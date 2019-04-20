<!DOCTYPE html>
<html lang="en" ng-app="postDetailsApp" ng-controller="postDetailsController">
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo ($metadesc != '' ? $metadesc : ''); ?>" />
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
         <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/developer.css') ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense');
    $login_userid = $this->session->userdata('aileenuser'); ?>
</head>
    <body class="one-hd profile-db body-loader">
        <?php $this->load->view('page_loader'); ?>
        <div id="main_page_load" style="display: block;">
            <?php echo $header_profile ?>
            
			<div class="main-section op-main-page">
				<div class="container mobp0">
                <div class="container-flex">
					<div class="left-section">
						<?php echo $n_leftbar ?>
					</div>
                    <div class="middle-section question-detail">
                        <div id="main-post-{{post.post_data.id}}" ng-if="postData.length != 0" class="all-post-box" ng-repeat="post in postData" ng-init="postIndex=$index">
                                <!--<input type="hidden" name="post_index" class="post_index" ng-class="post_index" ng-model="post_index" ng-value="{{$index + 1}}">-->
                                <input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_data.page}}">
                                <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.page_data.total_record}}">
                                <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.page_data.perpage_record}}">
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
                                        <div class="post-right-dropdown dropdown" ng-if="post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update'">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img ng-src="<?php echo base_url('assets/n-images/right-down.png') ?>" alt="Right Down"></a>
                                            <ul class="dropdown-menu">
                                                <li ng-if="user_id == post.user_data.user_id && post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update'"><a href="#" ng-click="EditPostNew(post.post_data.id, post.post_data.post_for, $index)">Edit Post</a></li>
                                                <li ng-if="user_id == post.user_data.user_id && post.post_data.post_for != 'profile_update' && post.post_data.post_for != 'cover_update'"><a href="#" ng-click="deletePost(post.post_data.id, $index)">Delete Post</a></li>
                                                <li>
                                                    <a ng-if="post.is_user_saved_post == '0'" href="javascript:void(0);" class="save-post-{{post.post_data.id}}" ng-click="save_post(post.post_data.id, $index, post)">Save Post</a>
                                                    <a ng-if="post.is_user_saved_post == '1'" href="javascript:void(0);">Saved Post</a>
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
                                                    <div class="form-group">
                                                        <label>Add hashtag (Topic)</label>
                                                        <textarea id="opp_hashtag{{post.post_data.id}}" type="text" class="hashtag-textarea" ng-model="opp.opp_hashtag_edit" placeholder="Ex:#php #Photography #CEO #JobSearch #Freelancer" autocomplete="off" maxlength="200" onkeyup="autocomplete_hashtag(this.id);" onkeypress="autocomplete_hashtag_keypress(event);"></textarea>
                                                        <!-- <div contenteditable="true" id="sim_hashtag"></div> -->
                                                        <div class="opp_hashtag{{post.post_data.id}} all-hashtags-list"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Company Name</label>
                                                        <input id="company_name_edit"  type="text" class="form-control" ng-model="opp.company_name_edit" placeholder="Enter Company Name" autocomplete="off" maxlength="100">
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

                                        <!-- Edit Simple Post Start -->
                                        <div id="edit-simple-post-{{post.post_data.id}}" style="display: none;">
                                            <form  id="post_something_edit" name="post_something_edit" ng-submit="post_something_check(event,postIndex)" enctype="multipart/form-data">
                                                <div class="post-box">
                                                    <div class="form-group">
                                                        <label>Post title</label>
                                                        <input type="text" placeholder="Etnter Title" id="sim_title" maxlength="100" ng-model="sim.sim_title_edit">
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label>Add hashtag (Topic)</label>
                                                        <textarea id="sim_hashtag{{post.post_data.id}}" type="text" class="hashtag-textarea" ng-model="sim.sim_hashtag_edit" placeholder="Ex:#php #Photography #CEO #JobSearch #Freelancer" autocomplete="off" maxlength="200" onkeyup="autocomplete_hashtag(this.id);" onkeypress="autocomplete_hashtag_keypress(event);"></textarea>
                                                        <!-- <div contenteditable="true" id="sim_hashtag"></div> -->
                                                        <div class="sim_hashtag{{post.post_data.id}} all-hashtags-list"></div>
                                                    </div>
                                                    <div class="form-group">
                                                    <!-- <div class="post-text"> -->
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
                                        <!-- Edit Question Start -->
                                        <div id="edit-ask-que-{{post.post_data.id}}" style="display: none;">
                                            <form id="ask_question" class="edit-question-form" name="ask_question" ng-submit="ask_question_check(event,$index)">
                                                <div class="post-box">                        
                                                    <div class="post-text">                            
                                                        <textarea class="title-text-area" ng-model="ask.ask_que" ng-keyup="questionList()" id="ask_que_{{post.post_data.id}}" placeholder="Ask Question"></textarea>
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
                                                            <input type="text" id="ask_web_link_{{post.post_data.id}}" class="" placeholder="Add Your Web Link">
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
                                                            <select ng-model="ask.ask_field_edit" id="ask_field_{{post.post_data.id}}">
                                                                <option value="" selected="selected">What is your field</option>
                                                                <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                                                                <option value="0">Other</option>
                                                            </select>
                                                        </span>
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
                                    <div class="post-discription" ng-if="post.post_data.post_for == 'share'">
                                        <p id="share-post-desc-{{post.post_data.id}}" ng-if="post.share_data.description" class="ng-scope">
                                            <span ng-bind="post.share_data.description" id="share-desc-{{post.post_data.id}}"></span>
                                        </p>
                                        <div id="share-post-{{post.post_data.id}}" style="display: none;">
                                            <div class="post-box">
                                                <div class="post-text">
                                                    <textarea id="share_post_text_{{post.post_data.id}}" class="hashtag-textarea" placeholder="Say something about post." autocomplete="off" maxlength="500"></textarea>
                                                </div>
                                                <div class="post-box-bottom" >
                                                    <p class="pull-right">
                                                        <button id="share-btn-{{post.post_data.id}}" ng-click="edit_share_post_fnc(post.post_data.id,$index);" class="btn1">Save</button>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

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
                                                    <div class="post-images" ng-if="post.share_data.data.post_data.total_post_files == '1'">
                                                        <div class="one-img" ng-repeat="post_file in post.share_data.data.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                                            <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                                                <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)">
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
                                                    <div class="post-images" ng-if="post.share_data.data.post_data.total_post_files == '2'">
                                                        <div class="two-img" ng-repeat="post_file in post.share_data.data.post_file_data">
                                                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                                        </div>
                                                    </div>
                                                    <div class="post-images" ng-if="post.share_data.data.post_data.total_post_files == '3'">
                                                        <span ng-repeat="post_file in post.share_data.data.post_file_data">
                                                            <div class="three-img-top" ng-if="$index == '0'">
                                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE4_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                                            </div>
                                                            <div class="two-img" ng-if="$index == '1'">
                                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                                            </div>
                                                            <div class="two-img" ng-if="$index == '2'">
                                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="post-images four-img" ng-if="post.share_data.data.post_data.total_post_files >= '4'">
                                                        <div class="two-img" ng-repeat="post_file in post.share_data.data.post_file_data| limitTo:4">
                                                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE2_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+post.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShare'+post.share_data.data.post_data.id)"></a>
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

                                                    <li class="post-save">
                                                        <a id="share-post-{{post.post_data.id}}" ng-click="share_post(post.post_data.id, $index, post)" href="javascript:void(0);" title="Share Post"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                                                    </li>

                                                    <li class="post-save">
                                                        <a ng-if="post.is_user_saved_post == '0'" class="save-post-{{post.post_data.id}}" ng-click="save_post(post.post_data.id, $index, post)" href="javascript:void(0);" title="Save Post"><img src="<?php echo base_url('assets/n-images/save-post.png'); ?>"></a>

                                                        <a ng-if="post.is_user_saved_post == '1'" id="saved-post-{{post.post_data.id}}" href="javascript:void(0);" title="Saved Post"><img src="<?php echo base_url('assets/n-images/saved-post.png'); ?>"></a>
                                                    </li>

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
                                                    <p dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{comment.comment}}" dd-text-collapse-cond="true"></p>
                                                </div>

                                                <div class="edit-comment" id="edit-comment-{{comment.comment_id}}" style="display:none;">
                                                    <div class="comment-input">
                                                        <!--<div contenteditable data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}},$index,post)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" onpaste="OnPaste_StripFormatting(event);"></div>-->
                                                        <div contenteditable="true" data-directive ng-model="editComment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendEditComment({{comment.comment_id}}, post.post_data.id)" id="editCommentTaxBox-{{comment.comment_id}}" ng-focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true" ng-paste="cmt_handle_paste_edit($event)" ng-keydown="check_comment_char_count_edit(comment.comment_id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
                                                        <div class="editCommentTaxBox-{{comment.comment_id}} all-hashtags-list"></div>
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
                                                    <li><a href="javascript:void(0);" id="cmt-reply-fnc-{{comment.comment_id}}" ng-click="comment_reply(postIndex,commentIndex,0,0,comment)">Reply</a></li>

                                                    <li ng-if="comment.is_userlikePostComment == '1'"><a href="javascript:void(0);" id="cmt-like-fnc-{{comment.comment_id}}" ng-click="likePostComment(comment.comment_id, post.post_data.id)" class="like"><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span> Like</a></li>

                                                    <li ng-if="comment.is_userlikePostComment == '0'"><a href="javascript:void(0);" id="cmt-like-fnc-{{comment.comment_id}}" ng-click="likePostComment(comment.comment_id, post.post_data.id)"><span ng-bind="comment.postCommentLikeCount" id="post-comment-like-{{comment.comment_id}}"></span> Like</a></li>

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

                                                        <li ng-if="commentreply.is_userlikePostComment == '1'"><a href="javascript:void(0);" id="cmt-like-fnc-{{commentreply.comment_id}}" ng-click="likePostComment(commentreply.comment_id, post.post_data.id)" class="like"><span ng-bind="commentreply.postCommentLikeCount" id="post-comment-like-{{commentreply.comment_id}}"></span> Like</a></li>

                                                        <li ng-if="commentreply.is_userlikePostComment == '0'"><a href="javascript:void(0);" id="cmt-like-fnc-{{commentreply.comment_id}}" ng-click="likePostComment(commentreply.comment_id, post.post_data.id)"><span ng-bind="commentreply.postCommentLikeCount" id="post-comment-like-{{commentreply.comment_id}}"></span> Like</a></li>

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
                                                <div contenteditable="true" data-directive ng-model="comment" ng-class="{'form-control': false, 'has-error':isMsgBoxEmpty}" ng-change="isMsgBoxEmpty = false" class="editable_text" placeholder="Add a Comment ..." ng-enter="sendComment({{post.post_data.id}},$index,post)" id="commentTaxBox-{{post.post_data.id}}" ng-focus="setFocus" focus-me="setFocus" ng-paste="cmt_handle_paste($event)" ng-keydown="check_comment_char_count(post.post_data.id,$event)" onkeyup="autocomplete_mention(this.id);"></div>
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
							<div class="tab-add">
								<?php $this->load->view('banner_add'); ?>
							</div>
                    </div>
                    <div class="right-section">
						<div id="right-fixed" class="fw">
							<?php $this->load->view('right_add_box'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                        <h4><a href="<?php echo base_url(); ?>{{userlist.user_slug}}">{{ userlist.user_id == '<?php echo $login_userid; ?>' ? 'You' : userlist.fullname}}</a></h4>
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
                                            <a class="post-name" href="<?php echo $leftbox_data['user_slug']; ?>"><?php echo ucwords($leftbox_data['first_name'].' '.$leftbox_data['last_name']); ?></a>
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
                                    <textarea id="share_post_text" class="hashtag-textarea" placeholder="Say something about post." autocomplete="off" maxlength="500"></textarea>
                                </div>
                            </div>
                            <div id="main-post-{{share_post_data.post_data.id}}" ng-if="share_post_data" class="all-post-box">
                                <div class="all-post-top">
                                    <div class="post-head" ng-if="share_post_data.post_data.post_for != 'share'">
                                        <div class="post-img" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.post_data.post_for == 'question'">
                                            <a ng-href="<?php echo base_url() ?>{{share_post_data.user_data.user_slug}}" class="post-name" target="_self" ng-if="share_post_data.question_data.is_anonymously == '0'">
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{share_post_data.user_data.user_image}}" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.user_data.user_image != '' && share_post_data.question_data.is_anonymously == '0'">
                                                <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.user_data.user_image == '' && share_post_data.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.user_data.user_image == '' && share_post_data.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </a>
                                                            
                                            <span class="no-img-post"  ng-if="share_post_data.user_data.user_image == '' || share_post_data.question_data.is_anonymously == '1'">A</span>
                                        </div>

                                        <div class="post-img" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.post_data.post_for != 'question' && share_post_data.user_data.user_image != ''">
                                            <a ng-href="<?php echo base_url() ?>{{share_post_data.user_data.user_slug}}" class="post-name" target="_self">
                                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{share_post_data.user_data.user_image}}">
                                            </a>
                                        </div>

                                        <div class="post-img no-profile-pic" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.post_data.post_for != 'question' && share_post_data.user_data.user_image == ''">
                                            <a ng-href="<?php echo base_url() ?>{{share_post_data.user_data.user_slug}}" class="post-name" target="_self">
                                                <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.user_data.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                                <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="share_post_data.user_data.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                            </a>
                                        </div>

                                        <div class="post-img" ng-if="share_post_data.post_data.user_type == '2' && share_post_data.post_data.post_for == 'question'">
                                            <a ng-href="<?php echo base_url() ?>company/{{share_post_data.user_data.business_slug}}" class="post-name" target="_self" ng-if="share_post_data.question_data.is_anonymously == '0'">
                                                <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{share_post_data.user_data.business_user_image}}" ng-if="share_post_data.user_data.business_user_image && share_post_data.question_data.is_anonymously == '0'">
                                                <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="!share_post_data.user_data.business_user_image" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                            </a>
                                                            
                                            <span class="no-img-post"  ng-if="!share_post_data.user_data.business_user_image || share_post_data.question_data.is_anonymously == '1'">A</span>
                                        </div>
                                                        
                                        <div class="post-img" ng-if="share_post_data.post_data.user_type == '2' && share_post_data.post_data.post_for != 'question' && share_post_data.user_data.business_user_image">
                                            <a ng-href="<?php echo base_url() ?>company/{{share_post_data.user_data.business_slug}}" class="post-name" target="_self">
                                                <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL; ?>{{share_post_data.user_data.business_user_image}}">
                                            </a>
                                        </div>
                                                        
                                        <div class="post-img no-profile-pic" ng-if="share_post_data.post_data.user_type == '2' && share_post_data.post_data.post_for != 'question' && !share_post_data.user_data.business_user_image">
                                            <a ng-href="<?php echo base_url() ?>company/{{share_post_data.user_data.business_slug}}" class="post-name" target="_self">
                                                <img ng-class="share_post_data.post_data.user_id == user_id ? 'login-user-pro-pic' : ''" ng-src="<?php echo base_url(NOBUSIMAGE); ?>"> 
                                            </a>
                                        </div>

                                        <div class="post-detail">
                                            <div class="fw" ng-if="share_post_data.post_data.post_for == 'question'">
                                                <a href="javascript:void(0)" class="post-name" ng-if="share_post_data.question_data.is_anonymously == '1'">Anonymous</a>
                                                <span class="post-time" ng-if="share_post_data.question_data.is_anonymously == '1'"></span>
                                                <a ng-href="<?php echo base_url() ?>{{share_post_data.user_data.user_slug}}" class="post-name" ng-bind="share_post_data.user_data.fullname" ng-if="share_post_data.post_data.user_type == '1' && share_post_data.question_data.is_anonymously == '0'"></a>
                                                <a ng-href="<?php echo base_url() ?>company/{{share_post_data.user_data.business_slug}}" class="post-name" ng-bind="share_post_data.user_data.company_name" ng-if="share_post_data.post_data.user_type == '2' && share_post_data.question_data.is_anonymously == '0'"></a><span class="post-time">{{share_post_data.post_data.time_string}}</span>
                                            </div>
                                                            
                                            <div class="fw" ng-if="share_post_data.post_data.post_for != 'question'">
                                                <a ng-if="share_post_data.post_data.user_type == '1'" ng-href="<?php echo base_url() ?>{{share_post_data.user_data.user_slug}}" class="post-name" ng-bind="share_post_data.user_data.fullname"></a>
                                                <a ng-if="share_post_data.post_data.user_type == '2'" ng-href="<?php echo base_url() ?>company/{{share_post_data.user_data.business_slug}}" class="post-name" ng-bind="share_post_data.user_data.company_name"></a><span class="post-time">{{share_post_data.post_data.time_string}}</span>
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
                                                                <a ng-href="<?php echo base_url() ?>{{share_post_data.share_data.data.user_data.user_slug}}" class="post-name" ng-bind="share_post_data.share_data.data.user_data.fullname" ng-if="share_post_data.share_data.data.post_data.user_type == '1' && share_post_data.share_data.data.question_data.is_anonymously == '0'"></a>
                                                                <a ng-href="<?php echo base_url() ?>company/{{share_post_data.share_data.data.user_data.business_slug}}" class="post-name" ng-bind="share_post_data.share_data.data.user_data.company_name" ng-if="share_post_data.share_data.data.post_data.user_type == '2' && share_post_data.share_data.data.question_data.is_anonymously == '0'"></a>
                                                                <!-- <span class="post-time">{{share_post_data.share_data.data.post_data.time_string}}</span> -->
                                                            </div>
                                                                            
                                                            <div class="fw" ng-if="share_post_data.share_data.data.post_data.post_for != 'question'">
                                                                <a ng-if="share_post_data.share_data.data.post_data.user_type == '1'" ng-href="<?php echo base_url() ?>{{share_post_data.share_data.data.user_data.user_slug}}" class="post-name" ng-bind="share_post_data.share_data.data.user_data.fullname"></a>
                                                                <a ng-if="share_post_data.share_data.data.post_data.user_type == '2'" ng-href="<?php echo base_url() ?>company/{{share_post_data.share_data.data.user_data.business_slug}}" class="post-name" ng-bind="share_post_data.share_data.data.user_data.company_name"></a>
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
                                                        <img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{share_post_data.share_data.data.profile_update.data_value}}" ng-click="openModal2('myModalCoverPicInnerShare'+share_post_data.share_data.data.post_data.id);">
                                                    </div>
                                                    <div class="post-discription" ng-if="share_post_data.share_data.data.post_data.post_for == 'cover_update'">
                                                        <img ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{share_post_data.share_data.data.cover_update.data_value}}" ng-if="share_post_data.share_data.data.cover_update.data_value != ''" ng-click="openModal2('myModalCoverPicInnerShare'+share_post_data.share_data.data.post_data.id);">
                                                    </div>
                                                    <div ng-if="share_post_data.share_data.data.post_data.post_for == 'profile_update' || share_post_data.share_data.data.post_data.post_for == 'cover_update'" id="myModalCoverPicInnerShare{{share_post_data.share_data.data.post_data.id}}" tabindex="-1" role="dialog"  class="modal modal2" style="display: none;">
                                                        <button type="button" class="modal-close" ng-click="closeModalShare('myModalCoverPicInnerShare'+share_post_data.share_data.data.post_data.id)">×</button>
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
                                                    <div class="post-images" ng-if="share_post_data.share_data.data.post_data.total_post_files == '1'">
                                                        <div class="one-img" ng-repeat="post_file in share_post_data.share_data.data.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                                            <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                                                <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)">
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
                                                    <div class="post-images" ng-if="share_post_data.share_data.data.post_data.total_post_files == '2'">
                                                        <div class="two-img" ng-repeat="post_file in share_post_data.share_data.data.post_file_data">
                                                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)"></a>
                                                        </div>
                                                    </div>
                                                    <div class="post-images" ng-if="share_post_data.share_data.data.post_data.total_post_files == '3'">
                                                        <span ng-repeat="post_file in share_post_data.share_data.data.post_file_data">
                                                            <div class="three-img-top" ng-if="$index == '0'">
                                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE4_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)"></a>
                                                            </div>
                                                            <div class="two-img" ng-if="$index == '1'">
                                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)"></a>
                                                            </div>
                                                            <div class="two-img" ng-if="$index == '2'">
                                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)"></a>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="post-images four-img" ng-if="share_post_data.share_data.data.post_data.total_post_files >= '4'">
                                                        <div class="two-img" ng-repeat="post_file in share_post_data.share_data.data.post_file_data| limitTo:4">
                                                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE2_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShareInner'+share_post_data.share_data.data.post_data.id);currentSlide2($index + 1,'myModalShareInner'+share_post_data.share_data.data.post_data.id)"></a>
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
                                        <button type="button" class="modal-close" ng-click="closeModalShare('myModalCoverPicShare'+share_post_data.post_data.id)">×</button>
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
                                    <div class="post-images" ng-if="share_post_data.post_data.total_post_files == '1'">
                                        <div class="one-img" ng-repeat="post_file in share_post_data.post_file_data" ng-init="$last ? loadMediaElement() : false">
                                            <a href="javascript:void(0);" ng-if="post_file.file_type == 'image'">
                                                <img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{post_file.filename}}" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)">
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
                                    <div class="post-images" ng-if="share_post_data.post_data.total_post_files == '2'">
                                        <div class="two-img" ng-repeat="post_file in share_post_data.post_file_data">
                                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}"  ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)"></a>
                                        </div>
                                    </div>
                                    <div class="post-images" ng-if="share_post_data.post_data.total_post_files == '3'">
                                        <span ng-repeat="post_file in share_post_data.post_file_data">
                                            <div class="three-img-top" ng-if="$index == '0'">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE4_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)"></a>
                                            </div>
                                            <div class="two-img" ng-if="$index == '1'">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)"></a>
                                            </div>
                                            <div class="two-img" ng-if="$index == '2'">
                                                <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE1_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)"></a>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="post-images four-img" ng-if="share_post_data.post_data.total_post_files >= '4'">
                                        <div class="two-img" ng-repeat="post_file in share_post_data.post_file_data| limitTo:4">
                                            <a href="javascript:void(0);"><img ng-src="<?php echo USER_POST_RESIZE2_UPLOAD_URL ?>{{post_file.filename}}" ng-if="post_file.file_type == 'image'" alt="{{post_file.filename}}" ng-click="openModal2('myModalShare'+share_post_data.post_data.id);currentSlide2($index + 1,'myModalShare'+share_post_data.post_data.id)"></a>
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
                                    <button ng-click="share_post_fnc();" class="btn1">Post</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade message-box biderror post-error" id="posterrormodal" tabindex="-1" role="dialog">
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
    
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/demo.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script src="//anglibs.github.io/angular-location-update/angular-location-update.min.js"></script>

        <script>
        var base_url = '<?php echo base_url(); ?>';
        var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
        var post_id = '<?php echo $post_id ?>';
        var cmt_maxlength = '700';
        var app = angular.module("postDetailsApp", ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','ngLocationUpdate']);
        var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/post_details.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui-1.12.1.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/autosize.js') ?>"></script>
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
            
            function split( val ) {
                return val.split( / \s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }

            function autocomplete_hashtag_keypress(e)
            {
                var re = /^[a-zA-Z0-9#\s]+$/; // or /^\w+$/ as mentioned
                if (!re.test(e.key)) {
                    e.preventDefault();                        
                    return false;
                }
            }

            function autocomplete_hashtag(id)
            {
                $("#"+id).bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                        $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    appendTo: "."+id,
                    minLength: 2,
                    source: function( request, response ) {                         
                        var search_key = extractLast( request.term );
                        if(search_key[0] == "#")
                        {
                            search_key = search_key.substr(1);
                            $.getJSON(base_url +"general/get_hashtag", { term : search_key},response);
                        }
                        else
                        {
                            return false;
                        }
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        var terms = split( this.value );
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push( ui.item.value );
                        // add placeholder to get the comma-and-space at the end
                        terms.push( "" );
                        this.value = terms.join( " " );
                        return false;
                    },
                });                
            }

            function placeCaretAtEnd(el) {
                el.focus();
                if (typeof window.getSelection != "undefined"
                        && typeof document.createRange != "undefined") {
                    var range = document.createRange();
                    range.selectNodeContents(el);
                    range.collapse(false);
                    var sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(range);
                } else if (typeof document.body.createTextRange != "undefined") {
                    var textRange = document.body.createTextRange();
                    textRange.moveToElementText(el);
                    textRange.collapse(false);
                    textRange.select();
                }
            }

            function split_m( val ) {
                // return val.split( /,\s*/ );
                return val.split( /@/ );
            }
            function extractLast_m( term ) {
                return split_m( term ).pop();
            }

            var startTyping = "Start Typing";

            function autocomplete_mention(id)
            {
                $("#"+id).bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                        $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    appendTo: "."+id,
                    minLength: 0,
                    create: function (event,ui) {                            
                        $("#"+id).data('ui-autocomplete')._renderItem = function (ul, item) {
                            if(item.fullname != undefined)
                            {
                                var content = '<a href="javascript:void(0);" contenteditable="false">';
                                var img_content = "";

                                if(item.user_image)
                                {
                                    var img_url = "<?php echo USER_THUMB_UPLOAD_URL;?>"+item.user_image;
                                    img_content = '<img src="'+img_url+'" alt="'+item.first_name+'" onError="this.onerror=null;this.src='+(item.user_gender == "M" ? '\''+base_url+'assets/img/man-user.jpg\'' : '\''+base_url+'assets/img/female-user.jpg\'')+'">';
                                }
                                else
                                {
                                    if(item.user_gender == "M")
                                    {
                                        img_content = '<img src="'+base_url+'assets/img/man-user.jpg'+'">';
                                    }
                                    else if(item.user_gender == "F")
                                    {                                            
                                        img_content = '<img src="'+base_url+'assets/img/female-user.jpg'+'">';   
                                    }
                                }
                                content += '<div class="post-img">'+img_content+'</div>';
                                content += '<div class="dropdown-user-detail">';
                                content += '<b>'+item.fullname+'</b>';
                                content += '<div class="msg-discription">';
                                if(item.title_name)
                                {
                                    content += '<span class="time_ago">'+item.title_name+'</span>';
                                }
                                else if(item.degree_name)
                                {
                                    content += '<span class="time_ago">'+item.degree_name+'</span>';
                                }
                                else
                                {
                                    content += '<span class="time_ago">Current Work</span>';
                                }
                                content += '</div>';
                                content += '</div>';                                    
                                content += '</a>';

                                return $('<li>').append(content)
                                    .appendTo(ul);
                            }
                        };
                    },
                    source: function( request, response ) {                            
                        var term = request.term,
                            results = [];
                        if (term.indexOf("@") >= 0) {
                            term = extractLast_m(request.term);
                            if (term.length > 0) {
                                results = $.getJSON(base_url +"userprofile/get_user_list", { term : term},response);
                                response(results);
                            } else {
                                results = [startTyping];
                            }
                        }                            
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        if (ui.item.fullname !== startTyping) {
                            var value = $("#"+this.id).html();
                            var terms = split_m(value);
                            terms.pop();
                            var content = '<a contenteditable="false" href="'+base_url+ui.item.user_slug+'" mention="'+window.btoa(ui.item.user_slug)+'">'+ui.item.fullname+'</a>&nbsp;';
                            terms.push(content);
                            $("#"+this.id).html(terms.join("@").replace(/@/g, ""));
                            placeCaretAtEnd($("#"+this.id)[0]);
                        }
                        return false;
                    },
                });
            }
            autosize(document.getElementsByClassName('hashtag-textarea'));
        </script>
    </body>
</html>