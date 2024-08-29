<?php


namespace App\Http\Controllers;


use App\Models\Employee;
use App\Models\workscheadules;
use App\Models\shift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class MyJadwalController extends Controller
{
   public function index($uuid)
   {
       // ambil data employee berdasarkan uuid
       $employee = Employee::where('uuid', $uuid)->firstOrFail();



       // dapetin tanggal sekarang
       $today = \Carbon\Carbon::today()->format('Y-m-d');


       // dapetin tanggal akhir data yang tersedia
       $endDate = DB::table('worksheadules')
                   ->where('uuid_employees', $uuid)
                   ->max('tanggal'); 
    // Mengambil tanggal terakhir yang tersedia
    // dd($endDate);

       // Jika tidak ada data tanggal terakhir, set endDate sebagai hari ini
       $endDate = $endDate ?: $today;


       // ambil data worksheadules berdasarkan uuid employee dan jarak tanggal dengan page
       $worksheadulesQuery = DB::table('worksheadules as w')
           ->select('w.*', 'e.id_unit', 's.checkout_time', 's.checkin_time')
           ->join('employees as e', 'w.uuid_employees', '=', 'e.uuid')
           ->join('shifts as s', 'w.shift_id', '=', 's.id')
           ->where('w.uuid_employees', $uuid)
           ->whereBetween('w.tanggal', [$today, $endDate]) // Pastikan rentang tanggal konsisten
           ->orderBy('w.tanggal', 'asc');


       // Ambil data untuk hari ini terpisah
       $todayWork = $worksheadulesQuery->clone()->where('w.tanggal', $today)->first();


       // Paginasi data
       $worksheadules = $worksheadulesQuery->paginate(5);


       // Jika data hari ini tidak ada dalam halaman pertama, tambahkan secara manual
       if ($todayWork && !$worksheadules->contains('tanggal', $today)) {
           $worksheadules->prepend($todayWork);
       }


       // Mengirimkan data ke view
       return view('myjadwal.index', compact('worksheadules', 'employee', 'today', 'endDate'));
   }














}
