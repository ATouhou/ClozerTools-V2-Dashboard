<?php
class Test_Controller extends Base_Controller
{
	public function __construct(){
        parent::__construct();
        $this->filter('before','auth');
    }

    public function action_leadscore(){
      $lead = Lead::take(10)->get();
      if($lead){
        foreach($lead as $l){
          echo $l->leadScore()."%<br>";
        }
      }
    }


    public function action_callchecker(){

      $leads = Lead::take(200)->get();
      foreach($leads as $l){
        echo $l->cust_num." - ".$l->status."<br>";
        $c = $l->calls;
        if(!empty($c)){
          foreach($c as $call){
            echo $call->result." | ";
          }
          echo "<br><br>";
        }
      }




    }

    public function action_dates(){
      $date = date('Y-m-d',strtotime('-6 Months'));
      echo $date."<br>";
      $lead = Lead::where('entry_date','>=',$date)->count();

      print_r($lead);



    }


    public function action_leadscores(){

      $sales = Sale::all();
      $leads = Lead::where('result','=','SOLD')->get();
      print_r(count($sales));

      $mainstats = DB::query("SELECT COUNT(*) as cnt, married,
        SUM(smoke='Y') smoke, SUM(pets = 'Y') pets, SUM(asthma = 'Y') asthma
        FROM leads WHERE status!='NEW' GROUP BY married");

      $stats = DB::query("SELECT COUNT(*) as cnt, married,
        SUM(smoke='Y') smoke, SUM(pets = 'Y') pets, SUM(asthma = 'Y') asthma

        FROM leads WHERE sale_id!=0 AND result='SOLD' GROUP BY married");
      echo "<pre>";
      print_r($mainstats);
      print_r($stats);


      foreach($mainstats as $key=>$value){

        foreach($stats as $k=>$v){
        

        }
      }

      foreach($sales as $s){
        echo $s->lead->cust_num."<br>";
        if($s->lead->result!="SOLD"){
          $l = Lead::find($s->lead->id);
          $l->result="SOLD";
          $l->save();
         echo $s->lead->result."|||<br>";
        }






        
      }












    }

    public function action_getnas(){

      $leads = Lead::where('status','=','APP')->where('result','=','NA')->get();

      foreach($leads as $l){
        echo $l->cust_name." || ".$l->status."||".$l->app_date."<br>";
      }


    }

    public function action_uploadoldbatchhealthtek(){
        echo "<form enctype='multipart/form-data' method='post' action=''>";
        echo "<input class='file' name='csvfile' type='file' />";
        echo "<button>UPLOAD</button></form>";
        $input = Input::all();
       
    if(!empty($input)){
        $filename = Input::file('csvfile.name');
        $tmp = Input::file('csvfile.tmp_name');

        echo $filename;
        echo $tmp;
       
        $file = $tmp;
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

        $xls = PHPExcel_IOFactory::load($file);
        $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
    
            foreach($rows as $val){
              $num = $val['H'];
              $num = substr($num,0,3)."-".substr($num,3,3)."-".substr($num,6,4);
              
              $check = Lead::where('cust_num','=',$num)->count();
              if($check==0){
                $lead = New Lead;
                
                if(!empty($val['A'])){
                  $lead->cust_name = $val['A'];
                }
                if(!empty($val['B'])){
                  $lead->spouse_name = $val['B'];
                }
                if(!empty($val['D']) && $val['D']!=NULL){
                  $lead->suite_no = $val['D'];
                }
                if(!empty($val['E']) && $val['E']!=NULL){
                  $lead->suite_no = $val['E'];
                }
                if(!empty($val['F']) && $val['F']!=NULL){
                  $lead->city = strtoupper($val['F']);
                }
                if(!empty($val['G']) && $val['G']!=NULL){
                  $lead->province = strtoupper($val['G']);
                }
                if(!empty($val['I']) && $val['I']!=NULL){
                  $lead->prefix = $val['I'];
                }
                if(!empty($val['J']) && $val['J']!=NULL){
                  $lead->married = $val['J'];
                }
                if(!empty($val['K']) && $val['K']!=NULL){
                  if($val['K']=="yes" || $val['K']=="y"){
                    $lead->asthma = 'Y';
                  } else {
                    $lead->asthma = 'N';
                  }
                }

                if(!empty($val['L']) && $val['L']!=NULL){
                  if($val['L']=="yes" || $val['L']=="y"){
                    $lead->smoke = 'Y';
                  } else {
                    $lead->smoke = 'N';
                  }
                }

                if(!empty($val['M']) && $val['M']!=NULL){
                  if($val['M']=="yes" || $val['M']=="y"){
                    $lead->pets = 'Y';
                  } else {
                    $lead->pets = 'N';
                  }
                }

                if($val['N']=="rent" || $val['N']=="r"){
                    $status = "INVALID";
                    $lead->rentown = "R";
                } else {
                    $lead->rentown = "O";
                }

                if(!empty($val['O'])){
                    $lead->yrs = $val['O'];
                } 

                if(!empty($val['P'])){
                    $lead->job = $val['P'];
                } 
                if(!empty($val['Q'])){
                    $lead->spouse_job = $val['Q'];
                } 

                if(!empty($val['T'])){
                    $lead->jobyrs = $val['T'];
                } 
                if(!empty($val['W'])){
                    $lead->gift = $val['W'];
                } 
                if(!empty($val['Y'])){
                    $lead->notes = $val['Y'];
                } 

                if(!empty($val['R'])){
                  if($val['R']=="full time" || $val['R']=="ft"){
                    $lead->fullpart = "FT";
                  } else {
                    $lead->fullpart = "PT";
                  }
                } 

                if(($val['X']=="") || ($val['X']==NULL)){
                    $lead->status = "NEW";
                } else {
                  $lead->status = $val['X'];
                }

                
                if($val['C']==NULL){
                    $lead->address = "";
                } else {
                    $lead->address = $val['C'];
                }

                $lead->entry_date = date('Y-m-d');
                $lead->birth_date = date('Y-m-d');
                $lead->researcher_id = 0;
                $lead->researcher_name = "OldSystemTransfer";
                $lead->original_leadtype = "paper";
                $lead->leadtype="paper";
                $lead->cust_num = $num;
                echo $num." || ";
                echo $lead->cust_name."|| ".$lead->status." || <br>";
                $lead->save();
              } else {
                echo "Number Already In System<br/><br/>";
              }
            }
      }
    }


    public function action_assignpredict(){

      echo Stats::expClose(231,"Peterborough",40);



/*
      
      echo $user->closePercent();
      echo $user->user_type;

      $user = User::where('username','=','dwayne')->first();
      echo $user->closePercent();
      echo $user->user_type;

      $user = User::where('username','=','penache')->first();
      echo $user->closePercent();
      echo $user->user_type;*/

    }


    public function action_testgift(){
      $app = Appointment::find(3617);
      if($app){
        GiftTracker::writeHistory($app);
        
      }
    }

    public function action_convertoldsales(){
     
      $sales = Sale::where('status','=','CANCELLED')->or_where('status','=','TURNDOWN')->get();

      if($sales){
        foreach($sales as $s){
          $cnt=0;
          $old=array("defender"=>array(),"majestic"=>array(),"attachment"=>array());
          if(!empty($s->defone_old)){
            $old["defender"][] = Sale::inventorySku($s->defone_old);
            $cnt++;
          }
          if(!empty($s->deftwo_old)){
            $old["defender"][] = Sale::inventorySku($s->deftwo_old);
            $cnt++;
          }
          if(!empty($s->defthree_old)){
            $old["defender"][] = Sale::inventorySku($s->defthree_old);
            $cnt++;
          }
          if(!empty($s->deffour_old)){
            $old["defender"][] = Sale::inventorySku($s->deffour_old);
            $cnt++;
          }
          if(!empty($s->deffive_old)){
            $old["defender"][] = Sale::inventorySku($s->deffive_old);
            $cnt++;
          }
          if(!empty($s->att_old)){
            $old["attachment"][] = Sale::inventorySku($s->att_old);
            $cnt++;
          }
          if(!empty($s->maj_old)){
            $old["majestic"][] = Sale::inventorySku($s->maj_old);
            $cnt++;
          }
           if(!empty($s->twomaj_old)){
            $old["majestic"][] = Sale::inventorySku($s->twomaj_old);
            $cnt++;
          }
           if(!empty($s->threemaj_old)){
            $old["majestic"][] = Sale::inventorySku($s->threemaj_old);
            $cnt++;
          }
          if($cnt>0){
            $s->old_machines = serialize($old);
            $s->save();
          }
          

        }
      }

      



    }

    public function action_saleinv(){
      $sale = Sale::find(1);

      $items = $sale->items;

      foreach($items as $i){
        echo $i->item_name;
      }
      



    }

    public function action_uploadav(){

        $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
        $max_file_size = 200 * 1024; #200kb
        $nw = $nh = 160; # image with # height

        $input = Input::all();
        $rules = array(
            'image' => 'required|max:5000', //image upload must be an image and must not exceed 500kb
        );
        $validation = Validator::make($input, $rules);
        if( $validation->fails() ) {
            return Redirect::to('dashboard/profile')->with_errors($validation);
        }

        $file = Input::file('image');
        $s = Setting::find(1)->shortcode;
        $user_id = $input['avatarID'];           
       
        $filename = $s."/avatars/".$user_id."-".$file['name'];        
        $path_parts = pathinfo($file['name']);
        $ext = $path_parts['extension'];
        if(!in_array($ext, $valid_exts)){
          echo "INVALID FORMAT!!!!";
        } else {
        //Resizer 
        $size = getimagesize($file['tmp_name']);
        $x = (int) $input['x'];
        $y = (int) $input['y'];
        $w = (int) $input['w'] ? $input['w'] : $size[0];
        $h = (int) $input['h'] ? $input['h'] : $size[1];

        $data = file_get_contents($file['tmp_name']);
        $vImg = imagecreatefromstring($data);
        $dstImg = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
          $filename2 = tempnam(sys_get_temp_dir(), "foo");
          imagejpeg($dstImg, $filename2);
          //Send to S3
          $input2 = S3::inputFile($filename2, false);
          if(S3::putObject($input2, 'salesdash', $filename, S3::ACL_PUBLIC_READ)){
              
              $user = User::find($user_id);
              if($user){
                  $user->avatar = $user_id."-".$file['name'];
                  $user->save();
                  return Redirect::back();
               } else {
                  
                  return Redirect::back();
              }
          } else {
            echo "UPLOAD FAILED!";
          }
        }
    }

    public function action_removedups(){
        if(isset($input['city']) && $input['city']!="all"){
        $cityQuery = "WHERE city = '".$input['city']."'";
        $city = $input['city'];
      } else {
        $cityQuery = ""; 
        $city = "all";
      }

        $cnt = DB::query("SELECT id FROM leads $cityQuery GROUP BY cust_num having count(*) >= 2  ");
        $cities = DB::query("SELECT DISTINCT city FROM leads GROUP BY cust_num having count(*) >= 2  ");
        $t = DB::query("SELECT id, cust_num, original_leadtype,entry_date,birth_date,status FROM leads $cityQuery GROUP BY cust_num having count(*) >= 2 ORDER BY id DESC LIMIT 15");
        
        echo "<pre>";
        
        foreach($t as $v){
          $leads = Lead::where('cust_num','=',$v->cust_num)->get(array('id','cust_num','status','original_leadtype','leadtype'));
          echo "ORIG :".$v->cust_num."<bR>";
          if($leads){
            foreach($leads as $l){
              if($l->id!=$v->id){
                if($l->status!="APP"){
                  echo $l->cust_num."<br>";
                  //$l->delete();
                } else {
                  echo "APP - ".$l->cust_num."<br>";
                }
                
              }
            }
          }
          
        }

        //return View::make('utils.duplicates2')->with('leads',$t)->with('cities',$cities)->with('city',$city);
      
    }

    public function action_appthold(){
      $appt = Appointment::where('app_date','>=',date('Y-m-d',strtotime('-100 days')))->get(array('id','status','booked_at','app_date'));
      echo "<pre>";
           $holdstats = DB::query("SELECT *, IF(puton + totaldems, 100*puton/total, NULL) AS hold 
            FROM (SELECT COUNT(*) as total, app_date, booked_at,
            SUM(status='DNS' OR status='SOLD') puton, SUM(status!='DNS' AND status!='SOLD') totaldems
            FROM appointments WHERE YEAR(app_date)= YEAR('".date('Y-m-d')."') GROUP BY app_date
            ) AS subquery");
           $allholds=0;
        foreach($holdstats as $val){
        $holds[$val->app_date] = array(
            "date"=>$val->app_date,
            "puton"=>$val->puton,
            "totaldems"=>$val->totaldems,
            "hold"=>number_format($val->hold,2,'.','')
            );

        $allholds+=$val->hold;
        }

        $avghold = number_format(($allholds/count($holds)),2,'.','');
        echo $avghold;
        print_r($holds);
    }

    public function action_testPush(){
      $p = New PusherLib;
      $p->pushMessage("test message");
    }


    function getWeekDates($week, $year)
{

    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7*$week)+1-$day)*24*3600;
    $return[0] = date('Y-m-d', $time);
    $time += 6*24*3600;
    $return[1] = date('Y-m-d', $time);
    return $return;
}

    public function action_datetest(){
      $date = "2014-09-10";
      $week = date("W", strtotime($date));
      $prevWeek = $week-1;
      $year = date("Y",strtotime($date));

      print_r($this->getWeekDates($prevWeek,$year));


    }


    public function action_neededapps(){
     $apps = Appointment::neededAppts(true);
     echo "<pre>";
     print_r($apps);

    }

   
    public function action_dealerstats(){
      echo "<pre>";
      $apps_day = DB::query("SELECT COUNT(*) as cnt, app_date, rep_id, rep_name FROM appointments WHERE status='DNS' OR status='SOLD' GROUP BY app_date, rep_id ");
      $apps_week = DB::query("SELECT COUNT(*) as cnt, app_date, rep_id, rep_name FROM appointments WHERE status='DNS' OR status='SOLD' GROUP BY WEEK(app_date), rep_id ");
      $apps_month = DB::query("SELECT COUNT(*) as cnt, app_date, rep_id, rep_name FROM appointments WHERE status='DNS' OR status='SOLD' GROUP BY MONTH(app_date), rep_id ");
      $dems=array();

      foreach($apps_day as $a){
        if($a->cnt>=3){
          if(!isset($dems[$a->rep_id]['day']['3dems'])){
             $dems[$a->rep_id]['day']['3dems'] = $a->app_date;
          }
        }
        if($a->cnt>=4){
          if(!isset($dems[$a->rep_id]['day']['4dems'])){
             $dems[$a->rep_id]['day']['4dems'] = $a->app_date;
          }
        }
        if($a->cnt>=5){
          if(!isset($dems[$a->rep_id]['day']['5dems'])){
             $dems[$a->rep_id]['day']['5dems'] = $a->app_date;
          }
        }
      }

      foreach($apps_week as $a){
        if($a->cnt>=15){
          if(!isset($dems[$a->rep_id]['week']['15dems'])){
             $dems[$a->rep_id]['week']['15dems'] = $a->app_date;
          }
        }
        if($a->cnt>=20){
          if(!isset($dems[$a->rep_id]['week']['20dems'])){
             $dems[$a->rep_id]['week']['20dems'] = $a->app_date;
          }
        }
        if($a->cnt>=25){
          if(!isset($dems[$a->rep_id]['week']['25dems'])){
             $dems[$a->rep_id]['week']['25dems'] = $a->app_date;
          }
        }
      }

      foreach($apps_month as $a){
        if($a->cnt>=50){
          if(!isset($dems[$a->rep_id]['month']['50dems'])){
             $dems[$a->rep_id]['month']['50dems'] = $a->app_date;
          }
        }
        if($a->cnt>=60){
          if(!isset($dems[$a->rep_id]['month']['60dems'])){
             $dems[$a->rep_id]['month']['60dems'] = $a->app_date;
          }
        }
        if($a->cnt>=75){
          if(!isset($dems[$a->rep_id]['month']['75dems'])){
             $dems[$a->rep_id]['month']['75dems'] = $a->app_date;
          }
        }
      }

      
      print_r($dems);


    }

    public function action_leads(){

      $citycount_cities = DB::query("SELECT city, SUM(status = 'NEW' AND original_leadtype!='other' AND original_leadtype!='survey' AND leadtype!='survey' ) avail,
          SUM(status = 'INACTIVE' AND leadtype='paper') paperunreleased, 
          SUM(status = 'INACTIVE' AND leadtype='secondtier') secondtierunreleased, 
          SUM(status='NH') nothomes, SUM(status='INACTIVE' AND leadtype='door') doorunreleased,
        SUM(status = 'ASSIGNED') assigned, SUM(original_leadtype='survey') totalsurvey, SUM(original_leadtype='paper') totalpaper,
        SUM(original_leadtype='door') totaldoor, SUM(original_leadtype!='door' AND original_leadtype!='paper' AND original_leadtype!='survey') totalother, 
        SUM(leadtype='survey' AND status='NEW' AND sale_id=0) survey, SUM(leadtype = 'secondtier' AND status='NEW' AND sale_id=0) secondtier, SUM(leadtype = 'paper' AND status='NEW' AND sale_id=0) paper,SUM(leadtype = 'door' AND status='NEW' AND sale_id=0 ) door,
        SUM(assign_date = DATE('".date('Y-m-d')."')) assign_sort, SUM(status='DELETED' AND leadtype!='survey') deleted,
        SUM(leadtype='other' AND status='NEW' AND sale_id=0) other, SUM(leadtype='ballot' AND status='NEW' AND sale_id=0) ballot, SUM(leadtype='homeshow' AND status='NEW' AND sale_id=0) homeshow, 
          SUM(leadtype='referral' AND status='NEW' AND sale_id=0) referral, SUM(leadtype='finalnotice' AND status='NEW' AND sale_id=0) final,
        SUM(leadtype = 'rebook' AND status='NEW' AND sale_id=0 AND app_time = '00:00:00') rebook,
          SUM(original_leadtype='secondtier' AND release_date!='0000-00-00' AND release_date>='".date('Y-m-d',strtotime('-3 days'))."') secondtierreleased,
          SUM(original_leadtype='survey' AND release_date!='0000-00-00' AND release_date>='".date('Y-m-d',strtotime('-3 days'))."') surveyreleased,
        SUM(original_leadtype='door' AND release_date!='0000-00-00' AND release_date>='".date('Y-m-d',strtotime('-3 days'))."') doorreleased,
        SUM(original_leadtype='paper' AND release_date!='0000-00-00' AND release_date>='".date('Y-m-d',strtotime('-3 days'))."') paperreleased,
        SUM(leadtype = 'rebook' AND status = 'NEW' AND app_time >= '".date('H:i',strtotime("10:00:00"))."' AND app_time <= '".date('H:i',strtotime("11:30:00"))."') rebookone,
          SUM(leadtype = 'rebook' AND status = 'NEW' AND app_time >= '".date('H:i',strtotime("11:30:01"))."' AND app_time <= '".date('H:i',strtotime("14:45:00"))."') rebooktwo,
          SUM(leadtype = 'rebook' AND status = 'NEW' AND app_time >= '".date('H:i',strtotime("14:45:01"))."' AND app_time <= '".date('H:i',strtotime("16:00:00"))."') rebookthree,
          SUM(leadtype = 'rebook' AND status = 'NEW' AND app_time >= '".date('H:i',strtotime("16:02:00"))."' AND app_time <= '".date('H:i',strtotime("18:30:00"))."') rebookfour,
          SUM(leadtype = 'rebook' AND status = 'NEW' AND app_time >= '".date('H:i',strtotime("18:31:00"))."' AND app_time <= '".date('H:i',strtotime("20:50:00"))."') rebookfive
        FROM leads GROUP BY city");
echo "<pre>";
print_r($citycount_cities);
    }


    public function action_recruits(){
      $user = User::find(58);
      echo $user->fullName();

      if(!empty($user->recruits)){
        foreach($user->recruits as $rec){
          echo $rec->fullName();
        }
      }
    }

    public function action_applydbtocities(){
      $city  = City::where('status','!=','leadtype')->get();
      foreach($city as $c){
        echo $c->cityname."|".$c->getCityStat("Number of taxfilers");
        $c->database_identifier = $c->getVector();
        $c->save();
      }
    }


    public function action_applyquadrants(){
        $cities = City::where('status','!=','leadtype')->get();
        echo "<h1>QUADRANT APPLIER</h1>";
        echo "<form method='post' action=''>";
        echo "<select name='city' >";
        foreach($cities as $c){
          echo "<option value='".$c->cityname."'>".$c->cityname."</option>";
        }
        echo "</select>";

        echo "<button>APPLY QUADRANTS</button></form>";
      $input = Input::get();
      if(isset($input['city'])){
          $city = $input['city'];
          $leads = Lead::where('city','=',$city)->get();
          foreach($leads as $val){
                $numcheck = substr(str_replace("-","",$val->cust_num),0, 6);
                $exists = Quadrant::where('exchange','=',$numcheck)->first();

                if($exists){
                  $city = City::find($exists->attributes['city_id'])->cityname;
                } else {  
                  $city = "No Assigned City";
                }
              echo $val->cust_name."|".$val->cust_num."| OLD CITY : ".$val->city." | NEW CITY : ".$city."<br>";;
              $val->city = $city;
              $val->save();
          }
      }
      
    }



    public function action_scratchtoexpense(){
      $scratch = Scratch::all();
      foreach($scratch as $s){
        $expense = New Expense;
        $expense->cityname = $s->city;
        $expense->date_paid = $s->date_sent;
        $expense->expense_amount = $s->cost;
        $expense->expense_tag = "Scratch Card Mailout to ".$s->city;
        $expense->category="Scratch Cards";
        $expense->user_id = Auth::user()->id;
        $expense->status="paid";
        $expense->save();
        echo $s->city."<br>";
      }


    }

    public function action_checkapps(){
      $apps = Appointment::count();
      echo $apps."<br><br>";
      $apps = DB::query("SELECT lead_id, MAX(id) as cnt FROM appointments
GROUP BY lead_id ORDER BY id DESC");

      $apps2 = DB::query("SELECT * FROM (
    SELECT * FROM appointments
    ORDER BY lead_id, id DESC 
) AS ord
GROUP BY lead_id");
      foreach($apps2 as $a){
        $lead = Lead::find($a->lead_id);
        if($lead){
          if($lead->result!=$a->status){
            if($a->status=="CXL" || $a->status=="SOLD" || $a->status=="DNS" || $a->status=="INC"){
              echo $lead->id. " | Lead : ".$lead->result."--<b>".$lead->status. "</b> | App : ".$a->status."<br>";
            }
            
          }
          
        }

      }

    }

    public function action_uploadmdhealth(){
      $cities = City::where('status','=','active')->get();

        echo "<form enctype='multipart/form-data' method='post' action=''>";
        echo "<input class='file' name='csvfile' type='file' />";
     
        echo "<button>UPLOAD</button></form>";
        $input = Input::all();
        if(!empty($input)){
            $filename = Input::file('csvfile.name');
            $tmp = Input::file('csvfile.tmp_name');
            $file = $tmp;
            require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

            $xls = PHPExcel_IOFactory::load($file);
            $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
        } else {
          $rows=array();
          $city='';
        }
      $duplicate=0;$count=0;
      foreach($rows as $k=>$r){
        if($k!=0){
        $cust_name = $r['A']." ".$r['B'];
        $number = str_replace("(","",$r['G']);
        $number = str_replace(")","",$number);
        $number = str_replace("-","",$number);
        $number = str_replace(" ","",$number);
        $num = substr($number,0,3)."-".substr($number,3,3)."-".substr($number,6,4);
              
       
        if(!empty($cust_name) && !empty($num) && !empty($r['D'])){
          $lead = New Lead;
          $lead->leadtype = "survey";
          $lead->original_leadtype = "survey";
          $lead->researcher_id = Auth::user()->id;
          $lead->researcher_name = "Upload/Manilla";
          $lead->manilla_researcher = Auth::user()->id;
          $lead->status="NEW";
          $lead->entry_date = date('Y-m-d');
          $lead->cust_name = $cust_name;
          $lead->cust_num = $num;
          $lead->smoke = "N"; 
          $lead->pets = "N";  
          $lead->asthma = "N"; 
          $lead->rentown = "";        
          $lead->city = $r['D'];
          $lead->address = $r['C'];
          $lead->postalcode = $r['F'];
          $test = $lead->save();
          if($test){
             echo $cust_name. " NUM :".$num." Address : ".$r['C']. "City : ".$r['D']."<br>";
          }
        }
        

        }
      }

    }

    public function action_createcities(){
      echo "<pre>";
      $leads = Lead::distinct()->get(array('city'));
      
      foreach($leads as $l){
        $city = City::where('cityname','=',$l->city)->first();
        if($city){
          echo "entered<br>";
        } else {
          $c = New City;
          $c->cityname = $l->city;
          $c->status = "active";
          $c->save();
          echo $l->city."<br>";
        }
        
      }
     
    }


    public function action_fixdoor(){

          $datemin = date('Y-m-d',strtotime('2014-08-01'));
          $datemax = date('Y-m-d',strtotime('2014-09-01'));
       

      $doorreporttime = DB::query("SELECT COUNT(id) as total, researcher_id, researcher_name,lat, lng,
        SUM(status!='WrongNumber') valid, SUM(status='WrongNumber' OR status='INVALID') wrong, SUM(status='NQ' AND nqreason='renter') renters, SUM(status='NI') ni,
        SUM(status='APP' OR status='SOLD' OR status='DNS' OR status='CONF') booked,SUM(result='DNS' AND status='APP') dns,
        SUM(status='DNC') dnc, SUM(status='NEW') avail, SUM(status='INACTIVE') unreleased, SUM(status='SOLD') sold, SUM(status='DNC') dnc, SUM(result='DNS' or result='SOLD') puton
        FROM leads WHERE original_leadtype = 'door' AND entry_date>= DATE('".$datemin."') AND entry_date<= DATE('".$datemax."') GROUP BY researcher_id");

     
      $appointments = DB::query("SELECT COUNT(*) as total, booker_id, booked_by FROM appointments WHERE app_date>= DATE('".$datemin."') AND app_date<= DATE('".$datemax."') GROUP BY booker_id");
      $bookerall = DB::query("SELECT COUNT(*) as total, booker_id, booker_name FROM leads WHERE entry_date>= DATE('".$datemin."') AND entry_date<= DATE('".$datemax."') GROUP BY booker_id");
      $bookerdoor = DB::query("SELECT COUNT(*) as total, SUM(status='SOLD') sold, SUM(status='APP') apps, booker_id, booker_name  FROM leads WHERE entry_date>= DATE('".$datemin."') AND entry_date<= DATE('".$datemax."') GROUP BY booker_id");
      $researcher = DB::query("SELECT COUNT(*) as total, researcher_id, researcher_name,SUM(status='SOLD') sold,  SUM(status='APP') apps FROM leads WHERE entry_date>= DATE('".$datemin."') AND entry_date<= DATE('".$datemax."') GROUP BY researcher_id");
      echo "<pre>";
      print_r($appointments);
      print_r($bookerall);
      print_r($bookerdoor);
      print_r($researcher);


    }

    public function action_applycallstoassigncount(){
      $count = Setting::find(1)->delete_count;
      $changed = array();
      $delcount = Lead::where('assign_count','>=',$count)->where('status','=','DELETED')->count();
      echo "<span style='font-size:40px;'>".$delcount."</span><br>";
      $del = Lead::where('assign_count','>=',$count)->where('status','=','DELETED')->take(1500)->get();
      print_r(count($del));
      echo "<br><pre>";
      foreach($del as $val){
        if($val->assign_count>count($val->calls)){         
          $val->assign_count = count($val->calls);
          $val->save();
          $changed[] = $val->cust_num;
        }
      }
      print_r($changed);  
    }

    public function action_inventorycheck(){
      $inv = Inventory::where('sale_id','!=',0)->get();
      $items=array();
      foreach($inv as $i){
        if($i->status!="Sold" && $i->status!="Cancelled"){
          //$i->status="Sold";
          //$i->save();
          $items[] = $i;
          echo $i->status."<br>";
        }
        
      }
      echo "<pre>";
      echo "All Changed Items";
      print_r($items);
    }

    public function action_applyinventory(){
      $sales = Sale::get();

      foreach($sales as $s){
        echo "SALE#".$s->id."-";
        echo $s->status. " | ".$s->typeofsale;
        echo "defone - ".$s->defone." | ";
        echo "deftwo - ".$s->deftwo." | ";
        echo "defthree - ".$s->defthree." | ";
        echo "deffour - ".$s->deffour." | ";
        echo "maj - ".$s->maj." | ";
        echo "twomaj - ".$s->twomaj." | ";
        echo "threemaj - ".$s->threemaj." | ";
        echo "att - ".$s->att." | <br/>";
        $nums = array("defone"=>$s->defone,"deftwo"=>$s->deftwo,"defthree"=>$s->defthree,"deffour"=>$s->deffour,"att"=>$s->att,"maj"=>$s->maj,"twomaj"=>$s->twomaj,"threemaj"=>$s->threemaj);
        foreach($nums as $k=>$n){
            if($n>0){
                $inv = Inventory::find($n);
                if($inv){

                  echo "|| ".$inv->sku. " - ".$inv->sale_id." - ".$inv->item_name." || ".$inv->status;
                }
              }
        }
        echo "<br><br>";
       
      }

    }

    


    public function action_applybookertosales(){
        $apps = Appointment::where('sale_id','!=',0)->get();
        foreach($apps as $s){
            $sale = Sale::find($s->sale_id);
            $sale->booker_id = $s->booker_id;
            $sale->researcher_id = $s->lead->researcher_id;
            if($sale->save()){
                echo "success ||".$s->sale_id."|".$s->booker_id."|".$sale->researcher_id;
            }
        };
    }

    public function action_applyresearchertoapps(){
        $apps = Appointment::where('researcher_id','=',0)->take(900)->get();
        print_r(count($apps));
        echo "<br>";
        foreach($apps as $s){
            $s->researcher_id = $s->lead->researcher_id;
            $s->save();
            if($s->save()){
                echo "success ||".$s->id."|".$s->researcher_id;
            }
        };
    }


    public function action_testmap(){

      $apps = Appointment::where('app_date','=',date('Y-m-d',strtotime('-3 Weeks')))
      ->where('app_time','=','15:30:00')->where('city','=','Victoria')
      ->get();
     

      return View::make('plugins.tspmap')
      ->with('apps',$apps);

    }

    public function action_testleads(){
      $leads = DB::query("SELECT * FROM leads WHERE 
        city='Victoria' AND entry_date >= '2013-10-20' AND entry_date !='0000-00-00' AND status='DELETED' ORDER BY entry_date LIMIT 10
        ");

      $leads2 = DB::query("UPDATE leads SET assign_count=0, status='NEW' WHERE 
        city='Victoria' AND entry_date >= '2013-10-20' AND entry_date !='0000-00-00' AND status='DELETED' ORDER BY entry_date LIMIT 10
        ");


        echo "<pre>";
        foreach($leads as $val){
          echo $val->id." | ";
          echo $val->entry_date."----".$val->assign_count."<br>";
        
        }
        print_r($leads);

    }

    public function action_narebooks(){


       $rebookcount = DB::query("SELECT COUNT(*) as count FROM leads 
            WHERE app_date != DATE('".date('Y-m-d')."') AND (status='RB' OR (result='NA' AND status='APP'))");

        print_r($rebookcount);
       $rebooks = Lead::where('status','=','APP')
       ->where('result','=','NA')
       ->or_where('result','=','RB')
       ->get(array('status','cust_name','cust_num'));
       echo "<pre>";
       foreach($rebooks as $val){
        echo $val->cust_name."|".$val->status."<br>";

       }

       
    }

    public function action_testsales(){
    echo "<pre>";
    $datemin = "2014-05-01";
    $datemax = "2014-05-31";
    $city='';
    	$weekdetails = DB::query("SELECT *, IF(sales + puton, 100*sales/puton, NULL) AS close, IF(puton+tot, 100*puton/tot, NULL) AS complete
      FROM (SELECT COUNT(*) as tot,rep_name, rep_id, 
      SUM(status!='DISP') tots,
      SUM(status='RB-OF' ) rbof, SUM(status='RB-TF') rbtf, SUM(status='CXL') cxl, SUM(status='DNS')dns, SUM(status='INC') inc, SUM(status='SOLD') sales,
      SUM(status='DNS' OR status='SOLD') puton, SUM(status='NQ') nq,SUM(status='DISP') disp
      FROM appointments WHERE app_date >= DATE('".$datemin."') AND app_date <= DATE('".$datemax."') $city GROUP BY rep_name) as SUBQUERY ");
      
    $saledetails = DB::query("SELECT COUNT(*) as tot, user_id, sold_by, SUM(typeofsale='defender') def,
    SUM(typeofsale='majestic') maj, SUM(typeofsale='system') system, SUM(status='COMPLETE' OR status='PAID') net,
    SUM(status='CANCELLED' OR status='TURNDOWN') cxl,
    SUM(typeofsale='supersystem') super, SUM(typeofsale='novasystem') nova, SUM(typeofsale='megasystem') mega,
    SUM(typeofsale='2defenders') twodef, SUM(typeofsale='3defenders') threedef,
    SUM(status='COMPLETE' AND typeofsale='defender') netdef, SUM(status='COMPLETE' AND typeofsale='majestic') netmaj, 
    SUM(status='COMPLETE' AND typeofsale='system') netsys, SUM(status='COMPLETE' AND typeofsale='supersystem') netsuper, 
    SUM(status='COMPLETE' AND typeofsale='megasystem') netmega, SUM(status='COMPLETE' AND typeofsale='novasystem') netnova, 
    SUM(status='COMPLETE' AND typeofsale='3defenders') netthreedef, SUM(status='COMPLETE' AND typeofsale='2defenders') nettwodef
    FROM sales WHERE date >= DATE('".$datemin."') AND date <= DATE('".$datemax."') $city GROUP BY user_id");

	/*$details = DB::query(
		SUM(typeofsale='majestic') maj SUM(typoeofsale='system') system, SUM(status='COMPLETE' OR status='PADI')
		(select max(typeofsale) from sales as val);*/
    

    $salesarray=array();
    $disp=0;$dns=0;$cxl=0;$inc=0;$puton=0;$rbtf=0;$rbof=0;$close=0;$complete=0;$allapp=0;$sold=0;$nq=0;
    $gmaj=0;$nmaj=0;$gdef=0;$gmaj=0;
    foreach($weekdetails as $w){
    	$disp+=$w->disp;$dns+=$w->dns;$cxl+=$w->cxl;$inc+=$w->inc;$rbtf+=$w->rbtf;$rbof+=$w->rbof;$nq+=$w->nq;
    	$puton+=$w->puton;$allapp+=$w->tots;$sold+=$w->sales;
        if($w->rep_id!=0){
        $salesarray[$w->rep_id] = array(
          "name"=>$w->rep_name,
          "rep_id"=>$w->rep_id,
          "appointment" =>array(
            "DISP"=>$w->disp,
            "DNS"=>$w->dns,
            "CXL"=>$w->cxl,
            "INC"=>$w->inc,
            "RBTF"=>$w->rbtf,
            "RBOF"=>$w->rbof,
            "PUTON"=>$w->puton,
            "CLOSE"=>$w->close,
            "COMPLETE"=>$w->complete),
          "grosssales"=>0,
          "netsales"=>0,
          "cancelledsales"=>0,
          "grosssale"=>array(
          "defender"=>0,"majestic"=>0,"system"=>0,"supersystem"=>0,
          "novasystem"=>0,"megasystem"=>0,"3defenders"=>0,
          "2defenders"=>0),
          "netsale"=>array(
          "defender"=>0,"majestic"=>0,"system"=>0,"supersystem"=>0,
          "novasystem"=>0,"megasystem"=>0,"3defenders"=>0,
          "2defenders"=>0),
          "totgrossunits"=>0,
          "grossmd"=>array("majestic"=>0,"defender"=>0),
          "grossunits"=>array("defender"=>0,"majestic"=>0,
          "system"=>0,"supersystem"=>0,"novasystem"=>0,
          "megasystem"=>0,"3defenders"=>0,"2defenders"=>0),
          "totnetunits"=>0,
          "netmd"=>array("majestic"=>0,"defender"=>0),
          "netunits"=>array("defender"=>0,"majestic"=>0,
          "system"=>0,"supersystem"=>0,"novasystem"=>0,
          "megasystem"=>0,"3defenders"=>0,"2defenders"=>0)
          );
          }
      }

    $gsales=0;$nsales=0;$cxlsales=0;

    foreach($saledetails as $s){
      if(array_key_exists($s->user_id,$salesarray)){
        $cxlsales+=$s->cxl;
        $gsales+=$s->tot;$nsales+=$s->tot;
        
        $salesarray[$s->user_id]["grosssales"]=$s->tot;
        $salesarray[$s->user_id]["netsales"]=$s->tot;
        $salesarray[$s->user_id]["grosssale"]=array(
          "defender"=>$s->def,"majestic"=>$s->maj,"system"=>$s->system,"supersystem"=>$s->super,
          "novasystem"=>$s->nova,"megasystem"=>$s->mega,"3defenders"=>$s->threedef,
          "2defenders"=>$s->twodef);
        $salesarray[$s->user_id]["netsale"]=array(
          "defender"=>$s->netdef,"majestic"=>$s->netmaj,"system"=>$s->netsys,"supersystem"=>$s->netsuper,
          "novasystem"=>$s->netnova,"megasystem"=>$s->netmega,"3defenders"=>$s->netthreedef,
          "2defenders"=>$s->nettwodef);
      };
      }
      
       if($sold!=0 && $puton!=0){
     	$close = number_format(($sold/($dns+$sold))*100,2,'.','');
     	$complete = number_format(100-(($sold+$dns)/($cxl+$inc+$rbtf+$rbof+$sold+$dns))*100,2,'.','');
     }
    
     $totals=array(
     "name"=>"totals",
     "appointment" =>array(
     		"TOTALS"=>$allapp,
     		"SOLD"=>$sold,
            "DISP"=>$disp,
            "DNS"=>$dns,
            "CXL"=>$cxl,
            "INC"=>$inc,
            "RBTF"=>$rbtf,
            "RBOF"=>$rbof,
            "PUTON"=>$puton,
            "CLOSE"=>$close,
            "COMPLETE"=>$complete),
          "grosssales"=>$gsales,
          "netsales"=>$nsales,
          "cancelledsales"=>$cxlsales,
          "grosssale"=>array(
          "defender"=>0,"majestic"=>0,"system"=>0,"supersystem"=>0,
          "novasystem"=>0,"megasystem"=>0,"3defenders"=>0,
          "2defenders"=>0),
          "netsale"=>array(
          "defender"=>0,"majestic"=>0,"system"=>0,"supersystem"=>0,
          "novasystem"=>0,"megasystem"=>0,"3defenders"=>0,
          "2defenders"=>0),
          "totgrossunits"=>0,
          "grossmd"=>array("majestic"=>0,"defender"=>0),
          "grossunits"=>array("defender"=>0,"majestic"=>0,
          "system"=>0,"supersystem"=>0,"novasystem"=>0,
          "megasystem"=>0,"3defenders"=>0,"2defenders"=>0),
          "totnetunits"=>0,
          "netmd"=>array("majestic"=>0,"defender"=>0),
          "netunits"=>array("defender"=>0,"majestic"=>0,
          "system"=>0,"supersystem"=>0,"novasystem"=>0,
          "megasystem"=>0,"3defenders"=>0,"2defenders"=>0)
        );
    
   
     
    foreach($salesarray as $s){
      foreach($s["grosssale"] as $k=>$v){
          $u = Sale::getUnits($k);
          $units = $s["grosssale"][$k]*$u["tot"];
          $majs = $s["grosssale"][$k]*$u["maj"];
          $defs = $s["grosssale"][$k]*$u["def"];
          
          $s["totgrossunits"] = intval($s["totgrossunits"])+intval($units);
          $s["grossmd"]["majestic"] = $s["grossmd"]["majestic"]+$majs;
          $s["grossmd"]["defender"] = $s["grossmd"]["defender"]+$defs;
          $s["grossunits"][$k] = $s["grossunits"][$k]+$units;
          
          $totals["grossunits"][$k] += intval($units);
          $totals["totgrossunits"] +=  intval($units);
          $totals["grosssale"][$k] += $s["grosssale"][$k];
          $totals["grossmd"]["majestic"] += $majs;
          $totals["grossmd"]["defender"] += $defs; 
      }
      foreach($s["netsale"] as $k=>$v){
          $u = Sale::getUnits($k);
          $units = $s["netsale"][$k]*$u["tot"];
          $majs = $s["netsale"][$k]*$u["maj"];
          $defs = $s["netsale"][$k]*$u["def"];
          
          $s["totnetunits"] = intval($s["totnetunits"])+intval($units);
          $s["netmd"]["majestic"] = $s["netmd"]["majestic"]+$majs;
          $s["netmd"]["defender"] = $s["netmd"]["defender"]+$defs;
          $s["netunits"][$k] = $s["netunits"][$k]+$units;
          
          $totals["netunits"][$k] += intval($units);
          $totals["totnetunits"] +=  intval($units);
          $totals["netsale"][$k] += $s["netsale"][$k];
          $totals["netmd"]["majestic"] += $majs;
          $totals["netmd"]["defender"] += $defs; 
      }
      $newarray[$s["rep_id"]] = $s;
    }

      $newarray["totals"] = $totals;

      print_r($newarray["totals"]);
   
    }



    public function action_fixnumbers(){
    
      $l = DB::query("SELECT * FROM leads WHERE cust_num REGEXP '^[^-]*$'");
   
      foreach($l as $v){
        $num = substr($v->cust_num,0,3)."-".substr($v->cust_num,3,3)."-".substr($v->cust_num,6,4);
        $v->cust_num = $num;
        $l = Lead::find($v->id);
        $l->cust_num = $num;
        $l->save();
        $c = Call::where('phone_no','=',$v->cust_num)->get();
        if($c){
          foreach($c as $val){
            $val->phone_no = $num;
            $val->save();
          }
        }
        echo $num."<br>";
      }
    }

    public function action_cyclonic(){
      $cities = City::where('status','=','active')->get();

        echo "<form enctype='multipart/form-data' method='post' action=''>";
        echo "<input class='file' name='csvfile' type='file' />";
     
        echo "<button>UPLOAD</button></form>";
        $input = Input::all();
        if(!empty($input)){
            $filename = Input::file('csvfile.name');
            $tmp = Input::file('csvfile.tmp_name');
            $city = Input::get('city');
            $file = $tmp;
            require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

            $xls = PHPExcel_IOFactory::load($file);
            $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
        } else {
          $rows=array();
          $city='';
        }
      $duplicate=0;$count=0;
      foreach($rows as $r){
        $cust_name = $r['A']." ".$r['B'];
        $number = str_replace("(","",$r['C']);
        $number = str_replace(")","",$number);
        $number = str_replace("-","",$number);
        $number = str_replace(" ","",$number);
        $num = substr($number,0,3)."-".substr($number,3,3)."-".substr($number,6,4);
              
       
        if(!empty($cust_name) && !empty($num)){
          $lead = New Lead;
          $lead->leadtype = "survey";
          $lead->original_leadtype = "survey";
          $lead->researcher_id = Auth::user()->id;
          $lead->researcher_name = "Upload/Manilla";
          $lead->manilla_researcher = Auth::user()->id;
          $lead->status="NEW";
          $lead->entry_date = date('Y-m-d');
          $lead->cust_name = $cust_name;
          $lead->cust_num = $num;
          $lead->smoke = "N"; 
          $lead->pets = "N";  
          $lead->asthma = "N"; 
          $lead->rentown = "";        
          $lead->city = $r['E'];
          $lead->address = $r['D'];
          $lead->postalcode = $r['F'];
          $test = $lead->save();
          if($test){
             echo $cust_name. " NUM :".$num." Address : ".$r['D']. "City : ".$r['E']."<br>";
          }
        }
        

      }




    }

    public function action_foxvalley(){
      $cities = City::where('status','=','active')->get();

        echo "<form enctype='multipart/form-data' method='post' action=''>";
        echo "<input class='file' name='csvfile' type='file' />";
        echo "<select name='city' >";
      foreach($cities as $c){
        echo "<option value='".$c->cityname."'>".$c->cityname."</option>";
      }
      echo "</select>";
        echo "<button>UPLOAD</button></form>";
        $input = Input::all();
        if(!empty($input)){
            $filename = Input::file('csvfile.name');
            $tmp = Input::file('csvfile.tmp_name');
            $city = Input::get('city');
            $file = $tmp;
            require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

            $xls = PHPExcel_IOFactory::load($file);
            $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
        } else {
          $rows=array();
          $city='';
        }
      $duplicate=0;$count=0;
      foreach($rows as $r){

          if(!empty($r['B'])){
              $number = str_replace("-","",$r['B']);
              $number = str_replace(" ","",$number);
              $num = substr($number,0,3)."-".substr($number,3,3)."-".substr($number,6,4);
              
              $checkphone = Lead::where('cust_num','=', $num)
                ->where('original_leadtype','!=','door')
                ->where('original_leadtype','!=','other')
                ->where('original_leadtype','!=','homeshow')
                ->where('original_leadtype','!=','ballot')
                ->where('original_leadtype','!=','finalnotice')
                ->where('original_leadtype','!=','referral')
                ->where('original_leadtype','!=','finalnotice')
                ->where('original_leadtype','!=','coldcall')
                ->where('original_leadtype','!=','doorknock')
                ->where('original_leadtype','!=','personal')
                ->first();

                if(!$checkphone){
                  if(!empty($r['A'])){
                      $lead = New Lead;
                      $lead->leadtype = "paper";
                      $lead->original_leadtype = "paper";
                      $lead->researcher_id = Auth::user()->id;
                      $lead->researcher_name = "Upload/Manilla";
                      $lead->status="INVALID";
                      $lead->entry_date = date('Y-m-d');
                      $lead->birth_date = date('Y-m-d');
                      $lead->cust_name = $r['A'];
                      $lead->cust_num = $num;
                      $lead->smoke = "N"; 
                      $lead->pets = "N";  
                      $lead->asthma = "N";
                      if(!empty($r['H'])){
                        if($r['H']=="R"){
                          $lead->fullpart = "FT";
                          $lead->job = "RETIRED";
                        } else {
                          $lead->fullpart = $r['H'];
                        }
                      } 
                      if(!empty($r['I'])){
                        $lead->rentown = $r['I'];
                      }
                      $lead->rentown = "";        
                      $lead->city = $city;
                      $lead->address = $r['C'];
                      $lead->postalcode = $r['E'];
                      $lead->age_range = $r['F'];
                      $lead->married = $r['G'];
                      if(isset($r['K'])){
                        if($r['K']=="yes" ){
                            $lead->has_purifier = 1;
                        } else if($r['K']=="no"){
                            $lead->has_purifier = 0;
                        }
                      }
                      
                      if($test = $lead->save()){
                        $count++;
                      };

                  }
                } else {
                  $duplicate++;
                }

                  }
      }
        echo $count. "Added | ". $duplicate. "Duplicates";
    }


    public function action_quality(){
    	echo "<form enctype='multipart/form-data' method='post' action=''>";
		echo "<input class='file' name='csvfile' type='file' />";
		echo "<button>UPLOAD</button></form>";
        $input = Input::all();
	   
    if(!empty($input)){
        $filename = Input::file('csvfile.name');
		$tmp = Input::file('csvfile.tmp_name');

	   
        $file = $tmp;
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

        $xls = PHPExcel_IOFactory::load($file);
        $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
  	} else {
  		$rows=array();
  	}

  	

  		foreach($rows as $r){
  		if(1 === preg_match('~[0-9]~', $r['B'])){
  		
  			$job = explode("/", $r['L']);
        $occupation = explode("/", $r['J']);
        $numcheck= str_replace(array( '(', ')' ), '', $r['B']);
				$quadcheck =  substr(str_replace(" ","",$numcheck),0, 6);
				$exists = Quadrant::where('exchange','=',$numcheck)->get('city_id');
				$numcheck = str_replace(" ","-",$numcheck);
					if($exists){
				    		$quad = $exists[0]->attributes['city_id'];
						$city = City::find($exists[0]->attributes['city_id'])->cityname;
					} else {	
						$city = "No Assigned City";
						$quad = "";
					}
				
				$checkphone = Lead::where('cust_num','=', $r['C'])
				->where('original_leadtype','=','paper')
				->first();
				
						if(!$checkphone){

  						}
  		echo $r['A']."|".$numcheck."|".$r['C']."|".$r['D']."|".$r['E']."|".$r['F']."|".$r['G']."|".$r['H']."|".$r['I']."|".$r['J']."|".$r['K']."|";;
  		echo $r['L']."|".$r['M']."|";
  		echo "<br>";
  	}


    }
}


    public function action_gettestimonials(){
        $testies = Appointment::where('testimonial','!=','')->get();
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';
        $objPHPexcel = New PHPExcel();
        $objWorksheet = $objPHPexcel->getActiveSheet();
        $i= 0; 
        $code = Setting::find(1)->distcode;
        foreach($testies as $val){
            $i++;
            $objWorksheet->getCell('A'.$i)->setValue($val->lead->cust_name);
            $objWorksheet->getCell('B'.$i)->setValue($val->lead->address);
            $objWorksheet->getCell('C'.$i)->setValue($val->testimonial);
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="file.xls"');
        $objWriter->save('php://output');
    }

  
    public function getTimes($time){
list($h , $m, $s ) = explode(":",$time);
if ( ($h == '00'  ) ) {
    $time = $m.":".$s.":".$h;
} 
return strtotime($time);
    }
    
    public function addDigits($number){
    	return array_sum(str_split($number));
    }
    
    public function getNumerology($number){
    	$n=0;
    	$arr = explode("-",$number);
    	foreach($arr as $a){
    		$n=$n+$this->addDigits($a);
    	}
    	
    	$t = $this->addDigits($n);
    	if($t>9){
    		$t= $this->addDigits($t);
    	}
    	return $t;
    }
    
    
    public function action_getnumerology($type=null){
    		if($type=="address"){
    			$leads = Lead::where('add_numerology','=',0)->where('address','!=','')->take(2000)->get();
    		} else if($type=="phone"){
    			$leads = Lead::where('num_numerology','=',0)->take(2000)->get();
    		} else {
    			$leads = Lead::where('num_numerology','=',0)->or_where('add_numerlogy','=',0)->take(2000)->get();
    		}

    		foreach($leads as $l){
			$int = filter_var($l->address, FILTER_SANITIZE_NUMBER_INT);
    			if($int>0){
    				$l->add_numerology=$this->getNumerology($int);
    			}
    				$l->num_numerology=$this->getNumerology($l->cust_num);
    			echo $int."<br>";
    			$l->save();
    			echo "saved<br>";
    		}
    }
    
    public function action_numeroStats(){
    	$address = DB::query("SELECT COUNT(*) as cnt, add_numerology, SUM(status='SOLD') sold, SUM(result='DNS') dns, SUM(status='NI') ni,
    	SUM(status='DNC') dnc, SUM(status='APP' OR status='SOLD' OR status='DNS') booked FROM leads GROUP BY add_numerology");
    	
    	$number = DB::query("SELECT COUNT(*) as cnt, num_numerology, SUM(status='SOLD') sold, SUM(result='DNS') dns, SUM(status='NI') ni,
    	SUM(status='DNC') dnc, SUM(status='APP' OR status='SOLD' OR status='DNS') booked FROM leads GROUP BY num_numerology");
    	echo "<pre>";
    	print_r($number);
    
    }
    
    
   
    
    
    
    
    
    
    
    
    
    //DATABASE MAINTENANCE / UTILITY FUNCTIONS
    public function action_applycitiestoapps(){
        $apps = Appointment::where('city','=','')->get();
        foreach($apps as $val){
            $val->city= $val->lead->city;
            $val->save();
        }
        $apps2 = Appointment::where('city','=','')->get();
    }

    public function action_adjustrebooks(){
       
    $t = DB::query("SELECT COUNT(*) as cnt, 
    SUM(leadtype='paper') paper, 
    SUM(leadtype='door') door, 
    SUM(leadtype='rebook') rebooks,
    SUM(leadtype='other') other,
    SUM(leadtype='homeshow') homeshow,
    SUM(leadtype='ballot') ballot
    FROM leads WHERE (result = 'RB-TF' OR result='RB-OF') AND app_date != '".date('Y-m-d')."' ");
    echo "<pre>";
    print_r($t);
    
   $t = DB::query("UPDATE leads SET leadtype='rebook' WHERE (result = 'RB-TF' OR result='RB-OF') AND app_date != '".date('Y-m-d')."' ");
    echo "<pre>";
    print_r($t);

       }

    public function action_applyquads(){
        $leads = Lead::where('researcher_name','=','OldSystemTransfer')->where('status','=','NEW')->or_where('status','=','NH')->get();
        

        foreach($leads as $val){
            $numcheck = substr(str_replace("-","",$val->cust_num),0, 6);
            
            $exists = Quadrant::where('exchange','=',$numcheck)->get('city_id');

            if($exists){
              $city = City::find($exists[0]->attributes['city_id'])->cityname;
            } else {  
              $city = "No Assigned City";
            }

          $val->city = $city;
          $val->save();
          echo $val->city;
        }
    }

    
    
    
    public function action_gettimes(){
        $apps = Appointment::where('in','!=','00:00:00')->where('out','!=','00:00:00')->get();
        foreach($apps as $val){
            if(($val->in!='00:00:00')&&($val->out!='00:00:00')){
            
            	$t = $this->getTimes($val->in);
            	$q = $this->getTimes($val->out);
                $timediff =($q-$t)/3600;
               $val->diff = $timediff;
               $val->save();
			echo $timediff."<br>";
              
               
            }
        }
    }


    public function action_buildstats(){
       $settings = Setting::find(1);
       $stats = DB::query("SELECT SUM(status='CANCELLED' OR status='TURNDOWN') cxl, SUM(status='COMPLETE' OR status='PAID') complete, 
        SUM(status!='CANCELLED' AND status!='TURNDOWN') total, SUM(MONTH(date) = MONTH('".date('Y-m-d')."') AND status!='CANCELLED' AND status!='TURNDOWN') monthsales from sales");
       $monthstats = DB::query("SELECT SUM(units) monthunits from appointments WHERE MONTH(app_date) = MONTH(NOW())");
       $apps = DB::query("SELECT SUM(units) units, SUM(status='DNS') DNS, SUM(status='NQ') NQ, SUM(status='SOLD') SOLD, SUM(status='INC') INC,
        SUM(status='CXL') CXL, SUM(status='INC') INC, SUM(status!='APP' AND status!='RB-TF' AND status!='RB-OF' AND status!='CXL') totdems from appointments");

       $calls = DB::query("SELECT COUNT(id) totcalls, SUM(result='APP') bookings, SUM(result='NI') NI, SUM(result='NQ') NQ, SUM(result='NH') NH, SUM(result!='NH') contact, SUM(result='DNC') dnc from calls");
       
            $check = Company::where('shortcode','=',$settings->shortcode)->get();

            if(!$check){
                $company = New Company;
                $company->shortcode = $settings->shortcode;
            } else {
                $company = Company::find($check[0]->id);
            }
            
            $units = $apps[0]->units-$company->unit_buffer;
           

            $company->total_sales = $stats[0]->total;
            $company->month_total = $stats[0]->monthsales;
            $company->month_units = $monthstats[0]->monthunits;
            $company->total_dns = $apps[0]->dns;
            $company->contest_left = $company->contest_goal-($units+$company->contest_buffer);
            $company->contest_totals = ($units)+$company->contest_buffer;
            $company->total_units = $apps[0]->units;
            $company->total_dems = $apps[0]->totdems;
            $company->total_calls = $calls[0]->totcalls;
            $company->total_bookings = $calls[0]->bookings;
            $company->total_notint = $calls[0]->ni;
            $company->total_nq = $calls[0]->nq;
            $company->total_contact = $calls[0]->contact;

            $company->total_cancelled = $stats[0]->cxl;

            $company->save();
        echo "<pre>";
       print_r($calls);
       print_r($apps);
       print_r($stats);
    }

    public function action_testcrew(){

        echo "<pre>";
        $crew = Crew::get();
        $roadcrew = Roadcrew::with('crew')->get();
        foreach($roadcrew as $val){
           print_r($val);
        }
      
    }
  
    
    public function action_sendtext(){
    echo "<form action='' method='post'>";
    echo "<input type='text' name='number' value=''/>";
    echo "<input type='submit' value='TEST TEXTING' />";
    echo "</form>";
    
    $input=Input::get();
    if(isset($input['number'])){
      $t = New Twilio;
      $num = $input['number'];
      $num = str_replace(array("-",")","("),"",$num);
      $m = "this is a test";
      print_r($t->sendSMS($num,$m));
    } 
    
    
    
    
            
         
    }

    public function action_finddupappts(){
        $array = array();
        $calls = DB::query("SELECT * FROM calls");
        foreach($calls as $val){
          echo $val->id."<br>";
            
        
        }
        print_r($array);
    }

    public function action_applypayments(){

        $apps = Sale::get();

        foreach($apps as $val){

            $val->pay_type = $val->status;
            if(($val->funded==0)&&($val->status!="CANCELLED")&&($val->status!="TURNDOWN")){
                $val->status="APPROVAL";
            }

            if(($val->payment=="VISA")||($val->payment=="MasterCard")||($val->payment=="AMEX")){
                $val->pay_type="CREDITCARD";
            } else if($val->payment=="CHQ"){
                $val->pay_type="CHEQUE";
            } else if($val->payment=="CASH"){
                $val->pay_type="CASH";
            }
            $val->save();
        }
    }


    

    public function action_findduplicates(){
      $leads = DB::query("SELECT cust_num,researcher_name,status,leadtype,original_leadtype,entry_date
              FROM leads
              GROUP BY cust_num
              HAVING count(*) > 1;");
      return View::make('template2')->with('leads',$leads);
    }

     public function action_manilladuplicates(){
            $leads = DB::query("SELECT cust_num
            FROM leads
            WHERE researcher_name = 'Upload/Manilla'
            GROUP BY cust_num
            HAVING count(*) > 1;");
            $c=0;
            return View::make('template2')->with('leads',$leads);
    }
    
     public function action_allduplicates(){

      $leads = DB::query("SELECT cust_num FROM leads GROUP BY cust_num HAVING count(*) > 1;");
      $c=0;
          
      return View::make('template2')->with('leads',$leads);
            
    }

  public function action_showleads(){
    echo "<pre>";
    $crews = RoadCrew::get();
    
    foreach($crews as $c){
      $list="";
      foreach($c->citylist() as $k=>$v){
        $list.="'".$k."',";
      }
      $list = rtrim($list,",");
      echo $list;

      print_r($list);

      $count = DB::query("SELECT SUM(status='NEW' AND leadtype='paper') manilla,
      SUM(status='NEW' AND leadtype='door') door,
      SUM(status='NEW' AND leadtype='rebook' AND app_time>=) RB,
      SUM(status='NEW' AND leadtype='rebook' AND app_time>=) RB,
      SUM(status='NEW' AND leadtype='rebook' AND app_time>=) RB,
      SUM(status='NEW' AND leadtype='rebook' AND app_time>=) RB,
      SUM(status='NEW' AND leadtype='homeshow') homeshow FROM leads WHERE city IN ($list) ");
      print_r($count);
      $leads = DB::query("SELECT count(*) FROM leads WHERE city IN ($list) AND status = 'NEW' AND leadtype='paper'");
      print_r($leads);
    }


  }

  public function action_getleads(){
    echo "<pre>";

$leadcount2 = DB::query("SELECT updated_at, assign_count FROM leads WHERE city='Victoria' AND leadtype='paper' AND status='NEW' ORDER BY assign_count ASC LIMIT 40");
print_r($leadcount2);


$leadcount = Lead::where('status','=','APP')->where('result','=','NA')->get();
foreach($leadcount as $l){
  echo $l->status."|";
  echo $l->app_time."<br><br>";
}


  }


  public function action_rebookapply(){
    $appointments = Appointment::where('app_date','>=',date('Y-m-d',strtotime('2014-06-17')))
    ->where('app_date','!=',date('Y-m-d'))
    ->where('status','=','APP')->get();


    if(!empty($appointments)){
    foreach($appointments as $a){
      if($a->lead->status=="APP" && $a->status=="APP"){
        echo "yes";
        $lead = $a->lead;
        $lead->status="NEW";
        $lead->leadtype="rebook";
        $lead->booker_id=0;
        $lead->booker_name="";
        $lead->result="";
        $lead->save();
      } else {
        echo "Already a NEW lead";
      }
        echo $a->lead->result."| ".$a->lead->status." | ".$a->result."<br>";
      }
    } else {
      echo "no data";
    }

 }
    
 public function action_uploadreggies(){
    echo "<form enctype='multipart/form-data' method='post' action=''>";
    echo "<input class='file' name='csvfile' type='file' />";
    echo "<button>UPLOAD</button></form>";
        $input = Input::all();
     
    if(!empty($input)){
        $filename = Input::file('csvfile.name');
    $tmp = Input::file('csvfile.tmp_name');

    echo $filename;
    echo $tmp;
     
        $file = $tmp;
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

        $xls = PHPExcel_IOFactory::load($file);
        $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
    
            foreach($rows as $k=>$val){

              if($k!=1){
                 $asthma = $val['A'];
              $smoke = $val['B'];
              $pets = $val['C'];
              $name = $val['D'];
              $address = $val['E'];
              $city = $val['F'];
              $phone = $val['G'];
              $user = $val['H'];

             
              if($user=="Victoria"){
                $id=237;
              } else if($user=="Penache") {
                $id=238;
              } else if($user=="Jen"){
                $id=239;
              }  else if($user=="Nick"){
                $id=241;
              }
             

              if($address==NULL){
                $address = "";
              }

             
              $leadtype = "door";
              $id=0;
              $entrydate = date('Y-m-d');
              $num = substr($phone,0,3)."-".substr($phone,3,3)."-".substr($phone,6,4);
              $number = explode("-",$num);
              $check = Lead::where('cust_num','=',$num)->count();
                if($check==0){
                  $lead = New Lead;
                  $lead->researcher_id = $id;
                  $lead->researcher_name = $user;
                  $lead->leadtype = $leadtype;
                  $lead->original_leadtype = $leadtype;
                  $lead->entry_date = $entrydate;
                  $lead->cust_name = $name;
                  $lead->address = $address;
                  $lead->cust_num = $num;
                  $lead->city = $city;
                  $lead->status = "INACTIVE";
                  $lead->smoke = $smoke;
                  $lead->pets = $pets;
                  $lead->asthma = $asthma;
                  $lead->save();
                  echo "Successful entry<br>";
                  echo $leadtype."|".$entrydate." | ".$address."|".$name ." | ".$num." | ".$lead->status."<br>";
                } else {
                  echo "failed...Already in<br>";
                }
              }
            }
      }
    }
  

	public function action_uploadoldbatch(){
		echo "<form enctype='multipart/form-data' method='post' action=''>";
		echo "<input class='file' name='csvfile' type='file' />";
		echo "<button>UPLOAD</button></form>";
        $input = Input::all();
	   
    if(!empty($input)){
        $filename = Input::file('csvfile.name');
		$tmp = Input::file('csvfile.tmp_name');

		echo $filename;
		echo $tmp;
	   
        $file = $tmp;
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

        $xls = PHPExcel_IOFactory::load($file);
        $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
    
            foreach($rows as $val){
            	$name = $val['A'];
            	$address = $val['B'];
            	$city = $val['E'];
            	$num = $val['H'];
            	$status = $val['M'];
            	$married = $val['J'];
            	$rent = $val['K'];

            	if(($name==NULL)||($name=="")){
                    $name = $val['B'];
                }
                if(($name==NULL)||($name=="")){
                    $name = $val['C'];
                }
                if(($name==NULL)||($name=="")){
                    $name = "No Name Given";
                }

            	if($status==""){
            		$status = "NEW";
            	}
            	if($rent=="rent"){
            		$status = "INVALID";
                    $rentown = "R";
            	} else {
                    $rentown = "O";
                }

            	$leadtype = $val['N'];
            	if($leadtype==""){
            		$leadtype="paper";
            		$or = "paper";
            	} elseif($leadtype=="DR"){
            		$leadtype="door";
            		$or = "door";
            	} else {
            		$leadtype="other";
            		$or = "other";
            	}

            	if($address==NULL){
            		$address = "";
            	}

            	if($married==NULL){
            		$married="";
            	}

            	$entrydate = date('Y-m-d',strtotime($val['L']));
            	$num = substr($num,0,3)."-".substr($num,3,3)."-".substr($num,6,4);
            	
            	$number = explode("-",$num);
            	
            	$check = Lead::where('cust_num','=',$num)->count();

            	if($check==0){
            		
            		$lead = New Lead;
            		$lead->researcher_id = 0;
            		$lead->researcher_name = "OldSystemTransfer";
            		$lead->leadtype = $leadtype;
            		$lead->original_leadtype = $or;
            		$lead->entry_date = $entrydate;
            		$lead->cust_name = $name;
                    $lead->rentown = $rentown;
            		$lead->address = $address;
            		$lead->cust_num = $num;
            		$lead->city = $city;
            		$lead->status = $status;
            		$lead->married = $married;
            		$lead->save();
            		echo "Successful entry<br>";

            	} else {
            		echo "failed";
            	}
            	//echo $leadtype."|".$entrydate." | ".$address."|".$name ." | ".$num." | ".$status."<br>";

            }
 	
      }
    }

    public function action_uploadoldbatchbez(){
        echo "<form enctype='multipart/form-data' method='post' action=''>";
        echo "<input class='file' name='csvfile' type='file' />";
        echo "<button>UPLOAD</button></form>";
        $input = Input::all();
       
    if(!empty($input)){
        $filename = Input::file('csvfile.name');
        $tmp = Input::file('csvfile.tmp_name');

      
        $file = $tmp;
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

        $xls = PHPExcel_IOFactory::load($file);
        $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
        echo "<pre>";
        $existcount=0;
        $entrycount=0;
            foreach($rows as $val){
                $num = $val['H'];
                $num = substr($num,0,3)."-".substr($num,3,3)."-".substr($num,6,4);
                $number = explode("-",$num);
                /*$check = Lead::where('cust_num','=',$num)->count();
                if($check>0){
                    $existcount++;
                } else {*/
                $name = $val['A'];
                if(($name==NULL)||($name=="")){
                    $name = $val['B'];
                }
                if(($name==NULL)||($name=="")){
                    $name = $val['C'];
                }
                if(($name==NULL)||($name=="")){
                    $name = "No Name Given";
                }
                $address = $val['D'];
                
                $city = $val['E'];
                $smoke = $val['L'];
                $pets = $val['M'];
                $asthma = $val['N'];
                $rentown = $val['O'];
                $years = $val['P'];
                $fullpart = $val['S'];
                $job = $val['Q'];
                $spouse_job = $val['R'];
                $jobyrs = $val['U'];
                $spouseyrs = $val['V'];
                $entry_date = $val['W'];
                $assign_count = $val['X'];
                $married = $val['K'];

                $status = $val['AA'];
                $notes = $val['AB'];

                if($fullpart=="full time"){
                    $fullpart = "FT";
                } elseif($fullpart=="part time"){
                    $fullpart = "PT";
                } else {
                    $fullpart = "FT";
                }


                if($married==""){
                    $married = "married";
                }

                if($smoke=="yes"){
                    $smoke = "Y";
                } else {
                    $smoke = "N";
                }
                 if($pets=="yes"){
                    $pets = "Y";
                } else {
                    $pets = "N";
                }
                 if($asthma=="yes"){
                    $asthma = "Y";
                } else {
                    $asthma = "N";
                }


                if($status==""){
                    $status = "NEW";
                } 
                if($status=="W#"){
                    $status = "Wrong Number";
                }


                if($rentown=="rent"){
                    $status = "INVALID";
                    $rentown = "R";
                } else {
                    $rentown = "O";
                }

                $leadtype = $val['AD'];
                if($leadtype==""){
                    $leadtype="paper";
                    $or = "paper";
                } elseif($leadtype=="DR"){
                    $leadtype="door";
                    $or = "door";
                } else {
                    $leadtype="other";
                    $or = "other";
                }

                if($address==NULL){
                    $address = "";
                }

                if($spouse_job==NULL){
                    $spouse_job="";
                }

                if($job==NULL){
                    $job = "";
                }

                if($jobyrs==NULL){
                    $jobyrs = "0 yrs";
                }
                if($spouseyrs==NULL){
                    $spouseyrs = "0 yrs";
                }
                 if($years==NULL){
                    $years = "0 yrs";
                }

                if($notes==NULL){
                    $notes="";
                }
  
                if($val['W']=="0000-00-00 00:00:00"){
                    $val['W'] = date('Y-m-d');
                }
                 $entry_date = date('Y-m-d',strtotime($val['W']));
                
                if($city==NULL){
                    $city = "No Assigned City";
                }

                    $lead = New Lead;
                    $lead->researcher_id = 0;
                    $lead->researcher_name = "OldSystemTransfer";
                    $lead->leadtype = $leadtype;
                    $lead->original_leadtype = $or;
                    $lead->entry_date = $entry_date;
                    $lead->cust_name = $name;
                    $lead->rentown = $rentown;
                    $lead->address = $address;
                    $lead->smoke = $smoke;
                    $lead->asthma = $asthma;
                    $lead->pets = $pets;
                    $lead->jobyrs = $jobyrs;
                    $lead->spouseyrs = $spouseyrs; 
                    $lead->yrs = $years;
                    $lead->fullpart = $fullpart;
                    $lead->job = $job;
                    $lead->spouse_job = $spouse_job;
                    $lead->cust_num = $num;
                    $lead->city = $city;
                    $lead->status = $status;
                    $lead->assign_count = $assign_count;
                    $lead->notes = $notes;
                    $lead->married = $married;
                    $lead->save();



                $entrycount++;
        }
            echo $entrycount." Were uploaded";
      }
    }


    public function action_uploadoldbatchwin(){
        echo "<form enctype='multipart/form-data' method='post' action=''>";
        echo "<input class='file' name='csvfile' type='file' />";
        echo "<button>UPLOAD</button></form>";
        $input = Input::all();
       
    if(!empty($input)){
        $filename = Input::file('csvfile.name');
        $tmp = Input::file('csvfile.tmp_name');

        echo $filename;
        echo $tmp;
       
        $file = $tmp;
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

        $xls = PHPExcel_IOFactory::load($file);
        $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
    
            foreach($rows as $val){
                $name = $val['A'];
                $address = $val['B'];
                $city = $val['E'];
                $num = $val['H'];
                $status = $val['N'];
                $married = $val['J'];
                $rent = $val['K'];

                if($name==NULL){
                    $name="No Name Entered";
                }
                
                if($status==""){
                    $status = "NEW";
                }
                if($rent=="rent"){
                    $status = "INVALID";
                    $rentown = "R";
                } else {
                    $rentown = "O";
                }

                

                if($address==NULL){
                    $address = "";
                }

                if($married==NULL){
                    $married="";
                }

                $job = $val['M'];
                if($job==NULL){
                    $job="";
                }

                if($city==NULL){
                    $city="No Assigned City";
                }

                $entrydate = date('Y-m-d',strtotime($val['L']));
                $num = substr($num,0,3)."-".substr($num,3,3)."-".substr($num,6,4);
                
                $number = explode("-",$num);
                
                $check = Lead::where('cust_num','=',$num)->count();

                if($check==0){
                    
                    $lead = New Lead;
                    $lead->researcher_id = 0;
                    $lead->researcher_name = "OldSystemTransfer";
                    
                    $lead->original_leadtype = "paper";
                    $lead->entry_date = $entrydate;
                    $lead->cust_name = $name;
                    $lead->leadtype="paper";
                    $lead->rentown = $rentown;
                    $lead->job = $job;
                    $lead->notes = $job;
                    $lead->address = $address;
                    $lead->cust_num = $num;
                    $lead->city = $city;
                    $lead->status = $status;
                    $lead->married = $married;
                    $lead->save();
                    echo "Successful entry<br>";

                } else {
                    echo "Number Already In System<br/><br/>";
                }
            }
      }
    }

    public function action_salesjournal(){
        echo "<form enctype='multipart/form-data' method='post' action=''>";
        echo "<input class='file' name='csvfile' type='file' />";
        echo "<button>UPLOAD</button></form>";
        $input = Input::all();
       
    if(!empty($input)){
        $filename = Input::file('csvfile.name');
        $tmp = Input::file('csvfile.tmp_name');

        echo $filename;
        echo $tmp;
       
        $file = $tmp;
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

        $xls = PHPExcel_IOFactory::load($file);
        $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
    
            foreach($rows as $val){
                if(!empty($val['A'])){
                    $string = str_replace(' ', '', $val['A']);
                    $string = preg_replace('/\s+/', '', $string);
                    if(strlen($string)==10){
                        $one = substr($string, 0,3);
                        $two = substr($string, 3,3); 
                        $three = substr($string, 6,4);
                        $num = $one."-".$two."-".$three;

                    $check = Lead::where('cust_num','=',$num)->first();
                    if($check){
                        if(($check->status=="NEW")||($check->status=="NH")){
                            $check->status ="INVALID";
                            $check->save();
                            echo "number already in......NOW UPDATED<br>";
                        }
                    } else {

                         $lead = New Lead;
                    $lead->researcher_name = "SalesJournalTransfer";
                    $lead->entry_date = date('Y-m-d');
                    $lead->original_leadtype = 'salesjournal';
                    $lead->cust_num = $num;
                    $lead->status = "INVALID";
                    $lead->save();
                    echo "NEW LEAD HAS BEEN ENTERED<br>";
                    }
                }
                }
            }
        }
    }

    public function action_saleupdate(){
        $sales = Sale::get();

        foreach($sales as $val){
            $val->defone_old = $val->defone;
            $val->deftwo_old = $val->deftwo;
            $val->maj_old = $val->maj;
            $val->att_old = $val->att;
            if($val->save()){
                echo $val->id."<br><br>";
            };
        }
    }




}