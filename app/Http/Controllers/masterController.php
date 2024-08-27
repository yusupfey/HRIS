<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Menu;
use App\Models\Reference;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\Dd;
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
                case 'unit':
                    $data['title'] = 'Master Unit';
                    $data['employe'] = Employee::get();
                    // dd($data['employe']);
                    return view('master/index', compact('data'));
                    
                    break;
                case 'reference':
                    $data['title'] = 'Master Reference';
                    $data['reference'] = Reference::get();
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
                    $data['satuan'] = Reference::get();
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
                $query = Reference::get();
                return DataTables::of($query)->addColumn('Action', function($val){
                    return '<div>
                    <button onclick="modalReference(`update`, {id:'.$val->id.', reference:`'.$val->reference.'`})" class="btn btn-warning"><i class="tf-icons bx bx-edit"></i></button>
                    <a href="/reference/'.$val->id.'" class="btn btn-info"><i class="tf-icons bx bx-info-circle"></i></a>
                    <a href="#" class="btn btn-danger"><i class="tf-icons bx bx-trash"></i></a>
                    </div>';
                })->rawColumns(['Action'])->make(true);

                break;
            case 'unit':
                $query = Unit::get();
                return response()->json($query);

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
            if($section ==='reference'){
                $validation = Validator::make($req->all(), [
                    'reference' => ['Required'],
                ]);
                if($validation->fails()){
                    return response()->json(['code'=>422,'errors'=>$validation->errors()], 422);
                }
                try {
                    Reference::create($req->all());

                    return response()->json(['code'=>200,'messege'=>'Berhasil'],200);
                } catch (\Throwable $th) {
                    return response()->json(['code'=>200,'error'=>$th]);
                }
            }
            if($section ==='reference_d'){
                $validation = Validator::make($req->all(), [
                    'reference_id' => ['Required'],
                    'val_name' => ['Required'],
                    'val' => ['Required'],
                ]);
                if($validation->fails()){
                    return response()->json(['code'=>422,'errors'=>$validation->errors()], 422);
                }
                try {
                    DB::table('d_references')->insert([
                        'reference_id' => $req->reference_id,
                        'val_name' => $req->val_name,
                        'val' => $req->val,
                    ]);

                    return response()->json(['code'=>200,'messege'=>'Berhasil'],200);
                } catch (\Throwable $th) {
                    return response()->json(['code'=>200,'error'=>$th]);
                }
            }
            if($section ==='unit'){
                $validation = Validator::make($req->all(), [
                    'name' => ['Required'],
                    'kepala_unit' => ['Required'],
                ]);
                if($validation->fails()){
                    return response()->json(['code'=>422,'errors'=>$validation->errors()]);
                }
                Unit::create($req->all());
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
            if($section ==='head-unit'){
                $data = json_decode($req->data);
                // dd($data);
                $val='';

                function setChild($id,$children){
                    foreach ($children as $key => $item) {
                        // dd($item->id);
                        Unit::where('id', $item->id)->update(['id_head_unit'=>$id]);
                        if(isset($item->children)){
                            setChild($item->id,$item->children);
                        }
                    }
                }
                foreach ($data as $key => $value) {
                    // dd($value->children);
                    if(count($value->children)>0){
                        // var_dump($value->children);
                        // dd('masuk sini');
                        setChild($value->id,$value->children);
                        
                    }else{
                        Unit::where('id', $value->id)->update(['id_head_unit'=>null]);
                    }
                    # code...
                }
                return response()->json(['code'=>200,'messege'=>'Berhasil', 'data'=>$data],200);

            }
            if($section ==='reference'){
                $validation = Validator::make($req->all(), [
                    'reference' => ['Required'],
                ]);
                if($validation->fails()){
                    return response()->json(['code'=>422,'errors'=>$validation->errors()], 422);
                }
                try {

                    return response()->json(['code'=>200,'messege'=>'Berhasil'],200);
                } catch (\Throwable $th) {
                    return response()->json(['code'=>200,'error'=>$th]);
                }
            }
            if($section ==='reference_d'){
                $validation = Validator::make($req->all(), [
                    'reference_id' => ['Required'],
                    'val_name' => ['Required'],
                    'val' => ['Required'],
                ]);
                if($validation->fails()){
                    return response()->json(['code'=>422,'errors'=>$validation->errors()], 422);
                }
                try {
                    DB::table('d_references')->where('id', $req->id)->update([
                        'val_name' => $req->val_name,
                        'val' => $req->val,
                    ]);

                    return response()->json(['code'=>200,'messege'=>'Berhasil'],200);
                } catch (\Throwable $th) {
                    return response()->json(['code'=>200,'error'=>$th]);
                }
            }
        }

        return response()->json('true');
    }
}
