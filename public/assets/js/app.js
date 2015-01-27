var APIlink = {
	"MAINURL":"http://127.0.0.1/",
	// Appointment links
	"appointments" : {"link":"appointment","title":"Appointments"},
	// Lead links
	"leads" : {"link":"lead","title":"Assign Leads"},
	"manageleads" : {"link":"lead","title":"Manage Leads"},
};
// Get current Hash and apply
function getHash(){
	if(window.location.hash) {
 		var hash = window.location.hash.substring(1);
 		var theLink = APIlink[hash];
 		if(theLink!=undefined && theLink!=null && theLink!=""){
 			document.title = (theLink.title || document.title);
 			loadURL(APIlink["MAINURL"]+theLink.link,'#ajax-loaded-area');
 		}
	} 
}
// Respond to hash change events
$(window).on('hashchange', function() {
	getHash();
});

// PAGE LOAD using AJAX with spinner animation
function loadURL(url, container) {
	$.ajax({
		type : "GET",
		url : url,
		dataType : 'html',
		cache : true, // (warning: this will cause a timestamp and will call the request twice)
		beforeSend : function() {
			// cog placed
			$(container).html('<h1><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
		},
		complete: function(){
	    	// Handle the complete event
	    	// alert("complete")
		},
		success : function(data) {
			$(container).css({
				opacity : '0.0'
			}).html(data).delay(50).animate({
				opacity : '1.0'
			}, 300);
		},
		error : function(xhr, ajaxOptions, thrownError) {
			$(container).html('<h4 style="margin-top:10px; display:block; text-align:left"><i class="fa fa-warning txt-color-orangeDark"></i> Error 404! Page not found.</h4>');
		},
		async : false
	});
	console.log("ajax request sent");
}

// PAGE LOAD using LOAD with coffee animation
function loadPage(url, container){
	$('#loadingAnimation').show();
	$(container).load(url);
	setTimeout(function(){
		$('#loadingAnimation').hide();
	},120);
}

function getMessages(){
	$('.systemMessages').load(MainURL+"alert/getmsgs");
}

// BIND EVENTS
$(document).ready(function(){
		// Store site variables for use
		var user = $('#user_type').val();
		var MainURL = $('#mainURL').val();
		getHash();
		// AJAX PAGE LOAD BASED OFF HASHCHANGE
		$('.loadPage').click(function(){
			getHash();
		});

		//REST OF SITE EVENTS GO HERE




	
});