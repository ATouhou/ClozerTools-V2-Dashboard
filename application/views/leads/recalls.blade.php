@layout('layouts/main')
@section('content')
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
       </aside>
        <div id="page-content" >
            
        <aside class="right">
            @render('layouts.chat')
        </aside>
        </div>
    </div>
</div>
<div class="push"></div>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
$('#leadmenu').addClass('expanded');

$('.edit').editable('{{URL::to("lead/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
         loaddata : function(value, settings) {
       return {foo: "bar"};
   }
});
});
</script>
@endsection