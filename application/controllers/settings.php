<?php
class Settings_Controller extends Base_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->filter('before', 'auth');
    }



    public function action_index(){
        
        
    }

    public function action_xlscolumns(){
        $input = Input::get();
        $settings = Setting::find(1);
        $settings->xls_columns = implode(",",$input['columns']);
        if($settings->save()){
            return Response::json($input['columns']);
        } else {
            return Response::json("failed");
        }

    }

    public function action_edit(){
        $input = Input::get();
        $field = $input['field'];
        $value = $input['value'];

        $settings = Setting::find(1);
        if($settings){
        
            $settings->$field = $value;
            $settings->save();
            return $value;
        } else {
            return "failed";
        }
    }

}