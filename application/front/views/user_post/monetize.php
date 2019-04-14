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
                        <h1>Monetize your Aileensoul Account</h1>
                        <div class="monetize-detail">
                            <div class="monetize-detail-sec">
                                <h2>How you will monetize your account ?</h2>
                                <ul>
                                    <li>To monetize your account you have to put creative and unique content, points will be rewarded for it.</li>
                                    <li>We will pay 10 dollars for 1000 Points. Once you have reached 1000 Points we will review your account and put advertisement in your content and you can earn money through clicks and views. The revenue will be split 50:50.</li>
                                    <li>You will continue to receive 10 dollars for every 1000 Points.</li>
                                </ul>
                            </div>
                            <div class="monetize-detail-sec">
                                <h2>Eligebilty to Monetize</h2>
                                <ul>
                                    <li>You have to attain 1000 Points.</li>
                                    <li>All the content should be creative, helpful and orginial. (Plagiarized content will not receive any point)</li>
                                </ul>
                            </div>
                            <div class="monetize-detail-sec">
                                <h2>Payment</h2>
                                <ul>
                                    <li>You have to share bank details with us and  you will get advertisement payment on 1 to 10 date after you reach minimum earning of 100 dollar</li>
                                    <li>You will get payment of points within 15 days after you reach every 1000 point.</li>
                                </ul>
                            </div>
                            <div class="monetize-detail-sec">
                                <h2>Points dsitribution </h2>
                                <ul class="monetize-point">
                                    <li><b>50 points</b>  -  Post opportunity
                                        <p>Opportunity should be for anyone. (example job seekers , freelancers , doctors , ceos, enterprenuers, plumber , artist, photographer , cook , etc.) ....<a data-toggle="modal" href="#" data-target="#opp-point"> View demo</a></p> 
                                    </li>
                                    <li><b>30 points</b>  -  Post video 
                                        <p>All types of videos acceptable but you can monetize only helpful and not plagarized.... <a href="">View demo.</a></p>
                                    </li>
                                    <li><b>30 ponts</b>  -  Post article
                                        <p>All types of article acceptable but you can monetize only useful content.... <a href="">View demo.</a></p>
                                    </li>
                                    <li><b>20 points</b>  -  Give answer
                                        <p>Answers should be helpful for users.... <a href="">View demo.</a></p>
                                    </li>
                                    <li><b>5 points</b>  -  Ask question
                                        <p>All types of question is acceptable but it should not have spamming.... <a href="">View demo.</a></p>
                                    </li>
                                    <li><b>5 points</b>  -  post photo
                                        <p>All types of photos acceptable. (with no spamming and no copyright issues).... <a href="">View demo.</a></p>
                                    </li>
                                </ul>
                                <p class="pt20">All content should be creative, helpful and orginial.</p>
                            </div>
                            <?php                             
                            if($is_user_monetize == 0){ ?>
                            <form id="monetize_user" name="monetize_user" action="javascript:void(0);" method="POST">
                                <div class="monetize-term-cond">
                                    <label id="lbl_term_condi" class="control control--checkbox" for="term_condi">
                                        <input type="checkbox" name="term_condi" id="term_condi" value="1">Agree to above  are our terms and codition
                                        <div class="control__indicator"></div>
                                    </label>
                                    <p class="pt20">
                                        <?php
                                        if(isset($userdata) && !empty($userdata)){
                                        ?>
                                            <button type="submit" onclick="new_monetize();" class="btn-new-3">Start moentize your account</button>
                                        <?php
                                        }
                                        else{ ?>
                                            <a href="<?php echo base_url('registration') ?>" class="btn-new-3">Start moentize your account</a>
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
                    required: "Please read and accept terms and codition",
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
                        console.log(data);
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
    <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/classie.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui-1.12.1.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/autosize.js') ?>"></script>   
    </body>
</html>