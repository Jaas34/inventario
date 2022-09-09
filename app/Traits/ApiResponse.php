<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Trait ApiResponse
 * @package App\Traits
 */
trait ApiResponse {

    /**
     * @param $request
     * @param null $rules
     * @return void
     */
    protected function validateRequest($request, $rules = null)
    {
        $validator = Validator::make($request, $rules);

        if ($validator->fails())
            throw new HttpResponseException(
                $this->errorResponse(
                    'No se pudo realizar la acción', ['errors' => $validator->errors()->toArray()], JsonResponse::HTTP_BAD_REQUEST)
            );
    }

    /**
     * @param $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function successResponse($message, $data = [], $status = JsonResponse::HTTP_OK)
    {
        $body = ['success' => true, 'message' => $message] + $data;
        return response()->json($body, $status, [],JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param null $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function errorResponse($message = null, $data = [], $status = JsonResponse::HTTP_BAD_REQUEST)
    {
        $body = ['success' => false, 'message' => $message] + $data;
        return response()->json($body, $status, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
