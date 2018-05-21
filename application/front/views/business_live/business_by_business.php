<div class="custom-user-list">
    <div class="list-box-custom border-none">
        <div class="">
            <div class="">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="<?php echo base_url() ?>business-by-categories">
                            <span class="hidden-xs">Business by </span> Categories
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>business-by-location">
                            <span class="hidden-xs">Business by</span> Location
                        </a>
                    </li> 
                    <li class="active">
                        <a href="<?php echo base_url() ?>business">
                            <span class="hidden-xs">Businesses</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="all-detail-box-all-jobs-list">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="job-category">
                        <div class="location-box">
                            <ul data-aos="fade-up" data-aos-duration="1000">
                                <li ng-repeat="(inJobsKey, inJobsval) in businessByBusiness">
                                    <h5>{{inJobsKey}}</h5>
                                    <ul>
                                        <li ng-repeat="(byJobKey, byJobVal) in inJobsval">      
                                            <a href="<?php //echo base_url(); ?>{{byJobVal.slug}}" target="_self"> {{byJobVal.name}} </a>
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