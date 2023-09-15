<?php

namespace App\Http\Controllers;

use App\Helpers\MyHelper;
use App\Models\Customer;
use App\Models\Timeslot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function periode(Request $request)
    {
        $limit_ranking = $request->limit_ranking ?? 10;
        $order = $request->order ?? 'DESC';

        $data = [
            'title' => 'Laporan Periode',
        ];

        if (isset($request->date_from) && isset($request->date_to)) {
            $date_from = $request->date_from . " 00:00:00";
            $date_to = $request->date_to . " 23:59:59";
            $data['top_status'] =  self::getTimeslotPerStatus($date_from, $date_to);
            $data['top_odp'] =  self::getOdpMost($date_from, $date_to);
            $data['top_admin'] =  self::getTopAdmin($order, $limit_ranking, $date_from, $date_to);
            $data['top_customer'] =  self::getTopCustomer($order, $limit_ranking, $date_from, $date_to);
            $data['date_from'] = $request->date_from;
            $data['date_to'] = $request->date_to;
            $data['title'] = $data['title'] . ' | ' . \Carbon\Carbon::parse($date_from)->format('Y-m-d') . ' sd ' . \Carbon\Carbon::parse($date_to)->format('Y-m-d');
        } else {
            $data['top_status'] =  self::getTimeslotPerStatus();
            $data['top_odp'] =  self::getOdpMost();
            $data['top_admin'] =  self::getTopAdmin($order, $limit_ranking);
            $data['top_customer'] =  self::getTopCustomer($order, $limit_ranking);
        }

        $top_admin = [];
        foreach($data['top_admin'] as $key => $value) {
            $top_admin[$value['name']] = $value['timeslots_count'];
        }
        $data['top_admin'] = $top_admin;

        $top_customer = [];
        foreach($data['top_customer'] as $key => $value) {
            $top_customer[$value['nama']] = $value['timeslots_count'];
        }
        $data['top_customer'] = $top_customer;

        return view('laporan.periode', $data);
    }

    // Processor
    public static function getTimeslotPerStatus($date_from = null, $date_to = null)
    {
        $top_status = Timeslot::selectRaw('timeslots.status, COUNT(*) AS timeslots_count')
        ->groupBy('status')
        ->orderBy('timeslots_count', 'DESC')
        ->when($date_from, function($query) use ($date_from) {
            $query->where('timeslots.created_at', '>=', $date_from);
        })
        ->when($date_to, function($query) use ($date_to) {
            $query->where('timeslots.created_at', '<=', $date_to);
        })
        ->get();

        $arr_top_status = [];
        foreach ($top_status as $ts) {
            $arr_top_status[$ts['status']] = (int)$ts['timeslots_count'];
        }
        return $arr_top_status;
    }

    public static function getOdpMost($date_from = null, $date_to = null)
    {
        $top_odp = Timeslot::join('odps', 'odps.id', '=', 'timeslots.odp_id')->selectRaw('timeslots.odp_id, odps.kode, COUNT(*) AS timeslots_count')
        ->groupBy('odp_id')
        ->orderBy('timeslots_count', 'DESC')
        ->when($date_from, function($query) use ($date_from) {
            $query->where('timeslots.created_at', '>=', $date_from);
        })
        ->when($date_to, function($query) use ($date_to) {
            $query->where('timeslots.created_at', '<=', $date_to);
        })
        ->get();

        $arr_top_odp = [];
        foreach ($top_odp as $ts) {
            $arr_top_odp[$ts['kode']] = (int)$ts['timeslots_count'];
        }
        return $arr_top_odp;
    }

    public static function getTopAdmin($order = 'DESC', $limit = 10, $date_from = null, $date_to = null)
    {
        $top_admin = User::withCount(['timeslots' => function($query) use ($date_from, $date_to) {
            if ($date_from && $date_to) {
                $query->whereBetween('timeslots.created_at', [$date_from, $date_to]);
            }
        }])->orderBy('timeslots_count', $order)
        ->where('users.role', 'admin')
        ->take($limit)->get();

        return $top_admin;
    }

    public static function getTopCustomer($order = 'DESC', $limit = 10, $date_from = null, $date_to = null)
    {
        $top_customer = Customer::withCount(['timeslots' => function($query) use ($date_from, $date_to) {
            if ($date_from && $date_to) {
                $query->whereBetween('timeslots.created_at', [$date_from, $date_to]);
            }
        }])->orderBy('timeslots_count', $order)
        ->take($limit)->get();

        return $top_customer;
    }
}
