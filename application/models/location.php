<?php
class Location extends Eloquent
{
    public static $timestamps = true;
    public static $table = "system_locations";

    // Get the tenant that user belongs to
    public function tenant(){
    	return $this->belongs_to('Tenant','tenant_id');
    }

    public function state(){

    }

    public function country(){

    }

}



