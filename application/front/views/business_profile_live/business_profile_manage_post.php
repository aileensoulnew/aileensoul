<?php
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
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>" />
            <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()); ?>" media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        <?php } ?>
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
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="page-container-bg-solid page-boxed pushmenu-push body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
            <?php echo $header; ?>
            <?php echo $business_header2; ?>
            <section>
                <?php echo $business_common; ?>
                <div class="text-center tab-block">
                    <div class="container mob-inner-page">
                        <a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug'] . '/photos') ?>">
                            Photo
                        </a>
                        <a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/videos' ?>">
                            Video
                        </a>
                        <a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/audios' ?>">
                            Audio
                        </a>
                        <a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/pdf' ?>">
                            PDf
                        </a>
                    </div>
                </div>
				<div class="full-box-module business_data mob-detail-custom">
                                <div class="profile-boxProfileCard  module">
                                    
                                    <table class="business_data_table">
                                        <tr>
                                            <td class="business_data_td1 detaile_map"><i class="fa fa-user"></i></td>
                                            <td class="business_data_td2"><?php echo ucfirst(strtolower($business_data[0]['contact_person'])); ?></td>
                                        </tr>

                                       <?php if ($business_data[0]['contact_mobile'] != '0') { ?>
                                        <tr>
                                            <td class="business_data_td1 detaile_map"><i class="fa fa-mobile"></i></td>
                                            <td class="business_data_td2"><span><?php
                                                    
                                                        echo $business_data[0]['contact_mobile'];
                                                   
                                                    ?></span>
                                            </td>
                                        </tr>
                                        <?php }?>
                                        <tr>
                                            <td class="business_data_td1 detaile_map"><i class="fa fa-envelope-o" aria-hidden="true"></i></td>
                                            <td class="business_data_td2"><span><?php echo $business_data[0]['contact_email']; ?></span></td>
                                        </tr>
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
                                                <td class="business_data_td1 detaile_map"><i class="fa fa-globe"></i></td>
                                                <td class="business_data_td2 website"><span><a target="_blank" href="<?php echo $business_data[0]['contact_website']; ?>"> <?php echo $business_data[0]['contact_website']; ?></a></span></td>
                                            </tr>
                                        <?php } ?>

                                        
                                        <?php if($business_data[0]['details']){?>
                                        <tr>
                                            <td class="business_data_td1 detaile_map"><i class="fa fa-suitcase"></i></td>
                                            <?php
                                            $bus_detail = nl2br($this->common->make_links($business_data[0]['details']));
                                            $bus_detail = preg_replace('[^(<br( \/)?>)*|(<br( \/)?>)*$]', '', $bus_detail);
                                            ?>
                                            <td class="business_data_td2"><span><?php echo $bus_detail; ?></span></td>
                                        </tr>
                                        <?php }?>
                                    </table>
                                </div>
                            </div>
                <div class="user-midd-section">
                    <div class="container art_container padding-360 manage-post-custom">
                        <div class="profile-box-custom left_side_posrt">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module">
                                    <div class="head_details1">
                                        <span><a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug'] . '/details'); ?>"><h5><i class="fa fa-info-circle" aria-hidden="true"></i>Information</h5></a>
                                        </span>      
                                    </div>
                                    <table class="business_data_table">
                                        <tr>
                                            <td class="business_data_td1 detaile_map"><i class="fa fa-user"></i></td>
                                            <td class="business_data_td2"><?php echo ucfirst(strtolower($business_data[0]['contact_person'])); ?></td>
                                        </tr>

                                       <?php if ($business_data[0]['contact_mobile'] != '0') { ?>
                                        <tr>
                                            <td class="business_data_td1 detaile_map"><i class="fa fa-mobile"></i></td>
                                            <td class="business_data_td2"><span><?php
                                                    
                                                        echo $business_data[0]['contact_mobile'];
                                                   
                                                    ?></span>
                                            </td>
                                        </tr>
                                        <?php }?>
                                        <tr>
                                            <td class="business_data_td1 detaile_map"><i class="fa fa-envelope-o" aria-hidden="true"></i></td>
                                            <td class="business_data_td2"><span><?php echo $business_data[0]['contact_email']; ?></span></td>
                                        </tr>
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
                                                <td class="business_data_td1 detaile_map"><i class="fa fa-globe"></i></td>
                                                <td class="business_data_td2 website"><span><a target="_blank" href="<?php echo $business_data[0]['contact_website']; ?>"> <?php echo $business_data[0]['contact_website']; ?></a></span></td>
                                            </tr>
                                        <?php } ?>

                                        
                                        <?php if($business_data[0]['details']){?>
                                        <tr>
                                            <td class="business_data_td1 detaile_map"><i class="fa fa-suitcase"></i></td>
                                            <?php
                                            $bus_detail = nl2br($this->common->make_links($business_data[0]['details']));
                                            $bus_detail = preg_replace('[^(<br( \/)?>)*|(<br( \/)?>)*$]', '', $bus_detail);
                                            ?>
                                            <td class="business_data_td2"><span><?php echo $bus_detail; ?></span></td>
                                        </tr>
                                        <?php }?>
                                    </table>
                                </div>
                            </div>
							<div class="left-info-box">
								<div class="dash-left-title">
									<h3><i class="fa fa-info-circle"></i> Information</h3>
								</div>
								<div class="dash-info-box">
										<h4>Specialties </h4>
										<ul class="skill-list">
											<li>HTML</li>
											<li>CSS</li>
											<li>Photo shop</li>
											<li>Saturday</li>
										</ul>
									</div>
									<div class="dash-info-box">
										<h4>Hours of Operation</h4>
										<p>On Specified Days</p>
										<ul>
											<li>Sunday : 2:30 PM to 1:30 PM</li>
											<li>Wednesday : 7:00 AM to 7:30 PM</li>
											<li>Thursday : 3:00 AM to 3:00 PM</li>
											<li>Saturday : 6:30 PM to 8:00 AM</li>
										</ul>
									</div>
									<div class="dash-info-box">
										<h4>Mission</h4>
										<p>Lorem ipsupm its a dummy text. its has binn use to for the Lorem ipsupm its a dummy text... <a href="#">View More</a></p>
									</div>
									<div class="dash-info-box">
										<h4>Tagline</h4>
										<p>Lorem ipsupm its a dummy text. its has binn use to... <a href="#">View More</a></p>
									</div>
									<div class="dash-info-box">
										<h4>Year Founded</h4>
										<p>10 june 2018 </p>
									</div>
							</div>
                            <a class="fw" href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/photos' ?>">
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
                            <a class="fw" href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/videos' ?>">
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
                            <div class="full-box-module business_data fw">
                                <div class="profile-boxProfileCard  module">
                                    <a href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/audios' ?>"> 
                                        <div class="head_details1">
                                            <h5><i class="fa fa-music" aria-hidden="true"></i>Audio</h5>
                                        </div>
                                    </a>
                                    <table class="business_data_table">
                                        <div class="bus_audios"> 
                                        </div>
                                    </table>
                                </div>
                            </div>
                            <a class="fw" href="<?php echo base_url('company/' . $business_common_data[0]['business_slug']) . '/pdf' ?>">
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
							<div class="right_side_posrt">
							<div class="tab-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                            <?php
                            if ($is_eligable_for_post == 1) {
                                ?>
								
                                <div class="post-editor col-md-12">
                                    <div class="main-text-area col-md-12">
                                        <div class="popup-img"> 
                                            <?php if ($business_login_user_image) { ?>
                                                <?php
                                                if (IMAGEPATHFROM == 'upload') {
                                                    if (!file_exists($this->config->item('bus_profile_main_upload_path') . $business_login_user_image)) {
                                                        ?>
                                                        <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Business Image">
                                                    <?php } else {
                                                        ?>
                                                        <img  src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image; ?>"  alt="Business Login User">
                                                        <?php
                                                    }
                                                } else {
                                                    $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_login_user_image;
                                                    $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                    if (!$info) {
                                                        ?>
                                                        <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Business Image">
                                                    <?php } else {
                                                        ?>
                                                        <img  src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image; ?>"  alt="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image; ?>">
                                                        <?php
                                                    }
                                                }
                                            } else {
                                                ?>
                                                <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Business Image">
                                            <?php } ?>
                                        </div>
                                        <div id="myBtn1"  class="editor-content popup-text" onclick="return modelopen();">
                                            <span>Post Your Product....</span>
                                            <div class="padding-left padding_les_left camer_h">
                                                <i class=" fa fa-camera">
                                                </i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div id="myModal3" class="modal-post">
                                <div class="modal-content-post">
                                    <span class="close3">&times;</span>
                                    <div class="post-editor post-edit-popup" id="close">
                                        <?php echo form_open_multipart(base_url('business-profile/bussiness-profile-post-add/' . 'manage/' . $business_data[0]['user_id']), array('id' => 'artpostform', 'name' => 'artpostform', 'class' => 'clearfix dashboard-upload-image-form', 'onsubmit' => "imgval(event)")); ?>
                                        <div class="main-text-area col-md-12"  >
                                            <div class="popup-img-in"> 
                                                <?php
                                                if ($business_login_user_image != '') {
                                                    ?>
                                                    <?php
                                                    if (IMAGEPATHFROM == 'upload') {
                                                        if (!file_exists($this->config->item('bus_profile_thumb_upload_path') . $business_login_user_image)) {
                                                            ?>
                                                            <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                                        <?php } else {
                                                            ?>
                                                            <img  src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image; ?>"  alt="Business Profile">
                                                            <?php
                                                        }
                                                    } else {
                                                        $filename = $this->config->item('bus_profile_thumb_upload_path') . $business_login_user_image;
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                        if (!$info) {
                                                            ?>
                                                            <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                                        <?php } else {
                                                            ?>
                                                            <img  src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL . $business_login_user_image; ?>"  alt="Business Profile">
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    ?>
                                                    <img  src="<?php echo base_url(NOBUSIMAGE); ?>"  alt="No Image">
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div id="myBtn1"  class="editor-content col-md-10 popup-text" >
                                                <textarea id= "test-upload_product" placeholder="Post Your Product...."  onKeyPress=check_length(this.form); onKeyDown=check_length(this.form); 
                                                          name=my_text rows=4 cols=30 class="post_product_name" style="position: relative;" tabindex="1"></textarea>
                                                <div class="fifty_val">                   
                                                    <input size=1 value=50 name=text_num class="text_num" disabled="disabled"> 
                                                </div>
                                                <div class="padding-left camera_in camer_h" ><i class=" fa fa-camera " ></i> </div>
                                            </div>
                                        </div>
                                        <div class="row"></div>
                                        <div  id="text"  class="editor-content col-md-12 popup-textarea" >
                                            <textarea id="test-upload_des" name="product_desc" class="description" placeholder="Enter Description" tabindex="2"></textarea>
                                            <output id="list"></output>
                                        </div>
                                        <div class="print_privew_post">
                                        </div>
                                        <div class="preview"></div>
                                        <div id="data-vid" class="large-8 columns">
                                        </div>
                                        <h2 id="name-vid"></h2>
                                        <p id="size-vid"></p>
                                        <p id="type-vid"></p>
                                        <div class="popup-social-icon">
                                            <ul class="editor-header">
                                                <li>
                                                    <div class="col-md-12"> <div class="form-group">
                                                            <input id="file-1" type="file" class="file" name="postattach[]"  multiple class="file" data-overwrite-initial="false" data-min-file-count="2" style="display: none;">
                                                        </div></div>
                                                    <label for="file-1">
                                                        <i class=" fa fa-camera upload_icon"  ><span class="upload_span_icon"> Photo </span> </i>
                                                        <i class=" fa fa-video-camera upload_icon"> <span class="upload_span_icon">Video </span> </i> 
                                                        <i class="fa fa-music upload_icon"><span class="upload_span_icon"> Audio</span> </i>
                                                        <i class=" fa fa-file-pdf-o upload_icon"><span class="upload_span_icon"> PDF </span></i>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="fr margin_btm">
                                            <button type="submit"  value="Submit">Post</button>    
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($this->session->flashdata('error')) {
                                echo $this->session->flashdata('error');
                            }
                            ?>
                            <div class="fw">
                                <div class="bs-example">
                                    <div class="progress progress-striped" id="progress_div">
                                        <div class="progress-bar" style="width: 0%;">
                                            <span class="sr-only">0%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="business-all-post">
                                </div>
                                <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="Loader" /></div>
                            </div>
                        </div>
						
						</div>
                        <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 
							<?php $this->load->view('right_add_box');
                            if($login_bussiness_data->user_id == $business_data[0]['user_id']): ?>
                            <div id="profile-progress" class="edit_profile_progress right-add-box" style="display: none;">
                                <div class="count_main_progress">
                                    <div class="circles">
                                        <div class="second circle-1">
                                            <div>
                                                <strong></strong>
                                                <span id="progress-txt"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
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
            <div class="modal fade message-box" id="query" role="dialog">
                <div class="modal-dialog modal-lm">
                    <div class="modal-content">
                        <button type="button" class="profile-modal-close" id="query" data-dismiss="modal">&times;</button>       
                        <div class="modal-body">
                            <span class="mes">
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade message-box" id="bidmodal-3" role="dialog">
                <div class="modal-dialog modal-lm">
                    <div class="modal-content">
                        <button type="button" class="profile-modal-close" data-dismiss="modal">&times;</button>       
                        <div class="modal-body">
                            <span class="mes">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var slug = '<?php echo $slugid; ?>';
            var no_business_post_html = '<?php echo $no_business_post_html ?>';
            var header_all_profile = '<?php echo $header_all_profile ?>';
        </script>
        
        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script type = "text/javascript" src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver=' . time()) ?>"></script> 
        <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>">
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/dashboard.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        
    </body>
</html>
