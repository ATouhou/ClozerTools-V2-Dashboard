<?php
class Appointment_Controller extends Base_Controller
{
	public function __construct(){
    parent::__construct();
    $this->filter('before','auth');
  }
  // APPOINTMENT API
  public function action_getappts(){
  	$appointments = Appointment::get();
  }


  public function action_index(){
  	$appts = Appointment::where('app_date','=',date('Y-m-d',strtotime('-5 Months')))->order_by('app_time','DESC')->get();
  	return View::make('appointment.board')->with('appts',$appts);
  }



  //**********MAIN INDEX PAGE*************//
  public function action_oldindex(){ 
    $input = Input::get();
    if(isset($input['appdate'])){
      $date = date('Y-m-d', strtotime(Input::get('appdate')));
    } else {
       $date = date('Y-m-d');
    }
    if(isset($input['app_city'])){
      $city = $input['app_city'];
    } else {
      $city = "all";
    }
    if(Auth::user()->user_type=="salesrep"){
      $todayappts = Appointment::where("app_date","=",$date)
      ->where("rep_id","=",Auth::user()->id)
      ->order_by("app_time","DESC")
      ->get();
    } else {

    if($city=="all"){
        $todayappts = Appointment::where("app_date","=",$date)
      ->order_by("app_time","DESC")
      ->get();
    } elseif(strpos($city,"RC1")){
       $todayappts = Appointment::where("city","LIKE","%RC1%")->where("app_date","=",$date)
      ->order_by("app_time","DESC")
      ->get();
    }  elseif(strpos($city,"RC2")){
       $todayappts = Appointment::where("city","LIKE","%RC2%")->where("app_date","=",$date)
      ->order_by("app_time","DESC")
      ->get();
    } elseif(strpos($city,"RC3")){
       $todayappts = Appointment::where("city","LIKE","%RC3%")->where("app_date","=",$date)
      ->order_by("app_time","DESC")
      ->get();
    }  elseif(strpos($city,"RC4")){
       $todayappts = Appointment::where("city","LIKE","%RC4%")->where("app_date","=",$date)
      ->order_by("app_time","DESC")
      ->get();
    } else {
      $todayappts = Appointment::where("city","LIKE",$city)->where("app_date","=",$date)
      ->order_by("app_time","DESC")
      ->get();
    }
   }
    $reps = User::where('user_type','=','salesrep')
      ->where('type','=','employee')
      ->where('level','!=',99)
      ->order_by('firstname','asc')
      ->get();

    $door = User::where('user_type','=','doorrep')
    ->where('type','=','employee')
    ->where('level','!=',99)
    ->order_by('firstname','asc')
    ->get();

    $texts = User::where('user_type','=','other')
    ->order_by('firstname','asc')
    ->get();
    $managers = User::where('user_type','=','manager')
    ->where('type','=','employee')
    ->where('level','!=',99)
    ->order_by('firstname','asc')
    ->get();

    $bookers = User::where('user_type','=','agent')
    ->where('type','=','employee')
      ->where('level','!=',99)
      ->order_by('firstname','asc')
      ->get(array('id','firstname','lastname','texting'));
   
    $sold = Lead::where('result','=','SOLD')
    ->where('app_date','=',$date)
    ->order_by('app_time','DESC')->count();

    $header=true;
    $first_date = date('Y-m-d',strtotime('last monday', strtotime($date)));
    $last_date = date('Y-m-d',strtotime('this sunday',strtotime($date)));
    $citylist = array();$allcities=array();
    $roadcrew = Roadcrew::get();
    foreach($roadcrew as $r){
      $citylist[$r->id] = $r->citylist();
    }
    foreach($citylist as $cit){
      foreach($cit as $k=>$v){
        $allcities[$k] = $v;
      }
    }
      $slots = Appointment::appslots();
      foreach($slots as $k=>$s){
        $end=strtotime($s->end)-60;
        $end= date('H:i:s',$end);
        $slot[] = array("s"=>$s->start,"f"=>$end,"name"=>$s->slot_name,"selector"=>str_replace(array(":","#"," ",",",".","-","|"),"",$s->slot_name));
      }
    return View::make('appointment.board')
    ->with('roadcrews',$roadcrew)
    ->with('slots',$slot)
    ->with('crewcities',$allcities)
      ->with('appts',$todayappts)
      ->with('reps',$reps)
      ->with('header',$header)
      ->with('bookers',$bookers)
      ->with('door',$door)
      ->with('text',$texts)
      ->with('managers',$managers)
      ->with('sold',$sold)
      ->with('date',date('M-d',strtotime($date)))
      ->with('datepass',$date);
  }

  //*********AJAX LOADED INFORMATION****************//
  //****AJAX LOAD CALLOUT BOX******//
  public function action_callout($id){
    $app = Appointment::find($id);
    if($app){
      return View::make('plugins.closecallout')
      ->with('app',$app);
    }
  }
  //*****AJAX LOAD STILL DISPATCHED*********/
  public function action_stilldispatched($id){
    if($id==null){
      return "Failed";
    }
    $apps = Appointment::where('rep_id','=',$id)->where('status','=','DISP')->get();
    $therep = User::find($id)->firstname." ".User::find($id)->lastname;
    return View::make('plugins.stilldispatched')
    ->with('apps',$apps)
    ->with('therep',$therep);
  }
  //******AJAX APPT INFO**************//
  public function action_getapptinfo($id){
    $appt = Appointment::with('lead')->find($id);
    return Response::json($appt);
  }
  //*****AJAX APPT DUPLICATE CHECKER***********//
  public function action_check(){
    $input = Input::get();

    if(empty($input['lead_id'])){
      return Response::json("failed");
    } else {
      $app = Appointment::where('lead_id','=',$input['lead_id'])->where('app_date','=',$input['date'])->first();
      if($app){
        return Response::json("alreadyexists");
      } else {
        return Response::json("success");
      }
    }
  }

  //*****************************************//

  //****AJAX LEAD INFO***************
  public function action_viewlead($id){
    $app = Appointment::find($id);
    $lead = Lead::with(array('calls','appointments'))->find($app->lead_id);
    return Response::json($lead);
  }
  //*****AJAX REUP UPDATE ALERTER******//
  public function action_refresh(){
    $alert = Alert::find(10);
    if($alert->seen==0){
      return View::make('appointment.refreshmodule')
      ->with('msg',$alert);
    } else {
      return false;
    }
  }
  //****AJAX SUBMIT SALE BOX*****//
  public function action_getsaleinfo($id){
    $app = Appointment::find($id);
    if($app){
      $u = User::find($app->rep_id);
    }
    if($u){
      return View::make('plugins.submitsale')
      ->with('app',$app)
      ->with('u',$u);
    } else {
      return "SERVER ERROR";
    }
  }
    //******AJAX DEALER STATUS**************//
  public function action_dealerstatus(){
    $indem = array(); $avail=array(); $out = array(); $intest=array();$disp=array();
    $reps = User::activeUsers('salesrep');
    $inapps = Appointment::where('rep_id','!=','0')
    ->where('status','=','DISP')
    ->where('app_date','=',date('Y-m-d'))
    ->group_by('rep_id')->get();

    foreach($inapps as $v){
       $u = User::find($v->rep_id);
      if($u){
        if($v->ridealong_id!=0){
          $with = $v->ridealong_id;
        } else {
          $with = "none";
        }
        $intest[$v->rep_id]=array("appid"=>$v->id,"name"=>$u->firstname." ".$u->attributes['lastname'][0],"in"=>$v->in,"type"=>"normal","with"=>$with);
      }
      
      if($v->ridealong_id!=0){
        $u = User::find($v->ridealong_id);
        if($u){
          $intest[$v->ridealong_id]=array("appid"=>$v->id,"name"=>$u->firstname." ".$u->attributes['lastname'][0],"in"=>$v->in,"type"=>"ridealong", "with"=>$v->rep_id);
        }
      }
    }

    foreach($reps as $val){
       if(array_key_exists($val->id, $intest)){
        if($val->working==1){
          if($intest[$val->id]["in"]!='00:00:00'){
                $indem[$val->id]=array("appid"=>$intest[$val->id]["appid"],"name"=>$val->firstname." ".$val->lastname[0],"in"=>$intest[$val->id]["in"],"type"=>$intest[$val->id]["type"],"with"=>$intest[$val->id]["with"]);
            } else {
                $disp[$val->id]=array("appid"=>$intest[$val->id]["appid"],"name"=>$val->firstname." ".$val->lastname[0],"in"=>$intest[$val->id]["in"],"type"=>$intest[$val->id]["type"],"with"=>$intest[$val->id]["with"]);
          }
        }
       } else {
        if($val->working==1){
          $out[$val->id]=$val->firstname." ".$val->lastname[0];
        }
       }
    }
  
    return View::make('plugins.repstatus-data')
    ->with('reps',$reps)
    ->with('disp',$disp)
    ->with('indemo',$indem)
    ->with('out',$out);
  }
  
  //*******DISPLAY DEMP ON MAP************
  public function action_viewdemomap(){
    $input = Input::get();

    if(empty($input)){
      return json_encode("failed");
    } else {
      
      if(($input['start']=="all")&&($input['city']=="all")){
         $apps = Appointment::where('app_date','=',$input['date'])
      ->get();
      } else if(($input['start']=="all")&&($input['city']!="all")){
        $apps = Appointment::where('app_date','=',$input['date'])
       ->where('city','=',$input['city'])
      ->get();
      } else if(($input['start']!="all")&&($input['city']=="all")){
        $apps = Appointment::where('app_date','=',$input['date'])
      ->where('app_time','>=',date('H:i',strtotime($input['start'])))
      ->where('app_time','<=',date('H:i',strtotime($input['end'])))
      ->get();
    } else if(($input['start']!="all")&&($input['city']!="all")){
       $apps = Appointment::where('app_date','=',$input['date'])
       ->where('city','=',$input['city'])
      ->where('app_time','>=',date('H:i',strtotime($input['start'])))
      ->where('app_time','<=',date('H:i',strtotime($input['end'])))
      ->get();
    }
      foreach($apps as $val){
          if($val->lead->lat!=0){
            $icon=URL::to_asset('img/app-nq.png'); 
          $label = "important special";

           if($val->status=="DISP"){
              $label = "info special";
              $icon = URL::to_asset('img/app-disp.png');
            } 

            if($val->status=="APP"){
              $label = "info";
              $icon = $icon = URL::to_asset('img/app-app2.png');
            } 

            if($val->status=="SOLD"){
              $label = "success special";
              $icon = URL::to_asset('img/app-sale.png');
            }

            if($val->status=="DNS"){
              $label = "important special";
              $icon = URL::to_asset('img/app-dns.png');
            }

            if($val->status=="INC"){
              $label = "warning";
              $icon = URL::to_asset('img/app-inc.png');
            }

            if($val->status=="CXL"){
              $label = "important";
              $icon = URL::to_asset('img/app-cxl.png');
            }

            if(($val->status=="RB-TF")||($val->status=="RB-OF")){
              $label = "info special";
              $icon = URL::to_asset('img/app-rb.png');
            }
           
            if($val->status=="NQ"){
              $icon=URL::to_asset('img/app-nq.png'); 
              $label = "important special";
            }
            
            if($val->status=="CONF"){
              $icon=URL::to_asset('img/app-conf.png'); 
              $label = "success";
            }
            
            if($val->status=="NA"){
              $icon=URL::to_asset('img/app-na.png'); 
              $label = "warning";
            }
             if($val->status=="BUMP"){
              $icon=URL::to_asset('img/app-bump.png'); 
              $label = "info";
             }
         
       
         $markers[] = array("latLng"=>array($val->lead->lat,$val->lead->lng),
            "id"=>$val->lead->id,
            "data"=>$val->lead->address." | " .$val->app_time. " | ",
            "tag"=>$val->status,
            "options"=>array("icon"=>$icon));
          }
          
      }
      if(empty($markers)){
        return Response::json("nodata");
      } else {
         return Response::json($markers);
      }
    }   
  }
  //*********END AJAX LOADED INFORMATION****************//





  //*************APPOINTMENT PROCESSING FUNCTIONS***********//
  public function action_dispatch(){
    $input=Input::get();
    $id = Input::get('dispid');
    $rep = User::find(Input::get('rep'));
    $rightaway = Input::get('rightaway');
    $sendtext = Input::get('sendtext');
    $setNote = Input::get('textRepNote');
    $m = "";
    if(!empty($input['ridealong'])){
      $ra= User::find(Input::get('ridealong'));
      $ridealong = $ra->id;
     } else {
      $ra=array();
      $ridealong=0;
     }


 
      if(!empty($rep)){
        $repname = $rep->firstname." ".$rep->lastname;
             
        $appt = Appointment::find($id);

        if($appt->status!="SOLD" && $appt->status!="DNS" && $appt->status!="INC"){
          $appt->status = "DISP";
        }
        if($appt->status=="SOLD"){
          $sale = Sale::find($appt->sale_id);
          if($sale){
            $sale->user_id = $rep->id;
            $sale->ridealong_id = $ridealong;
            $sale->sold_by = $repname;
            $sale->save();

          }
        }
        
        $appt->rep_id = Input::get('rep');
        $appt->rep_name = $repname;
        $appt->ridealong_id = $ridealong;
        $appt->dispatch_time = date("Y-m-d H:i:s");
        $appt->save();

        $lead = Lead::find($appt->lead_id);
        if($appt->status!="SOLD" && $appt->status!="DNS" && $appt->status!="INC"){
          $lead->result = "DISP";
        }
        
        $lead->rep = Input::get('rep');
        $lead->rep_name = $repname;
        $lead->save();

        if(!empty($rep->cell_no)){
           if((isset($sendtext))&&($sendtext=="on")){
           $t = New Twilio;
             if($rightaway){
               $m = "NEW RIGHTAWAY DEMO! Customer : ".$lead->cust_name." and ".$lead->spouse_name." - ADDRESS : ".$lead->address." | GIFT : ".$lead->gift." || http://maps.google.com/?q=".urlencode($lead->address);
              } else {
                $m = "NEW DEMO!! ".date('g:i a',strtotime($appt->app_time)). " - Customer : ".$lead->cust_name." and ".$lead->spouse_name." - ADDRESS : ".$lead->address." | GIFT : ".$lead->gift." || http://maps.google.com/?q=".urlencode($lead->address);
            }

            if(!empty($setNote)){
              $m = "NOTE : ".$setNote." | ".$m;
            }
            $t->sendSMS($rep->cell_no, $m );
            if(!empty($ra)){
              if(!empty($ra->cell_no)){
                $t->sendSMS($ra->cell_no, $m );
              }
            }
          }
        }

        $alert = Alert::find(5);
        $alert->message = "APPOINTMENT DISPATCH : ".$lead->cust_name."'s Appointment has been dispatched to ".strtoupper($repname)." by ".Auth::user()->firstname." ".Auth::user()->lastname."";
        $alert->color = "success";
        $alert->icon = "cus-car";
        $alert->save();
      } 

    return Redirect::back();
  }
  //*****BUMP FOR TODAY*********//
  public function action_bumptime(){
    $input = Input::get();
      if(empty($input['bumptoday'])){
        return Response::json("failed");
      }

    $appt = Appointment::find($input['theid']);
    $lead = Lead::find($appt->lead_id);
    $lead->bump_count = $lead->bump_count+1;
    $lead->app_time = date('H:i',strtotime($input['bumptoday']));
    if(isset($input['notes'])){
      if(!empty($input['notes'])){
        $lead->notes = $input['notes'];
      }
    }
    $lead->save();

    $appt->app_time = date('H:i',strtotime($input['bumptoday']));
      if(Auth::user()->user_type=="agent"){
        $appt->status = "CONF";
      }
    
    if($appt->save()){
      return Response::json("success");
    } else {
      return Response::json("failed");
    };
    
  }
  //*****BUMP APPOINTMENT*********//
  public function action_bump(){
    $id = Input::get('id');
    $notes = Input::get('notes');
    $rep = User::find(Input::get('rep'));
    $repname = $rep->firstname." ".$rep->lastname;
  
    $appt = Appointment::find($id);
    $appt->status = "BUMP";
    $appt->bump_id = $rep->id;
    $appt->bump_notes = $notes;
    $appt->save();

    $lead = Lead::find($appt->lead_id);
    $lead->result = "BUMP";
    $lead->save();
    
    $alert = New Alert;
    $alert->receiver_id = Input::get('rep');
    $alert->message = "APPOINTMENT TO BUMP sent by ".Auth::user()->firstname." REFRESH YOUR DASHBOARD TO VIEW!!";
    $alert->type = "personal";
    $alert->save();

    $alert = Alert::find(5);
    $alert->message = "APPOINTMENT BUMP Sent to ".$repname." for ".$lead->cust_name."'s Appointment @ ".$appt->app_time;
    $alert->color = "success";
    $alert->icon = "cus-car";
        
    $alert->save();
    return json_encode($appt->attributes);
  }
  //*******UN-DISPATCH APPOINTMENT FROM REP******//
  public function action_return($id){
    $appt = Appointment::find($id);
    $appt->status = "APP";
    $appt->rep_id = "";
    $appt->rep_name = "";
    $appt->ridealong_id = "";
    $appt->dispatch_time = "";

    $lead = Lead::find($appt->lead_id);
    $lead->result = "APP";
    $lead->rep = "";
    $lead->rep_name = "";
    $lead->save();

    $test = $appt->save();
      if($test){
        $alert = Alert::find(5);
        $alert->message = "APPOINTMENT UPDATE : ".$appt->cust_name."'s Appointment has been returned to Appointment Board by ".Auth::user()->firstname." ".Auth::user()->lastname."";
        $alert->color = "warning";
        $alert->icon = "cus-arrow-left";
        $alert->save();
      }
    return Redirect::back();
  }
  //******PROCESS APPT********//
  public function action_process(){
    $input = Input::get();
    $id = $input['idnum'];

    $appt = Appointment::find($id);
    $leadid = $appt->lead_id;

    if(empty($input['result'])){
      if(!empty($input['notes'])){
        $l = Lead::find($leadid);
        $l->notes = $input['notes'];
        $l->save();
        return Redirect::back();
      }
    }
    
    $oldstat = $appt->status;
    $newstat = $input['result'];

    $appt->status = $newstat;

    $lead = Lead::find($leadid);
    $lead->notes = $input['notes'];
    $lead->result = $newstat;
      if(($newstat=="DNS")||($newstat=="INC")){
        $lead->status = "APP";
        $sale = Sale::find($appt->sale_id);
        if($sale){
         $sale->delete();
         $appt->sale_id=0;
         $lead->sale_id=0;
        } else {
         $appt->sale_id=0;
         $lead->sale_id=0;
        }
      };
      
      if(($input['result']=="RB-TF")||($input['result']=="RB-OF")){
        $lead->status = "RB";
        if(!empty($input['booktimepicker'])){
          $ap = New Appointment;
          $ap->app_date = $input['appdate'];
          $ap->app_time = date('H:i',strtotime($input['booktimepicker']));
          $ap->lead_id = $leadid;
          $ap->booked_at = date("Y-m-d H:i:s");
          $ap->booked_by = $appt->booked_by;//Auth::user()->firstname." ".Auth::user()->lastname;
          $ap->booker_id = $appt->booker_id;//Auth::user()->id;
          $ap->status = "APP";
          $ap->save();
          $lead->bump_count = $lead->bump_count+1;
          $lead->status="APP";
          $lead->result="";
          $lead->app_date = $input['appdate'];
          $lead->app_time = date('H:i',strtotime($input['booktimepicker']));
        } 
      }

      if($input['result']=="CONF"){
          $appt->confirmed = 1;
      }

      

      if(($input['result']=="CONF")||($input['result']=="NA")){
        $lead->status = "APP";

        $call = New Call;
        $call->lead_id = $lead->id;
        $call->leadtype = $lead->leadtype;
        $call->caller_id = Auth::user()->id;
        $call->caller_name = Auth::user()->firstname;
        $call->phone_no = $lead->cust_num;
        $call->result = $newstat;
        $call->created_at = date('Y-m-d H:i:s');
        $call->save();
      }

      $appt->save();
      $lead->save();

      $alert = Alert::find(5);
      $alert->message = "APPOINTMENT UPDATE : ".$appt->lead->cust_name."'s Appointment has changed from ".$oldstat." to ".$newstat." by ".Auth::user()->firstname." ".Auth::user()->lastname."";
      $alert->color = "warning";
      $alert->icon = "cus-clipboard-sign";
      $alert->save();

    return Redirect::back();
  }

  //*******DID NOT SELL***********//
  public function action_dns($id){
    $t = explode("-",$id);
    $input=Input::get();
    $app = Appointment::find($t[0]);
    $type = $t[1];

     $user = User::find($app->rep_id);
      if($user){
      	if($type=="DNS"){
      		GameHistory::writeHistory(1,$app,"DNS",$user->id);
      		GameHistory::writeHistory(1,$app,"PUTON",$app->booker_id);
      	}
      
        GiftTracker::writeHistory($app,$type);
      }


    if(!empty($app)){
      $app->status=$type;
      $s = Sale::find($app->sale_id);
      if($s){
        $app->sale_id=0;
        if(Sale::removeItems($s)){
          $s->delete();
        };
      }
      $app->save();

      $l = Lead::find($app->lead_id);
        if(!empty($l)){
          $l->sale_id=0;
          $l->result=$type;
          $l->status="APP";
          $l->save();
        }
      
    }
    if(isset($input['request'])){
       return Response::json("success");
    } else {
       return Redirect::back();
    }
  }

  //***EDIT APPOINTMENT***//
  public function action_edit(){
    $input = Input::get();
    $x = explode("|", $input['id']);
    $appt = Appointment::find($x[1]);
    $lead = Lead::find($appt->lead_id);


    if(($x[0]=="in")||($x[0]=="out")){
      if(empty($input['value'])){
        $input['value'] = '00:00:00';
      } else {
         $temp = explode(":",$input['value']);
       if($temp[0]==0){
         $temp[0] = $temp[1];
       }
       if($temp[0]<10){
          $input['value'] = $input['value']." pm";
          $input['value'] = date('H:i',strtotime($input['value']));
       } else {
         $input['value'] = date('h:i',strtotime($input['value']));
       }
      }
    } 

    if($x[0]=="rep_id"){
       $id = explode("|",$input['value']);
      $user = User::find($id[1]);
      $sale = Sale::find($appt->sale_id);
      if(!empty($user)){
        $name = $user->firstname." ".$user->lastname;
        $appt->rep_id = $user->id;
        $appt->rep_name = $name;
        if($lead){
          $lead->rep = $user->id;
          $lead->rep_name = $name;
          $lead->save();
        }
        if($sale){
          $sale->sold_by = $name;
          $sale->user_id = $user->id;
          $sale->save();
        }
        $appt->save();
        return strtoupper($name);
      }
    }

    if($x[0]=="booked_by"){
      $id = explode("|",$input['value']);
      $user = User::find($id[1]);

      if(!empty($user)){
        $name = $user->firstname." ".$user->lastname;
        $appt->booked_by = $name;
        $appt->booker_id = $id[1];
        $appt->save();
        if($lead){
          $lead->booker_id = $input['value'];
          $lead->booker_name = $name;
          $lead->save();
        }
        return $name;
      }
    }

    $appt->$x[0] = $input['value'];
    if($x[0]=="out"){
      if(($appt->in!='00:00:00')&&($appt->out!='00:00:00')){
          $t =(strtotime($appt->out)-strtotime($appt->in))/3600;
          $appt->diff = $t;
      }
    }
    $test = $appt->save();
    if($test){
      if(($x[0]=="in")||($x[0]=="out")){
        if($input['value']=="00:00:00"){
          return "...";
        } else {
          return date('h:i',strtotime($input['value']));
        }
      } else {
        return $input['value'];}
    } else {}
  }

  //***DELETE APPOINTMENT***//
  public function action_delete($id){
    $app = Appointment::find($id);
    if($app){
      if($app->status=="SOLD"){
        $sale = Sale::find($app->sale_id);
        if($sale){
          $sale = Sale::removeItems($sale);
          $sale->delete();
        }
      }

      $app->delete();
      return Redirect::back();
    } else {
      return Redirect::back();
    }
  }
  //***************************


  //********************************************************************//
  //***********NEEDED APPOINTMENTS*************//

  public function action_needed($type=null){
    if($type){
      $needed = Appointment::neededAppts("city",true);
      $neededarea = Appointment::neededAppts("area",true);

    return View::make('plugins.needed-data')
    ->with('areas',$neededarea['cities'])
    ->with('neededarea',$neededarea['needed'])
    ->with('cities',$needed['cities'])
    ->with('needed',$needed['needed'])
    ->with('slots',$needed['slots']);
    } else {
      $needed = Appointment::neededAppts("city",false);
      $neededarea = Appointment::neededAppts("area",false);

      return View::make('appointment.needed')
      ->with('areas',$neededarea['cities'])
      ->with('neededarea',$neededarea['needed'])
      ->with('cities',$needed['cities'])
      ->with('needed',$needed['needed'])
      ->with('slots',$needed['slots']);
    }
  }

  public function action_needededit(){
    $input = Input::get();
    $fields = explode("|",$input['id']);
    $slot = DB::query("UPDATE appointment_slots SET ".$fields[1]."='".$input['value']."' WHERE id='".$fields[0]."'");
    return $input['value'];
  }



  //**********EXCEL BACKUP*********//
  //**********EXCEL BACKUP*********//
  public function action_backup(){
    $input = Input::get();
    $set = Setting::find(1);
    if(isset($input['appdate'])){
      $date = date('Y-m-d', strtotime(Input::get('appdate')));
    } else {
       $date = date('Y-m-d');
    }
    $title = "AppointmentBoardBackup-(".$date.")";
    // Get list of todays appointments
    $todayappts = Appointment::where("app_date","=",$date)
    ->order_by("app_time","ASC")
    ->get();
    // Get list of users
    $reps = User::activeUsers('salesrep');
    $door = User::activeUsers('doorrep');
    $bookers = User::activeUsers('agent');
   
    $texts = User::where('user_type','=','other')
    ->order_by('firstname','asc')
    ->get();

    $i=1;
    require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';
    $objPHPexcel = New PHPExcel();
    $objWorksheet = $objPHPexcel->getActiveSheet();
    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );

    $objWorksheet->getCell('A'.$i)->setValue('TIME');
    $objWorksheet->getCell('B'.$i)->setValue('NAME');
    $objWorksheet->getCell('C'.$i)->setValue('NUMBER');
    $objWorksheet->getCell('D'.$i)->setValue('ADDRESS');
    $objWorksheet->getCell('E'.$i)->setValue('BOOKED BY');
    $objWorksheet->getCell('F'.$i)->setValue('BOOKED AT');
    $objWorksheet->getCell('G'.$i)->setValue('GIFT');
    $objWorksheet->getCell('H'.$i)->setValue('IN');
    $objWorksheet->getCell('I'.$i)->setValue('OUT');
    $objWorksheet->getCell('J'.$i)->setValue('DEALER');
    $objWorksheet->getCell('K'.$i)->setValue('STATUS');
    if($set->show_lead_info==1){
      $objWorksheet->getCell('L'.$i)->setValue('OCCUPATION');
      $objWorksheet->getCell('M'.$i)->setValue('MARITAL');
      $objWorksheet->getCell('N'.$i)->setValue('SMOKE');
      $objWorksheet->getCell('O'.$i)->setValue('PETS');
      $objWorksheet->getCell('P'.$i)->setValue('ASTHMA');
      $objWorksheet->getCell('Q'.$i)->setValue('LEADTYPE');
    }


    foreach($todayappts as $val){
      $i++;      
      $name = explode(" ",$val->booked_by);
      if($val->in=='00:00:00'){
        $val->in = "";
      }
      if($val->out=='00:00:00'){
        $val->out = "";
      }
      if($val->status=="APP"){
        $val->status="";
      }
      $cust = (strlen($val->lead->cust_name) > 20) ? substr($val->lead->cust_name,0,20).'...' :$val->lead->cust_name;
      $objWorksheet->getCell('A'.$i)->setValue(date('h:i a',strtotime($val->app_time)));
      $objWorksheet->getCell('B'.$i)->setValue($cust);
      $objWorksheet->getCell('C'.$i)->setValue($val->lead->cust_num);
      $objWorksheet->getCell('D'.$i)->setValue($val->lead->address);
      $objWorksheet->getCell('E'.$i)->setValue($name[0]);
      $objWorksheet->getCell('F'.$i)->setValue(date('M-d h:i a',strtotime($val->booked_at)));
      $objWorksheet->getCell('G'.$i)->setValue($val->lead->gift);
      $objWorksheet->getCell('H'.$i)->setValue($val->in);
      $objWorksheet->getCell('I'.$i)->setValue($val->out);
      $objWorksheet->getCell('J'.$i)->setValue($val->rep_name);
      $objWorksheet->getCell('K'.$i)->setValue($val->status);
      if($set->show_lead_info==1){
        if($val->lead->leadtype=="other"){
            $leadtype="Scratch Card";
          } else if($val->lead->leadtype=="paper"){
            $leadtype="XLS Upload";
          } else if($val->lead->leadtype=="secondtier"){
            $leadtype="Second Tier";
          } else  {
            $leadtype=ucfirst(strtolower($val->lead->leadtype));
        }
        $objWorksheet->getCell('L'.$i)->setValue($val->lead->job);
        $objWorksheet->getCell('M'.$i)->setValue(strtoupper($val->lead->married));
        $objWorksheet->getCell('N'.$i)->setValue($val->lead->smoke);
        $objWorksheet->getCell('O'.$i)->setValue($val->lead->pets);
        $objWorksheet->getCell('P'.$i)->setValue($val->lead->asthma);
        $objWorksheet->getCell('Q'.$i)->setValue($leadtype);
      }
    };
    $objWorksheet->getColumnDimension('E')->setOutlineLevel(1);
    foreach (range('A', $objWorksheet->getHighestDataColumn()) as $col) {
        $objWorksheet->getColumnDimension($col)->setAutoSize(true);
    } 
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
    // We'll be outputting an excel file
    header('Content-type: application/vnd.ms-excel');

    // It will be called file.xls
    header('Content-Disposition: attachment; filename="'.$title.'.xls"');
    $objWriter->save('php://output');
  }
   


}