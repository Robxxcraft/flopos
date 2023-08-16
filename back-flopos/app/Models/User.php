<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function serializeDate(DateTimeInterface $date) {
        return \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('d F Y');
    }

    public function cart(){
        return $this->hasMany(Cart::class)->with('product.category')->paginate(10);
    }
    
    public function cartAll(){
        return $this->hasMany(Cart::class)->with('product');
    }

    public function cartTotalQuantity(){
        return $this->hasMany(Cart::class)->sum('quantity');
    }
    
    public function favourite(){
        return $this->hasMany(Favourite::class);
    }
}
