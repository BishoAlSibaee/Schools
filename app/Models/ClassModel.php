<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'class';
    protected $fillable = ['id_stage', 'class_code', 'class_student_count', 'class_student_counts'];
    public $timestamps = false;
}
