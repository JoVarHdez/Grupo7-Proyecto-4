<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="zxx">

<head>

	<title>Virtual Shop</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="Virtual Shop"/>
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
		<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<!-- //Meta tag Keywords -->


	<meta name="_token" content="{{ csrf_token() }}" /> 
	<script>$.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })</script> 

	
	<!-- Custom-Files -->
	<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
	<!-- Bootstrap css -->
	<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
	<!-- Main css -->
	<link rel="stylesheet" href="{{ asset('css/fontawesome-all.css') }}">
	<!-- Font-Awesome-Icons-CSS -->
	<link href="{{ asset('css/popuo-box.css') }}" rel="stylesheet" type="text/css" media="all" />
	<!-- pop-up-box -->
	<link href="{{ asset('css/menu.css') }}" rel="stylesheet" type="text/css" media="all" />
	<!-- menu style -->

	<!-- calification star style -->
	<link href="{{ asset('css/starRating.css') }}" rel="stylesheet" />
	<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

	<!-- //Custom-Files -->


	<!-- star califications -->
	<link rel="stylesheet" href="{{ asset('css/starRating.css') }}">
	<link href="http://www.cssscript.com/wp-includes/css/sticky.css" rel="stylesheet" type="text/css">

	<!-- web fonts -->
	<link href="{{ url('//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext') }}" rel="stylesheet">
	<link href="{{ url('//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese') }}" rel="stylesheet">
	<!-- //web fonts -->

	<!-- COMMENTS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-comments.css') }}">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<!-- Data -->


	

 <link href="{{ asset('css/comment.css') }}" rel="stylesheet">


	<!-- COMMENTS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	@yield('styles')

</head>

<body>
	@include ('layouts.top_header')
	@include ('layouts.errors')

	@if ($flash = session('message'))
      <div id="flash-message" class="alert alert-success" role='alert'>
        
          {{ $flash }}

      </div>
    @endif

	@include ('layouts.search_bar')
	
	@yield('content')
	
	@include ('layouts.footer')

	<!-- copyright -->
	<div class="copy-right py-3">
		<div class="container">
			<p class="text-center text-white">© 2018 Electro Store. All rights reserved | Design by
				<a href="http://w3layouts.com"> W3layouts.</a>
			</p>
		</div>
	</div>
	<!-- //copyright -->

	<!-- js-files -->
	<!-- jquery -->
	<script src="{{asset('js/jquery-2.2.3.min.js')}}"></script>
	<!-- //jquery -->

	<!-- nav smooth scroll -->
	<script>
		$(document).ready(function () {
			$(".dropdown").hover(
				function () {
					$('.dropdown-menu', this).stop(true, true).slideDown("fast");
					$(this).toggleClass('open');
				},
				function () {
					$('.dropdown-menu', this).stop(true, true).slideUp("fast");
					$(this).toggleClass('open');
				}
			);
		});
	</script>
	<!-- //nav smooth scroll -->

	<!-- popup modal (for location)-->
	<script src="{{asset('js/jquery.magnific-popup.js')}}"></script>
	<script>
		$(document).ready(function () {
			$('.popup-with-zoom-anim').magnificPopup({
				type: 'inline',
				fixedContentPos: false,
				fixedBgPos: true,
				overflowY: 'auto',
				closeBtnInside: true,
				preloader: false,
				midClick: true,
				removalDelay: 300,
				mainClass: 'my-mfp-zoom-in'
			});

		});
	</script>
	<!-- //popup modal (for location)-->

	<!-- cart-js -->

	<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-center">Shopping Cart</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
							
						<form action="/checkout" method="get" class="" target="">   
							 
							@if (Session::has('cart') && !is_null($cartItems) && !is_null($cartItems -> items))
								@if ($cartItems -> totalQuantity == 0)
									<ul>              
								
										<li class="">	Cart is empty.
										</li>
									</ul>
								@else
									<div id="totalPriceC">
										Total = ${{$cartItems -> totalPrice}}
									</div>
									
									<table class="timetable_sub">
										<thead>
											<tr>
												<th>Product Name</th>
												<th>Quantity</th>
												<th>Price</th>
											</tr>
										</thead>
										<tbody>
											@foreach($cartItems -> items as $item)
												<tr class="rem1">
												<td class="invert">{{$item['item'] -> name}}</td>
												<td class="invert">
													<div class="quantity">
														<div class="quantity-select">
															<div id="minus_{{$item['item'] -> idProduct}}_{{$item['item'] -> amount}}_{{$item['item'] -> price}}" class="entry value-minus">&nbsp;</div>
															<div id="quantityC_{{$item['item'] -> idProduct}}" class="entry value">
															<span>{{(int) $item['quantity']}}</span>
															</div>
															<div id="plus_{{$item['item'] -> idProduct}}_{{$item['item'] -> amount}}_{{$item['item'] -> price}}" class="entry value-plus active">&nbsp;</div>
														</div>
													</div>
												</td>
												<td class="invert">
													<div id="itemPriceC_{{{$item['item'] -> idProduct}}}">
														${{$item['price']}}
													</div>
												</td>
													
												</tr>
											@endforeach
										</tbody> 
									</table>
									<div class="right-w3l">
											<input type="submit" class="form-control" value="Checkout">
										</div>
								@endif
							@else
								<ul>              
								
									<li class="">	Cart is empty.
									</li>
								</ul>
							@endif
						</form>
					</div>
				</div>
			</div>
		</div>
	<!-- //cart-js -->

	<!-- password-script -->
	<script>
		window.onload = function () {
			document.getElementById("password1").onchange = validatePassword;
			document.getElementById("password2").onchange = validatePassword;
		}

		function validatePassword() {
			var pass2 = document.getElementById("password2").value;
			var pass1 = document.getElementById("password1").value;
			if (pass1 != pass2)
				document.getElementById("password2").setCustomValidity("Passwords Don't Match");
			else
				document.getElementById("password2").setCustomValidity('');
			//empty string means no validation error
		}
	</script>
	<!-- //password-script -->

	<script src="{{asset('js/checkoutPage.js')}}"></script>
		<!--quantity-->
	
	<!-- scroll seller -->
	<script src="{{asset('js/scroll.js')}}"></script>
	<!-- //scroll seller -->

	<!-- smoothscroll -->
	<script src="{{asset('js/SmoothScroll.min.js')}}"></script>
	<!-- //smoothscroll -->

	<!-- start-smooth-scrolling -->
	<script src="{{asset('js/move-top.js')}}"></script>
	<script src="{{asset('js/easing.js')}}"></script>
	<script>
		jQuery(document).ready(function ($) {
			$(".scroll").click(function (event) {
				event.preventDefault();

				$('html,body').animate({
					scrollTop: $(this.hash).offset().top
				}, 1000);
			});
		});
	</script>
	<!-- //end-smooth-scrolling -->

	<!-- smooth-scrolling-of-move-up -->
	<script>
		$(document).ready(function () {
			/*
			var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
			};
			*/
			$().UItoTop({
				easingType: 'easeOutQuart'
			});

		});
	</script>
	<!-- //smooth-scrolling-of-move-up -->

	<!-- for bootstrap working -->
	<script src="{{ asset('js/bootstrap.js') }}"></script>
	<!-- //for bootstrap working -->
	<!-- //js-files -->

	<script src="{{ asset('js/comment.js') }}"></script>
	<script src="{{ asset('js/starRating.js') }}"></script>
</body>

</html>