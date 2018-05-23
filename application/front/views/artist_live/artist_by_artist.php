<div class="custom-user-list">
    <div class="list-box-custom border-none">
        <div class="">
            <div class="">
                <ul class="nav nav-tabs">
                    <li><a href="<?php echo base_url(); ?>artist/category" data-toggle="tab"><span class="hidden-xs">Artist by</span> Categories</a></li>
                    <li><a href="<?php echo base_url(); ?>artist/location" data-toggle="tab"><span class="hidden-xs">Artist by</span> Location</a></li>
                    <li class="active"><a href="<?php echo base_url(); ?>artist" data-toggle="tab"><span class="hidden-xs">Artist</span></a></li>
                </ul>
            </div>

            <div class="all-detail-box-all-jobs-list">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="artist-category">
                        <div class="location-box">
                            <ul data-aos="fade-up" data-aos-duration="1000">
                                <li ng-repeat="(key, allJobVal) in artistByArtist">
                                    <h4>{{key}}</h4>
                                    <ul>
                                        <li ng-repeat="(byJobKey, byJobVal) in allJobVal">      
                                            <a href="<?php echo base_url(); ?>artist/{{byJobVal.slug}}" target="_self"> {{byJobVal.name}} </a>
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