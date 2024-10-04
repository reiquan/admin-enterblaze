<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriberNotification extends Model
{
    use HasFactory;
    protected $table = 'notify_subscribers';

    protected $fillable = [
        'universe_id',
        'alert_title',
        'alert_type',
        'alert_body',
        'alert_attachments',
        'post_date',
        'is_active',
    ];
    protected $dates = [
        'alert_post_date',
    ];
}