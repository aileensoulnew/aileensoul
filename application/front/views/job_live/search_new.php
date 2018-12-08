<!DOCTYPE html>
<?php $userid_login = $this->session->userdata('aileenuser');
//echo $userid_login."-------".$job_deactive."----------".$this->job_profile_set;exit;
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
<html lang="en" ng-app="jobSearch" ng-controller="jobSearchController">
    <head>
        <title ng-bind="title"></title>
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php //echo $head; ?>        
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">        
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); 
        ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver='.time()); ?>">
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <style type="text/css">
          .ui-autocomplete {
            background: #fff;
            z-index: 999999!important;
        }
</style>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page body-loader">    
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
        <?php 
        if($job_deactive == 0  && $this->job_profile_set == 1){
            echo $job_header2;
        }else if ($userid_login != "" && ($job_deactive > 0 || $this->job_profile_set == 1)) {
            echo $header_profile;
        }
        else if($userid_login != "" && $this->job_profile_set == 0)
        {
             echo $header_profile;
        }
        if($userid_login == "" || $job_deactive > 0 || $this->job_profile_set == 0)
        {
            $headercls = "";
            if($userid_login == "")
            {
                $headercls = " new-ld-page";
            }
            ?>
            <div class="middle-section middle-section-banner <?php echo $headercls; ?>">
            <?php
            echo $search_banner;
        }
        else
        { ?>
            <div class="middle-section">
        <?php } ?>  
            
            <div class="container pt20 mobp0">
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
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-companies">View More Companies</a></p>
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
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-categories">View More Categories</a></p>
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
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-location">View More Cities</a></p>
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
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-skills">View More Skills</a></p>
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
                            <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-designations">View More Designation</a></p>
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
					<?php $this->load->view('right_add_box'); ?>
                    <?php echo $left_footer; ?>
                   
                </div>
                <div class="middle-part">
					<!-- <div class="tab-add">
						<?php //$this->load->view('banner_add'); ?>
					</div> -->
                    <div class="page-title">
                        <h3>Search for <?php echo $q.($l != "" ? " jobs in ".$l : '') ; ?></h3>
                    </div>
					<!-- <div class="tab-add">
						<?php //$this->load->view('infeed_add'); ?>
					</div> -->
                    <div class="user_no_post_avl ng-scope" ng-if="job_search.length == 0">
                        <div class="user-img-nn">
                            <div class="user_no_post_img">
                                <img src="<?php echo base_url('assets/img/no-post.png?ver=time()');?>" alt="bui-no.png">
                            </div>
                            <div class="art_no_post_text">No Jobs Available.</div>
                        </div>
                    </div>
                    <div ng-if="job_search.length != 0" ng-repeat="job in job_search" ng-init="jobIndex=$index">
                    <div class="all-job-box">
                        <input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="jobs.page_number" ng-value="{{jobs.page_number}}">
                        <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="jobs.total_record" ng-value="{{jobs.total_record}}">
                        <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="jobs.perpage_record" ng-value="{{jobs.perpage_record}}">
                        <div class="all-job-top">
                            <div class="post-img">
                                <a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-if="job.comp_logo"><img ng-src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL; ?>{{job.comp_logo}}" onerror="this.onerror=null;this.src='<?php echo base_url('assets/n-images/commen-img.png') ?>';"></a>
                                <a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-if="!job.comp_logo"><img src="<?php echo base_url('assets/n-images/commen-img.png') ?>"></a>
                            </div>
                            <div class="job-top-detail">
                                <h5 ng-if="job.string_post_name"><a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-bind="job.string_post_name"></a></h5>
                                <h5 ng-if="!job.string_post_name"><a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-bind="job.post_name"></a></h5>
                                <p><a href="<?php echo base_url(); ?>{{job.string_post_name | slugify | limitTo:200}}-job-vacancy-in-{{job.slug_city | slugify}}-{{job.user_id}}-{{job.post_id}}" ng-bind="job.rec_comp_name"></a></p>
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
                    <?php if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") { ?>
                    <div id="ads{{jobIndex}}" ng-if="(jobIndex + 1) % <?php echo ADS_BREAK; ?> == 0">
                        <div class="tab-add">
                            <adsense ad-client="ca-pub-6060111582812113" ad-slot="6296725909" inline-style="display:block;" ad-format="fluid" data-ad-layout-key="-6r+eg+1e-3d+36" ad-class="infeed"></adsense>
                            <?php //$this->load->view('infeed_add'); ?>
                        </div>
                    </div>
                    <?php } ?>
                    </div>
					<!-- <div class="tab-add">
						<?php //$this->load->view('banner_add'); ?>
					</div> -->
                    <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="loaderimage"/></div>
                </div>
                <div class="right-part">
                    <?php $this->load->view('right_add_box'); ?>
                   
                </div>

            </div>
       
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
                    <div class="modal-body">
						
						<div class="mid-modal-body">
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
									<p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-companies">View More Companies</a></p>
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
									<p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-categories">View More Categories</a></p>
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
									<p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-location">View More Cities</a></p>
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
									<p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-skills">View More Skills</a></p>
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
									<p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-designations">View More Designation</a></p>
								</div>
								<div class="left-search-box">
									<div class="accordion" id="accordion2">
										<div class="accordion-group">
											<div class="accordion-heading">
												<h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOnemob">Posting Period</a></h3>
											</div>
											<div id="collapseOnemob" class="accordion-body collapse">
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
												<h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsetwomob">Experience</a></h3>
											</div>
											<div id="collapsetwomob" class="accordion-body collapse">
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
						</div>
                    </div>
                </div>
            </div>
        </div>
        
		 </div>
        </div>
		<!-- Register -modal  -->
        <div class="modal fade message-box register-model" id="job_reg" role="dialog">
            <div class="modal-dialog modal-lm" >
                <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <div class="modal-body">
                        <span class="mes">
                            <div class="pop_content pop-content-cus">
                                <h2>To Complete This Step, You Have to Register in the Job Profile.</h2>
                                <p class="poppup-btns">
                                    <a class="btn1" href="<?php echo base_url('job-profile/signup'); ?>">Register</a>
                                </p>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Popup Close -->
        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <?php 
        if($this->session->userdata('aileenuser') == "")
        {            
            $this->load->view('mobile_side_slide'); 
        }
        ?>
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script> -->

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
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
            var app = angular.module('jobSearch', ['ui.bootstrap','angular-google-adsense']);
            
            /*$(document).ready(function($) {
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
            });*/

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
        <script src="<?php echo base_url('assets/js/webpage/job-live/job_search_new.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_reg.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_job_reg&skill.js?ver='.time()); ?>"></script>
    </body>
</html>