<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Train;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Train::all();

        $data_header = ["No", "ID", "Selisih", "Nilai", "Keterangan",  "Action"];
        $data_body = $data->toArray();

        return view('pages.train', compact('data_body', 'data_header'));
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
        // store data train
        $validatedData = $request->validate([
            "keterangan" => "required|max:255",
            "nilai" => "required|numeric",
            "selisih" => "required|numeric",
        ]);

        $train = Train::create($validatedData);

        if ($train) {
            return redirect()->route('train.index')->with('success', 'Train berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan train. Silakan coba lagi.');
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
        // update data train
        $validatedData = $request->validate([
            "keterangan" => "required|max:255",
            "nilai" => "required|numeric",
            "selisih" => "required|numeric",
        ]);

        $train = Train::find($id);

        if ($train) {
            $train->update($validatedData);
            return redirect()->route('train.index')->with('success', 'Train berhasil diupdate.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate train. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // destroy data train
        $train = Train::find($id);

        if ($train) {
            $train->delete();
            return redirect()->route('train.index')->with('success', 'Train berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus train. Silakan coba lagi.');
        }
    }
}
