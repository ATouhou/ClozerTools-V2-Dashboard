<div class="modal hide fade" id="extra_sale_info">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Extra Info About Sale</h3>
	</div>
	<div class="modal-body">
		<form id="sale-info-form">
			<input type="hidden" name="sale_id" id="sale-extra-id"/><br/>
		<label>Filter One Item #</label>
		<input type="text" name="filter_one" id="sale-filterone"/><br/>
		<label>Filter Two Item #</label>
		<input type="text" name="filter_two" id="sale-filtertwo"/><br/>
		<label>Postal Code</label>
		<input type="text" name="postal_code" id="sale-postal_code"/><br/>
		<label>E-Mail Address</label>
		<input type="email" name="sale_email_address" id="sale-emailaddress"/><br/>
		<label> LEAD</label>
		<select name="lead_type" id="sale-leadtype">
			<option value="OL/OS">OL/OS</option>
			<option value="AL/AS">AL/AS</option>
		</select>
		</form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" class="btn btn-primary enterInfo">Save Info</a>
	</div>
</div>