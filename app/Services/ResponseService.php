<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ResponseService extends Service
{
    /**
     * Базовый ответ
     *
     * @param bool $success
     * @param string $msg
     * @param array $data
     * @param array $errorsForm
     * @param int $code
     * @return JsonResponse
     */
    public function baseResponse(
        bool   $success = true,
        string $msg = '',
        array  $data = [],
        array  $errorsForm = [],
        int    $code = 200
    ): JsonResponse
    {
        return response()->json(
            [
                'data' => $data,
                'success' => $success,
                'errorsForm' => $errorsForm,
                'msg' => $msg,
            ],
            $code
        );
    }

    public function sendError($msg = ''): JsonResponse
    {
        return $this->baseResponse(false, $msg, [], [], 400);
    }

    public function sendResponseWithErrors($errors, $msg = ''): JsonResponse
    {
        return $this->baseResponse(false, $msg, [], $errors, 400);
    }
}
