<?php

namespace App\Http\Controllers {

    use Illuminate\Routing\Attributes\Controllers\Authorize;
    use App\Services\ModelPermissionService;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Validation\Rule;
    use Illuminate\Http\Request;
    use App\Models\User;

    class UserModelPermissionController extends Controller
    {
        #[Authorize('managePermissions', 'user')]
        public function update(Request $request, User $user, ModelPermissionService $service)
        {
            $validated = $request->validate([
                'model_type' => ['required', Rule::in(array_keys(config('model-permissions.models')))],
                'model_id'   => ['required'],
                'permission' => ['required', Rule::in(config('model-permissions.permissions'))],
                'granted'    => ['required', 'boolean'],
            ]);

            $modelClass = config("model-permissions.models.{$validated['model_type']}");

            /** @var Model $model */
            $model = $modelClass::query()->findOrFail($validated['model_id']);

            if ($validated['granted']) {
                $service->grant($user, $model, $validated['permission']);
            } else {
                $service->revoke($user, $model, $validated['permission']);
            }

            return back();
        }
    }
}
