<?php
class Stats_Controller extends Base_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->filter('before', 'auth');
    }

    public function action_index(){

        $leadtype = $this->salesByColumn("original_leadtype");
        $gift = $this->salesByColumn("gift");
        $city = $this->salesByColumn("city");
        $marital = $this->salesByColumn("married");
        $time = $this->salesByColumn("app_time");
        $timeslots = $this->salesSlots();
        $machinesales = $this->salesFilter("typeofsale");
        $paytype = $this->salesFilter("pay_type");
        $status = $this->salesFilter("status");
        $hometype = $this->salesByColumn("homestead_type");

        return View::make('stats.index')
        ->with('sales_by',array("leadtype"=>$leadtype,
            "gift"=>$gift,
            "city"=>$city,
            "marital"=>$marital,
            "time"=>$time,
            "timeslots"=>$timeslots,
            "hometype"=>$hometype
        ))->with('sales',array("machines"=>$machinesales,
            "paytype"=>$paytype,
            "status"=>$status))
        ->with('charts',array("leadtype"=>$this->produceChart($leadtype,"original_leadtype"),
            "gift"=>$this->produceChart($gift,"gift"),
            "city"=>$this->produceChart($city,"city"),
            "marital"=>$this->produceChart($marital,"married"),
            "time"=>$this->produceChart($time,"app_time"),
            "hometype"=>$this->produceChart($hometype,"homestead_type")
            )
        );
    }

    public function produceChart($data, $column){
        $chart_data=array();
        if(!empty($data)){
            foreach($data as $l){
                if($l->$column!=""){
                    if($l->sold!=0){
                   $chart_data["categories"][] = strtoupper($l->$column);
                   $chart_data["sold"][] = intval($l->sold);
                   $chart_data["dns"][] = intval($l->dns);
                   $chart_data["inc"][] = intval($l->inc);
               }
                }
      
            }
        }
        return $chart_data;
    }

    public function salesByColumn($grouper, $display=null){
        
        $query = DB::query("SELECT COUNT(id) as total,leadtype, $grouper,
            SUM(status='APP' OR status='SOLD' OR status='DNS') demo,
            SUM(result='SOLD' AND (status='APP' OR status='SOLD')) sold,
            SUM(result='DNS' AND (status='APP' OR status='DNS')) dns,
            SUM(result='INC' AND (status='APP' OR status='INC')) inc, 
            SUM(result='CXL' AND (status='APP' OR status='CXL')) cxl
            FROM leads GROUP BY $grouper ORDER BY sold DESC");

    }

    public function salesSlots(){
        
        $slots = Appointment::appslots();
        foreach($slots as $k=>$s){
          $end=strtotime($s->end)-60;
          $end= date('H:i:s',$end);
          $slot[] = array("s"=>$s->start,"f"=>$end,"title"=>"<span style='font-size:10px;'>".str_replace("slot","Slot #",$s->slot_name)."</span>");
        }
        $salesbyslot = DB::query("SELECT COUNT(id) total, app_date, status,
        SUM(app_time >= '".date('H:i',strtotime($slot[0]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[0]['f']))."' AND (status='SOLD' OR result='SOLD')) sold_one,
        SUM(app_time >= '".date('H:i',strtotime($slot[1]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[1]['f']))."' AND (status='SOLD' OR result='SOLD')) sold_two,
        SUM(app_time >= '".date('H:i',strtotime($slot[2]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[2]['f']))."' AND (status='SOLD' OR result='SOLD')) sold_three,
        SUM(app_time >= '".date('H:i',strtotime($slot[3]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[3]['f']))."' AND (status='SOLD' OR result='SOLD')) sold_four,
        SUM(app_time >= '".date('H:i',strtotime($slot[4]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[4]['f']))."' AND (status='SOLD' OR result='SOLD')) sold_five,
        SUM(app_time >= '".date('H:i',strtotime($slot[0]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[0]['f']))."' AND (status='APP' AND result='DNS')) dns_one,
        SUM(app_time >= '".date('H:i',strtotime($slot[1]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[1]['f']))."' AND (status='APP' AND result='DNS')) dns_two,
        SUM(app_time >= '".date('H:i',strtotime($slot[2]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[2]['f']))."' AND (status='APP' AND result='DNS')) dns_three,
        SUM(app_time >= '".date('H:i',strtotime($slot[3]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[3]['f']))."' AND (status='APP' AND result='DNS')) dns_four,
        SUM(app_time >= '".date('H:i',strtotime($slot[4]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[4]['f']))."' AND (status='APP' AND result='DNS')) dns_five        
        FROM leads WHERE app_time != '00:00:00' AND app_time!='' AND (status='APP' OR status='SOLD' OR result='DNS' OR result='INC') ");
        
        return $salesbyslot;
    }

    public function salesFilter($grouper){
        $query = DB::query("SELECT COUNT(id) as cnt, $grouper FROM sales GROUP BY $grouper");

        return $query;




    }

    public function salesByTime($time=null){
        if($time=="MONTH"){

        } else if ($time=="DAY"){

        } else {

        }
        return $query;
    }


    public function action_getbookingstats(){
        return View::make('plugins.bookerstats');
    }

    public function action_getbookingleads(){
        return View::make('plugins.bookerleads');
    }

    public function action_bookerstats(){
    $callstats = DB::query("SELECT COUNT(*) as total, caller_id,
        COUNT(id) total,
        SUM(CASE WHEN HOUR(created_at) = 09 THEN 1 ELSE 0 END) 'nine',
        SUM(CASE WHEN HOUR(created_at) = 10 THEN 1 ELSE 0 END) 'ten',
        SUM(CASE WHEN HOUR(created_at) = 11 THEN 1 ELSE 0 END) 'eleven',
        SUM(CASE WHEN HOUR(created_at) = 12 THEN 1 ELSE 0 END) 'twelve',
        SUM(CASE WHEN HOUR(created_at) = 13 THEN 1 ELSE 0 END) 'thirteen',
        SUM(CASE WHEN HOUR(created_at) = 14 THEN 1 ELSE 0 END) 'fourteen',
        SUM(CASE WHEN HOUR(created_at) = 15 THEN 1 ELSE 0 END) 'fifteen',
        SUM(CASE WHEN HOUR(created_at) = 16 THEN 1 ELSE 0 END) 'sixteen',
        SUM(CASE WHEN HOUR(created_at) = 17 THEN 1 ELSE 0 END) 'seventeen',
        SUM(CASE WHEN HOUR(created_at) = 18 THEN 1 ELSE 0 END) 'eighteen',
        SUM(CASE WHEN HOUR(created_at) = 19 THEN 1 ELSE 0 END) 'nineteen',
        SUM(CASE WHEN HOUR(created_at) = 20 THEN 1 ELSE 0 END) 'twenty',
        SUM(CASE WHEN HOUR(created_at) = 21 THEN 1 ELSE 0 END) 'twentyone',
        SUM(CASE WHEN HOUR(created_at) = 09 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'ninec',
        SUM(CASE WHEN HOUR(created_at) = 10 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'tenc',
        SUM(CASE WHEN HOUR(created_at) = 11 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'elevenc',
        SUM(CASE WHEN HOUR(created_at) = 12 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'twelvec',
        SUM(CASE WHEN HOUR(created_at) = 13 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'thirteenc',
        SUM(CASE WHEN HOUR(created_at) = 14 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'fourteenc',
        SUM(CASE WHEN HOUR(created_at) = 15 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'fifteenc',
        SUM(CASE WHEN HOUR(created_at) = 16 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'sixteenc',
        SUM(CASE WHEN HOUR(created_at) = 17 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'seventeenc',
        SUM(CASE WHEN HOUR(created_at) = 18 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'eighteenc',
        SUM(CASE WHEN HOUR(created_at) = 19 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'nineteenc',
        SUM(CASE WHEN HOUR(created_at) = 20 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'twentyc',
        SUM(CASE WHEN HOUR(created_at) = 21 AND result = 'NI' OR result = 'NQ' OR result = 'DNC' THEN 1 ELSE 0 END) 'twentyonec',
        SUM(CASE WHEN HOUR(created_at) = 09 AND result = 'APP' THEN 1 ELSE 0 END) 'nineapp',
        SUM(CASE WHEN HOUR(created_at) = 10 AND result = 'APP' THEN 1 ELSE 0 END) 'tenapp',
        SUM(CASE WHEN HOUR(created_at) = 11 AND result = 'APP' THEN 1 ELSE 0 END) 'elevenapp',
        SUM(CASE WHEN HOUR(created_at) = 12 AND result = 'APP' THEN 1 ELSE 0 END) 'twelveapp',
        SUM(CASE WHEN HOUR(created_at) = 13 AND result = 'APP' THEN 1 ELSE 0 END) 'thirteenapp',
        SUM(CASE WHEN HOUR(created_at) = 14 AND result = 'APP' THEN 1 ELSE 0 END) 'fourteenapp',
        SUM(CASE WHEN HOUR(created_at) = 15 AND result = 'APP' THEN 1 ELSE 0 END) 'fifteenapp',
        SUM(CASE WHEN HOUR(created_at) = 16 AND result = 'APP' THEN 1 ELSE 0 END) 'sixteenapp',
        SUM(CASE WHEN HOUR(created_at) = 17 AND result = 'APP' THEN 1 ELSE 0 END) 'seventeenapp',
        SUM(CASE WHEN HOUR(created_at) = 18 AND result = 'APP' THEN 1 ELSE 0 END) 'eighteenapp',
        SUM(CASE WHEN HOUR(created_at) = 19 AND result = 'APP' THEN 1 ELSE 0 END) 'nineteenapp',
        SUM(CASE WHEN HOUR(created_at) = 20 AND result = 'APP' THEN 1 ELSE 0 END) 'twentyapp',
        SUM(CASE WHEN HOUR(created_at) = 21 AND result = 'APP' THEN 1 ELSE 0 END) 'twentyoneapp'
        FROM calls GROUP BY caller_id");

             
        $totalstats = DB::query("SELECT COUNT(*) as total, caller_id, COUNT(id) total,
        SUM(CASE when result != '' AND result != 'CONF' AND result != 'NA' AND leadtype='door' THEN 1 ELSE 0 END) totdoor,
        SUM(CASE WHEN result = 'APP' AND leadtype='door' THEN 1 ELSE 0 END) appdoor,
        SUM(CASE WHEN result = 'DNC' AND leadtype='door' THEN 1 ELSE 0 END) dncdoor,
        SUM(CASE WHEN result = 'NH' AND leadtype='door' THEN 1 ELSE 0 END) nhdoor,
        SUM(CASE WHEN result = 'NI' AND leadtype='door' THEN 1 ELSE 0 END) nidoor,
        SUM(CASE WHEN result = 'NQ' AND leadtype='door' THEN 1 ELSE 0 END) nqdoor,
        SUM(CASE WHEN result = 'Recall' AND leadtype='door' THEN 1 ELSE 0 END) recalldoor,
        SUM(CASE WHEN result = 'WrongNumber' AND leadtype='door' THEN 1 ELSE 0 END) wrongdoor,
        SUM(CASE when result != '' AND result != 'CONF' AND result != 'NA' AND leadtype='paper' THEN 1 ELSE 0 END) totpaper,
        SUM(CASE WHEN result = 'APP' AND leadtype='paper' THEN 1 ELSE 0 END) apppaper,
        SUM(CASE WHEN result = 'DNC' AND leadtype='paper' THEN 1 ELSE 0 END) dncpaper,
        SUM(CASE WHEN result = 'NH' AND leadtype='paper' THEN 1 ELSE 0 END) nhpaper,
        SUM(CASE WHEN result = 'NI' AND leadtype='paper' THEN 1 ELSE 0 END) nipaper,
        SUM(CASE WHEN result = 'NQ' AND leadtype='paper' THEN 1 ELSE 0 END) nqpaper,
        SUM(CASE WHEN result = 'Recall' AND leadtype='paper' THEN 1 ELSE 0 END) recallpaper,
        SUM(CASE WHEN result = 'WrongNumber' AND leadtype='paper' THEN 1 ELSE 0 END) wrongpaper,
        SUM(CASE when result != '' AND result != 'CONF' AND result != 'NA' AND leadtype='other' THEN 1 ELSE 0 END) totother,
        SUM(CASE WHEN result = 'APP' AND leadtype='other' THEN 1 ELSE 0 END) appother,
        SUM(CASE WHEN result = 'DNC' AND leadtype='other' THEN 1 ELSE 0 END) dncother,
        SUM(CASE WHEN result = 'NH' AND leadtype='other' THEN 1 ELSE 0 END) nhother,
        SUM(CASE WHEN result = 'NI' AND leadtype='other' THEN 1 ELSE 0 END) niother,
        SUM(CASE WHEN result = 'NQ' AND leadtype='other' THEN 1 ELSE 0 END) nqother,
        SUM(CASE WHEN result = 'Recall' AND leadtype='other' THEN 1 ELSE 0 END) recallother,
        SUM(CASE WHEN result = 'WrongNumber' AND leadtype='other' THEN 1 ELSE 0 END) wrongother,
        SUM(CASE when result != '' AND result != 'CONF' AND result != 'NA' AND leadtype='rebook' THEN 1 ELSE 0 END) totrebook,
        SUM(CASE WHEN result = 'APP' AND leadtype='rebook' THEN 1 ELSE 0 END) apprebook,
        SUM(CASE WHEN result = 'DNC' AND leadtype='rebook' THEN 1 ELSE 0 END) dncrebook,
        SUM(CASE WHEN result = 'NH' AND leadtype='rebook' THEN 1 ELSE 0 END) nhrebook,
        SUM(CASE WHEN result = 'NI' AND leadtype='rebook' THEN 1 ELSE 0 END) nirebook,
        SUM(CASE WHEN result = 'NQ' AND leadtype='rebook' THEN 1 ELSE 0 END) nqrebook,
        SUM(CASE WHEN result = 'Recall' AND leadtype='rebook' THEN 1 ELSE 0 END) recallrebook,
        SUM(CASE WHEN result = 'WrongNumber' AND leadtype='rebook' THEN 1 ELSE 0 END) wrongrebook
        FROM calls GROUP BY caller_id ");

        $stats = DB::query("SELECT COUNT(id) total,
        SUM(CASE when result != '' AND result != 'CONF' AND result != 'NA' THEN 1 ELSE 0 END) tot,
        SUM(CASE WHEN result = 'APP' THEN 1 ELSE 0 END) app,
        SUM(CASE WHEN result = 'DNC' THEN 1 ELSE 0 END) dnc,
        SUM(CASE WHEN result = 'NH' THEN 1 ELSE 0 END) nh,
        SUM(CASE WHEN result = 'NI' OR result = 'NQ' THEN 1 ELSE 0 END) ni,
        SUM(CASE WHEN result = 'NQ' THEN 1 ELSE 0 END) nq,
        SUM(CASE WHEN result = 'Recall' THEN 1 ELSE 0 END) recall,
        SUM(CASE WHEN result = 'WrongNumber' THEN 1 ELSE 0 END) wrong
        FROM calls ");
 
        return View::make('stats.agent')->with('callstats',$callstats)->with('totalstats',$totalstats)->with('stats',$stats);
    }


    public function getstatcount($field, $search, $date){
        return Lead::where($field,'=',$search)
        ->where('app_date','=',$date)
        ->count();
    }

     public function getmonthstats($field, $search, $startdate, $enddate){
        return Lead::where($field,'=',$search)
        ->where('app_date','>',$startdate)
        ->where('app_date','<',$enddate)
        ->count();
    }

    public function action_datetest(){

        echo date('Y-m-d');
    }

    public function getdailystats($table, $search, $op, $value, $column ){
        return DB::query("SELECT COUNT(id) as day FROM $table WHERE $search $op '$value' AND MONTH($column) = MONTH(now()) AND YEAR($column)=YEAR(NOW()) GROUP BY DAY($column) ORDER BY $column DESC ");
    }

    public function action_userbar(){
        return Auth::user()->usersbarchart();
    }

    public function action_demovssales($date=null){
        $monthstats =  DB::query("SELECT COUNT(*) as total, app_date,
             SUM(CASE WHEN result = 'DNS' THEN 1 ELSE 0 END) dns, 
             SUM(CASE WHEN result = 'SOLD' THEN 1 ELSE 0 END) sold, 
             SUM(CASE WHEN result = 'INC' THEN 1 ELSE 0 END) inc,
             SUM(CASE WHEN result = 'DNS' OR result = 'SOLD' OR result = 'INC' THEN 1 ELSE 0 END) tot
             FROM leads GROUP BY app_date");
        
       
        $demos = $this->getdailystats('leads','status','=','DNS','app_date');
        $sales = $this->getdailystats('leads','result','=','SOLD','app_date');

        $demodata = array();
        $salesdata= array();
        $i=0;

        foreach($monthstats as $val){
           if($val->app_date!="0000-00-00"){
            array_push($demodata, intval($val->tot));
            array_push($salesdata,intval($val->sold));


           }


        }

        //$array = array("demos"=>array(32,22,14,23,24,22,32,22,14,23,24,22),"sales"=>array(1,4,2,4,5,2,1,4,2,4,5,2));
        $array = array("demos"=>$demodata,"sales"=>$salesdata);
        return json_encode($array);

    }

    public function action_callsvsbooks(){

        $called = $this->getdailystats('leads','booker_name','!=','NULL','assign_date');
        $booked = $this->getdailystats('leads','status','=','APP','assign_date');

        $calldata = array();
        $bookdata= array();
        $i=0;

        foreach($called as $val){
            if(isset($booked[$i])){
                array_push($bookdata, $booked[$i]->day);
            } else {array_push($bookdata, 0);}
            $i++;
            array_push($calldata, $val->day);
        }

         $array = array("called"=>array(32,22,14,23,24,22),"booked"=>array(1,4,2,4,5,2));
       // $array = array("called"=>$calldata,"booked"=>$bookdata);
        return json_encode($array);
    }   
    
    public function action_agentstats(){
    
    $leads = Lead::where('booker_id','=',Auth::user()->id)
    ->where('call_date','=',date('Y-m-d'))
    ->get();
    
    $ni = 0;$app=0;$nh=0;$dnc=0;$rec=0;
    
    foreach($leads as $val){
    
    if($val->status=="APP"){$app++;}
    if($val->status=="NI"){$ni++;}
    if($val->status=="NH"){$nh++;}
    if($val->status=="DNC"){$dnc++;}
    if($val->status=="Recall"){$rec++;}
        
    }
    $array = array();
    $count = count($leads);
    if($app!=0){$app = array('name'=>'Booked','y'=>$app/$count*100,'color'=>'#00FF00');array_push($array,$app);}
    if($ni!=0){$ni = array('name'=>'Not Interested','y'=>$ni/$count*100,'color'=>'#990000');array_push($array,$ni);}
    if($rec!=0){$rec = array('name'=>'Recall','y'=>$rec/$count*100,'color'=>'#FF9900');array_push($array,$rec);}
    if($nh!=0){$nh = array('name'=>'Not Home','y'=>$nh/$count*100,'color'=>'#1F2E2E');array_push($array,$nh);}
    if($dnc!=0){$dnc = array('name'=>'Do Not Call','y'=>$dnc/$count*100,'color'=>'#FF0000');array_push($array,$dnc);}

    return json_encode($array);
      
    }

    public function action_booker(){
        $input = Input::get();
        $date2 = explode("GMT",$input['datemax']);
        $date = explode("GMT",$input['datemin']);
        $datemin = date('Y-m-d',strtotime($date[0]));
        $datemax = date('Y-m-d',strtotime($date2[0]));


        //STAT SECTION
        
       
        $totalstats = DB::query("SELECT COUNT(*) as total, caller_id, leadtype, COUNT(id) total,
        SUM(CASE WHEN result != '' AND result != 'CONF' AND result != 'NA' THEN 1 ELSE 0 END) tot,
        SUM(CASE WHEN result = 'APP' THEN 1 ELSE 0 END) app,
        SUM(CASE WHEN result = 'DNC' THEN 1 ELSE 0 END) dnc,
        SUM(CASE WHEN result = 'NH' THEN 1 ELSE 0 END) nh,
        SUM(CASE WHEN result = 'NI' THEN 1 ELSE 0 END) ni,
        SUM(CASE WHEN result = 'NQ' THEN 1 ELSE 0 END) nq,
        SUM(CASE WHEN result = 'Recall' THEN 1 ELSE 0 END) recall,
        SUM(CASE WHEN result = 'WrongNumber' THEN 1 ELSE 0 END) wrong
        FROM calls GROUP BY caller_id, leadtype");

        $test = DB::query("SELECT COUNT(*) AS total FROM calls WHERE created_at >= '".$datemin."' AND created_at<= '".$datemax."'");

        $stats = DB::query("SELECT COUNT(*) AS total, caller_id, leadtype,
            SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result != '' AND result !='CONF' AND result != 'NA' THEN 1 ELSE 0 END) rangetot,
            SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'APP' THEN 1 ELSE 0 END) rangeapp,
            SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'DNC' THEN 1 ELSE 0 END) rangednc,
            SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'NH' THEN 1 ELSE 0 END) rangenh,
            SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'NI' THEN 1 ELSE 0 END) rangeni,
            SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'NQ' THEN 1 ELSE 0 END) rangenq,
            SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'WrongNumber' THEN 1 ELSE 0 END) rangewrong,
            SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'Recall' THEN 1 ELSE 0 END) rangerecall
            FROM calls GROUP BY caller_id, leadtype");

        $stats2 = DB::query("SELECT COUNT(id) total,
        SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result != '' AND result != 'CONF' AND result != 'NA' THEN 1 ELSE 0 END) tot,
        SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'APP' THEN 1 ELSE 0 END) app,
        SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'DNC' THEN 1 ELSE 0 END) dnc,
        SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'NH' THEN 1 ELSE 0 END) nh,
        SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'NI' OR result = 'NQ' THEN 1 ELSE 0 END) ni,
        SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'NQ' THEN 1 ELSE 0 END) nq,
        SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'Recall' THEN 1 ELSE 0 END) recall,
        SUM(CASE WHEN created_at >= '".$datemin."' AND created_at <= '".$datemax."' AND result = 'WrongNumber' THEN 1 ELSE 0 END) wrong
        FROM calls");

        $arr = array();
        
        foreach($stats as $val){
            $u = User::find($val->caller_id);
            if($u->user_type=="agent"){
                $val->caller_id=$u->firstname." ".$u->lastname;
                array_push($arr, $val);
            }
        }
   
        return json_encode(array($arr,$stats2));



    }


    public function action_sales($date=null){
        $date = Input::get('date');
        
        if(isset($date))
            {$date = date('Y-m-d', strtotime($date));} 
        else 
            {$date=date('Y-m-d');}

    	$startdate = date('Y-m-01', strtotime($date));
      	$enddate = date('Y-m-t',strtotime($date));
    	$yesterday = date('Y-m-d', strtotime('-1 day', strtotime($date)));

        $sales = $this->getstatcount("result","SOLD",$date);
        $demos = $this->getstatcount("status","APP",$date);
        $cancels = $this->getstatcount("result","CXL",$date);

        $msales = $this->getmonthstats("result","SOLD",$startdate,$enddate);
        $mdemos = $this->getmonthstats("status","APP",$startdate,$enddate);
        $mcancels = $this->getmonthstats("result","CXL",$startdate,$enddate);

        $monthsales = Lead::where('app_date','>=',$startdate)
        ->where('app_date','=<',$enddate)
        ->where('result','=','SOLD')
        ->distinct('rep')
        ->get();

        $numbers = array();

        $salesreps = User::where('user_type','=','salesrep')->get();
        foreach($salesreps as $val){
            $array = array();
            $rep = $val->firstname." ".$val->lastname;
            
            $usales = Lead::where('result','=','SOLD')
            ->where('rep','=',$val->id)
            ->where('app_date','>',$startdate)
            ->where('app_date','<',$enddate)
            ->count();
            $udemos = Lead::where('status','=','APP')
            ->where('rep','=',$val->id)
            ->where('app_date','>',$startdate)
            ->where('app_date','<',$enddate)
            ->count();
            $inc = Lead::where('result','=','INC')
            ->where('rep','=',$val->id)
            ->where('app_date','>',$startdate)
            ->where('app_date','<',$enddate)
            ->count();
            $nq = Lead::where('result','=','NQ')
            ->where('rep','=',$val->id)
            ->where('app_date','>',$startdate)
            ->where('app_date','<',$enddate)
            ->count();
            if(($udemos!=0)||($usales!=0))
                {$ucloseratio = round(($usales/$udemos)*100,2);} 
            else 
                {$ucloseratio="";}
            $array = array(
                "closepercent"=>$ucloseratio,
                "repname"=>$rep,
                "sales"=>$usales,
                "demos"=>$udemos,
                "inc"=>$inc,
                "nq"=>$nq);
            array_push($numbers,$array);
            
        }
    
        $calls = Call::where('created_at','>=',$yesterday)->count();
        if(($mdemos!=0)||($sales!=0)){$closeratio = round(($msales/$mdemos)*100,2);} else {$closeratio="";}
        $bookratio="";
        $stats = array(
            "closeratio"=>$closeratio,
            "bookratio"=>$bookratio,
            "repnumbers"=>$numbers, 
            "todayssales"=>$sales,
            "todaysdemos"=>$demos,
            "todayscancels"=>$cancels,
            "monthsales"=>$msales,
            "monthdemos"=>$mdemos,
            "monthcxl"=>$mcancels);

    	return View::make('sales.performance')
    	->with('monthsales',$monthsales)
    	->with('monthstats',$stats)
        ->with('date',$date);
    	

    }

}