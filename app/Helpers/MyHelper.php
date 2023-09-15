<?php
namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MyHelper {
    public static function get_avatar($avatar, $empty_if_null = false)
    {
        // check existence of the file and is uploaded
        if($avatar != NULL)
        {
            return url(Storage::url($avatar));
        } else {
            if (!$empty_if_null) {
                return asset('theme-admin/assets/images/avatar.png');
            }
        }
    }

    public static function generateNoFaktur($id)
    {
        return str_pad($id, 5, '0', STR_PAD_LEFT) . '-' . date('Y');
    }

    public static function readableDate($date)
    {
        return Carbon::parse($date)->locale('id_ID')->isoFormat('D MMMM Y');
    }

    public static function formatNumber($number)
    {
        return number_format($number, 0, ',', '.');
    }

    public static function formatRupiah($number, $nol_menjadi_gratis = true)
    {
        if ($number > 0)
            return "Rp " . self::formatNumber($number);

        if ($number < 0)
            return "Rp " . self::formatNumber($number);

        if ($nol_menjadi_gratis)
            return "<span class='badge badge-success'>Gratis</span>";

        return 0;
    }

    public static function getMonthName($number, $year)
    {
        $indonesianMonths = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        if ($year) {
            return $indonesianMonths[$number] .' '. $year ?? date('Y');
        }
        return $indonesianMonths[$number];
    }


    public static function avatarUser($user, $width = "90px")
    {
        if ($user->foto == NULL) {
            return '<span data-letters="'. MyHelper::inisialNama($user->nama ?? $user->name) .'"></span>';
        } else {
            return '<img src="'. MyHelper::get_avatar($user->foto) .'" alt=""
            class="img-thumbnail rounded-circle" style="max-width:'. $width .'">';
        }
    }

    public static function inisialNama($str) {
        $acronym = '';
        $word = '';
        $words = preg_split("/(\s|\-|\.)/", $str);
        foreach($words as $w) {
            $acronym .= substr($w,0,1);
        }
        $word = $word . $acronym ;
        return $word;
    }

    public static function statusTicket($ticket) {
        switch ($ticket->status) {
            case 'open':
                return '<span class="badge bg-info">Open</span>';
                break;
            case 'progress':
                return '<span class="badge bg-warning">Progress</span>';
                break;
            case 'reject':
                return '<span class="badge bg-danger">Reject</span>';
                break;
            case 'finished':
                return '<span class="badge bg-success">Finished</span>';
                break;
            default:
                return '<span class="badge bg-danger">Open</span>';
                break;
        }
    }

    public static function isValidLatitude($latitude){
        if (preg_match("/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?);[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/", $latitude)) {
                return true;
        } else {
                return false;
        }
    }

    public static function isValidLongitude($longitude){
        if (preg_match("/^-?(180|1[1-7][0-9][.][0-9]{1,20}|[1-9][0-9][.][0-9]{1,20}|[0-9][.][0-9]{1,20})$/", $longitude)) {
                return true;
        } else {
                return false;
        }
    }

    public static function validateLatLong($lat, $long) {
        return preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?),[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $lat.','.$long);
    }

    public static function measuringDistance($koor1, $koor2) {
        try {
            // $explode1 = explode(",",$koor1);
            // $explode2 = explode(",",$koor2);
            // $lat1   = $explode1[0];
            // $lat2   = $explode2[0];
            // $lon1   = $explode1[1];
            // $lon2   = $explode2[1];
            // $theta  = $lon1 - $lon2;
            // $dist   = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            // $dist   = acos($dist);
            // $dist   = rad2deg($dist);
            // $miles  = $dist * 60 * 1.1515;
            // $kilm   = $miles * 1.60934;
            // $metm   = $miles * 1609.34;

            // return round($metm, 1);

            $explode1 = explode(",",$koor1);
            $explode2 = explode(",",$koor2);
            $lat1   = $explode1[0];
            $lat2   = $explode2[0];
            $lon1   = $explode1[1];
            $lon2   = $explode2[1];
            $theta  = $lon1 - $lon2;
            $dist   = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist   = acos($dist);
            $dist   = rad2deg($dist);
            $miles  = $dist * 60 * 1.1515;
            $kilm   = $miles * 1.60934;
            $metm   = $miles * 1609.34;

            return round($metm, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
