<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Nilai;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Karyawan::all();

        $data_header = ["No", "ID", "Nama Karyawan", "Jenis Kelamin", "Tempat Lahir", "Tanggal Lahir", "Alamat",  "Action"];
        $data_body = $data->toArray();

        return view('pages.karyawan', compact('data_body', 'data_header'));
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
        $validatedData = $request->validate([
            "nama" => "required|max:255",
            "tempat_lahir" => "required|max:255",
            "tanggal_lahir" => "required|date",
            "jenis_kelamin" => "required|in:L,P",
        ]);

        $validatedData['alamat'] = $request->alamat ?? null;
        $validatedData['email'] = $request->email ?? 'null';
        $validatedData['telepon'] = $request->telepon ?? null;
        $validatedData['jabatan'] = $request->jabatan ?? null;

        $karyawan = Karyawan::create($validatedData);

        $get_kriteria = Kriteria::all();

        $nilai = array();
        foreach ($get_kriteria as $key => $kriteria) {
            $id = Nilai::generateKodeNilaiKey($key);
            $nilai[] = [
                'id' => $id,
                'id_karyawan' => $karyawan->id,
                'id_kriteria' => $kriteria->id,
                'nilai' => 0,
            ];
        }

        $insert_nilai = Nilai::insert($nilai);

        if ($karyawan && $insert_nilai) {
            return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan karyawan. Silakan coba lagi.');
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
        // update data karyawan
        $validatedData = $request->validate([
            "nama" => "required|max:255",
            "tempat_lahir" => "required|max:255",
            "tanggal_lahir" => "required|date",
            "jenis_kelamin" => "required|in:L,P",
        ]);

        $validatedData['alamat'] = $request->alamat ?? null;
        $validatedData['email'] = $request->email ?? 'null';
        $validatedData['telepon'] = $request->telepon ?? null;
        $validatedData['jabatan'] = $request->jabatan ?? null;

        $karyawan = Karyawan::find($id);
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan.');
        }

        $updated = $karyawan->update($validatedData);

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
        $karyawan = Karyawan::find($id);
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan.');
        }

        $deleted = $karyawan->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Karyawan berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus karyawan.');
        }
    }
}
