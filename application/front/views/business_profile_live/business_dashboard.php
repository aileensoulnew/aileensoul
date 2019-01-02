<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
$company_name_txt = $business_data[0]['company_name'];
$business_slug_txt = base_url().'company/'.$business_common_data[0]['business_slug'];
if ($business_common_data[0]['business_user_image'] != '') {
    $business_user_image_txt = BUS_PROFILE_THUMB_UPLOAD_URL . $business_common_data[0]['business_user_image'];
}
else{
    $business_user_image_txt = base_url(NOBUSIMAGE);
}
$contact_email_txt = $business_data[0]['contact_email'];
$login_user_id = $this->session->userdata('aileenuser');
?>
<!DOCTYPE html>
<html ng-app="businessProfileApp" ng-controller="businessProfileController">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?>  
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
        <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/developer.css?ver=' . time()); ?>" />

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
        
    <?php $this->load->view('adsense');
    $cls = "";
    if($login_user_id == "")
    {
        $cls = "no-login old-no-login";
    } ?>
</head>
    <body class="page-container-bg-solid page-boxed pushmenu-push body-loader <?php echo $cls; ?>">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
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
                                            $contact_mobile_txt = "";
                                            if ($business_data[0]['contact_mobile'] != '0') {
                                                $contact_mobile_txt = $contact_mobile = $business_data[0]['contact_mobile'];
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
                                        <td class="business_data_td2"><span><?php echo $contact_email_txt = $business_data[0]['contact_email']; ?></span></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-map-marker"></i></td>
                                        <td class="business_data_td2"><span>
                                                <?php
                                                $address_txt = "";
                                                $city_txt = "";
                                                $state_txt = "";
                                                $county_txt = "";
                                                $pincode_txt = $business_data[0]['pincode'];
                                                if ($business_data[0]['address']) {
                                                    $address_txt = $business_data[0]['address'];
                                                    echo $address_txt.",";
                                                }
                                                ?> 
                                                <?php
                                                if ($business_data[0]['city']) {
                                                    $city_data = $this->db->get_where('cities', array('city_id' => $business_data[0]['city']))->row();
                                                    $city_txt = $city_data->city_name;
                                                    $city_slug = $city_data->slug;
                                                    echo $city_txt.",";
                                                }
                                                ?> 
                                                <?php
                                                if ($business_data[0]['country']) {
                                                    echo $county_txt = $this->db->get_where('countries', array('country_id' => $business_data[0]['country']))->row()->country_name;
                                                }
                                                $state_txt = $this->db->get_where('states', array('state_id' => $business_data[0]['state']))->row()->state_name;
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
                                        <td class="business_data_td2"><span><?php echo $description_txt = nl2br($this->common->make_links($business_data[0]['details'])); ?></span></td>
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
                        <div class="left-info-box">
                            <div class="dash-left-title">
                                <h3><i class="fa fa-info-circle"></i> Information</h3>
                            </div>
                                <div class="dash-info-box" ng-if="business_info_data.business_ext_benifit">
                                    <h4>

 Specialties </h4>
                                    <ul class="skill-list">
                                        <li ng-repeat="benefits in business_info_data.business_ext_benifit.split(',')">{{benefits}}</li>
                                    </ul>
                                </div>
                                <div class="dash-info-box" ng-if="bus_opening_hours">
                                    <h4>Hours of Operation</h4>
                                    <p ng-if="bus_opening_hours.opening_hour == '1'">Always open</p>
                                    <p ng-if="bus_opening_hours.opening_hour == '2'">On Specified Days</p>
                                    <p ng-if="bus_opening_hours.opening_hour == '3'">Appointment needed</p>
                                    <ul ng-if="bus_opening_hours.opening_hour == '2'">
                                        <li ng-if="bus_opening_hours.sun_from_time && bus_opening_hours.sun_from_ap && bus_opening_hours.sun_to_time && bus_opening_hours.sun_to_ap">Sunday : {{bus_opening_hours.sun_from_time}} {{bus_opening_hours.sun_from_ap}} to {{bus_opening_hours.sun_to_time}} {{bus_opening_hours.sun_to_ap}}</li>
                                        <li ng-if="bus_opening_hours.mon_from_time && bus_opening_hours.mon_from_ap && bus_opening_hours.mon_to_time && bus_opening_hours.mon_to_ap">Monday : {{bus_opening_hours.mon_from_time}} {{bus_opening_hours.mon_from_ap}} to {{bus_opening_hours.mon_to_time}} {{bus_opening_hours.mon_to_ap}}</li>
                                        <li ng-if="bus_opening_hours.tue_from_time && bus_opening_hours.tue_from_ap && bus_opening_hours.tue_to_time && bus_opening_hours.tue_to_ap">Tuesday : {{bus_opening_hours.tue_from_time}} {{bus_opening_hours.tue_from_ap}} to {{bus_opening_hours.tue_to_time}} {{bus_opening_hours.tue_to_ap}}</li>
                                        <li ng-if="bus_opening_hours.wed_from_time && bus_opening_hours.wed_from_ap && bus_opening_hours.wed_to_time && bus_opening_hours.wed_to_ap">Wednesday : {{bus_opening_hours.wed_from_time}} {{bus_opening_hours.wed_from_ap}} to {{bus_opening_hours.wed_to_time}} {{bus_opening_hours.wed_to_ap}}</li>
                                        <li ng-if="bus_opening_hours.thu_from_time && bus_opening_hours.thu_from_ap && bus_opening_hours.thu_to_time && bus_opening_hours.thu_to_ap">Thursday : {{bus_opening_hours.thu_from_time}} {{bus_opening_hours.thu_from_ap}} to {{bus_opening_hours.thu_to_time}} {{bus_opening_hours.thu_to_ap}}</li>
                                        <li ng-if="bus_opening_hours.fri_from_time && bus_opening_hours.fri_from_ap && bus_opening_hours.fri_to_time && bus_opening_hours.fri_to_ap">Friday : {{bus_opening_hours.fri_from_time}} {{bus_opening_hours.fri_from_ap}} to {{bus_opening_hours.fri_to_time}} {{bus_opening_hours.fri_to_ap}}</li>
                                        <li ng-if="bus_opening_hours.sat_from_time && bus_opening_hours.sat_from_ap && bus_opening_hours.sat_to_time && bus_opening_hours.sat_to_ap">Saturday : {{bus_opening_hours.sat_from_time}} {{bus_opening_hours.sat_from_ap}} to {{bus_opening_hours.sat_to_time}} {{bus_opening_hours.sat_to_ap}}</li>
                                    </ul>
                                </div>
                                <div class="dash-info-box" ng-if="business_info_data.business_mission != ''">
                                    <h4>Mission</h4>
                                    <p class="inner-dis" dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{business_info_data.business_mission}}" dd-text-collapse-cond="true">{{business_info_data.business_mission}}</p>
                                </div>
                                <div class="dash-info-box" ng-if="business_info_data.business_tagline != ''">
                                    <h4>Tagline</h4>
                                    <p class="inner-dis" dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{business_info_data.business_tagline}}" dd-text-collapse-cond="true">{{business_info_data.business_tagline}}</p>
                                </div>                                    
                                <div class="dash-info-box" ng-if="business_info_data.business_year_found">
                                    <h4>Year Founded</h4>
                                    <p>{{business_info_data.business_year_found}}</p>
                                </div>
                        </div>
                        <a href="javascript:void(0);" onclick="register_profile();">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module buisness_he_module" >
                                    <div class="head_details">
                                        <h5><i class="fa fa-camera" aria-hidden="true"></i>
                                            <span class="business-media">Photos</span></h5>
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
                                            <h5><i class="fa fa-video-camera" aria-hidden="true"></i>
                                                <span class="business-media">Video</span></h5>
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
                                        <h5><i class="fa fa-music" aria-hidden="true"></i>
                                            <span class="business-media">Audio</span></h5>
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
                                        <h5><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            <span class="business-media">PDF</span></h5>
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
                        <div>
                            <div class="right-info-box" ng-if="user_social_links.length > '0' || user_personal_links.length > '0'">
                                <div class="dtl-title">
                                    <img class="cus-width" src="<?php echo base_url().'assets/'; ?>n-images/detail/website.png"><span>Website</span>
                                </div>
                                <div class="dtl-dis">
                                    <div class="social-links" ng-if="user_social_links.length > '0'">
                                        <h4>Social</h4>
                                        <ul class="social-link-list">
                                            <li ng-repeat="social_links in user_social_links">
                                                <a href="{{social_links.user_links_txt}}" target="_self">
                                                    <img ng-if="social_links.user_links_type == 'Facebook'" src="<?php echo base_url(); ?>assets/n-images/detail/fb.png">
                                                    <img ng-if="social_links.user_links_type == 'Google'" src="<?php echo base_url(); ?>assets/n-images/detail/g-plus.png">
                                                    <img ng-if="social_links.user_links_type == 'LinkedIn'" src="<?php echo base_url(); ?>assets/n-images/detail/in.png">
                                                    <img ng-if="social_links.user_links_type == 'Pinterest'" src="<?php echo base_url(); ?>assets/n-images/detail/pin.png">
                                                    <img ng-if="social_links.user_links_type == 'Instagram'" src="<?php echo base_url(); ?>assets/n-images/detail/insta.png">
                                                    <img ng-if="social_links.user_links_type == 'GitHub'" src="<?php echo base_url(); ?>assets/n-images/detail/git.png">
                                                    <img ng-if="social_links.user_links_type == 'Twitter'" src="<?php echo base_url(); ?>assets/n-images/detail/twt.png">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="social-links" ng-if="user_personal_links.length > '0'">
                                        <h4 class="pt20 fw">Personal</h4>
                                        <ul class="social-link-list">
                                            <li ng-repeat="user_p_links in user_personal_links">
                                                <a href="{{user_p_links.user_links_txt}}" target="_self">
                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/pr-web.png">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="right-info-box">
                                
                                <div class="dtl-title">
                                    <img class="cus-width" src="<?php echo base_url().'assets/'; ?>n-images/detail/review.png"><span>Reviews</span>
                                </div>
                                <div class="dtl-dis">
                                    <div class="no-info" ng-if="review_data.length < '1'">
                                        <img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
                                        <?php if($login_bussiness_data->user_id == $business_data[0]['user_id']): ?>
                                        <span>Be the first to post your review.</span>
                                        <?php else: ?>
                                            <span>There are no reviews right now.</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="total-rev" ng-if="review_data.length > '0' && review_count > '0'">
                                        <span class="total-rat">{{avarage_review}}</span>
                                        <span class="rating-star">
                                            <input id="avarage_review" type="number" value="{{avarage_review}}">
                                        </span><span class="rev-count">{{review_count}} Review{{review_count > 1 ? 's' : ''}}</span>
                                    </div>
                                    <ul class="review-list">
                                        <li ng-if="review_data.length > '0'" ng-repeat="review_list in review_data">
                                            <div class="review-left" ng-if="!review_list.user_image">
                                                <div class="rev-img">
                                                    <div class="post-img-profile">
                                                        {{review_list.company_name | limitTo:1}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-left" ng-if="review_list.user_image">
                                                <img ng-src="<?php echo BUS_PROFILE_MAIN_UPLOAD_URL; ?>{{review_list.user_image}}">
                                            </div>
                                            <div class="review-right">
                                                <h4>{{review_list.company_name | wordFirstCase}}</h4>
                                                <div class="rating-star-cus">
                                                    <span class="rating-star">
                                                        <input id="rating-{{$index}}" value="{{review_list.review_star}}" type="number" class="rating user-rating">
                                                    </span>
                                                </div>
                                                <div class="review-dis" ng-if="review_list.review_desc">
                                                    {{review_list.review_desc}}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="form-group"></div>
                                </div>                          
                            </div>
                            <div class="right-info-box" ng-if="story_data">
                                <div class="dtl-title">
                                    <img class="cus-width" src="<?php echo base_url().'assets/'; ?>n-images/detail/about.png"><span>Story</span>
                                </div>
                                <div class="dtl-dis dtl-box-height">
                                    <div class="bus-story" ng-if="story_data.story_file" ng-click="open_business_story();">
                                        <img ng-src="<?php echo BUSINESS_USER_STORY_UPLOAD_URL;?>{{story_data.story_file}}">
                                    </div>
                                    <div class="bus-story" ng-if="!story_data.story_file" ng-click="open_business_story();">
                                        <div class="gradient-bg"></div>
                                    </div>
                                    <ul class="dis-list list-ul-cus">
                                        <li>
                                            <span>Description</span>
                                            <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{story_data.story_desc}}" dd-text-collapse-cond="true">{{story_data.story_desc}}</label>
                                        </li>
                                    
                                        <li>
                                            <span>What differentiate you from your competitiors</span>
                                            <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{story_data.story_diff}}" dd-text-collapse-cond="true">{{story_data.story_diff}}</label>
                                        </li>
                                
                                    </ul>
                                </div>
                                <div class="about-more" ng-if="story_data">
                                    <a href="javascript:void(0);" ng-click="open_business_story();">View More <img src="<?php echo base_url().'assets/'; ?>n-images/detail/down-arrow.png"></a>
                                </div>
                                
                            </div>
                            <div class="right-info-box add-menu" ng-if="menu_info_data.length > '0'">
                                <div class="dtl-title">
                                    <img class="cus-width" src="<?php echo base_url().'assets/'; ?>n-images/detail/menu.png"><span>Menu</span>
                                </div>
                                <div class="dtl-dis">
                                    <ul class="dis-list">
                                        <li ng-repeat="menu_info in menu_info_data | limitTo:6">
                                            <p class="screen-shot" data-target="#add-menu" data-toggle="modal">
                                                <img ng-src="<?php echo BUSINESS_USER_MENU_IMG_UPLOAD_URL; ?>{{menu_info.file_name}}">
                                            </p>
                                        </li>
                                    </ul>
                                </div>                                  
                            </div>
                            <div class="right-info-box" ng-if="jobs_data.length > '0'">
                                <div class="dtl-title">
                                    <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/job-opning.png?ver=' . time()) ?>"><span>Job Openings </span>
                                </div>
                                <div class="dtl-dis dis-accor">
                                    <div class="panel-group">
                                        
                                        <div class="panel panel-default" ng-repeat="job in jobs_data">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <a href="<?php echo base_url(); ?>{{job.post_name_txt | slugify}}-job-vacancy-in-{{job.slug_city}}-{{job.user_id}}-{{job.post_id}}" target="_self">
                                                        <div class="dis-left">
                                                            <div class="dis-left-img img-cus">
                                                                <img ng-if="!job.comp_logo" src="<?php echo base_url('assets/n-images/detail/job-def.png?ver=' . time()) ?>">
                                                                <img ng-if="job.comp_logo" ng-src="<?php echo REC_PROFILE_MAIN_UPLOAD_URL; ?>{{job.comp_logo}}">
                                                            </div>
                                                        </div>
                                                        <div class="dis-middle">
                                                            <h4>{{job.post_name_txt}}</h4>
                                                            <p>{{job.comp_name}}</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
					</div>

                </div>
            </div>
        </section>

        <div style="display:none;" class="modal fade dtl-modal timeline-cus bus-start-cus" id="bus-name-started-display" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="new-modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
                        <div class="dtl-title">
                            <span>How <?php echo ucwords($business_data[0]['company_name']); ?> Started?</span>
                        </div>                  
                        <div class="dtl-dis">                       
                            <div class="bus-story no-img-upload" style="float: left;width: 100%;">
                                <label class="upload-file">                                 
                                    <span id="upload-file1" style="display: none;">Change</span>
                                </label>
                            </div>                                              
                            <div class="form-group">
                                <h4>Description</h4>
                                <label>{{story_data.story_desc}}</label>
                            </div>
                            <div class="form-group">
                                <h4>Difference between <?php echo ucwords($business_data[0]['company_name']); ?> and competitiors</h4>
                                <label>{{story_data.story_diff}}</label>
                            </div>
                        </div>
                        <div class="dtl-btn bottom-btn">
                            <a href="#" class="save" data-dismiss="modal">
                                <span>Close</span>
                            </a>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade dtl-modal" id="add-menu" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="new-modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
                        <div class="dtl-title">
                            <span class="timeline-tital">Menu</span>
                        </div>                            
                        <div class="dtl-dis" ng-if="menu_info_data.length > '0'">
                            <div class="menu-privew">
                                <ul>
                                    <li ng-repeat="menu_info in menu_info_data">
                                        <p ng-click="openModal();currentSlide($index + 1)">
                                            <img ng-src="<?php echo BUSINESS_USER_MENU_IMG_UPLOAD_URL; ?>{{menu_info.file_name}}">
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dtl-btn bottom-btn">
                            <a href="#" class="save" data-dismiss="modal">
                                <span>Close</span>
                            </a>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="myModalPhotos" class="modal modal2" style="display: none;">
            <button type="button" class="new-modal-close" data-dismiss="modal" ng-click="closeModal()">×</button>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
                        <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                    </div>
                    <div class="mySlides" ng-repeat="menu_info in menu_info_data">
                        <div class="numbertext"></div>
                        <div class="slider_img_p">                  
                            <img ng-src="<?php echo BUSINESS_USER_MENU_IMG_UPLOAD_URL ?>{{menu_info.file_name}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">                       
                        </div>
                    </div>          
                </div>
                <div class="caption-container">
                    <p id="caption"></p>
                </div>
            </div> 
            <a class="prev" style="left:0px;" ng-click="plusSlides(-1)">&#10094;</a>
            <a class="next" ng-click="plusSlides(1)">&#10095;</a>
        </div>

        <div style="display:none;" class="modal fade dtl-modal" id="reviews" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="new-modal-close" data-dismiss="modal">×</button>
                    <div class="modal-body-cus"> 
                        <div class="dtl-title">
                            <span>Reviews</span>
                        </div>
                        <form id="business_review" name="business_review" ng-validate="business_review_validate">
                            <div class="dtl-dis">
                                <div class="form-group">
                                    <div class="rev-img">
                                        <?php if($login_bussiness_data->business_user_image != ''): ?>
                                        <img src="<?php echo BUS_PROFILE_MAIN_UPLOAD_URL.$login_bussiness_data->business_user_image; ?>">
                                        <?php else: ?>
                                            <div class="post-img-profile">
                                                <?php echo strtoupper(substr($login_bussiness_data->company_name, 0,1)); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="total-rev-top">
                                        <h4><?php echo $login_bussiness_data->company_name; ?></h4>
                                        <span class="rating-star">
                                            <input id="review_star" value="5" type="number" class="rating" data-min=0 data-max=5 data-step=0.5 data-size="sm" required name="review_star">
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea type="text" placeholder="Description" id="review_desc" name="review_desc" maxlength="700" ng-model="review_desc"></textarea>
                                    <span class="pull-right">{{700 - review_desc.length}}</span>
                                </div>
                                <div class="form-group">
                                    <div class="upload-file">
                                        <span class="fw">Upload Photo</span>
                                        <input type="file" id="review_file" name="review_file">
                                        <span id="review_file_error" class="error" style="display: none;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dtl-btn bottom-btn">
                                <a id="save_review" href="#" ng-click="save_review()" class="save">
                                    <span>Save</span>
                                </a>
                                <div id="review_loader" class="dtl-popup-loader" style="display: none;">
                                    <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
        
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var slug = '<?php echo $slugid; ?>';
            var no_business_post_html = '<?php echo $no_business_post_html ?>';
            var ismainregister = '<?php echo $ismainregister ?>';
            var isbusiness_register = '<?php echo $isbusiness_register ?>';
            var isbusiness_deactive = '<?php echo $isbusiness_deactive ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser') ?>';
        </script>
        <script>
            function open_profile() {
                register_profile();
            }
            function login_profile() {                 
                $('#bidmodal').modal('show');
            }
            function register_profile() {
                if(ismainregister == false || isbusiness_deactive == true){                   
                    $('#bidmodal').modal('show');
                }else{
                    window.location.href = '<?php echo business_register_step1; ?>'
                }
            }
        </script>

        
        <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>">
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script type="text/javascript">
            var user_slug = '<?php echo $business_data[0]['business_slug']; ?>';
            var business_user_story_upload_url = '<?php echo BUSINESS_USER_STORY_UPLOAD_URL; ?>';
            
            var from_user_id = '<?php echo $login_bussiness_data->user_id; ?>';
            var to_user_id = '<?php echo $business_data[0]['user_id']; ?>';
            
            var app = angular.module("businessProfileApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
        </script>
     
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/user_dashboard.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/dashboard_new.js?ver=' . time()); ?>"></script>
        
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
                        if(user_id != "")
                        {
                            window.location = '<?php echo business_register_step1; ?>'
                        }
                        else
                        {
                            return false;
                            open_profile();                            
                        }
                    }
                }                
            });
        </script>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "name": "Aileensoul",
            "url": "https://www.aileensoul.com"
        }
        </script>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "LocalBusiness",
            
            "name": "<?php echo $company_name_txt; ?>",
            "image": "<?php echo $business_user_image_txt; ?>",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "<?php echo $address_txt; ?>",
                "addressLocality": "<?php echo $city_txt; ?>",
                "addressRegion": "<?php echo $state_txt; ?>",
                "addressCountry": "<?php echo $county_txt; ?>",
                "postalCode": "<?php echo $pincode_txt; ?>"
            },
           
           "telephone": "<?php echo $contact_mobile_txt; ?>",
           "email": "<?php echo $contact_email_txt; ?>",
           "url": "<?php echo $business_slug_txt; ?>",
            "description": "Description: <?php echo addslashes($description_txt); ?>"
          }
        </script>
        <?php if($this->session->userdata('aileenuser') == "" && ($county_txt != "" || $business_data[0]['industriyal'] != 0)):

            $category_arr = $this->db->select('industry_slug,industry_name')->get_where('industry_type', array('industry_id' => $business_data[0]['industriyal']))->row_array();
            $category_slug = $category_arr['industry_slug'];
            $category_txt = $category_arr['industry_name'];
            
        ?>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement":
            [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item":
                    {
                        "@id": "<?php echo base_url(); ?>",
                        "name": "Aileensoul"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "item":
                    {
                        "@id": "<?php echo base_url(); ?>business-search",
                        "name": "Business"
                    }
                },
                <?php
                if($city_txt != "" && $category_txt != "" && array_search(trim($city_txt),array_column($top_city, 'city_name')) != ''): ?>
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item":
                    {
                        "@id": "<?php echo base_url('business'); ?>",
                        "name": "All Business"                
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 4,
                    "item":
                    {
                        "@id": "<?php echo base_url().$category_slug."-business-in-".$city_slug; ?>",
                        "name": "<?php echo $category_txt." Business in ".$city_txt; ?>"
                    }
                },
                <?php
                elseif($category_txt != ""): ?>
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item":
                    {
                        "@id": "<?php echo base_url('business-by-categories'); ?>",
                        "name": "Business by Category"                
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 4,
                    "item":
                    {
                        "@id": "<?php echo base_url().$category_slug."-business"; ?>",
                        "name": "<?php echo $category_txt." Business"; ?>"
                    }
                },
                <?php
                elseif($city_txt != ""): ?>
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item":
                    {
                        "@id": "<?php echo base_url('business-by-location'); ?>",
                        "name": "Business by Location"                
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 4,
                    "item":
                    {
                        "@id": "<?php echo base_url()."business-in-".$city_slug; ?>",
                        "name": "<?php echo $city_txt; ?>"
                    }
                },
                <?php
                endif; ?>
                {
                    "@type": "ListItem",
                    "position": 5,
                    "item":
                    {
                        "@id": "<?php echo current_url(); ?>",
                        "name": "<?php echo $company_name_txt; ?>"                
                    }
                }
            ]
        }
        </script>
        <?php endif; ?>
        <script src="<?php echo base_url('assets/js/star-rating.js?ver=' . time()); ?>"></script>
    </body>
</html>
