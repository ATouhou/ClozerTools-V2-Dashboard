<style>
.editContact{cursor:pointer;}

.contactRow {display:none;}
.other {display:none;}

</style>
	<div class='span12' style='padding-top:10px'>
		<button class='btn btn-default viewUserType' data-type='salesrep' data-head="Sales Representatives"><i class='cus-telephone'></i>&nbsp;&nbsp;DEALERS</button>
		<button class='btn btn-default viewUserType' data-type='agent' data-head="Booking Agents"><i class='cus-telephone'></i>&nbsp;&nbsp;AGENTS</button>
		<button class='btn btn-default viewUserType' data-type='researcher' data-head="Researchers"><i class='cus-script'></i>&nbsp;&nbsp;RESEARCHERS</button>
		<button class='btn btn-default viewUserType' data-type='doorrep' data-head="Door Reps"><i class='cus-door-in'></i>&nbsp;&nbsp;DOOR REPS</button>
		<button class='btn btn-default viewUserType' data-type='manager' data-head="Managers"><i class='cus-user'></i>&nbsp;&nbsp;MANAGERS</button>
		<button class='btn btn-default viewUserType' data-type='other' data-head="Business / Other Contacts" ><i class='cus-telephone'></i>&nbsp;&nbsp;OTHER CONTACTS</button>
	</div>

	<div class='span6' style='border:1px solid #ccc;padding:15px;max-height:475px;overflow:scroll;margin-top:20px;'>
	<table class='table table-condensed contactTable'>
		<thead>
			<tr>	<th style="width:6%;"></th>
				<th style="width:10%;">Name </th>
				<th class='other'>Company </th>
				<th>Cell No</th>
				<th>Phone No</th>
				<th>Sales Text</th>
			</tr>
		</thead>
		<tbody>
		@foreach($users as $v)
			<tr id="contact-{{$v->id}}" class='animated fadeInUp contactRow {{$v->user_type}}'>
				<td>  
					@if($v->user_type!="other")
						<img src='https://s3.amazonaws.com/salesdash/{{Setting::find(1)->shortcode}}/avatars/{{$v->avatar}}' style="width:80%;">
					@else 
						<button class='btn btn-danger btn-mini deleteContact' data-id="{{$v->id}}">X</button>
					@endif
				</td>
				<td>
					<span class='label label-info'>{{$v->firstname}} {{$v->lastname}}</span>
				</td>
				<td class="other">
					<span class='label editContact' id="companyname|{{$v->id}}">{{$v->companyname}}</span>
				</td>
				<td>	
					@if(empty($v->cell_no))
						<span class='label label-important editContact' id='cell_no|{{$v->id}}'>{{$v->cell_no}}</span>
					@else
						<span class='label label-inverse editContact' id='cell_no|{{$v->id}}'>{{$v->cell_no}}</span>
					@endif
				</td>
				<td>
					@if(empty($v->phone_no))
						<span class='label label-important editContact' id='phone_no|{{$v->id}}'>{{$v->phone_no}}</span>
					@else
						<span class='label label-inverse editContact' id='phone_no|{{$v->id}}'>{{$v->phone_no}}</span>
					@endif
				</td>
				<td>  <center>
						<input type="checkbox" id="textingAdd" value="{{$v->id}}" @if($v->texting==1) checked='checked' @endif  />
					</center>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	</div>
	<div class='span3 other animated fadeInUp' style="margin-top:14px;margin-left:20px">
		<h5>Add an Alternate Contact</h5>
		<form method="post" id="addNewContact">
			<label>First Name</label>
			<input type="text" name="firstname" id="firstname"  />
	      	<label>Last Name</label>          
	      	<input type="text" name="lastname" id="lastname"    />
	      	<label>Company Name</label>                   
	            <input type="text" name="companyname" id="companyname"  />
	      	<label>Cell Number</label>                   
	            <input type="text" name="cell_no" id="cell_no" />
	      	<label>Phone Number</label>                   
	            <input type="text" name="phone_no" id="phone_no"  />
	      </form>
	      <button class='btn btn-primary addContact'>ADD CONTACT</button>
	</div>
<script>
$(document).ready(function(){

	$('body').on('click','#textingAdd',function(){
		var id = $(this).val();
		var chk; var str;
		if($(this).is(':checked')){
			chk=1;
			str="Added user to sales text list";
		} else {
			chk=0;
			str="Removed user from sales text list";
		}
		$.getJSON('../users/enabletext/'+id,{chk:chk},function(data){
			if(data=="success") toastr.success(str,"Settings Saved");
		});
	});


	$('.addContact').click(function(){
		var form = $('#addNewContact').serialize();
		$.getJSON("{{URL::to('users/addother')}}",form,function(data){
			if(data){
				$('.contacts-body').load('{{URL::to("users/contactbook/other")}}');
			}
		});
	});

	$('.deleteContact').click(function(){
		var id=$(this).data('id');
    		if(confirm("Are you sure you want to delete this Contact?")){
        		var url = "{{URL::to('users/fulldelete/')}}"+id;
            	$.getJSON(url, function(data) {
            		console.log(data);
             		$('#contact-'+id).hide();
            		toastr.success('Contact Removed Succesfully','REMOVED')
            	});
   		}
	});

	$('.viewUserType').click(function(){
		$('.viewUserType').removeClass('btn-inverse');
		$('.contactTable tr.contactRow').hide();
		$('.other').hide();
		$('.'+$(this).data('type')).show();
		$('.contactHeader').html($(this).data('head'));
		$(this).addClass('btn-inverse');
	});


	$('.{{$page}}').show();
	$('[data-type="{{$page}}"]').addClass('btn-inverse');

	$('.editContact').editable('{{URL::to("users/edit")}}',{
	 indicator : 'Saving...',
	         tooltip   : 'Click to edit...',
	         width:'100',
	         height:'20',
	         submit  : 'OK',
	});
});

</script>