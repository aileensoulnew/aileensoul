<?php $user_id = $this->session->userdata('aileenuser'); ?>
<div class="container pt15 main-dashboard">
    <div class="analytic-detail fw">
        <div class="big-left">
            <div class="analytic-left-tab">
                <nav class="nav-sidebar">
                    <ul class="nav tabs">
                      <li class="active"><a href="#tab1" data-toggle="tab">Home</a></li>
                      <li class=""><a href="#tab2" data-toggle="tab">Point</a></li>
                      <li class=""><a href="#tab3" data-toggle="tab">Payment</a></li>                               
                    </ul>
                </nav>
            </div>
            <div class="tab-content">
                <div class="tab-pane active text-style" id="tab1">
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
                <div class="tab-pane text-style" id="tab2">
                    <h3>Point earning</h3>
                    <div class="ana-tab-box">
                        <p class="pb15">We'll send your payment once your payment threshold is reached</p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-custom" style="width: 20%;">
                                <span class="skill"><i class="val">20%</i></span>
                            </div>
                        </div>
                        <div class="fw pb15">
                            <span class="pull-left">$ 0 </span>
                            <span class="pull-right">$ 10 </span>
                        </div>
                        <p class="pb15">Lorem ipsum its a dummy text its use full for all.</p>
                    </div>
                </div>
                <div class="tab-pane text-style" id="tab3">
                  <h3>Add Bank Detail</h3>
                  <div class="ana-tab-box">
                        <div class="text-center">
                            <a href="" class="btn-new-3">Add payment method</a>
                        </div>
                        <form class="pt15 new-form">
                            <div class="form-group">
                                <input type="text" placeholder="Enter Bank name">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Enter Account name">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Enter Account number">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Re-enter Account number">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Enter Ifsc Code">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Enter Swift bic">
                            </div>
                            <div class="form-group text-center">
                                <a href="" class="btn-new-3">Submit</a>
                            </div>
                        </form>
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