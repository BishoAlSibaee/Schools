<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloorModel extends Model
{
    use HasFactory;
    protected $table = 'floor';
    protected $fillable = ['id_building', 'floor_number', 'floor_count_classes'];
    public $timestamps = false;
}
