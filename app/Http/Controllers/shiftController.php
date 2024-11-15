<?php

namespace App\Http\Controllers;
use App\Models\shift;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Symfony\Contracts\Service\Attribute\Required;

class shiftController extends Controller
{
    public function index(){
      $shifts = Shift::with('unit')->get();
      // dd($shifts);
        return view('pages.shift.index', compact('shifts'));
    }
    public function tambahshift() {
      $units = Unit::all(); 
      // dd($units);
      return view('pages.shift.tambahshift', compact('units')); // Kirim data unit ke tampilan
  }
   
  public function input(Request $request) {
    $shift = $request->validate([
        "name" => "required",
    ]);
    
    $shift['checkin_time'] = $request->checkin_time;
    $shift['checkout_time'] = $request->checkout_time;
    $shift['id_unit'] = $request->id_unit ?? null;

    Shift::create($shift); // Simpan data shift
    Session::flash('success', 'Berhasil menambah data');
    return redirect('/shift');
}
public function formupdate($id){
    // $shift = DB::select("SELECT * FROM shifts WHERE  id=$id");
    $shift = shift::where('id',$id)->first();
    $units = Unit::all(); 

    return view('pages.shift.updateshift',compact('shift','units'));
  }
  
   
    public function update(Request $request){
      $shift =$request->validate([
        "name"=>"Required",
      ]);
    $shift['jam'] = $request->jam;
    $shift['checkin_time'] = $request->checkin_time;
    $shift['checkout_time'] = $request->checkout_time;

    $shift = shift::where('id',$request->id)->update($shift);
    return redirect('/shift')->with('success','Update Success');
    }
    public function hapus($shift){
      $shift = shift::find($shift);
      if($shift){

        $shift->delete();
        return redirect('/shift')->with('success','berhasil menghapus data');
      }
      return redirect()->back()->with('error', 'Data tidak ditemukan!');

  }
  


}
