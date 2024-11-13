<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class BlazeTokenTier extends Model
{
    use HasFactory;
       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blaze_tokens_tiers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'token_tier_name',
        'token_tier_description',
        'token_tier_amount',
        'token_tier_usd_price',
        'token_tier_is_active'
    ];

   
}