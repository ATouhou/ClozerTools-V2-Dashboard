<button class='pull-right btn btn-danger' onclick='$(".infoHover").hide();'>CLOSE</button>
@if(!empty($history))

<h4>History of SKU#: <font color='yellow'> {{$history[0]->attributes['item_id']}}</font> </h4>
@if(!empty($item))
      @if($item->status=="Sold" && $item->sale_id!=0)
      <div style='height:230px;overflow:scroll'>
      @else
      <div style='height:500px;overflow:scroll'>
      @endif
@endif
<table class='table table-bordered' style="width:97%;">
      <tr>
            <th>Message</th>
            <th style="width:18%;">Date</th>
            <th>Action</th>
            <th style="width:18%;">Done By</th>
      </tr>
@foreach($history as $h)
<?php $u = User::find($h->user_id);?>
<?php if($h->type=="move"){$label = "info";} else if($h->type=="add"){$label="success";} else if($h->type=="checkout"){$label="warning blackText";} else if($h->type=="return"){$label="inverse";} else if($h->type=="sold"){$label="success special blackText";} 
      else if($h->type=="demoed"){$label="info special";} else if($h->type=="pickedup"){$label="warning special blackText";} else{$label="info";};?>
<tr>
      <td>{{$h->message}}</td>
      <td>{{date('M-d',strtotime($h->created_at))}}</td>
      <td><span class='label label-{{$label}}'>{{ucfirst($h->type)}}</span></td>
      <td>{{ucfirst($u->firstname)}} {{ucfirst($u->lastname)}}</td>
</tr>
@endforeach 
</table>
</div>
<br/>
@if(!empty($item))
      @if($item->status=="Sold" && $item->sale_id!=0)
      <h4>Sale Details for SKU#: <font color='yellow'> {{$history[0]->attributes['item_id']}}</font> </h4>
      <?php $sale = Sale::find($item->sale_id);?>
      <a href='{{URL::to("reports/sales")}}?startdate={{$item->date_sold}}&enddate={{$item->date_sold}}' target=_blank>
            <button class='pull-right btn btn-default'>VIEW SALE # {{$item->sale_id}}</button>
      </a>
      <span style='color:yellow'>Sold on {{date('M-d',strtotime($item->date_sold))}} by {{$item->sold_by}}</span><br/>
      Sale <span style='color:yellow'>#{{$item->sale_id}}</span> |  {{strtoupper($sale->typeofsale)}}<br/>
      <b>{{$sale->cust_name}}</b><br/>
      {{$sale->lead->address}}<br/>
      <h5>Other Items On Sale : </h5>
      <table class='table table-bordered'>
            <tr>
                  <th>Defenders</th>
                  <th>Majestics</th>
                  <th>Attachments</th>
            </tr>
            <tr>
                  <td>
                        @if($sale->defone!=0)
                        <button title='Click to View This Items History' class='tooltwo btn btn-default btn-mini viewHistory' data-sku='{{Sale::inventorySku($sale->defone)}}'>{{Sale::inventorySku($sale->defone)}}</button>
                        @endif
                        @if($sale->deftwo!=0)
                        <button title='Click to View This Items History' class='tooltwo btn btn-default btn-mini viewHistory' data-sku='{{Sale::inventorySku($sale->deftwo)}}'>{{Sale::inventorySku($sale->deftwo)}}</button>
                        @endif
                        @if($sale->defthree!=0)
                        <button title='Click to View This Items History' class='tooltwo btn btn-default btn-mini viewHistory' data-sku='{{Sale::inventorySku($sale->defthree)}}'>{{Sale::inventorySku($sale->defthree)}}</button>
                        @endif
                        @if($sale->deffour!=0)
                        <button title='Click to View This Items History' class='tooltwo btn btn-default btn-mini viewHistory' data-sku='{{Sale::inventorySku($sale->deffour)}}'>{{Sale::inventorySku($sale->deffour)}}</button>
                        @endif
                  </td>
                  <td>
                        @if($sale->maj!=0)
                        <button title='Click to View This Items History' class='tooltwo btn btn-default btn-mini viewHistory' data-sku='{{Sale::inventorySku($sale->maj)}}'>{{Sale::inventorySku($sale->maj)}}</button>
                        @endif
                        @if($sale->twomaj!=0)
                        <button title='Click to View This Items History' class='tooltwo btn btn-default btn-mini viewHistory' data-sku='{{Sale::inventorySku($sale->twomaj)}}'>{{Sale::inventorySku($sale->twomaj)}}</button>
                        @endif
                        @if($sale->threemaj!=0)
                        <button title='Click to View This Items History' class='tooltwo btn btn-default btn-mini viewHistory' data-sku='{{Sale::inventorySku($sale->threemaj)}}'>{{Sale::inventorySku($sale->threemaj)}}</button>
                        @endif
                  </td>
                  <td>
                        @if($sale->att!=0)
                        <button title='Click to View This Items History' class='tooltwo btn btn-default btn-mini viewHistory' data-sku='{{Sale::inventorySku($sale->att)}}'>{{Sale::inventorySku($sale->att)}}</button>
                        @endif 
                  </td>
            </tr>
      </table>
      @endif
@endif	        		
@else
<h3>No History Available</h3>
<p>The History feature was just recently added, so your old data will not have any history attached to it</p>
<p>But it is recording now and into the future</p>
@endif