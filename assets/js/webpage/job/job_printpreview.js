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
app.controller('userJobProfileController', function ($scope, $http, $location,$compile) {
    var all_months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $scope.user = {};
    $scope.$parent.title = "Details | Aileensoul";
    $scope.old_count_profile = 0;
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;    
    $scope.user_slug = user_data_slug;    
    $scope.segment2 = segment2;    

    $(document).on('change','select', function(e){
        $(this).addClass("custom-color");
    });
    angular.element(document).ready(function () {
        
        if (screen.width <= 1199) {
            $("#edit-profile-move").appendTo($(".edit-profile-move"));
            $("#skill-move").appendTo($(".skill-move"));
            $("#social-link-move").appendTo($(".social-link-move"));
            $("#idol-move").appendTo($(".idol-move"));
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
        if (screen.width > 768) {
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

    //Education Start
    $scope.get_edu_degree = function(){
        $http.get(base_url + "userprofile_page/get_edu_degree").then(function (success) {
            $scope.degree_data = success.data.degree_data;
        }, function (error) {});
    };
    $scope.get_edu_degree();

    $scope.get_edu_university = function(){
        $http.get(base_url + "userprofile_page/get_edu_university").then(function (success) {
            $scope.university_data = success.data.university_data;
        }, function (error) {});
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

            $http.post(base_url + 'job/save_user_education', edu_formdata,
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
                }
            });
        }
    };

    $scope.get_user_education = function(){
        $http({
            method: 'POST',
            url: base_url + 'job/get_user_education',
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
                $("#edution-loader").hide();
                $("#edution-body").show();
            }

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

            var inner_html = '<p id="edu_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+job_user_education_upload_url+edu_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';

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
                url: base_url + 'job/delete_user_education',
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
    //Education End

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

            $http.post(base_url + 'job/save_user_project', project_formdata,
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
            });
        }
    };

    $scope.get_user_project = function(){
        $http({
            method: 'POST',
            url: base_url + 'job/get_user_project',
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
                var inner_html = '<p id="project_file_prev" class="screen-shot"><a href="'+job_user_project_upload_url+proj_file_name+'" target="_blank"><img style="width: 100px;" src="'+job_user_project_upload_url+proj_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="project_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+job_user_project_upload_url+proj_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
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
                url: base_url + 'job/delete_user_project',
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

            $http.post(base_url + 'job/save_user_activity', activity_formdata,
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
            });
        }
    };

    $scope.get_user_activity = function(){
        $http({
            method: 'POST',
            url: base_url + 'job/get_user_activity',
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
                $("#activity-loader").hide();
                $("#activity-body").show();
            }

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
                var inner_html = '<p id="activity_file_prev" class="screen-shot"><a href="'+job_user_activity_upload_url+activity_file_name+'" target="_blank"><img style="width: 100px;" src="'+job_user_activity_upload_url+activity_file_name+'"></a></p>';
            }
            else if ($.inArray(fileExt.toLowerCase(), allowed_doc_ext) !== -1) {*/
                var inner_html = '<p id="activity_file_prev" class="screen-shot"><a class="file-preview-cus" href="'+job_user_activity_upload_url+activity_file_name+'" target="_blank"><img src="'+base_url+'assets/n-images/detail/file-up-cus.png"></a></p>';   
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
                url: base_url + 'job/delete_user_activity',
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
            });
        }
    };
    //Extracurricular Activity End
});