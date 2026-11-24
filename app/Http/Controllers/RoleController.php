<?php

namespace App\Http\Controllers {

    use Illuminate\Routing\Attributes\Controllers\Authorize;
    use Spatie\Permission\Models\Role as BaseRole;
    use App\Http\Requests\Roles\StoreRoleRequest;
    use Spatie\Permission\Models\Permission;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Inertia\Response;
    use App\Models\Role;

    class RoleController extends Controller
    {
        #[Authorize('manage_roles', Role::class)]
        public function index(): Response
        {
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

        #[Authorize('delete_role', 'role')]
        public function destroy(Role $role): RedirectResponse
        {
            abort_if(user()->cannot('delete_role'), 403);

            $role->delete();
            return back();
        }

        #[Authorize('add_permission_to_role', 'role')]
        public function addPermission(Request $request, Role $role): RedirectResponse
        {
            if (!$role->hasPermissionTo($request->permission['name'])) {
                $role->givePermissionTo($request->permission['name']);
            } else {
                $role->revokePermissionTo($request->permission['name']);
            }
            return back();
        }
    }
}
