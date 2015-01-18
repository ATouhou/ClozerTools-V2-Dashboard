<?php
class Tenant extends Eloquent
{
    public static $timestamps = true;

    // Get the tenant that user belongs to
    public function users(){
    	return $this->has_many('User','tenant_id');
    }

    public function sales(){

    }

    public function leads(){

    }

    public function locations(){
    	return $this->has_many('Location','tenant_id');
    }

}


