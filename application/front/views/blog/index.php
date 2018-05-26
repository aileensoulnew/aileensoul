<!DOCTYPE html>
<?php
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    header("HTTP/1.1 304 Not Modified");
    exit();
}

$format = 'D, d M Y H:i:s \G\M\T';
$now = time();

$date = gmdate($format, $now);
header('Date: ' . $date);
header('Last-Modified: ' . $date);

$date = gmdate($format, $now + 30);
header('Expires: ' . $date);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<html class="blog_cl" lang="en" ng-app="blogApp" ng-controller="blogController">
    <head>
        <title>Official Blog for Regular Updates, News and Sharing knowledge - Aileensoul</title>
        <meta name="description" content="Our Aileensoul official blog will describe our free service and related news, tips and tricks - stay tuned." />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<?php
    if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") {
    ?>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-91486853-1', 'auto');
            ga('send', 'pageview');

        </script>

        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-6060111582812113",
                enable_page_level_ads: true
            });
        </script>

        <meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
<?php } ?>
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <style>
            footer > .container{border:1px solid transparent!important;}
            .footer{border:1px solid #d9d9d9;}
        </style>
        <?php
            foreach ($blog_detail as $blog) {
        ?>
            <!-- Open Graph data -->
            <meta property="og:title" content="<?php echo $blog['title']; ?>" />
            <meta  property="og:type" content="Blog" />
            <meta  property="og:image" content="<?php echo base_url($this->config->item('blog_main_upload_path') . $blog['image'] . '?ver=' . time()) ?>" />
            <meta  property="og:description" content="<?php echo $blog['meta_description']; ?>" />
            <meta  property="og:url" content="<?php echo base_url('blog/' . $blog['blog_slug']) ?>" />
            <meta property="og:image:width" content="620" />
            <meta property="og:image:height" content="541" />
            <meta property="fb:app_id" content="825714887566997" />

            <!-- for twitter -->
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:site" content="<?php base_url('blog/' . $blog['blog_slug']) ?>">
            <meta name="twitter:title" content="<?php $blog['title']; ?>">
            <meta name="twitter:description" content="<?php $blog['meta_description']; ?>">
            <meta name="twitter:creator" content="By Aileensoul">
            <meta name="twitter:image" content="http://placekitten.com/250/250">
            <meta name="twitter:domain" content="<?php base_url('blog/' . $blog['blog_slug']) ?>">
        <?php
            }
        ?>

        <?php if (IS_OUTSIDE_CSS_MINIFY == '0') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">

        <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/blog.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver=' . time()); ?>">

        <?php } ?>

        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>

        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>        

        <?php } ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.mCustomScrollbar.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">
    </head>
    <?php if (!$this->session->userdata('aileenuser')) { ?>
    <body class="blog no-login blog-page">
        <?php }else{?>
         <body class="blog">
        <?php }?>
        <div class="main-inner">
            <div class="web-header">
                <header class="custom-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-sm-3">
                                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a>
                            </div>
                            <div class="col-md-8 col-sm-9" style="padding-top: 5px;">
                                <div class="btn-right pull-right">
                                    <?php if (!$this->session->userdata('aileenuser')) { ?>
                                        <a href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                                        <a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="sub-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 mob-p0">
                                <ul class="sub-menu blog-sub-menu">
                                    <li>
                                    <?php
                                    if ($this->input->get('q') || $this->uri->segment(2) == 'popular' || $this->uri->segment(2) == 'tag') {
                                        ?>
                                        <a class="fs22" href="<?php echo base_url('blog'); ?>">
                                            Blog
                                        </a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="fs22" href="<?php echo base_url('blog'); ?>">
                                            Blog
                                        </a>
                                        <?php
                                    }
                                    ?>
                                    </li>
                                    <li class="dropdown">
    							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Post
    							</a>
    							<div class="dropdown-menu">
    								<div class="dropdown-title">
    									Recent Post <a href="#" class="pull-right">See All</a>
    								</div>
    								<div class="content custom-scroll">
    									<ul class="dropdown-data msg-dropdown">
                                            <?php foreach ($blog_last as $blog) { ?>
    										<li class="">
    											<a href="<?php echo base_url('blog/' . $blog['blog_slug']) ?>">
    												<div class="dropdown-database">
    													<div class="post-img">
    														<img src="<?php echo base_url($this->config->item('blog_thumb_upload_path') . $blog['image'] . '?ver=' . time()) ?>" alt="<?php echo $blog['image']; ?>">
    													</div>
    													<div class="dropdown-user-detail">
    														<p class="drop-blog-title"><?php echo $blog['title']; ?></p>
    															<span class="day-text"><?php echo $blog['created_date_formatted']; ?></span>
    													</div> 
    												</div>
    											</a> 
    										</li>
                                            <?php } ?>
    									</ul>
    								</div>
    							</div>
    						</li>
                            <li class="dropdown">
    							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="pr-name">Category</span></a>
    							<div class="dropdown-menu">
    								<ul class="content custom-scroll">
                                        <li class="category" ng-repeat="category in categoryList track by $index">
                                            <a href="javascript:void(0)" ng-attr-id="{{ 'category_' + category.id }}" ng-click="cat_post(category.id)">
                                                {{ category.name }}
                                            </a>
                                        </li>
    								</ul>
    							</div>
    						</li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-6 hidden-mob blog-search">
            					<div class="job-search-box1 clearfix">        
            						<form action="<?php echo base_url;?>blog" method="get">
            							<fieldset class="sec_h2">
            								<input id="tags" class="tags ui-autocomplete-input" name="q" placeholder="Search" autocomplete="off" type="text">
            								<i class="fa fa-search" aria-hidden="true"></i>
            							</fieldset>
            						</form>   
            					</div>
    				        </div>  
                        </div>
                    </div>
                </div>
            </div>
            
            <section id="paddingtop_fixed" class="hidden">
                <div class="blog-mid-section user-midd-section">
                    <div class="container">
                        <div class="row">
                            <div class="custom-user-list">
                                <div class="job-contact-frnd">
                                </div>
                                <div class="fw" id="loader" style="text-align:center;"><img src="<?php echo base_url('assets/images/loader.gif?ver='.time()) ?>" alt="<?php echo 'LOADERIMAGE'; ?>"/></div>
                                <ul class="load-more-blog">
                                    <li class="loadbutton"></li>
                                    <li class="loadcatbutton"></li>
                                </ul>                              
                            </div>
                            <div class="right-part">
                				<div class="subscribe-box">
                					<h4>Subscribe to Our Newslatter</h4>
                					<input type="text" class="form-control" placeholder="Enter your email id">
                					<a class="btn1" href="#">Subscribe</a>
                				</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div id="paddingtop_fixed" class="user-midd-section">
                <input type="hidden" class="page_number" value="1">
                <input type="hidden" class="total_record" ng-value="total_record">
                <input type="hidden" class="perpage_record" value="4">
                <div class="container">
                    <div class="custom-user-list">
                        <div class="blog-box" ng-repeat="blog in blogPost">
                            <div class="blog-left-img">
                                <a class="blog-img" target="_blank" ng-href="<?php echo base_url; ?>blog/{{ blog.blog_slug }}">
                                    <img ng-src="<?php echo base_url($this->config->item('blog_main_upload_path')); ?>{{ blog.image }}">
                                </a>
                            </div>
                            <div class="blog-left-content">
                                <p class="blog-details-cus">
                                    <span class="cat text-capitalize">
                                        {{ blog.category_name }}
                                    </span> 
                                    <span>{{ blog.created_date_formatted }}</span> 
                                    <span>Dhaval Shah</span> 
                                    <span>{{ blog.total_comment }} comments</span>
                                </p>
                                <a target="_blank" ng-href="<?php echo base_url; ?>blog/{{ blog.blog_slug }}">
                                    <h3>
                                        {{ blog.title }}
                                    </h3>
                                </a>
                                <p class="blog-text" ng-bind-html="blog.description | unsafe" style="height: 62px;overflow: hidden;">
                                </p>
                                <p>
                                    <ul class="social-icon">
                                        <li>
                                            <a target="_blank" class="fbk" id="facebook_link" url_encode="{{ blog.social_encodeurl }}" url="{{ blog.social_url}}" title="Facebook" summary="{{ blog.social_summary }}" image="{{ social_image }}">
                                                <i class="fa fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li><a href="javascript:void(0)"  title="twitter" id="twitter_link" url_encode="{{ blog.url_encode }}" url="{{ blog.url }}"><i class="fa fa-twitter"></i></a></li>
                                        <li><a id="linked_link" href="javascript:void(0)" title="linkedin" url_encode="{{ blog.encode_url }}" url="{{ blog.url }}"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="javascript:void(0)" title="Google +" id="google_link" url_encode="{{ blog.encode_url }}" url="{{ blog.url }}"><i class="fa fa-google"></i></a></li>
                                    </ul>
                                </p>
                            </div>
                        </div>                                             
                        <div class="">
                            <pagination 
                              ng-model="currentPage"
                              total-items="total_record"
                              max-size="maxSize"  
                              boundary-links="true">
                            </pagination>
                        </div>      

                        <ul>
                          <li ng-repeat="todo in filteredTodos">{{todo.text}}</li>
                        </ul>
                    </div>
                    <div class="right-part">
                        <div class="subscribe-box" ng-show="subscribe_visibility">
                            <h4>Subscribe to Our Newslatter</h4>
                            <input type="text" class="form-control" placeholder="Enter your email id" ng-model="subscribe_email">
                            <h6 class="small" style="color: red;" ng-show="error_subscribe_visiblity">{{ error_subscribe_text }}</h6>
                            <a class="btn1" href="javascript:void(0)" ng-click="addsubscribe();">Subscribe</a>
                            <h6 class="small" style="color: red;">{{ ajax_error_text }}</h6>
                        </div>
                        <div class="subscribe-box" ng-hide="subscribe_visibility">
                            <h4>Your email id subscribe successfully.</h4>
                        </div>
                    </div>
                </div>                
            </div>
            <?php
                echo $login_footer
            ?>
        </div>

        <script>
            //AJAX DATA LOAD BY LAZZY LOADER START
            $(document).ready(function () {
                // blog_post();
            });

            /*function category_data(catid, pagenum) {
                $('.job-contact-frnd').html("");
                $('.loadbutton').html("");
                cat_post(catid, pagenum);
            }

            $('.loadcatbutton').click(function () {
                var pagenum = parseInt($(".page_number:last").val()) + 1;
                var catid = $(".catid").val();
                cat_post(catid, pagenum);
            });*/

            /*var isProcessing = false;
            function cat_post(catid, pagenum) { 
                if (isProcessing) {
                    return;
                }
                isProcessing = true;
                $.ajax({
                    type: 'POST',
                    url: base_url + "blog/cat_ajax?page=" + pagenum + "&cateid=" + catid,
                    data: {total_record: $("#total_record").val()},
                    dataType: "json",
                    beforeSend: function () {
                         $('#loader').show();
                    },
                    complete: function () {
                         $('#loader').hide();
                    },
                    success: function (data) {
                        // $('#loader').hide();
                        $('.job-contact-frnd').append(data.blog_data);
                        $('.loadcatbutton').html(data.load_msg)
                        // second header class add for scroll
                        var nb = $('.post-design-box').length;
                        if (nb == 0) {
                            $("#dropdownclass").addClass("no-post-h2");
                        } else {
                            $("#dropdownclass").removeClass("no-post-h2");
                        }
                        isProcessing = false;
                    }
                });
            }*/


            // $('.loadbutton').click(function () {
            //     var pagenum = parseInt($(".page_number:last").val()) + 1;
            //     blog_post(pagenum);
            // });

            // var isProcessing = false;
            /*function blog_post(pagenum) {
                if (isProcessing) {
                    return;
                }
                isProcessing = true;
                $.ajax({
                    type: 'POST',
                    url: base_url + "blog/blog_ajax?page=" + pagenum,
                    data: {total_record: $("#total_record").val()},
                    dataType: "json",
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    complete: function () {
                        $('#loader').hide();
                    },
                    success: function (data) {
                      //  $('#loader').remove();
                        $('.job-contact-frnd').append(data.blog_data);
                        $('.loadbutton').html(data.load_msg)
                        // second header class add for scroll
                        var nb = $('.post-design-box').length;
                        if (nb == 0) {
                            $("#dropdownclass").addClass("no-post-h2");
                        } else {
                            $("#dropdownclass").removeClass("no-post-h2");
                        }
                        isProcessing = false;
                    }
                });
            }*/
            //AJAX DATA LOAD BY LAZZY LOADER END

        </script>
        
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
            <script src="<?php echo base_url('assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js?ver=' . time()); ?>"></script>
            <script>
		
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


    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-sanitize.js"></script>
    <script src="<?php echo base_url('assets/js/angular-pagination.js?ver=' . time()); ?>"></script>
    <script>
        var base_url = '<?php echo base_url(); ?>';
        var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
        var title = '<?php echo $title; ?>';
        var header_all_profile = '<?php echo $header_all_profile; ?>';
        var app = angular.module('blogApp', ['ui.bootstrap','angularUtils.directives.dirPagination']);
    </script>

    <?php // if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/webpage/blog/blog.js?ver=' . time()); ?>"></script>
    <?php // } else { ?>
            <!-- <script src="<?php //echo base_url('assets/js_min/webpage/blog/blog.js?ver=' . time()); ?>"></script> -->
    <?php // } ?>

    </body>
</html>
