<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryManageController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index()
    {
        $categories = $this->categoryService->listWithPostCount();

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateCategory($request);
        $this->categoryService->create($data);

        return redirect()
            ->route('dashboard.categories.index')
            ->with('status', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateCategory($request);
        $this->categoryService->update($category, $data);

        return redirect()
            ->route('dashboard.categories.index')
            ->with('status', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if (! $this->categoryService->delete($category)) {
            return redirect()
                ->route('dashboard.categories.index')
                ->with('status', 'Cannot delete a category with assigned posts.');
        }

        return redirect()
            ->route('dashboard.categories.index')
            ->with('status', 'Category deleted.');
    }

    private function validateCategory(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
    }
}
