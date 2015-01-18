<?php
class City extends Eloquent
{
    public static $timestamps = false;
    public static $table = "cities";
    
    public function quadrant(){
		return $this->has_many('Quadrant', 'city_id');
	}

	public function subCity(){
		return $this->has_many('City','area_id');
	}

	public static function allCities($method=null){
		$cities = City::where('status','!=','leadtype')->where('type','=','city')->order_by('cityname')->get();
		if($method){
			$arr2=array();
  			foreach($cities as $val){
      			$arr2[$val->cityname] = $val->cityname;
   			}
   			return json_encode($arr2);
		} else {
			return $cities;
		}
	}
	
	public static function activeCities($method=null){
		$cities = City::where('status','=','active')->where('type','=','city')->order_by('cityname','ASC')->get();
		if($method){
			$arr2=array();
  			foreach($cities as $val){
      			$arr2[$val->cityname] = $val->cityname;
   			}
   			return json_encode($arr2);
		} else {
			return $cities;
		}
	}

	public static function activeAreas($method=null){
		$cities = City::where('status','=','active')->where('type','=','area')->order_by('cityname','ASC')->get();
		if($method){
			$arr2=array();
  			foreach($cities as $val){
      			$arr2[$val->cityname] = $val->cityname;
   			}
   			return json_encode($arr2);
		} else {
			return $cities;
		}
	}
	
	public function gifts(){


	}

	public function leadCount($type){
		$count = 0;
		if($type=="contact"){
			$count = Lead::where('city','=',$this->cityname)
			->where('status','!=','NEW')->where('status','!=','NH')->where('status','!=','INVALID')
			->where('status','!=','INACTIVE')->count();
		} elseif($type=="NEW") {
			$count = Lead::where('city','=',$this->cityname)
			->where('status','=','NEW')
			->where('assign_count','<',10)
			->count();
		} else {
			$count = Lead::where('city','=',$this->cityname)->count();
		}
		return $count;
	}

	public function cityStats(){
		$stats = DB::query("SELECT COUNT(*) as cnt,leadtype,
			original_leadtype, SUM(status!='NH' AND status!='DELETED' AND status!='NEW' AND status!='ASSIGNED') contact,
			SUM(status='DELETED' OR status='NEW' OR status='NH' OR status='ASSIGNED') uncontact, 
			SUM(status='NH') nh,SUM(status='NEW') new,SUM(status='NQ') nq,
			SUM(status='NI') ni,SUM(result='SOLD') sold,SUM(result='DNS') dns,
			SUM(status='APP' OR status='SOLD' OR status='DNS' OR status='RB') booked,SUM(status='DELETED') old_deleted, 
			SUM(status='WrongNumber') wrong FROM leads
			WHERE city='".$this->cityname."' GROUP BY original_leadtype ");
		return $stats;
	}

	public function cityRates(){
		$stats = DB::query("SELECT *, IF(ni+dnc+booked, 100*(booked)/(booked+ni+dnc), NULL) AS bookrate,
			IF(booked, 100*(sold)/(booked), NULL) AS close,
			IF(booked, 100*(sold)/(booked), NULL) AS sellrate
            FROM (SELECT COUNT(*) as cnt,leadtype,
			original_leadtype, SUM(status!='NH' AND status!='DELETED' AND status!='NEW' AND status!='ASSIGNED') contact,
			SUM(status='DELETED' OR status='NEW' OR status='NH' OR status='ASSIGNED') uncontact, 
			SUM(status='NH') nh,SUM(status='NEW') new,SUM(status='NQ') nq,
			SUM(status='NI') ni,SUM(status='DNC') dnc,SUM(result='SOLD') sold,SUM(result='DNS') dns,
			SUM(status='APP' OR status='SOLD' OR status='DNS' OR status='RB') booked,SUM(status='DELETED') old_deleted, 
			SUM(status='WrongNumber') wrong FROM leads
			WHERE city='".$this->cityname."') as SUBQUERY ");
		return $stats;
	}

	public function areaStats(){
		//TODO
	}

	public function scratchCards(){
		$tot=0;$qty=0;
		$scratch = Scratch::where('city','=',$this->cityname)->get();
		foreach($scratch as $val){
			$tot+=$val->cost;
			$qty+=$val->qty;
		}
		return array("cost"=>$tot,"qty"=>$qty);
	}

	public function getVector(){
		$cityname = explode(",",$this->cityname);
		$stats = CityStat::where('Ref_Date','=','2012')
				->where('GEO','LIKE','%'.$cityname[0].'%')
				->where('don','=','Number of taxfilers')
				->get(array('Vector'));
				if($stats){
					return $stats[0]->attributes['vector'];
				} else {
					return 0;
				}
				
	}

	public function getCityStat($theStat){
		//CAN STATS - USER UPLOADED CSV
		//****************************
		if(Setting::find(1)->mobile!=9){
			$cityname = explode(",",$this->cityname);
			if($theStat=="all"){
				if(!empty($this->database_identifier)){
					$stats = CityStat::where('Ref_Date','=','2012')
					->where('GEO','LIKE','%'.$cityname[0].'%')
					->get();
				} else {
					$stats = CityStat::where('Ref_Date','=','2012')
					->where('GEO','LIKE','%'.$cityname[0].'%')
					->get();
				}

				//Filter results wit custom words and filters;
				foreach($stats as $st){
					if($st->don=="Number of taxfilers"){
						$totalPeople = $st->value;
					}
					if (($st->value >= 0) && ($st->value <= 100)) {
						if($st->value!=0 && $totalPeople !=0){
							$st->people = number_format($totalPeople * ($st->value/100),0,'.','');
						} else {
							$st->people = 0;
						}
						
					} else {
						$st->people = $st->value;
					}
					$st->don = str_replace("taxfilers","People",$st->don);
					$st->don = str_replace("Percentage of People ","",$st->don);
					$st->don = str_replace("Percentage of persons, married","Married",$st->don);
					$st->don = str_replace("Percentage of persons with ","",$st->don);
					$st->don = str_replace("Number of persons reporting employment income and/or ","People Reporting Income or ",$st->don);
					$st->don = ucfirst($st->don);
				}
				$arr = array();
				foreach($stats as $st){
					$arr[$st->don] = $st;
				}


				return $arr;
			} else {
				if(!empty($this->database_identifier)){
					$stats = CityStat::where('Ref_Date','=','2012')
					->where('GEO','LIKE','%'.$cityname[0].'%')
					->where('don','=',$theStat)
					->get(array('value'));
				} else {
					$stats = CityStat::where('Ref_Date','=','2012')
					->where('GEO','LIKE','%'.$cityname[0].'%')
					->where('don','=',$theStat)
					->get(array('value'));
				}
				
			}
			
			if(!empty($stats)){
				$stats = number_format($stats[0]->attributes['value'],0,',',',');
			} else {
				$stats = 0;
			}
			
		} else {

			//US STATS - USER OPEN DATA API
			//****************************



		}

		return $stats;
	}

	public function getincome(){

	}

	public function getpercentages(){



	}

}