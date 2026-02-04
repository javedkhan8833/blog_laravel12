<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * @return Collection<int, Category>
     */
    public function listWithPostCount(): Collection
    {
        return Category::withCount('posts')
            ->orderBy('name')
            ->get();
    }

    /**
     * @return Collection<int, Category>
     */
    public function listForSelect(): Collection
    {
        return Category::orderBy('name')->get();
    }

    public function create(array $data): Category
    {
        $data['slug'] = $this->makeUniqueSlug($data['name']);

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $data['slug'] = $this->makeUniqueSlug($data['name'], $category->id);

        $category->update($data);

        return $category;
    }

    public function delete(Category $category): bool
    {
        if ($category->posts()->exists()) {
            return false;
        }

        $category->delete();

        return true;
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
