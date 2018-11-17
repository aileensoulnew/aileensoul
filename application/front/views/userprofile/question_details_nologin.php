<!DOCTYPE html>
<html lang="en" ng-app="questionDetailsApp" ng-controller="questionDetailsController">
    <head>
        <title ng-bind="title"></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">   
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); 
    $loging_userid = $this->session->userdata('aileenuser'); ?>
</head>
    <body class="profile-db body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
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
        <div class="middle-section middle-section-banner">
            <div class="container pt20 mobp0">
                <div class="left-part">
                    <div class="user-profile-box">
                        <div class="user-cover-img">
                            <a href="<?php echo base_url($leftbox_data['user_slug']) ?>">
                                <?php
                                if($leftbox_data['profile_background'] != '')
                                { ?>
                                    <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL.$leftbox_data['profile_background'] ?>" alt="<?php echo $leftbox_data['first_name'] ?>" class="bgImage">
                                <?php
                                }
                                else
                                {?>
                                    <div class="gradient-bg" style="height: 100%"></div>
                                <?php
                                }?>
                            </a>    
                        </div>
                        <div class="user-detail">
                            <div class="user-img">
                                <a href="<?php echo base_url($leftbox_data['user_slug']) ?>">
                                <?php
                                if ($leftbox_data['user_image'] != '')
                                { ?> 
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
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
                                </a>
                            </div>
                            <div class="user-detail-right">
                                <div class="user-detail-top">
                                    <h4>
                                        <a href="<?php echo base_url($leftbox_data['user_slug']) ?>" title="<?php echo ucfirst($leftbox_data['first_name']) . ' ' . ucfirst($leftbox_data['last_name']) ?>">
                                            <?php echo ucfirst($leftbox_data['first_name']) . ' ' . ucfirst($leftbox_data['last_name']) ?></a>
                                    </h4>
                                    <p>
                                        <a href="<?php echo base_url($leftbox_data['user_slug']) ?>">
                                            <?php
                                            if($leftbox_data['title_name'] == "")
                                            {
                                                echo $leftbox_data['degree_name'];
                                            }
                                            else if($leftbox_data['title_name'] != "")
                                            {
                                                echo $leftbox_data['title_name'];
                                            }
                                            else
                                            {
                                                echo "Self Employee";
                                            } ?>
                                        </a>
                                    </p>
                                </div>
                                <div class="user-detail-bottom">
                                    <ul>
                                        <li><a href="<?php echo base_url($leftbox_data['user_slug'].'/profiles') ?>">Profiles</a></li>
                                        <li><a href="<?php echo base_url($leftbox_data['user_slug']) ?>">Dashboard</a></li>
                                        <li><a href="<?php echo base_url($leftbox_data['user_slug'].'/details') ?>">Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="middle-part question-detail">
                    <div ng-if="postData.length != 0" class="all-post-box" ng-repeat="post in postData">
                        <div class="all-post-top">
                            <div class="post-head" ng-class="post.question_data.is_anonymously == '1' ? 'anonymous-que' : ''">
                                <div class="post-img" ng-if="post.post_data.post_for == 'question'">
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != '' && post.question_data.is_anonymously == '0'">
                                    <span class="no-img-post"  ng-if="post.user_data.user_image == '' || post.question_data.is_anonymously == '1'">A</span>
                                </div>
                                <div class="post-img" ng-if="post.post_data.post_for != 'question'">
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.user_data.user_image != ''">
                                    <span class="no-img-post" ng-bind="(post.user_data.first_name| limitTo:1 | uppercase) + (post.user_data.last_name | limitTo:1 | uppercase)"  ng-if="post.user_data.user_image == ''"></span>
                                </div>
                                <div class="post-detail">
                                    <div class="fw" ng-if="post.post_data.post_for == 'question'">
                                        <a href="javascript:void(0)" class="post-name" ng-if="post.question_data.is_anonymously == '1'">Anonymous</a><span class="post-time" ng-if="post.question_data.is_anonymously == '1'"></span>
                                        <a ng-href="<?php echo base_url('profiles/') ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" ng-if="post.question_data.is_anonymously == '0'"></a>
                                        <span class="post-time">{{post.post_data.time_string}}</span>
                                    </div>
                                    <div class="fw" ng-if="post.post_data.post_for != 'question'">
                                        <a ng-href="<?php echo base_url('profiles/') ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname"></a>
                                        <span class="post-time">{{post.post_data.time_string}}</span>
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
                            </div>
                            <div class="post-discription" ng-if="post.post_data.post_for == 'opportunity'">
                                <h5 class="post-title">
                                    <p ng-if="post.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="post.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.opportunity_data.location"><b>Location:</b><span ng-bind="post.opportunity_data.location" id="opp-post-location-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.opportunity_data.field"><b>Field:</b><span ng-bind="post.opportunity_data.field" id="opp-post-field-{{post.post_data.id}}"></span></p>
                                </h5>
                                <div class="post-des-detail" ng-if="post.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.opportunity_data.opportunity" id="opp-post-opportunity-{{post.post_data.id}}"></span></div>
                            </div>
                            <div class="post-discription" ng-if="post.post_data.post_for == 'simple'">
                                <div class="post-des-detail" ng-if="post.simple_data.description"><span ng-bind-html="post.simple_data.description" id="simple-post-description-{{post.post_data.id}}"></span></div>
                            </div>
                            <div class="post-discription" ng-if="post.post_data.post_for == 'profile_update'">
                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.profile_update.data_value}}">
                            </div>
                            <div class="post-discription" ng-if="post.post_data.post_for == 'cover_update'">
                                <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.cover_update.data_value}}" ng-if="post.cover_update.data_value != ''">
                            </div>
                            <div class="post-discription" ng-if="post.post_data.post_for == 'question'">
                                <div id="ask-que-{{post.post_data.id}}" class="post-des-detail">
                                    <h5 class="post-title">
                                        <div ng-if="post.question_data.question"><b>Question:</b><span ng-bind="post.question_data.question" id="ask-post-question-{{post.post_data.id}}"></span></div>                                        
                                        <div class="post-des-detail" ng-if="post.question_data.description">
                                            <div id="ask-que-desc-{{post.post_data.id}}" ng-class="post.question_data.description.length > 250 ? 'view-more-expand' : ''">
                                                <b>Description:</b>
                                                <span ng-bind-html="post.question_data.description"></span>
                                                <a id="remove-view-more{{post.post_data.id}}" ng-if="post.question_data.description.length > 250" ng-click="removeViewMore('ask-que-desc-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>
                                            </div>                                            
                                        </div>
                                        <p ng-if="post.question_data.link"><b>Link:</b><span id="ask-post-link-{{post.post_data.id}}" ng-bind-html="post.question_data.link | parseUrl"></span></p>
                                        <p ng-if="post.question_data.category"><b>Category:</b><span ng-bind="post.question_data.category" id="ask-post-category-{{post.post_data.id}}"></span></p>
                                        <p ng-if="post.question_data.field"><b>Field:</b><span ng-bind="post.question_data.field" id="ask-post-field-{{post.post_data.id}}"></span></p>
                                    </h5>
                                </div>
                                <div class="post-des-detail" ng-if="post.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.opportunity_data.opportunity"></span></div>
                                <!-- Edit Question Start -->
                                <div id="edit-ask-que-{{post.post_data.id}}" style="display: none;">
                                    <form id="ask_question" class="edit-question-form" name="ask_question" ng-submit="ask_question_check(event,$index)">
                                        <div class="post-box">                        
                                            <div class="post-text">                            
                                                <textarea class="title-text-area" ng-keyup="questionList()" id="ask_que_{{post.post_data.id}}" placeholder="Ask Question"></textarea>
                                                <ul class="questionSuggetion custom-scroll">
                                                    <li ng-repeat="que in queSearchResult">
                                                        <a ng-href="<?php echo base_url('questions/') ?>{{que.id}}/{{que.question| slugify}}" target="_self" ng-bind="que.question"></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="all-upload">                                    
                                                <div class="add-link" ng-click="ShowHide()">
                                                    <i class="fa fa fa-link upload_icon"><span class="upload_span_icon"> Add Link</span>  </i> 
                                                </div>
                                                <div class="form-group"  ng-show = "IsVisible">
                                                    <input type="url" id="ask_web_link_{{post.post_data.id}}" class="" placeholder="Add Your Web Link">
                                                </div>
                                            </div>                        
                                        </div>
                                        <div class="post-field">
                                            <div class="form-group">
                                                <label>Add Description<span class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></span></label>
                                                <textarea max-rows="5" id="ask_que_desc_{{post.post_data.id}}" placeholder="Add Description" cols="10"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Related Categories<span class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></span></label>
                                                <tags-input ng-model="ask.related_category_edit" display-property="name" placeholder="Related Category" replace-spaces-with-dashes="false" template="category-template" id="ask_related_category_edit{{post.post_data.id}}" on-tag-added="onKeyup()">
                                                    <auto-complete source="loadCategory($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="category-autocomplete-template"></auto-complete>
                                                </tags-input>
                                                <script type="text/ng-template" id="category-template">
                                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                                </script>
                                                <script type="text/ng-template" id="category-autocomplete-template">
                                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                                </script>
                                            </div>
                                            <div class="form-group">
                                                <label>From which field the Question asked?<span class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></span></label>
                                                <span class="select-field-custom">
                                                    <select ng-model="ask.ask_field" id="ask_field_{{post.post_data.id}}">
                                                        <option value="" selected="selected">What is your field</option>
                                                        <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                                        <option value="0">Other</option>
                                                    </select>
                                                </span>
                                            </div>

                                            <div class="form-group"  ng-if="ask.ask_field == '0'">
                                                <input id="ask_other_{{post.post_data.id}}" type="text" class="form-control" placeholder="Enter other field" ng-required="true" autocomplete="off" value="{{post.question_data.others_field}}">
                                            </div>
                                            <input type="hidden" name="post_for" ng-model="ask.post_for" class="form-control" value="question">
                                            <input type="hidden" id="ask_edit_post_id_{{$index}}" name="ask_edit_post_id" class="form-control" value="{{post.post_data.id}}">
                                        </div>
                                        <div class="text-right fw pt10 pb20">
                                            <div class="add-anonymously">
                                                <label class="control control--checkbox" title="Checked this">Add Anonymously<input type="checkbox" value="1" id="ask_is_anonymously{{post.post_data.id}}" ng-checked="post.question_data.is_anonymously == 1"><div class="control__indicator"></div></label>
                                            </div>
                                            <button type="submit" class="btn1" value="Submit">Save</button> 
                                        </div>
                                    </form>
                                </div>
                                <!-- Edit Question Start -->
                            </div>
                            <div class="post-images" ng-if="post.post_data.total_post_files == '1'">
                                        <div class="one-img" ng-repeat="post_file in post.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                            <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                                <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)">
                                            </a>
                                            <span ng-if="post_file.file_type == 'video'"> 
                                                <video controls width = "100%" height = "350" preload="metadata" poster="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}png">
                                                    <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}#t=0.1" type="video/mp4">
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
                                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                        </div>
                                    </div>
                                    <div class="post-images" ng-if="post.post_data.total_post_files == '3'">
                                        <span ng-repeat="post_file in post.post_file_data">
                                            <div class="three-img-top" ng-if="$index == '0'">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE4_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                            </div>
                                            <div class="two-img" ng-if="$index == '1'">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                            </div>
                                            <div class="two-img" ng-if="$index == '2'">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="post-images four-img" ng-if="post.post_data.total_post_files >= '4'">
                                        <div class="two-img" ng-repeat="post_file in post.post_file_data| limitTo:4">
                                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE2_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                            <div class="view-more-img" ng-if="$index == 3 && post.post_data.total_post_files > 4">
                                                <span><a href="javascript:void(0);" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)">View All ({{post.post_data.total_post_files - 4}})</a></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="myModal{{post.post_data.id}}" class="modal modal2" style="display: none;">
                                        <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModal'+post.post_data.id)">×</button>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                                </div>
                                                <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                                <div class="mySlides mySlides2{{post.post_data.id}}" ng-repeat="_photoData in post.post_file_data">
                                                    <div class="numbertext">{{$index + 1}} / {{post.post_data.total_post_files}}</div>
                                                    <div class="slider_img_p">
                                                        <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                                                    </div>
                                                </div>                                
                                            </div>
                                            <div class="caption-container">
                                                <p id="caption"></p>
                                            </div>
                                        </div> 
                                        <a ng-if="post.post_file_data.length > 1" class="prev" style="left:0px;" ng-click="plusSlides2(-1,post.post_data.id)">&#10094;</a>
                                        <a ng-if="post.post_file_data.length > 1" class="next" ng-click="plusSlides2(1,post.post_data.id)">&#10095;</a>
                                    </div>
                            <div class="post-bottom">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <ul class="bottom-left">
                                            <li>
                                                <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="no_login_pop(post.post_data.id)" ng-if="post.is_userlikePost == '1'" class="like"><i class="fa fa-thumbs-up"></i></a>
                                                <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="no_login_pop(post.post_data.id)" ng-if="post.is_userlikePost == '0'"><i class="fa fa-thumbs-up"></i></a>
                                            </li>
                                            <li><a href="javascript:void(0);" ng-click="viewAllComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length <= 1" id="comment-icon-{{post.post_data.id}}" class="last-comment"><i class="fa fa-comment-o"></i></a></li>
                                            <li><a href="javascript:void(0);" ng-click="viewLastComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length > 1" id="comment-icon-{{post.post_data.id}}" class="all-comment"><i class="fa fa-comment-o"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <ul class="pull-right bottom-right">
                                            <li class="like-count" ng-click="like_user_list(post.post_data.id);"><span id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count" style="{{post.post_like_count > 0 ? '' : 'display: none';}}"></span><span>Like</span></li>
                                            <!-- <li class="comment-count"><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span><span>Answers</span></li> -->
                                            <li><a href="javascript:void(0);" ng-click="viewAllComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length <= 1" id="comment-icon-{{post.post_data.id}}" class="last-comment"><span class="post-comment-count-{{post.post_data.id}}" style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" ng-bind="post.post_comment_count"></span><span>Answers</span></a></li>
                                            <li><a href="javascript:void(0);" ng-click="viewLastComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length > 1" id="comment-icon-{{post.post_data.id}}" class="all-comment"><span class="post-comment-count-{{post.post_data.id}}" style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" ng-bind="post.post_comment_count"></span><span>Answers</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="like-other-box">
                                <!-- <a href="#" ng-bind="post.post_like_data" id="post-other-like-{{post.post_data.id}}"></a> -->
                                <a href="#" ng-click="like_user_list(post.post_data.id);" ng-bind="post.post_like_data" id="post-other-like-{{post.post_data.id}}"></a>
                            </div>
                        </div>
                        <div class="ans-text" ng-if="post.post_comment_data.length !='0'"><span>Answers</span></div>
                        <div class="all-post-bottom comment-for-post-{{post.post_data.id}}">
                            <div class="comment-box">
                                <div id="cmt-{{comment.comment_id}}" class="post-comment" ng-repeat="comment in post.post_comment_data">
                                    <div class="post-img">
                                        <div ng-if="comment.user_image != ''">
                                            <a ng-href="<?php echo base_url() ?>{{comment.user_slug}}" class="post-name" target="_self">
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{comment.user_image}}">
                                            </a>
                                        </div>
                                        <div class="post-img" ng-if="comment.user_image == ''">
                                            <a ng-href="<?php echo base_url() ?>{{comment.user_slug}}" class="post-name" target="_self">
                                                <img ng-class="comment.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" comment.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-class="comment.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="comment.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </a>
                                            <!-- <div class="post-img-mainuser">{{comment.first_name| limitTo:1 | uppercase}}{{comment.last_name| limitTo:1 | uppercase}}</div> -->
                                        </div>
                                    </div>
                                    <div class="comment-dis">
                                        <div class="comment-name"><a ng-href="<?php echo base_url() ?>{{comment.user_slug}}" ng-bind="comment.username"></a></div>
                                        <div class="comment-dis-inner" id="comment-dis-inner-{{comment.comment_id}}" ng-bind-html="comment.comment"></div>
                                        <div class="edit-comment" id="edit-comment-{{comment.comment_id}}" style="display:none;">
                                            <div class="comment-input">
                                                <!--<div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" onpaste="OnPaste_StripFormatting(event);"></div>-->
                                                <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},{{ post.post_data.id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="handlePaste($event)"></div>
                                            </div>
                                            <div class="mob-comment">
                                                <button ng-click="no_login_pop(comment.comment_id, post.post_data.id)"><img ng-src="<?php echo base_url('assets/img/send.png') ?>"></button>
                                            </div>
                                            <div class="comment-submit hidden-mob">
                                                <button class="btn2" ng-click="no_login_pop(comment.comment_id, post.post_data.id)">Comment</button>
                                            </div>
                                        </div>
                                        <ul class="comment-action">
                                            <li><a href="javascript:void(0);" ng-click="no_login_pop(comment.comment_id, post.post_data.id)" ng-if="comment.is_userlikePostComment == '1'" class="like"><i class="fa fa-thumbs-up"></i><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span></a></li>

                                            <li><a href="javascript:void(0);" ng-click="no_login_pop(comment.comment_id, post.post_data.id)" ng-if="comment.is_userlikePostComment == '0'"><i class="fa fa-thumbs-up"></i><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span></a></li>

                                            <li><a href="javascript:void(0);" ng-click="no_login_pop(comment.comment_id, post.post_data.id)" ng-if="comment.is_userlikePostComment != '0' && comment.is_userlikePostComment != '1'"><i class="fa fa-thumbs-up"></i><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span></a></li>

                                            <li ng-if="post.post_data.user_id == user_id || comment.commented_user_id == user_id" id="edit-comment-li-{{comment.comment_id}}"><a href="javascript:void(0);" ng-click="no_login_pop(comment.comment_id, post.post_data.id, $parent.$index, $index)">Edit</a></li> 

                                            <li id="cancel-comment-li-{{comment.comment_id}}" style="display: none;"><a href="javascript:void(0);" ng-click="cancelPostComment(comment.comment_id, post.post_data.id, $parent.$index, $index)">Cancel</a></li> 

                                            <li ng-if="post.post_data.user_id == user_id || comment.commented_user_id == user_id"><a href="javascript:void(0);" class="del_comment" ng-click="no_login_pop(comment.comment_id, post.post_data.id, $parent.$index, $index, post)">Delete</a></li>

                                            <li><a href="javascript:void(0);" ng-bind="comment.comment_time_string"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="tab-add">
						<?php $this->load->view('banner_add'); ?>
					</div>
                </div>
                <div class="right-part">
                   <?php $this->load->view('right_add_box'); ?>
                </div>


            </div>
        </div>
        </div>
        <?php        
        echo $login_footer;
        echo $footer;        
        ?>
        <div class="modal fade message-box" id="delete_model" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div class="pop_content">Do you want to delete this comment?<div class="model_ok_cancel"><a class="okbtn btn1" ng-click="deleteComment(c_d_comment_id, c_d_post_id, c_d_parent_index, c_d_index, c_d_post)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                        </span>
                    </div>
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
                                        <h4><a href="<?php echo base_url(); ?>{{userlist.user_slug}}">{{(userlist.user_id == '<?php echo $loging_userid; ?>' ? 'You' : userlist.fullname)}}</a></h4>
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
        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror" id="bidmodal" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script src="//anglibs.github.io/angular-location-update/angular-location-update.min.js"></script>

        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var question = '<?php echo $question_id ?>';
            var title = '<?php echo $title ?>';
            var app = angular.module("questionDetailsApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','ngLocationUpdate']);
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/question_details.js?ver=' . time()) ?>"></script>
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
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "QAPage",
            "name": "<?php echo $question_data['question']; ?>",
            "description": "<?php echo $question_data['description']; ?>"
        }
        </script>

        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Question",
            "name": "<?php echo $question_data['question']; ?>",
            "upvoteCount": "<?php echo ($question_data['post_like_count'] != "" ? $question_data['post_like_count'] : 0); ?>",
            "text": "<?php echo $question_data['description']; ?>",
            "dateCreated": "<?php echo date('Y-m-d', strtotime($question_data['created_date'])); ?>",
            "author": {
                "@type": "Person",
                "name": "<?php echo ($question_data['is_anonymously'] == 1 ? "Anonymous" :ucfirst($leftbox_data['first_name']) . ' ' . ucfirst($leftbox_data['last_name'])) ?>"
            },
            "answerCount": "<?php echo $question_data['post_comment_count']; ?>"
         }
        </script>
        <?php
        foreach ($question_data['post_comment_data'] as $key => $value) { ?>            
            <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "Answer",
                "upvoteCount": "<?php echo ($value['postCommentLikeCount'] != "" ? $value['postCommentLikeCount'] : 0); ?>",
                "text": "<?php echo $value['comment']; ?>",
                "dateCreated": "<?php echo date('Y-m-d', strtotime($value['created_date'])); ?>",
                "author": {
                    "@type": "Person",
                    "name": "<?php echo $value['username']; ?>"
                }   
             }
            </script>
        <?php
        }
        ?>

    </body>
</html>