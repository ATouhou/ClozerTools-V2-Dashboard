@layout('layouts/main')
@section('content')

<style>
.order {
    background:#58D3F7;
    
}

.sell {
    background:#F7819F;
}
</style>

<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- aside -->  
        <aside> 
            @render('layouts.managernav')
        </aside>
        <!-- aside end -->
                
        <!-- main content -->
        <div id="page-content" style="padding-bottom:40px;">
            <h1 id="page-header">Gift Tracker / Stock <button class="btn btn-default btn-large pull-right addToStock" onclick="$('#addGiftToStock').toggle();">ADD GIFTS TO STOCK</button></h1>
                <div class="fluid-container">
                        <!-- widget grid -->
                        <section id="widget-grid" class="">
                        	
                            <div class="row-fluid">

                            <div id="addGiftToStock" class="span12 well" style="display:none;">
                                <h3>Add Gift to Stock</h3>
                                <form id="addGifts" action="" >
                                <label> GIFT : </label>
                                <select name="gift_gift" id="">
                                    @foreach($gifts as $g)
                                    <option value="{{$g->id}}">{{$g->name}}</option>
                                    @endforeach
                                </select>
                                <label> QTY : </label>
                                <input type="text" name="gift_qty" id="gift_qty" value="" /><br/>
                                <button class="btn btn-success">SAVE</button>
                                </form>
                            </div>
                            </div>

                            <div class="row-fluid">


                                <div class="span4">
                                    <h2>Gift Counts</h2>
                                        <table class="table table-bordered table-condensed table-responsive apptable" >
                                            <thead>
                                                <tr align="center">
    												<th>Gift Name</th>
                                                    <th>Qty</th> 
                                                    <th>Total Spent</th>                    	                                    
												</tr>
                                            </thead>
                                            
                                            @foreach($gifts as $val)
                                                <tr >
                                                    <td><span class='giftName tooltwo' style='cursor:pointer;' title='Click to filter History List' data-id='{{$val->id}}'>{{$val->name}}</span></td>
                                                    <td><center>{{$val->qty()}}</center></td>
                                                    <td><center>
                                                    @if($val->total_cost() != 0 )
                                                    ${{number_format($val->total_cost(),2,".","")}}
                                                    @endif
                                                    </center>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            
                                        </table>
                                </div>

                                <div class="span8" style="overflow:scroll;max-height:900px;">
                                    <h2>Gift History 

                                    Filter : <select name="" class="pull-right giftList" style="margin-right:20px;">
                                    <option value="all">ALL</option>
                                    @foreach($gifts as $g)
                                    <option value="{{$g->id}}">{{$g->name}}</option>
                                    @endforeach
                                    </select>
                                    </h2>
                                    <table class="table table-bordered table-condensed table-responsive apptable" >
                                                    <thead>
                                                        <tr align="center">
                                                            <th>DEL</th>
                                                            <th>Date</th>  
                                                            <th>Gift</th>
                                                            <th>Qty</th> 
                                                            <th>User</th>
                                                            <th style="width:35%;">Action Taken</th>  
                                                                                                                    
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($gifttrack as $val)
                                                        <tr class="trackRow {{$val->type}} gift-{{$val->gift_id}}"><td>
                                                        <a href='{{URL::to("util/delgifthistory/")}}{{$val->id}}'>
                                                        <button class='btn btn-danger btn-mini'>X</button>
                                                        </a>
                                                        </td>
                                                        <td>{{date('M-d',strtotime($val->created_at))}}</td>
                                                            <td>{{$val->gift->name}}</td>
                                                            <td><center>{{$val->qty}}</center></td>
                                                            <td><center>
                                                            {{$val->user->fullName()}}
                                                            </center>
                                                            </td>
                                                            <td>{{$val->comment}} @if($val->result!="")
                                                             <?php if($val->result=="SOLD") {$col = "success blackText";} else if($val->result=="DNS"){$col="important ";} else {$col="info ";};?> 
                                                            | <span class='label label-{{$col}} special'>{{$val->result}}</span> 
                                                            @endif</td>
                                                            
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                </div>
                        </div>
                      
                        </section>
                        <!-- end widget grid -->
                </div>      
        </div>
        <!-- end main content -->
            
        <!-- aside right on high res -->
        <aside class="right">
        @render('layouts.chat')
        <div class="divider"></div>
        </aside>
    </div>
</div>

<script>
$(document).ready(function(){
$('#giftmenu').addClass('expanded');

$('.gift').change(function(){
var stat = $(this).attr('id');
var url = '../cities/edit';
var val = $(this).val();
$.get(url, {id: stat, value: val}, function(data) {
            toastr.success('Gift updated succesfully', 'SUCCESS!');
            });
});

$('.giftList').change(function(){
    var id = $(this).val();
    if(id=="all"){
        $('.trackRow').show();
    } else {
        $('.trackRow').hide();
        $('.gift-'+id).show();
    }
    
});

$('.giftName').click(function(){
    var id = $(this).data('id');
    $('.trackRow').hide();
    $('.gift-'+id).show();
});

$('.tooltwo').tooltipster();

});
</script>
@endsection