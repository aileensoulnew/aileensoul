<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="utf-8">
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">  
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dragdrop/fileinput.css'); ?>">
        <link href="<?php echo base_url('assets/dragdrop/themes/explorer/theme.css') ?>" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/as-videoplayer/build/mediaelementplayer.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/ng-tags-input.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
        <!-- <link rel="stylesheet" type="text/css" href="<?php //echo base_url('assets/n-css/angular-tooltips.css') ?>"> -->
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js') ?>"></script>        
    <?php $this->load->view('adsense'); ?>    
</head>
    <body class="one-hd body-loader" onload="verifymail();">
        <?php $this->load->view('page_loader'); ?>
        <!-- Model Popup Start -->
        <div class="modal fade message-box biderror" id="mailmodal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lm">
                <div class="modal-content message">
                    <div class="modal-body">
                        <span class="mes">
                            <div class="msg"></div>
                            <div class="pop_content">
                                <div class="model_ok_cancel">
                                    <a class="btn1" id="okbtn" href="javascript:void(0);" data-dismiss="modal" title="OK">OK</a>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup End -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.form.3.51.js') ?>"></script> 
        <script src="<?php echo base_url('assets/dragdrop/js/plugins/sortable.js') ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/fileinput.js') ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/fr.js') ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/js/locales/es.js') ?>"></script>
        <script src="<?php echo base_url('assets/dragdrop/themes/explorer/theme.js') ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/build/mediaelement-and-player.js'); ?>"></script>
        <script src="<?php echo base_url('assets/as-videoplayer/demo.js'); ?>"></script>        
        <script>
        var base_url = '<?php echo base_url(); ?>';
        /*var slug = '<?php //echo $slugid; ?>';*/
        var id = '<?php echo $id; ?>';
        function verifymail() {        
            var post_data = {
                'id': id,
            }
            $.ajax({
                type: 'POST',
                url: base_url + 'registration/verifying',
                data: post_data,
                dataType:'json',
                success: function (response)
                {
                    if(response.success == '1')
                    {
                        window.location = base_url + response.user_slug;
                        /*$("#mailmodal .msg").html('Please verify your email address!<br />Check your inbox or spam folder in order to verify yourself.');
                        $("#mailmodal").modal("show");*/
                    }
                    else
                    {
                        window.location = base_url;
                        /*$("#mailmodal .msg").html('Please try again later.');
                        $("#mailmodal").modal("show");*/
                    }
                }
            });
        }
        </script>
        <script src="<?php echo base_url('assets/js/classie.js') ?>"></script>       
    </body>
</html>