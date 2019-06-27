<div class="mob-search-btn">
    <a data-toggle="modal" id="showBottom">
        <span><img src="<?php echo base_url('assets/n-images/filter.png');?>"></span> 
    </a>
</div>
<div class="left-section filter-fix">
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
                <span class="span-select select-cus">
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
            <div class="form-group search-gender">
                <label class="control control--radio">
                    Male
                    <input type="radio" value="M" name="gender" ng-model="search_gender" placeholder="Search by Hash Tag">
                    <div class="control__indicator"></div>
                </label>
                <label class="control control--radio">
                    Female
                    <input type="radio" value="F" name="gender" ng-model="search_gender" placeholder="Search by Hash Tag">
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>        
        <div class="search-left-box pt15">
            <div class="form-group">
                <a class="pull-left btn-new-1" ng-click="main_search_function();"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search
                    <img id="search-loader" ng-src="<?php echo base_url('assets/images/loader.gif');?>" alt="Loader" style="width: 20px;display: none;"/>
                </a> 
                <a class="pull-right btn-new-1" ng-click="clearData(0);"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
            </div>
        </div>
    </div>    
</div>
<div class="middle-section">
    <div ng-if="searchProfileData.length != 0">
        <div class="availabel-data-box">
            <div class="search-profiles" ng-repeat="searchProfile in searchProfileData">
                <div id="people_tooltip_content_{{$index}}" class="tooltip_templates">
                    <div class="user-tooltip">
                        <div class="tooltip-cover-img">
                            <img ng-if="searchProfile.profile_background != null && searchProfile.profile_background != ''" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL; ?>{{searchProfile.profile_background}}">                                        
                            <div ng-if="searchProfile.profile_background == null || searchProfile.profile_background == ''" class="gradient-bg" style="height: 100%"></div>
                        </div>
                        <div class="tooltip-user-detail">
                            <div class="tooltip-user-img">
                                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{searchProfile.user_image}}" ng-if="searchProfile.user_image != ''">

                                <img ng-class="searchProfile.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="searchProfile.user_image == '' && searchProfile.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">

                                <img ng-class="searchProfile.user_id == user_id ? 'login-user-pro-pic' : ''" ng-if="searchProfile.user_image == '' && searchProfile.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">

                            </div>

                            <h4 ng-bind="searchProfile.fullname | capitalize"></h4>

                            <p ng-if="searchProfile.title_name != null && searchProfile.degree_name == null">{{searchProfile.title_name.length < 30 ? searchProfile.title_name : ((searchProfile.title_name | limitTo:30)+'...') }}</p>
                            <p ng-if="searchProfile.title_name == null && searchProfile.degree_name != null">{{searchProfile.degree_name.length < 30 ? searchProfile.degree_name : ((searchProfile.degree_name | limitTo:30)+'...') }}</p>
                            <p ng-if="searchProfile.title_name == null && searchProfile.degree_name == null">Current Work</p>
                            <p ng-if="searchProfile.post_count != '' || searchProfile.contact_count != '' || searchProfile.follower_count != ''">
                                <span ng-if="searchProfile.post_count != ''"><b>{{searchProfile.post_count}}</b> Posts</span>
                                <span ng-if="searchProfile.contact_count != ''"><b>{{searchProfile.contact_count}}</b> Contacts</span>
                                <span ng-if="searchProfile.follower_count != ''"><b>{{searchProfile.follower_count}}</b> Followers</span>
                            </p>

                            <ul class="" ng-if="searchProfile.mutual_friend.length > 0">
                                <li ng-if="user_id != searchProfile.user_id" ng-repeat="_friend in searchProfile.mutual_friend | limitTo:2">
                                    <div class="user-img">
                                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{_friend.user_image}}" ng-if="_friend.user_image != ''">

                                        <img ng-if="_friend.user_image == '' && _friend.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">

                                        <img ng-if="_friend.user_image == '' && _friend.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                                    </div>
                                </li>                            
                                <li ng-if="user_id != searchProfile.user_id" class="m-contacts">
                                    <span ng-if="searchProfile.mutual_friend.length == 1">
                                        <b>{{searchProfile.mutual_friend[0].fullname}}</b> is in mutual contact.
                                    </span>
                                    <span ng-if="searchProfile.mutual_friend.length > 1">
                                        <b>{{searchProfile.mutual_friend[0].fullname}}</b>{{searchProfile.mutual_friend.length - 1 > 0 ? ' and ' : ''}}<b>{{searchProfile.mutual_friend.length - 1}}</b> more mutual contacts.
                                    </span>
                                </li>
                            </ul>
                            <div class="tooltip-btns" ng-if="user_id != searchProfile.user_id">
                                <ul>
                                    <li class="contact-btn-{{searchProfile.user_id}}">
                                        <a class="btn-new-1" ng-if="searchProfile.contact_status == 'new' || searchProfile.contact_status == null" data-param="{{searchProfile.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ searchProfile.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{searchProfile.user_id}}">Add to contact</a>
                                        
                                        <a class="btn-new-1" ng-if="searchProfile.contact_status == 'confirm'" data-param="{{searchProfile.contact_id}}{{ today | date : 'hhmmss'}},cancel,{{ searchProfile.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},1" onclick="contact(this.id);" id="contact_btn_{{searchProfile.user_id}}">In Contacts</a>
                                        
                                        <a class="btn-new-1" ng-if="searchProfile.contact_status == 'pending'" data-param="{{searchProfile.contact_id}}{{ today | date : 'hhmmss'}},cancel,{{ searchProfile.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{searchProfile.user_id}}">Request sent</a>
                                        
                                        <a class="btn-new-1" ng-if="searchProfile.contact_status == 'cancel'" data-param="{{searchProfile.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ searchProfile.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{searchProfile.user_id}}">Add to contact</a>
                                        
                                        <a class="btn-new-1" ng-if="searchProfile.contact_status == 'reject'" data-param="{{searchProfile.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ searchProfile.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{searchProfile.user_id}}">Add to contact</a>
                                    </li>
                                    <li class="follow-btn-user-{{searchProfile.user_id}}">
                                        <a ng-if="searchProfile.follow_status == 1" class="btn-new-1 following" data-uid="{{searchProfile.user_id}}{{ today | date : 'hhmmss'}}" onclick="unfollow_user(this.id)" id="follow_btn_people_{{searchProfile.user_id}}">Following</a>

                                        <a ng-if="searchProfile.follow_status == 0 || !searchProfile.follow_status" class="btn-new-1 follow" data-uid="{{searchProfile.user_id}}{{ today| date : 'hhmmss'}}" onclick="follow_user(this.id)" id="follow_btn_people_{{searchProfile.user_id}}">Follow</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo MESSAGE_URL; ?>user/{{searchProfile.user_slug}}" class="btn-new-1" target="_blank">Message</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-img post-img">
                    <a href="<?php echo base_url() ?>{{searchProfile.user_slug}}" target="_self" data-toggle="popover" data-tooltip-content="#people_tooltip_content_{{$index}}">
                        <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{searchProfile.user_image}}" alt="{{searchProfile.fullname}}" ng-if="searchProfile.user_image">
                        <img ng-if="!searchProfile.user_image && searchProfile.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                        <img ng-if="!searchProfile.user_image && searchProfile.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                    </a>
                </div>
                <div class="profile-data">
                    <p><a href="<?php echo base_url() ?>{{searchProfile.user_slug}}" ng-bind="searchProfile.fullname | capitalize" target="_self" data-toggle="popover" data-tooltip-content="#people_tooltip_content_{{$index}}"></a></p>
                    <span ng-if="searchProfile.degree_name == null && searchProfile.title_name != null">{{searchProfile.title_name.length < 30 ? searchProfile.title_name : ((searchProfile.title_name | limitTo:30)+'...') }}</span>
                    <span ng-if="searchProfile.degree_name != null && searchProfile.title_name == null">{{searchProfile.degree_name.length < 30 ? searchProfile.degree_name : ((searchProfile.degree_name | limitTo:30)+'...') }}</span>
                    <span ng-if="searchProfile.degree_name == null && searchProfile.title_name == null">Current work</span>
                    
                </div>
                <div class="profile-btns follow-btn-user-{{searchProfile.user_id}}" id="{{searchProfile.user_id}}">
                    <a ng-if="searchProfile.follow_status == 1" class="btn-new-1 following" data-uid="{{searchProfile.user_id}}{{ today | date : 'hhmmss'}}" onclick="unfollow_user(this.id)" id="follow_btn_people_{{searchProfile.user_id}}">Following</a>
                    <a ng-if="searchProfile.follow_status == 0 || !searchProfile.follow_status" class="btn-new-1 follow" data-uid="{{searchProfile.user_id}}{{ today| date : 'hhmmss'}}" onclick="follow_user(this.id)" id="follow_btn_people_{{searchProfile.user_id}}">Follow</a>
                    <!-- <a ng-if="searchProfile.follow_status == 1" class="btn1 following" ng-click="unfollow_user(searchProfile.user_id)">Following</a>
                    <a ng-if="searchProfile.follow_status == 0 || !searchProfile.follow_status" class="btn3 follow" ng-click="follow_user(searchProfile.user_id)">Follow</a> -->
                </div>
            </div>
        </div>
    </div>
    <div ng-if="total_record == 0" ng-class="total_record == 0 ? 'no-search-data' : ''">
        <div class="custom-user-box no-data-available">
            <div class='art-img-nn'>
                <div class='art_no_post_img'>
                    <img src="<?php echo base_url('assets/img/no-post.png'); ?>" alt="No People">
                </div>
                <div class='art_no_post_text'>No People Available. </div>
            </div>
        </div>
    </div>
    <div id="people-loader" class="fw post_loader" style="text-align: center;display: none;z-index: 9;">
        <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
    </div>
</div>
<div class="search-box">
    <nav class="cbp-spmenu cbp-spmenu-horizontal cbp-spmenu-bottom" id="cbp-spmenu-s4">
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
                <span class="span-select select-cus">
                    <select placeholder="Search by Industry" name="search_field" id="search_field_mob" ng-model="search_field">
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
            <div class="form-group search-gender">
                <label class="control control--radio">
                    Male
                    <input type="radio" value="M" name="gender" ng-model="search_gender" placeholder="Search by Hash Tag">
                    <div class="control__indicator"></div>
                </label>
                <label class="control control--radio">
                    Female
                    <input type="radio" value="F" name="gender" ng-model="search_gender" placeholder="Search by Hash Tag">
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>        
        <div class="search-left-box pt15">
            <div class="form-group">
                <a class="pull-left btn-new-1" ng-click="main_search_function();"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search
                    <img id="search-loader" ng-src="<?php echo base_url('assets/images/loader.gif');?>" alt="Loader" style="width: 20px;display: none;"/>
                </a> 
                <a class="pull-right btn-new-1" ng-click="clearData(1);"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
            </div>
        </div>
    </nav>
</div>
<script type="text/javascript">
    $('#search_field').select2({
        placeholder: 'Search by Industry',
        dropdownParent: $('.select-cus')
    });
</script>
<script>
    var menuBottom = document.getElementById( 'cbp-spmenu-s4' ),
    showBottom = document.getElementById( 'showBottom' ),
    body = document.body;

    showBottom.onclick = function() {
        classie.toggle( this, 'active' );
        classie.toggle( menuBottom, 'cbp-spmenu-open' );
        disableOther( 'showBottom' );
    };

    function disableOther( button ) {
        if( button !== 'showBottom' ) {
            classie.toggle( showBottom, 'disabled' );
        }
    }

    // mcustom scroll bar
    (function($){
        $(window).on("load",function(){
            $(".custom-scroll").mCustomScrollbar({
                autoHideScrollbar:true,
                theme:"minimal"
            });
        });
    })(jQuery);
</script>