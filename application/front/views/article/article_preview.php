<!DOCTYPE html>
<?php
$userid_login                 = $this->session->userdata('aileenuser');
$article_featured_upload_path = $this->config->item('article_featured_upload_path');
$like_usr_cnt = 2;?>
<html lang="en">
    <head>
        <title><?php echo $meta_title; ?></title>
        <meta name="description" content="<?php echo $meta_desc; ?>" />
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php //echo $head; ?>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/header.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <style type="text/css">
            .ui-autocomplete {
                background: #fff;
                z-index: 999999!important;
            }
            .article-info-box{
            	text-align: center;
            	width: 100%;
            	float: left;
            	position: absolute;
            	top: 45px;
            }
        </style>
    <?php $this->load->view('adsense');?>
</head>
<body class="profile-main-page">
	<?php echo $header_inner_profile; ?>

	<div class="middle-section">
		<?php if ($user_post_article['status'] == "draft") {
    echo "<span class='article-info-box'>The post has sent for approval. We'll send you a notification once it's live.</span>";
}?>
		<div class="container">
			<div class="custom-user-list pt20">
				<!-- article-box -->
				<div class="article-preview">
					<div class="article-title">
						<h2><?php echo ucwords($article_data['article_title']); ?></h2>
					</div>
					<p class="pt20">Posted on <?php echo date('dS F Y', strtotime($article_data['created_date'])); ?></p>
					<div class="article-author">
						<div class="post-img">
							<?php
if ($user_data['user_image'] != "") {
    $pro_img = USER_THUMB_UPLOAD_URL . $user_data['user_image'];
} else {
    if ($user_data['user_gender'] == "M") {
        $pro_img = base_url('assets/img/man-user.jpg');
    } elseif ($user_data['user_gender'] == "F") {
        $pro_img = base_url('assets/img/female-user.jpg');
    } else {
        $pro_img = base_url('assets/img/man-user.jpg');
    }

}?>
							<img src="<?php echo $pro_img; ?>">
						</div>
						<div class="author-detail">
							<h4><?php echo ucwords($user_data['first_name'] . ' ' . $user_data['last_name']); ?></h4>
							<p><?php
if ($user_data['title_name'] != "") {
    $designation = $user_data['title_name'];
} elseif ($user_data['degree_name'] != "") {
    $designation = $user_data['degree_name'];
} else {
    $designation = "Current Work";
}
echo $designation;?></p>
						</div>
						<?php if ($userid_login != $article_data['user_id']) {?>
						<div class="author-btn">
							<div class="user-btns">
								<a class="btn3">Add to contact</a>
								<a class="btn3">Follow</a>
								<a class="btn3">Message</a>
							</div>
						</div>
						<?php }?>
					</div><?php
if ($article_data['article_featured_image'] != "") {?>
					<div class="art-banner gradient-bg">
						<a href="#">
							<div class="upload-box">
								<p><img src="<?php echo base_url() . $article_featured_upload_path . $article_data['article_featured_image'] ?>"></p>
								<p>Upload Article Image</p>
							</div>
						</a>
					</div>
					<?php }?>
					<div class="article-content">
						<?php echo $article_data['article_desc']; ?>
					</div>
				</div>
				<?php if ($user_post_article['status'] == "publish"): ?>
				<div class="post-bottom">
					<div class="row">
						<div class="col-md-12">
							<ul class="bottom-left">
								<li class="user-likes">
									<?php
									$like_cls = "";
									if ($user_post_article['is_userlikePost'] == 1) {
									    $like_cls = "like";
									}?>
									<a id="post-like-<?php echo $user_post_article['id']; ?>" class="ripple <?php echo $like_cls; ?>" href="javascript:void(0);" onclick="post_like(<?php echo $user_post_article['id']; ?>);">
										<i class="fa fa-thumbs-up"></i>
									</a>
								</li>
							</ul>
							<ul id="like_user_list" class="bottom-left">
								<?php
								if(isset($user_post_article['post_like_data']) && !empty($user_post_article['post_like_data'])):
									$i = 1;
									foreach ($user_post_article['post_like_data'] as $post_like_data) {
										if($post_like_data['user_image'] != "")
										{
											$pro_img_url = USER_THUMB_UPLOAD_URL.$post_like_data['user_image'];
										}
										else
										{
											if($post_like_data['user_gender'] == "M")
											{
												$pro_img_url = base_url('assets/img/man-user.jpg');
											}
											elseif($post_like_data['user_gender'] == "F")
											{
												$pro_img_url = base_url('assets/img/man-user.jpg');
											}
											else
											{
												$pro_img_url = base_url('assets/img/man-user.jpg');
											}
										} ?>
										<li class="like-img">
											<a class="ripple" href="<?php echo base_url($post_like_data['user_slug']); ?>" title="<?php echo $post_like_data['fullname']; ?>">
												<img src="<?php echo $pro_img_url; ?>">
											</a>
										</li><?php
										if($i == $like_usr_cnt)
										{
											break;
										}
										$i++;
									}
									if($user_post_article['post_like_count'] > $like_usr_cnt)
									{?>
										<li class="like-img">
											<a class="ripple" href="javascript:void(0);">
												+<?php echo $user_post_article['post_like_count'] - $like_usr_cnt; ?> Others
											</a>
										</li>
									<?php
									}
								endif; ?>
								<!-- <li class="like-img">
									<a class="ripple" href="javascript:void(0);">
										+5 Others
									</a>
								</li> -->
							</ul>
						</div>

					</div>
				</div>
				<div class="like-other-box">
					<?php if(isset($user_post_article['post_comment_data']) && !empty($user_post_article['post_comment_data'])): ?>
					<div class="article-all-comment">
						<h2>All Comments</h2>
						<div class="art-comment">
							<?php
							foreach ($user_post_article['post_comment_data'] as $post_comment_data)
							{
								if($post_comment_data['user_image'] != "")
								{
									$pro_img_url = USER_THUMB_UPLOAD_URL.$post_comment_data['user_image'];
								}
								else
								{
									if($post_comment_data['user_gender'] == "M")
									{
										$pro_img_url = base_url('assets/img/man-user.jpg');
									}
									elseif($post_comment_data['user_gender'] == "F")
									{
										$pro_img_url = base_url('assets/img/man-user.jpg');
									}
									else
									{
										$pro_img_url = base_url('assets/img/man-user.jpg');
									}
								} ?>								
								<div id="comment-<?php echo $post_comment_data['comment_id']; ?>" class="post-comment">
			                        <div class="post-img">
			                            <img src="<?php echo $pro_img_url; ?>">
			                        </div>
			                        <div class="comment-dis">
			                            <div class="comment-name">
			                            	<a href="<?php echo base_url($post_comment_data['user_slug']) ?>"><?php echo ucwords($post_comment_data['username']); ?></a>
			                            </div>
			                            <div id="comment-dis-inner-<?php echo $post_comment_data['comment_id']; ?>" class="comment-dis-inner">
			                            	<?php echo $post_comment_data['comment']; ?>
			                            </div>
			                            <!-- Edit Comment Start -->
			                            <div class="edit-comment" id="edit-comment-<?php echo $post_comment_data['comment_id']; ?>" style="display:none;">
                                            <div class="comment-input">                         
                                                <div contenteditable="true" data-directive ng-model="editComment" class="editable_text" placeholder="Add a Comment ..." id="editCommentTaxBox-<?php echo $post_comment_data['comment_id']; ?>" focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true"><?php echo $post_comment_data['comment']; ?></div>
                                            </div>
                                            <div class="mob-comment">
                                                <button onclick="sendEditComment(<?php echo $post_comment_data['comment_id']; ?>, <?php echo $user_post_article['id']; ?>)"><img src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                            </div>
                                            
                                            <div class="comment-submit hidden-mob">
                                                <button class="btn2" onclick="sendEditComment(<?php echo $post_comment_data['comment_id']; ?>, <?php echo $user_post_article['id']; ?>)">Save</button>
                                            </div>
                                        </div>
                                        <!-- Edit Comment End -->
			                            <ul class="comment-action">
			                                <li>
			                                	<?php 
			                                	$cmt_like_cls = "";
			                                	if($post_comment_data['is_userlikePostComment'] == 1)
			                                	{
			                                		$cmt_like_cls = "like";
			                                	} ?>
			                                	<a href="javascript:void(0);" class="<?php echo $cmt_like_cls; ?>" onclick="likePostComment(<?php echo $post_comment_data['comment_id']; ?>, <?php echo $user_post_article['id']; ?>)">
			                                		<i class="fa fa-thumbs-up"></i>
			                                		<span id="post-comment-like-<?php echo $post_comment_data['comment_id']; ?>"><?php echo $post_comment_data['postCommentLikeCount'] > 0 ? $post_comment_data['postCommentLikeCount'] : ''; ?></span>
			                                	</a>
			                                </li>
			                                <?php
			                                if($post_comment_data['commented_user_id'] == $userid_login){ ?>
			                                <li id="edit-comment-li-<?php echo $post_comment_data['comment_id']; ?>">
			                                	<a href="javascript:void(0);" onclick="editPostComment(<?php echo $post_comment_data['comment_id']; ?>, <?php echo $user_post_article['id']; ?>)">Edit</a>
			                                </li>
			                                <li id="cancel-comment-li-<?php echo $post_comment_data['comment_id']; ?>" style="display: none;"><a href="javascript:void(0);" onclick="cancelPostComment(<?php echo $post_comment_data['comment_id']; ?>, <?php echo $user_post_article['id']; ?>)">Cancel</a>
			                                </li>
			                                <?php
			                            	}
			                                if($user_post_article['user_id'] == $userid_login || $post_comment_data['commented_user_id'] == $userid_login){ ?>
			                                <li><a href="javascript:void(0);" onclick="deletePostComment(<?php echo $post_comment_data['comment_id']; ?>, <?php echo $user_post_article['id']; ?>)">Delete</a></li>
			                            	<?php } ?>
			                                <li><a href="javascript:void(0);"><?php echo $post_comment_data['comment_time_string']; ?></a></li>
			                            </ul>
			                        </div>
			                    </div>
							<?php
							} ?>
						</div>
						<?php
							if($user_post_article['post_comment_count'] > 5)
							{ ?>
								<span id="loadmore" onclick="load_more_comment(<?php echo $user_post_article['id']; ?>);">Load more comments</span>
							<?php
							} ?>
						<div class="fw" id="cmt_loader" style="text-align: center; display: none;">
							<img src="<?php  echo base_url('assets/images/loader.gif');?>" alt="Loader">
						</div>							
					</div>
					<?php
					endif;
					if($userid_login == ""): ?>
					<div class="comment-article">
						<h2>Leave a Comment</h2><!-- (if not login) -->
						<div class="add-comment">
							<form class="pt10">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" placeholder="Enter Your Name">
										</div>
										<div class="form-group">
											<input type="text" placeholder="Enter Your Email">
										</div>
										<div class="form-group">
											<input type="text" placeholder="Website">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<textarea placeholder="Your Messages"></textarea>
										</div>
									</div>
									<div class="col-md-12 text-right">
										<a href="#" class="btn1">Submint</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					<?php
					else: ?>
					<div class="comment-article">
						<h2>Leave a Comment</h2><!-- (if login) -->
						<div class="add-comment">
							<form class="pt10">
								<div class="row">

									<div class="col-md-12">
										<div class="form-group">
											<div contenteditable="true" data-directive  class="editable_text" placeholder="Add a Comment ..." id="commentTaxBox-<?php echo $user_post_article['id']; ?>" ng-focus="setFocus" focus-me="setFocus" style="height:100px;"></div>
											<!-- <textarea placeholder="Your Messages" style="height:100px;"></textarea> -->
										</div>
									</div>
									<div class="col-md-12 text-right">
										<a id="send_comment" href="javascript:void(0)" onclick="sendComment(<?php echo $user_post_article['id']; ?>);" class="btn1">Submit</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					<?php
					endif; ?>
					<div class="related-article">
						<h2>Related Article</h2>
						<div class="row pt10">
							<div class="col-md-4">
								<div class="rel-art-box">
									<img src="<?php echo base_url(); ?>assets/img/art-post.jpg">
									<div class="rel-art-name">
										<a href="#">Article Name</a>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="rel-art-box">
									<img src="<?php echo base_url(); ?>assets/img/art-post.jpg">
									<div class="rel-art-name">
										<a href="#">Article Name</a>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="rel-art-box">
									<img src="<?php echo base_url(); ?>assets/img/art-post.jpg">
									<div class="rel-art-name">
										<a href="#">Article Name</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endif;?>
			</div>
			<div class="right-part">
				<?php $this->load->view('right_add_box');?>
				<div class="pt20 fw">
				<?php $this->load->view('right_add_box');?>
				</div>
	        </div>
		</div>
	</div>

	<!-- Model Popup Start -->
	<div class="modal fade message-box biderror" id="publishmodal" role="dialog" data-backdrop="static" data-keyboard="false">
	    <div class="modal-dialog modal-lm">
	        <div class="modal-content message">
	            <div class="modal-body">
	                <span class="mes">
	                	<div class="msg"></div>
		                <div class="pop_content">
		                	<div class="model_ok_cancel">
		                		<a class="btn1" id="okbtn" href="javascript:void(0);" data-dismiss="modal" title="OK">OK</a>
		                	</div>
		                </div>
		            </span>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- Model Popup End -->

	<div class="modal fade message-box" id="delete_model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div class="pop_content">Do you want to delete this comment?
                            	<div class="model_ok_cancel">
	                            	<a id="del_com" class="okbtn btn1" onclick="" href="javascript:void(0);" data-dismiss="modal">Yes</a>
	                            	<a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a>
	                            </div>
	                        </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
</body>
<script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
<!-- <script src="<?php //echo base_url('assets/js/jquery.min.js?ver=' . time()); ?>"></script> -->
<script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
<!-- <script src="<?php //echo base_url('assets/js/ckeditor.js?ver='.time()); ?>"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
<script type="text/javascript">
	var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
	var header_all_profile = '<?php echo $header_all_profile; ?>';
	var app = angular.module('', ['ui.bootstrap']);
	var base_url = "<?php echo base_url(); ?>"
	var user_thumb_upload_url = "<?php echo USER_THUMB_UPLOAD_URL; ?>"
	var like_usr_cnt = "<?php echo $like_usr_cnt; ?>"
</script>
<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
<script src="<?php echo base_url('assets/js/webpage/article/article_published.js?ver=' . time()) ?>"></script>
</html>