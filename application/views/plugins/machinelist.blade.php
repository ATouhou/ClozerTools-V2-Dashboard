<br/><h4>Select an Item to Add to Sale # {{$sale->id}}</h4>
<br/><br/>
<form id="machinelist" method="post" action="">
<input type="hidden" id="theSaleId" name="theSaleId" value="{{$sale->id}}">

<select name="machine-no" id="machine-no">
<?php $c=0;?>
@foreach($machines as $val)
		
		<?php $c++;?>
		<option value="{{$val->id}}" > {{$val->sku}} | {{strtoupper($val->item_name)}} | {{$val->checked_by}}</option>
@endforeach
@if($c==0)
	<option value="nomachine">Rep has no Inventory assigned to them!</option>
@endif
</select>
</form>

<div class="row-fluid" style="margin-top:40px;margin-bottom:20px;">
<button class="btn btn-danger" onclick="$('.infoHover').hide();">CLOSE</button> &nbsp;&nbsp;<button class="btn btn-default addMachines">ADD</button>
</div>


<script>
$(document).ready(function(){
	$('.addMachines').click(function(e){
		e.preventDefault();
		var form = $('#machinelist').serialize();
		id = $('#theSaleId').val();
		var option = $('#machine-no').find(":selected");

		$.getJSON('{{URL::to("sales/savemachines")}}',form,function(data){
			console.log(data);
			if(data.status=="nomachine"){
				toastr.warning("No machine chosen!","ITEM NOT ADDED");
			} else if(data.status=="failed"){
				toastr.error("Saving machine failed!","ITEM NOT ADDED");
			} else if(data.status=="alreadyattached"){
				toastr.error("Please remove from SALE #:"+data.d+" before trying to add to this sale","ITEM ALREADY ON SALE # : " +data.d );
			} else {	
				var html = "<span class='label label-info  special removeMachine tooltwo'  data-type='"+data.d.item_name+"' data-sale='"+id+"' data-machine='"+data.d.id+"'  title='Click to remove item from Sale' id='maj-span-"+data.d.id+"'>"+data.d.sku+"</span>";
				$('#'+data.d.item_name+'-'+id).append(html);
				var exp = $('#'+data.d.item_name+'-addbutton-'+id).attr('data-expcount');
				var cnt = $('#'+data.d.item_name+'-addbutton-'+id).attr('data-count');
				$('#'+data.d.item_name+'-addbutton-'+id).attr('data-count',parseInt(+cnt+1));
				var finalCount = parseInt(exp)-parseInt(+cnt+1);
				$('.'+data.d.item_name+'-count-'+id).html(finalCount);
				if(finalCount==0){
					$('.'+data.d.item_name+'-td-'+id).removeClass('DNS');
					$('.'+data.d.item_name+'-count-'+id).hide();
				} 
				

				toastr.success("SKU#"+data.d.sku+" Added succesfully to Sale","ITEM ADDED!");
				option.remove();
				$('.tooltwo').tooltipster();
				
			}
			
		});
	});
});
</script>