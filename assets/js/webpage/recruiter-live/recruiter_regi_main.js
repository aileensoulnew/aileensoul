app.filter('capitalize', function() {
    return function(input) {
        return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});
app.filter('slugify', function() {
    return function(input) {
        if (!input) return;
        // make lower case and trim
        var slug = input.toLowerCase().trim();
        // replace invalid chars with spaces
        slug = slug.replace(/[^a-z0-9\s-]/g, ' ');
        // replace multiple spaces or hyphens with a single hyphen
        slug = slug.replace(/[\s-]+/g, '-');
        if (slug[slug.length - 1] == "-") {
            slug = slug.slice(0, -1);
        }
        return slug;
    };
});
app.controller('recruiterRegiMainController', function($scope, $http, $location, $window, $timeout) {
    if (userid != "" && profData == 0 && studData == 0) {
        var title = "Recruiter Basic Information"
        var url = base_url + "recruiter/general-info";
        $location.path(url);
        var obj = {
            Title: title,
            Url: url
        };
        history.pushState(obj, obj.Title, obj.Url);
    } else if (userid == "") {
        var title = "Create Recruiter Profile | Aileensoul"
        var url = base_url + "recruiter/create-account";
        $location.path(url);
        var obj = {
            Title: title,
            Url: url
        };
        history.pushState(obj, obj.Title, obj.Url);
    }
});
app.config(function($routeProvider, $locationProvider) {
    $routeProvider.when("/recruiter/create-account", {
        templateUrl: base_url + "recruiter/recruiter_register",
        controller: 'recruiterRegiController'
    }).when("/recruiter/general-info", {
        templateUrl: base_url + "recruiter/recruiter_basic_info",
        controller: 'recruiterBasicInfoController'
    }).when("/recruiter/educational-info", {
        templateUrl: base_url + "recruiter/recruiter_education_info",
        controller: 'recruiterEduInfoController'
    }).when("/recruiter/registration", {
        templateUrl: base_url + "recruiter/recruiter_create_profile",
        controller: 'recruiterCreateProfileController'
    })
    $locationProvider.html5Mode(true);
});
app.controller('recruiterRegiController', function($scope, $http, $location, $window, $timeout) {
    var conn_new = new Strophe.Connection(openfirelink);
    $scope.$parent.title = "Create Recruiter Profile | Aileensoul";
    $scope.jobByLocation = {};
    $scope.jobs = {};
    reserve_keyword_arr = reserve_keyword.split(',');
    $("#selday,#selmonth,#selyear").focusin(function() {
        $('#dobtooltip').show();
    });
    $("#selday,#selmonth,#selyear").focusout(function() {
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
                    url: base_url + "registration/check_email",
                    type: "post",
                    data: {
                        email_reg: function() {
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
        messages: {
            first_name: {
                required: "Please enter first name",
            },
            last_name: {
                required: "Please enter last name",
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
    $scope.submitRegiForm = function() {
        if ($scope.register_form.validate()) {
            $("#register_form #create-account").attr("style","pointer-events:none");
            $http({
                method: 'POST',
                url: base_url + 'registration/reg_insert_new',
                data: $scope.user,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#register_form #create-account").removeAttr("style");
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
                        $scope.errorjobTitle = success.data.errors.jobTitle;
                        $scope.errorcityList = success.data.errors.cityList;
                        $scope.errorfield = success.data.errors.field;
                        $scope.errorotherField = success.data.errors.otherField;
                    }
                } else {
                    if (success.data.okmsg == "ok") {                        
                        $('#basic_info_ajax_load').hide();
                        var title = "Recruiter Information"
                        var url = base_url + "recruiter/general-info";
                        var obj = {
                            Title: title,
                            Url: url
                        };
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
            }, function(error) {});
        }
    };
    
});
app.controller('recruiterBasicInfoController', function($scope, $http, $location, $window, $timeout) {
    $scope.$parent.title = "Recruiter Profile | Aileensoul";
    $scope.jobByLocation = {};
    //$scope.basicinfo = {};
    getFieldList();

    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function(success) {
            $scope.fieldList = success.data;
        }, function(error) {});
    }
    $scope.jobTitle = function() {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchJobTitle',
            data: 'q=' + $scope.user.jobTitle,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.titleSearchResult = data;
        });
    }
    $scope.cityList = function() {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchCityList',
            data: 'q=' + $scope.user.cityList,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.citySearchResult = data;
        });
    }
    $("#jobTitle").focusin(function() {
        $('#jttooltip').show();
    });
    $("#jobTitle").focusout(function() {
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
    $scope.submitBasicInfoForm = function() {
        if ($scope.basicinfo.validate()) {
            angular.element('#basicinfo #submit').addClass("form_submit");
            angular.element('#basicinfo #submit').attr("style","pointer-events:none");
            $('#basic_info_ajax_load').show();
            $http({
                method: 'POST',
                url: base_url + 'user_info/ng_basic_info_insert',
                data: $scope.user,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
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
                        angular.element('#basicinfo #submit').removeAttr("style");
                        $('#basic_info_ajax_load').hide();
                        var title = "Recruiter Registrion"
                        var url = base_url + "recruiter/registration";
                        var obj = {
                            Title: title,
                            Url: url
                        };
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
            }, function(error) {});
        } else {
            return false;
        }
    };
});
app.controller('recruiterEduInfoController', function($scope, $http, $location, $window, $timeout) {
    $scope.$parent.title = "Recruiter Profile | Aileensoul";
    $("#currentStudy").focusin(function() {
        $('#cstooltip').show();
    });
    $("#currentStudy").focusout(function() {
        $('#cstooltip').hide();
    });
    $("#jobTitle").focusin(function() {
        $('#iftooltip').show();
    });
    $("#jobTitle").focusout(function() {
        $('#iftooltip').hide();
    });
    $scope.user = {};

    getFieldList();

    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function(success) {
            $scope.fieldList = success.data;
        }, function(error) {});
    }

    $scope.jobTitle = function() {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchJobTitle',
            data: 'q=' + $scope.user.jobTitle,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.titleSearchResult = data;
        });
    }
    $('#student_info_ajax_load').hide();
    $scope.currentStudy = function() {
        $http({
            method: 'POST',
            url: base_url + 'general_data/degreeList',
            data: 'q=' + $scope.user.currentStudy,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.degreeSearchResult = data;
        });
    }
    $scope.cityList = function() {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchCityList',
            data: 'q=' + $scope.user.cityList,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.citySearchResult = data;
        });
    }
    $scope.universityList = function() {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchUniversityList',
            data: 'q=' + $scope.user.universityName,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
                required: "Interested field is required.",
            }
        }
    };
    $scope.submitStudentInfoForm = function() {
        if ($scope.studentinfo.validate()) {
            angular.element('#studentinfo #submit').addClass("form_submit");
            angular.element('#studentinfo #submit').attr("style","pointer-events:none");
            $('#student_info_ajax_load').show();
            $http({
                method: 'POST',
                url: base_url + 'user_info/ng_student_info_insert',
                data: $scope.user,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {                
                angular.element('#studentinfo #submit').removeAttr("style");
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
                        var title = "Recruiter Registrion"
                        var url = base_url + "recruiter/registration";
                        var obj = {
                            Title: title,
                            Url: url
                        };
                        history.pushState(obj, obj.Title, obj.Url);
                    } else {
                        return false;
                    }
                }
            });
        } else {
            return false;
        }
    };
});
app.controller('recruiterCreateProfileController', function($scope, $http, $location, $window, $timeout) {
    // alert(first_name);
    $scope.$parent.title = "Recruiter Profile | Aileensoul";
    $("#email").focusin(function() {
        $('#emtooltip').show();
    });
    $("#email").focusout(function() {
        $('#emtooltip').hide();
    });
    $("#company_email").focusin(function() {
        $('#cetooltip').show();
    });
    $("#company_email").focusout(function() {
        $('#cetooltip').hide();
    });
    $("#company_profile").focusin(function() {
        $('#cptooltip').show();
    });
    $("#company_profile").focusout(function() {
        $('#cptooltip').hide();
    });
    $scope.recruiterRegiValidate = {
        rules: {
            first_name: {
                required: true,
                regx: /^[a-zA-Z]+$/,
            },
            last_name: {
                required: true,
                regx: /^[a-zA-Z]+$/,
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: base_url + "recruiter/check_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#email").val();
                        },
                    },
                },
            },
            job_title: {
                required: true,
            },
            company_name: {
                required: true,
                regx: /^[a-zA-Z0-9\s]*[a-zA-Z][a-zA-Z0-9]*[-@./#&+,\w\s]/
            },
            company_email: {
                required: true,
                email: true,
                remote: {
                    url: base_url + "recruiter/check_email_com",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#comp_email").val();
                        },
                    },
                },
            },
            company_number: {
                number: true,
                minlength: 8,
                maxlength: 15
            },
            comp_profile: {
                maxlength: 2500
            },
            country: {
                required: true,
            },
            state: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "First name is required.",
            },
            last_name: {
                required: "Last name is required.",
            },
            email: {
                required: "Email id is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },
            job_title: {
                required: "Current Position is required.",
            },
            company_name: {
                required: "Company name is required.",
            },
            company_email: {
                required: "Email address is required.",
                email: "Please enter valid email id.",
                remote: "Email already exists."
            },
            company_number: {
                required: "Phone no is required.",
            },
            country: {
                required: "Country is required.",
            },
            state: {
                required: "State is required.",
            },
        }
    };
    $scope.submitRecruiterRegiForm = function () {
        $scope.user.city = $("#city").val();
        $scope.user.state = $("#state").val();
        setTimeout(function(){
            $("#city").val($scope.user.city);
            $("#state").val($scope.user.state);
        },100);
        if ($scope.recruiterinfo.validate()) {
            $("#bidmodal").modal('show');            
            angular.element('#recruiterinfo #submit').attr("style","pointer-events: none;");
            angular.element('#recruiterinfo #submit').addClass("form_submit");
            $('#profilereg_ajax_load').show();
            $http({
                method: 'POST',
                url: base_url + 'recruiter/reg_insert_new',
                data: $scope.user,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                $('#profilereg_ajax_load').hide();
                angular.element('#recruiterinfo #submit').removeAttr("style");
                if (success.data.errors) {
                    $scope.errorFname = success.data.errors.errorFname;
                    $scope.errorLname = success.data.errors.errorLname;
                    $scope.errorEmail = success.data.errors.errorEmail;
                    $scope.errorJobtitle = success.data.errors.errorJobtitle;
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
                        // window.location = base_url + "recommended-candidates";
                        window.location = base_url + "post-job";
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
    };
});
$(window).on("load", function() {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});
// NEW HTML SCRIPT