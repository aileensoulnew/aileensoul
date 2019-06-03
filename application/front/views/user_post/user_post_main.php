<div class="left-section">
    <?php echo $n_leftbar; ?>
</div>
<div class="middle-section op-middle">    
    <div class="add-post">
        <div class="post-box">
                <?php if ($leftbox_data['user_image'] != '') { ?> 
                <div class="post-img">
                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                </div>
                <?php } else { 
                    
                echo '<div class="post-img no-profile-pic">';
                    
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
                echo "</div>";
                    } ?>
                
            <div id="post_opportunity_box" class="post-text" data-target="#post-popup" data-toggle="modal" onclick="void(0)">
                Express Yourself 
            </div>
            <!--<span class="post-cam"><i class="fa fa-camera"></i></span>-->
        </div>
        <div class="post-box-bottom">
            <ul>
                <li>
                    <a href="#" data-target="#opportunity-popup" data-toggle="modal">
                        <img src="<?php echo base_url('assets/n-images/post-op.svg') ?>"><span><span class="none-479">Post</span> <span> Opportunity</span></span>
                    </a>
                </li>
                <li class="pl15">
                    <a href="<?php echo base_url('new-article'); ?>" target="_self">
                        <img src="<?php echo base_url('assets/n-images/article.svg') ?>"><span><span class="none-479">Post</span> <span> Article</span></span>
                    </a>
                </li>
                <li class="pl15">
                    <a href="#" data-target="#ask-question" data-toggle="modal">
                        <img src="<?php echo base_url('assets/n-images/ask-question.svg') ?>"><span>Ask Question</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="bs-example">
        <div class="progress progress-striped" id="progress_div" style="display: none;">
            <div class="progress-bar" style="width: 10%;">
                <span class="sr-only">0%</span>
            </div>
        </div>
    </div>
    <div class="mob-progressbar fw">
        <p>Complete your profile to get connected with more people.</p>
        <p class="mob-edit-pro">
            <a href="<?php echo base_url().$this->session->userdata('aileenuser_slug').'/details' ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Profile</a>
        </p>
        <div class="progress skill-bar ">
            <div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                <span class="skill"><i class="val">0%</i></span>
            </div>
        </div>
    </div>

    <!-- Repeated Class Start -->
    <div class="all_user_post">        
        <div  class="user_no_post_avl" ng-if="postData.length == 0 || postData == ' null' || postData == 'null'"><h3>Feed</h3>
            <div class="user-img-nn">
                <div class="user_no_post_img">
                    <img src="<?php echo base_url('assets/img/bui-no.png'); ?>" alt="bui-no.png">
                </div>
                <div class="art_no_post_text">No Feed Available.</div>
            </div>
        </div>

        <div class="fw post_loader" style="text-align:center; display: none;">
            <img ng-src="<?php echo base_url('assets/images/loader.gif') . '' ?>" alt="Loader" />
        </div>
        <!-- Feed Start -->
        <div id="post-fail" class="user_no_post_avl" style="display: none;">
            <div class="user-img-nn">Please try again later.</div>
        </div>

        <div id="main-post-{{recentpost.post_data.id}}" class="all-post-box" ng-show="IsVisible" ng-init="postIndex=$index">
            <div class="all-post-top">
                <div class="post-head" ng-class="recentpost.question_data.is_anonymously == '1' ? 'anonymous-que' : ''">
                    <div class="post-img" ng-if="recentpost.post_data.post_for == 'question'">
                        <a ng-href="<?php echo base_url() ?>{{recentpost.user_data.user_slug}}" class="post-name" target="_self" ng-if="recentpost.question_data.is_anonymously == '0'">
                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{recentpost.user_data.user_image}}" ng-if="
                            recentpost.user_data.user_image != '' && recentpost.question_data.is_anonymously == '0'">
                            <img ng-class="recentpost.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="recentpost.user_data.user_image == '' && recentpost.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                            <img ng-class="recentpost.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="recentpost.user_data.user_image == '' && recentpost.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                        </a>
                                        
                        <span class="no-img-post"  ng-if="recentpost.user_data.user_image == '' || recentpost.question_data.is_anonymously == '1'">A</span>
                    </div>
                                    
                    <div class="post-img" ng-if="recentpost.post_data.post_for != 'question' && recentpost.user_data.user_image != ''">
                        <a ng-href="<?php echo base_url() ?>{{recentpost.user_data.user_slug}}" class="post-name" target="_self">
                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{recentpost.user_data.user_image}}">
                        </a>
                    </div>
                                    
                    <div class="post-img no-profile-pic" ng-if="recentpost.post_data.post_for != 'question' && recentpost.user_data.user_image == ''">
                        <a ng-href="<?php echo base_url() ?>{{recentpost.user_data.user_slug}}" class="post-name" target="_self">
                            <img ng-class="recentpost.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="recentpost.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                            <img ng-class="recentpost.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="recentpost.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                        </a>
                    </div>
                                    
                    <div class="post-detail">
                        <div class="fw" ng-if="recentpost.post_data.post_for == 'question'">
                            <a href="javascript:void(0)" class="post-name" ng-if="recentpost.question_data.is_anonymously == '1'">Anonymous</a>
                            <span class="post-time" ng-if="recentpost.question_data.is_anonymously == '1'"></span>
                            <a ng-href="<?php echo base_url() ?>{{recentpost.user_data.user_slug}}" class="post-name" ng-bind="recentpost.user_data.fullname" ng-if="recentpost.question_data.is_anonymously == '0'"></a><span class="post-time">{{recentpost.post_data.time_string}}</span>
                        </div>
                                        
                        <div class="fw" ng-if="recentpost.post_data.post_for != 'question'">
                            <a ng-href="<?php echo base_url() ?>{{recentpost.user_data.user_slug}}" class="post-name" ng-bind="recentpost.user_data.fullname"></a><span class="post-time">{{recentpost.post_data.time_string}}</span>
                        </div>
                                        
                        <div class="fw" ng-if="recentpost.post_data.post_for == 'question'">
                            <span class="post-designation" ng-if="recentpost.user_data.title_name != null && recentpost.question_data.is_anonymously == '0'" ng-bind="recentpost.user_data.title_name"></span>
                            <span class="post-designation" ng-if="recentpost.user_data.title_name == null && recentpost.question_data.is_anonymously == '0'" ng-bind="recentpost.user_data.degree_name"></span>
                            <span class="post-designation" ng-if="recentpost.user_data.title_name == null && recentpost.user_data.degree_name == null && recentpost.question_data.is_anonymously == '0'">CURRENT WORK</span>
                        </div>
                        <div class="fw" ng-if="recentpost.post_data.post_for != 'question'">
                            <span class="post-designation" ng-if="recentpost.user_data.title_name != null" ng-bind="recentpost.user_data.title_name"></span>
                            <span class="post-designation" ng-if="recentpost.user_data.title_name == null" ng-bind="recentpost.user_data.degree_name"></span>
                            <span class="post-designation" ng-if="recentpost.user_data.title_name == null && recentpost.user_data.degree_name == null">CURRENT WORK</span>
                        </div>
                    </div>
                    <div class="post-right-dropdown dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/right-down.png') ?>" alt="Right Down"></a>
                        <ul class="dropdown-menu">

                            <li ng-if="live_slug == recentpost.user_data.user_slug && recentpost.post_data.post_for != 'profile_update' && recentpost.post_data.post_for != 'cover_update'"><a href="javascript:void(0);" ng-click="deleteRecentPost(recentpost.post_data.id, $index)">Delete Post</a></li>
                            <li>
                                <a ng-if="recentpost.is_user_saved_post == '0'" href="javascript:void(0);" class="save-recentpost-{{recentpost.post_data.id}}" ng-click="save_recent_post(recentpost.post_data.id,recentpost)">Save Post</a>
                                <a ng-if="recentpost.is_user_saved_post == '1'" href="javascript:void(0);">Saved Post</a>

                                <a ng-if="recentpost.post_data.post_for != 'question' && recentpost.post_data.post_for == 'article'" href="<?php echo base_url(); ?>article/{{recentpost.article_data.article_slug}}" target="_blank">Show in new tab</a>
                                <a ng-if="recentpost.post_data.post_for != 'question' && recentpost.post_data.post_for != 'article' && recentpost.post_data.post_for == 'opportunity'" href="<?php echo base_url(); ?>o/{{recentpost.opportunity_data.oppslug}}" target="_blank">Show in new tab</a>
                                <a ng-if="recentpost.post_data.post_for != 'question' && recentpost.post_data.post_for != 'article' && recentpost.post_data.post_for != 'opportunity' && recentpost.post_data.post_for == 'simple'" href="<?php echo base_url(); ?>p/{{recentpost.simple_data.simslug}}" target="_blank">Show in new tab</a>                                
                                <a ng-if="recentpost.post_data.post_for == 'question'" ng-href="<?php echo base_url('questions/');?>{{recentpost.question_data.id}}/{{recentpost.question_data.question| slugify}}" target="_blank">Show in new tab</a>
                            </li>
                            <li ng-if="live_slug != recentpost.user_data.user_slug">
                                <a ng-click="open_report_spam(recentpost.post_data.id)" href="javascript:void(0);">Report</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="post-discription" ng-if="recentpost.post_data.post_for == 'opportunity'">
                    
                    <div id="post-opp-detail-{{recentpost.post_data.id}}">
                        <h5 class="post-title">
                            <p ng-if="recentpost.opportunity_data.opptitle"><b>Title of Opportunity:</b><span ng-bind="recentpost.opportunity_data.opptitle" id="opp-title-{{recentpost.post_data.id}}"></span></p>
                            <p ng-if="recentpost.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="recentpost.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{recentpost.post_data.id}}"></span></p>
                            <p ng-if="recentpost.opportunity_data.location"><b>Location:</b><span ng-bind="recentpost.opportunity_data.location" id="opp-post-location-{{recentpost.post_data.id}}"></span></p>
                            <p ng-if="recentpost.opportunity_data.field"><b>Field:</b><span ng-bind="recentpost.opportunity_data.field" id="opp-post-field-{{recentpost.post_data.id}}"></span></p>
                            <p ng-if="!recentpost.opportunity_data.field || recentpost.opportunity_data.field == 0"><b>Field:</b><span ng-bind="recentpost.opportunity_data.other_field" id="opp-recentpost-field-{{recentpost.post_data.id}}"></span></p>
                            <p ng-if="recentpost.opportunity_data.hashtag" class="hashtag-grd"><b>Hashtags:</b>                                    
                                <span>
                                    <span class="post-hash-tag" id="opp-post-hashtag-{{post.post_data.id}}" ng-repeat="hashtag in recentpost.opportunity_data.hashtag.split(' ')">{{hashtag}}</span>
                                </span>
                            </p>                            
                            <p ng-if="recentpost.opportunity_data.company_name"><b>Company Name:</b><span ng-bind="recentpost.opportunity_data.company_name" id="opp-recpost-company-{{recentpost.post_data.id}}"></span></p>
                        </h5>
                        <div class="post-des-detail" ng-if="recentpost.opportunity_data.opportunity">
                            <div id="opp-post-opportunity-{{recentpost.post_data.id}}" ng-class="recentpost.opportunity_data.opportunity.length > 250 ? 'view-more-expand' : ''">
                                <b>Opportunity:</b>
                                <span ng-bind-html="recentpost.opportunity_data.opportunity"></span>
                                <a id="remove-view-more{{recentpost.post_data.id}}" ng-if="recentpost.opportunity_data.opportunity.length > 250" ng-click="removeViewMore('opp-post-opportunity-'+recentpost.post_data.id,'remove-view-more'+recentpost.post_data.id);" class="read-more-post">.... Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post-discription" ng-if="recentpost.post_data.post_for == 'simple'">
                    <p id="simple-recentpost-title-{{recentpost.post_data.id}}" ng-if="recentpost.simple_data.sim_title">
                        <b>Title:</b>
                        <span ng-bind="recentpost.simple_data.sim_title"></span>
                    </p>
                    <p id="simple-recentpost-hashtag-{{recentpost.post_data.id}}" ng-if="recentpost.simple_data.hashtag" class="hashtag-grd">
                        <b>Hashtags:</b>
                        <span>
                            <span class="post-hash-tag" id="sim-recentpost-hashtag-{{recentpost.post_data.id}}" ng-repeat="hashtag in recentpost.simple_data.hashtag.split(' ')">{{hashtag}}</span>
                        </span>
                    </p>                   

                    <div ng-init="limit = 250; moreShown = false">
                        <span ng-if="recentpost.simple_data.description != ''" id="simple-post-description-{{recentpost.post_data.id}}" ng-bind-html="recentpost.simple_data.description" ng-class="recentpost.simple_data.description.length > 250 ? 'view-more-expand' : ''">
                        </span>
                        <a id="remove-view-more{{recentpost.post_data.id}}" ng-if="recentpost.simple_data.description.length > 250" ng-click="removeViewMore('simple-post-description-'+recentpost.post_data.id,'remove-view-more'+recentpost.post_data.id);" class="read-more-post">.... Read More</a>                            
                    </div>                    
                </div>
                
                <div class="post-discription" ng-if="recentpost.post_data.post_for == 'article'">
                    <p ng-if="recentpost.article_data.hashtag" class="hashtag-grd">
                        <span>
                            <span class="post-hash-tag" id="opp-post-hashtag-{{recentpost.article_data.id}}" ng-repeat="hashtag in recentpost.article_data.hashtag.split(' ')">{{hashtag}}</span>
                        </span>
                    </p>
                </div>
                <div class="post-images article-post-cus" ng-if="recentpost.post_data.post_for == 'article'">
                    <div class="one-img" ng-class="recentpost.article_data.article_featured_image == '' ? 'article-default-featured' : ''">
                        <a href="<?php echo base_url(); ?>article/{{recentpost.article_data.article_slug}}" target="_self">
                            <img ng-src="<?php echo base_url().$this->config->item('article_featured_upload_path'); ?>{{recentpost.article_data.article_featured_image}}" alt="{{recentpost.article_data.article_title}}" ng-if="recentpost.article_data.article_featured_image != ''">

                            <img ng-src="<?php echo base_url('assets/img/art-default.jpg'); ?>{{recentpost.article_data.article_featured_image}}" alt="{{recentpost.article_data.article_title}}" ng-if="recentpost.article_data.article_featured_image == ''">
                            <div class="article-post-text">
                                <h3>{{recentpost.article_data.article_title}}</h3>
                                <p>{{recentpost.user_data.fullname}}'s Article on Aileensoul</p>
                            </div>
                        </a>                            
                    </div>
                </div>
                <div class="post-discription" ng-if="recentpost.post_data.post_for == 'profile_update'">
                    <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{recentpost.profile_update.data_value}}" ng-click="openModal2('myModalCoverPic'+recentpost.post_data.id);">
                </div>
                <div class="post-discription" ng-if="recentpost.post_data.post_for == 'cover_update'">
                    <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{recentpost.cover_update.data_value}}" ng-if="recentpost.cover_update.data_value != ''" ng-click="openModal2('myModalCoverPic'+recentpost.post_data.id);">
                </div>
                <div ng-if="recentpost.post_data.post_for == 'profile_update' || recentpost.post_data.post_for == 'cover_update'" id="myModalCoverPic{{recentpost.post_data.id}}" class="modal modal2" style="display: none;">
                    <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModalCoverPic'+recentpost.post_data.id)">×</button>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
                                <img ng-src="<?php echo base_url('assets/images/loader.gif') . '' ?>" alt="Loader" />
                            </div>
                            <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                            <div class="mySlides mySlides2{{recentpost.post_data.id}}">
                                <div class="numbertext"></div>
                                <div class="slider_img_p" ng-if="recentpost.post_data.post_for == 'cover_update'">
                                    <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{recentpost.cover_update.data_value}}" alt="Cover Image" id="cover{{recentpost.post_data.id}}">
                                </div>
                                <div class="slider_img_p" ng-if="recentpost.post_data.post_for == 'profile_update'">
                                    <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{recentpost.profile_update.data_value}}" alt="Profile Image" id="cover{{recentpost.post_data.id}}">
                                </div>
                            </div>                                
                        </div>
                        <div class="caption-container">
                            <p id="caption"></p>
                        </div>
                    </div>
                </div>
                <div class="post-discription" ng-if="recentpost.post_data.post_for == 'question'">
                    <div id="ask-que-{{recentpost.post_data.id}}" class="post-des-detail">
                        <h5 class="post-title">
                            <div ng-if="recentpost.question_data.question"><b>Question:</b><span ng-bind="recentpost.question_data.question" id="ask-post-question-{{recentpost.post_data.id}}"></span></div>                                        
                            <div class="post-des-detail" ng-if="recentpost.question_data.description">
                                <div id="ask-que-desc-{{recentpost.post_data.id}}" ng-class="recentpost.question_data.description.length > 250 ? 'view-more-expand' : ''">
                                    <b>Description:</b>
                                    <span ng-bind-html="recentpost.question_data.description"></span>
                                    <a id="remove-view-more{{recentpost.post_data.id}}" ng-if="recentpost.question_data.description.length > 250" ng-click="removeViewMore('ask-que-desc-'+recentpost.post_data.id,'remove-view-more'+recentpost.post_data.id);" class="read-more-post">.... Read More</a>
                                </div>                                            
                            </div>
                            <p ng-if="recentpost.question_data.link"><b>Link:</b><span id="ask-post-link-{{recentpost.post_data.id}}" ng-bind-html="recentpost.question_data.link | parseUrl"></span></p>
                            <p ng-if="recentpost.question_data.category"><b>Category:</b><span ng-bind="recentpost.question_data.category" id="ask-post-category-{{recentpost.post_data.id}}"></span></p>
                            <p ng-if="recentpost.question_data.hashtag"><b>Hashtag:</b><span ng-bind="recentpost.question_data.hashtag" class="post-hash-tag" id="ask-post-hashtag-{{recentpost.post_data.id}}"></span></p>
                            <p ng-if="recentpost.question_data.field"><b>Field:</b><span ng-bind="recentpost.question_data.field" id="ask-post-field-{{recentpost.post_data.id}}"></span></p>
                        </h5>
                        <div class="post-des-detail" ng-if="recentpost.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="recentpost.opportunity_data.opportunity"></span></div>
                    </div>                   
                    
                </div>
                <div class="post-images" ng-if="recentpost.post_data.total_post_files == 1">
                    <div class="one-img" ng-repeat="post_file in recentpost.post_file_data" ng-init="$last ? loadMediaElement() : false">
                        <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                            <img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+recentpost.post_data.id);currentSlide2($index + 1,'myModal'+recentpost.post_data.id)">
                        </a>
                        <span ng-if="post_file.file_type == 'video'"> 
                            <video controls width = "100%" height = "350" ng-attr-poster="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}jpg" preload="none">
                                <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}#t=0.1" type="video/mp4">
                            </video>
                            <!--<video controls poster="" class="mejs__player" ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}"></video>-->
                        </span>
                        <span  ng-if="post_file.file_type == 'audio'">
                            <div class = "audio_main_div">
                                <div class = "audio_img">
                                    <img src = "<?php echo base_url('assets/images/music-icon.png') ?>" alt="music-icon.png">
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
                        <a ng-href="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" target="_blank" title="Click Here" ng-if="post_file.file_type == 'pdf'"><img ng-src="<?php echo base_url('assets/images/PDF.jpg') ?>"></a>
                    </div>
                </div>
                
                <div class="post-images" ng-if="recentpost.post_data.total_post_files == 2">
                    <div class="two-img" ng-repeat="post_file in recentpost.post_file_data">
                        <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModal'+recentpost.post_data.id);currentSlide2($index + 1,'myModal'+recentpost.post_data.id)"></a>
                    </div>
                </div>
                <div class="post-images" ng-if="recentpost.post_data.total_post_files == 3">
                    <span ng-repeat="post_file in recentpost.post_file_data">
                        <div class="three-img-top" ng-if="$index == '0'">
                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+recentpost.post_data.id);currentSlide2($index + 1,'myModal'+recentpost.post_data.id)"></a>
                        </div>
                        <div class="two-img" ng-if="$index == '1'">
                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+recentpost.post_data.id);currentSlide2($index + 1,'myModal'+recentpost.post_data.id)"></a>
                        </div>
                        <div class="two-img" ng-if="$index == '2'">
                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+recentpost.post_data.id);currentSlide2($index + 1,'myModal'+recentpost.post_data.id)"></a>
                        </div>
                    </span>
                </div>
                <div class="post-images four-img" ng-if="recentpost.post_data.total_post_files >= 4">
                    <div class="two-img" ng-repeat="post_file in recentpost.post_file_data| limitTo:4">
                        <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+recentpost.post_data.id);currentSlide2($index + 1,'myModal'+recentpost.post_data.id)"></a>
                        <div class="view-more-img" ng-if="$index == 3 && recentpost.post_data.total_post_files > 4">
                            <span><a href="javascript:void(0);" ng-click="openModal2('myModal'+recentpost.post_data.id);currentSlide2($index + 1,'myModal'+recentpost.post_data.id)">View All ({{recentpost.post_data.total_post_files - 4}})</a></span>
                        </div>
                    </div>
                </div>
                <div id="myModal{{recentpost.post_data.id}}" class="modal modal2" style="display: none;">
                    <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModal'+recentpost.post_data.id)">×</button>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;"><img ng-src="<?php echo base_url('assets/images/loader.gif') . '' ?>" alt="Loader" />
                            </div>
                            <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                            <div class="mySlides myModal{{recentpost.post_data.id}}" ng-if="recentpost.post_data.post_for != 'article'" ng-repeat="_photoData in recentpost.post_file_data">
                                <div class="numbertext">{{$index + 1}} / {{recentpost.post_data.total_post_files}}</div>
                                <div class="slider_img_p">
                                    <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                                </div>
                            </div>
                            <!-- <div class="mySlides mySlides2{{recentpost.post_data.id}}" ng-if="recentpost.post_data.post_for == 'article' && recentpost.article_data.article_featured_image != ''">
                                <div class="numbertext">1</div>
                                <div class="slider_img_p">
                                    <img ng-src="<?php //echo base_url().$this->config->item('article_featured_upload_path'); ?>{{recentpost.article_data.article_featured_image}}" alt="Image-1" id="element_load_1">
                                </div>
                            </div>  -->
                        </div>
                        <div class="caption-container">
                            <p id="caption"></p>
                        </div>
                    </div> 
                    <a ng-if="recentpost.post_file_data.length > 1" class="prev" style="left:0px;" ng-click="plusSlides2(-1,'myModal'+recentpost.post_data.id)">&#10094;</a>
                    <a ng-if="recentpost.post_file_data.length > 1" class="next" ng-click="plusSlides2(1,'myModal'+recentpost.post_data.id)">&#10095;</a>
                </div>
                <div class="post-bottom">
                        <div class="like-list">
                            <ul id="" class="bottom-left like_user_list">
                                <li class="like-img" ng-if="recentpost.user_like_list.length > 0" ng-repeat="user_like in recentpost.user_like_list">
                                    <a class="ripple" href="<?php echo base_url(); ?>{{user_like.user_slug}}" target="_self" title="{{user_like.fullname}}">
                                        <img ng-if="user_like.user_image" ng-src="<?php echo USER_THUMB_UPLOAD_URL; ?>{{user_like.user_image}}">
                                        <img ng-if="!user_like.user_image && user_like.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <img ng-if="!user_like.user_image && user_like.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    </a>
                                </li>                                   
                                <li class="like-img">
                                    <a href="javascript:void(0)" ng-click="like_user_list(recentpost.post_data.id);" ng-bind="recentpost.post_like_data" id="recentpost-other-like-{{recentpost.post_data.id}}"></a>
                                </li>
                            </ul>
                            <ul class="pull-right">
                                <li class="view-post">
                                        <span >25 Views</span>
                                    </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-xs-10 mob-pr0">
                                <ul class="bottom-left">
                                    <li class="user-likes">
                                        <a href="javascript:void(0)" id="post-like-{{recentpost.post_data.id}}" ng-click="post_recent_like(recentpost.post_data.id,$index,recentpost.post_data.user_id)" ng-if="recentpost.is_userlikePost == '1'" class="like"><i class="fa fa-thumbs-up"></i>
                                            <span style="{{recentpost.post_like_count > 0 ? '' : 'display: none';}}" id="post-like-count-{{recentpost.post_data.id}}" ng-bind="recentpost.post_like_count"></span>
                                        </a>
                                        <a href="javascript:void(0)" id="post-like-{{recentpost.post_data.id}}" ng-click="post_recent_like(recentpost.post_data.id,$index,recentpost.post_data.user_id)" ng-if="recentpost.is_userlikePost == '0'"><i class="fa fa-thumbs-up"></i>
                                            <span style="{{recentpost.post_like_count > 0 ? '' : 'display: none';}}" id="post-like-count-{{recentpost.post_data.id}}" ng-bind="recentpost.post_like_count"></span>
                                        </a>
                                    </li>
                                    <li class="comment-count"><a href="javascript:void(0);" ng-click="viewAllComment(recentpost.post_data.id, $index, recentpost)" ng-if="recentpost.post_comment_data.length <= 1" id="comment-icon-{{recentpost.post_data.id}}" class="last-comment" title="View Comments"><i class="fa fa-comment-o"></i><span style="{{recentpost.post_comment_count > 0 ? '' : 'display: none';}}" class="recentpost-comment-count-{{recentpost.post_data.id}}" ng-bind="recentpost.post_comment_count"></span></a></li>
                                    <li class="comment-count"><a href="javascript:void(0);" ng-click="viewLastComment(recentpost.post_data.id, $index, post)" ng-if="recentpost.post_comment_data.length > 1" id="comment-icon-{{recentpost.post_data.id}}" class="all-comment"  title="View Comments"><i class="fa fa-comment-o"></i><span style="{{recentpost.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{recentpost.post_data.id}}" ng-bind="recentpost.post_comment_count"></span></a></li>
                                    
                                </ul>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-2 mob-pl0">
                                <ul class="pull-right bottom-right">
                                    <li class="post-save">
                                        <a ng-if="recentpost.is_user_saved_post == '0'" id="save-post-{{recentpost.post_data.id}}" ng-click="save_recent_post(recentpost.post_data.id, $index, recentpost)" href="javascript:void(0);" title="Save Post"><img src="<?php echo base_url('assets/n-images/save-post.svg'); ?>"></a>
                                        <a ng-if="recentpost.is_user_saved_post == '1'" id="saved-post-{{recentpost.post_data.id}}" href="javascript:void(0);" title="Saved Post"><img src="<?php echo base_url('assets/n-images/saved-post.svg'); ?>"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <div class="like-other-box">
                    
                </div>
            </div>
            <div class="all-post-bottom comment-for-post-{{recentpost.post_data.id}}">
                <div class="comment-box">
                    <div class="post-comment" nf-if="recentpost.post_comment_data.length > 0" ng-repeat="comment in recentpost.post_comment_data" ng-init="commentIndex=$index">
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
                            <div class="comment-dis-inner" id="comment-dis-inner-{{comment.comment_id}}">
                                <p dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{comment.comment}}" dd-text-collapse-cond="true"></p>
                            </div>

                            <div class="edit-comment" id="edit-comment-{{comment.comment_id}}" style="display:none;">
                                <div class="comment-input">
                                    <!--<div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" onpaste="OnPaste_StripFormatting(event);"></div>-->
                                    <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}}, recentpost.post_data.id, recentpost.post_data.user_id)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="cmt_handle_paste_edit($event)" ng-keydown="check_comment_char_count_edit(comment.comment_id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                                    <div class="editCommentTaxBox-{{comment.comment_id}} all-hashtags-list"></div>
                                </div>
                                <div class="mob-comment">
                                    <button ng-click="sendEditComment(comment.comment_id, recentpost.post_data.id, recentpost.post_data.user_id)"><img ng-src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                </div>
                                
                                <div class="comment-submit hidden-mob">
                                    <button class="btn2" ng-click="sendEditComment(comment.comment_id, recentpost.post_data.id, recentpost.post_data.user_id)">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="comment-action">
                            <ul class="pull-left">
                                <li ng-if="comment.is_userlikePostComment == '1'"><a href="javascript:void(0);" id="cmt-like-fnc-{{comment.comment_id}}" ng-click="likePostComment(comment.comment_id, recentpost.post_data.id, comment.commented_user_id)" class="like"><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span> Like</a></li>

                                <li ng-if="comment.is_userlikePostComment == '0'"><a href="javascript:void(0);" id="cmt-like-fnc-{{comment.comment_id}}" ng-click="likePostComment(comment.comment_id, recentpost.post_data.id, comment.commented_user_id)"><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span> Like</a></li> 
                                <li id="cancel-comment-li-{{comment.comment_id}}" style="display: none;"><a href="javascript:void(0);" ng-click="cancelPostComment(comment.comment_id, recentpost.post_data.id, $parent.$index, $index)">Cancel</a></li> 
                                
                                <li><a href="javascript:void(0);" ng-bind="comment.comment_time_string"></a></li>
                            </ul>
                            <ul class="pull-right">
                                <li ng-if="comment.commented_user_id == user_id" id="edit-comment-li-{{comment.comment_id}}"><a href="javascript:void(0);" ng-click="editRecentPostComment(comment.comment_id, recentpost.post_data.id, postIndex, commentIndex)"><img src="<?php echo base_url('assets/n-images/edit.svg') ?>"></a></li>
                                <li ng-if="recentpost.post_data.user_id == user_id || comment.commented_user_id == user_id"><a href="javascript:void(0);" ng-click="deleteRecentPostComment(comment.comment_id, recentpost.post_data.id, postIndex, commentIndex, post)"><img src="<?php echo base_url('assets/n-images/delet.svg') ?>"></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="add-comment new-comment-{{recentpost.post_data.id}}">
                        <div class="post-img">
                            <?php 
                            if ($leftbox_data['user_image'] != '')
                            { ?> 
                                <img ng-class="recentpost.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '' ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
                            <?php
                            }
                            else
                            { 
                                if($leftbox_data['user_gender'] == "M")
                                {?>                                
                                    <img ng-class="recentpost.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                <?php
                                }
                                if($leftbox_data['user_gender'] == "F")
                                {
                                ?>
                                    <img ng-class="recentpost.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                <?php
                                }                                
                            } ?>

                        </div>
                        <div class="comment-input">
                            <div contenteditable="true" data-directive ng-model="comment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendRecentComment({{recentpost.post_data.id}},$index,post)" id="commentTaxBox-{{recentpost.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" ng-paste="cmt_handle_paste($event)" ng-keydown="check_comment_char_count(recentpost.post_data.id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                            <div class="commentTaxBox-{{recentpost.post_data.id}} all-hashtags-list"></div>
                        </div>
                        <div class="mob-comment">
                            <button id="cmt-btn-mob-{{recentpost.post_data.id}}"  ng-click="sendRecentComment(recentpost.post_data.id, $index, post)"><img ng-src="<?php echo base_url('assets/img/send.png') ?>"></button>
                        </div>
                        <div class="comment-submit hidden-mob">
                            <button id="cmt-btn-{{recentpost.post_data.id}}" class="btn2" ng-click="sendRecentComment(recentpost.post_data.id, $index, post)">Comment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div ng-if="postData.length != 0" ng-repeat="post in postData" ng-init="postIndex=$index">
            <div id="main-post-{{post.post_data.id}}" class="all-post-box" ng-class="post.post_data.post_for == 'article' ? 'article-post' : ''">
                <!--<input type="hidden" name="post_index" class="post_index" ng-class="post_index" ng-model="post_index" ng-value="{{$index + 1}}">-->
                <input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_data.page}}">
                <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.page_data.total_record}}">
                <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.page_data.perpage_record}}">
                
                <div class="all-post-top">
                    <div class="post-head" ng-class="post.question_data.is_anonymously == '1' ? 'anonymous-que' : ''">
                        <div class="post-img" ng-if="post.post_data.user_type == '1' && post.post_data.post_for == 'question'">
                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self" ng-if="post.question_data.is_anonymously == '0'">
                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.post_data.user_type == '1' && post.user_data.user_image != '' && post.question_data.is_anonymously == '0'">
                                <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.post_data.user_type == '1' && post.user_data.user_image == '' && post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.post_data.user_type == '1' && post.user_data.user_image == '' && post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                            </a>
                                            
                            <span class="no-img-post"  ng-if="post.user_data.user_image == '' || post.question_data.is_anonymously == '1'">A</span>
                        </div>
                                        
                        <div class="post-img" ng-if="post.post_data.user_type == '1' && post.post_data.post_for != 'question' && post.user_data.user_image != ''">
                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}">
                            </a>
                        </div>
                                        
                        <div class="post-img no-profile-pic" ng-if="post.post_data.user_type == '1' && post.post_data.post_for != 'question' && post.user_data.user_image == ''">
                            <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                            </a>
                        </div>

                        <div class="post-img" ng-if="post.post_data.user_type == '2' && post.post_data.post_for == 'question'">
                            <a ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" target="_self" ng-if="post.question_data.is_anonymously == '0'">
                                <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{post.user_data.business_user_image}}" ng-if="post.user_data.business_user_image && post.question_data.is_anonymously == '0'">
                                <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="!post.user_data.business_user_image" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                            </a>
                                            
                            <span class="no-img-post"  ng-if="!post.user_data.business_user_image || post.question_data.is_anonymously == '1'">A</span>
                        </div>
                                        
                        <div class="post-img" ng-if="post.post_data.user_type == '2' && post.post_data.post_for != 'question' && post.user_data.business_user_image">
                            <a ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" target="_self">
                                <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>{{post.user_data.business_user_image}}">
                            </a>
                        </div>
                                        
                        <div class="post-img no-profile-pic" ng-if="post.post_data.user_type == '2' && post.post_data.post_for != 'question' && !post.user_data.business_user_image">
                            <a ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" target="_self">
                                <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url(NOBUSIMAGE3); ?>"> 
                            </a>
                        </div>
                                        
                        <div class="post-detail">
                            <div class="fw" ng-if="post.post_data.post_for == 'question'">
                                <a href="javascript:void(0)" class="post-name" ng-if="post.question_data.is_anonymously == '1'">Anonymous</a>
                                <span class="post-time" ng-if="post.question_data.is_anonymously == '1'"></span>
                                <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" ng-if="post.post_data.user_type == '1' && post.question_data.is_anonymously == '0'" target="_self"></a>
                                <a ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" ng-bind="post.user_data.company_name" ng-if="post.post_data.user_type == '2' && post.question_data.is_anonymously == '0'" target="_self"></a><span class="post-time">{{post.post_data.time_string}}</span>
                            </div>
                                            
                            <div class="fw" ng-if="post.post_data.post_for != 'question'">
                                <a ng-if="post.post_data.user_type == '1'" ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" target="_self"></a>
                                <a ng-if="post.post_data.user_type == '2'" ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" ng-bind="post.user_data.company_name" target="_self"></a><span class="post-time">{{post.post_data.time_string}}</span>
                            </div>
                                            
                            <div class="fw" ng-if="post.post_data.user_type == '1' && post.post_data.post_for == 'question'">
                                <span class="post-designation" ng-if="post.user_data.title_name != null && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.title_name"></span>
                                <span class="post-designation" ng-if="post.user_data.title_name == null && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.degree_name"></span>
                                <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null && post.question_data.is_anonymously == '0'">CURRENT WORK</span>
                            </div>
                            <div class="fw" ng-if="post.post_data.user_type == '1' && post.post_data.post_for != 'question'">
                                <span class="post-designation" ng-if="post.user_data.title_name != null" ng-bind="post.user_data.title_name"></span>
                                <span class="post-designation" ng-if="post.user_data.title_name == null" ng-bind="post.user_data.degree_name"></span>
                                <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null">CURRENT WORK</span>
                            </div>

                            <div class="fw" ng-if="post.post_data.user_type == '2' && post.post_data.post_for == 'question'">
                                <span class="post-designation" ng-if="post.user_data.industry_name != null && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.industry_name"></span> 
                                <span class="post-designation" ng-if="!post.user_data.industry_name && post.question_data.is_anonymously == '0'">CURRENT WORK</span>
                            </div>
                            <div class="fw" ng-if="post.post_data.user_type == '2' && post.post_data.post_for != 'question'">
                                <span class="post-designation" ng-if="post.user_data.industry_name" ng-bind="post.user_data.industry_name"></span> 
                                <span class="post-designation" ng-if="!post.user_data.industry_name">CURRENT WORK</span>
                            </div>
                        </div>
                        <div class="post-right-dropdown dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/right-down.png') ?>" alt="Right Down"></a>
                            <ul class="dropdown-menu">
                                
                                <li ng-if="live_slug == post.user_data.user_slug && post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update' && post.post_data.post_for == 'article'"><a href="<?php echo base_url();?>edit-article/{{post.article_data.unique_key}}">Edit Post</a></li>
                               
                                <li ng-if="live_slug == post.user_data.user_slug && post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update' && post.post_monetize == 0"><a href="#" ng-click="deletePost(post.post_data.id, $index)">Delete Post</a></li>
                                <li>
                                    <a ng-if="post.is_user_saved_post == '0'" href="javascript:void(0);" ng-click="save_post(post.post_data.id, $index, post)">Save Post</a>
                                    <a ng-if="post.is_user_saved_post == '1'" href="javascript:void(0);">Saved Post</a>

                                    <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for == 'article'" href="<?php echo base_url(); ?>article/{{post.article_data.article_slug}}" target="_blank">Show in new tab</a>
                                    <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for == 'opportunity'" href="<?php echo base_url(); ?>o/{{post.opportunity_data.oppslug}}" target="_blank">Show in new tab</a>

                                    <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.post_for == 'simple'" href="<?php echo base_url(); ?>p/{{post.simple_data.simslug}}" target="_blank">Show in new tab</a>

                                    <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.post_for != 'simple' && post.post_data.post_for == 'share'" href="<?php echo base_url(); ?>shp/{{post.share_data.shared_post_slug}}" target="_blank">Show in new tab</a>
                                    
                                    <a ng-if="post.post_data.post_for == 'question'" ng-href="<?php echo base_url('questions/');?>{{post.question_data.id}}/{{post.question_data.question| slugify}}" target="_blank">Show in new tab</a>
                                </li>
                                <li ng-if="live_slug != post.user_data.user_slug">
                                    <a ng-click="open_report_spam(post.post_data.id)" href="javascript:void(0);">Report</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="post-discription" ng-if="post.post_data.post_for == 'opportunity'">
                       
                        <div id="post-opp-detail-{{post.post_data.id}}">
                            <h5 class="post-title">
                                <p ng-if="post.opportunity_data.opptitle"><b>Title of Opportunity:</b><span ng-bind="post.opportunity_data.opptitle" id="opp-title-{{post.post_data.id}}"></span></p>
                                <p ng-if="post.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="post.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{post.post_data.id}}"></span></p>
                                <p ng-if="post.opportunity_data.location"><b>Location:</b><span ng-bind="post.opportunity_data.location" id="opp-post-location-{{post.post_data.id}}"></span></p>
                                <p ng-if="post.opportunity_data.field"><b>Field:</b><span ng-bind="post.opportunity_data.field" id="opp-post-field-{{post.post_data.id}}"></span></p>
                                <p ng-if="!post.opportunity_data.field || post.opportunity_data.field == 0"><b>Field:</b><span ng-bind="post.opportunity_data.other_field" id="opp-post-field-{{post.post_data.id}}"></span></p>
                                <p ng-if="post.opportunity_data.hashtag" class="hashtag-grd">
                                    <b>Hashtags:</b>                                    
                                    <span>
                                        <span class="post-hash-tag" id="opp-post-hashtag-{{post.post_data.id}}" ng-repeat="hashtag in post.opportunity_data.hashtag.split(' ')">{{hashtag}}</span>
                                    </span>
                                </p>                                
                                <p ng-if="post.opportunity_data.company_name"><b>Company Name:</b><span ng-bind="post.opportunity_data.company_name" id="opp-post-company-{{post.post_data.id}}"></span></p>
                            </h5>
                            <div class="post-des-detail" ng-if="post.opportunity_data.opportunity">
                                <div id="opp-post-opportunity-{{post.post_data.id}}" ng-class="post.opportunity_data.opportunity.length > 250 ? 'view-more-expand' : ''">
                                    <b>Opportunity:</b>
                                    <span ng-bind-html="post.opportunity_data.opportunity"></span>
                                    <a id="remove-view-more{{post.post_data.id}}" ng-if="post.opportunity_data.opportunity.length > 250" ng-click="removeViewMore('opp-post-opportunity-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post-discription" ng-if="post.post_data.post_for == 'simple'">
                        <p ng-if="post.simple_data.sim_title"><b>Title:</b> <span ng-bind="post.simple_data.sim_title" id="opp-title-{{post.post_data.id}}"></span></p>
                        <p ng-if="post.simple_data.hashtag" class="hashtag-grd">
                            <b>Hashtags:</b>
                            <span>
                                <span class="post-hash-tag" id="sim-post-hashtag-{{post.post_data.id}}" ng-repeat="hashtag in post.simple_data.hashtag.split(' ')">{{hashtag}}</span>
                            </span>
                        </p>                        

                        <div ng-init="limit = 250; moreShown = false">
                            <span ng-if="post.simple_data.description != ''" id="simple-post-description-{{post.post_data.id}}" ng-bind-html="post.simple_data.description" ng-class="post.simple_data.description.length > 250 ? 'view-more-expand' : ''">
                            </span>
                            <a id="remove-view-more{{post.post_data.id}}" ng-if="post.simple_data.description.length > 250" ng-click="removeViewMore('simple-post-description-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>                            
                        </div>                        
                    </div>

                    <div class="post-discription" ng-if="post.post_data.post_for == 'article'">
                        <p ng-if="post.article_data.hashtag" class="hashtag-grd">
                            <span>
                                <span class="post-hash-tag" id="opp-post-hashtag-{{post.post_data.id}}" ng-repeat="hashtag in post.article_data.hashtag.split(' ')">{{hashtag}}</span>
                            </span>
                        </p>
                    </div>
                    <div class="post-images article-post-cus" ng-if="post.post_data.post_for == 'article'">
                        <div class="one-img" ng-class="post.article_data.article_featured_image == '' ? 'article-default-featured' : ''">
                            <a href="<?php echo base_url(); ?>article/{{post.article_data.article_slug}}" target="_self">
                                <img ng-src="<?php echo base_url().$this->config->item('article_featured_upload_path'); ?>{{post.article_data.article_featured_image}}" alt="{{post.article_data.article_title}}" ng-if="post.article_data.article_featured_image != ''">

                                <img ng-src="<?php echo base_url('assets/img/art-default.jpg'); ?>{{post.article_data.article_featured_image}}" alt="{{post.article_data.article_title}}" ng-if="post.article_data.article_featured_image == ''">
                                <div class="article-post-text">
                                    <h3>{{post.article_data.article_title}}</h3>
                                    <p>{{post.post_data.user_type == '1' ? post.user_data.fullname : post.user_data.company_name}}'s Article on Aileensoul</p>
                                </div>
                            </a>                            
                        </div>
                    </div>
                    <div class="post-discription" ng-if="post.post_data.post_for == 'profile_update'">
                        <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{post.profile_update.data_value}}" ng-click="openModal2('myModalCoverPic'+post.post_data.id);">
                    </div>
                    <div class="post-discription" ng-if="post.post_data.post_for == 'cover_update'">
                        <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.cover_update.data_value}}" ng-if="post.cover_update.data_value != ''" ng-click="openModal2('myModalCoverPic'+post.post_data.id);">
                    </div>
                    <div ng-if="post.post_data.post_for == 'profile_update' || post.post_data.post_for == 'cover_update'" id="myModalCoverPic{{post.post_data.id}}" class="modal modal2" style="display: none;">
                        <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModalCoverPic'+post.post_data.id)">×</button>
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
                                    <img ng-src="<?php echo base_url('assets/images/loader.gif') . '' ?>" alt="Loader" />
                                </div>
                                <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                <div class="mySlides mySlides2{{post.post_data.id}}">
                                    <div class="numbertext"></div>
                                    <div class="slider_img_p" ng-if="post.post_data.post_for == 'cover_update'">
                                        <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.cover_update.data_value}}" alt="Cover Image" id="cover{{post.post_data.id}}">
                                    </div>
                                    <div class="slider_img_p" ng-if="post.post_data.post_for == 'profile_update'">
                                        <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{post.profile_update.data_value}}" alt="Profile Image" id="cover{{post.post_data.id}}">
                                    </div>
                                </div>                                
                            </div>
                            <div class="caption-container">
                                <p id="caption"></p>
                            </div>
                        </div>
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
                                <p ng-if="post.question_data.hashtag"><b>Hashtag:</b><span ng-bind="post.question_data.hashtag" class="post-hash-tag" id="ask-post-hashtag-{{post.post_data.id}}"></span></p>
                                <p ng-if="post.question_data.field"><b>Field:</b><span ng-bind="post.question_data.field" id="ask-post-field-{{post.post_data.id}}"></span></p>
                            </h5>
                            <div class="post-des-detail" ng-if="post.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.opportunity_data.opportunity"></span></div>
                        </div>
                       
                    </div>
                    <div class="post-discription" ng-if="post.post_data.post_for == 'share'">
                        <p id="share-post-desc-{{post.post_data.id}}" ng-if="post.share_data.description" class="ng-scope">
                            <span ng-bind="post.share_data.description" id="share-desc-{{post.post_data.id}}"></span>
                        </p>

                        <div id="share-post-detail-{{post.post_data.id}}" ng-if="post.share_data" class="all-post-box">
                                <div class="all-post-top">
                                    <div class="post-head">
                                        <div class="post-img" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.post_data.post_for == 'question'">
                                            <a ng-href="<?php echo base_url() ?>{{post.share_data.data.user_data.user_slug}}" class="post-name" target="_self" ng-if="post.share_data.data.question_data.is_anonymously == '0'">
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.share_data.data.user_data.user_image}}" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.user_data.user_image != '' && post.share_data.data.question_data.is_anonymously == '0'">
                                                <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.user_data.user_image == '' && post.share_data.data.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.user_data.user_image == '' && post.share_data.data.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </a>
                                                            
                                            <span class="no-img-post"  ng-if="post.share_data.data.user_data.user_image == '' || post.share_data.data.question_data.is_anonymously == '1'">A</span>
                                        </div>

                                        <div class="post-img" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.post_data.post_for != 'question' && post.share_data.data.user_data.user_image != ''">
                                            <a ng-href="<?php echo base_url() ?>{{post.share_data.data.user_data.user_slug}}" class="post-name" target="_self">
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.share_data.data.user_data.user_image}}">
                                            </a>
                                        </div>

                                        <div class="post-img no-profile-pic" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.post_data.post_for != 'question' && post.share_data.data.user_data.user_image == ''">
                                            <a ng-href="<?php echo base_url() ?>{{post.share_data.data.user_data.user_slug}}" class="post-name" target="_self">
                                                <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.share_data.data.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.share_data.data.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </a>
                                        </div>

                                        <div class="post-img" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.post_data.post_for == 'question'">
                                            <a ng-href="<?php echo base_url() ?>company/{{post.share_data.data.user_data.business_slug}}" class="post-name" target="_self" ng-if="post.share_data.data.question_data.is_anonymously == '0'">
                                                <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{post.share_data.data.user_data.business_user_image}}" ng-if="post.share_data.data.user_data.business_user_image && post.share_data.data.question_data.is_anonymously == '0'">
                                                <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="!post.share_data.data.user_data.business_user_image" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                            </a>
                                                            
                                            <span class="no-img-post"  ng-if="!post.share_data.data.user_data.business_user_image || post.share_data.data.question_data.is_anonymously == '1'">A</span>
                                        </div>
                                                        
                                        <div class="post-img" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.post_data.post_for != 'question' && post.share_data.data.user_data.business_user_image">
                                            <a ng-href="<?php echo base_url() ?>company/{{post.share_data.data.user_data.business_slug}}" class="post-name" target="_self">
                                                <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>{{post.share_data.data.user_data.business_user_image}}">
                                            </a>
                                        </div>
                                                        
                                        <div class="post-img no-profile-pic" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.post_data.post_for != 'question' && !post.share_data.data.user_data.business_user_image">
                                            <a ng-href="<?php echo base_url() ?>company/{{post.share_data.data.user_data.business_slug}}" class="post-name" target="_self">
                                                <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                            </a>
                                        </div>

                                        <div class="post-detail">
                                            <div class="fw" ng-if="post.share_data.data.post_data.post_for == 'question'">
                                                <a href="javascript:void(0)" class="post-name" ng-if="post.share_data.data.question_data.is_anonymously == '1'">Anonymous</a>
                                                <span class="post-time" ng-if="post.share_data.data.question_data.is_anonymously == '1'"></span>
                                                <a ng-href="<?php echo base_url() ?>{{post.share_data.data.user_data.user_slug}}" class="post-name" ng-bind="post.share_data.data.user_data.fullname" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.question_data.is_anonymously == '0'"></a>
                                                <a ng-href="<?php echo base_url() ?>company/{{post.share_data.data.user_data.business_slug}}" class="post-name" ng-bind="post.share_data.data.user_data.company_name" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.question_data.is_anonymously == '0'"></a>
                                                <!-- <span class="post-time">{{post.share_data.data.post_data.time_string}}</span> -->
                                            </div>
                                                            
                                            <div class="fw" ng-if="post.share_data.data.post_data.post_for != 'question'">
                                                <a ng-if="post.share_data.data.post_data.user_type == '1'" ng-href="<?php echo base_url() ?>{{post.share_data.data.user_data.user_slug}}" class="post-name" ng-bind="post.share_data.data.user_data.fullname"></a>
                                                <a ng-if="post.share_data.data.post_data.user_type == '2'" ng-href="<?php echo base_url() ?>company/{{post.share_data.data.user_data.business_slug}}" class="post-name" ng-bind="post.share_data.data.user_data.company_name"></a>
                                                <!-- <span class="post-time">{{post.share_data.data.post_data.time_string}}</span> -->
                                            </div>

                                            <div class="fw" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.post_data.post_for == 'question'">
                                                <span class="post-designation" ng-if="post.share_data.data.user_data.title_name != null && post.share_data.data.question_data.is_anonymously == '0'" ng-bind="post.share_data.data.user_data.title_name"></span>
                                                <span class="post-designation" ng-if="post.share_data.data.user_data.title_name == null && post.share_data.data.question_data.is_anonymously == '0'" ng-bind="post.share_data.data.user_data.degree_name"></span>
                                                <span class="post-designation" ng-if="post.share_data.data.user_data.title_name == null && post.share_data.data.user_data.degree_name == null && post.share_data.data.question_data.is_anonymously == '0'">CURRENT WORK</span>
                                            </div>
                                            <div class="fw" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.post_data.post_for != 'question'">
                                                <span class="post-designation" ng-if="post.share_data.data.user_data.title_name != null" ng-bind="post.share_data.data.user_data.title_name"></span>
                                                <span class="post-designation" ng-if="post.share_data.data.user_data.title_name == null" ng-bind="post.share_data.data.user_data.degree_name"></span>
                                                <span class="post-designation" ng-if="post.share_data.data.user_data.title_name == null && post.share_data.data.user_data.degree_name == null">CURRENT WORK</span>
                                            </div>

                                            <div class="fw" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.post_data.post_for == 'question'">
                                                <span class="post-designation" ng-if="post.share_data.data.user_data.industry_name != null && post.share_data.data.question_data.is_anonymously == '0'" ng-bind="post.share_data.data.user_data.industry_name"></span> 
                                                <span class="post-designation" ng-if="!post.share_data.data.user_data.industry_name && post.share_data.data.question_data.is_anonymously == '0'">CURRENT WORK</span>
                                            </div>
                                            <div class="fw" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.post_data.post_for != 'question'">
                                                <span class="post-designation" ng-if="post.share_data.data.user_data.industry_name" ng-bind="post.share_data.data.user_data.industry_name"></span> 
                                                <span class="post-designation" ng-if="!post.share_data.data.user_data.industry_name">CURRENT WORK</span>
                                            </div>

                                        </div>            
                                    </div>
                                    <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'opportunity'">
                                       
                                        <div id="post-opp-detail-{{post.share_data.data.post_data.id}}">
                                            <div class="post-title opp-title-cus">
                                                <p ng-if="post.share_data.data.opportunity_data.opptitle"><b>Title of Opportunity:</b><h1 ng-bind="post.share_data.data.opportunity_data.opptitle" id="opp-title-{{post.share_data.data.post_data.id}}"></h1></p>
                                            </div>
                                            <h5 class="post-title">
                                                <p ng-if="post.share_data.data.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="post.share_data.data.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{post.share_data.data.post_data.id}}"></span></p>
                                                <p ng-if="post.share_data.data.opportunity_data.location"><b>Location:</b><span ng-bind="post.share_data.data.opportunity_data.location" id="opp-post-location-{{post.share_data.data.post_data.id}}"></span></p>
                                                <p ng-if="post.share_data.data.opportunity_data.field"><b>Field:</b><span ng-bind="post.share_data.data.opportunity_data.field" id="opp-post-field-{{post.share_data.data.post_data.id}}"></span></p>
                                                <p ng-if="!post.share_data.data.opportunity_data.field || post.share_data.data.opportunity_data.field == 0"><b>Field:</b><span ng-bind="post.share_data.data.opportunity_data.other_field" id="opp-post-field-{{post.share_data.data.post_data.id}}"></span></p>
                                                <p ng-if="post.share_data.data.opportunity_data.hashtag" class="hashtag-grd"><b>Hashtags:</b>
                                                    <span>
                                                        <span class="post-hash-tag" id="opp-post-hashtag-{{post.share_data.data.post_data.id}}" ng-repeat="hashtag in post.share_data.data.opportunity_data.hashtag.split(' ')">{{hashtag}}</span>
                                                    </span>
                                                </p>                                            
                                                <p ng-if="post.share_data.data.opportunity_data.company_name"><b>Company Name:</b><span ng-bind="post.share_data.data.opportunity_data.company_name" id="opp-post-company-{{post.share_data.data.post_data.id}}"></span></p>
                                            </h5>
                                            <div class="post-des-detail" ng-if="post.share_data.data.opportunity_data.opportunity">
                                                <div id="opp-post-opportunity-{{post.share_data.data.post_data.id}}" ng-class="post.share_data.data.opportunity_data.opportunity.length > 250 ? 'view-more-expand' : ''">
                                                    <b>Opportunity:</b>
                                                    <span ng-bind-html="post.share_data.data.opportunity_data.opportunity"></span>
                                                    <a id="remove-view-more{{post.share_data.data.post_data.id}}" ng-if="post.share_data.data.opportunity_data.opportunity.length > 250" ng-click="removeViewMore('opp-post-opportunity-'+post.share_data.data.post_data.id,'remove-view-more'+post.share_data.data.post_data.id);" class="read-more-post">.... Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'simple'">
                                        <p ng-if="post.share_data.data.simple_data.sim_title"><b>Title:</b> <span ng-bind="post.share_data.data.simple_data.sim_title" id="opp-title-{{post.share_data.data.post_data.id}}"></span></p>
                                        <p ng-if="post.share_data.data.simple_data.hashtag" class="hashtag-grd">
                                            <b>Hashtags:</b>
                                            <span>
                                                <span class="post-hash-tag" id="sim-post-hashtag-{{post.share_data.data.post_data.id}}" ng-repeat="hashtag in post.share_data.data.simple_data.hashtag.split(' ')">{{hashtag}}</span>
                                            </span>
                                        </p>
                                        <div ng-init="limit = 250; moreShown = false">
                                            <span ng-if="post.share_data.data.simple_data.description != ''" id="simple-post-description-{{post.share_data.data.post_data.id}}" ng-bind-html="post.share_data.data.simple_data.description" ng-class="post.share_data.data.simple_data.description.length > 250 ? 'view-more-expand' : ''">
                                            </span>
                                            <a id="remove-view-more{{post.share_data.data.post_data.id}}" ng-if="post.share_data.data.simple_data.description.length > 250" ng-click="removeViewMore('simple-post-description-'+post.share_data.data.post_data.id,'remove-view-more'+post.share_data.data.post_data.id);" class="read-more-post">.... Read More</a>                                        
                                        </div>                                    
                                    </div>
                                    <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'article'">
                                        <p ng-if="post.share_data.data.article_data.hashtag" class="hashtag-grd">
                                            <span>
                                                <span class="post-hash-tag" id="opp-post-hashtag-{{post.share_data.data.post_data.id}}" ng-repeat="hashtag in post.share_data.data.article_data.hashtag.split(' ')">{{hashtag}}</span>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="post-images article-post-cus" ng-if="post.share_data.data.post_data.post_for == 'article'">
                                        <div class="one-img" ng-class="post.share_data.data.article_data.article_featured_image == '' ? 'article-default-featured' : ''">
                                            <a href="<?php echo base_url(); ?>article/{{post.share_data.data.article_data.article_slug}}" target="_self">
                                                <img ng-src="<?php echo base_url().$this->config->item('article_featured_upload_path'); ?>{{post.share_data.data.article_data.article_featured_image}}" alt="{{post.share_data.data.article_data.article_title}}" ng-if="post.share_data.data.article_data.article_featured_image != ''">

                                                <img ng-src="<?php echo base_url('assets/img/art-default.jpg'); ?>{{post.share_data.data.article_data.article_featured_image}}" alt="{{post.share_data.data.article_data.article_title}}" ng-if="post.share_data.data.article_data.article_featured_image == ''">
                                                <div class="article-post-text">
                                                    <h3>{{post.share_data.data.article_data.article_title}}</h3>
                                                    <p>{{post.share_data.data.post_data.user_type == '1' ? post.share_data.data.user_data.fullname : post.share_data.data.user_data.company_name}}'s Article on Aileensoul</p>
                                                </div>
                                            </a>                            
                                        </div>
                                    </div>
                                    <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'profile_update'">
                                        <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{post.share_data.data.profile_update.data_value}}" ng-click="openModal2('myModalCoverPicShare'+post.share_data.data.post_data.id);">
                                    </div>
                                    <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'cover_update'">
                                        <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.share_data.data.cover_update.data_value}}" ng-if="post.share_data.data.cover_update.data_value != ''" ng-click="openModal2('myModalCoverPicShare'+post.share_data.data.post_data.id);">
                                    </div>
                                    <div ng-if="post.share_data.data.post_data.post_for == 'profile_update' || post.share_data.data.post_data.post_for == 'cover_update'" id="myModalCoverPicShare{{post.share_data.data.post_data.id}}" tabindex="-1" role="dialog"  class="modal modal2" style="display: none;">
                                        <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModalShare('myModalCoverPicShare'+post.share_data.data.post_data.id)">×</button>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
                                                    <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                                </div>
                                                <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                                <div class="mySlides mySlides2{{post.share_data.data.post_data.id}}">
                                                    <div class="numbertext"></div>
                                                    <div class="slider_img_p" ng-if="post.share_data.data.post_data.post_for == 'cover_update'">
                                                        <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.share_data.data.cover_update.data_value}}" alt="Cover Image" id="cover{{post.share_data.data.post_data.id}}">
                                                    </div>
                                                    <div class="slider_img_p" ng-if="post.share_data.data.post_data.post_for == 'profile_update'">
                                                        <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{post.share_data.data.profile_update.data_value}}" alt="Profile Image" id="cover{{post.share_data.data.post_data.id}}">
                                                    </div>
                                                </div>                                
                                            </div>
                                            <div class="caption-container">
                                                <p id="caption"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'question'">
                                        <div id="ask-que-{{post.share_data.data.post_data.id}}" class="post-des-detail">
                                            <h5 class="post-title">
                                                <div ng-if="post.share_data.data.question_data.question"><b>Question:</b><span ng-bind="post.share_data.data.question_data.question" id="ask-post-question-{{post.share_data.data.post_data.id}}"></span></div>                                        
                                                <div class="post-des-detail" ng-if="post.share_data.data.question_data.description">
                                                    <div id="ask-que-desc-{{post.share_data.data.post_data.id}}" ng-class="post.share_data.data.question_data.description.length > 250 ? 'view-more-expand' : ''">
                                                        <b>Description:</b>
                                                        <span ng-bind-html="post.share_data.data.question_data.description"></span>
                                                        <a id="remove-view-more{{post.share_data.data.post_data.id}}" ng-if="post.share_data.data.question_data.description.length > 250" ng-click="removeViewMore('ask-que-desc-'+post.share_data.data.post_data.id,'remove-view-more'+post.share_data.data.post_data.id);" class="read-more-post">.... Read More</a>
                                                    </div>                                            
                                                </div>
                                                <p ng-if="post.share_data.data.question_data.link"><b>Link:</b><span ng-bind="post.share_data.data.question_data.link" id="ask-post-link-{{post.share_data.data.post_data.id}}"></span></p>
                                                <p ng-if="post.share_data.data.question_data.category"><b>Category:</b><span ng-bind="post.share_data.data.question_data.category" id="ask-post-category-{{post.share_data.data.post_data.id}}"></span></p>
                                                <p ng-if="post.share_data.data.question_data.hashtag"><b>Hashtag:</b><span ng-bind="post.share_data.data.question_data.hashtag" class="post-hash-tag" id="ask-post-hashtag-{{post.post_data.id}}"></span></p>
                                                <p ng-if="post.share_data.data.question_data.field"><b>Field:</b><span ng-bind="post.share_data.data.question_data.field" id="ask-post-field-{{post.share_data.data.post_data.id}}"></span></p>
                                            </h5>
                                            <div class="post-des-detail" ng-if="post.share_data.data.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.share_data.data.opportunity_data.opportunity"></span></div>
                                        </div>                                    
                                    </div>
                                    <div class="post-images" ng-if="post.share_data.data.post_data.total_post_files == 1">
                                        <div class="one-img" ng-repeat="post_file in post.share_data.data.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                            <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                                <img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)">
                                            </a>
                                            <span ng-if="post_file.file_type == 'video'"> 
                                                <video controls width = "100%" height = "350" preload="metadata" ng-attr-poster="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}jpg">
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
                                    <div class="post-images" ng-if="post.share_data.data.post_data.total_post_files == 2">
                                        <div class="two-img" ng-repeat="post_file in post.share_data.data.post_file_data">
                                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                        </div>
                                    </div>
                                    <div class="post-images" ng-if="post.share_data.data.post_data.total_post_files == 3">
                                        <span ng-repeat="post_file in post.share_data.data.post_file_data">
                                            <div class="three-img-top" ng-if="$index == '0'">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                            </div>
                                            <div class="two-img" ng-if="$index == '1'">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                            </div>
                                            <div class="two-img" ng-if="$index == '2'">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="post-images four-img" ng-if="post.share_data.data.post_data.total_post_files >= 4">
                                        <div class="two-img" ng-repeat="post_file in post.share_data.data.post_file_data| limitTo:4">
                                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                            <div class="view-more-img" ng-if="$index == 3 && post.share_data.data.post_data.total_post_files > 4">
                                                <span><a href="javascript:void(0);" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)">View All ({{post.share_data.data.post_data.total_post_files - 4}})</a></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="myModalShare{{post.share_data.data.post_data.id}}" class="modal modal2" tabindex="-1" role="dialog" style="display: none;">
                                        <button type="button" class="modal-close" ng-click="closeModalShare('myModalShare'+post.share_data.data.post_data.id)">×</button>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                                </div>
                                                <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                                <div class="mySlides mySlides2{{post.share_data.data.post_data.id}}" ng-repeat="_photoData in post.share_data.data.post_file_data">
                                                    <div class="numbertext">{{$index + 1}} / {{post.share_data.data.post_data.total_post_files}}</div>
                                                    <div class="slider_img_p">
                                                        <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                                                    </div>
                                                </div>                                
                                            </div>
                                            <div class="caption-container">
                                                <p id="caption"></p>
                                            </div>
                                        </div> 
                                        <a ng-if="post.share_data.data.post_file_data.length > 1" class="prev" style="left:0px;" ng-click="plusSlides2(-1,post.share_data.data.post_data.id)">&#10094;</a>
                                        <a ng-if="post.share_data.data.post_file_data.length > 1" class="next" ng-click="plusSlides2(1,post.share_data.data.post_data.id)">&#10095;</a>
                                    </div>                                    
                                </div>
                        </div>
                    </div>
                    <div class="post-images" ng-if="post.post_data.total_post_files == 1">
                        <div class="one-img" ng-repeat="post_file in post.post_file_data" ng-init="$last ? loadMediaElement() : false">
                            <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                <img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,'myModal'+post.post_data.id)">
                            </a>
                            <span ng-if="post_file.file_type == 'video'"> 
                                <video controls width = "100%" height = "350" ng-attr-poster="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}jpg" preload="none">
                                    <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}#t=0.1" type="video/mp4">
                                </video>
                                <!--<video controls poster="" class="mejs__player" ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}"></video>-->
                            </span>
                            <span  ng-if="post_file.file_type == 'audio'">
                                <div class = "audio_main_div">
                                    <div class = "audio_img">
                                        <img src = "<?php echo base_url('assets/images/music-icon.png') ?>" alt="music-icon.png">
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
                            <a ng-href="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" target="_blank" title="Click Here" ng-if="post_file.file_type == 'pdf'"><img ng-src="<?php echo base_url('assets/images/PDF.jpg') ?>"></a>
                        </div>
                    </div>
                    
                    <div class="post-images" ng-if="post.post_data.total_post_files == 2">
                        <div class="two-img" ng-repeat="post_file in post.post_file_data">
                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,'myModal'+post.post_data.id)"></a>
                        </div>
                    </div>
                    <div class="post-images" ng-if="post.post_data.total_post_files == 3">
                        <span ng-repeat="post_file in post.post_file_data">
                            <div class="three-img-top" ng-if="$index == '0'">
                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,'myModal'+post.post_data.id)"></a>
                            </div>
                            <div class="two-img" ng-if="$index == '1'">
                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,'myModal'+post.post_data.id)"></a>
                            </div>
                            <div class="two-img" ng-if="$index == '2'">
                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,'myModal'+post.post_data.id)"></a>
                            </div>
                        </span>
                    </div>
                    <div class="post-images four-img" ng-if="post.post_data.total_post_files >= 4">
                        <div class="two-img" ng-repeat="post_file in post.post_file_data| limitTo:4">
                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,'myModal'+post.post_data.id)"></a>
                            <div class="view-more-img" ng-if="$index == 3 && post.post_data.total_post_files > 4">
                                <span><a href="javascript:void(0);" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,'myModal'+post.post_data.id)">View All ({{post.post_data.total_post_files - 4}})</a></span>
                            </div>
                        </div>
                    </div>
                    <div id="myModal{{post.post_data.id}}" class="modal modal2" style="display: none;">
                        <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModal'+post.post_data.id)">×</button>
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;"><img ng-src="<?php echo base_url('assets/images/loader.gif') . '' ?>" alt="Loader" />
                                </div>
                                <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                <div class="mySlides myModal{{post.post_data.id}}" ng-if="post.post_data.post_for != 'article'" ng-repeat="_photoData in post.post_file_data">
                                    <div class="numbertext">{{$index + 1}} / {{post.post_data.total_post_files}}</div>
                                    <div class="slider_img_p">
                                        <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                                    </div>
                                </div>
                                <!-- <div class="mySlides mySlides2{{post.post_data.id}}" ng-if="post.post_data.post_for == 'article' && post.article_data.article_featured_image != ''">
                                    <div class="numbertext">1</div>
                                    <div class="slider_img_p">
                                        <img ng-src="<?php //echo base_url().$this->config->item('article_featured_upload_path'); ?>{{post.article_data.article_featured_image}}" alt="Image-1" id="element_load_1">
                                    </div>
                                </div>  -->
                            </div>
                            <div class="caption-container">
                                <p id="caption"></p>
                            </div>
                        </div> 
                        <a ng-if="post.post_file_data.length > 1" class="prev" style="left:0px;" ng-click="plusSlides2(-1,'myModal'+post.post_data.id)">&#10094;</a>
                        <a ng-if="post.post_file_data.length > 1" class="next" ng-click="plusSlides2(1,'myModal'+post.post_data.id)">&#10095;</a>
                    </div>
                    <div class="post-bottom">
                        <div class="like-list">
                            <ul id="" class="bottom-left like_user_list">
                                <li class="like-img" ng-if="post.user_like_list.length > 0" ng-repeat="user_like in post.user_like_list">
                                    <a class="ripple" href="<?php echo base_url(); ?>{{user_like.user_slug}}" target="_self" title="{{user_like.fullname}}">
                                        <img ng-if="user_like.user_image" ng-src="<?php echo USER_THUMB_UPLOAD_URL; ?>{{user_like.user_image}}">
                                        <img ng-if="!user_like.user_image && user_like.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <img ng-if="!user_like.user_image && user_like.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    </a>
                                </li>                                   
                                <li class="like-img">
                                    <a href="javascript:void(0)" ng-click="like_user_list(post.post_data.id);" ng-bind="post.post_like_data" id="post-other-like-{{post.post_data.id}}"></a>
                                </li>
                            </ul>
                            <ul class="pull-right">
                                <li class="view-post">
                                        <span >25 Views</span>
                                    </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-xs-10 mob-pr0">
                                <ul class="bottom-left">
                                    <li class="user-likes">
                                        <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id, $index, 0, post.post_data.user_id)" ng-if="post.is_userlikePost == '1'" class="like"><i class="fa fa-thumbs-up"></i><span style="{{post.post_like_count > 0 ? '' : 'display: none';}}" id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span></a>

                                        <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id, $index, 0, post.post_data.user_id)" ng-if="post.is_userlikePost == '0'"><i class="fa fa-thumbs-up"></i>
                                            <span style="{{post.post_like_count > 0 ? '' : 'display: none';}}" id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span>
                                        </a>
                                    </li>
                                    <li class="comment-count"><a href="javascript:void(0);" ng-click="viewAllComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length <= 1" id="comment-icon-{{post.post_data.id}}" class="last-comment" title="View Comments"><i class="fa fa-comment-o"></i><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span></a></li>
                                     <li class="comment-count"><a href="javascript:void(0);" ng-click="viewLastComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length > 1" id="comment-icon-{{post.post_data.id}}" class="all-comment"  title="View Comments"><i class="fa fa-comment-o"></i><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span></a></li>
                                    <li>
                                        <a id="share-post-{{post.post_data.id}}" ng-click="share_post(post.post_data.id, $index, post)" href="javascript:void(0);" title="Share Post"><i class="fa fa-share-alt" aria-hidden="true"></i><span ng-if="post.post_share_count > 0">{{post.post_share_count}}</span></a>
                                    </li>
                                    
                                </ul>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-2 mob-pl0">
                                <ul class="pull-right bottom-right">
                                    <!--li class="like-count" ng-click="like_user_list(post.post_data.id);"><span style="{{post.post_like_count > 0 ? '' : 'display: none';}}" id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span><span>Like</span></li-->
                                    <!-- <li class="comment-count"><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span><span>Comment</span></li> -->


                                    <li class="post-save">
                                        <a ng-if="post.is_user_saved_post == '0'" id="save-post-{{post.post_data.id}}" ng-click="save_post(post.post_data.id, $index, post)" href="javascript:void(0);" title="Save Post"><img src="<?php echo base_url('assets/n-images/save-post.svg'); ?>"></a>
                                        <a ng-if="post.is_user_saved_post == '1'" id="saved-post-{{post.post_data.id}}" href="javascript:void(0);" title="Saved Post"><img src="<?php echo base_url('assets/n-images/saved-post.svg'); ?>"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="like-other-box">
                        
                    </div>
                </div>
                <div class="all-post-bottom comment-for-post-{{post.post_data.id}}">
                    <div class="comment-box">
                        <div class="post-comment" nf-if="post.post_comment_data.length > 0" ng-repeat="comment in post.post_comment_data" ng-init="commentIndex=$index">
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
                                <div class="comment-dis-inner" id="comment-dis-inner-{{comment.comment_id}}">
                                    <p dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{comment.comment}}" dd-text-collapse-cond="true"></p>
                                </div>

                                <div class="edit-comment" id="edit-comment-{{comment.comment_id}}" style="display:none;">
                                    <div class="comment-input">
                                        <!--<div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" onpaste="OnPaste_StripFormatting(event);"></div>-->
                                        <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}}, post.post_data.id, post.post_data.user_id)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="cmt_handle_paste_edit($event)" ng-keydown="check_comment_char_count_edit(comment.comment_id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                                        <div class="editCommentTaxBox-{{comment.comment_id}} all-hashtags-list"></div>
                                    </div>
                                    <div class="mob-comment">
                                        <button ng-click="sendEditComment(comment.comment_id, post.post_data.id, post.post_data.user_id)"><img ng-src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                    </div>
                                    
                                    <div class="comment-submit hidden-mob">
                                        <button class="btn2" ng-click="sendEditComment(comment.comment_id, post.post_data.id, post.post_data.user_id)">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="comment-action">
                                <ul class="pull-left">
                                    <li><a href="javascript:void(0);" id="cmt-reply-fnc-{{comment.comment_id}}" ng-click="comment_reply(postIndex,commentIndex,0,0,comment)">Reply</a></li>

                                    <li ng-if="comment.is_userlikePostComment == '1'"><a href="javascript:void(0);" id="cmt-like-fnc-{{comment.comment_id}}" ng-click="likePostComment(comment.comment_id, post.post_data.id, comment.commented_user_id)" class="like"><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span> Like</a></li>

                                    <li ng-if="comment.is_userlikePostComment == '0'"><a href="javascript:void(0);" id="cmt-like-fnc-{{comment.comment_id}}" ng-click="likePostComment(comment.comment_id, post.post_data.id, comment.commented_user_id)"><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span> Like</a></li>

                                    <li id="cancel-comment-li-{{comment.comment_id}}" style="display: none;"><a href="javascript:void(0);" ng-click="cancelPostComment(comment.comment_id, post.post_data.id, $parent.$index, commentIndex)">Cancel</a></li> 
                                    
                                    <li><a href="javascript:void(0);" ng-bind="comment.comment_time_string"></a></li>
                                </ul>
                                <ul class="pull-right">
                                    <li ng-if="comment.commented_user_id == user_id" id="edit-comment-li-{{comment.comment_id}}"><a href="javascript:void(0);" ng-click="editPostComment(comment.comment_id, post.post_data.id, postIndex, commentIndex)"><img src="<?php echo base_url('assets/n-images/edit.svg') ?>"></a></li>
                                    <li ng-if="post.post_data.user_id == user_id || comment.commented_user_id == user_id"><a href="javascript:void(0);" ng-click="deletePostComment(comment.comment_id, post.post_data.id, postIndex, commentIndex, post)"><img src="<?php echo base_url('assets/n-images/delet.svg') ?>"></a></li>
                                </ul>
                            </div>

                            <div class="post-comment reply-comment" nf-if="comment.comment_reply_data.length > 0" ng-repeat="commentreply in comment.comment_reply_data" ng-init="commentReplyIndex=$index">
                                <div class="post-img">
                                    <div ng-if="commentreply.user_image != ''">
                                        <a ng-href="<?php echo base_url() ?>{{commentreply.user_slug}}" class="post-name" target="_self">
                                            <img ng-class="commentreply.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{commentreply.user_image}}">
                                        </a>
                                    </div>
                                    <div class="post-img" ng-if="commentreply.user_image == ''">
                                        <a ng-href="<?php echo base_url() ?>{{commentreply.user_slug}}" class="post-name" target="_self">
                                            <img ng-class="commentreply.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" commentreply.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                            <img ng-class="commentreply.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" commentreply.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="comment-dis">
                                    <div class="comment-name"><a ng-href="<?php echo base_url() ?>{{commentreply.user_slug}}" class="post-name" target="_self" ng-bind="commentreply.username"></a></div>
                                    <div class="comment-dis-inner" id="comment-reply-dis-inner-{{commentreply.comment_id}}">
                                        <p dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{commentreply.comment}}" dd-text-collapse-cond="true">{{commentreply.comment}}</p>
                                    </div>

                                    <div class="edit-reply-comment" id="edit-reply-comment-{{commentreply.comment_id}}" style="display:none;">
                                        <div class="comment-input">                 
                                            <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="send_edit_comment_reply({{commentreply.comment_id}}, post.post_data.id)" id="edit-comment-reply-textbox-{{commentreply.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="cmt_handle_paste_edit($event)" ng-keydown="check_comment_char_count_edit(commentreply.comment_id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                                            <div class="edit-comment-reply-textbox-{{commentreply.comment_id}} all-hashtags-list"></div>
                                        </div>
                                        <div class="mob-comment">
                                            <button ng-click="send_edit_comment_reply(commentreply.comment_id, post.post_data.id)"><img ng-src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                        </div>                                        
                                        <div class="comment-submit hidden-mob">
                                            <button class="btn2" ng-click="send_edit_comment_reply(commentreply.comment_id, post.post_data.id)">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-action">
                                    <ul class="pull-left">
                                        <li><a href="javascript:void(0);" id="cmt-reply-fnc-{{commentreply.comment_id}}" ng-click="comment_reply(postIndex,commentIndex,user_id,commentreply.commented_user_id,commentreply)">Reply</a></li>

                                        <li ng-if="commentreply.is_userlikePostComment == '1'"><a href="javascript:void(0);" id="cmt-like-fnc-{{commentreply.comment_id}}" ng-click="likePostComment(commentreply.comment_id, post.post_data.id, commentreply.commented_user_id)" class="like"><span ng-bind="commentreply.postCommentLikeCount" id="post-comment-like-{{commentreply.comment_id}}"></span> Like</a></li>

                                        <li ng-if="commentreply.is_userlikePostComment == '0'"><a href="javascript:void(0);" id="cmt-like-fnc-{{commentreply.comment_id}}" ng-click="likePostComment(commentreply.comment_id, post.post_data.id, commentreply.commented_user_id)"><span ng-bind="commentreply.postCommentLikeCount" id="post-comment-like-{{commentreply.comment_id}}"></span> Like</a></li>

                                        <li id="cancel-reply-comment-li-{{commentreply.comment_id}}" style="display: none;"><a href="javascript:void(0);" ng-click="cancel_post_comment_reply(commentreply.comment_id, post.post_data.id, postIndex, commentIndex,commentReplyIndex)">Cancel</a></li> 
                                        
                                        <li id="timeago-reply-comment-li-{{commentreply.comment_id}}"><a href="javascript:void(0);" ng-bind="commentreply.comment_time_string"></a></li>
                                    </ul>
                                    <ul class="pull-right">
                                        <li ng-if="commentreply.commented_user_id == user_id" id="edit-comment-li-{{commentreply.comment_id}}"><a href="javascript:void(0);" ng-click="edit_post_comment_reply(commentreply.comment_id, post.post_data.id, postIndex, commentIndex,commentReplyIndex)"><img src="<?php echo base_url('assets/n-images/edit.svg') ?>"></a></li>
                                        <li ng-if="post.post_data.user_id == user_id || commentreply.commented_user_id == user_id"><a href="javascript:void(0);" ng-click="deletePostComment(commentreply.comment_id, post.post_data.id, postIndex, commentIndex, post)"><img src="<?php echo base_url('assets/n-images/delet.svg') ?>"></a></li>
                                    </ul>
                                </div>
                                
                            </div>

                            <div id="comment-reply-{{postIndex}}-{{commentIndex}}" class="comment-reply" style="display: none;">
                                <div class="post-img">
                                    <?php 
                                    if ($leftbox_data['user_image'] != '')
                                    { ?> 
                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '' ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
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
                                <div class="comment-dis">
                                    <div class="edit-comment">
                                        <div class="comment-input">             
                                            <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendCommentReply({{comment.comment_id}}, post.post_data.id,postIndex, commentIndex)" id="reply-comment-{{postIndex}}-{{commentIndex}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="cmt_handle_paste_edit($event)" ng-keydown="check_comment_char_count_edit(comment.comment_id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                                            <div class="reply-comment-{{postIndex}}-{{commentIndex}} all-hashtags-list"></div>
                                        </div>
                                        <div class="mob-comment">
                                            <button ng-click="sendCommentReply(comment.comment_id, post.post_data.id,postIndex, commentIndex)"><img ng-src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                        </div>
                                        
                                        <div class="comment-submit hidden-mob">
                                            <button class="btn2" ng-click="sendCommentReply(comment.comment_id, post.post_data.id,postIndex, commentIndex)">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="add-comment new-comment-{{post.post_data.id}}">
                            <div class="post-img">
                                <?php 
                                if ($leftbox_data['user_image'] != '')
                                { ?> 
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '' ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
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
                                <div contenteditable="true" data-directive ng-model="comment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendComment(post.post_data.id,$index,post)" id="commentTaxBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" ng-paste="cmt_handle_paste($event)" ng-keydown="check_comment_char_count(post.post_data.id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                                <div class="commentTaxBox-{{post.post_data.id}} all-hashtags-list"></div>
                            </div>
                            <div class="mob-comment">
                                <button id="cmt-btn-mob-{{post.post_data.id}}"  ng-click="sendComment(post.post_data.id, $index, post)"><img ng-src="<?php echo base_url('assets/img/send.png') ?>"></button>
                            </div>
                            <div class="comment-submit hidden-mob">
                                <button id="cmt-btn-{{post.post_data.id}}" class="btn2" ng-click="sendComment(post.post_data.id, $index, post)">Comment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div ng-if="postIndex == 1">
                <div id="main-post-{{post.post_data.id}}" ng-if="promotedPostData.length != 0" class="all-post-box" ng-repeat="post in promotedPostData" ng-init="postIndex=$index">
                    <div class="all-post-top">
                        <div class="post-head">
                            <div class="post-img" ng-if="post.post_data.user_type == '1' && post.post_data.post_for == 'question'">
                                <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self" ng-if="post.question_data.is_anonymously == '0'">
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}" ng-if="post.post_data.user_type == '1' && post.user_data.user_image != '' && post.question_data.is_anonymously == '0'">
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.post_data.user_type == '1' && post.user_data.user_image == '' && post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.post_data.user_type == '1' && post.user_data.user_image == '' && post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                </a>
                                                
                                <span class="no-img-post"  ng-if="post.user_data.user_image == '' || post.question_data.is_anonymously == '1'">A</span>
                            </div>
                                            
                            <div class="post-img" ng-if="post.post_data.user_type == '1' && post.post_data.post_for != 'question' && post.user_data.user_image != ''">
                                <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.user_data.user_image}}">
                                </a>
                            </div>
                                            
                            <div class="post-img no-profile-pic" ng-if="post.post_data.user_type == '1' && post.post_data.post_for != 'question' && post.user_data.user_image == ''">
                                <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" target="_self">
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                </a>
                            </div>

                            <div class="post-img" ng-if="post.post_data.user_type == '2' && post.post_data.post_for == 'question'">
                                <a ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" target="_self" ng-if="post.question_data.is_anonymously == '0'">
                                    <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{post.user_data.business_user_image}}" ng-if="post.user_data.business_user_image && post.question_data.is_anonymously == '0'">
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="!post.user_data.business_user_image" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                </a>
                                                
                                <span class="no-img-post"  ng-if="!post.user_data.business_user_image || post.question_data.is_anonymously == '1'">A</span>
                            </div>
                                            
                            <div class="post-img" ng-if="post.post_data.user_type == '2' && post.post_data.post_for != 'question' && post.user_data.business_user_image">
                                <a ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" target="_self">
                                    <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>{{post.user_data.business_user_image}}">
                                </a>
                            </div>
                                            
                            <div class="post-img no-profile-pic" ng-if="post.post_data.user_type == '2' && post.post_data.post_for != 'question' && !post.user_data.business_user_image">
                                <a ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" target="_self">
                                    <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                </a>
                            </div>

                            <div class="post-detail">
                                <div class="fw" ng-if="post.post_data.post_for == 'question'">
                                    <a href="javascript:void(0)" class="post-name" ng-if="post.question_data.is_anonymously == '1'">Anonymous</a>
                                    <span class="post-time" ng-if="post.question_data.is_anonymously == '1'"></span>
                                    <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" ng-if="post.post_data.user_type == '1' && post.question_data.is_anonymously == '0'" target="_self"></a>
                                    <a ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" ng-bind="post.user_data.company_name" ng-if="post.post_data.user_type == '2' && post.question_data.is_anonymously == '0'" target="_self"></a><span class="post-time">Promoted</span>
                                </div>
                                                
                                <div class="fw" ng-if="post.post_data.post_for != 'question'">
                                    <a ng-if="post.post_data.user_type == '1'" ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" target="_self"></a>
                                    <a ng-if="post.post_data.user_type == '2'" ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" ng-bind="post.user_data.company_name" target="_self"></a><span class="post-time">Promoted</span>
                                </div>

                                <div class="fw" ng-if="post.post_data.user_type == '1' && post.post_data.post_for == 'question'">
                                    <span class="post-designation" ng-if="post.user_data.title_name != null && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.title_name"></span>
                                    <span class="post-designation" ng-if="post.user_data.title_name == null && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.degree_name"></span>
                                    <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null && post.question_data.is_anonymously == '0'">CURRENT WORK</span>
                                </div>
                                <div class="fw" ng-if="post.post_data.user_type == '1' && post.post_data.post_for != 'question'">
                                    <span class="post-designation" ng-if="post.user_data.title_name != null" ng-bind="post.user_data.title_name"></span>
                                    <span class="post-designation" ng-if="post.user_data.title_name == null" ng-bind="post.user_data.degree_name"></span>
                                    <span class="post-designation" ng-if="post.user_data.title_name == null && post.user_data.degree_name == null">CURRENT WORK</span>
                                </div>

                                <div class="fw" ng-if="post.post_data.user_type == '2' && post.post_data.post_for == 'question'">
                                    <span class="post-designation" ng-if="post.user_data.industry_name != null && post.question_data.is_anonymously == '0'" ng-bind="post.user_data.industry_name"></span> 
                                    <span class="post-designation" ng-if="!post.user_data.industry_name && post.question_data.is_anonymously == '0'">CURRENT WORK</span>
                                </div>
                                <div class="fw" ng-if="post.post_data.user_type == '2' && post.post_data.post_for != 'question'">
                                    <span class="post-designation" ng-if="post.user_data.industry_name" ng-bind="post.user_data.industry_name"></span> 
                                    <span class="post-designation" ng-if="!post.user_data.industry_name">CURRENT WORK</span>
                                </div>

                            </div>
                            <div class="post-right-dropdown dropdown" ng-if="post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update'">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/right-down.png') ?>" alt="Right Down"></a>
                                <ul class="dropdown-menu">                                    
                                    <!-- <li ng-if="user_id == post.user_data.user_id && post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update' && post.post_monetize == 0"><a href="#" ng-click="deletePost(post.post_data.id, $index)">Delete Post</a></li> -->
                                    <li>
                                        <a ng-if="post.is_user_saved_post == '0'" href="javascript:void(0);" ng-click="save_post(post.post_data.id, $index, post)">Save Post</a>
                                        <a ng-if="post.is_user_saved_post == '1'" href="javascript:void(0);">Saved Post</a>

                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for == 'article'" href="<?php echo base_url(); ?>article/{{post.article_data.article_slug}}" target="_blank">Show in new tab</a>
                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for == 'opportunity'" href="<?php echo base_url(); ?>o/{{post.opportunity_data.oppslug}}" target="_blank">Show in new tab</a>

                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.post_for == 'simple'" href="<?php echo base_url(); ?>p/{{post.simple_data.simslug}}" target="_blank">Show in new tab</a>

                                        <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.post_for != 'simple' && post.post_data.post_for == 'share'" href="<?php echo base_url(); ?>shp/{{post.share_data.shared_post_slug}}" target="_blank">Show in new tab</a>
                                        
                                        <a ng-if="post.post_data.post_for == 'question'" ng-href="<?php echo base_url('questions/');?>{{post.question_data.id}}/{{post.question_data.question| slugify}}" target="_blank">Show in new tab</a>
                                    </li>                    
                                </ul>
                            </div>
                        </div>
                        <div class="post-discription" ng-if="post.post_data.post_for == 'opportunity'">
                            
                            <div id="post-opp-detail-{{post.post_data.id}}">
                                <h5 class="post-title">
                                    <p ng-if="post.opportunity_data.opptitle"><b>Title of Opportunity:</b><span ng-bind="post.opportunity_data.opptitle" id="opp-title-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="post.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.opportunity_data.location"><b>Location:</b><span ng-bind="post.opportunity_data.location" id="opp-post-location-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.opportunity_data.field"><b>Field:</b><span ng-bind="post.opportunity_data.field" id="opp-post-field-{{post.post_data.id}}"></span></p>
                                    <p ng-if="!post.opportunity_data.field || post.opportunity_data.field == 0"><b>Field:</b><span ng-bind="post.opportunity_data.other_field" id="opp-post-field-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.opportunity_data.hashtag" class="hashtag-grd"><b>Hashtags:</b>
                                        <span>
                                            <span class="post-hash-tag" id="opp-post-hashtag-{{post.post_data.id}}" ng-repeat="hashtag in post.opportunity_data.hashtag.split(' ')">{{hashtag}}</span>
                                        </span>
                                    </p>                                            
                                    <p ng-if="post.opportunity_data.company_name"><b>Company Name:</b><span ng-bind="post.opportunity_data.company_name" id="opp-post-company-{{post.post_data.id}}"></span></p>
                                </h5>
                                <div class="post-des-detail" ng-if="post.opportunity_data.opportunity">
                                    <div id="opp-post-opportunity-{{post.post_data.id}}" ng-class="post.opportunity_data.opportunity.length > 250 ? 'view-more-expand' : ''">
                                        <b>Opportunity:</b>
                                        <span ng-bind-html="post.opportunity_data.opportunity"></span>
                                        <a id="remove-view-more{{post.post_data.id}}" ng-if="post.opportunity_data.opportunity.length > 250" ng-click="removeViewMore('opp-post-opportunity-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-discription" ng-if="post.post_data.post_for == 'simple'">
                            <p id="simple-post-title-{{post.post_data.id}}" ng-if="post.simple_data.sim_title">
                                <b>Title:</b> 
                                <span ng-bind="post.simple_data.sim_title" id="opp-title-{{post.post_data.id}}"></span>
                            </p>
                            <p id="simple-post-hashtag-{{post.post_data.id}}" ng-if="post.simple_data.hashtag" class="hashtag-grd">
                                <b>Hashtags:</b>
                                <span>
                                    <span class="post-hash-tag" id="sim-post-hashtag-{{post.post_data.id}}" ng-repeat="hashtag in post.simple_data.hashtag.split(' ')">{{hashtag}}</span>
                                </span>
                            </p>                                        
                            <div ng-init="limit = 250; moreShown = false">
                                <span ng-if="post.simple_data.description != ''" id="simple-post-description-{{post.post_data.id}}" ng-bind-html="post.simple_data.description" ng-class="post.simple_data.description.length > 250 ? 'view-more-expand' : ''">
                                </span>
                                <a id="remove-view-more{{post.post_data.id}}" ng-if="post.simple_data.description.length > 250" ng-click="removeViewMore('simple-post-description-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>                            
                            </div>                            
                        </div>

                        <div class="post-discription" ng-if="post.post_data.post_for == 'profile_update'">
                            <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{post.profile_update.data_value}}" ng-click="openModal2('myModalCoverPic'+post.post_data.id);">
                        </div>
                        <div class="post-discription" ng-if="post.post_data.post_for == 'cover_update'">
                            <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.cover_update.data_value}}" ng-if="post.cover_update.data_value != ''" ng-click="openModal2('myModalCoverPic'+post.post_data.id);">
                        </div>
                        <div ng-if="post.post_data.post_for == 'profile_update' || post.post_data.post_for == 'cover_update'" id="myModalCoverPic{{post.post_data.id}}" class="modal modal2" style="display: none;">
                            <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal2('myModalCoverPic'+post.post_data.id)">×</button>
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
                                        <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                    </div>
                                    <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                    <div class="mySlides mySlides2{{post.post_data.id}}">
                                        <div class="numbertext"></div>
                                        <div class="slider_img_p" ng-if="post.post_data.post_for == 'cover_update'">
                                            <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.cover_update.data_value}}" alt="Cover Image" id="cover{{post.post_data.id}}">
                                        </div>
                                        <div class="slider_img_p" ng-if="post.post_data.post_for == 'profile_update'">
                                            <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{post.profile_update.data_value}}" alt="Profile Image" id="cover{{post.post_data.id}}">
                                        </div>
                                    </div>                                
                                </div>
                                <div class="caption-container">
                                    <p id="caption"></p>
                                </div>
                            </div>
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
                                    <p ng-if="post.question_data.link"><b>Link:</b><span ng-bind="post.question_data.link" id="ask-post-link-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.question_data.category"><b>Category:</b><span ng-bind="post.question_data.category" id="ask-post-category-{{post.post_data.id}}"></span></p>
                                    <p ng-if="post.question_data.field"><b>Field:</b><span ng-bind="post.question_data.field" id="ask-post-field-{{post.post_data.id}}"></span></p>
                                </h5>
                                <div class="post-des-detail" ng-if="post.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.opportunity_data.opportunity"></span></div>
                            </div>
                            
                        </div>
                        <div class="post-discription" ng-if="post.post_data.post_for == 'share'">
                            <p id="share-post-desc-{{post.post_data.id}}" ng-if="post.share_data.description" class="ng-scope">
                                <span ng-bind="post.share_data.description" id="share-desc-{{post.post_data.id}}"></span>
                            </p>                            

                            <div id="share-post-detail-{{post.post_data.id}}" ng-if="post.share_data" class="all-post-box">
                                    <div class="all-post-top">
                                        <div class="post-head">
                                            <div class="post-img" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.post_data.post_for == 'question'">
                                                <a ng-href="<?php echo base_url() ?>{{post.share_data.data.user_data.user_slug}}" class="post-name" target="_self" ng-if="post.share_data.data.question_data.is_anonymously == '0'">
                                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.share_data.data.user_data.user_image}}" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.user_data.user_image != '' && post.share_data.data.question_data.is_anonymously == '0'">
                                                    <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.user_data.user_image == '' && post.share_data.data.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.user_data.user_image == '' && post.share_data.data.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                </a>
                                                                
                                                <span class="no-img-post"  ng-if="post.share_data.data.user_data.user_image == '' || post.share_data.data.question_data.is_anonymously == '1'">A</span>
                                            </div>

                                            <div class="post-img" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.post_data.post_for != 'question' && post.share_data.data.user_data.user_image != ''">
                                                <a ng-href="<?php echo base_url() ?>{{post.share_data.data.user_data.user_slug}}" class="post-name" target="_self">
                                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{post.share_data.data.user_data.user_image}}">
                                                </a>
                                            </div>

                                            <div class="post-img no-profile-pic" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.post_data.post_for != 'question' && post.share_data.data.user_data.user_image == ''">
                                                <a ng-href="<?php echo base_url() ?>{{post.share_data.data.user_data.user_slug}}" class="post-name" target="_self">
                                                    <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.share_data.data.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="post.share_data.data.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                </a>
                                            </div>

                                            <div class="post-img" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.post_data.post_for == 'question'">
                                                <a ng-href="<?php echo base_url() ?>company/{{post.share_data.data.user_data.business_slug}}" class="post-name" target="_self" ng-if="post.share_data.data.question_data.is_anonymously == '0'">
                                                    <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{post.share_data.data.user_data.business_user_image}}" ng-if="post.share_data.data.user_data.business_user_image && post.share_data.data.question_data.is_anonymously == '0'">
                                                    <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="!post.share_data.data.user_data.business_user_image" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                                </a>
                                                                
                                                <span class="no-img-post"  ng-if="!post.share_data.data.user_data.business_user_image || post.share_data.data.question_data.is_anonymously == '1'">A</span>
                                            </div>
                                                            
                                            <div class="post-img" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.post_data.post_for != 'question' && post.share_data.data.user_data.business_user_image">
                                                <a ng-href="<?php echo base_url() ?>company/{{post.share_data.data.user_data.business_slug}}" class="post-name" target="_self">
                                                    <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>{{post.share_data.data.user_data.business_user_image}}">
                                                </a>
                                            </div>
                                                            
                                            <div class="post-img no-profile-pic" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.post_data.post_for != 'question' && !post.share_data.data.user_data.business_user_image">
                                                <a ng-href="<?php echo base_url() ?>company/{{post.share_data.data.user_data.business_slug}}" class="post-name" target="_self">
                                                    <img ng-class="post.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                                </a>
                                            </div>

                                            <div class="post-detail">
                                                <div class="fw" ng-if="post.share_data.data.post_data.post_for == 'question'">
                                                    <a href="javascript:void(0)" class="post-name" ng-if="post.share_data.data.question_data.is_anonymously == '1'">Anonymous</a>
                                                    <span class="post-time" ng-if="post.share_data.data.question_data.is_anonymously == '1'"></span>
                                                    <a ng-href="<?php echo base_url() ?>{{post.share_data.data.user_data.user_slug}}" class="post-name" ng-bind="post.share_data.data.user_data.fullname" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.question_data.is_anonymously == '0'" target="_self"></a>
                                                    <a ng-href="<?php echo base_url() ?>company/{{post.share_data.data.user_data.business_slug}}" class="post-name" ng-bind="post.share_data.data.user_data.company_name" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.question_data.is_anonymously == '0'" target="_self"></a>
                                                    <!-- <span class="post-time">{{post.share_data.data.post_data.time_string}}</span> -->
                                                </div>
                                                                
                                                <div class="fw" ng-if="post.share_data.data.post_data.post_for != 'question'">
                                                    <a ng-if="post.share_data.data.post_data.user_type == '1'" ng-href="<?php echo base_url() ?>{{post.share_data.data.user_data.user_slug}}" class="post-name" ng-bind="post.share_data.data.user_data.fullname" target="_self"></a>
                                                    <a ng-if="post.share_data.data.post_data.user_type == '2'" ng-href="<?php echo base_url() ?>company/{{post.share_data.data.user_data.business_slug}}" class="post-name" ng-bind="post.share_data.data.user_data.company_name" target="_self"></a>
                                                    <!-- <span class="post-time">{{post.share_data.data.post_data.time_string}}</span> -->
                                                </div>

                                                <div class="fw" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.post_data.post_for == 'question'">
                                                    <span class="post-designation" ng-if="post.share_data.data.user_data.title_name != null && post.share_data.data.question_data.is_anonymously == '0'" ng-bind="post.share_data.data.user_data.title_name"></span>
                                                    <span class="post-designation" ng-if="post.share_data.data.user_data.title_name == null && post.share_data.data.question_data.is_anonymously == '0'" ng-bind="post.share_data.data.user_data.degree_name"></span>
                                                    <span class="post-designation" ng-if="post.share_data.data.user_data.title_name == null && post.share_data.data.user_data.degree_name == null && post.share_data.data.question_data.is_anonymously == '0'">CURRENT WORK</span>
                                                </div>
                                                <div class="fw" ng-if="post.share_data.data.post_data.user_type == '1' && post.share_data.data.post_data.post_for != 'question'">
                                                    <span class="post-designation" ng-if="post.share_data.data.user_data.title_name != null" ng-bind="post.share_data.data.user_data.title_name"></span>
                                                    <span class="post-designation" ng-if="post.share_data.data.user_data.title_name == null" ng-bind="post.share_data.data.user_data.degree_name"></span>
                                                    <span class="post-designation" ng-if="post.share_data.data.user_data.title_name == null && post.share_data.data.user_data.degree_name == null">CURRENT WORK</span>
                                                </div>

                                                <div class="fw" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.post_data.post_for == 'question'">
                                                    <span class="post-designation" ng-if="post.share_data.data.user_data.industry_name != null && post.share_data.data.question_data.is_anonymously == '0'" ng-bind="post.share_data.data.user_data.industry_name"></span> 
                                                    <span class="post-designation" ng-if="!post.share_data.data.user_data.industry_name && post.share_data.data.question_data.is_anonymously == '0'">CURRENT WORK</span>
                                                </div>
                                                <div class="fw" ng-if="post.share_data.data.post_data.user_type == '2' && post.share_data.data.post_data.post_for != 'question'">
                                                    <span class="post-designation" ng-if="post.share_data.data.user_data.industry_name" ng-bind="post.share_data.data.user_data.industry_name"></span> 
                                                    <span class="post-designation" ng-if="!post.share_data.data.user_data.industry_name">CURRENT WORK</span>
                                                </div>

                                            </div>            
                                        </div>
                                        <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'opportunity'">
                                           
                                            <div id="post-opp-detail-{{post.share_data.data.post_data.id}}">
                                                <div class="post-title opp-title-cus">
                                                    <p ng-if="post.share_data.data.opportunity_data.opptitle"><b>Title of Opportunity:</b><h1 ng-bind="post.share_data.data.opportunity_data.opptitle" id="opp-title-{{post.share_data.data.post_data.id}}"></h1></p>
                                                </div>
                                                <h5 class="post-title">
                                                    <p ng-if="post.share_data.data.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="post.share_data.data.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{post.share_data.data.post_data.id}}"></span></p>
                                                    <p ng-if="post.share_data.data.opportunity_data.location"><b>Location:</b><span ng-bind="post.share_data.data.opportunity_data.location" id="opp-post-location-{{post.share_data.data.post_data.id}}"></span></p>
                                                    <p ng-if="post.share_data.data.opportunity_data.field"><b>Field:</b><span ng-bind="post.share_data.data.opportunity_data.field" id="opp-post-field-{{post.share_data.data.post_data.id}}"></span></p>
                                                    <p ng-if="!post.share_data.data.opportunity_data.field || post.share_data.data.opportunity_data.field == 0"><b>Field:</b><span ng-bind="post.share_data.data.opportunity_data.other_field" id="opp-post-field-{{post.share_data.data.post_data.id}}"></span></p>
                                                    <p ng-if="post.share_data.data.opportunity_data.hashtag" class="hashtag-grd"><b>Hashtags:</b>
                                                        <span>
                                                            <span class="post-hash-tag" id="opp-post-hashtag-{{post.share_data.data.post_data.id}}" ng-repeat="hashtag in post.share_data.data.opportunity_data.hashtag.split(' ')">{{hashtag}}</span>
                                                        </span>
                                                    </p>                                            
                                                    <p ng-if="post.share_data.data.opportunity_data.company_name"><b>Company Name:</b><span ng-bind="post.share_data.data.opportunity_data.company_name" id="opp-post-company-{{post.share_data.data.post_data.id}}"></span></p>
                                                </h5>
                                                <div class="post-des-detail" ng-if="post.share_data.data.opportunity_data.opportunity">
                                                    <div id="opp-post-opportunity-{{post.share_data.data.post_data.id}}" ng-class="post.share_data.data.opportunity_data.opportunity.length > 250 ? 'view-more-expand' : ''">
                                                        <b>Opportunity:</b>
                                                        <span ng-bind-html="post.share_data.data.opportunity_data.opportunity"></span>
                                                        <a id="remove-view-more{{post.share_data.data.post_data.id}}" ng-if="post.share_data.data.opportunity_data.opportunity.length > 250" ng-click="removeViewMore('opp-post-opportunity-'+post.share_data.data.post_data.id,'remove-view-more'+post.share_data.data.post_data.id);" class="read-more-post">.... Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'simple'">
                                            <p ng-if="post.share_data.data.simple_data.sim_title"><b>Title:</b> <span ng-bind="post.share_data.data.simple_data.sim_title" id="opp-title-{{post.share_data.data.post_data.id}}"></span></p>
                                            <p ng-if="post.share_data.data.simple_data.hashtag" class="hashtag-grd">
                                                <b>Hashtags:</b>
                                                <span>
                                                    <span class="post-hash-tag" id="sim-post-hashtag-{{post.share_data.data.post_data.id}}" ng-repeat="hashtag in post.share_data.data.simple_data.hashtag.split(' ')">{{hashtag}}</span>
                                                </span>
                                            </p>
                                            <div ng-init="limit = 250; moreShown = false">
                                                <span ng-if="post.share_data.data.simple_data.description != ''" id="simple-post-description-{{post.share_data.data.post_data.id}}" ng-bind-html="post.share_data.data.simple_data.description" ng-class="post.share_data.data.simple_data.description.length > 250 ? 'view-more-expand' : ''">
                                                </span>
                                                <a id="remove-view-more{{post.share_data.data.post_data.id}}" ng-if="post.share_data.data.simple_data.description.length > 250" ng-click="removeViewMore('simple-post-description-'+post.share_data.data.post_data.id,'remove-view-more'+post.share_data.data.post_data.id);" class="read-more-post">.... Read More</a>                                        
                                            </div>                                    
                                        </div>
                                        <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'article'">
                                            <p ng-if="post.share_data.data.article_data.hashtag" class="hashtag-grd">
                                                <span>
                                                    <span class="post-hash-tag" id="opp-post-hashtag-{{post.share_data.data.post_data.id}}" ng-repeat="hashtag in post.share_data.data.article_data.hashtag.split(' ')">{{hashtag}}</span>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="post-images article-post-cus" ng-if="post.share_data.data.post_data.post_for == 'article'">
                                            <div class="one-img" ng-class="post.share_data.data.article_data.article_featured_image == '' ? 'article-default-featured' : ''">
                                                <a href="<?php echo base_url(); ?>article/{{post.share_data.data.article_data.article_slug}}" target="_self">
                                                    <img ng-src="<?php echo base_url().$this->config->item('article_featured_upload_path'); ?>{{post.share_data.data.article_data.article_featured_image}}" alt="{{post.share_data.data.article_data.article_title}}" ng-if="post.share_data.data.article_data.article_featured_image != ''">

                                                    <img ng-src="<?php echo base_url('assets/img/art-default.jpg'); ?>{{post.share_data.data.article_data.article_featured_image}}" alt="{{post.share_data.data.article_data.article_title}}" ng-if="post.share_data.data.article_data.article_featured_image == ''">
                                                    <div class="article-post-text">
                                                        <h3>{{post.share_data.data.article_data.article_title}}</h3>
                                                        <p>{{post.share_data.data.post_data.user_type == '1' ? post.share_data.data.user_data.fullname : post.share_data.data.user_data.company_name}}'s Article on Aileensoul</p>
                                                    </div>
                                                </a>                            
                                            </div>
                                        </div>
                                        <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'profile_update'">
                                            <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{post.share_data.data.profile_update.data_value}}" ng-click="openModal2('myModalCoverPicShare'+post.share_data.data.post_data.id);">
                                        </div>
                                        <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'cover_update'">
                                            <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.share_data.data.cover_update.data_value}}" ng-if="post.share_data.data.cover_update.data_value != ''" ng-click="openModal2('myModalCoverPicShare'+post.share_data.data.post_data.id);">
                                        </div>
                                        <div ng-if="post.share_data.data.post_data.post_for == 'profile_update' || post.share_data.data.post_data.post_for == 'cover_update'" id="myModalCoverPicShare{{post.share_data.data.post_data.id}}" tabindex="-1" role="dialog"  class="modal modal2" style="display: none;">
                                            <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModalShare('myModalCoverPicShare'+post.share_data.data.post_data.id)">×</button>
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
                                                        <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                                    </div>
                                                    <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                                    <div class="mySlides mySlides2{{post.share_data.data.post_data.id}}">
                                                        <div class="numbertext"></div>
                                                        <div class="slider_img_p" ng-if="post.share_data.data.post_data.post_for == 'cover_update'">
                                                            <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{post.share_data.data.cover_update.data_value}}" alt="Cover Image" id="cover{{post.share_data.data.post_data.id}}">
                                                        </div>
                                                        <div class="slider_img_p" ng-if="post.share_data.data.post_data.post_for == 'profile_update'">
                                                            <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{post.share_data.data.profile_update.data_value}}" alt="Profile Image" id="cover{{post.share_data.data.post_data.id}}">
                                                        </div>
                                                    </div>                                
                                                </div>
                                                <div class="caption-container">
                                                    <p id="caption"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-discription" ng-if="post.share_data.data.post_data.post_for == 'question'">
                                            <div id="ask-que-{{post.share_data.data.post_data.id}}" class="post-des-detail">
                                                <h5 class="post-title">
                                                    <div ng-if="post.share_data.data.question_data.question"><b>Question:</b><span ng-bind="post.share_data.data.question_data.question" id="ask-post-question-{{post.share_data.data.post_data.id}}"></span></div>                                        
                                                    <div class="post-des-detail" ng-if="post.share_data.data.question_data.description">
                                                        <div id="ask-que-desc-{{post.share_data.data.post_data.id}}" ng-class="post.share_data.data.question_data.description.length > 250 ? 'view-more-expand' : ''">
                                                            <b>Description:</b>
                                                            <span ng-bind-html="post.share_data.data.question_data.description"></span>
                                                            <a id="remove-view-more{{post.share_data.data.post_data.id}}" ng-if="post.share_data.data.question_data.description.length > 250" ng-click="removeViewMore('ask-que-desc-'+post.share_data.data.post_data.id,'remove-view-more'+post.share_data.data.post_data.id);" class="read-more-post">.... Read More</a>
                                                        </div>                                            
                                                    </div>
                                                    <p ng-if="post.share_data.data.question_data.link"><b>Link:</b><span ng-bind="post.share_data.data.question_data.link" id="ask-post-link-{{post.share_data.data.post_data.id}}"></span></p>
                                                    <p ng-if="post.share_data.data.question_data.category"><b>Category:</b><span ng-bind="post.share_data.data.question_data.category" id="ask-post-category-{{post.share_data.data.post_data.id}}"></span></p>
                                                    <p ng-if="post.share_data.data.question_data.hashtag"><b>Hashtag:</b><span ng-bind="post.share_data.data.question_data.hashtag" class="post-hash-tag" id="ask-post-hashtag-{{post.post_data.id}}"></span></p>
                                                    <p ng-if="post.share_data.data.question_data.field"><b>Field:</b><span ng-bind="post.share_data.data.question_data.field" id="ask-post-field-{{post.share_data.data.post_data.id}}"></span></p>
                                                </h5>
                                                <div class="post-des-detail" ng-if="post.share_data.data.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.share_data.data.opportunity_data.opportunity"></span></div>
                                            </div>                                    
                                        </div>
                                        <div class="post-images" ng-if="post.share_data.data.post_data.total_post_files == 1">
                                            <div class="one-img" ng-repeat="post_file in post.share_data.data.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                                <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                                    <img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)">
                                                </a>
                                                <span ng-if="post_file.file_type == 'video'"> 
                                                    <video controls width = "100%" height = "350" preload="metadata" ng-attr-poster="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}jpg">
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
                                        <div class="post-images" ng-if="post.share_data.data.post_data.total_post_files == 2">
                                            <div class="two-img" ng-repeat="post_file in post.share_data.data.post_file_data">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                            </div>
                                        </div>
                                        <div class="post-images" ng-if="post.share_data.data.post_data.total_post_files == 3">
                                            <span ng-repeat="post_file in post.share_data.data.post_file_data">
                                                <div class="three-img-top" ng-if="$index == '0'">
                                                    <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                                </div>
                                                <div class="two-img" ng-if="$index == '1'">
                                                    <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                                </div>
                                                <div class="two-img" ng-if="$index == '2'">
                                                    <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                                </div>
                                            </span>
                                        </div>
                                        <div class="post-images four-img" ng-if="post.share_data.data.post_data.total_post_files >= 4">
                                            <div class="two-img" ng-repeat="post_file in post.share_data.data.post_file_data| limitTo:4">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                                <div class="view-more-img" ng-if="$index == 3 && post.share_data.data.post_data.total_post_files > 4">
                                                    <span><a href="javascript:void(0);" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)">View All ({{post.share_data.data.post_data.total_post_files - 4}})</a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="myModalShare{{post.share_data.data.post_data.id}}" class="modal modal2" tabindex="-1" role="dialog" style="display: none;">
                                            <button type="button" class="modal-close" ng-click="closeModalShare('myModalShare'+post.share_data.data.post_data.id)">×</button>
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                                    </div>
                                                    <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                                    <div class="mySlides mySlides2{{post.share_data.data.post_data.id}}" ng-repeat="_photoData in post.share_data.data.post_file_data">
                                                        <div class="numbertext">{{$index + 1}} / {{post.share_data.data.post_data.total_post_files}}</div>
                                                        <div class="slider_img_p">
                                                            <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                                                        </div>
                                                    </div>                                
                                                </div>
                                                <div class="caption-container">
                                                    <p id="caption"></p>
                                                </div>
                                            </div> 
                                            <a ng-if="post.share_data.data.post_file_data.length > 1" class="prev" style="left:0px;" ng-click="plusSlides2(-1,post.share_data.data.post_data.id)">&#10094;</a>
                                            <a ng-if="post.share_data.data.post_file_data.length > 1" class="next" ng-click="plusSlides2(1,post.share_data.data.post_data.id)">&#10095;</a>
                                        </div>                                    
                                    </div>
                            </div>
                        </div>
                        <div class="post-images" ng-if="post.post_data.total_post_files == 1">
                            <div class="one-img" ng-repeat="post_file in post.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                    <img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)">
                                </a>
                                <span ng-if="post_file.file_type == 'video'"> 
                                    <video controls width = "100%" height = "350" preload="metadata" ng-attr-poster="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}jpg">
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
                        <div class="post-images" ng-if="post.post_data.total_post_files == 2">
                            <div class="two-img" ng-repeat="post_file in post.post_file_data">
                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                            </div>
                        </div>
                        <div class="post-images" ng-if="post.post_data.total_post_files == 3">
                            <span ng-repeat="post_file in post.post_file_data">
                                <div class="three-img-top" ng-if="$index == '0'">
                                    <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                </div>
                                <div class="two-img" ng-if="$index == '1'">
                                    <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                </div>
                                <div class="two-img" ng-if="$index == '2'">
                                    <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)"></a>
                                </div>
                            </span>
                        </div>
                        <div class="post-images four-img" ng-if="post.post_data.total_post_files >= 4">
                            <div class="two-img" ng-repeat="post_file in post.post_file_data| limitTo:4">
                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,'myModal'+post.post_data.id)"></a>
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
                                    <div class="mySlides myModal{{post.post_data.id}}" ng-repeat="_photoData in post.post_file_data">
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
                            <a ng-if="post.post_file_data.length > 1" class="prev" style="left:0px;" ng-click="plusSlides2(-1,'myModal'+post.post_data.id)">&#10094;</a>
                            <a ng-if="post.post_file_data.length > 1" class="next" ng-click="plusSlides2(1,'myModal'+post.post_data.id)">&#10095;</a>
                        </div>

                        <div class="post-bottom">
                            <div class="like-list">
                                <ul id="" class="bottom-left like_user_list">
                                    <li class="like-img" ng-if="post.user_like_list.length > 0" ng-repeat="user_like in post.user_like_list">
                                        <a class="ripple" href="<?php echo base_url(); ?>{{user_like.user_slug}}" target="_self" title="{{user_like.fullname}}">
                                            <img ng-if="user_like.user_image" ng-src="<?php echo USER_THUMB_UPLOAD_URL; ?>{{user_like.user_image}}">
                                            <img ng-if="!user_like.user_image && user_like.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                            <img ng-if="!user_like.user_image && user_like.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        </a>
                                    </li>                                   
                                    <li class="like-img">
                                        <a href="javascript:void(0)" ng-click="like_user_list(post.post_data.id);" ng-bind="post.post_like_data" id="post-other-like-{{post.post_data.id}}"></a>
                                    </li>
                                </ul>
                                <ul class="pull-right">
                                    <li class="visit-post">
                                        <a class="btn3" href="https://www.commissioncrowd.com/?ref=dZeBOICH"  target="_self"><svg viewBox="0 0 209.281 209.281" width="13px" height="13px"><g><path d="M203.456,139.065c3.768-10.786,5.824-22.369,5.824-34.425s-2.056-23.639-5.824-34.425c-0.092-0.324-0.201-0.64-0.333-0.944  C188.589,28.926,149.932,0,104.641,0S20.692,28.926,6.159,69.271c-0.132,0.305-0.242,0.62-0.333,0.944  c-3.768,10.786-5.824,22.369-5.824,34.425s2.056,23.639,5.824,34.425c0.092,0.324,0.201,0.64,0.333,0.944  c14.534,40.346,53.191,69.271,98.482,69.271s83.948-28.926,98.482-69.271C203.255,139.705,203.364,139.39,203.456,139.065z   M104.641,194.281c-3.985,0-10.41-7.212-15.78-23.324c-2.592-7.775-4.667-16.713-6.179-26.436H126.6  c-1.512,9.723-3.587,18.66-6.178,26.436C115.051,187.069,108.626,194.281,104.641,194.281z M80.862,129.521  c-0.721-7.998-1.102-16.342-1.102-24.881s0.381-16.883,1.102-24.881h47.557c0.721,7.998,1.102,16.342,1.102,24.881  s-0.381,16.883-1.102,24.881H80.862z M15.001,104.641c0-8.63,1.229-16.978,3.516-24.881h47.3  c-0.701,8.163-1.057,16.529-1.057,24.881s0.355,16.718,1.057,24.881h-47.3C16.23,121.618,15.001,113.271,15.001,104.641z   M104.641,15c3.985,0,10.411,7.212,15.781,23.324c2.591,7.775,4.667,16.713,6.178,26.435H82.681  c1.512-9.723,3.587-18.66,6.179-26.435C94.231,22.212,100.656,15,104.641,15z M143.464,79.76h47.3  c2.287,7.903,3.516,16.251,3.516,24.881s-1.229,16.978-3.516,24.881h-47.3c0.701-8.163,1.057-16.529,1.057-24.881  S144.165,87.923,143.464,79.76z M184.903,64.76h-43.16c-2.668-18.397-7.245-34.902-13.666-46.644  C152.972,24.865,173.597,42.096,184.903,64.76z M81.204,18.115C74.783,29.857,70.206,46.362,67.538,64.76h-43.16  C35.685,42.096,56.309,24.865,81.204,18.115z M24.378,144.521h43.16c2.668,18.397,7.245,34.902,13.666,46.645  C56.309,184.416,35.685,167.186,24.378,144.521z M128.077,191.166c6.421-11.742,10.998-28.247,13.666-46.645h43.16  C173.597,167.186,152.972,184.416,128.077,191.166z" data-original="#7b7b7b" class="active-path" fill="#7b7b7b"/></g> </svg><span>Visit</span></a>
                                    </li>
                                    <li class="view-post">
                                        <span>25 Views</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-md-9 col-sm-9 col-xs-10 mob-pr0">
                                    <ul class="bottom-left">
                                        <li class="user-likes">
                                            <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id,$index,1,post.post_data.user_id)" ng-if="post.is_userlikePost == '1'" class="like"><i class="fa fa-thumbs-up"></i>
                                                <span style="{{post.post_like_count > 0 ? '' : 'display: none';}}" id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span></a>
                                            <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id,$index,1,post.post_data.user_id)" ng-if="post.is_userlikePost == '0'"><i class="fa fa-thumbs-up"></i>
                                                <span style="{{post.post_like_count > 0 ? '' : 'display: none';}}" id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span>
                                            </a>
                                        </li>
                                        <li class="comment-count"><a href="javascript:void(0);" ng-click="viewAllComment(post.post_data.id, $index, post,1)" ng-if="post.post_comment_data.length <= 1" id="comment-icon-{{post.post_data.id}}" class="last-comment" title="View Comments"><i class="fa fa-comment-o"></i><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span></a></li>
                                         <li class="comment-count"><a href="javascript:void(0);" ng-click="viewLastComment(post.post_data.id, $index, post,1)" ng-if="post.post_comment_data.length > 1" id="comment-icon-{{post.post_data.id}}" class="all-comment"  title="View Comments"><i class="fa fa-comment-o"></i><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span></a></li>
                                        <li>
                                            <a id="share-post-{{post.post_data.id}}" ng-click="share_post(post.post_data.id, $index, post, 1)" href="javascript:void(0);" title="Share Post"><i class="fa fa-share-alt" aria-hidden="true"></i><span ng-if="post.post_share_count > 0">{{post.post_share_count}}</span></a>
                                        </li>
                                        
                                    </ul>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-2 mob-pl0">
                                    <ul class="pull-right bottom-right">
                                        <!--li class="like-count" ng-click="like_user_list(post.post_data.id);"><span style="{{post.post_like_count > 0 ? '' : 'display: none';}}" id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span><span>Like</span></li-->
                                        <!-- <li class="comment-count"><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span><span>Comment</span></li> -->


                                        <li class="post-save">
                                            <a ng-if="post.is_user_saved_post == '0'" id="save-post-{{post.post_data.id}}" ng-click="save_post(post.post_data.id, $index, post, 1)" href="javascript:void(0);" title="Save Post"><img src="<?php echo base_url('assets/n-images/save-post.svg'); ?>"></a>
                                            <a ng-if="post.is_user_saved_post == '1'" id="saved-post-{{post.post_data.id}}" href="javascript:void(0);" title="Saved Post"><img src="<?php echo base_url('assets/n-images/saved-post.svg'); ?>"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="like-other-box">                                        
                        </div>
                    </div>
                    <div class="all-post-bottom comment-for-post-{{post.post_data.id}}">
                        <div class="comment-box">
                            <div class="post-comment" nf-if="post.post_comment_data.length > 0" ng-repeat="comment in post.post_comment_data" ng-init="commentIndex=$index">
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
                                    <div class="comment-dis-inner" id="comment-dis-inner-{{comment.comment_id}}">
                                        <p dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{comment.comment}}" dd-text-collapse-cond="true"></p>
                                    </div>

                                    <div class="edit-comment" id="edit-comment-{{comment.comment_id}}" style="display:none;">
                                        <div class="comment-input">
                                            <!--<div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" onpaste="OnPaste_StripFormatting(event);"></div>-->
                                            <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}}, post.post_data.id, post.post_data.user_id)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="cmt_handle_paste_edit($event)" ng-keydown="check_comment_char_count_edit(comment.comment_id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                                            <div class="editCommentTaxBox-{{comment.comment_id}} all-hashtags-list"></div>
                                        </div>
                                        <div class="mob-comment">
                                            <button ng-click="sendEditComment(comment.comment_id, post.post_data.id, post.post_data.user_id)"><img ng-src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                        </div>
                                        
                                        <div class="comment-submit hidden-mob">
                                            <button class="btn2" ng-click="sendEditComment(comment.comment_id, post.post_data.id, post.post_data.user_id)">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-action">
                                    <ul class="pull-left">
                                        <li><a href="javascript:void(0);" id="cmt-reply-fnc-{{comment.comment_id}}" ng-click="comment_reply(postIndex,commentIndex,0,0,comment)">Reply</a></li>

                                        <li ng-if="comment.is_userlikePostComment == '1'"><a href="javascript:void(0);" id="cmt-like-fnc-{{comment.comment_id}}" ng-click="likePostComment(comment.comment_id, post.post_data.id, comment.commented_user_id)" class="like"><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span> Like</a></li>

                                        <li ng-if="comment.is_userlikePostComment == '0'"><a href="javascript:void(0);" id="cmt-like-fnc-{{comment.comment_id}}" ng-click="likePostComment(comment.comment_id, post.post_data.id, comment.commented_user_id)"><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span> Like</a></li>

                                        <li id="cancel-comment-li-{{comment.comment_id}}" style="display: none;"><a href="javascript:void(0);" ng-click="cancelPostComment(comment.comment_id, post.post_data.id, $parent.$index, commentIndex)">Cancel</a></li> 
                                        
                                        <li><a href="javascript:void(0);" ng-bind="comment.comment_time_string"></a></li>
                                    </ul>
                                    <ul class="pull-right">
                                        <li ng-if="comment.commented_user_id == user_id" id="edit-comment-li-{{comment.comment_id}}"><a href="javascript:void(0);" ng-click="editPostComment(comment.comment_id, post.post_data.id, postIndex, commentIndex,1)"><img src="<?php echo base_url('assets/n-images/edit.svg') ?>"></a></li>
                                        <li ng-if="post.post_data.user_id == user_id || comment.commented_user_id == user_id"><a href="javascript:void(0);" ng-click="deletePostComment(comment.comment_id, post.post_data.id, postIndex, commentIndex, post,1)"><img src="<?php echo base_url('assets/n-images/delet.svg') ?>"></a></li>
                                    </ul>
                                </div>

                                <div class="post-comment reply-comment" nf-if="comment.comment_reply_data.length > 0" ng-repeat="commentreply in comment.comment_reply_data" ng-init="commentReplyIndex=$index">
                                    <div class="post-img">
                                        <div ng-if="commentreply.user_image != ''">
                                            <a ng-href="<?php echo base_url() ?>{{commentreply.user_slug}}" class="post-name" target="_self">
                                                <img ng-class="commentreply.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{commentreply.user_image}}">
                                            </a>
                                        </div>
                                        <div class="post-img" ng-if="commentreply.user_image == ''">
                                            <a ng-href="<?php echo base_url() ?>{{commentreply.user_slug}}" class="post-name" target="_self">
                                                <img ng-class="commentreply.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" commentreply.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-class="commentreply.commented_user_id == user_id ? 'login-user-pro-pic' : ''" ng-if=" commentreply.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="comment-dis">
                                        <div class="comment-name"><a ng-href="<?php echo base_url() ?>{{commentreply.user_slug}}" class="post-name" target="_self" ng-bind="commentreply.username"></a></div>
                                        <div class="comment-dis-inner" id="comment-reply-dis-inner-{{commentreply.comment_id}}">
                                            <p dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{commentreply.comment}}" dd-text-collapse-cond="true"></p>
                                        </div>

                                        <div class="edit-reply-comment" id="edit-reply-comment-{{commentreply.comment_id}}" style="display:none;">
                                            <div class="comment-input">                 
                                                <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="send_edit_comment_reply({{commentreply.comment_id}}, post.post_data.id)" id="edit-comment-reply-textbox-{{commentreply.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="cmt_handle_paste_edit($event)" ng-keydown="check_comment_char_count_edit(commentreply.comment_id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                                                <div class="edit-comment-reply-textbox-{{commentreply.comment_id}} all-hashtags-list"></div>
                                            </div>
                                            <div class="mob-comment">
                                                <button ng-click="send_edit_comment_reply(commentreply.comment_id, post.post_data.id)"><img ng-src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                            </div>                                        
                                            <div class="comment-submit hidden-mob">
                                                <button class="btn2" ng-click="send_edit_comment_reply(commentreply.comment_id, post.post_data.id)">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment-action">
                                        <ul class="pull-left">
                                            <li><a href="javascript:void(0);" id="cmt-reply-fnc-{{commentreply.comment_id}}" ng-click="comment_reply(postIndex,commentIndex,user_id,commentreply.commented_user_id,commentreply)">Reply</a></li>

                                            <li ng-if="commentreply.is_userlikePostComment == '1'"><a href="javascript:void(0);" id="cmt-like-fnc-{{commentreply.comment_id}}" ng-click="likePostComment(commentreply.comment_id, post.post_data.id, comment.commented_user_id)" class="like"><span ng-bind="commentreply.postCommentLikeCount" id="post-comment-like-{{commentreply.comment_id}}"></span> Like</a></li>

                                            <li ng-if="commentreply.is_userlikePostComment == '0'"><a href="javascript:void(0);" id="cmt-like-fnc-{{commentreply.comment_id}}" ng-click="likePostComment(commentreply.comment_id, post.post_data.id, comment.commented_user_id)"><span ng-bind="commentreply.postCommentLikeCount" id="post-comment-like-{{commentreply.comment_id}}"></span> Like</a></li>

                                            <li id="cancel-reply-comment-li-{{commentreply.comment_id}}" style="display: none;"><a href="javascript:void(0);" ng-click="cancel_post_comment_reply(commentreply.comment_id, post.post_data.id, postIndex, commentIndex,commentReplyIndex)">Cancel</a></li> 
                                            
                                            <li id="timeago-reply-comment-li-{{commentreply.comment_id}}"><a href="javascript:void(0);" ng-bind="commentreply.comment_time_string"></a></li>
                                        </ul>
                                        <ul class="pull-right">
                                            <li ng-if="commentreply.commented_user_id == user_id" id="edit-comment-li-{{commentreply.comment_id}}"><a href="javascript:void(0);" ng-click="edit_post_comment_reply(commentreply.comment_id, post.post_data.id, postIndex, commentIndex,commentReplyIndex)"><img src="<?php echo base_url('assets/n-images/edit.svg') ?>"></a></li>
                                            <li ng-if="post.post_data.user_id == user_id || commentreply.commented_user_id == user_id"><a href="javascript:void(0);" ng-click="deletePostComment(commentreply.comment_id, post.post_data.id, postIndex, commentIndex, post,1)"><img src="<?php echo base_url('assets/n-images/delet.svg') ?>"></a></li>
                                        </ul>
                                    </div>
                                    
                                </div>

                                <div id="comment-reply-{{postIndex}}-{{commentIndex}}" class="comment-reply" style="display: none;">
                                    <div class="post-img">
                                        <?php 
                                        if ($leftbox_data['user_image'] != '')
                                        { ?> 
                                            <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '' ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
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
                                    <div class="comment-dis">
                                        <div class="edit-comment">
                                            <div class="comment-input">             
                                                <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendCommentReply({{comment.comment_id}}, post.post_data.id,postIndex, commentIndex,1)" id="reply-comment-{{postIndex}}-{{commentIndex}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="cmt_handle_paste_edit($event)" ng-keydown="check_comment_char_count_edit(comment.comment_id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                                                <div class="reply-comment-{{postIndex}}-{{commentIndex}} all-hashtags-list"></div>
                                            </div>
                                            <div class="mob-comment">
                                                <button ng-click="sendCommentReply(comment.comment_id, post.post_data.id, postIndex, commentIndex,1)"><img ng-src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                            </div>
                                            
                                            <div class="comment-submit hidden-mob">
                                                <button class="btn2" ng-click="sendCommentReply(comment.comment_id, post.post_data.id, postIndex, commentIndex, 1)">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="add-comment new-comment-{{post.post_data.id}}">
                                <div class="post-img">
                                    <?php 
                                    if ($leftbox_data['user_image'] != '')
                                    { ?> 
                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '' ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
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
                                    <div contenteditable="true" data-directive ng-model="comment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendComment({{post.post_data.id}},$index,post,1)" id="commentTaxBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" ng-paste="cmt_handle_paste($event)" ng-keydown="check_comment_char_count(post.post_data.id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                                    <div class="commentTaxBox-{{post.post_data.id}} all-hashtags-list"></div>
                                </div>
                                <div class="mob-comment">
                                    <button id="cmt-btn-mob-{{post.post_data.id}}"  ng-click="sendComment(post.post_data.id, $index, post,1)"><img ng-src="<?php echo base_url('assets/img/send.png') ?>"></button>
                                </div>
                                <div class="comment-submit hidden-mob">
                                    <button id="cmt-btn-{{post.post_data.id}}" class="btn2" ng-click="sendComment(post.post_data.id, $index, post,1)">Comment</button>
                                </div>
                            </div>
                        </div>
                    </div>                              
                </div>
            </div>

            <div ng-if="(postIndex + 1) % <?php echo ADS_BREAK; ?> == 0">
                <div class="tab-add">
                    <adsense ad-client="ca-pub-6060111582812113" ad-slot="6296725909" inline-style="display:block;" ad-format="fluid" data-ad-layout-key="-6r+eg+1e-3d+36" ad-class="infeed"></adsense>
                    <?php //$this->load->view('infeed_add'); ?>
                </div>
            </div>
            <div ng-if="(postIndex + 1) / 10 === 1 && contact_suggetion_1">
                <div class="all-contact-cus">
                    <div class="all-contact">
                        <h4><a href="<?php echo base_url('contact-request') ?>" target="_self">All Contacts</a></h4> 
                        <div class="all-user-list">
                            <data-owl-carousel class="owl-carousel owl-carousel1" data-options="{{owlOptionsTestimonials}}">
                                <div owl-carousel-item="" ng-repeat="contact in contact_suggetion_1" class="item">
                                    <div class="item" id="item-{{contact.user_id}}">
                                        <div class="arti-profile-box">
                                            <div class="user-cover-img" ng-if="contact.profile_background != null && contact.profile_background != ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"   target="_self">
                                                    <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{contact.profile_background}}">
                                                </a>
                                            </div>
                                            <div class="user-cover-img" ng-if="contact.profile_background == null || contact.profile_background == ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"   target="_self">
                                                    <div class="gradient-bg" style="height: 100%"></div>
                                                </a>
                                            </div>
                                            <div class="user-pr-img" ng-if="contact.user_image != ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"   target="_self">
                                                    <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{contact.user_image}}">
                                                </a>
                                            </div>
                                            <div class="user-pr-img" ng-if="contact.user_image == ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"   target="_self">
                                                    <img ng-if="contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <img ng-if="contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                </a>
                                            </div>
                                            <div class="user-info-text text-center">
                                                <h3>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-bind="(contact.first_name | limitTo:1 | uppercase) + (contact.first_name.substr(1) | lowercase)+' '+ (contact.last_name | limitTo:1 | uppercase) + (contact.last_name.substr(1) | lowercase)" target="_self"></a>
                                                </h3>
                                                <p>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name != null && contact.degree_name == null" target="_self">{{contact.title_name| uppercase}}</a>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.degree_name != null && contact.title_name == null" target="_self">{{contact.degree_name| uppercase}}</a>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name == null && contact.degree_name == null" target="_self">CURRENT WORK</a>
                                                </p>
                                            </div>
                                            <div class="author-btn">
                                                <div class="user-btns">
                                                    <a class="btn3 addtobtn-{{contact.user_id}}" ng-click="addToContact(contact.user_id, contact)">Add to Contacts</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div owl-carousel-item="" class="item last-item-box">
                                    <div class="arti-profile-box">
                                        <div class="user-cover-img">
                                            <a href="<?php echo base_url('contact-request') ?>" target="_self">
                                                <div class="gradient-bg" style="height: 100%"></div>
                                            </a>
                                        </div>
                                        <div class="find-more user-pr-img">
                                            <img src="<?php echo base_url('assets/n-images/view-all.png') ?>">
                                        </div>                            
                                        <div class="user-info-text text-center">
                                            <h3>
                                                <a href="<?php echo base_url('contact-request') ?>" target="_self">Find More Contacts
                                                </a>
                                            </h3>                                
                                        </div>
                                        <div class="author-btn">
                                            <div class="user-btns">
                                                <a class="btn3" href="<?php echo base_url('contact-request') ?>" target="_self">View More</a>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </data-owl-carousel>
                        </div>
                    </div>
                </div>
            </div>
            <div ng-if="(postIndex + 1) / 20 === 1 && contact_suggetion_2">
                <div class="all-contact-cus">
                    <div class="all-contact">
                        <h4><a href="<?php echo base_url('contact-request') ?>" target="_self">All Contacts</a></h4> 
                        <div class="all-user-list">
                            <data-owl-carousel class="owl-carousel owl-carousel1" data-options="{{owlOptionsTestimonials}}">                                
                                <div owl-carousel-item="" ng-repeat="contact in contact_suggetion_2" class="item">
                                    <div class="item" id="item-{{contact.user_id}}">
                                        <div class="arti-profile-box">
                                            <div class="user-cover-img" ng-if="contact.profile_background != null && contact.profile_background != ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"   target="_self">
                                                    <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{contact.profile_background}}">
                                                </a>
                                            </div>
                                            <div class="user-cover-img" ng-if="contact.profile_background == null || contact.profile_background == ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"   target="_self">
                                                    <div class="gradient-bg" style="height: 100%"></div>
                                                </a>
                                            </div>
                                            <div class="user-pr-img" ng-if="contact.user_image != ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"   target="_self">
                                                    <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{contact.user_image}}">
                                                </a>
                                            </div>
                                            <div class="user-pr-img" ng-if="contact.user_image == ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"   target="_self">
                                                    <img ng-if="contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <img ng-if="contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                </a>
                                            </div>
                                            <div class="user-info-text text-center">
                                                <h3>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-bind="(contact.first_name | limitTo:1 | uppercase) + (contact.first_name.substr(1) | lowercase)+' '+ (contact.last_name | limitTo:1 | uppercase) + (contact.last_name.substr(1) | lowercase)" target="_self"></a>
                                                </h3>
                                                <p>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name != null && contact.degree_name == null" target="_self">{{contact.title_name| uppercase}}</a>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.degree_name != null && contact.title_name == null" target="_self">{{contact.degree_name| uppercase}}</a>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name == null && contact.degree_name == null" target="_self">CURRENT WORK</a>
                                                </p>
                                            </div>
                                            <div class="author-btn">
                                                <div class="user-btns">
                                                    <a class="btn3 addtobtn-{{contact.user_id}}" ng-click="addToContact(contact.user_id, contact)">Add to Contacts</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div owl-carousel-item="" class="item last-item-box">
                                    <div class="arti-profile-box">
                                        <div class="user-cover-img">
                                            <a href="<?php echo base_url('contact-request') ?>" target="_self">
                                                <div class="gradient-bg" style="height: 100%"></div>
                                            </a>
                                        </div>
                                        <div class="find-more user-pr-img">
                                            <img src="<?php echo base_url('assets/n-images/view-all.png') ?>">
                                        </div>                            
                                        <div class="user-info-text text-center">
                                            <h3>
                                                <a href="<?php echo base_url('contact-request') ?>" target="_self">Find More Contacts
                                                </a>
                                            </h3>                                
                                        </div>
                                        <div class="author-btn">
                                            <div class="user-btns">
                                                <a class="btn3" href="<?php echo base_url('contact-request') ?>" target="_self">View More</a>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </data-owl-carousel>
                        </div>
                    </div>
                </div>
            </div>
            <div ng-if="(postIndex + 1) / 30 === 1 && contact_suggetion_3">
                <div class="all-contact-cus">
                    <div class="all-contact">
                        <h4><a href="<?php echo base_url('contact-request') ?>" target="_self">All Contacts</a></h4> 
                        <div class="all-user-list">
                            <data-owl-carousel class="owl-carousel owl-carousel1" data-options="{{owlOptionsTestimonials}}">                                
                                <div owl-carousel-item="" ng-repeat="contact in contact_suggetion_3" class="item">
                                    <div class="item" id="item-{{contact.user_id}}">
                                        <div class="arti-profile-box">
                                            <div class="user-cover-img" ng-if="contact.profile_background != null && contact.profile_background != ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{contact.profile_background}}">
                                                </a>
                                            </div>
                                            <div class="user-cover-img" ng-if="contact.profile_background == null || contact.profile_background == ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"   target="_self">
                                                    <div class="gradient-bg" style="height: 100%"></div>
                                                </a>
                                            </div>
                                            <div class="user-pr-img" ng-if="contact.user_image != ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{contact.user_image}}">
                                                </a>
                                            </div>
                                            <div class="user-pr-img" ng-if="contact.user_image == ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <img ng-if="contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <img ng-if="contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                </a>
                                            </div>
                                            <div class="user-info-text text-center">
                                                <h3>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-bind="(contact.first_name | limitTo:1 | uppercase) + (contact.first_name.substr(1) | lowercase)+' '+ (contact.last_name | limitTo:1 | uppercase) + (contact.last_name.substr(1) | lowercase)" target="_self"></a>
                                                </h3>
                                                <p>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name != null && contact.degree_name == null" target="_self">{{contact.title_name| uppercase}}</a>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.degree_name != null && contact.title_name == null" target="_self">{{contact.degree_name| uppercase}}</a>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name == null && contact.degree_name == null" target="_self">CURRENT WORK</a>
                                                </p>
                                            </div>
                                            <div class="author-btn">
                                                <div class="user-btns">
                                                    <a class="btn3 addtobtn-{{contact.user_id}}" ng-click="addToContact(contact.user_id, contact)">Add to Contacts</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div owl-carousel-item="" class="item last-item-box">
                                    <div class="arti-profile-box">
                                        <div class="user-cover-img">
                                            <a href="<?php echo base_url('contact-request') ?>" target="_self">
                                                <div class="gradient-bg" style="height: 100%"></div>
                                            </a>
                                        </div>
                                        <div class="find-more user-pr-img">
                                            <img src="<?php echo base_url('assets/n-images/view-all.png') ?>">
                                        </div>                            
                                        <div class="user-info-text text-center">
                                            <h3>
                                                <a href="<?php echo base_url('contact-request') ?>" target="_self">Find More Contacts
                                                </a>
                                            </h3>                                
                                        </div>
                                        <div class="author-btn">
                                            <div class="user-btns">
                                                <a class="btn3" href="<?php echo base_url('contact-request') ?>" target="_self">View More</a>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </data-owl-carousel>
                        </div>
                    </div>
                </div>
            </div>
            <div ng-if="(postIndex + 1) / 40 === 1 && contact_suggetion_4">
                <div class="all-contact-cus">
                    <div class="all-contact">
                        <h4><a href="<?php echo base_url('contact-request') ?>" target="_self">All Contacts</a></h4> 
                        <div class="all-user-list">
                            <data-owl-carousel class="owl-carousel owl-carousel1" data-options="{{owlOptionsTestimonials}}">                                
                                <div owl-carousel-item="" ng-repeat="contact in contact_suggetion_4" class="item">
                                    <div class="item" id="item-{{contact.user_id}}">
                                        <div class="arti-profile-box">
                                            <div class="user-cover-img" ng-if="contact.profile_background != null && contact.profile_background != ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{contact.profile_background}}">
                                                </a>
                                            </div>
                                            <div class="user-cover-img" ng-if="contact.profile_background == null || contact.profile_background == ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <div class="gradient-bg" style="height: 100%"></div>
                                                </a>
                                            </div>
                                            <div class="user-pr-img" ng-if="contact.user_image != ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{contact.user_image}}">
                                                </a>
                                            </div>
                                            <div class="user-pr-img" ng-if="contact.user_image == ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <img ng-if="contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <img ng-if="contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                </a>
                                            </div>
                                            <div class="user-info-text text-center">
                                                <h3>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-bind="(contact.first_name | limitTo:1 | uppercase) + (contact.first_name.substr(1) | lowercase)+' '+ (contact.last_name | limitTo:1 | uppercase) + (contact.last_name.substr(1) | lowercase)" target="_self"></a>
                                                </h3>
                                                <p>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name != null && contact.degree_name == null" target="_self">{{contact.title_name| uppercase}}</a>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.degree_name != null && contact.title_name == null" target="_self">{{contact.degree_name| uppercase}}</a>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name == null && contact.degree_name == null" target="_self">CURRENT WORK</a>
                                                </p>
                                            </div>
                                            <div class="author-btn">
                                                <div class="user-btns">
                                                    <a class="btn3 addtobtn-{{contact.user_id}}" ng-click="addToContact(contact.user_id, contact)">Add to Contacts</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div owl-carousel-item="" class="item last-item-box">
                                    <div class="arti-profile-box">
                                        <div class="user-cover-img">
                                            <a href="<?php echo base_url('contact-request') ?>">
                                                <div class="gradient-bg" style="height: 100%"></div>
                                            </a>
                                        </div>
                                        <div class="find-more user-pr-img">
                                            <img src="<?php echo base_url('assets/n-images/view-all.png') ?>">
                                        </div>                            
                                        <div class="user-info-text text-center">
                                            <h3>
                                                <a href="<?php echo base_url('contact-request') ?>" target="_self">Find More Contacts
                                                </a>
                                            </h3>                                
                                        </div>
                                        <div class="author-btn">
                                            <div class="user-btns">
                                                <a class="btn3" href="<?php echo base_url('contact-request') ?>" target="_self">View More</a>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </data-owl-carousel>
                        </div>
                    </div>
                </div>
            </div>
            <div ng-if="(postIndex + 1) / 50 === 1 && contact_suggetion_5">
                <div class="all-contact-cus">
                    <div class="all-contact">
                        <h4><a href="<?php echo base_url('contact-request') ?>" target="_self">All Contacts</a></h4> 
                        <div class="all-user-list">
                            <data-owl-carousel class="owl-carousel owl-carousel1" data-options="{{owlOptionsTestimonials}}">                                
                                <div owl-carousel-item="" ng-repeat="contact in contact_suggetion_5" class="item">
                                    <div class="item" id="item-{{contact.user_id}}">
                                        <div class="arti-profile-box">
                                            <div class="user-cover-img" ng-if="contact.profile_background != null && contact.profile_background != ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{contact.profile_background}}">
                                                </a>
                                            </div>
                                            <div class="user-cover-img" ng-if="contact.profile_background == null || contact.profile_background == ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <div class="gradient-bg" style="height: 100%"></div>
                                                </a>
                                            </div>
                                            <div class="user-pr-img" ng-if="contact.user_image != ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{contact.user_image}}">
                                                </a>
                                            </div>
                                            <div class="user-pr-img" ng-if="contact.user_image == ''">
                                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}"  target="_self">
                                                    <img ng-if="contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                    <img ng-if="contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                </a>
                                            </div>
                                            <div class="user-info-text text-center">
                                                <h3>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-bind="(contact.first_name | limitTo:1 | uppercase) + (contact.first_name.substr(1) | lowercase)+' '+ (contact.last_name | limitTo:1 | uppercase) + (contact.last_name.substr(1) | lowercase)" target="_self"></a>
                                                </h3>
                                                <p>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name != null && contact.degree_name == null" target="_self">{{contact.title_name| uppercase}}</a>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.degree_name != null && contact.title_name == null" target="_self">{{contact.degree_name| uppercase}}</a>
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name == null && contact.degree_name == null" target="_self">CURRENT WORK</a>
                                                </p>
                                            </div>
                                            <div class="author-btn">
                                                <div class="user-btns">
                                                    <a class="btn3 addtobtn-{{contact.user_id}}" ng-click="addToContact(contact.user_id, contact)">Add to Contacts</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div owl-carousel-item="" class="item last-item-box">
                                    <div class="arti-profile-box">
                                        <div class="user-cover-img">
                                            <a href="<?php echo base_url('contact-request') ?>" target="_self">
                                                <div class="gradient-bg" style="height: 100%"></div>
                                            </a>
                                        </div>
                                        <div class="find-more user-pr-img">
                                            <img src="<?php echo base_url('assets/n-images/view-all.png') ?>">
                                        </div>                            
                                        <div class="user-info-text text-center">
                                            <h3>
                                                <a href="<?php echo base_url('contact-request') ?>" target="_self">Find More Contacts
                                                </a>
                                            </h3>                                
                                        </div>
                                        <div class="author-btn">
                                            <div class="user-btns">
                                                <a class="btn3" href="<?php echo base_url('contact-request') ?>" target="_self">View More</a>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </data-owl-carousel>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feed End -->
        
        <div class="fw" id="loader" style="text-align:center; display: block;"><img ng-src="<?php echo base_url('assets/images/loader.gif') . '' ?>" alt="Loader" /></div>
    </div>
    <!-- Repeated Class Complete -->
</div> 
<!-- middle part end  -->
<div style="display:none;" class="modal fade" id="report-spam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="report-box">
                <form name="report_spam_form" id="report_spam_form" ng-validate="report_spam_validate">
                    <h3>What’s Wrong with This Post?</h3>
                    <ul>
                        <li>
                            <label class="control control--radio">Not Intersed in This Post
                                <input name="report_spam" type="radio" class="report-cls" value="1">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--radio">Spam, or Promotional
                                <input name="report_spam" type="radio" class="report-cls" value="2">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--radio">Nudity or Sexually Explicit
                                <input name="report_spam" type="radio" class="report-cls" value="3">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--radio">Fake News & Fake Account
                                <input name="report_spam" type="radio" class="report-cls" value="4">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        
                        <li>
                            <label class="control control--radio">Scam, Phishing or Malware
                                <input name="report_spam" type="radio" class="report-cls" value="5">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--radio">Abusive, Violent or Hate Speech
                                <input name="report_spam" type="radio" class="report-cls" value="6">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li class="fw">
                            <label class="control control--radio">Other Reasons
                                <input name="report_spam" type="radio" class="report-cls" value="0">
                                <div class="control__indicator"></div>
                            </label>
                            <!--other-rsn <label data-target="#other-reason" data-toggle="modal" onclick="void(0)" class="">Other Reasons
                            </label> -->
                        </li>
                        <li class="fw report-other-res" id="report_other" style="display: none;">
                            <input name="other_report_spam" type="text" id="other_report_spam" style="opacity: 1;z-index: 1;">
                        </li>
                        <li class="report-err-li" id="err_report"></li>
                        <li>
                            <button id="save_report_spam" class="btn1" type="button" ng-click="save_report_spam();">Submit</button>
                            <div id="save_report_spam_loader" class="dtl-popup-loader" style="display: none;">
                                <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader">
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<div style="display:none;" class="modal fade" id="other-reason" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="report-box">
                
                <div class="other-reason-box">
                    <textarea placeholder="Enter your reason for reporting"></textarea>
                    <p class="text-center">
                        <button class="btn3">Back</button> <button class="btn1">Submit</button>
                    </p>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div style="display:none;" class="modal fade" id="post-share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="post-popup-box">
                <div class="share-post">
                    <div class="share-post-head">
                        <div class="post-head">
                            <div class="post-img">
                                <?php
                                if ($leftbox_data['user_image'] != '')
                                { ?>
                                    <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '' ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
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
                            <div class="post-detail">
                                <div class="fw">
                                    <a class="post-name" href="<?php echo $leftbox_data['user_slug']; ?>"  target="_self"><?php echo ucwords($leftbox_data['first_name'].' '.$leftbox_data['last_name']); ?></a>
                                </div>
                                <div class="fw">                            
                                    <span class="post-designation">
                                        <?php
                                        if($leftbox_data['title_name'])
                                            echo $leftbox_data['title_name'];
                                        else if($leftbox_data['degree_name'])
                                            echo $leftbox_data['degree_name'];
                                        else
                                            echo "CURRENT WORK"; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="post-text">
                            <textarea id="share_post_text" class="hashtag-textarea" placeholder="Write someting." autocomplete="off" maxlength="500"></textarea>
                        </div>
                    </div>
                    <div id="main-post-{{share_post_data.post_data.id}}" ng-if="share_post_data" class="all-post-box">
                        <div class="all-post-top">
                            <div class="post-head" ng-if="share_post_data.post_data.post_for != 'share'">
                                <div class="post-img" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.post_data.post_for != 'share' && share_post_data.post_data.post_for == 'question'">
                                    <a ng-href="<?php echo base_url() ?>{{share_post_data.user_data.user_slug}}" class="post-name" target="_self" ng-if="share_post_data.question_data.is_anonymously == '0'">
                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{share_post_data.user_data.user_image}}" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.user_data.user_image != '' && share_post_data.question_data.is_anonymously == '0'">
                                        <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.user_data.user_image == '' && share_post_data.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.user_data.user_image == '' && share_post_data.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    </a>
                                                    
                                    <span class="no-img-post"  ng-if="share_post_data.user_data.user_image == '' || share_post_data.question_data.is_anonymously == '1'">A</span>
                                </div>

                                <div class="post-img" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.post_data.post_for != 'share' && share_post_data.post_data.post_for != 'question' && share_post_data.user_data.user_image != ''">
                                    <a ng-href="<?php echo base_url() ?>{{share_post_data.user_data.user_slug}}" class="post-name" target="_self">
                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{share_post_data.user_data.user_image}}">
                                    </a>
                                </div>

                                <div class="post-img no-profile-pic" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.post_data.post_for != 'share' && share_post_data.post_data.post_for != 'question' && share_post_data.user_data.user_image == ''">
                                    <a ng-href="<?php echo base_url() ?>{{share_post_data.user_data.user_slug}}" class="post-name" target="_self">
                                        <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    </a>
                                </div>

                                <div class="post-img" ng-if="share_post_data.post_data.user_type == '2' && share_post_data.post_data.post_for != 'share' && share_post_data.post_data.post_for == 'question'">
                                    <a ng-href="<?php echo base_url() ?>company/{{share_post_data.user_data.business_slug}}" class="post-name" target="_self" ng-if="share_post_data.question_data.is_anonymously == '0'">
                                        <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{share_post_data.user_data.business_user_image}}" ng-if="share_post_data.user_data.business_user_image && share_post_data.question_data.is_anonymously == '0'">
                                        <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="!share_post_data.user_data.business_user_image" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                    </a>
                                                    
                                    <span class="no-img-post"  ng-if="!share_post_data.user_data.business_user_image || share_post_data.question_data.is_anonymously == '1'">A</span>
                                </div>
                                                
                                <div class="post-img" ng-if="share_post_data.post_data.user_type == '2' && share_post_data.post_data.post_for != 'share' && share_post_data.post_data.post_for != 'question' && share_post_data.user_data.business_user_image">
                                    <a ng-href="<?php echo base_url() ?>company/{{share_post_data.user_data.business_slug}}" class="post-name" target="_self">
                                        <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>{{share_post_data.user_data.business_user_image}}">
                                    </a>
                                </div>
                                                
                                <div class="post-img no-profile-pic" ng-if="share_post_data.post_data.user_type == '2' && share_post_data.post_data.post_for != 'share' && share_post_data.post_data.post_for != 'question' && !share_post_data.user_data.business_user_image">
                                    <a ng-href="<?php echo base_url() ?>company/{{share_post_data.user_data.business_slug}}" class="post-name" target="_self">
                                        <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                    </a>
                                </div>

                                <div class="post-detail" ng-if="share_post_data.post_data.post_for != 'share'">
                                    <div class="fw" ng-if="share_post_data.post_data.post_for == 'question'">
                                        <a href="javascript:void(0)" class="post-name" ng-if="share_post_data.question_data.is_anonymously == '1'">Anonymous</a>
                                        <span class="post-time" ng-if="share_post_data.question_data.is_anonymously == '1'"></span>
                                        <a ng-href="<?php echo base_url() ?>{{share_post_data.user_data.user_slug}}" class="post-name" ng-bind="share_post_data.user_data.fullname" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.question_data.is_anonymously == '0'" target="_self"></a>
                                        <a ng-href="<?php echo base_url() ?>company/{{share_post_data.user_data.business_slug}}" class="post-name" ng-bind="share_post_data.user_data.company_name" ng-if="share_post_data.post_data.user_type == '2' && share_post_data.question_data.is_anonymously == '0'" target="_self"></a><span class="post-time">{{share_post_data.post_data.time_string}}</span>
                                    </div>
                                                    
                                    <div class="fw" ng-if="share_post_data.post_data.post_for != 'question'">
                                        <a ng-if="share_post_data.post_data.user_type == '1'" ng-href="<?php echo base_url() ?>{{share_post_data.user_data.user_slug}}" class="post-name" ng-bind="share_post_data.user_data.fullname" target="_self"></a>
                                        <a ng-if="share_post_data.post_data.user_type == '2'" ng-href="<?php echo base_url() ?>company/{{share_post_data.user_data.business_slug}}" class="post-name" ng-bind="share_post_data.user_data.company_name" target="_self"></a><span class="post-time">{{share_post_data.post_data.time_string}}</span>
                                    </div>

                                    <div class="fw" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.post_data.post_for == 'question'">
                                        <span class="post-designation" ng-if="share_post_data.user_data.title_name != null && share_post_data.question_data.is_anonymously == '0'" ng-bind="share_post_data.user_data.title_name"></span>
                                        <span class="post-designation" ng-if="share_post_data.user_data.title_name == null && share_post_data.question_data.is_anonymously == '0'" ng-bind="share_post_data.user_data.degree_name"></span>
                                        <span class="post-designation" ng-if="share_post_data.user_data.title_name == null && share_post_data.user_data.degree_name == null && share_post_data.question_data.is_anonymously == '0'">CURRENT WORK</span>
                                    </div>
                                    <div class="fw" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.post_data.post_for != 'question'">
                                        <span class="post-designation" ng-if="share_post_data.user_data.title_name != null" ng-bind="share_post_data.user_data.title_name"></span>
                                        <span class="post-designation" ng-if="share_post_data.user_data.title_name == null" ng-bind="share_post_data.user_data.degree_name"></span>
                                        <span class="post-designation" ng-if="share_post_data.user_data.title_name == null && share_post_data.user_data.degree_name == null">CURRENT WORK</span>
                                    </div>

                                    <div class="fw" ng-if="share_post_data.post_data.user_type == '2' && share_post_data.post_data.post_for == 'question'">
                                        <span class="post-designation" ng-if="share_post_data.user_data.industry_name != null && share_post_data.question_data.is_anonymously == '0'" ng-bind="share_post_data.user_data.industry_name"></span> 
                                        <span class="post-designation" ng-if="!share_post_data.user_data.industry_name && share_post_data.question_data.is_anonymously == '0'">CURRENT WORK</span>
                                    </div>
                                    <div class="fw" ng-if="share_post_data.post_data.user_type == '2' && share_post_data.post_data.post_for != 'question'">
                                        <span class="post-designation" ng-if="share_post_data.user_data.industry_name" ng-bind="share_post_data.user_data.industry_name"></span> 
                                        <span class="post-designation" ng-if="!share_post_data.user_data.industry_name">CURRENT WORK</span>
                                    </div>

                                </div>            
                            </div>
                            <div class="post-discription" ng-if="share_post_data.post_data.post_for == 'opportunity'">
                               
                                <div id="post-opp-detail-{{share_post_data.post_data.id}}">
                                    <div class="post-title opp-title-cus">
                                        <p ng-if="share_post_data.opportunity_data.opptitle"><b>Title of Opportunity:</b><h1 ng-bind="share_post_data.opportunity_data.opptitle" id="opp-title-{{share_post_data.post_data.id}}"></h1></p>
                                    </div>
                                    <h5 class="post-title">
                                        <p ng-if="share_post_data.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="share_post_data.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{share_post_data.post_data.id}}"></span></p>
                                        <p ng-if="share_post_data.opportunity_data.location"><b>Location:</b><span ng-bind="share_post_data.opportunity_data.location" id="opp-post-location-{{share_post_data.post_data.id}}"></span></p>
                                        <p ng-if="share_post_data.opportunity_data.field"><b>Field:</b><span ng-bind="share_post_data.opportunity_data.field" id="opp-post-field-{{share_post_data.post_data.id}}"></span></p>
                                        <p ng-if="!share_post_data.opportunity_data.field || share_post_data.opportunity_data.field == 0"><b>Field:</b><span ng-bind="share_post_data.opportunity_data.other_field" id="opp-post-field-{{share_post_data.post_data.id}}"></span></p>
                                        <p ng-if="share_post_data.opportunity_data.hashtag" class="hashtag-grd"><b>Hashtags:</b>
                                            <span>
                                                <span class="post-hash-tag" id="opp-post-hashtag-{{share_post_data.post_data.id}}" ng-repeat="hashtag in share_post_data.opportunity_data.hashtag.split(' ')">{{hashtag}}</span>
                                            </span>
                                        </p>                                            
                                        <p ng-if="share_post_data.opportunity_data.company_name"><b>Company Name:</b><span ng-bind="share_post_data.opportunity_data.company_name" id="opp-post-company-{{share_post_data.post_data.id}}"></span></p>
                                    </h5>
                                    <div class="post-des-detail" ng-if="share_post_data.opportunity_data.opportunity">
                                        <div id="opp-post-opportunity-{{share_post_data.post_data.id}}" ng-class="share_post_data.opportunity_data.opportunity.length > 250 ? 'view-more-expand' : ''">
                                            <b>Opportunity:</b>
                                            <span ng-bind-html="share_post_data.opportunity_data.opportunity"></span>
                                            <a id="remove-view-more{{share_post_data.post_data.id}}" ng-if="share_post_data.opportunity_data.opportunity.length > 250" ng-click="removeViewMore('opp-post-opportunity-'+share_post_data.post_data.id,'remove-view-more'+share_post_data.post_data.id);" class="read-more-post">.... Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-discription" ng-if="share_post_data.post_data.post_for == 'simple'">
                                <p ng-if="share_post_data.simple_data.sim_title"><b>Title:</b> <span ng-bind="share_post_data.simple_data.sim_title" id="opp-title-{{share_post_data.post_data.id}}"></span></p>
                                <p ng-if="share_post_data.simple_data.hashtag" class="hashtag-grd">
                                    <b>Hashtags:</b>
                                    <span>
                                        <span class="post-hash-tag" id="sim-post-hashtag-{{share_post_data.post_data.id}}" ng-repeat="hashtag in share_post_data.simple_data.hashtag.split(' ')">{{hashtag}}</span>
                                    </span>
                                </p>
                                <div ng-init="limit = 250; moreShown = false">
                                    <span ng-if="share_post_data.simple_data.description != ''" id="simple-post-description-{{share_post_data.post_data.id}}" ng-bind-html="share_post_data.simple_data.description" ng-class="share_post_data.simple_data.description.length > 250 ? 'view-more-expand' : ''">
                                    </span>
                                    <a id="remove-view-more{{share_post_data.post_data.id}}" ng-if="share_post_data.simple_data.description.length > 250" ng-click="removeViewMore('simple-post-description-'+share_post_data.post_data.id,'remove-view-more'+share_post_data.post_data.id);" class="read-more-post">.... Read More</a>                                        
                                </div>                                    
                            </div>
                            <div class="post-discription" ng-if="share_post_data.post_data.post_for == 'article'">
                                <p ng-if="share_post_data.article_data.hashtag" class="hashtag-grd">
                                    <span>
                                        <span class="post-hash-tag" id="opp-post-hashtag-{{share_post_data.post_data.id}}" ng-repeat="hashtag in share_post_data.article_data.hashtag.split(' ')">{{hashtag}}</span>
                                    </span>
                                </p>
                            </div>
                            <div class="post-images article-post-cus" ng-if="share_post_data.post_data.post_for == 'article'">
                                <div class="one-img" ng-class="share_post_data.article_data.article_featured_image == '' ? 'article-default-featured' : ''">
                                    <a href="<?php echo base_url(); ?>article/{{share_post_data.article_data.article_slug}}" target="_self">
                                        <img ng-src="<?php echo base_url().$this->config->item('article_featured_upload_path'); ?>{{share_post_data.article_data.article_featured_image}}" alt="{{share_post_data.article_data.article_title}}" ng-if="share_post_data.article_data.article_featured_image != ''">

                                        <img ng-src="<?php echo base_url('assets/img/art-default.jpg'); ?>{{share_post_data.article_data.article_featured_image}}" alt="{{share_post_data.article_data.article_title}}" ng-if="share_post_data.article_data.article_featured_image == ''">
                                        <div class="article-post-text">
                                            <h3>{{share_post_data.article_data.article_title}}</h3>
                                            <p>{{share_post_data.post_data.user_type == '1' ? share_post_data.user_data.fullname : share_post_data.user_data.company_name}}'s Article on Aileensoul</p>
                                        </div>
                                    </a>                            
                                </div>
                            </div>
                            <div class="post-discription" ng-if="share_post_data.post_data.post_for == 'share'">
                                <div id="share-post-detail-{{share_post_data.post_data.id}}" ng-if="share_post_data.share_data" class="all-post-box">
                                        <div class="all-post-top">
                                            <div class="post-head">
                                                <div class="post-img" ng-if="share_post_data.share_data.data.post_data.user_type == '1' && share_post_data.share_data.data.post_data.post_for == 'question'">
                                                    <a ng-href="<?php echo base_url() ?>{{share_post_data.share_data.data.user_data.user_slug}}" class="post-name" target="_self" ng-if="share_post_data.share_data.data.question_data.is_anonymously == '0'">
                                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{share_post_data.share_data.data.user_data.user_image}}" ng-if="share_post_data.share_data.data.post_data.user_type == '1' && share_post_data.share_data.data.user_data.user_image != '' && share_post_data.share_data.data.question_data.is_anonymously == '0'">
                                                        <img ng-class="share_post_data.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.share_data.data.post_data.user_type == '1' && share_post_data.share_data.data.user_data.user_image == '' && share_post_data.share_data.data.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                        <img ng-class="share_post_data.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.share_data.data.post_data.user_type == '1' && share_post_data.share_data.data.user_data.user_image == '' && share_post_data.share_data.data.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                    </a>
                                                                    
                                                    <span class="no-img-post"  ng-if="share_post_data.share_data.data.user_data.user_image == '' || share_post_data.share_data.data.question_data.is_anonymously == '1'">A</span>
                                                </div>

                                                <div class="post-img" ng-if="share_post_data.share_data.data.post_data.user_type == '1' && share_post_data.share_data.data.post_data.post_for != 'question' && share_post_data.share_data.data.user_data.user_image != ''">
                                                    <a ng-href="<?php echo base_url() ?>{{share_post_data.share_data.data.user_data.user_slug}}" class="post-name" target="_self">
                                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{share_post_data.share_data.data.user_data.user_image}}">
                                                    </a>
                                                </div>

                                                <div class="post-img no-profile-pic" ng-if="share_post_data.share_data.data.post_data.user_type == '1' && share_post_data.share_data.data.post_data.post_for != 'question' && share_post_data.share_data.data.user_data.user_image == ''">
                                                    <a ng-href="<?php echo base_url() ?>{{share_post_data.share_data.data.user_data.user_slug}}" class="post-name" target="_self">
                                                        <img ng-class="share_post_data.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.share_data.data.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                        <img ng-class="share_post_data.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.share_data.data.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                    </a>
                                                </div>

                                                <div class="post-img" ng-if="share_post_data.share_data.data.post_data.user_type == '2' && share_post_data.share_data.data.post_data.post_for == 'question'">
                                                    <a ng-href="<?php echo base_url() ?>company/{{share_post_data.share_data.data.user_data.business_slug}}" class="post-name" target="_self" ng-if="share_post_data.share_data.data.question_data.is_anonymously == '0'">
                                                        <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{share_post_data.share_data.data.user_data.business_user_image}}" ng-if="share_post_data.share_data.data.user_data.business_user_image && share_post_data.share_data.data.question_data.is_anonymously == '0'">
                                                        <img ng-class="share_post_data.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="!share_post_data.share_data.data.user_data.business_user_image" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                                    </a>
                                                                    
                                                    <span class="no-img-post"  ng-if="!share_post_data.share_data.data.user_data.business_user_image || share_post_data.share_data.data.question_data.is_anonymously == '1'">A</span>
                                                </div>
                                                                
                                                <div class="post-img" ng-if="share_post_data.share_data.data.post_data.user_type == '2' && share_post_data.share_data.data.post_data.post_for != 'question' && share_post_data.share_data.data.user_data.business_user_image">
                                                    <a ng-href="<?php echo base_url() ?>company/{{share_post_data.share_data.data.user_data.business_slug}}" class="post-name" target="_self">
                                                        <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>{{share_post_data.share_data.data.user_data.business_user_image}}">
                                                    </a>
                                                </div>
                                                                
                                                <div class="post-img no-profile-pic" ng-if="share_post_data.share_data.data.post_data.user_type == '2' && share_post_data.share_data.data.post_data.post_for != 'question' && !share_post_data.share_data.data.user_data.business_user_image">
                                                    <a ng-href="<?php echo base_url() ?>company/{{share_post_data.share_data.data.user_data.business_slug}}" class="post-name" target="_self">
                                                        <img ng-class="share_post_data.share_data.data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                                    </a>
                                                </div>

                                                <div class="post-detail">
                                                    <div class="fw" ng-if="share_post_data.share_data.data.post_data.post_for == 'question'">
                                                        <a href="javascript:void(0)" class="post-name" ng-if="share_post_data.share_data.data.question_data.is_anonymously == '1'">Anonymous</a>
                                                        <span class="post-time" ng-if="share_post_data.share_data.data.question_data.is_anonymously == '1'"></span>
                                                        <a ng-href="<?php echo base_url() ?>{{share_post_data.share_data.data.user_data.user_slug}}" class="post-name" ng-bind="share_post_data.share_data.data.user_data.fullname" ng-if="share_post_data.share_data.data.post_data.user_type == '1' && share_post_data.share_data.data.question_data.is_anonymously == '0'" target="_self"></a>
                                                        <a ng-href="<?php echo base_url() ?>company/{{share_post_data.share_data.data.user_data.business_slug}}" class="post-name" ng-bind="share_post_data.share_data.data.user_data.company_name" ng-if="share_post_data.share_data.data.post_data.user_type == '2' && share_post_data.share_data.data.question_data.is_anonymously == '0'" target="_self"></a>
                                                        <!-- <span class="post-time">{{share_post_data.share_data.data.post_data.time_string}}</span> -->
                                                    </div>
                                                                    
                                                    <div class="fw" ng-if="share_post_data.share_data.data.post_data.post_for != 'question'">
                                                        <a ng-if="share_post_data.share_data.data.post_data.user_type == '1'" ng-href="<?php echo base_url() ?>{{share_post_data.share_data.data.user_data.user_slug}}" class="post-name" ng-bind="share_post_data.share_data.data.user_data.fullname" target="_self"></a>
                                                        <a ng-if="share_post_data.share_data.data.post_data.user_type == '2'" ng-href="<?php echo base_url() ?>company/{{share_post_data.share_data.data.user_data.business_slug}}" class="post-name" ng-bind="share_post_data.share_data.data.user_data.company_name" target="_self"></a>
                                                        <!-- <span class="post-time">{{share_post_data.share_data.data.post_data.time_string}}</span> -->
                                                    </div>

                                                    <div class="fw" ng-if="share_post_data.share_data.data.post_data.user_type == '1' && share_post_data.share_data.data.post_data.post_for == 'question'">
                                                        <span class="post-designation" ng-if="share_post_data.share_data.data.user_data.title_name != null && share_post_data.share_data.data.question_data.is_anonymously == '0'" ng-bind="share_post_data.share_data.data.user_data.title_name"></span>
                                                        <span class="post-designation" ng-if="share_post_data.share_data.data.user_data.title_name == null && share_post_data.share_data.data.question_data.is_anonymously == '0'" ng-bind="share_post_data.share_data.data.user_data.degree_name"></span>
                                                        <span class="post-designation" ng-if="share_post_data.share_data.data.user_data.title_name == null && share_post_data.share_data.data.user_data.degree_name == null && share_post_data.share_data.data.question_data.is_anonymously == '0'">CURRENT WORK</span>
                                                    </div>
                                                    <div class="fw" ng-if="share_post_data.share_data.data.post_data.user_type == '1' && share_post_data.share_data.data.post_data.post_for != 'question'">
                                                        <span class="post-designation" ng-if="share_post_data.share_data.data.user_data.title_name != null" ng-bind="share_post_data.share_data.data.user_data.title_name"></span>
                                                        <span class="post-designation" ng-if="share_post_data.share_data.data.user_data.title_name == null" ng-bind="share_post_data.share_data.data.user_data.degree_name"></span>
                                                        <span class="post-designation" ng-if="share_post_data.share_data.data.user_data.title_name == null && share_post_data.share_data.data.user_data.degree_name == null">CURRENT WORK</span>
                                                    </div>

                                                    <div class="fw" ng-if="share_post_data.share_data.data.post_data.user_type == '2' && share_post_data.share_data.data.post_data.post_for == 'question'">
                                                        <span class="post-designation" ng-if="share_post_data.share_data.data.user_data.industry_name != null && share_post_data.share_data.data.question_data.is_anonymously == '0'" ng-bind="share_post_data.share_data.data.user_data.industry_name"></span> 
                                                        <span class="post-designation" ng-if="!share_post_data.share_data.data.user_data.industry_name && share_post_data.share_data.data.question_data.is_anonymously == '0'">CURRENT WORK</span>
                                                    </div>
                                                    <div class="fw" ng-if="share_post_data.share_data.data.post_data.user_type == '2' && share_post_data.share_data.data.post_data.post_for != 'question'">
                                                        <span class="post-designation" ng-if="share_post_data.share_data.data.user_data.industry_name" ng-bind="share_post_data.share_data.data.user_data.industry_name"></span> 
                                                        <span class="post-designation" ng-if="!share_post_data.share_data.data.user_data.industry_name">CURRENT WORK</span>
                                                    </div>

                                                </div>            
                                            </div>
                                            <div class="post-discription" ng-if="share_post_data.share_data.data.post_data.post_for == 'opportunity'">
                                               
                                                <div id="post-opp-detail-{{share_post_data.share_data.data.post_data.id}}">
                                                    <div class="post-title opp-title-cus">
                                                        <p ng-if="share_post_data.share_data.data.opportunity_data.opptitle"><b>Title of Opportunity:</b><h1 ng-bind="share_post_data.share_data.data.opportunity_data.opptitle" id="opp-title-{{share_post_data.share_data.data.post_data.id}}"></h1></p>
                                                    </div>
                                                    <h5 class="post-title">
                                                        <p ng-if="share_post_data.share_data.data.opportunity_data.opportunity_for"><b>Opportunity for:</b><span ng-bind="share_post_data.share_data.data.opportunity_data.opportunity_for" id="opp-post-opportunity-for-{{share_post_data.share_data.data.post_data.id}}"></span></p>
                                                        <p ng-if="share_post_data.share_data.data.opportunity_data.location"><b>Location:</b><span ng-bind="share_post_data.share_data.data.opportunity_data.location" id="opp-post-location-{{share_post_data.share_data.data.post_data.id}}"></span></p>
                                                        <p ng-if="share_post_data.share_data.data.opportunity_data.field"><b>Field:</b><span ng-bind="share_post_data.share_data.data.opportunity_data.field" id="opp-post-field-{{share_post_data.share_data.data.post_data.id}}"></span></p>
                                                        <p ng-if="!share_post_data.share_data.data.opportunity_data.field || share_post_data.share_data.data.opportunity_data.field == 0"><b>Field:</b><span ng-bind="share_post_data.share_data.data.opportunity_data.other_field" id="opp-post-field-{{share_post_data.share_data.data.post_data.id}}"></span></p>
                                                        <p ng-if="share_post_data.share_data.data.opportunity_data.hashtag" class="hashtag-grd"><b>Hashtags:</b>
                                                            <span>
                                                                <span class="post-hash-tag" id="opp-post-hashtag-{{share_post_data.share_data.data.post_data.id}}" ng-repeat="hashtag in share_post_data.share_data.data.opportunity_data.hashtag.split(' ')">{{hashtag}}</span>
                                                            </span>
                                                        </p>                                            
                                                        <p ng-if="share_post_data.share_data.data.opportunity_data.company_name"><b>Company Name:</b><span ng-bind="share_post_data.share_data.data.opportunity_data.company_name" id="opp-post-company-{{share_post_data.share_data.data.post_data.id}}"></span></p>
                                                    </h5>
                                                    <div class="post-des-detail" ng-if="share_post_data.share_data.data.opportunity_data.opportunity">
                                                        <div id="opp-post-opportunity-{{share_post_data.share_data.data.post_data.id}}" ng-class="share_post_data.share_data.data.opportunity_data.opportunity.length > 250 ? 'view-more-expand' : ''">
                                                            <b>Opportunity:</b>
                                                            <span ng-bind-html="share_post_data.share_data.data.opportunity_data.opportunity"></span>
                                                            <a id="remove-view-more{{share_post_data.share_data.data.post_data.id}}" ng-if="share_post_data.share_data.data.opportunity_data.opportunity.length > 250" ng-click="removeViewMore('opp-post-opportunity-'+share_post_data.share_data.data.post_data.id,'remove-view-more'+share_post_data.share_data.data.post_data.id);" class="read-more-post">.... Read More</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="post-discription" ng-if="share_post_data.share_data.data.post_data.post_for == 'simple'">
                                                <p ng-if="share_post_data.share_data.data.simple_data.sim_title"><b>Title:</b> <span ng-bind="share_post_data.share_data.data.simple_data.sim_title" id="opp-title-{{share_post_data.share_data.data.post_data.id}}"></span></p>
                                                <p ng-if="share_post_data.share_data.data.simple_data.hashtag" class="hashtag-grd">
                                                    <b>Hashtags:</b>
                                                    <span>
                                                        <span class="post-hash-tag" id="sim-post-hashtag-{{share_post_data.share_data.data.post_data.id}}" ng-repeat="hashtag in share_post_data.share_data.data.simple_data.hashtag.split(' ')">{{hashtag}}</span>
                                                    </span>
                                                </p>
                                                <div ng-init="limit = 250; moreShown = false">
                                                    <span ng-if="share_post_data.share_data.data.simple_data.description != ''" id="simple-post-description-{{share_post_data.share_data.data.post_data.id}}" ng-bind-html="share_post_data.share_data.data.simple_data.description" ng-class="share_post_data.share_data.data.simple_data.description.length > 250 ? 'view-more-expand' : ''">
                                                    </span>
                                                    <a id="remove-view-more{{share_post_data.share_data.data.post_data.id}}" ng-if="share_post_data.share_data.data.simple_data.description.length > 250" ng-click="removeViewMore('simple-post-description-'+share_post_data.share_data.data.post_data.id,'remove-view-more'+share_post_data.share_data.data.post_data.id);" class="read-more-post">.... Read More</a>
                                                </div>
                                            </div>
                                            <div class="post-discription" ng-if="share_post_data.share_data.data.post_data.post_for == 'article'">
                                                <p ng-if="share_post_data.share_data.data.article_data.hashtag" class="hashtag-grd">
                                                    <span>
                                                        <span class="post-hash-tag" id="opp-post-hashtag-{{share_post_data.share_data.data.post_data.id}}" ng-repeat="hashtag in share_post_data.share_data.data.article_data.hashtag.split(' ')">{{hashtag}}</span>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="post-images article-post-cus" ng-if="share_post_data.share_data.data.post_data.post_for == 'article'">
                                                <div class="one-img" ng-class="share_post_data.share_data.data.article_data.article_featured_image == '' ? 'article-default-featured' : ''">
                                                    <a href="<?php echo base_url(); ?>article/{{share_post_data.share_data.data.article_data.article_slug}}" target="_self">
                                                        <img ng-src="<?php echo base_url().$this->config->item('article_featured_upload_path'); ?>{{share_post_data.share_data.data.article_data.article_featured_image}}" alt="{{share_post_data.share_data.data.article_data.article_title}}" ng-if="share_post_data.share_data.data.article_data.article_featured_image != ''">

                                                        <img ng-src="<?php echo base_url('assets/img/art-default.jpg'); ?>{{share_post_data.share_data.data.article_data.article_featured_image}}" alt="{{share_post_data.share_data.data.article_data.article_title}}" ng-if="share_post_data.share_data.data.article_data.article_featured_image == ''">
                                                        <div class="article-post-text">
                                                            <h3>{{share_post_data.share_data.data.article_data.article_title}}</h3>
                                                            <p>{{share_post_data.share_data.data.post_data.user_type == '1' ? share_post_data.share_data.data.user_data.fullname : share_post_data.share_data.data.user_data.company_name}}'s Article on Aileensoul</p>
                                                        </div>
                                                    </a>                            
                                                </div>
                                            </div>
                                            <div class="post-discription" ng-if="share_post_data.share_data.data.post_data.post_for == 'profile_update'">
                                                <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{share_post_data.share_data.data.profile_update.data_value}}" ng-click="openModal2('myModalCoverPicShare'+share_post_data.share_data.data.post_data.id);">
                                            </div>
                                            <div class="post-discription" ng-if="share_post_data.share_data.data.post_data.post_for == 'cover_update'">
                                                <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{share_post_data.share_data.data.cover_update.data_value}}" ng-if="share_post_data.share_data.data.cover_update.data_value != ''" ng-click="openModal2('myModalCoverPicShare'+share_post_data.share_data.data.post_data.id);">
                                            </div>
                                            <div ng-if="share_post_data.share_data.data.post_data.post_for == 'profile_update' || share_post_data.share_data.data.post_data.post_for == 'cover_update'" id="myModalCoverPicShare{{share_post_data.share_data.data.post_data.id}}" tabindex="-1" role="dialog"  class="modal modal2" style="display: none;">
                                                <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModalShare('myModalCoverPicShare'+share_post_data.share_data.data.post_data.id)">×</button>
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
                                                            <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                                        </div>
                                                        <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                                        <div class="mySlides mySlides2{{share_post_data.share_data.data.post_data.id}}">
                                                            <div class="numbertext"></div>
                                                            <div class="slider_img_p" ng-if="share_post_data.share_data.data.post_data.post_for == 'cover_update'">
                                                                <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{share_post_data.share_data.data.cover_update.data_value}}" alt="Cover Image" id="cover{{share_post_data.share_data.data.post_data.id}}">
                                                            </div>
                                                            <div class="slider_img_p" ng-if="share_post_data.share_data.data.post_data.post_for == 'profile_update'">
                                                                <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{share_post_data.share_data.data.profile_update.data_value}}" alt="Profile Image" id="cover{{share_post_data.share_data.data.post_data.id}}">
                                                            </div>
                                                        </div>                          
                                                    </div>
                                                    <div class="caption-container">
                                                        <p id="caption"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="post-discription" ng-if="share_post_data.share_data.data.post_data.post_for == 'question'">
                                                <div id="ask-que-{{share_post_data.share_data.data.post_data.id}}" class="post-des-detail">
                                                    <h5 class="post-title">
                                                        <div ng-if="share_post_data.share_data.data.question_data.question"><b>Question:</b><span ng-bind="share_post_data.share_data.data.question_data.question" id="ask-post-question-{{share_post_data.share_data.data.post_data.id}}"></span></div>                                        
                                                        <div class="post-des-detail" ng-if="share_post_data.share_data.data.question_data.description">
                                                            <div id="ask-que-desc-{{share_post_data.share_data.data.post_data.id}}" ng-class="share_post_data.share_data.data.question_data.description.length > 250 ? 'view-more-expand' : ''">
                                                                <b>Description:</b>
                                                                <span ng-bind-html="share_post_data.share_data.data.question_data.description"></span>
                                                                <a id="remove-view-more{{share_post_data.share_data.data.post_data.id}}" ng-if="share_post_data.share_data.data.question_data.description.length > 250" ng-click="removeViewMore('ask-que-desc-'+share_post_data.share_data.data.post_data.id,'remove-view-more'+share_post_data.share_data.data.post_data.id);" class="read-more-post">.... Read More</a>
                                                            </div>                                            
                                                        </div>
                                                        <p ng-if="share_post_data.share_data.data.question_data.link"><b>Link:</b><span ng-bind="share_post_data.share_data.data.question_data.link" id="ask-post-link-{{share_post_data.share_data.data.post_data.id}}"></span></p>
                                                        <p ng-if="share_post_data.share_data.data.question_data.category"><b>Category:</b><span ng-bind="share_post_data.share_data.data.question_data.category" id="ask-post-category-{{share_post_data.share_data.data.post_data.id}}"></span></p>
                                                        <p ng-if="share_post_data.share_data.data.question_data.hashtag"><b>Hashtag:</b><span ng-bind="share_post_data.share_data.data.question_data.hashtag" class="post-hash-tag" id="ask-post-hashtag-{{share_post_data.post_data.id}}"></span></p>
                                                        <p ng-if="share_post_data.share_data.data.question_data.field"><b>Field:</b><span ng-bind="share_post_data.share_data.data.question_data.field" id="ask-post-field-{{share_post_data.share_data.data.post_data.id}}"></span></p>
                                                    </h5>
                                                    <div class="post-des-detail" ng-if="share_post_data.share_data.data.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="share_post_data.share_data.data.opportunity_data.opportunity"></span></div>
                                                </div>                                    
                                            </div>
                                            <div class="post-images" ng-if="share_post_data.share_data.data.post_data.total_post_files == 1">
                                                <div class="one-img" ng-repeat="post_file in share_post_data.share_data.data.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                                    <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                                        <img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)">
                                                    </a>
                                                    <span ng-if="post_file.file_type == 'video'"> 
                                                        <video controls width = "100%" height = "350" preload="metadata" ng-attr-poster="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}jpg">
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
                                            <div class="post-images" ng-if="share_post_data.share_data.data.post_data.total_post_files == 2">
                                                <div class="two-img" ng-repeat="post_file in share_post_data.share_data.data.post_file_data">
                                                    <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)"></a>
                                                </div>
                                            </div>
                                            <div class="post-images" ng-if="share_post_data.share_data.data.post_data.total_post_files == 3">
                                                <span ng-repeat="post_file in share_post_data.share_data.data.post_file_data">
                                                    <div class="three-img-top" ng-if="$index == '0'">
                                                        <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)"></a>
                                                    </div>
                                                    <div class="two-img" ng-if="$index == '1'">
                                                        <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)"></a>
                                                    </div>
                                                    <div class="two-img" ng-if="$index == '2'">
                                                        <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)"></a>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="post-images four-img" ng-if="share_post_data.share_data.data.post_data.total_post_files >= 4">
                                                <div class="two-img" ng-repeat="post_file in share_post_data.share_data.data.post_file_data| limitTo:4">
                                                    <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)"></a>
                                                    <div class="view-more-img" ng-if="$index == 3 && share_post_data.share_data.data.post_data.total_post_files > 4">
                                                        <span><a href="javascript:void(0);" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)">View All ({{share_post_data.share_data.data.post_data.total_post_files - 4}})</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="myModalShareInner{{share_post_data.share_data.data.post_data.id}}" class="modal modal2" tabindex="-1" role="dialog" style="display: none;">
                                                <button type="button" class="modal-close" ng-click="closeModalShare('myModalShareInner'+share_post_data.share_data.data.post_data.id)">×</button>
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                                        </div>
                                                        <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                                        <div class="mySlides mySlides2{{share_post_data.share_data.data.post_data.id}}" ng-repeat="_photoData in share_post_data.share_data.data.post_file_data">
                                                            <div class="numbertext">{{$index + 1}} / {{share_post_data.share_data.data.post_data.total_post_files}}</div>
                                                            <div class="slider_img_p">
                                                                <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                                                            </div>
                                                        </div>                                
                                                    </div>
                                                    <div class="caption-container">
                                                        <p id="caption"></p>
                                                    </div>
                                                </div> 
                                                <a ng-if="share_post_data.share_data.data.post_file_data.length > 1" class="prev" style="left:0px;" ng-click="plusSlides2(-1,share_post_data.share_data.data.post_data.id)">&#10094;</a>
                                                <a ng-if="share_post_data.share_data.data.post_file_data.length > 1" class="next" ng-click="plusSlides2(1,share_post_data.share_data.data.post_data.id)">&#10095;</a>
                                            </div>                                    
                                        </div>
                                </div>
                            </div>

                            <div class="post-discription" ng-if="share_post_data.post_data.post_for == 'profile_update'">
                                <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{share_post_data.profile_update.data_value}}" ng-click="openModal2('myModalCoverPicShare'+share_post_data.post_data.id);">
                            </div>
                            <div class="post-discription" ng-if="share_post_data.post_data.post_for == 'cover_update'">
                                <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{share_post_data.cover_update.data_value}}" ng-if="share_post_data.cover_update.data_value != ''" ng-click="openModal2('myModalCoverPicShare'+share_post_data.post_data.id);">
                            </div>
                            <div ng-if="share_post_data.post_data.post_for == 'profile_update' || share_post_data.post_data.post_for == 'cover_update'" id="myModalCoverPicShare{{share_post_data.post_data.id}}" tabindex="-1" role="dialog"  class="modal modal2" style="display: none;">
                                <button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModalShare('myModalCoverPicShare'+share_post_data.post_data.id)">×</button>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
                                            <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                        </div>
                                        <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                        <div class="mySlides mySlides2{{share_post_data.post_data.id}}">
                                            <div class="numbertext"></div>
                                            <div class="slider_img_p" ng-if="share_post_data.post_data.post_for == 'cover_update'">
                                                <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{share_post_data.cover_update.data_value}}" alt="Cover Image" id="cover{{share_post_data.post_data.id}}">
                                            </div>
                                            <div class="slider_img_p" ng-if="share_post_data.post_data.post_for == 'profile_update'">
                                                <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{share_post_data.profile_update.data_value}}" alt="Profile Image" id="cover{{share_post_data.post_data.id}}">
                                            </div>
                                        </div>                                
                                    </div>
                                    <div class="caption-container">
                                        <p id="caption"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="post-discription" ng-if="share_post_data.post_data.post_for == 'question'">
                                <div id="ask-que-{{share_post_data.post_data.id}}" class="post-des-detail">
                                    <h5 class="post-title">
                                        <div ng-if="share_post_data.question_data.question"><b>Question:</b><span ng-bind="share_post_data.question_data.question" id="ask-post-question-{{share_post_data.post_data.id}}"></span></div>                                        
                                        <div class="post-des-detail" ng-if="share_post_data.question_data.description">
                                            <div id="ask-que-desc-{{share_post_data.post_data.id}}" ng-class="share_post_data.question_data.description.length > 250 ? 'view-more-expand' : ''">
                                                <b>Description:</b>
                                                <span ng-bind-html="share_post_data.question_data.description"></span>
                                                <a id="remove-view-more{{share_post_data.post_data.id}}" ng-if="share_post_data.question_data.description.length > 250" ng-click="removeViewMore('ask-que-desc-'+share_post_data.post_data.id,'remove-view-more'+share_post_data.post_data.id);" class="read-more-post">.... Read More</a>
                                            </div>                                            
                                        </div>
                                        <p ng-if="share_post_data.question_data.link"><b>Link:</b><span ng-bind="share_post_data.question_data.link" id="ask-post-link-{{share_post_data.post_data.id}}"></span></p>
                                        <p ng-if="share_post_data.question_data.category"><b>Category:</b><span ng-bind="share_post_data.question_data.category" id="ask-post-category-{{share_post_data.post_data.id}}"></span></p>
                                        <p ng-if="share_post_data.question_data.hashtag"><b>Hashtag:</b><span ng-bind="share_post_data.question_data.hashtag" class="post-hash-tag" id="ask-post-hashtag-{{post.post_data.id}}"></span></p>
                                        <p ng-if="share_post_data.question_data.field"><b>Field:</b><span ng-bind="share_post_data.question_data.field" id="ask-post-field-{{share_post_data.post_data.id}}"></span></p>
                                    </h5>
                                    <div class="post-des-detail" ng-if="share_post_data.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="share_post_data.opportunity_data.opportunity"></span></div>
                                </div>                                    
                            </div>
                            <div class="post-images" ng-if="share_post_data.post_data.total_post_files == 1">
                                <div class="one-img" ng-repeat="post_file in share_post_data.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                    <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                        <img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)">
                                    </a>
                                    <span ng-if="post_file.file_type == 'video'"> 
                                        <video controls width = "100%" height = "350" preload="metadata" ng-attr-poster="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}jpg">
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
                            <div class="post-images" ng-if="share_post_data.post_data.total_post_files == 2">
                                <div class="two-img" ng-repeat="post_file in share_post_data.post_file_data">
                                    <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)"></a>
                                </div>
                            </div>
                            <div class="post-images" ng-if="share_post_data.post_data.total_post_files == 3">
                                <span ng-repeat="post_file in share_post_data.post_file_data">
                                    <div class="three-img-top" ng-if="$index == '0'">
                                        <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)"></a>
                                    </div>
                                    <div class="two-img" ng-if="$index == '1'">
                                        <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)"></a>
                                    </div>
                                    <div class="two-img" ng-if="$index == '2'">
                                        <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)"></a>
                                    </div>
                                </span>
                            </div>
                            <div class="post-images four-img" ng-if="share_post_data.post_data.total_post_files >= 4">
                                <div class="two-img" ng-repeat="post_file in share_post_data.post_file_data| limitTo:4">
                                    <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)"></a>
                                    <div class="view-more-img" ng-if="$index == 3 && share_post_data.post_data.total_post_files > 4">
                                        <span><a href="javascript:void(0);" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)">View All ({{share_post_data.post_data.total_post_files - 4}})</a></span>
                                    </div>
                                </div>
                            </div>
                            <div id="myModalShare{{share_post_data.post_data.id}}" class="modal modal2" tabindex="-1" role="dialog" style="display: none;">
                                <button type="button" class="modal-close" ng-click="closeModalShare('myModalShare'+share_post_data.post_data.id)">×</button>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                                        </div>
                                        <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                        <div class="mySlides mySlides2{{share_post_data.post_data.id}}" ng-repeat="_photoData in share_post_data.post_file_data">
                                            <div class="numbertext">{{$index + 1}} / {{share_post_data.post_data.total_post_files}}</div>
                                            <div class="slider_img_p">
                                                <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                                            </div>
                                        </div>                                
                                    </div>
                                    <div class="caption-container">
                                        <p id="caption"></p>
                                    </div>
                                </div> 
                                <a ng-if="share_post_data.post_file_data.length > 1" class="prev" style="left:0px;" ng-click="plusSlides2(-1,share_post_data.post_data.id)">&#10094;</a>
                                <a ng-if="share_post_data.post_file_data.length > 1" class="next" ng-click="plusSlides2(1,share_post_data.post_data.id)">&#10095;</a>
                            </div>                                    
                        </div>
                    </div>
                    <div class="post-box-bottom" >
                        <p class="pull-right">
                            <button ng-click="share_post_fnc(post_index,share_is_promoted);" class="btn1">Post</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display:none;" class="modal fade" id="post-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="post-popup-box">
                <form  id="post_something" name="post_something" ng-submit="post_something_check(event)">
                    <div class="post-box">
                        <!--div class="post-img">
                            <?php
                            if ($leftbox_data['user_image'] != '')
                            { ?>
                                <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '' ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
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
                        </div-->
                        <div class="form-group">
                            <label>Post title</label>
                            <input type="text" class="form-control" placeholder="Etnter Title" id="sim_title" maxlength="100" ng-model="sim.sim_title">
                            <div id="simple-post-title" class="tooltip-custom" style="display: none;">Give a relevant title to your post that describes your post in a single sentence.</div>
                        </div>
                        
                        <div class="form-group">
                            <label>Add hashtag (Topic)</label>
                            <!-- <input id="sim_hashtag" type="text" class="form-control" ng-model="sim.sim_hashtag" placeholder="Ex:#php #Photography #CEO #JobSearch #Freelancer" maxlength="200" onkeyup="autocomplete_hashtag(this.id);" onkeypress="autocomplete_hashtag_keypress(event);"> -->
                            <textarea id="sim_hashtag" type="text" class="hashtag-textarea" ng-model="sim.sim_hashtag" placeholder="Ex:#php #Photography #CEO #JobSearch #Freelancer" maxlength="200" onkeyup="autocomplete_hashtag(this.id);" onkeypress="autocomplete_hashtag_keypress(event);" style="min-height: auto;"></textarea>

                            <!-- <div contenteditable="true" id="sim_hashtag" onkeyup="autocomplete_hashtag(this.id);" onkeypress="autocomplete_hashtag_keypress(event);"></div> -->
                            <div class="sim_hashtag all-hashtags-list"></div>
                            <div id="simple-post-hashtag" class="tooltip-custom" style="display: none;">Add topic regarding your post that describes your post.</div>
                        </div>
                        <div class="form-group">
                            <textarea name="description" ng-model="sim.description" id="description" class="title-text-area" placeholder="Share knowledge, opportunities, articles and questions"></textarea>
                        </div>
                        <div class="all-upload" ng-if="is_edit != 1">
                            <div class="form-group">
                                <div id="fileCountSim"></div>
                                <div id="selectedFiles" class="file-preview">
                                </div>
                                <input file-input="files" ng-file-model="sim.postfiles" type="file" id="fileInput1" name="postfiles[]" data-overwrite-initial="false" data-min-file-count="2"  multiple style="display: none;">
                            </div>
                            <label for="fileInput1" ng-click="postFiles()">
                                <i class="fa fa-camera upload_icon" onclick="javascript:$('#fileInput1').attr('accept','image/*');"><span class="upload_span_icon"> Photo </span></i>
                                <i class="fa fa-video-camera upload_icon" onclick="javascript:$('#fileInput1').attr('accept','video/*');"><span class="upload_span_icon"> Video</span>  </i> 
                                <i class="fa fa-music upload_icon" onclick="javascript:$('#fileInput1').attr('accept','audio/*');"> <span class="upload_span_icon">  Audio </span> </i>
                                <i class="fa fa-file-pdf-o upload_icon" onclick="javascript:$('#fileInput1').attr('accept','.pdf');"><span class="upload_span_icon"> PDF </span></i>
                            </label>
                        </div>
                        <div class="post-box-bottom" >
                            <ul ng-if="is_edit != 1">
                                <li>
                                    <a href="#"  class="post-opportunity-modal" data-target="#opportunity-popup" data-toggle="modal" data-dismiss="modal">
                                        <img src="<?php echo base_url('assets/n-images/post-op.png') ?>"><span><span class="none-479">Post</span> <span>Opportunity</span></span>
                                    </a>
                                </li>
                                <li class="pl15">
                                    <a href="<?php echo base_url('new-article'); ?>" target="_self">
                                        <img src="<?php echo base_url('assets/n-images/article.png') ?>"><span><span class="none-479">Post</span> <span>Article</span></span>
                                    </a>
                                </li>
                                <li class="pl15">
                                    <a href="#" class="post-ask-question-modal"  data-target="#ask-question" data-toggle="modal">
                                        <img src="<?php echo base_url('assets/n-images/ask-qustion.png') ?>"><span>Ask Question</span>
                                    </a>
                                </li>
                            </ul>
                            <input type="hidden" name="post_for" ng-model="sim.post_for" class="form-control" value="">
                            <input type="hidden" ng-if="is_edit == 1" id="edit_post_id" name="edit_post_id" ng-model="sim.edit_post_id" class="form-control" value="{{sim.edit_post_id}}">
                            <p class="pull-right">
                                <button type="submit" class="btn1" value="Submit">Post</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div style="display:none;" class="modal fade" id="opportunity-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="post-popup-box">
                <form id="post_opportunity" name="post_opportunity" ng-submit="post_opportunity_check(event)">
                    
                    <div class="post-field">
                        <div class="form-group title-op-op">
                            <label>Title of Opportunity</label>
                            <input id="opptitle"  type="text" class="form-control" ng-model="opp.opptitle" placeholder="Enter Title of Opportunity" autocomplete="off" maxlength="100">
                            <div id="opptitletooltip" class="tooltip-custom" style="display: none;">Enter the specific "title" of this opportunity. Ex: Hiring Software Developer, Contractors Needed for Bridge Construction, Fund Raising Opportunities for Entrepreneur etc.</div>
                        </div>
                        <div id="content" class="form-group">
                            <label>For whom this opportunity?</label>
                            
                            <tags-input id="job_title" ng-model="opp.job_title" display-property="name" placeholder="Ex: Singer, SEO, HR, Photographer, Designer…" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()">
                                <auto-complete source="loadJobTitle($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                            </tags-input>
                            <div id="jobtitletooltip" class="tooltip-custom" style="display: none;">Type the designation which best matches for given opportunity.</div>
                            <script type="text/ng-template" id="title-template">
                                <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                            </script>
                            <script type="text/ng-template" id="title-autocomplete-template">
                                <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                            </script>
                        </div>

                        <div class="form-group">
                            <label>For which location?</label>
                            
                            <tags-input id="location" ng-model="opp.location" display-property="city_name" placeholder="Ex: Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai...." replace-spaces-with-dashes="false" template="location-template" on-tag-added="onKeyup()">
                                <auto-complete source="loadLocation($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="location-autocomplete-template"></auto-complete>
                            </tags-input>
                            <div id="locationtooltip" class="tooltip-custom" style="display: none;">Enter a word or two then select the location for the opportunity.</div>
                            <script type="text/ng-template" id="location-template">
                                <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                            </script>
                            <script type="text/ng-template" id="location-autocomplete-template">
                                <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                            </script>
                        </div>
                        <div class="form-group">
                            <label class="">For which field?</label>
                            
                            <!--<input name="field" id="field" type="text" placeholder="What is your field?" autocomplete="off">-->
                            <span class="select-field-custom">
                                <select name="field" ng-model="opp.field" id="field" ng-change="other_field(this)" class="post-opportunity-field">
                                    <option value="" selected="selected">Select Related Fields</option>
                                    <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                    <option value="0">Other</option>
                                </select>
                            </span>
                            <div id="fieldtooltip" class="tooltip-custom" style="display: none;">Select the field from given options that best match with Opportunity.</div>
                        </div>
                        <div class="form-group" ng-if="opp.field == '0'">
                            <input type="text" class="form-control other-field" ng-model="opp.otherField" placeholder="Enter other field" ng-required="true" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Add hashtag (Topic)</label>  
                            <!-- <input id="opp_hashtag" type="text" class="form-control" ng-model="opp.opp_hashtag" placeholder="Ex:#php #Photography #CEO #JobSearch #Freelancer" maxlength="200" onkeyup="autocomplete_hashtag(this.id);" onkeypress="autocomplete_hashtag_keypress(event);"> -->
                            <textarea id="opp_hashtag" class="hashtag-textarea" ng-model="opp.opp_hashtag" placeholder="Ex:#php #Photography #CEO #JobSearch #Freelancer" maxlength="200" onkeyup="autocomplete_hashtag(this.id);" onkeypress="autocomplete_hashtag_keypress(event);"></textarea>
                            <!-- <div contenteditable="true" id="sim_hashtag"></div> -->
                            <div class="opp_hashtag all-hashtags-list"></div>
                            <div id="opp-post-hashtag" class="tooltip-custom" style="display: none;">Add topic regarding your post that describes your post.</div>
                        </div>
                        <div class="form-group">
                            <label>Company Name (Optional)</label>
                            <input id="company_name"  type="text" class="form-control" ng-model="opp.company_name" placeholder="Enter Company Name" autocomplete="off" maxlength="100">
                            <div id="op-post-company" class="tooltip-custom" style="display: none;">Enter the company name of opportunity</div>
                        </div>
                        
                        
                        <div class="post-text form-group pt20">
                            
                            <textarea name="description" ng-model="opp.description" id="description" class="title-text-area" placeholder="Post Opportunity"></textarea>
                        </div>
                        
                        <input type="hidden" name="post_for" ng-model="opp.post_for" class="form-control" value="">
                        <input type="hidden" ng-if="is_edit == 1" id="opp_edit_post_id" name="opp_edit_post_id" ng-model="opp.edit_post_id" class="form-control" value="{{opp.edit_post_id}}">
                        
                    
                    <div class="all-upload form-group" ng-if="is_edit != 1">
                            <div class="">
                                <div id="fileCountOpp"></div>
                                <div id="selectedFilesOpp" class="file-preview"></div>

                                <input file-input="files" ng-file-model="opp.postfiles" type="file" id="fileInput" name="postfiles[]" data-overwrite-initial="false" data-min-file-count="2"  multiple style="display: none;">
                            </div>
                            <label for="fileInput" ng-click="postFiles()">
                                <i class="fa fa-camera upload_icon" onclick="javascript:$('#fileInput').attr('accept','image/*');"><span class="upload_span_icon"> Photo </span></i>
                                <i class="fa fa-video-camera upload_icon" onclick="javascript:$('#fileInput').attr('accept','video/*');"><span class="upload_span_icon"> Video</span>  </i> 
                                <i class="fa fa-music upload_icon" onclick="javascript:$('#fileInput').attr('accept','audio/*');"> <span class="upload_span_icon">  Audio </span> </i>
                                <i class="fa fa-file-pdf-o upload_icon" onclick="javascript:$('#fileInput').attr('accept','.pdf');"><span class="upload_span_icon"> PDF </span></i>
                            </label>
                        </div>
                    </div>
                    <div class="text-right fw post-op-btn pb20 pr20">
                        <button type="submit" class="btn1"  value="Submit">Post</button>    
                    </div>
                    <?php // echo form_close(); ?>
                </form>
            </div>
        </div>
    </div>
</div>
<div style="display:none;" class="modal fade" id="ask-question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="post-popup-box">
                <form id="ask_question" name="ask_question" ng-submit="ask_question_check(event)">
                    <div class="post-box">
                        <div class="post-img">
                            <?php
                            if ($leftbox_data['user_image'] != '')
                            { ?>
                                <img class="login-user-pro-pic" ng-src="<?php echo USER_THUMB_UPLOAD_URL . $leftbox_data['user_image'] . '' ?>" alt="<?php echo $leftbox_data['first_name'] ?>">  
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
                        <div class="post-text">
                            
                            <textarea class="title-text-area" ng-keyup="questionList()" ng-model="ask.ask_que" id="ask_que" placeholder="Ask Your Question (What you want to ask today?)"></textarea>
                            <ul class="questionSuggetion custom-scroll">
                                <li ng-repeat="que in queSearchResult">
                                    <a ng-href="<?php echo base_url('questions/') ?>{{que.id}}/{{que.question| slugify}}" ng-bind="que.question" target="_self"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="all-upload" ng-if="is_edit != 1">
                            <div class="form-group">
                                <div id="fileCountQue"></div>
                                <div id="selectedFilesQue" class="file-preview"></div>
                                <input file-input="files" ng-file-model="ask.postfiles" type="file" id="fileInput2" name="postfiles[]" data-overwrite-initial="false" data-min-file-count="2"  multiple style="display: none;">
                            </div>
                            <label for="fileInput2" ng-click="postFiles()">
                                <i class="fa fa-camera upload_icon"><span class="upload_span_icon"> Add Screenshot </span></i>
                            </label>
                            <div class="add-link" ng-click="ShowHide()">
                                <i class="fa fa fa-link upload_icon"><span class="upload_span_icon"> Add Link</span>  </i> 
                            </div>
                            <div class="form-group"  ng-show = "IsVisible">
                                <input type="url" ng-model="ask.web_link" class="" placeholder="Add Your Web Link">
                            </div>
                        </div>
                    </div>
                    <div class="post-field">
                        <div class="form-group">
                            <label>Add Description</label>
                            
                            <textarea id="ask_desc" rows="1" max-rows="5" ng-model="ask.ask_description" placeholder="Add Description" cols="10" style="resize:none"></textarea>
                            <div id="ask_desctooltip" class="tooltip-custom" style="display: none;">Describe your problem in more details with some examples.</div>
                        </div>                                
                        <div class="form-group">
                            <label>Add hashtag (Topic)</label>
                            
                            <textarea id="ask_hashtag" class="hashtag-textarea" ng-model="ask.ask_hashtag" placeholder="Ex:#php #Photography #CEO #JobSearch #Freelancer" autocomplete="off" maxlength="200" onkeyup="autocomplete_hashtag(this.id);" onkeypress="autocomplete_hashtag_keypress(event);"></textarea>
                            <!-- <div contenteditable="true" id="sim_hashtag"></div> -->
                            <div class="ask_hashtag all-hashtags-list"></div>
                            <div id="ask-post-hashtag" class="tooltip-custom" style="display: none;">Add topic regarding your post that describes your post.</div>
                        </div>
                        <div class="form-group">
                            <label>From which field the Question asked?</label>
                            
                            <span class="select-field-custom">
                                <select ng-model="ask.ask_field" id="ask_field">
                                    <option value="" selected="selected">Select Related Field</option>
                                    <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                    <option value="0">Other</option>
                                </select>
                            </span>
                            <div id="ask_fieldtooltip" class="tooltip-custom" style="display: none;">Select the field from given options that best match with Question.</div>
                        </div>                                
                        <div class="form-group" ng-if="ask.ask_field == '0'">
                            <input type="text" class="form-control" ng-model="ask.otherField" placeholder="Enter other field" ng-required="true" autocomplete="off">
                        </div>
                        <input type="hidden" name="post_for" ng-model="ask.post_for" class="form-control" value="">
                        <input type="hidden" ng-if="is_edit == 1" id="ask_edit_post_id" name="ask_edit_post_id" ng-model="ask.edit_post_id" class="form-control" value="{{ask.edit_post_id}}">
                    </div>
                    <div class="text-right fw pt10 pb20 pr15">
                        <div class="add-anonymously">
                            <label class="control control--checkbox" title="Checked this">Add Anonymously<input type="checkbox" ng-model="ask.is_anonymously" value="1"><div class="control__indicator"></div></label>
                        </div>
                        <button type="submit" class="btn1"  value="Submit">Ask Your Question</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade message-box biderror post-error" id="posterrormodal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="posterror-modal-close modal-close" data-dismiss="modal">&times;
            </button>       
            <div class="modal-body">
                <span class="mes"></span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade message-box post-error" id="post" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes"></span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade message-box" id="delete_model" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes">
                    <div class="pop_content">Do you want to delete this comment?<div class="model_ok_cancel"><a class="okbtn btn1" ng-click="deleteComment(c_d_comment_id, c_d_post_id, c_d_parent_index, c_d_index, c_d_post, c_d_is_promoted)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade message-box" id="delete_recent_model" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes">
                    <div class="pop_content">Do you want to delete this comment?<div class="model_ok_cancel"><a class="okbtn btn1" ng-click="deleteRecentComment(c_d_comment_id, c_d_post_id, c_d_parent_index, c_d_index, c_d_post)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade message-box" id="delete_post_model" role="dialog" tabindex="-1">
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
<div class="modal fade message-box" id="delete_recent_post_model" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes">
                    <div class="pop_content">Do you want to delete this post?<div class="model_ok_cancel"><a class="okbtn btn1" ng-click="deletedRecentPost(p_rd_post_id, p_rd_index)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn btn1" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade message-box like-popup" id="likeusermodal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <h3 ng-if="count_likeUser > 0 && count_likeUser < 2">{{count_likeUser}} Like</h3>
            <h3 ng-if="count_likeUser > 1">{{count_likeUser}} Likes</h3>
            <div class="modal-body padding_less_right">
                <div class="">
                    <ul class="custom-scroll">
                        <li class="like-img" ng-repeat="userlist in get_like_user_list">
                            <a class="ripple" href="<?php echo base_url(); ?>{{userlist.user_slug}}" ng-if="userlist.user_image != ''" target="_self">
                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{userlist.user_image}}">
                            </a>
                            <a class="ripple" href="<?php echo base_url(); ?>{{userlist.user_slug}}" ng-if="userlist.user_image == '' || userlist.user_image == null" target="_self">
                                <img ng-if="userlist.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                <img ng-if="userlist.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                            </a>
                            <div class="like-detail">
                                <h4><a href="<?php echo base_url(); ?>{{userlist.user_slug}}" target="_self">{{(userlist.user_id == '<?php echo $user_id; ?>' ? 'You' : userlist.fullname)}}</a></h4>
                                <p ng-if="(userlist.title_name == null) && (userlist.degree_name != null)">{{userlist.degree_name}}</p>
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

<script>
    $(function() {

    var $window = $(window);
    var lastScrollTop = $window.scrollTop();
    var wasScrollingDown = true;

    var $sidebar = $("#left-fixed");
    if ($sidebar.length > 0) {

    var initialSidebarTop = $sidebar.position().top;

    $window.scroll(function(event) {

    var windowHeight = $window.height();
    var sidebarHeight = $sidebar.outerHeight();

    var scrollTop = $window.scrollTop();
    var scrollBottom = scrollTop + windowHeight;

    var sidebarTop = $sidebar.position().top;
    var sidebarBottom = sidebarTop + sidebarHeight;

    var heightDelta = Math.abs(windowHeight - sidebarHeight);
    var scrollDelta = lastScrollTop - scrollTop;

    var isScrollingDown = (scrollTop > lastScrollTop);
    var isWindowLarger = (windowHeight > sidebarHeight);

    if ((isWindowLarger && scrollTop > initialSidebarTop) || (!isWindowLarger && scrollTop > initialSidebarTop + heightDelta)) {
        $sidebar.addClass('fixed-cus');
    } else if (!isScrollingDown && scrollTop <= initialSidebarTop) {
        $sidebar.removeClass('fixed-cus');
    }

    var dragBottomDown = (sidebarBottom <= scrollBottom && isScrollingDown);
    var dragTopUp = (sidebarTop >= scrollTop && !isScrollingDown);

    if (dragBottomDown) {
        if (isWindowLarger) {
            $sidebar.css('top', 0);
        } else {
            $sidebar.css('top', -heightDelta );
        }
    } else if (dragTopUp) {
        $sidebar.css('top', 0);
    } else if ($sidebar.hasClass('fixed-cus')) {
        var currentTop = parseInt($sidebar.css('top'), 10);
        
        var minTop = -heightDelta;
        //var scrolledTop = currentTop + scrollDelta;
        
        //var isPageAtBottom = (scrollTop + windowHeight >= $(document).height());
        //var newTop = (isPageAtBottom) ? minTop : scrolledTop;
        
        // $sidebar.css('top', newTop);
    }

    lastScrollTop = scrollTop;
    wasScrollingDown = isScrollingDown;
    });
    }
    });
    autosize(document.getElementsByClassName('hashtag-textarea'));
</script>