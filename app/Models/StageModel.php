<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StageModel extends Model
{
    use HasFactory;
    protected $table = 'stage';
    protected $fillable = ['id_building', 'stage_name', 'stage_number'];
    public $timestamps = false;
}
