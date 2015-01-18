
        <h3>Process sale for {{$app->lead->cust_name}}</h3>
<h5>Dispatched to {{$app->rep_name}}</h5>
@if(($app->ridealong_id!=0)&&(!empty($app->ridealong)))
<img src='{{URL::to('img/ride-along.png')}}'>
Has Ride-Along : {{$app->ridealong->firstname}} {{$app->ridealong->lastname}} 
@endif

      
      <form class='submitSale' id="sale" method="post" action="{{URL::to('sales/registersale')}}">
        <div class='span4'>
      @if(($app->ridealong_id!=0)&&(!empty($app->ridealong)))
      <input type="checkbox" name="ra-check" id="ra-check"/> &nbsp;<span class='small'>Check this box, if ridealong did the demo...</span>
      @endif
      <h4>System Type</h4>
      <select name='systemtype'>
      <option value='defender'>Defender</option>
      <option value='2defenders'>2 Defender</option>
      <option value='3defenders'>3 Defender</option>
      <option value='majestic'>Majestic</option>
      <option value='2maj'>2 Majestics</option>
      <option value='3maj'>3 Majestics</option>
      <option value='system'>System</option>
      <option value='supersystem'>Super System</option>
      <option value='megasystem'>Mega System</option>
      <option value='novasystem'>Nova System</option>
      <option value='supernova'>Super Nova System</option>
      <option value='2system'>2 Systems</option>
      </select>
      <label for="payout">Payout : </label>
      <input type="text" name="payout" class="salepayout" id="payout" />
      <label for="payout">Price : </label>
      <input type="text" name="price" class="salepayout" id="price" />
      <input type="hidden" id="appid" name="appid" value="<?php echo $app->id;?>"/>
    </div>

           
            <input type="button" class="btn btn-primary btn-large" value="SUBMIT"  onclick="$('.submitSale').submit();" >&nbsp;&nbsp;
          </form>
            
            <button class="btn btn-danger btn-small" onclick="$('#processsale').hide();" style='margin-top:5px;'>CANCEL</button><br/>
            
            
    <script>
    $(document).ready(function(){

      $('.salepayout').on('keyup',function(){
        var val = $(this).val();
      if(isNaN(val)){
         val = val.replace(/[^0-9\.]/g,'');
           if(val.split('.').length>2) 
              val =val.replace(/\.+$/,"");
           }
        $(this).val(val); 
      });

    });
    </script>