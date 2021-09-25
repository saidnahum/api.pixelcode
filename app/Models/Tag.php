<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ApiTrait;

class Tag extends Model
{
    use HasFactory, ApiTrait;

    // Relacion n:n entre Tags y Posts
    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}
