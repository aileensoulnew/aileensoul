<div class="two-sec">  
        <div class="custom-user-list hash-tag-listing">
            <div class="list-box-custom">
                <div class="listing-top">
                    <div class="row">
                        <div class="col-md-8 col-sm-6 col-xs-4">
                            <h1>Hashtags</h1>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-8">
                            <div class="hash-search">
                                <input type="text" placeholder="Search hash tag" ng-model="search_tag" ng-keypress="check_enter_key($event)" />
                                <a href="#" ng-click="get_hashtag_search();"><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></a>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hashtag-list">
                    <ul>
                        <li ng-repeat="hashtag_arr in hashtag_list">
                            <div class="hash-box">
                                <div class="hash-box-top">
                                    <div class="hash-round">
                                        #{{hashtag_arr.hashtag | limitTo:1 | uppercase}}
                                    </div>
                                </div>
                                <div class="hash-detail">
                                    <p class="hash-name" title="#{{hashtag_arr.hashtag}}">#{{hashtag_arr.hashtag}}</p>
                                    <p class="hash-follow">
                                        {{hashtag_arr.hashtag_follower_count && hashtag_arr.hashtag_follower_count > 0 ? hashtag_arr.hashtag_follower_count+' Followers' : '&nbsp;' }}</p>
                                    <a href="#" class="btn-new-1 hashtag-follow-btn-{{hashtag_arr.id}}" ng-if="hashtag_arr.hashtag_follow_status == 0" ng-click="follow_hashtag(hashtag_arr.id,$index);">Follow</a>
                                    <a href="#" class="btn-new-1 hashtag-follow-btn-{{hashtag_arr.id}}" ng-if="hashtag_arr.hashtag_follow_status == 1" ng-click="unfollow_hashtag(hashtag_arr.id,$index);">Following</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="hashtag-loader" class="fw post_loader" style="text-align: center;display: none;z-index: 9;">
                    <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
                </div>
            </div>
        </div>
        <div class="right-section right-fixed-cus">
            <?php $this->load->view('right_add_box'); ?>
        </div>
    </div>
</div>