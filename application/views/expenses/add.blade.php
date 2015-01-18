<form id="newExpense" method="post" action="{{URL::to('expense/addnew')}}">
	<div style="width:45%;float:left;">
	@if(!empty($expense))
	<input type="hidden" name="expense_id" value="{{$expense->id}}">
	@endif
	<label>Name of Expense </label>
	<input type="text" name="expense_tag" id="expense_tag" @if(!empty($expense)) value="{{$expense->expense_tag}}" @endif />
	<label>Expense Amount <b>(without $ sign)</b></label>
	<input type="text" name="expense_amount" id="expense_amount" @if(!empty($expense)) value="{{number_format($expense->expense_amount,2,'.','')}}" @endif />

	<label>Category</label>
	<select name="category">
		@foreach($category as $c)
		<option value="{{str_replace('\'','',$c)}}" @if(!empty($expense) && $expense->category==$c) selected="selected" @endif>{{str_replace('\'','',$c)}}</option>
		@endforeach
	</select>
	<label>Expense Type</label>
	<select name="pay_type">
		@foreach($paytype as $c)
		<option value="{{str_replace('\'','',$c)}}" @if(!empty($expense) && $expense->pay_type==$c) selected="selected" @endif >{{ucfirst(str_replace('\'','',$c))}}</option>
		@endforeach
	</select>
	<label>Paid With</label>
	<select name="paid_with">
		@foreach($paywith as $c)
		<option value="{{str_replace('\'','',$c)}}" @if(!empty($expense) && $expense->paid_with==$c) selected="selected" @endif>{{str_replace('\'','',$c)}}</option>
		@endforeach
	</select>
	</div>
	<div style="width:40%;margin-left:20px;float:left;">
		<label>City To Attach Expense To</label>
		<select name="cityname">
			<option value="">None / Office</option>
		@foreach($cities as $c)
		<option value="{{$c->cityname}}" @if(!empty($expense) && $expense->cityname==$c->cityname) selected="selected" @endif>{{$c->cityname}}</option>
		@endforeach
	</select>
	 <label class="control-label">Date Paid</label>
        <div class="input-append date" id="datepicker-expense" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
        	<input class="datepicker-input" size="16" id="date_paid" name="date_paid" type="text" @if(!empty($expense)) value="{{date('Y-m-d',strtotime($expense->date_paid))}}" @else value="{{date('Y-m-d')}}" @endif  placeholder="Select a date" />
        	<span class="add-on"><i class="cus-calendar-2"></i></span>
       </div>
	</div>
	
	<br/>
	<br/><br/><br/><br/><br/><br/>
	
	<button class='btn btn-default btn-large addNewExpenseSubmit' style="margin-left:20px;">
	@if(empty($expense)) <i class='cus-add'></i>&nbsp;&nbsp;ADD NEW EXPENSE @else <i class='cus-accept'></i>&nbsp;&nbsp;UPDATE EXPENSE  @endif
	</button>
	
</form>
<script>
	$(document).ready(function(){
		$('#datepicker-expense').datepicker();

		$('.addNewExpenseSubmit').click(function(e){
			e.preventDefault();
			var name = $('#expense_tag').val();
			var amount = $('#expense_amount').val();
			if(!name){
				toastr.error("Please enter a name for this expense!!");
				return false;
			}
			if(!amount){
				toastr.error("Please enter an amount for this expense!!");
				return false;
			}
			$('#newExpense').submit();
		});
	});
</script>