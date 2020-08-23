@extends('layouts.app')
@section('content')
<div class="windows-firm-Box">
	<div class="top-tile">
		Choose Payment Method
	</div>
	<div class="windows-form">
		<form action="/check-out-pay" method="post">
        @csrf
        <div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">
						Total Payment
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						{{$total}}
					<input type="hidden" name="amount" value="{{$total}}">
					</span>
				</div>


		<div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">
						Payment Method
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						<div class="rs2-select2 rs3-select2 rs4-select2 bo4 of-hidden w-size21 m-t-8 m-b-12">
							<select class="selection-2" name="method">
								<option>Select Payment Method</option>
								<option value="cash">Cash</option>
								<option value="paytem">Paytm</option>
<!-- 								<option value="card">Debit Card</option> -->
							</select>
						</div>
					</span>
				</div>

				<div class="size15 trans-0-4">
					<!-- Button -->
					<button class="btn sub-btn">
						Submit
					</button>
				</div>
		</form>
	</div>
</div>
@endsection