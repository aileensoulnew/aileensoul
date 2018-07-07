<!DOCTYPE html>
<html lang="en" ng-app="recruiterRegiMain" ng-controller="recruiterRegiMainController">
    <head>
        <base href="<?php echo base_url(); ?>">        
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadesc; ?>" />
        <!-- <title ng-bind="title"></title> -->
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php //echo $head; ?>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <style>
          .ui-autocomplete {
            max-height: 100px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
          }
          /* IE 6 doesn't support max-height
           * we use height instead, but this forces the menu to always be this tall
           */
          * html .ui-autocomplete {
            height: 100px;
          }
          </style>
    <?php $this->load->view('adsense'); ?>
</head>
    <body  class="reg-form-cus">
        <div class="">
            <header class="custom-header">
                <div class="header animated fadeInDownBig">
                    <div class="container">
						<div class="row">
							<div class="col-md-4 col-sm-4 left-header col-xs-4 fw-479">
								<?php $this->load->view('main_logo'); ?>
							</div>
							<div class="col-md-8 col-sm-8 right-header col-xs-8 fw-479">
                                <div class="btn-right">
                                <?php if(!$this->session->userdata('aileenuser')) {?>
									<ul class="nav navbar-nav navbar-right test-cus drop-down">
										<?php $this->load->view('profile-dropdown'); ?>
										<li class="hidden-991"><a href="<?php echo base_url('login'); ?>" target="_self" class="btn2">Login</a></li>
										
										<li class="mob-bar-li">
											<span class="mob-right-bar">
												<?php $this->load->view('mobile_right_bar'); ?>
											</span>
										</li>
									
									</ul>
                                <?php }?>
                                </div>
                            </div>
               
						</div>
                    </div>
                </div>                
            </header>            
        </div>
               
        <div class="middle-section rec-reg-cus">
            <div class="container">
                <div ng-view></div>
            </div>
			<?php $this->load->view('mobile_side_slide'); ?>
            <?php echo $login_footer; ?>            
        </div>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>


        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src='<?php echo base_url(); ?>assets/chatjs/strophe.js'></script>
        <script src='<?php echo base_url(); ?>assets/chatjs/strophe.register.js'></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var profData = "<?php echo $professionData;?>";
            var studData = "<?php echo $studentData?>";
            var userid = "<?php echo $userid?>";
            var openfirelink = '<?php echo OPENFIRELINK; ?>';
            var openfireserver = '<?php echo OPENFIRESERVER; ?>';
            var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var app = angular.module('recruiterRegiMain', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize', 'ngValidate']);
            

            function experience(){
                document.getElementById('exp_data').style.display = 'block';
            }

            function not_experience(){
                var melement = document.getElementById('exp_data');                   
                if(melement.style.display == 'block'){
                    melement.style.display = 'none';
                    //value none if user have press yes button start
                    $("#experience_year").val("");
                    $("#experience_month").val("");
                }
            }

            function expyear_change() {
                var experience_year = document.querySelector("#experience_year").value;
                if (experience_year)
                {
                    $('#experience_month').attr('disabled', false);
                    var experience_year = document.getElementById('experience_year').value;
                    if (experience_year === '0 year') {
                        $("#experience_month option[value='0 month']").attr('disabled', true);
                    } else {
                        $("#experience_month option[value='0 month']").attr('disabled', false);
                    }
                }
                else
                {
                    $('#experience_month').attr('disabled', 'disabled');
                }
            }
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();   
            });
        </script>        
        <script src="<?php echo base_url('assets/js/webpage/job-live/searchJob.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/recruiter-live/recruiter_regi_main.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_job_reg&skill.js?ver='.time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/recruiter/rec_reg.js'); ?>"></script>
    </body>
</html>