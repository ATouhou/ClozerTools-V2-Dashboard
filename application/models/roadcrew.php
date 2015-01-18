<?php
class Roadcrew extends Eloquent
{
    	public static $timestamps = false;
    	public static $table = "roadcrews";

    	public function crew(){
		return $this->has_many('Crew', 'crew_id');
	}

	public function cities(){
		return Crew::where('crew_id','=',$this->id)->where('type','=','city')->get();
	}

	public function members(){
		return Crew::where('crew_id','=',$this->id)->where('type','!=','city')->get();
	}

	public function citylist(){
		$citylist = array();
		$cities = $this->cities();
		foreach($cities as $cit){
			$city = City::find($cit->city_id);
			if($city){
				$citylist[$city->cityname] = $this->id;
			}
		}

		return $citylist;
	}

	

}