<div class="custom-user-list">
    <div class="list-box-custom border-none cus-job">
        <div class="">
            <div class="">
                <ul class="nav nav-tabs">
                    <li><a href="<?php echo base_url(); ?>freelance-jobs-by-categories"><span class="hidden-xs">Frrelance Job by</span> Categories</a></li>
                    <li class="active"><a href="#"><span class="hidden-xs">Frrelance Jobs by</span> Fields</a></li>
                </ul>
            </div>
            <div class="all-detail-box">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="job-location">
                        <div class="location-box">
                            <ul data-aos="fade-up" data-aos-duration="1000">
                                <li ng-repeat="jf in jobByField">
                                    <a href="<?php echo base_url(); ?>freelance-jobs/{{jf.industry_slug}}" target="_self">
                                        <div class="cus-cat-middle">
                                        <img src="<?php echo JOB_INDUSTRY_IMG_PATH;?>{{jf.industry_image}}">
                                        <p>{{jf.industry_name | capitalize}}<span>({{jf.count}})</span></p>
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