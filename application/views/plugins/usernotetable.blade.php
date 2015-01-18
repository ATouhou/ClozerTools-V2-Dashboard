
<div class="row-fluid employeeNotes" style="display:none;">
        <div class="span12" style='padding:30px;'>
            <button class='btn btn-default addUserNote' data-userid="{{$user->id}}"><i class='cus-note'></i>&nbsp;&nbsp;ADD A NEW NOTE / COMMENT</button><br/><br/>
            

            <table class='table table-condensed table-bordered'>
                <tr>
                    <th>Entered By</th>
                    <th style="width:60%;">Comment / Note</th>
                    <th>Date Entered</th>
                    <th>Delete</th>
                </tr>
                <tbody class='user-note-table'>
                @foreach($notes as $n)
                <tr id='userNoteRow-{{$n->id}}'>
                    <td>{{User::find($n->sender_id)->firstname}} {{User::find($n->sender_id)->lastname}}</td>
                    <td>{{$n->body}}</td>
                    <td>{{date('Y-m-d',strtotime($n->created_at))}}</td>
                    <td><button class='btn btn-mini btn-danger deleteUserNote' data-id='{{$n->id}}'>X</button></td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <br/><br/>

           
        </div>
    </div>