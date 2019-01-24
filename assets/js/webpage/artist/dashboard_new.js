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
app.controller('artistDashboardController', function ($scope, $http, $location, $window,$compile)
{
    var all_months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $scope.all_months = all_months;

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
    };
    // $scope.get_artist_basic_info();

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
    // $scope.get_user_bio();

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
    };
    // $scope.get_user_talent_cat_data();

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
    };
    // $scope.get_user_specialities();

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
    };
    // $scope.get_user_art_imp_data();

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
            }
            setTimeout(function(){
                $(".exp-y-m-inner").show();
            },500);
            $("#exp-loader").hide();
            $("#exp-body").show();

        });
    };
    // $scope.get_user_experience();

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
    // $scope.get_user_award();

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

    setTimeout(function(){
        $scope.get_user_links();
        $scope.get_user_award();
        $scope.get_user_experience();
        $scope.get_user_art_imp_data();
        $scope.get_user_specialities();
        $scope.get_user_talent_cat_data();
    },5000);
    $scope.get_user_bio();
    $scope.get_artist_basic_info();
});