<input type="hidden" id="duplicateSkip" value="{{$skip}}" />
<input type="hidden" id="duplicateCity" value="{{$city}}" />
            <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;Duplicate Leads In System
           <button class="btn- btn-large pull-right duplicateQuarantined">QUARANTINED DUPLICATES</button>
            </h1>
            <h3 style='margin-top:-10px;'>( {{$page}} Leads are Duplicate Entries @if($city!="all") in {{$city}} @endif  )</h3>   
                @for($v=0;$v<($page/15);$v++)
                @if($skip==(15*$v))
                <button class='btn btn-mini btn-inverse duplicatePaginate' data-skip="{{15*($v)}}" style='margin-bottom:4px;'>{{$v+1}}</button>
                @else
                <button class='btn btn-mini btn-default duplicatePaginate' data-skip="{{15*($v)}}" style='margin-bottom:4px;'>{{$v+1}}</button>
                @endif
                
                @endfor
                <div class="span12" id="leadLoader" style="display:none;"><br/><br/><br/><br/>
                   <center><img src='{{URL::to("img/loaders/misc/300.gif")}}'></center><br/><br/><br/>
                </div>
                            <table class="apptable table table-condensed table-bordered table-responsive" id="duplicateTable" style="margin-top:20px;">
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cnt=$skip; $col=0;?>
                                    @foreach($leads as $k=>$val)
                                    <?php if($col==0){$col=1; $color="#ddd";} else if($col==1){$col=0;$color="#fff";};?>
                                    <?php $dups = Lead::where('cust_num','=',$val->cust_num)->get(array('id','city','cust_num','cust_name','entry_date','birth_date','assign_count','researcher_name','status','original_leadtype','leadtype'));
                                    $cnt++;?>
                                    <tr class='mainRow' style="background:{{$color}}" id="lead-{{$val->id}}">
                                        <td>Lead # : {{$val->id}}</td>
                                        <td ><span class='searchNum tooltwo' style='cursor:pointer;font-weight:bolder;font-size:15px;' title='Click to Search this Number'>{{$val->cust_num}}</span></td>
                                        <td>{{$val->cust_name}}</td>
                                        <td>
                                            @if($val->birth_date!='0000-00-00')
                                            {{$val->birth_date}}
                                            @else
                                            {{$val->entry_date}}
                                            @endif
                                        </td>
                                        <td>{{$val->city}}</td>
                                        <td >
                                            {{$val->researcher_name}}
                                        </td>
                                        <td >
                                            {{strtoupper($val->original_leadtype)}}
                                        </td>
                                        <td >
                                            {{$val->status}}
                                        </td>
                                        <td>
                                         <button class='btn btn-mini btn-danger deleteDuplicate' data-id='{{$val->id}}'>DELETE</button>
                                        </td>
                                    </tr>
                                    @if(!empty($dups))
                                        @foreach($dups as $d)
                                            @if($d->id!=$val->id)
                                           
                                        <tr id='lead-{{$d->id}}' style="background:{{$color}}" class='duplicateRow'>
                                        <td>Lead # : {{$d->id}}</td>
                                        <td ><span class='searchNum tooltwo' style='font-weight:bolder;color:red;font-size:15px;' title='Click to Search this Number'>{{$d->cust_num}}</span></td>
                                        <td>{{$d->cust_name}}</td>
                                        <td>
                                            @if($d->birth_date!='0000-00-00')
                                            {{$d->birth_date}}
                                            @else
                                            {{$d->entry_date}}
                                            @endif
                                        </td>
                                        <td>{{$d->city}}</td>
                                        <td >
                                            {{$d->researcher_name}}
                                        </td>
                                        <td >
                                              {{strtoupper($d->original_leadtype)}}
                                        </td>
                                        <td >
                                            {{$d->status}}
                                        </td>
                                        <td> @if($d->status=="DELETED" && $d->assign_count==99999)
                                            QUARANTINED
                                            
                                            @else
                                            <button class='btn btn-mini btn-danger deleteDuplicate' data-id='{{$d->id}}'>DELETE</button>
                                            @endif
                                            </td>
                                        </tr>
                                        
                                        @endif
                                        @endforeach


                                    @endif
                                    @endforeach
                                    
                                </tbody>
                            </table>
                            <br/>

                            @foreach($cities as $v)
                            <button class='btn btn-mini btn-default duplicatePaginate' data-city='{{$v->city}}'>{{$v->city}}</button>
                            @endforeach
                        
<script>
$(document).ready(function() {


   
    $('.tooltwo').tooltipster();
    var img = '{{URL::to("img/loaders/misc/66.gif")}}';

    $('.duplicatePaginate').click(function(){
        $('.duplicatePaginate').removeClass('btn-inverse');
        $(this).addClass('btn-inverse');
        var skip = $(this).data('skip');
        var city = $(this).data('city');
        if(city==undefined || city=="") {
            city = "all";
        }
        
        $('#leadLoader').show();
        $('#duplicateTable').hide();
        $.get("{{URL::to('lead/duplicates')}}",{skip:skip, city:city},function(data){
            $('#leadsAssigned').html(data);
            $('#leadLoader').hide();
            $('#duplicateTable').show();
        });
    });
    
    loaderIMG = "<tr class='imgLoader'><td colspan=8><center><img src='"+img+"'></center></td></tr>";




});
</script>

