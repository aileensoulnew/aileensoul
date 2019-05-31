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
                setTimeout(function(){
                    $('.comment-dis-inner a').attr('target', '_self');
                },500);
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

app.directive("owlCarousel", function() {
    return {
        restrict: 'E',
        link: function(scope) {
            scope.initCarousel = function(element) {
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
app.filter('slugify', function() {
    return function(input) {
        if (!input) return;
        // make lower case and trim
        var slug = input.toLowerCase().trim();
        // replace invalid chars with spaces
        slug = slug.replace(/[^a-z0-9\s-]/g, ' ');
        // replace multiple spaces or hyphens with a single hyphen
        slug = slug.replace(/[\s-]+/g, '-');
        return slug;
    };
});
app.directive('owlCarouselItem', [function() {
    return {
        restrict: 'A',
        link: function(scope, element) {
            // wait for the last item in the ng-repeat then call init
            if (scope.$last) {
                scope.initCarousel(element.parent());
            }
        }
    };
}]);
app.filter('removeLastCharacter', function() {
    return function(text) {
        return text.substr(0, text.lastIndexOf(".") + 1);
        //return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});
app.filter('parseUrl', function($sce) {
    var urls = /(\b(https:\/\/?|http:\/\/?|ftp:\/\/)[A-Z0-9+&@#\/%?=~_|!:,.;-]*[-A-Z0-9+&@#\/%=~_|])/gim
    var urlswww = /(\b(www.?)[A-Z0-9+&@#\/%?=~_|!:,.;-]*[-A-Z0-9+&@#\/%=~_|])/gim
    var emails = /(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})/gim
    return function(text, asTrusted) {
        if (text.match(urls)) {
            text = text.replace(urls, "<a href=\"$1\" target=\"_self\">$1</a>")
        } else if (text.match(urlswww)) {
            text = text.replace(urlswww, "<a href=\"//$1\" target=\"_self\">$1</a>")
        }
        if (text.match(emails)) {
            text = text.replace(emails, "<a href=\"mailto:$1\">$1</a>")
        }
        if (asTrusted) {
            return $sce.trustAsHtml(text);
        }
        return text;
    }
});
app.directive('ngEnter', function() { 
    // custom directive for sending message on enter click
    return function(scope, element, attrs) {
        element.bind("keydown keypress", function(event) {
            if (event.which === 13 && !event.shiftKey) {
                scope.$apply(function() {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});
/*app.directive("editableText", function() {
    return {
        controller: 'SearchDefaultController',
        restrict: 'C',
        replace: true,
        transclude: true,
    };
});*/
// app.controller('SearchDefaultController', ['$scope,$http', function($scope,$http) {   
app.service('likeService', function($http) {
    this.post_like = function(post_id,parent_index) {
        return $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
                    if (success.data.likePost_count < 1) {
                        $('#post-like-count-' + post_id).hide();
                    } else {
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
                // console.log(success.data.user_like_list);
                return success.data.user_like_list;
                // $scope.postData[parent_index].user_like_list = success.data.user_like_list;
            }
        });
    };
}); 
app.controller('SearchDefaultController', function($scope, $http, $compile) {
    $scope.handlePaste = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
    };

    $scope.active_tab = 0;
    $scope.contactSuggetion = [];
    /*if($scope.contactSuggetion.length == 0)
    {
        getContactSuggetion();
    }*/
    $scope.getContactSuggetion = function() {
        $http.get(base_url + "user_post/getContactSuggetion").then(function(success) {
            $scope.contactSuggetion = success.data;
        }, function(error) {});
    };
    // $scope.search_job_title = [];
    // $scope.search_field = '';
    // $scope.search_city = [];
    // $scope.search_hashtag = [];
    // $scope.search_company = [];
    // $scope.search_gender = '';

    $scope.addToContact = function(user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            if (success.data.message == 1) {
                $('#item-' + user_id + ' button.follow-btn').html('Request Send');
                $('.addtobtn-' + user_id).html('Request Send');
                $('.addtobtn-' + user_id).attr('style', 'pointer-events:none;');
                // $('.owl-carousel').trigger('next.owl.carousel');
            }
        });
    };    
});
app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/search/opportunity", {
                templateUrl: base_url + "user_post/search_opportunity",
                controller: 'opportunityController'
            })
            .when("/search/people", {
                templateUrl: base_url + "user_post/search_people",
                controller: 'peopleController'
            })
            .when("/search/post", {
                templateUrl: base_url + "user_post/search_post",
                controller: 'postController'
            })
            .when("/search/business", {
                templateUrl: base_url + "user_post/search_business",
                controller: 'businessController'
            })
            .when("/search/article", {
                templateUrl: base_url + "user_post/search_article",
                controller: 'articleController'
            })
            .when("/search/question", {
                templateUrl: base_url + "user_post/search_question",
                controller: 'questionController'
            })
            .otherwise({
                templateUrl: base_url + "user_post/search_all",
                controller: 'searchController'
            });
    $locationProvider.html5Mode(true);
});
app.controller('searchController', function($scope, $http, $compile) {
    $scope.$parent.active_tab = '1';
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;
    $scope.pro = {};
    $scope.pst = {};

    $scope.search_job_title = [];
    $scope.search_field = '';
    $scope.search_city = [];
    $scope.search_hashtag = [];
    $scope.search_company = [];
    $scope.search_gender = '';

    $scope.search_keyword = keyword;
    $scope.$parent.meta_title = '"'+keyword +'" | Aileensoul Search';
    var isProcessing = false;
    var isProcessingPst = false;
    $("#search").val(keyword);
    $("#mob_search").val(keyword);
    if(!user_id){
        window.location = "/";
    }

    $(document).on('keydown','#search_job_title .input',function () {
        if($('#search_job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_job_title .input',function () {
        if($('#search_job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_job_title .input',function () {
        if($('#search_job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_job_title ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Title');
            $(this).css('width', '100%');
        }         
    });

    $(document).on('keydown','#search_city .input',function () {
        if($('#search_city ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_city .input',function () {
        if($('#search_city ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_city .input',function () {
        if($('#search_city ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_city ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Location');
            $(this).css('width', '100%');
        }         
    });

    $scope.searchData = function() {
        //$(".post_loader").show();
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
            url: base_url + 'searchelastic/search',
            data: 'searchKeyword=' + searchKeyword+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $(".post_loader").hide();
            $scope.searchProfileData = success.data.profile;
            $scope.postData = success.data.opp_post;
            if(success.data.sim_post.length > 0)
            {
                $scope.postData.push(success.data.sim_post[0]);
            }
            if(success.data.question_post.length > 0)
            {
                $scope.postData.push(success.data.question_post[0]);
            }
            if(success.data.article_post.length > 0)
            {
                $scope.postData.push(success.data.article_post[0]);
            }

            $scope.business_data = success.data.business_data;
            
            $scope.$parent.opp_count = '('+success.data.opp_count+')';
            $scope.$parent.people_count = '('+success.data.people_count+')';
            $scope.$parent.simple_count = '('+success.data.simple_count+')';
            $scope.$parent.business_count = '('+success.data.business_count+')';
            $scope.$parent.article_count = '('+success.data.article_count+')';
            $scope.$parent.question_count = '('+success.data.question_count+')';
            $scope.$parent.total_count = '('+parseInt(success.data.opp_count+success.data.people_count+success.data.simple_count+success.data.business_count+success.data.article_count+success.data.question_count)+')';


            $('#main_loader').hide();            
            $('body').removeClass("body-loader");
            setTimeout(function() {
                $('.comment-dis-inner a').attr('target', '_self');
                $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
            }, 300);
        });
    };
    $scope.searchData();

    if($scope.$parent.contactSuggetion.length == 0)
    {
        $scope.$parent.getContactSuggetion();
    }

    $scope.clearData = function(){
        $scope.search_job_title = [];
        $scope.search_field = '';
        $scope.search_city = [];
        $scope.$parent.search_hashtag = [];
        $scope.$parent.search_company = [];
        $scope.$parent.search_gender = '';
        setTimeout(function(){
            $('#search_field').val(null).trigger('change');
        });
        $("#showBottom").click();
        $('#search_job_title .input').attr('placeholder', 'Search by Title').css('width', '100%');
        $('#search_city .input').attr('placeholder', 'Search by Location').css('width', '100%');

        $scope.searchData();
    }

    $scope.main_search_function = function(){
        if(($scope.search_job_title == undefined || $scope.search_job_title.length < 1) && ($scope.search_field == undefined || $scope.search_field == '') && ($scope.search_city == undefined || $scope.search_city.length < 1))
        {
            return false;
        }
        else
        {
            var search_job_title = JSON.stringify($scope.search_job_title);
            var search_city = JSON.stringify($scope.search_city);
            $scope.search_field = $scope.search_field;
            
            $("#showBottom").click();
            $("#search-loader").show();
            $("#search-loader").show();
            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'searchelastic/search',
                data: 'searchKeyword=' + searchKeyword+'&search_job_title='+search_job_title+'&search_field='+$scope.search_field+'&search_city='+search_city,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#search-loader").hide();
                $("#search-loader").hide();
                $(".post_loader").hide();
                $scope.searchProfileData = success.data.profile;
                $scope.postData = success.data.opp_post;
                if(success.data.sim_post.length > 0)
                {
                    $scope.postData.push(success.data.sim_post[0]);
                }
                if(success.data.question_post.length > 0)
                {
                    $scope.postData.push(success.data.question_post[0]);
                }
                if(success.data.article_post.length > 0)
                {
                    $scope.postData.push(success.data.article_post[0]);
                }

                $scope.business_data = success.data.business_data;
                
                $scope.$parent.opp_count = '('+success.data.opp_count+')';
                $scope.$parent.people_count = '('+success.data.people_count+')';
                $scope.$parent.simple_count = '('+success.data.simple_count+')';
                $scope.$parent.business_count = '('+success.data.business_count+')';
                $scope.$parent.article_count = '('+success.data.article_count+')';
                $scope.$parent.question_count = '('+success.data.question_count+')';
                $scope.$parent.total_count = '('+parseInt(success.data.opp_count+success.data.people_count+success.data.simple_count+success.data.business_count+success.data.article_count+success.data.question_count)+')';
                
                $('#main_loader').hide();            
                $('body').removeClass("body-loader");
                setTimeout(function() {
                    $('.comment-dis-inner a').attr('target', '_self');
                    $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
                }, 300);
            });
        }
    };

    $scope.follow_user = function(id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/follow_user',
            data: 'to_id=' + id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $("#" + id).html($compile(success.data)($scope));
        });
    };

    $scope.unfollow_user = function(id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/unfollow_user',
            data: 'to_id=' + id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $("#" + id).html($compile(success.data)($scope));
        });
    };

    $scope.followSearch = function(user_id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/addfollow',
            data: 'to_id=' + user_id + '&status=1',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            if (success.data == 1) {
                $('#search-profile-follow-' + user_id).html('Following');
            }
        });
    };
    /*$scope.post_like = function(post_id,parent_index) {
        likeService.post_like(post_id,parent_index).then(function(success) {
            $scope.postData[parent_index].user_like_list = success;
        });
    };*/

    $scope.removeViewMore = function(mainId, removeViewMore) {
        $("#" + mainId).removeClass("view-more-expand");
        $("#" + removeViewMore).remove();
    };
    $scope.post_like = function(post_id,parent_index,user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
                    if (success.data.likePost_count < 1) {
                        $('#post-like-count-' + post_id).hide();
                    } else {
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
        });
    };
    $scope.cmt_handle_paste_edit = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        value = value.substring(0, cmt_maxlength);
        document.execCommand('inserttext', false, value);
    };
    $scope.check_comment_char_count_edit = function(cmt_id, e) {
        var comment = $('#editCommentTaxBox-' + cmt_id).text();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8, 17, 35, 36, 37, 38, 39, 40, 46];
        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if (no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength) {
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    };
    $scope.sendComment = function(post_id, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $("#cmt-btn-mob-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-mob-" + post_id).attr("disabled", "disabled");
            $("#cmt-btn-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-" + post_id).attr("disabled", "disabled");
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[index].post_data.user_id);
                    }
                    if (commentClassName == 'last-comment') {
                        $scope.postData[index].post_comment_data.splice(0, 1);
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function() {
                    $("#cmt-btn-mob-" + post_id).removeAttr("style");
                    $("#cmt-btn-mob-" + post_id).removeAttr("disabled");
                    $("#cmt-btn-" + post_id).removeAttr("style");
                    $("#cmt-btn-" + post_id).removeAttr("disabled");
                }, 1000);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };
    $scope.viewAllComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.all_comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                $('.comment-dis-inner a').attr('target', '_self');
            },500);
        });
    };
    $scope.viewLastComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                $('.comment-dis-inner a').attr('target', '_self');
            },500);
        });
    };
    $scope.deletePostComment = function(comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $('#delete_model').modal('show');
    };
    $scope.deleteComment = function(comment_id, post_id, parent_index, index, post) {
        parent_index = 0;
        $(".del_comment").attr("style", "pointer-events:none");
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            setTimeout(function() {
                $(".del_comment").removeAttr("style");
            }, 1000);
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.editable_text').html('');
            } else {
                $scope.postData[parent_index].post_comment_data.splice(index, 1);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
            if (data.comment_count <= 0) {
                setTimeout(function() {
                    $(".comment-for-post-" + post_id + " .post-comment").remove();
                }, 100);
                $(".new-comment-" + post_id).show();
            }
        });
    };
    $scope.likePostComment = function(comment_id, post_id, comment_user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                if(socket)
                {
                    socket.emit('user notification',comment_user_id);
                }
                if (data.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }
            }
        });
    };
    $scope.editPostComment = function(comment_id, post_id, parent_index, index) {
        $(".comment-for-post-" + post_id + " .edit-comment").hide();
        $(".comment-for-post-" + post_id + " .comment-dis-inner").show();
        $(".comment-for-post-" + post_id + " li[id^=edit-comment-li-]").show();
        $(".comment-for-post-" + post_id + " li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
        $('#edit-comment-' + comment_id).show();
        editContent = editContent.substring(0, cmt_maxlength);
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-" + post_id).hide();
    };
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
    $scope.comment_reply = function(post_index,comment_id,login_user_id,comment_user_id,cmt_reply_obj)
    {
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
    $scope.cancelPostComment = function(comment_id, post_id, parent_index, index) {
        $('#edit-comment-' + comment_id).hide();
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-" + post_id).show();
    };
    $scope.EditPost = function(post_id, post_for, index) {
        $scope.is_edit = 1;
        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
    };
    $scope.sendEditComment = function(comment_id, post_id, user_id) {
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
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
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
                    $('.new-comment-' + post_id).show();
                }
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };
    $scope.sendCommentReply = function (comment_id,post_id,postIndex,commentIndex) {
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
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }
    $scope.deletePost = function(post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;
        $('#delete_post_model').modal('show');
    };
    $scope.deletedPost = function(post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                $scope.postData.splice(index, 1);
            }
        });
    };
    $scope.like_user_list = function(post_id) {
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            $('#likeusermodal').modal('show');
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
                $("#report-spam").modal('hide');
            });
        }
    };

    $scope.openModal2 = function(myModal2Id) {
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

    $scope.save_post = function(post_id,index,postData){
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
        });
    };

    $scope.share_post_data = [];
    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];
        $scope.post_index = index;
        $("#post-share").modal("show");
        setTimeout(function(){
            $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
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
        });
    };

    $scope.handlePaste = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
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
app.controller('opportunityController', function($scope, $http, $compile, $window,$location) {
    $scope.$parent.active_tab = '2';    
    $scope.user_id = user_id;
    $scope.$parent.meta_title = '"'+keyword +'" - Opportunities | Aileensoul Search';
    $scope.live_slug = live_slug;    

    $scope.search_job_title = [];
    $scope.search_field = '';
    $scope.search_city = [];
    $scope.search_hashtag = [];
    $scope.search_company = [];
    $scope.search_gender = '';

    $scope.pro = {};
    $scope.pst = {};
    var isProcessing = false;
    var isProcessingPst = false;
    $("#search").val(keyword);
    $("#mob_search").val(keyword);
    var pagenum = 0;
    $scope.perpage_record = 10;
    $scope.postData = [];

    $(document).on('keydown','#search_job_title .input',function () {
        if($('#search_job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_job_title .input',function () {
        if($('#search_job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_job_title .input',function () {
        if($('#search_job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_job_title ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Title');
            $(this).css('width', '100%');
        }         
    });

    $(document).on('keydown','#search_city .input',function () {
        if($('#search_city ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_city .input',function () {
        if($('#search_city ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_city .input',function () {
        if($('#search_city ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_city ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Location');
            $(this).css('width', '100%');
        }         
    });

    $(document).on('keydown','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_hashtag ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Hash Tags');
            $(this).css('width', '100%');
        }         
    });

    $(document).on('keydown','#search_company .input',function () {
        if($('#search_company ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_company .input',function () {
        if($('#search_company ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_company .input',function () {
        if($('#search_company ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_company ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Company');
            $(this).css('width', '100%');
        }         
    });

    $scope.searchData = function(pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $("#post-loader").show();
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
            url: base_url + 'searchelastic/search_opportunity_data',
            data: 'searchKeyword=' + searchKeyword + "&page=" + pagenum+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $("#post-loader").hide();

            $scope.page_number = success.data.page;
            if(success.data.opp_post.length > 0)
            {
                isProcessing = false;
                if (pagenum != 0 && $scope.postData != undefined) {
                    for (var i in success.data.opp_post) {                        
                        $scope.postData.push(success.data.opp_post[i]);                    
                    }
                }
                else{
                    $scope.$parent.opp_count = '('+success.data.opp_count+')';
                    $scope.total_record = success.data.opp_count;
                    $scope.postData = success.data.opp_post;
                }
            }
            else
            {
                isProcessing = true;
            }

            $('#main_loader').hide();
            $('body').removeClass("body-loader");
            
            setTimeout(function() {
                $('.comment-dis-inner a').attr('target', '_self');
                $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
            }, 300);
        });
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
        $("#showBottom").click();

        $('#search_job_title .input').attr('placeholder', 'Search by Title').css('width', '100%');
        $('#search_city .input').attr('placeholder', 'Search by Location').css('width', '100%');
        $('#search_hashtag .input').attr('placeholder', 'Search by Hash Tags').css('width', '100%');
        $('#search_company .input').attr('placeholder', 'Search by Company').css('width', '100%');

        pagenum = 0;
        isProcessing = false;
        $scope.searchData(pagenum);
        // $scope.get_search_total_count();
    }

    if($scope.$parent.contactSuggetion.length == 0)
    {
        $scope.$parent.getContactSuggetion();
    }

    $scope.get_search_total_count = function() {
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

        // $http.get(base_url + "searchelastic/search_total_count?searchKeyword="+searchKeyword+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city)
        $http({
            method: 'POST',
            // url: base_url + 'user_post/searchData',
            url: base_url + "searchelastic/search_total_count",
            data: 'searchKeyword=' + searchKeyword +'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.$parent.opp_count = '('+success.data.opp_count+')';
            $scope.$parent.people_count = '('+success.data.people_count+')';
            $scope.$parent.simple_count = '('+success.data.simple_count+')';
            $scope.$parent.business_count = '('+success.data.business_count+')';
            $scope.$parent.article_count = '('+success.data.article_count+')';
            $scope.$parent.question_count = '('+success.data.question_count+')';
            $scope.$parent.total_count = '('+parseInt(success.data.opp_count+success.data.people_count+success.data.simple_count+success.data.business_count+success.data.article_count+success.data.question_count)+')';
            $scope.total_record = success.data.opp_count;
        
            /*$("#search-all-tab").html('All '+$scope.total_count);
            $("#search-opp-tab").html('Opportunitis '+$scope.opp_count);
            $("#search-people-tab").html('People '+$scope.people_count);
            $("#search-post-tab").html('Post '+$scope.simple_count);
            $("#search-bus-tab").html('Business '+$scope.business_count);
            $("#search-article-tab").html('Article '+$scope.article_count);
            $("#search-que-tab").html('Question '+$scope.question_count);*/
        }, function(error) {});
    };

    $scope.searchData(pagenum);
    $scope.get_search_total_count();

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
            $scope.search_field = $scope.search_field;
            var search_field = $scope.search_field;
            $("#showBottom").click();
            $("#post-loader").show();
            $("#search-loader").show();
            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'searchelastic/search_opportunity_data',
                data: 'searchKeyword=' + searchKeyword + "&page=" + pagenum+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city+'&search_hashtag='+search_hashtag+'&search_company='+search_company,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#post-loader").hide();
                $("#search-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.postData = success.data.opp_post;
                
                $scope.$parent.opp_count = '('+success.data.opp_count+')';
                $scope.total_record = success.data.opp_count;

                $('#main_loader').hide();
                $('body').removeClass("body-loader");
                
                setTimeout(function() {
                    $('.comment-dis-inner a').attr('target', '_self');
                    $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
                }, 300);
            });
        }
    };

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height()) && $location.path() == '/search/opportunity') {
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
                    $scope.searchData(pagenum);
                }
            }
        }
    });

    $scope.removeViewMore = function(mainId, removeViewMore) {
        $("#" + mainId).removeClass("view-more-expand");
        $("#" + removeViewMore).remove();
    };
    $scope.post_like = function(post_id,parent_index, user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
                    if (success.data.likePost_count < 1) {
                        $('#post-like-count-' + post_id).hide();
                    } else {
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
        });
    };
    $scope.cmt_handle_paste_edit = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        value = value.substring(0, cmt_maxlength);
        document.execCommand('inserttext', false, value);
    };
    $scope.check_comment_char_count_edit = function(cmt_id, e) {
        var comment = $('#editCommentTaxBox-' + cmt_id).text();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8, 17, 35, 36, 37, 38, 39, 40, 46];
        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if (no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength) {
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    };
    $scope.sendComment = function(post_id, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $("#cmt-btn-mob-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-mob-" + post_id).attr("disabled", "disabled");
            $("#cmt-btn-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-" + post_id).attr("disabled", "disabled");
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[index].post_data.user_id);
                    }
                    if (commentClassName == 'last-comment') {
                        $scope.postData[index].post_comment_data.splice(0, 1);
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function() {
                    $("#cmt-btn-mob-" + post_id).removeAttr("style");
                    $("#cmt-btn-mob-" + post_id).removeAttr("disabled");
                    $("#cmt-btn-" + post_id).removeAttr("style");
                    $("#cmt-btn-" + post_id).removeAttr("disabled");
                }, 1000);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };
    $scope.viewAllComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.all_comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                $('.comment-dis-inner a').attr('target', '_self');
            },500);
        });
    };
    $scope.viewLastComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                $('.comment-dis-inner a').attr('target', '_self');
            },500);
        });
    };
    $scope.deletePostComment = function(comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $('#delete_model').modal('show');
    };
    $scope.deleteComment = function(comment_id, post_id, parent_index, index, post) {
        parent_index = 0;
        $(".del_comment").attr("style", "pointer-events:none");
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            setTimeout(function() {
                $(".del_comment").removeAttr("style");
            }, 1000);
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.editable_text').html('');
            } else {
                $scope.postData[parent_index].post_comment_data.splice(index, 1);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
            if (data.comment_count <= 0) {
                setTimeout(function() {
                    $(".comment-for-post-" + post_id + " .post-comment").remove();
                }, 100);
                $(".new-comment-" + post_id).show();
            }
        });
    };
    $scope.likePostComment = function(comment_id, post_id, comment_user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                if(socket)
                {
                    socket.emit('user notification',comment_user_id);
                }
                if (data.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }
            }
        });
    };
    $scope.editPostComment = function(comment_id, post_id, parent_index, index) {
        $(".comment-for-post-" + post_id + " .edit-comment").hide();
        $(".comment-for-post-" + post_id + " .comment-dis-inner").show();
        $(".comment-for-post-" + post_id + " li[id^=edit-comment-li-]").show();
        $(".comment-for-post-" + post_id + " li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
        $('#edit-comment-' + comment_id).show();
        editContent = editContent.substring(0, cmt_maxlength);
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-" + post_id).hide();
    };
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
    $scope.comment_reply = function(post_index,comment_id,login_user_id,comment_user_id,cmt_reply_obj)
    {
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
    $scope.cancelPostComment = function(comment_id, post_id, parent_index, index) {
        $('#edit-comment-' + comment_id).hide();
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-" + post_id).show();
    };
    $scope.EditPost = function(post_id, post_for, index) {
        $scope.is_edit = 1;
        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
    };
    $scope.sendEditComment = function(comment_id, post_id, user_id) {
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
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                if (data.message == '1') {
                    $('#comment-dis-inner-' + comment_id).show();
                    $('#comment-dis-inner-' + comment_id).html(comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-' + post_id).show();
                }
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };
    $scope.sendCommentReply = function (comment_id,post_id,postIndex,commentIndex) {
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
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }
    $scope.deletePost = function(post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;
        $('#delete_post_model').modal('show');
    };
    $scope.deletedPost = function(post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                $scope.postData.splice(index, 1);
            }
        });
    };
    $scope.like_user_list = function(post_id) {
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            $('#likeusermodal').modal('show');
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
                $("#report-spam").modal('hide');
            });
        }
    };

    $scope.openModal2 = function(myModal2Id) {
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

    $scope.save_post = function(post_id,index,postData){
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
        });
    };

    $scope.share_post_data = [];
    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];
        $scope.post_index = index;
        $("#post-share").modal("show");
        setTimeout(function(){
            $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
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
        });
    };

    $scope.handlePaste = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
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
});
app.controller('peopleController', function($scope, $http, $compile, $window, $location) {
    $scope.$parent.active_tab = '3';
    $scope.$parent.meta_title = '"'+keyword +'" - People | Aileensoul Search';
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;
    
    $scope.search_job_title = [];
    $scope.search_field = '';
    $scope.search_city = [];
    $scope.search_hashtag = [];
    $scope.search_company = [];
    $scope.search_gender = '';

    var isProcessing = false;
    var isProcessingPst = false;
    $("#search").val(keyword);
    $("#mob_search").val(keyword);

    var pagenum = 0
    $scope.perpage_record = 10;
    $scope.searchProfileData = [];

    $(document).on('keydown','#search_job_title .input',function () {
        if($('#search_job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_job_title .input',function () {
        if($('#search_job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_job_title .input',function () {
        if($('#search_job_title ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_job_title ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Title');
            $(this).css('width', '100%');
        }         
    });

    $(document).on('keydown','#search_city .input',function () {
        if($('#search_city ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_city .input',function () {
        if($('#search_city ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_city .input',function () {
        if($('#search_city ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_city ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Location');
            $(this).css('width', '100%');
        }         
    });

    $scope.searchData = function(pagenum) {
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
            // url: base_url + 'user_post/searchData',
            url: base_url + 'searchelastic/search_people_data',
            data: 'searchKeyword=' + searchKeyword+'&page='+pagenum+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city+'&search_gender='+$scope.search_gender,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $("#people-loader").hide();

            $scope.page_number = success.data.page;
            if(success.data.profile.length > 0)
            {
                isProcessing = false;
                if (pagenum != 0 && $scope.searchProfileData != undefined) {                    
                    for (var i in success.data.profile) {
                        $scope.searchProfileData.push(success.data.profile[i]);                        
                    }
                }
                else{                    
                    $scope.searchProfileData = success.data.profile;
                    $scope.$parent.people_count = '('+success.data.people_count+')';
                    $scope.total_record = success.data.people_count;
                }
            }
            else
            {
                isProcessing = true;
            }
            
            $('#main_loader').hide();            
            $('body').removeClass("body-loader");            
        });
    };

    $scope.main_search_function = function(){
        if(($scope.search_job_title == undefined || $scope.search_job_title.length < 1) && ($scope.search_field == undefined || $scope.search_field == '') && ($scope.search_city == undefined || $scope.search_city.length < 1) && ($scope.search_gender == undefined || $scope.search_gender == ''))
        {
            return false;
        }
        else
        {            
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

            $("#showBottom").click();

            $("#people-loader").show();
            $("#search-loader").show();

            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'searchelastic/search_people_data',
                data: 'searchKeyword=' + searchKeyword + "&page=" + pagenum+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city+'&search_gender='+$scope.search_gender,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#people-loader").hide();
                $("#search-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.searchProfileData = success.data.profile;
                
                $scope.$parent.people_count = '('+success.data.people_count+')';
                $scope.total_record = success.data.people_count;

                $('#main_loader').hide();
                $('body').removeClass("body-loader");                
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

        $("#showBottom").click();

        $('#search_job_title .input').attr('placeholder', 'Search by Title').css('width', '100%');
        $('#search_city .input').attr('placeholder', 'Search by Location').css('width', '100%');

        pagenum = 0;
        isProcessing = false;
        $scope.searchData(pagenum);
        // $scope.get_search_total_count();
    }

    if($scope.$parent.contactSuggetion.length == 0)
    {
        $scope.$parent.getContactSuggetion();
    }

    $scope.get_search_total_count = function() {
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

        // $http.get(base_url + "searchelastic/search_total_count?searchKeyword="+searchKeyword)
        $http({
            method: 'POST',
            // url: base_url + 'user_post/searchData',
            url: base_url + "searchelastic/search_total_count",
            data: 'searchKeyword=' + searchKeyword +'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.$parent.opp_count = '('+success.data.opp_count+')';
            $scope.$parent.people_count = '('+success.data.people_count+')';
            $scope.$parent.simple_count = '('+success.data.simple_count+')';
            $scope.$parent.business_count = '('+success.data.business_count+')';
            $scope.$parent.article_count = '('+success.data.article_count+')';
            $scope.$parent.question_count = '('+success.data.question_count+')';
            $scope.$parent.total_count = '('+parseInt(success.data.opp_count+success.data.people_count+success.data.simple_count+success.data.business_count+success.data.article_count+success.data.question_count)+')';

            $scope.total_record = success.data.people_count;

        }, function(error) {});
    };

    $scope.searchData(pagenum);
    $scope.get_search_total_count();

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height()) && $location.path() == '/search/people') {
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
                    $scope.searchData(pagenum);
                }
            }
        }
    });

    $scope.follow_user = function(id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/follow_user',
            data: 'to_id=' + id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $("#" + id).html($compile(success.data)($scope));
        });
    };

    $scope.unfollow_user = function(id) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/unfollow_user',
            data: 'to_id=' + id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $("#" + id).html($compile(success.data)($scope));
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
app.controller('postController', function($scope, $http, $compile, $window, $location) {
    $scope.$parent.active_tab = '4';
    $scope.$parent.meta_title = '"'+keyword +'" - Posts | Aileensoul Search';
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;
    $scope.pro = {};
    $scope.pst = {};

    $scope.search_job_title = [];
    $scope.search_field = '';
    $scope.search_city = [];
    $scope.search_hashtag = [];
    $scope.search_company = [];
    $scope.search_gender = '';

    var isProcessing = false;
    var isProcessingPst = false;
    $("#search").val(keyword);
    $("#mob_search").val(keyword);

    var pagenum = 0
    $scope.perpage_record = 10;
    $scope.postData = [];

    $(document).on('keydown','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_hashtag ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Hash Tags');
            $(this).css('width', '100%');
        }         
    });
    
    $scope.searchData = function(pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $("#post-loader").show();
        var search_hashtag = JSON.stringify($scope.search_hashtag);
        $http({
            method: 'POST',
            // url: base_url + 'user_post/searchData',
            url: base_url + 'searchelastic/search_post_data',
            data: 'searchKeyword=' + searchKeyword + '&page='+pagenum+'&search_hashtag='+search_hashtag,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
                    $scope.$parent.simple_count = '('+success.data.simple_count+')';
                    $scope.total_record = success.data.simple_count;
                }
            }
            else
            {
                isProcessing = true;
            }
            
            $('#main_loader').hide();
            $('body').removeClass("body-loader");
            
            setTimeout(function() {
                $('.comment-dis-inner a').attr('target', '_self');
                $('video,audio').mediaelementplayer( /* Options */ );
            }, 300);
        });
    };

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
            $("#showBottom").click();
            $("#post-loader").show();
            $("#search-loader").show();
            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'searchelastic/search_post_data',
                data: 'searchKeyword=' + searchKeyword + "&page=" + pagenum+'&search_hashtag='+search_hashtag,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#post-loader").hide();
                $("#search-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.postData = success.data.sim_post;
                
                $scope.$parent.simple_count = '('+success.data.simple_count+')';
                $scope.total_record = success.data.simple_count;

                $('#main_loader').hide();
                $('body').removeClass("body-loader");
                
                setTimeout(function() {
                    $('.comment-dis-inner a').attr('target', '_self');
                    $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
                }, 300);
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

        $("#showBottom").click();

        $('#search_hashtag .input').attr('placeholder', 'Search by Hash Tags').css('width', '100%');

        pagenum = 0;
        isProcessing = false;
        $scope.searchData(pagenum);
    }

    if($scope.$parent.contactSuggetion.length == 0)
    {
        $scope.$parent.getContactSuggetion();
    }

    $scope.get_search_total_count = function() {
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

        // $http.get(base_url + "searchelastic/search_total_count?searchKeyword="+searchKeyword+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city)
        $http({
            method: 'POST',
            // url: base_url + 'user_post/searchData',
            url: base_url + "searchelastic/search_total_count",
            data: 'searchKeyword=' + searchKeyword +'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.$parent.opp_count = '('+success.data.opp_count+')';
            $scope.$parent.people_count = '('+success.data.people_count+')';
            $scope.$parent.simple_count = '('+success.data.simple_count+')';
            $scope.$parent.business_count = '('+success.data.business_count+')';
            $scope.$parent.article_count = '('+success.data.article_count+')';
            $scope.$parent.question_count = '('+success.data.question_count+')';
            $scope.$parent.total_count = '('+parseInt(success.data.opp_count+success.data.people_count+success.data.simple_count+success.data.business_count+success.data.article_count+success.data.question_count)+')';
            
            $scope.total_record = success.data.simple_count;

        }, function(error) {});
    };

    $scope.searchData(pagenum);
    $scope.get_search_total_count();

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height()) && $location.path() == '/search/post') {
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
                    var pagenum = parseInt($scope.page_number) + 1;
                    $scope.searchData(pagenum);
                }
            }
        }
    });

    $scope.removeViewMore = function(mainId, removeViewMore) {
        $("#" + mainId).removeClass("view-more-expand");
        $("#" + removeViewMore).remove();
    };
    $scope.post_like = function(post_id,parent_index,user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
                    if (success.data.likePost_count < 1) {
                        $('#post-like-count-' + post_id).hide();
                    } else {
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
        });
    };
    $scope.cmt_handle_paste_edit = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        value = value.substring(0, cmt_maxlength);
        document.execCommand('inserttext', false, value);
    };
    $scope.check_comment_char_count_edit = function(cmt_id, e) {
        var comment = $('#editCommentTaxBox-' + cmt_id).text();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8, 17, 35, 36, 37, 38, 39, 40, 46];
        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if (no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength) {
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    };
    $scope.sendComment = function(post_id, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $("#cmt-btn-mob-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-mob-" + post_id).attr("disabled", "disabled");
            $("#cmt-btn-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-" + post_id).attr("disabled", "disabled");
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[index].post_data.user_id);
                    }
                    if (commentClassName == 'last-comment') {
                        $scope.postData[index].post_comment_data.splice(0, 1);
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function() {
                    $("#cmt-btn-mob-" + post_id).removeAttr("style");
                    $("#cmt-btn-mob-" + post_id).removeAttr("disabled");
                    $("#cmt-btn-" + post_id).removeAttr("style");
                    $("#cmt-btn-" + post_id).removeAttr("disabled");
                }, 1000);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };
    $scope.viewAllComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.all_comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                $('.comment-dis-inner a').attr('target', '_self');
            },500);
        });
    };
    $scope.viewLastComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                $('.comment-dis-inner a').attr('target', '_self');
            },500);
        });
    };
    $scope.deletePostComment = function(comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $('#delete_model').modal('show');
    };
    $scope.deleteComment = function(comment_id, post_id, parent_index, index, post) {
        parent_index = 0;
        $(".del_comment").attr("style", "pointer-events:none");
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            setTimeout(function() {
                $(".del_comment").removeAttr("style");
            }, 1000);
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.editable_text').html('');
            } else {
                $scope.postData[parent_index].post_comment_data.splice(index, 1);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
            if (data.comment_count <= 0) {
                setTimeout(function() {
                    $(".comment-for-post-" + post_id + " .post-comment").remove();
                }, 100);
                $(".new-comment-" + post_id).show();
            }
        });
    };
    $scope.likePostComment = function(comment_id, post_id, comment_user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                if(socket)
                {
                    socket.emit('user notification',comment_user_id);
                }
                if (data.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }
            }
        });
    };
    $scope.editPostComment = function(comment_id, post_id, parent_index, index) {
        $(".comment-for-post-" + post_id + " .edit-comment").hide();
        $(".comment-for-post-" + post_id + " .comment-dis-inner").show();
        $(".comment-for-post-" + post_id + " li[id^=edit-comment-li-]").show();
        $(".comment-for-post-" + post_id + " li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
        $('#edit-comment-' + comment_id).show();
        editContent = editContent.substring(0, cmt_maxlength);
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-" + post_id).hide();
    };
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
    $scope.comment_reply = function(post_index,comment_id,login_user_id,comment_user_id,cmt_reply_obj)
    {
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
    $scope.cancelPostComment = function(comment_id, post_id, parent_index, index) {
        $('#edit-comment-' + comment_id).hide();
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-" + post_id).show();
    };
    $scope.EditPost = function(post_id, post_for, index) {
        $scope.is_edit = 1;
        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
    };
    $scope.sendEditComment = function(comment_id, post_id, user_id) {
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
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                if (data.message == '1') {
                    $('#comment-dis-inner-' + comment_id).show();
                    $('#comment-dis-inner-' + comment_id).html(comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-' + post_id).show();
                }
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };
    $scope.sendCommentReply = function (comment_id,post_id,postIndex,commentIndex) {
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
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }
    $scope.deletePost = function(post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;
        $('#delete_post_model').modal('show');
    };
    $scope.deletedPost = function(post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                $scope.postData.splice(index, 1);
            }
        });
    };
    $scope.like_user_list = function(post_id) {
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            $('#likeusermodal').modal('show');
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
                $("#report-spam").modal('hide');
            });
        }
    };

    $scope.openModal2 = function(myModal2Id) {
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

    $scope.save_post = function(post_id,index,postData){
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
        });
    };

    $scope.share_post_data = [];
    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];
        $scope.post_index = index;
        $("#post-share").modal("show");
        setTimeout(function(){
            $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
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
        });
    };

    $scope.handlePaste = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
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
});
app.controller('businessController', function($scope, $http, $compile, $window, $location) {
    $scope.$parent.active_tab = '5';
    $scope.$parent.meta_title = '"'+keyword +'" - Businesses | Aileensoul Search';
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;
    $scope.pro = {};
    $scope.pst = {};

    $scope.search_job_title = [];
    $scope.search_field = '';
    $scope.search_city = [];
    $scope.search_hashtag = [];
    $scope.search_company = [];
    $scope.search_gender = '';

    var isProcessing = false;
    var isProcessingPst = false;
    $("#search").val(keyword);
    $("#mob_search").val(keyword);

    var pagenum = 0
    $scope.perpage_record = 10;
    
    $scope.searchData = function(pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;
        $("#business-loader").show();
        $http({
            method: 'POST',
            // url: base_url + 'user_post/searchData',
            url: base_url + 'searchelastic/search_business_data',
            data: 'searchKeyword=' + searchKeyword + '&page='+pagenum,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
                    $scope.$parent.business_count = '('+success.data.business_count+')';
                    $scope.total_record = success.data.business_count;
                }
            }
            else{
                isProcessing = true;
            }

            $('#main_loader').hide();
            $('body').removeClass("body-loader");
        });
    };

    $scope.get_search_total_count = function() {
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

        // $http.get(base_url + "searchelastic/search_total_count?searchKeyword="+searchKeyword+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city)
        $http({
            method: 'POST',
            // url: base_url + 'user_post/searchData',
            url: base_url + "searchelastic/search_total_count",
            data: 'searchKeyword=' + searchKeyword +'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.$parent.opp_count = '('+success.data.opp_count+')';
            $scope.$parent.people_count = '('+success.data.people_count+')';
            $scope.$parent.simple_count = '('+success.data.simple_count+')';
            $scope.$parent.business_count = '('+success.data.business_count+')';
            $scope.$parent.article_count = '('+success.data.article_count+')';
            $scope.$parent.question_count = '('+success.data.question_count+')';
            $scope.$parent.total_count = '('+parseInt(success.data.opp_count+success.data.people_count+success.data.simple_count+success.data.business_count+success.data.article_count+success.data.question_count)+')';

            $scope.total_record = success.data.business_count;

        }, function(error) {});
    };

    if($scope.$parent.contactSuggetion.length == 0)
    {
        $scope.$parent.getContactSuggetion();
    }

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
            $("#business-loader").show();
            $("#search-loader").show();
            $("#showBottom").click();
            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'searchelastic/search_business_data',
                data: formdata+'&searchKeyword=' + searchKeyword + "&page=" + pagenum,//{searchKeyword:searchKeyword,page:pagenum,formdata:formdata},
                // data: 'searchKeyword=' + searchKeyword + "&page=" + pagenum+'&formdata='+formdata,
                headers: {
                    'Content-Type':  'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#business-loader").hide();
                $("#search-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.business_data = success.data.business_data;
                
                $scope.$parent.business_count = '('+success.data.business_count+')';
                $scope.total_record = success.data.business_count;

                $('#main_loader').hide();
                $('body').removeClass("body-loader");
            });
        }
    };

    $scope.main_search_function_mob = function(){
        var formdata = $('#main_search_mob').serialize();
        if(formdata == undefined || formdata.length < 1)
        {
            return false;
        }
        else
        {            
            pagenum = 0;
            isProcessing = false;
            $("#business-loader").show();
            $("#search-loader").show();
            $("#showBottom").click();
            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'searchelastic/search_business_data',
                data: formdata+'&searchKeyword=' + searchKeyword + "&page=" + pagenum,//{searchKeyword:searchKeyword,page:pagenum,formdata:formdata},
                // data: 'searchKeyword=' + searchKeyword + "&page=" + pagenum+'&formdata='+formdata,
                headers: {
                    'Content-Type':  'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#business-loader").hide();
                $("#search-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.business_data = success.data.business_data;
                
                $scope.$parent.business_count = '('+success.data.business_count+')';
                $scope.total_record = success.data.business_count;

                $('#main_loader').hide();
                $('body').removeClass("body-loader");
            });
        }
    };

    $scope.clearData = function(){
        /*$scope.search_job_title = [];
        $scope.search_field = '';
        $scope.search_city = [];
        $scope.search_hashtag = [];
        $scope.search_company = [];
        $scope.search_gender = '';*/

        pagenum = 0;
        isProcessing = false;
        $("#showBottom").click();
        $('#main_search')[0].reset();
        $('#main_search_mob')[0].reset();
        $scope.searchData(pagenum);
    }

    $scope.searchData();
    $scope.get_search_total_count();

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height()) && $location.path() == '/search/business') {
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
                    $scope.searchData(pagenum);
                }
            }
        }
    });
});
app.controller('articleController', function($scope, $http, $compile, $window, $location) {
    $scope.$parent.active_tab = '6';
    $scope.$parent.meta_title = '"'+keyword +'" - Articles | Aileensoul Search';
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;
    
    $scope.search_job_title = [];
    $scope.search_field = '';
    $scope.search_city = [];
    $scope.search_hashtag = [];
    $scope.search_company = [];
    $scope.search_gender = '';

    var isProcessing = false;
    var isProcessingPst = false;
    $("#search").val(keyword);
    $("#mob_search").val(keyword);

    var pagenum = 0
    $scope.perpage_record = 10;

    $(document).on('keydown','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_hashtag ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Hash Tags');
            $(this).css('width', '100%');
        }         
    });
    
    $scope.searchData = function(pagenum) {
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
            // url: base_url + 'user_post/searchData',
            url: base_url + 'searchelastic/search_article_data',
            data: 'searchKeyword=' + searchKeyword + '&page='+pagenum+'&search_field='+btoa(search_field)+'&search_hashtag='+search_hashtag,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $("#post-loader").hide();
            if(success.data.article_post.length > 0)
            {
                isProcessing = false;
                $scope.page_number = success.data.page;            
                if (pagenum != 0 && $scope.postData != undefined) {
                    for (var i in success.data.article_post) {                        
                        $scope.postData.push(success.data.article_post[i]);                    
                    }
                }
                else{
                    $scope.postData = success.data.article_post;
                    $scope.$parent.article_count = '('+success.data.article_count+')';
                    $scope.total_record = success.data.article_count;
                }
            }
            else
            {
                isProcessing = true;
            }            
            $('#main_loader').hide();
            $('.comment-dis-inner a').attr('target', '_self');
            $('body').removeClass("body-loader");
        });
    };

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
            $scope.search_field = $scope.search_field;
            var search_field = $scope.search_field;
            $("#showBottom").click();
            $("#post-loader").show();
            $("#search-loader").show();
            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'searchelastic/search_article_data',
                // data: {searchKeyword:searchKeyword,page:pagenum,search_field:btoa(search_field),search_hashtag:search_hashtag},
                data: 'searchKeyword=' + searchKeyword + "&page=" + pagenum+'&search_field='+btoa(search_field)+'&search_hashtag='+search_hashtag,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#post-loader").hide();
                $("#search-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.postData = success.data.article_post;
                
                $scope.$parent.article_count = '('+success.data.article_count+')';
                $scope.total_record = success.data.article_count;

                $('#main_loader').hide();
                $('.comment-dis-inner a').attr('target', '_self');
                $('body').removeClass("body-loader");
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

        $("#showBottom").click();

        $('#search_hashtag .input').attr('placeholder', 'Search by Hash Tags').css('width', '100%');

        pagenum = 0;
        isProcessing = false;
        $scope.searchData(pagenum);
    }

    if($scope.$parent.contactSuggetion.length == 0)
    {
        $scope.$parent.getContactSuggetion();
    }

    $scope.get_search_total_count = function() {
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

        // $http.get(base_url + "searchelastic/search_total_count?searchKeyword="+searchKeyword+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city)
        $http({
            method: 'POST',
            // url: base_url + 'user_post/searchData',
            url: base_url + "searchelastic/search_total_count",
            data: 'searchKeyword=' + searchKeyword +'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.$parent.opp_count = '('+success.data.opp_count+')';
            $scope.$parent.people_count = '('+success.data.people_count+')';
            $scope.$parent.simple_count = '('+success.data.simple_count+')';
            $scope.$parent.business_count = '('+success.data.business_count+')';
            $scope.$parent.article_count = '('+success.data.article_count+')';
            $scope.$parent.question_count = '('+success.data.question_count+')';
            $scope.$parent.total_count = '('+parseInt(success.data.opp_count+success.data.people_count+success.data.simple_count+success.data.business_count+success.data.article_count+success.data.question_count)+')';

            $scope.total_record = success.data.article_count;

        }, function(error) {});
    };

    $scope.searchData(pagenum);
    $scope.get_search_total_count();

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height()) && $location.path() == '/search/article') {
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
                    $scope.searchData(pagenum);
                }
            }
        }
    });

    $scope.removeViewMore = function(mainId, removeViewMore) {
        $("#" + mainId).removeClass("view-more-expand");
        $("#" + removeViewMore).remove();
    };
    $scope.post_like = function(post_id,parent_index,user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
                    if (success.data.likePost_count < 1) {
                        $('#post-like-count-' + post_id).hide();
                    } else {
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
        });
    };
    $scope.cmt_handle_paste_edit = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        value = value.substring(0, cmt_maxlength);
        document.execCommand('inserttext', false, value);
    };
    $scope.check_comment_char_count_edit = function(cmt_id, e) {
        var comment = $('#editCommentTaxBox-' + cmt_id).text();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8, 17, 35, 36, 37, 38, 39, 40, 46];
        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if (no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength) {
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    };
    $scope.sendComment = function(post_id, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $("#cmt-btn-mob-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-mob-" + post_id).attr("disabled", "disabled");
            $("#cmt-btn-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-" + post_id).attr("disabled", "disabled");
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[index].post_data.user_id);
                    }
                    if (commentClassName == 'last-comment') {
                        $scope.postData[index].post_comment_data.splice(0, 1);
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function() {
                    $("#cmt-btn-mob-" + post_id).removeAttr("style");
                    $("#cmt-btn-mob-" + post_id).removeAttr("disabled");
                    $("#cmt-btn-" + post_id).removeAttr("style");
                    $("#cmt-btn-" + post_id).removeAttr("disabled");
                }, 1000);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };
    $scope.viewAllComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.all_comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                $('.comment-dis-inner a').attr('target', '_self');
            },500);
        });
    };
    $scope.viewLastComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                $('.comment-dis-inner a').attr('target', '_self');
            },500);
        });
    };
    $scope.deletePostComment = function(comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $('#delete_model').modal('show');
    };
    $scope.deleteComment = function(comment_id, post_id, parent_index, index, post) {
        parent_index = 0;
        $(".del_comment").attr("style", "pointer-events:none");
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            setTimeout(function() {
                $(".del_comment").removeAttr("style");
            }, 1000);
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.editable_text').html('');
            } else {
                $scope.postData[parent_index].post_comment_data.splice(index, 1);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
            if (data.comment_count <= 0) {
                setTimeout(function() {
                    $(".comment-for-post-" + post_id + " .post-comment").remove();
                }, 100);
                $(".new-comment-" + post_id).show();
            }
        });
    };
    $scope.likePostComment = function(comment_id, post_id, comment_user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                if(socket)
                {
                    socket.emit('user notification',comment_user_id);
                }
                if (data.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }
            }
        });
    };
    $scope.editPostComment = function(comment_id, post_id, parent_index, index) {
        $(".comment-for-post-" + post_id + " .edit-comment").hide();
        $(".comment-for-post-" + post_id + " .comment-dis-inner").show();
        $(".comment-for-post-" + post_id + " li[id^=edit-comment-li-]").show();
        $(".comment-for-post-" + post_id + " li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
        $('#edit-comment-' + comment_id).show();
        editContent = editContent.substring(0, cmt_maxlength);
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-" + post_id).hide();
    };
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
    $scope.comment_reply = function(post_index,comment_id,login_user_id,comment_user_id,cmt_reply_obj)
    {
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
    $scope.cancelPostComment = function(comment_id, post_id, parent_index, index) {
        $('#edit-comment-' + comment_id).hide();
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-" + post_id).show();
    };
    $scope.EditPost = function(post_id, post_for, index) {
        $scope.is_edit = 1;
        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
    };
    $scope.sendEditComment = function(comment_id, post_id, user_id) {
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
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                if (data.message == '1') {
                    $('#comment-dis-inner-' + comment_id).show();
                    $('#comment-dis-inner-' + comment_id).html(comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-' + post_id).show();
                }
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };
    $scope.sendCommentReply = function (comment_id,post_id,postIndex,commentIndex) {
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
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }
    $scope.deletePost = function(post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;
        $('#delete_post_model').modal('show');
    };
    $scope.deletedPost = function(post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                $scope.postData.splice(index, 1);
            }
        });
    };
    $scope.like_user_list = function(post_id) {
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            $('#likeusermodal').modal('show');
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
                $("#report-spam").modal('hide');
            });
        }
    };

    $scope.openModal2 = function(myModal2Id) {
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

    $scope.save_post = function(post_id,index,postData){
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
        });
    };

    $scope.share_post_data = [];
    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];
        $scope.post_index = index;
        $("#post-share").modal("show");
        setTimeout(function(){
            $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
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
        });
    };

    $scope.handlePaste = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
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
});
app.controller('questionController', function($scope, $http, $compile, $window, $location) {
    $scope.$parent.active_tab = '7';
    $scope.$parent.meta_title = '"'+keyword +'" - Questions | Aileensoul Search';
    $scope.user_id = user_id;
    $scope.live_slug = live_slug;
    
    $scope.search_job_title = [];
    $scope.search_field = '';
    $scope.search_city = [];
    $scope.search_hashtag = [];
    $scope.search_company = [];
    $scope.search_gender = '';

    var isProcessing = false;
    var isProcessingPst = false;
    $("#search").val(keyword);
    $("#mob_search").val(keyword);

    var pagenum = 0
    $scope.perpage_record = 10;

    $(document).on('keydown','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '100%');
        }
    });
    $(document).on('focusin','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
    });
    $(document).on('focusout','#search_hashtag .input',function () {
        if($('#search_hashtag ul li').length > 0)
        {            
            $(this).attr('placeholder', '');
            $(this).css('width', '20px');
        }
        if($('#search_hashtag ul li').length == 0)
        {            
            $(this).attr('placeholder', 'Search by Hash Tags');
            $(this).css('width', '100%');
        }         
    });
    
    $scope.searchData = function(pagenum) {
        if (isProcessing) {
            return;
        }
        isProcessing = true;        

        var search_field = '';
        if($scope.search_field != '')
        {
            search_field = $scope.search_field;
        }
        var search_hashtag = JSON.stringify($scope.search_hashtag);
        $http({
            method: 'POST',
            // url: base_url + 'user_post/searchData',
            url: base_url + 'searchelastic/search_question_data',
            data: 'searchKeyword=' + searchKeyword + '&page='+pagenum+'&search_field='+btoa(search_field)+'&search_hashtag='+search_hashtag,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
                    $scope.$parent.question_count = '('+success.data.question_count+')';
                    $scope.total_record = success.data.question_count;
                }            
            }
            else
            {
                isProcessing = true;
            }
            
            $('#main_loader').hide();
            $('body').removeClass("body-loader");
            
            setTimeout(function() {
                $('.comment-dis-inner a').attr('target', '_self');
                $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
            }, 300);
        });
    };

    $scope.main_search_function = function(){
        if(($scope.search_hashtag == undefined || $scope.search_hashtag.length < 1) && ($scope.search_field == undefined || $scope.search_field == ''))
        {
            return false;
        }
        else
        {
            $scope.postData = [];
            pagenum = 0;
            isProcessing = false;
            var search_hashtag = JSON.stringify($scope.search_hashtag);
            $scope.search_field = $scope.search_field;
            var search_field = $scope.search_field;
            $("#showBottom").click();
            $("#post-loader").show();
            $("#search-loader").show();
            $http({
                method: 'POST',
                // url: base_url + 'user_post/searchData',
                url: base_url + 'searchelastic/search_question_data',
                // data: {searchKeyword:searchKeyword,page:pagenum,search_field:btoa(search_field),search_hashtag:search_hashtag},
                data: 'searchKeyword=' + searchKeyword + "&page=" + pagenum+'&search_field='+btoa(search_field)+'&search_hashtag='+search_hashtag,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                $("#post-loader").hide();
                $("#search-loader").hide();

                $scope.page_number = success.data.page;            
                $scope.postData = success.data.question_post;
                
                $scope.$parent.question_count = '('+success.data.question_count+')';
                $scope.total_record = success.data.question_count;

                $('#main_loader').hide();
                $('.comment-dis-inner a').attr('target', '_self');
                $('body').removeClass("body-loader");
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
        $("#showBottom").click();

        $('#search_hashtag .input').attr('placeholder', 'Search by Hash Tags').css('width', '100%');

        pagenum = 0;
        isProcessing = false;
        $scope.searchData(pagenum);
    }

    if($scope.$parent.contactSuggetion.length == 0)
    {
        $scope.$parent.getContactSuggetion();
    }

    $scope.get_search_total_count = function() {
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

        // $http.get(base_url + "searchelastic/search_total_count?searchKeyword="+searchKeyword+'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city)
        $http({
            method: 'POST',
            // url: base_url + 'user_post/searchData',
            url: base_url + "searchelastic/search_total_count",
            data: 'searchKeyword=' + searchKeyword +'&search_job_title='+search_job_title+'&search_field='+search_field+'&search_city='+search_city,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.$parent.opp_count = '('+success.data.opp_count+')';
            $scope.$parent.people_count = '('+success.data.people_count+')';
            $scope.$parent.simple_count = '('+success.data.simple_count+')';
            $scope.$parent.business_count = '('+success.data.business_count+')';
            $scope.$parent.article_count = '('+success.data.article_count+')';
            $scope.$parent.question_count = '('+success.data.question_count+')';
            $scope.$parent.total_count = '('+parseInt(success.data.opp_count+success.data.people_count+success.data.simple_count+success.data.business_count+success.data.article_count+success.data.question_count)+')';
            
            $scope.total_record = success.data.question_count;

        }, function(error) {});
    };

    $scope.searchData();
    $scope.get_search_total_count();

    angular.element($window).bind("scroll", function (e) {
        
        if (($(window).scrollTop()) == ($(document).height() - $(window).height()) &&  $location.path() == '/search/question') {
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
                    $scope.searchData(pagenum);
                }
            }
        }
    });

    $scope.removeViewMore = function(mainId, removeViewMore) {
        $("#" + mainId).removeClass("view-more-expand");
        $("#" + removeViewMore).remove();
    };
    $scope.post_like = function(post_id,parent_index,user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
                    if (success.data.likePost_count < 1) {
                        $('#post-like-count-' + post_id).hide();
                    } else {
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
        });
    };
    $scope.cmt_handle_paste_edit = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        value = value.substring(0, cmt_maxlength);
        document.execCommand('inserttext', false, value);
    };
    $scope.check_comment_char_count_edit = function(cmt_id, e) {
        var comment = $('#editCommentTaxBox-' + cmt_id).text();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        var no_allow_keycode = [8, 17, 35, 36, 37, 38, 39, 40, 46];
        // if(e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 17 && e.keyCode != 46 && comment.length + 1 > 10)
        if (no_allow_keycode.indexOf(e.keyCode) == -1 && comment.length + 1 > cmt_maxlength) {
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    };
    $scope.sendComment = function(post_id, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $("#cmt-btn-mob-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-mob-" + post_id).attr("disabled", "disabled");
            $("#cmt-btn-" + post_id).attr("style", "pointer-events: none;");
            $("#cmt-btn-" + post_id).attr("disabled", "disabled");
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                if (data.message == '1') {
                    if(socket)
                    {
                        socket.emit('user notification',$scope.postData[index].post_data.user_id);
                    }
                    if (commentClassName == 'last-comment') {
                        $scope.postData[index].post_comment_data.splice(0, 1);
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                        if (data.comment_count > 0) {
                            $('.post-comment-count-' + post_id).show();
                        }
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                }
                setTimeout(function() {
                    $("#cmt-btn-mob-" + post_id).removeAttr("style");
                    $("#cmt-btn-mob-" + post_id).removeAttr("disabled");
                    $("#cmt-btn-" + post_id).removeAttr("style");
                    $("#cmt-btn-" + post_id).removeAttr("disabled");
                }, 1000);
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };
    $scope.viewAllComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.all_comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                $('.comment-dis-inner a').attr('target', '_self');
            },500);
        });
    };
    $scope.viewLastComment = function(post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            $scope.postData[index].post_comment_data = data.comment_data;
            $scope.postData[index].post_comment_count = data.post_comment_count;
            setTimeout(function(){
                $('.comment-dis-inner a').attr('target', '_self');
            },500);
        });
    };
    $scope.deletePostComment = function(comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;
        $('#delete_model').modal('show');
    };
    $scope.deleteComment = function(comment_id, post_id, parent_index, index, post) {
        parent_index = 0;
        $(".del_comment").attr("style", "pointer-events:none");
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            setTimeout(function() {
                $(".del_comment").removeAttr("style");
            }, 1000);
            data = success.data;
            if (commentClassName == 'last-comment') {
                $scope.postData[parent_index].post_comment_data.splice(0, 1);
                $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                $('.post-comment-count-' + post_id).html(data.comment_count);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.editable_text').html('');
            } else {
                $scope.postData[parent_index].post_comment_data.splice(index, 1);
                if (data.comment_count < 1) {
                    $('.post-comment-count-' + post_id).hide();
                }
                $('.post-comment-count-' + post_id).html(data.comment_count);
                $('.editable_text').html('');
            }
            if (data.comment_count <= 0) {
                setTimeout(function() {
                    $(".comment-for-post-" + post_id + " .post-comment").remove();
                }, 100);
                $(".new-comment-" + post_id).show();
            }
        });
    };
    $scope.likePostComment = function(comment_id, post_id, comment_user_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                if(socket)
                {
                    socket.emit('user notification',comment_user_id);
                }
                if (data.is_newLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                } else if (data.is_oldLike == 1) {
                    $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                    $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                }
            }
        });
    };
    $scope.editPostComment = function(comment_id, post_id, parent_index, index) {
        $(".comment-for-post-" + post_id + " .edit-comment").hide();
        $(".comment-for-post-" + post_id + " .comment-dis-inner").show();
        $(".comment-for-post-" + post_id + " li[id^=edit-comment-li-]").show();
        $(".comment-for-post-" + post_id + " li[id^=cancel-comment-li-]").hide();
        // var editContent = $('#comment-dis-inner-' + comment_id).html();
        var editContent = $scope.postData[parent_index].post_comment_data[index].comment;
        $('#edit-comment-' + comment_id).show();
        editContent = editContent.substring(0, cmt_maxlength);
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
        $('#edit-comment-li-' + comment_id).hide();
        $('#cancel-comment-li-' + comment_id).show();
        $(".new-comment-" + post_id).hide();
    };
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
    $scope.comment_reply = function(post_index,comment_id,login_user_id,comment_user_id,cmt_reply_obj)
    {
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
    $scope.cancelPostComment = function(comment_id, post_id, parent_index, index) {
        $('#edit-comment-' + comment_id).hide();
        $('#comment-dis-inner-' + comment_id).show();
        $('#edit-comment-li-' + comment_id).show();
        $('#cancel-comment-li-' + comment_id).hide();
        $(".new-comment-" + post_id).show();
    };
    $scope.EditPost = function(post_id, post_for, index) {
        $scope.is_edit = 1;
        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
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
    };
    $scope.sendEditComment = function(comment_id, post_id, user_id) {
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
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(success) {
                data = success.data;
                if (data.message == '1') {
                    $('#comment-dis-inner-' + comment_id).show();
                    $('#comment-dis-inner-' + comment_id).html(comment);
                    $('#edit-comment-' + comment_id).html();
                    $('#edit-comment-' + comment_id).hide();
                    $('#edit-comment-li-' + comment_id).show();
                    $('#cancel-comment-li-' + comment_id).hide();
                    $('.new-comment-' + post_id).show();
                }
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    };
    $scope.sendCommentReply = function (comment_id,post_id,postIndex,commentIndex) {
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
            });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }
    $scope.deletePost = function(post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;
        $('#delete_post_model').modal('show');
    };
    $scope.deletedPost = function(post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            data = success.data;
            if (data.message == '1') {
                $scope.postData.splice(index, 1);
            }
        });
    };
    $scope.like_user_list = function(post_id) {
        $http({
            method: 'POST',
            url: base_url + "user_post/likeuserlist",
            data: 'post_id=' + post_id,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(success) {
            $scope.count_likeUser = success.data.countlike;
            $scope.get_like_user_list = success.data.likeuserlist;
            $('#likeusermodal').modal('show');
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
                $("#report-spam").modal('hide');
            });
        }
    };

    $scope.openModal2 = function(myModal2Id) {
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

    $scope.save_post = function(post_id,index,postData){
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
        });
    };

    $scope.share_post_data = [];
    $scope.share_post = function(post_id,index,postData){
        $scope.share_post_data = $scope.postData[index];
        $scope.post_index = index;
        $("#post-share").modal("show");
        setTimeout(function(){
            $('video,audio').mediaelementplayer({'pauseOtherPlayers': true});
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
        });
    };

    $scope.handlePaste = function(e) {
        e.preventDefault();
        e.stopPropagation();
        var value = e.originalEvent.clipboardData.getData("Text");
        document.execCommand('inserttext', false, value);
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
});
$(window).on("load", function() {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});