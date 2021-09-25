<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ApiTrait;

class Category extends Model
{
    use HasFactory, ApiTrait;

    protected $fillable = ['name', 'slug'];

    protected $allowIncluded = ['posts', 'posts.user'];
    protected $allowFilter = ['id', 'name', 'slug'];
    protected $allowSort = ['id', 'name', 'slug'];

    // Relacion 1:n entre categorias y post
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
