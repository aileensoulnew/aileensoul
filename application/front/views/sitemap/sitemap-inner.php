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
<html lang="en" ng-app="siteMapInnerApp" ng-controller="siteMapInnerController">
	<head>
		<base href="<?php echo base_url();?>">
		<title ng-bind="title"></title>
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
								<h2 class="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png'); ?>"></a></h2>
							</div>
							<div class="col-md-6 col-sm-6 old-no-login no-login-right fw-479">
								<?php if (!$this->session->userdata('aileenuser')) { ?>
									<div class="btn-right">
									<a href="<?php echo base_url('login'); ?>" class="btn4" target="_self">Login</a>
									<a href="<?php echo base_url('registration'); ?>" class="btn2" target="_self">Create an account</a>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</header>
		</div>
		<div class="middle-section">
			<div class="container mobp0">
				<div class="sitemap">
					<h1>
						<a href="<?php echo base_url().'sitemap'; ?>" target="self">Sitemap</a>
					</h1>
					<div ng-view></div>
				</div>
			</div>
		</div>
		<?php echo $login_footer ?>
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

		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
		<script type="text/javascript">
			var searchword = "<?php echo $searchword; ?>";
			var base_url = "<?php echo base_url(); ?>";
			var app = angular.module('siteMapInnerApp', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);
		</script>
		<script src="<?php echo base_url('assets/js/webpage/sitemap/sitemapinner.js?ver=' . time()); ?>"></script>
	</body>
</html>