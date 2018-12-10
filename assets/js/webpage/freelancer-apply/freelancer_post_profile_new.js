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
app.controller('freelanceApplyProfileController', function ($scope, $http,$compile) {
    var all_months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $scope.all_months = all_months;

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

            $http.post(base_url + 'freelancer/save_user_education', edu_formdata,
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
            url: base_url + 'freelancer/get_user_education',
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
    // $scope.get_user_education();
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

            var inner_html = '<p id="edu_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+free_apply_education_upload_url+edu_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';

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
                url: base_url + 'freelancer/delete_user_education',
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

            $http.post(base_url + 'freelancer/save_user_experience', exp_formdata,
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
            url: base_url + 'freelancer/get_user_experience',
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
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="exp_doc_prev" class="screen-shot"><a href="'+free_apply_experience_upload_url+exp_file_name+'" target="_blank"><img style="width: 100px;" src="'+free_apply_experience_upload_url+exp_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="exp_doc_prev" class="screen-shot"><a class="file-preview-cus" href="'+free_apply_experience_upload_url+exp_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
            // }

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
                url: base_url + 'freelancer/delete_user_experience',
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
    $scope.get_country();
    
    //Experience End

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

            $http.post(base_url + 'freelancer/save_user_addicourse', addicourse_formdata,
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
            url: base_url + 'freelancer/get_user_addicourse',
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
            /*if ($.inArray(fileExt.toLowerCase(), allowed_img_ext) !== -1) {
                var inner_html = '<p id="addicourse_file_prev" class="screen-shot"><a href="'+free_apply_addicourse_upload_path+addicourse_file_name+'" target="_blank"><img style="width: 100px;" src="'+free_apply_addicourse_upload_path+addicourse_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="addicourse_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+free_apply_addicourse_upload_url+addicourse_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
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
                url: base_url + 'freelancer/delete_user_addicourse',
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
            $("#pub_file_error").html("File size must be less than 10MB.");
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
                $("#pub_file_error").html("Invalid file selected.");                
                $("#pub_file_error").show();
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

            $http.post(base_url + 'freelancer/save_user_publication', publication_formdata,
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
                        publication_formdata = new FormData();
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
            });
        }
    };

    $scope.get_user_publication = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer/get_user_publication',
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
                $("#publication-loader").hide();
                $("#publication-body").show();
            }

        });
    }
    // $scope.get_user_publication();
    $scope.view_more_publication = 2;
    $scope.publication_view_more = function(){
        $scope.view_more_publication = $scope.user_publication.length;
        $("#view-more-publication").hide();
    };

    $scope.reset_publication_form = function(){        
        $scope.edit_publication = 0;
        $scope.pub_file_old = '';
        $("#publication").removeClass("edit-form-cus");
        $("#publication_month").val('');
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
                url: base_url + 'freelancer/delete_user_publication',
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
            });
        }
    };
    $scope.get_user_publication();
    // User Publication End

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
                url: base_url + 'freelancer/save_user_language',                
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
            url: base_url + 'freelancer/get_user_languages',
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
            url: base_url + 'freelancer/save_user_links',                
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
            url: base_url + 'freelancer/get_user_links',
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

    // Skills Start
    $scope.save_user_skills = function(){

        $("#user_skills_loader").show();
        $("#user_skills_save").attr("style","pointer-events:none;display:none;");
        var updatedata = $.param({"user_skills":$scope.edit_user_skills});
        $http({
            method: 'POST',
            url: base_url + 'freelancer/save_user_skills',                
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

            $("#user_skills_save").removeAttr("style");
            $("#user_skills_loader").hide();
            $("#skills").modal('hide');
            var profile_progress = result.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            $scope.set_progress(count_profile_value,count_profile);
            
            // $("#skills .modal-close").click();
        });
        
    };

    $scope.reset_user_skills = function(){       
        var edit_user_skills = [];
        $scope.user_skills.forEach(function(element,catArrIndex) {
          edit_user_skills[catArrIndex] = {name:element.name};
        });
        // $scope.$apply(function () {
        setTimeout(function(){
            $scope.edit_user_skills = edit_user_skills;//$scope.user_skills;
        },100);
        // });
    };

    $scope.load_skills = [];
    $scope.loadSkills = function ($query) {
        return $http.get(base_url + 'freelancer/get_freelancer_skills', {cache: true}).then(function (response) {
            var load_skills = response.data;
            return load_skills.filter(function (title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };
    $scope.get_user_skills = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer/get_user_skills',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                skills_data = result.data.skills_data;
                skills_data_edit = result.data.skills_data_edit;
                $scope.user_skills = skills_data;
                $scope.edit_user_skills = skills_data_edit;
            }
            $("#skill-loader").hide();
            $("#skill-body").show();

        });
    }
    $scope.get_user_skills();
    // Skills End

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

            $http.post(base_url + 'freelancer/save_user_project', project_formdata,
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
                        project_formdata = new FormData();
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
            });
        }
    };

    $scope.get_user_project = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer/get_user_project',
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
                $("#project-loader").hide();
                $("#project-body").show();
            }

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
        $("#project_s_year").val('');
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
        $("#project_s_year").val(proj_start_date[0]);
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
                var inner_html = '<p id="project_file_prev" class="screen-shot"><a href="'+free_apply_project_upload_url+proj_file_name+'" target="_blank"><img style="width: 100px;" src="'+free_apply_project_upload_url+proj_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="project_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+free_apply_project_upload_url+proj_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
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
                url: base_url + 'freelancer/delete_user_project',
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
            });
        }
    };
    //Project End

    //Proffessional Summary Start
    $scope.save_prof_summary = function(){
        var prof_summary = $("#prof_summary").val();        
        // if(user_bio != "" && $scope.user_bio != user_bio)
        {
            $("#prof_summary_loader").show();
            $("#prof_summary_save").attr("style","pointer-events:none;display:none;");
            var updatedata = $.param({'prof_summary':prof_summary});
            $http({
                method: 'POST',
                url: base_url + 'freelancer/save_prof_summary',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {                    
                    prof_summary = result.data.user_prof_summary;
                    $scope.prof_summary = prof_summary;                
                }
                $("#prof_summary_save").removeAttr("style");
                $("#prof_summary_loader").hide();
                $("#prof-summary").modal('hide');
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
            });
        }
    };

    $scope.get_user_prof_summary = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer/get_user_prof_summary',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.prof_summary = result.data.user_prof_summary;                
            }
            $("#prof-summary-loader").hide();
            $("#prof-summary-body").show();
        });
    };
    $scope.get_user_prof_summary();
    //Proffessional Summary End

    //Company Overview Start
    $scope.save_company_overview = function(){
        var company_overview = $("#company_overview").val();        
        // if(user_bio != "" && $scope.user_bio != user_bio)
        {
            $("#company_overview_loader").show();
            $("#company_overview_save").attr("style","pointer-events:none;display:none;");
            var updatedata = $.param({'company_overview':company_overview});
            $http({
                method: 'POST',
                url: base_url + 'freelancer/save_company_overview',                
                data: updatedata,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                if(success == 1)
                {                    
                    company_overview = result.data.user_company_overview;
                    $scope.company_overview = company_overview;                
                }
                $("#company_overview_save").removeAttr("style");
                $("#company_overview_loader").hide();
                $("#company-overview").modal('hide');
                var profile_progress = result.data.profile_progress;
                var count_profile_value = profile_progress.user_process_value;
                var count_profile = profile_progress.user_process;
                $scope.progress_status = profile_progress.progress_status;
                $scope.set_progress(count_profile_value,count_profile);
            });
        }
    };

    $scope.get_user_company_overview = function(){
        $http({
            method: 'POST',
            url: base_url + 'freelancer/get_user_company_overview',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.company_overview = result.data.user_company_overview;                
            }
            $("#company-overview-loader").hide();
            $("#company-overview-body").show();
        });
    };
    $scope.get_user_company_overview();
    //Company Overview End
});