@layout('layouts/main')
@section('content')

<script>
function showUploadForm(){
$('#leadbatch').toggle(400);
}
</script>
<style>
#addnewagent {display:none;}
#leadbatch {display:none;}
#assignleads {display:none;}
#bookerleads{display:none;}
.leadrow{cursor:pointer;}
#release{display:none;}
.sendleads{cursor:pointer;border:3px solid #1f1f1f;padding:6px;font-size:14px;border-radius:7px;}
.sendleads:hover{background: #9dd53a;
background: -moz-linear-gradient(top,  #9dd53a 0%, #a1d54f 50%, #80c217 51%, #7cbc0a 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#9dd53a), color-stop(50%,#a1d54f), color-stop(51%,#80c217), color-stop(100%,#7cbc0a)); 
background: -webkit-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%);
background: -o-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); 
background: -ms-linear-gradient(top,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%); 
background: linear-gradient(to bottom,  #9dd53a 0%,#a1d54f 50%,#80c217 51%,#7cbc0a 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9dd53a', endColorstr='#7cbc0a',GradientType=0 ); 
color:#000;}
td select{width:65%!important;margin-right:10px;}
.noneavailable{display:none;}

.unreleased{padding:6px;background: #a90329; /* Old browsers */
background: -moz-linear-gradient(top,  #a90329 0%, #8f0222 44%, #6d0019 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#a90329), color-stop(44%,#8f0222), color-stop(100%,#6d0019)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #a90329 0%,#8f0222 44%,#6d0019 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #a90329 0%,#8f0222 44%,#6d0019 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #a90329 0%,#8f0222 44%,#6d0019 100%); /* IE10+ */
background: linear-gradient(to bottom,  #a90329 0%,#8f0222 44%,#6d0019 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a90329', endColorstr='#6d0019',GradientType=0 ); /* IE6-9 */
color:#fff!important;font-size:13px;border:1px solid #1f1f1f;}
.unreleased:hover {
background: #b7deed; /* Old browsers */
background: -moz-linear-gradient(top,  #b7deed 0%, #71ceef 50%, #21b4e2 51%, #b7deed 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b7deed), color-stop(50%,#71ceef), color-stop(51%,#21b4e2), color-stop(100%,#b7deed)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* IE10+ */
background: linear-gradient(to bottom,  #b7deed 0%,#71ceef 50%,#21b4e2 51%,#b7deed 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b7deed', endColorstr='#b7deed',GradientType=0 ); /* IE6-9 */
color:#000!important;cursor:pointer;}
.leadtable {margin-top:10px;border:1px solid #bbb;}
.leadtable th{font-size:11px;text-align:center;background:#eee;color:#000!important;border:1px solid #bbb;}
.leadtable td {border:1px solid #bbb;padding:7px;}
</style>
      

<div id="main" role="main" class="container-fluid">
    	<div class="contained">
        	<aside> 
            	@render('layouts.managernav')
        	</aside>
          <div id="page-content" style="padding-bottom:50px;">
            <h2>Available Leads from <font style='color:#000;'>{{$city}}</font>

                <button class="btn btn-small btn-success large filter" data-type='all' style="float:right;margin-top:10px;margin-right:10px;">
                 SHOW ALL<br>
                </button>
                <button class="btn btn-small btn-default btn-large filter" data-type='rebook' style="float:right;margin-top:10px;margin-right:10px;">
                  <i class="cus-arrow-redo"></i>&nbsp;&nbsp; REBOOKS<br>
                </button>
                <button class="btn btn-small btn-default btn-large filter" data-type='ballot' style="float:right;margin-top:10px;margin-right:10px;">
                  <i class="cus-script"></i>&nbsp;&nbsp; BALLOT BOX<br>
                </button>
                <button class="btn btn-small btn-default btn-large filter" data-type='paper' style="float:right;margin-top:10px;margin-right:10px;">
                  <i class="cus-script"></i>&nbsp;&nbsp; PAPER LEADS<br>
                </button>
                <button class="btn btn-small btn-default btn-large filter" data-type='door' style="float:right;margin-top:10px;margin-right:10px;">
                  <i class="cus-door"></i>&nbsp;&nbsp; DOOR LEADS<br>
                </button>
               <span style='float:right;font-size:14px;margin-top:5px;margin-right:10px;'>FILTER BY LEADTYPE: </span>
            </h1>
            <div class='row-fluid'><h5>This list shows the leads in the order that they would get assigned to the marketers. </h5></div>
            <div class="row-fluid">

					   @if(!empty($leads))
              <article class="span12">
						  <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false"  >
						    <header>
							     <h2>Lead List</h2>                           
						    </header>
						  <div>
							<div class="inner-spacer widget-content-padding"> 
								<table class="table table-bordered responsive" id="dtable2">
                  <thead>
                    <tr align="center">
    									<th>Entry Date</th>
    									<th>Entered By</th>
                      <th>LEADTYPE</th> 
											<th class="span2">Customer<br />Phone Number</th>
											<th>Customer<br />Name</th>
											<th>City</th>
											<th>CALLED</th>
											<th>STATUS</th>
                      <th>ACTIONS</th> 
                    </tr>
                  </thead>
                  <tbody id="bookerleaddata">
                  @foreach($leads as $val2)
									<?php if($val2->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
														if($val2->status=="APP"){$label="success";$msg = "DEMO BOOKED!";}
														elseif($val2->status=="SOLD"){$label="success";$msg = " $$ SOLD $$";}
	           												elseif($val2->status=="ASSIGNED"){$label="info";$msg = "ASSIGNED TO CALL";} 
            												elseif($val2->status=="NH") {$label="inverse";$msg = "NOT HOME";} 
            												elseif($val2->status=="DNC") {$label="important";$msg = "DO NOT CALL!";}
            												elseif($val2->status=="NI") {$label="important";$msg = "NOT INTERESTED";}
           													elseif($val2->status=="Recall") {$label="warning";$msg = "RECALL";} 
           													elseif($val2->status=="NQ") {$label="important";$msg = "NOT QUALIFIED";} 
           													elseif($val2->status=="WrongNumber"){$label="warning";$msg="Wrong Number";} 
           													elseif($val2->status=="NEW"){$label="success";$msg="AVAILABLE";} 
           													else{$label="";$msg="";}
                                    if($val2->leadtype=="rebook"){$label="warning";$msg="AVAILABLE";}  ?>
           				<tr id='agentrow-{{$val2->id}}' class="{{$shadow}} {{$val2->status}} {{$val2->leadtype}} leadrow" style='color:{{$color}}'>
										<td>{{date('M-d Y', strtotime($val2->entry_date))}}</td>
										<td>{{strtoupper($val2->researcher_name)}}</td>
										<td>
                      <center>
                        <span class='label label-{{$label}} special boxshadow' style="color:#000;">{{strtoupper($val2->leadtype)}}</span>
                      </center>
                    </td>
										<td class="span2">{{$val2->cust_num}}</td>
										<td><center>{{$val2->cust_name}}</center></td>
										<td>{{$val2->city}}</td>
										@if($val2->assign_count>0)
										<td>
											<center>
												<span class='label label-success boxshadow'>CALLED {{$val2->assign_count}} TIMES</span>
											</center>
									  </td>
										@else
										<td><center><span class='label label-inverse boxshadow'>No Contact</span></center></td>
										@endif
										<td>
											<center>
												<span class='label label-{{$label}} special boxshadow' style='color:#000;'>{{$msg}}</span>
											</center>
										</td>
                    <td><center>
                      <a href="{{URL::to('lead/newlead')}}/{{$val2->cust_num}}"><button class="btn btn-primary btn-small"><i class='cus-pencil'></i> &nbsp; EDIT</button></a>&nbsp;&nbsp;<button class="btn btn-danger btn-small deletelead" data-id="{{$val2->id}}">X</button></center> 
                    </td>
                  </tr>
									@endforeach
                </tbody>
                </table>
							</div>
						</div>
					</article>
					@endif
				</div>
			</div>
            </section>
                        <!-- end widget grid -->
      </div>    
      <aside class="right">
            @render('layouts.chat')
                 
      </aside>  
            
</div>
                <!-- end main content -->
            </div>
                   
        </div><!--end fluid-container-->
        <div class="push"></div>
    </div>

    <?php $arr=array();?>

    <?php foreach($bookers as $val){
    	$arr[$val->id] = $val->firstname." ".$val->lastname;
    };?>
<script src="{{URL::to_asset('js/editable.js')}}"></script>

<script>
$(document).ready(function(){
$('#leadmenu').addClass('expanded');

$('.filter').click(function(){
  var leadtype = $(this).data('type');
  if(leadtype=='all'){
    $('.leadrow').show();
  } else {
$('.leadrow').hide();
$('.'+leadtype).show();}
});


$('#dtable2').dataTable({
            // define table layout
            "sDom" : "<'row-fluid dt-header'<'span6'f><'span6 hidden-phone'T>r>t<'row-fluid dt-footer'<'span6 visible-desktop'i><'span6'p>>",
            // add paging 
            "sPaginationType" : "bootstrap",
            "oLanguage" : {
                "sLengthMenu" : "Showing: 25",
                "sSearch": "" 
            },
            "aaSorting": [],
            "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
            "iDisplayLength":25,
            "oTableTools": {
                "sSwfPath": "../js/include/assets/DT/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sButtonText": '<i class="cus-doc-excel-table oTable-adjust"></i>'+" BACKUP TO EXCEL"
                    }
                ]
            }
        }); 


$('.sendleads').editable('{{URL::to("lead/assignleads")}}',{
	data : '<?php echo  json_encode($arr);?>',
	type:'select',
	submit:'OK',
    	indicator : 'Assigning...',
    	tooltip: 'Click to Assign',
    	width:'40',
    	callback: function(value, settings){
    		console.log(value);
    		//window.location.reload(true);
    	}
});


$('.release').click(function(){
$('#release').toggle(300);
});

$('.deletelead').click(function(){
    var id=$(this).data('id');
    if(confirm("Are you sure you want to delete this lead?")){
        var url = "../lead/delete/"+id;
            $.getJSON(url, function(data) {
             $('#agentrow-'+id).hide(200);
             toastr.success('Lead Sucessfully Removed', 'Lead Deleted');
            });
    }
});
});
</script>
@endsection