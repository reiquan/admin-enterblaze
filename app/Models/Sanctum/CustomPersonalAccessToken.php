<?php

namespace App\Models\Sanctum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class CustomPersonalAccessToken extends SanctumPersonalAccessToken
{
          /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'custom_personal_access_tokens';

    protected $fillable = [
        'name',
        'token' ,
        'abilities',
        'tokenable_type', // Explicitly set the tokenable_type to your custom model
        'expires_at',
    ];
    // You can add custom methods or properties here
     // Example of custom logic
     public function scopeActive($query)
     {
         return $query->where('revoked', false);
     }
 
}
