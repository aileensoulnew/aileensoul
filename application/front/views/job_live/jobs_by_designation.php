<div class="custom-user-list">
        <div class="list-box-custom border-none cus-job">
            <div class="">
                <div class="">
                    <ul class="nav nav-tabs">
                        <li><a href="<?php echo base_url(); ?>jobs-by-categories"><span class="hidden-xs">Job by</span> Categories</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-skills"><span class="hidden-xs">Job by</span> Skill</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-location"><span class="hidden-xs">Job by</span> Location</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-companies"><span class="hidden-xs">Job by</span> Company</a></li>
                        <li class="active"><a href="#"><span class="hidden-xs">Job by</span> Designation</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs"><span class="hidden-xs">Jobs</a></li>
                    </ul>
                </div>
                <div class="all-detail-box">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="job-location">
                            <div class="location-box">
                                <ul data-aos="fade-up" data-aos-duration="1000">
                                    <li ng-repeat="jd in jobByDesc">
                                        <a href="<?php echo base_url(); ?>{{jd.job_slug}}-jobs" target="_self">
                                            <div class="cus-cat-middle">
                                            <img src="<?php echo DESIGNATION_IMG_PATH;?>{{jd.job_title_img}}">
                                            <p>{{jd.job_title | capitalize}}<span>({{jd.count}})</span></p>
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