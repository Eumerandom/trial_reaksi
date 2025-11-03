<?php

namespace App\Services;

use App\Exceptions\ShareholdingProviderException;
use App\Models\Company;
use App\Models\CompanyShareholding;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CompanyShareholdingService
{
    private const ENDPOINT = '/stock/get-major-holders';

    public function getShareholding(
        string $symbol,
        ?int $limit = null,
        ?string $region = null,
        ?string $lang = null,
        bool $forceRefresh = false
    ): array {
        $symbol = strtoupper(trim($symbol));
        $region = $region ?? (string) config('services.yahoo_finance.region', 'US');
        $lang = $lang ?? (string) config('services.yahoo_finance.lang', 'en-US');

        $company = Company::query()->where('symbol', $symbol)->first();
        $record = null;
        $source = 'database';

        if (! $forceRefresh) {
            $record = CompanyShareholding::query()
                ->where('symbol', $symbol)
                ->latest('fetched_at')
                ->first();
        }

        if (! $record) {
            if (! $company) {
                throw new RuntimeException(
                    "Perusahaan dengan simbol {$symbol} tidak ditemukan.",
                    Response::HTTP_NOT_FOUND
                );
            }

            $record = $this->fetchAndStore($company, $region, $lang);
            $source = 'rapidapi';
        }

        $payload = $record->payload;
        if ($limit !== null) {
            $payload = $this->applyLimit($payload, $limit);
        }

        Log::info('shareholdings.fetch', [
            'symbol' => $symbol,
            'region' => $region,
            'lang' => $lang,
            'limit' => $limit,
            'source' => $source,
            'cache_store' => $record->getAttribute('cache_store') ?? null,
            'cache_key' => $record->getAttribute('cache_key') ?? null,
            'fetched_at' => $record->fetched_at,
        ]);

        return ['payload' => $payload, 'source' => $source, 'record' => $record];
    }

    public function fetchAndStore(Company $company, ?string $region = null, ?string $lang = null): CompanyShareholding
    {
        $symbol = strtoupper((string) $company->symbol);
        if ($symbol === '') {
            throw new RuntimeException('Perusahaan tidak memiliki simbol saham.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $region = $region ?? (string) config('services.yahoo_finance.region', 'US');
        $lang = $lang ?? (string) config('services.yahoo_finance.lang', 'en-US');

        [$payload, $meta] = $this->requestShareholding($symbol, $region, $lang);

        return $company->shareholdings()->create([
            'symbol' => $symbol,
            'payload' => $payload,
            'source' => 'yahoo_finance',
            'fetched_at' => now(),
            'cache_store' => $meta['cache_store'] ?? null,
            'cache_key' => $meta['cache_key'] ?? null,
        ]);
    }

    /**
     * @return array{0: array, 1: array}
     */
    private function requestShareholding(string $symbol, string $region, string $lang): array
    {
        $apiKey = (string) config('services.yahoo_finance.api_key');
        if ($apiKey === '') {
            throw new RuntimeException('Yahoo Finance API key belum dikonfigurasi.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $host = (string) config('services.yahoo_finance.host', 'yahoo-finance-real-time1.p.rapidapi.com');
        $url = sprintf('https://%s%s', $host, self::ENDPOINT);
        $query = [
            'symbol' => $symbol,
            'region' => $region,
            'lang' => $lang,
        ];

        [$cache, $store] = $this->resolveCacheRepository();
        $cacheKey = $this->cacheKey($symbol, $region, $lang);

        if ($payload = $cache->get($cacheKey)) {
            return [$payload, ['cache_store' => $store, 'cache_key' => $cacheKey]];
        }

        try {
            $response = Http::withHeaders([
                'x-rapidapi-host' => $host,
                'x-rapidapi-key' => $apiKey,
            ])
                ->timeout($this->resolveTimeout())
                ->acceptJson()
                ->get($url, $query);
        } catch (ConnectionException $exception) {
            Log::warning('shareholdings.fetch_failed', [
                'symbol' => $symbol,
                'region' => $region,
                'lang' => $lang,
                'source' => 'rapidapi',
                'cache_store' => $store,
                'cache_key' => $cacheKey,
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        } catch (Throwable $exception) {
            Log::error('shareholdings.fetch_exception', [
                'symbol' => $symbol,
                'region' => $region,
                'lang' => $lang,
                'source' => 'rapidapi',
                'cache_store' => $store,
                'cache_key' => $cacheKey,
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }

        if ($response->failed()) {
            $errorBody = $this->formatErrorBody($response);

            Log::warning('shareholdings.fetch_failed', [
                'symbol' => $symbol,
                'region' => $region,
                'lang' => $lang,
                'source' => 'rapidapi',
                'cache_store' => $store,
                'cache_key' => $cacheKey,
                'status' => $response->status(),
                'error' => $errorBody,
            ]);

            $this->handleFailedResponse($response, $errorBody);
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            Log::warning('shareholdings.fetch_unexpected_payload', [
                'symbol' => $symbol,
                'region' => $region,
                'lang' => $lang,
                'source' => 'rapidapi',
                'cache_store' => $store,
                'cache_key' => $cacheKey,
                'type' => get_debug_type($payload),
            ]);

            throw new RuntimeException('Respon dari Yahoo Finance tidak sesuai harapan.', Response::HTTP_BAD_GATEWAY);
        }

        $cache->put($cacheKey, $payload, $this->cacheTtl());

        return [$payload, ['cache_store' => $store, 'cache_key' => $cacheKey]];
    }

    private function resolveTimeout(): float
    {
        $timeout = (float) config('services.yahoo_finance.timeout', 10);

        return $timeout > 0 ? $timeout : 10.0;
    }

    /**
     * @return array{0: \Illuminate\Contracts\Cache\Repository, 1: string}
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
                Log::error('shareholdings.cache_store_unavailable', [
                    'preferred' => $preferred,
                    'fallback' => $fallback,
                    'error' => $fallbackException->getMessage(),
                ]);

                return [Cache::store('array'), 'array'];
            }
        }
    }

    private function cacheStore(): string
    {
        $store = (string) config('services.yahoo_finance.cache_store', '');

        return $store !== '' ? $store : config('cache.default');
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

    private function cacheTtl(): int
    {
        $ttl = (int) config('services.yahoo_finance.cache_ttl', 900);

        return $ttl > 0 ? $ttl : 900;
    }

    private function fallbackCacheStore(string $preferred, Throwable $exception): string
    {
        $fallback = config('cache.default', 'array');

        if ($fallback === $preferred) {
            $fallback = 'array';
        }

        Log::warning('shareholdings.cache_store_fallback', [
            'preferred' => $preferred,
            'fallback' => $fallback,
            'error' => $exception->getMessage(),
        ]);

        return $fallback;
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

    private function handleFailedResponse(ClientResponse $response, ?array $errorBody): never
    {
        $status = $this->resolveStatusCode($response->status());

        throw new ShareholdingProviderException(
            'Gagal mengambil data shareholding dari Yahoo Finance.',
            $status,
            $errorBody
        );
    }

    private function resolveStatusCode(int $code): int
    {
        return ($code >= Response::HTTP_BAD_REQUEST && $code <= Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED)
            ? $code
            : Response::HTTP_BAD_GATEWAY;
    }

    private function applyLimit(array $payload, int $limit): array
    {
        array_walk($payload, function (&$value) use ($limit) {
            if (! is_array($value)) {
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
