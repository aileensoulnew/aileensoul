<!DOCTYPE html>
<html ng-app="freelancerApp" ng-controller="freelancerAppRegiController">
    <head>
        <!-- start head -->
        <?php //echo $head; ?>
        <!-- Calender Css Start-->

        <title><?php echo $title; ?></title>
        <!-- Calender Css End-->      
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/freelancer-apply.css?ver=' . time()); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">

        <!-- This Css is used for call popup -->
        <?php if (!$this->session->userdata('aileenuser')) { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style-main.css'); ?>">

        <?php } ?>     
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver='.time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/animate.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/job.css?ver=' . time()); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/owl.carousel.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/jquery.mCustomScrollbar.min.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/aos.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/developer.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css?ver=' . time()) ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/1.10.3.jquery-ui.css?ver=' . time()) ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
    <?php $this->load->view('adsense'); ?>
</head>
    <!-- END HEAD -->
<body class="freelancer-box no-login botton_footer cus-error" id="add-model-open">
    <!-- start header -->
    <?php
    if ($this->session->userdata('aileenuser')) {
        echo $header_profile;
    } else {
        ?>
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3 left-header text-center fw-479">
						<?php $this->load->view('main_logo'); ?>
                    </div>
                    <div class="col-md-8 col-sm-9 right-header fw-479 text-center">
                        <div class="btn-right pull-right">
                            <a href="javascript:void(0);" onclick="login_profile();" class="btn2">Login</a>
                            <a href="javascript:void(0);" onclick="create_profile();" class="btn3">Create an account</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <?php } ?>
    <!-- END HEADER -->    
        <div id="regi-opt" class="middle-section freelancer-midd">
            <div class="container">
                <div class="vertical-m-box">
                <div class="vm-box">
                    <h2>Select your Freelancing account type.</h2>
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
        <div id="register-form" class="middle-section freelancer-regi-form-cus" style="display: none;">
            <div id="regi-form-individual" class="container mob-plr0">
                <div class="job_reg_page_fprm">
                    <div class="job_reg_main fw job-reg-cus-new">
                        <h3>Individual</h3>
                        <div class="fw p20">
                            <form id="freelancer_apply_individual_regi" name="freelancer_apply_individual_regi" ng-validate="freelancer_apply_individual_regi_validate">
                                <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        <div class="form-group">
                                            <input type="text" id="first_name" name="first_name" class="form-control" required placeholder="First Name" value="<?php echo $user_data['first_name']; ?>" maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mx-auto">
                                        <div class="form-group">
                                            <input type="text" id="last_name" name="last_name" class="form-control" required placeholder="Last Name" value="<?php echo $user_data['last_name']; ?>" maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="email" name="email" class="form-control" required value="<?php echo $user_data['email']; ?>" placeholder="Email Address" maxlength="255">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" id="phoneno" name="phoneno" class="form-control" placeholder="Phone Number" required maxlength="10" ng-model="phoneno" numbers-only>
                                        </div>
                                    </div>                          
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="current_position" name="current_position" ng-model="current_position" ng-keyup="current_position_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off" placeholder="Current Position" ng-init="current_position = '<?php echo ($user_data['title_name'] != '' ? $user_data['title_name'] : ''); ?>'" maxlength="35" tabindex="5">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="field" name="field" tabindex="6" ng-model="field">
                                                    <option value="" selected="selected" disabled="">Select Industry</option>
                                                    <?php
                                                    if (count($category_data) > 0) {
                                                        foreach ($category_data as $cnt) {
                                                            if ($fields_req1) {
                                                                ?>
                                                                <option value="<?php echo $cnt['category_id']; ?>" <?php if ($cnt['category_id'] == $fields_req1) echo 'selected'; ?>><?php echo $cnt['category_name']; ?></option>

                                                                <?php
                                                            }
                                                            else {
                                                                ?>
                                                                <option value="<?php echo $cnt['category_id']; ?>"><?php echo $cnt['category_name']; ?></option> 
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </span>
                                        </div>
                                    </div>                          
                                </div>                      
                                <div class="row total-exp">
                                    <div class="col-md-12">
                                        Total Experience*:
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select tabindex="7" autofocus="" name="experience_year" id="experience_year" ng-model="experience_year" ng-change="experience_year_change();" class="form-control">
                                                    <option value="" selected="" option="" disabled="">Year</option>
                                                    <option value="0 year">0 year</option>
                                                    <option value="1 year">1 year</option>
                                                    <option value="2 year">2 year</option>
                                                    <option value="3 year">3 year</option>
                                                    <option value="4 year">4 year</option>
                                                    <option value="5 year">5 year</option>
                                                    <option value="6 year">6 year</option>
                                                    <option value="7 year">7 year</option>
                                                    <option value="8 year">8 year</option>
                                                    <option value="9 year">9 year</option>
                                                    <option value="10 year">10 year</option>
                                                    <option value="11 year">11 year</option>
                                                    <option value="12 year">12 year</option>
                                                    <option value="13 year">13 year</option>
                                                    <option value="14 year">14 year</option>
                                                    <option value="15 year">15 year</option>
                                                    <option value="16 year">16 year</option>
                                                    <option value="17 year">17 year</option>
                                                    <option value="18 year">18 year</option>
                                                    <option value="19 year">19 year</option>
                                                    <option value="20 year">20 year</option>
                                                </select>
                                            </span>
                                        </div>                          
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select tabindex="8" id="experience_month" class="form-control" name="experience_month" ng-model="experience_month" ng-change="experience_month_change();">
                                                        <option value="" selected="" option="" disabled="">Month</option>    
                                                        <option>0 month</option>
                                                        <option>1 month</option>
                                                        <option>2 month</option>
                                                        <option>3 month</option>
                                                        <option>4 month</option>
                                                        <option>5 month</option>
                                                        <option>6 month</option>
                                                        <option>7 month</option>
                                                        <option>8 month</option>
                                                        <option>9 month</option>
                                                        <option>10 month</option>
                                                        <option>11 month</option>
                                                    </select>
                                                </span>                                       
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="skills" id="skills1" tabindex="9" placeholder="Skills*" maxlength="255"  ng-model="user.skills">
                                </div>                      
                                <div class="row total-exp">
                                    <div class="col-md-12">
                                        Location:
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="individual_country" name="individual_country" ng-model="individual_country" ng-change="individual_country_change()" tabindex="10">
                                                    <option value="">Select Country</option>         
                                                    <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                                </select>
                                            </span>
                                        </div>                                    
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="individual_state" name="individual_state" ng-model="individual_state" ng-change="individual_state_change()" disabled = "disabled" tabindex="11">
                                                    <option value="">Select State</option>
                                                    <option data-ng-repeat='state_item in individual_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                                </select>
                                                <img id="individual_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;"> 
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="individual_city" name="individual_city" disabled = "disabled" tabindex="12">
                                                    <option value="">Select City</option>
                                                    <option data-ng-repeat='city_item in individual_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                                </select>
                                                <img id="individual_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                            </span>
                                        </div>
                                    </div>                          
                                </div>
                                <div class="fw text-center pt5">
                                    <a id="back_individual" href="javascript:void(0);" ng-click="back_to_main();" class="btn3">Back</a>
                                    <a href="javascript:void(0);" id="save_individual" tabindex="13" ng-click="save_individual();" class="btn3">Register</a>
                                    <div id="individual_loader" class="dtl-popup-loader" style="display: none;">
                                        <img src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" >
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p20 fw"></div>
            <div id="regi-form-company" class="container mob-plr0">
                <div class="job_reg_page_fprm">
                    <div class="job_reg_main fw job-reg-cus-new">
                        <h3>Company</h3>
                        <div class="fw p20">
                            <form id="freelancer_apply_company_regi" name="freelancer_apply_company_regi" ng-validate="freelancer_apply_company_regi_validate">
                                <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="comp_name" id="comp_name" tabindex="14" placeholder="Company Name*" maxlength="35">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mx-auto">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="comp_number" id="comp_number" tabindex="15" placeholder="Company Number" maxlength="35" ng-model="comp_number" numbers-only>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <input class="form-control" type="email" name="comp_email" id="comp_email" tabindex="16" placeholder="Company Email*" maxlength="255" value="<?php echo $user_data['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="comp_website" id="comp_website" tabindex="17" placeholder="Website URL" maxlength="255">
                                        </div>
                                    </div>                                    
                                </div>                                
                                <div class="form-group">
                                    <input class="form-control" type="text" name="skills" id="skills2" tabindex="19" placeholder="Skills*" maxlength="255">
                                </div>
                                <div class="form-group">
                                    <span class="span-select">
                                        <select id="comp_field" name="field" tabindex="20" ng-model="user.field">
                                            <option value="" selected="selected" disabled="">Select Industry*</option>
                                            <?php
                                            if (count($category_data) > 0) {
                                                foreach ($category_data as $cnt) {
                                                    if ($fields_req1) {
                                                        ?>
                                                        <option value="<?php echo $cnt['category_id']; ?>" <?php if ($cnt['category_id'] == $fields_req1) echo 'selected'; ?>><?php echo $cnt['category_name']; ?></option>
                                                        <?php
                                                    }
                                                    else {
                                                        ?>
                                                        <option value="<?php echo $cnt['category_id']; ?>"><?php echo $cnt['category_name']; ?></option> 
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </span>
                                </div>
                                
                                <div class="row total-exp">
                                    <div class="col-md-12">
                                        Total Experience*:
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select tabindex="21" autofocus="" name="comp_exp_year" id="comp_exp_year" ng-model="comp_exp_year" ng-change="comp_exp_year_change();" class="form-control" >
                                                    <option value="">Select Year</option>
                                                    <option value="0">0 year</option>
                                                    <option value="1">1 year</option>
                                                    <option value="2">2 year</option>
                                                    <option value="3">3 year</option>
                                                    <option value="4">4 year</option>
                                                    <option value="5">5 year</option>
                                                    <option value="6">6 year</option>
                                                    <option value="7">7 year</option>
                                                    <option value="8">8 year</option>
                                                    <option value="9">9 year</option>
                                                    <option value="10">10 year</option>
                                                    <option value="11">11 year</option>
                                                    <option value="12">12 year</option>
                                                    <option value="13">13 year</option>
                                                    <option value="14">14 year</option>
                                                    <option value="15">15 year</option>
                                                    <option value="16">16 year</option>
                                                    <option value="17">17 year</option>
                                                    <option value="18">18 year</option>
                                                    <option value="19">19 year</option>
                                                    <option value="20">20 year</option>
                                                </select>
                                            </span>
                                        </div>
                                    
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select tabindex="22" id="comp_exp_month" name="comp_exp_month" ng-model="comp_exp_month" ng-change="comp_exp_month_change();" class="form-control">
                                                    <option value="">Select Month</option> 
                                                    <option value="0">0 month</option>
                                                    <option value="1">1 month</option>
                                                    <option value="2">2 month</option>
                                                    <option value="3">3 month</option>
                                                    <option value="4">4 month</option>
                                                    <option value="5">5 month</option>
                                                    <option value="6">6 month</option>
                                                    <option value="7">7 month</option>
                                                    <option value="8">8 month</option>
                                                    <option value="9">9 month</option>
                                                    <option value="10">10 month</option>
                                                    <option value="11">11 month</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group one-border">
                                    <textarea placeholder="Company Overview" id="comp_overview" name="comp_overview" tabindex="23" maxlength="700"></textarea>
                                </div>
                                <div class="row total-exp">
                                    <div class="col-md-12">
                                        Company Address:
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="company_country" name="company_country" ng-model="company_country" ng-change="company_country_change()" tabindex="24">
                                                    <option value="">Select Country</option>         
                                                    <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                                </select>
                                            </span>
                                        </div>
                                    
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="company_state" name="company_state" ng-model="company_state" ng-change="company_state_change()" disabled = "disabled" tabindex="25">
                                                    <option value="">Select State</option>
                                                    <option data-ng-repeat='state_item in company_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                                </select>
                                                <img id="company_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <span class="span-select">
                                                <select id="company_city" name="company_city" ng-model="company_city" disabled = "disabled" tabindex="26">
                                                    <option value="">Select City</option>
                                                    <option data-ng-repeat='city_item in company_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                                </select>
                                                <img id="company_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="fw text-center pt5">
                                    <a id="back_company" href="javascript:void(0);" ng-click="back_to_main();" class="btn3">Back</a>
                                    <a href="javascript:void(0);" id="save_company" ng-click="save_company();" class="btn3">Register</a>
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
        <!-- END CONTAINER -->

        <!-- Bid-modal  -->
        <div class="modal fade message-box biderror custom-message in" id="bidmodal" role="dialog"  >
            <div class="modal-dialog modal-lm" >
                <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>       
                    <div class="modal-body">
                        <span class="mes"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Model Popup Close -->
        <!-- Bid-modal for other field start  -->
        <div class="modal fade message-box biderror custom-message" id="bidmodal2" role="dialog">
            <div class="modal-dialog modal-lm">
                <div class="modal-content message">
                    <button type="button" class="modal-close" data-dismiss="modal">&times;</button>
                    <h2>Add Field</h2>         
                    <input type="text" name="other_field" id="other_field" onkeypress="return remove_validation()">
                    <div class="fw"><a id="field" class="btn">OK</a></div>
                    <!--                    </div>-->
                </div>
            </div>
        </div>
        <!-- Model for other field Popup Close -->
        <!-- register -->

        <!-- <footer>        -->
        <?php //echo $login_footer ?> 
        <?php //echo $footer; ?>
        <!-- </footer> -->      
        

        <script  type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . time()); ?>"></script>
        

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script data-semver="0.13.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <script src="<?php echo base_url('assets/js/ng-tags-input.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-tooltips.min.js?ver=' . time()); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>

        <script src="<?php echo base_url('assets/js/jquery-ui.min-1.12.1.js?ver=' . time()) ?>"></script>

        <script>
            var base_url = '<?php echo base_url(); ?>';
            var site = '<?php echo base_url(); ?>';
            var user_session = '<?php echo $this->session->userdata('aileenuser'); ?>';
        
            var app = angular.module('freelancerApp', ['ngRoute', 'ui.bootstrap', 'ngTagsInput', 'ngSanitize', 'ngValidate']);
            var header_all_profile = '<?php echo $header_all_profile; ?>';
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/registation_new.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/freelancer-apply/registation.js?ver=' . time()); ?>"></script>
        <script type="text/javascript">
            $(function () {                
                function split(val)
                {
                    return val.split(/,\s*/);
                }
                function extractLast(term)
                {
                    return split(term).pop();
                }
                   
                $("#skills1").autocomplete({ 
                    minLength: 2,                
                    source: function (request, response) {                     
                        // delegate back to autocomplete, but extract the last term
                        $.getJSON(base_url + "general/get_skill", {term: extractLast($("#skills1").val())}, response);
                         $("#ui-id-1").addClass("autoposition");
                    },
                    appendTo: $("#auto_skill"),
                    focus: function () {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function (event, ui) {                    
                        var text = $("#skills1").val();
                        var terms = split($("#skills1").val());
                        text = text == null || text == undefined ? "" : text;
                        var checked = (text.indexOf(ui.item.value + ', ') > -1 ? 'checked' : '');
                        if (checked == 'checked') {

                            terms.push(ui.item.value);
                            $("#skills1").val(terms.split(", "));
                        }//if end
                        else {
                            if (terms.length <= 15) {
                                // remove the current input
                                terms.pop();
                                // add the selected item
                                terms.push(ui.item.value);
                                // add placeholder to get the comma-and-space at the end
                                terms.push("");
                                $("#skills1").val(terms.join(", "));
                                return false;
                            } else {
                                var last = terms.pop();
                                $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                                $(this).effect("highlight", {}, 1000);
                                $(this).attr("style", "border: solid 1px red;");
                                return false;
                            }
                        }
                    }
                });

                $("#skills2").autocomplete({ 
                    minLength: 2,                
                    source: function (request, response) {                     
                        // delegate back to autocomplete, but extract the last term
                        $.getJSON(base_url + "general/get_skill", {term: extractLast($("#skills2").val())}, response);
                         $("#ui-id-1").addClass("autoposition");
                    },
                    appendTo: $("#auto_skill"),
                    focus: function () {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function (event, ui) {                    
                        var text = $("#skills2").val();
                        var terms = split($("#skills2").val());
                        text = text == null || text == undefined ? "" : text;
                        var checked = (text.indexOf(ui.item.value + ', ') > -1 ? 'checked' : '');
                        if (checked == 'checked') {

                            terms.push(ui.item.value);
                            $("#skills2").val(terms.split(", "));
                        }//if end
                        else {
                            if (terms.length <= 15) {
                                // remove the current input
                                terms.pop();
                                // add the selected item
                                terms.push(ui.item.value);
                                // add placeholder to get the comma-and-space at the end
                                terms.push("");
                                $("#skills2").val(terms.join(", "));
                                return false;
                            } else {
                                var last = terms.pop();
                                $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                                $(this).effect("highlight", {}, 1000);
                                $(this).attr("style", "border: solid 1px red;");
                                return false;
                            }
                        }
                    }
                });                
            });
        </script>
    </body>
</html>