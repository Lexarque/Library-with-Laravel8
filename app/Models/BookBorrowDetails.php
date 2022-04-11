<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrowDetails extends Model
{
    protected $table = 'book_borrow_details';
    protected $primaryKey = 'id_book_borrow_details';
    protected $timesamps = false;

    protected $fillable = ['id_borrow', 'id_book', 'qty'];
}
