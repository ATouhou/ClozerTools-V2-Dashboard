@layout('layouts/main')
@section('content')
<style>

</style>
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
        <div id="page-content">
            <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;Duplicate Leads</h1>
            <h3 style='margin-top:-10px;'>( {{count($leads)}} Leads have Duplicates )</h3>   
                <div class="jarviswidget medShadow black" data-widget-editbutton="false" data-widget-deletebutton="false"
                data-widget-fullscreenbutton="false" >
                    <header>
                        <h2>DUPLICATE LEADS  </h2>

                    </header>
                    <!-- wrap div -->
                    <div>
                        <div class="inner-spacer" style="padding:20px;"> 
                            <table class="apptable table table-bordered table-responsive">
                                <thead >
                                    <tr>
                                        <td>Lead ID#</td>
                                        <td>Phone Number</td>
                                        <td>Customer Name</td>
                                        <td>Entry Date</td>
                                        <td>Original Leadtype</td>
                                        <td>Leadtype</td>
                                        <td>Status</td>
                                        <td>Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leads as $k=>$val)
                                    <tr class='mainRow' id="mainRow-{{$val->cust_num}}">
                                        <td>ID #{{$val->id}}</td>
                                        <td><span style='font-weight:bolder;font-size:15px;'>{{$val->cust_num}}</span></td>
                                        <td>{{$val->cust_name}}</td>
                                        <td>
                                            @if($val->birth_date!='0000-00-00')
                                            {{$val->birth_date}}
                                            @else
                                            {{$val->entry_date}}
                                            @endif
                                        </td>
                                        <td>{{strtoupper($val->original_leadtype)}}</td>
                                        <td>{{strtoupper($val->leadtype)}}</td>
                                        <td>{{$val->status}}</td>
                                        <td>
                                            <button class='btn btn-mini btn-primary seeDuplicates' data-id='{{$val->id}}' data-num='{{$val->cust_num}}'>SEE DUPLICATES</button>
                                        </td>
                                    </tr>
                                    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="push"></div>
<script>
$(document).ready(function() {
    var img = '{{URL::to("img/loaders/misc/66.gif")}}';
    loaderIMG = "<tr class='imgLoader'><td colspan=8><center><img src='"+img+"'></center></td></tr>";

$('.seeDuplicates').click(function(){
    $('tr.duplicateRow').hide();
    var num  = $(this).data('num');
    var id = $(this).data('id');
    var theEL = $('tr#mainRow-'+num);
    theEL.after(loaderIMG);
    $.getJSON("{{URL::to('lead/duplicates/')}}"+num,function(data){
        var html="<tr class='duplicateRow' style='height:20px;'><td colspan=8><center><h4>ALL LEADS WITH ( "+num+" ) AS THE PHONE NUMBER</h4></center></td></tr>";
        if(data){
            $.each(data,function(i,val){
                    html+="<tr id='lead-"+val.id+"' class='duplicateRow'><td>ID #"+val.id+"</td><td>"+val.cust_num+"</td><td>"+val.cust_name+"</td><td>"+val.entry_date+"</td>";
                    html+="<td>"+val.original_leadtype.toUpperCase()+"</td><td>"+val.leadtype.toUpperCase()+"</td><td>"+val.status+"</td>";
                    html+="<td><button class='btn btn-mini btn-danger deleteLead' data-id='"+val.id+"'>DELETE</button></td></tr>";
            });
            html+="<tr class='duplicateRow' style='height:40px;'></tr>";
            $('.imgLoader').remove();
            theEL.after(html);
        }
    });
});

$(document).on('click','.deleteLead',function(){
    var id=$(this).data('id');
    var url = "{{URL::to('lead/delete/')}}"+id;
    $.getJSON(url, function(data) {
        if(data=="sale"){
            toastr.error('Lead cannot be deleted', 'Lead has a SALE attached');
        } else if(data=="app"){
            toastr.error('Lead cannot be deleted', 'Lead has an APPOINTMENT attached');
        } else {
            $('#lead-'+id).hide(200);
            toastr.success('Lead Sucessfully Removed', 'Lead Deleted');
        }
    });
    
});

});
</script>

@endsection