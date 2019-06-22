<div class="pt20 fw">
<div class="container mobp0 contacts-page">
    <div class="custom-user-list">
		<div class="tab-add-991 ads">
            <?php
            $data['data'] = 'ads';
            $this->load->view('ads_box',$data); ?>
		</div>
        <div class="list-box-custom">
            <h3 class="mob-border-top-1">Contacts </h3>
            <div class="list-cus fw mobp0" id="nocontact">
              <!--   <input name="page_number" class="page_number"  ng-model="page_number" ng-value="pagecntctData.pagedata.page">
                <input name="total_record" class="total_record"  ng-model="total_record" ng-value="pagecntctData.pagedata.total_record">
                <input name="perpage_record" class="perpage_record"  ng-model="perpage_record" ng-value="pagecntctData.pagedata.perpage_record"> -->

                <div class="custom-user-box" ng-if="contats_data != '0'" ng-repeat="contacts in contactData">

                    <div id="people_tooltip_content_{{$index}}" class="tooltip_templates">
                        <div class="user-tooltip">
                            <div class="tooltip-cover-img">
                                <img ng-if="contacts.profile_background != null && contacts.profile_background != ''" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL; ?>{{contacts.profile_background}}">                                        
                                <div ng-if="contacts.profile_background == null || contacts.profile_background == ''" class="gradient-bg" style="height: 100%"></div>
                            </div>
                            <div class="tooltip-user-detail">
                                <div class="tooltip-user-img">
                                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contacts.user_image}}" ng-if="contacts.user_image != ''">

                                    <img ng-class="contacts.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="contacts.user_image == '' && contacts.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">

                                    <img ng-class="contacts.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="contacts.user_image == '' && contacts.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">

                                </div>

                                <h4 ng-bind="contacts.fullname | capitalize"></h4>

                                <p ng-if="contacts.title_name != null">{{contacts.title_name.length < 30 ? contacts.title_name : ((contacts.title_name | limitTo:30)+'...') }}</p>
                                <p ng-if="contacts.title_name == null">{{contacts.degree_name.length < 30 ? contacts.degree_name : ((contacts.degree_name | limitTo:30)+'...') }}</p>
                                <p ng-if="contacts.title_name == null && contacts.degree_name == null">Current Work</p>
                                <p ng-if="contacts.post_count != '' || contacts.contact_count != '' || contacts.follower_count != ''">
                                    <span ng-if="contacts.post_count != ''"><b>{{contacts.post_count}}</b> Posts</span>
                                    <span ng-if="contacts.contact_count != ''"><b>{{contacts.contact_count}}</b> Connections</span>
                                    <span ng-if="contacts.follower_count != ''"><b>{{contacts.follower_count}}</b> Followers</span>
                                </p>

                                <ul class="" ng-if="contacts.mutual_friend.length > 0">
                                    <li ng-if="user_id != contacts.people" ng-repeat="_friend in contacts.mutual_friend | limitTo:2">
                                        <div class="user-img">
                                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{_friend.user_image}}" ng-if="_friend.user_image != ''">

                                            <img ng-if="_friend.user_image == '' && _friend.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">

                                            <img ng-if="_friend.user_image == '' && _friend.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                        </div>
                                    </li>                            
                                    <li ng-if="user_id != contacts.people" class="m-contacts">
                                        <span ng-if="contacts.mutual_friend.length == 1">
                                            <b>{{contacts.mutual_friend[0].fullname}}</b> is in mutual contact.
                                        </span>
                                        <span ng-if="contacts.mutual_friend.length > 1">
                                            <b>{{contacts.mutual_friend[0].fullname}}</b>{{contacts.mutual_friend.length - 1 > 0 ? ' and ' : ''}}<b>{{contacts.mutual_friend.length - 1}}</b> more mutual contacts.
                                        </span>
                                    </li>
                                </ul>
                                <div class="tooltip-btns" ng-if="user_id != contacts.user_id">
                                    <ul>
                                        <li class="contact-btn-{{contacts.user_id}}">
                                            <a class="btn-new-1" ng-if="contacts.contact_detail.contact_value == 'new'" data-param="{{contacts.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ contacts.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{contacts.user_id}}">Add to contact</a>
                                            
                                            <a class="btn-new-1" ng-if="contacts.contact_detail.contact_value == 'confirm'" data-param="{{contacts.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},cancel,{{ contacts.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},1" onclick="contact(this.id);" id="contact_btn_{{contacts.user_id}}">In Contacts</a>
                                            
                                            <a class="btn-new-1" ng-if="contacts.contact_detail.contact_value == 'pending'" data-param="{{contacts.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},cancel,{{ contacts.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{contacts.user_id}}">Request sent</a>
                                            
                                            <a class="btn-new-1" ng-if="contacts.contact_detail.contact_value == 'cancel'" data-param="{{contacts.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ contacts.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{contacts.user_id}}">Add to contact</a>
                                            
                                            <a class="btn-new-1" ng-if="contacts.contact_detail.contact_value == 'reject'" data-param="{{contacts.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ contacts.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{contacts.user_id}}">Add to contact</a>
                                        </li>
                                        <li class="follow-btn-user-{{contacts.user_id}}">
                                            <a ng-if="contacts.follow_status == 1" class="btn-new-1 following" data-uid="{{contacts.user_id}}{{ today | date : 'hhmmss'}}" onclick="unfollow_user(this.id)" id="follow_btn_{{contacts.user_id}}">Following</a>

                                            <a ng-if="contacts.follow_status == 0 || !contacts.follow_status" class="btn-new-1 follow" data-uid="{{contacts.user_id}}{{ today| date : 'hhmmss'}}" onclick="follow_user(this.id)" id="follow_btn_{{contacts.user_id}}">Follow</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo MESSAGE_URL; ?>user/{{contacts.user_slug}}" class="btn-new-1" target="_blank">Message</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="post-img" ng-if="contacts.user_image != '' && contacts.user_image != null">
                        <a href="<?php echo base_url();?>{{contacts.user_slug}}" target="_self" data-toggle="popover" data-tooltip-content="#people_tooltip_content_{{$index}}">
                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contacts.user_image}}">
                        </a>
                    </div>
                    <div class="post-img" ng-if="contacts.user_image == '' || contacts.user_image == null">
                        <a href="<?php echo base_url();?>{{contacts.user_slug}}" target="_self" data-toggle="popover" data-tooltip-content="#people_tooltip_content_{{$index}}">
                            <img ng-if="contacts.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                            <img ng-if="contacts.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                        </a>
                    </div>
                    <div class="custom-user-detail">
                        <h4>
                            <a href="<?php echo base_url();?>{{contacts.user_slug}}" target="_self" ng-bind="(contacts.first_name | limitTo:1 | uppercase) + (contacts.first_name.substr(1) | lowercase) + ' ' + (contacts.last_name | limitTo:1 |uppercase) + (contacts.last_name.substr(1) | lowercase)" data-toggle="popover" data-tooltip-content="#people_tooltip_content_{{$index}}"></a>
                        </h4>
                        <p ng-if="contacts.title_name != null && contacts.degree_name == null">{{contacts.title_name}}</p>
                        <p ng-if="contacts.degree_name != null && contacts.title_name == null">{{contacts.degree_name}}</p>
                        <p ng-if="contacts.degree_name == null && contacts.title_name == null">Current work</p>
                    </div>
                    <div id="contact-btn-{{$index + 1}}" ng-if="contacts.user_id != user_id" class="custom-user-btn">

                        <!-- <a class="btn3" id="{{contacts.user_id}}" ng-click="remove(contacts.user_id)">In Contacts</a> -->

                        <a class="btn3" ng-if="contacts.contact_detail.contact_value == 'new'" ng-click="contact(contacts.contact_detail.contact_id, 'pending', contacts.user_id,$index + 1)">Add to contact</a>
                        <a class="btn1" ng-if="contacts.contact_detail.contact_value == 'confirm'" ng-click="contact(contacts.contact_detail.contact_id, 'cancel', contacts.user_id,$index + 1,1)">In Contacts</a>
                        <a class="btn3" ng-if="contacts.contact_detail.contact_value == 'pending'" ng-click="contact(contacts.contact_detail.contact_id, 'cancel', contacts.user_id,$index + 1)">Request sent</a>
                        <a class="btn3" ng-if="contacts.contact_detail.contact_value == 'cancel'" ng-click="contact(contacts.contact_detail.contact_id, 'pending', contacts.user_id,$index + 1)">Add to contact</a>
                        <a class="btn3" ng-if="contacts.contact_detail.contact_value == 'reject'" ng-click="contact(contacts.contact_detail.contact_id, 'pending', contacts.user_id,$index + 1)">Add to contact</a>
                    </div>
                    <div class="modal fade message-box" id="remove-contact-conform-{{$index + 1}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lm">
                            <div class="modal-content">
                                <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                                <div class="modal-body">
                                    <span class="mes">
                                        <div class="pop_content">Do you want to remove this contact?<div class="model_ok_cancel"><a class="okbtn" ng-click="remove_contact(contacts.contact_detail.contact_id, 'cancel', contacts.user_id,$index + 1)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fw post_loader loadmore" style="text-align:center; display: none;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>

                <div class="custom-user-box no-data-available"  ng-if="pagecntctData.pagedata.total_record == '0'">
                    <div class='art-img-nn'>
                        <div class='art_no_post_img'>
                            <img src="<?php echo base_url('assets/img/no-contact.png'); ?>" alt="No Contacts">
                        </div>
                        <div class='art_no_post_text'>No Contacts Available. </div>

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