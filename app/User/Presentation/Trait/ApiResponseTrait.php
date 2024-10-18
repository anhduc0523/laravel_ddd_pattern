<?php

namespace App\User\Presentation\Trait;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponseTrait
{
    public function successResponse($data, $message = null, $code = 200) : JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function errorResponse($message = null, $code = 400) : JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    public function paginateResponse($data, $code = 200) : JsonResponse
    {
        return response()->json([
            'data' => $data->items(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
        ], $code);
    }

    public function noContentResponse() : Response
    {
        return response()->noContent();
    }
}
