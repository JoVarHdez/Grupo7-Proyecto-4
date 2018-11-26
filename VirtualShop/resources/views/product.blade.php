
@extends('layouts.master')

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
						<a href="/index">Home</a>
						<i>|</i>
					</li>
					<li>Products</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->

	<!-- top Products -->
	<div class="ads-grid py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				{{Session::has('categorySearched') ? Session::get('categorySearched') : 'Products'}}</h3>
			<!-- //tittle heading -->

			<div class="row">
				<!-- product left -->
				<div class="agileinfo-ads-display col-lg-9">
					<div class="wrapper">


						<!-- first section -->
						@foreach(array_chunk($products, 15) as $productChunk)
							<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
								<div class="row">
							@foreach ($productChunk as $product)
								
								<div class="col-md-4 product-men mt-5">
										<div class="men-pro-item simpleCart_shelfItem">
											<div class="men-thumb-item text-center">
												<img class="img-index" src="{{ asset('products/'.$product->image_path) }}" alt="">
												<div class="men-cart-pro">
													<div class="inner-men-cart-pro">
														<a href="{{route('product.showDetail' , ['id' => $product -> idProduct]) }}" class="link-product-add-cart">Quick View</a>
													</div>
												</div>
												@if($product -> amount > 0)
													<span class="product-new-top">In Stock: {{$product -> amount}}</span>
												@else
													<span class="product-new-top">Out of Stock</span>
												@endif
											</div>
											<div class="item-info-product text-center border-top mt-4">
												<h4 class="pt-1">
													<a href="{{route('product.showDetail' , ['id' => $product -> idProduct]) }}">{{$product -> name}}</a>
												</h4>
												@inject('productClass', 'App\Product')
												<div class="info-product-price my-2">
												<span class="item_price">${{$product -> price}}</span><br>
												<span class="item_price">Global Rate: {{number_format($product -> globalRate, 1)}}</span>
													<!--<del>$280.00</del>-->
												</div>
												<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
													<form action="{{route('product.addToCart' , ['id' => $product -> idProduct]) }}" method="get">
															<fieldset>
																<input name="addToCart" type="submit" value="Add to cart" class="button btn"/>
															</fieldset>
														</form>
												</div>
											</div>
										</div>
									</div>
								
							@endforeach
								</div>
							</div>
						@endforeach
						<!-- //first section -->
						
					</div>
				</div>
				<!-- left -->
			</div>
		</div>
	</div>
	<!-- //top products -->


	@include('layouts.middle_section')

</body>

</html>

@endsection