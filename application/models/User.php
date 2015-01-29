<?php
class User extends Eloquent
{
    public static $timestamps = true;

    // Get the tenant that user belongs to
    public function tenant(){
    	return $this->belongs_to('Tenant','tenant_id');
    }
    // TENANT FUNCTIONS - For retrieving data about this Users Tenant
    public function tenantTable(){
    	return $this->tenant->table_prefix;
    }
    public function tenantName(){
    	return $this->tenant->tenant_name;
    }
    // END TENANT DATA


    	// Display formatting functions
    	// NAME FORMATTING FUNCTIONS
    	public function fullname(){
        	return ucfirst(strtolower($this->firstname))." ".ucfirst(strtolower($this->lastname));
    	}

    	public function profileName($type=null){
        if($type=="has"){
            if(Auth::check()){
                if($this->id==Auth::user()->id){
                    $name = "You have";
                } else {
                    $name = ucfirst(strtolower($this->firstname))." has";
                }
            } 
        } else {
            $name = ucfirst(strtolower($this->firstname))."'s";
            if(Auth::check()){
                if($this->id==Auth::user()->id){
                    $name = "Your";
                } 
            } 
        }
        return $name;
    	}	

    	public function cellNo(){
        	$num = str_replace(array("(",")","-"," ",":"),"",$this->cell_no);
        	$num = "(".substr($num,0,3).") -".substr($num,3,3)."-".substr($num,6,4);
        	return $num;
    	}

     	public function truncName(){
        	return ucfirst(strtolower($this->firstname))." ".ucfirst($this->lastname[0]);
    	}

    	public function stat($type){
    		$col = $type."_per";
    		return $this->$col."%";
    	}

    	//GENERIC STATIC USER FUNCTIONS
    	public static function allUsers(){
        	$users = User::where('id','!=',58)
        	->where('type','=','employee')
        	->where('level','!=',99)
        	->order_by('firstname','ASC')
        	->get();
        	
        	return $users;
    	}

    public static function activeUsers($type,$method=null){
        $users = User::where('user_type','=',$type)
          ->where('id','!=',58)
          ->where('type','=','employee')
          ->where('level','!=',99)
          ->order_by('firstname','ASC')
          ->get();
        if($method){
            $arr=array();
            if($method=="json_id"){
                $arr[0] = "BACK TO STOCK";
                foreach($users as $val){
                    $arr[$val->id] = $val->fullName();
                };

            } else {
                foreach($users as $val){
                    $arr[$val->firstname."|".$val->id] = $val->fullName();
                };
            }
        
            return json_encode($arr);
        } else {
            return $users;
        }
    }

    public static function getAverageTimes($id, $date, $type){
        $query="";
        if($id==null){
            return array();
        } else {
            if($type=="survey"){
                $query = "AND leadtype='survey' ";
            } 
            $nh = DB::query("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(length))) as avgnh FROM calls WHERE result='NH' AND caller_id='".$id."' ".$query." AND DATE(created_at) = '".$date."'");
            $ni = DB::query("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(length))) as avgni FROM calls WHERE result='NI' AND caller_id='".$id."' ".$query." AND DATE(created_at) = '".$date."'");
            $app = DB::query("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(length))) as avgapp FROM calls WHERE result='APP' AND caller_id='".$id."' ".$query." AND DATE(created_at) = '".$date."'");
            $all = DB::query("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(length))) as avgall FROM calls WHERE caller_id='".$id."' ".$query." AND DATE(created_at) = '".$date."'");
            $surv = DB::query("SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(length))) as avgcomplete FROM calls WHERE result='INACTIVE' AND caller_id='".$id."' ".$query." AND DATE(created_at) = '".$date."'");
            $times = array("nh"=>$nh[0]->avgnh,"ni"=>$ni[0]->avgni,"app"=>$app[0]->avgapp,"surv"=>$surv[0]->avgcomplete,"all"=>$all[0]->avgall);
            return $times;
        }
    }


    
    
    //RECRUITS 
    public function recruits(){
        return $this->has_many('User','recruited_by');
    }

    public function recruitedby(){
        return $this->belongs_to('User','recruited_by');
    }

    public function lastSale(){
        return Sale::where('user_id','=',$this->id)->order_by('date','DESC')->take(1)->get();
    }

    //GAME / BADGE FEATURES
    public function mainGameID(){
    	$gid=0;
    	if($this->user_type=="salesrep"){
    		$gid = 1;
    	}
    	if($this->user_type=="agent"){
    		$gid = 2;
    	} 
    	if($this->user_type=="doorrep"){
    		$gid = 3;
    	} 
    
    	if($this->user_type=="manager"){
    		$gid = 4;
    	}  
    	return $gid;
    }
    
    public function achievements($type=null){
        if($type=="badges") {
        	$games = GameUser::where('user_id','=',$this->id)->where('game_id','>',12)->order_by('order')->get();
        } else {
        	$games = GameUser::where('user_id','=',$this->id)->where('game_id','>',12)->order_by('order')->get();
        }
        return $games;
    }

    public function recentActivity($type=null){
    if($type=="all"){
    	$activity = GameHistory::where('user_type','=',$this->user_type)->where('type','!=','TROPHY')->take(4)->order_by('history_date','DESC')->get();
    } else if($type=="last"){
     	$activity = GameHistory::where('user_id','=',$this->id)->where('type','!=','TROPHY')->take(4)->order_by('history_date','DESC')->get();
    } else {
    	$activity = GameHistory::where('user_id','=',$this->id)->where('type','!=','TROPHY')->take(4)->order_by('history_date','DESC')->get();
    }

        return $activity;
    }
    
    public function systemGame(){
    	$game = GameUser::where('user_id','=',$this->id)->where('game_id','=',$this->mainGameID())->first();
    	return $game;
    }  

    
    public function saleCount(){
    	$sale=array();
    	if($this->user_type=="salesrep"){
    		$sale = Sale::where('user_id','=',$this->id)->count();
    	} else if($this->user_type=="doorrep"){
    		$sale = Sale::where('researcher_id','=',$this->id)->count();
    	} else if($this->user_type=="agent"){
    		$sale = Sale::where('booker_id','=',$this->id)->count();
    	}
    	
    	if($sale){
    		return $sale;
    	} else {
    		return 0;
    	}
    
    }

    public function incrementPoints($integer){
        $this->system_points += intval($integer);
        
    }

    public function decrementPoints($integer){
        $this->system_points -= intval($integer);
        
    }
    // END BADGE / GAME FEATURES
    

    public function demostats($limit){
        $dems = DB::query("SELECT COUNT(*) as cnt, app_date,
            SUM(status='SOLD') sold, SUM(status='DNS') dns, 
            SUM(status='INC') inc, SUM(status='CXL') cxl, SUM(status='RB-TF' OR status='RB-OF') rbs
            FROM (SELECT status, app_date FROM appointments WHERE rep_id='".$this->id."' ORDER BY app_date DESC LIMIT ".$limit.") t");
        if($dems){
            return $dems[0];
        } else {
            return false;
        }
    }

    public function hold(){
    		$hold = "N/A";
    		$holdstats = DB::query("SELECT *, IF(puton + totaldems, 100*puton/total, NULL) AS hold 
            FROM (SELECT COUNT(*) as total,
            SUM(status='DNS' OR status='SOLD') puton, SUM(status!='DNS' AND status!='SOLD') totaldems
            FROM appointments WHERE booker_id=$this->id) AS subquery");

    		if($holdstats){
    			$hold = number_format($holdstats[0]->hold,2,'.','');
    		} else {
    			$hold = "N/A";
    		}
        	return $hold;
    }

    public function closePercent(){
        $close = 0;
        if($this->user_type=="agent"){
           $calls = DB::query("SELECT *, IF(book + ni + dnc, 100*(book)/(book+ni+dnc), NULL) AS close
            FROM (SELECT COUNT(*) as cnt, SUM(result='APP') book,
            SUM(result='DNC') dnc, SUM(result='NI') ni FROM calls WHERE caller_id = '".$this->id."') as SUBQUERY ");
            if($calls){
                $close = $calls[0]->close;
            } 
        } else if($this->user_type=="doorrep"){
            $leads = DB::query("SELECT *, IF(book+notbooked, 100*(book)/(book+notbooked), NULL) AS close
            FROM (SELECT COUNT(*) as cnt, SUM(status='SOLD' OR status='DNS' OR status='APP') book,
            SUM(status!='SOLD' AND status!='DNS' AND status!='APP') notbooked FROM leads WHERE researcher_id = '".$this->id."') as SUBQUERY ");
            if($leads){
                $close = $leads[0]->close;
            } 
        } else if($this->user_type=="salesrep"){
            $apps = DB::query("SELECT *, IF(sold+dns, 100*(sold)/(sold+dns), NULL) AS close
            FROM (SELECT COUNT(*) as cnt, SUM(status='SOLD') sold,
            SUM(status='DNS') dns, SUM(status='INC') inc FROM appointments WHERE rep_id = '".$this->id."') as SUBQUERY ");
            if($apps){
                $close = $apps[0]->close;
            } 
        }
        return $close;
    }

    public function messages()
        {
        return $this->has_many('Message');
        }

    public function alerts()
    	{
        return $this->has_many('Alert', 'receiver_id');
   	}

    public function employee()
    	{
        return $this->has_one('Employee','user_id');
    	}

    public function crewtype(){
    		$c = Crew::where('user_id','=',$this->id)->first();
    		if($c){
    			return $c->type;
    		} else {
    			return "No Crew";
    		}
   	}

     public function sales()
    	{
            return $this->has_many('Sale')->order_by('date','DESC');
    	}

        

        public function appointments(){

            $fields = $this->getuserfields("apps");
           //$apps = $this->has_many('Appointment',$fields['theid']);
            $apps =  Appointment::where($fields['theid'],'=',$this->id)->get();

            $map = array();
            foreach($apps as $val){
          if($val->lead->lat!=0){
            $icon=URL::to_asset('img/app-nq.png'); 
            $label = "important special";

           if($val->status=="DISP"){
              $label = "info special";
              $icon = URL::to_asset('img/app-disp.png');
            } 

            if($val->status=="APP"){
              $label = "info";
              $icon = $icon = URL::to_asset('img/app-app2.png');
            } 

            if($val->status=="SOLD"){
              $label = "success special";
              $icon = URL::to_asset('img/app-sale.png');
            }

            if($val->status=="DNS"){
              $label = "important special";
              $icon = URL::to_asset('img/app-dns.png');
            }

            if($val->status=="INC"){
              $label = "warning";
              $icon = URL::to_asset('img/app-inc.png');
            }

            if($val->status=="CXL"){
              $label = "important";
              $icon = URL::to_asset('img/app-cxl.png');
            }

            if(($val->status=="RB-TF")||($val->status=="RB-OF")){
              $label = "info special";
              $icon = URL::to_asset('img/app-rb.png');
            }
           
            if($val->status=="NQ"){
              $icon=URL::to_asset('img/app-nq.png'); 
              $label = "important special";
            }
            
            if($val->status=="CONF"){
              $icon=URL::to_asset('img/app-conf.png'); 
              $label = "success";
            }
            
            if($val->status=="NA"){
              $icon=URL::to_asset('img/app-na.png'); 
              $label = "warning";
            }
             if($val->status=="BUMP"){
              $icon=URL::to_asset('img/app-bump.png'); 
              $label = "info";
             }
         
       
         $markers[] = array("latLng"=>array($val->lead->lat,$val->lead->lng),
            "id"=>$val->lead->id,
            "data"=>$val->lead->address." | " .$val->app_time. " | ",
            "tag"=>$val->status,
            "options"=>array("icon"=>$icon));
          }
          
      }
      $lat = Setting::find(1)->lat; $lng=Setting::find(1)->lng;
      if(empty($markers)){
       $map = array();
      } else {
        $map = $markers; 
      }
            return array("apps"=>$apps,"map"=>$map,"latlng"=>array($lat,$lng));
            

        }

       

    	public function notes(){
    		return Tasks::where('receiver_id','=',$this->id)->where('status','=','usernote')->get();
    	}

    	public function timelog(){
    		return $this->has_many('Timelog','user_id');
    	}

    	public function logTime(){
    		return Timelog::where('session_key','=',$this->session_key)->where('user_id','=',$this->id);
    	}

    	public function incrementCall(){
    		$t = Timelog::where('session_key','=',$this->session_key)->where('user_id','=',$this->id)->first();
    		if($t){
    			$t->calls_made = intval($t->calls_made)+intval(1);
    			if($t->save()){
    				return true;
    			};
    		}
    	}

    	public function callTime(){
    		$c = Call::where('caller_id','=',$this->id)->order_by('created_at','DESC')->take(2)->get();
    		if($c){	
    			foreach($c as $v){
    				$arr[] = strtotime($v->created_at);
    			}
    		}

    		if(isset($arr[0])&&(isset($arr[1]))){
    			
    			$time = round(abs($arr[1] - $arr[0]));
    			if($time<6){
    				$cl = "important special ";
    			} else if(($time<=11)&&($time>=6)){
    				$cl = "warning blackText";
    			} else if($time>=12){
    				$cl = "success special blackText";
    			} else {
    				$cl= "";
    			}
    			$time = "<span class='label label-".$cl."'>".gmdate("H:i:s",$time)."</span>";
    			return $time;
    		} else {
    			$cl="";
    			return false;
    		}
    		
    	}

    public function invoice(){
    	return $this->has_many('Dealerinvoice');
    }

    public function sent_tasks(){
        return $this->has_many('Tasks','sender_id');
    }

    public function mytasks(){
        return $this->has_many('Tasks','receiver_id');
    }

    public function machines(){
        return DB::query("SELECT * from inventory WHERE user_id = '".$this->id."' AND (status='Cancelled' OR status='Checked Out')");
    }

    public function hasMachines(){

    	$mac = Inventory::where('user_id','=',$this->id)->where('status','=','Checked Out')->count();
    	if($mac>0){
    		return true;
    	} else {
    		return false;
    	}


    }
    
    

    public function avatar_link(){
    	$shortcode = Setting::where('tenant_id','=',$this->tenant_id)->first();
    	if($shortcode){
    		if($this->avatar=="avatar.jpg"){
            	return URL::to_asset('images/').$this->avatar;
        	} else {
        	return "https://s3.amazonaws.com/salesdash/".$shortcode->shortcode."/avatars/".$this->avatar;
        	}
    	} else {
    		return URL::to_asset('images/').$this->avatar;
    	}        
    }

    public function todayscalls(){
        $calls = DB::query("SELECT COUNT(*) as total, result, SUM(result='NH') nh, SUM(result='APP') app, SUM(result='NI') ni
         FROM calls WHERE caller_id = '".$this->id."' AND DATE(created_at) = DATE('".date('Y-m-d')."')");
        return $calls;
    }

    public static function bookerstats(){
    	$bookerstats = DB::query("SELECT COUNT(id) total, caller_id, leadtype,
        SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,SUM(result = 'APP') app,
        SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,
        SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
        SUM(result = 'WrongNumber') wrong FROM calls WHERE leadtype!='survey' AND DATE(created_at) = DATE('".date('Y-m-d')."') GROUP BY caller_id, leadtype ORDER BY app");

        $totals = array();
        $paper=array();$door=array();$other=array();$survey=array();$secondtier=array();
        $homeshow=array();$ballot=array();$finalnotice=array();$referral=array();

        foreach($bookerstats as $val){
            $u = User::find($val->caller_id);
            if(!empty($u)){
                if($u->user_type=="agent"){
                    $val->caller_id = $u->firstname;
                    if(!isset($totals[$u->id])){
                    	$totals[$u->id]['caller_id'] = $u->firstname;
                        $totals[$u->id]['app'] = $val->app;
                        $totals[$u->id]['ni'] = $val->ni;
                        $totals[$u->id]['nh'] = $val->nh;
                        $totals[$u->id]['tot'] = $val->tot;
                    } else {
                      	$totals[$u->id]['app']+= $val->app;
                        $totals[$u->id]['ni']+= $val->ni;
                        $totals[$u->id]['nh']+= $val->nh;
                        $totals[$u->id]['tot']+= $val->tot;
                    } 

                    if($val->leadtype=="paper"){
                        array_push($paper,$val);
                    } else if($val->leadtype=="homeshow"){
                        array_push($homeshow,$val);
                    } else if($val->leadtype=="door"){
                        array_push($door,$val);
                    } else if($val->leadtype=="other"){
                        array_push($other,$val);
                    } else if($val->leadtype=="survey"){
                        array_push($survey,$val);
                    } else if($val->leadtype=="secondtier"){
                        array_push($secondtier,$val);
                    } else if($val->leadtype=="finalnotice"){
                        array_push($finalnotice,$val);
                    } else if($val->leadtype=="referral"){
                        array_push($referral,$val);
                    } else if($val->leadtype=="ballot"){
                        array_push($ballot,$val);
                    }
                }
            }
        }
        return array("totals"=>$totals,
            "paper"=>$paper,"door"=>$door,
            "other"=>$other,"homeshow"=>$homeshow,
            "ballot"=>$ballot,"survey"=>$survey,"secondtier"=>$secondtier,
            "finalnotice"=>$finalnotice,"referral"=>$referral);
    }

    public static function surveystats(){
          $bookerstats = DB::query("SELECT COUNT(id) total, caller_id,
        SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,SUM(result = 'INACTIVE') lead,
        SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,SUM(result='NID') nid,
        SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
        SUM(result = 'WrongNumber') wrong FROM calls WHERE leadtype='survey' AND DATE(created_at) = DATE('".date('Y-m-d')."') GROUP BY caller_id ORDER BY lead");

        $arr2 = array();
        foreach($bookerstats as $val){
            $u = User::find($val->caller_id);
            if(!empty($u)){
            if($u->user_type=="agent"){
                $val->caller_id = $u->firstname;
                array_push($arr2, $val);
            }}
        }
        return $arr2;
    }


    public static function appTimes($datemin,$datemax){
        $slots = Appointment::appslots();
        foreach($slots as $k=>$s){
          $end=strtotime($s->end)-60;
          $end= date('H:i:s',$end);
          $slot[] = array("s"=>$s->start,"f"=>$end);
        }
    	$apptimes = DB::query("SELECT booker_id, 
    	  COUNT(*) as tot,
        SUM(app_time >= '".date('H:i',strtotime($slot[0]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[0]['f']))."') slotone,
        SUM(app_time >= '".date('H:i',strtotime($slot[1]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[1]['f']))."') slottwo,
        SUM(app_time >= '".date('H:i',strtotime($slot[2]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[2]['f']))."') slotthree,
        SUM(app_time >= '".date('H:i',strtotime($slot[3]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[3]['f']))."') slotfour,
        SUM(app_time >= '".date('H:i',strtotime($slot[4]['s']))."' AND app_time <= '".date('H:i',strtotime($slot[4]['f']))."') slotfive
        FROM appointments WHERE app_date>=DATE('".$datemin."') AND app_date<=DATE('".$datemax."') AND status!='RB-TF' AND status!='RB-OF'  GROUP BY booker_id");

    	return $apptimes;
    }

    public function daysSince(){

    	$dems = DB::query("SELECT app_date FROM appointments WHERE rep_id = '".$this->id."' ORDER BY id DESC LIMIT 1");
    	$sales = DB::query("SELECT app_date FROM appointments WHERE rep_id = '".$this->id."' AND status='SOLD' ORDER BY id DESC LIMIT 1");
    	if(!empty($dems)){
    		$datetime1 = new DateTime($dems[0]->app_date);
		$datetime2 = new DateTime(date('Y-m-d'));
		$interval1 = $datetime1->diff($datetime2);
		
		$dems = $interval1->format('%a');

    	} else {
    		$dems = "n/a";
    	}

    		if(!empty($sales)){
    		$datetime3 = new DateTime($sales[0]->app_date);
		$datetime4 = new DateTime(date('Y-m-d'));
		$interval2 = $datetime3->diff($datetime4);
		$sales = $interval2->format('%a');

    	} else {
    		$sales = "n/a";
    	}

	return array('dems'=>$dems,'sales'=>$sales);
    }

    public function demosSince(){

      $dems = DB::query("SELECT app_date, status FROM appointments WHERE rep_id = '".$this->id."' AND (status='DNS' OR status='SOLD') ORDER BY app_date DESC");
    	$count = 0;

        foreach($dems as $val){
            if($val->status!="SOLD"){
                 $count++;
            } else {
               break;
            }
        }

      $lastapp = Appointment::where('rep_id','=',$this->id)->where('app_date','=',date('Y-m-d'))->where('status','=','DISP')->where('in','!=','00:00:00')->get();
      if(empty($lastapp)){
      	$timeIn = 0;
      } else {
      	$app = $lastapp[0]->attributes;
      	$in = $app['in'];
      	$out = date('H:i:s');
      	$time = round(abs(strtotime($in) - strtotime($out)));
      	$timeIn = gmdate("H:i:s",$time);
      }

     return array("count"=>intval($count),"timeIn"=>$timeIn);

    }

    public function averageTimeSpent(){

        $dems = Appointment::where('rep_id','=',$this->id)->where('in','!=','00:00:00')->where('out','!=', '00:00:00')->avg('diff');
   	    return number_format($dems,2,'.','');

    }

    
    public static function bookerleads($type=null){
    	if($type=="all"){
    		 $bookerleads = DB::query("SELECT COUNT(id) as tot FROM leads WHERE status='ASSIGNED'");
    	} else {
    		$bookerleads = DB::query("SELECT COUNT(id) as tot, booker_name, booker_id, city, leadtype, original_leadtype 
            FROM leads WHERE status='ASSIGNED' GROUP BY booker_name");
    	}
   	
   	return $bookerleads;

    }
    
    public static function bookerleadsbycity(){
             $bookerleads_city = DB::query("SELECT COUNT(id) as tot,city FROM leads WHERE status='ASSIGNED' GROUP BY city");
             $bookerleads_area = DB::query("SELECT COUNT(id) as tot,area_id FROM leads WHERE status='ASSIGNED' GROUP BY area_id");
        return array("area"=>$bookerleads_area,"city"=>$bookerleads_city);
    }

 
    
    public function shifts($type=null){
        if($type==NULL){
            $shifts = DB::query("SELECT COUNT(*) as total FROM schedule WHERE user_id = '".$this->id."' AND WEEK(date) = WEEK('".date('Y-m-d')."') AND YEAR(date)=YEAR(NOW())");
            return $shifts[0]->total;
        } else {
            $shifts = DB::query("SELECT * FROM schedule WHERE user_id = '".$this->id."' AND WEEK(date) = WEEK('".date('Y-m-d')."') AND YEAR(date)=YEAR(NOW()) ORDER BY date");
            return $shifts;
        }
    }

    public function hoursWorked($date){
        $hours= 0;
        $log_in = DB::query("SELECT log_in FROM timelog WHERE user_id = '".$this->id."' AND DATE(log_in) = DATE('".$date."') ORDER BY log_in ASC LIMIT 1 ");
        $log_out = DB::query("SELECT log_out FROM timelog WHERE user_id = '".$this->id."' AND DATE(log_in) = DATE('".$date."') ORDER BY log_in DESC LIMIT 1 ");

        $login = strtotime($log_in[0]->log_in);
        if(!empty($log_out)){
            if($log_out[0]->log_out!="0000-00-00 00:00:00"){
                $logout = strtotime($log_out[0]->log_out);
            } else {
                $logout = time();
            }
        } else {
            $logout = time();
        }
        
        $t = number_format((($logout-$login)/3600),2,'.','');
        return $t;
    }

    public function booked($date){
        $leads = DB::query("SELECT COUNT(id) as cnt FROM calls WHERE caller_id='".$this->id."' AND result='APP' AND DATE(created_at)=DATE('".$date."')");
        if($leads){
            if($leads[0]->cnt>0){
                return $leads[0]->cnt;
            } else {
                return 0;
            }
        }

    }


    public function hours($start,$end){
    	$hours = 0;
    	$calls = DB::query("SELECT MIN(id) as min, MAX(id) as max, created_at
                    FROM calls WHERE caller_id = ".$this->id." AND 
                    DATE(created_at) >= DATE('".$start."') AND 
                    DATE(created_at) <= DATE('".$end."') GROUP BY DATE(created_at) ORDER BY created_at ");
            if($calls){
            	foreach($calls as $c){
                    $t = Call::timeDiff($c->min, $c->max);
             		$hours=$hours+$t;
            	}
            }
            return $hours;
      /*  $hours = DB::query("SELECT SUM(length) as total FROM schedule WHERE date>=DATE('".$start."') AND date<=DATE('".$end."') AND user_id = '".$this->id."'");
        return $hours[0]->total/60;*/
    }

    public function leadsEntered($type=null){
        if($type=="count"){
            return Lead::where('researcher_id','=',$this->id)->count();
        } else {
            return Lead::where('researcher_id','=',$this->id)->get();
        }
        
    }

    public function leads(){
        return $this->has_many('Lead', 'booker_id');
    }

  

    public function recalls(){
         return Lead::where('booker_id','=',$this->id)
        ->where('status','=','Recall')
        ->where('recall_date','=',date('Y-m-d'))
        ->order_by('recall_date','ASC')
        ->get();
    }

    public static function unassignleads($user){

            if(DB::query("UPDATE leads SET booker_name='',booker_id='',assign_date='',status='NEW' WHERE status='ASSIGNED' AND booker_id = '".$user."'")){
            	 return true;
            };
            return true;
           
    }

   

    public function sentmessages(){
        return $this->has_many('Message', 'sender_id');
    }

    public function recmessages(){
        return $this->has_many('Message', 'receiver_id');
    }


    /*USER GOALS*/
    public function weeklygoal(){
        $goal = DB::table('goals')
        ->where('usertype','=',$this->user_type)
        ->where('typeofgoal','=','weekly')
        ->first();
        return $goal->goal;
    }

    public function monthlygoal(){
        $goal = DB::table('goals')
        ->where('usertype','=',$this->user_type)
        ->where('typeofgoal','=','monthly')
        ->first();
        return $goal->goal;
    }

    public function getgoals(){
        return array("week"=>$this->weeklygoal(),"month"=>monthlygoal());
    }

    public function getuserleads(){
        $fields = $this->getuserfields();
        $myleads = Lead::where($fields['theid'],'=',$this->id)
        ->order_by($fields['date'],'DESC')->get();
        return $myleads;
    }

    public function getcurrentleads($count){
        $f = $this->getuserfields();
        if($this->user_type=="agent"){
            $currentleads = Lead::where($f['theid'],'=',$this->id)
            ->where($f['status'],'=','ASSIGNED')
            ->or_where($f['status'],'=','NH')
            ->get();
        } else {
            $currentleads = DB::query("SELECT * FROM leads WHERE $f[theid] = '".$this->id."' AND DAY($f[date]) = DAY(DATE_SUB('".date('Y-m-d')."', INTERVAL $count DAY)) ORDER BY $f[date] ASC");
        }
        return $currentleads;
    }

	public function door_reggies($date=null){
		if($date){
			return Lead::where('researcher_id','=',$this->id)
		    ->order_by('created_at','DESC')
			->get();
		}
	}

    public function weekssales(){

        $sales = DB::query("SELECT SUM(units) as total FROM appointments WHERE rep_id = '$this->id' AND status='SOLD' AND WEEK(app_date,1) = WEEK('".date('Y-m-d')."',1) AND YEAR(app_date)=YEAR(NOW()) ");
        return $sales[0]->total;
    }

     public function monthssales(){
        $sales = DB::query("SELECT SUM(units) as total FROM appointments WHERE rep_id = '$this->id' AND status='SOLD' AND MONTH(app_date) = MONTH('".date('Y-m-d')."') AND YEAR(app_date)=YEAR(NOW()) ");
        return $sales[0]->total;
    }

  

    /*---STAT SECTION OF USERS----*/

    public function agentleads(){

            return Lead::where('booker_id','=',$this->id)
            ->where('status','=','ASSIGNED')
            ->get();
        
    }

    public function barchart(){
        if($this->user_type=="agent"){
            $allrepcalls = DB::query("SELECT *, IF(ni, 100*app/(ni+app), NULL) AS book 
            FROM (SELECT COUNT(id) as total, caller_id, created_at, SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,SUM(result = 'APP') app,
            SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
            SUM(result = 'WrongNumber') wrong FROM calls WHERE caller_id='".$this->id."')AS subquery GROUP BY DATE('created_at')");
            $app="";$dnc="";$ni="";$nh="";$nq="";$wrong="";$tot="";$dates="";$recall="";
            foreach($allrepcalls as $val){
                $app.=$val->app.",";
                $dnc.=$val->dnc.",";
                $ni.=$val->ni.",";
                $wrong.=$val->wrong.",";
                $recall.=$val->recall.",";
                $nh.=$val->nh.",";
                $dates.="'".date('D d',strtotime($val->created_at))."',";
            } 
            $charts = array("labels"=>$dates,"app"=>$app,"nh"=>$nh,"ni"=>$ni,"dnc"=>$dnc,"nq"=>$nq,"wrong"=>$wrong,"recall"=>$recall,"tot"=>$tot);

        } elseif($this->user_type=="salesrep"){

        } elseif($this->user_type=="doorrep"){

        }

        
        return $charts;
    }

    public function totalstats(){
        if($this->user_type=="agent"){
            $allrepputon = DB::query("SELECT COUNT(*) as total,
            SUM(status='DNS' OR status='SOLD' OR status='INC')puton, SUM(status='SOLD') sales FROM appointments WHERE booker_id='".$this->id."'");
            
            $allrepcalls = DB::query("SELECT *, IF(ni, 100*app/(ni+app), NULL) AS book 
            FROM (SELECT COUNT(id) as total, caller_id, created_at, SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,SUM(result = 'APP') app,
            SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
            SUM(result = 'WrongNumber') wrong, SUM(result='APP' AND leadtype='paper' ) manilla, SUM(result='APP' AND leadtype='door' ) door,
            SUM(result = 'APP' AND leadtype='other') scratch FROM calls WHERE caller_id='".$this->id."')AS subquery");

            $dailystats = DB::query("SELECT count(*) as total, caller_id, created_at, SUM(result != '' AND result != 'CONF' AND result != 'NA') tot,SUM(result = 'APP') app,
            SUM(result = 'DNC') dnc,SUM(result = 'NH') nh,SUM(result = 'NI') ni,SUM(result = 'NQ') nq,SUM(result = 'Recall') recall,
            SUM(result = 'WrongNumber') wrong, SUM(result='APP' AND leadtype='paper' ) manilla, SUM(result='APP' AND leadtype='door' ) door,
            SUM(result = 'APP' AND leadtype='other') scratch FROM calls WHERE caller_id='".$this->id."' GROUP BY DATE(created_at)");
          
            $app="";$dnc="";$ni="";$nh="";$nq="";$wrong="";$tot="";$dates="";$recall="";
            foreach($dailystats as $val){
                $app.=$val->app.",";
                $dnc.=$val->dnc.",";
                $ni.=$val->ni.",";
                $wrong.=$val->wrong.",";
                $recall.=$val->recall.",";
                $nh.=$val->nh.",";
                $dates.="'".date('D d',strtotime($val->created_at))."',";
            }

            $dailystats = array("app"=>$app,"dnc"=>$dnc,"ni"=>$ni,"wrong"=>$wrong,"recall"=>$recall,"nh"=>$nh,"dates"=>$dates);
           
        } elseif($this->user_type=="salesrep"){

        } elseif($this->user_type=="doorrep"){

        }
        $currentleads=array();$weekstats=array();$monthstats=array();
        $results = array("PUTON"=>$allrepputon,"ALLCALLS"=>$allrepcalls,"DAILYSTATS"=>$dailystats,"MONTHSTATS"=>$monthstats,"CURRENT"=>$currentleads);
        return $results;
    }

  

    public static function allrecalls(){
         return Lead::where('status','=','Recall')
        ->get();
    }

    public function repdemos(){
        return Lead::where('rep','=',$this->id)
        ->where('app_date','=',date('Y-m-d'))
        ->get();
    }

    public function repsales(){
        return Lead::where('rep','=',$this->id)
        ->where('app_date','=',date('Y-m-d'))
        ->where('result','=','SOLD')
        ->get();
    }

    public function salesrepstats($count){
        $sold = DB::query("SELECT COUNT(rep) as sold FROM leads WHERE rep = ".$this->id." AND result = 'SOLD' AND WEEK(app_date) = WEEK(DATE_SUB(now(), INTERVAL $count WEEK)) AND YEAR(app_date)=YEAR(NOW()) ");
        $dns = DB::query("SELECT COUNT(rep) as dns FROM leads WHERE rep = ".$this->id." AND result = 'DNS' AND WEEK(app_date) = WEEK(DATE_SUB(now(), INTERVAL $count WEEK)) AND YEAR(app_date)=YEAR(NOW()) ");
        $stat = array("sold"=>$sold,"dns"=>$dns);
        return $stat;
    }

    public function ajaxsales($count){
        return $this->salesrepstats($count);
    }

    public function unprocessedsales(){
        return Lead::where('rep','=',$this->id)
        ->where('sale_id','=',0)
        ->where('result','=','SOLD')
        ->get();
    }

   public function repmonthearn(){
        $monthearnings = $this->getmonthlyearn('sales','user_id','=',$this->id,'date');
        $weekearnings = $this->getweeklyearn('sales','user_id','=',$this->id,'date');
        if((!isset($weekearnings[0]))||(!isset($monthearnings[0]))){
            $array = array("weekly"=>0, "monthly"=>0);
        } else {
            $array = array("weekly"=>$weekearnings[0]->earning, "monthly"=>$monthearnings[0]->earning);}
        return $array;
    }

    //STATISTICS FUNCTIONS - Ajax stats, Regular Stats etc
	public function ajax_stats($counter=null){
        $stats = $this->getstats($counter);
        return $stats;
    }
        
    public function ajax_table($counter=null){
    echo json_encode('test');
    }

	public function getnums($select, $table, $userfield, $datefield, $typeoftime, $current){
        return DB::query("SELECT $select, COUNT(id) as count FROM $table WHERE $userfield = '$this->id' AND $typeoftime($datefield) = $typeoftime(DATE_SUB('".date('Y-m-d')."', INTERVAL $current WEEK)) GROUP BY $select ORDER BY $select ASC ");
    }

    public function getstats($counter=null){
	if($counter==null){$counter = 0;} 

        $f = $this->getuserfields();
        if(Auth::user()->user_type=="agent"){
            $weekly = $this->getnums($f['status'],'appointments',$f['theid'],'booked_at','WEEK',$counter);
            $monthly = $this->getnums($f['status'],'appointments',$f['theid'],'booked_at','MONTH', $counter);
        } else {
            $weekly = $this->getnums($f['status'],'leads',$f['theid'],$f['date'],'WEEK',$counter);
            $monthly = $this->getnums($f['status'],'leads',$f['theid'],$f['date'],'MONTH', $counter);}
	        $field = $f['RESULT'];
            $wcount = 0;
            $mcount = 0;

		if(!empty($weekly)){
            foreach($weekly as $val){
                $wcount = $wcount+$val->count;
                $weeklygroup[$val->$f['status']]=$val->count;
                $weeklygroup['total'] = $wcount;
            }}

	   	if(!empty($monthly)){
	        foreach($monthly as $val){
                $mcount = $mcount+$val->count;
                $monthlygroup[$val->$f['status']]=$val->count;
                $monthlygroup['total'] = $mcount;
            }}

        if(!isset($weeklygroup[$field])){
            $weeklygroup[$field] = 0;
        }

        if(!isset($monthlygroup[$field])){
            $monthlygroup[$field] = 0;
        }

        if(!isset($monthlygroup['total'])){
            $monthlygroup['total']=0;
        }

        if(!isset($weeklygroup['total'])){
            $weeklygroup['total']=0;
        }

        $stats = array("Monthly"=>$monthlygroup,"Weekly"=>$weeklygroup);
        $monthtotal = $stats['Monthly']['total'];
        $weektotal = $stats['Weekly']['total'];

        if($monthtotal!=0){
            $mpercent = number_format(($stats['Monthly'][$field]/$monthtotal*100),2);
        } else {$mpercent = 0;}

        if($weektotal!=0){
            $wpercent = number_format(($stats['Weekly'][$field]/$weektotal*100),2);
        } else {$wpercent = 0;}
      
        $results = array("weeklygoal"=>$this->weeklygoal(),"monthlygoal"=>$this->monthlygoal(),"type"=>$f['type'],"type2"=>$f['type2'], "MTotal"=>$monthtotal,"MClosed"=>$stats['Monthly'][$field],"MRatio"=>$mpercent,"WTotal"=>$weektotal,"WClosed"=>$stats['Weekly'][$field],"WRatio"=>$wpercent,"Breakdown"=>$stats);
	
        return($results);

    }

    //HELPER FUNCTIONS
    public function getuserfields($type=null){
        
        
            if($this->user_type=="agent"){
                $field = array("type"=>"Calls","type2"=>"Demos","status"=>"status","theid"=>"booker_id","date"=>"assign_date","RESULT"=>"APP","current"=>"ASSIGNED");
            } else if($this->user_type=="salesrep"){
                if($type=="apps"){
                    $field = array("type"=>"Demos","type2"=>"Sales","status"=>"result","theid"=>"rep_id","date"=>"date","RESULT"=>"SOLD","current"=>"DISP");
                } else {
                    $field = array("type"=>"Demos","type2"=>"Sales","status"=>"result","theid"=>"rep","date"=>"app_date","RESULT"=>"SOLD","current"=>"DISP");
                }
            }
             else if($this->user_type=="doorrep"){
            $field = array("type"=>"Leads","type2"=>"Leads","status"=>"status","theid"=>"researcher_id","date"=>"entry_date","RESULT"=>"none","current"=>"none");
            } else if($this->user_type=="manager"){
            $field = array("type"=>"Calls","type2"=>"Demos","status"=>"status","theid"=>"booker_id","date"=>"assign_date","RESULT"=>"APP","current"=>"ASSIGNED");
            }

       

       
        return $field;
    }

    public function getmonthlyearn($table, $search, $op, $value, $column ){
        return DB::query("SELECT SUM(payout) as earning FROM $table WHERE $search $op '$value' AND MONTH($column) = MONTH(now()) AND YEAR($column)=YEAR(NOW()) GROUP BY MONTH($column) ORDER BY $column DESC ");
    }

    public function getweeklyearn($table, $search, $op, $value, $column ){
        return DB::query("SELECT SUM(payout) as earning FROM $table WHERE $search $op '$value' AND WEEK($column) = WEEK(now()) AND YEAR($column)=YEAR(NOW()) GROUP BY WEEK($column) ORDER BY $column DESC ");
    }

    public function getmonthlystats($table, $search, $op, $value, $column ){
        return DB::query("SELECT COUNT(id) as total FROM $table WHERE $search $op '$value' AND MONTH($column) = MONTH(now()) AND YEAR($column)=YEAR(NOW()) GROUP BY MONTH($column) ORDER BY $column DESC ");
    }

    public function getweeklystats($table, $search, $op, $value, $column ){
        return DB::query("SELECT COUNT(id) as total FROM $table WHERE $search $op '$value' AND MONTH($column) = MONTH(now()) AND YEAR($column)=YEAR(NOW()) GROUP BY WEEK($column) ORDER BY $column DESC ");
    }
    
    public function getdailystats($table, $search, $op, $value, $column ){
        return DB::query("SELECT COUNT(id) as day FROM $table WHERE $search $op '$value' AND MONTH($column) = MONTH(now()) AND YEAR($column)=YEAR(NOW()) GROUP BY DAY($column) ORDER BY $column DESC ");
    }
   
    public function getstatcount($field, $search, $date){
        return Lead::where($field,'=',$search)
        ->where('app_date','=',$date)
        ->count();
    }

    public function getmonthstats($field, $search, $startdate, $enddate){
        return Lead::where($field,'=',$search)
        ->where('app_date','>',$startdate)
        ->where('app_date','<',$enddate)
        ->count();
    }




    /*CHARTS AND SUCH*/
    public function usersbarchart(){
        if(Auth::user()->user_type=="agent"){
            $total = $this->getmonthlystats('leads','booker_id','=',$this->id,'call_date');
            $closed = $this->getmonthlystats('leads','status','=','APP','call_date');
        } elseif(Auth::user()->user_type=="salesrep"){
            $total = $this->getmonthlystats('leads','rep','=',$this->id,'app_date');
            $closed = $this->getmonthlystats('leads','result','=','SOLD','app_date');
        }
       
        $totaldata = array();
        $closeddata= array();
        $i=0;

        foreach($total as $val){
            if(isset($closed[$i])){
                array_push($closeddata, $closed[$i]->total);
            } else {array_push($closeddata, 0);}
            $i++;
            array_push($totaldata, $val->total);
        }
        //TEST ARRAY FOR CHART TESTING
        //$array = array("total"=>array(32,22,14,23,24,22,32,22,14,23,24,22),"sales"=>array(1,4,2,4,5,2,1,4,2,4,5,2));

        $array = array("totals"=>$totaldata,"closed"=>$closeddata);
        return json_encode($array);

    }

}