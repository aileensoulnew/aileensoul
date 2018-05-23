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
                        <h1>Educational Information</h1>
                    </div>
                    <form name="studentinfo" id="studentinfo"class="">
                        <div class="form-group">
                            <label for="text">What are you studying right now?<font color="red">*</font></label>
                            <input type="text" name="currentStudy" id="currentStudy" class="form-control" placeholder="Pursuing: Engineering, Medicine, Desiging, MBA, Accounting, BA, 10th..">
                            <label class="error ng-binding ng-hide"></label>
                        </div>
                        <div class="form-group">
                            <label for="text">Where are you from?<font color="red">*</font></label>
                            <input type="text" name="city" id="city" class="form-control" placeholder="Enter your city name">
                            <label ng-show="errorcityList" class="error ng-binding ng-hide"></label>
                        </div>
                        <div class="form-group">
                            <label for="text">University / Collage / School<font color="red">*</font> </label>
                            <input type="text" name="university" id="university" class="form-control" placeholder="Enter your University / Collage / school">
                            <label class="error ng-binding ng-hide"></label>
                        </div>
                        <div class="form-group">
                            <label for="text">Interested field<font color="red">*</font></label>
                            <input type="text" name="jobTitle" id="jobTitle" class="form-control"placeholder="Ex:Seeking Opportunity,CEO, Enterpreneur, Founder, Singer, Photographer..">
                            <label class="error ng-binding ng-hide"></label>
                        </div>
                        <p class="text-center submit-btn">
                            <a href="<?php echo base_url();?>job-profile/basic-info" class="btn1">Back to Basic Infomation</a>

                            <button type="submit" id="submit" class="btn1">Next<span class="ajax_load" id="student_info_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>