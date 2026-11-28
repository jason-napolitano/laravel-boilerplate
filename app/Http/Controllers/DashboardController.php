<?php

namespace App\Http\Controllers {

    use Illuminate\Routing\Attributes\Controllers\Authorize;
    use Illuminate\Support;
    use Inertia\Response;
    use App\Models\User;
    use Carbon\Carbon;

    class DashboardController extends Controller
    {
        #[Authorize('view_dashboard')]
        public function __invoke(): Response
        {
            $registrations = yearly_data('created_at', User::class);
            $logins = yearly_data('last_login_at', User::class);

            return inertia('dashboard/index', compact('registrations', 'logins'));
        }
    }
}
