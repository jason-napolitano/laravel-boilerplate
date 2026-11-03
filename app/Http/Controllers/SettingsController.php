<?php

namespace App\Http\Controllers {

    use App\Http\Requests\Settings\UpdateSettingsRequest;
    use App\Http\Requests\Settings\UpdateSiteLogoRequest;
    use Illuminate\Http\RedirectResponse;
    use App\Models\Setting;
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

        public function updateImage(UpdateSiteLogoRequest $request, Setting $setting): RedirectResponse
        {
            $request->validated();

            $setting->updateImage('app', 'logo', 'logo', 'logo');

            return back();
        }
    }
}
