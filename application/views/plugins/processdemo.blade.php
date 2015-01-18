<div class="modal hide fade" id="process_modal" style="">
	<div class="well light" style="margin-bottom:0;">
		<div class="modal" id="process-modal" style="position: relative; top: auto; left: auto; right: auto; margin: 0 auto; z-index: 1; max-width: 100%;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					×
				</button>
				<h3>Calling <span class="processnumber"></span></h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="select01">Is it Mr or Mrs, or are you single?</label>
						<div class="controls">
							<select id="marriagestatus" name="marriagestatus" class="span2">
								<option value="married">Married</option>
								<option value="commonlaw">Common Law</option>
								<option value="single">Single</option> 
							</select>
						</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="javascript:void(0);" class="btn medium">Close</a>
				<a href="javascript:void(0);" class="btn medium btn-primary">Save changes</a>
			</div>
		</div>

<script>
$(document).ready(function(){
$('.process').click(function(){
var sts = $(this).data('status');
$('input#status').val(sts);




});
});
</script>


