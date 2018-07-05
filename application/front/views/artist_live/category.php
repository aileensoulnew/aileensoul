<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url();?>">
        <title><?php echo $title; ?></title>
        <meta charset="utf-8">
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">  
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <?php
           if($isartistactivate == true && $artist_isregister){
        ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/css/header.css?ver=' . time()) ?>">
        <?php } ?>

        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="profile-main-page bus-by-cus">
        <?php //$this->load->view('page_loader'); ?>
        <div id="main_page_load">
            <?php $page = (isset($page)) ? $page : ''; ?>
            <?php $session_user_id = $this->session->userdata('aileenuser'); ?>
            <?php
                if ($ismainregister == false) {
                    // $this->load->view('artist_live/login_header');
                }else if($isartistactivate == true && $artist_isregister){
                    echo $artistic_header2;
                }else{
                    echo $header_profile;
                }
            ?>
            <?php
               if($ismainregister == false ){
            ?>
                <div class="middle-section middle-section-banner new-ld-page">
            <?php echo $search_banner; 
                } else if($isartistactivate == true && $artist_isregister == true) { ?>
                <div class="middle-section">
            <?php } else { ?>
                <div class="middle-section middle-section-banner">
            <?php echo $search_banner;  
            } ?>
                    <div class="container pt20 mobp0 mobmt15">
                        <div class="custom-user-list">
                            <div class="list-box-custom border-none">
                                <div class="">
                                    <div class="">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="<?php echo base_url(); ?>artist/category"><span class="hidden-xs">Artist by</span> Categories</a></li>
                                            <li><a href="<?php echo base_url(); ?>artist/location"><span class="hidden-xs">Artist by</span> Location</a></li>
                                            <li><a href="<?php echo base_url(); ?>artist">Artist</a></li>
                                        </ul>
                                    </div>
                                    <div class="all-detail-box">
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="artist-categories">
                                                <div class="cat-box">
                                                    <ul><?php
                                                        if(isset($artistAllCategory) && !empty($artistAllCategory)):
                                                            foreach($artistAllCategory as $_artistAllCategory):?>
                                                        <li>
                                                            <a href="<?php echo artist_category.$_artistAllCategory['category_slug']; ?>" target="_self">
                                                                <div class="cus-cat-middle">
                                                                    <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                                                    <p>
                                                                        <?php echo ucwords($_artistAllCategory['art_category']); ?>
                                                                    </p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <?php
                                                            endforeach;
                                                        endif; ?>
                                                        <!-- <li>
                                                            <a href="<?php //echo artist_other_category; ?>" target="_self">
                                                                <div class="cus-cat-middle">
                                                                    <img src="<?php //echo base_url('assets/n-images/cat-1.png') ?>">
                                                                    <p>Other</p>
                                                                </div>
                                                            </a>
                                                        </li> -->
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
                            <?php echo $right_profile_view; ?>
                            <!-- <div class="add-box">
                                <img src="<?php //echo base_url('assets/img/add.jpg') ?>">
                            </div> -->
                        </div>
                    </div>
                </div>  
        <?php echo $login_footer; ?>    
        </div>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
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
            var app = angular.module('', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);
            var category_url = base_url + "artist_live/category";
        </script>               
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/artist/artistic_common.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/searchArtist.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/artist-live/category.js?ver=' . time()) ?>"></script>
        <!-- <script src="<?php //echo base_url('assets/js/webpage/artist-live/viewmoreartist.js?ver=' . time()) ?>"></script> -->
    </body>
</html>