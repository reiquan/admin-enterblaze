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
      'issue_title',
      'issue_image_cover',
      'issue_description',
      'issue_is_adult',
      'issue_is_locked',
      'issue_number',
      'issue_price',
      'issue_blaze_token_amount'
    ];

    public function pages(){
        return $this->hasMany(IssuePage::class);
    }
    public function book(){
        return $this->belongsTo(Book::class, 'issue_book_id');
    }
}
