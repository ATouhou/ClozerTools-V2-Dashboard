<?php
class Dashboard_Controller extends Base_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->filter('before','auth');
    }

    public function action_index()
    {   
        // Maybe load initial data
        // Load site data
        if(Auth::user()->user_type=="manager"){
            return Redirect::to('dashboard/manager');
        }
        if(Auth::user()->user_type=="salesrep"){
            return Redirect::to('dashboard/salesrep');
        }
        
        return "Acccess Allowed";
    }

    public function action_manager(){
        // Manager data goes here;
        return View::make('dashboard.manager');
    }

    public function action_agent($type=null){
        //$type refers to bucket - leadtype
        // Agent data goes here       
    }




    //FUNCTIONS FOR DASHBAORD
    public function action_requestleads(){
        $message = Setting::find(1)->lead_request;
        $alert = Alert::find(6);
        $alert->message = "<span class='label label-success special '>".Auth::user()->fullName()."</span><br/><b> ".$message."</b><br/><span class='label label-info special'> ".date('h:i a')."</span>";
        $alert->type = "all";
        $alert->color = "error";
        $alert->seen = 0;
        $alert->icon = "cus-telephone";
        $t = $alert->save();
        if($t){
            echo "success";
        }
    }

    public function action_avatarupload(){
        $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
        $max_file_size = 200 * 1024; #200kb
        $nw = $nh = 150; # image with # height
        $input = Input::all();
        $rules = array(
            'image' => 'required|max:5000', //image upload must be an image and must not exceed 500kb
        );
        $validation = Validator::make($input, $rules);
        if( $validation->fails() ) {
            return Redirect::to('dashboard/profile')->with_errors($validation);
        }

        $file = Input::file('image');
        $s = Setting::find(1)->shortcode;
        $user_id = $input['avatarID'];           
       
        $filename = $s."/avatars/".$user_id."-avatar.jpg";        
        $path_parts = pathinfo($file['name']);
        $ext = $path_parts['extension'];
        if(!in_array($ext, $valid_exts)){
          echo "INVALID FORMAT!!!!";
        } else {
        //Resizer 
        $size = getimagesize($file['tmp_name']);
        $x = (int) $input['x'];
        $y = (int) $input['y'];
        $w = (int) $input['w'] ? $input['w'] : $size[0];
        $h = (int) $input['h'] ? $input['h'] : $size[1];

        $data = file_get_contents($file['tmp_name']);
        $vImg = imagecreatefromstring($data);
        $dstImg = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
          $filename2 = tempnam(sys_get_temp_dir(), "foo");
          imagejpeg($dstImg, $filename2);
          //Send to S3
          $input2 = S3::inputFile($filename2, false);
          if(S3::putObject($input2, 'salesdash', $filename, S3::ACL_PUBLIC_READ)){
              
              $user = User::find($user_id);
              if($user){
                  $user->avatar = $user_id."-avatar.jpg";
                  $user->save();
                  return Redirect::back();
               } else {
                  
                  return Redirect::back();
              }
          } else {
            echo "UPLOAD FAILED!";
          }
        }
    }
}