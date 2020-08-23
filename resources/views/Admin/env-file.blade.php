@extends('layouts.master')
@section('content')

<div class="content mt-3">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">ENV</strong><span style="float: right;"><a href="/admin"><i class="fa fa-arrow-left"></i> Back</a></span>
					</div>
					<div class="card-body">
						<!-- Credit Card -->
						<div id="pay-invoice">
							<div class="card-body">
								  <div class="btn-group">
		                               <button type="button" class="btn btn-success btn-sm" onClick="refreshPage()">
										<i class="fa fa-refresh"></i> Refresh</button>
										<a href="/clear-config" class="btn btn-warning btn-sm">
                                   		 <i class="fa fa-remove"></i> Config Clear
                                		</a>
                                		<a href="/clear-cache" class="btn btn-info btn-sm">
                                   		 <i class="fa fa-remove"></i> Cache Clear
                                		</a>
                            		</div>
								<div class="card-title">
									<h3 class="text-center">File Data</h3>
								</div>
								<hr>
								<table class="table table-striped table-bordered">
									<thead>
									<tr>
										<th>Key</th>
										<th>Value</th>	
									</tr>
									</thead>
                    				<tbody>
									<tr>
										<td>APP_NAME</td>
										<td>{{env('APP_NAME')}}</td>
									</tr>
									<tr>
										<td>APP_ENV</td>
										<td>{{env('APP_ENV')}}</td>
									</tr>
									<tr>
										<td>APP_URL</td>
										<td>{{env('APP_URL')}}</td>
									</tr>
									<tr>
										<td>DB_DATABASE</td>
										<td>{{env('DB_DATABASE')}}</td>
									</tr>
									<tr>
										<td>DB_USERNAME</td>
										<td>{{env('DB_USERNAME')}}</td>
									</tr>
									<tr>
										<td>DB_PASSWORD</td>
										<td>{{env('DB_PASSWORD')}}</td>
									</tr>
									<tr>
										<td>MAIL_USERNAME</td>
										<td>{{env('MAIL_USERNAME')}}</td>
									</tr>

									<tr>
										<td>MAIL_PASSWORD</td>
										<td>{{env('MAIL_PASSWORD')}}</td>
									</tr>
									<tr>
										<td>MAIL_FROM_NAME</td>
										<td>{{env('MAIL_FROM_NAME')}}</td>
									</tr>
									<tr>
										<td>MAIL_FROM_ADDRESS</td>
										<td>{{env('MAIL_FROM_ADDRESS')}}</td>
									</tr>
									<tr>
										<td>PAYTM_MERCHANT_ID</td>
										<td>{{env('PAYTM_MERCHANT_ID')}}</td>
									</tr>
									<tr>
										<td>PAYTM_MERCHANT_KEY</td>
										<td>{{env('PAYTM_MERCHANT_KEY')}}</td>
									</tr>
								   </tbody>
								</table>
								<h4 style="text-align: center;padding: 20px;">Change Data</h4>
								<hr>
								<form action="/change-env-file-data" method="post">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-6">
											<div class="form-group">
												<label>Key</label>
												<input type="text" class="form-control" name="key" placeholder="Enter Key" required>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label>Value</label>
												<input type="text" class="form-control" name="value" placeholder="Enter Value" required>
											</div>
										</div>
									</div>
									<button id="saveForm" type="submit" class="btn btn-lg btn-info btn-block">
										<i class="fa fa-database fa-lg"></i>&nbsp;
										<span id="payment-button-amount">Update</span>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function refreshPage(){
		window.location.reload();
	}
</script>
@endsection