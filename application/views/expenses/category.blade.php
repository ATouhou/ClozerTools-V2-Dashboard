<form id="newCategory" method="post" action="{{URL::to('expense/addcategory')}}">
	<div style="width:100%;float:left;">
	

	<label>Categories <span class='blackText'>(Just type and hit enter or , to enter a new category)</label>
    <input id="categories" style="width:100%;" value="{{$categories}}" name="tags" />
 
    <br/>
    <button class='btn btn-large btn-default saveCategories'>SAVE</button>
	</div>
	
</form>
<script>
$(document).ready(function(){
		
	$('#categories').tagsInput({
       	height:'200px',
       	width:'90%'
    });
    
	$('.saveCategories').click(function(e){
		e.preventDefault();
		var form = $('#newCategory').serialize();
		$.ajax({
			url:"{{URL::to('expense/addcategory')}}",
			dataType:'json',
			data:form,
			success:function(data){
				if(data){
					 $('#expense_modal').modal('hide');
				} else {
					toastr.error("Could Not Save Category, Please contact admin!");
				}
			}
		});
	});


});
</script>