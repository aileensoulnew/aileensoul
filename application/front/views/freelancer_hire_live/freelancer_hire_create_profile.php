<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="#">Create an Account</a></li>
            <li><a href="#">Basic Information</a></li>
            <li class="active"><a href="#">Employer Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="rec-registration" class="tab-pane fade final-reg-form in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Employer Registration</h1>
                        <p>Complete your profile to connect with skilled freelancer</p>
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
                        <div id="regi-form-individual" style="display: none;">
                            <form id="freelancer_hire_individual_regi" name="freelancer_hire_individual_regi" ng-validate="freelancer_hire_individual_regi_validate">
                                <h2 class="text-center">Individual</h2>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="first_name" id="first_name" tabindex="1" placeholder="First Name*" maxlength="35" value="<?php echo $leftbox_data['first_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="last_name" id="last_name" tabindex="2" placeholder="Last Name*" maxlength="35" value="<?php echo $leftbox_data['last_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group left-tooltip">
                                            <input class="form-control" type="email" name="email_id" id="email_id" tabindex="3" placeholder="Email*" maxlength="255" value="<?php echo $fh_data['email']; ?>">
                                            <div id="emtooltip" class="tooltip-custom" style="display: none;">
                                                You will get freelancer recommendations, messages from freelancer, reminders, and promotional emails on provided email id.
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">                    
                                            <input type="text" class="form-control" id="current_position" name="current_position" ng-model="current_position" ng-keyup="current_position_list()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off" placeholder="Current Position" ng-init="current_position = '<?php echo ($leftbox_data['title_name'] != '' ? $leftbox_data['title_name'] : ''); ?>'" maxlength="35">
                                            <div id="cptooltip" class="tooltip-custom" style="display: none;">
                                                Enter a valid phone number so that freelancer can contact you.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <label>Location</label>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                                <div class="form-group fw">
                                                    <span class="select-field-custom">              
                                                        <select id="individual_country" name="individual_country" ng-model="individual_country" ng-change="individual_country_change()">
                                                            <option value="">Select Country</option>         
                                                            <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                                <div class="form-group fw">                     
                                                    <span class="select-field-custom">              
                                                        <select id="individual_state" name="individual_state" ng-model="individual_state" ng-change="individual_state_change()" disabled = "disabled">
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
                                                        <select id="individual_city" name="individual_city" ng-model="individual_city" disabled = "disabled">
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
                                            <textarea type="text" class="form-control" placeholder="Professional Information" id="prof_info" name="prof_info" ng-model="prof_info" maxlength="700"></textarea>
                                            <span class="pull-right d-c-c">{{700 - prof_info.length}}</span>
                                            <div id="pitooltip" class="tooltip-custom" style="display: none;">
                                                Enter your professional background and details so that it helps in building trust with freelancer as that will help them know more about you.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                           <div class="job_reg text-center">
                                        
                                              <!-- <input title="Register" type="submit" id="submit" name="" value="Register" tabindex="12"> -->
                                              <a id="back_individual" href="#" ng-click="back_to_main();" class="btn3">Back</a>  
                                              <button id="save_individual" ng-click="save_individual();" name="" class="btn1" tabindex="12">Register<span class="ajax_load pl10" id="freelancer_loader" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="regi-form-company" style="display: none;">
                            <form id="freelancer_hire_company_regi" name="freelancer_hire_company_regi" ng-validate="freelancer_hire_company_regi_validate">
                                <h2 class="text-center">Company</h2>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="comp_name" id="comp_name" tabindex="1" placeholder="Company Name" maxlength="35">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="comp_number" id="comp_number" tabindex="2" placeholder="Company Number" maxlength="35">
                                            <div id="cntooltip" class="tooltip-custom" style="display: none;">
                                                Enter a valid phone number so that freelancer can contact you.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group left-tooltip">
                                            <input class="form-control" type="email" name="comp_email" id="comp_email" tabindex="3" placeholder="Company Email*" maxlength="255" value="<?php echo $leftbox_data['email']; ?>">
                                            <div id="cetooltip" class="tooltip-custom" style="display: none;">
                                                You will get freelancer recommendations, messages from freelancer, reminders, and promotional emails on provided email id.
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="comp_website" id="comp_website" tabindex="2" placeholder="Current URL" maxlength="35">                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <?php $getFieldList = $this->data_model->getNewFieldList(); ?>
                                            <select name="company_field" id="company_field" ng-model="company_field" ng-change="company_other_field_fnc()" style="width: 100%">
                                                    <option value="">Select Field</option>
                                                <?php foreach ($getFieldList as $key => $value) { ?>
                                                    <option value="<?php echo $value['industry_id']; ?>""><?php echo $value['industry_name']; ?></option>
                                                <?php } ?>
                                                <option value="0">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="company_other_field_div" class="col-sm-12 col-md-12" style="display: none;">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="company_other_field" id="company_other_field" tabindex="2" placeholder="Enter Other Field" maxlength="35">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" tabindex="2" placeholder="Company Overview" id="comp_overview" name="comp_overview" ng-model="comp_overview" maxlength="700"></textarea>
                                            <span class="pull-right d-c-c">{{700 - comp_overview.length}}</span>
                                            <div id="cotooltip" class="tooltip-custom" style="display: none;">
                                                Enter your professional background and details so that it helps in building trust with freelancer as that will help them know more about you.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <label>Location</label>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                                <div class="form-group fw">
                                                    
                                                    <span class="select-field-custom">
                                                        <select id="company_country" name="company_country" ng-model="company_country" ng-change="company_country_change()">
                                                            <option value="">Select Country</option>         
                                                            <option data-ng-repeat='country_item in country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4 fw-479">
                                                <div class="form-group fw">
                                                    
                                                    <span class="select-field-custom">
                                                        <select id="company_state" name="company_state" ng-model="company_state" ng-change="company_state_change()" disabled = "disabled">
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
                                                        <select id="company_city" name="company_city" ng-model="company_city" disabled = "disabled">
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
                                              <button id="save_company" ng-click="save_company();" name="" class="btn1" tabindex="12">Register<span class="ajax_load pl10" id="company_loader" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </form> 
                        </div>
                    </div>
                    <!-- <form id="freelancehireinfo" name="freelancehireinfo" ng-submit="submitFreelancehireRegiForm()" class="hide" ng-validate="freelancehireRegiValidate" >
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="first_name" id="first_name" tabindex="1" placeholder="First Name*" maxlength="35" ng-model="user.first_name" ng-init="user.first_name ='<?php echo $fh_data['first_name']; ?>'">
                                    <label ng-show="errorFname" class="error">{{errorFname}}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="last_name" id="last_name" tabindex="2" placeholder="Last Name*" maxlength="35" ng-model="user.last_name" ng-init="user.last_name ='<?php echo $fh_data['last_name']; ?>'">
                                        <label ng-show="errorLname" class="error">{{errorLname}}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group left-tooltip">
                                    <input class="form-control" type="email" name="email" id="email" tabindex="3" placeholder="Email*" maxlength="255" ng-model="user.email" ng-init="user.email ='<?php echo $fh_data['email']; ?>'">
                                    <div id="emtooltip" class="tooltip-custom" style="display: none;">
                                        You will get freelancer recommendations, messages from freelancer, reminders, and promotional emails on provided email id.
                                    </div>
                                    <label ng-show="errorEmail" class="error">{{errorEmail}}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="phoneno" id="phoneno" tabindex="4" placeholder="Phone Number" maxlength="35" ng-model="user.phoneno">
                                    <div id="pntooltip" class="tooltip-custom" style="display: none;">
                                        Enter a valid phone number so that freelancer can contact you.
                                    </div>
                                    <label ng-show="pnEmail" class="error">{{pnEmail}}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group fw">
                                    <span class="select-field-custom">
                                        <select name="country" id="country" tabindex="4" ng-model="user.country">
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
                                    <label ng-show="errorCon" class="error">{{errorCon}}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group fw">
                                    <span class="select-field-custom">
                                        <select name="state" id="state" tabindex="6" ng-model="user.state">
                                            <option value="" selected="selected" disabled="">Select State*</option>
                                        </select>
                                    </span>
                                    <label ng-show="errorSt" class="error">{{errorSt}}</label>
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
                                <div class="form-group">
                                    <textarea class="form-control" tabindex="2" placeholder="Enter Professional Information" name="professionalinfo" id="professionalinfo" ng-model="user.professionalinfo"></textarea>
                                    <div id="pitooltip" class="tooltip-custom" style="display: none;">
                                        Enter your professional background and details so that it helps in building trust with freelancer as that will help them know more about you.
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