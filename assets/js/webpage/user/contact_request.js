var isscroll = true;
app.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});
app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/contact-request", {
                templateUrl: base_url + "userprofile_page/contact_request_people",
                controller: 'contactRequestController'
            })
            .when("/contact-business", {
                templateUrl: base_url + "userprofile_page/business_list",
                controller: 'businessController'
            })
            .when("/hashtags", {
                templateUrl: base_url + "userprofile_page/hashtag_list",
                controller: 'hashtagController'
            })
            .otherwise({
                templateUrl: base_url + "userprofile_page/contact_request_people",
                controller: 'contactRequestController'
            });
    $locationProvider.html5Mode(true);
});
app.controller('mainDefaultController', function($scope, $http, $compile) {
    $scope.active_pg = 0;
});
app.controller('contactRequestController', function ($scope, $http,$window,$location) {
    $scope.$parent.active_pg = 1;
    $scope.today = new Date();
    $scope.$parent.title = "Contact Request | Aileensoul";
    $scope.user_id = user_id;
    
    var offset = "40";
    var processing = false;
    
    $scope.jobs = {};

    var isProcessing = false;
    
    angular.element($window).bind("scroll", function (e) {
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.4) && $location.url().substr(1) == 'contact-request') {
            // isLoadingData = true;
            var page = $scope.jobs.page_number;
            var total_record = $scope.jobs.total_record;
            var perpage_record = $scope.jobs.perpage_record;
    
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.jobs.page_number + 1;
                    getContactSuggetion(pagenum);
                }
            }
        }
    });

    function getContactSuggetion(start) {
        if (isProcessing) {
            return false;
        }
        isProcessing = true;
        $(".sugg_post_load").show();

        // $http.get(base_url + "user_post/getContactAllSuggetion").then(function (success) {
        //     $scope.contactSuggetion = success.data;
        // }, function (error) {});
        $http({
            method: 'POST',
            url: base_url + 'user_post/getContactAllSuggetion?page='+start,            
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        }).then(function (success) {
            $(".sugg_post_load").hide();            
            
            if (success.data.con_sugg_data.length >0 ) {            
                if(start > 1)
                {
                    for (var i in success.data.con_sugg_data) {                            
                        //$scope.searchJob.push(data.latestJobs[i]);
                        //$scope.$apply(function () {
                            $scope.contactSuggetion.push(success.data.con_sugg_data[i]);
                        //});
                    }
                }
                else
                {
                    $scope.contactSuggetion = success.data.con_sugg_data;
                }

                
                isProcessing = false;

                // $scope.contactSuggetion = success.data.con_sugg_data;
                $scope.jobs.page_number = start;
                $scope.jobs.total_record = success.data.total_record;
                $scope.jobs.perpage_record = 40;
            }
            else
            {
                isProcessing = true;
                $scope.showLoadmore = false;
                $scope.contactSuggetion = success.data.con_sugg_data;
                $scope.jobs.page_number = start;
                $scope.jobs.total_record = success.data.total_record;
                $scope.jobs.perpage_record = 40;
            }
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                getContactSuggetion(start);
            },500);
        }, 
        function (complete) {
            $(".sugg_post_load").hide();
        });
    }
    function pending_contact_request() {
        $(".req_post_load").show();
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/pending_contact_request',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            async : true,
            cache : false,
        }).then(function (success) {
            $(".req_post_load").hide();
            $("#contactlist").show();
            pending_contact_request = success.data;
            $scope.pending_contact_request_data = pending_contact_request;            
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                pending_contact_request();
            },500);
        });
    }

    $scope.not_page = 0;
    $scope.not_total_record = 0;
    $scope.not_perpage = 5;
    var is_processing = false;
    $scope.contact_request_notification = [];
    $scope.contactRequestNotification = function(pagenum) {
        if(is_processing)
        {
            return false;
        }
        is_processing = true;
        $("#not-req-loader").show();
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/contactRequestNotification',
            data: 'page='+pagenum,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},            
        }).then(function (success) {            
            if(success.data.request_notification)
            {                
                for (var i in success.data.request_notification) {
                    $scope.contact_request_notification.push(success.data.request_notification[i]);
                }
                $scope.not_page = success.data.page;
                $scope.not_total_record = success.data.total_record;
                is_processing = false;
            }
            $("#not-req-loader").hide();
            // contact_request_notification = success.data;
            // $scope.contact_request_notification = contact_request_notification;
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.contactRequestNotification(pagenum);
            },500);
        });
    };
    
    $('.req-not-scroll').on('scroll', function () {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            var page = $scope.not_page;
            var total_record = $scope.not_total_record;
            var perpage_record = $scope.not_perpage;
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($scope.not_page) + 1;
                    $scope.contactRequestNotification(pagenum);
                }
            }
        }
    });

    $scope.confirmContact = function (from_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=confirm',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data) {
                $scope.pending_contact_request_data.splice(index, 1);
                if(socket)
                {
                    socket.emit('user notification',from_id);
                }
            }
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.confirmContact(from_id, index);
            },500);
        });
    }

    $scope.rejectContact = function (from_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=reject',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data) {
                $scope.pending_contact_request_data.splice(index, 1);
                if(socket)
                {
                    socket.emit('user notification',from_id);
                }
            }
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.rejectContact(from_id, index);
            },500);
        });
    }
    $scope.addToContact = function (user_id, suggest) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/addToContact',
            data: 'user_id=' + user_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                $('#item-' + user_id + ' a.btn3').html('Request Sent');
                if(socket)
                {
                    socket.emit('user notification',user_id);
                }
                //$('.owl-carousel').trigger('next.owl.carousel');
            }
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.addToContact(user_id, suggest);
            },500);
        });
    }

    pending_contact_request();
    getContactSuggetion(1);
    $scope.contactRequestNotification(1);
});
app.controller('businessController', function ($scope, $http,$window,$location) {
    $scope.$parent.active_pg = 2;
    $scope.today = new Date();
    $scope.$parent.title = "Business | Aileensoul";
    $scope.user_id = user_id;
    var offset = "12";
    var processing = false;
    //getContactSuggetion(1);
    var isProcessing = false;
    
    angular.element($window).bind("scroll", function (e) {
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.4) && $location.url().substr(1) == 'contact-business') {
            // isLoadingData = true;
            var page = $scope.page_number;
            var total_record = $scope.total_record;
            var perpage_record = $scope.perpage_record;
    
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.page_number + 1;
                    $scope.get_business_list(pagenum);
                }
            }
        }
    });

    $scope.get_business_list = function(start) {
        if (isProcessing) {
            return false;
        }
        isProcessing = true;
        $("#business-loader").show();
        $http({
            method: 'POST',
            url: base_url + 'user_post/get_business_list?page='+start,            
            data: 'search_tag='+$scope.search_tag,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $("#business-loader").hide();
            
            if (success.data.business_data.length >0 ) {
                if(start > 1)
                {
                    for (var i in success.data.business_data) {                            
                        //$scope.searchJob.push(data.latestJobs[i]);
                        //$scope.$apply(function () {
                            $scope.business_data.push(success.data.business_data[i]);
                        //});
                    }
                }
                else
                {
                    $scope.business_data = success.data.business_data;
                }

                
                isProcessing = false;

                // $scope.business_data = success.data.business_data;
                $scope.page_number = start;
                $scope.total_record = success.data.total_record;
                $scope.perpage_record = 12;
            }
            else
            {
                isProcessing = true;
                $scope.showLoadmore = false;
                // $scope.business_data = success.data.business_data;
                $scope.page_number = start;
                $scope.total_record = success.data.total_record;
                $scope.perpage_record = 12;
            }
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
        }, function (error) {
            $(".sugg_post_load").hide();
            setTimeout(function(){
                $scope.get_business_list(start);
            },500);
        }, 
        function (complete) {
            $(".sugg_post_load").hide();
        });
    };
    $scope.get_business_list(1);
});
app.controller('hashtagController', function ($scope, $http,$window,$location) {
    $scope.$parent.active_pg = 3;
    $scope.today = new Date();
    $scope.$parent.title = "Hashtags | Aileensoul";
    $scope.user_id = user_id;
    var offset = "12";
    var processing = false;
    //getContactSuggetion(1);
    var isProcessing = false;
    
    angular.element($window).bind("scroll", function (e) {
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.4) && $location.url().substr(1) == 'hashtags') {
            // isLoadingData = true;
            var page = $scope.page_number;
            var total_record = $scope.total_record;
            var perpage_record = $scope.perpage_record;
    
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.page_number + 1;
                    $scope.get_hashtag_list(pagenum);
                }
            }
        }
    });

    $scope.check_enter_key = function($event){
        var keyCode = $event.which || $event.keyCode;
        if (keyCode === 13) {
            isProcessing = false;
            $scope.get_hashtag_search(1);
        }
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
                $scope.page_number = start;
                $scope.total_record = success.data.total_record;
                $scope.perpage_record = 12;
            }
            else
            {
                isProcessing = true;
                $scope.showLoadmore = false;
                // $scope.hashtag_list = success.data.hashtag_list;
                $scope.page_number = start;
                $scope.total_record = success.data.total_record;
                $scope.perpage_record = 12;
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
                $scope.page_number = start;
                $scope.total_record = success.data.total_record;
                $scope.perpage_record = 12;
            }
            else
            {
                isProcessing = true;
                $scope.showLoadmore = false;
                $scope.hashtag_list = success.data.hashtag_list;
                $scope.page_number = start;
                $scope.total_record = success.data.total_record;
                $scope.perpage_record = 12;
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

    $scope.follow_hashtag = function(hashtag_id,index)
    {
        $(".hashtag-follow-btn-"+hashtag_id).attr('style','pointer-events:none;');
        $(".hashtag-follow-btn-"+hashtag_id).html('Following');
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
        $(".hashtag-follow-btn-"+hashtag_id).html('Follow');
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
});
$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});
function follow_user(id)
{
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $(".follow-btn-bus-" + uid.slice(0, -6) + ' a').html('Following');
    $.ajax({
        url: base_url + "userprofile_page/follow_user_tooltip",        
        type: "POST",
        data: 'to_id=' + uid + '&ele_id=' + id,
        success: function (data) {            
            $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-user-" + uid.slice(0, -6)).html(data);
            },500);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                follow_user(id);
            },500);
        }
    });
}

function unfollow_user(id) {
    var uid = $("#"+id).data('uid').toString();
    $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:none;');
    $(".follow-btn-bus-" + uid.slice(0, -6) + ' a').html('Follow');
    $.ajax({
        url: base_url + "userprofile_page/unfollow_user_tooltip",        
        type: "POST",
        data: 'to_id=' + uid + '&ele_id=' + id,
        success: function (data) {            
            $(".follow-btn-user-" + uid.slice(0, -6)).attr('style','pointer-events:all;');
            setTimeout(function(){
                $(".follow-btn-user-" + uid.slice(0, -6)).html(data);
            },500);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                unfollow_user(id);
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
    if(status == 'confirm')
    {
        $("#pending-con-"+indexCon.slice(0,-6)).remove();
        $.ajax({
            url: base_url + "userprofile/contactRequestAction",        
            type: "POST",
            data: 'from_id='+to_id.slice(0,-6)+'&action=confirm',
            dataType:"JSON",
            success: function (data) {            
                // $(".contact-btn-"+to_id.slice(0, -6)).attr('style','pointer-events:all;');
                setTimeout(function(){
                    // $(".contact-btn-"+to_id.slice(0, -6)).html(data.button);
                },500);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                setTimeout(function(){
                    contact(elid);
                },500);
            }
        });
    }
    else
    {        
        $(".contact-btn-"+to_id.slice(0, -6)+' a').html('Request sent');
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
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                setTimeout(function(){
                    contact(elid);
                },500);
            }
        });
    }    
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