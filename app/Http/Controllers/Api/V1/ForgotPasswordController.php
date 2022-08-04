<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $attributes = $request->validate(['email' => ['required', 'email']]);

        Password::sendResetLink($attributes);

        return response()->json(['message' => 'Reset password link sent to your email.']);
    }

}
