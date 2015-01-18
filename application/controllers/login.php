<?php
class Login_Controller extends Base_Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function action_index(){
    	return View::make('login.index');
    }

    public function action_run(){	
        $uname = Input::get('username');
        $password = Input::get('password');

        $input = array(
            'username' => $uname,
            'password' => $password
        );
        
        $rules = array(
            'username' => 'required|exists:users',
            'password' => 'required'
        );
            
        $validation = Validator::make($input, $rules);
            
        if( $validation->fails() ) {
            return Redirect::to('login')->with_errors($validation);
        }
            
        $credentials = array(
            'username' => $uname,
            'password' => $password
        );
            
        if( Auth::attempt($credentials)) {
            $user = User::find(Auth::user()->id);
            $settings = Setting::where('tenant_id','=',Auth::user()->tenant_id)->first();
            if($user->level==99){
                Session::flash('status_error', 'Your email or password is invalid - please try again.');
                return Redirect::to('login');
            }
            if($settings->track_times==1){
                if(($user->logged==1)&&($user->user_type=="agent")){
                    Session::flash('status_error', 'This user is already logged in on another computer. ');
                    return Redirect::to('login');
                }
            }
            
            $user->session_key = Hash::make($user->username."|".date('Y-m-d H:i:s'));
            $user->logged = 1;
            $user->save();

            $t = New Timelog;
            $t->session_key = $user->session_key;
            $t->user_id = $user->id;
            $t->log_in = date('Y-m-d H:i:s');
            $t->save();

            $mobileEnabled = $settings->mobile;
            if($user->user_type=="salesrep" || $user->user_type=="doorrep"){
                
            if($mobileEnabled==true){
                if(! empty($_SERVER['HTTP_USER_AGENT'])){
                    $useragent = $_SERVER['HTTP_USER_AGENT'];
                    if(preg_match('@(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)@', $useragent) ){
                        return Redirect::to('mobile/dashboard');
                    }
                }
            }
            } else if(Auth::user()->user_type=="researcher"){
                //return Redirect::to('lead');
                echo "Arrived";
            }

            return Redirect::to('dashboard');
        } else {
            sleep(3);
            Session::flash('status_error', 'Your email or password is invalid - please try again.');
            return Redirect::to('login');
        }
    }
}