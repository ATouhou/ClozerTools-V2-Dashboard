@layout('layouts/main')
@section('content')
      <style>
      .leadrow{cursor:pointer;}
      .addItem{margin-left:10px;
      	margin-bottom:10px;}
      </style>
<div id="main" role="main" class="container-fluid">
    <div class="contained">
    	<!-- LEFT SIDE WIDGETS & MENU -->
    	<aside> 
        	@render('layouts.managernav')
       </aside>
        <!-- END WIDGETS -->
                
        <!-- MAIN CONTENT -->
        <div id="page-content" >
            <h1 id="page-header">@if(!empty($theorder)) Edit Order #{{$theorder->attributes['id']}} @else Create New Order @endif</h1>
           
			<div class="fluid-container">
                
                <!-- widget grid -->
                <section id="widget-grid" class="">

                		
                		<div class="row-fluid" id="leadmanager" style="margin-top:20px;">
                                <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                    <header>
                                        <h2>Submit an Order</h2>                           
                                    </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <form id=
                                                "update" method="post" action="{{URL::to('items/createorder')}}">
                                                <input type="hidden" name="id" id="id" @if(!empty($theorder->id)) value="{{$theorder->id}}" @else value="new" @endif>
                                                <table class="table table-bordered responsive" >
                                                    <thead>
                                                        <tr><th>Supplier Name</th>
                                                        	<th>Address</th>
                                                        	
                                                         
    													</tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr><td>
                                                    		@if($errors->has('supplier')) 
                                                    		<span class="label label-important">{{$errors->first('supplier')}}</span><br/> 
                                                    		@endif
                                                    		<input type="text" name="supplier" id="supplier" @if(!empty($theorder)) value="{{$theorder->attributes['supplier']}}" @elseif(!empty(Input::old('supplier'))) value="{{Input::old('supplier')}}" @endif />
                                                    	</td>
                                        					<td>
                                        						@if($errors->has('address')) 
                                                    				<span class="label label-important">{{$errors->first('address')}}</span><br/> 
                                                    				@endif
                                        						<input type="text" name="address" id="address" @if(!empty($theorder)) value="{{$theorder->attributes['address']}}" @elseif(!empty(Input::old('address'))) value="{{Input::old('address')}}" @endif />
                                        					</td>

                                                    </tbody>
                                                </table>
                                                <hr><h4 style='margin-left:20px;'>Items on Order<button class='btn btn-primary addItem'><i class='cus-add'></i>&nbsp;&nbsp;ADD ITEM</button></h4>
                                                <table class="table table-bordered responsive">
                                                	<thead>
                                                	<th style='width:3%;'>Qty</th>
                                                	<th>Product Name</th>
                                                	<th>Comments</th>
                                                	<th>Remove</th>
                                                	</thead>
                                                	<tbody class='orderItems'>
                                                		
                                                		<tr id='itemRow-1'>
                                                		<td class='qtyList'><input type='text' id='qty[]' name='qty[]'> </td>
                                                		<td class='selectList'><select name="items[]" id="items[]" >
                                                			@if(!empty($items))
                                                			<option value=''></option>
                                                			@foreach($items as $val)
                                                			<option value='{{$val->id}}'>{{$val->name}}</option>
                                                			@endforeach
                                                			@endif
                                                		</select></td>
                                                		<td class='notesList'><textarea id='notes[]' name='notes[]'></textarea></td>
                                                	</td>
                                                	<td><button class='btn btn-danger btn-mini removeItem' data-id="1">REMOVE ITEM</button></td>
                                                	</tr>
                                                	
                                                	
                                                </tbody>
                                                </table>

                                          </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                </div>
                        </div>
                         <button class='btn btn-default' style='margin-bottom:50px;'><i class='cus-accept'></i>&nbsp;&nbsp;SUBMIT ORDER</button>
                                          </form>
                </section>
                <!-- end widget grid -->
            
            </div>    
            
            <!--RIGHT SIDE WIDGETS-->
        <aside class="right">
            @render('layouts.chat')
        </aside>
        <!--END RIGHT SIDE WIDGETS-->

        </div>
        <!-- end main content -->
    </div>
</div><!--end fluid-container-->
<div class="push"></div>
	
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en-AU"></script>
        <script>
         var options = {
  componentRestrictions: {country: "ca"}
 };

            var autocomplete = new google.maps.places.Autocomplete($("#address")[0], options);

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                console.log(place.address_components);

              address = '';
      if (place.address_components) {
       address += place.address_components[0].short_name;
       address += " "+place.address_components[1].short_name;
       address += " ,"+" "+place.address_components[2].short_name;
      }



            });
        </script>
<script>
$(document).ready(function(){
	$('#itemmenu').addClass('expanded');

	$('body').on('click','.removeItem',function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$('#itemRow-'+id).remove();
	});

	

	$('.addItem').click(function(e){
		e.preventDefault();
		var count = $('.orderItems').children('tr').length+1;
		list = $('.selectList').html();
		qty = $('.qtyList').html();
		
		notes = $('.notesList').html();

		html="<tr id='itemRow-"+count+"'><td>"+qty+"</td><td>"+list+"</td><td>"+notes+"</td><td><button class='btn btn-danger btn-mini removeItem' onclick='function(); return false;' data-id='"+count+"'>REMOVE ITEM</button></td></tr>";
		$('.orderItems').append(html);
	});



});
</script>

@endsection