<?php
class Quadrant extends Eloquent
{
    	public static $timestamps = true;
    	public static $table = "quadrants";

   	public function city(){
    		return $this->belongs_to('City');
   	}
}