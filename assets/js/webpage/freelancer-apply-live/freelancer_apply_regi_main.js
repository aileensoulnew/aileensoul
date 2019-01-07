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
        var url = base_url+"freelancer/general-info";
        
        $location.path(url);

        var obj = {Title: title, Url: url};
        history.pushState(obj, obj.Title, obj.Url);
    }
    else if(userid == "")
    {
        var title = "Create freelancer Profile | Aileensoul"
        var url = base_url+"freelancer/create-account";
        
        $location.path(url);

        var obj = {Title: title, Url: url};
        history.pushState(obj, obj.Title, obj.Url);
    }
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/freelancer/create-account", {
                templateUrl: base_url + "freelancer_apply_live/freelancer_apply_register",
                controller: 'freelanceRegiController'
            })
            .when("/freelancer/general-info", {
                templateUrl: base_url + "freelancer_apply_live/freelancer_apply_basic_info_new",
                controller: 'freelanceBasicInfoController'
            })
            .when("/freelancer/educational-info", {
                templateUrl: base_url + "freelancer_apply_live/freelancer_apply_education_info",
                controller: 'freelanceEduInfoController'
            })
            .when("/freelancer/registration", {
                templateUrl: base_url + "freelancer_apply_live/freelancer_apply_create_profile",
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
                    $("#main_create_ac").removeAttr("style");
                } else {
                    if (success.data.okmsg == "ok") {
                        $('#basic_info_ajax_load').hide();
                        var title = "freelancer Information"
                        var url = base_url+"freelancer/general-info";
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
                    $("#main_create_ac").removeAttr("style");
                }
                
            }, function (error){

            });
        }
    };    
});

app.controller('freelanceBasicInfoController', function ($scope, $http, $location, $window,$timeout) {
    $scope.$parent.title = "freelancer Profile | Aileensoul";    
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
                        var url = base_url+"freelancer/registration";

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
    $scope.$parent.title = "freelancer Profile | Aileensoul";

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
                        var url = base_url+"freelancer/registration";
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
    // alert(first_name);
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
        $("#freelanceapplyinfo")[0].reset();
        $("#freelanceapplyinfocompany")[0].reset();
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

    $scope.$parent.title = "Recruiter Profile | Aileensoul";

    $("#email").focusin(function(){
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

    $("#skills1").focusin(function(){
        $('#sktooltip').show();
    });
    $("#skills1").focusout(function(){
        $('#sktooltip').hide();
    });

    $scope.experience_year_change = function(){
        /*var ind_year = $("#experience_year option:selected").val();
        if(ind_year == '0 year')
        {
            $("#experience_month option[value='0 month']").attr("disabled","disabled");
        }
        else
        {
            $("#experience_month option[value='0 month']").removeAttr('disabled');
        }*/
    };

    $scope.experience_month_change = function(){
        /*var ind_month = $("#experience_month option:selected").val();
        if(ind_month == '0 month')
        {
            $("#experience_year option[value='0 year']").attr("disabled","disabled");
        }
        else
        {
            $("#experience_year option[value='0 year']").removeAttr('disabled');
        }*/
    };

    $scope.freelanceapplyRegiValidate = {
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

        if ($scope.freelanceapplyinfo.validate()) {

            $("#individual_loader").attr("style","display:inline-block;");
            $("#save_individual").attr("style","pointer-events:none;");
            $("#back_individual").attr("style","pointer-events:none;");

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

    //Company Start
    $("#comp_email  ").focusin(function(){
        $('#cetooltip').show();
    });
    $("#comp_email  ").focusout(function(){
        $('#cetooltip').hide();
    });

    $("#comp_number").focusin(function(){
        $('#cntooltip').show();
    });
    $("#comp_number").focusout(function(){
        $('#cntooltip').hide();
    });

    $("#skills2").focusin(function(){
        $('#cktooltip').show();
    });
    $("#skills2").focusout(function(){
        $('#cktooltip').hide();
    });

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
        /*var cmp_year = $("#comp_exp_year option:selected").val();
        if(cmp_year == '0')
        {
            $("#comp_exp_month option[value='0']").attr("disabled","disabled");
        }
        else
        {
            $("#comp_exp_month option[value='0']").removeAttr('disabled');
        }*/
    };

    $scope.comp_exp_month_change = function(){
        /*var cmp_year = $("#comp_exp_month option:selected").val();
        if(cmp_year == '0')
        {
            $("#comp_exp_year option[value='0']").attr("disabled","disabled");
        }
        else
        {
            $("#comp_exp_year option[value='0']").removeAttr('disabled');
        }*/
    };

    $scope.freelanceapplyCompanyRegiValidate = {
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

        if ($scope.freelanceapplyinfocompany.validate()) {

            $("#company_loader").attr("style","display:inline-block;");
            $("#save_company").attr("style","pointer-events:none;");
            $("#back_company").attr("style","pointer-events:none;");

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
    //Company End
});


$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});

// NEW HTML SCRIPT

/*$(function () {
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
});*/