<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
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
        
    ];
}
