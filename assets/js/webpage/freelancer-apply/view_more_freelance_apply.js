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

app.controller('viewMoreFreelanceApplyController', function ($scope, $http) {    
});
app.controller('searchFreelancerApplyController', function ($scope, $http) {    
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/freelance-jobs-by-fields", {
                templateUrl: base_url + "freelancer_apply_live/freelance_jobs_by_fields",
                controller: 'FAjobsByFieldController'
            })
            .when("/freelance-jobs-by-categories", {
                templateUrl: base_url + "freelancer_apply_live/freelance_jobs_by_categories",
                controller: 'FAjobsByCategoryController'
            })                       
    $locationProvider.html5Mode(true);
});

app.controller('FAjobsByFieldController', function ($scope, $http, $location, $window) {
    $scope.title = "Freelance Jobs By Field | Aileensoul";    
    $scope.jobByField = {};
    $scope.jobs = {};
    var isProcessing = false;
    function jobCity(pagenum = "") {
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "freelancer_apply_live/freelance_jobs_by_fields_ajax?page=" + pagenum).then(function (success) {
            data = success.data;
            if(data.fa_fields.length > 0)
            {                    
                if(pagenum > 1)
                {
                    for (var i in data.fa_fields) {                            
                        $scope.jobByField.push(data.fa_fields[i]);
                    }
                }
                else
                {
                    $scope.jobByField = data.fa_fields;
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

app.controller('FAjobsByCategoryController', function ($scope, $http, $location, $window) {
    $scope.title = "Freelance Jobs By Category | Aileensoul";    
    $scope.jobByCategory = {};
    $scope.jobs = {};
    var isProcessing = false;
    function jobSkill(pagenum = "") {
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "freelancer_apply_live/freelance_jobs_by_categories_ajax?page=" + pagenum).then(function (success) {
            data = success.data;
            if(data.fa_category.length > 0)
            {                    
                if(pagenum > 1)
                {
                    for (var i in data.fa_category) {                            
                        $scope.jobByCategory.push(data.fa_category[i]);
                    }
                }
                else
                {
                    $scope.jobByCategory = data.fa_category;
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
    jobSkill(1);  
    
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
                    jobSkill(pagenum);
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