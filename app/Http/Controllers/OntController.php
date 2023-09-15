<?php

namespace App\Http\Controllers;

use App\DataTables\OntDataTable;
use App\Models\Ont;
use Illuminate\Http\Request;

class OntController extends Controller
{
    public function index(OntDataTable $dataTable)
    {
        return $dataTable->render('master.ont.index', [
            'title' => 'List ONT',
            'datatable' => true
        ]);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah ONT',
        ];
        return view('master.ont.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'merk_ont' => ['nullable'],
            'type_ont' => ['nullable'],
            'versi_ont' => ['nullable'],
        ]);

        try {
            $ont = new Ont();
            $ont->merk_ont = $request->merk_ont;
            $ont->type_ont = $request->type_ont;
            $ont->versi_ont = $request->versi_ont;

            $ont->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat ONT: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.ont.index')->with('success', 'ONT berhasi disimpan.');
    }

    public function edit($id)
    {
        $ont = Ont::findOrFail($id);
        return view('master.ont.edit', [
            'data' => $ont,
            'title' => 'Edit ONT',
        ]);
    }

    public function update(Request $request, $id)
    {
        $ont = Ont::findOrFail($id);
        $request->validate([
            'merk_ont' => ['nullable'],
            'type_ont' => ['nullable'],
            'versi_ont' => ['nullable'],
        ]);

        try {
            $ont->merk_ont = $request->merk_ont;
            $ont->type_ont = $request->type_ont;
            $ont->versi_ont = $request->versi_ont;

            $ont->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.ont.index')->with('success', 'Berhasil mengubah data ONT.');
    }

    public function destroy($id)
    {
        $ont = Ont::findOrFail($id);
        try {
            $ont->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil menghapus ONT.');
    }
}
