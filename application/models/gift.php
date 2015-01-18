<?php
class Gift extends Eloquent
{
    	public static $timestamps = false;
    	public static $table = "gifts";

    	public function history(){
    		return $this->has_many('GiftTracker','gift_id');
    	}

    	public function qty(){
    		return GiftTracker::where('gift_id','=',$this->id)->sum('qty');
    	}

    	public function total_cost(){
    		return GiftTracker::where('gift_id','=',$this->id)->sum('cost');
    	}

    	

}