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