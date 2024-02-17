<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_cafe';
    public $incrementing = false;
    protected $keyType = 'string';


}