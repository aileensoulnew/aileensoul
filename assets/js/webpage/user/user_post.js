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
app.filter('parseUrl', function($sce) {
  var urls = /(\b(https:\/\/?|http:\/\/?|ftp:\/\/)[A-Z0-9+&@#\/%?=~_|!:,.;-]*[-A-Z0-9+&@#\/%=~_|])/gim
  var urlswww = /(\b(www.?)[A-Z0-9+&@#\/%?=~_|!:,.;-]*[-A-Z0-9+&@#\/%=~_|])/gim
  var emails = /(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})/gim

  return function(text, asTrusted) {
    if(text.match(urls)) {
      text = text.replace(urls, "<a href=\"$1\" target=\"_self\">$1</a>")
    }
    else if(text.match(urlswww)) {
      text = text.replace(urlswww, "<a href=\"//$1\" target=\"_self\">$1</a>")
    }
    if(text.match(emails)) {
      text = text.replace(emails, "<a href=\"mailto:$1\">$1</a>")
    }

    if(asTrusted) {
      return $sce.trustAsHtml(text);
    }
    return text;
  }
});
app.filter('wordFirstCase', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
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
app.directive("owlCarousel", function () {
    return {
        restrict: 'E',
        link: function (scope) {
            scope.initCarousel = function (element) {
                // provide any default options you want
                /*var defaultOptions = {
                    loop: false,
                    nav: true,
                    lazyLoad: true,
                    margin: 0,
                    video: true,
                    responsive: {
                        0: {
                            items: 2
                        },
                        480: {
                            items: 3
                        },
                        768: {
                            items: 3,
                        },
						1280: {
                            items: 2
                        }
                    }
                };*/
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
                        480: {
                            items: 1
                        },
                        768: {
                            items: 1,
                        },
                        1280: {
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
app.directive('ngEnter', function () {
    // custom directive for sending message on enter click
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
app.controller('mainDefaultController', function($scope, $http, $compile) {
    $scope.$parent.active_tab = '1';
    $scope.getContactSuggetion = function() {
        $http.get(base_url + "user_post/getContactSuggetion").then(function (success) {
            $scope.contactSuggetion = success.data;
        }, function (error) {});
    }
    $scope.getContactSuggetion();

    $scope.get_business_contact_suggetion = function() {
        $http.get(base_url + "user_post/get_business_contact_suggetion").then(function (success) {
            $scope.business_suggetion = success.data;
        }, function (error) {});
    };
    $scope.get_business_contact_suggetion();

    $scope.add_to_contact_business = function (id, status, to_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/add_business_follow',
            data: 'follow_id=' + id + '&status=' + status + '&to_id=' + to_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            // $scope.follow_value = success.data;
            if(socket)
            {
                socket.emit('user notification',to_id);
            }
            $('.busflwbtn-' + to_id).html('Following');
            $('.busflwbtn-' + to_id).attr('style','pointer-events:none;');
        }, function errorCallback(response) {
            setTimeout(function(){
                $scope.add_to_contact_business(id, status, to_id);
            },200);
        });
    };

    $scope.addToContact = function (user_id, contact) {
        $('.addtobtn-' + user_id).html('Request Sent');
        $('.addtobtn-' + user_id).attr('style','pointer-events:none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                setTimeout(function(){                    
                    /*$('.addtobtn-' + user_id).html('Request Sent');
                    $('.addtobtn-' + user_id).attr('style','pointer-events:none;');*/
                   // $('.owl-carousel').trigger('next.owl.carousel');
                },500);
                if(socket)
                {
                    socket.emit('user notification',user_id);
                }
                var index = $scope.contactSuggetion.indexOf(contact);
            }
        }, function errorCallback(response) {
            setTimeout(function(){
                $scope.addToContact(user_id,contact);
            },200);
        });
    };
});
app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/peoples", {
                templateUrl: base_url + "user_post/user_post_people",
                controller: 'peopleController'
            })
            .when("/posts", {
                templateUrl: base_url + "user_post/user_post_posts",
                controller: 'postController'
            })
            .when("/opportunities", {
                templateUrl: base_url + "user_post/user_post_opportunity",
                controller: 'opportunityController'
            })            
            .when("/articles", {
                templateUrl: base_url + "user_post/user_post_article",
                controller: 'articleController'
            })
            .when("/qa", {
                templateUrl: base_url + "user_post/user_post_question",
                controller: 'questionController'
            })
            .when("/businesses", {
                templateUrl: base_url + "user_post/user_post_business",
                controller: 'businessController'
            })
            .otherwise({
                templateUrl: base_url + "user_post/user_post_main",
                controller: 'userOppoController'
            });
    $locationProvider.html5Mode(true);
});
app.controller('userOppoController', function ($scope, $http,$compile,$location,$window) {
    $scope.today = new Date(); 
    $scope.$parent.active_tab = '1';
    $scope.IsVisible = false;
    $scope.recentpost = [];
    $scope.$parent.title = "Aileensoul";

    $scope.opp = {};
    $scope.sim = {};
    $scope.ask = {};
    $scope.postData = {};
    $scope.opp.post_for = 'opportunity';
    $scope.sim.post_for = 'simple';
    $scope.ask.post_for = 'question';
    $scope.live_slug = live_slug;
    $scope.user_id = user_id;
    $scope.share_post_data = [];

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
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
                
                setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

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

    $scope.openModal2 = function(myModal2Id) {        
        document.getElementById(myModal2Id).style.display = "block";
        $("body").addClass("modal-open");
    };
    $scope.closeModal2 = function(myModal2Id) {    
        document.getElementById(myModal2Id).style.display = "none";
        $("body").removeClass("modal-open");
    };
    $scope.closeModalShare = function(myModal2Id) {    
        document.getElementById(myModal2Id).style.display = "none";
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
        // var slides = document.getElementsByClassName("mySlides2"+myModal2Id);
        var slides = document.getElementsByClassName(myModal2Id);
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

    /*$(document).on('keydown', function (e) {
        if (e.keyCode === 27) {
            $('.modal-close').click();            
        }
    });*/
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
            $(this).css('width', '35px');
        }
    });
    $(document).on('focusout','#job_title .input',function () {
        if($('#job_title ul li').length > 0)
        {             
            $(this).attr('placeholder', '');
            $(this).css('width', '35px');
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
            $(this).css('width', '35px');            
        }
    });
    $(document).on('focusout','#location .input',function () {
        if($('#location ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '35px');            
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
            $(this).css('width', '35px');
        }
    });
    $(document).on('focusout','#ask_related_category .input',function () {
        if($('#ask_related_category ul li').length > 0)
        {             
            $(this).attr('placeholder', '');
            $(this).css('width', '35px');
        }
        if($('#ask_related_category ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Related Category');
            $(this).css('width', '100%');
        }         
    });   


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

    var isLoadingData = false;
    var postIndex = -1;

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

    $("#opptitle").focusin(function(){
        $('#opptitletooltip').show();
    });
    $("#opptitle").focusout(function(){
        $('#opptitletooltip').hide();
    });

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
	
	$("#sim_title").focusin(function(){
        $('#simple-post-title').show();
    });
    $("#sim_title").focusout(function(){
        $('#simple-post-title').hide();
    });
	
	$("#sim_hashtag").focusin(function(){
        $('#simple-post-hashtag').show();
    });
    $("#sim_hashtag").focusout(function(){
        $('#simple-post-hashtag').hide();
    });
	
	$("#opp_hashtag").focusin(function(){
        $('#opp-post-hashtag').show();
    });
    $("#opp_hashtag").focusout(function(){
        $('#opp-post-hashtag').hide();
    });
	
	$("#company_name").focusin(function(){
        $('#op-post-company').show();
    });
    $("#company_name").focusout(function(){
        $('#op-post-company').hide();
    });

	$("#ask_hashtag").focusin(function(){
        $('#ask-post-hashtag').show();
    });
    $("#ask_hashtag").focusout(function(){
        $('#ask-post-hashtag').hide();
    });

    $scope.set_owl_carousel = function(contact_suggetion,inx){
        var content = '<data-owl-carousel class="owl-carousel owl-carousel1" data-options="loop: false,nav: true,lazyLoad: true,margin: 0,video: true,responsive: {0: {items: 2},480: {items: 2},768: {items: 2,},1280: {items: 2}}">';
        contact_suggetion.forEach(function(element,contactInx) {
            content += '<div owl-carousel-item=""  class="item">';
            content += '<div class="item" id="item-'+element.user_id+'">';
            content += '<div class="arti-profile-box">';
                content += '<div class="user-cover-img">';
                    content += '<a href="'+base_url+element.user_slug+'" >';                    
                    if(element.profile_background)
                    {
                        content += '<img src="'+user_bg_main_upload_url+element.profile_background+'">';
                    }
                    else
                    {
                        content += '<div class="gradient-bg" style="height: 100%"></div>';
                    }
                    content += '</a>';
                content += '</div>';
                
                content += '<div class="user-pr-img">';
                    content += '<a href="'+base_url+element.user_slug+'" >';
                        if(element.user_image)
                        {
                            content += '<img src="'+user_main_upload_url+element.user_image+'">';
                        }
                        else
                        {
                            if(element.user_gender == 'M')
                            {
                                content += '<img src="'+base_url+'assets/img/man-user.jpg">';
                            }
                            else
                            {
                                content += '<img src="'+base_url+'assets/img/female-user.jpg">';
                            }
                        }
                    content += '</a>';
                content += '</div>';

                content += '<div class="user-info-text text-center">';
                    content += '<h3>';
                        content += '<a href="'+base_url+element.user_slug+'" >';
                            content += element.first_name+' '+element.last_name;
                        content += '</a>';
                    content += '</h3>';
                    content += '<p>';
                        content += '<a href="'+base_url+element.user_slug+'" >';
                        if(element.title_name){
                            content += element.title_name;
                        }
                        else if(element.degree_name){
                            content += element.degree_name;
                        }
                        else{
                            content += "CURRENT WORK";
                        }                            
                        content += '</a>';
                    content += '</p>';
                content += '</div>';

                content += '<div class="author-btn">';
                    content += '<div class="user-btns">';
                    content += '<a class="btn3 addtobtn-'+element.user_id+'" ng-click="addToContact('+element.user_id+',\'\' )">Add to Contacts';
                    content += '</a>';
                    content += '</div>';
                content += '</div>';

            content += '</div>';
            content += '</div>';
            content += '</div>';
        });
        content += "</data-owl-carousel>";
        setTimeout(function(){
            /*alert(inx);
            console.log(content);*/
            var $elm = $(".corousel"+inx).html(content);
            $compile($elm)($scope);
        },1000);
    };

    $scope.showLoadmore = true;
    var pg="";
    $scope.page = 0;
    $scope.total_record = 0;
    $scope.perpage = 5;
    var fl_addpost="";
    var processing = false;
    $scope.contact_suggetion = [];

    $scope.promotedPostData = [];
    function getUserPromotedPost() {
        $http.get(base_url + "user_post/getUserPromotedPost").then(function (success) {            
            $('body').removeClass("body-loader");
            if (success.data) {                
                $scope.promotedPostData = success.data; 
                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
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
                    });
                },500);

            } else {
                isLoadingData = true;
            }           
        }, function (error) {
            getUserPromotedPost();
        });
    }

    $scope.promotedPostIndex10Data = [];
    function getUserPromotedPostIndex10() {
        $http.get(base_url + "user_post/getUserPromotedPostIndex10").then(function (success) {            
            $('body').removeClass("body-loader");
            if (success.data) {                
                $scope.promotedPostIndex10Data = success.data; 
                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
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
                    });
                },500);

            } else {
                isLoadingData = true;
            }           
        }, function (error) {
            getUserPromotedPostIndex10();
        });
    }

    $scope.get_user_progress = function(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/get_user_progress',            
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            var hashtag_count = success.data.hashtag_count;
            $scope.hashtag_count = hashtag_count;
            var profile_progress = success.data.profile_progress;
            var count_profile_value = profile_progress.user_process_value;
            var count_profile = profile_progress.user_process;
            $scope.progress_status = profile_progress.progress_status;
            if(count_profile == 100)
            {
                $("#edit-profile-move").hide();
            }
            if(hashtag_count < 5){
                $("#hashtag-popup").modal('show');
            }
            $scope.set_progress(count_profile_value,count_profile);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.get_user_progress();
            },200);
        });
    };

    $scope.get_user_progress();

    $scope.set_progress = function(count_profile_value,count_profile){
        if(count_profile == 100)
        {
            $("#progress-txt").html("Hurray! Your profile is complete.");
            setTimeout(function(){
                $("#edit-profile-move").hide();
                $("#profile-progress").hide();
            },5000);
        }
        else
        {
            $("#edit-profile-move").show();
            $("#profile-progress").show();                
            $("#progress-txt").html("<a href='"+base_url+live_slug+"/details' target='_self'>Complete your profile to get connected with more people.</a>");   
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

    getUserPost(pg);
    var isProcessing = false;

    var is_scolled = false;
    function getUserPost(pg,fl_addpost) {

        $('#loader').show();
        if(pg == "" && fl_addpost == ""){
            $('#main_loader').show();
        }
        $http.get(base_url + "user_post/getUserPost?page=" + pg).then(function (success) {
            $('#loader').hide();
            if(pg == ""){
                $('#main_loader').hide();
            }
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (success.data.all_post_data) {
                isLoadingData = false;
                $('#progress_div').hide();
                $('.progress-bar').css("width",0);
                $('.sr-only').text(0+"%");
                $scope.postData = success.data.all_post_data;
                $scope.total_record = success.data.total_record;
                $scope.page = success.data.page;
                // $scope.contact_suggetion.push(success.data.contact_suggetion);
                // $scope.contact_suggetion = success.data.contact_suggetion;
                // $scope.set_owl_carousel(success.data.contact_suggetion,$scope.page);
                getUserPromotedPost();
            } else {
                isLoadingData = true;
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

                $('[data-toggle="popover"]').popover({
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
                });
                auto_load_feed();
                (adsbygoogle = window.adsbygoogle || []).push({});
            },1000);
        }, function (error) {
            setTimeout(function(){
                getUserPost(pg);
            },200);
        });
    }    

    $(window).on('scroll', function () {
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) && $location.url().substr(1) == '') {
            is_scolled = true;
            // isLoadingData = true;
            var page = $scope.page;//$(".page_number:last").val();
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
                    var pagenum = parseInt($scope.page) + 1;//parseInt($(".page_number:last").val()) + 1;
                    getUserPostLoadMore(pagenum);
                }
            }
        }
    });
    function auto_load_feed()
    {
        if($scope.page == 5)
        {
            is_scolled = true;
        }
        if(is_scolled == false)
        {
            var pagenum = parseInt($scope.page) + 1;
            getUserPostLoadMore(pagenum);
        }
    }

    function getUserPostLoadMore(pg) {
       
        if (isProcessing) {
          
            /*
             *This won't go past this condition while
             *isProcessing is true.
             *You could even display a message.
             **/
            return;
        }
        isProcessing = true;
        $('#loader').show();
        $http.get(base_url + "user_post/getUserPost?page="+pg+"&tot="+$scope.total_record).then(function (success) {
            $('#loader').hide();
           
            if (success.data.all_post_data[0].post_data) {
                isProcessing = false;
                //$scope.postData = success.data; 
                for (var i in success.data.all_post_data) {
                    $scope.postData.push(success.data.all_post_data[i]);
                }
                $scope.showLoadmore = true;
                $scope.page = success.data.page;//$scope.page + 1;
                // $scope.set_owl_carousel(success.data.contact_suggetion,$scope.page);
                // console.log($scope.page);
                if(success.data.contact_suggetion_1)
                {
                    $scope.contact_suggetion_1 = success.data.contact_suggetion_1;
                }
                if(success.data.contact_suggetion_2)
                {
                    $scope.contact_suggetion_2 = success.data.contact_suggetion_2;
                }
                if(success.data.contact_suggetion_3)
                {
                    $scope.contact_suggetion_3 = success.data.contact_suggetion_3;
                }
                if(success.data.contact_suggetion_4)
                {
                    $scope.contact_suggetion_4 = success.data.contact_suggetion_4;
                }
                if(success.data.contact_suggetion_5)
                {
                    $scope.contact_suggetion_5 = success.data.contact_suggetion_5;
                }

                if(success.data.hashtag_suggetion_1)
                {
                    $scope.hashtag_suggetion_1 = success.data.hashtag_suggetion_1;
                }
                if(success.data.hashtag_suggetion_2)
                {
                    $scope.hashtag_suggetion_2 = success.data.hashtag_suggetion_2;
                }
                if(success.data.hashtag_suggetion_3)
                {
                    $scope.hashtag_suggetion_3 = success.data.hashtag_suggetion_3;
                }
                if(success.data.hashtag_suggetion_4)
                {
                    $scope.hashtag_suggetion_4 = success.data.hashtag_suggetion_4;
                }
                if(success.data.hashtag_suggetion_5)
                {
                    $scope.hashtag_suggetion_5 = success.data.hashtag_suggetion_5;
                }
                if(success.data.hashtag_suggetion_6)
                {
                    $scope.hashtag_suggetion_6 = success.data.hashtag_suggetion_6;
                }
                if(success.data.hashtag_suggetion_7)
                {
                    $scope.hashtag_suggetion_7 = success.data.hashtag_suggetion_7;
                }
                if(success.data.hashtag_suggetion_8)
                {
                    $scope.hashtag_suggetion_8 = success.data.hashtag_suggetion_8;
                }
                if(success.data.hashtag_suggetion_9)
                {
                    $scope.hashtag_suggetion_9 = success.data.hashtag_suggetion_9;
                }
            } else {
                // processing = false;
                // isLoadingData = false;                
                $scope.showLoadmore = false;
            }

            if(pg == 2)
            {
                getUserPromotedPostIndex10();
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

                $('[data-toggle="popover"]').popover({
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
                });

                (adsbygoogle = window.adsbygoogle || []).push({});

                // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
            },1000);
            if(is_scolled == false)
            {
                auto_load_feed();
            }
        }, function (error) {
            setTimeout(function(){
                isProcessing = false;
                getUserPostLoadMore(pg)
            },200);
        });
    }

    

    getFieldList();
    function getFieldList() {
        $http.get(base_url + "general_data/getFieldList").then(function (success) {
            $scope.fieldList = success.data;
        }, function (error) {
            setTimeout(function(){
                getFieldList();
            },200);
        });
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

    $scope.removeViewMore = function(mainId,removeViewMore) {
        $("#"+mainId).removeClass("view-more-expand");
        $("#"+removeViewMore).remove();
    };

    $scope.postFiles = function () {
        var a = document.getElementById('description').value;
        var b = $('job_title').val();
        var c = $('#location').val();
        var d = $('#field').val();
        //$("#post_opportunity")[0].reset();
        $('#description').val(a);
        $('#job_title').val(b);
        $('#location').val(c);
        $('#field').val(d);
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
            var opptitle = $scope.opp.opptitle;
            var job_title = $scope.opp.job_title;
            var location = $scope.opp.location;
            var fields = $scope.opp.field;
            var otherField = $scope.opp.otherField;
            var opp_hashtag = $scope.opp.opp_hashtag;            
            var check_hashtag = (opp_hashtag != '' && opp_hashtag != undefined ? opp_hashtag.replace(/#/g, "") : '');
            var hashtags_arr = $scope.getHashTags(opp_hashtag);
            
            if( (fileCountOpp == 0 && (description == '' || description == undefined)) || ((opptitle == undefined || opptitle == '')  || (job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields == undefined || fields == '') || (fields == 0 && otherField == "") || (check_hashtag == undefined || check_hashtag == '' || hashtags_arr.length == 0 || hashtags_arr.length > 10)))
            {
                if(check_hashtag != '' && check_hashtag != undefined && (hashtags_arr.length == 0 || hashtags_arr.length > 10))
                {
                    if(hashtags_arr.length > 10)
                    {
                        $('#post .mes').html("<div class='pop_content'>You can add only 10 hashtags.");
                    }
                    else
                    {
                        $('#post .mes').html("<div class='pop_content'>Hashtags must start with '#'.");
                    }                    
                }
                else
                {
                    $('#post .mes').html("<div class='pop_content'>This post appears to be blank. All fields are mandatory.");
                }
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
                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'bmp', 'BMP'];
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
                    if((opptitle == '' || opptitle == undefined) || (description == '' || description == undefined) || ((job_title == undefined || job_title == '')  || (location == undefined || location == '') || (fields.trim() == undefined || fields.trim() == '')))
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
                formFileDataOpp.append('opptitle', $scope.opp.opptitle);
                formFileDataOpp.append('field', $scope.opp.field);
                formFileDataOpp.append('other_field', $scope.opp.otherField);
                formFileDataOpp.append('job_title', JSON.stringify($scope.opp.job_title));
                formFileDataOpp.append('location', JSON.stringify($scope.opp.location));
                formFileDataOpp.append('post_for', $scope.opp.post_for);
                formFileDataOpp.append('hashtag', $scope.opp.opp_hashtag);
                formFileDataOpp.append('company_name', $scope.opp.company_name);

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
                        if(socket)
                        {
                            setTimeout(function(){
                                socket.emit('user notification',user_id);
                            },1000);
                        }

                        $('.post_loader').hide();
                        $scope.opp.description = '';
                        $scope.opp.opptitle = '';
                        $scope.opp.job_title = '';
                        $scope.opp.location = '';
                        $scope.opp.field = '';
                        $scope.opp.postfiles = '';
                        document.getElementById('fileInput').value = '';
                        $('#job_title .input').attr('placeholder', 'Ex:Seeking Opportunity, CEO, Enterpreneur, Founder, Singer, Photographer....');
                        $('#job_title .input').css('width', '100%');

                        $('#location .input').attr('placeholder', 'Ex:Mumbai, Delhi, New south wels, London, New York, Captown, Sydeny, Shanghai....');
                        $('#location .input').css('width', '100%');


                        $("#post_opportunity")[0].reset();

                        $('.file-preview-thumbnails').html('');
                        //$scope.postData.splice(0, 0, success.data[0]);
                        getUserPost(pg,1);
                        $scope.IsVisible = true;                                
                        $scope.recentpost = success.data;
                        if(success.data.status == '0')
                        {
                            $("#post-fail").fadeIn("slow");
                            setTimeout(function() {
                                $("#post-fail").fadeOut("slow");
                            }, 5000);
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
                    }
                }, function (error) {
                    setTimeout(function(){
                        $scope.post_opportunity_check();
                    },200);
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
        }, function errorCallback(response) {            
            $scope.questionList();
        });
    }


    $scope.ask_question_check = function (event,postIndex) {

        if (document.getElementById("ask_edit_post_id_"+postIndex)) {
            var post_id = document.getElementById("ask_edit_post_id_"+postIndex).value;
        } else {
            var post_id = 0;
        }
        if (post_id == 0) {
            var field = document.getElementById("ask_field").value;
            var description = document.getElementById("ask_que").value;
            var description = description.trim();
            var ask_hashtag = $scope.ask.ask_hashtag;            
            var check_hashtag = (ask_hashtag != '' && ask_hashtag != undefined ? ask_hashtag.replace(/#/g, "") : '');
            var hashtags_arr = $scope.getHashTags(ask_hashtag);

            var fileInput = document.getElementById("fileInput2").files;
            if (field == '' || description == '' || check_hashtag == '' || hashtags_arr.length == 0 || hashtags_arr.length > 10)
            {
                if(check_hashtag != '' && check_hashtag != undefined && (hashtags_arr.length == 0  || hashtags_arr.length > 10))
                {
                    if(hashtags_arr.length > 10)
                    {                        
                        $('#post .mes').html("<div class='pop_content'>You can add only 10 hashtags.");
                    }
                    else
                    {
                        $('#post .mes').html("<div class='pop_content'>Hashtags must start with '#'.");
                    }                    
                }
                else
                {
                    $('#post .mes').html("<div class='pop_content'>Ask Question, Hashtags and Field is required.");
                }
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

                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'bmp', 'BMP'];
                
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
                formFileDataQue.append('hashtag', $scope.ask.ask_hashtag);
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
                                if(socket)
                                {
                                    setTimeout(function(){
                                        socket.emit('user notification',user_id);
                                    },1000);
                                }
                                //window.location = base_url+user_slug+"/questions";
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

                                $('#ask_related_category .input').attr('placeholder', 'Related Category');
                                $('#ask_related_category .input').css('width', '100%');

                                //$scope.postData.splice(0, 0, success.data[0]);
                                getUserPost(pg,1);
                                $scope.IsVisible = true;
                                $scope.recentpost = success.data;
                                if(success.data.status == '0')
                                {
                                    $("#post-fail").fadeIn("slow");
                                    setTimeout(function() {
                                        $("#post-fail").fadeOut("slow");
                                    }, 5000);
                                }

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
                            }                        
                        }, function (error) {
                            setTimeout(function(){
                                $scope.ask_question_check();
                            },200);
                        });
            }

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

            var sim_title = $scope.sim.sim_title;//document.getElementById("description").value;
            var sim_hashtag = $scope.sim.sim_hashtag;//document.getElementById("description").value;
            var description = $scope.sim.description;//document.getElementById("description").value;
            //var description = description.trim();
            var fileInput1 = document.getElementById("fileInput1").value;
            //console.log(fileInput1);
            var check_hashtag = (sim_hashtag != '' && sim_hashtag != undefined ? sim_hashtag.replace(/#/g, "") : '');
            var hashtags_arr = $scope.getHashTags(sim_hashtag);

            if((sim_title == '' || sim_title == undefined) || (check_hashtag == '' || check_hashtag == undefined || hashtags_arr.length == 0 || hashtags_arr.length > 10) || (fileCountSim == 0 && (description == '' || description == undefined)))
            {
                if(check_hashtag != '' && check_hashtag != undefined && (hashtags_arr.length == 0 || hashtags_arr.length > 10))
                {
                    if(hashtags_arr.length > 10)
                    {
                        $('#posterrormodal .mes').html("<div class='pop_content'>You can add only 10 hashtags.");
                    }
                    else
                    {
                        $('#posterrormodal .mes').html("<div class='pop_content'>Hashtags must start with '#'.");
                    }
                }
                else
                {
                    $('#posterrormodal .mes').html("<div class='pop_content'>All fields are mandatory. Please add title, hashtags, write or attach (photos, videos, audios, pdf) to post.");
                }
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
                var allowedExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'PNG', 'png', 'bmp', 'BMP'];
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
                            //$("#post_something")[0].reset();
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
                            //$("#post_something")[0].reset();
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
                            //$("#post_something")[0].reset();
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
                            //$("#post_something")[0].reset();
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
                            //$("#post_something")[0].reset();
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
                            //$("#post_something")[0].reset();
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
                        //$("#post_something")[0].reset();
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
                            //$("#post_something")[0].reset();
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
                            //$("#post_something")[0].reset();

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
                            //$("#post_something")[0].reset();
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
                            //$("#post_something")[0].reset();
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
                        //$("#post_something")[0].reset();
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
                formFileDataSim.append('sptitle', sim_title);//$scope.sim.sim_title);
                formFileDataSim.append('hashtag', sim_hashtag);//$scope.sim.sim_hashtag);
                formFileDataSim.append('post_for', $scope.sim.post_for);
                //data.append('data', data);

                $('body').removeClass('modal-open');
                $("#post-popup").modal('hide');
                $("#post_opportunity_box").attr("style","pointer-events:none;");

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
                        if(socket)
                        {
                            setTimeout(function(){
                                socket.emit('user notification',user_id);
                            },1000);
                        }

                        $("#post_something")[0].reset();
                        //$('.post_loader').hide();
                        $scope.sim.description = '';
                        $scope.sim.sim_title = '';
                        $scope.sim.sim_hashtag = '';
                        $scope.sim.postfiles = '';
                        document.getElementById('fileInput1').value = '';
                        $('.file-preview-thumbnails').html('');
                        //$scope.postData.splice(0, 0, success.data[0]);                                
                        getUserPost(pg,1);
                        $scope.IsVisible = true;
                        $scope.recentpost = success.data;
                        // console.log(success);
                        if(success.data.status == '0')
                        {
                            $("#post-fail").fadeIn("slow");
                            setTimeout(function() {
                                $("#post-fail").fadeOut("slow");
                            }, 5000);
                        }

                        setTimeout(function(){
                            // $scope.IsVisible = false;
                        },5000);

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
                    }
                    $("#post_opportunity_box").removeAttr("style");
                }, function (error) {
                    setTimeout(function(){
                        $scope.post_something_check();
                    },200);
                });
            }
        }
    }

    $scope.loadMediaElement = function ()
    {
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
        /*$('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
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
        }*/
    };
    

    $scope.post_like = function (post_id,parent_index,is_promoted,user_id) {
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
                if(is_promoted == 1)
                {
                    $scope.promotedPostData[parent_index].user_like_list = success.data.user_like_list;
                }
                else
                {
                    $scope.postData[parent_index].user_like_list = success.data.user_like_list;
                }
            }            
        }, function errorCallback(response) {
            setTimeout(function(){
                $scope.post_like(post_id,parent_index,is_promoted,user_id);
            },200);
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

    $scope.sendComment = function (post_id, index, post,is_promoted) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        // var mention_data = $("#commentTaxBox-"+post_id).attr('mention-data');
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
                data:data,// 'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            }).then(function (success) {
                data = success.data;                

                if (data.message == '1') {
                    if (commentClassName == 'last-comment') {
                        if(is_promoted == 1)
                        {
                            if(socket)
                            {
                                socket.emit('user notification',$scope.promotedPostData[index].post_data.user_id);
                            }

                            $scope.promotedPostData[index].post_comment_data.splice(0, 1);
                            $scope.promotedPostData[index].post_comment_data.push(data.comment_data[0]);
                        }
                        else
                        {
                            if(socket)
                            {
                                socket.emit('user notification',$scope.postData[index].post_data.user_id);
                            }

                            $scope.postData[index].post_comment_data.splice(0, 1);
                            $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        }
                        if(data.comment_count > 0)
                        {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if(data.comment_count > 0)
                        {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function(){
                    $("#commentTaxBox-"+post_id).attr('mention-data','');
                    $("#cmt-btn-mob-"+post_id).removeAttr("style");
                    $("#cmt-btn-mob-"+post_id).removeAttr("disabled");
                    $("#cmt-btn-"+post_id).removeAttr("style");
                    $("#cmt-btn-"+post_id).removeAttr("disabled");

                    $('[data-toggle="popover"]').popover({
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
                    });

                },1000);
            }, function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendComment(post_id, index, post,is_promoted);
                },200);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.viewAllComment = function (post_id, index, post,post_type) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if(post_type == 1)
            {
                $scope.postData[index].post_comment_data = data.all_comment_data;
                $scope.postData[index].post_comment_count = data.post_comment_count;
            }
            if(post_type == 2)//Promoted
            {
                $scope.promotedPostData[index].post_comment_data = data.all_comment_data;
                $scope.promotedPostData[index].post_comment_count = data.post_comment_count;
            }
            if(post_type == 3)//Promoted Index10
            {
                $scope.promotedPostIndex10Data[index].post_comment_data = data.all_comment_data;
                $scope.promotedPostIndex10Data[index].post_comment_count = data.post_comment_count;
            }
            
            setTimeout(function(){
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
        }, function errorCallback(response) {
            setTimeout(function(){
                $scope.viewAllComment(post_id, index, post,is_promoted);
            },200);
        });

    }

    $scope.viewLastComment = function (post_id, index, post,post_type) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if(post_type == 1)
            {
                $scope.postData[index].post_comment_data = data.comment_data;
                $scope.postData[index].post_comment_count = data.post_comment_count;
            }
            if(post_type == 2)//Promoted
            {
                $scope.promotedPostData[index].post_comment_data = data.comment_data;
                $scope.promotedPostData[index].post_comment_count = data.post_comment_count;
            }
            if(post_type == 3)//Promoted Index10
            {
                $scope.promotedPostIndex10Data[index].post_comment_data = data.comment_data;
                $scope.promotedPostIndex10Data[index].post_comment_count = data.post_comment_count;
            }
            setTimeout(function(){
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewLastComment(post_id, index, post,is_promoted);
            },200);
        });

    }
    $scope.deletePostComment = function (comment_id, post_id, parent_index, index, post,is_promoted) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $scope.c_d_is_promoted = is_promoted;

        $('#delete_model').modal('show');
    }

    $scope.deleteComment = function (comment_id, post_id, parent_index, index, post,is_promoted) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (commentClassName == 'last-comment') {
                if(is_promoted == 1)
                {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.promotedPostData[index].post_data.user_id);
                    }

                    $scope.promotedPostData[parent_index].post_comment_data.splice(0, 1);
                    $scope.promotedPostData[parent_index].post_comment_data.push(data.comment_data[0]);
                }
                else
                {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[index].post_data.user_id);                    
                    }
                    $scope.postData[parent_index].post_comment_data.splice(0, 1);
                    $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                }
                if(data.comment_count < 1)
                {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            } else {
                if(is_promoted == 1)
                {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.promotedPostData[index].post_data.user_id);
                    }
                    $scope.promotedPostData[parent_index].post_comment_data.splice(index, 1);
                }
                else
                {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[index].post_data.user_id);
                    }
                    $scope.postData[parent_index].post_comment_data.splice(index, 1);
                }
                if(data.comment_count < 1)
                {
                    $('.post-comment-count-' + post_id).hide();
                }
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deleteComment(comment_id, post_id, parent_index, index, post,is_promoted);
            },200);
        });
    }

    $scope.likePostComment = function (comment_id, post_id,comment_user_id) {
        $('#cmt-like-fnc-' + comment_id).attr("style","pointer-events:none;")
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
                    socket.emit('user notification',comment_user_id);
                }

                if (data.is_newLike == 1) {
                    // $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#cmt-like-fnc-' + comment_id).addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    // $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#cmt-like-fnc-' + comment_id).removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }

            }
            setTimeout(function(){
                $('#cmt-like-fnc-' + comment_id).removeAttr("style");
            },100);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.likePostComment(comment_id, post_id,comment_user_id);
            },200);
        });
    }
    $scope.editPostComment = function (comment_id, post_id, parent_index, index,is_promoted) {
        $(".comment-for-post-"+post_id+" .edit-comment").hide();
        $(".comment-for-post-"+post_id+" .comment-dis-inner").show();
        $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
        $(".comment-for-post-"+post_id+" li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        // var editContent = $('#comment-dis-inner-' + comment_id).text();
        if(is_promoted == 1)
        {
            var editContent = $scope.promotedPostData[parent_index].post_comment_data[index].comment;
            editContent = editContent.substring(0,cmt_maxlength);
        }
        else
        {
            var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
            editContent = editContent.substring(0,cmt_maxlength);
        }
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-"+post_id).hide();
    }

    $scope.edit_post_comment_reply = function (comment_id, post_id, parent_index, cmt_index,cmt_rpl_index,post_type) {       
        $(".comment-for-post-"+post_id+" .edit-reply-comment").hide();
        $(".comment-for-post-"+post_id+" li[id^=cancel-reply-comment-li-]").hide();
        $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
        $(".comment-for-post-"+post_id+" li[id^=timeago-reply-comment-li-]").show();
        $(".comment-for-post-"+post_id+" div[id^=comment-reply-dis-inner-]").show();
        $('#edit-comment-li-' + comment_id).hide();
        $('#timeago-reply-comment-li-' + comment_id).hide();

        if(post_type == 1)
        {            
            var editContent = $scope.postData[parent_index].post_comment_data[cmt_index].comment_reply_data[cmt_rpl_index].comment;
            editContent = editContent.substring(0,cmt_maxlength);
        }
        if(post_type == 2)//Promoted
        {            
            var editContent = $scope.promotedPostData[parent_index].post_comment_data[cmt_index].comment_reply_data[cmt_rpl_index].comment;
            editContent = editContent.substring(0,cmt_maxlength);
        }
        if(post_type == 3)//Promoted Index10
        {
            var editContent = $scope.promotedPostIndex10Data[parent_index].post_comment_data[cmt_index].comment_reply_data[cmt_rpl_index].comment;
            editContent = editContent.substring(0,cmt_maxlength);
        }
        editContent = editContent.substring(0,cmt_maxlength);
        $('#edit-reply-comment-' + comment_id).show();        
        $('#edit-comment-reply-textbox-' + comment_id).show();
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
    
    $scope.sendEditComment = function (comment_id,post_id,user_id,postIndex, commentIndex,post_type) {
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
                    $('#comment-dis-inner-' + comment_id).html(data.comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-'+post_id).show();

                    if(post_type == 1)
                    {
                        $scope.postData[postIndex].post_comment_data[commentIndex].comment = data.comment;
                        // $scope.postData[index].post_comment_count = data.post_comment_count;
                    }
                    if(post_type == 2)//Promoted
                    {
                        $scope.promotedPostData[postIndex].post_comment_data[commentIndex].comment = data.comment;
                        // $scope.promotedPostData[index].post_comment_count = data.post_comment_count;
                    }
                    if(post_type == 3)//Promoted Index10
                    {
                        $scope.promotedPostIndex10Data[postIndex].post_comment_data[commentIndex].comment = data.comment;
                        // $scope.promotedPostIndex10Data[index].post_comment_count = data.post_comment_count;
                    }
                }
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendEditComment(comment_id,post_id,user_id);
                },200);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.sendCommentReply = function (comment_id,post_id,postIndex,commentIndex,is_promoted) {
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
                        if(is_promoted == 1)
                        {
                            $scope.promotedPostData[postIndex].post_comment_data[commentIndex].comment_reply_data = data.comment_reply_data;
                            if(socket)
                            {
                                socket.emit('user notification',$scope.promotedPostData[postIndex].post_comment_data[commentIndex].commented_user_id);
                            }
                        }
                        else
                        {
                            $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data = data.comment_reply_data;
                            if(socket)
                            {
                                socket.emit('user notification',$scope.postData[postIndex].post_comment_data[commentIndex].commented_user_id);
                            }
                        }
                        
                        $('.editable_text').html('');
                    } else {
                        if(is_promoted == 1)
                        {
                            $scope.promotedPostData[postIndex].post_comment_data[commentIndex].comment_reply_data = data.comment_reply_data;
                            if(socket)
                            {
                                socket.emit('user notification',$scope.promotedPostData[postIndex].post_comment_data[commentIndex].commented_user_id);
                            }
                        }
                        else
                        {
                            $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data = data.comment_reply_data;
                            if(socket)
                            {
                                socket.emit('user notification',$scope.postData[postIndex].post_comment_data[commentIndex].commented_user_id);
                            }
                        }
                        
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
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
                    });

                },500);
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendCommentReply(comment_id,post_id,postIndex,commentIndex,is_promoted);
                },200);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.send_edit_comment_reply = function (reply_comment_id,post_id,postIndex, commentIndex,commentReplyIndex,post_type) {
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
                    $('#edit-comment-li-' + reply_comment_id).show();
                    $('#timeago-reply-comment-li-' + reply_comment_id).show();
                    $('#edit-reply-comment-' + reply_comment_id).hide();
                    $('#edit-comment-reply-textbox-' + reply_comment_id).html('');
                    $('#edit-comment-reply-textbox-' + reply_comment_id).hide();
                    $('#comment-reply-dis-inner-' + reply_comment_id).show();
                    $('#comment-reply-dis-inner-' + reply_comment_id).html(data.comment);
                    $('#edit-reply-comment-li-' + reply_comment_id).show();
                    $('#cancel-reply-comment-li-' + reply_comment_id).hide();
                    $(".new-comment-"+post_id).show();

                    if(post_type == 1)
                    {
                        $scope.postData[postIndex].post_comment_data[commentIndex].comment_reply_data[commentReplyIndex].comment = data.comment;
                        // $scope.postData[index].post_comment_count = data.post_comment_count;
                    }
                    if(post_type == 2)//Promoted
                    {
                        $scope.promotedPostData[postIndex].post_comment_data[commentIndex].comment_reply_data[commentReplyIndex].comment = data.comment;
                        // $scope.promotedPostData[index].post_comment_count = data.post_comment_count;
                    }
                    if(post_type == 3)//Promoted Index10
                    {
                        $scope.promotedPostIndex10Data[postIndex].post_comment_data[commentIndex].comment_reply_data[commentReplyIndex].comment = data.comment;
                        // $scope.promotedPostIndex10Data[index].post_comment_count = data.post_comment_count;
                    }

                    /*$('#comment-reply-dis-inner-' + reply_comment_id).show();
                    $('#comment-reply-dis-inner-' + reply_comment_id).html(comment);
                    $('#edit-comment-reply-textbox-' + reply_comment_id).html();
                    $('#edit-comment-reply-textbox-' + reply_comment_id).hide();
                    $('#edit-comment-li-' + reply_comment_id).show();
                    $('#edit-reply-comment-' + reply_comment_id).hide();
                    $('#cancel-reply-comment-li-' + reply_comment_id).hide();
                    $('.new-comment-'+post_id).show();*/
                }                
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.send_edit_comment_reply(reply_comment_id,post_id);
                },200);
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
                //$scope.postData.splice(index, 1);
                getUserPost();
            }
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deletedPost(post_id, index);
            },200);
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
            if($scope.count_likeUser > 0)
            {
                $scope.l_page = success.data.page;
                $scope.l_total_record = success.data.countlike;
                $('#likeusermodal').modal('show');
            }

            setTimeout(function(){
                $('[data-toggle="popover"]').popover({
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
                });
                
            },300);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.like_user_list(post_id);
            },200);
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
                    $('[data-toggle="popover"]').popover({
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
                    });
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

    $scope.like_user_model_list = function (comment_id, post_id, parent_index, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.like_user_model_list(comment_id, post_id, parent_index, index, post);
            },200);
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
    
    // angular.element("input[name='gender']:checked").val();
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
                $("#report-spam .modal-close").click();
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.save_report_spam();
                },200);
            });
        }
    };    

    $scope.deleteRecentPost = function (post_id, index) {
        $scope.p_rd_post_id = post_id;
        $scope.p_rd_index = index;

        $('#delete_recent_post_model').modal('show');
    }
    $scope.deletedRecentPost = function (post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            if (data.message == '1') {
                $scope.IsVisible = false;
                $scope.recentpost = {};
            }
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deletedRecentPost(post_id, index);
            },200);
        });
    }

    $scope.post_recent_like = function (post_id,parent_index,user_id) {
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
                $scope.recentpost.user_like_list = success.data.user_like_list;
            }            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.post_recent_like(post_id,parent_index,user_id);
            },200);
        });
    }

    $scope.viewAllCommentRecent = function (post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.recentpost.post_comment_data = data.all_comment_data;
            $scope.recentpost.post_comment_count = data.post_comment_count;
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewAllCommentRecent(post_id, index, post);
            },200);
        });

    }

    $scope.viewLastCommentRecent = function (post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            data = success.data;
            $scope.recentpost.post_comment_data = data.comment_data;
            $scope.recentpost.post_comment_count = data.post_comment_count;
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewLastCommentRecent(post_id, index, post);
            },200);
        });
    };

    $scope.editRecentPostComment = function (comment_id, post_id, parent_index, index) {
       /* var editContent = $('#comment-dis-inner-' + comment_id).html();
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();*/
        $(".comment-for-post-"+post_id+" .edit-comment").hide();
        $(".comment-for-post-"+post_id+" .comment-dis-inner").show();
        $(".comment-for-post-"+post_id+" li[id^=edit-comment-li-]").show();
        $(".comment-for-post-"+post_id+" li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        // var editContent = $('#comment-dis-inner-' + comment_id).text();
        var editContent = $scope.recentpost.post_comment_data[index].comment;
        editContent = editContent.substring(0,cmt_maxlength);
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-"+post_id).hide();
    };

    $scope.deleteRecentPostComment = function (comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;

        $('#delete_recent_model').modal('show');
    }

    $scope.deleteRecentComment = function (comment_id, post_id, parent_index, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.recentpost.post_comment_data.splice(0, 1);
                $scope.recentpost.post_comment_data.push(data.comment_data[0]);
                if(data.comment_count < 1)
                {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            } else {
                $scope.recentpost.post_comment_data.splice(index, 1);
                if(data.comment_count < 1)
                {
                    $('.post-comment-count-' + post_id).hide();
                }
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deleteRecentComment(comment_id, post_id, parent_index, index, post);
            },200);
        });
    };

    $scope.sendRecentComment = function (post_id, index, post) {
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
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            }).then(function (success) {
                data = success.data;
                
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',recentpost.post_data.user_id);
                    }
                    if (commentClassName == 'last-comment') {
                        $scope.recentpost.post_comment_data.splice(0, 1);
                        $scope.recentpost.post_comment_data.push(data.comment_data[0]);
                        if(data.comment_count > 0)
                        {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.recentpost.post_comment_data.push(data.comment_data[0]);
                        if(data.comment_count > 0)
                        {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function(){
                    $("#cmt-btn-mob-"+post_id).removeAttr("style");
                    $("#cmt-btn-mob-"+post_id).removeAttr("disabled");
                    $("#cmt-btn-"+post_id).removeAttr("style");
                    $("#cmt-btn-"+post_id).removeAttr("disabled");
                },1000);
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendRecentComment(post_id, index, post);
                },200);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };

    $scope.save_post = function(post_id,index,postData,is_promoted){
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
                if(is_promoted == 1)
                {
                    $scope.promotedPostData[index].is_user_saved_post = result.status;
                }
                else
                {
                    $scope.postData[index].is_user_saved_post = result.status;
                }
            }
            else
            {
                if(is_promoted == 1)
                {
                    $scope.promotedPostData[index].is_user_saved_post = result.status;
                }
                else
                {
                    $scope.postData[index].is_user_saved_post = result.status;
                }
            }
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.save_post(post_id,index,postData,is_promoted);
            },200);
        });
    };

    $scope.save_recent_post = function(post_id,postData){
        $('.save-recentpost-' + post_id).attr('style','pointer-events: none;');
        $http({
            method: 'POST',
            url: base_url + 'user_post/save_user_post',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            var result = success.data;
            if(result.status == '1')
            {
                $scope.recentpost.is_user_saved_post = result.status;                
            }
            else
            {
                $scope.recentpost.is_user_saved_post = result.status;
            }
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.save_recent_post(post_id,postData);
            },200);
        });
    };

    $scope.share_post = function(post_id,index,postData,is_promoted){
        if(is_promoted == 1)
        {
            $scope.share_post_data = $scope.promotedPostData[index];
        }
        else
        {
            $scope.share_post_data = $scope.postData[index];
        }
        $scope.post_index = index;
        $scope.share_is_promoted = is_promoted;
        $("#post-share").modal("show");
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
            autosize(document.getElementsByClassName('hashtag-textarea'));
        },300);
    };

    $scope.share_post_fnc = function(post_index,is_promoted){
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
                $("#post-share .modal-close").click();
                $("#share_post_text").val('');
            },100);
            if(result.status == '1')
            {
                $('.biderror .mes').html("<div class='pop_content'>Post Shared Successfully.");
                $('#posterrormodal').modal('show');
                if(is_promoted == 1)
                {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.promotedPostData[post_index].post_data.user_id);
                    }
                    $scope.promotedPostData[post_index].post_share_count = result.post_share_count;
                }
                else
                {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[post_index].post_data.user_id);
                    }
                    $scope.postData[post_index].post_share_count = result.post_share_count;
                }
            }
            else
            {
                $('.biderror .mes').html("<div class='pop_content'>Please Try Again.");
                $('#posterrormodal').modal('show');
            }
            $('.post-popup-box').attr('style','pointer-events: all;');
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.share_post_fnc(post_index,is_promoted);
            },200);
        });
    };

    $('#post_something,#post_opportunity input'). keydown(function (e) {
        if (e. keyCode == 13 && !$(e.target).is('textarea')) {
            e. preventDefault();
            return false;
        }
    });

    $scope.contact = function (id, status, to_id,indexCon,confirm) {
        if(confirm == '1')
        {
            $("#remove-contact-conform-"+indexCon).modal("show");
            return false;
        }
        $(".contact-btn-"+to_id).attr('style','pointer-events:none;');
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addToContactNewTooltip',
            data: 'contact_id=' + id + '&status=' + status + '&to_id=' + to_id + '&indexCon=' + indexCon,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {            
            if(success.data != "")
            {
                $(".contact-btn-"+to_id).attr('style','pointer-events:all;');
                $(".contact-btn-"+to_id).html($compile(success.data.button)($scope));
            }
            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.contact(id, status, to_id,indexCon,confirm);
            },200);
        });
    };

    $scope.remove_contact = function (id, status, to_id,indexCon) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addToContactNewTooltip',
            data: 'contact_id=' + id + '&status=' + status + '&to_id=' + to_id + '&indexCon=' + indexCon,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            if(success.data != "")
            {
                $(".contact-btn-"+to_id).html($compile(success.data.button)($scope));
            }
            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.remove_contact(id, status, to_id,indexCon);
            },200);
        });
    };

    /*$scope.follow_user = function (id) {
        $(".follow-btn-" + id).attr('style','pointer-events:none;');
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/follow_user_tooltip',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $(".follow-btn-" + id).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-" + id).html($compile(success.data)($scope));
                // $(".follow-btn-" + id).html(success.data);
            },500);
        },function errorCallback(response) {
            $scope.follow_user(id);
        });
    }

    $scope.unfollow_user = function (id) {
        $(".follow-btn-" + id).attr('style','pointer-events:none;');
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/unfollow_user_tooltip',
            data: 'to_id=' + id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
        .then(function (success) {
            $(".follow-btn-" + id).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-" + id).html($compile(success.data)($scope));
                // $(".follow-btn-" + id).html(success.data);
            },500);
        },function errorCallback(response) {
            $scope.unfollow_user(id);
        });
    }*/

    $scope.owlOptionsTestimonials = {
        'slideBy':2,
        'touchDrag':false,
        'mouseDrag':false,
        'loop': false,
        'nav': true,
        'lazyLoad': true,
        'margin': 0,
        'video': true,
        'responsive': {
            0: {
                items: 1
            },
            480: {
                items: 2
            },
            768: {
                items: 2
            },
            1280: {
                items: 2
            }
        }
    };

    $scope.owlOptionsHashtag = {
        'slideBy':3,
        'touchDrag':false,
        'mouseDrag':false,
        'loop': false,
        'nav': true,
        'lazyLoad': true,
        'margin': 0,
        'video': true,
        'responsive': {
            0: {
                items: 1
            },
            480: {
                items: 3
            },
            768: {
                items: 3
            },
            1280: {
                items: 3
            }
        }
    };

    setTimeout(function(){
        $(".hashtags-left-bar .owl-carousel").owlCarousel({
            'slideBy':1,
            'touchDrag':false,
            'mouseDrag':false,
            'loop': false,
            'nav': true,
            'lazyLoad': true,
            'margin': 0,
            'video': true,
            'responsive': {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                768: {
                    items: 1
                },
                1280: {
                    items: 1
                }
            }
        });
    },500);

    $scope.follow_hashtag = function(hashtag_id)
    {
        $(".hashtag-follow-btn-"+hashtag_id+" a").attr('style','pointer-events:none;');
        $(".hashtag-follow-btn-"+hashtag_id+" a").html('Following');
        $http({
            method: 'POST',
            url: base_url + 'user_post/follow_hashtag',
            data: 'hashtag_id=' + hashtag_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.status == 1) {
                $scope.hashtag_count = success.data.hashtag_count;                
                setTimeout(function(){
                    var $f_html = $(".hashtag-follow-btn-"+hashtag_id).html(success.data.follow_html);
                    $compile($f_html)($scope);

                    $(".hashtag-follow-count-"+hashtag_id).show();
                    if(success.data.hashtag_follower_count != '')
                    {
                        var $f_count = $(".hashtag-follow-count-"+hashtag_id).html(success.data.hashtag_follower_count + ' Followers');
                    }
                    $compile($f_count)($scope);
                },500);
            }
            $(".hashtag-follow-btn-"+hashtag_id+" a").removeAttr('style');
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.follow_hashtag(hashtag_id);
            },500);
        });
    };
    $scope.unfollow_hashtag = function(hashtag_id)
    {
        $(".hashtag-follow-btn-"+hashtag_id+" a").attr('style','pointer-events:none;');
        $(".hashtag-follow-btn-"+hashtag_id+" a").html('Follow');
        $http({
            method: 'POST',
            url: base_url + 'user_post/unfollow_hashtag',
            data: 'hashtag_id=' + hashtag_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.status == 0) {
                setTimeout(function(){
                    $scope.hashtag_count = success.data.hashtag_count;
                    var $f_html = $(".hashtag-follow-btn-"+hashtag_id).html(success.data.follow_html);
                    $compile($f_html)($scope);
                    if(success.data.hashtag_follower_count != '')
                    {
                        var $f_count = $(".hashtag-follow-count-"+hashtag_id).html(success.data.hashtag_follower_count + ' Followers');
                    }
                    else
                    {
                        $(".hashtag-follow-count-"+hashtag_id).hide();
                    }
                    $compile($f_count)($scope);
                },100);                
            }
            $(".hashtag-follow-btn-"+hashtag_id+" a").removeAttr('style');
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.unfollow_hashtag(hashtag_id);
            },500);
        });
    };

    $scope.get_hashtag_list = function(start) {
        if (isProcessing) {
            return false;
        }
        isProcessing = true;
        $("#hashtag-loader").show();
        $http({
            method: 'POST',
            url: base_url + 'user_post/get_hashtag_list?page='+start,            
            data: 'search_tag='+$scope.search_tag,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $("#hashtag-loader").hide();            
            
            if (success.data.hashtag_list.length >0 ) {
                if(start > 1)
                {
                    for (var i in success.data.hashtag_list) {                            
                        //$scope.searchJob.push(data.latestJobs[i]);
                        //$scope.$apply(function () {
                            $scope.hashtag_list.push(success.data.hashtag_list[i]);
                        //});
                    }
                }
                else
                {
                    $scope.hashtag_list = success.data.hashtag_list;
                }

                
                isProcessing = false;

                // $scope.hashtag_list = success.data.hashtag_list;
                $scope.hash_page_number = start;
                $scope.hash_total_record = success.data.total_record;
                $scope.hash_perpage_record = 12;
            }
            else
            {
                isProcessing = true;
                $scope.showLoadmore = false;
                // $scope.hashtag_list = success.data.hashtag_list;
                $scope.hash_page_number = start;
                $scope.hash_total_record = success.data.total_record;
                $scope.hash_perpage_record = 12;
            }            
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.get_hashtag_list(start);
            },500);
        }, 
        function (complete) {
            $(".sugg_post_load").hide();
        });
    };

    $scope.get_hashtag_search = function() {
        start = 1;
        if (isProcessing) {
            return false;
        }
        isProcessing = true;
        $(".sugg_post_load").show();
        $http({
            method: 'POST',
            url: base_url + 'user_post/get_hashtag_list?page='+start,
            data: 'search_tag='+$("#hashtag-search").val(),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $(".sugg_post_load").hide();            
            
            if (success.data.hashtag_list.length >0 ) {
                if(start > 1)
                {
                    for (var i in success.data.hashtag_list) {                            
                        //$scope.searchJob.push(data.latestJobs[i]);
                        //$scope.$apply(function () {
                            $scope.hashtag_list.push(success.data.hashtag_list[i]);
                        //});
                    }
                }
                else
                {
                    $scope.hashtag_list = success.data.hashtag_list;
                }

                
                isProcessing = false;

                // $scope.hashtag_list = success.data.hashtag_list;
                $scope.hash_page_number = start;
                $scope.hash_total_record = success.data.total_record;
                $scope.hash_perpage_record = 12;
            }
            else
            {
                isProcessing = true;
                $scope.showLoadmore = false;
                $scope.hashtag_list = success.data.hashtag_list;
                $scope.hash_page_number = start;
                $scope.hash_total_record = success.data.total_record;
                $scope.hash_perpage_record = 12;
            }
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.get_hashtag_list(start);
            },500);
        }, 
        function (complete) {
            $(".sugg_post_load").hide();
        });
    };
    $scope.get_hashtag_list(1);
    $scope.check_enter_key = function($event){
        var keyCode = $event.which || $event.keyCode;
        if (keyCode === 13) {
            isProcessing = false;
            $scope.get_hashtag_search(1);
        }
    };

    // angular.element($window).bind("scroll", function (e) {
    $('.post-popup-scroll').on('scroll', function () {
        if($(this).scrollTop() + $(this).innerHeight() >= ($(this)[0].scrollHeight)) {

            var page = $scope.hash_page_number;
            var total_record = $scope.hash_total_record;
            var perpage_record = $scope.hash_perpage_record;
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.hash_page_number) + 1;
                    $scope.get_hashtag_list(pagenum);
                }
            }
        }
    });
});

app.controller('peopleController', function($scope, $http, $compile, $window,$location) {
    $scope.today = new Date(); 
    $scope.$parent.active_tab = '2';
    $scope.$parent.title = "People | Aileensoul";
    $scope.user_id = user_id;
    
    var isProcessing = false;
    var isProcessingPst = false;
    
    var pagenum = 0
    $scope.perpage_record = 15;
    $scope.total_record = 0;

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
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
                
                setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    $scope.peopleData = function(pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $("#people-loader").show();

        var search_job_title = '';
        var search_city = '';
        var search_field = '';
        if($scope.search_job_title != '')
        {
            search_job_title = JSON.stringify($scope.search_job_title);
        }        
        if($scope.search_city != '')
        {
            search_city = JSON.stringify($scope.search_city);
        }
        if($scope.search_field != '')
        {
            search_field = $scope.search_field;
        }
        // console.log($scope.search_gender);

        $http({
            method: 'POST',
            url: base_url + 'user_post/peopleData',            
            data: 'page='+pagenum+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city+'&search_gender='+$scope.search_gender,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {

            $('#main_loader').hide();            
            $("#people-loader").hide();

            $scope.page_number = success.data.page;
            if(success.data.people_data.length > 0)
            {
                isProcessing = false;
                if (pagenum != 0 && $scope.people_data != undefined) {
                    for (var i in success.data.people_data) {
                        $scope.people_data.push(success.data.people_data[i]);
                    }
                }
                else{                
                    $scope.people_data = success.data.people_data;
                    if($scope.total_record == 0)
                    {
                        $scope.total_record = success.data.total_record;
                    }
                }

                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
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
                    });
                },500);
            }
            else
            {
                isProcessing = true;
            }
            
            $('#main_loader').hide();            
            $('body').removeClass("body-loader");            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.peopleData();
            },200);
        });
    };
    $scope.peopleData(pagenum);

    $scope.main_search_function = function(){
        if(($scope.search_job_title == undefined || $scope.search_job_title.length < 1) && ($scope.search_field == undefined || $scope.search_field == '') && ($scope.search_city == undefined || $scope.search_city.length < 1) && ($scope.search_gender == undefined || $scope.search_gender == ''))
        {
            return false;
        }
        else
        {
            $scope.people_data = '';
            $("#people-loader").show();
            pagenum = 0;
            isProcessing = false;
            var search_job_title = '';
            var search_city = '';
            var search_field = '';
            if($scope.search_job_title != '')
            {
                search_job_title = JSON.stringify($scope.search_job_title);
            }        
            if($scope.search_city != '')
            {
                search_city = JSON.stringify($scope.search_city);
            }
            if($scope.search_field != '')
            {
                search_field = $scope.search_field;
            }

            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'user_post/peopleData',
                data: 'page=' + pagenum+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city+'&search_gender='+$scope.search_gender,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#people-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.people_data = success.data.people_data;
                $scope.total_record = success.data.total_record;

                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
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
                    });
                },500);

                $('#main_loader').hide();
                $('body').removeClass("body-loader");                
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.main_search_function();
                },200);
            });
        }
    };

    $scope.clearData = function(){
        $scope.search_job_title = [];
        $scope.search_field = '';
        $scope.search_city = [];
        $scope.search_hashtag = [];
        $scope.search_company = [];
        $scope.search_gender = '';

        setTimeout(function(){
            $('#search_field').val(null).trigger('change');
        });


        pagenum = 0;
        isProcessing = false;
        $scope.peopleData(pagenum);
        // $scope.get_search_total_count();
    }

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) && $location.url().substr(1) == 'peoples') {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // console.log(parseInt(perpage_record * page));
            // console.log(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.peopleData(pagenum);
                }
            }
        }
    });

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
            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.contact(id, status, to_id,indexCon,confirm);
            },200);
        });
    };

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
            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.remove_contact(id, status, to_id,indexCon);
            },200);
        });
    };

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
});

app.controller('postController', function($scope, $http, $compile, $window,$location) {
    $scope.today = new Date();

    $scope.$parent.title = "Posts | Aileensoul";
    $scope.$parent.active_tab = '3';
    $scope.user_id = user_id;
    
    var isProcessing = false;

    var pagenum = 0
    $scope.perpage_record = 10;
    $scope.total_record = 0;

    $scope.details_in_popup = function(uid,login_user_id,utype,div_id){
        socket.emit('get user card',uid,login_user_id,utype);
        socket.on('get user card', (data) => {
            if(data.login_user_id == login_user_id){
                //var times = $scope.today.getHours()+''+$scope.today.getMinutes()+''+$scope.today.getSeconds();
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
                
                setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    $scope.postsData = function(pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $("#post-loader").show();

        var search_hashtag = JSON.stringify($scope.search_hashtag);

        $http({
            method: 'POST',
            url: base_url + 'user_post/postsData',            
            data: 'page='+pagenum+'&search_hashtag='+search_hashtag,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {

            $('#main_loader').hide();            
            $("#post-loader").hide();

            $scope.page_number = success.data.page;
            if(success.data.sim_post.length > 0)
            {
                isProcessing = false;
                if (pagenum != 0 && $scope.postData != undefined) {
                    for (var i in success.data.sim_post) {
                        $scope.postData.push(success.data.sim_post[i]);
                    }
                }
                else{                
                    $scope.postData = success.data.sim_post;
                    if($scope.total_record == 0)
                    {
                        $scope.total_record = success.data.total_record;
                    }
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

                    $('[data-toggle="popover"]').popover({
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
                    });
                
                    // $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
                },1000);
            }
            else
            {
                isProcessing = true;
            }
            
            $('#main_loader').hide();            
            $('body').removeClass("body-loader");            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.postsData(pagenum);
            },200);
        });
    };
    $scope.postsData(pagenum);    

    $scope.main_search_function = function(){
        if($scope.search_hashtag == undefined || $scope.search_hashtag.length < 1)
        {
            return false;
        }
        else
        {
            pagenum = 0;
            isProcessing = false;
            var search_hashtag = JSON.stringify($scope.search_hashtag);
            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'user_post/postsData',
                data: 'page='+pagenum+'&search_hashtag='+search_hashtag,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#post-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.postData = success.data.sim_post;                
                $scope.total_record = success.data.total_record;

                $('#main_loader').hide();
                $('body').removeClass("body-loader");
                
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
                    $('[data-toggle="popover"]').popover({
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
                    });
                },1000);
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.main_search_function();
                },200);
            });
        }
    };

    $scope.clearData = function(){
        $scope.search_job_title = [];
        $scope.search_field = '';
        $scope.search_city = [];
        $scope.search_hashtag = [];
        $scope.search_company = [];
        $scope.search_gender = '';

        pagenum = 0;
        isProcessing = false;
        $scope.postsData(pagenum);        
    }

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) && $location.url().substr(1) == 'posts') {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // console.log(parseInt(perpage_record * page));
            // console.log(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.postsData(pagenum);
                }
            }
        }
    });

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

    $scope.post_like = function (post_id,parent_index,user_id) {
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.post_like(post_id,parent_index,user_id);
            },200);
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

                    $('[data-toggle="popover"]').popover({
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
                    });
                },1000);
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendComment(post_id, index, post);
                },200);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.viewAllComment = function (post_id, index, post,post_type) {
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
            if(post_type == 1)
            {
                $scope.postData[index].post_comment_data = data.all_comment_data;
                $scope.postData[index].post_comment_count = data.post_comment_count;
            }
            if(post_type == 2)//Promoted
            {
                $scope.promotedPostData[index].post_comment_data = data.all_comment_data;
                $scope.promotedPostData[index].post_comment_count = data.post_comment_count;
            }
            if(post_type == 3)//Promoted Index10
            {
                $scope.promotedPostIndex10Data[index].post_comment_data = data.all_comment_data;
                $scope.promotedPostIndex10Data[index].post_comment_count = data.post_comment_count;
            }
            setTimeout(function(){
                $('[data-toggle="popover"]').popover({
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
                });
            },1000);            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewAllComment(post_id, index, post);
            },200);
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
            if(post_type == 1)
            {
                $scope.postData[index].post_comment_data = data.comment_data;
                $scope.postData[index].post_comment_count = data.post_comment_count;
            }
            if(post_type == 2)//Promoted
            {
                $scope.promotedPostData[index].post_comment_data = data.comment_data;
                $scope.promotedPostData[index].post_comment_count = data.post_comment_count;
            }
            if(post_type == 3)//Promoted Index10
            {
                $scope.promotedPostIndex10Data[index].post_comment_data = data.comment_data;
                $scope.promotedPostIndex10Data[index].post_comment_count = data.post_comment_count;
            }
            setTimeout(function(){
                $('[data-toggle="popover"]').popover({
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
                });
            },1000);            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewLastComment(post_id, index, post);
            },200);
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deleteComment(comment_id, post_id, parent_index, index, post);
            },200);
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.likePostComment(comment_id, post_id,commented_user_id);
            },200);
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
                    setTimeout(function(){
                        $('[data-toggle="popover"]').popover({
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
                        });
                    },1000);                    
                }
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendEditComment(comment_id,post_id,user_id);
                },200);
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
                        $('[data-toggle="popover"]').popover({
                            trigger: "manual" ,
                            html: true, 
                            animation:false,
                            template: '<div class="popover cus-tooltip" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                            content: function () {
                                // return $($(this).data('tooltip-content')).html();
                                var uid = $(this).data('uid');
                                var utype = $(this).data('utype');
                                var div_id =  "tmp-id-" + $.now();
                                return $scope.details_in_popup(uid,$scope.user_id,utype,div_id);Z
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
                        });
                    },1000);                    
                }
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.save_recent_post(comment_id,post_id,postIndex,commentIndex);
                },200);
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
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.send_edit_comment_reply(reply_comment_id,post_id);
                },200);
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
                $scope.postData.splice(index, 1);
            }
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deletedPost(post_id, index);
            },200);
        });
    }
    
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
            }
            setTimeout(function(){
                $('[data-toggle="popover"]').popover({
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
                });
            },1000);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.like_user_list(post_id);
            },200);
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
                    $('[data-toggle="popover"]').popover({
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
                    });
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.save_post(post_id,index,postData);
            },200);
        });
    };

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
                $("#report-spam .modal-close").click();
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.save_report_spam();
                },200);
            });
        }
    };

    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];        
        $scope.post_index = index;
        $("#post-share").modal("show");
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
                $("#post-share .modal-close").click();
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.share_post_fnc(post_index);
            },200);
        });
    };

    $scope.hashtags = [];
    $scope.loadHashtag = function ($query) {
        return $http.get(base_url + 'user_post/get_hashtag', {cache: true}).then(function (response) {
            var hashtag_data = response.data;
            return hashtag_data.filter(function (hashtags) {
                return hashtags.hashtag.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.removeViewMore = function(mainId,removeViewMore) {    
        $("#"+mainId).removeClass("view-more-expand");
        $("#"+removeViewMore).remove();
    };
});

app.controller('opportunityController', function($scope, $http, $compile, $window,$location) {
    $scope.today = new Date();

    $scope.$parent.title = "Opportunities | Aileensoul";
    $scope.$parent.active_tab = '4';
    $scope.user_id = user_id;
    
    var isProcessing = false;
    var isProcessingPst = false;
    
    var pagenum = 0
    $scope.perpage_record = 10;
    $scope.total_record = 0;

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
                
                setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    $scope.opportunityData = function(pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $("#post-loader").show();

        var search_job_title = JSON.stringify($scope.search_job_title);
        var search_city = JSON.stringify($scope.search_city);
        var search_hashtag = JSON.stringify($scope.search_hashtag);
        var search_company = JSON.stringify($scope.search_company);
        var search_field = $scope.search_field;

        $http({
            method: 'POST',
            url: base_url + 'user_post/opportunityData',            
            data: 'page='+pagenum+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city+'&search_hashtag='+search_hashtag+'&search_company='+search_company,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {

            $('#main_loader').hide();            
            $("#post-loader").hide();

            $scope.page_number = success.data.page;
            if(success.data.opportunity_post.length > 0)
            {
                isProcessing = false;
                if (pagenum != 0 && $scope.postData != undefined) {
                    for (var i in success.data.opportunity_post) {
                        $scope.postData.push(success.data.opportunity_post[i]);
                    }
                }
                else{                
                    $scope.postData = success.data.opportunity_post;
                    if($scope.total_record == 0)
                    {
                        $scope.total_record = success.data.total_record;
                    }
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
                    
                    $('[data-toggle="popover"]').popover({
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
                    });
            
                },1000);
            }
            else
            {
                isProcessing = true;
            }
            
            $('#main_loader').hide();            
            $('body').removeClass("body-loader");            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.opportunityData(pagenum);
            },200);
        });
    };
    $scope.opportunityData(pagenum);

    $scope.main_search_function = function(){
        if(($scope.search_job_title == undefined || $scope.search_job_title.length < 1) && ($scope.search_field == undefined || $scope.search_field == '') && ($scope.search_city == undefined || $scope.search_city.length < 1) && ($scope.search_hashtag == undefined || $scope.search_hashtag.length < 1) && ($scope.search_company == undefined || $scope.search_company.length < 1))
        {
            return false;
        }
        else
        {
            pagenum = 0;
            isProcessing = false;
            var search_job_title = JSON.stringify($scope.search_job_title);
            var search_city = JSON.stringify($scope.search_city);
            var search_hashtag = JSON.stringify($scope.search_hashtag);
            var search_company = JSON.stringify($scope.search_company);
            var search_field = $scope.search_field;
            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'user_post/opportunityData',
                data: "page=" + pagenum+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city+'&search_hashtag='+search_hashtag+'&search_company='+search_company,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#post-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.postData = success.data.opportunity_post;
                $scope.total_record = success.data.total_record;

                $('#main_loader').hide();
                $('body').removeClass("body-loader");
                
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

                    $('[data-toggle="popover"]').popover({
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
                    });
                },1000);
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.main_search_function();
                },200);
            });
        }
    };

    $scope.clearData = function(){
        $scope.search_job_title = [];
        $scope.search_field = '';
        $scope.search_city = [];
        $scope.search_hashtag = [];
        $scope.search_company = [];
        $scope.search_gender = '';
        setTimeout(function(){
            $('#search_field').val(null).trigger('change');
        });

        pagenum = 0;
        isProcessing = false;
        $scope.opportunityData(pagenum);        
    }

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) && $location.url().substr(1) == 'opportunities') {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // console.log(parseInt(perpage_record * page));
            // console.log(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.opportunityData(pagenum);
                }
            }
        }
    });

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

    $scope.hashtags = [];
    $scope.loadHashtag = function ($query) {
        return $http.get(base_url + 'user_post/get_hashtag', {cache: true}).then(function (response) {
            var hashtag_data = response.data;
            return hashtag_data.filter(function (hashtags) {
                return hashtags.hashtag.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.business_arr = [];
    $scope.loadBusiness = function ($query) {
        return $http.get(base_url + 'user_post/get_all_business', {cache: true}).then(function (response) {
            var business_data = response.data;
            return business_data.filter(function (business_arr) {
                return business_arr.company_name.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
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

    $scope.post_like = function (post_id,parent_index,user_id) {
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.post_like(post_id,parent_index,user_id);
            },200);
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

                    $('[data-toggle="popover"]').popover({
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
                    });
                },1000);
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendComment(post_id, index, post);
                },200);
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
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewAllComment(post_id, index, post);
            },200);
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
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewLastComment(post_id, index, post);
            },200);
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deleteComment(comment_id, post_id, parent_index, index, post);
            },200);
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.likePostComment(comment_id, post_id,commented_user_id);
            },200);
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

                    setTimeout(function(){
                        $('[data-toggle="popover"]').popover({
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
                        });
                    },500);
                }
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendEditComment(comment_id,post_id,user_id);
                },200);
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
                        $('[data-toggle="popover"]').popover({
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
                        });
                    },500);
                }
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendCommentReply(comment_id,post_id,postIndex,commentIndex);
                },200);
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
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.send_edit_comment_reply(reply_comment_id,post_id);
                },200);
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
                $scope.postData.splice(index, 1);
            }
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deletedPost(post_id, index);
            },200);
        });
    }
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
            }
            setTimeout(function(){
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.like_user_list(post_id);
            },200);
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
                    $('[data-toggle="popover"]').popover({
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
                    });
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.save_post(post_id,index,postData);
            },200);
        });
    };

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
                $("#report-spam .modal-close").click();
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.save_report_spam();
                },200);
            });
        }
    };

    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];        
        $scope.post_index = index;
        $("#post-share").modal("show");
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
                $("#post-share .modal-close").click();
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.share_post_fnc(post_index);
            },200);
        });
    };

    $scope.removeViewMore = function(mainId,removeViewMore) {    
        $("#"+mainId).removeClass("view-more-expand");
        $("#"+removeViewMore).remove();
    };
});

app.controller('articleController', function($scope, $http, $compile, $window,$location) {
    $scope.today = new Date();
    $scope.$parent.title = "Articles | Aileensoul";
    $scope.$parent.active_tab = '5';
    $scope.user_id = user_id;
    
    var isProcessing = false;
    var isProcessingPst = false;
    
    var pagenum = 0
    $scope.perpage_record = 10;
    $scope.total_record = 0;

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
                
                setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    $scope.articleData = function(pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $("#post-loader").show();

        var search_field = '';
        if($scope.search_field != '')
        {
            search_field = $scope.search_field;
        }
        var search_hashtag = JSON.stringify($scope.search_hashtag);

        $http({
            method: 'POST',
            url: base_url + 'user_post/articleData',
            data: 'page='+pagenum+'&search_field='+search_field+'&search_hashtag='+search_hashtag,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {

            $('#main_loader').hide();            
            $("#post-loader").hide();

            $scope.page_number = success.data.page;
            if(success.data.article_post.length > 0)
            {
                isProcessing = false;
                if (pagenum != 0 && $scope.postData != undefined) {
                    for (var i in success.data.article_post) {
                        $scope.postData.push(success.data.article_post[i]);
                    }
                }
                else{                
                    $scope.postData = success.data.article_post;
                    if($scope.total_record == 0)
                    {
                        $scope.total_record = success.data.total_record;
                    }
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
                    
                    $('[data-toggle="popover"]').popover({
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
                    });
            
                },1000);
            }
            else
            {
                isProcessing = true;
            }
            
            $('#main_loader').hide();            
            $('body').removeClass("body-loader");            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.articleData(pagenum);
            },200);
        });
    };
    $scope.articleData(pagenum);

    $scope.main_search_function = function(){
        if(($scope.search_hashtag == undefined || $scope.search_hashtag.length < 1) && ($scope.search_field == undefined || $scope.search_field == ''))
        {
            return false;
        }
        else
        {
            pagenum = 0;
            isProcessing = false;
            var search_hashtag = JSON.stringify($scope.search_hashtag);            
            var search_field = $scope.search_field;            
            $http({
                method: 'POST',
                url: base_url + 'user_post/articleData',
                data: 'page='+pagenum+'&search_field='+search_field+'&search_hashtag='+search_hashtag,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#post-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.postData = success.data.article_post;
                $scope.total_record = success.data.total_record;
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

                    $('[data-toggle="popover"]').popover({
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
                    });                
                },1000);

                $('#main_loader').hide();
                $('body').removeClass("body-loader");
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.main_search_function();
                },200);
            });
        }
    };    

    $scope.clearData = function(){
        $scope.search_job_title = [];
        $scope.search_field = '';
        $scope.search_city = [];
        $scope.search_hashtag = [];
        $scope.search_company = [];
        $scope.search_gender = '';
        setTimeout(function(){
            $('#search_field').val(null).trigger('change');
        });

        pagenum = 0;
        isProcessing = false;
        $scope.articleData(pagenum);        
    }

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) && $location.url().substr(1) == 'articles') {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // console.log(parseInt(perpage_record * page));
            // console.log(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.articleData(pagenum);
                }
            }
        }
    });

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

    $scope.post_like = function (post_id,parent_index,user_id) {
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.post_like(post_id,parent_index,user_id);
            },200);
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

                    
                    $('[data-toggle="popover"]').popover({
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
                    });
            
                },1000);
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendComment(post_id, index, post);
                },200);
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
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewAllComment(post_id, index, post);
            },200);
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
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewLastComment(post_id, index, post);
            },200);
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deleteComment(comment_id, post_id, parent_index, index, post);
            },200);
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.likePostComment(comment_id, post_id,commented_user_id);
            },200);
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
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendEditComment(comment_id,post_id,user_id);
                },200);
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
                }
                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
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
                    });
                },500);
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendCommentReply(comment_id,post_id,postIndex,commentIndex);
                },200);
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
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.send_edit_comment_reply(reply_comment_id,post_id);
                },200);
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
                $scope.postData.splice(index, 1);
            }
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deletedPost(post_id, index);
            },200);
        });
    }

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
            }
            setTimeout(function(){
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.like_user_list(post_id);
            },200);
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
                    $('[data-toggle="popover"]').popover({
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
                    });
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.save_post(post_id,index,postData);
            },200);
        });
    };

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
                $("#report-spam .modal-close").click();
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.save_report_spam();
                },200);
            });
        }
    };

    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];        
        $scope.post_index = index;
        $("#post-share").modal("show");
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
                $("#post-share .modal-close").click();
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.share_post_fnc(post_index);
            },200);
        });
    };

    $scope.hashtags = [];
    $scope.loadHashtag = function ($query) {
        return $http.get(base_url + 'user_post/get_hashtag', {cache: true}).then(function (response) {
            var hashtag_data = response.data;
            return hashtag_data.filter(function (hashtags) {
                return hashtags.hashtag.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.removeViewMore = function(mainId,removeViewMore) {    
        $("#"+mainId).removeClass("view-more-expand");
        $("#"+removeViewMore).remove();
    };
});

app.controller('questionController', function($scope, $http, $compile, $window,$location) {
    $scope.today = new Date();

    $scope.$parent.title = "Questions | Aileensoul";
    $scope.$parent.active_tab = '6';
    $scope.user_id = user_id;
    
    var isProcessing = false;
    var isProcessingPst = false;
    
    var pagenum = 0
    $scope.perpage_record = 10;
    $scope.total_record = 0;

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
                
                setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    $scope.questionData = function(pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $("#post-loader").show();

        var search_hashtag = JSON.stringify($scope.search_hashtag);
        var search_field = $scope.search_field;

        $http({
            method: 'POST',
            url: base_url + 'user_post/questionData',            
            data: 'page='+pagenum+'&search_field='+search_field+'&search_hashtag='+search_hashtag,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {

            $('#main_loader').hide();            
            $("#post-loader").hide();

            $scope.page_number = success.data.page;
            if(success.data.question_post.length > 0)
            {
                isProcessing = false;
                if (pagenum != 0 && $scope.postData != undefined) {
                    for (var i in success.data.question_post) {
                        $scope.postData.push(success.data.question_post[i]);
                    }
                }
                else{                
                    $scope.postData = success.data.question_post;
                    if($scope.total_record == 0)
                    {
                        $scope.total_record = success.data.total_record;
                    }
                }
                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
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
                    });
                },500);
            }
            else
            {
                isProcessing = true;
            }
            
            $('#main_loader').hide();            
            $('body').removeClass("body-loader");            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.questionData(pagenum);
            },200);
        });
    };
    $scope.questionData(pagenum);

    $scope.main_search_function = function(){
        if(($scope.search_hashtag == undefined || $scope.search_hashtag.length < 1) && ($scope.search_field == undefined || $scope.search_field == ''))
        {
            return false;
        }
        else
        {
            pagenum = 0;
            isProcessing = false;
            var search_hashtag = JSON.stringify($scope.search_hashtag);
            var search_field = $scope.search_field;
            $http({
                method: 'POST',
                url: base_url + 'user_post/questionData',            
                data: 'page='+pagenum+'&search_field='+search_field+'&search_hashtag='+search_hashtag,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#post-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.postData = success.data.question_post;
                $scope.total_record = success.data.total_record;
                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
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
                    });
                },500);

                $('#main_loader').hide();
                $('body').removeClass("body-loader");
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.main_search_function();
                },200);
            });
        }
    };

    $scope.clearData = function(){
        $scope.search_job_title = [];
        $scope.search_field = '';
        $scope.search_city = [];
        $scope.search_hashtag = [];
        $scope.search_company = [];
        $scope.search_gender = '';
        setTimeout(function(){
            $('#search_field').val(null).trigger('change');
        });

        pagenum = 0;
        isProcessing = false;
        $scope.questionData(pagenum);        
    }

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) && $location.url().substr(1) == 'qa') {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // console.log(parseInt(perpage_record * page));
            // console.log(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.questionData(pagenum);
                }
            }
        }
    });

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

    $scope.post_like = function (post_id,parent_index,user_id) {
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.post_like(post_id,parent_index,user_id);
            },200);
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
                    
                    $('[data-toggle="popover"]').popover({
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
                    });
            
                },1000);
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendComment(post_id, index, post);
                },200);
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
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewAllComment(post_id, index, post);
            },200);
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
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.viewLastComment(post_id, index, post);
            },200);
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deleteComment(comment_id, post_id, parent_index, index, post);
            },200);
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.likePostComment(comment_id, post_id,commented_user_id);
            },200);
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
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendEditComment(comment_id,post_id,user_id);
                },200);
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
                        $('[data-toggle="popover"]').popover({
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
                        });
                    },500);
                }
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.sendCommentReply(comment_id,post_id,postIndex,commentIndex);
                },200);
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
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.send_edit_comment_reply(reply_comment_id,post_id);
                },200);
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
                $scope.postData.splice(index, 1);
            }
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.deletedPost(post_id, index);
            },200);
        });
    }
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
            setTimeout(function(){
                $('[data-toggle="popover"]').popover({
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
                });
            },500);
            if(success.data.countlike > 0)
            {
                $scope.l_page = success.data.page;
                $scope.l_total_record = success.data.countlike;
                $('#likeusermodal').modal('show');
            }
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.like_user_list(post_id);
            },200);
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
                    $('[data-toggle="popover"]').popover({
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
                    });
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.save_post(post_id,index,postData);
            },200);
        });
    };

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
                $("#report-spam .modal-close").click();
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.save_report_spam();
                },200);
            });
        }
    };

    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];        
        $scope.post_index = index;
        $("#post-share").modal("show");
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
                $("#post-share .modal-close").click();
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
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.share_post_fnc(post_index);
            },200);
        });
    };

    $scope.hashtags = [];
    $scope.loadHashtag = function ($query) {
        return $http.get(base_url + 'user_post/get_hashtag', {cache: true}).then(function (response) {
            var hashtag_data = response.data;
            return hashtag_data.filter(function (hashtags) {
                return hashtags.hashtag.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        });
    };

    $scope.removeViewMore = function(mainId,removeViewMore) {    
        $("#"+mainId).removeClass("view-more-expand");
        $("#"+removeViewMore).remove();
    };
});

app.controller('businessController', function($scope, $http, $compile, $window,$location) {
    $scope.today = new Date();
    
    $scope.$parent.title = "Businesses | Aileensoul";
    $scope.$parent.active_tab = '7';
    $scope.user_id = user_id;
    
    var isProcessing = false;
    var isProcessingPst = false;
    
    var pagenum = 0
    $scope.perpage_record = 10;
    $scope.total_record = 0;

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
                
                setTimeout(function(){
                    $('#'+div_id).html(all_html);
                },1000);
            }
        });
        return '<div id="'+ div_id +'"><div class="user-tooltip" style="background: transparent;box-shadow: none;"><div class="fw text-center" style="padding-top:85px;min-height:200px"></div></div></div>';
    }

    $scope.businessData = function(pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $("#business-loader").show();        

        $http({
            method: 'POST',
            url: base_url + 'user_post/businessData',            
            data: 'page='+pagenum,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {

            $('#main_loader').hide();            
            $("#business-loader").hide();

            $scope.page_number = success.data.page;
            if(success.data.business_data.length > 0)
            {
                isProcessing = false;
                if (pagenum != 0 && $scope.business_data != undefined) {
                    for (var i in success.data.business_data) {
                        $scope.business_data.push(success.data.business_data[i]);
                    }
                }
                else{                
                    $scope.business_data = success.data.business_data;
                    if($scope.total_record == 0)
                    {
                        $scope.total_record = success.data.total_record;
                    }
                }
                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
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
                    });
                },500);
            }
            else
            {
                isProcessing = true;
            }
            
            $('#main_loader').hide();            
            $('body').removeClass("body-loader");            
        },function errorCallback(response) {
            setTimeout(function(){
                $scope.businessData(pagenum);
            },200);
        });
    };
    $scope.businessData(pagenum);

    $scope.main_search_function = function(){
        var formdata = $('#main_search').serialize();
        if(formdata == undefined || formdata.length < 1)
        {
            return false;
        }
        else
        {            
            pagenum = 0;
            isProcessing = false;

            $http({
                method: 'POST',
                url: base_url + 'user_post/businessData',
                data: formdata+"&page=" + pagenum,
                headers: {
                    'Content-Type':  'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#post-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.business_data = success.data.business_data;
                $scope.total_record = success.data.total_record;

                setTimeout(function(){
                    $('[data-toggle="popover"]').popover({
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
                    });
                },500);

                $('#main_loader').hide();
                $('body').removeClass("body-loader");
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.main_search_function();
                },200);
            });
        }
    };

    $scope.main_search_mob_function = function(){
        var formdata = $('#main_search_mob').serialize();
        if(formdata == undefined || formdata.length < 1)
        {
            return false;
        }
        else
        {            
            pagenum = 0;
            isProcessing = false;

            $http({
                method: 'POST',
                url: base_url + 'user_post/businessData',
                data: formdata+"&page=" + pagenum,
                headers: {
                    'Content-Type':  'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#post-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.business_data = success.data.business_data;
                $scope.total_record = success.data.total_record;

                $('#main_loader').hide();
                $('body').removeClass("body-loader");
            },function errorCallback(response) {
                setTimeout(function(){
                    $scope.main_search_mob_function();
                },200);
            });
        }
    };

    $scope.clearData = function(){
        
        pagenum = 0;
        isProcessing = false;
        $('#main_search')[0].reset();        
        $scope.businessData(pagenum);        
    }

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) && $location.url().substr(1) == 'businesses') {
            // console.log($(window).scrollTop());
            // console.log($(document).height() - $(window).height());
            var page = $scope.page_number;//$(".page_number").val();
            var total_record = $scope.total_record;//$(".total_record").val();
            var perpage_record = $scope.perpage_record;//$(".perpage_record").val();            
            // console.log(parseInt(perpage_record * page));
            // console.log(total_record);

            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.page_number) + 1;// parseInt($(".page_number").val()) + 1;
                    $scope.businessData(pagenum);
                }
            }
        }
    });
});

$(document).click(function(){
    $('.right-header ul.dropdown-menu').hide();
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
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