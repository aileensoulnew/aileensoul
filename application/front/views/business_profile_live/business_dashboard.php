123<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?>  
        <?php if (IS_BUSINESS_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">

        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
            .mejs__overlay-button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__overlay-loading-bg-img {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__button > button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
        </style>
        
        <style type="text/css">
            .two-images, .three-image, .four-image{
                height: auto !important;
            }
        </style>
        
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="page-container-bg-solid page-boxed pushmenu-push no-login old-no-login">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: none;">
        <?php if($ismainregister == false){ ?>
            <header>
                <div class="container">
					<div class="row">
                            <div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
								<?php $this->load->view('main_logo'); ?>
                            </div>
                            <div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
                                <div class="btn-right">
                                <?php if(!$this->session->userdata('aileenuser')) {?>
									<ul class="nav navbar-nav navbar-right test-cus drop-down">
										<?php $this->load->view('profile-dropdown'); ?>
										<li class="hidden-991"><a href="<?php echo base_url('login'); ?>" class="btn2">Login</a></li>
										<li class="hidden-991"><a href="<?php echo base_url('business-profile/create-account'); ?>" class="btn3">Create Business Account</a></li>
										<li class="mob-bar-li">
											<span class="mob-right-bar">
												<?php $this->load->view('mobile_right_bar'); ?>
											</span>
										</li>
									
									</ul>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </header>
        <?php } else {
                    echo $business_header2; 
                } 
        ?>
        <section>
			<?php if($ismainregister == false){ ?>
				<div class="no-login-padding">
					<div class="ld-sub-header detail-sub-header">
						<div class="container">
							<div class="web-ld-sub">
                            <ul class="">
                                <li><a href="<?php echo base_url('business-search'); ?>">Business Profile</a></li>
                                <li><a href="<?php echo base_url('business-by-categories'); ?>">Business by Categories</a></li>
                                <li><a href="<?php echo base_url('business-by-location'); ?>">Business by Locations</a></li>
                                <li><a href="<?php echo base_url('how-to-use-business-profile-in-aileensoul'); ?>">How Business Profile Works</a></li>
                                <li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
                            </ul>
                        </div>
                        <div class="mob-ld-sub">
                            <ul class="">
                                <li class="tab-first-li">
                                    <a href="#">Businesses</a>
                                    <ul>
                                        <li><a href="<?php echo base_url('business-search'); ?>">Business Profile</a></li>
                                        <li><a href="<?php echo base_url('business-by-categories'); ?>">Business by Categories</a></li>
                                        <li><a href="<?php echo base_url('business-by-location'); ?>">Business by Locations</a></li>
                                        <li><a href="<?php echo base_url('how-to-use-business-profile-in-aileensoul'); ?>">How Business Profile Works</a></li>
                                        <li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
                                    </ul>
                                    
                                </li>
                                <li><a href="<?php echo base_url('login'); ?>">Login</a></li>
                                <li><a href="<?php echo base_url('business-profile/create-account'); ?>"><span class="hidden-479">Create Business Profile</span><span class="visible-479">Sign Up</span></a></li>
                            </ul>
                        </div>
						</div>
					</div>
				</div>
			<?php } ?>
            <?php echo $business_common_profile; ?>
            <div class="text-center tab-block">
                <div class="mob-inner-page">
                    <a href="javascript:void(0);" onclick="register_profile();">
                        Photo
                    </a>
                    <a href="javascript:void(0);" onclick="register_profile();">
                        Video
                    </a>
                    <a href="javascript:void(0);" onclick="register_profile();">
                        Audio
                    </a>
                    <a href="javascript:void(0);" onclick="register_profile();">
                        PDf
                    </a>
                </div>
            </div>
			<div class="full-box-module business_data mob-detail-custom">
                            <div class="profile-boxProfileCard  module">
                               
                                <table class="business_data_table">
                                    <tr>
                                        <td class="business_data_td1"><i class="fa fa-user"></i></td>
                                        <td class="business_data_td2"><?php echo ucfirst(strtolower($business_data[0]['contact_person'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="business_data_td1"><i class="fa fa-mobile"></i></td>
                                        <td class="business_data_td2">
                                            <?php
                                            if ($business_data[0]['contact_mobile'] != '0') {
                                                $contact_mobile = $business_data[0]['contact_mobile'];
                                            } else {
                                                $contact_mobile = '-';
                                            }
                                            ?>
                                            <a href="tel:<?php echo $contact_mobile; ?>">
                                            <span><?php echo $contact_mobile; ?></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php if($this->session->userdata('aileenuser') != "") {?>
                                    <tr>
                                        <td class="business_data_td1"><i class="fa fa-envelope-o" aria-hidden="true"></i></td>
                                        <td class="business_data_td2"><span><?php echo $business_data[0]['contact_email']; ?></span></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-map-marker"></i></td>
                                        <td class="business_data_td2"><span>
                                                <?php
                                                if ($business_data[0]['address']) {
                                                    echo $business_data[0]['address'];
                                                    echo ",";
                                                }
                                                ?> 
                                                <?php
                                                if ($business_data[0]['city']) {
                                                    echo $this->db->get_where('cities', array('city_id' => $business_data[0]['city']))->row()->city_name;
                                                    echo",";
                                                }
                                                ?> 
                                                <?php
                                                if ($business_data[0]['country']) {
                                                    echo $this->db->get_where('countries', array('country_id' => $business_data[0]['country']))->row()->country_name;
                                                }
                                                ?> 
                                            </span></td>
                                    </tr>
                                    <?php
                                    if ($business_data[0]['contact_website']) {
                                        ?>
                                        <tr>
                                            <td class="business_data_td1"><i class="fa fa-globe"></i></td>
                                            <td class="business_data_td2 website"><span><a target="_blank" href="<?php echo $business_data[0]['contact_website']; ?>"> <?php echo $business_data[0]['contact_website']; ?></a></span></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-suitcase"></i></td>
                                        <td class="business_data_td2"><span><?php echo nl2br($this->common->make_links($business_data[0]['details'])); ?></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
						<div class="tab-add">
							<?php $this->load->view('banner_add'); ?>
						</div>
            <div class="user-midd-section">
                <div class="container art_container mobp0 manage-post-custom">

                    <div class="profile-box-custom left_side_posrt">
                        <div class="full-box-module business_data">
                            <div class="profile-boxProfileCard  module">
                                <div class="head_details1">
                                    <span><a href="javascript:void(0);" onclick="register_profile();"><h5><i class="fa fa-info-circle" aria-hidden="true"></i>Information</h5></a>
                                    </span>      
                                </div>
                                <table class="business_data_table">
                                    <tr>
                                        <td class="business_data_td1"><i class="fa fa-user"></i></td>
                                        <td class="business_data_td2"><?php echo ucfirst(strtolower($business_data[0]['contact_person'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="business_data_td1"><i class="fa fa-mobile"></i></td>
                                        <td class="business_data_td2"><span><?php
                                                if ($business_data[0]['contact_mobile'] != '0') {
                                                    echo $business_data[0]['contact_mobile'];
                                                } else {
                                                    echo '-';
                                                }
                                                ?></span>
                                        </td>
                                    </tr>
                                    <?php if($this->session->userdata('aileenuser') != "") {?>
                                    <tr>
                                        <td class="business_data_td1"><i class="fa fa-envelope-o" aria-hidden="true"></i></td>
                                        <td class="business_data_td2"><span><?php echo $business_data[0]['contact_email']; ?></span></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-map-marker"></i></td>
                                        <td class="business_data_td2"><span>
                                                <?php
                                                if ($business_data[0]['address']) {
                                                    echo $business_data[0]['address'];
                                                    echo ",";
                                                }
                                                ?> 
                                                <?php
                                                if ($business_data[0]['city']) {
                                                    echo $this->db->get_where('cities', array('city_id' => $business_data[0]['city']))->row()->city_name;
                                                    echo",";
                                                }
                                                ?> 
                                                <?php
                                                if ($business_data[0]['country']) {
                                                    echo $this->db->get_where('countries', array('country_id' => $business_data[0]['country']))->row()->country_name;
                                                }
                                                ?> 
                                            </span></td>
                                    </tr>
                                    <?php
                                    if ($business_data[0]['contact_website']) {
                                        ?>
                                        <tr>
                                            <td class="business_data_td1"><i class="fa fa-globe"></i></td>
                                            <td class="business_data_td2 website"><span><a target="_blank" href="<?php echo $business_data[0]['contact_website']; ?>"> <?php echo $business_data[0]['contact_website']; ?></a></span></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-suitcase"></i></td>
                                        <td class="business_data_td2"><span><?php echo nl2br($this->common->make_links($business_data[0]['details'])); ?></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <a href="javascript:void(0);" onclick="register_profile();">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module buisness_he_module" >
                                    <div class="head_details">
                                        <h5><i class="fa fa-camera" aria-hidden="true"></i>   Photos</h5>
                                    </div>
                                    <div class="bus_photos">
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);" onclick="register_profile();">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module">
                                    <table class="business_data_table">
                                        <div class="head_details">
                                            <h5><i class="fa fa-video-camera" aria-hidden="true"></i>Video</h5>
                                        </div>
                                        <div class="bus_videos">
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);" onclick="register_profile();">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard module">
                                    <div class="head_details1">
                                        <h5><i class="fa fa-music" aria-hidden="true"></i>Audio</h5>
                                    </div>
                                    <table class="business_data_table">
                                        <div class="bus_audios"> 
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);" onclick="register_profile();">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module buisness_he_module" >
                                    <div class="head_details">
                                        <h5><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  PDF</h5>
                                    </div>      
                                    <div class="bus_pdf"></div>
                                </div>
                            </div>
                        </a>
						<?php $this->load->view('right_add_box'); ?>
                        <?php echo $left_footer; ?>
                    </div>
                    <div class=" custom-right-art mian_middle_post_box animated fadeInUp custom-right-business">
                        <?php
                        if ($this->session->flashdata('error')) {
                            echo $this->session->flashdata('error');
                        }
                        ?>
                        <div class="fw">

                            <div class="business-all-post">
                            </div>
                            <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="loader" /></div>
							<div class="banner-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                        </div>
                    </div>

                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 
						<?php $this->load->view('right_add_box'); ?>
					</div>

                </div>
            </div>
        </section>

        <div class="modal fade message-box" id="likeusermodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close1" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="post" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="post"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade message-box" id="postedit" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login  -->
        <div class="modal login fade" id="login" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content login-frm">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>     	
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div class="title">
                                        <h1 class="ttc tlh2">Welcome To Aileensoul</h1>
                                    </div>

                                    <form role="form" name="login_form" id="login_form" method="post">

                                        <div class="form-group">
                                            <input type="email" value="<?php echo $email; ?>" name="email_login" id="email_login" autofocus="" class="form-control input-sm" placeholder="Email Address*">
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
                                            <input type="password" name="password_login" id="password_login" class="form-control input-sm" placeholder="Password*">
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
                                            <button class="btn1" onclick="login()">Login</button>
                                        </p>

                                        <p class=" text-center">
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" class="login_link" id="myBtn">Forgot Password ?</a>
                                        </p>

                                        <p class="pt15 text-center">
                                            Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" class="login_link" onclick="register_profile();">Create an account</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade login" id="forgotPassword" role="dialog">
            <div class="modal-dialog login-frm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>     	
                    <div class="modal-body">
                        <div class="right-main">
                            <div class="right-main-inner">
                                <div class="">
                                    <div id="forgotbuton"></div> 
                                    <div class="title">
                                        <p class="ttc tlh2">Forgot Password</p>
                                    </div>
                                    <?php
                                    $form_attribute = array('name' => 'forgot', 'method' => 'post', 'class' => 'forgot_password', 'id' => 'forgot_password');
                                    echo form_open('profile/forgot_password', $form_attribute);
                                    ?>
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
                                        <input class="btn btn-theme btn1" type="submit" name="submit" value="Submit" style="width:105px; margin:0px auto;" /> 
                                    </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade login register-model" id="register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content inner-form1">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>     	
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="">
                                <div class="title"><h1 class="tlh1">Sign up First and Register in Business Profile</h1></div>
                                <form role="form" name="register_form" id="register_form" method="post">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input tabindex="101" autofocus="" type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input tabindex="102" type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input tabindex="103" type="text" name="email_reg" id="email_reg" class="form-control input-sm" placeholder="Email Address" autocomplete="new-email">
                                    </div>
                                    <div class="form-group">
                                        <input tabindex="104" type="password" name="password_reg" id="password_reg" class="form-control input-sm" placeholder="Password" autocomplete="new-password">
                                    </div>
                                    <div class="form-group dob">
                                        <label class="d_o_b"> Date Of Birth :</label>
                                        <span><select tabindex="105" class="day" name="selday" id="selday">
                                                <option value="" disabled selected value>Day</option>
                                                <?php
                                                for ($i = 1; $i <= 31; $i++) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select></span>
                                        <span>
                                            <select tabindex="106" class="month" name="selmonth" id="selmonth">
                                                <option value="" disabled selected value>Month</option>
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
                                            </select></span>
                                        <span>
                                            <select tabindex="107" class="year" name="selyear" id="selyear">
                                                <option value="" disabled selected value>Year</option>
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
                                    <div class="dateerror" style="color:#f00; display: block;"></div>

                                    <div class="form-group gender-custom">
                                        <span><select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                <option value="" disabled selected value>Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select></span>
                                    </div>

                                    <p class="form-text" style="margin-bottom: 10px;">
                                        By Clicking on create an account button you agree our
                                        <a tabindex="109" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                    </p>
                                    <p>
                                        <button tabindex="111" class="btn1">Create an account</button>
                                    </p>
                                    <div class="sign_in pt10">
                                        <p>
                                            Already have an account ? <a tabindex="112" onClick="login_profile();" class="login_link" href="javascript:void(0);"> Log In </a>
                                        </p>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php $this->load->view('mobile_side_slide'); ?>
        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content pop-content-cus'>
                                <h2>Never miss out any opportunities, news, and updates.</h2>Join Now! <p class='poppup-btns'><a class='btn1 login_link' href='<?php echo base_url(); ?>login'>Login</a> or <a class='btn1 login_link' href='<?php echo base_url(); ?>business-profile/create-account'>Register</a></p>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Model Popup Close -->
        <?php echo $footer; ?>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
            <script type = "text/javascript" src="<?php echo base_url('assets/js/jquery.form.3.51.js') ?>"></script> 
            <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
            <script type = "text/javascript" src="<?php echo base_url('assets/js_min/jquery.form.3.51.js') ?>"></script> 
            <script src="<?php echo base_url('assets/dragdrop/js_min/plugins/sortable.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js_min/fileinput.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js_min/locales/fr.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/js_min/locales/es.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <?php } ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var slug = '<?php echo $slugid; ?>';
            var no_business_post_html = '<?php echo $no_business_post_html ?>';
            var ismainregister = '<?php echo $ismainregister ?>';
            var isbusiness_register = '<?php echo $isbusiness_register ?>';
            var isbusiness_deactive = '<?php echo $isbusiness_deactive ?>';
        </script>
        <script>

             function open_profile() {
                register_profile();
             }
            function login_profile() { 
                // $('#register').modal('hide');
                // $('#login').modal('show');
                $('#bidmodal').modal('show');
            }
            function register_profile() {
                if(ismainregister == false || isbusiness_deactive == true){
                    // $('#login').modal('hide');
                    // $('#register').modal('show');
                    $('#bidmodal').modal('show');
                }else{
                    window.location.href = '<?php echo business_register_step1; ?>'
                }
            }
            function forgot_profile() {
                $('#forgotPassword').modal('show');
                $('#register').modal('hide');
                $('#login').modal('hide');
                $('body').addClass('modal-open-other'); 
            }


            $('.modal-close').click(function(e){ 
                $('body').removeClass('modal-open-other'); 
                //$('#login').modal('show');
            });
        </script>
        <script type="text/javascript">
            function login()
            {
                document.getElementById('error1').style.display = 'none';
            }
            $(document).ready(function () {
                $("#login_form").validate({
                    rules: {
                        email_login: {
                            required: true,
                        },
                        password_login: {
                            required: true,
                        }
                    },
                    messages:
                            {
                                email_login: {
                                    required: "Please enter email address",
                                },
                                password_login: {
                                    required: "Please enter password",
                                }
                            },
                    submitHandler: submitForm
                });
                function submitForm()
                {

                    var email_login = $("#email_login").val();
                    var password_login = $("#password_login").val();
                    var post_data = {
                        'email_login': email_login,
                        'password_login': password_login,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    }
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ?>login/business_check_login',
                        data: post_data,
                        dataType: "json",
                        beforeSend: function ()
                        {
                            $("#error").fadeOut();
                            $("#btn1").html('Login');
                        },
                        success: function (response)
                        {
                            if (response.data == "ok") {
                                $("#btn1").html('<img src="<?php echo base_url() ?>assets/images/btn-ajax-loader.gif" alt="Loader" /> &nbsp; Login');
                                if (response.is_bussiness == '1') {
                                    window.location = "<?php echo base_url() ?>company/" + slug;
                                } else {
                                    window.location = "<?php echo base_url() ?>business-search";
                                }
                            } else if (response.data == "password") {
                                $("#errorpass").html('<label for="email_login" class="error">Please enter a valid password.</label>');
                                document.getElementById("password_login").classList.add('error');
                                document.getElementById("password_login").classList.add('error');
                                $("#btn1").html('Login');
                            } else {
                                $("#errorlogin").html('<label for="email_login" class="error">Please enter a valid email.</label>');
                                document.getElementById("email_login").classList.add('error');
                                document.getElementById("email_login").classList.add('error');
                                $("#btn1").html('Login');
                            }
                        }
                    });
                    return false;
                }
            });
        </script>
        <script>
            $(document).ready(function () {
                $.validator.addMethod("lowercase", function (value, element, regexpr) {
                    return regexpr.test(value);
                }, "Email Should be in Small Character");

                $("#register_form").validate({
                    rules: {
                        first_name: {
                            required: true,
                        },
                        last_name: {
                            required: true,
                        },
                        email_reg: {
                            required: true,
                            email: true,
                            //lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                            remote: {
                                url: "<?php echo site_url() . 'registration/check_email' ?>",
                                type: "post",
                                data: {
                                    email_reg: function () {
                                        // alert("hi");
                                        return $("#email_reg").val();
                                    },
                                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                },
                            },
                        },
                        password_reg: {
                            required: true,
                        },
                        selday: {
                            required: true,
                        },
                        selmonth: {
                            required: true,
                        },
                        selyear: {
                            required: true,
                        },
                        selgen: {
                            required: true,
                        }
                    },

                    groups: {
                        selyear: "selyear selmonth selday"
                    },
                    messages:
                            {
                                first_name: {
                                    required: "Please enter first name",
                                },
                                last_name: {
                                    required: "Please enter last name",
                                },
                                email_reg: {
                                    required: "Please enter email address",
                                    remote: "Email address already exists",
                                },
                                password_reg: {
                                    required: "Please enter password",
                                },

                                selday: {
                                    required: "Please enter your birthdate",
                                },
                                selmonth: {
                                    required: "Please enter your birthdate",
                                },
                                selyear: {
                                    required: "Please enter your birthdate",
                                },
                                selgen: {
                                    required: "Please enter your gender",
                                }

                            },
                    submitHandler: submitRegisterForm
                });
                /* register submit */
                function submitRegisterForm()
                {
                    var first_name = $("#first_name").val();
                    var last_name = $("#last_name").val();
                    var email_reg = $("#email_reg").val();
                    var password_reg = $("#password_reg").val();
                    var selday = $("#selday").val();
                    var selmonth = $("#selmonth").val();
                    var selyear = $("#selyear").val();
                    var selgen = $("#selgen").val();
                    var post_data = {
                        'first_name': first_name,
                        'last_name': last_name,
                        'email_reg': email_reg,
                        'password_reg': password_reg,
                        'selday': selday,
                        'selmonth': selmonth,
                        'selyear': selyear,
                        'selgen': selgen,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    }
                    var todaydate = new Date();
                    var dd = todaydate.getDate();
                    var mm = todaydate.getMonth() + 1; //January is 0!
                    var yyyy = todaydate.getFullYear();

                    if (dd < 10) {
                        dd = '0' + dd
                    }

                    if (mm < 10) {
                        mm = '0' + mm
                    }

                    var todaydate = yyyy + '/' + mm + '/' + dd;
                    var value = selyear + '/' + selmonth + '/' + selday;


                    var d1 = Date.parse(todaydate);
                    var d2 = Date.parse(value);
                    if (d1 < d2) {
                        $(".dateerror").html("Date of birth always less than to today's date.");
                        return false;
                    } else {
                        if ((0 == selyear % 4) && (0 != selyear % 100) || (0 == selyear % 400))
                        {
                            if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {
                                if (selday == 31) {
                                    $(".dateerror").html("This month has only 30 days.");
                                    return false;
                                }
                            } else if (selmonth == 2) { //alert("hii");
                                if (selday == 31 || selday == 30) {
                                    $(".dateerror").html("This month has only 29 days.");
                                    return false;
                                }
                            }
                        } else {
                            if (selmonth == 4 || selmonth == 6 || selmonth == 9 || selmonth == 11) {
                                if (selday == 31) {
                                    $(".dateerror").html("This month has only 30 days.");
                                    return false;
                                }
                            } else if (selmonth == 2) {
                                if (selday == 31 || selday == 30 || selday == 29) {
                                    $(".dateerror").html("This month has only 28 days.");
                                    return false;
                                }
                            }
                        }
                    }
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ?>registration/reg_insert',
                        data: post_data,
                        dataType: 'json',
                        beforeSend: function ()
                        {
                            $("#register_error").fadeOut();
                            $("#btn1").html('Create an account');
                        },
                        success: function (response)
                        {
                            if (response.okmsg == "ok") {
                                $("#btn-register").html('<img src="<?php echo base_url() ?>assets/images/btn-ajax-loader.gif" alt="Loader"/> &nbsp; Sign Up ...');

                                window.location = "<?php echo base_url() ?>business-search/";
                            } else {
                                $("#register_error").fadeIn(1000, function () {
                                    $("#register_error").html('<div class="alert alert-danger main"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; ' + response + ' !</div>');
                                    $("#btn1").html('Create an account');
                                });
                            }
                        }
                    });
                    return false;
                }
            });

        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#forgot_password").validate({
                    rules: {
                        forgot_email: {
                            required: true,
                            email: true,
                        }
                    },
                    messages: {
                        forgot_email: {
                            required: "Email Address Is Required.",
                        }
                    },
                     submitHandler: submitforgotForm
                });

                function submitforgotForm()
                {

                    var email_login = $("#forgot_email").val();

                    var post_data = {
                        'forgot_email': email_login,
                    }
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'profile/forgot_live',
                        data: post_data,
                        dataType: "json",
                        beforeSend: function ()
                        {
                            $("#error").fadeOut();
                        },
                        success: function (response)
                        {
                            if (response.data == "success") {
                                //  alert("login");
                                $("#forgotbuton").html(response.message);
                                setTimeout(function () {
                                    $('#forgotPassword').modal('hide');
                                    $('#login').modal('show');
                                    $("#forgotbuton").html('');
                                    document.getElementById("forgot_email").value = "";
                                }, 5000); // milliseconds
                                //window.location = base_url + "job/home/live-post";
                            } else {
                                $("#forgotbuton").html(response.message);
                            }
                        }
                    });
                    return false;
                }            /* validation */
            });
        </script>
        <?php if (IS_BUSINESS_JS_MINIFY == '0') { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/user_dashboard.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/user_dashboard.js?ver=' . time()); ?>"></script>
            <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <?php } ?>
        <script>
            $(document).on('click', '[data-toggle*=modal]', function () {
                $('[role*=dialog]').each(function () {
                    switch ($(this).css('display')) {
                        case('block'):
                        {
                            $('#' + $(this).attr('id')).modal('hide');
                            break;
                        }
                    }
                });
            });
            $(document).ready(function () {
                // setTimeout(function () {
                //     $('#register').modal('show');
                // }, 2000);
            });
            $('select').on('change', function () {
                if ($(this).val()) {
                    $(this).css('color', 'black');
                } else {
                    $(this).css('color', '#acacac');
                }
            });
            $(document).on('click', 'a,.comment-edit-butn,.ripple like_h_w', function (e) {                
                if($(e.target).prop("class") != "")
                {
                    var classNames = $(e.target).prop("class").toString().split(' ').pop();
                    if (classNames != 'login_link' && classNames != 'click-profiles') {
                        return false;
                        open_profile();
                    }
                }                
            });
        </script>
    </body>
</html>
