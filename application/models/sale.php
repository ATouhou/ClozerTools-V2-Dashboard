<?php
class Sale extends Eloquent
{
    public static $timestamps = true;

    public function user(){
        return $this->belongs_to('User');
    }

    public static function paymentTypes(){
        $array = array(
            "VISA"=>"Visa",
            "AMEX"=>"Amex",
            "MasterCard"=>"Master Card",
            "CASH"=>"Cash",
            "CHQ"=>"Cheque"
        );

        $set = Setting::find(1)->finance_types;
        $finance_types = explode(",",$set);
        $new_array = array();
        if(!empty($finance_types)){
            foreach($finance_types as $s){
                $new_array[$s] = $s;
            }
        }
        
        $new = array_merge($new_array,$array);
        return $new;
    }

    public static function financePercentages(){
        $set = Setting::find(1)->finance_percentages;
        $finance_per = explode(",",$set);
        $new_array = array();
        if(!empty($finance_per)){
            foreach($finance_per as $s){
                if($s==""){
                    $new_array["NA"] = "N/A";
                } else {
                    $new_array[$s] = $s."%";
                }
               
            }
        }
        return $new_array;
    }


    public static function inventorySku($item,$returnVal=null){
        if($item==0){
            if($returnVal!=null){
                return $returnVal;
            } else {
                return false;
            }
        } else {
            $i = Inventory::find($item);
            if($i){
                return $i->sku;
            } else {
                if($returnVal!=null){
                    return $returnVal;
                } else {
                    return false;
                }
            }
        }
    }

    public function units(){
        if($this->typeofsale=="defender"){
            return 1;
        } else if($this->typeofsale=="majestic"){
            return 1;
        }
        else if($this->typeofsale=="2maj"){
            return 2;
        }
        if($this->typeofsale=="3maj"){
            return 3;
        }
        else if($this->typeofsale=="system"){
            return 2;
        }
        else if($this->typeofsale=="supersystem"){
            return 3;
        }
        else if($this->typeofsale=="megasystem"){
            return 4;
        }
        else if($this->typeofsale=="novasystem"){
            return 5;
        }
        else if($this->typeofsale=="2defenders"){
            return 2;
        }
        else if($this->typeofsale=="3defenders"){
            return 3;
        }
        else if($this->typeofsale=="2system"){
            return 4;
        }
        else if($this->typeofsale=="supernova"){
            return 6;
        } else {
            return 0;
        }
    }
    
    public static function getUnits($type){
        
        if($type=="defender"){
            $arr= array("def"=>1,"maj"=>0,"tot"=>1);
            return $arr;
        }
        if($type=="majestic"){
             $arr= array("def"=>0,"maj"=>1,"tot"=>1);
            return $arr;
        }
        if($type=="2maj"){
             $arr= array("def"=>0,"maj"=>2,"tot"=>2);
            return $arr;
        }
        if($type=="3maj"){
             $arr= array("def"=>0,"maj"=>3,"tot"=>3);
            return $arr;
        }
        if($type=="system"){
            $arr= array("def"=>1,"maj"=>1,"tot"=>2);
            return $arr;
        }
        if($type=="supersystem"){
             $arr= array("def"=>2,"maj"=>1,"tot"=>3);
            return $arr;
        }
        if($type=="megasystem"){
             $arr= array("def"=>3,"maj"=>1,"tot"=>4);
            return $arr;
        }
        if($type=="novasystem"){
            $arr= array("def"=>4,"maj"=>1,"tot"=>5);
            return $arr;
        }
        if($type=="2defenders"){
             $arr= array("def"=>2,"maj"=>0,"tot"=>2);
            return $arr;
        }
        if($type=="3defenders"){
             $arr= array("def"=>3,"maj"=>0,"tot"=>3);
            return $arr;
        }
        if($type=="2system"){
             $arr= array("def"=>2,"maj"=>2,"tot"=>4);
            return $arr;
        }
        if($type=="supernovasystem"){
             $arr= array("def"=>5,"maj"=>1,"tot"=>6);
            return $arr;
        }
        if($type=="supernova"){
             $arr= array("def"=>5,"maj"=>1,"tot"=>6);
            return $arr;
        }
    }

    public static function saleBreakdown($id=null){
        if($id==null){
            $query = "";
        } else {
            $query = "WHERE user_id = '".$id."'";
        }

            $break = DB::query("SELECT COUNT(*) as cnt,status,
                SUM(payment='VISA') VISA, SUM(payment='Mastercard') MC,
                SUM(payment='AMEX') AMEX, SUM(payment='CHQ') chq,
                SUM(pay_type='CREDITCARD') creditcard, 
                SUM(payment='CASH') cash, SUM(payment='Lendcare') lendcare,
                SUM(payment='Crelogix') cre, SUM(payment='JP') jp,
                SUM(payment!='VISA' AND payment!='CHQ' AND payment!='CASH' AND payment!='MasterCard' AND payment!='AMEX') finance,
                SUM(pay_type='APP A') app_a,SUM(pay_type='APP B') app_b,
                SUM(pay_type='APP C') app_c, SUM(pay_type='APP D') app_d,
                SUM(pay_type='APP E') app_e, SUM(pay_type='APP A') first_line,
                SUM(pay_type='APP B' OR pay_type='APP C' OR pay_type='APP D' OR pay_type='APP D') second_line
                FROM sales ".$query." GROUP BY status");

            return $break;
    }

    public function appointment(){
        return $this->has_one('Appointment','sale_id');
    }

    public function ridealong(){
        return $this->belongs_to('User','ridealong_id');
    }

    public function items(){
        return $this->has_many('Inventory','sale_id');
    }

    public function lead(){
    	return $this->belongs_to('Lead','lead_id');
    }

    public function docs(){
        return $this->has_many('Doc','sale_id');
    }

    public function invoice(){
        return $this->belongs_to('Dealerinvoice','invoice_id');
    }

    public function ridealong_invoice(){
        return $this->belongs_to('Dealerinvoice','ridealong_invoice_id');
    }

     public static function removeItems($sale){
        $nums = array("defone"=>$sale->defone,"deftwo"=>$sale->deftwo,"defthree"=>$sale->defthree,"deffour"=>$sale->deffour,"att"=>$sale->att,"maj"=>$sale->maj,"twomaj"=>$sale->twomaj,"threemaj"=>$sale->threemaj);
        foreach($nums as $k=>$n){
            if($n!=0){
                $inv = Inventory::find($n);
                if($inv){
                    $ts = $inv->sale_id;
                    $inv->date_sold = '0000-00-00';
                    $inv->sold_by = '';
                    $inv->sale_id = 0;
                    $inv->status = 'Checked Out';
                    $inv->save();

                    $hist = New InventoryHistory;
                    $hist->item_id = $inv->sku;
                    $hist->type = 'deleted';
                    $hist->message = "Item removed from sale #".$ts;
                    $hist->user_id = Auth::user()->id;
                    $hist->save();
                }
                $sale->$k=0;
            }
        }
       return $sale;
  
    }

    
}