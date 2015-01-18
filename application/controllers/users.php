<?php
class Users_Controller extends Base_Controller
{
	public function __construct(){
        parent::__construct();
        $this->filter('before', 'auth');
    }

    public function action_profile($id){
        $user = User::find($id);
        if(Auth::user()->user_type!="manager"){
            if($id!=Auth::user()->id){
                return Redirect::back();
            }
        }
        if($user){
            return View::make('profile.agent')
            ->with('user',$user);
        } else {
            return Redirect::back();
        }
    }

    public function action_viewprofile($user_id){
        $input = Input::get();
        $user = User::find($user_id);
        if($user){
            if($user->user_type=="agent"){
                return View::make('profile.agent')
                ->with('user',$user);
            } else {
                if(isset($input['viewDistributor'])){
                    $site = $input['viewDistributor']."/presentation/viewrep/".$user_id;
                } else {
                    $site = URL::to("presentation/viewrep/").$user_id;
                }
                return View::make('profile.empty')
                ->with('profile',$site);
            }
        } else {
            return Redirect::back();
        }
    }

    public function action_loadrecruits($id){
        $user = User::find($id);
        $users = User::activeUsers("salesrep");
        if($user){
            return View::make('plugins.recruits')
            ->with('users',$users)
            ->with('user',$user);
        } else {
            echo "No User Found!!";
        }
        
    }

   

    public function action_addnewnote(){
        $input = Input::get();

        if(!empty($input)){
            $note = New Tasks;
            $note->receiver_id = $input['userid'];
            $note->sender_id = Auth::user()->id;
            $note->body = $input['thenote'];
            $note->status = "usernote";
            $note->save();
             $note->created_at = date('Y-m-d');
            $u = User::find(Auth::user()->id);
            if($u){
                $note->sender_id = $u->firstname." ".$u->lastname;
            }
            
            return json_encode($note);
        } else {
            return json_encode("failed");
        }
    }

    

    public function action_leadlist(){
        $input = Input::get();
        if(isset($input['date'])){
            if($input['date']=="today"){
                $date = "AND DATE(entry_date) = DATE('".date('Y-m-d')."')";
            } else {
                if(isset($input['start'])&&isset($input['end'])){
                    $date = "AND DATE(entry_date)>=DATE('".$input['start']."') AND DATE(entry_date)<=DATE('".$input['end']."')";
                } else {
                    $date = "";
                }
            }
        } else {
            $date = "";
        }
        $leads = DB::query("SELECT id,status,referral_id,cust_name,spouse_name,fullpart,rentown,address,entry_date,smoke,pets,asthma,cust_num, leadtype
            FROM leads WHERE researcher_id='".Auth::user()->id."' $date ORDER BY entry_date DESC, cust_name ASC");
        $lead=array();
        foreach($leads as $l){
            if($l->referral_id!=0){
                $ref = Lead::find($l->referral_id);
                if($ref){
                    $l->referral_id = $ref->cust_name. " | ID# ".$ref->id." | ".$ref->cust_num;
                }
            } 
            $lead[] = $l;
        }
        return Response::json($lead);
    }

    public function action_mobilestats($type){
        $input = Input::get();
        if(isset($input['date'])){
            if($input['date']=="today"){
                $date = "AND DATE(entry_date) = DATE('".date('Y-m-d')."')";
            } else {
                if(isset($input['start'])&&isset($input['end'])){
                    $date = "AND DATE(entry_date)>=DATE('".$input['start']."') AND DATE(entry_date)<=DATE('".$input['end']."')";
                } else {
                    $date = "";
                }
            }
        } else {
            $date = "";
        }
        $leads = DB::query("SELECT COUNT(id) total, entry_date, researcher_name, researcher_id,
            SUM(status!='NEW' AND status!='INACTIVE') contact, SUM(status='APP') booked,SUM(result='SOLD') sold,SUM(result='DNS') dns, SUM(status='INVALID') renter, SUM(status='DELETED') old, 
        SUM(status='NQ') nq, SUM(status='NI') ni, SUM(status='NEW') avail, SUM(status='WrongNumber') wrong,
        SUM(status='INACTIVE') unreleased, SUM(status='DNC') dnc FROM leads WHERE researcher_id ='".Auth::user()->id."' $date GROUP BY entry_date ORDER BY entry_date");
       
        return Response::json($leads);
    }

    public function action_deletenote($id){
        $t = Tasks::find($id);
        if($t->delete()){
            return "success";
        };
    }

    public function action_contactbook($page=null){
        $users = User::where('id','!=',58)->where('level','!=',99)->where('type','=','employee')->order_by('user_type')->order_by('firstname')->order_by('lastname')->get(array('id','firstname','lastname','companyname','address','cell_no','phone_no','user_type','avatar','texting'));
     
        if($page==null){
            $page = 'salesrep';
        } 

        return view::make('plugins.contactbook')
        ->with('users',$users)
        ->with('page',$page);

    }

    public function action_addother(){
        $input = Input::get();

        $user = New User;
        $user->firstname = $input['firstname'];
        $user->lastname = $input['lastname'];
        $user->companyname = $input['companyname'];
        $user->cell_no = $input['cell_no'];
        $user->phone_no = $input['phone_no'];
        $user->level =88;
        $user->user_type="other";
        $user->type="employee";
        if($user->save()){
            return json_encode("success");
        };

    }

    public function action_enabletext($id=null){
        if($id==null){
            return json_encode("failed");
        }

        $chk = Input::get('chk');
        $u = User::find($id);
        if($u){
            $u->texting = $chk;
            if($u->save()){
                return json_encode("success");
            } 
        } else {
            return json_encode("failed");
        }

    }

    public function action_profilesplinechart($thetime){
        $thetime = explode("-",$thetime);
        
        $dailystats = DB::query("SELECT count(*) as total, caller_id, created_at, SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,SUM(result = 'APP') app,
            SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
            SUM(result = 'WrongNumber') wrong, SUM(result='APP' AND leadtype='paper' ) manilla, SUM(result='APP' AND leadtype='door' ) door,
            SUM(result = 'APP' AND leadtype='other') scratch FROM calls WHERE caller_id='".$thetime[0]."' GROUP BY $thetime[1](created_at)");

            $app="";$dnc="";$ni="";$nh="";$nq="";$wrong="";$tot="";$dates="";$recall="";
            $prev_date=""; $i=0;
            foreach($dailystats as $val){
                if(date('D d',strtotime($val->created_at))!=$prev_date){
                    $prev_date = date('D d',strtotime($val->created_at));
                    $day = "Day ".$i++;
                } else {
                    $day="";
                }
                $app[]=intval($val->app);
                $dnc[]=intval($val->dnc);
                $ni[]=intval($val->ni);
                $wrong[]=intval($val->wrong);
                $recall[]=intval($val->recall);
                $nh[]=intval($val->nh);
                $dates[]=$day;
            }

            $dailystats = array("app"=>$app,"dnc"=>$dnc,"ni"=>$ni,"wrong"=>$wrong,"recall"=>$recall,"nh"=>$nh,"dates"=>$dates);
            return json_encode($dailystats);
    }

    public function action_profilebarchart($thetime){
        
        $dailystats2 = DB::query("SELECT caller_id, AVG(total) as avgcalls, AVG(ni) as avgni, AVG(dnc) as avgdnc,AVG(app) as avgapp,AVG(wrong) as avgwrong FROM(SELECT count(*) as total, caller_id, SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,SUM(result = 'APP') app,
            SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
            SUM(result = 'WrongNumber') wrong, SUM(result='APP' AND leadtype='paper' ) manilla, SUM(result='APP' AND leadtype='door' ) door,
            SUM(result = 'APP' AND leadtype='other') scratch FROM calls GROUP BY caller_id, $thetime(created_at)) as SUBQUERY GROUP BY caller_id ORDER BY avgapp DESC");

        foreach($dailystats2 as $val){
            $u = User::find($val->caller_id);
            if($u){
                if($u->user_type=="agent"){
                    $arr[]=$val;
                    $names[] = $u->firstname." ".$u->lastname;
                    $ni[] = intval($val->avgni);
                    $calls[] = intval($val->avgcalls);
                    $app[] = intval($val->avgapp);
                    $wrong[] = intval($val->avgwrong);
                }
            }
        }
        if($thetime=="DATE"){
            $tit = "Daily";
        } else if($thetime=="WEEK"){
            $tit = "Weekly";
        } else if($thetime=="HOUR"){
            $tit = "Hourly";
        } else if($thetime=="MONTH"){
            $tit="Monthly";
        }
        $title = $tit." Booking Averages By Marketer";
        
        $thedata = array(
            array("name"=>"calls","data"=>$calls,"color"=>"#000"),
            array("name"=>"ni","data"=>$ni,"color"=>"#990000"),
            array("name"=>"app","data"=>$app,"color"=>"#00FF00")
            );

        return json_encode(array("values"=>$thedata,"names"=>$names,"title"=>$title));
    }

    public function action_marketingavg($thetime){
        
        $dailystats2 = DB::query("SELECT caller_id, AVG(total) as avgcalls, AVG(ni) as avgni, AVG(dnc) as avgdnc,AVG(app) as avgapp,AVG(nh) as avgnh,AVG(wrong) as avgwrong FROM(SELECT count(*) as total, caller_id, SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,SUM(result = 'APP') app,
            SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
            SUM(result = 'WrongNumber') wrong, SUM(result='APP' AND leadtype='paper' ) manilla, SUM(result='APP' AND leadtype='door' ) door,
            SUM(result = 'APP' AND leadtype='other') scratch FROM calls GROUP BY caller_id, $thetime(created_at)) as SUBQUERY GROUP BY caller_id ORDER BY avgapp DESC");

        foreach($dailystats2 as $val){
            $u = User::find($val->caller_id);
            if($u){
                if($u->user_type=="agent"){
                   $val->caller_id = $u->firstname." ".$u->lastname;
                   $arr[]=$val;
                }
            }
        }
        if($thetime=="DATE"){
            $tit = "Daily";
        } else if($thetime=="WEEK"){
            $tit = "Weekly";
        } else if($thetime=="HOUR"){
            $tit = "Hourly";
        } else if($thetime=="MONTH"){
            $tit="Monthly";
        }
        $title = $tit." Booking Averages By Marketer";
       

        return json_encode(array("values"=>$arr,"title"=>$title));
    }

     public function action_salesavg($thetime){
        
        $dailystats2 = DB::query("SELECT rep_id, AVG(total) as avgdems, AVG(ni) as avgni, 
            AVG(dns) as avgdns,AVG(app) as avgapp, AVG(sold) as avgsold,
            AVG(nh) as avgnh FROM(SELECT count(*) as total, rep_id, SUM(status != '' AND status != 'CONF' AND status != 'NA') tot,SUM(status = 'APP') app,
            SUM(status = 'DNS') dns,SUM(status = 'NH') nh,SUM(status = 'NI') ni,SUM(status = 'NQ') nq, SUM(status='SOLD') sold FROM appointments GROUP BY rep_id, $thetime(app_date)) as SUBQUERY GROUP BY rep_id ORDER BY avgapp DESC");

        foreach($dailystats2 as $val){
            $u = User::find($val->rep_id);
            if($u){
                if($u->user_type=="salesrep"){
                   $val->rep_id = $u->firstname." ".$u->lastname;
                   $arr[]=$val;
                }
            }
        }
        if($thetime=="DATE"){
            $tit = "Daily";
        } else if($thetime=="WEEK"){
            $tit = "Weekly";
        } else if($thetime=="HOUR"){
            $tit = "Hourly";
        } else if($thetime=="MONTH"){
            $tit="Monthly";
        }
        $title = $tit." Sales Averages By Dealer";
       

        return json_encode(array("values"=>$arr,"title"=>$title));
    }

    public function action_create(){

        $input = array('username' => Input::get('username'),
            'password' => Input::get('password'));
        
        $rules = array('username' => 'required|unique:users',
            'password' => 'required');
       
        $validation = Validator::make($input, $rules);
            if( $validation->fails() ) {
                return Redirect::to('agent')->with_errors($validation);
            }

		$user = New User;
        $user->username = Input::get('username');
        $user->password = Hash::make(Input::get('password'));
        $user->firstname = ucfirst(Input::get('firstname'));
        $user->lastname = ucfirst(Input::get('lastname'));
        $user->avatar = "avatar.jpg";
		$user->cell_no = Input::get('cellno');
		$user->email = Input::get('email');
        $user->user_type = Input::get('typeofuser');
        $user->save();
        return Redirect::back();
    }

     public function action_createfromemployee(){
        $id = Input::get('user-id');
        $input = array('username' => Input::get('user-name'),
            'password' => Input::get('user-pwd'));
        
        $rules = array('username' => 'required|unique:users',
            'password' => 'required');
       
        $validation = Validator::make($input, $rules);
            if( $validation->fails() ) {
                return Redirect::to('employee')->with_errors($validation);
            }

        if($id){
        $user = User::find($id);
        $user->username = Input::get('user-name');
        $user->password = Hash::make(Input::get('user-pwd'));
        $user->type = "employee";
        $user->level = 1;
        $user->avatar = "avatar.jpg";
        $user->save();
        } 

      
        return Redirect::to('employee');
    }

    public function action_newlogin(){
        $input = Input::get();
        $rules = array("user-id"=>"required","newpass"=>"required");
        $v = Validator::make($input, $rules);
            
        if( $v->fails() ) {
            return Redirect::back()->with_errors($v);
        }
        
        $user = User::find($input['user-id']);
        $new_pass = Input::get('newpass');
        $user->password = Hash::make($new_pass);
        if($user->save()){
            echo "<font size=20px>SUCCESS! </font><br/>";
            echo "Please get the user you just changed to logout and login again.<br/>";
            echo "<font size=16px><a href='".URL::to('employee')."'>BACK</a></font>";
        };

   

    }

    public function action_edit(){
    	$input = Input::get();
        $x = explode("|", $input['id']);
        $user = User::find($x[1]);
        if($x[0]=="payrate"){
            $input['value'] = number_format(str_replace("$","",$input['value']),2,'.','');
        }

        if($x[0]=="recruited_by"){
            //TODO ADD GAMES POINTS HERE
            
        }

        $user->$x[0] = $input['value'];
        $t = $user->save();
        if(($x[0]=="firstname")||($x[0]=="lastname")){
            if(($user->user_type=="agent")||($user->user_type=="manager")){
                DB::query("UPDATE leads SET researcher_name='".$user->firstname." ".$user->lastname."' WHERE researcher_id='".$user->id."'");
                DB::query("UPDATE leads SET booker_name='".$user->firstname." ".$user->lastname."' WHERE booker_id='".$user->id."'");
                DB::query("UPDATE appointments SET booked_by='".$user->firstname." ".$user->lastname."' WHERE booker_id = '".$user->id."' ");
               if($x[0]=="firstname"){
                 DB::query("UPDATE calls SET caller_name='".$user->firstname."' WHERE caller_id='".$user->id."'");
               }
               return $input['value'];
            } else if($user->user_type=="salesrep"){
                DB::query("UPDATE leads SET rep_name='".$user->firstname." ".$user->lastname."' WHERE rep='".$user->id."'");
                DB::query("UPDATE sales SET sold_by='".$user->firstname." ".$user->lastname."' WHERE user_id='".$user->id."'");
                DB::query("UPDATE appointments SET rep_name='".$user->firstname." ".$user->lastname."' WHERE rep_id = '".$user->id."' ");
                DB::query("UPDATE inventory SET sold_by='".$user->firstname." ".$user->lastname."' WHERE user_id='".$user->id."' AND status='Sold' ");
                DB::query("UPDATE inventory SET checked_by='".$user->firstname." ".$user->lastname."' WHERE user_id='".$user->id."' AND status='Checked Out' ");
                return $input['value'];
            }
        }
        if($t){
            return $input['value'];
        } else {
            return "Save Failed!";
        }
    }


    public function action_delete($id){
    	$user = User::find($id);
    	$user->level = 99;
        $user->password="";
        $user->username="";
        $user->type='quit';
        $user->save();
    	echo json_encode("success");
    }

    public function action_fulldelete($id){
        $user = User::find($id);
        if($user->user_type=="other"){
            $user->delete();
            return Response::json($id);
        }
    }

    public function action_quit(){
        $input = Input::get();
        $user = User::find($input['user-id']);
        if($user){
            $user->level=99;
            $user->type = $input['status'];
            $user->username="";
            $user->password="";
            $user->save();
        return Redirect::back();}
    }

  

    public function action_activate($id){
        $user = User::find($id);
        $user->level = 1;
        $user->type = "employee";
        $user->save();
        return Redirect::back();
    }

    public function action_logout()
    {
        $user = User::find(Auth::user()->id);
        $user->logged = 0;
        $user->save();        
        
        $t = Timelog::where('session_key','=',$user->session_key)->first();
        if($t){
            $t->log_out = date('Y-m-d H:i:s');
            $t->difference = gmdate("H:i:s",round(abs(strtotime($t->log_out) - strtotime($t->log_in))));
            $t->save();
        }
       

        Auth::logout();
        return Redirect::to('home');
    }

    public function action_credits(){
        $input = Input::get();

        if($input['type']=="dec"){
            $u = User::find(Auth::user()->id);
            
            if($u->spins!=0){
            $u->spins = $u->spins-1;
            $u->credits = $u->credits-1;
            $u->logged_spins = $u->logged_spins+1;}
            $u->save();
            return json_encode(array('credits'=>$u->credits,'spins'=>$u->spins));
        }elseif($input['type']=="inc"){
            $u = User::find(Auth::user()->id);
            
            if($u->spins!=0){
            $u->credits = $u->credits+$input['amount'];
            $u->logged_spins = $u->logged_spins+1;
            $u->spins = $u->spins-1;}
            $u->save();
            return json_encode(array('credits'=>$u->credits,'spins'=>$u->spins));
        }



    }




}
