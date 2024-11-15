<?php

namespace App\Http\Controllers;

use App\Models\Approve;
use App\Models\cuti;
use App\Models\d_cuti;
use App\Models\Izin;
use App\Models\Sakit;
use App\Models\ubahjadwal;
use App\Models\workscheadules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Termwind\Components\Raw;

class ApproveController extends Controller
{
    public function index()
    {
        $uuid = Session::get('uuid');
        $data['cuti'] = DB::select("SELECT employees.name, dr.val_name, units.name as unit, approve.*
        FROM `approve`
         JOIN cuti ON cuti.id = approve.id_permohonan 
        INNER JOIN d_references dr on dr.val=cuti.jenis_cuti and reference_id=1
        INNER JOIN employees ON employees.uuid = cuti.uuid_karyawan 
        INNER JOIN units ON employees.id_unit = units.id
        WHERE uuid_atasan = '$uuid' AND approve.approve IS NULL AND jenis_permohonan = 1");
// dd($data);
        $data['izin'] = DB::select("SELECT employees.name, units.name as unit, approve.*, d_references.val_name
        FROM `approve`
        INNER JOIN izin ON izin.id = approve.id_permohonan
        INNER JOIN employees ON employees.uuid = izin.uuid_karyawan
        INNER JOIN units ON employees.id_unit = units.id
        INNER JOIN d_references ON d_references.val = approve.jenis_permohonan and d_references.reference_id = 2
        WHERE uuid_atasan = '$uuid' AND approve.approve IS NULL AND approve.jenis_permohonan = 3 ");
// dd($data);
        $data['ubahjadwal'] = DB::select("SELECT pemohon.name AS pemohon_name, pengganti.name AS pengganti_name, d_references.val_name, units.name AS unit,  approve.*
        FROM `approve` 
        INNER JOIN ubahjadwal ON ubahjadwal.id = approve.id_permohonan 
        INNER JOIN employees AS pemohon ON pemohon.uuid = ubahjadwal.uuid_pemohon
        INNER JOIN employees AS pengganti ON pengganti.uuid = ubahjadwal.uuid_pengganti
        INNER JOIN units ON pemohon.id_unit = units.id
        -- INNER JOIN shifts AS sa ON sa.id = ubahjadwal.shift_awal  
        -- INNER JOIN shifts AS sp ON sp.id = ubahjadwal.shift_pengganti  
        INNER JOIN d_references ON d_references.val = approve.jenis_permohonan and d_references.reference_id = 2
        WHERE uuid_atasan = '$uuid' AND approve.approve IS NULL AND jenis_permohonan = 2");
// dd($data);
        $data['sakit'] = DB::select("SELECT sakit.*, approve.*,employees.name AS karyawan_name,  d_references.val_name, units.name AS unit
        FROM `approve`
        INNER JOIN sakit ON sakit.id = approve.id_permohonan
        INNER JOIN employees ON employees.uuid = sakit.uuid_karyawan
        INNER JOIN units ON employees.id_unit = units.id
        INNER JOIN d_references ON d_references.val = approve.jenis_permohonan
        WHERE uuid_atasan = '$uuid' AND approve.approve IS NULL AND jenis_permohonan = 4");

        // dd($data);
        // DB::enableQueryLog(); // Enable query log
        $data1['history'] = DB::select("SELECT 
        CASE 
            WHEN approve.jenis_permohonan = 'cuti' THEN e1.name 
            WHEN approve.jenis_permohonan = 'ubahjadwal' THEN e2.name 
            WHEN approve.jenis_permohonan = 'izin' THEN e3.name 
            WHEN approve.jenis_permohonan = 'sakit' THEN e4.name 
            ELSE NULL END as karyawan_name,
            e1.name as cuti_karyawan_name,
            e2.name as ubahjadwal_karyawan_name,
            e3.name as izin_karyawan_name,
            e4.name as sakit_karyawan_name,
        approve.*
        FROM `approve` 
        LEFT JOIN cuti ON cuti.id = approve.id_permohonan 
        LEFT JOIN employees as e1 ON e1.uuid = cuti.uuid_karyawan
        LEFT JOIN ubahjadwal ON ubahjadwal.id = approve.id_permohonan 
        LEFT JOIN employees as e2 ON e2.uuid = ubahjadwal.uuid_pemohon
        LEFT JOIN izin ON izin.id = approve.id_permohonan 
        LEFT JOIN employees as e3 ON e3.uuid = izin.uuid_karyawan
        LEFT JOIN sakit ON sakit.id = approve.id_permohonan 
        LEFT JOIN employees as e4 ON e4.uuid = sakit.uuid_karyawan
        WHERE uuid_atasan = ? AND approve IS NOT NULL
", [$uuid]);

// dd($data1);
       
    return view('pages/approve/index', compact('data','data1'));
    }
    public function data($get, Request $request)
    {
        if ($get === 'cuti') {
            $data = DB::select("SELECT e1.name, units.name as unit, cuti.*, e2.name as pengganti_name, dr.val_name FROM cuti
            LEFT JOIN employees e1 on e1.uuid=cuti.uuid_karyawan
            LEFT JOIN units on e1.id_unit=units.id
            LEFT JOIN d_references dr on dr.val=cuti.jenis_cuti and reference_id=1
            LEFT JOIN employees e2 on e2.uuid=cuti.karyawan_pengganti 
            where cuti.id=$request->id");

            $approve = DB::select("SELECT e1.*, approve.*, units.name as unit FROM `approve` 
            INNER JOIN employees e1 on e1.uuid=approve.uuid_atasan
            INNER JOIN units on e1.id_unit=units.id
            where approve.id_permohonan=$request->id and approve.jenis_permohonan=1");
            return response()->json(['cuti' => $data, 'approve' => $approve]);
        } else if ($get === 'izin') {
            $data = DB::select("SELECT e1.name, units.name as unit, izin.* FROM izin
            INNER JOIN employees e1 on e1.uuid=izin.uuid_karyawan
            INNER JOIN units on e1.id_unit=units.id
            where izin.id=$request->id");
            // dd($data);

            $approve = DB::select("SELECT e1.*, approve.*, units.name as unit FROM `approve` 
            INNER JOIN employees e1 on e1.uuid=approve.uuid_atasan 
            INNER JOIN units on e1.id_unit=units.id
            where approve.id_permohonan=$request->id and approve.jenis_permohonan=3");
            return response()->json(['izin'=> $data, 'approve' => $approve]);
        } else if ($get === 'ubahjadwal') {
            $data = DB::select("SELECT e1.name,e2.name as pengganti, units.name as unit,sa.name AS shift_name, sp.name AS shift_names, ubahjadwal.* FROM ubahjadwal
            INNER JOIN employees e1 on e1.uuid=ubahjadwal.uuid_pemohon
            INNER JOIN employees e2 on e2.uuid=ubahjadwal.uuid_pengganti
            INNER JOIN shifts AS sa ON sa.id = ubahjadwal.shift_awal  
            INNER JOIN shifts AS sp ON sp.id = ubahjadwal.shift_pengganti 
            INNER JOIN units on e1.id_unit=units.id
            where ubahjadwal.id=$request->id");

            $approve = DB::select("SELECT e1.*, approve.*, units.name as unit FROM `approve` 
            INNER JOIN employees e1 on e1.uuid=approve.uuid_atasan 
            INNER JOIN units on e1.id_unit=units.id
            where approve.id_permohonan=$request->id and approve.jenis_permohonan=2");
            return response()->json(['ubahjadwal' => $data, 'approve' => $approve]);
        } else if ($get === 'sakit') {
            
            $data = DB::select("SELECT sakit.*, employees.name AS karyawan_name, units.name AS unit_name
            FROM sakit
            INNER JOIN employees ON employees.uuid = sakit.uuid_karyawan
            INNER JOIN units ON employees.id_unit = units.id
            WHERE sakit.id =  $request->id");
            // dd($data);
            $approve = DB::select("SELECT e1.*, approve.*, units.name as unit FROM approve
                INNER JOIN employees e1 on e1.uuid = approve.uuid_atasan
                INNER JOIN units on e1.id_unit = units.id
                WHERE approve.id_permohonan = $request->id and approve.jenis_permohonan=4");
            // Kembalikan response JSON
            return response()->json(['sakit' => $data, 'approve' => $approve]);
        }
        
    }
    public function store($get, Request $request){
        $uuid = Session::get('uuid');
        
// date_default_timezone_set('Asia/Jakarta');
// $realtime = date('H:i:s');
        approve::where([
            ['id_permohonan','=',$request->id_permohonan],
            ['jenis_permohonan','=',$request->jenis_permohonan],
            ['uuid_atasan','=',$uuid]
        ]);
        try {
            Approve::where([
                ['id_permohonan','=',$request->id_permohonan],
                ['jenis_permohonan','=',$request->jenis_permohonan],
                ['uuid_atasan','=',$uuid]
            ])->update([
                'approve'=>$get === 'approved' ? 1:0,
                'approve_date'=>date('Y-m-d h:m:s'),
            ]);
            $data = Approve::where(['id_permohonan'=>$request->id_permohonan,'jenis_permohonan'=>$request->jenis_permohonan])->get();
            $count = 0;
            foreach ($data as $key => $value) {
                if($value->approve == 1 && $value->approve_date != null){
                    $count = $count + 1;
                }
            }
            // dd(count($data));
            if($count === count($data)){
                switch ($request->jenis_permohonan) {
                    case '1': // cuti
                        try {
                            cuti::where('id', $request->id_permohonan)
                                ->update([
                                    'status' => 1
                                ]);
                                
                            $cuti = cuti::where('id', '=', $request->id_permohonan)->first();//ambil data cuti
                    
                            $tanggal_cuti = d_cuti::where('id_cuti', '=', $request->id_permohonan)->get();//ambil tangl_cti
                    
                          
                            foreach ($tanggal_cuti as $d_cuti) {
                                $currentDate = new \DateTime($d_cuti->tanggal_cuti);
                                    //ambil data wc pemohon
                                $shift_pemohon = workscheadules::where([
                                    'tanggal' => $currentDate->format('Y-m-d'),
                                    'uuid_employees' => $cuti->uuid_karyawan
                                ])->first();
                    
                                if ($shift_pemohon->shift_id === 4) {
                                    continue; 
                                }
                    //update jadwal pemohon
                                workscheadules::where([
                                    'tanggal' => $currentDate->format('Y-m-d'),
                                    'uuid_employees' => $cuti->uuid_karyawan
                                ])->update(['shift_id' => 7]);
                    
                    //update jadwal pengganti
                               
                                // workscheadules::where([
                                //     'tanggal' => $currentDate->format('Y-m-d'),
                                //     'uuid_employees' => $cuti->karyawan_pengganti
                                // ])->update(['shift_id' => $shift_pemohon->shift_id]);
                            }
                        } catch (\Throwable $th) {
                            dd($th);
                        }
                        break;
                        case '2': // tukar shift
                            try {
                                ubahjadwal::where('id', $request->id_permohonan)
                                    ->update(['status' => 1]);
                        
                                $ubahjadwal = ubahjadwal::find($request->id_permohonan);
                                // if (!$ubahjadwal) {
                                // }
                        
                                $startDate = new \DateTime($ubahjadwal->tanggal_perubahan);
                                $endDate = clone $startDate;
                                $endDate->modify('+1 day');
                        
    
                                $jadwal = workscheadules::whereBetween('tanggal', [
                                        $startDate->format('Y-m-d'),
                                        $endDate->format('Y-m-d')
                                    ])
                                    ->whereIn('uuid_employees', [$ubahjadwal->uuid_pemohon, $ubahjadwal->uuid_pengganti])
                                    ->get();
                        
                                if ($jadwal->isNotEmpty()) {
                                    $currentDate = clone $startDate;
                        
                        
                                    while ($currentDate <= $endDate) {
                                       
                                        $shiftPemohon = workscheadules::where([
                                            'tanggal' => $currentDate->format('Y-m-d'),
                                            'uuid_employees' => $ubahjadwal->uuid_pemohon
                                        ])->first();
                        
                                        $shiftPengganti = workscheadules::where([
                                            'tanggal' => $currentDate->format('Y-m-d'),
                                            'uuid_employees' =>  $ubahjadwal->uuid_pengganti
                                        ])->first();
                                        if ($shiftPemohon && $shiftPengganti) {
                                            $tempShiftId = $shiftPemohon->shift_id;
                                            $shiftPemohon->update(['shift_id' => $shiftPengganti->shift_id]);
                                            $shiftPengganti->update(['shift_id' => $tempShiftId]);
                                        }       
                                        $currentDate->modify('+1 day');
                                    }
                                }
                            } catch (\Throwable $th) {
                                dd($th);
                            }
                            break;
                                                                    
                        
                    case '3'://izin
                        Izin::where('id', '=', $request->id_permohonan)
                        ->update(['status' => 1]);
                        break;
                    case '4'://sakit
                        try {
                            
                            Sakit::where('id', '=', $request->id_permohonan)
                                ->update(['status' => 1]);
                    
                            $data = Sakit::where('id', '=', $request->id_permohonan)->first();
                    
                            // tanggal akhir sakit
                            $endDate = date('Y-m-d', strtotime('+' . $data->days . ' days', strtotime($data->tanggal)));
                    
                            $jadwal = workscheadules::whereBetween('tanggal', [$data->tanggal, $endDate])
                                ->where(['uuid_employees' => $data->uuid_karyawan])
                                ->get();
                    
                           
                            if ($jadwal->isNotEmpty()) {
                                $sickDaysCount = 0; 
                                $currentDate = new \DateTime($data->tanggal); 
                    
                                while ($sickDaysCount < $data->days) {
                                    // Cek apakah tanggal ini sudah ada dalam jadwal
                                    $shift = $jadwal->firstWhere('tanggal', $currentDate->format('Y-m-d'));
                    
                                   
                                    // if ($shift && $shift->shift_id === 4) {
                                    //     $currentDate->modify('+1 day');
                                    //     continue; 
                                    // }
                    
                                    workscheadules::where(['tanggal' => $currentDate->format('Y-m-d'), 'uuid_employees' => $data->uuid_karyawan])
                                        ->update(['shift_id' => 8]);
                    
                                    // Tambah hitung hari sakit yang ditambahkan
                                    $sickDaysCount++;
                    
                                    // Pindah ke hari berikutnya
                                    $currentDate->modify('+1 day');
                                }
                            }
                        } catch (\Throwable $th) {
                            // Tangani error dengan debug
                            dd($th);
                        }
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }

            // if ($get === 'Approved') {
            //     cuti::where('id_permohonan', '=', $request->id_permohonan)
            //         ->update([
            //             'status' => 1
            //         ]);
            // }
            return response()->json(['metadata'=>[
                    'code'=>200, 
                    'message'=>'Berhasil di update',
                    'data'=>$data
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
        // return response();
    }
}
