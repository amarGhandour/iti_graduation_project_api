<?php

namespace App\Http\Traits;

trait ApiResponse
{
    public function response(int $status, bool $success = true, mixed $errors = null, mixed $data = null, string $message = 'success')
    {
        return response()->json([
            'data' => $data ?? [],
            'errors' => $errors ?? [],
            'success' => $success,
            'message' => $message,
        ], $status);
    }
}
