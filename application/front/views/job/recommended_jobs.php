<!DOCTYPE html>
<?php $userid_login = $this->session->userdata('aileenuser');
// print_r($jobdata);exit;

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
<html lang="en" ng-app="recommendedJobs" ng-controller="recommendedJobsController">
    <head>
        <title ng-bind="title"></title>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php //echo $head; ?>        
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">        
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <style type="text/css">
          .ui-autocomplete {
            background: #fff;
            z-index: 99999!important;
        }
</style>
    </head>
    <body class="profile-main-page">    
        <?php echo $job_header2; ?>
        <div class="middle-section">
            
            <div class="container pt20">
                <div class="left-part">
                    <div class="full-box-module">
                        <div class="profile-boxProfileCard  module">
                            <div class="profile-boxProfileCard-cover <?php
                            if ($jobdata[0]['profile_background'] == '') {
                                echo "bg-images no-cover-upload";
                            }
                            ?>">
                                <a class="profile-boxProfileCard-bg u-bgUserColor a-block"
                                   href="<?php echo base_url('job-profile/' . $jobdata[0]['slug']); ?>"
                                   tabindex="-1"
                                   aria-hidden="true"
                                   rel="noopener" title="job resume">
                                       <?php
                                       if ($jobdata[0]['profile_background'] != '') {
                                           ?>
                                        <!-- box image start -->
                                        <img src="<?php echo JOB_BG_MAIN_UPLOAD_URL . $jobdata[0]['profile_background']; ?>" class="bgImage" alt="<?php echo $jobdata[0]['profile_background']; ?>" >
                                        <!-- box image end -->
                                        <?php
                                    } else {
                                        ?>
                                        <img src="<?php echo base_url(WHITEIMAGE); ?>" class="bgImage" alt="<?php echo 'NOIMAGE'; ?>">
                                        <?php
                                    }
                                    ?>
                                </a>
                            </div>
                            <div class="profile-boxProfileCard-content clearfix">
                                <div class="left_side_box_img buisness-profile-txext">
                                    <a class="profile-boxProfilebuisness-avatarLink2 a-inlineBlock"  href="<?php echo base_url('job-profile/' . $jobdata[0]['slug']); ?>" title="<?php echo $jobdata[0]['fname']; ?>" tabindex="-1" aria-hidden="true" rel="noopener">
                                        <?php
                                        if ($jobdata[0]['job_user_image']) {
                                            ?>
                                            <div class="left_iner_img_profile"><img src="<?php echo JOB_PROFILE_THUMB_UPLOAD_URL . $jobdata[0]['job_user_image']; ?>" alt="<?php echo $jobdata[0]['fname']; ?>" ></div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="data_img_2">
                                                <?php
                                                $a = $jobdata[0]['fname'];
                                                $acronym = substr($a, 0, 1);
                                                $b = $jobdata[0]['lname'];
                                                $acronym1 = substr($b, 0, 1);
                                                ?>
                                                <div class="post-img-profile">
                                                <?php echo ucfirst(strtolower($acronym)) . ucfirst(strtolower($acronym1)); ?>
                                                </div>
                                            </div>
                                                <?php
                                            }
                                            ?>
                                    </a>
                                </div>
                                <div class="right_left_box_design ">
                                    <span class="profile-company-name ">
                                        <span class="profile-company-name ">
                                            <a   href="<?php echo site_url('job-profile/' . $jobdata[0]['slug']); ?>" title="<?php echo $jobdata[0]['slug']; ?>">  <?php echo ucfirst($jobdata[0]['fname']) . ' ' . ucfirst($jobdata[0]['lname']); ?></a>
                                        </span>
                                    </span>
                                    <?php $category = $this->db->get_where('industry_type', array('industry_id' => $businessdata[0]['industriyal'], 'status' => '1'))->row()->industry_name; ?>
                                    <div class="profile-boxProfile-name">
                                        <a  href="<?php echo base_url('job-profile/' . $jobdata[0]['slug']); ?>" title="<?php echo $jobdata[0]['slug']; ?>"><?php
                                    if (ucwords($jobdata[0]['designation'])) {
                                        echo ucwords($jobdata[0]['designation']);
                                    } else {
                                        echo "Current Work";
                                    }
                                    ?></a>
                                    </div>
                                    <ul class=" left_box_menubar">
                                        <li>
                                            <a class="padding_less_left" title="Details" href="<?php echo base_url('job-profile/' . $jobdata[0]['slug']); ?>"> Details</a>
                                        </li>                                        
                                        <li><a title="Saved Job" href="<?php echo base_url('job-profile/saved-job'); ?>">Saved </a>
                                        </li>
                                        <li><a class="padding_less_right" title="Applied Job" href="<?php echo base_url('job-profile/applied-job'); ?>">Applied </a>
                                        </li>                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form name="job-company-filter" id="job-company-filter">
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Company</h3>
                            </div>
                            <ul class="search-listing custom-scroll">
                                <li ng-repeat="company in jobCompany">                                   
                                    <label class="control control--checkbox"><span ng-bind="company.company_name | capitalize"></span>
                                        <input type="checkbox" class="company-filter" ng-model="jobcompany" name="jobcompany[]" ng-value="{{company.rec_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>                                
                            </ul>
                            <p class="text-right p10"><a href="<?php echo base_url(); ?>jobs-by-companies">More Companies</a></p>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Categories</h3>
                            </div>
                            <ul class="search-listing custom-scroll">
                                <li ng-repeat="category in jobCategory">
                                    <label class="control control--checkbox"><span ng-bind="category.industry_name | capitalize"></span>
                                        <input type="checkbox" class="category-filter" ng-model="categories" name="category[]" ng-value="{{category.industry_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                            <p class="text-right p10"><a href="<?php echo base_url(); ?>jobs-by-categories">More Categories</a></p>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Cities</h3>
                            </div>
                            <ul class="search-listing custom-scroll">
                                <li ng-repeat="city in jobCity">
                                    <label class="control control--checkbox"><span ng-bind="city.city_name | capitalize"></span>
                                        <input type="checkbox" class="location-filter" ng-model="location" name="location[]" ng-value="{{city.city_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                            <p class="text-right p10"><a href="<?php echo base_url(); ?>jobs-by-location">More Cities</a></p>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Skills</h3>
                            </div>
                            <ul class="search-listing custom-scroll">
                                <li ng-repeat="skill in jobSkill">
                                    <label class="control control--checkbox"><span ng-bind="skill.skill | capitalize"></span>
                                        <input type="checkbox" class="skills-filter" ng-model="skills" name="skill[]" ng-value="{{skill.skill_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                            <p class="text-right p10"><a href="<?php echo base_url(); ?>jobs-by-skills">More Skills</a></p>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Designation</h3>
                            </div>
                            <ul class="search-listing custom-scroll">
                                <li ng-repeat="jd in jobDesignation">
                                    <label class="control control--checkbox"><span ng-bind="jd.job_title | capitalize"></span>
                                        <input type="checkbox" class="jds-filter" ng-model="jds" name="jds[]" ng-value="{{jd.title_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                            <p class="text-right p10"><a href="<?php echo base_url(); ?>jobs-by-designations">More Designation</a></p>
                        </div>
                        <div class="left-search-box">
                            <div class="accordion" id="accordion2">
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">Posting Period</a></h3>
                                    </div>
                                    <div id="collapseOne" class="accordion-body collapse">
                                        <ul class="search-listing">
                                            <li>
                                                <label class="control control--checkbox">Today
                                                    <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="1" ng-model="post_period1" ng-change="applyJobFilter()"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">Last 7 Days
                                                    <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="2" ng-model="post_period2" ng-change="applyJobFilter()"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">Last 15 Days
                                                    <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="3" ng-model="post_period3" ng-change="applyJobFilter()"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">Last 45 Days
                                                    <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="4" ng-model="post_period4" ng-change="applyJobFilter()"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="control control--checkbox">More than 45 Days
                                                    <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="5" ng-model="post_period5" ng-change="applyJobFilter()"/>
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
                                        <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsetwo">Experience</a></h3>
                                    </div>
                                    <div id="collapsetwo" class="accordion-body collapse">
                                        <div class="accordion-inner">
                                            <ul class="search-listing">
                                                <li>
                                                    <label class="control control--checkbox">0 to 1 year
                                                        <input class="exp-filter" type="checkbox" name="experience[]" ng-value="1" ng-model="exp1" ng-change="applyJobFilter()"/>
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="control control--checkbox">1 to 2 year
                                                        <input class="exp-filter" type="checkbox" name="experience[]" ng-value="2" ng-model="exp2" ng-change="applyJobFilter()"/>
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="control control--checkbox">2 to 3 year
                                                        <input class="exp-filter" type="checkbox" name="experience[]" ng-value="3" ng-model="exp3" ng-change="applyJobFilter()"/>
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="control control--checkbox">3 to 4 year
                                                        <input class="exp-filter" type="checkbox" name="experience[]" ng-value="4" ng-model="exp4" ng-change="applyJobFilter()"/>
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="control control--checkbox">4 to 5 year
                                                        <input class="exp-filter" type="checkbox" name="experience[]" ng-value="5" ng-model="exp5" ng-change="applyJobFilter()"/>
                                                        <div class="control__indicator"></div>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="control control--checkbox">More than 5 year
                                                        <input class="exp-filter" type="checkbox" name="experience[]" ng-value="6" ng-model="exp6" ng-change="applyJobFilter()"/>
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
                <div class="middle-part">
                    <div class="page-title">
                        <h3>Recommended Job</h3>
                    </div>
                    <div class="user_no_post_avl ng-scope" ng-if="recommended_job.length == 0">
                        <div class="user-img-nn">
                            <div class="user_no_post_img">
                                <img src="<?php echo base_url('assets/img/no-post.png?ver=time()');?>" alt="bui-no.png">
                            </div>
                            <div class="art_no_post_text">No Jobs Available.</div>
                        </div>
                    </div>
                    <div class="all-job-box" ng-repeat="job in recommended_job">
                        <input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="jobs.page_number" ng-value="{{jobs.page_number}}">
                        <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="jobs.total_record" ng-value="{{jobs.total_record}}">
                        <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="jobs.perpage_record" ng-value="{{jobs.perpage_record}}">
                        <div class="all-job-top">
                            <div class="post-img">
                                <a ng-href="<?php echo base_url(); ?>{{job.string_post_name | slugify}}-job-vacancy-in-{{job.city_name | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-if="job.comp_logo != null"><img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL ?>{{job.comp_logo}}"></a>
                                <a ng-href="<?php echo base_url(); ?>{{job.string_post_name | slugify}}-job-vacancy-in-{{job.city_name | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-if="job.comp_logo == null"><img src="<?php echo base_url('assets/n-images/commen-img.png') ?>"></a>
                            </div>
                            <div class="job-top-detail">
                                <h5><a href="<?php echo base_url(); ?>{{job.string_post_name | slugify}}-job-vacancy-in-{{job.city_name | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-if="job.string_post_name" ng-bind="job.string_post_name"></a></h5>
                                <h5><a href="<?php echo base_url(); ?>{{job.string_post_name | slugify}}-job-vacancy-in-{{job.city_name | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-if="!job.string_post_name" ng-bind="job.post_name"></a></h5>
                                <p><a href="<?php echo base_url(); ?>{{job.string_post_name | slugify}}-job-vacancy-in-{{job.city_name | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-bind="job.re_comp_name"></a></p>
                                <p><a href="<?php echo base_url(); ?>recruiter/profile/{{job.user_id}}" ng-bind="job.fullname"></a></p>
                            </div>
                        </div>
                        <div class="all-job-middle">
                            <p class="pb5">
                                <span class="location">
                                    <span><img class="pr5" src="<?php echo base_url('assets/n-images/location.png') ?>">{{job.city_name}},({{job.country_name}})</span>
                                </span>
                                <span class="exp">
                                    <span><img class="pr5" src="<?php echo base_url('assets/n-images/exp.png') ?>">{{job.min_year}} year - {{job.max_year}} year <span ng-if="job.fresher == '1'">(freshers can also apply)</span></span>
                                </span>
                            </p>
                            <p ng-bind="(job.post_description | limitTo:175) + '.....'"></p>

                        </div>
                        <div class="all-job-bottom">
                            <span class="job-post-date"><b>Posted on:</b><span ng-bind="job.created_date"></span></span>
                            <p class="pull-right" ng-if="job.job_applied == 1 && job.job_saved == 0">
                                <a href="javascript:void(0);" class="btn4  applied">Applied</a>
                            </p>
                            <p class="pull-right" ng-if="job.job_applied == 0 && job.job_saved == 1">
                                <a href="javascript:void(0);" class="btn4 saved savedpost{{job.post_id}}">Saved</a>
                                <a href="javascript:void(0);" class="btn4 applypost{{job.post_id}}" ng-click="applypopup(job.post_id,job.user_id)">Apply</a>
                            </p>
                            <p class="pull-right" ng-if="job.job_applied == 0 && job.job_saved == 0">
                                <a href="javascript:void(0);" class="btn4 savedpost{{job.post_id}}" ng-click="savepopup(job.post_id)">Save</a>
                                <a href="javascript:void(0);" class="btn4 applypost{{job.post_id}}" ng-click="applypopup(job.post_id,job.user_id)">Apply</a>
                            </p>

                        </div>
                    </div>
                    <div id="loader" style="display: none;">
                        <p style="text-align:center;">
                            <img src="<?php echo base_url('assets/images/loading.gif'); ?>" alt="<?php echo 'loaderimage'; ?>"/>
                        </p>
                    </div>
                </div>
                <div class="right-part">
                    <div class="edi_origde">
                        <?php                        
                        if ($count_profile == 100) {
                            if ($job_reg[0]['progressbar'] == 0) {
                                ?>
                            <div class="edit_profile_progress complete_profile">
                                <div class="progre_bar_text">
                                    <p>Please fill up your entire profile to get better job options and so that recruiter can find you easily.</p>
                                </div>
                                <div class="count_main_progress">
                                    <div class="circles">
                                        <div class="second circle-1 ">
                                            <div class="true_progtree">
                                                <img src="<?php echo base_url("assets/img/true.png"); ?>" alt="<?php echo 'successimage'; ?>">
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
                                            <a href="<?php echo base_url('job/basic-information') ?>" class="edit_profile_job" title="Edit profile">Edit Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="add-box">
                        <img src="<?php echo base_url('assets/img/add.jpg?ver=' . time()) ?>">
                    </div>
                </div>

            </div>
        </div>

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
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var q = "<?php echo $q ?>";
            var l = "<?php echo $l ?>";
            
            var w = '';
            var work_timing = "<?php echo $work_timing ?>";
            var login_user_id = "<?php echo $userid_login; ?>";
            var job_profile_set = "<?php echo $this->job_profile_set; ?>";
            var job_deactive = "<?php echo $job_deactive; ?>";
            var count_profile_value = '<?php echo $count_profile_value; ?>';
            var count_profile = '<?php echo $count_profile; ?>';
            var app = angular.module('recommendedJobs', ['ui.bootstrap']);
            
            $(document).ready(function($) {
                $("li.user-id label").click(function(e){
                    $(".dropdown").removeClass("open");
                    $(this).next('ul.dropdown-menu').toggle();
                    e.stopPropagation();
                });
                $(".right-header ul li.dropdown a").click(function(e){                          
                    $('.right-header ul.dropdown-menu').hide();
                });
            });
            $(document).click(function(){
                $('.right-header ul.dropdown-menu').hide();
            });

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
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job-live/searchJob.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job/recommended_jobs.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_reg.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_job_reg&skill.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/progressbar_common.js?ver=' . time()); ?>"></script>
    </body>
</html>