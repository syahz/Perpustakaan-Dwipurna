<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddCafeRequest;
use App\Http\Requests\AddMenuRequest;
use App\Http\Resources\CafeResource;

class CafeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','role:cafe'])->except('getCafe');
    }

    public function addCafe(AddCafeRequest $request) 
    {
    $existingCafe = Cafe::where('user_id', auth()->user()->id_user)->first();
    
    if ($existingCafe) {
        return response(['error' => 'Cafe dengan user ini sudah terdaftar.'], 409);
    }
        DB::table('cafes')->insert([
            'id_cafe' => Str::uuid(),
            'name' => request('name'),
            'location' => request('location'),
            'user_id' => $request->user()->id_user,
            'created_at' => now(),
        ]);
        return response(['message' => 'Cafe Registered'], 200);
    }
    public function getCafe() 
    {
        $Cafes = Cafe::get();
        return CafeResource::collection($Cafes);
    }

    public function addMenu(AddMenuRequest $request) 
    {
        $id_user = $request->user()->id_user;
        $cafe = Cafe::where('user_id',$id_user)->first();
        
        if (!$cafe) {
        return response(['message' => 'Cafe not found'], 404);
        }

        DB::table('cafe_menus')->insert([
            'id_menu' => Str::uuid(),
            'nama_menu' => request('nama_menu'),
            'price' => request('price'),
            'cafe_id' => $cafe->id_cafe,
            'created_at' => now(),
        ]);
        return response(['message' => 'Menu berhasil ditambahkan'], 200);
    }

    public function addBooksCafe(Request $request) 
    {
        $id_user = $request->user()->id_user;
        $cafes = Cafe::where('user_id', $id_user)->first();

        $request->validate([
            'books_id' => 'required|exists:books,id_books',
            'quantity' => 'required|integer',
        ]);

        DB::table('books_cafes')->insert([
            'id' => Str::uuid(),
            'books_id' => request('books_id'),
            'quantity' => request('quantity'),
            'cafe_id' => $cafes->id_cafe,
            'created_at' => now(),
        ]);
        return response(['message' => 'Buku Cafe Berhasil ditambahkan'], 200);
    }

}
