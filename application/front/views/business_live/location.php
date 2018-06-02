<div class="custom-user-list">
    <div class="list-box-custom border-none">
        <div class="">           
            <div class="">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="<?php echo base_url() ?>business-by-categories">
                            <span class="hidden-xs">Business by </span> Categories
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?php echo base_url() ?>business-by-location">
                            <span class="hidden-xs">Business by</span> Location
                        </a>
                    </li> 
                    <li>
                        <a href="<?php echo base_url() ?>business">
                            Businesses
                        </a>
                    </li>
                </ul>
            </div>

            <div class="all-detail-box">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="business-location">
                    <div class="location-box">
                        <ul data-aos="fade-up" data-aos-duration="1000">
                            <li ng-repeat="location in businessAllLocation">
                                <a ng-href="<?php echo base_url('business-in-') ?>{{location.slug}}"  target="_self">
                                    <div class="cus-cat-middle">
                                        <img src="<?php echo base_url('assets/n-images/cat-1.png?ver=' . time()) ?>">
                                        <p ng-bind="location.city_name"></p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
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