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
						<a href="index.blade.php">Home</a>
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
				<span>C</span>heckout
			</h3>
			<!-- //tittle heading -->
			<div class="checkout-right">
				<h4 class="mb-sm-4 mb-3">Your shopping cart contains:
					<span>{{Session::has('cart') ? Session::get('cart') -> totalQuantity : ""}}</span>
				</h4>
				<div id="totalPrice">
					Total = ${{$cartItems -> totalPrice}}
				</div>
				<div class="table-responsive">
					<table class="timetable_sub" dusk="table_checkout">
						<thead>
							<tr>
								<th>Product ID</th>
								<th>Product</th>
								<th>Product Name</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Remove</th>
							</tr>
						</thead>
						<tbody>
							
								@foreach($cartItems -> items as $item)
									<tr class="rem1">
									<td class="invert">{{$item['item'] -> idProduct}}</td>
										<td class="invert-image">
											<a href="single.blade.php">
												<img style="width:100px; height:100px;"src="{{ asset('products/'.$item['item']->image_path) }}" alt=" " class="img-responsive">
											</a>
										</td>
					
									<td class="invert">{{$item['item'] -> name}}</td>
									<td class="invert">
										<div class="quantity">
											<div class="quantity-select">
												<div id="minus_{{$item['item'] -> idProduct}}_{{$item['item'] -> amount}}_{{$item['item'] -> price}}" class="entry value-minus">&nbsp;</div>
												<div id="quantity_{{$item['item'] -> idProduct}}" class="entry value">
												<span dusk="quantity">{{(int) $item['quantity']}}</span>
												</div>
												<div id="plus_{{$item['item'] -> idProduct}}_{{$item['item'] -> amount}}_{{$item['item'] -> price}}" class="entry value-plus active">&nbsp;</div>
											</div>
										</div>
									</td>
									<td class="invert">
										<div id="itemPrice_{{{$item['item'] -> idProduct}}}">
											${{$item['price']}}
										</div>
									</td>
										<td class="invert">
											<div class="rem">
												<a href="/checkout/remove/{{$item['item'] -> idProduct}}">
												<div class="close1"> </div>
												</a>
											</div>
										</td>
									</tr>
								@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@if (Auth::check())
				<div class="checkout-left">
					<div class="address_form_agile mt-sm-5 mt-4">
						<div class="checkout-right-basket">
							<a href="checkout/payment">Make Payment
								<span class="far fa-hand-point-right"></span>
							</a>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
	<!-- //checkout page -->

	

	@include('layouts.middle_section')

</body>

</html>

@endsection