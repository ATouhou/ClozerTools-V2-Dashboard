<?php
class Employee_Controller extends Base_Controller
{
	public function __construct(){
        parent::__construct();
        $this->filter('before','auth');
  }

  public function action_index(){  

     if(Auth::user()->user_type!="manager"){
      return Redirect::to('dashboard');
    }

   
    $employees = User::where('type','=','employee')->where('level','!=',99)->order_by('user_type')->order_by('firstname')->get();
    $prevemp = User::where('type','=','fired')->or_where('type','=','quit')->or_where('type','=','layedoff')->order_by('firstname')->get();
    return View::make('employees.enternew')
    ->with('prevemp',$prevemp)
    ->with('employees',$employees);

  }

  public function action_update(){
    $input = Input::get();
    
    if(!empty($input['id'])){
      $emp = User::find($input['id']);
    } else {
      $emp = New User;
    }
    
    $first = str_replace("'","", $input['firstname']);
    $last = str_replace("'","",$input['lastname']);
    if(empty($last)){
      $last = ".";
    }
    
    if(empty($emp->avatar)){
      $emp->avatar = "avatar.jpg";
    }
    if(($input['position']=="salesrep")&&($emp->level==0)){
      $emp->level=1;
    }
    $emp->firstname = ucfirst($first);
    $emp->lastname = ucfirst($last);
    $emp->birthdate = $input['birthdate'];
    $emp->applied_on = $input['applydate'];
    $emp->notes = $input['notes'];
    $emp->sex = $input['sex'];
    $emp->user_type = $input['position'];
    $emp->type  = $input['status'];
    $emp->sinnum = $input['sinnum'];
    $emp->cell_no = $input['cell_no'];
    $emp->phone_no = $input['phone_no'];
    $emp->address = $input['address'];;
    if($emp->save()){
      return Redirect::back();
    };
  }

  public function action_newapplicant(){
    $input = Input::get();
    $emp = New User;
    $type = $input['type'];
    $first = str_replace("'","", $input['firstname']);
    $last = str_replace("'","",$input['lastname']);
    if(empty($last)){
      $last = ".";
    }
    
    if(empty($emp->avatar)){
      $emp->avatar = "avatar.jpg";
    }
    if(($input['position']=="salesrep")&&($emp->level==0)){
      $emp->level=1;
    }
    $emp->firstname = ucfirst($first);
    $emp->lastname = ucfirst($last);
    $emp->birthdate = $input['birthdate'];
    $emp->applied_on = date('Y-m-d');
    $emp->sex = $input['sex'];
    $emp->recruited_by = $input['recruitedby'];
    $emp->user_type = $input['position'];
    $emp->type  = $type;
    $emp->sinnum = $input['sinnum'];
    $emp->cell_no = $input['cell_no'];
    $emp->address = $input['address'];
    if($emp->save()){
      return Redirect::back();
    };

  }

  public function action_list($id=null){
    if($id==null){
      $emp = array();
    } else {
      $emp = User::find($id);
    }
  
     if(Auth::user()->user_type!="manager"){
      return Redirect::to('dashboard');
    }
      
    $applicants = User::where('type','!=','employee')->order_by('user_type')->order_by('lastname')->get();
    $employees = User::where('type','=','employee')->order_by('user_type')->order_by('lastname')->get();

    return View::make('employees.enternew')
    ->with('employee',$emp)
    ->with('applicants',$applicants)
    ->with('employees',$employees);

  }

  public function action_getemployee($id){
    if(!isset($id)){
      return json_encode("failed");
    }

    $emp = User::find($id);
    if($emp){
      return json_encode($emp);
    } else {
      return json_encode("failed");
    }

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

  public function action_delshift($id){
    $shift = Schedule::find($id);
    if($shift->delete()){
      echo json_encode($id);
    };
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
    echo json_encode($arr);
  }

}