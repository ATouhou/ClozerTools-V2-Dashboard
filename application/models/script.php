<?php
class Script extends Eloquent
{
    	public static $timestamps = true;
    	public static $table="scripts";

    	public function objections(){
	    	return Script::where('type','=','objection')->get();
    	}

    	public static function getScripts($lead){
    		
    		$gifts = City::where('cityname','=',$lead->city)->first();
        	if(!empty($gifts)){
			 	$arr = array($gifts->attributes['gift_one'],$gifts->attributes['gift_two'],$gifts->attributes['gift_three'],$gifts->attributes['gift_four']);
			 } else {
			 	$arr = array();
			 }
		$thescripts=array();
		if(empty($lead->address)){$address="No Address On File....ENTER ONE ABOVE";} else {$address = $lead->address.", ".$lead->city;}
   		$scripts = Script::where('type','!=','objection')->get();

   			foreach($scripts as $val){
   			$s = str_replace("[[NAME]]","<strong><span class='scriptval-booker_name'>".Auth::user()->firstname."</span></strong>",$val->script);
			$s = str_replace("[[CUSTNAME]]","<strong><span class='scriptval-cust_name'>".$lead->cust_name."</span></strong>",$s);
			$s = str_replace("[[SPOUSENAME]]","<strong><span class='scriptval-spouse_name'>".$lead->spouse_name."</span></strong>",$s);
			$s = str_replace("[[APPDATE]]","<span class='label label-info special'><span class='scriptval-address'>".$lead->app_date."</span></span><br>",$s);
			$s = str_replace("[[ADDRESS]]","<span class='label label-info special'><span class='scriptval-address'>".$address."</span></span><br><br>",$s);
			$s = str_replace("[[CHOSEN-GIFT]]","<span class='label label-info special'><span class='scriptval-gift'>".$lead->gift."</span></span><br><br>",$s);
			$type=$val->type;
			
			$g = "";$c=0;
			
			foreach($arr as $val){
				$c++;
				switch ($c) {
    				case 1:
        				$t="first";
        				break;
   				case 2:
       				$t="second";
        				break;
    				case 3:
        				$t="third";
        				break;
        			case 4:
        				$t="fourth";
        				break;
				}
				$thegift = Gift::find($val);
				if($thegift){
				$g.="The ".$t." option is the <strong> ".$thegift->name."</strong> <br/><br/>".$thegift->desc."<br/><br/> OR<br/><br/>";}
			}

			$g = substr_replace($g ,"",-16);
			$s = str_replace("[[GIFTS]]",$g,$s);
			$thescripts[$type] = $s;

   		}

   		return $thescripts;
    	}
}