<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Service extends Model
{
    use HasFactory;
       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services';

    protected $casts = [
        'service_sale_ends_at' => 'date',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_name',
        'service_description',
        'service_price',
        'service_is_active',
        'service_frequency',
        'service_tag',
        'service_perks',
        'service_category',
        'service_is_on_sale',
        'service_sale_percentage',
        'service_sale_ends_at',
        'service_featured'
    ];

   
}