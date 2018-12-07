app.controller('freelanceHireRegiController', function ($scope, $http) {
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
});
app.controller('freelanceHireIndividualRegiController', function ($scope, $http) {
    $scope.back_to_main = function(){
        $("#freelancer_hire_individual_regi")[0].reset();
        $("#regi-opt").show();
        $("#register-form").hide();
        $("#regi-form-company").hide();
        $("#regi-form-individual").hide();
    };
    $scope.country_change = function() {
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

    $scope.state_change = function() {
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

    $scope.freelancer_hire_individual_regi_validate = {
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            email_id: {
                required: true,
                email:true,
                remote: {
                    url: base_url + "freelancer_hire_live/check_email",
                    type: "post",
                    data: {
                      email: function() {
                        return $( "#email_id" ).val();
                      }
                    }
                },
            },
            current_position: {
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
            prof_info: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "Please enter first name",
            },
            last_name: {
                required: "Please enter last name",
            },
            email_id: {
                required: "Please enter email",
                email: "Please enter valid email id.",
                remote: "Email already exists",
            },            
            current_position: {
                required: "Please enter current position",
            },
            individual_country: {
                required: "Please select county",
            },
            individual_state: {
                required: "Please select state",
            },
            individual_city: {
                required: "Please select city",
            },
            prof_info: {
                required: "Please enter address",
            },
        },
    };

    $scope.save_individual = function(){
        if ($scope.freelancer_hire_individual_regi.validate())
        {
            $("#freelancer_loader").show();
            $("#save_individual").attr("style","pointer-events:none;display:none;");
            $("#back_individual").attr("style","pointer-events:none;display:none;");

            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var email_id = $("#email_id").val();
            var current_position = $("#current_position").val();
            var individual_country = $("#individual_country option:selected").val();
            var individual_state = $("#individual_state option:selected").val();
            var individual_city = $("#individual_city option:selected").val();
            var prof_info = $("#prof_info").val();

            var updatedata = $.param({'first_name':first_name,'last_name':last_name,'email_id':email_id,'current_position':current_position,"individual_country":individual_country,"individual_state":individual_state,"individual_city":individual_city,"prof_info":prof_info});
            $http({
                method: 'POST',
                url: base_url + 'freelancer_hire_live/save_individual',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {
                    window.location = base_url + "post-freelance-project";
                }
                else if(success == 0)
                {
                    $("#freelancer_loader").hide();
                    $("#save_individual").removeAttr("style");
                    $("#back_individual").removeAttr("style");
                    $("#error-modal").modal("show");
                }
            });
        }
    };
});
app.controller('freelanceHireCompanyRegiController', function ($scope, $http) {
    $scope.back_to_main = function(){
        $("#freelancer_hire_company_regi")[0].reset();
        $("#regi-opt").show();
        $("#register-form").hide();
        $("#regi-form-company").hide();
        $("#regi-form-individual").hide();
    };
    $scope.get_country()
    $scope.get_country = function () {
        $http({
            method: 'GET',
            url: base_url + 'userprofile_page/get_country',
            headers: {'Content-Type': 'application/json'},
        }).then(function (data) {
            $scope.company_country_list = data.data;
        });
    };
    $scope.country_change = function() {
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

    $scope.state_change = function() {
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

    $scope.company_other_field_fnc = function()
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

    $scope.freelancer_hire_company_regi_validate = {
        rules: {
            comp_name: {
                required: true,
            },
            comp_number: {
                number: true,
            },
            comp_email: {
                required: true,
                email:true,
                remote: {
                    url: base_url + "freelancer_hire_live/check_email",
                    type: "post",
                    data: {
                      email: function() {
                        return $( "#comp_email" ).val();
                      }
                    }
                },
            },
            comp_website: {
                url: true,
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
            company_country: {
                required: true,
            },
            company_state: {
                required: true,
            },
            company_city: {
                required: true,
            },
            comp_overview: {
                required: true,
            },
        },
        messages: {
            comp_name: {
                required: "Please enter company name",
            },
            comp_number: {
                required: "Please enter company number",
            },
            comp_email: {
                required: "Please enter email",
                email: "Please enter valid email id.",
                remote: "Email already exists",
            },
            company_country: {
                required: "Please select county",
            },
            company_state: {
                required: "Please select state",
            },
            company_city: {
                required: "Please select city",
            },
            comp_overview: {
                required: "Please enter company company overview",
            },
        },
    };

    $scope.save_company = function(){
        if ($scope.freelancer_hire_company_regi.validate())
        {
            $("#company_loader").show();
            $("#save_company").attr("style","pointer-events:none;display:none;");
            $("#back_company").attr("style","pointer-events:none;display:none;");

            var comp_name = $("#comp_name").val();
            var comp_number = $("#comp_number").val();
            var comp_email = $("#comp_email").val();
            var comp_website = $("#comp_website").val();
            var company_field = $("#company_field").val();
            var company_other_field = $("#company_other_field").val();
            var comp_website = $("#comp_website").val();
            var company_country = $("#company_country option:selected").val();
            var company_state = $("#company_state option:selected").val();
            var company_city = $("#company_city option:selected").val();
            var comp_overview = $("#comp_overview").val();

            var updatedata = $.param({'comp_name':comp_name,'comp_number':comp_number,'comp_email':comp_email,'comp_website':comp_website,'company_field':company_field,'company_other_field':company_other_field,"company_country":company_country,"company_state":company_state,"company_city":company_city,"comp_overview":comp_overview});
            $http({
                method: 'POST',
                url: base_url + 'freelancer_hire_live/save_company',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {
                    window.location = base_url + "post-freelance-project";
                }
                else if(success == 0)
                {
                    $("#freelancer_loader").hide();
                    $("#save_individual").removeAttr("style");
                    $("#back_individual").removeAttr("style");
                    $("#error-modal").modal("show");
                }
            });
        }
    };

});