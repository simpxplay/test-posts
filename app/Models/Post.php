<?php

namespace App\Models;

use App\Traits\PostRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use PostRelations;

    protected $fillable = [
        'title',
        'body'
    ];
}
