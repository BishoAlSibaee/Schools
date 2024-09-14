<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingModel extends Model
{
    use HasFactory;
    protected $table = 'building';
    protected $fillable = ['building_name', 'building_number ', 'building_la ', 'building_lo', 'building_count_floor', 'building_active'];
    public $timestamps = false;
}
