<?php
class Orderitem extends Eloquent
{
    	public static $timestamps = false;
    	public static $table = "orderitems";

    	public function order(){
    		return $this->has_one('Order','order_id');
    	}

    
}