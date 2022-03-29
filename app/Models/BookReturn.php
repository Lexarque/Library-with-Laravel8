<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReturn extends Model
{
    protected $table = 'book_return';
    protected $primaryKey = 'id_book_return';
    public $timestamps = false;

    protected $fillable = ['date_return', 'late_fee', 'id_borrow'];
}
