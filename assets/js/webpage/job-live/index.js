app.controller('jobController', function ($scope, $http) {
    $scope.title = title;
    $scope.jobCategory = {};
    $scope.jobCity = {};
    $scope.jobCompany = {};
    $scope.jobSkill = {};
    $scope.latestJob = {};

    function jobCategory() {
        $http.get(base_url + "job_live/jobCategory?limit=25").then(function (success) {
            $scope.jobCategory = success.data;
        }, function (error) {});
    }
    jobCategory();

    function jobCity() {
        $http.get(base_url + "job_live/jobCity?limit=25").then(function (success) {
            $scope.jobCity = success.data;
        }, function (error) {});
    }
    jobCity();
    function jobCompany() {
        $http.get(base_url + "job_live/jobCompany?limit=25").then(function (success) {
            $scope.jobCompany = success.data;
        }, function (error) {});
    }
    jobCompany();
    function jobSkill() {
        $http.get(base_url + "job_live/jobSkill?limit=25").then(function (success) {
            $scope.jobSkill = success.data;
        }, function (error) {});
    }
    jobSkill();
    function latestJob() {
        $http({
            method: 'POST',
            url: base_url + 'job_live/latestJob',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.latestJob = success.data;
                });
    }
    latestJob();

    $scope.applyJobFilter = function () {
        var d = $("#job-filter").serialize();
        $http({
            method: 'POST',
            url: base_url + 'job_live/applyJobFilter',
            data: d,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.latestJob = success.data;
                });
    }
    $('#job-filter input').change(function () {
        $scope.applyJobFilter();
    });
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});

    // NEW HTML SCRIPT

    AOS.init({
        easing: 'ease-in-out-sine'
    });

    setInterval(addItem, 100);

    var itemsCounter = 1;
    var container = document.getElementById('aos-demo');

    function addItem () {
        if (itemsCounter > 42) return;
        var item = document.createElement('div');
        item.classList.add('aos-item');
        item.setAttribute('data-aos', 'fade-up');
        item.innerHTML = '<div class="aos-item__inner"><h3>' + itemsCounter + '</h3></div>';
        // container.appendChild(item);
        itemsCounter++;
    }