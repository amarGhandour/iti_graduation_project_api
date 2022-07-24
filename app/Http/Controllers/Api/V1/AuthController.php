<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Traits\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->only(['name', 'email']) + [
                'password' => \Hash::make($request->input('password')),
            ]);

        return $this->response(Response::HTTP_CREATED, true, null, $user);
    }

    public function login(LoginRequest $request)
    {

        if (!\Auth::attempt($request->only(['email', 'password']))) {

            return $this->response(Response::HTTP_UNAUTHORIZED, false, ['invalid credentials']);
        }

        $user = \Auth::user();

        $jwt = $user->createToken('token', ['admin'])->plainTextToken;


        $cookie = cookie('jwt', $jwt, 60 * 24);

        return response()->json(['data' => [], 'errors' => [], 'success' => true])->withCookie($cookie);
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response()->json(['data' => [], 'errors' => [], 'success' => true])->withCookie($cookie);
    }

    public function updateInfo(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['email', Rule::unique('users', 'email')->ignore($request->user(), 'email')],
            'name' => ['string'],
        ]);

        $user = auth()->user();
        $user->update($attributes);

        return $this->response(Response::HTTP_ACCEPTED, true, null, $user);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required'],
            'password_confirm' => ['required', 'same:password']
        ]);

        $user = auth()->user();
        $user->update(['password' => Hash::make($request->input('password'))]);

        return $this->response(Response::HTTP_ACCEPTED, true, null, $user);
    }
}
