<div class="container form-radius-new">
	<h2 class="basic-h2"> Let's Complete Your Profile to Get You More New Opportunities.</h2>
    <div class="form-box">
        <h2 class="text-center">Basic Information</h3>
            <form name="basicinfo" id="basicinfo" ng-submit="submitBasicInfoForm()" ng-validate="basicInfoValidate">
                <div class="form-group">
                    <!--<p class="student-or-not">If you are a student then <a data-target="#Student-info" data-toggle="modal" href="javascript:;">Click Here.</a></p>-->
                    <p class="student-or-not">If Student then Make your Profile <a href="educational-information"> Here!</a> 
						
					</p> 
					<p class="student-info-popup">
						<a href="#">
							<svg viewBox="0 0 65 65" xml:space="preserve" width="17px" height="17px">
								<g>
									<g>
										<path d="M32.5,0C14.58,0,0,14.579,0,32.5S14.58,65,32.5,65S65,50.421,65,32.5S50.42,0,32.5,0z M32.5,61C16.785,61,4,48.215,4,32.5    S16.785,4,32.5,4S61,16.785,61,32.5S48.215,61,32.5,61z" fill="#5c5c5c"/>
										<circle cx="33.018" cy="19.541" r="3.345" fill="#5c5c5c"/>
										<path d="M32.137,28.342c-1.104,0-2,0.896-2,2v17c0,1.104,0.896,2,2,2s2-0.896,2-2v-17C34.137,29.237,33.241,28.342,32.137,28.342z    " fill="#5c5c5c"/>
									</g>
								</g>

							</svg>
						</a>
						<span class="student-info-box">
							If you are a student then fill “Educational Information” form to get relevant opportunities based on your interest, or else if you have graduated/working then fill the following form to get appropriate opportunities.
						</span>
					</p>
                </div>

                <div class="form-group">
                    <label for="text">What's your current position?<font color="red">*</font></label>
                    <input type="text" name="jobTitle" id="jobTitle" class="form-control" ng-keyup="jobTitle()" ng-model="user.jobTitle" placeholder="Enter job title / Designation" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="errorjobTitle" class="error">{{errorjobTitle}}</label>
					<div id="jttooltip" class="tooltip-custom" style="display: none;">
                        Enter “seeking opportunity” if you are a fresher else enter your current job title. Ex:Seeking Opportunity / CEO / Entrepreneur / Founder / Singer / Photographer / Developer / HR / BDE / CA / Doctor..
                    </div>
                </div>
                <div class="form-group">
                    <label for="text">What’s your current location?<font color="red">*</font></label>
                    <input type="text" name="city" id="city" class="form-control" ng-keyup="cityList()" ng-model="user.cityList" placeholder="Enter city name" typeahead="item as item.city_name for item in citySearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="errorcityList" class="error">{{errorcityList}}</label>
                </div>
                <div class="form-group cus_field">
                    <label for="text">What is your field?</label>
                    <select name="field" ng-model="user.field" id="field" ng-change="other_field(this)">
                        <option value="" selected="selected">Select field</option>
                        <option data-ng-repeat='fieldItem in fieldList' value='{{fieldItem.industry_id}}'>{{fieldItem.industry_name}}</option>             
                        <option value="0">Other</option>
                    </select>
                    <label ng-show="errorfield" class="error">{{errorfield}}</label>
                </div>
                <div class="form-group" ng-if="user.field == '0'">
                    <label for="text">Other Field</label>
                    <input type="text" class="form-control" ng-model="user.otherField" placeholder="Enter other field" ng-required="true">
                    <label ng-show="errorotherField" class="error">{{errorotherField}}</label>
                </div>
                <p class="text-center submit-btn">
                    <button type="submit" id="submit" class="btn-new-1">Submit<span class="ajax_load" id="basic_info_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                </p>
            </form>
    </div>
</div>
<script>
	$("#jobTitle").focusin(function(){
        $('#jttooltip').show();
    });
    $("#jobTitle").focusout(function(){
        $('#jttooltip').hide();
    });
	
	
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>