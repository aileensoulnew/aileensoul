<div class="custom-user-list">
    <div class="list-box-custom border-none">
        <div class="">
            <div class="">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="<?php echo base_url() ?>business-by-categories">
                            <span class="hidden-xs">Business by </span> Categories
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>business-by-location">
                            <span class="hidden-xs">Business by</span> Location
                        </a>
                    </li> 
                    <li>
                        <a href="<?php echo base_url() ?>business">
                            <span class="hidden-xs">Businesses</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="all-detail-box">
                <div class="tab-content">
                    <div class="tab-pane fade in <?php if($page == '' || !$page) echo 'active'; ?>" id="business-categories">
                        <div class="cat-box">
                            <ul data-aos="fade-up" data-aos-duration="1000">
                                <li ng-repeat="category in businessAllCategory">
                                    <a ng-href="<?php echo base_url ?>{{category.industry_slug}}-business" target="_self">
                                        <div class="cus-cat-middle">
                                            <img ng-src="<?php echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>" alt="{{category.industry_name}}">
                                            <p ng-bind="category.industry_name"></p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a ng-href="<?php echo base_url ?>other-business ?>">
                                        <div class="cus-cat-middle">
                                            <img ng-src="<?php echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>" alt="Other">
                                            <p>Other
                                                <!-- <span ng-bind="'(' + otherCategoryCount + ')'"></span> -->
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="tab-pane fade in <?php //if($page == 'location') echo 'active'; ?>" id="business-location">
                        <div class="location-box">
                            <ul data-aos="fade-up" data-aos-duration="1000">
                                <li ng-repeat="location in businessAllLocation">
                                    <a ng-href="<?php //echo base_url('business-in-') ?>{{location.slug}}">
                                        <div class="cus-cat-middle">
                                            <img src="<?php //echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>">
                                            <p ng-bind="location.city_name"></p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>


<div class="right-part">
    <div class="add-box">
        <img src="<?php echo base_url('assets/img/add.jpg?ver=' . time()) ?>" alt="{{category.industry_name}}">
    </div>
</div>