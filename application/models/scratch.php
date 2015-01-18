<?php
class Scratch extends Eloquent
{
    public static $timestamps = true;
    public static $table = "scratch_batch";

    public function lead(){
    	return $this->has_many('Lead','scratch_id');
    }


}