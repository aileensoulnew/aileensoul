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
                

                if (text.length > maxLength) {
                    // split the text in two parts, the first always showing

                    if(/^\<a.*\>.*\<\/a\>/i.test(text))
                    {
                        var start = text.indexOf("<a href");
                        var end = text.indexOf('target="_blank">');
                        element.append(text);
                    }
                    else
                    {
                        var firstPart = String(text).substring(0, maxLength);                    
                        var secondPart = String(text).substring(maxLength, text.length);                    

                        // create some new html elements to hold the separate info
                        var firstSpan = $compile('<span>' + firstPart + '</span>')(scope);
                        var secondSpan = $compile('<span ng-if="collapsed">' + secondPart + '</span>')(scope);
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

                if (text.length > maxLength) {
                    // split the text in two parts, the first always showing
                    var firstPart = String(text).substring(0, maxLength);
                    var secondPart = String(text).substring(maxLength, text.length);

                    // create some new html elements to hold the separate info
                    var firstSpan = $compile('<span>' + firstPart + '</span>')(scope);
                    var secondSpan = $compile('<span ng-if="collapsed">' + secondPart + '</span>')(scope);
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
                            items: 2
                        },
                        600: {
                            items: 2
                        },
                        960: {
                            items: 2,
                        },
                        1200: {
                            items: 2
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

// AUTO SCROLL MESSAGE DIV FIRST TIME END
app.directive('ngEnter', function () {          // custom directive for sending message on enter click
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
app.controller('userRecProfileController', function ($scope, $http, $location,$compile) {
    var all_months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $scope.user = {};
    $scope.$parent.title = "Details | Aileensoul";
    $scope.rec_skills_list = [];
    // $scope.old_count_profile = 0;
    $scope.user_id = user_id;
    // $scope.live_slug = live_slug;    
    // $scope.user_slug = user_data_slug;    
    // $scope.segment2 = segment2;

    function load_add_detail()
    {
        setTimeout(function(){
            var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo(".dtl-adv");
            $compile($el)($scope);
        },1000);        
    }

    //Recruiter Basic Info Start
    $scope.get_rec_basic_info = function(){
        var userdata = $.param({'user_id': user_id});
        $http({
            method: 'POST',
            url: base_url + 'recruiter/get_rec_basic_info',            
            data: userdata,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.rec_basic_info = result.data.recruiter_data;
                if($scope.rec_basic_info.rec_skills_txt != '')
                {
                    $scope.rec_skills_list = $scope.rec_basic_info.rec_skills_txt.split(',');
                }
                $("#rec-info-loader").hide();
                $("#rec-info-body").show();                               
            }
            var profile_progress = result.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            $scope.set_progress(count_profile_value,count_profile);
            load_add_detail();
        });
    };
    $scope.get_rec_basic_info();

    $scope.rec_other_field_fnc = function()
    {
        if($scope.rec_field == 0 && $scope.rec_field != "")
        {
            $("#rec_other_field_div").show();
        }
        else
        {
            $("#rec_other_field_div").hide();
        }
    };

    $scope.rec_job_title_list = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchJobTitleStart',
            data: 'q=' + $scope.rec_jotitle,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            data = success.data;
            $scope.titleSearchResult = data;
        });
    };

    $scope.edit_rec_basic_info = function(){
        $("#rec_firstname").val($scope.rec_basic_info.rec_firstname);
        $("#rec_lastname").val($scope.rec_basic_info.rec_lastname);
        $("#rec_jotitle").val($scope.rec_basic_info.title_name);
        $("#rec_field").val($scope.rec_basic_info.rec_field);
        $scope.rec_field = $scope.rec_basic_info.rec_field;
        if($scope.rec_basic_info.rec_field == 0)
        {
            $("#rec_other_field_div").show();
            $("#rec_other_field").val($scope.rec_basic_info.rec_other_field);
        }
        var rec_skills = "";
        if($scope.rec_basic_info.rec_skills_txt.trim() != "")
        {
            var rec_skills = $scope.rec_basic_info.rec_skills_txt.split(',');
        }
        var edit_rec_skills = [];
        if(rec_skills.length > 0)
        {                    
            rec_skills.forEach(function(element,cityIndex) {
              edit_rec_skills[cityIndex] = {"name":element};
            });
        }
        $scope.rec_skill_list = edit_rec_skills;
        
        $("#rec_role_res").val($scope.rec_basic_info.rec_role_res);
        $("#rec_hire_level").val($scope.rec_basic_info.rec_hire_level);
        $("#rec_exp_year").val($scope.rec_basic_info.rec_exp_year);
        $("#rec_exp_month").val($scope.rec_basic_info.rec_exp_month);
    };

    $scope.load_skills = [];
    $scope.loadSkills = function ($query) {
        return $http.get(base_url + 'userprofile_page/get_skills', {cache: true}).then(function (response) {
            var load_skills = response.data;
            return load_skills.filter(function (title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.rec_info_validate = {
        rules: {
            rec_firstname: {
                required: true,
            },
            rec_lastname: {
                required: true,
            },            
            rec_jotitle: {
                required: true,
            },
            rec_field: {
                required: true,
            },
            rec_other_field: {
                required: {
                    depends: function(element) {
                        return $("#rec_field option:selected").val() == 0 ? true : false;
                    }
                },
            },
            rec_role_res: {
                required: true,
            },
            rec_hire_level: {
                required: true,
            },
            rec_exp_year: {
                required: true,
            },
            rec_exp_month: {
                required: true,
            },
        },
        messages: {
            rec_firstname: {
                required: "Please enter first name",
            },
            rec_lastname: {
                required: "Please enter last name",
            },
            rec_jotitle: {
                required: "Please enter job title",
            },
            rec_field: {
                required: "Please select field",
            },
            rec_role_res: {
                required: "Please enter role and responsibilities",
            },
            rec_hire_level: {
                required: "Please select hired levels",
            },
            rec_exp_year: {
                required: "Please select experience",
            },
            rec_exp_month: {
                required: "Please select experience",
            },
        },
    };
    $scope.validate_rec_skills = function(){        
        if($scope.rec_skill_list == "" || $scope.rec_skill_list == undefined)
        {
            $("#rec_skill_list .tags").attr("style","border:1px solid #ff0000;");
            setTimeout(function(){
                $("#rec_skill_err").attr("style","display:block;");            
            },100);
            return false;
        }
        else
        {
            return true;
        }
    };
    $scope.rec_skills_fnc = function(){
        // $("#exp_designation input").removeClass("error");
        $("#rec_skill_list .tags").removeAttr("style");
        $("#rec_skill_err").attr("style","display:none;");
    };
    $scope.save_rec_info = function(){
        var rec_skills = $scope.validate_rec_skills();
        if ($scope.rec_info_form.validate() && rec_skills)
        {
            $("#rec_info_loader").show();
            $("#save_rec_info").attr("style","pointer-events:none;display:none;");
            
            var rec_firstname = $("#rec_firstname").val();
            var rec_lastname = $("#rec_lastname").val();
            var rec_jotitle = $("#rec_jotitle").val();
            var rec_field = $scope.rec_field;
            var rec_other_field = $("#rec_other_field").val();
            var rec_skill_list = $scope.rec_skill_list;
            var rec_role_res = $("#rec_role_res").val();
            var rec_hire_level = $('#rec_hire_level option:selected').val();
            var rec_exp_year = $('#rec_exp_year option:selected').val();
            var rec_exp_month = $('#rec_exp_month option:selected').val();

            var updatedata = $.param({'rec_firstname':rec_firstname,'rec_lastname':rec_lastname,'rec_jotitle':rec_jotitle,'rec_field':rec_field,'rec_other_field':rec_other_field,'rec_skill_list':rec_skill_list,"rec_role_res":rec_role_res,"rec_hire_level":rec_hire_level,"rec_exp_year":rec_exp_year,"rec_exp_month":rec_exp_month});
            $http({
                method: 'POST',
                url: base_url + 'recruiter/save_rec_info',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {
                    $scope.rec_basic_info = result.data.recruiter_data;
                    $(".job-menu-profile a h3").html($scope.rec_basic_info.rec_firstname+' '+$scope.rec_basic_info.rec_lastname)
                }
                $("#save_rec_info").removeAttr("style");
                $("#rec_info_loader").hide();
                $("#job-basic-info").modal('hide');
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
            });
        }
    };
    //Recruiter Basic Info End

    //Recruiter Company Start
    $scope.get_country = function () {
        $http({
            method: 'GET',
            url: base_url + 'userprofile_page/get_country',
            headers: {'Content-Type': 'application/json'},
        }).then(function (data) {
            $scope.rec_country_list = data.data;
        });
    };
    $scope.get_country();

    $scope.re_comp_country_change = function() {
        $("#re_comp_state").attr("disabled","disabled");
        $("#re_comp_state_loader").show();
        var counrtydata = $.param({'country_id': $scope.re_comp_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#re_comp_state").removeAttr("disabled");
            $("#re_comp_city").attr("disabled","disabled");
            $("#re_comp_state_loader").hide();
            $scope.re_comp_state_list = data.data;
            $scope.re_comp_city_list = [];
        });
    }

    $scope.re_comp_state_change = function() {
        if($scope.re_comp_state != "" && $scope.re_comp_state != 0 && $scope.re_comp_state != null)
        {
            $("#re_comp_city").attr("disabled","disabled");
            $("#re_comp_city_loader").show();
            var statedata = $.param({'state_id': $scope.re_comp_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#re_comp_city").removeAttr("disabled");
                $("#re_comp_city_loader").hide();
                $scope.re_comp_city_list = data.data;
            });
        }
    }
    $scope.get_rec_company_info = function(){
        var userdata = $.param({'user_id': user_id});
        $http({
            method: 'POST',
            url: base_url + 'recruiter/get_rec_company_info',            
            data: userdata,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.rec_comp_data = result.data.rec_comp_data;
                if($scope.rec_comp_data.re_comp_other_activity != '')
                {
                    $scope.re_comp_other_activity_list = $scope.rec_comp_data.re_comp_other_activity.split(',');
                }
                $("#rec-comp-loader").hide();
                $("#rec-comp-body").show();                               
            }
        });
    };
    $scope.get_rec_company_info();

    $scope.re_comp_other_field_fnc = function()
    {
        if($scope.re_comp_field == 0 && $scope.re_comp_field != "")
        {
            $("#re_comp_field_div").show();
        }
        else
        {
            $("#re_comp_field_div").hide();
        }
    };

    $scope.edit_rec_comp_info = function(){
        $("#re_comp_name").val($scope.rec_comp_data.re_comp_name);
        $("#re_comp_email").val($scope.rec_comp_data.re_comp_email);
        $("#re_comp_phone").val($scope.rec_comp_data.re_comp_phone > 0 ? $scope.rec_comp_data.re_comp_phone : '');
        $("#re_comp_site").val($scope.rec_comp_data.re_comp_site);
        $("#re_comp_size").val($scope.rec_comp_data.re_comp_size > 0 ? $scope.rec_comp_data.re_comp_size:'');
        if($scope.rec_comp_data.re_comp_field > -1)
        {            
            $("#re_comp_field").val($scope.rec_comp_data.re_comp_field);
            $scope.re_comp_field = $scope.rec_comp_data.re_comp_field;
            if($scope.rec_comp_data.re_comp_field == 0)
            {
                $("#re_comp_field_div").show();
                $("#re_comp_other_field").val($scope.rec_comp_data.re_comp_other_field);
            }
        }
        else
        {
            $scope.re_comp_field = "";
        }
        $("#re_comp_culture").val($scope.rec_comp_data.re_comp_culture);

        var re_comp_other_arr = "";
        if($scope.rec_comp_data.re_comp_other_activity.trim() != "")
        {
            var re_comp_other_arr = $scope.rec_comp_data.re_comp_other_activity.split(',');
        }
        var edit_re_comp_other_activity = [];
        if(re_comp_other_arr.length > 0)
        {                    
            re_comp_other_arr.forEach(function(element,cityIndex) {
              edit_re_comp_other_activity[cityIndex] = {"activity":element};
            });
        }
        $scope.re_comp_other_activity_txt = edit_re_comp_other_activity;

        $("#re_comp_profile").val($scope.rec_comp_data.re_comp_profile);

        $scope.re_comp_country = $scope.rec_comp_data.re_comp_country;
        $("#re_comp_country").val($scope.rec_comp_data.re_comp_country);
        // $scope.exp_country_change();
        $("#save_rec_comp_info").attr("style","pointer-events:none;");
        var counrtydata = $.param({'country_id': $scope.re_comp_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#re_comp_state").removeAttr("disabled");
            $("#re_comp_city").attr("disabled","disabled");
            $("#re_comp_state_loader").hide();
            $scope.re_comp_state_list = data.data;
            $scope.re_comp_city_list = [];
            $scope.re_comp_state = $scope.rec_comp_data.re_comp_state;

            $("#re_comp_city").attr("disabled","disabled");
            $("#re_comp_city_loader").show();
            var statedata = $.param({'state_id': $scope.re_comp_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#re_comp_city").removeAttr("disabled");
                $("#re_comp_city_loader").hide();
                $scope.re_comp_city_list = data.data;
                $scope.re_comp_city = $scope.rec_comp_data.re_comp_city;
                $("#save_rec_comp_info").removeAttr("style");
            });        
        });

        var comp_logo_name =  $scope.rec_comp_data.comp_logo;        
        $scope.comp_logo_old = comp_logo_name;
        if(comp_logo_name != null && comp_logo_name.trim() != "")
        {
            var filename_arr = comp_logo_name.split('.');
            // console.log(filename_arr);
            //console.log(filename_arr[filename_arr.length - 1]);
            $("#logo_doc_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];

            var inner_html = '<p id="logo_doc_prev" class="screen-shot"><a class="file-preview-cus" href="'+rec_profile_thumb_upload_url+comp_logo_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#re_comp_logo_error"));
            $compile(contentTr)($scope);
        }
    };

    var re_comp_formdata = new FormData();
    $(document).on('change','#re_comp_logo', function(e){
        $("#re_comp_logo_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#re_comp_logo_error").html("File size must be less than 10MB.");
            $("#re_comp_logo_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                re_comp_formdata.append('re_comp_logo', $('#re_comp_logo')[0].files[0]);
            }
            else {
                $("#re_comp_logo_error").html("Invalid file selected.");
                $("#re_comp_logo_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.re_comp_other_activity_fnc = function(){        
        $("#re_comp_other_activity_txt .tags").removeAttr("style");
        $("#re_comp_other_activity_err").attr("style","display:none;");
    };

    /*$scope.validate_activity = function(){        
        if($scope.re_comp_other_activity_txt == "" || $scope.re_comp_other_activity_txt == undefined)
        {
            $("#re_comp_other_activity_txt .tags").attr("style","border:1px solid #ff0000;");
            setTimeout(function(){
                $("#re_comp_other_activity_err").attr("style","display:block;");            
            },100);
            return false;
        }
        else
        {
            return true;
        }
    };*/

    $scope.rec_comp_validate = {
        rules: {
            re_comp_name: {
                required: true,
            },
            re_comp_email: {
                required: true,
                email:true,
            },            
            re_comp_phone: {
                required: true,
            },
            re_comp_size: {
                required: true,
            },
            re_comp_field: {
                required: true,
            },
            re_comp_other_field: {
                required: {
                    depends: function(element) {
                        return $("#re_comp_field option:selected").val() == 0 ? true : false;
                    }
                },
            },
            re_comp_country: {
                required: true,
            },
            re_comp_state: {
                required: true,
            },
            re_comp_city: {
                required: true,
            },
            re_comp_profile: {
                required: true,
            },
        },
    };

    $scope.save_rec_comp_info = function(){
        // var rec_other_activity = $scope.validate_activity();
        if ($scope.rec_comp_form.validate())
        {
            $("#rec_comp_info_loader").show();
            $("#save_rec_comp_info").attr("style","pointer-events:none;display:none;");
            
            re_comp_formdata.append('comp_logo_old', $scope.comp_logo_old);
            re_comp_formdata.append('re_comp_name', $('#re_comp_name').val());
            re_comp_formdata.append('re_comp_email', $('#re_comp_email').val());
            re_comp_formdata.append('re_comp_phone', $('#re_comp_phone').val());
            re_comp_formdata.append('re_comp_site', $('#re_comp_site').val());
            re_comp_formdata.append('re_comp_size', $('#re_comp_size').val());
            re_comp_formdata.append('re_comp_field', $('#re_comp_field option:selected').val());
            re_comp_formdata.append('re_comp_other_field', $('#re_comp_other_field').val());
            re_comp_formdata.append('re_comp_culture', $('#re_comp_culture option:selected').val());
            re_comp_formdata.append('re_comp_country', $('#re_comp_country option:selected').val());
            re_comp_formdata.append('re_comp_state', $('#re_comp_state option:selected').val());
            re_comp_formdata.append('re_comp_city', $('#re_comp_city option:selected').val());
            re_comp_formdata.append('re_comp_profile', $('#re_comp_profile').val());
            re_comp_formdata.append('re_comp_other_activity_txt', JSON.stringify($scope.re_comp_other_activity_txt));

            $http.post(base_url + 'recruiter/save_rec_comp_info', re_comp_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                success = result.data.success;
                if(success == 1)
                {
                    $scope.rec_comp_data = result.data.rec_comp_data;
                    if($scope.rec_comp_data.re_comp_other_activity != '')
                    {
                        $scope.re_comp_other_activity_list = $scope.rec_comp_data.re_comp_other_activity.split(',');
                    }
                }
                $("#rec_comp_info_loader").hide();
                $("#save_rec_comp_info").removeAttr("style");
                $("#experience").modal('hide');
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
            });
        }
    };
    //Recruiter Company End

    $scope.set_progress = function(count_profile_value,count_profile){
        if(count_profile == 100)
        {
            $("#profile-progress").show();
            $("#progress-txt").html("Hurray! Your profile is complete.");
            setTimeout(function(){
                // $("#edit-profile-move").hide();
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
});