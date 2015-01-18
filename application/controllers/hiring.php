<?php
class Hiring_Controller extends Base_Controller
{
	public function __construct(){
        parent::__construct();
  }

  public function action_index(){  

     if(Auth::user()->user_type!="manager"){
      return Redirect::to('dashboard');
    }
    $applicants = User::where('applied_on','!=','0000-00-00')
    ->where('type','!=','employee')
    ->where('type','!=','quit')
    ->where('type','!=','fired')
    ->where('type','!=','archived')
    ->where('type','!=','layedoff')
    ->order_by('firstname')->get();
    $employees = User::allUsers();
    $allapps = User::where('applied_on','!=','0000-00-00')->count();
    $upcoming = User::where('interview_date','>=',date('Y-m-d'))->where('type','=','interview')->order_by('interview_date')->order_by('interview_time')->get(array('id','firstname','lastname','cell_no','interview_date','interview_time','user_type'));
    $monthstats = DB::query("SELECT COUNT(*) as tot,  SUM('craigslist_ad' = 1) craigs, SUM(user_type = 'agent') marketing, SUM(user_type = 'salesrep') sales,
      SUM(user_type='doorrep') door, SUM('other_application' = 1) other FROM users WHERE MONTH(applied_on) = MONTH('".date('Y-m-d')."')");
    $weekstats = DB::query("SELECT COUNT(*) as tot,  SUM('craigslist_ad' = 1) craigs, SUM(user_type = 'agent') marketing, SUM(user_type = 'salesrep') sales,
      SUM(user_type='doorrep') door, SUM('other_application' = 1) other FROM users WHERE WEEK(applied_on) = WEEK('".date('Y-m-d')."')");

    return View::make('hiring.index')
    ->with('stats',array("month"=>$monthstats,"week"=>$weekstats))
    ->with('allapps',$allapps)
    ->with('employees',$employees)
    ->with('upcoming',$upcoming)
    ->with('applicants',$applicants);
  }

  public function action_archived(){
    $archived = User::where('type','=','archived')->order_by('applied_on')->order_by('firstname')->get();
    $hired = User::where('type','=','employee')->where('applied_on','!=','0000-00-00')->order_by('applied_on')->get();
    return json_encode(array("archived"=>$archived,"hired"=>$hired));

  }

  public function action_createuser(){
    $input = Input::get();
    $user = User::find($input['theid']);
    if($user){
      $user->type = "employee";
      $user->level = 1;
      $user->avatar = "avatar.jpg";
      if($user->save()){
         return json_encode($user->firstname." ".$user->lastname);
      };
    } else {
      return json_encode("failed");
    }


  }

  public function action_interview(){
    $input = Input::get();
    $user = User::find($input['user-id']);
    if($user){
      $user->interview_date = $input['interview_date'];

      $user->interview_time = date('H:i:s',strtotime($input['interview_time']));
      $user->type = "interview";
      $user->save();
      return Redirect::back();
    }
  }

  public function action_fileaway($id){
     
      $user = User::find($id);
    if($user){
      $user->type = "archived";
      $user->level = 99;
      $user->save();
      return json_encode($id);
    }


  }

  public function action_cancelinterview($id){
    $user = User::find($id);
    if($user){
      $user->interview_date="0000-00-00";
      $user->interview_time="00:00:00";
      $user->type = "applicant";
      $user->save();
    }
      echo json_encode($id);
  }

  public function action_getschedule(){
    $input = Input::get();
      if(empty($input)){
        $input['end']=date('Y-m-d');
      }
  
    $events = DB::query("SELECT firstname, lastname, interview_date,interview_time, user_type,id FROM 
      users WHERE type='interview' AND MONTH(interview_date) <= MONTH('".date('Y-m-d',strtotime($input['end']))."') ORDER BY interview_date, interview_time");
      foreach($events as $val){
        if($val->user_type=="agent"){$c ='#0066FF'; } else if($val->user_type=="salesrep"){$c ='#009933';} else {$c = '#1f1f1f';}
        $arr[]=array("id"=>$val->id,"title"=>$val->firstname." ".substr($val->lastname,0,1)."\n ".date('h:i a',strtotime($val->interview_time)),
         "start"=>$val->interview_date,"backgroundColor"=>$c,"className"=>"emp-".$val->id." interview ".$val->user_type);
      }
    echo json_encode($arr);

  }
  
   

  //EMPLOYEE FUNCTIONS

  public function action_schedule(){
    $input = Input::get();
 
    if(!empty($input)){

      $rules = array("date"=>"required","booker"=>"required","starttime"=>"required","endtime"=>"required");
      $v = Validator::make($input, $rules);
        
      if($v->fails()){
          return Redirect::back()->with_errors($v)->with_input();
      } else {
          $checkdatebooker = Schedule::where('date','=',$input['date'])->where('user_id','=',$input['booker'])->count();
            if($checkdatebooker) {
              Session::flash('hasshift','This marketer already has a shift, please remove it, before changing the hours');
              return Redirect::back()->with_input();
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
            }
          return Redirect::back()->with_input();
      }
    }

    $bookers = User::where('user_type','=','agent')->where('level','!=',99)->order_by('firstname')->get(array('id','firstname','lastname'));
      return View::make('schedule.schedule')
      ->with('bookers',$bookers);
  }

 

  
  



}