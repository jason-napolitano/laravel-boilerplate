<?php

namespace App\Http\Controllers {

    use Illuminate\Routing\Attributes\Controllers\Authorize;
    use App\Http\Requests\Settings as SettingsRequests;
    use Illuminate\Http\RedirectResponse;
    use App\Models\Setting;
    use Inertia\Response;

    class SettingsController extends Controller
    {
        #[Authorize('manage_settings', Setting::class)]
        public function index(): Response
        {
            return inertia('settings/index', [
                'settings' => $this->settings,
            ]);
        }

        #[Authorize('update_settings', Setting::class)]
        public function update(SettingsRequests\UpdateSettingsRequest $request): RedirectResponse
        {
            $this->settings->update($request->validated());

            return back();
        }

        public function updateImage(SettingsRequests\UpdateSiteLogoRequest $request, Setting $setting): RedirectResponse
        {
            $request->validated();

            $setting->updateImage('app', 'logo', 'logo', 'logo');

            return back();
        }
    }
}
