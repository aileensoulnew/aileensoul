<?php $user_id = $this->session->userdata('aileenuser'); ?>
<div class="pt20 fw">
<div class="container mobp0">
    <div class="custom-user-list question-page">
		<div class="tab-add-991 ads">
            <?php
            $data['data'] = 'ads';
            $this->load->view('ads_box',$data); ?>
		</div>
        <div class="list-box-custom">
            <h3 class="border-none mob-border-top-1">Questions</h3>
            <div class="custom-user-box no-data-available" ng-if="questionData.length == 0 ">
                <div class="art-img-nn">
                    <div class="art_no_post_img">
                        <img src="<?php echo base_url('assets/img/no-question.png'); ?>" alt="No Questions">
                    </div>
                    <div class="art_no_post_text">
                        No Questions Available.
                    </div>
                </div>
            </div>
        </div>
		
        <div class="all-post-box" ng-repeat="post in questionData" ng-init="queIndex=$index">
            <input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_data.page}}">
            <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.page_data.total_record}}">
            <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.page_data.perpage_record}}">
            <div class="all-post-top">
                <div class="post-head" ng-class="post.question_data.is_anonymously == '1' ? 'anonymous-que' : ''">
                    <div class="post-img" ng-if="post.post_data.post_for == 'question'">
                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != '' && post.question_data.is_anonymously == '0'">
                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_image == '' && post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_image == '' && post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                        <span class="no-img-post"  ng-if="post.question_data.is_anonymously == '1'">A</span>
                    </div>
                    <div class="post-img" ng-if="post.post_data.post_for != 'question'">
                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != ''">
                        <span class="no-img-post" ng-bind="(post.user_data.first_name| limitTo:1 | uppercase) + (post.user_data.last_name | limitTo:1 | uppercase)"  ng-if="post.user_data.user_image == ''"></span>
                    </div>
                    <div class="post-detail">
                        <div class="fw" ng-if="post.post_data.post_for == 'question'">
                            <a href="javascript:void(0)" class="post-name" ng-if="post.question_data.is_anonymously == '1'">Anonymous</a><span class="post-time" ng-if="post.question_data.is_anonymously == '1'"></span>
                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" ng-if="post.question_data.is_anonymously == '0'"></a><span class="post-time">{{post.post_data.time_string}}</span>
                        </div>
                        <div class="fw" ng-if="post.post_data.post_for != 'question'">
                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname"></a><span class="post-time">{{post.post_data.time_string}}</span>
                        </div>
                        <div class="fw" ng-if="post.post_data.post_for == 'question'">
                            <span class="post-designation" ng-if="post.user_data.title_name != '' && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.title_name"></span>
                            <span class="post-designation" ng-if="post.user_data.title_name == '' && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.degree_name"></span>
                            <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null && post.question_data.is_anonymously == '0'" ng-bind="CURRENT WORK"></span>
                        </div>
                        <div class="fw" ng-if="post.post_data.post_for != 'question'">
                            <span class="post-designation" ng-if="post.user_data.title_name != ''" ng-bind="post.user_data.title_name"></span>
                            <span class="post-designation" ng-if="post.user_data.title_name == ''" ng-bind="post.user_data.degree_name"></span>
                            <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null" ng-bind="CURRENT WORK"></span>
                        </div>
                    </div>
                    <div class="post-right-dropdown dropdown" ng-if="post.post_monetize == 0">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/right-down.png') ?>" alt="Right Down"></a>
                        <ul class="dropdown-menu">                            
                            <li><a href="javascript:void(0);" ng-click="deletePost(post.post_data.id, $index)">Delete Post</a></li>
                        </ul>
                    </div>
                </div>
                <div class="post-discription">
                    <div id="ask-que-{{post.post_data.id}}" class="post-des-detail">
                        <p class="question"><a ng-href="<?php echo base_url('questions/') ?>{{post.question_data.id}}/{{post.question_data.question | slugify}}" ng-bind="post.question_data.question" target="_self"></a></p>
                    </div>
                </div>
                <div class="post-bottom">
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-9 mob-pr0">
                            <ul class="bottom-left">
                                <li class="user-likes">
                                    <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id,$index,post.post_data.user_id)" ng-if="post.is_userlikePost == '1'" class="like"><i class="fa fa-thumbs-up"></i></a>
                                    <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id,$index,post.post_data.user_id)" ng-if="post.is_userlikePost == '0'"><i class="fa fa-thumbs-up"></i></a>
                                </li>
                                
                            </ul>
							<ul class="bottom-left like_user_list">
                                <li class="like-img" ng-if="post.user_like_list.length > 0" ng-repeat="user_like in post.user_like_list">
                                    <a class="ripple" href="<?php echo base_url(); ?>{{user_like.user_slug}}" target="_self" title="{{user_like.fullname}}">
                                        <img ng-if="user_like.user_image" ng-src="<?php echo USER_THUMB_UPLOAD_URL; ?>{{user_like.user_image}}">
                
                                        <img ng-if="!user_like.user_image && user_like.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        
                                        <img ng-if="!user_like.user_image && user_like.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">

                                    </a>
                                </li> 
								<!-- <li class="like-img">
									<a class="ripple" href="#" title="harshad patel">
										<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1546847465.png">
									</a>
								</li>
								<li class="like-img">
									<a class="ripple" href="#" title="harshad patel">
										<img src="https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1546847465.png">
									</a>
								</li> -->
								<li class="like-img">
									<a href="#" ng-click="like_user_list(post.post_data.id);" ng-bind="post.post_like_data" id="post-other-like-{{post.post_data.id}}"></a>
								</li>
								
							</ul>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-4">
                            <ul class="pull-right bottom-right">
                                <li class="comment-count pt5"><a href="javascript:void(0)" ng-click="giveAnswer(post.post_data.id)"><span class="post-comment-count-{{post.post_data.id}}" ng-if="post.post_comment_count > 0" ng-bind="post.post_comment_count"></span><span>Answers</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="ans-text" id="ans-text-{{post.post_data.id}}"><span>Answers</span></div>
            <div class="all-post-bottom" id="all-post-bottom-{{post.post_data.id}}">
                <div class="comment-box">
                    <div class="add-comment">
                        <div class="post-img">
                            <?php
                            if ($leftbox_data['user_image'] != '')
                            { ?>
                                <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                            <?php
                            }
                            else
                            { 
                                if($leftbox_data['user_gender'] == "M")
                                {?>                                
                                    <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                <?php
                                }
                                if($leftbox_data['user_gender'] == "F")
                                {
                                ?>
                                    <img class="login-user-pro-pic" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                <?php
                                } 
                            } ?>
                        </div>
                        <div class="comment-input">
                            <div contenteditable="true" data-directive ng-model="comment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendComment({{post.post_data.id}},$index,post)" id="commentTaxBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" ng-paste="handlePaste($event)" onkeyup="autocomplete_mention(this.id);"></div>
                            <div class="commentTaxBox-{{post.post_data.id}} all-hashtags-list"></div>
                        </div>
                        <div class="mob-comment">
                            <button ng-click="sendEditComment(comment.comment_id, post.post_data.id)"><img ng-src="<?php echo base_url('assets/img/send.png') ?>"></button>
                        </div>
                        <div class="comment-submit hidden-mob">
                            <button class="btn2" ng-click="sendComment(post.post_data.id, $index, post)">Comment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="tab-add ads">
            <?php
            $data['data'] = 'ads';
            $this->load->view('ads_box',$data); ?>
		</div>
        <div class="fw post_loader loadmore" style="text-align:center; display: none;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>
    </div>
    <div class="right-add">
        <?php $this->load->view('right_add_box'); ?>
    </div>
</div>
</div>

<div class="modal fade message-box" id="delete_post_model" role="dialog">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes">
                    <div class="pop_content">Do you want to delete this post?<div class="model_ok_cancel"><a class="okbtn btn1" ng-click="deletedPost(p_d_post_id, p_d_index)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade message-box like-popup" id="likeusermodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <h3 ng-if="count_likeUser > 0 && count_likeUser < 2">{{count_likeUser}} Like</h3>
                    <h3 ng-if="count_likeUser > 1">{{count_likeUser}} Likes</h3>
                    <div class="modal-body padding_less_right">
                        <div class="">
                            <ul>
                                <li class="like-img" ng-repeat="userlist in get_like_user_list">
                                    <a class="ripple" href="<?php echo base_url(); ?>{{userlist.user_slug}}" ng-if="userlist.user_image != ''">
                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{userlist.user_image}}">
                                    </a>
                                      <a class="ripple" href="<?php echo base_url(); ?>{{userlist.user_slug}}" ng-if="userlist.user_image == ''">
                                        <img ng-if="userlist.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <img ng-if="userlist.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    </a>
                                    <div class="like-detail">
                                        <h4><a href="<?php echo base_url(); ?>{{userlist.user_slug}}">{{(userlist.user_id == <?php echo $user_id; ?> ? 'You' : userlist.fullname)}}</a></h4>
                                        <p ng-if="(userlist.degree_name != null) && (userlist.title_name == null)">{{userlist.degree_name}}</p>
                                        <p ng-if="(userlist.title_name != null) && (userlist.degree_name == null)">{{userlist.title_name}}</p>
                                        <p ng-if="(userlist.title_name == null) && (userlist.degree_name == null)">Current work</p>
                                    </div>

                                </li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>