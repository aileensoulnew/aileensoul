<header>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 left-header col-xs-4 fw-479 ">
                <?php $this->load->view('main_logo'); ?>
            </div>
            <div class="col-md-6 col-sm-6 right-header col-xs-8 fw-479">
                <div class="btn-right">

                    <?php if(!$this->session->userdata('aileenuser')) {?>
                    <a title="Login" href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                    <a title="Creat an account" href="<?php echo base_url('registration'); ?>" class="btn3">Creat an account</a>

                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</header>