<div class="modal hide fade" id="upload_xlsinventory">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Upload XLS Inventory File</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('inventory/uploadbatch') }}" id="upload_inventory" enctype="multipart/form-data">
		
		<select name="upload_city" id="upload_city">
			@foreach($cities as $val)
			<option value='{{$val->cityname}}'>{{$val->cityname}}</option>
			@endforeach
		</select>
		<label for="photo">XLS File</label>
		<input type="file" placeholder="Choose a XLS File to upload" name="xls_upload_file" id="xls_upload_file" /><br>
			
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#upload_inventory').submit();" class="btn btn-primary uploadFileButton">Upload File</a>
	</div>
</div>


<div class="modal hide fade" id="moveCity">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Move Batch of Inventory to New City</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{URL::to('inventory/changeCity')}}" id="changeCity" enctype="multipart/form-data">
			<label>Type</label>
			<select name="machineType" id="machineType-city">
				<option value="all">All Machines</option>
				<option value="majestic">Majestic</option>
				<option value="defender">Defenders</option>
				<option value="attachment">Attachments</option>
			</select><br/>
			<label><strong>FROM :</strong> </label>
			<select name="fromcity" id="fromCity" >
				@foreach($cities as $val)
				<option value="{{$val->cityname}}">{{$val->cityname}}</option>
				@endforeach
			</select><br/>

			<label><strong>TO : </strong> </label>
			<select name="tocity" id="toCity">
				@foreach($cities as $val)
				<option value="{{$val->cityname}}">{{$val->cityname}}</option>
				@endforeach
			</select><br/>
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#changeCity').submit();" class="btn btn-primary executeMove">MOVE INVENTORY</a>
	</div>
</div>



<div class="modal hide fade" id="moveDealer">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Move Batch of Inventory from One Dealer to Another</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{URL::to('inventory/movedealer')}}" id="moveFromDealer" enctype="multipart/form-data">
			<label><strong>FROM :</strong> </label>
			<select name="fromRep" id="fromRep">
				@foreach($reps as $val)
				<option value="{{$val->id}}">{{$val->fullName()}}</option>
				@endforeach
			</select><br/>
			<label><strong>TO : </strong> </label>
			<select name="toRep">
				@foreach($reps as $val)
				<option value="{{$val->id}}">{{$val->fullName()}}</option>
				@endforeach
			</select><br/>
			<h4>Machines to Move</h4>
			@foreach($reps as $r)
				@foreach($r->machines() as $m)
					@if($m->status=="Checked Out")
					<div class="repMachineBox repMachine-{{$r->id}}">
					<label>{{$m->sku}} | {{strtoupper($m->item_name)}}
						<input type="checkbox" class="repMachineCheckbox" value="{{$m->id}}" name="repMachines[]"   />
					</label>
					</div>
					@endif
				@endforeach
			@endforeach
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#moveFromDealer').submit();" class="btn btn-primary">MOVE INVENTORY</a>
	</div>
</div>
