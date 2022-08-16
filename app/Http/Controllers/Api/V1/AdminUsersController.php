<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AdminUsersController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $this->authorize('user_access');

        $users = User::paginate(10);

        return UserCollection::make($users);
    }

    public function show(User $user)
    {
        $this->authorize('user_show');

        $user->load('roles');

        return $this->response(200, true, null, UserResource::make($user));
    }


    public function store(UserStoreRequest $request)
    {
        $this->authorize('user_create');

        $user = User::create($request->only(['name', 'email']) + [
                'password' => \Hash::make($request->input('password')),
                'email_verified_at' => now()
            ]);

        $user->syncRoles($request->input('roles'));

        return $this->response(Response::HTTP_CREATED, true, null, $user, 'User successfully created.');
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('user_edit');

        $request->validate([
            'roles' => ['required', Rule::exists('roles', 'name')]
        ]);

        $user->syncRoles($request->input('roles'));

        return $this->response(Response::HTTP_CREATED, true, null, $user, 'User successfully updated.');
    }
}
