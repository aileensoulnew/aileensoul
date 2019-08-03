<div class="two-sec">
    <div class="custom-user-list hash-tag-listing">
        <div class="list-box-custom">
            <div class="listing-top">
                <div class="row">
                    <div class="col-md-8 col-sm-6 col-xs-4">
                        <h1>Businesses</h1>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-8">
                        
                    </div>
                </div>
            </div>
            <div class="sugg-list business-list">
                <ul ng-if="business_data.length != 0">
                    <li ng-repeat="business in business_data" ng-init="busIndex=$index">
                        <div class="arti-profile-box">
                            <div class="user-cover-img">
                                <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" target="_self">
                                    <img ng-if="business.profile_background" ng-src="<?php echo BUS_BG_THUMB_UPLOAD_URL ?>{{business.profile_background}}" on-error-src="<?php echo BASEURL.WHITEIMAGE ?>">
                                    <div ng-if="business.profile_background" class="gradient-bg">
                                    </div>
                                </a>
                            </div>
                            <div class="user-pr-img">
                                <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" target="_self">                                    
                                    <img ng-if="business.business_user_image" ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{business.business_user_image}}" on-error-src="<?php echo BASEURL.NOBUSIMAGE ?>">
                                    <img ng-if="!business.business_user_image" ng-src="<?php echo BASEURL.NOBUSIMAGE ?>" on-error-src="<?php echo BASEURL.NOBUSIMAGE ?>">
                                </a>
                            </div>
                        </div>
                        <div class="bus-list-detial">
                            <div class="bus-list-left">
                                <h4><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" target="_self">{{business.company_name}}</a></h4>
                                <p>{{business.industry_name ? business.industry_name : business.other_industrial}}({{business.city_name ? business.city_name : (business.other_city ? business.other_city :business.country_name)}})</p>
                            </div>
                            <div class="bus-list-right follow-btn-bus-{{business.user_id}}">
                                <a ng-if="business.follow_status == 1" class="btn-new-1 following" data-uid="{{business.user_id}}{{ today | date : 'hhmmss'}}" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus_{{business.user_id}}">Following</a>
                                <a ng-if="business.follow_status == 0 || !business.follow_status" class="btn-new-1 follow" data-uid="{{business.user_id}}{{ today| date : 'hhmmss'}}" onclick="follow_user_bus(this.id)" id="follow_btn_bus_{{business.user_id}}">Follow</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div ng-if="total_record == 0" ng-class="total_record == 0 ? 'no-search-data' : ''">
                <div class="custom-user-box no-data-available">
                    <div class='art-img-nn'>
                        <div class='art_no_post_img'>
                            <img src="<?php echo base_url('assets/img/no-post.png'); ?>" alt="No Business">
                        </div>
                        <div class='art_no_post_text'>No Business Available. </div>
                    </div>
                </div>
            </div>
            <div id="business-loader" class="fw post_loader" style="text-align: center;display: none;z-index: 9;">
                <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
            </div>
        </div>
    </div>
    <div class="right-section right-fixed-cus">
        <?php $this->load->view('right_add_box'); ?>
    </div>
</div>