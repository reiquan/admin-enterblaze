<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    //
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'issues';
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

    public function volume(){
        return $this->belongsTo(Volume::class);
    }
    public function product(){
        return $this->hasOne(Product::class);
    }
}
