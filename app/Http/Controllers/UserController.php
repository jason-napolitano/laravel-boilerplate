<?php

namespace App\Http\Controllers {

    use Illuminate\Support\Facades\Gate;
    use Illuminate\Http\Request;
    use App\Http\Requests;
    use Inertia\Response;
    use Illuminate\Http;
    use App\Models;

    class UserController extends Controller
    {
        public function index(): Response
        {
            Gate::authorize('viewAny', user());

            $bannedUsers = Models\User::with('roles')->isBanned()->paginate($this->settings->items_per_page);
            $users = Models\User::with('roles')->isNotBanned()->paginate($this->settings->items_per_page);
            $roles = Models\Role::whereNot('name', 'admin')->get();

            return inertia('users/index', compact('users', 'bannedUsers', 'roles'));
        }

        public function show(Models\User $user): Response
        {
            Gate::authorize('view', $user);

            $permissions = Models\Permission::whereNot('name', 'view_dashboard')->get()->load('roles');
            $passkeys = $user->passkeys()->get(['id', 'name', 'created_at', 'last_used_at',]);

            return inertia('users/show', compact('user', 'permissions', 'passkeys'));
        }

        public function store(Requests\Users\CreateUserRequest $request): Http\RedirectResponse
        {
            $user = Models\User::create($request->validated());
            $user->assignRole($request['role_id']);

            return back();
        }

        public function update(Requests\Users\UpdateUserRequest $request, Models\User $user): Http\RedirectResponse
        {
            $user->update($request->validated());

            return to_route('users.show', $user);
        }

        public function destroy(Models\User $user): Http\RedirectResponse
        {
            Gate::authorize('delete', $user);

            if ($user->is(user())) {
                logout_action(static fn () => $user->delete());
                return to_route('login');
            }

            if (!$user->hasRole('admin')) {
                $user->delete();
            }

            return back();
        }

        public function updateImage(Requests\Users\UpdateImageRequest $request, Models\User $user): Http\RedirectResponse
        {
            $request->validated();

            $user->updateImage(directory: 'avatars', column: 'avatar');

            return back();
        }

        public function destroyImage(Models\User $user): Http\RedirectResponse
        {
            Gate::authorize('deleteImage', $user);

            $user->deleteImage(column: 'avatar');

            return back();
        }

        public function toggleBan(Models\User $user): Http\RedirectResponse
        {
            Gate::authorize('banUser', $user);

            $user->toggleBan();

            return back();
        }

        public function updateRole(Request $request, Models\User $user): Http\RedirectResponse
        {
            Gate::authorize('updateRole', $user);

            $user->syncRoles($request['role']['name']);

            return back();
        }
    }
}
