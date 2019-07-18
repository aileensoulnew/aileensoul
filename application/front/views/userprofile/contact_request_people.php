<div class="tab-add-991">
	<?php $this->load->view('banner_add'); ?>
    <div class="request-noti-move">
    </div>
</div>
<div class="custom-user-list">
    <div class="list-box-custom" ng-if="pending_contact_request_data.length > '0'">
        <h3 class="mob-border-top-1">Pending Contact Request</h3>
        <div class="sugg-list">
            <div class="fw post_loader req_post_load" style="text-align:center; display: none;">
                <img ng-src="<?php echo base_url('assets/images/loader.gif')?>" alt="Loader" />
            </div>                                
            <ul class="pendin-req" ng-class="pending_contact_request_data.length < '3' ? 'first-pending-req' : ''">
                <li id="pending-con-{{$index + 1}}" ng-repeat="contact in pending_contact_request_data">
                    <div class="arti-profile-box">
                    	<div class="user-cover-img">
							<a href="<?php echo base_url();?>{{contact.user_slug}}" target="_self">
								<img ng-if="contact.profile_background" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{contact.profile_background}}">
								<div ng-if="!contact.profile_background" class="gradient-bg" style="height: 100%"></div>
							</a>
						</div>
						<div class="user-pr-img">
							<a href="<?php echo base_url();?>{{contact.user_slug}}" target="_self">
								<img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{contact.user_image}}" ng-if="contact.user_image">                                                
                                <img ng-if="!contact.user_image && contact.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                <img ng-if="!contact.user_image && contact.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
							</a>
						</div>                                            
                        <div class="user-info-text text-center">
                            <p>
                                <a href="<?php echo base_url(); ?>{{contact.user_slug}}" target="_self">
                                	<span title="{{contact.fullname| capitalize}}" class="user-name main_data_cq" ng-bind="contact.fullname | capitalize"></span>
                                </a>
                            </p>
								<span class="user-des main_data_cq" title="{{contact.title_name}}" ng-if="contact.title_name != ''">{{contact.title_name}}</span>
								<span class="user-des main_data_cq" title="{{contact.degree_name}}" ng-if="contact.degree_name != ''">{{contact.degree_name}}</span>
								<span class="user-des main_data_cq" title="Current Work" ng-if="contact.title_name == null && contact.degree_name == null">Current Work</span>
							
                        </div>
                        <div class="author-btn">
                        	<p class="request-btn">
                                <a href="javascript:void(0);" class="btn1" ng-click="confirmContact(contact.from_id, $index)">
                                    Confirm
                                </a>
                                <a href="javascript:void(0);" class="btn3" ng-click="rejectContact(contact.from_id, $index)">
                                    Decline
                                </a>
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="list-box-custom suggestion">
        <h3>Suggestions</h3>
		<div class="sugg-list">
			<div class="no-data-box" ng-if="contactSuggetion.length == '0'">
                <div class="no-data-content">
                    <p><img src="<?php echo base_url('assets/img/No_Contact_Request.png') ?>"></p>
                    <p class="pt20">No Suggestion Contact Request</p>
                </div>
            </div>
			<ul class="">
				<li ng-repeat="suggest in contactSuggetion">
					<div class="arti-profile-box">
						<div class="user-cover-img">
							<a href="<?php echo base_url();?>{{suggest.user_slug}}" target="_self">
								<img ng-if="suggest.profile_background" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{suggest.profile_background}}">
								<div ng-if="!suggest.profile_background" class="gradient-bg" style="height: 100%"></div>
							</a>
						</div>
						<div class="user-pr-img">
							<a href="<?php echo base_url();?>{{suggest.user_slug}}" target="_self" data-toggle="popover" data-uid="{{suggest.user_id}}" data-utype="1">
								<img ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{suggest.user_image}}" ng-if="suggest.user_image">
                                <img ng-if="!suggest.user_image && suggest.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                                <img ng-if="!suggest.user_image && suggest.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
							</a>
						</div>
						<div class="user-info-text text-center">
							<p>
                                <a href="<?php echo base_url();?>{{suggest.user_slug}}" target="_self" data-toggle="popover" data-uid="{{suggest.user_id}}" data-utype="1">
									<span title="{{suggest.fullname| capitalize}}" class="user-name main_data_cq" ng-bind="suggest.fullname | capitalize"></span>
                                </a>
                            </p>    
                                <span class="user-des main_data_cq" title="{{suggest.title_name}}" ng-if="suggest.title_name">{{suggest.title_name}}</span>
                                <span class="user-des main_data_cq" title="{{suggest.degree_name}}" ng-if="suggest.degree_name">{{suggest.degree_name}}</span>
                                <span class="user-des main_data_cq" title="Current Work" ng-if="!suggest.title_name && !suggest.degree_name">Current Work</span>
							
						</div>
						
						<div class="author-btn">
							<div id="item-{{suggest.user_id}}" class="user-btns contact-btn-{{suggest.user_id}}">
                                <a class="btn-new-1" ng-if="suggest.contact_value == 'new'" data-param="{{suggest.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ suggest.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_bt_{{suggest.user_id}}">Add to contact</a>

								<!-- <a class="btn3" ng-click="addToContact(suggest.user_id, suggest);">Add to Contacts</a> -->
							</div>
						</div>
					</div>
				</li>
			</ul>
			<div class="fw post_loader sugg_post_load" style="text-align:center; display: none;">
                <img ng-src="<?php echo base_url('assets/images/loader.gif');?>" alt="Loader" />
            </div>
		</div>
    </div>
</div>
<div class="right-add">
	<?php $this->load->view('right_add_box'); ?>
    <div id="request-noti-move" class="request-noti">
        <div class="right-title">
            Contact Request Notifications
        </div>
        <div class="content custom-scroll">
            <div class="no-data-box" ng-if="contactRequestNotification.length == '0'">
                <div class="no-data-content">
                    <p><img src="<?php echo base_url('assets/img/No_Contact_Request.png') ?>"></p>
                    <p class="pt20">No Contact Request Notification</p>
                </div>
            </div>
            <ul class="request-list">
                <li ng-repeat="notification in contactRequestNotification">
                    <a href="<?php echo base_url(); ?>{{notification.user_slug}}">
                        <div class="post-img">
                            <img src="<?php echo USER_MAIN_UPLOAD_URL ?>{{notification.user_image}}" alt="{{notification.fullname}}" ng-if="notification.user_image != ''">
                            <img ng-if="notification.user_image == '' && notification.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                            <img ng-if="notification.user_image == '' && notification.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                        </div>
                        <div class="request-detail">
                            <h6 class="">
                                <b ng-bind="notification.fullname | capitalize" ng-bind="notification.fullname | capitalize"></b> confirmed your contact request.
                            </h6>
                            <p>{{notification.time_string}}</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?php echo $left_footer_list_view; ?>
    <!-- <div class="add-box fw">
        <div class="adv-main-view">
            <img src="<?php //echo base_url('assets/n-images/add.jpg'); ?>">
        </div>
    </div> -->
</div>