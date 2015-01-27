<?php
class Inventory extends Eloquent
{
    	public static $table = null;
        public function __construct()
        {
            parent::__construct();
            static::$table = Auth::user()->tenantTable()."_inventory";
        }

        public static $connection = 'clozertools-tenant-data';
        public static $timestamps = true;

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