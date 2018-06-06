<!DOCTYPE html>
<html lang="en" ng-app="searchApp" ng-controller="searchController">
    <head>
        <title>Aileensoul</title>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css?ver=' . time()); ?>">
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
    </head>
    <body class="search-page">
        <?php echo $header_profile ?>
        <div class="middle-section">
            <div class="container mobp0">
                <?php echo $n_leftbar; ?>
                <div class="middle-part">
                    <div class="no-data-box" ng-if="searchProfileData.length == '0' && postData.length == '0'">
                        <h3>Search result of "<?php echo $search_keyword ?>" </h3>
                        <div class="no-data-content">
                            <p><img src="<?php echo base_url('assets/n-images/no-data.png') ?>"></p>
                            <p class="pt20">Oops No Data Found.</p>
                            <p class="">
                                <span>We couldn't find what you were looking for.
                                    <span>Make sure you used the right keywords.</span>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="availabel-data-box" ng-if="searchProfileData.length != '0' && postData.length != '0'">
                        <h3 class="border-bottom-none">Search result of "<?php echo $search_keyword ?>" </h3>
                    </div>                    
                    <div class="availabel-data-box" ng-if="searchProfileData.length != '0'">
                        <h3>Profiles </h3>
                        <div class="post_loader" style="text-align:center;">
                            <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                        </div>
                        <div class="search-profiles" ng-repeat="searchProfile in searchProfileData">
                            <div class="profile-img post-img">
                                <a href="<?php echo base_url() ?>{{searchProfile.user_slug}}">
                                    <img src="<?php echo USER_THUMB_UPLOAD_URL ?>{{searchProfile.user_image}}" alt="{{searchProfile.fullname}}" ng-if="searchProfile.user_image">                                    
                                    <img ng-if="!searchProfile.user_image && searchProfile.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                    <img ng-if="!searchProfile.user_image && searchProfile.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                </a>
                            </div>
                            <div class="profile-data">
                                <p><a href="<?php echo base_url() ?>{{searchProfile.user_slug}}" ng-bind="searchProfile.fullname | capitalize"></a></p>
                                <span ng-if="searchProfile.degree_name != ''">{{searchProfile.title_name}}</span>
                                <span ng-if="searchProfile.degree_name == ''">{{searchProfile.degree_name}}</span>
                                <span ng-if="searchProfile.degree_name == null && searchProfile.title_name == null">Current work</span>
                                <!-- <span ng-bind="searchProfile.title_name" ng-if="searchProfile.title_name"></span>
                                <span ng-bind="searchProfile.degree_name" ng-if="searchProfile.degree_name"></span>
                                <span ng-if="(searchProfile.degree_name == 'null' || searchProfile.degree_name == '') && (searchProfile.title_name == 'null' || searchProfile.title_name == '')">CURRENT WORK</span>
                                <span ng-bind="searchProfile.industry_name" ng-if="searchProfile.industry_name"></span>
                                <span ng-bind="searchProfile.university_name" ng-if="searchProfile.university_name"></span>
                                <span ng-if="searchProfile.city">{{searchProfile.city}}, {{searchProfile.country}}</span> -->
                            </div>
                            <div class="profile-btns">                                
                                <a href="javascript:void(0);" id="search-profile-follow-{{searchProfile.user_id}}" ng-click="followSearch(searchProfile.user_id)" ng-if="!searchProfile.follow_status" class="btn3" title="Follow">Follow</a>
                                <a href="javascript:void(0);" id="search-profile-follow-{{searchProfile.user_id}}" ng-click="followSearch(searchProfile.user_id)" ng-if="searchProfile.follow_status == '1'" class="btn1" title="Following">Following</a>                                
                            </div>
                        </div>
                    </div>
                    <div class="availabel-data-box" ng-if="postData.length != '0'">
                        <h3>Posts </h3>
                        <div class="post_loader" style="text-align:center;">
                            <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                        </div>
                        <div class="p10 mobp0">
                            <div ng-if="postData.length != 0" class="all-post-box" ng-repeat="post in postData" ng-init="postIndex=$index">
                                <input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_data.page}}">
                                <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.page_data.total_record}}">
                                <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.page_data.perpage_record}}">
                                <div class="all-post-top">
                                    <div class="post-head">
                                        <div class="post-img" ng-if="post.post_data.post_for == 'question' && post.user_data.user_image !=''">
                                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != '' && post.question_data.is_anonymously == '0'">
                                            </a>
                                        </div>
                                        <div class="post-img" ng-if="post.post_data.post_for == 'question' && post.user_data.user_image == ''">
                                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                                <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_image == '' && post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_image == '' && post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </a>
                                        </div>
                                        <div class="post-img" ng-if="post.post_data.post_for != 'question' && post.user_data.user_image != ''">
                                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}">
                                            </a>
                                        </div>
                                        <div class="post-img" ng-if="post.post_data.post_for != 'question' && post.user_data.user_image == ''">
                                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                                <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </a>
                                        </div>
                                        <div class="post-detail">
                                            <div class="fw" ng-if="post.post_data.post_for == 'question'">
                                                <a href="javascript:void(0)" class="post-name" ng-if="post.question_data.is_anonymously == '1'">Anonymous</a><span class="post-time" ng-if="post.question_data.is_anonymously == '1'"></span>
                                                <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" ng-if="post.question_data.is_anonymously == '0'"></a><span class="post-time" ng-if="post.question_data.is_anonymously == '0'">{{post.post_data.time_string}}</span>
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
                                        <div class="post-right-dropdown dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/right-down.png') ?>" alt="Right Down"></a>
                                            <ul class="dropdown-menu">
                                                <!-- <li><a href="javascript:void(0);" ng-click="EditPost(post.post_data.id, post.post_data.post_for, $index)">Edit Post</a></li> -->
                                                <li><a href="javascript:void(0);" ng-click="deletePost(post.post_data.id, $index)">Delete Post</a></li>
                                                <li>
                                                    <a ng-if="post.post_data.post_for != 'question'" href="<?php echo base_url(); ?>post-detail/{{post.post_data.id}}" target="_blank">Show in New Tab</a>
                                                    <a ng-if="post.post_data.post_for == 'question'" ng-href="<?php echo base_url('questions/');?>{{post.question_data.id}}/{{post.question_data.question| slugify}}" target="_blank">Show in New Tab</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="post-discription" ng-if="post.post_data.post_for == 'opportunity'">
                                        <h5 class="post-title">
                                            <p ng-if="post.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="post.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{post.post_data.id}}"></span></p>
                                            <p ng-if="post.opportunity_data.location"><b>Location:</b><span ng-bind="post.opportunity_data.location" id="opp-post-location-{{post.post_data.id}}"></span></p>
                                            <p ng-if="post.opportunity_data.field"><b>Field:</b><span ng-bind="post.opportunity_data.field" id="opp-post-field-{{post.post_data.id}}"></span></p>
                                        </h5>
                                        <div class="post-des-detail" ng-if="post.opportunity_data.opportunity">
                                            <div id="opp-post-opportunity-{{post.post_data.id}}" ng-class="post.opportunity_data.opportunity.length > 250 ? 'view-more-expand' : ''">
                                                <b>Opportunity:</b>
                                                <span ng-bind-html="post.opportunity_data.opportunity"></span>
                                                <a id="remove-view-more{{post.post_data.id}}" ng-if="post.opportunity_data.opportunity.length > 250" ng-click="removeViewMore('opp-post-opportunity-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-discription" ng-if="post.post_data.post_for == 'simple'">
                                        <div class="post-des-detail" ng-if="post.simple_data.description">
                                            <div ng-init="limit = 250; moreShown = false">
                                                <span ng-if="post.simple_data.description != ''" id="simple-post-description-{{post.post_data.id}}" ng-bind-html="post.simple_data.description" ng-class="post.simple_data.description.length > 250 ? 'view-more-expand' : ''">
                                                </span>
                                                <a id="remove-view-more{{post.post_data.id}}" ng-if="post.simple_data.description.length > 250" ng-click="removeViewMore('simple-post-description-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-discription" ng-if="post.post_data.post_for == 'question'">
                                        <h5 class="post-title">
                                            <p ng-if="post.question_data.question"><b>Question:</b><span ng-bind="post.question_data.question" id="ask-post-question-{{post.post_data.id}}"></span></p>

                                            <div class="post-des-detail" ng-if="post.question_data.description">
                                                <div id="ask-que-desc-{{post.post_data.id}}" ng-class="post.question_data.description.length > 250 ? 'view-more-expand' : ''">
                                                    <b>Description:</b>
                                                    <span ng-bind-html="post.question_data.description"></span>
                                                    <a id="remove-view-more{{post.post_data.id}}" ng-if="post.question_data.description.length > 250" ng-click="removeViewMore('ask-que-desc-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>
                                                </div>                                            
                                            </div>
                                            
                                            <p ng-if="post.question_data.link"><b>Link:</b><span ng-bind="post.question_data.link" id="ask-post-link-{{post.post_data.id}}"></span></p>
                                            <p ng-if="post.question_data.category"><b>Category:</b><span ng-bind="post.question_data.category" id="ask-post-category-{{post.post_data.id}}"></span></p>
                                            <p ng-if="post.question_data.field"><b>Field:</b><span ng-bind="post.question_data.field" id="ask-post-field-{{post.post_data.id}}"></span></p>
                                        </h5>
                                        <div class="post-des-detail" ng-if="post.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.opportunity_data.opportunity"></span></div>
                                    </div>
                                    <div class="post-images" ng-if="post.post_data.total_post_files == '1'">
                                        <div class="one-img" ng-repeat="post_file in post.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                            <a href="#" ng-if="post_file.file_type == 'image'">
                                                <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}"  ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)" />
                                            </a>
                                            <span  ng-if="post_file.file_type == 'video'"> 
                                                <video controls width = "100%" height = "350">
                                                    <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" type="video/mp4">
                                                </video>
                                                <!--<video controls poster="" class="mejs__player" ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}"></video>-->
                                            </span>
                                            <span  ng-if="post_file.file_type == 'audio'">
                                                <div class = "audio_main_div">
                                                    <div class = "audio_img">
                                                        <img src = "<?php echo base_url('assets/images/music-icon.png?ver=' . time()) ?>" alt="music-icon.png">
                                                    </div>
                                                    <div class = "audio_source">
                                                        <audio id = "audio_player" width = "100%" height = "40" controls>
                                                            <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" type="audio/mp3">
                                                            Your browser does not support the audio tag.
                                                        </audio>
                                                    </div>
                                                </div>
                                                <!--<audio controls ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}"></audio>-->
                                            </span>
                                            <a ng-href="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" target="_blank" title="Click Here" ng-if="post_file.file_type == 'pdf'"><img ng-src="<?php echo base_url('assets/images/PDF.jpg?ver=' . time()) ?>"></a>
                                        </div>
                                    </div>
                                    <div class="post-images" ng-if="post.post_data.total_post_files == '2'">
                                        <div class="two-img" ng-repeat="post_file in post.post_file_data">
                                            <a href="#"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                        </div>
                                    </div>
                                    <div class="post-images" ng-if="post.post_data.total_post_files == '3'">
                                        <span ng-repeat="post_file in post.post_file_data">
                                            <div class="three-img-top" ng-if="$index == '0'">
                                                <a href="#"><img ng-src="<?php echo USER_POST_RESIZE4_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                            </div>
                                            <div class="two-img" ng-if="$index == '1'">
                                                <a href="#"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                            </div>
                                            <div class="two-img" ng-if="$index == '2'">
                                                <a href="#"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="post-images four-img" ng-if="post.post_data.total_post_files >= '4'">
                                        <div class="two-img" ng-repeat="post_file in post.post_file_data| limitTo:4">
                                            <a href="#"><img ng-src="<?php echo USER_POST_RESIZE2_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                            <div class="view-more-img" ng-if="$index == '3' && post.post_data.total_post_files > '4'">
                                                <span><a href="javascript:void(0);" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)">View All ({{post.post_data.total_post_files - 4}})</a></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-bottom">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <ul class="bottom-left">
                                                    <li>
                                                        <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id)" ng-if="post.is_userlikePost == '1'" class="like"><i class="fa fa-thumbs-up"></i></a>
                                                        <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id)" ng-if="post.is_userlikePost == '0'"><i class="fa fa-thumbs-up"></i></a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" ng-click="viewAllComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length <= 1" id="comment-icon-{{post.post_data.id}}" class="last-comment"><i class="fa fa-comment-o"></i></a></li>
                                                    <li><a href="javascript:void(0);" ng-click="viewLastComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length > 1" id="comment-icon-{{post.post_data.id}}" class="all-comment"><i class="fa fa-comment-o"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <ul class="pull-right bottom-right">
                                                    <li class="like-count"><span id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span><span>Like</span></li>
                                                    <li class="comment-count"><span class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span><span>Comment</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="like-other-box">
                                        <a href="#" ng-click="like_user_list(post.post_data.id);" ng-bind="post.post_like_data" id="post-other-like-{{post.post_data.id}}"></a>
                                    </div>
                                </div>
                                <div class="all-post-bottom comment-for-post-{{post.post_data.id}}">
                                    <div class="comment-box">
                                        <div class="post-comment" ng-repeat="comment in post.post_comment_data" ng-init="commentIndex=$index">
                                            <div class="post-img">
                                                <div ng-if="comment.user_image != ''">
                                                    <a ng-href="<?php echo base_url() ?>{{comment.user_slug}}" class="post-name" target="_self">
                                                        <img ng-class="comment.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{comment.user_image}}">
                                                    </a>
                                                </div>
                                                <div class="post-img" ng-if="comment.user_image == ''">
                                                    <a ng-href="<?php echo base_url() ?>{{comment.user_slug}}" class="post-name" target="_self">
                                                        <img ng-class="comment.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" comment.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                        <img ng-class="comment.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" comment.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="comment-dis">
                                                <div class="comment-name"><a ng-href="<?php echo base_url() ?>{{comment.user_slug}}" class="post-name" target="_self" ng-bind="comment.username"></a></div>
                                                <div class="comment-dis-inner" id="comment-dis-inner-{{comment.comment_id}}" ng-bind-html="comment.comment"></div>
                                                <div class="edit-comment" id="edit-comment-{{comment.comment_id}}" style="display:none;">
                                                    <div class="comment-input">
                                                        <!--<div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" onpaste="OnPaste_StripFormatting(event);"></div>-->
                                                        <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}}, post.post_data.id)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="handlePaste($event)"></div>
                                                    </div>
                                                    <div class="mob-comment">
                                                        <button ng-click="sendEditComment(comment.comment_id, post.post_data.id)"><img ng-src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                                    </div>
                                                    
                                                    <div class="comment-submit hidden-mob">
                                                        <button class="btn2" ng-click="sendEditComment(comment.comment_id, post.post_data.id)">Save</button>
                                                    </div>
                                                </div>
                                                <ul class="comment-action">
                                                    <li ng-if="comment.is_userlikePostComment == '1'"><a href="javascript:void(0);" ng-click="likePostComment(comment.comment_id, post.post_data.id)" class="like"><i class="fa fa-thumbs-up"></i><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span></a></li>
                                                    <li ng-if="comment.is_userlikePostComment == '0'"><a href="javascript:void(0);" ng-click="likePostComment(comment.comment_id, post.post_data.id)"><i class="fa fa-thumbs-up"></i><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span></a></li>
                                                    <li ng-if="comment.commented_user_id == user_id" id="edit-comment-li-{{comment.comment_id}}"><a href="javascript:void(0);" ng-click="editPostComment(comment.comment_id, post.post_data.id, $parent.$index, $index)">Edit</a></li> 
                                                    <li id="cancel-comment-li-{{comment.comment_id}}" style="display: none;"><a href="javascript:void(0);" ng-click="cancelPostComment(comment.comment_id, post.post_data.id, $parent.$index, $index)">Cancel</a></li> 
                                                    <li ng-if="post.post_data.user_id == user_id || comment.commented_user_id == user_id"><a href="javascript:void(0);" ng-click="deletePostComment(comment.comment_id, post.post_data.id, postIndex, commentIndex, post)">Delete</a></li>
                                                    <li><a href="javascript:void(0);" ng-bind="comment.comment_time_string"></a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="add-comment new-comment-{{post.post_data.id}}">
                                            <div class="post-img">
                                                <?php 
                                                if ($leftbox_data['user_image'] != '')
                                                { ?> 
                                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '?ver=' . time() ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                                                <?php
                                                }
                                                else
                                                { 
                                                    if($leftbox_data['user_gender'] == "M")
                                                    {?>                                
                                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <?php
                                                    }
                                                    if($leftbox_data['user_gender'] == "F")
                                                    {
                                                    ?>
                                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                    <?php
                                                    }                                
                                                } ?>

                                            </div>
                                            <div class="comment-input">
                                                <div contenteditable="true" data-directive ng-model="comment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendComment({{post.post_data.id}},$index,post)" id="commentTaxBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" ng-paste="handlePaste($event)"></div>
                                            </div>
                                            <div class="mob-comment">
                                                <button ng-click="sendComment(post.post_data.id, $index, post)"><img ng-src="<?php echo base_url('assets/img/send.png') ?>"></button>
                                            </div>
                                            <div class="comment-submit hidden-mob">
                                                <button class="btn2" ng-click="sendComment(post.post_data.id, $index, post)">Comment</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="right-part">
                    <div class="add-box">
                        <img ng-src="<?php echo base_url('assets/n-images/add.jpg') ?>">
                    </div>
                    <div class="all-contact">
                        <h4>Contacts<a href="<?php echo base_url('contact-request') ?>" class="pull-right">All</a></h4>
                        <div class="all-user-list">
                            <data-owl-carousel class="owl-carousel" data-options="">
                                <div owl-carousel-item="" ng-repeat="contact in contactSuggetion" class="item">
                                    <div class="item" id="item-{{contact.user_id}}">
                                        <div class="post-img" ng-if="contact.user_image != ''">
                                            <a href="<?php echo base_url(); ?>{{contact.user_slug}}" target="_self" >
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contact.user_image}}">
                                            </a>
                                        </div>
                                        <div class="post-img" ng-if="contact.user_image == ''">
                                            <a href="<?php echo base_url(); ?>{{contact.user_slug}}" target="_self" >
                                                <img ng-if="contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-if="contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </a>
                                        </div>
                                        <div class="user-list-detail">
                                            <p class="contact-name">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-bind="(contact.first_name | limitTo:1 | uppercase) + (contact.first_name.substr(1) | lowercase)+' '+ (contact.last_name | limitTo:1 | uppercase) + (contact.last_name.substr(1) | lowercase)"></a>
                                            </p>
                                            <p class="contact-designation">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name != ''">{{contact.title_name| uppercase}}</a>
                                                <a href="profiles/{{contact.user_slug}}" ng-if="contact.title_name == ''">{{contact.degree_name| uppercase}}</a>
                                                <a href="profiles/{{contact.user_slug}}" ng-if="contact.title_name == null && contact.degree_name == null">CURRENT WORK</a>
                                            </p>
                                        </div>
                                        <button class="follow-btn" ng-click="addToContact(contact.user_id)">Add to contact</button>
                                    </div>
                                </div>
                                <div owl-carousel-item="" class="item last-item-box">
                                    <a href="<?php echo base_url('contact-request') ?>">
                                        <div class="item" id="last-item">
                                            <div class="post-img" ng-if="contact.user_image != ''">
                                                <img ng-src="<?php echo base_url('assets/n-images/view-all.png?ver=' . time()) ?>">
                                            </div>
                                            <div class="user-list-detail">
                                                <p class="contact-name">
                                                    <a href="<?php echo base_url(); ?>contact-request" target="_self">Find More Contacts</a>
                                                </p>
                                            </div>
                                            <button class="follow-btn"><a href="<?php echo base_url(); ?>contact-request" target="_self">View More</a></button>
                                        </div>
                                    </a>
                                </div>
                            </data-owl-carousel>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  poup modal  -->        
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
        <div class="modal fade message-box" id="delete_model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div class="pop_content">Do you want to delete this comment?<div class="model_ok_cancel"><a class="okbtn btn1" ng-click="deleteComment(c_d_comment_id, c_d_post_id, c_d_parent_index, c_d_index, c_d_post)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
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
                                      <a class="ripple" href="<?php echo base_url(); ?>{{userlist.user_slug}}" ng-if="userlist.user_image == '' || userlist.user_image == null">
                                        <img ng-if="userlist.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <img ng-if="userlist.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    </a>
                                    <div class="like-detail">
                                        <h4><a href="<?php echo base_url(); ?>{{userlist.user_slug}}">{{userlist.fullname}}</a></h4>
                                        <p ng-if="userlist.title_name == ''">{{userlist.degree_name}}</p>
                                        <p ng-if="userlist.title_name != null">{{userlist.title_name}}</p>
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
        <!-- Popup Model -->

        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
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
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script>
                                var base_url = '<?php echo base_url(); ?>';
                                var user_slug = '<?php echo $this->uri->segment(2); ?>';
                                var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
                                var searchKeyword = '<?php echo $search_keyword; ?>';
                                var app = angular.module("searchApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize']);
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_search.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
        <script>
            var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
                showRight = document.getElementById( 'showRight' ),
                body = document.body;

            showRight.onclick = function() {
                classie.toggle( this, 'active' );
                classie.toggle( menuRight, 'cbp-spmenu-open' );
                disableOther( 'showRight' );
            };
        
            function disableOther( button ) {
                
                if( button !== 'showRight' ) {
                    classie.toggle( showRight, 'disabled' );
                }
            }
            
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
    </body>
</html>