<!DOCTYPE html>
<?php $user_id = $this->session->userdata('aileenuser');
$userid_login = $this->session->userdata('aileenuser'); ?>
<html lang="en" ng-app="jobSearchApp" ng-controller="jobSearchController">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">   
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page">
        <?php 
        if($job_deactive == 0 && $user_id != "")
        {
            echo $job_header2;            
        }
        else if ($job_deactive > 0)
        {
            echo $header_profile;
        }
        if($user_id == "")
        {?>
            <div class="middle-section middle-section-banner">
            <?php echo $search_banner; 
        }
        else
        { ?>
            <div class="middle-section">
        <?php } ?>            
            <div class="container pt20">
                <div class="left-part">
                    <form name="job-company-filter" id="job-company-filter">
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Company</h3>
                            </div>
                            <ul class="search-listing">
                                <li ng-repeat="company in jobCompany">                                   
                                    <label class="control control--checkbox"><span ng-bind="company.company_name | capitalize"></span>
                                        <input type="checkbox" class="company-filter" ng-model="jobcompany" name="jobcompany[]" ng-value="{{company.rec_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>                                
                            </ul>
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-companies">More Companies</a></p>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Categories</h3>
                            </div>
                            <ul class="search-listing">
                                <li ng-repeat="category in jobCategory">
                                    <label class="control control--checkbox"><span ng-bind="category.industry_name | capitalize"></span>
                                        <input type="checkbox" class="category-filter" ng-model="categories" name="category[]" ng-value="{{category.industry_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-categories">More Categories</a></p>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Cities</h3>
                            </div>
                            <ul class="search-listing">
                                <li ng-repeat="city in jobCity">
                                    <label class="control control--checkbox"><span ng-bind="city.city_name | capitalize"></span>
                                        <input type="checkbox" class="location-filter" ng-model="location" name="location[]" ng-value="{{city.city_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-location">More Cities</a></p>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Skills</h3>
                            </div>
                            <ul class="search-listing">
                                <li ng-repeat="skill in jobSkill">
                                    <label class="control control--checkbox"><span ng-bind="skill.skill | capitalize"></span>
                                        <input type="checkbox" class="skills-filter" ng-model="skills" name="skill[]" ng-value="{{skill.skill_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-skills">More Skills</a></p>
                        </div>
                        <div class="left-search-box">
                            <div class="">
                                <h3>Top Designation</h3>
                            </div>
                            <ul class="search-listing">
                                <li ng-repeat="jd in jobDesignation">
                                    <label class="control control--checkbox"><span ng-bind="jd.job_title | capitalize"></span>
                                        <input type="checkbox" class="jds-filter" ng-model="jds" name="jds[]" ng-value="{{jd.title_id}}" ng-change="applyJobFilter()"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-designations">More Designation</a></p>
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
                    <!-- <div class="custom_footer_left fw">
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
                    </div> -->
                </div>
                <div class="middle-part">
                    <div class="page-title">
                        <h3>Latest Job</h3>
                    </div>
                    <div class="user_no_post_avl ng-scope" ng-if="searchJob.length == 0">
                        <div class="user-img-nn">
                            <div class="user_no_post_img">
                                <img src="<?php echo base_url('assets/img/no-post.png?ver=time()');?>" alt="bui-no.png">
                            </div>
                            <div class="art_no_post_text">No Jobs Available.</div>
                        </div>
                    </div>
                    <div class="all-job-box" ng-repeat="job in searchJob">
                        <div class="all-job-top">
                            <div class="post-img">
                                <a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-if="job.comp_logo"><img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL ?>{{job.comp_logo}}"></a>
                                <a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-if="!job.comp_logo"><img src="<?php echo base_url('assets/n-images/commen-img.png') ?>"></a>
                            </div>
                            <div class="job-top-detail">
                                <h5><a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-if="job.string_post_name" ng-bind="job.string_post_name"></a></h5>
                                <h5><a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-if="!job.string_post_name" ng-bind="job.post_name"></a></h5>
                                <p><a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-bind="job.re_comp_name"></a></p>
                                <p><a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-bind="job.fullname"></a></p>
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
                    <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="loaderimage"/></div>
                </div>
                <div class="right-part">
                    <?php $this->load->view('right_add_box'); ?>
                </div>
            </div>
        </div>        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script> -->

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script>
                var base_url = '<?php echo base_url(); ?>';
                var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                var title = '<?php echo $title; ?>';
                var header_all_profile = '<?php echo $header_all_profile; ?>';
                var q = '';
                var l = '';
                var w = '';
                var login_user_id = "<?php echo $userid_login; ?>";
                var job_profile_set = "<?php echo $this->job_profile_set; ?>";
                var job_deactive = "<?php echo $job_deactive; ?>";
                var company_id = '<?php echo $company_id ?>';
                var skill = '<?php echo $keyword; ?>';
                //var skill = skill.replace(/\-/g, ' ');

                var search_location = '<?php echo $search_location; ?>';
                //var place = place.replace(/\-/g, ' ');
                var app = angular.module('jobSearchApp', ['ui.bootstrap']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job-live/searchJob.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job-live/company.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_search_login_new_search.js?ver=' . time()); ?>"></script>
    </body>
</html>