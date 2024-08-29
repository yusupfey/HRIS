<?php

namespace App\Http\Controllers;

use App\Models\Approve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Termwind\Components\Raw;

class ApproveController extends Controller
{
    public function index(){
        $uuid = Session::get('uuid');
        $data['data'] = DB::select("SELECT employees.name, approve.* FROM `approve` 
        INNER JOIN cuti on cuti.id=approve.id_permohonan 
        INNER JOIN employees on employees.uuid=cuti.uuid_karyawan 
        where uuid_atasan='$uuid' and approve.approve is null");
        // dd($uuid);
        $data['history'] = DB::select("SELECT employees.name, approve.* FROM `approve` 
        INNER JOIN cuti on cuti.id=approve.id_permohonan 
        INNER JOIN employees on employees.uuid=cuti.uuid_karyawan 
        where uuid_atasan='$uuid' and approve is not null");
        return view('pages/approve/index', compact('data'));
    }
    public function data($get, Request $request){
        if($get === 'cuti'){
            $data = DB::select("SELECT e1.name, units.name as unit, cuti.*, e2.name as pengganti_name, dr.val_name FROM cuti
            INNER JOIN employees e1 on e1.uuid=cuti.uuid_karyawan
            INNER JOIN units on e1.id_unit=units.id
            INNER JOIN d_references dr on dr.val=cuti.jenis_cuti and reference_id=1
            INNER JOIN employees e2 on e2.uuid=cuti.karyawan_pengganti 
            where cuti.id=$request->id");


            $approve = DB::select("SELECT e1.*, approve.approve_date, units.name as unit FROM `approve` 
            INNER JOIN employees e1 on e1.uuid=approve.uuid_atasan 
            INNER JOIN units on e1.id_unit=units.id
            where approve.id_permohonan=$request->id and jenis_permohonan=1");
            return response()->json(['cuti'=>$data, 'approve'=>$approve]);
        }else if($get === 'Izin'){

        }
    }
    public function store($get, Request $request){
        if($request->jenis_permohonan === '1'){
            //cuti

            if($get ==='approved'){
                $uuid = Session::get('uuid');
                try {
                    $data = Approve::where([
                        ['id_permohonan','=',$request->id_permohonan],
                        ['jenis_permohonan','=',$request->jenis_permohonan],
                        ['uuid_atasan','=',$uuid]
                    ])->update([
                        'approve'=>1,
                        'approve_date'=>date('Y-m-d h:m:s'),
                    ]);
                    return response()->json(['metadata'=>[
                            'code'=>200, 
                            'message'=>'Berhasil di update'
                        ]
                    ]);
                } catch (\Throwable $th) {
                    //throw $th;
                    return response()->json([
                        'metadata'=>[
                            'code'=>402, 
                            'message'=>'Error'
                        ],
                        'data'=>$th
                    ]);

                }

            }else{

            }
        }

        return $get;
    }
}
