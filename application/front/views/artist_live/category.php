<div class="custom-user-list">
    <div class="list-box-custom border-none">
        <div class="">
            <div class="">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="<?php echo base_url(); ?>artist/category"><span class="hidden-xs">Artist by</span> Categories</a></li>
                    <li><a href="<?php echo base_url(); ?>artist/location"><span class="hidden-xs">Artist by</span> Location</a></li>
                    <li><a href="<?php echo base_url(); ?>artist"><span class="hidden-xs">Artist</span></a></li>
                </ul>
            </div>
            <div class="all-detail-box">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="artist-categories">
                        <div class="cat-box">
                            <ul data-aos="fade-up" data-aos-duration="1000">
                                <li ng-repeat="category in artistAllCategory">
                                    <a href="<?php echo artist_category ?>{{category.category_slug}}" target="_self">
                                        <div class="cus-cat-middle">
                                            <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                            <p ng-bind="category.art_category | capitalize"></p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo artist_other_category; ?>" target="_self">
                                        <div class="cus-cat-middle">
                                            <img src="<?php echo base_url('assets/n-images/cat-1.png') ?>">
                                            <p>Other</p>
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
        <img src="<?php echo base_url('assets/img/add.jpg') ?>">
    </div>
</div>
