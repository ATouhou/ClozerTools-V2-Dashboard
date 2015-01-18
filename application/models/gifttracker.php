<?php
class GiftTracker extends Eloquent
{
    	public static $timestamps = false;
    	public static $table = "gift_tracker";

    	public function gift(){
    		return $this->belongs_to('Gift');
    	}

    	public function user(){
    		return $this->belongs_to('User');
    	}

    	public function lead(){
    		return $this->belongs_to('Lead');
    	}

        public static function writeHistory($appointment,$result){
            $user = $appointment->rep_id;
            $lead_id = $appointment->lead_id;
            $gift = Gift::where('name','=',$appointment->lead->gift)->first();
            if($gift){
                $check = GiftTracker::where('lead_id','=',$lead_id)->first();
                if($check){
                    $gt = $check;
                } else {
                    $gt = New GiftTracker;
                };
                $u = User::find($user);
                
                $gt->gift_id = $gift->id;
                $gt->lead_id = $lead_id;
                $gt->qty = -1;
                $gt->type = "sell";
                $gt->result = $result;
                $gt->cost = 0;
                $gt->user_id = $user;
                $gt->comment = $u->fullName()." gave a ".$gift->name." away at demo. | Lead # ".$lead_id." | ".$appointment->lead->cust_name;
                $gt->save();
                
            }

        }

}