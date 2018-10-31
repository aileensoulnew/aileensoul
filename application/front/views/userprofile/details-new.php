<!--<div class="container pt20 mobp0 detail-page">
    <div class="custom-user-list">
		<div class="tab-add-991 ads">			
		</div>
        <div class="list-box-custom">
            <h3 class="mob-border-top-1">Details</h3>
            <div class="p15 mobp0 fw">
                <div class="detail-box">
                    <h4>Basic Information</h4>
                    <ul>
                        <li><b>Name:</b> <span>{{details_data.first_name}} {{details_data.last_name}}</span></li>
                        <li ng-if="details_data.Designation !==undefined">
                            <b>Designation:</b> <span>{{details_data.Designation}}</span>
                        </li>
                        <li ng-if="details_data.Degree !==undefined"><b>Degree:</b> <span>{{details_data.Degree}}</span></li>
                        <li ng-if="details_data.Industry !==undefined"><b>Field:</b> <span>{{details_data.Industry}}</span></li>
                        <li ng-if="details_data.University !==undefined"><b>University:</b> <span>{{details_data.University}}</span></li>
                        <li ng-if="details_data.interested_fields != ''"><b>Interested Fields:</b> <span>{{details_data.interested_fields}}</span></li>
                        <li><b>City:</b> <span>{{details_data.City}}</span></li>
                        <li><b>DOB:</b> <span>{{details_data.DOB}}</span></li>
                    </ul>

                </div>
            </div>
        </div>
		<div class="tab-add ads">			
		</div>
    </div>
    <div class="right-add">
        <div class="right-add-box">        
        </div>
    </div>
</div> -->

<div class="container mob-plr0 pt20">
    <div class="all-detail-custom">
        <div class="custom-user-list">
            <div class="gallery" id="gallery">
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/edit-profile.png"><span>Profile Overview</span><a href="#" data-target="#profile-overview" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info" ng-if="user_bio == ''">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                            <div class="no-info" ng-if="user_bio != ''">
                                <h4>Description</h4>
                                <p dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_bio}}" dd-text-collapse-cond="true">{{user_bio}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-item edit-profile-move">
                </div>
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>About {{details_data.first_name}}</span><a href="#" data-target="#detail-about" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
                        </div>
                        <div class="dtl-dis about-detail">
                            <div class="no-info" ng-if="about_user_data.user_hobbies == '' && about_user_data.user_fav_quote_headline == '' && about_user_data.user_fav_artist == '' && about_user_data.user_fav_book == '' && about_user_data.user_fav_sport == ''">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                            <div ng-if="about_user_data.user_hobbies != '' || about_user_data.user_fav_quote_headline != '' || about_user_data.user_fav_artist != '' || about_user_data.user_fav_book != '' || about_user_data.user_fav_sport != ''">
                                <div ng-if="user_languages.length > 0">
                                    <h4>Language Known</h4>                                    
                                    <ul class="known-language">
                                        <li ng-repeat="user_lang in user_languages">
                                            <span class="pr5">{{user_lang.language_name}}</span> - <span class="pl5">{{user_lang.proficiency}}</span>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="dis-list">
                                    <li>
                                        <span>Date of Birth</span>
                                        {{details_data.DOB}}
                                    </li>
                                    <li ng-if="about_user_data.user_hobbies != ''">
                                        <span>Hobbies</span>
                                        {{about_user_data.user_hobbies}}
                                    </li>
                                    <li ng-if="about_user_data.user_fav_quote_headline != ''">
                                        <span>Favourite Quotes, Headline</span>
                                        {{about_user_data.user_fav_quote_headline}}
                                    </li>
                                    <li ng-if="about_user_data.user_fav_artist != ''">
                                        <span>Favourite Artist</span>
                                        {{about_user_data.user_fav_artist}}
                                    </li>
                                    <li ng-if="about_user_data.user_fav_book != ''">
                                        <span>Favourite Book</span>
                                        {{about_user_data.user_fav_book}}
                                    </li>
                                    <li ng-if="about_user_data.user_fav_sport != ''">
                                        <span>Favourite Sport</span>
                                        {{about_user_data.user_fav_sport}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/exp.png"><span>Experience({{exp_years}}year {{exp_months}}month)</span><a href="#" ng-click="reset_exp_form()" data-target="#experience" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis" ng-if="user_experience.length < 1">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                        <div class="dtl-dis dis-accor" ng-if="user_experience.length > 1">
                            <div class="panel-group" id="exp-accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default" ng-repeat="user_exp in user_experience" ng-if="$index <= view_more_exp">
                                    <div class="panel-heading" role="tab" id="exp-{{$index}}">
                                        <div class="panel-title">
                                            <div class="dis-left">
                                                <div class="dis-left-img">
                                                    <span>{{user_exp.exp_company_name | limitTo:1 | uppercase}}</span>
                                                </div>
                                            </div>
                                            <div class="dis-middle">
                                                <h4>{{user_exp.exp_company_name}}</h4>
                                                <p>Working as {{user_exp.designation}}</p>
                                            </div>
                                            <div class="dis-right">
                                                <span role="button" ng-click="edit_user_exp($index)" class="pr5">
                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                </span>
                                                <span role="button" data-toggle="collapse" data-parent="#exp-accordion" href="#exp{{$index}}" aria-expanded="true" aria-controls="exp1">
                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                </span>
                                            </div>
         
                                        </div>
                                    </div>
                                    <div id="exp{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="exp-{{$index}}">
                                        <div class="panel-body">
                                            <ul class="dis-list">
                                                <li>
                                                    <span>Time Period</span> 
                                                    <label>{{user_exp.start_date_str}} to</label>
                                                    <label ng-if="user_exp.end_date_str != '' && user_exp.end_date_str != null">{{user_exp.end_date_str}}</label> 
                                                    <label ng-if="user_exp.end_date_str == '' || user_exp.end_date_str == null">Still Working</label>
                                                </li>
                                                <li>
                                                    <span>Company Location</span>
                                                    {{user_exp.city_name}},{{user_exp.state_name}},{{user_exp.country_name}} 
                                                </li>
                                                <li ng-if="user_exp.exp_company_website != '' && user_exp.exp_company_website != null">
                                                    <span>Website</span>
                                                    <a href="{{user_exp.exp_company_website}}" target="_self">{{user_exp.exp_company_website}}</a>
                                                </li>
                                                <li>
                                                    <span>Description</span>
                                                    <label dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_exp.exp_desc}}" dd-text-collapse-cond="true">{{user_exp.exp_desc}}</label>
                                                </li>
                                                <li ng-if="user_exp.exp_file != '' && user_exp.exp_file != null">
                                                    <span>Document</span>
                                                    <p class="screen-shot" check-file-ext check-file="{{user_exp.exp_file}}" check-file-path="<?php echo "'".addslashes(USER_EXPERIENCE_UPLOAD_URL)."'"; ?>">
                                                        <!-- <img src="<?php echo base_url(); ?>assets/n-images/art-img.jpg"> -->
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="about-more">
                                    <a href="#" ng-click="exp_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/edution.png"><span>Educational Info</span><a href="#" data-target="#educational-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis" ng-if="user_education.length < 1">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                        <div class="dtl-dis dis-accor" ng-if="user_education.length > 1">
                            <div class="panel-group" id="edu-accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default" ng-repeat="user_edu in user_education" ng-if="$index <= view_more_edu">
                                    <div class="panel-heading" role="tab" id="edu-{{$index}}">
                                        <div class="panel-title">
                                            <div class="dis-left">
                                                <div class="dis-left-img">
                                                    <span>{{user_edu.edu_school_college | limitTo:1 | uppercase}}</span>
                                                </div>
                                            </div>
                                            <div class="dis-middle">
                                                <h4>{{user_edu.edu_school_college}}</h4>
                                                <p ng-if="user_edu.edu_degree == '0'">{{user_edu.edu_other_degree}}</p>
                                                <p ng-if="user_edu.edu_degree != '0'">{{user_edu.degree_name}}</p>
                                            </div>
                                            <div class="dis-right">
                                                <span role="button" ng-click="edit_user_edu($index)" class="pr5">
                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                </span>
                                                <span role="button" data-toggle="collapse" data-parent="#edu-accordion" href="#edu{{$index}}" aria-expanded="true" aria-controls="exp1">
                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                </span>
                                            </div>
         
                                        </div>
                                    </div>
                                    <div id="edu{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="edu-{{$index}}">
                                        <div class="panel-body">
                                            <ul class="dis-list">
                                                <li>
                                                    <span>Duration</span> 
                                                    <label>{{user_edu.start_date_str}} to</label>
                                                    <label ng-if="user_edu.end_date_str != '' && user_edu.end_date_str != null">{{user_edu.end_date_str}}</label> 
                                                    <label ng-if="user_edu.end_date_str == '' || user_edu.end_date_str == null">Studying</label>
                                                </li>
                                                <li>
                                                    <span>Board / University</span>
                                                    <label ng-if="user_edu.edu_university == '0'">{{user_edu.edu_other_university}}</label>
                                                    <label ng-if="user_edu.edu_university != '0'">{{user_edu.university_name}}</label>
                                                </li>
                                                <li>
                                                    <span>Course / Field of Study / Stream</span>
                                                    <label ng-if="user_edu.edu_stream == '0'">{{user_edu.edu_other_stream}}</label>
                                                    <label ng-if="user_edu.edu_stream != '0'">{{user_edu.stream_name}}</label>
                                                </li>
                                                <li ng-if="user_edu.edu_file != '' && user_edu.edu_file != null">
                                                    <span>Document</span>
                                                    <p class="screen-shot" check-file-ext check-file="{{user_edu.edu_file}}" check-file-path="<?php echo "'".addslashes(USER_EDUCATION_UPLOAD_URL)."'"; ?>">
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="about-more">
                                    <a href="#" ng-click="edu_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/project.png"><span>Project</span><a href="#" data-target="#dtl-project" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis" ng-if="user_projects.length < 1">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                        <div class="dtl-dis dis-accor" ng-if="user_projects.length > 1">
                            <div class="panel-group" id="project-accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default" ng-repeat="user_proj in user_projects" ng-if="$index <= view_more_proj">
                                    <div class="panel-heading" role="tab" id="project-{{$index}}">
                                        <div class="panel-title">
                                            <div class="dis-left">
                                                <div class="dis-left-img">
                                                    <span>{{user_proj.project_title | limitTo:1 | uppercase}}</span>
                                                </div>
                                            </div>
                                            <div class="dis-middle">
                                                <h4>{{user_proj.project_title}}</h4>
                                                <p ng-if="user_proj.project_field == '0'"> {{user_proj.project_other_field}}</p>
                                                <p ng-if="user_proj.project_field != '0'"> {{user_proj.project_field_txt}}</p>
                                            </div>
                                            <div class="dis-right">
                                                <span role="button" ng-click="edit_user_project($index)" class="pr5">
                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/detial-edit.png">
                                                </span>
                                                <span role="button" data-toggle="collapse" data-parent="#project-accordion" href="#project{{$index}}" aria-expanded="true" aria-controls="exp1">
                                                    <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png">
                                                </span>
                                            </div>
         
                                        </div>
                                    </div>
                                    <div id="project{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="project-{{$index}}">
                                        <div class="panel-body">
                                            <ul class="dis-list">
                                                <li ng-if="user_proj.project_url != ''">
                                                    <span>Website</span> 
                                                    <a href="{{user_proj.project_url}}" target="_self">{{user_proj.project_url}}</a>
                                                </li>
                                                <li>
                                                    <span>Duration</span> 
                                                    <label>{{user_proj.start_date_str}} to</label>
                                                    <label ng-if="user_proj.end_date_str != '' && user_proj.end_date_str != null">{{user_proj.end_date_str}}</label> 
                                                    <label ng-if="user_proj.end_date_str == '' || user_proj.end_date_str == null">Still Working</label>
                                                </li>
                                                <li>
                                                    <span>Team Size</span>
                                                    {{user_proj.project_team}}
                                                </li>
                                                <li>
                                                    <span>Your Role</span>
                                                    {{user_proj.project_role}}
                                                </li>
                                                <li ng-if="user_proj.project_partner_name != ''">
                                                    <span>Project Partner</span>
                                                    {{user_proj.project_partner_name}}
                                                </li>
                                                <li>
                                                    <span>Skills Applied</span>
                                                    {{user_proj.project_skills_txt}}
                                                </li>
                                                <li>
                                                    <span>Description</span>
                                                    <label dd-text-collapse dd-text-collapse-max-length="150" dd-text-collapse-text="{{user_proj.project_desc}}" dd-text-collapse-cond="true">{{user_proj.project_desc}}</label>
                                                </li>
                                                <li ng-if="user_proj.project_file != '' && user_proj.project_file != null">
                                                    <span>Project File</span>
                                                    <p class="screen-shot" check-file-ext check-file="{{user_proj.project_file}}" check-file-path="<?php echo "'".addslashes(USER_PROJECT_UPLOAD_URL)."'"; ?>">
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="about-more">
                                    <a href="#" ng-click="proj_view_more()">View More <img src="<?php echo base_url(); ?>assets/n-images/detail/down-arrow.png"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Additional Course</span><a href="#" data-target="#additional-course" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Extracurricular Activity</span><a href="#" data-target="#extra-activity" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Achievements & Awards</span><a href="#" data-target="#Achiv-awards" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Publication</span><a href="#" data-target="#publication" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Patent</span><a href="#" data-target="#patent" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Research</span><a href="#" data-target="#research" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="gallery-item skill-move">
                </div>
                <div class="gallery-item social-link-move">
                </div>
                <div class="gallery-item idol-move">
                </div>
                
            </div>
        </div>
        <div class="right-add">
            <div id="edit-profile-move" class="dtl-box">
                <div class="dtl-title">
                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/e-profile.png"><span>Edit Profile</span>
                </div>
                <div class="dtl-dis">
                    <img src="<?php echo base_url(); ?>assets/n-images/detail/profile-progressbar.jpg">
                </div>
            </div>
            <div id="skill-move" class="dtl-box">
                <div class="dtl-title">
                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/skill.png"><span>Skills</span><a href="#" data-target="#skills" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
                </div>
                <div class="dtl-dis">
                    <div class="no-info" ng-if="user_skills.length < '1'">
                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                        <span>Lorem ipsum its a dummy text.</span>
                    </div>
                    <ul class="skill-list" ng-if="user_skills.length > '0'">
                        <li ng-repeat="skills in user_skills">{{skills.name}}</li>
                    </ul>                    
                </div>
            </div>
            
            <div id="social-link-move" class="dtl-box">
                <div class="dtl-title">
                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Social Links</span><a href="#" data-target="#social-link" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
                </div>
                <div class="dtl-dis">
                    <div class="no-info">
                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                        <span>Lorem ipsum its a dummy text.</span>
                    </div>
                </div>
            </div>
            <div id="idol-move" class="dtl-box">
                <div class="dtl-title">
                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Inspiration</span><a href="#" data-target="#inspiration" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
                </div>
                <div class="dtl-dis">
                    <div class="no-info">
                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                        <span>Lorem ipsum its a dummy text.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- All Model Start -->
<!---  model Profile Overview  -->
<div style="display:none;" class="modal fade dtl-modal" id="profile-overview" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Profile Overview</span>
                </div>
                <div class="dtl-dis">
                    <label>Enter Profile Details</label>
                    <textarea name="user_bio" id="user_bio" ng-model="user_bio" type="text" placeholder="Enter Details">{{user_bio}}</textarea>
                    
                </div>
                <div class="dtl-btn">
                    <a id="user_bio_save" href="#" ng-click="save_user_bio()" class="save"><span>Save</span></a>
                    <img id="user_bio_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                </div>
            </div>  


        </div>
    </div>
</div>

<!---  model About  -->
<div style="display:none;" class="modal fade dtl-modal" id="detail-about" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>About {{details_data.first_name}}</span>
                </div>
                <div class="dtl-dis dtl-about-box post-field">
                    <div class="fw pb20">
                        <div class="row">
                            <div class="">
                                <div class="width-45">
                                    <div class="form-group">
                                        <label>Language</label>
                                        <!-- <input type="text" placeholder="Language" class="language" name="language"> -->
                                        <input type="text" name="language" ng-model="language[100].lngtxt" ng-keyup="get_languages(100)" class="form-control language" placeholder="Language"  id="language" typeahead="item as item.language_name for item in lang_search_result | filter:$viewValue"  autocomplete="off" ng-value="primari_lang.language_name" value="{{primari_lang.language_name}}">
                                    </div>
                                </div>
                                <div class="width-45">
                                    <div class="form-group">
                                        <label>Proficiency</label>
                                        <span class="span-select">
                                            <select class="proficiency" name="proficiency">
                                                <option value="Basic" ng-selected="primari_lang.proficiency == 'Basic'">Basic</option>
                                                <option value="Intermediate" ng-selected="primari_lang.proficiency == 'Intermediate'">Intermediate</option>
                                                <option value="Expert" ng-selected="primari_lang.proficiency == 'Expert'">Expert</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="" data-ng-repeat="field in languageSet.language track by $index">
                                <!-- <form class="frm_language" name="frm_language" id="frm_language" action="javascript:void(0);" method="post"> -->
                                    <div class="width-45">
                                        <div class="form-group">
                                            <label>Language</label>
                                            <!-- <input type="text" placeholder="Language" class="language" name="language"> -->
                                            <input type="text" name="language" ng-model="language[$index].lngtxt" ng-keyup="get_languages($index)" class="form-control language" placeholder="Language"  id="language" typeahead="item as item.language_name for item in lang_search_result | filter:$viewValue" autocomplete="off" ng-value="field.language_name" value="{{field.language_name}}">
                                        </div>
                                    </div>
                                    <div class="width-45">
                                        <div class="form-group">
                                            <label>Proficiency</label>
                                            <span class="span-select">
                                                <select class="proficiency" name="proficiency">
                                                    <option value="Basic" ng-selected="field.proficiency == 'Basic'">Basic</option>
                                                    <option value="Intermediate" ng-selected="field.proficiency == 'Intermediate'">Intermediate</option>
                                                    <option value="Expert" ng-selected="field.proficiency == 'Expert'">Expert</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="width-10">
                                        <label></label>
                                        <a href="#" class="pull-right" ng-click="removeLanguage($index)"><img class="dlt-img" src="<?php echo base_url(); ?>assets/n-images/detail/dtl-delet.png"></a>
                                    </div>
                                </div>
                                <div class="fw dtl-more-add">
                                    <a href="#" ng-click="addNewLanguage()"><span class="pr10">Add Language </span><img src="<?php echo base_url(); ?>assets/n-images/detail/inr-add.png"></a>
                                </div>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group dtl-dob">
                        <label>Date of Birth</label>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <span class="span-select">
                                    <select id="dob_month" name="month" ng-model="dob_month" ng-change="dob_fnc('','','')">
                                        <option value="">Month</option>
                                        <option value="01">Jan</option>
                                        <option value="02">Feb</option>
                                        <option value="03">Mar</option>
                                        <option value="04">Apr</option>
                                        <option value="05">May</option>
                                        <option value="06">Jun</option>
                                        <option value="07">Jul</option>
                                        <option value="08">Aug</option>
                                        <option value="09">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <span class="span-select">                                    
                                    <select id="dob_day" name="day" ng-model="dob_day" ng-click="dob_error()">
                                    </select>
                                </span>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <span class="span-select">                                    
                                    <select id="dob_year" name="year" ng-model="dob_year" ng-change="dob_fnc('','','')" ng-click="dob_error()">                                        
                                    </select>
                                </span>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <span id="dateerror" class="error" style="display: none;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Hobbies</label>
                        <!-- <input type="text" placeholder="Enter hobbies"> -->
                        <tags-input id="hobby_txt" ng-model="hobby_txt" display-property="hobby" placeholder="Enter hobbies" replace-spaces-with-dashes="false" template="title-template">
                        </tags-input>
                    </div>
                    <div class="form-group">
                        <label>Favourite Quotes, Headline</label>
                        <textarea id="user_fav_quote_headline" ng-model="user_fav_quote_headline" name="user_fav_quote_headline" placeholder="Description (Fav. Quotes, Headline)" ng-bind="about_user_data.user_fav_quote_headline"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Favourite Artist</label>
                        <input id="user_fav_artist" ng-model="user_fav_artist" name="user_fav_artist" type="text" placeholder="Enter artist" ng-value="about_user_data.user_fav_artist">
                    </div>
                    <div class="form-group">
                        <label>Favourite Book</label>
                        <input id="user_fav_book" ng-model="user_fav_book" name="user_fav_book" type="text" placeholder="Enter Book" ng-value="about_user_data.user_fav_book">
                    </div>
                    <div class="form-group">
                        <label>Favourite Sports</label>
                        <input id="user_fav_sport" ng-model="user_fav_sport" name="user_fav_sport" type="text" placeholder="Enter Sports" ng-value="about_user_data.user_fav_sport">
                    </div>
                </div>
                <div class="dtl-btn">                        
                        <a id="save_about_user" href="#" ng-click="save_about_user()" class="save"><span>Save</span></a>
                        <img id="about_user_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                    </div>
            </div>  


        </div>
    </div>
</div>

<!---  model Experience  -->
<div style="display:none;" class="modal fade dtl-modal" id="experience" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" ng-click="reset_exp_form()" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Experience</span>
                </div>
                <form name="experience_form" id="experience_form" ng-validate="experience_validate">
                    <!-- <input type="hidden" name="edit_exp" id="edit_exp" ng-model="edit_exp" ng-value="0"> -->
                    <div class="dtl-dis">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <label>Company Name</label>
                                    <input type="text" placeholder="Enter Company Name" id="exp_company_name" name="exp_company_name" ng-model="exp_company_name">
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label>Designation / Role</label>
                                    <!-- <input type="text" placeholder="Enter Designation"> -->
                                    <tags-input id="exp_designation" name="exp_designation" ng-model="exp_designation" display-property="name" placeholder="Enter Designation" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()" min-length="1" ng-keyup="exp_designation_fnc()">
                                        <auto-complete source="loadJobtitle($query)" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                    </tags-input>                        
                                    <script type="text/ng-template" id="title-template">
                                        <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                    </script>
                                    <script type="text/ng-template" id="title-autocomplete-template">
                                        <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                    </script>
                                    <label id="exp_designation_err" for="exp_designation" class="error" style="display: none;">Please enter designation / role</label>
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <label>Company Website</label>
                                    <input type="text" placeholder="Enter Company Website" id="exp_company_website" name="exp_company_website" ng-model="exp_company_website">
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label>Field </label>
                                    <span class="span-select">
                                        <?php $getFieldList = $this->data_model->getNewFieldList();?>
                                        <select name="exp_field" id="exp_field" ng-model="exp_field" ng-change="other_field_fnc()">
                                            <option value="">Select Field</option>
                                        <?php foreach ($getFieldList as $key => $value) { ?>
                                            <option value="<?php echo $value['industry_id']; ?>""><?php echo $value['industry_name']; ?></option>
                                        <?php } ?>
                                        <option value="0">Other</option>
                                    </select>
                                    </span>
                                </div>
                            </div>
                            <div id="exp_other_field_div" class="row" style="display: none;">
                                <div class="col-md-6 col-sm-6"></div>
                                <div class="col-md-6 col-sm-6">
                                    <label>Other Field</label>
                                    <input type="text" placeholder="Enter Other Field" id="exp_other_field" name="exp_other_field" ng-model="exp_other_field">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Company Location</label>
                            <!-- <input type="text" placeholder="Enter Company Location"> -->
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <span class="span-select">
                                        <select id="exp_country" name="exp_country" ng-model="exp_country" ng-change="exp_country_change()">
                                            <option value="">Select Country</option>         
                                            <option data-ng-repeat='country_item in exp_country_list' value='{{country_item.country_id}}'>{{country_item.country_name}}</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <span class="span-select">
                                        <select id="exp_state" name="exp_state" ng-model="exp_state" ng-change="exp_state_change()" disabled = "disabled">
                                            <option value="">Select State</option>
                                            <option data-ng-repeat='state_item in exp_state_list' value='{{state_item.state_id}}'>{{state_item.state_name}}</option>
                                        </select>
                                        <img id="exp_state_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                    </span>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <span class="span-select">
                                        <select id="exp_city" name="exp_city" ng-model="exp_city" disabled = "disabled">
                                            <option value="">Select City</option>
                                            <option data-ng-repeat='city_item in exp_city_list' value='{{city_item.city_id}}'>{{city_item.city_name}}</option>
                                        </select>
                                        <img id="exp_city_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 6px;right: 19px;display: none;">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <label>Start Date</label>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="exp_s_year" name="exp_s_year" ng-model="exp_s_year" ng-change="exp_start_year();">
                                                    <option value="">Year</option>
                                                    <?php
                                                    $year = date("Y",NOW());
                                                    for ($i=$year; $i >= 1950; $i--) { ?>
                                                        <option value="<?=$i?>"><?=$i?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="exp_s_month" name="exp_s_month" ng-model="exp_s_month">
                                                    <option value="">Month</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div id="exp_end_date" class="col-md-6 col-sm-6" ng-show='!exp_isworking'>
                                    <label>End Date</label>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="exp_e_year" name="exp_e_year" ng-model="exp_e_year">
                                                </select>
                                            </span>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="exp_e_month" name="exp_e_month" ng-model="exp_e_month">
                                                    <option value="">Month</option> 
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <span id="expdateerror" class="error" style="display: none;"></span>
                                </div>
                            </div>
                            <div class="pt10">
                                <label class="control control--checkbox">
                                    <input type="checkbox" ng-model="exp_isworking" id="exp_isworking" class="exp_isworking">I currently working here.
                                    <div class="control__indicator">
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description/Roles and Responsibilities</label>
                            <textarea row="4" type="text" placeholder="Description" id="exp_desc" name="exp_desc" ng-model="exp_desc"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="upload-file">
                                Upload File (work experience certificate) <input type="file" id="exp_file" name="exp_file">
                            </label>
                            <span id="exp_file_error" class="error" style="display: none;"></span>
                        </div>
                    </div>
                    <div class="dtl-btn">
                        <!-- <a href="#" class="save"><span>Save</span></a> -->
                        <a id="save_user_exp" href="#" ng-click="save_user_exp()" class="save"><span>Save</span></a>
                        <img id="user_exp_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!---  model Educational Info  -->
<div style="display:none;" class="modal fade dtl-modal" id="educational-info" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Educational Info</span>
                </div>
                <form name="edu_form" id="edu_form" ng-validate="edu_validate">
                    <div class="dtl-dis">
                        <div class="form-group">
                            <label>School / College Name</label>
                            <input type="text" placeholder="School / College Name" id="edu_school_college" name="edu_school_college" minlength="3" maxlength="200">
                        </div>
                        <div class="form-group">
                            <label>Board / University</label>
                            <select id="edu_university" name="edu_university" ng-model="edu_university" ng-change="edu_university_change();">
                                <option value="">Board / University</option>    
                                <option data-ng-repeat='university_item in university_data' value='{{university_item.university_id}}'>{{university_item.university_name}}</option>
                                <option value="0">Other</option>    
                            </select>
                        </div>
                        <div id="other_university" class="form-group" style="display: none;">
                            <input type="text" placeholder="Other Board / University" id="edu_other_university" name="edu_other_university" maxlength="200" minlength="3">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <label>Degree / Qualification </label>
                                    <!-- <input type="text" placeholder="Degree / Qualification "> -->
                                    <select id="edu_degree" name="edu_degree" ng-model="edu_degree" ng-change="edu_degree_change();">
                                        <option value="">Degree / Qualification</option>    
                                        <option data-ng-repeat='degree_item in degree_data' value='{{degree_item.degree_id}}'>{{degree_item.degree_name}}</option>
                                        <option value="0">Other</option>    
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label>Course / Field of Study / Stream </label>
                                    <!-- <input type="text" placeholder="Course / Field of Study / Stream"> -->
                                    <select id="edu_stream" name="edu_stream" ng-model="edu_stream" ng-change="edu_stream_change()" disabled = "disabled">
                                        <option value="">Course / Field of Study / Stream</option>
                                        <option data-ng-repeat='stream_item in stream_data' value='{{stream_item.stream_id}}'>{{stream_item.stream_name}}</option>
                                    </select>
                                    <img id="edu_stream_loader" src="<?php echo base_url('assets/img/spinner.gif') ?>" style="   width: 20px;position: absolute;top: 33px;right: 33px;display: none;">
                                </div>
                            </div>

                            <div id="other_edu" class="row" style="display: none;">
                                <div class="col-md-6 col-sm-6">
                                    <label>Other Degree / Qualification </label>
                                    <input type="text" placeholder="Degree / Qualification" id="edu_other_degree" name="edu_other_degree">
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label>Other Course / Field of Study / Stream </label>
                                    <input type="text" placeholder="Course / Field of Study / Stream" id="edu_other_stream" name="edu_other_stream">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <label>Start Date</label>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="edu_s_year" name="edu_s_year" ng-model="edu_s_year" ng-change="edu_start_year();">
                                                    <option value="">Year</option>
                                                    <?php
                                                    $year = date("Y",NOW());
                                                    for ($ey=$year; $ey >= 1950; $ey--) { ?>
                                                        <option value="<?=$ey?>"><?=$ey?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="edu_s_month" name="edu_s_month">
                                                    <option value="">Month</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6" ng-show='!edu_nograduate'>
                                    <label>End Date</label>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="edu_e_year" name="edu_e_year" ng-model="edu_e_year">
                                                </select>
                                            </span>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="edu_e_month" name="edu_e_month">
                                                    <option value="">Month</option> 
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <span id="edudateerror" class="error" style="display: none;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control control--checkbox">
                                <input type="checkbox" ng-model="edu_nograduate" id="edu_nograduate" name="edu_nograduate">If You are not graduate click here.
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="upload-file">
                                Upload File (Educational Certificate)<input type="file" id="edu_file" name="edu_file">
                            </label>
                            <span id="edu_file_error" class="error" style="display: none;"></span>
                        </div>                    
                    </div>
                    <div class="dtl-btn">
                        <!-- <a href="#" class="save"><span>Save</span></a> -->
                        <a id="edu_save" href="#" ng-click="save_user_education()" class="save"><span>Save</span></a>
                        <img id="edu_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!---  model Projects  -->
<div style="display:none;" class="modal fade dtl-modal" id="dtl-project" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Projects</span>
                </div>
                <form name="project_form" id="project_form" ng-validate="project_validate">
                <div class="dtl-dis">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Project Name / Title</label>
                                <input type="text" placeholder="Project Name / Title" id="project_title" name="project_title" maxlength="200">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Team Size</label>
                                <input type="text" placeholder="Enter Team size" id="project_team" name="project_team" maxlength="3">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">                            
                            <div class="col-md-6 col-sm-6">
                                <label>Role</label>
                                <input type="text" placeholder="Role" id="project_role" name="project_role" maxlength="200">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Skills Applied</label>
                                <tags-input id="project_skill_list" ng-model="project_skill_list" display-property="name" placeholder="Enter Skills" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()" ng-keyup="project_skills_fnc()">
                                    <auto-complete source="loadSkills($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                                </tags-input>                        
                                <script type="text/ng-template" id="title-template">
                                    <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                                </script>
                                <script type="text/ng-template" id="title-autocomplete-template">
                                    <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                                </script>
                                <label id="project_skill_err" for="project_skill_list" class="error" style="display: none;">Please enter skills</label>
                            </div>
                        </div>
                    </div>                   
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Project Field</label>
                                <span class="span-select">
                                    <?php $getFieldList = $this->data_model->getNewFieldList();?>
                                    <select name="project_field" id="project_field" ng-model="project_field" ng-change="other_project_field_fnc()">
                                            <option value="">Select Field</option>
                                        <?php foreach ($getFieldList as $key => $value) { ?>
                                            <option value="<?php echo $value['industry_id']; ?>""><?php echo $value['industry_name']; ?></option>
                                        <?php } ?>
                                        <option value="0">Other</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Project URL</label>
                                <input type="text" placeholder="Project URL" id="project_url" name="project_url">
                            </div>
                        </div>
                        <div id="proj_other_field_div" class="row" style="display: none;">
                            <div class="col-md-6 col-sm-6">
                                <label>Other Field</label>
                                <input type="text" placeholder="Enter Other Field" id="project_other_field" name="project_other_field" maxlength="200">
                            </div>
                            <div class="col-md-6 col-sm-6"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tag Project Partner</label>
                        <!-- <input type="text" placeholder="Tag Project Partner" id="project_partner" name="project_partner"> -->
                        <tags-input id="project_partner" ng-model="project_partner" display-property="p_name" placeholder="Tag Project Partner" replace-spaces-with-dashes="false" template="title-template" min-length="1">
                        </tags-input>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Start Date</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select id="project_s_year" name="project_s_year" ng-model="project_s_year" ng-change="project_start_year();">
                                                <option value="">Year</option>
                                                <?php
                                                $year = date("Y",NOW());
                                                for ($pi=$year; $pi >= 1950; $pi--) { ?>
                                                    <option value="<?=$pi?>"><?=$pi?></option>
                                                <?php
                                                } ?>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select id="project_s_month" name="project_s_month">
                                                <option value="">Month</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>End Date</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select id="project_e_year" name="project_e_year" ng-model="project_e_year">
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select id="project_e_month" name="project_e_month">
                                                <option value="">Month</option> 
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <span id="projdateerror" class="error" style="display: none;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Project Details / Description</label>
                        <textarea type="text" placeholder="Description" id="project_desc" name="project_desc" minlength="50" maxlength="700"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Project certificate) <input type="file" id="project_file" name="project_file">
                        </label>
                        <span id="project_file_error" class="error" style="display: none;"></span>
                    </div>
                </div>
                <div class="dtl-btn">
                    <!-- <a href="#" class="save"><span>Save</span></a> -->
                    <a id="project_save" href="#" ng-click="save_user_project()" class="save"><span>Save</span></a>
                    <img id="prject_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!---  model Additional Course  -->
<div style="display:none;" class="modal fade dtl-modal" id="additional-course" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Additional Course</span>
                </div>
                <form name="addicourse_form" id="addicourse_form" ng-validate="addicourse_validate">
                    <div class="dtl-dis">
                        <div class="form-group">
                            <label>Course Name</label>
                            <input type="text" placeholder="Course Name" id="addicourse_name" name="addicourse_name">
                        </div>
                        <div class="form-group">
                            <label>Organization</label>
                            <input type="text" placeholder="Organization" id="addicourse_org" name="addicourse_org">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <label>Start Date</label>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="addicourse_s_year" name="addicourse_s_year" ng-model="addicourse_s_year" ng-change="addicourse_start_year();">
                                                    <option value="">Year</option>
                                                    <?php
                                                    $year = date("Y",NOW());
                                                    for ($i=$year; $i >= 1950; $i--) { ?>
                                                        <option value="<?=$i?>"><?=$i?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="addicourse_s_month" name="addicourse_s_month">
                                                    <option value="">Month</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label>End Date</label>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="addicourse_e_year" name="addicourse_e_year">
                                                    <option value="">Year</option>                  
                                                </select>
                                            </span>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <span class="span-select">
                                                <select id="addicourse_e_month" name="addicourse_e_month">
                                                    <option value="">Month</option>
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">Jun</option>
                                                    <option value="07">Jul</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <span id="addicoursedateerror" class="error" style="display: none;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" placeholder="Enter URL" id="addicourse_url" name="addicourse_url">
                        </div>
                        
                        <div class="form-group">
                            <label class="upload-file">
                                Upload File (Additional Course Certificate) <input type="file" id="addicourse_file" name="addicourse_file">
                            </label>
                            <span id="addicourse_file_error" class="error" style="display: none;"></span>
                        </div>
                    </div>
                    <div class="dtl-btn">
                        <!-- <a href="#" class="save"><span>Save</span></a> -->
                        <a id="user_addicourse_save" href="#" ng-click="save_user_addicourse()" class="save"><span>Save</span></a>
                        <img id="user_addicourse_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                    </div>
                </form>
            </div>  


        </div>
    </div>
</div>

<!---  model Extracurricular Activity  -->
<div style="display:none;" class="modal fade dtl-modal" id="extra-activity" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Extracurricular Activity</span>
                </div>
                <form name="activity_form" id="activity_form" ng-validate="activity_validate">
                <div class="dtl-dis">
                    <div class="form-group">
                        <label>Participated In</label>
                        <input type="text" placeholder="Participated In" id="activity_participate" name="activity_participate">
                    </div>
                    <div class="form-group">
                        <label>Organization</label>
                        <input type="text" placeholder="Organization" id="activity_org" name="activity_org">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Start Date</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select id="activity_s_year" name="activity_s_year" ng-model="activity_s_year" ng-change="activity_start_year();">
                                                <option value="">Year</option>
                                                <?php
                                                $year = date("Y",NOW());
                                                for ($i=$year; $i >= 1950; $i--) { ?>
                                                    <option value="<?=$i?>"><?=$i?></option>
                                                <?php
                                                } ?>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select id="activity_s_month" name="activity_s_month">
                                                <option value="">Month</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>End Date</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select id="activity_e_year" name="activity_e_year">
                                                <option value="">Year</option>                  
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select id="activity_e_month" name="activity_e_month">
                                                <option value="">Month</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <span id="activitydateerror" class="error" style="display: none;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" placeholder="Description" id="activity_desc" name="activity_desc"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Extracurricular Activity Certificate) <input type="file" id="activity_file" name="activity_file">
                        </label>
                        <span id="activity_file_error" class="error" style="display: none;"></span>
                    </div>
                    
                </div>
                <div class="dtl-btn">
                    <!-- <a href="#" class="save"><span>Save</span></a> -->
                    <a id="user_activity_save" href="#" ng-click="save_user_activity()" class="save"><span>Save</span></a>
                    <img id="user_activity_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!---  model Achievements & Awards  -->
<div style="display:none;" class="modal fade dtl-modal" id="Achiv-awards" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Achievements & Awards</span>
                </div>
                <form name="award_form" id="award_form" ng-validate="award_validate">
                <div class="dtl-dis">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" placeholder="Title" id="award_title" name="award_title">
                    </div>
                    <div class="form-group">
                        <label>Organization</label>
                        <input type="text" placeholder="Organization" id="award_org" name="award_org">
                    </div>
                    <div class="form-group">
                        <label>Achievements & Awards Date</label>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <span class="span-select">
                                    <select id="award_month" name="award_month" ng-model="award_month" ng-change="award_date_fnc('','','')">
                                        <option value="">Month</option>
                                        <option value="01">Jan</option>
                                        <option value="02">Feb</option>
                                        <option value="03">Mar</option>
                                        <option value="04">Apr</option>
                                        <option value="05">May</option>
                                        <option value="06">Jun</option>
                                        <option value="07">Jul</option>
                                        <option value="08">Aug</option>
                                        <option value="09">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <span class="span-select">
                                    <select id="award_day" name="award_day" ng-model="award_day" ng-click="award_error()"></select>
                                </span>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <span class="span-select">
                                    <select id="award_year" name="award_year" ng-model="award_year" ng-change="award_date_fnc('','','')" ng-click="award_error()">
                                    </select>
                                </span>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <span id="awarddateerror" class="error" style="display: none;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" placeholder="Description" id="award_desc" name="award_desc"></textarea>
                    </div>                    
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Achievements & Awards Certificate) <input type="file" id="award_file" name="award_file">
                            <span id="award_file_error" class="error" style="display: none;"></span>
                        </label>
                    </div>
                    
                </div>
                <div class="dtl-btn">
                    <!-- <a href="#" class="save"><span>Save</span></a> -->
                    <a id="user_award_save" href="#" ng-click="save_user_award()" class="save"><span>Save</span></a>
                    <img id="user_award_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!---  model Publication  -->
<div style="display:none;" class="modal fade dtl-modal" id="publication" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Publication</span>
                </div>
                <form name="publication_form" id="publication_form" ng-validate="publication_validate">
                <div class="dtl-dis">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" placeholder="Title" id="pub_title" name="pub_title" minlength="3" maxlength="200">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Author</label>
                                <input type="text" placeholder="Author" id="pub_author" name="pub_author"  minlength="3" maxlength="200">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>URL</label>
                                <input type="text" placeholder="URL" id="pub_url" name="pub_url" maxlength="200">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Publisher / Publication</label>
                        <input type="text" placeholder="Publisher / Publication" id="pub_publisher" name="pub_publisher" minlength="3" maxlength="200">
                    </div>
                    
                    <div class="form-group">
                        <label>Publication Date</label>                            
                        <div class="row">                            
                            <div class="col-md-4 col-sm-4">
                                <span class="span-select">
                                    <select id="publication_month" name="publication_month" ng-model="publication_month" ng-change="publication_date_fnc('','','')">
                                        <option value="">Month</option>
                                        <option value="01">Jan</option>
                                        <option value="02">Feb</option>
                                        <option value="03">Mar</option>
                                        <option value="04">Apr</option>
                                        <option value="05">May</option>
                                        <option value="06">Jun</option>
                                        <option value="07">Jul</option>
                                        <option value="08">Aug</option>
                                        <option value="09">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <span class="span-select">
                                    <select id="publication_day" name="publication_day" ng-model="publication_day" ng-click="publication_error()"></select>
                                </span>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <span class="span-select">
                                    <select id="publication_year" name="publication_year" ng-model="publication_year" ng-change="publication_date_fnc('','','')" ng-click="publication_error()">
                                    </select>
                                </span>
                            </div>                            
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" placeholder="Description" id="pub_desc" name="pub_desc" minlength="10" maxlength="700"></textarea>
                    </div>                    
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Publication Certificate) <input type="file" id="pub_file" name="pub_file">
                        </label>
                        <span id="pub_file_error" class="error" style="display: none;">File size must be less than 5MB.</span>
                    </div>                    
                </div>
                <div class="dtl-btn">
                    <!-- <a href="#" class="save"><span>Save</span></a> -->
                    <a id="user_publication_save" href="#" ng-click="save_user_publication()" class="save"><span>Save</span></a>
                    <img id="user_publication_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!---  model Patent  -->
<div style="display:none;" class="modal fade dtl-modal" id="patent" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Patent</span>
                </div>
                <form name="patent_form" id="patent_form" ng-validate="patent_validate">
                    <div class="dtl-dis">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <label>Patent Title</label>
                                    <input type="text" placeholder="Patent Title" id="patent_title" name="patent_title">
                                </div>                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <label>Patent Creator / Innovator</label>
                                    <input type="text" placeholder="Patent Creator / Innovator" id="patent_creator" name="patent_creator">
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label>Patent Number</label>
                                    <input type="text" placeholder="Patent Number" id="patent_number" name="patent_number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Patent Date</label>
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <span class="span-select">
                                        <select id="patent_month" name="patent_month" ng-model="patent_month" ng-change="patent_date_fnc('','','')">
                                            <option value="">Month</option>
                                            <option value="01">Jan</option>
                                            <option value="02">Feb</option>
                                            <option value="03">Mar</option>
                                            <option value="04">Apr</option>
                                            <option value="05">May</option>
                                            <option value="06">Jun</option>
                                            <option value="07">Jul</option>
                                            <option value="08">Aug</option>
                                            <option value="09">Sep</option>
                                            <option value="10">Oct</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dec</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <span class="span-select">
                                        <select id="patent_day" name="patent_day" ng-model="patent_day" ng-click="patent_date_error()"></select>
                                    </span>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <span class="span-select">
                                        <select id="patent_year" name="patent_year" ng-model="patent_year" ng-change="patent_date_fnc('','','')" ng-click="patent_date_error()">
                                        </select>
                                    </span>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <span id="recdateerror" class="error" style="display: none;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <label>Patent Office</label>
                                    <input type="text" placeholder="Patent Office" id="patent_office" name="patent_office">
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label>Patent URL</label>
                                    <input type="text" placeholder="Patent URL" id="patent_url" name="patent_url">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" placeholder="Description" id="patent_desc" name="patent_desc"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="upload-file">
                                Upload File <input type="file" id="patent_file" name="patent_file">
                                <span id="patent_file_error" class="error" style="display: none;">File size must be less than 5MB.</span>
                            </label>
                        </div>                        
                    </div>
                    <div class="dtl-btn">
                        <!-- <a href="#" class="save"><span>Save</span></a> -->
                        <a id="user_patent_save" href="#" ng-click="save_user_patent()" class="save"><span>Save</span></a>
                        <img id="user_patent_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!---  model Research  -->
<div style="display:none;" class="modal fade dtl-modal" id="research" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Research</span>
                </div>
                    <form name="research_form" id="research_form" ng-validate="research_validate">
                        <div class="dtl-dis">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" placeholder="Title" id="research_title" name="research_title" ng-model="research_title" minlength="20" maxlength="200">
                            </div>
                            <div class="form-group">
                                <label>Details</label>
                                <textarea placeholder="Details" id="research_desc" name="research_desc" ng-model="research_desc" minlength="20" maxlength="700"></textarea>
                            </div>
                            <div class="form-group">
                                <label>URL</label>
                                <input type="text" placeholder="URL" id="research_url" name="research_url" ng-model="research_url">
                            </div>
                            
                            <div class="form-group">
                                <label>Publishing Date</label>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4">
                                        <span class="span-select">
                                            <select id="research_month" name="research_month" ng-model="research_month" ng-change="research_pub_fnc('','','')">
                                                <option value="">Month</option>
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jul</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <span class="span-select">
                                            <select id="research_day" name="research_day" ng-model="research_day" ng-click="research_error()">
                                        </select>                                    
                                        </span>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <span class="span-select">                                            
                                            <select id="research_year" name="research_year" ng-model="research_year" ng-change="research_pub_fnc('','','')" ng-click="research_error()">
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <span id="recdateerror" class="error" style="display: none;"></span>
                                    </div>
                                </div>                            
                            </div>                    
                            
                            <div class="form-group">
                                <label class="upload-file">
                                    Upload File <input type="file" id="research_document" name="research_document">
                                </label>
                            </div>
                        </div>
                        <div class="dtl-btn">
                            <!-- <a href="#" class="save"><span>Save</span></a> -->
                            <a id="user_research_save" href="#" ng-click="save_user_research()" class="save"><span>Save</span></a>
                            <img id="user_research_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                        </div>
                    </form>
            </div>  


        </div>
    </div>
</div>

<!---  model Skills  -->
<div style="display:none;" class="modal fade dtl-modal" id="skills" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Skills</span>
                </div>
                <div class="dtl-dis post-field">
                    <div class="form-group">
                        <label>Skills</label>
                        <!-- <input type="text" placeholder="Enter Skills"> -->
                        <tags-input id="user_skill_list" ng-model="edit_user_skills" display-property="name" placeholder="Enter Skills" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()">
                            <auto-complete source="loadSkills($query)" min-length="0" load-on-focus="false" load-on-empty="false" max-results-to-show="32" template="title-autocomplete-template"></auto-complete>
                        </tags-input>                        
                        <script type="text/ng-template" id="title-template">
                            <div class="tag-template"><div class="right-panel"><span>{{$getDisplayText()}}</span><a class="remove-button" ng-click="$removeTag()">&#10006;</a></div></div>
                        </script>
                        <script type="text/ng-template" id="title-autocomplete-template">
                            <div class="autocomplete-template"><div class="right-panel"><span ng-bind-html="$highlight($getDisplayText())"></span></div></div>
                        </script>
                    </div>
                </div>
                <div class="dtl-btn">                        
                    <a id="user_skills_save" href="#" ng-click="save_user_skills()" class="save"><span>Save</span></a>
                    <img id="user_skills_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                </div>
            </div>  


        </div>
    </div>
</div>

<!---  model Inspiration  -->
<div style="display:none;" class="modal fade dtl-modal" id="inspiration" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Inspiration</span>
                </div>
                <form name="idol_form" id="idol_form" ng-validate="idol_validate">
                    <div class="dtl-dis">
                        <div class="form-group">
                            <label class="upload-file">
                                Upload File (Photo of your inspiration)<input type="file" id="user_idol_file" name="user_idol_file">
                            </label>
                            <span id="user_idol_file_error" class="error" style="display: none;">File size must be less than 5MB.</span>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" placeholder="Enter Name" id="user_idol_name" name="user_idol_name">
                        </div>
                    </div>
                    <div class="dtl-btn">
                        <!-- <a href="#" class="save"><span>Save</span></a> -->
                        <a id="user_idol_save" href="#" ng-click="save_user_idol()" class="save"><span>Save</span></a>
                        <img id="user_idol_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!---  model Social Links  -->
<div style="display:none;" class="modal fade dtl-modal" id="social-link" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Social Links</span>
                </div>
                <div class="dtl-dis">
                    <div class="fw pb20">
                        
                        <div class="row">
                            <div class="">
                                <div class="" data-ng-repeat="field in social_linksset.social_links track by $index">
                                <div class="col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Website</label>
                                        <span class="span-select">
                                            <select id="link_type{{$index}}" name="link_type" class="link_type">
                                                <option value="Facebook" ng-selected="field.user_links_type == 'Facebook'">Facebook</option>
                                                <option value="Google" ng-selected="field.user_links_type == 'Google'">Google</option>
                                                <option value="Instagram" ng-selected="field.user_links_type == 'Instagram'">Instagram</option>
                                                <option value="LinkedIn" ng-selected="field.user_links_type == 'LinkedIn'">LinkedIn</option>
                                                <option value="Pinterest" ng-selected="field.user_links_type == 'Pinterest'">Pinterest</option>
                                                <option value="GitHub" ng-selected="field.user_links_type == 'GitHub'">GitHub</option>
                                                <option value="Twitter" ng-selected="field.user_links_type == 'Twitter'">Twitter</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label>URL</label>
                                        <input type="text" placeholder="URL" id="link_url{{$index}}" class="link_url" name="link_url" ng-keyup="check_socialurl($index)" ng-value="field.user_links_txt">
                                    </div>
                                </div>
                                
                                <div class="col-md-1 col-sm-1 pl0">
                                    <label></label>
                                    <a href="#" class="pull-right" ng-click="removeSocialLinks()"><img class="dlt-img" src="<?php echo base_url(); ?>assets/n-images/detail/dtl-delet.png"></a>
                                </div>
                                </div>
                                <div class="fw dtl-more-add" id="add-new-link">
                                    <a href="#" ng-click="addNewSocialLinks()"><span class="pr10">Add Social Links</span><img src="<?php echo base_url(); ?>assets/n-images/detail/inr-add.png"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div data-ng-repeat="field in personal_linksset.personal_links track by $index">
                            <div class="form-group">
                                <div class="col-md-11 col-sm-11">
                                    <label>Add Personal Website</label>
                                    <input type="text" placeholder="Add Personal Website" id="personal_link_url{{$index}}" class="personal_link_url" name="personal_link_url" ng-keyup="check_personalurl($index)" ng-value="field.user_links_txt">
                                    <span class="personal-link-info">Add http:// or https:// before link</span>
                                </div>
                                <div class="col-md-1 col-sm-1 pl0">
                                    <label></label>
                                    <a href="#" class="pull-right" ng-click="removePersonalLinks()"><img class="dlt-img" src="<?php echo base_url(); ?>assets/n-images/detail/dtl-delet.png"></a>
                                </div>
                            </div>
                        </div>
                        <div id="add-personla-link" class="fw dtl-more-add pt15">
                            <a href="#" ng-click="addNewPersonalLinks()"><span class="pr10">Add Personal Website Links </span>
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/inr-add.png">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="dtl-btn">
                        <!-- <a href="#" class="save"><span>Save</span></a> -->
                        <a id="user_links_save" href="#" ng-click="save_user_links()" class="save"><span>Save</span></a>
                        <img id="user_links_loader" src="<?php echo base_url(); ?>assets/images/loader.gif" alt="Loader" style="display: none;padding: 16px 15px 15px;">
                    </div>
            </div>  


        </div>
    </div>
</div>

<!-- All Model End 