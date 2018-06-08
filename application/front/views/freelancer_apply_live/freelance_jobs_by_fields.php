<div class="custom-user-list">
    <div class="list-box-custom border-none cus-job">
        <div class="">
            <div class="">
                <ul class="nav nav-tabs">
                    <li><a href="<?php echo base_url(); ?>freelance-jobs-by-categories"><span class="hidden-xs">Freelance Job by</span> Categories</a></li>
                    <li class="active"><a href="#"><span class="hidden-xs">Freelance Jobs by</span> Fields</a></li>
                </ul>
            </div>
            <div class="all-detail-box">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="job-location">
                        <div class="location-box">
                            <ul data-aos="fade-up" data-aos-duration="1000">
                                <li ng-repeat="jf in jobByField">
                                    <a href="<?php echo base_url(); ?>freelance-jobs/{{jf.category_slug}}" target="_self">
                                        <div class="cus-cat-middle">
                                        <img src="<?php echo FA_CATEGORY_IMG_PATH;?>{{jf.category_image}}">
                                        <p><span>{{jf.category_name | capitalize}}</span><span>({{jf.count}})</span></p>
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
        <img src="<?php //echo base_url();?>assets/img/add.jpg">
    </div> -->
    <?php echo $right_profile_view; ?>
    <?php echo $left_footer_list_view; ?>
</div>