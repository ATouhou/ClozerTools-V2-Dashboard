@layout('layouts/main')
@section('content')
<div class="modal hide fade" id="upload_file">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Upload New File</h3>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ URL::to('util/uploadfile') }}" id="upload_file_form" enctype="multipart/form-data">
            <label for="File">Upload File</label>
            <input type="hidden" id="the_folder" name="the_folder"/>
          
            <input type="file" placeholder="Choose a document to upload" name="theDoc" id="theDoc" /><br/><br/>
            <label for="File">Enter Optional Name </label><span class='small'>(if empty, filename will be used as the name)</span><br/>
            <input type="text" placeholder="Alternative Name" name="theName" id="theName" /><br>
            <label for="Notes">Optional Notes : </label>
            <textarea name="theNotes" id="theNotes" ></textarea>
            
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <button type="button" onclick="$('#upload_file_form').submit();" class="btn btn-primary uploadFileButton">Upload New Document</button>
    </div>
</div>

<div class="modal hide fade" id="move_file">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Move File to Another Folder</h3>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ URL::to('util/movefile') }}" id="move_file_form" enctype="multipart/form-data">
        <input type="hidden" name="movefile_id" id="movefile_id" value=""/>
            <label for="File">Move to Folder</label>
            <select name="moveto_folder">
            @foreach($folders as $f)
            <option value="{{$f}}">{{ucfirst(strtolower($f))}}</option>
            @endforeach
            </select>
            
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <button type="button" onclick="$('#move_file_form').submit();" class="btn btn-primary uploadFileButton">Move File</button>
    </div>
</div>


<div id="main" role="main" class="container-fluid">

    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
                
        <!-- main content -->
        <div id="page-content">
            <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;File Manager
            <button class="pull-right btn btn-default bordBut addCity" style="margin-right:5px;" onclick="$('#addfolder').toggle(200);"><i class='cus-add'></i>&nbsp;&nbsp;ADD NEW FOLDER </button>
            </h1>   
            
            <div class="row-fluid" style="margin-top:-20px;">

            <article class="span4 well" id="addfolder" style="display:none;">
                <h4>Add a New Folder</h4>
                 <form class="form-horizontal themed" id="newcity" method="post" style="margin-left:15px;" action="{{URL::to('util/addnewfilefolder')}}">
                    <label>Folder Name :
                        <input type="text" name="file_folder" id="file_folder" />
                    </label>
                    
                    <button title="" class="btn btn-primary" style="margin-top:10px;margin-top:20px;margin-bottom:20px">ADD FOLDER </button>
                </form>
            </article>
            </div>
 
            <div class="fluid-container">
                @if(Session::has('exists'))
                <h3 style='color:red;margin-left:10px;' class='animated fadeInUp'>Folder name already exists, please try another name</h3>
                @endif
                @foreach($folders as $f)
                <div  class="span12 well">
                    <h3>{{ucfirst(strtolower($f))}} Folder <button class='pull-right btn btn-danger deleteFolder' data-folder='{{$f}}'>DELETE</button>&nbsp;&nbsp;<button class='pull-right btn btn-purps uploadNewFile' style='margin-right:5px;' data-folder='{{$f}}'>UPLOAD FILE TO FOLDER</button>&nbsp;&nbsp;</h3>
                    @foreach($files as $file)
                        @if($file->file_folder==$f)
                            <div id="doc-{{$file->id}}" class='span2 well'>
                            <?php  if($file->filetype=="pdf"){
                                       $img="pdf.png";
                                    } else if($file->filetype=="jpg") {
                                       $img = "jpeg.png";
                                    } else if($file->filetype=="jpeg") {
                                       $img = "jpeg.png";
                                    } else {
                                       $img="file.png";
                                    };?>
                                <a href='https://s3.amazonaws.com/salesdash/{{$file->uri}}' target=_blank><img src='{{URL::to('images/')}}{{$img}}' style='border:0px;' width=80px /><br/>
                                <span class='small'>{{substr($file->filename,0,20)}}<br/>{{$file->filesize}} kb</span></a>
                                <br/>
                                <a class='btn btn-purps btn-mini' href='https://s3.amazonaws.com/salesdash/{{$file->uri}}' target=_blank>&nbsp;VIEW</a>&nbsp;&nbsp;
                                @if(count($folders)>1)
                                <div class='btn btn-yells btn-mini moveFile' data-id="{{$file->id}}" >MOVE</div><br/>
                                @endif
                                <div class='btn btn-danger btn-mini delImage' style='margin-top:5px;' data-id='{{$file->id}}'>X</div><br/>


                            </div>
                        @endif
                    @endforeach
                </div>
                @endforeach
            </div>
        <!-- end main content -->
            
        <!-- aside right on high res -->
        <aside class="right">
            @render('layouts.chat')
            <div class="divider"></div>
        </aside>

    </div>
</div>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
$('#utilmenu').addClass('expanded');

$('.uploadNewFile').click(function(){
    var folder = $(this).data('folder');
    $('#the_folder').val(folder);
    $('#upload_file').modal({backdrop: 'static'});
});

$('.deleteFolder').click(function(){
    var folder = $(this).data('folder');
    var t = confirm("Are you sure?? If you delete a folder with files in it, they will all be moved to the Default folder");
    if(t){
        $.post("{{URL::to('util/deletefolder')}}",{foldername:folder},function(data){
            if(data=="isdefault"){
                 toastr.warning("Cannot remove default folder");
            } else if(data=="success"){
                toastr.success("Folder Removed Successfully");
                setTimeout(function(){location.reload();},800)
            } else {
                toastr.error("There was an error deleting this folder.  Contact Admin for Help");
            }
        });
    }

});

$('.moveFile').click(function(){
    var file = $(this).data('id');
    $('#movefile_id').val(file);
    $('#move_file').modal({backdrop: 'static'});
});


$('.edit').editable('{{URL::to("cities/edit")}}',{
    indicator : 'Saving...',
    tooltip   : 'Click to edit City Name',
    submit  : 'OK',
    placeholder: '....',
    width     : '100',
    height    : '25',
    callback: function(value,settings){
        console.log(value);
    }
});






});
</script>
@endsection