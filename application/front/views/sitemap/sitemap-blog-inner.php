<!DOCTYPE html>
<html lang="en" ng-app="siteMapBlogListApp" ng-controller="siteMapBlogListController">
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
	<head>
		<title>Blog Sitemap | Aileensoul</title>
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
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">  
		<link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
	</head>
	<body class="sitemap">
		<div class="">
			<header>
				<div class="header">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-sm-6 left-header fw-479">
								<?php $this->load->view('main_logo'); ?>
							</div>
							<div class="col-md-6 col-sm-6 no-login-right old-no-login fw-479">
								<?php if (!$this->session->userdata('aileenuser')) { ?>
									<div class="btn-right">
									<a href="<?php echo base_url('login'); ?>" class="btn4">Login</a>
									<a href="<?php echo base_url('registration'); ?>" class="btn2">Create an account</a>
									</div>
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
						<h3>
							<span>
								<a href="<?php echo base_url().'sitemap/blogs'; ?>">
									Blog Category 
								</a>
							</span>
							<span>{{ cate_name | capitalize }}</span>
						</h3>
						<ul class="blog-inner-link pt20">
							<li ng-repeat="blog in blogPost">
								<a target="_blank" ng-href="<?php echo base_url; ?>blog/{{ blog.blog_slug }}">
							        {{ blog.title }}
								</a>
							</li>
						</ul>
					</div>
				</div>
				<pagination 
				  	ng-model="currentPage"
				  	total-items="total_record"
				  	max-size="maxSize"  
				  	boundary-links="true" ng-show="total_record > 100">
				</pagination>
			</div>		
		</div>
		<?php echo $login_footer ?>
		<!-- <footer class="footer">    
			<div class="container pt20">
				<div class="row">
					<div class="fw text-center">
						<ul class="footer-ul">
							<li><a title="Login" href="#" target="_blank">Login</a></li>
							<li><a title="Create an Account" href="#" target="_blank">Create an Account</a></li>
							<li><a title="Job Profile" href="#" target="_blank">Job Profile</a></li>
							<li><a title="Recruiter Profile" href="#" target="_blank">Recruiter Profile</a></li>
							<li><a title="Freelance Profile" href="#" target="_blank">Freelance Profile</a></li>
							<li><a title="Business Profile" href="#" target="_blank">Business Profile</a></li>
							<li><a title="Artistic Profile" href="#" target="_blank">Artistic Profile</a></li>
							<li><a title="About Us" href="#" target="_blank">About Us</a></li>
							<li><a href="#" title="Terms and Condition" target="_blank">Terms and Condition</a></li>
							<li><a href="#" title="Privacy policy" target="_blank">Privacy Policy</a></li>
							<li><a title="Disclaimer Policy" href="#" target="_blank">Disclaimer Policy</a></li>
							<li><a title="Contact Us" href="#" target="_blank">Contact Us</a></li>
							<li><a title="Blog" href="#" target="_blank">Blog</a></li>
							<li><a title="Send Us Feedback" href="#" target="_blank">Send Us Feedback</a></li>
							<li><a title="Advertise With Us" href="#" target="_blank">Advertise With Us</a></li>
							<li><a title="Sitemap" tabindex="0" href="#" target="_blank">Sitemap</a></li>
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
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
		<script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>		
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
		<script type="text/javascript">
			var category_name = "<?php echo $cate_name; ?>";
			var category_id = "<?php echo $cate_id; ?>";
			var base_url = "<?php echo base_url(); ?>";
			var app = angular.module('siteMapBlogListApp', ['ui.bootstrap']);
		</script>
		<script src="<?php echo base_url('assets/js/webpage/sitemap/bloginner.js?ver=' . time()); ?>"></script>
	</body>
</html>