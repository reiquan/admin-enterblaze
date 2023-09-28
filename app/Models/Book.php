<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';
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
      
    ];

    public function volumes(){
        return $this->hasMany(Volume::class);
    }

    public function universe(){
        return $this->belongsTo(Universe::class, 'universe_id');
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function blogs(){
        return $this->hasMany(Blog::class);
    }
}
