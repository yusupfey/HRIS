<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferenceController extends Controller
{
    public function index($id){
        $data['title'] = 'Reference';
        $data['reference'] = Reference::where('id', $id)->first();
        $data['reference_d'] = DB::table('d_references')->where('reference_id', $id)->get();

        return view('/ReferenceInfo/index', compact('data'));
    }
}
