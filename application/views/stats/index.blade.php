@layout('layouts/main')
@section('content')

<?php 
    function closePercent($value, $divisor){
        if($value!=0){
            $close = number_format(($value/($value+$divisor)),2,'.','')*100;
        } else {
            $close = "N/A";
        }
        return $close;
    }
;?>

<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<div id="main"  class="container-fluid" style="background:white;padding:45px;padding-top:30px;padding-bottom:800px;">
	
<div class="row-fluid">
  <button class='btn btn-default filterTables' data-type='close'>ORDER BY CLOSE % </button>
  <button class='btn btn-default filterTables' data-type='sold'>ORDER BY SALES </button>
</div>

<div class="row-fluid">
  <div class="span3">
      <h3> TETS</h3>
      <table class="table table-condensed table-responsive apptable">
         <thead>
            <th>LEADTYPE</th>
            <th><center>SOLD</center></th>
            <th><center>DNS</center></th>
            <th><center>INC</center></th>
            <th><center>CLOSE %</center></th>
         </thead>
         <tbody class="tableToSort">
          
            <tr data-close='23' data-sold='22'>
              <td></td>
              <td><center><span class='badge totalStat badge-success blackText'>22</span></center></td>
              <td><center><span class='badge totalStat badge-important '>2</span></center></td>
              <td><center><span class='badge totalStat badge-warning blackText'>3</span></center></td>
              <td><center><span class='badge totalStat badge-inverse' >23%</span></center></td>
            </tr>
            <tr data-close='15' data-sold='44'>
              <td></td>
              <td><center><span class='badge totalStat badge-success blackText'>44</span></center></td>
              <td><center><span class='badge totalStat badge-important '>2</span></center></td>
              <td><center><span class='badge totalStat badge-warning blackText'>3</span></center></td>
              <td><center><span class='badge totalStat badge-inverse' >15%</span></center></td>
            </tr>
            <tr data-close='32' data-sold='18'>
              <td></td>
              <td><center><span class='badge totalStat badge-success blackText'>18</span></center></td>
              <td><center><span class='badge totalStat badge-important '>2</span></center></td>
              <td><center><span class='badge totalStat badge-warning blackText'>3</span></center></td>
              <td><center><span class='badge totalStat badge-inverse' >32%</span></center></td>
            </tr>
            <tr data-close='12' data-sold='10'>
              <td></td>
              <td><center><span class='badge totalStat badge-success blackText'>10</span></center></td>
              <td><center><span class='badge totalStat badge-important '>2</span></center></td>
              <td><center><span class='badge totalStat badge-warning blackText'>3</span></center></td>
              <td><center><span class='badge totalStat badge-inverse' >12%</span></center></td>
            </tr>
           
         </tbody>
      </table>
  </div>
   <div class="span5">
   <br/><br/><br/>
      <div id="chart-container1">
      </div>
   </div>
   <div class="span3">

   </div>
</div>


<div class="row-fluid">
	<div class="span3">
      <h3> SALES BY LEADTYPE</h3>
      <table class="table table-condensed table-responsive apptable">
         <thead>
            <th>LEADTYPE</th>
            <th><center>SOLD</center></th>
            <th><center>DNS</center></th>
            <th><center>INC</center></th>
            <th><center>CLOSE %</center></th>
         </thead>
         <tbody class="tableToSort">
          @if(!empty($sales_by['leadtype']))
            @foreach($sales_by['leadtype'] as $l)
            @if($l->sold!=0)
            @if($l->original_leadtype!="")
            <tr data-close='{{closePercent($l->sold,$l->dns)}}' data-sold='{{$l->sold}}'>
              <td>{{strtoupper($l->original_leadtype)}}</td>
              <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold}}</span></center></td>
              <td><center><span class='badge totalStat badge-important '>{{$l->dns}}</span></center></td>
              <td><center><span class='badge totalStat badge-warning blackText'>{{$l->inc}}</span></center></td>
              <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold,$l->dns)}} %</span></center></td>
            </tr>
            @endif
            @endif
            @endforeach
          @else
          <td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td>
          @endif
         </tbody>
      </table>
	</div>
   <div class="span5">
   <br/><br/><br/>
      <div id="chart-container1">
      </div>
   </div>
   <div class="span3">

   </div>
</div>

<div class="row-fluid">
	<div class="span3">
		<h3> SALES BY GIFT</h3> 
      <table class="table table-condensed table-responsive apptable">
         <thead>
            <th>GIFT TYPE</th>
            <th><center>SOLD</center></th>
            <th><center>DNS</center></th>
            <th><center>INC</center></th>
            <th><center>CLOSE %</center></th>
         </thead>
         <tbody class="tableToSort">
          @if(!empty($sales_by['gift']))
            @foreach($sales_by['gift'] as $l)
            @if($l->gift!="")
            <tr data-close='{{closePercent($l->sold,$l->dns)}}' data-sold='{{$l->sold}}'>
              <td>{{strtoupper($l->gift)}}</td>
              <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold}}</span></center></td>
              <td><center><span class='badge totalStat badge-important '>{{$l->dns}}</span></center></td>
              <td><center><span class='badge totalStat badge-warning blackText'>{{$l->inc}}</span></center></td>
              <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold,$l->dns)}} %</span></center></td>
            </tr>
            @endif
            @endforeach
             @else
          <td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td>
          @endif
         </tbody>
      </table>
	</div>
   <div class="span5">
   <br/><br/><br/>
      <div id="chart-container2">
      </div>
   </div>
   <div class="span3">

   </div>
</div>

<div class="row-fluid">
    <div class="span3">
        <h3> SALES BY MARITAL STATUS</h3> 
      <table class="table table-condensed table-responsive apptable">
         <thead>
            <th>MARITAL STATUS</th>
            <th><center>SOLD</center></th>
            <th><center>DNS</center></th>
            <th><center>INC</center></th>
            <th><center>CLOSE %</center></th>
         </thead>
         <tbody class="tableToSort">
          @if(!empty($sales_by['marital']))
            @foreach($sales_by['marital'] as $l)
            @if($l->married!="")
            <tr data-close='{{closePercent($l->sold,$l->dns)}}' data-sold='{{$l->sold}}'>
              <td>{{strtoupper($l->married)}}</td>
              <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold}}</span></center></td>
              <td><center><span class='badge totalStat badge-important '>{{$l->dns}}</span></center></td>
              <td><center><span class='badge totalStat badge-warning blackText'>{{$l->inc}}</span></center></td>
              <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold,$l->dns)}} %</span></center></td>
            </tr>
            @endif
            @endforeach
            @else
          <td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td>
          @endif
         </tbody>
      </table>
    </div>
   <div class="span5">
   <br/><br/><br/>
      <div id="chart-container5">
      </div>
   </div>
   <div class="span3">

   </div>
</div>



<div class="row-fluid">
   <div class="span3">
      <h3> SALES BY TIME <button class='btn btn-small pull-right' onclick="$('.hiddenrow').toggle();">SHOW ALL</button></h3> 
      <table class="table table-condensed table-responsive apptable">
         <thead>
            <th>TIME SLOT</th>
            <th><center>SOLD</center></th>
            <th><center>DNS</center></th>
            <th><center>INC</center></th>
            <th><center>CLOSE %</center></th>
         </thead>
         <tbody class="tableToSort">
         <?php $cnt=0;?>
          @if(!empty($sales_by['time']))
            @foreach($sales_by['time'] as $l)
            <?php $cnt++;
            if($cnt>=10){$cl = "hide hiddenrow";} else {$cl="";};
            ?>
            @if($l->sold!=0)
            @if($l->app_time!="" && $l->app_time!='00:00:00')
            <tr class="{{$cl}}" data-close='{{closePercent($l->sold,$l->dns)}}' data-sold='{{$l->sold}}'>
              <td>{{strtoupper($l->app_time)}}</td>
              <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold}}</span></center></td>
              <td><center><span class='badge totalStat badge-important '>{{$l->dns}}</span></center></td>
              <td><center><span class='badge totalStat badge-warning blackText'>{{$l->inc}}</span></center></td>
              <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold,$l->dns)}} %</span></center></td>
            </tr>
            @endif
            @endif
            @endforeach
            @else
          <td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td>
          @endif
         </tbody>
      </table>
   </div>
    <div class="span5">
   <br/><br/><br/>
      <div id="chart-container3">
      </div>
   </div>
   <div class="span3">

   </div>
</div>
<div class="row-fluid">
   <div class="span3">
      <h3> SALES BY TIME SLOT</h3> 
      <table class="table table-condensed table-responsive apptable">
         <thead>
            <th>TIME SLOT</th>
            <th><center>SOLD</center></th>
            <th><center>DNS</center></th>
            <th><center>CLOSE %</center></th>
         </thead>
         <tbody class="tableToSort">
         <?php $cnt=0;?>
          @if(!empty($sales_by['timeslots']))
            @foreach($sales_by['timeslots'] as $l)
            <tr data-close='{{closePercent($l->sold_one,$l->dns_one)}}' data-sold='{{$l->sold_one}}'>  
            <td>Slot #1</td>
            <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold_one}}</span></center></td>
            <td><center><span class='badge totalStat badge-important blackText'>{{$l->dns_one}}</span></center></td>
            <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold_one,$l->dns_one)}}</span></center></td>
            
            </tr>
            <tr data-close='{{closePercent($l->sold_two,$l->dns_two)}}' data-sold='{{$l->sold_two}}'>  
            <td>Slot #2</td>
            <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold_two}}</span></center></td>
            <td><center><span class='badge totalStat badge-important blackText'>{{$l->dns_two}}</span></center></td>
            <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold_two,$l->dns_two)}}</span></center></td>
            
            </tr>
            <tr data-close='{{closePercent($l->sold_three,$l->dns_three)}}' data-sold='{{$l->sold_three}}'>  
            <td>Slot #3</td>
            <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold_three}}</span></center></td>
            <td><center><span class='badge totalStat badge-important blackText'>{{$l->dns_three}}</span></center></td>
            <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold_three,$l->dns_three)}}</span></center></td>
            
            </tr>
            <tr data-close='{{closePercent($l->sold_four,$l->dns_four)}}' data-sold='{{$l->sold_four}}'>  
            <td>Slot #4</td>
            <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold_four}}</span></center></td>
            <td><center><span class='badge totalStat badge-important blackText'>{{$l->dns_four}}</span></center></td>
            <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold_four,$l->dns_four)}}</span></center></td>
            
            </tr>
            <tr data-close='{{closePercent($l->sold_five,$l->dns_five)}}' data-sold='{{$l->sold_five}}'>  
            <td>Slot #5</td>
            <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold_five}}</span></center></td>
            <td><center><span class='badge totalStat badge-important blackText'>{{$l->dns_five}}</span></center></td>
            <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold_five,$l->dns_five)}}</span></center></td>
            </tr>
            @endforeach
            @else
          <td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td>
          @endif
         </tbody>
      </table>
   </div>
</div>

<div class="row-fluid">
   <div class="span3">
      <h3> SALES BY HOME TYPE<button class='btn btn-small pull-right' onclick="$('.hiddenrow').toggle();">SHOW ALL</button></h3> 
      <table class="table table-condensed table-responsive apptable">
         <thead>
            <th>HOMETYPE</th>
            <th><center>SOLD</center></th>
            <th><center>DNS</center></th>
            <th><center>INC</center></th>
            <th><center>CLOSE %</center></th>
         </thead>
         <tbody class="tableToSort">
         <?php $cnt=0;?>
          @if(!empty($sales_by['hometype']))
            @foreach($sales_by['hometype'] as $l)
            <?php $cnt++;
            if($cnt>=10){$cl = "hide hiddenrow";} else {$cl="";};
            ?>
            @if($l->sold!=0)
            @if($l->homestead_type!="")
            <tr class="{{$cl}}" data-close='{{closePercent($l->sold,$l->dns)}}' data-sold='{{$l->sold}}'>
            <td>{{strtoupper($l->city)}}</td>
            <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold}}</span></center></td>
            <td><center><span class='badge totalStat badge-important '>{{$l->dns}}</span></center></td>
            <td><center><span class='badge totalStat badge-warning blackText'>{{$l->inc}}</span></center></td>
            <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold,$l->dns)}} %</span></center></td>
            </tr>
            @endif
            @endif
            @endforeach
            @else
          <td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td>
          @endif
         </tbody>
      </table>
   </div>
   <div class="span5">
   <br/><br/><br/>
      <div id="chart-container4">
      </div>
   </div>
   <div class="span3">

   </div>
</div>


<div class="row-fluid">
   <div class="span3">
      <h3> SALES BY CITY<button class='btn btn-small pull-right' onclick="$('.hiddenrow').toggle();">SHOW ALL</button></h3> 
      <table class="table table-condensed table-responsive apptable">
         <thead>
            <th>CITY</th>
            <th><center>SOLD</center></th>
            <th><center>DNS</center></th>
            <th><center>INC</center></th>
            <th><center>CLOSE %</center></th>
         </thead>
         <tbody class="tableToSort">
         <?php $cnt=0;?>
          @if(!empty($sales_by['city']))
            @foreach($sales_by['city'] as $l)
            <?php $cnt++;
            if($cnt>=10){$cl = "hide hiddenrow";} else {$cl="";};
            ?>
            @if($l->sold!=0)
            @if($l->city!="")
            <tr class="{{$cl}}" data-close='{{closePercent($l->sold,$l->dns)}}' data-sold='{{$l->sold}}'>
            <td>{{strtoupper($l->city)}}</td>
            <td><center><span class='badge totalStat badge-success blackText'>{{$l->sold}}</span></center></td>
            <td><center><span class='badge totalStat badge-important '>{{$l->dns}}</span></center></td>
            <td><center><span class='badge totalStat badge-warning blackText'>{{$l->inc}}</span></center></td>
            <td><center><span class='badge totalStat badge-inverse'>{{closePercent($l->sold,$l->dns)}} %</span></center></td>
            </tr>
            @endif
            @endif
            @endforeach
            @else
          <td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td>
          @endif
         </tbody>
      </table>
   </div>
   <div class="span5">
   <br/><br/><br/>
      <div id="chart-container6">
      </div>
   </div>
   <div class="span3">

   </div>
</div>


</div>

<div class="push"></div>
<script src="{{URL::to('js/charts/themes.js')}}"></script>

<script>
$(function () {

  function sortTable(theTableBody,dataToSort){
    $cells = theTableBody.children('tr');
    $cells.sort(function(a,b){
      var an = a.getAttribute(dataToSort),
      bn = b.getAttribute(dataToSort);
      if(an < bn) {
        return 1;
      }
      if(an > bn) {
        return -1;
      }
      return 0;
    });
    $cells.detach().appendTo(theTableBody);   
  }

  $('.filterTables').click(function(){
    var type = $(this).data('type');
    $('.tableToSort').each(function(i,val){
        sortTable($(this),'data-'+type);
    });
  });


var leadtypeData = {{json_encode($charts['leadtype'])}};
var gifttypeData = {{json_encode($charts['gift'])}};
var apptimeData = {{json_encode($charts['time'])}};
var maritalData = {{json_encode($charts['marital'])}};
var housetypeData = {{json_encode($charts['hometype'])}};

    $('#chart-container1').highcharts({
        chart: {
            type: 'column',
            margin: 75,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'SALES BY LEADTYPE'
        },
        
        plotOptions: {
        column: {
                depth: 25,
                colorByPoint: true
        
            }
        },
        xAxis: {
            categories: leadtypeData.categories,
            
        },
        yAxis: {
            opposite: true
        },
        series: [{
            name: 'SOLD',
            data: leadtypeData.sold

        }]
    });

    $('#chart-container2').highcharts({
        chart: {
            type: 'column',
            margin: 75,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'SALES BY GIFT TYPE'
        },
        
        plotOptions: {
            column: {
                depth: 25,
                colorByPoint: true
            }
        },
        xAxis: {
            categories: gifttypeData.categories,
            
        },
        yAxis: {
            opposite: true,
            
        },
        series: [{
            name: 'Sales',
            data: gifttypeData.sold
        }]
    });

    $('#chart-container4').highcharts({
        chart: {
            type: 'column',
            margin: 75,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'Sales By House Type'
        },
       
        plotOptions: {
            column: {
                depth: 25,
                colorByPoint: true
            }
        },
        xAxis: {
            categories: housetypeData.categories
        },
        yAxis: {
            opposite: true
        },
        series: [{
            name: 'Sales',
            data: housetypeData.sold
        }]
    });

    $('#chart-container3').highcharts({
        chart: {
            type: 'column',
            margin: 75,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'SALES BY APPOINTMENT TIME'
        },
       
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: apptimeData.categories
        },
        yAxis: {
            opposite: true
        },
        series: [{
            name: 'Sales',
            data: apptimeData.sold
        }]
    });

     $('#chart-container5').highcharts({
        chart: {
            type: 'column',
            margin: 75,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'SALES BY MARITAL STATUS'
        },
       
        plotOptions: {
            column: {
                depth: 25,
                colorByPoint: true
            }
        },
        xAxis: {
            categories: maritalData.categories
        },
        yAxis: {
            opposite: true
        },
        series: [{
            name: 'Sales',
            data: maritalData.sold
        }]
    });
});
</script>
@endsection