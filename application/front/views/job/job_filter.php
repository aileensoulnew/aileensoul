<form name="job-company-filter" id="job-company-filter" method="POST">
    <div class="left-search-box">
        <div class="">
            <h3>Top Company</h3>
        </div>
        <ul class="search-listing custom-scroll">
            <?php 
            if(isset($jobCompany) && !empty($jobCompany)):
                foreach($jobCompany as $_jobCompany):
                    $slug = $this->common->clean($_jobCompany['company_name']);  ?>
            <li>                                   
                <label class="control control--checkbox">
                    <span><?php echo ucwords($_jobCompany['company_name']); ?></span>
                    <input type="checkbox" class="company-filter" name="company_id[]" value="<?php echo $_jobCompany['rec_id']; ?>" <?php echo in_array($_jobCompany['rec_id'], $company_id) ? "checked='checked'" : ""; ?> onchange="applyJobFilter()"/>
                    <div class="control__indicator"></div>
                </label>
            </li>
            <?php
                endforeach;
            endif; ?>
        </ul>
        <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-companies">View More Companies</a></p>
    </div>
    <div class="left-search-box">
        <div class="">
            <h3>Top Categories</h3>
        </div>
        <ul class="search-listing custom-scroll">
            <?php
            if(isset($jobCategory) && !empty($jobCategory)):
                foreach($jobCategory as $_jobCategory): ?>
                    <li ng-repeat="category in jobCategory">
                        <label class="control control--checkbox">
                            <span><?php echo ucwords($_jobCategory['industry_name']); ?></span>
                            <input type="checkbox" class="category-filter" name="category_id[]" <?php echo in_array($_jobCategory['industry_id'], $category_id) ? "checked='checked'" : ""; ?>  value="<?php echo $_jobCategory['industry_id']; ?>" onchange="applyJobFilter()"/>
                            <div class="control__indicator"></div>
                        </label>
                    </li>
            <?php
                endforeach;
            endif; ?>
        </ul>
        <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-categories">View More Categories</a></p>
    </div>
    <div class="left-search-box">
        <div class="">
            <h3>Top Cities</h3>
        </div>
        <ul class="search-listing custom-scroll">
            <?php
            if(isset($jobCity) && !empty($jobCity)):
                foreach($jobCity as $_jobCity): ?>
                    <li>
                        <label class="control control--checkbox">
                            <span><?php echo ucwords($_jobCity['city_name']); ?></span>
                            <input type="checkbox" class="location-filter" name="location_id[]" <?php echo in_array($_jobCity['city_id'], $location_id) ? "checked='checked'" : ""; ?> value="<?php echo $_jobCity['city_id']; ?>" onchange="applyJobFilter()"/>
                            <div class="control__indicator"></div>
                        </label>
                    </li>
            <?php 
                endforeach;
            endif; ?>
        </ul>
        <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-location">View More Cities</a></p>
    </div>
    <div class="left-search-box">
        <div class="">
            <h3>Top Skills</h3>
        </div>
        <ul class="search-listing custom-scroll">
            <?php
            if(isset($jobSkill) && !empty($jobSkill)):
                foreach($jobSkill as $_jobSkill): ?>
                    <li ng-repeat="skill in jobSkill">
                        <label class="control control--checkbox">
                            <span ng-bind="skill.skill | capitalize"><?php echo ucwords($_jobSkill['skill']); ?></span>
                            <input type="checkbox" class="skills-filter" name="skill_id[]" value="<?php echo $_jobSkill['skill_id']; ?>" <?php echo in_array($_jobSkill['skill_id'], $skill_id) ? "checked='checked'" : ""; ?> onchange="applyJobFilter()"/>
                            <div class="control__indicator"></div>
                        </label>
                    </li>
            <?php endforeach;
            endif; ?>
        </ul>
        <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-skills">View More Skills</a></p>
    </div>
    <div class="left-search-box">
        <div class="">
            <h3>Top Designation</h3>
        </div>
        <ul class="search-listing custom-scroll">
            <?php
            if(isset($jobDesignation) && !empty($jobDesignation)):
                foreach($jobDesignation as $_jobDesignation): ?>
                    <li ng-repeat="jd in jobDesignation">
                        <label class="control control--checkbox">
                            <span><?php echo ucwords($_jobDesignation['job_title']); ?></span>
                            <input type="checkbox" class="jds-filter" name="job_desc[]" value="<?php echo $_jobDesignation['title_id']; ?>" <?php echo in_array($_jobDesignation['title_id'], $job_desc) ? "checked='checked'" : ""; ?> onchange="applyJobFilter()"/>
                            <div class="control__indicator"></div>
                        </label>
                    </li>
            <?php endforeach;
            endif; ?>
        </ul>
        <p class="text-left p10"><a href="<?php echo base_url(); ?>jobs-by-designations">View More Designation</a></p>
    </div>
    <div class="left-search-box">
        <div class="accordion" id="accordion2">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">Posting Period</a></h3>
                </div>
                <div id="collapseOne" class="accordion-body collapse">
                    <ul class="search-listing">
                        <li>
                            <label class="control control--checkbox">Today
                                <input class="period-filter" type="checkbox" name="period_filter[]" value="1" <?php echo (in_array(1, $period_filter) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Last 7 Days
                                <input class="period-filter" type="checkbox" name="period_filter[]" value="2" <?php echo (in_array(2, $period_filter) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Last 15 Days
                                <input class="period-filter" type="checkbox" name="period_filter[]" value="3" <?php echo (in_array(3, $period_filter) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Last 45 Days
                                <input class="period-filter" type="checkbox" name="period_filter[]" value="4" <?php echo (in_array(4, $period_filter) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">More than 45 Days
                                <input class="period-filter" type="checkbox" name="period_filter[]" value="5" <?php echo (in_array(5, $period_filter) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="left-search-box">
        <div class="accordion" id="accordion3">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsetwo">Experience</a></h3>
                </div>
                <div id="collapsetwo" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <ul class="search-listing">
                            <li>
                                <label class="control control--checkbox">0 to 1 year
                                    <input class="exp-filter" type="checkbox" name="exp_fil[]" value="1" <?php echo (in_array(1, $exp_fil)? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">1 to 2 year
                                    <input class="exp-filter" type="checkbox" name="exp_fil[]" value="2" <?php echo (in_array(2, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">2 to 3 year
                                    <input class="exp-filter" type="checkbox" name="exp_fil[]" value="3" <?php echo (in_array(3, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">3 to 4 year
                                    <input class="exp-filter" type="checkbox" name="exp_fil[]" value="4" <?php echo (in_array(4, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">4 to 5 year
                                    <input class="exp-filter" type="checkbox" name="exp_fil[]" value="5" <?php echo (in_array(5, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">More than 5 year
                                    <input class="exp-filter" type="checkbox" name="exp_fil[]" value="6" <?php echo (in_array(6, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()"/>
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

        </div>
    </div>
</form>