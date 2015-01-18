$(document).ready(function(){

	$(document).on('click','.viewCalls',function(){
		var id = $(this).data('id');
		$('.expandInfo').hide();
		$('.callCount-'+id).toggle();
	});

	$(document).on('click','.viewAppHistory',function(){
		var id = $(this).data('id');
		$('.expandInfo').hide();
		$('.appHistory-'+id).show();
	});

	$(document).on('click','.viewTheAddress',function(){
		var lat = $(this).data('lat');
		var lng = $(this).data('lng');
		var address = $(this).data('address');
		console.log(address);
		$('#sideMap').show(200);
		setTimeout(function(){


		$("#side-map").gmap3({
    			getlatlng: {
        		address: address,
        		callback: function(result){
            	if(result) {
                	var i = 0;
                	$.each(result[0].geometry.location, function(index, value) {
                    if(i == 0) { lat = value; }
                    if(i == 1) { lng = value; }
                    i++;
                });
                $("#side-map").gmap3({
                   	marker: {
                        address: address,
                        options: {
                            draggable: false,
                            icon:new google.maps.MarkerImage("{{URL::to('img/app-app.png')}}"),
                            optimized: false,
                            animation: google.maps.Animation.DROP
                        }
                    },
                    map:{
                        options:{
                            center:new google.maps.LatLng(lat, lng),
                            zoom: 16
                        }
                    }
                });

            }
        }
    	}
	});
},500);
});

	$('#side-map-close').click(function(){
		$('#sideMap').hide(400)
	});

  		$('.tooltwo').tooltipster({
   			fixedWidth: 20
   		});

		$('.uploadAvatar').click(function(){
			$('#avatarID').val($(this).data('id'));
			$('#upload_modal_avatar').modal({backdrop: 'static'});
		});

		$('.viewApptNeeded').click(function(){
			$('#apptsNeededModal').load('{{URL::to('appointment/needed/json')}}');
			$('#needed_modal').modal({backdrop: 'static'});
		});
		

    		$(".sysalerts").load("{{URL::to('chat/alertsystem')}}");
    		
    		var refreshId = setInterval(function() {
    		    $(".sysalerts").load("{{URL::to('chat/alertsystem')}}");
    		}, 25000);

    		$.ajaxSetup({ cache: false });

    		$('.sysmsgclose').live('click',function(){
    			var id = $(this).data('id');
    			$.post("{{URL::to('chat/delalert')}}", { alert_id: id}).done(function(data) {
      			var dat = JSON.parse(data);
    				if(dat.type=="success"){ 
    					toastr.success('', dat.msg);} else if(dat.type=="warning"){
    					toastr.warning('',dat.msg);}
   				});
    		});
		
		$('.LeadManager').click(function(){
			$('.ajax-heading').html("Loading Leads...");
			$('.ajaxWait').show();
		});


		$(".leadSearch").keyup(function(e) {
		if(e.keyCode == 13)
    			{
        			var val = $(this).val();
				$('#leadViewer').show().html("<center><img src='{{URL::to('img/loaders/misc/100.gif')}}'></center>");
				$('#leadViewer').load('{{URL::to('lead/search')}}',{searchleads:val,skip:0,take:15});
				window.scrollTo(0,0)
    			}
		});

		$(document).on('click','.paginateLeads',function(){
			var script = $(this).data('script');
			var srch = $(this).data('search');
			var skip = $(this).data('skip');
			var take = $(this).data('take');
			var city = $(this).data('city');
			var type = $(this).data('type');
			window.scrollTo(0,0);
			if(script=="search"){
				$('#leadViewer').load('{{URL::to('lead/')}}'+script,{searchleads:srch,skip:skip,take:take});
			} else {
				$('#leadViewer').load('{{URL::to('lead/')}}'+script,{city:city,type:type,skip:skip,take:take});
			}
			
		});

		$(document).on('click','.backToScreen',function(){
			$('#leadViewer').hide(200);
		});



		$('.newLead').click(function(){	
			$('#lead_edit_modal').modal({backdrop: 'static'});
		});

		

		$('body').on('click','.uploadDoc',function(){
			var id = $(this).data('id');
			var lid = $(this).data('lid');
			$('#theID').val(id);
			$('#leadID').val(lid);
			$('#upload_doc').modal({backdrop: 'static'});
		});

$('body').on('click','.viewDoc',function(){
var id = $(this).data('id');
var name = $(this).data('name');
var type = $(this).data('type');

	$.getJSON('{{URL::to("sales")}}/viewdocs/'+id,function(data){
		html = "";
		$('.sale_id').html("#"+id+" - "+name+" ( Purchased : "+type+")");
			$.each(data,function(i,val){
				var d = val.attributes;
				html+="<div class='span1 imagebox' id='doc-"+d.id+"'>";
				html+="<img src='https://s3.amazonaws.com/salesdash/"+d.uri+"' width=80px /><br/><span class='small'>"+d.filename+"</span>";
				html+="<br/><a class='btn btn-primary btn-mini' href='https://s3.amazonaws.com/salesdash/"+d.uri+"' target=_blank>&nbsp;VIEW</a>&nbsp;&nbsp;<div class='btn btn-danger btn-mini delImage' data-id='"+d.id+"'>X</div></div>";
			});
		$('#viewfiles_doc').modal({backdrop: 'static'});
		$('#viewfiles_body').html(html);
	});
	
});


$('body').on('click','.delImage',function(data){
var t = confirm('Are you sure you want to delete this file???');
	if(t){
		var id = $(this).data('id');
		$.get('{{URL::to("sales")}}/delDocument/'+id, function(data){
				if(data=="success"){
					$('#doc-'+id).remove();
					toastr.success('File Removed','DELETE SUCCESFUL');
				} else if(data=="notauth") {
					toastr.warning('You cannot delete a file you didnt upload','ERROR!');
				} else if(data=="failed") {
					toastr.error('Deleting file failed!','FAILED TO REMOVE FILE');
				}
			if($('#viewfiles_body').children().size()==0){
				$('#viewfiles_doc').modal('hide');}
		});
	}
});





	});