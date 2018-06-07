<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="#">Create an Account</a></li>
            <li class="active"><a href="#">Basic Information</a></li>
            <li><a href="#" ng-click="submitStudentInfoForm()">Job Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="basic-information" class="tab-pane fade in active">            
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Educational Information</h1>
                    </div>
                    <form name="studentinfo" id="studentinfo"class="" ng-submit="submitStudentInfoForm()" ng-validate="studentInfoValidate">
                        <div class="form-group">
                            <label for="text">What are you studying right now?<font color="red">*</font></label>
                            <input type="text" name="currentStudy" id="currentStudy" class="form-control" placeholder="Pursuing: Engineering, Medicine, Desiging, MBA, Accounting, BA, 10th.." ng-keyup="currentStudy()" ng-model="user.currentStudy" typeahead="item as item.degree_name for item in degreeSearchResult | filter:$viewValue" autocomplete="off">
                            <div id="cstooltip" class="tooltip-custom" style="display: none;">
                                Enter the current qualification that you are pursuing like 10 th , 12 th , B.E, BCA, Medical, MBA
                            </div>
                            <label ng-show="errorcurrentStudy" class="error">{{errorcurrentStudy}}</label>
                        </div>
                        <div class="form-group">
                            <label for="text">Where are you from?<font color="red">*</font></label>
                            <input type="text" name="city" id="city" class="form-control" placeholder="Enter your city name"  ng-keyup="cityList()" ng-model="user.cityList" typeahead="item as item.city_name for item in citySearchResult | filter:$viewValue" autocomplete="off">
                            <label ng-show="errorcityList" class="error">{{errorcityList}}</label>
                        </div>
                        <div class="form-group">
                            <label for="text">University / Collage / School<font color="red">*</font> </label>
                            <input type="text" name="university" id="university" class="form-control" placeholder="Enter your University / Collage / school" ng-model="user.universityName" ng-keyup="universityList()" typeahead="item as item.university_name for item in universitySearchResult | filter:$viewValue" autocomplete="off">
                            <label ng-show="erroruniversityName" class="error">{{erroruniversityName}}</label>
                        </div>
                        <div class="form-group">
                            <label for="text">Interested field<font color="red">*</font></label>
                            <input type="text" name="jobTitle" id="jobTitle" class="form-control"placeholder="Ex:Seeking Opportunity,CEO, Enterpreneur, Founder, Singer, Photographer.." ng-keyup="jobTitle()" ng-model="user.jobTitle" typeahead="item as item.name for item in titleSearchResult | filter:$viewValue" autocomplete="off">
                            <div id="iftooltip" class="tooltip-custom" style="display: none;">
                                Enter the field name in which you want to make your career.
                            </div>
                            <label ng-show="errorjobTitle" class="error">{{errorjobTitle}}</label>
                        </div>
                        <p class="text-center submit-btn">
                            <a href="<?php echo base_url();?>job-profile/basic-info" class="btn-back">Back</a>

                            <button type="submit" id="submit" class="btn1">Next 123<span class="ajax_load" id="student_info_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>