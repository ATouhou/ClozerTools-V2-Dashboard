@layout('layouts/main')
@section('content')

<div class="modal hide fade" id="expense_modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="expenseModalHeader">Test Head</h3>
    </div>
    <div class="expenseModalBody modal-body book-process">
        
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
    </div>
</div>

<div id="main"  class="container-fluid" style="background:white;padding:45px;padding-top:30px;padding-bottom:1500px;">
    <h1><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-top:-20px;margin-right:-10px;'>&nbsp;Expense Manager</h1>
    <div class="row-fluid">
        <div class="span12">
                @for($m=1; $m<=12; $m++)
                <?php $monthnames = date('F', mktime(0,0,0,$m, 1, date('Y')));?>
                <a href="{{URL::to('expense/')}}?month={{$m}}">
                    <button class='btn btn-default @if($m==$month) btn-inverse  @else btn-default @endif btn-default'>
                        <span class='small' style='font-weight:normal;font-size:15px;' >{{$monthnames}}</span>
                    </button>
                </a>
                @endfor
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12" style="margin-top:30px;margin-bottom:40px;">
            <button class='btn btn-primary addNewExpense'><i class='cus-add'></i>&nbsp;&nbsp;NEW EXPENSE</button>&nbsp;&nbsp;
            <button class='btn btn-default newCategory'><i class='cus-add'></i>&nbsp;&nbsp;NEW CATEGORY</button>
        </div>
                <?php $highest = 0;$total=0;?>
                @if(!empty($expenses))
                    @foreach($expenses as $s)
                    <?php $amt = number_format($s->expense_amount,2,'.','');
                    $total+=$amt;?>
                    <?php if($amt > $highest){$highest = $amt;};?>
                    @endforeach
                @endif
                <?php $highestinc = 0;$totalinc=0;?>
                @if(!empty($income))
                    @foreach($income as $i)
                    <?php $amt2 = number_format($i->price,2,'.','');
                    $totalinc+=$amt2;
                    ?>
                    <?php if($amt2 > $highestinc){$highestinc = $amt2;};?>
                    @endforeach
                @endif

        <div class="span3 expenseLeft" style="margin-left:-5px;" >
            
            <div class="span12 well">
                <div class="span5">
                    <h4>GROSS INCOME</h4>
                    <span class='label label-success totalStat special blackText filteredTotalInc'>${{number_format($totalinc,2,'.','')}}</span>
                </div>

                <div class="span5">
                    <h4>Total Expenses</h4>
                    <span class='label label-important totalStat special filteredTotalExp'>${{number_format($total,2,'.','')}}</span>
                </div>
                <div class="span12" style="margin-top:30px;">
                    <h4>Filter By City</h4>
                    <select name="expense_city" id="expense_city">
                        <option value="all">All Cities</option>
                        @foreach($cities as $c)
                        <option value="{{str_replace(',','-',str_replace(' ','-',$c->cityname))}}">{{$c->cityname}}</option>
                        @endforeach
                    </select>
                    <br/>
                    <h4>Tags / Categories Filter</h4>
                    @foreach($tags as $t)
                    <button class='btn btn-default categoryFilter ' data-category='{{str_replace(' ','-',$t->category)}}'>{{$t->category}}</button>
                    @endforeach
                </div>
            </div>

            <div class="span12 well" style="margin-left:0px;margin-top:30px;">
                @if(!empty($expenses))
                <h4>All Expenses for {{$monthname}} : </h4>
                    @foreach($expenses as $s)
                        <?php $amt = number_format($s->expense_amount,2,'.','');?>
                        <?php $perc = number_format((($amt/$highest)*100),2,'.','');?>
                         <div class="expense-{{$s->id}} progress progress-success progress-striped cityname-{{str_replace(',','-',str_replace(' ','-',$s->cityname))}} category-{{str_replace(' ','-',$s->category)}}" style="height:35px;margin-bottom:4px">
                            <div class="bar " data-percentage="{{$perc}}" style="width: {{$perc}}%; padding-top:10px;"><span class='badge badge-inverse '>$ {{$amt}}</span></div>
                        </div>
                    @endforeach
                @else
                <center>
                    <h3>No Expenses for {{$monthname}}</h3>
                </center>
                @endif
            </div>
        </div>
 
        <div class="span4 expenseLeft" style="min-height:600px;">
            <div class='leftsideList EXPENSES'>
                @if(!empty($expenses))
                <h4 >{{strtoupper($monthname)}}'S EXPENSES <span class='cityView'></span></h4>
                    <ul class="expenseList">
                        @foreach($expenses as $s)
                        <?php $amt = number_format($s->expense_amount,2,'.','');?>
                        <?php if($amt > $highest){$highest = $amt;};?>
                            <li class="expenseRow tooltwo expense-{{$s->id}} cityname-{{str_replace(',','-',str_replace(' ','-',$s->cityname))}} category-{{str_replace(' ','-',$s->category)}}" title="${{$amt}} - {{$s->category}} - {{$s->expense_tag}} | Paid With : {{$s->paid_with}}" data-id="{{$s->id}}" data-amount='{{$amt}}'>
                            <span class='badge badge-important special deleteExpense tooltwo' title='Click here to delete this expense' data-id='{{$s->id}}'> - </span> &nbsp;&nbsp;{{$s->expense_tag}}
                                <span class="pull-right">${{$amt}}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                <h4 style="margin-left:20px;">There are no expenses entered for {{$monthname}}</h4>
                @endif
            </div>
        </div>

        <div class="span3 expenseLeft" style="min-height:600px;">
            <div class='leftsideList INCOME'>
            @if(!empty($income))
                <h4 style="margin-left:20px;">{{strtoupper($monthname)}}'S INCOME (estimate) <span class='cityView'></span></h4>
                <ul class="expenseList">
                <?php $highestinc=0;?>
                    @foreach($income as $i)
                    <?php $amt2 = number_format($i->price,2,'.','');$l = Lead::find($i->lead_id);?>
                        <li class="incomeRow stat-{{$i->status}} tooltwo income-{{$i->id}} cityname-{{str_replace(',','-',str_replace(' ','-',$l->city))}} category-{{$i->typeofsale}}" title="${{$amt2}} - {{strtoupper($i->typeofsale)}} - {{$i->cust_name}} | SOLD BY : {{$i->sold_by}} | {{$i->status}}" data-amount='{{$amt2}}'>
                        &nbsp;&nbsp;Sale# {{$i->id}} | {{strtoupper($i->typeofsale)}}
                            <span class="pull-right">${{$amt2}}</span>
                        </li>
                    @endforeach
                </ul>
            @else
            <h4 style="margin-left:20px;">There are no Sales for {{$monthname}}</h4>
            @endif
            </div>

        </div>

        
       
    </div>
</div>

<div class="push"></div>
<script>
$(document).ready(function(){

    function replaceTotals(){
        var expTotal=0; var incTotal=0;
        var city = $('#expense_city').val();
        if(city=="all"){
            $('li.incomeRow').each(function(){
                incTotal+=parseFloat($(this).data('amount'));
            });
        } else {
            $('li.incomeRow.cityname-'+city).each(function(){
                incTotal+=parseFloat($(this).data('amount'));
            });
        }
        $('li.expenseRow').each(function(){
            if($(this).is(":visible")){
               expTotal+=parseFloat($(this).data('amount'));
            }
        });
        $('.filteredTotalExp').html('$'+parseFloat(expTotal).toFixed(2));
        $('.filteredTotalInc').html('$'+parseFloat(incTotal).toFixed(2));

    }

    function filterExpenses(){
        $('li.expenseRow').hide();$('.progress').hide();
        $('li.incomeRow').hide();
        var catFilt = 0;
        var city = $('#expense_city').val();
        if(city=="all"){
            $('.cityView').html('');
            $('li.incomeRow').show();
        } else {
            $('.cityView').html('('+city+')');
            $('li.incomeRow.cityname-'+city).show();
        }
        $('.categoryFilter').each(function(i,val){
            if($(this).hasClass('btn-inverse')){
                catFilt++;
                var cat = $(this).data('category');
                if(city=="all"){
                    $('.category-'+cat).show();
                } else {
                    $('.category-'+cat+'.cityname-'+city).show();
                }
            }
        });
        if(catFilt==0){
            if(city=="all"){
                $('li.expenseRow').show();$('.progress').show();
            } else {
                $('li.expenseRow.cityname-'+city).show();
                $('.progress.cityname-'+city).show();
            }
        }
        setTimeout(replaceTotals,100);
    }



    $('.categoryFilter').click(function(){
        var cat = $(this).data('category');
        if($(this).hasClass('btn-inverse')){
            $(this).removeClass('btn-inverse');
        } else {
            $(this).addClass('btn-inverse');
        }
        filterExpenses();
    }); 

    $('#expense_city').change(function(){
        filterExpenses();
    });

    $('.expenseType').click(function(){
        var type=$(this).data('type');
        $('.expenseType').removeClass('btn-inverse');
        $('.leftsideList').hide(200);
        $(this).addClass('btn-inverse');
        $('.'+type).show(200);
    });

    $('.addNewExpense').click(function(){
        $('.expenseModalHeader').html("Add New Expense");
        $('.expenseModalBody').load("{{URL::to('expense/addnew')}}");
        $('#expense_modal').modal('show');
    });

    $('.expenseRow').click(function(){
        var id = $(this).data('id');
        $('.expenseModalHeader').html("Edit Expense");
        $('.expenseModalBody').load("{{URL::to('expense/addnew/')}}"+id);
        $('#expense_modal').modal('show');
    });

    $('.newCategory').click(function(){
        $('.expenseModalHeader').html("Add New Category");
        $('.expenseModalBody').load("{{URL::to('expense/addcategory')}}");
        $('#expense_modal').modal('show');
    });

    $('.deleteExpense').click(function(){
        var id = $(this).data('id');
        var t = confirm("Are you sure you want to delete this expense");
        if(t){
            $.getJSON("{{URL::to_asset('expense/delete')}}",{expense_id:id},function(data){
                console.log(data);
                if(data!="failed"){
                    $('.expense-'+id).remove();
                    toastr.success("Expense Deleted Successfully");
                } else {
                    toastr.error("Couldn't delete expense.  Please contact admin");
                }
            });
        }
    });

});
</script>

@endsection