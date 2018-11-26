	<!-- top Products -->
	<div class="ads-grid py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>P</span>roducts</h3>
			<!-- //tittle heading -->
			<div class="row">
				<!-- product left -->
				<div class="agileinfo-ads-display col-lg-9">
					<div class="wrapper">
						<!-- first section -->
				
						@foreach($categories as $category)
							<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
								<h3 class="heading-tittle text-center font-italic">{{$category -> name}} </h3>
								<div class="row">
									@foreach($category -> products() -> get() -> chunk(3) as $productChunk)
										@if(!$productChunk -> isEmpty())
											@foreach ($productChunk as $product)
												@if(!is_null($product))
													<div class="col-md-4 product-men mt-5">
														<div class="men-pro-item simpleCart_shelfItem">
															<div class="men-thumb-item text-center">
																<img class="img-index" src="{{ asset('products/'.$product->image_path) }}" alt="">
																<div class="men-cart-pro">
																	<div class="inner-men-cart-pro">
																		<a name="quickView" href="{{route('product.showDetail' , ['id' => $product -> idProduct]) }}" class="link-product-add-cart">Quick View</a>
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
																<div class="info-product-price my-2">
																<span class="item_price">${{$product -> price}}</span>
																	<!--<del>$280.00</del>-->
																</div>
																<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
																	<form action="{{route('product.addToCart' , ['id' => $product -> idProduct]) }}" method="get">
																		<fieldset>
																			<input name="" type="submit" value="Add to cart" class="button btn"/>
																		</fieldset>
																	</form>
																</div>
															</div>
														</div>
													</div>
												@endif
											@endforeach
										@else
											<div class="col-md-4 product-men mt-5">
												<div class="col-md-4 product-men mt-5">
												</div>
											</div>
											<div class="col-md-4 product-men mt-5">
												<div class="col-md-4 product-men mt-5">
													
													<div class="item-info-product text-center border-top mt-4">		
															<h4 class="pt-1">
																	<a href="single">No Products to show</a>
																</h4>	
													</div>
												</div>
											</div>
											<div class="col-md-4 product-men mt-5">
												<div class="col-md-4 product-men mt-5">
												</div>
											</div>
										@endif
									@endforeach
								</div>
							</div>
						@endforeach
						

						
				<!-- //product left -->
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- //top products -->