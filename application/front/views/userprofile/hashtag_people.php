<div class="availabel-data-box">
    <div ng-if="peopleData.length != '0'">
    <div class="search-profiles" ng-repeat="people in peopleData">
        <div class="profile-img post-img">
            <a href="<?php echo base_url() ?>{{people.user_slug}}" target="_self" data-popover data-uid="{{people.user_id}}" data-utype="1">
                <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{people.user_image}}" alt="{{people.fullname}}" ng-if="people.user_image">                                    
                <img ng-if="!people.user_image && people.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                <img ng-if="!people.user_image && people.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
            </a>
        </div>
        <div class="profile-data">
            <p><a href="<?php echo base_url() ?>{{people.user_slug}}" ng-bind="people.fullname | capitalize" target="_self" data-popover data-uid="{{people.user_id}}" data-utype="1"></a></p>
            <span ng-if="people.degree_name == null && people.title_name != null">{{people.title_name.length < 30 ? people.title_name : ((people.title_name | limitTo:30)+'...') }}</span>
            <span ng-if="people.degree_name != null && people.title_name == null">{{people.degree_name.length < 30 ? people.degree_name : ((people.degree_name | limitTo:30)+'...') }}</span>
            <span ng-if="people.degree_name == null && people.title_name == null">Current work</span>
            
        </div>
        <div id="contact-btn-{{$index + 1}}" ng-if="people.user_id != user_id" class="profile-btns contact-btn-{{people.user_id}}">
            <a class="btn-new-1" ng-if="people.contact_detail.contact_value == 'new'" data-param="{{people.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ people.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{people.user_id}}">Add to contact</a>
                                
            <a class="btn-new-1" ng-if="people.contact_detail.contact_value == 'confirm'" data-param="{{people.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},cancel,{{ people.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},1" onclick="contact(this.id);" id="contact_btn_{{people.user_id}}">In Contacts</a>
            
            <a class="btn-new-1" ng-if="people.contact_detail.contact_value == 'pending'" data-param="{{people.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},cancel,{{ people.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{people.user_id}}">Request sent</a>
            
            <a class="btn-new-1" ng-if="people.contact_detail.contact_value == 'cancel'" data-param="{{people.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ people.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{people.user_id}}">Add to contact</a>
            
            <a class="btn-new-1" ng-if="people.contact_detail.contact_value == 'reject'" data-param="{{people.contact_detail.contact_id}}{{ today | date : 'hhmmss'}},pending,{{ people.user_id}}{{ today | date : 'hhmmss'}},{{$index + 1}}{{ today | date : 'hhmmss'}},0" onclick="contact(this.id);" id="contact_btn_{{people.user_id}}">Add to contact</a>
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
    <div ng-if="total_record == 0" ng-class="total_record == 0 ? 'no-search-data' : ''">
        <div class="custom-user-box no-data-available">
            <div class='art-img-nn'>
                <div class='art_no_post_img'>
                    <img src="<?php echo base_url('assets/img/no-contact.png'); ?>" alt="No People">
                </div>
                <div class='art_no_post_text'>No People Available. </div>
            </div>
        </div>
    </div>
    <div id="people-loader" class="fw post_loader" style="text-align: center;display: none;z-index: 9;">
        <img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
    </div>
</div>