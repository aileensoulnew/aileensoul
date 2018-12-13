<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="#">Create an Account</a></li>
            <li><a href="#">Basic Information</a></li>
            <li class="active"><a href="#">Freelancer Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="rec-registration" class="tab-pane fade final-reg-form in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Freelancer Registration</h1>
                        <p>Complete your profile to start getting job recommendation right in your inbox.</p>
                    </div>
                    <div id="regi-opt" class="ind-com">
                        <div class="vertical-m-box">
                            <div class="pt20">                                
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
                    <div id="register-form">
                        <div class="">
                            
                        </div>
                        <div id="regi-form-individual" style="display: none;">
                            <form id="freelanceapplyinfo" name="freelanceapplyinfo" ng-validate="freelanceapplyRegiValidate">
                                <h2 class="text-center">Individual</h2>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">                                            
                                            <input class="form-control" type="text" name="first_name" id="first_name" tabindex="1" placeholder="First Name*" maxlength="35" ng-model="user.first_name" ng-init="user.first_name ='<?php echo $user_data['first_name']; ?>'">
                                        <label ng-show="errorFname" class="error">{{errorFname}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">                                            
                                            <input class="form-control" type="text" name="last_name" id="last_name" tabindex="2" placeholder="Last Name*" maxlength="35" ng-model="user.last_name" ng-init="user.last_name ='<?php echo $user_data['last_name']; ?>'">
                                        <label ng-show="errorLname" class="error">{{errorLname}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group left-tooltip">       
                                            <input class="form-control" type="email" name="email" id="email" tabindex="3" placeholder="Email*" value="" maxlength="255" ng-model="user.email" ng-init="user.email ='<?php echo $user_data['email']; ?>'">
                                            <div id="emtooltip" class="tooltip-custom" style="display: none;">
                                                You will get job recommendations, recruiter messages, reminders, and promotional emails on provided email id
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">                                            
                                            <input class="form-control" type="text" name="phoneno" id="phoneno" tabindex="4" placeholder="Phone Number" maxlength="35" ng-model="user.phoneno">
                                            <div id="pntooltip" class="tooltip-custom" style="display: none;">
                                                Enter a valid phone number so that people can contact you for work offers.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">                                            
                                            <input type="text" class="form-control" id="current_position" name="current_position" ng-model="current_position" ng-keyup="current_position_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off" placeholder="Current Position" ng-init="current_position = '<?php echo ($leftbox_data['title_name'] != '' ? $leftbox_data['title_name'] : ''); ?>'" maxlength="35" tabindex="5">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group fw">
                                            <span class="select-field-custom">        
                                                <select id="field" name="field" tabindex="6" ng-model="user.field">
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
                                    </div>
                                    <div class="fw">
                                        <div id="exp_data">
                                            <label class="pl15">Total Experience<span class="red">*</span>:</label>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group fw">
                                                    <span class="select-field-custom">
                                                        <select tabindex="7" autofocus="" name="experience_year" id="experience_year" ng-model="experience_year" ng-change="experience_year_change();" class="experience_year keyskil">
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
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group fw"> 
                                                    <span class="select-field-custom">
                                                        <select tabindex="8" id="experience_month" class="experience_month keyskil" name="experience_month" ng-model="experience_month" ng-change="experience_month_change();">
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="skills" id="skills1" tabindex="9" placeholder="Skills*" maxlength="35"  ng-model="user.skills">
                                            <div id="sktooltip" class="tooltip-custom" style="display: none;">
                                                Enter your best skills to get relevant job offers
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <label>Location</label>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                                <div class="form-group fw">                     
                                                    <span class="select-field-custom">
                                                        <select id="individual_country" name="individual_country" ng-model="individual_country" ng-change="individual_country_change()" tabindex="10">
                                                            <option value="">Select Country</option>         
                                                            <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                                <div class="form-group fw">                         
                                                    <span class="select-field-custom">
                                                        <select id="individual_state" name="individual_state" ng-model="individual_state" ng-change="individual_state_change()" disabled = "disabled" tabindex="11">
                                                            <option value="">Select State</option>
                                                            <option data-ng-repeat='state_item in individual_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                                        </select>
                                                        <img id="individual_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">  
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                                <div class="form-group fw">                 
                                                    <span class="select-field-custom">
                                                        <select id="individual_city" name="individual_city" disabled = "disabled" tabindex="12">
                                                            <option value="">Select City</option>
                                                            <option data-ng-repeat='city_item in individual_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                                        </select>
                                                        <img id="individual_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                           <div class="job_reg text-center">
                                        
                                              <a id="back_individual" href="#" ng-click="back_to_main();" class="btn3">Back</a>
                                              <button id="save_individual" name="" class="btn1" tabindex="13" ng-click="save_individual();">Register<span class="ajax_load pl10" id="individual_loader" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="regi-form-company" style="display: none;">
                            <form id="freelanceapplyinfocompany" name="freelanceapplyinfocompany" ng-validate="freelanceapplyCompanyRegiValidate">
                                <h2 class="text-center">Company</h2>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="comp_name" id="comp_name" tabindex="14" placeholder="Company Name*" maxlength="35">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="comp_number" id="comp_number" tabindex="15" placeholder="Company Number" maxlength="35">
                                            <div id="cntooltip" class="tooltip-custom" style="display: none;">
                                                Enter a valid phone number so that people can contact you for work offers.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group left-tooltip">
                                            <input class="form-control" type="email" name="comp_email" id="comp_email" tabindex="16" placeholder="Company Email*" maxlength="255" value="<?php echo $user_data['email']; ?>">
                                            <div id="cetooltip" class="tooltip-custom" style="display: none;">
                                                You will get job recommendations, recruiter messages, reminders, and promotional emails on provided email id
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="comp_website" id="comp_website" tabindex="17" placeholder="Website" maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="skills" id="skills2" tabindex="19" placeholder="Skills*" maxlength="255">
                                            <div id="cktooltip" class="tooltip-custom" style="display: none;">
                                                Enter your best skills to get relevant job offers
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group fw">
                                            <span class="select-field-custom">
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
                                    </div>                                   
                                
                                    <div class="fw">
                                        <div id="exp_data">
                                            <label class="pl15">Total Experience<span class="red">*</span>:</label>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group fw">
                                                    <span class="select-field-custom">
                                                    <select tabindex="21" autofocus="" name="comp_exp_year" id="comp_exp_year" ng-model="comp_exp_year" ng-change="comp_exp_year_change();" class="experience_year keyskil" >
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
                                            <div class="col-sm-6 col-md-6">
                                                <div class="form-group fw"> 
                                                    <span class="select-field-custom">
                                                    <select tabindex="22" id="comp_exp_month" name="comp_exp_month" ng-model="comp_exp_month" ng-change="comp_exp_month_change();" class="experience_month keyskil">
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
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <textarea placeholder="Company Overview" id="comp_overview" name="comp_overview" tabindex="23" maxlength="700"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <label>Company Address</label>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                                <div class="form-group fw">
                                                    <span class="select-field-custom">
                                                        <select id="company_country" name="company_country" ng-model="company_country" ng-change="company_country_change()" tabindex="24">
                                                            <option value="">Select Country</option>         
                                                            <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                                <div class="form-group fw">                        
                                                    <span class="select-field-custom">
                                                        <select id="company_state" name="company_state" ng-model="company_state" ng-change="company_state_change()" disabled = "disabled" tabindex="25">
                                                            <option value="">Select State</option>
                                                            <option data-ng-repeat='state_item in company_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                                        </select>
                                                        <img id="company_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                                <div class="form-group fw">
                                                    <span class="select-field-custom">
                                                        <select id="company_city" name="company_city" ng-model="company_city" disabled = "disabled" tabindex="26">
                                                            <option value="">Select City</option>
                                                            <option data-ng-repeat='city_item in company_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                                        </select>
                                                        <img id="company_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                           <div class="job_reg text-center">      
                                              <a id="back_company" href="#" ng-click="back_to_main();" class="btn3">Back</a>
                                              <button id="save_company" ng-click="save_company();" name="save_company" class="btn1" tabindex="27">Register<span class="ajax_load pl10" id="company_loader" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <form id="freelanceapplyinfo" name="freelanceapplyinfo" ng-submit="submitFreelanceapplyRegiForm()" ng-validate="freelanceapplyRegiValidate" >
                        <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="first_name" id="first_name" tabindex="1" placeholder="First Name*" maxlength="35" ng-model="user.first_name" ng-init="user.first_name ='<?php echo $user_data['first_name']; ?>'">
                                        <label ng-show="errorFname" class="error">{{errorFname}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="last_name" id="last_name" tabindex="2" placeholder="Last Name*" maxlength="35" ng-model="user.last_name" ng-init="user.last_name ='<?php echo $user_data['last_name']; ?>'">
                                        <label ng-show="errorLname" class="error">{{errorLname}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group left-tooltip">
                                        <input class="form-control" type="email" name="email" id="email" tabindex="3" placeholder="Email*" value="" maxlength="255" ng-model="user.email" ng-init="user.email ='<?php echo $user_data['email']; ?>'">
                                        <div id="emtooltip" class="tooltip-custom" style="display: none;">
                                            You will get job recommendations, recruiter messages, reminders, and promotional emails on provided email id
                                        </div>
                                        <label ng-show="errorEmail" class="error">{{errorEmail}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="phoneno" id="phoneno" tabindex="4" placeholder="Phone Number" maxlength="35" ng-model="user.phoneno">
                                        <div id="pntooltip" class="tooltip-custom" style="display: none;">
                                            Enter a valid phone number so that people can contact you for work offers.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="country" id="country" tabindex="5" ng-model="user.country">
                                                <option value="" selected="selected" disabled="">Select Country*</option>
                                                <?php
                                                if (count($countries) > 0) {
                                                    foreach ($countries as $cnt) {
                                                        ?>
                                                        <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="state" id="state" tabindex="6" ng-model="user.state">
                                                <option value="" selected="selected" disabled="">Select State*</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="city" id="city" tabindex="7" ng-model="user.city">
                                                <option value="" selected="selected" disabled="">Select City*</option>                                                
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select id="field" name="field" tabindex="8" ng-model="user.field">
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
                                                <option value="<?php echo $category_otherdata[0]['category_id']; ?> "><?php echo $category_otherdata[0]['category_name']; ?></option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group" id="auto_skill">
                                        <input class="form-control" type="text" name="skills" id="skills1" tabindex="9" placeholder="Skills*" maxlength="35"  ng-model="user.skills">
                                        <div id="sktooltip" class="tooltip-custom" style="display: none;">
                                            Enter your best skills to get relevant job offers
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="fw">
                                    <div id="exp_data">
                                        <label class="pl15">Total Experience<span class="red">*</span>:</label>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group fw">
                                                <span class="select-field-custom">
                                                <select tabindex="10" autofocus="" name="experience_year" id="experience_year" class="experience_year keyskil" ng-model="user.experience_year">
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
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group fw"> 
                                                <span class="select-field-custom">
                                                <select tabindex="11" id="experience_month" class="experience_month keyskil" name="experience_month" ng-model="user.experience_month">
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
                                                    <option>12 month</option>
                                                </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                       <div class="job_reg text-center">
                                          <button id="submit" name="" class="btn1" tabindex="12">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                       </div>
                                    </div>
                                </div>
                            </div>
                    </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
        /*$(document).bind("keydown","#skills1", function (event) {            
            if (event.keyCode === $.ui.keyCode.TAB &&
                    $(this).autocomplete("instance").menu.active) {
                event.preventDefault();
            }
        })*/

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