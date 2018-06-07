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
    $scope.$parent.title = "Create freelancer Profile | Aileensoul";    
    $scope.jobByLocation = {};
    $scope.jobs = {};

    $("#selday,#selmonth,#selyear").focusin(function(){
        $('#dobtooltip').show();
    });
    $("#selday,#selmonth,#selyear").focusout(function(){
        $('#dobtooltip').hide();
    });

    $scope.regiValidate = {
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
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
            selyear: "selyear selmonth selday"
        },
        messages:
        {
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
                required: "Please Accept privacy policy,terms and conditions",
            }

        },
        errorPlacement: function (error, element) {
            if (element.attr("type") == "checkbox") {
                error.insertAfter($("#lbl_term_condi"));
            } else {
                error.insertAfter(element);
            }
        },
    };

    $scope.submitRegiForm = function () {
        if ($scope.register_form.validate())
        {
            $http({
            method: 'POST',
                    url: base_url + 'registration/reg_insert_new',
                    data: $scope.user,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success){

                if (success.data.errors) {
                    $scope.errorjobTitle = success.data.errors.jobTitle;
                    $scope.errorcityList = success.data.errors.cityList;
                    $scope.errorfield = success.data.errors.field;
                    $scope.errorotherField = success.data.errors.otherField;
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
    function submitRegisterForm()
    {
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var email_reg = $("#email_reg").val();
        var password_reg = $("#password_reg").val();
        var selday = $("#selday").val();
        var selmonth = $("#selmonth").val();
        var selyear = $("#selyear").val();
        var selgen = $("#selgen").val();

        var post_data = {
            'first_name': first_name,
            'last_name': last_name,
            'email_reg': email_reg,
            'password_reg': password_reg,
            'selday': selday,
            'selmonth': selmonth,
            'selyear': selyear,
            'selgen': selgen,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        }
        $.ajax({
            type: 'POST',
            url: base_url+'registration/reg_insert',
            dataType: 'json',
            data: post_data,
            beforeSend: function ()
            {
                $("#register_error").fadeOut();
                $("#btn-register").html('Sign Up ...');
            },
            success: function (response)
            {
                var userid = response.userid;
                if (response.okmsg == "ok")
                {
                    $("#btn-register").html('<img src="'+base_url+'images/btn-ajax-loader.gif" /> &nbsp; Sign Up ...');
                    var title = "freelancer Information"
                    var url = base_url+"freelance-employer/general-info";
                    
                    $location.path(url);

                    var obj = {Title: title, Url: url};
                    history.pushState(obj, obj.Title, obj.Url);

                    $timeout(function() {
                        var el = document.getElementById('ca');
                        angular.element(el).triggerHandler('click');
                    }, 0);
                } else {
                    $("#register_error").fadeIn(1000, function () {
                        $("#register_error").html('<div class="alert alert-danger registration"> <i class="fa fa-info-circle" aria-hidden="true"></i> &nbsp; ' + response + ' !</div>');
                        $("#btn-register").html('Sign Up');
                    });
                }
            }
        });
        return false;
    }
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
            jobTitle: {
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
            jobTitle: {
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
                // regx: /^[a-zA-Z]+$/,
            },
            last_name: {
                required: true,
                // regx: /^[a-zA-Z]+$/,
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
                        window.location = base_url + "hire-freelancer"
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