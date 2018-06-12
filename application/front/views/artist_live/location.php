<div class="container pt20 mobp0">
    <div class="custom-user-list">
        <div class="list-box-custom border-none">
            <div class="">
                <div class="">
                    <ul class="nav nav-tabs">
                        <li><a href="<?php echo base_url(); ?>artist/category"><span class="hidden-xs">Artist by</span> Categories</a></li>
                        <li class="active"><a href="<?php echo base_url(); ?>artist/location"><span class="hidden-xs">Artist by</span> Location</a></li>
                        <li><a href="<?php echo base_url(); ?>artist">Artist</a></li>
                    </ul>
                </div>
                <div class="all-detail-box">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="artist-location">
                            <div class="location-box">
                                <ul data-aos="fade-up" data-aos-duration="1000">
                                    <li ng-repeat="location in artistAllLocation">
                                        <a href="<?php echo artist_location ?>{{location.location_slug}}" target="_self">
                                            <div class="cus-cat-middle">
                                                <img src="<?php echo base_url('assets/n-images/cat-2.png') ?>">
                                                <p ng-bind="location.art_location | capitalize"></p>
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
        <!-- <div class="add-box">
            <img src="<?php //echo base_url('assets/img/add.jpg') ?>">
        </div> -->
        <?php echo $right_profile_view; ?>
    </div>
</div>
