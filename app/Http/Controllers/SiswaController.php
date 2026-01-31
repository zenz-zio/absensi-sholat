<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    //{
    // tampilkan data siswa
    public function index()
    {
        $siswas = Siswa::all();
        return view('siswa.index', compact('siswas'));
    }

    // form tambah siswa
    public function create()
    {
        return view('siswa.create');
    }

    // simpan data siswa
    public function store(Request $request)
    {
        $request->validate([
            'nisn'    => 'required|unique:siswas,nisn',
            'kelas'   => 'required',
            'jurusan' => 'required',
        ]);

        Siswa::create($request->all());

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa berhasil ditambahkan');
    }

    // form edit siswa
    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    // update data siswa
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nisn'    => 'required|unique:siswas,nisn,' . $siswa->id,
            'kelas'   => 'required',
            'jurusan' => 'required',
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa berhasil diupdate');
    }

    // hapus data siswa
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa berhasil dihapus');
    }
}

