<!DOCTYPE html>
<?php
	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
		header("HTTP/1.1 304 Not Modified");
		exit();
	}
	$format = 'D, d M Y H:i:s \G\M\T';
	$now = time();
	$date = gmdate($format, $now);
	header('Date: ' . $date);
	header('Last-Modified: ' . $date);
	$date = gmdate($format, $now + 30);
	header('Expires: ' . $date);
	header('Cache-Control: public, max-age=30');
?>
<html lang="en">
	<head>
		<title>Aileensoul</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") { ?>
			<script>
				(function (i, s, o, g, r, a, m) {
					i['GoogleAnalyticsObject'] = r;
					i[r] = i[r] || function () {
						(i[r].q = i[r].q || []).push(arguments)
					}, i[r].l = 1 * new Date();
					a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
					a.async = 1;
					a.src = g;
					m.parentNode.insertBefore(a, m)
				})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
				ga('create', 'UA-91486853-1', 'auto');
				ga('send', 'pageview');
			</script>
			<meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
		<?php } ?>
		<?php $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

		<link rel="canonical" href="<?php echo $actual_link ?>" />
		<meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
	</head>
	<body class="sitemap">
		<div class="web-header">
			<header>
				<div class="header">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-sm-6 left-header fw-479">
								<h2 class="logo"><a href="#">Aileensoul</a></h2>
							</div>
							<div class="col-md-6 col-sm-6 no-login-right fw-479">
								<?php if (!$this->session->userdata('aileenuser')) { ?>
	                                <a href="<?php echo base_url('login'); ?>" class="btn8">Login</a>
	                                <a href="<?php echo base_url('registration'); ?>" class="btn9">Create an account</a>
	                            <?php } ?>
							</div>
						</div>
					</div>
				</div>
			</header>
		</div>	
		<div class="middle-section">
			<div class="container">
				<div class="sitemap">
					<h1>
						<a href="<?php echo base_url().'sitemap'; ?>">Sitemap</a>
					</h1>
					<div class="site-box">
						<div class="">
							<div class="dir-box">
								<h3>Directories</h3>
								<div class="row">
									<div class="col-md-3 col-sm-3">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/people' ?>">	Members 
												</a>
											</li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/artist' ?>">Artist</a>
											</li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/companies' ?>">Companies</a>
											</li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/jobs' ?>">Jobs</a>
											</li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/freelance-jobs' ?>">Freelance Jobs</a>
											</li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li>
												<a href="<?php echo base_url().'sitemap/blogs' ?>">Blog</a>
											</li>
										</ul>
									</div>
								</div>							
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 col-sm-3">
								<div class="site-pr-box">
									<h3>Job Profile</h3>
									<ul>
										<li><a href="<?php echo base_url().'login' ?>">Login  </a></li>
										<li><a href="<?php echo base_url().'job-profile/signup' ?>">Create Account </a></li>
										<li><a href="<?php echo base_url().'job-search' ?>">Job Search </a></li>
										<li><a href="<?php echo base_url().'jobs-by-location' ?>">View Jobs by Location </a></li>
										<li><a href="<?php echo base_url().'jobs-by-skills' ?>">View Jobs by Skills</a></li>
										<li><a href="<?php echo base_url().'jobs-by-designations' ?>">View Jobs by Designation </a></li>
										<li><a href="<?php echo base_url().'jobs-by-companies' ?>">View Jobs by Company </a></li>
										<li><a href="<?php echo base_url().'jobs-by-categories' ?>">View Jobs by Category</a></li>
										<li><a href="<?php echo base_url().'jobs' ?>">View Other Jobs </a></li>
									</ul>
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="site-pr-box">
									<h3>
										<a href="<?php echo base_url().'recruiter' ?>">
											Recruiter Profile
										</a>										
									</h3>
									<ul>
										<li><a href="<?php echo base_url().'login' ?>">Login </a></li>
										<li><a href="<?php echo base_url().'recruiter/signup' ?>">Create Recruiter Account </a></li>
									</ul>
								</div>
								<div class="site-pr-box">
									<h3>Business Profile</h3>
									<ul>
										<li><a href="<?php echo base_url().'login' ?>">Login</a></li>
										<li><a href="<?php echo base_url().'business-profile/registration/business-information' ?>">Create Business Account</a></li>
										<li><a href="<?php echo base_url().'business-search' ?>">Business Search</a></li>
										<li><a href="<?php echo base_url().'business-by-categories' ?>">View Business by Category</a></li>
										<li><a href="<?php echo base_url().'business-by-location' ?>">View Business by Location</a></li>
										<li><a href="<?php echo base_url().'business' ?>">View Other Business</a></li>
									</ul>
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="site-pr-box">
									<h3>
										<a href="<?php echo base_url().'freelance-employer' ?>">
											Freelance Employer Profile
										</a>
									</h3>
									<ul>
										<li><a href="<?php echo base_url().'login' ?>">Login</a></li>
										<li><a href="<?php echo base_url().'freelance-employer/signup' ?>">Create Freelance Employer Account</a></li>
										<li><a href="<?php echo base_url().'post-freelance-project' ?>">Post Projects</a></li>
									</ul>
								</div>
								<div class="site-pr-box">
									<h3>Freelancer Profile</h3>
									<ul>
										<li><a href="<?php echo base_url().'login' ?>">Login  </a></li>
										<li><a href="<?php echo base_url().'freelancer/signup' ?>">Create Freelance Account</a></li>
										<li><a href="<?php echo base_url().'freelance-jobs' ?>">Freelance Jobs</a></li>
										<li><a href="<?php echo base_url().'freelance-jobs-by-fields' ?>">View Freelance Jobs by Fields</a></li>
										<li><a href="<?php echo base_url().'freelance-jobs-by-skills' ?>">View Freelance Jobs by Skills</a></li>
									</ul>
								</div>
							</div>
							<div class="col-md-3 col-sm-3">
								<div class="site-pr-box">
									<h3>Artistic Profile</h3>
									<ul>
										<li><a href="<?php echo base_url().'login' ?>">Login</a></li>
										<li><a href="<?php echo base_url().'artist-profile/signup' ?>">Create Account</a></li>
										<li><a href="<?php echo base_url().'find-artist' ?>">Find Artist</a></li>
										<li><a href="<?php echo base_url().'artist-by-category' ?>">View Artist by Category</a></li>
										<li><a href="<?php echo base_url().'artist-by-location' ?>">View Artist by Location</a></li>
										<li><a href="<?php echo base_url().'artist' ?>">View Other Artist</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="">
							<div class="dir-box">
								<h3>General Information</h3>
								<div class="row">
									<div class="col-md-3 col-sm-3">
										<ul>
											<li><a href="<?php echo base_url() ?>">Home </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li><a href="<?php echo base_url().'about-us' ?>">About Us </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li><a href="<?php echo base_url().'privacy-policy' ?>">Privacy Policy </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li><a href="<?php echo base_url().'disclaimer-policy' ?>">Disclaimer Policy </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li><a href="<?php echo base_url().'terms-and-condition' ?>">Terms & Conditions</a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li><a href="<?php echo base_url().'feedback' ?>">FeedBack </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li><a href="<?php echo base_url().'contact-us' ?>">Contact Us </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li><a href="<?php echo base_url().'advertise-with-us' ?>">Advertise With Us </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li><a href="<?php echo base_url().'report-abuse' ?>"> Report Spam </a></li>
										</ul>
									</div>
									<div class="col-md-3 col-sm-3">
										<ul>
											<li><a href="<?php echo base_url().'faq' ?>"> FAQ </a></li>
										</ul>
									</div>
								</div>							
							</div>
						</div>
					</div>
					<div class="">
						<img src="<?php echo base_url('assets/n-images/sitemap.jpg') ?>" style="width:100%;">
					</div>
				</div>
			</div>
		</div>
		<?php echo $login_footer ?>
		<!-- <footer class="footer">    
			<div class="container pt20">
				<div class="row">
					<div class="fw text-center">
						<ul class="footer-ul">
							<li>
								<a title="Login" href="<?php echo base_url().'' ?>" target="_blank">Login
								</a>
							</li>
							<li>
								<a title="Create an Account" href="<?php echo base_url().'artist' ?>" target="_blank">Create an Account
								</a>
							</li>
							<li>
								<a title="Job Profile" href="<?php echo base_url().'artist' ?>" target="_blank">Job Profile
								</a>
							</li>
							<li>
								<a title="Recruiter Profile" href="<?php echo base_url().'artist' ?>" target="_blank">Recruiter Profile
								</a>
							</li>
							<li>
								<a title="Freelance Profile" href="<?php echo base_url().'artist' ?>" target="_blank">Freelance Profile
								</a>
							</li>
							<li>
								<a title="Business Profile" href="<?php echo base_url().'artist' ?>" target="_blank">Business Profile
								</a>
							</li>
							<li>
								<a title="Artistic Profile" href="<?php echo base_url().'artist' ?>" target="_blank">Artistic Profile
								</a>
							</li>
							<li>
								<a title="About Us" href="<?php echo base_url().'artist' ?>" target="_blank">About Us
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'artist' ?>" title="Terms and Condition" target="_blank">Terms and Condition
								</a>
							</li>
							<li>
								<a href="<?php echo base_url().'artist' ?>" title="Privacy policy" target="_blank">Privacy Policy
								</a>
							</li>
							<li>
								<a title="Disclaimer Policy" href="<?php echo base_url().'artist' ?>" target="_blank">Disclaimer Policy
								</a>
							</li>
							<li>
								<a title="Contact Us" href="<?php echo base_url().'artist' ?>" target="_blank">Contact Us
								</a>
							</li>
							<li>
								<a title="Blog" href="<?php echo base_url().'artist' ?>" target="_blank">Blog
								</a>
							</li>
							<li>
								<a title="Send Us Feedback" href="<?php echo base_url().'artist' ?>" target="_blank">Send Us Feedback
								</a>
							</li>
							<li>
								<a title="Advertise With Us" href="<?php echo base_url().'artist' ?>" target="_blank">Advertise With Us
								</a>
							</li>
							<li>
								<a title="Sitemap" tabindex="0" href="<?php echo base_url().'artist' ?>" target="_blank">Sitemap
								</a>
							</li>
						</ul>
					</div>
					<div class="ftr-copuright text-center pt10 pb20 fw">
						<span>    Ⓒ 2018 | by Aileensoul </span>
					</div>
				</div>
			</div>
		</footer> -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
		<script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()); ?>"></script>
		<script>			
			// mcustom scroll bar
			(function($){
				$(window).on("load",function(){
					$(".custom-scroll").mCustomScrollbar({
						autoHideScrollbar:true,
						theme:"minimal"
					});
				});
			})(jQuery);
		</script>
	</body>
</html>