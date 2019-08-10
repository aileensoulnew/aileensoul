<div class="pt20 fw">
<div class="container mobp0 followers-page">
    <div class="custom-user-list">
		<!-- <div class="tab-add-991 ads">
            <?php
            // $data['data'] = 'ads';
            // $this->load->view('ads_box',$data); ?>
		</div> -->
        <div class="list-box-custom">
            <h3 class="mob-border-top-1">Followers</h3>
            <div class="list-cus fw mobp0">
                <!-- <input name="page_number" class="page_number"  ng-model="page_number" ng-value="pagecntctData.pagedata.page">
                <input name="total_record" class="total_record"  ng-model="total_record" ng-value="pagecntctData.pagedata.total_record">
                <input name="perpage_record" class="perpage_record"  ng-model="perpage_record" ng-value="pagecntctData.pagedata.perpage_record"> -->
                
                <div class="custom-user-box" ng-if="pagecntctData.pagedata.total_record != '0'" ng-repeat="follow in followersData">
                    <div class="post-img" ng-if="follow.user_image != '' && follow.user_image != null">
                        <a href="<?php echo base_url();?>{{follow.user_slug}}" target="_self" data-popover data-uid="{{follow.user_id}}" data-utype="1">
                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{follow.user_image}}">
                        </a>
                    </div>

                    <div class="post-img" ng-if="follow.user_image == '' || follow.user_image == null">
                        <a href="<?php echo base_url();?>{{follow.user_slug}}" target="_self" data-popover data-uid="{{follow.user_id}}" data-utype="1">
                            <img ng-if="follow.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                            <img ng-if="follow.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                        </a>
                    </div>
                    <div class="custom-user-detail">
                        <h4>
                            <a href="<?php echo base_url();?>{{follow.user_slug}}" target="_self" ng-bind="(follow.first_name | limitTo:1 | uppercase) + (follow.first_name.substr(1) | lowercase) + ' ' + (follow.last_name | limitTo:1 | uppercase) + (follow.last_name.substr(1) | lowercase)" data-popover data-uid="{{follow.user_id}}" data-utype="1"></a>
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
		<!-- <div class="tab-add ads">
            <?php
            // $data['data'] = 'ads';
            // $this->load->view('ads_box',$data); ?>
		</div> -->
    </div>
    <div class="right-add">
        <?php $this->load->view('right_add_box'); ?>
    </div>
</div>
</div>


