<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller as Controller;

class BaseApiController extends Controller
{
    /**
     * success response method.
     *
     * @param array|string|bool|null $result
     * @return JsonResponse
     */
    public function sendResponse(array|string|bool|null $result = null): JsonResponse
    {
        $response = [
            'error' => null,
            'result' => $result,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param string $error
     * @param int $code
     * @return JsonResponse
     */
    public function sendError(string $error, int $code = 404): JsonResponse
    {
        $response = [
            'error' => $error,
            'result' => null,
        ];

        return response()->json($response, $code);
    }

    /**
     * return token response.
     *
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'token' => $token,
        ]);
    }

    /**
     * return unauthorized response.
     *
     * @return JsonResponse
     */
    protected function unauthorized(): JsonResponse
    {
        return $this->sendError('Unauthorized', 401);
    }

}
