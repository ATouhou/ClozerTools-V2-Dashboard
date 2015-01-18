<?php
class Expense_Controller extends Base_Controller
{
	public function __construct(){
        parent::__construct();
        $this->filter('before','auth');
  }

  public function action_index(){ 
    $input = Input::get();
    $cities = City::activeCities();
    if(isset($input['month'])){
      $month = $input['month'];
    } else {
      $month = date('n');
    }

    $tags = DB::query("SELECT DISTINCT category FROM expenses");
    $monthname = date('F', mktime(0,0,0,$month, 1, date('Y')));
    $expenses = DB::query("SELECT * FROM expenses WHERE MONTH(date_paid) = MONTH('".date('Y-m-d',strtotime($monthname))."' ) AND YEAR(date_paid) = YEAR(NOW()) ORDER BY expense_amount DESC");
    $income = DB::query("SELECT * FROM sales WHERE MONTH(date) = MONTH('".date('Y-m-d',strtotime($monthname))."') AND YEAR(date) = YEAR(NOW()) AND picked_up=0 AND status!='CANCELLED' AND status!='TURNDOWN' ORDER BY price DESC");
    
    return View::make('expenses.index')
    ->with('tags',$tags)
    ->with('cities',$cities)
    ->with('expenses',$expenses)
    ->with('income',$income)
    ->with('month',$month)
    ->with('monthname',$monthname);
  }

  //* AJAX LOADED SECTIONS**//
  public function action_addnew($id=null){
    $input = Input::get();

    if(isset($input['expense_tag'])){
      if(isset($input['expense_id'])){
        $exp = Expense::find($input['expense_id']);
      } else {
        $exp = New Expense;
      }
      
      foreach($input as $k=>$i){
        if($k!="expense_id"){
          $exp->$k = $i;
        }
      }
      $exp->status="paid";
      $exp->date_paid = $input['date_paid'];
      $exp->user_id = Auth::user()->id;
      if($exp->save()){
        return Redirect::back();
      };
    } else {
      if($id){
        $expense = Expense::find($id);
      } else {
        $expense = array();
      }
      $paywith = DB::query("SHOW COLUMNS FROM expenses WHERE field='paid_with'");
      $paytype = DB::query("SHOW COLUMNS FROM expenses WHERE field='pay_type'");
      $category = explode(",",Setting::find(1)->expense_tags);

      $cities = City::activeCities();
      preg_match_all("/'(.*?)'/", $paytype[0]->type, $paytype);
      preg_match_all("/'(.*?)'/", $paywith[0]->type, $paywith);
  
      return View::make('expenses.add')
      ->with('expense',$expense)
      ->with('cities',$cities)
      ->with('paywith',$paywith[0])
      ->with('paytype',$paytype[0])
      ->with('category',$category);
    }
  }

  public function action_addcategory(){
    $input = Input::get();
    if(isset($input['tags'])){
      $set = Setting::find(1);
      if($set){
        $set->expense_tags = $input['tags'];
        if($set->save()){
          return Response::json("success");
        } else {
          return Response::json("failed");
        }
      } else {
        return Response::json("failed");
      }
      return Response::json($input);
    } else {
      $categories = Setting::find(1)->expense_tags;
      
      return View::make('expenses.category')
      ->with('categories',$categories);
    }

  }

  //****END AJAX****//


  //ADD, EDIT, UPDATE
  

  public function action_delete(){
    $input = Input::get();
    if(!empty($input)){
      $exp = Expense::find($input['expense_id']);
      if($exp){
        if($exp->delete()){
          return Response::json($exp->id);
        } else {
          return Response::json("failed");
        }
      } else {
        return Response::json("failed");
      }
    } else {
      return Response::json("failed");
    }
  }

  //*******END CRUD FUNCTIONS******//

  public function action_reports(){

  }

  public function action_cityreport(){


  }

}