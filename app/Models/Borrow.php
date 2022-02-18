<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $table = 'borrow';
    public $timestamps = false;

    protected $fillable = ['date_borrow', 'id_students'];
}
