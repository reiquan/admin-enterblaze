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
        'book_title',
        'book_genres',
        'book_description',
        'book_audience',
        'book_subtitle',
        'book_image_path',
        'book_slug_name',
        'book_type',
        'book_price'

    ];

    public function volumes(){
        return $this->hasMany(Volume::class);
    }

    public function issues(){
        return $this->hasMany(Issue::class, 'issue_book_id');
    }

    public function universe(){
        return $this->belongsTo(Universe::class, 'book_universe_id');
    }
}
