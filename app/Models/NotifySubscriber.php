<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifySubscriber extends Model
{
    use HasFactory;
    protected $table = 'universe_subscriptions';

    protected $fillable = [
        'universe_id',
        'user_id',
        'is_active',
        'subscription_type',
    ];

    public function subscribers(){
        return $this->hasMany(User::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}