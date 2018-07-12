<!DOCTYPE html>
<html lang="en" ng-app="noRegJob" ng-controller="noRegJobController">
    <head>
        <!-- <title ng-bind="title"></title> -->
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <title>Job Search: Find best local jobs and employment at near by location</title>
        <meta name="description" content="Find the current job opportunities and options in any industry in your locale that best suits your skill and connect with recruiter. Apply Today! Upload your Resume Now." />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page without-reg ftr-page">        
        <div class="middle-section middle-section-banner new-ld-page">
			
            <?php echo $search_banner ?>

            <div class="job-cat-lp" >
                <div class="container" >
                    <div class="center-title" ><!--  -->
                        <h2>Jobs by Category</h2>
                    </div>
                    <div class="row pt20" ><!--  -->
                        <!-- <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box" ng-if="jobCategory.length != 0" ng-repeat="jobs in jobCategory" ng-init="jobIndex=$index">
                            <div class="all-cat-box">
                                <a ng-href="<?php echo base_url(); ?>{{jobs.industry_slug}}-jobs">
                                    <div class="cus-cat-middle">
                                    <img ng-src="<?php echo JOB_INDUSTRY_IMG_PATH;?>{{jobs.industry_image}}">
                                    <p class="" ng-bind="jobs.industry_name"></p>
                                    <-- <span ng-bind="jobs.count"></span> ---
                                    </div>
                                </a>
                            </div>
                        </div> -->
                        <?php if(isset($jobCategory) && !empty($jobCategory)):
                                foreach($jobCategory as $_jobCategory): ?>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="all-cat-box">
                                <a href="<?php echo base_url().$_jobCategory['industry_slug'].'-jobs'; ?>">
                                    <div class="cus-cat-middle">
                                        <img src="<?php echo JOB_INDUSTRY_IMG_PATH.$_jobCategory['industry_image']; ?>" onError="this.onerror=null;this.src='<?php echo JOB_INDUSTRY_IMG_PATH.'job_industry_image_default.png'; ?>';">
                                    <p><?php echo $_jobCategory['industry_name']; ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php  endforeach;
                            endif; ?>
                    </div>
                    <div class="p20 fw" ><!--  -->
                        <p class="p20 text-center"><a href="<?php echo base_url(); ?>jobs-by-categories" class="btn-1">View More</a></p>
                    </div>
                </div>
            </div>

            <div class="content-bnr">
                <div class="bnr-box">
                    
                    <div class="content-bnt-text" ><!--  -->
                        <h2>Still Cant Find the Right Job Don't Worry We Are Here to Help</h2>
                        <p><a href="<?php echo base_url('job-profile/create-account'); ?>" class="btn5">Create Job Profile</a></p>
                    </div>
                </div>
            </div>

            <div class="how-it-work">
                <div class="container">
                    <div class="center-title" ><!--  -->
                        <h2>How it Works</h2>
                    </div>
                    <div class="row" ><!--  -->
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="hiw-box">
                                <img src="<?php echo base_url();?>assets/n-images/reg.png">
                                <p>Register</p>
                                <span>Sign up, enter your skills, job title and make your profile to get found by recruiters.</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="hiw-box">
                                <img src="<?php echo base_url();?>assets/n-images/get-reccoman.png">
                                <p>Get Recommendation</p>
                                <span>Don’t worry if you can’t find a job! We provide suggested job options that best match your skill and job title.</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
                            <div class="hiw-box">
                                <img src="<?php echo base_url();?>assets/n-images/connect.png">
                                <p>Connect and Apply</p>
                                <span>Connect with recruiters to know more about opportunities. Shortlist, save and apply for recent job openings.</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 mob-cus-box">
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
                        <div class="center-title" ><!--  -->
                            <h2>Related Articles</h2>

                        </div>
                        <div class="row pt20" ><!--  -->
                            <?php if(isset($job_related_list) && !empty($job_related_list)):
                                    foreach($job_related_list as $_job_related_list): ?>
                            <div class="col-md-4 col-sm-4">
                                <div class="also-like-box">
                                    <div class="rec-img">
                                        <a href="<?php echo base_url().'blog/'.$_job_related_list['blog_slug']; ?>">
                                        <img src="<?php echo base_url($this->config->item('blog_main_upload_path')).$_job_related_list['image']; ?>"></a>
                                    </div>
                                    <div class="also-like-bottom">
                                        <p><a href="<?php echo base_url().'blog/'.$_job_related_list['blog_slug']; ?>"><?php echo $_job_related_list['title']; ?></a></p>
                                    </div>
                                
                                </div>
                            </div>
                            <?php  endforeach;
                                endif; ?>

                            <!-- <div class="col-md-3 col-sm-6">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url();?>assets/img/art-post.jpg">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url();?>assets/img/art-post.jpg">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="rel-art-box">
                                    <img src="<?php echo base_url();?>assets/img/art-post.jpg">
                                    <div class="rel-art-name">
                                        <a href="#">See the world in your language with Google Translate</a>
                                    </div>
                                </div>
                            </div> -->
                           
                        </div>
                    </div>
                </div>
            <div class="container">
                <div class="browse-jobs">
                    <div class="center-title" ><!--  -->
                        <h2>Browse Other Jobs</h2>
                    </div>
                    <div class="row" ><!--  -->
                        <div class="col-md-4 col-sm-4">
                            <div class="browse-box">
                                <ul>
                                    <li><h3>Jobs By Location</h3></li>
                                    <?php if(isset($jobCity) && !empty($jobCity)):
                                            foreach($jobCity as $_jobCity): ?>
                                    <li><a href="<?php echo base_url().'jobs-in-'.$_jobCity['slug']; ?>"><?php echo "Jobs in ".$_jobCity['city_name']; ?></a></li>
                                    <?php endforeach;
                                        endif; ?>
                                    <li><a href="<?php echo base_url(); ?>jobs-by-location">View All Location</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="browse-box">
                                <ul>
                                    <li><h3>Jobs By Designation</h3></li>
                                    <?php if(isset($jobDesignation) && !empty($jobDesignation)):
                                            foreach($jobDesignation as $_jobDesignation): ?>
                                    <li><a href="<?php echo base_url().$_jobDesignation['job_slug'].'-jobs'; ?>"><?php echo $_jobDesignation['job_title'].' Jobs'; ?></a></li>
                                    <?php endforeach;
                                        endif; ?>
                                    <li><a href="<?php echo base_url(); ?>jobs-by-designations">View All Designation</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="browse-box">
                                <ul>
                                    <li><h3>Jobs By Company</h3></li>
                                    <?php if(isset($jobCompany) && !empty($jobCompany)):
                                            foreach($jobCompany as $_jobCompany):
                                            $slug = $this->common->clean($_jobCompany['company_name']);  ?>
                                    <li><a href="<?php echo base_url().'jobs-opening-at-'.strtolower($slug).'-'.$_jobCompany['rec_id']; ?>"><?php echo $_jobCompany['company_name'].' Jobs'; ?></a></li>
                                    <?php endforeach;
                                        endif; ?>
                                    <li><a href="<?php echo base_url(); ?>jobs-by-companies">View All Companies</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php $this->load->view('mobile_side_slide'); ?>
            <?php echo $login_footer; ?>
        </div>
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
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