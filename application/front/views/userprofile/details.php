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

<div class="container pt20">
    <div class="row">
        <div class="detail-left">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Profile Overview</span><a href="#" data-target="#profile-overview" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info" ng-if="user_bio == ''">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                            <div class="no-info" ng-if="user_bio != ''">                                
                                <span>{{user_bio}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>About {{details_data.first_name}}</span><a href="#" data-target="#detail-about" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info" ng-if="about_user_data.user_hobbies == '' && about_user_data.user_fav_quote_headline == '' && about_user_data.user_fav_artist == '' && about_user_data.user_fav_book == '' && about_user_data.user_fav_sport == ''">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                            <div class="no-info" ng-if="about_user_data.user_hobbies != '' || about_user_data.user_fav_quote_headline != '' || about_user_data.user_fav_artist != '' || about_user_data.user_fav_book != '' || about_user_data.user_fav_sport != ''">
                                {{about_user_data.user_hobbies}}
                                {{about_user_data.user_fav_quote_headline}}
                                {{about_user_data.user_fav_artist}}
                                {{about_user_data.user_fav_book}}
                                {{about_user_data.user_fav_sport}}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-6">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Experience(4year 5month)</span><a href="#" data-target="#experience" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Educational Info</span><a href="#" data-target="#educational-info" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Project</span><a href="#" data-target="#dtl-project" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
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
                <div class="col-md-6 col-sm-6">
                    <div class="dtl-box">
                        <div class="dtl-title">
                            <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Extracurricular Activity</span><a href="#" data-target="#extra-acticity" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/detail-add.png"></a>
                        </div>
                        <div class="dtl-dis">
                            <div class="no-info">
                                <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                                <span>Lorem ipsum its a dummy text and its user to for all.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
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
                <div class="col-md-6 col-sm-6">
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
                <div class="col-md-6 col-sm-6">
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
                <div class="col-md-6 col-sm-6">
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
                
            </div>
        </div>
        <div class="detail-right">
            <div class="dtl-box">
                <div class="dtl-title">
                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Profile</span>
                </div>
                <div class="dtl-dis">
                    <img src="<?php echo base_url(); ?>assets/n-images/detail/profile-progressbar.jpg">
                    
                </div>
            </div>
            <div class="dtl-box">
                <div class="dtl-title">
                    <img class="cus-width" src="<?php echo base_url(); ?>assets/n-images/detail/about.png"><span>Skills</span><a href="#" data-target="#skills" data-toggle="modal" class="pull-right"><img src="<?php echo base_url(); ?>assets/n-images/detail/edit.png"></a>
                </div>
                <div class="dtl-dis">
                    <div class="no-info" ng-if="user_skills.length < '1'">
                        <img src="<?php echo base_url(); ?>assets/n-images/detail/about.png">
                        <span>Lorem ipsum its a dummy text.</span>
                    </div>
                    <div class="no-info" ng-if="user_skills.length > '0'">                        
                        <span ng-repeat="skills in user_skills">{{skills.name}}</span>
                    </div>
                </div>
            </div>
            
            <div class="dtl-box">
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
            <div class="dtl-box">
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
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Profile Overview</span>
                </div>
                <div class="dtl-dis">
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Company Name</label>
                                <input type="text" placeholder="Enter Company Name">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Designation / Role</label>
                                <input type="text" placeholder="Enter Designation">
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-6 col-sm-6">
                                <label>Company Website</label>
                                <input type="text" placeholder="Enter Company Website">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Field </label>
                                <span class="span-select">
                                    <select>
                                        <option>Select Field</option>
                                        <option>It Field</option>
                                        <option>Design</option>
                                        <option>Advertizing</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Company Location</label>
                        <input type="text" placeholder="Enter Company Location">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Start Date</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
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
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt10">
                            <label class="control control--checkbox">
                                <input type="checkbox">I currently working here.
                                <div class="control__indicator">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description/Roles and Responsibilities</label>
                        <textarea row="4" type="text" placeholder="Description">
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (work experience certificate) <input type="file">
                        </label>
                    </div>
                    
                    
                </div>
                <div class="dtl-btn">
                        <a href="#" class="save"><span>Save</span></a>
                    </div>
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
                <div class="dtl-dis">
                    <div class="form-group">
                        <label>School / College Name</label>
                        <input type="text" placeholder="School / College Name">
                    </div>
                    <div class="form-group">
                        <label>Board / University</label>
                        <input type="text" placeholder="Board / University">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Degree / Qualification </label>
                                <input type="text" placeholder="Degree / Qualification ">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Course / Field of Study / Stream </label>
                                <input type="text" placeholder="Course / Field of Study / Stream">
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
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
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
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control control--checkbox">
                            <input type="checkbox">If You are not graduate click here.
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Educational Certificate)<input type="file">
                        </label>
                    </div>
                    
                </div>
                <div class="dtl-btn">
                        <a href="#" class="save"><span>Save</span></a>
                    </div>
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
                <div class="dtl-dis">
                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-6 col-sm-6">
                                <label>Project Name / Title</label>
                                <input type="text" placeholder="Project Name / Title">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Team Size</label>
                                <input type="text" placeholder="Enter Company Location">
                            </div>
                            
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-6 col-sm-6">
                                <label>Role</label>
                                <input type="text" placeholder="Role">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Skills Applied</label>
                                <input type="text" placeholder="Skills Applied">
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Project Field </label>
                                <span class="span-select">
                                    <select>
                                        <option>Project Field</option>
                                        <option>It Field</option>
                                        <option>Design</option>
                                        <option>Advertizing</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Project URL</label>
                                <input type="text" placeholder="Project URL">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tag Project Partner</label>
                        <input type="text" placeholder="Tag Project Partner">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Start Date</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
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
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Project Details / Description</label>
                        <textarea type="text" placeholder="Description">
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Project certificate) <input type="file">
                        </label>
                    </div>
                    
                </div>
                <div class="dtl-btn">
                        <a href="#" class="save"><span>Save</span></a>
                    </div>
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
                <div class="dtl-dis">
                    <div class="form-group">
                        <label>Course Name</label>
                        <input type="text" placeholder="Course Name">
                    </div>
                    <div class="form-group">
                        <label>Organization</label>
                        <input type="text" placeholder="Organization">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Start Date</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
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
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>URL</label>
                        <input type="text" placeholder="Enter URL">
                    </div>
                    
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Additional Course Certificate) <input type="file">
                        </label>
                    </div>
                    
                </div>
                <div class="dtl-btn">
                        <a href="#" class="save"><span>Save</span></a>
                    </div>
            </div>  


        </div>
    </div>
</div>

<!---  model Extracurricular Activity  -->
<div style="display:none;" class="modal fade dtl-modal" id="extra-acticity" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="modal-close" data-dismiss="modal">×</button>
            <div class="modal-body-cus"> 
                <div class="dtl-title">
                    <span>Extracurricular Activity</span>
                </div>
                <div class="dtl-dis">
                    <div class="form-group">
                        <label>Participated In</label>
                        <input type="text" placeholder="Participated In">
                    </div>
                    <div class="form-group">
                        <label>Organization</label>
                        <input type="text" placeholder="Organization">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Start Date</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
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
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" placeholder="Description"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Extracurricular Activity Certificate) <input type="file">
                        </label>
                    </div>
                    
                </div>
                <div class="dtl-btn">
                        <a href="#" class="save"><span>Save</span></a>
                    </div>
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
                <div class="dtl-dis">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label>Organization</label>
                        <input type="text" placeholder="Organization">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Start Date</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
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
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" placeholder="Description"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Achievements & Awards Certificate) <input type="file">
                        </label>
                    </div>
                    
                </div>
                <div class="dtl-btn">
                        <a href="#" class="save"><span>Save</span></a>
                    </div>
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
                <div class="dtl-dis">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Author</label>
                                <input type="text" placeholder="Author">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>URL</label>
                                <input type="text" placeholder="URL">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Publisher / Publication</label>
                        <input type="text" placeholder="Publisher / Publication">
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Start Date</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
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
                                            <select>
                                                <option>Year</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" placeholder="Description"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Publication Certificate) <input type="file">
                        </label>
                    </div>
                    
                </div>
                <div class="dtl-btn">
                        <a href="#" class="save"><span>Save</span></a>
                    </div>
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
                <div class="dtl-dis">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Patent Title</label>
                                <input type="text" placeholder="Patent Title">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Patent Number</label>
                                <input type="text" placeholder="Patent Number">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Patent Creator / Innovator</label>
                                <input type="text" placeholder="Patent Creator / Innovator">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Patent Status</label>
                                <input type="text" placeholder="Patent Status">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Patent Date</label>
                            
                                
                                <div class="row">
                                    <div class="col-md-4 col-sm-4">
                                        <span class="span-select">
                                            <select>
                                                <option>Date</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <span class="span-select">
                                            <select>
                                                <option>Month</option>
                                                <option>januari</option>
                                                <option>Fabruari</option>
                                                <option>March</option>
                                                <option>April</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <span class="span-select">
                                            <select>
                                                <option>2016</option>
                                                <option>2017</option>
                                                <option>2018</option>
                                                <option>2019</option>
                                                <option>2020</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            
                            
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label>Patent Office</label>
                                <input type="text" placeholder="Patent Office">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label>Patent URL</label>
                                <input type="text" placeholder="Patent URL">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File <input type="file">
                        </label>
                    </div>
                    
                </div>
                <div class="dtl-btn">
                        <a href="#" class="save"><span>Save</span></a>
                    </div>
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
                        <tags-input id="job_title" ng-model="edit_user_skills" display-property="name" placeholder="Enter Skills" replace-spaces-with-dashes="false" template="title-template" on-tag-added="onKeyup()">
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
                <div class="dtl-dis">
                    <div class="form-group">
                        <label class="upload-file">
                            Upload File (Photo of your inspiration) <input type="file">
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" placeholder="Enter Skills">
                    </div>
                </div>
                <div class="dtl-btn">
                        <a href="#" class="save"><span>Save</span></a>
                    </div>
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
                                <div class="col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Website</label>
                                        <span class="span-select">
                                            <select>
                                                <option>Facebook</option>
                                                <option>Google</option>
                                                <option>Instagram</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label>URL</label>
                                        <input type="text" placeholder="URL">
                                    </div>
                                </div>
                                
                                <div class="col-md-1 col-sm-1 pl0">
                                    <label></label>
                                    <a href="#" class="pull-right"><img class="dlt-img" src="<?php echo base_url(); ?>assets/n-images/detail/dtl-delet.png"></a>
                                    
                                </div>
                                <div class="fw dtl-more-add">
                                    <a href="#"><span class="pr10">Add More Links </span><img src="<?php echo base_url(); ?>assets/n-images/detail/inr-add.png"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Add Personal Website</label>
                        <input type="text" placeholder="Add Personal Website">
                        <div class="fw dtl-more-add pt15">
                                    <a href="#"><span class="pr10">Add More Links </span><img src="<?php echo base_url(); ?>assets/n-images/detail/inr-add.png"></a>
                                </div>
                    </div>
                </div>
                <div class="dtl-btn">
                        <a href="#" class="save"><span>Save</span></a>
                    </div>
            </div>  


        </div>
    </div>
</div>

<!-- All Model End