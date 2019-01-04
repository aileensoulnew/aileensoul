app.directive('numbersOnly', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attr, ngModelCtrl) {
            function fromUser(text) {
                if (text) {
                    var transformedInput = text.replace(/[^0-9]/g, '');

                    if (transformedInput !== text) {
                        ngModelCtrl.$setViewValue(transformedInput);
                        ngModelCtrl.$render();
                    }
                    return transformedInput;
                }
                return undefined;
            }            
            ngModelCtrl.$parsers.push(fromUser);
        }
    };
});
app.directive('ddTextCollapse', ['$compile', function($compile) {

    return {
        restrict: 'A',
        scope: true,
        link: function(scope, element, attrs) {

            // start collapsed
            scope.collapsed = false;

            // create the function to toggle the collapse
            scope.toggle = function() {
                scope.collapsed = !scope.collapsed;
            };

            // wait for changes on the text
            attrs.$observe('ddTextCollapseText', function(text) {

                // get the length from the attributes
                var maxLength = scope.$eval(attrs.ddTextCollapseMaxLength);
                var condition = scope.$eval(attrs.ddTextCollapseCond);
                

                if (text.length > maxLength) {
                    // split the text in two parts, the first always showing

                    if(/^\<a.*\>.*\<\/a\>/i.test(text))
                    {
                        var start = text.indexOf("<a href");
                        var end = text.indexOf('target="_blank">');
                        element.append(text);
                    }
                    else
                    {
                        var firstPart = String(text).substring(0, maxLength);                    
                        var secondPart = String(text).substring(maxLength, text.length);                    

                        // create some new html elements to hold the separate info
                        var firstSpan = $compile('<span>' + firstPart + '</span>')(scope);
                        var secondSpan = $compile('<span ng-if="collapsed">' + secondPart + '</span>')(scope);
                        var moreIndicatorSpan = $compile('<span ng-if="!collapsed">... </span>')(scope);
                        var lineBreak = $compile('<br ng-if="collapsed">')(scope);
                        if(condition == true)
                        {                        
                            var toggleButton = $compile('<span class="collapse-text-toggle" ng-click="toggle()">{{collapsed ? "" : "View more"}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}
                        }
                        if(condition == false)
                        {                        
                            var toggleButton = $compile('<span class="collapse-text-toggle" ng-click="toggle()">{{collapsed ? "" : ""}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}
                        }

                        // remove the current contents of the element
                        // and add the new ones we created
                        element.empty();
                        element.append(firstSpan);
                        element.append(secondSpan);
                        element.append(moreIndicatorSpan);
                        element.append(lineBreak);
                        element.append(toggleButton);

                    }                    
                }
                else {
                    element.empty();
                    element.append(text);
                }
            });
        }
    };
}]);

app.filter('wordFirstCase', function () {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});
app.controller('freelanceHireProfileController', function ($scope, $http,$compile) {
    var all_months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $scope.all_months = all_months;

    function load_add_detail()
    {
        setTimeout(function(){
            var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo(".dtl-adv");
            $compile($el)($scope);
        },1000);        
    }

    var fh_formdata = new FormData();
    $(document).on('change','#review_file', function(e){
        $("#review_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#review_file_error").html("File size must be less than 10MB.");
            $("#review_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                fh_formdata.append('review_file', $('#review_file')[0].files[0]);
            }
            else {
                $("#review_file_error").html("Invalid file selected.");
                $("#review_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.freelancer_hire_profile_review_validate = {
        rules: {
            review_star: {
                required: true,
            },
            review_desc: {
                required: true,
            },
        },
        messages: {
            review_star: {
                required: "Please select star",
            },
            review_desc: {
                required: "Please enter rating review description",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "review_star") {
                error.insertAfter("#star-rate");
                error.attr("style","display:block !important;")
            } else {
                error.insertAfter(element);
            }
        },
    };

    $scope.save_review = function(){
        if ($scope.freelancer_hire_profile_review.validate())
        {
            $("#review_loader").show();
            $("#save_review").attr("style","pointer-events:none;display:none;");

            fh_formdata.append('from_user_id', from_user_id);
            fh_formdata.append('to_user_id', to_user_id);
            fh_formdata.append('review_star', $('#review_star').val());
            fh_formdata.append('review_star', $('#review_star').val());
            fh_formdata.append('review_desc', $('#review_desc').val());

            $http.post(base_url + 'freelancer_hire_live/save_review', fh_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })            
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                $("#freelancer_hire_profile_review")[0].reset();
                if(success == 1)
                {
                    $("#review_loader").hide();
                    $("#save_review").removeAttr("style");
                    $scope.review_data = result.data.review_data;
                    $scope.review_count = result.data.review_count;
                    $scope.avarage_review = result.data.avarage_review;                
                    setTimeout(function(){
                        // $("#rating-1").val($scope.avarage_review);
                        $("#rating-1").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                        $('#rating-1').rating('update', $scope.avarage_review);
                        $(".user-rating").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                        $("#review-loader").hide();
                        $("#review-body").show();
                    },1000);

                    $("#reviews").modal("hide");
                }
                else if(success == 0)
                {                    
                    $("#reviews").modal("hide");
                }
            });
        }
    };

    $scope.get_review = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer_hire_live/get_review',            
            data: 'to_user_id=' + to_user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.review_data = result.data.review_data;
                $scope.review_count = result.data.review_count;
                $scope.avarage_review = result.data.avarage_review;                
                setTimeout(function(){
                    $("#rating-1").val($scope.avarage_review);
                    $("#rating-1").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                    $(".user-rating").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                    $("#review-loader").hide();
                    $("#review-body").show();
                },1000);
            }
        });
    };


    $scope.get_country = function () {
        $http({
            method: 'GET',
            url: base_url + 'userprofile_page/get_country',
            headers: {'Content-Type': 'application/json'},
        }).then(function (data) {
            $scope.country_list = data.data;
        });
    };
    $scope.get_country();
    //Company Start
    $scope.comp_country_change = function() {
        $("#company_state").attr("disabled","disabled");
        $("#company_state_loader").show();
        var counrtydata = $.param({'country_id': $scope.company_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#company_state").removeAttr("disabled");
            $("#company_city").attr("disabled","disabled");
            $("#company_state_loader").hide();
            $scope.company_state_list = data.data;
            $scope.company_city_list = [];
        });
    };

    $scope.comp_state_change = function() {
        if($scope.company_state != "" && $scope.company_state != 0 && $scope.company_state != null)
        {
            $("#company_city").attr("disabled","disabled");
            $("#company_city_loader").show();
            var statedata = $.param({'state_id': $scope.company_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#company_city").removeAttr("disabled");
                $("#company_city_loader").hide();
                $scope.company_city_list = data.data;
            });
        }
    };

    $scope.get_cmp_company_cont_info = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer_hire_live/get_cmp_company_cont_info',            
            data: 'to_user_id=' + to_user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.cmp_company_cont_info = result.data.cmp_company_cont_info;
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
                $("#cmp-comp-cont-info-loader").hide();
                $("#cmp-comp-cont-info-body").show();
            }
            load_add_detail();
        });
    };

    $scope.get_cmp_company_info = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer_hire_live/get_cmp_company_info',            
            data: 'to_user_id=' + to_user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.cmp_company_info = result.data.cmp_company_info;
                $("#cmp-comp-info-loader").hide();
                $("#cmp-comp-info-body").show();
            }
        });
    };

    $scope.other_field_fnc = function()
    {
        if($scope.company_field == 0 && $scope.company_field != "")
        {
            $("#company_other_field_div").show();
        }
        else
        {
            $("#company_other_field_div").hide();
        }
    };

    $scope.edit_cmp_comp_con_info = function(){
        // console.log($scope.cmp_company_cont_info);
        $("#cmp_company_email").val($scope.cmp_company_cont_info.comp_email);
        $("#cmp_company_number").val($scope.cmp_company_cont_info.comp_number);
        $("#cmp_company_skype").val($scope.cmp_company_cont_info.comp_skype);
        $("#cmp_company_website").val($scope.cmp_company_cont_info.comp_website);

        $scope.company_country = $scope.cmp_company_cont_info.company_country;
        $("#company_country").val($scope.cmp_company_cont_info.company_country);
        // $scope.exp_country_change();
        var counrtydata = $.param({'country_id': $scope.company_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#company_state").removeAttr("disabled");
            $("#company_city").attr("disabled","disabled");
            $("#company_state_loader").hide();
            $scope.company_state_list = data.data;
            $scope.company_city_list = [];
            $scope.company_state = $scope.cmp_company_cont_info.company_state;

            $("#company_city").attr("disabled","disabled");
            $("#company_city_loader").show();
            var statedata = $.param({'state_id': $scope.company_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#company_city").removeAttr("disabled");
                $("#save_cmp_comp_con_info").removeAttr("style");
                $("#company_city_loader").hide();
                $scope.company_city_list = data.data;
                $scope.company_city = $scope.cmp_company_cont_info.company_city;
            });        
        });
    };

    $scope.cmp_comp_con_info_validate = {
        rules: {
            cmp_company_email: {
                required: true,                
                email: true,
                remote: {
                    url: base_url + "freelancer_hire_live/check_email",
                    type: "post",
                    data: {
                      email: function() {
                        return $( "#cmp_company_email" ).val();
                      }
                    }
                },
            },
            cmp_company_number: {
                required: true,
                number:true,
            },
            company_country: {
                required: true,
            },
            company_state: {
                required: true,
            },
            company_city: {
                required: true,
            },
        },
    };
    $scope.save_cmp_comp_con_info = function(){
        if ($scope.cmp_comp_con_info_form.validate())
        {
            $("#cmp_comp_con_info_loader").show();
            $("#save_cmp_comp_con_info").attr("style","pointer-events:none;display:none;");
            var cmp_company_email = $("#cmp_company_email").val();
            var cmp_company_number = $("#cmp_company_number").val();
            var cmp_company_skype = $("#cmp_company_skype").val();
            var cmp_company_website = $("#cmp_company_website").val();
            var company_country = $("#company_country option:selected").val();
            var company_state = $("#company_state option:selected").val();
            var company_city = $("#company_city option:selected").val();

            var updatedata = $.param({
                "cmp_company_email":cmp_company_email,
                "cmp_company_number":cmp_company_number,
                "cmp_company_skype":cmp_company_skype,
                "cmp_company_website":cmp_company_website,
                "company_country":company_country,
                "company_state":company_state,
                "company_city":company_city
            });

            $http({
                method: 'POST',
                url: base_url + 'freelancer_hire_live/save_cmp_comp_con_info',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {                    
                    $scope.cmp_company_cont_info = result.data.cmp_company_cont_info;                    
                }
                $("#save_cmp_comp_con_info").removeAttr("style");
                $("#cmp_comp_con_info_loader").hide();
                $("#com-contact-info").modal('hide');
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
            });
        }
    };

    $scope.load_skills = [];
    $scope.loadSkills = function ($query) {
        return $http.get(base_url + 'job/get_skills', {cache: true}).then(function (response) {
            var load_skills = response.data;
            return load_skills.filter(function (title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.comp_founded_year_change = function(userMonth){        
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();
        if($scope.comp_founded_month == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }

        var month_opt = "<option value=''>Select Month</option>";
        for (var j = 0; j <= mm; j++) {
            if(parseInt(j + 1) == userMonth)
            {
                month_opt += "<option value='"+parseInt(j + 1)+"' selected>"+all_months[j]+"</option>";
            }
            else
            {
                month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
            }
        }
        var elmonth = $('#comp_founded_month');
        elmonth.html($compile(month_opt)($scope));
    };

    $scope.edit_cmp_comp_info = function(){
        $("#comp_name").val($scope.cmp_company_info.comp_name);
        $("#company_field").val($scope.cmp_company_info.company_field);
        $scope.company_field = $scope.cmp_company_info.company_field;
        if($scope.cmp_company_info.company_field == 0)
        {
            $("#company_other_field_div").show();
        }
        $("#comp_team").val($scope.cmp_company_info.comp_team);

        var comp_skill_offer = "";
        if($scope.cmp_company_info.comp_skills_offer_txt.trim() != "")
        {
            var comp_skill_offer = $scope.cmp_company_info.comp_skills_offer_txt.split(',');
        }
        var edit_comp_skill_offer = [];
        if(comp_skill_offer.length > 0)
        {                    
            comp_skill_offer.forEach(function(element,skillIndex) {
              edit_comp_skill_offer[skillIndex] = {"name":element};
            });
        }
        $scope.comp_skills_offer = edit_comp_skill_offer;
        if($scope.cmp_company_info.comp_founded_year > 0)
        {
            $("#comp_founded_year").val($scope.cmp_company_info.comp_founded_year);
            $scope.comp_founded_year_change();
        }

        if($scope.cmp_company_info.comp_founded_month > 0)
        {            
            $("#comp_founded_month").val($scope.cmp_company_info.comp_founded_month);
        }

        if($scope.cmp_company_info.comp_overview != "")
        {
            $("#comp_overview").val($scope.cmp_company_info.comp_overview);
            $scope.comp_overview = $scope.cmp_company_info.comp_overview;
        }

        if($scope.cmp_company_info.comp_service_offer != "")
        {
            $("#comp_service_offer").val($scope.cmp_company_info.comp_service_offer);
            $scope.comp_service_offer = $scope.cmp_company_info.comp_service_offer;
        }

        if($scope.cmp_company_info.comp_exp_year > 0)
        {
            $("#comp_exp_year").val($scope.cmp_company_info.comp_exp_year);
        }

        if($scope.cmp_company_info.comp_exp_month > 0)
        {
            $("#comp_exp_month").val($scope.cmp_company_info.comp_exp_month);
        }
        var logo_old = $scope.cmp_company_info.comp_logo;
        $scope.comp_logo_old = logo_old;
        if(logo_old.trim() != "")
        {
            var filename_arr = logo_old.split('.');
            // console.log(filename_arr);
            //console.log(filename_arr[filename_arr.length - 1]);
            $("#exp_doc_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="exp_doc_prev" class="screen-shot"><a href="'+job_user_experience_upload_url+exp_file_name+'" target="_blank"><img style="width: 100px;" src="'+job_user_experience_upload_url+exp_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="exp_doc_prev" class="screen-shot"><a class="file-preview-cus" href="'+free_hire_comp_logo_upload_url+logo_old+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#comp_logo_error"));
            $compile(contentTr)($scope);
        }

    };

    var fh_comp_formdata = new FormData();
    $(document).on('change','#comp_logo', function(e){
        $("#comp_logo_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#comp_logo_error").html("File size must be less than 10MB.");
            $("#comp_logo_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                fh_comp_formdata.append('comp_logo', $('#comp_logo')[0].files[0]);
            }
            else {
                $("#comp_logo_error").html("Invalid file selected.");
                $("#comp_logo_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.cmp_comp_info_validate = {
        rules: {
            comp_name: {
                required: true,
            },
            company_field: {
                required: true,
            },
            company_other_field: {
                required: {
                    depends: function(element) {
                        return $("#company_field option:selected").val() == 0 ? true : false;
                    }
                },
            },
            comp_team: {
                required: true,
            },
            comp_founded_year: {
                required: true,
            },
            comp_founded_month: {
                required: true,
            },
            comp_overview: {
                required: true,
            },
            comp_service_offer: {
                required: true,
            },
            comp_exp_year: {
                required: true,
            },
            comp_exp_month: {
                required: true,
            },
        },
    };

    $scope.validate_comp_skills = function(){        
        if($scope.comp_skills_offer == "" || $scope.comp_skills_offer == undefined)
        {
            $("#comp_skills_offer .tags").attr("style","border:1px solid #ff0000;");
            /*setTimeout(function(){
                $("#exp_designation_err").attr("style","display:block;");            
            },100);*/
            return false;
        }
        else
        {
            return true;
        }
    };

    $scope.comp_skills_fnc = function(){
        // $("#exp_designation input").removeClass("error");
        $("#comp_skills_offer .tags").removeAttr("style");        
    };

    $scope.save_cmp_comp_info = function(){
        var comp_skills = $scope.validate_comp_skills();
        if ($scope.cmp_comp_info_form.validate() && comp_skills)
        {
            $("#cmp_comp_info_loader").show();
            $("#save_cmp_comp_info").attr("style","pointer-events:none;display:none;");
            
            fh_comp_formdata.append('comp_name', $('#comp_name').val());
            fh_comp_formdata.append('comp_logo_old', $scope.comp_logo_old);
            fh_comp_formdata.append('company_field', $('#company_field option:selected').val());
            fh_comp_formdata.append('company_other_field', $('#company_other_field').val());
            fh_comp_formdata.append('comp_skills_offer', JSON.stringify($scope.comp_skills_offer));
            fh_comp_formdata.append('comp_team', $('#comp_team').val());
            fh_comp_formdata.append('comp_founded_year', $('#comp_founded_year option:selected').val());
            fh_comp_formdata.append('comp_founded_month', $('#comp_founded_month option:selected').val());
            fh_comp_formdata.append('comp_overview', $('#comp_overview').val());
            fh_comp_formdata.append('comp_service_offer', $('#comp_service_offer').val());
            fh_comp_formdata.append('comp_exp_year', $('#comp_exp_year option:selected').val());
            fh_comp_formdata.append('comp_exp_month', $('#comp_exp_month option:selected').val());

            $http.post(base_url + 'freelancer_hire_live/save_cmp_comp_info', fh_comp_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                $("#cmp_comp_info_form")[0].reset();
                if(success == 1)
                {
                    $("#cmp_comp_info_loader").hide();
                    $("#save_cmp_comp_info").removeAttr("style");                    
                    $scope.cmp_company_info = result.data.cmp_company_info;
                    $("#com-info").modal("hide");
                    var profile_progress = result.data.profile_progress;
                    var count_profile_value = profile_progress.user_process_value;
                    var count_profile = profile_progress.user_process;
                    $scope.progress_status = profile_progress.progress_status;
                    $scope.set_progress(count_profile_value,count_profile);
                }
                else if(success == 0)
                {                    
                    $("#com-info").modal("hide");
                }
            });
        }
    };
    //Company End

    //Indiviaul Start
    $scope.individual_country_change = function() {
        $("#individual_state").attr("disabled","disabled");
        $("#individual_state_loader").show();
        var counrtydata = $.param({'country_id': $scope.individual_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#individual_state").removeAttr("disabled");
            $("#individual_city").attr("disabled","disabled");
            $("#individual_state_loader").hide();
            $scope.individual_state_list = data.data;
            $scope.individual_city_list = [];
        });
    };

    $scope.individual_state_change = function() {
        if($scope.individual_state != "" && $scope.individual_state != 0 && $scope.individual_state != null)
        {
            $("#individual_city").attr("disabled","disabled");
            $("#individual_city_loader").show();
            var statedata = $.param({'state_id': $scope.individual_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#individual_city").removeAttr("disabled");
                $("#individual_city_loader").hide();
                $scope.individual_city_list = data.data;
            });
        }
    };

    $scope.other_individual_comp_industry = function(){
        if($scope.individual_comp_industry == 0 && $scope.individual_comp_industry != "")
        {
            $("#individual_other_field_div").show();
        }
        else
        {
            $("#individual_other_field_div").hide();
        }
    };

    $scope.get_individual_company_info = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer_hire_live/get_individual_company_info',            
            data: 'to_user_id=' + to_user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.individual_company_info = result.data.individual_company_info;
                $("#individual-comp-info-loader").hide();
                $("#individual-comp-info-body").show();
            }
        });
    };

    $scope.edit_individual_comp_info = function(){
        $("#individual_comp_name").val($scope.individual_company_info.comp_name);
        $scope.individual_comp_industry = $scope.individual_company_info.company_field;
        $("#individual_comp_industry").val($scope.individual_company_info.company_field);
        if($scope.individual_comp_industry == '0')
        {
            $("#individual_other_field_div").show();
            $("#individual_other_comp_industry").val($scope.individual_company_info.company_other_field)
        }

        $("#individual_comp_overview").val($scope.individual_company_info.comp_overview);
        $scope.individual_comp_overview = $scope.individual_company_info.comp_overview;

        $scope.individual_country = $scope.individual_company_info.country;
        $("#individual_country").val($scope.individual_company_info.country);
        // $scope.exp_country_change();
        var counrtydata = $.param({'country_id': $scope.individual_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#individual_state").removeAttr("disabled");
            $("#individual_city").attr("disabled","disabled");
            $("#individual_state_loader").hide();
            $scope.individual_state_list = data.data;
            $scope.individual_city_list = [];
            $scope.individual_state = $scope.individual_company_info.state;

            $("#individual_city").attr("disabled","disabled");
            $("#individual_city_loader").show();
            var statedata = $.param({'state_id': $scope.individual_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#individual_city").removeAttr("disabled");
                $("#save_individual_comp_info").removeAttr("style");
                $("#individual_city_loader").hide();
                $scope.individual_city_list = data.data;
                $scope.individual_city = $scope.individual_company_info.city;
            });        
        });
    };

    $scope.individual_comp_info_validate = {
        rules: {
            individual_comp_name: {
                required: true,
            },
            individual_comp_industry: {
                required: true,
            },
            individual_other_comp_industry: {
                required: {
                    depends: function(element) {
                        return $("#individual_comp_industry option:selected").val() == 0 ? true : false;
                    }
                },
            },
            individual_comp_overview: {
                required: true,
            },
            individual_country: {
                required: true,
            },
            individual_state: {
                required: true,
            },
            individual_city: {
                required: true,
            },
        },
    };
    $scope.save_individual_comp_info = function(){
        if ($scope.individual_comp_info_form.validate())
        {
            $("#individual_comp_info_loader").show();
            $("#save_individual_comp_info").attr("style","pointer-events:none;display:none;");
            var individual_comp_name = $("#individual_comp_name").val();
            var individual_comp_industry = $("#individual_comp_industry option:selected").val();
            var individual_other_comp_industry = $("#individual_other_comp_industry").val();
            var individual_comp_overview = $("#individual_comp_overview").val();
            var individual_country = $("#individual_country option:selected").val();
            var individual_state = $("#individual_state option:selected").val();
            var individual_city = $("#individual_city option:selected").val();

            var updatedata = $.param({
                "individual_comp_name":individual_comp_name,
                "individual_comp_industry":individual_comp_industry,
                "individual_other_comp_industry":individual_other_comp_industry,
                "individual_comp_overview":individual_comp_overview,
                "individual_country":individual_country,
                "individual_state":individual_state,
                "individual_city":individual_city
            });

            $http({
                method: 'POST',
                url: base_url + 'freelancer_hire_live/save_individual_comp_info',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {                    
                    $scope.individual_company_info = result.data.individual_company_info;                    
                }
                $("#save_individual_comp_info").removeAttr("style");
                $("#individual_comp_info_loader").hide();
                $("#emp-company-info").modal('hide');
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
            });
        }
    };

    $scope.get_individual_basic_info = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer_hire_live/get_individual_basic_info',            
            data: 'to_user_id=' + to_user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.individual_basic_info = result.data.individual_basic_info;
                $("#individual-basic-info-loader").hide();
                $("#individual-basic-info-body").show();
            }
        });
    };

    $scope.current_position_list = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchJobTitleStart',
            data: 'q=' + $scope.individual_position,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            data = success.data;
            $scope.titleSearchResult = data;
        });
    };

    $scope.other_individual_industry = function(){
        if($scope.individual_industry == 0 && $scope.individual_industry != "")
        {
            $("#individual_other_field_div").show();
        }
        else
        {
            $("#individual_other_field_div").hide();
        }
    };

    $scope.edit_individual_basic_info = function(){
        $("#individual_first_name").val($scope.individual_basic_info.first_name);
        $("#individual_last_name").val($scope.individual_basic_info.last_name);
        $("#individual_email").val($scope.individual_basic_info.email);
        $("#individual_phone").val($scope.individual_basic_info.phone);
        $("#individual_skype").val($scope.individual_basic_info.skyupid);
        $("#individual_position").val($scope.individual_basic_info.current_position_txt);
        
        var individual_skill = "";
        if($scope.individual_basic_info.individual_skills_txt.trim() != "")
        {
            var individual_skill = $scope.individual_basic_info.individual_skills_txt.split(',');
        }
        var edit_individual_skill = [];
        if(individual_skill.length > 0)
        {                    
            individual_skill.forEach(function(element,skillIndex) {
              edit_individual_skill[skillIndex] = {"name":element};
            });
        }
        $scope.individual_skills = edit_individual_skill;

        $("#individual_industry").val($scope.individual_basic_info.individual_industry);
        $scope.individual_industry = $scope.individual_basic_info.individual_industry;
        if($scope.individual_industry == 0)
        {
            $("#individual_other_field_div").show();
            $("#individual_other_industry").val($scope.individual_basic_info.individual_other_industry);
        }
        $("#individual_prof_info").val($scope.individual_basic_info.professional_info);
        $scope.individual_prof_info = $scope.individual_basic_info.professional_info;
    };

    $scope.individual_basic_info_validate = {
        rules: {
            individual_first_name: {
                required: true,
            },
            individual_last_name: {
                required: true,
            },
            individual_email: {
                required: true,                
                email: true,
                remote: {
                    url: base_url + "freelancer_hire_live/check_email",
                    type: "post",
                    data: {
                      email: function() {
                        return $( "#individual_email" ).val();
                      }
                    }
                },
            },
            individual_phone: {
                required: true,
            },
            individual_skype: {
                required: true,
            },
            individual_position: {
                required: true,
            },
            individual_industry: {
                required: true,
            },
            individual_other_industry: {
                required: {
                    depends: function(element) {
                        return $("#individual_industry option:selected").val() == 0 ? true : false;
                    }
                },
            },
            individual_prof_info: {
                required: true,
            },
        },
    };

    $scope.validate_individual_skills = function(){
        if($scope.individual_skills == "" || $scope.individual_skills == undefined)
        {
            $("#individual_skills .tags").attr("style","border:1px solid #ff0000;");
            /*setTimeout(function(){
                $("#exp_designation_err").attr("style","display:block;");            
            },100);*/
            return false;
        }
        else
        {
            return true;
        }
    };
    $scope.individual_skills_fnc = function(){
        // $("#exp_designation input").removeClass("error");
        $("#individual_skills .tags").removeAttr("style");        
    };

    $scope.save_individual_basic_info = function(){
        var individual_skills_validate = $scope.validate_individual_skills();
        if ($scope.individual_basic_info_form.validate() && individual_skills_validate)
        {
            $("#individual_basic_info_loader").show();
            $("#save_individual_basic_info").attr("style","pointer-events:none;display:none;");

            var individual_first_name = $("#individual_first_name").val();
            var individual_last_name = $("#individual_last_name").val();
            var individual_email = $("#individual_email").val();
            var individual_phone = $("#individual_phone").val();
            var individual_skype = $("#individual_skype").val();
            var individual_position = $("#individual_position").val();
            var individual_skills = $scope.individual_skills;
            var individual_industry = $("#individual_industry option:selected").val();
            var individual_other_industry = $("#individual_other_industry").val();
            var individual_prof_info = $("#individual_prof_info").val();

            var updatedata = $.param({
                "individual_first_name":individual_first_name,
                "individual_last_name":individual_last_name,
                "individual_email":individual_email,
                "individual_phone":individual_phone,
                "individual_skype":individual_skype,
                "individual_position":individual_position,
                "individual_skills":individual_skills,
                "individual_industry":individual_industry,
                "individual_other_industry":individual_other_industry,
                "individual_prof_info":individual_prof_info,
            });

            $http({
                method: 'POST',
                url: base_url + 'freelancer_hire_live/save_individual_basic_info',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {                    
                    $scope.individual_basic_info = result.data.individual_basic_info;
                    $(".job-menu-profile a h3").html($scope.individual_basic_info.first_name+' '+$scope.individual_basic_info.last_name);
                }
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);

                $("#save_individual_basic_info").removeAttr("style");
                $("#individual_basic_info_loader").hide();
                $("#job-basic-info").modal('hide');
                /*var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);*/
            });
        }
    };
    //Indiviaul End

    $scope.set_progress = function(count_profile_value,count_profile){
        if(count_profile == 100)
        {
            $("#profile-progress").show();
            $("#progress-txt").html("Hurray! Your profile is complete.");
            setTimeout(function(){
                // $("#edit-profile-move").hide();
            },5000);
        }
        else
        {
            $("#edit-profile-move").show();
            $("#profile-progress").show();                
            $("#progress-txt").html("Complete your profile to get connected with more people.");   
        }
        // if($scope.old_count_profile < 100)
        {
            $('.second.circle-1').circleProgress({
                value: count_profile_value //with decimal point
            }).on('circle-animation-progress', function(event, progress) {
                $(this).find('strong').html(Math.round(count_profile * progress) + '<i>%</i>');
            });
        }
        $scope.old_count_profile = count_profile;
    };

    $scope.get_review();
    $scope.get_cmp_company_cont_info();
    $scope.get_cmp_company_info();
    $scope.get_individual_company_info();
    $scope.get_individual_basic_info();
});