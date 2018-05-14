<!DOCTYPE html>
<html lang="en">
<head>

    

   @include('style')
	




</head>
<body>

    

    <!-- fixed navigation bar -->
   
    	@include('header')

    <!-- slider -->
    

<section class="clearfix job-bg  ad-profile-page">
	<div class="container">
		<div class="breadcrumb-section">
			<ol class="breadcrumb">
				<li><a href="{{URL::to('/')}}">Home</a></li>
				<li>Wallet</li>
			</ol>						
			<h2 class="title">Wallet</h2>
		</div>
	
	


	<div class="career-objective section">
		<div class="user-pro-section">


			<!-- profile-details -->
			<div class="profile-details section">


				<h2>Wallet</h2>
			</div>
		</div>
<div class="err-msg" align="center">Your Escrow balance is : £{{ $escrow_balance }}</div>
<div class="clearfix">&nbsp;</div>
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Debit/Credit</th>
					<th>Amount</th>
				</tr>
			</thead>
			<tbody>
			@foreach($all_transactions as $trans)
				<tr style="@if($trans->debit_credit_type == 'debit') background: #90EE90; @else background: #FFB6C1;  @endif">
					<td>{{ $trans->title }}</td>
					<td>{{ $trans->debit_credit_type }}</td>
					<td>{{ $trans->amount }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>

	</div>
</div>
</section>


      @include('footer')
</body>
</html>