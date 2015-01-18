@layout('layouts/main')
@section('content')
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- LEFT SIDE WIDGETS & MENU -->
        <aside> 
            @render('layouts.managernav')
       </aside>
        <!-- END WIDGETS -->
                
        <!-- MAIN CONTENT -->
        <div id="page-content" >
            <h1 id="page-header"></h1>   
            <div class="fluid-container">
                
                <h3>Your Invoices </h3>
                <h5>Select two dates and click CREATE INVOICE, to generate a new invoice to be paid on</h5>
                    <div class="well row-fluid">
                        <form method="post" action="" id="dates" name="dates"/>
                        FROM : 
                        <div class="input-append date" style="margin-top:5px;" id="datepicker-js" data-date="{{$startdate}}" data-date-format="yyyy-mm-dd">
                        <input class="datepicker-input" size="16" id="startdate" name="startdate" type="text" value="{{$startdate}}" placeholder="Select a date" />
                        <span class="add-on"><i class="cus-calendar-2"></i></span>
                        </div>
                        &nbsp;&nbsp;TO : 
                        <div class="input-append date" style="margin-top:5px;" id="datepicker-js" data-date="{{$enddate}}" data-date-format="yyyy-mm-dd">
                        <input class="datepicker-input" size="16" id="enddate" name="enddate" type="text" value="{{$enddate}}" placeholder="Select a date" />
                        <span class="add-on"><i class="cus-calendar-2"></i></span>
                        </div>
                        <button class="btn btn-primary" style="margin-left:20px;margin-top:-6px;"><i class="cus-application-view-tile"></i>&nbsp;CREATE INVOICE</button>
                        </form>
                    </div>
                    @if(Session::has('msg'))
                    <span class='label label-important'>The chosen period contains no valid leads, please choose another period</span>
                    @endif
                        <div class="row-fluid" style="margin-top:30px;margin-bottom:40px;">
                            <div class="span12">
                                <table class="table apptable" >
                                    <thead>
                                        <tr style="background:#1f1f1f;color:#fff;">
                                            <th style="width:7%;">Invoice #</th>
                                            <th style="width:10%;">Reggier</th>
                                            <th style="width:9%;">Date Issued</th>
                                            <th style="width:9%;">Date Paid</th>
                                            <th style="width:11%;">TIME PERIOD</th>
                                            <th style="width:6%;">Valid</th>
                                            <th style="width:8%;">Wrong #'s</th>
                                            <th>Invoice Amount</th>
                                            <th>Notes</th>
                                            <th>Chq #</th>
                                            <th style="width:6%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $val)
                                        <?php if($val->status=="unpaid"){$label='important special';$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";$label='success special blackText';}
                                                          ;?>
                                        <tr id="invoicerow-{{$val->id}}">
                                        <td>
                                            {{$val->invoice_no}}
                                        </td>
                                        <td>
                                            {{User::find($val->user_id)->firstname}} {{User::find($val->user_id)->lastname}}
                                        </td>
                                       
                                        <td><span class='label label-inverse'>{{date('M d',strtotime($val->date_issued))}}</span></td>
                                        
                                        <td> @if($val->date_paid!='0000-00-00')  
                                            <span class='label label-success'>
                                                {{date('M d',strtotime($val->date_paid))}} 
                                            </span>
                                            @else 
                                            <span class='label label-important'>UNPAID</span>
                                            @endif
                                        </td>
                                         <td>{{date('M-d',strtotime($val->startdate))}} - {{date('M-d',strtotime($val->enddate))}}</td>
                                        <td>{{$val->valid}}</td>
                                        <td>{{$val->invalid}}</td>
                                        <td>{{$val->amount}}</td>
                                        <td>{{$val->notes}}</td>
                                        <td>{{$val->cheque_no}}</td>
                                        <td><span class='label label-{{$label}}'>{{strtoupper($val->status)}}</span>
                                            @if($val->status=="unpaid")
                                            <button data-id='{{$val->id}}' class='btn btn-mini btn-danger deleteInvoice'>X</button>
                                            @endif
                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
            </div>    
            
            <!--RIGHT SIDE WIDGETS-->
        <aside class="right">
            @render('layouts.chat')
        </aside>
        <!--END RIGHT SIDE WIDGETS-->
        </div>
        <!-- end main content -->
    </div>
</div><!--end fluid-container-->
<div class="push"></div>
<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
$('.edit').editable('{{URL::to("lead/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
});

$('.changeDate').change(function(){
      var t = $(this).data('id');
      var val = $(this).find('input').val();
      $.get('../../lead/edit',{id:t,value:val}, function(data){
        toastr.success('Date updates succesfully!', 'DATE UPDATED');
      });
});



$('.deleteInvoice').click(function(e){
    e.preventDefault;
var t = confirm('Are you sure you want to delete this Invoice??');
  if(t){
    var id = $(this).data('id');
    $.getJSON('{{URL::to('sales/deleteinv/')}}'+id,function(data){
      $('#invoicerow-'+id).remove();
      toastr.success('Removed Invoice Successfully','INVOICE DELETED!!');
       updateCount();
    });
  }
});

});
</script>


<Script>
$(document).ready(function(){



$(".booktimepicker2").timePicker({
  startTime: "10:00", 
  endTime: new Date(0, 0, 0, 23, 30, 0), 
  show24Hours: false,
  step: 15});
});



</script>
@endsection