<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request as HttpRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ShareholdingEndpointTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('cache.default', 'array');
        Cache::flush();

        Log::spy();

        config()->set('services.yahoo_finance.api_key', null);
        config()->set('services.yahoo_finance.host', 'yahoo-finance-real-time1.p.rapidapi.com');
        config()->set('services.yahoo_finance.region', 'US');
        config()->set('services.yahoo_finance.lang', 'en-US');
        config()->set('services.yahoo_finance.cache_store', null);
        config()->set('services.yahoo_finance.cache_ttl', 600);
    }

    public function test_symbol_query_parameter_is_required(): void
    {
        $response = $this->getJson('/api/shareholdings');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['symbol']);
    }

    public function test_shareholding_data_is_returned_from_service(): void
    {
        config()->set('services.yahoo_finance.api_key', 'test-key');
        config()->set('services.yahoo_finance.host', 'example-rapidapi-host.test');
        config()->set('services.yahoo_finance.region', 'US');
        config()->set('services.yahoo_finance.lang', 'en-US');

        $payload = [
            'majorHoldersBreakdown' => [
                'insidersPercentHeld' => 0.01,
            ],
            'institutionOwnership' => [
                'ownershipList' => [
                    ['organization' => 'Example Fund'],
                    ['organization' => 'Another Fund'],
                ],
            ],
            'symbol' => 'AAPL',
        ];

        Http::fake([
            'https://example-rapidapi-host.test/stock/get-major-holders*' => Http::response($payload, 200),
        ]);

        $response = $this->getJson('/api/shareholdings?symbol=AAPL&limit=1');

        $response->assertOk()->assertExactJson([
            'majorHoldersBreakdown' => [
                'insidersPercentHeld' => 0.01,
            ],
            'institutionOwnership' => [
                'ownershipList' => [
                    ['organization' => 'Example Fund'],
                ],
            ],
            'symbol' => 'AAPL',
        ]);

        Http::assertSent(function (HttpRequest $request) {
            $queryString = parse_url($request->url(), PHP_URL_QUERY) ?? '';
            parse_str($queryString, $query);

            return str_starts_with($request->url(), 'https://example-rapidapi-host.test/stock/get-major-holders')
                && ($query['symbol'] ?? null) === 'AAPL'
                && ($query['region'] ?? null) === 'US'
                && ($query['lang'] ?? null) === 'en-US'
                && $request->header('x-rapidapi-key') === ['test-key']
                && $request->header('x-rapidapi-host') === ['example-rapidapi-host.test'];
        });

        $this->assertTrue(Cache::has('shareholdings:AAPL:US:en-us'));

        Log::shouldHaveLogged('info', function ($message, array $context) {
            return $context['source'] ?? null === 'rapidapi'
                && ($context['symbol'] ?? null) === 'AAPL';
        });
    }

    public function test_shareholding_data_is_cached_for_subsequent_requests(): void
    {
        config()->set('services.yahoo_finance.api_key', 'test-key');
        config()->set('services.yahoo_finance.host', 'example-rapidapi-host.test');
        config()->set('services.yahoo_finance.region', 'US');
        config()->set('services.yahoo_finance.lang', 'en-US');

        $payload = [
            'institutionOwnership' => [
                'ownershipList' => [
                    ['organization' => 'Example Fund'],
                ],
            ],
            'symbol' => 'AAPL',
        ];

        Http::fake([
            'https://example-rapidapi-host.test/stock/get-major-holders*' => Http::response($payload, 200),
        ]);

        $first = $this->getJson('/api/shareholdings?symbol=AAPL');
        $first->assertOk()->assertExactJson($payload);

        Http::assertSentCount(1);

        Log::shouldHaveLogged('info', function ($message, array $context) {
            return $context['source'] ?? null === 'rapidapi'
                && ($context['symbol'] ?? null) === 'AAPL';
        });
        Log::shouldHaveLogged('info', function ($message, array $context) {
            return $context['source'] ?? null === 'cache'
                && ($context['symbol'] ?? null) === 'AAPL';
        });

        $second = $this->getJson('/api/shareholdings?symbol=AAPL');
        $second->assertOk()->assertExactJson($payload);

        Http::assertSentCount(1);
    }

    public function test_failed_request_returns_error_payload(): void
    {
        config()->set('services.yahoo_finance.api_key', 'test-key');
        config()->set('services.yahoo_finance.host', 'example-rapidapi-host.test');

        Http::fake([
            'https://example-rapidapi-host.test/stock/get-major-holders*' => Http::response(['error' => 'bad request'], 400),
        ]);

        $response = $this->getJson('/api/shareholdings?symbol=AAPL');

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Failed to fetch shareholding data from Yahoo Finance.',
                'error' => ['error' => 'bad request'],
            ]);

        $this->assertFalse(Cache::has('shareholdings:AAPL:US:en-us'));

        Log::shouldHaveLogged('warning', function ($message, array $context) {
            return $context['source'] ?? null === 'rapidapi'
                && ($context['symbol'] ?? null) === 'AAPL';
        });
    }

    public function test_cache_store_falls_back_when_preferred_store_missing(): void
    {
        config()->set('services.yahoo_finance.api_key', 'test-key');
        config()->set('services.yahoo_finance.host', 'example-rapidapi-host.test');
        config()->set('services.yahoo_finance.cache_store', 'missing-store');

        $payload = [
            'symbol' => 'AAPL',
            'institutionOwnership' => [
                'ownershipList' => [],
            ],
        ];

        Http::fake([
            'https://example-rapidapi-host.test/stock/get-major-holders*' => Http::response($payload, 200),
        ]);

        $response = $this->getJson('/api/shareholdings?symbol=AAPL');
        $response->assertOk()->assertExactJson($payload);

        Log::shouldHaveLogged('warning', function ($message, array $context) {
            return $message === 'shareholdings.cache_store_fallback'
                && ($context['preferred'] ?? null) === 'missing-store'
                && ($context['fallback'] ?? null) === 'array';
        });

        Log::shouldHaveLogged('info', function ($message, array $context) {
            return ($context['cache_store'] ?? null) === 'array'
                && ($context['source'] ?? null) === 'rapidapi';
        });
    }

    public function test_missing_api_key_returns_server_error(): void
    {
        $response = $this->getJson('/api/shareholdings?symbol=AAPL');

        $response->assertStatus(500)
            ->assertJson([
                'message' => 'Yahoo Finance API key is not configured.',
            ]);
    }
}
