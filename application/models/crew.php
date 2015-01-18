<?php
class Crew extends Eloquent
{
    public static $timestamps = false;
    public static $table = "crew";

    public function city(){
		return $this->belongs_to('City', 'city_id');
	}

	public function member(){
		return $this->belongs_to('User', 'user_id');
	}

	public function roadcrew(){
		return $this->belongs_to('Roadcrew','crew_id');
	}
}