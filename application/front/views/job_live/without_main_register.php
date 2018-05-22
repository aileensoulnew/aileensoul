<!DOCTYPE html>
<html lang="en" ng-app="noRegJob" ng-controller="noRegJobController">
    <head>
        <title ng-bind="title"></title>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/bootstrap.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    </head>
    <body class="profile-main-page">        
        <div class="middle-section middle-section-banner new-ld-page">
            <div class="search-banner" >
                <header>
                    <div class="header">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 left-header">
                                    <h2 class="logo"><a href="<?php echo base_url(); ?>">Aileensoul</a></h2>
                                </div>
                                <div class="col-md-6 col-sm-6 no-login-right fw-479">
                                    <a href="#" class="btn8">Login</a>
                                    <a href="#" class="btn9">Create Job Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
                            <div class="search-bnr-text">
                                <h1>Find the Right Job Opportunities</h1>
                                <p>Because Dream Matters </p>
                            </div>
                            <div class="search-box">
                                <form onsubmit="jobsearchSubmit()" action="javascript:void(0)" method="get">
                                <div class="pb20 search-input">
                                    <input type="text" ng-model="keyword" id="job_keyword" name="job_keyword" placeholder="Job Title, Keywords, or Company" autocomplete="off">
                                    <input type="text" ng-model="city" id="job_location" name="job_location" placeholder="City, State or Country" class="city-input" autocomplete="off">
                                    
                                </div>
                                <div class="pt5 fw pb20">
                                    <ul class="work-timing fw">
                                        <li>
                                            <label class="control control--checkbox">Full-Time
                                              <input type="checkbox" ng-model="fulltime" name="work_timing[]" class="work_timing-filter" value="1" />
                                              <div class="control__indicator"></div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="control control--checkbox">Part-Time
                                              <input class="work_timing-filter" ng-model="parttime" name="work_timing[]" value="2" type="checkbox"/>
                                              <div class="control__indicator"></div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="control control--checkbox">Internship
                                              <input  class="work_timing-filter" ng-model="internship" name="work_timing[]" value="3" type="checkbox"/>
                                              <div class="control__indicator"></div>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="fw pt20">
                                    <input type="submit" class="btn1" name="submit" value="Search">
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="col-md-6 right-bnr">
                            <img src="<?php echo base_url('assets/n-images/job-bnr.png?ver=' . time()) ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="job-cat-lp" >
                <div class="container" >
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>Job by Category</h2>
                    </div>
                    <div class="row pt20" data-aos="fade-up" data-aos-duration="1000">
                        <div class="col-md-3" ng-if="jobCategory.length != 0" ng-repeat="jobs in jobCategory" ng-init="jobIndex=$index">
                            <div class="all-cat-box">
                                <a href="<?php echo base_url(); ?>{{jobs.industry_slug}}-jobs">
                                    <div class="cus-cat-middle">
                                    <img src="<?php echo JOB_INDUSTRY_IMG_PATH."/";?>{{jobs.industry_image}}">
                                    <p class="">{{jobs.industry_name}}</p>
                                    <span>{{jobs.count}} jobs</span>
                                    </div>
                                </a>
                            </div>
                        </div>                        
                    </div>
                    <div class="p20 fw" data-aos="fade-up" data-aos-duration="1000">
                        <p class="p20 text-center"><a href="<?php echo base_url(); ?>jobs-by-categories" class="btn-1">View More</a></p>
                    </div>
                </div>
            </div>

            <div class="content-bnr">
                <div class="bnr-box">
                    
                    <div class="content-bnt-text" data-aos="fade-up" data-aos-duration="1000">
                        <h2>Still Cant Find the Right Job Don't Worry We Are Here to Help</h2>
                        <p><a href="#" class="btn5">Create Job Profile</a></p>
                    </div>
                </div>
            </div>

            <div class="how-it-work">
                <div class="container">
                    <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                        <h2>How it Works</h2>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-duration="1000">
                        <div class="col-md-3">
                            <div class="hiw-box">
                                <img src="<?php echo base_url();?>assets/n-images/reg.png">
                                <p>Register</p>
                                <span>Sign up, enter your skills, job title and make your profile to get found by recruiters.</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="hiw-box">
                                <img src="<?php echo base_url();?>assets/n-images/get-reccoman.png">
                                <p>Get Recommendation</p>
                                <span>Don’t worry if you can’t find a job! We provide suggested job options that best match your skill and job title.</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="hiw-box">
                                <img src="<?php echo base_url();?>assets/n-images/connect.png">
                                <p>Connect and Apply</p>
                                <span>Connect with recruiters to know more about opportunities. Shortlist, save and apply for recent job openings.</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="hiw-box last-child">
                                <img src="<?php echo base_url();?>assets/n-images/get-job.png">
                                <p>Get the Job</p>
                                <span>And finally kick-start your career with your dream job.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="related-article">
                <div class="container">
                        <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                            <h2>Related Articles</h2>

                        </div>
                        <div class="row pt20" data-aos="fade-up" data-aos-duration="1000">
                            <div class="col-md-3">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url();?>assets/img/art-post.jpg">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url();?>assets/img/art-post.jpg">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url();?>assets/img/art-post.jpg">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url();?>assets/img/art-post.jpg">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
        
            <div class="browse-jobs">
                <div class="center-title" data-aos="fade-up" data-aos-duration="1000">
                    <h2>Browse Other Jobs</h2>
                </div>
                <div class="row" data-aos="fade-up" data-aos-duration="1000">
                    <div class="col-md-4 col-sm-4">
                        <div class="browse-box">
                            <ul>
                                <li><h3>Job By Location</h3></li>
                                <li ng-if="jobCity.length != 0" ng-repeat="jc in jobCity" ng-init="jcIndex=$index"><a href="<?php echo base_url(); ?>jobs-in-{{jc.slug}}">Jobs in {{jc.city_name}} ({{jc.count}})</a></li>
                                <li><a href="<?php echo base_url(); ?>jobs-by-location">View All Location....</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="browse-box">
                            <ul>
                                <li><h3>Job By Designation</h3></li>
                                <li ng-if="jobDesignation.length != 0" ng-repeat="jd in jobDesignation" ng-init="jdIndex=$index"><a href="<?php echo base_url(); ?>{{jd.job_slug}}-jobs">{{jd.job_title}} ({{jd.count}})</a></li>                                
                                <li><a href="<?php echo base_url(); ?>jobs-by-designations">View All Designation....</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="browse-box">
                            <ul>
                                <li><h3>Job By Company</h3></li>
                                <li ng-if="jobCompany.length != 0" ng-repeat="jcm in jobCompany" ng-init="jcmIndex=$index"><a href="<?php echo base_url(); ?>jobs-opening-at-{{jcm.company_name | slugify}}-{{jcm.rec_id}}">{{jcm.company_name}} ({{jcm.count}})</a></li>
                                <li><a href="<?php echo base_url(); ?>jobs-by-companies">View All Companies....</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script type="text/javascript" charset="utf-8">
function jobsearchSubmit(){
    
        var keyword = $("input[name='job_keyword']").val().toLowerCase().split(' ').join('+');
        var city = $("input[name='job_location']").val().toLowerCase().split(' ').join('+');

        var work_timing_fil = "";
        $('.work_timing-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                work_timing_fil += (work_timing_fil == "") ? currentid : "-" + currentid;
            }
        });        
        // REPLACE , WITH - AND REMOVE IN FROM KEYWORD ARRAY
        var keyworddata = [];
        if(keyword != ""){
            keyworddata = keyword.split(",");
            // remove in from array
            if(keyworddata.indexOf("in") > -1 && city != ""){
                keyworddata.splice(keyworddata.indexOf("in"),1);
            }
            keyword = keyworddata.join('-').toString();
        }
        var citydata = [];
        if(city != ""){
            citydata = city.split(",");
            // remove in from array
            // if(citydata.indexOf("in") > -1 && city != ""){
            //     citydata.splice(citydata.indexOf("in"),1);
            // }
            city = citydata.join('-').toString();
        }

        if(keyword[keyword.length - 1] == "-")
        {            
            keyword = keyword.slice(0,-1);
        }
        
        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            window.location.href = base_url + 'jobs/search/' + keyword + '-jobs?work_timing='+work_timing_fil;
        } else if (keyword == '' && city != '') {
            window.location.href = base_url + 'jobs/search/jobs-in-' + city+'?work_timing='+work_timing_fil;
        } else {
            window.location.href = base_url + 'jobs/search/' + keyword + '-jobs-in-' + city+'?work_timing='+work_timing_fil;
        }
    }
</script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            //var header_all_profile = '<?php echo $header_all_profile; ?>';
            var q = '';
            var l = '';
            var w = '';
            var app = angular.module('noRegJob', ['ui.bootstrap']);
        </script>
        <script src="<?php echo base_url('assets/js/webpage/job-live/searchJob.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/job-live/without_regi.js?ver=' . time()) ?>"></script>
    </body>
</html>