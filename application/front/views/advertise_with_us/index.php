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
<html lang="en" class="add-wi-us">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />        
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/animte.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">
        
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="report ftr-page add-with-us">
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
												<?php //$this->load->view('profile-dropdown'); ?>
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
						<h1 class="text-center">Promote Your Business With Aileensoul</h1>
                        <div>
                            <span class="con-detail">mail : <a href="mailto:info@aileensoul.com"><span class="pr15">info@aileensoul.com</span></a><br class="block-479"> call : <a href="tel:9879907399">+91 9879907399</a></span>						
                        </div>
						
					</div>
				</div>
			</div>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>

            <div class="container">
                <div class="add-content">
                    <div class="fw p20">
                        <div class="add-title">
                            <h2>How to Advertise with us?</h2>
                        </div>
                        <div class="row">
                 
                            <div class="col-md-8 col-md-push-2">
                                <img src="<?php echo base_url('assets/n-images/HowtoAdvertiseWithUs.jpg') ?>" alt="Advertise With Us">
                            </div>
                        </div>
                    </div>
                    <div class="fw p20">
                        <div class="add-title">
                            <h2>How your Advertise will be displayed?</h2>
                        </div>
                        <div class="">
                           <img src="<?php echo base_url('assets/n-images/Advertisedisplay.jpg') ?>" alt="Advertise With Us">
                        </div>
                    </div>

					<div class="banner-add">
						<?php $this->load->view('banner_add'); ?>
					</div>
			
                    <div class="fw p20">
                        <div class="add-title">
                            <h2>Our Audience.</h2>
                        </div>
                        <div class="row">                            
                            <div class="col-lg-4 col-md-6 col-sm-6">
								<a href="<?php echo $business_right_profile_link; ?>">
									<div class="audience-box">
										<img src="<?php echo base_url('assets/n-images/Business.jpg') ?>" alt="Advertise With Us">
										<h3>Business Profile</h3>
										<p>The business profile in Aileensoul consists businesses from various fields such as IT sector, Medical, Clothing or any domain you name. Advertising in this profile will yield a great exposure in several industries which will help you in enlarging your business.</p>
									</div>
								</a>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mobp0">
                <div class="add-form">
                    <div class="add-form-title">
                        <h2>Reach Us</h2>
                        <p>Drop your advertising inquiries</p>
                    </div>
                    <form name="advertise" id="advertise" method="POST">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="firstname" name="firstname" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="lastname" name="lastname"  placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" id="email" name="email" placeholder="Email Address">
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea id="message" name="message" placeholder="Your Requirement"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <input type="submit" class="btn1" id="submit" name="submit" value="Submit">
                                </div>

                            </div>
                        </div>
                    </form>
					<div class="clearfix"></div>
                </div>
				<p class="text-center more-support">For more support <a href="mailto:inquiry@aileensoul.com">inquiry@aileensoul.com</a>
				<p class="text-center more-support">Call : <a href="tel:9879907399">+91 9879907399</a><p>
			</div>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>
        </div>
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog"  >
            <div class="modal-dialog modal-lm" >
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
		<?php $this->load->view('mobile_side_slide'); ?>
        <?php echo $login_footer ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';

        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/advertise.js?ver=' . time()); ?>); ?>"></script>
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