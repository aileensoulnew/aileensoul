<div class="left-section filter-fix">
    <div class="search-box">
        <form id="main_search" name="main_search" action="javascript:void(0);" method="post">
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
            <div class="search-left-box pt15">
                <div class="form-group">
                    <a class="pull-left btn-new-1" ng-click="main_search_function();"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search
                        <img id="search-loader" ng-src="<?php echo base_url('assets/images/loader.gif');?>" alt="Loader" style="width: 20px;display: none;"/>
                    </a> 
                    <a class="pull-right btn-new-1" ng-click="clearData();"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
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
                <div class="all-job-top">
                    <div class="post-img">
                        <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="business.business_user_image" target="_self"><img ng-src="<?php echo BUS_PROFILE_THUMB_UPLOAD_URL ?>{{business.business_user_image}}" on-error-src="<?php echo BASEURL.NOBUSIMAGE ?>"></a>
                        <a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-if="!business.business_user_image" target="_self"><img ng-src="<?php echo BASEURL.NOBUSIMAGE ?>" on-error-src="<?php echo BASEURL.NOBUSIMAGE ?>"></a>
                    </div>
                    <div class="job-top-detail">
                        <h5><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-bind="business.company_name" target="_self"></a></h5>
                        <h5 ng-if="business.industry_name"><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-bind="business.industry_name" target="_self"></a></h5>
                        <h5 ng-if="!business.industry_name"><a href="<?php echo BASEURL ?>company/{{business.business_slug}}" ng-bind="business.other_industrial" target="_self"></a></h5>
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
<!-- <div class="search-box">
    <nav class="cbp-spmenu cbp-spmenu-horizontal cbp-spmenu-bottom" id="cbp-spmenu-s4">
        <div class="search-left-box">
            <h3>Job title</h3>
            <div class="form-group">
                <input type="text" placeholder="Search by Job Title"> 
            </div>
        </div>
        <div class="search-left-box">
            <h3>Industry</h3>
            <div class="form-group">
                <span class="span-select">
                    <select placeholder="Search by Industry"> 
                        <option>It sectop</option>
                        <option>teacher</option>
                        <option>Docore</option>
                        <option>123</option>
                    </select>
                </span>
            </div>
        </div>
        <div class="search-left-box">
            <h3>City</h3>
            <div class="form-group">
                <input type="text" placeholder="Search by City"> 
            </div>
        </div>
        <div class="search-left-box">
            <h3>Hash Tag</h3>
            <div class="form-group">
                <input type="text" placeholder="Search by Hash Tag"> 
            </div>
        </div>
        <div class="search-left-box">
            <h3>Company</h3>
            <div class="form-group">
                <input type="text" placeholder="Search by Company"> 
            </div>
        </div>
        <div class="search-left-box pt15">
            <div class="form-group">
                <button class="pull-left btn-new-1"><span><img src="n-images/s-s.png"></span> Search</button> 
                <button class="pull-right btn-new-1"><span><img src="n-images/trash.png"></span> Clear</button> 
            </div>
        </div>        
    </nav>
</div> -->
<script>
    /*var menuRight = document.getElementById( 'cbp-spmenu-s2' );
    var menuBottom = document.getElementById( 'cbp-spmenu-s4' );
    var showRight = document.getElementById( 'showRight' );
    var showBottom = document.getElementById( 'showBottom' );
    var body = document.body;

    showRight.onclick = function() {
        classie.toggle( this, 'active' );
        classie.toggle( menuRight, 'cbp-spmenu-open' );
        disableOther( 'showRight' );
    };
    showBottom.onclick = function() {
        classie.toggle( this, 'active' );
        classie.toggle( menuBottom, 'cbp-spmenu-open' );
        disableOther( 'showBottom' );
    };

    function disableOther( button ) {
        
        if( button !== 'showRight' ) {
            classie.toggle( showRight, 'disabled' );
        }
        if( button !== 'showBottom' ) {
            classie.toggle( showBottom, 'disabled' );
        }
    }*/
</script>