<!DOCTYPE html>
<html lang="en" ng-app="hashtagDetailApp" ng-controller="defaultController">
    <head>
        <base href="/" >
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="dns-prefetch" href="https://www.aileensoul.com/">
        <link rel="canonical" href="<?php echo current_url(); ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">

        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/developer.css') ?>">
    </head>
    <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <body class="one-hd hashtag-detail-page">
        <?php echo $header_profile; ?>
        <div class="hash-header-mob">
            <div class="container">
                <div class="hash-head-left">
                    <div class="hash-back">
                        <a href="<?php echo base_url('hashtags') ?>" target="_self">
                            <img src="<?php echo base_url('assets/n-images/hash-arrow-back.png'); ?>">
                        </a>
                    </div>
                    <div class="hash-head-detail">
                        <h4><?php echo '#'.$hashtag_detail['hashtag']; ?></h4>
                        <p id="hashtag-follow-count"><?php echo $hashtag_detail['hashtag_follower_count'] ?> followers</p>
                    </div>
                </div>
                <div class="hash-head-right">
                    <?php 
                    if($hashtag_detail['hashtag_follow_status'] == 0){ ?>
                        <a href="javascript:void(0);" class="hash-btn-mob" ng-click="follow_hashtag(<?php echo $hashtag_detail['id']; ?>);">Follow</a>
                    <?php 
                    }                                            
                    if($hashtag_detail['hashtag_follow_status'] == 1){ ?>
                        <a href="javascript:void(0);" class="hash-btn-mob" ng-click="unfollow_hashtag(<?php echo $hashtag_detail['id']; ?>);">Following</a>
                    <?php 
                    } ?>
                </div>
            </div>
        </div>
        <div class="hash-hdr-move">
        </div>
        <div class="main-section op-main-page">
            <div class="container mobp0">
                <div class="big-left">
                    <div id="" class="left-section left-fixed-cus">
                        <div class="fw">
                            <div class="box-border">
                                <div class="hash-detail-box">
                                    <div class="fw">
                                        <div class="hash-detail-left">
                                            <?php echo '#'.strtoupper(substr($hashtag_detail['hashtag'], 0,1)); ?>
                                        </div>
                                        <div class="hash-detail">
                                            <h4><?php echo '#'.$hashtag_detail['hashtag']; ?></h4>
                                            <p id="hashtag-follow-count"><?php echo $hashtag_detail['hashtag_follower_count'] ?> followers</p>
                                            <div id="hashtag-follow-btn">
                                                <?php 
                                                if($hashtag_detail['hashtag_follow_status'] == 0){ ?>
                                                    <a href="javascript:void(0);" class="btn-new-1" ng-click="follow_hashtag(<?php echo $hashtag_detail['id']; ?>);">Follow</a>
                                                <?php 
                                                }                                            
                                                if($hashtag_detail['hashtag_follow_status'] == 1){ ?>
                                                    <a href="javascript:void(0);" class="btn-new-1" ng-click="unfollow_hashtag(<?php echo $hashtag_detail['id']; ?>);">Following</a>
                                                <?php 
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(isset($hashtag_detail['hashtag_recent_follower']) && !empty($hashtag_detail['hashtag_recent_follower'])): ?>
                                        <div class="hash-detail-bottom">
                                        <p>Recent Followers</p>
                                        <ul>
                                            <?php foreach ($hashtag_detail['hashtag_recent_follower'] as $key => $value) {
                                                if($value['user_image'] != "")
                                                {
                                                    $user_img = USER_THUMB_UPLOAD_URL . $value['user_image'];
                                                }
                                                else
                                                {
                                                    if($value['user_gender']  == 'M')
                                                    {
                                                        $user_img = base_url('assets/img/man-user.jpg');
                                                    }

                                                    if($value['user_gender']  == 'F')
                                                    {
                                                        $user_img = base_url('assets/img/female-user.jpg');
                                                    }
                                                }
                                                ?>
                                                <li><a href="<?php echo base_url().$value['user_slug']; ?>" title="<?php echo $value['first_name'].' '.$value['last_name']; ?>"><img src="<?php echo $user_img; ?>" alt="<?php echo $value['first_name'].' '.$value['last_name']; ?>"></a></li>
                                            <?php
                                            } ?>
                                        </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <?php echo $left_footer; ?>                        
                        </div>
                    </div>

                    <div class="middle-section">
                        <div class="hash-middle-fix" id="hash-hdr-move">
                            <div class="box-border">
                               <div class="hash-detail-top table-responsive content">
                                    <table class="table">
                                        <tr>
                                            <td ng-class="active_pg == 1 ? 'active' : ''"><a href="<?php echo base_url().'hashtag/'.$hashtag_detail['hashtag']; ?>">Top</a></td>
                                            <td ng-class="active_pg == 2 ? 'active' : ''"><a href="<?php echo base_url().'hashtag/'.$hashtag_detail['hashtag'].'/recent'; ?>">Recent</a></td>
                                            <td ng-class="active_pg == 3 ? 'active' : ''"><a href="<?php echo base_url().'hashtag/'.$hashtag_detail['hashtag'].'/opportunities'; ?>">Opportunities</a></td>
                                            <td ng-class="active_pg == 4 ? 'active' : ''"><a href="<?php echo base_url().'hashtag/'.$hashtag_detail['hashtag'].'/articles'; ?>">Articles</a></td>
                                            <td ng-class="active_pg == 5 ? 'active' : ''"><a href="<?php echo base_url().'hashtag/'.$hashtag_detail['hashtag'].'/questions'; ?>">Questions</a></td>
                                            <td ng-class="active_pg == 6 ? 'active' : ''"><a href="<?php echo base_url().'hashtag/'.$hashtag_detail['hashtag'].'/people'; ?>">People</a></td>
                                        </tr>
                                    </table>
                               </div>
                            </div>
                        </div>
                        <div class="hash-middle-pd">                        
                            <div ng-view></div>
                        </div>
                    </div>
                </div>
                <div class="right-section right-fixed-cus">
                    <?php $this->load->view('right_add_box'); ?>
                </div>
            </div>
        </div>

        <!-- <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script> -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
        <script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-sanitize-1.6.4.min.js?ver=' . time()); ?>"></script>

        <script type="text/javascript">
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';

            var bus_bg_main_upload_url = '<?php echo BUS_BG_MAIN_UPLOAD_URL; ?>';
            var bus_profile_thumb_upload_url = '<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>';
            var nobusimage = '<?php echo NOBUSIMAGE; ?>';
            var user_bg_main_upload_url = '<?php echo USER_BG_MAIN_UPLOAD_URL; ?>';
            var user_thumb_upload_url = '<?php echo USER_THUMB_UPLOAD_URL; ?>';
            var message_url = '<?php echo MESSAGE_URL; ?>';
            var hashtag_id = '<?php echo $hashtag_detail['id']; ?>';

            var app = angular.module("hashtagDetailApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','ngValidate']);
        </script>

        <script src="<?php echo SOCKETSERVER; ?>/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var socket = io.connect("<?php echo SOCKETSERVER; ?>");
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/hashtag_detail.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js') ?>"></script>
        <script>
            jQuery(document).ready(function ($) {
                var owl = $('.owl-carousel');
                owl.on('initialize.owl.carousel initialized.owl.carousel ' +
                        'initialize.owl.carousel initialize.owl.carousel ' +
                        'resize.owl.carousel resized.owl.carousel ' +
                        'refresh.owl.carousel refreshed.owl.carousel ' +
                        'update.owl.carousel updated.owl.carousel ' +
                        'drag.owl.carousel dragged.owl.carousel ' +
                        'translate.owl.carousel translated.owl.carousel ' +
                        'to.owl.carousel changed.owl.carousel',
                        function (e) {
                            $('.' + e.type)
                                    .removeClass('secondary')
                                    .addClass('success');
                            window.setTimeout(function () {
                                $('.' + e.type)
                                        .removeClass('success')
                                        .addClass('secondary');
                            }, 500);
                        });
                owl.owlCarousel({
                    loop: true,
                    nav: true,
                    lazyLoad: true,
                    margin: 0,
                    video: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 1
                        },
                        960: {
                            items: 1,
                        },
                        1200: {
                            items: 1
                        }
                    }
                });
            });

            // mcustom scroll bar
            (function ($) {
                $(window).on("load", function () {

                    $(".custom-scroll").mCustomScrollbar({
                        autoHideScrollbar: true,
                        theme: "minimal"
                    });

                });
            })(jQuery);
            
            $('#content').on( 'change keyup keydown paste cut', 'textarea', function (){
                $(this).height(0).height(this.scrollHeight);
            }).find( 'textarea' ).change();
        </script>    
        <script>
            $(function() {

            var $window = $(window);
            var lastScrollTop = $window.scrollTop();
            var wasScrollingDown = true;

            var $sidebar = $("#left-fixed");
            if ($sidebar.length > 0) {

            var initialSidebarTop = $sidebar.position().top;

            $window.scroll(function(event) {

            var windowHeight = $window.height();
            var sidebarHeight = $sidebar.outerHeight();

            var scrollTop = $window.scrollTop();
            var scrollBottom = scrollTop + windowHeight;

            var sidebarTop = $sidebar.position().top;
            var sidebarBottom = sidebarTop + sidebarHeight;

            var heightDelta = Math.abs(windowHeight - sidebarHeight);
            var scrollDelta = lastScrollTop - scrollTop;

            var isScrollingDown = (scrollTop > lastScrollTop);
            var isWindowLarger = (windowHeight > sidebarHeight);

            if ((isWindowLarger && scrollTop > initialSidebarTop) || (!isWindowLarger && scrollTop > initialSidebarTop + heightDelta)) {
                $sidebar.addClass('fixed-cus');
            } else if (!isScrollingDown && scrollTop <= initialSidebarTop) {
                $sidebar.removeClass('fixed-cus');
            }

            var dragBottomDown = (sidebarBottom <= scrollBottom && isScrollingDown);
            var dragTopUp = (sidebarTop >= scrollTop && !isScrollingDown);

            if (dragBottomDown) {
                if (isWindowLarger) {
                    $sidebar.css('top', 0);
                } else {
                    $sidebar.css('top', -heightDelta );
                }
            } else if (dragTopUp) {
                $sidebar.css('top', 0);
            } else if ($sidebar.hasClass('fixed-cus')) {
                var currentTop = parseInt($sidebar.css('top'), 10);
                
                var minTop = -heightDelta;
                //var scrolledTop = currentTop + scrollDelta;
                
                //var isPageAtBottom = (scrollTop + windowHeight >= $(document).height());
                //var newTop = (isPageAtBottom) ? minTop : scrolledTop;
                
                // $sidebar.css('top', newTop);
            }

            lastScrollTop = scrollTop;
            wasScrollingDown = isScrollingDown;
            });
            }
            });
        </script>
        <script>
            $(function() {

            var $window = $(window);
            var lastScrollTop = $window.scrollTop();
            var wasScrollingDown = true;

            var $sidebar = $("#right-fixed");
            if ($sidebar.length > 0) {

            var initialSidebarTop = $sidebar.position().top;

            $window.scroll(function(event) {

            var windowHeight = $window.height();
            var sidebarHeight = $sidebar.outerHeight();

            var scrollTop = $window.scrollTop();
            var scrollBottom = scrollTop + windowHeight;

            var sidebarTop = $sidebar.position().top;
            var sidebarBottom = sidebarTop + sidebarHeight;

            var heightDelta = Math.abs(windowHeight - sidebarHeight);
            var scrollDelta = lastScrollTop - scrollTop;

            var isScrollingDown = (scrollTop > lastScrollTop);
            var isWindowLarger = (windowHeight > sidebarHeight);

            if ((isWindowLarger && scrollTop > initialSidebarTop) || (!isWindowLarger && scrollTop > initialSidebarTop + heightDelta)) {
                $sidebar.addClass('fixed-cus1');
            } else if (!isScrollingDown && scrollTop <= initialSidebarTop) {
                $sidebar.removeClass('fixed-cus1');
            }

            var dragBottomDown = (sidebarBottom <= scrollBottom && isScrollingDown);
            var dragTopUp = (sidebarTop >= scrollTop && !isScrollingDown);

            if (dragBottomDown) {
                if (isWindowLarger) {
                    $sidebar.css('top', 0);
                } else {
                    $sidebar.css('top', -heightDelta );
                }
            } else if (dragTopUp) {
                $sidebar.css('top', 0);
            } else if ($sidebar.hasClass('fixed-cus1')) {
                var currentTop = parseInt($sidebar.css('top'), 10);
                
                var minTop = -heightDelta;
                //var scrolledTop = currentTop + scrollDelta;
                
               // var isPageAtBottom = (scrollTop + windowHeight >= $(document).height());
               // var newTop = (isPageAtBottom) ? minTop : scrolledTop;
                
               // $sidebar.css('top', newTop);
            }

            lastScrollTop = scrollTop;
            wasScrollingDown = isScrollingDown;
            });
            }
            });
        </script>
        <script>
            $(document).ready(function () {
                if (screen.width <= 1279) {
                    $("#business-move").appendTo($(".business-move"));
                    $("#artist-move").appendTo($(".artist-move"));
                    
                }
                if (screen.width < 768) {
                    $("#edit-profile-move").appendTo($(".edit-custom-move"));
                }
            });
            $(document).ready(function () {
                if (screen.width <= 991) {
                    $("#hash-hdr-move").appendTo($(".hash-hdr-move"));
                    
                }            
            });
            $(document).ready(function() {
              $("#your-name").attr("placeholder", "Your Name");  
            });
            $(document).ready(function () {
                if (screen.width <= 479) {
                    $("#your-name").attr("placeholder", "Mobile Your Name");
                    
                }
            });
        </script>
    </body>
</html>