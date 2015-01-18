<?php
class Doc extends Eloquent
{
    public static $timestamps = true;
    public static $table = "docs";

    public function user(){
        return $this->has_one('User');
    }

    public function lead(){
        return $this->has_one('Lead');
    }

    public function sale(){
        return $this->has_one('Sale');
    }


}