<?php
class SaleItem extends Eloquent
{
    public static $timestamps = false;
    public static $table = "sale_items";

    public static function getItems(){
    	return SaleItem::where('tenant_id','=',Auth::user()->tenant_id)->get();
    }

    public function individualItems(){
    	return DB::query("SELECT * FROM sale_inventory WHERE tenant_id = '".Auth::user()->tenant_id."' AND sale_item_id='".$this->id."'");
    }

    public static function getQty($id){
    	$qty = 0;
    	$items =  DB::query("SELECT * FROM sale_inventory WHERE tenant_id = '".Auth::user()->tenant_id."' AND sale_item_id='".$id."'");
    	if($items){
    		foreach($items as $i){
    			$qty = $qty + $i->qty;
    			//echo $i->sale_item."||".$qty."<br>";
    		}
    	}
    	return $qty;
    }

    
    
    
    
}