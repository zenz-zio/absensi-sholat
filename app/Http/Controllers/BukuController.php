<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('index', compact('buku'));
    }

    public function create()
    {
        return view('forms');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penerbit' => 'required|string',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required',
        ]);


        Buku::create($validated);
        return redirect('/');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penerbit' => 'required|string',
            'penulis' => 'required|string|max:255',
            'tahun_terbit' => 'required',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($validated);

        return redirect('/');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect('/');
    }
}
