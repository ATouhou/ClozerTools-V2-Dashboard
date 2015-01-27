<?php
class StatusPipeline extends Eloquent
{
    public static $timestamps = false;
    public static $table = "pipeline_status";

    public static function getPipeline(){
    	return StatusPipeline::where('tenant_id','=',Auth::user()->tenant_id)->get();
    }

}