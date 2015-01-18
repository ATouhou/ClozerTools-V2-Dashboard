<?php
class Call extends Eloquent
{
    public static $timestamps = true;
    public static $table = "calls";
   
    public function booker(){
    	return $this->belongs_to('User','caller_id');
    }

    public function leads(){
    	return $this->has_one('Lead','lead_id');
    }

    public static function timeDiff($call_1, $call_2){
    	$min = Call::find($call_1)->created_at;
        $max = Call::find($call_2)->created_at;
      
       
      	$time = round(abs(strtotime($max) - strtotime($min)));
      	return gmdate("H:i:s",$time);

    }
    
   
    public static function timeBetween($time1,$time2){
    
        $time = round(abs(strtotime($time1) - strtotime($time2)));
        $dat = gmdate("H:i:s",$time);
        if($time<1){
        $col = 'inverse';
        $dat = "N/A";
        } else if($time<=3){
        $col = 'important special';
       
        } else if(($time>3)&&($time<=10)) {
        $col="warning special blackText";
        } else {
        $col="success special blackText";
        }
        return "<center><span class='label label-".$col." '>".$dat."</span></center>";//
    }

}