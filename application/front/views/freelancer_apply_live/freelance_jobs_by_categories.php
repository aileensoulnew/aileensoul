<div class="custom-user-list">
    <div class="list-box-custom border-none cus-job">
        <div class="">
            <div class="">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#"><span class="hidden-xs">Freelance Job by</span> Categories</a></li>
                    <li><a href="<?php echo base_url(); ?>freelance-jobs-by-fields"><span class="hidden-xs">Freelance Job by</span> Fields</a></li>
                </ul>
            </div>
            <div class="all-detail-box">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="job-category">
                        <div class="location-box">
                            <ul data-aos="fade-up" data-aos-duration="1000">
                                <li ng-repeat="jc in jobByCategory">
                                    <a href="<?php echo base_url(); ?>freelance-jobs/{{jc.skill_slug}}" target="_self">
                                        <div class="cus-cat-middle">
                                        <img src="<?php echo SKILLS_IMG_PATH ?>{{jc.skill_image}}">
                                        <p>{{jc.skill | capitalize}}</p>
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
        <img src="<?php // echo base_url();?>assets/img/add.jpg">
    </div> -->
    <?php echo $right_profile_view; ?>
    <?php echo $left_footer_list_view; ?>
</div>