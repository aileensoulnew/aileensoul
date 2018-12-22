app.directive('numbersOnly', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attr, ngModelCtrl) {
            function fromUser(text) {
                if (text) {
                    var transformedInput = text.replace(/[^0-9]/g, '');

                    if (transformedInput !== text) {
                        ngModelCtrl.$setViewValue(transformedInput);
                        ngModelCtrl.$render();
                    }
                    return transformedInput;
                }
                return undefined;
            }            
            ngModelCtrl.$parsers.push(fromUser);
        }
    };
});
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
app.filter('wordFirstCase', function () {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});
app.filter('removeOther', function () {
    return function(input) {
      // return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
        if(input)
        {
            return input.replace('other','').replace(/,\s*$/, "");
        }
    // console.log(input);
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

        return slug;
    };
});
app.controller('artistProfileController', function ($scope, $http, $location, $window,$compile)
{
    var all_months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $scope.all_months = all_months;
    $scope.from_user_id = from_user_id;
    $scope.to_user_id = to_user_id;

    function load_add_detail()
    {
        setTimeout(function(){
            var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo(".dtl-adv");
            $compile($el)($scope);
        },1000);        
    }

    //Education Start
    $scope.get_edu_degree = function(){
        $http.get(base_url + "userprofile_page/get_edu_degree").then(function (success) {
            $scope.degree_data = success.data.degree_data;
        }, function (error) {});
    };

    $scope.get_edu_university = function(){
        $http.get(base_url + "userprofile_page/get_edu_university").then(function (success) {
            $scope.university_data = success.data.university_data;
        }, function (error) {});
    };    

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

            $http.post(base_url + 'artist_live/save_user_education', edu_formdata,
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
                        edu_formdata = new FormData();
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
                }
            });
        }
    };

    $scope.get_user_education = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_education',
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
        });
    }
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
        $("#edu_s_year").val('');
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
        $("#edu_s_year").val(edu_start_date[0]);
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

            var inner_html = '<p id="edu_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+art_user_education_upload_url+edu_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';

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
                url: base_url + 'artist_live/delete_user_education',
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
            });
        }
    };
    $scope.get_edu_degree();
    $scope.get_edu_university();
    $scope.get_user_education();
    //Education End

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

            $http.post(base_url + 'artist_live/save_user_addicourse', addicourse_formdata,
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
                        addicourse_formdata = new FormData();
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
            });
        }
    };

    $scope.get_user_addicourse = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_addicourse',
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
                $("#addicourse-loader").hide();
                $("#addicourse-body").show();
            }

        });
    }
    
    $scope.view_more_ac = 2;
    $scope.ac_view_more = function(){
        $scope.view_more_ac = $scope.user_addicourse.length;
        $("#view-more-addicourse").hide();
    };

    $scope.reset_addicourse_form = function(){
        $scope.edit_addicourse = 0;
        $scope.addicourse_file_old = "";
        $("#additional-course").removeClass("edit-form-cus");
        $("#addicourse_s_year").val('');
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
        $("#addicourse_s_year").val(addicourse_start_date[0]);
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

            var inner_html = '<p id="addicourse_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+art_user_addicourse_upload_url+addicourse_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';

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
                url: base_url + 'artist_live/delete_user_addicourse',
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
            });
        }
    };
    $scope.get_user_addicourse();
    //Additional Course End

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
        var first_chl_year = "<option value=''>Select Year</option>";
        $("#award_year").html(first_chl_year+year_opt);
        
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
            var first_chl_day = "<option value=''>Select Day</option>";
            $("#award_day").html(first_chl_day+day_opt);
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

            $http.post(base_url + 'artist_live/save_user_award', award_formdata,
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
                        award_formdata = new FormData();
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
            });
        }
    };

    $scope.get_user_award = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_award',
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
                $("#awards-loader").hide();
                $("#awards-body").show();
            }

        });
    }
    
    $scope.view_more_award = 2;
    $scope.award_view_more = function(){
        $scope.view_more_award = $scope.user_award.length;
        $("#view-more-award").hide();
    };

    $scope.reset_awards_form = function(){        
        $scope.edit_awards = 0;
        $scope.awards_file_old = '';
        $("#Achiv-awards").removeClass("edit-form-cus");
        $("#award_month").val('');
        $("#award_day").html("");
        $("#award_year").html("");
        $("#award_file_error").hide();        
        $("#award_file_prev").remove();
        $("#delete_user_award_modal").remove();
        $("#award_form")[0].reset();
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
            var inner_html = '<p id="award_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+art_user_award_upload_url+award_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';
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
                url: base_url + 'artist_live/delete_user_award',
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
            });
        }
    };

    $scope.get_user_award();
    //User Achieve & Award End

    //Experience Start
    $scope.exp_job_title_list = function () {
        $http({
            method: 'POST',
            url: base_url + 'general_data/searchJobTitleStart',
            data: 'q=' + $scope.exp_designation,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            data = success.data;
            $scope.titleSearchResult = data;
        });
    };

    $scope.get_country = function () {
        $http({
            method: 'GET',
            url: base_url + 'userprofile_page/get_country',
            headers: {'Content-Type': 'application/json'},
        }).then(function (data) {
            $scope.exp_country_list = data.data;
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

            $http.post(base_url + 'artist_live/save_user_experience', exp_formdata,
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
                        $scope.job_basic_info = result.job_basic_info;
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
                }
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
        $("#exp_s_year").val('');
        $("#exp_s_month").html('');
        $("#exp_e_year").html('');
        $("#exp_e_month").html('');
        
        // $scope.exp_e_year = '';
        // $scope.exp_e_month = '';
        $scope.exp_isworking = '';
        $("#delete_user_exp_modal").remove();
        $("#exp_doc_prev").remove();
        exp_formdata = new FormData();
        $("#experience_form")[0].reset();
    };
    $scope.get_user_experience = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_experience',
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
            setTimeout(function(){
                $(".exp-y-m-inner").show();
            },500);
            $("#exp-loader").hide();
            $("#exp-body").show();

        });
    }
    
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
        });
        // $scope.exp_state_change();        

        var exp_start_date = $scope.user_experience[index].exp_start_date.split('-');
        var exp_end_date = $scope.user_experience[index].exp_end_date.split('-');        
        $scope.exp_s_year = exp_start_date[0];
        $("#exp_s_year").val(exp_start_date[0]);
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
            var inner_html = '<p id="exp_doc_prev" class="screen-shot"><a class="file-preview-cus" href="'+art_user_experience_upload_url+exp_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';

            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#exp_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.experience_form.validate();
        },1000);

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
                url: base_url + 'artist_live/delete_user_experience',
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
            });
        }
    };    
    $scope.get_user_experience();
    //Experience End

    //Business Portfolio Start
    $scope.edit_portfolio_id = 0;
    var portfolio_formdata = new FormData();
    $(document).on('change','#portfolio_file', function(e){
        $("#portfolio_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#portfolio_file_error").html("File size must be less than 10MB.");
            $("#portfolio_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','PDF','docx','doc'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                portfolio_formdata.append('portfolio_file', $('#portfolio_file')[0].files[0]);
            }
            else {
                $("#portfolio_file_error").html("Invalid file selected.");
                $("#portfolio_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.business_portfolio_validate = {
        rules: {            
            portfolio_title: {
                required: true,
                maxlength: 200,
                minlength: 3
            },            
            portfolio_desc: {
                required: true,
                maxlength: 700,
                minlength: 10
            },
        },
    };
    $scope.save_portfolio = function(){
        if ($scope.business_portfolio_form.validate()) {
            $("#portfolio_loader").show();
            $("#portfolio_save").attr("style","pointer-events:none;display:none;");

            portfolio_formdata.append('edit_portfolio_id', $scope.edit_portfolio_id);
            portfolio_formdata.append('portfolio_file_old', $scope.portfolio_file_old);
            portfolio_formdata.append('portfolio_title', $('#portfolio_title').val());
            portfolio_formdata.append('portfolio_desc', $('#portfolio_desc').val());            
            
            $http.post(base_url + 'artist_live/save_portfolio', portfolio_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })
            .then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $("#portfolio_save").removeAttr("style");
                        $("#portfolio_loader").hide();
                        $("#business_portfolio_form")[0].reset();
                        // $scope.reset_awards_form();
                        $scope.user_portfolio = result.user_portfolio;
                        $("#art-portfolio").modal('hide');
                    }
                    else
                    {
                        $("#portfolio_save").removeAttr("style");
                        $("#portfolio_loader").hide();
                        $("#business_portfolio_form")[0].reset();
                        $("#art-portfolio").modal('hide');
                    }
                }
            });
        }
    };

    $scope.get_portfolio = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_portfolio',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                user_portfolio = result.data.user_portfolio;
                $scope.user_portfolio = user_portfolio;
                $("#portfolio-loader").hide();
                $("#portfolio-body").show();
            }

        });
    }
    $scope.get_portfolio();
    $scope.view_more_port = 2;
    $scope.port_view_more = function(){
        $scope.view_more_port = $scope.user_portfolio.length;
        $("#view-more-pr").hide();
    };
    $scope.reset_portfolio = function(){
        $scope.edit_portfolio_id = 0;
        $scope.portfolio_file_old = '';
        $("#art-portfolio").removeClass("edit-form-cus");
        $("#portfolio_file_error").hide();        
        $("#portfolio_file_prev").remove();
        $("#delete_user_portfolio_modal").remove();
        $("#business_portfolio_form")[0].reset();
        portfolio_formdata = new FormData();
    };
    $scope.edit_portfolio = function(index){
        $scope.reset_portfolio();
        $("#art-portfolio").addClass("edit-form-cus");
        var portfolio_data = $scope.user_portfolio[index];        
        $scope.edit_portfolio_id = portfolio_data.id_portfolio;
        $("#portfolio_title").val(portfolio_data.portfolio_title);
        $("#portfolio_desc").val(portfolio_data.portfolio_desc);

        var portfolio_file_name = portfolio_data.portfolio_file;
        $scope.portfolio_file_old = portfolio_file_name;
        if(portfolio_file_name.trim() != "")
        {            
            var filename_arr = portfolio_file_name.split('.');
            $("#portfolio_file_prev").remove();
            var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var allowed_doc_ext = ['pdf','PDF','docx','doc'];
            var fileExt = filename_arr[filename_arr.length - 1];

            var inner_html = '<p id="portfolio_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+art_user_portfolio_upload_url+portfolio_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            
            var contentTr = angular.element(inner_html);
            contentTr.insertAfter($("#portfolio_file_error"));
            $compile(contentTr)($scope);
        }
        setTimeout(function(){  
            $scope.award_form.validate();
        },1000);

        var delete_btn = '<a id="delete_user_portfolio_modal" href="#" data-target="#delete-portfolio-model" data-toggle="modal" class="save delete-edit"><span>Delete</span></a>';
        var contentbtn = angular.element(delete_btn);
        contentbtn.insertAfter($("#portfolio_loader"));
        $compile(contentbtn)($scope);
        $("#art-portfolio").modal("show");

    };

    $scope.delete_portfolio = function(){
        $("#delete_portfolio").attr("style","pointer-events:none;display:none;");
        $("#delete_portfolio_loader").show();
        $("#portfolio-delete-btn").hide();
        if($scope.edit_portfolio_id != 0)
        {
            var expdata = $.param({'edit_portfolio_id': $scope.edit_portfolio_id});
            $http({
                method: 'POST',
                url: base_url + 'artist_live/delete_portfolio',
                data: expdata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result) {
                    result = result.data;
                    if(result.success == '1')
                    {
                        $scope.user_portfolio = result.user_portfolio;
                        $("#delete-portfolio-model").modal('hide');
                        $("#art-portfolio").modal('hide');
                        $("#delete_portfolio").removeAttr("style");
                        $("#delete_portfolio_loader").hide();
                        $("#portfolio-delete-btn").show();                        
                        $scope.reset_portfolio();
                    }
                    else
                    {
                        $("#delete-portfolio-model").modal('hide');
                        $("#art-portfolio").modal('hide');
                        $("#delete_portfolio").removeAttr("style");
                        $("#delete_portfolio_loader").hide();
                        $("#portfolio-delete-btn").show();
                        $scope.reset_portfolio();
                    }
                }
            });
        }
    };
    //Business Portfolio End

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
            url: base_url + 'artist_live/save_user_links',                
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
            $("#user_links_save").removeAttr("style");
            $("#user_links_loader").hide();
            $("#social-link").modal('hide');
            var profile_progress = result.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            $scope.set_progress(count_profile_value,count_profile);
        });
    };

    
    $scope.get_user_links = function()
    {
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_links',
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

        });
    };
    $scope.get_user_links();
    //Socila Links End

    //Language Start
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
        });
    };

    $scope.save_user_language = function(){        
        {
            $("#user_language_loader").show();
            $("#save_user_language").attr("style","pointer-events:none;display:none;");
            
            var languages = $('.language').serializeArray();
            var proficiency = $('.proficiency').serializeArray();
            
            var dob = '';//dob_year_txt+'-'+dob_month_txt+'-'+dob_day_txt;        
            var updatedata = $.param({"language":languages,"proficiency":proficiency});
            $http({
                method: 'POST',
                url: base_url + 'artist_live/save_user_language',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {                    
                    var user_langs = result.data.user_languages;
                    $scope.user_languages = user_langs;
                    $scope.primari_lang = user_langs[0];
                    $scope.languageSet.language = user_langs.slice(1);
                }
                $("#save_user_language").removeAttr("style");
                $("#user_language_loader").hide();
                $("#language").modal('hide');
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
            });
        }
    };

    $scope.get_user_languages = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_languages',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                var user_langs = result.data.user_languages;
                $scope.user_languages = user_langs;
                $scope.primari_lang = user_langs[0];
                $scope.languageSet.language = user_langs.slice(1);               
            }
            $("#language-loader").hide();
            $("#language-body").show();
        });
    };
    $scope.get_user_languages();
    //Language End

    //Art Bio Start
    $scope.save_art_bio = function(){
        var user_bio = $("#user_bio").val();        
        // if(user_bio != "" && $scope.user_bio != user_bio)
        {
            $("#user_bio_loader").show();
            $("#user_bio_save").attr("style","pointer-events:none;display:none;");
            var updatedata = $.param({'user_bio':user_bio});
            $http({
                method: 'POST',
                url: base_url + 'artist_live/save_art_bio',                
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
                $("#user_bio_save").removeAttr("style");
                $("#user_bio_loader").hide();
                $("#bio").modal('hide');
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
            });
        }
    };

    $scope.get_user_bio = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_bio',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.user_bio = result.data.user_bio;                
            }
            $("#bio-loader").hide();
            $("#bio-body").show();
        });
    };
    $scope.get_user_bio();
    //Art Bio End

    //Specialities Start
    $scope.save_user_speciality = function(){
        $("#user_speciality_loader").show();
        $("#save_user_speciality").attr("style","pointer-events:none;display:none;");
        var speciality_txt = $scope.speciality_txt;
        var speciality_desc = $("#speciality_desc").val();
        var updatedata = $.param({"speciality_txt":speciality_txt,"speciality_desc":speciality_desc});
        $http({
            method: 'POST',
            url: base_url + 'artist_live/save_user_speciality',                
            data: updatedata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            success = result.data.success;
            if(success == 1)
            {
                $scope.art_speciality_data = result.data.art_speciality_data;
            }

            $("#save_user_speciality").removeAttr("style");
            $("#user_speciality_loader").hide();
            $("#specialities").modal('hide');
            var profile_progress = result.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            $scope.set_progress(count_profile_value,count_profile);
        });
    };

    $scope.edit_user_specialities = function(){
        if($scope.art_speciality_data.art_spl_tags != '')
        {            
            var edit_user_speciality = [];
            var art_spl_tags_arr = $scope.art_speciality_data.art_spl_tags.split(',');
            art_spl_tags_arr.forEach(function(element,catArrIndex) {                
              edit_user_speciality[catArrIndex] = {speciality:element};
            });
            $scope.speciality_txt = edit_user_speciality;
        }
        $("#speciality_desc").val($scope.art_speciality_data.art_spl_desc);
        $scope.speciality_desc = $scope.art_speciality_data.art_spl_desc;
        $("#specialities").modal('show');        
    };
    $scope.get_user_specialities = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_specialities',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.art_speciality_data = result.data.art_speciality_data;
            }
            $("#specialities-loader").hide();
            $("#specialities-body").show();

        });
    }
    $scope.get_user_specialities();
    //Specialities End

    //Software / Instrument/ Skills Start
    $scope.save_user_soft_inst_skill = function(){
        $("#user_soft_inst_skill_loader").show();
        $("#save_user_soft_inst_skill").attr("style","pointer-events:none;display:none;");
        var soft_inst_skill_txt = $scope.soft_inst_skill_txt;        
        var updatedata = $.param({"soft_inst_skill_txt":soft_inst_skill_txt});
        $http({
            method: 'POST',
            url: base_url + 'artist_live/save_user_soft_inst_skill',                
            data: updatedata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            success = result.data.success;
            if(success == 1)
            {
                $scope.art_soft_inst_skill = result.data.art_soft_inst_skill;
            }

            $("#save_user_soft_inst_skill").removeAttr("style");
            $("#user_soft_inst_skill_loader").hide();
            $("#art-sof").modal('hide');           
        });
    };

    $scope.edit_soft_inst_skill = function(){
        if($scope.art_soft_inst_skill != '')
        {            
            var edit_art_soft_inst_skill = [];
            var art_soft_inst_skill_arr = $scope.art_soft_inst_skill.split(',');
            art_soft_inst_skill_arr.forEach(function(element,catArrIndex) {                
              edit_art_soft_inst_skill[catArrIndex] = {sis:element};
            });
            $scope.soft_inst_skill_txt = edit_art_soft_inst_skill;
        }        
        $("#art-sof").modal('show');        
    };
    $scope.get_user_soft_inst_skill_data = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_soft_inst_skill_data',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.art_soft_inst_skill = result.data.art_soft_inst_skill;
            }
            $("#soft_inst_skill-loader").hide();
            $("#soft_inst_skill-body").show();

        });
    }
    $scope.get_user_soft_inst_skill_data();
    //Software / Instrument/ Skills End

    //Type of Talent / Category Start
    $scope.save_user_talent_cat = function(){
        $("#user_talent_cat_loader").show();
        $("#save_user_talent_cat").attr("style","pointer-events:none;display:none;");
        var talent_cat_txt = $scope.talent_cat_txt;        
        var updatedata = $.param({"talent_cat_txt":talent_cat_txt});
        $http({
            method: 'POST',
            url: base_url + 'artist_live/save_user_talent_cat',                
            data: updatedata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            success = result.data.success;
            if(success == 1)
            {
                $scope.art_talent_cat = result.data.art_talent_category;
            }

            $("#save_user_talent_cat").removeAttr("style");
            $("#user_talent_cat_loader").hide();
            $("#talent").modal('hide');           
        });
    };

    $scope.edit_talent_cat = function(){
        if($scope.art_talent_cat != '')
        {            
            var edit_art_talent_cat = [];
            var art_talent_cat_arr = $scope.art_talent_cat.split(',');
            art_talent_cat_arr.forEach(function(element,catArrIndex) {                
              edit_art_talent_cat[catArrIndex] = {tal_cat:element};
            });
            $scope.talent_cat_txt = edit_art_talent_cat;
        }
        $("#talent").modal('show');        
    };
    $scope.get_user_talent_cat_data = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_talent_cat_data',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.art_talent_cat = result.data.art_talent_category;
            }
            $("#talent_cat-loader").hide();
            $("#talent_cat-body").show();

        });
    }
    $scope.get_user_talent_cat_data();
    //Type of Talent / Category End

    //Art Search Status Start
    $scope.validate_art_imp = function(){
        var art_status = $("#art_status").val();        
        if(art_status == 1 || art_status == 2 || art_status == 3)
        {
            $(".mm-dropdown").attr("style","border: 1px solid #ddd;");
            return true;
        }
        else
        {
            $(".mm-dropdown").attr("style","border: 1px solid #f00000;");
            return false;
        }
    };

    $scope.art_imp_save = function(){
        var pre_loc = $scope.validate_art_imp();
        if (pre_loc)
        {
            $("#art_imp_save_loader").show();
            $("#art_imp_save").attr("style","pointer-events:none;display:none;");
            var art_status = $("#art_status").val();
            var updatedata = $.param({'art_status':art_status});
            $http({
                method: 'POST',
                url: base_url + 'artist_live/art_imp_save',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {                    
                    $scope.art_imp_data = result.data.art_imp_data;
                }
                $("#art_imp_save").removeAttr("style");
                $("#art_imp_save_loader").hide();
                $("#availability").modal('hide');
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
            });
            
        }
    };
    
    $scope.get_user_art_imp_data = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_user_art_imp_data',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.art_imp_data = result.data.art_imp_data;
            }
            $("#art_imp-loader").hide();
            $("#art_imp-body").show();

        });
    }
    $scope.get_user_art_imp_data();
    //Art Search Status End

    //Art Basic Info Start
    $scope.art_dob_date_fnc = function(dob_day,dob_month,dob_year){
        $("#artdobdateerror").hide();
        $("#artdobdateerror").html('');
        var kcyear = document.getElementsByName("art_dob_year")[0],
        kcmonth = document.getElementsByName("art_dob_month")[0],
        kcday = document.getElementsByName("art_dob_day")[0];                
        
        var d = new Date();
        var n = d.getFullYear();
        year_opt = "";
        for (var i = n; i >= 1900; i--) {
            if(dob_year == i)
            {
                year_opt += "<option value='"+i+"' selected='selected'>"+i+"</option>";
            }
            else
            {                
                year_opt += "<option value='"+i+"'>"+i+"</option>";
            }            
        }
        var first_chl_year = "<option value=''>Select Year</option>";
        $("#art_dob_year").html(first_chl_year+year_opt);
        
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
            var first_chl_day = "<option value=''>Select Day</option>";
            $("#art_dob_day").html(first_chl_day+day_opt);
        }
        validate_date(dob_day,dob_month,dob_year);
    };
    $scope.art_dob_error = function()
    {
        $("#artdobdateerror").hide();
        $("#artdobdateerror").html('');
    };
    $scope.art_basic_country_change = function() {
        $("#art_basic_state").attr("disabled","disabled");
        $("#art_basic_state_loader").show();
        var counrtydata = $.param({'country_id': $scope.art_basic_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#art_basic_state").removeAttr("disabled");
            $("#art_basic_city").attr("disabled","disabled");
            $("#art_basic_state_loader").hide();
            $scope.art_basic_state_list = data.data;
            $scope.art_basic_city_list = [];
        });
    }

    $scope.art_basic_state_change = function() {
        if($scope.art_basic_state != "" && $scope.art_basic_state != 0 && $scope.art_basic_state != null)
        {
            $("#art_basic_city").attr("disabled","disabled");
            $("#art_basic_city_loader").show();
            var statedata = $.param({'state_id': $scope.art_basic_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#art_basic_city").removeAttr("disabled");
                $("#art_basic_city_loader").hide();
                $scope.art_basic_city_list = data.data;
            });
        }
    }

    $scope.view_more_about = function(){
        $("#about-detail").removeClass("dtl-box-height");
        $("#view-more-about").hide();
    };
    $scope.get_artist_basic_info = function(){
        $http({
            method: 'POST',
            url: base_url + 'artist_live/get_artist_basic_info',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.artist_basic_info = result.data.artist_basic_info;
                $scope.artist_preferred_info = result.data.artist_preferred_info;
                
                setTimeout(function(){
                    if($("#about-detail").innerHeight() > 155)
                    {
                        $("#about-detail").addClass("dtl-box-height");
                        $("#view-more-about").show();
                    }
                    else
                    {
                        $("#view-more-about").hide();
                    }

                    if($("#preffered-detail").innerHeight() > 155)
                    {
                        $("#preffered-detail").addClass("dtl-box-height");
                        $("#view-more-preffered").show();
                    }
                    else
                    {
                        $("#view-more-preffered").hide();
                    }
                },500);
            }
            $("#art-info-loader").hide();
            $("#art-info-body").show();
            $("#art-preffered-loader").hide();
            $("#art-preffered-body").show();

        });
    }
    $scope.get_artist_basic_info();

    $scope.edit_art_basic_info = function(){
        $("#art_basic_info_save").attr("style","pointer-events:none");
        var artist_basic_arr = $scope.artist_basic_info;
        $("#art_fname").val(artist_basic_arr.art_name);
        $("#art_lname").val(artist_basic_arr.art_lastname);
        
        var cat_arr = artist_basic_arr.art_skill.split(",");        
        if(cat_arr.indexOf("26") != -1){
            $("#other_category_div").show();
            $("#art_other_category").val(artist_basic_arr.other_category_txt);
        }
        else{
            $("#other_category_div").hide();
            $("#art_other_category").val("");
        }
        // Set the value
        $("#skills").val(cat_arr).change();
        $("#art_gender").val(artist_basic_arr.art_gender);
        $("#art_email").val(artist_basic_arr.art_email);
        $("#art_phnno").val(artist_basic_arr.art_phnno);

        var art_dob_arr = artist_basic_arr.art_dob.split("-");
        art_dob_day = art_dob_arr[2];
        art_dob_month = art_dob_arr[1];
        art_dob_year = art_dob_arr[0];
        $("#art_dob_month").val(art_dob_month);
        // $scope.art_dob_month = art_dob_month;
        $scope.art_dob_date_fnc(art_dob_day,art_dob_month,art_dob_year);

        $scope.art_basic_country = artist_basic_arr.art_country;
        $("#art_basic_country").val(artist_basic_arr.art_country);
        // $scope.art_basic_country_change();
        var counrtydata = $.param({'country_id': $scope.art_basic_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#art_basic_state").removeAttr("disabled");
            $("#art_basic_city").attr("disabled","disabled");
            $("#art_basic_state_loader").hide();
            $scope.art_basic_state_list = data.data;
            $scope.art_basic_city_list = [];
            $scope.art_basic_state = artist_basic_arr.art_state;

            $("#art_basic_city").attr("disabled","disabled");
            $("#art_basic_city_loader").show();
            var statedata = $.param({'state_id': $scope.art_basic_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#art_basic_city").removeAttr("disabled");
                $("#art_basic_city_loader").hide();
                $scope.art_basic_city_list = data.data;
                $scope.art_basic_city = artist_basic_arr.art_city;
                $("#art_basic_info_save").removeAttr("style");
            });        
        });

        $("#job-basic-info").modal('show');
    };

    $('#skills').multiSelect();
    $scope.arts_basic_info_validate = {
        rules: {            
            art_fname: {
                required: true,
                maxlength: 255
            },
            art_lname: {
                required: true,
                maxlength: 255
            },
            "skills[]": {
                required: true,                
            },
            art_other_category: {
                required: {
                    depends: function(element) {
                        var all_cat_arr = $("#skills").val();    
                        if(all_cat_arr.indexOf("26") != -1){
                            return true;
                        }
                        else{
                            return false;
                        }
                    }
                },
            },
            art_gender: {
                required: true,
            },
            art_email: {
                required: true,
                email:true,
                remote: {
                    url: base_url + "artist/check_email",
                    type: "post",
                    data: {
                      email: function() {
                        return $( "#art_email" ).val();
                      }
                    }
                },
            },
            art_phnno: {
                required: true,
            },
            art_dob_month: {
                required: true,
            },
            art_dob_day: {
                required: true,
            },
            art_dob_year: {
                required: true,
            },
            art_basic_country: {
                required: true,
            },
            art_basic_state: {
                required: true,
            },
            art_basic_city: {
                required: true,
            },
        },
    };
    $scope.validate_skills = function(){
        var all_cat_arr = $("#skills").val();    
        if(all_cat_arr.length > 0 && all_cat_arr.length < 11){
            return true;
        }
        else
        {
            $("#multidropdown").attr("style","border:1px solid #ff0000;");
            return false;
        }
    };
    $scope.art_basic_info_save = function(){
        var vali_skill = $scope.validate_skills();
        if ($scope.art_basic_info_form.validate() && vali_skill) {
            $("#art_basic_info_save_loader").show();
            $("#art_basic_info_save").attr("style","pointer-events:none;display:none;");

            var art_fname = $("#art_fname").val();
            var art_lname = $("#art_lname").val();
            var art_category = $("#skills").val();
            var art_other_category = $("#art_other_category").val();
            var art_gender = $("#art_gender option:selected").val();
            var art_email = $("#art_email").val();
            var art_phnno = $("#art_phnno").val();
            var art_dob_day = $("#art_dob_day option:selected").val();
            var art_dob_month = $("#art_dob_month option:selected").val();
            var art_dob_year = $("#art_dob_year option:selected").val();
            var art_basic_country = $("#art_basic_country option:selected").val();
            var art_basic_state = $("#art_basic_state option:selected").val();
            var art_basic_city = $("#art_basic_city option:selected").val();

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
            var value = art_dob_year + '/' + art_dob_month + '/' + art_dob_day;

            var d1 = Date.parse(todaydate);
            var d2 = Date.parse(value);

            if (d1 < d2) {
                $("#artdobdateerror").html("Birth date always less than to today's date.");
                $("#artdobdateerror").show();

                $("#art_basic_info_save").removeAttr("style");
                $("#art_basic_info_save_loader").hide();
                return false;
            }

            var updatedata = $.param({
                'art_fname':art_fname,                
                'art_lname':art_lname,                
                'art_category':art_category,                
                'art_other_category':art_other_category,                
                'art_gender':art_gender,                
                'art_email':art_email,                
                'art_phnno':art_phnno,                
                'art_dob_day':art_dob_day,                
                'art_dob_month':art_dob_month,                
                'art_dob_year':art_dob_year,                
                'art_basic_country':art_basic_country,                
                'art_basic_state':art_basic_state,                
                'art_basic_city':art_basic_city,                
            });
            $http({
                method: 'POST',
                url: base_url + 'artist_live/art_basic_info_save',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {
                    $scope.artist_basic_info = result.data.artist_basic_info;
                    $scope.artist_preferred_info = result.data.artist_preferred_info;
                }
                $("#art_basic_info_save").removeAttr("style");
                $("#art_basic_info_save_loader").hide();
                $("#job-basic-info").modal('hide');
                // var profile_progress = result.data.profile_progress;
                // var count_profile_value = profile_progress.user_process_value;
                // var count_profile = profile_progress.user_process;
                // $scope.progress_status = profile_progress.progress_status;
                // $scope.set_progress(count_profile_value,count_profile);
            });
        }
    };
    //Art Basic Info End

    //Art Preffered Info Start
    $scope.view_more_preffered = function(){
        $("#preffered-detail").removeClass("dtl-box-height");
        $("#view-more-preffered").hide();
    };
    var defaults = {
      'buttonHTML': '<span class="multi-select-button custom-mini-select" id="multidropdown-pc">',
    };
    $('#pref_cate').multiSelect(defaults);

    $scope.art_preffered_country_change = function() {
        $("#art_preffered_state").attr("disabled","disabled");
        $("#art_preffered_state_loader").show();
        var counrtydata = $.param({'country_id': $scope.art_preffered_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#art_preffered_state").removeAttr("disabled");
            $("#art_preffered_city").attr("disabled","disabled");
            $("#art_preffered_state_loader").hide();
            $scope.art_preffered_state_list = data.data;
            $scope.art_preffered_city_list = [];
        });
    }

    $scope.art_preffered_state_change = function() {
        if($scope.art_preffered_state != "" && $scope.art_preffered_state != 0 && $scope.art_preffered_state != null)
        {
            $("#art_preffered_city").attr("disabled","disabled");
            $("#art_preffered_city_loader").show();
            var statedata = $.param({'state_id': $scope.art_preffered_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#art_preffered_city").removeAttr("disabled");
                $("#art_preffered_city_loader").hide();
                $scope.art_preffered_city_list = data.data;
            });
        }
    }

    $scope.arts_preferred_info_validate = {
        rules: {
            "pref_cate[]": {
                required: true,                
            },
            art_other_pref_cate: {
                required: {
                    depends: function(element) {
                        var all_cat_arr = $("#pref_cate").val();    
                        if(all_cat_arr.indexOf("26") != -1){
                            return true;
                        }
                        else{
                            return false;
                        }
                    }
                },
            },            
            art_preffered_country: {
                required: true,
            },
            art_preffered_state: {
                required: true,
            },
            art_preffered_city: {
                required: true,
            },
            preffered_availability: {
                required: true,
            },
        },
    };
    $scope.validate_pref_cat = function(){
        var all_cat_arr = $("#pref_cate").val();    
        if(all_cat_arr.length > 0 && all_cat_arr.length < 11){
            return true;
        }
        else
        {
            $("#multidropdown-pc").attr("style","border:1px solid #ff0000;");
            return false;
        }
    };
    $scope.validate_pref_skill = function(){        
        if($scope.preferred_skill_txt == "" || $scope.preferred_skill_txt == undefined)
        {
            $("#preferred_skill_txt .tags").attr("style","border:1px solid #ff0000;");            
            return false;
        }
        else
        {
            return true;
        }
    };
    $scope.preferred_skill_fnc = function(){
        $("#preferred_skill_txt .tags").attr("style","border:1px solid #cccccc;");
    };
    $scope.art_preferred_info_save = function(){
        var vali_cat = $scope.validate_pref_cat();
        var vali_skill = $scope.validate_pref_skill();
        if ($scope.art_preferred_info_form.validate() && vali_cat && vali_skill) {
            $("#art_preferred_info_save_loader").show();
            $("#art_preferred_info_save").attr("style","pointer-events:none;display:none;");

            var pref_cate = $("#pref_cate").val();
            var art_other_pref_cate = $("#art_other_pref_cate").val();
            var preferred_skill_txt = $scope.preferred_skill_txt;
            var art_preffered_country = $("#art_preffered_country option:selected").val();
            var art_preffered_state = $("#art_preffered_state option:selected").val();
            var art_preffered_city = $("#art_preffered_city option:selected").val();
            var preffered_availability = $("#preffered_availability option:selected").val();

            var updatedata = $.param({
                'pref_cate':pref_cate,                
                'art_other_pref_cate':art_other_pref_cate,                
                'preferred_skill_txt':preferred_skill_txt,                
                'art_preffered_country':art_preffered_country,                
                'art_preffered_state':art_preffered_state,                
                'art_preffered_city':art_preffered_city,                
                'preffered_availability':preffered_availability,
            });
            $http({
                method: 'POST',
                url: base_url + 'artist_live/art_preferred_info_save',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {
                    $scope.artist_basic_info = result.data.artist_basic_info;
                    $scope.artist_preferred_info = result.data.artist_preferred_info;
                }
                $("#art_preferred_info_save").removeAttr("style");
                $("#art_preferred_info_save_loader").hide();
                $("#preferred-work").modal('hide');
                // var profile_progress = result.data.profile_progress;
                // var count_profile_value = profile_progress.user_process_value;
                // var count_profile = profile_progress.user_process;
                // $scope.progress_status = profile_progress.progress_status;
                // $scope.set_progress(count_profile_value,count_profile);
            });
        }
    };

    $scope.edit_art_preferred_info = function(){
        $("#art_preferred_info_save").attr("style","pointer-events:none");
        var artist_basic_arr = $scope.artist_basic_info;
        var artist_preferred_arr = $scope.artist_preferred_info;
        $("#artist_preferred_arr").val(artist_preferred_arr.preffered_availability);
        
        var cat_arr = artist_basic_arr.art_skill.split(",");        
        if(cat_arr.indexOf("26") != -1){
            $("#other_pref_cate_div").show();
            $("#art_other_pref_cate").val(artist_basic_arr.other_category_txt);
        }
        else{
            $("#other_pref_cate_div").hide();
            $("#art_other_pref_cate").val("");
        }
        // Set the value
        $("#pref_cate").val(cat_arr).change();

        if(artist_preferred_arr.preffered_skills != '')
        {            
            var edit_preffered_skills = [];
            var preffered_skills_arr = artist_preferred_arr.preffered_skills.split(',');
            preffered_skills_arr.forEach(function(element,catArrIndex) {                
              edit_preffered_skills[catArrIndex] = {pref_skill:element};
            });
            $scope.preferred_skill_txt = edit_preffered_skills;
        }

        $scope.art_preffered_country = artist_preferred_arr.preffered_country;
        $("#art_preffered_country").val(artist_preferred_arr.preffered_country);
        // $scope.art_preffered_country_change();
        var counrtydata = $.param({'country_id': $scope.art_preffered_country});
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_state_by_country_id',
            data: counrtydata,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (data) {
            $("#art_preffered_state").removeAttr("disabled");
            $("#art_preffered_city").attr("disabled","disabled");
            $("#art_preffered_state_loader").hide();
            $scope.art_preffered_state_list = data.data;
            $scope.art_preffered_city_list = [];
            $scope.art_preffered_state = artist_preferred_arr.preffered_state;

            $("#art_preffered_city").attr("disabled","disabled");
            $("#art_preffered_city_loader").show();
            var statedata = $.param({'state_id': $scope.art_preffered_state});
            $http({
                method: 'POST',
                url: base_url + 'userprofile_page/get_city_by_state_id',
                data: statedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (data) {
                $("#art_preffered_city").removeAttr("disabled");
                $("#art_preffered_city_loader").hide();
                $scope.art_preffered_city_list = data.data;
                $scope.art_preffered_city = artist_preferred_arr.preffered_city;
                $("#art_preferred_info_save").removeAttr("style");
            });        
        });

        $("#preferred-work").modal('show');
    };
    //Art Preffered Info End
});

function otherchange(cat_id){
    var all_cat_arr = $("#skills").val();    
    if(all_cat_arr.indexOf("26") != -1){
        $("#other_category_div").show();
    }
    else{
        $("#other_category_div").hide();
    }
    $("#multidropdown").removeAttr("style");
}
function other_change_pref_cate(){
    var all_cat_arr = $("#pref_cate").val();
    if(all_cat_arr.indexOf("26") != -1){
        $("#other_pref_cate_div").show();
    }
    else{
        $("#other_pref_cate_div").hide();
    }
    $("#multidropdown-pc").removeAttr("style");
}