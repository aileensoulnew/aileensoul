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
app.controller('freelancerAppRegiController', function ($scope, $http) {
    $scope.open_form = function(form_id){        
        if(form_id == '1')
        {
            $("#regi-opt").hide();
            $("#register-form").show();
            $("#regi-form-company").hide();
            $("#regi-form-individual").show();
        }
        else if(form_id == '2')
        {
            $("#regi-opt").hide();
            $("#register-form").show();
            $("#regi-form-individual").hide();
            $("#regi-form-company").show();
        }
    };

    $scope.back_to_main = function(){
        $("#freelancer_apply_individual_regi")[0].reset();
        $("#freelancer_apply_company_regi")[0].reset();
        $("#regi-opt").show();
        $("#register-form").hide();
        $("#regi-form-company").hide();
        $("#regi-form-individual").hide();
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

    $scope.current_position_list = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchJobTitleStart',
            data: 'q=' + $scope.current_position,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            data = success.data;
            $scope.titleSearchResult = data;
        });
    };

    $scope.individual_country_change = function() {
        $("#individual_state").attr("disabled","disabled");
        $("#save_individual").attr("style","pointer-events:none;");
        $("#individual_state_loader").show();
        var counrtydata = $.param({'country_id': $scope.individual_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#individual_state").removeAttr("disabled");
            $("#save_individual").removeAttr("style");
            $("#individual_city").attr("disabled","disabled");
            $("#individual_state_loader").hide();
            $scope.individual_state_list = data.data;
            $scope.individual_city_list = [];
        });
    }

    $scope.individual_state_change = function() {
        if($scope.individual_state != "" && $scope.individual_state != 0 && $scope.individual_state != null)
        {
            $("#individual_city").attr("disabled","disabled");
            $("#save_individual").attr("style","pointer-events:none;");
            $("#individual_city_loader").show();
            var statedata = $.param({'state_id': $scope.individual_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#individual_city").removeAttr("disabled");
                $("#save_individual").removeAttr("style");
                $("#individual_city_loader").hide();
                $scope.individual_city_list = data.data;
            });
        }
    };

    $scope.experience_year_change = function(){
        var ind_year = $("#experience_year option:selected").val();
        if(ind_year == '0 year')
        {
            $("#experience_month option[value='0 month']").attr("disabled","disabled");
        }
        else
        {
            $("#experience_month option[value='0 month']").removeAttr('disabled');
        }
    };

    $scope.experience_month_change = function(){
        var ind_month = $("#experience_month option:selected").val();
        if(ind_month == '0 month')
        {
            $("#experience_year option[value='0 year']").attr("disabled","disabled");
        }
        else
        {
            $("#experience_year option[value='0 year']").removeAttr('disabled');
        }
    };

    $scope.freelancer_apply_individual_regi_validate = {
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true,
                //regx: /^["-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: base_url + "freelancer/check_email",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#email").val();
                        },
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                    }, async: false
                },
            },
            phoneno: {
               number: true,
                minlength: 8,
                maxlength: 15
            },
            current_position: {
                required: true,
            },
            field: {
                required: true
            },
            experience_year: {
                required: true
            },
            experience_month: {
                required: true
            },
            skills: {
                required: true,
                //regx: /^["-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
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
        groups: {
          experience: "experience_year experience_month"
        },
        messages: {
            first_name: {
                required: "First name is required."
            },
            last_name: {
                required: "Last name is required."
            },
            email: {
                required: "Email id is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },
            phoneno: {
                minlength: "Minimum length 8 digit",
                maxlength: "Maximum length 15 digit"
            },            
            current_position: {
                required: "Please enter current position",
            },
            field: {
                required: "Field is required",
            },
            experience_year : {
              required: "Experience is required"  
            },
            experience_month : {
              required: "Experience is required"  
            },
            skills: {
                required: "Skill is required"
            },
            individual_country: {
                required: "Country is required.",
            },
            individual_state: {
                required: "State is required.",
            },
            individual_city: {
                required: "City is required.",
            },
        },
    };

    $scope.save_individual = function () {

        if ($scope.freelancer_apply_individual_regi.validate()) {

            $("#individual_loader").attr("style","display:inline-block;");
            $("#save_individual").attr("style","pointer-events:none;display:none;");
            $("#back_individual").attr("style","pointer-events:none;display:none;");

            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var email = $("#email").val();
            var phoneno = $("#phoneno").val();
            var current_position = $("#current_position").val();
            var field = $("#field option:selected").val();
            var experience_year = $("#experience_year option:selected").val();
            var experience_month = $("#experience_month option:selected").val();
            var skills1 = $("#skills1").val();
            var individual_country = $("#individual_country option:selected").val();
            var individual_state = $("#individual_state option:selected").val();
            var individual_city = $("#individual_city option:selected").val();

            var updatedata = $.param({'first_name':first_name,'last_name':last_name,'email':email,"phoneno":phoneno,'current_position':current_position,"field":field,"experience_year":experience_year,"experience_month":experience_month,"skills":skills1,"country":individual_country,"state":individual_state,"city":individual_city});

            $http({
                method: 'POST',
                url: base_url + 'freelancer/save_individual',
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {
                success = result.data.success;
                if(success == 1)
                {
                    window.location = base_url + "recommended-freelance-work"
                }
                else
                {
                    $("#individual_loader").attr("style","display:none;");
                    $("#save_individual").removeAttr("style");
                    $("#back_individual").removeAttr("style");
                    $("#error-modal").modal("show");
                }
            });
        }
        else {
            return false;
        }
    };

    //Company Registration Start
    $scope.company_country_change = function() {
        $("#company_state").attr("disabled","disabled");
        $("#save_company").attr("style","pointer-events:none;");
        $("#company_state_loader").show();
        var counrtydata = $.param({'country_id': $scope.company_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#company_state").removeAttr("disabled");
            $("#save_company").removeAttr("style");
            $("#company_city").attr("disabled","disabled");
            $("#company_state_loader").hide();
            $scope.company_state_list = data.data;
            $scope.company_city_list = [];
        });
    }

    $scope.company_state_change = function() {
        if($scope.company_state != "" && $scope.company_state != 0 && $scope.company_state != null)
        {
            $("#company_city").attr("disabled","disabled");
            $("#save_company").attr("style","pointer-events:none;");
            $("#company_city_loader").show();
            var statedata = $.param({'state_id': $scope.company_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#company_city").removeAttr("disabled");
                $("#save_company").removeAttr("style");
                $("#company_city_loader").hide();
                $scope.company_city_list = data.data;
            });
        }
    };

    $scope.comp_exp_year_change = function(){
        var cmp_year = $("#comp_exp_year option:selected").val();
        if(cmp_year == '0')
        {
            $("#comp_exp_month option[value='0']").attr("disabled","disabled");
        }
        else
        {
            $("#comp_exp_month option[value='0']").removeAttr('disabled');
        }
    };

    $scope.comp_exp_month_change = function(){
        var cmp_year = $("#comp_exp_month option:selected").val();
        if(cmp_year == '0')
        {
            $("#comp_exp_year option[value='0']").attr("disabled","disabled");
        }
        else
        {
            $("#comp_exp_year option[value='0']").removeAttr('disabled');
        }
    };

    $scope.freelancer_apply_company_regi_validate = {
        rules: {
            comp_name: {
                required: true
            },
            comp_number: {
                number: true,
                minlength: 8,
                maxlength: 15
            },
            comp_email: {
                required: true,
                email: true,                
            },            
            comp_website: {
                url: true,
            },
            skills: {
                required: true,
                //regx: /^["-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            field: {
                required: true
            },
            comp_exp_year: {
                required: true
            },
            comp_exp_month: {
                required: true
            },
            comp_overview: {
                required: true
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
        groups: {
          experience: "comp_exp_year comp_exp_month"
        },
        messages: {
            comp_name: {
                required: "Company name is required."
            },
            comp_number: {
                minlength: "Minimum length 8 digit",
                maxlength: "Maximum length 15 digit"
            }, 
            comp_email: {
                required: "Email id is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },           
            comp_website: {
                url: "URL start with http:// or https://",
            },
            skills: {
                required: "Skill is required"
            },
            field: {
                required: "Field is required",
            },
            comp_exp_year : {
              required: "Experience is required"  
            },
            comp_exp_month : {
              required: "Experience is required"  
            },
            comp_overview : {
              required: "Company overview is required"  
            },
            company_country: {
                required: "Country is required.",
            },
            company_state: {
                required: "State is required.",
            },
            company_city: {
                required: "City is required.",
            },
        },
    };

    $scope.save_company = function () {        

        if ($scope.freelancer_apply_company_regi.validate()) {

            $("#company_loader").attr("style","display:block;");
            $("#save_company").attr("style","pointer-events:none;display:none;");
            $("#back_company").attr("style","pointer-events:none;display:none;");

            var comp_name = $("#comp_name").val();
            var comp_number = $("#comp_number").val();
            var email = $("#comp_email").val();            
            var comp_website = $("#comp_website").val();            
            var skills2 = $("#skills2").val();
            var field = $("#comp_field option:selected").val();
            var experience_year = $("#comp_exp_year option:selected").val();
            var experience_month = $("#comp_exp_month option:selected").val();
            var comp_overview = $("#comp_overview").val();
            var company_country = $("#company_country option:selected").val();
            var company_state = $("#company_state option:selected").val();
            var company_city = $("#company_city option:selected").val();

            var updatedata = $.param({'comp_name':comp_name,'comp_number':comp_number,'email':email,'comp_website':comp_website,"skills":skills2,"field":field,"experience_year":experience_year,"experience_month":experience_month,"comp_overview":comp_overview,"country":company_country,"state":company_state,"city":company_city});

            $http({
                method: 'POST',
                url: base_url + 'freelancer/save_company',
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {
                success = result.data.success;
                if(success == 1)
                {
                    window.location = base_url + "recommended-freelance-work"
                }
                else
                {
                    $("#company_loader").attr("style","display:none;");
                    $("#save_company").removeAttr("style");
                    $("#back_company").removeAttr("style");
                    $("#error-modal").modal("show");
                }
            });
        }
        else {
            return false;
        }
    };
    //Company Registration End
});