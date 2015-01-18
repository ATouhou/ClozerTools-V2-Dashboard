<?php
class Scripts_Controller extends Base_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->filter('before', 'auth');
       
    }

    public function action_index(){
		return Redirect::to('scripts/booker');
    }

    public function action_booker(){
        $scripts = Script::where('type','!=','batch')->where('type','!=','objection')->get();
        $batches = Script::where('type','=','batch')->get();
	    return View::make('scripts.index')->with('scripts',$scripts)->with('batch',$batches);
    }

    public function action_objections(){
        $scripts = Script::where('type','=','objection')->order_by('id','DESC')->get();
	    return View::make('scripts.objections')
	    ->with('scripts',$scripts);
    }

    public function action_objectionsave(){
    	$input = Input::get();
        $alert = Alert::find(5);

        if(isset($input['scriptid']) && $input['scriptid']!=0){
            $script = Script::find($input['scriptid']);
            $alert->message = "Objection Script Update by ".Auth::user()->firstname. "<br> Title : <b>".$input['objtitle']."</b>";
        } else {
            $script = New Script;
            $script->type = "objection";
            $alert->message = "New Objection Script Added by ".Auth::user()->firstname. "<br> Title :<b>".$input['objtitle']."</b>";
        }
            $script->title = $input['objtitle'];
            $script->script = $input['objscript'];
            $t = $script->save();
            if($t){
              $alert->color = "success";
              $alert->icon = "cus-clipboard-sign";
              $alert->save();
              return Response::json($script->id);
            }
    }

    public function action_objectiondelete(){
    	$input = Input::get();
    	$script = Script::find($input['id']);
    
    	if($script){
    		$script->delete();
    		$alert = Alert::find(5);
    		$alert->message = "Objection Script deleted by ".Auth::user()->firstname;
    		$alert->color = "success";
    		$alert->icon = "cus-clipboard-sign";
    		$alert->save();
    		echo json_encode("Success");
    	}
    }

    public function action_createbatch(){
        $input = Input::get();
        if(isset($input['batch_name'])){
            $batch = New Script;
            $batch->type = "batch";
            $batch->title = $input['batch_name'];
            if($batch->save()){
                $id = $batch->id;
                DB::query("INSERT INTO scripts (batch_id, type, title, script)
                                SELECT ".$id." AS batch_id, type, title, script
                                FROM scripts
                                WHERE batch_id = 0 AND type!='batch' AND type!='objection'");

                return Redirect::back();
            };
        }
    }

    public function action_deletebatch(){




    }

	public function action_save(){
	   $input = Input::all();
	   $text = nl2br($input['script']);
	   
	   $script = Script::find($input['thescriptid']);
	   $script->script = $text;
	   $script->save();
	   
	   return Redirect::back();
	}
}

