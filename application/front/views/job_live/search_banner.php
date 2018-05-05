<div class="search-banner hidden" ng-controller="searchJobController">
    <div class="container">
        <div class="text-right pt20">
            <!--  -->
            <?php if(!$isjobdeactivate || $isjobdeactivate == false) { ?>
                <a class="btn5" href="<?php echo $job_profile_link; ?>">Create Job Profile</a>
            <?php } else{ ?>
                <a class="btn5" href="<?php echo base_url('job/reactivateacc'); ?>">Reactivate Job Profile</a>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                <div class="search-bnr-text">
                    <h1>Find The Job That Fits Your Life</h1>
                </div>
                <div class="search-box">
                    <form ng-submit="searchSubmit()">
                        <div class="pb20 search-input">
                            <input type="text" ng-model="keyword" id="q" name="q" placeholder="Keywords, Title, or Company" autocomplete="on">
                            <input type="text" ng-model="city" id="l" name="l" placeholder="City, State or Country" autocomplete="on">
                        </div>
                        <div class="pt5">
                            <ul class="work-timing">
                                <li>
                                    <label class="control control--checkbox">Full-Time
                                        <input type="checkbox" ng-model="fulltime" id="fulltime" name="fulltime" value="1"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                                <li>
                                    <label class="control control--checkbox">Part-Time
                                        <input type="checkbox" ng-model="parttime" id="parttime" name="parttime" value="1"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                                <li>
                                    <label class="control control--checkbox">Internship
                                        <input type="checkbox" ng-model="internship" id="internship" name="internship" value="1"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="fw pt20">
                            <input type="submit" class="btn1" name="submit" value="Search">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 right-bnr">
                <img src="n-images/job-bnr.png">
            </div>
        </div>
    </div>
</div>
<div class="search-banner">
    <div class="container">
        <div class="text-right pt20">
            <!--  -->
            <?php if(!$isjobdeactivate || $isjobdeactivate == false) { ?>
                <a class="btn5" href="<?php echo $job_profile_link; ?>">Create Job Profile</a>
            <?php } else{ ?>
                <a class="btn5" href="<?php echo base_url('job/reactivateacc'); ?>">Reactivate Job Profile</a>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
                <div class="search-bnr-text">
                    <h1>Find the Right Job Opportunities</h1>
                    <p>Because Dream Matters </p>
                </div>
                <div class="search-box">
                    <form ng-submit="searchSubmit()">
                        <div class="pb20 search-input">
                            <input type="text" ng-model="keyword" id="q" name="q" placeholder="Job Title, Keywords, or Company" autocomplete="on">
                            <input type="text" ng-model="city" id="l" name="l" placeholder="City, State or Country" class="city-input" autocomplete="on">
                            
                        </div>
                        <div class="pt5 fw pb20">
                            <ul class="work-timing fw">
                                <li>
                                    <label class="control control--checkbox">Full-Time
                                      <input type="checkbox"/>
                                      <div class="control__indicator"></div>
                                    </label>
                                </li>
                                <li>
                                    <label class="control control--checkbox">Part-Time
                                      <input type="checkbox"/>
                                      <div class="control__indicator"></div>
                                    </label>
                                </li>
                                <li>
                                    <label class="control control--checkbox">Internship
                                      <input type="checkbox"/>
                                      <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="fw pt20">
                            <a type="submit" href="#" class="btn1">View More Jobs</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 right-bnr">
                <img src="<?php echo base_url('assets/n-images/job-bnr.png') ?>">
            </div>
        </div>
    </div>
</div>