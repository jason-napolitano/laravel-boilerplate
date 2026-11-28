<?php

namespace App\Http\Controllers {

    use App\Http\Controllers\Support\ManagesModelPermissions;
    use App\Models;
    use Illuminate\Routing\Attributes\Controllers\Authorize;
    use Inertia\Response;

    class CategoryController extends Controller
    {
        use ManagesModelPermissions;

        public function index(): Response
        {
            $categories = Models\Category::all();
            return inertia('categories/index', compact('categories'));
        }

        #[Authorize('read', 'category')]
        public function show(Models\Category $category): Response
        {
            return inertia('categories/show', $this->modelPermissionData($category));
        }
    }
}
