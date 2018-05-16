app.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
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

app.controller('viewMoreJobController', function ($scope, $http) {    
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/jobs-by-location", {
                templateUrl: base_url + "job_live/jobs_by_location",
                controller: 'jobByLocationController'
            })
            .when("/jobs-by-skills", {
                templateUrl: base_url + "job_live/jobs_by_skills",
                controller: 'jobsBySkillsController'
            })
            .when("/jobs-by-designations", {
                templateUrl: base_url + "job_live/jobs_by_designations",
                controller: 'jobsByDescController'
            })
            .when("/jobs-by-companies", {
                templateUrl: base_url + "job_live/jobs_by_companies",
                controller: 'jobsByCompanyController'
            })
            .when("/jobs-by-categories", {
                templateUrl: base_url + "job_live/jobs_by_categories",
                controller: 'jobsBycategoryController'
            });            
    $locationProvider.html5Mode(true);
});

app.controller('jobByLocationController', function ($scope, $http, $location, $window) {    
    $scope.title = title;    
    $scope.jobByLocation = {};
    $scope.jobs = {};
    var isProcessing = false;
    function jobCity(pagenum = "") {
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "job_live/jobs_by_location_ajax?page=" + pagenum).then(function (success) {
            data = success.data;
            if(data.job_city.length > 0)
            {                    
                if(pagenum > 1)
                {
                    for (var i in data.job_city) {                            
                        $scope.jobByLocation.push(data.job_city[i]);
                    }
                }
                else
                {
                    $scope.jobByLocation = data.job_city;
                }
                $scope.jobs.page_number = pagenum;
                $scope.jobs.total_record = data.total_record;
                $scope.jobs.perpage_record = 5;            
                isProcessing = false;
            }
            else
            {
                $scope.showLoadmore = false;                
            }            
        }, function (error) {});
    }
    jobCity(1);  
    
    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {            
            isLoadingData = true;
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
                    jobCity(pagenum);
                }
            }
        }
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