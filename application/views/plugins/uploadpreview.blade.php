@layout('layouts/main')
@section('content')

<style>
.previewTable {
	font-size:22px!important;
	margin:0px;padding:0px;
	width:100%;
	box-shadow: 10px 10px 5px #888888;
	border:1px solid #000000;
	
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
	
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
	
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
	
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}.previewTable table{
    border-collapse: collapse;
        border-spacing: 0;
	width:100%;
	height:100%;
	margin:0px;padding:0px;
}.previewTable tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.previewTable table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.previewTable table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.previewTable tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.previewTable tr:hover td{
	
}
.previewTable tr:nth-child(odd){ background-color:#d6d6d6; }
.previewTable tr:nth-child(even)    { background-color:#ffffff; }.previewTable td{
	vertical-align:middle;
	
	
	border:1px solid #000000;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:2px;
	font-size:13px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.previewTable tr:last-child td{
	border-width:0px 1px 0px 0px;
}.previewTable tr td:last-child{
	border-width:0px 0px 1px 0px;
}.previewTable tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.previewTable tr.header td{
		background:-o-linear-gradient(bottom, #666666 5%, #666666 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #666666), color-stop(1, #666666) );
	background:-moz-linear-gradient( center top, #666666 5%, #666666 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#666666", endColorstr="#666666");	background: -o-linear-gradient(top,#666666,666666);

	background-color:#666666;
	border:0px solid #000000;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:15px;
	font-family:Arial;
	font-weight:bold;
	color:#ffffff;
}

.previewTable tr.header2 td{
	
	background-color:#3e3e3e;
	border:0px solid #000000;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:14px;
	font-family:Arial;

	color:#ffffff;
}
.previewTable tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #666666 5%, #666666 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #666666), color-stop(1, #666666) );
	background:-moz-linear-gradient( center top, #666666 5%, #666666 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#666666", endColorstr="#666666");	background: -o-linear-gradient(top,#666666,666666);

	background-color:#666666;
}
.previewTable tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.previewTable tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}


body {font-family:Arial;
font-size:30px;
}
</style>

<div style="background:white;height:1500px;width:98%;margin:0 auto;padding:25px;">

@if(empty($columns))

<center>
<h1>You have not attached a file! Or the file is Empty / Not Valid</h1>
</center>
@else
<h2>XLS Upload Preview</h2>
<h3>
This preview layout should match the excel file you're trying to upload
</h3>
<?php $arrColumns = array(0=>'A',1=>'B',2=>'C',3=>'D',4=>'E',5=>'F',6=>'G',7=>'H',8=>'I',9=>'J',10=>'K',11=>'L',12=>'M',13=>'N',14=>'O',15=>'P',16=>'Q',17=>'R',18=>'S',19=>'T',20=>'U',21=>'V',22=>'W',23=>'X',24=>'Y',25=>'Z',26=>'AA',27=>'AB',28=>'AC',29=>'AD',30=>'AE',31=>'AF',32=>'AG',33=>'AH',34=>'AI',35=>'AJ',36=>'AK',37=>'AL',38=>'AM',39=>'AN',40=>'AO',41=>'AP',42=>'AQ',43=>'AR',44=>'AS',45=>'AT',46=>'AU',47=>'AV',48=>'AW',49=>'AX',50=>'AY',51=>'AZ',52=>'BA',53=>'BB',54=>'BC',55=>'BD',56=>'BE',57=>'BF',58=>'BG',59=>'BH',60=>'BI',61=>'BJ',62=>'BK',63=>'BL',64=>'BM',65=>'BN',66=>'BO',67=>'BP',68=>'BQ',69=>'BR',70=>'BS',71=>'BT',72=>'BU',73=>'BV',74=>'BW',75=>'BX',76=>'BY',77=>'BZ');
        
        ?>
<p style="font-size:17px;"> Uploaded By : {{Auth::user()->fullName()}}<br/>
     Preview Date : {{date('Y-m-d H:i:s')}}<br/>
     @if(!empty($info))
     Survey Date : {{$info["survey_date"]}}<br/>
     Leadtype : {{$info["leadtype"]}}<br/>
     @endif

</p>
<h5>
<table class='previewTable'>
		<tr class='header'>
			@foreach($columns as $k=>$v)
			<td>Column {{ucfirst($arrColumns[$k])}}</td>
			@endforeach
		</tr>
		<tr class='header2'>
			@foreach($columns as $v)
			<td>
			<?php if (strpos($v,'skipempty') !== false){
				echo "Skipped / Unused";
			} else {
				echo ucfirst($v);
			};?>

			</td>
			@endforeach
		</tr>
		@foreach($leads as $v)
		<tr>
			@foreach($columns as $j=>$c)
			<td>  <?php 
			
				if($c=="CustomerName"){
					echo $v['cust_name'];
					$theCol = $arrColumns[$j];
				} else if($c=="OptionalLastName"){
					echo "Last Name Moved to Col ".$theCol;
				}  else {
					if(isset($v[$c])){
						echo $v[$c];
					}
				};
				?>
			</td>
			@endforeach			
		</tr>
		@endforeach
</table>

<center>
	<br/><br/><br/>
<h3>Click the Button below if this Preview Looks Correct</h3>

</center>
@endif
<center>
@if(!empty($input))
<form enctype="multipart/form-data" id="leadbatchupload" method="post"  action="{{URL::to('lead/batchload')}}">
	<fieldset style="display:none;">
		<input type="text" id="xlsColumnOrder" name="xlsColumnOrder" value="{{$input['xlsColumnOrder']}}"/>
		<input type="text" name="researcher" value="{{$input['researcher']}}" />	
		<input type="text" name="leadcity" value="{{$input['leadcity']}}" />
        <input size="16" id="survey_date" name="survey_date" type="text" value="{{$input['survey_date']}}"  />                                  
        <input id="s3TempFile" name="s3TempFile" type="text" value="{{$file}}" />
	</fieldset>
		
			
			&nbsp;&nbsp;
			<button class="btn  btn-success btn-large tooltwo blackText continueUpload" style="border-radius:8px;padding:25px;font-size:23px;" title="Upload your file straight to the server"  >
			<i class='cus-doc-excel-csv'></i>&nbsp;<b>CONTINUE WITH UPLOAD</b>
			</button>&nbsp;
		
	
</form>
@endif
<br/>
<h3>If the columns are in the wrong order, go back and re-organize your columns to match</h3>
<button class="btn btn-warning btn-large goBack blackText" style="border-radius:8px;padding:25px;font-size:23px;">GO BACK</button>
</center>
</div>
<script>
$(document).ready(function(){
	$('.continueUpload').click(function(e){
		e.preventDefault();
		var t = confirm("Are you sure your columns are correct!! You must use 'SKIP' columns if you have columns you want to ignore or that contain useless data, oir data lnked to a category not provided here");
		if(t){
			$('.ajax-heading').html('Uploading Excel Lead File...');
			$('.ajaxWait').show();
			setTimeout(function(){$('#leadbatchupload').submit();},500);
		}
	});

	$('.goBack').click(function(e){
		e.preventDefault();
        parent.history.back();
        return false;
    });
});
</script>
@endsection

