<!-- new mail ticker -->
                                <?php $chatsystem = User::where('logged','!=','0')->where('id','!=',Auth::user()->id)->get();
                                $mymsgs = User::find(Auth::user()->id)->recmessages()->where('status','=','unseen')->get();?>
                               <a href="javascript:void(0)" class="btn btn-small btn-inverse dropdown-toggle" data-toggle="dropdown">
                                    @if(!empty($mymsgs))
                                    <span class="mail-sticker">{{count($mymsgs)}}</span>
                                    @endif
                                    <i class="cus-email"></i>
                                </a>
                                <!-- email lists -->
                               
                                <div class="dropdown-menu toolbar pull-right">
                                    <h3>Inbox</h3>
                                    <!-- "mailbox-slimscroll-js" identifier is used with Slimscroll.js plugin -->
                                    <ul id="mailbox-slimscroll-js" class="mailbox">
                                        @foreach($mymsgs as $val)
                                        <li>
                                            <a href="{{URL::to('chat/assigntab')}}/{{$val->sender_id}}" class="unread">
                                                <img src="img/email-unread.png" alt="important mail">
                                                From: {{User::find($val->sender_id)->firstname}}
                                                <i class="icon-paper-clip"></i>
                                                <span>{{$val->msg_body}}</span>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{URL::to('chat')}}" id="go-to-inbox">Go to Inbox <i class="icon-double-angle-right"></i></a>
                                </div>
                                <!-- end email lists -->