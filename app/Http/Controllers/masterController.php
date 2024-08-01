<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class masterController extends Controller
{
    public function index()
    {
        return view('master/index');
    }
    public function store(Request $req, $section){
        $user = Session::get('username');
        if($req->mode =='input'){
            
            if($section ==='menu_d'){
                // $req->validate([
                //     'name' => ['Required'],
                //     'Href' => ['Required'],
                //     'Level' => ['Required'],
                // ]);
                try {
                    $validation = Validator::make($req->all(), [
                        'name' => ['Required'],
                        'href' => ['Required'],
                    ]);
                    if($validation->fails()){
                        return response()->json(['code'=>422,'errors'=>$validation->errors()]);
                    }
                    try {
                        Menu::create($req->all());
    
                        return response()->json(['code'=>200,'messege'=>'Berhasil'],200);
                    } catch (\Throwable $th) {
                        return response()->json(['code'=>200,'error'=>$th]);
                    }
                } catch (\Throwable $th) {
                    return response()->json($th);
                }
            }
            if($section ==='menu'){
                $validation = Validator::make($req->all(), [
                    'name' => ['Required'],
                    'href' => ['Required'],
                    'icon' => ['Required'],
                ]);
                // $validation['order'] = $req->order;
                // $validation['inactive_date'] = null;
                if($validation->fails()){
                    return response()->json(['code'=>422,'errors'=>$validation->errors()]);
                }
                try {
                    Menu::create($req->all());

                    return response()->json(['code'=>200,'messege'=>'Berhasil'],200);
                } catch (\Throwable $th) {
                    return response()->json(['code'=>200,'error'=>$th]);
                }
            }
        }else{

        }
    }
    public function form($form,$section,$id=null)
    {
        if($form == 'form-input'){
            switch ($section) {
                case 'menu':
                    $data['title'] = 'Master Menu';
                    return view('master/index', compact('data'));
                    
                    break;
                case 'reference':
                    $data['title'] = 'Master Reference';
                    $data['satuan'] = DB::table('references')->get();;
                    return view('master/index', compact('data'));
                    break;
            }
        }else if($form == 'form-update'){
            switch ($section) {
                case 'menu':
                    $data['title'] = 'From Update';
                    $data['header'] = DB::table('menus')->where('id', $id)->first();
                    $data['detail'] = DB::table('menus')->where('header_id', $id)->get();
                    // dd($data['detail']);
                    return view('master/index', compact('data'));
                    
                    break;
                case 'reference':
                    $data['title'] = 'Master Reference';
                    $data['satuan'] = DB::select('select * from T_reference');
                    return view('master/index', compact('data'));
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
    public function data($section)
    {
        switch ($section) {
            case 'user':
                $query = DB::select('select * from users');
                return DataTables::of($query)->toJson();

                break;
            case 'menu':
                $query = DB::select('select * from menus where header_id is null');
                return DataTables::of($query)->
                addColumn('Action', function($val){
                    return '<div>
                    <a href="/master/form-update/menu/'.$val->id.'" class="btn btn-warning"><i class="tf-icons bx bx-edit"></i></a>
                    <a href="#" class="btn btn-info"><i class="tf-icons bx bx-info-circle"></i></a>
                    <a href="#" class="btn btn-danger"><i class="tf-icons bx bx-trash"></i></a>
                    </div>';
                })->rawColumns(['Action'])->make(true);

                break;
            case 'reference':
                $query = DB::table('references')->get();
                return DataTables::of($query)->toJson();

                break;
                
            default:
                # code...
                break;
        }
    }


    public function post($section, Request $req)
    {
        // dd($section);
        $user = Session::get('username');
        if($req->mode =='input'){
            
            if($section ==='menu_d'){
                // $req->validate([
                //     'name' => ['Required'],
                //     'Href' => ['Required'],
                //     'Level' => ['Required'],
                // ]);
                try {
                    $validation = Validator::make($req->all(), [
                        'name' => ['Required'],
                        'href' => ['Required'],
                    ]);
                    if($validation->fails()){
                        return response()->json(['code'=>422,'errors'=>$validation->errors()]);
                    }
                    try {
                        Menu::create($req->all());
    
                        return response()->json(['code'=>200,'messege'=>'Berhasil'],200);
                    } catch (\Throwable $th) {
                        return response()->json(['code'=>200,'error'=>$th]);
                    }
                } catch (\Throwable $th) {
                    return response()->json($th);
                }
            }
            if($section ==='menu'){
                $validation = Validator::make($req->all(), [
                    'name' => ['Required'],
                    'href' => ['Required'],
                    'icon' => ['Required'],
                ]);
                // $validation['order'] = $req->order;
                // $validation['inactive_date'] = null;
                if($validation->fails()){
                    return response()->json(['code'=>422,'errors'=>$validation->errors()]);
                }
                try {
                    Menu::create($req->all());

                    return response()->json(['code'=>200,'messege'=>'Berhasil'],200);
                } catch (\Throwable $th) {
                    return response()->json(['code'=>200,'error'=>$th]);
                }
            }
        }else{
            if($section ==='menu_d'){
                try {
                    DB::statement("EXEC sp_update_menu_D 
                    @ID=$req->ID, 
                    @Name='$req->Name', 
                    @href='$req->Href',
                    @level='$req->Level',
                    @up_user='$user'
                    ");

                    return response()->json(['code'=>200,'messege'=>'Berhasil'],200);
                } catch (\Throwable $th) {
                    return response()->json($th);
                }
            }
            if($section ==='menu'){
                $req->validate([
                    'Name' => ['Required'],
                    'Href' => ['Required'],
                    'Icon' => ['Required'],
                ]);
                try {
                    DB::statement("EXEC sp_insert_menu
                    @Name='$req->Name', 
                    @Icon='$req->Href',
                    @Href='$req->Href',
                    @level='$req->Level',
                    @in_user='$user'
                    ");

                    return response()->json(['code'=>200,'messege'=>'Berhasil'],200);
                } catch (\Throwable $th) {
                    return response()->json($th);
                }
            }
        }

        return response()->json('true');
    }
}
