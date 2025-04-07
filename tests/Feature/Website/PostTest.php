<?php

namespace Tests\Feature\Website;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function test_user_can_get_all_posts()
    {
        $posts = Post::factory(15)->create();

        $response = $this->getJson(route('posts.index'));
        $response->assertOk();
        $response->assertJsonCount(10, 'data');
        $response->assertExactJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'content',
                    'author',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links',
            'meta',
        ]);
    }

    public function test_user_can_create_post()
    {
        $post = [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->sentence(11),
        ];

        $response = $this->postJson(route('posts.store'), $post);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'post' => [
                'id',
                'title',
                'content',
                'author',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_user_can_show_one_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson(route('posts.show', $post->id));
        $response->assertOk();
        $response->assertJsonStructure([
            'post' => [
                'id',
                'title',
                'content',
                'author',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_user_can_update_post()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $postUpdate = [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->sentence(11),
        ];
        
        $response = $this->putJson(route('posts.update', $post->id), $postUpdate);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'post' => [
                'id',
                'title',
                'content',
                'author',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_user_can_delete_post()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson(route('posts.destroy', $post->id));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
        ]);
        $this->assertModelMissing($post);
    }
}
