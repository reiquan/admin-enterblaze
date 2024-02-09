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
    protected $table = 'issue_pages';
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
      'issue_page_url',
      'issue_page_is_locked',
      'issue_page_is_adult'
    ];

    public function issue(){
        return $this->belongsTo(Issue::class);
    }
}
