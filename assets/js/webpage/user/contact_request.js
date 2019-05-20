var isscroll = true;
app.controller('contactRequestController', function ($scope, $http,$window ) {
    $scope.title = "Contact Request | Aileensoul";
    pending_contact_request();
    var offset="40";
    var processing = false;
    getContactSuggetion(1);
    contactRequestNotification();
    $scope.jobs = {};

    var isProcessing = false;
    
    angular.element($window).bind("scroll", function (e) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.6) {
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
            /*
             *This won't go past this condition while
             *isProcessing is true.
             *You could even display a message.
             **/
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
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
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
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            $(".req_post_load").hide();
            $("#contactlist").show();
            pending_contact_request = success.data;
            $scope.pending_contact_request_data = pending_contact_request;            
        });
    }
    function contactRequestNotification() {
        $http({
            method: 'POST',
            url: base_url + 'userprofile_page/contactRequestNotification',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            contactRequestNotification = success.data;
            $scope.contactRequestNotification = contactRequestNotification;
        });
    }
    $scope.confirmContact = function (from_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'userprofile/contactRequestAction',
            data: 'from_id=' + from_id + '&action=confirm',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data) {
                $scope.pending_contact_request_data.splice(index, 1);
                socket.emit('user notification',from_id);
            }
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
                socket.emit('user notification',from_id);
            }
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
                socket.emit('user notification',user_id);
                //$('.owl-carousel').trigger('next.owl.carousel');
            }
        });
    }
});
$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});