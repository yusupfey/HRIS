<?php

    use Illuminate\Support\Facades\DB;

    if(!function_exists('getMenus')){
        function getMenus(){
            $menu = DB::select("select * from menus where header_id is null order by ID asc");
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
?>