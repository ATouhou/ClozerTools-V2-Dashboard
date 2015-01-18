<?php
class Inventory extends Eloquent
{
    	public static $timestamps = true;
    	public static $table = "inventory";

    	public function sold(){
        	return $this->belongs_to('Sale');
    	}

    	public function soldby(){
    		return $this->has_one('User');
    	}

    	public function history(){
    		return $this->has_many('InventoryHistory','item_id');
    	}

    	public static function gethistory($sku){
    		return InventoryHistory::where('item_id','=',$sku)->order_by('created_at','asc')->get();
    	}
}