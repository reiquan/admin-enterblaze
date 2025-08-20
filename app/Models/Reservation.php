<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reservations';
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
        'book_id',
        'issue_id',
        'user_id',
        'price',
        'email',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'reservation_number',

    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function issues(){
        return $this->belongsTo(Issue::class);
    }
}
