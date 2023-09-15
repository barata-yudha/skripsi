<?php

namespace App\Http\Controllers;

use App\DataTables\TimeslotDataTable;
use App\DataTables\TimeslotOpenDataTable;
use App\DataTables\TimeslotProgressDataTable;
use App\DataTables\TimeslotRejectDataTable;
use App\DataTables\TimeslotSolveDataTable;
use App\Models\Customer;
use App\Models\Odp;
use App\Models\Ont;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TimeslotController extends Controller
{
    public function index(TimeslotDataTable $dataTable)
    {
        return $dataTable->render('timeslot.index', [
            'title' => 'List Timeslot',
            'datatable' => true
        ]);
    }

    public function ticket_open(TimeslotOpenDataTable $dataTable)
    {
        return $dataTable->render('ticket.open', [
            'title' => 'List Ticket Open',
            'datatable' => true
        ]);
    }

    public function ticket_progress(TimeslotProgressDataTable $dataTable)
    {
        return $dataTable->render('ticket.progress', [
            'title' => 'List Ticket Progress',
            'datatable' => true
        ]);
    }

    public function ticket_solve(TimeslotSolveDataTable $dataTable)
    {
        return $dataTable->render('ticket.solved', [
            'title' => 'List Ticket Solved',
            'datatable' => true
        ]);
    }

    public function ticket_reject(TimeslotRejectDataTable $dataTable)
    {
        return $dataTable->render('ticket.reject', [
            'title' => 'List Ticket Reject',
            'datatable' => true
        ]);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Timeslot',
            'customers' => Customer::all(),
            'odps' => Odp::where('port_used', '<', '16')->get(),
            'onts' => Ont::all(),
        ];
        return view('timeslot.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => ['required'],
            'odp_id' => ['required'],
            'ont_id' => ['required'],
            'latitude' => ['nullable'],
            'longitude' => ['nullable'],
            'serial_number' => ['nullable'],
            'cable_distance' => ['nullable'],
            'doc' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp,pdf,webp', 'between:0,2048'],
        ]);

        try {
            $timeslot = new Timeslot();
            $timeslot->user_id = Auth::user()->id;
            $timeslot->customer_id = $request->customer_id;
            $timeslot->odp_id = $request->odp_id;
            $timeslot->ont_id = $request->ont_id;
            $timeslot->latitude = $request->latitude;
            $timeslot->longitude = $request->longitude;
            $timeslot->serial_number = $request->serial_number;
            $timeslot->cable_distance = $request->cable_distance;

            if ($request->hasFile('doc')) {
                $filename = Str::random(32) . '.' . $request->file('doc')->getClientOriginalExtension();
                $doc_path = $request->file('doc')->storeAs('public/doc', $filename);
                $timeslot->doc = isset($doc_path) ? $doc_path : '';
            }


            $timeslot->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat Timeslot: ' . $e->getMessage());
        }

        return redirect()->route('dashboard.timeslot.index')->with('success', 'Timeslot berhasi disimpan.');
    }

    public function edit($id)
    {
        $timeslot = Timeslot::findOrFail($id);
        return view('timeslot.edit', [
            'data' => $timeslot,
            'title' => 'Edit Timeslot',
        ]);
    }

    public function show($id)
    {
        $timeslot = Timeslot::findOrFail($id);
        return view('timeslot.show', [
            'data' => $timeslot,
            'title' => 'Detail Timeslot',
        ]);
    }

    public function update(Request $request, $id)
    {
        $timeslot = Timeslot::findOrFail($id);
        $request->validate([
            'customer_id' => ['required'],
            'odp_id' => ['required'],
            'ont_id' => ['required'],
            'latitude' => ['nullable'],
            'longitude' => ['nullable'],
            'serial_number' => ['nullable'],
            'cable_distance' => ['nullable'],
            'doc' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp,pdf,webp', 'between:0,2048'],
        ]);

        try {
            $timeslot->customer_id = $request->customer_id;
            $timeslot->odp_id = $request->odp_id;
            $timeslot->ont_id = $request->ont_id;
            $timeslot->latitude = $request->latitude;
            $timeslot->longitude = $request->longitude;
            $timeslot->serial_number = $request->serial_number;
            $timeslot->cable_distance = $request->cable_distance;

            if ($request->hasFile('doc')) {
                if($timeslot->doc != '') {
                    try {
                        Storage::delete($timeslot->doc);
                    } catch (\Throwable $th) {
                    }
                }
                $filename = Str::random(32) . '.' . $request->file('doc')->getClientOriginalExtension();
                $doc_path = $request->file('doc')->storeAs('public/doc', $filename);
                $timeslot->doc = $request->file('doc')->getClientOriginalName();
            }
            $timeslot->doc = isset($doc_path) ? $doc_path : $timeslot->doc;

            $timeslot->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil mengubah data Timeslot.');
    }

    public function destroy($id)
    {
        $timeslot = Timeslot::findOrFail($id);
        try {
            $timeslot->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil menghapus Timeslot.');
    }

    // State Functions
    public function approve($id)
    {
        $timeslot = Timeslot::findOrFail($id);
        $timeslot->status = 'progress';
        $timeslot->taken_by = Auth::user()->id;
        $timeslot->taken_at = date('Y-m-d H:i:s');
        $timeslot->save();

        return redirect()->route('dashboard.timeslot.progress')->with('success', 'Ticket berhasil di approve, status berubah menjadi progress');
    }

    public function reject($id)
    {
        $timeslot = Timeslot::findOrFail($id);
        $timeslot->status = 'reject';
        $timeslot->save();

        return redirect()->route('dashboard.timeslot.open')->with('success', 'Ticket berhasil di reject, status berubah menjadi Reject.');
    }

    public function finish($id)
    {
        $timeslot = Timeslot::findOrFail($id);
        $timeslot->status = 'finished';
        $timeslot->finished_at = date('Y-m-d H:i:s');
        $timeslot->save();

        // update odp used + 1
        $odp = Odp::findOrFail($timeslot->odp_id);
        $odp->port_used = $odp->port_used + 1;
        $odp->save();

        return redirect()->route('dashboard.timeslot.solve')->with('success', 'Ticket berhasil di selesaikan, status berubah menjadi Finished.');
    }
}
