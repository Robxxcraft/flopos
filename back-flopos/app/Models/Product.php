<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [ 'title', 'slug', 'category_id', 'description', 'price', 'stock', 'photo' ];

    protected $casts = ['favorited_count' => 'boolean'];
    
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function favorite(){
        return $this->hasMany(Favorite::class);
    }

    public function favorited(){
        return $this->hasOne(Favorite::class)->where('user_id', isset(Auth::guard('sanctum')->user()->id) ? Auth::guard('sanctum')->user()->id : 0);
    }
}
