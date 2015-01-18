@layout('layouts/main')
@section('content')

<script>
function showAddForm(){
$('#agentlist').hide();
$('#addnewagent').fadeIn(500);
window.location.hash = 'addagent';
}

function showAgents(){
$('#agentlist').fadeIn();
$('#addnewagent').hide();
window.location.hash = 'viewagents';
}
</script>

<style>
#addnewagent {display:none;}
</style>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
        <div id="page-content">
            <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;City Management</h1>  

            <span class="redText">You do not have to enter quadrants for cities.  As long as when you upload leads,  You seperate your file uploads by city. (File must only contain leads from one city)</span> 
            @if($msg>0)
            <h4>{{$msg}} Cities Were Created Automatically From leads</h4>
            @endif
                <div class="fluid-container">
                    
                        <section id="widget-grid" class="">
                            <article class="span12" style="margin-bottom:80px;">
                                <h4>Current Active Cities</h4>
                                <br>
                                <form method="post" action="{{URL::to('cities/save')}}">
                                <div class="controls" style="margin-bottom:40px;">
                                    <input id="citylist" value="" name="tags" />
                                </div>
                                <button class="btn btn-primary btn-large save-cities">SAVE</button>
                            </form>
                            </article>
                        </section>
                        <!-- end widget grid -->
                </div>      
        </div>
        <!-- end main content -->
            
        <!-- aside right on high res -->
        <aside class="right">
        @render('layouts.chat')
        <div class="divider"></div>
        </aside>
              
    </div>
            
</div>


<script>
$(document).ready(function(){
$('#citymenu').addClass('expanded');
$('#citylist').tagsInput({
   'height':'90px',
   'width':'420px',
   'defaultText':'Enter Cities',
});

$('#citylist').importTags('{{$cities}}');

$('.save-cities').click(function(){
toastr.success('City List has been Updated', 'SUCCESS!');
});

});
</script>


@endsection