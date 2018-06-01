<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="#">Create an Account</a></li>
            <li><a href="#">Basic Information</a></li>
            <li class="active"><a href="#">Recruiter Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="rec-registration" class="tab-pane fade final-reg-form in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Recruiter Registration</h1>
                        <p>Complete your profile to connect with job seeker.</p>
                    </div>
                    <form id="recruiterinfo" name="recruiterinfo" ng-submit="submitRecruiterRegiForm()" ng-validate="recruiterRegiValidate">
                        <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="first_name" id="first_name" tabindex="1" placeholder="First Name*" maxlength="35" ng-model="user.first_name" ng-init="user.first_name ='<?php echo $rec_data['first_name']; ?>'">
                                        <label ng-show="errorFname" class="error">{{errorFname}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="last_name" id="last_name" tabindex="2" placeholder="Last Name*" maxlength="35" ng-model="user.last_name" ng-init="user.last_name ='<?php echo $rec_data['last_name']; ?>'">
                                        <label ng-show="errorLname" class="error">{{errorLname}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" type="email" name="email" id="email" tabindex="3" placeholder="Email*" value="" maxlength="255" ng-model="user.email" ng-init="user.email ='<?php echo $rec_data['email']; ?>'">
                                        <div id="emtooltip" class="tooltip-custom" style="display: none;">
                                            You will get candidate recommendations, messages from candidate, reminders, and promotional emails on provided email id.
                                        </div>
                                        <label ng-show="errorEmail" class="error">{{errorEmail}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="company_name" id="company_name" tabindex="4" placeholder="Company Name*" maxlength="35" ng-model="user.company_name">
                                        <label ng-show="errorCN" class="error">{{errorCN}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="company_email" id="company_email" tabindex="5" placeholder="Company Email*" maxlength="35" ng-model="user.company_email">
                                        <div id="cetooltip" class="tooltip-custom" style="display: none;">
                                            Enter a working email id on which candidate can contact you or send emails.
                                        </div>
                                        <label ng-show="errorCE" class="error">{{errorCE}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="company_number" id="company_number" tabindex="6" placeholder="Company Number" maxlength="35" ng-model="user.company_number">
                                    </div>
                                </div>
                            
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="country" id="country" tabindex="7" ng-model="user.country">
                                                <option value="" selected="selected" disabled="">Select Country*</option>
                                                <?php
                                                if (count($countries) > 0) {
                                                    foreach ($countries as $cnt) {
                                                        if ($country1) {
                                                        ?>
                                                            <option value="<?php echo $cnt['country_id']; ?>" <?php if ($cnt['country_id'] == $country1) echo 'selected'; ?>><?php echo $cnt['country_name']; ?></option>

                                                        <?php
                                                        }
                                                        else {
                                                        ?>
                                                            <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name']; ?></option>
                                                        <?php
                                                        }
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
                                            <select name="state" id="state" tabindex="8" ng-model="user.state">
                                                <option value="" selected="selected">Select State*</option>                                                
                                            </select>
                                        </span>
                                        <label ng-show="errorSt" class="error">{{errorSt}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="city" id="city" tabindex="9" ng-model="user.city">
                                                <option value="" selected="selected">Select City</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="company_profile" name="company_profile" tabindex="10" placeholder="Enter Company Profile" maxlength="200" ng-model="user.company_profile"></textarea>
                                        <div id="cptooltip" class="tooltip-custom" style="display: none;">
                                            Describe more in detail about the company background, services, culture, size, website link, etc.
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                       <div class="job_reg text-center">
                                    
                                          <!-- <input title="Register" type="submit" id="submit" name="" value="Register" tabindex="12"> -->
                                          <button id="submit" name="" class="btn1" tabindex="11">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
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