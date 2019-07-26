<div class="pt20 fw">
    <div class="container mobp0 following-page">
        <div class="custom-user-list">
            <div class="tab-add-991 ads">
                <?php
                $data['data'] = 'ads';
                $this->load->view('ads_box',$data); ?>          
            </div>
            <ul class="nav nav-tabs" role="tablist">
                <li><a href="<?php echo base_url(); ?>{{user_slug}}/following" ng-click='makeActive("following")'>People</a></li>
                <li class="active"><a href="#">Hashtags</a></li>
            </ul>
            <div class="custom-user-list hash-tag-listing">
                <div class="list-box-custom">
                    <div class="hashtag-list">
                        <ul>
                            <li ng-repeat="hashtag_arr in hashtag_list">
                                <div class="hash-box">
                                    <div class="hash-box-top">
                                        <div class="hash-round">
                                            <a href="<?php echo base_url().'hashtag/'; ?>{{hashtag_arr.hashtag}}" target="_self">
                                                #{{hashtag_arr.hashtag | limitTo:1 | uppercase}}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="hash-detail">
                                        <p class="hash-name" title="#{{hashtag_arr.hashtag}}">
                                            <a href="<?php echo base_url().'hashtag/'; ?>{{hashtag_arr.hashtag}}" target="_self">#{{hashtag_arr.hashtag}}</a>
                                        </p>
                                        <p class="hash-follow">
                                            {{hashtag_arr.hashtag_follower_count ? hashtag_arr.hashtag_follower_count+' Followers' : '&nbsp;' }}</p>
                                        <a href="#" class="btn-new-1 hashtag-follow-btn-{{hashtag_arr.id}}" ng-if="hashtag_arr.hashtag_follow_status == 0" ng-click="follow_hashtag(hashtag_arr.id,$index);">Follow</a>
                                        <a href="#" class="btn-new-1 hashtag-follow-btn-{{hashtag_arr.id}}" ng-if="hashtag_arr.hashtag_follow_status == 1" ng-click="unfollow_hashtag(hashtag_arr.id,$index);">Following</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="hashtag-loader" class="fw post_loader" style="text-align: center;display: none;z-index: 9;">
                        <img ng-src="<?php echo base_url('assets/images/loader.gif'); ?>" alt="Loader" />
                    </div>
                    <div class="custom-user-box no-data-available"  ng-if="total_record == '0'">
                        <div class="art-img-nn">
                            <div class="art_no_post_img">
                                <img src="<?php echo base_url('assets/img/no-following.png'); ?>" alt="No Following">
                            </div>
                            <div class="art_no_post_text">
                                No Hashtags Available.
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
        </div>
        <div class="right-add">
            <?php $this->load->view('right_add_box'); ?>
        </div>
    </div>
</div>