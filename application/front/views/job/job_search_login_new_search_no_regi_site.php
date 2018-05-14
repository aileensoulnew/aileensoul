<!DOCTYPE html>
<html lang="en" ng-app="jobSearchNRApp" ng-controller="jobSearchNRController">
    <head>
        <!-- start head -->
        <?php echo $head; ?>
        <!-- END HEAD -->

        <title><?php echo $title; ?></title>
        <?php
        if (IS_JOB_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
        <?php } else { ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/job.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
    </head>
    <!-- END HEAD -->

    <body class="profile-main-page">
        <?php
        $userid = $this->session->userdata('aileenuser');
        if (!$userid) {
            ?>
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-3 col-xs-3 fw-479 left-header">
                            <div class="logo"> <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a></div>
                        </div>
                        <div class="col-md-8 col-sm-9 col-xs-9 fw-479 right-header">
                            <div class="btn-right pull-right">
                                <a href="javascript:void(0);" onclick="login_profile();" class="btn2">Login</a>
                                <a href="javascript:void(0);" onclick="register_profile();" class="btn3">Creat an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        <?php }else{
            echo $header;
            } ?>
            <div class="middle-section middle-section-banner">
                <?php echo $search_banner ?>
                <div class="container">
                    <div class="left-part">
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
                    <div class="custom_footer_left fw">
                        <div class="">
                            <ul>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> About Us 
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Contact Us
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Blogs 
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Privacy Policy 
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Terms &amp; Condition
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <span class="custom_footer_dot"> · </span> Send Us Feedback
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                    <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                        <!--<div class="common-form">-->

                            <div class="page-title">
                                <h3>

                                    <?php
                                    if ($keyword == "" && $keyword1 == "") {
                                        echo 'All Jobs';
                                    } elseif ($keyword != "" && $keyword1 == "") {
                                        echo $keyword;
                                        echo " Jobs";
                                    } elseif ($keyword == "" && $keyword1 != "") {
                                        echo " Jobs in ";
                                        echo $keyword1;
                                    } else {
                                        echo $keyword;
                                        echo " Jobs in ";
                                        echo $keyword1;
                                    }
                                    ?>
                                </h3>

                                <div class="contact-frnd-post">
                                    <div class="job-contact-frnd ">
                                        <div class="user_no_post_avl ng-scope" ng-if="searchJob.length == 0">
                                            <div class="user-img-nn">
                                                <div class="user_no_post_img">
                                                    <img src="<?php echo base_url('assets/img/no-post.png?ver=time()');?>" alt="bui-no.png">
                                                </div>
                                                <div class="art_no_post_text">No Jobs Available.</div>
                                            </div>
                                        </div>
                                        <div class="all-job-box" ng-repeat="job in searchJob">
                                            <input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="jobs.page_number" ng-value="{{jobs.page_number}}">
                                            <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="jobs.total_record" ng-value="{{jobs.total_record}}">
                                            <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="jobs.perpage_record" ng-value="{{jobs.perpage_record}}">
                                            <div class="all-job-top">
                                                <div class="post-img">
                                                    <a href="#" ng-if="job.comp_logo"><img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL ?>{{job.comp_logo}}"></a>
                                                    <a href="#" ng-if="!job.comp_logo"><img src="<?php echo base_url('assets/n-images/commen-img.png') ?>"></a>
                                                </div>
                                                <div class="job-top-detail">
                                                    <h5><a href="#" ng-if="job.string_post_name" ng-bind="job.string_post_name"></a></h5>
                                                    <h5><a href="#" ng-if="!job.string_post_name" ng-bind="job.post_name"></a></h5>
                                                    <p><a href="#" ng-bind="job.re_comp_name"></a></p>
                                                    <p><a href="#" ng-bind="job.fullname"></a></p>
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
                                                <p class="pull-right">
                                                    <a href="#" class="btn4">Save</a>
                                                    <a href="#" class="btn4">Apply</a>
                                                </p>

                                            </div>
                                        </div>
                                        <!--.........AJAX DATA......-->           
                                    </div>
                                    <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="loaderimage"/></div>
                                </div>

                            </div>
                        <!--</div>-->
                    </div>
                    <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 

                        <div class="all-profile-box">
                            <div class="all-pro-head">
                                <h4>Profiles<a href="<?php echo base_url('profiles/') . $this->session->userdata('aileenuser_slug'); ?>" class="pull-right">All</a></h4>
                            </div>
                            <ul class="all-pr-list">
                                <li>
                                    <a href="<?php echo base_url('job-search'); ?>">
                                        <div class="all-pr-img" alt="job">
                                            <img src="<?php echo base_url('assets/img/i1.jpg'); ?>" alt="job">
                                        </div>
                                        <span>Job Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('recruiter'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i2.jpg'); ?>" alt="recruiter">
                                        </div>
                                        <span>Recruiter Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('freelance'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i3.jpg'); ?>"  alt="freelancer">
                                        </div>
                                        <span>Freelance Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('business-profile'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i4.jpg'); ?>" alt="business profile">
                                        </div>
                                        <span>Business Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('artist'); ?>" >
                                        <div class="all-pr-img">
                                            <img src="<?php echo base_url('assets/img/i5.jpg'); ?>" alt="artist">
                                        </div>
                                        <span>Artistic Profile</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>

            </div>   
   
    <!-- Model Popup Open -->
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


<?php echo $footer; ?>

    <!-- Login  -->
    <div class="modal fade login" id="login" role="dialog">
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
                                        <input type="email" value="<?php echo $email; ?>" name="email_login" autofocus="" id="email_login" class="form-control input-sm" placeholder="Email Address*">
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
                                        <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
                                    </p>

                                    <p class="pt15 text-center">
                                        Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();">Create an account</a>
                                    </p>
                                </form>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Login -->

    <!-- Login  For Apply Post-->
    <div class="modal fade login" id="login_apply" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content login-frm">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <div class="right-main">
                        <div class="right-main-inner">
                            <div class="">
                                <div class="title">
                                    <h1 class="ttc">Welcome To Aileensoul</h1>
                                </div>

                                <form role="form" name="login_form_apply" id="login_form_apply" method="post">

                                    <div class="form-group">
                                        <input type="email" value="<?php echo $email; ?>" name="email_login_apply" id="email_login_apply" autofocus="" class="form-control input-sm email_login" placeholder="Email Address*">
                                        <div id="error2" style="display:block;">
                                            <?php
                                            if ($this->session->flashdata('erroremail')) {
                                                echo $this->session->flashdata('erroremail');
                                            }
                                            ?>
                                        </div>
                                        <div id="errorlogin_apply"></div> 
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_login_apply" id="password_login_apply" class="form-control input-sm password_login" placeholder="Password*">
                                        <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">

                                        <div id="error1" style="display:block;">
                                            <?php
                                            if ($this->session->flashdata('errorpass')) {
                                                echo $this->session->flashdata('errorpass');
                                            }
                                            ?>
                                        </div>
                                        <div id="errorpass_apply"></div> 
                                    </div>

                                    <p class="pt-20 ">
                                        <button class="btn1" onclick="login()">Login</button>
                                    </p>

                                    <p class=" text-center">
                                        <a href="javascript:void(0)" data-toggle="modal" onclick="forgot_profile();" id="myBtn">Forgot Password ?</a>
                                    </p>

                                    <p class="pt15 text-center">
                                        Don't have an account? <a class="db-479" href="javascript:void(0);" data-toggle="modal" onclick="register_profile();">Create an account</a>
                                    </p>
                                </form>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Login -->

    <!-- model for forgot password start -->
    <div class="modal fade login" id="forgotPassword" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content login-frm">
                <button type="button" class="modal-close" data-dismiss="modal" onclick="forgot_close();">&times;</button>       
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




    <!-- model for forgot password end -->

    <!-- register -->

    <div class="modal fade register-model login" id="register" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content inner-form1">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <div class="clearfix">
                        <div class="">
                            <div class="title"><h1 class="tlh1">Sign up First and Register in Job Profile</h1></div>
                            <div class="main-form">
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
                                        <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
                                    </div>
                                    <div class="form-group dob">
                                        <label class="d_o_b"> Date Of Birth :</label>
                                        <span> <select tabindex="105" class="day" name="selday" id="selday">
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

                                            </select></span>

                                    </div>
                                    <div class="dateerror" style="color:#f00; display: block;"></div>

                                    <div class="form-group gender-custom">
                                        <span><select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                                <option value="" disabled selected value>Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select></span>
                                    </div>

                                    <p class="form-text">
                                        By Clicking on create an account button you agree our
                                        <a tabindex="109" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                    </p>
                                    <p>
                                        <button tabindex="111" class="btn1">Create an account</button>

                                    </p>
                                    <div class="sign_in pt10">
                                        <p>
                                            Already have an account ? <a tabindex="112" id ="postid" onClick="login_profile_apply()" href="javascript:void(0);"> Log In </a>
                                        </p>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- register -->

    <!-- register for apply start-->

    <div class="modal fade register-model login" id="register_apply" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <div class="clearfix">
                        <div class="">
                            <div class="title">
                                <h1 class="ttc tlh2">Welcome To Aileensoul</h1>
                            </div>
                            <div class="main-form">
                                <form role="form" name="register_form" id="register_form" method="post">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input tabindex="101" type="text" name="first_name" id="first_name" class="form-control input-sm" autofocus="" placeholder="First Name">
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
                                        <input type="hidden" name="password_login_postid" id="password_login_postid" class="form-control input-sm post_id_login">
                                    </div>
                                    <div class="form-group dob">
                                        <label class="d_o_b"> Date Of Birth :</label>
                                        <select tabindex="105" class="day" name="selday" id="selday">
                                            <option value="" disabled selected value>Day</option>
                                            <?php
                                            for ($i = 1; $i <= 31; $i++) {
                                                ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
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

                                        </select>
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

                                    </div>
                                    <div class="dateerror" style="color:#f00; display: block;"></div>

                                    <div class="form-group gender-custom">
                                        <select tabindex="108" class="gender"  onchange="changeMe(this)" name="selgen" id="selgen">
                                            <option value="" disabled selected value>Gender</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                    </div>

                                    <p class="form-text">
                                        By Clicking on create an account button you agree our<br class="mob-none">
                                        <a tabindex="109" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="110" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                    </p>
                                    <p>
                                        <button tabindex="111" class="btn1">Create an account</button>

                                    </p>
                                    <div class="sign_in pt10">
                                        <p>
                                            Already have an account ? <a tabindex="112" onClick="login_profile_apply(<?php echo $post['post_id']; ?>)" href="javascript:void(0);"> Log In </a>
                                        </p>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- register for apply end -->

    <!-- script for skill textbox automatic start-->

    <?php
    if (IS_JOB_JS_MINIFY == '0') {
        ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
<?php } else { ?>


        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>

<?php } ?>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
    <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
    <script>
        var base_url = '<?php echo base_url(); ?>';

        var skill = '<?php echo $keyword; ?>';
        //var skill = skill.replace(/\-/g, ' ');

        var search_location = '<?php echo $search_location; ?>';
        //var place = place.replace(/\-/g, ' ');

        var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var q = '';
        var l = '';
        var w = '';
        var app = angular.module('jobSearchNRApp', ['ngRoute','ui.bootstrap']);
    </script>
    <script src="<?php echo base_url('assets/js/webpage/job-live/searchJob.js?ver=' . time()) ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_search_login_new_search_no_regi_site.js?ver=' . time()); ?>"></script>
    
</body>
</html>