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
            ->join('shifts','shifts.id','=','worksheadules.shift_id')
            ->select('worksheadules.id','worksheadules.tanggal','shifts.name')
            ->where('worksheadules.tanggal', date('Y-m-d'))
            ->where('worksheadules.uuid_employees', Session::get('uuid'))
            ->first();
        // $masuk = A
            // dd($data);
            return view('dashboard2', compact('data'));
        }
        // public function getabsen(Request $request){
        //     $data =DB::select("select * from absen where uuid_karyawan='$request->uuid' and type='$request->type'and in_date='$request->in_date'and schd_id='$request->schd_id'and type='$request->type'");
        //     return $data;
        // }
        
    public function absen(Request $request){
           
        
        switch ($request->mode) {
            case 'checkin':
                $type = 1;
                break;
            case 'checkout':
                $type = 2;
                break;
                
            
            default:
                # code...
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
            $data['remark'] = ''; 
                // dd($absen);
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
