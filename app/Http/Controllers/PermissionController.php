<?php

namespace App\Http\Controllers {

    use App\Http\Requests\Permissions\StorePermissionRequest;
    use Illuminate\Http\RedirectResponse;
    use App\Models\Permission;

    class PermissionController extends Controller
    {
        public function store(StorePermissionRequest $request): RedirectResponse
        {
            Permission::create($request->validated());
            return back();
        }
    }
}
