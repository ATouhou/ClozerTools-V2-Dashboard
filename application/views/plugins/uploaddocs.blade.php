<div class="modal hide fade" id="upload_doc">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Upload New Document</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('sales/uploadfile') }}" id="upload_doc_form" enctype="multipart/form-data">
			<label for="File">Upload File</label>
			<input type="hidden" id="theID" name="theID"/>
			<input type="hidden" id="leadID" name="leadID"/>
	        <input type="file" placeholder="Choose a document to upload" name="theDoc" id="theDoc" /><br/><br/>
	        <label for="File">Enter Optional Name </label><span class='small'>(if empty, filename will be used as the name)</span><br/>
	        <input type="text" placeholder="Alternative Name" name="theName" id="theName" /><br>
	        <label for="Notes">Optional Notes : </label>
	        <textarea name="theNotes" id="theNotes" ></textarea>
			
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#upload_doc_form').submit();" class="btn btn-primary uploadFileButton">Upload New Document</button>
	</div>
</div>

<div class="modal hide fade" id="viewfiles_doc">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>All Files For Sale <span class='sale_id'></span></h3>
	</div>
	<input type="hidden" id="imageCount" name="imageCount" value=""/>
	<div class="modal-body" id="viewfiles_body">
		
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">CLOSE</a>
    	
	</div>
</div>