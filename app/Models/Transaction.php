<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id',
        'table_name',
        'cafe_id',
        'total_price',
        'status'
    ];


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

}