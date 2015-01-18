<input type="hidden" id="repcallout-id" value="">
		<div class="span3">
			<label>What type of Vacuum do they have?</label>
			<select name="repcallout-vacuum" data-id="vacuum|{{$app->id}}" data-theid="{{$app->id}}" class="calloutField">
				<option value=''></option>
				<?php $vacuums = Item::getVacuums();?>
				@if(is_array($vacuums))
				@foreach($vacuums as $val)
				<option value="{{$val}}" @if($app->vacuum==$val) selected="selected" @endif>{{$val}}</option>
				@endforeach
				@endif
			</select>
			<label>How many dirt pads you pull??</label>
			<select name="repcallout-dirtpads" data-id="dirtpads|{{$app->id}}" data-theid="{{$app->id}}" class="calloutField">
				<option value=''></option>
				<option value="under20" @if($app->dirtpads=="under20") selected="selected" @endif>Under 20</option>
				<option value="25-30" @if($app->dirtpads=="25-30") selected="selected" @endif>25-30</option>
				<option value="30-40" @if($app->dirtpads=="30-40") selected="selected" @endif>30-40</option>
				<option value="40-50" @if($app->dirtpads=="40-50") selected="selected" @endif>40-50</option>
				<option value="50-75" @if($app->dirtpads=="50-75") selected="selected" @endif>50-75</option>
				<option value="75-100" @if($app->dirtpads=="75-100") selected="selected" @endif>75-100</option>
				<option value="100+" @if($app->dirtpads=="100+") selected="selected" @endif>100+</option>
			</select>
			<label>Monthly Commitment / Down Payment </label>
			<input type="text" name="repcallout-commit" class="calloutField"  data-theid="{{$app->id}}" data-id="commit|{{$app->id}}"  value="{{$app->commit}}" / ><br/>

			<label><strong>Call Out Notes</strong></label>
			<textarea class="calloutField" name="callout_notes" id="callout_notes|{{$app->id}}" data-id="callout_notes|{{$app->id}}" data-theid="{{$app->id}}" rows=6 value="{{$app->callout_notes}}">{{$app->callout_notes}}</textarea>
		
		</div>
		<div class="span3">
			<label>Were you able to complete the following tests??</label>
			<input type="checkbox" class="calloutField" data-id="stroke|{{$app->id}}" name="repcallout-stroke" @if($app->stroke==1) checked="checked" @endif> 52 Stroke Test<br/>
			<input type="checkbox" class="calloutField" data-id="baking|{{$app->id}}"name="repcallout-baking" @if($app->baking==1) checked="checked" @endif> Baking Soda Test<br/>
			<input type="checkbox" class="calloutField" data-id="mattress|{{$app->id}}"name="repcallout-mattress" @if($app->mattress==1) checked="checked" @endif> Mattress Test<br/>
			<input type="checkbox"  class="calloutField" data-id="breadmilk|{{$app->id}}" name="repcallout-breadmilk" @if($app->breadmilk==1) checked="checked" @endif> Bread / Milk Test<br/>
		<br/>
			<label><strong>CUSTOMER TESTIMONIAL</strong></label>
			<textarea class="calloutField" name="testimonial" id="testimonial|{{$app->id}}" data-id="testimonial|{{$app->id}}" data-theid="{{$app->id}}" rows=6 value="{{$app->testimonial}}">{{$app->testimonial}}</textarea>
		</div>
		<div class="span4" style="padding-left:5px;border-left:1px solid #ccc;">
			<h4>Referrals From Customer</h4>
			<table class='table table-responsive'>
				<tr>
					<td>Name</td>
					<td>Number</td>
					<td>City</td>
				</tr>
				<tbody id="repcallout-Referrals">
				<?php $lead = Lead::find($app->lead_id);?>
				@if($lead)
					@if(!empty($lead->referrals))
						@foreach($lead->referrals as $r)
						<tr>
							<td>{{$r->cust_name}}</td>
							<td>{{$r->cust_num}}</td>
							<td>{{$r->city}}</td>
						</tr>
						@endforeach
					@endif
				@endif
			</tbody>
			</table>
			<br/><br/>
			<h5>Enter a New Referral</h5>
			<div style="width:100%;float:left;padding-bottom:20px;">
			<form id="callout-referral" action="" >	
			
			<input type="hidden" name="repcallout-referralID" value="{{$lead->id}}">
			<input type="text"  style="float:left;margin-left:5px;width:25%;"name="repcallout-referralname" id="repcallout-referralname" class="" value="" placeholder="Customer Name" / >
			<input type="text" style="float:left;margin-left:5px;width:25%;" name="repcallout-referralnumber" maxlength="12" onkeyup="addDashes(this)" id="repcallout-referralnumber" class="" value="" placeholder="Phone Number" / >
			<select  style="float:left;margin-left:5px;width:25%;" id="repcallout-referralcity" name="repcallout-referralcity" class="" value="" placeholder="Customer City" >
				<option value="" disabled selected>Select City for this Referral</option>
				<?php $cities = City::activeCities();?>
				@foreach($cities as $c)
				<option value="{{$c->cityname}}">{{$c->cityname}}</option>
				@endforeach
			</select>
			<br/>
			<button class='btn btn-default btn-small addNewReferralLead'>ADD REFERRAL</button>
		</form>
			</div>
			

		</div>


	<script>
	$(document).ready(function(){
		$('.addNewReferralLead').click(function(e){
			e.preventDefault();
			var city = $('#repcallout-referralcity option:selected').val() ;
			var name = $('#repcallout-referralname').val();
			var num = $('#repcallout-referralnumber').val();
			if(!city){
				toastr.warning("PLEASE CHOOSE A VALID CITY!");
				return false;
			}
			if(!name){
				toastr.warning("PLEASE ENTER A NAME FOR THIS REFERRAL!");
				return false;
			}
			if(!num){
				toastr.warning("PLEASE ENTER A PHONE NUMBER FOR THIS REFERRAL!");
				return false;
			}
			var form = $('#callout-referral').serialize();
			$.post("{{URL::to('lead/addnewreferral')}}",form,function(data){
				if(data=="alreadyexists"){
					toastr.warning("Number already exists in system!! ");
				} else if(data=="failed"){
					toastr.warning("Data Save Failed! Contact Admin");
				} else {
					toastr.success("Successfully entered new referral!");
					var html="";
					html+="<tr><td>"+data.cust_name+"</td><td>"+data.cust_num+"</td><td>"+data.city+"</td></tr>";
					$('#repcallout-Referrals').append(html);
				}
			});
		});



		$('.calloutField').change(function(){
			var id = $(this).data('id');
			var theid = $(this).data('theid');
			var val = $(this).val();
			
			if($(this).prop("checked")){
				val=1;
			}
			$.get("{{URL::to('appointment/edit')}}",{id:id, value:val},function(data){
				toastr.success("Successfuly updated information");
					$('.coimg-'+theid).attr('src','{{URL::to_asset("images/callout-done.png")}}');
			});
		});


	});
	</script>