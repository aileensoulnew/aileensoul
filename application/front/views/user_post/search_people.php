<div class="left-section">
    <div class="search-box">
        <div class="search-left-box">
            <h3>Title</h3>
            <div class="form-group">
                <input type="text" placeholder="Search by Title"> 
            </div>
        </div>
        <div class="search-left-box">
            <h3>Location</h3>
            <div class="form-group">
                <input type="text" placeholder="Search by Location"> 
            </div>
        </div>
        <?php $getFieldList = $this->data_model->getNewFieldList();?>
        <div class="search-left-box">
            <h3>Industry</h3>
            <div class="form-group">
                <span class="span-select">
                    <select placeholder="Search by Industry">
                        <option value="">Select Industry</option>
                        <?php foreach ($getFieldList as $key => $value) { ?>
                            <option value="<?php echo $value['industry_id']; ?>"><?php echo $value['industry_name']; ?></option>
                        <?php } ?>
                    </select>
                </span>
            </div>
        </div>        
        <div class="search-left-box">
            <h3>Gender</h3>
            <div class="form-group">
                <input type="radio" name="gender" placeholder="Search by Hash Tag"> Male
                <input type="radio" name="gender" placeholder="Search by Hash Tag"> Female
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
</div>