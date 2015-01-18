@layout('layouts/main')
@section('content')
<style>

table.apptable td select{width:80px;}
td {border:1px solid #1f1f1f;}

.unpaid{
background: #febbbb; /* Old browsers */
background: -moz-linear-gradient(top,  #febbbb 0%, #fe9090 45%, #ff5c5c 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#febbbb), color-stop(45%,#fe9090), color-stop(100%,#ff5c5c)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* IE10+ */
background: linear-gradient(to bottom,  #febbbb 0%,#fe9090 45%,#ff5c5c 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#febbbb', endColorstr='#ff5c5c',GradientType=0 ); /* IE6-9 */
}

.paid {
background: #e4efc0; /* Old browsers */
background: -moz-linear-gradient(top,  #e4efc0 0%, #7b9b5e 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e4efc0), color-stop(100%,#7b9b5e)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #e4efc0 0%,#7b9b5e 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #e4efc0 0%,#7b9b5e 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #e4efc0 0%,#7b9b5e 100%); /* IE10+ */
background: linear-gradient(to bottom,  #e4efc0 0%,#7b9b5e 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e4efc0', endColorstr='#7b9b5e',GradientType=0 ); /* IE6-9 */
}

.edit {cursor:pointer;}
.removeDeal {cursor:pointer}

.finishcancel{
	background:#6e6e6e;
}
.bordbut {border:1px solid #1f1f1f!important;
margin-top:3px;
}
.nomachine {background:#eee!important}

.imagebox {
	 -moz-box-shadow:    inset 0 0 10px #000000;
   -webkit-box-shadow: inset 0 0 10px #000000;
   box-shadow:         inset 0 0 10px #000000;
  overflow:hidden;
   padding:15px;
   border-right:1px solid #1f1f1f;
   border-radius:5px;
   float:left;
   margin-bottom:10px;
   height:120px;
      width:100px;
      text-align:center;
}

.imagebox:hover {
	background:#eee;
}

.blacktext {color:#000;cursor:pointer;background: #f3c5bd; /* Old browsers */
background: -moz-linear-gradient(top,  #f3c5bd 0%, #e86c57 50%, #ea2803 51%, #ff6600 75%, #c72200 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f3c5bd), color-stop(50%,#e86c57), color-stop(51%,#ea2803), color-stop(75%,#ff6600), color-stop(100%,#c72200)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* IE10+ */
background: linear-gradient(to bottom,  #f3c5bd 0%,#e86c57 50%,#ea2803 51%,#ff6600 75%,#c72200 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f3c5bd', endColorstr='#c72200',GradientType=0 ); /* IE6-9 */
}

.bignum3{font-size:12px;padding:5px;}
div.jGrowl.myposition {position: absolute;font-size:200%;margin-left:150px;top: 20%;}
.edit {width:100%;height:10px;}
.rightbutton{float:right;margin-top:10px;margin-right:10px;}
.bigfont{font-size:20px;padding:6px;color :#000!important;}
.weekreport {}
.weekreport th{text-align:center;background:#1f1f1f;color:#fff;}
.weekreport td {padding:10px;}
</style>

<?php if(isset($_GET['rep'])) {$rep = $_GET['rep'];} else {$rep='all';};?>
<?php $tax_rate = Setting::find(1)->tax_rate;
$reggie_rate = Setting::find(1)->reggie_rate;?>
@if(count($sales)>0)
<input type="hidden" id="hasnodeals" name="hasnodeals" value="true"/>
@else
<input type="hidden" id="hasnodeals" name="hasnodeals" value="false"/>
@endif
<div class="modal hide fade" id="newinvoice">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>Create a New Invoice</h3>
  </div>
   
  <div class="modal-body" id="newinvoice_body">
    <form method="POST" action="{{ URL::to('sales/createinvoice') }}" id="newinvoice_form">
    @if(Auth::user()->user_type=="manager")
    <label>Select the Dealer or Door Reggier</label>
    <select class='replist' name="the-rep" id="the-rep" style="width:100%;">
      <option value=""></option>
      @foreach($reps as $val)
      <option data-type='{{$val->user_type}}' value='{{$val->id}}'>{{$val->firstname}} {{$val->lastname}}</option>
      @endforeach
    </select>
  @else
    <input type="hidden" id="the-rep" name="the-rep" value="{{Auth::user()->id}}"/>
  @endif
  <div class='newinvoice-form salesrep-form' @if(Auth::user()->user_type=="manager") style='display:none;' @endif>
    <h4>Select the Deals for this Invoice / Pay Period</h4>
    <p style='color:red'>If a deal is unselectable / greyed out, it means it has not yet been funded or marked as completed by a manager</p>
    <span class='small'>  (you can always add/remove later)</span><br/>
    @for($v=0;$v<4;$v++)
     <select data-pay='0' id="selectdeal-{{$v}}" class='selectdeal' name="deals[]" style="width:100%;">
      <option class='filter' value=''></option>
    @foreach($sales as $val)
      @if($val->funded==1 && $val->status=='COMPLETE')
      <option class='selectdeal-opt' data-user='{{$val->user_id}}' data-ridealong='{{$val->ridealong_id}}' data-payout='{{$val->payout}}' value='{{$val->id}}' style="color:blue">SALE# {{$val->id}} | {{strtoupper($val->typeofsale)}} | {{$val->cust_name}} | <b>{{$val->sold_by}}</b> | COMPLETE & FUNDED</option>
      @else
      <option class='selectdeal-opt' data-user='{{$val->user_id}}' data-ridealong='{{$val->ridealong_id}}' data-payout='{{$val->payout}}' value='{{$val->id}}' disabled>SALE# {{$val->id}} | {{strtoupper($val->typeofsale)}} | {{$val->cust_name}} | <b>{{$val->sold_by}}</b> | INCOMPLETE</option>
      @endif
    @endforeach
    </select>
    @endfor
  </div>

  <div class='newinvoice-form doorrep-form' style='display:none;'>
    <label>Select the Invoice Period for Door Reggier</label>
  
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
                      
  </div>
   
   
    </form>
     <div class='newinvoice-form salesrep-form' @if(Auth::user()->user_type=="manager") style='display:none;' @endif>
    <h3>Estimated Amount of Invoice : $<span id='est-payout'>0</span> </h4>
    <span class='small'>If this number seems off, or isn't updating, please talk to your <strong>manager</strong>, as they need to enter the correct payouts on their side</span>
  </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">CLOSE</a>
        <button type="button" onclick="$('#newinvoice_form').submit();" class="btn btn-primary">SUBMIT INVOICE</button>
  </div>
</div>
<script>
$(document).ready(function(){

    $('.selectdeal').change(function(){
    var pay = $(this).find(":selected").data('payout');
    $(this).data('pay',pay);
    var p = 0;
    $('.selectdeal').each(function(i,val){
    p = parseInt($(this).data('pay'))+p;
    });

    $('#est-payout').html(p);
  });
});
</script>

<div class="modal hide fade" id="markpaid">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Mark this invoice as paid</h3>
	</div>
	<input type="hidden" id="inv-id" name="inv-id" value=""/>
	<div class="modal-body" id="markpaid_body">
    <label>Amount on Cheque / Transfer</label>
    <input type="text" name="amount" id="amount" />
    <label>Enter a Payment Identfier (ie Cheque #, Bank Transfer #, etc)</label>
		<input type="text" name="cheque_no" id="cheque_no" /><br/><br/>
    <label>Enter Optional Notes : (optional)</label>
    <textarea name="notes" id="notes" rows=8></textarea><br/><br/>
    <strong>Be Careful | </strong> Once you mark this invoice as paid, the attached sales are untouchable
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">CLOSE</a>
    	<a href="#" class="btn btn-primary markaspaid">MARK AS PAID</a>
	</div>
</div>

<div class="modal hide fade" id="attachdeal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>Attach a Deal/Sale to this Invoice<span class='invoice_id'></span></h3>
  </div>
  
  <div class="modal-body" id="attach_dealbody">

    <input type="hidden" id="attach-invoice-id" name="attach-invoice-id" value=""/>
    <label>Select a Deal to add to this invoice...</label><br/><br/>
    <select name="attach-thesale" id="attach-thesale" style="width:100%;">
    @foreach($sales as $val)
    <?php $lead = Lead::find($val->lead_id);?>
    <option value='{{$val->id}}'>

    SALE#: {{$val->id}} | {{$val->cust_name}} - {{$lead->address}} | {{$val->typeofsale}} |  {{$val->sold_by}}</option>
    @endforeach
    @if(empty($sales))
    <option value=0>There are no funded deals to pick from. Make sure all funded deals have been marked as such</option>
    @endif
    </select>
  
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">CLOSE</a>
      <button type="button" id="submitDeal" class="btn btn-primary">Attach Sale</button>
  </div>
</div>

<div id="main"  class="container-fluid lightPaperBack" style="min-height:1000px;padding:45px;padding-top:30px;padding-bottom:800px;">
	
    <h3>{{$title}}
    @if(Auth::user()->user_type=='manager')
    
      <button class="btn btn-primary btn-large rightbutton newInvoice">
        <i class="cus-money-dollar"></i>&nbsp;NEW INVOICE
      </button>
     
    @else
      <button class="btn btn-primary btn-large btn-large rightbutton newInvoice tooltwo" title="Click here to create a new Invoice/Payform to submit for payment" style='margin-top:-10px'>
        <i class="cus-money-dollar"></i>&nbsp;CREATE NEW INVOICE
      </button>  
    @endif
		@include('plugins.reportmenu')
    
	</h3>
  <div class="row-fluid well" style="margin-top:30px;padding-top:25px;border-top:1px solid #ddd;border-bottom:1px solid #ddd">
      <form method="get" action="" id="dates" name="dates"/>
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
              @if(Auth::user()->user_type=="manager")
              <div class='span4' style="margin-top:5px;" id="cityname">
                Choose Rep&nbsp;&nbsp;
                    <select class='replist' name='rep' id='rep'>
                      <option value='all'>All</option>
                      @if(!empty($reps))
                      @foreach($reps as $val)
                      <option class='repoption filter-rep-{{$val->user_type}}' data-type='{{$val->user_type}}' value='{{$val->id}}' @if($rep==$val->id) selected='selected' @endif>{{$val->firstname}} {{$val->lastname}}</option>
                      @endforeach
                      @endif
                    </select>
              </div>
              @endif
              <button class="btn btn-default" style="margin-left:20px;margin-top:-6px;">
                <i class="cus-application-view-tile"></i>&nbsp;GENERATE REPORT
              </button>
          </form>
          <div class="clearfix"></div>
          <div class="row-fluid" style="margin-top:40px;">
          <div class="largestats end ">
              <span class="bignum2 BOOK">{{count($invoices)}}</span><br/>
              <h5>TOTAL</h5>
          </div>
       
          <div class="largestats end ">
              <span class="bignum2 DNS2 unpaid-count " ></span><br/>
              <h5>UNPAID</h5>
          </div>

          <div class="largestats end">
              <span class="bignum2 SOLD paid-count"></span><br/>
              <h5>PAID</h5>
          </div>
          <div class="span4">
          <a href='{{URL::to("sales/invoice?allunpaid=true")}}'><button class='btn btn-danger' style="margin-top:15px;">VIEW ALL UNPAID INVOICES</button></a>
          </div>
          <br/>
          @if(Session::has('msg'))
          <span class='label label-important special animated shake'  style='font-size:18px;'>The chosen period contains no valid leads to invoice for this Reggier, Please try another period</span>
          @endif

          @if(Session::has('overlap'))
          <span class='label label-important special animated shake' style='font-size:18px;'>The chosen period overlaps with another period already submitted by this user.</span>
          @endif
          
        </div>

      </div>

    	<div class="well row-fluid dealer-invoices" style='margin-top:35px;'>
        	<div class="row-fluid" style="margin-bottom:20px;">
                        			<div class="span12">
                        				<h4>All DEALER Invoices for chosen period</h5>
                        				<table class="table table-bordered table-condensed weekreport" style="border:1px solid #1f1f1f;color:#000;" >
                        				    <thead style="color:#000!important">
                                        <th style="width:4%;">INV #</th>
                        				        <th style="width:8%;">Dealer</th>
                        				        <th style="width:5%;">Issued</th>
                                        <th style="width:5%;">Paid</th>
                                        <th style="width:6%;">Add</th>
                                        <th style="width:14%;">DEALS ON INVOICE</th>
                        				        <th style="width:6%;">Est. Owing</th>
                                        <th style="width:12%;">Notes</th>
                                        <th>Paid</th>
                                        <th style="width:7%;">Chq #</th>
                        				        <th>Status</th>
                                        <th style="width:20%;">Actions</th>
                        				    </thead>

                        				    <tbody class='marketingstats'>
                          				    @foreach($invoices as $val)
                                      @if(!empty($val->user))
                                      <?php $amt=0; if($val->status=="unpaid"){$st = 'important';} else {$st='success';};?>
                                        <tr data-id="{{$val->id}}" class='filter dealer-filter-{{$val->user_id}} invoicerow {{$val->status}}' id="invoicerow-{{$val->id}}">
                                          <td>{{$val->invoice_no}}</td>
                                           <td>
                                           {{$val->user->firstname}} {{$val->user->lastname}}<br/>
                                           </td>
                                           <td>{{date('Y-m-d',strtotime($val->date_issued))}}</td>
                                           <td id="paiddate-{{$val->id}}">@if($val->date_paid!="0000-00-00")
                                            <span class='small'>{{date('Y-m-d',strtotime($val->date_paid))}}</span>
                                            @else 
                                            <span class='label label-important'>UNPAID</span>
                                            @endif
                                            </td>
                                            <td> 
                                              <center>
                                                <button class='tooltwo btn btn-default btn-small attachDeal' title='Click to add a Sale to this Invoice' data-id='{{$val->id}}'><i class='cus-add'></i> ADD</button>
                                              </center>
                                            </td>
                                           <td id="inv-sales-{{$val->id}}">
                                           
                                            @if(count($val->sale)>0)
                                              @foreach($val->sale as $v)
                                              <?php $amt = $amt+$v->payout;?>
                                                <button id='deal-{{$v->id}}' data-inv='{{$val->id}}' data-paid="{{$v->paid}}" class='btn btn-inverse btn-mini tooltwo removeDeal' title='Click here to remove this deal from invoice' data-id='{{$v->id}}' style="margin-bottom:5px;"><i class=''></i> # {{$v->id}} | {{substr($v->cust_name,0,18)}}.. | {{ucfirst($v->typeofsale)}}</button>
                                              @endforeach
                                            @endif
                                           </td>
                                           <td >
                                            
                                            <span id="payout-{{$val->id}}">
                                            @if($amt==0)
                                              Make sure you have entered Payouts on the deals
                                            @else
                                              @if(Setting::find(1)->invoice_tax==1)
                                               Sub : ${{$amt}} <br/>
                                               <span style='font-size:13px;'>Tax : ${{number_format(floatval($amt)*($tax_rate/100),2,'.','')}}</span>
                                               <b>Total : </b><br/>
                                               $ {{number_format(floatval($amt)+(floatval($amt)*($tax_rate/100)),2,'.','')}}
                                               @else
                                               <b>Total : </b><br/>
                                               $ {{$amt}}
                                               @endif
                                            @endif
                                            </span>
                                          </td>
                                          <td><span class='edit notes-{{$val->id}}' id='notes|{{$val->id}}'> {{$val->notes}} </span></td>
                                          <td><span class='edit amount-{{$val->id}}' id="amount|{{$val->id}}">{{$val->amount}}</span></td>
                                          <td>
                                          <span class='edit cheque_no-{{$val->id}}' id="cheque_no|{{$val->id}}">
                                            @if(!empty($val->cheque_no))
                                            {{$val->cheque_no}}
                                            @endif
                                          </span>
                                         
                                          </td>
                                           <td id="status-{{$val->id}}">
                                            <center>
                                             <span class='label label-{{$st}}'> {{ucfirst($val->status)}}</span>
                                           </center>
                                          </td>
                                           <td>
                                           <center>
                                            @if(Auth::user()->user_type=="manager")
                                            <button class='tooltwo btn btn-success btn-mini markPaid' title='Click to Enter Cheque# and mark this invoice and its consequent sales as PAID' data-id='{{$val->id}}' style='color:#000'><i class=''></i> MARK PAID</button>
                                            @endif
                                            
                                            <a href='{{URL::to("sales/viewinvoice/")}}{{$val->id}}'><button class='btn btn-primary btn-mini' ><i class='cus-eye'></i>VIEW</button></a>
                                            <button class='tooltwo btn btn-danger btn-mini deleteInvoice' title='Click to Delete!' data-id='{{$val->id}}' ><i class=''></i>DELETE</button>
                                          </center>
                                          </td>
                        				        </tr>
                                        @endif
                                        @endforeach
                        				    </tbody>
                        				</table>
                        			</div>
                        		</div>

    	</div>

      @if(Auth::user()->user_type=="manager")
      <div class="well row-fluid door-reggie-invoices" style='margin-top:30px;'>
        

          <div class="row-fluid" style="margin-bottom:40px;">
                              <div class="span12">
                                <h4>All DOOR REGGIE Invoices for chosen period</h5>
                                <table class="table table-bordered table-condensed weekreport" style="border:1px solid #1f1f1f;color:#000;" >
                                    <thead style="color:#000!important">
                                        <th style="width:7%;">Invoice #</th>
                                            <th style="width:10%;">Reggier</th>
                                            <th style="width:9%;">Date Issued</th>
                                            <th style="width:9%;">Date Paid</th>
                                            <th style="width:11%;">TIME PERIOD</th>
                                            <th style="width:6%;">Est. Owing</th>
                                            <th style="width:6%;">Valid</th>
                                            <th style="width:8%;">Invalid / Inactive</th>
                                            <th>Notes</th>
                                            <th>Paid</th>
                                            <th>Chq #</th>
                                            <th style="width:6%;">Status</th>
                                            <th>Actions</th>
                                    </thead>

                                    <tbody class='marketingstats'>
                                      @foreach($doorinvoices as $val)
                                      @if(!empty($val->user))
                                      <?php $amt=0; if($val->status=="unpaid"){$st = 'important';} else {$st='success';};?>
                                        <tr data-id="{{$val->id}}" class='filter dealer-filter-{{$val->user_id}} invoicerow {{$val->status}}' id="invoicerow-{{$val->id}}">
                                          <td>{{$val->invoice_no}}</td>
                                           <td>
                                            {{$val->user->firstname}} {{$val->user->lastname}}<br/>
                                           </td>
                                           <td>{{date('Y-m-d',strtotime($val->date_issued))}}</td>
                                           <td id="paiddate-{{$val->id}}">
                                            @if($val->date_paid!="0000-00-00")
                                            <span class='small'>{{date('Y-m-d',strtotime($val->date_paid))}}</span>
                                            @else 
                                            <span class='label label-important'>UNPAID</span>
                                            @endif
                                            </td>
                                            <td> 
                                              {{date('M-d',strtotime($val->startdate))}} - {{date('M-d',strtotime($val->enddate))}}
                                            </td>
                                            <td>
                                              <center>
                                              $ {{$val->valid*$reggie_rate}}
                                            </center>
                                            </td>
                                           <td ><center>
                                           {{$val->valid}}
                                           </center>
                                           </td>
                                           <td >
                                            <center>
                                             {{$val->invalid}}
                                            </center>
                                          </td>
                                          <td><span class='edit notes-{{$val->id}}' id='notes|{{$val->id}}'> {{$val->notes}} </span></td>
                                          <td><span class='edit amount-{{$val->id}}' id="amount|{{$val->id}}">{{$val->amount}}</span></td>
                                          <td>
                                          <span class='edit cheque_no-{{$val->id}}' id="cheque_no|{{$val->id}}">@if(!empty($val->cheque_no)){{$val->cheque_no}}@endif</span>
                                         
                                          </td>
                                           <td id="status-{{$val->id}}">
                                            <center>
                                             <span class='label label-{{$st}}'> {{ucfirst($val->status)}}</span>
                                            </center>
                                          </td>
                                           <td>
                                           <center>
                                            @if(Auth::user()->user_type=="manager")
                                            <button class='tooltwo btn btn-success btn-mini markPaid' title='Click to Enter Cheque# and mark this invoice and its consequent sales as PAID' data-id='{{$val->id}}' style='color:#000'><i class=''></i> MARK PAID</button>
                                            @endif
                                            
                                            
                                            <button class='tooltwo btn btn-danger btn-mini deleteInvoice' title='Click to Delete!' data-id='{{$val->id}}' ><i class=''></i>DELETE</button>
                                          </center>
                                          </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                              </div>
                            </div>

      </div>

      @endif

      @if(Auth::user()->user_type=="salesrep")
    	<div class='row-fluid'>
        <h3>Your Sales for the chosen period</h3>
        	<table class="table apptable table-condensed"  >
            	<thead>
                  <tr>
                      <th style="width:1%"></th>
                      <th style="width:4%;">Date</th>
                      <th style="width:4%;">SALE #</th>
                      <th>Customer Name</th>
                      <th style="width:7%;"><span class="small">Phone #</span></th>
                      <th>City</th>
                      <th>Payment</th>
                      <th>Funded</th>
                      <th>Status</th>
                      <th>System Type</th>

                      <th style='width:4%;'>DEFENDERS</th>
                      <th style='width:4%;'>MAJESTICS</th>
                      <th style='width:4%;'>ATTACHMENTS</th>

                      <th>Booker</th>
                      <th>Notes</th>
                      <th>Invoice</th>
                      <th>STATUS</th>
                      <th>COMMISSION</th>
                      <th>PRICE</th>
                     
                  </tr>
              </thead>
              <tbody>
              <?php $count=1;?>

               
                  @if(!empty($yoursales))
                    @foreach($yoursales as $v)
                      <?php if(($v->status=="CANCELLED")&&($v->picked_up==1)) {$row = "finishcancel";} else {$row = $v->status;};
                      $items = $v->items;
                      ?>
                    <tr class='{{$row}} ' id='rowid-{{$v->id}}'>
                        <td>{{$count++}}</td>
                        <td><span class="small">{{date('M d',strtotime($v->date))}}</span></td>
                        <td>{{$v->id}}</td>
                        <td><span class="edit" id="cust_name|{{$v->id}}">{{$v->cust_name}}</span></span></td>
                        <td>{{$v->lead->cust_num}}</td>
                        <td><span class="small">{{$v->lead->city}}</span></td>
                        <td>
                          <span class="edit" id="payment|{{$v->id}}">
                          @if(!empty($v->payment))
                          {{$v->payment}} 
                          @endif
                        </span>
                        </td>
                        <td>@if($v->funded==1)
                          <span class='label label-success'>Funded</span>
                          @else
                          <span class='label label-important'>Un-Funded</span>
                          @endif
                          
                        </td>
                        
                        <td id='status-{{$v->id}}'>
                        {{$v->status}}
                        </td>
                        <td >{{ucfirst($v->typeofsale)}}</td>
                        @if(($v->status=="CANCELLED")||($v->status=="TURNDOWN"))
                        @if($v->picked_up==1)

                        <?php $machines = unserialize($v->old_machines);?>
                        <td class='machines' id='def-{{$val->id}}' >
                              <center>
                              @if(!empty($machines['defender']))
                                @foreach($machines['defender'] as $i)
                                <span class='label label-inverse' >{{$i}}</span>
                                @endforeach
                              @endif
                              </center>
                        </td>
                        <td class='machines' id='maj-{{$val->id}}'>
                            <center>
                              @if(!empty($machines['majestic']))
                                @foreach($machines['majestic'] as $i)
                                <span class='label label-inverse' >{{$i}}</span>
                                @endforeach
                              @endif
                            </center>
                        </td>
                        <td class='machines' id='att-{{$val->id}}' >
                            <center>
                             @if(!empty($machines['attachment']))
                                @foreach($machines['attachment'] as $i)
                                <span class='label label-inverse' >{{$i}}</span>
                                @endforeach
                              @endif
                            </center>
                        </td>

                        @else

                        <td class='machines' id='def-{{$val->id}}'>
                            <center>
                            @if(!empty($items))
                                @foreach($items as $i)
                                    @if($i->item_name=="defender")
                                        <span class='label label-important special blackText' id='def-span-{{$val->id}}'>{{$i->sku}}</span>
                                    @endif
                                @endforeach
                            @endif
                            </center>
                        </td>
                        <td class='machines' id='maj-{{$val->id}}'>
                              <center>
                              @if(!empty($items))
                                  @foreach($items as $i)
                                      @if($i->item_name=="majestic")
                                          <span class='label label-important  special blackText' id='maj-span-{{$val->id}}'>{{$i->sku}}</span>
                                      @endif
                                  @endforeach
                              @endif
                              </center>
                        </td>
                        <td class='machines' id='att-{{$val->id}}'>
                              <center>
                              @if(!empty($items))
                                  @foreach($items as $i)
                                      @if($i->item_name=="attachment")
                                          <span class='label label-important  special blackText' id='att-span-{{$val->id}}'>{{$i->sku}}</span>
                                      @endif
                                  @endforeach
                              @endif
                              </center>
                        </td>
                        @endif

                        @else
                        <td class='machines' id='def-{{$val->id}}'>
                            <center>
                            @if(!empty($items))
                                @foreach($items as $i)
                                    @if($i->item_name=="defender")
                                        <span class='label label-info special blackText' id='def-span-{{$val->id}}'>{{$i->sku}}</span>
                                    @endif
                                @endforeach
                            @endif
                            </center>
                        </td>
                        <td class='machines' id='maj-{{$val->id}}'>
                              <center>
                              @if(!empty($items))
                                  @foreach($items as $i)
                                      @if($i->item_name=="majestic")
                                          <span class='label label-info  special blackText' id='maj-span-{{$val->id}}'>{{$i->sku}}</span>
                                      @endif
                                  @endforeach
                              @endif
                              </center>
                        </td>
                        <td class='machines' id='att-{{$val->id}}'>
                              <center>
                              @if(!empty($items))
                                  @foreach($items as $i)
                                      @if($i->item_name=="attachment")
                                          <span class='label label-info  special blackText' id='att-span-{{$val->id}}'>{{$i->sku}}</span>
                                      @endif
                                  @endforeach
                              @endif
                              </center>
                        </td>
                        @endif

                        <td>{{$v->lead->booker_name}}</td>
                        <td><span class="edit" id="comments|{{$v->id}}">{{$v->comments}}</span></td>
                        <td>
                          @if(!empty($v->invoice->invoice_no))
                          <?php if($v->funded==0){$sts='danger';} else {$sts='success';};?>
                            <button class='tooltwo btn btn-{{$sts}} btn-mini'  title='Click to highlight invoice above' ><i class='cus-eye'></i>{{$v->invoice->invoice_no}}</button>
                          @else
                          <span class='tooltwo' title='Dealer has not submitted an invoice yet'>n/a</span>
                          @endif
                        </td>
                        <td>
                          <center>
                          @if($v->paid==1) <span class='label label-success'>PAID</span> @else 
                          <span class='label label-important'>UNPAID</span>
                          @endif</td>
                           <td>
                             <center>
                         @if(!empty($v->payout)){{number_format($v->payout,2,'.','')}}@endif
                        </center>
                        </td>
                        <td>
                          <center>
                         @if(!empty($v->price)){{number_format($v->price,2,'.','')}}@endif
                        </center>
                        </td>
                    </tr>
                    @endforeach
                  @endif
              </tbody>
        	</table>
    	</div>
      @endif
</div>
<div class="push"></div>



<script>
$(document).ready(function(){
var options = $('#selectdeal-1 option').clone();


$('.edit').editable('{{URL::to("sales/editinvoice")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         width:'100',
         height:'20',
         submit  : 'OK',
});


function checkDeals(){
  var t = $('#hasnodeals').val();
if(t==="false"){
  alert('You have no FUNDED deals\n\n You cannot create an Invoice, until you have a funded deal available!');
} else {
  return true;
}
}

$('.replist').change(function(){
  var type = $(this).find(':selected').data('type');
  repid = $(this).val();
  var tempOptions = options;
  var opt = [];
  opt.push("<option value=''></option>");
tempOptions.each(function(i,val){
  var t = $(this).data('user');
  var ra = $(this).data('ridealong');

 if(t==repid || ra == repid){
  opt.push($(this));
 }
});

$('.selectdeal').empty();
$('.selectdeal').html(opt);
$('.filter').hide();
$('.dealer-filter-'+repid).show();

$('.newinvoice-form').hide();
$('.'+type+'-form').show();
});


 $('.view-invoices').click(function(){
          var type = $(this).data('type');
          $('.repoption').hide();
          $('.filter-rep-'+type).show();
          $('.door-reggie-invoices').toggle();
          $('.dealer-invoices').toggle();
        });

$('.newInvoice').click(function(){
if(checkDeals()){
   $('#newinvoice').modal({backdrop: 'static'});
};
});

$('.markPaid').click(function(){
var id = $(this).data('id');
$('#inv-id').val(id);
$('#markpaid').modal({backdrop: 'static'});
});

$('.markaspaid').click(function(){
  var inv = $('#inv-id').val();
  var chq = $('#cheque_no').val();
  var amt = $('#amount').val();
  var not = $('#notes').val();
  $.getJSON('{{URL::to('sales/markpaid')}}',{invoice:inv,cheque:chq,amount:amt,notes:not},function(data){
  if(data=="failed"){
      toastr.error('You failed to fill out an amount, or some other error occured','Mark as Paid Failed!');
    } else {
      console.log(data);
      $('#paiddate-'+inv).html('<span class="small">'+data.date_paid+'</span>');
      $('.cheque_no-'+inv).html(data.cheque_no);
      $('#status-'+inv).html("<center><span class='label label-success'>Paid</span></center>");

      var t = $('#inv-sales-'+inv).find('button');
      $.each(t,function(i,val){
        $(this).data('paid',1);
      });
      $('#invoicerow-'+inv).addClass('paid');
      $('.amount-'+inv).html(data.amount);
      $('.notes-'+inv).html(data.notes);
      $('#markpaid').modal('hide');
       updateCount();
    }
      
  });
 
});

$('.attachDeal').click(function(){
if(checkDeals()){
var id = $(this).data('id');
$('#attach-invoice-id').val(id);
$('#attachdeal').modal({backdrop: 'static'});
}
});

$(document).on('click','.removeDeal',function(){
 var paid = $(this).data('paid');
  if(paid==0){

  var t = confirm("Are you sure you want to remove this deal??");
  if(t){
      var id = $(this).data('id');
      var inv = $(this).data('inv');
    $.getJSON('{{URL::to('sales/removedeal')}}',{thesale:id},function(data){
    if(data!="failed"){
    $("#attach-thesale").prepend('<option value='+data.id+'>SALE#: '+data.id+' | '+data.cust_name+' | '+data.typeofsale+' | '+data.sold_by+'</option>');
      $('#deal-'+id).remove();
      var or_payout = $('#payout-'+inv).html();
      var t = isNaN(or_payout);
      if(t){
        or_payout = 0;
      }

      payout = parseInt(or_payout)-parseInt(data.payout);
      $('#payout-'+inv).html(payout);
      toastr.success('Removed deal from invoice successfully!', 'DEAL REMOVED!');
      updateCount();
    }
    });
    } 
    } else {
    alert('Cannot remove a sale from a paid invoice!!');
  }
});

$('#submitDeal').click(function(){
  var inv = $('#attach-invoice-id').val();
  var id = $('#attach-thesale').val();
  $.getJSON('{{URL::to('sales/attachdeal')}}',{thesale:id,invoiceid:inv},function(data){
    if(data=="failed"){
      alert('This deal is already attached to a sale!!');
      toastr.error('Failed!','Failed to add deal!');
    } else {
      html ="";
      html+="&nbsp;&nbsp;<button id='deal-"+data.id+"' data-inv='"+inv+"' data-id='"+data.id+"' data-paid='"+data.paid+"' class='btn btn-inverse btn-mini tooltwo removeDeal' title='Click here to remove this deal from invoice'><i class=''></i> "+data.cust_name+" - "+data.typeofsale+"</button>";
      $('#inv-sales-'+inv).append(html);
      var or_payout = $('#payout-'+inv).html();
      var t = isNaN(or_payout);
      if(t){
        or_payout = 0;
      }

      payout = parseInt(or_payout)+parseInt(data.payout);
      $('#payout-'+inv).html(payout);
      $("#attach-thesale option[value='"+id+"']").remove();
      $('#attachdeal').modal('hide');
      toastr.success('Deal added to this invoice','DEAL ADDED SUCCESSFULLY');
       updateCount();
   }
  });
});

$('.deleteInvoice').click(function(){
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

function updateCount(){
var paytotal = 0;
 var unpaid=0; var paid=0;var paidtotal=0;var unpaidtotal=0;
      $('.invoicerow').each(function(i,val){
  var id = $(this).data('id');
  var pay = $('#payout-'+id).html();
  if(isNaN(pay)){
  pay = 0;

  } 
  if($(this).hasClass('unpaid')){
  unpaid++;
  unpaidtotal = parseInt(pay)+parseInt(unpaidtotal);
} else {
  paid++;
  paidtotal = parseInt(pay)+parseInt(paidtotal);
}
});

$('.paid-count').html("$"+paidtotal);
$('.unpaid-count').html("$"+unpaidtotal);

}

updateCount();

});
</script>

@endsection