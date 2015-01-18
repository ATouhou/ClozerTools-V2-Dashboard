<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/

Route::controller(Controller::detect());

Route::get('/', function()
{	
	if(Auth::check()){
		return Redirect::to('dashboard');
	} else {
		return View::make('login.index');
	}
});



// TEMPORARY TENANT CREATION AND REMOVAL
// TODO - USER SIGNUP
Route::get('modifytenant', function(){
	return View::make('home.createtenant');
});

Route::post('createtenant', function(){
	$input = Input::get();
	if($input['verify_code']=='ct-admin-123'){
		$check = Tenant::where('tenant_name','=',$input['tenant_name'])->count();
		if($check>0){
			echo "Sorry Name is taken";
		} else {
			$tenant = New Tenant;
			$tenant->tenant_name = $input['tenant_name'];
			$tenant->table_prefix = str_replace(" ","",strtolower($input['tenant_name']));
			$tenant->org_id = $input['org_id'];
			$tenant->save();

			$db = DB::connection("clozertools-tenant-data");
			$db->query("CREATE TABLE ".$tenant->table_prefix."_appointments
  				AS (SELECT * FROM advanced_appointments WHERE 1 = 2)");
			$db->query("CREATE TABLE ".$tenant->table_prefix."_leads
  				AS (SELECT * FROM advanced_leads WHERE 1 = 2)");
			echo "Tenant Created Succesfully  : ".$tenant->id;
		}
	} else {
		return View::make('home.createtenant');
	}
});

Route::post('removetenant',function(){
	$input = Input::get();
	if($input['tenant_id']==null){
		echo "ID REQUIRED";
	} else {
		$tenant = Tenant::find($input['tenant_id']);
		if($tenant){
			$db = DB::connection("clozertools-tenant-data");
			$db->query("DROP TABLE ".$tenant->table_prefix."_appointments");
			$db->query("DROP TABLE ".$tenant->table_prefix."_leads");
			if($tenant->delete()){
				echo "Tenant Removed Succesfully";
			};
		}
	}
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application. The exception object
| that is captured during execution is then passed to the 500 listener.
|
*/

Event::listen('404', function()
{	
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	
});

Route::filter('after', function($response)
{
	$response->headers('Access-Control-Allow-Origin','*');

});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});

Route::filter('manager',function(){
	if(Auth::user()->user_type!="manager") return Redirect::to('dashboard');
});