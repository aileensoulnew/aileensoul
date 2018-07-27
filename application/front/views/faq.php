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
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
       
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
		
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
		<script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="report ftr-page">      
        <div class="middle-section middle-section-banner new-ld-page">
			<header>
					<div class="">
						<div class="container">
							<div class="row">
								<div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
									<?php $this->load->view('main_logo'); ?>
								</div>
								<div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
									<div class="btn-right other-hdr">
										<?php if (!$this->session->userdata('aileenuser')) { ?>
											<ul class="nav navbar-nav navbar-right test-cus drop-down">
												<?php $this->load->view('profile-dropdown'); ?>
												<li><a href="<?php echo base_url('login'); ?>" class="btn8">Login</a></li>
												<li><a href="<?php echo base_url('registration'); ?>" class="btn9">Create an account</a></li>
												<li class="mob-bar-li">
													<span class="mob-right-bar">
														<?php $this->load->view('mobile_right_bar'); ?>
													</span>
												</li>
											
											</ul>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</header>
			<div class="search-banner cus-search-bnr" >
				
				<div class="container">
					<div class="row">
						<h1 class="text-center">Frequently Asked Questions</h1>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>
            <div class="container">
				<div class="report-middle-box">						
					<ul class="faq">
						<li>
							<a href="<?php echo base_url('how-to-use-job-profile-in-aileensoul'); ?>">
								How to use Job profile in Aileensoul? 
								<span class="pull-right">
									<img src="<?php echo base_url('assets/n-images/more-link.png') ?>">
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('how-to-use-recruiter-profile-in-aileensoul'); ?>">
								How to use Recruiter profile in Aileensoul? 
								<span class="pull-right">
									<img src="<?php echo base_url('assets/n-images/more-link.png') ?>">
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('how-to-use-freelance-profile-in-aileensoul'); ?>">
								How to use Freelancer profile in Aileensoul?
								<span class="pull-right">
									<img src="<?php echo base_url('assets/n-images/more-link.png') ?>">
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('how-to-use-business-profile-in-aileensoul'); ?>">
								How to use Business profile in Aileensoul?
								<span class="pull-right">
									<img src="<?php echo base_url('assets/n-images/more-link.png') ?>">
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo base_url('how-to-use-artistic-profile-in-aileensoul'); ?>">
								How to use Artistic profile in Aileensoul?
								<span class="pull-right">
									<img src="<?php echo base_url('assets/n-images/more-link.png') ?>">
								</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>
			<?php $this->load->view('mobile_side_slide'); ?>
			<?php echo $login_footer ?>
		</div>
		<!--  poup modal  -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>        
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()); ?>"></script>
        <script>
            // mcustom scroll bar
            (function ($) {
                $(window).on("load", function () {
                    $(".custom-scroll").mCustomScrollbar({
                        autoHideScrollbar: true,
                        theme: "minimal"
                    });
                });
            })(jQuery);
        </script>
		<script>
		  AOS.init({
			easing: 'ease-in-out-sine'
		  });
		  setInterval(addItem, 100);
		  var itemsCounter = 1;
		  var container = document.getElementById('aos-demo');
		  function addItem () {
			if (itemsCounter > 42) return;
			var item = document.createElement('div');
			item.classList.add('aos-item');
			item.setAttribute('data-aos', 'fade-up');
			item.innerHTML = '<div class="aos-item__inner"><h3>' + itemsCounter + '</h3></div>';
			// container.appendChild(item);
			itemsCounter++;
		  }
    </script>
	<script>
	$(function(){
		$(".dropdown").hover(            
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            },
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            });
    });
</script>
    </body>
</html>