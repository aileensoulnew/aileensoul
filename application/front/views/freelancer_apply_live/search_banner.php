<div class="search-banner hidden" ng-controller="searchFreelancerApplyController">
    <div class="container">
        <div class="text-right pt20">
            <?php if($isdeactivatefreelancer){ ?>
                <a class="btn5" href="<?php echo base_url('freelancer/freelancer_post') ?>">Reactivate Freelance Apply Profile</a>
            <?php }else{ ?>
                <a class="btn5" href="<?php echo base_url('freelance-work/registration') ?>">Create Freelance Apply Profile</a>
            <?php } ?>
        </div>
        <div class="search-bnr-text">
            <h1>Lorem Ipsum the dummy text</h1>
        </div>
        <div class="search-box">
            <form ng-submit="searchSubmit()">
                <div class="pb20 search-input">
                    <input type="text" ng-model="keyword" id="q" name="q" placeholder="Keywords, Title, Or Company" autocomplete="off">
                    <input type="text" ng-model="city" id="l" name="q" placeholder="City, State or Country" autocomplete="off">
                    <input type="submit" class="btn1" name="submit" value="Submit">
                </div>
                <div class="pt5">
                    <ul class="work-timing">
                        <li>
                            <label class="control control--checkbox">Full-Time
                                <input ng-model="full_time" name="f" type="checkbox"/>
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Part-Time
                                <input ng-model="part_time" name="p" type="checkbox"/>
                                <div class="control__indicator"></div>
                            </label>
                        </li>

                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- NEW DESIGN -->
<div class="search-banner" ng-controller="searchFreelancerApplyController">
    <div class="container">
        <div class="text-right pt20">
            <?php if($isdeactivatefreelancer){ ?>
                <a class="btn5" href="<?php echo base_url('freelancer/freelancer_post') ?>">Reactivate Freelance Apply Profile</a>
            <?php }else{ ?>
                <a class="btn5" href="<?php echo base_url('freelance-work/registration') ?>">Create Freelance Apply Profile</a>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
                <div class="search-bnr-text">
                    <h1>Work from Anywhere at Any Time</h1>
                    <p>Get the work you love</p>
                </div>
                <div class="search-box">
                    <form ng-submit="searchSubmit()">
                        <div class="pb20 search-input">
                            <input type="text" ng-model="keyword" id="q" name="q" placeholder="Job Title, Keywords, or Skills" autocomplete="off">
                            <input type="text" ng-model="city" id="l" name="q" placeholder="City, State or Country" autocomplete="off" class="city-input">                          
                        </div>
                        <div class="pt5 fw pb20">
                            <ul class="work-timing fw">
                                <li>
                                    <label class="control control--checkbox">Hourly
                                      <input type="checkbox"/>
                                      <div class="control__indicator"></div>
                                    </label>
                                </li>
                                <li>
                                    <label class="control control--checkbox">Fixed
                                      <input type="checkbox"/>
                                      <div class="control__indicator"></div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="fw pt20">
                            <!-- <a href="#" class="btn1">Search Jobs</a> -->
                            <input type="submit" class="btn1" name="submit" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 right-bnr">
                <img src="<?php echo base_url('assets/n-images/free-apply.png') ?>">
            </div>
        </div>
    </div>
</div>