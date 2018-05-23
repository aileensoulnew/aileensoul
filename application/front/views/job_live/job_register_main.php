<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#">Register</a></li>
            <li><a href="<?php echo base_url();?>job-profile/basic-info">Basic Information</a></li>
            <li><a href="<?php echo base_url();?>job-profile/registration">Job Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="register" class="tab-pane fade in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Register</h1>
                    </div>
                    <form name="register_form" id="register_form" method="post" novalidate="novalidate">
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input name="first_name" id="first_name" tabindex="1" class="form-control input-sm" placeholder="First Name*" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input name="last_name" tabindex="2" id="last_name" class="form-control input-sm" placeholder="Last Name*" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input name="email_reg" id="email_reg" tabindex="3" class="form-control input-sm" placeholder="Email Address*" autocomplete="new-email" type="email">
                        </div>
                        <div class="form-group">
                            <input name="password_reg" id="password_reg" tabindex="4" class="form-control input-sm" placeholder="Password*" autocomplete="new-password" type="password">
                        </div>
                        <div class="form-group dob">
                            <label class="d_o_b"> Date Of Birth *:</label>
                            <!--span class="d_o_b">DOB </span-->
                            <span>
                                <select class="day" name="selday" id="selday" tabindex="5">
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
                                <select class="month" name="selmonth" id="selmonth" tabindex="6">
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
                                <select class="year" name="selyear" id="selyear" tabindex="7">
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
                        </div>

                        <div class="form-group gender-custom">
                            <span>
                                <select class="gender" name="selgen" id="selgen" tabindex="8">
                                    <option value="" disabled="" selected="">Gender*</option>
                                    <option value="M">Male</option>
                                    <option value="F">female</option>
                                </select>
                            </span>
                        </div>

                        <p class="clr-c fs12">
                            By Clicking on create an account button you agree our 
                            <a tabindex="10" href="#">Terms and Condition</a> and <a tabindex="11" href="#">Privacy policy</a>.
                        </p>
                        <p class="text-center">
                            <button class="btn1" tabindex="9">Next</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>