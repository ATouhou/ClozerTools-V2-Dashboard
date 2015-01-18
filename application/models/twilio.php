<?php
class Twilio 
{	

     public $conn = "";
     public $cap = "";
     public $twiNum = "4318000396";
     public $sid = "ACf99fe976d1acd1c0d31597fae4b5f6f6"; 
     public $token = "3fa44dfa9f201f72eae8cb3cf4113467"; 
     
    /*
    //TESTING
    public $conn = "";
    public $sid = "AC71e86592dfd8db3aad709eb069847e20";
    public $token="a6085e3f62f6c509d581e5c3157ab0b3";
    public $twiNum = "+15005550006";*/
     
     	public function __construct(){
         	require('bundles/twilio-php-master/Services/Twilio.php');
        	$this->conn = new Services_Twilio($this->sid, $this->token);
            $num = Setting::find(1)->twinum;
            if(!empty($num)){
                $this->twiNum = $num;
            } else {
                $this->twiNum = "2267740391";
            }

                //6047572841 - advancedair
                //2267740391 - healthtek, atlas
                //2048171942 - mdhealth, foxvalley, ribmountain, avaeros, coastal
                //2048171675 - pureair, purus, breatheez, puretek
            
    }
   
    public function makeCall($num){
        echo $num."<br><br>";
        

        try{
            //Initiate a New Call
            $call = $this->conn->account->calls->create(
                $this->twiNum,
                $num,
                'http://demo.twilio.com/welcome/voice/'
                );
            echo "Started Call : ". $call->sid;
        } catch(Exception $e){
            echo "Error: ".$e->getMessage();
        }
        
    
    } 
   
    
    	public function sendSMS($num, $msg, $link=null){
    		if($num==null){
      	  	$num = "7788776759";
    		}
            $img=array();
            if($link!=null){
                $img = array($link);
                $call = $this->conn->account->messages->sendMessage($this->twiNum,$num,$msg,$img);
            } else {
                $call = $this->conn->account->messages->sendMessage($this->twiNum,$num,$msg);
            }
    		
    			if($call){
    				return array("status"=>$call->status);
    			} else {
    				return array("status"=>"failed");
    			}
	}

    public function capa(){
        
         return $this->conn->account->incoming_phone_numbers->getNumber('+14318000396');


    }
    
}