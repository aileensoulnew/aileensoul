<div class="left-section">
    <div class="search-box">
        <div class="search-left-box">
            <h3>Title</h3>
            <div class="form-group">
                <!-- <input type="text" placeholder="Search by Title"> -->
                <!-- <input type="text" placeholder="Search by Title" id="search_job_title" name="search_job_title" ng-model="search_job_title" ng-keyup="search_job_title_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off" maxlength="200"> -->
                <tags-input id="search_job_title" name="search_job_title" ng-model="search_job_title" display-property="name" placeholder="Search by Title" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()" max-tags="5">
                    <auto-complete source="loadJobTitle($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                </tags-input>
                <div id="jobtitletooltip" class="tooltip-custom" style="display: none;">Type the designation which best matches for given opportunity.</div>
                <script type="text/ng-template" id="title-template">
                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                </script>
                <script type="text/ng-template" id="title-autocomplete-template">
                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                </script>
            </div>
        </div>
        <?php $getFieldList = $this->data_model->getFieldList();?>
        <div class="search-left-box">
            <h3>Industry</h3>
            <div class="form-group">
                <span class="span-select">
                    <select placeholder="Search by Industry" name="search_field" id="search_field" ng-model="search_field">
                        <option value="">Select Industry</option>
                        <?php foreach ($getFieldList as $key => $value) { ?>
                            <option value="<?php echo $value['industry_name']; ?>"><?php echo $value['industry_name']; ?></option>
                        <?php } ?>
                    </select>
                </span>
            </div>
        </div>
        <div class="search-left-box">
            <h3>Location</h3>
            <div class="form-group">
                <!-- <input type="text" placeholder="Search by City"> -->
                <!-- <input type="text" placeholder="Search by City" id="search_city" name="search_city" ng-model="search_city" ng-keyup="search_city_list()" typeahead="item as item.city_name for item in citySearchResult | filter:$viewValue" autocomplete="off" maxlength="200"> -->
                <tags-input id="search_city" ng-model="search_city" name="search_city" display-property="city_name" placeholder="Search by Location" replace-spaces-with-dashes="false" template="location-template" on-tag-added="onKeyup()" max-tags="5">
                    <auto-complete source="loadLocation($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="location-autocomplete-template"></auto-complete>
                </tags-input>
                <div id="locationtooltip" class="tooltip-custom" style="display: none;">Enter a word or two then select the location for the opportunity.</div>
                <script type="text/ng-template" id="location-template">
                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                </script>
                <script type="text/ng-template" id="location-autocomplete-template">
                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                </script>
            </div>            
        </div>        
        <div class="search-left-box">
            <h3>Gender</h3>
            <div class="form-group">
                <input type="radio" name="gender" ng-model="search_gender" placeholder="Search by Hash Tag"> Male
                <input type="radio" name="gender" ng-model="search_gender" placeholder="Search by Hash Tag"> Female
            </div>
        </div>        
        <div class="search-left-box pt15">
            <div class="form-group">
                <a class="pull-left btn-new-1"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search</a> 
                <a class="pull-right btn-new-1"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
            </div>
        </div>
    </div>    
</div>
<div class="middle-section">
    <div class="availabel-data-box" ng-if="searchProfileData.length != '0'">
        <div class="search-profiles" ng-repeat="searchProfile in searchProfileData">
            <div class="profile-img post-img">
                <a href="<?php echo base_url() ?>{{searchProfile.user_slug}}">
                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{searchProfile.user_image}}" alt="{{searchProfile.fullname}}" ng-if="searchProfile.user_image">                                    
                    <img ng-if="!searchProfile.user_image && searchProfile.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                    <img ng-if="!searchProfile.user_image && searchProfile.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                </a>
            </div>
            <div class="profile-data">
                <p><a href="<?php echo base_url() ?>{{searchProfile.user_slug}}" ng-bind="searchProfile.fullname | capitalize"></a></p>
                <span ng-if="searchProfile.degree_name == null && searchProfile.title_name != null">{{searchProfile.title_name}}</span>
                <span ng-if="searchProfile.degree_name != null && searchProfile.title_name == null">{{searchProfile.degree_name}}</span>
                <span ng-if="searchProfile.degree_name == null && searchProfile.title_name == null">Current work</span>
                
            </div>
            <div class="profile-btns" id="{{searchProfile.user_id}}">
                <a ng-if="searchProfile.follow_status == 1" class="btn1 following" ng-click="unfollow_user(searchProfile.user_id)">Following</a>
                <a ng-if="searchProfile.follow_status == 0 || !searchProfile.follow_status" class="btn3 follow" ng-click="follow_user(searchProfile.user_id)">Follow</a>
            </div>
        </div>
    </div>
    <div id="people-loader" class="fw post_loader" style="text-align: center;display: none;z-index: 9;">
        <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
    </div>
</div>