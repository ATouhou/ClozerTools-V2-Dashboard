<style>
div.tagsinput { border:1px solid #CCC; background: #FFF; padding:5px; width:300px; height:100px; overflow-y: auto;}
div.tagsinput span.tag { border: 1px solid #a5d24a; -moz-border-radius:2px; -webkit-border-radius:2px; display: block; float: left; padding: 5px; text-decoration:none; background: #cde69c; color: #638421; margin-right: 5px; margin-bottom:5px;font-family: helvetica;  font-size:13px;}
div.tagsinput span.tag a { font-weight: bold; color: #82ad2b; text-decoration:none; font-size: 11px;  } 
div.tagsinput input { width:80px; margin:0px; font-family: helvetica; font-size: 13px; border:1px solid transparent; padding:5px; background: transparent; color: #000; outline:0px;  margin-right:5px; margin-bottom:5px; }
div.tagsinput div { display:block; float: left; } 
.tags_clear { clear: both; width: 100%; height: 0px; }
.not_valid {background: #FBD8DB !important; color: #90111A !important;}
</style>
<div class="modal hide fade" id="add_modal_exchange">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3> Add New Quadrants to <span class="loadCityName"></span></h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('quadrant/create') }}" id="add_modal_form_exchange" >
			<label>Enter New 6-Digit Codes <i><b>(No dashes)</b></i></label><br/>
			Tab / Enter / Comma will seperate the exchanges<br/>
			RED means the quadrant has already been entered
			<input type="hidden" name="city_id" id="city_id" value="" />
			<input name="tags" id="tags" value="" />
	      <br>
			
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#add_modal_form_exchange').submit();" class="btn btn-primary">Add Quadrants</a>
	</div>
</div>
<script src="{{URL::to_asset('js/jquery.tagsinput.min.js')}}"></script>

<script>
$(document).ready(function(){
$('#tags').tagsInput({
	'minChars' : 6,
   'maxChars' : 6 ,
   'defaultText':''
});
});

</script>
