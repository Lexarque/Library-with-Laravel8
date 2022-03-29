<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id_students';
    public $timestamps = false;

    protected $fillable = ['name_students', 'birth_date', 'gender', 'address', 'id_student_class'];
}
