<?php

namespace App\Http\Controllers;

use App\DataTables\CustomerDataTable;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(CustomerDataTable $dataTable)
    {
        return $dataTable->render('master.customer.index', [
            'title' => 'List Customer',
            'datatable' => true
        ]);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Customer',
        ];
        return view('master.customer.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['nullable'],
            'no_hp' => ['nullable'],
            'alamat' => ['nullable'],
        ]);

        try {
            $customer = new Customer();
            $customer->nama = $request->nama;
            $customer->no_hp = $request->no_hp;
            $customer->alamat = $request->alamat;

            $customer->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat Customer: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.customer.index')->with('success', 'Customer berhasi disimpan.');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('master.customer.edit', [
            'data' => $customer,
            'title' => 'Edit Customer',
        ]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $request->validate([
            'nama' => ['nullable'],
            'no_hp' => ['nullable'],
            'alamat' => ['nullable'],
        ]);

        try {
            $customer->nama = $request->nama;
            $customer->no_hp = $request->no_hp;
            $customer->alamat = $request->alamat;

            $customer->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.customer.index')->with('success', 'Berhasil mengubah data Customer.');


        // SET KE VARIABLE
        $tgl_awal = $request->tgl_awal;
        $id_status = $request->id_status;
        $id_unit = $request->id_unit;

        // QUERY USING WHEN
        DB::table('table')->select()
            ->when($tgl_awal, function ($query, $tgl_awal) {
                return $query->where('tgl', '>=', $tgl_awal);
            })
            ->when($id_status, function ($query, $id_status) {
                return $query->where('id_status', '>=', $id_status);
            })
            ->when($id_unit, function ($query, $id_unit) {
                return $query->where('id_unit', '>=', $id_unit);
            })
            ->get();
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        try {
            $customer->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil menghapus Customer.');
    }
}
