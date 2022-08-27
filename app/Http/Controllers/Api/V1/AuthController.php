<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ImageTrait;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponse, ImageTrait;

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->only(['name', 'email']) + [
                'password' => \Hash::make($request->input('password')),
            ]);

        $user->assignRole('User');

        event(new Registered($user));

        return $this->response(Response::HTTP_CREATED, true, null, UserResource::make($user));
    }

    public function login(LoginRequest $request)
    {
        if (!\Auth::attempt($request->only(['email', 'password']))) {

            return $this->response(Response::HTTP_UNAUTHORIZED, false, ['invalid credentials'], null, 'Invalid email or password.');
        }

        $user = \Auth::user();
        $user->load('roles');

        $jwt = $user->createToken('access_token')->plainTextToken;

        $cookie = cookie('access_token', $jwt, 60 * 24);

        return response()->json(['data' => [
            'user' => UserResource::make($user),
            'accessToken' => $jwt
        ], 'errors' => [], 'success' => true])->withCookie($cookie);
    }

    public function logout()
    {
        $cookie = Cookie::forget('access_token');

        auth()->user()->tokens()->delete();

        return response()->json(['data' => [], 'errors' => [], 'success' => true])->withCookie($cookie);
    }

    public function updateInfo(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($request->user(), 'email')],
            'name' => ['required', 'string', 'min:5', 'max:20'],
            'avatar' => ['image']
        ]);

        $user = auth()->user();

//        $avatar = $this->updateImage($request, $user?->image, 'images' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR, null, 'avatar');


        $user->update($request->only(['name', 'email']));

        return $this->response(Response::HTTP_ACCEPTED, true, null, UserResource::make($user), 'Profile successfully updated.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required'],
            'password_confirm' => ['required', 'same:password']
        ]);

        $user = auth()->user();
        $user->update(['password' => Hash::make($request->input('password'))]);

        return $this->response(Response::HTTP_ACCEPTED, true, null, UserResource::make($user), 'Password successfully updated.');
    }
}
