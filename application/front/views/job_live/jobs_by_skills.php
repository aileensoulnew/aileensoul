<div class="custom-user-list">
        <div class="list-box-custom border-none cus-job">
            <div class="">
                <div class="">
                    <ul class="nav nav-tabs">
                        <li><a href="<?php echo base_url(); ?>jobs-by-categories"><span class="hidden-xs">Job by</span> Categories</a></li>
                        <li class="active"><a href="#"><span class="hidden-xs">Job by</span> Skill</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-location"><span class="hidden-xs">Job by</span> Location</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-companies"><span class="hidden-xs">Job by</span> Company</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-designations"><span class="hidden-xs">Job by</span> Designation</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs"><span class="hidden-xs">Jobs</a></li>
                    </ul>
                </div>
                <div class="all-detail-box">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="job-location">
                            <div class="location-box">
                                <ul data-aos="fade-up" data-aos-duration="1000">
                                    <li ng-repeat="js in jobBySkills">
                                        <a href="<?php echo base_url(); ?>{{js.skill_slug}}-jobs" target="_self">
                                            <div class="cus-cat-middle">
                                            <img src="<?php echo SKILLS_IMG_PATH;?>{{js.skill_image}}">
                                            <p>{{js.skill | capitalize}}<span>({{js.count}})</span></p>
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