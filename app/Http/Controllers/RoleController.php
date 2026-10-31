<?php

namespace App\Http\Controllers {

    use Spatie\Permission\Models\Role as BaseRole;
    use App\Http\Requests\Roles\StoreRoleRequest;
    use Spatie\Permission\Models\Permission;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Inertia\Response;
    use App\Models\Role;

    class RoleController extends Controller
    {
        public function index(): Response
        {
            abort_if(user()->cannot('manage_roles'), 403);

            $permissions = Permission::whereNot('name', '*')->whereNot('name', 'view_dashboard')->get();
            $roles = Role::with('permissions')->whereNot('name', 'admin')->get();

            return inertia('roles/index', compact('permissions', 'roles'));
        }

        public function store(StoreRoleRequest $request): RedirectResponse
        {
            $role = BaseRole::create($request->validated());
            $role->givePermissionTo(
                Role::findByName(env('APP_DEFAULT_ROLE'))->getPermissionNames()
            );

            return back();
        }

        public function destroy(Role $role): RedirectResponse
        {
            abort_if(user()->cannot('delete_role'), 403);

            $role->delete();
            return back();
        }

        public function addPermission(Request $request, Role $role): RedirectResponse
        {
            abort_if(user()->cannot('add_permission_to_role'), 403);

            if (!$role->hasPermissionTo($request->permission['name'])) {
                $role->givePermissionTo($request->permission['name']);
            } else {
                $role->revokePermissionTo($request->permission['name']);
            }
            return back();
        }
    }
}
