@layout('layouts/main')
@section('content')

<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- aside -->  
        <aside> 
            @render('layouts.managernav')
        </aside>
        <!-- aside end -->
                
        <!-- main content -->
        <div id="page-content">
            <h1 id="page-header">Gifts Assigned To Cities<br/><br/>
                <div class="fluid-container">
                        <!-- widget grid -->
                        <section id="widget-grid" class="">
                        	
                            <div class="row-fluid" id="quadrants">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>CITY LEAD GIFT MANAGER<h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <table class="table table-striped table-bordered responsive"  >
                                                    <thead>
                                                        <tr align="center">
    														<th>City / Area Name</th>
                                                            <th colspan=4>Gifts</th>                     	                                    
														</tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($cities as $val)
                                                    @if($val->status=="active")
                                                    <tr id="cityrow-{{$val->id}}">
                                                        
                                                     	<td class="span3">{{$val->cityname}}<br/><a href="{{URL::to('cities/deactivate/')}}{{$val->id}}"><button class="btn btn-mini btn-danger">DE-ACTIVATE</button></a></td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_one|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_one) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_two|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_two) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_three|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_three) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_four|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_four) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
													 	
														
                                                   	</tr>
                                                    @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                    </div>
                                    <!-- end widget -->
                                </article>
                        </div>
                        <h1 id="page-header">Gifts Assigned To Leadtypes<br/><br/>
                        <div class="row-fluid" id="quadrants">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>LEADTYPE GIFT MANAGER<h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                       
                                            <div class="inner-spacer"> 
                                                <table class="table table-striped table-bordered responsive"  >
                                                    <thead>
                                                        <tr align="center">
                                                            <th>Leadtype</th>
                                                            <th colspan=4>Gifts</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($leadtypes as $val)

                                                    <tr id="cityrow-{{$val->id}}">
                                                        
                                                        <td class="span3">{{ucfirst($val->cityname)}}</td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_one|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_one) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_two|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_two) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_three|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_three) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="span2">
                                                            <select style="width:100%" class="gift" id="gift_four|{{$val->id}}">
                                                                <option value=''></option>
                                                                @foreach($gifts as $val2)
                                                                <option value='{{$val2->id}}' @if($val2->id==$val->gift_four) selected='selected'  @endif>{{$val2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                    </div>
                                 
                                </article>
                        </div>
                         <div class="row-fluid">
                                    <div class="span8" style="margin-bottom:30px;">
                                        <h4>Click a City Name to activate it</h4>
                                        
                                        @foreach($cities as $val)
                                            @if($val->status=="retired")
                                            <a href="{{URL::to('cities/activate')}}/{{$val->id}}"><button class="btn btn-defaault" style="margin-top:10px;">{{$val->cityname}}</button></a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                    <!-- end widget -->
						       
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
});
</script>
@endsection