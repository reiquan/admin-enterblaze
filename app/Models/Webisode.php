<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webisode extends Model
{
    use HasFactory;
       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table= 'webisodes';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = []; 

      /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'webisode_universe_id',
        'webisode_title',
        'webisode_slug',
        'webisode_logline',
        'webisode_description',
        'webisode_cover_image',
        'webisode_is_active',
        'webisode_is_featured',
        'webisode_is_adult',
        'webisode_tags',
        'webisode_genre',
        'webisode_rating',
        'webisode_release_date',
        'webisode_price',
        'webisode_episode_count',
        'webisode_view_count',
        'webisode_subscriber_count',
    ];


    public function universe()
    {
        return $this->belongsTo(Universe::class, 'webisode_universe_id');
    }
}
