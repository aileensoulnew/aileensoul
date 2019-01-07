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

app.controller('businessRegiMainController', function ($scope, $http, $location, $window,$timeout) {

    if(userid != "" && profData == 0 && studData == 0)
    {        
        var title = "Business Basic Information"
        var url = base_url+"business-profile/basic-info";
        
        $location.path(url);

        var obj = {Title: title, Url: url};
        history.pushState(obj, obj.Title, obj.Url);
    }
    else if(userid == "")
    {
        var title = "Create Business Profile | Aileensoul"
        var url = base_url+"business-profile/create-account";
        
        $location.path(url);

        var obj = {Title: title, Url: url};
        history.pushState(obj, obj.Title, obj.Url);
    }
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/business-profile/create-account", {
                templateUrl: base_url + "business_profile_live/business_register",
                controller: 'businessRegiController'
            })
            .when("/business-profile/basic-info", {
                templateUrl: base_url + "business_profile_live/business_basic_info",
                controller: 'businessBasicInfoController'
            })
            .when("/business-profile/educational-info", {
                templateUrl: base_url + "business_profile_live/business_education_info",
                controller: 'businessEduInfoController'
            })
            .when("/business-profile/registration", {
                templateUrl: base_url + "business_profile_live/business_create_profile",
                controller: 'businessCreateProfileController'
            })            
    $locationProvider.html5Mode(true);
});

app.controller('businessRegiController', function ($scope, $http, $location, $window,$timeout) {
    var conn_new = new Strophe.Connection(openfirelink);
    $scope.$parent.title = "Create Business Profile | Aileensoul";    
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
                        var title = "Business Information"
                        var url = base_url+"business-profile/basic-info";
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

app.controller('businessBasicInfoController', function ($scope, $http, $location, $window,$timeout) {
    $scope.$parent.title = "Business Profile | Aileensoul";    
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
                        var title = "Business Registrion"
                        var url = base_url+"business-profile/registration";

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

app.controller('businessEduInfoController', function ($scope, $http, $location, $window,$timeout) {
    $scope.$parent.title = "Business Profile | Aileensoul";

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
                        var title = "Business Registrion"
                        var url = base_url+"business-profile/registration";
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

app.controller('businessCreateProfileController', function ($scope, $http, $location, $window,$timeout) {
    // alert(first_name);
    $scope.$parent.title = "Recruiter Profile | Aileensoul";

    $("#contactmobile").focusin(function(){
        $('#cmtooltip').show();
    });
    $("#contactmobile").focusout(function(){
        $('#cmtooltip').hide();
    });

    $("#business_details").focusin(function(){
        $('#bdtooltip').show();
    });
    $("#business_details").focusout(function(){
        $('#bdtooltip').hide();
    });

    function getCountry() {
        $http({
            method: 'GET',
            url: base_url + 'business_profile_registration/getCountry',
            headers: {'Content-Type': 'application/json'},
        }).then(function (data) {
            $scope.countryList = data.data;
        });
    }
    getCountry();

    function onCountryChange1(country_id = '') {        
        if(country_id != null)
        {            
            $http({
                method: 'POST',
                url: base_url + 'business_profile_registration/getStateByCountryId',
                data: {countryId: country_id}
            }).then(function (data) {
                $scope.stateList = data.data;            
            });
        }
    }

    $scope.onCountryChange = function () {
        if($scope.user.country != ""){            
            $scope.countryIdVal = $scope.user.country;
            onCountryChange1($scope.countryIdVal);
            //$scope.user.city = "";
        }
    };

    function onStateChange1(state_id = '') {
        if(state_id != null)
        {            
            $http({
                method: 'POST',
                url: base_url + 'business_profile_registration/getCityByStateId',
                data: {stateId: state_id}
            }).then(function (data) {
                if (angular.isDefined($scope.user.city)) {
                    delete $scope.user.city;
                }
                $scope.cityList = data.data;
            });
        }
    }

    $scope.onStateChange = function () {
        $scope.stateIdVal = $scope.user.state;
        onStateChange1($scope.stateIdVal);
    };

    function getDescription() {
        $http({
            method: 'POST',
            url: base_url + 'business_profile_registration/getDescription',
            headers: {'Content-Type': 'application/json'},
        }).then(function (data) {                                
            data = data.data;
            $scope.business_type = data['business_type'];
            $scope.industry_type = data['industriyaldata'];
        });
    }
    getDescription();

    $.validator.addMethod("regx1", function(value, element, regexpr) {
        if (!value) {
            return true;
        } else {
            return regexpr.test(value);
        }
    }, "Only space, only number and only special characters are not allow");
    $.validator.addMethod("regx2", function(value, element, regexpr) {
        if (!value) {
            return true;
        } else {
            return regexpr.test(value);
        }
    }, "Special character and space not allow in the beginning");

    $scope.businessRegiValidate = {
        rules: {
            companyname: {
                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            country: {
                required: true,
            },
            state: {
                required: true,
            },
            business_address: {
                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
            contactname: {
                required: true,
                regx1: /^[a-zA-Z\s]*[a-zA-Z]/
            },
            contactmobile: {
                required: true,
                number: true,
                minlength: 8,
                maxlength: 15,
                regx2: /^[0-9][0-9]*/
            },
            email: {
                required: true,
                email: true,
            },
            contactwebsite :{
                url:true
            },
            business_type: {
                required: true,
            },
            industriyal: {
                required: true,
            },
            business_details: {
                required: true,
                regx1: /^[-@./#&+,\w\s]*[a-zA-Z][a-zA-Z0-9]*/
            },
        },
        messages: {
            companyname: {
                required: 'Company name is required.',
            },
            country: {
                required: 'Country is required.',
            },
            state: {
                required: 'State is required.',
            },
            business_address: {
                required: 'Business address is required.',
            },
            contactname: {
                required: "Person name is required.",
            },
            contactmobile: {
                required: "Mobile number is required.",
            },
            email: {
                required: "Email id is required.",
                email: "Please enter valid email id.",
            },
            contactwebsite :{
                url: "Please enter valid URL With http or https.",
            },
            business_type: {
                required: "Business type is required.",
            },
            industriyal: {
                required: "Industrial is required.",
            },
            business_details: {
                required: "Business details is required.",
            },
        }
    };
    $scope.submitBusinessRegiForm = function () {
        if ($scope.businessinfo.validate()) {

            angular.element('#businessinfo #submit').addClass("form_submit");
            angular.element('#businessinfo #submit').css("pointer-events","none");
            $('#profilereg_ajax_load').show();
            $scope.loader_show = true;
            var form_data = new FormData($("#businessinfo")[0]);
            // angular.forEach($('#business_image')[0].files, function (file) {
            //     form_data.append('business_image[]', file);
            // });

            $http.post(base_url+'business_profile_registration/business_profile_insert',form_data,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false}
            }).then(function (data) {
                data = data.data;
                if (data.errors) {
                    err_arr = data.errors;                              
                    if(err_arr.already_exist)
                    {
                        $("#bus_err").modal("show");
                        $('#profilereg_ajax_load').hide();
                        angular.element('#businessinfo #submit').removeClass("form_submit");
                        angular.element('#businessinfo #submit').css("pointer-events","all");
                    }
                    else
                    {
                        $scope.errorImage = data.errors.image1;
                    }
                } else {
                    angular.element('#businessinfo #submit').css("pointer-events","all");
                    if (data.is_success == '1') {
                        angular.element('#businessinfo #submit').removeClass("form_submit");
                        $scope.loader_show = false;
                        window.location.href = base_url + 'business-profile';
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
/*$(document).on('change','#country', function () {
    var countryID = $(this).val();
    if (countryID) {
        $.ajax({
            type: 'POST',
            url: base_url + "business_profile_registration/getStateByCountryId",
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
            url: base_url + "business_profile/ajax_data",
            data: 'state_id=' + stateID,
            success: function (html) {
                $('#city').html(html);
            }
        });
    } else {
        $('#city').html('<option value="">Select state first</option>');
    }
});*/