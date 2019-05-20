<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>        
        <?php echo $head; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <?php $this->load->view('adsense'); ?>
    </head>
    <style type="text/css">
          .common-form fieldset select:focus{ border: 1px solid #1b8ab9 !important;color: #1b8ab9 !important;}
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
                                        <li>
                                            <a href="<?php echo base_url() . 'edit-profile' ?>">Edit</a>
                                        </li>
                                        <li  <?php if ($this->uri->segment(1) == 'change-password') { ?> class="active init" <?php } ?>> <a href="<?php echo base_url('change-password') ?>">Change Password </a></li>
                                        <li> <a href="<?php echo base_url('subscribe') ?>">Subscribe</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-8">
                              <div class="common-form">
                            <div class="change-password">
                                <div class="change-password-box">
                                    <h4>Change Password</h4>
                                    <?php echo form_open(base_url('registration/changepassword_insert'), array('id' => 'regform', 'name' => 'regform', 'class' => 'clearfix')); ?>
                                    <fieldset class="full-width">
                                        <label>Old Password <span style="color:red">*</span></label>
                                        <input tabindex="1" type="password" name="oldpassword"  id="oldpassword" placeholder="Old Password" /> <span id="password1-error"> </span>
                                        <?php
                                        if (isset($error_message1)) {
                                            echo $error_message1;
                                        }
                                        echo form_error('oldpassword');
                                        ?>
                                    </fieldset>
                                    <fieldset class="full-width">
                                        <label>New Password <span style="color:red">*</span></label>
                                        <input type="password" tabindex="2" name="password1"  id="password1" placeholder="New Password" /> <span id="password1-error"> </span>
                                        <?php echo form_error('password1'); ?>
                                    </fieldset>
                                    <fieldset class="full-width">
                                        <label>Confirm Password<span style="color:red">*</span></label>
                                        <input type="password" tabindex="3" name="password2"  id="password2" placeholder="Confirm Password" /> <span id="password2-error"> </span>
                                        <?php echo form_error('password2'); ?>
                                    </fieldset>
                                    <fieldset class="hs-submit full-width">
                                        <!-- <input type="reset"  value="Cancel" name="cancel"> -->
                                        <input type="submit" tabindex="4"  value="Save" name="submit">
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
        <?php echo $login_footer ?>
        <?php echo $footer; ?>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php  echo base_url('assets/js/additional-methods1.15.0.min.js?ver='.time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>

        <script>
            $(document).ready(function () { 
                $.validator.addMethod( "notEqualTo", function( value, element, param ) {
                    return this.optional( element ) || !$.validator.methods.equalTo.call( this, value, element, param );
                }, "The entered password should be different than the old one." );

                $("#regform").validate({ 
                    rules: {
                        oldpassword: {
                            required: true,
                            remote: {
                                url: "<?php echo site_url() . 'registration/check_password' ?>",
                                type: "post",
                                data: { oldpassword: function () { return $("#oldpassword").val(); },
                                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                },
                            },

                        },
                        password1: {
                            required: true,
                            notEqualTo: "#oldpassword"
                        },
                        password2: {
                            required: true,
                            equalTo: "#password1",
                            notEqualTo: "#oldpassword"
                        }
                    },

                    messages:
                    {
                        oldpassword: {
                            required: "Please enter old password",
                            remote: "Old password does not match"
                        },
                        password1: {
                            required: "Please enter new password",
                        },
                        password2: {
                            required: "Please enter confirm password",
                            equalTo: "Please enter the same password as above"
                        },
                    },    
                }); 
            });
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>
        <script src="http://chat.aileensoul.localhost/socket.io/socket.io.js"></script>
        <script type="text/javascript">
            var socket = io.connect('http://chat.aileensoul.localhost:3000/');
        </script>
        <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
    </body>
</html>
