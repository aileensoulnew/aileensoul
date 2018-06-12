<div class="custom-user-list">
        <div class="list-box-custom border-none cus-job">
            <div class="">
                <div class="">
                    <ul class="nav nav-tabs">
                        <li><a href="<?php echo base_url(); ?>jobs-by-categories"><span class="hidden-xs">Jobs by</span> Categories</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-skills"><span class="hidden-xs">Jobs by</span> Skills</a></li>
                        <li class="active"><a href="#"><span class="hidden-xs">Jobs by</span> Locations</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-companies"><span class="hidden-xs">Jobs by</span> Companies</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-designations"><span class="hidden-xs">Jobs by</span> Designations</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs">Jobs</a></li>
                    </ul>
                </div>
                <div class="all-detail-box">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="job-location">
                            <div class="location-box">
                                <ul data-aos="fade-up" data-aos-duration="1000">
                                    <li ng-repeat="jl in jobByLocation">
                                        <a href="<?php echo base_url(); ?>jobs-in-{{jl.slug}}" target="_self">
                                            <div class="cus-cat-middle">
                                            <img src="<?php echo CITY_IMG_PATH;?>{{jl.city_image}}">
                                            <p>Jobs in {{jl.city_name | capitalize}}</p>
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
        <?php echo $left_footer; ?>
    </div>