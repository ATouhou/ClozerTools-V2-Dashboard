<?php
class System_Controller extends Base_Controller
{
	 public function __construct(){
        parent::__construct();
        $this->filter('before', 'auth');
        //$this->filter('before', 'manager');
    }

    

    public function action_settings(){
        $slots = DB::query("SELECT * FROM appointment_slots");
        return View::make("system.index")
        ->with('goals',Goal::get())
        ->with('settings',Setting::find(1))
        ->with('slots',$slots);
    }

    public function action_paytypes($types){
        if($types=="creditcard"){
            $array = array("VISA"=>"VISA","MasterCard"=>"MasterCard","AMEX"=>"American Express");
        } else if($types=="percentage"){
            $array = array("5.99"=>"5.99","12.99"=>"12.99","17.99"=>"17.99","19.90"=>"19.90","29.90"=>"29.90");
        } else {
            $array = array("JP"=>"JP Financial","Crelogix"=>"Crelogix","Lendcare"=>"Lendcare");
        }
        return Response::json($array);
    }

    public function action_apptslottime(){
        $input = Input::get();
        DB::query("UPDATE appointment_slots SET ".$input['field']." = '".$input['value']."' WHERE id = '".$input['id']."' ");
        $t = DB::query("SELECT ".$input['field']." FROM appointment_slots WHERE id = '".$input['id']."'");
        if($t){
            return Response::json($t[0]->$input['field']);
        } else {
            return Response::json("failed");
        }
    }

    public function action_addtag($type){
        $input = Input::get();
        $tag = $input['theTag'];
        $settings = Setting::find(1);
        if($type=="finance"){
            $settings->finance_types = $settings->finance_types.",".$tag;
        } else if($type=="creditcard"){
            $settings->creditcard_types = $settings->creditcard_types.",".$tag;
        } else if($type=="percentage"){
            $settings->finance_percentages = $settings->finance_percentages.",".$tag;
        }
        if($settings->save()){
            return Response::json("success");
        };
    }

    public function action_removetag($type){
        $input = Input::get();
        $tag = $input['theTag'];
        $settings = Setting::find(1);
        $check = Sale::where('payment','=',$tag)->count();
            if($check){
                return Response::json("cannotdelete");
            }
        if($type=="finance"){
            $types = explode(",",$settings->finance_types);
            $pos = array_search($tag,$types);
            if($pos){
                unset($types[$pos]);
            }
            $finance_types = implode(",",$types);
            $settings->finance_types = $finance_types;
        } elseif($type=="creditcard"){
            $types = explode(",",$settings->creditcard_types);
            $pos = array_search($tag,$types);
            if($pos){
                unset($types[$pos]);
            }
            $creditcard_types = implode(",",$types);
            $settings->creditcard_types = $creditcard_types;
        } elseif($type=="percentage"){
            $types = explode(",",$settings->finance_percentages);
            $pos = array_search($tag,$types);
            if($pos){
                unset($types[$pos]);
            }
            $finance_percentages = implode(",",$types);
            $settings->finance_percentages = $finance_percentages;
        }
        if($settings->save()){
            return Response::json("success");
        };
    }

    
    public function action_invoice(){
        $invoices = Invoice::order_by('id')->get();

        return View::make('system/invoice')
        ->with('invoices',$invoices)
        ;
    }

    public function action_paybycheque(){
        $input = Input::get();

        $inv = Invoice::find($input['inv-id']);
        if($inv){
            $inv->cust_notes = $input['inv-notes'];
            $inv->payment_no = $input['payment_num'];
            $inv->status = 'paid';
            $inv->payment_date = date('Y-m-d',strtotime($input['paiddate']));
            $inv->save();
            return Redirect::back();
        }
    
    }

    public function action_edit(){
        $input = Input::get();
        if(!empty($input)){
            $settings = Setting::find(1);
            if($input['field']=="contest_buffer"){
                $company = Company::where('shortcode','=',$settings->shortcode)->first();
                if($company){
                    $company->contest_buffer = $input['value'];
                    $allSaleStats = Stats::saleStats("ALLTIME","","");
                    foreach($allSaleStats as $v=>$r){
                        if($v=="totals"){
                            $totnits = $r['totnetunits'];
                        }
                    }
                    $company->total_units = $totnits;
                    $company->unit_buffer = $totnits;
                    $company->save();
                }
            }
            $settings->$input['field'] = $input['value'];
            if($settings->save()){
                return Response::json("success");
            } else {
                return Response::json("failed");
            };
        } else {
            return Response::json("failed");
        }
    }

    public function action_goalsedit(){
        $input = Input::get();
        if(!empty($input)){
            $id = explode("|",$input['field']);
            $goal = Goal::find($id[1]);
            if($goal){
                $goal->goal = $input['value'];
                if($goal->save()){
                    return Response::json("success");
                } else {
                    return Response::json("failed");
                }
            } else {
                return Response::json("failed");
            }
        } else {
            return Response::json("failed");
        }
    }

}