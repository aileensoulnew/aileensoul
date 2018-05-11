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
app.controller('jobSearchController', function ($scope, $http) {

    $scope.jobCategory = {};
    $scope.jobCity = {};
    $scope.jobCompany = {};
    $scope.jobSkill = {};
    $scope.latestJob = {};

    function jobCategory(limit = "") {
        $http.get(base_url + "job_live/jobCategory?limit="+limit).then(function (success) {
            $scope.jobCategory = success.data;
        }, function (error) {});
    }
    jobCategory();

    function jobCity(limit = "") {
        $http.get(base_url + "job_live/jobCity?limit="+limit).then(function (success) {
            $scope.jobCity = success.data;
        }, function (error) {});
    }
    jobCity();
    function jobCompany(limit = "") {
        $http.get(base_url + "job_live/jobCompany?limit="+limit).then(function (success) {
            $scope.jobCompany = success.data;
        }, function (error) {});
    }
    jobCompany();
    function jobSkill(limit = "") {
        $http.get(base_url + "job_live/jobSkill?limit="+limit).then(function (success) {
            $scope.jobSkill = success.data;
        }, function (error) {});
    }
    jobSkill();

    function jobTitle(limit = "") {
        $http.get(base_url + "job_live/get_jobtitle?limit="+limit).then(function (success) {
            $scope.jobDesignation = success.data;
        }, function (error) {});
    }
    jobTitle();

    //CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER START
    
    job_search();
    $(window).scroll(function() {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {
            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    job_search(pagenum);
                }
            }
        }
    });
    
    var isProcessing = false;

    function job_search(pagenum) {
        if (isProcessing) {
            /*
             *This won't go past this condition while
             *isProcessing is true.
             *You could even display a message.
             **/
            return;
        }
        isProcessing = true;
        $.ajax({
            type: 'POST',
            url: base_url + "job/ajax_job_search_new?page=" + pagenum + "&skill=" + encodeURIComponent(skill),
            data: { "total_record": $("#total_record").val(), },
            dataType: "html",
            beforeSend: function() {
                if (pagenum == 'undefined') {
                    $(".job-contact-frnd ").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
                } else {
                    $('#loader').show();
                }
            },
            complete: function() {
                $('#loader').hide();
            },
            success: function(data) {
                $('.loader').remove();
                $('.job-contact-frnd ').append(data);
                // second header class add for scroll
                var nb = $('.post-design-box').length;
                if (nb == 0) {
                    $("#dropdownclass").addClass("no-post-h2");
                } else {
                    $("#dropdownclass").removeClass("no-post-h2");
                }
                isProcessing = false;
            }
        });
    }
    //CODE FOR RESPONES OF AJAX COME FROM CONTROLLER AND LAZY LOADER END
});  