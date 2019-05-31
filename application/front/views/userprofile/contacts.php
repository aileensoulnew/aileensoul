<div class="pt20 fw">
<div class="container mobp0 contacts-page">
    <div class="custom-user-list">
		<div class="tab-add-991 ads">
            <?php
            $data['data'] = 'ads';
            $this->load->view('ads_box',$data); ?>
		</div>
        <div class="list-box-custom">
            <h3 class="mob-border-top-1">Contacts </h3>
            <div class="list-cus fw mobp0" id="nocontact">
              <!--   <input name="page_number" class="page_number"  ng-model="page_number" ng-value="pagecntctData.pagedata.page">
                <input name="total_record" class="total_record"  ng-model="total_record" ng-value="pagecntctData.pagedata.total_record">
                <input name="perpage_record" class="perpage_record"  ng-model="perpage_record" ng-value="pagecntctData.pagedata.perpage_record"> -->

                <div class="custom-user-box" ng-if="contats_data != '0'" ng-repeat="contacts in contactData">
                   
                    <div class="post-img" ng-if="contacts.user_image != '' && contacts.user_image != null">
                        <a href="<?php echo base_url();?>{{contacts.user_slug}}" target="_self">
                            <img ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{contacts.user_image}}">
                        </a>
                    </div>
                    <div class="post-img" ng-if="contacts.user_image == '' || contacts.user_image == null">
                        <a href="<?php echo base_url();?>{{contacts.user_slug}}" target="_self">
                            <img ng-if="contacts.user_gender == 'M'" ng-src="<?php echo base_url('assets/img/man-user.jpg') ?>">
                            <img ng-if="contacts.user_gender == 'F'" ng-src="<?php echo base_url('assets/img/female-user.jpg') ?>">
                        </a>
                    </div>
                    <div class="custom-user-detail">
                        <h4>
                            <a href="<?php echo base_url();?>{{contacts.user_slug}}" target="_self" ng-bind="(contacts.first_name | limitTo:1 | uppercase) + (contacts.first_name.substr(1) | lowercase) + ' ' + (contacts.last_name | limitTo:1 |uppercase) + (contacts.last_name.substr(1) | lowercase)"></a>
                        </h4>
                        <p ng-if="contacts.title_name != null && contacts.degree_name == null">{{contacts.title_name}}</p>
                        <p ng-if="contacts.degree_name != null && contacts.title_name == null">{{contacts.degree_name}}</p>
                        <p ng-if="contacts.degree_name == null && contacts.title_name == null">Current work</p>
                    </div>
                    <div id="contact-btn-{{$index + 1}}" ng-if="contacts.user_id != user_id" class="custom-user-btn">

                        <!-- <a class="btn3" id="{{contacts.user_id}}" ng-click="remove(contacts.user_id)">In Contacts</a> -->

                        <a class="btn3" ng-if="contacts.contact_detail.contact_value == 'new'" ng-click="contact(contacts.contact_detail.contact_id, 'pending', contacts.user_id,$index + 1)">Add to contact</a>
                        <a class="btn1" ng-if="contacts.contact_detail.contact_value == 'confirm'" ng-click="contact(contacts.contact_detail.contact_id, 'cancel', contacts.user_id,$index + 1,1)">In Contacts</a>
                        <a class="btn3" ng-if="contacts.contact_detail.contact_value == 'pending'" ng-click="contact(contacts.contact_detail.contact_id, 'cancel', contacts.user_id,$index + 1)">Request sent</a>
                        <a class="btn3" ng-if="contacts.contact_detail.contact_value == 'cancel'" ng-click="contact(contacts.contact_detail.contact_id, 'pending', contacts.user_id,$index + 1)">Add to contact</a>
                        <a class="btn3" ng-if="contacts.contact_detail.contact_value == 'reject'" ng-click="contact(contacts.contact_detail.contact_id, 'pending', contacts.user_id,$index + 1)">Add to contact</a>
                    </div>
                    <div class="modal fade message-box" id="remove-contact-conform-{{$index + 1}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lm">
                            <div class="modal-content">
                                <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                                <div class="modal-body">
                                    <span class="mes">
                                        <div class="pop_content">Do you want to remove this contact?<div class="model_ok_cancel"><a class="okbtn" ng-click="remove_contact(contacts.contact_detail.contact_id, 'cancel', contacts.user_id,$index + 1)" href="javascript:void(0);" data-dismiss="modal">Yes</a><a class="cnclbtn" href="javascript:void(0);" data-dismiss="modal">No</a></div></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fw post_loader loadmore" style="text-align:center; display: none;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>

                <div class="custom-user-box no-data-available"  ng-if="pagecntctData.pagedata.total_record == '0'">
                    <div class='art-img-nn'>
                        <div class='art_no_post_img'>
                            <img src="<?php echo base_url('assets/img/no-contact.png'); ?>" alt="No Contacts">
                        </div>
                        <div class='art_no_post_text'>No Contacts Available. </div>

                    </div>
                </div>
            </div>
        </div>
		<div class="tab-add ads">
            <?php
            $data['data'] = 'ads';
            $this->load->view('ads_box',$data); ?>
		</div>
    </div>
    <div class="right-add">
        <?php $this->load->view('right_add_box'); ?>
    </div>
</div>
</div>