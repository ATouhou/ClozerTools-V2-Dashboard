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
        <div id="page-content" style="background:white;">
            <h1 id="page-header">Order History</h1>
          
            <div class="fluid-container">
                
                <!-- widget grid -->
                <section id="widget-grid" class="" style="margin-bottom:40px;background:white">

                    @if(count($orders)>0)

                        
                            <div class="row-fluid" id="appointments">
                                <div class="jarviswidget" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                    <header>
                                        <h2>Order History</h2>                           
                                    </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <table class="table table-bordered responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>Date Entered</th>
                                                           
                                                            <th>Received</th>
                                                            <th>Submitted</th>
                                                            <th>Supplier Name</th>
                                                            <th>Supplier Address</th>
                                                            <th>Line Items</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!empty($orders))
                                                    @foreach($orders as $val)
                                                     <?php if($val->status=="entered"){$label="inverse";} 
                                                            elseif($val->status=="submitted") {$label="info special";} 
                                                            elseif($val->status=="received") {$label="warning special";} 
                                                            elseif($val->status=="complete") {$label="success special";};?>
                                                            

                                                        <tr id="{{$val->id}}" class="{{$val->status}} orderrow" style="color:#000">
                                                            <td><b><Center>{{$val->created_at}}</center></b></td>
                                                             <td><b>@if($val->receive_date!='0000-00-00')<Center><span class='edit' id='receive_date|{{$val->id}}'>{{$val->receive_date}}</span></center>@endif</b></td>
                                                              <td><b>@if($val->submit_date!='0000-00-00')<Center><span class='edit' id='submit_date|{{$val->id}}'>{{$val->submit_date}}</span></center>@endif</b></td>
                                                            <td class="edit" id="supplier|{{$val->id}}">{{ucfirst($val->supplier)}}</td>
                                                            <td class="edit" id="address|{{$val->id}}">{{ucfirst($val->address)}}</td>
                                                           <td ><center>{{count($val->items())}}</center></td>
                                                     
                                                            <td><center><span class="label label-{{$label}}">{{ucfirst($val->status)}}</center></span></center></td>
                                                            <td>
                                                                <center>
                                                                    <a href="{{URL::to('items/orderedit/')}}{{$val->id}}"><button class="btn btn-mini btn-default"><i class="cus-pencil"></i>&nbsp;&nbsp;EDIT ORDER</button></a>
                                                                <a href="{{URL::to('items/delorder/')}}{{$val->id}}"><button class="btn btn-mini btn-danger"><i class="cus-eye"></i>&nbsp;&nbsp;DELETE</button></a>
                                                                </center>
                                                            </td>
                                                            
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                </div>
                        </div>


                    @endif
                </section>
                <!-- end widget grid -->
            
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
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
    $('#itemmenu').addClass('expanded');

$('.edit').editable('{{URL::to("items/editorder")}}',{
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