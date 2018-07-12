<!DOCTYPE html>
<html lang="en" ng-app="FARecommendedProject" ng-controller="FARecommendedProjectController">
<?php $userid = $this->session->userdata('aileenuser');
$fa_slug = $this->db->select('freelancer_apply_slug')->get_where('freelancer_post_reg', array('user_id' => $userid, 'status' => '1'))->row()->freelancer_apply_slug;
?>
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <?php echo $head; ?> 
        <?php
        if (IS_APPLY_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-apply.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/freelancer-apply.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
         <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
         <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="">
        <?php //echo $header; ?>
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: none;">
        <?php echo $freelancer_post_header2; ?>
        <section>
            <div class="user-midd-section " id="paddingtop_fixed">
                <div class="container padding-360">
                    <div class="row4">
                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt">
                            <div class="">
                                <div class="full-box-module">   
                                    <div class="profile-boxProfileCard  module">
                                        <div class="profile-boxProfileCard-cover"> 
                                            <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                               href="<?php echo base_url('freelancer/').$fa_slug; ?>"
                                               tabindex="-1"
                                               aria-hidden="true"
                                               rel="noopener">
                                                   <?php
                                                   if ($freelancerdata[0]['profile_background'] != '') {
                                                       ?>
                                                    <div class="data_img">
                                                        <img src="<?php echo FREE_POST_BG_THUMB_UPLOAD_URL . $freelancerdata[0]['profile_background']; ?>" class="bgImage" alt="<?php echo $freelancerdata[0]['freelancer_post_fullname'] . "" . $freelancerdata[0]['freelancer_post_username']; ?>" >
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="data_img bg-images no-cover-upload">
                                                        <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="No Image"  >
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </a>
                                        </div>
                                        <div class="profile-boxProfileCard-content clearfix">
                                            <div class="left_side_box_img buisness-profile-txext">
                                                <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock" 
                                                   href="<?php echo base_url('freelancer/').$fa_slug; ?>" title="<?php echo $freelancerdata[0]['freelancer_post_fullname'] . ' ' . $freelancerdata[0]['freelancer_post_username']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                                       <?php
                                                       $filename = $this->config->item('free_post_profile_main_upload_path') . $freelancerdata[0]['freelancer_post_user_image'];
                                                       $s3 = new S3(awsAccessKey, awsSecretKey);
                                                       $info = $s3->getObjectInfo(bucket, $filename);
                                                       if ($info) {
                                                           ?>
                                                        <img src="<?php echo FREE_POST_PROFILE_MAIN_UPLOAD_URL . $freelancerdata[0]['freelancer_post_user_image']; ?>" alt="<?php echo $freelancerdata[0]['freelancer_post_fullname'] . ' ' . $freelancerdata[0]['freelancer_post_username']; ?>" >
                                                        <?php
                                                    } else {
                                                        $fname = $freelancerdata[0]['freelancer_post_fullname'];
                                                        $lname = $freelancerdata[0]['freelancer_post_username'];
                                                        $sub_fname = substr($fname, 0, 1);
                                                        $sub_lname = substr($lname, 0, 1);
                                                        ?>
                                                        <div class="post-img-profile">
                                                            <?php echo ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)); ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                            <div class="right_left_box_design">
                                                <span class="profile-company-name">
                                                    <a href="<?php echo base_url('freelancer/').$fa_slug; ?>"><?php echo ucwords($freelancerdata[0]['freelancer_post_fullname']) . ' ' . ucwords($freelancerdata[0]['freelancer_post_username']); ?></a>
                                                </span>
                                                <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                                                <div class="profile-boxProfile-name">
                                                    <a  href="<?php echo base_url('freelancer/').$fa_slug; ?>"><?php
                                                        if ($freepostdata['designation']) {
                                                            echo ucwords($freepostdata['designation']);
                                                        } else {
                                                            echo $this->lang->line("designation");
                                                        }
                                                        ?></a>
                                                </div>
                                                <ul class=" left_box_menubar">
                                                    <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'freelancer-details')) { ?> class="active" <?php } ?>><a  class="padding_less_left"  title="freelancer Details" href="<?php echo base_url('freelancer/').$fa_slug; ?>"><?php echo $this->lang->line("details"); ?></a>
                                                    </li>
                                                    <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'saved-projects')) { ?> class="active" <?php } ?>><a title="Saved Post" href="<?php echo base_url('freelancer/saved-projects'); ?>"><?php echo $this->lang->line("saved"); ?></a>
                                                    </li>
                                                    <li <?php if (($this->uri->segment(1) == 'freelance-work') && ($this->uri->segment(2) == 'applied-projects')) { ?> class="active" <?php } ?>><a title="Applied Post"  class="padding_less_right"  href="<?php echo base_url('freelancer/applied-projects'); ?>"><?php echo $this->lang->line("applied"); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>                             
                                </div>
                                <form name="job-company-filter" id="job-company-filter">
                        
                                    <div class="left-search-box">
                                        <div class="">
                                            <h3>Top Fields</h3>
                                        </div>
                                        <ul class="search-listing custom-scroll">
                                            <li ng-repeat="category in FAFields">
                                                <label class="control control--checkbox"><span ng-bind="category.category_name | capitalize"></span>
                                                    <input type="checkbox" class="category-filter" ng-model="cat_fil" name="category[]" ng-value="{{category.category_id}}" ng-change="applyJobFilter()"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                        </ul>
                                        <p class="text-left p10"><a href="<?php echo base_url(); ?>freelance-jobs-by-fields">View More Fields</a></p>
                                    </div>
                                    
                                    <div class="left-search-box">
                                        <div class="">
                                            <h3>Top Categories</h3>
                                        </div>
                                        <ul class="search-listing custom-scroll">
                                            <li ng-repeat="skill in FASkills">
                                                <label class="control control--checkbox"><span ng-bind="skill.skill | capitalize"></span>
                                                    <input type="checkbox" class="skills-filter" ng-model="skills_fil" name="skill[]" ng-value="{{skill.skill_id}}" ng-change="applyJobFilter()"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                        </ul>
                                        <p class="text-left p10"><a href="<?php echo base_url(); ?>freelance-jobs-by-categories">View More Categories</a></p>
                                    </div>

                                    <div class="left-search-box">
                                        <div class="accordion" id="accordion2">
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" aria-expanded="true">Work Type</a></h3>
                                                </div>
                                                <div id="collapseOne" class="accordion-body collapse in" aria-expanded="true" style="">
                                                    <ul class="search-listing">
                                                        <li>
                                                            <label class="control control--checkbox">Hourly
                                                                <input type="checkbox" ng-value="1" class="worktype-filter" ng-model="worktype1" name="worktype[]" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">Fixed
                                                                <input type="checkbox" ng-value="2" class="worktype-filter" ng-model="worktype2" name="worktype[]" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="left-search-box">
                                        <div class="accordion" id="accordion2">
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" aria-expanded="true">Posting Period</a></h3>
                                                </div>
                                                <div id="collapseTwo" class="accordion-body collapse in" aria-expanded="true" style="">
                                                    <ul class="search-listing">
                                                        <li>
                                                            <label class="control control--checkbox">Today
                                                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="1" ng-model="post_period1" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">Last 7 Days
                                                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="2" ng-model="post_period2" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">Last 15 Days
                                                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="3" ng-model="post_period3" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">Last 45 Days
                                                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="4" ng-model="post_period4" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">More than 45 Days
                                                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="5" ng-model="post_period5" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="left-search-box">
                                        <div class="accordion" id="accordion3">
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsetwo" aria-expanded="true">Required Experience</a></h3>
                                                </div>
                                                <div id="collapsetwo" class="accordion-body collapse in" aria-expanded="true" style="">
                                                    <div class="accordion-inner">
                                                        <ul class="search-listing">
                                                            <li>
                                                                <label class="control control--checkbox">0 to 1 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="1" ng-model="exp1" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="control control--checkbox">1 to 2 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="2" ng-model="exp2" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="control control--checkbox">2 to 3 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="3" ng-model="exp3" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="control control--checkbox">3 to 4 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="4" ng-model="exp4" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="control control--checkbox">4 to 5 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="5" ng-model="exp5" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="control control--checkbox">More than 5 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="6" ng-model="exp6" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                    
                                </form>

                                <?php echo $left_footer; ?>
                            </div>
                        </div>
                        <!-- cover pic end -->
                        <div class="custom-right-art mian_middle_post_box animated fadeInUp cust-inner-part">
                            <?php if ($this->uri->segment(3) == 'live-post') { ?>

                                <div>
                                    <?php
                                    if ($this->session->flashdata('error')) {

                                        echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>';
                                    }
                                    if ($this->session->flashdata('success')) {

                                        echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>';
                                    }
                                    ?>
                                </div>

                                <?php
                            }
                            ?>
                            <div class="page-title">
                                <h3>Recommended Projects</h3>
                            </div>

                            <div class="job-contact-frnd1">
                                <div class="user_no_post_avl ng-scope" ng-if="freepostapply.length == 0">
                                    <div class="user-img-nn">
                                        <div class="user_no_post_img">
                                            <img src="<?php echo base_url('assets/img/no-post.png?ver=time()');?>" alt="bui-no.png">
                                        </div>
                                        <div class="art_no_post_text">No Projects Available.</div>
                                    </div>
                                </div>
                                <div class="all-job-box freelance-recommended-post" ng-repeat="applypost in freepostapply">
                                    <div class="all-job-top">
                                        <div class="job-top-detail">
                                            <h5><a href="<?php echo base_url(); ?>freelance-jobs/{{applypost.industry_name}}/{{applypost.post_slug}}-{{applypost.user_id}}-{{applypost.post_id}}">{{applypost.post_name}}
                                                <span ng-if="applypost.day_remain > 0">({{applypost.day_remain}} days left)</span>
                                                </a>
                                            </h5>
                                            <p><a href="<?php echo base_url(); ?>freelance-jobs/{{applypost.industry_name}}/{{applypost.post_slug}}-{{applypost.user_id}}-{{applypost.post_id}}">{{applypost.fullname | capitalize}}</a></p>
                                            <p ng-if="applypost.post_rate != ''">Budget : {{applypost.post_rate}} {{applypost.post_currency}} (hourly/fixed)</p>
                                        </div>
                                    </div>
                                    <div class="all-job-middle">
                                        <p class="pb5">
                                            <span class="location" ng-if="applypost.city || applypost.country">
                                                <!-- IF BOTH DATA AVAILABLE OF COUNTRY AND CITY -->
                                                <span ng-if="applypost.city && applypost.country">
                                                    <img class="pr5" src="<?php echo base_url('assets/img/location.png?ver=' . time()) ?>">{{ applypost.city }},({{ applypost.country }})
                                                </span>
                                                <!-- IF ONLY CITY AVAILABLE -->
                                                <span ng-if="applypost.city && !applypost.country">
                                                    <img class="pr5" src="<?php echo base_url('assets/img/location.png?ver=' . time()) ?>">{{ applypost.city }}
                                                </span>
                                                <!-- IF ONLY COUNTRY AVAILABLE -->
                                                <span ng-if="!applypost.city && applypost.country">
                                                    <img class="pr5" src="<?php echo base_url('assets/img/location.png?ver=' . time()) ?>">{{applypost.country}}
                                                </span>
                                            </span>
                                            <span class="exp">
                                                <span>
                                                    <img class="pr5" src="<?php echo base_url('assets/img/exp.png?ver=' . time()) ?>">
                                                    Skils: <span dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{applypost.post_skill}}" dd-text-collapse-cond="false">
                                                    </span>
                                                </span>
                                            </span>
                                        </p>                                
                                        <p dd-text-collapse dd-text-collapse-max-length="100" dd-text-collapse-text="{{applypost.post_description}}" dd-text-collapse-cond="false">
                                        </p>
                                        <p ng-if="applypost.industry_name != '' ">
                                            Categories : <span>{{applypost.industry_name}}</span>
                                        </p>
                                    </div>
                                    <div class="all-job-bottom">
                                        <p class="pull-left hw-479"><span>Applied Persons: {{applypost.ShortListedCount}}</span>
                                        <span class="pl20">Shortlisted Persons: {{applypost.AppliedCount}}</span>
										</p>
                                        <p class="pull-right" ng-if="applypost.apply_post == 1">
                                            <a href="javascript:void(0);" class="btn4 applied">Applied</a>
                                        </p>
                                        <p class="pull-right" ng-if="applypost.apply_post == 0 && applypost.saved_post == 1">
                                            <a href="javascript:void(0);" class="btn4 saved">Saved</a>
                                            <a href="javascript:void(0)" ng-click="applypopup(applypost.post_id,applypost.user_id)" class="btn4 applypost{{applypost.post_id}}">Apply</a>
                                        </p>
                                        <p class="pull-right" ng-if="applypost.apply_post == 0 && applypost.saved_post == 0">
                                            <?php if($userid_login != "" && $this->freelance_apply_profile_set == 0): ?>
                                                <a href="<?php echo base_url('freelance-work/profile/live-post/'); ?>{{applypost.post_id}}" class="btn4">Save</a>
                                                <a href="<?php echo base_url('freelance-work/profile/live-post/'); ?>{{applypost.post_id}}" class="btn4">Apply</a>
                                            <?php else: ?>
                                                <a href="javascript:void(0)" ng-click="savepopup(applypost.post_id)" class="btn4 savedpost{{applypost.post_id}}">Save</a>
                                                <a href="javascript:void(0)" ng-click="applypopup(applypost.post_id,applypost.user_id)" class="btn4 applypost{{applypost.post_id}}">Apply</a>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <div id="loader" style="display:none;"><p style="text-align:center;"><img alt="loader" src="<?php echo base_url('assets/images/loading.gif'); ?>"/></p></div>
                        </div>

                        <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                            
                            <div class="edi_origde">
                                    <?php
                                    
                                    if ($count_profile == 100) {
                                        if ($freepostdata[0]['progressbar'] == 0) {
                                            ?>
                                            <div class="edit_profile_progress complete_profile">
                                                <div class="progre_bar_text">
                                                    <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
                                                </div>
                                                <div class="count_main_progress">
                                                    <div class="circles">
                                                        <div class="second circle-1 ">
                                                            <div class="true_progtree">
                                                                <img alt="Completed" src="<?php echo base_url("assets/img/true.png"); ?>">
                                                            </div>
                                                            <div class="tr_text">
                                                                Successfully Completed
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="edit_profile_progress">
                                            <div class="progre_bar_text">
                                                <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
                                            </div>
                                            <div class="count_main_progress">
                                                <div class="circles">
                                                    <div class="second circle-1">
                                                        <div>
                                                            <strong></strong>

                                                            <a href="<?php echo base_url('freelancer/basic-information') ?>" class="edit_profile_job">Edit Profile</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            

                        </div>

                    </div>
                </div>
            </div>
        </section>
        </div>
        <?php echo $footer; ?>
		<div>
			<div class="mob-filter" data-target="#filter" data-toggle="modal">
				<svg width="25.000000pt" height="25.000000pt" viewBox="0 0 300.000000 300.000000">
					<g transform="translate(0.000000,300.000000) scale(0.100000,-0.100000)"
					fill="#1b8ab9" stroke="none">
					<path d="M489 2781 l-29 -29 0 -221 0 -221 -110 0 c-115 0 -161 -12 -174 -45
					-3 -9 -6 -163 -6 -341 l0 -325 25 -24 c23 -24 30 -25 144 -25 l121 0 2 -646 3
					-646 24 -19 c33 -27 92 -25 119 4 l22 23 0 642 0 642 124 0 c107 0 127 3 147
					19 l24 19 3 331 3 332 -30 29 c-29 30 -30 30 -150 30 l-121 0 0 225 0 226 -25
					24 c-34 35 -78 33 -116 -4z m271 -851 l0 -210 -210 0 -210 0 0 210 0 210 210
					0 210 0 0 -210z"/>
					<path d="M1445 2785 l-25 -24 0 -641 0 -640 -119 0 c-105 0 -121 -2 -145 -21
					l-26 -20 0 -338 0 -338 23 -21 c21 -20 34 -22 145 -22 l122 0 0 -224 c0 -211
					1 -225 21 -250 16 -21 29 -26 64 -26 35 0 48 5 64 26 20 25 21 39 21 250 l0
					224 123 0 c181 0 167 -33 167 382 l0 337 -26 20 c-24 19 -40 21 -145 21 l-119
					0 0 640 0 641 -25 24 c-33 34 -87 34 -120 0z m275 -1685 l0 -210 -215 0 -215
					0 0 210 0 210 215 0 215 0 0 -210z"/>
					<path d="M2405 2785 l-25 -24 0 -226 0 -225 -121 0 c-120 0 -121 0 -150 -30
					l-30 -29 3 -332 3 -331 24 -19 c20 -16 40 -19 147 -19 l124 0 0 -643 0 -644
					23 -21 c29 -28 86 -29 118 -3 l24 19 3 646 2 646 121 0 c114 0 121 1 144 25
					l25 24 0 325 c0 178 -3 332 -6 341 -13 33 -59 45 -174 45 l-110 0 0 221 0 221
					-29 29 c-38 37 -82 39 -116 4z m265 -855 l0 -210 -210 0 -210 0 0 210 0 210
					210 0 210 0 0 -210z"/>
					</g>
					</svg>
			</div>
		</div>
		<div id="filter" class="modal mob-modal fade" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="mid-modal-body">
						<div class="mid-modal-body">
							<form name="job-company-filter" id="job-company-filter">
                        
                                    <div class="left-search-box">
                                        <div class="">
                                            <h3>Top Fields</h3>
                                        </div>
                                        <ul class="search-listing custom-scroll">
                                            <li ng-repeat="category in FAFields">
                                                <label class="control control--checkbox"><span ng-bind="category.category_name | capitalize"></span>
                                                    <input type="checkbox" class="category-filter" ng-model="cat_fil" name="category[]" ng-value="{{category.category_id}}" ng-change="applyJobFilter()"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                        </ul>
                                        <p class="text-left p10"><a href="<?php echo base_url(); ?>freelance-jobs-by-fields">View More Fields</a></p>
                                    </div>
                                    
                                    <div class="left-search-box">
                                        <div class="">
                                            <h3>Top Categories</h3>
                                        </div>
                                        <ul class="search-listing custom-scroll">
                                            <li ng-repeat="skill in FASkills">
                                                <label class="control control--checkbox"><span ng-bind="skill.skill | capitalize"></span>
                                                    <input type="checkbox" class="skills-filter" ng-model="skills_fil" name="skill[]" ng-value="{{skill.skill_id}}" ng-change="applyJobFilter()"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                        </ul>
                                        <p class="text-left p10"><a href="<?php echo base_url(); ?>freelance-jobs-by-categories">View More Categories</a></p>
                                    </div>

                                    <div class="left-search-box">
                                        <div class="accordion" id="accordion2">
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" aria-expanded="true">Work Type</a></h3>
                                                </div>
                                                <div id="collapseOne" class="accordion-body collapse in" aria-expanded="true" style="">
                                                    <ul class="search-listing">
                                                        <li>
                                                            <label class="control control--checkbox">Hourly
                                                                <input type="checkbox" ng-value="1" class="worktype-filter" ng-model="worktype1" name="worktype[]" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">Fixed
                                                                <input type="checkbox" ng-value="2" class="worktype-filter" ng-model="worktype2" name="worktype[]" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="left-search-box">
                                        <div class="accordion" id="accordion2">
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" aria-expanded="true">Posting Period</a></h3>
                                                </div>
                                                <div id="collapseOne" class="accordion-body collapse in" aria-expanded="true" style="">
                                                    <ul class="search-listing">
                                                        <li>
                                                            <label class="control control--checkbox">Today
                                                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="1" ng-model="post_period1" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">Last 7 Days
                                                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="2" ng-model="post_period2" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">Last 15 Days
                                                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="3" ng-model="post_period3" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">Last 45 Days
                                                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="4" ng-model="post_period4" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="control control--checkbox">More than 45 Days
                                                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="5" ng-model="post_period5" ng-change="applyJobFilter()">
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="left-search-box">
                                        <div class="accordion" id="accordion3">
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsetwo" aria-expanded="true">Required Experience</a></h3>
                                                </div>
                                                <div id="collapsetwo" class="accordion-body collapse in" aria-expanded="true" style="">
                                                    <div class="accordion-inner">
                                                        <ul class="search-listing">
                                                            <li>
                                                                <label class="control control--checkbox">0 to 1 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="1" ng-model="exp1" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="control control--checkbox">1 to 2 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="2" ng-model="exp2" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="control control--checkbox">2 to 3 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="3" ng-model="exp3" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="control control--checkbox">3 to 4 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="4" ng-model="exp4" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="control control--checkbox">4 to 5 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="5" ng-model="exp5" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="control control--checkbox">More than 5 year
                                                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="6" ng-model="exp6" ng-change="applyJobFilter()">
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                    
                                </form>
						</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
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
        <?php
        if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <!-- <script async src="<?php // echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script> -->
            <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <!-- <script async src="<?php // echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script> -->
            <script type="text/javascript" src="<?php echo base_url('assets/js_min/progressloader.js?ver=' . time()); ?>"></script>
        <?php } ?>        
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>

        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
        
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>


        <script type="text/javascript">
            $(".alert").delay(3200).fadeOut(300);
            var base_url = '<?php echo base_url(); ?>';
            var count_profile_value = '<?php echo $count_profile_value; ?>';
            var count_profile = '<?php echo $count_profile; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var title = '<?php echo $title; ?>';
            var login_user_id = '<?php echo $userid; ?>';
            var fa_profile_set = '<?php echo $this->freelance_apply_profile_set; ?>';
            var app = angular.module('FARecommendedProject', ['ui.bootstrap']);
        </script>

        <script  src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <!-- <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/post_apply.js?ver=' . time()); ?>"></script> -->
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/progressbar.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply-live/post_apply_new.js?ver=' . time()); ?>"></script>
        <?php
        /*if (IS_APPLY_JS_MINIFY == '0') {
            ?>
            <script  src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/post_apply.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/progressbar.js?ver=' . time()); ?>"></script>
            <?php
        } else {
            ?>
            <script  src="<?php echo base_url('assets/js_min/croppie.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/post_apply.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/freelancer_apply_common.js?ver=' . time()); ?>"></script>
            <script async type="text/javascript" src="<?php echo base_url('assets/js_min/webpage/freelancer-apply/progressbar.js?ver=' . time()); ?>"></script>
        <?php }*/ ?>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
    </body>               
</html>