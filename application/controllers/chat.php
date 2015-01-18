<?php
class Chat_Controller extends Base_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->filter('before','auth');
    }


    public function action_index(){
    	$chattabs = User::find(Auth::user()->id)->chattabs;
    	if(!empty($chattabs)){
    	$chattabs = explode(",",$chattabs);}
    	$agents = User::get();
    	
    	
    	return View::make('chat.index')->with('tabs',$chattabs)->with('agents',$agents);
    }

    public function action_systemmessage(){

        $allalert = Alert::where("seen","=",0)->take(5)->get();
       return View::make('chat.systemmsg')
       ->with('allalert',$allalert);
     
    }

    public function action_savealert(){

        $id = Input::get('msg_id');
        $msg = Input::get('message');

        $alert = Alert::find($id);
        $alert->message = $msg;
        $alert->save();
    }

    public function action_newmsg(){
    	$message = Input::get('message');
    	$receiver = Input::get('receiver_id');

    	$newmsg = New Message;
    	$newmsg->sender_id = Auth::user()->id;
    	$newmsg->receiver_id = $receiver;
    	$newmsg->msg_body = $message;
    	$test = $newmsg->save();

        $alert = New Alert;
        $alert->receiver_id = $receiver;
        $alert->message = "NEW MESSAGE FROM ".Auth::user()->firstname." ".Auth::user()->lastname." : ".$message;
        $alert->type = "message";
        $alert->save();
    }
    
    public function action_assigntab($id){
    
    $you = User::find(Auth::user()->id);

    if(!empty($you->chattabs)){
    $tabs = explode(",",$you->chattabs);
    array_push($tabs,$id);
    $tabs = array_unique($tabs);
    $tabs = implode(",", $tabs);
    } else {$tabs = $id;}
    $you->chattabs = $tabs;
    $you->save();
	Session::put('chat-tab', $id);
    return Redirect::to('chat');
    }
    
    public function action_deletetab(){
    $id = Input::get('tab_id');
    $you = User::find(Auth::user()->id);
    if(!empty($you->chattabs)){
    
    $tabs = explode(",",$you->chattabs);
    array_push($tabs,$id);
    
    $tabs = array_unique($tabs);
    $count = count($tabs);
    for($i=0;$i<$count;$i++){
    echo $tabs[$i]."<br>";
    if($tabs[$i]==$id){
    unset($tabs[$i]);
    }
    }
    $id = $tabs[0];
    $tabs = implode(",", $tabs);
    } else {$tabs = $id;}
    
    $you->chattabs = $tabs;
    $you->save();
    Session::put('chat-tab', $id);
    return Redirect::to('chat');
    
    }

    public function action_getmsgs($id){
			$messages = Message::where('sender_id','=',$id)
			->where('receiver_id','=',Auth::user()->id)
			->or_where('sender_id','=',Auth::user()->id)
			->where('receiver_id','=',$id)
			->order_by('created_at','DESC')->take(15)
			->get();
    	foreach($messages as $val){
        $user = User::find($val->sender_id);
        if(!empty($user->avatar)){$avatar = '<img src="'.URL::to_asset('images/').$user->avatar.'" alt="" width=30px>';}
        else {$avatar =  '<img src="img/default-avatar.gif" alt="" width=30px>';}
        if($val->sender_id==Auth::user()->id){$type="message-box you"; $who="Me";} else {$val->status = "seen";$val->save(); $type="message-box"; $who=ucfirst(User::find($val->sender_id)->firstname);}
        echo '<p id="message-dynamic-' . $val->id . ' class="'.$type.'">'.$avatar.'<span class="message"><strong>&nbsp;&nbsp;'.$who.'</strong><span class="message-time">'.$val->created_at.'</span><span class="message-time">'.ucfirst($val->status).'&nbsp;&nbsp;</span><span class="message-text">' . $val->msg_body . '</span></span></p>';
        }
    }

    public function action_alertsystem(){
        $messages = Alert::where('seen','=','0')
        ->where('type','=','all')
        ->or_where('type','=',Auth::user()->user_type)
        ->order_by('id','DESC')
        ->get();
        

        $rightaways = City::where('status','=','active')->get(array('id','cityname','rightaway'));
        $activetasks = Tasks::where('receiver_id','=',Auth::user()->id)->where('status','=','active')->count();
        $seentasks = Tasks::where('receiver_id','=',Auth::user()->id)->where('status','=','seen')->count();
        if(($activetasks>0)||($seentasks>0)){
            if($activetasks==1){$p="";} else {$p="S";};
            if($seentasks==1){$s="";} else {$s="S";};
            echo "<div class='rightaways'>";
                if($activetasks>0){
                    echo "<span class='label label-warning special animated bounce gotone' style='color:#000'>You have <span class='label label-important special'>".$activetasks."</span> TASK".$p." to deal with</span><br/>";
                }
                if($seentasks>0){
                     echo "<br/><span class='label label-warning special animated bounce gotone' style='color:#000'>You are working on <span class='label label-important special'>".$seentasks."</span> TASK".$s."</span><br/>";
                }
              echo "<br/><a href='".URL::to('util/task')."/".Auth::user()->id."'><button class='btn btn-default'>VIEW YOUR TASKS</button></a><br/><br/>";
              echo "</div>";
        }

        if(!empty($rightaways)){

        $head=0;
            foreach($rightaways as $val){
                if($val->rightaway!=0){
                    if($head==0){
                        
                         echo "<div class='rightaways'>";
                         echo "<h5>RIGHT AWAYS NEEDED!!</h5>";
                        }
                    $head++;
                        echo "<span class='label label-warning special animated bounce gotone' style='color:#000'>".$val->cityname." : </span>&nbsp;&nbsp;<span class='badge badge-info special animated slideInLeft' style='font-size:14px;padding:7px;'>".$val->rightaway."</span>";
                        echo "<br/><a href='".URL::to('cities/gotrightaway/').$val->id."'><button class='btn btn-small gotone' style='margin-top:5px;' ><i class='cus-accept'></i>&nbsp;CLICK IF YOU GOT ONE!</button></a><br/><br/>";
                    }
            }
            if($head==1){ echo "</div>";
            
        }
       
        }

        echo "<div class='messagebox'>";
        
        echo "<h3>System Messages</h3>";
        foreach($messages as $val){
         if(isset($val->icon)){$icon = $val->icon;} else {$icon = "cus-exclamation";}
         if(isset($val->color)){$alert = $val->color;}else {$alert = "warning";}
         if($alert=="error"){
            $anim = "animated wobble";
         } else {
            $anim = "";
         }
        if(!empty($val->message)){
            if($val->type=="all"){
                $title = "<b>General Message:</b><br>";
            } else if($val->type=="agent"){
                $title = "<b>Booker Message:</b><br>";
            } else if($val->type=="salesrep"){
                $title = "<b>Specialist Message:</b><br>";
            } else if($val->type=="researcher"){
                $title = "<b>Door Rep Message:</b><br>";
            }
            $button="<button class='close sysmsgclose' data-id='".$val->id."' data-dismiss='alert'>×</button>";
        echo "<div class='alert adjusted alert-".$alert." ".$anim."'>".$button."<i class='".$icon."'></i>".$title."".$val->message."</div>";
        
        }}
        echo "</div>";


    }

    public function action_appointmentalert(){
        $msg = Alert::find(6);
        if($msg->seen==0){
        echo $msg->message;
        } else {
            echo "none";
        }




    }

    public function action_appointmentacknowledge(){
        $msg = Alert::find(6);
        $msg->seen=1;
        $msg->save();

    }

    public function action_delalert(){
        $id = Input::get('alert_id');
        $alert = Alert::find($id);

        if(Auth::user()->user_type=="manager"){
            if($id==6){
                $alert->seen = 1;
                $alert->save();
                return json_encode(array("type"=>"success","msg"=>"Request for leads acknowledged"));
            }
        }
    
        if($alert->receiver_id!="0"){
        $alert->seen = "1";
        $alert->save();
            return json_encode(array("type"=>"success","msg"=>"Alert Acknowledged!"));
        } else {
            return json_encode(array("type"=>"warning","msg"=>"You cannot remove this Alert<br>Its a system alert"));
        }
    

    }





}