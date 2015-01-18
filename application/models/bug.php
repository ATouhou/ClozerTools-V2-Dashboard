<?php
class Bug extends Eloquent
{
    public static $timestamps = true;
    public static $table = "bugs";

    public function user(){
        return $this->belongs_to('User','user_id');
    }

    public function thread(){
    	return $this->has_many('Bug','thread_id');
    }

    


}