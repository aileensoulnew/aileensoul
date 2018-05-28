<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="#">Create an Account</a></li>
            <li><a href="#">Basic Information</a></li>
            <li class="active"><a href="#">Business Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="rec-registration" class="tab-pane fade final-reg-form in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Business Registration</h1>
                        <p>Create Your Business Page to Grow Your Online Visibility, Audience, and Network</p>
                    </div>
                    <form id="businessinfo" name="businessinfo" ng-submit="submitBusinessRegiForm()" ng-validate="businessRegiValidate">
                        <div class="row">
                                
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="companyname" id="companyname" tabindex="1" placeholder="Business name*" ng-model="user.companyname">
                                        <span ng-show="errorCompanyName" class="error">{{errorCompanyName}}</span>
                                    </div>
                                </div>
                            
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="country" id="country" tabindex="2" ng-model="user.country" ng-change="onCountryChange()">
                                                <option disabled="" value="" selected="selected">Select Country*</option>
                                                <option data-ng-repeat='countryItem in countryList' value='{{countryItem.country_id}}'>{{countryItem.country_name}}</option>
                                            </select>
                                        </span>
                                        <span ng-show="errorCountry" class="error">{{errorCountry}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="state" ng-change="onStateChange()" id="state" tabindex="3" ng-model="user.state">
                                                <option disabled="" value="" selected="selected">Select State*</option>
                                                <option data-ng-repeat='stateItem in stateList' value='{{stateItem.state_id}}' ng-selected="user.state_id == stateItem.state_id">{{stateItem.state_name}}</option>
                                            </select>
                                        </span>
                                        <span ng-show="errorState" class="error">{{errorState}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="city" id="city" tabindex="4" ng-model="user.city">
                                                <option disabled="" value="" selected="selected">Select City</option>
                                                <option data-ng-repeat='cityItem in cityList' value='{{cityItem.city_id}}'>{{cityItem.city_name}}</option>
                                            </select>
                                        </span>                                        
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="pincode" id="pincode" tabindex="5" placeholder="Enter Pincode" ng-model="user.pincode">                                        
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="business_address" id="business_address" tabindex="6" placeholder="Business Street Address*" ng-model="user.business_address">
                                        <span ng-show="errorBusinessAddress" class="error">{{errorBusinessAddress}}</span>  
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="contactname" id="contactname" tabindex="7" placeholder="Business Owner Name*" ng-model="user.contactname">
                                        <span ng-show="errorContactName" class="error">{{errorContactName}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="contactmobile" id="contactmobile" tabindex="8" placeholder="Phone Number*"  ng-model="user.contactmobile">
                                        <div id="cmtooltip" class="tooltip-custom" style="display: none;">
                                            Enter the main phone number associated with this business so that customers can contact you.
                                        </div>
                                        <span ng-show="errorContactMobile" class="error">{{errorContactMobile}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="email" id="email" tabindex="9" placeholder="Business Email*" ng-model="user.email" >
                                        <span ng-show="errorEmail" class="error">{{errorEmail}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="contactwebsite" id="contactwebsite" tabindex="10" placeholder="Enter Contact Website" ng-model="user.contactwebsite" >
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="business_type" ng-model="user.business_type" ng-change="busSelectCheck(this)" id="business_type" tabindex="11">
                                                <option disabled="" value="" selected="selected">Select Business type*</option>
                                                <option ng-repeat='businessType in business_type' value='{{businessType.type_id}}'>{{businessType.business_name}}</option>             
                                                <option ng-option value="0" id="busOption">Other</option>    
                                            </select>
                                        </span>
                                        <span ng-show="errorBusinessType" class="error">{{errorBusinessType}}</span>
                                    </div>
                                    <div id="busDivCheck" ng-if="user.business_type == '0'">
                                        <div class="form-group">
                                            <input type="text" name="bustype" ng-model="user.bustype" id="bustype" value="" ng-required="true" placeholder="Other business type">
                                            <span ng-show="errorOtherBusinessType" class="error">{{errorOtherBusinessType}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="industriyal" id="industriyal" tabindex="12" ng-model="user.industriyal">
                                                <option value="" disabled="" selected="selected">Select Industry Type*</option>
                                                <option ng-repeat='caegoryType in industry_type' value='{{caegoryType.industry_id}}'>{{caegoryType.industry_name}}</option>
                                                <option ng-option value="0" id="indOption">Other</option>
                                            </select>
                                        </span>
                                         <span ng-show="errorCategory" class="error">{{errorCategory}}</span>
                                    </div>
                                    <div id="indDivCheck" ng-if="user.industriyal == '0'">
                                        <div class="form-group">
                                            <input type="text" name="indtype" ng-model="user.indtype" id="indtype" tabindex="4"  value="" ng-required="true" placeholder="Other Industry">
                                            <span ng-show="errorOtherCategory" class="error">{{errorOtherCategory}}</span>           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="business_details" id="business_details" tabindex="13" placeholder="Business Description*" ng-model="user.business_details"></textarea>
                                        <div id="bdtooltip" class="tooltip-custom" style="display: none;">
                                            Describe your business in more details so that it becomes easy for the customer to know more about your service and product.
                                        </div>
                                        <span ng-show="errorBusinessDetails" class="error">{{errorBusinessDetails}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 bus-upload-img">
                                    <div class="form-group">
                                        <span class="pr15">Business images:</span>
                                        <input type="file" tabindex="14" name="business_image" id="business_image" ng-model="user.business_image" multiple>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                       <div class="job_reg text-center">
                                    
                                          <!-- <input title="Register" type="submit" id="submit" name="" value="Register" tabindex="12"> -->
                                          <button id="submit" name="" class="btn1" tabindex="15">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
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