//app.filter('capitalize', function() {
//    return function(input) {
//      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
//    }
//});
app.filter('capitalize', function () {
    return function (str) {
        if (str === undefined || !str || str == null) {
            return false;
        }
        return str.split(" ").map(function (input) {
            return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : ''
        }).join(" ");

    }
});
app.controller('headerCtrl', function ($scope, $http,$timeout) {

    function get_notification_unread_count()
    {
        var url = base_url+'notification/get_notification_unread_count';
        $.get(url, function(data, status){
            $(".noti_count").show();
            if(parseInt(data) > 0)
            {
                if(parseInt(data) > 99)
                {
                    $(".noti_count").html('99+');
                }
                else
                {
                    $(".noti_count").html(data);
                }
            }
            else
            {
                $(".noti_count").hide();
                $(".noti_count").html("");
            }
        }).fail(function() {
            get_notification_unread_count();
        });
    }

    function unread_message_count()
    {
        var url = base_url+'cron/unread_message_count_wc';
        $.get(url, function(data, status){
            data = JSON.parse(data);            
            if(data.unread_user > 0)
            {
                $(".msg-count").show();
                if(parseInt(data.unread_user) > 99)
                {
                    $(".msg-count").addClass('not-max');
                    $(".msg-count").html('99+');
                }
                else
                {
                    $(".msg-count").removeClass('not-max');
                    $(".msg-count").html(data.unread_user);
                }
            }
            else
            {
                $(".msg-count").hide();
                $(".msg-count").text('');   
            }
        }).fail(function() {
            unread_message_count();
        });
    }

    function contactRequestCount(){
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestCount',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            contact_request = success.data;
            if(contact_request.total > 0)
            {
                $(".con_req_cnt").show();
                if(contact_request.total > 99)
                {
                    $(".con_req_cnt").addClass('not-max');
                }
                else
                {
                    $(".con_req_cnt").removeClass('not-max');
                }
            }
            $scope.contact_request_count = (contact_request.total > 99 ? '99+' : contact_request.total);
        });
    }

    setTimeout(function(){
        get_notification_unread_count();
        unread_message_count();
        contactRequestCount();
    }, 1000);

    $scope.header_all_profile = function () {
        $('.all .dropdown-menu').html(header_all_profile);
        $(document).find('.business_popup .dropdown-menu').html(header_all_profile);
    }

    $scope.header_contact_request = function () {
        
        $("#contact_loader").show();
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contact_request',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $("#contact_loader").hide();
            contact_request = success.data;
            $scope.contact_request_data = contact_request;
            $scope.contact_request_count = '0';
        });
    }

    $scope.confirmContactRequest = function (from_id,index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=confirm',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $scope.contact_request_data.splice(index, 1);
        });
    }

    $scope.rejectContactRequest = function (from_id,index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=reject',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $scope.contact_request_data.splice(index, 1);
        });
    }

    /*var loadTime = 40000, //Load the data every second
        errorCount = 0, //Counter for the server errors
        loadPromise; //Pointer to the promise created by the Angular $timout service

    var getData = function() {
        $http.get(base_url+'notification/unread_message_count_new?now=' + Date.now())
        .then(function(res) {
            $scope.not_data = res.data;
            if(res.data > 0)
            {
                $(".msg-count").show();
                if(res.data > 99)
                {
                    $(".msg-count").text('99+');
                }
                else
                {
                    $(".msg-count").text(res.data);
                }
            }
            else
            {
                $(".msg-count").hide();
                $(".msg-count").text('');   
            }
             // console.log(res.data);

              errorCount = 0;
              nextLoad();
        })
        .catch(function(res) {
            // $scope.not_data = 'Server error';
            // console.log('Server error');
            // nextLoad(++errorCount * 2 * loadTime);
        });
    };

     var cancelNextLoad = function() {
        // $timeout.cancel(loadPromise);
     };

    var nextLoad = function(mill) {
        mill = mill || loadTime;

        //Always make sure the last timeout is cleared before starting a new one
        // cancelNextLoad();
        // $timeout(getData, mill);
    };


    //Start polling the data from the server
    // getData();


    //Always clear the timeout when the view is destroyed, otherwise it will   keep polling
    $scope.$on('$destroy', function() {
        // cancelNextLoad();
    });*/
    
    /*setTimeout(function(){


        if(typeof(EventSource) !== "undefined") {
            var source = new EventSource(base_url+"cron/unread_message_count_wc");
            source.onmessage = function(event) {
                // console.log(event.data);
                if(parseInt(event.data) > 0)
                {
                    $(".msg-count").show();
                    if(parseInt(event.data) > 99)
                    {
                        $(".msg-count").addClass('not-max');
                        $(".msg-count").html('99+');
                    }
                    else
                    {
                        $(".msg-count").removeClass('not-max');
                        $(".msg-count").html(event.data);
                    }
                }
                else
                {
                    $(".msg-count").hide();
                    $(".msg-count").html("");
                }
            };
        } else {
            console.log("Sorry, your browser does not support server-sent events...");
        }

        if(typeof(EventSource) !== "undefined") {
            var source = new EventSource(base_url+"cron/get_notification_unread_count_wc");
            source.onmessage = function(event) {
                // console.log(event.data);
                $(".noti_count").show();
                if(parseInt(event.data) > 0)
                {
                    if(parseInt(event.data) > 99)
                    {
                        $(".noti_count").addClass('not-max');
                        $(".noti_count").html('99+');
                    }
                    else
                    {
                        $(".noti_count").removeClass('not-max');
                        $(".noti_count").html(event.data);
                    }
                }
                else
                {
                    $(".noti_count").hide();
                    $(".noti_count").html("");
                }
            };
        } else {
            console.log("Sorry, your browser does not support server-sent events...");
        }

        if(typeof(EventSource) !== "undefined") {
            var source = new EventSource(base_url+"cron/contact_request_count_wc");
            source.onmessage = function(event) {
                // console.log(event.data);
                if(parseInt(event.data) > 0)
                {
                    $(".con_req_cnt").show();
                    if(parseInt(event.data) > 99)
                    {
                        $(".con_req_cnt").addClass('not-max');
                        $(".con_req_cnt").html('99+');
                    }
                    else
                    {
                        $(".con_req_cnt").removeClass('not-max');
                        $(".con_req_cnt").html(event.data);
                    }
                }
                else
                {
                    $(".con_req_cnt").hide();
                    $(".con_req_cnt").html("");
                }
            };
        } else {
            console.log("Sorry, your browser does not support server-sent events...");
        }

    },2000);*/
});
$(".dropdown-menu").click(function (event) {
    $(this).parent('li').addClass('open');
    event.stopPropagation();
});