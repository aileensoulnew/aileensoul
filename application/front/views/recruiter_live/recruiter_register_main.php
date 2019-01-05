<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li id="ca" class="active"><a href="#">Create an Account</a></li>
            <li><a href="#" ng-click="submitRegiForm()">Basic Information</a></li>
            <li><a href="#" ng-click="submitRegiForm()">Recruiter Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="register" class="tab-pane fade in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Sign Up</h1>
                        <p class="text-center">Let’s quickly create an account to get started.</p>
                    </div>
                    <form name="register_form" id="register_form" ng-submit="submitRegiForm()" ng-validate="regiValidate">
                        <div id="register_error" class="row"></div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input name="first_name" id="first_name" tabindex="1" class="form-control input-sm" placeholder="First Name*" type="text" ng-model="user.first_name">
                                    <label ng-show="errorFname" class="error">{{errorFname}}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input name="last_name" tabindex="2" id="last_name" class="form-control input-sm" placeholder="Last Name*" type="text" ng-model="user.last_name">
                                    <label ng-show="errorLname" class="error">{{errorLname}}</label>
                                </div>
                            </div>
                            <div id="err-res-key" class="err-flname"></div>
                        </div>

                        <div class="form-group">
                            <input name="email_reg" id="email_reg" tabindex="3" class="form-control input-sm" placeholder="Email Address*" autocomplete="new-email" type="email" ng-model="user.email_reg">
                            <label ng-show="errorEmail" class="error">{{errorEmail}}</label>
                        </div>
                        <div class="form-group">
                            <input name="password_reg" id="password_reg" tabindex="4" class="form-control input-sm" placeholder="Password*" autocomplete="new-password" type="password" ng-model="user.password_reg">
                            <label ng-show="errorPassword" class="error">{{errorPassword}}</label>
                        </div>
                        <div class="form-group dob">
                            <label class="d_o_b"> Date Of Birth *:</label>
                            <!--span class="d_o_b">DOB </span-->
                            <span>
                                <select class="day" ng-model="user.selday" name="selday" id="selday" tabindex="5">
                                    <option value="" disabled selected value>Day</option>
                                    <?php
                                    for ($i = 1; $i <= 31; $i++) {
                                    ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                    }
                                    ?>        
                                </select>
                            </span>
                            <span>
                                <select class="month" ng-model="user.selmonth" name="selmonth" id="selmonth" tabindex="6">
                                    <option value="" disabled selected value>Month</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </span>
                            <span>
                                <select class="year" ng-model="user.selyear" name="selyear" id="selyear" tabindex="7">
                                    <option value="" disabled selected value>Year</option>
                                    <?php
                                    for ($i = date('Y'); $i >= 1900; $i--) {
                                    ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </span>
                            <div id="dobtooltip" class="tooltip-custom" style="display: none;">
                                Date of Birth will help us in providing better feeds and opportunity only for you.
                            </div>
                            <label ng-show="errorDob" class="error">{{errorDob}}</label>
                        </div>

                        <div class="form-group gender-custom">
                            <span>
                                <select class="gender" ng-model="user.selgen" name="selgen" id="selgen" tabindex="8">
                                    <option value="" disabled="" selected="">Gender*</option>
                                    <option value="M">Male</option>
                                    <option value="F">female</option>
                                </select>
                                <label ng-show="errorGender" class="error">{{errorGender}}</label>
                            </span>
                        </div>

                        <!-- <p class="clr-c fs12">
                            By Clicking on create an account button you agree our 
                            <a tabindex="10" href="#">Terms and Condition</a> and <a tabindex="11" href="#">Privacy policy</a>.
                        </p> -->
                        <div class="clr-c fs12 form-group term_condi_check">
                            <label id="lbl_term_condi" class="control control--checkbox" for="term_condi">
                                <input tabindex="9" type="checkbox" ng-model="user.term_condi" name="term_condi" id="term_condi" value="1" />
                                I have read and agree to use this website as subjected to Aileensoul 
                                <a tabindex="10" href="<?php echo base_url('terms-and-condition'); ?>">Terms and Condition</a> and <a tabindex="11" href="<?php echo base_url('privacy-policy'); ?>">Privacy policy</a>.
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                        <p class="text-center">
                            <button type="submit" class="btn1" tabindex="12" id="create-account">Create an Account</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>