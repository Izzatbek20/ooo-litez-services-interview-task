<?php

namespace App\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    protected function success(array $data, ?string $message, int $code = Response::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function successWithPagination(?JsonResource $resource, ?string $message, int $code = Response::HTTP_OK)
    {
        $resource = $resource->response()->getData(true);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $resource['data'],
            'links' => $resource['links'] ?? null,
            'meta' => $resource['meta'] ?? null,
        ], $code);
    }

    protected function error(?string $message, ?array $errors, int $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
