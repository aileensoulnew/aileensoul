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
        <?php if (IS_OUTSIDE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">
        <?php } else { ?>

            <link rel="stylesheet" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver=' . time()); ?>">
        <?php } ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
		 <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
		 <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">
		
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>

    <?php $this->load->view('adsense'); ?>
</head>
    <body class="report ftr-page feedback-cus">
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
						<h1 class="text-center">Your Feedback Matters</h1>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="banner-add">
					<?php $this->load->view('banner_add'); ?>
				</div>
			</div>

                <div class="container">
                    <div class="form-pd row">
                        <div id="feedbacksucc"></div>
                        <div class="inner-form">
                            <div class="login">
                                <div class="title">
                                    <h2>Send us feedback</h2>
                                </div>
                                <form name="feedback_form" id="feedback_form" method="post">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="feedback_firstname" id="feedback_firstname" class="form-control input-sm" placeholder="First Name*">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="feedback_lastname" id="feedback_lastname" class="form-control input-sm" placeholder="Last Name*">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="feedback_email" id="feedback_email" class="form-control input-sm" placeholder="Email Address*">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="feedback_subject" id="feedback_subject" class="form-control input-sm" placeholder="Subject*">
                                    </div>
                                    <div class="form-group">
                                        <textarea id="feedback_message" name="feedback_message" class="form-control" placeholder="Message*"></textarea>
                                    </div>
                                    <p class="pb15">
                                        <span class="red">*</span>All fields are mandatory
                                    </p>
                                    <p>
                                        <button title="Submit" class="btn1">Submit</button>
                                    </p>
                                </form>
                            </div>
                        </div>
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

        <!-- <div class="modal fade message-box biderror" id="bidmodal" role="dialog"  >
            <div class="modal-dialog modal-lm" >
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="modal fade message-box biderror custom-message cust-err" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm deactive">
               <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var base_url = '<?php echo base_url(); ?>';

        </script>

        <?php //if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/webpage/feedback.js?ver=' . time()); ?>); ?>"></script>

        <?php /*} else { ?>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js?ver=<?php echo time(); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/webpage/feedback.js?ver=' . time()); ?>); ?>"></script>

        <?php }*/ ?>
    </body>
</html>