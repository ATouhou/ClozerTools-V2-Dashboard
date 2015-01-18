<?php $setting = Setting::find(1);
?>
<div class="modal hide fade" id="payment_calc_modal" style='width:75%;margin-top:-150px;margin-left:-680px;z-index:50000'>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>Payment Calculator </h3>
	</div>
	<div class="modal-body" id="payment-calc" style="height:600px;">

            <div class="fluid-container" style="padding-bottom:40px;">

                <div class="row-fluid well">
                    <div class="span3" style="margin-left:10px;">
                        <h3>Monthly Payment (est)</h3><br/>
                        <h4><span class='bignum monthlypayment'>$0.00</span> </h4><br/>

                        <table class="table-condensed table-bordered" style="margin-top:5px; font-size:16px; padding:5px; border:1px solid #1f1f1f;">
                            <tr>
                                <td>Discount</td><td>$<span id="discount">0</span></td>
                            </tr>
                            <tr>
                                <td>HST</td><td>$<span id="hst" style="font-weight:bolder;">0</span></td>
                            </tr>
                            <tr>
                                <td>Cash Price</td><td >$<span id="cash_price">0</span></td>
                            </tr>
                            
                            <tr>
                               <?php if($setting->shortcode=="mdhealth" || $setting->shortcode=="mdhealth2" || $setting->shortcode=="foxvalley" || $setting->shortcode=="cyclo" || $setting->shortcode=="ribmount" || $setting->shortcode=="triad" || $setting->shortcode=="pureair"){
                                $fee="";
                               } else {
                                $fee = "49.95";
                                } ;?>
                                <td>Reg Fees</td><td><input type="text" id="fees" value="{{$fee}}" style='width:38%;'></td>
                            </tr>

                            <tr>
                                <td>Total Financed</td><td >$<span id="TAF" style="font-weight:bolder;">0</span></td>
                            </tr>
                            <tr>
                                <td class="smallText">TCB</td><td class="smallText" >$<span id="TCB" >0</span></td>
                            </tr>
                            <tr>
                                <td class="smallText">TAP</td><td class="smallText" >$<span id="TAP" >0</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="span3">
                        <label for="price">Sticker Price </label>
                        <input type="text" name="sale_price" id="sale_price" placeholder="Enter retail price of system"/>
                        <label for="price">Sub-Total (Customer Price)</label>
                        <input type="text" name="given_price" id="given_price" placeholder="Enter the price you are selling it to the customer"/>
                        <label for="price">Down Payment</label>
                        <input type="text" name="down_pay" id="down_pay" value="0"/>
                    </div>
                   
                    <div class="span3">
                        <label for="interest">Interest Rate</label>
                        <select name="interest" id="interest">
                            @if(Setting::find(1)->shortcode=="putk")
                            <option value="table1">9.95%</option>
                            @endif
                            <option value="table2">19.95%</option>
                            <option value="table3" selected='selected'>29.90%</options>
                        </select>
                        <label for="def">Deferral</label>
                        <select name="def" id="def">
                            <option value="0">0 Months</option>
                            <option value="3">3 Months</options>
                            <option value="6">6 Months</options>
                        </select>
                        <label for="term">Term</label>
                        <select name="term" id="term">
                            <option value="6">6 Months</option>
                            <option value="12">12 Months</options>
                            <option value="18">18 Months</options>
                            <option value="24">24 Months</options>
                            <option value="30">30 Months</options>
                            <option value="36">36 Months</options>
                            <option value="42" >42 Months</options>
                            <option value="48" selected='selected'>48 Months</options>  
                            <option value="54">54 Months</options>
                            <option value="60" >60 Months</options>       
                        </select>
                        <label for="tax_rate">Tax Rate</label>
                        <select name="tax_rate" id="tax_rate" >

                            <option value="13" data-rates='13%'>Default (13%)</option>
                            <option value="5" data-rates='5% GST'>Alberta (5% GST)</option>
                            <option value="12" data-rates='7% PST & 5% GST' @if($setting->shortcode=='aas' || $setting->shortcode=='healthtek') selected='selected' @endif>BC (7% PST + 5% GST)</option>
                            <option value="13" data-rates='8% PST & 5% GST' @if($setting->shortcode=='whs') selected='selected' @endif>Manitoba (8% PST + 5% GST)</option>
                            <option value="13" data-rates='13% HST' @if($setting->shortcode=='avaeros') selected='selected' @endif >New Brunswick / Newfoundland (13% HST)</option>
                            <option value="5" data-rates='5% GST'>Nunavut & Northwest Ter. (5% GST)</option>
                            <option value="13" data-rates='13% HST' @if($setting->shortcode=='putk' || $setting->shortcode=='be') selected='selected' @endif>Ontario (13% HST )</option>
                            <option value="14.975" data-rates='9.975% QST & 5% GST'>Quebec (9.975% QST + 5% GST )</option>
                            <option value="14" data-rates='14% HST'>Prince Edward Island (14% HST )</option>
                            <option value="10" data-rates='5% PST & 5% GST' @if($setting->shortcode=='quality' || $setting->shortcode=='quality2') selected='selected' @endif>Saskatchewan (5% PST + 5% GST)</option>
                            <option value="4.75" data-rates='4.75%' @if($setting->shortcode=='triad') selected='selected' @endif>North Carolina, US (4.75%)</option>
                            <option value="5" data-rates='5%' @if($setting->shortcode=='foxv' || $setting->shortcode=='ribmount') selected='selected' @endif>Wisconsin, US (5%)</option>
                            <option value="5" data-rates='5%' @if($setting->shortcode=='cyclo') selected='selected' @endif>Iowa, US (5%)</option>
                            <option value="7" data-rates='7%' @if($setting->shortcode=='mdhealth') selected='selected' @endif>Indiana, US (7%)</option>

                          </select>
                    </div>
                    <div class="span12">
                        
                      
                    </div>
                  
                </div>
                
                <div class="row-fluid"  id="tables">
                    @if(Setting::find(1)->shortcode=="putk")
                    <div class="span3">
                        <h3>9.95%</h3>
                        <table class="table table-condensed table-bordered">
                            <thead>
                                
                                <tr><th>TERM</th><th>Deferral 0</th><th>Deferral 3</th><th>Deferral 3</th></tr>
                            </thead>
                            <tbody id="table1">
                                <tr class='term-6'><td>6</td><td class='def-0'>0.171537</td><td class='def-3'>0.175804</td><td class='def-6'>0.180071</td></tr>
                                <tr class='term-12'><td>12</td><td class='def-0'>0.087893</td><td class='def-3'>0.090079</td><td class='def-6'>0.092265</td></tr>
                                <tr class='term-18'><td>18</td><td class='def-0'>0.060034</td><td class='def-3'>0.061527</td><td class='def-6'>0.063021</td></tr>
                                <tr class='term-24'><td>24</td><td class='def-0'>0.046122</td><td class='def-3'>0.047269</td><td class='def-6'>0.048416</td></tr>
                                <tr class='term-30'><td>30</td><td class='def-0'>0.037788</td><td class='def-3'>0.038728</td><td class='def-6'>0.039668</td></tr>
                                <tr class='term-36'><td>36</td><td class='def-0'>0.032244</td><td class='def-3'>0.033046</td><td class='def-6'>0.033848</td></tr>
                                <tr class='term-42'><td>42</td><td class='def-0'>0.028293</td><td class='def-3'>0.028997</td><td class='def-6'>0.029701</td></tr>
                                <tr class='term-48'><td>48</td><td class='def-0'>0.025339</td><td class='def-3'>0.025969</td><td class='def-6'>0.026599</td></tr>
                                <tr class='term-54'><td>54</td><td class='def-0'>0.023048</td><td class='def-3'>0.023621</td><td class='def-6'>0.024195</td></tr>
                                <tr class='term-60'><td>60</td><td class='def-0'>0.021222</td><td class='def-3'>0.02175</td><td class='def-6'>0.022278</td></tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <div class="span3">
                        <h3>19.95%</h3>
                        <table class="table table-condensed table-bordered">
                            <thead>
                                
                                <tr><th>TERM</th><th>Deferral 0</th><th>Deferral 3</th><th>Deferral 3</th></tr>
                            </thead>
                            <tbody id="table2">
                                <tr class='term-6'><td>6</td><td class='def-0'>0.176498</td><td class='def-3'>0.185301</td><td class='def-6'>0.194103</td></tr>
                                <tr class='term-12'><td>12</td><td class='def-0'>0.092611</td><td class='def-3'>0.097230</td><td class='def-6'>0.101848</td></tr>
                                <tr class='term-18'><td>18</td><td class='def-0'>0.064739</td><td class='def-3'>0.067968</td><td class='def-6'>0.071197</td></tr>
                                <tr class='term-24'><td>24</td><td class='def-0'>0.050871</td><td class='def-3'>0.053409</td><td class='def-6'>0.055946</td></tr>
                                <tr class='term-30'><td>30</td><td class='def-0'>0.042605</td><td class='def-3'>0.044730</td><td class='def-6'>0.046854</td></tr>
                                <tr class='term-36'><td>36</td><td class='def-0'>0.037138</td><td class='def-3'>0.038990</td><td class='def-6'>0.040843</td></tr>
                                <tr class='term-42'><td>42</td><td class='def-0'>0.033271</td><td class='def-3'>0.034931</td><td class='def-6'>0.036590</td></tr>
                                <tr class='term-48'><td>48</td><td class='def-0'>0.030404</td><td class='def-3'>0.031920</td><td class='def-6'>0.033437</td></tr>
                                <tr class='term-54'><td>54</td><td class='def-0'>0.028202</td><td class='def-3'>0.029609</td><td class='def-6'>0.031015</td></tr>
                                <tr class='term-60'><td>60</td><td class='def-0'>0.026466</td><td class='def-3'>0.027786</td><td class='def-6'>0.029106</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="span3">
                        <h3>29.90%</h3>
                        <table class="table table-condensed table-bordered">
                            <thead>
                                
                                <tr><th>TERM</th><th>Deferral 0</th><th>Deferral 3</th><th>Deferral 3</th></tr>
                            </thead>
                            <tbody id="table3">
                                <tr class='term-6'><td>6</td><td class='def-0'>0.181499</td><td class='def-3'>0.195066</td><td class='def-6'>0.208634</td></tr>
                                <tr class='term-12'><td>12</td><td class='def-0'>0.097438</td><td class='def-3'>0.104721</td><td class='def-6'>0.112005</td></tr>
                                <tr class='term-18'><td>18</td><td class='def-0'>0.069620</td><td class='def-3'>0.074824</td><td class='def-6'>0.080028</td></tr>
                                <tr class='term-24'><td>24</td><td class='def-0'>0.055861</td><td class='def-3'>0.060037</td><td class='def-6'>0.064213</td></tr>
                                <tr class='term-30'><td>30</td><td class='def-0'>0.047725</td><td class='def-3'>0.051292</td><td class='def-6'>0.054859</td></tr>
                                <tr class='term-36'><td>36</td><td class='def-0'>0.042397</td><td class='def-3'>0.045566</td><td class='def-6'>0.048735</td></tr>
                                <tr class='term-42'><td>42</td><td class='def-0'>0.038672</td><td class='def-3'>0.041563</td><td class='def-6'>0.044454</td></tr>
                                <tr class='term-48'><td>48</td><td class='def-0'>0.035948</td><td class='def-3'>0.038635</td><td class='def-6'>0.041322</td></tr>
                                <tr class='term-54'><td>54</td><td class='def-0'>0.033888</td><td class='def-3'>0.036421</td><td class='def-6'>0.038954</td></tr>
                                <tr class='term-60'><td>60</td><td class='def-0'>0.032292</td><td class='def-3'>0.034706</td><td class='def-6'>0.037120</td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>    
        


	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
	</div>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function(){

    function calculate(){
    var tax = $('#tax_rate').val();
            var tax_rate = parseFloat(parseInt(tax))/100;
            var sale_price = $('#sale_price').val();
            var given_price = $('#given_price').val();
            var down_pay = $('#down_pay').val();
            var fees = $('#fees').val();
            var discount = (parseFloat(sale_price)-parseFloat(given_price)).toFixed(2);
            $('#discount').html(discount);
            var hst =parseFloat(given_price)*tax_rate;
            $('#hst').html(hst.toFixed(2));
            $('#cash_price').html((parseFloat(given_price)+parseFloat(hst)).toFixed(2));
            var amount = ((parseFloat(given_price)+parseFloat(hst)+parseFloat(fees))-parseFloat(down_pay));
            $('#TAF').html(amount.toFixed(2));
            var interest = $('#interest').val();
            var def = $('#def').val();
            var term = $('#term').val();
            var calcval = $('#'+interest).find('.term-'+term).find('.def-'+def).html();
            var monthly = parseFloat(amount)*calcval;
            var tap = parseFloat(monthly)*parseInt(term);
            var tcb = tap-amount;
            $('#TCB').html(tcb.toFixed(2));
            $('#TAP').html(tap.toFixed(2));
            $('.monthlypayment').html("$"+parseFloat(monthly).toFixed(2)+" / Mn");
        }

$('input[type=text]').change(function(){
    calculate();
});

$('select').change(function(){
calculate();
})
});
</script>