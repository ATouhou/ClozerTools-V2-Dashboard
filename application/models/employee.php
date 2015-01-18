<?php
class Employee extends Eloquent
{
    public static $timestamps = true;
    public static $table = "employees";

    public function user(){
    	return $this->has_one('User','user_id');
    }



}