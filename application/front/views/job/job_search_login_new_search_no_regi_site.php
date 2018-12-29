<!DOCTYPE html>
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
<html lang="en"><!--  ng-app="jobSearchNRApp" ng-controller="jobSearchNRController"> -->
    <head>
        <!-- start head -->
        <?php //echo $head; ?>
        <!-- END HEAD -->
		<!-- <meta name="robots" content="noindex, nofollow"> -->
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="canonical" href="<?php echo current_url(); ?>" />
  
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
        
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">   
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <!-- END HEAD -->

    <body classclass="profile-main-page">        
            <div class="middle-section middle-section-banner new-ld-page">
                <?php echo $search_banner ?>
                <div class="container pt20 mobp0">
                    <div class="left-part">
                        <?php echo $job_filter; ?>
                    </div>

                    <div class="middle-part animated fadeInUp">
                        <!--<div class="common-form">-->
							<div class="tab-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                            <div class="page-title">
                                <h1 class="search-title">

                                    <?php
                                    if ($keyword == "" && $keyword1 == "") {
                                        echo 'All Jobs';
                                    } elseif ($keyword != "" && $keyword1 == "") {
                                        echo $schema_name_item4;
                                        // echo " Jobs";
                                    } /*elseif ($keyword == "" && $keyword1 != "") {
                                        echo " Jobs in ";
                                        echo $keyword1;
                                    } else {
                                        echo $keyword;
                                        echo " Jobs in ";
                                        echo $keyword1;
                                    }*/
                                    ?>
                                </h1>

                                <div class="">
                                    <div class="job-contact-frnd ">
                                        <?php if(isset($searchJob) && empty($searchJob) && $page == 0):?>
                                        <div class="user_no_post_avl ng-scope">
                                            <div class="user-img-nn">
                                                <div class="user_no_post_img">
                                                    <img src="<?php echo base_url('assets/img/no-post.png?ver=time()');?>" alt="bui-no.png">
                                                </div>
                                                <div class="art_no_post_text">No Jobs Available.</div>
                                            </div>
                                        </div>
                                        <?php
                                        endif;
                                        if(isset($searchJob) && !empty($searchJob)):
                                            foreach($searchJob as $_searchJob): ?>
                                        <div class="all-job-box">                                            
                                            <div class="all-job-top">
                                                <div class="post-img">
                                                    <?php 
                                                    $url = strtolower($this->common->clean($_searchJob['string_post_name']));
                                                    $slug_city = strtolower($this->common->clean($_searchJob['slug_city'])); ?>
                                                    <a href="<?php echo base_url().substr($url,0,200).'-job-vacancy-in-'.$slug_city.'-'.$_searchJob['user_id'].'-'.$_searchJob['post_id']; ?>">
                                                        <?php if($_searchJob['comp_logo'] != ""){
                                                            ?>
                                                        <img src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL.$_searchJob['comp_logo'] ?>" onError="this.onerror=null;this.src='<?php echo base_url().'/assets/n-images/commen-img.png'; ?>';">
                                                        <?php
                                                        }
                                                        else{ ?>
                                                            <img src="<?php echo base_url('assets/n-images/commen-img.png') ?>">
                                                        <?php
                                                        } ?>
                                                    </a>
                                                </div>
                                                <div class="job-top-detail">
                                                    <h5>
                                                        <a href="<?php echo base_url().substr($url,0,200).'-job-vacancy-in-'.$slug_city.'-'.$_searchJob['user_id'].'-'.$_searchJob['post_id']; ?>">
                                                            <?php echo($_searchJob['string_post_name'] != $_searchJob['post_name'] ? $_searchJob['string_post_name']:$_searchJob['string_post_name']); ?>
                                                        </a>
                                                       
                                                    <p>
                                                        <a href="<?php echo base_url().substr($url,0,200).'-job-vacancy-in-'.$slug_city.'-'.$_searchJob['user_id'].'-'.$_searchJob['post_id']; ?>">
                                                            <?php echo $_searchJob['re_comp_name']; ?>
                                                        </a>
                                                    </p>
                                                    <p>
                                                        <a href="<?php echo base_url().substr($url,0,200).'-job-vacancy-in-'.$slug_city.'-'.$_searchJob['user_id'].'-'.$_searchJob['post_id']; ?>">
                                                            <?php echo $_searchJob['fullname']; ?>
                                                        </a>  
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="all-job-middle">
                                                <p class="pb5">
                                                    <span class="location">
                                                        <span><img class="pr5" src="<?php echo base_url('assets/n-images/location.png') ?>">
                                                            <?php echo $_searchJob['city_name'].',('.$_searchJob['country_name'].')'; ?></span>
                                                    </span>
                                                    <span class="exp">
                                                        <span>
                                                            <img class="pr5" src="<?php echo base_url('assets/n-images/exp.png') ?>">
                                                                <?php 
                                                                echo $_searchJob['min_year'].'year -'.$_searchJob['max_year'].' year';
                                                                echo ($_searchJob['fresher'] == '1' ? '<span>(freshers can also apply)</span>' : '');
                                                                ?>
                                                        </span>
                                                    </span>
                                                </p>
                                                <p><?php echo substr($_searchJob['post_description'],0,175).'.....'; ?>
                                                </p>

                                            </div>
                                            <div class="all-job-bottom">
                                                <span class="job-post-date">
                                                    <b>Posted on:</b><span><?php echo $_searchJob['created_date'];?></span>
                                                </span>
                                                <p class="pull-right">
                                                    <a href="javascript:void(0);" class="btn4" onclick="savepopup(<?php echo $_searchJob['post_id'];?>)">Save</a>
                                                    <a href="javascript:void(0);" class="btn4" onclick="applypopup(<?php echo $_searchJob['post_id'];?>,<?php echo $_searchJob['user_id'];?>)">Apply</a>
                                                </p>

                                            </div>
                                        </div>
                                        <?php 
                                            endforeach;
                                        endif; ?>
                                        <!--.........AJAX DATA......-->           
                                    </div>
                                    <?php echo $links; ?>
                                    <div class="fw" id="loader" style="text-align:center;display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="loaderimage"/></div>
                                </div>
								
                            </div>
							<div class="banner-add">
									<?php $this->load->view('banner_add'); ?>
								</div>
                        <!--</div>-->
                    </div>
                    <div id="hideuserlist" class="right-part animated fadeInRightBig"> 
						<?php $this->load->view('right_add_box'); ?>
                    </div>

                </div>
				<?php echo $login_footer; ?>
				<!-- mobile filter  -->
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
                            <?php echo $job_filter; ?>
							<!-- <form name="job-company-filter" id="job-company-filter">
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
									<p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-companies">View More Companies</a></p>
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
									<p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-categories">View More Categories</a></p>
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
									<p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-location">View More Cities</a></p>
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
									<p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-skills">View More Skills</a></p>
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
							</form> -->
						</div>
                    </div>
                </div>
            </div>
        </div>
	<!-- end mobile filter  -->
				
            </div>   
   
    <!-- Model Popup Open -->
	
	
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

<?php $this->load->view('mobile_side_slide'); ?>
<?php echo $footer; ?>

    <!-- script for skill textbox automatic start-->

    <?php
    /*if (IS_JOB_JS_MINIFY == '0') {
        ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
<?php } else { ?>


        <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver=' . time()) ?>"></script>

<?php }*/ ?>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
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
        var q = '';
        var l = '';
        var w = '';
        var login_user_id = "<?php echo $userid_login; ?>";
        var job_profile_set = "<?php echo $this->job_profile_set; ?>";
        var job_deactive = "<?php echo $job_deactive; ?>";
        var filter_url = "<?php echo $filter_url; ?>";
        
        var app = angular.module('jobSearchNRApp', ['ngRoute','ui.bootstrap']);
        $(document).ready(function(){
                $(window).scrollTop(500);
            });
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
            /*$(document).click(function(){
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
    <script src="<?php echo base_url('assets/js/webpage/job-live/searchJob.js?ver=' . time()) ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/job_search_login_new_search_no_regi_site.js?ver=' . time()); ?>"></script>
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement":
        [
            {
                "@type": "ListItem",
                "position": 1,
                "item":
                {
                    "@id": "<?php echo base_url(); ?>",
                    "name": "Aileensoul"
                }
            },
            {
                "@type": "ListItem",
                "position": 2,
                "item":
                {
                    "@id": "<?php echo base_url(); ?>job-search",
                    "name": "Jobs"
                }
            },
            {
                "@type": "ListItem",
                "position": 3,
                "item":
                {
                    "@id": "<?php echo  $schema_url_item3; ?>",
                    "name": "<?php echo  $schema_name_item3; ?>"
                }
            },
            {
                "@type": "ListItem",
                "position": 4,
                "item":
                {
                    "@id": "<?php echo current_url(); ?>",
                    "name": "<?php echo  $schema_name_item4; ?>"
                }
            }
        ]
    }
    </script>
</body>
</html>