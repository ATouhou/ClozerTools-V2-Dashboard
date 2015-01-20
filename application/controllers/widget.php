<?php
class Widget_Controller extends Base_Controller
{
	public function __construct(){
    		parent::__construct();
    		$this->filter('before','auth');
  	}
    
    // WIDGET CRUD FUNCTIONS
  	public function action_index(){
  		$input = Input::get();
  		$widget = Widget::find($input['theid']);
  		if($widget){
  			return View::make($widget->widget_template);
  		} else {
  			return Response::json("failed");
  		}
  	}

  	public function action_remove(){
  		$input = Input::get();
  		$widget = GridModule::find($input['theid']);
  		if($widget){
  			if($widget->delete()){
  				return Response::json("success");
  			} else {
  				return Response::json("failed");
  			};
  		} else {
  			return Response::json("no id provided");
  		}
  	}

  	public function action_create(){
  		$input = Input::get();
  		$widget = Widget::find($input['theid']);
  		if($widget){
  			$newwidget = New GridModule;
  			$newwidget->tenant_id = Auth::user()->tenant_id;
  			$newwidget->user_id = Auth::user()->id;
  			$newwidget->widget_id = $widget->id;
  			if(isset($input['custom_name'])){
  				$newwidget->custom_name = $input['custom_name'];
  			} else {
  				$newwidget->custom_name = $widget->widget_name;
  			}
  			if($newwidget->save()){
  				return View::make($widget->widget_template);
  			} else {
  				return Response::json("failed");
  			};
  		} else {
  			return Response::json("failed");
  		}
  	}


    // WIDGET PAGES & FORMS
    public function action_addnewwidget(){
      $myWidgets = GridModule::myModules();
      $ids = array();
      if($myWidgets){
        foreach($myWidgets as $my){
          $ids[] = $my->widget_id;
        }
      }
      $widgets = Widget::get();
      return View::make('forms.newwidget')->with('widgets',$widgets)->with('myWidgets',$ids);
    }




}