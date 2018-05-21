<?php $user_id = $this->session->userdata('aileenuser'); ?>
<div class="search-banner">
    <?php
    if($user_id == ""): ?>
        <header>
            <div class="header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 left-header">
                            <h2 class="logo"><a href="<?php echo base_url(); ?>">Aileensoul</a></h2>
                        </div>
                        <div class="col-md-6 col-sm-6 no-login-right fw-479">
                            <a href="#" class="btn8">Login</a>
                            <a href="#" class="btn9">Create Job Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <?php endif; ?>
    <div class="container">
        <div class="text-right pt20">
            <!--  -->
            <?php if((!$isjobdeactivate || $isjobdeactivate == false) && $job_deactive == 0) { ?>
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
                    <form onsubmit="jobsearchSubmit()" action="javascript:void(0)" method="get">
                        <div class="pb20 search-input">
                            <input type="text" ng-model="keyword" id="job_keyword" name="job_keyword" placeholder="Job Title, Keywords, or Company" autocomplete="off">
                            <input type="text" ng-model="city" id="job_location" name="job_location" placeholder="City, State or Country" class="city-input" autocomplete="off">
                            
                        </div>
                        <div class="pt5 fw pb20">
                            <ul class="work-timing fw">
                                <li>
                                    <label class="control control--checkbox">Full-Time
                                      <input type="checkbox" ng-model="fulltime" name="work_timing[]" class="work_timing-filter" value="1" />
                                      <div class="control__indicator"></div>
                                    </label>
                                </li>
                                <li>
                                    <label class="control control--checkbox">Part-Time
                                      <input class="work_timing-filter" ng-model="parttime" name="work_timing[]" value="2" type="checkbox"/>
                                      <div class="control__indicator"></div>
                                    </label>
                                </li>
                                <li>
                                    <label class="control control--checkbox">Internship
                                      <input  class="work_timing-filter" ng-model="internship" name="work_timing[]" value="3" type="checkbox"/>
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
                <img src="<?php echo base_url('assets/n-images/job-bnr.png') ?>">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8">
function jobsearchSubmit(){
    
        var keyword = $("input[name='job_keyword']").val().toLowerCase().split(' ').join('+');
        var city = $("input[name='job_location']").val().toLowerCase().split(' ').join('+');

        var work_timing_fil = "";
        $('.work_timing-filter').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                work_timing_fil += (work_timing_fil == "") ? currentid : "-" + currentid;
            }
        });        
        // REPLACE , WITH - AND REMOVE IN FROM KEYWORD ARRAY
        var keyworddata = [];
        if(keyword != ""){
            keyworddata = keyword.split(",");
            // remove in from array
            if(keyworddata.indexOf("in") > -1 && city != ""){
                keyworddata.splice(keyworddata.indexOf("in"),1);
            }
            keyword = keyworddata.join('-').toString();
        }
        var citydata = [];
        if(city != ""){
            citydata = city.split(",");
            // remove in from array
            // if(citydata.indexOf("in") > -1 && city != ""){
            //     citydata.splice(citydata.indexOf("in"),1);
            // }
            city = citydata.join('-').toString();
        }

        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            window.location.href = base_url + 'jobs/search/' + keyword + '-jobs?work_timing='+work_timing_fil;
        } else if (keyword == '' && city != '') {
            window.location.href = base_url + 'jobs/search/jobs-in-' + city+'?work_timing='+work_timing_fil;
        } else {
            window.location.href = base_url + 'jobs/search/' + keyword + '-jobs-in-' + city+'?work_timing='+work_timing_fil;
        }
    }
</script>