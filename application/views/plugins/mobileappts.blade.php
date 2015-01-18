
<h2>Appointments for {{date('D M-d')}}</h2>
<button class="button viewappts" data-id="{{Auth::user()->id}}">VIEW ONLY YOUR APPOINTMENTS</button><br/><br/>
                    	<ul class="list" id="apptList">
                     	@foreach($appts as $v)
                     		<li class="{{$v->status}} appList rep-{{$v->rep_id}}"  style="border-bottom:2px solid #1f1f1f;">
                     		<a href="#appmap" class="appts rep-{{$v->rep_id}}" data-apptid="{{$v->id}}" data-rep="{{$v->rep_id}}" data-id="{{Auth::user()->id}}" >
                     			<span class="label label-time">{{date('h:i a', strtotime($v->app_time))}}</span>
                     			<span class="label label-name">{{$v->lead->cust_name}}</span>
                     			<span class="label label-number">{{$v->lead->cust_num}}</span>
                     			<br/><br/>
                     			<span style="font-size:12px;color:#000"><b>{{$v->lead->address}}</b></span><br/><br/>
                     			Dispatched To : <span id="rep-{{$v->id}}" class="label label-dispatch">{{$v->rep_name}}</span>
                     			<span id="status-{{$v->id}}" class="status">{{$v->status}}</span>
                     			</a>
                     		</li>
                     	@endforeach
                    	</ul>
              