<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Base controller providing a consistent JSON envelope for every mobile
 * API response: { success, message, data, meta }.
 */
abstract class ApiController extends Controller
{
    /**
     * Return a successful JSON response.
     */
    protected function ok(mixed $data = null, string $message = 'OK', array $meta = []): JsonResponse
    {
        return $this->respond(true, $message, $data, $meta, 200);
    }

    /**
     * Return a 201 Created JSON response.
     */
    protected function created(mixed $data = null, string $message = 'Created successfully'): JsonResponse
    {
        return $this->respond(true, $message, $data, [], 201);
    }

    /**
     * Return an error JSON response.
     */
    protected function error(string $message = 'Something went wrong', int $status = 400, array $errors = []): JsonResponse
    {
        $payload = [
            'success' => false,
            'message' => $message,
            'data' => null,
        ];

        if (! empty($errors)) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }

    /**
     * Return a paginated collection wrapped in the standard envelope.
     */
    protected function paginated(Paginator $paginator, ?string $resource = null, string $message = 'OK'): JsonResponse
    {
        $items = $paginator->items();

        if ($resource && class_exists($resource)) {
            $items = $resource::collection($items)->resolve();
        }

        return $this->respond(true, $message, $items, [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
        ]);
    }

    /**
     * Return a paginated resource collection (Laravel ResourceCollection).
     */
    protected function paginatedResource(ResourceCollection $collection, string $message = 'OK'): JsonResponse
    {
        $resource = $collection->resource;

        $items = $collection->resolve();

        $meta = [];
        if ($resource instanceof Paginator) {
            $meta = [
                'current_page' => $resource->currentPage(),
                'per_page' => $resource->perPage(),
                'total' => $resource->total(),
                'last_page' => $resource->lastPage(),
                'from' => $resource->firstItem(),
                'to' => $resource->lastItem(),
            ];
        }

        return $this->respond(true, $message, $items, $meta);
    }

    /**
     * Build the response envelope.
     */
    protected function respond(bool $success, string $message, mixed $data, array $meta = [], int $status = 200): JsonResponse
    {
        $payload = [
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ];

        if (! empty($meta)) {
            $payload['meta'] = $meta;
        }

        return response()->json($payload, $status);
    }
}
