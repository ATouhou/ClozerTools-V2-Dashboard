<?php
class Dealerinvoice extends Eloquent
{
    public static $timestamps = true;
    public static $table = "dealer_invoices";

    public function sale(){
    	return $this->has_many('Sale', 'invoice_id');
    }

    public function user(){
    	return $this->belongs_to('User');
    }

}