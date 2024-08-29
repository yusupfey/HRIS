<?php

namespace App\Http\Controllers;
use App\Models\shift;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Symfony\Contracts\Service\Attribute\Required;

class shiftController extends Controller
{
    public function index(){
        $shift = shift::get();
        return view('pages.shift.index', compact('shift'));
    }
    public function  tambahshift() {

        return view('pages.shift.tambahshift');
    }
    public function formupdate($id){
      // $shift = DB::select("SELECT * FROM shifts WHERE  id=$id");
      $shift = shift::where('id',$id)->first();
      // dd($shift);
      return view('pages.shift.updateshift',compact('shift'));
    }
    public function input(Request $request){
        $shift =$request->validate([
            "name"=>"Required",

        ]);
        $shift['jam'] = $request->jam;
        $shift['checkin_time'] = $request->checkin_time;
        $shift['checkout_time'] = $request->checkout_time;



        shift::insert($shift);
        session::flash('success','berhasil menambah data');
        return redirect('/shift');

    }
    public function hapus($shift){
        $shift = shift::find($shift);
        $shift->delete();
        return redirect('/shift')->with('success','berhasil menghapus data');

    }
    public function update(Request $request){
      $shift =$request->validate([
        "name"=>"Required",
      ]);
    $shift['jam'] = $request->jam;
    $shift['checkin_time'] = $request->checkin_time;
    $shift['checkout_time'] = $request->checkout_time;

    $shift = shift::where('id',$request->id)->update($shift);
    return redirect('/shift');
    }


}
