<div class="custom-user-list">
        <div class="list-box-custom border-none cus-job">
            <div class="">
                <div class="">
                    <ul class="nav nav-tabs">
                        <li><a href="<?php echo base_url(); ?>jobs-by-categories"><span class="hidden-xs">Jobs by</span> Categories</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-skills"><span class="hidden-xs">Jobs by</span> Skills</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-location"><span class="hidden-xs">Jobs by</span> Locations</a></li>
                        <li class="active"><a href="#"><span class="hidden-xs">Jobs by</span> Companies</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs-by-designations"><span class="hidden-xs">Jobs by</span> Designations</a></li>
                        <li><a href="<?php echo base_url(); ?>jobs">Jobs</a></li>
                    </ul>
                </div>
                <div class="all-detail-box">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="job-company">
                            <div class="location-box">
                                <ul data-aos="fade-up" data-aos-duration="1000">
                                    <li ng-repeat="jc in jobByComp">
                                        <a href="<?php echo base_url(); ?>jobs-opening-at-{{jc.company_name | slugify}}-{{jc.rec_id}}" target="_self">
                                            <div class="cus-cat-middle">
                                            <img check-image-new ng-src="<?php echo REC_PROFILE_THUMB_UPLOAD_URL ?>{{jc.comp_logo}}">
                                            <!-- <img ng-if="!jc.comp_logo" src="<?php //echo base_url('assets/n-images/commen-img.png') ?>"> -->
                                            <p>{{jc.company_name | capitalize}}<span>({{jc.count}})</span></p>
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