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
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <?php
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

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.mCustomScrollbar.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/font-awesome.min.css?ver=' . time()); ?>">

        <!-- <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script> -->
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>

    <?php $this->load->view('adsense');?>
    </head>
    <?php if (!$this->session->userdata('aileenuser')) { ?>
        <body class="no-login blog-m blog-page old-no-login">
    <?php }else{?>
        <body class="blog-m blog-page">
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
										<?php $this->load->view('profile-dropdown'); ?>
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
                            <div class="col-md-6 col-sm-6 mob-p0 col-xs-8 fw-479">
                                <ul class="sub-menu blog-sub-menu">
                                    <li>
                                     <a class="fs22" href="<?php echo base_url('blog'); ?>">
                                            Blog
                                        </a>
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
                            <div class="col-sm-6 col-md-6 col-xs-4 blog-search fw-479">
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
                <div class="container pt15">
                    <div class="custom-user-list">
                        <div class="post-guid-content job_reg_main fw">
                            <h1>Guest Post Guidelines</h1>
                            <div class="p20 fw">
                                <p>We always welcome people who like to contribute a useful piece of information to our audiences.</p>
                                <p>To become a guest contributor to our website you need to meet the following criteria:</p>
                                
                                <h2 class="pt15">Content Standards</h2>
                                <ul>
                                    <li><p>Your article should be around Business networking, Recruitment, Job Search, Freelancing, Artists networking topics.</p></li>
                                    <li><p>The post should provide realistic points that can be implemented by the readers.</p></li>
                                    <li><p>The length of the content should be around 1000 words and above.</p></li>
                                    <li><p>Should not be published elsewhere and should be plagiarism free, grammatically correct, well structured, visually compelling and understandable to the audience.</p></li>
                                    <li><p>The post should contain some new topic or view and not the same points that rest of the article around the Internet says.</p></li>
                                    <li><p>Include some image wherever it’s necessary to explain a view.</p></li>
                                    <li><p>The image should not have copyright issues. (Provide a source of the image.)</p></li>
                                    <li><p>Should not be a promotional one and containing a lot of links to your website unless it’s mandatory.</p></li>
                                    
                                </ul>
                                <p>P.S. We hold the rights to edit content or remove the hyperlinks mentioned in the article if we think it doesn’t match with the context of the post.</p>
                                <h2 class="pt15">Submission Procedure</h2>
                                <ul>
                                    <li><p>First, send us topic headline with some description and points that explains what the article will be.</p></li>
                                    <li><p>If we approve your topic, the article must send in word format.</p></li>
                                    
                                </ul>
                                <p>If you think, you meet with our requirement then contact us by submitting below form.</p>
                                <div class="guide-form">
                                    <div class="fw job-reg-cus-new">        
                                        <div class="fw p20">
                                            <form id="guest_form" name="guest_form" method="post" action="javascript:void(0);">
                                                <div class="form-group">
                                                    <input type="text" id="guest_name" name="guest_name" class="form-control" required="" placeholder="First Name">
                                                    <!-- <label class="form-control-placeholder" for="First Name"></label> -->
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="guest_email" name="guest_email" class="form-control" required="" placeholder="Email Address">
                                                    <!-- <label class="form-control-placeholder" for="First Name">Email Address</label> -->
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="guest_jobtitle" name="guest_jobtitle" class="form-control" required="" placeholder="Job Title">
                                                    <!-- <label class="form-control-placeholder" for="First Name">Job Title</label> -->
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="guest_company" name="guest_company" class="form-control" required="" placeholder="Company">
                                                    <!-- <label class="form-control-placeholder" for="First Name">Company</label> -->
                                                </div>
                                                <div class="form-group">
                                                    <textarea type="text" id="guest_desc" name="guest_desc" class="form-control" required="" placeholder="Discription"></textarea>
                                                    <!-- <label class="form-control-placeholder" for="First Name">Discription</label> -->
                                                </div>
                                                <div class="fw text-center pt5">
                                                    <!-- <a href="javascript:void(0)" onclick="save_guest()" class="btn3">Submit</a> -->
                                                    <button id="submit_guest" class="btn3" type="submit">Submit</button>
                                                </div>
                                                <h6 class="small" style="display: none;" id="error_subscribe">Done</h6>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <p><b>Disclaimer:</b> Due to many requests we may not be able to respond promptly. You can expect a response from our side within 24-48 hours.
                                </p>                                
                            </div>                        
                        </div>
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
            <!-- Bid-modal  -->
            <div class="modal message-box biderror" id="bidmodal" role="dialog">
                <div class="modal-dialog modal-lm">
                    <div class="modal-content">
                        <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                        <div class="modal-body">
                            <span class="mes">Succefully Submitted</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Model Popup Close -->
			<?php $this->load->view('mobile_side_slide'); ?>
            <?php
                echo $login_footer;
            ?>
        </div>
    </div>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
    <!-- <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()); ?>"></script> -->
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
    <script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
    <script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script>
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
        $(document).ready(function(){
            $("#guest_form").validate({
                rules: {
                    guest_name: {
                        required: true,
                        maxlength: 100
                    },
                    guest_email: {
                        required: true,
                        email : true,
                        maxlength: 100
                    },
                    guest_jobtitle: {
                        required: true,
                        maxlength: 100
                    },
                    guest_company: {
                        required: true,
                        maxlength: 100
                    },
                    guest_desc: {
                        required: true,
                        maxlength: 700
                    },
                },
                errorElement : 'label',
                submitHandler: function (form) {
                    $("#submit_guest").attr("disabled","disabled");
                    var guest_name = $("#guest_name").val();
                    var guest_email = $("#guest_email").val();
                    var guest_jobtitle = $("#guest_jobtitle").val();
                    var guest_company = $("#guest_company").val();
                    var guest_desc = $("#guest_desc").val();
                    var post_data = {"guest_name":guest_name,"guest_email":guest_email,"guest_jobtitle":guest_jobtitle,"guest_company":guest_company,"guest_desc":guest_desc};
                    $.ajax({
                        type: 'POST',
                        url: base_url + "blog/add_guest",
                        data: post_data,
                        dataType: "json",
                        beforeSend: function () {
                            // $('#loader').show();
                        },
                        complete: function () {
                            // $('#loader').hide();
                        },
                        success: function (data) {                            
                            $("#guest_form")[0].reset();
                            $("#submit_guest").removeAttr("disabled");
                            if(data.success == true)
                            {
                                $("#guest_form")[0].reset();
                                $("#bidmodal .modal-body .mes").html("Successfully Submitted");
                                $("#bidmodal").modal("show");
                            }

                            if(data.success == false)
                            {
                                $("#bidmodal .modal-body .mes").html("Please try again later");
                                $("#bidmodal").modal("show");
                            }

                            if(data.error == true)
                            {
                                $("#bidmodal .modal-body .mes").html("Please try again later");
                                $("#bidmodal").modal("show");
                            }
                        }
                    });
                }
            });
        });

    </script>
    </body>
</html>
