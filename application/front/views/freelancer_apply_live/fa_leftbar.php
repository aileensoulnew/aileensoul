<?php
$limit_fs = 10;
// $FAFields = $this->freelancer_apply_model->freelancerFields($limit_fs);
// $FASkills = $this->freelancer_apply_model->get_fa_category($limit_fs)['fa_category'];
?>
<form name="job-company-filter" id="job-company-filter" class="frm-job-company-filter" method="POST">
    
    <div class="left-search-box">
        <div class="">
            <h3>Top Fields</h3>
        </div>
        <ul class="search-listing">
            <?php
            if(isset($FAFields) && !empty($FAFields)):
                foreach($FAFields as $_FAFields): ?>
                    <li>
                        <label class="control control--checkbox">
                            <span><?php echo ucwords($_FAFields['category_name']); ?></span>
                            <input type="checkbox" class="category-filter" name="category[]" value="<?php echo $_FAFields['category_id']; ?>" <?php echo in_array($_FAFields['category_id'], $category_id) ? "checked='checked'" : ""; ?> onchange="applyJobFilter()" ng-click="applyJobFilter()"/>
                            <div class="control__indicator"></div>
                        </label>
                    </li>
            <?php
                endforeach;
            endif; ?>
        </ul>
        <p class="text-left p10"><a href="<?php echo base_url(); ?>freelance-jobs-by-fields">View More Fields</a></p>
    </div>
    
    <div class="left-search-box">
        <div class="">
            <h3>Top Categories</h3>
        </div>
        <ul class="search-listing">
            <?php
            if(isset($FASkills) && !empty($FASkills)):
                foreach($FASkills as $_FASkills): ?>
                    <li>
                        <label class="control control--checkbox">
                            <span><?php echo ucwords($_FASkills['skill']); ?></span>
                            <input type="checkbox" class="skills-filter" name="skill[]" value="<?php echo$_FASkills['skill_id']; ?>" <?php echo in_array($_FASkills['skill_id'], $skill_id) ? "checked='checked'" : ""; ?> onchange="applyJobFilter()" ng-click="applyJobFilter()"/>
                            <div class="control__indicator"></div>
                        </label>
                    </li>
                <?php
                endforeach;
            endif; ?>
        </ul>
        <p class="text-left p10"><a href="<?php echo base_url(); ?>freelance-jobs-by-categories">View More Categories</a></p>
    </div>

    <div class="left-search-box">
        <div class="accordion" id="accordion1">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">Work Type</a></h3>
                </div>
                <div id="collapseOne" class="accordion-body collapse in">
                    <ul class="search-listing">
                        <li>
                            <label class="control control--checkbox">Hourly
                                <input type="checkbox" value="1" class="worktype-filter" ng-model="worktype1" name="worktype[]" <?php echo (in_array(1, $worktype) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Fixed
                                <input type="checkbox" value="2" class="worktype-filter" ng-model="worktype2" name="worktype[]" <?php echo (in_array(2, $worktype) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
    <div class="left-search-box">
        <div class="accordion" id="accordion2">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapsetwo" aria-expanded="true">Posting Period</a></h3>
                </div>
                <div id="collapsetwo" class="accordion-body collapse in" aria-expanded="true" style="">
                    <ul class="search-listing">
                        <li>
                            <label class="control control--checkbox">Today
                                <input class="period-filter" type="checkbox" name="posting_period[]" value="1" <?php echo (in_array(1, $period_filter) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Last 7 Days
                                <input class="period-filter" type="checkbox" name="posting_period[]" value="2" <?php echo (in_array(2, $period_filter) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Last 15 Days
                                <input class="period-filter" type="checkbox" name="posting_period[]" value="3" <?php echo (in_array(3, $period_filter) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Last 45 Days
                                <input class="period-filter" type="checkbox" name="posting_period[]" value="4" <?php echo (in_array(4, $period_filter) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">More than 45 Days
                                <input class="period-filter" type="checkbox" name="posting_period[]" value="5" <?php echo (in_array(5, $period_filter) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
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
                    <h3><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsethree" aria-expanded="true">Required Experience</a></h3>
                </div>
                <div id="collapsethree" class="accordion-body collapse in" aria-expanded="true" style="">
                    <div class="accordion-inner">
                        <ul class="search-listing">
                            <li>
                                <label class="control control--checkbox">0 to 1 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" value="1" <?php echo (in_array(1, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">1 to 2 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" value="2" <?php echo (in_array(2, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">2 to 3 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" value="3" <?php echo (in_array(3, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">3 to 4 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" value="4" <?php echo (in_array(4, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">4 to 5 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" value="5" <?php echo (in_array(5, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">More than 5 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" value="6" <?php echo (in_array(6, $exp_fil) ? "checked='checked'" : ''); ?> onchange="applyJobFilter()" ng-click="applyJobFilter()">
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