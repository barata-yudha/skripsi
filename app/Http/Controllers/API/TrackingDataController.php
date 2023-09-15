<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OdpCollection;
use App\Http\Resources\TimeslotCollection;
use App\Models\Odp;
use App\Models\Timeslot;
use Illuminate\Http\Request;

class TrackingDataController extends Controller
{
    public function get_tracking_odp(Request $request)
    {
        $odp = Odp::query();
        if ($request->filter != '') {
            $odp->where(function ($query) {
                $query->where('latitude', 'not like', '%E%');
                $query->orWhere('latitude', 'not like', '%?%');
                $query->orWhere('latitude', '!=', 0);
                $query->orWhere('latitude', '!=', 1);
                $query->orWhere('longitude', 'not like', '%E%');
                $query->orWhere('longitude', 'not like', '%?%');
                $query->orWhere('longitude', '!=', 0);
                $query->orWhere('longitude', '!=', 1);
            })->get();
        }
        $odp = $odp->where(function ($query) {
                $query->where('latitude', 'not like', '%E%');
                $query->where('latitude', 'not like', '%?%');
                $query->where('latitude', '!=', 0);
                $query->where('latitude', '!=', 1);
                $query->where('longitude', 'not like', '%E%');
                $query->where('longitude', 'not like', '%?%');
                $query->where('longitude', '!=', 0);
                $query->where('longitude', '!=', 1);
            })
        ->get();
        $data = OdpCollection::collection($odp);
        return response()->json($data);
    }

    public function get_tracking_timeslot(Request $request)
    {
        $timeslot = Timeslot::query();
        if ($request->filter != '') {
            $timeslot->where(function ($query) {
                $query->where('latitude', 'not like', '%E%');
                $query->orWhere('latitude', 'not like', '%?%');
                $query->orWhere('latitude', '!=', 0);
                $query->orWhere('latitude', '!=', 1);
                $query->orWhere('longitude', 'not like', '%E%');
                $query->orWhere('longitude', 'not like', '%?%');
                $query->orWhere('longitude', '!=', 0);
                $query->orWhere('longitude', '!=', 1);
            })->get();
        }
        $timeslot = $timeslot->where(function ($query) {
                $query->where('latitude', 'not like', '%E%');
                $query->where('latitude', 'not like', '%?%');
                $query->where('latitude', '!=', 0);
                $query->where('latitude', '!=', 1);
                $query->where('longitude', 'not like', '%E%');
                $query->where('longitude', 'not like', '%?%');
                $query->where('longitude', '!=', 0);
                $query->where('longitude', '!=', 1);
            })
        ->where('status', 'finished')
        ->get();
        $data = TimeslotCollection::collection($timeslot);
        return response()->json($data);
    }
}
