<!DOCTYPE html>
<?php
$userid_login                 = $this->session->userdata('aileenuser');
$article_featured_upload_path = $this->config->item('article_featured_upload_path');
$like_usr_cnt = 5;
$no_login_cls= "";
if($userid_login == "")
{
	$no_login_cls= " old-no-login";
}
if($article_data['article_meta_title'] != "")
{
	$meta_title = $article_data['article_meta_title'].TITLEPOSTFIX;
}
else
{
	$meta_title = ucwords($article_data['article_title'])." by ".ucwords($user_data['first_name']." ".$user_data['last_name']).TITLEPOSTFIX;
} ?>
<html lang="en">
    <head>
        <title><?php echo $meta_title; ?></title>
        <meta name="description" content="<?php echo $article_data['article_meta_description']; ?>" />
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="canonical" href="<?php echo current_url(); ?>" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/header.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <!--link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>"-->
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
<body class="new-article preview-article<?php echo $no_login_cls; ?>">
		<?php 
			if($userid_login){ 
				echo $header_inner_profile;
			}else{ ?>
            <header>
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
										<li class="hidden-991"><a href="<?php echo base_url(); ?>registration" class="btn3">Create Account</a></li>
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
        <?php } ?>


	<div class="middle-section">
		<?php 
			// print_r($user_post_article);exit();
			$article_pub = 0;
			$article_pub_cls = "";
			if ($user_post_article['status'] == "draft" && $user_post_article['is_delete'] == "0") {
				echo "<span class='article-info-box'>This Article has sent for approval. We'll send you a notification once it's live.</span>";
			}
			else if ($user_post_article['status'] == "reject" && $user_post_article['is_delete'] == "0") {
				echo "<span class='article-info-box'>This Article is rejected.</span>";
			}
			else if ($user_post_article['is_delete'] == "1") {
				echo "<span class='article-info-box'>This Article is deleted.</span>";
			}
			else if($user_post_article['status'] == "publish" && $userid_login == $article_data['user_id'])
			{
				$article_pub_cls = "cat-name-cus";
				$article_pub = 1;
			} ?>
		<div class="container">
			<div class="custom-user-list">
				<!-- article-box -->
				<div class="article-preview">
					<div class="article-title">
						<h1><?php echo ucwords($article_data['article_title']); ?></h1>
					</div>
					<p class="pb10">
						<span class="cat-name-cus">
							<?php
						if($article_data['article_main_category'] == 0)
						{
							echo $article_data['article_other_category'];
						}
						else
						{
							$category = $this->db->get_where('industry_type', array('industry_id' => $article_data['article_main_category'], 'status' => 1))->row()->industry_name;
							echo $category;
						}  ?>
						</span>
						<span class="<?php echo $article_pub_cls; ?>"><?php echo date('dS F Y', strtotime($article_data['created_date'])); ?></span>
						<?php if($article_pub == 1 && $userid_login == $article_data['user_id']){ ?>
						<span><a href="<?php echo base_url()."edit-article/".$article_data['unique_key']; ?>">Edit Article</a></span>
						<?php } ?>
					</p>

					<?php
					if($article_data['hashtag'] != ''): ?>
					<p class="pb10">
						<span>
							<?php
							foreach (explode(" ", $article_data['hashtag']) as $key => $value) {
								echo '<span class="post-hash-tag">'.$value.'</span>';
							} ?>
						</span>
					</p>
				<?php endif; ?>
					
					<!--div class="article-author">
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
							<a href="<?php echo base_url($user_data['user_slug']); ?>">
								<img src="<?php echo $pro_img; ?>">
							</a>
						</div>
						<div class="author-detail">
							<a href="<?php echo base_url($user_data['user_slug']); ?>">
							<h4><?php echo ucwords($user_data['first_name'] . ' ' . $user_data['last_name']); ?></h4>
							<p><?php
								if ($user_data['title_name'] != "") {
								    $designation = $user_data['title_name'];
								} elseif ($user_data['degree_name'] != "") {
								    $designation = $user_data['degree_name'];
								} else {
								    $designation = "Current Work";
								}
								echo $designation;?>
							</p>
							</a>
						</div>
						
					</div-->
					<?php
					if ($article_data['article_featured_image'] != "") {?>
					<div class="art-banner gradient-bg">
						<a href="#">
							<div class="upload-box">
								<p><img src="<?php echo base_url() . $article_featured_upload_path . $article_data['article_featured_image'] ?>"></p>
							</div>
						</a>
					</div>
					<?php }?>
					<div class="pt15">
						<?php echo $article_data['article_desc']; ?>
					</div>
				</div>
				<?php if ($user_post_article['status'] == "publish"):
					if($userid_login != "")
					{ ?>
						<div class="post-bottom">
							<div class="row">
								<div class="col-md-12">
									<ul class="bottom-left">
										<li class="user-likes">
											<?php
											$like_cls = "";
											if ($user_post_article['is_userlikePost'] == 1) {
											    $like_cls = "like";
											} ?>
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
												<li class="like-img other-like-cus">
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
				<?php } ?>
				<div class="like-other-box">
					<?php
					if($userid_login == ""): ?>
					<div class="comment-article">
						<!-- (if not login) -->
						<div class="add-comment-no-login">
							To Insert a Comment You Have To <a href="<?php echo base_url('login'); ?>">login.</a>
						</div>
					</div>
					<?php
					endif; ?>
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
			                        	<a href="<?php echo base_url($post_comment_data['user_slug']) ?>">
			                            	<img src="<?php echo $pro_img_url; ?>">
			                        	</a>
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
                                                <div contenteditable="true" data-directive class="editable_text" placeholder="Add a Comment ..." id="editCommentTaxBox-<?php echo $post_comment_data['comment_id']; ?>" focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true"><?php echo $post_comment_data['comment']; ?></div>
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
			                            	<?php
			                            	if($userid_login != ""){ ?>
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
			                            	<?php }
			                            	} ?>
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
								<p class="text-center pt15 fw"><span id="loadmore" onclick="load_more_comment(<?php echo $user_post_article['id']; ?>);">See More Comments</span>
								</p>
							<?php
							} ?>
						<div class="fw" id="cmt_loader" style="text-align: center; display: none;">
							<img src="<?php  echo base_url('assets/images/loader.gif');?>" alt="Loader">
						</div>							
					</div>
					<?php
					endif;?>					
					<?php if($userid_login != ""): ?>
					<div class="comment-article">
						<h2>Leave a Comment</h2><!-- (if login) -->
						<div class="add-comment">
							<form class="pt10">
								<div class="row">

									<div class="col-md-12">
										<div class="form-group">
											<div contenteditable="true" data-directive  class="editable_text" placeholder="Add a Comment ..." id="commentTaxBox-<?php echo $user_post_article['id']; ?>" focus-me="setFocus" style="height:100px;"></div>
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
					endif;
					if(isset($related_article_data) && !empty($related_article_data)): ?>
					<div class="related-article">
						<h2>Related Article</h2>
						<div class="row pt10">
							<?php							
							foreach($related_article_data as $_related_article_data):
								if($_related_article_data['article_featured_image'] != "")
								{
									$article_img = base_url().$article_featured_upload_path.$_related_article_data['article_featured_image'];
									$default_img_cls ="";
								}
								else
								{
									$article_img = base_url('assets/img/art-default.jpg');
									$default_img_cls =" article-defaul-img";
								} ?>
								<div class="col-md-4">
									<div class="rel-art-box<?php echo $default_img_cls; ?>">
										<a href="<?php echo base_url().'article/'.$_related_article_data['article_slug']; ?>">
											<img src="<?php echo $article_img; ?>" alt="<?php echo ucwords($_related_article_data['article_title']); ?>">
										</a>
										<div class="rel-art-name">
											<a href="<?php echo base_url().'article/'.$_related_article_data['article_slug']; ?>"><?php echo ucwords($_related_article_data['article_title']); ?></a>
										</div>
									</div>
								</div>
							<?php
							endforeach;
							?>
						</div>
					</div>
					<?php
					endif;
					?>
				</div>
				<?php endif;?>
			</div>
			<div class="right-part">
				<div class="arti-profile-box">
					<?php if($article_data['user_type'] == '1'): ?>
						<div class="user-cover-img">
							<a href="<?php echo base_url().$user_data['user_slug']; ?>">
								<?php 
								if($user_data['profile_background'] != "")
								{ ?>							    
									<img src="<?php echo USER_BG_MAIN_UPLOAD_URL.$user_data['profile_background'];?>">
								<?php
								}else{ ?>
									<div class="gradient-bg"></div>
								<?php
								} ?>
							</a>
						</div>
						<div class="user-pr-img">
							<?php
								if ($user_data['user_image'] != "")
								{
								    $pro_img = USER_THUMB_UPLOAD_URL . $user_data['user_image'];
								}
								else
								{
								    if ($user_data['user_gender'] == "M") {
								        $pro_img = base_url('assets/img/man-user.jpg');
								    } elseif ($user_data['user_gender'] == "F") {
								        $pro_img = base_url('assets/img/female-user.jpg');
								    } else {
								        $pro_img = base_url('assets/img/man-user.jpg');
								    }

								}
							?>
							<a href="<?php echo base_url().$user_data['user_slug']; ?>"><img src="<?php echo $pro_img; ?>"></a>
						</div>
						<div class="user-info-text text-center">
							<h3>
								<a href="<?php echo base_url().$user_data['user_slug']; ?>">
								<?php echo ucwords($user_data['first_name']." ".$user_data['last_name']); ?>
								</a>
							</h3>
							<p>
								<a href="<?php echo base_url().$user_data['user_slug']; ?>">
									<?php 
									if($user_data['title_name'] != "")
										echo $user_data['title_name'];
									elseif($user_data['degree_name'] != "")
										echo $user_data['degree_name'];
									else
										echo "Current Work"; ?>
								</a>
							</p>
						</div>
					<?php else: ?>
						<div class="user-cover-img">
							<a href="<?php echo base_url().'company/'.$business_data['business_slug']; ?>">
								<?php 
								if($business_data['profile_background'] != "")
								{ ?>							    
									<img src="<?php echo BUS_BG_MAIN_UPLOAD_URL.$business_data['profile_background'];?>">
								<?php
								}else{ ?>
									<div class="gradient-bg"></div>
								<?php
								} ?>
							</a>
						</div>
						<div class="user-pr-img">
							<?php
								if ($business_data['business_user_image'] != "")
								{
								    $pro_img = BUS_PROFILE_THUMB_UPLOAD_URL . $business_data['business_user_image'];
								}
								else
								{
									$pro_img = base_url(NOBUSIMAGE);
								}
							?>
							<a href="<?php echo base_url().'company/'.$business_data['business_slug']; ?>"><img src="<?php echo $pro_img; ?>"></a>
						</div>
						<div class="user-info-text text-center">
							<h3>
								<a href="<?php echo base_url().'company/'.$business_data['business_slug']; ?>">
								<?php echo ucwords($business_data['company_name']); ?>
								</a>
							</h3>
							<p>
								<a href="<?php echo base_url().'company/'.$business_data['business_slug']; ?>">
									<?php 
									if($business_data['industry_name'] != "")
										echo $business_data['industry_name'];								
									else
										echo "Current Work"; ?>
								</a>
							</p>
						</div>
					<?php endif; ?>
				
					<?php
					if ($userid_login != "" && $userid_login != $article_data['user_id'])
					{?>
						<div class="author-btn">
							<div class="user-btns">
								<?php
								if($article_data['user_type'] == '1'){
									if($contact_value == 'new'){ ?>
										<a id="contact-btn" class="btn3" onclick="contact(<?php echo $contact_id; ?>, 'pending', <?php echo $to_id; ?>)">Add to contact</a>
									<?php
									}
									elseif($contact_value == 'confirm'){ ?>
										<a id="contact-btn" class="btn3" onclick="contact(<?php echo $contact_id; ?>, 'cancel', <?php echo $to_id; ?>,1)">In Contacts</a>
									<?php
									}
									elseif($contact_value == 'pending' && $from_id != $to_id){ ?>
										<a id="contact-btn" class="btn3" onclick="contact(<?php echo $contact_id; ?>, 'cancel', <?php echo $to_id; ?>)">Request sent</a>
									<?php
									}
									elseif($contact_value == 'pending' && $from_id == $to_id){ ?>
										<a id="contact-btn" class="btn3" onclick="confirmContactRequestInnerHeader(<?php echo $to_id; ?>)">Confirm Request</a>
									<?php
									}
									elseif($contact_value == 'cancel' || $contact_value == 'reject'){ ?>
										<a id="contact-btn" class="btn3" onclick="contact(<?php echo $contact_id; ?>, 'pending', <?php echo $to_id; ?>)">Add to contact</a>
									<?php
									}

									if($follow_value == "new" || $follow_value == "0"){ ?>
										<a id="follow-btn" class="btn3" onclick="follow(<?php echo $follow_id; ?>, 1, <?php echo $to_id; ?>)">Follow</a>
									<?php }
									elseif($follow_value == "1"){ ?>
										<a id="follow-btn" class="btn3" onclick="follow(<?php echo $follow_id; ?>, 0, <?php echo $to_id; ?>)">Following</a>
									<?php
									} ?>
									<a href="<?php echo MESSAGE_URL."user/".$user_data['user_slug']; ?>" class="btn3">Message</a>
								<?php
								}
								else{
									if($follow_value == "new" || $follow_value == 0){?>
										<a id="follow-btn" class="btn3" onclick="follow_business(<?php echo $follow_id; ?>, 1, <?php echo $to_id; ?>)">Follow</a>
									<?php
									}
									elseif($follow_value == 1){?>
										<a id="follow-btn" class="btn3">Following</a>
									<?php
									}
								} ?>
							</div>
						</div>
						<?php 
					}?>
				</div>
				<?php $this->load->view('right_add_box'); ?>
			</div>
		</div>
	</div>
	<?php echo $login_footer ?>   
	<?php echo $footer; ?>

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
    <div class="modal fade message-box" id="remove-contact-conform" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lm">
            <div class="modal-content">
                <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>
                <div class="modal-body">
                    <span class="mes">
                        <div class="pop_content">Do you want to remove this contact?<div class="model_ok_cancel"><a class="okbtn" onclick="remove_contact('<?php echo $contact_id; ?>','cancel','<?php echo $to_id; ?>')" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
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
<script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
<script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
<script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script>
<script type="text/javascript">
	var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
	var header_all_profile = '<?php echo $header_all_profile; ?>';
	var app = angular.module('', ['ui.bootstrap']);
	var base_url = "<?php echo base_url(); ?>"
	var user_thumb_upload_url = "<?php echo USER_THUMB_UPLOAD_URL; ?>"
	var like_usr_cnt = "<?php echo $like_usr_cnt; ?>"
	var user_type = "<?php echo $article_data['user_type']; ?>"
</script>
<?php 
if($article_data['article_featured_image'] != "")
{
	$img_url = base_url() . $article_featured_upload_path . $article_data['article_featured_image'];
	list($width,$height) = getimagesize(base_url() . $article_featured_upload_path . $article_data['article_featured_image']);
}
else
{
	$img_url = base_url('assets/img/art-default.jpg');
	list($width,$height) = getimagesize(base_url('assets/img/art-default.jpg'));
}
?>
<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "BlogPosting",
	"mainEntityOfPage":{
		"@type":"WebPage",
		"@id":"<?php echo base_url().'article/'.$article_data['article_slug']; ?>"
	},
	"headline": "<?php echo ucwords($article_data['article_title']); ?>",
	"image": {
		"@type": "ImageObject",
		"url": "<?php echo $img_url; ?>",
		"height": <?php echo $height; ?>,
		"width": <?php echo $width; ?>
	},
	"datePublished": "<?php echo date("Y-m-d",strtotime($article_data['created_date'])); ?>",
	"dateModified": "<?php echo date("Y-m-d",strtotime($article_data['modify_date'])); ?>",
	"author": {
		"@type": "Person",
		"name": "<?php echo ucwords($user_data['first_name']." ".$user_data['last_name']); ?>"
	},
	"publisher": {
		"@type": "Organization",
		"name": "Aileensoul",
		"logo": {
			"@type": "ImageObject",
            "url": "<?php echo base_url(); ?>assets/img/aileensoul-logo.png",
            "width": 60,
            "height": 60
		}
	},
	"description": "<?php echo $article_data['article_meta_description']; ?>"
}
</script>

<script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
<script src="<?php echo base_url('assets/js/webpage/article/article_published.js?ver=' . time()) ?>"></script>
</html>