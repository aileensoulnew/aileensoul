<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url();?>">
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="canonical" href="<?php echo current_url(); ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">   
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <?php if($isbusiness_register == true && !$isbusiness_deactive){ ?>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/header.css?ver=' . time()) ?>">
        <?php } ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page bus-by-cus two-hd">
        <?php //$this->load->view('page_loader'); ?>
        <div id="main_page_load">
            <?php 
                if($ismainregister == false){                    
                }else if($isbusiness_register == true && $isbusiness_deactive == false){
                    echo $business_header2;
                }else{
                    echo $header_profile; 
                }
            ?>

            <?php
               if($ismainregister == false){
            ?>
                <div class="main-section middle-section-banner new-ld-page">
            <?php //echo $search_banner; 
                } else if(!$isbusiness_deactive && $isbusiness_register == true) { ?>
                <div class="main-section">
            <?php } else { ?>
                <div class="main-section middle-section-banner">
            <?php //echo $search_banner;  
            } ?>

                <?php if($business_profile_set == 0 && $business_profile_set == '0'){ 
                        echo $search_banner; 
                    } 
                ?>
                <!-- NEW HTML -->
                <div class="container mobp0 mobmt15">
					<div class="tab-add-991">
						<?php $this->load->view('banner_add'); ?>
					</div>
                    <div class="custom-user-list">
                        <div class="list-box-custom border-none">
                            <div class="">
                                <div class="">
                                    <ul class="nav nav-tabs">
                                        <li>
                                            <a href="<?php echo base_url() ?>business-by-categories">
                                                <span class="hidden-xs">Business by </span> Categories
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() ?>business-by-location">
                                                <span class="hidden-xs">Business by</span> Location
                                            </a>
                                        </li> 
                                        <li class="active">
                                            <a href="javascript:void(0);">
                                               <h1>Businesses</h1>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="all-jobs-list">
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="job-category">
                                            <div class="location-box">
                                                <ul class="art-bus-cus" >
                                                    <?php
                                                    if(isset($businessByBusiness) && !empty($businessByBusiness)):
                                                        foreach($businessByBusiness as $key=>$allJobVal):?>
                                                    <li ng-repeat="(key, allJobVal) in businessByBusiness">
                                                        <h4><?php echo $key; ?></h4>
                                                        <ul class="art-bus-all">
                                                            <?php
                                                            foreach($allJobVal as $byJobKey=>$byJobVal):?>
                                                            <li ng-repeat="(byJobKey, byJobVal) in allJobVal">
                                                                <a href="<?php echo base_url().$byJobVal['slug']; ?>" target="_self"><?php echo $byJobVal['name']; ?></a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                        endforeach;
                                                    endif; ?>
                                                </ul>
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
            </div>
            <?php echo $login_footer; ?>
            <?php $this->load->view('mobile_side_slide'); ?>
        </div>
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script> -->
        <script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
        <script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-sanitize-1.6.4.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script>
                var base_url = '<?php echo base_url(); ?>';
                var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                var title = '<?php echo $title; ?>';
                var header_all_profile = '<?php echo $header_all_profile; ?>';
                var q = '';
                var l = '';
                var app = angular.module('', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);
        </script>
        <script src="<?php echo SOCKETSERVER; ?>/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var socket = io.connect("<?php echo SOCKETSERVER; ?>");
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/searchBusiness.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
        <?php 
            if($isbusiness_register == true && $isbusiness_deactive == false){
        ?>
            <script src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()) ?>"></script>
        <?php
            }
        if($this->session->userdata('aileenuser') == ""):
        ?>
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
                        "@id": "<?php echo base_url(); ?>business-search",
                        "name": "Business"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item":
                    {
                        "@id": "<?php echo current_url(); ?>",
                        "name": "All Business"                
                    }
                }
            ]
        }
        </script>
        <?php endif; ?>
    </body>
</html>