<input type="hidden" id="thisSiteURL" value="{{URL::to('')}}">
<input type="hidden" id="otherSiteURL" value="{{URL::to('')}}">


<div class="row-fluid" style="padding:10px;padding-left:18px;padding-top:25px;">
    <?php if(isset($stats['all'][$user->id])){
            $st = $stats['all'][$user->id];
            $app = $st['appointment'];
        } else {
            $st = array();
            $app = array();
        }
        if(isset($stats['month'][$user->id])){
            $stmonth = $stats['month'][$user->id];
            $appmonth = $stmonth['appointment']; 
        } else {
            $stmonth=array();$appmonth=array();
        }
        if(isset($stats['week'][$user->id])){
            $stweek = $stats['week'][$user->id];
            $appweek = $stweek['appointment'];
        } else {
            $stweek = array();
            $appweek=array();
        }
    ;?>

    <div class="span4" style="border-right:1px solid #ccc;">
        <div class="avatarColumn">
            <img title="Click to upload a new avatar" class='uploadAvatar smallShadow profileAvatar tooltwo' src='{{$user->avatar_link()}}' data-id="{{$user->id}}" >
        </div>
        <div style="width:47%;float:left;margin-left:-15px;" >
            <h2 style="color:#1f1f1f;margin-top:0px;margin-left:0px;">{{ucfirst(strtolower($user->firstname))}} <span style="color:#bbb;">{{ucfirst(strtolower($user->lastname))}}</span></h2>
                <img src='{{URL::to("img/badges/")}}points.png' style='width:45px;margin-bottom:8px;'>
                <span class='tooltwo badge badge-inverse' style='font-size:16px;' title='Put On Demos | 1 Point , SOLD Demo | 5 Points'>{{$user->system_points}} Points</span><br/>
                <img src='{{URL::to("img/badges/")}}bronzecoins.png' style='width:20px;margin-bottom:8px;'>
                <span class='tooltwo badge bronzeCoins ' style='font-size:16px;' title='For every GROSS unit sold | 1 BRONZE'>{{$user->bronze_points}} </span>
                <img src='{{URL::to("img/badges/")}}silvercoins.png' style='width:20px;margin-left:15px;margin-bottom:8px;'>
                <span class='tooltwo badge silverCoins blackText' style='font-size:16px;' title='For every GROSS sale | 1 SILVER'>{{$user->silver_points}} </span>
                <img src='{{URL::to("img/badges/")}}goldcoins.png' style='width:20px;margin-left:15px;margin-bottom:8px;'>
                <span class='tooltwo badge goldCoins blackText' style='font-size:16px;' title='For every GROSS Super, Mega or Nova System sale | 1 GOLD'>{{$user->gold_points}} </span><br/>
            <h4>Address : <br/><b class='blackText'>{{$user->address}}</b></h4>
            <h4>Cell : <b class='blackText'>{{$user->cellNo()}}</b></h4><br/>

                    <!--<div style="margin-top:10px;">
                        <button class='btn btn-mini btn-default switchType' data-type='NET'>NET</button>&nbsp;
                        <button class='btn btn-mini btn-primary switchType' data-type='GROSS'>GROSS</button>
                    </div>-->
        </div>
        <div class="span11" style="margin-left:-4px;">
        
            <div class='profileStat'>
                DEMOS<br/>
                <div class="profileStatNUM  black">
                @if(!empty($app['PUTON']))
                    {{$app['PUTON']}}
                @else
                0
                @endif
                </div>
            </div>
            <div class='profileStat tooltwo' title="Number of leads Entered / Brought In by {{$user->firstname}}">
                LEADS<br/>
                <div class="profileStatNUM  yellow">
                    {{$user->leadsEntered("count")}}
                </div>
            </div>
            <div class='profileStat'>
                SALES<br/>
                <div class="profileStatNUM  green">
                    
                    <span class='stats GROSS'>@if(!empty($st['grosssales'])) {{$st['grosssales']}} @else 0 @endif</span>
                    <span class='stats NET'>@if(!empty($st['netsales'])) {{$st['netsales']}} @else 0 @endif</span>
                   
                </div>
            </div>
            <div class='profileStat'>
                UNITS<br/>
                <div class="profileStatNUM  blue">
                    
                    <span class='stats GROSS'>
                    @if(!empty($st['totgrossunits'])) {{$st['totgrossunits']}} @else 0 @endif
                    </span>
                    <span class='stats NET'>
                    @if(!empty($st['totnetunits'])) {{$st['totnetunits']}} @else 0 @endif
                    </span>
                   
                </div>
            </div>
       
            <div style='float:left;margin-left:28px;margin-top:15px;'>
                
                <span class='bigCount' style='font-size:55px;'>
                @if(!empty($app['CLOSE'])) {{number_format($app['CLOSE'],0,'.','')}} @else 0 @endif 
                <span class='bigCount' style='color:#bbb;'>%</span></span>
                <br/>Close Percent
            </div>
            
        </div>
        <div class="row-fluid">
            <div class="span12" style="margin-top:30px;border-top:1px solid #ccc;padding-top:10px;">
                <div class="span4">
                    <h5>Avg. Time in Demo</h5>
                    <h3 style="color:#000;margin-top:-20px;">{{$charts['averagetime']['avg']}}</h3>
                </div>
                <div class="span4">
                    <h5>Avg. Time in Sale</h5>
                    <h3 style="color:#000;margin-top:-20px;">{{$charts['averagetime']['sold']}}</h3>
                </div>
                
                <div class="span4">
                    <h5 >Avg. Time in DNS</h5>
                    <h3 style="color:#000;margin-top:-20px;">{{$charts['averagetime']['dns']}}</h3>
                </div>
            </div>
        </div>
        <div class=" well" style="float:left;width:96%;margin-left:-3px;background:#ddd;margin-top:20px;">
            @include('games.recentactivity')
        </div>
    </div>


    <div class="span8" style="margin-left:25px;overflow:scroll;height:1050px;">
        <div class="row-fluid borderBottomLight">
            <div class="span12">
                <button class='btn btn-small btn-inverse loadProfile' data-id='{{$user->id}}' data-type="profile">PROFILE / ACHIEVEMENTS</button>
                <button class='btn btn-small btn-default loadProfile' data-id='{{$user->id}}' data-type="viewappointment">APPOINTMENT</button>
                <button class='btn btn-small btn-default loadProfile' data-id='{{$user->id}}' data-type="sales">SALES</button>
                <button class='btn btn-small btn-default loadProfile viewleaderBoards' data-id='{{$user->id}}' data-type="leaderboard">LEADEBOARDS</button>
                @if($user->user_type=="salesrep")
                  <!--<button class='btn btn-small btn-default loadProfile' data-id='{{$user->id}}' data-type="invoices">INVOICES</button>-->
                @endif
                @if($user->user_type=="agent")
                    <button class='btn btn-small btn-default loadProfile' data-id='{{$user->id}}' data-type="calls">CALLS</button>
                @endif
            </div> 
        </div>

        <div class="profile-badges row-fluid"  >
            <div class="span6">
               @include('games.counters')
            </div>
            <div class="span6" >
                @include('games.badges')
            </div>
        </div>

        <div class="profileData row-fluid" id="leaderboardData" style="display:none;width:97%;">
            @include('dashboard.stats.leaderboards')
        </div>
            
        <div class="profileData row-fluid" id="profileData" >  
            <div class="span6" >
                @include('games.trophycase')
            </div>
            <div class="span6" style="padding-right:22px;">
                @include('games.recruits')
            </div>
        </div>

        <div class="profileData row-fluid" id="leaderData" style="display:none;">
            <div class="span7">
            </div>
        </div>



        <div class="profileData row-fluid well" id="viewappointmentData" style="width:95%;display:none;">
            <div id="appStats" class="span12">
            @if(isset($app) && !empty($app))
                <div style='float:left;margin-left:28px;margin-top:15px;'>
                    <span class='bigCount' style='font-size:55px;'>
                    @if(!empty($app['PUTON'])) {{$app['PUTON']}} @else 0 @endif
                    </span>
                    <br/>PUT ON 
                </div>
                <div style='float:left;margin-left:28px;margin-top:15px;'>
                    <span class='bigCount' style='color:#99FF99;font-size:55px;'>
                    @if(!empty($st['grosssales'])) {{$st['grosssales']}} @else 0 @endif
                    </span>
                    <br/>SOLD
                </div>
                <div style='float:left;margin-left:28px;margin-top:15px;'>
                    <span class='bigCount' style='color:#FF6666;font-size:55px;'>
                        @if(!empty($app['DNS'])) {{$app['DNS']}} @else 0 @endif
                    </span>
                    <br/>DNS
                </div>
                <div style='float:left;margin-left:28px;margin-top:15px;'>
                    <span class='bigCount' style='font-size:55px;'>
                        @if(!empty($app['INC'])) {{$app['INC']}} @else 0 @endif
                    </span>
                    <br/>INC
                </div>
              
                <div style='float:left;margin-left:48px;border-left:1px solid #ccc;padding-left:20px;margin-top:15px;'>
                    <span class='bigCount' style='font-size:55px;'>
                        @if(isset($appweek) && !empty($appweek))
                           {{$appweek['PUTON']}}
                        @else
                           0
                        @endif
                    </span>
                    <br/>THIS WEEK
                </div>
                
                <div style='float:left;margin-left:28px;margin-top:15px;'>
                    <span class='bigCount' style='font-size:55px;'>
                        @if(isset($appmonth) && !empty($appmonth))
                            {{$appmonth['PUTON']}}
                        @else
                            0
                        @endif
                    </span>
                    <br/>THIS MONTH
                </div>
            @endif
            </div>  
            <div id="viewappointment">
                <div id="theMap" class="medShadow span12" style="margin-top:20px;height:590px;background:#fff;">
                    <img src='{{URL::to("img/loaders/misc/100.gif")}}'>
                </div>
                <div id="theAppts" class="span6" >
                
                    <ul class="leaderBoardList">
                    </ul>
                </div>
            </div>
        </div>

        <div class="profileData row-fluid" id="salesData" style="display:none;">
            <div class="span6" style="margin-top:20px;">
            <?php $breakdown = Sale::saleBreakdown($user->id);?>
            @include('games.machinesales')
            @if(!empty($breakdown))
            @foreach($breakdown as $b)
                <h4>{{$b->status}} Deals</h4>
                <div class='well' style='width:97%;float:left;margin-bottom:20px;'>
                  
                    <div style='float:left;margin-left:28px;margin-top:15px;'>
                      <span class='bigCount' style='font-size:55px;'>
                        {{number_format(($b->finance/$b->cnt)*100,0,'.','')}}
                        <span class='bigCount' style='color:#bbb;'>%</span>
                      </span>
                      <br/>Finance Deals : {{$b->finance}}<br/>
                      1st Line: {{$b->first_line}} &nbsp;&nbsp;|&nbsp;&nbsp;2nd Line: {{$b->second_line}}<br/>
                    </div>
                    <div style='float:left;margin-left:28px;margin-top:15px;'>
                      <span class='bigCount' style='font-size:55px;'>
                        {{number_format(($b->creditcard/$b->cnt)*100,0,'.','')}}
                        <span class='bigCount' style='color:#bbb;'>%</span>
                      </span>
                      <br/>Credit Card : {{$b->creditcard}}<br/>
                     
                    </div>
                    <div style='float:left;margin-left:28px;margin-top:15px;'>
                      <span class='bigCount' style='font-size:55px;'>
                        {{number_format(($b->chq/$b->cnt)*100,0,'.','')}}
                        <span class='bigCount' style='color:#bbb;'>%</span>
                      </span>
                      <br/>Cheque : {{$b->chq}}
                    </div>
                </div>
            @endforeach
            @endif
            </div>
            <div id="theSales" class="span6" style="height:700px;overflow:scroll;padding:10px;" >
                @if(!empty($sales))
                <h5>{{$user->profileName()}} Sales</h5>
                <ul class="leaderBoardList" style='margin-left:-10px;width:101%;'>
                <?php $sales = $user->sales;?>
                @foreach($sales as $s)
                    <li class="saleRow {{$s->pay_type}}" style='background:white;'>
                    <div style='margin-top:10px;float:left;margin-right:10px;'>
                      <span class='tooltwo sale-{{$s->status}} bigCount' title='{{$s->status}}'>{{$s->id}}</span>
                    </div>
                    <b>{{$s->cust_name}}</b><br/>
                    @if(!empty($s->lead->address))
                    <span class='smallText'>{{substr($s->lead->address,0,40)}}</span>
                    @else
                    ...
                    @endif
                    <div style='float:right;margin-top:-15px;'>
                      <img class='tooltwo' title='Paid with {{strtoupper($s->payment)}}' src="{{URL::to('images/')}}payment-{{strtolower($s->payment)}}.png" style='width:77px;margin-right:10px;'>
                      <img class='tooltwo' title='{{strtoupper($s->typeofsale)}}' src='{{URL::to("images/pureop-small-")}}{{$s->typeofsale}}.png' style='width:35px;'>
                    </div>
                    </li>
                @endforeach

                </ul>
                @else

                @endif
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function(){
    $('.tooltwo').tooltipster();
 
   

    $('.loadProfile').click(function(){
        $('.loadProfile').removeClass('btn-inverse');
        $(this).addClass('btn-inverse');
        var site = $(this).data('type');
        var id = $(this).data('id');
        $('.profileData').hide();
        if(site=="profile"){
            $('#'+site+'Data').show();
            $('.profile-badges').show(200);
        } else {
            $('.profile-badges').fadeOut(200);
            $('#'+site+'Data').show();
            if(site=="viewappointment"){
                getMap();
            } else {
                $('#'+site).load("{{URL::to('presentation/')}}"+site+"/"+id).show();
            }
        }
    });
  
    $('.NET').hide();
    
    $('.switchType').click(function(){

        $('.switchType').removeClass('btn-inverse');
        $(this).addClass('btn-inverse');
        var type = $(this).html();
        $('.stats').hide();
        $('.bigSTATS').hide();
        $('#counter-'+type).show();
        $('.'+type).show();
    });

    

    var user_id = "{{$user->id}}";
    var roadAtlasStyles = [
              {
                  "featureType": "road.highway",
                  "elementType": "geometry",
                  "stylers": [
                    { "saturation": -100 },
                    { "lightness": -8 },
                    { "gamma": 1.18 }
                  ]
              }, {
                  "featureType": "road.arterial",
                  "elementType": "geometry",
                  "stylers": [
                    { "saturation": -100 },
                    { "gamma": 1 },
                    { "lightness": -24 }
                  ]
              }, {
                  "featureType": "poi",
                  "elementType": "geometry",
                  "stylers": [
                    { "saturation": -100 }
                  ]
              }, {
                  "featureType": "administrative",
                  "stylers": [
                    { "saturation": -100 }
                  ]
              }, {
                  "featureType": "transit",
                  "stylers": [
                    { "saturation": -100 }
                  ]
              }, {
                  "featureType": "water",
                  "elementType": "geometry.fill",
                  "stylers": [
                    { "saturation": -100 }
                  ]
              }, {
                  "featureType": "road",
                  "stylers": [
                    { "saturation": -100 }
                  ]
              }, {
                  "featureType": "administrative",
                  "stylers": [
                    { "saturation": -100 }
                  ]
              }, {
                  "featureType": "landscape",
                  "stylers": [
                    { "saturation": -100 }
                  ]
              }, {
                  "featureType": "poi",
                  "stylers": [
                    { "saturation": -100 }
                  ]
              }, {
              }
            ]
        function getMap(){
                $.getJSON('{{URL::to("presentation/viewappointment")}}/'+user_id,function(data){
                    $("#theMap").gmap3({
                      marker:{
                        values: data.map,
                        options:{
                         draggable:false,
                        },
                        events:{
                          mouseover: function(marker, event, context){
                            var map = $(this).gmap3("get"),
                              infowindow = $(this).gmap3({get:{name:"infowindow"}});
                            if (infowindow){
                              infowindow.open(map, marker);
                              infowindow.setContent(context.data);
                            } else {
                              $(this).gmap3({
                                infowindow:{
                                  anchor:marker, 
                                  options:{content: context.data}
                                }
                              });
                            }
                          },
                          mouseout: function(){
                            var infowindow = $(this).gmap3({get:{name:"infowindow"}});
                            if (infowindow){
                              infowindow.close();
                            }
                          },
                        }
                      },
                      map:{
                        options:{
                          zoom: 8,
                            center: new google.maps.LatLng(data.latlng[0],data.latlng[1]),
                            mapTypeId: google.maps.MapTypeId.HYBRID,
                            mapTypeControl: true,
                            mapTypeControlOptions: {
                                mapTypeIds: [google.maps.MapTypeId.HYBRID, "style1"]
                            },
                            navigationControl: true,
                            scrollwheel: true,
                            streetViewControl: true
                         }
                      },styledmaptype:{
                      id: "style1",
                      options:{
                        name: "Style 1"
                      },
                      styles: roadAtlasStyles
                    }
                  
                    }); 

                setTimeout(function(){
                    var map = $("#theMap").gmap3("get");
                    map.setZoom(9);
                },1000);
            }); 
        }
});
</script>