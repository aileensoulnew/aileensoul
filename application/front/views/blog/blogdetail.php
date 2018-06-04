<!DOCTYPE html>
<?php
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    header("HTTP/1.1 304 Not Modified");
    exit();
}

$format = 'D, d M Y H:i:s \G\M\T';
$now = time();

$date = gmdate($format, $now + 30);
header('Expires: ' . $date);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<html lang="en" ng-app="blogDetailApp" ng-controller="blogDetailController">
    <head>
        <title><?php echo $blog_detail[0]['title']; ?> - Aileensoul</title>
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
        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $blog_detail[0]['title']; ?>" />
        <meta  property="og:type" content="Blog" />
        <meta  property="og:image" content="<?php echo base_url($this->config->item('blog_main_upload_path') . $blog_detail[0]['image']) ?>" />
        <meta  property="og:description" content="<?php echo $blog_detail[0]['meta_description']; ?>" />
        <meta  property="og:url" content="<?php echo base_url('blog/' . $blog_detail[0]['blog_slug']) ?>" />
        <meta property="fb:app_id" content="825714887566997" />

        <!-- for twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="<?php base_url('blog/' . $blog_detail[0]['blog_slug']) ?>">
        <meta name="twitter:title" content="<?php $blog_detail[0]['title']; ?>">
        <meta name="twitter:description" content="<?php $blog_detail[0]['meta_description']; ?>">
        <meta name="twitter:creator" content="By Aileensoul">
        <meta name="twitter:image" content="http://placekitten.com/250/250">
        <meta name="twitter:domain" content="<?php base_url('blog/' . $blog_detail[0]['blog_slug']) ?>">
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />

        <?php if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
        <?php } else { ?>

            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/blog.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver=' . time()); ?>">
        <?php } ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.mCustomScrollbar.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">
            <style type="text/css">
            	.twolinetext{
	                overflow: hidden;
	                text-overflow: ellipsis;
	                display: -webkit-box;
	                -webkit-box-orient: vertical;
	                -webkit-line-clamp: 2;
	                line-height: 1.5em;
	                max-height: 3em;
	            }
	            .onelinetext {
	                overflow: hidden;
	                text-overflow: ellipsis;
	                display: -webkit-box;
	                -webkit-box-orient: vertical;
	                -webkit-line-clamp: 1;
	            }
            </style>
    </head>
	<?php if (!$this->session->userdata('aileenuser')) { ?>
    <body class="blog-page blog blog-d old-no-login">
        <?php }else{?>
         <body class="blog-page blog-d">
        <?php }?>
		

        <div class="main-inner">
            <div class="web-header">
	            <header class="custom-header">
	                <div class="container">
	                    <div class="row">
	                        <div class="col-md-4 col-sm-3 col-xs-4 fw-539 left-header">
	                            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name.png?ver=' . time()) ?>" alt="logo"></a>
	                        </div>
	                        <div class="col-md-8 col-sm-9 col-xs-8 fw-539 right-header">
	                            <div class="btn-right">
	                                <?php if (!$this->session->userdata('aileenuser')) { ?>
	                                    <a href="<?php echo base_url('login'); ?>" class="btn4">Login</a>
	                                    <a href="<?php echo base_url('registration'); ?>" class="btn2">Create an account</a>
	                                <?php } ?>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </header>
                <div class="sub-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 mob-p0 col-xs-6">
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
                                            <a ng-href="<?php echo base_url() ?>blog/category/{{ category.name | slugify }}" ng-attr-id="{{ 'category_' + category.id }}" ng-click="cat_post(category.id)">
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
      
	    	<div id="paddingtop_fixed" class="user-midd-section angularsection hidden">
	    		<div class="container">
	    			<div class="custom-user-list pt20" ng-repeat="blog in blogDetails track by $index">
	    				<div class="blog-user-detail">
	    					<div class="user-img">	
	    						<img src="<?php echo base_url(); ?>assets/n-images/user-pic.jpg">
	    					</div>
	    					<p class="pt20">{{ blog.name }}</p>
	    					<p>{{ blog.created_date_formatted }}</p>
	    					<p>
	    						<img src="<?php echo base_url(); ?>assets/n-images/comment.png" class="pr5">{{ blog.total_comment }}
	    					</p>
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
	    				</div>
	    				<div class="blog-detail">
	    					<div class="blog-box">
	    						<div class="blog-left-content blog-detail-top">
	    							<a target="_blank" ng-href="<?php echo base_url; ?>blog/{{ blog.blog_slug }}">
		    							<p class="blog-details-cus">
		    								<a ng-href="<?php echo base_url() ?>blog/category/{{ cat_name | slugify}}" ng-repeat="cat_name in blog.blog_category_name track by $index">
		                                        <span class="cat text-capitalize" ng-if="($index == 0)">
		                                            {{ cat_name }}
		                                        </span> 
		                                        <span class="cat text-capitalize" ng-if="($index > 0)">
		                                            , {{ cat_name }}
		                                        </span> 
		                                    </a>
		    								<!-- <span class="cat">{{ blog.category_name }}</span> --> 
		    							</p>
		    							<h3>{{ blog.title }}</h3>
	    							</a>	    							
	    						</div>
	    						<div class="blog-left-img">
	    							<img ng-src="<?php echo base_url($this->config->item('blog_main_upload_path')); ?>{{ blog.image }}">
	    						</div>
	    						<div class="blog-left-content" ng-bind-html="blog.description | unsafe">   						
	    						</div>
	    					</div>
	    					<div class="">
	    						<ul class="pagination pull-right pb0 pt20">
	    						  	<li class="prev">
	    						  		<?php
	                                        if (count($blog_all) != 0) {
	                                            foreach ($blog_all as $key => $blog) {
	                                                if ($blog['id'] == $blog_detail[0]['id'] && ($key + 1) != 1) {
	                                                    ?>
	                                                    <a href="<?php echo base_url('blog/' . $blog_all[$key - 1]['blog_slug']); ?>">
	                                                    	Previous
	                                                    </a>
	                                                    <?php
	                                                }
	                                            }
	                                        }
                                        ?>
	    						  	</li>
	    						  	<li class="next">
	    						  		<?php
	    						  			if (count($blog_all) != 0) {
		    						  		    foreach ($blog_all as $key => $blog) {
		    						  		        if ($blog['id'] == $blog_detail[0]['id'] && ($key + 1) != count($blog_all)) {
		    						  		            ?>
		    						  		            <a href="<?php echo base_url('blog/' . $blog_all[$key + 1]['blog_slug']); ?>">Next</a>
		    						  		            <?php
		    						  		        }
		    						  		    }
		    						  		}
	    						  		?>
    						  		</li>
	    						</ul>
	    					</div>
	    					
	    					<div class="also-like fw pt20">
	    						<div class="center-title">
	                                <h3>You may also like</h3>
	    						</div>
	    						<div class="row pt20">
	    							<div class="col-md-4 col-sm-4" ng-repeat="post in blog.related_post">
	    								<div class="also-like-box">
    										<a target="_blank" ng-href="<?php echo base_url; ?>blog/{{ post.blog_slug }}">
		    									<div class="rec-img">
	    											<img ng-src="<?php echo base_url($this->config->item('blog_main_upload_path')); ?>{{ post.image }}">
		    									</div>
    										</a>
	    									<a target="_blank" ng-href="<?php echo base_url() ?>blog/category/{{ (cat_name).toLowerCase() }}" ng-repeat="cat_name in post.blog_category_name track by $index">
		                                        <span class="cat text-capitalize" ng-if="($index == 0)">
		                                            {{ cat_name }}
		                                        </span> 
		                                        <span class="cat text-capitalize" ng-if="($index > 0)">
		                                            , {{ cat_name }}
		                                        </span> 
		                                    </a>
	    									<!-- <span class="onelinetext" title="{{ post.category_name}}">
	    										{{ post.category_name}}
	    									</span> -->
	    									<p>
	    										<a target="_blank" ng-href="<?php echo base_url; ?>blog/{{ post.blog_slug }}">
	    											{{ post.title }}
	    										</a> 
    										</p>
	    								</div>
	    							</div>
	    						</div>
	    					</div>
	    					<div class="all-comments fw" ng-show="(blog.all_comment).length">
	    						<div class="center-title">
	                                <h3>All Comments</h3>
	    						</div>
	    						<div class="comment-box" ng-repeat="comment in blog.all_comment">
	    							<div class="comment-img">
	    								<!-- <img ng-src="<?php //echo base_url($this->config->item('blog_main_upload_path')); ?>{{ comment.image }}"> -->
	    							</div>
	    							<div class="comment-text">
	    								<h4>{{ comment.name }}</h4>
	    								<span>{{ comment.created_date_formatted }}</span>
	    								<p>{{ comment.message }}</p>
	    							</div>
	    						</div>
	    					</div>
	    					<div class="leave-reply fw">
	    						<div class="center-title">
	                                <h3>Leave a reply</h3>
	    						</div>
	    						<div class="reply-form pt20">
	    							<form name="comment" id="comment" method="post" autocomplete="off">
		    							<div class="row pt20">
		    								<div class="col-md-6 col-sm-6">
		    									<div class="form-group">
		    										<input type="text" ng-model="cname" class="form-control" name="name" id="name" placeholder="Enter Your Name">
		    									</div>
		    								</div>
		    								<div class="col-md-6 col-sm-6">
		    									<div class="form-group">
		    										<input type="text" ng-model="comment_email" class="form-control" name="email" id="email" placeholder="Enter Your Email id">
		    									</div>
		    								</div>
		    							</div>
		    							<div class="row">
		    								<div class="col-md-12">
		    									<div class="form-group">
		    										<textarea class="form-control" name="message" id="comment_message" placeholder="message" ng-model="msg"></textarea>
		    									</div>
		    									<!-- <p ng-show="comment_error_visibility">{{ comment_error_text }}</p> -->
		    									<p class="comment_error"></p>
		    								</div>	    								
		    							</div>
		    							<input type="hidden" value="{{ blog.id }}" name="blog_id" id="blog_id">
		    							<button onclick="addcomment()" class="btn1">Comment</button>
		    						</form>
	    						</div>
	    					</div>
	    				</div>
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

			
			

        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
            <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
            <script src="<?php echo base_url('assets/js_min/bootstrap.min.js?ver=' . time()); ?>"></script>
        <?php } ?>
        <?php
        echo $login_footer
        ?>
        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script src="<?php echo base_url('assets/js/jquery.validate.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.js?ver=' . time()); ?>"></script>
        <?php } ?>
        <!-- This Js is used for call popup -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-sanitize.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
	        var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
	        var title = '<?php echo $title; ?>';
	        var header_all_profile = '<?php echo $header_all_profile; ?>';
	        var blog_slug = '<?php echo $this->uri->segment(2); ?>';
	        var app = angular.module('blogDetailApp', ['ui.bootstrap']);
            app.filter('slugify', function () {
                return function (input) {
                    if (!input)
                        return;
                    // make lower case and trim
                    var slug = input.toLowerCase().trim();

                    // replace invalid chars with spaces
                    slug = slug.replace(/[^a-z0-9\s-]/g, ' ');

                    // replace multiple spaces or hyphens with a single hyphen
                    slug = slug.replace(/[\s-]+/g, '-');

                    if(slug[slug.length - 1] == "-")
                    {            
                        slug = slug.slice(0,-1);
                    }
                    return slug;
                };
            });
        </script>

        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/webpage/blog/blog_detail.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/webpage/blog/blog_detail.js?ver=' . time()); ?>"></script>

        <?php } ?>
    </body>
</html>