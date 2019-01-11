<!DOCTYPE html>
<html lang="en" ng-app="contactRequestApp" ng-controller="contactRequestController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/jquery-3.2.1.min.js') ?>"></script> -->
    	<?php $this->load->view('adsense'); ?>
    </head>
    <body class=" body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
            <?php echo $header_profile; ?>
            <div class="middle-section middle-section-banner">
                <div class="container pt20 mobp0">
					<div class="tab-add-991">
						<?php $this->load->view('banner_add'); ?>
					</div>
                    <div class="custom-user-list">
                        <div class="list-box-custom" ng-if="pending_contact_request_data.length > '0'">
                            <h3 class="mob-border-top-1">Pending Contact Request</h3>
                            <div class="sugg-list">
                                <div class="fw post_loader req_post_load" style="text-align:center; display: none;">
                                    <img ng-src="<?php echo base_url('assets/images/loader.gif')?>" alt="Loader" />
                                </div>                                
                                <ul class="">
                                    <li ng-repeat="contact in pending_contact_request_data">
                                        <div class="arti-profile-box">
                                        	<div class="user-cover-img">
												<a href="<?php echo base_url();?>{{contact.user_slug}}" target="_self">
													<img ng-if="contact.profile_background" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{contact.profile_background}}">
													<div ng-if="!contact.profile_background" class="gradient-bg" style="height: 100%"></div>
												</a>
											</div>
											<div class="user-pr-img">
												<a href="<?php echo base_url();?>{{contact.user_slug}}" target="_self">
													<img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{contact.user_image}}" ng-if="contact.user_image">                                                
                                                    <img ng-if="!contact.user_image && contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <img ng-if="!contact.user_image && contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
												</a>
											</div>                                            
                                            <div class="user-info-text text-center">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}" target="_self">
                                                	<span title="{{contact.fullname| capitalize}}" class="user-name main_data_cq" ng-bind="contact.fullname | capitalize"></span>
													<span class="user-des main_data_cq" title="{{contact.title_name}}" ng-if="contact.title_name != ''">{{contact.title_name}}</span>
													<span class="user-des main_data_cq" title="{{contact.degree_name}}" ng-if="contact.degree_name != ''">{{contact.degree_name}}</span>
													<span class="user-des main_data_cq" title="Current Work" ng-if="contact.title_name == null && contact.degree_name == null">Current Work</span>
												</a>
                                            </div>
                                            <div class="author-btn">
                                            	<p class="request-btn">
                                                    <a href="javascript:void(0);" class="btn1 pull-left" ng-click="confirmContact(contact.from_id, $index)">
                                                        Confirm
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn3 pull-right" ng-click="rejectContact(contact.from_id, $index)">
                                                        Decline
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="list-box-custom suggestion">
                            <h3>Suggestions</h3>
							<div class="sugg-list">
								<div class="no-data-box" ng-if="contactSuggetion.length == '0'">
                                    <div class="no-data-content">
                                        <p><img src="<?php echo base_url('assets/img/No_Contact_Request.png') ?>"></p>
                                        <p class="pt20">No Suggestion Contact Request</p>
                                    </div>
                                </div>
								<ul class="">
									<li ng-repeat="suggest in contactSuggetion">
										<div class="arti-profile-box">
											<div class="user-cover-img">
												<a href="<?php echo base_url();?>{{suggest.user_slug}}" target="_self">
													<img ng-if="suggest.profile_background" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{suggest.profile_background}}">
													<div ng-if="!suggest.profile_background" class="gradient-bg" style="height: 100%"></div>
												</a>
											</div>
											<div class="user-pr-img">
												<a href="<?php echo base_url();?>{{suggest.user_slug}}" target="_self">
													<img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{suggest.user_image}}" ng-if="suggest.user_image">                                                
                                                    <img ng-if="!suggest.user_image && suggest.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <img ng-if="!suggest.user_image && suggest.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
												</a>
											</div>
											<div class="user-info-text text-center">
												<a href="<?php echo base_url();?>{{suggest.user_slug}}" target="_self">
													<span title="{{suggest.fullname| capitalize}}" class="user-name main_data_cq" ng-bind="suggest.fullname | capitalize"></span>
													<span class="user-des main_data_cq" title="{{suggest.title_name}}" ng-if="suggest.title_name != ''">{{suggest.title_name}}</span>
													<span class="user-des main_data_cq" title="{{suggest.degree_name}}" ng-if="suggest.degree_name != ''">{{suggest.degree_name}}</span>
													<span class="user-des main_data_cq" title="Current Work" ng-if="suggest.title_name == null && suggest.degree_name == null">Current Work</span>
												</a>
											</div>
											
											<div class="author-btn">
												<div id="item-{{suggest.user_id}}" class="user-btns">
													<a class="btn3" ng-click="addToContact(suggest.user_id, suggest);">Add to Contacts</a>
												</div>
											</div>
										</div>
									</li>
								</ul>
								<div class="fw post_loader sugg_post_load" style="text-align:center; display: none;">
                                    <img ng-src="<?php echo base_url('assets/images/loader.gif');?>" alt="Loader" />
                                </div>
							</div>
                        </div>
                    </div>
                    <div class="right-add">
						<?php $this->load->view('right_add_box'); ?>
                        <div class="request-noti">
                            <div class="right-title">
                                Contact Request Notifications
                            </div>
                            <div class="content custom-scroll">
                                <div class="no-data-box" ng-if="contactRequestNotification.length == '0'">
                                    <div class="no-data-content">
                                        <p><img src="<?php echo base_url('assets/img/No_Contact_Request.png') ?>"></p>
                                        <p class="pt20">No Contact Request Notification</p>
                                    </div>
                                </div>
                                <ul class="request-list">
                                    <li ng-repeat="notification in contactRequestNotification">
                                        <a href="<?php echo base_url(); ?>{{notification.user_slug}}">
                                            <div class="post-img">
                                                <img src="<?php echo USER_MAIN_UPLOAD_URL ?>{{notification.user_image}}" alt="{{notification.fullname}}" ng-if="notification.user_image != ''">
                                                <img ng-if="notification.user_image == '' && notification.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-if="notification.user_image == '' && notification.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </div>
                                            <div class="request-detail">
                                                <h6 class="">
                                                    <b ng-bind="notification.fullname | capitalize" ng-bind="notification.fullname | capitalize"></b> confirmed your contact request.
                                                </h6>
                                                <p>{{notification.time_string}}</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php echo $left_footer_list_view; ?>
                        <!-- <div class="add-box fw">
                            <div class="adv-main-view">
                                <img src="<?php //echo base_url('assets/n-images/add.jpg'); ?>">
                            </div>
                        </div> -->
                    </div>

                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/classie.js'); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_slug = '<?php echo $this->uri->segment(2); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var item = '<?php echo $this->uri->segment(1); ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var app = angular.module("contactRequestApp", ['ngRoute', 'ui.bootstrap', 'ngSanitize']);
        </script>
        <script>
        
        $(function () {
            $('a[href="#search"]').on('click', function (event) {
                event.preventDefault();
                $('#search').addClass('open');
                $('#search > form > input[type="search"]').focus();
            });
            $('#search, #search button.close-new').on('click keyup', function (event) {
                if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                    $(this).removeClass('open');
                }
            });
        });
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/contact_request.js?ver=' . time()) ?>"></script>
    </body>
</html>