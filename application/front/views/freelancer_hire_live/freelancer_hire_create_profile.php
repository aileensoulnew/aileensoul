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
                    <form id="freelancehireinfo" name="freelancehireinfo" ng-submit="submitFreelancehireRegiForm()" ng-validate="freelancehireRegiValidate" >
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
                                
                                      <!-- <input title="Register" type="submit" id="submit" name="" value="Register" tabindex="12"> -->
                                      <button id="submit" name="" class="btn1" tabindex="12">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
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