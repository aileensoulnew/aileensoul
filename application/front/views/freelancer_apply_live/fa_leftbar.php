
<form name="job-company-filter" id="job-company-filter">
    
    <div class="left-search-box">
        <div class="">
            <h3>Top Fields</h3>
        </div>
        <ul class="search-listing">
            <li ng-repeat="category in FAFields">
                <label class="control control--checkbox"><span ng-bind="category.category_name | capitalize"></span>
                    <input type="checkbox" class="category-filter" ng-model="cat_fil" name="category[]" ng-value="{{category.category_id}}" ng-change="applyJobFilter()"/>
                    <div class="control__indicator"></div>
                </label>
            </li>
        </ul>
        <p class="text-left p10"><a href="<?php echo base_url(); ?>freelance-jobs-by-fields">View More Fields</a></p>
    </div>
    
    <div class="left-search-box">
        <div class="">
            <h3>Top Categories</h3>
        </div>
        <ul class="search-listing">
            <li ng-repeat="skill in FASkills">
                <label class="control control--checkbox"><span ng-bind="skill.skill | capitalize"></span>
                    <input type="checkbox" class="skills-filter" ng-model="skills_fil" name="skill[]" ng-value="{{skill.skill_id}}" ng-change="applyJobFilter()"/>
                    <div class="control__indicator"></div>
                </label>
            </li>
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
                                <input type="checkbox" ng-value="1" class="worktype-filter" ng-model="worktype1" name="worktype[]" ng-change="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Fixed
                                <input type="checkbox" ng-value="2" class="worktype-filter" ng-model="worktype2" name="worktype[]" ng-change="applyJobFilter()">
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
                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="1" ng-model="post_period1" ng-change="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Last 7 Days
                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="2" ng-model="post_period2" ng-change="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Last 15 Days
                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="3" ng-model="post_period3" ng-change="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">Last 45 Days
                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="4" ng-model="post_period4" ng-change="applyJobFilter()">
                                <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--checkbox">More than 45 Days
                                <input class="period-filter" type="checkbox" name="posting_period[]" ng-value="5" ng-model="post_period5" ng-change="applyJobFilter()">
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
                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="1" ng-model="exp1" ng-change="applyJobFilter()">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">1 to 2 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="2" ng-model="exp2" ng-change="applyJobFilter()">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">2 to 3 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="3" ng-model="exp3" ng-change="applyJobFilter()">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">3 to 4 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="4" ng-model="exp4" ng-change="applyJobFilter()">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">4 to 5 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="5" ng-model="exp5" ng-change="applyJobFilter()">
                                    <div class="control__indicator"></div>
                                </label>
                            </li>
                            <li>
                                <label class="control control--checkbox">More than 5 year
                                    <input class="exp-filter" type="checkbox" name="experience[]" ng-value="6" ng-model="exp6" ng-change="applyJobFilter()">
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