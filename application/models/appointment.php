<?php
class Appointment extends Eloquent
{   
    public static $table = null;
    public function __construct()
    {
        parent::__construct();
        static::$table = Auth::user()->tenantTable()."_appointments";
    }

    public static $connection = 'clozertools-tenant-data';
    public static $timestamps = true;
     
    // Get the rep Appointment is dispatched to
    public function rep(){
        return $this->belongs_to('User','rep_id');
    }

    // Appointment belongs to Lead
    public function lead(){
        return $this->belongs_to('Lead','lead_id');
    }










    

    

    public function ridealong(){
    	return $this->belongs_to('User','ridealong_id');
    }

    public function sale(){
    	return $this->belongs_to('Sale','sale_id');
    }

    public static function checkDate($date){
        $date = strtotime($date);
        $today = strtotime(date('Y-m-d'));
        if((date('l',$today)=='Friday')||(date('l',$today)=='Saturday')){
            $skip=3;
        } else {
            $skip =2;
        }
        $future = strtotime(date('Y-m-d', strtotime("+".$skip." days")));
        if($date>$future){
           return false;
        } else {
            return true;
        }
    }

    public static function appslots(){
        return DB::query("SELECT * FROM appointment_slots");
    }
    
    public static function neededAppts($type,$filter=null){
        if($type=="city"){
            $cities = City::where('status','!=','leadtype')->where('type','=','city')->order_by('cityname')->get();
            $groupField = "city";
        } else {
            $cities = City::where('status','!=','leadtype')->where('type','=','area')->order_by('cityname')->get();
            $groupField = "area_id";
        }

        $needed=array();
        $slots = Appointment::appslots();
        foreach($slots as $k=>$s){
          $end=strtotime($s->end)-60;
          $end= date('H:i:s',$end);
          $slot[] = array("s"=>$s->start,"f"=>$end,"title"=>"<span style='font-size:10px;'>".str_replace("slot","Slot #",$s->slot_name)."</span>");
        }
        foreach($cities as $val){
            if($groupField=="area_id"){
                $name = $val->id;
            } else {
                $name = str_replace(array(".",","," "),"-",$val->cityname);
            }
            if($filter==true){
                if($val->status=="active"){
                    $needed[$name]['day1']['needed'] = array(
                    $val->today_slot1,$val->today_slot2,
                    $val->today_slot3,$val->today_slot4,
                    $val->today_slot5,"name"=>$val->cityname,"id"=>$val->id);
                    $needed[$name]['day2']['needed'] = array(
                    $val->tomorrow_slot1,$val->tomorrow_slot2,
                    $val->tomorrow_slot3,$val->tomorrow_slot4,
                    $val->tomorrow_slot5,"name"=>$val->cityname,"id"=>$val->id);
                    $needed[$name]['day3']['needed'] = array(
                    $val->twoday_slot1,$val->twoday_slot2,
                    $val->twoday_slot3,$val->twoday_slot4,
                    $val->twoday_slot5,"name"=>$val->cityname,"id"=>$val->id);
                }
            } else {
              $needed[$name]['day1']['needed'] = array(
              $val->today_slot1,$val->today_slot2,
              $val->today_slot3,$val->today_slot4,
              $val->today_slot5,"name"=>$val->cityname,"id"=>$val->id);
              $needed[$name]['day2']['needed'] = array(
              $val->tomorrow_slot1,$val->tomorrow_slot2,
              $val->tomorrow_slot3,$val->tomorrow_slot4,
              $val->tomorrow_slot5,"name"=>$val->cityname,"id"=>$val->id);
              $needed[$name]['day3']['needed'] = array(
              $val->twoday_slot1,$val->twoday_slot2,
              $val->twoday_slot3,$val->twoday_slot4,
              $val->twoday_slot5,"name"=>$val->cityname,"id"=>$val->id);
            }
        }

        $neededtoday = DB::query("SELECT COUNT(id) total, app_date, $groupField,
        SUM(app_time >= '".date('H:i')."') remaining,
        SUM(app_time >= '".date('H:i',strtotime($slot[0]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[0]['f']))."') one,
        SUM(app_time >= '".date('H:i',strtotime($slot[1]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[1]['f']))."') two,
        SUM(app_time >= '".date('H:i',strtotime($slot[2]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[2]['f']))."') three,
        SUM(app_time >= '".date('H:i',strtotime($slot[3]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[3]['f']))."') four,
        SUM(app_time >= '".date('H:i',strtotime($slot[4]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[4]['f']))."') five
        FROM leads WHERE app_date = '".date('Y-m-d')."' AND status='APP' GROUP BY $groupField");
        
        $neededtomorrow = DB::query("SELECT COUNT(id) total, app_time, app_date, $groupField,
        SUM(app_time >= '".date('H:i')."') remaining,
        SUM(app_time >= '".date('H:i',strtotime($slot[0]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[0]['f']))."') one,
        SUM(app_time >= '".date('H:i',strtotime($slot[1]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[1]['f']))."') two,
        SUM(app_time >= '".date('H:i',strtotime($slot[2]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[2]['f']))."') three,
        SUM(app_time >= '".date('H:i',strtotime($slot[3]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[3]['f']))."') four,
        SUM(app_time >= '".date('H:i',strtotime($slot[4]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[4]['f']))."') five
        FROM leads WHERE app_date = '".date('Y-m-d',strtotime('+1 Day'))."' AND status='APP' GROUP BY $groupField");

        $neededtwoday = DB::query("SELECT COUNT(id) total, app_time, app_date, $groupField,
        SUM(app_time >= '".date('H:i')."') remaining,
        SUM(app_time >= '".date('H:i',strtotime($slot[0]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[0]['f']))."') one,
        SUM(app_time >= '".date('H:i',strtotime($slot[1]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[1]['f']))."') two,
        SUM(app_time >= '".date('H:i',strtotime($slot[2]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[2]['f']))."') three,
        SUM(app_time >= '".date('H:i',strtotime($slot[3]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[3]['f']))."') four,
        SUM(app_time >= '".date('H:i',strtotime($slot[4]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[4]['f']))."') five
        FROM leads WHERE app_date = '".date('Y-m-d',strtotime('+2 Day'))."' AND status='APP' GROUP BY $groupField");

        foreach($neededtoday as $val){
            if(array_key_exists(str_replace(array(".",","," "),"-",$val->$groupField),$needed)){
                $needed[str_replace(array(".",","," "),"-",$val->$groupField)]['day1']['onboard'] = array($val->one,$val->two,$val->three,$val->four,$val->five,"name"=>$val->$groupField);
            }
        }

        foreach($neededtomorrow as $val){
            if(array_key_exists(str_replace(array(".",","," "),"-",$val->$groupField),$needed)){
                    $needed[str_replace(array(".",","," "),"-",$val->$groupField)]['day2']['onboard'] = array($val->one,$val->two,$val->three,$val->four,$val->five,"name"=>$val->$groupField);
            }
        }

        foreach($neededtwoday as $val){
            if(array_key_exists(str_replace(array(".",","," "),"-",$val->$groupField),$needed)){
              $needed[str_replace(array(".",","," "),"-",$val->$groupField)]['day3']['onboard'] = array($val->one,$val->two,$val->three,$val->four,$val->five,"name"=>$val->$groupField);
            }
        }
        
        return array("cities"=>$cities,"needed"=>$needed,"slots"=>$slot);
    }

 
}