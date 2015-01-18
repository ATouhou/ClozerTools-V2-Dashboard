@layout('layouts/main')
@section('content')


<?php $set = Setting::find(1);?>
<style>
#addnewagent {display:none;}
.script{display:none;}
.showScript {padding:3px!important;}
</style>

<div class="modal hide fade" id="scriptbatch_modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Create New Script Batch</h3>
    </div>
    <div class="modal-body">
            <form id="createScripts" action="{{URL::to('scripts/createbatch')}}">
                    <input type="text" name="batch_name" value="" placeholder="Enter Batch Name" />
                    <button class="btn btn-default" style="margin-top:-8px;">ADD</button>
            </form>
    </div>
</div>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- aside -->  
        <aside> 
            @render('layouts.managernav')
        </aside>
        <!-- aside end -->
                
        <!-- main content -->
        <div id="page-content">
            <h1 id="page-header">Booker Scripts</h1>   
                <div class="fluid-container">
                    
							<h4>Instructions</h4>
							
							Use the following formatting conventions to display relevant data inside the script.<br/><br/>
							Display Marketers Name : <b>[[NAME]]</b><br>
							Display the Customer Name : <b>[[CUSTNAME]]</b><br>
                            Display the Address : <b>[[ADDRESS]]</b><br>
                            Display the Spouse Name : <b>[[SPOUSENAME]]</b><br>
                            Display All Gifts with Descriptions  : <b>[[GIFTS]]</b><br>
                            Display chosen gift : <b>[[CHOSEN-GIFT]]</b><br/>
                            <br/>
                            Example :<br/>
                            <b>Hello [[CUSTNAME]], You live at [[ADDRESS]]</b><br>
                            Will display...<br/>
                            <b>Hello Julia, You live at 123 Test Address, CA</b>
							</p>
							
                        <!-- start icons -->
                        
                        <div id="start">
                            <h3>Viewing <span class='scriptType'> Default </span> Scripts</h3><br/>
                            <select name="changeScripts" id="changeScripts" style="margin-top:-10px;">
                                @if(!empty($batch))
                                    @foreach($batch as $b)
                                    <?php if($b->title=="Default"){$b->id = 0; $id=0;};?>
                                    <option value="{{$b->id}}">{{$b->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <br/>
                            <button class='btn btn-default btn-small createNewScripts'>CREATE NEW BATCH</button>
                            <!--<button class="btn btn-danger btn-small deleteBatch">DELETE BATCH</button>-->
                            <br/>

                            <ul style="margin-top:20px;">
                                @if($set->lead_survey==1)
                                <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="survey" title="">
                                        <button class="btn btn-small btn-primary">SURVEY SCRIPT</button>
                                   </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="bookrightnow" title="">
                                        <button class="btn btn-small btn-primary">BOOK RIGHT NOW SCRIPT</button>
                                   </a>
                                </li>
                                @endif
                                @if($set->lead_paper==1 || $set->lead_secondtier==1)
                                <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="booking" title="">
                                        <button class="btn btn-small btn-primary">BOOKING SCRIPT</button>
                                   </a>
                                </li>
                                @endif
                               @if($set->lead_door==1)
                                <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="door" title="">
                                        <button class="btn btn-small btn-primary">DOOR REGY SCRIPT</button>
                                   </a>
                                </li>
                                @endif
                                @if($set->lead_scratch==1)
                                <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="scratch" title="">
                                        <button class="btn btn-small btn-primary">SCRATCH SCRIPT</button>
                                   </a>
                                </li>
                                @endif
                                <br/>
                                @if($set->lead_finalnotice==1)
                                <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="finalnotice" title="">
                                        <button class="btn btn-small btn-primary">FINAL NOTICE SCRIPT</button>
                                   </a>
                                </li>
                                @endif
                                @if($set->lead_homeshow==1)
                                <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="homeshow" title="">
                                        <button class="btn btn-small btn-primary">HOMESHOW SCRIPT</button>
                                   </a>
                                </li>
                                @endif
                                @if($set->lead_ballot==1)
                                <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="ballot" title="">
                                        <button class="btn btn-small btn-primary">BALLOT BOX SCRIPT</button>
                                   </a>
                                </li>
                                @endif
                                @if($set->lead_referral==1)
                                <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="referral" title="">
                                        <button class="btn btn-small btn-primary">REFERRAL SCRIPT</button>
                                   </a>
                                </li>
                                @endif
                                
                                 <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="rebook" title="">
                                        <button class="btn btn-small btn-primary">REBOOK SCRIPT</button>
                                   </a>
                                </li>
                             
                                  <li>
                                    <a href="javascript:void(0)" class="showScript" data-script="{{$id}}" data-type="confirmation" title="">
                                        <button class="btn btn-small btn-primary">CONFIRMATION SCRIPT</button>
                                   </a>
                                </li>
                              
                            </ul>
                        </div>   

                        <!-- widget grid -->
                        <section id="widget-grid" class="">
                            <article class="span12" style="margin-bottom:80px;">
                            @foreach($batch as $b)

							@foreach($scripts as $val)
                            @if($val->batch_id==$b->id)
							<div id="{{$val->type}}-{{$b->id}}" class="script">
							<h4 >{{$val->title}} ({{$b->title}})</h4>
								  <form method="post" action="{{URL::to('scripts/save')}}">
                                <div class="controls" style="margin-bottom:40px;">
										<input type="hidden" id="thescriptid" name="thescriptid"  value="{{$val->id}}"/></input>
                                 <textarea class="span7" rows=20 name="script" />{{str_replace("<br />", "", $val->script)}}</textarea>
								 <br>
								     <button class="btn btn-primary btn-large save-script" data-id="{{$val->id}}">SAVE</button>
                                </div>
                            </form>
							</div>
                            @endif
							@endforeach
                            
                            @endforeach
                        </article>
                        </section>

                        
                    <!-- end widget grid -->
                </div>      
        </div>
        <!-- end main content -->
            
        <!-- aside right on high res -->
        <aside class="right">
        @render('layouts.chat')
        <div class="divider"></div>
        <!-- date picker -->
      
        </aside>
              
    </div>
            
</div>


<script>
$(document).ready(function(){
$('#scriptmenu').addClass('expanded');

    $(document).on('click','.showScript',function(){
        $('.script').hide();
        var type = $(this).data('type')+"-"+$(this).data('script');
        $('#'+type).show();
    });

    $('.createNewScripts').click(function(){
        $('#scriptbatch_modal').modal({backdrop:'static'});

    });
   

    $('#changeScripts').change(function(){
        var script = $(this).val();
        $('.script').hide();
        $('.showScript').each(function(){
            $(this).data('script',script);
        });
    });


});
</script>


@endsection