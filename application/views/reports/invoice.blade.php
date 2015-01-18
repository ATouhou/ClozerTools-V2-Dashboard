@layout('layouts/main')
@section('content')
<style>

table.apptable td select{width:80px;}
.CANCELLED {background:#bbb!important;}
.TURNDOWN{
	background:#ccc!important;
}

.PAID {
	background: #e4efc0; /* Old browsers */
background: -moz-linear-gradient(top,  #e4efc0 0%, #7b9b5e 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e4efc0), color-stop(100%,#7b9b5e)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #e4efc0 0%,#7b9b5e 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #e4efc0 0%,#7b9b5e 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #e4efc0 0%,#7b9b5e 100%); /* IE10+ */
background: linear-gradient(to bottom,  #e4efc0 0%,#7b9b5e 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e4efc0', endColorstr='#7b9b5e',GradientType=0 ); /* IE6-9 */

	
}
.COMPLETE{
	background: #c9de96; /* Old browsers */
background: -moz-linear-gradient(top,  #c9de96 0%, #8ab66b 44%, #398235 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#c9de96), color-stop(44%,#8ab66b), color-stop(100%,#398235)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #c9de96 0%,#8ab66b 44%,#398235 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #c9de96 0%,#8ab66b 44%,#398235 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #c9de96 0%,#8ab66b 44%,#398235 100%); /* IE10+ */
background: linear-gradient(to bottom,  #c9de96 0%,#8ab66b 44%,#398235 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c9de96', endColorstr='#398235',GradientType=0 ); /* IE6-9 */

}
.removeItem {cursor:pointer}
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
.processapp{width:90%!important;}
.bignum3{font-size:12px;padding:5px;}
div.jGrowl.myposition {position: absolute;font-size:200%;margin-left:150px;top: 20%;}
.edit {width:100%;height:10px;}
.rightbutton{float:right;margin-top:10px;margin-right:10px;}
.bigfont{font-size:20px;padding:6px;color :#000!important;}
.weekreport {}
.weekreport th{text-align:center;background:#1f1f1f;color:#fff;}
.weekreport td {padding:10px;}
</style>

<?php if(isset($_GET['city'])) {$city = $_GET['city'];} else {$city='all';};?>
<div class="modal hide fade" id="upload_doc">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Upload New Document</h3>
	</div>
	<div class="modal-body">
		<form method="POST" action="{{ URL::to('sales/uploadfile') }}" id="upload_doc_form" enctype="multipart/form-data">
			<label for="File">Upload File</label>
			<input type="hidden" id="theID" name="theID"/>
			<input type="hidden" id="leadID" name="leadID"/>
	        <input type="file" placeholder="Choose a document to upload" name="theDoc" id="theDoc" /><br/><br/>
	        <label for="File">Enter Optional Name </label><span class='small'>(if empty, filename will be used as the name)</span><br/>
	        <input type="text" placeholder="Alternative Name" name="theName" id="theName" /><br>
	        <label for="Notes">Optional Notes : </label>
	        <textarea name="theNotes" id="theNotes" ></textarea>
			
	    </form>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
    	<button type="button" onclick="$('#upload_doc_form').submit();" class="btn btn-primary">Upload New Document</a>
	</div>
</div>

<div class="modal hide fade" id="viewfiles_doc">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>All Files For Sale <span class='sale_id'></span></h3>
	</div>
	<input type="hidden" id="imageCount" name="imageCount" value=""/>
	<div class="modal-body" id="viewfiles_body">
		
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">CLOSE</a>
    	
	</div>
</div>
<div id="main"  class="container-fluid lightPaperBack" style="min-height:1000px;padding:45px;padding-top:30px;padding-bottom:800px;">
	
    	@include('plugins.reportmenu')

    	<div class="well row-fluid">
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
            	<div class='span4' style="margin-top:5px;" id="cityname">
            		Choose City&nbsp;&nbsp;
                		<select name='city' id='city'>
                			<option value='all'>All</option>
                			@if(!empty($cities))
                			@foreach($cities as $val)
                			<option value='{{$val->cityname}}' @if($city==$val->cityname) selected='selected' @endif>{{$val->cityname}}</option>
                			@endforeach
                			@endif
                		</select>
            	</div>
            	<button class="btn btn-default" style="margin-left:20px;margin-top:-6px;">
            		<i class="cus-application-view-tile"></i>&nbsp;GENERATE REPORT
            	</button>
        	</form>

        	<div class="row-fluid" style="margin-bottom:40px;">
                        			<div class="span12">
                        				<h4>Week Report By Dealer for {{$title}}</h5>
                        				<table class="table table-bordered table-condensed weekreport" style="border:1px solid #1f1f1f;" >
                        				    <thead style="color:#000!important">
                        				        <th>Associate</th>
                        				        <th>Unpaid Sales</th>
                        				        <th>Paid Sales</th>
                        				        <th>Invoices</th>
                        				        
                        				    </thead>

                        				    <tbody class='marketingstats'>
                        				    	<tr class=''>
                                                    <td></td><td></td><td></td><td></td>
                        				        </tr>
                        				      
                        				        
                        				    </tbody>
                        				</table>
                        			</div>
                        		</div>

    	</div>

    	<div class='row-fluid'>
        	<table class="table apptable table-condensed" id="dtable2">
            	<thead>
            	    <tr>
            	        <th style="width:1%"></th>
            	        <th style="width:4%;">Date</th>
                        <th>Submitted By</th>
            	        <th>Invoice #</th>
            	        <th>Sales</th>
            	        <th>Amount</th>
            	        <th>Status</th>
            	    </tr>
            	</thead>
            	<tbody>
            	<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            	</tbody>
        	</table>
    	</div>

    
    	<div class="row-fluid" style="margin-top:90px;padding-top:25px;border-top:1px solid #ddd;border-bottom:1px solid #ddd">
        	<div class="span3">
        	<div class="largestats end ">
            	<span class="bignum2 BOOK"></span><br/>
            	<h5>Booked</h5>
        	</div>
        	<div class="largestats end ">
        	    <span class="bignum2 PUTON"></span><br/>
        	    <h5>Puton</h5>
        	</div>
        	<div class="largestats end ">
        	    <span class="bignum2 DNS2"></span><br/>
        	    <h5>DNS</h5>
        	</div>
        	<div class="largestats end">
        	    <span class="bignum2 RECALL"></span><br/>
        	    <h5>NQ</h5>
        	</div>
        	<div class="largestats end">
        	    <span class="bignum2 SOLD"></span><br/>
        	    <h5>SOLD</h5>
        	</div>
        	<div class="guagechart" style="width:170px;height:100px;float:left;margin-left:40px;">
        	    <canvas id="teamsalesweek" data-value="" style="width:93%;"></canvas>
        	</div>
        	<br/>
        	<span class="badge badge-success special" style="font-size:25px;padding:10px;"><span id="month-sales"></span>&nbsp;%</span><br/>
        	Closing Average
        	
    	</div>
    </div>
    

</div>
<div class="push"></div>
<!--PAGE SCRIPTS-->
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script src="{{URL::to_asset('js/highcharts.js')}}"></script>
<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>
<script>
function getguageslim(gval, element, max, textfield){
var opts = {
  lines: 12, 
  angle: 0,
  lineWidth: 0.27, 
  pointer: {
    length: 1, 
    strokeWidth: 0.064, 
    color: '#000000'
  },
  limitMax: 'true',   
  colorStart: '#002906',  
  colorStop: '#00DA41',    
  strokeColor: '#E0E0E0',  
  generateGradient: true
};
var target = document.getElementById(element); 
var gauge = new Gauge(target).setOptions(opts); 
gauge.maxValue = max; 
gauge.animationSpeed = 32; 
gauge.set(gval); 
gauge.setTextField(document.getElementById(textfield));
}
</script>

<script>
$(document).ready(function(){

$('.uploadDoc').click(function(){
var id = $(this).data('id');
var lid = $(this).data('lid');
$('#theID').val(id);
$('#leadID').val(lid);
$('#upload_doc').modal({backdrop: 'static'});
});

$('.viewDoc').click(function(){
var id = $(this).data('id');
var name = $(this).data('name');
var type = $(this).data('type');

	$.getJSON('../sales/viewdocs/'+id,function(data){
		html = "";
		$('.sale_id').html("#"+id+" - "+name+" ( Purchased : "+type+")");
			$.each(data,function(i,val){
				var d = val.attributes;
				html+="<div class='span1 imagebox' id='doc-"+d.id+"'>";
				html+="<img src='https://s3.amazonaws.com/salesdash/"+d.uri+"' width=80px /><br/><span class='small'>"+d.filename+"</span>";
				html+="<br/><a class='btn btn-primary btn-mini' href='https://s3.amazonaws.com/salesdash/"+d.uri+"' target=_blank>&nbsp;VIEW</a>&nbsp;&nbsp;<div class='btn btn-danger btn-mini delImage' data-id='"+d.id+"'>X</div></div>";
			});
		$('#viewfiles_doc').modal({backdrop: 'static'});
		$('#viewfiles_body').html(html);
	});
	
});


$('body').on('click','.delImage',function(data){
var t = confirm('Are you sure you want to delete this file???');
	if(t){
		var id = $(this).data('id');
		$.get('../sales/delDocument/'+id, function(data){
				if(data=="success"){
					$('#doc-'+id).remove();
					toastr.success('File Removed','DELETE SUCCESFUL');
				} else if(data=="notauth") {
					toastr.warning('You cannot delete a file you didnt upload','ERROR!');
				} else if(data=="failed") {
					toastr.error('Deleting file failed!','FAILED TO REMOVE FILE');
				}
			if($('#viewfiles_body').children().size()==0){
				$('#viewfiles_doc').modal('hide');}
		});
	}
});


var weekval = $('#teamsalesweek').data('value');
getguageslim(weekval, 'teamsalesweek', 100,'month-sales');

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
            "iDisplayLength":500,
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




	
	$('.editinv').editable('{{URL::to("sales/additem")}}', {
  		data: function(value, settings){
  			rep = $(this).data('rep');
     			machine = $(this).data('type');
     			id = $(this).data('id');
  			$.ajax({
  				url:'../inventory/getmachinelist',
  				type:'get',
  				dataType: 'json',
  				async:false,
  				data: {rep:rep,type:machine},
  				success: function(data){
  				result = data;
     				}
     			});
     			return result;
  		},
     		type    : 'select',
     		submit  : 'OK',
     		width : '40',
     		callback : function(value, settings) {
         	replaceRow(id);
     		}
 	});

 	function replaceRow(id){
 	var html = "";
 		$.getJSON('../sales/getsalerow/'+id, function(data){
 			console.log(data);
 			var d = data;
 			var mach1, mach2;
 			var defone1 = d.defone;
 			var deftwo1=d.deftwo;
 			var att1 = d.att;
 			var maj1 = d.maj;
 			if((d.status=='CANCELLED')||(d.status=='TURNDOWN')){

 			if(d.pickedup==0){
 			mach1 = "<center><span class='label label-important'>";
 			mach2 = "</span></a></center>  ";
 			$('tr#rowid-'+d.id).removeClass().addClass(d.status);
			$('#pickup-'+id).html("<a class='btn bordbut btn btn-mini btn-success pickupSale' data-id='"+d.id+"' style='color:#000;'>RETURN</a>");
 			} else {
 			$('#status-'+id).html(d.status);
 			$('#pickup-'+id).html("");
 			$('tr#rowid-'+d.id).removeClass().addClass('finishcancel');
 			mach1 = "<center><span class='label'>";
 			mach2 = "</span></a></center>  ";
			} 
			} else {
			$('#pickup-'+id).html("");
			if((d.status=="PAID")||(d.status=="COMPLETED")){
				$('tr#rowid-'+d.id).removeClass().addClass(d.status);
			} else {
				$('tr#rowid-'+d.id).removeClass();
			}
			
			mach1 = "<center><span class='bordbut label label-info special'>";
 			mach2 = "</span></a></center>  ";
 			d.maj = "<span class='removeItem' data-id='"+d.majsku+"' data-type='maj' data-sale='"+d.id+"'>"+d.maj+"</a>";
 			d.defone = "<span class='removeItem' data-id='"+d.defonesku+"' data-type='defone' data-sale='"+d.id+"'>"+d.defone+"</a>";
 			d.deftwo = "<span class='removeItem' data-id='"+d.deftwosku+"' data-type='deftwo' data-sale='"+d.id+"'>"+d.deftwo+"</a>";
 			d.att = "<span class='removeItem' data-id='"+d.attsku+"' data-type='att' data-sale='"+d.id+"'>"+d.att+"</a>";
			}

 			

 			if(maj1!=0){
 			$('#maj-'+id).html(mach1+d.maj+mach2);}
 			if(att1!=0){
 			$('#att-'+id).html(mach1+d.att+mach2);}
 			if(defone1!=0){
 			$('#defone-'+id).html(mach1+d.defone+mach2);}
 			if(deftwo1!=0){
 			$('#deftwo-'+id).html(mach1+d.deftwo+mach2);}


 		});

 	}

 	$('body').on('click','.pickupSale',function(data){
 	var id = $(this).data('id');
 		$.get('../sales/pickupsale/'+id, function(data){
 			replaceRow(id);
 		});
 	});

 	$('body').on('click','.removeItem',function(data){
 		var id = $(this).data('id');
 		var sid = $(this).data('sale');
 		var type = $(this).data('type');
 		$.get('../sales/removeitem/'+id+'-'+type,function(data){
 		console.log(data);
 		if(data=="failed"){
 			toastr.error("Failed to remove item","FAILED");
 		} else if(data=="success"){
 			location.reload();
  		}
 			
 		});
 	});

	$('.edit').editable('{{URL::to("sales/edit")}}',{
		submit:'OK',
    		indicator : 'Saving...',
    		tooltip: 'Enter Data',
    		width:'100px',
    		placeholder:".................."
	});

	$('.statusedit').editable('{{URL::to("sales/edit")}}',{
		data : '{"APPROVAL":"Waiting Approval","APP A":"App A","APP B":"App B","APP C":"App C","APP E":"App E","COMPLETE":"Complete","PAID":"Paid","CANCELLED":"Cancelled","TURNDOWN":"Turndown","RETURN":"Return"}',
		type:'select',
		submit:'OK',
    		indicator : 'Saving...',
    		tooltip: 'Enter Data',
    		placeholder:"..................",
    		callback : function(value, settings) {
         	replaceRow($(this).data('id'));
     }
    	});

	$('.systemedit').editable('{{URL::to("sales/edit")}}',{
		data : '{"defender":"Defender","majestic":"Majestic","system":"System","supersystem":"Super System","megasystem":"Mega System"}',
		type: 'select',
		submit:'OK',
		indicator: 'saving',
		tooltip: 'Select',
		callback: function(value, settings){
		location.reload();
	}
	});

	$('.markpaid').click(function(){
		var id = $(this).data('id');
		if($(this).is(":checked")){
		var value=1;
	} else {
	var value=0;
	}
		$.get('{{URL::to("sales/edit")}}',{id:id,value:value},function(data){
		if(data==1) toastr.success('Sale marked as paid','MARKED AS PAID');
		});
		
	});




});
</script>

@endsection