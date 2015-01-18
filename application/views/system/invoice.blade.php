@layout('layouts/main')
@section('content')
      <style>
      .leadrow{cursor:pointer;}
      .paypal {cursor:pointer; width:33%;}
        .edit {cursor:pointer;}
        .paid {
        background: #b8e1fc; /* Old browsers */
background: -moz-linear-gradient(top,  #b8e1fc 0%, #a9d2f3 10%, #90bae4 25%, #90bcea 37%, #90bff0 50%, #6ba8e5 51%, #a2daf5 83%, #bdf3fd 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b8e1fc), color-stop(10%,#a9d2f3), color-stop(25%,#90bae4), color-stop(37%,#90bcea), color-stop(50%,#90bff0), color-stop(51%,#6ba8e5), color-stop(83%,#a2daf5), color-stop(100%,#bdf3fd)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #b8e1fc 0%,#a9d2f3 10%,#90bae4 25%,#90bcea 37%,#90bff0 50%,#6ba8e5 51%,#a2daf5 83%,#bdf3fd 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #b8e1fc 0%,#a9d2f3 10%,#90bae4 25%,#90bcea 37%,#90bff0 50%,#6ba8e5 51%,#a2daf5 83%,#bdf3fd 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #b8e1fc 0%,#a9d2f3 10%,#90bae4 25%,#90bcea 37%,#90bff0 50%,#6ba8e5 51%,#a2daf5 83%,#bdf3fd 100%); /* IE10+ */
background: linear-gradient(to bottom,  #b8e1fc 0%,#a9d2f3 10%,#90bae4 25%,#90bcea 37%,#90bff0 50%,#6ba8e5 51%,#a2daf5 83%,#bdf3fd 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b8e1fc', endColorstr='#bdf3fd',GradientType=0 ); /* IE6-9 */
display:none;
        }
        .unpaid {
background: #febbbb; /* Old browsers */
background: -moz-linear-gradient(top,  #febbbb 0%, #fe9090 45%, #ff5c5c 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#febbbb), color-stop(45%,#fe9090), color-stop(100%,#ff5c5c)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* IE10+ */
background: linear-gradient(to bottom,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#febbbb', endColorstr='#ff5c5c',GradientType=0 ); /* IE6-9 */

        }
        .complete {
background: #fefefd; /* Old browsers */
background: -moz-linear-gradient(top,  #fefefd 0%, #dce3c4 42%, #aebf76 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fefefd), color-stop(42%,#dce3c4), color-stop(100%,#aebf76)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #fefefd 0%,#dce3c4 42%,#aebf76 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #fefefd 0%,#dce3c4 42%,#aebf76 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #fefefd 0%,#dce3c4 42%,#aebf76 100%); /* IE10+ */
background: linear-gradient(to bottom,  #fefefd 0%,#dce3c4 42%,#aebf76 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fefefd', endColorstr='#aebf76',GradientType=0 ); /* IE6-9 */
display:none;
      } 
       .problem {

       }


      </style>
<div class="modal hide fade" id="markPaid_modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Mark Invoice as Paid</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('system/paybycheque') }}" id="markpaid_form" enctype="multipart/form-data">
			 <input type="hidden" name="inv-id"  class='inv-id' id="inv-id" /><br>
       <span class='small'>You dont HAVE to enter anything here, it helps if you do, but leaving it empty and pressing MARK AS PAID, will still change this invoice to PAID.  </span><br/><br/>

		<label for="photo">Cheque # / Bank Transfer #</label>
	      <input type="text" name="payment_num" id="payment_num" /><br>
        <label for="notes">Optional Notes : </label>
        <textarea rows=3 id="inv-notes" name="inv-notes">

        </textarea>
        <label class="control-label">Date You Made The Payment</label>
        
          <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
                    <input class="datepicker-input" size="16" id="paiddate" name="paiddate" type="text" value="{{date('Y-m-d')}}"  placeholder="Select a date" />
                    <span class="add-on"><i class="cus-calendar-2"></i></span>

                </div>

	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#markpaid_form').submit();" class="btn btn-primary">MARK AS PAID</a>
	</div>
</div>


<div id="main" role="main" class="container-fluid">
    <div class="contained">
    	<!-- LEFT SIDE WIDGETS & MENU -->
    	<aside> 
        	@render('layouts.managernav')
       </aside>
        <!-- END WIDGETS -->
                
        <!-- MAIN CONTENT -->





        <div id="page-content" >
            <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;margin-top:-20px;'>&nbsp;Invoicing / Payment <div style='float:right;'>

              <button class='btn filter btn-danger' data-status='unpaid'>UNPAID INVOICES</button>
              <button class='btn btn-success filter' data-status='paid'>PAID INVOICES</button>
            <button class='btn btn-primary filter' data-status='complete'>SETTLED INVOICES</button>
            <button class='btn btn-default filter' data-status='all'>ALL INVOICES</button>
            </div></h1><br/><br/>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" >
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="W6HVUGLGAPXBL">
<input type="image" class="tooltwo" title="Click here to subscribe to a Monthly Billing option" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
           
			<div class="fluid-container">
                
                <!-- widget grid -->
                <section id="widget-grid" class="">
               	
                	<div class="row-fluid" id="appointments" style="margin-top:20px;">
                		
				
                		<div id="invoices" class="span12 jarviswidget medShadow userTable black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                        <header>
                              <h2>SYSTEM INVOICES</h2>                           
                        </header>
                        <!-- wrap div -->
                        	<div>
                        	      <div class="inner-spacer"> 
                        	            <table class="table table-bordered responsive">
                        	                  <thead>
                        	                        <tr>	
                        	                        	<th>Invoice No</th>
                        	                              <th>Start Date</th>
                        	                              <th>End Date</th>
                                                        <th>Charge / Type</th>
                        	                              <th>AMOUNT</th>
                                                        <th>Notes</th>
                        	                              <th>Status</th>
                                                        <th>Payment/Chq #</th>
                                                        <th>Payment Date</th>
                                                        <th>Settle Date</th>
                        	                              <th>Actions</th>
                        	                        </tr>
                        	                  </thead>
                        	                  <tbody>

                                                @foreach($invoices as $val)
                                                <?php if($val->status=="paid"){
									                                     $label = "success";
                                                    } elseif($val->status=="unpaid"){
                                                    	$label = "important special";
                                                    } elseif($val->status=="complete"){
                                                    	$label = "success special";
                                                    } else{
                                                    	$label = "inverse special";
                                                    } ;
                                                    ?>
                                                      <tr id="inv-{{$val->id}}" class="invoice-row {{$val->status}}" data-id="{{$val->id}}" style="color:#000">	
                                                        <td><span class='label label-inverse'>{{$val->invoice_no}}</span></td>
                                                            <td><center>
                                                            	{{date('M-d',strtotime($val->start_date))}}
                                                            	</center>
                                                            </td>
                                                            <td><center>
                                                              {{date('M-d',strtotime($val->end_date))}}
                                                              </center>
                                                            </td>
                                                            <td><center>
                                                              {{$val->type}}
                                                              </center>
                                                            </td>
                                                            <td>
                                                              <center>
                                                              ${{$val->amount}}
                                                              </center>
                                                            </td>
                                                            <td>
                                                             <span class='small'>
                                                              {{$val->notes}}
                                                              @if(!empty($val->cust_notes) && ($val->cust_notes!=''))
                                                              <br>
                                                              <b>Notes : </b>{{$val->cust_notes}}
                                                              @endif
                                                            </span>
                                                            </td>
                                                             <td>
                                                              <center><span class='label label-{{$label}}'>
                                                              {{strtoupper($val->status)}}
                                                            </span>
                                                              </center>
                                                            </td>

                                                           <td><center><span class='small'>{{$val->payment_no}}</span></center></td>
                                                           <td>
                                                              <center>
                                                               @if($val->payment_date!='0000-00-00')
                                                              {{$val->payment_date}}
                                                              @endif
                                                              </center>
                                                            </td>
                                                            <td>
                                                              <center>
                                                                @if($val->settle_date!='0000-00-00')
                                                              {{$val->settle_date}}
                                                              @endif
                                                              </center>
                                                            </td>
                                                            <td><center>
                                                               @if($val->status=="unpaid")
                                                              <button class='btn btn-primary btn-mini markPaid tooltwo' title='If you have sent a cheque, and want to mark as paid, Click here' data-id='{{$val->id}}'>MARK AS PAID
                                                              </button>
                                                              @endif
                                                              @if($val->status=="unpaid")
                                                              <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
										  <input type="hidden" name="cmd" value="_s-xclick">
                                                              @if(Setting::find(1)->shortcode=='be')
                                                              <input type="hidden" name="hosted_button_id" value="3XFEZKZ9JMS4Q">
                                                              @else
                                                              <input type="hidden" name="hosted_button_id" value="MYCQUXV3SZFWE">
                                                              @endif
                                                              <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
											<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
											</form>
										@endif
										</td>
                                                       </tr>
                                                @endforeach
                                          	</tbody>
                                    	</table>
                              	</div>
                                            <!-- end content-->
                        	</div>
                                        <!-- end wrap div -->
                        </div>


                                	

                                	
                  </div>

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
      
<script>
$(document).ready(function(){
	$('#systemmenu').addClass('expanded');

  $('.filter').click(function(data){
    var type = $(this).data('status');
    if(type=="all"){
      $('.invoice-row').show();
    } else {
      $('.invoice-row').hide();
      $('.'+type).show();
    }
  });

$('.markPaid').click(function(){
	$('.inv-id').val($(this).data('id'));
$('#markPaid_modal').modal({backdrop: 'static'});
});




});
</script>

@endsection