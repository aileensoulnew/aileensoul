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
		<meta name="description" content="{{metadesc}}" />
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
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
	<?php $this->load->view('adsense'); ?>
</head>
	<body class="sitemap">
		<div class="">
			<header>
				<div class="header">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-sm-6 left-header fw-479">
								<h2 class="logo"><a href="<?php echo base_url(); ?>">
									<svg>
										<text class="logo-size" x="0" y="25" fill="#fff">Aileensoul</text>
									</svg>
								</a></h2>
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

		<script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
        <script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-sanitize-1.6.4.js?ver=' . time()); ?>"></script>
		<script type="text/javascript">
			var searchword = "<?php echo $searchword; ?>";
			var base_url = "<?php echo base_url(); ?>";
			var app = angular.module('siteMapInnerApp', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);
			var title = "<?php echo $title ?>";
			var metadesc = "<?php echo $metadesc ?>";
		</script>
		<script src="<?php echo base_url('assets/js/webpage/sitemap/sitemapinner.js?ver=' . time()); ?>"></script>
	</body>
</html>