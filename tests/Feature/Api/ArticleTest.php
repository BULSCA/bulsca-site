<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_pinned_articles_are_separate_from_eight_per_page_ordered_results(): void
    {
        $pinned = Article::factory()->create(['pinned' => true]);
        $articles = Article::factory()->count(10)->create(['created_at' => '2026-01-01 12:00:00']);
        $response = $this->getJson('/api/v1/articles')->assertOk()
            ->assertJsonCount(1, 'data.pinned')->assertJsonCount(8, 'data.articles')
            ->assertJsonPath('data.pinned.0.id', $pinned->id)
            ->assertJsonPath('data.articles.0.id', $articles->last()->id)
            ->assertJsonPath('meta.total', 10)->assertJsonPath('meta.last_page', 2);
        $this->assertNotContains($pinned->id, array_column($response->json('data.articles'), 'id'));
        $this->assertArrayNotHasKey('content', $response->json('data.articles.0'));
        $this->getJson('/api/v1/articles?page=2')->assertOk()->assertJsonCount(2, 'data.articles');
    }

    public function test_tag_filters_apply_to_pinned_and_regular_articles(): void
    {
        $tag = Tag::factory()->create();
        $article = Article::factory()->create();
        $article->tags()->attach($tag);
        Article::factory()->create(['pinned' => true]);
        $this->getJson('/api/v1/articles?tag='.$tag->slug)->assertOk()
            ->assertJsonCount(0, 'data.pinned')->assertJsonCount(1, 'data.articles')
            ->assertJsonPath('data.articles.0.tags.0.slug', $tag->slug);
        $this->getJson('/api/v1/articles?tag=missing')->assertNotFound()->assertJsonPath('code', 'not_found');
    }

    public function test_old_title_slugs_return_safe_detail_without_changing_counters(): void
    {
        $author = User::factory()->create(['name' => 'Alex']);
        $article = Article::factory()->create(['title' => 'New title', 'author' => $author->id,
            'content' => '<p>Safe</p><script>bad()</script>', 'views' => 10]);
        $before = $article->getAttributes();
        $this->getJson('/api/v1/articles/old-title.'.$article->id)->assertOk()
            ->assertJsonPath('data.slug', $article->getSlug())->assertJsonPath('data.author', 'Alex')
            ->assertJsonPath('data.content', '<p>Safe</p>');
        $this->assertSame($before, $article->fresh()->getAttributes());
    }

    public function test_missing_empty_and_invalid_requests_are_explicit(): void
    {
        $this->getJson('/api/v1/articles')->assertOk()->assertJsonCount(0, 'data.articles');
        $this->getJson('/api/v1/articles/unknown')->assertNotFound();
        $this->getJson('/api/v1/articles/999999')->assertNotFound();
        $this->getJson('/api/v1/articles?page=0')->assertUnprocessable()->assertJsonValidationErrors('page');
    }
}
