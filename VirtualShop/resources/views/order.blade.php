@extends('layouts.master')
<!-- Bootstrap core CSS -->

@section('content')

	@include ('layouts.nav_bar_products')
	

	<!-- banner-2 -->
	<div class="page-head_agile_info_w3l">

	</div>
	<!-- //banner-2 -->
	<!-- page -->
	<div class="services-breadcrumb">
		<div class="agile_inner_breadcrumb">
			<div class="container">
				<ul class="w3_short">
					<li>
						<a href="\index">Home</a>
						<i>|</i>
					</li>
					<li>Checkout</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->
	<!-- checkout page -->
	<div class="privacy py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>O</span>rders
			</h3>
			<!-- //tittle heading -->
			<div class="checkout-right">
				<h4 class="mb-sm-4 mb-3">Orders made
					<span></span>
				</h4>
				<form class="form-inline" action="/order" method="post">
								{{ csrf_field() }}
									<input value="" name="orderId" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" >
									<button style="width: 100px;" class="btn my-2 my-sm-0" type="submit">Search</button>
							</form>

				<div class="table-responsive">
					<table class="timetable_sub">
						<thead>
							<tr>
								<th>Order ID</th>
								<th>Date</th>
                                <th>Products</th>
                                <th>Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach($orders as $order)
								<tr class="rem1">
								<td class="invert">
                                    {{$order -> idOrder}}
								</td>
                                <td class="invert">{{$order -> created_at}}</td>
                                <td class="invert">
                                    <ul>
                                        @foreach($order -> products as $product)
                                            
											<li>
												{{$product -> name}} ({{$product -> productQuantity}})
											</li>
                                            
                                        @endforeach
                                    </ul>
                                </td>
								<td class="invert">
									${{$order -> total}}
								</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- //checkout page -->

	@include('layouts.middle_section')

</body>

</html>

@endsection