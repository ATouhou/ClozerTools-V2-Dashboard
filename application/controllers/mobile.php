<?php
class Mobile_Controller extends Base_Controller
{
	public function __construct(){
        parent::__construct();
        $this->filter('before','auth');
  	}
    
        // *** ACTUAL VIEWABLE PAGES
    public function action_dashboard(){
      return Redirect::to('mobile/'.Auth::user()->user_type);
    }

    public function action_doorrep(){

      $cities = City::where('status','!=','leadtype')->order_by('cityname')->get();
      $wrongnums = Lead::where('status','=','WrongNumber')->where('researcher_id','=',Auth::user()->id)->get();
      $current =  DB::query("SELECT * FROM leads WHERE researcher_id = '".Auth::user()->id."' AND DATE(created_at) = DATE('".date('Y-m-d')."') ORDER BY id DESC");
      $leads =  DB::query("SELECT * FROM leads WHERE researcher_id = '".Auth::user()->id."' AND DATE(created_at) < DATE('".date('Y-m-d')."') ORDER BY id DESC");
      
      return View::make('mobile.doorrep')
      ->with('todays',$current)
      ->with('allleads',$leads)
      ->with('wrongnums',$wrongnums)
      ->with('cities',$cities);
    }

    public function action_salesrep(){
        
        $machines = Inventory::where('checked_by','=',Auth::user()->firstname." ".Auth::user()->lastname)
        ->where('status','=','Checked Out')
        ->get();
        //$allsales = Auth::user()->sales;
        $weeksales = DB::query("SELECT SUM(payout) payout, SUM(price) price FROM sales WHERE user_id='".Auth::user()->id."' AND WEEK(date)=WEEK('".date('Y-m-d')."') AND YEAR(date)=YEAR(NOW()) ");
        $monthsales = DB::query("SELECT SUM(payout) payout, SUM(price) price FROM sales WHERE user_id = ".Auth::user()->id." AND MONTH(date) = MONTH('".date('Y-m-d')."') AND YEAR(date)=YEAR(NOW())");
        $yearsales = DB::query("SELECT SUM(payout) payout, SUM(price) price FROM sales WHERE user_id = ".Auth::user()->id." AND YEAR(date) = YEAR('".date('Y-m-d')."')");
        $pureop = DB::query("SELECT * FROM pureop WHERE id = '".Auth::user()->level."'");


        $monthmin = date('Y-m-1',strtotime('this month'));
        $monthmax = date('Y-m-d', strtotime('last day of this month'));
       

       $yearsalestats = Stats::saleStats("ALLTIME","","");
       $monthsalestats = Stats::saleStats("MONTH","","");
       $weeksalestats = Stats::saleStats("WEEK","","");

      $leads = Lead::where('researcher_id','=',Auth::user()->id)->order_by('entry_date')->order_by('cust_name')->get();

      return View::make('mobile.template')
      ->with('leads',$leads)
      ->with('user',Auth::user())
      ->with('pureop',$pureop)
      ->with('startdate',$monthmin)
      ->with('month',$monthsalestats)
      ->with('week',$weeksalestats)
      ->with('year',$yearsalestats)
      ->with('earnings',array("week"=>$weeksales,"month"=>$monthsales,"year"=>$yearsales))
      ->with('machines',$machines);

    }
    // END ACTUAL PAGES 




  	//*********AJAX LOADED PAGES ******* //
    public function action_invoice($id=null){
      if($id==null){
        $sales = Sale::where('user_id','=',Auth::user()->id)->where('invoice_id','=',0)->where('status','!=','CANCELLED')->where('status','!=','TBS')->get();
        $invoice = array();
      } else {
        $sales = Sale::where('user_id','=',Auth::user()->id)->where('invoice_id','=',0)->where('status','!=','CANCELLED')->where('status','!=','TBS')->get();
        $invoice = Dealerinvoice::find($id);
      }
      return View::make('mobile.modules.invoiceform')
        ->with('sales',$sales)
        ->with('invoice',$invoice);
    }

    public function action_viewinvoice($id){
      if($id==null){
        echo "SERVER ERROR";
      } else {
        $invoice=Dealerinvoice::find($id);
        return View::make('mobile.modules.viewinvoice')
        ->with('invoice',$invoice);
      }
    }

    public function action_getsale($id){
      if($id==null){
        return "SERVER ERROR";
      } else {
        $sale = Sale::find($id);
        if($sale){
          $inventory = Auth::user()->machines();
          return View::make('mobile.modules.saleform')
          ->with('sale',$sale)
          ->with('machines',$inventory);
        } else {
          return  "SERVER ERROR - SALE NOT FOUND";
        }
      }
    }

    public function action_appointments($date=null){
      if($date==null){
        $date = date('Y-m-d');
      } 
      $appts = Appointment::where('app_date','=',$date)->where('rep_id','=',Auth::user()->id)->order_by('app_time','DESC')->get();
      $nextapp = Appointment::where('app_date','=',$date)->where('rep_id','=',Auth::user()->id)->where('status','!=','SOLD')
      ->where('status','!=','DNS')->where('status','!=','INC')->order_by('app_time','DESC')->first();

      return View::make('mobile.modules.appointments')
      ->with('appts',$appts)
      ->with('nextapp',$nextapp);
    }

    public function action_sales(){
      $input = Input::get();
      if(empty($input)){
        $datemin = date('Y-m-1',strtotime('this month'));
        $datemax = date('Y-m-d', strtotime('last day of this month'));
        $type="all";
      } else {
        $type = $input['saletype'];
        $datemin = $input['start'];
        $datemax = $input['end'];
      }

      $day = date('w');
      $day = $day-1;
      $weekmin = date('m-d-Y', strtotime('-'.$day.' days'));
      $weekmax = date('m-d-Y', strtotime('+'.(6-$day).' days'));
      if($type=="pending"){
         $sales = Sale::where('user_id','=',Auth::user()->id)
         ->where('status','!=','COMPLETE')
         ->where('status','!=','PAID')
         ->where('status','!=','TURNDOWN')
         ->where('status','!=','CANCELLED')
         ->where('status','!=','TBS')
         ->where('date','>=',$datemin)
         ->where('date','<=',$datemax)
         ->order_by('date','DESC')
         ->get();
      } elseif($type=="cancelled"){
         $sales = Sale::where('user_id','=',Auth::user()->id)
         ->where('status','=','CANCELLED')
         ->where('date','>=',$datemin)
         ->where('date','<=',$datemax)
         ->order_by('date','DESC')
         ->get();
      } else {
        $sales = Sale::where('user_id','=',Auth::user()->id)
         ->where('status','!=','TURNDOWN')
         ->where('status','!=','CANCELLED')
         ->where('status','!=','TBS')
         ->where('status','!=','APPROVAL')
         ->where('status','!=','RETURN')
         ->where('date','>=',$datemin)
         ->where('date','<=',$datemax)
         ->order_by('date','DESC')
         ->get();
      }

      return View::make('mobile.modules.sales')
      ->with('sales',$sales)->with('type',$type);
    }

    public function action_invoices(){
      $invoices = Dealerinvoice::where('user_id','=',Auth::user()->id)->order_by('date_issued','DESC')->order_by('created_at','DESC')->get();

      return View::make('mobile.modules.invoices')
      ->with('invoices',$invoices);
    }

    public function action_salestats(){
      $input=Input::get();
      if(empty($input)){
        $datemin = date('Y-m-1',strtotime('this month'));
        $datemax = date('Y-m-d', strtotime('last day of this month'));
      } else {
        $datemin = $input['start'];
        $datemax = $input['end'];
      }

      $day = date('w');
      $day = $day-1;
      $weekmin = date('m-d-Y', strtotime('-'.$day.' days'));
      $weekmax = date('m-d-Y', strtotime('+'.(6-$day).' days'));
      $yearsalestats = Stats::saleStats('2012-01-01','2020-01-01',"");
      $monthsalestats = Stats::saleStats($datemin,$datemax,"");
      $weeksalestats = Stats::saleStats($weekmin,$weekmax,"");

      return View::make('mobile.modules.stats')
      ->with('startdate',$datemin)
      ->with('year',$yearsalestats)
      ->with('month',$monthsalestats)
      ->with('week',$weeksalestats);
    }
    //***END AJAX*******//


  	//USEFUL FUNCTION FOR MOBILE

    public function action_marktime(){
      $alert = Alert::find(10);
      $time = date('H:i:s');
      $input = Input::get();
      $type = $input['type'];
      $app = Appointment::find($input['appid']);
      
      $app = Appointment::find($input['appid']);
      if($app){
        if(isset($input['status'])){
          $app->status=$input['status'];
          $lead = Lead::find($app->lead_id);
          if($lead){
            $lead->result = $input['status'];
            $lead->save();
          }
        }
        $app->$type = $time;
        if($app->save()){
          $alert->message = Auth::user()->firstname." has checked ".$type." @ ".$time.", Refresh the board to update";
          $alert->seen = 0;
          $alert->save();
          return Response::json("success");
        } else {
          return Response::json("failed");
        }
        
      } else {
        return Response::json("failed");
      }

    }

  	public function action_assignleads(){
  		$input = Input::get();
    		$rules = array("leadtype"=>"required","booker"=>"required","city"=>"required");
    		$v = Validator::make($input, $rules);
    		if($v->fails()){

    		} else {
    			$type = Input::get('leadtype');
    			$booker = Input::get('booker');
    			$city = Input::get('city');
    			
    			$has = Lead::where('booker_id','=',$booker)
        		->where('status','=','ASSIGNED')
        		->get();

        		$u = User::find($booker);
        		if(!empty($u)) $name = $u->firstname." ".$u->lastname;

        		if(!empty($has)){
            		foreach($has as $val){
            	    		$val->booker_name = "";
            	    		$val->booker_id = "";
            	   		$val->assign_date = "";
            	    		$val->status = "NEW";
            	    		$val->save();
            		}
            	}

            	$leads = DB::query("SELECT * FROM leads WHERE city='".$city."' AND leadtype='".$type."' AND status='NEW' ORDER BY assign_count ASC LIMIT 20");
			
            	$recallcount = 0;
        		$count = 0;
        		foreach($leads as $val){
        		        		
            		if(($val->recall_date!="0000-00-00")&&(date('Y-m-d',strtotime($val->recall_date))>=date('Y-m-d'))){
            		$recallcount++;
            		} else { 
            			$count++;
            			$lead = Lead::find($val->id);
            			$lead->booker_name = $name;
            			$lead->booker_id = $booker;
            			$lead->assign_date = date('Y-m-d');
            			$lead->assign_time = date('H:m:s');
            			$lead->assign_count = $lead->assign_count+1;
            			$lead->status = "ASSIGNED";
            			$lead->save();
           			}
        		}
        	
        		$msg = "<span class='label label-info special'>".$count."</span> ".$type." LEADS ASSIGNED to ".$name." - From ".strtoupper($city)." - Assigned on ".date('H:m M-d');
        			if($recallcount>0){
            			$msg.="  || <span class='label label-important special'>".$recallcount ." not past RECALL DATE</span>";
        			}

        		$alert = Alert::find(6);
        		$alert->seen = 1;
        		$alert->save();

        		$alert = Alert::find(8);
        		$alert->message = "LAST BATCH OF LEADS : ".$msg;
        		$alert->color = "info";
        		$alert->icon = "cus-telephone";
        		$alert->save();
       
        		$data = DB::query("SELECT city, SUM(status = 'NEW' AND original_leadtype!='other') avail,
        			SUM(leadtype = 'paper' AND status = 'NEW') paper,
        			SUM(leadtype = 'door' AND status = 'NEW' ) door,SUM(leadtype = 'rebook' AND status = 'NEW') rebook 
        			FROM leads WHERE city = '".$city."'");
			
			return json_encode(array("data"=>$data,"message"=>$msg));

  		}
  	}


  	public function action_dispatchappt(){
  		$id = Input::get('theid');
    		$appt = Appointment::find($id);
    		$rep = User::find(Input::get('dispatchtorep'));
   		$status = Input::get('status');
    		$booker = Input::get('dispatchtobooker');

    		$input = Input::get();

    		if(!empty($id)){

      		$lead = Lead::find($appt->lead_id);

      	if(!empty($status)){
        		$appt->status = $status;
        		$lead->result = $status;
      	}

      	if(!empty($rep)){
        		$appt->rep_id = $rep->id;
        		$appt->rep_name = $rep->firstname." ".$rep->lastname;
        		$appt->status = "DISP";
        		$appt->dispatch_time = date("Y-m-d H:i:s");
        		$appt->save();
        		$lead->rep_name = $rep->firstname." ".$rep->lastname;
        		$lead->rep = Input::get('dispatchtorep');
        		$lead->result="DISP";

        		/*if(!empty($rep->cell_no)){
         		 $this->sendSMS($rep->cell_no, "NEW DEMO!! ".date('g:i a',strtotime($appt->app_time)). " - Customer : ".$lead->cust_name."and ".$lead->spouse_name." - ADDRESS : ".$lead->address." | GIFT : ".$lead->gift. "| Booked By : ".$lead->booker_name);
        		}*/
   
      	}

      	if(!empty($booker)){
        		$appt->bump_id = $booker;
      	}

      	$appt->save();
      	$lead->save();
    		}

    		return json_encode($appt);
	}

  public function action_savesale(){
    $input = Input::get();
    if(empty($input)){
      return Response::json("failed");
    } else {
      $sale = Sale::find($input['sale_id']);
      if($sale){
        $sale->price = $input['sale_price'];
        $sale->down_payment = $input['down_pay'];
        if($sale->typeofsale!=$input['typeofsystem']){
          $units = Sale::getUnits($input['typeofsystem']);
          $sale->typeofsale = $input['typeofsystem'];
          $app = Appointment::where('sale_id','=',$sale->id)->get();
          $app2 = Appointment::find($app[0]->attributes['id']);
          $app2->systemsale = $input['typeofsystem'];
          $app2->units = $units['tot'];
          $app2->save();
          $sale = Sale::removeItems($sale);
        }
        $sale->payment = $input['methodofpay'];
        $sale->deferal = $input['deferal'];
        $sale->interest_rate = $input['interest']; 
        if($sale->save()){
           return Response::json("success");
        }
      } else {
        return Response::json("nosale");
      }
    }
  }

  public function action_saveinvoice(){

    $input = Input::get();
    $rules = array('the-rep'=>'required');
        $v = Validator::make($input,$rules);
        if( $v->fails() ) {
                return Response::json("failed");
        }
    $invoice = $input['the-invoice'];


    $u = User::find($input['the-rep']);
        if($u->user_type=="doorrep"){
            $type = "door";
        } else if($u->user_type=="salesrep"){
            $type = "dealer";
        }

        if($type=="dealer"){
          if($invoice==0){
            $inv = Dealerinvoice::create(
            array(
                'user_id'=>$input['the-rep'],
                'date_issued'=> date('Y-m-d'),
                'type'=>$type,
                'status'=>'unpaid'
                ));
             $inv->invoice_no = $inv->id."-".$input['the-rep'];
          } else {
            foreach($input['deals'] as $val){
                    if($val!=""){
                        $sale = Sale::find($val);
                        if($sale){
                            $sale->invoice_id = $invoice;
                            $sale->save();
                        }
                    }
            }
             return Response::json("success");
          }
        }
        
       
        if($type=="door"){
            $valid = DB::query("SELECT COUNT(id) as total, researcher_id, researcher_name,
            SUM(status!='WrongNumber') valid, SUM(status='WrongNumber' OR status='INVALID') invalid
        FROM leads WHERE original_leadtype = 'door' AND entry_date>= DATE('".$input['startdate']."') AND 
        entry_date<= DATE('".$input['enddate']."') AND researcher_id = '".$input['the-rep']."'");
       
            if($valid){
                    if($valid[0]->valid>0){
                        $inv = Dealerinvoice::create(
                    array(
                        'user_id'=>$input['the-rep'],
                        'date_issued'=> date('Y-m-d'),
                        'type'=>$type,
                        'status'=>'unpaid'
                    ));
                     $inv->invoice_no = $inv->id."-".$input['the-rep'];
                     $inv->valid = $valid[0]->valid;
                     $inv->invalid = $valid[0]->invalid;
                     $inv->startdate = $input['startdate'];
                     $inv->enddate = $input['enddate'];
                    } else {
                    return Response::json("alreadyentered");
                    }
            }
                
        }
        
        if(empty($inv)){
            return Response::json("failed");
        } else {
             if($inv->save()){
             $id = $inv->id;
              foreach($input['deals'] as $val){
                    if($val!=""){
                        $sale = Sale::find($val);
                        if($sale){
                            $sale->invoice_id = $inv->id;
                            $sale->save();
                        }
                    }
                }
                return Response::json("success");
            };
        }
  }

  public function action_deleteinvoice($id){
    $inv = Dealerinvoice::find($id);
    if($inv){
      $sales = $inv->sale;
      if(!empty($sales)){
        $s = Sale::find($id);
      }

      return Response::json("success");
    } else {
      return Response::json("noinvoice");
    }
  }

 

 
  public function action_salesedit(){
     $input = Input::get();
      $x = explode("|", $input['id']);
      $inv = Sale::find($x[1]);

      if($x[0]=="typeofsale"){
        $app = Appointment::where('sale_id','=',$x[1])->get();
        $app2 = Appointment::find($app[0]->attributes['id']);
        $app2->systemsale = $input['value'];
        $app2->units = Sale::getUnits($input['value']);
        $app2->save();
      }

      $inv->$x[0] = $input['value'];
      $t = $inv->save();
        if($t){
          echo ucfirst($input['value']);
        } else {echo "Save Failed!";}
  }


  public function action_acknowledge(){
    $alert = Alert::find(10);
    $alert->seen = 1;
    if($alert->save()){
      return Response::json("success");
    };
  }





	//STATS AND AVERAGES

	public function action_getreggiemap(){
		$period = Input::get('period');
      	$coordinates = DB::query("SELECT id, address, lat, lng, cust_name, researcher_name, researcher_id, status, entry_date, cust_num, assign_count, result,notes
      	FROM leads WHERE original_leadtype = 'door' AND $period(entry_date)=$period('".date('Y-m-d')."')");
       	return json_encode($coordinates);
   	}

  public function action_getappmap($id){
        $coordinates = DB::query("SELECT id, address, lat, lng, cust_name, researcher_name, researcher_id, status, entry_date, cust_num, assign_count, result,notes
        FROM leads WHERE id='".$id."'");
        return json_encode($coordinates);
  }

	public function action_marketingreport(){
    		$input = Input::get();
    		$period = $input['period'];
    		
      		$paperanddoor = DB::query("SELECT COUNT(*) as total, leadtype, original_leadtype, 
        		SUM(result='DNS') dns, SUM(result='SOLD') sold, 
        		SUM(result='NQ') nq FROM leads WHERE $period(app_date)=$period('".date('Y-m-d')."') GROUP BY original_leadtype");
       
      	$stats = DB::query("SELECT COUNT(*) AS total, caller_id, leadtype, created_at,
        		SUM(result != '' AND result !='CONF' AND result != 'NA') rangetot,
        		SUM(result = 'APP') rangeapp,SUM(result = 'DNC') rangednc,
        		SUM(result = 'NH') rangenh,SUM(result = 'NI') rangeni,
        		SUM(result = 'NQ') rangenq,SUM(result = 'WrongNumber') rangewrong,
        		SUM(result = 'Recall') rangerecall FROM calls WHERE $period(created_at)=$period('".date('Y-m-d')."') GROUP BY caller_id, leadtype");

      	$statstotals = DB::query("SELECT COUNT(id) as total,
      	  SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,
      	  SUM(result = 'APP') app,SUM(result = 'DNC') dnc,
      	  SUM(result = 'NH') nh,SUM(result = 'NI' OR result = 'NQ') ni,
      	  SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
      	  SUM(result = 'WrongNumber') wrong FROM calls WHERE $period(created_at)=$period('".date('Y-m-d')."')");

      	$bookerstats = DB::query("SELECT caller_id,
      	  SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,
      	  SUM(result = 'APP') app,SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,
      	  SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
      	  SUM(result = 'WrongNumber') wrong FROM calls 
      	  WHERE $period(created_at)=$period('".date('Y-m-d')."') GROUP BY caller_id ORDER BY app DESC");


     		$appdetails = DB::query("SELECT *, IF(puton + total, 100*puton/total, NULL) AS hold 
     		  FROM (SELECT COUNT(*) as total, booked_by, booker_id,
     		  SUM(status='DNS')dns, SUM(status='INC') inc, SUM(status='SOLD') sales,
     		  SUM(status='DNS' OR status='INC' OR status='SOLD') puton
     		  FROM appointments WHERE $period(app_date)=$period('".date('Y-m-d')."') GROUP BY booker_id) as SUBQUERY ORDER BY booked_by");

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

      
        	return json_encode(array("appdetails"=>$appdetailsarray,"paperanddoor"=>$paperanddoor));
  	}

	}