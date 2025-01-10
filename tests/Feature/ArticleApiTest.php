<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_articles()
    {
        Article::factory(10)->create();

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200)
                 ->assertJsonCount(10, 'data');
    }

    public function test_can_search_articles_by_keyword()
    {
        Article::factory()->create(['title' => 'Laravel News']);

        $response = $this->getJson('/api/articles?keyword=Laravel');

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Laravel News']);
    }
}
