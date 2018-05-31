<?php $userid = $this->session->userdata('aileenuser'); ?>
<!DOCTYPE html>
<html lang="en" ng-app="freelanceApplyNRApp" ng-controller="freelanceApplyNRController">
    <head>
        <!-- start head -->
        <?php //echo $head; ?>
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
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <style>
          .ui-autocomplete {
            max-height: 100px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
          }
          /* IE 6 doesn't support max-height
           * we use height instead, but this forces the menu to always be this tall
           */
          * html .ui-autocomplete {
            height: 100px;
          }
          </style>
    </head>
    <!-- END HEAD -->

    <body class="profile-main-page">        
            <div class="middle-section middle-section-banner new-ld-page">
                <?php
                if($userid != ""){
                    echo $header_profile;
                } ?>
                <!-- <div class="search-banner" >
                    <header>
                        <div class="header">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 left-header fw-479">
                                        <h2 class="logo"><a target="_self" href="<?php echo base_url(); ?>">Aileensoul</a></h2>
                                        
                                    </div>
                                    <div class="col-md-6 col-sm-6 no-login-right fw-479">
                                        <a href="<?php echo base_url('login'); ?>" class="btn8">Login</a>
                                        <a href="<?php echo base_url('freelancer/create-account'); ?>" class="btn9">Create Freelancer Account</a>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
                                <div class="search-bnr-text">
                                    <h1>Work from Anywhere at Any Time</h1>
                                    <p>Get the work you love</p>
                                </div>
                                <div class="search-box">
                                    <form>
                                        <div class="pb20 search-input">
                                            <input type="text" placeholder="Job Title, Keywords, or Skills">
                                            <input class="city-input" type="text" placeholder="City, State or Country">
                                            
                                        </div>
                                        <div class="pt5 fw pb20">
                                            <ul class="work-timing fw">
                                                <li>
                                                    <label class="control control--checkbox">Hourly
                                                      <input type="checkbox"/>
                                                      <div class="control__indicator"></div>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="control control--checkbox">Fixed
                                                      <input type="checkbox"/>
                                                      <div class="control__indicator"></div>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="fw pt20">
                                            <a href="#" class="btn1">Search Jobs</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6 right-bnr">
                                <img src="<?php echo base_url(); ?>assets/n-images/free-apply.png">
                            </div>
                        </div>
                    </div>
                </div> -->
                <?php echo $search_banner; ?>

                <div class="container pt20">
                    <div class="left-part">
                    <form name="job-company-filter" id="job-company-filter">
                        
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Fields</h3>
                            </div>
                            <ul class="search-listing custom-scroll">
                                <li ng-repeat="category in FAFields">
                                    <label class="control control--checkbox"><span ng-bind="category.industry_name | capitalize"></span>
                                        <input type="checkbox" class="category-filter" ng-model="cat_fil" name="category[]" ng-value="{{category.industry_id}}" ng-change="applyJobFilter()"/>
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
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>freelance-jobs-by-skills ">View More Categories</a></p>
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
                        <!--</div>-->
                        <div class="page-title">
                            <h3>Recommended Projects</h3>
                        </div>
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
                                <span>Applied Persons: {{applypost.ShortListedCount}}</span>
                                <span class="pl20">Shortlisted Persons: {{applypost.AppliedCount}}</span>
                                <p class="pull-right">
                                    <?php if($userid != ""): ?>
                                        <a href="<?php echo base_url('freelance-work/profile/live-post/'); ?>{{applypost.post_id}}" class="btn4">Save</a>
                                        <a href="<?php echo base_url('freelance-work/profile/live-post/'); ?>{{applypost.post_id}}" class="btn4">Apply</a>
                                    <?php else: ?>
                                        <a href="javascript:void(0)" ng-click="savepopup(applypost.post_id)" class="btn4">Save</a>
                                        <a href="javascript:void(0)" ng-click="applypopup(applypost.post_id,applypost.user_id)" class="btn4">Apply</a>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div id="loader" style="display: none;">
                            <p style="text-align:center;">
                                <img src="<?php echo base_url('assets/images/loading.gif'); ?>" alt="<?php echo 'loaderimage'; ?>"/>
                            </p>
                        </div>
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


<?php echo $footer; ?>

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
    <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
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
        var skill = '<?php echo $keyword; ?>';
        var search_location = '<?php echo $search_location; ?>';
        var login_user_id = "<?php echo $userid_login; ?>";
        var app = angular.module('freelanceApplyNRApp', ['ngRoute','ui.bootstrap']);
        var header_all_profile = '<?php echo $header_all_profile; ?>';
        // $(document).ready(function(){
        //     $(window).scrollTop(500);
        // });
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
            
            /*$('#job_reg').on('hidden.bs.modal', function (e) {
                $("#job_apply").val('');
                $("#job_apply_userid").val('');
                $("#job_save").val('');
            });*/
    </script>    
    <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>  
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/fa_field_cat_list_no_login.js?ver=' . time()); ?>"></script>
</body>
</html>