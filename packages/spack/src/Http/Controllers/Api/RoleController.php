<?php

namespace Spack\Http\Controllers\Api;

use AhsanDev\Support\Field;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Cache;

class RoleController implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return ['can:setting'];
    }

    /**
     * Display a listing of the Role.
     */
    public function index()
    {
        return Role::withCount('permissions')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Role $role)
    {
        return $this->fields($role);
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2|unique:roles,name',
            'permissions' => 'nullable',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        $role->permissions()->sync($request->permissions);
        $role->loadCount('permissions');

        Cache::flush();

        return [
            'message' => 'Role created successfully',
            'model' => $role,
        ];
    }

    /**
     * Display the specified role.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        return $this->fields($role);
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2|unique:roles,name,'.$role->id,
            'permissions' => 'nullable',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        $role->permissions()->sync($request->permissions);
        $role->loadCount('permissions');

        Cache::flush();

        return [
            'message' => 'Role updated successfully',
            'model' => $role,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        foreach ($request->items as $item) {
            $hasUsers = Role::has('users')->find($item);

            if (! $hasUsers) {
                $items[] = $item;
            } else {
                throw new \Exception('Please first delete users related to this role!', 1);
            }
        }

        Role::destroy($request->items);

        return [
            'message' => count($request->items) > 1
                ? 'Roles Deleted Successfully!'
                : 'Role Deleted Successfully!',
        ];
    }

    protected function fields($model)
    {
        return Field::make()
            ->field('name', $model->name)
            ->field('permissions', $model->permissions->pluck('id'), Permission::options());
    }
}
