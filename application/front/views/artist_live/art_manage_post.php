<!DOCTYPE html>
<html lang="en" ng-app="artistDashboardApp" ng-controller="artistDashboardController">
    <head> 
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver='.time()); ?>">
        <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver='.time()); ?>" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/video.css?ver='.time()); ?>">
    
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
       
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
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
<!-- END HEADER -->
<body class="page-container-bg-solid page-boxed body-loader">
    <?php $this->load->view('page_loader'); ?>
    <div id="main_page_load" style="display: block;">    
        <?php echo $artistic_header2; ?>
        <section class="custom-row">
        <?php echo $artistic_common; ?>
            <div class="text-center tab-block">
                <div class="container mob-inner-page">
                   <a href="<?php echo site_url('artist/p/' . $get_url . '/photos'); ?>" title="Photo">
                        Photo
                    </a>
                   <a href="<?php echo site_url('artist/p/' . $get_url . '/videos'); ?>" title="Video">
                        Video
                    </a>
                   <a href="<?php echo site_url('artist/p/' . $get_url . '/audios'); ?>" title="Audio">
                        Audio
                    </a>
                    <a href="<?php echo site_url('artist/p/' . $get_url . '/pdf') ?>" title="Pdf">
                        PDf
                    </a>
                </div>
            </div>
            <div class="full-box-module business_data mob-detail-custom">
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
                        <?php }?>
                        <tr>
                            <td class="business_data_td1 detaile_map"><i class="fa fa-envelope" aria-hidden="true"></i></td>
                            <td class="business_data_td2">
								<a href="mailto:<?php echo $artisticdata[0]['art_email']; ?>" title="<?php echo $artisticdata[0]['art_email']; ?>"><?php echo $artisticdata[0]['art_email']; ?></a>
							</td>
                        </tr>
                        <tr>
                            <td class="business_data_td1  detaile_map" ><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                            <td class="business_data_td2">
                                <span>
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
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="user-midd-section">
                <div class="container art_container padding-360 manage-post-custom">        
                    <div class="profile-box-custom left_side_posrt">
                        <div class="full-box-module business_data">
                            <div class="profile-boxProfileCard  module">
                               <div class="head_details1">
                                    <span>
                                        <a href="<?php echo base_url('artist/p/' . $this->uri->segment(3) .'/details'); ?>" title="Information">
                                            <h5>
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                Information
                                            </h5>
                                        </a>
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
                                          }*/
                                            ?>   
                                        </td>
                                    </tr>                                    
                                    <?php /*if($artisticdata[0]['art_yourart']){?>
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
                                    <?php }?>
                                    <tr>
                                        <td class="business_data_td1 detaile_map"><i class="fa fa-envelope" aria-hidden="true"></i></td>
                                        <td class="business_data_td2">
        									<a href="mailto:<?php echo $artisticdata[0]['art_email']; ?>" title="<?php echo $artisticdata[0]['art_email']; ?>"><?php echo $artisticdata[0]['art_email']; ?></a>
        								</td>
                                    </tr>
                                    <tr>
                                        <td class="business_data_td1  detaile_map" ><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                                        <td class="business_data_td2">
                                            <span>
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
            					<h4>Email id</h4>
            					<p>{{artist_basic_info.art_email}}</p>
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

                        <a class="fw" href="<?php echo site_url('artist/p/' . $get_url . '/photos'); ?>" title="Photos">
                            <div class="full-box-module business_data" id="autorefresh">
                                <div class="profile-boxProfileCard  module buisness_he_module" style="">
                                    <div class="head_details">
                                        <h5><i class="fa fa-camera" aria-hidden="true"></i>Photos</h5>
                                    </div>  
                                    <div class="art_photos">
                                         <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="fw" href="<?php echo site_url('artist/p/' . $get_url . '/videos'); ?>" title="Video">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module">
                                    <table class="business_data_table">
                                        <div class="head_details">
                                             <h5><i class="fa fa-video-camera" aria-hidden="true"></i>  Video</h5>
                                        </div>  
                                        <div class="art_videos">
                                             <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </a>
                        <div class="full-box-module business_data fw">
                            <div class="profile-boxProfileCard  module">
                                <table class="business_data_table">
                                     <a href="<?php echo site_url('artist/p/' . $get_url . '/audios'); ?>"> 
                                    <div class="head_details">
                                         <h5><i class="fa fa-music" aria-hidden="true"></i>  Audio</h5>
                                    </div>
                                     </a>
                                    <div class="art_audios">
                                         <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                    </div>
                                </table>
                            </div>
                        </div>
                     
                        <a class="fw" href="<?php echo site_url('artist/p/' . $get_url . '/pdf') ?>" title="Pdf">
                            <div class="full-box-module business_data">
                                <div class="profile-boxProfileCard  module pdf_box">
                                    <table class="business_data_table">
                                        <div class="head_details">
                                             <h5><i class="fa fa-file-pdf-o" aria-hidden="true"></i>  PDF</h5>
                                        </div>
                                        <div class="art_pdf">
                                             <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>
                                        </div>
                                    </table>
                                </div>
                            </div>
        				</a>
        				<?php $this->load->view('right_add_box'); ?>
        				
        				<?php echo $left_footer; ?>
                        
                    </div>
                    
        			
        			
        			<!-- popup start -->
                    <div class=" custom-right-art mian_middle_post_box animated fadeInUp custom-right-business"  >
            			<div class="tab-add">
            				<?php $this->load->view('banner_add'); ?>
            			</div>                    
                        <!-- The Modal -->
                        <div id="myModal3" class="modal-post">
                            <!-- Modal content -->
                            <div class="modal-content-post">
                                <span class="close3">&times;</span>
                                <div class="post-editor col-md-12 post-edit-popup" id="close">
                                    <?php echo form_open_multipart(base_url('artist/art_post_insert/' . 'manage/' . $artisticdata[0]['user_id']), array('id' => 'artpostform', 'name' => 'artpostform', 'class' => 'clearfix upload-image-form', 'onsubmit' => "return imgval(event);")); ?>
                                    <div class="main-text-area col-md-12" >
                                        <div class="popup-img-in ">
                                            <?php 
                                            if (IMAGEPATHFROM == 'upload') {
                                                if($artisticdata[0]['art_user_image']){
                                                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'])) { ?>
                                                        <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                                    <?php } else { ?>
                                                        <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="<?php echo $artisticdata[0]['art_user_image']; ?>">
                                                    <?php }
                                                } else{ ?>
                                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                                <?php 
                                                } 
                                            }
                                            else
                                            {
                                                $filename = $this->config->item('art_profile_thumb_upload_path') . $artisticdata[0]['art_user_image'];
                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if ($info) { ?>
                                                    <img  src="<?php echo ART_PROFILE_THUMB_UPLOAD_URL . $artisticdata[0]['art_user_image']; ?>"  alt="<?php echo $artisticdata[0]['art_user_image']; ?>">
                                                    <?php
                                                }
                                                else
                                                { ?>
                                                    <img  src="<?php echo base_url(NOARTIMAGE); ?>"  alt="<?php echo "NOARTIMAGE"; ?>">
                                                <?php
                                                }
                                            }?>
                                        </div>
                                        <div id="myBtn3"    class="editor-content col-md-10 popup-text" >
                                            <textarea id= "test-upload-product" placeholder="Post Your Art...."  onKeyPress=check_length(this.form); onKeyDown=check_length(this.form);  onkeyup=check_length(this.form); onblur=check_length(this.form); name=my_text rows=4 cols=30 class="post_product_name"></textarea>
                                            <div class="fifty_val">  
                                                <input size=1 class="text_num" tabindex="-500" value=50 name=text_num readonly> 
                                            </div>
                                            <div class="camera_in padding-left padding_les_left camer_h">
                                                <i class=" fa fa-camera" ></i> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"></div>
                                    <div  id="text"  class="editor-content col-md-12 popup-textarea" >
                                        <textarea id="test-upload-des" name="product_desc" class="description" placeholder="Enter Description"></textarea>
                                        <output id="list"></output>
                                    </div>
                                    <div class="popup-social-icon">
                                        <ul class="editor-header">
                                            <li>
                                                <div class="col-md-12"> <div class="form-group">
                                                        <input id="file-1" type="file" class="file" name="postattach[]"  multiple class="file" data-overwrite-initial="false" data-min-file-count="2" style="visibility:hidden;">
                                                    </div></div>
                                                <label for="file-1">
                                                       <i class=" fa fa-camera upload_icon"  ><span class="upload_span_icon"> Photo</span></i>
                                                       <i class=" fa fa-video-camera upload_icon"  ><span class="upload_span_icon"> Video </span></i>
                                                       <i class="fa fa-music upload_icon "  ><span class="upload_span_icon"> Audio </span></i>
                                                       <i class=" fa fa-file-pdf-o upload_icon"  > <span class="upload_span_icon">PDF </span></i>
                                                 </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="fr">
                                        <button type="submit"  value="Submit" style="margin: 0px;">Post</button>    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <!-- popup end -->
                        <div class="bs-example">
                            <div class="progress progress-striped" id="progress_div">
                                <div class="progress-bar" style="width: 0%;">
                                    <span class="sr-only">0%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="art-all-post">
                        </div>

            			 <div class="banner-add">
            				<?php $this->load->view('banner_add'); ?>
            			</div>
                        <div class="fw" id="loader" style="text-align:center;">
                            <img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/>
                        </div>
                    </div>           
        			
        			<div class="right-part right-scroll">
        				<?php $this->load->view('right_add_box'); ?>
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
        </section>
        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">
                             <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                               <div class=" ">

                               <div class="fw" id="loaderfollow" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>" /></div>

                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
                                    </div>
                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="width:350px; display: none"></div>
                                    </div>
                                <input type="submit"  class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save">
                                </form>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="bidmodal-limit" role="dialog">
            <div class="modal-dialog modal-lm deactive">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal" id="common-limit">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box biderror" id="profileimage" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal" id="profileimage">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
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
        <div class="modal fade message-box" id="likeusermodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
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
                    <button type="button" class="modal-close" id="post" data-dismiss="modal">&times;</button>     <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="image" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="image" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                        </span>
                    </div>
                </div>
            </div>
        </div>  
        <div class="modal fade message-box biderror" id="bidmodaleditpost" role="dialog"  >
            <div class="modal-dialog modal-lm" >
                <div class="modal-content">
                   <button type="button" class="modal-close editpost" data-dismiss="modal">&times;</button>       
                   <div class="modal-body">
                      <span class="mes"></span>
                   </div>
                </div>
             </div>
        </div>
    </div>
    <?php echo $footer; ?>

    <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.form.3.51.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
    <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>

    <script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';   
    var isdeactive = '<?php echo $isartistactivate; ?>';   
    var data= <?php echo json_encode($demo); ?>;
    var data1 = <?php echo json_encode($city_data); ?>;
    var complex = <?php echo json_encode($selectdata); ?>;
    var textarea = document.getElementById("textarea");
    var slug = '<?php echo $artid; ?>';
    var art_slug = '<?php echo artist_dashboard. $get_url; ?>';
    var header_all_profile = '<?php echo $header_all_profile; ?>';
    var user_slug = '<?php echo $get_url; ?>';
    var app = angular.module("artistDashboardApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
    </script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/dashboard.js?ver='.time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/dashboard_new.js?ver='.time()); ?>"></script>
</body>
</html>