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
                           Businesses
                        </a>
                    </li>
                </ul>
            </div>

            <div class="all-jobs-list">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="job-category">
                        <div class="location-box">
                            <ul class="art-bus-cus" >
                                <li ng-repeat="(key, allJobVal) in businessByBusiness">
                                    <h4>{{key}}</h4>
                                    <ul class="art-bus-all">
                                        <!-- <li ng-repeat="(inJobsKey, inJobsval) in allJobVal"> -->
                                            <!-- <ul> -->
                                                <li ng-repeat="(byJobKey, byJobVal) in allJobVal">      
                                                    <a href="<?php //echo base_url(); ?>{{byJobVal.slug}}" target="_self"> {{byJobVal.name}} </a>
                                                </li>
                                            <!-- </ul> -->
                                        <!-- </li> -->
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
    <?php echo $right_profile_view; ?>
</div>