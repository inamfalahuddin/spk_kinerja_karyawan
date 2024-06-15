<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kriteria::all();

        $data_header = ["No", "ID", "Nama Kriteria", "Nilai", "Tipe",  "Action"];
        $data_body = $data->toArray();

        $data_aspek = [
            '1' => 'Sangat Kurang',
            '2' => 'Kurang',
            '3' => 'Cukup',
            '4' => 'Baik',
            '5' => 'Sangat Baik',
        ];

        return view('pages.kriteria', compact('data_body', 'data_header', 'data_aspek'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // store data kriteria
        $validatedData = $request->validate([
            "nama" => "required|max:255",
            "tipe" => "required|in:core,secondary",
            "nilai" => "required|numeric",
        ]);

        $kriteria = Kriteria::create($validatedData);

        if ($kriteria) {
            return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan kriteria. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update kriteria
        $validatedData = $request->validate([
            "nama" => "required|max:255",
            "tipe" => "required|in:core,secondary",
            "nilai" => "required|numeric",
        ]);

        $kriteria = Kriteria::find($id);

        if (!$kriteria) {
            return redirect()->back()->with('error', 'Kriteria tidak ditemukan.');
        }

        $updated = $kriteria->update($validatedData);

        if ($updated) {
            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete data kriteria 
        $kriteria = Kriteria::find($id);

        if (!$kriteria) {
            return redirect()->back()->with('error', 'Kriteria tidak ditemukan.');
        }

        $deleted = $kriteria->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }
}
