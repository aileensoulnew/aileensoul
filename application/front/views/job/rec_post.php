<?php $userid_login = $this->session->userdata('aileenuser');

 $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name !=' => "Others");
if ($userid_login) {
    $search_condition = "((is_other = '1' AND user_id = $userid_login) OR (is_other = '0'))";
} else {
    $search_condition = "(is_other = '0')";
}
$industry = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'industry_id,industry_name', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

$contition_array = array('is_delete' => '0', 'industry_name' => "Others", 'is_other' => '0');
$search_condition = "((status = '1'))";
$other_industry = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'industry_id,industry_name', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php //echo $head; ?> 
        <?php /*
        if (IS_REC_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css'); ?>">

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/recruiter.css'); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css'); ?>">

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/recruiter.css'); ?>">
        <?php }*/ ?>

         <?php /*
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
        <?php }else{?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver='.time()); ?>">

        <?php }*/ ?>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">  
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); 
        ?>">		
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
       
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <style type="text/css">
            .ui-autocomplete{
                z-index: 99999!important;
            }
        </style>

    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push freeh3 cust-job-width paddnone">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: none;">
        <?php //echo $recruiter_header2; ?>
        <?php
        //$returnpage = $_GET['page'];
        // echo $this->session->userdata('aileenuser');
        // echo $recliveid;exit;
        if ($this->session->userdata('aileenuser') != $recliveid) {
             if($job_deactive == 0 && $userid_login != ""){
                echo $job_header2;
            }else if ($job_deactive > 0 || $this->job_profile_set == 0) {
                echo $header_inner_profile;
            }
            //echo $job_header2;
        }
        else{
            echo $recruiter_header2;
        } /*elseif ($recdata[0]['re_step'] == 3) {
            echo $recruiter_header2_border;
        } elseif ($returnpage == 'notification') {
            
        }*/
        ?>
        <div id="preloader"></div>
        <!-- START CONTAINER -->
        <section>
            <div class="user-midd-section" id="paddingtop_fixed">
                <div class="container padding-360">
                    <!-- MIDDLE SECTION START -->
                    <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" style="position: absolute !important;">
                        <!--left bar box start-->
                        <div class="full-box-module">   
                            <div class="profile-boxProfileCard  module">
                                <div class="profile-boxProfileCard-cover"> 
                                    <?php                                    
                                     if ($this->session->userdata('aileenuser') == $recliveid) {
                                        if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">
                                            <?php else: ?>
                                        <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo base_url('recruiter/profile'); ?>" tabindex="-1" 
                                           aria-hidden="true" rel="noopener">
                                           <?php endif;
                                            } else {
                                                if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                    <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">
                                                    <?php else: ?>
                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block" href="<?php echo base_url('recruiter/profile/' . $recliveid) ?>" title="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" tabindex="-1" 
                                               aria-hidden="true" rel="noopener">
                                               <?php 
                                           endif;
                                           } ?>
                                            <div class="bg-images no-cover-upload"> 
                                                <?php
                                                $image_ori = $recdata[0]['profile_background'];
                                                $filename = $this->config->item('rec_bg_main_upload_path') . $recdata[0]['profile_background'];
                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if ($info && $recdata[0]['profile_background'] != '') {
                                                    ?>
                                                    <img src = "<?php echo REC_BG_MAIN_UPLOAD_URL . $recdata[0]['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $recdata[0]['profile_background']; ?>"/>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" >
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </a>
                                </div>
                                <div class="profile-boxProfileCard-content clearfix">
                                    <div class="left_side_box_img buisness-profile-txext">
                                        <?php
                                        if ($this->session->userdata('aileenuser') == $recliveid) {
                                            if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block a-inlineBlock" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">
                                            <?php else: ?>
                                            <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock a-inlineBlock"  href="<?php echo base_url('recruiter/profile/'. $recliveid); ?>" title="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                            <?php endif; } else {
                                                if($this->job_profile_set == 0 && $job_deactive == 0): ?>
                                                    <a class="profile-boxProfileCard-bg u-bgUserColor a-block a-inlineBlock" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">
                                            <?php else: ?>
                                                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock "  href="<?php echo base_url('recruiter/profile/' . $recliveid); ?>" title="<?php echo $recdata[0]['rec_firstname'] . ' ' . $recdata[0]['rec_lastname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">                                               
                                                <?php endif; } 
                                                $filename = $this->config->item('rec_profile_thumb_upload_path') . $recdata[0]['recruiter_user_image'];
                                                $s3 = new S3(awsAccessKey, awsSecretKey);
                                                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);
                                                if ($recdata[0]['recruiter_user_image'] != '' && $info) {
                                                    ?>
                                                    <div class="left_iner_img_profile">
                                                        <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $recdata[0]['recruiter_user_image']; ?>" alt="<?php echo $recdata[0]['recruiter_user_image']; ?>" >
                                                    </div>
                                                    <?php
                                                } else {


                                                    $a = $recdata[0]['rec_firstname'];
                                                    $acr = substr($a, 0, 1);

                                                    $b = $recdata[0]['rec_lastname'];
                                                    $acr1 = substr($b, 0, 1);
                                                    ?>
                                                    <div class="post-img-profile">
                                                        <?php echo ucfirst(strtolower($acr)) . ucfirst(strtolower($acr1)); ?>

                                                    </div>

                                                    <?php
                                                }
                                                ?>
                                            </a>
                                    </div>
                                    <div class="right_left_box_design ">
                                        <span class="profile-company-name ">
                                            <?php if ($this->session->userdata('aileenuser') == $recliveid) { 
                                                if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">
                                                    <?php echo ucfirst(strtolower($recdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata[0]['rec_lastname'])); ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo site_url('recruiter/profile'); ?>" title="<?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($recdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata[0]['rec_lastname'])); ?></a>
                                            <?php 
                                                endif;
                                            } else { 
                                                if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);"><?php echo ucfirst(strtolower($recdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata[0]['rec_lastname'])); ?></a>
                                            <?php else: ?>
                                                <a href="<?php echo site_url('recruiter/profile/' . $recliveid); ?>" title="<?php echo ucfirst(strtolower($recdata['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata['rec_lastname'])); ?>">   <?php echo ucfirst(strtolower($recdata[0]['rec_firstname'])) . ' ' . ucfirst(strtolower($recdata[0]['rec_lastname'])); ?></a>
                                            <?php endif;
                                            } ?>
                                        </span>

                                    
                                        <div class="profile-boxProfile-name">
                                            <?php if ($this->session->userdata('aileenuser') == $recliveid) { 
                                                if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">
                                            <?php else: ?>
                                                <a href="<?php echo site_url('recruiter/profile/' . $recdata[0]['user_id']); ?>" title="<?php echo ucfirst(strtolower($recdata[0]['designation'])); ?>">
                                                <?php endif;
                                            } else { 
                                                if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">
                                            <?php else: ?>
                                                    <a href="<?php echo site_url('recruiter/profile/' . $recliveid); ?>" title="<?php echo ucfirst(strtolower($recdata[0]['designation'])); ?>">    
                                            <?php 
                                                endif;
                                            } 
                                                    if (ucfirst(strtolower($recdata[0]['designation']))) {
                                                        echo ucfirst(strtolower($recdata[0]['designation']));
                                                    } else {
                                                        echo "Designation";
                                                    }
                                                    ?></a>
                                        </div>
                                        <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                            <ul class=" left_box_menubar">
                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>>
                                                    <?php if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">Details</a>
                                            <?php else: ?>
                                                    <a class="padding_less_left" title="Details" href="<?php echo base_url('recruiter/profile'); ?>"> Details</a>
                                                <?php endif;?>
                                                </li>                                
                                                <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>>
                                                    <?php if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">Post</a>
                                            <?php else: ?>
                                                    <a title="Post" href="<?php echo base_url('recruiter/post'); ?>">Post</a>
                                                <?php endif; ?>
                                                </li>
                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'save-candidate') { ?> class="active" <?php } ?>>
                                                    <?php if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">Saved </a>
                                            <?php else: ?>
                                                    <a title="Saved Candidate" class="padding_less_right" href="<?php echo base_url('recruiter/save-candidate'); ?>">Saved </a>
                                                <?php endif; ?>
                                                </li>

                                            </ul>
                                        <?php } else { ?>
                                            <ul class=" left_box_menubar">
                                                <li <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'profile') { ?> class="active" <?php } ?>>
                                                <?php if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">Details</a>
                                            <?php else: ?>
                                                    <a class="padding_less_left" title="Details" href="<?php echo base_url('recruiter/profile/' . $recliveid); ?>"> Details</a>
                                                <?php endif; ?>
                                                </li>                                
                                                <li id="rec_post_home" <?php if ($this->uri->segment(1) == 'recruiter' && $this->uri->segment(2) == 'post') { ?> class="active" <?php } ?>>
                                                    <?php if($this->job_profile_set == 0 && $job_deactive == 0):?>
                                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block" data-toggle="modal" data-target="#job_reg" href="javascript:void(0);">Post</a>
                                            <?php else: ?>
                                                    <a title="Post" href="<?php echo base_url('recruiter/post/' . $recliveid); ?>">Post</a>
                                                <?php endif; ?>
                                                </li>

                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>  


                        </div>
                       
                        <div id="hideuserlist" class=" fixed_right_display animated fadeInRightBig"> 
							<div class="all-profile-box hidden">
                                <div class="all-pro-head">
                                    <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right">All</a></h4>
                                </div>
                                <ul class="all-pr-list">
                                    <li>
                                        <a href="<?php echo base_url('job'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="job">
                                            </div>
                                            <span>Job Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('recruiter'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="recruiter">
                                            </div>
                                            <span>Recruiter Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('freelance'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i3.jpg'); ?>" alt="freelancer">
                                            </div>
                                            <span>Freelance Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('business-profile'); ?>" alt="business-profile">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i4.jpg'); ?>">
                                            </div>
                                            <span>Business Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url('artist'); ?>">
                                            <div class="all-pr-img">
                                                <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="artist">
                                            </div>
                                            <span>Artistic Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <?php echo $right_profile_view; ?>
                        </div>
																					
                        <!--left bar box end-->
                        <!-- <div  class="add-post-button mob-block">
                            <?php /*if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                <a class="btn btn-3 btn-3b" id="rec_post_job2" href="<?php echo base_url('recruiter/add-post'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job 123</a>
                            <?php }*/ ?>
                        </div>
                        <div class="mob-none">
                            <div  class="add-post-button">
                                <?php /*if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                    <a class="btn btn-3 btn-3b" id="rec_post_job1" href="<?php echo base_url('recruiter/add-post'); ?>"><i class="fa fa-plus" aria-hidden="true"></i>  Post a Job 123</a>
                                <?php }*/ ?>
                            </div>
                        </div> -->
                    </div>


                    <div class="inner-right-part">
                        <div class="page-title">
                            <h3>
                                <?php
                                $cache_time = $this->db->get_where('job_title', array('title_id' => $postdata[0]['post_name']))->row()->name;
                                if ($cache_time) {
                                    echo $cache_time;
                                } else {
                                    echo $postdata[0]['post_name'];
                                }
                                ?>
                            </h3>
                        </div>
						
                        <?php
                        if (count($postdata) > 0) {
                            foreach ($postdata as $post) {  
                                ?>
                                <div class="all-job-box job-detail">
                                    <div class="all-job-top">
                                        <div class="post-img">
                                            <a title="<?php echo $post['re_comp_name']; ?>" href="<?php echo base_url('recruiter/profile/' . $post['user_id']); ?>">
                                                <?php
                                                $cache_time = $this->db->get_where('recruiter', array(
                                                            'user_id' => $post['user_id']
                                                        ))->row()->comp_logo;
                                                if ($cache_time) {
                                                    if (IMAGEPATHFROM == 'upload') {
                                                        if (!file_exists($this->config->item('rec_profile_thumb_upload_path') . $cache_time)) { 
                                                            ?>
                                                <img src="<?php echo base_url('assets/images/commen-img.png') ?>" alt="commonimage">
                                                   <?php     } else { ?>
                                                            <img src="<?php echo  REC_PROFILE_THUMB_UPLOAD_URL . $cache_time ?>" alt="<?php echo $cache_time; ?>">
                                                       <?php  }
                                                    } else { ?>
                                                        <!--<img src="<?php echo base_url($this->config->item('rec_profile_thumb_upload_path') . $cache_time);  ?>" alt="<?php echo $cache_time; ?>">-->
                                                    <?php    $filename = $this->config->item('rec_profile_thumb_upload_path') . $cache_time;
                                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename); 
                                                         if ($info) { ?>
                                                           <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL . $cache_time  ?>" alt="<?php echo $cache_time; ?>">
                                                         <?php } else { ?>
                                                          <img src="<?php echo  base_url('assets/images/commen-img.png') ?>" alt="commonimage">
                                                       <?php  }
                                                    }
                                                } else { ?>
                                                    <img src="<?php echo  base_url('assets/images/commen-img.png') ?>" alt="commonimage">
                                               <?php  } ?>
                                            </a>
                                        </div>
                                        <div class="job-top-detail">
                                            <?php
                                            $cache_time1 = $this->db->get_where('job_title', array('title_id' => $post['post_name']))->row()->name;
                                            if ($cache_time1) {
                                                $cache_time1;
                                            } else {
                                                $cache_time1 = $post['post_name'];
                                            }
                                            ?>
                                            <h5><a title="<?php echo $cache_time1; ?>"><?php echo $cache_time1; ?></a></h5>
                                            <p><a href="<?php echo base_url('recruiter/profile/' . $post['user_id']); ?>" title="<?php echo $post['re_comp_name']; ?>">
                                                    <?php
                                                    $out = strlen($post['re_comp_name']) > 40 ? substr($post['re_comp_name'], 0, 40) . "..." : $post['re_comp_name'];
                                                    echo $out;
                                                    ?>
                                                </a>
                                            </p>
                                            <p><a href="<?php echo base_url('recruiter/profile/' . $post['user_id']); ?>" title="<?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?>"><?php echo ucfirst(strtolower($post['rec_firstname'])) . ' ' . ucfirst(strtolower($post['rec_lastname'])); ?></a></p>
                                            <p class="loca-exp">
                                                <span class="location">
                                                    <?php
                                                    $cityname = $this->db->get_where('cities', array('city_id' => $post['city']))->row()->city_name;
                                                    $countryname = $this->db->get_where('countries', array('country_id' => $post['country']))->row()->country_name;
                                                    ?>
                                                    <span>
                                                        
                                                        <?php
                                                        if ($cityname || $countryname) {
                                                            if ($cityname) {
                                                                echo $cityname . ', ';
                                                            }
                                                            echo $countryname.' '.'(Location)';
                                                        }
                                                        ?>
                                                    </span>
                                                </span>
                                            </p>
                                            <p class="loca-exp">
                                                <span class="exp">
                                                    <span>
                                                        <!-- <img class="pr5" src="<?php //echo base_url('assets/images/exp.png'); ?>"> -->

                                                        <?php
                                                        if (($post['min_year'] != '0' || $post['max_year'] != '0') && ($post['fresher'] == 1)) {


                                                            echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year' . " (Required Experience) " . "(Fresher can also apply).";
                                                        } else if (($post['min_year'] != '0' || $post['max_year'] != '0')) {
                                                            echo $post['min_year'] . ' Year - ' . $post['max_year'] . ' Year'. " (Required Experience) ";
                                                        } else {
                                                            echo "Fresher";
                                                        }
                                                        ?>
                                                    </span>
                                                </span>
                                            </p>
                                            <p class="pull-right job-top-btn">

                                                <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
           
                                                    <?php
                                                } else {
                                                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                                                    $contition_array = array(
                                                        'post_id' => $post['post_id'],
                                                        'job_delete' => '0',
                                                        'user_id' => $userid
                                                    );
                                                    $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                    if ($jobsave) {
                                                        ?>
                                                        <a href="javascript:void(0);" class="btn4 applied">Applied</a>
                                                    <?php } else { ?>
                                                       
                                                        <?php
                                                        $userid = $this->session->userdata('aileenuser');
                                                        $contition_array = array(
                                                            'user_id' => $userid,
                                                            'job_save' => '2',
                                                            'post_id ' => $post['post_id'],
                                                            'job_delete' => '1'
                                                        );
                                                        $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                        if ($jobsave) {
                                                            ?>
                                                            <a class="btn4 saved save_saved_btn">Saved</a>
                                                        <?php } else { ?>
                                                            <a title="Save" id="<?php echo $post['post_id']; ?>" onClick="savepopup(<?php echo $post['post_id'] ?>)" href="javascript:void(0);" class="savedpost<?php echo $post['post_id']; ?> btn4 save_saved_btn">Save</a>
                                                        <?php } ?>
                                                         <a href="javascript:void(0);"  class= "applypost<?php echo $post['post_id']; ?>  btn4" onclick="applypopup(<?php echo $post['post_id'] ?>,<?php echo $post['user_id'] ?>)">Apply</a>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                               
                                            </p>
                                        </div>
                                    </div>
                                    <div class="detail-discription">
                                        <div class="all-job-middle">
                                            <ul>
                                                <li>
                                                    <b>Job description</b>
                                                    <span>
                                                        <pre><?php echo $this->common->make_links($post['post_description']); ?></pre>
                                                    </span>
                                                </li>
                                                <li>
                                                    <b>Key skill</b>
                                                    <span>  <?php
                                        $comma = ", ";
                                        $k = 0;
                                        $aud = $post['post_skill'];
                                        $aud_res = explode(',', $aud);

                                        if (!$post['post_skill']) {

                                            echo $post['other_skill'];
                                        } else if (!$post['other_skill']) {


                                            foreach ($aud_res as $skill) {

                                                $cache_time = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;

                                                if ($cache_time != " ") {
                                                    if ($k != 0) {
                                                        echo $comma;
                                                    }echo $cache_time;
                                                    $k++;
                                                }
                                            }
                                        } else if ($post['post_skill'] && $post['other_skill']) {
                                            foreach ($aud_res as $skill) {
                                                if ($k != 0) {
                                                    echo $comma;
                                                }
                                                $cache_time3 = $this->db->get_where('skill', array('skill_id' => $skill))->row()->skill;


                                                echo $cache_time3;
                                                $k++;
                                            } echo "," . $post['other_skill'];
                                        }
                                                ?>  
                                                    </span>
                                                </li>
                                                <li><b>No of openings</b>
                                                    <span><?php echo $post['post_position']; ?>
                                                    </span>
                                                </li>
                                                <li><b>Industry</b>
                                                    <span> 
                                                        <?php
                                                        $cache_time4 = $this->db->get_where('job_industry', array('industry_id' => $post['industry_type']))->row()->industry_name;
                                                        echo $cache_time4;
                                                        ?>
                                                    </span>
                                                </li>
                                                <li><b>Required education</b>
                                                    <?php if ($post['degree_name'] != '' || $post['other_education'] != '') { ?>
                                                        <span>
                                                            <?php
                                                            $comma = ", ";
                                                            $k = 0;
                                                            $edu = $post['degree_name'];
                                                            $edu_nm = explode(',', $edu);

                                                            if (!$post['degree_name']) {

                                                                echo $post['other_education'];
                                                            } else if (!$post['other_education']) {


                                                                foreach ($edu_nm as $edun) {
                                                                    if ($k != 0) {
                                                                        echo $comma;
                                                                    }
                                                                    $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                    echo $cache_time;
                                                                    $k++;
                                                                }
                                                            } else if ($post['degree_name'] && $post['other_education']) {
                                                                foreach ($edu_nm as $edun) {
                                                                    if ($k != 0) {
                                                                        echo $comma;
                                                                    }
                                                                    $cache_time = $this->db->get_where('degree', array('degree_id' => $edun))->row()->degree_name;


                                                                    echo $cache_time;
                                                                    $k++;
                                                                } echo "," . $post['other_education'];
                                                            }
                                                            ?>     

                                                        </span>
                                                    <?php } else { ?>
                                                        <span>
                                                            <?php echo JOBDATANA; ?>
                                                        </span>
                                                    <?php } ?>
                                                </li>
                                                <li><b>Sallary</b>
                                                    <span>
                                                        <?php
                                                        $currency = $this->db->get_where('currency', array('currency_id' => $post['post_currency']))->row()->currency_name;

                                                        if ($post['min_sal'] || $post['max_sal']) {
                                                            echo $post['min_sal'] . " - " . $post['max_sal'] . ' ' . $currency . ' ' . $post['salary_type'];
                                                        } else {
                                                            echo JOBDATANA;
                                                        }
                                                        ?></span>
                                                </li>
                                                <li><b>Employment Type</b>
                                                    <span>
                                                        <?php if ($post['emp_type'] != '') { ?>

                                                            <?php echo $this->common->make_links($post['emp_type']) . '  Job'; ?>

                                                            <?php
                                                        } else {
                                                            echo JOBDATANA;
                                                        }
                                                        ?> 
                                                    </span>
                                                </li>
                                                <li><b>Interview Process</b>
                                                    <span>
                                                        <?php if ($post['interview_process'] != '') { ?>
                                                            <pre>
                                                                <?php echo $this->common->make_links($post['interview_process']); ?></pre>
                                                                <?php
                                                        } else {
                                                            echo JOBDATANA;
                                                        }
                                                        ?> 
                                                    </span>
                                                </li>
                                                <li><b>Company profile</b>
                                                    <span>
                                                        <?php if ($post['re_comp_profile'] != '') { ?>
                                                            <pre>
                                                                <?php echo $this->common->make_links($post['re_comp_profile']); ?></pre>
                                                                <?php
                                                        } else {
                                                            echo JOBDATANA;
                                                        }
                                                        ?> 
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="all-job-bottom">
                                            <span class="job-post-date"><b>Posted on:  </b><?php echo date('d-M-Y', strtotime($post['created_date'])); ?></span>
                                            <p class="pull-right">
                                                <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
                                                    <a href="javascript:void(0);" class="btn4" onclick="removepopup(<?php echo $post['post_id'] ?>)">Remove</a>
                                                    <a href="<?php echo base_url() . 'recruiter/edit-post/' . $post['post_id'] ?>" class="btn4">Edit</a>
                                                    <?php
                                                    $join_str[0]['table'] = 'job_reg';
                                                    $join_str[0]['join_table_id'] = 'job_reg.user_id';
                                                    $join_str[0]['from_table_id'] = 'job_apply.user_id';
                                                    $join_str[0]['join_type'] = '';

                                                    $condition_array = array('post_id' => $post['post_id'], 'job_apply.job_delete' => '0', 'job_reg.status' => '1', 'job_reg.is_delete' => '0', 'job_reg.job_step' => '10');
                                                    $data = "job_apply.*,job_reg.job_id";
                                                    $apply_candida = $this->common->select_data_by_condition('job_apply', $condition_array, $data, $short_by = '', $order_by = '', $limit, $offset, $join_str, $groupby = '');
                                                    $countt = count($apply_candida);
                                                    ?>
                                                    <a href="<?php echo base_url() . 'recruiter/apply-list/' . $post['post_id'] ?>" class="btn4">Applied  Candidate : <?php echo $countt ?></a>
                                                    <?php
                                                } else {
                                                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                                                    $contition_array = array(
                                                        'post_id' => $post['post_id'],
                                                        'job_delete' => '0',
                                                        'user_id' => $userid
                                                    );
                                                    $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                    if ($jobsave) {
                                                        ?>
                                                        <a href="javascript:void(0);" class="btn4 applied">Applied</a>
                                                    <?php } else { ?>
                                                        
                                                        <?php
                                                        $userid = $this->session->userdata('aileenuser');
                                                        $contition_array = array(
                                                            'user_id' => $userid,
                                                            'job_save' => '2',
                                                            'post_id ' => $post['post_id'],
                                                            'job_delete' => '1'
                                                        );
                                                        $jobsave = $this->data['jobsave'] = $this->common->select_data_by_condition('job_apply', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                                                        if ($jobsave) {
                                                            ?>
                                                            <a class="btn4 saved save_saved_btn">Saved</a>
                                                        <?php } else { ?>
                                                            <a title="Save" id="<?php echo $post['post_id']; ?>" onClick="savepopup(<?php echo $post['post_id'] ?>)" href="javascript:void(0);" class="savedpost<?php echo $post['post_id']; ?> btn4 save_saved_btn">Save</a>
                                                        <?php } ?>
                                                        <a href="javascript:void(0);"  class= "applypost<?php echo $post['post_id']; ?>  btn4" onclick="applypopup(<?php echo $post['post_id'] ?>,<?php echo $post['user_id'] ?>)">Apply</a>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                
                                            </p>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="art-img-nn">
                                <div class="art_no_post_img">
                                    <img src="<?php echo base_url() . 'assets/img/job-no.png'; ?>" alt="nojobimage">
                                </div>
                                <div class="art_no_post_text">
                                    No  Post Available.
                                </div>
                            </div>
                        <?php } ?>
                    </div>
					
					

                </div>
            </div>
            <!-- MIDDLE SECTION END -->
        </section>
        <!-- END CONTAINER -->

        <!-- BEGIN FOOTER -->
        <!--PROFILE PIC MODEL START-->
        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>      
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">

                                <div class="fw" id="profi_loader"  style="display:none;" style="text-align:center;" ><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="loaderimage"/></div>
                                <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                                    <div class="col-md-5">
                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one" >
                                    </div>

                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="display:none;" style="width:350px"></div>
                                    </div>
                                    <input type="submit" class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                </form>

                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Model Popup Open -->
        <!-- Bid-modal  -->
        <div class="modal message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <!--PROFILE PIC MODEL END-->

        <!-- Register -modal  -->
        <div class="modal fade message-box login register-model" id="job_reg" role="dialog">
            <div class="modal-dialog modal-lm" >
                <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <div class="">
                        <?php
                            if ($this->uri->segment(3) == 'live-post') {
                                echo '<div class="alert alert-success">Your post will be automatically apply successfully after completing this step...!</div>';
                            }
                        ?>
                         <div class="common-form job_reg_main">
                            <h3>Welcome in Job Profile</h3>
                            <?php echo form_open(base_url('job/job_insert_popup'), array('id' => 'jobseeker_regform', 'name' => 'jobseeker_regform', 'class' => 'clearfix')); ?>
                            <input type="hidden" value="" name="job_save" id="job_save">
                            <input type="hidden" value="" name="job_apply" id="job_apply">
                            <input type="hidden" value="" name="job_apply_userid" id="job_apply_userid">
                            <fieldset>
                               <label >First Name <font  color="red">*</font> :</label>
                                 <?php     if ($livepost) { ?>
                                             <input type="hidden" name="livepost" id="livepost" tabindex="5"  value="<?php echo $livepost;?>">
                                        <?php    }
                                            ?>
                               <input type="text" name="first_name" id="first_name" tabindex="1" placeholder="Enter your First Name" style="text-transform: capitalize;" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value" value="<?php echo $userdata['first_name'];?>" maxlength="35">
                               <?php echo form_error('first_name');; ?>
                            </fieldset>
                            <fieldset>
                               <label >Last Name <font  color="red">*</font>:</label>
                               <input type="text" name="last_name" id="last_name" tabindex="2" placeholder="Enter your Last Name" style="text-transform: capitalize;" onfocus="this.value = this.value;" value="<?php echo $userdata['last_name'];?>" maxlength="35">
                               <?php echo form_error('last_name');; ?>
                            </fieldset>
                            <fieldset class="full-width vali_er">
                               <label >Email Address <font  color="red">*</font> :</label>
                               <input type="email" name="email" id="email" tabindex="3" placeholder="Enter your Email Address" value="<?php echo $userdata['email'];?>" maxlength="255">
                                <span class="email_note"><b>Note:-</b> Related notification email will be send on provided email address kindly use regular  email address.<div></div></span>
                               <?php echo form_error('email');; ?>
                            </fieldset>
                            <fieldset class="fresher_radio col-xs-12" >
                               <label>Fresher <font  color="red">*</font> : </label>
                               <div class="main_raio">
                                  <input type="radio" value="Fresher" tabindex="4" id="test1" name="fresher" class="radio_job" id="fresher" onclick="not_experience()">
                                  <label for="test1" class="point_radio" >Yes</label>
                               </div>

                               <div class="main_raio">
                                  <input type="radio"  value="Experience" tabindex="5" id="test2" class="radio_job" name="fresher" id="fresher" onclick="experience()">
                                  <label for="test2" class="point_radio">No</label>
                               </div>
                               <div class="fresher-error"><?php echo form_error('fresher'); ?></div>
                            </fieldset>
                            <fieldset class="full-width">
                                <div id="exp_data" style="display:none;">
                                   <label>Total Experience<span class="red">*</span>:</label>
                                      <select style="width: 45%; margin-right: 4%; float: left;" tabindex="6" autofocus name="experience_year" id="experience_year" tabindex="1" class="experience_year keyskil" onchange="expyear_change();">
                                         <option value="" selected option disabled>Year</option>
                                         <option value="0 year">0 year</option>
                                         <option value="1 year">1 year</option>
                                         <option value="2 year" >2 year</option>
                                         <option value="3 year" >3 year</option>
                                         <option value="4 year">4 year</option>
                                         <option value="5 year">5 year</option>
                                         <option value="6 year">6 year</option>
                                         <option value="7 year">7 year</option>
                                         <option value="8 year">8 year</option>
                                         <option value="9 year">9 year</option>
                                         <option value="10 year">10 year</option>
                                         <option value="11 year" >11 year</option>
                                         <option value="12 year">12 year</option>
                                         <option value="13 year">13 year</option>
                                         <option value="14 year">14 year</option>
                                         <option value="15 year">15 year</option>
                                         <option value="16 year">16 year</option>
                                         <option value="17 year">17 year</option>
                                         <option value="18 year">18 year</option>
                                         <option value="19 year">19 year</option>
                                         <option value="20 year">20 year</option>
                                      </select>
                                                      
                                      <select style="width: 45%;" name="experience_month" tabindex="7"   id="experience_month" class="experience_month keyskil" onclick="expmonth_click();">
                                         <option value="" selected option disabled>Month</option>
                                         <option value="0 month">0 month</option>
                                         <option value="1 month">1 month</option>
                                         <option value="2 month">2 month</option>
                                         <option value="3 month">3 month</option>
                                         <option value="4 month">4 month</option>
                                         <option value="5 month">5 month</option>
                                         <option value="6 month">6 month</option>
                                         <option value="7 month">7 month</option>
                                         <option value="8 month">8 month</option>
                                         <option value="9 month">9 month</option>
                                         <option value="10 month">10 month</option>
                                         <option value="11 month">11 month</option>
                                         <option value="12 month">12 month</option>
                                      </select>
                                      <?php echo form_error('experience_month'); ?>
                                </div>
                            </fieldset>
                            <fieldset class="full-width">
                               <label >Job Title<font  color="red">*</font> :</label>
                               <input type="search" tabindex="8" id="job_title" name="job_title" value="" placeholder="Ex:- Sr. Engineer, Jr. Engineer, Software Developer, Account Manager" style="text-transform: capitalize;" onfocus="this.value = this.value;" maxlength="255">
                               <?php echo form_error('job_title'); ?>
                            </fieldset>
                            <fieldset class="full-width fresher_select main_select_data" >
                               <label for="skills"> Skills<font  color="red">*</font> : </label>
                               <input id="skills2" style="text-transform: capitalize;" name="skills" tabindex="9"  size="90" placeholder="Enter SKills">
                               <?php echo form_error('skills'); ?>
                            </fieldset>
                            <fieldset class="full-width main_select_data">
                               <label>Industry <font  color="red">*</font> :</label>
                               <span>
                               <select name="industry" id="industry" tabindex="10">
                                  <option value="" selected="selected">Select industry</option>
                                  <?php foreach ($industry as $indu) { ?>
                                  <option value="<?php echo $indu['industry_id']; ?>"><?php echo $indu['industry_name']; ?></option>
                                  <?php } ?>
                                   <option value="<?php echo $other_industry[0]['industry_id']; ?>"><?php echo $other_industry[0]['industry_name']; ?></option>
                               </select>
                             </span>
                               <?php echo form_error('industry');; ?>
                            </fieldset>
                            <fieldset class="full-width fresher_select main_select_data" >
                               <label for="cities">Preffered location for job<font  color="red">*</font> : </label>
                               <input id="cities2" name="cities"  style="text-transform: capitalize;" size="90" tabindex="11" placeholder="Enter Preferred Cites">
                               <?php echo form_error('cities');; ?>
                            </fieldset>
                            <fieldset class=" full-width">
                               <div class="job_reg">
                            
                                  <!-- <input title="Register" type="submit" id="submit" name="" value="Register" tabindex="12"> -->
                                  <button id="submit" name="" class="cus_btn_sub" tabindex="12">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                               </div>
                            </fieldset>
                            <?php echo form_close();?>
                         </div>
                      </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Popup Close -->
        <!-- START FOOTER -->
        <!-- <footer> -->
        </div>
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <!-- </footer> -->
        <!-- END FOOTER -->


        <!-- FIELD VALIDATION JS START -->
        <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>  
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <?php
        /*if (IS_REC_JS_MINIFY == '0') {
            ?>
            <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>  
            <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
              <script src="<?php echo base_url('assets/js_min/croppie.js'); ?>"></script>  
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js'); ?>"></script>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <?php }*/ ?>

        <?php
        if (IS_JOB_JS_MINIFY == '0') {
            ?>

        <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
            <script src="<?php echo base_url('assets/js/webpage/recruiter/search.js'); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js/webpage/job/search_common.js?ver=' . time()); ?>"></script>
        <?php } ?>

        <?php }else{?>
        <?php if ($this->session->userdata('aileenuser') == $recliveid) { ?>
            <script src="<?php echo base_url('assets/js_min/webpage/recruiter/search.js'); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/webpage/job/search_common.js?ver=' . time()); ?>"></script>
        <?php } ?>
        
        <?php }?>
        <script>
        var base_url = '<?php echo base_url(); ?>';
        var data1 = <?php echo json_encode($de); ?>;
        var data = <?php echo json_encode($demo); ?>;
        var get_csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var get_csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var id = '<?php echo $this->uri->segment(3); ?>';
        var return_page = '<?php echo $_GET['page']; ?>';
        var header_all_profile = '<?php echo $header_all_profile; ?>';
        var login_user_id = "<?php echo $userid_login; ?>";
        var job_profile_set = "<?php echo $this->job_profile_set; ?>";
        var job_deactive = "<?php echo $job_deactive; ?>";

        function removepopup(id)
        {
            $('.biderror .mes').html("<div class='pop_content'>Do you want to remove this post?<div class='model_ok_cancel'><a class='okbtn' id=" + id + " onClick='remove_post(" + id + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
            $('#bidmodal').modal('show');
        }

        //remove post start
        function remove_post(abc)
        {
            $.ajax({
                type: 'POST',
                url: base_url + 'recruiter/remove_post',
                data: 'post_id=' + abc,
                success: function (data) {

                    $('#' + 'removepost' + abc).html(data);
                    $('#' + 'removepost' + abc).removeClass();
                    var numItems = $('.contact-frnd-post .job-contact-frnd .profile-job-post-detail').length;

                    if (numItems == '0') {

                        var nodataHtml = "<div class='art-img-nn'><div class='art_no_post_img'><img src='" + base_url + "img/job-no.png' alt='nojobimage'/></div><div class='art_no_post_text'> No Post Available.</div></div>";
                        $('.contact-frnd-post').html(nodataHtml);
                    }
                }
            });
        }

        //apply post start
        function applypopup(postid, userid)
        {
            if(job_profile_set == 0 && login_user_id != "")
            {
                $("#job_apply").val(postid);
                $("#job_apply_userid").val(userid);
                $("#job_save").val('');
                $('#job_reg').modal('show');
            }
            else
            {
                if(login_user_id == "" || job_deactive == 1)
                {                
                    if(login_user_id == "")
                        $('.biderror .mes').html("<div class='pop_content'>Please Login or Register.</div>");
                    else if(job_deactive == 1)
                        $('.biderror .mes').html("<div class='pop_content'>Please Reactive.</div>");
                    $('#bidmodal').modal('show');
                }
                else
                { 
                    $('.biderror .mes').html("<div class='pop_content'>Are you sure want to apply this  jobpost?<div class='model_ok_cancel'><a class='okbtn' id=" + postid + " onClick='apply_post(" + postid + "," + userid + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
                    $('#bidmodal').modal('show');
                }
            }
        }

        function apply_post(abc, xyz) {
            var alldata = 'all';
            var user = xyz;

            $.ajax({
                type: 'POST',
                url: base_url + 'job/job_apply_post',
                data: 'post_id=' + abc + '&allpost=' + alldata + '&userid=' + user,
                dataType: 'json',
                success: function (data) { 
                    $('.savedpost' + abc).hide();
                    $('.applypost' + abc).html(data.status);
                    $('.applypost' + abc).attr('disabled', 'disabled');
                    $('.applypost' + abc).attr('onclick', 'myFunction()');
                    $('.applypost' + abc).addClass('applied');

                    if (data.notification.notification_count != 0) {
                        var notification_count = data.notification.notification_count;
                        var to_id = data.notification.to_id;
                        show_header_notification(notification_count, to_id);
                    }

                }
            });
        }
        //apply post end

        //save post start 
        function savepopup(id) {
            if(job_profile_set == 0 && login_user_id != "")
            {
                $("#job_apply_userid").val('');
                $("#job_apply").val('');
                $("#job_save").val(id);
                $('#job_reg').modal('show');
            }
            else
            {
                if(login_user_id == "" || job_deactive == 1)
                {
                    if(login_user_id == "")
                        $('.biderror .mes').html("<div class='pop_content'>Please Login or Register.</div>");
                    else if(job_deactive == 1)
                        $('.biderror .mes').html("<div class='pop_content'>Please Reactive.</div>");
                    $('#bidmodal').modal('show');
                }
                else
                {
                    save_post(id);
                    $('.biderror .mes').html("<div class='pop_content cus-pop-mes'>Jobpost successfully saved.");
                    $('#bidmodal').modal('show');
                }
            }
        }

        function save_post(abc)
        {
            $.ajax({
                type: 'POST',
                url: base_url + 'job/job_save',
                data: 'post_id=' + abc,
                success: function (data) {
                    $('.' + 'savedpost' + abc).html(data).addClass('saved');
                }
            });

        }
        //save post End

        function experience(){
            document.getElementById('exp_data').style.display = 'block';
        }
           
        function not_experience(){
            var melement = document.getElementById('exp_data');
            if(melement.style.display == 'block'){
                melement.style.display = 'none';
                //value none if user have press yes button start
                $("#experience_year").val("");
                $("#experience_month").val("");
            }
        }
        function expyear_change()
        {
            var experience_year = document.querySelector("#experience_year").value;
            if (experience_year)
            {
                $('#experience_month').attr('disabled', false);
                var experience_year = document.getElementById('experience_year').value;
                if (experience_year === '0 year') {
                    $("#experience_month option[value='0 month']").attr('disabled', true);
                }
                else
                {
                    $("#experience_month option[value='0 month']").attr('disabled', false);
                }
            }
            else
            {
                $('#experience_month').attr('disabled', 'disabled');
            }
            // var element = document.getElementById("experience_year");
            // element.classList.add("valuechangecolor");
        }
        function expmonth_click()
        {
            // var element = document.getElementById("experience_month");
            //element.classList.add("valuechangecolor");              
        }
        $('#job_reg').on('hidden.bs.modal', function (e) {
            $("#job_apply").val('');
            $("#job_apply_userid").val('');
            $("#job_save").val('');
        });
        //validation start
        $(document).ready(function() {
            // $.validator.addMethod("lowercase", function(value, element, regexpr) {          
            //          return regexpr.test(value);
            //      }, "email Should be in Small Character");
            $.validator.addMethod("regx2", function(value, element, regexpr) {
                if (!value) {
                    return true;
                } else {
                    return regexpr.test(value);
                }
            }, "Special character and space not allow in the beginning");
            $.validator.addMethod("regx_digit", function(value, element, regexpr) {
                if (!value) {
                    return true;
                } else {
                    return regexpr.test(value);
                }
            }, "Digit is not allow");
            $.validator.addMethod("regx1", function(value, element, regexpr) {
                if (!value) {
                    return true;
                } else {
                    return regexpr.test(value);
                }
            }, "Only space, only number and only special characters are not allow");
            $("#jobseeker_regform").validate({
                ignore: '*:not([name])',
                rules: {
                    first_name: {
                        required: true,
                        regx2: /^[a-zA-Z0-9-.,']*[0-9a-zA-Z][a-zA-Z]*/,
                        regx_digit: /^([^0-9]*)$/,
                    },
                    last_name: {
                        required: true,
                        regx2: /^[a-zA-Z0-9-.,']*[0-9a-zA-Z][a-zA-Z]*/,
                        regx_digit: /^([^0-9]*)$/,
                    },
                    cities: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                        // lowercase: /^[0-9a-z\s\r\n@!#\$\^%&*()+=_\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/,
                        remote: {
                            url: base_url + "job/check_email",
                            //async is used for double click on submit avoid
                            async: false,
                            type: "post",
                        },
                    },
                    fresher: {
                        required: true,
                    },
                    job_title: {
                        required: true,
                        regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                    },
                    industry: {
                        required: true,
                    },
                    cities: {
                        required: true,
                        regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                    },
                    skills: {
                        required: true,
                        regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/,
                    },
                },
                messages: {
                    first_name: {
                        required: "First name is required.",
                    },
                    last_name: {
                        required: "Last name is required.",
                    },
                    email: {
                        required: "Email address is required.",
                        email: "Please enter valid email id.",
                        remote: "Email already exists"
                    },
                    fresher: {
                        required: "Fresher is required.",
                    },
                    industry: {
                        required: "Industry is required.",
                    },
                    cities: {
                        required: "City is required.",
                    },
                    job_title: {
                        required: "Job title is required.",
                    },
                    skills: {
                        required: "Skill is required.",
                    }
                },
                errorPlacement: function(error, element) {
                    //console.log(element);
                    if (element.attr("name") == "fresher" )
                        error.insertBefore(".fresher-error");            
                    else
                        error.insertAfter(element);
                },
            });
            
            $('#main_loader').hide();
            $('#main_page_load').show();
        });
        //BUTTON SUBMIT DISABLE AFTER SOME TIME START
        $("#submit").on('click', function() {
            if (!$('#jobseeker_regform').valid()) {
                return false;
            } else {
                $("#submit").addClass("register_disable");
                return true;
            }
        });
        //BUTTON SUBMIT DISABLE AFTER SOME TIME END
        </script>
        <script src="<?php echo base_url('assets/js/webpage/job-live/searchJob.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_job_reg&skill.js?ver='.time()); ?>"></script>
    </body>
</html>