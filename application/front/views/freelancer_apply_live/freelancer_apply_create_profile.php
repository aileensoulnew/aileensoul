<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="#">Create an Account</a></li>
            <li><a href="#">Basic Information</a></li>
            <li class="active"><a href="#">Freelancer Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="rec-registration" class="tab-pane fade final-reg-form in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Freelancer Registration</h1>
                        <p>Complete your profile to start getting job recommendation right in your inbox.</p>
                    </div>
                    <form id="freelanceapplyinfo" name="freelanceapplyinfo" ng-submit="submitFreelanceapplyRegiForm()" ng-validate="freelanceapplyRegiValidate" >
                        <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="first_name" id="first_name" tabindex="1" placeholder="First Name*" maxlength="35" ng-model="user.first_name" ng-init="user.first_name ='<?php echo $user_data['first_name']; ?>'">
                                        <label ng-show="errorFname" class="error">{{errorFname}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="last_name" id="last_name" tabindex="2" placeholder="Last Name*" maxlength="35" ng-model="user.last_name" ng-init="user.last_name ='<?php echo $user_data['last_name']; ?>'">
                                        <label ng-show="errorLname" class="error">{{errorLname}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group left-tooltip">
                                        <input class="form-control" type="email" name="email" id="email" tabindex="3" placeholder="Email*" value="" maxlength="255" ng-model="user.email" ng-init="user.email ='<?php echo $user_data['email']; ?>'">
                                        <div id="emtooltip" class="tooltip-custom" style="display: none;">
                                            You will get job recommendations, recruiter messages, reminders, and promotional emails on provided email id
                                        </div>
                                        <label ng-show="errorEmail" class="error">{{errorEmail}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="phoneno" id="phoneno" tabindex="4" placeholder="Phone Number" maxlength="35" ng-model="user.phoneno">
                                        <div id="pntooltip" class="tooltip-custom" style="display: none;">
                                            Enter a valid phone number so that people can contact you for work offers.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="country" id="country" tabindex="5" ng-model="user.country">
                                                <option value="" selected="selected" disabled="">Select Country*</option>
                                                <?php
                                                if (count($countries) > 0) {
                                                    foreach ($countries as $cnt) {
                                                        ?>
                                                        <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="state" id="state" tabindex="6" ng-model="user.state">
                                                <option value="" selected="selected" disabled="">Select State*</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select name="city" id="city" tabindex="7" ng-model="user.city">
                                                <option value="" selected="selected" disabled="">Select City*</option>                                                
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group fw">
                                        <span class="select-field-custom">
                                            <select id="field" name="field" tabindex="8" ng-model="user.field">
                                                <option value="" selected="selected" disabled="">Select Industry*</option>
                                                <?php
                                                if (count($category_data) > 0) {
                                                    foreach ($category_data as $cnt) {
                                                        if ($fields_req1) {
                                                            ?>
                                                            <option value="<?php echo $cnt['category_id']; ?>" <?php if ($cnt['category_id'] == $fields_req1) echo 'selected'; ?>><?php echo $cnt['category_name']; ?></option>

                                                            <?php
                                                        }
                                                        else {
                                                            ?>
                                                            <option value="<?php echo $cnt['category_id']; ?>"><?php echo $cnt['category_name']; ?></option> 
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <option value="<?php echo $category_otherdata[0]['category_id']; ?> "><?php echo $category_otherdata[0]['category_name']; ?></option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group" id="auto_skill">
                                        <input class="form-control" type="text" name="skills" id="skills1" tabindex="9" placeholder="Skills*" maxlength="35"  ng-model="user.skills">
                                        <div id="sktooltip" class="tooltip-custom" style="display: none;">
                                            Enter your best skills to get relevant job offers
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="fw">
                                    <div id="exp_data">
                                        <label class="pl15">Total Experience<span class="red">*</span>:</label>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group fw">
                                                <span class="select-field-custom">
                                                <select tabindex="10" autofocus="" name="experience_year" id="experience_year" class="experience_year keyskil" ng-model="user.experience_year">
                                                    <option value="" selected="" option="" disabled="">Year</option>
                                                    <option value="0 year">0 year</option>
                                                    <option value="1 year">1 year</option>
                                                    <option value="2 year">2 year</option>
                                                    <option value="3 year">3 year</option>
                                                    <option value="4 year">4 year</option>
                                                    <option value="5 year">5 year</option>
                                                    <option value="6 year">6 year</option>
                                                    <option value="7 year">7 year</option>
                                                    <option value="8 year">8 year</option>
                                                    <option value="9 year">9 year</option>
                                                    <option value="10 year">10 year</option>
                                                    <option value="11 year">11 year</option>
                                                    <option value="12 year">12 year</option>
                                                    <option value="13 year">13 year</option>
                                                    <option value="14 year">14 year</option>
                                                    <option value="15 year">15 year</option>
                                                    <option value="16 year">16 year</option>
                                                    <option value="17 year">17 year</option>
                                                    <option value="18 year">18 year</option>
                                                    <option value="19 year">19 year</option>
                                                    <option value="20 year">20 year</option>
                                                </select>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group fw"> 
                                                <span class="select-field-custom">
                                                <select tabindex="11" id="experience_month" class="experience_month keyskil" name="experience_month" ng-model="user.experience_month">
                                                    <option value="" selected="" option="" disabled="">Month</option>    
                                                    <option>0 month</option>
                                                    <option>1 month</option>
                                                    <option>2 month</option>
                                                    <option>3 month</option>
                                                    <option>4 month</option>
                                                    <option>5 month</option>
                                                    <option>6 month</option>
                                                    <option>7 month</option>
                                                    <option>8 month</option>
                                                    <option>9 month</option>
                                                    <option>10 month</option>
                                                    <option>11 month</option>
                                                    <option>12 month</option>
                                                </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                       <div class="job_reg text-center">
                                    
                                          <!-- <input title="Register" type="submit" id="submit" name="" value="Register" tabindex="12"> -->
                                          <button id="submit" name="" class="btn1" tabindex="12">Register<span class="ajax_load pl10" id="profilereg_ajax_load" style="display: none;"><i aria-hidden="true" class="fa fa-spin fa-refresh"></i></span></button>
                                       </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
        /*$(document).bind("keydown","#skills1", function (event) {            
            if (event.keyCode === $.ui.keyCode.TAB &&
                    $(this).autocomplete("instance").menu.active) {
                event.preventDefault();
            }
        })*/

        $("#skills1").autocomplete({ 
                minLength: 2,                
                source: function (request, response) {                     
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "general/get_skill", {term: extractLast($("#skills1").val())}, response);
                     $("#ui-id-1").addClass("autoposition");
                },
                appendTo: $("#auto_skill"),
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {                    
                    var text = $("#skills1").val();
                    var terms = split($("#skills1").val());
                    text = text == null || text == undefined ? "" : text;
                    var checked = (text.indexOf(ui.item.value + ', ') > -1 ? 'checked' : '');
                    if (checked == 'checked') {

                        terms.push(ui.item.value);
                        $("#skills1").val(terms.split(", "));
                    }//if end
                    else {
                        if (terms.length <= 15) {
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push(ui.item.value);
                            // add placeholder to get the comma-and-space at the end
                            terms.push("");
                            $("#skills1").val(terms.join(", "));
                            return false;
                        } else {
                            var last = terms.pop();
                            $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                            $(this).effect("highlight", {}, 1000);
                            $(this).attr("style", "border: solid 1px red;");
                            return false;
                        }
                    }
                }
            });

    $('#country').change(function () {
        var countryID = $(this).val();
        if (countryID) {
            $.ajax({
                type: 'POST',
                url: base_url + "freelancer/ajax_data",
                data: 'country_id=' + countryID,
                success: function (html) {
                    $('#state').html(html);
                    $('#state').removeClass("color-black-custom");
                    $('#city').removeClass("color-black-custom");
                    $('#city').html('<option value="">Select state first</option>');
                }
            });
        } else {
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>');
        }
    });
    $('#state').change(function () {
        var stateID = $(this).val();
        if (stateID) {
            $.ajax({
                type: 'POST',
                url: base_url + "freelancer/ajax_data",
                data: 'state_id=' + stateID,
                success: function (html) {
                    $('#city').html(html);
                     $('#city').removeClass("color-black-custom");
                }
            });
        } else {
            $('#city').html('<option value="">Select state first</option>');
        }
    });
});
</script>