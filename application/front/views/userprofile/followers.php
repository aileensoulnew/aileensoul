<div class="pt20 fw">
<div class="container mobp0 followers-page">
    <div class="custom-user-list">
		<div class="tab-add-991 ads">
            <?php
            $data['data'] = 'ads';
            $this->load->view('ads_box',$data); ?>
		</div>
        <div class="list-box-custom">
            <h3 class="mob-border-top-1">Followers</h3>
            <div class="list-cus fw mobp0">
                <!-- <input name="page_number" class="page_number"  ng-model="page_number" ng-value="pagecntctData.pagedata.page">
                <input name="total_record" class="total_record"  ng-model="total_record" ng-value="pagecntctData.pagedata.total_record">
                <input name="perpage_record" class="perpage_record"  ng-model="perpage_record" ng-value="pagecntctData.pagedata.perpage_record"> -->
                
                <div class="custom-user-box" ng-if="pagecntctData.pagedata.total_record != '0'" ng-repeat="follow in followersData">
                    <div id="people_tooltip_content_{{$index}}" class="tooltip_templates">
                        <div class="user-tooltip">
                            <div class="tooltip-cover-img">
                                <img ng-if="follow.profile_background != null && follow.profile_background != ''" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL; ?>{{follow.profile_background}}">                                        
                                <div ng-if="follow.profile_background == null || follow.profile_background == ''" class="gradient-bg" style="height: 100%"></div>
                            </div>
                            <div class="tooltip-user-detail">
                                <div class="tooltip-user-img">
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{follow.user_image}}" ng-if="follow.user_image != ''">

                                    <img ng-class="follow.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="follow.user_image == '' && follow.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">

                                    <img ng-class="follow.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="follow.user_image == '' && follow.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">

                                </div>

                                <h4 ng-bind="follow.fullname | capitalize"></h4>

                                <p ng-if="follow.title_name != null && follow.degree_name == null">{{follow.title_name.length < 30 ? follow.title_name : ((follow.title_name | limitTo:30)+'...') }}</p>
                                <p ng-if="follow.title_name == null && follow.degree_name != null">{{follow.degree_name.length < 30 ? follow.degree_name : ((follow.degree_name | limitTo:30)+'...') }}</p>
                                <p ng-if="follow.title_name == null && follow.degree_name == null">Current Work</p>
                                <p ng-if="follow.post_count != '' || follow.contact_count != '' || follow.follower_count != ''">
                                    <span ng-if="follow.post_count != ''"><b>{{follow.post_count}}</b> Posts</span>
                                    <span ng-if="follow.contact_count != ''"><b>{{follow.contact_count}}</b> Contacts</span>
                                    <span ng-if="follow.follower_count != ''"><b>{{follow.follower_count}}</b> Followers</span>
                                </p>

                                <ul class="" ng-if="follow.mutual_friend.length > 0">
                                    <li ng-if="user_id != follow.people" ng-repeat="_friend in follow.mutual_friend | limitTo:2">
                                        <div class="user-img">
                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{_friend.user_image}}" ng-if="_friend.user_image != ''">

                                            <img ng-if="_friend.user_image == '' && _friend.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">

                                            <img ng-if="_friend.user_image == '' && _friend.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        </div>
                                    </li>                            
                                    <li ng-if="user_id != follow.people" class="m-contacts">
                                        <span ng-if="follow.mutual_friend.length == 1">
                                            <b>{{follow.mutual_friend[0].fullname}}</b> is in mutual contact.
                                        </span>
                                        <span ng-if="follow.mutual_friend.length > 1">
                                            <b>{{follow.mutual_friend[0].fullname}}</b>{{follow.mutual_friend.length - 1 > 0 ? ' and ' : ''}}<b>{{follow.mutual_friend.length - 1}}</b> more mutual contacts.
                                        </span>
                                    </li>
                                </ul>
                                <div class="tooltip-btns" ng-if="user_id != follow.user_id">
                                    <ul>
                                        <li class="contact-btn-{{follow.user_id}}">
                                            <a class="btn-new-1" ng-if="follow.contact_value == 'new'" data-param="{{follow.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ follow.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{follow.user_id}}">Add to contact</a>
                                            
                                            <a class="btn-new-1" ng-if="follow.contact_value == 'confirm'" data-param="{{follow.contact_id}}{{ today | date : 'hhmmss'}},cancel,{{ follow.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},1" onclick="contact(this.id);" id="contact_btn_{{follow.user_id}}">In Contacts</a>
                                            
                                            <a class="btn-new-1" ng-if="follow.contact_value == 'pending'" data-param="{{follow.contact_id}}{{ today | date : 'hhmmss'}},cancel,{{ follow.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{follow.user_id}}">Request sent</a>
                                            
                                            <a class="btn-new-1" ng-if="follow.contact_value == 'cancel'" data-param="{{follow.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ follow.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{follow.user_id}}">Add to contact</a>
                                            
                                            <a class="btn-new-1" ng-if="follow.contact_value == 'reject'" data-param="{{follow.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ follow.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{follow.user_id}}">Add to contact</a>
                                        </li>
                                        <li class="follow-btn-user-{{follow.user_id}}">
                                            <a ng-if="follow.follow_status == 1" class="btn-new-1 following" data-uid="{{follow.user_id}}{{ today | date : 'hhmmss'}}" onclick="unfollow_user(this.id)" id="follow_btn_{{follow.user_id}}">Following</a>

                                            <a ng-if="follow.follow_status == 0 || !follow.follow_status" class="btn-new-1 follow" data-uid="{{follow.user_id}}{{ today| date : 'hhmmss'}}" onclick="follow_user(this.id)" id="follow_btn_{{follow.user_id}}">Follow</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo MESSAGE_URL; ?>user/{{follow.user_slug}}" class="btn-new-1" target="_blank">Message</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post-img" ng-if="follow.user_image != '' && follow.user_image != null">
                        <a href="<?php echo base_url();?>{{follow.user_slug}}" target="_self" data-toggle="popover" data-tooltip-content="#people_tooltip_content_{{$index}}">
                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{follow.user_image}}">
                        </a>
                    </div>

                    <div class="post-img" ng-if="follow.user_image == '' || follow.user_image == null">
                        <a href="<?php echo base_url();?>{{follow.user_slug}}" target="_self" data-toggle="popover" data-tooltip-content="#people_tooltip_content_{{$index}}">
                            <img ng-if="follow.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                            <img ng-if="follow.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                        </a>
                    </div>
                    <div class="custom-user-detail">
                        <h4>
                            <a href="<?php echo base_url();?>{{follow.user_slug}}" target="_self" ng-bind="(follow.first_name | limitTo:1 | uppercase) + (follow.first_name.substr(1) | lowercase) + ' ' + (follow.last_name | limitTo:1 | uppercase) + (follow.last_name.substr(1) | lowercase)" data-toggle="popover" data-tooltip-content="#people_tooltip_content_{{$index}}"></a>
                        </h4>
                        <p ng-if="follow.title_name && !follow.degree_name">{{follow.title_name}}</p>
                        <p ng-if="follow.degree_name && !follow.title_name">{{follow.degree_name}}</p>
                        <p ng-if="!follow.degree_name && !follow.title_name">Current work</p>

                    </div>
                    <div ng-if="follow.user_id != user_id" class="custom-user-btn follow-btn-user-{{follow.user_id}}" id="{{follow.user_id}}">
                        <!-- <a class="btn1 following"  ng-if="follow.follow_user_id != null" ng-click="unfollow_user(follow.user_id)">Following</a>
                        <a class="btn3 follow" ng-if="follow.follow_user_id == null"  ng-click="follow_user(follow.user_id)">Follow</a> -->

                        <a ng-if="follow.follow_status == 1" class="btn-new-1 following" data-uid="{{follow.user_id}}{{ today | date : 'hhmmss'}}" onclick="unfollow_user(this.id)" id="follow_btn_{{follow.user_id}}">Following</a>

                        <a ng-if="follow.follow_status == 0 || !follow.follow_status" class="btn-new-1 follow" data-uid="{{follow.user_id}}{{ today| date : 'hhmmss'}}" onclick="follow_user(this.id)" id="follow_btn_{{follow.user_id}}">Follow</a>
                    </div>

                </div>
                <div class="fw post_loader loadmore" style="text-align:center; display: none;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>
                <div class="custom-user-box no-data-available"  ng-if="pagecntctData.pagedata.total_record == '0'">
                    <div class='art-img-nn'>
                        <div class='art_no_post_img'>
                            <img src="<?php echo base_url('assets/img/no-follow.png'); ?>" alt="No Follower">
                        </div>
                        <div class='art_no_post_text'>No Follower Available. </div>

                    </div>
                </div>
            </div>
        </div>
		<div class="tab-add ads">
            <?php
            $data['data'] = 'ads';
            $this->load->view('ads_box',$data); ?>
		</div>
    </div>
    <div class="right-add">
        <?php $this->load->view('right_add_box'); ?>
    </div>
</div>
</div>


