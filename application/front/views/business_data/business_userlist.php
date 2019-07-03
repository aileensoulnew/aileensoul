<!DOCTYPE html>
<html  ng-app="userListApp" ng-controller="userListController">
    <head>
        <title><?php echo $title; ?></title>
        <?php echo $head; ?>
        <?php
        if (IS_BUSINESS_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/business.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/business.css?ver=' . time()); ?>">
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>" />
        <?php $this->load->view('adsense'); ?>
    </head>
    <body class="page-container-bg-solid page-boxed pushmenu-push user-list">
        <?php echo $header; ?>
        <?php echo $business_header2; ?>
        <section>
            <div class="container" id="paddingtop_fixed">
            </div>
            <div class="user-midd-section bui_art_left_box">
                <div class="container art_container padding-360">
                    <div class="">
                        <div class="profile-box-custom fl animated fadeInLeftBig left_side_posrt" >
                            <div class="left_fixed">
                                <?php //echo $business_left ?>
                            </div>
                            <div class="left-search-box list-type-bullet">
                                <div class="">
                                    <h3>Top Categories</h3>
                                </div>
                                <ul class="search-listing custom-scroll">
                                    <li ng-repeat="category in businessCategory">
                                        <label class="control control--checkbox">
											<span>{{category.industry_name | capitalize}}
												<span class="pull-right">({{category.count}})</span>
											</span>
                                            <input class="category-filter categorycheckbox" type="checkbox" name="{{category.industry_name}}" value="{{category.industry_id}}" style="height: 12px;" [attr.checked]="(category.isselected) ? 'checked' : null" autocomplete="false">
											<div class="control__indicator"></div>
                                        </label>
                                    </li>
                                </ul>
                                <p class="text-left p10"><a href="<?php echo base_url('business-by-categories') ?>">View More Categories</a></p>
                            </div>
                            <!-- TOP Location -->
                            <div class="left-search-box list-type-bullet">
                                <div class="">
                                    <h3>Top Location</h3>
                                </div>
                                <ul class="search-listing custom-scroll">
                                    <li ng-repeat="location in businessLocation">
                                        <label class="control control--checkbox">
											<span>{{location.city_name | capitalize}}
												<span class="pull-right">({{location.count}})</span>
											</span>
                                            <input class="category-filter locationcheckbox" type="checkbox" name="{{location.city_name}}" value="{{location.city_id}}" style="height: 12px;" [attr.checked]="(location.isselected) ? 'checked' : null" autocomplete="false">
											<div class="control__indicator"></div>
                                        </label>
                                    </li>
                                </ul>
                                <p class="text-left p10"><a href="<?php echo base_url('business-by-location') ?>">View More Location</a></p>
                            </div>
							<?php $this->load->view('right_add_box'); ?>
                            <?php echo $left_footer; ?>
                        </div>
                        <div class="custom-right-art mian_middle_post_box animated fadeInUp">
                            <div class="">  
                                <div class="right_side_posrt fl"> 
									<div class="tab-add">
										<?php $this->load->view('banner_add'); ?>
									</div>
                                    <div class="common-form userlist-cus">
                                        <div class="job-saved-box">
                                            <h3>Business list</h3>
                                            
                                            <div class="contact-frnd-post">
                                                <!-- AJAX DATA... -->
                                            </div>
                                            <div class="fw" id="loader" style="text-align:center;">
                                                <img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="Loader" />
                                            </div>
                                           
                                            <div class="col-md-1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="hideuserlist" class="right_middle_side_posrt fixed_right_display animated fadeInRightBig"> 
							<?php $this->load->view('right_add_box'); ?>
                        </div>

                    </div>
                </div>
            </div>
        </section>
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
                    <div class="mid-modal-body">
						<div class="mid-modal-body">
							 <div class="left-search-box list-type-bullet">
                                <div class="">
                                    <h3>Top Categories</h3>
                                </div>
                                <ul class="search-listing custom-scroll">
                                    <li ng-repeat="category in businessCategory">
                                        <label class="control control--checkbox">
											<span>{{category.industry_name | capitalize}}
												<span class="pull-right">({{category.count}})</span>
											</span>
                                            <input class="category-filter categorycheckbox" type="checkbox" name="{{category.industry_name}}" value="{{category.industry_id}}" style="height: 12px;" [attr.checked]="(category.isselected) ? 'checked' : null" autocomplete="false">
											<div class="control__indicator"></div>
                                        </label>
                                    </li>
                                </ul>
                                <p class="text-left p10"><a href="<?php echo base_url('business-by-categories') ?>">View More Categories</a></p>
                            </div>
                            <!-- TOP Location -->
                            <div class="left-search-box list-type-bullet">
                                <div class="">
                                    <h3>Top Location</h3>
                                </div>
                                <ul class="search-listing custom-scroll">
                                    <li ng-repeat="location in businessLocation">
                                        <label class="control control--checkbox">
											<span>{{location.city_name | capitalize}}
												<span class="pull-right">({{location.count}})</span>
											</span>
                                            <input class="category-filter locationcheckbox" type="checkbox" name="{{location.city_name}}" value="{{location.city_id}}" style="height: 12px;" [attr.checked]="(location.isselected) ? 'checked' : null" autocomplete="false">
											<div class="control__indicator"></div>
                                        </label>
                                    </li>
                                </ul>
                                <p class="text-left p10"><a href="<?php echo base_url('business-by-location') ?>">View More Location</a></p>
                            </div>
						</div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>
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
        <div class="modal fade message-box" id="bidmodal-2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div id="popup-form">
                                <?php echo form_open_multipart(base_url('business_profile/user_image_insert'), array('id' => 'userimage', 'name' => 'userimage', 'class' => 'clearfix')); ?>
                                <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="profilepic">
                                <input type="hidden" name="hitext" id="hitext" value="6">
                                <div class="popup_previred">
                                    <img id="preview" src="#" alt="your image" /></div>
                                <input type="submit" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                <?php echo form_close(); ?>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
        <script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';

            var bus_bg_main_upload_url = '<?php echo BUS_BG_MAIN_UPLOAD_URL; ?>';
            var bus_profile_thumb_upload_url = '<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>';
            var nobusimage = '<?php echo NOBUSIMAGE; ?>';
            var user_bg_main_upload_url = '<?php echo USER_BG_MAIN_UPLOAD_URL; ?>';
            var user_thumb_upload_url = '<?php echo USER_THUMB_UPLOAD_URL; ?>';
            var message_url = '<?php echo MESSAGE_URL; ?>';

            var app = angular.module('userListApp', ['ui.bootstrap']);
        </script>
        <script src="<?php echo SOCKETSERVER; ?>/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var socket = io.connect("<?php echo SOCKETSERVER; ?>");
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/business-profile/userlist.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" defer="defer" src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
    </body>
</html>