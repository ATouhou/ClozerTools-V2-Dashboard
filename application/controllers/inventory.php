<?php
class Inventory_Controller extends Base_Controller
{
	 public function __construct(){
        parent::__construct();

        $this->filter('before', 'auth');


    }

    public function action_index()
    {    if(Auth::user()->user_type=="agent" && Auth::user()->assign_leads!=1){return Redirect::to('dashboard');}
        if(Auth::user()->user_type=="doorrep"){return Redirect::to('dashboard');}
        if(Setting::find(1)->inventory_levels==1){
          $defender=0;$majestic=0;$att=0;
          $alert = Alert::find(9);
        $inv = Inventory::where('status','=','In Stock')->get();
        foreach($inv as $v){
            if($v->item_name=="defender"){
                $defender++;
            }
             if($v->item_name=="majestic"){
                $majestic++;
            }
             if($v->item_name=="attachment"){
                $att++;
            }
        }
        
        if(($defender<2)||($majestic<2)||($att<2)){
          $alert->message = "Inventory levels are low!! Please restock!<br/><br/>Majestic : ".$majestic."<br/>Defenders : ".$defender."<br/>Attachments : ".$att;
          $alert->seen = 0; 
          $alert->save();
       } else {
          $alert->seen = 1; 
          $alert->save();
       }
      } else {
        $alert = Alert::find(9);
        $alert->seen = 1;
        $alert->save();
      }
        


      $input = Input::get();
      $table = "no";
      if(!empty($input)){
        if(isset($input['table'])){
          if($input['table']=="yes"){
            $table = "yes";
          } else {
            $table="no";
          }
        } 

        if(isset($input['type'])){
            $type = $input['type'];
        } else {
          $type="all";
        }
        if((isset($input['app_city']))&&($input['app_city'])!="all"){
          $city = $input['app_city'];

        } else {
          $city="All Cities";
        }
      } else {
        $type="all";
        $city="All Cities";
      }

      if($city!="All Cities"){
        $defenders = Inventory::where('location','=',$city)->where('item_name','=','defender')->order_by('location')->order_by('sku')->get(array('id','location','sku','returned','sale_id','item_name','date_received','created_at','status'));
        $majestics = Inventory::where('location','=',$city)->where('item_name','=','majestic')->order_by('location')->order_by('sku')->get(array('id','location','sku','returned','sale_id','item_name','date_received','created_at','status'));
        $attach = Inventory::where('location','=',$city)->where('item_name','=','attachment')->order_by('location')->order_by('sku')->get(array('id','location','sku','returned','sale_id','item_name','date_received','created_at','status'));
      } else {
        $defenders = Inventory::where('item_name','=','defender')->order_by('location')->order_by('sku')->get(array('id','location','sku','returned','sale_id','item_name','date_received','created_at','status'));
        $majestics = Inventory::where('item_name','=','majestic')->order_by('location')->order_by('sku')->get(array('id','location','sku','returned','sale_id','item_name','date_received','created_at','status'));
        $attach = Inventory::where('item_name','=','attachment')->order_by('location')->order_by('sku')->get(array('id','location','sku','returned','sale_id','item_name','date_received','created_at','status'));
      }
     

      $reps = User::activeUsers('salesrep');
      $cities = City::where('status','!=','leadtype')->order_by('cityname')->get();
      $inventory = Inventory::where('status','!=','Sold')->where('status','!=','Cancelled')->order_by('location')->order_by('status')->order_by('sku')->order_by('user_id')->get();

      $stats = DB::query("SELECT COUNT(*) as total, location,
        SUM(CASE WHEN item_name='majestic' THEN 1 ELSE 0 END) maj,
        SUM(CASE WHEN item_name='defender' THEN 1 ELSE 0 END) def,
        SUM(CASE WHEN item_name='attachment' THEN 1 ELSE 0 END) att
        FROM inventory GROUP BY location");

      $totalstats = DB::query("SELECT COUNT(*) as total, location,
        SUM(CASE WHEN item_name='majestic' AND status='In Stock' THEN 1 ELSE 0 END) in_maj,
        SUM(CASE WHEN item_name='defender' AND status='In Stock' THEN 1 ELSE 0 END) in_def,
        SUM(CASE WHEN item_name='attachment' AND status='In Stock' THEN 1 ELSE 0 END) in_att,
        SUM(CASE WHEN item_name='majestic' AND status='Checked Out' THEN 1 ELSE 0 END) c_maj,
        SUM(CASE WHEN item_name='defender' AND status='Checked Out' THEN 1 ELSE 0 END) c_def,
        SUM(CASE WHEN item_name='attachment' AND status='Checked Out' THEN 1 ELSE 0 END) c_att
        FROM inventory");

      $statsbyrep = DB::query("SELECT COUNT(*) as total, location,checked_by,
        SUM(CASE WHEN item_name='majestic' THEN 1 ELSE 0 END) maj,
        SUM(CASE WHEN item_name='defender' THEN 1 ELSE 0 END) def,
        SUM(CASE WHEN item_name='attachment' THEN 1 ELSE 0 END) att
        FROM inventory GROUP BY checked_by");

      $machinelist = Item::where('type','=','stock')->where('status','=','active')->get();
       if(isset($input['oldstyle'])){
           return View::make('inventory.index(backup)')
      ->with('def',$defenders)
      ->with('machinelist', $machinelist)
      ->with('maj',$majestics)
      ->with('type',$type)
      ->with('city',$city)
      ->with('att',$attach)
      ->with('cities',$cities)
      ->with('stats',$stats)
      ->with('table',$table)
      ->with('active','inventory_menu')
      ->with('reps', $reps)
      ->with('inventory',$inventory)
      ->with('machinesbyrep',$statsbyrep);
      } else {
        return View::make('inventory.newinventory')
      ->with('def',$defenders)
      ->with('machinelist', $machinelist)
      ->with('maj',$majestics)
      ->with('type',$type)
      ->with('city',$city)
      ->with('att',$attach)
      ->with('cities',$cities)
      ->with('stats',$stats)
      ->with('table',$table)
      ->with('active','inventory_menu')
      ->with('reps', $reps)
      ->with('inventory',$inventory)
      ->with('machinesbyrep',$statsbyrep);
      }
      
    }

    public function action_solditems(){
      $inventory = Inventory::where('status','!=','In Transit')->where('status','!=','In Stock')
      ->where('status','!=','Checked Out')->order_by('location')->order_by('sale_id')->get();
      return View::make('inventory.solditems')->with('inventory',$inventory);
    }

    public function action_viewinventory(){
    	 if(Auth::user()->user_type=="agent" && Auth::user()->assign_leads!=1){return Redirect::to('dashboard');}
        if(Auth::user()->user_type=="doorrep"){return Redirect::to('dashboard');}
      $input = Input::get();
      $machinelist = Item::where('type','=','stock')->where('status','=','active')->get();
      $reps = User::where("user_type","=","salesrep")->where('level','!=',99)->order_by('firstname')->get();
      
      if(!empty($input)){
        if(isset($input['type'])){
            $type = $input['type'];
        } else {
          $type="all";
        }

        if((isset($input['app_city']))&&($input['app_city'])!="all"){
          $city = $input['app_city'];
        } else {
          $city="All Cities";
        }
      } else {
        $type="all";
        $city="All Cities";
      }

      if(isset($input['city'])){
        $city = " WHERE location = '".$input['city']."'";
      } else {
        $city="";
      }
        if(isset($input['type'])){
        $type = " WHERE item_name = '".$input['type']."'";
      } else {
        $type="";
      }

      if(isset($input['status'])){
        $status = " WHERE status = '".$input['status']."'";
      } else {
        $status="";
      }

      $cities = City::where('status','=','active')->order_by('cityname')->get();
      $inventory = DB::query("SELECT * FROM inventory ORDER BY date_received");

      $stats = DB::query("SELECT COUNT(*) as total, location,
        SUM(CASE WHEN item_name='majestic' THEN 1 ELSE 0 END) maj,
        SUM(CASE WHEN item_name='defender' THEN 1 ELSE 0 END) def,
        SUM(CASE WHEN item_name='attachment' THEN 1 ELSE 0 END) att
        FROM inventory GROUP BY location");

      $totalstats = DB::query("SELECT COUNT(*) as total, location,
        SUM(CASE WHEN item_name='majestic' AND status='In Stock' THEN 1 ELSE 0 END) in_maj,
        SUM(CASE WHEN item_name='defender' AND status='In Stock' THEN 1 ELSE 0 END) in_def,
        SUM(CASE WHEN item_name='attachment' AND status='In Stock' THEN 1 ELSE 0 END) in_att,
        SUM(CASE WHEN item_name='majestic' AND status='Checked Out' THEN 1 ELSE 0 END) c_maj,
        SUM(CASE WHEN item_name='defender' AND status='Checked Out' THEN 1 ELSE 0 END) c_def,
        SUM(CASE WHEN item_name='attachment' AND status='Checked Out' THEN 1 ELSE 0 END) c_att
        FROM inventory");

      $statsbyrep = DB::query("SELECT COUNT(*) as total, location,checked_by,
        SUM(CASE WHEN item_name='majestic' THEN 1 ELSE 0 END) maj,
        SUM(CASE WHEN item_name='defender' THEN 1 ELSE 0 END) def,
        SUM(CASE WHEN item_name='attachment' THEN 1 ELSE 0 END) att
        FROM inventory GROUP BY checked_by");


      return View::make("plugins.inventory")
      ->with('inventory',$inventory)
      ->with('machinelist', $machinelist)
      ->with('cities',$cities)
      ->with('active','inventory_menu')
      ->with('reps', $reps)
      ->with('inventory',$inventory)
      ;
    }

    public function action_confirmdate(){
      $input = Input::get();
      if(isset($input['theid'])){
        $inv = Inventory::find($input['theid']);
        if($inv){
          if($input['thevalue']==1){
            $inv->date_confirmed = date('Y-m-d');
          } else {
            $inv->date_confirmed = "0000-00-00";
          }
          if($inv->save()){
            if($input['thevalue']==1){
              return Response::json(date('D d M'));
            } else {
              return Response::json("Unconfirmed");
            }
          };
        }
      } else {
        return Response::json("failed");
      }
    }

    public function action_movetostocknew($id=null){
        $input = Input::get();
        if(isset($input['city']) && isset($input['type'])){
            $inventory = Inventory::where('location','=',$input['city'])->where('status','=','In Transit')->where('item_name','=',$input['type'])->get();
            if(count($inventory)>0){
                foreach($inventory as $i){
                  $i->status = "In Stock";
                  $i->save();
                  $hist = New InventoryHistory;
                  $hist->item_id = $i->sku;
                  $hist->type = 'move';
                  $hist->message = "Moved to Stock on ".date('M-d');
                  $hist->user_id = Auth::user()->id;
                  $hist->save();
                }

              return Response::json(count($inventory));
            } else {
              return Response::json("noitems");
            }
        } else {
          if($id=="all"){
            $count = Inventory::where('status','=','In Transit')->count();
            DB::query("UPDATE inventory SET status='In Stock' WHERE status='In Transit'");
            return Response::json($count);
          } else {
            $inv = Inventory::find($id);
            if($inv){
              if($inv->status=="In Transit"){
                 $inv->status = "In Stock";
                 if($inv->save()){
                  $hist = New InventoryHistory;
                  $hist->item_id = $inv->sku;
                  $hist->type = 'move';
                  $hist->message = "Moved to Stock on ".date('M-d');
                  $hist->user_id = Auth::user()->id;
                  $hist->save();
                  return Response::json(1);
                 };
              }
            } else {
          return Response::json("failed");
        }
      }
        }

      
    }

    public function action_movetostock($id=null){
      if($id==null){
        DB::query("UPDATE inventory SET status='In Stock' WHERE status='In Transit'");
        return Redirect::back();
      } else {
        $inv = Inventory::find($id);
        if($inv){
          if($inv->status=="In Transit"){
             $inv->status = "In Stock";
             if($inv->save()){
              $hist = New InventoryHistory;
              $hist->item_id = $inv->sku;
              $hist->type = 'move';
              $hist->message = "Moved to Stock on ".date('M-d');
              $hist->user_id = Auth::user()->id;
              $hist->save();
              return json_encode($inv);
             };
          }
        } else {
          return json_encode("failed");
        }
      }
    }

    public function action_changeCity(){
      $input = Input::get();
      $type = $input['machineType'];

      if(!empty($input)){
        if($type=="all"){
          $inventory = Inventory::where('location','=',$input['fromcity'])->where('status','!=','Sold')->where('status','!=','Cancelled')->where('status','!=','In Transit')->get();
        } else {
          $inventory = Inventory::where('item_name','=',$type)->where('location','=',$input['fromcity'])->where('status','!=','Sold')->where('status','!=','Cancelled')->where('status','!=','In Transit')->get();
        }
        
        foreach($inventory as $i){
          $i->location = $input['tocity'];
          $i->save();
          $hist = New InventoryHistory;
          $hist->item_id = $i->sku;
          $hist->type = 'move';
          $hist->message = "Moved to ".$input['tocity']." on ".date('Y-m-d');
          $hist->user_id = Auth::user()->id;
          $hist->save();
        }
        
        return Redirect::back();
      } else {
        return Redirect::back();
      }
    }

  


    public function action_move(){

      $input = array('city' => Input::get('city'));
      $rules = array('city' => 'required');
       
        $validation = Validator::make($input, $rules);
           if( $validation->fails() ) {
                return Redirect::to('inventory')->with_errors($validation);
            }

        $tags = explode(",",Input::get('tags2'));
      
        foreach($tags as $val){
          $inv = Inventory::where("sku","=",$val)->get();
          $inv = Inventory::find($inv[0]->id);
          $inv->status = "In Stock";
          $inv->location = Input::get('city');
          $inv->save();
          $hist = New InventoryHistory;
          $hist->item_id = $inv->sku;
          $hist->type = 'move';
          $hist->message = "Moved to ".$input['city']." on ".$input['date'];
          $hist->user_id = Auth::user()->id;
          $hist->save();
        }
        return Redirect::to('inventory');
    }

    public function action_movedealer(){

      $input = Input::get();
      $rules = array('fromRep' => 'required', 'toRep'=>'required');
       
        $validation = Validator::make($input, $rules);
           if( $validation->fails() ) {
                return Redirect::to('inventory')->with_errors($validation);
            }
        $from = User::find($input['fromRep']);
        $to = User::find($input['toRep']);

        if(!empty($input['repMachines'])){
          foreach($input['repMachines'] as $mac){
            $m = Inventory::find($mac);
            if($m){
              if($m->checked_by==$from->fullName()){
                $m->checked_by = $to->fullName();
                $m->status = "Checked Out";
                $m->user_id = $input['toRep'];
                $t = $m->save();
                  if($t){
                    $hist = New InventoryHistory;
                    $hist->item_id = $m->sku;
                    $hist->type = 'checkout';
                    $hist->message = "Item Moved from ".$from->firstname." to ".$to->firstname." on ".date('Y-m-d');
                    $hist->user_id = Auth::user()->id;
                    $hist->save();
                  }
              }
            }
          }
        }
        return Redirect::to('inventory');
    }

    public function action_add(){
      $skus = explode(",", Input::get('tags'));
      $type = Input::get('unittype');
    
      $city = Input::get('cityname');
      $status = Input::get('inv-status');
      if($city=='none'){
        $city='';
      }
      $count=0;
      $badnums = array();
      $goodnums = array();

      foreach($skus as $val){
        $input = array('sku' => $val);
        $rules = array('sku' => 'required');
       $check = Inventory::where('sku','=',$val)->where('item_name','=',$type)->count();
       if($check>0){
             array_push($badnums, $val);
       }  else {
        $inv = New Inventory;
        $inv->item_name = $type;
        $inv->sku = $val;
        $inv->user_id = Auth::user()->id;
        $inv->date_received = date('Y-m-d');
        $inv->location = $city;
        $inv->status = $status;
        $test = $inv->save();
        if($test){
          $hist = New InventoryHistory;
          $hist->item_id = $val;
          $hist->type = 'add';
          $hist->message = "Added on ". date('Y-m-d');
          $hist->user_id = $inv->user_id = Auth::user()->id;
          $hist->save();

          $count++;
          array_push($goodnums, array("id"=>$inv->id,"sku"=>$val,"item_name"=>$inv->item_name,"location"=>$inv->location,"status"=>str_replace(" ","-",$inv->status)));
        }
      }
      }

      $results = array("bad"=>$badnums,"good"=>$goodnums);
      $msg = $count." new ".strtoupper($type)."'s have been entered. <br> ".date('M-d');
      if(!empty($nums)){$nums = implode(",",$nums);$msg="<br><strong style='color:red;'>SKU# ".$nums." already exists in system</strong>";}
      $alert = Alert::find(5);
      $alert->message = $msg;
      $alert->color = "success";
      $alert->icon = "cus-cart";
      $alert->save();
      return json_encode($results);
    }

    public function action_deleteitem($id=null){
     if(isset($id)){$theid = $id;} else {$theid = Input::get('id');}
     $item = Inventory::find($theid);
     if($item->sale_id==0){
          $hist = New InventoryHistory;
          $hist->item_id = $item->sku;
          $hist->type = 'delete';
          $hist->message = "Item deleted on ". date('M-d');
          $hist->user_id = Auth::user()->id;
          $hist->save();
        $item->delete();
        return $theid;
    } else {
      return "failed";
    }
   
    }



    public function action_return($id){
      $input = Input::get();


      $inv = Inventory::find($id);
      $user = User::find($inv->user_id);
      $inv->status="In Stock";
      $inv->checked_by = "";
      $inv->user_id = 0;      

      //TODO INVENTORY COUNTER

      $alert = Alert::find(5);
      $alert->message = "Machine #".$inv->sku." has been returned to Stock on ".date('M-d')." by ".Auth::user()->fullName();
      $alert->color = "success";
      $alert->icon = "cus-delivery";
      $alert->save();
     
      if($inv->save()){
          $hist = New InventoryHistory;
          $hist->item_id = $inv->sku;
          $hist->type = 'return';
          $hist->message = "Item returned from ".$user->firstname. " into Stock ";
          $hist->user_id = Auth::user()->id;
          $hist->save();

        if(isset($input['tableview'])){
          return Redirect::back();
        } else {
           return json_encode($inv);
        }
        
      } else {
        return json_encode("failed!");
      }
    }

    public function action_dispatch(){
      $input = Input::get();
      $inv = Inventory::find($input['id']);
      $rep = User::find(Input::get('rep'))->firstname." ".User::find(Input::get('rep'))->lastname;
      $inv->status = "Checked Out";
      $inv->checked_by = $rep;
      $inv->user_id = Input::get('rep');
      $t = $inv->save();

      $alert = Alert::find(5);
      $alert->message = "Machine #".$inv->sku." has been assigned to ".$rep." on ".date('M-d')." by ".Auth::user()->fullName();
      $alert->color = "success";
      $alert->icon = "cus-delivery";
      $alert->save();

      if($t){
          $hist = New InventoryHistory;
          $hist->item_id = $inv->sku;
          $hist->type = 'checkout';
          $hist->message = "Item assigned to ".$rep;
          $hist->user_id = Auth::user()->id;
          $hist->save();
        return json_encode($inv);
      } else {
        return json_encode("failed");
      }
      return json_encode($inv);
    }

  
    public function action_checkout(){
      $input = Input::get();  
      
      $rules = array('sku'=>'required','city'=>'required','rep'=>'required');
      $v = Validator::make($input,$rules);

      if($v->fails()){
        return Redirect::back()->with_errors($v);
      } else {
      $inv = Inventory::find($input['sku']);
      $rep = User::find($input['rep'])->firstname." ".User::find($input['rep'])->lastname;
      $inv->location = $input['city'];
      $inv->user_id = $input['rep'];
      $inv->checked_by = $rep;
      $inv->notes = $inv->notes." Machine checked out by ".$rep. "on ".date('Y-m-d');
      $inv->status = "Checked Out";
      if($inv->save()){
          $hist = New InventoryHistory;
          $hist->item_id = $inv->sku;
          $hist->type = 'checkout';
          $hist->message = "Machine checked out by ".$rep. "on ".date('M-d');
          $hist->user_id = Auth::user()->id;
          $hist->save();

      };

      $alert = Alert::find(5);
      $alert->message = "Machine #".$inv->sku." has been assigned to ".$rep." on ".date('M-d')." by ".Auth::user()->fullName();
      $alert->color = "success";
      $alert->icon = "cus-delivery";
      $alert->save();
      return Redirect::back();
      }


    }

    public function action_additem(){
      $input = Input::get();
        $rules = array('sku' => 'required','type'=>'required');
       
        $validation = Validator::make($input, $rules);
           if( $validation->fails() ) {
                 return false;
            } else {

              $numchk = Inventory::where('sku','=',$input['sku'])->where('item_name','=',$input['type'])->count();

              if($this->checkSKU($input['sku'],$input['type'])){
              
              $inv = New Inventory;
              $inv->item_name = $input['type'];
              $inv->sku = $input['sku'];
              $inv->user_id = Auth::user()->id;
              $inv->date_received = $input['date'];
              $inv->status = 'In Stock';
              $inv->notes = "Added on ".$input['date']. " by ".Auth::user()->fullName();
              if(!empty($input['rep'])){
                $repname = User::find($input['rep'])->firstname." ".User::find($input['rep'])->lastname;
                $inv->checked_by = $repname;
                $inv->user_id = $input['rep'];
                $inv->status = 'Checked Out';
              }
              if(!empty($input['city'])){
                 $inv->location = $input['city'];
              }
         
        $t = $inv->save();
        if($t){
          $hist = New InventoryHistory;
          $hist->item_id = $inv->sku;
          $hist->type = 'add';
          $hist->message = "Added on ".$input['date']. " by ".Auth::user()->fullName();
          $hist->user_id = Auth::user()->id;
          $hist->save();
         return true;
        }
              } else {
                return "alreadyin";
              }
      }
    }
    
    public function action_edit(){
      $input = Input::get();
      $x = explode("|", $input['id']);
      $inv = Inventory::find($x[1]);
      if($inv){
        if($x[0]=="sku"){
          if($this->checkSKU($input['value'],$inv->item_name)){
            $inv->$x[0] = $input['value'];
          } else {
            return "Duplicate Number!";
          }
        } else {

          if($x[0]=="user_id"){
            if($input['value']==0){
              if($inv->user_id==0 && $inv->checked_by==""){
                return "ASSIGN REP";
              } else {

              $hist = New InventoryHistory;
              $hist->item_id = $inv->sku;
              $hist->type = 'return';
              $hist->message = "Item returned from ".$inv->checked_by. " into Stock ";
              $hist->user_id = Auth::user()->id;
              $hist->save();

              $inv->status="In Stock";
              $inv->checked_by = "";
              $inv->user_id=0;
              $alert = Alert::find(5);
              $alert->message = "Machine #".$inv->sku." has been returned to Stock on ".date('M-d')." by ".Auth::user()->fullName();
              $alert->color = "success";
              $alert->icon = "cus-delivery";
              $alert->save();
              }

            } else {
              $u = User::find($input['value']);
              if($u){
                $inv->checked_by = $u->fullName();
                $inv->status = "Checked Out";
                $inv->user_id = $input['value'];
                $hist = New InventoryHistory;
                $hist->item_id = $inv->sku;
                $hist->type = 'checkout';
                $hist->message = "Machine checked out to ".$u->fullName(). "on ".date('M-d');
                $hist->user_id = Auth::user()->id;
                $hist->save();
  
                $alert = Alert::find(5);
                $alert->message = "Machine #".$inv->sku." has been assigned to ".$u->fullName()." on ".date('M-d')." by ".Auth::user()->fullName();
                $alert->color = "success";
                $alert->icon = "cus-delivery";
                $alert->save();
              } 
            }
            
          } else {
            $inv->$x[0] = $input['value'];
          }
        }
      }

      $t = $inv->save();
        if($t){
          if($x[0]=="location"){
            $hist = New InventoryHistory;
            $hist->item_id = $inv->sku;
            $hist->type = 'move';
            $hist->message = "Moved to ".$input['value']." on ".date('Y-m-d');
            $hist->user_id = Auth::user()->id;
            $hist->save();
          }
          if($x[0]=="user_id"){
            if($input['value']==0){
              return "ASSIGN REP";
            } else {
              return $u->fullName();
            }
            
          } else {
            return $input['value'];
          }
        } else {return "Save Failed!";}
    }

    public function checkSKU($sku,$type){
       $numchk = Inventory::where('sku','=',$sku)->where('item_name','=',$type)->count();
       if($numchk){
         return false;
        } else {
          return true;
        } 
    }

    public function action_crew(){

      return View::make("inventory.crew");
    }

    public function action_checksku(){
      $sku = Input::get('sku');
      $check = Inventory::where('sku','=',$sku)->first();
      if($check){
         print_r($sku);
      } else {
         return false;
      }
     
    }

    public function action_uploadbatch(){
      $input = Input::all();

        $filename = Input::file('xls_upload_file.name');
        $tmp = Input::file('xls_upload_file.tmp_name');

        if(!empty($filename)){
        $file = $tmp;
        $ext =  pathinfo($filename, PATHINFO_EXTENSION);
        if($ext!="xls" && $ext!="xlsx"){
          $msg = "<span class='animated shake label label-important special'>Not a valid file format!  Please only upload .XLS / .XLSX file</span>";
          Session::flash("upload_msg",$msg);
          return Redirect::back();
        }
        require_once 'bundles/laravel-phpexcel/PHPExcel/IOFactory.php';
        $xls = PHPExcel_IOFactory::load($file);
        $rows = $xls->getActiveSheet()->toArray(null,true,true,true);
        } else {
        $msg = "<span class='animated shake label label-important special'>No File Found / Empty Input</span>";
        Session::flash("upload_msg",$msg);
        return Redirect::back();
        }

      $entered=array();$majcount=0;$defcount=0;
      foreach($rows as $r){
        $temp = strtolower($r['A']);
        if($temp[0]=="m"){
          $m = str_replace("m","",$temp);
          if(is_numeric($m)){
            echo $m."<br>";
            $c = Inventory::where('sku','=',$m)->where('item_name','=','majestic')->count();
            if($c){
              $entered[]=$m;
            } else {
              $i = new Inventory;
              $i->sku = $m;
              $i->item_name = "majestic";
              $i->date_received = date('Y-m-d');
              $i->notes='Added on '.date('Y-m-d').' by '.Auth::user()->firstname." ".Auth::user()->lastname;
              $i->location = $input['upload_city'];
              $i->status = "In Transit";
              $i->save();
              $majcount++;
            }
          }
        }

        if($temp[0]=="d"){
          $d = str_replace("d","",$temp);
          if(is_numeric($d)){
            echo $d."<bR>";
            $c = Inventory::where('sku','=',$d)->where('item_name','=','defender')->count();
            if($c){
              $entered[]=$d;
            } else {
              $i = new Inventory;
              $i->sku = $d;
              $i->item_name = "defender";
              $i->date_received = date('Y-m-d');
              $i->notes='Added on '.date('Y-m-d').' by '.Auth::user()->firstname." ".Auth::user()->lastname;
              $i->location = $input['upload_city'];
              $i->status = "In Transit";
              $i->save();
              $defcount++;
            }
          }
        }
      }

      
      $msg="";
      if(count($entered)>0){
        $str = implode(",",$entered);
        $msg.= "<span class='label animated fadeInUp label-important special'>".count($entered). " items have already been entered. | ".$str." |";
      } else {
        $msg.="<span class='animated fadeInUp label label-info special'>";
      }
        $msg.= " Succesfully uploaded ";
        if($majcount>0){
          $msg.=$majcount." majestics ";
        }
        if($majcount>0 && $defcount>0){
          $msg.=" and ";
        }

        if($defcount>0){
          $msg.=$defcount. " defenders";
        }
        $msg.= " to stock</span>";


        if($majcount>0 || $defcount>0 || count($entered>0)){
          Session::flash("upload_msg",$msg);
        }
        
      
        return Redirect::back();
    }

    public function action_history($sku){
      if($sku==null){
        return false;
      } else {
      $history = Inventory::getHistory($sku);
      $item = Inventory::where('sku','=',$sku)->first();

      return View::make('plugins.inventoryhistory')
      ->with('history',$history)
      ->with('item',$item);
     }

    }



    



}