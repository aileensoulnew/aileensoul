<!DOCTYPE html>
<html lang="en" ng-app="basicInfoApp" ng-controller="basicInfoController">
    <head>
        <base href="<?php echo base_url(); ?>" >
        <title ng-bind="title"></title>
        <!-- <meta name="robots" content="noindex, nofollow"> -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-commen.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/n-style.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/n-css/font-awesome.min.css') ?>">
        <script src="<?php echo base_url('assets/js/jquery.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js?ver=' . time()) ?>"></script>
        <style>
            #searchResult{
                list-style: none;
                padding: 0px;
                width: 500px;
                position: absolute;
                margin: 0;
            }

            #searchResult li{
                background: lavender;
                padding: 4px;
                margin-bottom: 1px;
            }

            #searchResult li.active{
                background: #000000;
            }

            #searchResult li:nth-child(even){
                background: cadetblue;
                color: white;
            }

            #searchResult li:hover{
                cursor: pointer;
            }

        </style>
    <?php $this->load->view('adsense'); ?>
</head>
    <body class="register">
        <?php echo $header_profile; ?>
        <div class="middle-section">
            <div ng-view></div>
        </div>
        <?php //echo $login_footer; ?>
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.validate.min.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular.min-1.6.4.js?ver=' . time()); ?>"></script>
        <script data-semver="0.13.0" src="<?php echo base_url('assets/js/angular/ui-bootstrap-tpls-0.13.0.min.js?ver=' . time()); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/js/angular/angular-route-1.6.4.js?ver=' . time()); ?>"></script>
        <script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            /*var slug = '<?php //echo $slugid; ?>'; // Pratik*/
            var user_id = '<?php echo $this->session->userdata('aileenuser'); ?>';
            var title = '<?php echo $title; ?>';
            /*var header_all_profile = '<?php //echo $header_all_profile; ?>'; // Pratik*/
            
            var app = angular.module("basicInfoApp", ['ngRoute', 'ui.bootstrap', 'ngValidate']);
            app.config(function ($routeProvider, $locationProvider) {
                $routeProvider
                .when("/basic-information", {
                    templateUrl: base_url + "user_info_page/basic_profile",
                    controller: 'basicInfoController'
                })
                .when("/educational-information", {
                    templateUrl: base_url + "user_info_page/educational_profile",
                    controller: 'studentInfoController'
                });
                $locationProvider.html5Mode(true);
            });
            app.controller('basicInfoController', function ($scope, $http, $location) {
                $scope.user = {};
                $('#basic_info_ajax_load').hide();

                // PROFEETIONAL DATA
                getFieldList();
                function getFieldList() {
                    $http.get(base_url + "general_data/getFieldList").then(function (success) {
                        $scope.fieldList = success.data;
                    }, function (error) {});
                }

                $scope.jobTitle = function () {
                    $http({
                        method: 'POST',
                        url: base_url + 'general_data/searchJobTitleStart',
                        data: 'q=' + $scope.user.jobTitle,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                    .then(function (success) {
                        data = success.data;
                        $scope.titleSearchResult = data;
                    });
                };

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
                };

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
                if ($scope.basicinfo.validate()) {
                    angular.element('#basicinfo #submit').addClass("form_submit");
                    angular.element('#basicinfo #submit').attr("style","pointer-events:none;");
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
                                angular.element('#basicinfo #submit').removeAttr("style");
                                $('#basic_info_ajax_load').hide();
                                window.location = base_url;
                            } else {
                                return false;
                            }
                        }
                    }, function (error){

                    });
                }
                else {
                    return false;
                }

                };
                    $scope.goMainLink = function(path){
                        location.href = path;
                    }
            });

            app.controller('studentInfoController', function ($scope, $http) {
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
                        angular.element('#studentinfo #submit').attr("style","pointer-events:none;");
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
                                    angular.element('#studentinfo #submit').removeAttr("style");
                                    $('#student_info_ajax_load').hide();
                                    window.location = base_url;
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
        </script>
        <script>
            var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
            showRight = document.getElementById( 'showRight' ),
            body = document.body;

            showRight.onclick = function() {
                classie.toggle( this, 'active' );
                classie.toggle( menuRight, 'cbp-spmenu-open' );
                disableOther( 'showRight' );
            };

            function disableOther( button ) {
                if( button !== 'showRight' ) {
                    classie.toggle( showRight, 'disabled' );
                }
            }

            $(function () {
                $('a[href="#search"]').on('click', function (event) {
                    event.preventDefault();
                    $('#search').addClass('open');
                    $('#search > form > input[type="search"]').focus();
                });
                $('#search, #search button.close-new').on('click keyup', function (event) {
                    if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                        $(this).removeClass('open');
                    }
                });
            });
        </script>
        <script src="<?php echo base_url('assets/js/webpage/user/user_header_profile.js?ver=' . time()) ?>"></script>
    </body>
</html>