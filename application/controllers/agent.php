<?php
class Agent_Controller extends Base_Controller
{
	public function __construct(){
        parent::__construct();
        $this->filter('before','auth');
  }

  public function action_index(){  

    if(Auth::user()->user_type!="manager"){
      return Redirect::to('dashboard');
    }
	    
    $manager = User::where('user_type','=','manager')->where('level','!=',99)->get();
    $res = User::where('user_type','=','researcher')->where('level','!=',99)->get();
    $salesrep = User::where('user_type','=','salesrep')->where('level','!=',99)->get();
    $agent = User::where('user_type','=','agent')->where('level','!=',99)->get();
    $doorrep = User::where('user_type','=','doorrep')->where('level','!=',99)->get();
    $unactive = User::where('level','=',99)->get();
    
    return View::make('agent.index')
    ->with('manager',$manager)
    ->with('res',$res)
    ->with('salesrep',$salesrep)
    ->with('unactive',$unactive)
    ->with('agent',$agent)
    ->with('doorrep',$doorrep)
    ->with('active','agent');
  }

  public function action_schedule(){
    $input = Input::get();
 
    if(!empty($input)){

      $rules = array("date"=>"required","booker"=>"required","starttime"=>"required","endtime"=>"required");
      $v = Validator::make($input, $rules);
        
      if($v->fails()){
          return Redirect::back()->with_errors($v)->with_input();
      } else {
              $thedate = $input['date'];
              $start = date('H:i:s',strtotime($input['starttime']));
              $end = date('H:i:s',strtotime($input['endtime']));
              $booker = $input['booker'];
              $u = User::find($input['booker']);
              $name = $u->firstname." ".$u->lastname;
              $sched = New Schedule;
              $sched->user_id = $input['booker'];
              $sched->user_name = $name;
              $sched->date = $input['date'];
              $sched->checkin = $start;
              $sched->checkout = $end;
              $sched->length = (strtotime($end)-strtotime($start))/60;
              $sched->save();
          return Redirect::back()->with_input();
      }
    }

  $bookers = User::where('user_type','=','agent')->where('level','!=',99)->order_by('firstname')->get(array('id','firstname','lastname'));
    return View::make('schedule.schedule')
    ->with('bookers',$bookers);
  }

  public function action_delshift($id){
    $shift = Schedule::find($id);
    if($shift->delete()){
      return Response::json("success");
    };
  }

  public function action_moveshift($id){
    $input = Input::get();
    $shift = Schedule::find($id);
    if($shift){
      if(isset($input['date'])&&!empty($input['date'])){
        $d = $input['date'];
        if($d>0) {$d="+ ".$d;};
        $shift->date = date('Y-m-d', strtotime($shift->date. $d.' days'));
        if($shift->save()){
          return Response::json("success");
        };
      }
    }
  }

  public function action_copyshift($id){
    $input = Input::get();
    $shift = Schedule::find($id);
    if($shift){
      if(isset($input['date'])&&!empty($input['date'])){
        $d = $input['date'];
        if($d>0) {$d="+ ".$d;};
        $sched = New Schedule;
        $sched->date = date('Y-m-d', strtotime($shift->date. $d.' days'));
        $sched->user_id = $shift->user_id;
        $sched->user_name = $shift->user_name;
        $sched->checkin = $shift->checkin;
        $sched->checkout = $shift->checkout;
        $sched->length = $shift->length;
        if($sched->save()){
          return Response::json(array("id"=>$sched->id,"title"=>$sched->user_name."\n ".date('g:i',strtotime($sched->checkin))."-".date('g:i',strtotime($sched->checkout)), "start"=>$sched->date));
        };
      }
    }
  }

  public function action_getschedule(){
    $input = Input::get();
      if(empty($input)){
        $input['end']=date('Y-m-d');
      }
  
    $events = DB::query("SELECT * FROM schedule WHERE MONTH(date) <= MONTH('".date('Y-m-d',strtotime($input['end']))."') ORDER BY date");
      foreach($events as $val){
        $arr[]=array("id"=>$val->id,"title"=>$val->user_name."\n ".date('g:i',strtotime($val->checkin))."-".date('g:i',strtotime($val->checkout)), "start"=>$val->date);
      }
    return Response::json($arr);
  }
}