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
      'title',
      'image_cover',
      'description',
      'is_adult',
      'is_locked',
      'issue_number'
    ];

    public function pages(){
        return $this->hasMany(IssuePage::class);
    }
    public function book(){
        return $this->belongsTo(Book::class);
    }
}
