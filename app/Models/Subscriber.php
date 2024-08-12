<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Sanctum\CustomPersonalAccessToken;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Subscriber extends Authenticatable
{
    use HasFactory, HasApiTokens;

       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_creator'
    ];

   /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function createToken($name, array $abilities = ['*'])
    {
        return $this->tokens()->create([
            'name' => $name,
            'token' => $plainTextToken = str()->random(40),
            'abilities' => $abilities,
            'tokenable_type' => self::class, // Explicitly set the tokenable_type to your custom model
            'expires_at' =>  now()->addDays(7),
        ])->forceFill(['plain_text_token' => $plainTextToken]);
    }

    public function tokens()
    {
        return $this->morphMany(CustomPersonalAccessToken::class, 'tokenable');
    }
}
