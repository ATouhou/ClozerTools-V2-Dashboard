<?php
class GameUser extends Eloquent
{
    public static $timestamps = true;
    public static $table = "game_users";

    public function game(){
        return $this->belongs_to('Game','game_id');
    }
    
    public function users(){
    	return $this->belongs_to('User','user_id');
    }
    


}