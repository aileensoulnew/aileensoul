<div class="left-section">
    <div class="search-box">
        <div class="search-left-box">
            <h3>Title</h3>
            <div class="form-group">                
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
                            <option value="<?php echo $value['industry_id']; ?>"><?php echo $value['industry_name']; ?></option>
                        <?php } ?>
                    </select>
                </span>
            </div>
        </div>
        <div class="search-left-box">
            <h3>Location</h3>
            <div class="form-group">                
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
                <a class="pull-left btn-new-1" ng-click="main_search_function();"><span><img src="<?php echo base_url('assets/n-images/s-s.png'); ?>"></span> Search</a> 
                <a class="pull-right btn-new-1" ng-click="clearData();"><span><img src="<?php echo base_url('assets/n-images/trash.png'); ?>"></span> Clear</a> 
            </div>
        </div>
    </div>    
</div>
<div class="middle-section">
    <div class="availabel-data-box" ng-if="people_data.length != '0'">
        <div class="search-profiles" ng-repeat="people in people_data">
            <div class="profile-img post-img">
                <a href="<?php echo base_url() ?>{{people.user_slug}}">
                    <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{people.user_image}}" alt="{{people.fullname}}" ng-if="people.user_image">                                    
                    <img ng-if="!people.user_image && people.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                    <img ng-if="!people.user_image && people.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                </a>
            </div>
            <div class="profile-data">
                <p><a href="<?php echo base_url() ?>{{people.user_slug}}" ng-bind="people.fullname | capitalize"></a></p>
                <span ng-if="people.degree_name == null && people.title_name != null">{{people.title_name}}</span>
                <span ng-if="people.degree_name != null && people.title_name == null">{{people.degree_name}}</span>
                <span ng-if="people.degree_name == null && people.title_name == null">Current work</span>
                
            </div>
            <div id="contact-btn-{{$index + 1}}" ng-if="people.user_id != user_id" class="profile-btns">
                <a class="btn3" ng-if="people.contact_detail.contact_value == 'new'" ng-click="contact(people.contact_detail.contact_id, 'pending', people.user_id,$index + 1)">Add to contact</a>
                <a class="btn1" ng-if="people.contact_detail.contact_value == 'confirm'" ng-click="contact(people.contact_detail.contact_id, 'cancel', people.user_id,$index + 1,1)">In people</a>
                <a class="btn3" ng-if="people.contact_detail.contact_value == 'pending'" ng-click="contact(people.contact_detail.contact_id, 'cancel', people.user_id,$index + 1)">Request sent</a>
                <a class="btn3" ng-if="people.contact_detail.contact_value == 'cancel'" ng-click="contact(people.contact_detail.contact_id, 'pending', people.user_id,$index + 1)">Add to contact</a>
                <a class="btn3" ng-if="people.contact_detail.contact_value == 'reject'" ng-click="contact(people.contact_detail.contact_id, 'pending', people.user_id,$index + 1)">Add to contact</a>
            </div>
            <div class="modal fade message-box" id="remove-contact-conform-{{$index + 1}}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lm">
                    <div class="modal-content">
                        <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                        <div class="modal-body">
                            <span class="mes">
                                <div class="pop_content">Do you want to remove this contact?<div class="model_ok_cancel"><a class="okbtn" ng-click="remove_contact(people.contact_detail.contact_id, 'cancel', people.user_id,$index + 1)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <div ng-if="total_record == 0 && postData.length == 0" ng-class="total_record == 0 ? 'no-search-data' : ''">
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