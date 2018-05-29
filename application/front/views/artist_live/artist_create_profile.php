<div class="">
    <div class="title-div">
        <ul class="nav nav-tabs">
            <li><a href="#">Artistic an Account</a></li>
            <li><a href="#">Artistic Information</a></li>
            <li class="active"><a href="#">Artistic Registration</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="art-registration" class="tab-pane fade final-reg-form  in active">
            <div class="inner-form">
                <div class="login">
                    <div class="title">
                        <h1>Artistic Registration</h1>
                        <p>Create your Artistic Portfolio to show your talent to the world.</p>
                    </div>
                    <form id="artinfo" name="artinfo" ng-submit="submitArtistRegiForm()" ng-validate="artistRegiValidate">
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
                                        Enter a valid email id so that other people can contact you. Also, we will send you to contact recommendations, reminders, and promotional emails on provided email id.
                                    </div>
                                    <label ng-show="errorEmail" class="error">{{errorEmail}}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="phoneno" id="phoneno" tabindex="2" placeholder="Phone Number" maxlength="35" ng-model="user.phoneno">
                                    <div id="pntooltip" class="tooltip-custom" style="display: none;">
                                        Enter a valid phone number so that other people can connect with you.
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group fw">
                                    <span class="select-field-custom">
                                        <select name="skills[]" id="skills" class="multi-select-button" tabindex="10" multiple ng-model="user.skills">
                                            <?php                             
                                            foreach($art_category as $cnt){ 
                                                if($art_category1)
                                                { 
                                                    $category = explode(',' , $art_category1);  
                                                    ?>
                                                    <option value="<?php echo $cnt['category_id']; ?>"
                                                    <?php if(in_array($cnt['category_id'], $category)) echo 'selected';?> onchange="return otherchange(<?php echo $cnt['category_id']; ?>);"><?php echo ucwords(ucfirst($cnt['art_category']));?></option>              
                                                    <?php
                                                }
                                                else
                                                {  
                                                    ?>
                                                    <option value="<?php echo $cnt['category_id']; ?>" onchange="return otherchange(<?php echo $cnt['category_id']; ?>);"><?php echo ucwords(ucfirst($cnt['art_category']));?></option>
                                                    <?php
                                                }       
                                            }
                                            ?>
                                            
                                        </select>
                                    </span>

                                    <div id="other_category" class="other_category" style="display: none;">                                        
                                        <input name="othercategory"  type="text" id="othercategory" tabindex="2" placeholder="Other skill" value="" onkeyup= "return removevalidation();" ng-model="user.othercategory"/>
                                    </div>

                                </div>
                            </div>
                            
                        
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group fw">
                                    <span class="select-field-custom">
                                        <select name="country" id="country" tabindex="10" ng-model="user.country">
                                            <option value="" selected="selected">Select Country*</option>
                                            <?php
                                            if(count($countries) > 0){
                                                foreach($countries as $cnt){  ?>
                                                    <option value="<?php echo $cnt['country_id']; ?>"><?php echo $cnt['country_name'];?></option>
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
                                        <select name="state" id="state" tabindex="10" ng-model="user.state">
                                            <option value="" selected="selected" disabled="">Select State*</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group fw">
                                    <span class="select-field-custom">
                                        <select name="city" id="city" tabindex="10" ng-model="user.city">
                                            <option value="" selected="selected" disabled="">Select City*</option>
                                        </select>
                                    </span>
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
<script src="<?php echo base_url('assets/js/jquery.multi-select.js?ver=' . time()); ?>"></script>
<script type="text/javascript">
    $(function() {
        $('#skills').multiSelect({
            noneText: "Select Category*"
        });
    });
    function otherchange(cat_id) {
        if (cat_id == 26) {
            var active = document.querySelector(".multi-select-container");
            active.classList.remove("multi-select-container--open");
            //$("#other_category").show();
        }
        else
        {
            //$("#other_category").hide();
        }
    }

    $('#country').on('change',function(){ 
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type:'POST',
                url: base_url + "artist/ajax_data",
                //url:'<?php echo base_url() . "artist/ajax_data"; ?>',
                data:'country_id='+countryID,
                success:function(html){
                    $('#state').html(html);
                    $('#city').html('<option value="">Select state first</option>'); 
                }
            }); 
        }else{
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
    
    $('#state').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url: base_url + "artist/ajax_data",
                //url:'<?php echo base_url() . "artist/ajax_data"; ?>',
                data:'state_id='+stateID,
                success:function(html){
                    $('#city').html(html);
                }
            }); 
        }else{
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
</script>