<?php
class InventoryHistory extends Eloquent
{
    	public static $timestamps = true;
    	public static $table = "inventoryhistory";

    	public function item(){
    		return $this->belongs_to('Inventory');
    	}

    


}