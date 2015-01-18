<?php 
$dates = Stats::get1standLastofMonth(date('Y-m-d'));
;?>

      <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;{{count($quarantined)}} Total Duplicates Quarantined
            <button class="btn- btn-large pull-right duplicateManager">BACK TO UNQUARANTINED DUPLICATES</button>
            </h1><br/>

            <a href='{{URL::to("reports/dataentry")}}?startdate={{$dates[0]}}&enddate={{$dates[1]}}' target=_blank><button class='btn btn-primary'>VIEW THIS MONTHS DUPLICATE / INVALID NUMBER REPORT</button></a>

@if(!empty($quarantined))
    <table class="apptable table table-condensed table-bordered table-responsive" id="quarantineTable" style="margin-top:20px;">
        <thead >
            <tr>
                <th style='width:6%;'></th>
                <th>Phone Number</th>
                <th>Customer Name</th>
                <th>Entry Date</th>
                <th>City</th>
                <th>Entered By</th>
                <th>Leadtype</th>
                <th>Status</th>
            </tr>
        </thead>
        @foreach($quarantined as $q)
         <tr id='lead-{{$q->id}}'  class='duplicateRow'>
                <td>Lead # : {{$q->id}}</td>
                <td ><span class='searchNum tooltwo' style='font-weight:bolder;color:red;font-size:15px;' title='Click to Search this Number'>{{$q->cust_num}}</span></td>
                <td>{{$q->cust_name}}</td>
                <td>
                    @if($q->birth_date!='0000-00-00')
                    {{$q->birth_date}}
                    @else
                    {{$q->entry_date}}
                    @endif
                </td>
                <td>{{$q->city}}</td>
                <td >
                    {{$q->entry_date}}
                </td>
                <td >
                    {{$q->researcher_name}}
                </td>
                <td >
                    QUARANTINED / DELETED
                </td>
               
                </tr>
    
        @endforeach
    </table>
    @else
    <br/><br/><br/>
    <h2>No Quarantined Duplicates Found</h2>
    @endif