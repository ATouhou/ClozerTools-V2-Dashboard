@layout('layouts/main')
@section('content')
<style>
.settingSection {
    display:none;
}
</style>

<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
        <div id="page-content" style="width:80%;">

            <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style=''>&nbsp;System Settings Manager </h1>
                <div class="row-fluid" style="margin-bottom:30px;">
                    <button class='btn btn-default changeSettings' id="generalButton" data-type='general'>GENERAL SETTINGS</button>
                    <button class='btn btn-default changeSettings' id="leadButton" data-type='lead'>LEAD SETTINGS</button>
                    <button class='btn btn-default changeSettings' id="saleButton" data-type='sale'>SALE SETTINGS</button>
                    <button class='btn btn-default changeSettings' id="appointmentButton"data-type='appointment'>APPOINTMENT SETTINGS</button>
                    <button class='btn btn-default changeSettings' id="goalButton" data-type='goal'>GOAL SETTINGS</button>
                </div>

                <div id="generalSettings" class="row-fluid settingSection">
                    <div class="jarviswidget medShadow" id="widget-id-0">
                        <header>
                            <h2>GENERAL SYSTEM SETTINGS</h2>                           
                        </header>
                        <div>
                            <div class="inner-spacer" style="padding-left:20px;"> 
                                <form class="form-horizontal themed">
                                        <br/>
                                        <label class="tooltwo" title="Your Company Address" for="input01">
                                            Company Address<br/>
                                            <input type="text" class="edit_input" name="company_address"  id="company_address" value="{{$settings->company_address}}" />
                                        </label>
                                        <label class="tooltwo" title="Tax Rate for your company" for="input01">
                                            Tax rate<br/>
                                            <input type="text" class="edit_input" name="tax_rate"  id="tax_rate" value="{{$settings->tax_rate}}" />
                                        </label>
                                        
                                        <label class="tooltwo" title="The Amount in $ that Door Reggiers get paid" for="input01">
                                            Door Reggie Pay Rate &nbsp;&nbsp;<br/>
                                           $  <input type="text" class="edit_input" name="reggie_rate"  id="reggie_rate" value="{{$settings->reggie_rate}}" />
                                        </label>
                                        <br/>
                                        <label class="tooltwo checkbox" title="Apply taxes to Dealer Invoices">
                                            <input type="checkbox" id="invoice_tax" name="invoice_tax" @if($settings->invoice_tax==1) checked="checked" @endif >
                                            Show / Charge Taxes on Dealer Invoices
                                        </label>
                                     
                                        <label class="tooltwo checkbox" title="Activate the MOBILE APP">
                                            <input type="checkbox" id="mobile" name="mobile" @if($settings->mobile==1) checked="checked" @endif>
                                            Enable / Disable MOBILE App Site for Dealers
                                        </label>
                                        
                                        <!--<label class="tooltwo checkbox" title="Enable Chat Support functionality.  You can ask questions and get immediate response">
                                            <input type="checkbox" id="support" name="support" @if($settings->support==1) checked="checked" @endif>
                                            Enable Chat Support
                                        </label>-->
                                        <!-- <label class="tooltwo" title="Change the theme colour for everyone" for="input01">
                                            Theme Colour<br/>
                                            <select name="theme" id="theme" class="edit_input">
                                                <option value="darkgreen" @if($settings->theme=="darkgreen") selected="selected" @endif >Dark Green</option>
                                                <option value="blue" @if($settings->theme=="blue") selected="selected" @endif>Blue</option>
                                                <option value="green" @if($settings->theme=="green") selected="selected" @endif>Light Green</option>
                                            </select>
                                        </label>-->
                                        
                                        <hr>
                                        <h4 style="margin-top:-15px;"><img src='{{URL::to("img/pureop-logo.png")}}' style="width:160px"> </h4>
                                        <h5>Pure Opportunity Module</h5>
                                         <label class="tooltwo checkbox" title="Activate the Pure Opportunity Statistics on the dashboard">
                                            <input type="checkbox" id="pureop_stats" name="pureop_stats" @if($settings->pureop_stats==1) checked="checked" @endif>
                                            Enable the Pure Opportunity Page
                                        </label>
                                        
                                        <label class="tooltwo checkbox" title="Activate other distributors access to your stats ">
                                            <input type="checkbox" id="office_access" name="office_access" @if($settings->office_access==1) checked="checked" @endif>
                                            Allow Access to Your Stats for Other Distributors 
                                        </label>
                                        <label class="tooltwo checkbox" title="View other distributors stats ">
                                            <input type="checkbox" id="other_offices" name="other_offices" @if($settings->other_offices==1) checked="checked" @endif>
                                            Enable Viewing of Other Offices Stats
                                        </label>
                                        <h5>Leader Boards</h5>
                                        <label class="tooltwo checkbox" title="Activate the Leader Boards for all Distributors">
                                            <input type="checkbox" id="leaderboard" name="leaderboard" @if($settings->leaderboard==1) checked="checked" @endif>
                                            Enable The Distributor Leader Board Module 
                                        </label>
                                        <label class="tooltwo checkbox" title="Activate/Deactivate the Podium Graphics for the Leaderboards">
                                            <input type="checkbox" id="podium" name="podium" @if($settings->podium==1) checked="checked" @endif>
                                            Enable The Podiums Above the Leaderboards 
                                        
                                        <h5>Tesla Contest</h5>
                                        <label class="tooltwo checkbox" title="Activate the Pure Opportunity Contest on the dashboard">
                                            <input type="checkbox" id="contests" name="contests" @if($settings->contests==1) checked="checked" @endif>
                                            Enable the Pure Opportunity Contest 
                                        </label>
                                        <div style="width:100%;float:left;">
                                        <img src='{{URL::to("images/teslalogo.png")}}' style="float:left;width:45px">
                                        <label class="tooltwo" style="margin-left:20px;float:left;width:70%;margin-bottom:20px;" title="Your UNIT count as of today.  For calculation purposes.  You only have to enter this once, then the system will calculate from then on" for="input01">
                                            Your UNIT count as of today
                                        <input style="width:50%;" type="text" class="edit_input" name="contest_buffer"  id="contest_buffer" value="{{$settings->contest_buffer}}" />
                                        </label>
                                        <br/><br/>
                                        </div>
                                        <br/><br/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="leadSettings" class="row-fluid settingSection">
                    <div class="jarviswidget medShadow" id="widget-id-0">
                        <header>
                            <h2>LEAD SETTINGS</h2>                           
                        </header>
                        <div>
                        <div class="inner-spacer" style="padding-left:20px;"> 
                        <!-- content goes here -->
                            <form class="form-horizontal themed">
                                <div class="span4">
                                <h4>Lead Upload Settings</h4>
                                    <label class="tooltwo checkbox" title="Will not allow renters in the system, will quarantine anything marked R in renter field">
                                        <input type="checkbox" id="no_renters" name="no_renters" @if($settings->no_renters==1) checked="checked" @endif>
                                        Remove Any Renters From Uploaded Leads
                                    </label>
                                
                                    <!--<label class="tooltwo checkbox" title="Will not allow renters in the system, will quarantine anything marked R in renter field">
                                        <input type="checkbox" id="duplicate_overwrite" name="duplicate_overwrite" @if($settings->no_renters==1) checked="checked" @endif>
                                        Lead Overwrite
                                    </label>-->
                                    <label class="tooltwo" title="Choose how you want to deal with duplicates">
                                        Duplicate Settings<br/>
                                        <select name="duplicate_type" id="duplicate_type" class="edit_input">
                                            <option value="allow_all" @if($settings->duplicate_type=="allow_all") selected="selected" @endif> Allow All Duplicates   </option>
                                            <option value="allow_different_types" @if($settings->duplicate_type=="allow_different_types") selected="selected" @endif>  Allow only Duplicates of Different Leadtypes</option>
                                            <option value="not_allowed" @if($settings->duplicate_type=="not_allowed") selected="selected" @endif> No Duplicates Allowed</option>
                                        </select>
                                    </label>
                                    
                                    <label style="display:none;" class="animated fadeInDown tooltwo timeframe" title="If a duplicate is found when entering a new lead, it must be older than this date, for the new entry to be able to go in" for="input01">
                                        No Duplicates threshold timeframe<br/>
                                        <select name="duplicate_timeframe" id="duplicate_timeframe" class="edit_input">
                                            <option value="3_months" @if($settings->duplicate_timeframe=="3_months") selected="selected" @endif> 3 Months </option>
                                            <option value="6_months" @if($settings->duplicate_timeframe=="6_months") selected="selected" @endif> 6 Months </option>
                                            <option value="8_months" @if($settings->duplicate_timeframe=="8_months") selected="selected" @endif> 8 Months </option>
                                            <option value="1_year" @if($settings->duplicate_timeframe=="1_year") selected="selected" @endif> 1 Year </option>
                                        </select>
                                    </label>
                                    <br/>
                                    <h4>Settings for Already Surveyed Leads</h4>
                                    <label class="checkbox">
                                        <input type="checkbox" id="delete_leads" name="delete_leads" @if($settings->delete_leads==1) checked="checked" @endif>
                                        Delete/Quarantine Leads After 'X' Calls
                                    </label>
                                    <label class="checkbox tooltwo" title="Show a RED bubble showing deleted leads for each city. With ability to re-release them">
                                        <input type="checkbox" id="show_deleted" @if($settings->show_deleted==1) checked="checked" @endif>
                                        Show Deleted Leads Bubble On Lead Page
                                    </label>
                                    <label class="checkbox tooltwo" title="Include Rebooks in deleted leads.  Will delete any rebooks that have passed the call count">
                                        <input type="checkbox" id="delete_rebooks" name="delete_rebooks" @if($settings->delete_rebooks==1) checked="checked" @endif>
                                        Include Rebooks in Deleted Leads 
                                    </label>
                                    <label class="tooltwo" title="How many times a lead can be called, before being quarantined into DELETED leads pool" for="input01">
                                        MAX Times to Call Before Deleting&nbsp;&nbsp;<br/>
                                        <input type="text" class="edit_input" name="delete_count"  id="delete_count" value="{{$settings->delete_count}}" />
                                    </label>
                                    
                                    <label class="tooltwo checkbox" title="Will Show a bubble showing how many leads have been released in the last 3 days, for each leadtype in the leads table">
                                        <input type="checkbox" id="show_released" name="show_released" @if($settings->show_released==1) checked="checked" @endif>
                                        Show Released Leads Bubble
                                    </label>
                                    <label class="tooltwo checkbox" title="When checked, Recalls will be sorted in with regular leads if they have passed their recall date">
                                        <input type="checkbox" id="sort_recalls" name="sort_recalls" @if($settings->sort_recalls==1) checked="checked" @endif>
                                        Sort Recalls in with Leads, when Sorting
                                    </label>
                                    <label class="tooltwo checkbox" title="When checked, Currently assigned leads will be unassigned, before a new batch can be assigned.  If you want to assign multiple leads from multiple cities, leave this unchecked">
                                        <input type="checkbox" id="auto_unassign" name="auto_unassign" @if($settings->auto_unassign==1) checked="checked" @endif>
                                        Automatically Un-Assign Assigned leads
                                    </label>
                                    <br/>
                                    <div id="unSurveyed" >
                                    <h4>Settings for Un-Surveyed Leads</h4>
                                    <label class="checkbox">
                                        <input type="checkbox" id="delete_survey_leads" name="delete_survey_leads" @if($settings->delete_survey_leads==1) checked="checked" @endif>
                                        Delete/Quarantine Un-surveyed Leads After 'X' Calls
                                    </label>
                                    <label class="tooltwo" title="How many times an un-surveyed / fresh lead can be called, before being quarantined into DELETED leads pool" for="input01">
                                        MAX Times to Call Before Deleting Un-Surveyed Leads&nbsp;&nbsp;<br/>
                                        <input type="text" class="edit_input" name="survey_delete_count"  id="survey_delete_count" value="{{$settings->survey_delete_count}}" />
                                    </label>
                                    </div>
                                    <br/>
                                    </div>
                                    <div class="span3">
                                        <h4>General Settings</h4>
                                        <label class="tooltwo checkbox" title="Will show or hide rebooks from lead table.  This is also settable from the lead page itself">
                                            <input type="checkbox" id="show_rebooks" name="show_rebooks" @if($settings->show_rebooks==1) checked="checked" @endif>
                                            Show / Hide Rebooks from Lead Table
                                        </label>
                                        <label class="tooltwo" title="The Default Batch Amount on lead page, for assigning and releasing" for="input01">
                                            Default BLOCK size to assign/release;&nbsp;<br/>
                                            <input type="text" class="edit_input" name="default_batch"  id="default_batch" value="{{$settings->default_batch}}" />
                                        </label>
                                        <br/>
                                        <h4>Lead Assigning Tables</h4>
                                        <label class="tooltwo checkbox" title="Activate Leads by Areas Table">
                                            <input type="checkbox" id="leads_areas" @if($settings->leads_areas==1) checked="checked" @endif>
                                            Show 'LEADS BY AREA' table
                                        </label>
                                        <label class="tooltwo checkbox" title="Activate Leads by City Table">
                                            <input type="checkbox" id="leads_cities" @if($settings->leads_cities==1) checked="checked" @endif>
                                            Show 'LEADS BY CITY' table
                                        </label>
                                        <br/>
                                        
                                        <h4>Active Lead Types in Lead Tables</h4>
                                        <label class="tooltwo checkbox" title="Activate Fresh Leads to Survey Leadtype">
                                            <input type="checkbox" id="lead_survey" @if($settings->lead_survey==1) checked="checked" @endif>
                                            Fresh Un-Surveyed Leads
                                        </label>
                                        <label class="tooltwo checkbox" title="Activate Second Tier Leadtype">
                                            <input type="checkbox" id="lead_secondtier" @if($settings->lead_secondtier==1) checked="checked" @endif>
                                            Second Tier Survey
                                        </label>
                                        <label class="tooltwo checkbox" title="Activate Manilla/Surveyed Leadtype">
                                            <input type="checkbox" id="lead_paper" @if($settings->lead_paper==1) checked="checked" @endif>
                                            Paper / Manilla Leads
                                        </label>
                                        <label class="tooltwo checkbox" title="Activate Door Reggie Leadtype">
                                            <input type="checkbox" id="lead_door" @if($settings->lead_door==1) checked="checked" @endif>
                                            Door Reggie Leads
                                        </label>
                                         <label class="tooltwo checkbox" title="Activate Homeshow Leadtype">
                                            <input type="checkbox" id="lead_homeshow" @if($settings->lead_homeshow==1) checked="checked" @endif>
                                            Homeshow Leads
                                        </label>
                                         <label class="tooltwo checkbox" title="Activate Ballot Box Leadtype">
                                            <input type="checkbox" id="lead_ballot" @if($settings->lead_ballot==1) checked="checked" @endif>
                                            Ballot Box Leads
                                        </label>
                                         <label class="tooltwo checkbox" title="Activate Scratch Card Leadtype">
                                            <input type="checkbox" id="lead_scratch" @if($settings->lead_scratch==1) checked="checked" @endif>
                                            Scratch Card Leads
                                        </label>
                                        <label class="tooltwo checkbox" title="Activate Final Notice Leadtype">
                                            <input type="checkbox" id="lead_finalnotice" @if($settings->lead_finalnotice==1) checked="checked" @endif>
                                            Final Notice Leads
                                        </label>
                                        <label class="tooltwo checkbox" title="Activate Instant Set Leadtype">
                                            <input type="checkbox" id="lead_instant" @if($settings->lead_instant==1) checked="checked" @endif>
                                            Instant Set Lead
                                        </label>
                                        <label class="tooltwo checkbox" title="Activate Training Lead Leadtype">
                                            <input type="checkbox" id="lead_train" @if($settings->lead_train==1) checked="checked" @endif>
                                            Training Lead
                                        </label>
                                        <br/>
                                    </div>
                                    <div class="span4">
                                    	<h4>Message When Booker Requests Leads</h4>
                                    	<textarea rows=3 class="edit_input" name="lead_request"  id="lead_request" >{{$settings->lead_request}}</textarea>
                                    	<br/><br/><br/>

                                    	<h4>Lead Quality Scoring Index</h4>
                                    	<label class="tooltwo checkbox" title="Activate Lead Quality Scoring">
                                            <input type="checkbox" id="show_lead_score" @if($settings->show_lead_score==1) checked="checked" @endif>
                                            Activate / Hide Lead Scoring
                                        </label>
                                        <br/>
                                        <h5>Criteria for Lead Quality Scores</h5>
                                        <select name="scoring_type" class="scoring_type">
                                        	<option value="default">Default ClozerTools Algorithm</option>
                                        	<option value="custom" disabled>Custom Choices (coming soon)</option>
                                        </select>

                                        <br/><br/><br/>
                                       <!--<div class="row">
                                        <table class="table table-condensed">
                                        	<tr><th>Criteria</th><th>Match</th><th>Importance</th><th>Remove</th></tr>
                                        	<tr><td></td><td></td><td></td></tr>
                                        	<tr><td></td><td></td><td></td></tr>
                                        	<tr><td></td><td></td><td></td></tr>
                                        	<tr><td></td><td></td><td></td></tr>
                                        </table>-->
                                    </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>

                <div id="appointmentSettings" class="row-fluid settingSection">
                    <div class="jarviswidget medShadow" id="widget-id-0">
                        <header>
                            <h2>APPOINTMENT PAGE SETTINGS</h2>                           
                        </header>
                        <!-- wrap div -->
                        <div>
                            <div class="inner-spacer" style="padding-left:20px;"> 
                            <!-- content goes here -->
                                <form class="form-horizontal themed">
                                    <div class="span4">
                                    <br/>
                                        <label class="checkbox tooltwo" title="Enable / Disable Texts to go out to reps when dispatching appointments">
                                            <input type="checkbox" id="texting" @if($settings->texting==1) checked="checked" @endif>
                                            Appointment Texting (SMS Messages)
                                        </label>
                                        <label class="tooltwo checkbox" title="Show Smoke / Pets / Allergy / RentOwn / Job on Appointment Board">
                                            <input type="checkbox" id="show_lead_info" @if($settings->show_lead_info==1) checked="checked" @endif>
                                            Show Extra Lead Info On Appointment Board
                                        </label>
                                        
                                        <label class="checkbox tooltwo" title="Allow Bookers to View the Appointment Board">
                                            <input type="checkbox" id="appointment_board_access" @if($settings->appointment_board_access==1) checked="checked" @endif>
                                            Appointment Board Access for Marketers
                                        </label>
                                         <label class="tooltwo checkbox" title="Show ALERTS to alert managers, when Appointments need confirming">
                                                    <input type="checkbox" id="confirms" @if($settings->confirms==1) checked="checked" @endif>
                                                    Show Popups to Alert managers when Appointments need confirming or haven't yet been dispatched
                                                </label>
                                        <!--<label class="tooltwo checkbox" title="Show the LED Ticker module on the appointment page, when other offices sell.">
                                            		<input type="checkbox" id="led_ticker" @if($settings->led_ticker==1) checked="checked" @endif>
                                            		LED Ticker When an Office Sells
                                        		</label>-->
                                        <br/>

                                        <label class="tooltwo" title="Choose the default Number searching engine">
                                            Search Engine for Numbers<br/>
                                           <select name="fouroneone_url" id="fouroneone_url" class="edit_input">
                                                <option value="http://www.canada411.ca/search/?stype=re&what=" @if($settings->fouroneone_url=="http://www.canada411.ca/search/?stype=re&what=") selected="selected" @endif>Canada 411 (411.ca)</option>
                                                <option value="http://www.411.com/phone/" @if($settings->fouroneone_url=="http://www.411.com/phone/") selected="selected" @endif>North America 411 (411.com)</option>
                                                <option value="http://www.whitepages.ca/phone/" @if($settings->fouroneone_url=="http://www.whitepages.ca/phone/") selected="selected" @endif>White Pages (whitepages.com)</option>
                                            </select>
                                        </label>
                                        <br/>
                                        
                                        <br/>
                                        <h4>Map Settings</h4>
                                        <label class="tooltwo" title="Choose the default Map Display Type">
                                           <select name="default_map" id="default_map" class="edit_input">
                                                <option value="ROADMAP" @if($settings->default_map=="ROADMAP") selected="selected" @endif>Roadmap / Default Google</option>
                                                <option value="HYBRID" @if($settings->default_map=="HYBRID") selected="selected" @endif> Hyrbid (Satellite + Roadmap) </option>
                                                <option value="SATELLITE" @if($settings->default_map=="SATELLITE") selected="selected" @endif>Satellite Only</option>
                                            </select>
                                        </label>
                                        <label class="tooltwo" title="Choose the Map Setup">
                                           <select name="map_settings" id="map_settings" class="edit_input">
                                                <option value="leftside" @if($settings->map_settings=="leftside") selected="selected" @endif> Map on Left / StreetView on Right</option>
                                                <option value="rightside" @if($settings->map_settings=="rightside") selected="selected" @endif> Map on Right / StreetView on Left </option>
                                                <option value="onlystreet" @if($settings->map_settings=="onlystreet") selected="selected" @endif>Street View Only</option>
                                                <option value="onlymap" @if($settings->map_settings=="onlymap") selected="selected" @endif>Map View Only</option>
                                            </select>
                                        </label>
                                        <br/>
                                        </div>
                                        <div class="span5" >
                                            <h4>Appointment Needed Settings</h4>
                                            <p>Click the Slot Name to edit the Alias for the time slot</p>
                                            <table class="table animated fadeInDown table-condensed table-bordered"  style="border:1px solid #ccc;padding:5px;">
                                                <thead>
                                                    <tr>
                                                        <th>Slot</th>
                                                        <th>Start</th>
                                                        <th>End</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($slots as $s)
                                                    <?php $name = str_replace("slot","Appt. Slot # ",$s->slot_name);?>
                                                    <tr>
                                                        <td><span class='tooltwo needed-edit' title='Click to Edit Slot Name' id="{{$s->id}}|slot_name">{{$name}}</span></td>
                                                        <td><center><input class="timePick" name="booktimepicker" data-field="start" data-id="{{$s->id}}" placeholder="Select Time..." type="text" value="{{$s->start}}" style="width:54%;"  /></center>  </td>
                                                        <td><center><input class="timePick" name="booktimepicker" data-field="end" data-id="{{$s->id}}" placeholder="Select Time..." type="text" value="{{$s->end}}" style="width:54%;"  /> </center></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <br/>
                                            	<label class="tooltwo checkbox" title="Show the Appointments Needed Module to Users">
                                            		<input type="checkbox" id="needed" @if($settings->needed==1) checked="checked" @endif>
                                            		Activate Appointments Needed Module
                                        		</label>
                                        </div>  
                                </form> 
                            </div>
                        </div>
                    </div>
                </div>

                <div id="saleSettings" class="row-fluid settingSection">
                    <div class="jarviswidget medShadow" id="widget-id-0">
                        <header>
                            <h2>SALES JOURNAL / REPORT SETTINGS</h2>                           
                        </header>
                        <!-- wrap div -->
                        <div>
                        <div class="inner-spacer" style="padding-left:20px;"> 
                        <!-- content goes here -->
                            <form class="form-horizontal themed">
                                <br/>
                                    
                                    <label class="checkbox tooltwo" title="Allow Document Uploads for Sales">
                                        <input type="checkbox" id="document_uploads" @if($settings->document_uploads==1) checked="checked" @endif>
                                        Allow Document Uploads
                                    </label>
                                    <label class="tooltwo checkbox" title="Allow entry of extra sale info">
                                        <input type="checkbox" id="extra_info_sale" @if($settings->extra_info_sale==1) checked="checked" @endif>
                                        Allow Input of Extra Info (Filter#1, Filter#2, Email etc)
                                    </label>
                               
                                    <label class="checkbox tooltwo" title="Show / Hide Quick Pick Buttons">
                                        <input type="checkbox" id="quick_pick_buttons" @if($settings->quick_pick_buttons==1) checked="checked" @endif>
                                        Enable Quick Pick Date Buttons
                                    </label>
                                    <label class="checkbox tooltwo" title="Enable Daily Snapshot Report">
                                        <input type="checkbox" id="daily_snapshot" @if($settings->daily_snapshot==1) checked="checked" @endif>
                                        Enable Daily Snapshot Report
                                    </label>
                                    <br/>
                                   
                                    <label class="checkbox tooltwo" title="Enter any Finance Companies you use.  Seperated by Space, or Tab">
                                    Finance Types for Finance Deals
                                    </label>
                                       <input id="finance_deals" value="{{$settings->finance_types}}" name="tags" />
                                    <br/>

                                    <label class="checkbox tooltwo" title="Enter any Finance Percentages you use.  Seperated by Space, or Tab">
                                    Finance Percentage Options for Finance Deals <b>(enter in this format #.## )</b>
                                    </label>
                                       <input id="finance_percentages" value="{{$settings->finance_percentages}}" name="tags" />
                                    <br/>
                                    <!--<label class="checkbox tooltwo" title="">Credit Card Types for CC Deals</label>
                                        <input id="cc_deals" value="{{$settings->creditcard_types}}" name="tags" />
                                    <br/>-->
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid settingSection" id="goalSettings"  >
                    <div class="jarviswidget medShadow " id="widget-id-0">
                    <header>
                        <h2>GOAL SETTINGS</h2>                           
                    </header>
                    
                    <div>
                        <div class="inner-spacer" style="padding-left:20px;padding-bottom:30px;"> 
                            <form class="form-horizontal themed">
                            <div class="span4" style="margin-top:10px;margin-bottom:20px;">
                                <label class="tooltwo" title="Change the type of goal chart that is displayed (Guage, Progress Bars)" for="input01">
                                        Goal Style<br/>
                                        <select name="goal_type" id="goal_type" class="edit_input">
                                            <option value="guage" @if($settings->goal_type=="guage") selected="selected" @endif>Guages</option>
                                            <option value="progress" @if($settings->goal_type=="progress") selected="selected" @endif>Progress Bars</option>
                                        </select>
                                </label>
                                <label class="tooltwo checkbox" title="Will Show the progress bars of your goals, on the main dashboard page">
                                    <input type="checkbox" id="goals" name="goals" @if($settings->goals==1) checked="checked" @endif>
                                    Display Goals on Dashboard
                                </label>
                            </div>
                            <div class="span12" style="height:20px;"></div>
                            <br/><br/>
                            <div class="span3">
                            <h4>APPOINTMENT GOALS</h4>
                                @foreach($goals as $g)
                                    @if($g->usertype=="agent")
                                    <label>
                                         {{strtoupper($g->typeofgoal)}} PUT ON DEMOS
                                        <br/>
                                        <input type="text" class="edit_goals" name="goal|{{$g->id}}"  id="goal|{{$g->id}}" value="{{$g->goal}}" />
                                    </label>
                                    @endif
                                @endforeach
                            </div>
                            <div class="span3">
                            <h4>SALES GOALS</h4>
                                @foreach($goals as $g)
                                    @if($g->usertype=="salesrep" && $g->typeofgoal!="weeklyunits" && $g->typeofgoal!="monthlyunits")
                                    <label>
                                     {{strtoupper($g->typeofgoal)}} SOLD DEMOS
                                    <br/>
                                    <input type="text" class="edit_goals" name="goal|{{$g->id}}"  id="goal|{{$g->id}}" value="{{$g->goal}}" />
                                    </label>
                                    @endif
                                @endforeach                         
                            </div>
                            <div class="span3">
                                    <h4>UNIT GOALS</h4>
                                    @foreach($goals as $g)
                                        @if($g->usertype=="salesrep" && ($g->typeofgoal=="weeklyunits" || $g->typeofgoal=="monthlyunits"))
                                        <label>
                                        @if($g->typeofgoal=="weeklyunits")
                                        WEEKLY UNITS SOLD
                                        @else
                                        MONTHLY UNITS SOLD
                                        @endif
                                        <br/>
                                        <input type="text" class="edit_goals" name="goal|{{$g->id}}"  id="goal|{{$g->id}}" value="{{$g->goal}}" />
                                        </label>
                                        @endif
                                    @endforeach
                            </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>

        </div>
    </div>
</div>
                           

<script src="{{URL::to_asset('js/timepicker.js')}}"></script>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function() {

    $('.timePick').change(function(){

    	var theid = $(this).data('id');var thefield=$(this).data('field');var val =  $(this).val();t =$(this);
    	$.getJSON("{{URL::to('system/apptslottime')}}", {id: theid, field: thefield,value: val},function(data){
    		if(data!="failed"){
    			toastr.success("Saved Appointment Time","SUCCESS");
    		} else {
    			taostr.error("Failed to Save","FAILED - CONTACT ADMIN");
    		}
    		t.val(data);
    	});


    });

   $(".timePick").timePicker({
        startTime: "09:00", 
        endTime: new Date(0, 0, 0, 23, 30, 0), 
        show24Hours: true,
        step: 15});

    $('.changeSettings').click(function(){
        $('.changeSettings').removeClass('btn-inverse');
        $(this).addClass('btn-inverse');
        var type = $(this).data('type');
        localStorage.setItem("settingPage",type);
        $('.settingSection').hide();
        $('#'+type+'Settings').show();
    });


    if(localStorage){
        if(localStorage.getItem("settingPage")){
            $('#'+localStorage.getItem("settingPage")+"Button").trigger('click');
        } else {
            $('#generalButton').trigger('click');
        }
    }


    var v = $('#duplicate_type').find(":selected").val();
    if(v=="not_allowed"){$('.timeframe').show();};

    $('#duplicate_type').change(function(){
        if($(this).val()=="not_allowed"){
            $('.timeframe').show();
        } else {
            $('.timeframe').hide();
        }
    });

    $('.needed-edit').editable('{{URL::to("appointment/needededit")}}',{
        indicator : 'Saving...',
        tooltip   : 'Click to edit Appointment Slot Name',
        submit  : 'OK',
        placeholder: '....',
        width     : '100',
        height    : '25',
        callback: function(value,settings){
            console.log(value);
        }
    });



    $('.edit_goals').change(function(){
        var val = $(this).val();
        var field = $(this).attr('id');
        $.getJSON("{{URL::to('system/goalsedit')}}",{field:field,value:val},function(data){
            if(data=="success"){
                toastr.success("Settings Saved!");
            } else {
                toastr.error("Failed to Save!");
            }
        });
    });

    $('#finance_deals').tagsInput({
        height:'90px',
        width:'90%',
        autocomplete_url:'{{URL::to("system/paytypes/finance")}}',
        onAddTag:function(tag){
            $.getJSON("{{URl::to('system/addtag/finance')}}",{theTag:tag},function(data){
                if(data=="success"){
                     toastr.success('Successfully added finance type');
                 } else {
                    toastr.error('Failed to add Finance type');
                 }
            });
        },
        onRemoveTag:function(tag){
            $.getJSON("{{URl::to('system/removetag/finance')}}",{theTag:tag},function(data){
                if(data=="success"){
                     toastr.success('Successfully removed finance type');
                 } else if(data=="cannotdelete") {
                    toastr.error('Cannot delete a finance type that is already applied to Sales');
                     setTimeout(function(){location.reload();},500);
                 } else {
                    toastr.error('Failed to remove Finance type');
                 }
            });
        }
    });

    $('#finance_percentages').tagsInput({
        height:'90px',
        width:'90%',
        autocomplete_url:'{{URL::to("system/paytypes/percentage")}}',
        onAddTag:function(tag){
            $.getJSON("{{URl::to('system/addtag/percentage')}}",{theTag:tag},function(data){
                if(data=="success"){
                     toastr.success('Successfully added finance percentage');
                 } else {
                    toastr.error('Failed to add Finance percentage');
                 }
            });
        },
        onRemoveTag:function(tag){
            $.getJSON("{{URl::to('system/removetag/percentage')}}",{theTag:tag},function(data){
                if(data=="success"){
                     toastr.success('Successfully removed finance percentage');
                 } else if(data=="cannotdelete") {
                    toastr.error('Cannot delete a finance type that is already applied to Sales');
                     setTimeout(function(){location.reload();},500);
                 } else {
                    toastr.error('Failed to remove Finance type');
                 }
            });
        }
    });
  

    $('#cc_deals').tagsInput({
        height:'90px',
        width:'90%',
        autocomplete_url:'{{URL::to("system/paytypes/creditcard")}}',
        onAddTag:function(tag){
            $.getJSON("{{URl::to('system/addtag/creditcard')}}",{theTag:tag},function(data){
                if(data=="success"){
                    toastr.success('Successfully added Credit Card type');
                 } else {
                    toastr.error('Failed to add Credit Card type');
                 }
            });
        },
        onRemoveTag:function(tag){
            $.getJSON("{{URl::to('system/removetag/creditcard')}}",{theTag:tag},function(data){
                if(data=="success"){
                     toastr.success('Successfully removed Credit Card type');
                 } else if(data=="cannotdelete") {
                    toastr.error('Cannot delete a Credit Card type that is already applied to Sales');
                    setTimeout(function(){location.reload();},500);
                 } else {
                    toastr.error('Failed to remove Credit Card type');
                 }
            });
        }
    });


    $('.edit_input').change(function(){

        var val = $(this).val();
        var field = $(this).attr('id');
        $.getJSON("{{URL::to('system/edit')}}",{field:field,value:val},function(data){
            if(data=="success"){
                toastr.success("Settings Saved!");
                if(field=="theme"){
                    location.reload();
                }
            } else {
                toastr.error("Failed to Save!");
            }
        });
    });

    $( ":checkbox" ).change(function(){
        var val = $(this).val();
        var field = $(this).attr('id');
        if($(this).is(':checked')){
            var val = 1;
        } else {
            var val = 0;
        }
        $.getJSON("{{URL::to('system/edit')}}",{field:field,value:val},function(data){
            if(data=="success"){
                toastr.success("Settings Saved!");
                if(field=="support"){
                    location.reload();
                }
            } else {
                toastr.error("Failed to Save!");
            }
        });
    });


});
</script>
@endsection