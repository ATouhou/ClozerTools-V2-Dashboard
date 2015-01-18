$(document).ready(function(){

  var MainURL = $('#mainURL').val();

  $('.logoutButton').click(function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    window.location = href;
  });

	// Payment Calculator
 	function calculate(){
   		var tax = $('#tax_rate').val();
   		var tax_rate = parseFloat(parseInt(tax))/100;
   		var sale_price = $('#sale_price').val();
   		var given_price = $('#given_price').val();
   		var down_pay = $('#down_pay').val();
   		var fees = $('#fees').html();
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
   		$('.monthlypayment').hide().removeClass('fadeInUp').addClass('fadeInUp').show().html("$"+parseFloat(monthly).toFixed(2)+" / Mn");
    }

  function getAppts(date){
     $.ui.updateContentDiv("#appointmentList","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
      
      if(date!=null){
        $.get("../mobile/appointments",function(data){
          $.ui.updateContentDiv("#appointmentList",data);
        });
      } else {
        $.get("../mobile/appointments",function(data){
          $.ui.updateContentDiv("#appointmentList",data);
        });
      }
   
  }

  function getSales(type){
      var from = $('#fromdate').val();
      var to = $('#todate').val();
     
        $.post(MainURL+"/mobile/sales",{saletype:type,start:from ,end:to},function(data){
            $.ui.updateContentDiv("#saleList",data);
        });
  }

  function getStats(){
    $.ui.updateContentDiv("#stats","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
    
      $.get("../mobile/salestats",function(data){
         $.ui.updateContentDiv("#stats",data);
      });
   
  }
    
    // Calculate Button
    $('.calculate').click(function(e){
        calculate();
    });

    $('.viewAppts').click(function(){
      getAppts();
    });

    $('.viewStats').click(function(){
      getStats();
    });

    $('.viewSales').click(function(){
      $.ui.updateContentDiv("#saleList","<center><img src='../img/loaders/misc/66.gif' style='margin-top:39px;'></center>");
      var type=$(this).data('type');
      getSales(type);
    });

    $('.fromdate').change(function(){
      $('.fromdate').val($('.fromdate').val());
    });

    $('.todate').change(function(){
      $('.todate').val($('.todate').val());
    });

    $(document).on('click','.viewCommission',function(){
      $('.commission').toggle();
      });

    // SALE PAGE AND FORM STUFF

    // View SALE
    $(document).on('click','.viewSale',function(){
      var id = $(this).attr('data-id');
      $.ui.setTitle("Sale #"+id);
      $.ui.loadContent('#formpanel');
      $.get("../mobile/getsale/"+id,function(data){
        $.ui.updateContentDiv('#formpanel',data);
      });
    });
    //Change PAYMENT image when select is chosen
    $(document).on('change','#methodofpay',function(){
      var type = $(this).val().toLowerCase();
      if(type=="lendcare" || type=="crelogix" || type=="jp"){
        $('#interest').show();
      } else {
        $('#interest').hide();
      }
      $('#paymentMethod').attr('src',MainURL+'/images/payment-'+type+'.png');
    });
    //Change SYSTEM image when select is chosen
    $(document).on('change','#typeofsystem',function(){
      var type = $(this).val().toLowerCase()
      $('#systemType').attr('src',MainURL+'/images/pureop-small-'+type+'.png');
    });

    getAppts();
   
});