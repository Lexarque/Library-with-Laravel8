<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table = 'student_class';
    protected $primaryKey = 'id_student_class';
    public $timestamps = false;

    protected $fillable = ['name_student_class', 'group_student_class'];
}
