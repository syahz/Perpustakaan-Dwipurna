<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddBookRequest;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','role:toko_buku']);
    }

    public function addBooks(AddBookRequest $request) 
    {
        $id_user = $request->user()->id_user;

        DB::table('books')->insert([
            'id_books' => Str::uuid(),
            'judul' => request('judul'),
            'penulis' => request('penulis'),
            'penerbit' => request('penerbit'),
            'tahun_terbit' => request('tahun_terbit'),
            'user_id' => $id_user,
        ]);
        return response(['message' => 'Book Added'], 200);
    }
}
