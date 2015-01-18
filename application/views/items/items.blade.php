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
            <h1 id="page-header">Item Manager</h1>   
                <div class="fluid-container">
                        <!-- widget grid -->
                        <section id="widget-grid" class="">
                            <article class="span12" style="margin-bottom:80px;">
                              <button class="btn btn-large btn-success addItem">ADD A NEW STOCK ITEM</button>
                              <br><br>
                              <div class="allitems">
                            @if(!empty($items))
							@foreach($items as $val)
                            <div class="control-group span3 shadowBOX obj gift-{{$val->id}} scriptbox" >
                                <label for="itemtitle">Name of Item : </label>
                                <input type="text" name="itemtitle-{{$val->id}}" id="itemtitle-{{$val->id}}" value="{{$val->name}}"/>
                                <label for="itemdesc">Description of Item : </label>
                                <textarea type="text" name="itemdesc-{{$val->id}}" id="itemdesc-{{$val->id}}" value="{{$val->description}}" rows=4>{{$val->description}}</textarea>
                                <br/>
                                <label for='itemtype'>Type of Item :</label>
                                <select name="itemtype-{{$val->id}}" id="itemtype-{{$val->id}}" >
                                    <option value="stock" @if($val->type=="stock") selected='selected' @endif>Stock</option>
                                    <option value="gift" @if($val->type=="gift") selected='selected' @endif>Gift</option>
                                    <option value="other" @if($val->type=="other") selected='selected' @endif>Other / Scratch Cards / Ballot Boxes</option>
                                </select>
                                <label for="itemprice">Price per Item</label>
                                <input name="itemprice-{{$val->id}}" id="itemprice-{{$val->id}}" value="{{$val->price}}"><br><br/><br/>
                                <button class="btn btn-primary btn-mini saveGift" data-id="{{$val->id}}">SAVE</button>
                                <button class="btn btn-mini btn-danger deleteItem" data-id="{{$val->id}}">DELETE</button>
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
$('#itemmenu').addClass('expanded');
var count = $('.deleteItem:first').data('id');


$('.addItem').click(function(){
    count++;
    var html = "<div class='control-group shadowBOX span3 obj gift-"+count+" scriptbox' >";
    html+="<label for='itemtitle'>Name of Item : </label><input type='text' name='itemtitle-"+count+"' id='itemtitle-"+count+"' />";
    html+="<label for='itemdesc'>Description of Item: </label><textarea name='itemdesc-"+count+"' id='itemdesc-"+count+"' rows=4></textarea><br/>";
    html+=" <label for='itemtype'>Type of Item :</label><select name='itemtype-"+count+"' id='itemtype-"+count+"' ><option value='stock' >Stock</option><option value='gift' >Gift</option><option value='other'>Other / Scratch Cards / Ballot Boxes</option></select><br/>";
    html+="<label for='itemprice'>Price per Item</label><input name='itemprice-"+count+"' id='itemprice-"+count+"'  ><br><br/><button class='btn btn-primary btn-mini saveGift' data-id='"+count+"'>SAVE</button>&nbsp;<button class='btn btn-mini btn-danger deleteItem' data-id='"+count+"'>DELETE</button></div>";
    $('.allitems').prepend(html);
});

$('.allitems').on('click','.deleteItem', function(){
var id = $(this).data('id');
count--;
$.ajax({type: "POST",
        url: "../items/delete",
        data: {id:id},
            beforeSend: function(){},
            success: function(data) {
            toastr.success('Item has been deleted!', 'DELETE SUCCESS!');
            $('.gift-'+id).hide(200);
            }
    }); 


});

$('.allitems').on('click','.saveGift', function(){
var id = $(this).data('id');
var pri = $('#itemprice-'+id).val();
var tit = $('#itemtitle-'+id).val();
var desc = $('#itemdesc-'+id).val();
var type = $('#itemtype-'+id).val();
$.ajax({
        type: "POST",
        url: "../items/save",
        data: {id:id,price:pri,name:tit,desc:desc,type:type},
            success: function(data) {
                console.log(data);
            toastr.success('Item has been updated', 'SAVE SUCCESS!');
            }
    }); 
});



});
</script>
@endsection