<?php

namespace App\Http\Controllers {

    use App\Http\Requests\Settings\UpdateSettingsRequest;
    use App\Models\Setting;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Inertia\Response;

    class SettingsController extends Controller
    {
        public function index(): Response
        {
            abort_if(user()->cannot('manage_settings'), 403);

            return inertia('settings/index', [
                'settings' => $this->settings,
            ]);
        }

        public function update(UpdateSettingsRequest $request): RedirectResponse
        {
            abort_if(user()->cannot('update_settings'), 403);
            $this->settings->update($request->validated());

            return back();
        }

        public function updateImage(Request $request, Setting $setting): RedirectResponse
        {
            $request->validate([
                'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:8196'],
            ]);

            $setting->updateImage('app', 'logo', 'logo', 'logo');

            return back();
        }

        public function deleteImage(Setting $setting): RedirectResponse
        {
            $setting->deleteImage('app');

            return back();
        }
    }
}
