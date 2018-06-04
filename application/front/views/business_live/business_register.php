<!DOCTYPE html>
<html lang="en" ng-app="businessRegiMain" ng-controller="businessRegiMainController">
    <head>
        <base href="<?php echo base_url(); ?>">        
        <title ng-bind="title"></title>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php //echo $head; ?>
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
    </head>
    <body  class="reg-form-cus">
        <div class="web-header">
            <header class="custom-header">
                <div class="header animated fadeInDownBig">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 left-header">
                                <h2 class="logo"><a href="#">Aileensoul</a></h2>
                            </div>
                            <div class="col-md-6 col-sm-6 right-header">
                                <ul>
                                    
                                    <li>
                                        <a href="<?php echo base_url(); ?>login" target="_self" class="btn3">Login</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>                
            </header>            
        </div>
        <div class="mobile-header">
            <header class="">
                <div class="header animated fadeInDownBig">
                    <div class="container">
                        <div class="left-header">
                            <h2 class="logo"><a href="#"><img src="<?php echo base_url(); ?>assets/n-images/mob-logo.png"></a></h2>                            
                            <div class="right-header">
                                <ul>
                                    <li class="dropdown user-id">
                                        <a href="#" class="btn3">Login</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </div>        
        <div class="middle-section bus-reg-cus">
            <div class="container">
                <div ng-view></div>
            </div>
            <?php echo $login_footer; ?>            
        </div>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/owl.carousel.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/aos.js?ver=' . time()) ?>"></script>


        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php  echo base_url('assets/js/additional-methods1.15.0.min.js?ver='.time()); ?>"></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var profData = "<?php echo $professionData;?>";
            var studData = "<?php echo $studentData?>";
            var userid = "<?php echo $userid?>";
            var first_name = "asd";
            var app = angular.module('businessRegiMain', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize', 'ngValidate']);

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
        <script src="<?php echo base_url('assets/js/webpage/business-live/business_regi_main.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_job_reg&skill.js?ver='.time()); ?>"></script>
    </body>
</html>