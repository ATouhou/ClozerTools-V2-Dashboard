<?php
class GameHistory extends Eloquent
{
    public static $timestamps = true;
    public static $table = "game_history";
   
   

    public function game(){
        return $this->belongs_to('Game','game_id');
    }
    
    public function user(){
    	return $this->belongs_to('User','user_id');
    }

    public function lead(){
        return $this->belongs_to('Lead','lead_id');
    }

    public function appt(){
        return $this->belongs_to('Appointment','appt_id');
    }

    public function historyMessage(){
      if($this->points==1){
            $suf = "Point ";
        } else {
            $suf = " Points ";
        }
      $msg = str_replace("||",$this->points. " ".$suf,$this->message);
      return $msg;
    }
    
    //*****USER STATIC FUNCTIONS*****//
    public static function writeHistory($game,$appt,$type,$user_id,$msg=null){
      $user = User::find($user_id);
      if($user){
        if($msg==null){
          $msg = " Earned || " ;
        }
        $points = Game::points($type);
        $history = New GameHistory;
        $history->game_id = $game;
        $history->user_id = $user->id;
        $history->user_type = $user->user_type;
        $history->lead_id = $appt->lead->id;
        $history->appt_id = $appt->id;
        $history->points = $points;
        if($type=="SOLD" || $type=="BOOKSOLD"){
          $check = GameHistory::where('sale_id','=',$appt->sale_id)->where('user_id','=',$user->id)->first();
          if($check){
            return false;
          }
          $history->sale_id = $appt->sale_id;
          $msg.=" for a SOLD DEMO";
          $history->history_date = $appt->app_date;
        } else if($type=="DNS"){
          $check = GameHistory::where('sale_id','=',$appt->sale_id)->where('user_id','=',$user->id)->first();
          if($check){
            $user->decrementPoints($check->points);
            $check->delete();
          }
          $msg.=" for a DNS DEMO";
          $history->history_date = $appt->app_date;
        } else if($type=="BOOK"){
          $msg.=" for a BOOKED DEMO";
          $history->history_date = $appt->booked_at;
        } else if($type=="PUTON"){
          $msg.=" for a PUT ON DEMO";
          $history->history_date = $appt->app_date;
        } else if($type=="PICKUP"){

        } else if($type==""){
          
        }
        $history->message = $msg;
        $history->type = $type;
        $history->user_type = $user->user_type;
        $user->incrementPoints($points);
        $user->save();
        $history->save();
      }
    }

}