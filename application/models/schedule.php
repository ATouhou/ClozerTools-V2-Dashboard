<?php
class Schedule extends Eloquent
{
    	public static $timestamps = false;
    	public static $table = "schedule";
   	
   	public function user(){
   		return $this->has_one('User','user_id');
   	}
}