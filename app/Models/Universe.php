<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universe extends Model
{
    use HasFactory;

         /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'universes';
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
        'universe_name', 'universe_image_url', 'universe_logo'
    ];
    public function books(){
        return $this->hasMany(Book::class);
    }
    public function volumes(){
        return $this->hasMany(Volume::class);
    }
}
