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
    contactRequestCount();
    
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
            }
            $scope.contact_request_count = contact_request.total;
        });
    }

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

    var loadTime = 1000, //Load the data every second
        errorCount = 0, //Counter for the server errors
        loadPromise; //Pointer to the promise created by the Angular $timout service

    var getData = function() {
        $http.get(base_url+'notification/unread_message_count_new?now=' + Date.now())
        .then(function(res) {
            $scope.not_data = res.data;
            if(res.data > 0)
            {
                $(".msg-count").show();
                $(".msg-count").text(res.data);
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
             nextLoad(++errorCount * 2 * loadTime);
        });
    };

     var cancelNextLoad = function() {
         $timeout.cancel(loadPromise);
     };

    var nextLoad = function(mill) {
        mill = mill || loadTime;

        //Always make sure the last timeout is cleared before starting a new one
        cancelNextLoad();
        $timeout(getData, mill);
    };


    //Start polling the data from the server
    getData();


    //Always clear the timeout when the view is destroyed, otherwise it will   keep polling
    $scope.$on('$destroy', function() {
        cancelNextLoad();
    });
});
$(".dropdown-menu").click(function (event) {
    $(this).parent('li').addClass('open');
    event.stopPropagation();
});