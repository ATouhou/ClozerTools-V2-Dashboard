
<div class="modal hide fade" id="uploadLeadsModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3> Add New Leads to <span class="loadCityName"></span></h3>
	</div>
	<div class="modal-body">
	<span class="redText">PLEASE ONLY UPLOAD FILES THAT MATCH THE FORMAT YOUR SYSTEM IS DESIGNED FOR</span>
		<form method="POST" action="{{ URL::to('lead/batchload') }}" id="upload_leads_form" enctype="multipart/form-data">
		<p>Please input only an .xls file</p>
			<input type="hidden" id="leadUploadCity" name="leadcity"/>
			<label class="control-label " for="csvfile">Choose File</label>
			<div class="controls">
				<input class="file" id="csvfile" name="csvfile" type="file" />
			</div>
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#upload_leads_form').submit();" class="btn btn-primary">Upload Leads</a>
	</div>
</div>

