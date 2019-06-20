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
                                    <input id="fields" class="categorycheckbox" type="checkbox" name="industry_name[]" value="<?php echo $_businessCategory['industry_id']; ?>" style="height: 12px;">
                                <div class="control__indicator"></div>
                            </label>
                        
                    <?php
                        endforeach;
                    endif;?>
                </div>
            </div>
            <p class="text-left p10"><a href="<?php echo base_url('business-by-categories');?>" target="_self">View More Categories</a></p>
            
            <div class="search-left-box">
                <h3>Top Locations</h3>
                <div class="form-group">
                    <?php $businessLocation = $this->business_model->businessLocation(5);
                    if(isset($businessLocation) && !empty($businessLocation)):
                        foreach($businessLocation as $_businessLocation): ?>
                        
                            <label class="control control--checkbox">
                                <span><?php echo ucwords($_businessLocation['city_name']); ?>
                                    <span class="pull-right hide">(<?php echo $_businessLocation['count']; ?>)</span>
                                </span>
                                    <input class="locationcheckbox" type="checkbox" name="city_name[]" value="<?php echo $_businessLocation['city_id']; ?>" style="height: 12px;">
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
                    <a class="pull-left btn-new-1" ng-click="main_search_function();"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search</a> 
                    <a class="pull-right btn-new-1" ng-click="clearData();"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
                </div>
            </div>
        </form>
    </div>    
</div>
<div class="middle-section">    
    <div ng-if="business_data.length != 0" ng-repeat="business in business_data" ng-init="busIndex=$index">
        <div id="tooltip_content_{{busIndex}}" class="tooltip_templates">
            <div class="bus-tooltip">
                <div class="user-tooltip">
                    <div class="tooltip-cover-img">
                        <img ng-if="business.profile_background" ng-src="<?php echo BUS_BG_MAIN_UPLOAD_URL ?>{{business.profile_background}}">
                        <div ng-if="business.profile_background == null || business.profile_background == ''" class="gradient-bg" style="height: 100%"></div>
                    </div>
                    <div class="tooltip-user-detail">
                        <div class="tooltip-user-img">
                            <img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{business.business_user_image}}" ng-if="business.business_user_image">
                            <img ng-if="!business.business_user_image" ng-src="<?php echo base_url(NOBUSIMAGE); ?>">
                        </div>
                        <div class="fw">
                            <div class="tooltip-detail">
                                <h4 ng-bind="business.company_name"></h4>
                                <p ng-if="business.industry_name != null" ng-bind="business.industry_name"></p> 
                                <p ng-if="!business.industry_name">CURRENT WORK</p>
                                <p>{{business.city_name}}{{business.city_name != '' ? ',' : ''}}{{business.state_name}}{{business.state_name != '' ? ',' : ''}}{{business.country_name}}</p>
                            </div>
                            
                            <div class="tooltip-btns follow-btn-bus-{{business.user_id}}">
                                <a ng-if="business.follow_status == 1" class="btn-new-1 following" data-uid="{{business.user_id}}{{ today | date : 'hhmmss'}}" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus_{{business.user_id}}">Following</a>

                                <a ng-if="business.follow_status == 0 || !business.follow_status" class="btn-new-1 follow" data-uid="{{business.user_id}}{{ today| date : 'hhmmss'}}" onclick="follow_user_bus(this.id)" id="follow_btn_bus_{{business.user_id}}">Follow</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="all-job-box search-business">
            <div class="search-business-top">
                <div class="bus-cover no-cover-upload">
                    <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="business.profile_background" target="_self"><img ng-src="<?php echo BUS_BG_MAIN_UPLOAD_URL ?>{{business.profile_background}}" on-error-src="<?php echo BASEURL.WHITEIMAGE ?>"></a>
                    <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="!business.profile_background" target="_self"><img ng-src="<?php echo BASEURL.WHITEIMAGE ?>" on-error-src="<?php echo BASEURL.WHITEIMAGE ?>"></a>
                </div>
                <div class="all-job-top bus-search-top">
                    <div class="post-img">
                        <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="business.business_user_image" target="_self" data-toggle="popover" data-tooltip-content="#tooltip_content_{{busIndex}}"><img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{business.business_user_image}}" on-error-src="<?php echo BASEURL.NOBUSIMAGE ?>"></a>
                        <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="!business.business_user_image" target="_self" data-toggle="popover" data-tooltip-content="#tooltip_content_{{busIndex}}"><img ng-src="<?php echo BASEURL.NOBUSIMAGE ?>" on-error-src="<?php echo BASEURL.NOBUSIMAGE ?>"></a>
                    </div>
                    <div class="job-top-detail">
                        <h5><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-bind="business.company_name" target="_self" data-toggle="popover" data-tooltip-content="#tooltip_content_{{busIndex}}"></a></h5>
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
    <div ng-if="total_record == 0 && postData.length == 0" ng-class="total_record == 0 ? 'no-search-data' : ''">
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
<div class="mob-filter" data-target="#filter" data-toggle="modal">
    <svg width="25.000000pt" height="25.000000pt" viewBox="0 0 300.000000 300.000000">
        <g transform="translate(0.000000,300.000000) scale(0.100000,-0.100000)" fill="#1b8ab9" stroke="none">
            <path d="M489 2781 l-29 -29 0 -221 0 -221 -110 0 c-115 0 -161 -12 -174 -45
        -3 -9 -6 -163 -6 -341 l0 -325 25 -24 c23 -24 30 -25 144 -25 l121 0 2 -646 3
        -646 24 -19 c33 -27 92 -25 119 4 l22 23 0 642 0 642 124 0 c107 0 127 3 147
        19 l24 19 3 331 3 332 -30 29 c-29 30 -30 30 -150 30 l-121 0 0 225 0 226 -25
        24 c-34 35 -78 33 -116 -4z m271 -851 l0 -210 -210 0 -210 0 0 210 0 210 210
        0 210 0 0 -210z"></path>
            <path d="M1445 2785 l-25 -24 0 -641 0 -640 -119 0 c-105 0 -121 -2 -145 -21
        l-26 -20 0 -338 0 -338 23 -21 c21 -20 34 -22 145 -22 l122 0 0 -224 c0 -211
        1 -225 21 -250 16 -21 29 -26 64 -26 35 0 48 5 64 26 20 25 21 39 21 250 l0
        224 123 0 c181 0 167 -33 167 382 l0 337 -26 20 c-24 19 -40 21 -145 21 l-119
        0 0 640 0 641 -25 24 c-33 34 -87 34 -120 0z m275 -1685 l0 -210 -215 0 -215
        0 0 210 0 210 215 0 215 0 0 -210z"></path>
            <path d="M2405 2785 l-25 -24 0 -226 0 -225 -121 0 c-120 0 -121 0 -150 -30
        l-30 -29 3 -332 3 -331 24 -19 c20 -16 40 -19 147 -19 l124 0 0 -643 0 -644
        23 -21 c29 -28 86 -29 118 -3 l24 19 3 646 2 646 121 0 c114 0 121 1 144 25
        l25 24 0 325 c0 178 -3 332 -6 341 -13 33 -59 45 -174 45 l-110 0 0 221 0 221
        -29 29 c-38 37 -82 39 -116 4z m265 -855 l0 -210 -210 0 -210 0 0 210 0 210
        210 0 210 0 0 -210z"></path>
        </g>
    </svg>
</div>
<div id="filter" class="modal mob-modal fade" role="dialog">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>         
            <div class="mid-modal-body">
                <div class="mid-modal-body">
                    <div class="search-box">
                        <form id="main_search_mob" name="main_search" action="javascript:void(0);" method="post">
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
                                                    <input id="fields" class="categorycheckbox" type="checkbox" name="industry_name[]" value="<?php echo $_businessCategory['industry_id']; ?>" style="height: 12px;">
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
                                                    <input class="locationcheckbox" type="checkbox" name="city_name[]" value="<?php echo $_businessLocation['city_id']; ?>" style="height: 12px;">
                                                <div class="control__indicator"></div>
                                            </label>                    
                                    <?php
                                        endforeach;
                                    endif;?>
                                </div>
                            </div>

                            <p class="text-left p10"><a href="<?php echo base_url('business-by-location');?>" target="_self">View More Location</a></p>
                            <div class="search-left-box pt15">
                                <div class="form-group">
                                    <a data-dismiss="modal" class="pull-left btn-new-1" ng-click="main_search_mob_function();"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search</a> 
                                    <a data-dismiss="modal" class="pull-right btn-new-1" ng-click="clearData();"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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