<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryManageController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')
            ->orderBy('name')
            ->get();

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateCategory($request);
        $data['slug'] = $this->makeUniqueSlug($data['name']);

        Category::create($data);

        return redirect() ->route('dashboard.categories.index')->with('status', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateCategory($request);
        $data['slug'] = $this->makeUniqueSlug($data['name'], $category->id);

        $category->update($data);

        return redirect()
            ->route('dashboard.categories.index')
            ->with('status', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return redirect()
                ->route('dashboard.categories.index')
                ->with('status', 'Cannot delete a category with assigned posts.');
        }

        $category->delete();

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

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 2;

        while (
            Category::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
