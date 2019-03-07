<!DOCTYPE html>
<html lang="en" ng-app="searchApp" ng-controller="searchController">
    <head>
        <title>Search<?php echo TITLEPOSTFIX; ?></title>
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>"> 
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
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="search-page body-loader one-hd">
        <?php echo $header_profile ?>
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
            <div class="main-section">
                <div class="container mobp0">
					<div class="container-flex">
						<div class="left-section">
							<?php echo $n_leftbar; ?>
						</div>
                    <div class="middle-section-cus">
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
                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{searchProfile.user_image}}" alt="{{searchProfile.fullname}}" ng-if="searchProfile.user_image">                                    
                                        <img ng-if="!searchProfile.user_image && searchProfile.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                        <img ng-if="!searchProfile.user_image && searchProfile.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    </a>
                                </div>
                                <div class="profile-data">
                                    <p><a href="<?php echo base_url() ?>{{searchProfile.user_slug}}" ng-bind="searchProfile.fullname | capitalize"></a></p>
                                    <span ng-if="searchProfile.degree_name == null && searchProfile.title_name != null">{{searchProfile.title_name}}</span>
                                    <span ng-if="searchProfile.degree_name != null && searchProfile.title_name == null">{{searchProfile.degree_name}}</span>
                                    <span ng-if="searchProfile.degree_name == null && searchProfile.title_name == null">Current work</span>
                                    
                                </div>
                                <div class="profile-btns" id="{{searchProfile.user_id}}">
                                    <a ng-if="searchProfile.follow_status == 1" class="btn1 following" ng-click="unfollow_user(searchProfile.user_id)">Following</a>
                                    <a ng-if="searchProfile.follow_status == 0 || !searchProfile.follow_status" class="btn3 follow" ng-click="follow_user(searchProfile.user_id)">Follow</a>
                                </div>
                            </div>
                            <div class="load-more-btn" id="load_more_pro_div" style="display: none;">
                                <button class="" name="load_more_pro" id="load_more_pro" ng-click="load_more_profile();">Load more</button>
                            </div>
                        </div>
                        <div class="availabel-data-box" ng-if="postData.length != '0'">
                            <h3>Posts </h3>
							<div class="tab-add">
								<?php $this->load->view('infeed_add'); ?>
							</div>
                            <div class="post_loader" style="text-align:center;">
                                <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                            </div>
                            <div class="p10 mobp0">
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
                                                        <img ng-class="post.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                                    </a>
                                                </div>
                                                                
                                                <div class="post-detail">
                                                    <div class="fw" ng-if="post.post_data.post_for == 'question'">
                                                        <a href="javascript:void(0)" class="post-name" ng-if="post.question_data.is_anonymously == '1'">Anonymous</a>
                                                        <span class="post-time" ng-if="post.question_data.is_anonymously == '1'"></span>
                                                        <a ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname" ng-if="post.post_data.user_type == '1' && post.question_data.is_anonymously == '0'"></a>
                                                        <a ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" ng-bind="post.user_data.company_name" ng-if="post.post_data.user_type == '2' && post.question_data.is_anonymously == '0'"></a><span class="post-time">{{post.post_data.time_string}}</span>
                                                    </div>
                                                                    
                                                    <div class="fw" ng-if="post.post_data.post_for != 'question'">
                                                        <a ng-if="post.post_data.user_type == '1'" ng-href="<?php echo base_url() ?>{{post.user_data.user_slug}}" class="post-name" ng-bind="post.user_data.fullname"></a>
                                                        <a ng-if="post.post_data.user_type == '2'" ng-href="<?php echo base_url() ?>company/{{post.user_data.business_slug}}" class="post-name" ng-bind="post.user_data.company_name"></a><span class="post-time">{{post.post_data.time_string}}</span>
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

                                                        <li ng-if="live_slug == post.user_data.user_slug && post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update' && post.post_data.post_for != 'article'"><a href="#" ng-click="EditPostNew(post.post_data.id, post.post_data.post_for, $index)">Edit Post</a></li>
                                                        <li ng-if="live_slug == post.user_data.user_slug && post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update'"><a href="#" ng-click="deletePost(post.post_data.id, $index)">Delete Post</a></li>
                                                        <li>
                                                            <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for == 'article'" href="<?php echo base_url(); ?>article/{{post.article_data.article_slug}}" target="_blank">Show in new tab</a>
                                                            <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for == 'opportunity'" href="<?php echo base_url(); ?>o/{{post.opportunity_data.oppslug}}" target="_blank">Show in new tab</a>
                                                            <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files == '0'" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/post/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                                            <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files >= '1' && post.post_file_data[0].file_type == 'image'" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/photos/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                                            <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files >= '1' && post.post_file_data[0].file_type == 'video'" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/videos/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                                            <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files >= '1' && post.post_file_data[0].file_type == 'audio'" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/audios/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                                            <a ng-if="post.post_data.post_for != 'question' && post.post_data.post_for != 'article' && post.post_data.post_for != 'opportunity' && post.post_data.total_post_files >= '1' && post.post_file_data[0].file_type == 'pdf'" href="<?php echo base_url(); ?>{{post.user_data.user_slug}}/pdf/{{post.post_data.id}}" target="_blank">Show in new tab</a>
                                                            <a ng-if="post.post_data.post_for == 'question'" ng-href="<?php echo base_url('questions/');?>{{post.question_data.id}}/{{post.question_data.question| slugify}}" target="_blank">Show in new tab</a>
                                                        </li>
                                                        <li ng-if="live_slug != post.user_data.user_slug">
                                                            <a ng-click="open_report_spam(post.post_data.id)" href="javascript:void(0);">Report</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="post-discription" ng-if="post.post_data.post_for == 'opportunity'">
                                                <!-- Edit Post Opportunity Start -->
                                                <div id="edit-opp-post-{{post.post_data.id}}" style="display: none;">
                                                    <form id="post_opportunity_edit" name="post_opportunity_edit" ng-submit="post_opportunity_check(event,postIndex)">
                                                        <div class="post-box">                        
                                                            <div class="post-text">
                                                                <!-- <textarea name="description" id="description_edit_{{post.post_data.id}}" class="title-text-area" placeholder="Post Opportunity"></textarea> -->
                                                                <div contenteditable="true" data-directive ng-model="sim.description_edit" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Post Opportunity..." id="description_edit_{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="handlePaste($event)"></div>
                                                            </div>                        
                                                        </div>
                                                        <div class="post-field">
                                                            <div class="form-group">
                                                                <label>Title of Opportunity</label>
                                                                <input id="opptitleedit{{post.post_data.id}}"  type="text" class="form-control" ng-model="opp.opptitleedit" placeholder="Enter Title of Opportunity" ng-required="true" autocomplete="off">
                                                            </div>
                                                            <div id="content" class="form-group">
                                                                <label>For whom this opportunity?<a href="#" data-toggle="tooltip" data-placement="left" title="Type the designation which best matches for given opportunity." class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" tooltips tooltip-append-to-body="true" tooltip-close-button="true" tooltip-side="right" tooltip-hide-trigger="click" tooltip-template="" alt="tooltip"></a></label>
                                                                
                                                                <tags-input id="job_title" ng-model="opp.job_title_edit" display-property="name" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer...." replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()">
                                                                    <auto-complete source="loadJobTitle($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                                                </tags-input>
                                                                <script type="text/ng-template" id="title-template">
                                                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                                                </script>
                                                                <script type="text/ng-template" id="title-autocomplete-template">
                                                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                                                </script>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>For which location?<a href="#" data-toggle="tooltip" data-placement="left" title="Enter a word or two then select the location for the opportunity." class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></a></label>
                                                                <tags-input id="location" ng-model="opp.location_edit" display-property="city_name" placeholder="Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai...." replace-spaces-with-dashes="false" template="location-template" on-tag-added="onKeyup()">
                                                                    <auto-complete source="loadLocation($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="location-autocomplete-template"></auto-complete>
                                                                </tags-input>
                                                                <script type="text/ng-template" id="location-template">
                                                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                                                </script>
                                                                <script type="text/ng-template" id="location-autocomplete-template">
                                                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                                                </script>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="pb5">For which field?<a href="#" data-toggle="tooltip" data-placement="left" title="Select the field from given options that best match with Opportunity." class="pull-right"><img ng-src="<?php echo base_url('assets/n-images/tooltip.png') ?>" alt="tooltip"></a></label>
                                                                <!--<input name="field" id="field" type="text" placeholder="What is your field?" autocomplete="off">-->
                                                                <span class="select-field-custom">
                                                                    <select name="field" ng-model="opp.field_edit" id="field_edit{{post.post_data.id}}" ng-change="other_field(this)">
                                                                        <option value="" selected="selected">Select Related Fields</option>
                                                                        <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                                                        <option value="0">Other</option>
                                                                    </select>
                                                                </span>
                                                            </div>
                                                            <div class="form-group" ng-if="opp.field_edit == '0'">
                                                                <input id="otherField_edit{{post.post_data.id}}" name="otherField_edit{{post.post_data.id}}" type="text" class="form-control other-field" ng-model="opp.otherField_edit" placeholder="Enter other field" ng-required="true" autocomplete="off">
                                                            </div>
                                                            <input type="hidden" name="post_for" class="form-control" value="">
                                                            <input type="hidden" id="opp_edit_post_id{{postIndex}}" name="opp_edit_post_id" class="form-control" value="{{post.post_data.id}}">
                                                        </div>
                                                        <div class="text-right fw pb10">
                                                            <button type="submit" class="btn1" id="save_{{post.post_data.id}}" value="Submit">
                                                                <span class="ajax_load" id="login_ajax_load{{post.post_data.id}}" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span>
                                                            Save</button>                                    
                                                        </div>
                                                        <?php // echo form_close(); ?>
                                                    </form>
                                                </div>
                                                <!-- Edit Post Opportunity End -->
                                                <div id="post-opp-detail-{{post.post_data.id}}">
                                                    <h5 class="post-title">
                                                        <p ng-if="post.opportunity_data.opptitle"><b>Title of Opportunity:</b><span ng-bind="post.opportunity_data.opptitle" id="opp-title-{{post.post_data.id}}"></span></p>
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
                                            </div>
                                            <div class="post-discription" ng-if="post.post_data.post_for == 'simple'">
                                                <div ng-init="limit = 250; moreShown = false">
                                                    <span ng-if="post.simple_data.description != ''" id="simple-post-description-{{post.post_data.id}}" ng-bind-html="post.simple_data.description" ng-class="post.simple_data.description.length > 250 ? 'view-more-expand' : ''">
                                                    </span>
                                                    <a id="remove-view-more{{post.post_data.id}}" ng-if="post.simple_data.description.length > 250" ng-click="removeViewMore('simple-post-description-'+post.post_data.id,'remove-view-more'+post.post_data.id);" class="read-more-post">.... Read More</a>                            
                                                </div>

                                                <!-- Edit Simple Post Start -->
                                                <div id="edit-simple-post-{{post.post_data.id}}" style="display: none;">
                                                    <form  id="post_something_edit" name="post_something_edit" ng-submit="post_something_check(event,postIndex)" enctype="multipart/form-data">
                                                        <div class="post-box">        
                                                            <div class="post-text">
                                                                <div contenteditable="true" data-directive ng-model="sim.description_edit" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Share knowledge, opportunities, articles and questions" id="editPostTexBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="handlePaste($event)"></div>

                                                                <!-- <textarea name="description" ng-model="sim.description_edit" id="editPostTexBox-{{post.post_data.id}}" class="title-text-area hide" placeholder="Write something here..."></textarea> -->
                                                            </div>                        
                                                            <div class="post-box-bottom" >                            
                                                                <input type="hidden" name="post_for" class="form-control" value="simple">
                                                                <input type="hidden" id="edit_post_id{{postIndex}}" name="edit_post_id" class="form-control" value="{{post.post_data.id}}">
                                                                <p class="pull-right">
                                                                    <button type="submit" class="btn1" value="Submit">Save</button>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- Edit Simple Post End -->
                                            </div>
                                            <!-- <div class="post-discription" ng-if="post.post_data.post_for == 'article'">
                                                <div ng-init="limit = 100; moreShown = false" class="article-title" ng-if="post.article_data.article_featured_image == ''">
                                                    <span ng-if="post.article_data.article_title != ''" id="simple-post-description-{{post.post_data.id}}" ng-bind-html="post.article_data.article_title" ng-class="post.article_data.article_title.length > 100 ? 'view-more-expand' : ''">
                                                    </span>
                                                    <a id="remove-view-more{{post.post_data.id}}" ng-if="post.article_data.article_title.length > 100" href="<?php //echo base_url(); ?>article/{{post.article_data.article_slug}}">.... Read More</a>
                                                </div>
                                                <div ng-init="limit = 100; moreShown = false" class="article-description" ng-if="post.article_data.article_featured_image == ''">
                                                    <span ng-if="post.article_data.article_desc != ''" id="simple-post-description-{{post.post_data.id}}" ng-bind-html="post.article_data.article_desc" ng-class="post.article_data.article_desc.length > 100 ? 'view-more-expand' : ''">
                                                    </span>
                                                    <a id="remove-view-more{{post.post_data.id}}" ng-if="post.article_data.article_desc.length > 100" href="<?php //echo base_url(); ?>article/{{post.article_data.article_slug}}">.... Read More</a>
                                                </div>
                                            </div> -->
                                            <div class="post-discription" ng-if="post.post_data.post_for == 'article'"></div>
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
                                                        <p ng-if="post.question_data.field"><b>Field:</b><span ng-bind="post.question_data.field" id="ask-post-field-{{post.post_data.id}}"></span></p>
                                                    </h5>
                                                    <div class="post-des-detail" ng-if="post.opportunity_data.opportunity"><b>Opportunity:</b><span ng-bind="post.opportunity_data.opportunity"></span></div>
                                                </div>
                                                <!-- Edit Question Start -->
                                                <div id="edit-ask-que-{{post.post_data.id}}" style="display: none;">
                                                    <form id="ask_question" class="edit-question-form" name="ask_question" ng-submit="ask_question_check(event,$index)">
                                                        <div class="post-box">                        
                                                            <div class="post-text">                            
                                                                <textarea class="title-text-area" ng-model="ask.ask_que" ng-keyup="questionList()" id="ask_que_{{post.post_data.id}}" placeholder="Ask Your Question (What you want to ask today?)"></textarea>
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
                                                                <label>Add Description</label>
                                                                <textarea max-rows="5" id="ask_que_desc_{{post.post_data.id}}" placeholder="Add Description" cols="10"></textarea>
                                                                <div id="dobtooltip" class="tooltip-custom" style="">Describe your problem in more details with some examples.</div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Related Categories</label>
                                                                
                                                                
                                                                <tags-input ng-model="ask.related_category_edit" display-property="name" placeholder="Add a Related Category " replace-spaces-with-dashes="false" template="category-template" id="ask_related_category_edit{{post.post_data.id}}" on-tag-added="onKeyup()">
                                                                    <auto-complete source="loadCategory($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="category-autocomplete-template"></auto-complete>
                                                                </tags-input>
                                                                <div id="dobtooltip" class="tooltip-custom" style="">Enter a word or two then select a tag that matches with Question. Enter up to 5 tags. Ex: For the question “How to open a saving account?” tags will be “banking”.</div>
                                                                <script type="text/ng-template" id="category-template">
                                                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                                                </script>
                                                                <script type="text/ng-template" id="category-autocomplete-template">
                                                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                                                </script>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>From which field the Question asked?</label>
                                                                
                                                                <span class="select-field-custom">
                                                                    <select ng-model="ask.ask_field_edit" id="ask_field_{{post.post_data.id}}">
                                                                        <option value="" selected="selected">Select Related Field</option>
                                                                        <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                                                        <option value="0">Other</option>
                                                                    </select>
                                                                </span>
                                                                <div id="dobtooltip" class="tooltip-custom" style="">Select the field from given options that best match with Question.</div>
                                                            </div>

                                                            <div class="form-group"  ng-if="ask.ask_field_edit == '0'">
                                                                <input id="ask_other_{{post.post_data.id}}" type="text" class="form-control other-field" placeholder="Enter other field" ng-required="true" autocomplete="off" value="{{post.question_data.others_field}}">
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
                                                <!-- Edit Question End -->
                                            </div>
                                            <div class="post-images" ng-if="post.post_data.total_post_files == '1'">
                                                <div class="one-img" ng-repeat="post_file in post.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                                    <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                                        <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModal'+post.post_data.id);currentSlide2($index + 1,post.post_data.id)">
                                                    </a>
                                                    <span ng-if="post_file.file_type == 'video'"> 
                                                        <video controls width = "100%" height = "350" poster="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{ post_file.filename | removeLastCharacter }}png" preload="none">
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
                                                        <div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;"><img ng-src="<?php echo base_url('assets/images/loader.gif') . '' ?>" alt="Loader" />
                                                        </div>
                                                        <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
                                                        <div class="mySlides mySlides2{{post.post_data.id}}" ng-if="post.post_data.post_for != 'article'" ng-repeat="_photoData in post.post_file_data">
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
                                                <a ng-if="post.post_file_data.length > 1" class="prev" style="left:0px;" ng-click="plusSlides2(-1,post.post_data.id)">&#10094;</a>
                                                <a ng-if="post.post_file_data.length > 1" class="next" ng-click="plusSlides2(1,post.post_data.id)">&#10095;</a>
                                            </div>
                                            <div class="post-bottom">
                                                <div class="row">
                                                    <div class="col-md-9 col-sm-9 col-xs-9 mob-pr0">
                                                        <ul class="bottom-left">
                                                            <li class="user-likes">
                                                                <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id,$index)" ng-if="post.is_userlikePost == '1'" class="like"><i class="fa fa-thumbs-up"></i></a>
                                                                <a href="javascript:void(0)" id="post-like-{{post.post_data.id}}" ng-click="post_like(post.post_data.id,$index)" ng-if="post.is_userlikePost == '0'"><i class="fa fa-thumbs-up"></i></a>
                                                            </li>
                                                            <!--li><a href="javascript:void(0);" ng-click="viewAllComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length <= 1" id="comment-icon-{{post.post_data.id}}" class="last-comment"><i class="fa fa-comment-o"></i></a></li-->
                                                            <!-- <li><a href="javascript:void(0);" ng-click="viewLastComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length > 1" id="comment-icon-{{post.post_data.id}}" class="all-comment"><i class="fa fa-comment-o"></i></a></li> -->
                                                        </ul>
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
                                                        
                                                        
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-3 mob-pl0">
                                                        <ul class="pull-right bottom-right">
                                                            <!--li class="like-count" ng-click="like_user_list(post.post_data.id);"><span style="{{post.post_like_count > 0 ? '' : 'display: none';}}" id="post-like-count-{{post.post_data.id}}" ng-bind="post.post_like_count"></span><span>Like</span></li-->
                                                            <!-- <li class="comment-count"><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span><span>Comment</span></li> -->

                                                            <li class="comment-count"><a href="javascript:void(0);" ng-click="viewAllComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length <= 1" id="comment-icon-{{post.post_data.id}}" class="last-comment"><i class="fa fa-comment-o"></i><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span></a></li>
                                                            <li class="comment-count"><a href="javascript:void(0);" ng-click="viewLastComment(post.post_data.id, $index, post)" ng-if="post.post_comment_data.length > 1" id="comment-icon-{{post.post_data.id}}" class="all-comment"><i class="fa fa-comment-o"></i><span style="{{post.post_comment_count > 0 ? '' : 'display: none';}}" class="post-comment-count-{{post.post_data.id}}" ng-bind="post.post_comment_count"></span></a></li>

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
                                                            <p dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{comment.comment}}" dd-text-collapse-cond="true">{{comment.comment}}</p>
                                                        </div>

                                                        <div class="edit-comment" id="edit-comment-{{comment.comment_id}}" style="display:none;">
                                                            <div class="comment-input">
                                                                <!--<div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" onpaste="OnPaste_StripFormatting(event);"></div>-->
                                                                <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}}, post.post_data.id)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="cmt_handle_paste_edit($event)" ng-keydown="check_comment_char_count_edit(comment.comment_id,$event)"></div>
                                                            </div>
                                                            <div class="mob-comment">
                                                                <button ng-click="sendEditComment(comment.comment_id, post.post_data.id)"><img ng-src="<?php echo base_url('assets/n-images/send.png') ?>"></button>
                                                            </div>
                                                            
                                                            <div class="comment-submit hidden-mob">
                                                                <button class="btn2" ng-click="sendEditComment(comment.comment_id, post.post_data.id)">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="comment-action">
                                                        <ul class="pull-left">
                                                            <li ng-if="comment.is_userlikePostComment == '1'"><a href="javascript:void(0);" id="cmt-like-fnc-{{comment.comment_id}}" ng-click="likePostComment(comment.comment_id, post.post_data.id)" class="like"><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span> Like</a></li>

                                                            <li ng-if="comment.is_userlikePostComment == '0'"><a href="javascript:void(0);" id="cmt-like-fnc-{{comment.comment_id}}" ng-click="likePostComment(comment.comment_id, post.post_data.id)"><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span> Like</a></li> 
                                                            <li id="cancel-comment-li-{{comment.comment_id}}" style="display: none;"><a href="javascript:void(0);" ng-click="cancelPostComment(comment.comment_id, post.post_data.id, $parent.$index, $index)">Cancel</a></li> 
                                                            
                                                            <li><a href="javascript:void(0);" ng-bind="comment.comment_time_string"></a></li>
                                                        </ul>
                                                        <ul class="pull-right">
                                                            <li ng-if="comment.commented_user_id == user_id" id="edit-comment-li-{{comment.comment_id}}"><a href="javascript:void(0);" ng-click="editPostComment(comment.comment_id, post.post_data.id, postIndex, commentIndex)"><img src="<?php echo base_url('assets/n-images/edit.svg') ?>"></a></li>
                                                            <li ng-if="post.post_data.user_id == user_id || comment.commented_user_id == user_id"><a href="javascript:void(0);" ng-click="deletePostComment(comment.comment_id, post.post_data.id, postIndex, commentIndex, post)"><img src="<?php echo base_url('assets/n-images/delet.svg') ?>"></a></li>
                                                        </ul>
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
                                                        <div contenteditable="true" data-directive ng-model="comment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendComment({{post.post_data.id}},$index,post)" id="commentTaxBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" ng-paste="cmt_handle_paste($event)" ng-keydown="check_comment_char_count(post.post_data.id,$event)"></div>
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
                                    <div ng-if="(postIndex + 1) % <?php echo ADS_BREAK; ?> == 0">
                                        <div class="tab-add">
                                            <adsense ad-client="ca-pub-6060111582812113" ad-slot="6296725909" inline-style="display:block;" ad-format="fluid" data-ad-layout-key="-6r+eg+1e-3d+36" ad-class="infeed"></adsense>
                                            <?php //$this->load->view('infeed_add'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="load-more-btn" id="load_more_pst_div" style="display: none;">
                                    <button class="" name="load_more_pst" id="load_more_pst" ng-click="load_more_post();">Load more</button>
                                </div>
                            </div>
							<div class="tab-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                        </div>

                    </div>
					<div class="right-section">
                    <div id="right-fixed" class="fw">
                        <?php $this->load->view('right_add_box'); ?>
                        <div class="all-contact">
                            <h4><a href="<?php echo base_url('contact-request') ?>" target="_self">All Contacts</a></h4> 
                            <div class="all-user-list">
                                <data-owl-carousel class="owl-carousel" data-options="">
                                    <div owl-carousel-item="" ng-repeat="contact in contactSuggetion" class="item">
                                        <div class="item" id="item-{{contact.user_id}}">
                                            <div class="arti-profile-box">
                                                <div class="user-cover-img" ng-if="contact.profile_background != null && contact.profile_background != ''">
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" >
                                                        <img src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{contact.profile_background}}">
                                                    </a>
                                                </div>
                                                <div class="user-cover-img" ng-if="contact.profile_background == null || contact.profile_background == ''">
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" >
                                                        <div class="gradient-bg" style="height: 100%"></div>
                                                    </a>
                                                </div>
                                                <div class="user-pr-img" ng-if="contact.user_image != ''">
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" >
                                                        <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{contact.user_image}}">
                                                    </a>
                                                </div>
                                                <div class="user-pr-img" ng-if="contact.user_image == ''">
                                                    <a href="<?php echo base_url(); ?>{{contact.user_slug}}" >
                                                        <img ng-if="contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                        <img ng-if="contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                                    </a>
                                                </div>
                                                <div class="user-info-text text-center">
                                                    <h3>
                                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-bind="(contact.first_name | limitTo:1 | uppercase) + (contact.first_name.substr(1) | lowercase)+' '+ (contact.last_name | limitTo:1 | uppercase) + (contact.last_name.substr(1) | lowercase)"></a>
                                                    </h3>
                                                    <p>
                                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name != null && contact.degree_name == null">{{contact.title_name| uppercase}}</a>
                                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.degree_name != null && contact.title_name == null">{{contact.degree_name| uppercase}}</a>
                                                        <a href="<?php echo base_url(); ?>{{contact.user_slug}}" ng-if="contact.title_name == null && contact.degree_name == null">CURRENT WORK</a>
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
                                            <div class="find-more">
                                                <img src="<?php echo base_url('assets/n-images/view-all.png') ?>">
                                            </div>                            
                                            <div class="user-info-text text-center">
                                                <h3>
                                                    <a href="<?php echo base_url('contact-request') ?>">Find More Contacts
                                                    </a>
                                                </h3>                                
                                            </div>
                                            <div class="author-btn">
                                                <div class="user-btns">
                                                    <a class="btn3" href="<?php echo base_url('contact-request') ?>">View More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <a href="<?php //echo base_url('contact-request') ?>">
                                            <div class="item" id="last-item">
                                                <div class="post-img" ng-if="contact.user_image != ''">
                                                    <img ng-src="<?php //echo base_url('assets/n-images/view-all.png') ?>">
                                                </div>
                                                <div class="user-list-detail">
                                                    <p class="contact-name">Find More Contacts</p>
                                                </div>
                                                <button class="follow-btn">View More</button> 
                                            </div>
                                        </a> -->
                                    </div>
                                </data-owl-carousel>
                            </div>
                        </div>
                    </div>
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

        <!-- <script src="<?php //echo base_url('assets/js/jquery.min.js'); ?>"></script> -->
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
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js') ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_slug = '<?php echo $this->uri->segment(2); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var searchKeyword = '<?php echo $search_keyword; ?>';
            var live_slug = '<?php echo $this->session->userdata('aileenuser_slug'); ?>';
            var keyword = "<?php echo $search_keyword ?>";
            var app = angular.module("searchApp", ['ui.bootstrap', 'ngTagsInput', 'ngSanitize','angular-google-adsense', 'ngValidate']);
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
	</script>
	<script>
        $(function() {

        var $window = $(window);
        var lastScrollTop = $window.scrollTop();
        var wasScrollingDown = true;

        var $sidebar = $("#right-fixed");
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
            $sidebar.addClass('fixed-cus1');
        } else if (!isScrollingDown && scrollTop <= initialSidebarTop) {
            $sidebar.removeClass('fixed-cus1');
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
        } else if ($sidebar.hasClass('fixed-cus1')) {
            var currentTop = parseInt($sidebar.css('top'), 10);
            
            var minTop = -heightDelta;
            //var scrolledTop = currentTop + scrollDelta;
            
           // var isPageAtBottom = (scrollTop + windowHeight >= $(document).height());
           // var newTop = (isPageAtBottom) ? minTop : scrolledTop;
            
           // $sidebar.css('top', newTop);
        }

        lastScrollTop = scrollTop;
        wasScrollingDown = isScrollingDown;
        });
        }
        });
	</script>
    </body>
</html>