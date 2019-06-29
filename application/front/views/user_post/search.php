<!DOCTYPE html>
<html lang="en" ng-app="searchApp" ng-controller="SearchDefaultController">
    <head>
        <title ng-bind="meta_title">Search<?php echo TITLEPOSTFIX; ?></title>
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="/">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>"> 
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/select2.min.css') ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <style type="text/css">
            .mejs__overlay-button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__overlay-loading-bg-img {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
            .mejs__button > button {
                background-image: url("https://www.aileensoul.com/assets/as-videoplayer/build/mejs-controls.svg");
            }
        </style>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="two-hd search-new-page">
        <?php echo $header_profile ?>
        <div class="filter-sub-header">
            <div class="sub-header">
                <div class="container">
                    <nav class="search-tab">
                        <div class="nav nav-tabs nav-fill table-responsive content" id="nav-tab" role="tablist">
                            <table class="sub-menu table">
                                <tr>
                                    <td>
                                        <a class="nav-item nav-link" ng-class="active_tab == '1' ? 'active' : ''" id="search-all-tab" href="<?php echo base_url('search').'?q='.$search_keyword; ?>">All <span>{{total_count}}</span></a>
                                    </td>
                                    <td>
                                        <a class="nav-item nav-link" ng-class="active_tab == '2' ? 'active' : ''" id="search-opp-tab" href="<?php echo base_url('search/opportunity').'?q='.$search_keyword; ?>">Opportunities(Jobs) <span>{{opp_count}}</span></a>
                                    </td>
                                    <td>
                                        <a class="nav-item nav-link" ng-class="active_tab == '3' ? 'active' : ''" id="search-opp-tab" id="search-people-tab" href="<?php echo base_url('search/people').'?q='.$search_keyword; ?>">People <span>{{people_count}}</span></a>
                                    </td>
                                    <td>
                                        <a class="nav-item nav-link" ng-class="active_tab == '4' ? 'active' : ''" id="search-opp-tab" id="search-post-tab" href="<?php echo base_url('search/post').'?q='.$search_keyword; ?>">Posts <span>{{simple_count}}</span></a>
                                    </td>
                                    <td>
                                        <a class="nav-item nav-link" ng-class="active_tab == '5' ? 'active' : ''" id="search-opp-tab" id="search-bus-tab" href="<?php echo base_url('search/business').'?q='.$search_keyword; ?>">Businesses <span>{{business_count}}</span></a>
                                    </td>
                                    <td>
                                        <a class="nav-item nav-link" ng-class="active_tab == '6' ? 'active' : ''" id="search-opp-tab" id="search-article-tab" href="<?php echo base_url('search/article').'?q='.$search_keyword; ?>">Articles <span>{{article_count}}</span></a>
                                    </td>
                                    <td>
                                        <a class="nav-item nav-link" ng-class="active_tab == '7' ? 'active' : ''" id="search-opp-tab" id="search-que-tab" href="<?php echo base_url('search/question').'?q='.$search_keyword; ?>">Questions <span>{{question_count}}</span></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        

        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
            <div class="main-section">
                <div class="container mobp0">                    
					<div class="big-left">                        
                        <div ng-view></div>
                    </div>
					<div class="right-section">
                        <div id="right-fixed" class="fw">
                            <?php $this->load->view('right_add_box'); ?>
                            <div class="all-contact">
                                <h4><a href="<?php echo base_url('contact-request') ?>" target="_self">All Contacts</a></h4> 
                                <div class="all-user-list">
                                    <data-owl-carousel class="owl-carousel" data-options="">
                                        <div owl-carousel-item="" ng-repeat="contact in contactSuggetion" class="item">
                                            <div class="item" id="item-{{contact.user_id}}">
                                                <div class="arti-profile-box">
                                                    <div class="user-cover-img" ng-if="contact.profile_background != null && contact.profile_background != ''">
                                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" target="_self">
                                                            <img src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{contact.profile_background}}">
                                                        </a>
                                                    </div>
                                                    <div class="user-cover-img" ng-if="contact.profile_background == null || contact.profile_background == ''">
                                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" target="_self">
                                                            <div class="gradient-bg" style="height: 100%"></div>
                                                        </a>
                                                    </div>
                                                    <div class="user-pr-img" ng-if="contact.user_image != ''">
                                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" target="_self">
                                                            <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{contact.user_image}}">
                                                        </a>
                                                    </div>
                                                    <div class="user-pr-img" ng-if="contact.user_image == ''">
                                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" target="_self">
                                                            <img ng-if="contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                            <img ng-if="contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                        </a>
                                                    </div>
                                                    <div class="user-info-text text-center">
                                                        <h3>
                                                            <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-bind="(contact.first_name | limitTo:1 | uppercase) + (contact.first_name.substr(1) | lowercase)+' '+ (contact.last_name | limitTo:1 | uppercase) + (contact.last_name.substr(1) | lowercase)" target="_self"></a>
                                                        </h3>
                                                        <p>
                                                            <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name != null && contact.degree_name == null" target="_self">{{contact.title_name| uppercase}}</a>
                                                            <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.degree_name != null && contact.title_name == null" target="_self">{{contact.degree_name| uppercase}}</a>
                                                            <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name == null && contact.degree_name == null" target="_self">CURRENT WORK</a>
                                                        </p>
                                                    </div>
                                                    <div class="author-btn">
                                                        <div class="user-btns">
                                                            <a class="btn3 addtobtn-{{contact.user_id}}" ng-click="addToContact(contact.user_id, contact)">Add to Contacts</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div owl-carousel-item="" class="item last-item-box">
                                            <div class="arti-profile-box">
                                                <div class="find-more">
                                                    <img src="<?php echo base_url('assets/n-images/view-all.png') ?>">
                                                </div>                            
                                                <div class="user-info-text text-center">
                                                    <h3>
                                                        <a href="<?php echo base_url('contact-request') ?>" target="_self">Find More Contacts
                                                        </a>
                                                    </h3>                                
                                                </div>
                                                <div class="author-btn">
                                                    <div class="user-btns">
                                                        <a class="btn3" href="<?php echo base_url('contact-request') ?>" target="_self">View More</a>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </data-owl-carousel>
                                </div>
                            </div>
                        </div>
					</div>					
                </div>
            </div>
        </div>

        <!-- <script src="<?php //echo base_url('assets/js/jquery.min.js'); ?>"></script> -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
        <script>
            $('#content').on('change keyup keydown paste cut', 'textarea', function () {
                $(this).height(0).height(this.scrollHeight);
            }).find('textarea').change();
            var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>
        <script src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
        <script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-sanitize-1.6.4.js?ver=' . time()); ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_slug = '<?php echo $this->uri->segment(2); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var searchKeyword = '<?php echo $search_keyword; ?>';
            var live_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
            var keyword = "<?php echo $search_keyword; ?>";
            var cmt_maxlength = '700';

            var bus_bg_main_upload_url = '<?php echo BUS_BG_MAIN_UPLOAD_URL; ?>';
            var bus_profile_thumb_upload_url = '<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>';
            var nobusimage = '<?php echo NOBUSIMAGE; ?>';
            var user_bg_main_upload_url = '<?php echo USER_BG_MAIN_UPLOAD_URL; ?>';
            var user_thumb_upload_url = '<?php echo USER_THUMB_UPLOAD_URL; ?>';
            var message_url = '<?php echo MESSAGE_URL; ?>';
            
            var app = angular.module("searchApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize', 'ngValidate']);
        </script>
        <script src="<?php echo SOCKETSERVER; ?>/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var socket = io.connect("<?php echo SOCKETSERVER; ?>");
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_search.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui-1.12.1.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/autosize.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
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
        <script>
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

            function placeCaretAtEnd(el) {
                el.focus();
                if (typeof window.getSelection != "undefined"
                        && typeof document.createRange != "undefined") {
                    var range = document.createRange();
                    range.selectNodeContents(el);
                    range.collapse(false);
                    var sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(range);
                } else if (typeof document.body.createTextRange != "undefined") {
                    var textRange = document.body.createTextRange();
                    textRange.moveToElementText(el);
                    textRange.collapse(false);
                    textRange.select();
                }
            }

            function split_m( val ) {
                // return val.split( /,\s*/ );
                return val.split( /@/ );
            }
            function extractLast_m( term ) {
                return split_m( term ).pop();
            }

            var startTyping = "Start Typing";

            function autocomplete_mention(id)
            {
                $("#"+id).bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                        $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    appendTo: "."+id,
                    minLength: 0,
                    create: function (event,ui) {                            
                        $("#"+id).data('ui-autocomplete')._renderItem = function (ul, item) {
                            if(item.fullname != undefined)
                            {
                                var content = '<a href="javascript:void(0);" contenteditable="false">';
                                var img_content = "";

                                if(item.user_image)
                                {
                                    var img_url = "<?php echo USER_THUMB_UPLOAD_URL;?>"+item.user_image;
                                    img_content = '<img src="'+img_url+'" alt="'+item.first_name+'" onError="this.onerror=null;this.src='+(item.user_gender == "M" ? '\''+base_url+'assets/img/man-user.jpg\'' : '\''+base_url+'assets/img/female-user.jpg\'')+'">';
                                }
                                else
                                {
                                    if(item.user_gender == "M")
                                    {
                                        img_content = '<img src="'+base_url+'assets/img/man-user.jpg'+'">';
                                    }
                                    else if(item.user_gender == "F")
                                    {                                            
                                        img_content = '<img src="'+base_url+'assets/img/female-user.jpg'+'">';   
                                    }
                                }
                                content += '<div class="post-img">'+img_content+'</div>';
                                content += '<div class="dropdown-user-detail">';
                                content += '<b>'+item.fullname+'</b>';
                                content += '<div class="msg-discription">';
                                if(item.title_name)
                                {
                                    content += '<span class="time_ago">'+item.title_name+'</span>';
                                }
                                else if(item.degree_name)
                                {
                                    content += '<span class="time_ago">'+item.degree_name+'</span>';
                                }
                                else
                                {
                                    content += '<span class="time_ago">Current Work</span>';
                                }
                                content += '</div>';
                                content += '</div>';                                    
                                content += '</a>';

                                return $('<li>').append(content)
                                    .appendTo(ul);
                            }
                        };
                    },
                    source: function( request, response ) {                            
                        var term = request.term,
                            results = [];
                        if (term.indexOf("@") >= 0) {
                            term = extractLast_m(request.term);
                            if (term.length > 0) {
                                results = $.getJSON(base_url +"userprofile/get_user_list", { term : term},response);
                                response(results);
                            } else {
                                results = [startTyping];
                            }
                        }                            
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        if (ui.item.fullname !== startTyping) {
                            var value = $("#"+this.id).html();
                            var terms = split_m(value);
                            terms.pop();
                            var content = '<a target="_self" contenteditable="false" href="'+base_url+ui.item.user_slug+'" mention="'+window.btoa(ui.item.user_slug)+'">'+ui.item.fullname+'</a>&nbsp;';
                            terms.push(content);
                            $("#"+this.id).html(terms.join("@").replace(/@/g, ""));
                            placeCaretAtEnd($("#"+this.id)[0]);
                        }
                        return false;
                    },
                });
            }
    	</script>
        <script src="<?php echo base_url('assets/js/select2-4.0.3.min.js?ver=' . time()) ?>"></script>
    </body>
</html>