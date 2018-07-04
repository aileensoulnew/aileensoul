<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url();?>">
        <title><?php echo $title; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
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
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page bus-by-cus">
        <?php //$this->load->view('page_loader'); ?>
        <div id="main_page_load">
            <?php 
                if($ismainregister == false){
                    // $this->load->view('business_live/login_header');
                }else if($isbusiness_register == true && $isbusiness_deactive == false){
                    echo $business_header2;
                }else{
                    echo $header_profile; 
                }
            ?>

            <?php
               if($ismainregister == false){
            ?>
                <div class="middle-section middle-section-banner new-ld-page">
            <?php //echo $search_banner; 
                } else if(!$isbusiness_deactive && $isbusiness_register == true) { ?>
                <div class="middle-section">
            <?php } else { ?>
                <div class="middle-section middle-section-banner">
            <?php //echo $search_banner;  
            } ?>

                <?php if($business_profile_set == 0 && $business_profile_set == '0'){ 
                        echo $search_banner; 
                    } 
                ?>
                <!-- NEW HTML -->
                <div class="container pt20 mobp0 mobmt15">
                    <div class="custom-user-list">
                        <div class="list-box-custom border-none">
                            <div class="">
                                <div class="">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="<?php echo base_url() ?>business-by-categories">
                                                <span class="hidden-xs">Business by </span> Categories
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() ?>business-by-location">
                                                <span class="hidden-xs">Business by</span> Location
                                            </a>
                                        </li> 
                                        <li>
                                            <a href="<?php echo base_url() ?>business">
                                                Businesses
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="all-detail-box">
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="business-categories">
                                            <div class="cat-box">
                                                <ul><?php
                                                if(isset($businessAllCategory) && !empty($businessAllCategory)):
                                                    foreach($businessAllCategory as $_businessAllCategory):?>
                                                    <li>
                                                        <a href="<?php echo base_url().$_businessAllCategory['industry_slug'].'-business'; ?>" target="_self">
                                                            <div class="cus-cat-middle">
                                                                <img src="<?php echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>" alt="<?php echo $_businessAllCategory['industry_name']; ?>">
                                                                <p><?php echo $_businessAllCategory['industry_name']; ?></p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <?php
                                                    endforeach;
                                                endif; ?>
                                                </ul>
                                            </div>
                                            <?php echo $links; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="right-part">
                        <!-- <div class="add-box">
                            <img src="<?php //echo base_url('assets/img/add.jpg?ver=' . time()) ?>" alt="{{category.industry_name}}">
                        </div> -->
                        <?php echo $right_profile_view; ?>
                    </div>
                </div>
            </div>
            <?php echo $login_footer; ?>
        </div>
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver='.time()); ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script> -->
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
                var app = angular.module('', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);
        </script>               
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/business-live/searchBusiness.js?ver=' . time()) ?>"></script>
        <script src="<?php //echo base_url('assets/js/webpage/business-live/viewmorebusiness.js?ver=' . time()) ?>"></script>
        <?php 
            if($isbusiness_register == true && $isbusiness_deactive == false){
        ?>
            <script src="<?php echo base_url('assets/js/webpage/business-profile/common.js?ver=' . time()) ?>"></script>
        <?php
            }
        ?>
    </body>
</html>