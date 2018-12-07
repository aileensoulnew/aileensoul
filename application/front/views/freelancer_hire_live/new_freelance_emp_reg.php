<!DOCTYPE html>
<html lang="en" ng-app="freelanceHireControllerApp" ng-controller="freelanceHireRegiController">
    <head>
        <!-- <title>Freelance Register | Aileensoul</title> -->
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php //echo $metadesc; ?>" />
        <meta charset="utf-8">
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/developer.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <meta property="og:image" content="<?php echo base_url(); ?>assets/n-images/free-hire.png" />
    <?php $this->load->view('adsense'); ?>
    </head>
    <body class="profile-main-page recruiter-main">
        <img src="<?php echo base_url(); ?>assets/n-images/free-hire.png" style="display: none;">
       <?php echo $header_profile; ?>       
        <div id="regi-opt" class="middle-section freelancer-midd">
            <div class="container">
                <div class="vertical-m-box">
                <div class="vm-box">
                    <h2>Select your Hiring account type.</h2>
                    <div class="m-box middle-left">
                        <a id="regi-individual" href="javascript:void(0);" ng-click="open_form(1);">
                            <span class="indi-img"></span>
                            <p>Are you working as Independent?</p>
                            <h4>Individual</h4>
                        </a>
                    </div>
                    <div class="m-box middle-right">
                        <a id="regi-company" href="javascript:void(0);" ng-click="open_form(2);">
                            <span class="com-img"></span>
                            <p>Are you an Organization?</p>
                            <h4>Company</h4>
                        </a>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div id="register-form" class="middle-section" style="display: none;">
            <div id="regi-form-individual" class="container mob-plr0" style="display: none;" ng-controller="freelanceHireIndividualRegiController">
                <div class="job_reg_page_fprm">
                    <div class="job_reg_main fw job-reg-cus-new">
                        <h3>Indivdual</h3>
                        <div class="fw p20">
                            <form id="freelancer_hire_individual_regi" name="freelancer_hire_individual_regi" ng-validate="freelancer_hire_individual_regi_validate">
                                <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        <div class="form-group">
                                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" value="<?php echo $leftbox_data['first_name']; ?>">
                                            <!-- <label class="form-control-placeholder" for="First Name">First Name</label> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mx-auto">
                                        <div class="form-group">
                                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo $leftbox_data['last_name']; ?>">
                                            <!-- <label class="form-control-placeholder" for="Last Name">Last Name</label> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="email_id" name="email_id" class="form-control" placeholder="Email Address" value="<?php echo $leftbox_data['email']; ?>">
                                            <!-- <label class="form-control-placeholder" for="First Name">Email Address</label> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="current_position" name="current_position" ng-model="current_position" ng-keyup="current_position_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off" placeholder="Current Position" ng-init="current_position = '<?php echo ($leftbox_data['title_name'] != '' ? $leftbox_data['title_name'] : ''); ?>'">
                                            <!-- <input type="text" class="form-control" required> -->
                                            <!-- <label class="form-control-placeholder" for="current_position">Current Position</label> -->
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="row total-exp">
                                    <div class="col-md-12 fw">
                                        Location:
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 hw-479">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="individual_country" name="individual_country" ng-model="individual_country" ng-change="country_change()">
                                                    <option value="">Country</option>         
                                                    <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                                </select>
                                            </span>
                                        </div>
                                    
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 hw-479">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="individual_state" name="individual_state" ng-model="individual_state" ng-change="state_change()" disabled = "disabled">
                                                    <option value="">State</option>
                                                    <option data-ng-repeat='state_item in individual_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                                </select>
                                                <img id="individual_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">                                    
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="individual_city" name="individual_city" ng-model="individual_city" disabled = "disabled">
                                                    <option value="">City</option>
                                                    <option data-ng-repeat='city_item in individual_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                                </select>
                                                <img id="individual_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group one-border">
                                    <textarea type="text" class="form-control" placeholder="Professional Information about you" id="prof_info" name="prof_info" ng-model="prof_info" maxlength="700"></textarea>
                                    <span class="pull-right">{{700 - prof_info.length}}</span>
                                    <!-- <label class="form-control-placeholder" for="First Name">Professional Information about you</label> -->
                                </div>
                                
                                <div class="fw text-center pt5">
                                    <a id="back_individual" ng-click="back_to_main();" class="btn3">Back</a>
                                    <a id="save_individual" ng-click="save_individual();" class="btn3">Register</a>                                    
                                    <div id="freelancer_loader" class="dtl-popup-loader" style="display: none;">
                                        <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p20 fw"></div>
            <div id="regi-form-company" class="container mob-plr0" style="display: none;" ng-controller="freelanceHireCompanyRegiController">
                <div class="job_reg_page_fprm">
                    <div class="job_reg_main fw job-reg-cus-new">
                        <h3>Company</h3>
                        <div class="fw p20">
                            <form id="freelancer_hire_company_regi" name="freelancer_hire_company_regi" ng-validate="freelancer_hire_company_regi_validate">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="form-group">
                                        <input type="text" id="comp_name" name="comp_name" class="form-control" placeholder="Company Name">
                                        <!-- <label class="form-control-placeholder" for="First Name">Company Name</label> -->
                                    </div>
                                </div>
                                <div class="col-md-6 mx-auto">
                                    <div class="form-group">
                                        <input type="text" id="comp_number" name="comp_number" class="form-control" placeholder="Company Number">
                                        <!-- <label class="form-control-placeholder" for="Last Name">Company Number</label> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="comp_email" name="comp_email" placeholder="Company Email" value="<?php echo $leftbox_data['email']; ?>">
                                        <!-- <label class="form-control-placeholder" for="First Name">Company Email</label> -->
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Company's Website URL" id="comp_website" name="comp_website">
                                        <!-- <label class="form-control-placeholder" for="First Name">Company's Website URL</label> -->
                                    </div>
                                    </div>                                
                            </div>                            
                            <div class="form-group">
                                <span class="span-select">
                                    <?php $getFieldList = $this->data_model->getNewFieldList(); ?>
                                    <select name="company_field" id="company_field" ng-model="company_field" ng-change="company_other_field_fnc()">
                                            <option value="">Select Field</option>
                                        <?php foreach ($getFieldList as $key => $value) { ?>
                                            <option value="<?php echo $value['industry_id']; ?>""><?php echo $value['industry_name']; ?></option>
                                        <?php } ?>
                                        <option value="0">Other</option>
                                    </select>
                                </span>
                            </div>
                            <div id="company_other_field_div" class="form-group" style="display: none;">
                                <input type="text" class="form-control" placeholder="Enter Other Field" id="company_other_field" name="company_other_field" ng-model="company_other_field">
                            </div>
                            
                            <div class="form-group one-border">
                                <textarea type="text" class="form-control" placeholder="Company Overview" id="comp_overview" name="comp_overview" ng-model="comp_overview" maxlength="700"></textarea>
                                <span class="pull-right">{{700 - comp_overview.length}}</span>
                                <!-- <label class="form-control-placeholder" for="First Name">Company Overview</label> -->
                            </div>
                            <div class="row total-exp">
                                <div class="col-md-12">
                                    Company Address:
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4 hw-479">
                                    <div class="form-group">
                                        <span class="span-select">
                                            <select id="company_country" name="company_country" ng-model="company_country" ng-change="country_change()">
                                                <option value="">Country</option>         
                                                <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                            </select>
                                        </span>
                                    </div>                                
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4 hw-479">
                                    <div class="form-group">
                                        <span class="span-select">
                                            <select id="company_state" name="company_state" ng-model="company_state" ng-change="state_change()" disabled = "disabled">
                                                <option value="">State</option>
                                                <option data-ng-repeat='state_item in company_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                            </select>
                                            <img id="company_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                    <div class="form-group">
                                        <span class="span-select">
                                            <select id="company_city" name="company_city" ng-model="company_city" disabled = "disabled">
                                                <option value="">City</option>
                                                <option data-ng-repeat='city_item in company_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                            </select>
                                            <img id="company_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                        </span>
                                    </div>
                                </div>                                
                            </div>                            
                            <div class="fw text-center pt5">
                                <a id="back_company" href="#" ng-click="back_to_main();" class="btn3">Back</a>                                
                                <a id="save_company" ng-click="save_company();" class="btn3">Register</a>                                    
                                <div id="company_loader" class="dtl-popup-loader" style="display: none;">
                                    <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade message-box biderror" id="error-modal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lm">
                <div class="modal-content">                    
                    <div class="modal-body">
                        <span class="mes">
                            <div class='pop_content'>
                                <span>Please Try Again Later !</span>
                                <p class='poppup-btns pt20'>
                                    <span id="project-delete-btn">
                                        <a href="<?php echo base_url('freelance-employer'); ?>" class="btn1">
                                            <span>OK</span>
                                        </a>
                                    </span>                                    
                                </p>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?php echo base_url('assets/js/croppie.js?ver=' . time()); ?>"></script> 
        <!-- script for skill textbox automatic end (option 2)-->
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>

        <script src="<?php echo base_url('assets/js/progressloader.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/masonry.pkgd.min.js?ver=' . time()); ?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular-google-adsense.min.js'); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            var header_all_profile = '<?php echo $header_all_profile; ?>';
            var q = '';
            var l = '';
            var app = angular.module('freelanceHireControllerApp', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize','ngValidate']); 
            var site = '<?php echo base_url(); ?>';
            var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
            
            $('#content').on( 'change keyup keydown paste cut', 'textarea', function (){
                $(this).height(0).height(this.scrollHeight);
            }).find( 'textarea' ).change();
        </script>               
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-hire/hire_registration_new.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>        
    </body>
</html>