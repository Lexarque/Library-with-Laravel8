<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    protected $primaryKey = 'id_book';
    public $timestamps = false;

    protected $fillable = ['name_book', 'author_book', 'desc_book', 'image'];
}
