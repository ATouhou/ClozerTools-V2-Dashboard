
<div class="modal hide fade" id="addcity_modal_exchange">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3> Add New Cities to <span class="loadCityName"></span></h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('cities/addcitiestoarea') }}" id="addcities_modal_form_exchange" >
			<label>Choose cities to add to this area</label>
			<div class="loadCityList">
				
			</div>
			<input type="hidden" name="area_id" id="area_id_num" value="">
	      <br>
			
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-danger" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#addcities_modal_form_exchange').submit();" class="btn btn-primary">ADD CHECKED CITIES TO AREA</a>
	</div>
</div>


<script>
$(document).ready(function(){
$('#tags').tagsInput({
	'minChars' : 6,
   'maxChars' : 6 ,
   'defaultText':''
});

$('.addCitytoAreaCheck').change(function(){
	var id =$(this).val();
	var area = $('#area_id_num').val();

});
});
</script>
