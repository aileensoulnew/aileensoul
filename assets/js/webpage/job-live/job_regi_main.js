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

        if(slug[slug.length - 1] == "-")
        {            
            slug = slug.slice(0,-1);
        }
        return slug;
    };
});

app.controller('jobRegiMainController', function ($scope, $http) {    
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/job-profile/create-account", {
                templateUrl: base_url + "job_live/job_register",
                controller: 'jobRegiController'
            })
            .when("/job-profile/basic-info", {
                templateUrl: base_url + "job_live/job_basic_info",
                controller: 'jobBasicInfoController'
            })
            .when("/job-profile/educational-info", {
                templateUrl: base_url + "job_live/job_education_info",
                controller: 'jobEduInfoController'
            })
            .when("/job-profile/registration", {
                templateUrl: base_url + "job_live/job_create_profile",
                controller: 'jobCreateProfileController'
            })            
    $locationProvider.html5Mode(true);
});

app.controller('jobRegiController', function ($scope, $http, $location, $window) {
    $scope.title = "Job By Location, Job Profile | Aileensoul";    
    $scope.jobByLocation = {};
    $scope.jobs = {};
});

app.controller('jobBasicInfoController', function ($scope, $http, $location, $window) {
    $scope.title = "Job By Skills, Job Profile | Aileensoul";    
    $scope.jobByLocation = {};
    $scope.jobs = {};
    var isProcessing = false;
});

app.controller('jobEduInfoController', function ($scope, $http, $location, $window) {
    $scope.title = "Job By Designation, Job Profile | Aileensoul";    
    $scope.jobByDesc = {};
    $scope.jobs = {};
    var isProcessing = false;    
});

app.controller('jobCreateProfileController', function ($scope, $http, $location, $window) {
    $scope.title = "Job By Designation, Job Profile | Aileensoul";    
    $scope.jobByDesc = {};
    $scope.jobs = {};
    var isProcessing = false;    
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