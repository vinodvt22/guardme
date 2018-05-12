<!DOCTYPE html>
<html lang="en">
<head>

    

   @include('style')
	




</head>
<body>

    

    <!-- fixed navigation bar -->
   
    	@include('header')

    <!-- slider -->
    

<section class=" job-bg ad-details-page">
	<div class="container">
		<div class="breadcrumb-section">
			<ol class="breadcrumb">
				<li><a href="{{URL::to('/')}}">Home</a></li>
				<li>Wallet</li>
			</ol>						
			<h2 class="title">Wallet</h2>
		</div>
	
	


		<div class="adpost-details post-resume">
			

			<div class="row">
				<div class="col-md-8">
					<div class="section postdetails">
						<div class="description-info">
							<h2>Wallet</h2>
							
							
							<table class="table table-striped">
								<!-- <thead>
									<tr>
										<th>Title</th>
										<th>Debit/Credit</th>
										<th>Amount</th>
									</tr>
								</thead> -->
								<tbody>
								@if($all_transactions->count() >0)
									@foreach($all_transactions as $trans)
										<tr>
											<td>{{ $trans->title }}</td>
											<td>{{ $trans->debit_credit_type }}</td>
											<td>£ {{ $trans->amount }}</td>
										</tr>
									@endforeach
								
									<!-- <tr >
										<td>title</td>
										<td>credit/debit</td>
										<td>amount</td>
									</tr> -->
								@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="section job-short-info center balance">
						<h5>Escrow Balance</h5>
						<ul>
							<li>
								<p class="font-35">£
									@if($escrow_balance==0)
										0.00
									@else
										{{ $escrow_balance }}
									@endif
								</p>
							</li>
							
							
						</ul>
					</div>

					<div class="section quick-rules job-postdetails">
						<h4>Heading1</h4>
						<ul>
							<li>
								lorem ipsum dolor sit amet, consectetur adipiscing elit
							</li>
							<li>
								lorem ipsum dolor sit amet, consectetur adipiscing elit
							</li>
							<li>
								lorem ipsum dolor sit amet, consectetur adipiscing elit
							</li>
							<li>
								lorem ipsum dolor sit amet, consectetur adipiscing elit
							</li>
							<li>
								lorem ipsum dolor sit amet, consectetur adipiscing elit
							</li>
							
						</ul>
					</div>


					<div class="section quick-rules job-postdetails">
						<h4>Heading2</h4>
						<ul>
							<li>
								lorem ipsum dolor sit amet, consectetur adipiscing elit
							</li>
							<li>
								lorem ipsum dolor sit amet, consectetur adipiscing elit
							</li>
							<li>
								lorem ipsum dolor sit amet, consectetur adipiscing elit
							</li>
							<li>
								lorem ipsum dolor sit amet, consectetur adipiscing elit
							</li>
							<li>
								lorem ipsum dolor sit amet, consectetur adipiscing elit
							</li>
							
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


      @include('footer')
</body>
</html>