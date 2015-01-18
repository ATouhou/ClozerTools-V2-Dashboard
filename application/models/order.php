<?php
class Order extends Eloquent
{
    	public static $timestamps = true;
    	public static $table = "orders";

    	public function items(){
    		return Orderitem::where('order_id','=',$this->id)->get();
    	}
    
}