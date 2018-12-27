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
            .pr-pl-box{position: fixed; bottom: 0; background:rgba(255,255,255,1); color:#5c5c5c; padding: 10px; width: 100%; text-align: center; z-index: 9999;}
            .btn-pr-pl{padding: 1px 10px; background:#1b8ab9; color:#fff; border-radius: 3px; display: inline-block;}
            .btn-pr-pl:hover{background:#1d7398; color:#fff; text-decoration: none;}
			.footer{margin-bottom:35px;}
        </style>

    <?php $this->load->view('adsense'); ?>
</head>
    <body class="custom-landscape">
		<div class="pr-pl-box">
            Aileensoul uses cookies to analyze traffic and shows ads to the site. Using this site you agree of its use. Refer <a href="https://www.aileensoul.com/privacy-policy">Privacy Policy</a> to learn more about the use of cookies. <a class="btn-pr-pl" href="javascript:void(0);">Close</a>
        </div>
        <div class="main-login">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 col-sm-3 col-lg-2 col-xs-6">
                            <?php $this->load->view('main_logo'); ?>
                        </div>
						<div class="col-lg-10 col-md-10 col-sm-9 col-xs-6 right-cus-new-hdr">
							<ul class="test-cus">
								<li><a href="<?php echo $job_right_profile_link; ?>">Job</a></li>
								<li><a href="<?php echo $recruiter_right_profile_link; ?>">Recruiter</a></li>
								<li><a href="<?php echo $business_right_profile_link; ?>">Business</a></li>
								<li><a href="<?php echo $artist_right_profile_link; ?>">Artistic</a></li>
								<li><a href="<?php echo $freelance_hire_right_profile_link; ?>">Hire Freelancer</a></li>
								<li><a href="<?php echo $freelance_apply_right_profile_link; ?>">Freelance Jobs</a></li>
								
								<li><a class="btn-n" href="#" data-target="#login" data-toggle="modal">Login</a></li>
								
							</ul>
							<span class="mob-right-bar">
								<?php $this->load->view('mobile_right_bar'); ?>
							</span>
							
						</div>
						
                        
                        
                    </div>
					
                </div>
            </header>
			
            <section class="middle-main">
                <div class="tablate-main-login">
					<form class="header-login" name="login_form" id="login_form" method="post">
						<div class="input">
							<input type="email" tabindex="1"  name="email_login" id="email_login" class="form-control input-sm" placeholder="Email Address">
						</div>
						<div class="input">
							<input type="password" tabindex="1"  name="password_login" id="password_login" class="form-control input-sm" placeholder="Password">
						</div>
						<div class="btn-right">
							<button id="login-new" title="Login" tabindex="1"  class="btn1-cus">Login <span class="ajax_load" id="login_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
							<a tabindex="1" data-target="#forgotPassword" data-toggle="modal" data-dismiss="modal" class="" href="javascript:void(0)" title="Forgot Password">Forgot Password?</a>
						</div>
					</form>
				</div>
                <div class="clearfix"></div>
				<div class="container">
                    <div class="mid-trns">
                        <div class="">
                            <div class="col-md-7 col-sm-6">
                                <div class="top-middle">
                                    <div class="text-effect">
                                        <h1>
                                        <p>We provide platform & opportunities to</p>
                                        <p>every person in the world to make their career.</p>
                                        </h1>
                                    </div>
                                </div>
                                <div class="bottom-middle">
                                    <div id="carouselFade" class="carousel slide carousel-fade" data-ride="carousel">
                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner" role="listbox">
                                            <div class="item active">  
                                                <div class="carousel-caption">
                                                    <img src="<?php echo base_url('assets/img/job1.png?ver=' . time()); ?>" alt="Job Profile">
                                                    <div class="carousel-text">
                                                        <h3>Job Profile</h3>
                                                        <p>Find best job options and connect with recruiters.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item"> 
                                                <div class="carousel-caption">
                                                    <img src="<?php echo base_url('assets/img/rec.png?ver=' . time()); ?>" alt="Recruiter">
                                                    <div class="carousel-text">
                                                        <h3>Recruiter Profile</h3>
                                                        <p>Hire quality employees here.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item"> 
                                                <div class="carousel-caption">
                                                    <img src="<?php echo base_url('assets/img/freelancer.png?ver=' . time()); ?>" alt="Freelancer">
                                                    <div class="carousel-text">
                                                        <h3>Freelance Profile</h3>
                                                        <p>Hire freelancers and also find freelance work.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item"> 
                                                <div class="carousel-caption">
                                                    <img src="<?php echo base_url('assets/img/business.png?ver=' . time()); ?>" alt="Business">
                                                    <div class="carousel-text">
                                                        <h3>Business Profile</h3>
                                                        <p>Grow your business network.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item"> 
                                                <div class="carousel-caption">
                                                    <img src="<?php echo base_url('assets/img/art.png?ver=' . time()); ?>" alt="Artistic">
                                                    <div class="carousel-text">
                                                        <h3>Artistic Profile</h3>
                                                        <p> Show your art & talent to the world.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6 custom-padd">
                                <div class="login">
                                    <h4>Join Aileensoul - It's Free</h4>
                                    <form name="register_form" id="register_form" method="post" autocomplete="off">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="1" type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <input tabindex="2" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input tabindex="3" type="email" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="new-email">
                                        </div>
                                        <div class="form-group">
                                            <input tabindex="4" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password" autocomplete="new-password">
                                        </div>
                                        <div class="form-group dob">
                                            <label class="d_o_b"> Date Of Birth :</label>
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
                                                </select></span>
                                        </div>
                                        <div class="dateerror"></div>
                                        <div class="form-group gender-custom">
                                            <span>
                                                <select tabindex="8" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                    <option value="" disabled selected>Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="form-text term_condi_check">
                                            <label id="lbl_term_condi" class="control control--checkbox" for="term_condi">
                                                <input tabindex="9" type="checkbox" name="term_condi" id="term_condi" value="1" />
                                                I have read and agree to use this website as subjected to Aileensoul 
                                                <a href="<?php echo base_url('terms-and-condition'); ?>" title="Terms and Condition" tabindex="10" target="_blank">Terms & Condition</a> and 
                                                <a tabindex="11" href="<?php echo base_url('privacy-policy'); ?>" title="Privacy policy" target="_blank">Privacy Policy</a>.
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                        <p>
                                            <button id="create-acc-new" title="Create an account" tabindex="12" class="btn1">Create an account<span class="ajax_load pl10" id="registration_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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

            </section>
			<div class="modal fade login" id="login" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content login-frm">
                        <button type="button" class="modal-close" data-dismiss="modal">&times;</button>     	
                        <div class="modal-body">
                            <div class="right-main">
                                <div class="right-main-inner">
                                    <div class="">
                                        <div class="title">
                                            <h3 class="tlh2">Welcome to Aileensoul</h3>
                                        </div>

                                        <form role="form" name="login_form_main" id="login_form_main" method="post">
                                            <div class="form-group">
                                                <input type="email" value="<?php echo $email; ?>" name="email_login_main" id="email_login_main" autofocus="" class="form-control input-sm" placeholder="Email Address*" autocomplete="off">
                                                <div id="error2" style="display:block;">
                                                    <?php
                                                    if ($this->session->flashdata('erroremail')) {
                                                        echo $this->session->flashdata('erroremail');
                                                    }
                                                    ?>
                                                </div>
                                                <div id="errorlogin"></div> 
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password_login_main" id="password_login_main" class="form-control input-sm" placeholder="Password*">
                                                <div id="error1" style="display:block;">
                                                    <?php
                                                    if ($this->session->flashdata('errorpass')) {
                                                        echo $this->session->flashdata('errorpass');
                                                    }
                                                    ?>
                                                </div>
                                                <div id="errorpass"></div> 
                                            </div>

                                            <p class="pt-20 ">
                                                <button class="btn1" onclick="" type="submit">Login</button>
                                            </p>

                                            <p class=" text-center">
                                                <a title="Forgot Password" href="javascript:void(0)" data-toggle="modal"" data-target="#forgotPassword"  data-dismiss="modal" data-toggle="modal">Forgot Password ?</a>
                                            </p>

                                            <p class="pt15 text-center">
                                                Don't have an account? <a title="Create an account" href="<?php echo base_url()."registration"; ?>">Create an account</a>
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
        </div>
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
    </body>
</html>
