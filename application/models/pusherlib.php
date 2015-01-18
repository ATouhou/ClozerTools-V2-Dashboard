<?php
class PusherLib
{	
     public $conn = "";
     public $appID = "96002";
     public $appKey = "b3171a17e2d40caedd56"; 
     public $appSecret = "4a24313bc0982dfb1fcf"; 

     	public function __construct(){
         	require('bundles/Pusher/Pusher.php');
        	$this->conn = new Pusher($this->appKey, $this->appSecret, $this->appID);
        }
   
    public function pushMessage($msg){
        $this->conn->trigger('ct-channel','my-event',array('message'=>$msg));
    }
    
}