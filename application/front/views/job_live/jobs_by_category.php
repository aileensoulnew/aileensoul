<div class="custom-user-list">
        <div class="list-box-custom border-none cus-job">
            <div class="">
                <div class="">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#"><span class="hidden-xs">Jobs by</span> Categories</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-skills"><span class="hidden-xs">Jobs by</span> Skills</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-location"><span class="hidden-xs">Jobs by</span> Locations</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-companies"><span class="hidden-xs">Jobs by</span> Companies</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-designations"><span class="hidden-xs">Jobs by</span> Designations</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs">Jobs</a></li>
                    </ul>
                </div>
                <div class="all-detail-box">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="job-category">
                            <div class="location-box">
                                <ul data-aos="fade-up" data-aos-duration="1000">
                                    <li ng-repeat="jc in jobByCat">
                                        <a href="<?php echo base_url(); ?>{{jc.industry_slug}}-jobs" target="_self">
                                            <div class="cus-cat-middle">
                                            <img src="<?php echo JOB_INDUSTRY_IMG_PATH ?>{{jc.industry_image}}">
                                            <p>{{jc.industry_name | capitalize}}<span>({{jc.count}})</span></p>
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
            <img src="<?php echo base_url();?>assets/img/add.jpg">
        </div>
    </div>