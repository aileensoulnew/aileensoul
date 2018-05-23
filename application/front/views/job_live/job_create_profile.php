<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="<?php echo base_url();?>job-profile/create-account">Register</a></li>
            <li><a href="<?php echo base_url();?>job-profile/basic-info">Basic Information</a></li>
            <li class="active"><a href="#">Job Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="job-registration" class="tab-pane fade final-reg-form  in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Job Registration</h1>
                    </div>
                    <form id="jobseeker_regform">
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="first_name" id="first_name" tabindex="1" placeholder="Enter your First Name*" maxlength="35">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="last_name" id="last_name" tabindex="2" placeholder="Enter your Last Name*" maxlength="35">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input class="form-control" type="email" name="email" id="email" tabindex="3" placeholder="Enter your Email Address*" value="" maxlength="255">
                                    <a href="#" data-toggle="tooltip" data-placement="left" title="" class="pull-right email-note-cus" data-original-title=" Related notification email will be sent on provided email address kindly use regular email address."><img tooltips="" tooltip-append-to-body="true" tooltip-close-button="true" tooltip-side="right" tooltip-hide-trigger="click" alt="tooltip" src="<?php echo base_url(); ?>assets/img/tooltip.png"></a>
                                    
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group cus-radio-box">
                                    <label>Fresher <font color="red">*</font> : </label>
                                    <div class="main_raio">
                                        <input type="radio" value="Fresher" tabindex="4" id="test1" name="fresher" class="radio_job form-control" onclick="not_experience()">
                                        <label for="test1" class="point_radio">Yes</label>
                                    </div>

                                    <div class="main_raio">
                                        <input  type="radio" value="Experience" tabindex="5" id="test2" class="radio_job form-control" name="fresher" onclick="experience()">
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
                                            <select tabindex="6" autofocus="" name="experience_year" id="experience_year" class="experience_year keyskil" onchange="expyear_change();">
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
                                            <select tabindex="7" id="experience_month" class="experience_month keyskil">
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
                                    <input class="form-control" type="search" tabindex="8" id="job_title" name="job_title" value="" placeholder="Ex:- Sr. Engineer, Jr. Engineer, Software Developer, Account Manager*" style="text-transform: capitalize;" onfocus="this.value = this.value;" maxlength="255" class="ui-autocomplete-input" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input class="form-control" id="skills2" style="text-transform: capitalize;" name="skills" tabindex="9" size="90" placeholder="Enter SKills*" class="ui-autocomplete-input" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group fw">
                                    <span class="select-field-custom">
                                        <select name="industry" id="industry" tabindex="10">
                                            <option value="" selected="selected">Select industry*</option>
                                            <option value="382">Account</option>
                                            <option value="1">Accounting</option>
                                            <option value="303">Accounting-Tax/Consulting</option>
                                            <option value="328">Advertising/PR/Event Management</option>
                                            <option value="351">Agriculture/Forestry/Fishing</option>
                                            <option value="3">Airlines/Aviation</option>
                                            <option value="4">Alternative Dispute Resolution </option>
                                            <option value="5">Alternative Medicine</option>
                                            <option value="343">Analyst</option>
                                            <option value="6">Animation</option>
                                            <option value="7">Apparel &amp; Fashion</option>
                                            <option value="321">Apparel/Garments</option>
                                            <option value="8">Architecture &amp; Interior</option>
                                            <option value="300">Architecture/Interior Design</option>
                                            <option value="9">Arts &amp; Crafts</option>
                                            <option value="314">Automobiles/Auto Component/Auto Ancillary</option>
                                            <option value="10">Automotive</option>
                                            <option value="11">Aviation &amp; Aerospace</option>
                                            <option value="12">Banking</option>
                                            <option value="13">Biotechnology</option>
                                            <option value="304">Biotechnology/Pharmaceutical/Medicine</option>
                                            <option value="14">Brodcast Media</option>
                                            <option value="15">Bulding Materials</option>
                                            <option value="16">Business Supplies &amp; Equipment</option>
                                            <option value="17">Capital Markets</option>
                                            <option value="340">Catering/Food Services/Restaurant</option>
                                            <option value="18">Chemicals</option>
                                            <option value="19">Civic &amp; Social Organization</option>
                                            <option value="20">Civil Engineering</option>
                                            <option value="21">Commercial Real Estate</option>
                                            
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                   
                                   <input class="form-control" id="cities2" name="cities" style="text-transform: capitalize;" size="90" tabindex="11" placeholder="Enter Preferred Cites*" class="ui-autocomplete-input" autocomplete="off">
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