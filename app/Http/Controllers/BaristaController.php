<?php

namespace App\Http\Controllers;

use App\Models\BaristaCafe;
use App\Models\Cafe;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaristaController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api','role:barista']);
    }

    public function confirmTransaction(Request $request, $id_transaction) 
    {
        $request->validate([
            'status' => 'required|in:PENDING,VERIFIED,FAILED',
        ]);

        $book = Transaction::findOrFail($id_transaction);
    
        $book->status = $request->input('status');
        $book->save();

    return response()->json(['message' => 'Data berhasil diupdate']);
    }

    public function addBaristaCafe(Request $request) 
    {
        $id_user = $request->user()->id_user;
        $request->validate([
            'cafe_id' => 'required|exists:cafes,id_cafe',
        ]);
        $cafeId = $request->input('cafe_id');

        $existingBarista = BaristaCafe::where('user_id', auth()->user()->id_user)->first();
        if ($existingBarista) {
            return response(['error' => 'Barista dengan user ini sudah terdaftar.'], 409);
        }

        DB::table('barista_cafes')->insert([
            'id' => Str::uuid(),
            'user_id' => $id_user,
            'cafe_id' => $cafeId,
        ]);
        return response(['message' => 'Barista Added'], 200);
    }
}
