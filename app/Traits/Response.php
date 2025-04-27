<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Response
{
    /**
     * Generate a success response.
     *
     * @param  int  $code
     * @param  string  $message
     * @param  array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($code = 200, $message = 'success', $data = [])
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data], $code);
    }

    /**
     * Generate a successful JSON response with optional metadata.
     *
     * @param array $data 
     * @param array $metadata 
     * @param string $message
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function successResponseWithMetadata($data = [], $metadata = [], $message = 'success', $code = 200 )
    {
            return response()->json(['success' => true, 'message' => $message, 'metadata' => $metadata, 'data' => $data ], $code );
    }

    /**
     * Set success response
     *
     * @param $message
     * @param $collection
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function withCollection($code = 200, string $message = 'success', $data = []): JsonResponse
    {
        return response()->json(array_merge([
            'status' => true,
            'message' => $message,
        ], (array)$data), $code);
    }

    /**
     * Generate an error response.
     *
     * @param  int  $code
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($code = 400, $message = 'Something bad happened')
    {
        return response()->json(['success' => false, 'message' => $message], $code);
    }
}