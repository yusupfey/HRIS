<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Employee;
use App\Models\workscheadules;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(){
        $data = DB::table('worksheadules')
            ->join('shifts', 'shifts.id', '=', 'worksheadules.shift_id')
            ->select('worksheadules.id', 'worksheadules.tanggal', 'shifts.id as shift_id', 'shifts.name', 'shifts.checkin_time', 'shifts.checkout_time')
            ->where('worksheadules.tanggal', date('Y-m-d'))
            ->where('worksheadules.uuid_employees', Session::get('uuid'))
            ->first();
    
        $in_date = date('H:i:s');
        $masuk = DB::table('absen')
            ->select('in_date', 'type')
            ->where('schd_id', $data->id ?? null)
            ->get();
    
        $absen = $masuk->firstWhere('type', 1);
        $pulang = $masuk->firstWhere('type', 2);
    
        date_default_timezone_set('Asia/Jakarta');
        $realtime = date('H:i:s');
        // dd($realtime);
    
        $checkin_time = date('H:i:s', strtotime($data->checkin_time ?? null) - 3600);//satuan detik dalam 1jm
        $checkin = $realtime >= $checkin_time && is_null($absen);
    
        $checkout_time = date('H:i:s', strtotime($data->checkout_time ?? null) - 600);//satuan detik 10mnit
        $checkout = $realtime >= $checkout_time && is_null($pulang);
    
        // shift yang tidak memerlukan  tombol
        $noabsen = in_array($data->shift_id ?? null, [4, 7, 8]);
    
        return view('dashboard2', compact('data', 'masuk', 'absen', 'pulang', 'checkin', 'checkout', 'noabsen'));
    }
    
        public function absen(Request $request){
            
            $schedules = DB::table('worksheadules')
            ->join('shifts','shifts.id','=','worksheadules.shift_id')
            ->select('shifts.checkin_time','shifts.checkout_time')
            ->where('worksheadules.id', $request->schd_id)
            ->first();
            
            


        switch ($request->mode) {
            case 'checkin':
                $type = 1;
                $remark = date('Y-m-d H:i:s') > $schedules->checkin_time ? 'Telat':'Ontime';
                break;
            case 'checkout':
                $type = 2;
                $remark='';
                if(date('H:i:s') > $schedules->checkout_time){
                    $code = 400;
                    $message = 'Anda Tidak bisa absense pulang, waktu pulang pukul'. $schedules->checkout_time;
                    return response()->json([
                        'response'=> [
                            'metadata'=> [
                                'code'=>$code,
                                'message'=>$message
                            ],
                        ]
                    ]);
                }
                
                break;
            default:
                # code.
                break;
        }
        date_default_timezone_set('Asia/Jakarta');
        $checkExist = Absen::where('schd_id', $request->schd_id)->where('type', $type)->first();
        if(isset($checkExist)){
            $code = 400;
            $message = 'Gagal';
            $resdata = $checkExist->in_date;
        }else{
            $indate = date('Y-m-d H:i:s');
            $data['uuid_karyawan'] = Session::get('uuid');
            $data['type'] = $type; 
            $data['in_date'] = $indate; 
            $data['schd_id'] = $request->schd_id; 
            $data['latlong'] = $request->input('latlong'); 
            $data['remark'] = $remark; 
            Absen::create($data);

            $code = 200;
            $message = 'Berhasil';
            $resdata = $indate;    
        }
        return response()->json([
            'response'=> [
                'metadata'=> [
                    'code'=>$code,
                    'message'=>$message
                ],
                'data'=> $resdata 
            ]
        ]);
    }
}
