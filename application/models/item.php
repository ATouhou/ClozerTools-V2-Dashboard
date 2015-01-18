<?php
class Item extends Eloquent
{
    	public static $timestamps = false;
    	public static $table = "items";

    	public function order(){
    		return $this->has_many('Orderitem','order_id');
    	}
    	
    	public static function getVacuums(){
    	$array = array(
            
        "Bissell",
        "Broom",
        "Central Vac",
        "Compact",
        "Dirt Devil",
    	"Dyson",
        "Electrolux",
        "Eureka",
        "Filter Magic",
        "Henry",
        "Hoover",
        "Kenmore",
        "Kirby",
    	"Miele",
        "Mircale Mate",
        "No Vacuum",
        "Old FQ",
        "Orek",
        "Other",
        "Panasonic",
        "Patriot",
        "Rainbow",
    	"Shark",
        "Shop Vac",
        "Simplicity",
        "Tristar",
        "Vortek",
        );
    	
    	return $array;
    	
    	}
    
}