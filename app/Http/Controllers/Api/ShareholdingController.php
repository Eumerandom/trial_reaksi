<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ShareholdingController extends Controller
{
    private const ENDPOINT = '/stock/get-major-holders';

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'symbol' => ['required', 'string'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $apiKey = (string) config('services.yahoo_finance.api_key');
        if ($apiKey === '') {
            return response()->json([
                'message' => 'Yahoo Finance API key is not configured.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $host = (string) config('services.yahoo_finance.host', 'yahoo-finance-real-time1.p.rapidapi.com');
        $url = sprintf('https://%s%s', $host, self::ENDPOINT);

        $query = [
            'symbol' => $validated['symbol'],
            'region' => $request->query('region', (string) config('services.yahoo_finance.region', 'US')),
            'lang' => $request->query('lang', (string) config('services.yahoo_finance.lang', 'en-US')),
        ];

        $cacheKey = $this->cacheKey($validated['symbol'], $query['region'], $query['lang']);
        [$cache, $store] = $this->resolveCacheRepository();

        $payload = $cache->get($cacheKey);
        $source = 'cache';

        if (!is_array($payload)) {
            try {
                $response = Http::withHeaders([
                    'x-rapidapi-host' => $host,
                    'x-rapidapi-key' => $apiKey,
                ])
                    ->timeout($this->resolveTimeout())
                    ->acceptJson()
                    ->get($url, $query);
            } catch (ConnectionException $exception) {
                return response()->json([
                    'message' => 'Unable to reach Yahoo Finance API.',
                    'error' => $exception->getMessage(),
                ], Response::HTTP_BAD_GATEWAY);
            } catch (Throwable $exception) {
                report($exception);

                return response()->json([
                    'message' => 'Unexpected error while fetching shareholding data.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($response->failed()) {
                $status = $this->resolveStatusCode($response->status());
                $errorBody = $this->formatErrorBody($response);

                return response()->json([
                    'message' => 'Failed to fetch shareholding data from Yahoo Finance.',
                    'error' => $errorBody,
                ], $status);
            }

            $payload = $response->json();

            if (!is_array($payload)) {
                return response()->json([
                    'message' => 'Unexpected response while fetching shareholding data.',
                ], Response::HTTP_BAD_GATEWAY);
            }

            $cache->put($cacheKey, $payload, $this->cacheTtl());
            $source = 'rapidapi';
        }

        if (($validated['limit'] ?? null) !== null) {
            $payload = $this->applyLimit($payload, (int) $validated['limit']);
        }

        return response()->json($payload);
    }

    private function resolveStatusCode(int $code): int
    {
        return ($code >= Response::HTTP_BAD_REQUEST && $code <= Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED)
            ? $code
            : Response::HTTP_BAD_GATEWAY;
    }

    private function resolveTimeout(): float
    {
        $timeout = (float) config('services.yahoo_finance.timeout', 10);

        return $timeout > 0 ? $timeout : 10.0;
    }

    private function cacheKey(string $symbol, string $region, string $lang): string
    {
        return sprintf(
            'shareholdings:%s:%s:%s',
            strtoupper(trim($symbol)),
            strtoupper(trim($region)),
            strtolower(trim($lang)),
        );
    }

    private function cacheStore(): string
    {
        $store = (string) config('services.yahoo_finance.cache_store', '');

        return $store !== '' ? $store : config('cache.default');
    }

    /**
     * Resolve a cache repository for shareholding data with fallback support.
     */
    private function resolveCacheRepository(): array
    {
        $preferred = $this->cacheStore();

        try {
            return [Cache::store($preferred), $preferred];
        } catch (Throwable $exception) {
            $fallback = $this->fallbackCacheStore($preferred, $exception);

            try {
                return [Cache::store($fallback), $fallback];
            } catch (Throwable $fallbackException) {
                return [Cache::store('array'), 'array'];
            }
        }
    }

    private function fallbackCacheStore(string $preferred, Throwable $exception): string
    {
        $fallback = config('cache.default', 'array');

        if ($fallback === $preferred) {
            $fallback = 'array';
        }

        return $fallback;
    }

    private function cacheTtl(): int
    {
        $ttl = (int) config('services.yahoo_finance.cache_ttl', 900);

        return $ttl > 0 ? $ttl : 900;
    }

    private function formatErrorBody(ClientResponse $response): ?array
    {
        $payload = $response->json();

        if (is_array($payload)) {
            return $payload;
        }

        $body = trim($response->body() ?? '');

        return $body === '' ? null : ['body' => $body];
    }

    private function applyLimit(array $payload, int $limit): array
    {
        array_walk($payload, function (&$value) use ($limit) {
            if (!is_array($value)) {
                return;
            }

            if (Arr::isList($value)) {
                $value = array_slice($value, 0, $limit);

                return;
            }

            foreach ($value as &$nested) {
                if (is_array($nested) && Arr::isList($nested)) {
                    $nested = array_slice($nested, 0, $limit);
                }
            }
        });

        return $payload;
    }
}
