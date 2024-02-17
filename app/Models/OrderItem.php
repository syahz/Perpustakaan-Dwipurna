<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'transaction_id',
        'menu_id',
        'quantity'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function menu()
    {
        return $this->belongsTo(CafeMenu::class, 'menu_id', 'id_menu');
    }
}