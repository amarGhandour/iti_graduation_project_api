<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'string', 'max:20', 'min:8'],
            'token' => ['required', 'string']
        ]);

        $resetStatus = Password::reset($attributes, function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        if ($resetStatus == Password::INVALID_TOKEN) {
            return $this->response(400, false, ['token' => 'invalid token'], null, 'invalid token');
        }

        return $this->response(201, true, null, null, 'Password successfully changed.');
    }
}
