<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\CafeMenu;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function index(Request $request) 
    {
        $table_name = $request->input('table_name');
        $menu_orders = $request->input('orders'); 
        $cafeName = $request->cafeName;
        $cafe = Cafe::where('name', $cafeName)->first();

    $transaction = Transaction::create([
        'id' => 'TRX' . mt_rand(10000,99999). mt_rand(10000,99999),
        'table_name' => $table_name,
        'cafe_id' => $cafe->id_cafe, // atau
        'total_price' => 0, 
    ]);

    $total_price = 0;
    foreach ($menu_orders as $order) {

        $menu = CafeMenu::where('id_menu', $order['menu_id'])->first();
        if (!$menu) {
            return response(['message' => 'Menu tidak ada'], 404);
        }

        $quantity = $order['quantity'];
        $price = $menu->price * $quantity;

        $order_item = OrderItem::create([
            'id' => Str::uuid(),
            'transaction_id' => $transaction->id,
            'menu_id' => $menu->id_menu,
            'quantity' => $quantity,
        ]);
        $order_item->save();

        $total_price += $price;
    }

    $transaction->total_price = $total_price;
    $transaction->save();

    if ($total_price >= 25000) {
        $tiket = 'ini_tiket_ruang_baca' . mt_rand(10000,99999). mt_rand(10000,99999);
    } else {
        $tiket = null;
    }

    return response(['message' => 'Order has been placed', 'transaction_id' => $transaction->id,'tiket_ruang_baca' => $tiket], 200);

    }

    public function getAllTransaction($id_cafe)
    {
        $transaction = Transaction::where('cafe_id', $id_cafe)->get();
        return new TransactionResource($transaction);
    }

    public function getTransaction($id_cafe) 
    {
        $transaction = Transaction::where('cafe_id', $id_cafe)
        ->where('status','PENDING')
        ->get();
        return new TransactionResource($transaction);
    }
}
