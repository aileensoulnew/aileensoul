app.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});
app.filter('slugify', function () {
    return function (input) {
        if (!input)
            return;

        // make lower case and trim
        var slug = input.toLowerCase().trim();

        // replace invalid chars with spaces
        slug = slug.replace(/[^a-z0-9\s-]/g, ' ');

        // replace multiple spaces or hyphens with a single hyphen
        slug = slug.replace(/[\s-]+/g, '-');

        if(slug[slug.length - 1] == "-")
        {            
            slug = slug.slice(0,-1);
        }
        return slug;
    };
});

app.controller('freelancerRegiMainController', function ($scope, $http, $location, $window,$timeout) {

    if(userid != "" && profData == 0 && studData == 0)
    {        
        var title = "freelancer Basic Information"
        var url = base_url+"freelance-employer/general-info";
        
        $location.path(url);

        var obj = {Title: title, Url: url};
        history.pushState(obj, obj.Title, obj.Url);
    }
    else if(userid == "")
    {
        var title = "Create freelancer Profile | Aileensoul"
        var url = base_url+"freelance-employer/create-account";
        
        $location.path(url);

        var obj = {Title: title, Url: url};
        history.pushState(obj, obj.Title, obj.Url);
    }
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/freelance-employer/create-account", {
                templateUrl: base_url + "freelancer_hire_live/freelancer_hire_register",
                controller: 'freelanceRegiController'
            })
            .when("/freelance-employer/general-info", {
                templateUrl: base_url + "freelancer_hire_live/freelancer_hire_basic_info_new",
                controller: 'freelanceBasicInfoController'
            })
            .when("/freelance-employer/educational-info", {
                templateUrl: base_url + "freelancer_hire_live/freelancer_hire_education_info",
                controller: 'freelanceEduInfoController'
            })
            .when("/freelance-employer/registration", {
                templateUrl: base_url + "freelancer_hire_live/freelancer_hire_create_profile",
                controller: 'freelanceCreateProfileController'
            })            
    $locationProvider.html5Mode(true);
});

app.controller('freelanceRegiController', function ($scope, $http, $location, $window,$timeout) {
    var conn_new = new Strophe.Connection(openfirelink);
    $scope.$parent.title = "Create freelancer Profile | Aileensoul";    
    $scope.jobByLocation = {};
    $scope.jobs = {};
    reserve_keyword_arr = reserve_keyword.split(',');

    $("#selday,#selmonth,#selyear").focusin(function(){
        $('#dobtooltip').show();
    });
    $("#selday,#selmonth,#selyear").focusout(function(){
        $('#dobtooltip').hide();
    });

    $.validator.addMethod("check_res_keyword_fname", function (value, element, param) {
        var val = $(param).val();
        if(val != "")
        {            
            if(reserve_keyword_arr.indexOf(value.toLowerCase()) != -1 && reserve_keyword_arr.indexOf(val.toLowerCase()) != -1)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }, "First name or Last name contains our reserved keyword.");
    $.validator.addMethod("check_res_keyword_lname", function (value, element, param) {
        var val = $(param).val();
        if(val != "")
        {            
            if(reserve_keyword_arr.indexOf(value.toLowerCase()) != -1 && reserve_keyword_arr.indexOf(val.toLowerCase()) != -1)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }, "First name or Last name contains our reserved keyword.");

    $.validator.addMethod("notEqualFname", function(value, element, param) {
        return this.optional(element) || value != $(param).val();
    }, "First name and Last name has to be different.");
    $.validator.addMethod("notEqualLname", function(value, element, param) {
        return this.optional(element) || value != $(param).val();
    }, "First name and Last name has to be different.");

    $scope.regiValidate = {
        rules: {
            first_name: {
                required: true,
                check_res_keyword_lname:'#last_name',
                notEqualLname:'#last_name',
            },
            last_name: {
                required: true,
                check_res_keyword_fname:'#first_name',
                notEqualFname:'#first_name',
            },
            email_reg: {
                required: true,
                remote: {
                    url: base_url+"registration/check_email",
                    type: "post",
                    data: {
                        email_reg: function () {
                            // alert("hi");
                            return $("#email_reg").val();
                        },
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                    },
                },
            },
            password_reg: {
                required: true,
            },
            selday: {
                required: true,
            },
            selmonth: {
                required: true,
            },
            selyear: {
                required: true,
            },
            selgen: {
                required: true,
            },
            term_condi: {
                required: true,
            }
        },

        groups: {
            selyear: "selyear selmonth selday",
            res_keyword: "first_name last_name",
        },
        messages:
        {
            first_name: {
                required: "Please enter First name and Last name",
            },
            last_name: {
                required: "Please enter First name and Last name",
            },
            email_reg: {
                required: "Please enter email address",
                remote: "Email address already exists",
            },
            password_reg: {
                required: "Please enter password",
            },

            selday: {
                required: "Please enter your birthdate",
            },
            selmonth: {
                required: "Please enter your birthdate",
            },
            selyear: {
                required: "Please enter your birthdate",
            },
            selgen: {
                required: "Please enter your gender",
            },
            term_condi: {
                required: "Please read and accept privacy policy, terms and conditions",
            }

        },
        errorPlacement: function (error, element) {
            if (element.attr("type") == "checkbox") {
                error.insertAfter($("#lbl_term_condi"));
            }
            else if(element.attr("name") == "first_name" || element.attr("name") == "last_name"){
                error.appendTo($("#err-res-key"));
            }else {
                error.insertAfter(element);
            }
        },
    };

    $scope.submitRegiForm = function () {
        if ($scope.register_form.validate())
        {
            $("#main_create_ac").attr("style","pointer-events:none");
            $http({
            method: 'POST',
                    url: base_url + 'registration/reg_insert_new',
                    data: $scope.user,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success){

                if (success.data.errors) {
                    var err_arr = success.data.errors;
                    if(err_arr.errorReg != "")
                    {
                        $("#register_error").fadeIn(1000, function() {
                            $("#register_error").html('<div class="error-reg-cus"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; Try after sometime!</div>');
                        });
                    }
                    else
                    {
                        $scope.errorjobTitle = err_arr.jobTitle;
                        $scope.errorcityList = err_arr.cityList;
                        $scope.errorfield = err_arr.field;
                        $scope.errorotherField = err_arr.otherField;
                    }
                } else {
                    if (success.data.okmsg == "ok") {                        
                        $('#basic_info_ajax_load').hide();
                        var title = "freelancer Information"
                        var url = base_url+"freelance-employer/general-info";
                        var obj = {Title: title, Url: url};
                        history.pushState(obj, obj.Title, obj.Url);

                        $timeout(function() {
                            var el = document.getElementById('ca');
                            angular.element(el).triggerHandler('click');
                        }, 0);
                        // window.location = base_url;
                    } else {
                        return false;
                    }
                }
                
            }, function (error){

            });
        }
    };
    
});

app.controller('freelanceBasicInfoController', function ($scope, $http, $location, $window,$timeout) {
    $scope.$parent.title = "Freelancer Profile | Aileensoul";    
    $scope.jobByLocation = {};
    //$scope.basicinfo = {};

    getFieldList();
    function getFieldList() {
    $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {});
    }
    
    $scope.jobTitle = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchJobTitle',
            data: 'q=' + $scope.user.jobTitle,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.titleSearchResult = data;
        });
    }

    $scope.cityList = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchCityList',
            data: 'q=' + $scope.user.cityList,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.citySearchResult = data;
        });
    }

    $("#jobTitle").focusin(function(){
        $('#jttooltip').show();
    });
    $("#jobTitle").focusout(function(){
        $('#jttooltip').hide();
    });

    $scope.basicInfoValidate = {
        rules: {
            jobTitle: {
                required: true,
            },
            city: {
                required: true,
            },
            field: {
                required: true,
            }
        },
        messages: {
            jobTitle: {
                required: "Job title is required.",
            },
            city: {
                required: "City is required.",
            },
            field: {
                required: "Field id is required.",
            }
        }
    };
    $scope.submitBasicInfoForm = function () {
        if ($scope.basicinfo.validate())
        {
            angular.element('#basicinfo #submit').addClass("form_submit");
            $('#basic_info_ajax_load').show();
            $http({
            method: 'POST',
                    url: base_url + 'user_info/ng_basic_info_insert',
                    data: $scope.user,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success){
                if (success.data.errors) {
                    $scope.errorjobTitle = success.data.errors.jobTitle;
                    $scope.errorcityList = success.data.errors.cityList;
                    $scope.errorfield = success.data.errors.field;
                    $scope.errorotherField = success.data.errors.otherField;
                    if(success.data.errors.acc_exist == 1)
                    {
                        window.location = base_url;
                    }
                } else {
                    if (success.data.is_success == '1') {
                        angular.element('#basicinfo #submit').removeClass("form_submit");
                        $('#basic_info_ajax_load').hide();
                        var title = "freelancer Registrion"
                        var url = base_url+"freelance-employer/registration";

                        var obj = {Title: title, Url: url};
                        history.pushState(obj, obj.Title, obj.Url);

                        /*$timeout(function() {
                            var el = document.getElementById('ca');
                            angular.element(el).triggerHandler('click');
                        }, 0);*/
                        // window.location = base_url;
                    } else {
                        return false;
                    }
                }
            }, function (error){

            });
        }
        else
        {
            return false;
        }
    };
});

app.controller('freelanceEduInfoController', function ($scope, $http, $location, $window,$timeout) {
    $scope.$parent.title = "Freelancer Profile | Aileensoul";

    $("#currentStudy").focusin(function(){
        $('#cstooltip').show();
    });
    $("#currentStudy").focusout(function(){
        $('#cstooltip').hide();
    });

    $("#jobTitle").focusin(function(){
        $('#iftooltip').show();
    });
    $("#jobTitle").focusout(function(){
        $('#iftooltip').hide();
    });
    
    $scope.user = {};

    getFieldList();
    function getFieldList() {
    $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {});
    }

    $scope.jobTitle = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchJobTitle',
            data: 'q=' + $scope.user.jobTitle,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.titleSearchResult = data;
        });
    }

    $('#student_info_ajax_load').hide();                

    $scope.currentStudy = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/degreeList',
            data: 'q=' + $scope.user.currentStudy,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.degreeSearchResult = data;
        });
    }

    $scope.cityList = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchCityList',
            data: 'q=' + $scope.user.cityList,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.citySearchResult = data;
        });
    }

    $scope.universityList = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchUniversityList',
            data: 'q=' + $scope.user.universityName,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.universitySearchResult = data;
        });
    }

    $scope.studentInfoValidate = {
        rules: {
            currentStudy: {
                required: true,
            },
            city: {
                required: true,
            },
            university: {
                required: true,
            },
            // jobTitle
            field: {
                required: true,
            }
        },
        messages: {
            currentStudy: {
                required: "Current study is required.",
            },
            city: {
                required: "City is required.",
            },
            university: {
                required: "University name is required.",
            },
            // jobTitle
            field: {
                required:  "Interested field is required.",
            }
        }
    };
    $scope.submitStudentInfoForm = function () {
        if ($scope.studentinfo.validate()) {
            angular.element('#studentinfo #submit').addClass("form_submit");
            $('#student_info_ajax_load').show();
            $http({
                 method: 'POST',
                url: base_url + 'user_info/ng_student_info_insert',
                data: $scope.user,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                if (success.data.errors) {
                    $scope.errorcurrentStudy = success.data.errors.currentStudy;
                    $scope.errorcityList = success.data.errors.cityList;
                    $scope.erroruniversityName = success.data.errors.universityName;
                    if(success.data.errors.acc_exist == 1)
                    {
                        window.location = base_url;
                    }
                } else {
                if (success.data.is_success == '1') {
                        angular.element('#studentinfo #submit').removeClass("form_submit");
                        $('#student_info_ajax_load').hide();                        
                        var title = "freelancer Registrion"
                        var url = base_url+"freelance-employer/registration";
                        var obj = {Title: title, Url: url};
                        history.pushState(obj, obj.Title, obj.Url);
                    } else {
                        return false;
                    }
                }
            });
        }
        else {
            return false;
        }
    };
});

app.controller('freelanceCreateProfileController', function ($scope, $http, $location, $window,$timeout) {    
    $scope.$parent.title = "Freelancer Profile | Aileensoul";
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

    $scope.back_to_main = function(){
        $("#freelancer_hire_individual_regi")[0].reset();
        $("#freelancer_hire_company_regi")[0].reset();
        $("#regi-opt").show();
        $("#register-form").hide();
        $("#regi-form-company").hide();
        $("#regi-form-individual").hide();
    };

    //Individual tooltips
    $("#email_id").focusin(function(){
        $('#emtooltip').show();
    });
    $("#email_id").focusout(function(){
        $('#emtooltip').hide();
    });

    $("#current_position").focusin(function(){
        $('#cptooltip').show();
    });
    $("#current_position").focusout(function(){
        $('#cptooltip').hide();
    });

    $("#prof_info").focusin(function(){
        $('#pitooltip').show();
    });
    $("#prof_info").focusout(function(){
        $('#pitooltip').hide();
    });
    //Individual tooltips

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
            $("#freelancer_loader").attr("style","display:inline-block;");
            $("#save_individual").attr("style","pointer-events:none;");
            $("#back_individual").attr("style","pointer-events:none;");

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
                    $("#freelancer_loader").attr("style","display:none;");
                    $("#save_individual").removeAttr("style");
                    $("#back_individual").removeAttr("style");
                    $("#error-modal").modal("show");
                }
            });
        }
    };

    //Company Tooltips
    $("#comp_number").focusin(function(){
        $('#cntooltip').show();
    });
    $("#comp_number").focusout(function(){
        $('#cntooltip').hide();
    });

    $("#comp_email").focusin(function(){
        $('#cetooltip').show();
    });
    $("#comp_email").focusout(function(){
        $('#cetooltip').hide();
    });

    $("#comp_overview").focusin(function(){
        $('#cotooltip').show();
    });
    $("#comp_overview").focusout(function(){
        $('#cotooltip').hide();
    });
    //Company Tooltips

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
            $("#company_loader").attr("style","display:inline-block;");
            $("#save_company").attr("style","pointer-events:none;");
            $("#back_company").attr("style","pointer-events:none;");

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
                    $("#company_loader").attr("style","display:none;");
                    $("#save_individual").removeAttr("style");
                    $("#back_individual").removeAttr("style");
                    $("#error-modal").modal("show");
                }
            });
        }
    };

    /*$("#email").focusin(function(){
        $('#emtooltip').show();
    });
    $("#email").focusout(function(){
        $('#emtooltip').hide();
    });

    $("#phoneno").focusin(function(){
        $('#pntooltip').show();
    });
    $("#phoneno").focusout(function(){
        $('#pntooltip').hide();
    });

    $("#professional_info").focusin(function(){
        $('#pitooltip').show();
    });
    $("#professional_info").focusout(function(){
        $('#pitooltip').hide();
    });

    $scope.freelancehireRegiValidate = {
        rules: {
            first_name: {
                required: true,                
            },
            last_name: {
                required: true,                
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: base_url + "freelancer_hire/check_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#email").val();
                        },
                    },
                },
            },            
            phoneno: {
                number: true,
                minlength: 8,
                maxlength: 15
            },            
            country: {
                required: true,
            },
            state: {
                required: true,
            },
            professionalinfo: {
                maxlength: 2500
            }
        },
        messages: {
            first_name: {
                required: "First name is required.",
            },
            last_name: {
                required: "Last name is required.",
            },
            phoneno: {
                number: "Only Number allowed.",
                minlength: "Minimum 8 digits.",
                maxlength: "Maximum 15 digits."
            },
            email: {
                required: "Email id is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },
            country: {
                required: "Country is required.",
            },
            state: {
                required: "State is required.",
            },
            professionalinfo: {
                maxlength: "Maximum 2500 character allowed."
            }
        }
    };

    $scope.submitFreelancehireRegiForm = function () {
        $scope.user.city = $("#city").val();
        $scope.user.state = $("#state").val();
        setTimeout(function(){
            $("#city").val($scope.user.city);
            $("#state").val($scope.user.state);
        },100);
        if ($scope.freelancehireinfo.validate()) {
            angular.element('#freelancehireinfo #submit').addClass("form_submit");
            $('#profilereg_ajax_load').show();
            // freelancer_hire/hire_registation_insert
            $http({
                method: 'POST',
                url: base_url + 'freelancer_hire_live/hire_registation_insert_new',
                data: $scope.user,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                $('#profilereg_ajax_load').hide();
                if (success.data.errors) {
                    $scope.errorFname = success.data.errors.errorFname;
                    $scope.errorLname = success.data.errors.errorLname;
                    $scope.errorEmail = success.data.errors.errorEmail;
                    $scope.errorCN = success.data.errors.errorCN;
                    $scope.errorCE = success.data.errors.errorCE;
                    $scope.errorCon = success.data.errors.errorCon;
                    $scope.errorSt = success.data.errors.errorSt;
                }
                else
                {
                    if (success.data.is_success == '1')
                    {
                        //window.location = base_url+"artist/home";
                        // window.location = base_url + "hire-freelancer"
                        window.location = base_url + "post-freelance-project"
                    }
                    else
                    {
                        return false;
                    }
                }
            });
        }
        else {
            return false;
        }
    };*/
});


$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});

// NEW HTML SCRIPT

AOS.init({
    easing: 'ease-in-out-sine'
});

setInterval(addItem, 100);

var itemsCounter = 1;
var container = document.getElementById('aos-demo');

function addItem () {
    if (itemsCounter > 42) return;
    var item = document.createElement('div');
    item.classList.add('aos-item');
    item.setAttribute('data-aos', 'fade-up');
    item.innerHTML = '<div class="aos-item__inner"><h3>' + itemsCounter + '</h3></div>';
    // container.appendChild(item);
    itemsCounter++;
}
$(document).on('change','#country', function () {
    var countryID = $(this).val();
    if (countryID) {
        $.ajax({
            type: 'POST',
            url: base_url + "freelancer_hire/ajax_data",
            data: 'country_id=' + countryID,
            success: function (html) {
                $('#state').html(html);
                $('#city').html('<option value="">Select state first</option>');
            }
        });
    } else {
        $('#state').html('<option value="">Select country first</option>');
        $('#city').html('<option value="">Select state first</option>');
    }
});

$(document).on('change','#state', function () {
    var stateID = $(this).val();
    if (stateID) {
        $.ajax({
            type: 'POST',
            url: base_url + "freelancer_hire/ajax_data",
            data: 'state_id=' + stateID,
            success: function (html) {
                $('#city').html(html);
            }
        });
    } else {
        $('#city').html('<option value="">Select state first</option>');
    }
});