@layout('layouts/main')
@section('content')
      <style>
      .scriptbox {
        margin-top:30px;
        border : 1px solid #ccc;
        border-radius:4px;
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
        <div id="page-content">
            <h1 id="page-header">Gift Manager</h1>   
                <div class="fluid-container">
                        <!-- widget grid -->
                        <section id="widget-grid" class="">
                            <article class="span12" style="margin-bottom:80px;">
                              <button class="btn btn-large btn-success addGift">ADD A NEW GIFT</button> 
                              <A href="{{URL::to('util/giftcities')}}">
                              <button class="btn btn-large btn-primary">ASSIGN GIFTS TO CITIES / LEADTYPES</button>
                              </a>
                              <a href='{{URL::to("util/giftstock")}}'><button class="btn btn-large btn-default pull-right stockGifts">GIFTS IN STOCK</button> 
                                </a>
                              <br><br>
                              <div class="allgifts">
                            @if(!empty($gifts))
							@foreach($gifts as $val)
                            <div class="control-group span3 shadowBOX obj gift-{{$val->id}} scriptbox" >
                                <label for="gifttitle">Name of Gift : </label>
                                <input type="text" name="gifttitle-{{$val->id}}" id="gifttitle-{{$val->id}}" value="{{$val->name}}"/>
                                <label for="giftdesc">Description for Marketing Script : </label>
                                <textarea type="text" name="giftdesc-{{$val->id}}" id="giftdesc-{{$val->id}}" value="{{$val->desc}}" rows=10>{{$val->desc}}</textarea>
                                <label for="giftprice">Price per Unit</label>
                                <input name="giftprice-{{$val->id}}" id="giftprice-{{$val->id}}" value="{{$val->priceper}}"><br><br/><br/>
                                <button class="btn btn-primary btn-mini saveGift" data-id="{{$val->id}}">SAVE</button>
                                <button class="btn btn-mini btn-danger deleteGift" data-id="{{$val->id}}">DELETE</button>
                            </div>
							@endforeach
                            @endif
                        </div>
                        </article>
                        </section>
                </div>      
        </div>
       <!-- end main content -->
       <!-- aside right on high res -->
        <aside class="right">
        @render('layouts.chat')
     
        </aside>
    </div>
</div>
<script>
$(document).ready(function(){
$('#giftmenu').addClass('expanded');
var count = $('.deleteGift:last').data('id');

$('.stockGifts').click(function(){
        $('#stock').show();
        $('#gifts').hide();
});


$('.addGift').click(function(){
    count++;
    var html = "<div class='control-group shadowBOX span3 obj gift-"+count+" scriptbox' >";
    html+="<label for='gifttitle'>Name of Gift : </label><input type='text' name='gifttitle-"+count+"' id='gifttitle-"+count+"' />";
     html+="<label for='giftdesc'>Description : </label><textarea name='giftdesc-"+count+"' id='giftdesc-"+count+"' rows=10></textarea>";
    html+="<label for='giftprice'>Price per Unit</label><input name='giftprice-"+count+"' id='giftprice-"+count+"'  ><br><br/><button class='btn btn-primary btn-mini saveGift' data-id='"+count+"'>SAVE</button>&nbsp;<button class='btn btn-mini btn-danger deleteGift' data-id='"+count+"'>DELETE</button></div>";
    $('.allgifts').prepend(html);
});

$('.allgifts').on('click','.deleteGift', function(){
var id = $(this).data('id');
count--;
$.ajax({type: "POST",
        url: "../util/giftdelete",
        data: {id:id},
            beforeSend: function(){},
            success: function(data) {
            toastr.success('Gift has been deleted!', 'DELETE SUCCESS!');
            $('.gift-'+id).hide(200);
            }
    }); 


});

$('.allgifts').on('click','.saveGift', function(){
var id = $(this).data('id');
var pri = $('#giftprice-'+id).val();
var tit = $('#gifttitle-'+id).val();
var desc = $('#giftdesc-'+id).val();
$.ajax({
        type: "POST",
        url: "../util/giftsave",
        data: {id:id,price:pri,name:tit,desc:desc},
            success: function(data) {
            toastr.success('Gift has been updated', 'SAVE SUCCESS!');
            }
    }); 
});



});
</script>
@endsection