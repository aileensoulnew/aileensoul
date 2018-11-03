<?php $user_id = $this->session->userdata('aileenuser'); ?>
<!DOCTYPE html>
<html lang="en" ng-app="userProfileApp" ng-controller="userProfileController">
    <head>
        <base href="/" >
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">   
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css?ver=' . time()); ?>">
        <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css?ver=' . time()) ?>" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
        
        <link href="<?php echo base_url('8/ninja-slider.css'); ?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <style type="text/css">
            .show-more-container {
                overflow: hidden;
            }
            .show-more-collapse, .show-more-expand {
                text-align: center;
                display: none;
            }

            .show-more-expanded > .show-more-collapse {
                display: inherit;
            }

            .show-more-collapsed > .show-more-expand {
                display: inherit;
            }
            .edit_profile_progress {
                width: 100%;
            }
            .edit_profile_progress {
                float: right;
                width: 100%;
                background-color: #fff;
                border: 1px solid #d9d9d9;
                border-radius: 3px;
                margin: 0 0 10px;
                padding: 10px 0;
            }
            .progre_bar_text {
                padding: 0 17px;
            }
            .circles {
                padding-top: 5px;
                text-align: center;
            }
            .circle-1 {
                width: 175px;
                margin: 0 6px 6px;
                display: inline-block;
                position: relative;
                text-align: center;
                line-height: 1.2;
            }
            .circle-1 canvas {
                vertical-align: middle;
                width: 175px;
                height: 175px;
                border: 1px solid transparent;
                display: #000;
            }
            .circle-1 strong {
                position: absolute;
                top: 54px;
                left: 5px;
                width: 100%;
                text-align: center;
                line-height: 40px;
                font-size: 30px;
            }
            #progress-txt{
                position: absolute;
                top: 94px;
                width: 100%;
                text-align: center;
                left: 0;
            }
        </style>

    <?php $this->load->view('adsense'); ?>
</head>
    <?php $que_cls = "";
    if($this->uri->segment(2) && $this->uri->segment(2) == "questions")
    {
        $que_cls = "questions";
    } ?>
    <body class="main-db <?php echo $que_cls; ?> body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
        <?php if(!$user_id): ?>
        <header>
            <div class="container">
                <div class="row old-no-login">
                    <div class="col-md-4 col-sm-3 col-xs-3 fw-479 left-header">
                        <?php $this->load->view('main_logo'); ?>
                    </div>
                    <div class="col-md-8 col-sm-9 col-xs-9 fw-479 right-header">
                        <ul class="nav navbar-nav navbar-right test-cus drop-down">
                            <?php $this->load->view('profile-dropdown'); ?>
                            <li class="hidden-991"><a href="<?php echo base_url('login'); ?>" class="btn2" target="_self">Login</a></li>
                            <li class="hidden-991"><a href="<?php echo base_url('registration'); ?>" class="btn3" target="_self">Create an account</a></li>
                            <li class="mob-bar-li">
                                <span class="mob-right-bar">
                                    <?php $this->load->view('mobile_right_bar'); ?>
                                </span>
                            </li>
                        
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <?php else:
            echo $header_profile;
            endif; ?>
        <?php echo $header; ?>
        <div ng-view></div>
        <?php echo $login_footer; ?>
        </div>
        <!--PROFILE PIC MODEL START-->
        <div class="modal fade message-box" id="bidmodal-2" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>      
                    <div class="modal-body">
                        <div class="mes">
                            <div id="popup-form">
                                <div class="fw" id="profi_loader"  style="display:none; text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/></div>
                                <form id ="userimage" name ="userimage" class ="clearfix" enctype="multipart/form-data" method="post">
                                    <div class="fw">
                                        <input type="file" name="profilepic" accept="image/gif, image/jpeg, image/png" id="upload-one" >
                                    </div>

                                    <div class="col-md-7 text-center">
                                        <div id="upload-demo-one" style="display:none; width:350px"></div>
                                    </div>
                                    <input type="submit" class="upload-result-one btn1" name="profilepicsubmit" id="profilepicsubmit" value="Save" >
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- No Signup User Modal Start  -->
        <div class="modal fade message-box biderror" id="regmodal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content pop-content-cus'>
                                <h2>Never miss out any opportunities, news, and updates.</h2>
                                Join Now! 
                                <p class='poppup-btns'>
                                    <a class='btn1' href="<?php echo base_url(); ?>login" target="_self">Login</a> or 
                                    <a class='btn1' href="<?php echo base_url(); ?>registration" target="_self">Register</a>
                                </p>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- No Signup User Modal Close  -->
        <div class="modal fade message-box custom-popup" id="other-user-profile-img" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lm">
                <button type="button" class="modal-close" data-dismiss="modal"><img src="<?php echo base_url('assets/img/left-arrow-popup.png') ?>"></button> 
                <div class="modal-content">
                         
                    <div class="modal-body">
                        <div class="mes">
                            <?php if($userdata['user_image'] != ""){ ?>
                                <img src="<?php echo USER_MAIN_UPLOAD_URL . $userdata['user_image']; ?>">
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box custom-popup" id="view-profile-img" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lm">
                <button type="button" class="modal-close" data-dismiss="modal"><img src="<?php echo base_url('assets/img/left-arrow-popup.png') ?>"></button> 
                <div class="modal-content">
                         
                    <div class="modal-body">
                        <div class="mes">
                            <?php if ($userdata['user_image'] != ''){ ?>
                                <img src="<?php echo USER_MAIN_UPLOAD_URL . $userdata['user_image']; ?>">
                            <?php } else if (strtoupper($userdata['user_gender']) == "M"){ ?>
                                <img src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                            <?php } else{ ?>
                                <img src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box custom-popup" id="view-cover-img" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lm">
                <button type="button" class="modal-close" data-dismiss="modal"><img src="<?php echo base_url('assets/img/left-arrow-popup.png') ?>"></button> 
                <div class="modal-content">
                         
                    <div class="modal-body">
                        <div class="mes">
                            <?php if($userdata['profile_background'] != ""){ ?>
                            <img src = "<?php echo USER_BG_MAIN_UPLOAD_URL . $userdata['profile_background']; ?>" name="image_src" id="image_src" alt="<?php echo $userdata['profile_background']; ?>"/>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--PROFILE PIC MODEL END-->
        <div class="modal fade message-box" id="remove-contact" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div class="pop_content">Do you want to delete all message?<div class="model_ok_cancel"><a class="okbtn" ng-click="delete_all_history(m_a_d_message_to_profile_id)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade message-box" id="remove-contact-conform" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div class="pop_content">Do you want to remove this contact?<div class="model_ok_cancel"><a class="okbtn" ng-click="remove_contact('<?php echo $contact_id; ?>','cancel','<?php echo $to_id; ?>')" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        $session_user = $this->session->userdata('aileenuser');        
        if(empty($session_user))        
        {            
            $this->load->view('mobile_side_slide');
        }?>
        <script src="<?php echo base_url('assets/js/croppie.js'); ?>"></script>  
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script src="<?php echo base_url('8/ninja-slider.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/webpage/job/progressbar_common.js?ver=' . time()); ?>"></script> -->
        <script>
            var base_url = '<?php echo base_url(); ?>';
            //var user_slug = '<?php echo $this->uri->segment(2); ?>';
            var user_slug = '<?php echo $this->uri->segment(1); ?>';//Pratik
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var item = '<?php echo $this->uri->segment(1); ?>';
            var live_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
            //var segment2 = '<?php echo $this->uri->segment(2); ?>';
            var segment2 = '<?php echo $this->uri->segment(1); ?>';//Pratik
            var user_data_slug = '<?php echo $userdata['user_slug']; ?>';
            var to_id = '<?php echo $to_id; ?>';
            var contact_value = '<?php echo $contact_value; ?>';
            var contact_status = '<?php echo $contact_status; ?>';
            var contact_id = '<?php echo $contact_id; ?>';
            var follow_value = '<?php echo $follow_value; ?>';
            var follow_status = '<?php echo $follow_status; ?>';
            var follow_id = '<?php echo $follow_id; ?>';
            var is_userPostCount = '<?php echo $is_userPostCount; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var user_experience_upload_url = '<?php echo USER_EXPERIENCE_UPLOAD_URL; ?>';
            var user_education_upload_url = '<?php echo USER_EDUCATION_UPLOAD_URL; ?>';
            var user_project_upload_url = '<?php echo USER_PROJECT_UPLOAD_URL; ?>';
            var user_patent_upload_url = '<?php echo USER_PATENT_UPLOAD_URL; ?>';
            var user_research_upload_url = '<?php echo USER_RESEARCH_UPLOAD_URL; ?>';
            var user_idol_upload_url = '<?php echo USER_IDOL_UPLOAD_URL; ?>';
            var user_publication_upload_url = '<?php echo USER_PUBLICATION_UPLOAD_URL; ?>';
            var user_award_upload_url = '<?php echo USER_AWARD_UPLOAD_URL; ?>';
            var user_activity_upload_url = '<?php echo USER_ACTIVITY_UPLOAD_URL; ?>';
            var user_addicourse_upload_url = '<?php echo USER_ADDICOURSE_UPLOAD_URL; ?>';
            var app = angular.module("userProfileApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
            // var count_profile_value = '';
            // var count_profile = '';
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
        <script>
    		/*var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
    			showRight = document.getElementById( 'showRight' ),
    			body = document.body;

    		showRight.onclick = function() {
    			classie.toggle( this, 'active' );
    			classie.toggle( menuRight, 'cbp-spmenu-open' );
    			disableOther( 'showRight' );
    		};
    	
    		function disableOther( button ) {
    			
    			if( button !== 'showRight' ) {
    				classie.toggle( showRight, 'disabled' );
    			}
    		}*/
    		
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
    	
            jQuery(document).ready(function($) {
                $("li.user-id label").click(function(e){
                    $(".dropdown").removeClass("open");
                    $(this).next('ul.dropdown-menu').toggle();
                    e.stopPropagation();
                });
                $(".right-header ul li.dropdown a").click(function(e){                          
                    $('.right-header ul.dropdown-menu').hide();
                });
            });
        </script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/masonry/3.2.2/masonry.pkgd.min.js'></script>

    </body>
</html>