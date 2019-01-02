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
                        <!-- <div class="full-box-module business_data">
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
                        </div> -->
                        <div class="left-info-box bus-info">
                            <div class="dash-left-title">
                                <h3><i class="fa fa-info-circle"></i> Information</h3>
                            </div>
                            <div class="dash-info-box">
                                <h4>
                                    <svg viewBox="0 0 60 60" width="17px" height="17px" stroke-width="1" stroke="#5c5c5c">
                                        <path d="M48.014,42.889l-9.553-4.776C37.56,37.662,37,36.756,37,35.748v-3.381c0.229-0.28,0.47-0.599,0.719-0.951  c1.239-1.75,2.232-3.698,2.954-5.799C42.084,24.97,43,23.575,43,22v-4c0-0.963-0.36-1.896-1-2.625v-5.319  c0.056-0.55,0.276-3.824-2.092-6.525C37.854,1.188,34.521,0,30,0s-7.854,1.188-9.908,3.53C17.724,6.231,17.944,9.506,18,10.056  v5.319c-0.64,0.729-1,1.662-1,2.625v4c0,1.217,0.553,2.352,1.497,3.109c0.916,3.627,2.833,6.36,3.503,7.237v3.309  c0,0.968-0.528,1.856-1.377,2.32l-8.921,4.866C8.801,44.424,7,47.458,7,50.762V54c0,4.746,15.045,6,23,6s23-1.254,23-6v-3.043  C53,47.519,51.089,44.427,48.014,42.889z M51,54c0,1.357-7.412,4-21,4S9,55.357,9,54v-3.238c0-2.571,1.402-4.934,3.659-6.164  l8.921-4.866C23.073,38.917,24,37.354,24,35.655v-4.019l-0.233-0.278c-0.024-0.029-2.475-2.994-3.41-7.065l-0.091-0.396l-0.341-0.22  C19.346,23.303,19,22.676,19,22v-4c0-0.561,0.238-1.084,0.67-1.475L20,16.228V10l-0.009-0.131c-0.003-0.027-0.343-2.799,1.605-5.021  C23.253,2.958,26.081,2,30,2c3.905,0,6.727,0.951,8.386,2.828c1.947,2.201,1.625,5.017,1.623,5.041L40,16.228l0.33,0.298  C40.762,16.916,41,17.439,41,18v4c0,0.873-0.572,1.637-1.422,1.899l-0.498,0.153l-0.16,0.495c-0.669,2.081-1.622,4.003-2.834,5.713  c-0.297,0.421-0.586,0.794-0.837,1.079L35,31.623v4.125c0,1.77,0.983,3.361,2.566,4.153l9.553,4.776  C49.513,45.874,51,48.28,51,50.957V54z" fill="#5c5c5c"/>
                                    </svg>
                                Contact Person</h4>
                                <p><?php echo ucfirst(strtolower($business_data[0]['contact_person'])); ?></p>
                            </div>
                            <?php if ($business_data[0]['contact_mobile'] != '0') { ?>
                            <div class="dash-info-box">
                                <h4>
                                    <svg viewBox="0 0 376.076 376.076" width="17px" height="17px" stroke-width="1" stroke="#5c5c5c">
                                        <g>
                                            <g>
                                                <path d="M266.611,0.076h-158.32c-13.946-0.758-27.602,4.179-37.84,13.68c-9.859,10.682-14.918,24.933-14,39.44v269.76    c0,39.12,27.44,53.12,53.12,53.12h157.04c39.12,0,53.12-27.44,53.12-53.12V53.116C319.731,13.996,292.291,0.076,266.611,0.076z     M307.651,322.956c0.08,12.32-4,41.12-41.04,41.12h-157.04c-12.32,0-41.12-4-41.12-41.12v-32h239.2V322.956z M307.651,279.116    h-239.2V69.836h239.2V279.116z M307.731,57.916H68.451v-4.72c-0.827-11.287,2.954-22.428,10.48-30.88    c8.172-7.329,18.971-11.025,29.92-10.24h157.76c12.32,0,41.12,4,41.12,41.12V57.916z" fill="#5c5c5c"/>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M207.011,29.356h-37.6c-3.314,0-6,2.686-6,6c0,3.314,2.686,6,6,6h37.6c3.314,0,6-2.686,6-6    C213.011,32.042,210.325,29.356,207.011,29.356z" fill="#5c5c5c"/>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M188.051,302.316c-14.536,0.044-26.284,11.864-26.24,26.4s11.864,26.284,26.4,26.24    c14.474-0.044,26.196-11.766,26.24-26.24C214.451,314.136,202.631,302.316,188.051,302.316z M188.051,342.956    C188.051,342.956,188.051,342.956,188.051,342.956l0,0.08c-7.909-0.044-14.284-6.491-14.24-14.4    c0.044-7.909,6.491-14.284,14.4-14.24c7.877,0.044,14.24,6.442,14.24,14.32C202.407,336.625,195.96,343,188.051,342.956z" fill="#5c5c5c"/>
                                            </g>
                                        </g>
                                    </svg>
                                Contact No</h4>
                                <p>
                                    <span><?php echo $business_data[0]['contact_mobile']; ?> </span>
                                </p>
                            </div>
                            <?php }?>
                            <div class="dash-info-box">
                                <h4>
                                    <?xml version="1.0" encoding="iso-8859-1"?>
                                    <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                                    <svg viewBox="0 0 54.757 54.757" width="17px" height="16x" stroke-width="1" stroke="#5c5c5c">
                                        <g>
                                            <path d="M27.557,12c-3.859,0-7,3.141-7,7s3.141,7,7,7s7-3.141,7-7S31.416,12,27.557,12z M27.557,24c-2.757,0-5-2.243-5-5   s2.243-5,5-5s5,2.243,5,5S30.314,24,27.557,24z" fill="#5c5c5c"/>
                                            <path d="M40.94,5.617C37.318,1.995,32.502,0,27.38,0c-5.123,0-9.938,1.995-13.56,5.617c-6.703,6.702-7.536,19.312-1.804,26.952   L27.38,54.757L42.721,32.6C48.476,24.929,47.643,12.319,40.94,5.617z M41.099,31.431L27.38,51.243L13.639,31.4   C8.44,24.468,9.185,13.08,15.235,7.031C18.479,3.787,22.792,2,27.38,2s8.901,1.787,12.146,5.031   C45.576,13.08,46.321,24.468,41.099,31.431z" fill="#5c5c5c"/>
                                        </g>
                                    </svg>
                                Address</h4>
                                <p>
                                    <span class="box-dis">
                                    <?php
                                    if ($business_data[0]['address']) {
                                        echo $business_data[0]['address'];
                                        echo ",";
                                    }
                                    if ($business_data[0]['city']) {
                                        echo $this->db->get_where('cities', array('city_id' => $business_data[0]['city']))->row()->city_name;
                                        echo",";
                                    }                                        
                                    if ($business_data[0]['country']) {
                                        echo $this->db->get_where('countries', array('country_id' => $business_data[0]['country']))->row()->country_name;
                                    }
                                    ?>
                                    </span>
                                </p>
                            </div>
                            <?php
                            if ($business_data[0]['contact_website']) {
                                ?>
                            <div class="dash-info-box">
                                <h4>
                                    <svg viewBox="0 0 482.8 482.8" width="17px" height="16px" stroke-width="1" stroke="#5c5c5c">
                                        <g>
                                            <g>
                                                <path d="M255.2,209.3c-5.3,5.3-5.3,13.8,0,19.1c21.9,21.9,21.9,57.5,0,79.4l-115,115c-21.9,21.9-57.5,21.9-79.4,0l-17.3-17.3    c-21.9-21.9-21.9-57.5,0-79.4l115-115c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-115,115C8.7,322.7,0,343.6,0,365.8    c0,22.2,8.6,43.1,24.4,58.8l17.3,17.3c16.2,16.2,37.5,24.3,58.8,24.3s42.6-8.1,58.8-24.3l115-115c32.4-32.4,32.4-85.2,0-117.6    C269.1,204,260.5,204,255.2,209.3z" fill="#5c5c5c"/>
                                                <path d="M458.5,58.2l-17.3-17.3c-32.4-32.4-85.2-32.4-117.6,0l-115,115c-32.4,32.4-32.4,85.2,0,117.6c5.3,5.3,13.8,5.3,19.1,0    s5.3-13.8,0-19.1c-21.9-21.9-21.9-57.5,0-79.4l115-115c21.9-21.9,57.5-21.9,79.4,0l17.3,17.3c21.9,21.9,21.9,57.5,0,79.4l-115,115    c-5.3,5.3-5.3,13.8,0,19.1c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4l115-115c15.7-15.7,24.4-36.6,24.4-58.8    C482.8,94.8,474.2,73.9,458.5,58.2z" fill="#5c5c5c"/>
                                            </g>
                                        </g>
                                    </svg>
                                Website</h4>
                                <p>
                                    <a target="_blank" href="<?php echo $business_data[0]['contact_website']; ?>"> <span class="box-dis"><?php echo $business_data[0]['contact_website']; ?></span></a>
                                </p>
                            </div>
                            <?php } ?>

                            <?php if($business_data[0]['details']){?>
                            <div class="dash-info-box">
                                <h4>
                                    <svg viewBox="0 0 490 490" width="17px" height="16px" stroke-width="1" stroke="#5c5c5c">
                                        <g>
                                            <g>
                                                <path d="M393.872,454.517c-2.304,0-4.583-0.804-6.412-2.354l-99.315-84.194H68.115C30.556,367.968,0,337.242,0,299.474V103.977    c0-37.768,30.556-68.494,68.115-68.494h353.77c37.559,0,68.115,30.727,68.115,68.494v195.497    c0,37.768-30.556,68.494-68.115,68.494h-18.071v76.549c0,3.891-2.243,7.428-5.752,9.067    C396.723,454.21,395.293,454.517,393.872,454.517z M68.115,55.483c-26.592,0-48.226,21.754-48.226,48.494v195.497    c0,26.739,21.634,48.494,48.226,48.494h223.662c2.346,0,4.616,0.834,6.411,2.354l85.737,72.685v-65.039c0-5.523,4.453-10,9.945-10    h28.015c26.592,0,48.226-21.755,48.226-48.494V103.977c0-26.74-21.634-48.494-48.226-48.494H68.115z" fill="#5c5c5c"/>
                                            </g>
                                            <g>
                                                <g>
                                                    <path d="M405.168,147.469H84.832c-5.492,0-9.944-4.478-9.944-10c0-5.523,4.452-10,9.944-10h320.335c5.492,0,9.944,4.477,9.944,10     C415.111,142.991,410.66,147.469,405.168,147.469z" fill="#5c5c5c"/>
                                                </g>
                                                <g>
                                                    <path d="M405.168,211.503H84.832c-5.492,0-9.944-4.478-9.944-10c0-5.523,4.452-10,9.944-10h320.335c5.492,0,9.944,4.477,9.944,10     C415.111,207.025,410.66,211.503,405.168,211.503z" fill="#5c5c5c"/>
                                                </g>
                                                <g>
                                                    <path d="M405.168,275.538H84.832c-5.492,0-9.944-4.478-9.944-10c0-5.523,4.452-10,9.944-10h320.335c5.492,0,9.944,4.476,9.944,10     C415.111,271.06,410.66,275.538,405.168,275.538z" fill="#5c5c5c"/>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                Discription</h4>
                                <?php
                                $bus_detail = nl2br($this->common->make_links($business_data[0]['details']));
                                $bus_detail = preg_replace('[^(<br( \/)?>)*|(<br( \/)?>)*$]', '', $bus_detail);
                                ?>                                    
                                <p class="inner-dis" dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="<?php echo $bus_detail; ?>" dd-text-collapse-cond="true"><?php echo $bus_detail; ?>
                                </p>
                            </div>
                            <?php }?>
                            <div class="dash-info-box" ng-if="bus_opening_hours">
                                <h4>
                                    <svg width="18px" height="17px" viewBox="0 0 612 612" >
                                        <g>
                                            <g>
                                                <path d="M587.572,186.881c-32.266-75.225-87.096-129.934-162.949-162.285C386.711,8.427,346.992,0.168,305.497,0.168    c-41.488,0-80.914,8.181-118.784,24.428C111.488,56.861,56.415,111.535,24.092,186.881C7.895,224.629,0,264.176,0,305.664    c0,41.496,7.895,81.371,24.092,119.127c32.323,75.346,87.403,130.348,162.621,162.621c37.877,16.247,77.295,24.42,118.784,24.42    c41.489,0,81.214-8.259,119.12-24.42c75.853-32.352,130.683-87.403,162.956-162.621C603.819,386.914,612,347.16,612,305.664    C612,264.176,603.826,224.757,587.572,186.881z M538.724,440.853c-24.021,41.195-56.929,73.876-98.375,98.039    c-41.195,24.021-86.332,36.135-134.845,36.135c-36.47,0-71.27-7.024-104.4-21.415c-33.129-14.384-61.733-33.294-85.661-57.215    c-23.928-23.928-42.973-52.811-57.214-85.997c-14.199-33.065-21.08-68.258-21.08-104.735c0-48.52,11.921-93.428,35.807-134.509    c23.971-41.231,56.886-73.947,98.039-98.04c41.146-24.092,85.99-36.142,134.502-36.142c48.52,0,93.649,12.121,134.845,36.142    c41.446,24.164,74.283,56.879,98.375,98.039c24.092,41.153,36.135,85.99,36.135,134.509    C574.852,354.185,562.888,399.399,538.724,440.853z" fill="#5c5c5c"/>
                                                <path d="M324.906,302.988V129.659c0-10.372-9.037-18.738-19.41-18.738c-9.701,0-18.403,8.366-18.403,18.738v176.005    c0,0.336,0.671,1.678,0.671,2.678c-0.671,6.024,1.007,11.043,5.019,15.062l100.053,100.046c6.695,6.695,19.073,6.695,25.763,0    c7.694-7.695,7.188-18.86,0-26.099L324.906,302.988z" fill="#5c5c5c"/>
                                            </g>
                                        </g>
                                    </svg>
                                Hours of Operation</h4>
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
                                <h4>
                                    <svg  viewBox="0 0 414.295 414.295" width="18px" height="17px" stroke-width="1" stroke="#5c5c5c">
                                        <g>
                                            <g>
                                                <path d="M342.804,129.011l69.12-69.12c3.139-3.109,3.164-8.174,0.055-11.314c-1.437-1.451-3.374-2.298-5.415-2.366l0.24,0.48    l-37.6-1.28l-1.28-37.6c-0.149-4.416-3.849-7.875-8.265-7.726c-2.041,0.069-3.979,0.915-5.415,2.366l-69.04,68.72    c-1.558,1.568-2.398,3.711-2.32,5.92v8C200.799,28.544,88.417,49.247,31.87,131.331S-3.975,325.798,78.11,382.345    c82.084,56.547,194.467,35.844,251.014-46.24c42.471-61.651,42.471-143.122,0-204.774h8    C339.25,131.343,341.294,130.508,342.804,129.011z M345.204,233.811c0.12,90.928-73.495,164.737-164.423,164.857    c-90.928,0.12-164.737-73.495-164.857-164.423c-0.12-90.928,73.495-164.737,164.423-164.857    c37.649-0.05,74.177,12.806,103.497,36.423l0.4,13.36l-32,32c-45.521-39.897-114.766-35.337-154.663,10.184    c-39.897,45.521-35.337,114.766,10.184,154.663c45.521,39.897,114.766,35.337,154.663-10.184    c35.846-40.9,36.279-101.899,1.016-143.303l32-32l13.2,0.48C332.172,160.12,345.068,196.383,345.204,233.811z M175.444,239.171    c3.12,3.102,8.16,3.102,11.28,0l16-16c1.559,3.218,2.379,6.744,2.4,10.32c0,13.255-10.745,24-24,24s-24-10.745-24-24    s10.745-24,24-24c3.576,0.021,7.102,0.841,10.32,2.4l-16,16C172.342,231.011,172.342,236.051,175.444,239.171z M203.124,200.131    c-18.422-12.192-43.24-7.142-55.432,11.28c-12.192,18.422-7.142,43.24,11.28,55.432c18.422,12.192,43.24,7.142,55.432-11.28    c8.858-13.385,8.858-30.768,0-44.152l37.92-37.92c33.243,39.472,28.192,98.419-11.28,131.662    c-39.472,33.243-98.419,28.192-131.662-11.28c-33.243-39.472-28.192-98.419,11.28-131.662c34.782-29.292,85.6-29.292,120.382,0    L203.124,200.131z M300.404,114.211l-1.12-34.08l53.6-53.6l0.88,26.64c0,4.418,3.582,8,8,8l26.64,0.88l-53.92,53.28    L300.404,114.211z" fill="#5c5c5c"/>
                                            </g>
                                        </g>
                                    </svg>
                                Mission</h4>
                                <p class="inner-dis" dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{business_info_data.business_mission}}" dd-text-collapse-cond="true">
                                    {{business_info_data.business_mission}}
                                </p>
                            </div>
                            <div class="dash-info-box" ng-if="business_info_data.business_tagline != ''">
                                <h4>
                                    <svg width="18px" height="17px" viewBox="0 0 400 400"  ><g id="svgg">
                                        <path id="path0" d="M171.200 0.400 C 171.200 0.647,169.133 0.800,165.800 0.800 C 160.667 0.800,160.400 0.840,160.400 1.600 C 160.400 2.347,160.133 2.400,156.400 2.400 C 152.667 2.400,152.400 2.453,152.400 3.200 C 152.400 3.933,152.133 4.000,149.200 4.000 C 146.267 4.000,146.000 4.067,146.000 4.800 C 146.000 5.529,145.733 5.600,143.000 5.600 C 140.267 5.600,140.000 5.671,140.000 6.400 C 140.000 7.133,139.733 7.200,136.800 7.200 C 133.867 7.200,133.600 7.267,133.600 8.000 C 133.600 8.703,133.333 8.800,131.400 8.800 C 129.467 8.800,129.200 8.897,129.200 9.600 C 129.200 10.311,128.933 10.400,126.800 10.400 C 124.667 10.400,124.400 10.489,124.400 11.200 C 124.400 11.911,124.133 12.000,122.000 12.000 C 120.133 12.000,119.600 12.133,119.600 12.600 C 119.600 13.022,119.174 13.200,118.163 13.200 C 117.062 13.200,116.676 13.387,116.516 14.000 C 116.339 14.675,115.970 14.800,114.153 14.800 C 112.267 14.800,112.000 14.899,112.000 15.600 C 112.000 16.267,111.733 16.400,110.400 16.400 C 109.067 16.400,108.800 16.533,108.800 17.200 C 108.800 17.867,108.533 18.000,107.200 18.000 C 105.867 18.000,105.600 18.133,105.600 18.800 C 105.600 19.467,105.333 19.600,104.000 19.600 C 102.667 19.600,102.400 19.733,102.400 20.400 C 102.400 21.067,102.133 21.200,100.800 21.200 C 99.467 21.200,99.200 21.333,99.200 22.000 C 99.200 22.667,98.933 22.800,97.600 22.800 C 96.267 22.800,96.000 22.933,96.000 23.600 C 96.000 24.248,95.733 24.400,94.600 24.400 C 93.467 24.400,93.200 24.552,93.200 25.200 C 93.200 25.867,92.933 26.000,91.600 26.000 C 90.267 26.000,90.000 26.133,90.000 26.800 C 90.000 27.467,89.733 27.600,88.400 27.600 C 87.067 27.600,86.800 27.733,86.800 28.400 C 86.800 28.933,86.533 29.200,86.000 29.200 C 85.556 29.200,85.200 29.467,85.200 29.800 C 85.200 30.222,84.774 30.400,83.763 30.400 C 82.662 30.400,82.276 30.587,82.116 31.200 C 82.001 31.640,81.641 32.000,81.316 32.000 C 80.991 32.000,80.631 32.360,80.516 32.800 C 80.359 33.401,79.970 33.600,78.953 33.600 C 77.867 33.600,77.600 33.758,77.600 34.400 C 77.600 34.933,77.333 35.200,76.800 35.200 C 76.267 35.200,76.000 35.467,76.000 36.000 C 76.000 36.667,75.733 36.800,74.400 36.800 C 73.067 36.800,72.800 36.933,72.800 37.600 C 72.800 38.133,72.533 38.400,72.000 38.400 C 71.467 38.400,71.200 38.667,71.200 39.200 C 71.200 39.733,70.933 40.000,70.400 40.000 C 69.867 40.000,69.600 40.267,69.600 40.800 C 69.600 41.467,69.333 41.600,68.000 41.600 C 66.667 41.600,66.400 41.733,66.400 42.400 C 66.400 42.933,66.133 43.200,65.600 43.200 C 65.067 43.200,64.800 43.467,64.800 44.000 C 64.800 44.533,64.533 44.800,64.000 44.800 C 63.556 44.800,63.200 45.067,63.200 45.400 C 63.200 45.730,62.930 46.000,62.600 46.000 C 62.267 46.000,62.000 46.356,62.000 46.800 C 62.000 47.467,61.733 47.600,60.400 47.600 C 59.067 47.600,58.800 47.733,58.800 48.400 C 58.800 48.933,58.533 49.200,58.000 49.200 C 57.467 49.200,57.200 49.467,57.200 50.000 C 57.200 50.533,56.933 50.800,56.400 50.800 C 55.867 50.800,55.600 51.067,55.600 51.600 C 55.600 52.133,55.333 52.400,54.800 52.400 C 54.267 52.400,54.000 52.667,54.000 53.200 C 54.000 53.733,53.733 54.000,53.200 54.000 C 52.667 54.000,52.400 54.267,52.400 54.800 C 52.400 55.333,52.133 55.600,51.600 55.600 C 51.067 55.600,50.800 55.867,50.800 56.400 C 50.800 56.933,50.533 57.200,50.000 57.200 C 49.467 57.200,49.200 57.467,49.200 58.000 C 49.200 58.533,48.933 58.800,48.400 58.800 C 47.867 58.800,47.600 59.067,47.600 59.600 C 47.600 60.133,47.333 60.400,46.800 60.400 C 46.267 60.400,46.000 60.667,46.000 61.200 C 46.000 61.644,45.733 62.000,45.400 62.000 C 45.070 62.000,44.800 62.270,44.800 62.600 C 44.800 62.933,44.444 63.200,44.000 63.200 C 43.467 63.200,43.200 63.467,43.200 64.000 C 43.200 64.533,42.933 64.800,42.400 64.800 C 41.867 64.800,41.600 65.067,41.600 65.600 C 41.600 66.133,41.333 66.400,40.800 66.400 C 40.133 66.400,40.000 66.667,40.000 68.000 C 40.000 69.333,39.867 69.600,39.200 69.600 C 38.667 69.600,38.400 69.867,38.400 70.400 C 38.400 70.933,38.133 71.200,37.600 71.200 C 37.067 71.200,36.800 71.467,36.800 72.000 C 36.800 72.533,36.533 72.800,36.000 72.800 C 35.467 72.800,35.200 73.067,35.200 73.600 C 35.200 74.133,34.933 74.400,34.400 74.400 C 33.733 74.400,33.600 74.667,33.600 76.000 C 33.600 77.333,33.467 77.600,32.800 77.600 C 32.267 77.600,32.000 77.867,32.000 78.400 C 32.000 78.933,31.733 79.200,31.200 79.200 C 30.756 79.200,30.400 79.467,30.400 79.800 C 30.400 80.130,30.130 80.400,29.800 80.400 C 29.367 80.400,29.200 80.844,29.200 82.000 C 29.200 83.333,29.067 83.600,28.400 83.600 C 27.867 83.600,27.600 83.867,27.600 84.400 C 27.600 84.933,27.333 85.200,26.800 85.200 C 26.133 85.200,26.000 85.467,26.000 86.800 C 26.000 88.133,25.867 88.400,25.200 88.400 C 24.667 88.400,24.400 88.667,24.400 89.200 C 24.400 89.733,24.133 90.000,23.600 90.000 C 22.933 90.000,22.800 90.267,22.800 91.600 C 22.800 92.933,22.667 93.200,22.000 93.200 C 21.352 93.200,21.200 93.467,21.200 94.600 C 21.200 95.733,21.048 96.000,20.400 96.000 C 19.883 96.000,19.600 96.267,19.600 96.753 C 19.600 97.170,19.243 97.600,18.800 97.716 C 18.194 97.875,18.000 98.262,18.000 99.316 C 18.000 100.370,17.806 100.757,17.200 100.916 C 16.587 101.076,16.400 101.462,16.400 102.563 C 16.400 103.733,16.252 104.000,15.600 104.000 C 14.933 104.000,14.800 104.267,14.800 105.600 C 14.800 106.933,14.667 107.200,14.000 107.200 C 13.289 107.200,13.200 107.467,13.200 109.600 C 13.200 111.467,13.067 112.000,12.600 112.000 C 12.181 112.000,12.000 112.422,12.000 113.400 C 12.000 114.533,11.848 114.800,11.200 114.800 C 10.489 114.800,10.400 115.067,10.400 117.200 C 10.400 119.333,10.311 119.600,9.600 119.600 C 8.933 119.600,8.800 119.867,8.800 121.200 C 8.800 122.533,8.667 122.800,8.000 122.800 C 7.267 122.800,7.200 123.067,7.200 126.000 C 7.200 128.933,7.133 129.200,6.400 129.200 C 5.697 129.200,5.600 129.467,5.600 131.400 C 5.600 133.333,5.503 133.600,4.800 133.600 C 4.067 133.600,4.000 133.867,4.000 136.800 C 4.000 139.733,3.933 140.000,3.200 140.000 C 2.456 140.000,2.400 140.267,2.400 143.800 C 2.400 147.333,2.344 147.600,1.600 147.600 C 0.838 147.600,0.800 147.867,0.800 153.200 C 0.800 156.667,0.648 158.800,0.400 158.800 C 0.139 158.800,0.000 165.000,0.000 176.600 C 0.000 188.200,0.139 194.400,0.400 194.400 C 0.648 194.400,0.800 196.533,0.800 200.000 C 0.800 205.333,0.838 205.600,1.600 205.600 C 2.344 205.600,2.400 205.867,2.400 209.400 C 2.400 212.933,2.456 213.200,3.200 213.200 C 3.933 213.200,4.000 213.467,4.000 216.400 C 4.000 219.333,4.067 219.600,4.800 219.600 C 5.529 219.600,5.600 219.867,5.600 222.600 C 5.600 225.333,5.671 225.600,6.400 225.600 C 7.111 225.600,7.200 225.867,7.200 228.000 C 7.200 230.133,7.289 230.400,8.000 230.400 C 8.667 230.400,8.800 230.667,8.800 232.000 C 8.800 233.333,8.933 233.600,9.600 233.600 C 10.311 233.600,10.400 233.867,10.400 236.000 C 10.400 238.133,10.489 238.400,11.200 238.400 C 11.867 238.400,12.000 238.667,12.000 240.000 C 12.000 241.156,12.167 241.600,12.600 241.600 C 13.061 241.600,13.200 242.111,13.200 243.800 C 13.200 245.733,13.297 246.000,14.000 246.000 C 14.667 246.000,14.800 246.267,14.800 247.600 C 14.800 248.933,14.933 249.200,15.600 249.200 C 16.252 249.200,16.400 249.467,16.400 250.637 C 16.400 251.738,16.587 252.124,17.200 252.284 C 17.806 252.443,18.000 252.830,18.000 253.884 C 18.000 254.938,18.194 255.325,18.800 255.484 C 19.243 255.600,19.600 256.030,19.600 256.447 C 19.600 256.933,19.883 257.200,20.400 257.200 C 21.048 257.200,21.200 257.467,21.200 258.600 C 21.200 259.733,21.352 260.000,22.000 260.000 C 22.667 260.000,22.800 260.267,22.800 261.600 C 22.800 262.933,22.933 263.200,23.600 263.200 C 24.133 263.200,24.400 263.467,24.400 264.000 C 24.400 264.533,24.667 264.800,25.200 264.800 C 25.867 264.800,26.000 265.067,26.000 266.400 C 26.000 267.733,26.133 268.000,26.800 268.000 C 27.333 268.000,27.600 268.267,27.600 268.800 C 27.600 269.333,27.867 269.600,28.400 269.600 C 29.067 269.600,29.200 269.867,29.200 271.200 C 29.200 272.296,29.374 272.800,29.753 272.800 C 30.058 272.800,30.401 273.160,30.516 273.600 C 30.631 274.040,31.012 274.400,31.363 274.400 C 31.824 274.400,32.000 274.786,32.000 275.800 C 32.000 276.933,32.152 277.200,32.800 277.200 C 33.333 277.200,33.600 277.467,33.600 278.000 C 33.600 278.533,33.867 278.800,34.400 278.800 C 34.933 278.800,35.200 279.067,35.200 279.600 C 35.200 280.133,35.467 280.400,36.000 280.400 C 36.533 280.400,36.800 280.667,36.800 281.200 C 36.800 281.733,37.067 282.000,37.600 282.000 C 38.267 282.000,38.400 282.267,38.400 283.600 C 38.400 284.933,38.533 285.200,39.200 285.200 C 39.733 285.200,40.000 285.467,40.000 286.000 C 40.000 286.533,40.267 286.800,40.800 286.800 C 41.333 286.800,41.600 287.067,41.600 287.600 C 41.600 288.133,41.867 288.400,42.400 288.400 C 42.933 288.400,43.200 288.667,43.200 289.200 C 43.200 289.733,43.467 290.000,44.000 290.000 C 44.533 290.000,44.800 290.267,44.800 290.800 C 44.800 291.244,45.067 291.600,45.400 291.600 C 45.730 291.600,46.000 291.870,46.000 292.200 C 46.000 292.533,46.356 292.800,46.800 292.800 C 47.333 292.800,47.600 293.067,47.600 293.600 C 47.600 294.133,47.867 294.400,48.400 294.400 C 48.933 294.400,49.200 294.667,49.200 295.200 C 49.200 295.733,49.467 296.000,50.000 296.000 C 50.533 296.000,50.800 296.267,50.800 296.800 C 50.800 297.333,51.067 297.600,51.600 297.600 C 52.133 297.600,52.400 297.867,52.400 298.400 C 52.400 298.933,52.667 299.200,53.200 299.200 C 53.733 299.200,54.000 299.467,54.000 300.000 C 54.000 300.533,54.267 300.800,54.800 300.800 C 55.333 300.800,55.600 301.067,55.600 301.600 C 55.600 302.133,55.867 302.400,56.400 302.400 C 56.933 302.400,57.200 302.667,57.200 303.200 C 57.200 303.733,57.467 304.000,58.000 304.000 C 58.533 304.000,58.800 304.267,58.800 304.800 C 58.800 305.333,59.067 305.600,59.600 305.600 C 60.133 305.600,60.400 305.867,60.400 306.400 C 60.400 307.048,60.667 307.200,61.800 307.200 C 62.778 307.200,63.200 307.381,63.200 307.800 C 63.200 308.133,63.556 308.400,64.000 308.400 C 64.533 308.400,64.800 308.667,64.800 309.200 C 64.800 309.733,65.067 310.000,65.600 310.000 C 66.133 310.000,66.400 310.267,66.400 310.800 C 66.400 311.333,66.667 311.600,67.200 311.600 C 67.733 311.600,68.000 311.867,68.000 312.400 C 68.000 313.067,68.267 313.200,69.600 313.200 C 70.933 313.200,71.200 313.333,71.200 314.000 C 71.200 314.533,71.467 314.800,72.000 314.800 C 72.533 314.800,72.800 315.067,72.800 315.600 C 72.800 316.267,73.067 316.400,74.400 316.400 C 75.733 316.400,76.000 316.533,76.000 317.200 C 76.000 317.733,76.267 318.000,76.800 318.000 C 77.333 318.000,77.600 318.267,77.600 318.800 C 77.600 319.333,77.867 319.600,78.400 319.600 C 78.933 319.600,79.200 319.867,79.200 320.400 C 79.200 321.042,79.467 321.200,80.553 321.200 C 81.570 321.200,81.959 321.399,82.116 322.000 C 82.276 322.613,82.662 322.800,83.763 322.800 C 84.933 322.800,85.200 322.948,85.200 323.600 C 85.200 324.133,85.467 324.400,86.000 324.400 C 86.444 324.400,86.800 324.667,86.800 325.000 C 86.800 325.433,87.244 325.600,88.400 325.600 C 89.733 325.600,90.000 325.733,90.000 326.400 C 90.000 327.067,90.267 327.200,91.600 327.200 C 92.933 327.200,93.200 327.333,93.200 328.000 C 93.200 328.533,93.467 328.800,94.000 328.800 C 94.533 328.800,94.800 329.067,94.800 329.600 C 94.800 330.248,95.067 330.400,96.200 330.400 C 97.333 330.400,97.600 330.552,97.600 331.200 C 97.600 331.867,97.867 332.000,99.200 332.000 C 100.533 332.000,100.800 332.133,100.800 332.800 C 100.800 333.467,101.067 333.600,102.400 333.600 C 103.733 333.600,104.000 333.733,104.000 334.400 C 104.000 335.111,104.267 335.200,106.400 335.200 C 108.533 335.200,108.800 335.289,108.800 336.000 C 108.800 336.667,109.067 336.800,110.400 336.800 C 111.733 336.800,112.000 336.933,112.000 337.600 C 112.000 338.242,112.267 338.400,113.353 338.400 C 114.370 338.400,114.759 338.599,114.916 339.200 C 115.094 339.880,115.462 340.000,117.363 340.000 C 119.333 340.000,119.600 340.095,119.600 340.800 C 119.600 341.511,119.867 341.600,122.000 341.600 C 123.867 341.600,124.400 341.733,124.400 342.200 C 124.400 342.633,124.844 342.800,126.000 342.800 C 127.333 342.800,127.600 342.933,127.600 343.600 C 127.600 344.329,127.867 344.400,130.600 344.400 C 133.333 344.400,133.600 344.471,133.600 345.200 C 133.600 345.911,133.867 346.000,136.000 346.000 C 138.133 346.000,138.400 346.089,138.400 346.800 C 138.400 347.533,138.667 347.600,141.600 347.600 C 144.533 347.600,144.800 347.667,144.800 348.400 C 144.800 349.129,145.067 349.200,147.800 349.200 C 150.533 349.200,150.800 349.271,150.800 350.000 C 150.800 350.747,151.067 350.800,154.800 350.800 C 158.533 350.800,158.800 350.853,158.800 351.600 C 158.800 352.360,159.067 352.400,164.200 352.400 C 169.333 352.400,169.600 352.440,169.600 353.200 C 169.600 353.975,169.867 354.000,178.153 354.000 C 186.370 354.000,186.715 354.031,186.916 354.800 C 187.119 355.578,187.462 355.600,199.363 355.600 C 211.333 355.600,211.600 355.583,211.600 354.800 C 211.600 354.025,211.867 354.000,220.200 354.000 C 228.533 354.000,228.800 353.975,228.800 353.200 C 228.800 352.453,229.067 352.400,232.800 352.400 C 236.533 352.400,236.800 352.453,236.800 353.200 C 236.800 353.867,237.067 354.000,238.400 354.000 C 239.733 354.000,240.000 354.133,240.000 354.800 C 240.000 355.333,240.267 355.600,240.800 355.600 C 241.333 355.600,241.600 355.867,241.600 356.400 C 241.600 356.933,241.867 357.200,242.400 357.200 C 242.844 357.200,243.200 357.467,243.200 357.800 C 243.200 358.219,243.622 358.400,244.600 358.400 C 245.733 358.400,246.000 358.552,246.000 359.200 C 246.000 359.733,246.267 360.000,246.800 360.000 C 247.333 360.000,247.600 360.267,247.600 360.800 C 247.600 361.467,247.867 361.600,249.200 361.600 C 250.533 361.600,250.800 361.733,250.800 362.400 C 250.800 362.933,251.067 363.200,251.600 363.200 C 252.133 363.200,252.400 363.467,252.400 364.000 C 252.400 364.667,252.667 364.800,254.000 364.800 C 255.333 364.800,255.600 364.933,255.600 365.600 C 255.600 366.267,255.867 366.400,257.200 366.400 C 258.533 366.400,258.800 366.533,258.800 367.200 C 258.800 367.733,259.067 368.000,259.600 368.000 C 260.133 368.000,260.400 368.267,260.400 368.800 C 260.400 369.442,260.667 369.600,261.753 369.600 C 262.770 369.600,263.159 369.799,263.316 370.400 C 263.475 371.006,263.862 371.200,264.916 371.200 C 265.970 371.200,266.357 371.394,266.516 372.000 C 266.676 372.613,267.062 372.800,268.163 372.800 C 269.333 372.800,269.600 372.948,269.600 373.600 C 269.600 374.133,269.867 374.400,270.400 374.400 C 270.844 374.400,271.200 374.667,271.200 375.000 C 271.200 375.433,271.644 375.600,272.800 375.600 C 274.133 375.600,274.400 375.733,274.400 376.400 C 274.400 377.067,274.667 377.200,276.000 377.200 C 277.333 377.200,277.600 377.333,277.600 378.000 C 277.600 378.648,277.867 378.800,279.000 378.800 C 280.133 378.800,280.400 378.952,280.400 379.600 C 280.400 380.267,280.667 380.400,282.000 380.400 C 283.333 380.400,283.600 380.533,283.600 381.200 C 283.600 381.911,283.867 382.000,286.000 382.000 C 288.133 382.000,288.400 382.089,288.400 382.800 C 288.400 383.467,288.667 383.600,290.000 383.600 C 291.333 383.600,291.600 383.733,291.600 384.400 C 291.600 385.067,291.867 385.200,293.200 385.200 C 294.533 385.200,294.800 385.333,294.800 386.000 C 294.800 386.701,295.067 386.800,296.953 386.800 C 298.770 386.800,299.139 386.925,299.316 387.600 C 299.475 388.206,299.862 388.400,300.916 388.400 C 301.970 388.400,302.357 388.594,302.516 389.200 C 302.694 389.880,303.062 390.000,304.963 390.000 C 306.933 390.000,307.200 390.095,307.200 390.800 C 307.200 391.511,307.467 391.600,309.600 391.600 C 311.467 391.600,312.000 391.733,312.000 392.200 C 312.000 392.661,312.511 392.800,314.200 392.800 C 316.133 392.800,316.400 392.897,316.400 393.600 C 316.400 394.333,316.667 394.400,319.600 394.400 C 322.533 394.400,322.800 394.467,322.800 395.200 C 322.800 395.933,323.067 396.000,326.000 396.000 C 328.933 396.000,329.200 396.067,329.200 396.800 C 329.200 397.544,329.467 397.600,333.000 397.600 C 336.533 397.600,336.800 397.656,336.800 398.400 C 336.800 399.154,337.067 399.200,341.400 399.200 C 344.200 399.200,346.000 399.357,346.000 399.600 C 346.000 399.861,353.067 400.000,366.400 400.000 C 379.733 400.000,386.800 399.861,386.800 399.600 C 386.800 399.361,388.333 399.200,390.600 399.200 C 394.133 399.200,394.400 399.144,394.400 398.400 C 394.400 397.733,394.667 397.600,396.000 397.600 C 397.333 397.600,397.600 397.467,397.600 396.800 C 397.600 396.178,397.867 396.000,398.800 396.000 L 400.000 396.000 400.000 389.000 C 400.000 384.600,399.851 382.000,399.600 382.000 C 399.380 382.000,399.200 381.640,399.200 381.200 C 399.200 380.667,398.933 380.400,398.400 380.400 C 397.956 380.400,397.600 380.133,397.600 379.800 C 397.600 379.367,397.156 379.200,396.000 379.200 C 394.667 379.200,394.400 379.067,394.400 378.400 C 394.400 377.867,394.133 377.600,393.600 377.600 C 393.067 377.600,392.800 377.333,392.800 376.800 C 392.800 376.356,392.533 376.000,392.200 376.000 C 391.867 376.000,391.600 375.644,391.600 375.200 C 391.600 374.667,391.333 374.400,390.800 374.400 C 390.267 374.400,390.000 374.133,390.000 373.600 C 390.000 372.933,389.733 372.800,388.400 372.800 C 387.067 372.800,386.800 372.667,386.800 372.000 C 386.800 371.467,386.533 371.200,386.000 371.200 C 385.467 371.200,385.200 370.933,385.200 370.400 C 385.200 369.867,384.933 369.600,384.400 369.600 C 383.867 369.600,383.600 369.333,383.600 368.800 C 383.600 368.133,383.333 368.000,382.000 368.000 C 380.667 368.000,380.400 367.867,380.400 367.200 C 380.400 366.667,380.133 366.400,379.600 366.400 C 379.067 366.400,378.800 366.133,378.800 365.600 C 378.800 365.067,378.533 364.800,378.000 364.800 C 377.467 364.800,377.200 364.533,377.200 364.000 C 377.200 363.467,376.933 363.200,376.400 363.200 C 375.956 363.200,375.600 362.933,375.600 362.600 C 375.600 362.270,375.330 362.000,375.000 362.000 C 374.667 362.000,374.400 361.644,374.400 361.200 C 374.400 360.667,374.133 360.400,373.600 360.400 C 373.067 360.400,372.800 360.133,372.800 359.600 C 372.800 359.067,372.533 358.800,372.000 358.800 C 371.467 358.800,371.200 358.533,371.200 358.000 C 371.200 357.467,370.933 357.200,370.400 357.200 C 369.867 357.200,369.600 356.933,369.600 356.400 C 369.600 355.867,369.333 355.600,368.800 355.600 C 368.267 355.600,368.000 355.333,368.000 354.800 C 368.000 354.267,367.733 354.000,367.200 354.000 C 366.667 354.000,366.400 353.733,366.400 353.200 C 366.400 352.667,366.133 352.400,365.600 352.400 C 365.067 352.400,364.800 352.133,364.800 351.600 C 364.800 351.067,364.533 350.800,364.000 350.800 C 363.467 350.800,363.200 350.533,363.200 350.000 C 363.200 349.467,362.933 349.200,362.400 349.200 C 361.867 349.200,361.600 348.933,361.600 348.400 C 361.600 347.867,361.333 347.600,360.800 347.600 C 360.267 347.600,360.000 347.333,360.000 346.800 C 360.000 346.267,359.733 346.000,359.200 346.000 C 358.552 346.000,358.400 345.733,358.400 344.600 C 358.400 343.622,358.219 343.200,357.800 343.200 C 357.467 343.200,357.200 342.844,357.200 342.400 C 357.200 341.867,356.933 341.600,356.400 341.600 C 355.733 341.600,355.600 341.333,355.600 340.000 C 355.600 338.667,355.467 338.400,354.800 338.400 C 354.267 338.400,354.000 338.133,354.000 337.600 C 354.000 337.067,353.733 336.800,353.200 336.800 C 352.533 336.800,352.400 336.533,352.400 335.200 C 352.400 333.867,352.267 333.600,351.600 333.600 C 350.948 333.600,350.800 333.333,350.800 332.163 C 350.800 331.062,350.613 330.676,350.000 330.516 C 349.399 330.359,349.200 329.970,349.200 328.953 C 349.200 327.867,349.042 327.600,348.400 327.600 C 347.689 327.600,347.600 327.333,347.600 325.200 C 347.600 323.067,347.511 322.800,346.800 322.800 C 346.089 322.800,346.000 322.533,346.000 320.400 C 346.000 318.267,345.911 318.000,345.200 318.000 C 344.489 318.000,344.400 317.733,344.400 315.600 C 344.400 313.467,344.311 313.200,343.600 313.200 C 342.834 313.200,342.800 312.933,342.800 307.000 C 342.800 301.067,342.834 300.800,343.600 300.800 C 344.133 300.800,344.400 300.533,344.400 300.000 C 344.400 299.467,344.667 299.200,345.200 299.200 C 345.733 299.200,346.000 298.933,346.000 298.400 C 346.000 297.867,346.267 297.600,346.800 297.600 C 347.333 297.600,347.600 297.333,347.600 296.800 C 347.600 296.267,347.867 296.000,348.400 296.000 C 348.933 296.000,349.200 295.733,349.200 295.200 C 349.200 294.667,349.467 294.400,350.000 294.400 C 350.533 294.400,350.800 294.133,350.800 293.600 C 350.800 293.067,351.067 292.800,351.600 292.800 C 352.040 292.800,352.400 292.551,352.400 292.247 C 352.400 291.942,352.760 291.599,353.200 291.484 C 353.640 291.369,354.000 290.988,354.000 290.637 C 354.000 290.287,354.287 290.000,354.637 290.000 C 354.988 290.000,355.369 289.640,355.484 289.200 C 355.599 288.760,355.959 288.400,356.284 288.400 C 356.609 288.400,356.969 288.040,357.084 287.600 C 357.199 287.160,357.542 286.800,357.847 286.800 C 358.226 286.800,358.400 286.296,358.400 285.200 C 358.400 283.867,358.533 283.600,359.200 283.600 C 359.733 283.600,360.000 283.333,360.000 282.800 C 360.000 282.267,360.267 282.000,360.800 282.000 C 361.333 282.000,361.600 281.733,361.600 281.200 C 361.600 280.667,361.867 280.400,362.400 280.400 C 362.933 280.400,363.200 280.133,363.200 279.600 C 363.200 279.067,363.467 278.800,364.000 278.800 C 364.667 278.800,364.800 278.533,364.800 277.200 C 364.800 275.867,364.933 275.600,365.600 275.600 C 366.044 275.600,366.400 275.333,366.400 275.000 C 366.400 274.670,366.687 274.400,367.037 274.400 C 367.388 274.400,367.765 274.057,367.874 273.637 C 367.984 273.217,368.417 272.784,368.837 272.674 C 369.409 272.525,369.600 272.115,369.600 271.037 C 369.600 269.867,369.748 269.600,370.400 269.600 C 370.917 269.600,371.200 269.333,371.200 268.847 C 371.200 268.430,371.557 268.000,372.000 267.884 C 372.613 267.724,372.800 267.338,372.800 266.237 C 372.800 265.067,372.948 264.800,373.600 264.800 C 374.133 264.800,374.400 264.533,374.400 264.000 C 374.400 263.556,374.667 263.200,375.000 263.200 C 375.433 263.200,375.600 262.756,375.600 261.600 C 375.600 260.267,375.733 260.000,376.400 260.000 C 377.048 260.000,377.200 259.733,377.200 258.600 C 377.200 257.467,377.352 257.200,378.000 257.200 C 378.667 257.200,378.800 256.933,378.800 255.600 C 378.800 254.267,378.933 254.000,379.600 254.000 C 380.267 254.000,380.400 253.733,380.400 252.400 C 380.400 251.067,380.533 250.800,381.200 250.800 C 381.867 250.800,382.000 250.533,382.000 249.200 C 382.000 247.867,382.133 247.600,382.800 247.600 C 383.467 247.600,383.600 247.333,383.600 246.000 C 383.600 244.667,383.733 244.400,384.400 244.400 C 385.048 244.400,385.200 244.133,385.200 243.000 C 385.200 241.867,385.352 241.600,386.000 241.600 C 386.663 241.600,386.800 241.333,386.800 240.047 C 386.800 238.830,386.973 238.448,387.600 238.284 C 388.280 238.106,388.400 237.738,388.400 235.837 C 388.400 233.867,388.495 233.600,389.200 233.600 C 389.911 233.600,390.000 233.333,390.000 231.200 C 390.000 229.067,390.089 228.800,390.800 228.800 C 391.503 228.800,391.600 228.533,391.600 226.600 C 391.600 224.911,391.739 224.400,392.200 224.400 C 392.667 224.400,392.800 223.867,392.800 222.000 C 392.800 219.867,392.889 219.600,393.600 219.600 C 394.333 219.600,394.400 219.333,394.400 216.400 C 394.400 213.467,394.467 213.200,395.200 213.200 C 395.944 213.200,396.000 212.933,396.000 209.400 C 396.000 205.867,396.056 205.600,396.800 205.600 C 397.567 205.600,397.600 205.333,397.600 199.200 C 397.600 193.067,397.633 192.800,398.400 192.800 C 399.187 192.800,399.200 192.533,399.200 176.600 C 399.200 160.667,399.187 160.400,398.400 160.400 C 397.638 160.400,397.600 160.133,397.600 154.800 C 397.600 149.467,397.562 149.200,396.800 149.200 C 396.056 149.200,396.000 148.933,396.000 145.400 C 396.000 141.867,395.944 141.600,395.200 141.600 C 394.453 141.600,394.400 141.333,394.400 137.600 C 394.400 133.867,394.347 133.600,393.600 133.600 C 392.897 133.600,392.800 133.333,392.800 131.400 C 392.800 129.711,392.661 129.200,392.200 129.200 C 391.733 129.200,391.600 128.667,391.600 126.800 C 391.600 124.667,391.511 124.400,390.800 124.400 C 390.095 124.400,390.000 124.133,390.000 122.163 C 390.000 120.262,389.880 119.894,389.200 119.716 C 388.523 119.539,388.400 119.170,388.400 117.316 C 388.400 115.462,388.277 115.093,387.600 114.916 C 386.999 114.759,386.800 114.370,386.800 113.353 C 386.800 112.267,386.642 112.000,386.000 112.000 C 385.333 112.000,385.200 111.733,385.200 110.400 C 385.200 109.067,385.067 108.800,384.400 108.800 C 383.733 108.800,383.600 108.533,383.600 107.200 C 383.600 105.867,383.467 105.600,382.800 105.600 C 382.133 105.600,382.000 105.333,382.000 104.000 C 382.000 102.667,381.867 102.400,381.200 102.400 C 380.533 102.400,380.400 102.133,380.400 100.800 C 380.400 99.467,380.267 99.200,379.600 99.200 C 378.933 99.200,378.800 98.933,378.800 97.600 C 378.800 96.267,378.667 96.000,378.000 96.000 C 377.352 96.000,377.200 95.733,377.200 94.600 C 377.200 93.467,377.048 93.200,376.400 93.200 C 375.867 93.200,375.600 92.933,375.600 92.400 C 375.600 91.956,375.333 91.600,375.000 91.600 C 374.567 91.600,374.400 91.156,374.400 90.000 C 374.400 88.667,374.267 88.400,373.600 88.400 C 372.948 88.400,372.800 88.133,372.800 86.963 C 372.800 85.862,372.613 85.476,372.000 85.316 C 371.557 85.200,371.200 84.770,371.200 84.353 C 371.200 83.867,370.917 83.600,370.400 83.600 C 369.867 83.600,369.600 83.333,369.600 82.800 C 369.600 82.267,369.333 82.000,368.800 82.000 C 368.152 82.000,368.000 81.733,368.000 80.600 C 368.000 79.467,367.848 79.200,367.200 79.200 C 366.667 79.200,366.400 78.933,366.400 78.400 C 366.400 77.867,366.133 77.600,365.600 77.600 C 364.933 77.600,364.800 77.333,364.800 76.000 C 364.800 74.667,364.667 74.400,364.000 74.400 C 363.467 74.400,363.200 74.133,363.200 73.600 C 363.200 73.067,362.933 72.800,362.400 72.800 C 361.867 72.800,361.600 72.533,361.600 72.000 C 361.600 71.467,361.333 71.200,360.800 71.200 C 360.267 71.200,360.000 70.933,360.000 70.400 C 360.000 69.867,359.733 69.600,359.200 69.600 C 358.667 69.600,358.400 69.333,358.400 68.800 C 358.400 68.356,358.133 68.000,357.800 68.000 C 357.378 68.000,357.200 67.574,357.200 66.563 C 357.200 65.485,357.009 65.075,356.437 64.926 C 356.017 64.816,355.584 64.383,355.474 63.963 C 355.365 63.543,354.988 63.200,354.637 63.200 C 354.287 63.200,354.000 62.930,354.000 62.600 C 354.000 62.267,353.644 62.000,353.200 62.000 C 352.667 62.000,352.400 61.733,352.400 61.200 C 352.400 60.667,352.133 60.400,351.600 60.400 C 351.067 60.400,350.800 60.133,350.800 59.600 C 350.800 59.067,350.533 58.800,350.000 58.800 C 349.467 58.800,349.200 58.533,349.200 58.000 C 349.200 57.467,348.933 57.200,348.400 57.200 C 347.867 57.200,347.600 56.933,347.600 56.400 C 347.600 55.867,347.333 55.600,346.800 55.600 C 346.267 55.600,346.000 55.333,346.000 54.800 C 346.000 54.267,345.733 54.000,345.200 54.000 C 344.667 54.000,344.400 53.733,344.400 53.200 C 344.400 52.667,344.133 52.400,343.600 52.400 C 343.067 52.400,342.800 52.133,342.800 51.600 C 342.800 51.160,342.551 50.800,342.247 50.800 C 341.942 50.800,341.599 50.440,341.484 50.000 C 341.325 49.394,340.938 49.200,339.884 49.200 C 338.830 49.200,338.443 49.006,338.284 48.400 C 338.169 47.960,337.788 47.600,337.437 47.600 C 337.067 47.600,336.800 47.265,336.800 46.800 C 336.800 46.267,336.533 46.000,336.000 46.000 C 335.556 46.000,335.200 45.733,335.200 45.400 C 335.200 45.067,334.844 44.800,334.400 44.800 C 333.867 44.800,333.600 44.533,333.600 44.000 C 333.600 43.467,333.333 43.200,332.800 43.200 C 332.267 43.200,332.000 42.933,332.000 42.400 C 332.000 41.733,331.733 41.600,330.400 41.600 C 329.067 41.600,328.800 41.467,328.800 40.800 C 328.800 40.267,328.533 40.000,328.000 40.000 C 327.467 40.000,327.200 39.733,327.200 39.200 C 327.200 38.667,326.933 38.400,326.400 38.400 C 325.867 38.400,325.600 38.133,325.600 37.600 C 325.600 36.952,325.333 36.800,324.200 36.800 C 323.067 36.800,322.800 36.648,322.800 36.000 C 322.800 35.483,322.533 35.200,322.047 35.200 C 321.630 35.200,321.200 34.843,321.084 34.400 C 320.924 33.787,320.538 33.600,319.437 33.600 C 318.267 33.600,318.000 33.452,318.000 32.800 C 318.000 32.267,317.733 32.000,317.200 32.000 C 316.667 32.000,316.400 31.733,316.400 31.200 C 316.400 30.533,316.133 30.400,314.800 30.400 C 313.644 30.400,313.200 30.233,313.200 29.800 C 313.200 29.367,312.756 29.200,311.600 29.200 C 310.267 29.200,310.000 29.067,310.000 28.400 C 310.000 27.867,309.733 27.600,309.200 27.600 C 308.667 27.600,308.400 27.333,308.400 26.800 C 308.400 26.152,308.133 26.000,307.000 26.000 C 305.867 26.000,305.600 25.848,305.600 25.200 C 305.600 24.533,305.333 24.400,304.000 24.400 C 302.667 24.400,302.400 24.267,302.400 23.600 C 302.400 22.933,302.133 22.800,300.800 22.800 C 299.467 22.800,299.200 22.667,299.200 22.000 C 299.200 21.333,298.933 21.200,297.600 21.200 C 296.267 21.200,296.000 21.067,296.000 20.400 C 296.000 19.733,295.733 19.600,294.400 19.600 C 293.067 19.600,292.800 19.467,292.800 18.800 C 292.800 18.158,292.533 18.000,291.447 18.000 C 290.430 18.000,290.041 17.801,289.884 17.200 C 289.725 16.594,289.338 16.400,288.284 16.400 C 287.230 16.400,286.843 16.206,286.684 15.600 C 286.506 14.920,286.138 14.800,284.237 14.800 C 282.267 14.800,282.000 14.705,282.000 14.000 C 282.000 13.333,281.733 13.200,280.400 13.200 C 279.244 13.200,278.800 13.033,278.800 12.600 C 278.800 12.139,278.289 12.000,276.600 12.000 C 274.667 12.000,274.400 11.903,274.400 11.200 C 274.400 10.489,274.133 10.400,272.000 10.400 C 269.867 10.400,269.600 10.311,269.600 9.600 C 269.600 8.889,269.333 8.800,267.200 8.800 C 265.067 8.800,264.800 8.711,264.800 8.000 C 264.800 7.267,264.533 7.200,261.600 7.200 C 258.667 7.200,258.400 7.133,258.400 6.400 C 258.400 5.671,258.133 5.600,255.400 5.600 C 252.667 5.600,252.400 5.529,252.400 4.800 C 252.400 4.067,252.133 4.000,249.200 4.000 C 246.267 4.000,246.000 3.933,246.000 3.200 C 246.000 2.457,245.733 2.400,242.247 2.400 C 238.830 2.400,238.475 2.328,238.284 1.600 C 238.086 0.843,237.738 0.800,231.837 0.800 C 227.946 0.800,225.600 0.650,225.600 0.400 C 225.600 0.137,216.267 0.000,198.400 0.000 C 180.533 0.000,171.200 0.137,171.200 0.400 M219.600 18.800 C 219.600 19.560,219.867 19.600,224.953 19.600 C 229.970 19.600,230.320 19.650,230.516 20.400 C 230.710 21.142,231.062 21.200,235.363 21.200 C 239.733 21.200,240.000 21.246,240.000 22.000 C 240.000 22.728,240.267 22.800,242.953 22.800 C 245.570 22.800,245.931 22.891,246.116 23.600 C 246.302 24.311,246.662 24.400,249.363 24.400 C 251.796 24.400,252.400 24.519,252.400 25.000 C 252.400 25.483,253.022 25.600,255.600 25.600 C 258.533 25.600,258.800 25.667,258.800 26.400 C 258.800 27.103,259.067 27.200,261.000 27.200 C 262.933 27.200,263.200 27.297,263.200 28.000 C 263.200 28.711,263.467 28.800,265.600 28.800 C 267.733 28.800,268.000 28.889,268.000 29.600 C 268.000 30.267,268.267 30.400,269.600 30.400 C 270.933 30.400,271.200 30.533,271.200 31.200 C 271.200 31.911,271.467 32.000,273.600 32.000 C 275.733 32.000,276.000 32.089,276.000 32.800 C 276.000 33.467,276.267 33.600,277.600 33.600 C 278.933 33.600,279.200 33.733,279.200 34.400 C 279.200 35.042,279.467 35.200,280.553 35.200 C 281.570 35.200,281.959 35.399,282.116 36.000 C 282.275 36.606,282.662 36.800,283.716 36.800 C 284.770 36.800,285.157 36.994,285.316 37.600 C 285.476 38.213,285.862 38.400,286.963 38.400 C 288.133 38.400,288.400 38.548,288.400 39.200 C 288.400 39.867,288.667 40.000,290.000 40.000 C 291.333 40.000,291.600 40.133,291.600 40.800 C 291.600 41.467,291.867 41.600,293.200 41.600 C 294.356 41.600,294.800 41.767,294.800 42.200 C 294.800 42.619,295.222 42.800,296.200 42.800 C 297.333 42.800,297.600 42.952,297.600 43.600 C 297.600 44.267,297.867 44.400,299.200 44.400 C 300.533 44.400,300.800 44.533,300.800 45.200 C 300.800 45.733,301.067 46.000,301.600 46.000 C 302.133 46.000,302.400 46.267,302.400 46.800 C 302.400 47.467,302.667 47.600,304.000 47.600 C 305.333 47.600,305.600 47.733,305.600 48.400 C 305.600 48.933,305.867 49.200,306.400 49.200 C 306.933 49.200,307.200 49.467,307.200 50.000 C 307.200 50.667,307.467 50.800,308.800 50.800 C 310.133 50.800,310.400 50.933,310.400 51.600 C 310.400 52.133,310.667 52.400,311.200 52.400 C 311.733 52.400,312.000 52.667,312.000 53.200 C 312.000 53.848,312.267 54.000,313.400 54.000 C 314.414 54.000,314.800 54.176,314.800 54.637 C 314.800 54.988,315.160 55.369,315.600 55.484 C 316.040 55.599,316.400 55.959,316.400 56.284 C 316.400 56.609,316.760 56.969,317.200 57.084 C 317.640 57.199,318.000 57.542,318.000 57.847 C 318.000 58.226,318.504 58.400,319.600 58.400 C 320.933 58.400,321.200 58.533,321.200 59.200 C 321.200 59.733,321.467 60.000,322.000 60.000 C 322.533 60.000,322.800 60.267,322.800 60.800 C 322.800 61.333,323.067 61.600,323.600 61.600 C 324.133 61.600,324.400 61.867,324.400 62.400 C 324.400 62.933,324.667 63.200,325.200 63.200 C 325.733 63.200,326.000 63.467,326.000 64.000 C 326.000 64.533,326.267 64.800,326.800 64.800 C 327.333 64.800,327.600 65.067,327.600 65.600 C 327.600 66.133,327.867 66.400,328.400 66.400 C 328.933 66.400,329.200 66.667,329.200 67.200 C 329.200 67.640,329.449 68.000,329.753 68.000 C 330.058 68.000,330.401 68.360,330.516 68.800 C 330.631 69.240,330.991 69.600,331.316 69.600 C 331.641 69.600,332.001 69.960,332.116 70.400 C 332.231 70.840,332.591 71.200,332.916 71.200 C 333.241 71.200,333.601 71.560,333.716 72.000 C 333.831 72.440,334.191 72.800,334.516 72.800 C 334.841 72.800,335.201 73.160,335.316 73.600 C 335.431 74.040,335.812 74.400,336.163 74.400 C 336.513 74.400,336.800 74.670,336.800 75.000 C 336.800 75.333,337.156 75.600,337.600 75.600 C 338.133 75.600,338.400 75.867,338.400 76.400 C 338.400 76.933,338.667 77.200,339.200 77.200 C 339.733 77.200,340.000 77.467,340.000 78.000 C 340.000 78.533,340.267 78.800,340.800 78.800 C 341.333 78.800,341.600 79.067,341.600 79.600 C 341.600 80.133,341.867 80.400,342.400 80.400 C 342.933 80.400,343.200 80.667,343.200 81.200 C 343.200 81.733,343.467 82.000,344.000 82.000 C 344.533 82.000,344.800 82.267,344.800 82.800 C 344.800 83.244,345.067 83.600,345.400 83.600 C 345.733 83.600,346.000 83.956,346.000 84.400 C 346.000 84.933,346.267 85.200,346.800 85.200 C 347.452 85.200,347.600 85.467,347.600 86.637 C 347.600 87.715,347.791 88.125,348.363 88.274 C 348.783 88.384,349.216 88.817,349.326 89.237 C 349.435 89.657,349.812 90.000,350.163 90.000 C 350.533 90.000,350.800 90.335,350.800 90.800 C 350.800 91.333,351.067 91.600,351.600 91.600 C 352.248 91.600,352.400 91.867,352.400 93.000 C 352.400 94.133,352.552 94.400,353.200 94.400 C 353.733 94.400,354.000 94.667,354.000 95.200 C 354.000 95.733,354.267 96.000,354.800 96.000 C 355.467 96.000,355.600 96.267,355.600 97.600 C 355.600 98.933,355.733 99.200,356.400 99.200 C 356.933 99.200,357.200 99.467,357.200 100.000 C 357.200 100.533,357.467 100.800,358.000 100.800 C 358.667 100.800,358.800 101.067,358.800 102.400 C 358.800 103.733,358.933 104.000,359.600 104.000 C 360.267 104.000,360.400 104.267,360.400 105.600 C 360.400 106.933,360.533 107.200,361.200 107.200 C 361.848 107.200,362.000 107.467,362.000 108.600 C 362.000 109.578,362.181 110.000,362.600 110.000 C 362.933 110.000,363.200 110.356,363.200 110.800 C 363.200 111.333,363.467 111.600,364.000 111.600 C 364.667 111.600,364.800 111.867,364.800 113.200 C 364.800 114.533,364.933 114.800,365.600 114.800 C 366.305 114.800,366.400 115.067,366.400 117.037 C 366.400 118.938,366.520 119.306,367.200 119.484 C 367.806 119.643,368.000 120.030,368.000 121.084 C 368.000 122.138,368.194 122.525,368.800 122.684 C 369.401 122.841,369.600 123.230,369.600 124.247 C 369.600 125.333,369.758 125.600,370.400 125.600 C 371.111 125.600,371.200 125.867,371.200 128.000 C 371.200 130.133,371.289 130.400,372.000 130.400 C 372.711 130.400,372.800 130.667,372.800 132.800 C 372.800 134.933,372.889 135.200,373.600 135.200 C 374.333 135.200,374.400 135.467,374.400 138.400 C 374.400 141.333,374.467 141.600,375.200 141.600 C 375.903 141.600,376.000 141.867,376.000 143.800 C 376.000 145.733,376.097 146.000,376.800 146.000 C 377.556 146.000,377.600 146.267,377.600 150.800 C 377.600 155.333,377.644 155.600,378.400 155.600 C 379.166 155.600,379.200 155.867,379.200 161.800 C 379.200 167.044,379.292 168.000,379.800 168.000 C 380.315 168.000,380.400 169.222,380.400 176.600 C 380.400 183.978,380.315 185.200,379.800 185.200 C 379.292 185.200,379.200 186.156,379.200 191.400 C 379.200 197.333,379.166 197.600,378.400 197.600 C 377.644 197.600,377.600 197.867,377.600 202.400 C 377.600 206.933,377.556 207.200,376.800 207.200 C 376.071 207.200,376.000 207.467,376.000 210.200 C 376.000 212.933,375.929 213.200,375.200 213.200 C 374.489 213.200,374.400 213.467,374.400 215.600 C 374.400 217.733,374.311 218.000,373.600 218.000 C 372.889 218.000,372.800 218.267,372.800 220.400 C 372.800 222.533,372.711 222.800,372.000 222.800 C 371.289 222.800,371.200 223.067,371.200 225.200 C 371.200 227.333,371.111 227.600,370.400 227.600 C 369.758 227.600,369.600 227.867,369.600 228.953 C 369.600 229.970,369.401 230.359,368.800 230.516 C 368.194 230.675,368.000 231.062,368.000 232.116 C 368.000 233.170,367.806 233.557,367.200 233.716 C 366.520 233.894,366.400 234.262,366.400 236.163 C 366.400 238.133,366.305 238.400,365.600 238.400 C 364.933 238.400,364.800 238.667,364.800 240.000 C 364.800 241.333,364.667 241.600,364.000 241.600 C 363.333 241.600,363.200 241.867,363.200 243.200 C 363.200 244.356,363.033 244.800,362.600 244.800 C 362.270 244.800,362.000 245.070,362.000 245.400 C 362.000 245.733,361.644 246.000,361.200 246.000 C 360.533 246.000,360.400 246.267,360.400 247.600 C 360.400 248.933,360.267 249.200,359.600 249.200 C 358.933 249.200,358.800 249.467,358.800 250.800 C 358.800 252.133,358.667 252.400,358.000 252.400 C 357.467 252.400,357.200 252.667,357.200 253.200 C 357.200 253.733,356.933 254.000,356.400 254.000 C 355.733 254.000,355.600 254.267,355.600 255.600 C 355.600 256.933,355.467 257.200,354.800 257.200 C 354.267 257.200,354.000 257.467,354.000 258.000 C 354.000 258.533,353.733 258.800,353.200 258.800 C 352.533 258.800,352.400 259.067,352.400 260.400 C 352.400 261.733,352.267 262.000,351.600 262.000 C 351.156 262.000,350.800 262.267,350.800 262.600 C 350.800 262.930,350.513 263.200,350.163 263.200 C 349.812 263.200,349.435 263.543,349.326 263.963 C 349.216 264.383,348.783 264.816,348.363 264.926 C 347.791 265.075,347.600 265.485,347.600 266.563 C 347.600 267.733,347.452 268.000,346.800 268.000 C 346.267 268.000,346.000 268.267,346.000 268.800 C 346.000 269.244,345.733 269.600,345.400 269.600 C 345.067 269.600,344.800 269.956,344.800 270.400 C 344.800 270.933,344.533 271.200,344.000 271.200 C 343.467 271.200,343.200 271.467,343.200 272.000 C 343.200 272.533,342.933 272.800,342.400 272.800 C 341.867 272.800,341.600 273.067,341.600 273.600 C 341.600 274.133,341.333 274.400,340.800 274.400 C 340.267 274.400,340.000 274.667,340.000 275.200 C 340.000 275.733,339.733 276.000,339.200 276.000 C 338.533 276.000,338.400 276.267,338.400 277.600 C 338.400 278.933,338.267 279.200,337.600 279.200 C 337.156 279.200,336.800 279.467,336.800 279.800 C 336.800 280.133,336.444 280.400,336.000 280.400 C 335.467 280.400,335.200 280.667,335.200 281.200 C 335.200 281.733,334.933 282.000,334.400 282.000 C 333.867 282.000,333.600 282.267,333.600 282.800 C 333.600 283.333,333.333 283.600,332.800 283.600 C 332.267 283.600,332.000 283.867,332.000 284.400 C 332.000 285.048,331.733 285.200,330.600 285.200 C 329.467 285.200,329.200 285.352,329.200 286.000 C 329.200 286.533,328.933 286.800,328.400 286.800 C 327.867 286.800,327.600 287.067,327.600 287.600 C 327.600 288.133,327.333 288.400,326.800 288.400 C 326.267 288.400,326.000 288.667,326.000 289.200 C 326.000 289.733,325.733 290.000,325.200 290.000 C 324.533 290.000,324.400 290.267,324.400 291.600 C 324.400 292.933,324.267 293.200,323.600 293.200 C 322.825 293.200,322.800 293.467,322.800 301.600 C 322.800 309.733,322.825 310.000,323.600 310.000 C 324.356 310.000,324.400 310.267,324.400 314.800 C 324.400 319.333,324.444 319.600,325.200 319.600 C 325.929 319.600,326.000 319.867,326.000 322.600 C 326.000 325.333,326.071 325.600,326.800 325.600 C 327.511 325.600,327.600 325.867,327.600 328.000 C 327.600 330.133,327.689 330.400,328.400 330.400 C 329.067 330.400,329.200 330.667,329.200 332.000 C 329.200 333.156,329.367 333.600,329.800 333.600 C 330.262 333.600,330.400 334.115,330.400 335.837 C 330.400 337.738,330.520 338.106,331.200 338.284 C 331.806 338.443,332.000 338.830,332.000 339.884 C 332.000 340.938,332.194 341.325,332.800 341.484 C 333.401 341.641,333.600 342.030,333.600 343.047 C 333.600 344.133,333.758 344.400,334.400 344.400 C 335.067 344.400,335.200 344.667,335.200 346.000 C 335.200 347.333,335.333 347.600,336.000 347.600 C 336.533 347.600,336.800 347.867,336.800 348.400 C 336.800 348.933,337.067 349.200,337.600 349.200 C 338.267 349.200,338.400 349.467,338.400 350.800 C 338.400 352.133,338.533 352.400,339.200 352.400 C 339.733 352.400,340.000 352.667,340.000 353.200 C 340.000 353.733,340.267 354.000,340.800 354.000 C 341.467 354.000,341.600 354.267,341.600 355.600 C 341.600 356.933,341.733 357.200,342.400 357.200 C 342.844 357.200,343.200 357.467,343.200 357.800 C 343.200 358.133,343.556 358.400,344.000 358.400 C 344.533 358.400,344.800 358.667,344.800 359.200 C 344.800 359.644,345.067 360.000,345.400 360.000 C 345.733 360.000,346.000 360.356,346.000 360.800 C 346.000 361.333,346.267 361.600,346.800 361.600 C 347.467 361.600,347.600 361.867,347.600 363.200 C 347.600 364.533,347.733 364.800,348.400 364.800 C 348.933 364.800,349.200 365.067,349.200 365.600 C 349.200 366.133,349.467 366.400,350.000 366.400 C 350.533 366.400,350.800 366.667,350.800 367.200 C 350.800 367.733,351.067 368.000,351.600 368.000 C 352.133 368.000,352.400 368.267,352.400 368.800 C 352.400 369.333,352.667 369.600,353.200 369.600 C 353.733 369.600,354.000 369.867,354.000 370.400 C 354.000 370.933,354.267 371.200,354.800 371.200 C 355.333 371.200,355.600 371.467,355.600 372.000 C 355.600 372.533,355.867 372.800,356.400 372.800 C 356.933 372.800,357.200 373.067,357.200 373.600 C 357.200 374.133,357.467 374.400,358.000 374.400 C 358.444 374.400,358.800 374.667,358.800 375.000 C 358.800 375.333,359.156 375.600,359.600 375.600 C 360.133 375.600,360.400 375.867,360.400 376.400 C 360.400 376.933,360.667 377.200,361.200 377.200 C 361.733 377.200,362.000 377.467,362.000 378.000 C 362.000 378.648,362.267 378.800,363.400 378.800 C 364.533 378.800,364.800 378.952,364.800 379.600 C 364.800 380.133,365.067 380.400,365.600 380.400 C 366.133 380.400,366.400 380.667,366.400 381.200 C 366.400 382.448,352.610 382.448,352.284 381.200 C 352.090 380.458,351.738 380.400,347.437 380.400 C 343.582 380.400,342.800 380.299,342.800 379.800 C 342.800 379.309,342.111 379.200,339.000 379.200 C 335.467 379.200,335.200 379.144,335.200 378.400 C 335.200 377.667,334.933 377.600,332.000 377.600 C 329.067 377.600,328.800 377.533,328.800 376.800 C 328.800 376.097,328.533 376.000,326.600 376.000 C 324.667 376.000,324.400 375.903,324.400 375.200 C 324.400 374.489,324.133 374.400,322.000 374.400 C 319.867 374.400,319.600 374.311,319.600 373.600 C 319.600 372.889,319.333 372.800,317.200 372.800 C 315.067 372.800,314.800 372.711,314.800 372.000 C 314.800 371.289,314.533 371.200,312.400 371.200 C 310.267 371.200,310.000 371.111,310.000 370.400 C 310.000 369.697,309.733 369.600,307.800 369.600 C 305.867 369.600,305.600 369.503,305.600 368.800 C 305.600 368.137,305.333 368.000,304.047 368.000 C 302.830 368.000,302.448 367.827,302.284 367.200 C 302.124 366.587,301.738 366.400,300.637 366.400 C 299.467 366.400,299.200 366.252,299.200 365.600 C 299.200 364.889,298.933 364.800,296.800 364.800 C 294.667 364.800,294.400 364.711,294.400 364.000 C 294.400 363.352,294.133 363.200,293.000 363.200 C 292.022 363.200,291.600 363.019,291.600 362.600 C 291.600 362.167,291.156 362.000,290.000 362.000 C 288.667 362.000,288.400 361.867,288.400 361.200 C 288.400 360.533,288.133 360.400,286.800 360.400 C 285.467 360.400,285.200 360.267,285.200 359.600 C 285.200 358.933,284.933 358.800,283.600 358.800 C 282.267 358.800,282.000 358.667,282.000 358.000 C 282.000 357.333,281.733 357.200,280.400 357.200 C 279.067 357.200,278.800 357.067,278.800 356.400 C 278.800 355.733,278.533 355.600,277.200 355.600 C 275.867 355.600,275.600 355.467,275.600 354.800 C 275.600 354.360,275.351 354.000,275.047 354.000 C 274.742 354.000,274.399 353.640,274.284 353.200 C 274.125 352.594,273.738 352.400,272.684 352.400 C 271.630 352.400,271.243 352.206,271.084 351.600 C 270.924 350.987,270.538 350.800,269.437 350.800 C 268.267 350.800,268.000 350.652,268.000 350.000 C 268.000 349.467,267.733 349.200,267.200 349.200 C 266.667 349.200,266.400 348.933,266.400 348.400 C 266.400 347.733,266.133 347.600,264.800 347.600 C 263.467 347.600,263.200 347.467,263.200 346.800 C 263.200 346.267,262.933 346.000,262.400 346.000 C 261.956 346.000,261.600 345.733,261.600 345.400 C 261.600 344.967,261.156 344.800,260.000 344.800 C 258.667 344.800,258.400 344.667,258.400 344.000 C 258.400 343.556,258.133 343.200,257.800 343.200 C 257.467 343.200,257.200 342.844,257.200 342.400 C 257.200 341.733,256.933 341.600,255.600 341.600 C 254.267 341.600,254.000 341.467,254.000 340.800 C 254.000 340.267,253.733 340.000,253.200 340.000 C 252.667 340.000,252.400 339.733,252.400 339.200 C 252.400 338.667,252.133 338.400,251.600 338.400 C 251.067 338.400,250.800 338.133,250.800 337.600 C 250.800 336.933,250.533 336.800,249.200 336.800 C 247.867 336.800,247.600 336.667,247.600 336.000 C 247.600 335.467,247.333 335.200,246.800 335.200 C 246.267 335.200,246.000 334.933,246.000 334.400 C 246.000 333.867,245.733 333.600,245.200 333.600 C 244.667 333.600,244.400 333.333,244.400 332.800 C 244.400 331.555,232.441 331.555,232.116 332.800 C 231.920 333.550,231.570 333.600,226.553 333.600 C 221.467 333.600,221.200 333.640,221.200 334.400 C 221.200 335.191,220.933 335.200,198.400 335.200 C 175.867 335.200,175.600 335.191,175.600 334.400 C 175.600 333.640,175.333 333.600,170.200 333.600 C 165.067 333.600,164.800 333.560,164.800 332.800 C 164.800 332.057,164.533 332.000,161.047 332.000 C 157.630 332.000,157.275 331.928,157.084 331.200 C 156.898 330.489,156.538 330.400,153.837 330.400 C 151.404 330.400,150.800 330.281,150.800 329.800 C 150.800 329.317,150.178 329.200,147.600 329.200 C 144.667 329.200,144.400 329.133,144.400 328.400 C 144.400 327.697,144.133 327.600,142.200 327.600 C 140.267 327.600,140.000 327.503,140.000 326.800 C 140.000 326.089,139.733 326.000,137.600 326.000 C 135.467 326.000,135.200 325.911,135.200 325.200 C 135.200 324.489,134.933 324.400,132.800 324.400 C 130.667 324.400,130.400 324.311,130.400 323.600 C 130.400 322.889,130.133 322.800,128.000 322.800 C 125.867 322.800,125.600 322.711,125.600 322.000 C 125.600 321.358,125.333 321.200,124.247 321.200 C 123.230 321.200,122.841 321.001,122.684 320.400 C 122.506 319.720,122.138 319.600,120.237 319.600 C 118.267 319.600,118.000 319.505,118.000 318.800 C 118.000 318.133,117.733 318.000,116.400 318.000 C 115.067 318.000,114.800 317.867,114.800 317.200 C 114.800 316.533,114.533 316.400,113.200 316.400 C 111.867 316.400,111.600 316.267,111.600 315.600 C 111.600 314.933,111.333 314.800,110.000 314.800 C 108.667 314.800,108.400 314.667,108.400 314.000 C 108.400 313.352,108.133 313.200,107.000 313.200 C 106.022 313.200,105.600 313.019,105.600 312.600 C 105.600 312.167,105.156 312.000,104.000 312.000 C 102.667 312.000,102.400 311.867,102.400 311.200 C 102.400 310.667,102.133 310.400,101.600 310.400 C 101.067 310.400,100.800 310.133,100.800 309.600 C 100.800 308.933,100.533 308.800,99.200 308.800 C 97.867 308.800,97.600 308.667,97.600 308.000 C 97.600 307.333,97.333 307.200,96.000 307.200 C 94.667 307.200,94.400 307.067,94.400 306.400 C 94.400 305.867,94.133 305.600,93.600 305.600 C 93.067 305.600,92.800 305.333,92.800 304.800 C 92.800 304.152,92.533 304.000,91.400 304.000 C 90.267 304.000,90.000 303.848,90.000 303.200 C 90.000 302.683,89.733 302.400,89.247 302.400 C 88.830 302.400,88.400 302.043,88.284 301.600 C 88.124 300.987,87.738 300.800,86.637 300.800 C 85.467 300.800,85.200 300.652,85.200 300.000 C 85.200 299.467,84.933 299.200,84.400 299.200 C 83.867 299.200,83.600 298.933,83.600 298.400 C 83.600 297.867,83.333 297.600,82.800 297.600 C 82.267 297.600,82.000 297.333,82.000 296.800 C 82.000 296.133,81.733 296.000,80.400 296.000 C 79.244 296.000,78.800 295.833,78.800 295.400 C 78.800 295.067,78.444 294.800,78.000 294.800 C 77.467 294.800,77.200 294.533,77.200 294.000 C 77.200 293.467,76.933 293.200,76.400 293.200 C 75.867 293.200,75.600 292.933,75.600 292.400 C 75.600 291.956,75.333 291.600,75.000 291.600 C 74.667 291.600,74.400 291.244,74.400 290.800 C 74.400 290.267,74.133 290.000,73.600 290.000 C 73.067 290.000,72.800 289.733,72.800 289.200 C 72.800 288.533,72.533 288.400,71.200 288.400 C 69.867 288.400,69.600 288.267,69.600 287.600 C 69.600 287.067,69.333 286.800,68.800 286.800 C 68.267 286.800,68.000 286.533,68.000 286.000 C 68.000 285.467,67.733 285.200,67.200 285.200 C 66.667 285.200,66.400 284.933,66.400 284.400 C 66.400 283.867,66.133 283.600,65.600 283.600 C 65.067 283.600,64.800 283.333,64.800 282.800 C 64.800 282.267,64.533 282.000,64.000 282.000 C 63.467 282.000,63.200 281.733,63.200 281.200 C 63.200 280.667,62.933 280.400,62.400 280.400 C 61.956 280.400,61.600 280.133,61.600 279.800 C 61.600 279.467,61.244 279.200,60.800 279.200 C 60.267 279.200,60.000 278.933,60.000 278.400 C 60.000 277.867,59.733 277.600,59.200 277.600 C 58.667 277.600,58.400 277.333,58.400 276.800 C 58.400 276.356,58.133 276.000,57.800 276.000 C 57.367 276.000,57.200 275.556,57.200 274.400 C 57.200 273.067,57.067 272.800,56.400 272.800 C 55.867 272.800,55.600 272.533,55.600 272.000 C 55.600 271.467,55.333 271.200,54.800 271.200 C 54.267 271.200,54.000 270.933,54.000 270.400 C 54.000 269.867,53.733 269.600,53.200 269.600 C 52.667 269.600,52.400 269.333,52.400 268.800 C 52.400 268.267,52.133 268.000,51.600 268.000 C 51.067 268.000,50.800 267.733,50.800 267.200 C 50.800 266.667,50.533 266.400,50.000 266.400 C 49.333 266.400,49.200 266.133,49.200 264.800 C 49.200 263.467,49.067 263.200,48.400 263.200 C 47.956 263.200,47.600 262.933,47.600 262.600 C 47.600 262.267,47.244 262.000,46.800 262.000 C 46.267 262.000,46.000 261.733,46.000 261.200 C 46.000 260.667,45.733 260.400,45.200 260.400 C 44.533 260.400,44.400 260.133,44.400 258.800 C 44.400 257.467,44.267 257.200,43.600 257.200 C 43.067 257.200,42.800 256.933,42.800 256.400 C 42.800 255.956,42.533 255.600,42.200 255.600 C 41.778 255.600,41.600 255.174,41.600 254.163 C 41.600 253.062,41.413 252.676,40.800 252.516 C 40.194 252.357,40.000 251.970,40.000 250.916 C 40.000 249.884,39.803 249.474,39.237 249.326 C 38.817 249.216,38.384 248.783,38.274 248.363 C 38.165 247.943,37.788 247.600,37.437 247.600 C 36.976 247.600,36.800 247.214,36.800 246.200 C 36.800 245.067,36.648 244.800,36.000 244.800 C 35.333 244.800,35.200 244.533,35.200 243.200 C 35.200 241.867,35.067 241.600,34.400 241.600 C 33.733 241.600,33.600 241.333,33.600 240.000 C 33.600 238.667,33.467 238.400,32.800 238.400 C 32.133 238.400,32.000 238.133,32.000 236.800 C 32.000 235.467,31.867 235.200,31.200 235.200 C 30.533 235.200,30.400 234.933,30.400 233.600 C 30.400 232.267,30.267 232.000,29.600 232.000 C 28.897 232.000,28.800 231.733,28.800 229.800 C 28.800 227.867,28.703 227.600,28.000 227.600 C 27.333 227.600,27.200 227.333,27.200 226.000 C 27.200 224.667,27.067 224.400,26.400 224.400 C 25.667 224.400,25.600 224.133,25.600 221.200 C 25.600 218.622,25.483 218.000,25.000 218.000 C 24.538 218.000,24.400 217.485,24.400 215.763 C 24.400 213.862,24.280 213.494,23.600 213.316 C 22.891 213.131,22.800 212.770,22.800 210.153 C 22.800 207.467,22.728 207.200,22.000 207.200 C 21.256 207.200,21.200 206.933,21.200 203.363 C 21.200 199.862,21.130 199.507,20.400 199.316 C 19.644 199.118,19.600 198.770,19.600 192.953 C 19.600 187.067,19.565 186.800,18.800 186.800 C 18.021 186.800,18.000 186.533,18.000 176.600 C 18.000 166.667,18.021 166.400,18.800 166.400 C 19.565 166.400,19.600 166.133,19.600 160.247 C 19.600 154.430,19.644 154.082,20.400 153.884 C 21.130 153.693,21.200 153.338,21.200 149.837 C 21.200 146.267,21.256 146.000,22.000 146.000 C 22.728 146.000,22.800 145.733,22.800 143.047 C 22.800 140.430,22.891 140.069,23.600 139.884 C 24.280 139.706,24.400 139.338,24.400 137.437 C 24.400 135.715,24.538 135.200,25.000 135.200 C 25.467 135.200,25.600 134.667,25.600 132.800 C 25.600 130.667,25.689 130.400,26.400 130.400 C 27.111 130.400,27.200 130.133,27.200 128.000 C 27.200 125.867,27.289 125.600,28.000 125.600 C 28.648 125.600,28.800 125.333,28.800 124.200 C 28.800 123.067,28.952 122.800,29.600 122.800 C 30.311 122.800,30.400 122.533,30.400 120.400 C 30.400 118.267,30.489 118.000,31.200 118.000 C 31.867 118.000,32.000 117.733,32.000 116.400 C 32.000 115.067,32.133 114.800,32.800 114.800 C 33.467 114.800,33.600 114.533,33.600 113.200 C 33.600 111.867,33.733 111.600,34.400 111.600 C 35.067 111.600,35.200 111.333,35.200 110.000 C 35.200 108.667,35.333 108.400,36.000 108.400 C 36.642 108.400,36.800 108.133,36.800 107.047 C 36.800 106.030,36.999 105.641,37.600 105.484 C 38.040 105.369,38.400 105.009,38.400 104.684 C 38.400 104.359,38.760 103.999,39.200 103.884 C 39.813 103.724,40.000 103.338,40.000 102.237 C 40.000 101.067,40.148 100.800,40.800 100.800 C 41.333 100.800,41.600 100.533,41.600 100.000 C 41.600 99.556,41.867 99.200,42.200 99.200 C 42.633 99.200,42.800 98.756,42.800 97.600 C 42.800 96.267,42.933 96.000,43.600 96.000 C 44.133 96.000,44.400 95.733,44.400 95.200 C 44.400 94.667,44.667 94.400,45.200 94.400 C 45.848 94.400,46.000 94.133,46.000 93.000 C 46.000 91.867,46.152 91.600,46.800 91.600 C 47.333 91.600,47.600 91.333,47.600 90.800 C 47.600 90.267,47.867 90.000,48.400 90.000 C 48.917 90.000,49.200 89.733,49.200 89.247 C 49.200 88.830,49.557 88.400,50.000 88.284 C 50.613 88.124,50.800 87.738,50.800 86.637 C 50.800 85.467,50.948 85.200,51.600 85.200 C 52.133 85.200,52.400 84.933,52.400 84.400 C 52.400 83.867,52.667 83.600,53.200 83.600 C 53.733 83.600,54.000 83.333,54.000 82.800 C 54.000 82.267,54.267 82.000,54.800 82.000 C 55.333 82.000,55.600 81.733,55.600 81.200 C 55.600 80.667,55.867 80.400,56.400 80.400 C 56.933 80.400,57.200 80.133,57.200 79.600 C 57.200 79.156,57.467 78.800,57.800 78.800 C 58.233 78.800,58.400 78.356,58.400 77.200 C 58.400 75.867,58.533 75.600,59.200 75.600 C 59.644 75.600,60.000 75.333,60.000 75.000 C 60.000 74.667,60.356 74.400,60.800 74.400 C 61.333 74.400,61.600 74.133,61.600 73.600 C 61.600 73.067,61.867 72.800,62.400 72.800 C 62.933 72.800,63.200 72.533,63.200 72.000 C 63.200 71.467,63.467 71.200,64.000 71.200 C 64.533 71.200,64.800 70.933,64.800 70.400 C 64.800 69.867,65.067 69.600,65.600 69.600 C 66.133 69.600,66.400 69.333,66.400 68.800 C 66.400 68.133,66.667 68.000,68.000 68.000 C 69.333 68.000,69.600 67.867,69.600 67.200 C 69.600 66.667,69.867 66.400,70.400 66.400 C 70.933 66.400,71.200 66.133,71.200 65.600 C 71.200 65.067,71.467 64.800,72.000 64.800 C 72.533 64.800,72.800 64.533,72.800 64.000 C 72.800 63.467,73.067 63.200,73.600 63.200 C 74.133 63.200,74.400 62.933,74.400 62.400 C 74.400 61.956,74.667 61.600,75.000 61.600 C 75.333 61.600,75.600 61.244,75.600 60.800 C 75.600 60.267,75.867 60.000,76.400 60.000 C 76.933 60.000,77.200 59.733,77.200 59.200 C 77.200 58.533,77.467 58.400,78.800 58.400 C 79.956 58.400,80.400 58.233,80.400 57.800 C 80.400 57.467,80.756 57.200,81.200 57.200 C 81.733 57.200,82.000 56.933,82.000 56.400 C 82.000 55.867,82.267 55.600,82.800 55.600 C 83.333 55.600,83.600 55.333,83.600 54.800 C 83.600 54.133,83.867 54.000,85.200 54.000 C 86.533 54.000,86.800 53.867,86.800 53.200 C 86.800 52.667,87.067 52.400,87.600 52.400 C 88.133 52.400,88.400 52.133,88.400 51.600 C 88.400 50.948,88.667 50.800,89.837 50.800 C 90.938 50.800,91.324 50.613,91.484 50.000 C 91.599 49.560,91.942 49.200,92.247 49.200 C 92.551 49.200,92.800 48.840,92.800 48.400 C 92.800 47.733,93.067 47.600,94.400 47.600 C 95.733 47.600,96.000 47.467,96.000 46.800 C 96.000 46.267,96.267 46.000,96.800 46.000 C 97.333 46.000,97.600 45.733,97.600 45.200 C 97.600 44.533,97.867 44.400,99.200 44.400 C 100.533 44.400,100.800 44.267,100.800 43.600 C 100.800 42.933,101.067 42.800,102.400 42.800 C 103.556 42.800,104.000 42.633,104.000 42.200 C 104.000 41.778,104.426 41.600,105.437 41.600 C 106.538 41.600,106.924 41.413,107.084 40.800 C 107.241 40.199,107.630 40.000,108.647 40.000 C 109.733 40.000,110.000 39.842,110.000 39.200 C 110.000 38.533,110.267 38.400,111.600 38.400 C 112.933 38.400,113.200 38.267,113.200 37.600 C 113.200 36.933,113.467 36.800,114.800 36.800 C 116.133 36.800,116.400 36.667,116.400 36.000 C 116.400 35.333,116.667 35.200,118.000 35.200 C 119.333 35.200,119.600 35.067,119.600 34.400 C 119.600 33.733,119.867 33.600,121.200 33.600 C 122.533 33.600,122.800 33.467,122.800 32.800 C 122.800 32.097,123.067 32.000,125.000 32.000 C 126.933 32.000,127.200 31.903,127.200 31.200 C 127.200 30.533,127.467 30.400,128.800 30.400 C 130.133 30.400,130.400 30.267,130.400 29.600 C 130.400 28.889,130.667 28.800,132.800 28.800 C 134.933 28.800,135.200 28.711,135.200 28.000 C 135.200 27.289,135.467 27.200,137.600 27.200 C 139.733 27.200,140.000 27.111,140.000 26.400 C 140.000 25.671,140.267 25.600,143.000 25.600 C 145.400 25.600,146.000 25.480,146.000 25.000 C 146.000 24.519,146.604 24.400,149.037 24.400 C 151.738 24.400,152.098 24.311,152.284 23.600 C 152.469 22.891,152.830 22.800,155.447 22.800 C 158.133 22.800,158.400 22.728,158.400 22.000 C 158.400 21.253,158.667 21.200,162.400 21.200 C 166.133 21.200,166.400 21.147,166.400 20.400 C 166.400 19.634,166.667 19.600,172.600 19.600 C 178.533 19.600,178.800 19.566,178.800 18.800 C 178.800 18.010,179.067 18.000,199.200 18.000 C 219.333 18.000,219.600 18.010,219.600 18.800 M124.400 156.237 C 124.400 189.338,124.408 189.677,125.200 189.884 C 125.956 190.082,126.000 190.430,126.000 196.247 C 126.000 202.133,126.035 202.400,126.800 202.400 C 127.544 202.400,127.600 202.667,127.600 206.200 C 127.600 209.733,127.656 210.000,128.400 210.000 C 129.133 210.000,129.200 210.267,129.200 213.200 C 129.200 215.778,129.317 216.400,129.800 216.400 C 130.222 216.400,130.400 216.826,130.400 217.837 C 130.400 218.938,130.587 219.324,131.200 219.484 C 131.877 219.661,132.000 220.030,132.000 221.884 C 132.000 223.738,132.123 224.107,132.800 224.284 C 133.401 224.441,133.600 224.830,133.600 225.847 C 133.600 226.933,133.758 227.200,134.400 227.200 C 134.933 227.200,135.200 227.467,135.200 228.000 C 135.200 228.533,135.467 228.800,136.000 228.800 C 136.667 228.800,136.800 229.067,136.800 230.400 C 136.800 231.733,136.933 232.000,137.600 232.000 C 138.267 232.000,138.400 232.267,138.400 233.600 C 138.400 234.933,138.533 235.200,139.200 235.200 C 139.733 235.200,140.000 235.467,140.000 236.000 C 140.000 236.533,140.267 236.800,140.800 236.800 C 141.452 236.800,141.600 237.067,141.600 238.237 C 141.600 239.315,141.791 239.725,142.363 239.874 C 142.783 239.984,143.216 240.417,143.326 240.837 C 143.435 241.257,143.812 241.600,144.163 241.600 C 144.513 241.600,144.800 241.870,144.800 242.200 C 144.800 242.530,145.070 242.800,145.400 242.800 C 145.733 242.800,146.000 243.156,146.000 243.600 C 146.000 244.133,146.267 244.400,146.800 244.400 C 147.333 244.400,147.600 244.667,147.600 245.200 C 147.600 245.717,147.867 246.000,148.353 246.000 C 148.770 246.000,149.200 246.357,149.316 246.800 C 149.431 247.240,149.812 247.600,150.163 247.600 C 150.533 247.600,150.800 247.935,150.800 248.400 C 150.800 248.917,151.067 249.200,151.553 249.200 C 151.970 249.200,152.400 249.557,152.516 250.000 C 152.676 250.613,153.062 250.800,154.163 250.800 C 155.333 250.800,155.600 250.948,155.600 251.600 C 155.600 252.133,155.867 252.400,156.400 252.400 C 156.933 252.400,157.200 252.667,157.200 253.200 C 157.200 253.867,157.467 254.000,158.800 254.000 C 160.133 254.000,160.400 254.133,160.400 254.800 C 160.400 255.317,160.667 255.600,161.153 255.600 C 161.570 255.600,162.000 255.957,162.116 256.400 C 162.291 257.068,162.662 257.200,164.363 257.200 C 165.907 257.200,166.400 257.345,166.400 257.800 C 166.400 258.233,166.844 258.400,168.000 258.400 C 169.333 258.400,169.600 258.533,169.600 259.200 C 169.600 259.944,169.867 260.000,173.400 260.000 L 177.200 260.000 177.200 246.800 L 177.200 233.600 175.847 233.600 C 174.830 233.600,174.441 233.401,174.284 232.800 C 174.125 232.194,173.738 232.000,172.684 232.000 C 171.630 232.000,171.243 231.806,171.084 231.200 C 170.969 230.760,170.588 230.400,170.237 230.400 C 169.887 230.400,169.600 230.130,169.600 229.800 C 169.600 229.467,169.244 229.200,168.800 229.200 C 168.267 229.200,168.000 228.933,168.000 228.400 C 168.000 227.867,167.733 227.600,167.200 227.600 C 166.667 227.600,166.400 227.333,166.400 226.800 C 166.400 226.267,166.133 226.000,165.600 226.000 C 165.067 226.000,164.800 225.733,164.800 225.200 C 164.800 224.667,164.533 224.400,164.000 224.400 C 163.467 224.400,163.200 224.133,163.200 223.600 C 163.200 223.067,162.933 222.800,162.400 222.800 C 161.733 222.800,161.600 222.533,161.600 221.200 C 161.600 219.867,161.467 219.600,160.800 219.600 C 160.267 219.600,160.000 219.333,160.000 218.800 C 160.000 218.267,159.733 218.000,159.200 218.000 C 158.533 218.000,158.400 217.733,158.400 216.400 C 158.400 215.244,158.233 214.800,157.800 214.800 C 157.345 214.800,157.200 214.307,157.200 212.763 C 157.200 211.062,157.068 210.691,156.400 210.516 C 155.773 210.352,155.600 209.970,155.600 208.753 C 155.600 207.467,155.463 207.200,154.800 207.200 C 154.070 207.200,154.000 206.933,154.000 204.163 C 154.000 201.462,153.911 201.102,153.200 200.916 C 152.459 200.722,152.400 200.370,152.400 196.153 C 152.400 191.867,152.353 191.600,151.600 191.600 C 150.867 191.600,150.800 191.333,150.800 188.406 L 150.800 185.212 162.500 185.106 L 174.200 185.000 174.302 153.900 L 174.405 122.800 149.402 122.800 L 124.400 122.800 124.400 156.237 M210.400 157.800 C 210.400 192.533,210.406 192.800,211.200 192.800 C 211.962 192.800,212.000 193.067,212.000 198.400 C 212.000 203.111,212.095 204.000,212.600 204.000 C 213.089 204.000,213.200 204.671,213.200 207.637 C 213.200 210.938,213.274 211.294,214.000 211.484 C 214.677 211.661,214.800 212.030,214.800 213.884 C 214.800 215.738,214.923 216.107,215.600 216.284 C 216.277 216.461,216.400 216.830,216.400 218.684 C 216.400 220.538,216.523 220.907,217.200 221.084 C 217.806 221.243,218.000 221.630,218.000 222.684 C 218.000 223.738,218.194 224.125,218.800 224.284 C 219.401 224.441,219.600 224.830,219.600 225.847 C 219.600 226.933,219.758 227.200,220.400 227.200 C 221.067 227.200,221.200 227.467,221.200 228.800 C 221.200 230.133,221.333 230.400,222.000 230.400 C 222.533 230.400,222.800 230.667,222.800 231.200 C 222.800 231.733,223.067 232.000,223.600 232.000 C 224.267 232.000,224.400 232.267,224.400 233.600 C 224.400 234.933,224.533 235.200,225.200 235.200 C 225.733 235.200,226.000 235.467,226.000 236.000 C 226.000 236.533,226.267 236.800,226.800 236.800 C 227.452 236.800,227.600 237.067,227.600 238.237 C 227.600 239.338,227.787 239.724,228.400 239.884 C 228.843 240.000,229.200 240.430,229.200 240.847 C 229.200 241.261,229.470 241.600,229.800 241.600 C 230.130 241.600,230.400 241.870,230.400 242.200 C 230.400 242.533,230.756 242.800,231.200 242.800 C 231.733 242.800,232.000 243.067,232.000 243.600 C 232.000 244.133,232.267 244.400,232.800 244.400 C 233.333 244.400,233.600 244.667,233.600 245.200 C 233.600 245.733,233.867 246.000,234.400 246.000 C 234.933 246.000,235.200 246.267,235.200 246.800 C 235.200 247.333,235.467 247.600,236.000 247.600 C 236.533 247.600,236.800 247.867,236.800 248.400 C 236.800 248.933,237.067 249.200,237.600 249.200 C 238.133 249.200,238.400 249.467,238.400 250.000 C 238.400 250.533,238.667 250.800,239.200 250.800 C 239.733 250.800,240.000 251.067,240.000 251.600 C 240.000 252.267,240.267 252.400,241.600 252.400 C 242.933 252.400,243.200 252.533,243.200 253.200 C 243.200 253.717,243.467 254.000,243.953 254.000 C 244.370 254.000,244.800 254.357,244.916 254.800 C 245.066 255.374,245.462 255.600,246.316 255.600 C 247.170 255.600,247.566 255.826,247.716 256.400 C 247.876 257.013,248.262 257.200,249.363 257.200 C 250.374 257.200,250.800 257.378,250.800 257.800 C 250.800 258.267,251.333 258.400,253.200 258.400 C 255.333 258.400,255.600 258.489,255.600 259.200 C 255.600 259.944,255.867 260.000,259.400 260.000 L 263.200 260.000 263.200 246.800 L 263.200 233.600 261.600 233.600 C 260.267 233.600,260.000 233.467,260.000 232.800 C 260.000 232.158,259.733 232.000,258.647 232.000 C 257.630 232.000,257.241 231.801,257.084 231.200 C 256.969 230.760,256.588 230.400,256.237 230.400 C 255.887 230.400,255.600 230.130,255.600 229.800 C 255.600 229.467,255.244 229.200,254.800 229.200 C 254.267 229.200,254.000 228.933,254.000 228.400 C 254.000 227.867,253.733 227.600,253.200 227.600 C 252.667 227.600,252.400 227.333,252.400 226.800 C 252.400 226.267,252.133 226.000,251.600 226.000 C 251.067 226.000,250.800 225.733,250.800 225.200 C 250.800 224.667,250.533 224.400,250.000 224.400 C 249.467 224.400,249.200 224.133,249.200 223.600 C 249.200 223.067,248.933 222.800,248.400 222.800 C 247.867 222.800,247.600 222.533,247.600 222.000 C 247.600 221.467,247.333 221.200,246.800 221.200 C 246.133 221.200,246.000 220.933,246.000 219.600 C 246.000 218.267,245.867 218.000,245.200 218.000 C 244.533 218.000,244.400 217.733,244.400 216.400 C 244.400 215.067,244.267 214.800,243.600 214.800 C 242.952 214.800,242.800 214.533,242.800 213.400 C 242.800 212.422,242.619 212.000,242.200 212.000 C 241.733 212.000,241.600 211.467,241.600 209.600 C 241.600 207.467,241.511 207.200,240.800 207.200 C 240.095 207.200,240.000 206.933,240.000 204.963 C 240.000 203.062,239.880 202.694,239.200 202.516 C 238.472 202.325,238.400 201.970,238.400 198.553 C 238.400 195.067,238.343 194.800,237.600 194.800 C 236.844 194.800,236.800 194.533,236.800 190.000 L 236.800 185.200 248.400 185.200 L 260.000 185.200 260.000 154.000 L 260.000 122.800 235.200 122.800 L 210.400 122.800 210.400 157.800 " stroke="none" fill="#5c5c5c" fill-rule="evenodd"></path><path id="path1" d="" stroke="none" fill="#605c5c" fill-rule="evenodd"></path><path id="path2" d="" stroke="none" fill="#605c5c" fill-rule="evenodd"></path><path id="path3" d="" stroke="none" fill="#605c5c" fill-rule="evenodd"></path><path id="path4" d="" stroke="none" fill="#605c5c" fill-rule="evenodd"></path></g></svg>
                                    Tagline
                                </h4>
                                <p class="inner-dis" dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{business_info_data.business_tagline}}" dd-text-collapse-cond="true"><span class="box-dis">{{business_info_data.business_tagline}}</span>
                                </p>
                            </div>
                            <div class="dash-info-box" ng-if="business_info_data.business_year_found">
                                <h4> 
                                    <svg viewBox="0 0 60 60" width="17px" height="17px" stroke-width="0.5" stroke="#5c5c5c"> 
                                    <path d="M51.371,3.146c-0.459-0.185-11.359-4.452-19.84,0.045C24.811,6.758,13.015,4.082,10,3.308V1c0-0.553-0.447-1-1-1  S8,0.447,8,1v3c0,0.014,0.007,0.026,0.008,0.04C8.008,4.052,8,4.062,8,4.074V33v1.074V59c0,0.553,0.447,1,1,1s1-0.447,1-1V35.375  c2.273,0.567,7.227,1.632,12.368,1.632c3.557,0,7.2-0.511,10.101-2.049c7.652-4.061,18.056,0.004,18.16,0.045  c0.309,0.124,0.657,0.086,0.932-0.102C51.835,34.716,52,34.406,52,34.074v-30C52,3.665,51.751,3.298,51.371,3.146z M50,32.665  c-3.26-1.038-11.646-3.096-18.469,0.525C24.812,36.756,13.02,34.082,10,33.308V33V5.375c3.853,0.961,15.381,3.343,22.469-0.417  C39.035,1.475,47.627,3.973,50,4.777V32.665z" fill="#5c5c5c"/>
                                    </svg>
                                Year Founded</h4>
                                <p>{{business_info_data.business_year_found}}</p>
                            </div>
                            <div class="dash-info-box" ng-if="business_info_data.business_ext_benifit">
                                <h4>
                                    <svg viewBox="0 0 487.222 487.222" width="17px" height="16px">
                                        <g>
                                            <path d="M486.554,186.811c-1.6-4.9-5.8-8.4-10.9-9.2l-152-21.6l-68.4-137.5c-2.3-4.6-7-7.5-12.1-7.5l0,0c-5.1,0-9.8,2.9-12.1,7.6   l-67.5,137.9l-152,22.6c-5.1,0.8-9.3,4.3-10.9,9.2s-0.2,10.3,3.5,13.8l110.3,106.9l-25.5,151.4c-0.9,5.1,1.2,10.2,5.4,13.2   c2.3,1.7,5.1,2.6,7.9,2.6c2.2,0,4.3-0.5,6.3-1.6l135.7-71.9l136.1,71.1c2,1,4.1,1.5,6.2,1.5l0,0c7.4,0,13.5-6.1,13.5-13.5   c0-1.1-0.1-2.1-0.4-3.1l-26.3-150.5l109.6-107.5C486.854,197.111,488.154,191.711,486.554,186.811z M349.554,293.911   c-3.2,3.1-4.6,7.6-3.8,12l22.9,131.3l-118.2-61.7c-3.9-2.1-8.6-2-12.6,0l-117.8,62.4l22.1-131.5c0.7-4.4-0.7-8.8-3.9-11.9   l-95.6-92.8l131.9-19.6c4.4-0.7,8.2-3.4,10.1-7.4l58.6-119.7l59.4,119.4c2,4,5.8,6.7,10.2,7.4l132,18.8L349.554,293.911z" fill="#5c5c5c"/>
                                        </g>
                                    </svg>
                                Specialties </h4>
                                <ul class="skill-list">
                                    <li ng-repeat="benefits in business_info_data.business_ext_benifit.split(',')">{{benefits}}</li>
                                </ul>
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
