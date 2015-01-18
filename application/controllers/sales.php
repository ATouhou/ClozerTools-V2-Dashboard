<?php
class Sales_Controller extends Base_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->filter('before', 'auth');
    }

    public function action_otherinfo(){
        $input = Input::get();
        if(!empty($input['sale_id'])){
           $s =  Sale::find($input['sale_id']);
           if($s){
            $s->filter_one = $input['filter_one'];
            $s->filter_two = $input['filter_two'];
            $s->postal_code = $input['postal_code'];
            $s->lead_type = $input['lead_type'];
            $s->emailaddress = $input['sale_email_address'];
            if($s->save()){
                return json_encode($s->attributes);
            };
           } else {
           return json_encode("failed_nosale");
           }
        } else {
            return json_encode("failed_noid");
        }
        //return json_encode($input['sale_id']);
    }

    public function action_invoice($id=null){
       
        if(Auth::user()->user_type=='salesrep'){
            $rep = Auth::user()->id;
        } else {
            $rep="all";
        }

        $input = Input::get();
        if(empty($input['startdate'])){
            if(Auth::user()->user_type=="salesrep"){
                $title = "Invoice / Sales Report for This Week";
            } else {
                $title = "Invoice Report for This Week";
            }
       
        $city = '';
        $day = date('w');
        $day = $day-1;
        $datemin = date('Y-m-d',strtotime('-'.$day.' days'));
        $datemax = date('Y-m-d',strtotime('+'.(6-$day).' days'));
      } else {
        $datemin = $input['startdate'];
        $datemax = $input['enddate'];
        $title = "Invoices for Period (".date('M d',strtotime($datemin))."-".date('M d',strtotime($datemax)).")";
      }

        $cities = City::where('status','=','active')->get();
        $reps = User::where('user_type','!=','manager')
        ->where('user_type','!=','other')
        ->where('user_type','!=','agent')
        ->where('level','!=',99)
        ->where('type','=','employee')
        ->order_by('firstname')
        ->order_by('user_type')
        ->get();

       if(isset($input['allunpaid']) && $input['allunpaid']==true){
            $invoices = Dealerinvoice::
            where('type','=','dealer')
            ->where('status','=','unpaid')
            ->order_by('date_issued','ASC')
            ->get();

            $doorinvoices = Dealerinvoice::
            where('type','=','door')
            ->where('status','=','unpaid')
            ->order_by('date_issued','ASC')
            ->get();
            
            $sales = Sale::where('paid','=',0)->where('status','!=','CANCELLED')->where('status','!=','TBS')->where('invoice_id','=',0)
            ->get();

         } else {

            if($rep=="all"){

        if($id==null){

            $invoices = Dealerinvoice::
            where('type','=','dealer')
            ->where('created_at','>=',date('Y-m-d H:i:s',strtotime($datemin)))
            ->where('created_at','<=',date('Y-m-d H:i:s',strtotime($datemax)))
            ->order_by('date_issued','ASC')
            ->get();
    
            $doorinvoices = Dealerinvoice::
            where('type','=','door')
            ->where('created_at','>=',date('Y-m-d H:i:s',strtotime($datemin)))
            ->where('created_at','<=',date('Y-m-d H:i:s',strtotime($datemax)))
            ->order_by('date_issued','ASC')
            ->get();

        } else {
            $title = "Viewing Invoice # : ".$id;
            $invoices = Dealerinvoice::where('invoice_no','=',$id)->get();
        }

    /*$sales = Sale::where('paid','=',0)->where('status','!=','CANCELLED')->where('status','!=','TBS')->where('invoice_id','=',0)
    ->get();*/
    $sales = DB::query("SELECT * FROM sales WHERE status!='CANCELLED' AND status!='TBS' AND invoice_id = 0 AND paid = 0");

    } else {

    $sales = DB::query("SELECT * FROM sales WHERE (user_id='".$rep."' OR ridealong_id='".$rep."') 
        AND status!='CANCELLED' AND status!='TBS' AND invoice_id = 0 AND paid = 0");

    /*Sale::where('paid','=',0)
    ->where('user_id','=',$rep)
    ->where('status','!=','CANCELLED')
    ->where('status','!=','TBS')
    ->where('invoice_id','=',0)
    ->get();*/

    if($id==null){

    $invoices = Dealerinvoice::where('user_id','=',$rep)
    ->where('type','=','dealer')
    ->where('created_at','>=',date('Y-m-d H:i:s',strtotime($datemin)))
    ->where('created_at','<=',date('Y-m-d H:i:s',strtotime($datemax)))
    ->order_by('date_issued','ASC')
    ->get();

    $doorinvoices = Dealerinvoice::where('user_id','=',$rep)
    ->where('type','=','door')
    ->where('created_at','>=',date('Y-m-d H:i:s',strtotime($datemin)))
    ->where('created_at','<=',date('Y-m-d H:i:s',strtotime($datemax)))
    ->order_by('date_issued','ASC')
    ->get();

       } else {
        $invoices = Dealerinvoice::where('invoice_no','=',$id)->get();
        }
    }
        
      }

    if(Auth::user()->user_type=="salesrep"){

       /* $yoursales = DB::query("SELECT * FROM sales WHERE (user_id='".$rep."' OR ridealong_id = '".$rep."') 
            AND status!='CANCELLED' AND status!='TBS' AND created_at >= DATE('".date('Y-m-d H:i:s',strtotime($datemin))."') 
            AND created_at <= DATE('".date('Y-m-d H:i:s',strtotime($datemax))."')");*/

    
    $yoursales = Sale::where('user_id','=',Auth::user()->id)
    ->where('status','!=','CANCELLED')
    ->where('status','!=','TBS')
    ->where('created_at','>=',date('Y-m-d H:i:s',strtotime($datemin)))
    ->where('created_at','<=',date('Y-m-d H:i:s',strtotime($datemax)))
    ->get();
    
    } else {$yoursales=array();}

     if((isset($input['rep']))&&(empty($input['startdate']))){
         $invoices = Dealerinvoice::where('user_id','=',$rep)
        ->order_by('date_issued','ASC')
        ->get();
        $u = User::find($rep);
        if($u){
            $title = "All Invoices for ".$u->firstname." ".$u->lastname;
        } else {
             $title = "Cannot find user in system";
        }   
        
    }

    return View::make('sales.invoice')
    ->with('startdate',$datemin)
    ->with('enddate',$datemax)
    ->with('invoices',$invoices)
    ->with('doorinvoices',$doorinvoices)
    ->with('reps',$reps)
    ->with('sales',$sales)
    ->with('yoursales',$yoursales)
    ->with('cities',$cities)
    ->with('title',$title);

    }
    
    
    public function action_viewinvoice($id){
        $inv = Dealerinvoice::find($id);
        
        
        return View::make('plugins.invoiceview')
        ->with('invoice',$inv);
    
    
    
    }

    public function action_attachdeal(){
        $input = Input::get();

        $rules = array('thesale'=>'required','invoiceid'=>'required');
        $v = Validator::make($input,$rules);
        if( $v->fails() ) {
                return json_encode("failed");
            }
        $inv = Dealerinvoice::find($input['invoiceid']);
        $sale = Sale::find($input['thesale']);

        if($inv){
                if($sale){
                    if($sale->invoice_id==0){
                        $sale->invoice_id = $input['invoiceid'];
                        $sale->save();
                        return json_encode($sale->attributes);
                    } else {
                        return json_encode("failed");
                    }
                
                }
        }
   
    }

    public function action_removedeal(){
        $input = Input::get();
        $rules = array('thesale'=>'required');
        $v = Validator::make($input,$rules);
        if( $v->fails() ) {
                return json_encode("failed");
            }

        $sale = Sale::find($input['thesale']);

        if($sale){
                $sale->invoice_id = 0;
                $sale->save();
                return json_encode($sale->attributes);
            } else {
                return json_encode("failed");
            }
    }

    public function action_markpaid(){
        $input = Input::get();
        $rules = array('invoice'=>'required','amount'=>'required');
        $v = Validator::make($input,$rules);
        if( $v->fails() ) {
                return json_encode("failed");
            }
            $arr = array();
        $inv = Dealerinvoice::find($input['invoice']);
        if(empty($input['cheque'])){
            $chk = '';
        } else {
            $chk = $input['cheque'];
        }

        if($inv){
            
            if(!empty($inv->sale)){
                foreach($inv->sale as $v){
                    $v->paid = 1;
                    $v->paid_date = date('Y-m-d');
                    $v->save();
                }
            }
            
            $inv->date_paid = date('Y-m-d');
            $inv->status = 'paid';
            $inv->cheque_no = $chk;
            $inv->amount = $input['amount'];
            $inv->notes = $input['notes'];
            if($inv->save()){
                return json_encode($inv->attributes);
            };

        } else {
            return json_encode("failed");
        }

    }

    public function action_deleteinv($id){
        $inv = Dealerinvoice::find($id);
        if($inv){
            if((Auth::user()->user_type=="manager")||(Auth::user()->id==$inv->user_id)){
                if(!empty($inv->sale)){
                    foreach($inv->sale as $s){
                        $s->paid = 0;
                        $s->paid_date = "0000-00-00";
                        $s->invoice_id=0;
                        $s->save();
                    }
                }
                if($inv->delete()){
                    return json_encode("success");
                } else {
                    return json_encode("failed to delete!");
                };
               
            } else {
            return json_encode("Not allowed!!");
            }
        } else {
            return json_encode("failed");
        }
    }

    public function action_createinvoice(){
        $input = Input::get();
       
        
         $rules = array('the-rep'=>'required');
        $v = Validator::make($input,$rules);
        if( $v->fails() ) {
                return Redirect::back();
            }

        $u = User::find($input['the-rep']);
        if($u->user_type=="doorrep"){
            $type = "door";
        } else if($u->user_type=="salesrep"){
            $type = "dealer";
        }
        if($type=="dealer"){
            $inv = Dealerinvoice::create(
            array(
                'user_id'=>$input['the-rep'],
                'date_issued'=> date('Y-m-d'),
                'type'=>$type,
                'status'=>'unpaid'
                ));
             $inv->invoice_no = $inv->id."-".$input['the-rep'];
        }
        
       
        if($type=="door"){

            //Check for overlap
            $check = DB::query("SELECT COUNT(*) as cnt from dealer_invoices WHERE(
                (DATE('".$input['startdate']."') <= DATE(enddate) AND DATE('".$input['enddate']."') >= DATE(startdate))
            ) AND user_id = '".$u->id."'");

            if($check[0]->cnt>0){
               Session::flash('overlap',true);
               return Redirect::back();
            } else {

                $valid = DB::query("SELECT COUNT(id) as total, researcher_id, researcher_name,
                SUM(status='WrongNumber') wrong,
                SUM(status!='WrongNumber' AND status!='INACTIVE' AND status!='INVALID') valid, SUM(status='WrongNumber' OR status='INVALID' OR status='INACTIVE') invalid
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
                        Session::flash('msg',true);
                        }
                    }
            }
            }

         
        if(empty($inv)){
            return Redirect::back();
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
                
                return Redirect::back();
        };
        
        }
    }

    public function action_editinvoice(){
         $input = Input::get();

      $x = explode("|", $input['id']);
      $invoice = Dealerinvoice::find($x[1]);
      $invoice->$x[0] = $input['value'];
      $test = $invoice->save();
            if($test) return $input['value'];
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

    public function action_index(){
        if(Auth::user()->user_type!="salesrep"){
            $confirms = Lead::where('status','=','SOLD')->where('result','=','SOLD')->where('sale_id','=',0)->get();
            $approvals = Sale::where('status','=','APPROVAL')->get();
            $skus = Inventory::where('status','!=','Sold')->get();

        $statsmonth = DB::query("SELECT
            SUM(CASE WHEN status='APPROVAL' OR status='COMPLETE' AND MONTH(date)=MONTH('".date('Y-m-d')."') THEN payout ELSE 0 END) pay,
            SUM(CASE WHEN status='APPROVAL' OR status='COMPLETE' AND MONTH(date)=MONTH('".date('Y-m-d')."') THEN price ELSE 0 END) price
            FROM sales WHERE MONTH(date)=MONTH('".date('Y-m-d')."')");

        $statsweek = DB::query("SELECT
            SUM(CASE WHEN status='APPROVAL' OR status='COMPLETE' AND WEEK(date)=WEEK('".date('Y-m-d')."') THEN payout ELSE 0 END) pay,
            SUM(CASE WHEN status='APPROVAL' OR status='COMPLETE' AND WEEK(date)=WEEK('".date('Y-m-d')."') THEN price ELSE 0 END) price
            FROM sales WHERE WEEK(date)=WEEK('".date('Y-m-d')."')");
        
        } else {

        $confirms = Lead::where('status','=','SOLD')->where('result','=','SOLD')->where('rep','=',Auth::user()->id)->where('sale_id','=',0)->get();
        $approvals = Sale::where('status','=','APPROVAL')->where('user_id','=',Auth::user()->id)->get();
        $skus = Inventory::where('checked_by','=',Auth::user()->firstname." ".Auth::user()->lastname)->where('status','!=','Sold')->get();
        
        $statsmonth = DB::query("SELECT
            SUM(CASE WHEN status='APPROVAL' OR status='COMPLETE' AND MONTH(date)=MONTH('".date('Y-m-d')."') AND rep = ".Auth::user()->id." THEN payout ELSE 0 END) pay,
            SUM(CASE WHEN status='APPROVAL' OR status='COMPLETE' AND MONTH(date)=MONTH('".date('Y-m-d')."') AND rep = ".Auth::user()->id." THEN price ELSE 0 END) price
            FROM sales WHERE MONTH(date)=MONTH('".date('Y-m-d')."')");

        $statsweek = DB::query("SELECT
            SUM(CASE WHEN status='APPROVAL' OR status='COMPLETE' AND WEEK(date)=WEEK('".date('Y-m-d')."') AND rep = ".Auth::user()->id."  THEN payout ELSE 0 END) pay,
            SUM(CASE WHEN status='APPROVAL' OR status='COMPLETE' AND WEEK(date)=WEEK('".date('Y-m-d')."') AND rep = ".Auth::user()->id." THEN price ELSE 0 END) price
            FROM sales WHERE WEEK(date)=WEEK('".date('Y-m-d')."')");
        }
      
        return View::make('sales.index')
        ->with('skus',$skus)
        ->with('statsmonth',$statsmonth)
        ->with('statsweek',$statsweek)
        ->with('confirms',$confirms)
        ->with('approvals',$approvals);
    }

    public function action_history($date=null){
        if(Auth::user()->user_type!="salesrep"){
            $allsales = Sale::order_by('date')->get();
        } else {
            $allsales = Sale::where('user_id','=',Auth::user()->id)->order_by('date')->get();
        }

        $stats = DB::query("SELECT COUNT(*) as total, rep_name,
            SUM(CASE WHEN result = 'DNS' THEN 1 ELSE 0 END) dns, 
            SUM(CASE WHEN result = 'SOLD' THEN 1 ELSE 0 END) sold, 
            SUM(CASE WHEN result = 'INC' THEN 1 ELSE 0 END) inc,
            SUM(CASE WHEN result = 'DNS' OR result = 'SOLD' OR result = 'INC' THEN 1 ELSE 0 END) tot
            FROM leads GROUP BY rep_name");

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
        ->where('app_date','<=',$enddate)
        ->where('result','=','SOLD')
        ->distinct('rep')
        ->get();

        $numbers = array();

        $salesreps = User::where('user_type','=','salesrep')->get();
        foreach($salesreps as $val){
            $array = array();
            $rep = $val->firstname." ".$val->lastname;
            
            $usales = Lead::where('result','=','SOLD')
            
            ->where('app_date','>',$startdate)
            ->where('app_date','<',$enddate)
            ->count();
            $udemos = Lead::where('status','=','APP')
           
            ->where('app_date','>',$startdate)
            ->where('app_date','<',$enddate)
            ->count();
            $inc = Lead::where('result','=','INC')
            
            ->where('app_date','>',$startdate)
            ->where('app_date','<',$enddate)
            ->count();
            $nq = Lead::where('result','=','NQ')
           
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


        return View::make('sales.history')
        ->with('allsales',$allsales)
        ->with('stats',$stats)
        ->with('monthsales',$monthsales)
        ->with('monthstats',$stats)
        ->with('date',$date);


    }

    public function action_view($id){
        if($id==0){
            return Redirect::to('sales');
        }
        $sale = Sale::with('items')->with('lead')->find($id);

        $pricing = DB::query("SELECT * FROM pricing");
        $pureop = DB::query("SELECT * FROM pureop WHERE id = '".User::find($sale->user_id)->level."'");
        return View::make('sales.viewsale')
        ->with('sale',$sale)
        ->with('pricing',$pricing)
        ->with('comm',$pureop);
    }

    public function action_submitsale($id){
        if($id==null){
            return Redirect::back();
        }
        
        $s = Lead::find($id);
        
        if(Auth::user()->user_type=="manager"){
            $skus = Inventory::where('status','=','Checked Out')->get();
        } else {
            $skus = Inventory::where('checked_by','=',Auth::user()->id)
            ->where('status','=','Checked Out')
            ->get();
        }
     
        return View::make('sales.submitsale')
        ->with('skus',$skus)
        ->with('sale',$s);
    }

    

    public function action_viewsale($id){
    	$sale = Sale::with('items')->with('lead')->find($id);
        $pricing = DB::query("SELECT * FROM pricing");
        $pureop = DB::query("SELECT * FROM pureop");

        $sales = Inventory::where('sale_id','=',$sale->sale_id)->get();
    	return json_encode(array("sale"=>$sale,"pricing"=>$pricing, "commision"=>$pureop));
    }

    public function action_deletesale($id){
    	$sale = Sale::find($id);
    	$sale->delete();
    	return json_encode("success");
    }

    

    

    public function action_getmachinelist($id){
        if($id==null){
            return "Sale does not exist";
        } else {
            $sale = Sale::find($id);
            if($sale){
                $machines = Inventory::where('user_id','=',$sale->user_id)
                ->where('status','=','Checked out')
                ->get();

                     return View::make('plugins.machinelist')
                    ->with('sale',$sale)
                    ->with('machines',$machines);
            } else {
               return "failed";
            }
        }
    }

    public function action_savemachines(){
        $input = Input::get();
        $sale = $input['theSaleId'];
        $machine = $input['machine-no'];
        
        if($machine=="nomachine"){
            return Response::json(array("status"=>"nomachine"));
        };

        $m = Inventory::find($machine);
        $s = Sale::find($sale);
        if($m){
            if($m->sale_id!=0){
                return Response::json(array("status"=>"alreadyattached","d"=>$m->sale_id));
            }
            $m->sold_by = $m->checked_by;
            $m->sale_id = intval($sale);
            if($s){
                $m->date_sold = $s->date;
            } else {
                $m->date_sold = date('Y-m-d');
            }
            $m->status = "Sold";
            if($m->save()){
                //Record History
                $hist = New InventoryHistory;
                $hist->item_id = $m->sku;
                $hist->type = 'sold';
                $hist->message = "Item Sold by ".$m->sold_by;
                $hist->user_id = Auth::user()->id;
                $hist->save();
                return Response::json(array("status"=>"success","d"=>$m->attributes));
            } else {
                return Response::json(array("status"=>"failed"));
            };
        } else {
            return Response::json(array("status"=>"failed"));
        }
    }
    //Batch change status on inventory items attached to sale
    public function changeStatus($sale,$status){
        $nums = $sale->items;
        if($nums){
            foreach($nums as $n){
                $n->status = $status;
                $n->save();
            }
        }
        
        return $sale;
    }
    //Batch remove items from sale
    public function removeItems($sale){
        $nums = $sale->items;
        if($nums){
            foreach($nums as $n){
                $ts = $n->sale_id;
                $n->date_sold = '0000-00-00';
                $n->sold_by = '';
                $n->sale_id = 0;
                $n->status = 'Checked Out';
                $n->save();
                $hist = New InventoryHistory;
                $hist->item_id = $n->sku;
                $hist->type = 'return';
                $hist->message = "Item Removed/Returned from sale #".$ts;
                $hist->user_id = Auth::user()->id;
                $hist->save();
            }
        }
        return $sale;
    }

    public function action_removeitem(){
        $input = Input::get();
        if(empty($input)){
            return Response::json("failed");
        }
        $inv = Inventory::find($input['machine']);
        if($inv){
            $ts = $inv->sale_id;
            $inv->sale_id=0;
            $inv->status="Checked Out";
            $inv->date_sold="0000-00-00";
            $inv->sold_by="";
            if($inv->save()){
                $hist = New InventoryHistory;
                $hist->item_id = $inv->sku;
                $hist->type = 'return';
                $hist->message = "Item Removed/Returned from sale # ".$ts;
                $hist->user_id = Auth::user()->id;
                $hist->save();
                return Response::json("success");
            } else {
                return Response::json("failed");
            }
        } else {
            return Response::json("failed");
        }
    }

    public function addMachine($sale,$machine){
        
        $inv = Inventory::find($machine);
        if(!empty($inv)){
            $inv->status = "Sold";
            $inv->sold_by = $sale->sold_by;
            $inv->date_sold = $sale->date;
            $inv->sale_id = $sale->id;

                $hist = New InventoryHistory;
                $hist->item_id = $inv->sku;
                $hist->type = 'sold';
                $hist->message = "Item Sold by ".$sale->sold_by;
                $hist->user_id = Auth::user()->id;
                $hist->save();
            if($inv->save()){
                
                return true;
            };
        } else {
            return false;
        }
    }

    public function action_edit(){

      $input = Input::get();
      $x = explode("|", $input['id']);
      $inv = Sale::find($x[1]);

      if($x[0]=="typeofsale"){
        $app = Appointment::where('sale_id','=',$x[1])->get();
        $app2 = Appointment::find($app[0]->attributes['id']);
        $app2->systemsale = $input['value'];
        $app2->units = $this->units($input['value']);
        $app2->save();
        $this->removeItems($inv);
      }

      if($x[0]=="payment"){
        $inv->funded = 0;
        if(($input['value']=="MasterCard")||($input['value']=="VISA")||($input['value']=="AMEX")){
            $inv->pay_type="CREDITCARD";
            $inv->deferal = "NA";
        } else if($input['value']=="CASH"){
            $inv->pay_type="CASH";
            $inv->deferal = "NA";
        }  else if($input['value']=="CHQ"){
            $inv->pay_type="CHEQUE";
            $inv->deferal = "NA";
        } else {
            $inv->pay_type="NA";
        }
      }

      if($x[0]=="status"){
        if(($input['value']=="CANCELLED")||($input['value']=="TURNDOWN")||($input['value']=="TBS")){
            $this->changeStatus($inv,"Cancelled");
            $inv->picked_up=0;
            $inv->cancel_date = date('Y-m-d');
        } else {
            $this->changeStatus($inv,"Sold");
            $inv->picked_up=0;
            $inv->cancel_date = '0000-00-00';
        }
      }

      $inv->$x[0] = $input['value'];
      $t = $inv->save();
        if($t){

           if($x[0]=="conf"){
                echo 2;
            } else if($x[0]=="interest_rate") {
                if(!empty($input['value'])){
                     $inv->interest_rate = number_format($input['value'], 2, '.', '');
                }
                
                 $inv->save();
                 echo $inv->interest_rate."%";

            } else {
              echo ucfirst($input['value']);

            }
          
        } else {echo "Save Failed!";}

    }

    public function units($type){

    if(($type=="defender")||($type=="majestic")){
           return 1;
        } elseif($type=="2maj"){
            return 2;
        } elseif($type=="3maj"){
            return 3;
        } elseif($type=="system"){
           return 2;
        } elseif($type=="2defenders"){
            return 2;
        }  elseif($type=="3defenders"){
            return 3;
        } elseif($type=="supersystem"){
           return 3;
        } elseif($type=="megasystem"){
           return 4;
        } elseif($type=="novasystem"){
           return 5;
        } elseif($type=="2system"){
           return 4;
        } elseif($type=="supernova"){
           return 6;
        }
    }



    

    public function action_approve($id){
        if($id==null){
            return Redirect::back();
        }

        $input = Input::get();
        $sale = Sale::find($id);
        $sale->payment = Input::get('methodofpay');
        $sale->deferal = Input::get('deferal');
        $fund = Input::get('funded');
        $finance = Input::get('financed');
        $app = Input::get('app');
        $net = Input::get('net');
        $conf = Input::get('conf');
        $tdpay = Input::get('tdpayout');

        if(empty($tdpay)){$tdpay = "0";}
        if(empty($fund)){$fund = "0";}
        if(empty($app)){$app = "0";}
        if(empty($conf)){$conf = "0";}
        if(empty($finance)){$finance = "0";}
        if(empty($net)){$net = "0";}

        $sale->net = $net;
        $sale->finance = $finance;
        $sale->app = $app;
        $sale->tdpay = $tdpay;
        $sale->conf = $conf;
        $sale->funded = $fund;
        $sale->status = "APPROVED";
        if($sale->save()){
            return Redirect::back();
        };

    }

    public function action_registersale(){

        $input = Input::get();
        $app = Appointment::find($input['appid']);
 
        if(isset($input['ra-check'])){
            if($input['ra-check']=="on"){
                $app->ridealong_diddemo=1;
            } 
        }
       
        if((!empty($app->ridealong_id))&&($app->ridealong_id!=0)){
            $ra = $app->ridealong_id;
        } else {
            $ra = 0;
        }
        $time = date('H:i:s');
        if(isset($input['type'])){
            
            $app->out = $time;
            $alert = Alert::find(10);
            $alert->message = Auth::user()->firstname." has Checked Out & SOLD!! (".$input['systemtype'].") @ ".$time.", Refresh the board to update";
            $alert->seen = 0;
            $alert->save();
           
        } 

        $sale = Sale::create(
            array(
                'user_id'=>$app->rep_id,
                'ridealong_id'=>$ra,
                'researcher_id'=>$app->lead->researcher_id,
                'booker_id'=>$app->booker_id,
                'sold_by'=>$app->rep->fullName(),
                'lead_id'=>$app->lead_id,
                'cust_name'=>$app->lead->cust_name,
                'date'=>$app->app_date,
                'typeofsale'=>$input['systemtype'],
                'price'=>$input['price'],
                'payout'=>$input['payout'],
                'status'=>"APPROVAL"
                ));
        $app->sale_id = $sale->id;
        $app->systemsale=$input['systemtype'];
        $units = Sale::getUnits($input['systemtype']);
        $app->units = $units['tot'];
        $app->status="SOLD";
        $app->save();

        $l = Lead::find($app->lead_id);
        $l->result="SOLD";
        $l->status="SOLD";
        $l->sale_id=$sale->id;
        $l->save();
        
        //WRITE HISTORY
        GameHistory::writeHistory(1,$app,"SOLD",$app->rep_id);
        GameHistory::writeHistory(1,$app,"PUTON",$app->booker_id);
        GameHistory::writeHistory(1,$app,"BOOKSOLD",$app->booker_id);
        GiftTracker::writeHistory($app,"SOLD");
        $company = str_replace('- Rep Dashboard','',Setting::find(1)->title);
        $p = New PusherLib;
        $p->pushMessage($app->rep->fullName()." | ".$company." | ".strtoupper($input['systemtype'])." @ ".date('H:i a'));
        if(isset($input['request'])){
            return Response::json("success");
        } else {
            return Redirect::back();
        }
    }


    public function action_newsale(){
        $skus = Input::get('tags');
     	$tags = explode(",",$skus);
        $input = Input::all();
        $rules = array('tags' => 'required',
            'methodofpay' => 'required',
            'price'=>'required','payout'=>'required');
       
        $validation = Validator::make($input, $rules);
           if( $validation->fails() ) {
                return Redirect::back()->with_errors($validation);
            }
        
        $lead_id = Input::get('lead_id');
        $lead = Lead::find($lead_id);
     
    	$sale = Sale::create(array(
                'user_id' => $lead->rep,
                'payform_submitted_by' => Auth::user()->firstname." ".Auth::user()->lastname,
                'sold_by' => $lead->rep_name,
                'lead_id' => $lead->id,
                'cust_name' => Input::get('custname'),
                'date' => $lead->app_date,
                'skus'=> $skus,
                'deferal'=>Input::get('deferal'),
                'submission_date'=>Input::get('date'),
                'typeofsale' => Input::get('typeofsystem'),
                'payment' => Input::get('methodofpay'),
                'price' => Input::get('price'),
                'payout' => Input::get('payout'),
                'status'=>"APPROVAL"
            ));
       
        $lead->sale_id = $sale->id;
        $lead->save();

    	foreach($tags as $val){
    		$inv = Inventory::where('sku','=',$val)->first();
    		$inv->status = "Waiting Approval";
    		$inv->sale_id = $sale->id;
    		$inv->date_sold = Input::get('date');
    		$inv->user_id = $lead->rep;
    		$inv->sold_by = $lead->rep_name;
    		$inv->save();
			
    		}
        return Redirect::to('sales');
    }

    public function action_uploadfile(){
        $input = Input::all();

        if(!empty($input['theDoc']['name'])){

            $file = Input::file('theDoc');
            $s = Setting::find(1)->shortcode;
            $id = $input['theID']."-".$input['leadID'];
            if($file){$input2 = S3::inputFile($file['tmp_name'], false);}
            $path_parts = pathinfo($file['name']);
            $ext = $path_parts['extension'];
            
               if(!empty($input['theName'])){
                    $filename = $input['theName'].".".$ext;
                } else {
                    $filename = $file['name'];
                }

                if(!empty($input2)){
                    if(S3::putObject($input2, 'salesdash', $s."/".$id."/".$filename, S3::ACL_PUBLIC_READ)){
                    $file2 = Doc::where('uri','=', $s."/".$id."/".$filename)->get();
                    if($file2){
                       echo "<span style='font-size:30px'>A File with that Name already exists for this Sale!</span><br><a href='".URL::to('reports/sales')."' class='btn btn-large btn-default'>BACK</a>";
                    } else {
                        $f = New Doc;
                        $f->lead_id = $input['leadID'];
                        $f->sale_id = $input['theID'];
                        $f->user_id = Auth::user()->id;
                        $f->notes = $input['theNotes'];
                        $f->filetype = $ext;
                        $f->filesize = $file['size'];
                        $f->filename = $filename;
                        $f->uri = $s."/".$id."/".$filename;
                        $f->save();
                        return Redirect::back();
                    }
                } else {
                     echo "<span style='font-size:30px'>FAILED!!  Please go back to try again</span><br><a href='".URL::to('reports/sales')."' class='btn btn-large btn-default'>BACK</a>";
                }

                } else {
                     echo "<span style='font-size:30px'>FAILED!!  Please go back to try again</span><br><a href='".URL::to('reports/sales')."' class='btn btn-large btn-default'>BACK</a>";
                }
                
            } else {
                echo "<span style='font-size:30px'>NO FILE SELECTED!!  Please go back to try again</span><br><a href='".URL::to('reports/sales')."' class='btn btn-large btn-default'>BACK</a>";
            }
    }

    public function action_pickupsale($id){
        if($id){
            $sale = Sale::find($id);
            $old=array("defender"=>array(),"majestic"=>array(),"attachment"=>array());
          
            if($sale){
                $items = $sale->items;
                if($items){
                    foreach($items as $inv){
                        $inv->date_sold = '0000-00-00';
                        $inv->sold_by = '';
                        $inv->user_id = 0;
                        $inv->sale_id = 0;
                        $inv->returned = $inv->returned+1;
                        $inv->checked_by = '';
                        $inv->status = 'In Stock';
                        if($inv->save()){
                            $hist = New InventoryHistory;
                            $hist->item_id = $inv->sku;
                            $hist->type = 'pickedup';
                            $hist->message = "Cancelled Sale Item Picked Up From Sale #".$sale->id." to Stock on ".date('M-d');
                            $hist->user_id = Auth::user()->id;
                            $hist->save();
                        };
                        if(isset($old[$inv->item_name])){
                            $old[$inv->item_name][] = $inv->sku;
                        }
                    }
                }

                $sale->picked_up= $sale->picked_up+1;
                $sale->old_machines = serialize($old);
                if($sale->status=="TBS"){
                    $sale->status="CANCELLED";
                }
                if($sale->save()){
                    return Response::json("success");
                } else {
                    return Response::json("failed");
                }
               
            } else {
                return Response::json("failed");
            }
           
        } else {
            return Response::json("failed");
        }
    }

    public function action_viewdocs($sale){
        $docs = Doc::where('sale_id','=',$sale)->get();
        if($docs){
        echo json_encode($docs);}
        else {

        }
    }

    public function action_delDocument($id=null){
        if($id){
            $doc = Doc::find($id);
            if($doc){
                if($doc->user_id!=Auth::user()->id){
                    return "notauth";
                }
                if(S3::deleteObject('salesdash',$doc->uri)){
                    $doc->delete();
                    return "success";
                } else {
                    return "failed";
                }
            } 
        } else {
            return "failed";
        }
    }

    public function action_getsalerow($id){
        if($id){
            $sale = Sale::find($id);
            if($sale){

                if($sale->defone!=0){
                    $defone = Inventory::find($sale->defone)->sku;
                } else if(($sale->defone_old)&&($sale->picked_up==1)) {
                    $defone = Inventory::find($sale->defone_old)->sku;;
                } else {
                    $defone="";
                }

                 if($sale->deftwo!=0){
                    $deftwo = Inventory::find($sale->deftwo)->sku;
                } else if(($sale->deftwo_old)&&($sale->picked_up==1)) {
                    $deftwo = Inventory::find($sale->deftwo_old)->sku;;
                } else {
                    $deftwo="";
                }

                 if($sale->maj!=0){
                    $maj = Inventory::find($sale->maj)->sku;
                } else if(($sale->maj_old)&&($sale->picked_up==1)) {
                    $maj = Inventory::find($sale->maj_old)->sku;;
                } else {
                    $maj="";
                }

                 if($sale->att!=0){
                    $att = Inventory::find($sale->att)->sku;
                } else if(($sale->att_old)&&($sale->picked_up==1)) {
                    $att = Inventory::find($sale->att_old)->sku;;
                } else {
                    $att="";
                }

                $arr = array("id"=>$sale->id, "sale"=>$sale,"status"=>$sale->status,"terms"=>$sale->deferal,"interest_rate"=>$sale->interest_rate,"paid_down"=>$sale->paid_down,"down_payment_type"=>$sale->down_payment_type,"pickedup"=>$sale->picked_up,"defone"=>$defone,"deftwo"=>$deftwo,"att"=>$att,"maj"=>$maj,"attsku"=>$sale->att, "defonesku"=>$sale->defone,"deftwosku"=>$sale->deftwo,"majsku"=>$sale->maj,"type"=>$sale->typeofsale

                    );

                return json_encode($arr);

            }
        }
    }


    public function action_saleinfo($id){
        $sale = Sale::find($id);
        if($sale){
            return View::make('plugins.saleinfo')
            ->with('sale',$sale);
        }
    }

    public function action_progress($id){
        $sale = Sale::find($id);
        if($sale){
            return View::make('plugins.saleprogress')
            ->with('sale',$sale);
        }
    }

    public function action_invoiceinfo($id){
        $sale = Sale::find($id);
        if($sale){
            return View::make('plugins.invoiceinfo')
            ->with('sale',$sale);
        }
    }
    	



    
}
