<?php
class Lead_Controller extends Base_Controller
{
	    public function __construct(){
        	parent::__construct();
        	$this->filter('before','auth');
    	}

    	//MAIN LEAD PAGE
    	public function action_index()
    	{   
    	  if(Auth::user()->user_type=="agent" && Auth::user()->assign_leads!=1){return Redirect::to('dashboard');}
        if(Auth::user()->user_type=="doorrep"){return Redirect::to('dashboard');}
        	$st = Setting::find(1);

          //Check for renters, and delete.  Or un-delete depending on user settings
          if($st->no_renters==1){
            $rent_leads = DB::query("SELECT COUNT(*) as cnt FROM leads WHERE rentown='R' AND status='NEW' AND sale_id=0 AND leadtype!='rebook' AND leadtype!='door' AND original_leadtype='paper'");
            $rent_deleted = $rent_leads[0]->cnt;
            DB::query("UPDATE leads SET status='INVALID' WHERE rentown='R' AND status='NEW'  AND sale_id=0  AND leadtype!='rebook' AND leadtype!='door' AND original_leadtype='paper'");
            $rent_undeleted = 0;
          } else {
            $rent_leads2 = DB::query("SELECT COUNT(*) as cnt FROM leads WHERE rentown='R' AND  status='INVALID'  AND sale_id=0 AND leadtype!='rebook' AND leadtype!='door' AND original_leadtype='paper'");
            $rent_undeleted = $rent_leads2[0]->cnt;
            DB::query("UPDATE leads SET status='NEW' WHERE rentown='R' AND status='INVALID'  AND sale_id=0 AND leadtype!='rebook' AND leadtype!='door' AND original_leadtype='paper'");
            $rent_deleted = 0;
          }

          // Check if user has Deleted leads checked.  If so remove leads after
          // X amount of calls
        	if($st->delete_leads==1){
        		$del = $st->delete_count;
            if($st->delete_rebooks==1){
              $leads = DB::query("SELECT COUNT(*) as cnt FROM leads WHERE assign_count>=".$del." AND (status='NEW'  AND sale_id=0 AND leadtype!='survey')");
              $leads2 = DB::query("SELECT COUNT(*) as cnt FROM leads WHERE assign_count<".$del." AND (status='DELETED'  AND sale_id=0 AND leadtype!='survey')");
              DB::query("UPDATE leads SET status='DELETED' WHERE assign_count>=".$del." AND (status='NEW'  AND sale_id=0 AND leadtype!='survey') ");
              DB::query("UPDATE leads SET status='NEW' WHERE assign_count<".$del." AND (status='DELETED'  AND sale_id=0 AND leadtype!='survey') ");
            } else {
              $leads = DB::query("SELECT COUNT(*) as cnt FROM leads WHERE assign_count>=".$del." AND (status='NEW' AND leadtype!='rebook'  AND sale_id=0 AND leadtype!='survey')");
              $leads2 = DB::query("SELECT COUNT(*) as cnt FROM leads WHERE assign_count<".$del." AND (status='DELETED' AND leadtype!='rebook'  AND sale_id=0 AND leadtype!='survey')");
              DB::query("UPDATE leads SET status='DELETED' WHERE assign_count>=".$del." AND (status='NEW' AND leadtype!='rebook'  AND sale_id=0 AND leadtype!='survey') ");
              DB::query("UPDATE leads SET status='NEW' WHERE assign_count<".$del." AND (status='DELETED' AND leadtype!='rebook'  AND sale_id=0 AND leadtype!='survey') ");
            }
            
        		$deleted = $leads[0]->cnt;
        		$undeleted = $leads2[0]->cnt;
        		
        	} else {
        	$deleted = 0;
        	$undeleted = 0;}

          // Check if user wants to delete survey leads as well
          if($st->delete_survey_leads==1){
              $delsurvey = $st->survey_delete_count;
              $sur_leads = DB::query("SELECT COUNT(*) as cnt FROM leads WHERE assign_count>=".$delsurvey." AND (status='NEW' AND sale_id=0 AND leadtype='survey')");
              $sur_leads2 = DB::query("SELECT COUNT(*) as cnt FROM leads WHERE assign_count<".$delsurvey." AND (status='DELETED' AND sale_id=0 AND leadtype='survey')");
              DB::query("UPDATE leads SET status='DELETED' WHERE assign_count>=".$delsurvey." AND (status='NEW'  AND sale_id=0 AND leadtype='survey') ");
              DB::query("UPDATE leads SET status='NEW' WHERE assign_count<".$delsurvey." AND (status='DELETED'  AND sale_id=0 AND leadtype='survey') ");
              $sur_deleted = $sur_leads[0]->cnt;
              $sur_undeleted = $sur_leads2[0]->cnt;
            } else {
              $sur_deleted = 0;
              $sur_undeleted = 0;
          }
            
        	
        	if(Input::all()){
        		$date = date('Y-m-d', strtotime(Input::get('date')));
        		$date2 = date('Y-m-d 00:00:00', strtotime(Input::get('date')));
      	} else {
      		$date = date('Y-m-d');$date2 = date('Y-m-d 00:00:00');
      	}
      	$date = date('Y-m-d');
      	
       	$citycount_cities = DB::query("SELECT city, assign_count, SUM(status = 'NEW' AND original_leadtype!='other' AND original_leadtype!='survey' AND leadtype!='survey' ) avail,
        	SUM(status = 'INACTIVE' AND leadtype='paper') paperunreleased, 
        	SUM(status = 'INACTIVE' AND leadtype='secondtier') secondtierunreleased, 
        	SUM(status = 'INACTIVE' AND leadtype='ballot') ballotunreleased, 
        	SUM(status = 'INACTIVE' AND leadtype='homeshow') homeshowunreleased,
        	SUM(status='INACTIVE' AND leadtype='door') doorunreleased, 
        	SUM(status='NH') nothomes, SUM(status='NH' AND leadtype='rebook') rebooks_tosort,
        	SUM(status='NH' AND leadtype='paper') paper_tosort,SUM(status='NH' AND leadtype='homeshow') homeshow_tosort,
        	SUM(status='NH' AND leadtype='door') door_tosort,SUM(status='NH' AND leadtype='ballot') ballot_tosort,
        	SUM(status='NH' AND leadtype='secondtier') secondtier_tosort,SUM(status='NH' AND leadtype='survey') survey_tosort,
       	SUM(status = 'ASSIGNED') assigned, SUM(original_leadtype='survey' AND leadtype!='rebook') totalsurvey, SUM(original_leadtype='paper' AND leadtype!='rebook') totalpaper,
       	SUM(original_leadtype='door' AND leadtype!='rebook') totaldoor, SUM(original_leadtype!='door' AND original_leadtype!='paper' AND original_leadtype!='survey') totalother, 
       	SUM(leadtype='survey' AND status='NEW' AND sale_id=0) survey, 
        	SUM(leadtype = 'secondtier' AND status='NEW' AND sale_id=0) secondtier, 
        	SUM(leadtype = 'paper' AND status='NEW' AND sale_id=0) paper,
        	SUM(leadtype = 'door' AND status='NEW' AND sale_id=0 ) door,
        	SUM(leadtype = 'door' AND status='NEW' AND sale_id=0 AND assign_count=0 ) uncalled_door,
        	SUM(leadtype = 'paper' AND status='NEW' AND sale_id=0 AND assign_count=0 ) uncalled_paper,
        	SUM(leadtype = 'secondtier' AND status='NEW' AND sale_id=0 AND assign_count=0 ) uncalled_secondtier,
        	MIN(case when leadtype = 'paper' AND status = 'NEW' AND sale_id=0 then assign_count end) as ac_paper,
        	MIN(case when leadtype = 'door' AND status = 'NEW' AND sale_id=0 then assign_count end) as ac_door,
        	MIN(case when leadtype = 'secondtier' AND status = 'NEW' AND sale_id=0 then assign_count end) as ac_secondtier,
       	SUM(assign_date = DATE('".date('Y-m-d')."')) assign_sort, 
        	SUM(status='DELETED' AND leadtype!='survey') deleted,
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

		$citycount_areas = DB::query("SELECT city,area_id, SUM(status = 'NEW' AND original_leadtype!='other' AND original_leadtype!='survey' AND leadtype!='survey' ) avail,
        	SUM(status = 'INACTIVE' AND leadtype='paper') paperunreleased, 
        	SUM(status = 'INACTIVE' AND leadtype='secondtier') secondtierunreleased, 
        	SUM(status = 'INACTIVE' AND leadtype='ballot') ballotunreleased, 
        	SUM(status = 'INACTIVE' AND leadtype='homeshow') homeshowunreleased, 
        	SUM(status='INACTIVE' AND leadtype='door') doorunreleased,
        	SUM(status='NH') nothomes, 
       	SUM(status = 'ASSIGNED') assigned, SUM(original_leadtype='survey') totalsurvey, SUM(original_leadtype='paper') totalpaper,
       	SUM(original_leadtype='door') totaldoor, SUM(original_leadtype!='door' AND original_leadtype!='paper' AND original_leadtype!='survey') totalother, 
       	SUM(leadtype='survey' AND status='NEW' AND sale_id=0) survey, 
        SUM(leadtype = 'secondtier' AND status='NEW' AND sale_id=0) secondtier, 
        SUM(leadtype = 'paper' AND status='NEW' AND sale_id=0) paper,
        SUM(leadtype = 'door' AND status='NEW' AND sale_id=0 ) door,
        SUM(leadtype = 'door' AND status='NEW' AND sale_id=0 AND assign_count=0 ) uncalled_door,
        SUM(leadtype = 'paper' AND status='NEW' AND sale_id=0 AND assign_count=0 ) uncalled_paper,
        SUM(leadtype = 'secondtier' AND status='NEW' AND sale_id=0 AND assign_count=0 ) uncalled_secondtier,
        MIN(case when leadtype = 'paper' AND status = 'NEW' AND sale_id=0 then assign_count end) as ac_paper,
        MIN(case when leadtype = 'door' AND status = 'NEW' AND sale_id=0 then assign_count end) as ac_door,
        MIN(case when leadtype = 'secondtier' AND status = 'NEW' AND sale_id=0 then assign_count end) as ac_secondtier,
       	SUM(assign_date = DATE('".date('Y-m-d')."')) assign_sort, 
        SUM(status='DELETED' AND leadtype!='survey') deleted,
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
       	FROM leads WHERE area_id!=0 GROUP BY area_id");

		$assigned_today = DB::query("SELECT * FROM leads WHERE assign_date=DATE('".date('Y-m-d')."')");
       	$bookper = DB::query("SELECT *, IF(apps + demos, 100*(apps+demos)/total, NULL) AS bookper 
       	FROM (SELECT COUNT(id) as total, leadtype,SUM(result = 'SOLD' OR result='DNS') demos, 
       	SUM(status = 'APP' OR status='NA' OR status='DISP' OR status='CONF') apps FROM leads GROUP BY leadtype) as subquery ORDER BY bookper DESC ");
       
       	$arr=array();
       		foreach($bookper as $val){
       			$arr[$val->leadtype] = $val;
       		}

       	$bookers = User::where('user_type','=','agent')->where('type','=','employee')->where('level','!=',99)->order_by('firstname','ASC')->get();
       	$res = User::where('user_type','=','researcher')->where('type','=','employee')->where('level','!=',99)->order_by('firstname','ASC')->get();
       	$activecities = City::where('status','=','active')->where('type','=','city')->get();
       	$activeareas = City::where('status','=','active')->where('type','=','area')->get();
       	$arrcit=array();$arrarea=array();
       	foreach($activecities as $val){
       		$arrcit[] = str_replace(array(",","-"," ","  ","."),"-",strtolower($val->cityname));
       	}
       	foreach($activeareas as $val){
       		$arrarea[] = str_replace(array(",","-"," ","  ","."),"-",strtolower($val->cityname));
       	}
      	$lastsort = Alert::find(7);

      	return View::make('leads.index')
      	->with('active','leads')
      	->with('cityleads', $citycount_cities)
      	->with('arealeads',$citycount_areas)
      	->with('lastsort',$lastsort)
      	->with('bookper',$arr)
      	->with('assigned_today',$assigned_today)
      	->with('activecities',$arrcit)
      	->with('activeareas',$arrarea)
      	->with('bookers',$bookers)
      	->with('researchers',$res)
      	->with('date',$date)
      	->with('res',$res)
      	->with('deleted',$deleted)
      	->with('undeleted',$undeleted)
        	->with('sur_deleted',$sur_deleted)
        	->with('sur_undeleted',$sur_undeleted)
        	->with('rent_deleted',$rent_deleted)
        	->with('rent_undeleted',$rent_undeleted);
   	}



    //************AJAX LOADED MANAGER FUNCTIONS********************/

    /***SCRATCH CARD MANAGER STUFF*****/
    public function action_scratch(){
      $scratch = Scratch::get();
      $cities = City::where('status','=','active')->get();
      return View::make('plugins.scratchcards')
        ->with('cities', $cities)
        ->with('scratch',$scratch);
    }

    public function action_scratchstats(){

        $input = Input::get();
        if(!empty($input)){
          if(isset($input['scratch_id'])){
            $batch = Scratch::find($input['scratch_id']);
            if($batch){
              $date = $batch->attributes['date_sent'];
              $city = $batch->attributes['city'];

              $stats = DB::query("SELECT COUNT(*) as cnt, SUM(status='APP' OR status='SOLD') app, 
                SUM(status='SOLD' OR result='SOLD') sold, SUM(status='APP' AND result='DNS') dns, 
                SUM(status='NI') ni, SUM(status='Recall') recall
                FROM leads WHERE entry_date>=DATE('".$date."') AND city='".$city."' AND original_leadtype='other' ");

              /*$leads = Lead::where('city','=',$city)
              ->where('entry_date','>=',$date)
              ->where('original_leadtype','=','other')
              ->get();*/
              $leads=array();

              return Response::json(array("leads"=>$leads,"stats"=>$stats[0]));
            }
          } else {
            return Response::json("failed");
          }
          
        } else {
          return Response::json("failed");
        }
    }

    public function action_addscratchbatch(){
        $input = Input::get();
        $scratch = New Scratch;
        $scratch->date_sent = date('Y-m-d',strtotime($input['scratch_date']));
        $scratch->qty = $input['scratch_qty'];
        $scratch->city = $input['scratch_city'];
        $scratch->cost = intval($input['scratch_qty'])*0.21;

        $expense = New Expense;
        $expense->cityname = $input['scratch_city'];
        $expense->date_paid = date('Y-m-d',strtotime($input['scratch_date']));
        $expense->expense_amount = intval($input['scratch_qty'])*0.21;
        $expense->expense_tag = "Scratch Card Mailout to ".$input['scratch_city'];
        $expense->category="Scratch Cards";
        $expense->user_id = Auth::user()->id;
        $expense->status="paid";
        $expense->save();

        if($scratch->save()){
          return json_encode($scratch->attributes);
        };
    }

    public function action_delscratchbatch($id){
      if($id!=null){
        $batch = Scratch::find($id);
        if($batch->delete()){
          return true;
        };
      } else {
        return false;
      }
    }
    /***END SCRATCH CARD*****/


    /*****EVENT MANGER STUFF*****/
    public function action_events(){
      $events = Eventshow::get();
      $cities = City::where('status','=','active')->get();
      return View::make('plugins.events')->with('events',$events)->with('cities',$cities);
    }


    public function action_eventstats(){
      $input = Input::get();
      $event = Eventshow::find($input['event_id']);
      if($event){
        $stats = $event->stats;
        return Response::json($stats);
      } else {
        return Response::json("failed");
      }
      
    }
    public function action_attachleads(){
    	$input = Input::get();
    	$cnt=0;
    	if(!empty($input) && isset($input['event_id'])){
    		if(!empty($input['leads'])){
    			foreach($input['leads'] as $lead){
    				$theLead = Lead::find($lead);
    				if($theLead){
    					$theLead->event_id = $input['event_id'];
    					if($theLead->save()){
    						$cnt++;
    					};
    				}
    			}
    			return Response::json(array("cnt"=>$cnt,"status"=>"success"));
    		}
    	}
    	return Response::json(array("cnt"=>$cnt,"status"=>"failed"));
    }
    public function action_attacheventleads($id){
    	$event=array();
    	if($id){
    		$event = Eventshow::find($id);
    		if($event){
    			$leads = $event->cityLeads();
    		} else {
    			$leads = Lead::where('original_leadtype','=','homeshow')->where('event_id','=',0)->get();
    		}
    	} else {
    		$leads = Lead::where('original_leadtype','=','homeshow')->get();
    	}

    	return View::make('plugins.attachleadstoevent')->with('leads',$leads)->with('event',$event);
    }

    public function action_addevent(){
      $input = Input::get();
      $check = Eventshow::where('event_name','=',$input['event_name'])->first();
      if($check){
        return Response::json("alreadyexists");
      } else {
        $event = New Eventshow;
        foreach($input as $k=>$v){
          if($k!="_"){
            $val = str_replace("$","",$v);
            $event->$k = $val;
          }
        }
        $event->event_type="homeshow";
        $event->save();
        return Response::json($event->attributes);
      }
    }

    public function action_delevent($id){
      $cnt=0;
      $event = Eventshow::find($id);
      if($event){
        $leads = $event->leads;
        if($leads){
          $cnt = $event->leadCount();
          DB::query("UPDATE leads SET event_id = 0 WHERE original_leadtype='homeshow' AND event_id = '".$event->id."'");
        }
        $event->delete();
        return Response::json(array("count"=>$cnt,"result"=>"success"));
      }
      return Response::json(array("count"=>0,"result"=>"failed"));
    }
    /****END EVENTS*************/



    /*****DUPLICATE FINDER AND REMOVER************/

    public function action_duplicates($type=null){

    	$input = Input::get();
    	if(isset($input['skip'])){
    		$skip = $input['skip'];
    	} else {
    		$skip = 0;
    	}
    	if(isset($input['city']) && $input['city']!="all"){
    		$cityQuery = "WHERE city = '".$input['city']."'";
    		$city = $input['city'];
    	} else {
    		$cityQuery = ""; 
    		$city = "all";
    	}


      if($type==null){
      	$cnt = DB::query("SELECT id FROM leads $cityQuery GROUP BY cust_num having count(*) >= 2  ");
      	$cities = DB::query("SELECT DISTINCT city FROM leads GROUP BY cust_num having count(*) >= 2  ");
        $t = DB::query("SELECT id, cust_num, cust_name,researcher_name, city, address, original_leadtype,entry_date,birth_date,status FROM leads $cityQuery GROUP BY cust_num having count(*) >= 2 ORDER BY id DESC LIMIT 15 OFFSET ".$skip."");
        return View::make('utils.duplicates2')->with('leads',$t)->with('page',count($cnt))->with('skip',$skip)->with('cities',$cities)->with('city',$city);
      } else {
        $quarantined = Lead::where('assign_count','=',99999)->where('status','=','DELETED')->order_by('entry_date','DESC')->get();
        return View::make('utils.quarantined')->with('quarantined',$quarantined);
      }
    }
    /********END DUPLICATES********************/

   	public function action_showreleased(){
   		$input = Input::get();
   		if(isset($input['city'])){
   		$city = $input['city'];
   		$released = DB::query("SELECT release_date, 
   		SUM(original_leadtype='door') doorreleased,
       	SUM(original_leadtype='paper') paperreleased,
        SUM(original_leadtype='survey') surveyreleased,
       	SUM((original_leadtype='paper' OR original_leadtype='door')  AND (status='NEW' OR status='NH')) uncontacted,
       	SUM((original_leadtype='paper' OR original_leadtype='door') AND status!='NEW' AND status!='NH') contacted,
       	SUM((original_leadtype='paper' OR original_leadtype='door') AND status='DELETED') toomany
       	FROM leads WHERE release_date!='0000-00-00' AND release_date>='".date('Y-m-d',strtotime('-7 days'))."' AND city='".$city."' GROUP BY release_date");

   		return View::make('plugins.showreleased')
   		->with('released',$released)
   		->with('city',$city);
   		} else {
   			//print_r($input);
   		}
   	}

   	public function action_releasesingle($id){
   		$input = Input::get();
   		$l = Lead::find($id);
   		if($l){
   			if($l->status=="INACTIVE"){
   				$l->status="NEW";
   				$l->release_date = date('Y-m-d');
   				if($l->save()){
   					return Response::json($id);
   				};
   			}
   		}
   	}

   	public function action_assignsingle(){
   		$input = Input::get();
   		$id = explode("|",$input['value']);
   		$l = Lead::find($input['id']);
   		$u = User::find($id[1]);
   		if($u){
   			if($l){
   				$l->assign_date=date('Y-m-d');
   				$l->assign_time=date('H:i:s');
   				$l->booker_name=$u->firstname." ".$u->lastname;
   				$l->booker_id=$u->id;
   				$l->status="ASSIGNED";
   				$l->assign_count = intval($l->assign_count)+1;
   				$l->save();

   				return Response::json($l->id);
   			}
   		}
   	}

   	public function action_reactivate($id){
   		$l = Lead::find($id);
   		if($l){
   			if($l->status=="DELETED"){
   				$l->status="NEW";
   				$l->assign_count = 0;
          $l->release_date = date('Y-m-d');
          $l->was_deleted=1;
   				if($l->save()){
   					return Response::json($id);
   				};
   			}
   		}
   	}

   	public function action_getassigned(){
   		$assigned = Lead::where('assign_date', '=', date('Y-m-d'))->where('booker_id','!=',0)->order_by('entry_date','ASC')->order_by('call_date','DESC')->get();
   
        	$array = array();
        	if(!empty($assigned)){
        		foreach($assigned as $val){
            		array_push($array, $val->booker_id);
        		}
        	}

       	$assname = array_unique($array);

       	 return View::make('plugins.assignedleads')
       	 ->with('assigned',$assigned)
       	 ->with('date',date('Y-m-d'))
       	 ->with('assname',$assname);
   	}

   	public function action_getassignedinfo(){
   		$input = Input::get();
   		if(!empty($input)){
   			$cnt=0;
   			$assigned = DB::query("SELECT COUNT(*) as cnt, booker_name, booker_id, leadtype, original_leadtype,assign_time,assign_date FROM leads WHERE status = 'ASSIGNED' AND city ='".$input['city']."' GROUP BY booker_id");
   			if(!empty($assigned)){
   				foreach($assigned as $v){
   					$cnt=$cnt+$v->cnt;
   				}
   			}

   			return View::make('plugins.getassignedinfo')
   			->with('assigned',$assigned)
   			->with('total',$cnt)
   			->with('city',$input['city']);
   		
   		} else {
   			echo "failed";
   		}
   		


   	}

    public function action_getreferral($id){
      $app=array();
      if($id==null){
        return Response::json("failed");
      } else {
        $lead = Lead::find($id);
        if($lead){
          $ref = $lead->referrer;
            if(!empty($ref)){
              $app = Appointment::where('lead_id','=',$ref->id)->order_by('app_date','DESC')->take(1)->get(array('callout_notes'));
              $app = $app[0]->attributes;

              if($ref->sale_id!=0){
                $sale = Sale::find($ref->sale_id);
                $sale->date = date('M-d',strtotime($sale->date));
                $sale->typeofsale = strtoupper($sale->typeofsale);
                $sale = $sale->attributes;
              } else {
                $sale=array();
              }
              return Response::json(array("lead"=>$ref->attributes,"sale"=>$sale,"app"=>$app));
          } else {
              return Response::json("failed");
          }
        } else {
          return Response::json("failed");
        }
      }
    }

   	public function action_bookprocess($id){
   		$lead = Lead::find($id);
        	$thescripts = Script::getScripts($lead);

   		return View::make('plugins.bookprocess')
   		->with('lead',$lead)
   		->with('script',$thescripts);
   	}


    	//LEAD SEARCH FUNCTION
	public function action_search(){
		$input = Input::get();
      	$skip = $input['skip'];
      	$take = $input['take'];
      	if(empty($skip)){$skip=0;}
      	if(!empty($take)){$take=10;}
      	$search = $input['searchleads'];
      	$term = $search;

        	if(is_numeric($search)){
        		$sale = Sale::where('id','=',$search)->get();
        		$salecount = count($sale);
           		if(strlen($search)==10){
            		$first = substr($search,0,3);
            		$mid = substr($search,3,3);
            		$last = substr($search,6,7);
            		$search = $first."-".$mid."-".$last;
           		}
        	} else {
        		$salecount = Sale::where("cust_name","LIKE","%".$search."%")
        		->or_where("typeofsale","LIKE","%".$search."%")
        		->or_where("payment","LIKE","%".$search."%")
        		->or_where("sold_by","LIKE","%".$search."%")
        		->order_by('date')
        		->count();
        		$sale = Sale::where("cust_name","LIKE","%".$search."%")
        		->or_where("typeofsale","LIKE","%".$search."%")
        		->or_where("payment","LIKE","%".$search."%")
        		->or_where("sold_by","LIKE","%".$search."%")
        		->order_by('date')
        		->skip($skip)
        		->take($take)->get();
        	}

        	$databuttons = "data-search='".$term."' data-script='search'";
        	$cnt = Lead::where("address","LIKE","%".$search."%")
        	->or_where("cust_name","LIKE","%".$search."%")
        	->or_where("cust_num","LIKE","%".$search."%")
        	->or_where("city","LIKE","%".$search."%")
        	->or_where("booker_name","LIKE","%".$search."%")
        	->or_where("status","LIKE","%".$search."%")
        	->or_where("result","LIKE","%".$search."%")
        	->or_where("rep_name","=",$search)
        	->or_where("leadtype","=",$search)
        	->or_where("original_leadtype","=",$search)
        	->order_by("entry_date","DESC")
        	->count();
        	$results = Lead::where("address","LIKE","%".$search."%")
        	->or_where("cust_name","LIKE","%".$search."%")
        	->or_where("cust_num","LIKE","%".$search."%")
        	->or_where("city","LIKE","%".$search."%")
        	->or_where("booker_name","LIKE","%".$search."%")
        	->or_where("status","LIKE","%".$search."%")
        	->or_where("result","LIKE","%".$search."%")
        	->or_where("rep_name","=",$search)
        	->or_where("leadtype","=",$search)
        	->or_where("original_leadtype","=",$search)
        	->order_by("entry_date","DESC")
        	->skip($skip)
        	->take($take)
        	->get();
        	$ltitle = " for Search returned (<font style='color:#000;'>".$cnt." </font> Matches)";
        	$stitle = " for Search  returned (<font style='color:#000;'>".$salecount." </font> Matches)";
        	$pagination = $cnt/$take;
        	$page = intval($skip/$take);
        	
        	return View::make('plugins.searchleads')
        	->with('pagenum',$page)
      	->with('page',$pagination)
      	->with('cnt',$cnt)
      	->with('salecount',$salecount)
      	->with('sale',$sale)
      	->with('leads',$results)
      	->with('ltitle',$ltitle)
      	->with('stitle',$stitle)
      	->with('databuttons',$databuttons);
    	}

    	public function action_ajaxleadsearch(){
    		$input = Input::get();
      	$skip = 0;
      	$take = 10;
      	if(empty($skip)){$skip=0;}
      	if(!empty($take)){$take=10;}
      	$search = $input['searchterm'];
      	$term = $search;

        	if(is_numeric($search)){
           		if(strlen($search)==10){
            		$first = substr($search,0,3);
            		$mid = substr($search,3,3);
            		$last = substr($search,6,7);
            		$search = $first."-".$mid."-".$last;
           		}
        	} 

        
        	$results = DB::query("SELECT cust_name, cust_num, id, address, status FROM leads WHERE (address LIKE '%".$search."%' OR cust_name LIKE '%".$search."%' OR cust_num='%".$search."%') AND (status='SOLD' OR status='DNS' OR status='APP') ORDER BY cust_name LIMIT 10");


        	return Response::json($results);

    	}

		   
	public function action_doorentry(){
	
		$res = User::where('user_type','=','researcher')
			->or_where('user_type','=','agent')
			->order_by('lastname')
			->get(array('id','lastname','firstname'));

    		$cities = DB::table('cities')
    	 		->where('status','=','active')
    	   		->order_by('cityname')
    	   		->get();
		
		return View::make('leads.doorentry')
			->with('res', $res)
			->with('cities', $cities);
	}
	
	public function action_addnewdoor(){
	
	  	$input = Input::get();
      	Session::put('leadcity', $input['city']);
	  	Session::put('leaddate', $input['surveydate']);
	  
	  	$rules = array(
			'custname' => 'required',
        		'address' => 'required',
			'city' => 'required',
			'phone' => 'required',
			'married' => 'required',
			'surveydate'=>'required'
		);

		$validation = Validator::make($input, $rules);
           		if( $validation->fails() ) {
                		return Redirect::back()->with_input()->with_errors($validation);
            	}

		$date = date('Y-m-d', strtotime($input['surveydate']));
		$check = Lead::where('cust_num','=',$input['phone'])
			->where('original_leadtype','=','door')
			->count();

		$check2 = Lead::where('cust_num','=',$input['phone'])
			->where('original_leadtype','=','salesjournal')
			->count();

	
		if(($check)||($check2)){
			return Redirect::back()->with_input()->with_errors($validation);
		} else {
			$newlead = New Lead;
			$newlead->researcher_id = Auth::user()->id;
			$newlead->researcher_name = Auth::user()->firstname." ".Auth::user()->lastname;
			$newlead->entry_date = $date;
			$newlead->leadtype = "door";
    	    		$newlead->original_leadtype = "door";
    	    		$newlead->status = "INACTIVE";
			$newlead->cust_name = $input['custname'];
    	    		$newlead->spouse_name = $input['spousename'];
			$newlead->cust_num = $input['phone'];
			$newlead->address = $input['address'];
			$newlead->city = $input['city'];
			$newlead->married = $input['married'];
			$newlead->notes = $input['notes'];	
			$newlead->save();
	
			$this->getlatLong(urlencode($newlead->address),$newlead->id); 
			return Redirect::back()->with('city',$input['city']);
		}
	}

	public function action_addnewreferral(){
	
	  	$input = Input::get();
	  	if(isset($input['repcallout-referralnumber'])){
	  		$check = Lead::where('cust_num','=',$input['repcallout-referralnumber'])
			->count();
			if($check){
				return Response::json("alreadyexists");
			}
	  	}
      	
	  	$rules = array(
	  		'repcallout-referralID' => 'required',
			'repcallout-referralname' => 'required',
			'repcallout-referralcity' => 'required',
			'repcallout-referralnumber' => 'required'
		);

		$validation = Validator::make($input, $rules);
           		if( $validation->fails() ) {
                		return Response::json("failed");
            	}

		$date = date('Y-m-d');
		
	
		if($check){
			return Response::json("alreadyexists");
		} else {
			$ref = Lead::find($input['repcallout-referralID']);
			if($ref){
				if(!empty($ref->rep_id)){
					$res_id = $ref->rep_id;
					$res_name = $ref->rep;
				} else {
					$res_id = Auth::user()->id;
					$res_name = Auth::user()->fullName();
				}
				$ref_id = $ref->id;
			} else {
				$ref_id = 0;
			}
			$newlead = New Lead;
			$newlead->researcher_id = $res_id;
			$newlead->researcher_name = $res_name;
			$newlead->entry_date = $date;
			$newlead->birth_date = $date;
			$newlead->leadtype = "referral";
    	    		$newlead->original_leadtype = "referral";
    	    		$newlead->referral_id = $ref_id;
    	    		$newlead->status = "NEW";
			$newlead->cust_name = $input['repcallout-referralname'];
    	      	$newlead->cust_num = $input['repcallout-referralnumber'];
			$newlead->city = $input['repcallout-referralcity'];
			if($newlead->save()){
				return Response::json($newlead->attributes);
			} else {
				return Response::json("failed");
			};
		}
	}


	public function action_addnewscratch(){
		$settings = Setting::find(1);
	  	$input = Input::get();
	  	//Error checking first
	  	// Empty values first
	  	// Check for custoemr name
		if(empty($input['newscratch-custnum'])){
			return Response::json("nonum");
		}
		// Check for Valid City
		if(empty($input['newscratch-city'])){
			return Response::json("nocity");
		}
		// Check for name
		if(empty($input['newscratch-name'])){
			return Response::json("noname");
		}
    		// Check for duplicates
    		$leadtype = $input['newscratch-leadtype'];
		$num = str_replace(array("(",")","-","."),"",$input['newscratch-custnum']);
		if(strlen($num)<10){
			return Response::json("notvalidnum");
		}
		if(strlen($num)>=11){
			$num = substr($num, 1);
		}
		$num = substr($num,0,3)."-".substr($num,3,3)."-".substr($num,6,4);
		
		if($settings->duplicate_type=="allow_different_types"){
			$check = Lead::where('cust_num','=',$num)->where('original_leadtype','=',$leadtype)->count();
		} else if($settings->duplicate_type=="not_allowed"){
			$check = Lead::where('cust_num','=',$num)->count();
		} else if($settings->duplicate_type=="allow_all"){
			$check=false;
		} else {	
			$check=false;
		}
		if($check){
			return Response::json("alreadyexists");
		}

		$newlead = New Lead;
    if($leadtype=="finalnotice"){
      if(!empty($input['newscratch-researcher'])){
        $res = explode("|",$input['newscratch-researcher']);
        $newlead->researcher_id = $res[0];
        $user_name = $res[1];
        if(isset($res[2])){
          $user_name.=" ".$res[2];
        }
        $newlead->researcher_name = $user_name;
      } else {
        $newlead->researcher_id = Auth::user()->id;
        $newlead->researcher_name = Auth::user()->fullName();
      }
    } else {
      $newlead->researcher_id = Auth::user()->id;
      $newlead->researcher_name = Auth::user()->fullName();
    }
		
		$newlead->booker_name = Auth::user()->fullName();
    $newlead->booker_id = Auth::user()->id;
		$newlead->entry_date = date('Y-m-d');
		$newlead->birth_date = date('Y-m-d');
		$newlead->leadtype = $leadtype;
    $newlead->original_leadtype = $leadtype;
    $newlead->status = $input['newscratch-status'];
		$newlead->cust_name = $input['newscratch-name'];
    $newlead->spouse_name = $input['newscratch-spouse'];
		$newlead->cust_num = $num;
		$newlead->address = $input['newscratch-address'];
		$newlead->city = $input['newscratch-city'];
		$newlead->married = $input['newscratch-married'];
        	$newlead->call_date = date('Y-m-d H:i:s');
        	if($input['newscratch-status']==="Recall"){
			$time = Input::get('newscratch-booktimepicker');
    			$time =  date('H:i',strtotime($time));
            	$newlead->recall_date = $input['newscratch-recalldate'];
		}
		// Optional Data
		if(!empty($input['newscratch-homestead'])){
			$newlead->homestead_type = $input['newscratch-homestead'];
		}
    if(!empty($input['newscratch-sex'])){
      $newlead->sex = $input['newscratch-sex'];
    }
    if(!empty($input['newscratch-agerange'])){
      $newlead->age_range = $input['newscratch-agerange'];
    }
		if(isset($input['newscratch-gift'])){
             	$newlead->gift = $input['newscratch-gift'];
          	}
          	if(isset($input['newscratch-notes'])){
             	$newlead->notes = $input['newscratch-notes'];
          	}
          	if(!empty($input['newscratch-rentown'][0])){
        		if($input['newscratch-rentown'][0]=="rent"){
        			$newlead->rentown = "R";
        		} else {
        			$newlead->rentown = "O";
        		}
		      } else {
            	$newlead->rentown = "O";
          	}
		if(!empty($input['newscratch-fullpart'][0])){
			$newlead->fullpart = $input['newscratch-fullpart'][0];
		}
		if(!empty($input['newscratch-job'])){
			$newlead->job = $input['newscratch-job'];
      
		}
		if(!empty($input['newscratch-married'])){
			$newlead->married = $input['newscratch-married'];
		}
		// End Optional
		//Appointment check IF BOOKED
	  	if(($input['newscratch-status']=="APP")){
	  		if(empty($input['newscratch-booktimepicker'])){
	  			return Response::json("needtime");
	  		};
			if(!empty($input['newscratch-appdate'])){
			 	$t = Appointment::checkDate($input['newscratch-appdate']);
			 	if(Auth::user()->user_type=="agent"){
			 		if(!$t){
			 		return Response::json("cannotbook");
			 		}
			 	}
			};
			$time = $input['newscratch-booktimepicker'];
    			$time =  date('H:i',strtotime($time));
            	$newlead->booked_at = date('Y-m-d H:i:s');
            	$newlead->app_date = $input['newscratch-appdate'];
            	$newlead->app_time = $time;
            	$newlead->result = "APP";
            	$newlead->save();
            	// Register Appointment 
            	$appt = New Appointment;
            	$appt->lead_id = $newlead->id;
            	$appt->app_date = $input['newscratch-appdate'];
            	$appt->app_time = $time;
            	$appt->booked_at = date('Y-m-d H:i:s');
            	$appt->city = $input['newscratch-city'];
            	$appt->booked_by = Auth::user()->firstname." ".Auth::user()->lastname;
            	$appt->booker_id = Auth::user()->id;
            	$appt->researcher_id = Auth::user()->id;
            	$appt->status = "APP";
            	$appt->save();
            	// Register Alert Messages

            	$alert = Alert::find(5);
            	$alert->message = "NEW SCRATCH CARD DEMO BOOKED BY ".Auth::user()->firstname."!!  |  ".ucfirst($newlead->cust_name)."'s Demo is on ".$newlead->app_date." @ ".$newlead->app_time."";
            	$alert->color = "success";
            	$alert->icon = "cus-book-next";
            	$alert->save();
    		} else {
    			$newlead->save();
    		};

    		//Register as a call for new scratch card
        	$call = New Call;
        	$call->lead_id = $newlead->id;
        	$call->leadtype = $leadtype;
        	$call->caller_id = Auth::user()->id;
        	$call->caller_name = Auth::user()->firstname;
        	$call->phone_no = $newlead->cust_num;
        	$call->result = $input['newscratch-status'];
        	$call->created_at = date('Y-m-d H:i:s');
        	$call->save();

        	if($leadtype=="other"){
        		$scratch = Scratch::where('city','=',$input['newscratch-city'])->order_by('date_sent','desc')->first();
        		if($scratch){
        			$scratch->qty_calledin = $scratch->qty_calledin+1;
        			$date = strtotime($scratch->date_sent);
        			if(date('Y-m-d')<date('Y-m-d',strtotime('+7 Days',$date))){
        				$scratch->oneweek_qty = $scratch->oneweek_qty+1;
      			}
        			$scratch->save();
        		}
        	}

        	if(($newlead->lat==0)&&(!empty($newlead->address))){
        		$this->getlatLong(urlencode($newlead->address),$newlead->id);
        	}

        	return Response::json($newlead->attributes);
	}

	public function action_addnewlead(){
		$input = Input::get();
		$settings = Setting::find(1);
    if(isset($input['newlead-researcher'])){
      if(!empty($input['newlead-researcher'])){
        $res = explode("|",$input['newlead-researcher']);
        $user_id = $res[0];
        $user_name = $res[1];
        if(isset($res[2])){
          $user_name.=" ".$res[2];
        }
      } else {
        $user_name = Auth::user()->fullName();
        $user_id = Auth::user()->id;
      }
    } else {
        $user_name = Auth::user()->fullName();
        $user_id = Auth::user()->id;
    }

    

		if(($input['newlead-status']=="APP")){
			if(!empty($input['newlead-appdate'])){
			 	$t = Appointment::checkDate($input['newlead-appdate']);
			 	if(Auth::user()->user_type=="agent"){
			 		if(!$t){
			 		return Response::json("cannotbook");
			 		}
			 	}
			};
    };

		$leadtype = $input['newlead-leadtype'];
		$num = str_replace("-","",$input['newlead-custnum']);
		if(strlen($num)>=11){
			$num = substr($num, 1);
		}
		$num = substr($num,0,3)."-".substr($num,3,3)."-".substr($num,6,4);
		
		if($settings->duplicate_type=="allow_different_types"){
			$check = Lead::where('cust_num','=',$num)->where('original_leadtype','=',$leadtype)->count();
		} else if($settings->duplicate_type=="not_allowed"){
			$check = Lead::where('cust_num','=',$num)->count();
		} else if($settings->duplicate_type=="allow_all"){
			$check=false;
		} else {	
			$check=false;
		}
		
		if($check){
			return Response::json("alreadyexists");
		}
		if(empty($input['newlead-custnum'])){
			return Response::json("nonum");
		}
		if(empty($input['newlead-city'])){
			return Response::json("nocity");
		}
		if(empty($input['newlead-name'])){
			return Response::json("noname");
		}

     		$lead = New Lead;
     		$lead->leadtype = $leadtype;
        	$lead->original_leadtype=$leadtype;
          if($leadtype=="homeshow"){
            $lead->event_id = $input['newlead-eventid'];
          }
        	$lead->researcher_name = $user_name;
        	$lead->researcher_id = $user_id;
        	$lead->cust_num = $num;
        	$lead->entry_date = date('Y-m-d');
            if(isset($input['newlead-entrydate'])){
               $lead->birth_date = $input['newlead-entrydate'];
            } else {
               $lead->birth_date = date('Y-m-d');
            }
            if($input['newlead-leadtype']=="referral"){
            	if(isset($input['newlead-referralleadHidden'])){
    				if(!empty($input['newlead-referralleadHidden'])){
    					$lead->referral_id = $input['newlead-referralleadHidden'];
    				}
    			}
            }
           	
            
            if($input['newlead-status']=="Recall"){
            	$lead->recall_date = $input['newlead-recalldate'];
            }
     		  $lead->cust_name = $input['newlead-name'];
        	$lead->spouse_name = $input['newlead-spouse'];
        	$lead->city = $input['newlead-city'];
        	$lead->address = $input['newlead-address'];
          if(isset($input['newlead-gift'])){
             $lead->gift = $input['newlead-gift'];
          }
          if(isset($input['newlead-notes'])){
             $lead->notes = $input['newlead-notes'];
          }

        	if(!empty($input['newlead-rentown'][0])){
        		if($input['newlead-rentown'][0]=="rent"){
        			$lead->rentown = "R";
        		} else {
        			$lead->rentown = "O";
        		}
		      } else {
            $lead->rentown = "O";
          }

		if(!empty($input['newlead-fullpart'][0])){
			$lead->fullpart = $input['newlead-fullpart'][0];
		}

		if(!empty($input['newlead-job'])){
			$lead->job = $input['newlead-job'];
      
		}
		if(!empty($input['newlead-homestead'])){
			$lead->homestead_type = $input['newlead-homestead'];
		}
    if(!empty($input['newlead-sex'])){
      $lead->sex = $input['newlead-sex'];
    }
    if(!empty($input['newlead-agerange'])){
      $lead->age_range = $input['newlead-agerange'];
    }
		if(!empty($input['newlead-marital'])){
			$lead->married = $input['newlead-marital'];
		}

    if(isset($input['newlead-asthma'])){
      if($input['newlead-asthma']==1){
        $lead->asthma = "Y";
      } else {
        $lead->asthma = "N";
      }
      
    }
     if(isset($input['newlead-pets'])){
      if($input['newlead-pets']==1){
        $lead->pets = "Y";
      } else {
        $lead->pets = "N";
      }
    }
     if(isset($input['newlead-smoke'])){
      if($input['newlead-smoke']==1){
        $lead->smoke = "Y";
      } else {
        $lead->smoke = "N";
      }
    }

    if($input['newlead-status']=="NEW" && ($input['newlead-leadtype']=="door" || $input['newlead-leadtype']=="homeshow" || $input['newlead-leadtype']=="ballot")){
      $lead->status = "INACTIVE";
    } else {
      $lead->status = $input['newlead-status'];
    }


        	$lead->save();
 
        	if(($input['newlead-status']=="APP")){

    				$time =  date('H:i',strtotime($input['newlead-booktimepicker']));
            		$lead->booker_name = Auth::user()->firstname." ".Auth::user()->lastname;
            		$lead->booker_id = Auth::user()->id;
            		$lead->booked_at = date('Y-m-d H:i:s');
            		$lead->app_date = $input['newlead-appdate'];
            		$lead->app_time = $time;
            		$lead->result = "APP";

            		$call = New Call;
            		$call->lead_id = $lead->id;
            		$call->leadtype = $lead->leadtype;
            		$call->caller_id = Auth::user()->id;
            		$call->caller_name = Auth::user()->firstname;
            		$call->phone_no = $lead->cust_num;
            		$call->created_at = date('Y-m-d H:i:s');
            		$call->result = "APP";
            		$call->save();
		
            		$appt = New Appointment;
            		$appt->lead_id = $lead->id;
            		$appt->app_date = $input['newlead-appdate'];
            		$appt->app_time = $time;
            		$appt->city = $input['newlead-city'];
            		$appt->booked_at = date('Y-m-d H:i:s');
            		$appt->booked_by = Auth::user()->firstname." ".Auth::user()->lastname;
            		$appt->booker_id = Auth::user()->id;
            		$appt->status = "APP";
            			if($appt->save()){
                				$alert = Alert::find(5);
                				$alert->message = "APPOINTMENT BOOKED : ".Auth::user()->firstname." ".Auth::user()->lastname." has booked an appointment for ".$lead->app_date." at ".$lead->app_time;
                				$alert->color = "success";
                				$alert->icon = "cus-clipboard-sign";
                				$alert->save();
            			};
       		}

        		if(!empty($input['newlead-address'])){
            		$this->getlatLong(urlencode($input['newlead-address']),$lead->id); 
            	}

            if($lead->save()){
            	return Response::json($lead->attributes);
            } else {
            	return Response::json("failed");
            }
		
	}

	public function action_stats(){

		$input = Input::get();
		$city = $input['city'];

       	$stats = DB::query("SELECT assign_count, 
   		SUM(status='APP' OR status='SOLD' OR status='DNS' OR status='CXL') booked,
   		SUM(status='NI' OR status='NQ' OR status='DNC') notinterested,
   		SUM(status='SOLD') sold
       	FROM leads WHERE city = '".$city."' GROUP BY assign_count  ");
	
		return View::make('plugins.leadstats')
		->with('city',$city)
		->with('stats',$stats);


	}

	public function action_recalls(){
    $activecities = City::where('status','=','active')->get();
     $recalls = Lead::where('status','=','Recall')
     	->order_by('recall_date')
     	->get();
     return View::make('plugins.recalls')
      ->with('cities',$activecities)
     	->with('recalls',$recalls);
  }

  public function action_referrals(){
    $activecities = City::where('status','=','active')->get();
    $referrals = Lead::where('original_leadtype','=','referral')->where('researcher_id','!=',0)
    ->order_by('entry_date','ASC')->order_by('cust_name','DESC')->get();
   
          $array = array();
          if(!empty($referrals)){
            foreach($referrals as $val){
              $user = User::find($val->researcher_id);
                array_push($array, $val->researcher_id);
            }
          }

        $refname = array_unique($array);

         return View::make('plugins.referralleads')
         ->with('referrals',$referrals)
         ->with('refname',$refname);
  }

  

    	

    	public function action_releaserecall(){
    		$input = Input::get();
    		$id = $input['theid'];
    		$n = $input['notes'];
    		$msg="failed";
       	$l = Lead::find($id);   
        	$l->status = "NEW";
        	if($n==true){
    			$l->notes="";
    		}
    		$l->recall_release = date('Y-m-d');
        	$l->recall_date = "0000-00-00";

        	if($l->save()){
        		return json_encode("success");
        	} else {
        		return json_encode("failed");
        	}
        	
    	}
	/*----LEAD FUNCTIONS----*/
	//
	//
	public function action_geocodeall(){
        	$l = Lead::where('address','!=','')->where('lat','=',0)->where('lng','=',0)->get();
      
        	foreach($l as $val){
            	$this->getlatLong(urlencode($val->address),$val->id); 
            	echo "success";
        	}
    	}

    	public function getlatlong($address, $id){
        	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true";
        	$get = file_get_contents($url);
        	$xml = json_decode($get);
        	$l = Lead::find($id);
        		if(!empty($xml->results[0])){
        			$l->lat = $xml->results[0]->geometry->location->lat;
        			$l->lng = $xml->results[0]->geometry->location->lng;
        		}
        	if($l->save()){
            	return true;
        	}
    	}
	
	public function action_checknum($num){

		$check = Lead::where('original_leadtype','=','door')
			->where('cust_num','=',$num)
			->count();

		if($check){
			echo "yes";
		} else {

		}	
	}
	
	

	public function action_checkscratchnum($num){

		$check = Lead::where('cust_num','=',$num)
			->count();

		if($check){
			echo "yes";
		} else {

		}	
	}

    	public function action_fixnum(){
        	$num = Input::get('phone');
        	$id = Input::get('id');

        	$l = Lead::find($id);
        	if($l->researcher_id==Auth::user()->id){
        		$l->cust_num = $num;
        		$l->status = "NEW";
        	}
       
        	if($l->save()){
            	echo "success";
        	};
    	}

    	public function validatephone($num){
        	if( !preg_match("/^([1]-)?[0-9]{3}-[0-9]{3}-[0-9]{4}$/i", $num) ) { 
            	return false;
        	} else {
            	return true;
        	}
    	}

   	public function action_doorstats(){
	
	   	$getdate= Input::get('date');
      	if(!$getdate){
      		$getdate = date('Y-m-d');
      	}
	  
      	$date = date('Y-m-d H:i:s', strtotime($getdate));
	  	$enddate = date('Y-m-d H:i:s', strtotime('+23 hours', strtotime($getdate)));
       
       	$reps = User::where('user_type','=','salesrep')->get();
	    
	    	$todaysregys = Lead::where('leadtype','=','door')
			->where('status','=','NEW')
			->where('created_at','>',$date)
			->where('created_at','<',$enddate)
			->order_by('created_at','DESC')
			->get();
       
      	return View::make('leads.doormap')
      		->with('appts',$todaysregys)
      		->with('reps',$reps)
      		->with('date',date('M-d',strtotime($date)))
      		->with('datepass',$date);
	}

    	public function action_bookerleads($id=null){

        	$leads = Auth::user()->getcurrentleads(0);
        	$html ="";
        	foreach($leads as $val){
            	if($val->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
            	if($val->status=="APP"){$label="success";}
            	elseif($val->status=="ASSIGNED"){$label="info";} 
            	elseif($val->status=="NH") {$label="inverse";} 
            	elseif($val->status=="DNC") {$label="important";}
            	elseif($val->status=="NI") {$label="important";}
            	elseif($val->status=="Recall") {$label="warning";}
    
            	$html.="<tr id='agentrow-".$val->id."' class='".$shadow." ".$val->status."' style='color:".$color."'>";
            	$html.="<td>".date('M-d', strtotime($val->created_at))."</td>";
            	$html.="<td class='span4'><b>".$val->cust_num."</b></td>";
            	$html.="<td class='span4'>".$val->cust_name."</td>";
            	$html.=" <td>".$val->city."</td>";
            
            		if(Lead::find($val->id)->calls()->count()!=0){
            			$html.="<td><center><span class='label label-success boxshadow'>".Lead::find($val->id)->calls()->count()." Calls Made</center></td>";
            		} else {
                			$html.="<td><center><span class='label label-inverse '>Not Called</span></center></td>";
            		}
            	$html.="<td><span class='label label-".$label." special boxshadow'>".$val->status."</span></td>";
            		if(Auth::user()->user_type=="agent"){
            			$html.="<td><a class='btn btn-primary' href='".URL::to('lead/newlead/').$val->cust_num."'><i class='cus-telephone'></i>&nbsp;VIEW LEAD</a></td>";
           			}
           		$html.="</tr>";
        	}
        	return $html;
    	}

    	//LEAD ACTIONS - ASSIGN, UNASSIGN AND SORT
    	public function action_assignleads($type=null){
    		$input = Input::all();
     		$info = explode("|",$input['id']);
     		$id=explode("|",$input['value']);
     		$theMsg="";$count=0;
        if(Setting::find(1)->auto_unassign==1){
          if(!User::unassignleads($id[1])){
          //return json_encode("failed");
          }
        }
     		
		      $u = User::find($id[1]);
        	if(!empty($u)) $name = $u->fullName();

    		if($type){
    			$city = $info[2]; $block=30; $type2="paper";
          $cityType = City::where('cityname','=',$city)->first();
    			$date = $info[0];
    			$theMsg="NEW";
    			$leads = DB::query("UPDATE leads SET booker_name='".$name."',booker_id='".$u->id."',assign_time='".date('H:i:s')."', assign_date='".date('Y-m-d')."', status='ASSIGNED' WHERE city='".$city."' AND researcher_name='Upload/Manilla' AND status='NEW'  AND sale_id=0 AND entry_date=DATE('".$date."') AND leadtype='paper' ORDER BY assign_count ASC LIMIT ".$block."");
        	$leadcount = DB::query("SELECT id FROM leads WHERE city='".$city."' AND researcher_name='Upload/Manilla' AND status='NEW' AND entry_date=DATE('".$date."') AND leadtype='paper'  AND sale_id=0  ORDER BY assign_count ASC LIMIT ".$block."");

    		} else {
        //Extract data from ajax call
    		$block = $info[0];
        $type2 = $info[1];
        $city = $info[2];
        $never_called = $info[3];
        $reverse = $info[4];
     		$job_filter = $info[5];
        $age_filter = $info[6];
        $sex_filter = $info[7];
        $marital_filter = $info[8];

        $cityType = City::where('cityname','=',$city)->first();
        if($cityType){
          if($cityType->type=="area"){
            $cityQuery = "area_id = '".$cityType->id."'";
          } else {
            $cityQuery = "city = '".$city."'";
          }
        } else {
          $cityQuery = "city = '".$city."'";
        }

        if($type2=="rebook"){
        		$all = $info[3];
        		$time = explode("-",$info[4]);
    			  $s = date('H:i',strtotime($time[0]));
    			  $f = date('H:i',strtotime($time[1]));
    			  $theMsg = "REBOOKS";
        		if($all=="true"){
        			$leadcount = DB::query("SELECT id FROM leads WHERE $cityQuery
        			AND leadtype='".$type2."' AND status='NEW' AND sale_id=0 ORDER BY assign_count ASC");
        			$leads = DB::query("UPDATE leads SET booker_name='".$name."',booker_id='".$u->id."',assign_time='".date('H:i:s')."',
                assign_date='".date('Y-m-d')."',status='ASSIGNED' WHERE $cityQuery 
        			AND leadtype='".$type2."' AND status='NEW' AND sale_id=0 ORDER BY assign_count ASC");
        		} else {
        			$leadcount = DB::query("SELECT id FROM leads WHERE $cityQuery
        			AND leadtype='".$type2."' AND status='NEW' AND sale_id=0 
        			AND app_time >= '".$s."' AND app_time <= '".$f."'  ORDER BY assign_count ASC LIMIT ".$block."");
        			$leads = DB::query("UPDATE leads SET booker_name='".$name."',booker_id='".$u->id."',assign_time='".date('H:i:s')."',
                assign_date='".date('Y-m-d')."',status='ASSIGNED' WHERE $cityQuery 
        			AND leadtype='".$type2."' AND status='NEW' AND sale_id=0 
        			AND app_time >= '".$s."' AND app_time <= '".$f."'  ORDER BY assign_count ASC LIMIT ".$block."");
        		}
    		  } else {
            $filter = "";

            if($job_filter!="false"){
              if($job_filter=="working"){
                $filter.= "AND fullpart!='R' ";
                $theMsg.="Job : ".strtoupper($job_filter)." | ";
              } else if($job_filter=="R"){
                $filter.= "AND (job LIKE '%RETIRED%' OR fullpart='R') ";
                $theMsg.="Job : RETIRED | ";
              } else if($job_filter=="FT" || $job_filter=="PT"){
                $filter.= "AND fullpart='".$job_filter."' ";
                $theMsg.="Job : ".strtoupper($job_filter)." | ";
              }
            } 

            if($age_filter!="all"){
              $filter.="AND age_range='".$age_filter."' ";
              $theMsg.="Between ".$age_filter." YRS | ";
            }

            if($sex_filter!="false"){
              $filter.="AND sex='".$sex_filter."' ";
              $theMsg.="Sex : ".strtoupper($sex_filter)." | ";
            }

            if($marital_filter!="false"){
              $filter.="AND married='".$marital_filter."' ";
              $theMsg.="Marital Status : ".strtoupper($marital_filter)." | ";
            }

            if($never_called=="true"){
              $filter.="AND assign_count=0 ";
              $theMsg.="NEVER CALLED | ";
            } 
            
            $order="ORDER BY ";
            if($reverse=="true"){
              $order.="entry_date ASC ,";
              $theMsg.="OLDEST FIRST |";
            }
            $order.="assign_count ASC ";

            $leadcount = DB::query("SELECT id FROM leads WHERE $cityQuery 
              AND leadtype='".$type2."' AND status='NEW' AND sale_id=0 ".$filter.$order." LIMIT ".$block."");
            $leads = DB::query("UPDATE leads SET booker_name='".$name."',booker_id='".$u->id."',assign_time='".date('H:i:s')."',assign_date='".date('Y-m-d')."',status='ASSIGNED' 
              WHERE $cityQuery AND leadtype='".$type2."' AND status='NEW' AND sale_id=0 ".$filter.$order." LIMIT ".$block."");
          }
		    }

        	$count = count($leadcount);
        	$msg = "<span class='label label-info special'>".$count."</span> ".$theMsg." ".strtoupper($type)." LEADS ASSIGNED to ".$name." - From ".strtoupper($city)." - Assigned on ".date('H:m M-d');

        	$alert = New Alert;
        	$alert->receiver_id = $u->id;
        	$alert->type = "personal";
        	$alert->message = $count." LEADS ASSIGNED - From ".strtoupper($city)." - Assigned on ".date('H:m M-d')." | ".$theMsg;
        	$alert->color = "success";
        	$alert->icon = "cus-telephone";
        	$alert->save();

        	$alert = Alert::find(6);
        	$alert->seen = 1;
        	$alert->save();

        	$alert = Alert::find(8);
        	$alert->message = "LAST BATCH OF LEADS : ".$msg;
        	$alert->color = "info";
        	$alert->icon = "cus-telephone";
        	$alert->save();

        	$alert = Alert::find(5);
        	$alert->message = $msg;
        	if($count==0){
            $alert->color = "error";
          } else {
            $alert->color = "info";
          }
        	$alert->icon = "cus-telephone";
        	$alert->save();
          if($cityType->type=="area"){
            if($type2=="rebook"){
              if($all=="true"){
                $thecount = Lead::where('leadtype','=',$type2)
                ->where('area_id','=',$cityType->id)
                ->where('status','=','NEW')
                ->where('sale_id','=',0)
                ->count();
                $msg = "allrebooks";
              } else {
                $thecount = Lead::where('leadtype','=',$type2)
                ->where('area_id','=',$cityType->id)
                ->where('status','=','NEW')
                ->where('sale_id','=',0)
                ->where('app_time','>=',$s)
                ->where('app_time','<=',$f)
                ->count();
              }
            } else {
              $thecount = Lead::where('leadtype','=',$type2)
              ->where('area_id','=',$cityType->id)
              ->where('status','=','NEW')
              ->where('sale_id','=',0)
              ->count();
            }
          } else {
            if($type2=="rebook"){
              if($all=="true"){
                $thecount = Lead::where('leadtype','=',$type2)
                ->where('city','=',$city)
                ->where('status','=','NEW')
                ->where('sale_id','=',0)
                ->count();
                $msg = "allrebooks";
              } else {
                $thecount = Lead::where('leadtype','=',$type2)
                ->where('city','=',$city)
                ->where('status','=','NEW')
                ->where('sale_id','=',0)
                ->where('app_time','>=',$s)
                ->where('app_time','<=',$f)
                ->count();
              }
            } else {
              $thecount = Lead::where('leadtype','=',$type2)
              ->where('city','=',$city)
              ->where('status','=','NEW')
              ->where('sale_id','=',0)
              ->count();
            }
          }

        	$asscount_city = DB::query("SELECT city, SUM(status = 'ASSIGNED' ) assigned	FROM leads GROUP BY city");
          $asscount_area = DB::query("SELECT area_id, SUM(status='ASSIGNED') assigned FROM leads WHERE area_id!=0 GROUP BY area_id ");
        	$city = str_replace(" ","-",strip_tags($city));

		if($type=="manilla"){
			$asscount = DB::query("	SELECT city, SUM(status = 'ASSIGNED' ) assigned	FROM leads GROUP BY city");
      $asscount_city = DB::query("  SELECT city, SUM(status = 'ASSIGNED' ) assigned FROM leads GROUP BY city");
      $asscount_area = DB::query("SELECT area_id, SUM(status='ASSIGNED') assigned FROM leads WHERE area_id!=0 GROUP BY area_id ");
          
			return Response::json(count($leadcount));
		} else {
			return Response::json(array("city"=>$city,"count"=>$thecount,"assigned_city"=>$asscount_city,"assigncount_area"=>$asscount_area,"msg"=>$msg,"cnt"=>$count));
		}
	}
    	

    	public function action_unassignlead($id){
        	if($id!="all"){
        		DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW' WHERE status='ASSIGNED' AND booker_id='".$id."'");
        		
        	} else {
        		DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW' WHERE status='ASSIGNED'");
        	}

        	return Redirect::to('lead');
    	}

    	public function action_releaseleads(){
        	$input = Input::get();
        	$type = Input::get('releaseleadtype');
        	$block = Input::get('releaseblocksize');
        	$city = Input::get('citytorelease');
          
          if($type!='DELETED'){
            $days = "-".Input::get('releasetime')." days";
            $date = date('Y-m-d',strtotime($days));
          }

          $cityType = City::where('cityname','=',$city)->first();
          if($cityType){
            if($cityType->type=="area"){
              if($type=='DELETED'){
                $leads = Lead::where('status','=','DELETED')
                ->where('area_id','=',$cityType->id)
                ->where('entry_date','>=','2013-10-20')
                ->where('entry_date','!=','0000-00-00')
                ->order_by('entry_date')
                ->take($block)
                ->get();
                $date = date('Y-m-d');
              } else {
                  $leads = Lead::where('status','=','INACTIVE')
                ->where('birth_date','<=',$date)
                ->where('area_id','=',$cityType->id)
                ->where('leadtype','=',$type)
                ->take($block)
                ->get();
              }
            } else {
              if($type=='DELETED'){
                $leads = Lead::where('status','=','DELETED')
                ->where('city','=',$city)
                ->where('entry_date','>=','2013-10-20')
                ->where('entry_date','!=','0000-00-00')
                ->order_by('entry_date')
                ->take($block)
                ->get();
                $date = date('Y-m-d');
              } else {
                  $leads = Lead::where('status','=','INACTIVE')
                ->where('birth_date','<=',$date)
                ->where('city','=',$city)
                ->where('leadtype','=',$type)
                ->take($block)
                ->get();
              }
            }
          }


        	$releasecount = 0;
          if(!empty($leads)){
        	   foreach($leads as $val){
              $val->status = "NEW";
              if($type!='DELETED'){
                $val->release_date = date('Y-m-d');
              } else {
                $val->release_date = date('Y-m-d');
                $val->was_deleted = 1;
                $val->assign_count=0;
              }
              
              if($val->save()){
              		$releasecount++;
              };
       	    }
          }

          if($type=='DELETED'){
            $releasecount = $releasecount. "DELETED";
          }

        	$alert = Alert::find(5);
        	$alert->message = $releasecount." leads released into the system<br/> Date : ".date('M d', strtotime($date))." <br/>By :".Auth::user()->firstname." ".Auth::user()->lastname;
        	$alert->color = "info";
        	$alert->icon = "cus-arrow-right";
        	$alert->save();

        	return Redirect::to('lead');
    	}

    	public function action_releasemanilla(){
    		$input = Input::get();
    		$city = $input['city'];
    		$date = $input['date'];

   		  $releasecount = DB::query("SELECT COUNT(*) as count FROM leads WHERE researcher_name = 'Upload/Manilla' AND leadtype!='survey' city LIKE '%".$city."%' AND entry_date=DATE('".date('Y-m-d',strtotime($date))."') AND status='INACTIVE'");
		    DB::query("UPDATE leads SET status='NEW',release_date='".date('Y-m-d')."' WHERE researcher_name = 'Upload/Manilla' AND leadtype!='survey' AND city LIKE '%".$city."%' AND entry_date=DATE('".date('Y-m-d',strtotime($date))."') AND status='INACTIVE'");

    		return json_encode(array(count($releasecount)));
    	}


    	public function action_sortleads(){


    		$input = Input::get();
    		if(!empty($input['citytosort'])){
    			$city = $input['citytosort'];
    			$sorttype = $input['sorttype'];
    		} else {
    			$city=false;
    			$sorttype=false;
    		}
    		
    		$recallcount=0;$noanswercount=0;
        $cityQuery="";
        // If CITY is chosen, sort only the city
    		if($city){
          $theCity = City::where('cityname','=',$city)->first();
          if($theCity){
            if($theCity->type=="area"){
              $cityQuery="area_id = '".$theCity->id."' ";
            } else {
              $cityQuery="city = '".$city."' ";
            }
          } 
    			// Sort either all or rebooks only
          if($sorttype=="all"){
    				$st = "";
    			} elseif($sorttype=="rebooks"){
    				$st = "AND leadtype='rebook'";
    			} else if($sorttype==false){
    				$st = "";
    			} else {
    				$st = "AND leadtype='".$sorttype."' ";
    			}

        		//Get count of NOT HOMES in system by city
        		  $leadsortcount = DB::query("SELECT COUNT(*) as count FROM leads 
              WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND $cityQuery 
              AND status='NH' AND sale_id=0 ".$st);

        		//Get count of rebooks in system by city
			        $rebookcount = DB::query("SELECT COUNT(*) as count FROM leads 
                WHERE DATE(app_date) < DATE('".date('Y-m-d')."') 
                AND status='RB' AND $cityQuery ".$st);

            // Get count of all ASSIGNED leads for this city
        		  $assignedcount = DB::query("SELECT COUNT(*) as count FROM leads 
                WHERE $cityQuery AND status='ASSIGNED' ".$st);

            // IF RECALL SORT IS CHECKED - SORT INTO POOL
        		if(Setting::find(1)->sort_recalls==1){
              //Get count of recalls in system by city
        			$recallcount = DB::query("SELECT COUNT(*) as count FROM leads 
                WHERE app_date < DATE('".date('Y-m-d')."') AND $cityQuery 
                AND status='Recall' AND sale_id=0 AND recall_date<=DATE('".date('Y-m-d')."') ".$st);
        			//Update Recalls
         		   DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW' 
                WHERE app_date < DATE('".date('Y-m-d')."') AND $cityQuery 
                AND status='Recall' AND sale_id=0 AND recall_date<=DATE('".date('Y-m-d')."') ".$st);
        			//Get count of recalls sorted
              $recallcount = $recallcount[0]->count;
        		}

            if(Setting::find(1)->sort_noanswer==1){
              //Get count of noanswers in system by city
              $noanswercount = DB::query("SELECT COUNT(*) as count FROM leads 
              WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND $cityQuery AND status='APP' AND result='NA' AND sale_id=0 ");
              //Update No Answers
              DB::query("UPDATE leads SET booker_name='',booker_id='', leadtype='rebook', result='', assign_date='',status='NEW', app_time='00:00:00'  
              WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND $cityQuery AND status='APP' AND result='NA' AND sale_id=0");
              //Get count of No Answers
              $noanswercount = $noanswercount[0]->count;
            }

            // UPDATE THE LEADS 
        		//NH's
        		DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW',result=''
    			   WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND $cityQuery AND status='NH' AND sale_id=0 ".$st);
        		//RB's
        		DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW', leadtype='rebook',result='' 
        		WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND $cityQuery AND sale_id=0 AND status='RB' ".$st);
        		//Update ASSIGNED - reput back into pool if not past today.
        		DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW',result='' 
            WHERE $cityQuery AND status='ASSIGNED' ".$st);
        	   
        } else {

        		//Get count of NOT HOMES in system 
        		$leadsortcount = DB::query("SELECT COUNT(*) as count FROM leads 
        		WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND status='NH' AND sale_id=0 ");

        		//Get count of rebooks in system 
			      $rebookcount = DB::query("SELECT COUNT(*) as count FROM leads 
            WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND status='RB' AND sale_id=0 ");

        		//Get count of ASSIGNED in system 
        		$assignedcount = DB::query("SELECT COUNT(*) as count FROM leads WHERE status='ASSIGNED'");

        		// IF RECALL SORT IS CHECKED - SORT INTO POOL
         		if(Setting::find(1)->sort_recalls==1){
        			//Get count of recalls in system by city
        			$recallcount = DB::query("SELECT COUNT(*) as count FROM leads 
              WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND status='Recall' AND sale_id=0 
              AND recall_date<=DATE('".date('Y-m-d')."')");
        			//Update Recalls
         			DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW' 
    				  WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND status='Recall' AND sale_id=0 
              AND recall_date<=DATE('".date('Y-m-d')."')");
         			// Get recall count
              $recallcount = $recallcount[0]->count;
        		}

            if(Setting::find(1)->sort_noanswer==1){
              $noanswercount = DB::query("SELECT COUNT(*) as count FROM leads 
              WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND status='APP' AND result='NA' AND sale_id=0 ");
              DB::query("UPDATE leads SET booker_name='',booker_id='', leadtype='rebook', result='', assign_date='',status='NEW', app_time='00:00:00'  
              WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND status='APP' AND result='NA' AND sale_id=0");
              $noanswercount = $noanswercount[0]->count;
            }
         		
        		//NH's
        		DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW',result=''  
    			   WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND status='NH' AND sale_id=0 ");
        		//RB's
        		DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW', leadtype='rebook',result='' 
        		WHERE DATE(app_date) < DATE('".date('Y-m-d')."') AND status='RB' AND sale_id=0 ");
        		//ASSIGNED
        		DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW',result='' 
              WHERE status='ASSIGNED'");
        }

        //Get counts of all updated leads
        $rebookcount = $rebookcount[0]->count;
        $leadsortcount = $leadsortcount[0]->count;
        $assignedcount = $assignedcount[0]->count;

        	$msg="";
        	$alert = Alert::find(7);
        	if($city){
        		if($st!=""){
        			$msg="Rebook Leads from ".$city." last sorted ".date('D g:i a')." by ".Auth::user()->firstname." ".Auth::user()->lastname;
        		} else {
        			$msg="Leads from ".$city." last sorted ".date('D g:i a')." by ".Auth::user()->firstname." ".Auth::user()->lastname;
        		}
        		
        		$alert->message = $msg;
        	} else {
        		$msg="Leads last sorted ".date('D g:i a')." by ".Auth::user()->firstname." ".Auth::user()->lastname;
        		$alert->message = $msg;
        	}
        	
        	$alert->color = "info";
        	$alert->icon = "cus-arrow-redo";
        	$alert->save();
	
        	$alert = Alert::find(5);
        	if($city){
        		$alert->message = $leadsortcount." NH's | ".$rebookcount." RB's | ".$noanswercount." NA's | ".$recallcount." Recalls from ".$city." have been sorted into lead pool By ".Auth::user()->firstname." ".Auth::user()->lastname;
        	
        	} else {
        		$alert->message = $leadsortcount." NH's | ".$rebookcount." RB's | ".$noanswercount." NA's | ".$recallcount." Recalls | ".$assignedcount." ASSIGNED |  have been sorted into lead pool By ".Auth::user()->firstname." ".Auth::user()->lastname;
        	}
        	$alert->color = "info";
        	$alert->icon = "cus-arrow-redo";
        	$alert->save();
        	return Response::json($msg);

    	}


      public function action_batchload($type=null){

        $input = Input::get();

        if(isset($input['s3TempFile'])){
          $file="temp.xls";
          $getfile = S3::getObject("salesdash", $input['s3TempFile'], $file);
          $filename = "tempfile";
        } else {
          $filename = Input::file('csvfile.name');
          $tmp = Input::file('csvfile.tmp_name');
          $file = $tmp;
        }
        
        if(empty($filename) || !isset($filename)){
          Session::flash('nofile','You need to attach an XLS file in order to upload leads !');
          if($type=="preview"){
          	$html = View::make('plugins.uploadpreview')->with('leads',array())->with('columns',array())->render();
          	return Response::make($html);
          } else {
          	return Redirect::back();
          }
        }

        $set = Setting::find(1);
        $sc = $set->shortcode;
        if($sc=="foxv" || $sc=="cyclo" || $sc=="triad" || $sc=="starcity" || $sc=="mdhealth" || $sc=="mdhealth2" || $sc=="ribmount" || $sc=="pureair" ){
          $leadtype = "survey";
        } else {
          $leadtype = "paper";
        }

        $count=0;$duplicate=0;$empty=0;
        //Variable declaration
        $researcher = Input::get('researcher');
        $survey_date = Input::get('survey_date');
        $city = Input::get('leadcity');

        $theCity = City::where('cityname','=',$city)->first();
        if($theCity){
        	$offset = $theCity->time_offset;
        } else {
        	$offset = 0;
        }

        //SETUP COLUMNS BASED ON USER CHOSEN COLUMNS
        //First initiate index referencing variable
        $arrColumns = array(0=>'A',1=>'B',2=>'C',3=>'D',4=>'E',5=>'F',6=>'G',7=>'H',8=>'I',9=>'J',10=>'K',11=>'L',12=>'M',13=>'N',14=>'O',15=>'P',16=>'Q',17=>'R',18=>'S',19=>'T',20=>'U',21=>'V',22=>'W',23=>'X',24=>'Y',25=>'Z',26=>'AA',27=>'AB',28=>'AC',29=>'AD',30=>'AE',31=>'AF',32=>'AG',33=>'AH',34=>'AI',35=>'AJ',36=>'AK',37=>'AL',38=>'AM',39=>'AN',40=>'AO',41=>'AP',42=>'AQ',43=>'AR',44=>'AS',45=>'AT',46=>'AU',47=>'AV',48=>'AW',49=>'AX',50=>'AY',51=>'AZ',52=>'BA',53=>'BB',54=>'BC',55=>'BD',56=>'BE',57=>'BF',58=>'BG',59=>'BH',60=>'BI',61=>'BJ',62=>'BK',63=>'BL',64=>'BM',65=>'BN',66=>'BO',67=>'BP',68=>'BQ',69=>'BR',70=>'BS',71=>'BT',72=>'BU',73=>'BV',74=>'BW',75=>'BX',76=>'BY',77=>'BZ');
        //Explode column list and store in new array with above index keys
        $arr = array();
        $columnOrder = explode(",",$input['xlsColumnOrder']);
        foreach($columnOrder as $i=>$col){
          $arr[$col] = $arrColumns[$i];
        }


        //Apply defaults if variables are empty
        if(!empty($researcher)){
           $user = $researcher;
          } else {
           $user = 0;
        }

        if(empty($survey_date)){
          $suvey_date = date('Y-m-d');
        }

        // Initaite PHP Excel
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';
        $xls = PHPExcel_IOFactory::load($file);
        $rows = $xls->getActiveSheet()->toArray(null,true,false,true);

        $dataToInsert = array();
        foreach($rows as $r){
        	
          $rowData = array();
          //Check cust_num column for valid number
          //If has valid number continue
          if(1 === preg_match('~[0-9]~', $r[$arr['cust_num']])){
          	//Break out of loop, if its only a file preview
          	if($type=="preview"){
        		if($count>=10){
        			break;
        		}
        	}
            //Apply correct formatting to the phone number
            $numcheck= str_replace(array( '(', ')' ), '', $r[$arr['cust_num']]);
            $numcheck = str_replace("-","",$numcheck);
            $numcheck = str_replace(" ","",$numcheck);
            $num = substr($numcheck,0,3)."-".substr($numcheck,3,3)."-".substr($numcheck,6,4);

            //If preview, allow any and all just for preview
            if($type=="preview"){
              $checkphone=false;
            } else {
              //Do duplicate checking here
              if($set->duplicate_type=="not_allowed"){

                if($set->duplicate_timeframe=="3_months"){
                  $checkphone = Lead::where('cust_num','=', $num)->where('birth_date','>=',date('Y-m-d',strtotime('-3 Months')))->first();
                } else if($set->duplicate_timeframe=="6_months"){
                  $checkphone = Lead::where('cust_num','=', $num)->where('birth_date','>=',date('Y-m-d',strtotime('-6 Months')))->first();
                } else if($set->duplicate_timeframe=="8_months"){
                  $checkphone = Lead::where('cust_num','=', $num)->where('birth_date','>=',date('Y-m-d',strtotime('-8 Months')))->first();
                } else if($set->duplicate_timeframe=="1_year"){
                  $checkphone = Lead::where('cust_num','=', $num)->where('birth_date','>=',date('Y-m-d',strtotime('-12 Months')))->first();
                } else {
                  $checkphone = Lead::where('cust_num','=', $num)->first();
                }
              } else if($set->duplicate_type=="allow_all"){
                $checkphone=false;
              } else if($set->duplicate_type=="allow_different_types"){
                $checkphone = Lead::where('cust_num','=', $num)->where('original_leadtype','=',$leadtype)->first();
              } 
            }

              
              $rowData["manilla_researcher"] = $user;
              $rowData["leadtype"] = $leadtype;
              $rowData["original_leadtype"] = $leadtype;
              $rowData["researcher_id"] = Auth::user()->id;
              $rowData["researcher_name"] = "Upload/Manilla";
              $rowData["app_offset"] = $offset;
              $rowData["birth_date"] = $survey_date;
              $rowData["entry_date"] = date('Y-m-d');
              $rowData["created_at"]= date('Y-m-d H:i:s');
              $rowData["updated_at"]= date('Y-m-d H:i:s');
              $rowData["cust_num"] = $num;
              //Name Details
              //Check for name field.  Append last name if seperate
              $cust_name="";
              if(isset($arr['CustomerName'])){
                $cust_name = $r[$arr['CustomerName']];
              }
              if(isset($arr['OptionalLastName'])){
                $cust_name.= " ".$r[$arr['OptionalLastName']];
              }
              $rowData["cust_name"] = $cust_name;

              if(isset($arr['spouse_name'])){
                $rowData["spouse_name"] = $r[$arr['spouse_name']];
              } else {
                $rowData["spouse_name"] = "";
              }
              //NOTES
              if(isset($arr['notes'])){
                $rowData["notes"] = $r[$arr['notes']];
              } else {
                $rowData["notes"] = "";
              }
              //Address / Home details
              //Rent or Own
              $rowData["rentown"] = "";
              $rentown="";
              if(isset($arr['rentown'])){
                if( strtolower($r[$arr['rentown']])=="r" ||  strtolower($r[$arr['rentown']])=="rent" ||  strtolower($r[$arr['rentown']])=="renter" || strtolower($r[$arr['rentown']])=="non-homeowners" ){
                	//Set to INVALID if No Renters is checked
                  $rowData["rentown"] = "R";
                  $rentown = "R";
                } else if( strtolower($r[$arr['rentown']])=="o" ||   strtolower($r[$arr['rentown']])=="own" ||   strtolower($r[$arr['rentown']])=="owner" ||  strtolower($r[$arr['rentown']])=="homeowner"){
                  $rowData["rentown"] = "O";
                  $rentown = "O";
                } 
              } else {
                $rowData["rentown"] = "";
                $rentown = "";
              }

              //Age and income details
              if(isset($arr['age_range'])){
                $rowData["age_range"] = $r[$arr['age_range']];
              } else {
                $rowData["age_range"] = "";
              }
              if(isset($arr['income'])){
                $rowData['income'] = $r[$arr['income']];
              } else {
                $rowData['income'] = '';
              }

              if(isset($arr['yrs'])){
                  $rowData["yrs"] = $r[$arr['yrs']];
              } else {
                $rowData["yrs"] = "";
              }
              //Check for address
              if(isset($arr['address'])){
                $rowData["address"] = $r[$arr['address']];
              }  else {
                $rowData["address"] = "";
              }
              //Check for postal code
              if(isset($arr['postalcode'])){
                $rowData["postalcode"] = $r[$arr['postalcode']];
              } else {
                $rowData["postalcode"] = "";
              }
              //Male or female
              if(isset($arr['sex'])){
                if(strtolower($r[$arr['sex']])=="m" || strtolower($r[$arr['sex']])=="male") {
                	 $rowData["sex"] = "male";
                } else if (strtolower($r[$arr['sex']])=="f" || strtolower($r[$arr['sex']])=="female"){
                	 $rowData["sex"] = "female";
                } else {
                	 $rowData["sex"] = "";
                }
              } else {
                $rowData["sex"] = "";
              }

              //Check for lat lng
              if(isset($arr['lat'])){
                $rowData["lat"] = $r[$arr['lat']];
              } else {
                $rowData["lat"] = "";
              }
              if(isset($arr['lng'])){
                $rowData["lng"] = $r[$arr['lng']];
              } else {
                $rowData["lng"] = "";
              }
              //Check for province / State
              if(isset($arr['province'])){
                $rowData["province"] = $r[$arr['province']];
              } else {
                $rowData["province"] = "";
              }
              // Apply chosen city, or city from file
              // City details
              if(!empty($city) && isset($city)){
                $rowData["city"] = $city;
              } else {
                if(isset($arr['city'])){
                  $rowData["city"] = $r[$arr['city']];
                } else {
                  $rowData["city"] = "No Assigned City";
                }
              }
              //Extra details
              if(isset($arr['smoke'])){
                if($r[$arr['smoke']]=="Y" || $r[$arr['smoke']]=="Yes" || $r[$arr['smoke']]=="yes"){
                  $rowData["smoke"] =  "Y";
                } else {
                  $rowData["smoke"] =  "N";
                }
              } else {
                $rowData["smoke"] = "";
              }
              if(isset($arr['pets'])){
                 if($r[$arr['pets']]=="Y" || $r[$arr['pets']]=="Yes" || $r[$arr['pets']]=="yes"){
                  $rowData["pets"] =  "Y";
                } else {
                  $rowData["pets"] =  "N";
                }
              } else {
                $rowData["pets"] = "";
              }
              if(isset($arr['asthma'])){
                 if($r[$arr['asthma']]=="Y" || $r[$arr['asthma']]=="Yes" || $r[$arr['asthma']]=="yes"){
                  $rowData["asthma"] =  "Y";
                } else {
                  $rowData["asthma"] =  "N";
                }
              } else {
                $rowData["asthma"] = "";
              }
              if(isset($arr['married']) && !empty($arr['married'])){
                if($r[$arr["married"]]=="S"){
                  $rowData["married"] = "single";
                } else if($r[$arr["married"]]=="w"){
                  $rowData["married"] = "widowed";
                } else if($r[$arr["married"]]=="W"){
                  $rowData["married"] = "widowed";
                } else if($r[$arr["married"]]=="WID"){
                  $rowData["married"] = "widowed";
                } else if($r[$arr["married"]]=="SEP"){
                  $rowData["married"] = "seperated";
                } else if($r[$arr["married"]]=="sep"){
                  $rowData["married"] = "seperated";
                } else if($r[$arr["married"]]=="M"){
                  $rowData["married"] = "married";
                } else if($r[$arr["married"]]=="Married"){
                  $rowData["married"] = "married";
                } else if($r[$arr["married"]]=="Single"){
                  $rowData["married"] = "single";
                } else if($r[$arr["married"]]=="married"){
                  $rowData["married"] = "married";
                }  else if($r[$arr["married"]]=="single"){
                  $rowData["married"] = "single";
                } else if($r[$arr["married"]]=="C"){
                  $rowData["married"] = "commonlaw";
                } else if($r[$arr["married"]]=="C-LAW"){
                  $rowData["married"] = "commonlaw";
                } else if($r[$arr["married"]]=="D"){
                  $rowData["married"] = "divorced";
                } else if($r[$arr["married"]]=="DIV"){
                  $rowData["married"] = "divorced";
                } else if($r[$arr["married"]]=="div"){
                  $rowData["married"] = "divorced";
                } else {
                  $rowData["married"] = strtolower($r[$arr["married"]]);
                }
              } else {
                $rowData["married"] = "";
              };
              // Job details
              if(isset($arr['job']) && !empty($arr['job'])){
                $jobs = explode("/",$r[$arr['job']]);
                if(isset($jobs[0]) && !empty($jobs[0])){
                  $rowData["job"] = $jobs[0];
                } else {
                  $rowData["job"] = "";
                }
                if(isset($jobs[1]) && !empty($jobs[1])){
                  $rowData["spouse_job"] = $jobs[1];
                } else {
                  $rowData["spouse_job"] = "";
                }
              } else {
                $rowData["job"] = "";
                $rowData["spouse_job"]="";
              };

              if(isset($arr['jobyrs']) && !empty($arr['jobyrs'])){
                $jobYear = explode("/",$r[$arr['jobyrs']]);
                if(isset($jobYear[0]) && !empty($jobYear[0])){
                  $rowData["jobyrs"] = $jobYear[0];
                } else {
                  $rowData["jobyrs"] = "";
                }
                if(isset($jobYear[1]) && !empty($jobYear[1])){
                  $rowData["spouseyrs"] = $jobYear[1];
                } else {
                  $rowData["spouseyrs"] = "";
                }
              } else {
                $rowData["jobyrs"] = "";
                $rowData["spouseyrs"] = "";
              };

              if(isset($arr['fullpart'])){
                $rowData["fullpart"] = "";
                if (substr($r[$arr['fullpart']], 0, 2)==="FT"){
                  $rowData["fullpart"] = "FT";
                }
                if (substr($r[$arr['fullpart']], 0, 2)==="PT"){
                  $rowData["fullpart"] = "PT";
                }
                if (substr($r[$arr['fullpart']], 0, 1)==="R"){
                  $rowData["fullpart"] = "R";
                }
              } else {
                $rowData["fullpart"] = "";
              };

             
              
              if($checkphone==false){
                  $rowData["assign_count"] = 0;
                  if($set->no_renters==1 && $rentown=="R"){
                    $rowData["status"] = "INVALID";
                  } else {
                    if($leadtype=="survey"){
                      $rowData["status"] = "NEW";
                    } else {
                      $rowData["status"] = "INACTIVE";
                    }
                  }
              		$count++;
            	} else {
             		$rowData["assign_count"] = 99999;
                $rowData["status"] = "DELETED";
             		$duplicate++;
            	};

            //Apply data to an array
            $dataToInsert[] = $rowData;
          } else {
            $empty++;
        }
        } 

       
        if($type=="preview"){

          //Upload file to S3 for temp storage
          if(isset($input['s3TempFile'])){
            $theFile = $file;
          } else {
            $theFile = Input::file('csvfile');
            if($file){$input2 = S3::inputFile($file, false);}
            $path = $sc."/temp_uploads/".$filename;
            if(!empty($input2)){
              S3::putObject($input2, 'salesdash', $path, S3::ACL_PUBLIC_READ);
            }
          }
         
        	foreach($arr as $k=>$v){
        		$cols[] = $k;
        	}
        	if($leadtype=="paper"){
        		$leadtype2 = "Manilla / Paper Upload";
        	} else {
        		$leadtype2 = "Fresh Survey";
        	}
        	$uploadinfo = array(
        		"survey_date"=>$survey_date,
        		"leadtype"=>$leadtype2);
        	$html = View::make('plugins.uploadpreview')
          ->with('leads',$dataToInsert)->with('columns',$cols)
          ->with('info',$uploadinfo)->with('input',$input)->with('file',$path)
          ->render();
        	return Response::make($html);
        } else {
        	if(!empty($dataToInsert)){
          		$t = DB::table('leads')->insert($dataToInsert);
        	}
        	$msg="";
        	if($duplicate>0){$msg.="|<span class='label label-important special'> ".$duplicate. " Duplicates</span> were found and removed from batch";};
        	if(($count==0)&&($duplicate==0)){$msg = "The file format is invalid!";}
        	    $alert = Alert::find(5);
        	    if($count!=0){
        	      $alert->message = $count. " new leads were uploaded from an .XLS by ".Auth::user()->firstname." ".Auth::user()->lastname." on ".date('M-d')." ".$msg;
        	      $alert->color = "success";
        	      $alert->icon = "cus-book-next";
        	    } else {
        	      $alert->message = "Batch Lead upload by ".Auth::user()->firstname." failed.  || ".$msg;
        	      $alert->color = "danger";
        	      $alert->icon = "cus-stop";
        	      Session::flash('batchfail','Batch Lead upload by '.Auth::user()->firstname.' failed.  || '.$msg);
        	    }	
        	    $alert->save();
        	    return Redirect::to('lead');
        	}

      }

  
    	public function action_batchload33(){
        //Initialize
        $input = Input::all();
        $filename = Input::file('csvfile.name');
	      $tmp = Input::file('csvfile.tmp_name');
        $file = $tmp;
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';
        $xls = PHPExcel_IOFactory::load($file);
        $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
        $count=0;
        $duplicate=0;
        $empty=0;
        $sc = Setting::find(1)->shortcode;


        //Variables to inputs
	      $researcher = Input::get('researcher');
        $survey_date = Input::get('survey_date');
        $city = Input::get('leadcity');
        if(empty($city)){
          $type = "quadrants";
        } else {
          $type = "city";
        }
        $quad = "";

		    if(!empty($researcher)){
			     $user = $researcher;
		      } else {
			     $user = 0;
		    }

        if(empty($survey_date)){
          $suvey_date = date('Y-m-d');
        }

        //Check if CITY UPLOAD is chosen, and if so, make sure a city is chosen
        if($type=="city"){
          if(empty($city)){
            $alert = Alert::find(5);
            $alert->message = "You must select a city to upload leads!!";
            $alert->color = "danger";
            $alert->icon = "cus-stop";
            $alert->save();
            Session::flash('nocity','You need to assign a city to the leads you are trying to upload!');
            return Redirect::back();
          } 
        } 


        if($sc=="quality" || $sc=="quality2") {
        	foreach($rows as $r){
		  		  if(1 === preg_match('~[0-9]~', $r['B'])){
              $numcheck= str_replace(array( '(', ')' ), '', $r['B']);
              $numcheck = str_replace("-","",$numcheck);
              $numcheck = str_replace(" ","",$numcheck);
              $num = substr($numcheck,0,3)."-".substr($numcheck,3,3)."-".substr($numcheck,6,4);
				
					    $checkphone = Lead::where('cust_num','=', $num)
					    ->where('original_leadtype','=','paper')
					    ->first();
				
						  if(!$checkphone){
						  	$lead = New Lead;
                $lead->leadtype = "paper";
                $lead->original_leadtype = "paper";
						  	$lead->quad_id = $quad;
                $lead->researcher_id = Auth::user()->id;
                $lead->researcher_name = "Upload/Manilla";
                $lead->manilla_researcher = $user;
                $lead->address = $r['C'];
                $lead->birth_date = $survey_date;
			          $lead->entry_date = date('Y-m-d');
                $lead->cust_name = $r['A'];
                $lead->cust_num = $num;  
                          			
                if(!empty($r['D'])){ 
                  if(($r['D']=="None")||($r['D']=="No")){
                    $lead->smoke = "N";
                  } else {
                    $lead->smoke = "Y";
                  }
                } else {
                  $lead->smoke = "N";
                }
                          			
                if(!empty($r['F'])){ 
                  if(($r['F']=="None")||($r['F']=="No")){
                    $lead->asthma = "N";
                  } else {
                  	$lead->asthma = "Y";
                  }
                } else {
                  $lead->asthma = "N";
                }
                          			
                if(!empty($r['E'])){ 
                	if(($r['E']=="None")||($r['E']=="No")){
                		$lead->pets = "N";
                	} else {
                		$lead->pets = "Y";
                	}
                } else {
                  $lead->pets = "N";
                }
                
                $lead->city = $city;

                if($r['I']=="Owner"){
			         	 $lead->rentown = "O";
			         	 $lead->status = "INACTIVE";
			          } else {
			         	  $lead->rentown = "R";
			         	  $lead->status="INVALID";
			          }

		            if(!empty($r['J'])){
		             	$lead->fullpart = $r['J'];
		            }
  
                if(!empty($r['J'])){
                	$lead->job = $r['J'];
                }
                          			
                if(!empty($r['G'])){
                  $lead->married = strtolower($r['G']);
                } else {
                  $lead->married="single";
                }
							  $test = $lead->save();
                if($test){$count++;}
  					  }	else {
  						$duplicate++;
  					  }
  				  } else {
  				  	$empty++;
  				  }
    			}
        } else if($sc=="foxv" || $sc=="cyclo" || $sc=="ribmount"){
          foreach($rows as $r){
            if(!empty($r['C']) && $r['C']!='Phone' && $r['C']!='Phone Number') {
            	$cust_name = $r['A']." ".$r['B'];
        		$number = str_replace("(","",$r['C']);
        		$number = str_replace(")","",$number);
        		$number = str_replace("-","",$number);
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
                  if(!empty($r['C'])){
                      $lead = New Lead;
                      $lead->leadtype = "survey";
                      $lead->original_leadtype = "survey";
                      $lead->researcher_id = Auth::user()->id;
                      $lead->researcher_name = "Upload/Manilla";
                      $lead->manilla_researcher = $user;
                      $lead->status="NEW";
                      $lead->entry_date = date('Y-m-d');
                      $lead->cust_name = $cust_name;
                      $lead->cust_num = $num;
                      $lead->smoke = "N"; 
                      $lead->pets = "N";  
                      $lead->asthma = "N"; 
                      if(isset($city)&&!empty($city)){
                      	$lead->city = $city;
                      } else {
                      	$lead->city = $r['E'];;
                      }       
                      
                      $lead->address = $r['D'];
                      if(isset($r['F'])){
                        $lead->province = $r['F'];
                      }

                      if(isset($r['G'])){
                        $lead->postalcode = $r['G'];
                      }

                      if(isset($r['I'])){
                        $lead->married = strtolower($r['I']);
                      }

                      if(isset($r['J'])){
                        $lead->age_range = $r['J'];
                      }

                      if(isset($r['M'])){
                        if($r['M']=="Homeowner"){
                          $lead->rentown = "O";
                        } else {
                          $lead->rentown = "R";
                        }

                      }

                      if(isset($r['R']) && isset($r['S'])){
                        $lead->lat = $r['R']; $lead->lng = $r['S'];
                      }

                      
                      $test = $lead->save();
                    if($test){$count++;}
                  }
                } else {
                  $duplicate++;
                }
            } else {
            	$empty++;
            }
          }
        } else if($sc=="mdhealth" || $sc=="mdhealth2"){
        	foreach($rows as $r){
            if(!empty($r['G']) && $r['G']!="Phone"){
            	$cust_name = $r['A']." ".$r['B'];
        		$number = str_replace("(","",$r['G']);
        		$number = str_replace(")","",$number);
        		$number = str_replace("-","",$number);
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
                  if(!empty($r['G'])){
                      $lead = New Lead;
                      $lead->leadtype = "survey";
                      $lead->original_leadtype = "survey";
                      $lead->researcher_id = Auth::user()->id;
                      $lead->researcher_name = "Upload/Manilla";
                      $lead->manilla_researcher = $user;
                      $lead->status="NEW";
                      $lead->entry_date = date('Y-m-d');
                      $lead->cust_name = $cust_name;
                      $lead->cust_num = $num;
                      $lead->smoke = "N"; 
                      $lead->pets = "N";  
                      $lead->asthma = "N"; 
                      $lead->rentown = "";        
                      if(isset($city)&&!empty($city)){
                      	$lead->city = $city;
                      } else {
                      	$lead->city = $r['D'];
                      }
                      $lead->province = $r['E'];      
                      $lead->address = $r['C'];
                      $lead->postalcode = $r['F'];
                      $test = $lead->save();
                    if($test){$count++;}
                  }
                } else {
                  $duplicate++;
                }
            } else {
            	$empty++;
            }
          }
        } else {
          //IF NOT QUALITY-AIR
        	foreach($rows as $val){
            if(is_numeric($val['A'])){
              if(!empty($val['E'])){

                $job = explode("/", $val['L']);
                $occupation = explode("/", $val['K']);
                $jobyears = explode("/", $val['M']);
                if($type=="quadrants"){
                  $numcheck = substr(str_replace("-","",$val['C']),0, 6);
                  $exists = Quadrant::where('exchange','=',$numcheck)->get('city_id');
                  if($exists){
                    $quad = $exists[0]->attributes['city_id'];
                    $city = City::find($exists[0]->attributes['city_id'])->cityname;
                  } else {  
                    $city = "No Assigned City";
                    $quad = "";
                  }
                }
                $number = str_replace("-","",$val['C']);
                $number = str_replace(" ","",$number);
                $num = substr($number,0,3)."-".substr($number,3,3)."-".substr($number,6,4);
					        
			$checkphone = Lead::where('cust_num','=', $num)
			->where('original_leadtype','=','paper')
			->first();
					
			if(!$checkphone){
                  $lead = New Lead;
                  $lead->leadtype = "paper";
                  $lead->original_leadtype = "paper";
			$lead->quad_id = $quad;
                  $lead->researcher_id = Auth::user()->id;
                  $lead->researcher_name = "Upload/Manilla";
                  $lead->manilla_researcher = $user;
                  if($val['H']=="R"){
                  	if($sc=="be"){
                  		$lead->status="INACTIVE";
                  	} else {
                  		$lead->status="INVALID";
                  	}
                  } else {
                  	$lead->status = "INACTIVE";
                  }
			$lead->entry_date = date('Y-m-d');
                  $lead->birth_date = $survey_date;
                  $lead->cust_name = $val['B'];
                  $lead->cust_num = $num;     
                  $lead->smoke = $val['D'];
                  $lead->pets = $val['E'];
                  $lead->asthma = $val['F'];
			            $lead->city = $city;
		              $lead->rentown = $val['H'];
                  $lead->yrs = $val['I'];

                  if(!empty($job[0])){
                  	$lead->fullpart = $job[0];
                  }
                  if(!empty($job[1])){
                  	$lead->spousefullpart = $job[1];
                  }
                  if(!empty($occupation[0])){
                  	$lead->job = $occupation[0];
                  }
                  if(!empty($occupation[1])){
                  	$lead->spouse_job = $occupation[1];
                  }
                  if(!empty($jobyears[0])){
                  	$lead->jobyrs = $jobyears[0];
                  }
                  if(!empty($jobyears[1])){
                  	$lead->spouseyrs = $jobyears[1];
                  }
                  if($val['J']=="S"){
                  	$lead->married = "single";
                  }elseif($val['J']=="M"){
                  	$lead->married = "married";
                  } elseif($val['J']=="D"){
                    $lead->married = "divorced";
                  } elseif($val['J']=="C"){
                    $lead->married = "commonlaw";
                  }

							      $test = $lead->save();
                    if($test){$count++;}
				   		  } else {
				if(($checkphone->status=="NI")&&($checkphone->entry_date<date('Y-m-d',strtotime('-9 Months')))){
				$lead = New Lead;
                    	$lead->leadtype = "paper";
                    	$lead->original_leadtype = "paper";
				$lead->quad_id = $quad;
                    $lead->researcher_id = Auth::user()->id;
                    $lead->researcher_name = "Upload/Manilla";
                    $lead->manilla_researcher = $user;
                    if($val['H']=="R"){
                    	if($sc=="be"){
                    		$lead->status="INACTIVE";
                    	} else {
                    		$lead->status="INVALID";
                    	}
                    } else {
                    	$lead->status = "INACTIVE";
                    }
							      $lead->entry_date = date('Y-m-d');
                    $lead->birth_date = $survey_date;
                    $lead->cust_name = $val['B'];
                    $lead->cust_num = $num;     
                    $lead->smoke = $val['D'];
                    $lead->pets = $val['E'];
                    $lead->asthma = $val['F'];
			            	$lead->city = $city;
		                $lead->rentown = $val['H'];
                    $lead->yrs = $val['I'];
                    if(!empty($job[0])){
                    	$lead->fullpart = $job[0];
                    }
                    if(!empty($job[1])){
                    	$lead->spousefullpart = $job[1];
                    }
                    		if(!empty($occupation[0])){
                    	$lead->job = $occupation[0];
                    }
                    if(!empty($occupation[1])){
                    	$lead->spouse_job = $occupation[1];
                    }
 								    if(!empty($jobyears[0])){
                    	$lead->jobyrs = $jobyears[0];
                    }
                    if(!empty($jobyears[1])){
                    	$lead->spouseyrs = $jobyears[1];
                    }
                    if($val['J']=="S"){
                    	$lead->married = "single";
                    }elseif($val['J']=="M"){
                    	$lead->married = "married";
                    } elseif($val['J']=="D"){
                      $lead->married = "divorced";
                    } elseif($val['J']=="C"){
                      $lead->married = "commonlaw";
                    }

							      $test = $lead->save();
                    if($test){$count++;}
				   			  } else {
				   				  $duplicate++;
				   			  }
				   		  }
              }
            }
        	}
        };
          $msg="";
        if($duplicate>0){$msg.="|<span class='label label-important special'> ".$duplicate. " Duplicates</span> were found and removed from batch";};
        if($empty>0){$msg.=" | <span class='label label-info special'>".$empty." Empty Phone Numbers </span> were found, and not uploaded";} 

 		    if(($count==0)&&($duplicate==0)){$msg = "The file format is invalid!";}
       	    $alert = Alert::find(5);
        		if($count!=0){
        			$alert->message = $count. " new leads were uploaded from an .XLS by ".Auth::user()->firstname." ".Auth::user()->lastname." on ".date('M-d')." ".$msg;
        			$alert->color = "success";
        			$alert->icon = "cus-book-next";
        		} else {
        			$alert->message = "Batch Lead upload by ".Auth::user()->firstname." failed.  || ".$msg;
        			$alert->color = "danger";
        			$alert->icon = "cus-stop";
        			Session::flash('batchfail','Batch Lead upload by '.Auth::user()->firstname.' failed.  || '.$msg);
        		}
        	  $alert->save();
        	  return Redirect::to('lead');
    	}

    	public function getcount($status){
        	$date = date('Y-m-d');
        	return Lead::where('status','=',$status)
        		->where('booker_id','=',Auth::user()->id)
        		->where('call_date','=',$date)
        		->count();
    	}

      public function action_processsurvey(){
        $input = Input::get();
        $id = Input::get('leadid');
        $status = Input::get('status');
        $name = Input::get('name');
        $address = Input::get('address');
        $url = Input::get('fullURL');
        $u = User::find(Auth::user()->id);

          if(isset($input['call_length'])){
            $length = $input['call_length'];
          } else {
            $length = "00:00:00";
          }

          $lead = Lead::find($id);
          if(!empty($address)){
            $lead->address = $address;
          }
          $lead->cust_name = $name;
          $lead->call_date = date('Y-m-d H:i:s');
          $lead->call_length = $length;
          if(isset($input['smoke'])){
            $lead->smoke="Y";
          }
          if(isset($input['pets'])){
            $lead->pets="Y";
          }
          if(isset($input['asthma'])){
            $lead->asthma="Y";
          }
          if(isset($input['air_purifier'])){
            $lead->has_purifier=1;
          }
          $lead->sex = $input['sex'];
          $lead->spouse_name = $input['spousename'];
          $lead->job = $input['job'];
          if($input['rentown']=="R"){
            if(Setting::find(1)->no_renters==1){
              $status="INVALID";
            }
          }
          $lead->notes = $input['notes'];
          $lead->rentown = $input['rentown'];
          $lead->jobyrs = $input['jobyrs'];
          $lead->fullpart = $input['fullpart'];
          if($input['fullpart']=="R"){
            $lead->job = "Retired";
          }
          $lead->married = $input['marriagestatus'];
          $lead->age_range = $input['age_range'];

          if($status=="APP"){
              $time = Input::get('booktimepicker');
              $time =  date('H:i',strtotime($time));
              $lead->booked_at = date('Y-m-d H:i:s');
              $lead->app_date = Input::get('appdate');
              $lead->app_time = $time;
              $lead->result = "APP";
              $city = $lead->city;
            

              $appt = New Appointment;
              $appt->lead_id = $id;
              $appt->app_date = Input::get('appdate');
              $appt->researcher_id = $lead->researcher_id;
              $appt->app_time = $time;
              $appt->booked_at = date('Y-m-d H:i:s');
              $appt->city = $city;
              $appt->booked_by = Auth::user()->firstname." ".Auth::user()->lastname;
              $appt->booker_id = Auth::user()->id;
              $appt->status = "APP";
              $appt->save();
              if(Setting::find(1)->games==1){
                $t = "<br/>They earned 1 Credit, and 3 spins on the slot machine!!";
              } else {
                $t = "";
              }
              GameHistory::writeHistory(1,$appt,"BOOK",$u->id);
              $alert = Alert::find(5);
              $alert->message = "NEW DEMO BOOKED BY ".Auth::user()->firstname."!!  |  ".ucfirst($lead->cust_name)."'s Demo is on ".$lead->app_date." @ ".$lead->app_time.$t;
              $alert->color = "success";
              $alert->icon = "cus-book-next";
              $alert->save();
        } else if($status=="INACTIVE" || $status=="INVALID"){
            $lead->assign_count = 0;
            $lead->booker_id=0;
            $lead->booker_name="";
            $lead->leadtype = "secondtier";
            $lead->original_leadtype="secondtier";
            $lead->researcher_name = Auth::user()->fullName();
            $lead->researcher_id = Auth::user()->id;
            $lead->birth_date = date('Y-m-d');
          } else {
            $lead->assign_count = $lead->assign_count+1;
          }

          $lead->status = $status;
          $lead->save();

          $call = New Call;
          $call->lead_id = $lead->id;
          $call->leadtype = "survey";
          $call->caller_id = Auth::user()->id;
          $call->length = $length;
          $call->caller_name = Auth::user()->firstname;
          $call->phone_no = $lead->cust_num;
          $call->result = $status;
          $call->created_at = date('Y-m-d H:i:s');
          $call->save();
          $u->incrementCall();
          $u->save();
          if($status=="INACTIVE"){
            if(($lead->lat==0)&&(!empty($lead->address))){
                $this->getlatLong(urlencode($lead->address),$lead->id);
            }
          }
          

          if(isset($input['json_form'])){
            return json_encode($lead);
          } else {
            return Redirect::to($url);
          }
      }

    	public function action_processlead(){
    		$input = Input::get();
    		$id = Input::get('leadid');
        $url = Input::get('fullURL');
        $status = Input::get('status');

          if(isset($input['json_form'])){
            $appcheck = Appointment::where('lead_id','=',Input::get('leadid'))
            ->where('app_date','=',Input::get('appdate'))->first();

            if($appcheck){
              return Response::json("alreadyexists");
            }
          }
          

        	$u = User::find(Auth::user()->id);
        	if(isset($input['call_length'])){
        		$length = $input['call_length'];
        	} else {
        		$length = "00:00:00";
        	}
        	$lead = Lead::find($id);
        	
        	if($status=="Recall"){
            	$lead->recall_date = Input::get('recalldate');
        	}


    		$address = Input::get('address');
    		$notes = Input::get('notes');
    		if(!empty($notes)){
    			$lead->notes = $notes;
    		}
        	

        	if(!empty($address)){
        		$lead->address = $address;
        	} 
        	
        	if($status=="APP"){
            	$time = Input::get('booktimepicker');
    			$time =  date('H:i',strtotime($time));
            	$lead->booked_at = date('Y-m-d H:i:s');
            	$lead->app_date = Input::get('appdate');
            	$lead->app_time = $time;
            	$lead->result = "APP";
            	$city = $lead->city;
	
            	
            	$u->credits = $u->credits+1;
            	if($u->spins+3>=10){
            		$msg = 10-$u->spins." Spins";
            		$u->spins = 10;
            	} else {
            	 	$u->spins = $u->spins+3;
            		$msg = "3 Spins";
            	}
            	Session::flash('AppBook','Congratulations!  You earned 1 Credit, and '.$msg.'!');

            	$appt = New Appointment;
            	$appt->lead_id = $id;
            	$appt->app_date = Input::get('appdate');
              	$appt->researcher_id = $lead->researcher_id;
            	$appt->app_time = $time;
            	$appt->booked_at = date('Y-m-d H:i:s');
            	$appt->city = $city;
            	$appt->booked_by = Auth::user()->firstname." ".Auth::user()->lastname;
            	$appt->booker_id = Auth::user()->id;
            	$appt->status = "APP";
            	$appt->save();
            	if(Setting::find(1)->games==1){
            		$t = "<br/>They earned 1 Credit, and 3 spins on the slot machine!!";
            	} else {
            		$t = "";
            	}
            	
            	GameHistory::writeHistory(1,$appt,"BOOK",$u->id);
            	$alert = Alert::find(5);
            	$alert->message = "NEW DEMO BOOKED BY ".Auth::user()->firstname."!!  |  ".ucfirst($lead->cust_name)."'s Demo is on ".$lead->app_date." @ ".$lead->app_time.$t;
            	$alert->color = "success";
            	$alert->icon = "cus-book-next";
            	$alert->save();
      	}
        	
        	$lead->status = $status;
        	if($status=="NQ"){
        		$reason = Input::get('nqreason');
        		if($reason=="renter"){
        			$lead->rentown = "R";
        			$lead->status = "INVALID";
        		}
        		$lead->nqreason = $reason;
        	}
        	if($status=="WrongNumber"){
        		$lead->nqreason = Input::get('wrongreason');
        	}
        	$lead->call_date = date('Y-m-d H:i:s');
          	$lead->assign_count = $lead->assign_count+1;
        	$lead->call_length = $length;
        	$lead->save();

        	$call = New Call;
        	$call->lead_id = $lead->id;
        	$call->leadtype = $lead->original_leadtype;
        	$call->caller_id = Auth::user()->id;
        	$call->length = $length;
        	$call->caller_name = Auth::user()->firstname;
        	$call->phone_no = $lead->cust_num;
        	$call->result = $status;
        	$call->created_at = date('Y-m-d H:i:s');
        	$call->save();
        	$u->incrementCall();
        	$u->save();
	
        	if(($lead->lat==0)&&(!empty($lead->address))){
        		$this->getlatLong(urlencode($lead->address),$lead->id);
        	}

        	if(isset($input['json_form'])){
        		return json_encode($lead);
        	} else {
        		return Redirect::to($url);
        	}
    	}

    	public function action_leadinfo($id){
    		$l = Lead::find($id);
    		if($l){
    			return View::make('plugins.leadinfo')
    			->with('lead',$l);
    		}

    	}

    	public function action_newlead($num=null){

        	if($num!=null){
        	    $input = array("phonecheck"=>$num);
        	} else {
        	    $input = Input::get();
        	}
   	
        	$getlead="";
        	$calls="";
        	
        	$cities = City::where('status','!=','leadtype')->order_by('cityname','asc')->get();

        		if(!empty($input['phonecheck'])){
            		if($this->validatephone($input['phonecheck'])){
            	    		$getlead = Lead::where('cust_num','=', $input['phonecheck'])->first();
            	    		if(!empty($getlead)){
            	    			$calls = Lead::find($getlead->attributes['id'])->calls;
            	    		} else {
            	        		$getlead = New Lead;
            	            	$getlead->cust_num = $input['phonecheck'];
            	                  $calls = "";
            	        	}
            		} else {
			            return View::make('leads.enternew')
            	    		->with('notvalid', true);
            		}
        		}
        	$thescripts=array();
        	if(!empty($num)){
	        	$thescripts = Script::getScripts($getlead);
	       }
		
        	return View::make('leads.enternew')
        		->with('thelead',$getlead)
        		->with('cities',$cities)
        		->with('thescript',$thescripts)
        		->with('calls',$calls);
    	}

    	public function action_delete($id=null){
    		if(isset($id)){
    			$theid = $id;
    		} else {
    			$theid = Input::get('id');
    		}
        $input = Input::get();
        $lead = Lead::find($theid);
        if(isset($input['duplicate'])&&($input['duplicate']==true)){
          $lead->status="DELETED";
          $lead->assign_count=99999;
          $lead->save();
          return Response::json("duplicate");
        }

     		
     		if($lead){
     			if(!empty($lead->sale)){
     				return Response::json("sale");
     			}
     			if(!empty($lead->appointments)){
     				return Response::json("app");
     			}
     			if(!empty($lead->calls)){
     				$lead->status="DELETED";
     				$lead->assign_count=20;
     				$lead->save();
     				return Response::json("calls");
     			}
     			
     			if($lead->delete()){
        			return Response::json($theid);
     			};
     		}
    	}


    	public function action_updatelead(){
        	$input = Input::get();
     
        	$rules = array(
            	"name"=>"required",
            	"custnum"=>"required|min:12|max:12",
            	"city"=>"required",
            	"leadtype"=>"required",
            	"status"=>"required"
            );

        	$v = Validator::make($input, $rules);

        	if($v->fails()){
           		return Redirect::to('lead/newlead/'.$input['custnum'])->with_input()->with_errors($v);
        	} else {
        		if($input['id']=="new"){
            		$lead = New Lead;
            		if(($input['leadtype']!="door")&&($input['leadtype']!='paper')&&($input['leadtype']!='rebook')){
            			$lead->original_leadtype=$input['leadtype'];
            			$lead->researcher_name = Auth::user()->fullName();
            			$lead->researcher_id = Auth::user()->id;
            			$lead->entry_date = date('Y-m-d');
            			$lead->status = "NEW";
            		}
        		} else {
        			$lead = Lead::find($input['id']);
        		}

            if($input['bookChange']=="true"){
              $lead->booker_id = Auth::user()->id;
              $lead->booker_name = Auth::user()->fullName();
            }


            if($input['leadtype']!='rebook'){
              $lead->original_leadtype = $input['leadtype'];
            }
        		$lead->leadtype = $input['leadtype'];
        		$lead->cust_name = $input['name'];
        		$lead->cust_num = $input['custnum'];
        		$lead->spouse_name = $input['spouse'];
        		$lead->city = $input['city'];
        		$lead->address = $input['address'];
        		$lead->homestead_type=$input['homestead'];
            $lead->sex=$input['sex'];
       			if($input['status']!="donotchange"){
       				$lead->status = $input['status'];
       			}

        			if($lead->status=="Recall"){
            			$lead->recall_date = $input['recalldate'];
                  $call = New Call;
                  $call->lead_id = $lead->id;
                  $call->leadtype = $lead->leadtype;
                  $call->caller_id = Auth::user()->id;
                  $call->caller_name = Auth::user()->firstname;
                  $call->phone_no = $lead->cust_num;
                  $call->created_at = date('Y-m-d H:i:s');
                  $call->result = "Recall";
                  $call->save();
        			}

        		$lead->gift = $input['gift'];
        		$lead->call_date = date('Y-m-d');
        		$lead->notes = $input['notes'];
        		$lead->save();

        		if(!empty($input['address'])){
            			$this->getlatLong(urlencode($input['address']),$lead->id); 
            }
        
        		if(($input['status']=="APP")){
    				    $time =  date('H:i',strtotime($input['booktimepicker']));
            		$lead->booked_at = date('Y-m-d H:i:s');
            		$lead->app_date = $input['appdate'];
            		$lead->app_time = $time;
            		$lead->result = "APP";

            		$call = New Call;
            		$call->lead_id = $lead->id;
            		$call->leadtype = $lead->leadtype;
            		$call->caller_id = Auth::user()->id;
            		$call->caller_name = Auth::user()->firstname;
            		$call->phone_no = $lead->cust_num;
            		$call->created_at = date('Y-m-d H:i:s');
            		$call->result = "APP";
            		$call->save();
		
            		$appt = New Appointment;
            		$appt->lead_id = $lead->id;
            		$appt->app_date = $input['appdate'];
            		$appt->app_time = $time;
            		$appt->city = $input['city'];
            		$appt->booked_at = date('Y-m-d H:i:s');
            		$appt->booked_by = Auth::user()->fullName();
            		$appt->booker_id = Auth::user()->id;
            		$appt->status = "APP";
            			if($appt->save()){
                				$alert = Alert::find(5);
                				$alert->message = "APPOINTMENT BOOKED : ".Auth::user()->firstname." ".Auth::user()->lastname." has booked an appointment for ".$lead->app_date." at ".$lead->app_time;
                				$alert->color = "success";
                				$alert->icon = "cus-clipboard-sign";
                				$alert->save();
            			};
       		}
        
        		$check = $lead->save();

        		if($check){
           			if($lead->status=="APP"){
            			return Redirect::to('appointment/'.'?date='.$lead->app_date);
           			} else {
            			return Redirect::to('lead/newlead');
           			}
        		}
        	}
      }

      public function action_getleads(){
      	$input = Input::get();
      	$city = $input['city'];
      	$type = $input['type'];
      	$skip = $input['skip'];
      	$take = $input['take'];

      	if($type=="NEW"){$t="Available ";}else if($type=="ASSIGNED"){$t="Assigned ";} else if($type=="NI"){
      		$t="Not Interested ";
      	} else if($type=="NQ"){$t="Not Qualified ";}else if($type=="DNC"){$t="Do Not Call";}elseif($type=="INACTIVE"){$t="Unreleased ";} elseif($type=="ALL"){$t="All Leads";} else {$t="Default ";}
        if($type=="ALL"){
          $leads = Lead::where('city','=',$city)->skip($skip)->take($take)->order_by('entry_date','ASC')->get();
          $leadcnt = Lead::where('city','=',$city)->order_by('assign_count','ASC')->count();
        } else {
          $leads = Lead::where('city','=',$city)->where('status','=',$type)->skip($skip)->take($take)->order_by('entry_date','ASC')->get();
        $leadcnt = Lead::where('city','=',$city)->where('status','=',$type)->order_by('assign_count','ASC')->count();
        }
      	$bookers = User::where('level','!=',99)->where('user_type','=','agent')->or_where('user_type','=','doorrep')->or_where('user_type','=','researcher')->order_by('firstname','ASC')->get();
      	
      	$cities = City::where('status','!=','leadtype')->get();
      	$databuttons = "data-city='".$city."' data-type='".$type."' data-script='getleads'";
      	
      	$pagination = $leadcnt/$take;
      	$page = intval($skip/$take);
      	$ltitle = "for <font style='color:#000;'>".$city." (".$t.")</font> returned  <font style='color:#000;'>".$leadcnt."</font> Results";
        	$stitle = "for <font style='color:#000;'>".$city." (".$t.")</font> returned  <font style='color:#000;'>".$leadcnt."</font> Results";
      	
      	return View::make('plugins.searchleads')
        	->with('type',$type)
      	->with('salecount',0)
      	->with('pagenum',$page)
      	->with('page',$pagination)
      	->with('leads',$leads)
      	->with('cnt',$leadcnt)
      	->with('city',$city)
      	->with('stitle',$stitle)
      	->with('ltitle',$ltitle)
      	->with('databuttons',$databuttons);
      }

    	public function action_viewlead($id){
    		$lead = Lead::with(array('calls','appointments'))->find($id);
    		return json_encode($lead);
    	}

    	public function action_edit(){
    		$input = Input::get();
	 	$x = explode("|", $input['id']);
		$lead = Lead::find($x[1]);
		if($x[0]=="entry_date"){
			$input['value'] = date('Y-m-d',strtotime($input['value']));
		}
		$lead->$x[0] = $input['value'];
		$test = $lead->save();
		if($test){echo $input['value'];} else {echo "Save Failed!";}
    	}

}


