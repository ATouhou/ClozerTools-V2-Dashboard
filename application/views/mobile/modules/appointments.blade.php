<?php $html="";$todays="";$mapID="";?>
<?php $setting = Setting::find(1);?>
<?php if(empty($nextapp)){
$html.="<br/><br/>No Appointment Dispatched to You";
}else{
$html.="<div class='special viewItem' data-id='".$nextapp->id."' style='padding-top:20px;'>";
$html.="<b>".$nextapp->lead->cust_name;
if(!empty($nextapp->lead->spouse_name)){
            $html.=" & ".$nextapp->lead->spouse_name;
}
$html.="</b><br>".$nextapp->lead->address."<br>";
if($nextapp->in=='00:00:00'){
    $html.="<button class='button markTIME markIN' data-id='".$nextapp->id."' style='padding:8px;width:95%;background:#A3E0FF;'>CHECK IN</button><br/>";
} else {
    $html.="<br/><b>CHECK IN </b>: ".date('h:i a',strtotime($nextapp->in));
}
if($nextapp->out=='00:00:00' && $nextapp->in!='00:00:00'){
   $html.="<button class='button markTIME markOUT' data-id='".$nextapp->id."' style='padding:8px;width:95%;background:#FF6666;'>CHECK OUT</button><br/>";
} 
if($nextapp->out!='00:00:00'){

    $html.="<br/><b>CHECK OUT </b>: ".date('h:i a',strtotime($nextapp->out));
}
$html.="</div>";
$mapID = $nextapp->lead->id;
};?>

@if(!empty($appts))
@foreach($appts as $a)
    <?php 
    if($a->rep_id!=Auth::user()->id){
        
    } else {
        $todays.="<div class='special viewItem' data-id='".$a->id."' style='padding-top:20px;'>";
        
        $todays.="<b>".$a->lead->cust_name;
        if(!empty($a->lead->spouse_name)){
            $todays.=" & ".$a->lead->spouse_name;
        }
        $todays.="</b><br>".$a->lead->address."<br><br/>";
        $todays.="<span class='label smallText ".$a->status."'>".$a->status."</span>";
        $todays.="</div>";
    }
    ?>
    <?php if($a->in=='00:00:00' && $a->out=='00:00:00'){$in=1;$out=0;}; 
    if($a->in!='00:00:00' && $a->out=='00:00:00' ){$in=0;$out=1;} ;
    if($a->in!='00:00:00' && $a->out!='00:00:00' ){$in=0;$out=0;} ;
    ?>
    <li class='animated fadeInUp {{$a->status}} viewAppt' data-id='{{$a->lead->id}}' data-appid='{{$a->id}}' data-chkin='{{$in}}' data-chkout='{{$out}}'>
        <div class="leftMenu">
            <span style='font-size:14px;font-weight:bold;line-height:10px;'>
                {{$a->lead->cust_name}}
                @if(!empty($a->lead->spouse_name)) & {{$a->lead->spouse_name}} @endif
            </span><br/>
            <span class="smallText">{{$a->lead->address}}</span>
            <br/>
            <span class="smallText"><b>{{$a->lead->cust_num}}</b></span><br/>
            @if($a->rep_id!=0) <span class='smallText' style='color:green'> Disp :<b> {{$a->rep_name}} </b></span> @endif
            <span class='smallText'> 
                @if($a->in!='00:00:00') <br/><b>CHECK IN:</b> {{date('h:i a',strtotime($a->in))}} @endif
                @if($a->out!='00:00:00') <br/><b>CHECK OUT:</b> {{date('h:i a',strtotime($a->out))}} @endif
            </span>
        </div>
        
        <div class='pull-right' style='width:90px;margin-top:-78px;'>
            @if($a->rep_id==Auth::user()->id)
            <span class='label'>{{date('h:i a',strtotime($a->app_time))}}</span>
            @else
            <span class='label'>{{date('h:i a',strtotime($a->app_time))}}</span>
            @endif
            <br/><br/>
            @if($a->status!='SOLD')
            <span class='label {{$a->status}}'>{{$a->status}}</span>
            @else
            <img style='float:right;width:42px;margin-right:20px;' src='{{URL::to_asset("images/")}}pureop-small-{{$a->systemsale}}.png'>
            @endif
        </div>
    </li>
@endforeach
@else
<center><br/><br/>
<h4>There are no appointments for today</h4>
</center>
@endif


<script>
function getMap(id){
    var url = './getappmap/'+id;
    $.getJSON(url,function(data){
        var ico="";
        $.each(data, function(key, data) {

                latLng = new google.maps.LatLng(data.lat, data.lng); 
                if(data.status=="APP"){
                    ico = '/img/pure-op.png';
                    if(data.result=="DNS")  {
                        ico = '/img/app-dns.png';
                    }
                } else if(data.result=="SOLD")  {
                    ico = '/img/app-sale.png';
                } else if(data.result=="DNS")  {
                    ico = '/img/app-dns.png';
                } else if(data.status=="NI")  {
                    ico = '/img/app-dns.png';
                } else if(data.status=="CXL")  {
                    ico = '/img/app-cxl.png';
                } else {
                    ico = '/img/door-regy.png';
                }
            });
        var mapOptions = {
                center: latLng,
                zoom: 13,
                disableDefaultUI: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
        var map = new google.maps.Map(document.getElementById("appMap"),
            mapOptions);
            marker = new google.maps.Marker({
                        position: latLng,
                        title: data.title,
                        icon: ico
            });
            marker.setMap(map);
            map.panBy(-98,-118);
    });
}
$(document).ready(function(){
    $('.yourAppts').html("<?php echo $html;?>");
    $('.todaysDems').html("<?php echo $todays;?>");

    getMap("<?php echo $mapID;?>");

});
</script>