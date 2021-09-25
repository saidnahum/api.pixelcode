<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ApiTrait;

class Post extends Model
{
    use HasFactory, ApiTrait;

    const BORRADOR = 1;
    const PUBLICADO = 2;

    protected $fillable = ['name', 'slug', 'extract', 'body', 'status', 'category_id', 'user_id'];

    // Relacion 1:n inversa entre post y users
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Relacion 1:n inversa entre post y categorias
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // Relacion n:n entre posts y tags
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    // Relacion 1:n polimórfica entre post e images
    public function images(){
        return $this->morphToMany(Image::class, 'imageable');
    }
}
