<?php
class Cities_Controller extends Base_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->filter('before', 'auth');
    }

    public function action_index(){
      $set = Setting::find(1)->shortcode;
      $cnt = 0;
      if($set=="foxv" || $set=="cyclo" || $set=="triad" || $set=="starcity" || $set=="ribmount" || $set=="mdhealth" || $set=="mdhealth2" || $set=="pureair" || $set=="coastal"){
        $leads = Lead::distinct()->get(array('city'));
        $gift = City::where('status','=','active')->where('gift_one','!=',0)->first();
        foreach($leads as $l){
          $city = City::where('cityname','=',$l->city)->first();
          if($city){
  
          } else {
              $c = New City;
              $c->cityname = $l->city;
              if($gift){
                $c->gift_one = $gift->gift_one;
                $c->gift_two = $gift->gift_two;
                $c->gift_three = $gift->gift_three;
                $c->gift_four = $gift->gift_four;
              } 
              
              $c->status = "active";
              $c->save();
              $cnt++;
          } 
        }
      }

      $areas = City::with('subCity')->where('status','!=','leadtype')->where('type','=','area')->order_by('cityname')->get();
      if(!empty($areas)){
        foreach($areas as $a){
          $check ="";
          $t = $a->subCity;
          if($t){
           foreach($t as $v){
             $check.="'".$v->cityname."',";
           }
           $check=rtrim($check,",");
          }
          if($check!="" && (!empty($check))){
            $dataCount = DB::query("SELECT COUNT(id) as cnt FROM leads WHERE city IN(".$check.") AND area_id=0");
            if($dataCount[0]->cnt>0){
               DB::query("UPDATE leads SET area_id='".$a->id."' WHERE city IN (".$check.") AND area_id = 0");
            }
          }
        }
      }
      $scripts = Script::where('type','=','batch')->get(array('id','type','title'));
   	  $cities = City::with('quadrant')->where('status','!=','leadtype')->where('type','=','city')->order_by('cityname')->get();
    	$gifts = Gift::all();
    	return View::make('cities.quadrants')->with('scripts',$scripts)->with('areas',$areas)->with('cities',$cities)->with('gifts',$gifts)->with('msg',$cnt);
    }

    public function action_merge(){
    	$input = Input::get();
    	$host = $input['hostCity'];
    	$cities = $input['mergeCities'];
    	$query = "";
    	if(!empty($cities)){
    		foreach($cities as $v){
    			$query.="'".$v."',";
    		}
    	}
    	$query = substr($query, 0, -1);
    	$tot=0;
    	$cnt = DB::query("SELECT COUNT(*) as tot FROM leads WHERE city IN (".$query.")");
    	if($cnt){
    		if($cnt[0]->tot>0){
    			$tot = $cnt[0]->tot;
    			$update = DB::query("UPDATE leads SET city='".$host."' WHERE city IN(".$query.")");
    		}
    	}
    	Session::flash("merge",$tot." Leads Were Merged with ".$host);
    	return Redirect::back();
    	
    }
   
    //USEFUL FUNCTIONS
	public function action_sortleads(){
		$nocities = Lead::where('city','=','No Assigned City')->get();
		$arr = array();
		foreach($nocities as $val){
		$numcheck = substr(str_replace("-","",$val->cust_num),0, 6);
		$exists = Quadrant::where('exchange','=',$numcheck)->get('city_id');
			if($exists){
				$lead = Lead::find($val->id);
				$lead->quad_id = $exists[0]->attributes['city_id'];
				$lead->city = City::find($exists[0]->attributes['city_id'])->cityname;
				$lead->save();
				} else {
				array_push($arr,$numcheck);
			}
		}
			
		$arr = array_unique($arr);
		$st = implode(", ",$arr);
		if(!empty($arr)){Session::flash('organize', $st);};
		return Redirect::to('lead');
	}
	
	
	public function action_addnew(){
	$input = Input::get();
	$rules = array("cityname"=>"required|min:3|unique:cities","city_type"=>"required");
	$v = Validator::make($input,$rules);
	$gift = City::where('status','=','active')->where('gift_one','!=',0)->first();

		if($v->fails()){
			return Redirect::back()->with_errors($v);
		} else {
			$city = New City;
      $city->type = $input['city_type'];
      if($gift){
        $city->gift_one = $gift->gift_one;
        $city->gift_two = $gift->gift_two;
        $city->gift_three = $gift->gift_three;
        $city->gift_four = $gift->gift_four;
      }
      
			$city->cityname = str_replace("'","",$input['cityname']);
			$city->save();
			return Redirect::back();
		}
	}

  public function action_addcitiestoarea(){
    $input = Input::get();
    $rules = array("area_id"=>"required","citytoarea"=>"required");
    $v = Validator::make($input,$rules);
    if($v->fails()){
      return Redirect::back()->with_errors($v);
    } else {
      if(isset($input['citytoarea'])){
        $string="";
        foreach($input['citytoarea'] as $c){
          $city = City::find($c);
          if($city){
            $city->area_id = $input['area_id'];
            $city->save();
            $string.="'".$city->cityname."',";
          }
        }
        $string=substr($string,0,-1);
        $leadcount=0;
        $leads = DB::query("UPDATE leads SET area_id = '".$input['area_id']."' WHERE city IN($string) ");
        /*$affected= DB::query("SELECT COUNT(*) as cnt FROM leads WHERE city IN($string)");
        if($affected){
          $leadcount = $affected[0]->cnt;
        }*/
      }
      return Redirect::back();
    }
   
  }

  public function action_loadcitiesforarea(){
    $cities = City::where('status','=','active')->where('type','=','city')->where('area_id','=',0)->order_by('cityname')->get();
    if($cities){
      return Response::json($cities);
    } else {
      return Response::json("failed");
    }
  }

  public function action_removesubcity(){
    $input = Input::get();
    if(!empty($input)){
      if(isset($input['area']) && isset($input['city'])){
        $city = City::find($input['city']);
        $city->area_id = 0;
        if($city->save()){
          DB::query("UPDATE leads SET area_id=0 WHERE city='".$city->cityname."' ");
          $count = DB::query("SELECT COUNT(*) as cnt FROM leads WHERE city='".$city->cityname."'");
          if($count){
            $leadcount = $count[0]->cnt;
          } else {
            $leadcount=0;
          }
          return Response::json($leadcount);
        } else {
          return Response::json("failed");
        };
      }
    } else {
      return Response::json("failed");
    }
  }

	public function action_gotrightaway($id){
		$city = City::find($id);
		if($city->rightaway!=0){
			$city->rightaway = $city->rightaway-1;
			$city->save();
		}
		$alert = Alert::find(5);
        $alert->message = "RIGHT AWAY FOR  <strong>".$city->cityname."</strong> BOOKED BY <strong>".Auth::user()->firstname." ".Auth::user()->lastname."</strong>";
        $alert->color = "success";
        $alert->icon = "cus-book-next";
        $alert->save();
		return Redirect::back();
	}
	
	public function action_delete($id){
	$city = City::find($id);
  $subCities = City::where('area_id','=',$id)->get();
  if($subCities){
    foreach($subCities as $sc){
      $sc->area_id = 0;
      $sc->save();
    }
    $leads = DB::query("UPDATE leads SET area_id = 0 WHERE area_id='".$id."' ");
  }

	if($city->delete()){
    return Response::json("success");
  } else {
    return Response::json("failed");
  }
	
	}

	public function action_activate($id){
		$city = City::find($id);
		$city->status="active";
		$city->save();
		return Redirect::back();
	}
	public function action_deactivate($id){
		$city = City::find($id);
		$city->status="retired";
		$city->save();
		return Redirect::back();
	}

	public function action_edit(){
      $input = Input::get();
      $leadcount=0;
      $x = explode("|", $input['id']);
      $city = City::find($x[1]);

      if($x[0]=="cityname"){
      	$name = str_replace("'","",$input['value']);
      	$leads = Lead::where('city','=',$city->cityname)->count();
      	$apps = Appointment::where('city','=',$city->cityname)->count();
      	$inv = Inventory::where('location','=',$city->cityname)->count();
      	if($leads!=0){
      		if(!DB::query("UPDATE leads SET city = '".$name."' WHERE city = '".$city->cityname."'")){
      			return false;
      		};
      	}
      	if($apps!=0){
      		if(!DB::query("UPDATE appointments SET city = '".$name."' WHERE city = '".$city->cityname."'")){
      			return false;
      		};
      	}
      	if($inv!=0){
      		if(!DB::query("UPDATE inventory SET location = '".$name."' WHERE location = '".$city->cityname."'")){
      			return false;
      		};
      	}

      	$city->$x[0] = $name;
      	$test = $city->save();
    	if($test) return $name;
      } else if($x[0]=="time_offset"){
        $leadcount = Lead::where('city','=',$city->cityname)->count();
        DB::query("UPDATE leads SET app_offset = '".$input['value']."' WHERE city = '".$city->cityname."' ");
        $city->$x[0] = $input['value'];
        $test = $city->save();
        if($test) return $leadcount;
      } else {
      	$city->$x[0] = $input['value'];
      	$test = $city->save();
    		if($test) {
            return $input['value'];
        }
      }
    }

    public function action_timeslot(){
    	$input= Input::get();
    	$x = explode("|",$input['id']);
    	
    	$needed = $input['value'];
      	$city = City::find($x[2]);
      	$city->$x[1] = $needed;
      	if($city->save()){
          return $input['value']-$x[0];
        };

    }



    /******CITY STATS PROFILE PAGE STUFF *******/
    public function action_profile($city_id){
      $city = City::find($city_id);
      $stats = $city->getCityStat("all");
      $cityStats = $city->cityStats();
      return View::make('cities.profile')
      ->with('city',$city)
      ->with('stats',$stats)
      ->with('cityStats',$cityStats);


    }

}