<?php

namespace App\Http\Controllers;

use App\DataTables\OdpDataTable;
use App\Models\Odp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OdpController extends Controller
{
    public function index(OdpDataTable $dataTable)
    {
        return $dataTable->render('master.odp.index', [
            'title' => 'List ODP',
            'datatable' => true
        ]);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah ODP',
        ];
        return view('master.odp.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => ['nullable'],
            'latitude' => ['nullable'],
            'longitude' => ['nullable'],
            'address' => ['nullable'],
            'power' => ['nullable'],
            'port_max' => ['nullable'],
            'port_used' => ['nullable'],
            'keterangan' => ['nullable'],
            'icon' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp,pdf,webp', 'between:0,2048'],
            'doc' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp,pdf,webp', 'between:0,2048'],
        ]);

        try {
            $odp = new Odp();
            $odp->kode = $request->kode;
            $odp->latitude = $request->latitude;
            $odp->longitude = $request->longitude;
            $odp->address = $request->address;
            $odp->power = $request->power;
            $odp->port_max = $request->port_max;
            $odp->port_used = 0;
            $odp->keterangan = $request->keterangan;

            if ($request->hasFile('doc')) {
                $filename = Str::random(32) . '.' . $request->file('doc')->getClientOriginalExtension();
                $doc_path = $request->file('doc')->storeAs('public/doc', $filename);
                $odp->doc = isset($doc_path) ? $doc_path : '';
            }

            if ($request->hasFile('icon')) {
                $filename = Str::random(32) . '.' . $request->file('icon')->getClientOriginalExtension();
                $icon_path = $request->file('icon')->storeAs('public/icon', $filename);
                $odp->icon = isset($icon_path) ? $icon_path : '';
            }

            $odp->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat ODP: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.odp.index')->with('success', 'ODP berhasi disimpan.');
    }

    public function edit($id)
    {
        $odp = Odp::findOrFail($id);
        return view('master.odp.edit', [
            'data' => $odp,
            'title' => 'Edit ODP',
        ]);
    }

    public function update(Request $request, $id)
    {
        $odp = Odp::findOrFail($id);
        $request->validate([
            'kode' => ['nullable'],
            'latitude' => ['nullable'],
            'longitude' => ['nullable'],
            'address' => ['nullable'],
            'power' => ['nullable'],
            'port_max' => ['nullable'],
            'port_used' => ['nullable'],
            'keterangan' => ['nullable'],
            'doc' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp,pdf,webp', 'between:0,2048'],
            'icon' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp,pdf,webp', 'between:0,2048'],
        ]);

        try {
            $odp->kode = $request->kode;
            $odp->latitude = $request->latitude;
            $odp->longitude = $request->longitude;
            $odp->address = $request->address;
            $odp->power = $request->power;
            $odp->port_max = $request->port_max;
            $odp->keterangan = $request->keterangan;

            if ($request->hasFile('doc')) {
                if($odp->doc != '') {
                    try {
                        Storage::delete($odp->doc);
                    } catch (\Throwable $th) {
                    }
                }
                $filename = Str::random(32) . '.' . $request->file('doc')->getClientOriginalExtension();
                $doc_path = $request->file('doc')->storeAs('public/doc', $filename);
                $odp->doc = $request->file('doc')->getClientOriginalName();
            }
            $odp->doc = isset($doc_path) ? $doc_path : $odp->doc;

            if ($request->hasFile('icon')) {
                if($odp->icon != '') {
                    try {
                        Storage::delete($odp->icon);
                    } catch (\Throwable $th) {
                    }
                }
                $filename = Str::random(32) . '.' . $request->file('icon')->getClientOriginalExtension();
                $icon_path = $request->file('icon')->storeAs('public/icon', $filename);
                $odp->icon = $request->file('icon')->getClientOriginalName();
            }
            $odp->icon = isset($icon_path) ? $icon_path : $odp->icon;

            $odp->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.odp.index')->with('success', 'Berhasil mengubah data odp.');
    }

    public function destroy($id)
    {
        $odp = Odp::findOrFail($id);
        try {
            $odp->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil menghapus odp.');
    }
}
