<div class="custom-user-list">
        <div class="list-box-custom border-none cus-job">
            <div class="">
                <div class="">
                    <ul class="nav nav-tabs">
                        <li><a href="<?php echo base_url(); ?>jobs-by-categories"><span class="hidden-xs">Jobs by</span> Categories</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-skills"><span class="hidden-xs">Jobs by</span> Skills</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-location"><span class="hidden-xs">Jobs by</span> Locations</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-companies"><span class="hidden-xs">Jobs by</span> Companies</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-designations"><span class="hidden-xs">Jobs by</span> Designations</a></li>
                        <li class="active"><a href="#">Jobs</a></li>
                    </ul>
                </div>
                <div class="all-jobs-list">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="job-category">
                            <div class="location-box">
                                <ul class="jobs-listing" >
                                    <li ng-repeat="(key, allJobVal) in jobByJobs">
                                        <h4>{{key}}</h4>
                                        <ul class="jobs-listing-main">
                                            <li ng-repeat="(inJobsKey, inJobsval) in allJobVal">
                                                <h5>{{inJobsKey}}</h5>
                                                <ul class="jobs-listing-sub">
                                                    <li ng-repeat="(byJobKey, byJobVal) in inJobsval">      
                                                        <a href="<?php //echo base_url(); ?>{{byJobVal.slug}}" target="_self"> {{byJobVal.name}} </a>
                                                    </li>
                                                </ul>
                                                <!-- <a href="<?php //echo base_url(); ?>{{alljobs.slug}}" target="_self"> {{alljobs.name}} </a> -->
                                            </li>
                                        </ul>                                        
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