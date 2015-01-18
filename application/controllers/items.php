<?php
class Items_Controller extends Base_Controller
{
	public function __construct(){
        	parent::__construct();
        	$this->filter('before','auth');
    	}

    	public function action_index(){
    		$items = Item::where('status','=','active')->order_by('id','DESC')->get();
    		return View::make('items.items')
    		->with('items',$items);
    	}
    	
    	public function action_save(){
    		$input = Input::get();

    		$item = Item::find($input['id']);
    		if(!$item){
    			$item = New Item;
    		}

    		$item->type = "stock";
    		$item->name = $input['name'];
    		$item->description = $input['desc'];
    		$item->type = $input['type'];
    		$item->price = $input['price'];
    		$c = $item->save();
    		if($c){
    		return json_encode($item);}
    	}

    	public function action_delete(){
    		$id = Input::get('id');
    		$item = Item::find($id);
    		if($item){
    			$item->status = "unactive";
    			$item->save();
    			return json_ecnode("succes");
    		}
    	}

        public function action_orderedit($id){
            $order = Order::find($id);
            if($order){
                $theorder = $order;
                $items = Item::where('status','=','active')->get();
            return View::make('items.editorder')
            ->with('items',$items)
            ->with('theorder',$order);
            } else {
                return Redirect::back();
            }



        }

        public function action_removeitem($id){
            $oitem = Orderitem::find($id);
            if($oitem){
                $oitem->delete();
                return "success";
            }
        }

    	public function action_createorder(){
    		$input = Input::all();
            if($input['id']=="new"){
                $order = New Order;
            } else {
                $order = Order::find($input['id']);
            }
            
    		$rules = array('supplier'=>'required','address'=>'required');
    		$v = Validator::make($input,$rules);
    		if($v->fails()){
    			return Redirect::back()->with_errors($v);
    		}
    		

    		$order->user_id = Auth::user()->id;
    		$order->address = $input['address'];
    		$order->supplier = $input['supplier'];
    		$order->status = $input['status'];
           /* if(($order->receive_date=='0000-00-00')&&($input['status']=="received")){
                $order->receive_date = date('Y-m-d');
            } 
            if(($order->submit_date=='0000-00-00')&&($input['status']=="submitted")){
                $order->submit_date = date('Y-m-d');
            }*/
            if($input['status']=="received"){
                $order->receive_date = date('Y-m-d');
            } 
            if($input['status']=="submitted"){
                $order->submit_date = date('Y-m-d');}

    		if($order->save()){
            if(!empty($input['items'])){
                foreach($input['items'] as $key=>$val){
                    $find = Orderitem::where('item_id','=',$input['items'][$key])->where('order_id','=',$order->id)->first();
                    if($find){
                        $item = $find;
                    } else {
                        $item = New Orderitem;
                    }
                    
                    $item->qty = $input['qty'][$key];
                    $item->notes = $input['notes'][$key];
                    $item->item_id = $input['items'][$key];
                    $item->order_id = $order->id;
                    $item->save();
                }
            }
    			return Redirect::to('items/orders');
    		};
     	}

        public function action_editorder(){

        $input = Input::get();
        $x = explode("|", $input['id']);
        $order = Order::find($x[1]);
       
        $order->$x[0] = $input['value'];
        $test = $order->save();
        if($test){echo $input['value'];} else {echo "Save Failed!";}
        
        }

        public function action_delorder($id){
            $order = Order::find($id);
            if($order->delete()){
                return Redirect::back();
            };

        }


    	public function action_submitorder(){
    		$theorder = array();
    		$items = Item::where('status','=','active')->get();
    		return View::make('items.submitorder')
    		->with('items',$items)
    		->with('theorder',$theorder);
    	}

    	public function action_orders(){
    		$orders = Order::order_by('created_at','DESC')->get();
    		return View::make('items.orders')
    		->with('orders',$orders);
    	}
    	
    	
}