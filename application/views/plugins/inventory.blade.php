<style>
#enterone {float:left; margin-left:20px;padding-bottom:20px;}
                                          #dtable3 input {width:70%!important;float:left;}
                                          #dtable3 select {width:90%!important;float:left;}
                                        </style>

                                    <table class="table table-bordered table-condensed responsive" style="margin-left:-15px;" >
                                                 
                                                   <table class="table table-bordered table-condensed responsive" id="dtable3">
                                                    <thead>
                                                       
                                                        <tr>
                                                            <th>DEL</th>
                                                            <th>SKU #</th>
                                                            <th>UNIT NAME</th>
                                                            <th>Date Received</th>
                                                            <th>Date Sold</th>
                                                            <th>LOCATION</th>
                                                            <th>STATUS</th>
                                                            <th>Sold By</th>
                                                            <th>Checked Out By</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody class="inventory">
                                                    @foreach($inventory as $val)
                                                    <?php if($val->status=="In Stock")
                                                    {$class="success";$stat="label label-success";} 
                                                    elseif($val->status=="Sold") 
                                                    {$class="SOLD";$stat="label label-success special";} 
                                                    elseif($val->status=="Checked Out")
                                                    {$class="info";$stat="label label-info";}
                                                    elseif($val->status=="Waiting Approval")
                                                    {$class="NA";$stat="label label-warning";}
                                                    else {$class="";$stat="label";}

                                                    if($val->item_name=="defender"){$type="inverse";}elseif($val->item_name=="majestic"){$type="success";}else{$type="info";}
                                                    ?>

                                                     <tr class="{{$class}} {{$val->location}} item-{{$val->id}}" id="item-{{$val->id}}">
                                                        <td>@if($val->status=="In Stock")
                                                            <center>
                                                                <button class="btn btn-danger btn-mini deleteitem" data-id="{{$val->id}}">X</button>
                                                            </center>
                                                            @endif
                                                        </td>
                                                        <td><b><span class='edit' id="sku|{{$val->id}}">{{$val->sku}}</span></b></td>
                                                        <td><span class="label label-{{$type}}">{{ucfirst($val->item_name)}}</span></td>
                                                        <td class="edit" id="date_received|{{$val->id}}">{{$val->date_received}}</td>
                                                        <td>@if($val->date_sold!="0000-00-00")<center>{{$val->date_sold}}</center>@endif</td>
                                                        <td class="center editcity" id="location|{{$val->id}}">{{$val->location}}</td>
                                                        <td class="center">
                                                            @if($val->status=="Sold")
                                                          
                                                            <span class="{{$stat}}">{{$val->status}}</span>  
                                                            @else
                                                            <span class="{{$stat}}">{{$val->status}}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{$val->sold_by}}</td>
                                                        <td id="{{$val->id}}">
                                                        @if($val->checked_by!="")
                                                            @if($val->status=="Sold")
                                                            <span class='label label-inverse'>SOLD BY {{strtoupper($val->sold_by)}}</span>
                                                            @else
                                                            <a href="{{URL::to('inventory/return/')}}{{$val->id}}">
                                                                <button class="btn btn-primary btn-mini">
                                                                    <i class="cus-arrow-left"></i>&nbsp;Return To Stock
                                                                </button>
                                                            </a><strong>&nbsp;&nbsp;Assigned To {{strtoupper($val->checked_by)}}</strong> &nbsp;&nbsp;
                                                            @endif  
                                                        @else
                                                        <select name="repdispatch" id="repdispatch-{{$val->id}}" style="width:45%!important;">
                                                            <option></option>
                                                            @foreach($reps as $val2)
                                                            <option value="{{$val2->id}}">{{$val2->firstname}} {{$val2->lastname}}</option>
                                                            @endforeach
                                                        </select>&nbsp;
                                                        <button class="btn btn-mini btn-default sendtorep" data-id="{{$val->id}}">SEND TO REP</button>
                                                        @endif
                                                        </td>
                                                    </tr>
                                                     @endforeach
                                                    </tbody>
                                                </table>
                                            </table>

<script>
$(document).ready(function(){

   
        $('#dtable3').dataTable({
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






});
</script>