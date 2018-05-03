<?php //echo $head; ?>
<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html ng-app="jobReactivateApp">
	<head>
		<meta charset="utf-8">
		<title><?php echo $userdata[0]['first_name']." ".$userdata[0]['last_name'] . " | Reactivate | Job Profile - Aileensoul" ?></title> 
		<?php
		if (IS_JOB_CSS_MINIFY == '0') {
			?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver='.time()); ?>">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver='.time()); ?>">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
			<?php }else{?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver='.time()); ?>">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver='.time()); ?>">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver='.time()); ?>">
		<?php }?>
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/media.css?ver='.time()); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/animate.css?ver='.time()) ?>" />

		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver='.time()); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver='.time()); ?>">
	   	<link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
	</head>
	<!--header start-->
	<?php echo $header; ?>
	<!--header End-->
	<body>
		<?php echo $header_profile; ?>
		<div class="container" id="paddingtop_fixed">
		 	<div class="row">
				<center>
			 		<div class="reactivatebox">
						<div class="reactivate_header">
							<center>
								<h2>Are you sure you want to reactive your job profile? </h2>
							</center>
						</div>
						<div class="reactivate_btn_y">
			 				<a href="<?php echo base_url('job/reactivate'); ?>">Yes</a>
		 				</div>
						<div class="reactivate_btn_n">
							<a href="<?php echo base_url('/') . $this->session->userdata('aileenuser_slug'); ?>">No</a>
					 	</div>
	 				</div>
 				</center>
			</div>
		</div>
		<!-- <footer>     -->    
		<?php echo $footer;  ?>
		<!-- </footer> -->
		<script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
		
		<?php
		if (IS_JOB_JS_MINIFY == '0') {
			?>
			<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
		<?php }else{?>
			<script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver='.time()); ?>"></script>
		<?php }?>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
		<script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>

		<script>
			var app = angular.module('jobReactivateApp', ['ui.bootstrap']);
			var header_all_profile = '<?php echo $header_all_profile; ?>';
			var base_url = '<?php echo base_url(); ?>';
			var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
			var title = '<?php echo $title; ?>';
			var q = '';
			var l = '';
		</script>               
		<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
	</body>
</html>