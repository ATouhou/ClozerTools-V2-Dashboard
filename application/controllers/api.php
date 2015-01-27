<?php
class Api_Controller extends Base_Controller
{
	public function __construct(){
    		parent::__construct();
    		$this->filter('before','auth');
  	}
 	
  	// Appointments

  	// Leads

  	// Users

  	// Inventory

  	// Reports

  	// Stats and Data
  	public function action_salestats($period=null){
  		if($period==null){
  			$period = "ALLTIME";
  		}
  		$input = Input::get();
  		if(isset($input['datemin']) && isset($input['datemax'])){
  			if(isset($input['city'])){
  				$stats = Stats::saleStats($input['datemin'],$input['datemax'],$input['city']);
  			} else {
  				$stats = Stats::saleStats($input['datemin'],$input['datemax'],"");
  			}
  		} else {
  			$stats = Stats::saleStats($period,"","");
  		}
  		return Response::json(array($period=>$stats));
  	}



  	
}