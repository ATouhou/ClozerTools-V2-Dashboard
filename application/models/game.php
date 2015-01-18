<?php
class Game extends Eloquent
{
    public static $timestamps = true;
    public static $table = "gameification";

    public function user(){
        return $this->has_many('GameUser','game_id');
    }

    public function badgeImage(){
        $url = URL::to_asset('img/badges/').$this->badge_image;
    	return $url;
    }

    public static function allGames(){
    	return Game::where('id','>',12)->get();
    }

    public static function points($type){
        if($type=="BOOK"){
            return 1;
            //return Setting::find(1)->points_book;
        } else if($type=="PUTON"){
            return 1;
            //return Setting::find(1)->points_puton;
        } else if($type=="BOOKSOLD"){
            return 1;
            //return Setting::find(1)->points_puton;
        }  else if($type=="SOLD"){
            return 5;
            //return Setting::find(1)->points_puton;
        } else if($type=="DNS"){
            return 1;
            //return Setting::find(1)->points_puton;
        } else if($type=="PICKEDUP"){
            return 1;
            //return Setting::find(1)->points_puton;
        } else if($type=="GUNIT"){
            return 1;
            //return Setting::find(1)->points_puton;
        }else if($type=="CONGRATS"){
            return 1;
            //return Setting::find(1)->points_puton;
        } else {
            return 0;
        }
    }

}