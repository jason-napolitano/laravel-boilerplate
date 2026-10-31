<?php

namespace App\Http\Controllers {

    use Illuminate\Support;
    use Inertia\Response;
    use App\Models\User;
    use Carbon\Carbon;

    class DashboardController extends Controller
    {
        public function __invoke(): Response
        {
            abort_if(user()->cannot('view_dashboard'), 403);

            $registrations = $this->perYearData('created_at');
            $logins = $this->perYearData('last_login_at');

            return inertia('dashboard/index', compact('registrations', 'logins'));
        }

        private function perYearData(string $field): Support\Collection
        {
            $users = User::query()
                ->whereBetween($field, [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ])
                ->get([$field])
                ->groupBy(
                    fn ($user) => Carbon::parse($user->getRawOriginal($field))->format('n')
                );

            $collection = collect();

            for ($month = 1; $month <= 12; $month++) {
                $collection->push(
                    $users->get((string) $month, collect())->count()
                );
            }

            return $collection;
        }
    }
}
