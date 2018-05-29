<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="#">Create an Account</a></li>
            <li><a href="#">Basic Information</a></li>
            <li class="active"><a href="#">Job Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="job-registration" class="tab-pane fade final-reg-form  in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Job Registration</h1>
                        <p>Opportunities are waiting, complete your profile now.</p>
                    </div>
                    <form id="jobseeker_regform" name="jobseeker_regform" ng-submit="submitJobRegiForm()" ng-validate="jobRegiValidate">
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="first_name" id="first_name" tabindex="1" placeholder="Enter your First Name*" maxlength="35" ng-model="user.first_name" ng-init="user.first_name ='<?php echo $job_data['first_name']; ?>'">
                                    <label ng-show="errorFname" class="error">{{errorFname}}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="last_name" id="last_name" tabindex="2" placeholder="Enter your Last Name*" maxlength="35"  ng-model="user.last_name" ng-init="user.last_name ='<?php echo $job_data['last_name']; ?>'">
                                    <label ng-show="errorLname" class="error">{{errorLname}}</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input class="form-control" type="email" name="email" id="email" tabindex="3" placeholder="Enter your Email Address*" maxlength="255"  ng-model="user.email" ng-init="user.email ='<?php echo $job_data['email']; ?>'">
                                    <div id="emtooltip" class="tooltip-custom" style="display: none;">
                                        You will get job recommendations, recruiter messages, reminders, and promotional emails on provided email id.
                                    </div>
                                    <label ng-show="errorEmail" class="error">{{errorEmail}}</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group cus-radio-box">
                                    <label>Fresher <font color="red">*</font> : </label>
                                    <div class="main_raio">
                                        <input ng-model="user.fresher" type="radio" value="Fresher" tabindex="4" id="test1" name="fresher" class="radio_job form-control" onclick="not_experience()">
                                        <label for="test1" class="point_radio">Yes</label>
                                    </div>

                                    <div class="main_raio">
                                        <input ng-model="user.fresher" type="radio" value="Experience" tabindex="5" id="test2" class="radio_job form-control" name="fresher" onclick="experience()">
                                        <label for="test2" class="point_radio">No</label>
                                    </div>
                                    <div class="fresher-error"></div>
                                </div>
                            </div>
                            <div class="fw">
                                <div id="exp_data" style="display:none;">
                                    <label class="pl15">Total Experience<span class="red">*</span>:</label>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group fw">
                                            <span class="select-field-custom">
                                            <select tabindex="6" ng-model="user.experience_year" autofocus="" name="experience_year" id="experience_year" class="experience_year keyskil" onchange="expyear_change();">
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
                                            <select ng-model="user.experience_month" tabindex="7" id="experience_month" class="experience_month keyskil">
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
                                    <input class="form-control" type="search" tabindex="8" id="job_title" name="job_title" placeholder="Enter Job Title*" style="text-transform: capitalize;" onfocus="this.value = this.value;" maxlength="255" class="ui-autocomplete-input" autocomplete="off" ng-model="user.jobTitle" ng-keyup="jobTitle()" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" ng-init="user.jobTitle = '<?php echo $user_profession_data['name']; ?>'">
                                    <div id="jttooltip" class="tooltip-custom" style="display: none;">
                                        Ex:- Sr. Engineer, Jr. Engineer, Software Developer, Account Manager
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input class="form-control" id="skills2" style="text-transform: capitalize;" name="skills" tabindex="9" size="90" placeholder="Enter SKills*" class="ui-autocomplete-input" autocomplete="off" ng-model="user.skills">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group fw">
                                    <span class="select-field-custom">
                                        <select name="industry" id="industry" tabindex="10" ng-model="user.industry">
                                            <option value="" selected="selected" disabled="">Select industry</option>
                                            <?php foreach ($industry as $indu) { ?>
                                            <option value="<?php echo $indu['industry_id']; ?>"><?php echo $indu['industry_name']; ?></option>
                                            <?php } ?>
                                            <option value="<?php echo $other_industry[0]['industry_id']; ?>"><?php echo $other_industry[0]['industry_name']; ?></option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">                                   
                                   <input class="form-control" id="cities2" name="cities" style="text-transform: capitalize;" size="90" tabindex="11" placeholder="Enter Preferred Cites*" class="ui-autocomplete-input" autocomplete="off" ng-model="user.cities" autocomplete="off">
                                   <div id="lotooltip" class="tooltip-custom" style="display: none;">
                                        Enter the location where you want to work
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                   <div class="job_reg text-center">
                                
                                      <!-- <input title="Register" type="submit" id="submit" name="" value="Register" tabindex="12"> -->
                                      <button id="submit" type="submit" name="" class="btn1" tabindex="12">Register<span class="ajax_load pl10" id="jobreg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </form>                     
                </div>
            </div>
        </div>
    </div>
</div>
 <script type="text/javascript" src="<?php echo base_url('assets/js/webpage/job/search_job_reg&skill.js?ver='.time()); ?>"></script>