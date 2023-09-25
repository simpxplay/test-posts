<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use \Illuminate\Contracts\Auth\Authenticatable;

class PostService
{
    //In more difficult method I recommend to use DTO and probably Transaction
    public function store(User|Authenticatable $user, array $data): Post
    {
        $post = new Post($data);
        $post->user()->associate($user);
        $post->save();
        return $post;
    }

    public function update(Post $post, array $data): Post
    {
        $post->fill($data);
        $post->save();
        return $post;
    }

    public function delete(Post $post){
        return $post->delete();
    }
}
