<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'string', 'max:20', 'min:8'],
            'token' => ['required', 'string']
        ]);

        $resetStatus = Password::reset($attributes, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($resetStatus == Password::INVALID_TOKEN) {
            return response()->json(['message' => 'invalid token'], 400);
        }

        return response()->json(['message' => 'Password successfully changed.'], 400);
    }
}
