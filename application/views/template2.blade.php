@layout('layouts/main')
@section('content')
<style>

</style>
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
        <div id="page-content">
            <h1 id="page-header">Template</h1>   
                <div class="fluid-container">
                    <?php $c=0;?>
                    @foreach($leads as $val)
               <?php $c++;
                $l = DB::query("SELECT id,cust_num,researcher_name,status,leadtype,original_leadtype,entry_date FROM leads WHERE researcher_name = 'Upload/Manilla' AND cust_num = '".$val->cust_num."'");
               
                if($l){
                    echo "<br/><strong>Duplicate #</strong>".$c."<br>";
                foreach($l as $v){
                    echo "<div id='lead-".$v->id."'>ID#".$v->id." | ".$v->cust_num." | Researcher : ".$v->researcher_name." | Upload Date :  ".$v->entry_date." | Leadtype : ".$v->leadtype." | Status : ".$v->status."<button class='deleteLead' data-id='".$v->id."'>DELETE</button><br></div>";
                }};?>
            @endforeach

            

                </div>    
            <aside class="right">
 
            </aside>
        </div>
    </div>
</div>
<div class="push"></div>
<script>
$(document).ready(function() {

$('.deleteLead').click(function(){
    var id=$(this).data('id');
        var url = "{{URL::to('lead/delete/')}}"+id;
            $.getJSON(url, function(data) {
                if(data=="sale"){
                    toastr.error('Lead cannot be deleted', 'Lead has a SALE attached');
                } else if(data=="app"){
                    toastr.error('Lead cannot be deleted', 'Lead has an APPOINTMENT attached');
                } else {
                    $('#lead-'+id).hide(200);
                    toastr.success('Lead Sucessfully Removed', 'Lead Deleted');
                }
            });
    
});

});
</script>

@endsection