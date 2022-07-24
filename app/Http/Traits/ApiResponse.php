<?php

namespace App\Http\Traits;

trait ApiResponse
{
    public function response(int $status, bool $success = true, mixed $errors = null, mixed $data = null)
    {
        return response()->json([
            'data' => $data ?? [],
            'errors' => $errors ?? [],
            'success' => $success
        ], $status);
    }
}
