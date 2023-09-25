<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function testStore(): void
    {
        $data = ['title' => 'Test', 'body' => 'Test body'];
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('test')
            ]
        );
        $response = $this->actingAs($user)->post('/api/posts', $data);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure(["data" => ["id", "title", "body", "user"]]);
    }

    public function testStoreValidation(): void
    {
        $data = ['title' => 'Test', 'body' => 'tt'];
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('test')
            ]
        );
        $response = $this->actingAs($user)->post('/api/posts', $data);
        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function testUpdate(): void
    {
        $data = ['title' => 'Test', 'body' => 'Test body'];
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('test')
            ]
        );
        $response = $this->actingAs($user)->put('/api/posts/'.Post::first()->id, $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(["data" => ["id", "title", "body", "user"]]);
    }

    public function testUpdateValidation(): void
    {
        $data = ['title' => 'Te', 'body' => 'tt'];
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('test')
            ]
        );
        $response = $this->actingAs($user)->put('/api/posts/'.Post::first()->id, $data);
        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function testIndex(): void
    {
        $response = $this->get('/api/posts');
        $response->assertJsonStructure(["data" => [["id", "title", "body", "user"]]]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDelete(): void
    {
        $response = $this->delete('/api/posts/'.Post::first()->id);
        $response->assertJson(["success" => true]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testDeleteValidation(): void
    {
        $response = $this->delete('/api/posts/');
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
