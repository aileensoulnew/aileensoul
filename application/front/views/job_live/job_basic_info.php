<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="<?php echo base_url();?>job-profile/create-account">Register</a></li>
            <li class="active"><a href="#">Basic Information</a></li>
            <li><a href="<?php echo base_url();?>job-profile/registration">Job Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="basic-information" class="tab-pane fade in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Basic Information</h1>
                    </div>
                    <form name="basicinfo" id="basicinfo" class="">
                        <div class="form-group">
                            
                            <p class="student-or-not">If Student then Make your Profile <a href="<?php echo base_url(); ?>job-profile/educational-info">Here!</a> </p>
                        </div>

                        <div class="form-group">
                            <label for="text">Who are you?<font color="red">*</font></label>
                            <input type="text" name="jobTitle" class="form-control" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer.." >
                            <label ng-show="errorjobTitle" class="error ng-binding ng-hide"></label>
                        </div>
                        <div class="form-group">
                            <label for="text">Where are you from?<font color="red">*</font></label>
                            <input type="text" name="city" id="city" class="form-control" placeholder="Enter your city name">
                            <label ng-show="errorcityList" class="error ng-binding ng-hide"></label>
                        </div>
                        <div class="form-group cus_field">
                            <label for="text">What is your field?<font color="red">*</font></label>
                            <span class="select-field-custom">
                            <select name="field" id="field" class="ng-pristine ng-untouched ng-valid ng-empty">
                                <option value="" selected="selected">Select your field</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                                <option value="0">Other</option>
                            </select>
                            </span>
                            <label ng-show="errorfield" class="error ng-binding ng-hide"></label>
                        </div>
                        <!-- ngIf: user.field == '0' -->
                        <p class="text-center submit-btn">
                            <button type="submit" id="submit" class="btn1">Next<span class="ajax_load" id="basic_info_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                        </p>
                    </form>
                </div>
            </div>            
        </div>
    </div>
</div>