@extends('layouts.master')

@section('content')

	@include ('layouts.nav_bar')

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
					<li>Product Detail</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- //page -->

	<!-- Single Page -->
	<div class="banner-bootom-w3-agileits py-5">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>P</span>roduct
				<span>D</span>etail</h3>
			<!-- //tittle heading -->
			@if($product -> active == 1)
				<div class="row">
					<div class="col-lg-5 col-md-8 single-right-left ">
						<div class="grid images_3_of_2">
							<div class="flexslider">
								<ul class="slides">
									<li data-thumb="{{$product->image_path}}">
										<div class="thumb-image">
											<img src="{{ asset('products/'.$product->image_path) }}" data-imagezoom="true" class="img-fluid" alt=""> </div>
									</li>
								</ul>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>

					<div class="col-lg-7 single-right-left simpleCart_shelfItem">
						<h3 class="mb-3">{{$product->name}} </h3>

			

						<div class="single-infoagile">
							<ul>
								<li class="mb-3">
									<div id="averageRate2" value="{{ $globalRateData['globalRate']}}"> Average Rate: {{ $globalRateData['globalRate']}} </div>
									<div id="ratesCount1"> ({{ $globalRateData['ratesQuantity'] }} rates) </div>
								</li>
								<li class="mb-3">
									${{$product -> price}}
								</li>
								@foreach($product -> categories() -> get() as $category)
								<li class="mb-3">
										{{$category -> name}}
								</li>
								@endforeach
							</ul>
						</div>
						<div class="product-single-w3l">
							<p class="my-3">
							<ul>
								<li class="mb-1">
									{{$product -> description}}
								</li>
								<li class="mb-1">
									{{$product -> amount}} in Stock
								</li>
							</ul>
						</div>
						<div class="occasion-cart">
							<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
									<form action="{{route('product.addToCart' , ['id' => $product -> idProduct]) }}" method="get">
											<fieldset>
												<input dusk="add_button" name="" type="submit" value="Add to cart" class="button btn"/>
											</fieldset>
										</form>
							</div>
						</div>
					</div>
				</div>
				@if (Auth::check())
					<h3> Rate </h3>
						<br>
						<div id="globalRate2" value="{{ $globalRateData['globalRate']}}"> Average Rate: {{$globalRateData['globalRate']}}</div>
						<div id="ratesCount2">({{ $globalRateData['ratesQuantity'] }} rates)</div>

						<br><br>
						Your Rate:
						<!-- RATING - Form -->
						@if($userRate -> rate == -1)
							<div id = "starUpdate" class="cont">
								<div class="stars">
								<form id="star_form"  >
									{{ csrf_field() }}
									<input type="hidden" name="idProductStar" value="{{Request::route('id')}}"/>
									<input type="hidden" name="idUserStar" value="{{Auth::id()}}"/>
									<input type="hidden" name="oldRate" value="{{ (int) $userRate -> rate }}"/>
									<input type="hidden" name="ratesCount" value="{{ (int) $globalRateData['ratesQuantity'] }}"/>
									<input type="hidden" name="ratesSum" value="{{ (int) $globalRateData['ratesSum']}}"/>

									<input value="5" class="star star-5" id="star-5-2" type="radio" name="star"/>
									<label class="star star-5" for="star-5-2" dusk="star-rate-2-5"></label>
									<input value="4" class="star star-4" id="star-4-2" type="radio" name="star"/>
									<label class="star star-4" for="star-4-2" dusk="star-rate-2-4"></label>
									<input value="3" class="star star-3" id="star-3-2" type="radio" name="star"/>
									<label class="star star-3" for="star-3-2" dusk="star-rate-2-3"></label>
									<input value="2" class="star star-2" id="star-2-2" type="radio" name="star"/>
									<label class="star star-2" for="star-2-2" dusk="star-rate-2-2"></label>
									<input value="1" class="star star-1" id="star-1-2" type="radio" name="star"/>
									<label class="star star-1" for="star-1-2" dusk="star-rate-2-1"></label>
									
									</form>	
								</div>
								<button id="submitRate" style="width: 100px;" class="btn my-2 my-sm-0" type="submit" dusk="rate-button-2">Rate</button>
							</div>
							<div style="display:none" id="starShow" style="" class="cont">
									<div id="starRestart" class="stars">
										
										<input value="5" class="star star-5" id="star-5-2" type="radio" name="star"/>
										<label class="star star-5" for="star-5-2"></label>
										<input value="4" class="star star-4" id="star-4-2" type="radio" name="star"/>
										<label class="star star-4" for="star-4-2"></label>
										<input value="3" class="star star-3" id="star-3-2" type="radio" name="star"/>
										<label class="star star-3" for="star-3-2"></label>
										<input value="2" class="star star-2" id="star-2-2" type="radio" name="star"/>
										<label class="star star-2" for="star-2-2"></label>
										<input value="1" class="star star-1" id="star-1-2" type="radio" name="star"/>
										<label class="star star-1" for="star-1-2"></label>
										
										
										
									</div>
									<button id="updateRate" style="width: 100px;" class="btn my-2 my-sm-0" type="submit">Update</button>
								</div>

						@else
						<div style="display:none" id = "starUpdate" class="cont">
								<div class="stars">
								<form id="star_form"  >
									{{ csrf_field() }}
									<input type="hidden" name="idProductStar" value="{{Request::route('id')}}"/>
									<input type="hidden" name="idUserStar" value="{{Auth::id()}}"/>
									<input type="hidden" name="oldRate" value="{{ (int) $userRate -> rate }}"/>
									<input type="hidden" name="ratesCount" value="{{ (int) $globalRateData['ratesQuantity']}}"/>
									<input type="hidden" name="ratesSum" value="{{ (int) $globalRateData['ratesSum']}}"/>

									<input value="5" class="star star-5" id="star-5-2" type="radio" name="star"/>
									<label class="star star-5" for="star-5-2" dusk="star-rate-1"></label>
									<input value="4" class="star star-4" id="star-4-2" type="radio" name="star"/>
									<label class="star star-4" for="star-4-2" dusk="star-rate-1"></label>
									<input value="3" class="star star-3" id="star-3-2" type="radio" name="star"/>
									<label class="star star-3" for="star-3-2" dusk="star-rate-1"></label>
									<input value="2" class="star star-2" id="star-2-2" type="radio" name="star"/>
									<label class="star star-2" for="star-2-2" dusk="star-rate-1"></label>
									<input value="1" class="star star-1" id="star-1-2" type="radio" name="star"/>
									<label class="star star-1" for="star-1-2" dusk="star-rate-1"></label>
									
									</form>	
								</div>
								<button dusk="rate_button" id="submitRate" style="width: 100px;" class="btn my-2 my-sm-0" type="submit">Rate</button>
							</div>
							<div id="starShow" style="" class="cont">
									<div id="starRestart" class="stars">
										
										@for ($i = 5; $i > 0; $i--)
											@if ($i == $userRate -> rate)
											<input value="{{$i}}" class="star star-{{$i}}" id="star-{{$i}}-2" type="radio" name="star" dusk="star-rating-{{$i}}" checked/>
											@else
											<input value="{{$i}}" class="star star-{{$i}}" id="star-{{$i}}-2" type="radio" name="star" dusk="star-rating-{{$i}}"/>
											@endif
											<label value="{{$i}}" class="star star-{{$i}}" for="star-{{$i}}-2"></label>
											
										@endfor
										
										
										
									</div>
									<button id="updateRate" style="width: 100px;" class="btn my-2 my-sm-0" type="submit">Update</button>
								</div>
							@endif
					@endif

					<br>
					
					<!-- first section -->
					<br><br>
					<h3> Opinions </h3>
					<br>
					@if (Auth::check())
						<div class="panel-body">
							@if (session('status'))
								<div class="alert alert-success">
									{{ session('status') }}
								</div>
							@endif
							<form id="form-inline" method="post" action="{{ route('comments.store') }}">
								{{ csrf_field() }}
							<input type="hidden" name="idProduct" value="{{Request::route('id')}}" >
								<div class="col-10 agileits_search" style="padding: 10px;">
									<div class="form-group">
										<textarea style="width:800px; height:75px;" name="comment" placeholder="Write something about the product..."></textarea>
										
									</div>
									<button dusk="post_botton" style="width: 100px;" class="btn my-2 my-sm-0" type="submit">Post</button>
								</div>
								
							</form>
						</div>
					@endif
					<br><br>
					<!--Show comments-->
					<div class="container">
						<div class="row">
							
							@foreach($comments as $comment)
								<div class="col-sm-8">
									<div class="panel panel-white post panel-shadow">
										<div class="post-heading">
											<div class="pull-left meta">
												<div class="title h5">
													<a href="#"><b>{{ $comment -> name }} </b></a>
													
												</div>
												<h6 class="text-muted time">{{ $comment -> created_at }}</h6>
											</div>
										</div> 
										<div class="post-description"> 
											<textarea style="width:500px; height:75px; border:none; background-color: transparent; resize: none; outline: none;" disabled="disabled">{{ $comment -> content }}</textarea>
											<div class="stats">
												@if(Auth::check())
													<a id="replyButton_{{$comment -> idComment }}"  class="btn btn-default stat-item">
														<i class=""></i>Reply
													</a>
													@if (Auth::id() == $comment -> idUser)
														<a id="deleteButton_{{$comment -> idComment }}" href="{{action('CommentController@destroy', ['comment' => $comment -> idComment])}}" class="btn btn-default stat-item">
															<i class=""></i>Delete
														</a>
													@endif
												@endif
											</div>

											<!--Reply field-->
											<div style="display:none;" id="commentReply_replyButton_{{$comment -> idComment}}">
												<form method="post" action="{{ route('replies.store') }}">
													{{ csrf_field() }}
													<input type="hidden" name="idComment" value="{{$comment -> idComment}}" >
													<div class="col-10 agileits_search" style="padding: 10px;">
														<div class="form-group">
															<textarea style="width:500px; height:75px;" name="reply" placeholder="Write something about the product..."></textarea>
															
														</div>
													<button style="width: 100px;" class="btn my-2 my-sm-0" type="submit">Reply</button>
													</div>
												</form>
											</div>
											<!--Reply field-->

										</div>

										@foreach($comment -> replies as $reply)
											<div class="col-sm-8">
												<div class="panel panel-white post panel-shadow">
													<div class="post-heading">
														<div class="pull-left meta">
															<div class="title h5">
																<a href="#"><b>{{ $reply -> name }} </b></a>
																<!-- Rating -->
															</div>
															<h6 class="text-muted time">{{ $reply -> created_at }}</h6>
														</div>
													</div> 
													<div class="post-description"> 
														<textarea style="width:300px; height:25px; border:none; background-color: transparent; resize: none; outline: none;" disabled="disabled">{{ $reply -> reply }}</textarea>
														<div class="stats">
															@if(Auth::check())
																@if(Auth::id() == $reply -> idUser)
																	<a href="{{action('ReplyController@destroy', ['reply' => $reply -> idReply])}}" class="btn btn-default stat-item">
																		<i class=""></i>Delete
																	</a>
																@endif
															@endif
														</div>
													</div>
												</div>
											</div>
										@endforeach
									</div>
								</div>
							@endforeach
						</div>
					</div>
						<!-- //first section -->
			@endif
		</div>

		
	</div>
	<!-- //Single Page -->


	@include('layouts.middle_section')
</body>

</html>

@endsection