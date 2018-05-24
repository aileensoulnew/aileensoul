<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="#">Create an Account</a></li>
            <li class="active"><a href="#">Basic Information</a></li>
            <li><a href="#" ng-click="submitBasicInfoForm()">Freelancer Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="basic-information" class="tab-pane fade in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Basic Information</h1>
                    </div>
                    <form name="basicinfo" id="basicinfo" class="" ng-submit="submitBasicInfoForm()" ng-validate="basicInfoValidate">
                        <div class="form-group">
                            
                            <p class="student-or-not">If Student then Make your Profile <a href="<?php echo base_url(); ?>freelancer/educational-info">Here!</a> </p>
                        </div>

                        <div class="form-group">
                            <label for="text">Who are you?(Job title)<font color="red">*</font></label>
                                <input type="text" name="jobTitle" ng-model="user.jobTitle" ng-keyup="jobTitle()" class="form-control" placeholder="Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer.."  id="jobTitle" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue"  autocomplete="off">
                                <label ng-show="errorjobTitle" class="error">{{errorjobTitle}}</label>
                                <!-- <label ng-show="errorjobTitle" class="error ng-binding ng-hide"></label> -->
                                <div id="jttooltip" class="tooltip-custom" style="display: none;">
                                    Enter “seeking opportunity” if you are a fresher else enter your current job title.
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="text">What’s your current location?<font color="red">*</font></label>
                            <input type="text" name="city" id="city" class="form-control" placeholder="Enter City Name" ng-keyup="cityList()" ng-model="user.cityList" placeholder="Enter your city name" typeahead="item as item.city_name for item in citySearchResult | filter:$viewValue" autocomplete="off">
                            <label ng-show="errorcityList" class="error">{{errorcityList}}</label>
                            <!-- <label ng-show="errorcityList" class="error ng-binding ng-hide"></label> -->
                        </div>
                        <div class="form-group cus_field">
                            <label for="text">What is your field?<font color="red">*</font></label>
                            <span class="select-field-custom">
                            <select name="field" id="field" ng-model="user.field" class="ng-pristine ng-untouched ng-valid ng-empty">
                                <option value="" selected="selected">Select Field</option>
                                <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>            
                                <option value="0">Other</option>
                            </select>
                            </span>
                            <label ng-show="errorfield" class="error">{{errorfield}}</label>
                            <!-- <label ng-show="errorfield" class="error ng-binding ng-hide"></label> -->
                        </div>
                        <div class="form-group cus_field" ng-if="user.field == '0'">
                            <label for="text">Other Field</label>
                            <input type="text" class="form-control" ng-model="user.otherField" placeholder="Enter other field" ng-required="true">
                            <label ng-show="errorotherField" class="error">{{errorotherField}}</label>
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