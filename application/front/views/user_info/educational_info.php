<div class="container">
	<h2 class="basic-h2"> Let's Complete Your Profile to Get You More New Opportunities.</h2>
    <div class="form-box">
        <h2 class="text-center">Educational Information</h3>
            <form name="studentinfo" id="studentinfo" ng-submit="submitStudentInfoForm()" ng-validate="studentInfoValidate">
                <div class="form-group">
                    <label for="text">What are you studying right now?<font color="red">*</font></label>
                    <input type="text" name="currentStudy" id="currentStudy" class="form-control" placeholder="Pursuing: Engineering, Medicine, Desiging, MBA, Accounting, BA, 5th, 10th, 12th .." ng-keyup="currentStudy()" ng-model="user.currentStudy" typeahead="item as item.degree_name for item in degreeSearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="errorcurrentStudy" class="error">{{errorcurrentStudy}}</label>
					<div id="cstooltip" class="tooltip-custom" style="display: none;">
                        Enter the current qualification that you are pursuing like 10 th , 12 th , B.E, BCA, Medical, MBA
                    </div>
                </div>
                <div class="form-group">
                    <label for="text">Where are you from?<font color="red">*</font></label>
                    <input type="text" name="city" id="city" class="form-control" ng-keyup="cityList()" ng-model="user.cityList" placeholder="Enter city name" typeahead="item as item.city_name for item in citySearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="errorcityList" class="error">{{errorcityList}}</label>
                </div>
                <div class="form-group">
                    <label for="text">University / College / School <font color="red">*</font></label>
                    <input type="text" name="university" id="university" class="form-control" placeholder="Enter University / College / school " ng-model="user.universityName" ng-keyup="universityList()" typeahead="item as item.university_name for item in universitySearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="erroruniversityName" class="error">{{erroruniversityName}}</label>
                </div>
                <!-- <div class="form-group">
                    <label for="text">Interested field<font color="red">*</font></label>
                    <input type="text" name="jobTitle" id="jobTitle" class="form-control" ng-keyup="jobTitle()" ng-model="user.jobTitle" placeholder="Ex: IT, Banking, Medical, CS, Accounting, Media, Marketing, Fitness, Sports.." typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off">
                    <label ng-show="errorjobTitle" class="error">{{errorjobTitle}}</label>
					<div id="iftooltip" class="tooltip-custom" style="display: none;">
                        Enter the field name in which you want to make your career.
                    </div>
                </div> -->
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
					<a class="btn-back" href="basic-information" title="Go to Back"> Back</a>
                    <button type="submit" id="submit" class="btn1">Submit<span class="ajax_load" id="student_info_ajax_load"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                </p>
            </form>
    </div>

</div>
<script>
	$("#currentStudy").focusin(function(){
        $('#cstooltip').show();
    });
    $("#currentStudy").focusout(function(){
        $('#cstooltip').hide();
    });
	$("#jobTitle").focusin(function(){
        $('#iftooltip').show();
    });
    $("#jobTitle").focusout(function(){
        $('#iftooltip').hide();
    });
</script>