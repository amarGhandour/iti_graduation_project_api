<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminRolesController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $this->authorize('role_access');

        $roles = Role::with('permissions')->paginate();

        return $this->response(200, true, null, $roles);
    }

    public function show(Role $role)
    {
        $this->authorize('role_show');

        $role->load('permissions');

        return $this->response(200, true, null, RoleResource::make($role));
    }

    public function store(Request $request)
    {
        $this->authorize('role_create');

        $request->validate([
            'name' => ['required'],
            'permissions' => ['required', Rule::exists('permissions', 'id')]
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
            'guard_name' => 'api',
        ]);

        $role->syncPermissions($request->input('permissions'));

        return $this->response(201, true, null, RoleResource::make($role), 'New role successfully created.');
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('role_edit');

        if ($role->name == 'Super Admin' || $role->name == 'User')
            return $this->response(403, true, 'Forbidden', null, 'You cannot edit this role.');

        $request->validate([
            'name' => 'required',
            'permissions' => ['required', Rule::exists('permissions', 'id')]
        ]);


        $role->update([
            'name' => $request->input('name'),
        ]);

        $role->syncPermissions($request->input('permissions'));

        return $this->response(201, true, null, RoleResource::make($role), 'Role successfully updated.');
    }

    public function destroy(Role $role)
    {
        $this->authorize('role_delete');

        if ($role->name == 'Super Admin' || $role->name == 'User')
            return $this->response(403, true, 'Forbidden', null, 'You cannot delete this role.');

        $role->delete();

        return $this->response(204);
    }
}
