<!DOCTYPE html>
<html lang="en" ng-app="artistProfileApp" ng-controller="artistProfileController">
	<head>
		<title><?php echo $title; ?></title>
		<?php echo $head; ?>
		<?php
		if (IS_ART_CSS_MINIFY == '0') {
			?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
			
		<?php }else{?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
			
		<?php }?>
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css?ver=' . time()) ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/artistic.css?ver='.time()); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
		<!-- END HEADER -->
		<?php $this->load->view('adsense');
        $user_first_name = ucwords($artisticdata[0]['art_name']); ?>
	</head>
	<body class="page-container-bg-solid page-boxed botton_footer body-loader">
		<?php $this->load->view('page_loader'); ?>
		<div id="main_page_load" style="display: block;">
			<?php echo $header; ?>
			<?php //echo $art_header2_border; ?>
			<?php echo $artistic_header2; ?>
			<section class="custom-row">
				<?php echo $artistic_common; ?>
				<div class="container mobp0">
					<div class="all-detail-custom">
					
						<div class="custom-user-list">
							<div class="edit-custom-move">
								
							</div>
					<div class="all-detail-custom">
    					<div class="gallery" id="gallery">
    						
    						<!--  01 Bio  -->
    						<div class="gallery-item">
    							<div class="dtl-box">
    								<div class="dtl-title">
    									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/prof-sum.png?ver=' . time()) ?>"><span>Bio</span>
                                        <a href="#"  ng-if="from_user_id == to_user_id" data-target="#bio" data-toggle="modal" class="pull-right">
                                            <img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>">
                                        </a>
    								</div>
    								<div id="bio-loader" class="dtl-dis">
                                        <div class="text-center">
                                            <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                        </div>
                                    </div>
                                    <div id="bio-body" style="display: none;">
                                        <div class="dtl-dis">
                                            <div class="no-info" ng-if="user_bio == ''">
                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                <span ng-if="from_user_id == to_user_id">Describe briefly about what your interests are, what you have done and what you want to do.</span>
                                                <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any Bio yet.</span>
                                            </div>
                                            <div class="" ng-if="user_bio != ''">
                                                <h4>About</h4>
                                                <p dd-text-collapse dd-text-collapse-max-length="350" dd-text-collapse-text="{{user_bio}}" dd-text-collapse-cond="true">{{user_bio}}</p>
                                            </div>
                                        </div>
                                    </div>								
    							</div>
    						</div>
    						
    						<!--  02 Edit profile  -->
    						<div id="edit-custom-move" class="gallery-item edit-profile-move">
    							<div class="abailability-move">
    							</div>
    						</div>
    						
    						<!--  03 Basic information  -->
    						<div class="gallery-item">
    						</div>
    						
    						<!--  04 Basic information  -->
    						<div class="gallery-item">
    							<div class="dtl-box">
    								<div class="dtl-title">
    									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>"><span>Basic Information</span><a href="#" class="pull-right" ng-click="edit_art_basic_info();" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
    								</div>
                                    <div id="art-info-loader" class="dtl-dis">
                                        <div class="text-center">
                                            <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                        </div>
                                    </div>
                                    <div id="art-info-body" style="display: none;">
        								<div id="about-detail" class="dtl-dis">
        									<ul class="dis-list list-ul-cus">
        										<li>
        											<span>Art category</span>
        											<label class="text-capitalize">{{artist_basic_info.art_category_txt | removeOther}}{{artist_basic_info.art_category_txt != 'other' && artist_basic_info.art_category_txt != '' && artist_basic_info.other_category_txt? ',' : ''}}{{artist_basic_info.other_category_txt}}</label>
        										</li>
        										<li ng-if="artist_basic_info.art_gender">
        											<span>Gender</span>
                                                    <label ng-if="artist_basic_info.art_gender =='1'">Male</label>
                                                    <label ng-if="artist_basic_info.art_gender =='2'">Female</label>
        											<label ng-if="artist_basic_info.art_gender =='3'">Other</label>
        										</li>
        										<li ng-if="artist_basic_info.art_dob">
        											<span>Date of Birth</span>
        											<label>{{artist_basic_info.art_dob_txt}}</label>
        										</li>
        										<li>
        											<span>Location</span>
        											<label ng-if="artist_basic_info.country_name || artist_basic_info.state_name || artist_basic_info.city_name">
                                                        {{artist_basic_info.city_name != '' ? artist_basic_info.city_name : ''}}
                                                        {{artist_basic_info.city_name != '' && artist_basic_info.state_name != '' ? ',' : ''}}
                                                        {{artist_basic_info.state_name != '' ? artist_basic_info.state_name : ''}}
                                                        {{artist_basic_info.state_name != '' && artist_basic_info.country_name != '' ? ',' : ''}}
                                                        {{artist_basic_info.country_name != '' ? artist_basic_info.country_name : ''}}
                                                    </label>
        										</li>    										
        									</ul>
        								</div>
                                    </div>
    								<div id="view-more-about" class="about-more" style="display: none;">
    									<a href="#" ng-click="view_more_about();">View More <img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>"></a>
    								</div>
    								
    							</div>
    						</div>
    						
    						<!--  05 Language  -->
    						<div class="gallery-item language-move">
    						</div>
    						
    						<!--  06 Type of talant  -->
    						<div class="gallery-item type-talant-move">
    						</div>
    						
    						<!--  07 Educational Info  -->
    						<div class="gallery-item">
                                <div class="dtl-box">
                                    <div class="dtl-title">
                                        <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/edution.png"><span>Educational Info</span><a href="#" data-target="#educational-info" data-toggle="modal" ng-click="reset_edu_form();" class="pull-right" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                    </div>
                                    <div id="edution-loader" class="dtl-dis">
                                        <div class="text-center">
                                            <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                        </div>
                                    </div>
                                    <div id="edution-body" style="display: none;">
                                        <div class="dtl-dis" ng-if="user_education.length < 1">
                                            <div class="no-info">
                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                <span ng-if="from_user_id == to_user_id">Showcase what degrees you have! From which school or university you have graduated.</span>
                                                <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any educational details yet.</span>
                                            </div>
                                        </div>
                                        <div class="dtl-dis dis-accor" ng-if="user_education.length > 0">
                                            <div class="panel-group" id="edu-accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default" ng-repeat="user_edu in user_education" ng-if="$index <= view_more_edu">
                                                    <div class="panel-heading" role="tab" id="edu-{{$index}}">
                                                        <div class="panel-title">
                                                            <div class="dis-left">
                                                                <div class="dis-left-img">
                                                                    <span>{{user_edu.edu_school_college | limitTo:1 | uppercase}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="dis-middle">
                                                                <h4>{{user_edu.edu_school_college}}</h4>
                                                                <p ng-if="user_edu.edu_degree == '0'">{{user_edu.edu_other_degree}}</p>
                                                                <p ng-if="user_edu.edu_degree != '0'">{{user_edu.degree_name}}</p>
                                                            </div>
                                                            <div class="dis-right">
                                                                <span role="button" ng-click="edit_user_edu($index)" class="pr5" ng-if="from_user_id == to_user_id">
                                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                                </span>
                                                                <span role="button" data-toggle="collapse" data-parent="#edu-accordion" href="#edu{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                                </span>
                                                            </div>
                         
                                                        </div>
                                                    </div>
                                                    <div id="edu{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="edu-{{$index}}">
                                                        <div class="panel-body">
                                                            <ul class="dis-list list-ul-cus">
                                                                <li class="select-preview">
                                                                    <span>Duration</span> 
                                                                    <label ng-if="user_edu.start_date_str">{{user_edu.start_date_str}} to</label>
                                                                    <label ng-if="user_edu.end_date_str != null && end_date_str != ''">{{user_edu.end_date_str}}</label> 
                                                                    <label ng-if="user_edu.end_date_str == null || end_date_str == ''">Pursuing</label>
                                                                </li>
                                                                <li class="select-preview">
                                                                    <span>Board / University</span>
                                                                    <label ng-if="user_edu.edu_university == '0'">{{user_edu.edu_other_university}}</label>
                                                                    <label ng-if="user_edu.edu_university != '0'">{{user_edu.university_name}}</label>
                                                                </li>
                                                                <li class="select-preview">
                                                                    <span>Course / Field of Study / Stream</span>
                                                                    <label ng-if="user_edu.edu_stream == '0'">{{user_edu.edu_other_stream}}</label>
                                                                    <label ng-if="user_edu.edu_stream != '0'">{{user_edu.stream_name}}</label>
                                                                </li>
                                                                <li ng-if="user_edu.edu_file != '' && user_edu.edu_file != null">
                                                                    <span>Document</span>
                                                                    <p class="screen-shot" check-file-ext check-file="{{user_edu.edu_file}}" check-file-path="<?php echo "'".addslashes(ART_USER_EDUCATION_UPLOAD_URL)."'"; ?>">
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="view-more-edu" class="about-more" ng-if="user_education.length > 3">
                                                    <a href="javascript:void(0);" ng-click="edu_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    						
    						<!--  08  Experience  -->
    						<div class="gallery-item">
                                <div class="dtl-box">
                                    <div class="dtl-title">
                                        <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/exp.png">
                                        <span>Experience                                        
                                            <span class="exp-y-m-inner" ng-if="exp_years > '0' || exp_months > '0'">(
                                                <span ng-if="exp_years > '0'">{{exp_years}} year{{exp_years > '1' ? 's' : ''}}</span>
                                                <span ng-if="exp_months > '0'">{{exp_months}} month{{exp_months > '1' ? 's' : ''}}</span>
                                                 )
                                            </span>
                                        </span>
                                            <a href="#" ng-if="from_user_id == to_user_id" ng-click="reset_exp_form()" data-target="#experience" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                    </div>
                                    <div id="exp-loader" class="dtl-dis">
                                        <div class="text-center">
                                            <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                        </div>
                                    </div>
                                    <div id="exp-body" style="display: none;">
                                        <div class="dtl-dis" ng-if="user_experience.length < '1'">
                                            <div class="no-info">
                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                <span ng-if="from_user_id == to_user_id">Add your experiences details whether it's working somewhere or owning a business.</span>
                                                <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any experience details yet.</span>
                                            </div>
                                        </div>
                                        <div class="dtl-dis dis-accor" ng-if="user_experience.length > '0'">
                                            <div class="panel-group" id="exp-accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default" ng-repeat="user_exp in user_experience" ng-if="$index <= view_more_exp">
                                                    <div class="panel-heading" role="tab" id="exp-{{$index}}">
                                                        <div class="panel-title">
                                                            <div class="dis-left">
                                                                <div class="dis-left-img">
                                                                    <span>{{user_exp.exp_company_name | limitTo:1 | uppercase}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="dis-middle">
                                                                <h4>{{user_exp.exp_company_name}}</h4>
                                                                <p>{{user_exp.designation}}</p>
                                                            </div>
                                                            <div class="dis-right">
                                                                <span role="button" ng-click="edit_user_exp($index)" class="pr5" ng-if="from_user_id == to_user_id">
                                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                                </span>
                                                                <span role="button" data-toggle="collapse" data-parent="#exp-accordion" href="#exp{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                                </span>
                                                            </div>
                         
                                                        </div>
                                                    </div>
                                                    <div id="exp{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="exp-{{$index}}">
                                                        <div class="panel-body">
                                                            <ul class="dis-list list-ul-cus">
                                                                <li class="select-preview">
                                                                    <span>Time Period</span> 
                                                                    <label>{{user_exp.start_date_str}} to</label>
                                                                    <label ng-if="user_exp.end_date_str != '' && user_exp.end_date_str != null">{{user_exp.end_date_str}}</label> 
                                                                    <label ng-if="user_exp.end_date_str == '' || user_exp.end_date_str == null">Still Working</label>
                                                                </li>
                                                                <li>
                                                                    <span>Company Location</span>
                                                                    {{user_exp.city_name}},{{user_exp.state_name}},{{user_exp.country_name}} 
                                                                </li>
                                                                <li ng-if="user_exp.exp_company_website != '' && user_exp.exp_company_website != null">
                                                                    <span>Website</span>
                                                                    <a href="{{user_exp.exp_company_website}}" target="_self">{{user_exp.exp_company_website}}</a>
                                                                </li>
                                                                <li>
                                                                    <span>Description</span>
                                                                    <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_exp.exp_desc}}" dd-text-collapse-cond="true">{{user_exp.exp_desc}}</label>
                                                                </li>
                                                                <li ng-if="user_exp.exp_file != '' && user_exp.exp_file != null">
                                                                    <span>Document</span>
                                                                    <p class="screen-shot" check-file-ext check-file="{{user_exp.exp_file}}" check-file-path="<?php echo "'".addslashes(ART_USER_EXPERIENCE_UPLOAD_URL)."'"; ?>">
                                                                        <!-- <img src="<?php echo base_url(); ?>assets/n-images/art-img.jpg"> -->
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="view-more-exp" class="about-more" ng-if="user_experience.length > '3'">
                                                    <a href="#" ng-click="exp_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    						
    						<!--  09 Portfolio  -->
    						<div class="gallery-item">
    							<div class="dtl-box">
    								<div class="dtl-title">
    									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/bus-portfolio.png?ver=' . time()) ?>"><span>Art Portfolio</span><a href="#"  ng-if="from_user_id == to_user_id" data-target="#art-portfolio" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
    								</div>
    								<div id="portfolio-loader" class="dtl-dis">
    		                            <div class="text-center">
    		                                <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
    		                            </div>
    		                        </div>
    		                        <div id="portfolio-body" style="display: none;">
    		                            <div class="dtl-dis" ng-if="user_portfolio.length < '1'">
    		                                <div class="no-info">
    		                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
    		                                    <span ng-if="from_user_id == to_user_id">Show your talent to the world. Attach your art portfolio.</span>
    		                                    <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any portfolio yet.</span>
    		                                </div>
    		                            </div>
    									<div class="dtl-dis dis-accor">
    										<div class="panel-group" id="project-accordion" role="tablist" aria-multiselectable="true">
    											<div class="panel panel-default" ng-repeat="portfolio in user_portfolio" ng-if="$index <= view_more_port">
    												<div class="panel-heading" role="tab" id="p-{{$index}}">
    													<div class="panel-title">
    														<div class="dis-left">
    															<div class="dis-left-img">
    																<span>{{portfolio.portfolio_title | limitTo:1 | uppercase}}</span>
    															</div>
    														</div>
    														<div class="dis-middle">
    															<h4>{{portfolio.portfolio_title}}</h4>
    														</div>
    														<div class="dis-right">
    															<a href="javascript:void(0);" ng-if="from_user_id == to_user_id" class="pr5" ng-click="edit_portfolio($index);">
    																<img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>">
    															</a>
    															<span role="button" data-toggle="collapse" data-parent="#project-accordion" href="#p{{$index}}" aria-expanded="false" aria-controls="p{{$index}}" class="collapsed up-down">
    																<img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>">
    															</span>
    														</div>
    													</div>
    												</div>
    												<div id="p{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="p-{{$index}}" aria-expanded="false" style="height: 0px;">
    													<div class="panel-body">
    														<ul class="dis-list list-ul-cus">				
    															<li>
    																<span>Description</span>
    																<label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{portfolio.portfolio_desc}}" dd-text-collapse-cond="true">{{portfolio.portfolio_desc}}</label>
    															</li>
    															<li ng-if="portfolio.portfolio_file != '' && portfolio.portfolio_file != null">
    		                                                        <span>Project File</span>
    		                                                        <p class="screen-shot" check-file-ext check-file="{{portfolio.portfolio_file}}" check-file-path="<?php echo "'".addslashes(ART_USER_PORTFOLIO_UPLOAD_URL)."'"; ?>">
    		                                                        </p>
    		                                                    </li>
    														</ul>
    													</div>
    												</div>
    											</div>
    											<div id="view-more-pr" class="about-more" ng-if="user_portfolio.length > '3'">
    		                                        <a href="javascript:void(0);" ng-click="port_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
    		                                    </div>
    										</div>
    									</div>
    								</div>								
    							</div>
    						</div>
    						
    						<!--  10 social profile  -->
    						<div class="gallery-item social-link-move">
                            </div>
    						
    						<!--  11 Preferred Work   -->
    						<div class="gallery-item">
    							<div class="dtl-box">
    								<div class="dtl-title">
    									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/work.png?ver=' . time()) ?>"><span>Preferred Work </span><a href="#" class="pull-right" ng-click="edit_art_preferred_info();" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
    								</div>
                                    <div id="art-preffered-loader" class="dtl-dis">
                                        <div class="text-center">
                                            <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                        </div>
                                    </div>
                                    <div id="art-preffered-body" style="display: none;">
        								<div id="preffered-detail" class="dtl-dis">
        									<ul class="dis-list list-ul-cus">
        										<li class="select-preview">
        											<span>Preferred Category</span>
                                                    <label class="text-capitalize">{{artist_basic_info.art_category_txt | removeOther}}{{artist_basic_info.art_category_txt != 'other' && artist_basic_info.art_category_txt != '' && artist_basic_info.other_category_txt? ',' : ''}}{{artist_basic_info.other_category_txt}}</label>
        										</li>
        										<li class="fw" ng-if="artist_preferred_info.preffered_skills">
        											<span>Skills</span>
        											<ul	class="skill-list">
        												<li ng-repeat="pref_skill in artist_preferred_info.preffered_skills.split(',')">{{pref_skill}}</li>
        											</ul>
        										</li>
        										<li ng-if="artist_preferred_info.preffered_country_name || artist_preferred_info.preffered_state_name || artist_preferred_info.preffered_city_name">
        											<span>Preferred Location</span>
        											<label ng-if="artist_preferred_info.preffered_country_name || artist_preferred_info.preffered_state_name || artist_preferred_info.preffered_city_name">
                                                        {{artist_preferred_info.preffered_city_name != '' ? artist_preferred_info.preffered_city_name : ''}}
                                                        {{artist_preferred_info.preffered_city_name != '' && artist_preferred_info.preffered_state_name != '' ? ',' : ''}}
                                                        {{artist_preferred_info.preffered_state_name != '' ? artist_preferred_info.preffered_state_name : ''}}
                                                        {{artist_preferred_info.preffered_state_name != '' && artist_preferred_info.preffered_country_name != '' ? ',' : ''}}
                                                        {{artist_preferred_info.preffered_country_name != '' ? artist_preferred_info.preffered_country_name : ''}}
                                                    </label>
        										</li>
        										<li class="select-preview" ng-if="artist_preferred_info.preffered_availability">
        											<span>Availability</span>
                                                    <label ng-if="artist_preferred_info.preffered_availability == '1'">Full Time</label>
                                                    <label ng-if="artist_preferred_info.preffered_availability == '2'">Part Time</label>
                                                    <label ng-if="artist_preferred_info.preffered_availability == '3'">Contract</label>
        											<label ng-if="artist_preferred_info.preffered_availability == '4'">Freelance</label>
        										</li>
        									</ul>
        								</div>
                                    </div>
    								<div id="view-more-preffered" class="about-more" style="display: none;">
    									<a href="#" ng-click="view_more_preffered();">View More <img src="<?php echo base_url('assets/n-images/detail/down-arrow.png?ver=' . time()) ?>"></a>
    								</div>
    							</div>
    						</div>
    						
    						<!--  12 Specialities  -->
    						<div class="gallery-item">
    							<div class="dtl-box">
    								<div class="dtl-title">
    									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/key-member.png?ver=' . time()) ?>"><span>Specialities</span><a href="#" class="pull-right" ng-click="edit_user_specialities();" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
    								</div>
    								<div id="specialities-loader" class="dtl-dis">
                                        <div class="text-center">
                                            <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                        </div>
                                    </div>
                                    <div id="specialities-body" style="display: none;">
                                        <div class="dtl-dis" ng-if="!art_speciality_data.art_spl_tags && !art_speciality_data.art_spl_desc">
                                            <div class="no-info">
                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                <span ng-if="from_user_id == to_user_id">What is the one thing that separates you from others? Highlight it on your profile.</span>
                                                <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any specialities yet.</span>
                                            </div>
                                        </div>
    									<div class="dtl-dis" ng-if="art_speciality_data.art_spl_tags || art_speciality_data.art_spl_desc">
    										<ul class="dis-list list-ul-cus">
    											<li class="fw" ng-if="art_speciality_data.art_spl_tags != ''">
    												<span>Tags</span>
    												<ul	class="skill-list">
    													<li ng-repeat="speciality in art_speciality_data.art_spl_tags.split(',')">{{speciality}}</li>
    												</ul>
    											</li>
    											<li ng-if="art_speciality_data.art_spl_desc != ''">
    												<span>Description</span>
    												<p dd-text-collapse dd-text-collapse-max-length="350" dd-text-collapse-text="{{art_speciality_data.art_spl_desc}}" dd-text-collapse-cond="true">{{art_speciality_data.art_spl_desc}}</p>
    											</li>
    										</ul>
    									</div>
    								</div>								
    							</div>
    						</div>
    						
    						<!--  13 blank div  -->
    						<div class="gallery-item" >
    						</div>
    						
    						<!--  14 software  -->
    						<div class="gallery-item software-move" >
    						
    							<div class="dtl-box">
    								<div class="dtl-title">
    									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/software.png?ver=' . time()) ?>"><span>Software / Instrument/ Skills</span><a href="#" class="pull-right" ng-click="edit_soft_inst_skill();" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
    								</div>
    								<div id="soft_inst_skill-loader" class="dtl-dis">
                                        <div class="text-center">
                                            <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                        </div>
                                    </div>
                                    <div id="soft_inst_skill-body" style="display: none;">
                                        <div class="dtl-dis" ng-if="!art_soft_inst_skill">
                                            <div class="no-info">
                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                <span ng-if="from_user_id == to_user_id">At what you are good. Add your expertise to profile.</span>
                                                <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any skills yet.</span>
                                            </div>
                                        </div>
    									<div class="dtl-dis" ng-if="art_soft_inst_skill">
    										<ul class="dis-list list-ul-cus">
    											<li class="fw">
    												<span>Tags</span>
    												<ul	class="skill-list">
    													<li ng-repeat="sis in art_soft_inst_skill.split(',')">{{sis}}</li>
    												</ul>
    											</li>
    										</ul>
    									</div>
    								</div>								
    							</div>
    						</div>
    						
    						<!--  15 Achievements and Awards  -->
    						<div class="gallery-item">
                                <div class="dtl-box">
                                    <div class="dtl-title">
                                        <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/achi-awards.png"><span>Achievements & Awards</span><a href="#" data-target="#Achiv-awards" data-toggle="modal" ng-click="reset_awards_form();" class="pull-right" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                    </div>
                                    <div id="awards-loader" class="dtl-dis">
                                        <div class="text-center">
                                            <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                        </div>
                                    </div>
                                    <div id="awards-body" style="display: none;">
                                        <div class="dtl-dis" ng-if="user_award.length < '1'">
                                            <div class="no-info">
                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                <span ng-if="from_user_id == to_user_id">Add the achievements and awards that you have earned.</span>
                                                <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any achievements & awards yet.</span>
                                            </div>
                                        </div>
                                        <div class="dtl-dis dis-accor" ng-if="user_award.length > '0'">
                                            <div class="panel-group" id="award-accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default" ng-repeat="user_awrd in user_award" ng-if="$index <= view_more_award">
                                                    <div class="panel-heading" role="tab" id="award-{{$index}}">
                                                        <div class="panel-title">
                                                            <div class="dis-left">
                                                                <div class="dis-left-img">
                                                                    <span>{{user_awrd.award_title | limitTo:1 | uppercase}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="dis-middle">
                                                                <h4>{{user_awrd.award_title}}</h4>        
                                                                <p>{{user_awrd.award_org}}</p>
                                                            </div>
                                                            <div class="dis-right">
                                                                <span role="button" ng-click="edit_user_award($index)" class="pr5" ng-if="from_user_id == to_user_id">
                                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                                </span>
                                                                <span role="button" data-toggle="collapse" data-parent="#award-accordion" href="#award{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                                </span>
                                                            </div>
                         
                                                        </div>
                                                    </div>
                                                    <div id="award{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="award-{{$index}}">
                                                        <div class="panel-body">
                                                            <ul class="dis-list list-ul-cus">
                                                                <li class="select-preview">
                                                                    <span>Date</span> 
                                                                    <label>{{user_awrd.award_date_str}}</label>
                                                                </li>
                                                                <li>
                                                                    <span>Description</span>
                                                                    <label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_awrd.award_desc}}" dd-text-collapse-cond="true">{{user_awrd.award_desc}}</label>
                                                                </li>
                                                                <li ng-if="user_awrd.award_file != '' && user_awrd.award_file != null">
                                                                    <span>Document</span>
                                                                    <p class="screen-shot" check-file-ext check-file="{{user_awrd.award_file}}" check-file-path="<?php echo "'".addslashes(ART_USER_AWARD_UPLOAD_URL)."'"; ?>">
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="view-more-award" class="about-more" ng-if="user_award.length > '3'">
                                                    <a href="#" ng-click="award_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    						
    						<!--  16 Additional Course  -->
    						<div class="gallery-item">
                                <div class="dtl-box">
                                    <div class="dtl-title">
                                        <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/add-course.png"><span>Additional Course</span><a href="#" data-target="#additional-course" data-toggle="modal" ng-click="reset_addicourse_form();" class="pull-right" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                                    </div>
                                    <div id="addicourse-loader" class="dtl-dis">
                                        <div class="text-center">
                                            <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                        </div>
                                    </div>
                                    <div id="addicourse-body" style="display: none;">
                                        <div class="dtl-dis" ng-if="user_addicourse.length < '1'">
                                            <div class="no-info">
                                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                                <span ng-if="from_user_id == to_user_id">Highlight the other online or offline courses you have pursued.</span>
                                                <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any additional course details yet.</span>
                                            </div>
                                        </div>
                                        <div class="dtl-dis dis-accor" ng-if="user_addicourse.length > '0'">
                                            <div class="panel-group" id="addicourse-accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default" ng-repeat="user_course in user_addicourse" ng-if="$index <= view_more_ac">
                                                    <div class="panel-heading" role="tab" id="addicourse-{{$index}}">
                                                        <div class="panel-title">
                                                            <div class="dis-left">
                                                                <div class="dis-left-img">
                                                                    <span>{{user_course.addicourse_name | limitTo:1 | uppercase}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="dis-middle">
                                                                <h4>{{user_course.addicourse_name}}</h4>        
                                                                <p>{{user_course.addicourse_org}}</p>
                                                            </div>
                                                            <div class="dis-right">
                                                                <span role="button" ng-click="edit_user_addicourse($index)" class="pr5" ng-if="from_user_id == to_user_id">
                                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                                </span>
                                                                <span role="button" data-toggle="collapse" data-parent="#addicourse-accordion" href="#addicourse{{$index}}" aria-expanded="true" aria-controls="exp1" class="up-down collapsed">
                                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                                </span>
                                                            </div>
                         
                                                        </div>
                                                    </div>
                                                    <div id="addicourse{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="addicourse-{{$index}}">
                                                        <div class="panel-body">
                                                            <ul class="dis-list list-ul-cus">
                                                                <li>
                                                                    <span>Duration</span> 
                                                                    <label>{{user_course.start_date_str}} to</label>
                                                                    <label ng-if="user_course.end_date_str != '' && user_course.end_date_str != null">{{user_course.end_date_str}}</label> 
                                                                    <label ng-if="user_course.end_date_str == '' || user_course.end_date_str == null">Studying</label>
                                                                </li>
                                                                <li ng-if="user_course.addicourse_url != ''">
                                                                    <span>Website</span> 
                                                                    <div class="dis-list-link">
                                                                    <a href="{{user_course.addicourse_url}}" target="_self">{{user_course.addicourse_url}}</a>
                                                                    </div>
                                                                </li>
                                                                <li ng-if="user_course.addicourse_file != '' && user_course.addicourse_file != null">
                                                                    <span>Document</span>
                                                                    <p class="screen-shot" check-file-ext check-file="{{user_course.addicourse_file}}" check-file-path="<?php echo "'".addslashes(ART_USER_ADDICOURSE_UPLOAD_URL)."'"; ?>">
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="view-more-addicourse" class="about-more" ng-if="user_addicourse.length > '3'">
                                                    <a href="#" ng-click="ac_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    					
    					</div>
					</div>
					</div>
					<div class="right-add">
					<!-- Availability  -->
						<div class="rsp-dtl-box">
							<div class="dtl-box" id="abailability-move">
                                <div id="art_imp-loader" class="dtl-dis">
                                    <div class="text-center">
                                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                    </div>
                                </div>
                                <div id="art_imp-body" style="display: none;">
                                    <div class="dtl-dis">
    									<ul class="dis-list cus-status list-ul-cus">
                                            <li>
                                                <label class="fw">
                                                    <span ng-if="art_imp_data == '1'">
                                                        <span class="job-active"></span>Open for work
                                                    </span>
                                                    <span ng-if="art_imp_data == '2'">
                                                        <span class="job-passive"></span>Open for Collaboration
                                                    </span>
                                                    <span ng-if="art_imp_data == '3'">
                                                        <span class="job-not"></span>Not now
                                                    </span>
                                                    <span ng-if="art_imp_data != '1' && art_imp_data != '2' && art_imp_data != '3'">
                                                        <span class="job-status"></span>Artist Availability Status
                                                    </span>
    												<span class="pull-right">
                                                    <a href="#" ng-if="from_user_id == to_user_id" data-target="#availability" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit1.png?ver=' . time()) ?>"></a>
    												</span>
                                                </label>
                                            </li>
                                        </ul>
    								</div>
                                </div>
							</div>
						</div>
							
						<div class="dtl-box p10 dtl-adv">
								<img src="<?php echo base_url('assets/n-images/detail/add.png?ver=' . time()) ?>">
						</div>
							
					<!-- edit profile  -->
					<div class="rsp-dtl-box">
						<div class="dtl-box" id="edit-profile-move" ng-if="from_user_id == to_user_id">
							<div class="dtl-title">
								<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/e-profile.png?ver=' . time()) ?>"><span>Edit Profile</span>
							</div>
							<div class="dtl-dis dtl-edit-p">
                                <div class="dtl-edit-top"></div>
                                <div class="profile-status">
                                    <ul>
                                        <li><span class=""><img ng-if="progress_status.user_image_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Profile pic</li>

                                        <li class="pl20"><span class=""><img ng-if="progress_status.profile_background_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Cover pic</li>
                                        
                                        <li><span class=""><img ng-if="progress_status.user_experience_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Experience</li>

                                        <li class="pl20"><span class=""><img ng-if="progress_status.user_languages_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Languages</li>
                                        
                                        <li><span class=""><img ng-if="progress_status.user_bio_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Bio</li>

                                        <li class="pl20"><span class=""><img ng-if="progress_status.user_links_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Social</li>
                                        
                                        <li><span class=""><img ng-if="progress_status.fname_status == '1' && progress_status.lname_status == '1' && progress_status.category_status == '1' && progress_status.gender_status == '1' && progress_status.email_status == '1' && progress_status.phnno_status == '1' && progress_status.dob_status == '1' && progress_status.country_status == '1' && progress_status.state_status == '1' && progress_status.city_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Basic info</li>

                                        <li class="fw"><span class=""><img ng-if="progress_status.user_education_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Educational Info</li>

                                        <li class="fw"><span class=""><img ng-if="progress_status.active_status_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Availability Status</li>

                                        <li class="fw"><span class=""><img ng-if="progress_status.preffered_skills_status == '1' && progress_status.preffered_country_status == '1' && progress_status.preffered_state_status == '1' && progress_status.preffered_city_status == '1' && progress_status.preffered_availability_status == '1' " src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Preferred Work</li>
                                    </ul>
                                </div>
                                <div class="dtl-edit-bottom"></div>
                                <div class="p20">
                                    <!-- <img src="<?php //echo base_url('assets/n-images/detail/profile-progressbar.jpg?ver=' . time()) ?>"> -->
                                    <div id="profile-progress" class="edit_profile_progress" style="display: none;">
                                        <div class="count_main_progress">
                                            <div class="circles">
                                                <div class="second circle-1">
                                                    <div>
                                                        <strong></strong>
                                                        <span id="progress-txt"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                
                            </div>
						</div>
					</div>
					
					<!-- Social Link  -->
					<div class="rsp-dtl-box">
						<div id="social-link-move" class="dtl-box">
			                <div class="dtl-title">
			                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/website.png"><span>Social Profile</span><a href="#" data-target="#social-link" data-toggle="modal" class="pull-right" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
			                </div>
			                <div id="social-link-loader" class="dtl-dis">
			                    <div class="text-center">
			                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
			                    </div>
			                </div>
			                <div id="social-link-body" style="display: none;">
			                    <div class="dtl-dis">
			                        <div class="no-info" ng-if="user_social_links.length < '1' && user_personal_links.length < '1'">
			                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
			                            <span ng-if="from_user_id == to_user_id">Add your other social profile links to get connected with people on other platforms.</span>
			                            <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any social link yet.</span>
			                        </div>
			                        <div class="social-links" ng-if="user_social_links.length > '0'">
			                            <h4>Social</h4>
			                            <ul class="social-link-list">
			                                <li ng-repeat="social_links in user_social_links">
			                                    <a href="{{social_links.user_links_txt}}" target="_self">
			                                        <img ng-if="social_links.user_links_type == 'Facebook'" src="<?php echo base_url(); ?>assets/n-images/detail/fb.png">
			                                        <img ng-if="social_links.user_links_type == 'Google'" src="<?php echo base_url(); ?>assets/n-images/detail/g-plus.png">
			                                        <img ng-if="social_links.user_links_type == 'LinkedIn'" src="<?php echo base_url(); ?>assets/n-images/detail/in.png">
			                                        <img ng-if="social_links.user_links_type == 'Pinterest'" src="<?php echo base_url(); ?>assets/n-images/detail/pin.png">
			                                        <img ng-if="social_links.user_links_type == 'Instagram'" src="<?php echo base_url(); ?>assets/n-images/detail/insta.png">
			                                        <img ng-if="social_links.user_links_type == 'GitHub'" src="<?php echo base_url(); ?>assets/n-images/detail/git.png">
			                                        <img ng-if="social_links.user_links_type == 'Twitter'" src="<?php echo base_url(); ?>assets/n-images/detail/twt.png">
			                                    </a>
			                                </li>
			                            </ul>
			                        </div>
			                        <div class="social-links" ng-if="user_personal_links.length > '0'">
			                            <h4 class="pt20 fw">Personal</h4>
			                            <ul class="social-link-list">
			                                <li ng-repeat="user_p_links in user_personal_links">
			                                    <a href="{{user_p_links.user_links_txt}}" target="_self">
			                                        <img src="<?php echo base_url(); ?>assets/n-images/detail/pr-web.png">
			                                    </a>
			                                </li>
			                            </ul>
			                        </div>
			                    </div>
			                </div>
			            </div>
					</div>
                        <!-- language  -->
				
						<div class="rsp-dtl-box " id="language-move">
							<div class="dtl-box">
                                <div class="dtl-title">
                                    <img class="cus-width" src="<?php echo base_url('assets/n-images/detail/language.png?ver=' . time()) ?>"><span>Language</span><a href="#" data-target="#language" data-toggle="modal" class="pull-right" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
                                </div>
                                <div id="language-loader" class="dtl-dis">
                                    <div class="text-center">
                                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                    </div>
                                </div>
                                <div id="language-body" style="display: none;">
                                    <div class="dtl-dis">
                                        <div class="no-info" ng-if="user_languages.length < '1'">
                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                            <span ng-if="from_user_id == to_user_id">How many languages do you know? Add them to your profile.</span>
                                            <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any languages.   </span>
                                        </div>
                                        <ul ng-if="user_languages.length > 0" class="known-language">
                                            <li ng-repeat="user_lang in user_languages">
                                                <span class="pr5">{{user_lang.language_name}}</span> - <span class="pl5">{{user_lang.proficiency}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
						</div>

                        <!-- Type of Talent / Category  -->
						<div class="rsp-dtl-box" id="type-talant-move">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/cat.png?ver=' . time()) ?>"><span>Type of Talent / Category</span><a href="#" class="pull-right" ng-click="edit_talent_cat();" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div id="talent_cat-loader" class="dtl-dis">
                                    <div class="text-center">
                                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                    </div>
                                </div>
                                <div id="talent_cat-body" style="display: none;">
                                    <div class="dtl-dis" ng-if="!art_talent_cat">
                                        <div class="no-info">
                                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                            <span ng-if="from_user_id == to_user_id">Add the category of your talent.</span>
                                            <span ng-if="from_user_id != to_user_id"><?php echo $user_first_name; ?> hasn't added any category yet.</span>
                                        </div>
                                    </div>
									<div class="dtl-dis" ng-if="art_talent_cat">
										<ul class="dis-list list-ul-cus">
											<li class="fw">
												<span>Skills</span>
												<ul	class="skill-list">
													<li ng-repeat="tal_cat in art_talent_cat.split(',')">{{tal_cat}}</li>
												</ul>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>	
					</div>
					</div>
				</div>
			</section>
		</div>
		
	<?php if($login_art_data[0]['user_id'] == $artisticdata[0]['user_id']): ?>
	<!---  model Start  -->	
	<!---  model basic information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="job-basic-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Basic Information</span>
					</div>
                    <form name="art_basic_info_form" id="arts_basic_info_form" ng-validate="arts_basic_info_validate">
    					<div class="dtl-dis">
    						<div class="row">
    							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
    								<div class="form-group">
    									<label>First Name</label>
    									<input type="text" placeholder="Name" id="art_fname" name="art_fname" maxlength="255">
    								</div>
    							</div>
    							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
    								<div class="form-group">
    									<label>Last Name</label>
    									<input type="text" placeholder="Last Name" id="art_lname" name="art_lname" maxlength="255">
    								</div>
    							</div>
    						</div>
    						<div class="row">
    							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
    								<div class="form-group">
    									<label>Art category</label>
    									<span class="span-select">
    										<select name="skills[]" id="skills" tabindex="1" autofocus multiple>
                                                <?php foreach($art_category as $_art_category){  ?>
    											<option onchange="return otherchange(<?php echo $_art_category['category_id']; ?>);" value="<?php echo $_art_category['category_id']; ?>"><?php echo ucwords(ucfirst($_art_category['art_category'])); ?></option>
                                                <?php } ?>
                                            </select>
    									</span>
    								</div>
    							</div>
    							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
    								<div class="form-group">
    									<label>Gender</label>
    									<span class="span-select">
    										<select id="art_gender" name="art_gender">
                                                <option value="">Select Gender</option>
    											<option value="1">Male </option>
    											<option value="2">Female </option>
    											<option value="3">Other </option>
    										</select>
    									</span>
    								</div>
    							</div>							
    						</div>

                            <div id="other_category_div" class="row" style="display: none;">
                                <div class="col-md-6 col-sm-6 col-xs-6 fw-479">
                                    <div class="form-group">
                                        <label>Other Category</label>
                                        <input type="text" placeholder="Other Category" id="art_other_category" name="art_other_category" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 fw-479">
                                </div>
                            </div>
    						
    						<div class="row">
    							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
    								<div class="form-group">
    									<label>Email</label>
    									<input type="text" placeholder="Email" id="art_email" name="art_email" maxlength="255">
    								</div>
    							</div>
    							<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
    								<div class="form-group">
    									<label>Phone number</label>
    									<input type="text" placeholder="Phone number" id="art_phnno" name="art_phnno" ng-model="art_phnno" numbers-only maxlength="15">
    								</div>
    							</div>
    						</div>
    						<div class="row">
    							<div class="col-md-12">
    								<label>Date of Birth</label>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-4">
    								<div class="form-group">    									
    									<span class="span-select">
    										<select id="art_dob_month" name="art_dob_month" ng-model="art_dob_month" ng-change="art_dob_date_fnc('','','')">
                                                <option value="">Month</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
    									</span>
    								</div>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-4">
    								<div class="form-group">
    									
    									<span class="span-select">
    										<select id="art_dob_day" name="art_dob_day" ng-model="art_dob_day" ng-click="art_dob_error()">
                                            </select>
    									</span>
    								</div>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-4">
    								<div class="form-group">
                                        <span class="span-select">
    										<select id="art_dob_year" name="art_dob_year" ng-model="art_dob_year" ng-change="art_dob_date_fnc('','','')" ng-click="art_dob_error()">
                                            </select>
    									</span>
    								</div>
    							</div>
                                <div class="col-md-12 col-sm-12">
                                    <span id="artdobdateerror" class="error" style="display: none;"></span>
                                </div>
    						</div>
    						
    						<div class="row">
    							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
    								<div class="form-group">
    									<label>Country</label>
    									<span class="span-select">
    										<select id="art_basic_country" name="art_basic_country" ng-model="art_basic_country" ng-change="art_basic_country_change()">
                                                <option value="">Country</option>         
                                                <option data-ng-repeat='country_item in exp_country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                            </select>
    									</span>
    								</div>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
    								<div class="form-group">
    									<label>State</label>
    									<span class="span-select">
    										<select id="art_basic_state" name="art_basic_state" ng-model="art_basic_state" ng-change="art_basic_state_change()" disabled = "disabled">
                                                <option value="">State</option>
                                                <option data-ng-repeat='state_item in art_basic_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                            </select>
                                            <img id="art_basic_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
    									</span>
    								</div>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
    								<div class="form-group">
    									<label>City</label>
    									<span class="span-select">
    										<select id="art_basic_city" name="art_basic_city" ng-model="art_basic_city" disabled = "disabled">
                                                <option value="">City</option>
                                                <option data-ng-repeat='city_item in art_basic_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                            </select>
                                            <img id="art_basic_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
    									</span>
    								</div>
    							</div>
    						</div>
    					</div>
    					<div class="dtl-btn">
    						<a id="art_basic_info_save" href="javascript:void(0);" ng-click="art_basic_info_save()" class="save">
                                <span>Save</span>
                            </a>
                            <div id="art_basic_info_save_loader"  class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                            </div>
    					</div>
                    </form>
				</div>
            </div>
        </div>
    </div>
	
	<!--  model tagline  -->
	<div style="display: none;" class="modal fade dtl-modal" id="tagline" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Tagline</span>
					</div>
					<div class="dtl-dis">
						<label>Enter tagline</label>
						<textarea type="text" placeholder="Enter tagline"></textarea>
						
					</div>
					<div class="dtl-btn">
							<a href="#" class="save"><span>Save</span></a>
						</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!--  model bio  -->
	<div style="display: none;" class="modal fade dtl-modal" id="bio" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Bio</span>
					</div>
					<div class="dtl-dis">
						<label>About</label>
						<textarea type="text" placeholder="Enter Bio" id="user_bio" name="user_bio" ng-model="user_bio"></textarea>
						<span class="pull-right">{{700 - user_bio.length}}</span>
						
					</div>					
					<div class="dtl-btn bottom-btn">
                        <!-- <a href="#" class="save"><span>Save</span></a> -->
                        <a id="user_bio_save" href="#" ng-click="save_art_bio()" class="save"><span>Save</span></a>
                        <div id="user_bio_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                        </div>
                    </div>
				</div>
			</div>
        </div>
    </div>
	
	<!--  model Type of Talent / Category  -->
	<div style="display: none;" class="modal fade dtl-modal" id="talent" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Type of Talent / Category</span>
					</div>
					<div class="dtl-dis">
						<label>Tags</label>
						<tags-input id="talent_cat_txt" ng-model="talent_cat_txt" display-property="tal_cat" placeholder="Enter Tags" replace-spaces-with-dashes="false" template="title-template"></tags-input>
					</div>
					<div class="dtl-btn">
						<a id="save_user_talent_cat" href="#" ng-click="save_user_talent_cat()" class="save"><span>Save</span></a>
                        <div id="user_talent_cat_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                        </div>
					</div>
				</div>
			</div>
        </div>
    </div>
	
	
	
	<!---  model Art Portfolio  -->
	<div style="display:none;" class="modal fade dtl-modal" id="art-portfolio" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Art Portfolio</span>
					</div>
					<form name="business_portfolio_form" id="business_portfolio_form" ng-validate="business_portfolio_validate">
						<div class="dtl-dis">
							<div class="form-group">
								<label>Title</label>
								<input type="text" placeholder="Title" id="portfolio_title" name="portfolio_title" maxlength="255">
							</div>
							<div class="form-group big-textarea">
								<label>Description</label>
								<textarea type="text" placeholder="Description" id="portfolio_desc" name="portfolio_desc" maxlength="700" ng-model="portfolio_desc"></textarea>
								<span class="pull-right">{{700 - portfolio_desc.length}}</span>
							</div>
							<div class="form-group">
								<div class="upload-file">
		                            <label>Upload File</label>
		                            <input type="file" id="portfolio_file" name="portfolio_file">
		                            <span id="portfolio_file_error" class="error" style="display: none;"></span>
		                        </div>								
							</div>
						</div>
						<div class="dtl-btn">
							<a id="portfolio_save" href="javascript:void(0);" ng-click="save_portfolio()" class="save">
								<span>Save</span>
							</a>
							<div id="portfolio_loader"  class="dtl-popup-loader" style="display: none;">
		                    	<img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
    <div class="modal fade message-box biderror" id="delete-portfolio-model" role="dialog">
	    <div class="modal-dialog modal-lm">
	        <div class="modal-content">
	            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
	            <div class="modal-body">
	                <span class="mes">
	                    <div class='pop_content'>
	                        <span>Are you sure you want to delete art portfolio ?</span>
	                        <p class='poppup-btns pt20'>
	                            <span id="portfolio-delete-btn">
	                                <a id="delete_portfolio" href="javascript:void(0);" ng-click="delete_portfolio()" class="btn1">
	                                    <span>Delete</span>
	                                </a> 
	                                <a class='btn1' href="javascript:void(0);" data-dismiss="modal">Cancel</a>
	                            </span>
	                            <img id="delete_portfolio_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
	                        </p>
	                    </div>
	                </span>
	            </div>
	        </div>
	    </div>
	</div>
	
	<!--  Availability  -->
	<div style="display: none;" id="availability" class="modal fade dtl-modal in" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
                    <div class="dtl-title">
                        <span>Availability</span>
                    </div>
                    <div class="dtl-dis">                                
                        <div class="form-group">
                            <!-- Use This! #just fix width+height IMG  -->
                            <div class="mm-dropdown">
                              <div class="textfirst">
                                <span ng-if="art_imp_data == '1'">
                                    <span class="job-active"></span>Open for Work
                                </span>
                                <span ng-if="art_imp_data == '2'">
                                    <span class="job-passive"></span>Open for Collaboration
                                </span>
                                <span ng-if="art_imp_data == '3'">
                                    <span class="job-not"></span>Not Now
                                </span>
                                <span ng-if="art_imp_data != '1' && art_imp_data != '2' && art_imp_data != '3'">
                                    Select Status
                                </span>
                              </div>
                              <ul>
                                <li class="input-option" data-value="1">
                                    <span class="job-active"></span>Open for Work
                                </li>
                                <li class="input-option" data-value="2">
                                    <span class="job-passive"></span>Open for Collaboration
                                </li>
                                <li class="input-option" data-value="3">
                                    <span class="job-not"></span>Not Now
                                </li>
								
                              </ul>
                              <input id="art_status" type="hidden" class="option" name="namesubmit" value="{{art_imp_data}}" />
                            </div>
                            <!-- End This -->
                        </div>
                        
                    </div>
                    <div class="dtl-btn bottom-btn">
                        <!-- <a href="#" class="save"><span>Save</span></a> -->
                        <a id="art_imp_save" href="#" ng-click="art_imp_save()" class="save"><span>Save</span></a>
                        <div id="art_imp_save_loader" class="dtl-popup-loader" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                        </div>
                    </div>
                </div>  


            </div>
        </div>
    </div>
	
	
	<!--  model Preferred Work  -->
	<div style="display: none;" class="modal fade dtl-modal" id="preferred-work" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Preferred Work</span>
					</div>
                    <form name="art_preferred_info_form" id="arts_preferred_info_form" ng-validate="arts_preferred_info_validate">
    					<div class="dtl-dis">
    						<div class="form-group">
    							<label>Preferred Category</label>
    							<span class="span-select">
    								<select name="pref_cate[]" id="pref_cate" tabindex="1" autofocus multiple>
                                        <?php foreach($art_category as $_art_category){  ?>
                                        <option onchange="return other_change_pref_cate(<?php echo $_art_category['category_id']; ?>);" value="<?php echo $_art_category['category_id']; ?>"><?php echo ucwords(ucfirst($_art_category['art_category'])); ?></option>
                                        <?php } ?>
                                    </select>
    							</span>
    						</div>
                            <div id="other_pref_cate_div" class="form-group" style="display: none;">
                                <label>Other Category</label>
                                <input type="text" placeholder="Other Category" id="art_other_pref_cate" name="art_other_pref_cate" maxlength="255">
                            </div>
    						<div class="form-group">
    							<label>Skills</label>
    							<tags-input id="preferred_skill_txt" ng-model="preferred_skill_txt" display-property="pref_skill" placeholder="Enter Skills" replace-spaces-with-dashes="false" template="title-template" ng-keyup="preferred_skill_fnc()"></tags-input>
    						</div>
    						<div class="row">
    							<div class="col-md-12 fw">
    								<label>Preferred Location</label>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
    								<div class="form-group">
    									<span class="span-select">
    										<select id="art_preffered_country" name="art_preffered_country" ng-model="art_preffered_country" ng-change="art_preffered_country_change()">
                                                <option value="">Country</option>         
                                                <option data-ng-repeat='country_item in exp_country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                            </select>
    									</span>
    								</div>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
    								<div class="form-group">
    									<span class="span-select">
    										<select id="art_preffered_state" name="art_preffered_state" ng-model="art_preffered_state" ng-change="art_preffered_state_change()" disabled = "disabled">
                                                <option value="">State</option>
                                                <option data-ng-repeat='state_item in art_preffered_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                            </select>
                                            <img id="art_preffered_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
    									</span>
    								</div>
    							</div>
    							<div class="col-md-4 col-sm-4 col-xs-4 fw-479">
    								<div class="form-group">
    									<span class="span-select">
    										<select id="art_preffered_city" name="art_preffered_city" ng-model="art_preffered_city" disabled = "disabled">
                                                <option value="">City</option>
                                                <option data-ng-repeat='city_item in art_preffered_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                            </select>
                                            <img id="art_preffered_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
    									</span>
    								</div>
    							</div>
    						</div>
    						<div class="form-group">
    							<label>Availability</label>
    							<span class="span-select">
    								<select id="preffered_availability" name="preffered_availability">
                                        <option value="">Select Availability</option>
    									<option value="1">Full time</option>
    									<option value="2">Part time</option>
    									<option value="3">Contract</option>
    									<option value="4">Freelance</option>
    								</select>
    							</span>
    						</div>						
    					</div>
    					<div class="dtl-btn">
    						<a id="art_preferred_info_save" href="javascript:void(0);" ng-click="art_preferred_info_save()" class="save">
                                <span>Save</span>
                            </a>
                            <div id="art_preferred_info_save_loader"  class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                            </div>
    					</div>
                    </form>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Educational Info  -->
	<div style="display:none;" class="modal fade dtl-modal" id="educational-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
                    <div class="dtl-title">
                        <span>Educational Info</span>
                    </div>
                    <form name="edu_form" id="edu_form" ng-validate="edu_validate">
                        <div class="dtl-dis">
                            <div class="form-group">
                                <label>School / College Name</label>
                                <input type="text" placeholder="Enter School / College Name" id="edu_school_college" name="edu_school_college" minlength="3" maxlength="200">
                            </div>
                            <div class="form-group">
                                <label>Board / University</label>
                                <span class="span-select">
                                    <select id="edu_university" name="edu_university" ng-model="edu_university" ng-change="edu_university_change();">
                                        <option value="">Select Board / University</option>    
                                        <option data-ng-repeat='university_item in university_data' value='{{university_item.university_id}}'>{{university_item.university_name}}</option>
                                        <option value="0">Other</option>    
                                    </select>
                                </span>
                            </div>
                            <div id="other_university" class="form-group" style="display: none;">
                                <input type="text" placeholder="Other Board / University" id="edu_other_university" name="edu_other_university" maxlength="200" minlength="3">
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Degree / Qualification </label>
                                        <!-- <input type="text" placeholder="Degree / Qualification "> -->
                                        <span class="span-select">
                                        <select id="edu_degree" name="edu_degree" ng-model="edu_degree" ng-change="edu_degree_change();">
                                            <option value="">Select Degree / Qualification</option>    
                                            <option data-ng-repeat='degree_item in degree_data' value='{{degree_item.degree_id}}'>{{degree_item.degree_name}}</option>
                                            <option value="0">Other</option>    
                                        </select>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Course / Field of Study / Stream </label>
                                        <!-- <input type="text" placeholder="Course / Field of Study / Stream"> -->
                                        <span class="span-select">
                                        <select id="edu_stream" name="edu_stream" ng-model="edu_stream" ng-change="edu_stream_change()" disabled = "disabled">
                                            <option value="">Select Course / Field of Study / Stream</option>
                                            <option data-ng-repeat='stream_item in stream_data' value='{{stream_item.stream_id}}'>{{stream_item.stream_name}}</option>
                                        </select>
                                        </span>
                                        <img id="edu_stream_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 33px;right: 33px;display: none;">
                                    </div>
                                    </div>
                                </div>

                                <div id="other_edu" class="row" style="display: none;">
                                    <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Other Degree / Qualification </label>
                                        <input type="text" placeholder="Degree / Qualification" id="edu_other_degree" name="edu_other_degree">
                                    </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Other Course / Field of Study / Stream </label>
                                        <input type="text" placeholder="Course / Field of Study / Stream" id="edu_other_stream" name="edu_other_stream">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <label>Start Date</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select id="edu_s_year" name="edu_s_year"  ng-model="edu_s_year" ng-change="edu_start_year();">
                                                        <option value="">Year</option>
                                                        <?php
                                                        $year = date("Y",NOW());
                                                        for ($ey=$year; $ey >= 1950; $ey--) { ?>
                                                            <option value="<?=$ey?>"><?=$ey?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </span>
                                            </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select id="edu_s_month" name="edu_s_month">
                                                        <option value="">Month</option>
                                                    </select>
                                                </span>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6" ng-show='!edu_nograduate'>
                                        <label>End Date</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select id="edu_e_year" name="edu_e_year" ng-model="edu_e_year">
                                                    </select>
                                                </span>
                                            </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select id="edu_e_month" name="edu_e_month">
                                                        <option value="">Month</option> 
                                                    </select>
                                                </span>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <span id="edudateerror" class="error" style="display: none;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control control--checkbox">
                                    <input type="checkbox" ng-model="edu_nograduate" id="edu_nograduate" name="edu_nograduate">If You are not graduate click here.
                                    <div class="control__indicator"></div>
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="upload-file">
                                    <label>Upload File (Educational Certificate)</label>
                                    <input type="file" id="edu_file" name="edu_file">
                                    <span id="edu_file_error" class="error" style="display: none;"></span>
                                </div>
                            </div>                    
                        </div>
                        <div class="dtl-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="edu_save" href="#" ng-click="save_user_education()" class="save"><span>Save</span></a>
                            <div id="edu_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade message-box biderror" id="delete-edu-model" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                <div class="modal-body">
                    <span class="mes">
                        <div class='pop_content'>
                            <span>Are you sure you want to delete educational information ?</span>
                            <p class='poppup-btns pt20'>
                                <span id="edu-delete-btn">
                                    <a id="delete_user_edu" href="#" ng-click="delete_user_edu()" class="btn1">
                                        <span>Delete</span>
                                    </a> 
                                    <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                </span>
                                <img id="user_edu_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                            </p>
                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>
	
	<!---  model Experience  -->
	<div style="display:none;" class="modal fade dtl-modal" id="experience" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" ng-click="reset_exp_form()" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
                    <div class="dtl-title">
                        <span>Experience</span>
                    </div>
                    <form name="experience_form" id="experience_form" ng-validate="experience_validate">
                        <!-- <input type="hidden" name="edit_exp" id="edit_exp" ng-model="edit_exp" ng-value="0"> -->
                        <div class="dtl-dis">                            
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
	                                        <label>Company Name</label>
	                                        <input type="text" placeholder="Enter Company Name" id="exp_company_name" name="exp_company_name" ng-model="exp_company_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
	                                    <div class="form-group">
	                                        <label>Designation / Role</label>
	                                        <!-- <input type="text" placeholder="Enter Designation"> -->
	                                        <input type="text" placeholder="Enter Designation" id="exp_designation" name="exp_designation" ng-model="exp_designation" ng-keyup="exp_job_title_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off">
	                                    </div>
                                    </div>
                                    
                                </div>
                           
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Website <span class="link-must">(Must be http:// or https://)</span></label>
                                        <input type="text" placeholder="Enter Company Website" id="exp_company_website" name="exp_company_website" ng-model="exp_company_website">
                                        
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Field </label>
                                        <span class="span-select">
                                            <?php $getFieldList = $this->data_model->getNewFieldList();?>
                                            <select name="exp_field" id="exp_field" ng-model="exp_field" ng-change="other_field_fnc()">
                                                <option value="">Select Field</option>
                                                <?php foreach($art_category as $_art_category){  ?>
                                                <option value="<?php echo $_art_category['category_id']; ?>"><?php echo ucwords(ucfirst($_art_category['art_category'])); ?></option>
                                                <?php } ?>
                                        </select>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div id="exp_other_field_div" class="row" style="display: none;">
                                    <div class="col-md-6 col-sm-6"></div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Other Field</label>
                                        <input type="text" placeholder="Enter Other Field" id="exp_other_field" name="exp_other_field" ng-model="exp_other_field">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <label>Company Location</label>
                                <!-- <input type="text" placeholder="Enter Company Location"> -->
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                        <div class="form-group">
                                        <span class="span-select">
                                            <select id="exp_country" name="exp_country" ng-model="exp_country" ng-change="exp_country_change()">
                                                <option value="">Country</option>         
                                                <option data-ng-repeat='country_item in exp_country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                            </select>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                        <div class="form-group">
                                        <span class="span-select">
                                            <select id="exp_state" name="exp_state" ng-model="exp_state" ng-change="exp_state_change()" disabled = "disabled">
                                                <option value="">State</option>
                                                <option data-ng-repeat='state_item in exp_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                            </select>
                                            <img id="exp_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                        <div class="form-group">
                                        <span class="span-select">
                                            <select id="exp_city" name="exp_city" ng-model="exp_city" disabled = "disabled">
                                                <option value="">City</option>
                                                <option data-ng-repeat='city_item in exp_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                            </select>
                                            <img id="exp_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <label>Start Date</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                <span class="span-select">
                                                    <select id="exp_s_year" name="exp_s_year" ng-model="exp_s_year" ng-change="exp_start_year();">
                                                        <option value="">Year</option>
                                                        <?php
                                                        $year = date("Y",NOW());
                                                        for ($i=$year; $i >= 1950; $i--) { ?>
                                                            <option value="<?=$i?>"><?=$i?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                <span class="span-select">
                                                    <select id="exp_s_month" name="exp_s_month" ng-model="exp_s_month">
                                                        <option value="">Month</option>
                                                    </select>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="exp_end_date" class="col-md-6 col-sm-6" ng-show='!exp_isworking'>
                                        <label>End Date</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                <span class="span-select">
                                                    <select id="exp_e_year" name="exp_e_year" ng-model="exp_e_year">
                                                    </select>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                <span class="span-select">
                                                    <select id="exp_e_month" name="exp_e_month" ng-model="exp_e_month">
                                                        <option value="">Month</option> 
                                                    </select>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <span id="expdateerror" class="error" style="display: none;"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control control--checkbox">
                                        <input type="checkbox" ng-model="exp_isworking" id="exp_isworking" class="exp_isworking">I currently work here.
                                        <div class="control__indicator">
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea row="4" type="text" placeholder="Enter Roles and Responsibility" id="exp_desc" name="exp_desc" ng-model="exp_desc"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="upload-file">
                                    <label>Upload File (work experience certificate)</label>
                                    <input type="file" id="exp_file" name="exp_file">
                                    <span id="exp_file_error" class="error" style="display: none;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="dtl-btn">
                            <a id="save_user_exp" href="#" ng-click="save_user_exp()" class="save"><span>Save</span></a>
                            <div id="user_exp_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade message-box biderror" id="delete-exp-model" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                <div class="modal-body">
                    <span class="mes">
                        <div class='pop_content'>
                            <span>Are you sure you want to delete work experience ?</span>
                            <p class='poppup-btns pt20'>
                                <span id="exp-delete-btn">
                                    <a id="delete_user_exp" href="#" ng-click="delete_user_exp()" class="btn1">
                                        <span>Delete</span>
                                    </a> 
                                    <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                </span>
                                <img id="user_exp_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                            </p>
                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>
	
	<!---  model Social Profile  -->
	<div style="display:none;" class="modal fade dtl-modal" id="social-link" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <button type="button" class="modal-close" data-dismiss="modal">×</button>
	            <div class="modal-body-cus"> 
	                <div class="dtl-title">
	                    <span>Social Profile</span>
	                </div>
	                <div class="dtl-dis">
	                    <div class="fw pb20">
	                        
	                        <div class="row">
	                            <div class="">
	                                <div class="" data-ng-repeat="field in social_linksset.social_links track by $index">
	                                <div class="col-md-3 col-sm-3 col-xs-4 mob-pr0">
	                                    <div class="form-group">
	                                        <label>Website</label>
	                                        <span class="span-select">
	                                            <select id="link_type{{$index}}" name="link_type" class="link_type">
	                                                <option value="Facebook" ng-selected="field.user_links_type == 'Facebook'">Facebook</option>
	                                                <option value="Google" ng-selected="field.user_links_type == 'Google'">Google</option>
	                                                <option value="Instagram" ng-selected="field.user_links_type == 'Instagram'">Instagram</option>
	                                                <option value="LinkedIn" ng-selected="field.user_links_type == 'LinkedIn'">LinkedIn</option>
	                                                <option value="Pinterest" ng-selected="field.user_links_type == 'Pinterest'">Pinterest</option>
	                                                <option value="GitHub" ng-selected="field.user_links_type == 'GitHub'">GitHub</option>
	                                                <option value="Twitter" ng-selected="field.user_links_type == 'Twitter'">Twitter</option>
	                                            </select>
	                                        </span>
	                                    </div>
	                                </div>
	                                <div class="col-md-8 col-sm-8 col-xs-7">
	                                    <div class="form-group">
	                                        <label>URL <span class="personal-link-info">(must start with http:// or https://)</span></label>
	                                        <input type="text" placeholder="Enter URL" id="link_url{{$index}}" class="link_url" name="link_url" ng-keyup="check_socialurl($index)" ng-value="field.user_links_txt">
	                                    </div>
	                                </div>
	                                
	                                <div class="col-md-1 col-sm-1 col-xs-1 pl0">
	                                    
	                                    <a href="#" class="pull-right" ng-click="removeSocialLinks($index)"><img class="dlt-img" src="<?php echo base_url(); ?>assets/n-images/detail/dtl-delet.png"></a>
	                                </div>
	                                </div>
	                                <div class="fw dtl-more-add" id="add-new-link">
	                                    <a href="#" ng-click="addNewSocialLinks()"><span class="pr10">Add Social Links</span><img src="<?php echo base_url(); ?>assets/n-images/detail/inr-add.png"></a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div data-ng-repeat="field in personal_linksset.personal_links track by $index">
	                            <div class="form-group">
	                                <div class="col-md-11 col-sm-11 col-xs-11">
	                                    <label>Add Personal Website</label>
	                                    <input type="text" placeholder="Enter Website Link" id="personal_link_url{{$index}}" class="personal_link_url" name="personal_link_url" ng-keyup="check_personalurl($index)" ng-value="field.user_links_txt">
	                                    <span class="personal-link-info">URL must start with http:// or https://</span>
	                                </div>
	                                <div class="col-md-1 col-sm-1 col-xs-1 pl0">
	                                    
	                                    <a href="#" class="pull-right" ng-click="removePersonalLinks($index)"><img class="dlt-img" src="<?php echo base_url(); ?>assets/n-images/detail/dtl-delet.png"></a>
	                                </div>
	                            </div>
	                        </div>
	                        <div id="add-personla-link" class="fw dtl-more-add pt15">
	                            <a href="#" ng-click="addNewPersonalLinks()"><span class="pr10">Add Personal Website Links </span>
	                                <img src="<?php echo base_url(); ?>assets/n-images/detail/inr-add.png">
	                            </a>
	                        </div>
	                    </div>
	                </div>
	                <div class="dtl-btn">
	                        <!-- <a href="#" class="save"><span>Save</span></a> -->
	                        <a id="user_links_save" href="#" ng-click="save_user_links()" class="save"><span>Save</span></a>
							<div id="user_links_loader" class="dtl-popup-loader" style="display: none;">
	                        <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
							</div>
	                    </div>
	            </div>  


	        </div>
	    </div>
	</div>
	
	<!---  model specialities  -->
	<div style="display:none;" class="modal fade dtl-modal" id="specialities" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Specialities</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Tags</label>
							<tags-input id="speciality_txt" ng-model="speciality_txt" display-property="speciality" placeholder="Enter Tags" replace-spaces-with-dashes="false" template="title-template"></tags-input>
						</div>
						<div class="form-group big-textarea">
							<label>Description</label>
							<textarea type="text" placeholder="Description" id="speciality_desc" name="speciality_desc" ng-model="speciality_desc"></textarea>
							<span class="pull-right">{{700 - speciality_desc.length}}</span>
						</div>
					</div>
					<div class="dtl-btn">
						<a id="save_user_speciality" href="#" ng-click="save_user_speciality()" class="save"><span>Save</span></a>
                        <div id="user_speciality_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                        </div>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Software / Instrument/ Skills  -->
	<div style="display:none;" class="modal fade dtl-modal" id="art-sof" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Software / Instrument/ Skills</span>
					</div>
					<div class="dtl-dis">
						<div class="form-group">
							<label>Tags</label>
							<tags-input id="soft_inst_skill_txt" ng-model="soft_inst_skill_txt" display-property="sis" placeholder="Enter Tags" replace-spaces-with-dashes="false" template="title-template"></tags-input>
						</div>
						
					</div>
					<div class="dtl-btn">
						<a id="save_user_soft_inst_skill" href="#" ng-click="save_user_soft_inst_skill()" class="save"><span>Save</span></a>
                        <div id="user_soft_inst_skill_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                        </div>
					</div>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Achievements & Awards  -->
	<div style="display:none;" class="modal fade dtl-modal" id="Achiv-awards" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
                    <div class="dtl-title">
                        <span>Achievements & Awards</span>
                    </div>
                    <form name="award_form" id="award_form" ng-validate="award_validate">
                    <div class="dtl-dis">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" placeholder="Enter Title" id="award_title" name="award_title">
                        </div>
                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" placeholder="Enter Organization" id="award_org" name="award_org">
                        </div>
                        <div class="">
                            <label>Date</label>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                <div class="form-group">
                                    <span class="span-select">
                                        <select id="award_month" name="award_month" ng-model="award_month" ng-change="award_date_fnc('','','')">
                                            <option value="">Month</option>
                                            <option value="01">Jan</option>
                                            <option value="02">Feb</option>
                                            <option value="03">Mar</option>
                                            <option value="04">Apr</option>
                                            <option value="05">May</option>
                                            <option value="06">Jun</option>
                                            <option value="07">Jul</option>
                                            <option value="08">Aug</option>
                                            <option value="09">Sep</option>
                                            <option value="10">Oct</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dec</option>
                                        </select>
                                    </span>
                                </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                <div class="form-group">
                                    <span class="span-select">
                                        <select id="award_day" name="award_day" ng-model="award_day" ng-click="award_error()">
                                            <option value="">Select Day</option>
                                        </select>
                                    </span>
                                </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                <div class="form-group">
                                    <span class="span-select">
                                        <select id="award_year" name="award_year" ng-model="award_year" ng-change="award_date_fnc('','','')" ng-click="award_error()">
                                            <option value="">Select Year</option>
                                        </select>
                                    </span>
                                </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <span id="awarddateerror" class="error" style="display: none;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" placeholder="Enter Description" id="award_desc" name="award_desc"></textarea>
                        </div>                    
                        <div class="form-group">
                            <div class="upload-file">
                                <label>Upload File (Achievements & Awards Certificate)</label>
                                <input type="file" id="award_file" name="award_file">
                                <span id="award_file_error" class="error" style="display: none;"></span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="dtl-btn">
                        <!-- <a href="#" class="save"><span>Save</span></a> -->
                        <a id="user_award_save" href="#" ng-click="save_user_award()" class="save"><span>Save</span></a>
                        <div id="user_award_loader"  class="dtl-popup-loader" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade message-box biderror" id="delete-award-model" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                <div class="modal-body">
                    <span class="mes">
                        <div class='pop_content'>
                            <span>Are you sure you want to delete achievement & award ?</span>
                            <p class='poppup-btns pt20'>
                                <span id="award-delete-btn">
                                    <a id="delete_user_award" href="#" ng-click="delete_user_award()" class="btn1">
                                        <span>Delete</span>
                                    </a> 
                                    <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                </span>
                                <img id="user_award_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                            </p>
                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>
	
	<!---  model Additional Course  -->
	<div style="display:none;" class="modal fade dtl-modal" id="additional-course" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
                    <div class="dtl-title">
                        <span>Additional Course</span>
                    </div>
                    <form name="addicourse_form" id="addicourse_form" ng-validate="addicourse_validate">
                        <div class="dtl-dis">
                            <div class="form-group">
                                <label>Course Name</label>
                                <input type="text" placeholder="Enter Course Name" id="addicourse_name" name="addicourse_name">
                            </div>
                            <div class="form-group">
                                <label>Organization</label>
                                <input type="text" placeholder="Enter Organization" id="addicourse_org" name="addicourse_org">
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        
                                        <label>Start Date</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                <span class="span-select">
                                                    <select id="addicourse_s_year" name="addicourse_s_year" ng-model="addicourse_s_year" ng-change="addicourse_start_year();">
                                                        <option value="">Year</option>
                                                        <?php
                                                        $year = date("Y",NOW());
                                                        for ($i=$year; $i >= 1950; $i--) { ?>
                                                            <option value="<?=$i?>"><?=$i?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                <span class="span-select">
                                                    <select id="addicourse_s_month" name="addicourse_s_month">
                                                        <option value="">Month</option> 
                                                    </select>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <label>End Date</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select id="addicourse_e_year" name="addicourse_e_year">
                                                    </select>
                                                </span>
                                            </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <span class="span-select">
                                                    <select id="addicourse_e_month" name="addicourse_e_month">
                                                        <option value="">Month</option>
                                                    </select>
                                                </span>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <span id="addicoursedateerror" class="error" style="display: none;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>URL <span class="link-must">(Must be http:// or https://)</span></label>
                                <input type="text" placeholder="Enter URL" id="addicourse_url" name="addicourse_url">
                                
                            </div>
                            
                            <div class="form-group">
                                <div class="upload-file">
                                    <label>Upload File (Additional Course Certificate)</label>
                                    <input type="file" id="addicourse_file" name="addicourse_file">
                                    <span id="addicourse_file_error" class="error" style="display: none;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="dtl-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="user_addicourse_save" href="#" ng-click="save_user_addicourse()" class="save"><span>Save</span></a>
                            <div id="user_addicourse_loader" class="dtl-popup-loader" style="display: none;">
                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                            </div>
                        </div>
                    </form>
                </div>  


            </div>
        </div>
    </div>
    <div class="modal fade message-box biderror" id="delete-addicourse-model" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                <div class="modal-body">
                    <span class="mes">
                        <div class='pop_content'>
                            <span>Are you sure you want to delete additional course ?</span>
                            <p class='poppup-btns pt20'>
                                <span id="addicourse-delete-btn">
                                    <a id="delete_user_addicourse" href="#" ng-click="delete_user_addicourse()" class="btn1">
                                        <span>Delete</span>
                                    </a> 
                                    <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
                                </span>
                                <img id="user_addicourse_del_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                            </p>
                        </div>
                    </span>
                </div>
            </div>
        </div>
    </div>
		
	<!---  model language  -->
	<div style="display:none;" class="modal fade dtl-modal" id="language" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
                    <div class="dtl-title">
                        <span>Language</span>
                    </div>
                    <div class="dtl-dis">
                        <div class="fw pb20">                                
                            <div class="row">
                                <div class="">
                                    <div class="width-45">
                                        <div class="form-group">
                                            <label>Language</label>
                                            <input type="text" name="language[]" ng-model="language[100].lngtxt" ng-keyup="get_languages(100)" class="form-control language" placeholder="Enter Language"  id="language" typeahead="item as item.language_name for item in lang_search_result | filter:$viewValue"  autocomplete="off" ng-value="primari_lang.language_name" value="{{primari_lang.language_name}}">
                                        </div>
                                    </div>
                                    <div class="width-45">
                                        <div class="form-group">
                                            <label>Proficiency</label>
                                            <span class="span-select">
                                                <select class="proficiency" name="proficiency">
                                                    <option value="" disabled>Select Proficiency</option>
                                                    <option value="Basic" ng-selected="primari_lang.proficiency == 'Basic'">Basic</option>
                                                    <option value="Intermediate" ng-selected="primari_lang.proficiency == 'Intermediate'">Intermediate</option>
                                                    <option value="Expert" ng-selected="primari_lang.proficiency == 'Expert'">Expert</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- <div class="width-10">
                                        <label></label>
                                        <a href="#" class="pull-right"><img class="dlt-img" src="<?php //echo base_url('assets/n-images/detail/dtl-delet.png?ver=' . time()) ?>"></a>
                                    </div> -->
                                    <div class="" data-ng-repeat="field in languageSet.language track by $index">                                        
                                        <div class="width-45">
                                            <div class="form-group">
                                                <label>Language</label>
                                                <!-- <input type="text" placeholder="Language" class="language" name="language"> -->
                                                <input type="text" name="language[]" ng-model="language[$index].lngtxt" ng-keyup="get_languages($index)" class="form-control language" placeholder="Enter Language"  id="language" typeahead="item as item.language_name for item in lang_search_result | filter:$viewValue" autocomplete="off" ng-value="field.language_name" value="{{field.language_name}}">
                                            </div>
                                        </div>
                                        <div class="width-45">
                                            <div class="form-group">
                                                <label>Proficiency</label>
                                                <span class="span-select">
                                                    <select class="proficiency" name="proficiency[]">
                                                        <option value="" disabled>Select Proficiency</option>
                                                        <option value="Basic" ng-selected="field.proficiency == 'Basic'">Basic</option>
                                                        <option value="Intermediate" ng-selected="field.proficiency == 'Intermediate'">Intermediate</option>
                                                        <option value="Expert" ng-selected="field.proficiency == 'Expert'">Expert</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="width-10">
                                            <a href="#" class="pull-right" ng-click="removeLanguage($index)"><img class="dlt-img" src="<?php echo base_url(); ?>assets/n-images/detail/dtl-delet.png"></a>
                                        </div>
                                    </div>
                                    <div class="fw dtl-more-add">
                                        <a href="#" ng-click="addNewLanguage()"><span class="pr10">Add More languages </span><img src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="dtl-btn">
                        <!-- <a href="#" class="save"><span>Save</span></a> -->
                        <a id="save_user_language" href="#" ng-click="save_user_language()" class="save"><span>Save</span></a>
                        <div id="user_language_loader" class="dtl-popup-loader" style="display: none;">
                        <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                        </div>
                    </div>
                </div>  


            </div>
        </div>
    </div>
    <!---  model End  --> 
    <?php endif; ?>
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
	<!-- Bid-modal-2  -->
	<div class="modal fade message-box" id="bidmodal-2" role="dialog">
		<div class="modal-dialog modal-lm">
			<div class="modal-content">
				<button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
				<div class="modal-body">
					<span class="mes">
						<div id="popup-form">
							<form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
								<div class=" ">

									<div class="fw" id="loaderfollow" style="text-align:center; display: none;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo "loader.gif"; ?>"/></div>

									<input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one">
								</div>
								<div class="col-md-7 text-center">
									<div id="upload-demo-one" style="width:350px; display: none"></div>
								</div>
								<input type="submit"  class="upload-result-one" name="profilepicsubmit" id="profilepicsubmit" value="Save">
							</form>
						</div>
					</span>
				</div>
			</div>
		</div>
	</div>
	<!-- Model Popup Close -->

	<?php echo $login_footer ?>
	<?php echo $footer; ?>

	<!-- script for skill textbox automatic start (option 2)-->
	<script  src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
	<script  src="<?php echo base_url('assets/js/bootstrap.min.js?ver='.time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.multi-select.js?ver=' . time()); ?>"></script>
	<script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/masonry/3.2.2/masonry.pkgd.min.js'></script>
	<script src="<?php echo base_url('assets/js/star-rating.js?ver=' . time()); ?>"></script>
	<script src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
    <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
	<script>
		$('#main_loader').hide();
		$('#main_page_load').show();
		$('body').removeClass("body-loader");

		var base_url = '<?php echo base_url(); ?>';   
		var data= <?php echo json_encode($demo); ?>;
		var data1 = <?php echo json_encode($de); ?>;
		var data= <?php echo json_encode($demo); ?>;
		var data1 = <?php echo json_encode($city_data); ?>;
		var slug = '<?php echo $artid; ?>';
		var user_slug = '<?php echo $get_url; ?>';

		var from_user_id = '<?php echo $login_art_data[0]['user_id']; ?>';
		var to_user_id = '<?php echo $artisticdata[0]['user_id']; ?>';

		var art_user_portfolio_upload_url = '<?php echo ART_USER_PORTFOLIO_UPLOAD_URL; ?>';
		var art_user_award_upload_url = '<?php echo ART_USER_AWARD_UPLOAD_URL; ?>';
		var art_user_addicourse_upload_url = '<?php echo ART_USER_ADDICOURSE_UPLOAD_URL; ?>';
		var art_user_experience_upload_url = '<?php echo ART_USER_EXPERIENCE_UPLOAD_URL; ?>';
    	var art_user_education_upload_url = '<?php echo ART_USER_EDUCATION_UPLOAD_URL; ?>';

		var header_all_profile = '<?php echo $header_all_profile; ?>';

		var app = angular.module("artistProfileApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
	</script>
	<script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/details_new.js?ver='.time()); ?>"></script>
    <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
    <script  type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/details.js?ver='.time()); ?>"></script>
	<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/masonry/3.2.2/masonry.pkgd.min.js'></script>
	<script>
		$(document).ready(function () {
			$('html,body').animate({scrollTop: 300}, 500);
		});
		$(document).ready(function () {
			if (screen.width > 768) {
				var masonryLayout = function masonryLayout(containerElem, itemsElems, columns) {
					containerElem.classList.add('masonry-layout', 'columns-' + columns);
					var columnsElements = [];

					for (var i = 1; i <= columns; i++) {
						var column = document.createElement('div');
						column.classList.add('masonry-column', 'column-' + i);
						containerElem.appendChild(column);
						columnsElements.push(column);
					}

					for (var m = 0; m < Math.ceil(itemsElems.length / columns); m++) {
						for (var n = 0; n < columns; n++) {
							var item = itemsElems[m * columns + n];
							columnsElements[n].appendChild(item);
							item.classList.add('masonry-item');
						}
					}
				};
				masonryLayout(document.getElementById('gallery'),
				document.querySelectorAll('.gallery-item'), 2);
			}
		});		
        $(function() {
          // Set
          var main = $('div.mm-dropdown .textfirst')
          var li = $('div.mm-dropdown > ul > li.input-option')
          var inputoption = $("div.mm-dropdown .option")
          var default_text = 'Select Status';

          // Animation
          main.click(function() {
            main.html(default_text);
            li.toggle();
          });

          // Insert Data
          li.click(function() {
            // hide
            li.toggle();
            var livalue = $(this).data('value');
            var lihtml = $(this).html();
            main.html(lihtml);
            inputoption.val(livalue);
          });
        });
        $(document).ready(function () {
        	if (screen.width <= 1199) {
        		$("#edit-profile-move").appendTo($(".edit-profile-move"));
	            $("#social-link-move").appendTo($(".social-link-move"));
	            $("#language-move").appendTo($(".language-move"));
	            $("#type-talant-move").appendTo($(".type-talant-move"));
	            $("#abailability-move").appendTo($(".abailability-move"));
	            $(".remove-blank").remove();
	        }
	        if (screen.width < 768) {
	        	$("#edit-custom-move").appendTo($(".edit-custom-move"));
	        }
	    });
	</script>
	<script type="text/ng-template" id="title-template">
        <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dtl-edit-bottom').hover(function () {
                $('.profile-status').addClass('hover-bottom');
            }, function () {
                $('.profile-status').removeClass('hover-bottom');
            });
            
            $('.dtl-edit-top').hover(function () {
                $('.profile-status').addClass('hover-top');
            }, function () {
                $('.profile-status').removeClass('hover-top');
            });

        });
    </script>
	</body>
</html>