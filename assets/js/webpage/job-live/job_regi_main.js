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

app.controller('jobRegiMainController', function ($scope, $http, $location, $window,$timeout) {
    if(userid != "" && profData == 0 && studData == 0)
    {        
        var title = "Basic Information"
        var url = base_url+"job-profile/basic-info";
        
        $location.path(url);

        var obj = {Title: title, Url: url};
        history.pushState(obj, obj.Title, obj.Url);
    }
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/job-profile/create-account", {
                templateUrl: base_url + "job_live/job_register",
                controller: 'jobRegiController'
            })
            .when("/job-profile/basic-info", {
                templateUrl: base_url + "job_live/job_basic_info",
                controller: 'jobBasicInfoController'
            })
            .when("/job-profile/educational-info", {
                templateUrl: base_url + "job_live/job_education_info",
                controller: 'jobEduInfoController'
            })
            .when("/job-profile/registration", {
                templateUrl: base_url + "job_live/job_create_profile",
                controller: 'jobCreateProfileController'
            })            
    $locationProvider.html5Mode(true);
});

app.controller('jobRegiController', function ($scope, $http, $location, $window,$timeout) {
    $scope.title = "Job By Location, Job Profile | Aileensoul";    
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
                        var title = "Basic Information"
                        var url = base_url+"job-profile/basic-info";
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
    /*$("#register_form").validate({
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
            }

        },
        submitHandler: submitRegisterForm
    });*/
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
                    var title = "Basic Information"
                    var url = base_url+"job-profile/basic-info";
                    
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

app.controller('jobBasicInfoController', function ($scope, $http, $location, $window,$timeout) {
    $scope.title = "Job By Skills, Job Profile | Aileensoul";    
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
                        var title = "Job Registrion"
                        var url = base_url+"job-profile/registration";

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

app.controller('jobEduInfoController', function ($scope, $http, $location, $window,$timeout) {
    $scope.title = "Job By Designation, Job Profile | Aileensoul";    
    $scope.jobByDesc = {};
    $scope.jobs = {};
    var isProcessing = false;    
});

app.controller('jobCreateProfileController', function ($scope, $http, $location, $window,$timeout) {
    $scope.title = "Job By Designation, Job Profile | Aileensoul";    
    $scope.jobByDesc = {};
    $scope.jobs = {};
    var isProcessing = false;    
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