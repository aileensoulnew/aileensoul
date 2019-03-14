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
<html class="blog_cl" lang="en"><!--  ng-app="blogApp" ng-controller="blogController"> -->
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <?php
        if($category_page == 1){ ?>
            <meta name="robots" content="noindex, follow">
        <?php
        }
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <style>
            footer > .container{border:1px solid transparent!important;}
            .footer{border:1px solid #d9d9d9;}
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
        <?php
            /*foreach ($blogPost as $blog) {
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
            }*/
        ?>

        
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">       

        
            <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>

			<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.mCustomScrollbar.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver=' . time()); ?>">
    <?php $this->load->view('adsense');
$cat_cls = "";
if($category_page == 1)
{
		$cat_cls = "blog-cat";
}?>
</head>
    <?php if (!$this->session->userdata('aileenuser')) { ?>
        <body class="no-login blog-m blog-page old-no-login <?php echo $cat_cls; ?>">
    <?php }else{?>
        <body class="blog-m blog-page <?php echo $cat_cls; ?>">
    <?php }?>

    <?php //$this->load->view('page_loader'); ?>
    <div id="main_page_load">
        <div class="main-inner">
            <div class="web-header">
                <header class="custom-header">
	                <div class="container">
	                    <div class="row">
                            <div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
								<?php $this->load->view('main_logo'); ?>
                            </div>
                            <div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
                                <div class="btn-right">
                                <?php if(!$this->session->userdata('aileenuser')) {?>
									<ul class="nav navbar-nav navbar-right test-cus drop-down">
										<?php //$this->load->view('profile-dropdown'); ?>
										<li class="hidden-991"><a href="<?php echo base_url('login'); ?>" class="btn2">Login</a></li>
										<li class="hidden-991"><a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a></li>
										<li class="mob-bar-li">
											<span class="mob-right-bar">
												<?php $this->load->view('mobile_right_bar'); ?>
											</span>
										</li>
									
									</ul>
                                <?php }?>
                                </div>
                            </div>
                        </div>
	                </div>
	            </header>
                <div class="sub-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 mob-p0 col-xs-8 fw-479 mob-cus-p">
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
            									Recent Post <a href="<?php echo base_url() ?>blog" class="pull-right">See All</a>
            								</div>
            								<div class="content custom-scroll">
            									<ul class="dropdown-data msg-dropdown">
                                                    <?php
                                                    if(isset($recent_blog_list) && !empty($recent_blog_list)):
                                                        foreach($recent_blog_list as $_recent_blog_list): ?>
                                                    <li>
                                                        <a href="<?php echo base_url().'blog/'.$_recent_blog_list['blog_slug']; ?>">
            												<div class="dropdown-database">
            													<div class="post-img">
                                                                    <img src="<?php echo base_url($this->config->item('blog_main_upload_path')).$_recent_blog_list['image']; ?>" alt="<?php echo $_recent_blog_list['image']; ?>">
            													</div>
            													<div class="dropdown-user-detail">
            														<p class="drop-blog-title">
                                                                        <?php echo $_recent_blog_list['title']; ?>
                                                                    </p>
        															<span class="day-text">
                                                                        <?php echo $_recent_blog_list['created_date_formatted']; ?>
                                                                    </span>
                                                                </div> 
            												</div>
            											</a> 
            										</li>
                                                    <?php
                                                        endforeach;
                                                    endif; ?>
            									</ul>
            								</div>
            							</div>
            						</li>
                                    <li class="dropdown">
            							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="pr-name">Category</span></a>
            							<div class="dropdown-menu">
            								<ul class="content custom-scroll">
                                                <?php
                                                if(isset($categoryList) && !empty($categoryList)):
                                                    foreach($categoryList as $_categoryList):
                                                    $category_url = $this->common->clean($_categoryList['name']);
                                                     ?>
                                                    <li class="category <?php echo ($category_id == $_categoryList['id'] ? 'active' : '');?>">
                                                        <a href="<?php echo base_url().'blog/category/'.strtolower($category_url); ?>">
                                                            <?php echo ucwords($_categoryList['name']); ?>
                                                        </a>
                                                    </li><?php
                                                    endforeach;
                                                endif;?>
            								</ul>
            							</div>
            						</li>
                                    <li>
                                        <a class="fs22" href="<?php echo base_url('guest-contributor'); ?>">Guest Blog</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-4 col-md-4 col-xs-4 blog-search fw-479">
            					<div class="job-search-box1 clearfix hidden-479">        
            						<form action="<?php echo base_url().'blog';?>" method="get" onsubmit="return formCheckMain()">
            							<fieldset class="sec_h2 ">
            								<input id="tags" class="tags ui-autocomplete-input" name="q" placeholder="Search" autocomplete="off" type="text" value="<?php echo $search_keyword; ?>">
            								<i class="fa fa-search" aria-hidden="true"></i>
            							</fieldset>
										
            						</form>   
            					</div>
								<div class="clearfix block-479">        
            						<form action="<?php echo base_url().'blog';?>" method="get" onsubmit="return formCheckMob()">
										<fieldset>
            								<input id="res_tags" class="tags ui-autocomplete-input" name="q" placeholder="Search" autocomplete="off" type="text" value="<?php echo $search_keyword; ?>" required>
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
								<?php $this->load->view('right_add_box'); ?>
                                <ul class="load-more-blog">
                                    <li class="loadbutton"></li>
                                    <li class="loadcatbutton"></li>
                                </ul>                              
                            </div>
                            <div class="right-part">
								<?php $this->load->view('right_add_box'); ?>
                				<div class="subscribe-box">
                					<h4>Subscribe to Our Newsletter</h4>
                					<input type="text" class="form-control" placeholder="Enter your email id">
                					<a class="btn1" href="#">Subscribe</a>
                				</div>
								<?php $this->load->view('right_add_box'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div id="paddingtop_fixed" class="user-midd-section">                
                <!-- <input type="hidden" class="page_number" value="1">
                <input type="hidden" class="total_record" ng-value="total_record">
                <input type="hidden" class="perpage_record" value="4"> -->
                <?php if($category_name == "" && $search_keyword == ""){?>
                <div class="container">
                    <div class="blog-t">
                        <h1>Aileensoul Blog</h1>
                    </div>
                </div>
                <?php } ?>
                <div class="container">
                    <div class="custom-user-list">
						<div class="tab-add">
							<?php $this->load->view('banner_add'); ?>
						</div>
						<div class="clearfix"></div>
                        <?php if($category_name != ""){ ?>
                            <h3 style="border: 1px solid #d9d9d9;color: #5c5c5c;text-align: center;margin-bottom: 20px; border-radius:4px;"><?php
                            echo "Category : ".ucwords($category_name)."</h3>";
                        }
                        if($search_keyword != ""){ ?>
                        <h3 style="border: 1px solid #d9d9d9;color: #5c5c5c;text-align: center;margin-bottom: 20px; border-radius:4px;">Search results of 
                            <?php echo '' . $search_keyword . ''; ?></h3>
                        <?php }
                        if(isset($blogPost) && !empty($blogPost)):
                            foreach($blogPost as $_blogPost): ?>
                        <div class="blog-box">
                            <div class="blog-left-img">
                                <a class="blog-img" href="<?php echo base_url().'blog/'.$_blogPost['blog_slug']; ?>">
                                    <img src="<?php echo base_url($this->config->item('blog_main_upload_path')).$_blogPost['image']; ?>">
                                </a>
                            </div>
                            <div class="blog-left-content">
                                <p class="blog-details-cus">
                                    <?php
                                    foreach($_blogPost['blog_category_name'] as $key=>$val):
                                    $category_url = $this->common->clean($val); ?>
                                    <a href="<?php echo base_url().'blog/category/'.strtolower($category_url); ?>">
                                        <span class="cat text-capitalize">
                                            <?php
                                            if($key == 0)
                                                echo $val;
                                            if($key > 0)
                                                echo ", ".$val; ?>
                                        </span> 
                                        <!-- <span class="cat text-capitalize" ng-if="($index > 0)">
                                            , {{ cat_name }}
                                        </span>  -->
                                    </a>
                                    <?php endforeach; ?>
                                    <span class="blog-date"><?php echo $_blogPost['created_date_formatted']; ?></span> 
                                    <span><?php echo $_blogPost['name']; ?></span> 
                                    <?php if($_blogPost['total_comment'] > 0): ?><span><?php echo $_blogPost['total_comment']; ?> comments</span><?php endif; ?>
                                </p>
                                <a href="<?php echo base_url().'blog/'.$_blogPost['blog_slug']; ?>">
                                    <h2><?php echo $_blogPost['title']; ?></h2>
                                </a>
                                <span class="blog-text">
                                    <?php echo substr(strip_tags($_blogPost['description']), 0,150);?><a href="<?php echo base_url().'blog/'.$_blogPost['blog_slug']; ?>">...read more
                                    </a>
                                </span>
                                <p>
                                    <ul class="social-icon">
                                        <li>
                                            <a class="fbk" id="facebook_link" url_encode="<?php echo $_blogPost['social_encodeurl']; ?>" url="<?php echo $_blogPost['social_url']; ?>" title="Facebook" summary="<?php echo $_blogPost['social_summary']; ?>" image="<?php echo $_blogPost['social_image']; ?>">
                                                <i class="fa fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li><a href="javascript:void(0)"  title="twitter" id="twitter_link" url_encode="<?php echo $_blogPost['url_encode']; ?>" url="<?php echo $_blogPost['url']; ?>"><i class="fa fa-twitter"></i></a></li>
                                        <li><a id="linked_link" href="javascript:void(0)" title="linkedin" url_encode="<?php echo $_blogPost['encode_url']; ?>" url="<?php echo $_blogPost['url']; ?>"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="javascript:void(0)" title="Google +" id="google_link" url_encode="<?php echo $_blogPost['encode_url']; ?>" url="<?php echo $_blogPost['url']; ?>"><i class="fa fa-google"></i></a></li>
                                    </ul>
                                </p>
                            </div>
                        </div>
                        <?php
                            endforeach;
                        endif; ?>
                        <div class="fw pt20 text-center">
                            <?php echo $links; ?>
                        </div> 
						<div class="banner-add">
							<?php $this->load->view('banner_add'); ?>
						</div>

                        <!-- <ul>
                          <li ng-repeat="todo in filteredTodos">{{todo.text}}</li>
                        </ul> -->
                    </div>
                    <div class="right-part">
						<?php $this->load->view('right_add_box'); ?>
                        <form id="subscribe_form" name="subscribe_form" method="post" action="javascript:void(0);">
                            <div id="subscribe-form" class="subscribe-box">
                                <h4>Subscribe to Our Newsletter</h4>
                                <input type="text" class="form-control" placeholder="Enter your email id" name="subscribe_email" id="subscribe_email" maxlength="100">
                                <button class="btn1" type="submit">Subscribe</button>
                                <h6 class="small" style="color: red;display: none;" id="error_subscribe"></h6>
                            </div>
                            <div id="subscribe-done" class="subscribe-box" style="display: none;">
                                <h4>Your email id subscribe successfully.</h4>
                            </div>
                        </form>
						<div class="pt20 fw">
						<?php $this->load->view('right_add_box'); ?>
						</div>
                    </div>
                </div>                
            </div>
			<?php $this->load->view('mobile_side_slide'); ?>
            <?php
                echo $login_footer;
            ?>
        </div>
    </div>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
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
    <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-sanitize.js"></script>
    <script src="<?php echo base_url('assets/js/angular-pagination.js?ver=' . time()); ?>"></script>
    <script>
        var base_url = '<?php echo base_url(); ?>';
        var keyword = '';
        var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
        var title = '<?php echo $title; ?>';
        var category_id = '<?php echo $category_id; ?>';
        var header_all_profile = '<?php echo $header_all_profile; ?>';
        var app = angular.module('blogApp', ['ui.bootstrap','angularUtils.directives.dirPagination']);
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

        function formCheckMain()
        {
            if($("#tags").val().trim() == "" || $("#tags").val() == undefined)
            {
                return false;
            }
            return true;
        }

        function formCheckMob()
        {
            if($("#res_tags").val().trim() == "" || $("#res_tags").val() == undefined)
            {
                return false;
            }
            return true;
        }       

        $(document).ready(function(){
            $("#subscribe_form").validate({
                rules: {
                    subscribe_email: {
                        required: true,
                        email : true,
                        maxlength: 100
                    },                        
                },
                messages:
                {                        
                    subscribe_email: {
                        required: "Please enter email address",
                        email: "Please enter valid email address",
                        maxlength: "Maxumum 100 allow for email address"
                    },                      

                },
                errorElement : 'h6',
                submitHandler: function (form) {                        
                    $.ajax({
                        type: 'POST',
                        url: base_url + "blog/add_subscription",
                        data: {email: $("#subscribe_email").val()},
                        dataType: "json",
                        beforeSend: function () {
                            $('#loader').show();
                        },
                        complete: function () {
                            $('#loader').hide();
                        },
                        success: function (data) {                                
                            if(data.success == true)
                            {
                                $("#subscribe_form")[0].reset();
                                $("#subscribe-done").show();
                                $("#subscribe-form").hide();
                            }

                            if(data.success == false)
                            {
                                $("#error_subscribe").show();
                                $("#error_subscribe").text(data.message);
                                setTimeout(function(){
                                    $("#error_subscribe").hide();
                                    $("#error_subscribe").text("");
                                },5000)
                            }

                            if(data.error == true)
                            {
                                $("#error_subscribe").show();
                                $("#error_subscribe").text(data.message);
                                setTimeout(function(){
                                    $("#error_subscribe").text("");
                                    $("#error_subscribe").hide();
                                },5000)
                            }
                        }
                    });
                }
            });
        });

    </script>

    <?php // if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <!-- <script src="<?php echo base_url('assets/js/webpage/blog/blog.js?ver=' . time()); ?>"></script> -->
    <?php // } else { ?>
            <!-- <script src="<?php //echo base_url('assets/js_min/webpage/blog/blog.js?ver=' . time()); ?>"></script> -->
    <?php // }
    if($blog_page == 'list'){ ?>
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
                        "@id": "<?php echo base_url(); ?>blog",
                        "name": "Blog"
                    }
                }
            ]
        }
        </script>

    <?php }
    elseif($blog_page == 'category'){ ?>
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
                        "@id": "<?php echo base_url(); ?>blog",
                        "name": "Blog"
                    }
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "item":
                    {
                        "@id": "<?php echo current_url(); ?>",
                        "name": "<?php echo ucwords($category_name); ?>"
                    }
                }
            ]
        }
        </script>

    <?php } ?>

    </body>
</html>
