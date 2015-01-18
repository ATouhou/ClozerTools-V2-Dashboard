                         <?php $bookerleads = User::bookerleads();?>
                        @if(!empty($bookerleads))
                        <div class="span11" style="margin-top:15px;padding-top:10px;">
                        <h5>ASSIGNED LEADS</h5>
                        <table class="table table-bordered table-condensed " style="float:left;border:1px solid #1f1f1f;" >
                            <thead>
                                <th width:40%;>Booker</th>
                                <th>Assigned</th>
                                <th>Exp. Contact</th>
                                <th>City</th>
                                <th>Leadtype</th>
                            </thead>
                            <tbody class=''>
                                @foreach($bookerleads as $val)
                                @if($val->booker_name!="")
                                @if($val->tot!=0)
                                <tr>
                                    <td><a href="{{URL::to('users/profile/')}}{{$val->booker_id}}"<button class="btn btn-primary btn-mini">Profile</button></a>&nbsp;<span class='small'>{{$val->booker_name}}</span></td>
                                    <td><center><span class='label label-info special'>{{$val->tot}}</span></td>
                                    <td><center>
                                    <?php $exp = Stats::expClose($val->booker_id, $val->city, $val->tot);
                                    if($exp<=5){$l = "important";} else if($exp>5 && $exp<10){$l="info";}else{$l="success blackText";};?>
                                       <span class="label label-{{$l}} special tooltwo " title="Expected contact rate for these leads, based on historical stats of booker, and city"> {{$exp}} </span>
                                       </center>
                                    </td>
                                    <td><span class='small'>{{strtoupper($val->city)}}</span></td>
                                    <td><span class="small">{{strtoupper($val->leadtype)}}</span></td>
                                </tr>
                                @endif
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @endif