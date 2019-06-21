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
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<html lang="en" class="custom-main">
    <head>
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <title>Find best career opportunities in Business, Job Search, Freelancing, and Art<?php echo TITLEPOSTFIX; ?></title>
        <meta name="description" content="If you are either looking for jobs, freelance work, recruitment, business network or want to show your artistic side, look no further. Aileensoul has built a collabrative platfrom for each industry. Join now! It's Free.">
        <meta property="og:title" content="Find best career opportunities in Business, Job Search, Freelancing, and Art | Aileensoul" />
        <meta property="og:description" content="If you are either looking for jobs, freelance work, recruitment, business network or want to show your artistic side, look no further. Aileensoul has built a collabrative platfrom for each industry. Join now! It's Free."/>
        <meta property="og:image" content="<?php echo base_url('assets/images/meta-icon.png'); ?>" />
       
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <meta name="p:domain_verify" content="d0a13cf7576745459dc0ca6027df5513"/>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <?php
        $actual_link = base_url();// "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.mCustomScrollbar.css?ver=' . time()); ?>">
        <?php
        /*if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
        <?php }*/ ?>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">

        <?php
        /*if (IS_OUTSIDE_JS_MINIFY == '0') {
            ?>
            <script data-pagespeed-no-defer src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>"></script>
            <!--script data-pagespeed-no-defer src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script--> 
            <?php
        } else {
            ?>
            <script data-pagespeed-no-defer src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>"></script>
            <script data-pagespeed-no-defer src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script> 
        <?php }*/ ?>
        <script src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>"></script>
		<style>
        </style>

    <?php $this->load->view('adsense'); ?>
</head>
    <body class="custom-landscape main-reg">
		
		<div>
			<div class="main-reg-header">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-10">
							<div class="top-logo">
								<a href="<?php echo base_url(); ?>">
									<img src="<?php echo base_url('assets/n-images/logo.png') ?>">
								
									<span><svg>
									<text class="logo-size" x="0" y="25">Aileensoul</text>
									</svg></span>
								</a>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-2 blok-767">
							<span class="mob-right-bar">
								<?php $this->load->view('mobile_right_bar'); ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 border-right">
						<div class="left-reg">
							<ul>
								<li><img src="<?php echo base_url('assets/n-images/mrg-1.png') ?>"><span>Showcase your talent and get opportunities.</span></li>
								<li><img src="<?php echo base_url('assets/n-images/mrg-2.png') ?>"><span>Ask the question, post opportunities, and articles.</span></li>
								<li><img src="<?php echo base_url('assets/n-images/mrg-3.png') ?>"><span>Follow your interest and do networking.</span></li>
								<li><img src="<?php echo base_url('assets/n-images/mrg-4.png') ?>"><span>List your business.</span></li>
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="right-reg">
							<div class="right-reg-content">
								<p>A place where everyone can learn, earn and grow</p>
								
								<div class="reg-btns">
									<a href="javascript:void(0);" id="login-btn-id" class="btn-new-1">Login</a>
										
									<a href="javascript:void(0);" id="signup-btn-id" class="btn-new-3">Sign up</a>
								</div>
							</div>
							<div id="login-form-id" class="login-form">
								<h3>Welcome to Aileensoul</h3>
								<form class="new-form pt20" name="login_form" id="login_form" method="post">
									<div class="form-group">
										<input type="email" tabindex="1"  name="email_login" id="email_login" class="form-control input-sm" placeholder="Email Address">
									</div>
									<div class="form-group">
										<input type="password" tabindex="1"  name="password_login" id="password_login" class="form-control input-sm" placeholder="Password">
									</div>
									<p class="pt15 fw">
										<button id="login-new" title="Login" tabindex="1"  class="btn-new-1">Login <span class="ajax_load" id="login_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
									</p>
									<p class="pt15 fw">
										<a tabindex="1" data-target="#forgotPassword" data-toggle="modal" data-dismiss="modal" class="" href="javascript:void(0)" title="Forgot Password">Forgot Password?</a>
									</p>
									<p class="pt10 fw">
                                        Don't have an account? <a id="creat-acc" title="Create an account" href="#">Create an account</a>
                                    </p>
									
								</form>
							</div>
							<div id="sign-up" class="signup-form">
								<h3>Join Aileensoul - It's Free</h3>
								<div id="register_error" class="row"></div>
                                <form class="new-form" name="register_form" id="register_form" method="post" autocomplete="off">
                                    <div class="row">
										<div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input tabindex="1" type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input tabindex="2" type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
                                            </div>
                                        </div>
										<div class="col-md-12 col-sm-12">
											<div id="err-res-key" class="err-flname"></div>
										</div>
										<div class="col-md-12 col-sm-12">
											<div class="form-group">
												<input tabindex="3" type="email" name="email_reg" id="email_reg" class="form-control" placeholder="Email Address" autocomplete="new-email">
											</div>
										</div>
										<div class="col-md-12 col-sm-12">
											<div class="form-group">
												<input tabindex="4" type="password" name="password_reg" id="password_reg" class="form-control" placeholder="Password" autocomplete="new-password">
											</div>
										</div>
										<div class="col-md-8 col-sm-12 text-left">
											<label class="d_o_b"> Date Of Birth :</label>
											<div class="form-group dob">
												
												<span>
													<select tabindex="5" class="day" name="selday" id="selday">
														<option value="" disabled selected>Day</option>
															<?php
															for ($i = 1; $i <= 31; $i++) {
																?>
																<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
																<?php
															}
															?>
													</select>
												</span>
												<span>
													<select tabindex="6" class="month" name="selmonth" id="selmonth">
														<option value="" disabled selected>Month</option>
														<option value="1">Jan</option>
														<option value="2">Feb</option>
														<option value="3">Mar</option>
														<option value="4">Apr</option>
														<option value="5">May</option>
														<option value="6">Jun</option>
														<option value="7">Jul</option>
														<option value="8">Aug</option>
														<option value="9">Sep</option>
														<option value="10">Oct</option>
														<option value="11">Nov</option>
														<option value="12">Dec</option>
													</select>
												</span>
												<span>
													<select tabindex="7" class="year" name="selyear" id="selyear">
														<option value="" disabled selected>Year</option>
															<?php
															for ($i = date('Y'); $i >= 1900; $i--) {
																?>
																<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
																<?php
															}
															?>
													</select>
												</span>
											</div>
											<div class="dateerror"></div>
										</div>
										<div class="col-md-4 col-sm-12 text-left">
											<label class="d_o_b fw"> Gender :</label>
											<div class="form-group gender-custom">
												
												<span>
													<select tabindex="8" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
														<option value="" disabled selected>Gender</option>
														<option value="M">Male</option>
														<option value="F">Female</option>
													</select>
												</span>
											</div>
										</div>
										<div class="col-md-12 col-sm-12">
											<div class="form-text term_condi_check text-left fw">
												<label id="lbl_term_condi" class="control control--checkbox" for="term_condi">
													<input tabindex="9" type="checkbox" name="term_condi" id="term_condi" value="1" />
														I have read and agree to use this website as subjected to Aileensoul 
													<a href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition" tabindex="10" target="_blank">Terms & Condition</a> and 
													<a tabindex="11" href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy" target="_blank">Privacy Policy</a>.
													<div class="control__indicator"></div>
												</label>
											</div>
										</div>
										<div class="col-md-12 col-sm-12 pt20 fw">
											<p class="create-ac-bottom fw">
												<button id="create-acc-new" title="Create an account" tabindex="12" class="btn-new-1">Create an account<span class="ajax_load pl10" id="registration_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
											</p>
										</div> 
										<div class="col-md-12 col-sm-12">
											<p class="pt15 fw">
												Already have an account?
												<a id="login-acc" title="Create an account" href="javascript:void(0);">Login</a>
											</p>
										</div>
									</div>
											
                                    
                                </form>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
        
        <div class="pr-pl-box">
            Aileensoul uses cookies to analyze traffic and shows ads to the site. Using this site you agree of its use. Refer <a href="https://www.aileensoul.com/privacy-policy">Privacy Policy</a> to learn more about the use of cookies. <a class="btn-pr-pl" href="javascript:void(0);">Close</a>
        </div>
			
         
                
                
				
        
        <!-- model for forgot password start -->
        <div class="modal fade login" id="forgotPassword" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div id="forgotbuton"></div> 
                                    <div class="title">
                                        <p class="tlh2">Forgot Password</p>
                                    </div>
                                   
                                    <?php
                                    // $form_attribute = array('name' => 'forgot', 'method' => 'post', 'class' => 'forgot_password', 'id' => 'forgot_password');
                                    // echo form_open('#', $form_attribute);
                                    ?>
                                    <form role="form" class="forgot_password" name="forgot" id="forgot_password" method="post">
                                    <div class="form-group">
                                        <input type="email" value="" name="forgot_email" id="forgot_email" class="form-control input-sm" placeholder="Email Address*">
                                        <div id="error2" style="display:block;">
                                            <?php
                                            if ($this->session->flashdata('erroremail')) {
                                                echo $this->session->flashdata('erroremail');
                                            }
                                            ?>
                                        </div>
                                        <div id="errorlogin"></div> 
                                    </div>

                                    <p class="pt-20 text-center">
                                        <input class="btn btn-theme btn1" type="submit" name="submit" value="Submit" id="forgot_submit" style="width:105px; margin:0px auto;" /> 
                                    </p>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('mobile_side_slide'); ?>
        <?php echo $login_footer ?>
      
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script src='<?php echo base_url(); ?>assets/chatjs/strophe.js'></script>
        <script src='<?php echo base_url(); ?>assets/chatjs/strophe.register.js'></script>
        <script>
                var user_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
                var base_url = '<?php echo base_url(); ?>';
                /*var data = <?php //echo json_encode($demo); ?>;//Pratik
                var data1 = <?php //echo json_encode($city_data); ?>;//Pratik*/
                var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
                var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
                var openfirelink = '<?php echo OPENFIRELINK; ?>';
                var openfireserver = '<?php echo OPENFIRESERVER; ?>';
                var reserve_keyword = '<?php echo strtolower(RESERVE_KEYWORD); ?>';
				
				 $(".btn-pr-pl").click(function () {
					$(".pr-pl-box").remove();
				});
        </script>
        <script src="<?php echo base_url('assets/js/webpage/main.js?ver=' . time()); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.js?ver=' . time()); ?>"></script>
        <?php
        /*if (IS_OUTSIDE_JS_MINIFY == '0') {
            ?>
            <!--<script src="<?php echo base_url('assets/js/webpage/main.js?ver=' . time()); ?>"></script>-->
            <?php
        } else {
            ?>
            <!--<script src="<?php echo base_url('assets/js_min/webpage/main.js?ver=' . time()); ?>"></script>-->
        <?php }*/ ?>
		
		<script>
		
			
		// mcustom scroll bar
			(function($){
				$(window).on("load",function(){
					
					/*$(".custom-scroll").mCustomScrollbar({
						autoHideScrollbar:true,
						theme:"minimal"
					});*/
					
				});
			})(jQuery);
    </script>
		<script>
			
			$(document).ready(function(){
			  $("#login-btn-id").click(function(){
				$("#login-form-id").addClass("form-disply");
				$(".right-reg-content").addClass("form-none");
				$(".right-reg").addClass("form-height1");
				
			  });
			  $("#creat-acc").click(function(){
				$("#sign-up").addClass("form-disply");
				$(".right-reg").addClass("form-height");
				$(".right-reg").removeClass("form-height1");
				
			  });
			  $("#login-acc").click(function(){
				$("#login-form-id").addClass("form-disply");
				$("#sign-up").removeClass("form-disply");
				$(".right-reg").removeClass("form-height");
				$(".right-reg").addClass("form-height1");
			  });
			  
			  $("#signup-btn-id").click(function(){
				$("#sign-up").addClass("form-disply");
				$(".right-reg-content").addClass("form-none");
				$(".right-reg").addClass("form-height");
				$(".right-reg").removeClass("form-height1");
			  });
		
			  
			});
		</script>
    </body>
</html>
