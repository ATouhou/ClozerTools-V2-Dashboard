<?php
class GridModule extends Eloquent
{
    public static $timestamps = false;
    public static $table = "system_layouts";

    public static function myModules(){
    	return GridModule::where('tenant_id','=',Auth::user()->tenant_id)->get();
    }
    
    
    
}