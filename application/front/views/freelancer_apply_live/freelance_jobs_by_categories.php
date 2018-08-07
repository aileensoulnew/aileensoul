<!DOCTYPE html>
<?php $user_id = $this->session->userdata('aileenuser'); 
//echo $user_id."-------".$job_deactive."----------".$this->job_profile_set;exit;?>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>">        
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
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
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <style>
          .ui-autocomplete {
            max-height: 100px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
          }
          /* IE 6 doesn't support max-height
           * we use height instead, but this forces the menu to always be this tall
           */
          * html .ui-autocomplete {
            height: 100px;
          }
          </style>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page">    
        <?php
        if($user_id != ""  && $this->freelance_apply_profile_set == 1){
            echo $header_inner_profile;
            echo $freelancer_post_header2;
        }
        else if($user_id != "" && $this->freelance_apply_profile_set == 0)
        {
             echo $header_inner_profile;
        }

        if($user_id == "" || $this->freelance_apply_profile_set == 0)
        {
            $headercls = "";
            if($user_id == "")
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
            <?php 
        } ?>
            <div class="container pt20 mobp0 mobmt15">
				<div class="tab-add-991">
					<?php $this->load->view('banner_add'); ?>
				</div>
                <div class="custom-user-list">
                    <div class="list-box-custom border-none cus-job">
                        <div class="">
                            <div class="">
                                <ul class="nav nav-tabs">
									<li><a href="<?php echo base_url(); ?>freelance-jobs-by-fields"><span class="hidden-xs">Freelance Job by</span> Fields</a></li>
                                    <li class="active"><a href="javascript:void(0);"><span class="hidden-xs">Freelance Job by</span> Categories</a></li>
                                    
                                </ul>
                            </div>
                            <div class="all-detail-box">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="job-category">
                                        <div class="location-box">
                                            <ul>
                                                <?php
                                                if(isset($jobByCategory) && !empty($jobByCategory)):
                                                    foreach($jobByCategory as $_jobByCategory): ?>
                                                        <li>
                                                            <a href="<?php echo base_url().'freelance-jobs/'.$_jobByCategory['skill_slug']; ?>" target="_self">
                                                                <div class="cus-cat-middle">
                                                                <img src="<?php echo SKILLS_IMG_PATH.$_jobByCategory['skill_image']; ?>">
                                                                <p><?php echo ucwords($_jobByCategory['skill']); ?></p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                <?php
                                                    endforeach;
                                                endif;?>
                                            </ul>
                                            <?php echo $links; ?>
                                        </div>
                                    </div>                        
                                </div>
                            </div>
							<div class="banner-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                        </div>
                                    
                    </div>
                </div>
                <div class="right-add">
					<?php $this->load->view('right_add_box'); ?>
                    
                </div>
            </div>
			<?php echo $login_footer; ?>
        </div>
        <?php if($user_id != "" && $this->freelance_apply_profile_set == 0)
        { ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <?php } ?>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var q = '';
            var l = '';
            var w = '';
            var app = angular.module('', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);

            $(document).ready(function($) {
                /*$("li.user-id label").click(function(e){
                    $(".dropdown").removeClass("open");
                    $(this).next('ul.dropdown-menu').toggle();
                    e.stopPropagation();
                });*/
                $("li.user-id a").click(function(e){
                    $(".dropdown").removeClass("open");
                    $(this).next('ul.dropdown-menu').toggle();
                    e.stopPropagation();
                });
                /*$(".right-header ul li.dropdown a").click(function(e){
                    $('.right-header ul.dropdown-menu').hide();
                });*/
            });
            /*$(document).click(function(){
                $('.right-header ul.dropdown-menu').hide();
            });*/
            $(document).ready(function () {
                $('html,body').animate({scrollTop: 300}, 500);
            });
        </script>
        <?php if($user_id != "")
        { ?>
        <script>
            $(document).click(function(){
                $('.right-header ul.dropdown-menu').hide();
            });
        </script>
        <?php } ?>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>        
        <!-- <script src="<?php //echo base_url('assets/js/webpage/freelancer-apply/view_more_freelance_apply.js?ver=' . time()) ?>"></script> -->
    </body>
</html>