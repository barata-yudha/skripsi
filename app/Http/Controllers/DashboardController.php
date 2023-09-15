<?php

namespace App\Http\Controllers;

use App\Helpers\MyHelper;
use App\Models\Customer;
use App\Models\Odp;
use App\Models\Timeslot;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_odp = Odp::count();
        $total_customer = Customer::count();
        $total_open = Timeslot::where('status', 'open')->count();
        $total_progress = Timeslot::where('status', 'progress')->count();
        $total_solved = Timeslot::where('status', 'finished')->count();
        $data = [
            'title' => 'Dashboard',
            'total_odp' => $total_odp,
            'total_customer' => $total_customer,
            'total_open' => $total_open,
            'total_progress' => $total_progress,
            'total_solved' => $total_solved,
        ];

        return view('dashboard', $data);
    }

    public function my_area()
    {
        $data = [
            'title' => 'My Area',
        ];

        return view('my_area', $data);
    }

    public function check_coverage(Request $request)
    {
        $data = [
            'title' => 'Check Coverage',
        ];

        if ($request->has('tikor_pelanggan')) {
            $tikor_pelanggan = $request->tikor_pelanggan;
            // split latitude longitude dari tikor
            $split = explode(',', $tikor_pelanggan);
            $latitude = 0;
            $longitude = 0;

            if (isset($split[0])) {
                $latitude = $split[0];
            };

            if (isset($split[1])) {
                $longitude = $split[1];
            };
            $tikor_pelanggan_fixed = $latitude . ',' . $longitude;

            $odps = Odp::where('port_used', '<', '16')->get();
            foreach ($odps as $odp) {
                $odp_latitude = $odp->latitude;
                $odp_longitude = $odp->longitude;
                $tikor_odp = $odp_latitude . ',' . $odp_longitude;
                $distance = MyHelper::measuringDistance($tikor_pelanggan_fixed, $tikor_odp);

                $value['kode']      = $odp->kode;
                $value['address']  = $odp->address;
                $value['port']  = $odp->port_used . '/' . $odp->port_max;
                $value['distance']     = $distance;
                $value['direction_link']      = "<a href='https://www.google.com/maps/dir/".$tikor_odp."/".$tikor_pelanggan."/' target='_BLANK'><i class='fa fa-search'></i></a>";
                $data['data'][] = $value;
            }

            usort($data['data'], function($x, $y) {
                return $x['distance'] <=> $y['distance'];
            });

            $last['data']   = array_slice($data['data'], 0, 5);
        }

        $data['tikor_pelanggan'] = $tikor_pelanggan ?? null;
        $data['latitude'] = $latitude ?? null;
        $data['longitude'] = $longitude ?? null;
        $data['closest_odp'] = $last['data'] ?? null;

        return view('check_coverage', $data);
    }
}
