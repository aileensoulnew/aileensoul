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
<html lang="en"><!--  ng-app="blogDetailApp" ng-controller="blogDetailController"> -->
    <head>
        <!-- <title><?php //echo $blog_data['title']; ?> - Aileensoul</title> -->
        <title><?php echo trim($blog_data['title']); ?></title>
        <meta name="description" content="<?php echo trim($blog_data['meta_description']); ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta charset="utf-8">
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />       
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $blog_data['title']; ?>" />
        <meta  property="og:type" content="Blog" />
        <meta  property="og:image" content="<?php echo base_url($this->config->item('blog_main_upload_path') . $blog_data['image']) ?>" />
        <meta  property="og:description" content="<?php echo $blog_data['meta_description']; ?>" />
        <meta  property="og:url" content="<?php echo base_url('blog/' . $blog_data['blog_slug']) ?>" />
        <meta property="fb:app_id" content="825714887566997" />

        <!-- for twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="<?php base_url('blog/' . $blog_data['blog_slug']) ?>">
        <meta name="twitter:title" content="<?php $blog_data['title']; ?>">
        <meta name="twitter:description" content="<?php $blog_data['meta_description']; ?>">
        <meta name="twitter:creator" content="By Aileensoul">
        <meta name="twitter:image" content="http://placekitten.com/250/250">
        <meta name="twitter:domain" content="<?php base_url('blog/' . $blog_data['blog_slug']) ?>">
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
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()); ?>">
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
    <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
	<?php if (!$this->session->userdata('aileenuser')) { ?>
        <body class="blog-page blog-d old-no-login">
    <?php }else{?>
        <body class="blog-page blog-d">
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
										<li><a href="<?php echo base_url('login'); ?>" class="btn2">Login</a></li>
										<li><a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a></li>
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
        	<div id="paddingtop_fixed" class="user-midd-section">
	    		<div class="container">
	    			<div class="custom-user-list pt20">
	    				<div class="blog-user-detail">
	    					<div class="user-img">
								<img src="<?php echo base_url().'assets/n-images/'.$blog_data['name'].'.jpg'; ?>">
	    					</div>
							<div class="user-detail-left">
								<p class="pt20"><?php echo $blog_data['name']; ?></p>
								<p><?php echo $blog_data['created_date_formatted']; ?></p>
								<p>
									<img class="hidden-639" src="<?php echo base_url(); ?>assets/n-images/comment.png" class="pr5"><?php echo $blog_data['total_comment']; ?> <span class="block-639"> Comment</span>
								</p>
							
								<ul class="social-icon">
									<li>
										<a target="_blank" class="fbk" id="facebook_link" url_encode="<?php echo $blog_data['social_encodeurl']; ?>" url="<?php echo $blog_data['social_url']; ?>" title="Facebook" summary="<?php echo $blog_data['social_summary']; ?>" image="<?php echo $blog_data['social_image']; ?>">
											<i class="fa fa-facebook-f"></i>
										</a>
									</li>
									<li><a href="javascript:void(0)"  title="twitter" id="twitter_link" url_encode="<?php echo $blog_data['url_encode']; ?>" url="<?php echo $blog_data['url']; ?>"><i class="fa fa-twitter"></i></a></li>
									<li><a id="linked_link" href="javascript:void(0)" title="linkedin" url_encode="<?php echo $blog_data['encode_url']; ?>" url="<?php echo $blog_data['url']; ?>"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="javascript:void(0)" title="Google +" id="google_link" url_encode="<?php echo $blog_data['encode_url']; ?>" url="<?php echo $blog_data['url']; ?>"><i class="fa fa-google"></i></a></li>
								</ul>
							</div>
	    				</div>
	    				<div class="blog-detail">
	    					<div class="blog-box">
	    						<div class="blog-left-content blog-detail-top">
	    							<a href="<?php echo base_url().'blog/'.$blog_data['blog_slug']; ?>">
		    							<!-- <p class="blog-details-cus">
                                            <?php /*foreach($blog_data['blog_category_name'] as $k=>$v):
                                                $category_url = $this->common->clean($v); ?>
		    								<a href="<?php echo base_url().'blog/category/'.$category_url; ?>">
                                                <span class="cat text-capitalize">
                                                <?php
                                                if($key == 0)
                                                    echo $val;
                                                if($key > 0)
                                                    echo ", ".$val; ?>
		                                        </span> 		                                        
		                                    </a>
                                            <?php endforeach;*/ ?>
		    							</p> -->
		    							<h3><?php echo $blog_data['title']; ?></h3>
	    							</a>	    							
	    						</div>
	    						<div class="blog-left-img">
	    							<img src="<?php echo base_url($this->config->item('blog_main_upload_path')).$blog_data['image']; ?>">
	    						</div>
	    						<div class="blog-left-content">
                                    <?php echo $blog_data['description']; ?>
	    						</div>
	    					</div>
	    					<div class="">
	    						<ul class="pagination pull-right pb0 pt20">
	    						  	<li class="prev">
	    						  		<?php
	                                        if (count($blog_all) != 0) {
	                                            foreach ($blog_all as $key => $blog) {
	                                                if ($blog['id'] == $blog_data['id'] && ($key + 1) != 1) {
	                                                    ?>
	                                                    <a href="<?php echo base_url('blog/' . $blog_all[$key - 1]['blog_slug']); ?>" target="_self">
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
		    						  		        if ($blog['id'] == $blog_data['id'] && ($key + 1) != count($blog_all)) {
		    						  		            ?>
		    						  		            <a href="<?php echo base_url('blog/' . $blog_all[$key + 1]['blog_slug']); ?>" target="_self">Next</a>
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
                                    <?php
                                    if(isset($blog_data['related_post']) && !empty($blog_data['related_post'])):
                                        foreach($blog_data['related_post'] as $related_post): ?>
	    							<div class="col-md-4 col-sm-12">
	    								<div class="also-like-box">
											<div class="rec-img">
												<a href="<?php echo base_url().'blog/'.$related_post['blog_slug']; ?>">
	    											<img src="<?php echo base_url($this->config->item('blog_main_upload_path')).$related_post['image']; ?>">
												</a>
											</div>
											<div class="also-like-bottom">
                                                <?php foreach($related_post['blog_category_name'] as $key=>$val):
                                                $category_url = $this->common->clean($val); ?>
                                                <a href="<?php echo base_url().'blog/category/'.strtolower($category_url); ?>">
                                                    <span class="cat text-capitalize">
                                                    <?php
                                                    if($key == 0)
                                                        echo $val;
                                                    if($key > 0)
                                                        echo ", ".$val; ?>
                                                    </span>
                                                </a>
                                                <?php endforeach; ?>
												
												<!-- <span class="onelinetext" title="{{ post.category_name}}">
													{{ post.category_name}}
												</span> -->
												<p>
													<a href="<?php echo base_url().'blog/'.$related_post['blog_slug']; ?>">
                                                        <?php echo $related_post['title']; ?>
													</a> 
												</p>
											</div>
											<div class="clearfix"></div>
	    								</div>
	    							</div>
                                <?php endforeach;
                                    endif; ?>
	    						</div>
	    					</div>
                            <?php
                            if(isset($blog_data['all_comment']) && !empty($blog_data['all_comment'])):?>
	    					<div class="all-comments fw">
	    						<div class="center-title">
	                                <h3>All Comments</h3>
	    						</div>
                                <div class="all-comment-div " style="height:300px; overflow-y:scroll;">
                                    <div class="all-comment-result">
                                    <?php foreach($blog_data['all_comment'] as $all_comment): ?>
    	    						<div class="comment-box">
    	    							<div class="comment-img post-head">
                                            <span class="post-img">
                                            <?php echo ucwords($all_comment['name'][0]); ?>
                                            </span>
                                        </div>
    	    							<div class="comment-text">
    	    								<h4><?php echo ucwords($all_comment['name']); ?></h4>
    	    								<span><?php echo $all_comment['created_date_formatted']; ?></span>
    	    								<p><?php echo $all_comment['message']; ?></p>
    	    							</div>
    	    						</div>
                                    <?php endforeach; ?>
                                    </div>
                                    <div class="fw" id="loader_more" style="text-align:center;display: none;"><img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="loaderimage"></div>
                                </div>
	    					</div>
                            <?php endif; ?>
	    					<div class="leave-reply fw">
	    						<div class="center-title">
	                                <h3>Leave a reply</h3>
	    						</div>
	    						<div class="reply-form pt20">
	    							<form name="comment" id="comment" method="post" autocomplete="off">
		    							<div class="row pt20">
		    								<div class="col-md-6 col-sm-6">
		    									<div class="form-group">
		    										<input type="text" class="form-control" name="cname" id="cname" placeholder="Enter Your Name">
		    									</div>
		    								</div>
		    								<div class="col-md-6 col-sm-6">
		    									<div class="form-group">
		    										<input type="text" class="form-control" name="comment_email" id="comment_email" placeholder="Enter Your Email id">
		    									</div>
		    								</div>
		    							</div>
		    							<div class="row">
		    								<div class="col-md-12">
		    									<div class="form-group">
		    										<textarea class="form-control" name="comment_message" id="comment_message" placeholder="message"></textarea>
		    									</div>
		    									<!-- <p ng-show="comment_error_visibility">{{ comment_error_text }}</p> -->
		    									<p class="comment_error"></p>
		    								</div>	    								
		    							</div>
		    							<input type="hidden" value="<?php echo $blog_data['id']; ?>" name="blog_id" id="blog_id">
		    							<button class="btn1" type="submit">Comment</button>
		    						</form>
	    						</div>
	    					</div>
							<div class="banner-add">
								<?php $this->load->view('banner_add'); ?>
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
                                <h4>Your email id subscribed successfully.</h4>
                            </div>
                        </form>
						<div class="pt20 fw">
						<?php $this->load->view('right_add_box'); ?>
						</div>
                    </div>
	    		</div>	    		
	    	</div>
        <!-- Comment Modal  -->
        <div class="modal message-box biderror" id="commentmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>         
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Comment Modal  -->

        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()); ?>" ></script>
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        <?php
            echo $login_footer
        ?>
		<?php $this->load->view('mobile_side_slide'); ?>
    </div>
        <?php if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
            <script src="<?php echo base_url('assets/js/jquery.validate.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/js_min/jquery.validate.js?ver=' . time()); ?>"></script>
        <?php } ?>
        <!-- This Js is used for call popup -->
        <script src="<?php echo base_url('assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-sanitize.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
	        var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
	        var title = '<?php echo $title; ?>';
	        var header_all_profile = '<?php echo $header_all_profile; ?>';
	        var blog_slug = '<?php echo $this->uri->segment(2); ?>';	        
            var blog_id = "<?php echo $blog_data['id']; ?>";
            $(window).on("load",function(){
                $(".custom-scroll").mCustomScrollbar({
                    autoHideScrollbar:true,
                    theme:"minimal"
                });
            });
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

                $("#comment").validate({
                    rules: {
                        cname: {
                            required: true,
                            maxlength: 100
                        },
                        comment_email: {
                            required: true,
                            email : true,
                            maxlength: 100
                        },
                        comment_message: {
                            required: true,
                            maxlength: 1000
                        },
                                                
                    },
                    messages:
                    {
                        cname: {
                            required: "Please enter you name",
                            maxlength: "Maxumum 100 allow for name"
                        },
                        comment_email: {
                            required: "Please enter email address",
                            email : "Please enter valid email address",
                            maxlength: "Maxumum 100 allow for email address"
                        },
                        comment_message: {
                            required: "Please enter comment",
                            maxlength: "Maxumum 1000 allow for comment"
                        },
                    },                    
                    submitHandler: function (form) {
                        // console.log($("#comment").serialize());
                        $.ajax({
                            type: 'POST',
                            url: base_url + "blog/comment_insert",
                            data: $("#comment").serialize(),
                            dataType: "json",
                            beforeSend: function () {
                                $('#comment_loader').show();
                            },
                            complete: function () {
                                $('#comment_loader').hide();
                            },
                            success: function (data) {                                
                                $("#comment")[0].reset();
                                if(data == 1)
                                {
                                    $('#commentmodal .mes').html("Comment Added Successfully. When admin approve than it will show.");
                                    $("#commentmodal").modal("show");
                                }
                                else if(data == 0)
                                {
                                    $('#commentmodal .mes').html("Comment not added. Plese try again.");
                                    $("#commentmodal").modal("show");
                                }
                            }
                        });
                    }
                });
            });
            // Social media click
            $(document).on("click", '#google_link', function(event) { 
                var  url = $(this).attr('url_encode');
                window.open('https://plus.google.com/share?url=' + url +'', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
            });

            $(document).on("click", '#linked_link', function(event) { 
                var  url = $(this).attr('url_encode');
                window.open('https://www.linkedin.com/cws/share?url=' + url +'', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
            });

            $(document).on("click", '#twitter_link', function(event) { 
                var  url = $(this).attr('url_encode');
                window.open('https://twitter.com/intent/tweet?url=' + url +'', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
            });

            $(document).on("click", '#facebook_link', function(event) { 
                var url = $(this).attr('url');
                var url_encode = $(this).attr('url_encode');
                var title = $(this).attr('title');
                var summary = $(this).attr('summary');
                var image = $(this).attr('image');

                $.ajax({
                    type: 'POST',
                    url: 'https://graph.facebook.com?id=' + url + '&scrape=true',
                    success: function (data) {
                        console.log(data);
                    }

                });
                window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + summary + '&p[url]=' + url_encode + '&p[images][0]=' + image + '', 'sharer', 'toolbar=0,status=0,width=620,height=280');
            });
            var page = 1;
            var limit = 5;
            var total_rec = "";
            var is_loading = false;
            $(".all-comment-div").scroll(function(){
                if($(".all-comment-div").scrollTop() + $(".all-comment-div").height() == $(".all-comment-result").height() && is_loading == false)
                {
                    loadmorecomment(page)
                }
            });
            function loadmorecomment(pg)
            {
                if (is_loading) {                    
                    return;
                }
                is_loading = true;
                page = pg + 1;                
                $.ajax({
                        type: 'POST',
                        url: base_url + "blog/load_more_comment",
                        data: {page:page,blog_id:blog_id},                        
                        beforeSend: function () {
                            $('#loader_more').show();
                        },
                        complete: function () {
                            $('#loader_more').hide();
                        },
                        success: function (data) {
                            if(data != "")
                            {                                
                                $(".all-comment-result").append(data);
                                is_loading = false;
                            }
                            else
                            {
                                is_loading = true;   
                            }
                        }
                    });
            }
        </script>
        <!-- <script src="<?php //echo base_url('assets/js/webpage/blog/blog_detail.js?ver=' . time()); ?>"></script> -->
        <?php /* if (IS_OUTSIDE_JS_MINIFY == '0') { ?>
            <script src="<?php echo base_url('assets/js/webpage/blog/blog_detail.js?ver=' . time()); ?>"></script>
        <?php } else { ?>
            <script src="<?php echo base_url('assets/js_min/webpage/blog/blog_detail.js?ver=' . time()); ?>"></script>

        <?php } */?>
		
    </body>
</html>