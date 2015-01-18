<?php
class Util_Controller extends Base_Controller
{
	public function __construct(){
        	parent::__construct();
        	$this->filter('before','auth');
    	}

	
	public function action_filemanager(){
		$settings = Setting::find(1);
		
		if(empty($settings->file_folders)){
			$settings->file_folders = "DEFAULT";
			$settings->save();
		}
		$folders = explode(",",$settings->file_folders);

		$files = Doc::where('file_folder','!=','')->where('file_folder','!=','avatar')->get();

		return View::make("files.index")
		->with('folders',$folders)
		->with('files',$files);
	}

	public function action_addnewfilefolder(){
		$input = Input::get();
		if(isset($input['file_folder'])){
			$settings = Setting::find(1);
			$name = strtoupper($input['file_folder']);
			$folders = explode(",",$settings->file_folders);	
			if(in_array($name,$folders)){
				Session::flash("exists","Folder already exists");
				return Redirect::back();
			} else {
				$settings->file_folders = $settings->file_folders.",".$name;
				$settings->save();
				return Redirect::back();
			}
		}
	}

	public function action_deletefolder(){
		$input = Input::get();
		if(isset($input['foldername'])){
			$settings = Setting::find(1);
			$name = $input['foldername'];
			$folders = explode(",",$settings->file_folders);
			if($name!="DEFAULT"){
				
 
				if(in_array($name,$folders)){
					$pos = array_search($name, $folders);
					unset($folders[$pos]);
					$newfolders = implode(",",$folders);
					$settings->file_folders = $newfolders;
					if($settings->save()){
						//Check for files and change them all
						DB::query("UPDATE docs SET file_folder = 'DEFAULT' WHERE file_folder='".$name."'");
						return Response::json("success");
					} else {
						return Response::json("failed!!");
					};
				}
			} else {
				return Response::json("isdefault");
			}
			
			
		} else {
			return Response::json("failed!!");
		}


	}

	public function action_movefile(){
		$input = Input::all();
		if(isset($input['movefile_id'])){
			$file = Doc::find($input['movefile_id']);
			if($file){
				$file->file_folder = $input['moveto_folder'];
				$file->save();
				return Redirect::back();
			} else {
				echo "Error moving file - Contact admin!";
			}
		}
	}

	public function action_uploadfile(){
		$input = Input::all();

        if(!empty($input['theDoc']['name'])){
        	$folder = $input['the_folder'];
            $file = Input::file('theDoc');
            $s = Setting::find(1)->shortcode;
            $id = $input['the_folder']."-".$file;
            if($file){$input2 = S3::inputFile($file['tmp_name'], false);}
            $path_parts = pathinfo($file['name']);
            $ext = $path_parts['extension'];
            
               if(!empty($input['theName'])){
                    $filename = $input['theName'].".".$ext;
                } else {
                    $filename = $file['name'];
                }

                if(!empty($input2)){
                    if(S3::putObject($input2, 'salesdash', $s."/officedocuments/".$filename, S3::ACL_PUBLIC_READ)){
                    $file2 = Doc::where('uri','=', $s."/officedocuments/".$filename)->get();
                    if($file2){
                       echo "<span style='font-size:30px'>A File with that Name already exists!</span><br><a href='".URL::to('util/filemanager')."' class='btn btn-large btn-default'>BACK</a>";
                    } else {
                        $f = New Doc;
                        $f->lead_id = 0;
                        $f->sale_id = 0;
                        $f->user_id = Auth::user()->id;
                        $f->notes = $input['theNotes'];
                        $f->filetype = $ext;
                        $f->filesize = $file['size'];
                        $f->filename = $filename;
                        $f->uri = $s."/officedocuments/".$filename;
                        $f->file_folder = $folder;
                        $f->save();
                        return Redirect::back();
                    }
                } else {
                     echo "<span style='font-size:30px'>FAILED!!  Please go back to try again</span><br><a href='".URL::to('util/filemanager')."' class='btn btn-large btn-default'>BACK</a>";
                }

                } else {
                     echo "<span style='font-size:30px'>FAILED!!  Please go back to try again</span><br><a href='".URL::to('util/filemanager')."' class='btn btn-large btn-default'>BACK</a>";
                }
                
            } else {
                echo "<span style='font-size:30px'>NO FILE SELECTED!!  Please go back to try again</span><br><a href='".URL::to('util/filemanager')."' class='btn btn-large btn-default'>BACK</a>";
            }
	}


	public function action_sendtext(){
		$input = Input::get();
	
		$t = New Twilio;
		$id = Input::get('id');
		$theMessage= Input::get('msg');
		$theImage = Input::get('image');
		
		$u = User::find($id);

		if($u){
			$user = $u->firstname." ".$u->lastname;
			if(!empty($u->cell_no)){
				$cell=$u->cell_no;
				if((strlen($cell)>=10)&&(strlen($cell)<=14)){
					$send = $t->sendSMS($cell,$theMessage,$theImage);
					if(($send['status']=='queued')||($send['status']=='sent')){
						$msg = "SMS sent successfully to ".$user;
						$msg2 = "SMS SENT | ".$cell;
						$status="success";
					} else {
						$msg = "Failed to send SMS to ".$user;
						$msg2 = "SMS FAILED!";
						$status="failed";
					}
				} else {
					$msg = "Not a valid Number for ".$user;
					$msg2 = "CHECK NUMBER!" .$cell;
					$status="failed";
				}
			} else {
				$msg = $user." has no cell phone number in system!";
				$msg2 = "ADD USERS NUMBER!";
				$status="failed";
			}
		}  else {
			$msg = "User not in database";
			$msg2 = "USER NOT DEFINED";
			$status="failed";
		
		}
		return Response::json(array("msg"=>$msg,"msg2"=>$msg2,"status"=>$status));
		//return Response::json(array("status"=>"failed"));
	}	


	public function action_task($id=null){
		if($id==null){
			$users = User::where('level','!=',99)->order_by('firstname')->get();
			$tasks = Tasks::order_by('status')->order_by('created_at','DESC')->get();
			return View::make('tasks.tasks')
			->with('users',$users)
			->with('tasks',$tasks);
		} else {
			if($id!=Auth::user()->id){
			return Redirect::back();
		}
			$tasks = Tasks::where('receiver_id','=',$id)->order_by('created_at')->get();
			return View::make('tasks.usertasks')
			->with('tasks',$tasks);
		}
	}

	public function action_bug($type){
			$bugs = Bug::where('type','=',$type)->order_by('priority')->get();
			return View::make('tasks.bugs')
			->with('type',$type)
			->with('bugs',$bugs);
	}

	public function action_bugsubmit(){
		$input = Input::get();
		$rules = array(
			'summary'=>'required','description'=>'required','type'=>'required'
			);
		$v = Validator::make($input,$rules);
		 if($v->fails()){
			return Redirect::back()->with_errors($v)->with_input();
		} else {
			$bug = New Bug;
			$bug->user_id=Auth::user()->id;
			if($input['type']=="answer"){
				$bug->thread_id = $input['thread_id'];
			}
			$bug->summary = $input['summary'];
			$bug->description = $input['description'];
			$bug->type=$input['type'];
			$bug->status = 'unseen';
			$bug->priority = 'urgent';
			$bug->save();
			return Redirect::back();
		}


	}

	public function action_delbug($id){
		$input = Input::get();
		$type = $input['type'];
		$t = Bug::find($id);
		if($type=="archive"){
			$t->status = "archive";
			$t->save();
			return $id;
		} else {
			if(!empty($t->thread)){
				foreach($t->thread as $v){
					$v->delete();
				}
			}
			$t->delete();
			return $id;
		}

		
	}

	public function action_editbug($idtype){
		if(!empty($idtype)){
			$t = explode("-",$idtype);
			$id = $t[0];
			$type = $t[1];
			$bug = Bug::find($id);
			if($bug){
				$bug->status = $type;
				$bug->save();
				return "Success";
			}
		}
	}

	public function action_addtask(){
		$input = Input::get();
		$rules = array('user'=>'required','title'=>'required','details'=>'required');
		$v = Validator::make($input,$rules);
		if($v->fails()){
			return Redirect::back()->with_errors($v)->with_input();
		} else {
			$task = New Tasks;
			$task->sender_id = Auth::user()->id;
			$task->receiver_id = $input['user'];
			$task->title = $input['title'];
			$task->body = $input['details'];
			$task->status = "active";
			$task->save();

			$alert = New Alert;
        		$alert->receiver_id = $input['user'];
        		$alert->type = "personal";
        		$alert->message = "NEW TASK ASSIGNED TO YOU! <a href='".URL::to('util/task')."'>VIEW YOUR TASKS</a>";
        		$alert->color = "info";
        		$alert->icon = "cus-task";
        		$alert->save();
			return Redirect::back();
		}
	}

	public function action_updatetask($data){
		$data = explode("-",$data);
		$t = Tasks::find($data[0]);
		$t->status = $data[1];
		if($t->save()){
			return json_encode($data);
		}
	}

	public function action_deltask($id){
		$t = Tasks::find($id);
		if($t->delete()){
			echo $id;
		}
	}

	public function action_gifts(){
		$gifts = Gift::all();
		$cities = City::where('status','!=','leadtype')->order_by('cityname')->get();
		return View::make('gifts.gifts')
		->with('cities',$cities)
		->with('gifts',$gifts);
	}

	public function action_giftcities(){
		$cities = City::where('status','!=','leadtype')->get();
		$leadtypes = City::where('status','=','leadtype')->get();
		$gifts = Gift::all();
		return View::make('gifts.giftcities')
		->with('leadtypes',$leadtypes)
		->with('cities',$cities)
		->with('gifts',$gifts);
	}

	public function action_giftdelete(){
		$id = Input::get('id');
		$g = Gift::find($id);
		if($g){
			$g->delete();
			echo "success";
		}
	}

	public function action_giftsave(){
		$input = Input::get();
		$gift = Gift::find($input['id']);
		if(!$gift){
			$gift = New Gift;
		}
		$gift->name = $input['name'];
		$gift->desc = $input['desc'];
		$gift->priceper = $input['price'];
		$gift->save();

		echo "success";

	}


	public function action_giftstock(){
		$input = Input::get();
		if(isset($input['gift_gift'])){
			$gift = Gift::find($input['gift_gift']);
			if($gift){
				$qty = intval($input['gift_qty']);
				$cost = intval($qty)*floatval($gift->priceper);
				$gt = New GiftTracker;
				$gt->gift_id = $input['gift_gift'];
				$gt->qty = $qty;
				$gt->type = "order";
				$gt->cost = $cost;
				$gt->user_id = Auth::user()->id;
				$gt->comment = Auth::user()->fullName()." put ".$input['gift_qty']." ".$gift->name." into Stock ";
				$gt->save();
			}
		} 
		$cities = City::where('status','!=','leadtype')->get();
		$leadtypes = City::where('status','=','leadtype')->get();
		$gifts = Gift::all();
		$gifttrack = GiftTracker::all();
		return View::make('gifts.giftstock')
		->with('leadtypes',$leadtypes)
		->with('cities',$cities)
		->with('gifttrack',$gifttrack)
		->with('gifts',$gifts);
	}

	public function action_delgifthistory($id){
		$gift = GiftTracker::find($id);
		if($gift){
			$gift->delete();
			return Redirect::to('util/giftstock');
		}
	}

}