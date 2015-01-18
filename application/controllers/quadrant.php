<?php
class Quadrant_Controller extends Base_Controller
{
	public function __construct(){
        	parent::__construct();
        	$this->filter('before', 'auth');
        	//$this->filter('before', 'manager');
    	}
    
    	public function action_index(){
    		$quadrants = QuadrantName::get();
    	 	return View::make('quadrants.index')
    	 		->with('quadrants',$quadrants)
         		->with('active','leadsmenu');
	}
   
	public function action_create(){
		$input = Input::all();
		
		$quads = explode(",",$input['tags']);
		$cnt = 0;
		$quadarr = array();
		foreach($quads as $val){
			$chk = Quadrant::where('exchange','=',$val)->count();
			if($chk){
				$cnt++;
				$quadarr[]=$val;
			} else {
			$quad = New Quadrant;
			$quad->city_id = $input['city_id'];
			$quad->exchange = $val;
			$quad->save();
			}
		}
		if($cnt==0){
			$msg = "Successfully added all quadrants!";
		} else {
			$msg = $cnt." Quadrants were not added, because they already exist in the system...";
			foreach($quadarr as $v){
			$msg.="<span class='label label-info special'>".$v."</span>";
			}
		}
		
		Session::flash("quadrantmsg",$msg);
		
		return Redirect::back();
	}
	
	public function action_delete($id){
		$quad = Quadrant::find($id);
		$quad->delete();
		echo json_encode("Success");
	}

}