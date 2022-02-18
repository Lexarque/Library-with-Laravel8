<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReturnDetails extends Model
{
    protected $table = 'return_details';
    public $timestamps = false;

    protected $fillable = ['qty', 'id_borrow', 'id_book'];
}
