<?php $user_id = $this->session->userdata('aileenuser'); ?>
<div class="container pt15 main-dashboard">
    <div class="analytic-detail fw">
        <div class="big-left">
            <div class="analytic-left-tab">
                <nav class="nav-sidebar">
                    <ul class="nav tabs">
                      <li ng-class="{active: isSet(1)}"><a href="" ng-click="setTab(1)" data-toggle="tab">Home</a></li>
                      <li ng-class="{active: isSet(2)}"><a href="" ng-click="setTab(2)" data-toggle="tab">Point</a></li>
                      <li ng-class="{active: isSet(3)}"><a href="" ng-click="setTab(3)" data-toggle="tab">Bank Details</a></li>
                    </ul>
                </nav>
            </div>
            <div class="tab-content">
                <div class="tab-inner text-style" ng-show="isSet(1)">
                    <h3>Analytics</h3>
                    <div class="ana-tab-box">
                        <div class="point-table p15 fw">
                            <div class="earn-point">
                                <span>Points</span>
                                <span>{{total_points}}</span>
                            </div>
                            <div class="earn-point">
                                <span>Total Earning</span>
                                <span>$ {{total_earn}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div ng-show="isSet(2)">
                    <div class="tab-inner text-style">
                        <h3>Point earning</h3>
                        <div class="ana-tab-box">
                            <p class="pb15">We'll send your payment once your payment threshold is reached</p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-custom" style="width: 0%;">
                                    <span class="skill"><i class="val"></i></span>
                                </div>
                            </div>
                            <div class="fw pb15">
                                <span class="pull-left">$ 0 </span>
                                <span class="pull-right">$ 10 </span>
                            </div>
                            <p class="pb15">Lorem ipsum its a dummy text its use full for all.</p>
                        </div>
                        <div class="ana-tab-box" ng-if="payment_history.length > 0">
                            <table>
                                <tr>
                                    <th>Earning</th>
                                    <th>Status</th>
                                    <th>Threshold Date</th>
                                    <th>Payment Date</th>
                                </tr>
                                <tr ng-repeat="history in payment_history">
                                    <td>${{history.earn_amount}}</td>
                                    <td>{{history.status}}</td>
                                    <td>{{history.modify_date_str}}</td>
                                    <td>{{history.status != 'unpaid' ? history.payment_date_str : '--'}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>                    
                </div>
                <div ng-show="isSet(3)">
                    <div class="tab-inner text-style">
                      <h3>Add Bank Detail</h3>
                      <div class="ana-tab-box">                            
                            <div class="monetize-payment-detail">
                                <form class="pt15 new-form" id="bank_detail" name="bank_detail" ng-submit="submit_bank_info()" ng-validate="bank_info_validate">
                                    <div class="form-group">
                                        <input type="text" id="bank_name" name="bank_name" ng-model="bank_name" placeholder="Enter Bank name" maxlength="200">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="bank_ac_holder_name" name="bank_ac_holder_name" ng-model="bank_ac_holder_name" placeholder="Enter Account Holder name" maxlength="200">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="bank_ac_number" name="bank_ac_number" ng-model="bank_ac_number" placeholder="Enter Account number" maxlength="200">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="bank_ac_re_number" name="bank_ac_re_number" ng-model="bank_ac_re_number" placeholder="Re-enter Account number" maxlength="200">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="bank_ifsc" name="bank_ifsc" ng-model="bank_ifsc" placeholder="Enter Ifsc Code" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="bank_swift" name="bank_swift" ng-model="bank_swift" placeholder="Enter Swift bic" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="country_code" name="country_code" ng-model="country_code" placeholder="Enter country code" maxlength="4">
                                        <input type="text" id="contact_number" name="contact_number" ng-model="contact_number" placeholder="Enter contact number" maxlength="50">
                                    </div>
                                    <div class="form-group text-center">
                                        <!-- <a href="" class="btn-new-3" ng-click="add_bank_detail();">Submit</a> -->
                                        <button type="submit" id="submit" class="btn-new-3">Submit<span class="ajax_load" id="bank_info_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                    </div>
                                    <label id="success-bankinfo"></label>
                                </form>
                            </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-section">
            <div id="right-fixed" class="fw">
                <div class="right-add-box">
                </div>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade message-box biderror post-error" id="posterrormodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="posterror-modal-close modal-close" data-dismiss="modal">&times;
            </button>       
            <div class="modal-body">
                <span class="mes"></span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade message-box post-error" id="post" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <button type="button" class="modal-close" id="post" data-dismiss="modal">&times;</button>       
            <div class="modal-body">
                <span class="mes"></span>
            </div>
        </div>
    </div>
</div>