<?php
class Lead extends Eloquent
{   
    public static $table = null;
    public function __construct()
    {
        parent::__construct();
        static::$table = Auth::user()->tenantTable()."_leads";
    }
    public static $connection = 'clozertools-tenant-data';
    public static $timestamps = true;
    // AJAX/API loading functions




    // END AJAX

    // Display page functions



    // End display pages

    // Functions for display formatting
    public function displayCustName($upper=false,$spoused=false){
        if($upper==true){
            $name = explode(" ", strtoupper($this->cust_name));
            $spouse = explode(" ", strtoupper($this->spouse_name));
        } else {
            $name = explode(" ", strtolower($this->cust_name));
            $spouse = explode(" ", strtolower($this->spouse_name));
        }
        $displayname="";
        if(isset($name[0])){
            $displayname.=ucfirst($name[0]);
        }
        if(isset($name[1])){
            $displayname.=" ".ucfirst($name[1]);
        }
        if($spoused==true){
            if($this->spouse_name!="" && $this->spouse_name!="N" && $this->spouse_name!="NoSpouse"){
                if(!empty($spouse)){
                    $displayname.=" <b>and</b> ";
                    if(isset($spouse[0])){
                        $displayname.=ucfirst($spouse[0]);
                    }
                    if(isset($spouse[1])){  
                        $displayname.=" ".ucfirst($spouse[1]);
                    }
                }
            }
        }
        return $displayname;
    }

    public function displayAppTime($time,$type,$offset=false){


        $display="";
        $time2 = strtotime($time);
        if($type=="ampm"){
            $type = "g:i a";
        } else {
            $type = "h:i";
        }

        if($offset==true){
            if($time2!=0){
                if($this->app_offset>0){
                    $t_o = "-".$this->app_offset." Hours";
                } else {
                    $t_o = str_replace("-","+",$this->app_offset)." Hours";
                }
                $offset_time = strtotime($t_o, $time2);
                if($this->app_offset==0){
                    return "";
                } else {
                    return date($type, strtotime($offset_time));
                }
            } else {
                return "";
            }
        } else {
            return date($type, $time2);
        }
    }

    public function displayNum(){
        $data = str_replace(array("-"," ",":",")","("),"",$this->cust_num);
        $num = "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6);
        return $num;
    }

    public function displayAddress(){
        $address = explode(",",$this->address);
        if(isset($address[0])){
            return strtoupper($address[0]);
        } else {
            return "N/A";
        }
    }

    public function leadTypeIcon(){
        $leadtype = LeadType::where("leadtype_name","=",$this->original_leadtype)->first();
        if($leadtype){
            $str="";
            $l = $leadtype->leadtype_icon;
            if($this->leadtype=="Rebook" || $this->leadtype=="rebook"){
                $str.="<span class='cus-arrow-redo' data-toggle='popover' data-trigger='hover' data-placement='top' data-content='This Lead has been booked, and then rebooked' data-original-title='REBOOKED'></span>";
            }
            $str.="<span class='".$l."' data-toggle='popover' data-trigger='hover' data-placement='top' data-content='".strtoupper($this->original_leadtype)." LEAD' data-original-title='LEADTYPE'></span>";
            return $str;
        } else {
            return $this->original_leadtype;
        }
    }


    public function user(){
        return $this->belongs_to('User');
    }

    public function leadScore(){
        $s = Setting::find(1)->lead_score_type;
        $total =0 ; $leadscore = 0;
       
        $scores = DB::query("SELECT * FROM lead_scoring WHERE scoring_type = '".$s."'");
        foreach($scores as $s){
            $col = $s->lead_column;
            if($this->$col == $s->value){
                $leadscore+=$s->user_weight;
            }
                $total+=$s->user_weight;
        }
        if($leadscore!=0 && $total!=0){
            return number_format($leadscore/$total,2,'.','')*100;
        } else {
            return "N/A";
        }
    }

    public function referrals(){
       // $referrals = Lead::where('referral_id','=',$this->id)->get();
        //return $referrals;
        return $this->has_many('Lead','referral_id');
    }

    public function referrer(){
        return $this->belongs_to('Lead','referral_id');
    }

    public function calls(){
    	return $this->has_many('Call','lead_id')->order_by('created_at');
    }

    public function dupcalls(){
        $calls = Call::where('phone_no','=',$this->cust_num)->get();
        if($calls){
            return $calls;
        } else {
            return false;
        }
    }
    
    public function last_call(){
        $c = Call::where('lead_id','=',$this->id)->order_by('created_at','DESC')->first();
        if($c){
             return $c;
        } else {
            return 0;
        }
    }

    public function appointments(){
        return $this->has_many('Appointment','lead_id');
    }

    public function event(){
        return $this->belongs_to('Eventshow','event_id');
    }

    public function sale(){
        return $this->has_one('Sale','lead_id');
    }

    public function docs(){
        return $this->has_many('Doc','lead_id');
    }

    public function manilla_user(){
        return User::find($this->manilla_researcher)->firstname." ".User::find($this->manilla_researcher)->lastname;
    }

    public function delete(){
        foreach($this->calls as $call){
            $call->delete();
        }
        return parent::delete();
    }

}