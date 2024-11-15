<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

    if(!function_exists('getMenus')){
        function getMenus(){
            $uuid = Auth::user()->uuid;
            $pj = DB::select("select * from d_units where uuid_pj = '$uuid'");
            if(count($pj)>0){
                $menu = DB::select("select * from menus where id not in (2) and header_id is null order by ID asc");
            }else{
                $menu = DB::select("select * from menus where id not in (2, 5) and header_id is null order by ID asc");
            }
            // switch ($unit) {
            //     case '':
            //         # code...
            //         break;
                
            //     default:
            //         # code...
            //         break;
            // }
            return $menu;
        }
    }
    if(!function_exists('getSubMenu')){
        function getSubMenu($id){
            $menu = DB::select("select * from menus where header_id='$id'");
            return $menu;
        }
    }
    if(!function_exists('breadcrumbs')){
        function breadcrumbs($key,$title=null){
            // $breadcrumbs = Breadcrumbs::render($key, $title);
            // return $breadcrumbs;
        }
    }
