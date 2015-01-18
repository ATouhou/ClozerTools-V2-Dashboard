<?php
class Reports_Controller extends Base_Controller
{
	public function __construct(){
    parent::__construct();
    $this->filter('before', 'auth');
    
  }

  public function action_index(){
    return View::make('reports.index');
  }

  public function action_wrongnums(){
    $input = Input::get();
       if(empty($input)){
        $datemin = date('Y-m-d');
        $datemax = date('Y-m-d');
      } else {
        $datemin = $input['startdate'];
        $datemax = $input['startdate'];
      }

      $title="Wrong Numbers For ".$datemin;
      $nums = DB::query("SELECT * FROM leads WHERE DATE(call_date) = DATE('".date('Y-m-d',strtotime($datemin))."') AND (status='WrongNumber' OR status='DNC') AND booker_id!=0 AND booker_name!='' ORDER BY booker_id, status, city ");
      return View::make("reports.wrongnums")->with('nums',$nums)->with('date',$datemin);

  }

  public function action_soldapps(){
    $input = Input::get();
       if(empty($input)){
        $datemin = date('Y-m-d');
        $datemax = date('Y-m-d');
      } else {
        $datemin = $input['startdate'];
        $datemax = $input['startdate'];
      }
      $d = date('Y-m-d',strtotime($datemin));
      if(isset($input['booker-id'])){
        $user = User::find($input['booker-id']);
        $sales = Sale::where('booker_id','=',$input['booker-id'])
        ->where('date','=',$d)->order_by('cust_name')->get(array('booker_id','typeofsale','status','id','cust_name',));
        $pdf = new Fpdf();
        $pdf->AddPage();
         $pdf->SetFont('Arial','B',16);
         $pdf->Cell(50,10,"Sales Under ".$user->fullName()." for ".date('M-d',strtotime($d)),16);
         $pdf->Ln();$pdf->Ln();

        $pdf->SetFont('Arial','B',9);
        // Header
        $columns = array("Booked By","Sale Type","Status","Customer","Number","Address");
        $sale=array();
        foreach($sales as $s){
          $sale[] = $s->attributes;
        }
        foreach($columns as $c){
           if($c=="Number" || $c=="Status"){
            $pdf->Cell(20,6,strtoupper($c),1);
          } else if($c=="Address") {
            $pdf->Cell(60,6,strtoupper($c),1);
          } else {
            $pdf->Cell(30,6,strtoupper($c),1);
          }
        }
        $pdf->Ln();
        $pdf->SetFont('Arial','',7);
        foreach($sale as $rows){
          $sale = Sale::find($rows['id']);
          $rows["cust_num"] = $sale->lead->cust_num;
          $rows["address"] = $sale->lead->address;

          foreach($rows as $k=>$col){
            if($k=="booker_id"){
              $col = $user->fullName();
            }
            if($k!="id"){
               if($k=="cust_num" || $k=="status"){
                $pdf->Cell(20,6,strtoupper($col),1);
              } else if($k=="address"){
                $pdf->Cell(60,6,strtoupper($col),1);
              } else {
                $pdf->Cell(30,6,strtoupper($col),1);
              }
              
            } 


          }
          $pdf->Ln();
                
        }
        
       
        $content =$pdf->Output();
        return Response::make($content, 200, array('content-type'=>'application/pdf'));
      } else {
          
          $users = User::allUsers("agent");
          $sales = Sale::where('booker_id','!=',0)->where('date','=',$d)->order_by('booker_id')->order_by('cust_name')->get();
          $sale=array();
            foreach($sales as $s){
              $sale[$s->booker_id][] = $s;
            }
          
          $title="Sold Appointments For ".$datemin;
           return View::make("reports.soldapps")->with('agents',$users)->with('sales',$sale)->with('date',$datemin);
      }
     
  }

  public function action_dailysnapshot(){
  	 if(Auth::user()->user_type=="agent" && Auth::user()->assign_leads!=1){return Redirect::to('dashboard');}
        if(Auth::user()->user_type=="doorrep"){return Redirect::to('dashboard');}
    $input = Input::get();
       if(empty($input)){
        $datemin = date('Y-m-d');
        $datemax = date('Y-m-d');
      } else {
        $datemin = $input['startdate'];
        $datemax = $input['startdate'];
      }

      $title="Daily Snap for ".$datemin;

      $salestats = Stats::saleStats($datemin,$datemax,"");
    
      $bookerstats = DB::query("SELECT caller_id,length,
        SEC_TO_TIME(AVG(TIME_TO_SEC(length))) as avgtime,
        SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,
        SUM(result != '' ) totals,
        SUM(result='CONF') confirms, SUM(result='NA') na,
        SUM(result = 'APP') app,SUM(result = 'DNC') dnc,SUM(result = 'NH') nh, 
        SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'NQ' OR result='NI') ninq,SUM(result = 'Recall') recall,
        SUM(result = 'WrongNumber') wrong FROM calls 
        WHERE DATE(created_at) >= DATE('".$datemin."') AND DATE(created_at) <= DATE('".$datemax."') GROUP BY caller_id ORDER BY app DESC");

      $appdetails = DB::query("SELECT *, IF(puton + total, 100*puton/total, NULL) AS hold 
        FROM (SELECT COUNT(*) as total, booked_by, booker_id,
        SUM(status='DNS')dns, SUM(status='INC') inc, SUM(status='SOLD') sales,SUM(status='CXL') cxl,
        SUM(status='DNS' OR status='INC' OR status='SOLD') puton, SUM(status='RB-TF') rbtf, SUM(status='RB-OF') rbof
        FROM appointments WHERE app_date >= DATE('".$datemin."') AND app_date <= DATE('".$datemax."') GROUP BY booker_id) as SUBQUERY ORDER BY booked_by");

      $apphours = DB::query("SELECT caller_id,FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at)/3600)*3600) AS cre,
        length,
        SEC_TO_TIME(AVG(TIME_TO_SEC(length))) as avgtime,
        SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,
        SUM(result != '' ) totals,
        SUM(result='CONF') confirms, SUM(result='NA') na,
        SUM(result = 'APP') app,SUM(result = 'DNC') dnc,SUM(result = 'NH') nh, 
        SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'NQ' OR result='NI') ninq,SUM(result = 'Recall') recall,
        SUM(result = 'WrongNumber') wrong FROM calls 
        WHERE DATE(created_at) >= DATE('".$datemin."') AND DATE(created_at) <= DATE('".$datemax."') GROUP BY HOUR(created_at), caller_id ORDER BY caller_id, cre");


      $appdetailsarray=array();
      foreach($appdetails as $val){
          $u = User::find($val->booker_id);
          if(!empty($u)){
            if($u->user_type=="agent" || $u->user_type=="manager"){
              $appdetailsarray[$val->booker_id]=array("salestats"=>$val,"payrate"=>$u->payrate);
            } else {

            }
          }
        }

      foreach($apphours as $ap){
        if(array_key_exists($ap->caller_id,$appdetailsarray)){
          $appdetailsarray[$ap->caller_id]["hourlystats"][$ap->cre] = $ap;
        }
      }

      foreach($bookerstats as $val){
        if(array_key_exists($val->caller_id,$appdetailsarray)){
          $appdetailsarray[$val->caller_id]["callstats"] = $val;
        }
      }

      $appointments = Appointment::where('app_date','=',$datemin)->where('status','!=','APP')
      ->where('status','!=','NA')->where('status','!=','CONF')->order_by('app_time')->order_by('status')->get();

      return View::make('reports.daily')
      ->with('title',$title)
      ->with('salestats',$salestats)
      ->with('startdate',$datemin)
      ->with('enddate',$datemax)
      ->with('appointments',$appointments)
      ->with('bookdetails',$appdetailsarray);

  }



public function action_marketing(){
	 if(Auth::user()->user_type=="agent" && Auth::user()->assign_leads!=1){return Redirect::to('dashboard');}
        if(Auth::user()->user_type=="doorrep"){return Redirect::to('dashboard');}
    $input = Input::get();
      if(empty($input)){
        $title = "Marketing Stats This Week";
        $day = date('w');
        $day = $day-1;
        $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
        $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));
      } else {
        $datemin = $input['startdate'];
        $datemax = $input['enddate'];
        $title = "Marketing Stats (".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).")";
      }

      $paperanddoor = DB::query("SELECT COUNT(*) as total, leadtype, original_leadtype, 
        SUM(status!='WrongNumber' AND status!='INVALID' AND entry_date>=DATE('".$datemin."') AND entry_date <=DATE('".$datemax."')) tot,
        SUM(status!='WrongNumber' AND status!='INVALID' AND birth_date>=DATE('".$datemin."') AND birth_date <=DATE('".$datemax."') AND original_leadtype='secondtier') totsecondtier,
        SUM(result='DNS' AND app_date>=DATE('".$datemin."') AND app_date <=DATE('".$datemax."')) dns, 
        SUM(result='SOLD' AND app_date>=DATE('".$datemin."') AND app_date <=DATE('".$datemax."') ) sold,
        SUM(result='NQ' AND app_date>=DATE('".$datemin."') AND app_date <=DATE('".$datemax."')) nq FROM leads GROUP BY original_leadtype");

     /* $stats = DB::query("SELECT COUNT(*) AS total, caller_id, leadtype, created_at, 
        SUM(result != '' AND result !='CONF' AND result != 'NA') rangetot,
        SUM(result='CONF') rangeconfirms, SUM(result='NA') rangena,
        SUM(result = 'APP') rangeapp,SUM(result = 'DNC') rangednc,
        SUM(result = 'NH') rangenh,SUM(result = 'NI') rangeni,
        SUM(result = 'NQ') rangenq,SUM(result = 'WrongNumber') rangewrong,
        SUM(result = 'Recall') rangerecall FROM calls WHERE DATE(created_at) >=DATE('".$datemin."') AND DATE(created_at) <=DATE('".$datemax."') GROUP BY caller_id, leadtype");
  */
    
      $bookerstats = DB::query("SELECT caller_id,
        SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,
        SUM(result != '' ) totals,
        SUM(result='CONF') confirms, SUM(result='NA') na,
        SUM(result = 'APP') app,SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,
        SUM(result = 'NID') nid, SUM(result='NEW') new,
        SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
        SUM(result = 'WrongNumber') wrong FROM calls 
        WHERE DATE(created_at) >= DATE('".$datemin."') AND DATE(created_at) <= DATE('".$datemax."') GROUP BY caller_id ORDER BY app DESC");


      $appdetails = DB::query("SELECT *, IF(puton + total, 100*puton/total, NULL) AS hold 
        FROM (SELECT COUNT(*) as total, booked_by, booker_id,
        SUM(status='DNS')dns, SUM(status='INC') inc, SUM(status='SOLD') sales,SUM(status='CXL') cxl,
        SUM(status='DNS' OR status='INC' OR status='SOLD') puton
        FROM appointments WHERE DATE(app_date) >= DATE('".$datemin."') AND DATE(app_date) <= DATE('".$datemax."') GROUP BY booker_id) as SUBQUERY ORDER BY booked_by");

      $appdetailsarray=array();
        foreach($appdetails as $val){
          $u = User::find($val->booker_id);
          if(!empty($u)){
            if($u->user_type=="agent" || $u->user_type=="manager"){
              $appdetailsarray[$val->booker_id]=array("salestats"=>$val,"payrate"=>$u->payrate);
            } else {

            }
          }
        }

      foreach($bookerstats as $val){
        if(array_key_exists($val->caller_id,$appdetailsarray)){
          $appdetailsarray[$val->caller_id]["callstats"] = $val;
        }
      }

      $marketstats = $this->marketingpodium($datemin, $datemax);
      $apptimes = User::appTimes($datemin,$datemax);
      
      return View::make('reports.marketing')
      ->with('paperanddoor',$paperanddoor)
      ->with('apptimes',$apptimes)
      ->with('marketstats',$marketstats)
      ->with('marketingreports',$appdetailsarray)
      ->with('startdate',$datemin)
      ->with('enddate',$datemax)
      ->with('title',$title);
  }


  //FUNCTIONS
  public function marketingpodium($start, $end){
    //BOOKER STATS AND STUFF
    $allrephold = DB::query("SELECT *, IF(book + tot, 100*book/(book + tot), NULL) AS hold 
    FROM (SELECT COUNT(*) as total, booker_id, booked_by,SUM(status='DNS' OR status='SOLD') book, 
    SUM(status!='DNS' AND status!='SOLD') tot FROM appointments WHERE app_date>=DATE('".$start."') AND app_date<=DATE('".$end."') 
    GROUP BY booker_id) AS subquery ORDER BY hold DESC, total DESC");
    
    $allrepputon = DB::query("SELECT COUNT(*) as total, booker_id, booked_by,
    SUM(status='DNS' OR status='SOLD')puton FROM appointments WHERE app_date>=DATE('".$start."') AND app_date<=DATE('".$end."') GROUP BY booker_id ORDER BY puton DESC");
    
    $allrepbook = DB::query("SELECT *, IF(app + ni, 100*app/(app + ni), NULL) AS book 
      FROM (SELECT COUNT(*) as total, caller_id, caller_name,
      SUM(result = 'APP') app,SUM(result = 'NI') ni,SUM(result = 'NI') nid
      FROM calls WHERE created_at>=DATE('".$start."') AND created_at<=DATE('".$end."') GROUP BY caller_id) AS subquery ORDER BY app DESC");

    $monthbookerstats = DB::query("SELECT *, IF(ni, 100*app/(ni+app), NULL) AS book 
      FROM (SELECT COUNT(id) as total, leadtype, caller_id,SUM(result != '' AND result != 'CONF' 
      AND result != 'NA') tot,SUM(result = 'APP') app,
      SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,SUM(result='NID') nid, SUM(result='NEW') newsurvey, SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
      SUM(result = 'WrongNumber') wrong FROM calls WHERE created_at>=DATE('".$start."') AND created_at<=DATE('".$end."')  GROUP BY caller_id, leadtype) AS subquery ORDER BY app DESC");

     
    $arr2 = array();
    foreach($monthbookerstats as $val){
      $u = User::find($val->caller_id);
      if(!empty($u)){
        if($u->user_type=="agent"){
          $val->booker_id = $val->caller_id;
          $val->caller_id = $u->firstname." ".$u->lastname;
          array_push($arr2, $val);
        }
      }
    }

      $allrepholdarray=array();
      foreach($allrephold as $val){
        $u = User::find($val->booker_id);
        if(!empty($u)){
          if(($u->user_type=="agent")&&($u->level!=99)){
            $allrepholdarray[] = array(
              "booker_name"=>$u->firstname." ".$u->lastname,
              "booker_id"=>$val->booker_id,
              "hold"=>number_format($val->hold,2,'.',''),
              "total"=>$val->tot,
              "alltotal"=>$val->total,
              "booked"=>$val->book
              );
          }
        }
      }

      $allrepbookarray=array();
      foreach($allrepbook as $val){
        $u = User::find($val->caller_id);
        if(!empty($u)){
          if(($u->user_type=="agent")&&($u->level!=99)){
            $allrepbookarray[] = array(
              "booker_id"=>$val->caller_id,
              "booker_name"=>$val->caller_name,
              "app"=>$val->app,
              "bookper"=>number_format($val->book,2,'.',''),
              "total"=>$val->total,
              "ni"=>$val->ni
            );
          }
        }
      }
        
      $allrepputonarray=array();
      foreach($allrepputon as $val){
        $u = User::find($val->booker_id);
        if(!empty($u)){
          if(($u->user_type=="agent")&&($u->level!=99)){
            $allrepputonarray[] = array(
              "booker_id"=>$val->booker_id,
              "puton"=>$val->puton,
              "booker_name"=>$u->firstname
              );
          }
        }
      }
        
      $results=array("puton"=>$allrepputonarray,"booked"=>$allrepbookarray,"hold"=>$allrepholdarray,"stats"=>$arr2);
      return $results;
  }

  public function action_door($type=null){
  	 if(Auth::user()->user_type=="agent" && Auth::user()->assign_leads!=1){return Redirect::to('dashboard');}
        if(Auth::user()->user_type=="doorrep"){return Redirect::to('dashboard');}
    $input=Input::get();
    if((isset($type))&&($type=="map")){
      
      if(isset($input['id'])){
        $coordinates = DB::query("SELECT id, address,  sale_id, leadtype, original_leadtype,lat, lng, cust_name, booker_name, researcher_name, researcher_id, status, entry_date, cust_num, assign_count, result,notes
        FROM leads WHERE researcher_id=".Input::get('id')." AND original_leadtype = 'door' AND entry_date>=DATE('".Input::get('to')."') AND entry_date<=DATE('".Input::get('from')."') ORDER BY status, entry_date DESC");
      } else if(isset($input['cityname'])) {
        $coordinates = DB::query("SELECT id, address, sale_id, leadtype, original_leadtype,lat, lng, cust_name, booker_name, researcher_name, researcher_id, status, entry_date, cust_num, assign_count, result,notes
        FROM leads WHERE original_leadtype = 'door' AND city LIKE '%".$input['cityname']."%'   ");
      } else {
        $coordinates = DB::query("SELECT id, address, sale_id, leadtype, original_leadtype,lat, lng, cust_name, booker_name, researcher_name, researcher_id, status, entry_date, cust_num, assign_count, result,notes
        FROM leads WHERE original_leadtype = 'door' AND entry_date>=DATE('".Input::get('to')."') AND entry_date<=DATE('".Input::get('from')."')");
      }
       
      $markers = array();
      $i=1;
      $iconcount = 1;
      $id = 0;
      foreach($coordinates as $val){
        if(!empty($val->address)){
          if(isset($input['plainicons'])){
                $label="";$tag = $val->status;
                if($val->status=="APP"){
                  $tag = $val->result;
                  $icon = URL::to_asset('img/door-regy1.png');
                } else if($val->status=="NEW"){
                  $icon = URL::to_asset('img/door-regy2.png');
                } else if($val->status=="SOLD" || $val->result=="SOLD"){
                  $tag = $val->result;
                  $icon = URL::to_asset('img/door-regy5.png');
                } else if($val->status=="INACTIVE"){
                  $icon = URL::to_asset('img/door-regy2.png');
                } else {
                  $icon = URL::to_asset('img/door-regy4.png');
                }

              } else {
          $user = $val->researcher_id;
          if(User::find($user)->user_type=="doorrep"){
           // $icon = URL::to_asset('img/door-regy'.$iconcount.'.png');
             $tag = $val->status;
               $label = "success special blackText";
                $icon = URL::to_asset('img/')."small-".$val->status.".png";
                
          if($val->status=="NEW"){

            if($val->leadtype=="rebook"){

                $label = "important special";
                $icon = URL::to_asset('img/')."app-small-RB.png";
            } 
          }

              if($val->status=="APP"){
              $icon = URL::to_asset('img/')."app-small-".$val->result.".png";
                if($val->result=="DNS"){
                $tag = $val->result;
                $label = "important special";
                
                } else if($val->result=="INC") {
                     $tag = $val->result;
                $label = "success warning";
                
                } else if(($val->result=="APP")||($val->result=="DISP")){
                $tag = $val->result;
                $label = "info special";
                   $icon = URL::to_asset('img/')."app-highlight-".$val->result.".png";
                }
             
              } else if($val->status=="SOLD"){
              $s = Sale::find($val->sale_id);
              if($s){
                 $label = "success special";
                $icon = URL::to_asset('images/')."pureop-small-".$s->typeofsale.".png";
              } else {
               $label = "success special";
                $icon = URL::to_asset('img/door-regy-sold.png');
              }
   
               
              }  else {
                //$label = "inverse";$tag = "all";
              }
              if($val->status=="ASSIGNED"){
              $assigned = "to ".$val->booker_name;
              } else {
              $assigned="";}

           
          }
        }
      }
         $markers[] = array("latLng"=>array($val->lat,$val->lng),
            "data"=>"Customer : ".$val->cust_name."<br>".$val->address."<br>Date : ".$val->entry_date." <br>Surveyor : ".$val->researcher_name."<br>Status : <span class='label label-".$label."'>".$val->status."</span>",
            "tag"=>$tag,"options"=>array("icon"=>$icon));
        //$thedata[] = $val;
      } 
        if(!empty($coordinates)){
          $lat = $val->lat;
          $lng = $val->lng;
          $empty = false;
        } else {
          $lat = Setting::find(1)->lat;
          $lng = Setting::find(1)->lng;
          $empty = true;
        }
        if(empty($input)){
          return json_encode(array("map"=>$markers,'latlng'=>array($lat,$lng),'empty'=>$empty));
        } else {
          return json_encode(array("map"=>$markers,'latlng'=>array($lat,$lng),'empty'=>$empty));
        }
    } else {
      $input = Input::get();
        if(empty($input)){
          $title = "Dorr Reggies This Week";
          $day = date('w');
          $day = $day-1;
          $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
          $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));
        } else {
          $datemin = $input['startdate'];
          $datemax = $input['enddate'];
          $title = "Door Reggies for (".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).")";
        }

      $doorreporttime = DB::query("SELECT COUNT(id) as total, researcher_id, researcher_name,lat, lng,
        SUM(status!='WrongNumber') valid, SUM(status='WrongNumber' OR status='INVALID') wrong, SUM(status='NQ' AND nqreason='renter') renters, SUM(status='NI') ni,
        SUM(status='APP' OR status='SOLD' OR status='DNS' OR status='CONF') booked,SUM(result='DNS' AND status='APP') dns,
        SUM(status='DNC') dnc, SUM(status='NEW') avail, SUM(status='INACTIVE') unreleased, SUM(status='SOLD') sold, SUM(status='DNC') dnc, SUM(result='DNS' or result='SOLD') puton
        FROM leads WHERE original_leadtype = 'door' AND entry_date>= DATE('".$datemin."') AND entry_date<= DATE('".$datemax."') GROUP BY researcher_id");
      
        $numero = array();//Stats::getNumerology();
        

      return View::make('reports.door')
      ->with('numero',$numero)
      ->with('doorreports',$doorreporttime)
      ->with('startdate',$datemin)
      ->with('enddate',$datemax)
      ->with('title',$title);
    }
  }

  public function action_other($map=null){
  	 if(Auth::user()->user_type=="agent" && Auth::user()->assign_leads!=1){return Redirect::to('dashboard');}
        if(Auth::user()->user_type=="doorrep"){return Redirect::to('dashboard');}
    $type = Input::get('leadtype_get'); 
    if(empty($type)){
    $type="paper";
   
    }
     $t = "= '".$type."'";
    if($type=="all"){
       $t = "!= 'door'";
    }
        
        if((isset($map))&&($map=="map")){
      
      if(isset($input['id'])){
        $coordinates = DB::query("SELECT id, address, sale_id, leadtype, original_leadtype,lat, lng, cust_name, booker_name, researcher_name, researcher_id, status, entry_date, cust_num, assign_count, result,notes
        FROM leads WHERE researcher_id=".Input::get('id')." AND original_leadtype ".$t." AND entry_date>=DATE('".Input::get('to')."') AND entry_date<=DATE('".Input::get('from')."') ORDER BY status, entry_date DESC");
      } else {
        $coordinates = DB::query("SELECT id, address, leadtype, original_leadtype, sale_id, lat, lng, cust_name, booker_name, researcher_name, researcher_id, status, entry_date, cust_num, assign_count, result,notes
        FROM leads WHERE  original_leadtype ".$t." AND entry_date>=DATE('".Input::get('to')."') AND entry_date<=DATE('".Input::get('from')."')");
      }
     
      $markers = array();
      $i=1;
      $iconcount = 1;
      $id = 0;
      foreach($coordinates as $val){
        if(!empty($val->address)){
          $user = $val->researcher_id;
           $tag = $val->status;
                $label = "success special blackText";
                $icon = URL::to_asset('img/')."small-".$val->status.".png";
                
          if($val->status=="NEW"){

            if($val->leadtype=="rebook"){

                $label = "important special";
                $icon = URL::to_asset('img/')."app-small-RB.png";
            } 
          }

              if($val->status=="APP"){
              $icon = URL::to_asset('img/')."app-small-".$val->result.".png";
                if($val->result=="DNS"){
                $tag = $val->result;
                $label = "important special";
                
                } else if($val->result=="INC") {
                     $tag = $val->result;
                $label = "success warning";
                
                } else if(($val->result=="APP")||($val->result=="DISP")){
                $tag = $val->result;
                $label = "info special";
                   $icon = URL::to_asset('img/')."app-highlight-".$val->result.".png";
                }
             
              } else if($val->status=="SOLD"){
              $s = Sale::find($val->sale_id);
              if($s){
                 $label = "success special";
                $icon = URL::to_asset('images/')."pureop-small-".$s->typeofsale.".png";
              } else {
               $label = "success special";
                $icon = URL::to_asset('img/door-regy-sold.png');
              }
   
               
              }  else {
                //$label = "inverse";$tag = "all";
              }
              if($val->status=="ASSIGNED"){
              $assigned = "to ".$val->booker_name;
              } else {
              $assigned="";}
              
            $markers[] = array("latLng"=>array($val->lat,$val->lng),
            "data"=>"Customer : ".$val->cust_name."<br>Address: ".$val->address."<br>Entry Date : ".$val->entry_date." <br>Surveyor : ".$val->researcher_name."<br>Status : <span class='label label-".$label."'>".$val->status." ".$assigned."</span>",
            "tag"=>$tag,"options"=>array("icon"=>$icon));
          
        }

        $thedata[] = $val;
      }
        if(empty($input)){
          return json_encode(array("map"=>$markers));
        } else {
          return json_encode(array("map"=>$markers,"leads"=>$thedata));
        }
    } else {
      $input = Input::get();
        if(empty($input)){
          $title = "Data Entry for the Week";
          $day = date('w');
          $day = $day-1;
          $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
          $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));
        } else {
          $datemin = $input['startdate'];
          $datemax = $input['enddate'];
          $title = "Data Entry for (".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).")";
        }

      $doorreporttime = DB::query("SELECT COUNT(id) as total, researcher_id, researcher_name,lat, lng,
        SUM(status!='WrongNumber') valid, SUM(status='WrongNumber') wrong, SUM(status='NQ' AND nqreason='renter') renters,
        SUM(status='NEW') avail, SUM(status='INACTIVE') unreleased, SUM(status='NI') ni,SUM(status='DNC') dnc, SUM(status='SOLD') sold, SUM(status='DNC') dnc, 
        SUM(status='APP' OR status='SOLD' OR status='DNS' OR status='CONF') booked, SUM(result='DNS' or result='SOLD') puton, SUM(result='DNS' AND status='APP') dns
        FROM leads WHERE original_leadtype ".$t." AND entry_date>= DATE('".$datemin."') AND entry_date<= DATE('".$datemax."') GROUP BY researcher_name");
        $numero = Stats::getNumerology();

      return View::make('reports.entry')
      ->with('type',$type)
      ->with('numero',$numero)
      ->with('doorreports',$doorreporttime)
      ->with('startdate',$datemin)
      ->with('enddate',$datemax)
      ->with('title',$title);
    }



  }

  public function action_sales(){
  	 if(Auth::user()->user_type=="agent" && Auth::user()->assign_leads!=1){return Redirect::to('dashboard');}
        if(Auth::user()->user_type=="doorrep"){return Redirect::to('dashboard');}
    $input = Input::get();
      if(empty($input)){
        $title = "Sales This Week";
        $city = '';
        $day = date('w');
        $day = $day-1;
        $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
        $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));
      } else if(isset($input['incomplete'])||isset($input['financedeals'])){
        if(isset($input['financedeals'])){$title = "All Incomplete Finance Deals";} else {$title = "All Incomplete Sales";}
        $day = date('w');
        $day = $day-1;
         if((isset($input['city']))&&($input['city']!='all')){
        $city = "AND city = '".$input['city']."'";}
        else {
           $city = '';
        }
        $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
        $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));

      } else {
        $datemin = $input['startdate'];
        if((isset($input['city']))&&($input['city']!='all')){
        $city = "AND city = '".$input['city']."'";}
        else {
           $city = '';
        }
        $datemax = $input['enddate'];
        $title = "Sales for (".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).")";
      }

     $year = date("Y",strtotime($datemin));
     $week = date("W", strtotime($datemin));
     $prevWeek = $week-1;


      $dates = Stats::getDatesOfWeek($prevWeek,$year);
      if(!empty($dates)){
        $prevStart = $dates[0];
        $prevFinish = $dates[1];
      }
      
  
    $arr=array();
    $defs = Inventory::where('status','=','Checked Out')->order_by('checked_by','ASC')->get(array('sku','id','item_name','checked_by'));
    foreach($defs as $val){
      $arr[$val->id] = $val->sku." | ".ucfirst($val->item_name)." | ".$val->checked_by;
    }
    if(!empty($input['displayStats'])){
      $displaystats = Input::get('displayStats');
    } else {
      $displaystats="no";
    }
    
    $stats = Stats::saleStats($datemin,$datemax,$city);
    $prevStats = Stats::saleStats($prevStart,$prevFinish,$city);

    
     /* foreach($salebytype as $val){
        if($val->typeofsale=="majestic"){
          $type = "Majestic";
        } else if($val->typeofsale=="defender"){
          $type = "Defender";
        } 
        else if($val->typeofsale=="system"){
          $type = "System";
        } 
          else if($val->typeofsale=="supersystem"){
          $type = "Super";
        }
          else if($val->typeofsale=="megasystem"){
          $type="Mega";
        } else {
          $type="None Chosen";
        }
        $salebytypechart[] = array(strtoupper($type),intval($val->tot));
      }*/
    
      /*if(!empty($appdetails)){
        $appdetails = $appdetails[0];
      } 

      foreach($salesbydealer as $val){
        if($val->sales!=0){
          $u = User::find($val->rep_id);
          if(!empty($u)){
            $salesbydeal[]=array(strtoupper($val->rep_name),intval($val->sales));
          }
        }
      }*/

      /*if(!empty($appdetails)){
        foreach($appdetails as $key=>$val){
          if(($key!="tot")&&($key!="total")&&($key!="puton")&&($key!="close")){
          $demochart['chart'][] = array(strtoupper($key), intval($val));}
          $demochart['stats'][$key]=$val;
        }
      } else {
        $demochart = array("stats"=>0,"chart"=>0);
      }*/

      if(isset($input['incomplete'])){
        $salesreport = DB::query("SELECT * FROM sales WHERE status!='COMPLETE' AND status!='PAID' AND (typeofsale='' 
          OR payment='' OR price='0.00' 
          OR payout='0.00' OR (payment!='VISA' AND payment!='CHQ' AND payment!='CASH' AND payment!='MasterCard' AND payment!='AMEX' AND deferal='NA') OR pay_type='NA'
          OR  (defone=0 AND deftwo=0 AND defthree=0 AND deffour=0 AND deffive=0 AND maj=0 AND att=0)) AND status!='CANCELLED' AND status!='TBS' AND status!='TURNDOWN' ORDER BY date");
      } else if(isset($input['financedeals'])) {
          $salesreport = DB::query("SELECT * FROM sales WHERE 
          ((payment!='VISA' AND payment!='CHQ' AND payment!='CASH' AND payment!='MasterCard' AND payment!='AMEX') AND  (funded=0 OR conf=0)) AND status!='CANCELLED' AND status!='TBS' AND status!='TURNDOWN' AND status!='PAID' AND status!='COMPLETE' ORDER BY date");
        
      } else {
        $salesreport = DB::query("SELECT * FROM sales WHERE date >= DATE('".$datemin."') AND date <= DATE('".$datemax."') ORDER BY date");
      }
      $cities = City::where('status','=','active')->get();
      $reps = User::activeUsers('salesrep');

      return View::make('reports.sales(new)')
      ->with('inventory',$arr)
      ->with('mainstats',$stats)
      ->with('prevStats',$prevStats)
      ->with('salesreport',$salesreport)
      ->with('displaystats',$displaystats)
      ->with('startdate',$datemin)
      ->with('enddate',$datemax)
      ->with('cities',$cities)
      ->with('title',$title)
      ->with('reps',$reps);
  }

  public function action_invoice(){
     $input = Input::get();
      if(empty($input)){
        $title = "Invoices This Week";
        $city = '';
        $day = date('w');
        $day = $day-1;
        $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
        $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));
      } else {
        $datemin = $input['startdate'];
        if($input['city']!='all'){
        $city = "AND city = '".$input['city']."'";}
        else {
           $city = '';
        }
        $datemax = $input['enddate'];
        $title = "Invoices for (".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).")";
      }

    $cities = City::where('status','=','active')->get();
 

    return View::make('reports.invoice')
    ->with('startdate',$datemin)
    ->with('enddate',$datemax)
    ->with('cities',$cities)
    ->with('title',$title);

  }

  public function action_leadmap(){
    $datemin = Input::get('start');
    $datemax = Input::get('end');

    $coordinates = DB::query("SELECT id, address, lat, lng, cust_name, cust_num, 
      researcher_name, researcher_id, assign_count, notes, status, app_date, result, entry_date 
      FROM leads WHERE MONTH(created_at) = MONTH('".date('Y-m-d')."') AND YEAR(created_at) = YEAR(NOW())");

    $markers = array();
    $i=1;
    $iconcount = 1;
   
      $id = 0;
      foreach($coordinates as $val){
        if($val->lat!=0.0){
          if($val->result=="DISP"){
            $tag = $val->result;
            $label = "info special";
            $icon = URL::to_asset('img/demo-disp.png');
          } 

          if($val->status=="APP"){
            $tag = $val->result;
            $label = "success special";
            $icon = $icon = URL::to_asset('img/demo-icon-car.png');
          } 

        if($val->result=="SOLD"){
                    $tag = $val->result;
                    $label = "success special";
                    $icon = URL::to_asset('img/door-regy-sold.png');
            }

            if($val->result=="DNS"){
                    $tag = $val->result;
                    $label = "important special";
                    $icon = URL::to_asset('img/demo-dns.png');
            }

            if($val->result=="INC"){
                    $tag = $val->result;
                    $label = "warning";
                    $icon = URL::to_asset('img/door-inc.png');
            }

            if($val->result=="CXL"){
                    $tag = $val->result;
                    $label = "important";
                    $icon = URL::to_asset('img/door-cxl.png');
            }
            if($val->status=="NH"){$icon=URL::to_asset('img/door-regy2.png');$label = "info";$tag = "NH";} 
            if($val->status=="NI") {$icon=URL::to_asset('img/door-regy3.png'); $label = "important";$tag = "NI";} 
            if($val->status=="NEW"){$icon=URL::to_asset('img/door-regy1.png'); $label = "inverse";$tag = "NEW";}
        if(($val->status=="NQ")||($val->result=="NQ")){$icon=URL::to_asset('img/door-regy3.png'); $label = "important special";$tag = "NQ";}
       $markers[] = array("latLng"=>array($val->lat,$val->lng),
            "data"=>"Customer : ".$val->cust_name."<br>Entry Date : ".$val->entry_date." <br>Surveyor : ".$val->researcher_name."<br>APP DATE: ".$val->app_date."<br>Status : <span class='label label-".$label."'>".$val->status."</span><br>Result: ".$val->result,
            "tag"=>$tag,
            "options"=>array("icon"=>$icon));
            }
       $thedata[] = $val;

        }

        return json_encode(array("map"=>$markers,"leads"=>$thedata));

    }

    public function action_dataentry(){
    	 if(Auth::user()->user_type=="agent" && Auth::user()->assign_leads!=1){return Redirect::to('dashboard');}
        if(Auth::user()->user_type=="doorrep"){return Redirect::to('dashboard');}
        $input = Input::get();
        if(empty($input)){
          $title = "Manilla Upload report Last Two Weeks";
          $datemin = date('Y-m-d',strtotime('-14 Day'));
          $datemax = date('Y-m-d');

        } else {
          $datemin = $input['startdate'];
          $datemax = $input['enddate'];
          $title = "Manilla Upload Report (".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).")";
          }
          
        if(isset($input['cityname'])&&($input['cityname']!="all")){
          $dataentrystats = DB::query("SELECT COUNT(id) as total, entry_date, researcher_name, city,
        SUM(status!='INVALID') valid, SUM(status='SOLD' OR status='COMPLETE' OR result='SOLD') sold, SUM(status='APP' OR status='RB-TF' OR status='RB-OF' OR status='SOLD') app, 
        SUM(status='NI') ni, SUM(status='NQ') nq, SUM(status!='INACTIVE' AND status!='INVALID') released, SUM(status='INACTIVE') unreleased, 
        SUM(status='DELETED' AND assign_count=99999) duplicates,SUM(status='DELETED' AND assign_count!=99999) called_to_many,
        SUM(CASE WHEN assign_count > 0 AND assign_count!=99999 THEN 1 ELSE 0 END) called, SUM(status='ASSIGNED') assigned, SUM(status='DNC') dnc, SUM(status='NEW') new, 
        SUM(status='WrongNumber') wrong, SUM(status='INVALID') renters
        FROM leads WHERE original_leadtype = 'paper' AND researcher_name = 'Upload/Manilla' AND DATE(entry_date)>= DATE('".$datemin."') AND DATE(entry_date)<= DATE('".$datemax."') AND city='".$input['cityname']."' GROUP BY entry_date");
        
        $wrong = DB::query("SELECT COUNT(id) as tot,city,entry_date, status, SUM(status!='INVALID' AND status!='WrongNumber') valid, 
          SUM(status='INVALID') renters, SUM(status='WrongNumber') wrong, SUM(LENGTH(cust_num)=11) short_num1,
        SUM(LENGTH(cust_num)=10) short_num2,SUM(LENGTH(cust_num)=9) short_num3, SUM(status='DELETED' AND assign_count=99999) duplicates
        FROM leads WHERE original_leadtype = 'paper' AND researcher_name = 'Upload/Manilla' AND entry_date>= '".$datemin."' AND entry_date<= '".$datemax."' AND city='".$input['cityname']."' GROUP BY entry_date  ");
       
        
        } else {
          $dataentrystats = DB::query("SELECT COUNT(id) as total, entry_date, researcher_name, city,
        SUM(status!='INVALID') valid, SUM(status='SOLD' OR status='COMPLETE' OR result='SOLD') sold, SUM(status='APP' OR status='RB-TF' OR status='RB-OF' OR status='SOLD') app, SUM(status='NI') ni, SUM(status='NQ') nq, 
        SUM(status!='INACTIVE' AND status!='INVALID') released, SUM(status='INACTIVE') unreleased, 
        SUM(status='DELETED' AND assign_count=99999) duplicates,SUM(status='DELETED' AND assign_count!=99999) called_to_many,
        SUM(CASE WHEN assign_count > 0 AND assign_count!=99999 THEN 1 ELSE 0 END) called, SUM(status='ASSIGNED') assigned, SUM(status='DNC') dnc, SUM(status='NEW') new, SUM(status='WrongNumber') wrong, SUM(status='INVALID') renters
        FROM leads WHERE original_leadtype = 'paper' AND researcher_name = 'Upload/Manilla' AND entry_date>= DATE('".$datemin."') AND entry_date<= DATE('".$datemax."') GROUP BY entry_date, city");

        $wrong = DB::query("SELECT COUNT(id) as tot,city,entry_date, status, SUM(status!='INVALID' AND status!='WrongNumber') valid, SUM(status='INVALID') renters, SUM(status='WrongNumber') wrong, SUM(LENGTH(cust_num)=11) short_num1,
        SUM(LENGTH(cust_num)=10) short_num2,SUM(LENGTH(cust_num)=9) short_num3, SUM(status='DELETED' AND assign_count=99999) duplicates
        FROM leads WHERE original_leadtype = 'paper' AND researcher_name = 'Upload/Manilla' AND entry_date>= '".$datemin."' AND entry_date<= '".$datemax."' GROUP BY entry_date  ");
        }
      
      if(!empty($input['cityname'])){
        $city = $input['cityname'];
      } else {
        $city="all";
      }

      $bookers = User::where('level','!=',99)->where('user_type','=','agent')->order_by('firstname','ASC')->get();
      $cities = City::where('status','=','active')->get();

      return View::make('reports.dataentry')
      ->with('title',$title)
      ->with('city',$city)
      ->with('wrong',$wrong)
      ->with('cities',$cities)
      ->with('bookers',$bookers)
      ->with('dataentry',$dataentrystats)
      ->with('startdate',$datemin)
      ->with('enddate',$datemax);
    }





    //*****EXCEL GENERATED DATA******//
      public function action_generateExcelMarketing(){

      $input = Input::get();
       if(empty($input)){
        $day = date('w');
        $day = $day-1;
        $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
        $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));
      } else {
        $datemin = $input['startdate'];
        $datemax = $input['enddate'];
      }

      $scratch = Scratch::where('date_sent','>=',date('Y-m-d',strtotime($datemin)))->
      where('date_sent','<=',date('Y-m-d',strtotime($datemax)))->sum('qty');



      $title = "Marketing Report (".date('M-d Y',strtotime($datemin))." - ".date('M-d Y',strtotime($datemax)).")";
      $titlefile = date('M-d',strtotime($datemin))."-".date('M-d',strtotime($datemax));
     
      $paperanddoor = DB::query("SELECT COUNT(*) as total, leadtype, original_leadtype, 
        SUM(status!='INVALID' AND status!='WrongNumber' AND entry_date>=DATE('".$datemin."') AND entry_date <=DATE('".$datemax."')) tot,
        SUM(status!='WrongNumber' AND status!='INVALID' AND birth_date>=DATE('".$datemin."') AND birth_date <=DATE('".$datemax."') AND original_leadtype='secondtier') totsecondtier,
        SUM(result='DNS' AND app_date>=DATE('".$datemin."') AND app_date <=DATE('".$datemax."')) dns, 
        SUM(result='SOLD' AND app_date>=DATE('".$datemin."') AND app_date <=DATE('".$datemax."') ) sold,
        SUM(result='NQ' AND app_date>=DATE('".$datemin."') AND app_date <=DATE('".$datemax."')) nq FROM leads GROUP BY original_leadtype");
       
      $stats = DB::query("SELECT COUNT(*) AS total, caller_id, leadtype, created_at,
        SUM(result != '' AND result !='CONF' AND result != 'NA') rangetot,
        SUM(result='CONF') rangeconfirms, SUM(result='NA') rangena,
        SUM(result = 'APP') rangeapp,SUM(result = 'DNC') rangednc,
        SUM(result = 'NH') rangenh,SUM(result = 'NI') rangeni,
        SUM(result = 'NQ') rangenq,SUM(result = 'WrongNumber') rangewrong,
        SUM(result = 'Recall') rangerecall FROM calls WHERE DATE(created_at) >=DATE('".$datemin."') AND DATE(created_at) <=DATE('".$datemax."') GROUP BY caller_id, leadtype");

      $statstotals = DB::query("SELECT COUNT(id) as total,
        SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,
        SUM(result != '' ) totals,
        SUM(result='CONF') confirms, SUM(result='NA') na,
        SUM(result = 'APP') app,SUM(result = 'DNC') dnc,
        SUM(result = 'NH') nh,SUM(result = 'NI' OR result = 'NQ') ni,
        SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
        SUM(result = 'WrongNumber') wrong FROM calls WHERE DATE(created_at) >=DATE('".$datemin."') AND DATE(created_at) <=DATE('".$datemax."')");

      $bookerstats = DB::query("SELECT caller_id,
        SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,
        SUM(result != '' ) totals,
        SUM(result='CONF') confirms, SUM(result='NA') na,
        SUM(result = 'APP') app,SUM(result = 'DNC') dnc,SUM(result = 'NH') nh, 
        SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
        SUM(result = 'WrongNumber') wrong FROM calls 
        WHERE DATE(created_at) >= DATE('".$datemin."') AND DATE(created_at) <= DATE('".$datemax."') GROUP BY caller_id ORDER BY app DESC");

      $appdetails = DB::query("SELECT *, IF(puton + total, 100*puton/total, NULL) AS hold 
        FROM (SELECT COUNT(*) as total, booked_by, booker_id,
        SUM(status='DNS')dns, SUM(status='INC') inc, SUM(status='SOLD') sales,SUM(status='CXL') cxl,
        SUM(status='DNS' OR status='INC' OR status='SOLD') puton
        FROM appointments WHERE app_date >= DATE('".$datemin."') AND app_date <= DATE('".$datemax."') GROUP BY booker_id) as SUBQUERY ORDER BY booked_by");

      $appdetailsarray=array();
        foreach($appdetails as $val){
          $u = User::find($val->booker_id);
          if(!empty($u)){
            if($u->user_type=="agent"){
              $appdetailsarray[$val->booker_id]=array("salestats"=>$val,"payrate"=>$u->payrate);
            }
          }
        }

      foreach($bookerstats as $val){
        if(array_key_exists($val->caller_id,$appdetailsarray)){
          $appdetailsarray[$val->caller_id]["callstats"] = $val;
        }
      }

      $marketstats = $this->marketingpodium($datemin, $datemax);
      $apptimes = User::appTimes($datemin,$datemax);

        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';
        $objPHPexcel = New PHPExcel();
        $objWorksheet = $objPHPexcel->getActiveSheet();

       $objWorksheet->setTitle($titlefile);
        $total=0;$sales=0;$dns=0;$inc=0;$puton=0;$hours=0;$cxl=0;$totalhours=0;
        $i= 1;
        $objWorksheet->getCell('A'.$i)->setValue($title);
        $i++;
        $i = $this->newEmptyRow($objWorksheet,$i);

        $objWorksheet->getCell('A'.$i)->setValue('NAME');
        $objWorksheet->getCell('B'.$i)->setValue('Booked');
        $objWorksheet->getCell('C'.$i)->setValue('BPH');
        $objWorksheet->getCell('D'.$i)->setValue('SOLD');
        $objWorksheet->getCell('E'.$i)->setValue('DNS');
        $objWorksheet->getCell('F'.$i)->setValue('INC');
        $objWorksheet->getCell('G'.$i)->setValue('TOTAL');
        $objWorksheet->getCell('H'.$i)->setValue('HOLD %');
        $objWorksheet->getCell('I'.$i)->setValue('BOOK %');
        $objWorksheet->getCell('J'.$i)->setValue('HRS');
        $objWorksheet->getCell('K'.$i)->setValue('Payrate');
        $objWorksheet->getCell('L'.$i)->setValue('$ Earned');
        $objWorksheet->mergeCells('A1:J1');
        $objWorksheet->getStyle('I')->getNumberFormat()->setFormatCode('0.00%');
        $objWorksheet->getStyle('C')->getNumberFormat()->setFormatCode('0.00');
        $objWorksheet->getStyle('A1:J1')->getFont()->setSize(14);
        $objWorksheet->getStyle('A1:J1')->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getStyle('A3:J3')->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getColumnDimension()->setAutoSize(true);
      
        foreach($appdetailsarray as $val){
          $i++;
          $hold_per=0; $book_per=0; $hours=0;
          $total=$total+$val['salestats']->total;
          $sales=$sales+$val['salestats']->sales;
          $dns=$dns+$val['salestats']->dns;
          $inc=$inc+$val['salestats']->inc;
          $cxl=$cxl+$val['salestats']->cxl;

          $puton=$puton+$val['salestats']->puton;
          $u = User::find($val['salestats']->booker_id);
          if($u){

            $hours = $u->hours($datemin,$datemax);
            
            if(($val['salestats']->puton!=0)&&($val['salestats']->total!=0)){
              $hold_per = number_format(($val['salestats']->puton/$val['salestats']->total)*100,2,'.','');
            } 

            //$hours=$hours+$u->hours($datemin,$datemax);
            if($hours!=0){
              if($val['salestats']->puton!=0){
                $book_per = number_format(($val['salestats']->puton/$hours)*100,2,'.','');
              } 
                $bph = number_format(($val['salestats']->total/$hours),2,'.','');
              } else {
                $bph = number_format(($val['salestats']->total/30),2,'.','');
            }
            if(!empty($pay[$val['payrate']])){
              $pay[$val['payrate']] = $pay[$val['payrate']] + $hours;
            } else {
              $pay[$val['payrate']] = $hours;
            }

            $objWorksheet->getCell('A'.$i)->setValue(($val['salestats']->booked_by));
            $objWorksheet->getCell('B'.$i)->setValue($val['salestats']->total);
            $objWorksheet->getCell('C'.$i)->setValue("=(B".$i."/J".$i.")");
            $objWorksheet->getCell('D'.$i)->setValue($val['salestats']->sales);
            $objWorksheet->getCell('E'.$i)->setValue($val['salestats']->dns);
            $objWorksheet->getCell('F'.$i)->setValue($val['salestats']->inc);
            $objWorksheet->getCell('G'.$i)->setValue("=D".$i."+E".$i."+F".$i);
            $objWorksheet->getCell('H'.$i)->setValue("=(D".$i."+E".$i."+F".$i.")/B".$i);
            $objWorksheet->getStyle('H'.$i)->getNumberFormat()->setFormatCode('0.00%');
            $objWorksheet->getCell('I'.$i)->setValue("=(G".$i."/J".$i.")");
            $objWorksheet->getCell('J'.$i)->setValue($hours);
            $objWorksheet->getStyle('J'.$i)->applyFromArray(
              array(
               'fill' => array(
                  'type' => PHPExcel_Style_Fill::FILL_SOLID,
                  'color' => array('rgb' => 'FFFF99')
                )
              )
            );
            $objWorksheet->getCell('K'.$i)->setValue($val['payrate']);
            $objWorksheet->getCell('L'.$i)->setValue("=(J".$i."*K".$i.")");
            $objWorksheet->getStyle('K'.$i)->getNumberFormat()->setFormatCode('$0.00');
            $objWorksheet->getStyle('L'.$i)->getNumberFormat()->setFormatCode('$0.00');
          }
        }

        

        $i++;
        $i = $this->newEmptyRow($objWorksheet,$i);

        $objWorksheet->getStyle('A'.$i.':J'.$i)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getCell('A'.$i)->setValue('TOTAL');
        $objWorksheet->getCell('B'.$i)->setValue("=SUM(B4:B".($i-2).")");
        $objWorksheet->getCell('C'.$i)->setValue("=B".$i."/J".$i.")");
        $objWorksheet->getCell('D'.$i)->setValue("=SUM(D4:D".($i-2).")");
        $objWorksheet->getCell('E'.$i)->setValue("=SUM(E4:E".($i-2).")");
        $objWorksheet->getCell('F'.$i)->setValue("=SUM(F4:F".($i-2).")");
        $objWorksheet->getCell('G'.$i)->setValue("=SUM(G4:G".($i-2).")");
        $objWorksheet->getCell('H'.$i)->setValue("=(D".$i."+E".$i."+F".$i.")/B".$i);
        $objWorksheet->getStyle('H'.($i))->getNumberFormat()->setFormatCode('0.00%');
        $objWorksheet->getCell('I'.$i)->setValue('');
        $objWorksheet->getCell('J'.$i)->setValue("=SUM(J4:J".($i-2).")");
        $objWorksheet->getCell('L'.$i)->setValue("=SUM(L4:L".($i-2).")");
        $objWorksheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode('0.00');

        $i++;
        $i = $this->newEmptyRow($objWorksheet,$i);
        $i = $this->newEmptyRow($objWorksheet,$i);
       
        $totalsurveys=0;$totalmas=0;$totalsts=0;$totalreggies=0;$totalscratch=0;$totalsold=0;$totaldems=0;$setratio=0;$totalhome=0;
        if(!empty($paperanddoor)){
            foreach($paperanddoor as $val){
              if($val->original_leadtype=="paper" ){
                $totalsurveys += $val->tot;
                $totalmas += $val->tot;
              } else if($val->original_leadtype=="secondtier"){
                $totalsts += $val->totsecondtier;
              } else if($val->original_leadtype=="door"){
                $totalsurveys = $totalsurveys+$val->tot;
                $totalreggies=$val->tot;
              } else if(($val->original_leadtype=="other")||($val->original_leadtype=="finalnotice")){
                $totalscratch = $totalscratch+$val->tot;

              } else if(($val->original_leadtype=="homeshow")||($val->original_leadtype=="ballot")){
                $totalhome = $totalhome+$val->tot;
              } 

                $totalsold = $totalsold+$val->sold;
                $totaldems = $totaldems+($val->sold+$val->dns);
            }
        }

        $c = $i;
        $objWorksheet->getCell('A'.$c)->setValue('TOTAL PHONE ROOM BOOKING HOURS');
        $objWorksheet->getCell('B'.$c)->setValue("=J".($c-3));
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('0.00');
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('TOTAL MARKETING HOURS');
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('0.00');
        
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('TOTAL DEMOS (SOLD+DNS+INC)');
        $objWorksheet->getCell('B'.$c)->setValue("=D".($c-5)."+E".($c-5)."+F".($c-5));
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('COMPLETE DEMOS (SOLD+DNS)');
        $objWorksheet->getCell('B'.$c)->setValue("=D".($c-6)."+E".($c-6));
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('TOTAL APPOINTMENTS');
        $objWorksheet->getCell('B'.$c)->setValue("=B".($c-7));
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('HOLD RATIO');
        $objWorksheet->getCell('B'.$c)->setValue("=(B".($c-2)."/B".($c-1).")");
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('0.00%');
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('SET RATIO (APPTS/HOURS)');
        $objWorksheet->getCell('B'.$c)->setValue("=B".($c-2)."/B".($c-5));
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('0.00');

        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('MALL / HOME SHOWS (BALLOT)');
        $objWorksheet->getCell('B'.$c)->setValue($totalhome);
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('FLYERS (SCRATCH)');
        $objWorksheet->getCell('B'.$c)->setValue($scratch);
        $c++;
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('TOTAL MA');
        $objWorksheet->getCell('B'.$c)->setValue($totalmas);
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('TOTAL MA HRS');
        $objWorksheet->getCell('B'.$c)->setValue("=B".($c-1)."/7");
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('0.00');
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('TOTAL DOOR REGGIES');
        $objWorksheet->getCell('B'.$c)->setValue($totalreggies);
       
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('TOTAL DR HOURS');
        $objWorksheet->getCell('B'.($c))->setValue("=B".($c-1)."/7");
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('0.00');
        $objWorksheet->getCell('B'.($c-12))->setValue("=B".($c)."+B".($c-2)."+B".($c-13));
        $c++;

        $c++;
        $c = $this->newEmptyRow($objWorksheet,$c);
        
       
        $objWorksheet->getCell('A'.$c)->setValue('Total Phone Room $');
        $objWorksheet->getStyle('A'.$c)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getCell('B'.$c)->setValue("=L".($c-19));
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('$0.00');
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('Total Door Reggie $');
        $objWorksheet->getStyle('A'.$c)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getCell('B'.$c)->setValue("=B".($c-5)."*3");
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('$0.00');
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('Total Manilla $');
        $objWorksheet->getStyle('A'.$c)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getCell('B'.$c)->setValue("=(B".($c-8)."/7)*10.50");
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('$0.00');
        $c++;
        $objWorksheet->getCell('A'.$c)->setValue('Total Scratch $');
        $objWorksheet->getStyle('A'.$c)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getCell('B'.$c)->setValue("=B".($c-11)."*0.20");
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('$0.00');
        
        $c++;
        $c=$this->newEmptyRow($objWorksheet,$c);
        $objWorksheet->getCell('A'.$c)->setValue('TOTAL MARKETING $');
        $objWorksheet->getCell('B'.$c)->setValue("=SUM(B".($c-5).":B".($c-2).")");
        
        $objWorksheet->getStyle('A'.$c.':J'.$c)->getFont()->setSize(11);
        $objWorksheet->getStyle('A'.$c)->applyFromArray(array("font" => array( "bold" => true)));
        $c++;
        $c=$this->newEmptyRow($objWorksheet,$c);
        $objWorksheet->getCell('A'.$c)->setValue('COST PER DEMO');
        $objWorksheet->getCell('B'.$c)->setValue("=B".($c-2)."/B".($c-20));
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('$0.00');
        
        $objWorksheet->getStyle('A'.$c.':J'.$c)->getFont()->setSize(11);
        $objWorksheet->getStyle('A'.$c)->applyFromArray(array("font" => array( "bold" => true)));
        $c++;
        $c=$this->newEmptyRow($objWorksheet,$c);
        $objWorksheet->getCell('A'.$c)->setValue('COST PER SALE');
        $objWorksheet->getCell('B'.$c)->setValue("=B".($c-4)."/D".($c-28));
        $objWorksheet->getStyle('B'.($c))->getNumberFormat()->setFormatCode('$0.00');
        $objWorksheet->getStyle('A'.$c.':J'.$c)->getFont()->setSize(11);
        $objWorksheet->getStyle('A'.$c)->applyFromArray(array("font" => array( "bold" => true)));
        


$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');
$name = "MarketingReport-(".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).").xls";
// It will be called file.xls
header('Content-Disposition: attachment; filename="'.$name.'"');
$objWriter->save('php://output');

}

      public function action_generateExcelSale(){

      $input = Input::get();
       if(empty($input)){
        
        $day = date('w');
        $day = $day-1;
        $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
        $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));
      } else {
        $datemin = $input['startdate'];
        $datemax = $input['enddate'];
       
      }


        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';
        $objPHPexcel = New PHPExcel();
        $objWorksheet = $objPHPexcel->getActiveSheet();

        $sales = Sale::where('date','>=',$datemin)->where('date','<=',$datemax)->get();

        $i= 0; $stat="";
        $settings = Setting::find(1);
        
        foreach($sales as $val){

         if($val->payment=="Lendcare"){
            $val->payment = "LC";
        }
        
        if($val->payment=="MasterCard"){
          $val->payment = "MC";
        }
        
        if($val->pay_type=="APP A"){
          $stat = "A";
        } else if($val->pay_type=="APP B"){
          $stat = "B";
        } else if($val->pay_type=="APP C"){
          $stat = "C";
        } else if($val->pay_type=="APP D"){
          $stat = "D";
        } else if($val->pay_type=="APP E"){
          $stat = "E";
        } else if($val->pay_type=="CREDITCARD"){
          $stat = "PD";
        } else if($val->pay_type=="CHEQUE"){
          $stat = "PD";
        } else if($val->pay_type=="CASH"){
          $stat = "PD";
        } 

      if($val->status=="TURNDOWN"){
        $stat = "TD";
      } else if($val->status=="CANCELLED" || $val->status=="TBS"){
        $stat = "CXL";
      }

    $addy = explode(",",$val->lead->address);
    $name = explode(" ",$val->cust_name);
    $num =  str_replace("-","",$val->lead->cust_num);
    $date = PHPExcel_Style_NumberFormat::toFormattedString($val->date, "M/D/YYYY");
    $i++;

    if(($val->status=="CANCELLED")||($val->status=="TURNDOWN")||($val->status=="TBS")){
    $fill = array(
        'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'BEBEBE'),
                )
      );
    $objWorksheet->getStyle('A'.$i.':AZ'.$i)->applyFromArray($fill);
    $objWorksheet->getStyle('A'.$i.':AZ'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    $objWorksheet->getCell('A'.$i)->setValue($settings->distcode);
    $objWorksheet->getCell('B'.$i)->setValue('');
    $objWorksheet->getCell('C'.$i)->setValue(str_replace("-","",$val->date));
    
    if(isset($name[0])){
        $objWorksheet->getCell('E'.$i)->setValue(strtoupper($name[0]));
    } else {
        $objWorksheet->getCell('E'.$i)->setValue(strtoupper($val->cust_name));
    }

    if(isset($name[1])){
        if($name[1]!="&"){
            $objWorksheet->getCell('D'.$i)->setValue(strtoupper($name[1]));
        } else {
            $objWorksheet->getCell('D'.$i)->setValue(strtoupper($name[2]));
        }
        
    } else {
        $objWorksheet->getCell('D'.$i)->setValue('');
    }

      $items = $val->items;
      $d1="---";$d2="---";$d3="---";$d4="---";$d5="---";$maj="---";$m2="---";$m3="---";$att="---";
      if(!empty($items)){
        foreach($items as $inv){
          if($inv->item_name=="defender"){
            if($d1=="---"){
              $d1 = $inv->sku;
            } else if($d2=="---"){
              $d2 = $inv->sku;
            } else if($d3=="---"){
              $d3 = $inv->sku;
            } else if($d4=="---"){
              $d4 = $inv->sku;
            } else if($d5=="---"){
              $d5 = $inv->sku;
            }
          } else if($inv->item_name=="majestic"){
            if($maj=="---"){
              $maj = $inv->sku;
            } else if($m2=="---"){
              $m2 = $inv->sku;
            } else if($m3=="---"){
              $m3 = $inv->sku;
            }
          } else if($inv->item_name=="attachment"){
            if($att=="---"){
              $att = $inv->sku;
            }
          }
        }
      }

     
    if(empty($val->filter_one)){
      $val->filter_one = '---';
    }

    if(empty($val->filter_two)){
      $val->filter_two = '---';
    }

    $bookname = explode(" ",$val->lead->booker_name);
   
    if(empty($val->down_payment)){
      $val->down_payment = "-";
    }

    $objWorksheet->getColumnDimension()->setAutoSize(true);
    $objWorksheet->getCell('F'.$i)->setValue(strtoupper($addy[0]));
    $objWorksheet->getCell('G'.$i)->setValue(strtoupper($val->lead->city));
    $objWorksheet->getCell('H'.$i)->setValue($settings->province);
    $objWorksheet->getCell('I'.$i)->setValue($val->postal_code);
    $objWorksheet->getCell('J'.$i)->setValue($num);
    $objWorksheet->getCell('K'.$i)->setValue($val->emailaddress);
    $objWorksheet->getCell('M'.$i)->setValue('');
    $objWorksheet->getCell('N'.$i)->setValue(strtoupper($val->payment));
    $objWorksheet->getCell('O'.$i)->setValue($val->down_payment);
    $objWorksheet->getCell('P'.$i)->setValue($val->price);
    $objWorksheet->getStyle('O'.$i)->getNumberFormat()->setFormatCode('0.00');
    $objWorksheet->getStyle('P'.$i)->getNumberFormat()->setFormatCode('0.00');
    $objWorksheet->getStyle('O'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objWorksheet->getStyle('P'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objWorksheet->getCell('Q'.$i)->setValue($stat);
    $objWorksheet->getCell('R'.$i)->setValue('');
    $objWorksheet->getCell('S'.$i)->setValue('');
    $objWorksheet->getCell('T'.$i)->setValue('');
    
    $objWorksheet->getCell('U'.$i)->setValueExplicit($maj, PHPExcel_Cell_DataType::TYPE_STRING);
    $objWorksheet->getStyle('U'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    $objWorksheet->getStyle('U'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objWorksheet->getCell('V'.$i)->setValueExplicit($val->filter_one, PHPExcel_Cell_DataType::TYPE_STRING);
    $objWorksheet->getStyle('V'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    $objWorksheet->getStyle('V'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $objWorksheet->getCell('W'.$i)->setValueExplicit($d1, PHPExcel_Cell_DataType::TYPE_STRING);
    $objWorksheet->getStyle('W'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    $objWorksheet->getStyle('W'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $objWorksheet->getCell('X'.$i)->setValueExplicit($val->filter_two, PHPExcel_Cell_DataType::TYPE_STRING);
    $objWorksheet->getStyle('X'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    $objWorksheet->getStyle('X'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $objWorksheet->getCell('Y'.$i)->setValueExplicit($d2, PHPExcel_Cell_DataType::TYPE_STRING);
    $objWorksheet->getStyle('Y'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    $objWorksheet->getStyle('Y'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objWorksheet->getCell('Z'.$i)->setValueExplicit($att, PHPExcel_Cell_DataType::TYPE_STRING);
    $objWorksheet->getStyle('Z'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    $objWorksheet->getStyle('Z'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $objWorksheet->getCell('AB'.$i)->setValue(strtoupper($val->sold_by));
    $objWorksheet->getCell('AC'.$i)->setValue(strtoupper(User::find($val->user_id)->sinnum));
    $objWorksheet->getCell('AD'.$i)->setValue(strtoupper($bookname[0]."/".$val->lead->original_leadtype));
    $objWorksheet->getCell('AE'.$i)->setValue(strtoupper($val->lead_type));
    if($d3!='---' || $d4!='---' || $m2!='---'){
      $i++;
      if($m2!='---'){
        $objWorksheet->getCell('U'.$i)->setValueExplicit($m2, PHPExcel_Cell_DataType::TYPE_STRING);
        $objWorksheet->getStyle('U'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objWorksheet->getStyle('U'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      }
      if($d3!='---'){
        $objWorksheet->getCell('W'.$i)->setValueExplicit($d3, PHPExcel_Cell_DataType::TYPE_STRING);
        $objWorksheet->getStyle('W'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objWorksheet->getStyle('W'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      }
      if($d4!='---'){
        $objWorksheet->getCell('Y'.$i)->setValueExplicit($d4, PHPExcel_Cell_DataType::TYPE_STRING);
        $objWorksheet->getStyle('Y'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objWorksheet->getStyle('Y'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      }
  }
  if($m3!='---' || $d5!='---'){
    $i++;
    if($m3!='---'){
      $objWorksheet->getCell('U'.$i)->setValueExplicit($m3, PHPExcel_Cell_DataType::TYPE_STRING);
      $objWorksheet->getStyle('U'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
      $objWorksheet->getStyle('U'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    if($d5!='---'){
      $objWorksheet->getCell('W'.$i)->setValueExplicit($d5, PHPExcel_Cell_DataType::TYPE_STRING);
      $objWorksheet->getStyle('W'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
      $objWorksheet->getStyle('W'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    
  }
}





    
$objWorksheet->getColumnDimension('A')->setAutoSize(true);
$objWorksheet->getColumnDimension('B')->setAutoSize(true);
$objWorksheet->getColumnDimension('C')->setAutoSize(true);
$objWorksheet->getColumnDimension('D')->setAutoSize(true);
$objWorksheet->getColumnDimension('E')->setAutoSize(true);
$objWorksheet->getColumnDimension('F')->setAutoSize(true);
$objWorksheet->getColumnDimension('G')->setAutoSize(true);
$objWorksheet->getColumnDimension('H')->setAutoSize(true);
$objWorksheet->getColumnDimension('I')->setAutoSize(true);
$objWorksheet->getColumnDimension('J')->setAutoSize(true);
$objWorksheet->getColumnDimension('K')->setAutoSize(true);
$objWorksheet->getColumnDimension('L')->setAutoSize(true);
$objWorksheet->getColumnDimension('M')->setAutoSize(true);
$objWorksheet->getColumnDimension('N')->setAutoSize(true);
$objWorksheet->getColumnDimension('O')->setAutoSize(true);
$objWorksheet->getColumnDimension('P')->setAutoSize(true);
$objWorksheet->getColumnDimension('Q')->setAutoSize(true);
$objWorksheet->getColumnDimension('R')->setAutoSize(true);
$objWorksheet->getColumnDimension('S')->setAutoSize(true);
$objWorksheet->getColumnDimension('T')->setAutoSize(true);
$objWorksheet->getColumnDimension('U')->setAutoSize(true);
$objWorksheet->getColumnDimension('V')->setAutoSize(true);
$objWorksheet->getColumnDimension('W')->setAutoSize(true);
$objWorksheet->getColumnDimension('X')->setAutoSize(true);
$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
$objWorksheet->getColumnDimension('AA')->setAutoSize(true);
$objWorksheet->getColumnDimension('AB')->setAutoSize(true);
$objWorksheet->getColumnDimension('AC')->setAutoSize(true);
$objWorksheet->getColumnDimension('AD')->setAutoSize(true);
$objWorksheet->getColumnDimension('AE')->setAutoSize(true);
$objWorksheet->getColumnDimension('AF')->setAutoSize(true);
$objWorksheet->getColumnDimension('AG')->setAutoSize(true);
$objWorksheet->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
$name = "SalesReport-(".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).").xls";
header('Content-Disposition: attachment; filename="'.$name.'"');
$objWriter->save('php://output');


}




public function action_generateExcelDealer(){

      $input = Input::get();

      if(empty($input)){
        $title = "Dealer Report This Week";
        $city = '';
        $day = date('w');
        $day = $day-1;
        $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
        $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));

      } else {
        $datemin = $input['startdate'];
        if((isset($input['city']))&&($input['city']!='all')){
        $city = "AND city = '".$input['city']."'";}
        else {
           $city = '';
        }
        $datemax = $input['enddate'];
        $title = "Dealer Report for (".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).")";

      }
      //Set previous week dates
      $year = date("Y",strtotime($datemin));
      $week = date("W", strtotime($datemin));
      $prevWeek = $week-1;


      $dates = Stats::getDatesOfWeek($prevWeek,$year);
      if(!empty($dates)){
        $prevStart = $dates[0];
        $prevFinish = $dates[1];
      }


      require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';
      $objPHPexcel = New PHPExcel();
      $objWorksheet = $objPHPexcel->getActiveSheet();
      $i= 1;
        $objWorksheet->getStyle("A".$i.":S".$i)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getStyle("A".$i.":S".$i)->getFont()->setSize(13);
        $objWorksheet->mergeCells('A'.$i.':J'.$i);
        $objWorksheet->getStyle("A".$i)->getFont()->setSize(16);
        $objWorksheet->getCell('A'.$i)->setValue($title." - GROSS");

        $i++;

        $i = $this->newEmptyRow($objWorksheet,$i);
        $objWorksheet->getStyle('O')->getNumberFormat()->setFormatCode('0.00');
        $objWorksheet->getStyle('P')->getNumberFormat()->setFormatCode('0.00');
        $objWorksheet->getStyle("A".$i.":S".$i)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getCell('A'.$i)->setValue('DEALER NAME');
        $objWorksheet->getCell('B'.$i)->setValue('SALES');
         //$objWorksheet->getCell('B'.$i)->setValue($prevStart."-".$prevFinish);
        $objWorksheet->getCell('C'.$i)->setValue('Units');
        $objWorksheet->getCell('D'.$i)->setValue('Nova');
        $objWorksheet->getCell('E'.$i)->setValue('Mega');
        $objWorksheet->getCell('F'.$i)->setValue('Super');
        $objWorksheet->getCell('G'.$i)->setValue('System');
        $objWorksheet->getCell('H'.$i)->setValue('Majestic');
        $objWorksheet->getCell('I'.$i)->setValue('Defender');
        $objWorksheet->getCell('J'.$i)->setValue('DNS');
        $objWorksheet->getCell('K'.$i)->setValue('CXL');
        $objWorksheet->getCell('L'.$i)->setValue('INC');
        $objWorksheet->getCell('M'.$i)->setValue('RB-TF');
        $objWorksheet->getCell('N'.$i)->setValue('RB-OF');
        $objWorksheet->getCell('O'.$i)->setValue('Close %');
        $objWorksheet->getCell('P'.$i)->setValue('COM');
        $objWorksheet->getCell('Q'.$i)->setValue('Prv Wk S');
        $objWorksheet->getCell('R'.$i)->setValue('Prv Wk U');

      $start=$i;
      $stats = Stats::saleStats($datemin,$datemax,$city);
      $prevStats = Stats::saleStats($prevStart,$prevFinish,$city);
      if(!empty($stats)){
        foreach($stats as $val){
          if(isset($val["name"])){
            if($val["name"]!="totals"){
              $u=User::find($val["rep_id"]);
              if($u){
                $i++;
                $objWorksheet->getCell('A'.$i)->setValue($val['name']);
                $objWorksheet->getCell('B'.$i)->setValue($val['grosssales']);
                $objWorksheet->getCell('C'.$i)->setValue($val['totgrossunits']);
                $objWorksheet->getCell('D'.$i)->setValue($val['grosssale']['novasystem']);
                $objWorksheet->getCell('E'.$i)->setValue($val['grosssale']['megasystem']);
                $objWorksheet->getCell('F'.$i)->setValue($val['grosssale']['supersystem']);
                $objWorksheet->getCell('G'.$i)->setValue($val['grosssale']['system']);
                $objWorksheet->getCell('H'.$i)->setValue($val['grosssale']['majestic']);
                $objWorksheet->getCell('I'.$i)->setValue($val['grosssale']['defender']);
                $objWorksheet->getCell('J'.$i)->setValue($val['appointment']['DNS']);      
                $objWorksheet->getCell('K'.$i)->setValue($val['appointment']['CXL']);
                $objWorksheet->getCell('L'.$i)->setValue($val['appointment']['INC']);
                $objWorksheet->getCell('M'.$i)->setValue($val['appointment']['RBTF']);
                $objWorksheet->getCell('N'.$i)->setValue($val['appointment']['RBOF']);
                $objWorksheet->getCell('O'.$i)->setValue("=(B".$i."/(J".$i."+B".$i."))*100");
                $objWorksheet->getCell('P'.$i)->setValue("=100-((B".$i."+J".$i.")/(B".$i."+J".$i."+K".$i."+L".$i."+M".$i."+N".$i."))*100");
                if(isset($prevStats[$u->id])){
                  $objWorksheet->getCell('Q'.$i)->setValue($prevStats[$u->id]["grosssales"]);
                  $objWorksheet->getCell('R'.$i)->setValue($prevStats[$u->id]["totgrossunits"]);
                }
                

                $end=$i;

              }
            }
          }
        }
      }
     

        $i++;
        $i = $this->newEmptyRow($objWorksheet,$i);
        $objWorksheet->getStyle("A".$i.":Q".$i)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getStyle('O'.$i)->getNumberFormat()->setFormatCode('0.00');
        $objWorksheet->getStyle('P'.$i)->getNumberFormat()->setFormatCode('0.00');
        $objWorksheet->getCell('A'.$i)->setValue('TOTALS');
        $objWorksheet->getCell('B'.$i)->setValue('=SUM(B'.$start.':B'.$end.')');
        $objWorksheet->getCell('C'.$i)->setValue('=SUM(C'.$start.':C'.$end.')');
        $objWorksheet->getCell('D'.$i)->setValue('=SUM(D'.$start.':D'.$end.')');
        $objWorksheet->getCell('E'.$i)->setValue('=SUM(E'.$start.':E'.$end.')');
        $objWorksheet->getCell('F'.$i)->setValue('=SUM(F'.$start.':F'.$end.')');
        $objWorksheet->getCell('G'.$i)->setValue('=SUM(G'.$start.':G'.$end.')');
        $objWorksheet->getCell('H'.$i)->setValue('=SUM(H'.$start.':H'.$end.')');
        $objWorksheet->getCell('I'.$i)->setValue('=SUM(I'.$start.':I'.$end.')');
        $objWorksheet->getCell('J'.$i)->setValue('=SUM(J'.$start.':J'.$end.')');
        $objWorksheet->getCell('K'.$i)->setValue('=SUM(K'.$start.':K'.$end.')');
        $objWorksheet->getCell('L'.$i)->setValue('=SUM(L'.$start.':L'.$end.')');
        $objWorksheet->getCell('M'.$i)->setValue('=SUM(M'.$start.':M'.$end.')');
        $objWorksheet->getCell('N'.$i)->setValue('=SUM(N'.$start.':N'.$end.')');
        $objWorksheet->getCell('O'.$i)->setValue("=(B".$i."/(J".$i."+B".$i."))*100");
        $objWorksheet->getCell('P'.$i)->setValue("=100-((B".$i."+J".$i.")/(B".$i."+J".$i."+K".$i."+L".$i."+M".$i."+N".$i."))*100");
        $objWorksheet->getCell('Q'.$i)->setValue('=SUM(Q'.$start.':Q'.$end.')');
        $objWorksheet->getCell('R'.$i)->setValue('=SUM(R'.$start.':R'.$end.')');


        // NET STATS
        $i++;
        $i = $this->newEmptyRow($objWorksheet,$i);
        $i = $this->newEmptyRow($objWorksheet,$i);
        $i = $this->newEmptyRow($objWorksheet,$i);
        $objWorksheet->getStyle("A".$i.":S".$i)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getStyle("A".$i.":S".$i)->getFont()->setSize(13);
        $objWorksheet->mergeCells('A'.$i.':J'.$i);
        $objWorksheet->getStyle("A".$i)->getFont()->setSize(16);
        $objWorksheet->getCell('A'.$i)->setValue($title." - NET");
        $i++;
        $i = $this->newEmptyRow($objWorksheet,$i);
        $objWorksheet->getStyle('O')->getNumberFormat()->setFormatCode('0.00');
        $objWorksheet->getStyle('P')->getNumberFormat()->setFormatCode('0.00');
        $objWorksheet->getStyle("A".$i.":S".$i)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getCell('A'.$i)->setValue('DEALER NAME');
        $objWorksheet->getCell('B'.$i)->setValue('SALES');
        $objWorksheet->getCell('C'.$i)->setValue('Units');
        $objWorksheet->getCell('D'.$i)->setValue('Nova');
        $objWorksheet->getCell('E'.$i)->setValue('Mega');
        $objWorksheet->getCell('F'.$i)->setValue('Super');
        $objWorksheet->getCell('G'.$i)->setValue('System');
        $objWorksheet->getCell('H'.$i)->setValue('Majestic');
        $objWorksheet->getCell('I'.$i)->setValue('Defender');
        $objWorksheet->getCell('J'.$i)->setValue('DNS');
        $objWorksheet->getCell('K'.$i)->setValue('CXL');
        $objWorksheet->getCell('L'.$i)->setValue('INC');
        $objWorksheet->getCell('M'.$i)->setValue('RB-TF');
        $objWorksheet->getCell('N'.$i)->setValue('RB-OF');
        $objWorksheet->getCell('O'.$i)->setValue('Close %');
        $objWorksheet->getCell('P'.$i)->setValue('COM');
        $objWorksheet->getCell('Q'.$i)->setValue('Prv Wk S');
        $objWorksheet->getCell('R'.$i)->setValue('Prv Wk U');
      $start=$i;
      if(!empty($stats)){
        foreach($stats as $val){
          if(isset($val["name"])){
            if($val["name"]!="totals"){
              $u=User::find($val["rep_id"]);
              if($u){
                $i++;
                $objWorksheet->getCell('A'.$i)->setValue($val['name']);
                $objWorksheet->getCell('B'.$i)->setValue($val['netsales']);
                $objWorksheet->getCell('C'.$i)->setValue($val['totnetunits']);
                $objWorksheet->getCell('D'.$i)->setValue($val['netsale']['novasystem']);
                $objWorksheet->getCell('E'.$i)->setValue($val['netsale']['megasystem']);
                $objWorksheet->getCell('F'.$i)->setValue($val['netsale']['supersystem']);
                $objWorksheet->getCell('G'.$i)->setValue($val['netsale']['system']);
                $objWorksheet->getCell('H'.$i)->setValue($val['netsale']['majestic']);
                $objWorksheet->getCell('I'.$i)->setValue($val['netsale']['defender']);
                $objWorksheet->getCell('J'.$i)->setValue($val['appointment']['DNS']);      
                $objWorksheet->getCell('K'.$i)->setValue($val['appointment']['CXL']);
                $objWorksheet->getCell('L'.$i)->setValue($val['appointment']['INC']);
                $objWorksheet->getCell('M'.$i)->setValue($val['appointment']['RBTF']);
                $objWorksheet->getCell('N'.$i)->setValue($val['appointment']['RBOF']);
                $objWorksheet->getCell('O'.$i)->setValue("=(B".$i."/(J".$i."+B".$i."))*100");
                $objWorksheet->getCell('P'.$i)->setValue("=100-((B".$i."+J".$i.")/(B".$i."+J".$i."+K".$i."+L".$i."+M".$i."+N".$i."))*100");
                if(isset($prevStats[$u->id])){
                  $objWorksheet->getCell('Q'.$i)->setValue($prevStats[$u->id]["netsales"]);
                  $objWorksheet->getCell('R'.$i)->setValue($prevStats[$u->id]["totnetunits"]);
                }
                $end=$i;

              }
            }
          }
        }
      }

        $i++;
        $i = $this->newEmptyRow($objWorksheet,$i);
        $objWorksheet->getStyle("A".$i.":Q".$i)->applyFromArray(array("font" => array( "bold" => true)));
        $objWorksheet->getStyle('O'.$i)->getNumberFormat()->setFormatCode('0.00');
        $objWorksheet->getStyle('P'.$i)->getNumberFormat()->setFormatCode('0.00');
        $objWorksheet->getCell('A'.$i)->setValue('TOTALS');
        $objWorksheet->getCell('B'.$i)->setValue('=SUM(B'.$start.':B'.$end.')');
        $objWorksheet->getCell('C'.$i)->setValue('=SUM(C'.$start.':C'.$end.')');
        $objWorksheet->getCell('D'.$i)->setValue('=SUM(D'.$start.':D'.$end.')');
        $objWorksheet->getCell('E'.$i)->setValue('=SUM(E'.$start.':E'.$end.')');
        $objWorksheet->getCell('F'.$i)->setValue('=SUM(F'.$start.':F'.$end.')');
        $objWorksheet->getCell('G'.$i)->setValue('=SUM(G'.$start.':G'.$end.')');
        $objWorksheet->getCell('H'.$i)->setValue('=SUM(H'.$start.':H'.$end.')');
        $objWorksheet->getCell('I'.$i)->setValue('=SUM(I'.$start.':I'.$end.')');
        $objWorksheet->getCell('J'.$i)->setValue('=SUM(J'.$start.':J'.$end.')');
        $objWorksheet->getCell('K'.$i)->setValue('=SUM(K'.$start.':K'.$end.')');
        $objWorksheet->getCell('L'.$i)->setValue('=SUM(L'.$start.':L'.$end.')');
        $objWorksheet->getCell('M'.$i)->setValue('=SUM(M'.$start.':M'.$end.')');
        $objWorksheet->getCell('N'.$i)->setValue('=SUM(N'.$start.':N'.$end.')');
        $objWorksheet->getCell('O'.$i)->setValue("=(B".$i."/(J".$i."+B".$i."))*100");
        $objWorksheet->getCell('P'.$i)->setValue("=100-((B".$i."+J".$i.")/(B".$i."+J".$i."+K".$i."+L".$i."+M".$i."+N".$i."))*100");
        $objWorksheet->getCell('Q'.$i)->setValue('=SUM(Q'.$start.':Q'.$end.')');
        $objWorksheet->getCell('R'.$i)->setValue('=SUM(R'.$start.':R'.$end.')');
        $objWorksheet->getStyle("B3:S100")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorksheet->getColumnDimension()->setAutoSize(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        
        $name = "DealerReport - (".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).").xls";
        // It will be called file.xls
        header('Content-Disposition: attachment; filename="'.$name.'"');
        $objWriter->save('php://output');

}

public function newEmptyRow($sheet,$c){
            $sheet->getCell('A'.$c)->setValue('');
            $c++;
            return $c;

}

public function generateWrongRow($lead,$sheet,$c){

            $sheet->getCell('A'.$c)->setValue($lead->entry_date);
            $sheet->getCell('B'.$c)->setValue($lead->cust_name);
            $sheet->getCell('C'.$c)->setValue($lead->cust_num);
            $sheet->getCell('D'.$c)->setValue($lead->rentown);
            $sheet->getCell('E'.$c)->setValue($lead->status);
            return true;


}

public function setHeadings($heading,$sheet,$c){
          
            $sheet->getCell('A'.$c)->setValue("Entry Date");
            $sheet->getCell('B'.$c)->setValue("Name");
            $sheet->getCell('C'.$c)->setValue("Phone Number");
            $sheet->getCell('D'.$c)->setValue("Owns");
            $sheet->getCell('E'.$c)->setValue("Status");
            return true;
}


 public function action_generateExcelManilla(){

      $input = Input::get();
       if(empty($input)){
        
        $day = date('w');
        $day = $day-1;
        $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
        $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));
      } else {
        $datemin = $input['startdate'];
        $datemax = $input['enddate'];
       
      }


        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';
        $objPHPexcel = New PHPExcel();
        $objWorksheet = $objPHPexcel->getActiveSheet();
        $objWorksheet->getColumnDimension('A')->setWidth(18);
        $objWorksheet->getColumnDimension('B')->setWidth(25);
        $objWorksheet->getColumnDimension('C')->setWidth(18);
        $objWorksheet->getColumnDimension('D')->setWidth(5);
        $objWorksheet->getColumnDimension('E')->setWidth(15);
       
        $wrong = DB::query("SELECT address, city,cust_num, cust_name, entry_date, status, rentown
        FROM leads WHERE original_leadtype = 'paper' AND researcher_name = 'Upload/Manilla' AND entry_date>= '".$datemin."' AND entry_date<= '".$datemax."' AND (status='WrongNumber' OR status='INVALID' OR LENGTH(cust_num)=9 OR (status='DELETED' AND assign_count=99999))");

       foreach($wrong as $val) {
        if(($val->status=="WrongNumber")||($val->status=="INVALID")){
        $arr[$val->status][] = $val;
        } else if($val->status=="DELETED"){
          $arr["DUPLICATES"][] = $val;
        }
        else {
        $arr['lessdigits'][] = $val;
        }
       
       }
        
          $i= 0;
          if(!empty($arr['WrongNumber'])){
          $this->setHeadings("Wrong Numbers",$objWorksheet,$i);
            foreach($arr['WrongNumber'] as $l){
              $l->status="Wrong Number";
            $i++;
            $this->generateWrongRow($l,$objWorksheet,$i);
           
            }
          }

          if(!empty($arr['INVALID'])){
          
          $this->setHeadings("Invalid Numbers / Renters",$objWorksheet,$i);
            foreach($arr['INVALID'] as $l){
              $l->status="Renter";
            $i++;
             $this->generateWrongRow($l,$objWorksheet,$i);
            
            }
          }

           if(!empty($arr['DUPLICATES'])){
          
          $this->setHeadings("Duplicate Numbers",$objWorksheet,$i);
            foreach($arr['DUPLICATES'] as $l){
              $l->status="Duplicate Lead";
            $i++;
             $this->generateWrongRow($l,$objWorksheet,$i);
            
            }
          }

          if(!empty($arr['lessdigits'])){

          $this->setHeadings("Less than 12 Digits",$objWorksheet,$i);
            foreach($arr['lessdigits'] as $l){
              $l->status="Too Few Digits";
            $i++;
             $this->generateWrongRow($l,$objWorksheet,$i);
            
            }
          }
          


$name = "ManillaReport - (".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).").xls";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
header('Content-Disposition: attachment; filename="'.$name.'"');
$objWriter->save('php://output');

}

public function action_generateHealthmor(){
      $input = Input::get();
      
      if(empty($input)){
        $title = "Dealer Report This Week";
        $city = '';

        $datemin = date('Y-m-1',strtotime(date('Y-m-d')));
        $datemax = date('Y-m-t',strtotime(date('Y-m-d')));
        $date = date('Y-m-d');
      } else {
        if((isset($input['city']))&&($input['city']!='all')){
        $city = "AND city = '".$input['city']."'";}
        else {
           $city = '';
        }
        $datemin = date('Y-m-1',strtotime(date('Y-m-d',strtotime($input['date']))));
        $datemax = date("Y-m-t",strtotime(date('Y-m-d',strtotime($input['date']))));
        $date = date('Y-m-d',strtotime($input['date']));
        
      }

        // you can put any date you want
        $nbDay = date('N', strtotime($date));
        $monday = new DateTime($date);
        $sunday = new DateTime($date);
        $monday->modify('-'.($nbDay-1).' days');
        $sunday->modify('+'.(7-$nbDay).' days');
        $day = date('w');
        $week_start = date('Y-m-d', strtotime($monday->format('Y-m-d H:i:s')));
        $week_end = date('Y-m-d', strtotime($sunday->format('Y-m-d H:i:s')));
        //$monthStats = Stats::saleStats($datemin,$datemax,"");
        $weekStats = Stats::saleStats($week_start,$week_end,"");

       $mdemos = DB::query("SELECT COUNT(id) as tot, SUM(status!='RB-TF' AND status!='RB-OF') totals, 
        SUM(status='SOLD') sold, SUM(status='DISP')disp, SUM(status='DNS' OR status='SOLD' OR status='INC' OR status='NQ') demos2 ,
        SUM(status='SOLD' OR status='DNS' OR status='INC') puton
        FROM appointments WHERE MONTH(app_date)=MONTH('".$datemin."')  AND YEAR(app_date) = YEAR(NOW()) ");

        $msales = DB::query("SELECT COUNT(id) as tot, 
        SUM(status!='CANCELLED' AND status!='TURNDOWN' AND status!='TBS') total, SUM(status='COMPLETE') net,
        SUM(status='CANCELLED' OR status='TURNDOWN' OR status='TBS') cancelled 
        FROM sales WHERE date >= DATE('".$datemin."') AND date <= DATE('".$datemax."')");
        
        $mtypes = DB::query("SELECT typeofsale,status, pay_type,picked_up
        FROM sales WHERE date >= DATE('".$datemin."') AND date <= DATE('".$datemax."')");

        $gmaj=0;$gdef=0;$nmaj=0;$ndef=0;$tmaj=0;$tdef=0;$cmaj=0;$cdef=0;
        $one_def=0;$one_maj=0;$two_def=0;$two_maj=0;
        foreach($mtypes as $val){
          $mt = Stats::units($val->typeofsale);

            if($mt){
                $gmaj += $mt['maj'];
                $gdef += $mt['def'];
          }

          if($val->picked_up==0){
            if($mt){
              $nmaj += $mt['maj'];
              $ndef += $mt['def'];
              if($val->pay_type=="APP A"){
                $one_def += $mt['def'];
                $one_maj += $mt['maj'];
              }
              if(($val->pay_type=="APP B")||($val->pay_type=="APP C")||($val->pay_type=="APP D")||($val->pay_type=="APP E")){
                $two_def += $mt['def'];
                $two_maj += $mt['maj'];
              }
            }
          }
          if($val->status=="TURNDOWN"){
            if($mt){
              $tmaj +=$mt['maj'];
              $tdef +=$mt['def'];
            }
          } else if($val->status=="CANCELLED" || $val->status=="TBS"){
            $cmaj += $mt['maj'];
            $cdef += $mt['def'];
          }
         
        }
      
     
      $marketing = DB::query("SELECT booker_id, booked_by, SUM(units) unit, SUM(status='SOLD' OR status='DNS' OR status='INC') puton
      FROM appointments WHERE MONTH(app_date)=MONTH('".$datemin."')  AND YEAR(app_date) = YEAR(NOW()) GROUP BY booker_id ORDER BY unit DESC");
      $sales = DB::query("SELECT rep_id, rep_name, SUM(units) unit, SUM(status='SOLD' OR status='DNS' ) puton
      FROM appointments WHERE MONTH(app_date)=MONTH('".$datemin."')  AND YEAR(app_date) = YEAR(NOW()) GROUP BY rep_id ORDER BY unit DESC");
      $appts = DB::query("SELECT sale_id,systemsale,booker_id,booked_by,rep_id FROM appointments WHERE MONTH(app_date)=MONTH('".$datemin."') AND YEAR(app_date) = YEAR(NOW())");
      
      foreach($marketing as $mark){
        $grossmaj=0;$netmaj=0;$grossdef=0;$netdef=0;
        foreach($appts as $a){
          if($a->booker_id==$mark->booker_id){
            $mt = Stats::units($a->systemsale);
            if($mt){
              $grossmaj += $mt['maj'];
              $grossdef += $mt['def'];
            }
            $sale = Sale::find($a->sale_id);
            if($sale){
              if($sale->picked_up==0){
                $netmaj += $mt['maj'];
                $netdef += $mt['def'];
              }
            }
          }
        }
        $mark->grossmaj = $grossmaj;
        $mark->grossdef = $grossdef;
        $mark->netmaj = $netmaj;
        $mark->netdef = $netdef;
      }
      
      foreach($sales as $s){
        $grossmaj=0;$netmaj=0;$grossdef=0;$netdef=0;
        foreach($appts as $a){
          if($a->rep_id==$s->rep_id){
            $mt = Stats::units($a->systemsale);
            if($mt){
              $grossmaj += $mt['maj'];
              $grossdef += $mt['def'];
            }
            $sale = Sale::find($a->sale_id);
            if($sale){
              if($sale->picked_up==0){
                $netmaj += $mt['maj'];
                $netdef += $mt['def'];
              }
            }
          }
        }
        $s->grossmaj = $grossmaj;
        $s->grossdef = $grossdef;
        $s->netmaj = $netmaj;
        $s->netdef = $netdef;
      }
     
      $reggie = DB::query("SELECT COUNT(id) as tot, researcher_name, researcher_id FROM leads 
      WHERE original_leadtype='door' AND MONTH(entry_date)=MONTH('".$datemin."')  AND YEAR(entry_date) = YEAR(NOW()) 
      AND status!='WrongNumber' AND status!='INVALID' AND researcher_name!='OldSystemTransfer' GROUP BY researcher_id ORDER BY tot DESC");

      $styleArray = array(
      'font' => array(
        'bold' => true
      )
      );

      
      
      $settings = Setting::find(1);
      $name = strtoupper(str_replace(" - Rep Dashboard","",$settings->title));
      require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

      $objPHPexcel = PHPExcel_IOFactory::load('public/img/HealthmorTemplate.xls');
      $objWorksheet = $objPHPexcel->getActiveSheet();
      $i=8;
      $objWorksheet->getCell('D'.$i)->setValue("Week Ending ".date('M-d',strtotime($datemax)));

      $i=13;
      $objWorksheet->getCell('A'.$i)->setValue($settings->distcode);
      $objWorksheet->getCell('B'.$i)->setValue($name);
      $objWorksheet->getCell('C'.$i)->setValue($weekStats["totals"]["grossmd"]["majestic"]);
      $objWorksheet->getCell('D'.$i)->setValue($weekStats["totals"]["grossmd"]["defender"]);
      $objWorksheet->getCell('E'.$i)->setValue($gmaj);
      $objWorksheet->getCell('F'.$i)->setValue($gdef);
      $objWorksheet->getCell('G'.$i)->setValue($nmaj);
      $objWorksheet->getCell('H'.$i)->setValue($ndef);
      $objWorksheet->getCell('I'.$i)->setValue($weekStats["totals"]["appointment"]["PUTON"]);
      $objWorksheet->getCell('J'.$i)->setValue($mdemos[0]->puton);
      $objWorksheet->getCell('K'.$i)->setValue($weekStats["totals"]["appointment"]["TOTALS"]);
      $objWorksheet->getCell('L'.$i)->setValue($mdemos[0]->totals);
      $objWorksheet->getCell('M'.$i)->setValue('');
      $objWorksheet->getCell('N'.$i)->setValue('');
      $objWorksheet->getCell('O'.$i)->setValue('');
      $objWorksheet->getCell('P'.$i)->setValue('');
      $objWorksheet->getCell('Q'.$i)->setValue('');
      $objWorksheet->getCell('R'.$i)->setValue('');
      $objWorksheet->getCell('S'.$i)->setValue('');

      // Top Canvassers
      $i=23;
      for($j=0;$j<3;$j++){
        if(isset($canvas[$j])){
          $objWorksheet->mergeCells('A'.$i.':G'.$i);
          $objWorksheet->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->mergeCells('F'.$i.':G'.$i);
          $objWorksheet->getStyle('F'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->mergeCells('H'.$i.':L'.$i);
          $objWorksheet->getStyle('H'.$i.':L'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->getCell('A'.$i)->setValue(strtoupper($sales[$j]->rep_name));
          $objWorksheet->getCell('H'.$i)->setValue($name);
          $objWorksheet->getCell('M'.$i)->setValue($sales[$j]->grossmaj);
          $objWorksheet->getCell('N'.$i)->setValue($sales[$j]->grossdef);
          $objWorksheet->getCell('O'.$i)->setValue($sales[$j]->netmaj);
          $objWorksheet->getCell('P'.$i)->setValue($sales[$j]->netdef);
          $objWorksheet->getCell('Q'.$i)->setValue(0);
          $objWorksheet->getCell('R'.$i)->setValue(0);
          $objWorksheet->getCell('S'.$i)->setValue(0);
           $i++;
        }
      }

      // Top Marketer Info
      $i=31;
      for($j=0;$j<3;$j++){
        if(isset($marketing[$j])){
            $objWorksheet->mergeCells('A'.$i.':G'.$i);
            $objWorksheet->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objWorksheet->mergeCells('H'.$i.':N'.$i);
            $objWorksheet->getStyle('H'.$i.':N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objWorksheet->getCell('A'.$i)->setValue(strtoupper($marketing[$j]->booked_by));
            $objWorksheet->getCell('H'.$i)->setValue($name);
            $objWorksheet->getCell('O'.$i)->setValue($marketing[$j]->grossmaj);
            $objWorksheet->getCell('P'.$i)->setValue($marketing[$j]->grossdef);
            $objWorksheet->getCell('Q'.$i)->setValue($marketing[$j]->netmaj);
            $objWorksheet->getCell('R'.$i)->setValue($marketing[$j]->netdef);
            $objWorksheet->getCell('S'.$i)->setValue($marketing[$j]->puton);
            $i++;
        }
      }
      
      // Top Door Reggiers
      $i=42;
      for($j=0;$j<3;$j++){
        if(isset($reggie[$j])){
          $objWorksheet->mergeCells('A'.$i.':G'.$i);
          $objWorksheet->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->mergeCells('H'.$i.':N'.$i);
          $objWorksheet->getStyle('H'.$i.':N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->getCell('A'.$i)->setValue(strtoupper($reggie[$j]->researcher_name));
          $objWorksheet->getCell('H'.$i)->setValue($name);
          $objWorksheet->getCell('O'.$i)->setValue($reggie[$j]->tot);
          $i++;
        }
      }

      // Top Specialists
      $i=55;
      for($j=0;$j<3;$j++){
        if(isset($sales[$j])){
          if(!empty($sales[$j]->rep_name)){
          $objWorksheet->mergeCells('A'.$i.':G'.$i);
          $objWorksheet->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->mergeCells('F'.$i.':G'.$i);
          $objWorksheet->getStyle('F'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->mergeCells('H'.$i.':L'.$i);
          $objWorksheet->getStyle('H'.$i.':L'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->getCell('A'.$i)->setValue(strtoupper($sales[$j]->rep_name));
          $objWorksheet->getCell('H'.$i)->setValue($name);
          $objWorksheet->getCell('M'.$i)->setValue($sales[$j]->grossmaj);
          $objWorksheet->getCell('N'.$i)->setValue($sales[$j]->grossdef);
          $objWorksheet->getCell('O'.$i)->setValue($sales[$j]->netmaj);
          $objWorksheet->getCell('P'.$i)->setValue($sales[$j]->netdef);
          $objWorksheet->getCell('Q'.$i)->setValue(0);
          $objWorksheet->getCell('R'.$i)->setValue(0);
          $objWorksheet->getCell('S'.$i)->setValue(0);
           $i++;
         }
        }
      }
  
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
      // We'll be outputting an excel file
      header('Content-type: application/vnd.ms-excel');
      $name = "Monthly-WeeklyDistStats-(".date('M',strtotime($datemin)).").xls";
      // It will be called file.xls
      header('Content-Disposition: attachment; filename="'.$name.'"');
      $objWriter->save('php://output');

  }




  public function action_monthlyReport(){
      $input = Input::get();
      
      if(empty($input)){
        $title = "Dealer Report This Week";
        $city = '';

        $datemin = date('Y-m-1',strtotime(date('Y-m-d')));
        $datemax = date('Y-m-t',strtotime(date('Y-m-d')));
      } else {
        if((isset($input['city']))&&($input['city']!='all')){
        $city = "AND city = '".$input['city']."'";}
        else {
           $city = '';
        }
        $datemin = date('Y-m-1',strtotime(date('Y-m-d',strtotime($input['date']))));
        $datemax = date("Y-m-t",strtotime(date('Y-m-d',strtotime($input['date']))));
        
      }



       $mdemos = DB::query("SELECT COUNT(id) as tot, SUM(status!='RB-TF' AND status!='RB-OF') totals, 
        SUM(status='SOLD') sold, SUM(status='DISP')disp, SUM(status='DNS' OR status='SOLD' OR status='INC' OR status='NQ') demos2,
        SUM(status='SOLD' OR status='DNS' OR status='INC') puton
        FROM appointments WHERE MONTH(app_date)=MONTH('".$datemin."') AND YEAR(app_date) = YEAR(NOW()) ");

        $msales = DB::query("SELECT COUNT(id) as tot, 
        SUM(status!='CANCELLED' AND status!='TURNDOWN' AND status!='TBS') total, SUM(status='COMPLETE') net,
        SUM(status='CANCELLED' OR status='TURNDOWN' OR status='TBS') cancelled 
        FROM sales WHERE date >= DATE('".$datemin."') AND date <= DATE('".$datemax."')");
        
        $mtypes = DB::query("SELECT typeofsale,status, pay_type,picked_up
        FROM sales WHERE date >= DATE('".$datemin."') AND date <= DATE('".$datemax."')");

        $gmaj=0;$gdef=0;$nmaj=0;$ndef=0;$tmaj=0;$tdef=0;$cmaj=0;$cdef=0;
        $one_def=0;$one_maj=0;$two_def=0;$two_maj=0;
        foreach($mtypes as $val){
          $mt = Stats::units($val->typeofsale);

            if($mt){
                $gmaj += $mt['maj'];
                $gdef += $mt['def'];

          }

          if($val->picked_up==0){
            if($mt){
              $nmaj += $mt['maj'];
              $ndef += $mt['def'];
              if($val->pay_type=="APP A" || $val->pay_type=="CREDITCARD" || $val->pay_type=="CHEQUE" || $val->pay_type=="CASH"){
                $one_def += $mt['def'];
                $one_maj += $mt['maj'];
              } else if(($val->pay_type=="APP B" || $val->pay_type=="APP C" || $val->pay_type=="APP D" || $val->pay_type=="APP E")){
                $two_def += $mt['def'];
                $two_maj += $mt['maj'];
              }
            }
          }
          if($val->status=="TURNDOWN"){
            if($mt){
              $tmaj +=$mt['maj'];
              $tdef +=$mt['def'];
            }
          } else if($val->status=="CANCELLED" || $val->status=="TBS"){
            $cmaj += $mt['maj'];
            $cdef += $mt['def'];
          }
         
        }
      
     
      $marketing = DB::query("SELECT booker_id, booked_by, SUM(units) unit, SUM(status='SOLD' OR status='DNS' OR status='INC') puton
      FROM appointments WHERE MONTH(app_date)=MONTH('".$datemin."') AND YEAR(app_date) = YEAR(NOW()) GROUP BY booker_id ORDER BY unit DESC");
      $sales = DB::query("SELECT rep_id, rep_name, SUM(units) unit, SUM(status='SOLD' OR status='DNS' ) puton
      FROM appointments WHERE MONTH(app_date)=MONTH('".$datemin."') AND YEAR(app_date) = YEAR(NOW()) GROUP BY rep_id ORDER BY unit DESC");
      $appts = DB::query("SELECT sale_id,systemsale,booker_id,booked_by,rep_id FROM appointments WHERE MONTH(app_date)=MONTH('".$datemin."') AND YEAR(app_date) = YEAR(NOW())");
      
      foreach($marketing as $mark){
        $grossmaj=0;$netmaj=0;$grossdef=0;$netdef=0;
        foreach($appts as $a){
          if($a->booker_id==$mark->booker_id){
            $mt = Stats::units($a->systemsale);
            if($mt){
              $grossmaj += $mt['maj'];
              $grossdef += $mt['def'];
            }
            $sale = Sale::find($a->sale_id);
            if($sale){
              if($sale->picked_up==0){
                $netmaj += $mt['maj'];
                $netdef += $mt['def'];
              }
            }
          }
        }
        $mark->grossmaj = $grossmaj;
        $mark->grossdef = $grossdef;
        $mark->netmaj = $netmaj;
        $mark->netdef = $netdef;
      }
      
      foreach($sales as $s){
        $grossmaj=0;$netmaj=0;$grossdef=0;$netdef=0;
        foreach($appts as $a){
          if($a->rep_id==$s->rep_id){
            $mt = Stats::units($a->systemsale);
            if($mt){
              $grossmaj += $mt['maj'];
              $grossdef += $mt['def'];
            }
            $sale = Sale::find($a->sale_id);
            if($sale){
              if($sale->picked_up==0){
                $netmaj += $mt['maj'];
                $netdef += $mt['def'];
              }
            }
          }
        }
        $s->grossmaj = $grossmaj;
        $s->grossdef = $grossdef;
        $s->netmaj = $netmaj;
        $s->netdef = $netdef;
      }
     
      $reggie = DB::query("SELECT COUNT(id) as tot, researcher_name, researcher_id FROM leads 
      WHERE original_leadtype='door' AND MONTH(entry_date)=MONTH('".$datemin."') AND YEAR(entry_date) = YEAR(NOW())
      AND status!='WrongNumber' AND status!='INVALID' AND researcher_name!='OldSystemTransfer' GROUP BY researcher_id ORDER BY tot DESC");

      $styleArray = array(
      'font' => array(
        'bold' => true
      )
      );
      
      $settings = Setting::find(1);
      $name = strtoupper(str_replace(" - Rep Dashboard","",$settings->title));
      require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';

      $objPHPexcel = PHPExcel_IOFactory::load('public/img/DistributorStatsTemplate.xls');
      $objWorksheet = $objPHPexcel->getActiveSheet();
      $i=9;
      $objWorksheet->getCell('D'.$i)->setValue("Month Ending : ".date('M Y',strtotime($datemax)));

      $i=13;
      $objWorksheet->getCell('A'.$i)->setValue($settings->distcode);
      $objWorksheet->getCell('B'.$i)->setValue($name);
      $objWorksheet->getCell('C'.$i)->setValue($gmaj);
      $objWorksheet->getCell('D'.$i)->setValue($gdef);
      $objWorksheet->getCell('E'.$i)->setValue('');
      $objWorksheet->getCell('F'.$i)->setValue('');
      $objWorksheet->getCell('G'.$i)->setValue($tmaj);
      $objWorksheet->getCell('H'.$i)->setValue($tdef);
      $objWorksheet->getCell('I'.$i)->setValue($cmaj);
      $objWorksheet->getCell('J'.$i)->setValue($cdef);
      $objWorksheet->getCell('K'.$i)->setValue($nmaj);
      $objWorksheet->getCell('L'.$i)->setValue($ndef);
      $objWorksheet->getCell('M'.$i)->setValue($one_maj);
      $objWorksheet->getCell('N'.$i)->setValue($one_def);
      $objWorksheet->getCell('O'.$i)->setValue($two_maj);
      $objWorksheet->getCell('P'.$i)->setValue($two_def);
      $objWorksheet->getCell('Q'.$i)->setValue('');
      $objWorksheet->getCell('R'.$i)->setValue($mdemos[0]->totals);
      $objWorksheet->getCell('S'.$i)->setValue($mdemos[0]->puton);

      // Top Canvassers
      $i=22;
      for($j=0;$j<3;$j++){
        if(isset($canvas[$j])){
          $objWorksheet->mergeCells('A'.$i.':G'.$i);
          $objWorksheet->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->mergeCells('F'.$i.':G'.$i);
          $objWorksheet->getStyle('F'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->mergeCells('H'.$i.':L'.$i);
          $objWorksheet->getStyle('H'.$i.':L'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->getCell('A'.$i)->setValue(strtoupper($sales[$j]->rep_name));
          $objWorksheet->getCell('H'.$i)->setValue($name);
          $objWorksheet->getCell('M'.$i)->setValue($sales[$j]->grossmaj);
          $objWorksheet->getCell('N'.$i)->setValue($sales[$j]->grossdef);
          $objWorksheet->getCell('O'.$i)->setValue($sales[$j]->netmaj);
          $objWorksheet->getCell('P'.$i)->setValue($sales[$j]->netdef);
          $objWorksheet->getCell('Q'.$i)->setValue(0);
          $objWorksheet->getCell('R'.$i)->setValue(0);
          $objWorksheet->getCell('S'.$i)->setValue(0);
           $i++;
        }
      }

      // Top Marketer Info
      $i=31;
      for($j=0;$j<3;$j++){
        if(isset($marketing[$j])){
            $objWorksheet->mergeCells('A'.$i.':G'.$i);
            $objWorksheet->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objWorksheet->mergeCells('H'.$i.':N'.$i);
            $objWorksheet->getStyle('H'.$i.':N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objWorksheet->getCell('A'.$i)->setValue(strtoupper($marketing[$j]->booked_by));
            $objWorksheet->getCell('H'.$i)->setValue($name);
            $objWorksheet->getCell('O'.$i)->setValue($marketing[$j]->grossmaj);
            $objWorksheet->getCell('P'.$i)->setValue($marketing[$j]->grossdef);
            $objWorksheet->getCell('Q'.$i)->setValue($marketing[$j]->netmaj);
            $objWorksheet->getCell('R'.$i)->setValue($marketing[$j]->netdef);
            $objWorksheet->getCell('S'.$i)->setValue($marketing[$j]->puton);
            $i++;
        }
      }
      
      // Top Door Reggiers
      $i=51;
      for($j=0;$j<3;$j++){
        if(isset($reggie[$j])){
          $objWorksheet->mergeCells('A'.$i.':G'.$i);
          $objWorksheet->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->mergeCells('H'.$i.':N'.$i);
          $objWorksheet->getStyle('H'.$i.':N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->getCell('A'.$i)->setValue(strtoupper($reggie[$j]->researcher_name));
          $objWorksheet->getCell('H'.$i)->setValue($name);
          $objWorksheet->getCell('O'.$i)->setValue($reggie[$j]->tot);
          $i++;
        }
      }

      // Top Specialists
      $i=61;
      for($j=0;$j<3;$j++){
        if(isset($sales[$j])){
          if(!empty($sales[$j]->rep_name)){
          $objWorksheet->mergeCells('A'.$i.':G'.$i);
          $objWorksheet->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->mergeCells('F'.$i.':G'.$i);
          $objWorksheet->getStyle('F'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->mergeCells('H'.$i.':L'.$i);
          $objWorksheet->getStyle('H'.$i.':L'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $objWorksheet->getCell('A'.$i)->setValue(strtoupper($sales[$j]->rep_name));
          $objWorksheet->getCell('H'.$i)->setValue($name);
          $objWorksheet->getCell('M'.$i)->setValue($sales[$j]->grossmaj);
          $objWorksheet->getCell('N'.$i)->setValue($sales[$j]->grossdef);
          $objWorksheet->getCell('O'.$i)->setValue($sales[$j]->netmaj);
          $objWorksheet->getCell('P'.$i)->setValue($sales[$j]->netdef);
          $objWorksheet->getCell('Q'.$i)->setValue(0);
          $objWorksheet->getCell('R'.$i)->setValue(0);
          $objWorksheet->getCell('S'.$i)->setValue(0);
           $i++;
         }
        }
      }
  
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
      // We'll be outputting an excel file
      header('Content-type: application/vnd.ms-excel');
      $name = "MonthlyDistributorStats-(".date('M',strtotime($datemin)).").xls";
      // It will be called file.xls
      header('Content-Disposition: attachment; filename="'.$name.'"');
      $objWriter->save('php://output');

  }




}