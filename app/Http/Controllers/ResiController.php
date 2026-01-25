<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ResiController extends Controller
{
    public function index()
    {
        $resi = Resi::all();
        return view('dashboard.admin.resi.index', compact('resi'));
    }

    public function create()
    {
        return view('dashboard.admin.resi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengirim'     => 'required|string',
            'kontak_pengirim'   => 'required',
            'alamat_pengirim'   => 'required',
            'nama_penerima'     => 'required|string',
            'kontak_penerima'   => 'required',
            'alamat_penerima'   => 'required',
            'jenis_pengiriman'  => 'required',
            'harga'             => 'nullable',
        ]);

        $validated['no_resi'] = 'RESI-' . Str::upper(Str::random(8));

        $validated['harga'] = $validated['harga']
            ? str_replace(['Rp ', '.'], '', $validated['harga'])
            : null;

        Resi::create($validated);

        return redirect()
            ->route('admin.resi.index')
            ->with('success', 'Resi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $resi = Resi::findOrFail($id);

        return view('dashboard.admin.resi.edit', compact('resi'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_pengirim'     => 'required|string',
            'kontak_pengirim'   => 'required',
            'alamat_pengirim'   => 'required',
            'nama_penerima'     => 'required|string',
            'kontak_penerima'   => 'required',
            'alamat_penerima'   => 'required',
            'jenis_pengiriman'  => 'required',
            'harga'             => 'nullable',
        ]);

        $validated['harga'] = $validated['harga']
            ? str_replace(['Rp ', '.'], '', $validated['harga'])
            : null;

        $resi = Resi::findOrFail($id);
        $resi->update($validated);

        return redirect()
            ->route('admin.resi.index')
            ->with('success', 'Resi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $resi = Resi::findOrFail($id);
        $resi->delete();

        return redirect()->route('admin.resi.index');
    }

    public function showQr($id)
    {
        $resi = Resi::findOrFail($id);

        return view('dashboard.admin.resi.qr', compact('resi'));
    }
}
