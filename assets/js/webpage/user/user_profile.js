var scopeHold;
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
    $scope.active = url.substring(url.lastIndexOf("/") + 1)
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


    $scope.contact = function (id, status, to_id, confirm = 0) {
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
            $scope.contact_value = success.data.trim();
        });
    }

    $scope.remove_contact = function (id, status, to_id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addcontact',
            data: 'contact_id=' + id + '&status=' + status + '&to_id=' + to_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {                    
            $scope.contact_value = success.data.trim();
        });
    }

    $scope.confirmContactRequestInnerHeader = function (from_id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=confirm',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $scope.contact_value = 'confirm';
        });
    }
    $scope.follow = function (id, status, to_id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addfollow',
            data: 'follow_id=' + id + '&status=' + status + '&to_id=' + to_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.follow_value = success.data;
                });
    }
});
app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/profiles/:name*", {
                templateUrl: base_url + "userprofile_page/profile",
                controller: 'profilesController'
            })
            .when("/dashboard/:name*", {
                templateUrl: base_url + "userprofile_page/dashboard",
                controller: 'dashboardController'
            })
            .when("/dashboard/photos/:name*", {
                templateUrl: base_url + "userprofile_page/photos",
                controller: 'dashboardPhotosController'
            })
            .when("/details/:name*", {
                templateUrl: base_url + "userprofile_page/details",
                controller: 'detailsController'
            })
            .when("/contacts/:name*", {
                templateUrl: base_url + "userprofile_page/contacts",
                controller: 'contactsController'
            })
            .when("/followers/:name*", {
                templateUrl: base_url + "userprofile_page/followers",
                controller: 'followersController'
            })
            .when("/following/:name*", {
                templateUrl: base_url + "userprofile_page/following",
                controller: 'followingController'
            })
            .when("/questions/:name*", {
                templateUrl: base_url + "userprofile_page/questions",
                controller: 'questionsController'
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
            .when(":name*\/questions", {
                templateUrl: base_url + "userprofile_page/questions",
                controller: 'questionsController'
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
    $scope.user = {};
    // PROFEETIONAL DATA
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
        });
    }
    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height())) {
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
    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 6;
    $scope.buttonText = "Load More";

    
    // Fetch data
    $scope.getDashboardPdf = function (pagenum) {
        $('.post_loader').show();
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
                if ($scope.pdfData != undefined) {
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.pdfrecord) {
                        $scope.pdfData.push(response.data.pdfrecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.pdfData = response.data.pdfrecord;
                }                
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height())) {
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
                setTimeout(function(){ $('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */); }, 300);
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height())) {
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
    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 6;
    $scope.buttonText = "Load More";

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

    
    // Fetch data
    $scope.getDashboardVideos = function (pagenum) {
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
                    $scope.page_number = response.data.videoData.pagedata.page;
                    for (var i in response.data.videoData.videorecord) {
                        $scope.videoData.push(response.data.videoData.videorecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data.videoData;
                    $scope.videoData = response.data.videoData.videorecord;
                }
                if(pagenum == "" || pagenum == 1)
                {
                    $scope.allVideosData = response.data.allVideosData;   
                }
                setTimeout(function(){ $('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */); }, 300);
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height())) {
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
    // Fetch data
    $scope.getDashboardPhotos = function (pagenum) {
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
            url: base_url + "userprofile_page/photos_data?page=" + pagenum+"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            $('.post_loader').hide();
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
                    $scope.page_number = response.data.photosData.pagedata.page;
                    for (var i in response.data.photosData.photosrecord) {
                        $scope.photoData.push(response.data.photosData.photosrecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data.photosData;
                    $scope.photoData = response.data.photosData.photosrecord;
                }
                if(pagenum == "" || pagenum == 1)
                {
                    $scope.allPhotosData = response.data.allPhotosData;   
                }
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height())) {
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

    setTimeout(function(){        
        var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="6296725909" inline-style="display:block;" ad-format="fluid" data-ad-layout-key="-6r+eg+1e-3d+36"  ad-class="infeed"></adsense>').appendTo('.tab-add');
        $compile($el)($scope);

        var $elm = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
            $compile($elm)($scope);
    },2000);
    
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

    /*$("#post-popup").on('hidden.bs.modal', function (event) {
        $("#post_something")[0].reset();
    });

    $("#opportunity-popup").on('hidden.bs.modal', function (event) {
        $("#post_opportunity")[0].reset();
    });*/
    $scope.opp = {};
    $scope.sim = {};
    $scope.ask = {};
    $scope.postData = {};
    $scope.opp.post_for = 'opportunity';
    $scope.sim.post_for = 'simple';
    $scope.ask.post_for = 'question';
    $scope.user_id = user_id;
    getUserDashboardPost();
    getUserDashboardImage();
    getUserDashboardVideo();
    getUserDashboardArticle();
    getUserDashboardInformation()
    getUserDashboardAudio();
    getUserDashboardPdf();

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
                    getUserDashboardPostLoad(pagenum);
                }
            }
        }
    });
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
            check_no_post_data();
            $('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */);
        }, function (error) {});
    }

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
                check_no_post_data();
            } else {
                // processing = false;
                // isLoadingData = false;
                isLoadingData = true;
                $scope.showLoadmore = false;
            }
            $('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */);
        }, function (error) {});
    }

    function getUserDashboardImage(pagenum) {        
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardImage?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postImageData = success.data.userDashboardImage;
            $scope.postAllImageData = success.data.userDashboardImageAll;
        }, function (error) {});
    }

    function getUserDashboardVideo(pagenum) {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardVideo?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postVideoData = success.data.userDashboardVideo;
            $scope.postAllVideoData = success.data.userDashboardVideoAll;
            setTimeout(function(){ $('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */); }, 300);
            
        }, function (error) {});
    }

    function getUserDashboardArticle() {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardArticle?user_slug=" + user_slug).then(function (success)
        {
            $('#loader').hide();
            $scope.postArticleData = success.data.userDashboardArticle;            
        }, function (error) {});
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
            $scope.details_data = details_data;            
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
        });
    }

    function getUserDashboardAudio(pagenum) {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardAudio?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postAudioData = success.data.userDashboardAudio;
            $scope.postAllAudioData = success.data.userDashboardAudioAll;
            setTimeout(function(){ $('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */); }, 300);
        }, function (error) {});
    }

    function getUserDashboardPdf(pagenum) {
        $('#loader').show();
        $http.get(base_url + "user_post/getUserDashboardPdf?user_slug=" + user_slug).then(function (success) {
            $('#loader').hide();
            $scope.postPdfData = success.data.userDashboardPdf;
            $('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */);
        }, function (error) {});
    }

    getFieldList();
    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {});
    }
    if(user_id != "")
    {
        getContactSuggetion();
        function getContactSuggetion() {
            $http.get(base_url + "user_post/getContactSuggetion").then(function (success) {
                $scope.contactSuggetion = success.data;
                //console.log($scope.contactSuggetion);
            }, function (error) {});
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

    $scope.post_opportunity_check = function (event,postIndex) {

        if (document.getElementById("opp_edit_post_id"+postIndex)) {
            var post_id = document.getElementById("opp_edit_post_id"+postIndex).value;
        } else {
            var post_id = 0;
        }        
        if (post_id == 0) {
            var fileInput = document.getElementById("fileInput").files;
            var description = $scope.opp.description;//document.getElementById("description").value;            
            var job_title = $scope.opp.job_title;
            var location = $scope.opp.location;
            var fields = $scope.opp.field;
            var otherField_edit = $scope.opp.otherField_edit;
            
            if( (fileCountOpp == 0 && (description == '' || description == undefined)) || ((job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields == undefined || fields == '') || (fields == 0 && otherField_edit == "")))
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. All fields are mandatory.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            }
            else
            {
                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg'];
                var allowesvideo = ['mp4', 'webm', 'mov', 'MP4'];
                var allowesaudio = ['mp3','mpeg'];
                var allowespdf = ['pdf'];
                var imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                if(fileCountOpp > 0 && fileCountOpp < 11)
                {
                    $.each(formFileExtOpp, function( index, value ) {
                        //console.log( index + ": " + value );
                        if($.inArray(value, allowedExtensions) > -1)
                        {
                            imgExt = true;
                        }
                        if($.inArray(value, allowesvideo) > -1)
                        {
                            videoExt = true;
                        }
                        if($.inArray(value, allowesaudio) > -1)
                        {
                            audioExt = true;
                        }
                        if($.inArray(value, allowespdf) > -1)
                        {
                            pdfExt = true;
                        }
                    });

                    if(imgExt == true && (videoExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                    }
                    if(videoExt == true && (imgExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either video or photo or  audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    if(audioExt == true && (imgExt == true || videoExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either audio or photo or video or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(audioExt == true && (description == '' || description == undefined))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter Audio Title.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }

                    }
                    if(pdfExt == true && (imgExt == true || videoExt == true || audioExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either pdf or photo or video or audio. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(pdfExt == true && (description == '' || description == undefined))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter PDF Title.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }
                    }
                }
                else
                {
                    if((description == '' || description == undefined) || ((job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields.trim() == undefined || fields.trim() == '')))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to Post Opportunity.");
                        $('#posterrormodal').modal('show');
                        //$("#post_opportunity")[0].reset();
                        //setInterval('window.location.reload()', 10000);
                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();
                            }
                        });
                        //event.preventDefault();
                        return false;
                    }
                }

                for (var i = 0; i < fileCountOpp; i++)
                {
                    var vname = fileNamesArrOpp[i];
                    var vfirstname = fileNamesArrOpp[i];
                    var ext = vfirstname.split('.').pop();
                    var ext1 = vname.split('.').pop();
                    var foundPresent = $.inArray(ext, allowedExtensions) > -1;
                    var foundPresentvideo = $.inArray(ext, allowesvideo) > -1;
                    var foundPresentaudio = $.inArray(ext, allowesaudio) > -1;
                    var foundPresentpdf = $.inArray(ext, allowespdf) > -1;

                    if (foundPresent == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;
                        if (foundPresent1 == true && fileCountOpp >= 11) {                        
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 photos at a time.");
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                        if (foundPresent1 == true && fileCountOpp == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single video.");
                            $('#posterrormodal').modal('show');
                            // setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentaudio == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;
                        if (foundPresent1 == true && fileCountOpp == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single audio.");
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentpdf == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowespdf) > -1;
                        if (foundPresent1 == true && fileCountOpp == 1) {
                        } else {                            
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single PDF.");                            
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            //$("#post_opportunity")[0].reset();
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();

                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == false) {

                        $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                        $('#posterrormodal').modal('show');
                        //setInterval('window.location.reload()', 10000);
                        //$("#post_opportunity")[0].reset();
                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();

                            }
                        });
                        event.preventDefault();
                        return false;
                    }
                }

                /*var form_data = new FormData();
                $.each($("#fileInput")[0].files, function(i, file) {
                    form_data.append('postfiles[]', file);
                });*/

                formFileDataOpp.append('description', $scope.opp.description);
                formFileDataOpp.append('field', $scope.opp.field);
                formFileDataOpp.append('other_field', otherField_edit);
                formFileDataOpp.append('job_title', JSON.stringify($scope.opp.job_title));
                formFileDataOpp.append('location', JSON.stringify($scope.opp.location));
                formFileDataOpp.append('post_for', $scope.opp.post_for);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');

                //$('.post_loader').show();
                $('#progress_div').show();
                var bar = $('.progress-bar');
                var percent = $('.sr-only');
                $http.post(base_url + 'user_post/post_opportunity', formFileDataOpp,
                        {
                            transformRequest: angular.identity,
                            headers: {'Content-Type': undefined, 'Process-Data': false},
                            uploadEventHandlers: {
                                progress: function(e) {
                                     if (e.lengthComputable) {
                                        progress = Math.round(e.loaded * 100 / e.total);

                                        bar.width((progress - 1) +'%');
                                        percent.html((progress - 1) +'%');

                                        //console.log("progress: " + progress + "%");
                                        if (e.loaded == e.total) {
                                            /*setTimeout(function(){
                                                $('#progress_div').hide();
                                                progress = 0;
                                                bar.width(progress+'%');
                                                percent.html(progress+'%');
                                            }, 2000);*/
                                            //console.log("File upload finished!");
                                            //console.log("Server will perform extra work now...");
                                        }
                                    }
                                }
                            }
                        })
                        .then(function (success) {

                            if (success) {
                                $("#post_opportunity")[0].reset();
                                $('.post_loader').hide();
                                $scope.opp.description = ' ';
                                $scope.opp.job_title = '';
                                $scope.opp.location = '';
                                $scope.opp.field = '';
                                $scope.opp.postfiles = '';
                                document.getElementById('fileInput').value = '';

                                $('.file-preview-thumbnails').html('');
                                //$scope.postData.splice(0, 0, success.data[0]);
                                getUserDashboardPost();
                                if (foundPresent == true)
                                {
                                    getUserDashboardImage();
                                }
                                if (foundPresentvideo == true)
                                {
                                    getUserDashboardVideo();
                                }
                                if (foundPresentaudio == true)
                                {
                                    getUserDashboardAudio();
                                }
                                if (foundPresentpdf == true)
                                {
                                    getUserDashboardPdf();
                                }

                                bar.width(100+'%');
                                percent.html(100+'%');
                                setTimeout(function(){                                    
                                    progress = 0;
                                    // bar.width(progress+'%');
                                    // percent.html(progress+'%');
                                }, 2000);

                                imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                                cntImgOpp = 0;
                                formFileDataOpp = new FormData();
                                fileCountOpp = 0;
                                fileNamesArrOpp = [];
                                formFileExtOpp = [];
                                $("#selectedFilesOpp").html("");
                                $("#fileCountOpp").text("");

                                $('video, audio').mediaelementplayer({'pauseOtherPlayers': true});
                            }
                        });
            }

        } else {
            //var description = $("#description_edit_"+post_id).val();//$scope.opp.description;//document.getElementById("description").value;
            var description = $('#description_edit_' + post_id).html();
            description = description.replace(/&nbsp;/gi, " ");
            description = description.replace(/<br>$/, '');
            description = description.replace(/&gt;/gi, ">");
            description = description.replace(/&/g, "%26");            
            description = description.trim();
            var job_title = $scope.opp.job_title_edit;
            var location = $scope.opp.location_edit;
            var fields = $("#field_edit"+post_id).val();            
            var otherField_edit = $("#otherField_edit"+post_id).val();//$scope.opp.otherField_edit;

            if((job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields == undefined || fields == '') || (fields == 0 && otherField_edit == ""))
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {


                var form_data = new FormData();

                form_data.append('description', description);
                form_data.append('field', fields);
                form_data.append('other_field', otherField_edit);
                form_data.append('job_title', JSON.stringify(job_title));
                form_data.append('location', JSON.stringify(location));
                form_data.append('post_for', $scope.opp.post_for);
                form_data.append('post_id', post_id);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#login_ajax_load"+post_id).show();
                $("#save_"+post_id).attr("style","pointer-events: none;");
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {
                            $("#login_ajax_load"+post_id).hide();
                            $("#save_"+post_id).attr("style","pointer-events: all;");
                            if (success.data.response == 1) {
                                $scope.postData[postIndex].opportunity_data.field = success.data.opp_field;
                                $scope.postData[postIndex].opportunity_data.field_id = success.data.field_id;
                                $scope.postData[postIndex].opportunity_data.location = success.data.opp_location;
                                $scope.postData[postIndex].opportunity_data.opportunity_for = success.data.opp_opportunity_for;
                                $scope.postData[postIndex].opportunity_data.opportunity = success.data.opportunity;
                                $("#post_opportunity_edit")[0].reset();

                                $("#edit-opp-post-"+post_id).hide();
                                $('#post-opp-detail-' + post_id).show();   
                                // $('#opp-post-opportunity-for-' + post_id).html(success.data.opp_opportunity_for);
                                // $('#opp-post-location-' + post_id).html(success.data.opp_location);
                                // $('#opp-post-field-' + post_id).html(success.data.opp_field);
                                // $('#opp-post-opportunity-' + post_id).html(success.data.opportunity);

                                //                                $scope.opp.description = '';
                                //                                $scope.opp.job_title = '';
                                //                                $scope.opp.location = '';
                                //                                $scope.opp.field = '';
                                //                                $scope.opp.postfiles = '';
                            }

                        });
            }

        }
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
                });
    }
    $scope.ask_question_check = function (event) {

        if (document.getElementById("ask_edit_post_id")) {
            var post_id = document.getElementById("ask_edit_post_id").value;
        } else {
            var post_id = 0;
        }
        if (post_id == 0) {
            var field = document.getElementById("ask_field").value;
            var description = document.getElementById("ask_que").value;
            var description = description.trim();
            var fileInput = document.getElementById("fileInput2").files;
            if ((field == '') || (description == ''))
            {
                $('#post .mes').html("<div class='pop_content'>Ask question and Field is required.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {

                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg'];
                
                var imgExtNot = false;

                if(fileCountQue > 0)
                {
                    $.each(formFileExtQue, function( index, value ) {
                        //console.log( index + ": " + value );
                        if($.inArray(value, allowedExtensions) == -1)
                        {
                            imgExtNot = true;
                        }                        
                    });

                    if(imgExtNot == true || fileCountQue > 10)
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload photo. You cannot upload more than 10 photos at a time.");
                            $('#posterrormodal').modal('show');
                            //$("#post_opportunity")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                    }                    
                }

                /*var form_data = new FormData();
                angular.forEach($scope.files, function (file) {
                    form_data.append('postfiles[]', file);
                });*/
                //form_data.append('postfiles',$scope.ask.postfiles);
                formFileDataQue.append('question', $scope.ask.ask_que);
                formFileDataQue.append('description', $scope.ask.ask_description);
                formFileDataQue.append('field', $scope.ask.ask_field);
                formFileDataQue.append('other_field', $scope.ask.otherField);
                formFileDataQue.append('category', JSON.stringify($scope.ask.related_category));
                formFileDataQue.append('weblink', $scope.ask.web_link);
                formFileDataQue.append('post_for', $scope.ask.post_for);
                formFileDataQue.append('is_anonymously', $scope.ask.is_anonymously);

                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#ask-question").modal('hide');
                //$('.post_loader').show();
                // $.each($("#fileInput2")[0].files, function(i, file) {
                //     form_data.append('postfiles[]', file);
                // });
                $('#progress_div').show();
                var bar = $('.progress-bar');
                var percent = $('.sr-only');

                $http.post(base_url + 'user_post/post_opportunity', formFileDataQue,
                        {
                            transformRequest: angular.identity,
                            headers: {'Content-Type': undefined, 'Process-Data': false},
                            uploadEventHandlers: {
                                progress: function(e) {
                                     if (e.lengthComputable) {
                                        progress = Math.round(e.loaded * 100 / e.total);

                                        bar.width((progress - 1) +'%');
                                        percent.html((progress - 1) +'%');

                                        //console.log("progress: " + progress + "%");
                                        if (e.loaded == e.total) {
                                            /*setTimeout(function(){
                                                $('#progress_div').hide();
                                                progress = 0;
                                                bar.width(progress+'%');
                                                percent.html(progress+'%');
                                            }, 2000);*/
                                            //console.log("File upload finished!");
                                            //console.log("Server will perform extra work now...");
                                        }
                                    }
                                }
                            }
                        })
                        .then(function (success) {
                            if (success) {
                                window.location = base_url+user_slug+"/questions";
                                $('.post_loader').hide();
                                $scope.opp.description = '';
                                $scope.opp.job_title = '';
                                $scope.opp.location = '';
                                $scope.opp.field = '';
                                $scope.opp.postfiles = '';
                                document.getElementById('fileInput2').value = '';
                                $('.file-preview-thumbnails').html('');
                                $scope.ask.postfiles = '';
                                $scope.ask.ask_que = '';
                                $scope.ask.ask_description = '';
                                $scope.ask.ask_field = '';
                                $scope.ask.otherField = '';
                                $scope.ask.related_category = '';
                                $scope.ask.web_link = '';
                                $scope.ask.post_for = 'question';
                                $scope.ask.is_anonymously = '';

                                //$scope.postData.splice(0, 0, success.data[0]);
                                getUserDashboardPost();
                                getUserDashboardImage();

                                bar.width(100+'%');
                                percent.html(100+'%');
                                setTimeout(function(){                                    
                                    progress = 0;
                                    // bar.width(progress+'%');
                                    // percent.html(progress+'%');
                                }, 2000);
                                imgExt = false;
                                cntImgQue = 0;
                                formFileDataQue = new FormData();
                                fileCountQue = 0;
                                fileNamesArrQue = [];
                                formFileExtQue = [];
                                $("#selectedFilesQue").html("");
                                $("#fileCountQue").text("");
                                $('video, audio').mediaelementplayer({'pauseOtherPlayers': true});
                            }
                        });
            }

        } else {

            var field = document.getElementById("ask_field").value;
            var description = document.getElementById("ask_que").value;
            var description = description.trim();
            if ((field == '') || (description == ''))
            {
                $('#post .mes').html("<div class='pop_content'>Ask question and Field is required.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                event.preventDefault();
                return false;
            } else {


                var form_data = new FormData();

                form_data.append('question', $scope.ask.ask_que);
                form_data.append('description', $scope.ask.ask_description);
                form_data.append('field', $scope.ask.ask_field);
                form_data.append('other_field', $scope.ask.otherField);
                form_data.append('category', JSON.stringify($scope.ask.related_category));
                form_data.append('weblink', $scope.ask.web_link);
                form_data.append('post_for', $scope.ask.post_for);
                form_data.append('is_anonymously', $scope.ask.is_anonymously);
                form_data.append('post_id', post_id);
                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#ask-question").modal('hide');
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {
                            if (success) {
                                if (success.data.response == 1) {
                                    $('#ask-post-question-' + post_id).html(success.data.ask_question);
                                    $('#ask-post-description-' + post_id).html(success.data.ask_description);
                                    //   $('#ask-post-link-' + post_id).html(success.data.opp_field);
                                    $('#ask-post-category-' + post_id).html(success.data.ask_category);
                                    $('#ask-post-field-' + post_id).html(success.data.ask_field);
                                }
                                $scope.opp.description = '';
                                $scope.opp.job_title = '';
                                $scope.opp.location = '';
                                $scope.opp.field = '';
                                $scope.opp.postfiles = '';
                                document.getElementById('fileInput').value = '';

                                $scope.ask.postfiles = '';
                                $scope.ask.ask_que = '';
                                $scope.ask.ask_description = '';
                                $scope.ask.ask_field = '';
                                $scope.ask.otherField = '';
                                $scope.ask.related_category = '';
                                $scope.ask.web_link = '';
                                $scope.ask.post_for = '';
                                $scope.ask.is_anonymously = '';

                                $scope.postData.splice(0, 0, success.data[0]);
                                $('video, audio').mediaelementplayer({'pauseOtherPlayers': true});
                            }
                        });
            }
        }
    }
    
    
       
     $scope.lightbox = function (idx) {
                 //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
            var ninjaSldr = document.getElementById("ninja-slider");
            ninjaSldr.parentNode.style.display = "block";

            nslider.init(idx);

            var fsBtn = document.getElementById("fsBtn");
            fsBtn.click();
  
    };
    
    function fsIconClick(isFullscreen, ninjaSldr) { //fsIconClick is the default event handler of the fullscreen button
            if (isFullscreen) {
                ninjaSldr.parentNode.style.display = "none";
            }
        }


    // POST SOMETHING UPLOAD START

    $scope.post_something_check = function (event,postIndex) {        
        //alert(postIndex);return false;
        if (document.getElementById("edit_post_id"+postIndex)) {
            var post_id = document.getElementById("edit_post_id"+postIndex).value;
        } else {
            var post_id = 0;
        }        
        if (post_id == 0) {
            var fileInput = document.getElementById("fileInput1").files;

            var description = $scope.sim.description;//document.getElementById("description").value;
            //var description = description.trim();
            var fileInput1 = document.getElementById("fileInput1").value;
            //console.log(fileInput1);

            if (fileCountSim == 0 && description == '')
            {
                $('#posterrormodal .mes').html("<div class='pop_content'>This post appears to be blank. Please write or attach (photos, videos, audios, pdf) to post.1");
                $('#posterrormodal').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                // $("#post_something")[0].reset();
                //event.preventDefault();
                return false;
            } else {

                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF', 'psd', 'PSD', 'bmp', 'BMP', 'tiff', 'TIFF', 'iff', 'IFF', 'xbm', 'XBM', 'webp', 'WebP', 'HEIF', 'heif', 'BAT', 'bat', 'BPG', 'bpg', 'SVG', 'svg'];
                var allowesvideo = ['mp4', 'webm', 'mov', 'MP4'];
                var allowesaudio = ['mp3','mpeg'];
                var allowespdf = ['pdf'];
                var imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                if(fileCountSim > 0 && fileCountSim < 11)
                {
                    $.each(formFileExtSim, function( index, value ) {
                        //console.log( index + ": " + value );
                        if($.inArray(value, allowedExtensions) > -1)
                        {
                            imgExt = true;
                        }
                        if($.inArray(value, allowesvideo) > -1)
                        {
                            videoExt = true;
                        }
                        if($.inArray(value, allowesaudio) > -1)
                        {
                            audioExt = true;
                        }
                        if($.inArray(value, allowespdf) > -1)
                        {
                            pdfExt = true;
                        }
                    });

                    if(imgExt == true && (videoExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            $("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                    }
                    if(videoExt == true && (imgExt == true || audioExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either video or photo or  audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            $("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    if(audioExt == true && (imgExt == true || videoExt == true || pdfExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either audio or photo or video or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            $("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(audioExt == true && (description == '' || description == undefined || description == ' '))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter Audio Title.");
                            $('#posterrormodal').modal('show');
                            $("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }

                    }
                    if(pdfExt == true && (imgExt == true || videoExt == true || audioExt == true))
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either pdf or photo or video or audio. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            $("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;                        
                    }
                    else
                    {
                        if(pdfExt == true && (description == '' || description == undefined || description == ' '))
                        {
                            $('.biderror .mes').html("<div class='pop_content'>Please Enter PDF Title.");
                            $('#posterrormodal').modal('show');
                            $("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false; 
                        }
                    }
                }
                else
                {
                    if(description == '' || description == undefined || description == ' ')
                    {
                        $('.biderror .mes').html("<div class='pop_content'>You cannot upload more than 10 files at a time.");
                        $('#posterrormodal').modal('show');
                        $("#post_something")[0].reset();
                        //setInterval('window.location.reload()', 10000);
                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();
                            }
                        });
                        //event.preventDefault();
                        return false;
                    }
                }



                for (var i = 0; i < fileCountSim; i++)
                {
                    var vname = fileNamesArrSim[i];
                    var vfirstname = fileNamesArrSim[i];
                    var ext = vfirstname.split('.').pop();
                    var ext1 = vname.split('.').pop();                    
                    var foundPresent = $.inArray(ext, allowedExtensions) > -1;
                    var foundPresentvideo = $.inArray(ext, allowesvideo) > -1;
                    var foundPresentaudio = $.inArray(ext, allowesaudio) > -1;
                    var foundPresentpdf = $.inArray(ext, allowespdf) > -1;

                    if (foundPresent == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowedExtensions) > -1;
                        if (foundPresent1 == true && fileCountSim >= 11) {                        
                            $('.biderror .mes').html("<div class='pop_content'>You can only upload one type of file at a time...either photo or video or audio or pdf. You cannot upload more than 10 files at a time.");
                            $('#posterrormodal').modal('show');
                            $("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);
                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    }
                    else if (foundPresentvideo == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesvideo) > -1;
                        if (foundPresent1 == true && fileCountSim == 1) {
                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single video.");
                            $('#posterrormodal').modal('show');
                            //setInterval('window.location.reload()', 10000);
                            $("#post_something")[0].reset();

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentaudio == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowesaudio) > -1;
                        if (foundPresent1 == true && fileCountSim == 1) {

                            /*if (product_name == '') {
                             $('.biderror .mes').html("<div class='pop_content'>You have to add audio title.");
                             $('#posterrormodal').modal('show');
                             //setInterval('window.location.reload()', 10000);
                             
                             $(document).on('keydown', function (e) {
                             if (e.keyCode === 27) {
                             //$( "#bidmodal" ).hide();
                             $('#posterrormodal').modal('hide');
                             $('.modal-post').show();
                             }
                             });
                             event.preventDefault();
                             return false;
                             } */

                        } else {
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single audio.");
                            $('#posterrormodal').modal('show');
                            $("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();
                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentpdf == true)
                    {
                        var foundPresent1 = $.inArray(ext1, allowespdf) > -1;
                        if (foundPresent1 == true && fileCountSim == 1) {

                            /*if (product_name == '') {
                             $('.biderror .mes').html("<div class='pop_content'>You have to add pdf title.");
                             $('#posterrormodal').modal('show');
                             setInterval('window.location.reload()', 10000);
                             
                             $(document).on('keydown', function (e) {
                             if (e.keyCode === 27) {
                             $('#posterrormodal').modal('hide');
                             $('.modal-post').show();
                             }
                             });
                             event.preventDefault();
                             return false;
                             } */
                        } else {
                            /*if (fileInput.length > 10) {
                                $('.biderror .mes').html("<div class='pop_content'>You can not upload more than 10 files at a time.");
                            } else {
                            }*/
                            $('.biderror .mes').html("<div class='pop_content'>Allowed to upload only single PDF.");
                            $('#posterrormodal').modal('show');
                            $("#post_something")[0].reset();
                            //setInterval('window.location.reload()', 10000);

                            $(document).on('keydown', function (e) {
                                if (e.keyCode === 27) {
                                    $('#posterrormodal').modal('hide');
                                    $('.modal-post').show();

                                }
                            });
                            //event.preventDefault();
                            return false;
                        }
                    } else if (foundPresentvideo == false) {

                        $('.biderror .mes').html("<div class='pop_content'>This File Format is not supported Please Try to Upload MP4 or WebM files..");
                        $('#posterrormodal').modal('show');
                        $("#post_something")[0].reset();
                        //setInterval('window.location.reload()', 10000);

                        $(document).on('keydown', function (e) {
                            if (e.keyCode === 27) {
                                $('#posterrormodal').modal('hide');
                                $('.modal-post').show();

                            }
                        });
                        //event.preventDefault();
                        return false;
                    }
                }

                /*var form_data = new FormData();
                $.each($("#fileInput1")[0].files, function(i, file) {
                    form_data.append('postfiles[]', file);
                });*/

               

                formFileDataSim.append('description', description);//$scope.sim.description);
                formFileDataSim.append('post_for', $scope.sim.post_for);
                //data.append('data', data);

                $('body').removeClass('modal-open');
                $("#post-popup").modal('hide');

                //$('.post_loader').show();
                $('#progress_div').show();
                var bar = $('.progress-bar');
                var percent = $('.sr-only');
                $http.post(base_url + 'user_post/post_opportunity', formFileDataSim,
                        {
                            transformRequest: angular.identity,
                            headers: {'Content-Type': undefined, 'Process-Data': false},
                            uploadEventHandlers: {
                                progress: function(e) {
                                     if (e.lengthComputable) {

                                        //document.getElementById("progress_div").style.display = "block";                                        
                                        
                                        progress = Math.round(e.loaded * 100 / e.total);

                                        bar.width((progress - 1) +'%');
                                        percent.html((progress - 1) +'%');

                                        //console.log("progress: " + progress + "%");
                                        if (e.loaded == e.total) {
                                            /*setTimeout(function(){
                                                $('#progress_div').hide();
                                                progress = 0;
                                                bar.width(progress+'%');
                                                percent.html(progress+'%');
                                            }, 2000);*/
                                            //console.log("File upload finished!");
                                            //console.log("Server will perform extra work now...");
                                        }
                                    }
                                }
                            }
                        })
                        .then(function (success) {
                            if (success) {
                                $("#post_something")[0].reset();
                                //$('.post_loader').hide();
                                $scope.sim.description = '';
                                $scope.sim.postfiles = '';
                                document.getElementById('fileInput1').value = '';
                                $('.file-preview-thumbnails').html('');
                                //$scope.postData.splice(0, 0, success.data[0]);                                
                                if (foundPresent == true)
                                {
                                    getUserDashboardImage();
                                }
                                if (foundPresentvideo == true)
                                {
                                    getUserDashboardVideo();
                                }
                                if (foundPresentaudio == true)
                                {
                                    getUserDashboardAudio();
                                }
                                if (foundPresentpdf == true)
                                {
                                    getUserDashboardPdf();
                                }
                                getUserDashboardPost();

                                bar.width(100+'%');
                                percent.html(100+'%');
                                setTimeout(function(){
                                    //$('#progress_div').hide();
                                    progress = 0;
                                    // bar.width(progress+'%');
                                    // percent.html(progress+'%');
                                }, 2000);

                                imgExt = false,videoExt = false,audioExt = false,pdfExt = false;

                                cntImgSim = 0;
                                formFileDataSim = new FormData();
                                fileCountSim = 0;
                                fileNamesArrSim = [];
                                formFileExtSim = [];
                                $("#selectedFiles").html("");
                                $("#fileCountSim").text("");

                                $('video, audio').mediaelementplayer({'pauseOtherPlayers': true});
                            }
                        });
            }
        } else {

            var description = $('#editPostTexBox-' + post_id).html();
            description = description.replace(/&nbsp;/gi, " ");
            description = description.replace(/<br>$/, '');
            description = description.replace(/&gt;/gi, ">");
            description = description.replace(/&/g, "%26");
        

            //var description = $("#editPostTexBox-"+post_id).val();//$scope.sim.description_edit;//document.getElementById("description").value;            
            description = description.trim();
            /*if (description == '')
            {
                $('#post .mes').html("<div class='pop_content'>This post appears to be blank. Please write to post.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {*/
                var form_data = new FormData();
                form_data.append('description', description);
                form_data.append('post_for', $scope.sim.post_for);
                form_data.append('post_id', post_id);

                $('body').removeClass('modal-open');
                $("#post-popup").modal('hide');
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined, 'Process-Data': false}
                })
                .then(function (success) {
                    if (success) {
                        $("#post_something_edit")[0].reset();
                        if (success.data.response == 1) {
                            $scope.postData[postIndex].simple_data.description = success.data.sim_description;
                            //$('#simple-post-description-' + post_id).html(success.data.sim_description);
                            //$('#simple-post-description-' + post_id).attr("dd-text-collapse-text",success.data.sim_description);
                            $('#edit-simple-post-' + post_id).hide();
                            $('#simple-post-description-' + post_id).show();
                            
                        }
                    }
                });
            //}

        }
    }

    $scope.loadMediaElement = function ()
    {
        $('video,audio').mediaelementplayer({'pauseOtherPlayers': true}/* Options */);
        var mediaElements = document.querySelectorAll('video, audio'), i, total = mediaElements.length;

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
        }
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
                $('#item-' + user_id + ' button.follow-btn').html('Request Send');
//                $('.owl-carousel').trigger('next.owl.carousel');
            }
        });
    }

    $scope.post_like = function (post_id) {
        if(user_id == "" || user_id == undefined)
        {
            $("#regmodal").modal("show");
            return false;
        }
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
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
            }
        });
    }

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
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                    .then(function (success) {
                        data = success.data;
                        if (data.message == '1') {
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
                });
    }
    $scope.editPostComment = function (comment_id, post_id, parent_index, index) {
        $(".comment-for-post-"+post_id+" .edit-comment").hide();
        $(".comment-for-post-"+post_id+" .comment-dis-inner").show();
        $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
        $(".comment-for-post-"+post_id+" li[id^=cancel-comment-li-]").hide();
        var editContent = $('#comment-dis-inner-' + comment_id).html();
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-"+post_id).hide();
    }

    $scope.cancelPostComment = function (comment_id, post_id, parent_index, index) {
        
        $('#edit-comment-' + comment_id).hide();
        
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-"+post_id).show();
    }

    $scope.EditPostNew = function (post_id, post_for, index) {
        if(post_for == "simple")
        {
            $("#edit-simple-post-"+post_id).show();
            var editContent = $scope.postData[index].simple_data.description//$('#simple-post-description-' + post_id).attr("ng-bind-html");
            $('#editPostTexBox-' + post_id).html(editContent.replace(/(<([^>]+)>)/ig,""));
            setTimeout(function(){
                //$('#editPostTexBox-' + post_id).focus();
                setCursotToEnd(document.getElementById('editPostTexBox-' + post_id));
            },100);            
            $('#simple-post-description-' + post_id).hide();            
        }
        else if(post_for == "opportunity")
        {
            var edit_location = [];
            var edit_jobtitle = [];
            var opportunity = $scope.postData[index].opportunity_data.opportunity;//$("#opp-post-opportunity-" + post_id).attr("dd-text-collapse-text");
            var job_title = $('#opp-post-opportunity-for-' + post_id).html().split(",");
            var city_names = $('#opp-post-location-' + post_id).html().split(",");
            //var field = ($scope.postData[index].opportunity_data.field == null || $scope.postData[index].opportunity_data.field == "" ? "Other" : $scope.postData[index].opportunity_data.field);//$('#opp-post-field-' + post_id).html()
            var field = $scope.postData[index].opportunity_data.field;
            var field_id = $scope.postData[index].opportunity_data.field_id;
            if(opportunity != "" && opportunity != undefined)
            {
                //$("#description_edit_" + post_id).val(opportunity.replace(/(<([^>]+)>)/ig,""));
                $("#description_edit_" + post_id).html(opportunity.replace(/(<([^>]+)>)/ig,""));
            }
            city_names.forEach(function(element,cityArrIndex) {
              edit_location[cityArrIndex] = {"city_name":element};
            });
            $scope.opp.location_edit = edit_location;

            job_title.forEach(function(element,jobArrIndex) {
              edit_jobtitle[jobArrIndex] = {"name":element};
            });
            $scope.opp.job_title_edit = edit_jobtitle;

            if(city_names.length > 0)
            {
                $('#location .input').attr('placeholder', '');
                $('#location .input').css('width', '200px');
            }
            if(job_title.length > 0)
            {
                $('#job_title .input').attr('placeholder', '');
                $('#job_title .input').css('width', '200px');
            }

            $('[id=field_edit'+post_id+'] option').filter(function() { 
                return (field_id != 0 ? $(this).text() == field : 'Other'); //To select Blue
            }).prop('selected', true);

            $scope.opp.field_edit = field_id;
            $scope.opp.otherField_edit = "";
            setTimeout(function(){
                // $scope.opp.otherField_edit = field;
                $("#otherField_edit" + post_id).val(field);    
            },100);

            $("#description_edit_" + post_id).focus();
            setTimeout(function(){
                //$('#description_edit_' + post_id).focus();                
                setCursotToEnd(document.getElementById('description_edit_' + post_id));
            },100);
            $("#edit-opp-post-"+post_id).show();
            $('#post-opp-detail-' + post_id).hide();   

        }
    }

    $scope.cancelPostEditNew = function (post_id, post_for, index) {
        if(post_for == "simple")
        {
            $("#edit-simple-post-"+post_id).hide();
            $('#simple-post-description-' + post_id).show();
        }
        else if(post_for == "opportunity")
        {
            $("#edit-opp-post-"+post_id).hide();
            $('#post-opp-detail-' + post_id).show();
        }
    }

    $scope.EditPost = function (post_id, post_for, index) {
        $scope.is_edit = 1;

        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.is_edit = 1;
                    if (post_for == "opportunity") {
                        $scope.opp.description = success.data.opportunity;
                        $scope.opp.job_title = success.data.opportunity_for;
                        $scope.opp.location = success.data.location;
                        $scope.opp.field = success.data.field;
                        $scope.opp.edit_post_id = post_id;
                        $("#opportunity-popup").modal('show');

                    } else if (post_for == "simple") {
                        $scope.sim.description = success.data.description;
                        $scope.sim.edit_post_id = post_id;

                        $("#post-popup").modal('show');

                    } else if (post_for == "question") {
                        $scope.ask.ask_que = success.data.question;
                        $scope.ask.ask_description = success.data.description;
                        $scope.ask.related_category = success.data.tag_name;
                        $scope.ask.ask_field = success.data.field;
                        $scope.ask.edit_post_id = post_id;

                        $("#ask-question").modal('show');
                    }
                });


    }

    $scope.sendEditComment = function (comment_id,post_id) {
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
                    $('#comment-dis-inner-' + comment_id).show();
                    $('#comment-dis-inner-' + comment_id).html(comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-'+post_id).show();
                }
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
            }
        });
    }

    function check_no_post_data() {
        var numberPost = $scope.postData.length;
        if (numberPost == 0) {
            $('.all_user_post').html(no_user_post_html);
        }
    }
    
    $scope.like_user_list = function (post_id) {
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            if(success.data.countlike > 0)
            {                
                $('#likeusermodal').modal('show');
            }
        });

    }
    scopeHold = $scope;    
});
app.controller('detailsController', function ($scope, $http, $location,$compile) {
    $scope.user = {};
    $scope.$parent.title = "Details | Aileensoul";
    // PROFEETIONAL DATA
    getFieldList();

    function load_add()
    {
        setTimeout(function(){        
        var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
            $compile($el)($scope);

        var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
            $compile($el)($scope);
        },1000);        
    }

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
            $scope.details_data = details_data;
            $scope.user_bio = user_bio;
            $scope.user_skills = skills_data;
            $scope.edit_user_skills = skills_data_edit;
            $scope.user_dob = $scope.details_data.user_dob;

            dob = $scope.details_data.user_dob.split('-');
            $scope.dob_month = dob[1];
            dob_month = dob[1];            
            dob_day = dob[2];            
            dob_year = dob[0];
            $scope.dob_fnc(dob_day,dob_month,dob_year); 

            load_add();
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
                $scope.primari_lang = user_langs[0];
                $scope.languageSet.language = user_langs.slice(1);

                var user_hobbies = about_user_data.user_hobbies.split(',');
                var edit_hobbies = [];
                user_hobbies.forEach(function(element,jobArrIndex) {
                  edit_hobbies[jobArrIndex] = {"hobby":element};
                });
                $scope.hobby_txt = edit_hobbies;
                $scope.user_fav_quote_headline = about_user_data.user_fav_quote_headline;
                $scope.user_fav_artist = about_user_data.user_fav_artist;
                $scope.user_fav_book = about_user_data.user_fav_book;
                $scope.user_fav_sport = about_user_data.user_fav_sport;                
            }

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
        if(user_bio != "" && $scope.user_bio != user_bio)
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
                $("#user_bio_save").removeAttr("style");
                $("#user_bio_loader").hide();
                $("#profile-overview").modal('hide');
            });
        }
    };

    $("#profile-overview").on("hide.bs.modal", function () {
        $("#user_bio").val($scope.user_bio);
    });
    var close_skill = 0;
    $scope.save_user_skills = function(){        
        if($scope.edit_user_skills != "")
        {
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
                $("#user_skills_save").removeAttr("style");
                $("#user_skills_loader").hide();
                // $("#skills").modal('hide');
                $("#skills .modal-close").click();
            });
        }
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

    $scope.job_title = [];
    $scope.loadSkills = function ($query) {
        return $http.get(base_url + 'userprofile_page/get_skills', {cache: true}).then(function (response) {
            var job_title = response.data;
            return job_title.filter(function (title) {
                return title.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.dob_fnc = function(dob_day,dob_month,dob_year){
        $("#dateerror").hide();
        $("#dateerror").html('');
        var kcyear = document.getElementsByName("year")[0],
        kcmonth = document.getElementsByName("month")[0],
        kcday = document.getElementsByName("day")[0];                
        
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
        $("#dob_year").html(year_opt);
        
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
                /*var opt = new Option();
                opt.value = opt.text = i;
                if (i == d)
                {
                    opt.selected = true;
                }
                kcday.add(opt);*/
            }
            $("#dob_day").html(day_opt);
        }
        validate_date(dob_day,dob_month,dob_year);
    };
    $scope.dob_error = function()
    {
        $("#dateerror").hide();
        $("#dateerror").html('');
    };
    $scope.save_about_user = function(){        
        $("#about_user_loader").show();
        $("#save_about_user").attr("style","pointer-events:none;display:none;");
        var dob_day_txt = $("#dob_day option:selected").val();
        var dob_month_txt = $("#dob_month option:selected").val();
        var dob_year_txt = $("#dob_year option:selected").val();

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
            $("#dateerror").html("Date of birth always less than to today's date.");
            $("#dateerror").show();

            $("#save_about_user").removeAttr("style");
            $("#about_user_loader").hide();
            return false;
        }
        // var languages = $('.frm_language').serialize();
        var languages = $('.language').serializeArray();
        var proficiency = $('.proficiency').serializeArray();
        // var languages = $('.frm_language').serializeArray();
        // var languages = new FormData('.frm_language');

        // var lang_prof = $('.lang_prof :selected').serialize();
        var dob = dob_year_txt+'-'+dob_month_txt+'-'+dob_day_txt;        
        var updatedata = $.param({'user_dob':dob,'user_hobby':$scope.hobby_txt,'user_fav_quote_headline':$scope.user_fav_quote_headline,'user_fav_artist':$scope.user_fav_artist,'user_fav_book':$scope.user_fav_book,'user_fav_sport':$scope.user_fav_sport,"language":languages,"proficiency":proficiency});
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
            }
            $("#save_about_user").removeAttr("style");
            $("#about_user_loader").hide();
            // $("#profile-overview").modal('hide');
        });
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
        });
    };

    //Research Start
    $scope.research_pub_fnc = function(dob_day,dob_month,dob_year){
        $("#dateerror").hide();
        $("#dateerror").html('');
        var kcyear = document.getElementsByName("year")[0],
        kcmonth = document.getElementsByName("month")[0],
        kcday = document.getElementsByName("day")[0];                
        
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
                minlength: 20
            },
            research_desc: {
                required: true,
                maxlength: 700,
                minlength: 50
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
                research_desc: "Please enter description",
            },
            research_url: {                
                url: "Enter valid URL",
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
        var fileExtension = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'gif', 'GIF','pdf','docx','doc','PDF'];
        var ext = $(this).val().split('.');
        alert(ext[ext.length - 1]);
        if ($.inArray(ext[ext.length - 1].toLowerCase(), fileExtension) !== -1) {             
            research_formdata.append('file', $('#research_document')[0].files[0]);
        }
        else {
            $(this).val() = "";
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

            research_formdata.append('research_title', $('#research_title').val());
            research_formdata.append('research_desc', $('#research_desc').val());
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
                    if(result.success == '1')
                    {
                        $("#user_research_save").removeAttr("style");
                        $("#user_research_loader").hide();
                        $("#research_form")[0].reset();
                        $("#research").modal('hide');
                    }
                    else
                    {
                        $("#user_research_save").removeAttr("style");
                        $("#user_research_loader").hide();
                        $("#research_form")[0].reset();
                        $("#research").modal('hide');
                    }
                }
            });
        }
    };
    //Research End
    
});
app.controller('contactsController', function ($scope, $http, $location, $window,$compile) {
    
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

    setTimeout(function(){        
    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
        $compile($el)($scope);

    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
        $compile($el)($scope);
    },1000);

    $scope.contact = function (id, status, to_id,indexCon,confirm = 0) {
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
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        // console.log($(window).scrollTop());
        // console.log($(document).height() - $(window).height());
        // console.log(($(document).height() - $(window).height()) * 0.7);
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height())) {
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

    //    lazzy loader start
// Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;    
    $scope.user_slug = user_data_slug;
    $scope.$parent.title = "Follower | Aileensoul";

    setTimeout(function(){
    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
        $compile($el)($scope);

    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
        $compile($el)($scope);
    },1000);

    // Fetch data
    $scope.getFollowers = function (pagenum) {
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
            if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }
        $http({
            method: 'post',
            url: base_url + "userprofile_page/followers_data?page=" + pagenum +"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (response.data != '') {
                $scope.row += $scope.rowperpage;
                if ($scope.contactData != undefined) {
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.contactrecord) {
                        $scope.followersData.push(response.data.followerrecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.followersData = response.data.followerrecord;
                }
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            var page = $(".page_number").val();
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
                    var pagenum = parseInt($(".page_number").val()) + 1;
                    // alert(pagenum);
                    $scope.getFollowers(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getFollowers();
//    lazzy loader end

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
            $("#" + id).html($compile(success.data)($scope));
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

                    $("#" + id).html($compile(success.data)($scope));
                });
    }
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }
});
app.controller('followingController', function ($scope, $http, $location, $compile, $window) {    
    // Variables
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;    
    $scope.user_slug = user_data_slug;
    $scope.$parent.title = "Following | Aileensoul";

    
    setTimeout(function(){
    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
        $compile($el)($scope);

    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
        $compile($el)($scope);
    },1000);

    // Fetch data
    $scope.getFollowing = function (pagenum) {

        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('#main_loader').show();
            if($scope.$parent.pade_reload == true)
            {
                $('#main_loader').show();            
            }
        }

        $http({
            method: 'post',
            url: base_url + "userprofile_page/following_data?page=" + pagenum +"&user_slug="+user_slug,
            data: {row: $scope.row, rowperpage: $scope.rowperpage}
        }).then(function successCallback(response) {
            if(pagenum == undefined || pagenum == "1" || pagenum == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (response.data != '') {
                $scope.row += $scope.rowperpage;
                if ($scope.contactData != undefined) {
                    $scope.page_number = response.data.pagedata.page;
                    for (var i in response.data.followingrecord) {
                        $scope.followingData.push(response.data.followingrecord[i]);
                    }
                } else {
                    $scope.pagecntctData = response.data;
                    $scope.followingData = response.data.followingrecord;
                }
            } else {
                $scope.showLoadmore = false;
            }
            $('footer').show();
        });
    }
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            var page = $(".page_number").val();
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
                    var pagenum = parseInt($(".page_number").val()) + 1;
                    $scope.getFollowing(pagenum);
                }
            }
        }
    });
    // Call function
    $scope.getFollowing();
//    lazzy loader end
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
                     $("#" + id).html($compile(success.data.follow_view)($scope));
                }
                else
                {
                    $('#' + id).closest('.custom-user-box').fadeToggle();
                    if (success.data.unfollowingcount == '0') {
                        $("#nofollowng").html("<div class='art-img-nn'><div class='art_no_post_img'><img src='assets/img/icon_notification_big.png' alt='notification image'></div><div class='art_no_post_text'>No Following Contacts Available. </div></div>");
                    }
                }
            }
        });
    }
    $scope.goUserprofile = function (path) {
        location.href = base_url + 'profiles/' + path;
    }
});
app.controller('questionsController', function ($scope, $http, $location, $compile, $window) {
    var isLoadingData = false;
    //    lazzy loader start
    $scope.showLoadmore = true;
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.buttonText = "Load More";
    $scope.ask = {};
    $scope.user_id = user_id;
    $scope.$parent.title = "Questions | Aileensoul";

    setTimeout(function(){
    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-format="auto"></adsense>').appendTo('.ads');
        $compile($el)($scope);

    var $el = $('<adsense ad-client="ca-pub-6060111582812113" ad-slot="8390312875" inline-style="display:block;" ad-class="adBlock"></adsense>').appendTo('.right-add-box');
        $compile($el)($scope);
    },1000);


    getFieldList();
    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {});
    }

    //$scope.category = [];
    $scope.loadCategory = function ($query) {
        return $http.get(base_url + 'user_post/get_category', {cache: true}).then(function (response) {
            var category_data = response.data;
            return category_data.filter(function (category) {
                return category.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.like_user_list = function (post_id) {
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            if(success.data.countlike > 0)
            {
                $('#likeusermodal').modal('show');
            }
        });
    }

    $scope.getQuestions = function (pagenum) {
        if(pagenum == undefined || pagenum == "1" || pagenum == ""){
            // $('.post_loader').show();
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
            } else {
                if(pagenum == '' || pagenum == 0 || pagenum == undefined)
                {
                    $scope.questionData = [];
                }
                $scope.showLoadmore = false;
            }
            $('footer').show();
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

    $scope.post_like = function (post_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                if (success.data.is_newLike == 1) {
                    $('#post-like-count-' + post_id).show();
                    $('#post-like-' + post_id).addClass('like');
                    $('#post-like-' + post_id).html('Liked');
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
                    $('#post-like-' + post_id).html('Like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                }
            }
        });
    }

    $scope.giveAnswer = function (user_id) {
        var ans_text_class = document.getElementById('ans-text-' + user_id).className.split(' ').pop();
        if (ans_text_class == 'open') {
            $('#ans-text-' + user_id).removeClass('open');
            $('#ans-text-' + user_id).css('display', 'none');
            $('#all-post-bottom-' + user_id).css('display', 'none');
        } else {
            $('#ans-text-' + user_id).addClass('open');
            $('#ans-text-' + user_id).css('display', 'block');
            $('#all-post-bottom-' + user_id).css('display', 'block');
        }
    }

    $scope.IsVisible = false;
    $scope.ShowHide = function () {
        //If DIV is visible it will be hidden and vice versa.
        $scope.IsVisible = $scope.IsVisible ? false : true;
    }

    $scope.ask_question_check = function (event,queIndex) {

        if (document.getElementById("ask_edit_post_id_"+queIndex)) {
            var post_id = document.getElementById("ask_edit_post_id_"+queIndex).value;
        } else {
            var post_id = 0;
        }        
        if (post_id == 0) {

        } else {

            var ask_que = document.getElementById("ask_que_"+post_id).value;
            var ask_que = ask_que.trim();

            if($scope.IsVisible == true)
            {                
                var ask_web_link = $("#ask_web_link_"+post_id).val();
            }
            else
            {
                var ask_web_link = "";
            }
            var ask_que_desc = $('#ask_que_desc_' + post_id).val();
            /*ask_que_desc = ask_que_desc.replace(/&nbsp;/gi, " ");
            ask_que_desc = ask_que_desc.replace(/<br>$/, '');
            ask_que_desc = ask_que_desc.replace(/&gt;/gi, ">");
            ask_que_desc = ask_que_desc.replace(/&/g, "%26");*/
            ask_que_desc = ask_que_desc.trim();
            var related_category_edit = $scope.ask.related_category_edit;
            var fields = $("#ask_field_"+post_id).val();  
            if(fields == 0)
                var ask_other = $("#ask_other_"+post_id).val();
            else
                var ask_other = "";

            var ask_is_anonymously = ($("#ask_is_anonymously"+post_id+":checked").length > 0 ? 1 : 0);            
            
            if ((fields == '') || (ask_que == ''))
            {
                $('#post .mes').html("<div class='pop_content'>Ask question and Field is required.");
                $('#post').modal('show');
                $(document).on('keydown', function (e) {
                    if (e.keyCode === 27) {
                        $('#posterrormodal').modal('hide');
                        $('.modal-post').show();
                    }
                });
                //event.preventDefault();
                return false;
            } else {


                var form_data = new FormData();

                form_data.append('question', ask_que);
                form_data.append('description', ask_que_desc);
                form_data.append('field', fields);
                form_data.append('other_field', ask_other);
                form_data.append('category', JSON.stringify(related_category_edit));
                form_data.append('weblink', ask_web_link);
                form_data.append('post_for', "question");
                form_data.append('is_anonymously', ask_is_anonymously);
                form_data.append('post_id', post_id);
                $('body').removeClass('modal-open');
                $("#opportunity-popup").modal('hide');
                $("#ask-question").modal('hide');
                $http.post(base_url + 'user_post/edit_post_opportunity', form_data,
                        {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
                        })
                        .then(function (success) {
                            if (success) {
                                $("#edit-ask-que-"+post_id).hide();
                                $("#ask-que-"+post_id).show();                                
                                $scope.questionData[queIndex].question_data = success.data.question_data;
                                //$scope.getQuestions();
                                /*if (success.data.response == 1) {
                                    $('#ask-post-question-' + post_id).html(success.data.ask_question);
                                    $('#ask-post-description-' + post_id).html(success.data.ask_description);
                                    //   $('#ask-post-link-' + post_id).html(success.data.opp_field);
                                    $('#ask-post-category-' + post_id).html(success.data.ask_category);
                                    $('#ask-post-field-' + post_id).html(success.data.ask_field);
                                }*/
                                
                            }
                        });
            }
        }
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
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                    .then(function (success) {
                        data = success.data;
                        if (data.message == '1') {
                            $('.post-comment-count-' + post_id).html(data.comment_count);
                            $('.editable_text').html('');
                        }
                    });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.EditPostQuestion = function (post_id, post_for, index) {
        if(post_for == "question")
        {
            $(".question-page div[id^=ask-que-]").show();
            $(".question-page div[id^=edit-ask-que-]").hide();

            $("#edit-ask-que-"+post_id).show();
            $("#ask_que_"+post_id).val($scope.questionData[index].question_data.question);
            $("#ask_que_desc_"+post_id).val($scope.questionData[index].question_data.description);
            if($scope.questionData[index].question_data.link != "")
            {                
                $scope.IsVisible = true;
                $("#ask_web_link_"+post_id).val($scope.questionData[index].question_data.link);                
            }
            else
            {
                $("#ask_web_link_"+post_id).val("");  
            }
            var related_category = [];
            var rel_category = $scope.questionData[index].question_data.category.split(",");            
            rel_category.forEach(function(element,catArrIndex) {
              related_category[catArrIndex] = {"name":element};
            });
            $scope.ask.related_category_edit = related_category;
            //$("#ask_related_category_edit"+post_id).val(related_category);

            var ask_field = $scope.questionData[index].question_data.field;

            if(ask_field != null)
            {                
                $('[id=ask_field_'+post_id+'] option').filter(function() { 
                    return ($(this).text() == ask_field);
                }).prop('selected', true);
            }
            else
            {                
                $scope.ask.ask_field = 0
                var ask_other = $scope.questionData[index].question_data.others_field;                
                setTimeout(function(){                    
                    $('[id=ask_field_'+post_id+'] option').filter(function() { 
                        return ($(this).text() == 'Other');
                    }).prop('selected', true);
                    $("#ask_other_"+post_id).val(ask_other);
                },100)
            }

            
            // var editContent = $('#simple-post-description-' + post_id).attr("dd-text-collapse-text");
            // $('#editPostTexBox-' + post_id).html(editContent);
            // setTimeout(function(){
            //     //$('#editPostTexBox-' + post_id).focus();
            //     setCursotToEnd(document.getElementById('editPostTexBox-' + post_id));
            // },100);
            $('#ask-que-' + post_id).hide();            
        }        
    }

    $scope.EditPost = function (post_id, post_for, index) {
        $scope.is_edit = 1;


        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.is_edit = 1;
                    if (post_for == "opportunity") {
                        $scope.opp.description = success.data.opportunity;
                        $scope.opp.job_title = success.data.opportunity_for;
                        $scope.opp.location = success.data.location;
                        $scope.opp.field = success.data.field;
                        $scope.opp.edit_post_id = post_id;
                        $("#opportunity-popup").modal('show');

                    } else if (post_for == "simple") {
                        $scope.sim.description = success.data.description;
                        $scope.sim.edit_post_id = post_id;

                        $("#post-popup").modal('show');

                    } else if (post_for == "question") {
                        $scope.ask.ask_que = success.data.question;
                        $scope.ask.ask_description = success.data.description;
                        $scope.ask.related_category = success.data.tag_name;
                        $scope.ask.ask_field = success.data.field;
                        $scope.ask.edit_post_id = post_id;

                        $("#ask-question").modal('show');
                    }
                });
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
            }
        });
    }

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
            url: base_url + "userprofile_page/user_image_insert1",
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

