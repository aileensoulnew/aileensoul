<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>        
        <?php echo $head; ?>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/1.10.3.jquery-ui.css?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>       
        <?php $this->load->view('adsense'); ?>
    </head>
    <style type="text/css">
        .common-form fieldset select:focus{ 
            border: 1px solid #1b8ab9 !important;
            color: #1b8ab9 !important;
        }
        .edit-pr-custom .change-password-box form{
            border: 1px solid #ddd !important;
            padding: 10px !important;
        }
    </style>
    <!-- start header -->
    <?php echo $header_inner_profile; ?>
    <!-- END HEADER -->
    <body class="change-pw">
        <div id="paddingtop_fixed" class="user-midd-section">
            <div class="container">
                <div class="row">
                    <div class=" ">
                        <div class="col-lg-3 col-md-4 col-sm-4">
                            <div class="">
                                <div class="left-side-bar">
                                    <ul class="left-form-each">
                                        <li><a href="<?php echo base_url('edit-profile');?>">Edit</a></li>
                                        <li><a href="<?php echo base_url('change-password') ?>">Change Password </a></li>
                                        <li <?php if ($this->uri->segment(1) == 'subscribe') { ?> class="active init" <?php } ?>><a href="#">Subscribe</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-8 edit-pr-custom">
                              <div class="common-form">
                            <div class="change-password">
                                <div class="change-password-box">
                                    <h4>Subscribe</h4>
                                    <?php echo form_open('javascript:void(0);', array('id' => 'regform', 'name' => 'regform', 'class' => 'clearfix')); ?>
                                    <fieldset>
                                        <!-- <label>Subscribe</label> -->
                                        <label class="control control--radio">
                                        Subscribe
                                        <input class="gen-male" tabindex="1" type="radio" id="subscribe" name="subscribe" value="1" <?php
                                        if ($userdata['is_subscribe'] == 1) {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <div class="control__indicator"></div>
                                        </label>
                                        <label class="control control--radio">
                                        Unsubscribe
                                        <input type="radio" id="subscribe" tabindex="2" name="subscribe" value="0" <?php
                                        if ($userdata['is_subscribe'] == 0) {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <div class="control__indicator"></div>
                                        </label>
                                        <?php echo form_error('subscribe'); ?>
                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                        <!-- <input type="reset"  value="Cancel" name="cancel"> -->
                                        <input type="button" onclick="submitSubscribeForm();" tabindex="3"  value="Save" name="submit">
                                    </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box addreport" id="unsubscribemodel" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <!-- <button type="button" class="modal-close" data-dismiss="modal">&times;</button> -->
                    <div class="post-popup-box">
                        <div class="post-box">
                            <div class="post-text">
                                <div class="mes"></div>                     
                            </div>
                            <div class="post-box-bottom">
                                <p class="pull-right">
                                    <button type="button" id="close_model" class="btn1" data-dismiss="modal" value="Close">Close</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
  <?php
if(IS_OUTSIDE_JS_MINIFY == '0'){
?>
   <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
<?php } else{ ?>
     <script src="<?php echo base_url('assets/js_min/jquery.validate.min.js?ver='.time()); ?>"></script>
<?php } ?>
<script type="text/javascript" src="<?php  echo base_url('assets/js/additional-methods1.15.0.min.js?ver='.time()); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>       
<!-- validation for edit email formate form strat -->

<script>
var base_url = '<?php echo base_url(); ?>';
var header_all_profile = '<?php echo $header_all_profile; ?>';
function submitSubscribeForm()
{                 
    var subscribe = $("input[name='subscribe']:checked").val();
    $.ajax({
        type: 'POST',
        url: base_url + 'registration/subscribe_update',
        data: {'subscribe':subscribe},
        success: function (result)
        {
            var sub = '';
            if(subscribe == 0)
            {
                sub = "Unsubscribe"
            }
            if (subscribe == 1)
            {
                sub = "Subscribe"
            }
            content = '<div class="pop_content" style="color: #1b8ab9;">'+sub+' successfully.</div>';
            $("#unsubscribemodel .mes").html(content);
            $("#unsubscribemodel").modal('show');
        }
    });
    return false;
}
$('#close_model').click(function () {
    window.location = base_url+'subscribe';
});
</script>
    </body>
</html>
