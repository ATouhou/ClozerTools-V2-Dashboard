<div style='width:90%;float:left;'>
Check any dealer that was recruited by {{$user->fullName()}}
</div>
<br/><br/>
@foreach($users as $u)
 <?php if($u->id==$user->id){
 	$style=" style='display:none;'";
 } else {
 	$style="";
 };?>
 @if($u->recruited_by==0 || $u->recruited_by==$user->id)
<div class='span4' {{$style}}>
	<input type='checkbox' name='recruits[]' class='recruitCheckbox' id="recruited_by|{{$u->id}}" value="{{$user->id}}" data-name="{{$user->fullName()}}" data-recruit="{{$u->fullName()}}" @if($u->recruited_by==$user->id) checked="checked" @endif  > {{$u->fullName()}}
</div>
@endif
@endforeach
<script>
$(document).ready(function(){
	$( ".recruitCheckbox" ).change(function(){
        var theId = $(this).val();
        var name = $(this).data('name');
        var recruit = $(this).data('recruit');
        var field = $(this).attr('id');
       
        if($(this).is(':checked')){
            var val = theId;
        } else {
            var val = 0;
        }
        $.get("{{URL::to('users/edit')}}",{id:field,value:val},function(data){
            if(data!="Save Failed!"){
            	if(val!=0){
            		toastr.success(recruit+ " was attached to "+name+" as their recruit");
            	} else {
            		toastr.success(recruit+ " was removed as a recruit under "+name);
            	}
                
            } else {
                toastr.error("Failed to Save!");
            }
        });

    });
	
});

</script>