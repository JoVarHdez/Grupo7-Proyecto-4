	<!-- header-bottom-->
	<div class="header-bot">
		<div class="container">
			<div class="row header-bot_inner_wthreeinfo_header_mid">
				<!-- logo -->
				<div class="col-md-3 logo_agile">
					<h1 class="text-center">
						<a href="/index" class="font-weight-bold font-italic">
							<img src="{{asset('images/logo2.png')}}" alt=" " class="img-fluid">Virtual Shop
						</a>
					</h1>
				</div>
				<!-- //logo -->

				
				<!-- search -->
				<div class="col-md-9 header mt-4 mb-md-0 mb-4">
					<div class="row">

						<div class="col-10 agileits_search">
							<form class="form-inline" action="/product" method="post">
								{{ csrf_field() }}
								
									<select id="agileinfo-nav_search2" name="categorySearch" class="border" style="width: 200px;" >
											<option value="">All Categories</option>
											@foreach($categories as $category)
												@if(Session::has('categorySearched') && Session::get('categorySearched') == $category -> name)
													<option selected="selected" value="{{$category -> idCategory}}">{{$category -> name}}</option>
												@else
													<option value="{{$category -> idCategory}}">{{$category -> name}}</option>
												@endif
											@endforeach
									</select>

									&nbsp; &nbsp; &nbsp;
									Sort by Rate:
									<select id="agileinfo-nav_search2" name="sortRate" class="border" style="width: 200px;" >
										@for ($i = 5; $i >= 1; $i--)
											@if(Session::has('sortRate') && Session::get('sortRate') == $i)
												<option selected="selected" value="{{$i}}">{{$i}}.x</option>
											@else
												@if($i == 5)
													<option selected="selected"  value="{{$i}}">{{$i}}.x</option>
												@else

													<option value="{{$i}}">{{$i}}.x</option>
												@endif
											@endif
										@endfor
										<option value="0"> Without rate </option>
								</select>
									<input value="{{Session::has('searched') ? Session::get('searched') : ""}}" name="search" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" >
									<button style="width: 100px;" class="btn my-2 my-sm-0" type="submit">Search</button>
							</form>
						</div>

						<div class="col-2 top_nav_right text-center mt-sm-0 mt-2">
							<div class="wthreecartaits wthreecartaits2 cart cart box_1">
								
								<button dusk="cart_botton" href="#" data-toggle="modal" data-target="#cart" class="btn w3view-cart" type="submit" value="">
									<i class="fas fa-cart-arrow-down"></i>
								</button>
						
							</div>
							<h6>items: {{Session::has('cart') ? Session::get('cart') -> totalQuantity : "0"}}</h6>
						</div>
						<!-- //cart details -->
					</div>
				</div>
				<!-- //search -->
						
						
			</div>
		</div>
	</div>
	<!-- shop locator (popup) -->
	<!-- //header-bottom -->