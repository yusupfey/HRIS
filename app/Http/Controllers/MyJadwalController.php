<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\WorkSchedule; // Pastikan nama model sesuai
use App\Models\Shift; // Pastikan nama model sesuai
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MyJadwalController extends Controller
{
    public function index($uuid)
    {
        // Ambil data employee berdasarkan uuid
        $employee = Employee::with('unit')->where('uuid', $uuid)->firstOrFail();

        // Dapatkan tanggal hari ini
        $today = \Carbon\Carbon::today()->format('Y-m-d');
        // Dapatkan tanggal akhir data yang tersedia
        $endDate = DB::table('worksheadules')  
            ->where('uuid_employees', $uuid)
            ->max('tanggal');

        // Jika tidak ada data tanggal terakhir, set endDate sebagai hari ini
        $endDate = $endDate ?: $today;

        // Ambil data worksheadules berdasarkan uuid employee dan jarak tanggal dengan page
        $worksheadulesQuery = DB::table('worksheadules as w')
            ->select('w.*', 'e.id_unit', 's.checkout_time', 's.checkin_time', 's.name as shift_name') // Ambil nama shift
            ->join('employees as e', 'w.uuid_employees', '=', 'e.uuid')
            ->join('shifts as s', 'w.shift_id', '=', 's.id')
            ->where('w.uuid_employees', $uuid)
            ->whereBetween('w.tanggal', [$today, $endDate])
            ->orderBy('w.tanggal', 'asc');

        // Ambil data untuk hari ini terpisah
        $todayWork = $worksheadulesQuery->clone()->where('w.tanggal', $today)->first();

        // Paginasi data
        $worksheadules = $worksheadulesQuery->paginate(15);

        // Jika data hari ini tidak ada dalam halaman pertama, tambahkan secara manual
        // if ($todayWork && !$worksheadules->contains('tanggal', $today)) {
        //     $worksheadules->prepend($todayWork);
        // }
        return view('myjadwal.index', compact('worksheadules', 'employee', 'today', 'endDate'));
    }
}
