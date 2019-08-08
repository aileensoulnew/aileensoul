var scopeHold;
app.directive('checkFileExt', ['$compile', function($compile) {

    return {
        restrict: 'A',
        scope: true,
        link: function(scope, element, attrs) {
            attrs.$observe('checkFile', function(text) {
                // console.log(text);
                var filename_arr = text.split('.');
                var upload_url = scope.$eval(attrs.checkFilePath);
                // console.log(filename_arr);
                //console.log(filename_arr[filename_arr.length - 1]);
                var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
                var allowed_doc_ext = ['pdf','PDF','docx','doc'];
                var fileExt = filename_arr[filename_arr.length - 1];
                /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                    var inner_html = $compile('<a href="'+upload_url+text+'" target="_blank"><img src="'+upload_url+text+'"></a>')(scope);
                }
                else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                    var inner_html = $compile('<a class="file-preview-cus" href="'+upload_url+text+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a>')(scope);   
                // }
                element.empty();
                element.append(inner_html);
            });
            
        }
    };
}]);
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

                var all_html = $.parseHTML(text);
                if ($(all_html).text().length > maxLength) {
                    // split the text in two parts, the first always showing

                    if(/^\<a.*\>.*\<\/a\>/i.test(text))
                    {
                    	var start = text.indexOf("<a href");
                    	var end = text.indexOf('target="_blank">');
                    	element.append(text);
                    }
                    else
                    {
                    	var firstPart = String($(all_html).text()).substring(0, maxLength);                    
	                    var secondPart = String(text).substring(maxLength, text.length);                    

	                    // create some new html elements to hold the separate info
	                    var firstSpan = $compile('<span ng-if="!collapsed">' + firstPart + '</span>')(scope);
	                    var secondSpan = $compile('<span ng-if="collapsed">' + text + '</span>')(scope);
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

app.directive('pTextCollapse', ['$compile', function($compile) {

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
            attrs.$observe('pTextCollapseText', function(text) {

                // get the length from the attributes
                var maxLength = scope.$eval(attrs.pTextCollapseMaxLength);
                var all_html = $.parseHTML(text);
                if ($(all_html).text().length > maxLength) {
                    // split the text in two parts, the first always showing
                    var firstPart = String($(all_html).text()).substring(0, maxLength);
                    var secondPart = String(text).substring(maxLength, text.length);

                    // create some new html elements to hold the separate info
                    var firstSpan = $compile('<span ng-if="!collapsed">' + firstPart + '</span>')(scope);
                    var secondSpan = $compile('<span ng-if="collapsed">' + text + '</span>')(scope);
                    var moreIndicatorSpan = $compile('<span ng-if="!collapsed">... </span>')(scope);
                    var lineBreak = $compile('<br ng-if="collapsed">')(scope);
                    var toggleButton = $compile('<span class="collapse-text-toggle">{{collapsed ? "" : ""}}</span>')(scope);//{{collapsed ? "View less" : "View more"}}

                    // remove the current contents of the element
                    // and add the new ones we created
                    element.empty();
                    element.append(firstSpan);
                    element.append(secondSpan);
                    element.append(moreIndicatorSpan);
                    element.append(lineBreak);
                    element.append(toggleButton);
                }
                else {
                    element.empty();
                    element.append(text);
                }
            });
        }
    };
}]);

app.filter('unsafe', function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
});

app.filter('charCount', function() {
    return function(text) {
    	var tmp = document.createElement("DIV");
	   	tmp.innerHTML = text;
	   	var str = tmp.textContent || tmp.innerText || "";
	   	console.log(str.length)
        return str.length;
    };
});

app.filter('wordFirstCase', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
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

        return slug;
    };
});

app.filter('removeLastCharacter', function () {
    return function (text) {
        return text.substr(0, text.lastIndexOf(".") + 1);
        //return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.filter('removeFirstCharacter', function() {
    return function(text) {
        return text.substr(1).toLowerCase();
        //return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.directive("owlCarousel", function () {
    return {
        restrict: 'E',
        link: function (scope) {
            scope.initCarousel = function (element) {
                // provide any default options you want
                var defaultOptions = {
                    loop: false,
                    nav: true,
                    lazyLoad: true,
                    margin: 0,
                    video: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 1
                        },
                        960: {
                            items: 1,
                        },
                        1200: {
                            items: 1
                        }
                    }
                };
                var customOptions = scope.$eval($(element).attr('data-options'));
                // combine the two options objects
                for (var key in customOptions) {
                    defaultOptions[key] = customOptions[key];
                }
                // init carousel
                $(element).owlCarousel(defaultOptions);
            };
        }
    };
});
app.directive('owlCarouselItem', [function () {
        return {
            restrict: 'A',
            link: function (scope, element) {
                // wait for the last item in the ng-repeat then call init
                if (scope.$last) {
                    scope.initCarousel(element.parent());
                }
            }
        };
    }]);
/*app.directive('fileInput', function ($parse) {
    return {
        restrict: 'A',
        link: function ($scope, element, attrs) {
            $(element).fileinput({
                uploadUrl: '#',
                allowedFileExtensions: ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg', 'mp4', 'mp3', 'pdf'],
                overwriteInitial: false,
                initialPreviewAsData : true,
                maxFileSize: 1000000,
                maxFilesNum: 10,
                //validateInitialCount: true,
                //allowedFileTypes: ['image','video', 'flash'],
                slugCallback: function (filename) {
                    return filename.replace('(', '_').replace(']', '_');
                }
            });
            element.on("change", function (event) {                
                var files = event.target.files;
                console.log(event.target.files.length);
                $parse(attrs.fileInput).assign($scope, element[0].files);
                $scope.$apply();
            });
        }
    };
});*/

// AUTO SCROLL MESSAGE DIV FIRST TIME END
app.directive('ngEnter', function () {			// custom directive for sending message on enter click
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13 && !event.shiftKey) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});
app.directive("editableText", function () {
    return {
        controller: 'EditorController',
        restrict: 'C',
        replace: true,
        transclude: true,
    };
});
app.controller('EditorController', ['$scope', function ($scope) {
    $scope.handlePaste = function (e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
    };
}]);

app.controller('userProfileController', function ($scope, $http) {
    var url = window.location.href;
    $scope.active = url.substring(url.lastIndexOf("/") + 1);
    //$scope.active = $scope.active == item ? '' : item;
    $scope.pade_reload = true;
    $scope.makeActive = function (item) {
        $scope.pade_reload = false;
        $scope.active = $scope.active == item ? '' : item;
    }
    $scope.live_slug = live_slug;
    $scope.segment2 = segment2;
    $scope.user_slug = user_data_slug;
    $scope.to_id = to_id;
    $scope.contact_value = contact_value;
    $scope.contact_status = contact_status;
    $scope.contact_id = contact_id;
    $scope.follow_value = follow_value;
    $scope.follow_status = follow_status;
    $scope.follow_id = follow_id;

    $scope.get_field_list = function() {
        $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {});
    }
    $scope.get_field_list();   

    $scope.get_user_detail = function(){
        $http.get(base_url + "userprofile_page/get_user_data").then(function (success) {

            var professionData = success.data.professionData
            var studentData = success.data.studentData;
            
            if(professionData != null && professionData)
            {
                $("#user-basic-info").show();
                $("#user-student-info").hide();
                setTimeout(function(){
                    $("#basic_job_title").val(professionData.job_title);
                    $("#basic_info_city").val(professionData.city_name);
                    $("#basic_info_field").val(professionData.field);
                    if(professionData.field == 0)
                    {
                        $("#basic_info_other_field_div").show();
                        $("#basic_info_other_field").val(professionData.other_field);
                    }
                },500);
            }
            if(studentData != null && studentData)
            {
                $("#user-basic-info").hide();
                $("#user-student-info").show();
                setTimeout(function(){
                    $("#stud_info_study").val(studentData.degree_name);
                    $("#stud_info_city").val(studentData.city_name);
                    $("#stud_info_university").val(studentData.university_name);
                    $("#stud_info_field").val(studentData.interested_fields);
                    if(studentData.interested_fields == 0)
                    {
                        $("#stud_info_other_field_div").show();
                        $("#stud_info_other_field").val(studentData.other_interested_fields);
                    }
                },500);
            }
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_detail();
            },500);
        });
    };
    $scope.get_user_detail();
    $scope.open_student = function()
    {
        $("#user-basic-info").hide();
        $("#user-student-info").show();
    };

    $scope.other_basic_info = function(){
        if($scope.basic_info_field != "" && $scope.basic_info_field == 0)
        {
            $("#basic_info_other_field_div").show();
        }
        else
        {
            $("#basic_info_other_field_div").hide();
        }
    };

    $scope.basic_job_title_list = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchJobTitleStart',
            data: 'q=' + $scope.basic_job_title,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            data = success.data;
            $scope.titleSearchResult = data;
        }, function (error) {
            setTimeout(function(){
                $scope.basic_job_title_list();
            },500);
        });
    };

    $scope.basic_info_city_list = function () {
        $http({
        method: 'POST',
                url: base_url + 'general_data/searchCityList',
                data: 'q=' + $scope.basic_info_city,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            data = success.data;
            $scope.citySearchResult = data;
        }, function (error) {
            setTimeout(function(){
                $scope.basic_info_city_list();
            },500);
        });
    }
    // $scope.basic_info_city();

    $scope.basic_info_validate = {
        rules: {
            basic_job_title: {
                required: true,
            },
            basic_info_city: {
                required: true,
            },
            basic_info_field: {
                required: true,
            },
            basic_info_other_field: {
                required: {
                    depends: function(element) {
                        return $("#basic_info_field option:selected").val() == 0 ? true : false;
                    }
                },
            },
        },
        messages: {
            basic_job_title: {
                required: "Job title is required.",
            },
            basic_info_city: {
                required: "City is required.",
            },
            basic_info_field: {
                required: "Field id is required.",
            }
        }
    };
    $scope.save_user_basicinfo = function(){
        if ($scope.basicinfo.validate()) {
            $("#user_basicinfo_loader").show();
            $("#user_basicinfo").attr("style","pointer-events:none;display:none;");
            var basic_job_title = $('#basic_job_title').val();
            var basic_info_city = $('#basic_info_city').val();
            var basic_info_field = $('#basic_info_field option:selected').val();
            var basic_info_other_field = $('#basic_info_other_field').val();
            var updatedata = $.param({'basic_job_title':basic_job_title,'basic_info_city':basic_info_city,'basic_info_field':basic_info_field,'basic_info_other_field':basic_info_other_field});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/save_user_basicinfo',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {
                // $('#main_page_load').show();                
                success = result.data.success;
                $("#basicinfo")[0].reset();
                $("#studinfo")[0].reset();
                if(success == 1)
                {
                    $("#hpd").html(basic_job_title);
                    $("#hpc").html(basic_info_city);
                    $scope.get_user_detail();
                }
                $("#user_basicinfo").removeAttr("style");
                $("#user_basicinfo_loader").hide();
                $("#user-info-edit").modal('hide');
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_basicinfo();
                },500);
            });
        }
    };    

    $scope.open_basicinfo = function()
    {
        $("#user-basic-info").show();
        $("#user-student-info").hide();
    };

    $scope.other_stud_info = function(){
        if($scope.stud_info_field != "" && $scope.stud_info_field == 0)
        {
            $("#stud_info_other_field_div").show();
        }
        else
        {
            $("#stud_info_other_field_div").hide();
        }
    };

    $scope.stud_info_study_list = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/degreeList',
            data: 'q=' + $scope.stud_info_study,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.degreeSearchResult = data;
        }, function (error) {
            setTimeout(function(){
                $scope.stud_info_study_list();
            },500);
        });
    }

    $scope.stud_info_city_list = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchCityList',
            data: 'q=' + $scope.stud_info_city,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.citySearchResult = data;
        }, function (error) {
            setTimeout(function(){
                $scope.stud_info_city_list();
            },500);
        });
    }

    $scope.stud_info_university_list = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchUniversityList',
            data: 'q=' + $scope.stud_info_university,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.universitySearchResult = data;
        }, function (error) {
            setTimeout(function(){
                $scope.stud_info_university_list();
            },500);
        });
    }

    $scope.stud_info_validate = {
        rules: {
            stud_info_study: {
                required: true,
            },
            stud_info_city: {
                required: true,
            },
            stud_info_university: {
                required: true,
            },            
            stud_info_field: {
                required: true,
            },
            stud_info_other_field: {
                required: {
                    depends: function(element) {
                        return $("#stud_info_field option:selected").val() == 0 ? true : false;
                    }
                },
            },
        },
        messages: {
            stud_info_study: {
                required: "Current study is required.",
            },
            stud_info_city: {
                required: "City is required.",
            },
            stud_info_university: {
                required: "University name is required.",
            },
            stud_info_field: {
                required:  "Interested field is required.",
            }
        }
    };

    $scope.save_user_studinfo = function(){
        if ($scope.studinfo.validate()) {
            $("#user_studinfo_loader").show();
            $("#user_studinfo").attr("style","pointer-events:none;display:none;");
            var stud_info_study = $('#stud_info_study').val();
            var stud_info_city = $('#stud_info_city').val();
            var stud_info_university = $('#stud_info_university').val();
            var stud_info_field = $('#stud_info_field option:selected').val();
            var stud_info_other_field = $('#stud_info_other_field').val();
            var updatedata = $.param({'stud_info_study':stud_info_study,'stud_info_city':stud_info_city,'stud_info_university':stud_info_university,'stud_info_field':stud_info_field,'stud_info_other_field':stud_info_other_field});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/save_user_studinfo',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                $("#studinfo")[0].reset();
                $("#basicinfo")[0].reset();
                if(success == 1)
                {
                    $("#hpd").html(stud_info_study);
                    $("#hpc").html(stud_info_city);
                    $scope.get_user_detail();
                }
                $("#user_studinfo").removeAttr("style");
                $("#user_studinfo_loader").hide();
                $("#user-info-edit").modal('hide');
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_studinfo();
                },500);
            });
        }
    };

    $scope.contact = function (id, status, to_id, confirm) {
        // alert(status);
        // return false;
        if(confirm == '1')
        {
            $("#remove-contact-conform").modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addcontact',
            data: 'contact_id=' + id + '&status=' + status + '&to_id=' + to_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) { 
            if(socket)
            {
                socket.emit('user notification',to_id);
            }
            $scope.contact_value = success.data.trim();
            $scope.get_all_counter();
        }, function (error) {
            setTimeout(function(){
                $scope.contact(id, status, to_id, confirm);
            },500);
        });
    };

    $scope.remove_contact = function (id, status, to_id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addcontact',
            data: 'contact_id=' + id + '&status=' + status + '&to_id=' + to_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            if(socket)
            {
                socket.emit('user notification',to_id);
            }
            $scope.contact_value = success.data.trim();
            $scope.get_all_counter();
        }, function (error) {
            setTimeout(function(){
                $scope.remove_contact(id, status, to_id);
            },500);
        });
    };

    $scope.confirmContactRequestInnerHeader = function (from_id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=confirm',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if(socket)
            {
                socket.emit('user notification',from_id);
            }
            $scope.contact_value = 'confirm';
        }, function (error) {
            setTimeout(function(){
                $scope.confirmContactRequestInnerHeader(from_id);
            },500);
        });
    };
    $scope.follow = function (id, status, to_id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addfollow',
            data: 'follow_id=' + id + '&status=' + status + '&to_id=' + to_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            if(socket)
            {
                socket.emit('user notification',to_id);
            }
            $scope.follow_value = success.data;
        }, function (error) {
            setTimeout(function(){
                $scope.follow(id, status, to_id);
            },500);
        });
    };
});
app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when(":name*\/monetization-analytics", {
                templateUrl: base_url + "userprofile_page/monetization_analytics",
                controller: 'monetizationController'
            })
            .when(":name*\/details", {
                templateUrl: base_url + "userprofile_page/details",
                controller: 'detailsController'
            })
            .when(":name*\/contacts", {
                templateUrl: base_url + "userprofile_page/contacts",
                controller: 'contactsController'
            })
            .when(":name*\/followers", {
                templateUrl: base_url + "userprofile_page/followers",
                controller: 'followersController'
            })
            .when(":name*\/following", {
                templateUrl: base_url + "userprofile_page/following",
                controller: 'followingController'
            })
            .when(":name*\/hashtags", {
                templateUrl: base_url + "userprofile_page/user_hashtags",
                controller: 'hashtagController'
            })
            .when(":name*\/questions", {
                templateUrl: base_url + "userprofile_page/questions",
                controller: 'questionsController'
            })
            .when(":name*\/savedpost", {
                templateUrl: base_url + "userprofile_page/savedpost",
                controller: 'savedpostController'
            })
            .when(":name*\/profiles", {
                templateUrl: base_url + "userprofile_page/profile",
                controller: 'profilesController'
            })
            .when(":name*\/photos", {
                templateUrl: base_url + "userprofile_page/photos",
                controller: 'dashboardPhotosController'
            })
            .when(":name*\/videos", {
                templateUrl: base_url + "userprofile_page/videos",
                controller: 'dashboardVideoController'
            })
            .when(":name*\/audios", {
                templateUrl: base_url + "userprofile_page/audios",
                controller: 'dashboardAudiosController'
            })
            .when(":name*\/pdf", {
                templateUrl: base_url + "userprofile_page/pdf",
                controller: 'dashboardPdfController'
            })
            .when(":name*\/article", {
                templateUrl: base_url + "userprofile_page/article",
                controller: 'dashboardArticleController'
            })
            .otherwise({
                templateUrl: base_url + "userprofile_page/dashboard",
                controller: 'dashboardController'
            });
    $locationProvider.html5Mode(true);
});
app.controller('profilesController', function ($scope, $http, $location) {
    $scope.today = new Date();
    window.location = base_url;
    $scope.user = {};
    // PROFEETIONAL DATA

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }
            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();

    $scope.$parent.title = "Profiles | Aileensoul";    
    getFieldList();
    function getFieldList() {
        if($scope.$parent.pade_reload == true)
        {
            $('#main_loader').show();            
        }
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/profiles_data',
            data: 'u=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {            
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            details_data = success.data;
            $scope.details_data = details_data;
        }, function (error) {
            setTimeout(function(){
                getFieldList();
            },500);
        });
        
        $('footer').show();
    }
});

app.controller('dashboardArticleController', function ($scope, $http, $location, $window) {
    /*$('.post_loader').hide();
    $('#main_loader').hide();
    $('body').removeClass("body-loader");*/
    $scope.makeActive = function (item,slug) {
        $scope.active = $scope.active == item ? '' : item;
    }

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }
            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();

    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 6;
    $scope.buttonText = "Load More";

    // Fetch data
    $scope.getDashboardArticle = function (pagenum) {
        $('.load_more_post').show();
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();
            }
            //$('#main_loader').show();
        }
        $http({
            method: 'post',
            url: base_url + "userprofile_page/article_data?page=" + pagenum+"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {            
            $('.load_more_post').hide();
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (response.data != '') {
                $scope.pagedata = response.data.pagedata;
                $scope.page_number = response.data.pagedata.page;
                $scope.total_record = response.data.pagedata.total_record;
                $scope.perpage_record = response.data.pagedata.perpage_record;
                //$scope.row += $scope.rowperpage;
                if ($scope.articleData != undefined) {
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.articlerecord) {                        
                        $scope.articleData.push(response.data.articlerecord[i]);
                        /*$scope.$apply(function() {
                            $scope.articleData.push(response.data.articlerecord[i]);
                        });*/
                    }
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.articleData = response.data.articlerecord;
                }                
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        }, function (error) {
            setTimeout(function(){
                $scope.getDashboardArticle(pagenum);
            },500);
        });
    }
    angular.element($window).bind("scroll", function (e) {
        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // alert(parseInt(perpage_record * page));
            // alert(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.getDashboardArticle(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getDashboardArticle();

    $scope.user = {};    
});
app.controller('dashboardPdfController', function ($scope, $http, $location, $window) {
    $scope.makeActive = function (item,slug) {
        $scope.active = $scope.active == item ? '' : item;
    }
    // lazzy loader start

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }
            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();

    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 6;
    $scope.buttonText = "Load More";

    $scope.page_number = 0;
    $scope.total_record = '';
    $scope.perpage_record = 5;

    var isProcessing = false;
    // Fetch data
    $scope.getDashboardPdf = function (pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $('.loadmore').show();
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
             if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
            //$('#main_loader').show();
        }
        $http({
            method: 'post',
            url: base_url + "userprofile_page/pdf_data?page=" + pagenum+"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            $('.loadmore').hide();
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (response.data != '') {
                $scope.pagedata = response.data.pagedata;
                $scope.page_number = response.data.pagedata.page;
                $scope.total_record = response.data.pagedata.total_record;
                $scope.perpage_record = response.data.pagedata.perpage_record;
                //$scope.row += $scope.rowperpage;
                if ($scope.pdfData != undefined) {
                    isProcessing = false;
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.pdfrecord) {
                        $scope.pdfData.push(response.data.pdfrecord[i]);
                    }
                } else {
                    isProcessing = false;
                    $scope.pagecntctData = response.data;
                    $scope.pdfData = response.data.pdfrecord;
                }                
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        }, function (error) {
            setTimeout(function(){
                $scope.getDashboardPdf(pagenum);
            },500);
        });
    }
    angular.element($window).bind("scroll", function (e) {
        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // alert(parseInt(perpage_record * page));
            // alert(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.getDashboardPdf(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getDashboardPdf();
    //lazzy loader end

    $scope.user = {};
    
});

app.controller('dashboardAudiosController', function ($scope, $http, $location, $window) {
    $scope.makeActive = function (item,slug) {
        $scope.active = $scope.active == item ? '' : item;
    }
    // lazzy loader start

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();

    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 6;
    $scope.buttonText = "Load More";

    
    // Fetch data
    $scope.getDashboardAudios = function (pagenum) {
        $('.post_loader').show();
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
             if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }
        $http({
            method: 'post',
            url: base_url + "userprofile_page/audios_data?page=" + pagenum+"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            $('.post_loader').hide();
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (response.data != '') {
                $scope.pagedata = response.data.pagedata;
                $scope.page_number = response.data.pagedata.page;
                $scope.total_record = response.data.pagedata.total_record;
                $scope.perpage_record = response.data.pagedata.perpage_record;
                //$scope.row += $scope.rowperpage;
                if ($scope.audioData != undefined) {
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.videorecord) {
                        $scope.audioData.push(response.data.videorecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.audioData = response.data.videorecord;
                }
                setTimeout(function(){
                    var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

                    for (i = 0; i < total; i++) {
                        if($(mediaElements[i])[0].id == '')
                        {                            
                            new MediaElementPlayer(mediaElements[i], {
                                stretching: 'auto',
                                pluginPath: '../../../build/',
                                success: function (media) {
                                    var renderer = document.getElementById(media.id + '-rendername');

                                    media.addEventListener('loadedmetadata', function () {
                                        var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                                        if (src !== null && src !== undefined) {
                                            // renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                                            // renderer.querySelector('.renderer').innerHTML = media.rendererName;
                                            // renderer.querySelector('.error').innerHTML = '';
                                        }
                                    });

                                    media.addEventListener('error', function (e) {
                                        renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                                    });
                                }
                            });
                        }
                    }
                    // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
                },1000);
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        }, function (error) {
            setTimeout(function(){
                $scope.getDashboardAudios(pagenum);
            },500);
        });
    }
    angular.element($window).bind("scroll", function (e) {
        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // alert(parseInt(perpage_record * page));
            // alert(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.getDashboardAudios(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getDashboardAudios();
    //lazzy loader end

    $scope.user = {};
    
});

app.controller('dashboardVideoController', function ($scope, $http, $location, $window) {
    $scope.makeActive = function (item,slug) {
        $scope.active = $scope.active == item ? '' : item;
    }

    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $('.modal-close').click();            
        }
    });

    // lazzy loader start

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();

    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 6;
    $scope.buttonText = "Load More";

    $scope.page_number = 0;
    $scope.total_record = '';
    $scope.perpage_record = 5;

    $scope.openModal = function() {
        document.getElementById('myModalVideo').style.display = "block";
        $("body").addClass("modal-open");
    };
    $scope.closeModal = function() {    
        document.getElementById('myModalVideo').style.display = "none";
        $("body").removeClass("modal-open");
    };
    //var slideIndex = 1;
    //showSlides(slideIndex);
    $scope.plusSlides = function(n) {    
        showSlides(slideIndex += n);
    };
    $scope.currentSlide = function(n) {    
        showSlides(slideIndex = n);
    };
    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        //var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        
        

        /*var elem = $("#element_load_"+slideIndex);

        $("#myModalPhotos #all_image_loader").hide();
        if (!elem.prop('complete')) {
            $("#myModalPhotos #all_image_loader").show();
            elem.on('load', function() {
                $("#myModalPhotos #all_image_loader").hide();
                // console.log("Loaded!");
                // console.log(this.complete);
            });
        }*/
        /*for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }*/
        slides[slideIndex - 1].style.display = "block";
        //dots[slideIndex - 1].className += " active";
        //captionText.innerHTML = dots[slideIndex - 1].alt;
        //$("#videoplayer_"+slideIndex)[0].play(); 
        setTimeout(function(){ $("#videoplayer_"+slideIndex)[0].play(); }, 300);
    }
    var isProcessing = false;
    
    // Fetch data
    $scope.getDashboardVideos = function (pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $('.loadmore').show();
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
             if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }
            
        $http({
            method: 'post',
            url: base_url + "userprofile_page/videos_data?page=" + pagenum+"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            $('.post_loader').hide();
            if (response.data != '') {
                $scope.pagedata = response.data.videoData.pagedata;
                $scope.page_number = response.data.videoData.pagedata.page;
                $scope.total_record = response.data.videoData.pagedata.total_record;
                $scope.perpage_record = response.data.videoData.pagedata.perpage_record;                
                //$scope.row += $scope.rowperpage;
                if ($scope.videoData != undefined) {
                    isProcessing = false;
                    $scope.page_number = response.data.videoData.pagedata.page;
                    for (var i in response.data.videoData.videorecord) {
                        $scope.videoData.push(response.data.videoData.videorecord[i]);
                    }
                } else {
                    isProcessing = false;
                    $scope.pagecntctData = response.data.videoData;
                    $scope.videoData = response.data.videoData.videorecord;
                }
                if(pagenum == undefined || pagenum == "" || pagenum == 1)
                {
                    $scope.allVideosData = response.data.allVideosData;   
                }
                setTimeout(function(){
                    var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

                    for (i = 0; i < total; i++) {                        
                        if($(mediaElements[i])[0].id == '')
                        {

                            new MediaElementPlayer(mediaElements[i], {
                                stretching: 'auto',
                                pluginPath: '../../../build/',
                                success: function (media) {
                                    var renderer = document.getElementById(media.id + '-rendername');

                                    media.addEventListener('loadedmetadata', function () {
                                        var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                                        if (src !== null && src !== undefined) {
                                            // renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                                            // renderer.querySelector('.renderer').innerHTML = media.rendererName;
                                            // renderer.querySelector('.error').innerHTML = '';
                                        }
                                    });

                                    media.addEventListener('error', function (e) {
                                        renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                                    });
                                }
                            });
                        }
                    }
                    // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
                },1000);
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        }, function (error) {
            setTimeout(function(){
                isProcessing = false;
                $scope.getDashboardVideos(pagenum);
            },500);
        });
    }
    angular.element($window).bind("scroll", function (e) {
        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // alert(parseInt(perpage_record * page));
            // alert(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {                    
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.getDashboardVideos(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getDashboardVideos();
    //lazzy loader end

    $scope.user = {};
    
});

app.controller('dashboardPhotosController', function ($scope, $http, $location, $window) {
    $scope.$parent.title = "Photos | Aileensoul";
    $scope.makeActive = function (item,slug) {
        $scope.active = $scope.active == item ? '' : item;
    }
    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $('.modal-close').click();            
        }
    });
    // lazzy loader start

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();

    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 6;
    $scope.buttonText = "Load More";

    $scope.openModal = function() {
        document.getElementById('myModalPhotos').style.display = "block";
        $("body").addClass("modal-open");
    };
    $scope.closeModal = function() {    
        document.getElementById('myModalPhotos').style.display = "none";
        $("body").removeClass("modal-open");
    };
    //var slideIndex = 1;
    //showSlides(slideIndex);
    $scope.plusSlides = function(n) {    
        showSlides(slideIndex += n);
    };
    $scope.currentSlide = function(n) {    
        showSlides(slideIndex = n);
    };
    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        //var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        var elem = $("#element_load_"+slideIndex);

        $("#myModalPhotos #all_image_loader").hide();
        if (!elem.prop('complete')) {
            $("#myModalPhotos #all_image_loader").show();
            elem.on('load', function() {
                $("#myModalPhotos #all_image_loader").hide();
                // console.log("Loaded!");
                // console.log(this.complete);
            });
        }
        /*for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }*/
        slides[slideIndex - 1].style.display = "block";
        //dots[slideIndex - 1].className += " active";
        //captionText.innerHTML = dots[slideIndex - 1].alt;
    }
    var isProcessing = false;
    // Fetch data
    $scope.getDashboardPhotos = function (pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $('.loadmore').show();
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
             if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }
        $http({
            method: 'post',
            url: base_url + "userprofile_page/photos_data?page=" + pagenum+"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            $('.loadmore').hide();
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            //console.log(response.data.photosData);
            if (response.data != '') {
                $scope.pagedata = response.data.photosData.pagedata;
                $scope.page_number = response.data.photosData.pagedata.page;
                $scope.total_record = response.data.photosData.pagedata.total_record;
                $scope.perpage_record = response.data.photosData.pagedata.perpage_record;
                //$scope.row += $scope.rowperpage;
                if ($scope.photoData != undefined) {
                    isProcessing = false;
                    $scope.page_number = response.data.photosData.pagedata.page;
                    for (var i in response.data.photosData.photosrecord) {
                        $scope.photoData.push(response.data.photosData.photosrecord[i]);
                    }
                } else {
                    isProcessing = false;
                    $scope.pagecntctData = response.data.photosData;
                    $scope.photoData = response.data.photosData.photosrecord;
                }
                if(pagenum == undefined || pagenum == "1" || pagenum == "")
                {
                    $scope.allPhotosData = response.data.allPhotosData;   
                }
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        }, function (error) {
            setTimeout(function(){
                $scope.getDashboardPhotos(pagenum);
            },500);
        });
    }
    angular.element($window).bind("scroll", function (e) {
        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // alert(parseInt(perpage_record * page));
            // alert(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.getDashboardPhotos(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getDashboardPhotos();
    //lazzy loader end

    $scope.user = {};
    
});

app.controller('dashboardController', function ($scope, $compile, $http, $location) {
    $scope.today = new Date();

    $scope.opp = {};
    $scope.sim = {};
    $scope.ask = {};
    $scope.postData = {};
    $scope.opp.post_for = 'opportunity';
    $scope.sim.post_for = 'simple';
    $scope.ask.post_for = 'question';
    $scope.user_id = user_id;

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
                // var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
                var hh = $scope.today.getHours() < 10 ? '0'+$scope.today.getHours() : $scope.today.getHours();
                var mm = $scope.today.getMinutes() < 10 ? '0'+$scope.today.getMinutes() : $scope.today.getMinutes();
                var ss = $scope.today.getSeconds() < 10 ? '0'+$scope.today.getSeconds() : $scope.today.getSeconds();
                var times = hh+''+mm+''+ss;
                var all_html = '';
                if(data.user_type.toString() == '2')
                {
                    all_html += '<div class="bus-tooltip">';
                        all_html += '<div class="user-tooltip">';
                        
                            all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background)
                            {
                                all_html += '<img src="'+bus_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else
                            {
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';   
                            }
                            all_html += '</div>';

                            all_html += '<div class="tooltip-user-detail">';
                                all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.business_user_image)
                                {
                                    all_html += '<img src="'+bus_profile_thumb_upload_url+data.user_data.business_user_image+'">';
                                }
                                else
                                {
                                    all_html += '<img src="'+base_url+nobusimage+'">';
                                }
                                all_html += '</div>';
                                
                                all_html += '<div class="fw">';
                                    all_html += '<div class="tooltip-detail">';
                                        all_html += '<h4>'+data.user_data.company_name+'</h4>';
                                        all_html += '<p>';
                                            if(data.user_data.industry_name){
                                                all_html += data.user_data.industry_name;
                                            }
                                            else{
                                                all_html += "Current Work";
                                            }
                                        all_html += '</p>';

                                        all_html += '<p>';
                                            all_html += data.user_data.city_name + (data.user_data.state_name != '' ? ',' : '') + data.user_data.state_name + (data.user_data.country_name != '' ? ',' : '') + data.user_data.country_name;
                                        all_html += '</p>';
                                    all_html += '</div>';

                                    if(data.user_data.user_id != login_user_id){
                                        all_html += '<div class="tooltip-btns follow-btn-bus-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user_bus(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</div>';
                                    }

                                all_html += '</div>';

                            all_html += '</div>';
                        all_html += '</div>';
                    all_html += '</div>';
                }
                if(data.user_type.toString() == '1')
                {
                    all_html += '<div class="user-tooltip">';
                        all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background){
                                all_html += '<img src="'+user_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else{
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';
                            }
                        all_html += '</div>';
                        all_html += '<div class="tooltip-user-detail">';
                            all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.user_image){
                                    all_html += '<img src="'+user_profile_80x80_upload_url+data.user_data.user_image+'">';
                                }
                                else
                                {
                                    if(data.user_data.user_gender == 'M'){
                                        all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                    }
                                    if(data.user_data.user_gender == 'F'){
                                        all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                    }
                                }
                            all_html += '</div>';

                            // all_html += '<h4>'+data.user_data.fullname+'</h4>';
                            all_html += '<h4><a href="'+base_url+data.user_data.user_slug+'" target="_self">'+data.user_data.fullname+'</a></h4>';
                            all_html += '<p>';
                                if(data.user_data.title_name && !data.user_data.degree_name){
                                    all_html += (data.user_data.title_name.length > 30 ? data.user_data.title_name.substr(0,30)+'...' : data.user_data.title_name);
                                }
                                else if(!data.user_data.title_name && data.user_data.degree_name){
                                    all_html += (data.user_data.degree_name.length > 30 ? data.user_data.degree_name.substr(0,30)+'...' : data.user_data.degree_name);
                                }
                                else{
                                    all_html += "Current Work";
                                }
                            all_html += '</p>';
                            if(data.post_count != '' || data.contact_count != '' || data.follower_count != ''){
                                all_html += '<p>';
                                    if(data.post_count != ''){
                                        all_html += '<span><b>'+data.post_count+'</b> Posts</span>';
                                    }
                                    if(data.contact_count != ''){
                                        all_html += '<span><b>'+data.contact_count+'</b> Contacts</span>';
                                    }
                                    if(data.follower_count != ''){
                                        all_html += '<span><b>'+data.follower_count+'</b> Followers</span>';
                                    }
                                all_html += '</p>';
                            }
                            if(data.mutual_friend.length > 0){
                                all_html += '<ul>';
                                // data.mutual_friend.forEach(function(friends,index){
                                for(var i=0;i<data.mutual_friend.length;i++){
                                    if(i == 2)
                                    {
                                        break;
                                    }
                                    friends = data.mutual_friend[i];
                                    all_html += '<li><div class="user-img">';
                                    if(friends.user_image){
                                        all_html += '<img src="'+user_thumb_upload_url+friends.user_image+'">';
                                    }
                                    else
                                    {                        
                                        if(friends.user_gender == 'M'){
                                            all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                        }
                                        if(friends.user_gender == 'F'){
                                            all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                        }
                                    }
                                    all_html += '</div></li>';
                                }

                                all_html += '<li class="m-contacts">';
                                    if(data.mutual_friend.length == 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> is in mutual contact.</span>';
                                    }
                                    else if(data.mutual_friend.length > 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> and <b>'+parseInt(data.mutual_friend.length - 1)+'</b> more mutual contacts.</span>';
                                    }
                                all_html += '</li>';
                                all_html += '</ul>';
                            }

                            if(data.user_data.user_id != login_user_id){
                                all_html += '<div class="tooltip-btns">';
                                    all_html += '<ul>';
                                        all_html += '<li class="contact-btn-'+data.user_data.user_id+'">';
                                            if(data.contact_value == 'new'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'confirm'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',1" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">In Contacts</a>';
                                            }
                                            else if(data.contact_value == 'pending'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Request sent</a>';
                                            }
                                            else if(data.contact_value == 'cancel'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'reject'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li class="follow-btn-user-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li>';
                                            all_html += '<a href="'+message_url+'user/'+data.user_data.user_slug+'" class="btn-new-1" target="_blank">Message</a>';
                                        all_html += '</li>';

                                    all_html += '</ul>';
                                all_html += '</div>';
                            }

                        all_html += '</div>';
                    all_html += '</div>';
                }            
                /*setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);*/
                $('#'+div_id).html(all_html);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }
    /*$scope.makeActive = function (item,slug) {
        $scope.active = $scope.active == item ? '' : item;
    }*/
    // $scope.$parent.title = "Dashboard | Aileensoul";

    $("#job_title").focusin(function(){
        $('#jobtitletooltip').show();
    });
    $("#job_title").focusout(function(){
        $('#jobtitletooltip').hide();
    });

    $("#location").focusin(function(){
        $('#locationtooltip').show();
    });
    $("#location").focusout(function(){
        $('#locationtooltip').hide();
    });

    $("#field").focusin(function(){
        $('#fieldtooltip').show();
    });
    $("#field").focusout(function(){
        $('#fieldtooltip').hide();
    });

    $("#ask_desc").focusin(function(){
        $('#ask_desctooltip').show();
    });
    $("#ask_desc").focusout(function(){
        $('#ask_desctooltip').hide();
    });

    $("#ask_related_category").focusin(function(){
        $('#rlcattooltip').show();
    });
    $("#ask_related_category").focusout(function(){
        $('#rlcattooltip').hide();
    });

    $("#ask_field").focusin(function(){
        $('#ask_fieldtooltip').show();
    });
    $("#ask_field").focusout(function(){
        $('#ask_fieldtooltip').hide();
    });

    $scope.getHashTags = function(inputText) {  
        var regex = /(?:^|\s)(?:#)([a-zA-Z\d]+)/gm;
        // var regex = /[^\s#]+/g;
        var matches = [];
        var match;

        while ((match = regex.exec(inputText))) {
            matches.push(match[1]);
        }

        return matches;
    };

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }
            
        }, function (error) {});
    }
    $scope.get_all_counter();
    
    var isLoadingData = false;

    $(document).on('hidden.bs.modal', function (event) {
        if($('.modal.in').length > 0)
        {
            if ($('body').hasClass('modal-open') == false) {
                $('body').addClass('modal-open');
            };            
        }
    });

    $(document)  
    .on('show.bs.modal', '.modal', function(event) {
        $(this).appendTo($('body'));
    })
    .on('shown.bs.modal', '.modal.in', function(event) {
        setModalsAndBackdropsOrder();
    })
    .on('hidden.bs.modal', '.modal', function(event) {
        setModalsAndBackdropsOrder();
    });

    function setModalsAndBackdropsOrder() {
        var modalZIndex = 1040;
        $('.modal.in').each(function(index) {
            var $modal = $(this);
            modalZIndex++;
            $modal.css('zIndex', modalZIndex);
            $modal.next('.modal-backdrop.in').addClass('hidden').css('zIndex', modalZIndex - 1);
        });
        $('.modal.in:visible:last').focus().next('.modal-backdrop.in').removeClass('hidden');
    }

    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $('.modal-close').click();            
        }
    });

    $(document).on('keydown','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });

    $(document).on('focusin','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
    });
    $(document).on('focusout','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {             
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
        if($('#job_title ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer....');
            $(this).css('width', '100%');
        }         
    });

    $(document).on('keydown','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
    });
    $(document).on('focusout','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
        if($('#location ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai....');
            $(this).css('width', '100%');
        }         
    });


    $(document).on('keydown','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
    });
    $(document).on('focusout','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {             
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
        if($('#ask_related_category ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Related Category');
            $(this).css('width', '100%');
        }         
    });

    $scope.removeViewMore = function(mainId,removeViewMore) {    
        $("#"+mainId).removeClass("view-more-expand");
        $("#"+removeViewMore).remove();
    };

    $scope.dashboardPhotosAfterDPUpload = function() {    
        getUserDashboardImage()
    };    
    
    var cntImgSim = 0;
    var formFileDataSim = new FormData();
    var formFileExtSim = [];
    var fileCountSim = 0;
    var fileNamesArrSim = [];

    var cntImgOpp = 0;
    var formFileDataOpp = new FormData();
    var formFileExtOpp = [];
    var fileCountOpp = 0;
    var fileNamesArrOpp = [];

    var cntImgQue = 0;
    var formFileDataQue = new FormData();
    var formFileExtQue = [];
    var fileCountQue = 0;
    var fileNamesArrQue = [];

    $(document).on('change','#fileInput2', function(e){
        $.each($('#fileInput2')[0].files, function(i, f) {
            if(fileNamesArrQue.indexOf(f.name) < 0)
            {

                if(f.type.match("image.*")) {
                
                formFileExtQue.push(f.type.split('/')[1]);
                fileNamesArrQue.push(f.name);

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrevQue_"+cntImgQue+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFileQue('"+cntImgQue+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFilesQue');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataQue.append('myfiles_'+cntImgQue, f);

                        cntImgQue++;
                        fileCountQue++;                    
                        $("#fileCountQue").text(fileCountQue);
                        if($('#fileInput2')[0].files.length - 1 == i)
                        {
                            $('#fileInput2').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }               
            }            
        });
    });

    $scope.removeFileQue = function(rmId) {
        fileCountQue--;
        $("#fileCountQue").text(fileCountQue);
        if(fileCountQue <= 0)
        {
            $("#fileInput2").val("");
        }        
        var ext = formFileDataQue.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtQue.indexOf(ext.toString());
        formFileExtQue.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrQue.indexOf(formFileDataQue.get("myfiles_"+rmId).name);
        fileNamesArrQue.splice(fileNameIndex, 1);
        $("#imgPrevQue_"+rmId).remove();
        formFileDataQue.delete("myfiles_"+rmId);
    };

    $(document).on('change','#fileInput1', function(e){
        $.each($('#fileInput1')[0].files, function(i, f) {
            
            if(fileNamesArrSim.indexOf(f.name) < 0)
            {
                formFileExtSim.push(f.type.split('/')[1]);
                fileNamesArrSim.push(f.name);

                if(f.type.match("image.*")) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrev_"+cntImgSim+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFile('"+cntImgSim+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFiles');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataSim.append('myfiles_'+cntImgSim, f);

                        cntImgSim++;
                        fileCountSim++;                    
                        $("#fileCountSim").text(fileCountSim);
                        if($('#fileInput1')[0].files.length - 1 == i)
                        {
                            $('#fileInput1').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }
                else if(f.type.match("video.*")) {
                    src = URL.createObjectURL(f);
                    var $el = $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip"><video width="400"><source src="'+src+'" id="video_here">Your browser does not support HTML5 video.</video></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    //fileNamesArrSim.push(f.name);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }
                }

                else if(f.type.match("audio.*")) {
                    src = URL.createObjectURL(f);
                    var $el =  $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip i-ip-audio"><audio><source src="'+src+'" type="audio/ogg"><source src="'+src+'" type="audio/mpeg">Your browser does not support the audio element.</audio></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }
                }

                else if(f.type == "application/pdf") {              
                    var $el =  $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip"><img ng-src="'+base_url+'assets/images/PDF.jpg" class="selFile"></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }

                    /*var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrev_"+cntImgSim+"'><div class='i-ip'><embed width='100%' src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></embed></div><label class='remove_img' name='remove_image' ng-click=\"removeFile('"+cntImgSim+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFiles');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataSim.append('myfiles_'+cntImgSim, f);

                        cntImgSim++;
                        fileCountSim++;                    
                        $("#fileCountSim").text(fileCountSim);
                        if($('#fileInput1')[0].files.length - 1 == i)
                        {
                            $('#fileInput1').val("");
                        }
                    }
                    reader.readAsDataURL(f);*/
                }
            }            
        });
    });

    $scope.removeFile = function(rmId) {        
        fileCountSim--;
        $("#fileCountSim").text(fileCountSim);
        if(fileCountSim <= 0)
        {
            $("#fileInput1").val("");
        }        
        var ext = formFileDataSim.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtSim.indexOf(ext.toString());
        formFileExtSim.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrSim.indexOf(formFileDataSim.get("myfiles_"+rmId).name);
        fileNamesArrSim.splice(fileNameIndex, 1);
        //console.log(fileNamesArrSim);
        $("#imgPrev_"+rmId).remove();
        formFileDataSim.delete("myfiles_"+rmId);

    };

    $(document).on('change','#fileInput', function(e){
        $.each($('#fileInput')[0].files, function(i, f) {
            
            if(fileNamesArrOpp.indexOf(f.name) < 0)
            {
                formFileExtOpp.push(f.type.split('/')[1]);
                fileNamesArrOpp.push(f.name);

                if(f.type.match("image.*")) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrevOpp_"+cntImgOpp+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFileOpp('"+cntImgOpp+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFilesOpp');                        
                        $compile($el)($scope);

                        formFileDataOpp.append('myfiles_'+cntImgOpp, f);

                        cntImgOpp++;
                        fileCountOpp++;                    
                        $("#fileCountOpp").text(fileCountOpp);
                        if($('#fileInput')[0].files.length - 1 == i)
                        {
                            $('#fileInput').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }
                else if(f.type.match("video.*")) {
                    src = URL.createObjectURL(f);
                    var $el = $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip"><video width="400"><source src="'+src+'" id="video_here">Your browser does not support HTML5 video.</video></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);                    
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }

                else if(f.type.match("audio.*")) {
                    src = URL.createObjectURL(f);
                    var $el =  $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip i-ip-audio"><audio><source src="'+src+'" type="audio/ogg"><source src="'+src+'" type="audio/mpeg">Your browser does not support the audio element.</audio></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }

                else if(f.type == "application/pdf") {              
                    var $el =  $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip"><img ng-src="'+base_url+'assets/images/PDF.jpg" class="selFile"></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }
            }            
        });
    });

    $scope.removeFileOpp = function(rmId) {
        fileCountOpp--;
        $("#fileCountOpp").text(fileCountOpp);
        if(fileCountOpp <= 0)
        {
            $("#fileInput").val("");
        }        
        var ext = formFileDataOpp.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtOpp.indexOf(ext.toString());
        formFileExtOpp.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrOpp.indexOf(formFileDataOpp.get("myfiles_"+rmId).name);
        fileNamesArrOpp.splice(fileNameIndex, 1);
        $("#imgPrevOpp_"+rmId).remove();
        formFileDataOpp.delete("myfiles_"+rmId);
    };

    $scope.openModal = function() {
        document.getElementById('myModal1').style.display = "block";
        $("body").addClass("modal-open");
    };    
    $scope.closeModal = function() {    
        document.getElementById('myModal1').style.display = "none";
        $("body").removeClass("modal-open");
    };    
    //var slideIndex = 1;
    //showSlides(slideIndex);
    $scope.plusSlides = function(n) {    
        showSlides(slideIndex += n);
    };   
    $scope.currentSlide = function(n) {    
        showSlides(slideIndex = n);
    };    
    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        //var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        /*for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }*/
        slides[slideIndex - 1].style.display = "block";
        //dots[slideIndex - 1].className += " active";
        //captionText.innerHTML = dots[slideIndex - 1].alt;
    }

    $scope.openModal2 = function(myModal2Id) {
        /*if(user_id != "")
        {            
            document.getElementById(myModal2Id).style.display = "block";
            $("body").addClass("modal-open");
        }
        else
        {
            $("#regmodal").modal("show");
        }*/
        document.getElementById(myModal2Id).style.display = "block";
        $("body").addClass("modal-open");
    };
    $scope.closeModal2 = function(myModal2Id) {
        document.getElementById(myModal2Id).style.display = "none";
        $("body").removeClass("modal-open");
    };
    $scope.closeModalShare = function(myModal2Id) {
        document.getElementById(myModal2Id).style.display = "none";
        // $("body").removeClass("modal-open");
        if($('.modal.in').length > 0)
        {
            if ($('body').hasClass('modal-open') == false) {
                $('body').addClass('modal-open');
            };            
        }
        else
        {
            $("body").removeClass("modal-open");
        }
        $("#"+myModal2Id).modal('hidden');
    };
    $scope.plusSlides2 = function(n,myModal2Id) {    
        showSlides2(slideIndex += n,myModal2Id);
    };
    $scope.currentSlide2 = function(n,myModal2Id) {    
        showSlides2(slideIndex = n,myModal2Id);
    };
    function showSlides2(n,myModal2Id) {
        var i;
        var slides = document.getElementsByClassName("mySlides2"+myModal2Id);
        //var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        var elem = $("#element_load_"+slideIndex);
        $("#myModal"+myModal2Id+" #all_image_loader").hide();

        if (!elem.prop('complete')) {
            $("#myModal"+myModal2Id+" #all_image_loader").show();
            elem.on('load', function() {
                $("#myModal"+myModal2Id+" #all_image_loader").hide();
                // console.log("Loaded!");
                // console.log(this.complete);
            });
        } 
        /*for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }*/
        slides[slideIndex - 1].style.display = "block";
        //dots[slideIndex - 1].className += " active";
        //captionText.innerHTML = dots[slideIndex - 1].alt;
    }

    $(window).on('scroll', function () {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7)
        {
            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    getUserDashboardPostLoad(pagenum);
                }
            }
        }
    });    

    function getUserDashboardPostLoad(pagenum) {
        if (isLoadingData) {
          
            /*
             *This won't go past this condition while
             *isProcessing is true.
             *You could even display a message.
             **/
            return;
        }
        isLoadingData = true;
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardPost?page=" + pagenum + "&user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            if (success.data.length > 0) {
                isLoadingData = false;
                for (var i in success.data) {
                    $scope.postData.push(success.data[i]);
                }
                // check_no_post_data();
            } else {
                // processing = false;
                // isLoadingData = false;
                isLoadingData = true;
                $scope.showLoadmore = false;
            }
            setTimeout(function(){
                var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

                for (i = 0; i < total; i++) {
                    if($(mediaElements[i])[0].id == '')
                    {                        
                        new MediaElementPlayer(mediaElements[i], {
                            stretching: 'auto',
                            pluginPath: '../../../build/',
                            success: function (media) {
                                var renderer = document.getElementById(media.id + '-rendername');

                                media.addEventListener('loadedmetadata', function () {
                                    var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                                    if (src !== null && src !== undefined) {
                                        // renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                                        // renderer.querySelector('.renderer').innerHTML = media.rendererName;
                                        // renderer.querySelector('.error').innerHTML = '';
                                    }
                                });

                                media.addEventListener('error', function (e) {
                                    renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                                });
                            }
                        });
                    }
                }
                // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
                /*$('[data-toggle="popover"]').popover({
                    trigger: "manual" ,
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                        // return $('#popover-content').html();
                    },
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show");
                    $(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide");
                        }
                    }, 100);
                });*/
            },1000);
        }, function (error) {
            setTimeout(function(){
                getUserDashboardPostLoad(pagenum);
            },500);
        });
    }
    var all_image_load = false;
    
    function getUserDashboardImage(pagenum) {        
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardImage?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postImageData = success.data.userDashboardImage;
            $scope.postAllImageData = success.data.userDashboardImage;//success.data.userDashboardImageAll;
        }, function (error) {
            setTimeout(function(){
                getUserDashboardImage(pagenum);
            },500);
        });
    }

    $scope.load_more_photos = function()
    {
        if($scope.postAllImageData.length == 6 && all_image_load == false)
        {
            $('#all_image_loader').show();
            $http.get(base_url + "user_post/getUserDashboardAllImage?user_slug=" + user_slug).then(function (success) {
                all_image_load = true;
                $('#all_image_loader').hide();
                for (var i in success.data.userDashboardImageAll) {
                    $scope.postAllImageData.push(success.data.userDashboardImageAll[i]);
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.load_more_photos(pagenum);
                },500);
            });
        }
    }

    var all_video_load = false;
    function getUserDashboardVideo() {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardVideo?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postVideoData = success.data.userDashboardVideo;
            $scope.postAllVideoData = success.data.userDashboardVideo;
            setTimeout(function(){
                var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

                for (i = 0; i < total; i++) {
                    if($(mediaElements[i])[0].id == '')
                    {                        
                        new MediaElementPlayer(mediaElements[i], {
                            stretching: 'auto',
                            pluginPath: '../../../build/',
                            success: function (media) {
                                var renderer = document.getElementById(media.id + '-rendername');

                                media.addEventListener('loadedmetadata', function () {
                                    var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                                    if (src !== null && src !== undefined) {
                                        // renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                                        // renderer.querySelector('.renderer').innerHTML = media.rendererName;
                                        // renderer.querySelector('.error').innerHTML = '';
                                    }
                                });

                                media.addEventListener('error', function (e) {
                                    renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                                });
                            }
                        });
                    }
                }
                // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
            },1000);
            
        }, function (error) {
            setTimeout(function(){
                getUserDashboardVideo();
            },500);
        });
    }

    $scope.load_more_videos = function()
    {
        if($scope.postAllVideoData.length == 6 && all_video_load == false)
        {
            $('#loader').show();
            $http.get(base_url + "user_post/getUserDashboardVideoAll?user_slug=" + user_slug).then(function (success) {
                    all_video_load = true;
                    $('#loader').hide();
                    for (var i in success.data.userDashboardVideoAll) {
                        $scope.postAllVideoData.push(success.data.userDashboardVideoAll[i]);
                    }
                    setTimeout(function(){
                        var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

                        for (i = 0; i < total; i++) {
                            if($(mediaElements[i])[0].id == '')
                            {                        
                                new MediaElementPlayer(mediaElements[i], {
                                    stretching: 'auto',
                                    pluginPath: '../../../build/',
                                    success: function (media) {
                                        var renderer = document.getElementById(media.id + '-rendername');

                                        media.addEventListener('loadedmetadata', function () {
                                            var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                                            if (src !== null && src !== undefined) {
                                                // renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                                                // renderer.querySelector('.renderer').innerHTML = media.rendererName;
                                                // renderer.querySelector('.error').innerHTML = '';
                                            }
                                        });

                                        media.addEventListener('error', function (e) {
                                            renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                                        });
                                    }
                                });
                            }
                        }
                        // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
                    },1000);
            }, function (error) {
                setTimeout(function(){
                    $scope.load_more_videos();
                },500);
            });
        }
    }

    function getUserDashboardArticle() {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardArticle?user_slug=" + user_slug).then(function (success)
        {
            $('#loader').hide();
            $scope.postArticleData = success.data.userDashboardArticle;            
        }, function (error) {
            setTimeout(function(){
                getUserDashboardArticle();
            },500);
        });
    }

    function getUserDashboardInformation() {
        $('#loader').show();
      
        $('footer').hide();
       $http({
            method: 'POST',
            url: base_url + 'userprofile_page/detail_data',
            //data: 'u=' + user_id,
            data: 'u=' + user_slug,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            details_data = success.data.detail_data;
            details_data.DOB = details_data.DOB.substring(0,details_data.DOB.length - 4)
            $scope.details_data = details_data;            
            $scope.user_bio = success.data.user_bio;            
            $scope.user_skills = success.data.skills_data;

            $scope.$parent.title = "About "+details_data.fullname+" | Aileensoul";
            if(details_data.Degree != "")
            {
                desc = details_data.Degree;
            }
            if(details_data.Designation != "")
            {
                desc = details_data.Designation;
            }
            $scope.$parent.metadesc = "Connect with "+details_data.fullname+", "+desc+" and know more about him only at Aileensoul.com. Join Now!";

            var profile_progress = success.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            if(count_profile == 100)
            {
                $("#edit-profile-move").hide();
            }
            $scope.set_progress(count_profile_value,count_profile);
        }, function (error) {
            setTimeout(function(){
                getUserDashboardInformation();
            },500);
        });
    }

    $scope.set_progress = function(count_profile_value,count_profile){
        if(count_profile == 100)
        {
            $("#progress-txt").html("Hurray! Your profile is complete.");
            setTimeout(function(){
                $("#edit-profile-move").hide();
            },5000);
        }
        else
        {
            $("#edit-profile-move").show();
            $("#profile-progress").show();                
            $("#progress-txt").html("<a href='"+base_url+user_slug+"/details' target='_self'>Complete your profile to get connected with more people.</a>");   
        }
        // if($scope.old_count_profile < 100)
        {
            $('.second.circle-1').circleProgress({
                value: count_profile_value //with decimal point
            }).on('circle-animation-progress', function(event, progress) {
                $('.progress-bar-custom').width(Math.round(count_profile * progress)+'%');
                $('.progress-bar-custom span .val').html(Math.round(count_profile * progress)+'%');
                $(this).find('strong').html(Math.round(count_profile * progress) + '<i>%</i>');
            });
        }
        $scope.old_count_profile = count_profile;
    };

    function getUserDashboardAudio(pagenum) {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardAudio?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postAudioData = success.data.userDashboardAudio;
            $scope.postAllAudioData = success.data.userDashboardAudioAll;            
         }, function (error) {
            setTimeout(function(){
                getUserDashboardAudio(pagenum);
            },500);
        });
    }

    function getUserDashboardPdf(pagenum) {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardPdf?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postPdfData = success.data.userDashboardPdf;           
        }, function (error) {
            setTimeout(function(){
                getUserDashboardPdf(pagenum);
            },500);
        });
    }

    // getFieldList();
    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {
            setTimeout(function(){
                getFieldList();
            },500);
        });
    }
    if(user_id != "")
    {
        getContactSuggetion();
        function getContactSuggetion() {
            $http.get(base_url + "user_post/getContactSuggetion").then(function (success) {
                $scope.contactSuggetion = success.data;
                //console.log($scope.contactSuggetion);
            }, function (error) {
                setTimeout(function(){
                    getContactSuggetion();
                },500);
            });
        }
    }

    $scope.job_title = [];
    $scope.loadJobTitle = function ($query) {
        return $http.get(base_url + 'user_post/get_jobtitle', {cache: true}).then(function (response) {
            var job_title = response.data;
            return job_title.filter(function (title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };
    $scope.location = [];
    $scope.loadLocation = function ($query) {
        return $http.get(base_url + 'user_post/get_location', {cache: true}).then(function (response) {
            var location_data = response.data;
            return location_data.filter(function (location) {
                return location.city_name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.category = [];
    $scope.loadCategory = function ($query) {
        return $http.get(base_url + 'user_post/get_category', {cache: true}).then(function (response) {
            var category_data = response.data;
            return category_data.filter(function (category) {
                return category.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };


    $scope.postFiles = function () {
        var a = document.getElementById('description').value;
        var b = document.getElementById('job_title').value;
        var c = document.getElementById('location').value;
        var d = document.getElementById('field').value;        
        //document.getElementById("post_opportunity").reset();
        document.getElementById('description').value = a;
        document.getElementById('job_title').value = b;
        document.getElementById('location').value = c;
        document.getElementById('field').value = d;
    }
    
    $scope.IsVisible = false;
    $scope.ShowHide = function () {
        //If DIV is visible it will be hidden and vice versa.
        $scope.IsVisible = $scope.IsVisible ? false : true;
    }


    $scope.questionList = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchQuestionList',
            data: 'q=' + $scope.ask.ask_que,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.queSearchResult = data;
            if ($scope.queSearchResult.length > 0) {
                $('.questionSuggetion').addClass('question-available');
            } else {
                $('.questionSuggetion').removeClass('question-available');
            }
        }, function (error) {
            setTimeout(function(){
                $scope.questionList();
            },500);
        });
    }   
       
    $scope.lightbox = function (idx) {
        //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
        var ninjaSldr = document.getElementById("ninja-slider");
        ninjaSldr.parentNode.style.display = "block";
        nslider.init(idx);
        var fsBtn = document.getElementById("fsBtn");
        fsBtn.click();
    };
    
    function fsIconClick(isFullscreen, ninjaSldr) { 
        //fsIconClick is the default event handler of the fullscreen button
        if (isFullscreen) {
            ninjaSldr.parentNode.style.display = "none";
        }
    }


    // POST SOMETHING UPLOAD START

    $scope.loadMediaElement = function ()
    {
        /*setTimeout(function(){
            var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

            for (i = 0; i < total; i++) {
                new MediaElementPlayer(mediaElements[i], {
                    stretching: 'auto',
                    pluginPath: '../../../build/',
                    success: function (media) {
                        var renderer = document.getElementById(media.id + '-rendername');

                        media.addEventListener('loadedmetadata', function () {
                            var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                            if (src !== null && src !== undefined) {
                                // renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                                // renderer.querySelector('.renderer').innerHTML = media.rendererName;
                                // renderer.querySelector('.error').innerHTML = '';
                            }
                        });

                        media.addEventListener('error', function (e) {
                            renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                        });
                    }
                });
            }
            // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
        },1000);*/

        //$('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */);
        /*var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

        for (i = 0; i < total; i++) {
            new MediaElementPlayer(mediaElements[i], {
                stretching: stretching,
                pluginPath: '../js/build/',
                success: function (media) {
                    var renderer = document.getElementById(media.id + '-rendername');

                    media.addEventListener('loadedmetadata', function () {
                        var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                        if (src !== null && src !== undefined) {
                            renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                            renderer.querySelector('.renderer').innerHTML = media.rendererName;
                            renderer.querySelector('.error').innerHTML = '';
                        }
                    });

                    media.addEventListener('error', function (e) {
                        renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                    });
                }
            });
        }*/
    };
    $scope.addToContact = function (user_id, contact) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                if(socket)
                {
                    socket.emit('user notification',user_id);
                }
                var index = $scope.contactSuggetion.indexOf(contact);
                $('.addtobtn-' + user_id).html('Request Sent');
                $('.addtobtn-' + user_id).attr('style','pointer-events:none;');
               // $('.owl-carousel').trigger('next.owl.carousel');
            }
        }, function (error) {
            setTimeout(function(){
                $scope.addToContact(user_id, contact);
            },500);
        });
    }

    $scope.post_like = function (post_id,parent_index,like_user_id) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }        
        $('#post-like-' + post_id).attr('style','pointer-events: none;');
        if($('#post-like-' + post_id).hasClass('like'))
        {
            $('#post-like-' + post_id).removeClass('like');
            var like_cnt = $('#post-like-count-' + post_id).html();
            if(parseInt(like_cnt) - 1 < 1)
            {
                $('#post-like-count-' + post_id).hide();
            }
            else
            {
                $('#post-like-count-' + post_id).html(parseInt(like_cnt) - 1);
            }
        }
        else
        {
            $('#post-like-' + post_id).addClass('like');
            $('#post-like-count-' + post_id).show();
            var like_cnt = $('#post-like-count-' + post_id).html();
            $('#post-like-count-' + post_id).html(parseInt(like_cnt) + 1);

        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $('#post-like-' + post_id).removeAttr('style');
            if (success.data.message == 1) {
                if(socket)
                {
                    socket.emit('user notification',like_user_id);
                }
                if (success.data.is_newLike == 1) {
                    $('#post-like-count-' + post_id).show();
                    $('#post-like-' + post_id).addClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                } else if (success.data.is_oldLike == 1) {
                    if(success.data.likePost_count < 1)
                    {                        
                        $('#post-like-count-' + post_id).hide();
                    }
                    else
                    {
                        $('#post-like-count-' + post_id).show();
                    }
                    $('#post-like-' + post_id).removeClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                }
                $scope.postData[parent_index].user_like_list = success.data.user_like_list;
            }
        }, function (error) {
            setTimeout(function(){
                $scope.post_like(post_id,parent_index,like_user_id);
            },500);
        });
    }

    $scope.cmt_handle_paste = function (e) {        
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");        
        value = value.substring(0,cmt_maxlength);        
        document.execCommand('inserttext', false, value);
    };

    $scope.check_comment_char_count = function(post_id,e){
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8,17,35,36,37,38,39,40,46];

        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if(no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength)
        {
            e.preventDefault();
            return false;
        }
        else
        {
            return true;
        }
    };

    $scope.cmt_handle_paste_edit = function (e) {        
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");        
        value = value.substring(0,cmt_maxlength);        
        document.execCommand('inserttext', false, value);
    };

    $scope.check_comment_char_count_edit = function(cmt_id,e){
        var comment = $('#editCommentTaxBox-' + cmt_id).text();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8,17,35,36,37,38,39,40,46];
        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if(no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength)
        {
            e.preventDefault();
            return false;
        }
        else
        {
            return true;
        }
    };

    $scope.sendComment = function (post_id, index, post) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $("#cmt-btn-mob-"+post_id).attr("style","pointer-events: none;");
            $("#cmt-btn-mob-"+post_id).attr("disabled","disabled");
            $("#cmt-btn-"+post_id).attr("style","pointer-events: none;");
            $("#cmt-btn-"+post_id).attr("disabled","disabled");
            var data = $.param({comment:comment,post_id:post_id});
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: data,//'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[index].post_data.user_id);
                    }
                    if (commentClassName == 'last-comment') {
                        $scope.postData[index].post_comment_data.splice(0, 1);
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function(){
                    $("#cmt-btn-mob-"+post_id).removeAttr("style");
                    $("#cmt-btn-mob-"+post_id).removeAttr("disabled");
                    $("#cmt-btn-"+post_id).removeAttr("style");
                    $("#cmt-btn-"+post_id).removeAttr("disabled");
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },1000);
            }, function (error) {
                setTimeout(function(){
                    $scope.sendComment(post_id, index, post);
                },500);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.viewAllComment = function (post_id, index, post) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.all_comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                /*$('[data-toggle="popover"]').popover({
                    trigger: "manual" ,
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                        // return $('#popover-content').html();
                    },
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show");
                    $(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide");
                        }
                    }, 100);
                });*/
            },500);
        }, function (error) {
            setTimeout(function(){
                $scope.viewAllComment(post_id, index, post);
            },500);
        });
    }

    $scope.viewLastComment = function (post_id, index, post) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                /*$('[data-toggle="popover"]').popover({
                    trigger: "manual" ,
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                        // return $('#popover-content').html();
                    },
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show");
                    $(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide");
                        }
                    }, 100);
                });*/
            },500);
        }, function (error) {
            setTimeout(function(){
                $scope.viewLastComment(post_id, index, post);
            },500);
        });
    }
    $scope.deletePostComment = function (comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $('#delete_model').modal('show');
    }

    $scope.deleteComment = function (comment_id, post_id, parent_index, index, post) {
        // console.log("comment_id",comment_id);
        // console.log("post_id",post_id);
        // console.log("parent_index",parent_index);
        // console.log("index",index);
        // console.log("post",post);
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        //console.log("commentClassName",commentClassName);
        //return false;
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            } else {
                $scope.postData[parent_index].post_comment_data.splice(index, 1);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
            if(data.comment_count <= 0)
            {
                setTimeout(function(){
                    $(".comment-for-post-"+post_id+" .post-comment").remove();
                },100);
                $(".new-comment-"+post_id).show();                
            }
        }, function (error) {
            setTimeout(function(){
                $scope.deleteComment(comment_id, post_id, parent_index, index, post);
            },500);
        });
    }

    $scope.likePostComment = function (comment_id, post_id) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            
            if (data.message == '1') {
                if (data.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }

            }
        }, function (error) {
            setTimeout(function(){
                $scope.likePostComment(comment_id, post_id);
            },500);
        });
    }
    $scope.editPostComment = function (comment_id, post_id, parent_index, index) {
        $(".comment-for-post-"+post_id+" .edit-comment").hide();
        $(".comment-for-post-"+post_id+" .comment-dis-inner").show();
        $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
        $(".comment-for-post-"+post_id+" li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
        $('#edit-comment-' + comment_id).show();
        editContent = editContent.substring(0,cmt_maxlength);
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-"+post_id).hide();
    }

    $scope.edit_post_comment_reply = function (comment_id, post_id, parent_index, cmt_index,cmt_rpl_index) {       
        $(".comment-for-post-"+post_id+" .edit-reply-comment").hide();
        $(".comment-for-post-"+post_id+" li[id^=cancel-reply-comment-li-]").hide();
        $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
        $(".comment-for-post-"+post_id+" li[id^=timeago-reply-comment-li-]").show();
        $(".comment-for-post-"+post_id+" div[id^=comment-reply-dis-inner-]").show();
        $('#edit-comment-li-' + comment_id).hide();
        $('#timeago-reply-comment-li-' + comment_id).hide();

        var editContent = $scope.postData[parent_index].post_comment_data[cmt_index].comment_reply_data[cmt_rpl_index].comment;
        editContent = editContent.substring(0,cmt_maxlength);
        $('#edit-reply-comment-' + comment_id).show();
        $('#edit-comment-reply-textbox-' + comment_id).html(editContent);
        $('#comment-reply-dis-inner-' + comment_id).hide();
        $('#edit-reply-comment-li-' + comment_id).hide();
        $('#cancel-reply-comment-li-' + comment_id).show();
        $(".new-comment-"+post_id).hide();
    }

    $scope.cancel_post_comment_reply = function (comment_id, post_id, parent_index, cmt_index,cmt_rpl_index) {
        $('#edit-comment-li-' + comment_id).show();
        $('#timeago-reply-comment-li-' + comment_id).show();
        $('#edit-reply-comment-' + comment_id).hide();        
        $('#comment-reply-dis-inner-' + comment_id).show();
        $('#edit-reply-comment-li-' + comment_id).show();
        $('#cancel-reply-comment-li-' + comment_id).hide();
        $(".new-comment-"+post_id).show();
    }

    $scope.comment_reply = function(post_index,comment_id,login_user_id,comment_user_id,cmt_reply_obj){
        $scope.comment_reply_data = cmt_reply_obj;
        if(login_user_id == 0 && comment_user_id == 0)
        {
            $("#reply-comment-"+post_index+"-"+comment_id).html('');            
        }
        else
        {
            if(login_user_id == comment_user_id)
            {
                $("#reply-comment-"+post_index+"-"+comment_id).html('');                
            }
            else
            {
                var content = '<a class="mention-'+post_index+'-'+comment_id+'" href="'+base_url+cmt_reply_obj.user_slug+'" data-mention="'+window.btoa(cmt_reply_obj.user_slug)+'">'+cmt_reply_obj.username+'</a>&nbsp;';                
                $("#reply-comment-"+post_index+"-"+comment_id).html(content);
            }
        }
        $("#comment-reply-"+post_index+"-"+comment_id).show();   
    };

    $scope.cancelPostComment = function (comment_id, post_id, parent_index, index) {
        
        $('#edit-comment-' + comment_id).hide();
        
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-"+post_id).show();
    }    

    $scope.share_post_data = [];    

    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];        
        $scope.post_index = index;
        $("#post-share").modal("show");
       /* setTimeout(function(){
            var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

            for (i = 0; i < total; i++) {
                new MediaElementPlayer(mediaElements[i], {
                    stretching: 'auto',
                    pluginPath: '../../../build/',
                    success: function (media) {
                        var renderer = document.getElementById(media.id + '-rendername');

                        media.addEventListener('loadedmetadata', function () {
                            var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                            if (src !== null && src !== undefined) {
                                // renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                                // renderer.querySelector('.renderer').innerHTML = media.rendererName;
                                // renderer.querySelector('.error').innerHTML = '';
                            }
                        });

                        media.addEventListener('error', function (e) {
                            renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                        });
                    }
                });
            }
            // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
        },1000);*/
        setTimeout(function(){            
            autosize(document.getElementsByClassName('hashtag-textarea'));
        },300);
    };

    $scope.share_post_fnc = function(post_index){        
        $('.post-popup-box').attr('style','pointer-events: none;');
        var description = $("#share_post_text").val();
        var post_id = 0;
        if($scope.share_post_data.post_data.post_for == 'share')
        {
            post_id = $scope.share_post_data.share_data.data.post_data.id;
        }
        else
        {
            post_id = $scope.share_post_data.post_data.id;
        }

        $http({
            method: 'POST',
            url: base_url + 'user_post/save_user_post_share',
            data: 'post_id=' + post_id +'&description='+description,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            var result = success.data;            
            setTimeout(function(){
                $('#post-share').modal('hide');
                $("#share_post_text").val('');
            },100);
            if(result.status == '1')
            {
                $('.biderror .mes').html("<div class='pop_content'>Post Shared Successfully.");
                $('#posterrormodal').modal('show');
                $scope.postData[post_index].post_share_count = result.post_share_count;
            }
            else
            {
                $('.biderror .mes').html("<div class='pop_content'>Please Try Again.");
                $('#posterrormodal').modal('show');
            }
            $('.post-popup-box').attr('style','pointer-events: all;');
        }, function (error) {
            setTimeout(function(){
                $scope.share_post_fnc(post_index);
            },500);
        });
    };

    $scope.sendEditComment = function (comment_id,post_id,user_id) {
        var comment = $('#editCommentTaxBox-' + comment_id).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentUpdate',
                data: 'comment=' + comment + '&comment_id=' + comment_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',user_id);
                    }
                    $('#comment-dis-inner-' + comment_id).show();
                    $('#comment-dis-inner-' + comment_id).html(comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-'+post_id).show();
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.sendEditComment(comment_id,post_id,user_id);
                },500);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.sendCommentReply = function (comment_id,post_id,postIndex,commentIndex) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#reply-comment-'+postIndex+'-'+commentIndex).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        
        var mention = 0;
        var mention_id = 0;

        if($("a.mention-"+postIndex+"-"+commentIndex).data('mention') != undefined && $("a.mention-"+postIndex+"-"+commentIndex).data('mention') != '')
        {
            var cmt_mention = window.atob($("a.mention-"+postIndex+"-"+commentIndex).data('mention'));            
            if(cmt_mention == $scope.comment_reply_data.user_slug){
                mention = 1;
                mention_id = $scope.comment_reply_data.commented_user_id;
            }
        }
        // data: {comment:comment,comment_id:comment_id,post_id:post_id,mention:mention,mention_id:$scope.comment_reply_data.commented_user_id},
        if (comment) {
            $http({
                method: 'POST',
                url: base_url + 'user_post/add_post_comment_reply',
                data: 'comment=' + comment + '&comment_id=' + comment_id + '&post_id=' + post_id + '&mention=' + mention + '&mention_id=' + mention_id+'&comment_reply_id='+$scope.comment_reply_data.comment_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                // console.log(success.data);
                data = success.data;
                if (data.message == '1') {                    
                    if (commentClassName == 'last-comment') {
                        // $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data.splice(commentIndex, 1);
                        $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data = data.comment_reply_data;
                        if(socket)
                        {
                            socket.emit('user notification',$scope.postData[postIndex].post_comment_data[commentIndex].commented_user_id);
                        }
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data = data.comment_reply_data;
                        if(socket)
                        {
                            socket.emit('user notification',$scope.postData[postIndex].post_comment_data[commentIndex].commented_user_id);
                        }
                        $('.editable_text').html('');
                    }
                    setTimeout(function(){
                        /*$('[data-toggle="popover"]').popover({
                            trigger: "manual" ,
                            html: true, 
                            animation:false,
                            template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                            content: function () {
                                // return $($(this).data('tooltip-content')).html();
                                var uid = $(this).data('uid');
                                var utype = $(this).data('utype');
                                var div_id =  "tmp-id-" + $.now();
                                return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);            
                                // return $('#popover-content').html();
                            },
                            placement: function (context, element) {

                                var $this = $(element);
                                var offset = $this.offset();
                                var width = $this.width();
                                var height = $this.height();

                                var centerX = offset.left + width / 2;
                                var centerY = offset.top + height / 2;
                                var position = $(element).position();
                                
                                if(centerY > $(window).scrollTop())
                                {
                                    scroll_top = $(window).scrollTop();
                                    scroll_center = centerY;
                                }
                                if($(window).scrollTop() > centerY)
                                {
                                    scroll_top = centerY;
                                    scroll_center = $(window).scrollTop();
                                }
                                
                                if (parseInt(scroll_center - scroll_top) < 340){
                                    return "bottom";
                                }                        
                                return "top";
                            }
                        }).on("mouseenter", function () {
                            var _this = this;
                            $(this).popover("show");
                            $(".popover").on("mouseleave", function () {
                                $(_this).popover('hide');
                            });
                        }).on("mouseleave", function () {
                            var _this = this;
                            setTimeout(function () {
                                if (!$(".popover:hover").length) {
                                    $(_this).popover("hide");
                                }
                            }, 100);
                        });*/
                    },500);
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.sendCommentReply(comment_id,post_id,postIndex,commentIndex);
                },500);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.send_edit_comment_reply = function (reply_comment_id,post_id) {
        var comment = $('#edit-comment-reply-textbox-' + reply_comment_id).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $http({
                method: 'POST',
                url: base_url + 'user_post/edit_post_comment_reply',
                data: 'comment=' + comment + '&reply_comment_id=' + reply_comment_id + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                data = success.data;
                if (data.message == '1') {
                    $('#comment-reply-dis-inner-' + reply_comment_id).show();
                    $('#comment-reply-dis-inner-' + reply_comment_id).html(comment);
                    $('#edit-comment-reply-textbox-' + reply_comment_id).html();
                    $('#edit-comment-reply-textbox-' + reply_comment_id).hide();
                    $('#edit-comment-li-' + reply_comment_id).show();
                    $('#cancel-reply-comment-li-' + reply_comment_id).hide();
                    $('.new-comment-'+post_id).show();
                }                
            }, function (error) {
                setTimeout(function(){
                    $scope.send_edit_comment_reply(reply_comment_id,post_id);
                },500);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.deletePost = function (post_id, index) {
        if(user_id != "")
        {            
            $scope.p_d_post_id = post_id;
            $scope.p_d_index = index;
            $('#delete_post_model').modal('show');
        }
        else
        {
            $('#regmodal').modal('show');   
        }
    }
    $scope.deletedPost = function (post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (data.message == '1') {
                //$scope.postData.splice(index, 1);
                getUserDashboardVideo();
                getUserDashboardAudio();            
                getUserDashboardPdf();
                getUserDashboardImage();
                getUserDashboardPost();
                $scope.get_all_counter();
            }
        }, function (error) {
            setTimeout(function(){
                $scope.deletedPost(post_id, index);
            },500);
        });
    }

    /*function check_no_post_data() {
        var numberPost = $scope.postData.length;
        if (numberPost == 0) {
            $('.all_user_post').html(no_user_post_html);
        }
    }*/

    $scope.l_page = 0;
    $scope.l_total_record = 0;
    $scope.l_perpage = 7;
    
    $scope.like_post_id = 0;
    $scope.like_user_list = function (post_id) {
        $scope.like_post_id = post_id;
        pagenum = 1;

        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id + '&pagenum='+pagenum,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            if(success.data.countlike > 0)
            {
                $scope.l_page = success.data.page;
                $scope.l_total_record = success.data.countlike;
                $('#likeusermodal').modal('show');
                setTimeout(function(){
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },500);
            }
        }, function (error) {
            setTimeout(function(){
                $scope.like_user_list(post_id);
            },500);
        });
    }

    var is_processing = false;

    $scope.like_user_list_loadmore = function(post_id,pagenum) {
        if(is_processing)
        {
            return false;
        }
        is_processing = true;
        $('#like_loader').show();
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id + '&pagenum='+pagenum,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $('#like_loader').hide();
            if(success.data.likeuserlist)
            {
                for (var i in success.data.likeuserlist) {
                    $scope.get_like_user_list.push(success.data.likeuserlist[i]);
                }

                $scope.l_page = success.data.page;
                $scope.l_total_record = success.data.countlike;
                
                setTimeout(function(){
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },500);
                is_processing = false;
            }
            
        });
    }

    $('.like-popup-scroll').on('scroll', function () {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            var page = $scope.l_page;
            var total_record = $scope.l_total_record;
            var perpage_record = $scope.l_perpage;
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.l_page) + 1;
                    $scope.like_user_list_loadmore($scope.like_post_id,pagenum);
                }
            }
        }
    });
    scopeHold = $scope;
    
    $scope.get_user_links = function()
    {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_links',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.user_social_links = result.data.user_social_links_data;
                $scope.user_personal_links = result.data.user_personal_links_data;                
            }
            else
            {
                $scope.user_social_links = [];
                $scope.user_personal_links = [];
            }
            $("#social-link-loader").hide();
            $("#social-link-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_links();
            },500);
        });
    };
    

    $scope.get_user_experience = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_experience',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_experience = result.data.user_experience;
                $scope.user_experience = user_experience;
                $scope.exp_years = result.data.exp_years;
                $scope.exp_months = result.data.exp_months;
            }
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_experience();
            },500);
        });
    }
    

    $scope.get_user_education = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_education',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_education = result.data.user_education;
                $scope.user_education = user_education;
            }
            $("#edution-loader").hide();
            $("#edution-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_education();
            },500);
        });
    }
    

    $('input:radio[name="report_spam"]').change(function(){
        if($(this).val() == '0'){
           $("#report_other").show();
        }
        else
        {
            $("#report_other").hide();   
        }
    });
    $scope.report_post_id = 0;
    $scope.open_report_spam = function(post_id){
        $scope.report_post_id = post_id;
        $("#report_spam_form")[0].reset();
        $("#report-spam").modal('show');
    };

    $scope.report_spam_validate = {        
        rules: {           
            report_spam: {
                required: true,
            },
            other_report_spam: {
                required: {
                    depends: function(element) {
                        return $("input[name='report_spam']:checked").val() == 0 ? true : false;
                    }
                },
            },
        },
        messages: {
            report_spam: {
                required: "Select Report",
            },
            other_report_spam: {
                required: "Enter Other Report",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "report_spam") {
                error.appendTo($("#err_report"));
            } else {
                error.insertAfter(element);
            }
        },
    };
    $scope.save_report_spam = function(){
        if ($scope.report_spam_form.validate()) {

            $("#save_report_spam").attr("style","pointer-events:none;display:none;");
            $("#save_report_spam_loader").show();

            var reported_post_id = $scope.report_post_id;            
            var reported_reason = $("input[name='report_spam']:checked").val();
            var reported_reason_other = $("#other_report_spam").val();
            var updatedata = $.param({'reported_post_id':reported_post_id,'reported_reason':reported_reason,'reported_reason_other':reported_reason_other});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/save_report_spam',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {
                // $('#main_page_load').show();                
                success = result.data.success;
                $("#report_spam_form")[0].reset();                
                if(success == 1)
                {
                    
                }
                $("#save_report_spam").removeAttr("style");
                $("#save_report_spam_loader").hide();
                $("#report-spam").modal('hide');
            }, function (error) {
                setTimeout(function(){
                    $scope.save_report_spam();
                },500);
            });
        }
    };

    function getUserDashboardPost(pagenum) {
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
             if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }
            
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardPost?page=" + pagenum + "&user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            $scope.postData = success.data;
            $('#progress_div').hide();
            $('.progress-bar').css("width",0);
            $('.sr-only').text(0+"%");
            // check_no_post_data();

            setTimeout(function(){
                var originalLeave = $.fn.popover.Constructor.prototype.leave;
                $.fn.popover.Constructor.prototype.leave = function(obj){
                    var self = obj instanceof this.constructor ?
                    obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
                    var container, timeout;

                    originalLeave.call(this, obj);

                    if(obj.currentTarget) {
                        container = $(obj.currentTarget).siblings('.popover')
                        timeout = self.timeout;
                        container.one('mouseenter', function(){
                            //We entered the actual popover – call off the dogs
                            clearTimeout(timeout);
                            //Let's monitor popover content instead
                            container.one('mouseleave', function(){
                                $.fn.popover.Constructor.prototype.leave.call(self, self);
                            });
                        })
                    }
                };

                $('body').popover({
                    selector: '[data-popover]',
                    animation: true,
                    trigger: "click hover" ,
                    delay: {show: 1000, hide: 50},
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        // console.log($(this).data('tooltip-url'));
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);//$(this).data('tooltip-url'),div_id);
                        // return $('#popover-content').html();
                    },
                    // placement: 'auto',
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                });
                /*$('[data-toggle="popover"]').popover({
                    trigger: "manual" ,
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                        // return $('#popover-content').html();
                    },
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show");
                    $(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide");
                        }
                    }, 100);
                });*/
            },500);
            
            getUserDashboardImage();
            getUserDashboardArticle();
            getUserDashboardAudio();
            getUserDashboardVideo();
            getUserDashboardPdf();
            $scope.get_user_links();
            $scope.get_user_experience();
            $scope.get_user_education();

        }, function (error) {
            setTimeout(function(){
                getUserDashboardPost(pagenum);
            },500);
        });
    }

    getUserDashboardPost();
    getUserDashboardInformation()

    $scope.save_post = function(post_id,index,postData){
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        $('#save-post-' + post_id).attr('style','pointer-events: none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/save_user_post',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            var result = success.data;
            if(result.status == '1')
            {
                $scope.postData[index].is_user_saved_post = result.status;                
            }
            else
            {
                $scope.postData[index].is_user_saved_post = result.status;
            }
        }, function (error) {
            setTimeout(function(){
                $scope.save_post();
            },500);
        });
    };
});
app.controller('detailsController', function ($scope, $http, $location,$compile) {
    $scope.today = new Date();
    var all_months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $scope.user = {};
    $scope.$parent.title = "Details | Aileensoul";
    $scope.old_count_profile = 0;

    /*if($scope.$parent.live_slug != $scope.$parent.segment2)
    {
        $( "body" ).find("a[data-target]").remove();
    }*/
    // PROFEETIONAL DATA
    getFieldList();
    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }
            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();    
    
    function getFieldList() {
        // $('#main_loader').hide();        
        if($scope.$parent.pade_reload == true)
        {
            $('#main_loader').show();            
        }
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/detail_data',
            //data: 'u=' + user_id,
            data: 'u=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            
            details_data = success.data.detail_data;
            user_bio = success.data.user_bio;
            skills_data = success.data.skills_data;
            skills_data_edit = success.data.skills_data_edit;
            $scope.user_bio = user_bio;
            $scope.user_skills = skills_data;
            $scope.edit_user_skills = skills_data_edit;
            if(details_data)
            {                
                $scope.details_data = details_data;
                $scope.user_dob = $scope.details_data.user_dob;
                dob = $scope.details_data.user_dob.split('-');
                $scope.dob_month = dob[1];
                dob_month = dob[1];            
                dob_day = dob[2];            
                dob_year = dob[0];
            }
            //$scope.dob_fnc(dob_day,dob_month,dob_year);

            var profile_progress = success.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            if(count_profile == 100)
            {
                $("#edit-profile-move").hide();
            }
            $("#skill-loader").hide();
            $("#skill-body").show();

            $("#profile-loader").hide();
            $("#profile-body").show();

            $scope.set_progress(count_profile_value,count_profile);            
        }, function (error) {            
            setTimeout(function(){
                getFieldList();
            },500);
        });
        $('footer').show();
    }

    getAboutUser();
    function getAboutUser()
    {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_about_user',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                about_user_data = result.data.about_user_data;
                $scope.about_user_data = about_user_data;
                var user_langs = result.data.user_languages;
                $scope.user_languages = user_langs;
                $scope.primari_lang = user_langs[0];
                $scope.languageSet.language = user_langs.slice(1);
                var user_hobbies = "";
                if(about_user_data.user_hobbies.trim() != "")
                {
                    var user_hobbies = about_user_data.user_hobbies.split(',');
                }
                var edit_hobbies = [];
                if(user_hobbies.length > 0)
                {                    
                    user_hobbies.forEach(function(element,jobArrIndex) {
                      edit_hobbies[jobArrIndex] = {"hobby":element};
                    });
                }
                $scope.hobby_txt = edit_hobbies;
                $scope.user_fav_quote_headline = about_user_data.user_fav_quote_headline;

                
                var user_fav_artist = "";
                if(about_user_data.user_fav_artist.trim() != "")
                {
                    var user_fav_artist = about_user_data.user_fav_artist.split(',');
                }
                var edit_fav_art = [];
                if(user_fav_artist.length > 0)
                {                    
                    user_fav_artist.forEach(function(element,jobArrIndex) {
                      edit_fav_art[jobArrIndex] = {"fav_artist":element};
                    });
                }
                $scope.user_fav_artist_txt = edit_fav_art;

                var user_fav_book = "";
                if(about_user_data.user_fav_book.trim() != "")
                {
                    var user_fav_book = about_user_data.user_fav_book.split(',');
                }
                var edit_fav_book = [];
                if(user_fav_book.length > 0)
                {                    
                    user_fav_book.forEach(function(element,jobArrIndex) {
                      edit_fav_book[jobArrIndex] = {"fav_book":element};
                    });
                }
                $scope.user_fav_book_txt = edit_fav_book;

                var user_fav_sport = "";
                if(about_user_data.user_fav_sport.trim() != "")
                {
                    var user_fav_sport = about_user_data.user_fav_sport.split(',');
                }
                var edit_fav_sport = [];
                if(user_fav_sport.length > 0)
                {                    
                    user_fav_sport.forEach(function(element,jobArrIndex) {
                      edit_fav_sport[jobArrIndex] = {"fav_sport":element};
                    });
                }
                $scope.user_fav_sport_txt = edit_fav_sport;
                
                setTimeout(function(){
                    if($("#about-detail div").innerHeight() > 155)
                    {
                        $("#view-more-about").show();
                    }
                    else
                    {
                        $("#view-more-about").hide();
                    }
                },500);
            }
            $("#about-loader").hide();
            $("#about-body").show();
        }, function (error) {            
            setTimeout(function(){
                getAboutUser();
            },500);
        });
    }
    $scope.view_more_about = function(){
        $("#about-detail").removeClass("about-detail");
        $("#view-more-about").hide();
    };
    get_user_links();
    function get_user_links()
    {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_links',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.user_social_links = result.data.user_social_links_data;
                $scope.user_personal_links = result.data.user_personal_links_data;
                $scope.social_linksset.social_links = result.data.user_social_links_data_edit;
                $scope.personal_linksset.personal_links = result.data.user_personal_links_data_edit;
            }
            else
            {
                $scope.user_social_links = [];
                $scope.user_personal_links = [];
            }
            $("#social-link-loader").hide();
            $("#social-link-body").show();
        }, function (error) {
            setTimeout(function(){
                get_user_links();
            },500);
        });
    }
    $scope.goMainLink = function (path) {
        location.href = path;
    }
    $scope.makeActive = function (item,slug) {
        $scope.active = $scope.active == item ? '' : item;
    }

    $scope.save_user_bio = function(){
        var user_bio = $("#user_bio").val();        
        // if(user_bio != "" && $scope.user_bio != user_bio)
        {
            $("#user_bio_loader").show();
            $("#user_bio_save").attr("style","pointer-events:none;display:none;");
            var updatedata = $.param({'user_bio':user_bio});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/save_user_bio',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {                    
                    user_bio = result.data.user_bio;
                    $scope.user_bio = user_bio;                
                }
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
                $scope.get_all_counter();
                $("#user_bio_save").removeAttr("style");
                $("#user_bio_loader").hide();
                $("#profile-overview").modal('hide');
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_bio();
                },500);
            });
        }
    };

    $("#profile-overview").on("hide.bs.modal", function () {
        $("#user_bio").val($scope.user_bio);
    });
    var close_skill = 0;
    $scope.save_user_skills = function(){

        $("#user_skills_loader").show();
        $("#user_skills_save").attr("style","pointer-events:none;display:none;");
        var updatedata = $.param({"user_skills":$scope.edit_user_skills});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/save_user_skills',                
            data: updatedata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            success = result.data.success;
            if(success == 1)
            {
                skills_data = result.data.skills_data;
                skills_data_edit = result.data.skills_data_edit;
                $scope.user_skills = skills_data;
                $scope.edit_user_skills = skills_data_edit;
            }
            close_skill = 1;

            var profile_progress = result.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            $scope.set_progress(count_profile_value,count_profile);

            $scope.get_all_counter();
            
            $("#user_skills_save").removeAttr("style");
            $("#user_skills_loader").hide();
            // $("#skills").modal('hide');
            $("#skills .modal-close").click();
        }, function (error) {
            setTimeout(function(){
                $scope.save_user_skills();
            },500);
        });
        
    };

    $("#skills").on("hide.bs.modal", function () {
        if(close_skill == 0)
        {            
            var edit_user_skills = [];
            $scope.user_skills.forEach(function(element,catArrIndex) {
              edit_user_skills[catArrIndex] = {name:element.name};
            });
            $scope.$apply(function () {
                $scope.edit_user_skills = edit_user_skills;//$scope.user_skills;
            });
        }
        else
        {
            close_skill = 0;
        }
    });

    $scope.load_skills = [];
    $scope.loadSkills = function ($query) {
        return $http.get(base_url + 'userprofile_page/get_skills', {cache: true}).then(function (response) {
            var load_skills = response.data;
            return load_skills.filter(function (title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };
    
    $scope.save_about_user = function(){
        //if ($scope.about_user_form.validate())
        {
            $("#about_user_loader").show();
            $("#save_about_user").attr("style","pointer-events:none;display:none;");
            
            // var languages = $('.frm_language').serialize();
            var languages = $('.language').serializeArray();
            var proficiency = $('.proficiency').serializeArray();
            // var languages = $('.frm_language').serializeArray();
            // var languages = new FormData('.frm_language');

            // var lang_prof = $('.lang_prof :selected').serialize();
            var dob = '';//dob_year_txt+'-'+dob_month_txt+'-'+dob_day_txt;        
            var updatedata = $.param({'user_dob':dob,'user_hobby':$scope.hobby_txt,'user_fav_quote_headline':$scope.user_fav_quote_headline,'user_fav_artist':$scope.user_fav_artist_txt,'user_fav_book':$scope.user_fav_book_txt,'user_fav_sport':$scope.user_fav_sport_txt,"language":languages,"proficiency":proficiency});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/save_about_user',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {
                    $scope.about_user_data = result.data.about_user_data;
                    var user_langs = result.data.user_languages;
                    $scope.user_languages = user_langs;
                    $scope.primari_lang = user_langs[0];
                    $scope.languageSet.language = user_langs.slice(1);
                }
                setTimeout(function(){
                    if($("#about-detail div").innerHeight() > 155)
                    {
                        $("#view-more-about").show();
                    }
                    else
                    {
                        $("#view-more-about").hide();   
                    }
                },500);
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
                $scope.get_all_counter();
                $("#save_about_user").removeAttr("style");
                $("#about_user_loader").hide();
                $("#detail-about").modal('hide');
            }, function (error) {
                setTimeout(function(){
                    $scope.save_about_user();
                },500);
            });
        }
    };

    $scope.languageSet = {language: []};

    $scope.languageSet.language = [];
    $scope.addNewLanguage = function () {
        // console.log($scope.languageSet.language.length);
        if($scope.languageSet.language.length < 99)
        {
            $scope.languageSet.language.push('');
        }
    };

    $scope.removeLanguage = function (z) {
        //var lastItem = $scope.languageSet.language.length - 1;
        $scope.languageSet.language.splice(z,1);
    };
    $scope.language = [];
    $scope.get_languages = function(id) {        
        $http({
            method: 'POST',
            url: base_url + 'general_data/get_languages',
            data: 'q=' + $scope.language[id].lngtxt,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.lang_search_result = data;
        }, function (error) {
            setTimeout(function(){
                $scope.get_languages(id);
            },500);
        });
    };

    //Research Start
    $scope.research_pub_fnc = function(dob_day,dob_month,dob_year){
        $("#recdateerror").hide();
        $("#recdateerror").html('');
        var kcyear = document.getElementsByName("research_year")[0],
        kcmonth = document.getElementsByName("research_month")[0],
        kcday = document.getElementsByName("research_day")[0];                
        
        var d = new Date();
        var n = d.getFullYear();
        year_opt = "";
        for (var i = n; i >= 1950; i--) {
            if(dob_year == i)
            {
                year_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
            }
            else
            {                
                year_opt += "<option value='"+i+"'>"+i+"</option>";
            }            
        }
        $("#research_year").html(year_opt);
        
        function validate_date(dob_day,dob_month,dob_year) {
            var y = +kcyear.value;
            if(dob_month != ""){
                var m = dob_month;
            }
            else{
            var m = kcmonth.value;
            }

            if(dob_day != ""){
                var d = dob_day;
            }
            else{                
                var d = kcday.value;
            }
            if (m === "02"){
                var mlength = 28 + (!(y & 3) && ((y % 100) !== 0 || !(y & 15)));
            }
            else{
                var mlength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m - 1];
            }

            kcday.length = 0;
            var day_opt = "";
            for (var i = 1; i <= mlength; i++) {
                if(dob_day == i)
                {
                    day_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
                }
                else
                {                
                    day_opt += "<option value='"+i+"'>"+i+"</option>";
                }
            }
            $("#research_day").html(day_opt);
        }
        validate_date(dob_day,dob_month,dob_year);
    };
    $scope.research_error = function()
    {
        $("#recdateerror").hide();
        $("#recdateerror").html('');
    };
    $scope.research_validate = {
        rules: {
            research_title: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
            research_desc: {
                required: true,
                maxlength: 700,
                minlength: 50
            },
            research_field: {
                required: true,
            },
            research_other_field: {
                required: {
                    depends: function(element) {
                        return $("#research_field option:selected").val() == 0 ? true : false;
                    }
                },
            },
            research_url: {
                url: true,
            },
            research_month: {
                required: true,
            },
            research_day: {
                required: true,
            },
            research_year: {
                required: true,
            }
        },
        groups: {
            research_year: "research_year research_month research_day"
        },
        messages: {
            research_title: {
                required: "Please enter research title",
            },
            research_desc: {
                required: "Please enter description",
            },
            research_field: {
                required: "Please select field",
            },
            research_url: {                
                url: "URL must start with http:// or https://",
            },            
            research_day: {
                required: "Please enter research publishing date",
            },
            research_month: {
                required: "Please enter research publishing date",
            },
            research_year: {
                required: "Please enter research publishing date",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("type") == "checkbox") {
                error.insertAfter($("#lbl_term_condi"));
            } else {
                error.insertAfter(element);
            }
        },
    };
    var research_formdata = new FormData();
    $(document).on('change','#research_document', function(e){
        $("#research_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#research_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','docx','doc','PDF'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                research_formdata.append('file', $('#research_document')[0].files[0]);
            }
            else {
                $(this).val("");
            }         
        }
    });
    $scope.save_user_research = function(){
        if ($scope.research_form.validate()) {
            $("#user_research_loader").show();
            $("#user_research_save").attr("style","pointer-events:none;display:none;");

            var dob_day_txt = $("#research_day option:selected").val();
            var dob_month_txt = $("#research_month option:selected").val();
            var dob_year_txt = $("#research_year option:selected").val();

            var todaydate = new Date();
            var dd = todaydate.getDate();
            var mm = todaydate.getMonth() + 1;
            var yyyy = todaydate.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            var todaydate = yyyy + '/' + mm + '/' + dd;
            var value = dob_year_txt + '/' + dob_month_txt + '/' + dob_day_txt;

            var d1 = Date.parse(todaydate);
            var d2 = Date.parse(value);

            if (d1 < d2) {
                $("#recdateerror").html("Date of publishing always less than to today's date.");
                $("#recdateerror").show();

                $("#user_research_save").removeAttr("style");
                $("#user_research_loader").hide();
                return false;
            }

            research_formdata.append('edit_research', $scope.edit_research);
            research_formdata.append('research_document_old', $scope.research_document_old);
            research_formdata.append('research_title', $('#research_title').val());
            research_formdata.append('research_desc', $('#research_desc').val());
            research_formdata.append('research_field', $('#research_field option:selected').val());
            research_formdata.append('research_other_field', $('#research_other_field').val());
            research_formdata.append('research_url', $('#research_url').val());
            
            research_formdata.append('research_month',$("#research_month option:selected").val());
            research_formdata.append('research_day',$("#research_day option:selected").val());
            research_formdata.append('research_year',$("#research_year option:selected").val());
            $http.post(base_url + 'userprofile_page/save_research_user', research_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_research = result.user_research;
                    }
                    research_formdata = new FormData();
                    $("#user_research_save").removeAttr("style");
                    $("#user_research_loader").hide();
                    $("#research_form")[0].reset();
                    $("#research").modal('hide');
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_research();
                },500);
            });
        }
    };

    $scope.get_user_research = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_research',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.user_research = result.data.user_research;
            }
            $("#research-loader").hide();
            $("#research-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_research();
            },500);
        });
    };
    $scope.get_user_research();

    $scope.view_more_research = 2;
    $scope.research_view_more = function(){
        $scope.view_more_research = $scope.user_research.length;
        $("#view-more-research").hide();
    };
    $scope.other_field_research = function()
    {
        if($scope.research_field == 0 && $scope.research_field != "")
        {
            $("#research_other_field_div").show();
        }
        else
        {
            $("#research_other_field_div").hide();
        }
    }

    $scope.reset_research_form = function(){        
        $scope.edit_research = 0;
        $scope.research_file_old = '';
        $("#research").removeClass("edit-form-cus");
        $("#research_day").html("");
        $("#research_year").html("");
        $("#research_file_error").hide();
        $("#research_other_field_div").hide();
        $("#research_doc_prev").remove();
        $("#delete_user_research_modal").remove();
        $("#research_form")[0].reset();
    };
    $scope.edit_user_research = function(index){
        $scope.reset_research_form();
        $("#research").addClass("edit-form-cus");
        var research_arr = $scope.user_research[index];
        $scope.edit_research = research_arr.id_research;
        $("#research_title").val(research_arr.research_title);
        $("#research_field").val(research_arr.research_field);
        if(research_arr.research_field == 0)
        {
            $("#research_other_field_div").show();
            $("#research_other_field").val(research_arr.research_other_field);
        }
        $("#research_url").val(research_arr.research_url);
        $("#research_desc").val(research_arr.research_desc);        
        var research_date_arr = research_arr.research_publish_date.split("-");
        research_day = research_date_arr[2];
        research_month = research_date_arr[1];
        research_year = research_date_arr[0];
        $("#research_month").val(research_month);
        $scope.research_pub_fnc(research_day,research_month,research_year);

        var research_file_name = research_arr.research_document;
        $scope.research_document_old = research_file_name;
        if(research_file_name.trim() != "")
        {            
            var filename_arr = research_file_name.split('.');
            $("#research_doc_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="research_doc_prev" class="screen-shot"><a href="'+user_research_upload_url+research_file_name+'" target="_blank"><img style="width: 100px;" src="'+user_research_upload_url+research_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="research_doc_prev" class="screen-shot"><a class="file-preview-cus" href="'+user_research_upload_url+research_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#research_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.research_form.validate();
        },1000);
        var delete_btn = '<a id="delete_user_research_modal" href="#" data-target="#delete-research-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#user_research_loader"));
        $compile(contentbtn)($scope);
        $("#research").modal("show");
    };

    $scope.delete_user_research = function(){
        $("#delete_user_research").attr("style","pointer-events:none;display:none;");
        $("#user_research_del_loader").show();
        $("#research-delete-btn").hide();
        if($scope.edit_research != 0)
        {
            var expdata = $.param({'research_id': $scope.edit_research});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/delete_user_research',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_research = result.user_research;                        
                        $("#delete-research-model").modal('hide');
                        $("#research").modal('hide');
                        $("#delete_user_research").removeAttr("style");
                        $("#user_research_del_loader").hide();
                        $("#research-delete-btn").show();                        
                        $scope.reset_research_form();
                    }
                    else
                    {
                        $("#delete-research-model").modal('hide');
                        $("#research").modal('hide');
                        $("#delete_user_research").removeAttr("style");
                        $("#user_research_del_loader").hide();
                        $("#research-delete-btn").show();
                        $scope.reset_research_form();
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.delete_user_research();
                },500);
            });
        }
    };
    //Research End

    //Socila Links Start
    $scope.social_linksset = {social_links: []};

    $scope.social_linksset.social_links = [];
    $scope.addNewSocialLinks = function () {
        // console.log($scope.social_linksset.social_links.length);
        if($scope.social_linksset.social_links.length < 7)
        {
            $scope.social_linksset.social_links.push('');
            if($scope.social_linksset.social_links.length == 7)
            {
                $("#add-new-link").hide();
            }
        }
        else
        {
            $("#add-new-link").hide();
        }
    };

    $scope.removeSocialLinks = function (z) {
        //var lastItem = $scope.social_linksset.social_links.length - 1;
        $scope.social_linksset.social_links.splice(z,1);
        $("#add-new-link").show();
    };

    $scope.check_socialurl = function(id){
        var link_type = $("#link_type"+id+" option:selected").val();
        var link_url = $("#link_url"+id).val();        
        if(link_type == "Facebook")
        {            
            if(/(http|https):\/\/?(?:www\.)?(mbasic.facebook|m\.facebook|facebook|fb)\.(com|me)\/(?:(?:\w\.)*#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "Google")
        {            
            if(/\+[^/]+|\d{21}/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "Instagram")
        {            
            if(/https?:\/\/(www\.)?instagram\.com\/([A-Za-z0-9_](?:(?:[A-Za-z0-9_]|(?:\.(?!\.))){0,28}(?:[A-Za-z0-9_]))?)/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "LinkedIn")
        {            
            if(/(http|https):\/\/?(?:www\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
               return true; 
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "Pinterest")
        {            
            if(/^http(s)?:\/\/(in.)pinterest.com\/(.*)?$/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "GitHub")
        {            
            if(/http(s)?:\/\/(www\.)?github\.(com|io)\/[A-z 0-9 _-]+\/?/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }
        if(link_type == "Twitter")
        {            
            if(/http(s)?:\/\/(.*\.)?twitter\.com\/[A-z 0-9 _]+\/?/i.test(link_url)){
                $("#link_url"+id).removeClass("error");
                return true;
            }
            else
            {
                $("#link_url"+id).addClass("error");
                return false;
            }
        }

    };

    $scope.personal_linksset = {personal_links: []};

    $scope.personal_linksset.personal_links = [];
    $scope.addNewPersonalLinks = function () {
        // console.log($scope.personal_linksset.personal_links.length);
        if($scope.personal_linksset.personal_links.length < 10)
        {
            $scope.personal_linksset.personal_links.push('');
            if($scope.personal_linksset.personal_links.length == 10)
            {
                $("#add-personla-link").hide();
            }
        }
        else
        {
            $("#add-personla-link").hide();
        }
    };

    $scope.removePersonalLinks = function (z) {
        //var lastItem = $scope.personal_linksset.personal_links.length - 1;
        $scope.personal_linksset.personal_links.splice(z,1);
        $("#add-personla-link").show();
    };
    $scope.check_personalurl = function(id){
        var personal_link_url = $("#personal_link_url"+id).val();
        //var regexp =   /^(https):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
        var res = personal_link_url.match(/(http(s)?:\/\/.)(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
        if(res != null)// if (regexp.test(personal_link_url))
        {
            $("#personal_link_url"+id).removeClass("error");
            return true;
        }
        else
        {
            $("#personal_link_url"+id).addClass("error");
            return false;
        }
    };

    $scope.save_user_links = function(){
        $("#user_links_loader").show();
        $("#user_links_save").attr("style","pointer-events:none;display:none;");
        var link_type = $('.link_type').serializeArray();
        var link_url = $('.link_url').serializeArray();
        var err_link = 0;
        link_url.forEach(function(links,idx) {          
          if($scope.check_socialurl(idx) === false)
          {
            err_link = 1;
          }
        });        

        var personal_link_url = $('.personal_link_url').serializeArray();
        personal_link_url.forEach(function(links,idx) {          
          if($scope.check_personalurl(idx) === false)
          {
            err_link = 1;
          }
        });
        if(err_link == 1)
        {
            $("#user_links_save").removeAttr("style");
            $("#user_links_loader").hide();
            return;
        }
        var updatedata = $.param({'link_type':link_type,'link_url':link_url,'personal_link_url':personal_link_url});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/save_user_links',                
            data: updatedata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            // $('#main_page_load').show();                
            success = result.data.success;
            if(success == 1)
            {
                user_social_links_data = result.data.user_social_links_data;
                user_personal_links_data = result.data.user_personal_links_data;
                $scope.user_social_links = user_social_links_data;
                $scope.user_personal_links = user_personal_links_data;
                $scope.social_linksset.social_links = user_social_links_data;
                $scope.personal_linksset.personal_links = user_personal_links_data;
            }
            var profile_progress = result.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            $scope.set_progress(count_profile_value,count_profile);
            $scope.get_all_counter();
            $("#user_links_save").removeAttr("style");
            $("#user_links_loader").hide();
            $("#social-link").modal('hide');
        }, function (error) {
            setTimeout(function(){
                $scope.save_user_links();
            },500);
        });
    };
    //Socila Links End

    //User Idol Start
    var idol_formdata = new FormData();
    $(document).on('change','#user_idol_file', function(e){
        $("#user_idol_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#user_idol_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {            
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                idol_formdata.append('user_idol_file', $('#user_idol_file')[0].files[0]);
            }
            else {
                $(this).val("");
            }         
        }
    });
    $scope.idol_validate = {
        rules: {
            user_idol_file: {
                required: {
                    depends: function(element) {
                        return $scope.edit_idols == 0 ? true : false;
                    }
                },
            },
            user_idol_name: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
        },
        messages: {
            user_idol_file: {
                required: "Please select image",
            },
            user_idol_name: {
                required: "Please enter name",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("type") == "checkbox") {                
            } else {
                error.insertAfter(element);
            }
        },
    };
    $scope.save_user_idol = function(){
        if ($scope.idol_form.validate()) {
            
            $("#user_idol_loader").show();
            $("#user_idol_save").attr("style","pointer-events:none;display:none;");

            idol_formdata.append('edit_idols', $scope.edit_idols);
            idol_formdata.append('user_idol_pic_old', $scope.user_idol_pic_old);
            idol_formdata.append('user_idol_name', $('#user_idol_name').val());
            $http.post(base_url + 'userprofile_page/save_user_idol', idol_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_idols = result.user_idols;
                        $("#user_idol_save").removeAttr("style");
                        $("#user_idol_loader").hide();
                        $("#idol_form")[0].reset();
                        $("#inspiration").modal('hide');                        
                    }
                    else
                    {
                        $("#user_idol_save").removeAttr("style");
                        $("#user_idol_loader").hide();
                        $("#idol_form")[0].reset();
                        $("#inspiration").modal('hide');
                    }
                    var profile_progress = result.profile_progress;
                    var count_profile_value = profile_progress.user_process_value;
                    var count_profile = profile_progress.user_process;
                    $scope.progress_status = profile_progress.progress_status;
                    $scope.set_progress(count_profile_value,count_profile);
                    $scope.get_all_counter();
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_idol();
                },500);
            });
        }
    };
    $scope.get_user_idol = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_idol',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.user_idols = result.data.user_idols;
            }
            $("#idol-loader").hide();
            $("#idol-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_idol();
            },500);
        });
    };
    $scope.get_user_idol();

    $scope.view_more_idol = 2;
    $scope.idol_view_more = function(){
        $scope.view_more_idol = $scope.user_idols.length;
        $("#view-more-idol").hide();
    };

    $scope.reset_user_idols = function(){        
        $scope.edit_idols = 0;
        $scope.user_idol_pic_old = "";
        $("#inspiration").removeClass("edit-form-cus");
        idol_formdata = new FormData();
        $("#research_doc_prev").remove();
        $("#delete_user_idol_modal").remove();
        $("#idol_form")[0].reset();
    };

    $scope.edit_user_idols = function(index){
        $scope.reset_user_idols();
        $("#inspiration").addClass("edit-form-cus");
        var idols_arr = $scope.user_idols[index];
        
        $scope.edit_idols = idols_arr.id_idol;
        
        $("#user_idol_name").val(idols_arr.user_idol_name);
        
        var idol_pic_name = idols_arr.user_idol_pic;
        $scope.user_idol_pic_old = idol_pic_name;
        if(idol_pic_name.trim() != "")
        {            
            var filename_arr = idol_pic_name.split('.');
            $("#research_doc_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="research_doc_prev" class="screen-shot"><a href="'+user_idol_upload_url+idol_pic_name+'" target="_blank"><img style="width: 100px;" src="'+user_idol_upload_url+idol_pic_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="research_doc_prev" class="screen-shot"><a class="file-preview-cus" href="'+user_idol_upload_url+idol_pic_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#user_idol_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.research_form.validate();
        },1000);
        var delete_btn = '<a id="delete_user_idol_modal" href="#" data-target="#delete-idol-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#user_idol_loader"));
        $compile(contentbtn)($scope);
        $("#inspiration").modal("show");
    };

    $scope.delete_user_idol = function(){
        $("#delete_user_idol").attr("style","pointer-events:none;display:none;");
        $("#user_idol_del_loader").show();
        $("#idol-delete-btn").hide();
        if($scope.edit_idols != 0)
        {
            var expdata = $.param({'idol_id': $scope.edit_idols});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/delete_user_idol',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_idols = result.user_idols;
                        $("#delete-idol-model").modal('hide');
                        $("#inspiration").modal('hide');
                        $("#delete_user_idol").removeAttr("style");
                        $("#user_idol_del_loader").hide();
                        $("#idol-delete-btn").show();                        
                        $scope.reset_user_idols();
                        var profile_progress = result.profile_progress;
                        var count_profile_value = profile_progress.user_process_value;
                        var count_profile = profile_progress.user_process;
                        $scope.progress_status = profile_progress.progress_status;
                        $scope.set_progress(count_profile_value,count_profile);
                        $scope.get_all_counter();
                    }
                    else
                    {
                        $("#delete-idol-model").modal('hide');
                        $("#inspiration").modal('hide');
                        $("#delete_user_idol").removeAttr("style");
                        $("#user_idol_del_loader").hide();
                        $("#idol-delete-btn").show();
                        $scope.reset_user_idols();
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.delete_user_idol();
                },500);
            });
        }
    };
    //User Idol End

    // User Publication Start
    $scope.publication_date_fnc = function(dob_day,dob_month,dob_year){
        $("#pubdateerror").hide();
        $("#pubdateerror").html('');
        var kcyear = document.getElementsByName("publication_year")[0],
        kcmonth = document.getElementsByName("publication_month")[0],
        kcday = document.getElementsByName("publication_day")[0];                
        
        var d = new Date();
        var n = d.getFullYear();
        year_opt = "";
        for (var i = n; i >= 1950; i--) {
            if(dob_year == i)
            {
                year_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
            }
            else
            {                
                year_opt += "<option value='"+i+"'>"+i+"</option>";
            }            
        }
        $("#publication_year").html(year_opt);
        
        function validate_date(dob_day,dob_month,dob_year) {
            var y = +kcyear.value;
            if(dob_month != ""){
                var m = dob_month;
            }
            else{
            var m = kcmonth.value;
            }

            if(dob_day != ""){
                var d = dob_day;
            }
            else{                
                var d = kcday.value;
            }
            if (m === "02"){
                var mlength = 28 + (!(y & 3) && ((y % 100) !== 0 || !(y & 15)));
            }
            else{
                var mlength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m - 1];
            }

            kcday.length = 0;
            var day_opt = "";
            for (var i = 1; i <= mlength; i++) {
                if(dob_day == i)
                {
                    day_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
                }
                else
                {                
                    day_opt += "<option value='"+i+"'>"+i+"</option>";
                }
            }
            $("#publication_day").html(day_opt);
        }
        validate_date(dob_day,dob_month,dob_year);
    };
    $scope.publication_error = function()
    {
        $("#pubdateerror").hide();
        $("#pubdateerror").html('');
    };

    var publication_formdata = new FormData();
    $(document).on('change','#pub_file', function(e){
        $("#pub_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#pub_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                publication_formdata.append('pub_file', $('#pub_file')[0].files[0]);
            }
            else {
                $(this).val("");
            }         
        }
    });

    $scope.publication_validate = {
        rules: {            
            pub_title: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
            pub_author: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
            pub_url: {
                url: true,                
            },
            pub_publisher: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
            publication_month: {
                required: true,
            },
            publication_day: {
                required: true,
            },
            publication_year: {
                required: true,
            },
            pub_desc: {
                required: true,
                maxlength: 700,
                minlength: 10
            },
        },
        /*groups: {
            publication_date: "publication_year publication_month publication_day"
        },   */     
        messages: {
            pub_title: {
                required: "Please enter publication title",
            },
            pub_author: {
                required: "Please enter publication author",
            },
            pub_url: {
                url: "URL must start with http:// or https://",
            },
            pub_publisher: {
                required: "Please enter publisher",
            },
            publication_month: {
                required: "Please select publication date",
            },
            publication_day: {
                required: "Please select publication date",
            },
            publication_year: {
                required: "Please select publication date",
            },
            pub_desc: {
                required: "Please enter publication description",
            },

        },
        errorPlacement: function (error, element) {
            /*if (element.attr("name") == "publication_month" || element.attr("name") == "publication_day" || element.attr("name") == "publication_year") {
                error.insertAfter("#publication_year");                
            } else {*/
                error.insertAfter(element);
            // }
        },
    };
    $scope.save_user_publication = function(){
        if ($scope.publication_form.validate()) {
            $("#user_publication_loader").show();
            $("#user_publication_save").attr("style","pointer-events:none;display:none;");

            var pub_day_txt = $("#publication_day option:selected").val();
            var pub_month_txt = $("#publication_month option:selected").val();
            var pub_year_txt = $("#publication_year option:selected").val();

            var todaydate = new Date();
            var dd = todaydate.getDate();
            var mm = todaydate.getMonth() + 1;
            var yyyy = todaydate.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            var todaydate = yyyy + '/' + mm + '/' + dd;
            var value = pub_year_txt + '/' + pub_month_txt + '/' + pub_day_txt;

            var d1 = Date.parse(todaydate);
            var d2 = Date.parse(value);

            if (d1 < d2) {
                $("#recdateerror").html("Date of publishing always less than to today's date.");
                $("#recdateerror").show();

                $("#user_research_save").removeAttr("style");
                $("#user_research_loader").hide();
                return false;
            }

            publication_formdata.append('edit_publication', $scope.edit_publication);
            publication_formdata.append('pub_file_old', $scope.pub_file_old);
            publication_formdata.append('pub_title', $('#pub_title').val());
            publication_formdata.append('pub_author', $('#pub_author').val());
            publication_formdata.append('pub_url', $('#pub_url').val());
            publication_formdata.append('pub_publisher', $('#pub_publisher').val());
            publication_formdata.append('pub_desc', $('#pub_desc').val());            
            publication_formdata.append('pub_day_txt', pub_day_txt);            
            publication_formdata.append('pub_month_txt', pub_month_txt);            
            publication_formdata.append('pub_year_txt', pub_year_txt);            

            $http.post(base_url + 'userprofile_page/save_user_publication', publication_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $("#user_publication_save").removeAttr("style");
                        $("#user_publication_loader").hide();
                        $("#publication_form")[0].reset();
                        $scope.user_publication = result.user_publication;                         
                        $("#publication").modal('hide');
                    }
                    else
                    {
                        $("#user_publication_save").removeAttr("style");
                        $("#user_publication_loader").hide();
                        $("#publication_form")[0].reset();
                        $("#publication").modal('hide');
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_publication();
                },500);
            });
        }
    };

    $scope.get_user_publication = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_publication',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_publication = result.data.user_publication;
                $scope.user_publication = user_publication;
            }
            $("#publication-loader").hide();
            $("#publication-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_publication();
            },500);
        });
    }
    $scope.get_user_publication();
    $scope.view_more_publication = 2;
    $scope.publication_view_more = function(){
        $scope.view_more_publication = $scope.user_publication.length;
        $("#view-more-publication").hide();
    };

    $scope.reset_publication_form = function(){        
        $scope.edit_publication = 0;
        $scope.pub_file_old = '';
        $("#publication").removeClass("edit-form-cus");
        $("#publication_day").html("");
        $("#publication_year").html("");
        $("#pub_file_error").hide();        
        $("#pub_file_prev").remove();
        $("#delete_user_publication_modal").remove();
        $("#publication_form")[0].reset();
    };
    $scope.edit_user_publication = function(index){
        $scope.reset_publication_form();
        $("#publication").addClass("edit-form-cus");
        var publication_arr = $scope.user_publication[index];
        $scope.edit_publication = publication_arr.id_publication;
        $("#pub_title").val(publication_arr.pub_title);
        $("#pub_author").val(publication_arr.pub_author);        
        $("#pub_url").val(publication_arr.pub_url);
        $("#pub_publisher").val(publication_arr.pub_publisher);        
        var publication_date_arr = publication_arr.pub_date.split("-");
        publication_day = publication_date_arr[2];
        publication_month = publication_date_arr[1];
        publication_year = publication_date_arr[0];
        $("#publication_month").val(publication_month);
        $scope.publication_date_fnc(publication_day,publication_month,publication_year);

        $("#pub_desc").val(publication_arr.pub_desc);

        var publication_file_name = publication_arr.pub_file;
        $scope.pub_file_old = publication_file_name;
        if(publication_file_name.trim() != "")
        {            
            var filename_arr = publication_file_name.split('.');
            $("#pub_file_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="pub_file_prev" class="screen-shot"><a href="'+user_publication_upload_url+publication_file_name+'" target="_blank"><img style="width: 100px;" src="'+user_publication_upload_url+publication_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="pub_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+user_publication_upload_url+publication_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#pub_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.publication_form.validate();
        },1000);
        var delete_btn = '<a id="delete_user_publication_modal" href="#" data-target="#delete-publication-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#user_publication_loader"));
        $compile(contentbtn)($scope);
        $("#publication").modal("show");
    };

    $scope.delete_user_publication = function(){
        $("#delete_user_publication").attr("style","pointer-events:none;display:none;");
        $("#user_publication_del_loader").show();
        $("#publication-delete-btn").hide();
        if($scope.edit_publication != 0)
        {
            var expdata = $.param({'publication_id': $scope.edit_publication});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/delete_user_publication',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_publication = result.user_publication;
                        $("#delete-publication-model").modal('hide');
                        $("#publication").modal('hide');
                        $("#delete_user_publication").removeAttr("style");
                        $("#user_publication_del_loader").hide();
                        $("#publication-delete-btn").show();                        
                        $scope.reset_publication_form();
                    }
                    else
                    {
                        $("#delete-publication-model").modal('hide');
                        $("#publication").modal('hide');
                        $("#delete_user_publication").removeAttr("style");
                        $("#user_publication_del_loader").hide();
                        $("#publication-delete-btn").show();
                        $scope.reset_publication_form();
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.delete_user_publication();
                },500);
            });
        }
    };
    // User Publication End

    //User Patent Start
    $scope.patent_date_fnc = function(dob_day,dob_month,dob_year){
        $("#patentdateerror").hide();
        $("#patentdateerror").html('');
        var kcyear = document.getElementsByName("patent_year")[0],
        kcmonth = document.getElementsByName("patent_month")[0],
        kcday = document.getElementsByName("patent_day")[0];                
        
        var d = new Date();
        var n = d.getFullYear();
        year_opt = "";
        for (var i = n; i >= 1950; i--) {
            if(dob_year == i)
            {
                year_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
            }
            else
            {                
                year_opt += "<option value='"+i+"'>"+i+"</option>";
            }            
        }
        $("#patent_year").html(year_opt);
        
        function validate_date(dob_day,dob_month,dob_year) {
            var y = +kcyear.value;
            if(dob_month != ""){
                var m = dob_month;
            }
            else{
            var m = kcmonth.value;
            }

            if(dob_day != ""){
                var d = dob_day;
            }
            else{                
                var d = kcday.value;
            }
            if (m === "02"){
                var mlength = 28 + (!(y & 3) && ((y % 100) !== 0 || !(y & 15)));
            }
            else{
                var mlength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m - 1];
            }

            kcday.length = 0;
            var day_opt = "";
            for (var i = 1; i <= mlength; i++) {
                if(dob_day == i)
                {
                    day_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
                }
                else
                {                
                    day_opt += "<option value='"+i+"'>"+i+"</option>";
                }
            }
            $("#patent_day").html(day_opt);
        }
        validate_date(dob_day,dob_month,dob_year);
    };
    $scope.patent_date_error = function()
    {
        $("#patentdateerror").hide();
        $("#patentdateerror").html('');
    };

    var patent_formdata = new FormData();
    $(document).on('change','#patent_file', function(e){
        $("#patent_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#patent_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                patent_formdata.append('patent_file', $('#patent_file')[0].files[0]);
            }
            else {
                $(this).val("");
            }         
        }
    });

    $scope.patent_validate = {
        rules: {            
            patent_title: {
                required: true,
                maxlength: 200,
                minlength: 3
            },            
            patent_creator: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
            patent_number: {
                required: true,
                maxlength: 200,
            },            
            patent_month: {
                required: true,
            },
            patent_day: {
                required: true,
            },
            patent_year: {
                required: true,
            },
            patent_office: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
            patent_url: {
                url: true,                
            },
            patent_desc: {
                required: true,
                maxlength: 700,
                minlength: 10
            },
        },
        /*groups: {
            publication_date: "publication_year publication_month publication_day"
        },   */     
        messages: {
            patent_title: {
                required: "Please enter patent title",
            },
            patent_creator: {
                required: "Please enter patent creator",
            },
            patent_number: {
                required: "Please enter patent creator",
            },
            patent_month: {
                required: "Please select patent date",
            },
            patent_day: {
                required: "Please select patent date",
            },
            patent_year: {
                required: "Please select patent date",
            },
            patent_office: {
                required: "Please patent office",
            },
            patent_url: {
                url: "URL must start with http:// or https://",
            },
            patent_desc: {
                required: "Please enter patent description",
            },

        },
        errorPlacement: function (error, element) {
            /*if (element.attr("name") == "publication_month" || element.attr("name") == "publication_day" || element.attr("name") == "publication_year") {
                error.insertAfter("#publication_year");                
            } else {*/
                error.insertAfter(element);
            // }
        },
    };
    $scope.save_user_patent = function(){
        if ($scope.patent_form.validate()) {
            $("#user_patent_loader").show();
            $("#user_patent_save").attr("style","pointer-events:none;display:none;");

            var patent_day = $("#patent_day option:selected").val();
            var patent_month = $("#patent_month option:selected").val();
            var patent_year = $("#patent_year option:selected").val();

            var todaydate = new Date();
            var dd = todaydate.getDate();
            var mm = todaydate.getMonth() + 1;
            var yyyy = todaydate.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            var todaydate = yyyy + '/' + mm + '/' + dd;
            var value = patent_year + '/' + patent_month + '/' + patent_day;

            var d1 = Date.parse(todaydate);
            var d2 = Date.parse(value);

            if (d1 < d2) {
                $("#patentdateerror").html("Patent date always less than to today's date.");
                $("#patentdateerror").show();

                $("#user_patent_save").removeAttr("style");
                $("#user_patent_loader").hide();
                return false;
            }

            patent_formdata.append('edit_patent', $scope.edit_patent);
            patent_formdata.append('patent_file_old', $scope.patent_file_old);
            patent_formdata.append('patent_title', $('#patent_title').val());
            patent_formdata.append('patent_creator', $('#patent_creator').val());
            patent_formdata.append('patent_number', $('#patent_number').val());
            patent_formdata.append('patent_day', patent_day);
            patent_formdata.append('patent_month', patent_month);
            patent_formdata.append('patent_year', patent_year);
            patent_formdata.append('patent_office', $('#patent_office').val());
            patent_formdata.append('patent_url', $('#patent_url').val());
            patent_formdata.append('patent_desc', $('#patent_desc').val());

            $http.post(base_url + 'userprofile_page/save_user_patent', patent_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $("#user_patent_save").removeAttr("style");
                        $("#user_patent_loader").hide();
                        $("#patent_form")[0].reset();
                        $scope.reset_patent_form();
                        $scope.user_patent = result.user_patent;
                        $("#patent").modal('hide');
                    }
                    else
                    {
                        $("#user_patent_save").removeAttr("style");
                        $("#user_patent_loader").hide();
                        $("#patent_form")[0].reset();
                        $scope.reset_patent_form();
                        $("#patent").modal('hide');
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_patent();
                },500);
            });
        }
    };

    $scope.get_user_patent = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_patent',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_patent = result.data.user_patent;
                $scope.user_patent = user_patent;
            }
            $("#patent-loader").hide();
            $("#patent-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_patent();
            },500);
        });
    }
    $scope.get_user_patent();
    $scope.view_more_patent = 2;
    $scope.patent_view_more = function(){
        $scope.view_more_patent = $scope.user_patent.length;
        $("#view-more-patent").hide();
    };
    $scope.reset_patent_form = function(){        
        $scope.edit_patent = 0;
        $scope.patent_file_old = '';
        $("#patent").removeClass("edit-form-cus");
        $("#patent_day").html("");
        $("#patent_year").html("");
        $("#patent_doc_prev").remove();
        $("#delete_user_patent_modal").remove();
        $("#patent_form")[0].reset();
        patent_formdata = new FormData();
    };
    $scope.edit_user_patent = function(index){
        $scope.reset_patent_form();        
        $("#patent").addClass("edit-form-cus");
        var patent_arr = $scope.user_patent[index];
        $scope.edit_patent = patent_arr.id_patent;
        $("#patent_title").val(patent_arr.patent_title);
        $("#patent_creator").val(patent_arr.patent_creator);
        $("#patent_number").val(patent_arr.patent_number);        
        var patent_date_arr = patent_arr.patent_date.split("-");
        patent_day = patent_date_arr[2];
        patent_month = patent_date_arr[1];
        patent_year = patent_date_arr[0];
        $("#patent_month").val(patent_month);
        $scope.patent_date_fnc(patent_day,patent_month,patent_year);
        $("#patent_office").val(patent_arr.patent_office);
        $("#patent_url").val(patent_arr.patent_url);
        $("#patent_desc").val(patent_arr.patent_desc);

        var patent_file_name = patent_arr.patent_file;
        $scope.patent_file_old = patent_file_name;
        if(patent_file_name.trim() != "")
        {            
            var filename_arr = patent_file_name.split('.');

            $("#patent_doc_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="patent_doc_prev" class="screen-shot"><a href="'+user_patent_upload_url+patent_file_name+'" target="_blank"><img style="width: 100px;" src="'+user_patent_upload_url+patent_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="patent_doc_prev" class="screen-shot"><a class="file-preview-cus" href="'+user_patent_upload_url+patent_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#patent_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.patent_form.validate();
        },1000);

        var delete_btn = '<a id="delete_user_patent_modal" href="#" data-target="#delete-patent-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#user_patent_loader"));
        $compile(contentbtn)($scope);
        $("#patent").modal("show");
    };

    $scope.delete_user_patent = function(){
        $("#delete_user_patent").attr("style","pointer-events:none;display:none;");
        $("#user_patent_del_loader").show();
        $("#patent-delete-btn").hide();
        if($scope.edit_patent != 0)
        {
            var expdata = $.param({'patent_id': $scope.edit_patent});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/delete_user_patent',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_patent = result.user_patent;
                        $("#delete-patent-model").modal('hide');
                        $("#patent").modal('hide');
                        $("#delete_user_patent").removeAttr("style");
                        $("#user_patent_del_loader").hide();
                        $("#patent-delete-btn").show();                        
                        $scope.reset_patent_form();
                    }
                    else
                    {
                        $("#delete-patent-model").modal('hide');
                        $("#patent").modal('hide');
                        $("#delete_user_patent").removeAttr("style");
                        $("#user_patent_del_loader").hide();
                        $("#patent-delete-btn").show();
                        $scope.reset_patent_form();
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.delete_user_patent();
                },500);
            });
        }
    };
    //User Patent End

    //User Achieve & Award Start
    $scope.award_date_fnc = function(dob_day,dob_month,dob_year){
        $("#awarddateerror").hide();
        $("#awarddateerror").html('');
        var kcyear = document.getElementsByName("award_year")[0],
        kcmonth = document.getElementsByName("award_month")[0],
        kcday = document.getElementsByName("award_day")[0];                
        
        var d = new Date();
        var n = d.getFullYear();
        year_opt = "";
        for (var i = n; i >= 1950; i--) {
            if(dob_year == i)
            {
                year_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
            }
            else
            {                
                year_opt += "<option value='"+i+"'>"+i+"</option>";
            }            
        }
        $("#award_year").html(year_opt);
        
        function validate_date(dob_day,dob_month,dob_year) {
            var y = +kcyear.value;
            if(dob_month != ""){
                var m = dob_month;
            }
            else{
            var m = kcmonth.value;
            }

            if(dob_day != ""){
                var d = dob_day;
            }
            else{                
                var d = kcday.value;
            }
            if (m === "02"){
                var mlength = 28 + (!(y & 3) && ((y % 100) !== 0 || !(y & 15)));
            }
            else{
                var mlength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m - 1];
            }

            kcday.length = 0;
            var day_opt = "";
            for (var i = 1; i <= mlength; i++) {
                if(dob_day == i)
                {
                    day_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
                }
                else
                {                
                    day_opt += "<option value='"+i+"'>"+i+"</option>";
                }
            }
            $("#award_day").html(day_opt);
        }
        validate_date(dob_day,dob_month,dob_year);
    };
    $scope.award_error = function()
    {
        $("#awarddateerror").hide();
        $("#awarddateerror").html('');
    };

    var award_formdata = new FormData();
    $(document).on('change','#award_file', function(e){
        $("#award_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#award_file_error").html("File size must be less than 10MB.");
            $("#award_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                award_formdata.append('award_file', $('#award_file')[0].files[0]);
            }
            else {
                $("#award_file_error").html("Invalid file selected.");
                $("#award_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.award_validate = {
        rules: {            
            award_title: {
                required: true,
                maxlength: 200,
                minlength: 3
            },            
            award_org: {
                required: true,
                maxlength: 200,
                minlength: 3
            },           
            award_month: {
                required: true,
            },
            award_day: {
                required: true,
            },
            award_year: {
                required: true,
            },
            award_desc: {
                required: true,
                maxlength: 700,
                minlength: 10
            },
        },
        /*groups: {
            publication_date: "publication_year publication_month publication_day"
        },   */     
        messages: {
            award_title: {
                required: "Please enter achievements & awards title",
            },
            award_org: {
                required: "Please enter achievements & awards organization",
            },
            award_month: {
                required: "Please select achievements & awards date",
            },
            award_day: {
                required: "Please select achievements & awards date",
            },
            award_year: {
                required: "Please select achievements & awards date",
            },
            award_desc: {
                required: "Please enter achievements & awards description",
            },

        },
        errorPlacement: function (error, element) {
            /*if (element.attr("name") == "publication_month" || element.attr("name") == "publication_day" || element.attr("name") == "publication_year") {
                error.insertAfter("#publication_year");                
            } else {*/
                error.insertAfter(element);
            // }
        },
    };
    $scope.save_user_award = function(){
        if ($scope.award_form.validate()) {
            $("#user_award_loader").show();
            $("#user_award_save").attr("style","pointer-events:none;display:none;");

            var award_day = $("#award_day option:selected").val();
            var award_month = $("#award_month option:selected").val();
            var award_year = $("#award_year option:selected").val();

            var todaydate = new Date();
            var dd = todaydate.getDate();
            var mm = todaydate.getMonth() + 1;
            var yyyy = todaydate.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            var todaydate = yyyy + '/' + mm + '/' + dd;
            var value = award_year + '/' + award_month + '/' + award_day;

            var d1 = Date.parse(todaydate);
            var d2 = Date.parse(value);

            if (d1 < d2) {
                $("#awarddateerror").html("Achievements & Award date always less than to today's date.");
                $("#awarddateerror").show();

                $("#user_award_save").removeAttr("style");
                $("#user_award_loader").hide();
                return false;
            }

            award_formdata.append('edit_awards', $scope.edit_awards);
            award_formdata.append('awards_file_old', $scope.awards_file_old);
            award_formdata.append('award_title', $('#award_title').val());
            award_formdata.append('award_org', $('#award_org').val());            
            award_formdata.append('award_day', award_day);
            award_formdata.append('award_month', award_month);
            award_formdata.append('award_year', award_year);
            award_formdata.append('award_desc', $('#award_desc').val());

            $http.post(base_url + 'userprofile_page/save_user_award', award_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $("#user_award_save").removeAttr("style");
                        $("#user_award_loader").hide();
                        $("#award_form")[0].reset();
                        $scope.reset_awards_form();
                        $scope.user_award = result.user_award;
                        $("#Achiv-awards").modal('hide');
                    }
                    else
                    {
                        $("#user_award_save").removeAttr("style");
                        $("#user_award_loader").hide();
                        $("#award_form")[0].reset();
                        $("#Achiv-awards").modal('hide');
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_award();
                },500);
            });
        }
    };

    $scope.get_user_award = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_award',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_award = result.data.user_award;
                $scope.user_award = user_award;
            }
            $("#awards-loader").hide();
            $("#awards-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_award();
            },500);
        });
    }
    $scope.get_user_award();
    $scope.view_more_award = 2;
    $scope.award_view_more = function(){
        $scope.view_more_award = $scope.user_award.length;
        $("#view-more-award").hide();
    };

    $scope.reset_awards_form = function(){        
        $scope.edit_awards = 0;
        $scope.awards_file_old = '';
        $("#Achiv-awards").removeClass("edit-form-cus");
        $("#award_day").html("");
        $("#award_year").html("");
        $("#award_file_error").hide();        
        $("#award_file_prev").remove();
        $("#delete_user_award_modal").remove();
        $("#award_form")[0].reset();
        award_formdata = new FormData();
    };
    $scope.edit_user_award = function(index){
        $scope.reset_awards_form();
        $("#Achiv-awards").addClass("edit-form-cus");
        var award_arr = $scope.user_award[index];
        $scope.edit_awards = award_arr.id_award;
        $("#award_title").val(award_arr.award_title);
        $("#award_org").val(award_arr.award_org);        
        var award_date_arr = award_arr.award_date.split("-");
        award_day = award_date_arr[2];
        award_month = award_date_arr[1];
        award_year = award_date_arr[0];
        $("#award_month").val(award_month);
        $scope.award_date_fnc(award_day,award_month,award_year);

        $("#award_desc").val(award_arr.award_desc);

        var award_file_name = award_arr.award_file;
        $scope.awards_file_old = award_file_name;
        if(award_file_name.trim() != "")
        {            
            var filename_arr = award_file_name.split('.');
            $("#award_file_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="award_file_prev" class="screen-shot"><a href="'+user_award_upload_url+award_file_name+'" target="_blank"><img style="width: 100px;" src="'+user_award_upload_url+award_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="award_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+user_award_upload_url+award_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#award_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.award_form.validate();
        },1000);

        var delete_btn = '<a id="delete_user_award_modal" href="#" data-target="#delete-award-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#user_award_loader"));
        $compile(contentbtn)($scope);
        $("#Achiv-awards").modal("show");
    };

    $scope.delete_user_award = function(){
        $("#delete_user_award").attr("style","pointer-events:none;display:none;");
        $("#user_award_del_loader").show();
        $("#award-delete-btn").hide();
        if($scope.edit_awards != 0)
        {
            var expdata = $.param({'award_id': $scope.edit_awards});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/delete_user_award',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_award = result.user_award;
                        $("#delete-award-model").modal('hide');
                        $("#Achiv-awards").modal('hide');
                        $("#delete_user_award").removeAttr("style");
                        $("#user_award_del_loader").hide();
                        $("#award-delete-btn").show();                        
                        $scope.reset_awards_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                    else
                    {
                        $("#delete-award-model").modal('hide');
                        $("#Achiv-awards").modal('hide');
                        $("#delete_user_award").removeAttr("style");
                        $("#user_award_del_loader").hide();
                        $("#award-delete-btn").show();
                        $scope.reset_awards_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.delete_user_award();
                },500);
            });
        }
    };
    //User Achieve & Award End

    //Extracurricular Activity Start
    $scope.activity_start_year = function(){
        $("#activitydateerror").html("");
        $("#activitydateerror").hide();
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();
        if($scope.activity_s_year == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }
        var year_opt = "<option value=''>Year</option>";
        if($scope.activity_s_year != "" && $scope.activity_s_year != 0)
        {            
            for (var i = yyyy; i >= $scope.activity_s_year; i--) {            
                year_opt += "<option value='"+i+"'>"+i+"</option>";
            }
        }
        var elyear = $('#activity_e_year');
        elyear.html($compile(year_opt)($scope));

        var month_opt = "";
        for (var j = 0; j <= mm; j++) {            
            month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
        }
        var elmonth = $('#activity_s_month');
        elmonth.html($compile(month_opt)($scope));
    };

    $(document).on('change','#activity_e_year', function(e){
        $("#activitydateerror").html("");
        $("#activitydateerror").hide();
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();

        // console.log($(this).val());
        if($(this).val() == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }

        var month_opt = "";
        for (var j = 0; j <= mm; j++) {            
            month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
        }
        $('#activity_e_month').html(month_opt);
    });

    var activity_formdata = new FormData();
    $(document).on('change','#activity_file', function(e){
        $("#activity_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#activity_file_error").html("File size must be less than 10MB.");
            $("#activity_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                activity_formdata.append('activity_file', $('#activity_file')[0].files[0]);
            }
            else {
                $("#activity_file_error").html("Invalid file selected.");
                $("#activity_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.activity_validate = {
        rules: {            
            activity_participate: {
                required: true,
                maxlength: 200,
                minlength: 3
            },            
            activity_org: {
                required: true,
                maxlength: 200,
                minlength: 3
            },           
            activity_s_year: {
                required: true,
            },
            activity_s_month: {
                required: true,
            },
            activity_e_year: {
                required: true,
            },
            activity_e_month: {
                required: true,
            },
            activity_desc: {
                required: true,
                maxlength: 700,
                minlength: 10
            },
        },      
        messages: {
            activity_participate: {
                required: "Please enter Participated In",
            },
            activity_org: {
                required: "Please enter extracurricular activity organization",
            },
            activity_s_year: {
                required: "Please select extracurricular activity start date",
            },
            activity_s_month: {
                required: "Please select extracurricular activity start date",
            },
            activity_e_year: {
                required: "Please select extracurricular activity end date",
            },
            activity_e_month: {
                required: "Please select extracurricular activity end date",
            },
            activity_desc: {
                required: "Please enter achievements & awards description",
            },

        },
        errorPlacement: function (error, element) {
            /*if (element.attr("name") == "publication_month" || element.attr("name") == "publication_day" || element.attr("name") == "publication_year") {
                error.insertAfter("#publication_year");                
            } else {*/
                error.insertAfter(element);
            // }
        },
    };
    $scope.save_user_activity = function(){        
        $("#activitydateerror").html("");
        $("#activitydateerror").hide();
        if ($scope.activity_form.validate()) {
            $("#user_activity_loader").show();
            $("#user_activity_save").attr("style","pointer-events:none;display:none;");

            var activity_s_year = $("#activity_s_year option:selected").val();
            var activity_s_month = $("#activity_s_month option:selected").val();

            var activity_e_year = $("#activity_e_year option:selected").val();
            var activity_e_month = $("#activity_e_month option:selected").val();
            console.log(activity_s_year,activity_s_month,activity_e_year,activity_e_month);
            var activity_date_error = false;
            if(parseInt(activity_e_year) == parseInt(activity_s_year))
            {
                if(parseInt(activity_e_month) <= parseInt(activity_s_month))
                {
                    activity_date_error = true;
                }
            }

            if (activity_date_error == true) {                
                $("#activitydateerror").html("Extracurricular Activity date not same or start date is less than end date.");
                $("#activitydateerror").show();

                $("#user_activity_save").removeAttr("style");
                $("#user_activity_loader").hide();
                return false;
            }

            activity_formdata.append('edit_activity', $scope.edit_activity);
            activity_formdata.append('activity_file_old', $scope.activity_file_old);
            activity_formdata.append('activity_participate', $('#activity_participate').val());
            activity_formdata.append('activity_org', $('#activity_org').val());            
            activity_formdata.append('activity_s_year', activity_s_year);
            activity_formdata.append('activity_s_month', activity_s_month);
            activity_formdata.append('activity_e_year', activity_e_year);
            activity_formdata.append('activity_e_month', activity_e_month);
            activity_formdata.append('activity_desc', $('#activity_desc').val());

            $http.post(base_url + 'userprofile_page/save_user_activity', activity_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $("#user_activity_save").removeAttr("style");
                        $("#user_activity_loader").hide();
                        $("#activity_form")[0].reset();
                        $scope.reset_activity_form();
                        $scope.user_activity = result.user_activity;                        
                        $("#extra-activity").modal('hide');
                    }
                    else
                    {
                        $("#user_activity_save").removeAttr("style");
                        $("#user_activity_loader").hide();
                        $("#activity_form")[0].reset();
                        $scope.reset_activity_form();
                        $("#extra-activity").modal('hide');
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_activity();
                },500);
            });
        }
    };

    $scope.get_user_activity = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_activity',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_activity = result.data.user_activity;
                $scope.user_activity = user_activity;
            }
            $("#activity-loader").hide();
            $("#activity-body").show();

        }, function (error) {
            setTimeout(function(){
                $scope.get_user_activity();
            },500);
        });
    }
    $scope.get_user_activity();
    $scope.view_more_activity = 2;
    $scope.activity_view_more = function(){
        $scope.view_more_activity = $scope.user_activity.length;
        $("#view-more-activity").hide();
    };

    $scope.reset_activity_form = function(){
        $scope.edit_activity = 0;
        $("#extra-activity").removeClass("edit-form-cus");
        $scope.activity_file_old = "";
        $("#activity_s_month").html('');
        $("#activity_e_year").html('');
        $("#activity_e_month").html('');
        $("#activity_file_error").hide();        
        $("#activity_file_prev").remove();
        $("#delete_user_activity_modal").remove();
        $('#activity_file').val('');
        $("#activity_form")[0].reset();
        activity_formdata = new FormData();
    };
    $scope.edit_user_activity = function(index){
        $scope.reset_activity_form();
        $("#extra-activity").addClass("edit-form-cus");
        var activity_arr = $scope.user_activity[index];        
        $scope.edit_activity = activity_arr.id_extra_activity;
        $("#activity_participate").val(activity_arr.activity_participate);
        $("#activity_org").val(activity_arr.activity_org);
        var activity_start_date = activity_arr.activity_start_date.split('-');
        var activity_end_date = activity_arr.activity_end_date.split('-');        
        $scope.activity_s_year = activity_start_date[0];
        $scope.activity_start_year();
        // $scope.exp_s_month = activity_start_date[1];
        setTimeout(function(){
            $("#activity_s_month").val(activity_start_date[1]);
            $("#activity_e_year").val(activity_end_date[0]).change();
            // $scope.exp_e_year = exp_end_date[0];
        },500);
        setTimeout(function(){
            $("#activity_e_month").val(activity_end_date[1]);
        },500);        

        $("#activity_desc").val(activity_arr.activity_desc);

        var activity_file_name = activity_arr.activity_file;
        $scope.activity_file_old = activity_file_name;
        if(activity_file_name.trim() != "")
        {            
            var filename_arr = activity_file_name.split('.');
            $("#activity_file_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="activity_file_prev" class="screen-shot"><a href="'+user_activity_upload_url+activity_file_name+'" target="_blank"><img style="width: 100px;" src="'+user_activity_upload_url+activity_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="activity_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+user_activity_upload_url+activity_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#activity_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.activity_form.validate();
        },1000);
        var delete_btn = '<a id="delete_user_activity_modal" href="#" data-target="#delete-activity-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#user_activity_loader"));
        $compile(contentbtn)($scope);
        $("#extra-activity").modal("show");
    };

    $scope.delete_user_activity = function(){
        $("#delete_user_activity").attr("style","pointer-events:none;display:none;");
        $("#user_activity_del_loader").show();
        $("#activity-delete-btn").hide();
        if($scope.edit_activity != 0)
        {
            var expdata = $.param({'activity_id': $scope.edit_activity});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/delete_user_activity',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_activity = result.user_activity;
                        $("#delete-activity-model").modal('hide');
                        $("#extra-activity").modal('hide');
                        $("#delete_user_activity").removeAttr("style");
                        $("#user_activity_del_loader").hide();
                        $("#activity-delete-btn").show();                        
                        $scope.reset_activity_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                    else
                    {
                        $("#delete-activity-model").modal('hide');
                        $("#extra-activity").modal('hide');
                        $("#delete_user_activity").removeAttr("style");
                        $("#user_activity_del_loader").hide();
                        $("#activity-delete-btn").show();
                        $scope.reset_activity_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.delete_user_activity();
                },500);
            });
        }
    };
    //Extracurricular Activity End

    //Additional Course Start
    $scope.addicourse_start_year = function(){
        $("#addicoursedateerror").html("");
        $("#addicoursedateerror").hide();
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();
        if($scope.addicourse_s_year == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }
        var year_opt = "<option value=''>Year</option>";
        if($scope.addicourse_s_year != "" && $scope.addicourse_s_year != 0)
        {            
            for (var i = yyyy; i >= $scope.addicourse_s_year; i--) {            
                year_opt += "<option value='"+i+"'>"+i+"</option>";
            }
        }
        var elyear = $('#addicourse_e_year');
        elyear.html($compile(year_opt)($scope));

        var month_opt = "";
        for (var j = 0; j <= mm; j++) {            
            month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
        }
        var elmonth = $('#addicourse_s_month');
        elmonth.html($compile(month_opt)($scope));
    };

    $(document).on('change','#addicourse_e_year', function(e){
        $("#addicoursedateerror").html("");
        $("#addicoursedateerror").hide();
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();

        // console.log($(this).val());
        if($(this).val() == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }

        var month_opt = "";
        for (var j = 0; j <= mm; j++) {            
            month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
        }
        $('#addicourse_e_month').html(month_opt);
    });

    var addicourse_formdata = new FormData();
    $(document).on('change','#addicourse_file', function(e){
        $("#addicourse_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#addicourse_file_error").html("File size must be less than 10MB.");
            $("#addicourse_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                addicourse_formdata.append('addicourse_file', $('#addicourse_file')[0].files[0]);
            }
            else {
                $("#addicourse_file_error").html("Invalid file selected.");
                $("#addicourse_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.addicourse_validate = {
        rules: {            
            addicourse_name: {
                required: true,
                maxlength: 200,
                minlength: 3
            },            
            addicourse_org: {
                required: true,
                maxlength: 200,
                minlength: 3
            },           
            addicourse_s_year: {
                required: true,
            },
            addicourse_s_month: {
                required: true,
            },
            addicourse_e_year: {
                required: true,
            },
            addicourse_e_month: {
                required: true,
            },
            addicourse_url: {
                url: true,
            },
        },      
        messages: {
            addicourse_name: {
                required: "Please enter additional course name",
            },
            addicourse_org: {
                required: "Please enter additional course organization",
            },
            addicourse_s_year: {
                required: "Please select additional course start date",
            },
            addicourse_s_month: {
                required: "Please select additional course start date",
            },
            addicourse_e_year: {
                required: "Please select additional course end date",
            },
            addicourse_e_month: {
                required: "Please select additional course end date",
            },
            addicourse_url: {
                url: "URL must start with http:// or https://",
            },

        },
        errorPlacement: function (error, element) {
            /*if (element.attr("name") == "publication_month" || element.attr("name") == "publication_day" || element.attr("name") == "publication_year") {
                error.insertAfter("#publication_year");                
            } else {*/
                error.insertAfter(element);
            // }
        },
    };
    $scope.save_user_addicourse = function(){
        $("#addicoursedateerror").html("");
        $("#addicoursedateerror").hide();
        if ($scope.addicourse_form.validate()) {
            $("#user_addicourse_loader").show();
            $("#user_addicourse_save").attr("style","pointer-events:none;display:none;");

            var addicourse_s_year = $("#addicourse_s_year option:selected").val();
            var addicourse_s_month = $("#addicourse_s_month option:selected").val();

            var addicourse_e_year = $("#addicourse_e_year option:selected").val();
            var addicourse_e_month = $("#addicourse_e_month option:selected").val();
            var activity_date_error = false;
            if(parseInt(addicourse_e_year) == parseInt(addicourse_s_year))
            {
                if(parseInt(addicourse_e_month) <= parseInt(addicourse_s_month))
                {
                    activity_date_error = true;
                }
            }

            if (activity_date_error == true) {                
                $("#addicoursedateerror").html("Additional Course date not same or start date is less than end date.");
                $("#addicoursedateerror").show();

                $("#user_addicourse_save").removeAttr("style");
                $("#user_addicourse_loader").hide();
                return false;
            }


            addicourse_formdata.append('edit_addicourse', $scope.edit_addicourse);
            addicourse_formdata.append('addicourse_file_old', $scope.addicourse_file_old);
            addicourse_formdata.append('addicourse_name', $('#addicourse_name').val());
            addicourse_formdata.append('addicourse_org', $('#addicourse_org').val());            
            addicourse_formdata.append('addicourse_s_year', addicourse_s_year);
            addicourse_formdata.append('addicourse_s_month', addicourse_s_month);
            addicourse_formdata.append('addicourse_e_year', addicourse_e_year);
            addicourse_formdata.append('addicourse_e_month', addicourse_e_month);
            addicourse_formdata.append('addicourse_url', $('#addicourse_url').val());

            $http.post(base_url + 'userprofile_page/save_user_addicourse', addicourse_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $("#user_addicourse_save").removeAttr("style");
                        $("#user_addicourse_loader").hide();
                        $("#addicourse_form")[0].reset();
                        $scope.user_addicourse = result.user_addicourse;
                        $scope.reset_addicourse_form();
                        $("#additional-course").modal('hide');
                    }
                    else
                    {
                        $("#user_addicourse_save").removeAttr("style");
                        $("#user_addicourse_loader").hide();
                        $("#addicourse_form")[0].reset();
                        $("#additional-course").modal('hide');
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_addicourse();
                },500);
            });
        }
    };

    $scope.get_user_addicourse = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_addicourse',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_addicourse = result.data.user_addicourse;
                $scope.user_addicourse = user_addicourse;
            }
            $("#addicourse-loader").hide();
            $("#addicourse-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_addicourse();
            },500);
        });
    }
    $scope.get_user_addicourse();
    $scope.view_more_ac = 2;
    $scope.ac_view_more = function(){
        $scope.view_more_ac = $scope.user_addicourse.length;
        $("#view-more-addicourse").hide();
    };

    $scope.reset_addicourse_form = function(){
        $scope.edit_addicourse = 0;
        $scope.addicourse_file_old = "";
        $("#additional-course").removeClass("edit-form-cus");
        $("#addicourse_s_month").html('');
        $("#addicourse_e_year").html('');
        $("#addicourse_e_month").html('');
        $("#addicourse_file_error").hide();        
        $("#addicourse_file_prev").remove();
        $("#delete_user_addicourse_modal").remove();
        $('#addicourse_file').val('');
        $("#addicourse_form")[0].reset();
        addicourse_formdata = new FormData();
    };
    $scope.edit_user_addicourse = function(index){
        $scope.reset_addicourse_form();
        $("#additional-course").addClass("edit-form-cus");
        var addicourse_arr = $scope.user_addicourse[index];        
        $scope.edit_addicourse = addicourse_arr.id_addicourse;
        $("#addicourse_name").val(addicourse_arr.addicourse_name);
        $("#addicourse_org").val(addicourse_arr.addicourse_org);
        var addicourse_start_date = addicourse_arr.addicourse_start_date.split('-');
        var addicourse_end_date = addicourse_arr.addicourse_end_date.split('-');        
        $scope.addicourse_s_year = addicourse_start_date[0];
        $scope.addicourse_start_year();
        // $scope.exp_s_month = addicourse_start_date[1];
        setTimeout(function(){
            $("#addicourse_s_month").val(addicourse_start_date[1]);
            $("#addicourse_e_year").val(addicourse_end_date[0]).change();
            // $scope.exp_e_year = exp_end_date[0];
        },500);
        setTimeout(function(){
            $("#addicourse_e_month").val(addicourse_end_date[1]);
        },500);        

        $("#addicourse_url").val(addicourse_arr.addicourse_url);

        var addicourse_file_name = addicourse_arr.addicourse_file;
        $scope.addicourse_file_old = addicourse_file_name;
        if(addicourse_file_name.trim() != "")
        {            
            var filename_arr = addicourse_file_name.split('.');
            $("#addicourse_file_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="addicourse_file_prev" class="screen-shot"><a href="'+user_addicourse_upload_url+addicourse_file_name+'" target="_blank"><img style="width: 100px;" src="'+user_addicourse_upload_url+addicourse_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="addicourse_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+user_addicourse_upload_url+addicourse_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#addicourse_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.addicourse_form.validate();
        },1000); 
        var delete_btn = '<a id="delete_user_addicourse_modal" href="#" data-target="#delete-addicourse-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#user_addicourse_loader"));
        $compile(contentbtn)($scope);
        $("#additional-course").modal("show");
    };

    $scope.delete_user_addicourse = function(){
        $("#delete_user_addicourse").attr("style","pointer-events:none;display:none;");
        $("#user_addicourse_del_loader").show();
        $("#addicourse-delete-btn").hide();
        if($scope.edit_addicourse != 0)
        {
            var expdata = $.param({'addicourse_id': $scope.edit_addicourse});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/delete_user_addicourse',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_addicourse = result.user_addicourse;                        
                        $("#delete-addicourse-model").modal('hide');
                        $("#additional-course").modal('hide');
                        $("#delete_user_addicourse").removeAttr("style");
                        $("#user_addicourse_del_loader").hide();
                        $("#addicourse-delete-btn").show();                        
                        $scope.reset_addicourse_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                    else
                    {
                        $("#delete-addicourse-model").modal('hide');
                        $("#additional-course").modal('hide');
                        $("#delete_user_addicourse").removeAttr("style");
                        $("#user_addicourse_del_loader").hide();
                        $("#addicourse-delete-btn").show();
                        $scope.reset_addicourse_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.delete_user_addicourse();
                },500);
            });
        }
    };
    //Additional Course End

    //Experience Start
    /*$scope.load_jobtitle = [];
    $scope.loadJobtitle = function ($query) {
        return $http.get(base_url + 'user_post/get_jobtitle', {cache: true}).then(function (response) {
            var load_jobtitle = response.data;
            return load_jobtitle.filter(function (title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };*/

    $scope.exp_job_title_list = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchJobTitleStart',
            data: 'q=' + $scope.exp_designation,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            data = success.data;
            $scope.titleSearchResult = data;
        }, function (error) {
            setTimeout(function(){
                $scope.exp_job_title_list();
            },500);
        });
    };

    $scope.get_country = function () {
        $http({
            method: 'GET',
            url: base_url + 'userprofile_page/get_country',
            headers: {'Content-Type': 'application/json'},
        }).then(function (data) {
            $scope.exp_country_list = data.data;
        }, function (error) {
            setTimeout(function(){
                $scope.get_country();
            },500);
        });
    };
    $scope.get_country();

    $scope.exp_country_change = function() {
        $("#exp_state").attr("disabled","disabled");
        $("#exp_state_loader").show();
        var counrtydata = $.param({'country_id': $scope.exp_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#exp_state").removeAttr("disabled");
            $("#exp_city").attr("disabled","disabled");
            $("#exp_state_loader").hide();
            $scope.exp_state_list = data.data;
            $scope.exp_city_list = [];
        }, function (error) {
            setTimeout(function(){
                $scope.exp_country_change();
            },500);
        });
    }

    $scope.exp_state_change = function() {
        if($scope.exp_state != "" && $scope.exp_state != 0 && $scope.exp_state != null)
        {
            $("#exp_city").attr("disabled","disabled");
            $("#exp_city_loader").show();
            var statedata = $.param({'state_id': $scope.exp_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#exp_city").removeAttr("disabled");
                $("#exp_city_loader").hide();
                $scope.exp_city_list = data.data;
            }, function (error) {
                setTimeout(function(){
                    $scope.exp_state_change();
                },500);
            });
        }
    }

    $scope.other_field_fnc = function()
    {
        if($scope.exp_field == 0 && $scope.exp_field != "")
        {
            $("#exp_other_field_div").show();
        }
        else
        {
            $("#exp_other_field_div").hide();
        }
    }

    $scope.exp_start_year = function(){
        $("#expdateerror").html("");
        $("#expdateerror").hide();
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();
        if($scope.exp_s_year == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }
        var year_opt = "<option value=''>Year</option>";
        for (var i = yyyy; i >= $scope.exp_s_year; i--) {            
            year_opt += "<option value='"+i+"'>"+i+"</option>";
        }
        // $('#exp_e_year').html(year_opt);
        // var $elyear = $('#exp_e_year').html(year_opt);
        // $compile($elyear)($scope);

        var elyear = $('#exp_e_year');
        elyear.html($compile(year_opt)($scope));

        var month_opt = "";
        for (var j = 0; j <= mm; j++) {            
            month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
        }
        // $('#exp_s_month').html(month_opt);
        // var $elmonth = $('#exp_s_month').html(month_opt);
        // $compile($elmonth)($scope);

        var elmonth = $('#exp_s_month');
        elmonth.html($compile(month_opt)($scope));
    };
    $(document).on('change','#exp_e_year', function(e){
        $("#expdateerror").html("");
        $("#expdateerror").hide();
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();

        // console.log($(this).val());
        if($(this).val() == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }

        var month_opt = "";
        for (var j = 0; j <= mm; j++) {            
            month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
        }
        $('#exp_e_month').html(month_opt);
    });

    $scope.exp_designation_fnc = function(){
        // $("#exp_designation input").removeClass("error");
        $("#exp_designation .tags").removeAttr("style");
        $("#exp_designation_err").attr("style","display:none;");
    };

    $scope.experience_validate = {
        rules: {            
            exp_company_name: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
            exp_designation: {
                required: true,
            },
            exp_company_website: {
                url: true,
            },
            exp_field: {
                required: true,
            },
            exp_other_field: {
                required: {
                    depends: function(element) {
                        return $("#exp_field option:selected").val() == 0 ? true : false;
                    }
                },
            },
            exp_country: {
                required: true,
            },
            exp_state: {
                required: true,
            },
            exp_city: {
                required: true,
            },
            exp_s_year: {
                required: true,
            },
            exp_s_month: {
                required: true,
            },
            exp_e_year: {
                required: {
                    depends: function(element) {
                        return $("#exp_isworking").is(':checked') ? false : true;
                    }
                },
            },
            exp_e_month: {
                required: {
                    depends: function(element) {
                        return $("#exp_isworking").is(':checked') ? false : true;
                    }
                },
            },
            exp_desc: {
                required: true,
            },
            
        },      
        messages: {
            exp_company_name: {
                required: "Please enter company name",
            },
            exp_company_website: {
                url: "URL must start with http:// or https://",
            },
            exp_field: {
                required: "Please select field",
            },
            exp_country: {
                required: "Please select county",
            },
            exp_state: {
                required: "Please select state",
            },
            exp_city: {
                required: "Please select city",
            },
            exp_s_year: {
                required: "Please select experience start date",
            },
            exp_s_month: {
                required: "Please select experience start date",
            },
            exp_e_year: {
                required: "Please select experience end date",
            },
            exp_e_month: {
                required: "Please select experience end date",
            },
            exp_desc: {
                required: "Please enter experience description",
            },
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
    };

    var exp_formdata = new FormData();
    $(document).on('change','#exp_file', function(e){
        $("#exp_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#exp_file_error").html("File size must be less than 10MB.");
            $("#exp_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                exp_formdata.append('exp_file', $('#exp_file')[0].files[0]);
            }
            else {
                $("#exp_file_error").html("Invalid file selected.");
                $("#exp_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.validate_desig = function(){        
        if($scope.exp_designation == "" || $scope.exp_designation == undefined)
        {
            $("#exp_designation .tags").attr("style","border:1px solid #ff0000;");
            setTimeout(function(){
                $("#exp_designation_err").attr("style","display:block;");            
            },100);
            return false;
        }
        else
        {
            return true;
        }
    };

    $scope.save_user_exp = function(){
        var desig = $scope.validate_desig();
        $("#expdateerror").html("");
        $("#expdateerror").hide();
        if ($scope.experience_form.validate() && desig) {
            $("#user_exp_loader").show();
            $("#save_user_exp").attr("style","pointer-events:none;display:none;");

            var exp_s_year = $("#exp_s_year option:selected").val();
            var exp_s_month = $("#exp_s_month option:selected").val();

            var exp_e_year = $("#exp_e_year option:selected").val();
            var exp_e_month = $("#exp_e_month option:selected").val();
            var exp_date_error = false;            
            if(parseInt(exp_e_year) == parseInt(exp_s_year))
            {
                if(parseInt(exp_e_month) <= parseInt(exp_s_month))
                {
                    exp_date_error = true;
                }
            }
            if($("#exp_isworking:checked").length == 1)
            {
                exp_date_error = false;
            }
            if (exp_date_error == true) {                
                $("#expdateerror").html("Experience date not same or start date is less than end date.");
                $("#expdateerror").show();
                $("#save_user_exp").removeAttr("style");
                $("#user_exp_loader").hide();
                return false;
            }

            exp_formdata.append('edit_exp', $scope.edit_exp);
            exp_formdata.append('exp_file_old', $scope.exp_file_old);
            exp_formdata.append('exp_company_name', $('#exp_company_name').val());
            exp_formdata.append('exp_designation', $('#exp_designation').val());
            exp_formdata.append('exp_company_website', $('#exp_company_website').val());
            exp_formdata.append('exp_field', $('#exp_field option:selected').val());
            exp_formdata.append('exp_other_field', $('#exp_other_field').val());
            exp_formdata.append('exp_country', $('#exp_country option:selected').val());
            exp_formdata.append('exp_state', $('#exp_state option:selected').val());
            exp_formdata.append('exp_city', $('#exp_city option:selected').val());
            exp_formdata.append('exp_s_year', exp_s_year);
            exp_formdata.append('exp_s_month', exp_s_month);
            exp_formdata.append('exp_e_year', exp_e_year);
            exp_formdata.append('exp_e_month', exp_e_month);
            exp_formdata.append('exp_isworking', $("#exp_isworking:checked").length);
            exp_formdata.append('exp_desc', $('#exp_desc').val());

            $http.post(base_url + 'userprofile_page/save_user_experience', exp_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        user_experience = result.user_experience;
                        $scope.user_experience = user_experience;
                        $scope.exp_years = result.exp_years;
                        $scope.exp_months = result.exp_months;
                        $("#save_user_exp").removeAttr("style");
                        $("#user_exp_loader").hide();
                        $scope.reset_exp_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();
                        $("#experience").modal('hide');
                    }
                    else
                    {
                        $("#save_user_exp").removeAttr("style");
                        $("#user_exp_loader").hide();
                        $scope.reset_exp_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();
                        $("#experience").modal('hide');
                    }
                    var profile_progress = result.profile_progress;
                    var count_profile_value = profile_progress.user_process_value;
                    var count_profile = profile_progress.user_process;
                    $scope.progress_status = profile_progress.progress_status;
                    $scope.set_progress(count_profile_value,count_profile);
                    $scope.get_all_counter();
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_exp();
                },500);
            });
        }
    };
    $scope.reset_exp_form = function(){
        $("#experience").removeClass("edit-form-cus");
        $scope.exp_designation_fnc();
        $scope.edit_exp = 0;
        $scope.exp_file_old = '';
        $scope.exp_state_list = '';
        $scope.exp_designation = [];
        $scope.exp_company_website = '';
        $scope.exp_field = '';
        $scope.exp_other_field = '';
        $("#exp_other_field_div").hide(); 
        // $scope.exp_country = '';
        $scope.exp_state_list = [];
        $scope.exp_city_list = [];
        $scope.exp_s_year = '';
        $("#exp_s_month").html('');
        $("#exp_e_year").html('');
        $("#exp_e_month").html('');
        
        // $scope.exp_e_year = '';
        // $scope.exp_e_month = '';
        $scope.exp_isworking = '';
        $("#delete_user_exp_modal").remove();
        $("#exp_doc_prev").remove();
        $("#experience_form")[0].reset();
    };
    $scope.get_user_experience = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_experience',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_experience = result.data.user_experience;
                $scope.user_experience = user_experience;
                $scope.exp_years = result.data.exp_years;
                $scope.exp_months = result.data.exp_months;
            }
            $("#exp-loader").hide();
            $("#exp-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_experience();
            },500);
        });
    }
    $scope.get_user_experience();
    $scope.view_more_exp = 2;
    $scope.exp_view_more = function(){
        $scope.view_more_exp = $scope.user_experience.length;
        $("#view-more-exp").hide();
    };
    
    $scope.edit_user_exp = function(index){

        $scope.reset_exp_form();
        $("#experience").addClass("edit-form-cus");
        // $scope.exp_city_list = [];
        $scope.edit_exp = $scope.user_experience[index].id_experience;        
        $("#edit_exp").val($scope.user_experience[index].id_experience);
        // $scope.exp_company_name = $scope.user_experience[index].exp_company_name;
        var exp_company_name_txt = $scope.user_experience[index].exp_company_name;
        $("#exp_company_name").val(exp_company_name_txt);
        
        $scope.exp_designation = $scope.user_experience[index].designation;
        $scope.exp_company_website = $scope.user_experience[index].exp_company_website;
        $scope.exp_field = $scope.user_experience[index].exp_field;
        if($scope.exp_field == 0)
        {
            $scope.exp_other_field = $scope.user_experience[index].exp_other_field;
            $("#exp_other_field_div").show();
        }
        else
        {
            $scope.exp_other_field = "";
            $("#exp_other_field_div").hide();   
        }
        $scope.exp_country = $scope.user_experience[index].exp_country;
        $("#exp_country").val($scope.user_experience[index].exp_country);
        // $scope.exp_country_change();
        var counrtydata = $.param({'country_id': $scope.exp_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#exp_state").removeAttr("disabled");
            $("#exp_city").attr("disabled","disabled");
            $("#exp_state_loader").hide();
            $scope.exp_state_list = data.data;
            $scope.exp_city_list = [];
            $scope.exp_state = $scope.user_experience[index].exp_state;

            $("#exp_city").attr("disabled","disabled");
            $("#exp_city_loader").show();
            var statedata = $.param({'state_id': $scope.exp_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#exp_city").removeAttr("disabled");
                $("#exp_city_loader").hide();
                $scope.exp_city_list = data.data;
                $scope.exp_city = $scope.user_experience[index].exp_city;
            });        
        }, function (error) {
            setTimeout(function(){
                $scope.edit_user_exp();
            },500);
        });
        // $scope.exp_state_change();        

        var exp_start_date = $scope.user_experience[index].exp_start_date.split('-');
        var exp_end_date = $scope.user_experience[index].exp_end_date.split('-');        
        $scope.exp_s_year = exp_start_date[0];
        $scope.exp_start_year();
        // $scope.exp_s_month = exp_start_date[1];
        setTimeout(function(){
            $("#exp_s_month").val(exp_start_date[1]);
            $("#exp_e_year").val(exp_end_date[0]).change();
            // $scope.exp_e_year = exp_end_date[0];
        },100);
        setTimeout(function(){
            $("#exp_e_month").val(exp_end_date[1]);
        },500);
        $scope.exp_isworking = (parseInt($scope.user_experience[index].exp_isworking) == 1 ? true : false);
        
        // $scope.exp_desc = $scope.user_experience[index].exp_desc;
        var exp_desc_txt = $scope.user_experience[index].exp_desc;
        $("#exp_desc").val(exp_desc_txt);
        
        var exp_file_name = $scope.user_experience[index].exp_file;
        $scope.exp_file_old = exp_file_name;
        if(exp_file_name.trim() != "")
        {
            var filename_arr = exp_file_name.split('.');
            // console.log(filename_arr);
            //console.log(filename_arr[filename_arr.length - 1]);
            $("#exp_doc_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="exp_doc_prev" class="screen-shot"><a href="'+user_experience_upload_url+exp_file_name+'" target="_blank"><img style="width: 100px;" src="'+user_experience_upload_url+exp_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="exp_doc_prev" class="screen-shot"><a class="file-preview-cus" href="'+user_experience_upload_url+exp_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#exp_file_error"));
            $compile(contentTr)($scope);
            setTimeout(function(){  
                $scope.experience_form.validate();
            },1000);
        }

        var delete_btn = '<a id="delete_user_exp_modal" href="#" data-target="#delete-exp-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#user_exp_loader"));
        $compile(contentbtn)($scope);
        $("#experience").modal("show");
    };

    $scope.delete_user_exp = function(){
        $("#delete_user_exp").attr("style","pointer-events:none;display:none;");
        $("#user_exp_del_loader").show();
        $("#exp-delete-btn").hide();
        if($scope.edit_exp != 0)
        {
            var expdata = $.param({'exp_id': $scope.edit_exp});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/delete_user_experience',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        user_experience = result.user_experience;
                        $scope.user_experience = user_experience;
                        $scope.exp_years = result.exp_years;
                        $scope.exp_months = result.exp_months;
                        $("#delete-exp-model").modal('hide');
                        $("#experience").modal('hide');
                        $("#delete_user_exp").removeAttr("style");
                        $("#user_exp_del_loader").hide();
                        $("#exp-delete-btn").show();
                        $scope.reset_exp_form();
                        var profile_progress = result.profile_progress;
                        var count_profile_value = profile_progress.user_process_value;
                        var count_profile = profile_progress.user_process;
                        $scope.progress_status = profile_progress.progress_status;
                        $scope.set_progress(count_profile_value,count_profile);
                        $scope.get_all_counter();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                    else
                    {
                        $("#delete-exp-model").modal('hide');
                        $("#experience").modal('hide');
                        $("#delete_user_exp").removeAttr("style");
                        $("#user_exp_del_loader").hide();
                        $("#exp-delete-btn").show();
                        $scope.reset_exp_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.delete_user_exp();
                },500);
            });
        }
    };
    
    //Experience End

    //Project Start
    $scope.other_project_field_fnc = function()
    {
        if($scope.project_field == 0 && $scope.project_field != "")
        {
            $("#proj_other_field_div").show();
        }
        else
        {
            $("#proj_other_field_div").hide();
        }
    }

    $scope.project_start_year = function(){        
        $("#projdateerror").html("");
        $("#projdateerror").hide();
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();
        if($scope.project_s_year == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }
        var year_opt = "<option value=''>Year</option>";
        for (var i = yyyy; i >= $scope.project_s_year; i--) {            
            year_opt += "<option value='"+i+"'>"+i+"</option>";
        }
        var elyear = $('#project_e_year');
        elyear.html($compile(year_opt)($scope));

        var month_opt = "";
        for (var j = 0; j <= mm; j++) {            
            month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
        }
        var elmonth = $('#project_s_month');
        elmonth.html($compile(month_opt)($scope));
    };
    $(document).on('change','#project_e_year', function(e){
        $("#projdateerror").html("");
        $("#projdateerror").hide();
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();

        // console.log($(this).val());
        if($(this).val() == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }

        var month_opt = "";
        for (var j = 0; j <= mm; j++) {            
            month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
        }
        $('#project_e_month').html(month_opt);
    });

    $(document).on('keydown','#project_team',function (e) {
        /*var key = window.e ? e.keyCode : e.which;
        if (e.keyCode === 8 || e.keyCode === 46) {
            return true;
        } else if ( key < 48 || key > 57 ) {
            return false;
        } else {
            return true;
        }*/
        // Allow: backspace, delete, tab, escape, enter         
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: Ctrl/cmd+r
            (e.keyCode == 82 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $scope.project_validate = {
        rules: {            
            project_title: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
            project_team: {
                required: true,
                maxlength: 3,
                number: true
            },
            project_role: {
                required: true,
                maxlength: 200,
            },
            project_field: {
                required: true,
            },
            project_other_field: {
                required: {
                    depends: function(element) {
                        return $("#project_field option:selected").val() == 0 ? true : false;
                    }
                },
                maxlength: 200,
            },
            project_url: {
                url: true,
                maxlength: 200,
            },
            project_s_year: {
                required: true,
            },
            project_s_month: {
                required: true,
            },
            project_e_year: {
                required: true,
            },
            project_e_month: {
                required: true,
            },
            project_desc: {
                required: true,
                minlength: 50,
                maxlength: 700,
            },
            
        },      
        messages: {
            project_title: {
                required: "Please enter project title",
            },
            project_team: {
                required: "Please enter project team size",
            },
            project_role: {
                required: "Please enter your role in project",
            },
            project_field: {
                required: "Please select field",
            },
            project_url: {
                url: "URL must start with http:// or https://",
            },
            project_s_year: {
                required: "Please select project start date",
            },
            project_s_month: {
                required: "Please select project start date",
            },
            project_e_year: {
                required: "Please select project end date",
            },
            project_e_month: {
                required: "Please select project end date",
            },
            project_desc: {
                required: "Please enter project description",
            },
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
    };

    $scope.project_skills_fnc = function(){
        // $("#exp_designation input").removeClass("error");
        $("#project_skill_list .tags").removeAttr("style");
        $("#project_skill_err").attr("style","display:none;");
    };

    var project_formdata = new FormData();
    $(document).on('change','#project_file', function(e){
        $("#project_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#project_file_error").html("File size must be less than 10MB.");
            $("#project_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                project_formdata.append('project_file', $('#project_file')[0].files[0]);
            }
            else {
                $("#project_file_error").html("Invalid file selected.");
                $("#project_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.validate_proj_skills = function(){        
        if($scope.project_skill_list == "" || $scope.project_skill_list == undefined)
        {
            $("#project_skill_list .tags").attr("style","border:1px solid #ff0000;");
            setTimeout(function(){
                $("#project_skill_err").attr("style","display:block;");            
            },100);
            return false;
        }
        else
        {
            return true;
        }
    };

    $scope.save_user_project = function(){
        var proj_skills = $scope.validate_proj_skills();
        $("#projdateerror").html("");
        $("#projdateerror").hide();
        if ($scope.project_form.validate() && proj_skills) {
            $("#prject_loader").show();
            $("#project_save").attr("style","pointer-events:none;display:none;");

            var project_s_year = $("#project_s_year option:selected").val();
            var project_s_month = $("#project_s_month option:selected").val();

            var project_e_year = $("#project_e_year option:selected").val();
            var project_e_month = $("#project_e_month option:selected").val();
            var project_date_error = false;
            if(parseInt(project_e_year) == parseInt(project_s_year))
            {
                if(parseInt(project_e_month) <= parseInt(project_s_month))
                {
                    project_date_error = true;
                }
            }

            if (project_date_error == true) {                
                $("#projdateerror").html("Project date not same or start date is less than end date.");
                $("#projdateerror").show();
                $("#project_save").removeAttr("style");
                $("#prject_loader").hide();
                return false;
            }

            project_formdata.append('edit_project', $scope.edit_project);
            project_formdata.append('project_file_old', $scope.project_file_old);
            project_formdata.append('project_title', $('#project_title').val());
            project_formdata.append('project_team', $('#project_team').val());
            project_formdata.append('project_role', $('#project_role').val());
            project_formdata.append('project_skill_list', JSON.stringify($scope.project_skill_list));
            project_formdata.append('project_field', $('#project_field option:selected').val());
            project_formdata.append('project_other_field', $('#project_other_field').val());
            project_formdata.append('project_url', $('#project_url').val());
            project_formdata.append('project_partner', JSON.stringify($scope.project_partner));
            project_formdata.append('project_s_year', project_s_year);
            project_formdata.append('project_s_month', project_s_month);
            project_formdata.append('project_e_year', project_e_year);
            project_formdata.append('project_e_month', project_e_month);
            project_formdata.append('project_desc', $('#project_desc').val());

            $http.post(base_url + 'userprofile_page/save_user_project', project_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == 1)
                    {
                        $("#project_save").removeAttr("style");
                        $("#prject_loader").hide();
                        $scope.project_skill_list = [];
                        $scope.project_partner = [];
                        $("#project_form")[0].reset();
                        $scope.user_projects = result.user_projects;
                        $scope.reset_project_form();
                        $("#dtl-project").modal('hide');
                    }
                    else
                    {
                        // $("#project_save").removeAttr("style");
                        // $("#prject_loader").hide();
                        // $("#project_form")[0].reset();
                        $scope.reset_project_form();
                        $("#dtl-project").modal('hide');
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_project();
                },500);
            });
        }
    };

    $scope.get_user_project = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_project',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_projects = result.data.user_projects;
                $scope.user_projects = user_projects;
            }
            $("#project-loader").hide();
            $("#project-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_project();
            },500);
        });
    }
    $scope.get_user_project();
    $scope.view_more_proj = 2;
    $scope.proj_view_more = function(){
        $scope.view_more_proj = $scope.user_projects.length;
        $("#view-more-proj").hide();
    };

    $scope.reset_project_form = function(){
        $("#dtl-project").removeClass("edit-form-cus");
        $scope.edit_project = 0;
        $scope.project_file_old = "";
        $("#other_project").hide();
        $scope.project_skill_list = [];
        $("#project_field").val('');
        $scope.project_partner = [];
        
        $scope.project_s_year = "";
        $("#project_s_month").html('');
        $("#project_e_year").html('');
        $("#project_e_month").html('');
        $("#project_file_error").hide();        
        $("#project_file_prev").remove();
        $('#project_file').val('');
        $("#project_form")[0].reset();
        $("#delete_user_project_modal").remove();
        project_formdata = new FormData();
    };
    $scope.edit_user_project = function(index){
        $scope.reset_project_form();
        var projects_arr = $scope.user_projects[index];
        $("#dtl-project").addClass("edit-form-cus");
        $scope.edit_project = projects_arr.id_projects;
        $("#project_title").val(projects_arr.project_title);
        $("#project_team").val(projects_arr.project_team);
        $("#project_role").val(projects_arr.project_role);

        var project_skill = "";
        if(projects_arr.project_skills_txt.trim() != "")
        {
            var project_skill = projects_arr.project_skills_txt.split(',');
        }
        var edit_project_skill = [];
        if(project_skill.length > 0)
        {                    
            project_skill.forEach(function(element,skillIndex) {
              edit_project_skill[skillIndex] = {"name":element};
            });
        }
        $scope.project_skill_list = edit_project_skill;

        $("#project_field").val(projects_arr.project_field);        
        if(projects_arr.project_field == 0)
        {
            $("#proj_other_field_div").show();
            $("#project_other_field").val(projects_arr.project_other_field);
        }
        $("#project_url").val(projects_arr.project_url);

        var project_partner_arr = "";
        if(projects_arr.project_partner_name.trim() != "")
        {
            var project_partner_arr = projects_arr.project_partner_name.split(',');
        }
        var project_partner_list = [];
        if(project_partner_arr.length > 0)
        {                    
            project_partner_arr.forEach(function(element,pIndex) {
              project_partner_list[pIndex] = {"p_name":element};
            });
        }
        $scope.project_partner = project_partner_list;
        
        var proj_start_date = projects_arr.project_start_date.split('-');
        var proj_end_date = projects_arr.project_end_date.split('-');        
        $scope.project_s_year = proj_start_date[0];
        $scope.project_start_year();
        // $scope.exp_s_month = proj_start_date[1];
        setTimeout(function(){
            $("#project_s_month").val(proj_start_date[1]);
            $("#project_e_year").val(proj_end_date[0]).change();
            // $scope.exp_e_year = exp_end_date[0];
        },500);
        setTimeout(function(){
            $("#project_e_month").val(proj_end_date[1]);
        },500);

        $("#project_desc").val(projects_arr.project_desc);

        var proj_file_name = projects_arr.project_file;
        $scope.project_file_old = proj_file_name;
        if(proj_file_name.trim() != "")
        {            
            var filename_arr = proj_file_name.split('.');
            $("#project_file_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="project_file_prev" class="screen-shot"><a href="'+user_project_upload_url+proj_file_name+'" target="_blank"><img style="width: 100px;" src="'+user_project_upload_url+proj_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="project_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+user_project_upload_url+proj_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#project_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.project_form.validate();
        },1000);

        var delete_btn = '<a id="delete_user_project_modal" href="#" data-target="#delete-project-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#prject_loader"));
        $compile(contentbtn)($scope);
        $("#dtl-project").modal("show");
    };

    $scope.delete_user_project = function(){
        $("#delete_user_project").attr("style","pointer-events:none;display:none;");
        $("#user_project_del_loader").show();
        $("#project-delete-btn").hide();
        if($scope.edit_project != 0)
        {
            var expdata = $.param({'project_id': $scope.edit_project});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/delete_user_project',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_projects = result.user_projects;                        
                        $("#delete-project-model").modal('hide');
                        $("#dtl-project").modal('hide');
                        $("#delete_user_project").removeAttr("style");
                        $("#user_project_del_loader").hide();
                        $("#project-delete-btn").show();                        
                        $scope.reset_project_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                    else
                    {
                        $("#delete-project-model").modal('hide');
                        $("#dtl-project").modal('hide');
                        $("#delete_user_project").removeAttr("style");
                        $("#user_project_del_loader").hide();
                        $("#project-delete-btn").show();
                        $scope.reset_project_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.delete_user_project();
                },500);
            });
        }
    };
    //Project End

    //Education Start
    $scope.get_edu_degree = function(){
        $http.get(base_url + "userprofile_page/get_edu_degree").then(function (success) {
            $scope.degree_data = success.data.degree_data;
        }, function (error) {
            setTimeout(function(){
                $scope.get_edu_degree();
            },500);
        });
    };
    $scope.get_edu_degree();

    $scope.get_edu_university = function(){
        $http.get(base_url + "userprofile_page/get_edu_university").then(function (success) {
            $scope.university_data = success.data.university_data;
        }, function (error) {
            setTimeout(function(){
                $scope.get_edu_university();
            },500);
        });
    };
    $scope.get_edu_university();

    $scope.edu_degree_change = function(){
        $("#other_edu").hide();
        if($scope.edu_degree != "" && $scope.edu_degree != 0)
        {            
            $("#edu_stream").attr("disabled","disabled");
            $("#edu_stream_loader").show();
            var counrtydata = $.param({'degree_id': $scope.edu_degree});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_stream_by_degree_id',
                data: counrtydata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#edu_stream").removeAttr("disabled");
                $("#edu_stream_loader").hide();
                $scope.stream_data = data.data.stream_data;
            }, function (error) {
                setTimeout(function(){
                    $scope.edu_degree_change();
                },500);
            });
        }
        else
        {
            $scope.stream_data = [];
            if($scope.edu_degree == 0 && $scope.edu_degree != "")
            {
                $("#edu_stream").attr("disabled","disabled");
                $("#other_edu").show();
            }
            
        }
    };

    $scope.edu_university_change = function(){
        if($scope.edu_university == 0 && $scope.edu_university != "")
        {
            $("#other_university").show();
        }
        else
        {
            $("#other_university").hide();   
        }
    };

    $scope.edu_start_year = function(){        
        $("#edudateerror").html("");
        $("#edudateerror").hide();
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();
        if($scope.edu_s_year == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }
        var year_opt = "<option value=''>Year</option>";
        if($scope.edu_s_year != "" && $scope.edu_s_year != 0)
        {            
            for (var i = yyyy; i >= $scope.edu_s_year; i--) {            
                year_opt += "<option value='"+i+"'>"+i+"</option>";
            }
        }
        var elyear = $('#edu_e_year');
        elyear.html($compile(year_opt)($scope));

        var month_opt = "";
        for (var j = 0; j <= mm; j++) {            
            month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
        }
        var elmonth = $('#edu_s_month');
        elmonth.html($compile(month_opt)($scope));
    };
    $(document).on('change','#edu_e_year', function(e){
        $("#edudateerror").html("");
        $("#edudateerror").hide();
        var todaydate = new Date();
        var yyyy = todaydate.getFullYear();

        // console.log($(this).val());
        if($(this).val() == yyyy)
        {
            var mm = todaydate.getMonth();
        }
        else
        {
            var mm = 11;
        }

        var month_opt = "";
        for (var j = 0; j <= mm; j++) {            
            month_opt += "<option value='"+parseInt(j + 1)+"'>"+all_months[j]+"</option>";
        }
        $('#edu_e_month').html(month_opt);
    });

    var edu_formdata = new FormData();
    $(document).on('change','#edu_file', function(e){
        $("#edu_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#edu_file_error").html("File size must be less than 10MB.");
            $("#edu_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                edu_formdata.append('edu_file', $('#edu_file')[0].files[0]);
            }
            else {
                $("#edu_file_error").html("Invalid file selected.");
                $("#edu_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.edu_validate = {
        rules: {            
            edu_school_college: {
                required: true,
                maxlength: 200,
                minlength: 3
            },
            edu_university: {
                required: true,
            },
            edu_other_university: {
                required: {
                    depends: function(element) {
                        return $("#edu_university option:selected").val() == 0 ? true : false;
                    }
                },
                maxlength: 200,
                minlength: 3
            },
            edu_degree: {
                required: true,
            },
            edu_other_degree: {
                required: {
                    depends: function(element) {
                        return $("#edu_degree option:selected").val() == 0 ? true : false;
                    }
                },
                maxlength: 200,
                minlength: 3
            },
            edu_stream: {
                required: true,
            },
            edu_other_stream: {
                required: {
                    depends: function(element) {
                        return $("#edu_stream option:selected").val() == 0 ? true : false;
                    }
                },
                maxlength: 200,
                minlength: 3
            },
            edu_s_year: {
                required: true,
            },
            edu_s_month: {
                required: true,
            },
            edu_e_year: {
                required: {
                    depends: function(element) {
                        return $("#edu_nograduate").is(':checked') ? false : true;
                    }
                },
            },
            edu_e_month: {
                required: {
                    depends: function(element) {
                        return $("#edu_nograduate").is(':checked') ? false : true;
                    }
                },
            },
        },      
        messages: {
            edu_school_college: {
                required: "Please enter school / college name",
            },
            edu_university: {
                required: "Please enter select board / university",
            },
            edu_degree: {
                required: "Please enter select degree / qualification",
            },
            edu_stream: {
                required: "Please select course / field of study / stream",
            },
            edu_s_year: {
                required: "Please select education start date",
            },
            edu_s_month: {
                required: "Please select education start date",
            },
            edu_e_year: {
                required: "Please select education end date",
            },            
            edu_e_month: {
                required: "Please select education end date",
            },
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
    };

    $scope.save_user_education = function(){        
        $("#edudateerror").html("");
        $("#edudateerror").hide();
        if ($scope.edu_form.validate()) {
            $("#edu_loader").show();
            $("#edu_save").attr("style","pointer-events:none;display:none;");

            var edu_s_year = $("#edu_s_year option:selected").val();
            var edu_s_month = $("#edu_s_month option:selected").val();

            var edu_e_year = $("#edu_e_year option:selected").val();
            var edu_e_month = $("#edu_e_month option:selected").val();
            var edu_date_error = false;
            if(parseInt(edu_e_year) == parseInt(edu_s_year))
            {
                if(parseInt(edu_e_month) <= parseInt(edu_s_month))
                {
                    edu_date_error = true;
                }
            }
            var edu_nograduate = 0;
            if($("#edu_nograduate:checked").length == 1)
            {
                edu_nograduate = 1;
                edu_date_error = false;
            }

            if (edu_date_error == true) {                
                $("#edudateerror").html("Education date not same or start date is less than end date.");
                $("#edudateerror").show();
                $("#edu_save").removeAttr("style");
                $("#edu_loader").hide();
                return false;
            }

            edu_formdata.append('edit_edu', $scope.edit_edu);
            edu_formdata.append('edu_file_old', $scope.edu_file_old);
            edu_formdata.append('edu_school_college', $('#edu_school_college').val());
            edu_formdata.append('edu_university', $('#edu_university option:selected').val());
            edu_formdata.append('edu_other_university', $('#edu_other_university').val());
            edu_formdata.append('edu_degree', $('#edu_degree option:selected').val());
            edu_formdata.append('edu_other_degree', $('#edu_other_degree').val());
            edu_formdata.append('edu_stream', $('#edu_stream option:selected').val());
            edu_formdata.append('edu_other_stream', $('#edu_other_stream').val());
            edu_formdata.append('edu_s_year', edu_s_year);
            edu_formdata.append('edu_s_month', edu_s_month);
            edu_formdata.append('edu_e_year', edu_e_year);
            edu_formdata.append('edu_e_month', edu_e_month);            
            edu_formdata.append('edu_nograduate', edu_nograduate);

            $http.post(base_url + 'userprofile_page/save_user_education', edu_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == 1)
                    {
                        $scope.edu_nograduate = 0;
                        $("#other_university").hide(); 
                        $("#other_edu").hide();
                        $("#edu_save").removeAttr("style");
                        $("#edu_loader").hide();
                        $("#edu_form")[0].reset();
                        $scope.user_education = result.user_education;
                        $scope.reset_edu_form();
                        $("#educational-info").modal('hide');
                    }
                    else
                    {
                        $scope.edu_nograduate = 0;
                        $("#other_university").hide(); 
                        $("#other_edu").hide();
                        $("#edu_save").removeAttr("style");
                        $("#edu_loader").hide();
                        $("#edu_form")[0].reset();
                        $scope.reset_edu_form();
                        $("#educational-info").modal('hide');
                    }
                    var profile_progress = result.profile_progress;
                    var count_profile_value = profile_progress.user_process_value;
                    var count_profile = profile_progress.user_process;
                    $scope.progress_status = profile_progress.progress_status;
                    $scope.set_progress(count_profile_value,count_profile);
                    $scope.get_all_counter();
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.save_user_education();
                },500);
            });
        }
    };

    $scope.get_user_education = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_education',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_education = result.data.user_education;
                $scope.user_education = user_education;
            }
            $("#edution-loader").hide();
            $("#edution-body").show();
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_education();
            },500);
        });
    }
    $scope.get_user_education();
    $scope.view_more_edu = 2;
    $scope.edu_view_more = function(){
        $scope.view_more_edu = $scope.user_education.length;
        $("#view-more-edu").hide();
    };
    $scope.reset_edu_form = function(){
        $scope.edit_edu = 0;
        $("#educational-info").removeClass("edit-form-cus");
        $scope.edu_file_old = "";
        $("#other_edu").hide();
        $scope.edu_university = "";
        $scope.edu_degree = "";
        $scope.edu_stream = "";
        $scope.edu_s_year = "";
        $("#edu_s_month").html('');
        $("#edu_s_month").html('');
        $("#edu_e_year").html('');
        $("#edu_e_month").html('');
        $("#edu_file_error").hide();        
        $("#edu_file_prev").remove();
        $("#delete_user_edu_modal").remove();
        $('#edu_file').val('');
        $("#edu_form")[0].reset();
        edu_formdata = new FormData();
    };
    $scope.edit_user_edu = function(index){
        $scope.reset_edu_form();
        $("#educational-info").addClass("edit-form-cus");
        var edu_arr = $scope.user_education[index];        
        $scope.edit_edu = edu_arr.id_education;
        $("#edu_school_college").val(edu_arr.edu_school_college);
        $scope.edu_university = edu_arr.edu_university;
        if(edu_arr.edu_university == 0)
        {
            $("#other_university").show();
            $("#edu_other_university").val(edu_arr.edu_other_university);
        }

        // $("#edu_degree").val(edu_arr.edu_degree).change();
        $scope.edu_degree = edu_arr.edu_degree;
        $scope.edu_degree_change();
        if(edu_arr.edu_degree == 0)
        {
            $("#other_edu").show();
            $("#edu_other_degree").val(edu_arr.edu_other_degree);            
            $("#edu_other_stream").val(edu_arr.edu_other_stream);            
        }
        else
        {            
            // $("#edu_stream").val(edu_arr.edu_stream).change();
            $scope.edu_stream = edu_arr.edu_stream;
        }

        var edu_start_date = edu_arr.edu_start_date.split('-');
        var edu_end_date = edu_arr.edu_end_date.split('-');        
        $scope.edu_s_year = edu_start_date[0];
        $scope.edu_start_year();
        // $scope.exp_s_month = edu_start_date[1];
        setTimeout(function(){
            $("#edu_s_month").val(edu_start_date[1]);
            $("#edu_e_year").val(edu_end_date[0]).change();
            // $scope.exp_e_year = exp_end_date[0];
        },500);
        setTimeout(function(){
            $("#edu_e_month").val(edu_end_date[1]);
        },500);

        $scope.edu_nograduate = (parseInt(edu_arr.edu_nograduate) == 1 ? true : false);

        var edu_file_name = edu_arr.edu_file;
        $scope.edu_file_old = edu_file_name;
        if(edu_file_name.trim() != "")
        {            
            var filename_arr = edu_file_name.split('.');
            $("#edu_file_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="edu_file_prev" class="screen-shot"><a href="'+user_education_upload_url+edu_file_name+'" target="_blank"><img style="width: 100px;" src="'+user_education_upload_url+edu_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="edu_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+user_education_upload_url+edu_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#edu_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.edu_form.validate();
        },1000); 

        var delete_btn = '<a id="delete_user_edu_modal" href="#" data-target="#delete-edu-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#edu_loader"));
        $compile(contentbtn)($scope);
        $("#educational-info").modal("show");
    };

    $scope.delete_user_edu = function(){
        $("#delete_user_edu").attr("style","pointer-events:none;display:none;");
        $("#user_edu_del_loader").show();
        $("#edu-delete-btn").hide();
        if($scope.edit_edu != 0)
        {
            var expdata = $.param({'edu_id': $scope.edit_edu});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/delete_user_education',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_education = result.user_education;
                        $("#delete-edu-model").modal('hide');
                        $("#educational-info").modal('hide');
                        $("#delete_user_edu").removeAttr("style");
                        $("#user_edu_del_loader").hide();
                        $("#edu-delete-btn").show();                        
                        $scope.reset_edu_form();
                        var profile_progress = result.profile_progress;
                        var count_profile_value = profile_progress.user_process_value;
                        var count_profile = profile_progress.user_process;
                        $scope.progress_status = profile_progress.progress_status;
                        $scope.set_progress(count_profile_value,count_profile);
                        $scope.get_all_counter();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                    else
                    {
                        $("#delete-edu-model").modal('hide');
                        $("#educational-info").modal('hide');
                        $("#delete_user_edu").removeAttr("style");
                        $("#user_edu_del_loader").hide();
                        $("#edu-delete-btn").show();
                        $scope.reset_edu_form();
                        // $scope.exp_designation = [];
                        // $("#experience_form")[0].reset();                        
                    }
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.delete_user_edu();
                },500);
            });
        }
    };
    //Education End
    
    $scope.set_progress = function(count_profile_value,count_profile){
        if(count_profile == 100)
        {
            $("#progress-txt").html("Hurray! Your profile is complete.");
            setTimeout(function(){
                $("#edit-profile-move").hide();
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


    $(document).on('change','select', function(e){
        $(this).addClass("custom-color");
    });
    angular.element(document).ready(function () {
        
        if (screen.width <= 1199) {
            $("#edit-profile-move").appendTo($(".edit-profile-move"));
            $("#skill-move").appendTo($(".skill-move"));
            $("#social-link-move").appendTo($(".social-link-move"));
            $("#idol-move").appendTo($(".idol-move"));
            $("#about-move").appendTo($(".about-move"));
            $("#add-move").appendTo($(".add-move"));
			$(".remove-blank").remove();
        }
	

        $('.modal').on('hidden.bs.modal', function () {
            //If there are any visible            
            if($(".modal:visible").length > 0) {
                //Slap the class on it (wait a moment for things to settle)
                setTimeout(function() {
                    $('body').addClass('modal-open');
                },200);
            }
            else
            {
                setTimeout(function() {
                    $('body').removeClass('modal-open');
                },200);
            }
        });
		if (screen.width > 767) {
        var masonryLayout = function masonryLayout(containerElem, itemsElems, columns) {
          containerElem.classList.add('masonry-layout', 'columns-' + columns);
          var columnsElements = [];

          for (var i = 1; i <= columns; i++) {
            var column = document.createElement('div');
            column.classList.add('masonry-column', 'column-' + i);
            containerElem.appendChild(column);
            columnsElements.push(column);
          }

          for (var m = 0; m < Math.ceil(itemsElems.length / columns); m++) {
            for (var n = 0; n < columns; n++) {
              var item = itemsElems[m * columns + n];
              columnsElements[n].appendChild(item);
              item.classList.add('masonry-item');
            }
          }
		  
        };

        masonryLayout(document.getElementById('gallery'),
        document.querySelectorAll('.gallery-item'), 2);
		}
		if (screen.width < 768) {
			$("#edit-profile-move").appendTo($(".edit-profile-mob"));
		}
    });
});
app.controller('contactsController', function ($scope, $http, $location, $window,$compile) {
    $scope.today = new Date();
    
    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;    
    $scope.user_slug = user_data_slug;
    $scope.$parent.title = "Contacts | Aileensoul";
    $scope.pagi = {};
    var isProcessing = false;

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
                // var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
                var hh = $scope.today.getHours() < 10 ? '0'+$scope.today.getHours() : $scope.today.getHours();
                var mm = $scope.today.getMinutes() < 10 ? '0'+$scope.today.getMinutes() : $scope.today.getMinutes();
                var ss = $scope.today.getSeconds() < 10 ? '0'+$scope.today.getSeconds() : $scope.today.getSeconds();
                var times = hh+''+mm+''+ss;
                var all_html = '';
                if(data.user_type.toString() == '2')
                {
                    all_html += '<div class="bus-tooltip">';
                        all_html += '<div class="user-tooltip">';
                        
                            all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background)
                            {
                                all_html += '<img src="'+bus_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else
                            {
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';   
                            }
                            all_html += '</div>';

                            all_html += '<div class="tooltip-user-detail">';
                                all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.business_user_image)
                                {
                                    all_html += '<img src="'+bus_profile_thumb_upload_url+data.user_data.business_user_image+'">';
                                }
                                else
                                {
                                    all_html += '<img src="'+base_url+nobusimage+'">';
                                }
                                all_html += '</div>';
                                
                                all_html += '<div class="fw">';
                                    all_html += '<div class="tooltip-detail">';
                                        all_html += '<h4>'+data.user_data.company_name+'</h4>';
                                        all_html += '<p>';
                                            if(data.user_data.industry_name){
                                                all_html += data.user_data.industry_name;
                                            }
                                            else{
                                                all_html += "Current Work";
                                            }
                                        all_html += '</p>';

                                        all_html += '<p>';
                                            all_html += data.user_data.city_name + (data.user_data.state_name != '' ? ',' : '') + data.user_data.state_name + (data.user_data.country_name != '' ? ',' : '') + data.user_data.country_name;
                                        all_html += '</p>';
                                    all_html += '</div>';

                                    if(data.user_data.user_id != login_user_id){
                                        all_html += '<div class="tooltip-btns follow-btn-bus-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user_bus(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</div>';
                                    }

                                all_html += '</div>';

                            all_html += '</div>';
                        all_html += '</div>';
                    all_html += '</div>';
                }
                if(data.user_type.toString() == '1')
                {
                    all_html += '<div class="user-tooltip">';
                        all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background){
                                all_html += '<img src="'+user_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else{
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';
                            }
                        all_html += '</div>';
                        all_html += '<div class="tooltip-user-detail">';
                            all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.user_image){
                                    all_html += '<img src="'+user_thumb_upload_url+data.user_data.user_image+'">';
                                }
                                else
                                {
                                    if(data.user_data.user_gender == 'M'){
                                        all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                    }
                                    if(data.user_data.user_gender == 'F'){
                                        all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                    }
                                }
                            all_html += '</div>';

                            // all_html += '<h4>'+data.user_data.fullname+'</h4>';
                            all_html += '<h4><a href="'+base_url+data.user_data.user_slug+'" target="_self">'+data.user_data.fullname+'</a></h4>';
                            all_html += '<p>';
                                if(data.user_data.title_name && !data.user_data.degree_name){
                                    all_html += (data.user_data.title_name.length > 30 ? data.user_data.title_name.substr(0,30)+'...' : data.user_data.title_name);
                                }
                                else if(!data.user_data.title_name && data.user_data.degree_name){
                                    all_html += (data.user_data.degree_name.length > 30 ? data.user_data.degree_name.substr(0,30)+'...' : data.user_data.degree_name);
                                }
                                else{
                                    all_html += "Current Work";
                                }
                            all_html += '</p>';
                            if(data.post_count != '' || data.contact_count != '' || data.follower_count != ''){
                                all_html += '<p>';
                                    if(data.post_count != ''){
                                        all_html += '<span><b>'+data.post_count+'</b> Posts</span>';
                                    }
                                    if(data.contact_count != ''){
                                        all_html += '<span><b>'+data.contact_count+'</b> Contacts</span>';
                                    }
                                    if(data.follower_count != ''){
                                        all_html += '<span><b>'+data.follower_count+'</b> Followers</span>';
                                    }
                                all_html += '</p>';
                            }
                            if(data.mutual_friend.length > 0){
                                all_html += '<ul>';
                                for(var i=0;i<data.mutual_friend.length;i++){
                                    if(i == 2)
                                    {
                                        break;
                                    }
                                    friends = data.mutual_friend[i];
                                    all_html += '<li><div class="user-img">';
                                    if(friends.user_image){
                                        all_html += '<img src="'+user_thumb_upload_url+friends.user_image+'">';
                                    }
                                    else
                                    {                        
                                        if(friends.user_gender == 'M'){
                                            all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                        }
                                        if(friends.user_gender == 'F'){
                                            all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                        }
                                    }
                                    all_html += '</div></li>';
                                }

                                all_html += '<li class="m-contacts">';
                                    if(data.mutual_friend.length == 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> is in mutual contact.</span>';
                                    }
                                    else if(data.mutual_friend.length > 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> and <b>'+parseInt(data.mutual_friend.length - 1)+'</b> more mutual contacts.</span>';
                                    }
                                all_html += '</li>';
                                all_html += '</ul>';
                            }

                            if(data.user_data.user_id != login_user_id){
                                all_html += '<div class="tooltip-btns">';
                                    all_html += '<ul>';
                                        all_html += '<li class="contact-btn-'+data.user_data.user_id+'">';
                                            if(data.contact_value == 'new'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'confirm'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',1" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">In Contacts</a>';
                                            }
                                            else if(data.contact_value == 'pending'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Request sent</a>';
                                            }
                                            else if(data.contact_value == 'cancel'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'reject'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li class="follow-btn-user-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li>';
                                            all_html += '<a href="'+message_url+'user/'+data.user_data.user_slug+'" class="btn-new-1" target="_blank">Message</a>';
                                        all_html += '</li>';

                                    all_html += '</ul>';
                                all_html += '</div>';
                            }

                        all_html += '</div>';
                    all_html += '</div>';
                }            
                /*setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);*/
                $('#'+div_id).html(all_html);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    setTimeout(function(){        
    /*var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
        $compile($el)($scope);

    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
        $compile($el)($scope);*/
    },1000);

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();

    $scope.contact = function (id, status, to_id,indexCon,confirm) {
        if(confirm == '1')
        {
            $("#remove-contact-conform-"+indexCon).modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addToContactNew',
            data: 'contact_id=' + id + '&status=' + status + '&to_id=' + to_id + '&indexCon=' + indexCon,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {            
            if(success.data != "")
            {
                $("#contact-btn-"+indexCon).html($compile(success.data.button)($scope));
            }
            $scope.get_all_counter();
        }, function (error) {
            setTimeout(function(){
                $scope.contact(id, status, to_id,indexCon,confirm);
            },500);
        });
    }

    $scope.remove_contact = function (id, status, to_id,indexCon) {        
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addToContactNew',
            data: 'contact_id=' + id + '&status=' + status + '&to_id=' + to_id + '&indexCon=' + indexCon,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {            
            if(success.data != "")
            {                
                $("#contact-btn-"+indexCon).html($compile(success.data.button)($scope));
            }
            $scope.get_all_counter();
        }, function (error) {
            setTimeout(function(){
                $scope.remove_contact(id, status, to_id,indexCon);
            },500);
        });
    }

    // Fetch data
    $scope.getContacts = function (pagenum) {
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
            if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }
        if (isProcessing) {
          
            /*
             *This won't go past this condition while
             *isProcessing is true.
             *You could even display a message.
             **/
            return;
        }
        isProcessing = true;
        $(".loadmore").show();
        $http({
            method: 'post',
            url: base_url + "userprofile_page/contacts_data?page=" + pagenum+"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            $(".loadmore").hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (response.data != '') {
                isProcessing = false;
                $scope.pagi.page = response.data.pagedata.page;
                $scope.pagi.total_record = response.data.pagedata.total_record;
                $scope.pagi.perpage_record = response.data.pagedata.perpage_record;
                $scope.row += $scope.rowperpage;
                if ($scope.contactData != undefined) {
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.contactrecord) {
                        $scope.contactData.push(response.data.contactrecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.contactData = response.data.contactrecord;
                }
                setTimeout(function(){
                    var originalLeave = $.fn.popover.Constructor.prototype.leave;
                    $.fn.popover.Constructor.prototype.leave = function(obj){
                        var self = obj instanceof this.constructor ?
                        obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
                        var container, timeout;

                        originalLeave.call(this, obj);

                        if(obj.currentTarget) {
                            container = $(obj.currentTarget).siblings('.popover')
                            timeout = self.timeout;
                            container.one('mouseenter', function(){
                                //We entered the actual popover – call off the dogs
                                clearTimeout(timeout);
                                //Let's monitor popover content instead
                                container.one('mouseleave', function(){
                                    $.fn.popover.Constructor.prototype.leave.call(self, self);
                                });
                            })
                        }
                    };

                    $('body').popover({
                        selector: '[data-popover]',
                        animation: true,
                        trigger: "click hover" ,
                        delay: {show: 1000, hide: 50},
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            // console.log($(this).data('tooltip-url'));
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);//$(this).data('tooltip-url'),div_id);
                            // return $('#popover-content').html();
                        },
                        // placement: 'auto',
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    });
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },500);
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        }, function (error) {
            setTimeout(function(){
                $scope.getContacts();
            },500);
        });
    }
    angular.element($window).bind("scroll", function (e) {
        // console.log($(window).scrollTop());
        // console.log($(document).height() - $(window).height());
        // console.log(($(document).height() - $(window).height()) * 0.7);
        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
        // if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7)) {
            var page = $scope.pagi.page;
            var total_record = $scope.pagi.total_record;
            var perpage_record = $scope.pagi.perpage_record;
            
           // alert(parseInt(perpage_record * page));
           // alert(total_record);
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.pagi.page) + 1;
                    $scope.getContacts(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getContacts();

    $scope.user = {};
    var id = 1;
    $scope.remove = function (index) {
        $('#remove-contact .mes').html("<div class='pop_content'>Do you want to remove this post?<div class='model_ok_cancel'><a class='okbtn btn1' id=" + id + " onClick='remove_contacts(" + index + ")' href='javascript:void(0);' data-dismiss='modal'>Yes</a><a class='cnclbtn btn1' href='javascript:void(0);' data-dismiss='modal'>No</a></div></div>");
        $('#remove-contact').modal('show');
    }
    // PROFEETIONAL DATA
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }
});
app.controller('followersController', function ($scope, $http, $location, $compile, $window) {
    $scope.today = new Date();

    //    lazzy loader start

    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;    
    $scope.user_slug = user_data_slug;
    $scope.$parent.title = "Follower | Aileensoul";
    $scope.page_number = 0;
    $scope.total_record = '';
    $scope.perpage = 10;

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
                // var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
                var hh = $scope.today.getHours() < 10 ? '0'+$scope.today.getHours() : $scope.today.getHours();
                var mm = $scope.today.getMinutes() < 10 ? '0'+$scope.today.getMinutes() : $scope.today.getMinutes();
                var ss = $scope.today.getSeconds() < 10 ? '0'+$scope.today.getSeconds() : $scope.today.getSeconds();
                var times = hh+''+mm+''+ss;
                var all_html = '';
                if(data.user_type.toString() == '2')
                {
                    all_html += '<div class="bus-tooltip">';
                        all_html += '<div class="user-tooltip">';
                        
                            all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background)
                            {
                                all_html += '<img src="'+bus_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else
                            {
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';   
                            }
                            all_html += '</div>';

                            all_html += '<div class="tooltip-user-detail">';
                                all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.business_user_image)
                                {
                                    all_html += '<img src="'+bus_profile_thumb_upload_url+data.user_data.business_user_image+'">';
                                }
                                else
                                {
                                    all_html += '<img src="'+base_url+nobusimage+'">';
                                }
                                all_html += '</div>';
                                
                                all_html += '<div class="fw">';
                                    all_html += '<div class="tooltip-detail">';
                                        all_html += '<h4>'+data.user_data.company_name+'</h4>';
                                        all_html += '<p>';
                                            if(data.user_data.industry_name){
                                                all_html += data.user_data.industry_name;
                                            }
                                            else{
                                                all_html += "Current Work";
                                            }
                                        all_html += '</p>';

                                        all_html += '<p>';
                                            all_html += data.user_data.city_name + (data.user_data.state_name != '' ? ',' : '') + data.user_data.state_name + (data.user_data.country_name != '' ? ',' : '') + data.user_data.country_name;
                                        all_html += '</p>';
                                    all_html += '</div>';

                                    if(data.user_data.user_id != login_user_id){
                                        all_html += '<div class="tooltip-btns follow-btn-bus-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user_bus(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</div>';
                                    }

                                all_html += '</div>';

                            all_html += '</div>';
                        all_html += '</div>';
                    all_html += '</div>';
                }
                if(data.user_type.toString() == '1')
                {
                    all_html += '<div class="user-tooltip">';
                        all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background){
                                all_html += '<img src="'+user_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else{
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';
                            }
                        all_html += '</div>';
                        all_html += '<div class="tooltip-user-detail">';
                            all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.user_image){
                                    all_html += '<img src="'+user_thumb_upload_url+data.user_data.user_image+'">';
                                }
                                else
                                {
                                    if(data.user_data.user_gender == 'M'){
                                        all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                    }
                                    if(data.user_data.user_gender == 'F'){
                                        all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                    }
                                }
                            all_html += '</div>';

                            // all_html += '<h4>'+data.user_data.fullname+'</h4>';
                            all_html += '<h4><a href="'+base_url+data.user_data.user_slug+'" target="_self">'+data.user_data.fullname+'</a></h4>';
                            all_html += '<p>';
                                if(data.user_data.title_name && !data.user_data.degree_name){
                                    all_html += (data.user_data.title_name.length > 30 ? data.user_data.title_name.substr(0,30)+'...' : data.user_data.title_name);
                                }
                                else if(!data.user_data.title_name && data.user_data.degree_name){
                                    all_html += (data.user_data.degree_name.length > 30 ? data.user_data.degree_name.substr(0,30)+'...' : data.user_data.degree_name);
                                }
                                else{
                                    all_html += "Current Work";
                                }
                            all_html += '</p>';
                            if(data.post_count != '' || data.contact_count != '' || data.follower_count != ''){
                                all_html += '<p>';
                                    if(data.post_count != ''){
                                        all_html += '<span><b>'+data.post_count+'</b> Posts</span>';
                                    }
                                    if(data.contact_count != ''){
                                        all_html += '<span><b>'+data.contact_count+'</b> Contacts</span>';
                                    }
                                    if(data.follower_count != ''){
                                        all_html += '<span><b>'+data.follower_count+'</b> Followers</span>';
                                    }
                                all_html += '</p>';
                            }
                            if(data.mutual_friend.length > 0){
                                all_html += '<ul>';
                                for(var i=0;i<data.mutual_friend.length;i++){
                                    if(i == 2)
                                    {
                                        break;
                                    }
                                    friends = data.mutual_friend[i];
                                    all_html += '<li><div class="user-img">';
                                    if(friends.user_image){
                                        all_html += '<img src="'+user_thumb_upload_url+friends.user_image+'">';
                                    }
                                    else
                                    {                        
                                        if(friends.user_gender == 'M'){
                                            all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                        }
                                        if(friends.user_gender == 'F'){
                                            all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                        }
                                    }
                                    all_html += '</div></li>';
                                }

                                all_html += '<li class="m-contacts">';
                                    if(data.mutual_friend.length == 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> is in mutual contact.</span>';
                                    }
                                    else if(data.mutual_friend.length > 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> and <b>'+parseInt(data.mutual_friend.length - 1)+'</b> more mutual contacts.</span>';
                                    }
                                all_html += '</li>';
                                all_html += '</ul>';
                            }

                            if(data.user_data.user_id != login_user_id){
                                all_html += '<div class="tooltip-btns">';
                                    all_html += '<ul>';
                                        all_html += '<li class="contact-btn-'+data.user_data.user_id+'">';
                                            if(data.contact_value == 'new'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'confirm'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',1" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">In Contacts</a>';
                                            }
                                            else if(data.contact_value == 'pending'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Request sent</a>';
                                            }
                                            else if(data.contact_value == 'cancel'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'reject'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li class="follow-btn-user-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li>';
                                            all_html += '<a href="'+message_url+'user/'+data.user_data.user_slug+'" class="btn-new-1" target="_blank">Message</a>';
                                        all_html += '</li>';

                                    all_html += '</ul>';
                                all_html += '</div>';
                            }

                        all_html += '</div>';
                    all_html += '</div>';
                }
                
                /*setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);*/
                $('#'+div_id).html(all_html);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    setTimeout(function(){
    /*var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
        $compile($el)($scope);

    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
        $compile($el)($scope);*/
    },1000);

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }
            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();
    var isProcessing = false;

    // Fetch data
    $scope.getFollowers = function (pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
            if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }
        $('.loadmore').show();
        $http({
            method: 'post',
            url: base_url + "userprofile_page/followers_data?page=" + pagenum +"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            $('.loadmore').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (response.data != '') {
                $scope.row += $scope.rowperpage;
                if ($scope.followersData != undefined) {
                    isProcessing = false;
                    $scope.page_number = response.data.pagedata.page;
                    $scope.total_record = response.data.pagedata.total_record;
                    $scope.perpage = response.data.pagedata.perpage_record;
                    for (var i in response.data.followerrecord) {
                        $scope.followersData.push(response.data.followerrecord[i]);
                    }
                } else {
                    isProcessing = false;
                    $scope.pagecntctData = response.data;
                    $scope.followersData = response.data.followerrecord;
                    $scope.page_number = response.data.pagedata.page;
                    $scope.total_record = response.data.pagedata.total_record;
                    $scope.perpage = response.data.pagedata.perpage_record;
                }
                setTimeout(function(){
                    var originalLeave = $.fn.popover.Constructor.prototype.leave;
                    $.fn.popover.Constructor.prototype.leave = function(obj){
                        var self = obj instanceof this.constructor ?
                        obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
                        var container, timeout;

                        originalLeave.call(this, obj);

                        if(obj.currentTarget) {
                            container = $(obj.currentTarget).siblings('.popover')
                            timeout = self.timeout;
                            container.one('mouseenter', function(){
                                //We entered the actual popover – call off the dogs
                                clearTimeout(timeout);
                                //Let's monitor popover content instead
                                container.one('mouseleave', function(){
                                    $.fn.popover.Constructor.prototype.leave.call(self, self);
                                });
                            })
                        }
                    };

                    $('body').popover({
                        selector: '[data-popover]',
                        animation: true,
                        trigger: "click hover" ,
                        delay: {show: 1000, hide: 50},
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            // console.log($(this).data('tooltip-url'));
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);//$(this).data('tooltip-url'),div_id);
                            // return $('#popover-content').html();
                        },
                        // placement: 'auto',
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    });
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },500);
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        }, function (error) {
            setTimeout(function(){
                $scope.getFollowers();
            },500);
        });
    }
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage;//$(".perpage_record").val();
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    // alert(pagenum);
                    $scope.getFollowers(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getFollowers();
   // lazzy loader end

    $scope.user = {};
    var id = 1;
    $scope.follow = function (index) { }

    // PROFEETIONAL DATA
    $scope.follow_user = function (id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/follow_user',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $scope.get_all_counter();
            $("#" + id).html($compile(success.data)($scope));
        }, function (error) {
            setTimeout(function(){
                $scope.follow_user(id);
            },500);
        });
    }
    $scope.unfollow_user = function (id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/unfollow_user',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $scope.get_all_counter();
            $("#" + id).html($compile(success.data)($scope));
        }, function (error) {
            setTimeout(function(){
                $scope.unfollow_user(id);
            },500);
        });
    }
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }
});
app.controller('followingController', function ($scope, $http, $location, $compile, $window) {
    $scope.today = new Date();
    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;    
    $scope.user_slug = user_data_slug;
    $scope.$parent.title = "Following | Aileensoul";
    $scope.page_number = 0;
    $scope.total_record = '';
    $scope.perpage = 10;    

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
                // var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
                var hh = $scope.today.getHours() < 10 ? '0'+$scope.today.getHours() : $scope.today.getHours();
                var mm = $scope.today.getMinutes() < 10 ? '0'+$scope.today.getMinutes() : $scope.today.getMinutes();
                var ss = $scope.today.getSeconds() < 10 ? '0'+$scope.today.getSeconds() : $scope.today.getSeconds();
                var times = hh+''+mm+''+ss;
                var all_html = '';
                if(data.user_type.toString() == '2')
                {
                    all_html += '<div class="bus-tooltip">';
                        all_html += '<div class="user-tooltip">';
                        
                            all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background)
                            {
                                all_html += '<img src="'+bus_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else
                            {
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';   
                            }
                            all_html += '</div>';

                            all_html += '<div class="tooltip-user-detail">';
                                all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.business_user_image)
                                {
                                    all_html += '<img src="'+bus_profile_thumb_upload_url+data.user_data.business_user_image+'">';
                                }
                                else
                                {
                                    all_html += '<img src="'+base_url+nobusimage+'">';
                                }
                                all_html += '</div>';
                                
                                all_html += '<div class="fw">';
                                    all_html += '<div class="tooltip-detail">';
                                        all_html += '<h4>'+data.user_data.company_name+'</h4>';
                                        all_html += '<p>';
                                            if(data.user_data.industry_name){
                                                all_html += data.user_data.industry_name;
                                            }
                                            else{
                                                all_html += "Current Work";
                                            }
                                        all_html += '</p>';

                                        all_html += '<p>';
                                            all_html += data.user_data.city_name + (data.user_data.state_name != '' ? ',' : '') + data.user_data.state_name + (data.user_data.country_name != '' ? ',' : '') + data.user_data.country_name;
                                        all_html += '</p>';
                                    all_html += '</div>';

                                    if(data.user_data.user_id != login_user_id){
                                        all_html += '<div class="tooltip-btns follow-btn-bus-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user_bus(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</div>';
                                    }

                                all_html += '</div>';

                            all_html += '</div>';
                        all_html += '</div>';
                    all_html += '</div>';
                }
                if(data.user_type.toString() == '1')
                {
                    all_html += '<div class="user-tooltip">';
                        all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background){
                                all_html += '<img src="'+user_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else{
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';
                            }
                        all_html += '</div>';
                        all_html += '<div class="tooltip-user-detail">';
                            all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.user_image){
                                    all_html += '<img src="'+user_thumb_upload_url+data.user_data.user_image+'">';
                                }
                                else
                                {
                                    if(data.user_data.user_gender == 'M'){
                                        all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                    }
                                    if(data.user_data.user_gender == 'F'){
                                        all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                    }
                                }
                            all_html += '</div>';

                            // all_html += '<h4>'+data.user_data.fullname+'</h4>';
                            all_html += '<h4><a href="'+base_url+data.user_data.user_slug+'" target="_self">'+data.user_data.fullname+'</a></h4>';
                            all_html += '<p>';
                                if(data.user_data.title_name && !data.user_data.degree_name){
                                    all_html += (data.user_data.title_name.length > 30 ? data.user_data.title_name.substr(0,30)+'...' : data.user_data.title_name);
                                }
                                else if(!data.user_data.title_name && data.user_data.degree_name){
                                    all_html += (data.user_data.degree_name.length > 30 ? data.user_data.degree_name.substr(0,30)+'...' : data.user_data.degree_name);
                                }
                                else{
                                    all_html += "Current Work";
                                }
                            all_html += '</p>';
                            if(data.post_count != '' || data.contact_count != '' || data.follower_count != ''){
                                all_html += '<p>';
                                    if(data.post_count != ''){
                                        all_html += '<span><b>'+data.post_count+'</b> Posts</span>';
                                    }
                                    if(data.contact_count != ''){
                                        all_html += '<span><b>'+data.contact_count+'</b> Contacts</span>';
                                    }
                                    if(data.follower_count != ''){
                                        all_html += '<span><b>'+data.follower_count+'</b> Followers</span>';
                                    }
                                all_html += '</p>';
                            }
                            if(data.mutual_friend.length > 0){
                                all_html += '<ul>';
                                for(var i=0;i<data.mutual_friend.length;i++){
                                    if(i == 2)
                                    {
                                        break;
                                    }
                                    friends = data.mutual_friend[i];
                                    all_html += '<li><div class="user-img">';
                                    if(friends.user_image){
                                        all_html += '<img src="'+user_thumb_upload_url+friends.user_image+'">';
                                    }
                                    else
                                    {                        
                                        if(friends.user_gender == 'M'){
                                            all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                        }
                                        if(friends.user_gender == 'F'){
                                            all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                        }
                                    }
                                    all_html += '</div></li>';
                                }

                                all_html += '<li class="m-contacts">';
                                    if(data.mutual_friend.length == 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> is in mutual contact.</span>';
                                    }
                                    else if(data.mutual_friend.length > 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> and <b>'+parseInt(data.mutual_friend.length - 1)+'</b> more mutual contacts.</span>';
                                    }
                                all_html += '</li>';
                                all_html += '</ul>';
                            }

                            if(data.user_data.user_id != login_user_id){
                                all_html += '<div class="tooltip-btns">';
                                    all_html += '<ul>';
                                        all_html += '<li class="contact-btn-'+data.user_data.user_id+'">';
                                            if(data.contact_value == 'new'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'confirm'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',1" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">In Contacts</a>';
                                            }
                                            else if(data.contact_value == 'pending'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Request sent</a>';
                                            }
                                            else if(data.contact_value == 'cancel'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'reject'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li class="follow-btn-user-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li>';
                                            all_html += '<a href="'+message_url+'user/'+data.user_data.user_slug+'" class="btn-new-1" target="_blank">Message</a>';
                                        all_html += '</li>';

                                    all_html += '</ul>';
                                all_html += '</div>';
                            }

                        all_html += '</div>';
                    all_html += '</div>';
                }
                
                /*setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);*/
                $('#'+div_id).html(all_html);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    
    setTimeout(function(){
    /*var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
        $compile($el)($scope);

    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
        $compile($el)($scope);*/
    },1000);

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();
    var isProcessing = false;
    // Fetch data
    $scope.getFollowing = function (pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
            if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }
        $('.loadmore').show();

        $http({
            method: 'post',
            url: base_url + "userprofile_page/following_data?page=" + pagenum +"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            $('.loadmore').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (response.data != '') {
                $scope.row += $scope.rowperpage;
                if ($scope.followingData != undefined) {
                    isProcessing = false;
                    $scope.page_number = response.data.pagedata.page;
                    $scope.total_record = response.data.pagedata.total_record;
                    $scope.perpage = response.data.pagedata.perpage_record;
                    for (var i in response.data.followingrecord) {
                        $scope.followingData.push(response.data.followingrecord[i]);
                    }
                } else {
                    isProcessing = false;
                    $scope.pagecntctData = response.data;
                    $scope.followingData = response.data.followingrecord;
                    $scope.page_number = response.data.pagedata.page;
                    $scope.total_record = response.data.pagedata.total_record;
                    $scope.perpage = response.data.pagedata.perpage_record;
                }
                setTimeout(function(){
                    var originalLeave = $.fn.popover.Constructor.prototype.leave;
                    $.fn.popover.Constructor.prototype.leave = function(obj){
                        var self = obj instanceof this.constructor ?
                        obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
                        var container, timeout;

                        originalLeave.call(this, obj);

                        if(obj.currentTarget) {
                            container = $(obj.currentTarget).siblings('.popover')
                            timeout = self.timeout;
                            container.one('mouseenter', function(){
                                //We entered the actual popover – call off the dogs
                                clearTimeout(timeout);
                                //Let's monitor popover content instead
                                container.one('mouseleave', function(){
                                    $.fn.popover.Constructor.prototype.leave.call(self, self);
                                });
                            })
                        }
                    };

                    $('body').popover({
                        selector: '[data-popover]',
                        animation: true,
                        trigger: "click hover" ,
                        delay: {show: 1000, hide: 50},
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            // console.log($(this).data('tooltip-url'));
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);//$(this).data('tooltip-url'),div_id);
                            // return $('#popover-content').html();
                        },
                        // placement: 'auto',
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    });
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },500);
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        }, function (error) {
            setTimeout(function(){
                $scope.getFollowing(pagenum);
            },500);
        });
    }
    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage;//$(".perpage_record").val();
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;
                    $scope.getFollowing(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getFollowing();
   // lazzy loader end
    $scope.user = {};
    var id = 1;
    
    $scope.follow_user = function (id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/follow_user',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $("#" + id).html($compile(success.data)($scope));
        }, function (error) {
            setTimeout(function(){
                $scope.follow_user(id);
            },500);
        });
    }
    // PROFEETIONAL DATA
    $scope.unfollow_user = function (id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/unfollowingContacts',
            dataType: 'json',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            if (success.data.response == 1) {                
                if(live_slug != user_slug)
                {
                    $('.following_counter').html(success.data.unfollowingcount);
                }
                else
                {
                    $('#' + id).closest('.custom-user-box').fadeToggle();
                    $('.following_counter').html(success.data.unfollowingcount);
                    if (success.data.unfollowingcount == '0') {
                        $("#nofollowng").html("<div class='art-img-nn'><div class='art_no_post_img'><img src='assets/img/icon_notification_big.png' alt='notification image'></div><div class='art_no_post_text'>No Following Contacts Available. </div></div>");
                        $(".following_counter").hide();
                    }
                }
            }
        }, function (error) {
            setTimeout(function(){
                $scope.unfollow_user(id);
            },500);
        });
    }

    $scope.follow_business_user = function (id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/follow_business_user',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $("#buss-" + id).html($compile(success.data)($scope));
        }, function (error) {
            setTimeout(function(){
                $scope.follow_business_user(id);
            },500);
        });
    }
    
    $scope.unfollow_business_user = function (id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/unfollowing_business_user',
            dataType: 'json',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            if (success.data.response == 1) {
                if(live_slug != user_slug)
                {
                    $("#buss-" + id).html($compile(success.data.follow_view)($scope));
                }
                else
                {
                    $('#buss-' + id).closest('.custom-user-box').fadeToggle();
                    $('.following_counter').html(success.data.unfollowingcount);
                    if (success.data.unfollowingcount == '0') {
                        $("#nofollowng").html("<div class='art-img-nn'><div class='art_no_post_img'><img src='assets/img/icon_notification_big.png' alt='notification image'></div><div class='art_no_post_text'>No Following Contacts Available. </div></div>");
                        $(".following_counter").hide();
                    }
                }
            }
        }, function (error) {
            setTimeout(function(){
                $scope.unfollow_business_user(id);
            },500);
        });
    }
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }
});
app.controller('hashtagController', function ($scope, $http, $location, $compile, $window) {
    $scope.today = new Date();
    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;    
    $scope.user_slug = user_data_slug;
    $scope.$parent.title = "Hashtags | Aileensoul";
    $scope.page_number = 0;
    $scope.total_record = '';
    $scope.perpage = 12;
    
    setTimeout(function(){
    /*var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
        $compile($el)($scope);

    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
        $compile($el)($scope);*/
    },1000);

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();
    var isProcessing = false;
    // Fetch data
    $scope.getFollowingHashtags = function (pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
            if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }
        $('#hashtag-loader').show();

        $http({
            method: 'post',
            url: base_url + "userprofile_page/following_hashtags_data?page=" + pagenum +"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            $('#hashtag-loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (response.data != '') {
                if ($scope.hashtag_list != undefined) {
                    isProcessing = false;
                    $scope.page_number = response.data.page;
                    $scope.total_record = response.data.total_record;                    
                    for (var i in response.data.hashtag_list) {
                        $scope.hashtag_list.push(response.data.hashtag_list[i]);
                    }
                } else {
                    isProcessing = false;
                    $scope.hashtag_list = response.data.hashtag_list;
                    $scope.page_number = response.data.page;
                    $scope.total_record = response.data.total_record;                    
                }
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        }, function (error) {
            setTimeout(function(){
                $scope.getFollowingHashtags(pagenum);
            },500);
        });
    }
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage;//$(".perpage_record").val();
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;
                    $scope.getFollowingHashtags(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getFollowingHashtags();
    // lazzy loader end
    $scope.follow_hashtag = function(hashtag_id,index)
    {
        $(".hashtag-follow-btn-"+hashtag_id).attr('style','pointer-events:none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/follow_hashtag',
            data: 'hashtag_id=' + hashtag_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.status == 1) {
                $scope.hashtag_list[index].hashtag_follow_status = success.data.status;
                $scope.hashtag_list[index].hashtag_follower_count = success.data.hashtag_follower_count;
            }
            $(".hashtag-follow-btn-"+hashtag_id).removeAttr('style');
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.follow_hashtag(hashtag_id,index);
            },500);
        });
    };

    $scope.unfollow_hashtag = function(hashtag_id,index)
    {
        $(".hashtag-follow-btn-"+hashtag_id).attr('style','pointer-events:none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/unfollow_hashtag',
            data: 'hashtag_id=' + hashtag_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.status == 0) {
                $scope.hashtag_list[index].hashtag_follow_status = success.data.status;
                $scope.hashtag_list[index].hashtag_follower_count = success.data.hashtag_follower_count;
            }
            $(".hashtag-follow-btn-"+hashtag_id).removeAttr('style');
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.follow_hashtag(hashtag_id,index);
            },500);
        });
    };
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }
});
app.controller('questionsController', function ($scope, $http, $location, $compile, $window) {
    $scope.today = new Date();
    var isLoadingData = false;
    //    lazzy loader start
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";
    $scope.ask = {};
    $scope.user_id = user_id;
    $scope.$parent.title = "Questions | Aileensoul";

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
                // var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
                var hh = $scope.today.getHours() < 10 ? '0'+$scope.today.getHours() : $scope.today.getHours();
                var mm = $scope.today.getMinutes() < 10 ? '0'+$scope.today.getMinutes() : $scope.today.getMinutes();
                var ss = $scope.today.getSeconds() < 10 ? '0'+$scope.today.getSeconds() : $scope.today.getSeconds();
                var times = hh+''+mm+''+ss;
                var all_html = '';
                if(data.user_type.toString() == '2')
                {
                    all_html += '<div class="bus-tooltip">';
                        all_html += '<div class="user-tooltip">';
                        
                            all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background)
                            {
                                all_html += '<img src="'+bus_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else
                            {
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';   
                            }
                            all_html += '</div>';

                            all_html += '<div class="tooltip-user-detail">';
                                all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.business_user_image)
                                {
                                    all_html += '<img src="'+bus_profile_thumb_upload_url+data.user_data.business_user_image+'">';
                                }
                                else
                                {
                                    all_html += '<img src="'+base_url+nobusimage+'">';
                                }
                                all_html += '</div>';
                                
                                all_html += '<div class="fw">';
                                    all_html += '<div class="tooltip-detail">';
                                        all_html += '<h4>'+data.user_data.company_name+'</h4>';
                                        all_html += '<p>';
                                            if(data.user_data.industry_name){
                                                all_html += data.user_data.industry_name;
                                            }
                                            else{
                                                all_html += "Current Work";
                                            }
                                        all_html += '</p>';

                                        all_html += '<p>';
                                            all_html += data.user_data.city_name + (data.user_data.state_name != '' ? ',' : '') + data.user_data.state_name + (data.user_data.country_name != '' ? ',' : '') + data.user_data.country_name;
                                        all_html += '</p>';
                                    all_html += '</div>';

                                    if(data.user_data.user_id != login_user_id){
                                        all_html += '<div class="tooltip-btns follow-btn-bus-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user_bus(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</div>';
                                    }

                                all_html += '</div>';

                            all_html += '</div>';
                        all_html += '</div>';
                    all_html += '</div>';
                }
                if(data.user_type.toString() == '1')
                {
                    all_html += '<div class="user-tooltip">';
                        all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background){
                                all_html += '<img src="'+user_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else{
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';
                            }
                        all_html += '</div>';
                        all_html += '<div class="tooltip-user-detail">';
                            all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.user_image){
                                    all_html += '<img src="'+user_thumb_upload_url+data.user_data.user_image+'">';
                                }
                                else
                                {
                                    if(data.user_data.user_gender == 'M'){
                                        all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                    }
                                    if(data.user_data.user_gender == 'F'){
                                        all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                    }
                                }
                            all_html += '</div>';

                            // all_html += '<h4>'+data.user_data.fullname+'</h4>';
                            all_html += '<h4><a href="'+base_url+data.user_data.user_slug+'" target="_self">'+data.user_data.fullname+'</a></h4>';
                            all_html += '<p>';
                                if(data.user_data.title_name && !data.user_data.degree_name){
                                    all_html += (data.user_data.title_name.length > 30 ? data.user_data.title_name.substr(0,30)+'...' : data.user_data.title_name);
                                }
                                else if(!data.user_data.title_name && data.user_data.degree_name){
                                    all_html += (data.user_data.degree_name.length > 30 ? data.user_data.degree_name.substr(0,30)+'...' : data.user_data.degree_name);
                                }
                                else{
                                    all_html += "Current Work";
                                }
                            all_html += '</p>';
                            if(data.post_count != '' || data.contact_count != '' || data.follower_count != ''){
                                all_html += '<p>';
                                    if(data.post_count != ''){
                                        all_html += '<span><b>'+data.post_count+'</b> Posts</span>';
                                    }
                                    if(data.contact_count != ''){
                                        all_html += '<span><b>'+data.contact_count+'</b> Contacts</span>';
                                    }
                                    if(data.follower_count != ''){
                                        all_html += '<span><b>'+data.follower_count+'</b> Followers</span>';
                                    }
                                all_html += '</p>';
                            }
                            if(data.mutual_friend.length > 0){
                                all_html += '<ul>';
                                for(var i=0;i<data.mutual_friend.length;i++){
                                    if(i == 2)
                                    {
                                        break;
                                    }
                                    friends = data.mutual_friend[i];
                                    all_html += '<li><div class="user-img">';
                                    if(friends.user_image){
                                        all_html += '<img src="'+user_thumb_upload_url+friends.user_image+'">';
                                    }
                                    else
                                    {                        
                                        if(friends.user_gender == 'M'){
                                            all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                        }
                                        if(friends.user_gender == 'F'){
                                            all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                        }
                                    }
                                    all_html += '</div></li>';
                                }

                                all_html += '<li class="m-contacts">';
                                    if(data.mutual_friend.length == 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> is in mutual contact.</span>';
                                    }
                                    else if(data.mutual_friend.length > 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> and <b>'+parseInt(data.mutual_friend.length - 1)+'</b> more mutual contacts.</span>';
                                    }
                                all_html += '</li>';
                                all_html += '</ul>';
                            }

                            if(data.user_data.user_id != login_user_id){
                                all_html += '<div class="tooltip-btns">';
                                    all_html += '<ul>';
                                        all_html += '<li class="contact-btn-'+data.user_data.user_id+'">';
                                            if(data.contact_value == 'new'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'confirm'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',1" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">In Contacts</a>';
                                            }
                                            else if(data.contact_value == 'pending'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Request sent</a>';
                                            }
                                            else if(data.contact_value == 'cancel'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'reject'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li class="follow-btn-user-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li>';
                                            all_html += '<a href="'+message_url+'user/'+data.user_data.user_slug+'" class="btn-new-1" target="_blank">Message</a>';
                                        all_html += '</li>';

                                    all_html += '</ul>';
                                all_html += '</div>';
                            }

                        all_html += '</div>';
                    all_html += '</div>';
                }
                
                /*setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);*/
                $('#'+div_id).html(all_html);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    setTimeout(function(){
    /*var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
        $compile($el)($scope);

    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
        $compile($el)($scope);*/
    },1000);

    $scope.getHashTags = function(inputText) {  
        var regex = /(?:^|\s)(?:#)([a-zA-Z\d]+)/gm;
        // var regex = /[^\s#]+/g;
        var matches = [];
        var match;

        while ((match = regex.exec(inputText))) {
            matches.push(match[1]);
        }

        return matches;
    };
    
    getFieldList();
    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {
            setTimeout(function(){
                getFieldList();
            },500);
        });
    }

    $scope.prettifyNumber = function(value) {
        var thousand = 1000;
        var million = 1000000;
        var billion = 1000000000;
        var trillion = 1000000000000;
        if (value < thousand) {
            return String(value);   
        }
        
        if (value >= thousand && value <= 1000000) {
             return  Math.abs(value/thousand).toFixed(1) + 'k';   
        }
        
        if (value >= million && value <= billion) {
            return Math.abs(value/million).toFixed(1) + 'M';   
        }
        
        if (value >= billion && value <= trillion) {
            return Math.abs(value/billion).toFixed(1) + 'B';   
        }
        
        else {
            return Math.abs(value/trillion).toFixed(1) + 'T';   
        }
    };

    $scope.get_all_counter = function() {
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }
    $scope.get_all_counter();

    //$scope.category = [];
    $scope.loadCategory = function ($query) {
        return $http.get(base_url + 'user_post/get_category', {cache: true}).then(function (response) {
            var category_data = response.data;
            return category_data.filter(function (category) {
                return category.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.l_page = 0;
    $scope.l_total_record = 0;
    $scope.l_perpage = 7;
    
    $scope.like_post_id = 0;
    $scope.like_user_list = function (post_id) {
        $scope.like_post_id = post_id;
        pagenum = 1;

        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id + '&pagenum='+pagenum,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            if(success.data.countlike > 0)
            {
                $scope.l_page = success.data.page;
                $scope.l_total_record = success.data.countlike;
                $('#likeusermodal').modal('show');
                setTimeout(function(){
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },500);
            }
        }, function (error) {
            setTimeout(function(){
                $scope.like_user_list(post_id);
            },500);
        });
    }

    var is_processing = false;

    $scope.like_user_list_loadmore = function(post_id,pagenum) {
        if(is_processing)
        {
            return false;
        }
        is_processing = true;
        $('#like_loader').show();
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id + '&pagenum='+pagenum,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $('#like_loader').hide();
            if(success.data.likeuserlist)
            {
                for (var i in success.data.likeuserlist) {
                    $scope.get_like_user_list.push(success.data.likeuserlist[i]);
                }

                $scope.l_page = success.data.page;
                $scope.l_total_record = success.data.countlike;
                
                setTimeout(function(){
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },500);
                is_processing = false;
            }
            
        });
    }

    $('.like-popup-scroll').on('scroll', function () {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            var page = $scope.l_page;
            var total_record = $scope.l_total_record;
            var perpage_record = $scope.l_perpage;
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.l_page) + 1;
                    $scope.like_user_list_loadmore($scope.like_post_id,pagenum);
                }
            }
        }
    });

    $scope.getQuestions = function (pagenum) {
        $('.loadmore').show();        
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
            if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }
        $http({
            method: 'post',
            url: base_url + "userprofile_page/questions_list?page=" + pagenum+"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            $('.loadmore').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            $('.post_loader').hide();
            isLoadingData  = false;
            if (response.data != '') {
                $scope.row += $scope.rowperpage;
                if ($scope.questionData != undefined) {
                    //$scope.page_number = response.data.pagedata.page;
                    for (var i in response.data) {
                        $scope.questionData.push(response.data[i]);                        
                    }
                    
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.questionData = response.data;
                }
                setTimeout(function(){
                    var originalLeave = $.fn.popover.Constructor.prototype.leave;
                    $.fn.popover.Constructor.prototype.leave = function(obj){
                        var self = obj instanceof this.constructor ?
                        obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
                        var container, timeout;

                        originalLeave.call(this, obj);

                        if(obj.currentTarget) {
                            container = $(obj.currentTarget).siblings('.popover')
                            timeout = self.timeout;
                            container.one('mouseenter', function(){
                                //We entered the actual popover – call off the dogs
                                clearTimeout(timeout);
                                //Let's monitor popover content instead
                                container.one('mouseleave', function(){
                                    $.fn.popover.Constructor.prototype.leave.call(self, self);
                                });
                            })
                        }
                    };

                    $('body').popover({
                        selector: '[data-popover]',
                        animation: true,
                        trigger: "click hover" ,
                        delay: {show: 1000, hide: 50},
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            // console.log($(this).data('tooltip-url'));
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);//$(this).data('tooltip-url'),div_id);
                            // return $('#popover-content').html();
                        },
                        // placement: 'auto',
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    });
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },500);
            } else {
                if(pagenum == '' || pagenum == 0 || pagenum == undefined)
                {
                    $scope.questionData = [];
                }
                $scope.showLoadmore = false;
            }
            $('footer').show();
        }, function (error) {
            setTimeout(function(){
                $scope.getQuestions(pagenum);
            },500);
        });
    }
    
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() == $(document).height() - $(window).height()  && isLoadingData == false ) {
            isLoadingData = true;
            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    $scope.getQuestions(pagenum);                    
                }
            }
        }
    });
    $scope.getQuestions();
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }

    $scope.post_like = function (post_id,parent_index,user_id) {

        if($('#post-like-' + post_id).hasClass('like'))
        {
            $('#post-like-' + post_id).removeClass('like');
            var like_cnt = $('#post-like-count-' + post_id).html();
            if(parseInt(like_cnt) - 1 < 1)
            {
                $('#post-like-count-' + post_id).hide();
            }
            else
            {
                $('#post-like-count-' + post_id).html(parseInt(like_cnt) - 1);
            }
        }
        else
        {
            $('#post-like-' + post_id).addClass('like');
            $('#post-like-count-' + post_id).show();
            var like_cnt = $('#post-like-count-' + post_id).html();
            $('#post-like-count-' + post_id).html(parseInt(like_cnt) + 1);

        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            
            if (success.data.message == 1) {
                if(socket)
                {
                    socket.emit('user notification',user_id);
                }
                if (success.data.is_newLike == 1) {
                    $('#post-like-count-' + post_id).show();
                    // $('#post-like-' + post_id).addClass('like');
                    
                    var myEl = angular.element( document.querySelector('#post-like-' + post_id) );
                    myEl.addClass('like');

                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                } else if (success.data.is_oldLike == 1) {
                    if(success.data.likePost_count < 1)
                    {                        
                        $('#post-like-count-' + post_id).hide();
                    }
                    else
                    {
                        $('#post-like-count-' + post_id).show();
                    }
                    $('#post-like-' + post_id).removeClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                }
                $scope.questionData[parent_index].user_like_list = success.data.user_like_list;
            }
        }, function (error) {
            setTimeout(function(){
                $scope.post_like(post_id,parent_index,user_id);
            },500);
        });
    }

    $scope.giveAnswer = function (user_id) {
        /*var ans_text_class = document.getElementById('ans-text-' + user_id).className.split(' ').pop();
        if (ans_text_class == 'open') {
            $('#ans-text-' + user_id).removeClass('open');
            $('#ans-text-' + user_id).css('display', 'none');
            $('#all-post-bottom-' + user_id).css('display', 'none');
        } else {
            $('#ans-text-' + user_id).addClass('open');
            $('#ans-text-' + user_id).css('display', 'block');
            $('#all-post-bottom-' + user_id).css('display', 'block');
        }*/
    }

    $scope.IsVisible = false;
    $scope.ShowHide = function () {
        //If DIV is visible it will be hidden and vice versa.
        $scope.IsVisible = $scope.IsVisible ? false : true;
    }

    $scope.sendComment = function (post_id, index, post) {
        //var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            var data = $.param({comment:comment,post_id:post_id});
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: data,//'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.questionData[index].post_data.user_id);
                    }
                    $scope.questionData[index].post_comment_count = data.comment_count;
                    $('.post-comment-count-' + post_id).html(data.comment_count);
                    $('.editable_text').html('');
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.sendComment(post_id, index, post);
                },500);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.deletePost = function (post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;

        $('#delete_post_model').modal('show');
    }
    $scope.deletedPost = function (post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (data.message == '1') {
                //$scope.questionData.splice(index, 1);
                $scope.questionData = [];
                $scope.getQuestions();
                $scope.get_all_counter();
            }
        }, function (error) {
            setTimeout(function(){
                $scope.deletedPost(post_id, index);
            },500);
        });
    }
});

app.controller('savedpostController', function ($scope, $http, $location, $compile, $window) {
    $scope.today = new Date();

    var isLoadingData = false;    
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 5;
    $scope.buttonText = "Load More";
    $scope.savedpost = {};
    $scope.user_id = user_id;
    $scope.$parent.title = "Saved Post | Aileensoul";

    $scope.opp = {};
    $scope.sim = {};
    $scope.ask = {};
    $scope.postData = {};
    $scope.opp.post_for = 'opportunity';
    $scope.sim.post_for = 'simple';
    $scope.ask.post_for = 'question';

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
                // var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
                var hh = $scope.today.getHours() < 10 ? '0'+$scope.today.getHours() : $scope.today.getHours();
                var mm = $scope.today.getMinutes() < 10 ? '0'+$scope.today.getMinutes() : $scope.today.getMinutes();
                var ss = $scope.today.getSeconds() < 10 ? '0'+$scope.today.getSeconds() : $scope.today.getSeconds();
                var times = hh+''+mm+''+ss;
                var all_html = '';
                if(data.user_type.toString() == '2')
                {
                    all_html += '<div class="bus-tooltip">';
                        all_html += '<div class="user-tooltip">';
                        
                            all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background)
                            {
                                all_html += '<img src="'+bus_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else
                            {
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';   
                            }
                            all_html += '</div>';

                            all_html += '<div class="tooltip-user-detail">';
                                all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.business_user_image)
                                {
                                    all_html += '<img src="'+bus_profile_thumb_upload_url+data.user_data.business_user_image+'">';
                                }
                                else
                                {
                                    all_html += '<img src="'+base_url+nobusimage+'">';
                                }
                                all_html += '</div>';
                                
                                all_html += '<div class="fw">';
                                    all_html += '<div class="tooltip-detail">';
                                        all_html += '<h4>'+data.user_data.company_name+'</h4>';
                                        all_html += '<p>';
                                            if(data.user_data.industry_name){
                                                all_html += data.user_data.industry_name;
                                            }
                                            else{
                                                all_html += "Current Work";
                                            }
                                        all_html += '</p>';

                                        all_html += '<p>';
                                            all_html += data.user_data.city_name + (data.user_data.state_name != '' ? ',' : '') + data.user_data.state_name + (data.user_data.country_name != '' ? ',' : '') + data.user_data.country_name;
                                        all_html += '</p>';
                                    all_html += '</div>';

                                    if(data.user_data.user_id != login_user_id){
                                        all_html += '<div class="tooltip-btns follow-btn-bus-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user_bus(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user_bus(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</div>';
                                    }

                                all_html += '</div>';

                            all_html += '</div>';
                        all_html += '</div>';
                    all_html += '</div>';
                }
                if(data.user_type.toString() == '1')
                {
                    all_html += '<div class="user-tooltip">';
                        all_html += '<div class="tooltip-cover-img">';
                            if(data.user_data.profile_background){
                                all_html += '<img src="'+user_bg_main_upload_url+data.user_data.profile_background+'">';
                            }
                            else{
                                all_html += '<div class="gradient-bg" style="height: 100%"></div>';
                            }
                        all_html += '</div>';
                        all_html += '<div class="tooltip-user-detail">';
                            all_html += '<div class="tooltip-user-img">';
                                if(data.user_data.user_image){
                                    all_html += '<img src="'+user_thumb_upload_url+data.user_data.user_image+'">';
                                }
                                else
                                {
                                    if(data.user_data.user_gender == 'M'){
                                        all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                    }
                                    if(data.user_data.user_gender == 'F'){
                                        all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                    }
                                }
                            all_html += '</div>';

                            // all_html += '<h4>'+data.user_data.fullname+'</h4>';
                            all_html += '<h4><a href="'+base_url+data.user_data.user_slug+'" target="_self">'+data.user_data.fullname+'</a></h4>';
                            all_html += '<p>';
                                if(data.user_data.title_name && !data.user_data.degree_name){
                                    all_html += (data.user_data.title_name.length > 30 ? data.user_data.title_name.substr(0,30)+'...' : data.user_data.title_name);
                                }
                                else if(!data.user_data.title_name && data.user_data.degree_name){
                                    all_html += (data.user_data.degree_name.length > 30 ? data.user_data.degree_name.substr(0,30)+'...' : data.user_data.degree_name);
                                }
                                else{
                                    all_html += "Current Work";
                                }
                            all_html += '</p>';
                            if(data.post_count != '' || data.contact_count != '' || data.follower_count != ''){
                                all_html += '<p>';
                                    if(data.post_count != ''){
                                        all_html += '<span><b>'+data.post_count+'</b> Posts</span>';
                                    }
                                    if(data.contact_count != ''){
                                        all_html += '<span><b>'+data.contact_count+'</b> Contacts</span>';
                                    }
                                    if(data.follower_count != ''){
                                        all_html += '<span><b>'+data.follower_count+'</b> Followers</span>';
                                    }
                                all_html += '</p>';
                            }
                            if(data.mutual_friend.length > 0){
                                all_html += '<ul>';
                                for(var i=0;i<data.mutual_friend.length;i++){
                                    if(i == 2)
                                    {
                                        break;
                                    }
                                    friends = data.mutual_friend[i];
                                    all_html += '<li><div class="user-img">';
                                    if(friends.user_image){
                                        all_html += '<img src="'+user_thumb_upload_url+friends.user_image+'">';
                                    }
                                    else
                                    {                        
                                        if(friends.user_gender == 'M'){
                                            all_html += '<img src="'+base_url+"assets/img/man-user.jpg"+'">';
                                        }
                                        if(friends.user_gender == 'F'){
                                            all_html += '<img src="'+base_url+"assets/img/female-user.jpg"+'">';
                                        }
                                    }
                                    all_html += '</div></li>';
                                }

                                all_html += '<li class="m-contacts">';
                                    if(data.mutual_friend.length == 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> is in mutual contact.</span>';
                                    }
                                    else if(data.mutual_friend.length > 1){
                                        all_html += '<span><b>'+data.mutual_friend[0].fullname+'</b> and <b>'+parseInt(data.mutual_friend.length - 1)+'</b> more mutual contacts.</span>';
                                    }
                                all_html += '</li>';
                                all_html += '</ul>';
                            }

                            if(data.user_data.user_id != login_user_id){
                                all_html += '<div class="tooltip-btns">';
                                    all_html += '<ul>';
                                        all_html += '<li class="contact-btn-'+data.user_data.user_id+'">';
                                            if(data.contact_value == 'new'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'confirm'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',1" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">In Contacts</a>';
                                            }
                                            else if(data.contact_value == 'pending'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',cancel,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Request sent</a>';
                                            }
                                            else if(data.contact_value == 'cancel'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                            else if(data.contact_value == 'reject'){
                                                all_html += '<a class="btn-new-1" data-param="'+data.contact_id+''+times+',pending,'+data.user_data.user_id+''+times+','+times+',0" onclick="contact(this.id);" id="contact_btn_'+data.user_data.user_id+'">Add to contact</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li class="follow-btn-user-'+data.user_data.user_id+'">';
                                            if(data.follow_status == '1'){
                                                all_html += '<a class="btn-new-1 following" data-uid="'+data.user_data.user_id+''+times+'" onclick="unfollow_user(this.id)" id="follow_btn_bus">Following</a>';
                                            }
                                            else
                                            {
                                                all_html += '<a class="btn-new-1 follow" data-uid="'+data.user_data.user_id+''+times+'" onclick="follow_user(this.id)" id="follow_btn_bus">Follow</a>';
                                            }
                                        all_html += '</li>';

                                        all_html += '<li>';
                                            all_html += '<a href="'+message_url+'user/'+data.user_data.user_slug+'" class="btn-new-1" target="_blank">Message</a>';
                                        all_html += '</li>';

                                    all_html += '</ul>';
                                all_html += '</div>';
                            }

                        all_html += '</div>';
                    all_html += '</div>';
                }
                
                /*setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);*/
                $('#'+div_id).html(all_html);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    $('footer').hide();
    
    $scope.get_all_counter = function() {
        if($scope.$parent.pade_reload == true)
        {
            $('#main_loader').show();
        }
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            $('#main_loader').hide();
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }    

    $("#job_title").focusin(function(){
        $('#jobtitletooltip').show();
    });
    $("#job_title").focusout(function(){
        $('#jobtitletooltip').hide();
    });

    $("#location").focusin(function(){
        $('#locationtooltip').show();
    });
    $("#location").focusout(function(){
        $('#locationtooltip').hide();
    });
    $("#field").focusin(function(){
        $('#fieldtooltip').show();
    });
    $("#field").focusout(function(){
        $('#fieldtooltip').hide();
    });

    $("#ask_desc").focusin(function(){
        $('#ask_desctooltip').show();
    });
    $("#ask_desc").focusout(function(){
        $('#ask_desctooltip').hide();
    });

    $("#ask_related_category").focusin(function(){
        $('#rlcattooltip').show();
    });
    $("#ask_related_category").focusout(function(){
        $('#rlcattooltip').hide();
    });

    $("#ask_field").focusin(function(){
        $('#ask_fieldtooltip').show();
    });
    $("#ask_field").focusout(function(){
        $('#ask_fieldtooltip').hide();
    });

    $scope.getHashTags = function(inputText) {  
        var regex = /(?:^|\s)(?:#)([a-zA-Z\d]+)/gm;
        // var regex = /[^\s#]+/g;
        var matches = [];
        var match;

        while ((match = regex.exec(inputText))) {
            matches.push(match[1]);
        }

        return matches;
    };


    $(document).on('hidden.bs.modal', function (event) {
        if($('.modal.in').length > 0)
        {
            if ($('body').hasClass('modal-open') == false) {
                $('body').addClass('modal-open');
            };            
        }
    });

    $(document).on('show.bs.modal', '.modal', function(event) {
        $(this).appendTo($('body'));
    }).on('shown.bs.modal', '.modal.in', function(event) {
        setModalsAndBackdropsOrder();
    }).on('hidden.bs.modal', '.modal', function(event) {
        setModalsAndBackdropsOrder();
    });

    function setModalsAndBackdropsOrder() {  
      var modalZIndex = 1040;
      $('.modal.in').each(function(index) {
            var $modal = $(this);
            modalZIndex++;
            $modal.css('zIndex', modalZIndex);
            $modal.next('.modal-backdrop.in').addClass('hidden').css('zIndex', modalZIndex - 1);
        });
      $('.modal.in:visible:last').focus().next('.modal-backdrop.in').removeClass('hidden');
    }

    $(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $('.modal-close').click();            
        }
    });

    $(document).on('keydown','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });

    $(document).on('focusin','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
    });
    $(document).on('focusout','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {             
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
        if($('#job_title ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer....');
            $(this).css('width', '100%');
        }         
    });

    $(document).on('keydown','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
    });
    $(document).on('focusout','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
        if($('#location ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai....');
            $(this).css('width', '100%');
        }         
    });


    $(document).on('keydown','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
    });
    $(document).on('focusout','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {             
            $(this).attr('placeholder', '');
            $(this).css('width', '10px');
        }
        if($('#ask_related_category ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Related Category');
            $(this).css('width', '100%');
        }         
    });

        $scope.removeViewMore = function(mainId,removeViewMore) {    
        $("#"+mainId).removeClass("view-more-expand");
        $("#"+removeViewMore).remove();
    };

    $scope.dashboardPhotosAfterDPUpload = function() {    
        getUserDashboardImage()
    };    
    
    var cntImgSim = 0;
    var formFileDataSim = new FormData();
    var formFileExtSim = [];
    var fileCountSim = 0;
    var fileNamesArrSim = [];

    var cntImgOpp = 0;
    var formFileDataOpp = new FormData();
    var formFileExtOpp = [];
    var fileCountOpp = 0;
    var fileNamesArrOpp = [];

    var cntImgQue = 0;
    var formFileDataQue = new FormData();
    var formFileExtQue = [];
    var fileCountQue = 0;
    var fileNamesArrQue = [];

    $(document).on('change','#fileInput2', function(e){
        $.each($('#fileInput2')[0].files, function(i, f) {
            if(fileNamesArrQue.indexOf(f.name) < 0)
            {

                if(f.type.match("image.*")) {
                
                formFileExtQue.push(f.type.split('/')[1]);
                fileNamesArrQue.push(f.name);

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrevQue_"+cntImgQue+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFileQue('"+cntImgQue+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFilesQue');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataQue.append('myfiles_'+cntImgQue, f);

                        cntImgQue++;
                        fileCountQue++;                    
                        $("#fileCountQue").text(fileCountQue);
                        if($('#fileInput2')[0].files.length - 1 == i)
                        {
                            $('#fileInput2').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }               
            }            
        });
    });

    $scope.removeFileQue = function(rmId) {
        fileCountQue--;
        $("#fileCountQue").text(fileCountQue);
        if(fileCountQue <= 0)
        {
            $("#fileInput2").val("");
        }        
        var ext = formFileDataQue.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtQue.indexOf(ext.toString());
        formFileExtQue.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrQue.indexOf(formFileDataQue.get("myfiles_"+rmId).name);
        fileNamesArrQue.splice(fileNameIndex, 1);
        $("#imgPrevQue_"+rmId).remove();
        formFileDataQue.delete("myfiles_"+rmId);
    };

    $(document).on('change','#fileInput1', function(e){
        $.each($('#fileInput1')[0].files, function(i, f) {
            
            if(fileNamesArrSim.indexOf(f.name) < 0)
            {
                formFileExtSim.push(f.type.split('/')[1]);
                fileNamesArrSim.push(f.name);

                if(f.type.match("image.*")) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrev_"+cntImgSim+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFile('"+cntImgSim+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFiles');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataSim.append('myfiles_'+cntImgSim, f);

                        cntImgSim++;
                        fileCountSim++;                    
                        $("#fileCountSim").text(fileCountSim);
                        if($('#fileInput1')[0].files.length - 1 == i)
                        {
                            $('#fileInput1').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }
                else if(f.type.match("video.*")) {
                    src = URL.createObjectURL(f);
                    var $el = $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip"><video width="400"><source src="'+src+'" id="video_here">Your browser does not support HTML5 video.</video></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    //fileNamesArrSim.push(f.name);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }
                }

                else if(f.type.match("audio.*")) {
                    src = URL.createObjectURL(f);
                    var $el =  $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip i-ip-audio"><audio><source src="'+src+'" type="audio/ogg"><source src="'+src+'" type="audio/mpeg">Your browser does not support the audio element.</audio></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }
                }

                else if(f.type == "application/pdf") {              
                    var $el =  $('<div class="img_preview" id="imgPrev_'+cntImgSim+'"><div class="i-ip"><img ng-src="'+base_url+'assets/images/PDF.jpg" class="selFile"></div><label class="remove_img" name="remove_image" ng-click=\'removeFile("'+cntImgSim+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFiles');
                    //$("#selectedFiles").append(html);
                    $compile($el)($scope);
                    formFileDataSim.append('myfiles_'+cntImgSim, f);
                    cntImgSim++;
                    fileCountSim++;
                    $("#fileCountSim").text(fileCountSim);
                    if($('#fileInput1')[0].files.length - 1 == i)
                    {
                        $('#fileInput1').val("");
                    }

                    /*var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrev_"+cntImgSim+"'><div class='i-ip'><embed width='100%' src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></embed></div><label class='remove_img' name='remove_image' ng-click=\"removeFile('"+cntImgSim+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFiles');
                        //$("#selectedFiles").append(html);
                        $compile($el)($scope);

                        formFileDataSim.append('myfiles_'+cntImgSim, f);

                        cntImgSim++;
                        fileCountSim++;                    
                        $("#fileCountSim").text(fileCountSim);
                        if($('#fileInput1')[0].files.length - 1 == i)
                        {
                            $('#fileInput1').val("");
                        }
                    }
                    reader.readAsDataURL(f);*/
                }
            }            
        });
    });

    $scope.removeFile = function(rmId) {
        fileCountSim--;
        $("#fileCountSim").text(fileCountSim);
        if(fileCountSim <= 0)
        {
            $("#fileInput1").val("");
        }        
        var ext = formFileDataSim.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtSim.indexOf(ext.toString());
        formFileExtSim.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrSim.indexOf(formFileDataSim.get("myfiles_"+rmId).name);
        fileNamesArrSim.splice(fileNameIndex, 1);
        //console.log(fileNamesArrSim);
        $("#imgPrev_"+rmId).remove();
        formFileDataSim.delete("myfiles_"+rmId);

    };

    $(document).on('change','#fileInput', function(e){
        $.each($('#fileInput')[0].files, function(i, f) {
            
            if(fileNamesArrOpp.indexOf(f.name) < 0)
            {
                formFileExtOpp.push(f.type.split('/')[1]);
                fileNamesArrOpp.push(f.name);

                if(f.type.match("image.*")) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var $el = $("<div class='img_preview' id='imgPrevOpp_"+cntImgOpp+"'><div class='i-ip'><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selFile' title='"+f.name+"'></div><label class='remove_img' name='remove_image' ng-click=\"removeFileOpp('"+cntImgOpp+"')\" ><i class='fa fa-trash-o' aria-hidden='true'></i></label></div>").appendTo('#selectedFilesOpp');                        
                        $compile($el)($scope);

                        formFileDataOpp.append('myfiles_'+cntImgOpp, f);

                        cntImgOpp++;
                        fileCountOpp++;                    
                        $("#fileCountOpp").text(fileCountOpp);
                        if($('#fileInput')[0].files.length - 1 == i)
                        {
                            $('#fileInput').val("");
                        }
                    }
                    reader.readAsDataURL(f); 
                }
                else if(f.type.match("video.*")) {
                    src = URL.createObjectURL(f);
                    var $el = $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip"><video width="400"><source src="'+src+'" id="video_here">Your browser does not support HTML5 video.</video></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);                    
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }

                else if(f.type.match("audio.*")) {
                    src = URL.createObjectURL(f);
                    var $el =  $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip i-ip-audio"><audio><source src="'+src+'" type="audio/ogg"><source src="'+src+'" type="audio/mpeg">Your browser does not support the audio element.</audio></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }

                else if(f.type == "application/pdf") {              
                    var $el =  $('<div class="img_preview" id="imgPrevOpp_'+cntImgOpp+'"><div class="i-ip"><img ng-src="'+base_url+'assets/images/PDF.jpg" class="selFile"></div><label class="remove_img" name="remove_image" ng-click=\'removeFileOpp("'+cntImgOpp+'")\'><i class="fa fa-trash-o" aria-hidden="true"></i></label></div>').appendTo('#selectedFilesOpp');                    
                    $compile($el)($scope);
                    formFileDataOpp.append('myfiles_'+cntImgOpp, f);
                    cntImgOpp++;
                    fileCountOpp++;
                    $("#fileCountOpp").text(fileCountOpp);
                    if($('#fileInput')[0].files.length - 1 == i)
                    {
                        $('#fileInput').val("");
                    }
                }
            }            
        });
    });

    $scope.removeFileOpp = function(rmId) {
        fileCountOpp--;
        $("#fileCountOpp").text(fileCountOpp);
        if(fileCountOpp <= 0)
        {
            $("#fileInput").val("");
        }        
        var ext = formFileDataOpp.get("myfiles_"+rmId).type.split('/')[1];
        var fileExtIndex = formFileExtOpp.indexOf(ext.toString());
        formFileExtOpp.splice(fileExtIndex, 1);
        
        var fileNameIndex = fileNamesArrOpp.indexOf(formFileDataOpp.get("myfiles_"+rmId).name);
        fileNamesArrOpp.splice(fileNameIndex, 1);
        $("#imgPrevOpp_"+rmId).remove();
        formFileDataOpp.delete("myfiles_"+rmId);
    };

    $scope.openModal = function() {
        document.getElementById('myModal1').style.display = "block";
        $("body").addClass("modal-open");
    };    
    $scope.closeModal = function() {    
        document.getElementById('myModal1').style.display = "none";
        $("body").removeClass("modal-open");
    };
    $scope.closeModalShare = function(myModal2Id) {    
        document.getElementById(myModal2Id).style.display = "none";
        $("body").removeClass("modal-open");
        $("#"+myModal2Id).modal('hidden');
    };
    //var slideIndex = 1;
    //showSlides(slideIndex);
    $scope.plusSlides = function(n) {    
        showSlides(slideIndex += n);
    };   
    $scope.currentSlide = function(n) {    
        showSlides(slideIndex = n);
    };    
    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        //var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        /*for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }*/
        slides[slideIndex - 1].style.display = "block";
        //dots[slideIndex - 1].className += " active";
        //captionText.innerHTML = dots[slideIndex - 1].alt;
    }

    $scope.openModal2 = function(myModal2Id) {
        /*if(user_id != "")
        {            
            document.getElementById(myModal2Id).style.display = "block";
            $("body").addClass("modal-open");
        }
        else
        {
            $("#regmodal").modal("show");
        }*/
        document.getElementById(myModal2Id).style.display = "block";
        $("body").addClass("modal-open");
    };
    $scope.closeModal2 = function(myModal2Id) {    
        document.getElementById(myModal2Id).style.display = "none";
        $("body").removeClass("modal-open");
    };
    $scope.plusSlides2 = function(n,myModal2Id) {    
        showSlides2(slideIndex += n,myModal2Id);
    };
    $scope.currentSlide2 = function(n,myModal2Id) {    
        showSlides2(slideIndex = n,myModal2Id);
    };
    function showSlides2(n,myModal2Id) {
        var i;
        var slides = document.getElementsByClassName("mySlides2"+myModal2Id);
        //var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        var elem = $("#element_load_"+slideIndex);
        $("#myModal"+myModal2Id+" #all_image_loader").hide();

        if (!elem.prop('complete')) {
            $("#myModal"+myModal2Id+" #all_image_loader").show();
            elem.on('load', function() {
                $("#myModal"+myModal2Id+" #all_image_loader").hide();
                // console.log("Loaded!");
                // console.log(this.complete);
            });
        } 
        /*for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }*/
        slides[slideIndex - 1].style.display = "block";
        //dots[slideIndex - 1].className += " active";
        //captionText.innerHTML = dots[slideIndex - 1].alt;
    }

    $(window).on('scroll', function () {
        if ($(window).scrollTop() == $(document).height() - $(window).height())
        {
            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    getUserSavedPostLoad(pagenum);
                }
            }
        }
    });    

    function getUserSavedPostLoad(pagenum) {
        if (isLoadingData) {
            return;
        }
        isLoadingData = true;
        $('#loader').show();
        $http.get(base_url + "user_post/getUserSavedPost?page=" + pagenum + "&user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            if (success.data.length > 0) {
                isLoadingData = false;
                for (var i in success.data) {
                    $scope.postData.push(success.data[i]);
                }
                // check_no_post_data();
            } else {
                // processing = false;
                // isLoadingData = false;
                isLoadingData = true;
                $scope.showLoadmore = false;
            }
            setTimeout(function(){
                var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

                for (i = 0; i < total; i++) {
                    if($(mediaElements[i])[0].id == '')
                    {                        
                        new MediaElementPlayer(mediaElements[i], {
                            stretching: 'auto',
                            pluginPath: '../../../build/',
                            success: function (media) {
                                var renderer = document.getElementById(media.id + '-rendername');

                                media.addEventListener('loadedmetadata', function () {
                                    var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                                    if (src !== null && src !== undefined) {
                                        // renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                                        // renderer.querySelector('.renderer').innerHTML = media.rendererName;
                                        // renderer.querySelector('.error').innerHTML = '';
                                    }
                                });

                                media.addEventListener('error', function (e) {
                                    renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                                });
                            }
                        });
                    }
                }
                // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
            },1000);
            setTimeout(function(){
                /*$('[data-toggle="popover"]').popover({
                    trigger: "manual" ,
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                        // return $('#popover-content').html();
                    },
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show");
                    $(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide");
                        }
                    }, 100);
                });*/
            },500);
        }, function (error) {
            setTimeout(function(){
                $scope.getUserSavedPostLoad(pagenum);
            },500);
        });
    }

    // getFieldList();
    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {
            setTimeout(function(){
                getFieldList();
            },500);
        });
    }
    if(user_id != "")
    {
        getContactSuggetion();
        function getContactSuggetion() {
            $http.get(base_url + "user_post/getContactSuggetion").then(function (success) {
                $scope.contactSuggetion = success.data;
                //console.log($scope.contactSuggetion);
            }, function (error) {
                setTimeout(function(){
                    getContactSuggetion();
                },500);
            });
        }
    }

    $scope.job_title = [];
    $scope.loadJobTitle = function ($query) {
        return $http.get(base_url + 'user_post/get_jobtitle', {cache: true}).then(function (response) {
            var job_title = response.data;
            return job_title.filter(function (title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };
    $scope.location = [];
    $scope.loadLocation = function ($query) {
        return $http.get(base_url + 'user_post/get_location', {cache: true}).then(function (response) {
            var location_data = response.data;
            return location_data.filter(function (location) {
                return location.city_name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.category = [];
    $scope.loadCategory = function ($query) {
        return $http.get(base_url + 'user_post/get_category', {cache: true}).then(function (response) {
            var category_data = response.data;
            return category_data.filter(function (category) {
                return category.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };


    $scope.IsVisible = false;
    $scope.ShowHide = function () {
        //If DIV is visible it will be hidden and vice versa.
        $scope.IsVisible = $scope.IsVisible ? false : true;
    }


    $scope.questionList = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchQuestionList',
            data: 'q=' + $scope.ask.ask_que,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.queSearchResult = data;
            if ($scope.queSearchResult.length > 0) {
                $('.questionSuggetion').addClass('question-available');
            } else {
                $('.questionSuggetion').removeClass('question-available');
            }
        }, function (error) {
            setTimeout(function(){
                $scope.questionList();
            },500);
        });
    }
    
    
       
    $scope.lightbox = function (idx) {
        //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
        var ninjaSldr = document.getElementById("ninja-slider");
        ninjaSldr.parentNode.style.display = "block";

        nslider.init(idx);

        var fsBtn = document.getElementById("fsBtn");
        fsBtn.click();  
    };
    
    function fsIconClick(isFullscreen, ninjaSldr) { 
        //fsIconClick is the default event handler of the fullscreen button
        if (isFullscreen) {
            ninjaSldr.parentNode.style.display = "none";
        }
    }


    // POST SOMETHING UPLOAD START    

    $scope.loadMediaElement = function ()
    {
        setTimeout(function(){
            var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

            for (i = 0; i < total; i++) {
                new MediaElementPlayer(mediaElements[i], {
                    stretching: 'auto',
                    pluginPath: '../../../build/',
                    success: function (media) {
                        var renderer = document.getElementById(media.id + '-rendername');

                        media.addEventListener('loadedmetadata', function () {
                            var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                            if (src !== null && src !== undefined) {
                                // renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                                // renderer.querySelector('.renderer').innerHTML = media.rendererName;
                                // renderer.querySelector('.error').innerHTML = '';
                            }
                        });

                        media.addEventListener('error', function (e) {
                            renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                        });
                    }
                });
            }
            // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
        },1000);

        // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
        /*var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

        for (i = 0; i < total; i++) {
            new MediaElementPlayer(mediaElements[i], {
                stretching: stretching,
                pluginPath: '../js/build/',
                success: function (media) {
                    var renderer = document.getElementById(media.id + '-rendername');

                    media.addEventListener('loadedmetadata', function () {
                        var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                        if (src !== null && src !== undefined) {
                            renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                            renderer.querySelector('.renderer').innerHTML = media.rendererName;
                            renderer.querySelector('.error').innerHTML = '';
                        }
                    });

                    media.addEventListener('error', function (e) {
                        renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                    });
                }
            });
        }*/
    };
    $scope.addToContact = function (user_id, contact) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                var index = $scope.contactSuggetion.indexOf(contact);
                $('.addtobtn-' + user_id).html('Request Sent');
                $('.addtobtn-' + user_id).attr('style','pointer-events:none;');
                // $('.owl-carousel').trigger('next.owl.carousel');
                if(socket)
                {
                    socket.emit('user notification',user_id);
                }
            }
        }, function (error) {
            setTimeout(function(){
                $scope.addToContact(user_id, contact);
            },500);
        });
    }

    $scope.post_like = function (post_id,parent_index,user_id) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        if($('#post-like-' + post_id).hasClass('like'))
        {
            $('#post-like-' + post_id).removeClass('like');
            var like_cnt = $('#post-like-count-' + post_id).html();
            if(parseInt(like_cnt) - 1 < 1)
            {
                $('#post-like-count-' + post_id).hide();
            }
            else
            {
                $('#post-like-count-' + post_id).html(parseInt(like_cnt) - 1);
            }
        }
        else
        {
            $('#post-like-' + post_id).addClass('like');
            $('#post-like-count-' + post_id).show();
            var like_cnt = $('#post-like-count-' + post_id).html();
            $('#post-like-count-' + post_id).html(parseInt(like_cnt) + 1);

        }
        $('#post-like-' + post_id).attr('style','pointer-events: none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $('#post-like-' + post_id).removeAttr('style');
            if (success.data.message == 1) {
                if(socket)
                {
                    socket.emit('user notification',user_id);
                }
                if (success.data.is_newLike == 1) {
                    $('#post-like-count-' + post_id).show();
                    $('#post-like-' + post_id).addClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                } else if (success.data.is_oldLike == 1) {
                    if(success.data.likePost_count < 1)
                    {                        
                        $('#post-like-count-' + post_id).hide();
                    }
                    else
                    {
                        $('#post-like-count-' + post_id).show();
                    }
                    $('#post-like-' + post_id).removeClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                }
                $scope.postData[parent_index].user_like_list = success.data.user_like_list;
            }
        }, function (error) {
            setTimeout(function(){
                $scope.post_like(post_id,parent_index,user_id);
            },500);
        });
    }

    $scope.cmt_handle_paste = function (e) {        
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");        
        value = value.substring(0,cmt_maxlength);        
        document.execCommand('inserttext', false, value);
    };

    $scope.check_comment_char_count = function(post_id,e){
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8,17,35,36,37,38,39,40,46];

        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if(no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength)
        {
            e.preventDefault();
            return false;
        }
        else
        {
            return true;
        }
    };

    $scope.cmt_handle_paste_edit = function (e) {        
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");        
        value = value.substring(0,cmt_maxlength);        
        document.execCommand('inserttext', false, value);
    };

    $scope.check_comment_char_count_edit = function(cmt_id,e){
        var comment = $('#editCommentTaxBox-' + cmt_id).text();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8,17,35,36,37,38,39,40,46];
        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if(no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength)
        {
            e.preventDefault();
            return false;
        }
        else
        {
            return true;
        }
    };

    $scope.sendComment = function (post_id, index, post) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $("#cmt-btn-mob-"+post_id).attr("style","pointer-events: none;");
            $("#cmt-btn-mob-"+post_id).attr("disabled","disabled");
            $("#cmt-btn-"+post_id).attr("style","pointer-events: none;");
            $("#cmt-btn-"+post_id).attr("disabled","disabled");
            var data = $.param({comment:comment,post_id:post_id});
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: data,//'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[index].post_data.user_id);
                    }
                    if (commentClassName == 'last-comment') {
                        $scope.postData[index].post_comment_data.splice(0, 1);
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function(){
                    $("#cmt-btn-mob-"+post_id).removeAttr("style");
                    $("#cmt-btn-mob-"+post_id).removeAttr("disabled");
                    $("#cmt-btn-"+post_id).removeAttr("style");
                    $("#cmt-btn-"+post_id).removeAttr("disabled");
                    
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
            
                },1000);
            }, function (error) {
                setTimeout(function(){
                    $scope.sendComment(post_id, index, post);
                },500);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.viewAllComment = function (post_id, index, post) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.all_comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                /*$('[data-toggle="popover"]').popover({
                    trigger: "manual" ,
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                        // return $('#popover-content').html();
                    },
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show");
                    $(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide");
                        }
                    }, 100);
                });*/
            },500);
        }, function (error) {
            setTimeout(function(){
                $scope.viewAllComment(post_id, index, post);
            },500);
        });
    }

    $scope.viewLastComment = function (post_id, index, post) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                /*$('[data-toggle="popover"]').popover({
                    trigger: "manual" ,
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                        // return $('#popover-content').html();
                    },
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show");
                    $(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide");
                        }
                    }, 100);
                });*/
            },500);
        }, function (error) {
            setTimeout(function(){
                $scope.viewLastComment(post_id, index, post);
            },500);
        });
    }
    $scope.deletePostComment = function (comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $('#delete_model').modal('show');
    }

    $scope.deleteComment = function (comment_id, post_id, parent_index, index, post) {
        // console.log("comment_id",comment_id);
        // console.log("post_id",post_id);
        // console.log("parent_index",parent_index);
        // console.log("index",index);
        // console.log("post",post);
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        //console.log("commentClassName",commentClassName);
        //return false;
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            } else {
                $scope.postData[parent_index].post_comment_data.splice(index, 1);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
            if(data.comment_count <= 0)
            {
                setTimeout(function(){
                    $(".comment-for-post-"+post_id+" .post-comment").remove();
                },100);
                $(".new-comment-"+post_id).show();                
            }
        }, function (error) {
            setTimeout(function(){
                $scope.deleteComment(comment_id, post_id, parent_index, index, post);
            },500);
        });
    }

    $scope.likePostComment = function (comment_id, post_id,commented_user_id) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            
            if (data.message == '1') {
                if(socket)
                {
                    socket.emit('user notification',commented_user_id);
                }
                if (data.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }

            }
        }, function (error) {
            setTimeout(function(){
                $scope.likePostComment(comment_id, post_id,commented_user_id);
            },500);
        });
    }
    $scope.editPostComment = function (comment_id, post_id, parent_index, index) {
        $(".comment-for-post-"+post_id+" .edit-comment").hide();
        $(".comment-for-post-"+post_id+" .comment-dis-inner").show();
        $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
        $(".comment-for-post-"+post_id+" li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
        $('#edit-comment-' + comment_id).show();
        editContent = editContent.substring(0,cmt_maxlength);
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-"+post_id).hide();
    }

    $scope.edit_post_comment_reply = function (comment_id, post_id, parent_index, cmt_index,cmt_rpl_index) {       
        $(".comment-for-post-"+post_id+" .edit-reply-comment").hide();
        $(".comment-for-post-"+post_id+" li[id^=cancel-reply-comment-li-]").hide();
        $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
        $(".comment-for-post-"+post_id+" li[id^=timeago-reply-comment-li-]").show();
        $(".comment-for-post-"+post_id+" div[id^=comment-reply-dis-inner-]").show();
        $('#edit-comment-li-' + comment_id).hide();
        $('#timeago-reply-comment-li-' + comment_id).hide();

        var editContent = $scope.postData[parent_index].post_comment_data[cmt_index].comment_reply_data[cmt_rpl_index].comment;
        editContent = editContent.substring(0,cmt_maxlength);
        $('#edit-reply-comment-' + comment_id).show();
        $('#edit-comment-reply-textbox-' + comment_id).html(editContent);
        $('#comment-reply-dis-inner-' + comment_id).hide();
        $('#edit-reply-comment-li-' + comment_id).hide();
        $('#cancel-reply-comment-li-' + comment_id).show();
        $(".new-comment-"+post_id).hide();
    }

    $scope.cancel_post_comment_reply = function (comment_id, post_id, parent_index, cmt_index,cmt_rpl_index) {
        $('#edit-comment-li-' + comment_id).show();
        $('#timeago-reply-comment-li-' + comment_id).show();
        $('#edit-reply-comment-' + comment_id).hide();        
        $('#comment-reply-dis-inner-' + comment_id).show();
        $('#edit-reply-comment-li-' + comment_id).show();
        $('#cancel-reply-comment-li-' + comment_id).hide();
        $(".new-comment-"+post_id).show();
    }

    $scope.comment_reply = function(post_index,comment_id,login_user_id,comment_user_id,cmt_reply_obj){
        $scope.comment_reply_data = cmt_reply_obj;
        if(login_user_id == 0 && comment_user_id == 0)
        {
            $("#reply-comment-"+post_index+"-"+comment_id).html('');            
        }
        else
        {
            if(login_user_id == comment_user_id)
            {
                $("#reply-comment-"+post_index+"-"+comment_id).html('');                
            }
            else
            {
                var content = '<a class="mention-'+post_index+'-'+comment_id+'" href="'+base_url+cmt_reply_obj.user_slug+'" data-mention="'+window.btoa(cmt_reply_obj.user_slug)+'">'+cmt_reply_obj.username+'</a>&nbsp;';                
                $("#reply-comment-"+post_index+"-"+comment_id).html(content);
            }
        }
        $("#comment-reply-"+post_index+"-"+comment_id).show();   
    };

    $scope.cancelPostComment = function (comment_id, post_id, parent_index, index) {
        
        $('#edit-comment-' + comment_id).hide();
        
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-"+post_id).show();
    }   

    $scope.sendEditComment = function (comment_id,post_id,user_id) {
        var comment = $('#editCommentTaxBox-' + comment_id).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentUpdate',
                data: 'comment=' + comment + '&comment_id=' + comment_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',user_id);
                    }
                    $('#comment-dis-inner-' + comment_id).show();
                    $('#comment-dis-inner-' + comment_id).html(comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-'+post_id).show();
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.sendEditComment(comment_id,post_id,user_id);
                },500);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.sendCommentReply = function (comment_id,post_id,postIndex,commentIndex) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#reply-comment-'+postIndex+'-'+commentIndex).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        
        var mention = 0;
        var mention_id = 0;

        if($("a.mention-"+postIndex+"-"+commentIndex).data('mention') != undefined && $("a.mention-"+postIndex+"-"+commentIndex).data('mention') != '')
        {
            var cmt_mention = window.atob($("a.mention-"+postIndex+"-"+commentIndex).data('mention'));            
            if(cmt_mention == $scope.comment_reply_data.user_slug){
                mention = 1;
                mention_id = $scope.comment_reply_data.commented_user_id;
            }
        }
        // data: {comment:comment,comment_id:comment_id,post_id:post_id,mention:mention,mention_id:$scope.comment_reply_data.commented_user_id},
        if (comment) {
            $http({
                method: 'POST',
                url: base_url + 'user_post/add_post_comment_reply',
                data: 'comment=' + comment + '&comment_id=' + comment_id + '&post_id=' + post_id + '&mention=' + mention + '&mention_id=' + mention_id+'&comment_reply_id='+$scope.comment_reply_data.comment_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {
                // console.log(success.data);
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[postIndex].post_comment_data[commentIndex].commented_user_id);
                    }
                    if (commentClassName == 'last-comment') {
                        // $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data.splice(commentIndex, 1);
                        $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data = data.comment_reply_data;
                        
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data = data.comment_reply_data;
                        
                        $('.editable_text').html('');
                    }
                    setTimeout(function(){
                        /*$('[data-toggle="popover"]').popover({
                            trigger: "manual" ,
                            html: true, 
                            animation:false,
                            template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                            content: function () {
                                // return $($(this).data('tooltip-content')).html();
                                var uid = $(this).data('uid');
                                var utype = $(this).data('utype');
                                var div_id =  "tmp-id-" + $.now();
                                return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);            
                                // return $('#popover-content').html();
                            },
                            placement: function (context, element) {

                                var $this = $(element);
                                var offset = $this.offset();
                                var width = $this.width();
                                var height = $this.height();

                                var centerX = offset.left + width / 2;
                                var centerY = offset.top + height / 2;
                                var position = $(element).position();
                                
                                if(centerY > $(window).scrollTop())
                                {
                                    scroll_top = $(window).scrollTop();
                                    scroll_center = centerY;
                                }
                                if($(window).scrollTop() > centerY)
                                {
                                    scroll_top = centerY;
                                    scroll_center = $(window).scrollTop();
                                }
                                
                                if (parseInt(scroll_center - scroll_top) < 340){
                                    return "bottom";
                                }                        
                                return "top";
                            }
                        }).on("mouseenter", function () {
                            var _this = this;
                            $(this).popover("show");
                            $(".popover").on("mouseleave", function () {
                                $(_this).popover('hide');
                            });
                        }).on("mouseleave", function () {
                            var _this = this;
                            setTimeout(function () {
                                if (!$(".popover:hover").length) {
                                    $(_this).popover("hide");
                                }
                            }, 100);
                        });*/
                    },500);
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.sendCommentReply(comment_id,post_id,postIndex,commentIndex);
                },500);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.send_edit_comment_reply = function (reply_comment_id,post_id) {
        var comment = $('#edit-comment-reply-textbox-' + reply_comment_id).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $http({
                method: 'POST',
                url: base_url + 'user_post/edit_post_comment_reply',
                data: 'comment=' + comment + '&reply_comment_id=' + reply_comment_id + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success) {                
                data = success.data;
                if (data.message == '1') {
                    $('#comment-reply-dis-inner-' + reply_comment_id).show();
                    $('#comment-reply-dis-inner-' + reply_comment_id).html(comment);
                    $('#edit-comment-reply-textbox-' + reply_comment_id).html();
                    $('#edit-comment-reply-textbox-' + reply_comment_id).hide();
                    $('#edit-comment-li-' + reply_comment_id).show();
                    $('#cancel-reply-comment-li-' + reply_comment_id).hide();
                    $('.new-comment-'+post_id).show();
                }                
            }, function (error) {
                setTimeout(function(){
                    $scope.send_edit_comment_reply(reply_comment_id,post_id);
                },500);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.deletePost = function (post_id, index) {
        if(user_id != "")
        {            
            $scope.p_d_post_id = post_id;
            $scope.p_d_index = index;
            $('#delete_post_model').modal('show');
        }
        else
        {
            $('#regmodal').modal('show');   
        }
    }
    $scope.deletedPost = function (post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (data.message == '1') {
                //$scope.postData.splice(index, 1);
                getUserDashboardVideo();
                getUserDashboardAudio();            
                getUserDashboardPdf();
                getUserDashboardImage();
                getUserDashboardPost();
                $scope.get_all_counter();
            }
        }, function (error) {
            setTimeout(function(){
                $scope.deletedPost(post_id, index);
            },500);
        });
    }

    /*function check_no_post_data() {
        var numberPost = $scope.postData.length;
        if (numberPost == 0) {
            $('.all_user_post').html(no_user_post_html);
        }
    }*/

    $scope.l_page = 0;
    $scope.l_total_record = 0;
    $scope.l_perpage = 7;
    
    $scope.like_post_id = 0;
    
    $scope.like_user_list = function (post_id) {
        $scope.like_post_id = post_id;
        pagenum = 1;
        
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id + '&pagenum='+pagenum,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            if(success.data.countlike > 0)
            {
                $scope.l_page = success.data.page;
                $scope.l_total_record = success.data.countlike;
                $('#likeusermodal').modal('show');
                setTimeout(function(){
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },500);
            }
        }, function (error) {
            setTimeout(function(){
                $scope.like_user_list(post_id);
            },500);
        });
    }

    var is_processing = false;

    $scope.like_user_list_loadmore = function(post_id,pagenum) {
        if(is_processing)
        {
            return false;
        }
        is_processing = true;
        $('#like_loader').show();
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id + '&pagenum='+pagenum,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $('#like_loader').hide();
            if(success.data.likeuserlist)
            {
                for (var i in success.data.likeuserlist) {
                    $scope.get_like_user_list.push(success.data.likeuserlist[i]);
                }

                $scope.l_page = success.data.page;
                $scope.l_total_record = success.data.countlike;
                
                setTimeout(function(){
                    /*$('[data-toggle="popover"]').popover({
                        trigger: "manual" ,
                        html: true, 
                        animation:false,
                        template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        content: function () {
                            // return $($(this).data('tooltip-content')).html();
                            var uid = $(this).data('uid');
                            var utype = $(this).data('utype');
                            var div_id =  "tmp-id-" + $.now();
                            return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                            // return $('#popover-content').html();
                        },
                        placement: function (context, element) {

                            var $this = $(element);
                            var offset = $this.offset();
                            var width = $this.width();
                            var height = $this.height();

                            var centerX = offset.left + width / 2;
                            var centerY = offset.top + height / 2;
                            var position = $(element).position();
                            
                            if(centerY > $(window).scrollTop())
                            {
                                scroll_top = $(window).scrollTop();
                                scroll_center = centerY;
                            }
                            if($(window).scrollTop() > centerY)
                            {
                                scroll_top = centerY;
                                scroll_center = $(window).scrollTop();
                            }
                            
                            if (parseInt(scroll_center - scroll_top) < 340){
                                return "bottom";
                            }                        
                            return "top";
                        }
                    }).on("mouseenter", function () {
                        var _this = this;
                        $(this).popover("show");
                        $(".popover").on("mouseleave", function () {
                            $(_this).popover('hide');
                        });
                    }).on("mouseleave", function () {
                        var _this = this;
                        setTimeout(function () {
                            if (!$(".popover:hover").length) {
                                $(_this).popover("hide");
                            }
                        }, 100);
                    });*/
                },500);
                is_processing = false;
            }
            
        });
    }

    $('.like-popup-scroll').on('scroll', function () {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            var page = $scope.l_page;
            var total_record = $scope.l_total_record;
            var perpage_record = $scope.l_perpage;
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.l_page) + 1;
                    $scope.like_user_list_loadmore($scope.like_post_id,pagenum);
                }
            }
        }
    });
    scopeHold = $scope;

    $('input:radio[name="report_spam"]').change(function(){
        if($(this).val() == '0'){
           $("#report_other").show();
        }
        else
        {
            $("#report_other").hide();   
        }
    });
    $scope.report_post_id = 0;
    $scope.open_report_spam = function(post_id){
        $scope.report_post_id = post_id;
        $("#report_spam_form")[0].reset();
        $("#report-spam").modal('show');
    };

    $scope.report_spam_validate = {
        rules: {           
            report_spam: {
                required: true,
            },
            other_report_spam: {
                required: {
                    depends: function(element) {
                        return $("input[name='report_spam']:checked").val() == 0 ? true : false;
                    }
                },
            },
        },
        messages: {
            report_spam: {
                required: "Select Report",
            },
            other_report_spam: {
                required: "Enter Other Report",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "report_spam") {
                error.appendTo($("#err_report"));
            } else {
                error.insertAfter(element);
            }
        },
    };
    $scope.save_report_spam = function(){
        if ($scope.report_spam_form.validate()) {

            $("#save_report_spam").attr("style","pointer-events:none;display:none;");
            $("#save_report_spam_loader").show();

            var reported_post_id = $scope.report_post_id;            
            var reported_reason = $("input[name='report_spam']:checked").val();
            var reported_reason_other = $("#other_report_spam").val();
            var updatedata = $.param({'reported_post_id':reported_post_id,'reported_reason':reported_reason,'reported_reason_other':reported_reason_other});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/save_report_spam',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {
                // $('#main_page_load').show();                
                success = result.data.success;
                $("#report_spam_form")[0].reset();                
                if(success == 1)
                {
                    
                }
                $("#save_report_spam").removeAttr("style");
                $("#save_report_spam_loader").hide();
                $("#report-spam").modal('hide');
            }, function (error) {
                setTimeout(function(){
                    $scope.save_report_spam();
                },500);
            });
        }
    };

    function getUserSavedPost(pagenum) {
        /*if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
            if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }*/
            
        $('#loader').show();
        $http.get(base_url + "user_post/getUserSavedPost?page=" + pagenum + "&user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            $scope.postData = success.data;
            $('#progress_div').hide();
            $('.progress-bar').css("width",0);
            $('.sr-only').text(0+"%");
            // check_no_post_data();
            setTimeout(function(){
                var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

                for (i = 0; i < total; i++) {
                    if($(mediaElements[i])[0].id == '')
                    {                        
                        new MediaElementPlayer(mediaElements[i], {
                            stretching: 'auto',
                            pluginPath: '../../../build/',
                            success: function (media) {
                                var renderer = document.getElementById(media.id + '-rendername');

                                media.addEventListener('loadedmetadata', function () {
                                    var src = media.originalNode.getAttribute('src').replace('&amp;', '&');
                                    if (src !== null && src !== undefined) {
                                        // renderer.querySelector('.src').innerHTML = '<a href="' + src + '" target="_blank">' + src + '</a>';
                                        // renderer.querySelector('.renderer').innerHTML = media.rendererName;
                                        // renderer.querySelector('.error').innerHTML = '';
                                    }
                                });

                                media.addEventListener('error', function (e) {
                                    renderer.querySelector('.error').innerHTML = '<strong>Error</strong>: ' + e.message;
                                });
                            }
                        });
                    }
                }
                // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
            },1000);
            setTimeout(function(){
                var originalLeave = $.fn.popover.Constructor.prototype.leave;
                $.fn.popover.Constructor.prototype.leave = function(obj){
                    var self = obj instanceof this.constructor ?
                    obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
                    var container, timeout;

                    originalLeave.call(this, obj);

                    if(obj.currentTarget) {
                        container = $(obj.currentTarget).siblings('.popover')
                        timeout = self.timeout;
                        container.one('mouseenter', function(){
                            //We entered the actual popover – call off the dogs
                            clearTimeout(timeout);
                            //Let's monitor popover content instead
                            container.one('mouseleave', function(){
                                $.fn.popover.Constructor.prototype.leave.call(self, self);
                            });
                        })
                    }
                };

                $('body').popover({
                    selector: '[data-popover]',
                    animation: true,
                    trigger: "click hover" ,
                    delay: {show: 1000, hide: 50},
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        // console.log($(this).data('tooltip-url'));
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);//$(this).data('tooltip-url'),div_id);
                        // return $('#popover-content').html();
                    },
                    // placement: 'auto',
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                });
                /*$('[data-toggle="popover"]').popover({
                    trigger: "manual" ,
                    html: true, 
                    animation:false,
                    template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                    content: function () {
                        // return $($(this).data('tooltip-content')).html();
                        var uid = $(this).data('uid');
                        var utype = $(this).data('utype');
                        var div_id =  "tmp-id-" + $.now();
                        return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);
                        // return $('#popover-content').html();
                    },
                    placement: function (context, element) {

                        var $this = $(element);
                        var offset = $this.offset();
                        var width = $this.width();
                        var height = $this.height();

                        var centerX = offset.left + width / 2;
                        var centerY = offset.top + height / 2;
                        var position = $(element).position();
                        
                        if(centerY > $(window).scrollTop())
                        {
                            scroll_top = $(window).scrollTop();
                            scroll_center = centerY;
                        }
                        if($(window).scrollTop() > centerY)
                        {
                            scroll_top = centerY;
                            scroll_center = $(window).scrollTop();
                        }
                        
                        if (parseInt(scroll_center - scroll_top) < 340){
                            return "bottom";
                        }                        
                        return "top";
                    }
                }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show");
                    $(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide");
                        }
                    }, 100);
                });*/
            },500);
        }, function (error) {
            setTimeout(function(){
                $scope.getUserSavedPost(pagenum);
            },500);
        });
    }
    if($scope.$parent.live_slug != $scope.$parent.segment2)
    {
        window.location = base_url+$scope.$parent.segment2;
    }
    else
    {
        $scope.get_all_counter();
        getUserSavedPost();
    }

    $scope.unsave_post = function(post_id,index,postData){
        $('#unsave-post-' + post_id).attr('style','pointer-events: none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/unsave_user_post',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            var result = success.data;
            if(result.status == '1')
            {
                $scope.postData[index].is_user_saved_post = 0;                
            }
            else
            {
                $scope.postData[index].is_user_saved_post = result.status;
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
                if(result.savedpost_counter == '0')
                {
                    $scope.postData = [];
                }
            }
            else
            {
                $scope.postData = [];
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }
        }, function (error) {
            setTimeout(function(){
                $scope.unsave_post(post_id,index,postData);
            },500);
        });
    };

    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];        
        $scope.post_index = index;
        $("#post-share").modal("show");

        setTimeout(function(){            
            autosize(document.getElementsByClassName('hashtag-textarea'));
        },300);
    };

    $scope.share_post_fnc = function(post_index){        
        $('.post-popup-box').attr('style','pointer-events: none;');
        var description = $("#share_post_text").val();
        var post_id = 0;
        if($scope.share_post_data.post_data.post_for == 'share')
        {
            post_id = $scope.share_post_data.share_data.data.post_data.id;
        }
        else
        {
            post_id = $scope.share_post_data.post_data.id;
        }

        $http({
            method: 'POST',
            url: base_url + 'user_post/save_user_post_share',
            data: 'post_id='+post_id+'&description='+description,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            var result = success.data;            
            setTimeout(function(){
                $('#post-share').modal('hide');
                $("#share_post_text").val('');
            },100);
            if(result.status == '1')
            {
                if(socket)
                {
                    socket.emit('user notification',$scope.postData[post_index].post_data.user_id);
                }
                $('.biderror .mes').html("<div class='pop_content'>Post Shared Successfully.");
                $('#posterrormodal').modal('show');
                $scope.postData[post_index].post_share_count = result.post_share_count;
            }
            else
            {
                $('.biderror .mes').html("<div class='pop_content'>Please Try Again.");
                $('#posterrormodal').modal('show');
            }
            $('.post-popup-box').attr('style','pointer-events: all;');
        }, function (error) {
            setTimeout(function(){
                $scope.share_post_fnc(post_index);
            },500);
        });
    };
});
app.controller('monetizationController', function ($scope,$http,$location,$compile,$window){
    // $('#main_loader').hide();
    $('footer').hide();
    // alert($scope.$parent.segment2);

    $scope.get_all_counter = function() {
        if($scope.$parent.pade_reload == true)
        {
            $('#main_loader').show();
        }
        $http.get(base_url + "userprofile_page/get_all_counter?user_slug="+user_slug).then(function (success) {
            var result = success.data;
            $('#main_loader').hide();
            $('body').removeClass("body-loader");
            if(result.dashboard_counter != '')
            {
                $('.dashboard_counter').show();
                $('.dashboard_counter').html(result.dashboard_counter);
            }
            else
            {
                //$('.dashboard_counter').hide();
                $('.dashboard_counter').html('0');
            }

            if(result.detail_counter > 0)
            {
                $('.detail_counter').show();
                $('.detail_counter').html(result.detail_counter+'%');
            }
            else
            {
                //$('.detail_counter').hide();
                $('.detail_counter').html('0%');
            }

            if(result.contact_counter != '')
            {
                $('.contact_counter').show();
                $('.contact_counter').html(result.contact_counter);
            }
            else
            {
                //$('.contact_counter').hide();
                $('.contact_counter').html('0');
            }

            if(result.follower_counter != '')
            {
                $('.follower_counter').show();
                $('.follower_counter').html(result.follower_counter);
            }
            else
            {
                //$('.follower_counter').hide();
                $('.follower_counter').html('0');
            }

            if(result.following_counter != '')
            {
                $('.following_counter').show();
                $('.following_counter').html(result.following_counter);
            }
            else
            {
                //$('.following_counter').hide();
                $('.following_counter').html('0');
            }

            if(result.question_counter != '')
            {
                $('.question_counter').show();
                $('.question_counter').html(result.question_counter);
            }
            else
            {
                //$('.question_counter').hide();
                $('.question_counter').html('0');
            }

            if(result.savedpost_counter != '')
            {
                $('.savedpost_counter').show();
                $('.savedpost_counter').html(result.savedpost_counter);
            }
            else
            {
                //$('.savedpost_counter').hide();
                $('.savedpost_counter').html('0');
            }

            if(result.monetize_earn != '')
            {
                $('.monetize_earn').show();
                $('.monetize_earn').html(result.monetize_earn);
            }
            else
            {
                //$('.monetize_earn').hide();
                $('.monetize_earn').html('0');
            }
            
        }, function (error) {
            setTimeout(function(){
                $scope.get_all_counter();
            },500);
        });
    }    

    $scope.get_user_monetize = function(){
        $http({
            method: 'POST',
            url: base_url + 'user_post/get_user_monetize',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            var result = success.data;            
            if(result)
            {
                $scope.total_earn = result.total_earn;
                $scope.total_points = result.total_points;                
                var earn_points_process_value = parseFloat($scope.total_points) / 10;
                var earn_process_value = parseFloat($scope.total_earn);            
            }
            else
            {
                $scope.total_earn = '0';
                $scope.total_points = '0';                
                var earn_points_process_value = 0;
                var earn_process_value = 0;
            }
            $scope.payment_history = result.payment_history;
            $scope.user_bank_detail = result.user_bank_detail;
            if($scope.user_bank_detail)
            {                
                $scope.bank_name = $scope.user_bank_detail.bank_name;
                $scope.bank_ac_holder_name = $scope.user_bank_detail.bank_ac_holder_name;
                $scope.bank_ac_number = $scope.user_bank_detail.bank_ac_number;
                $scope.bank_ifsc = $scope.user_bank_detail.bank_ifsc;
                $scope.bank_swift = $scope.user_bank_detail.bank_swift;
                $scope.country_code = $scope.user_bank_detail.country_code;
                $scope.contact_number = $scope.user_bank_detail.contact_number;
            }

            $('.progress').circleProgress({
                // value: 0.1 //with decimal point
            }).on('circle-animation-progress', function(event, progress) {
                $('.progress-bar-custom').width(Math.round(earn_points_process_value * progress)+'%');
                if(earn_process_value >= 1)
                {
                    $('.progress-bar-custom span .val').html('$'+(earn_process_value * progress));
                }
            })
        }, function (error) {
            setTimeout(function(){
                $scope.get_user_monetize();
            },500);
        });
    };
    if($scope.$parent.live_slug != $scope.$parent.segment2)
    {
        window.location = base_url+$scope.$parent.segment2;
    }
    else
    {
        $scope.get_all_counter();
        $scope.get_user_monetize();
    }

    $scope.tab = 1;

    $scope.setTab = function(newTab){
      $scope.tab = newTab;
    };

    $scope.isSet = function(tabNum){
      return $scope.tab === tabNum;
    };

    $scope.check_payment_detail = function(){
        if($scope.total_earn < 10)
        {
            // $('.biderror .mes').html("<div class='pop_content'>You must reach $10 to add payment detail.</div>");
            // $('#posterrormodal').modal('show');
        }
        else
        {
            $scope.payment_detail = 1;
        }
    };

    $scope.bank_info_validate = {
        // errorElement: 'span',
        rules: {
            bank_name: {
                required: true,
                maxlength: 200,
            },
            bank_ac_holder_name: {
                required: true,
                maxlength: 200,
            },
            bank_ac_number: {
                required: true,
                maxlength: 200,
            },
            bank_ac_re_number: {
                required: true,
                maxlength: 200,
                equalTo: "#bank_ac_number"
            },
            bank_ifsc: {
                required: true,
                maxlength: 50,
            },
            bank_swift: {
                required: true,
                maxlength: 50,
            },
            country_code: {
                required: true,
                maxlength: 4,
            },
            contact_number: {
                required: true,
                maxlength: 50,
            }
        },
        messages: {
            bank_name: {
                required: "Bank name is required.",
            },
            bank_ac_holder_name: {
                required: "Bank account holder name is required.",
            },
            bank_ac_number: {
                required: "Bank account number is required.",
            },
            bank_ac_re_number: {
                required: "Bank account number is required.",
            },
            bank_ifsc: {
                required: "Bank IFSC code is required.",
            },
            bank_swift: {
                required: "Bank swift bic is required.",
            },
            country_code: {
                required: "Country code is required.",
            },
            contact_number: {
                required: "Contact number is required.",
            }
        }
    };
    $scope.submit_bank_info = function () {
        if ($scope.bank_detail.validate())
        {
            angular.element('#bank_detail #submit').addClass("form_submit");
            $('#bank_info_ajax_load').show();
            var updatedata = $.param({'bank_name':$scope.bank_name,'bank_ac_holder_name':$scope.bank_ac_holder_name,'bank_ac_number':$scope.bank_ac_number,'bank_ifsc':$scope.bank_ifsc,'bank_swift':$scope.bank_swift,'country_code':$scope.country_code,'contact_number':$scope.contact_number});
            $http({
                method: 'POST',
                url: base_url + 'user_post/save_user_bank_detail',
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (success){
                $('#bank_info_ajax_load').hide();                
                if (success.data.status == 1) {
                    $("#posterrormodal .modal-body .mes").addClass("bank-detail-msg");
                    $("#posterrormodal .modal-body .mes").html("Bank detail changes successfully.");
                    $("#posterrormodal").modal('show');
                    /*$("#success-bankinfo").show();
                    $("#success-bankinfo").html("Bank detail changes successfully.")
                    $("#success-bankinfo").fadeOut(5000);*/
                } else {
                    
                }
            }, function (error) {
                setTimeout(function(){
                    $scope.submit_bank_info();
                },500);
            });
        }
        else
        {
            return false;
        }
    };

});

function remove_contacts(index) {
    $.ajax({
        url: base_url + "userprofile_page/removeContacts",
        dataType: 'json',
        type: "POST",
        data: {"id": index},
        success: function (data) {
            if (data.response == 1) {
                $('#' + index).closest('.custom-user-box').fadeToggle();
                if (data.contactcount == '1') {
                    $("#nocontact").html("<div class='art-img-nn'><div class='art_no_post_img'><img src='assets/img/icon_notification_big.png' alt='notification image'></div><div class='art_no_post_text'>No Contacts Available. </div></div>");
                }
            }
        }
    });
}
function unfollowing_contacts(index) {
    $.ajax({
        url: base_url + "userprofile_page/unfollowingContacts",
        dataType: 'json',
        type: "POST",
        data: {"id": index},
        success: function (data) {
            if (data.response == 1) {
                $('#' + index).closest('.custom-user-box').fadeToggle();

            }
        }
    });
}
$uploadCrop1 = $('#upload-demo-one').croppie({
                    enableExif: true,
                    viewport: {
                        width: 200,
                        height: 200,
                        type: 'square'
                    },
                    boundary: {
                        width: 300,
                        height: 300
                    }
                });
var fileTypes = ['jpg', 'jpeg', 'png']; 
$('#upload-one').on('change', function () {

    if (this.files && this.files[0]) {
        var extension = this.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
        isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types
            if (isSuccess)
            {
                document.getElementById('upload-demo-one').style.display = 'block';
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    
                    $uploadCrop1.croppie('bind', {
                        url: e.target.result
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
            }
            else
            {
                $("#userimage")[0].reset();
                if($uploadCrop1 != "")
                {
                    $uploadCrop1.croppie('bind', {
                        url: ""
                    });
                    document.getElementById('upload-demo-one').style.display = 'none';
                }
                alert("Select only JPG,JPEG,PNG");
            }
        }
});
$("#userimage").validate({
    rules: {
        profilepic: {
            required: true,
        },
    },
    messages: {
        profilepic: {
            required: "Photo Required",
        },
    },
    submitHandler: profile_pic
});
function profile_pic() {
    $uploadCrop1.croppie('result', {
        /*type: 'canvas',
        size: 'viewport'*/
        type: 'canvas',
        size: { width: 450, height: 450 }
    }).then(function (resp) {
        $.ajax({
            url: base_url + "userprofile_page/user_profile_pic_update",
            type: "POST",
            data: {"image": resp},
            beforeSend: function () {
                $('#profi_loader').show();
            },
            complete: function () {
            },
            success: function (data) {
                var res = JSON.parse(data);
                $('#profi_loader').hide();
                $('#bidmodal-2').modal('hide');
                $("#user-profile.profile-img").html(res.userImageContent);
                $("#view-profile-img .modal-body .mes img").attr('src',res.userProfilePicMain);
                $("#header-main-profile-pic").html('<img ng-src="'+res.userProfilePicThumb+'" src="'+res.userProfilePicThumb+'">');
                if(!$("#header-main-profile-pic").hasClass("profile-brd"))
                {
                    $("#header-main-profile-pic").addClass("profile-brd");
                }
                $(".login-user-pro-pic").attr('src',res.userProfilePicThumb);

                scopeHold.dashboardPhotosAfterDPUpload();

                document.getElementById('upload-one').value = null;
                document.getElementById('upload-demo-one').value = '';
            }
        });
    });
}

function updateprofilepopup(id) {
    document.getElementById('upload-demo-one').style.display = 'none';
    document.getElementById('profi_loader').style.display = 'none';
    document.getElementById('upload-one').value = null;
    $('#bidmodal-2').modal('show');
}
function myFunction() {

    document.getElementById("upload-demo").style.visibility = "hidden";
    document.getElementById("upload-demo-i").style.visibility = "hidden";
    document.getElementById('message1').style.display = "block";
}
function showDiv() {

    document.getElementById('row1').style.display = "block";
    document.getElementById('row2').style.display = "none";
    $(".cr-image").attr("src", "");
    $("#upload").val('');
}

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('.cr-image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 1250,
        height: 350,
        type: 'square'
    },
    boundary: {
        width: 1250,
        height: 350
    }
});
   
$('.upload-result').on('click', function (ev) {

    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {
    	//console.log(resp);return false;
        $.ajax({
            url: base_url + "userprofile_page/ajaxpro",
            type: "POST",
            data: {"image": resp},
            success: function (result) {
                if (result) {
                	data = JSON.parse(result);                	
                	//console.log(data.cover_image);
                    $("#row2").html(data.cover);
                    $("#view-cover-img #image_src").attr("src",data.cover_image);
                    document.getElementById('row2').style.display = "block";
                    document.getElementById('row1').style.display = "none";
                    document.getElementById('message1').style.display = "none";
                    document.getElementById("upload-demo").style.visibility = "visible";
                    document.getElementById("upload-demo-i").style.visibility = "visible";
                    scopeHold.dashboardPhotosAfterDPUpload();
                }
            }
        });
    });
});
$('.cancel-result').on('click', function (ev) {

    document.getElementById('row2').style.display = "block";
    document.getElementById('row1').style.display = "none";
    document.getElementById('message1').style.display = "none";
    $(".cr-image").attr("src", "");
});
$(document).on('change','#upload', function(){

    var reader = new FileReader();
    reader.onload = function (e) {
        $uploadCrop.croppie('bind', {
            url: e.target.result
        }).then(function () {
            console.log('jQuery bind complete');
        });
    }
    reader.readAsDataURL(this.files[0]);
});
//$('#upload').on('change', function () {
$(document).on('change','#upload', function(){

    var fd = new FormData();
    fd.append("image", $("#upload")[0].files[0]);
    files = this.files;
    size = files[0].size;
    if (!files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
        picpopup();
        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        return false;
    }
    if (size > 26214400)
    {
        alert("Allowed file size exceeded. (Max. 25 MB)")
        document.getElementById('row1').style.display = "none";
        document.getElementById('row2').style.display = "block";
        return false;
    }
    $.ajax({

            url: base_url + "dashboard/image",
            //url: "<?php echo base_url(); ?>artist/image",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {
            }
        });
});

$(document).on('click','.post-opportunity-modal, .post-ask-question-modal', function(){
    $('#post-popup').modal('toggle');
});
$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});
$(document).click(function(){
    $('.right-header ul.dropdown-menu').hide();
});
function setCursotToEnd(el)
{
    el.focus();
    if (typeof window.getSelection != "undefined"
            && typeof document.createRange != "undefined") {
        var range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(false);
        textRange.select();
    }
}

function follow_user(id)
{
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $(".follow-btn-user-" + uid.slice(0, -6) + ' a').html('Following');
    $.ajax({
        url: base_url + "userprofile_page/follow_user_tooltip",        
        type: "POST",
        data: 'to_id=' + uid + '&ele_id=' + id,
        success: function (data) {            
            $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-user-" + uid.slice(0, -6)).html(data);
            },500);
        }
    });
}

function unfollow_user(id) {
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $(".follow-btn-user-" + uid.slice(0, -6) + ' a').html('Follow');
    $.ajax({
        url: base_url + "userprofile_page/unfollow_user_tooltip",        
        type: "POST",
        data: 'to_id=' + uid + '&ele_id=' + id,
        success: function (data) {            
            $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-user-" + uid.slice(0, -6)).html(data);
            },500);
        }
    });
}

function follow_user_bus(id)
{
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-bus-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $(".follow-btn-bus-" + uid.slice(0, -6) + ' a').html('Following');
    $.ajax({
        url: base_url + "userprofile_page/business_follow_tooltip",        
        type: "POST",
        data: 'to_id=' + uid + '&ele_id=' + id,
        success: function (data) {            
            $(".follow-btn-bus-" + uid.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-bus-" + uid.slice(0, -6)).html(data);
            },500);
        }
    });
}

function unfollow_user_bus(id) {
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-bus-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $(".follow-btn-bus-" + uid.slice(0, -6) + ' a').html('Follow');
    $.ajax({
        url: base_url + "userprofile_page/business_unfollow_tooltip",        
        type: "POST",
        data: 'to_id=' + uid + '&ele_id=' + id,
        success: function (data) {            
            $(".follow-btn-bus-" + uid.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-bus-" + uid.slice(0, -6)).html(data);
            },500);
        }
    });
}

function contact(elid)
{
    var params = $("#"+elid).data('param').split(",");
    var id = params[0];
    var status = params[1];
    var to_id = params[2];
    var indexCon = params[3];
    var confirm = params[4];

    
    $(".contact-btn-"+to_id.slice(0, -6)).attr('style','pointer-events:none;');

    $.ajax({
        url: base_url + "userprofile_page/addToContactNewTooltip",        
        type: "POST",
        data: 'contact_id='+id+'&status='+status+'&to_id='+to_id+'&indexCon='+indexCon+'&elid='+elid,
        dataType:"JSON",
        success: function (data) {            
            $(".contact-btn-"+to_id.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".contact-btn-"+to_id.slice(0, -6)).html(data.button);
            },500);
        }
    });
}