<?php
class Crew_Controller extends Base_Controller
{
	public function __construct(){
    parent::__construct();
    $this->filter('before','auth');
  
  }

   public function action_index(){
    	$dealers = User::activeUsers("salesrep");
    	$crews = Roadcrew::get();
    	$cities = City::where('status','!=','leadtype')->order_by('cityname')->get();
      return View::make('cities.crews')->with('dealer',$dealers)->with('crews',$crews)->with('cities',$cities);
    }

    public function action_createcrew(){
    	$input = Input::get();

    	$crew = New Roadcrew;
    	$crew->crew_name = $input['crew_name'];
    	if($crew->save()){
    		if(!empty($input['crew_manager'])){
    			$crewman = New Crew;
    			$crewman->user_id = $input['crew_manager'];
    			$crewman->crew_id = $crew->id;
    			$crewman->type = "crewmanager";
    			$crewman->save();
    		}
    		return Redirect::back();
    	}

    }

    public function action_removecrewitem($id){
    	if(!empty($id)){
    		$c = Crew::find($id);
    		$c->delete();
    		return json_encode("success");
    	} else {
    		return false;
    	}
    }

    public function action_adddealertocrew(){
    	$input = Input::get();
    	$arr = array();$cities=array();

    	if(!empty($input['crewmanager'])){
    		$chk = Crew::where('user_id','=',$input['crewmanager'])->where('crew_id','=',$input['crew_id'])->first();
    		if($chk){
    			$chk->type="crewmanager";
    			$chk->save();
          $msg = array("status"=>"success","msg"=>$chk->member->firstname." ".substr($chk->member->lastname,0,1)." added to Crew as Crew Manager");
          $arr[] = array("id"=>$check->id,"name"=>$check->member->firstname." ".substr($check->member->lastname,0,1),"type"=>$check->type,"msg"=>$msg);
    		} else {
    			$member = New Crew;
    			$member->user_id = $input['crewmanager'];
    			$member->crew_id = $input['crew_id'];
    			$member->type="crewmanager";
    			$member->save();
          $msg = array("status"=>"success","msg"=>$member->member->firstname." ".substr($member->member->lastname,0,1)." added to Crew as Crew Manager");
          $arr[] = array("id"=>$member->id,"name"=>$member->member->firstname." ".substr($member->member->lastname,0,1),"type"=>$member->type,"msg"=>$msg);
    		}
    	}

    	if(!empty($input['vanmanager'])){
    		$chk = Crew::where('user_id','=',$input['vanmanager'])->where('crew_id','=',$input['crew_id'])->first();
    		if($chk){
    			$chk->type="vanmanager";
    			$chk->save();
          $msg = array("status"=>"success","msg"=>$chk->member->firstname." ".substr($chk->member->lastname,0,1)." added to Crew as Van Manager");
          $arr[] = array("id"=>$check->id,"name"=>$check->member->firstname." ".substr($check->member->lastname,0,1),"type"=>$check->type,"msg"=>$msg);
    		} else {
    			$member = New Crew;
    			$member->user_id = $input['vanmanager'];
    			$member->crew_id = $input['crew_id'];
    			$member->type="vanmanager";
    			$member->save();
          $msg = array("status"=>"success","msg"=>$member->member->firstname." ".substr($member->member->lastname,0,1)." added to Crew as Van Manager");
          $arr[] = array("id"=>$member->id,"name"=>$member->member->firstname." ".substr($member->member->lastname,0,1),"type"=>$member->type,"msg"=>$msg);
    		}
    	}

    	if(!empty($input['crew_dealer'])){
    		foreach($input['crew_dealer'] as $val){
    			if(!empty($val)){
    				$chk = Crew::where('user_id','=',$val)->where('crew_id','=',$input['crew_id'])->get();
    				if(!$chk){
    					$member = New Crew;
    					$member->user_id = $val;
    					$member->crew_id = $input['crew_id'];
    					$member->type="dealer";
    					$member->save();
    					$msg = array("status"=>"success","msg"=>$member->member->firstname." ".substr($member->member->lastname,0,1)." added to Crew");
    					$arr[] = array("id"=>$member->id,"name"=>$member->member->firstname." ".substr($member->member->lastname,0,1),"type"=>$member->type,"msg"=>$msg);
    				} else {
    					$msg = array("status"=>"failed","msg"=>User::find($val)->firstname." ".substr(User::find($val)->lastname,0,1)." already in Crew");
    					$arr[] = array("id"=>0,"name"=>0,"type"=>0,"msg"=>$msg);
    				}
    			}
    		}
    	}

    	 if(!empty($input['crew_cities'])){
    		foreach($input['crew_cities'] as $val){
    			if(!empty($val)){
    				$chk = Crew::where('city_id','=',$val)->where('crew_id','=',$input['crew_id'])->get();
    				if(!$chk){
    					$member = New Crew;
    					$member->city_id = $val;
    					$member->crew_id = $input['crew_id'];
    					$member->type="city";
    					$member->save();
    					$msg = array("status"=>"success","msg"=>$member->city->cityname." added to Crew");
    					$cities[] = array("id"=>$member->id,"name"=>$member->city->cityname,"type"=>$member->type,"msg"=>$msg);
    				} else {
    					$msg = array("status"=>"failed","msg"=>City::find($val)->cityname." already in Crew");
    					$cities[] = array("id"=>0,"name"=>0,"type"=>0,"msg"=>$msg);
    				}
    			}
    		}
    	}
     return json_encode(array("crew_id"=>$input['crew_id'],"dealers"=>$arr,"cities"=>$cities));

    	
    }

    public function action_crewedit(){
      $input = Input::get();
      $x = explode("|", $input['id']);
      $crew = Roadcrew::find($x[1]);
      	$crew->$x[0] = $input['value'];
      	$test = $crew->save();
    		if($test) return $input['value'];
    }

    public function action_crewdelete($id){
    	$crew = Roadcrew::find($id);
    	if($crew){
        $del = Crew::where('crew_id','=',$id)->get();
        if($del){
          foreach($del as $d){
            $d->delete();
          }
        }
    		$crew->delete();
    		return json_encode("success");
    	} else {
    		return false;
    	}

    }


  public function action_manage(){
  	$crews = array();
  	if(Auth::user()->user_type=="manager"){
  		$crews = Roadcrew::get();
  	} else {
  		$crew = Crew::where('user_id','=',Auth::user()->id)->get();
  	}
  	if(isset($crew)){
  		foreach($crew as $c){
  			$rc = Roadcrew::find($c->crew_id);
  			if($rc){
  				$crews[] = $rc;
  			}
  		}
  	}

  	$dealers = User::activeUsers("salesrep");
    $cities = City::where('status','!=','leadtype')->order_by('cityname')->get();
    return View::make('inventory.crew')->with('dealer',$dealers)->with('crews',$crews)->with('cities',$cities);
  }

  public function action_loadcrew($id){
  	$crew = Roadcrew::find($id);
  	$crews = array();
  	$cities = array();
  	$city=array();
  	  	if($crew){
  			$cities[] = $crew->cities();
  		}
  	if(!empty($cities)){
  		foreach($cities[0] as $c){
  			if(!empty($c)){
  			$ci = City::find($c->attributes['city_id']);
  				if($ci){
  					$cityname = $ci->cityname;
  					$inv = Inventory::where('status','=','In Stock')->where('location','=',$cityname)->order_by('created_at')->get();
  					$city[] =array("cityname"=>$cityname,"city_id"=>$ci->id,"inventory"=>$inv);
  				}
  			}
  		}
  	}
  	return View::make('plugins.crewinventory')
  	->with('inventory',$city)->with('crew',$crew);
  }


 }
