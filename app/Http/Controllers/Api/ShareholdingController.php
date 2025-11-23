<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ShareholdingProviderException;
use App\Http\Controllers\Controller;
use App\Services\CompanyShareholdingService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ShareholdingController extends Controller
{
    public function __construct(
        private readonly CompanyShareholdingService $shareholdingService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'symbol' => ['required', 'string'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'refresh' => ['nullable', 'boolean'],
        ]);

        $region = $request->query('region');
        $lang = $request->query('lang');
        $forceRefresh = (bool) ($validated['refresh'] ?? false);

        try {
            $result = $this->shareholdingService->getShareholding(
                $validated['symbol'],
                $validated['limit'] ?? null,
                $region,
                $lang,
                $forceRefresh
            );

            return response()->json($result['payload']);
        } catch (ShareholdingProviderException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'error' => $exception->error,
            ], $exception->status);
        } catch (ConnectionException $exception) {
            return response()->json([
                'message' => 'Unable to reach Yahoo Finance API.',
                'error' => $exception->getMessage(),
            ], Response::HTTP_BAD_GATEWAY);
        } catch (RuntimeException $exception) {
            $status = $exception->getCode() >= Response::HTTP_BAD_REQUEST
                ? $exception->getCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            return response()->json([
                'message' => $exception->getMessage(),
            ], $status);
        } catch (Throwable $exception) {
            report($exception);
            Log::error('shareholdings.unhandled_exception', [
                'symbol' => $validated['symbol'],
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'Unexpected error while fetching shareholding data.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
