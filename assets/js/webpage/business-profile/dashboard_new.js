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
app.controller('businessProfileController', function ($scope, $http, $location, $window,$compile) {
    var all_months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $scope.all_months = all_months;
    $scope.from_user_id = from_user_id;
    $scope.to_user_id = to_user_id;
    $scope.get_business_info = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_business_info',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.business_info_data = result.data.business_info_data;
            }
            $("#business-loader").hide();
            $("#business-body").show();
        });
    }
    $scope.get_business_info();

    $scope.get_opening_hours = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_opening_hours',
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.bus_opening_hours = result.data.bus_opening_hours;                
            }
            $("#hours-loader").hide();
            $("#hours-body").show();
        });
    };
    $scope.get_opening_hours();

    $scope.get_user_links = function()
    {
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_user_links',
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

        });
    };
    $scope.get_user_links();

    $scope.get_business_story = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_business_story',            
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.story_data = result.data.story_data;
                $("#story-loader").hide();
                $("#story-body").show();
            }
        });
    };
    $scope.get_business_story();

    $scope.open_business_story = function(){
        // $("#bus-portfolio").addClass("edit-form-cus");
        if($scope.story_data)
        {
            var story_file_name = $scope.story_data.story_file;        
            if(story_file_name.trim() != "")
            {
                var filename_arr = story_file_name.split('.');
                $("#story_file_prev1").remove();
                var allowed_img_ext = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
                var allowed_doc_ext = ['pdf','PDF','docx','doc'];
                var fileExt = filename_arr[filename_arr.length - 1];

                var inner_html = '<p id="story_file_prev1" class="screen-shot"><a class="file-preview-cus" href="'+business_user_story_upload_url+story_file_name+'" target="_blank"><img src="'+business_user_story_upload_url+story_file_name+'" style="width:100%;"></a></p>';

                var contentTr = angular.element(inner_html);
                contentTr.insertAfter($("#upload-file1"));
                $compile(contentTr)($scope);
            }
        }

        $("#bus-name-started-display").modal("show");
    };

    $scope.get_menu_info = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_menu_info',
            //data: 'u=' + user_id,
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.menu_info_data = result.data.menu_info_data;
            }
            $("#menu-loader").hide();
            $("#menu-body").show();

        });
    }
    $scope.get_menu_info();

    $scope.openModal = function() {
        document.getElementById('myModalPhotos').style.display = "block";
        // $("body").addClass("modal-open");
    };
    $scope.closeModal = function() {    
        document.getElementById('myModalPhotos').style.display = "none";
        // $("body").removeClass("modal-open");
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

    $scope.get_review = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_review',            
            data: 'to_user_id=' + to_user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.review_data = result.data.review_data;
                $scope.review_count = result.data.review_count;
                $scope.avarage_review = result.data.avarage_review;                
                setTimeout(function(){
                    $("#avarage_review").val($scope.avarage_review);
                    $("#avarage_review").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                    $(".user-rating").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                    $("#review-loader").hide();
                    $("#review-body").show();
                },1000);
            }
        });
    };
    $scope.get_review();

    var business_review_formdata = new FormData();
    $(document).on('change','#review_file', function(e){
        $("#review_file_error").hide();
        if(this.files[0].size > 10485760)
        {
            $("#review_file_error").html("File size must be less than 10MB.");
            $("#review_file_error").show();
            $(this).val("");
            return true;
        }
        else
        {
            var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF'];
            var ext = $(this).val().split('.');        
            if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
                business_review_formdata.append('review_file', $('#review_file')[0].files[0]);
            }
            else {
                $("#review_file_error").html("Invalid file selected.");
                $("#review_file_error").show();
                $(this).val("");
            }         
        }
    });

    $scope.business_review_validate = {
        rules: {
            review_star: {
                required: true,
            },
            review_desc: {
                required: true,
            },
        },
        messages: {
            review_star: {
                required: "Please select start",
            },
            review_desc: {
                required: "Please enter rating review description",
            },
        },
    };

    $scope.save_review = function(){
        if ($scope.business_review.validate())
        {
            $("#review_loader").show();
            $("#save_review").attr("style","pointer-events:none;display:none;");

            business_review_formdata.append('from_user_id', from_user_id);
            business_review_formdata.append('to_user_id', to_user_id);
            business_review_formdata.append('review_star', $('#review_star').val());
            business_review_formdata.append('review_star', $('#review_star').val());
            business_review_formdata.append('review_desc', $('#review_desc').val());

            $http.post(base_url + 'business_profile_live/save_review', business_review_formdata,
            {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined, 'Process-Data': false},
            })            
            .then(function (result) {                
                // $('#main_page_load').show();                
                success = result.data.success;
                $("#business_review")[0].reset();
                if(success == 1)
                {
                    $("#review_loader").hide();
                    $("#save_review").removeAttr("style");
                    $scope.review_data = result.data.review_data;
                    $scope.review_count = result.data.review_count;
                    $scope.avarage_review = result.data.avarage_review;                
                    setTimeout(function(){
                        // $("#rating-1").val($scope.avarage_review);
                        $("#avarage_review").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                        $('#avarage_review').rating('update', $scope.avarage_review);
                        $(".user-rating").rating({min:0, max:5, step:0.5, size:'sm',readonly:true});
                    },1000);

                    $("#reviews").modal("hide");
                }
                else if(success == 0)
                {                    
                    $("#reviews").modal("hide");
                }
            });
        }
    };

    //Job Opening Start
    $scope.get_business_job_opening = function(){
        $http({
            method: 'POST',
            url: base_url + 'business_profile_live/get_business_job_opening',
            data: 'user_slug=' + user_slug,//Pratik
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (result) {
            $('body').removeClass("body-loader");
            success = result.data.success;
            if(success == 1)
            {
                $scope.jobs_data = result.data.jobs_data;
                $scope.rec_profile = result.data.rec_profile;
                $("#jobs-loader").hide();
                $("#jobs-body").show();
            }
        });
    };
    $scope.get_business_job_opening();
    //Job Opening End
});