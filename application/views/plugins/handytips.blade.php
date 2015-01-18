<style>
#handytips{width:600px;
height:500px;
background:white;
border:1px solid #1f1f1f;
position:fixed;
z-index:80000;padding:40px;
margin-left:370px;display:none;}
</style>
<script>
$(document).ready(function(){


	$('#searchleads').hover(function () {
    var expanding = $(this);
    var timer = window.setTimeout(function () {
        expanding.data('timerid', null);
        	$('#handytips').toggle(200);
    }, 1000);
    //store ID of newly created timer in DOM object
    expanding.data('timerid', timer);
}, function () {
    var timerid = $(this).data('timerid');
    if (timerid != null) {
        //mouse out, didn't timeout. Kill previously started timer
        window.clearTimeout(timerid);
    }
});
	$('#searchleads').mouseout(function () {
		$('#handytips').hide(200);
	});

});
</script>

<div id="handytips" class="shadowBOX">
<h4>Search Tips</h4>
You can search leads, and sales with this box.<br/>
There is loose searching based on name, numbers, address, city, booker, and sales rep on the lead searches.<br/>

The sale search is more specific.<br/>
<Br/>
To search for a specific sale.  Just type in the sale number.
ie 148  = Sale #148<br/><br/>
To find sales by dealer, just type in their first and last name<br/><br/>
<Br/>
To search leads for a specific set of leads, here are the keywords to search.
<li>INVALID - Renters</li>
<li>INACTIVE - (Unreleased Leads)</li>
<li>SOLD - (All leads that were sold)</li>
<li>NEW - (Available leads)</li>
<li>NQ - (Not Qualified)</li>
<li>NI - (Not Interested)</li>
<li>DNC - (Do Not Call)</li>
<li>NQ - (Not Qualified)</li>
INACTIVE - (Unreleased leads

<p>Searching phone numbers : USE DASHES   ###-###-####


</div>