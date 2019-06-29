<div class="mob-search-btn">
    <a data-toggle="modal" id="showBottom">
        <span><img src="<?php echo base_url('assets/n-images/filter.png');?>"></span> 
    </a>
</div>
<div class="left-section filter-fix">
    <div class="search-box">
        <form id="main_search" class="bus-search" name="main_search" action="javascript:void(0);" method="post">
            <div class="search-left-box">
                <h3>Top Categories</h3>            
                <div class="form-group">
                    <?php $businessCategory = $this->business_model->businessCategory(5);
                    if(isset($businessCategory) && !empty($businessCategory)):
                        foreach($businessCategory as $_businessCategory): ?>                    
                            <label class="control control--checkbox">
                                <span><?php echo ucwords($_businessCategory['industry_name']); ?>
                                    <span class="pull-right hide">(<?php echo $_businessCategory['count']; ?>)</span>
                                </span>
                                    <input id="fields" class="categorycheckbox" type="checkbox" name="industry_name[]" value="<?php echo $_businessCategory['industry_name']; ?>" style="height: 12px;">
                                <div class="control__indicator"></div>
                            </label>
                        
                    <?php
                        endforeach;
                    endif;?>
                </div>
            </div>
            <p class="text-left p10"><a href="<?php echo base_url('business-by-categories');?>" target="_self">View More Categories</a></p>

            <div class="search-left-box">
                <h3>City</h3>
                <div class="form-group">
                    <?php $businessLocation = $this->business_model->businessLocation(5);
                    if(isset($businessLocation) && !empty($businessLocation)):
                        foreach($businessLocation as $_businessLocation): ?>
                        
                            <label class="control control--checkbox">
                                <span><?php echo ucwords($_businessLocation['city_name']); ?>
                                    <span class="pull-right hide">(<?php echo $_businessLocation['count']; ?>)</span>
                                </span>
                                    <input class="locationcheckbox" type="checkbox" name="city_name[]" value="<?php echo $_businessLocation['city_name']; ?>" style="height: 12px;">
                                <div class="control__indicator"></div>
                            </label>                    
                    <?php
                        endforeach;
                    endif;?>
                </div>
            </div>
            <p class="text-left p10"><a href="<?php echo base_url('business-by-location');?>" target="_self">View More Location</a></p>
            <div class="search-left-box">
                <div class="form-group">
                    <a class="pull-left btn-new-1" ng-click="main_search_function();"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search
                        <img id="search-loader" ng-src="<?php echo base_url('assets/images/loader.gif');?>" alt="Loader" style="width: 20px;display: none;"/>
                    </a> 
                    <a class="pull-right btn-new-1" ng-click="clearData(0);"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
                </div>
            </div>
        </form>
    </div>    
</div>
<div class="middle-section">
    <div ng-if="business_data.length != 0" ng-repeat="business in business_data" ng-init="busIndex=$index">
        <div class="all-job-box search-business">
            <div class="search-business-top">
                <div class="bus-cover no-cover-upload">
                    <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="business.profile_background" target="_self"><img ng-src="<?php echo BUS_BG_MAIN_UPLOAD_URL ?>{{business.profile_background}}" on-error-src="<?php echo BASEURL.WHITEIMAGE ?>"></a>
                    <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="!business.profile_background" target="_self"><img ng-src="<?php echo BASEURL.WHITEIMAGE ?>" on-error-src="<?php echo BASEURL.WHITEIMAGE ?>"></a>
                </div>
                <div class="all-job-top bus-search-top">
                    <div class="post-img">
                        <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="business.business_user_image" target="_self" data-toggle="popover" data-uid="{{business.user_id}}" data-utype="2"><img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{business.business_user_image}}" on-error-src="<?php echo BASEURL.NOBUSIMAGE ?>"></a>
                        <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="!business.business_user_image" target="_self" data-toggle="popover" data-uid="{{business.user_id}}" data-utype="2"><img ng-src="<?php echo BASEURL.NOBUSIMAGE ?>" on-error-src="<?php echo BASEURL.NOBUSIMAGE ?>"></a>
                    </div>
                    <div class="job-top-detail">
                        <h5><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-bind="business.company_name" target="_self" data-toggle="popover" data-uid="{{business.user_id}}" data-utype="2"></a></h5>
                        <h5 class="bus-ind" ng-if="business.industry_name"><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-bind="business.industry_name" target="_self"></a></h5>
                        <h5 class="bus-ind" ng-if="!business.industry_name"><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-bind="business.other_industrial" target="_self"></a></h5>
                    </div>
                    <div class="bus-follow follow-btn-bus-{{business.user_id}}">                        
                        <a ng-if="business.follow_status == 1" class="btn-new-1 following" data-uid="{{business.user_id}}{{ today | date : 'hhmmss'}}" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus_{{business.user_id}}">Following</a>
                        <a ng-if="business.follow_status == 0 || !business.follow_status" class="btn-new-1 follow" data-uid="{{business.user_id}}{{ today| date : 'hhmmss'}}" onclick="follow_user_bus(this.id)" id="follow_btn_bus_{{business.user_id}}">Follow</a>
                    </div>
                </div>
            </div>
            <div class="all-job-middle">
                <ul class="search-detail">
                    <li ng-if="business.contact_website"><span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/website.png') ?>"></span> <p class="detail-content"><a ng-href="{{business.contact_website}}" target="_self" ng-bind="business.contact_website"></a></p></li>
                    
                    <li>
                        <span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/location.png') ?>"></span>
                        <p class="detail-content">
                            <span ng-if="business.city_name && !business.other_city" ng-bind="business.city_name"></span>
                            <span ng-if="!business.city_name && business.other_city" ng-bind="business.other_city"></span>
                            <span ng-if="business.city_name || business.other_city != ''">,(</span>
                            <span ng-bind="business.country_name"></span>
                            <span ng-if="business.city_name || business.other_city != ''">)</span>
                        </p>
                    </li>

                    <li ng-if="business.details"><span class="img"><img class="pr10" ng-src="<?php echo base_url('assets/n-images/exp.png') ?>"></span><p class="detail-content">{{business.details | limitTo:110}}...<a href="<?php echo BASEURL ?>company/{{business.business_slug}}" target="_self"> Read more</a></p></li>
                </ul>
            </div>
        </div>
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
<div class="search-box">
    <nav class="cbp-spmenu cbp-spmenu-horizontal cbp-spmenu-bottom" id="cbp-spmenu-s4">
        <form id="main_search_mob" class="bus-search" name="main_search" action="javascript:void(0);" method="post">
            <div class="search-left-box">
                <h3>Top Categories</h3>            
                <div class="form-group">
                    <?php $businessCategory = $this->business_model->businessCategory(5);
                    if(isset($businessCategory) && !empty($businessCategory)):
                        foreach($businessCategory as $_businessCategory): ?>                    
                            <label class="control control--checkbox">
                                <span><?php echo ucwords($_businessCategory['industry_name']); ?>
                                    <span class="pull-right hide">(<?php echo $_businessCategory['count']; ?>)</span>
                                </span>
                                    <input id="fields" class="categorycheckbox" type="checkbox" name="industry_name[]" value="<?php echo $_businessCategory['industry_name']; ?>" style="height: 12px;">
                                <div class="control__indicator"></div>
                            </label>
                        
                    <?php
                        endforeach;
                    endif;?>
                </div>
            </div>
            <p class="text-left p10 bus-filter"><a href="<?php echo base_url('business-by-categories');?>" target="_self">View More Categories</a></p>

            <div class="search-left-box">
                <h3>City</h3>
                <div class="form-group">
                    <?php $businessLocation = $this->business_model->businessLocation(5);
                    if(isset($businessLocation) && !empty($businessLocation)):
                        foreach($businessLocation as $_businessLocation): ?>
                        
                            <label class="control control--checkbox">
                                <span><?php echo ucwords($_businessLocation['city_name']); ?>
                                    <span class="pull-right hide">(<?php echo $_businessLocation['count']; ?>)</span>
                                </span>
                                    <input class="locationcheckbox" type="checkbox" name="city_name[]" value="<?php echo $_businessLocation['city_name']; ?>" style="height: 12px;">
                                <div class="control__indicator"></div>
                            </label>                    
                    <?php
                        endforeach;
                    endif;?>
                </div>
            </div>
            <p class="text-left p10 bus-filter"><a href="<?php echo base_url('business-by-location');?>" target="_self">View More Location</a></p>
            <div class="search-left-box">
                <div class="form-group">
                    <a class="pull-left btn-new-1" ng-click="main_search_function_mob();"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search
                        <img id="search-loader" ng-src="<?php echo base_url('assets/images/loader.gif');?>" alt="Loader" style="width: 20px;display: none;"/>
                    </a> 
                    <a class="pull-right btn-new-1" ng-click="clearData(1);"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
                </div>
            </div>
        </form>
    </nav>
</div>
<script>
    var menuBottom = document.getElementById( 'cbp-spmenu-s4' ),
    showBottom = document.getElementById( 'showBottom' ),
    body = document.body;

    showBottom.onclick = function() {
        classie.toggle( this, 'active' );
        classie.toggle( menuBottom, 'cbp-spmenu-open' );
        disableOther( 'showBottom' );
    };

    function disableOther( button ) {
        if( button !== 'showBottom' ) {
            classie.toggle( showBottom, 'disabled' );
        }
    }

    // mcustom scroll bar
    (function($){
        $(window).on("load",function(){
            $(".custom-scroll").mCustomScrollbar({
                autoHideScrollbar:true,
                theme:"minimal"
            });
        });
    })(jQuery);
</script>