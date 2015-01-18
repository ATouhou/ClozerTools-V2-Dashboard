<?php
class Timelog extends Eloquent
{
    	public static $timestamps = true;
    	public static $table = "timelog";

    	public function user(){
    		return $this->belongs_to('User','user_id');
    	}

    	
}