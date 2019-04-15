<?php $user_id = $this->session->userdata('aileenuser'); ?>
<div class="container pt15 main-dashboard">
    <div class="left-part">
		<div class="box-border p5">
            <div class="save-left-box">
                <span>Monetization Analytics</span>
                <img src="<?php echo base_url('assets/n-images/post-it.png') ?>">                
            </div>
        </div>
        <?php echo $left_footer_list_view; ?>
    </div>

        <div class="middle-part">
            
			<div class="tab-add">
				<?php $this->load->view('infeed_add'); ?>
			</div>
            <div class="box-border">
                <div>
                    <span>{{total_points}}</span>
                    <span>Points</span>
                </div>
                <div>
                    <span>$</span>
                    <span>{{total_earn}}</span>
                </div>
            </div>
			
            <div class="fw" id="loader" style="text-align:center; display: none;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>
        </div>
        <div class="right-part">
            <?php $this->load->view('right_add_box'); ?>
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