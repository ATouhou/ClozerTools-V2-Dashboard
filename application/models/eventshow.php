<?php
class Eventshow extends Eloquent
{
    public static $timestamps = true;
    public static $table = "events";
   
    public function city(){
        return $this->belongs_to('City','city_id');
    }

    public function cityLeads(){
        $leads = Lead::where('original_leadtype','=','homeshow')->where('city','=',$this->city->cityname)->where('event_id','=',0)->get();
        return $leads;
    }

    public function leads(){
        return $this->has_many('Lead','event_id');
    }

    public function leadCount(){
        return Lead::where('event_id','=',$this->id)->count();
    }

    public function stats(){
        $stats = DB::query("SELECT COUNT(*) as cnt, SUM(status='APP' OR status='SOLD' OR status='CXL') booked, SUM(status='SOLD') sold, SUM(result='DNS') dns, SUM(result='INC') inc, SUM(status='NI') ni, SUM(status='NQ') nq, SUM(status='NH') nh, SUM(status='DNC') dnc FROM leads WHERE (original_leadtype='homeshow' OR original_leadtype='tradeshow') AND event_id = '".$this->id."' ");
        if($stats){
            return $stats[0];
        } else {
            return array();
        }
    }
    
   
    

}