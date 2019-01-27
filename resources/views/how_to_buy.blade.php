@extends('common.default')

@section('content')

{{!! $content !!}}
<?php /*
	<section id="content">

	<div class="content">
		<div class="container">

			<div class="slide-image slide-buy-back">
				<center>
					{!! Html::image("images/slide.jpeg", "slide",array('class'=>'img-responsive')) !!}
				</center>
			</div><!-- slide image end -->
		</div><!-- container end -->

		<div class="container">
			<div class="section-heading">
				<h2>How To Buy ?</h2>
			</div>
			<div class="section-content buy-image">
				<div class="part-one">
					<div class="part-one-image">
						{!! Html::image("images/tabs.jpg", "Welcome") !!}
					</div><!-- part-one-image end -->

					<div class="part-one-left-line">
						<canvas id="part-one" width="30" height="170"></canvas>
					</div><!-- part-one-left-line end -->

					<div class="part-one-content">
						<div class="part-one-content-heading">
							<strong>
								Register an account with OpenSupermall.com
							</strong>
							<div class="part-one-content-desc">
								<p> > Click the "Sign in" or "Sign Up" button if you have not registered an account.</p>
								<p> > Fill up buyer registration form.</p>
								<p> > if you are facing any problems, please do call out help line : <span>+6012-272 0667</span></p>
							</div>
						</div><!-- part-one-content-heading end -->
					</div><!-- part-one-content end -->

					<div class="part-one-number">
						<span>1</span>
					</div><!-- part-one end -->

					<div class="clearfix"></div>
				</div><!-- part-one-number end -->

				<div class="end-line">
					<canvas id="end-line" width="150" height="16" ></canvas>
				</div><!-- end-line -->

				<div class="part-two">
					<div class="part-two-number">
						<span>2</span>
					</div><!-- part-two-number end -->

					<div class="part-two-content">
						<div class="part-two-content-heading">
							<div class="part-two-content-desc">
								<p> After successful registration,login to your own profile.</p>
							</div>
						</div>
					</div><!-- part-two-content end -->

					<div class="part-two-image">
						{!! Html::image("images/computer.png", "Welcome") !!}
					</div><!-- part-two-image end -->
					<div class="clearfix"></div>

				</div><!-- part-two end -->

				<div class="part-three">
					<div class="part-three-line">
						<canvas id="part-three" width="100" height="130"></canvas>
					</div>
					<div class="clearfix"></div>
				</div><!-- part-three -->


				<div class="end-line">
					<canvas id="end-line-1" width="150" height="16" ></canvas>
				</div><!-- end-line -->


				<div class="part-four">
					<div class="part-four-image">
						{!! Html::image("images/computer2.jpg", "Welcome") !!}
					</div><!-- part-four-image end -->

					<div class="part-four-content">
						<div class="part-four-content-heading">
							<strong>
								Select your product.
							</strong>
							<div class="part-four-content-desc">
								<p> > Choose your fevorite product, and put them in your shopping cart.</p>
								<p> > Choose the shipping option.</p>
								<p> > Read the terms & Conditions and agree. </p>
								<p> > Read the Refund & Refund policy and agree. </p>
							</div>
						</div><!-- part-four-content-heading end -->
					</div><!-- part-four-content end -->

					<div class="part-four-number">
						<span>3</span>
					</div><!-- part-four-number end -->

					<div class="part-four-line">
						<canvas id="part-four" width="200" height="250"></canvas>
					</div>
					<div class="clearfix"></div>
				</div><!-- part-four-number end -->


				<div class="end-line">
					<canvas id="end-line-2" width="150" height="16" ></canvas>
				</div><!-- end-line -->


				<div class="part-five">
					<div class="part-five-number">
						<span>4</span>
					</div><!-- part-five-number end -->

					<div class="part-five-image">
						{!! Html::image("images/mail.jpg", "Welcome") !!}
					</div><!-- part-five-image end -->

					<div class="part-five-content">
						<div class="part-five-content-heading">
							<strong>
								Make payment.
							</strong>
							<div class="part-five-content-desc">
								<p> > View your shopping cart.</p>
								<p> > Go through your order list.</p>
								<p> > Once satisfied, select option to make payment. </p>
								<p> > Read the terms & conditions and agree. </p>
							</div>
						</div><!-- part-five-content-heading end -->
					</div><!-- part-five-content end -->

					<div class="clearfix"></div>
				</div><!-- part-five-number end -->

				<div class="part-six">
					<div class="part-six-line">
						<canvas id="part-six" width="200" height="250"></canvas>
					</div>
				</div><!-- part-six end -->

				<div class="end-line">
					<canvas id="end-line-3" width="150" height="16" ></canvas>
				</div><!-- end-line -->

				<div class="part-svn">
					<div class="part-svn-image">
						{!! Html::image("images/po.jpg", "Welcome") !!}
					</div><!-- part-svn-image end -->
					<div class="part-svn-content">
						<div class="part-svn-content-heading">
							<strong>
								Check your purchase order list.
							</strong>
							<div class="part-svn-content-desc">
								<p> > Keep track of your confirmed purchase order by head to order management at your profile .</p>
							</div>
							<div class="clearfix"></div>
						</div><!-- part-svn-content-heading end -->
					</div><!-- part-svn-content end -->
					<div class="part-svn-number">
						<span>5</span>
					</div><!-- part-svn-number end -->
					<div class="clearfix"></div>
				</div><!-- part-svn-number end -->

				<div class="adjust">
					<div class="part-eight">
						<div class="part-eight-line">
							<canvas id="part-eight" width="100" height="150"></canvas>
						</div>
					</div><!-- part-eight end -->
				</div>

				<div class="end-line">
					<canvas id="end-line-4" width="150" height="16" ></canvas>
				</div><!-- end-line -->

				<div class="part-nine">
					<div class="part-nine-number">
						<span>6</span>
					</div><!-- part-nine-number end -->

					<div class="part-nine-image">
						{!! Html::image("images/transport.jpg", "Welcome") !!}
					</div><!-- part-nine-image end -->

					<div class="part-nine-content">
						<div class="part-nine-content-heading">
							<strong>
								Product Delivery
							</strong>
							<div class="part-nine-content-desc">
								<p> > The product will be shipped to your state location within 10 business days in  accordance to your	shipping service.</p>
								<p> > Track our purchase order at your own profile list.</p>
								<p> > Order tracking number will be sent to you via email.</p>
							</div>
							{{-- <div class="clearfix"></div> --}}
						</div><!-- part-nine-content-heading end -->
					</div><!-- part-nine-content end -->
						<div class="clearfix"></div>
				</div><!-- part-nine-number end -->

				<div class="end-line">
					<canvas id="end-line-5" width="150" height="16" ></canvas>
				</div><!-- end-line -->

			</div><!-- buy image end -->
		</div><!-- container end -->
	</div><!-- content end -->
	
</section><!-- section content end -->
 */
	?>
@stop

