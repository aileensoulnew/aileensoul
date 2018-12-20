<!DOCTYPE html>
<html lang="en" ng-app="businessProfileApp" ng-controller="businessProfileController">
    <head>
    	<title><?php echo $title; ?></title>
    	<?php echo $head; ?>
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
    	<link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css?ver=' . time()) ?>">
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/developer.css?ver=' . time()); ?>" />
        <!-- <script src="<?php //echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php //echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script> -->
        <?php $this->load->view('adsense'); ?>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push botton_footer body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
        <?php
	        echo $header; 
	        echo $business_header2;
	        $from_user_id = $login_bussiness_data->user_id;
	        $to_user_id = $business_data['user_id'];

	        $time_array = array("1:00","1:30","2:00","2:30","3:00","3:30","4:00","4:30","5:00","5:30","6:00","6:30","7:00","7:30","8:00","8:30","9:00","9:30","10:00","10:30","11:00","11:30","12:00","12:30");
	    ?>
        <section>
           <?php echo $business_common; ?>
            <div class="user-midd-section">
                <div class="container tab-plr0 pt20">
                    <div class="all-detail-custom">
                        <div class="custom-user-list">
							<div class="edit-custom-move">
								
							</div>
					<div class="gallery" id="gallery">
						<!-- 01 Basic information  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/about.png?ver=' . time()) ?>">
									<span>Basic Information</span>
									<a href="#" ng-if="from_user_id == to_user_id" ng-click="edit_business();" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div id="business-loader" class="dtl-dis">
		                            <div class="text-center">
		                                <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
		                            </div>
		                        </div>
		                        <div id="business-body" style="display: none;">
									<div id="business-detail" class="dtl-dis">
										<ul class="dis-list list-ul-cus">
											<li ng-if="business_info_data.business_type">
												<span>Business Type </span>
												<label ng-if="business_info_data.business_type > '0'">{{business_info_data.business_type_txt}}</label>
												<label ng-if="business_info_data.business_type == '0'">{{business_info_data.other_business_type}}</label>
											</li>
											<li ng-if="business_info_data.details != ''">
												<span>Business Description</span>
												<label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{business_info_data.details}}" dd-text-collapse-cond="true">{{business_info_data.details}}</label>
											</li>
											<li ng-if="business_info_data.business_tot_emp">
												<span>Total Employees</span>
												<label ng-if="business_info_data.business_tot_emp == '1'">1 to 10</label>
												<label ng-if="business_info_data.business_tot_emp == '2'">10 to 30</label>
												<label ng-if="business_info_data.business_tot_emp == '3'">30 to 50</label>
												<label ng-if="business_info_data.business_tot_emp == '4'">More than 50</label>
											</li>
											<li ng-if="business_info_data.business_year_found">
												<span>Year Founded / Established</span>
												{{business_info_data.business_year_found}}
											</li>
											<li class="fw" ng-if="business_info_data.business_ext_benifit">
												<span>Specialties / Extra Benefits / Ambience / Facilities Tags</span>
												<ul class="skill-list">
													<li ng-repeat="benefits in business_info_data.business_ext_benifit.split(',')">{{benefits}}</li>
												</ul>
											</li>
											<li ng-if="business_info_data.business_pay_mode">
												<span>Payment Mode Accepted</span>
												<label ng-if="business_info_data.business_pay_mode == '1'">Cash</label>
												<label ng-if="business_info_data.business_pay_mode == '2'">Online</label>
												<label ng-if="business_info_data.business_pay_mode == '3'">Card</label>
												<label ng-if="business_info_data.business_pay_mode == '4'">Wallate</label>
											</li>
											<li class="fw" ng-if="business_info_data.business_keyword">
												<span>Business Keywords</span>
												<ul class="skill-list">
													<li ng-repeat="keywords in business_info_data.business_keyword.split(',')">{{keywords}}</li>
												</ul>
											</li>
											<li ng-if="business_info_data.business_mission != ''">
												<span>Mission</span>
												<label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{business_info_data.business_mission}}" dd-text-collapse-cond="true">{{business_info_data.business_mission}}</label>
											</li>
											<li ng-if="business_info_data.business_legal_name != ''">
												<span>Legal Name</span>
												{{business_info_data.business_legal_name}}
											</li>
											<li class="fw" ng-if="business_info_data.business_ser_pro">
												<span>Services / Products you offer (Tags)</span>
												<ul class="skill-list">
													<li ng-repeat="ser_pro in business_info_data.business_ser_pro.split(',')">{{ser_pro}}</li>
												</ul>
											</li>
											<li ng-if="business_info_data.business_serve_area_txt">
												<span>Area Served</span>
												<label>{{business_info_data.business_serve_area_txt}}</label>
											</li>
											<li ng-if="business_info_data.business_tagline != ''">
												<span>Tagline</span>
												{{business_info_data.business_tagline}}
											</li>
											<li ng-if="business_info_data.business_formly_known != ''">
												<span>Formerly Knowns as</span>
												{{business_info_data.business_formly_known}}
											</li>
										</ul>
									</div>
								</div>
								<div id="view-more-business" class="about-more" style="display: none;">
                                    <a href="#" ng-click="view_more_business();">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                </div>
								
							</div>
						</div>
						
						<!-- 02 Edit profile  -->
						<div class="gallery-item edit-profile-move" >
						</div>
						
						<!-- 03 blank div  -->
						<div class="gallery-item" >
						</div>
						
						<!-- 04 Address Information  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/address-info.png"><span>Address Information</span><a href="#" ng-if="from_user_id == to_user_id" ng-click="edit_address_info();" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
								</div>
								<div id="address-loader" class="dtl-dis">
		                            <div class="text-center">
		                                <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
		                            </div>
		                        </div>
		                        <div id="address-body" style="display: none;">
									<div id="address-detail" class="dtl-dis">
										<ul class="dis-list list-ul-cus">
											<li ng-if="address_info_data.address != '' || address_info_data.country_name || address_info_data.state_name || address_info_data.city_name || address_info_data.pincode">
												<span>Location</span>
												<label>
													{{address_info_data.address != '' ? address_info_data.address : ''}},
													<em ng-if="address_info_data.country_name || address_info_data.state_name || address_info_data.city_name">
														{{address_info_data.city_name != '' ? address_info_data.city_name : ''}}
														{{address_info_data.city_name != '' && address_info_data.state_name != '' ? ',' : ''}}
														{{address_info_data.state_name != '' ? address_info_data.state_name : ''}}
														{{address_info_data.state_name != '' && address_info_data.country_name != '' ? ',' : ''}}
														{{address_info_data.country_name != '' ? address_info_data.country_name : ''}}
													</em>												
													<em ng-if="address_info_data.pincode">{{address_info_data.pincode}}.</em>
												</label>
											</li>
											<li ng-if="address_info_data.business_no_location">
												<span>No. of Locations</span>
												<label ng-if="address_info_data.business_no_location == '1'">1 Location</label>
												<label ng-if="address_info_data.business_no_location == '2'">1-5 Locations</label>
												<label ng-if="address_info_data.business_no_location == '3'">5+ Locations</label>
												<label ng-if="address_info_data.business_no_location == '4'">None-online only</label>
												<label ng-if="address_info_data.business_no_location == '5'">None-I travel to my customers</label>
											</li>
											<li ng-if="address_info_data.business_office_location">
												<span>Address Type</span>
												<label ng-if="address_info_data.business_office_location == '1'">Headquaters</label>
												<label ng-if="address_info_data.business_office_location == '2'">Other location</label>
											</li>											
										</ul>
									</div>
								</div>
								<div id="view-more-address" class="about-more" style="display: none;">
                                    <a href="#" ng-click="view_more_address();">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                </div>
								
							</div>
						</div>
						
						<!-- 05 Contact Information  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/contact.png?ver=' . time()) ?>">
									<span>Contact Information</span>
									<a href="javascript:void(0);" ng-if="from_user_id == to_user_id"ng-click="edit_contact_info();" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
								</div>
								<div id="contact-loader" class="dtl-dis">
		                            <div class="text-center">
		                                <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
		                            </div>
		                        </div>
		                        <div id="contact-body" style="display: none;">
		                            <div class="dtl-dis" ng-if="!contact_info_data.contact_person && !contact_info_data.contact_job_title && !contact_info_data.contact_mobile && !contact_info_data.contact_email && !contact_info_data.contact_website && !contact_info_data.contact_fax && !contact_info_data.contact_tollfree">
		                                <div class="no-info">
		                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
		                                    <span>Add contact information so that customer can get in touch.</span>
		                                </div>
		                            </div>		                        
									<div id="about-detail" class="dtl-dis dtl-box-height" ng-if="contact_info_data.contact_person || contact_info_data.contact_job_title || contact_info_data.contact_mobile || contact_info_data.contact_email || contact_info_data.contact_website || contact_info_data.contact_fax || contact_info_data.contact_tollfree">
										<ul class="dis-list list-ul-cus">
											<li ng-if="contact_info_data.contact_person">
												<span>Contact Person Name / Owner Name</span>
												{{contact_info_data.contact_person}}
											</li>
											<li ng-if="contact_info_data.contact_job_title">
												<span>Designation / Role</span>
												{{contact_info_data.contact_job_title_txt}}
											</li>
											<li ng-if="contact_info_data.contact_mobile">
												<span>Contact Number</span>
												{{contact_info_data.contact_mobile}}
											</li>
											<li ng-if="contact_info_data.contact_fax">
												<span>Fax Number</span>
												{{contact_info_data.contact_fax}}
											</li>

											<li ng-if="contact_info_data.contact_website">
												<span>Website</span>
												<a href="{{contact_info_data.contact_website}}" target="_self">{{contact_info_data.contact_website}}</a>
											</li>
											
											<li ng-if="contact_info_data.contact_tollfree">
												<span>Toll Free Number</span>
												{{contact_info_data.contact_tollfree}}
											</li>
											<li ng-if="contact_info_data.contact_email">
												<span>Email Id</span>
												{{contact_info_data.contact_email}}
											</li>
											
										</ul>
									</div>
								</div>
								<div id="view-more-about" class="about-more" style="display: none;">
                                    <a href="#" ng-click="view_more_about();">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                </div>
							</div>
						</div>
						
						<!-- 06 Social Profile  -->
						<div class="gallery-item social-link-move" >
						</div>
						
						<!-- 07 hours of oparation  -->
						<div class="gallery-item hour-move" >
						</div>
						
						<!-- 08 Business Portfolio  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/bus-portfolio.png?ver=' . time()) ?>">
									<span>Business Portfolio</span>
									<a href="javascript:void(0);" ng-if="from_user_id == to_user_id" data-target="#bus-portfolio" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
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
		                                    <span ng-if="from_user_id == to_user_id">Attract more business opportunities by attaching your company portfolio.</span>
		                                    <span ng-if="from_user_id != to_user_id"><?php echo ucwords($business_data['company_name']); ?> hasn't added any portfolio.</span>
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
		                                                        <p class="screen-shot" check-file-ext check-file="{{portfolio.portfolio_file}}" check-file-path="<?php echo "'".addslashes(BUSINESS_USER_PORTFOLIO_UPLOAD_URL)."'"; ?>">
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
						
						
						
						<!-- 09 Key Members Information  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/key-member.png?ver=' . time()) ?>">
									<span>Key Members Information</span>
									<span ng-if="from_user_id == to_user_id" data-target="#member-info" ng-click="reset_member();" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></span>
								</div>
								<div id="key-member-loader" class="dtl-dis">
	                                <div class="text-center">
	                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
	                                </div>
	                            </div>
	                            <div id="key-member-body" style="display: none;">
	                            	<div class="no-info" ng-if="key_member_data.length < '1'">
										<img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
										<span ng-if="from_user_id == to_user_id">Add the key people who are on-board with you.</span>
										<span ng-if="from_user_id != to_user_id"><?php echo ucwords($business_data['company_name']); ?> hasn't added any members yet.</span>
									</div>
									<div class="dtl-dis dis-accor" ng-if="key_member_data.length > '0'">
										<div class="panel-group" id="member-accordion" role="tablist" aria-multiselectable="true">
											<div class="panel panel-default" ng-repeat="member in key_member_data" ng-if="$index <= view_more_km">
												<div class="panel-heading" role="tab" id="expOne">
													<div class="panel-title">
														<div class="dis-left">
															<div class="dis-left-img" ng-class="member.member_img ? 'img-cus' : ''">
																<img ng-if="member.member_img" ng-src="<?php echo BUSINESS_MEMBER_IMG_UPLOAD_URL;?>{{member.member_img}}">
																<span ng-if="!member.member_img">{{member.member_name | limitTo:1 | uppercase}}</span>
															</div>
														</div>
														<div class="dis-middle">
															<h4>{{member.member_name}}</h4>
															<p>Working as {{member.member_job_title_txt}}</p>
															
														</div>
														<div class="dis-right">
															<a href="javascript:void(0);" ng-click="edit_member($index);" class="pr5"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>n-images/detail/detial-edit.png"></a>
															<span role="button" data-toggle="collapse" data-parent="#member-accordion" href="#mem{{$index}}" aria-expanded="false" aria-controls="mem{{$index}}" class="collapsed up-down">
																<img src="<?php echo base_url('assets/n-images/detail/
																down-arrow.png?ver=' . time()) ?>">
															</span>
														</div>	                 
													</div>
												</div>
												<div id="mem{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="expOne" aria-expanded="false" style="height: 0px;">
													<div class="panel-body">
														<ul class="dis-list list-ul-cus">
															<li ng-if="member.member_gender">
																<span>Gender</span>
																<label ng-if="member.member_gender == '1'">Male</label>
																<label ng-if="member.member_gender == '2'">Female</label>
																<label ng-if="member.member_gender == '3'">Other</label>
															</li>
															<li class="fw" ng-if="member.linkedin_url || member.twitter_url">
																<span>Social Links</span>
																<ul class="social-link-list pt5">
																	<li ng-if="member.linkedin_url"><a href="{{member.linkedin_url}}" target="_self"><img src="<?php echo base_url('assets/n-images/detail/in.png?ver=' . time()) ?>"></a></li>
																	<li ng-if="member.twitter_url"><a href="{{member.twitter_url}}" target="_self"><img src="<?php echo base_url('assets/n-images/detail/twt.png?ver=' . time()) ?>"></a></li>
																</ul>					
															</li>
															<li ng-if="member.member_bio">
																<span>Biography</span>
																<label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{member.member_bio}}" dd-text-collapse-cond="true">{{member.member_bio}}</label>
															</li>				
														</ul>
													</div>
												</div>
											</div>
											<div id="view-more-km" class="about-more" ng-if="key_member_data.length > 3">
		                                        <a href="#" ng-click="km_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
		                                    </div>
										</div>
									</div>
								</div>								
							</div>
						</div>
						
						<!-- 10 How Business Name Started?  -->
						<div class="gallery-item bus-name-started">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/bus-start.png?ver=' . time()) ?>">
									<span>How This Business Started?</span>
									<span href="#" ng-if="from_user_id == to_user_id" ng-click="edit_business_story();" class="pull-right" style="cursor: pointer;"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></span>
								</div>
								<div id="story-loader" class="dtl-dis">
	                                <div class="text-center">
	                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
	                                </div>
	                            </div>
	                            <div id="story-body" style="display: none;">
	                            	<div class="no-info" ng-if="!story_data">
										<img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
										<span ng-if="from_user_id == to_user_id">Tell the story of your business name.</span>
										<span ng-if="from_user_id != to_user_id"><?php echo ucwords($business_data['company_name']); ?> hasn't added any story.</span>
									</div>
									<div class="dtl-dis dtl-box-height" ng-if="story_data">
										<div class="bus-story" ng-if="story_data.story_file" ng-click="open_business_story();">
											<img ng-src="<?php echo BUSINESS_USER_STORY_UPLOAD_URL;?>{{story_data.story_file}}">
										</div>
										<div class="bus-story" ng-if="!story_data.story_file" ng-click="open_business_story();">
											<div class="gradient-bg"></div>
										</div>
										<ul class="dis-list list-ul-cus">
											<li>
												<span>Description</span>
												<label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{story_data.story_desc}}" dd-text-collapse-cond="true">{{story_data.story_desc}}</label>
											</li>
										
											<li>
												<span>What differentiate you from your competitiors</span>
												<label class="inner-dis" dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{story_data.story_diff}}" dd-text-collapse-cond="true">{{story_data.story_diff}}</label>
											</li>
									
										</ul>
									</div>
									<div class="about-more" ng-if="story_data">
										<a href="#" ng-click="open_business_story();">View More </a>
									</div>
								</div>
								
							</div>
						</div>
						
						
						<!-- 11 Reviews  -->
						<div class="gallery-item">
							<div class="dtl-box">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/review.png?ver=' . time()) ?>">
									<span>Reviews</span>
									<a ng-if="from_user_id != to_user_id" href="javascript:void(0);" data-target="#reviews" data-toggle="modal" class="pull-right write-review"><img src="<?php echo base_url('assets/n-images/detail/write.png?ver=' . time()) ?>">
										<span>Write a review</span>
									</a>
								</div>
								<div id="review-loader" class="dtl-dis">
		                                <div class="text-center">
		                                    <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
		                                </div>
		                            </div>
		                            <div id="review-body" style="display: none;">
										<div class="dtl-dis">
			                            	<div class="no-info" ng-if="review_data.length < '1'">
												<img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
												<?php if($from_user_id != $to_user_id): ?>
												<span>Be the first to post your review.</span>
												<?php else: ?>
													<span>There are no reviews right now.</span>
												<?php endif; ?>
											</div>
											<div class="total-rev" ng-if="review_data.length > '0' && review_count > '0'">
												<span class="total-rat">{{avarage_review}}</span>
												<span class="rating-star">
													<input id="avarage_review" type="number" value="{{avarage_review}}">
												</span><span class="rev-count">{{review_count}} Review{{review_count > 1 ? 's' : ''}}</span>
											</div>
											<ul class="review-list">
												<li ng-if="review_data.length > '0'" ng-repeat="review_list in review_data">
													<div class="review-left" ng-if="!review_list.user_image">
														<div class="rev-img">
															<div class="post-img-profile">
																{{review_list.company_name | limitTo:1}}
															</div>
														</div>
													</div>
													<div class="review-left" ng-if="review_list.user_image">
														<img ng-src="<?php echo BUS_PROFILE_MAIN_UPLOAD_URL; ?>{{review_list.user_image}}">
													</div>
													<div class="review-right">
														<h4>{{review_list.company_name | wordFirstCase}}</h4>
														<div class="rating-star-cus">
															<span class="rating-star">
															<input id="rating-{{$index}}" value="{{review_list.review_star}}" type="number" class="rating user-rating" class="rating">
																</span>
														</div>
														<div class="review-dis" ng-if="review_list.review_desc">
															{{review_list.review_desc}}
														</div>
													</div>
												</li>
											</ul>
											<div class="form-group"></div>
										</div>
									</div>
							</div>
						</div>
						
						
						<!-- 12 Job Openings  -->
						<div class="gallery-item">
							<div class="dtl-box job-opening">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/job-details.png?ver=' . time()) ?>">
									<span>Job Openings </span>
									<a href="<?php echo base_url('recruiter'); ?>" ng-if="from_user_id == to_user_id && rec_profile == '0'" class="pull-right" target="_self"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
									<a href="<?php echo base_url('post-job'); ?>" ng-if="from_user_id == to_user_id && rec_profile == '1'" class="pull-right" target="_self"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div id="jobs-loader" class="dtl-dis">
		                            <div class="text-center">
		                                <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
		                            </div>
		                        </div>
		                        <div id="jobs-body" style="display: none;">
		                        	<div class="dtl-dis" ng-if="jobs_data.length < '1'">
		                                <div class="no-info" ng-if="from_user_id == to_user_id && rec_profile == '0'">
		                                	<a href="<?php echo base_url('recruiter'); ?>" target="_self"><span>Create Recruiter profile</span></a>
		                                </div>
		                                <div class="no-info" ng-if="from_user_id == to_user_id && rec_profile == '1'">
		                                	<span>Post the career opportunities at your company</span>
		                                	<a href="<?php echo base_url('post-job'); ?>" target="_self"><span>Post Current Opening</span></a>
		                                </div>
		                                <div class="no-info" ng-if="from_user_id != to_user_id">
		                                	<span>There's no job opening right now. Check after some time.</span>
		                                </div>
		                            </div>
									<div class="dtl-dis dis-accor" ng-if="jobs_data.length > '0'">
										<div class="panel-group">
											<div class="panel panel-default" ng-repeat="job in jobs_data"><!-- inner div -->
												<div class="panel-heading">
													<div class="panel-title">
														<a href="<?php echo base_url(); ?>{{job.post_name_txt | slugify}}-job-vacancy-in-{{job.slug_city}}-{{job.user_id}}-{{job.post_id}}" target="_self">
															<div class="dis-left">
																<div class="dis-left-img img-cus">
																	<img ng-if="!job.comp_logo" src="<?php echo base_url('assets/n-images/detail/job-def.png?ver=' . time()) ?>">
																	<img ng-if="job.comp_logo" ng-src="<?php echo REC_PROFILE_MAIN_UPLOAD_URL; ?>{{job.comp_logo}}">
																</div>
															</div>
															<div class="dis-middle">
																<h4>{{job.post_name_txt}}</h4>
																<p>{{job.comp_name}}</p>
															</div>
														</a>
										            </div>
												</div>						
											</div><!-- inner div -->
										</div>
									</div>
								</div>
								
							</div>
						</div>
						
						<!-- 13 Achievements and Awards  -->
						<div class="gallery-item">
		                    <div class="dtl-box">
		                        <div class="dtl-title">
		                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/achi-awards.png">
		                            <span>Achievements & Awards</span>
		                            <a href="#" data-target="#Achiv-awards" data-toggle="modal" ng-click="reset_awards_form();" class="pull-right" ng-if="from_user_id == to_user_id"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
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
		                                    <span ng-if="from_user_id == to_user_id">Showcase the honour you have achieved to profile.</span>
		                                    <span ng-if="from_user_id != to_user_id"><?php echo ucwords($business_data['company_name']); ?> hasn't added any achievements & awards.</span>
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
		                                                    <span role="button" data-toggle="collapse" data-parent="#award-accordion" href="#award{{$index}}" aria-expanded="true" aria-controls="exp1">
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
		                                                        <p class="screen-shot" check-file-ext check-file="{{user_awrd.award_file}}" check-file-path="<?php echo "'".addslashes(BUSINESS_USER_AWARD_UPLOAD_URL)."'"; ?>">
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
						
						<!-- 14 Timeline  -->
						<div class="gallery-item timeline-move" >
						</div>
						
						<!-- 03 blank div  -->
						<div class="gallery-item news-move" >
						</div>
						
						<!-- 15 News / Press Release  -->
						<div class="gallery-item">
							<div class="dtl-box press-rel" id="news-move">
								<div class="dtl-title">
									<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/news.png?ver=' . time()) ?>">
									<span>News / Press Release</span>
									<a href="javascript:void(0);" ng-if="from_user_id == to_user_id" data-target="#press-release" data-toggle="modal" class="pull-right" ng-click="reset_press_release();"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
								</div>
								<div id="press-release-loader" class="dtl-dis">
		                            <div class="text-center">
		                                <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
		                            </div>
		                        </div>
		                        <div id="press-release-body" style="display: none;">
		                            <div class="dtl-dis" ng-if="user_press_release.length < '1'">
		                                <div class="no-info">
		                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
		                                    <span ng-if="from_user_id == to_user_id">Add the news or press release related your business.</span>
		                                    <span ng-if="from_user_id != to_user_id"><?php echo ucwords($business_data['company_name']); ?> hasn't added any news.</span>
		                                </div>
		                            </div>
									<div class="dtl-dis dis-accor" ng-if="user_press_release.length > '0'">
										<div class="panel-group">
											<div class="panel panel-default" ng-repeat="press_release in user_press_release" ng-if="$index <= view_more_pr">
												<div class="panel-heading">
													<div class="panel-title">
														<a href="{{press_release.news_press_release_link}}" target="_self">
															<div class="dis-left">
																<div class="dis-left-img img-cus">
																	<img src="<?php echo base_url('assets/n-images/detail/press-rel.png?ver=' . time()) ?>">
																</div>
															</div>
															<div class="dis-middle">
																<h4>{{press_release.news_press_release_title}}</h4>
															</div>
														</a>
														<div class="dis-right">
															<a href="javascript:void(0);" ng-if="from_user_id == to_user_id" ng-click="edit_press_release($index)"><img src="<?php echo base_url('assets/n-images/detail/detial-edit.png?ver=' . time()) ?>"></a>
														</div>
													</div>
												</div>
											</div>
											<div id="view-more-pr" class="about-more" ng-if="user_press_release.length > 3">
		                                        <a href="#" ng-click="pr_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
		                                    </div>										
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- 16 Add menu  -->
						<div class="gallery-item menu-move" >
						</div>
						
					</div>

						</div>
						<div class="right-add add-detail">
							<div class="right-add-box">
								<div class="dtl-box p10 dtl-adv"></div>
							</div>
							
							<!-- edit profile  -->
							<div class="rsp-dtl-box" ng-if="from_user_id == to_user_id">
								<div class="dtl-box" id="edit-profile-move">
									<div class="dtl-title">
										<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/e-profile.png?ver=' . time()) ?>"><span>Edit Profile</span>
									</div>
									<div class="dtl-dis dtl-edit-p">
										<div class="dtl-edit-top"></div>
										<div class="profile-status">
											<ul>
												<li><span class=""><img ng-if="progress_status.user_image_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Profile pic</li>
												<li class="pl20"><span class=""><img ng-if="progress_status.profile_background_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Cover pic</li>
												
												<li><span class=""><img ng-if="progress_status.company_name_status == '1' && progress_status.business_type_status == '1' && progress_status.industriyal_status == '1' && progress_status.details_status == '1' && progress_status.business_tot_emp_status == '1' && progress_status.business_year_found_status == '1' && progress_status.business_pay_mode_status == '1' && progress_status.business_mission_status == '1' && progress_status.business_legal_name_status == '1' && progress_status.business_ser_pro_status == '1' && progress_status.business_serve_area_status == '1' && progress_status.business_tagline_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Basic Info</li>
												<li class="pl20"><span class=""><img ng-if="progress_status.timeline_status == '1'" src="<?php echo base_url(); ?>assets/n-images/detail/c.png"></span>Timeline</li>

												<li><span class=""><img ng-if="progress_status.contact_person_status == '1' && progress_status.contact_mobile_status == '1' && progress_status.contact_email_status == '1' && progress_status.contact_job_title_status == '1'" src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>Contact Info</li>
												<li class="pl20"><span class=""><img ng-if="progress_status.country_status == '1' && progress_status.state_status == '1' && progress_status.city_status == '1' && progress_status.pincode_status == '1' && progress_status.address_status == '1' && progress_status.business_no_location_status == '1' && progress_status.business_office_location_status == '1'" src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>Address</li>

												<li><span class=""><img ng-if="progress_status.key_member_status == '1'" src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>Key Members</li>
												<li class="pl20"><span class=""><img ng-if="progress_status.user_links_status == '1'" src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>Social</li>
												
												<li class="fw"><span class=""><img ng-if="progress_status.story_data_status == '1'" src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>Business Started</li>
												<li class="fw"><span class=""><img ng-if="progress_status.hours_operation_status == '1'" src="<?php echo base_url('assets/n-images/detail/c.png?ver=' . time()) ?>"></span>Hours of Operation</li>
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
					                            <span ng-if="from_user_id == to_user_id">Enter your social profile links. Let people stay connected with you on other platforms too.</span>
					                            <span ng-if="from_user_id != to_user_id"><?php echo ucwords($business_data['company_name']); ?> hasn't added any social links.</span>
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
					
							<!-- Timeline  -->
							<div class="rsp-dtl-box">
								<div class="dtl-box" id="timeline-move">
									<div class="dtl-title">
										<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/timeline.png?ver=' . time()) ?>"><span>Timeline</span><a href="#" ng-if="from_user_id == to_user_id" data-target="#timeline-cus" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/detail-add.png?ver=' . time()) ?>"></a>
									</div>
									<div class="dtl-dis">
										<div class="no-info" ng-if="timeline_data.length < '1'">
											<img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
											<span ng-if="from_user_id == to_user_id">Show your business greatest achievements and events.</span>
											<span ng-if="from_user_id != to_user_id"><?php echo ucwords($business_data['company_name']); ?> hasn't added any achievements.</span>
										</div>
										<div class="fw dtl-more-add" ng-if="timeline_data.length > '0'">
											<a href="#" data-target="#timeline-cus" data-toggle="modal"><span class="pr10">{{from_user_id == to_user_id ? 'Add' : 'View'}} Timeline </span><img ng-if="from_user_id == to_user_id" src="<?php echo base_url('assets/n-images/detail/inr-add.png?ver=' . time()) ?>"></a>
										</div>
									</div>
									
								</div>
							</div>
					
							<!-- Hours of Operation  -->
							<div class="rsp-dtl-box">
								<div class="dtl-box" id="hour-move">
										<div class="dtl-title">
											<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/ho-op.png?ver=' . time()) ?>"><span>Hours of Operation</span><a href="#" ng-if="from_user_id == to_user_id" ng-click="edit_opening_hours();" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
										</div>
										<div id="hours-loader" class="dtl-dis">
						                    <div class="text-center">
						                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
						                    </div>
						                </div>
						                <div id="hours-body" style="display: none;">
											<div class="dtl-dis">
						                        <div class="no-info" ng-if="!bus_opening_hours">
						                            <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
						                            <span ng-if="from_user_id == to_user_id">Add your company operating hours.</span>
						                            <span ng-if="from_user_id != to_user_id"><?php echo ucwords($business_data['company_name']); ?> hasn't added operating hours.</span>
						                        </div>
												<ul class="dis-list list-ul-cus" ng-if="bus_opening_hours">
													<li ng-if="bus_opening_hours.opening_hour">
														<span>Opening hours</span>
														<label ng-if="bus_opening_hours.opening_hour == '1'">Always open</label>
														<label ng-if="bus_opening_hours.opening_hour == '2'">On Specified Days</label>
														<label ng-if="bus_opening_hours.opening_hour == '3'">Appointment needed</label>
													</li>
													<li ng-if="bus_opening_hours.opening_hour == '2'">
														<span ng-if="bus_opening_hours.sun_from_time || bus_opening_hours.sun_from_ap || bus_opening_hours.sun_to_time || bus_opening_hours.sun_to_ap || 
														bus_opening_hours.mon_from_time || bus_opening_hours.mon_from_ap || bus_opening_hours.mon_to_time || bus_opening_hours.mon_to_ap || 
														bus_opening_hours.tue_from_time || bus_opening_hours.tue_from_ap || bus_opening_hours.tue_to_time || bus_opening_hours.tue_to_ap || 
														bus_opening_hours.wed_from_time || bus_opening_hours.wed_from_ap || bus_opening_hours.wed_to_time || bus_opening_hours.wed_to_ap || 
														bus_opening_hours.thu_from_time || bus_opening_hours.thu_from_ap || bus_opening_hours.thu_to_time || bus_opening_hours.thu_to_ap || 
														bus_opening_hours.fri_from_time || bus_opening_hours.fri_from_ap || bus_opening_hours.fri_to_time || bus_opening_hours.fri_to_ap || 
														bus_opening_hours.sat_from_time || bus_opening_hours.sat_from_ap || bus_opening_hours.sat_to_time || bus_opening_hours.sat_to_ap">Days</span>

														<label ng-if="bus_opening_hours.sun_from_time && bus_opening_hours.sun_from_ap && bus_opening_hours.sun_to_time && bus_opening_hours.sun_to_ap">Sunday : {{bus_opening_hours.sun_from_time}} {{bus_opening_hours.sun_from_ap}} to {{bus_opening_hours.sun_to_time}} {{bus_opening_hours.sun_to_ap}}</label>

														<label ng-if="bus_opening_hours.mon_from_time && bus_opening_hours.mon_from_ap && bus_opening_hours.mon_to_time && bus_opening_hours.mon_to_ap">Monday : {{bus_opening_hours.mon_from_time}} {{bus_opening_hours.mon_from_ap}} to {{bus_opening_hours.mon_to_time}} {{bus_opening_hours.mon_to_ap}}</label>
														<label ng-if="bus_opening_hours.tue_from_time && bus_opening_hours.tue_from_ap && bus_opening_hours.tue_to_time && bus_opening_hours.tue_to_ap">Tuesday : {{bus_opening_hours.tue_from_time}} {{bus_opening_hours.tue_from_ap}} to {{bus_opening_hours.tue_to_time}} {{bus_opening_hours.tue_to_ap}}</label>
														<label ng-if="bus_opening_hours.wed_from_time && bus_opening_hours.wed_from_ap && bus_opening_hours.wed_to_time && bus_opening_hours.wed_to_ap">Wednesday : {{bus_opening_hours.wed_from_time}} {{bus_opening_hours.wed_from_ap}} to {{bus_opening_hours.wed_to_time}} {{bus_opening_hours.wed_to_ap}}</label>
														<label ng-if="bus_opening_hours.thu_from_time && bus_opening_hours.thu_from_ap && bus_opening_hours.thu_to_time && bus_opening_hours.thu_to_ap">Thursday : {{bus_opening_hours.thu_from_time}} {{bus_opening_hours.thu_from_ap}} to {{bus_opening_hours.thu_to_time}} {{bus_opening_hours.thu_to_ap}}</label>
														<label ng-if="bus_opening_hours.fri_from_time && bus_opening_hours.fri_from_ap && bus_opening_hours.fri_to_time && bus_opening_hours.fri_to_ap">Friday : {{bus_opening_hours.fri_from_time}} {{bus_opening_hours.fri_from_ap}} to {{bus_opening_hours.fri_to_time}} {{bus_opening_hours.fri_to_ap}}</label>
														<label ng-if="bus_opening_hours.sat_from_time && bus_opening_hours.sat_from_ap && bus_opening_hours.sat_to_time && bus_opening_hours.sat_to_ap">Saturday : {{bus_opening_hours.sat_from_time}} {{bus_opening_hours.sat_from_ap}} to {{bus_opening_hours.sat_to_time}} {{bus_opening_hours.sat_to_ap}}</label>
													</li>
												</ul>
											</div>
										</div>
										
									</div>
							</div>
					
							<!-- Add Menu  -->
							<div class="rsp-dtl-box">
								<div class="dtl-box add-menu" id="menu-move">
									<div class="dtl-title">
										<img class="cus-width" src="<?php echo base_url('assets/n-images/detail/menu.png?ver=' . time()) ?>"><span>Add Menu</span><a href="#" data-target="#add-menu" ng-if="from_user_id == to_user_id" data-toggle="modal" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/edit.png?ver=' . time()) ?>"></a>
									</div>
									<div id="menu-loader" class="dtl-dis">
					                    <div class="text-center">
					                        <img alt="Loader" src="<?php echo base_url(); ?>assets/images/loader.gif">
					                    </div>
					                </div>
					                <div id="menu-body" style="display: none;">
					                	<div class="no-info" ng-if="menu_info_data.length < '1'">
											<img src="<?php echo base_url('assets/n-images/detail/edit-profile.png?ver=' . time()) ?>">
											<span ng-if="from_user_id == to_user_id">Show what product or service you offer.</span>
											<span ng-if="from_user_id != to_user_id"><?php echo ucwords($business_data['company_name']); ?> hasn't added any menu.</span>
										</div>
										<div class="dtl-dis" ng-if="menu_info_data.length > '0'">
											<ul class="dis-list">
												<li ng-repeat="menu_info in menu_info_data | limitTo:6">
													<p class="screen-shot" data-target="#add-menu" data-toggle="modal">
														<img ng-src="<?php echo BUSINESS_USER_MENU_IMG_UPLOAD_URL; ?>{{menu_info.file_name}}">
													</p>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
        </section>
		</div>
		
	<!---  model basic information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="job-basic-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Basic Information</span>
					</div>
					<form name="business_info_form" id="business_info_form" ng-validate="business_info_validate">
						<div class="dtl-dis">
							<div class="form-group">
								<label>Business Name</label>
								<input type="text" placeholder="Business Name" id="business_name" name="business_name" maxlength="255">
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Business Type</label>
										<span class="span-select">
											<select id="business_type" name="business_type" ng-model="business_type" ng-change="other_business_type_fnc();">
												<option value="">Select Business Type</option>
												<?php foreach ($business_types as $key => $value) { ?>
													<option value="<?php echo $value['type_id']; ?>"><?php echo $value['business_name']; ?></option>
												<?php } ?>
												<option value="0">Other</option>
											</select>
										</span>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Business Category / Industry</label>
										<span class="span-select">
											<select id="business_category" name="business_category" ng-model="business_category" ng-change="other_business_category_fnc();">
												<option value="">Select Category / Industry</option>
												<?php foreach ($business_category as $key => $value) { ?>
													<option value="<?php echo $value['industry_id']; ?>"><?php echo $value['industry_name']; ?></option>
												<?php } ?>
												<option value="0">Other</option>
											</select>
										</span>
									</div>
								</div>
							</div>
							<div id="other_div" class="row" style="display: none;">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div id="other_business_type_div" class="form-group" style="display: none;">
										<label>Other business type</label>
										<input type="text" placeholder="Other business type" id="other_business_type" name="other_business_type" maxlength="255">
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div id="other_business_category_div" class="form-group" style="display: none;">
										<label>Other category</label>
										<input type="text" placeholder="Other category" id="other_business_category" name="other_business_category" maxlength="255">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label>Business Description </label>
								<textarea type="text" placeholder="Business Description" class="big-textarea" id="business_desc" name="business_desc" maxlength="700"></textarea>
							</div>
							
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Total Employees</label>
										<span class="span-select">
											<select id="business_tot_emp" name="business_tot_emp">
												<option value="">Select Total Employees</option>
												<option value="1">1 to 10</option>
												<option value="2">10 to 30</option>
												<option value="3">30 to 50</option>
												<option value="4">More than 50</option>
											</select>
										</span>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Year Founded / Established</label>
										<span class="span-select">
											<select id="business_year_found" name="business_year_found">
												<option value="">Select</option>
												<?php 
												$year = date('Y');
												for ($i = $year; $i >= $year - 100; $i--) { ?>
													<option value="<?php echo  $i; ?>"><?php echo  $i; ?></option>
												<?php 
												} ?>
											</select>
										</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Specialties / Extra Benefits<span class="hidden-xs"> / Facilities</span></label>
										<!-- <input type="text" placeholder="Extra Benefits-tags"> -->
										<tags-input id="business_ext_benifit" ng-model="business_ext_benifit" display-property="benifit" placeholder="Extra Benefits" replace-spaces-with-dashes="false" template="title-template" ng-keyup="business_ext_benifit_fnc()">
	                                	</tags-input>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Payment Mode Accepted</label>
										<span class="span-select">
											<select id="business_pay_mode" name="business_pay_mode">
												<option value="">Select</option>
												<option value="1">Cash</option>
												<option value="2">Online</option>
												<option value="3">Card</option>
												<option value="4">Wallet</option>
											</select>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Business Keywords</label>							
								<tags-input id="business_keyword" ng-model="business_keyword" display-property="keyword" placeholder="Business Keywords" replace-spaces-with-dashes="false" template="title-template" ng-keyup="business_keyword_fnc()">
								</tags-input>
							</div>
							<div class="form-group">
								<label>Mission</label>
								<textarea type="text" placeholder="Mission" id="business_mission" name="business_mission" maxlength="700"></textarea>
							</div>
							<div class="form-group">
								<label>Legal Name</label>
								<input type="text" placeholder="Legal Name" id="business_legal_name" name="business_legal_name">
							</div>
							<div class="form-group">
								<label>Services / Products you offer (Tags)</label>
								<!-- <input type="text" placeholder="Services / Products you offer (Tags)"> -->
								<tags-input id="business_ser_pro" ng-model="business_ser_pro" display-property="services" placeholder="Services / Products" replace-spaces-with-dashes="false" template="title-template" ng-keyup="business_ser_pro_fnc()">
								</tags-input>
							</div>
							<div class="form-group">
								<label>Area Served (City)</label>							
								<!-- <input type="text" placeholder="Area Served" id="business_serve_area" name="business_serve_area" ng-model="business_serve_area" maxlength="255"> -->
								<tags-input id="business_serve_area" ng-model="business_serve_area" display-property="city" placeholder="Area Served" replace-spaces-with-dashes="false" template="title-template" ng-keyup="business_serve_area_fnc()" on-tag-added="onKeyup()">
                                        <auto-complete source="loadCities($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                    </tags-input>                        
                                    <script type="text/ng-template" id="title-template">
                                        <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                    </script>
                                    <script type="text/ng-template" id="title-autocomplete-template">
                                        <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                    </script>
								</tags-input>
							</div>
							<div class="form-group">
								<label>Tagline</label>
								<input type="text" placeholder="Tagline" id="business_tagline" name="business_tagline">
							</div>
							<div class="form-group">
								<label>Formerly Knowns as</label>
								<input type="text" placeholder="Formerly Knowns as" id="business_formly_known" name="business_formly_known">
							</div>						
						</div>
						<div class="dtl-btn">
							<a id="save_business" href="javascript:void(0);" ng-click="save_business()" class="save">
								<span>Save</span>
							</a>
							<div id="save_business_loader"  class="dtl-popup-loader" style="display: none;">
		                    	<img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
	
	<!---  model Business Portfolio  -->
	<div style="display:none;" class="modal fade dtl-modal" id="bus-portfolio" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Business Portfolio</span>
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
	                        <span>Are you sure you want to delete business portfolio ?</span>
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
	
	<!---  model Key Members Information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="member-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Key Members Information</span>
					</div>
					<form name="business_member_form" id="business_member_form" ng-validate="business_member_validate">
						<div class="dtl-dis">
							<div class="form-group">
								<label>Name</label>
								<input type="text" placeholder="Name" id="member_name" name="member_name" maxlength="255">
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Designation</label>
										<input type="text" placeholder="Enter Designation" id="member_job_title" name="member_job_title" ng-model="member_job_title" ng-keyup="basic_job_title_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off" maxlength="255">
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 fw-479">
									<div class="form-group">
										<label>Gender </label>
										<span class="span-select">
											<select id="member_gender" name="member_gender">
												<option value="">Select Gender</option>
												<option value="1">Male</option>
												<option value="2">Female</option>
												<option value="3">Other</option>
											</select>
										</span>
									</div>
								</div>								
							</div>
							<div class="form-group">
								<label>Biography</label>
								<textarea type="text" placeholder="Biography" id="member_bio" name="member_bio" ng-model="member_bio" maxlength="700"></textarea>
								<span class="pull-right">{{700 - member_bio.length}}</span>
							</div>
							
							<div class="row pb20">
								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-4 mob-pr0">
										<div class="form-group">
											<label>Website</label>
										</div>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-7">
										<div class="form-group">
											<label>URL</label>
										</div>
									</div>																
								</div>

								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-4 mob-pr0">
										<div class="form-group">
											<label>LinkedIn</label>
										</div>
									</div>
									<div class="col-md-9 col-sm-9 col-xs-7">
										<div class="form-group">
											<input type="text" placeholder="URL" id="linkedin_url" name="linkedin_url" maxlength="255">
										</div>
									</div>																
								</div>
								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-4 mob-pr0">
										<div class="form-group">
											<label>Twitter</label>
										</div>
									</div>
									<div class="col-md-9 col-sm-9 col-xs-7">
										<div class="form-group">
											<input type="text" placeholder="URL" id="twitter_url" name="twitter_url" maxlength="255">
										</div>
									</div>															
								</div>
							</div>
							
							<div class="form-group">
								<div class="upload-file">
		                            <label>Upload Photo of key member</label>
		                            <input type="file" id="member_img" name="member_img">
		                            <span id="member_img_error" class="error" style="display: none;"></span>
		                        </div>
							</div>
						</div>
						<div class="dtl-btn">
							<a id="save_member" href="javascript:void(0);" ng-click="save_member()" class="save">
								<span>Save</span>
							</a>
							<div id="member_loader"  class="dtl-popup-loader" style="display: none;">
		                    	<img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
							</div>
						</div>
					</form>
				</div>	


            </div>
        </div>
    </div>
    <div class="modal fade message-box biderror" id="delete-member-model" role="dialog">
	    <div class="modal-dialog modal-lm">
	        <div class="modal-content">
	            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
	            <div class="modal-body">
	                <span class="mes">
	                    <div class='pop_content'>
	                        <span>Are you sure you want to delete member ?</span>
	                        <p class='poppup-btns pt20'>
	                            <span id="member-delete-btn">
	                                <a id="delete_member" href="javascript:void(0);" ng-click="delete_member()" class="btn1">
	                                    <span>Delete</span>
	                                </a> 
	                                <a class='btn1' href="javascript:void(0);" data-dismiss="modal">Cancel</a>
	                            </span>
	                            <img id="delete_member_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
	                        </p>
	                    </div>
	                </span>
	            </div>
	        </div>
	    </div>
	</div>
	
	<!---  model Address Information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="add-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Address Information</span>
					</div>
					<form name="address_info_form" id="address_info_form" ng-validate="address_info_validate">
						<div class="dtl-dis">
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4">
									<div class="form-group">
										<label>Country</label>
										<span class="span-select">
											<select id="address_country" name="address_country" ng-model="address_country" ng-change="address_country_change()">
	                                            <option value="">Country</option>         
	                                            <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
	                                        </select>
										</span>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<div class="form-group">
										<label>State</label>
										<span class="span-select">
											<select id="address_state" name="address_state" ng-model="address_state" ng-change="address_state_change()" disabled = "disabled">
	                                            <option value="">State</option>
	                                            <option data-ng-repeat='state_item in address_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
	                                        </select>
	                                        <img id="address_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
										</span>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<div class="form-group">
										<label>City</label>
										<span class="span-select">
											<select id="address_city" name="address_city" ng-model="address_city" disabled = "disabled">
	                                            <option value="">City</option>
	                                            <option data-ng-repeat='city_item in address_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
	                                        </select>
	                                        <img id="address_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Street Address</label>
								<textarea type="text" placeholder="Street Address" id="address_address" name="address_address" maxlength="700"></textarea>
							</div>
							<div class="form-group">
								<label>Pincode</label>
								<input type="text" placeholder="Pincode" id="address_pincode" name="address_pincode" maxlength="20">
							</div>
							
							<div class="form-group">
								<label>No. of Locations</label>
								<span class="span-select">
									<select id="address_no_location" name="address_no_location">
										<option value="">Select</option>
										<option value="1">1 Location</option>
										<option value="2">1-5 Locations</option>
										<option value="3">5+ Locations</option>
										<option value="4">None-online only</option>
										<option value="5">None-I travel to my customers</option>
									</select>
								</span>
								
							</div>
							<div class="form-group o-l-e-c">
								<label class="fw">Is this Headquarters Address or Another Office Location?</label>
								<label class="control control--radio pr20">
									Headquaters
									<input class="gen-male" type="radio" id="gen" name="address_office_location" value="1" ng-model="address_office_location">
									<div class="control__indicator"></div>
								</label>
								<label id="other-loc" class="control control--radio">
									Other location
									<input type="radio" id="gen" name="address_office_location" value="2" ng-model="address_office_location">
									<div class="control__indicator"></div>
								</label>
							</div>							
						</div>
						<div class="dtl-btn">
							<a id="save_address_info" href="#" ng-click="save_address_info()" class="save">
								<span>Save</span>
							</a>
	                        <div id="save_address_info_loader" class="dtl-popup-loader" style="display: none;">
	                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
	                        </div>
						</div>
					</form>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Contact Information  -->
	<div style="display:none;" class="modal fade dtl-modal" id="contact-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Contact Information</span>
					</div>
					<form name="contact_info_form" id="contact_info_form" ng-validate="contact_info_validate">
						<div class="dtl-dis">
							<div class="form-group">
								<label>Contact Person Name / Owner Name</label>
								<input type="text" placeholder="Contact Person Name / Owner Name" id="contact_person" name="contact_person" maxlength="255">
							</div>						
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Designation / Role </label>
										<input type="text" placeholder="Designation / Role" id="contact_job_title" name="contact_job_title" ng-model="contact_job_title" ng-keyup="contact_job_title_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off" maxlength="255">
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Contact Number</label>
										<input type="text" placeholder="Contact Number" id="contact_mobile" name="contact_mobile" maxlength="15" ng-model="contact_mobile" numbers-only>
									</div>
								</div>							
							</div>
							
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Email Id</label>
										<input type="text" placeholder="Email Id" id="contact_email" name="contact_email" maxlength="255">
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Website <span class="link-must">(Must be http:// or https://)</span></label>
										<input type="text" placeholder="Website" id="contact_website" name="contact_website" maxlength="255">
									</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Fax Number</label>
										<input type="text" placeholder="Fax Number" id="contact_fax" name="contact_fax" maxlength="20">
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Toll Free Number</label>
										<input type="text" placeholder="Toll Free Number" id="contact_tollfree" name="contact_tollfree" maxlength="30">
									</div>
								</div>
							</div>
						</div>
						<div class="dtl-btn">
							<a id="save_contact_info" href="#" ng-click="save_contact_info()" class="save">
								<span>Save</span>
							</a>
	                        <div id="save_contact_info_loader" class="dtl-popup-loader" style="display: none;">
	                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
	                        </div>
						</div>
					</form>
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
	                                        <label>URL</label>
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
	
	<!---  model Hours of Operation  -->
	<div style="display:none;" class="modal fade dtl-modal" id="hours-opration" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Hours of Operation</span>
					</div>
					<form name="opening_hours_form" id="opening_hours_form" ng-validate="opening_hours_validate">
						<div class="dtl-dis">
							<div class="form-group">
								<label>Select opening hours</label>
								<span class="span-select">
									<select id="opening_hour" name="opening_hour" ng-model="opening_hour" ng-change="change_opening_hour();">
										<option value="">Select opening hours</option>
										<option value="1">Always open</option>
										<option value="2">On Specified Days</option>
										<option value="3">Appointment needed</option>
									</select>
								</span>
							</div>
							<div id="specified_day_div" class="row" style="display: none;">
								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-3 fw-479">
										<div class="form-group">
											<label>Days</label>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>From</label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>&nbsp;</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>To</label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>&nbsp;</label>	
												</div>
											</div>
										</div>
									</div>								
								</div>
								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-3 fw-479">
										<div class="form-group">
											<span>Sunday</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="sun_from_time" name="sun_from_time" ng-model="sun_from_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="sun_from_ap" name="sun_from_ap" ng-model="sun_from_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="sun_to_time" name="sun_to_time" ng-model="sun_to_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="sun_to_ap" name="sun_to_ap" ng-model="sun_to_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>								
								</div>

								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-3 fw-479">
										<div class="form-group">
											<span>Monday</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="mon_from_time" name="mon_from_time" ng-model="mon_from_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="mon_from_ap" name="mon_from_ap" ng-model="mon_from_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="mon_to_time" name="mon_to_time" ng-model="mon_to_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="mon_to_ap" name="mon_to_ap" ng-model="mon_to_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>								
								</div>

								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-3 fw-479">
										<div class="form-group">
											<span>Tuesday</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="tue_from_time" name="tue_from_time" ng-model="tue_from_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="tue_from_ap" name="tue_from_ap" ng-model="tue_from_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="tue_to_time" name="tue_to_time" ng-model="tue_to_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="tue_to_ap" name="tue_to_ap" ng-model="tue_to_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>								
								</div>

								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-3 fw-479">
										<div class="form-group">
											<span>Wednesday</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="wed_from_time" name="wed_from_time" ng-model="wed_from_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="wed_from_ap" name="wed_from_ap" ng-model="wed_from_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="wed_to_time" name="wed_to_time" ng-model="wed_to_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="wed_to_ap" name="wed_to_ap" ng-model="wed_to_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>								
								</div>

								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-3 fw-479">
										<div class="form-group">
											<span>Thursday</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="thu_from_time" name="thu_from_time" ng-model="thu_from_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="thu_from_ap" name="thu_from_ap" ng-model="thu_from_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="thu_to_time" name="thu_to_time" ng-model="thu_to_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="thu_to_ap" name="thu_to_ap" ng-model="thu_to_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>								
								</div>

								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-3 fw-479">
										<div class="form-group">
											<span>Friday</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="fri_from_time" name="fri_from_time" ng-model="fri_from_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="fri_from_ap" name="fri_from_ap" ng-model="fri_from_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="fri_to_time" name="fri_to_time" ng-model="fri_to_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="fri_to_ap" name="fri_to_ap" ng-model="fri_to_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>								
								</div>

								<div class="">
									<div class="col-md-3 col-sm-3 col-xs-3 fw-479">
										<div class="form-group">
											<span>Saturday</span>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="sat_from_time" name="sat_from_time" ng-model="sat_from_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="sat_from_ap" name="sat_from_ap" ng-model="sat_from_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="sat_to_time" name="sat_to_time" ng-model="sat_to_time">
															<option value="">Select</option>
															<?php foreach ($time_array as $key => $value) { ?>
																<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
															<?php 
															} ?>
														</select>
													</span>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<span class="span-select">
														<select id="sat_to_ap" name="sat_to_ap" ng-model="sat_to_ap">
															<option value="">Select</option>
															<option value="AM">AM</option>
															<option value="PM">PM</option>
														</select>
													</span>
												</div>
											</div>
										</div>
									</div>								
								</div>
							</div>						
						</div>
						<div class="dtl-btn">
							<div class="dtl-btn bottom-btn">
								<a id="save_opening_hours" href="#" ng-click="save_opening_hours()" class="save">
									<span>Save</span>
								</a>
		                        <div id="opening_hours_loader" class="dtl-popup-loader" style="display: none;">
		                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
		                        </div>
							</div>
						</div>
					</form>
				</div>	


            </div>
        </div>
    </div>
	
	<!---  model Add Menu  -->
	<div style="display:none;" class="modal fade dtl-modal" id="add-menu" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<a href="#" ng-if="from_user_id == to_user_id" data-target="#add-menu-img" data-toggle="modal" class=""><img src="<?php echo base_url('assets/n-images/detail/detail-add1.png?ver=' . time()) ?>"><span class="timeline-tital">Add Menu</span></a>
					</div>
					<div class="dtl-dis">
						<div class="menu-privew">
							<ul>
								<li ng-repeat="menu_info in menu_info_data">
									<p ng-click="openModal();currentSlide($index + 1)">
										<img ng-src="<?php echo BUSINESS_USER_MENU_IMG_UPLOAD_URL; ?>{{menu_info.file_name}}">
									</p>
								</li>
							</ul>
						</div>
					</div>					
				</div>
			</div>
        </div>
    </div>

    <div id="myModalPhotos" class="modal modal2" style="display: none;">
		<button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal()">×</button>
		<div class="modal-dialog">
	        <div class="modal-content">
	        	<div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
	        		<img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
	            </div>
		 		<div class="mySlides" ng-repeat="menu_info in menu_info_data">
		 			<div class="numbertext"></div>
		 			<div class="slider_img_p">	 				
		 				<img ng-src="<?php echo BUSINESS_USER_MENU_IMG_UPLOAD_URL ?>{{menu_info.file_name}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">	                    
		 			</div>
		 		</div>	 		
		 	</div>
		 	<div class="caption-container">
		 		<p id="caption"></p>
		 	</div>
		</div> 
	 	<a class="prev" style="left:0px;" ng-click="plusSlides(-1)">&#10094;</a>
		<a class="next" ng-click="plusSlides(1)">&#10095;</a>
	</div>

    <!---  model add menu img  -->
	<div style="display:none;" class="modal fade dtl-modal " id="add-menu-img" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Add Menu</span>
					</div>
					<form id="business_menu_frm" name="business_menu_frm" ng-validate="business_menu_frm_validate">
						<div class="dtl-dis">
							<div class="form-group">
								<div class="upload-file">
		                            <label>Upload File</label>
		                            <input type="file" id="menu_file_name" name="menu_file_name">
		                            <span id="menu_file_name_error" class="error" style="display: none;"></span>
		                        </div>
							</div>
						</div>
						<div class="dtl-btn">
							<a id="save_menu" href="#" ng-click="save_menu()" class="save">
								<span>Save</span>
							</a>
	                        <div id="menu_loader" class="dtl-popup-loader" style="display: none;">
	                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
	                        </div>
						</div>
					</form>
				</div>	


            </div>
        </div>
    </div>
	
	<!-- modal Reviews  -->
	<div style="display:none;" class="modal fade dtl-modal" id="reviews" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Reviews</span>
					</div>
					<form id="business_review" name="business_review" ng-validate="business_review_validate">
						<div class="dtl-dis">
							<div class="form-group">
								<div class="rev-img">
									<?php if($login_bussiness_data->business_user_image != ''): ?>
									<img src="<?php echo BUS_PROFILE_MAIN_UPLOAD_URL.$login_bussiness_data->business_user_image; ?>">
									<?php else: ?>
										<div class="post-img-profile">
											<?php echo strtoupper(substr($login_bussiness_data->company_name, 0,1)); ?>
										</div>
									<?php endif; ?>
								</div>
								<div class="total-rev-top">
									<h4><?php echo $login_bussiness_data->company_name; ?></h4>
									<span class="rating-star">
										<input id="review_star" value="5" type="number" class="rating" data-min=0 data-max=5 data-step=0.5 data-size="sm" required name="review_star">
									</span>
								</div>
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea type="text" placeholder="Description" id="review_desc" name="review_desc" maxlength="700" ng-model="review_desc"></textarea>
								<span class="pull-right">{{700 - review_desc.length}}</span>
							</div>
							<div class="form-group">
								<div class="upload-file">
									<span class="fw">Upload Photo</span>
									<input type="file" id="review_file" name="review_file">
									<span id="review_file_error" class="error" style="display: none;"></span>
								</div>
							</div>
						</div>
						<div class="dtl-btn bottom-btn">
							<a id="save_review" href="#" ng-click="save_review()" class="save">
								<span>Save</span>
							</a>
	                        <div id="review_loader" class="dtl-popup-loader" style="display: none;">
	                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
	                        </div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
	
	
	<!---  model How Business Name Started?  -->
	<div style="display:none;" class="modal fade dtl-modal timeline-cus bus-start-cus" id="bus-name-started" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>How <?php echo ucwords($business_data['company_name']); ?> Started?</span>
					</div>
					<form id="story_form" name="story_form" ng-validate="story_form_validate">
						<div class="dtl-dis">						
							<div class="bus-story no-img-upload" style="float: left;width: 100%;">
								<label class="upload-file">
									<img class="story_u_f" src="<?php echo base_url('assets/n-images/detail/bus-story-upload.png?ver=' . time()) ?>">
									<input type="file" id="story_file" name="story_file">
									<span id="upload-file" style="display: none;">Change</span>
								</label>
							</div>
							<div id="story-upload" class="s-u-p"></div>
							<img id="upload_img" ng-src="{{story_image}}" style="display: none;">
							<div class="form-group">
								<label>Description</label>
								<textarea maxlength="2000" type="text" id="story_desc" name="story_desc" ng-model="story_desc" placeholder="Describe your business struggle story"></textarea>
								<span class="pull-right">{{2000 - story_desc.length}}</span>
							</div>
							<div class="form-group">
								<label>What differentiate you from your competitiors</label>
								<textarea maxlength="2000" type="text" id="story_diff" name="story_diff" ng-model="story_diff" placeholder="What differentiate you from your competitiors"></textarea>
								<span class="pull-right">{{2000 - story_diff.length}}</span>
							</div>
						</div>
						<div class="dtl-btn bottom-btn">
							<a id="save_business_story" href="#" ng-click="save_business_story()" class="save">
								<span>Save</span>
							</a>
	                        <div id="save_business_story_loader" class="dtl-popup-loader" style="display: none;">
	                            <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
	                        </div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>

    <div style="display:none;" class="modal fade dtl-modal timeline-cus bus-start-cus" id="bus-name-started-display" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>How <?php echo ucwords($business_data['company_name']); ?> Started?</span>
					</div>					
					<div class="dtl-dis">						
						<div class="bus-story no-img-upload" style="float: left;width: 100%;">
							<label class="upload-file">									
								<span id="upload-file1" style="display: none;">Change</span>
							</label>
						</div>												
						<div class="form-group">
							<h4>Description</h4>
							<label>{{story_data.story_desc}}</label>
						</div>
						<div class="form-group">
							<h4>Difference between <?php echo ucwords($business_data['company_name']); ?> and competitiors</h4>
							<label>{{story_data.story_diff}}</label>
						</div>
					</div>
					<div class="dtl-btn bottom-btn">
						<a href="#" class="save" data-dismiss="modal">
							<span>Close</span>
						</a>                        
					</div>
				</div>
			</div>
        </div>
    </div>
	
	
	
	<!---  model Timeline custom  -->
	<div style="display:none;" class="modal fade dtl-modal timeline-cus" id="timeline-cus" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">						
						<a href="#" ng-if="from_user_id == to_user_id" data-target="#timeline" data-toggle="modal" class=""><img src="<?php echo base_url('assets/n-images/detail/detail-add1.png?ver=' . time()) ?>"><span class="timeline-tital"> Add Timeline</span></a>
						<a href="#" ng-if="from_user_id != to_user_id" class=""><span class="timeline-tital">Timeline</span></a>
					</div>
					<div class="dtl-dis" ng-if="timeline_data.length < '1'">
                        <div class="no-timeline">
                            <a href="#" ng-if="from_user_id == to_user_id" data-target="#timeline" data-toggle="modal" class=""><img src="<?php echo base_url('assets/n-images/no-timeline1.jpg?ver=' . time()) ?>"><span class="timeline-tital"><h2>Add Timeline</h2></span></a>
                        </div>
                    </div>
					<div class="dtl-dis" ng-if="timeline_data.length > '0'">
						<section class="cd-horizontal-timeline">
							<div class="timeline">
								<div class="events-wrapper">
									<div class="events">
										<ol>
											<!-- <li><a href="#0" data-date="16/01/2014" class="selected">16 Jan<span> </span></a> </li> -->
											<li ng-repeat="timeline in timeline_data"><a href="#0" data-date="{{timeline.timeline_date_a}}" ng-class="$index == selected_timeline ? 'selected' : ''" ng-click="select_timeline($index);">{{timeline.timeline_date_li}}<span> </span></a> </li>
										</ol>

										<span class="filling-line" aria-hidden="true"></span>
									</div> <!-- .events -->
								</div> <!-- .events-wrapper -->
									
								<ul class="cd-timeline-navigation">
									<li><a href="#0" class="prev inactive"></a></li>
									<li><a href="#0" class="next"></a></li>
								</ul> <!-- .cd-timeline-navigation -->
							</div> <!-- .timeline -->

							<div class="events-content">
								<ol>
									<li ng-class="$index == selected_timeline ? 'selected' : ''" ng-repeat="timeline in timeline_data" data-date="{{timeline.timeline_date_a}}" ng-init="main_index=$index">
										<div ng-repeat="timeline_in_data in timeline.timeline_inner_data" ng-init="inner_index=$index">
											<div class="fw pb20">
												<div class="timeline-left">
													<img ng-if="!timeline_in_data.timeline_file" src="<?php echo base_url('assets/n-images/detail/def-timeline.png?ver=' . time()) ?>">

													<img ng-if="timeline_in_data.timeline_file" ng-src="<?php echo BUSINESS_USER_TIMELINE_UPLOAD_URL; ?>{{timeline_in_data.timeline_file}}">
												</div>
												<div class="timeline-right">
													<h2>{{timeline_in_data.timeline_title}}<a ng-if="from_user_id == to_user_id" href="javascript:void(0);" ng-click="edit_timeline(main_index,inner_index);" class="pull-right"><img src="<?php echo base_url('assets/n-images/detail/main-edit.png?ver=' . time()) ?>"></a></h2>
													<em>{{timeline_in_data.timeline_date_str}}</em>
												</div>
												
											</div>
											<p>
												{{timeline_in_data.timeline_desc}}
											</p>
										</div>
									</li>
									
								</ol>
							</div> <!-- .events-content -->
						</section>						
					</div>	
				</div>	
            </div>
        </div>
    </div>
	
	<!---  model Timeline  -->
	<div style="display:none;" class="modal fade dtl-modal " id="timeline" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>Timeline</span>
					</div>
					<form name="timeline_form" id="timeline_form" ng-validate="timeline_validate">
						<div class="dtl-dis">
							<div class="form-group">
								<label>Achievements Title</label>
								<input type="text" placeholder="Achievements Title" id="timeline_title" name="timeline_title" ng-model="timeline_title">
							</div>
							
							<div class="row">
	                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
									<div class="form-group">
										<label>Month</label>
		                                <span class="span-select">
		                                    <select id="timeline_month" name="timeline_month" ng-model="timeline_month" ng-change="timeline_date_fnc('','','')">
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
										<label>Day</label>
		                                <span class="span-select">
		                                    <select id="timeline_day" name="timeline_day" ng-model="timeline_day" ng-click="timeline_error()"></select>
		                                </span>
		                            </div>
	                            </div>
	                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
									<div class="form-group">
										<label>Year</label>
		                                <span class="span-select">
		                                    <select id="timeline_year" name="timeline_year" ng-model="timeline_year" ng-change="timeline_date_fnc('','','')" ng-click="timeline_error()">
		                                    </select>
		                                </span>
		                            </div>
	                            </div>
	                            <div class="col-md-12 col-sm-12">
	                                <span id="timelinedateerror" class="error" style="display: none;"></span>
	                            </div>
	                        </div>

							<div class="form-group big-textarea">
								<label>Description</label>
								<textarea type="text" placeholder="Description" id="timeline_desc" name="timeline_desc" ng-model="timeline_desc"></textarea>
								<span>{{700 - timeline_desc.length}}</span>
							</div>
							<div class="form-group">
								<div class="upload-file">
									<span class="fw">Upload Photo</span>
									<input type="file" id="timeline_file" name="timeline_file">
									<span id="timeline_file_error" class="error" style="display: none;"></span>
								</div>
							</div>
						</div>
						<div class="dtl-btn">
							<a id="save_timeline" href="#" ng-click="save_timeline()" class="save"><span>Save</span></a>
							<div id="timeline_loader"  class="dtl-popup-loader" style="display: none;">
		                    	<img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
    <div class="modal fade message-box biderror" id="delete-timeline-model" role="dialog">
	    <div class="modal-dialog modal-lm">
	        <div class="modal-content">
	            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
	            <div class="modal-body">
	                <span class="mes">
	                    <div class='pop_content'>
	                        <span>Are you sure you want to delete timeline ?</span>
	                        <p class='poppup-btns pt20'>
	                            <span id="timeline-delete-btn">
	                                <a id="delete_timeline" href="#" ng-click="delete_timeline()" class="btn1">
	                                    <span>Delete</span>
	                                </a> 
	                                <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
	                            </span>
	                            <img id="delete_timeline_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
	                        </p>
	                    </div>
	                </span>
	            </div>
	        </div>
	    </div>
	</div>
	
	<!---  model News / Press Release  -->
	<div style="display:none;" class="modal fade dtl-modal" id="press-release" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">×</button>
                <div class="modal-body-cus"> 
					<div class="dtl-title">
						<span>News / Press Release</span>
					</div>
					<form name="press_release_form" id="press_release_form" ng-validate="press_release_validate">
						<div class="dtl-dis">
							<div class="row">
								<div class="fw">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="form-group">
											<label>Title</label>
											<input type="text" placeholder="News Title" id="press_rel_title" name="press_rel_title" maxlength="255">
										</div>
									</div>
								</div>
								<div class="fw">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="form-group">
											<label>Add Link <span class="personal-link-info">(URL must start with http:// or https://)</span></label>
											<input type="text" placeholder="Add Website" id="press_rel_link" name="press_rel_link" maxlength="255">
										</div>
									</div>
								</div>							
							</div>
						</div>
						<div class="dtl-btn">
							<a id="save_press_release" href="#" ng-click="save_press_release()" class="save"><span>Save</span></a>
							<div id="press_release_loader"  class="dtl-popup-loader" style="display: none;">
		                    	<img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
    <div class="modal fade message-box biderror" id="delete-pr-model" role="dialog">
	    <div class="modal-dialog modal-lm">
	        <div class="modal-content">
	            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
	            <div class="modal-body">
	                <span class="mes">
	                    <div class='pop_content'>
	                        <span>Are you sure you want to delete news / press release ?</span>
	                        <p class='poppup-btns pt20'>
	                            <span id="pr-delete-btn">
	                                <a id="delete_press_release" href="#" ng-click="delete_press_release()" class="btn1">
	                                    <span>Delete</span>
	                                </a> 
	                                <a class='btn1' href="#" data-dismiss="modal">Cancel</a>
	                            </span>
	                            <img id="delete_press_release_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
	                        </p>
	                    </div>
	                </span>
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
	                                    <select id="award_day" name="award_day" ng-model="award_day" ng-click="award_error()"></select>
	                                </span>
	                            </div>
	                            </div>
	                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
								<div class="form-group">
	                                <span class="span-select">
	                                    <select id="award_year" name="award_year" ng-model="award_year" ng-change="award_date_fnc('','','')" ng-click="award_error()">
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
	                        <textarea type="text" placeholder="Enter Description" id="award_desc" name="award_desc" maxlength="700" ng-model="award_desc"></textarea>
	                        <span class="pull-right">{{700 - award_desc.length}}</span>
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
		
    <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <!--<img class="icon" src="images/dollar-icon.png" alt="" />-->
                    <span class="mes"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade message-box" id="query" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="profile-modal-close" id="query" data-dismiss="modal">&times;</button>       
                <div class="modal-body">
                    <span class="mes">
                    </span>
                </div>
            </div>
        </div>
    </div>
        
    <?php echo $login_footer ?>
    <?php echo $footer; ?>

    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
    
    <!-- <script src="<?php //echo base_url('assets/js/timeline.js?ver=' . time()); ?>"></script> -->
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
        var base_url = '<?php echo base_url(); ?>';
        var header_all_profile = '<?php echo $header_all_profile; ?>';
        var user_slug = "<?php echo $business_data['business_slug']; ?>"

        var from_user_id = '<?php echo $login_bussiness_data->user_id; ?>';
		var to_user_id = '<?php echo $business_data['user_id']; ?>';

        var business_user_award_upload_url = '<?php echo BUSINESS_USER_AWARD_UPLOAD_URL; ?>';
        var business_user_portfolio_upload_url = '<?php echo BUSINESS_USER_PORTFOLIO_UPLOAD_URL; ?>';
        var business_user_story_upload_url = '<?php echo BUSINESS_USER_STORY_UPLOAD_URL; ?>';
        var business_user_timeline_upload_url = '<?php echo BUSINESS_USER_TIMELINE_UPLOAD_URL; ?>';
        var business_member_img_upload_url = '<?php echo BUSINESS_MEMBER_IMG_UPLOAD_URL; ?>';
        $('#main_loader').hide();
        // $('#main_page_load').show();
        $('body').removeClass("body-loader");
        var app = angular.module("businessProfileApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
    </script>
    <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/details_new.js?ver=' . time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/details.js?ver=' . time()); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
    <!-- <script src="<?php //echo base_url('assets/js/jquery.mobile.custom.min.js?ver=' . time()); ?>"></script> -->
	<script>
		$(document).ready(function () {
			if (screen.width > 768)
			{
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
		// mcustom scroll bar
		(function($){
			$(window).on("load",function(){
				$(".custom-scroll").mCustomScrollbar({
					autoHideScrollbar:true,
					theme:"minimal"
				});
			});
		})(jQuery);
	</script>
	<script>
		$(document).ready(function ()
		{
			if (screen.width <= 1199)
			{
				$("#edit-profile-move").appendTo($(".edit-profile-move"));
				$("#social-link-move").appendTo($(".social-link-move"));
				$("#timeline-move").appendTo($(".timeline-move"));
				$("#hour-move").appendTo($(".hour-move"));
				$("#menu-move").appendTo($(".menu-move"));
				$("#news-move").appendTo($(".news-move"));
				$(".remove-blank").remove();
			}
			if (screen.width < 768) {
				$("#edit-profile-move").appendTo($(".edit-custom-move"));
			}
		});

	    // un-track $modal windows on hide
	    $(document).on('hide.bs.modal', function (e, $modal) {
	    	setTimeout(function(){
		    	if($('.modal.in').length > 0)
		    	{
		    		$("body").removeClass('modal-open');
		    		$("body").addClass('modal-open');
		    	}
	    	},100);
	    });
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
    <script type="text/ng-template" id="title-template">
        <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
    </script>

    </body>
</html>
