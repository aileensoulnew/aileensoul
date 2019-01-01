<?php
$s3 = new S3(awsAccessKey, awsSecretKey);
$userid = $this->session->userdata('aileenuser');
$fullname = ucwords($artisticdata[0]['art_name']." ".$artisticdata[0]['art_lastname']);
?>
<!DOCTYPE html>
<html lang="en" ng-app="artistDashboardApp" ng-controller="artistDashboardController">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
         
        <?php echo $head; ?>  

             <?php
        if (IS_ART_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver='.time()); ?>"> 
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
           
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />  
            <?php }else{?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver='.time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/artistic.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />  
            <?php }?>    
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
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

            .art-all-comment{display: none;}
        </style>
        
    <?php $this->load->view('adsense');
    $cls = "";
    if($userid == "")
    {
        $cls = "old-no-login";
    } ?>
</head>
    <body class="page-container-bg-solid page-boxed pushmenu-push body-loader <?php echo $cls; ?>">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
        <?php if($this->session->userdata('aileenuser')){ 
            echo $artistic_header2;
        }else{ ?>
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
										<li class="hidden-991"><a href="<?php echo base_url(); ?>artist-profile/create-account" class="btn3">Create Artistic Account</a></li>
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
        <?php } ?>
        <section>
			<?php if(!$this->session->userdata('aileenuser')){  ?>
				<div class="no-login-padding">
					<div class="ld-sub-header detail-sub-header">
						<div class="container">
							<div class="web-ld-sub">
								<ul class="">
									<li><a href="<?php echo base_url('find-artist'); ?>">Artist Profile</a></li>
									<li><a href="<?php echo base_url('artist/category'); ?>">Artists by Category</a></li>
									<li><a href="<?php echo base_url('artist/location'); ?>">Artists by Location</a></li>
									<li><a href="<?php echo base_url('how-to-use-artistic-profile-in-aileensoul'); ?>">How Artistic Profile Works</a></li>
									<li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
								</ul>
							</div>
							<div class="mob-ld-sub">
								<ul class="">
									<li class="tab-first-li">
										<a href="javascript:void(0);">Artists</a>
										<ul>
											<li><a href="<?php echo base_url('find-artist'); ?>">Artist Profile</a></li>
											<li><a href="<?php echo base_url('artist/category'); ?>">Artists by Category</a></li>
											<li><a href="<?php echo base_url('artist/location'); ?>">Artists by Location</a></li>
											<li><a href="<?php echo base_url('how-to-use-artistic-profile-in-aileensoul'); ?>">How Artistic Profile Works</a></li>
											<li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
										</ul>
										
									</li>
									<li><a href="<?php echo base_url('login'); ?>">Login</a></li>
									<li><a href="<?php echo base_url('artist-profile/create-account'); ?>"><span class="hidden-479">Create Artistic Profile</span><span class="visible-479">Sign Up</span></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php }  ?>
		
            <?php echo $artistic_common_profile; ?>
            <div class="text-center tab-block">
                <div class="container mob-inner-page">
                    <a href="javascript:void(0);" onclick="login_profile();" title="Photo">
                        Photo
                    </a>
                    <a href="javascript:void(0);" onclick="login_profile();" title="Video">
                        Video
                    </a>
                    <a href="javascript:void(0);" onclick="login_profile();" title="Audio">
                        Audio
                    </a>
                    <a href="javascript:void(0);" onclick="login_profile();" title="Pdf">
                        PDf
                    </a>
                </div>
            </div>

            <div class="user-midd-section">
                <div class="container mobp0">
                    <div class="">
                    <div class="profile-box-custom left_side_posrt">
                        <div class="full-box-module business_data">
                            <div class="profile-boxProfileCard  module">
                                <div class="head_details1">
                                    <span><a href="javascript:void(0);" onclick="login_profile();" title="Information"><h5><i class="fa fa-info-circle" aria-hidden="true"></i>Information</h5></a>
                                    </span>      
                                </div>
                                <table class="business_data_table">
                                    <tr>
                                        <td class="business_data_td1"><i class="fa fa-trophy" aria-hidden="true"></i></td>
                                        <td class="business_data_td2">
                                            {{artist_basic_info.art_category_txt}}
                                            <?php
                                            /*$art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $artisticdata[0]['other_skill']))->row()->other_category;
                                            $category = $artisticdata[0]['art_skill'];
                                            $category = explode(',' , $category);
                                            $category_txt = "";
                                            foreach ($category as $catkey => $catval) {
                                                $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                                $categorylist[] = ucwords($art_category);
                                                $category_txt .= ucwords($art_category).",";
                                            } 
                                            $listfinal1 = array_diff($categorylist, array('Other'));
                                            $listFinal = implode(',', $listfinal1);

                                            if(!in_array(26, $category)){
                                                echo $listFinal;
                                            }else if($artisticdata[0]['art_skill'] && $artisticdata[0]['other_skill']){
                                                $trimdata = $listFinal .','.ucwords($art_othercategory);
                                                echo trim($trimdata, ',');
                                            }
                                            else{
                                                echo ucwords($art_othercategory);  
                                            }*/
                                            ?>   
                                        </td>
                                    </tr>
                                    <?php /*if($artisticdata[0]['art_yourart']){?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-lightbulb-o" aria-hidden="true"></i></td>
                                        <td class="business_data_td2"><span><?php echo $artisticdata[0]['art_yourart']; ?></span></td>
                                    </tr>
                                    <?php }
                                    if($artisticdata[0]['art_desc_art']){?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-file-text" aria-hidden="true"></i></td>
                                        <td class="business_data_td2"><span><?php echo $this->common->make_links($artisticdata[0]['art_desc_art']); ?></span></td>
                                    </tr>
                                    <?php }
                                    if($userid != ""){?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-envelope" aria-hidden="true"></i></td>
                                        <td class="business_data_td2">
                                            <a href="mailto:<?php echo $artisticdata[0]['art_email']; ?>" title="<?php echo $artisticdata[0]['art_email']; ?>"><?php echo $artisticdata[0]['art_email']; ?></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="business_data_td1  detaile_map" ><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                                        <td class="business_data_td2">
                                            <span>
                                            <?php
                                            if ($artisticdata[0]['art_city']) {
                                                echo $city_txt = $this->db->select('city_name')->select('city_name')->get_where('cities', array('city_id' => $artisticdata[0]['art_city']))->row()->city_name;
                                                echo",";
                                            }
                                            ?> 
                                            <?php
                                            if ($artisticdata[0]['art_country']) {
                                                echo $this->db->select('country_name')->select('country_name')->get_where('countries', array('country_id' => $artisticdata[0]['art_country']))->row()->country_name;
                                            }
                                            ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php */ ?>
                                </table>
                            </div>
                        </div>
                        <div class="left-info-box">
                            <div class="dash-info-box" ng-if="user_bio != ''">
                                <h4>Bio</h4>
                                <p dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{user_bio}}" dd-text-collapse-cond="true">{{user_bio}}</p>
                            </div>                            
                            <div class="dash-info-box">
                                <h4>Location </h4>                              
                                <p ng-if="artist_basic_info.country_name || artist_basic_info.state_name || artist_basic_info.city_name">
                                    {{artist_basic_info.city_name != '' ? artist_basic_info.city_name : ''}}
                                    {{artist_basic_info.city_name != '' && artist_basic_info.state_name != '' ? ',' : ''}}
                                    {{artist_basic_info.state_name != '' ? artist_basic_info.state_name : ''}}
                                    {{artist_basic_info.state_name != '' && artist_basic_info.country_name != '' ? ',' : ''}}
                                    {{artist_basic_info.country_name != '' ? artist_basic_info.country_name : ''}}
                                </p>
                            </div>
                            <div class="dash-info-box" ng-if="art_talent_cat">
                                <h4>Type of Talent</h4>
                                <ul class="skill-list">
                                    <li ng-repeat="tal_cat in art_talent_cat.split(',')">{{tal_cat}}</li>
                                </ul>
                            </div>
                            <div class="dash-info-box" ng-if="art_speciality_data.art_spl_tags || art_speciality_data.art_spl_desc">
                                <h4>Specialities</h4>
                                <ul class="skill-list" ng-if="art_speciality_data.art_spl_tags != ''">
                                    <li ng-repeat="speciality in art_speciality_data.art_spl_tags.split(',')">{{speciality}}</li>
                                </ul>
                                <p ng-if="art_speciality_data.art_spl_desc != ''" dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{art_speciality_data.art_spl_desc}}" dd-text-collapse-cond="true">{{art_speciality_data.art_spl_desc}}</p>
                            </div>
                            <div class="dash-info-box" ng-if="art_imp_data  == '1' || art_imp_data  == '2' || art_imp_data  == '3'">
                                <h4>Availability </h4>
                                <p ng-if="art_imp_data == '1'">Open for work</p>
                                <p ng-if="art_imp_data == '2'">Open for Collaboration</p>
                                <p ng-if="art_imp_data == '3'">Not now</p>
                            </div>
                            <div class="dash-info-box" ng-if="user_experience.length > '0'">
                                <h4>Experience </h4>
                                <ul>
                                    <li ng-repeat="user_exp in user_experience">{{user_exp.designation}} at {{user_exp.exp_company_name}}</li>
                                </ul>
                            </div>
                            <div class="dash-info-box" ng-if="user_award.length > '0'">
                                <h4>Achievements & Awards </h4>
                                <ul>
                                    <li ng-repeat="_user_award in user_award">{{_user_award.award_title}} ({{_user_award.award_date | limitTo:4}})</li>
                                </ul>
                            </div>
                        </div>
                        <!-- user iamges start-->
                        <a href="javascript:void(0);" onclick="login_profile();" title="Photos">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module buisness_he_module" >
                                    <div class="head_details">
                                        <h5><i class="fa fa-camera" aria-hidden="true"></i>   Photos</h5>
                                    </div>
                                   <div class="art_photos">
                                      <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                  </div>
                                </div>
                            </div>
                        </a>
                        <!-- user images end-->
                        <!-- user video start-->
                        <a href="javascript:void(0);" onclick="login_profile();" title="Video">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module">
                                    <table class="business_data_table">
                                        <div class="head_details">
                                            <h5><i class="fa fa-video-camera" aria-hidden="true"></i>Video</h5>
                                        </div>
                                        <div class="art_videos">
                                        <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </a>
                        <!-- user video emd-->
                        <!-- user audio start-->
                        <a href="javascript:void(0);" onclick="login_profile();" title="Audio">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module">
                                    <div class="head_details1">
                                        <h5><i class="fa fa-music" aria-hidden="true"></i>Audio</h5>
                                    </div>
                                    <table class="business_data_table">
                                        <div class="art_audios">
                                        <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                       </div>
                                    </table>
                                </div>
                            </div>
                        </a>
                        <!-- user audio end-->
                        <!-- user pdf  start-->
                        <a href="javascript:void(0);" onclick="login_profile();" title="Pdf">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module buisness_he_module" >
                                    <div class="head_details">
                                        <h5><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  PDF</h5>
                                    </div>      
                                    <div class="art_pdf">
                                      <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                   </div>
                                </div>
                            </div>
                        </a>
						<?php $this->load->view('right_add_box'); ?>
                        <?php echo $left_footer_list_view; ?>
                        <!-- user pdf  end-->
                    </div>
					<div class="full-box-module business_data mob-detail-custom tab-mb15">
                            <div class="profile-boxProfileCard  module">
                                
                                <table class="business_data_table">
                                    <tr>
                                        <td class="business_data_td1"><i class="fa fa-trophy" aria-hidden="true"></i></td>
                                        <td class="business_data_td2">
                                            <?php
                                   
                                    $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $artisticdata[0]['other_skill']))->row()->other_category;

                                    $category = $artisticdata[0]['art_skill'];
                                    $category = explode(',' , $category);

                                    foreach ($category as $catkey => $catval) {
                                       $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                                       $categorylist[] = ucwords($art_category);
                                     } 

                                    $listfinal1 = array_diff($categorylist, array('Other'));
                                    $listFinal = implode(',', $listfinal1);
                                       
                                    if(!in_array(26, $category)){
                                     echo $listFinal;
                                   }else if($artisticdata[0]['art_skill'] && $artisticdata[0]['other_skill']){

                                    $trimdata = $listFinal .','.ucwords($art_othercategory);
                                    echo trim($trimdata, ',');
                                   }
                                   else{
                                     echo ucwords($art_othercategory);  
                                  }
                                    ?>   
                                </td>
                                </tr>
                                 <?php if($artisticdata[0]['art_yourart']){?>
                                <tr>
                                <td class="business_data_td1 detaile_map"><i class="fa fa-lightbulb-o" aria-hidden="true"></i></td>
                                <td class="business_data_td2"><span><?php echo $artisticdata[0]['art_yourart']; ?></span></td>
                               </tr>
                               <?php }?>

                                    <?php if($artisticdata[0]['art_desc_art']){?>
                            <tr>
                                <td class="business_data_td1 detaile_map"><i class="fa fa-file-text" aria-hidden="true"></i></td>
                                <td class="business_data_td2"><span><?php echo $this->common->make_links($artisticdata[0]['art_desc_art']); ?></span></td>
                            </tr>
                            <?php }
                            if($userid != ""){?>
                                     <tr>
                                <td class="business_data_td1 detaile_map"><i class="fa fa-envelope" aria-hidden="true"></i></td>
                                <td class="business_data_td2">
                                    <a href="mailto:<?php echo $artisticdata[0]['art_email']; ?>" title="<?php echo $artisticdata[0]['art_email']; ?>"><?php echo $artisticdata[0]['art_email']; ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                            <tr>
                                <td class="business_data_td1  detaile_map" ><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                                <td class="business_data_td2"><span>
                                        <?php
                                        if ($artisticdata[0]['art_city']) {
                                            echo $this->db->select('city_name')->select('city_name')->get_where('cities', array('city_id' => $artisticdata[0]['art_city']))->row()->city_name;
                                            echo",";
                                        }
                                        ?> 
                                        <?php
                                        if ($artisticdata[0]['art_country']) {
                                            echo $this->db->select('country_name')->select('country_name')->get_where('countries', array('country_id' => $artisticdata[0]['art_country']))->row()->country_name;
                                        }
                                        ?>
                                    </span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
						
					<div class="tab-add">
						<?php $this->load->view('banner_add'); ?>
					</div>
                      <div class="custom-right-art mian_middle_post_box animated fadeInUp custom-right-business">
                            <div class="art-all-post">
                            </div>
                            <div class="fw" id="loader-post" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
							<div class="banner-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                        </div>
						<div id="hideuserlist" class="right_middle_side_posrt">
							<?php $this->load->view('right_add_box'); ?>
                            <div class="right-info-box" ng-if="user_social_links.length > '0' || user_personal_links.length > '0'">
                                <div class="dtl-title">
                                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/website.png"><span>Website</span>
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
                                        <h4 class="pt20">Personal</h4>
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
						</div>
					</div>
                </div>
            </div>
        </section>
        
        <!-- Bid-modal  -->
        <div class="modal message-box biderror" id="errorrmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content pop-content-cus'>
                                <h2>Never miss out any opportunities, news, and updates.</h2>Join Now! <p class='poppup-btns'><a class='btn1' href='<?php echo base_url(); ?>login'>Login</a> or <a class='btn1' href='<?php echo base_url(); ?>artist-profile/create-account'>Register</a></p>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
</div>
<?php //$this->load->view('mobile_side_slide'); ?>
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
        <!-- POST BOX JAVASCRIPT END --> 

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>

        <script>
            var base_url = '<?php echo base_url(); ?>';
            var slug = '<?php echo $artid; ?>';
            var site_url = '<?php echo $get_url; ?>';
            var userid = "<?php echo $userid; ?>";            
            var user_slug = '<?php echo $get_url; ?>';
            var app = angular.module("artistDashboardApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/dashboard_new.js?ver='.time()); ?>"></script>
        <!-- script for login  user valoidtaion start -->
        <script>
            function login_profile() {
               if(userid != ""){
                $('#register').modal('show');
               }
               else
               {                
                $('#errorrmodal').modal('show');
               }
                $('body').addClass('modal-open'); 

            }
            function login_data() { 
                if(userid != ""){
                    $('#login').modal('show');
                    $('#register').modal('hide');
                }
                else
                {
                    $('#errorrmodal').modal('hide');
                }
                $('body').addClass('modal-open'); 

            }
            function register_profile() {
                if(userid != ""){
                    $('#login').modal('hide');
                    $('#register').modal('show');
                }
                else
                {                    
                    $('#errorrmodal').modal('show');
                }
            }
            function forgot_profile() {
                if(userid != ""){
                    $('#forgotPassword').modal('show');
                    $('#register').modal('hide');
                    $('#login').modal('hide');
                }
                else
                {                    
                    $('#errorrmodal').modal('hide');
                }
                $('body').addClass('modal-open-other');   

            }

            $('.modal-close').click(function(e){
                $('body').removeClass('modal-open-other');
            });
        </script>
        <script type="text/javascript">
            $( document ).on( 'keydown', function ( e ) {
                if ( e.keyCode === 27 ) {
                    $('#register').modal('hide');
                    $('#login').modal('hide');
                    $('#forgotPassword').modal('hide');
                }
            });
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/user_dashboard.js?ver=' . time()); ?>"></script>
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
                if(typeof session_userid === 'undefined'){
                    setTimeout(function () {
                        // $('#register').modal('show');
                    }, 2000);
                }
            });
            var session_userid = "<?php echo $this->session->userdata('aileenuser');?>";
        </script>
       
        <?php if($artist_isregister == false){ ?>
            <script src="<?php echo base_url('assets/js_min/jquery.multi-select.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist-live/profile.js?ver='.time()); ?>"></script>
            <?php } ?>
			<?php $this->load->view('mobile_side_slide'); ?>
        <?php
        if($this->session->userdata('aileenuser') == ""): ?>
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
                        "@id": "<?php echo base_url(); ?>find-artist",
                        "name": "Artist"
                    }
                },
                <?php
                if(trim($category_txt) != "Other," && $city_txt != ""): ?>
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item":
                    {
                        "@id": "<?php echo base_url(); ?>artist",
                        "name": "All Artist"                
                    }
                },
                <?php
                    foreach (explode(",", $category_txt) as $key => $value) {
                        if($value != "" && $value != "Other")
                        { ?>
                            {
                                "@type": "ListItem",
                                "position": 4,
                                "item":
                                {
                                    "@id": "<?php echo base_url()."artist/".$this->common->create_slug($value)."-in-".$this->common->clean($city_txt); ?>",
                                    "name": "<?php echo $value." in ".$city_txt; ?>"
                                }
                            },
                        <?php }
                    } ?>
                <?php
                elseif($category_txt != "Other," && $city_txt == ""): ?>
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item":
                    {
                        "@id": "<?php echo base_url(); ?>artist/category",
                        "name": "Artist by Category"                
                    }
                },
                <?php
                    foreach (explode(",", $category_txt) as $key => $value) {
                        if($value != "" && $value != "Other")
                        { ?>
                            {
                                "@type": "ListItem",
                                "position": 4,
                                "item":
                                {
                                    "@id": "<?php echo base_url()."artist/".$this->common->create_slug($value); ?>",
                                    "name": "<?php echo $value; ?>"
                                }
                            },
                        <?php }
                    } ?>
                <?php
                elseif($city_txt != "" && trim($category_txt) == "Other,"): ?>
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item":
                    {
                        "@id": "<?php echo base_url(); ?>artist/location",
                        "name": "Artist by location"                
                    }
                },
                
                {
                    "@type": "ListItem",
                    "position": 4,
                    "item":
                    {
                        "@id": "<?php echo base_url()."artist/artist-in-".$this->common->clean($city_txt); ?>",
                        "name": "<?php echo $city_txt; ?>"
                    }
                },
                        
                <?php
                endif;
                ?>                
                {
                    "@type": "ListItem",
                    "position": 5,
                    "item":
                    {
                        "@id": "<?php echo current_url(); ?>",
                        "name": "<?php echo $fullname; ?>"
                    }
                }
            ]
        }
        </script>
        <?php 
        // $category_txt
        // $city_txt
        endif; ?>
    </body>
</html>