<!DOCTYPE html>
<head>
  <title><?php echo $title; ?></title>
  <!-- start head -->
  <?php //echo $head; ?>
  <!-- END HEAD -->
  <!-- start header -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php //echo $head; ?>
  <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css?ver=' . time()); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
  <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
  <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>

  <!-- END HEADER -->

<?php $this->load->view('adsense');?>
</head>
<body class="page-container-bg-solid page-boxed noti-page">
<?php echo $header_inner_profile; ?>
    <?php echo $dash_header; ?>
    <!-- BEGIN HEADER MENU -->
    <?php echo $dash_header_menu; ?>

    <!-- END HEADER MENU -->

<!-- END HEADER -->

<div class="user-midd-section" id="paddingtop_fixed">
   <div class="container mobp0">
		<div class="custom-user-list">
			<div class="banner-add">
				<?php $this->load->view('banner_add'); ?>
			</div>
            <div class="common-form">
               <div class="job-saved-box">
                  <h3>View Notification</h3>
                  <div class="notification-box bg">
                     <div class="common-form">
                        <div class="">
                        </div>
                     </div>
                     <div class="contact-frnd-post">
                         <ul class="notification_data">
                           <!--AJAX DATA GET BY LAZZY LOADER START-->
                         </ul>
                        <div class="fw" id="loader" style="text-align:center;">
                           <img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>"/>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
			<div class="banner-add">
				<?php $this->load->view('banner_add'); ?>
			</div>
		</div>
		<div class="right-add">
			<?php $this->load->view('right_add_box'); ?>
		</div>
      
   </div>
   <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<!-- BEGIN INNER FOOTER -->
<?php echo $login_footer ?>
<?php echo $footer; ?>
<script>
  var base_url = '<?php echo base_url(); ?>';  
  var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';  
  var header_all_profile = '<?php echo $header_all_profile; ?>';
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/webpage/notification/notification.js'); ?>"></script>
<?php /*if (IS_NOT_JS_MINIFY == '0') {?>
  <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/notification/notification.js'); ?>"></script>
<?php } else {?>
  <script type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/notification/notification.js'); ?>"></script>
<?php }*/ ?>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
<script type="text/javascript">
function not_active(not_id)
{
   $.ajax({
      type: 'POST',
      url: '<?php echo base_url() . "notification/not_active" ?>',
      data: 'not_id=' + not_id,
      success: function (data) {
      }
   });
}
</script>
