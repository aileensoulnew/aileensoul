<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="utf-8">
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <link rel="dns-prefetch" href="https://www.aileensoul.com/">
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
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/developer.css') ?>">
        <!-- <link rel="stylesheet" type="text/css" href="<?php //echo base_url('assets/n-css/angular-tooltips.css') ?>"> -->
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js') ?>"></script>
        
        <?php $this->load->view('adsense');
        $user_id = $this->session->userdata('aileenuser');        
        ?>
    </head>
    <body class="one-hd">    
    <div id="main_page_load">
        <?php echo $header_profile; ?>        
        <div class="main-section">
            <div class="container">            	
                <div class="big-left">
                    <div class="monetize-box">
                        <h1>Monetize Aileensoul Account</h1>
                        <div class="monetize-detail">
                            <div class="monetize-detail-sec">
                                <h2>How to monetize your account?</h2>
                                <ul>
                                    <li>To monetize your account you have to put creative and unique content, points will be rewarded for it.</li>
                                    <li>We will pay 10 dollars for 1000 Points. Once you have reached 1000 Points we will review your account and if you are eligible then we will put an advertisement in your content and you can earn money through clicks and views. The revenue will be split 50:50.</li>
                                    <li>You will continue to receive 10 dollars for every 1000 Points.</li>
                                </ul>
                            </div>
                            <div class="monetize-detail-sec">
                                <h2>Eligibility to Monetize</h2>
                                <ul>
                                    <li>You have to attain 1000 Points.</li>
                                    <li>All the content should be creative, helpful and original. (Plagiarized content will not receive any point)</li>
                                </ul>
                            </div>
                            <div class="monetize-detail-sec">
                                <h2>Payment</h2>
                                <ul>
                                    <li>Share bank details with us.</li>
                                    <li>you will get payment of advertisement on 1 to 10 date of next month after you reach the minimum earning of 100 dollars.</li>
                                    <li>you will get payment of points within 15 days after you reach every 1000 point.</li>
                                </ul>
                            </div>
                            <div class="monetize-detail-sec last-sec">
                                <h2>Points distribution </h2>
                                <ul class="monetize-point">
                                    <li><b>50 points</b>  -  Post opportunity
                                        <p>Opportunity should be for anyone. (example job seekers, freelancers, doctors, CEOs, entrepreneurs, plumbers, artists, photographers, cooks, etc.) ....<a data-toggle="modal" href="#" data-target="#opp-point"> Learn more.</a></p> 
                                    </li>
                                    <li><b>30 points</b>  -  Post video 
                                        <p>All types of videos acceptable. ( Example: Informative Videos, Learning Videos, Entertainment Videos..).... <a data-toggle="modal" href="#" data-target="#video-point">Learn more.</a></p>
                                    </li>
                                    <li><b>30 ponts</b>  -  Post article
                                        <p>All types of article acceptable. ( Example: Informative Articles, Learning Articles..).... <a data-toggle="modal" href="#" data-target="#article-point">Learn more.</a></p>
                                    </li>
                                    <li><b>20 points</b>  -  Give answer
                                        <p>Answers should be helpful for users.... <a data-toggle="modal" href="#" data-target="#ans-point">Learn more.</a></p>
                                    </li>
                                    <li><b>5 points</b>  -  Ask question
                                        <p>All types of questions are acceptable.... <a data-toggle="modal" href="#" data-target="#qus-point">Learn more.</a></p>
                                    </li>
                                    <li><b>5 points</b>  -  Post photo
                                        <p>All types of photos acceptable. ( Example: Informative Photos, Learning Photos, Not selfie...).... <a data-toggle="modal" href="#" data-target="#photo-point">Learn more.</a></p>
                                    </li>
                                </ul>
                                <p class="pt20">All content should be creative, helpful and original. There should be no copyright issues in your content. If there will be we will permanently delete your account anytime.</p>
                                <p class="t-n-c">(<span class="error">*</span>We will keep reviewing the content and if it is found inappropriate or not in accordance with our terms than Aileensoul will hold the right to deduct points or not reward any points for the same.)</p>
                            </div>
                            <?php                             
                            if($is_user_monetize == 0){ ?>
                            <form id="monetize_user" name="monetize_user" action="javascript:void(0);" method="POST">
                                <div class="monetize-term-cond">
                                    <label id="lbl_term_condi" class="control control--checkbox" for="term_condi">
                                        <input type="checkbox" name="term_condi" id="term_condi" value="1">Above all are our terms and conditions. Agree to our terms and condition to monetize your account.
                                        <div class="control__indicator"></div>
                                    </label>
                                    <p class="pt20">
                                        <?php
                                        if(isset($userdata) && !empty($userdata)){
                                        ?>
                                            <button type="submit" onclick="new_monetize();" class="btn-new-3">Start Monetize Account</button>
                                        <?php
                                        }
                                        else{ ?>
                                            <a href="<?php echo base_url('registration') ?>" class="btn-new-3">Start Monetize Account</a>
                                        <?php
                                        } ?>
                                    </p>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            	<div class="right-section">
                    <?php $this->load->view('right_add_box'); ?>
            	</div>
            </div>    	
        </div>    	
    </div>
    <!--  poup modal  -->
        <div style="display:none;" class="modal fade monetize-popup" id="opp-point" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="mo-popup">
                        <div class="">
                            <img src="<?php echo base_url('assets/n-images/op-point.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade monetize-popup" id="video-point" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="mo-popup">
                        <div class="">
                            <img src="<?php echo base_url('assets/n-images/video-point.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade monetize-popup" id="article-point" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="mo-popup">
                        <div class="">
                            <img src="<?php echo base_url('assets/n-images/article-point.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade monetize-popup" id="ans-point" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="mo-popup">
                        <div class="">
                            <img src="<?php echo base_url('assets/n-images/ans-point.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade monetize-popup" id="qus-point" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="mo-popup">
                        <div class="">
                            <img src="<?php echo base_url('assets/n-images/qus-point.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none;" class="modal fade monetize-popup" id="photo-point" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="modal-close" data-dismiss="modal">×</button>
                    <div class="mo-popup">
                        <div class="">
                            <img src="<?php echo base_url('assets/n-images/photo-point.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="monetize_success" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div class="pop_content pb20">Your account is now on monetization mode. Enjoy earning with Aileensoul.
                            </div>
                            <a class="btn-new-1" href="<?php echo base_url(); ?>">OK</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade message-box" id="monetize_fail" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">
                    <button type="button" class="modal-close" id="postedit"data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes">
                            <div class="pop_content">Please try again later.
                            </div>
                            <a class="btn1" href="<?php echo base_url(); ?>">OK</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $login_footer; ?>
        
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
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
    <script src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
    
    <script>
    var base_url = '<?php echo base_url(); ?>';
    /*var slug = '<?php //echo $slugid; ?>';*/
    var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
    var header_all_profile = '<?php echo $header_all_profile; ?>';
    $(document).ready(function () {
        $("#monetize_user").validate({
            rules: {
                term_condi: {
                    required: true,
                }
            },
            messages:{
                term_condi: {
                    required: "Please read and accept terms and conditions",
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("type") == "checkbox") {
                    error.insertAfter($("#lbl_term_condi"));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {                
                var term_condi = $("#term_condi").val();
                $.ajax({
                    url: base_url+"userprofile/save_monetize", 
                    type: "POST",             
                    data: {term_condi:term_condi},
                    dataType: 'json',                    
                    success: function(data) {                        
                        if(data.success == '1')
                        {
                            $("#monetize_user").remove();
                            $("#monetize_success").modal("show");
                        }
                        else
                        {
                            $("#monetize_fail").modal("show");
                        }
                    }
                });
                return false;
            },

        });
    });
    function new_monetize() {
        $("#monetize_user").validate();
    }
    </script>
    <script src="http://chat.aileensoul.localhost/socket.io/socket.io.js"></script>
    <script type="text/javascript">
        var socket = io.connect('http://chat.aileensoul.localhost:3000/');
    </script>
    <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/webpage/notification.js?ver=' . time()) ?>"></script>
    <script src="<?php echo base_url('assets/js/classie.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui-1.12.1.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/autosize.js') ?>"></script>   

    </body>
</html>