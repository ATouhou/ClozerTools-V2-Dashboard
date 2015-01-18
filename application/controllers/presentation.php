<?php
class Presentation_Controller extends Base_Controller
{
	public function __construct(){
        parent::__construct();
        //$this->filter('after','auth');
  }

  // View cross site REP info
  public function action_viewrep($id=null){
    if($id==null){
      return Redirect::back();
    }

    $games = Game::allGames();
    $notes = Tasks::where('receiver_id','=',$id)->where('status','=','usernote')->get();
    $charts = Stats::getCharts($id);
    $user = User::find($id);
    $stats = Stats::saleStats("ALLTIME","","");
    $monthStats = Stats::saleStats("MONTH","","");
    $weekStats = Stats::saleStats("WEEK","","");

    $data = View::make('games.index')
    ->with('stats',array('all'=>$stats,'month'=>$monthStats,'week'=>$weekStats))
    ->with('charts',$charts)
    ->with('games',$games)
    ->with('user',$user);

    $response = Response::make($data);
    $response->header('Content-Type', 'application/json');
    $response->header('Access-Control-Allow-Origin', '*');
    return $response;
  }

  public function action_viewappointment($user_id){
    $user = User::find($user_id);
    if($user){
      $apps = $user->appointments();
      $lat = Setting::find(1)->lat;
      $lng = Setting::find(1)->lng;
      
      $response = Response::json($apps);
      $response->header('Content-Type', 'application/json');
      $response->header('Access-Control-Allow-Origin', '*');
      return $response;
    }
    

  }

    public function action_pureop(){
        $input = Input::get();
        $viewmyself=false;

       if(isset($input['viewMyself'])){
        if($input['viewMyself']==true){
          $viewmyself=true;
        } 
       }
        
        $monthSalesNumbers= Stats::saleStats("MONTH","","");
        $weekSalesNumbers= Stats::saleStats("WEEK","","");

        $salesreps = User::where('user_type','=','salesrep')->where('level','!=','99')->order_by('level')->get();
        $sales = DB::query("SELECT * FROM sales WHERE month(date) = month('".date('Y-m-d')."') AND YEAR(date)=YEAR(NOW())");
        $monthsales = DB::query("SELECT COUNT(id), units FROM appointments WHERE status='SOLD' AND month(app_date) = month('".date('Y-m-d')."') AND YEAR(app_date)=YEAR(NOW())");
        $weeksales = DB::query("SELECT * FROM sales WHERE week(date,1) = week('".date('Y-m-d')."',1) AND YEAR(date)=YEAR(NOW())");
        $companies = DB::query("SELECT * FROM companies");
        $rep_count=0;$reps="";$marketers="";
        $company = Company::where('shortcode','=',Setting::find(1)->shortcode)->first();
        foreach($monthSalesNumbers as $k=>$v){
          if($k=="totals"){
            if($company){
                $company->month_total = $v['netsales'];
                $company->month_units = $v['totnetunits'];
                $company->net_maj = $v['netmd']['majestic'];
                $company->net_def = $v['netmd']['defender'];
            }
          } else {
            $rep_count++;
            if($rep_count<4){
              $u = User::find($v["rep_id"]);
              if($u){
                $reps.= $u->fullName()."|".$v["totnetunits"]."|";
                if($u->avatar=="avatar.jpg"){
                  $reps.="avatar.jpg+";
                } else {
                  $reps.=$u->avatar_link()."+";
                };
              }
              
            }
          }
        }
       $reps = substr($reps, 0, -1);
       if(!empty($reps)){
        $company->top_reps = $reps;
      } else {
         $company->top_reps = "";
      }
       
       $company->top_marketers="";
       $company->save();
       $data =  View::make('plugins.pureopdashboard')

        ->with('companies',$companies)
        ->with('viewMyself',$viewmyself)
        ->with('salesreps',$salesreps)
        ->with('monthSales',$monthSalesNumbers)
        ->with('weekSales',$weekSalesNumbers)
        ->with('sales',$sales)
        ->with('monthsales',$monthsales)
        ->with('weeksales',$weeksales);
        $response = Response::make($data);
        $response->header('Access-Control-Allow-Origin', '*');
        return $response;
    
    }

    public function action_revupcontest(){
      $month1 = Stats::saleStats("2014-10-01","2014-10-31","");
      $month2 = Stats::saleStats("2014-11-01","2014-11-30","");
      $month3 = Stats::saleStats("2014-12-01","2014-12-31","");
      $revup = array();$tickets=0;
      foreach($month1 as $k=>$val){
        $hasvalues=false;
        if($k!="totals"){
          $name = explode(" ",$val['name']);
          $revup[$val['rep_id']]['name'] = ucfirst(strtolower($name[0]))." ".ucfirst(substr($name[1],0,1));
          $def = $val['netmd']['defender'];
          $maj = $val['netmd']['majestic'];
          if($maj>$def){
            $systems1 = $def;
          } else {
            $systems1 = $maj;
          }
          $revup[$val['rep_id']]['m1maj'] = $maj;
          $revup[$val['rep_id']]['m1def'] = $def;
          $revup[$val['rep_id']]['m1hybrid'] = intval($systems1)-intval($val['netsale']['system']);
          $revup[$val['rep_id']]['m1system'] = $val['netsale']['system'];
          $revup[$val['rep_id']]['m1netunits'] = $val['totnetunits'];
          if($val['totnetunits']>0){
            $hasvalues=true;
          }
          $revup[$val['rep_id']]['m1tickets'] = 0;
          if($revup[$val['rep_id']]['m1system']+$revup[$val['rep_id']]['m1hybrid'] >=10 || $revup[$val['rep_id']]['m1netunits'] >=30){
            $revup[$val['rep_id']]['m1tickets'] = 1;
            $tickets++;
          }
          $revup[$val['rep_id']]['m2maj'] = 0;
          $revup[$val['rep_id']]['m2def'] = 0;
          $revup[$val['rep_id']]['m2hybrid'] = 0;
          $revup[$val['rep_id']]['m2system'] = 0;
          $revup[$val['rep_id']]['m2netunits'] = 0;
          $revup[$val['rep_id']]['m2tickets'] = 0;

          $revup[$val['rep_id']]['m3maj'] = 0;
          $revup[$val['rep_id']]['m3def'] = 0;
          $revup[$val['rep_id']]['m3hybrid'] = 0;
          $revup[$val['rep_id']]['m3system'] = 0;
          $revup[$val['rep_id']]['m3netunits'] = 0;
          $revup[$val['rep_id']]['m3tickets'] = 0;

          foreach($month2 as $i=>$v){
            if($i==$k){
              $def = $v['netmd']['defender'];
              $maj = $v['netmd']['majestic'];
              if($maj>$def){
                $systems2 = $def;
              } else {
                $systems2 = $maj;
              }
              $revup[$val['rep_id']]['m2maj'] = $maj;
              $revup[$val['rep_id']]['m2def'] = $def;
              $revup[$val['rep_id']]['m2hybrid'] =  intval($systems2)-intval($v['netsale']['system']);
              $revup[$val['rep_id']]['m2system'] = $v['netsale']['system'];
              $revup[$val['rep_id']]['m2netunits'] = $v['totnetunits'];
              if($v['totnetunits']>0){
                $hasvalues=true;
              }
              if($revup[$val['rep_id']]['m2system']+$revup[$val['rep_id']]['m2hybrid'] >=10 || $revup[$val['rep_id']]['m2netunits'] >=30){
                $revup[$val['rep_id']]['m2tickets'] = 1;
                $tickets++;
              }
            }
          }
          foreach($month3 as $i=>$v){
            if($i==$k){
              $def = $v['netmd']['defender'];
              $maj = $v['netmd']['majestic'];
              if($maj>$def){
                $systems3 = $def;
              } else {
                $systems3 = $maj;
              }
              $revup[$val['rep_id']]['m3maj'] = $maj;
              $revup[$val['rep_id']]['m3def'] = $def;
              $revup[$val['rep_id']]['m3hybrid'] = intval($systems3)-intval($v['netsale']['system']);
              $revup[$val['rep_id']]['m3system'] = $v['netsale']['system'];
              $revup[$val['rep_id']]['m3netunits'] = $v['totnetunits'];
              if($v['totnetunits']>0){
                $hasvalues=true;
              }
              if($revup[$val['rep_id']]['m3system']+$revup[$val['rep_id']]['m3hybrid'] >=10 || $revup[$val['rep_id']]['m3netunits'] >=30){
                $revup[$val['rep_id']]['m3tickets'] = 1;
                $tickets++;
              }
            }
          }
          $revup[$val['rep_id']]['hasvalues'] = $hasvalues;
        }
      }

      $revup["totaltickets"] = $tickets;
      $response = Response::json($revup);
      $response->header('Content-Type', 'application/json');
      $response->header('Access-Control-Allow-Origin', '*');
      return $response;

    }

    public function action_monthlystats(){

      $stats = Stats::saleStats("MONTH","","");
      $response = Response::json($stats);
      $response->header('Content-Type', 'application/json');
      $response->header('Access-Control-Allow-Origin', '*');
      return $response;

    }

    public function action_contest(){
      $settings = Setting::find(1);
     
      if($settings->contest_buffer!=0 && $settings->contests==1){
        $allSaleStats = Stats::saleStats("ALLTIME","","");
        
        $company = Company::where('shortcode','=',$settings->shortcode)->first();
        foreach($allSaleStats as $v=>$r){
          if($v=="totals"){
            $company->total_sales = $r['netsales'];
            $company->total_units = $r['totnetunits'];
            $company->contest_totals = intval($company->contest_buffer) + (intval($company->total_units)-intval($company->unit_buffer));
            $company->contest_left = intval($company->contest_goal) - intval($company->contest_totals);
          } 
        }
        $company->save();
        $response = Response::json($company->attributes);  
      } else {
        $response = Response::json("notenabled");
      }
      
        
        $response->header('Content-Type', 'application/json');
        $response->header('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function action_repinfo($id){
      $input = Input::get();
      $viewmyself=false;

       if(isset($input['viewMyself'])){
        if($input['viewMyself']==true){
          $viewmyself=true;
        } 
       }
       
        if($id==null){  
            return false;
        } else {
            $stats = Stats::getCharts($id);
            if($id=="all"){ 
                $sales = Sale::get();
                $notes = array();
                $rep = User::find(1);
                $all="all";
            } else {
                $sales = Sale::where('user_id','=',$id)->get();
                $notes = Tasks::where('receiver_id','=',$id)->where('status','=','usernote')->get();
                $rep = User::find($id);
                $all=array();
            }
            $data =  View::make("profile.salesrep")
            ->with('user',$rep)
            ->with('viewMyself',$viewmyself)
            ->with('all',$all)
            ->with('type',$id)
            ->with('notes',$notes)
            ->with('sales',$sales)
            ->with('stats',$stats);
            $response = Response::make($data);
            $response->header('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }




    /**********FULL SCREEN DISPLAY SECTION***************/

    public function action_display(){

      $settings = Setting::find(1);
      $companies = Company::get();
      $fullscreen = true;
      return View::make("fullscreen.display")->with('companies',$companies)->with('settings',$settings)->with('fullscreen',$fullscreen);
    }

    public function action_salemap(){
      //$sales = DB::query("SELECT lead_id,typeofsale, status, payment, price FROM sales WHERE MONTH(date)=MONTH(NOW())");
      $date = "2014-09-01";
      $dates = Stats::getDatesOfWeek(date("W",strtotime($date)), date("Y",strtotime($date)));
      $appts = Appointment::where('app_date','>=',$dates[0])->where('app_date','<=',$dates[1])->get();
      $markers=array();

      foreach($appts as $val){
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
            "data"=>$val->lead->address." | " .$val->app_time. " | Machine : ".ucfirst($val->systemsale),
            "tag"=>$val->status,
            "options"=>array("icon"=>$icon));
          }
          
      }

      if(!empty($markers)){
        return Response::json($markers);
      } else {
        return Response::json("nodata");
      }
    }








    /***************OLD DEPRECATED FUNCTION***************/

    public function action_stats(){

    	$sales = Stats::salespodium("MONTH");
      $marketing = Stats::marketpodium("MONTH");
      $doorreggie = Stats::reggiestats("MONTH");
      $settings = Setting::find(1);
      $employees = User::where('user_type','=','agent')->where('level','!=',99)->get(array('id','firstname','lastname','address','sex','cell_no'));
      $activereps = User::where('user_type','=','salesrep')->where('level','!=',99)->get(array('id','firstname','lastname','address','sex','cell_no'));
      $data = array("sales"=>$sales,"marketing"=>$marketing,"settings"=>$settings,"marketers"=>$employees,"reps"=>$activereps);

	      $response = Response::json($data);
		    $response->header('Content-Type', 'application/json');
		    $response->header('Access-Control-Allow-Origin', '*');
		    return $response;
    }
    
    public function action_bigscreen(){

      $sales = Stats::salespodium("MONTH");
      $salesweek = Stats::salespodium("WEEK");
      $marketing = Stats::marketpodium("MONTH");
      $marketingweek = Stats::marketpodium("WEEK");
      $doorreggie = Stats::reggiestats("MONTH");
      $settings = Setting::find(1);
      $employees = User::where('user_type','=','agent')->where('level','!=',99)->get(array('id','firstname','lastname','address','sex','cell_no'));
      $activereps = User::where('user_type','=','salesrep')->where('level','!=',99)->get(array('id','firstname','lastname','address','sex','cell_no'));
      $data = array("sales"=>$sales,"marketing"=>$marketing,"marketingweek"=>$marketingweek,"salesweek"=>$salesweek,"settings"=>$settings,"marketers"=>$employees,"reps"=>$activereps);
     
      $response = Response::json($data);
      $response->header('Content-Type', 'application/json');
      $response->header('Access-Control-Allow-Origin', '*');
      return $response;
    }
   

    public function action_getreport(){

      $sales = Stats::salespodium("MONTH");
      $allsales = DB::query("SELECT sold_by, status, typeofsale, user_id FROM sales WHERE MONTH(date) = MONTH('".date('Y-m-d')."') AND YEAR(date)=YEAR(NOW())");
      $monthsales= Stats::salesstats("MONTH");
      $reggies = Stats::reggiestats("MONTH");
      $marketing = Stats::marketpodium("MONTH");
      $settings = Setting::find(1);
      $employees = User::where('user_type','=','agent')->where('level','!=',99)->get(array('id','firstname','lastname','address','sex','cell_no'));
      $activereps = User::where('user_type','=','salesrep')->where('level','!=',99)->get(array('id','firstname','lastname','address','sex','cell_no'));

      $arr2=array();

        foreach($sales['reps'] as $v){
           $maj=0;$def=0;$ndef=0;$nmaj=0;
            foreach($allsales as $k){
              if($v->rep_id==$k->user_id){
             $u = Stats::units($k->typeofsale);
             $maj = $maj+$u['maj'];
             $def = $def+$u['def'];
             if($k->status=="COMPLETED"){
               $nmaj = $nmaj+$u['maj'];
               $ndef = $ndef+$u['def'];
             }
          }
            }

             $arr2[]=array("gmaj"=>$maj,"gdef"=>$def,"nmaj"=>$nmaj,"ndef"=>$ndef,"name"=>$v->rep_name,"id"=>$k->user_id);
          
        }


      $data = array(
        "sales"=>$sales,
        "allsales"=>$arr2,
        "reggies"=>$reggies,
        "monthsales"=>$monthsales,
        "marketing"=>$marketing,
        "settings"=>$settings,
        "marketers"=>$employees,
        "reps"=>$activereps
        );
     
      $response = Response::json($data['monthsales']);
      $response->header('Content-Type', 'application/json');
      $response->header('Access-Control-Allow-Origin', '*');
      return $response;



    }

}