
<div class="modal hide fade" id="upload_modal_avatar">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Upload New Avatar</h3>
	</div>
	<div class="modal-body">
		<img id="uploadPreview" style="display:none;"/>
  
<!-- image uploading form -->
<form action="{{URL::to('dashboard/avatarupload')}}" method="post" enctype="multipart/form-data">
  <div id="crop_image" style='font-size:20px;font-weight:bolder;display:none;color:#000;margin-top:15px;width:100%;float:left;'>
  	Before Uploading Image Must Be Cropped as Square
  </div><br/><br/>
  <input id="uploadImage" type="file" accept="image/jpeg" name="image" />
  <input type="hidden" id="avatarID" name="avatarID" value=""/><br/><br/>
  <input id="submit_avatar_button" class="btn btn-primary btn-large" type="submit" value="Upload Cropped Image" style="display:none;">

  <!-- hidden inputs -->
  <input type="hidden" id="x" name="x" />
  <input type="hidden" id="y" name="y" />
  <input type="hidden" id="w" name="w" />
  <input type="hidden" id="h" name="h" />
</form>

		<!--<form method="POST" action="{{ URL::to('dashboard/avatarupload') }}" id="upload_modal_form_avatar" enctype="multipart/form-data">
			<label for="photo">Photo</label>
			
	        <input type="file" placeholder="Choose a photo to upload" name="photo" id="photo" /><br>
			
	    </form>-->
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	
	</div>
</div>
<script>
// set info for cropping image using hidden fields
function setInfo(i, e) {
	$('#x').val(e.x1);
	$('#y').val(e.y1);
	$('#w').val(e.width);
	$('#h').val(e.height);
	$('#submit_avatar_button').show();
}

$(document).ready(function() {
	var p = $("#uploadPreview");

	// prepare instant preview
	$("#uploadImage").change(function(){
		// fadeOut or hide preview
		p.fadeOut();

		// prepare HTML5 FileReader
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

		oFReader.onload = function (oFREvent) {
	   		p.attr('src', oFREvent.target.result).fadeIn();
		};
		$('#crop_image').show();
	});


	$('img#uploadPreview').imgAreaSelect({
		// set crop ratio (optional)
		aspectRatio: '1:1',
		onSelectEnd: setInfo
	});
});
</script>
