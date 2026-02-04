<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class PostService
{
    /**
     * @return Collection<int, Post>
     */
    public function listForUser(int $userId): Collection
    {
        return Post::query()
            ->where('user_id', $userId)
            ->with('category')
            ->latest()
            ->get();
    }

    public function listPublishedPaginated(int $perPage = 6): LengthAwarePaginator
    {
        return Post::query()
            ->whereNotNull('published_at')
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function loadForShow(Post $post): Post
    {
        return $post->loadMissing(['author', 'category']);
    }

    public function createForUser(array $data, int $userId): Post
    {
        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $data['user_id'] = $userId;
        $data['slug'] = $this->makeUniqueSlug($data['title']);

        return Post::create($data);
    }

    public function update(Post $post, array $data): Post
    {
        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $data['slug'] = $this->makeUniqueSlug($data['title'], $post->id);

        $post->update($data);

        return $post;
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }

    public function ensureOwner(Post $post, int $userId): void
    {
        if ($post->user_id !== $userId) {
            abort(403);
        }
    }

    private function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (
            Post::query()
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
