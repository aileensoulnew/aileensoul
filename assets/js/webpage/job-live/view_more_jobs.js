app.directive('checkImageNew', function() {
   return {
      link: function(scope, element, attrs) {
         element.bind('error', function() {
            element.attr('src', base_url + '/assets/n-images/commen-img.png'); // set default image
         });
       }
   }
});
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
            })
            .when("/jobs", {
                templateUrl: base_url + "job_live/jobs_by_jobs",
                controller: 'jobsByjobsController'
            });            
    $locationProvider.html5Mode(true);
});

app.controller('jobByLocationController', function ($scope, $http, $location, $window) {
    $scope.$parent.title = "Search Full Time Jobs by Location - Find Available Local Jobs in Your City";
    $scope.$parent.metadesc = "Explore numerous Jobs near by your location on Aileensoul. Choose your preferable city and find the latest jobs. Get your dream job now!";    
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
            $('#main_loader').hide();
            $('#main_page_load').show();

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

app.controller('jobsBySkillsController', function ($scope, $http, $location, $window) {
    $scope.$parent.title = "Search Full Time Jobs by Skills - Browse IT/Non-IT Jobs";
    $scope.$parent.metadesc = "Explore numerous Jobs by your skills on Aileensoul. Choose preferable IT and Non-IT skills and find the latest jobs. Register and Get your dream job now!"; 
    $scope.jobByLocation = {};
    $scope.jobs = {};
    var isProcessing = false;
    function jobSkill(pagenum = "") {
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "job_live/jobs_by_skills_ajax?page=" + pagenum).then(function (success) {
            data = success.data;
            if(data.job_skills.length > 0)
            {                    
                if(pagenum > 1)
                {
                    for (var i in data.job_skills) {                            
                        $scope.jobBySkills.push(data.job_skills[i]);
                    }
                }
                else
                {
                    $scope.jobBySkills = data.job_skills;
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

            $('#main_loader').hide();
            $('#main_page_load').show();   
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

app.controller('jobsByDescController', function ($scope, $http, $location, $window) {
    $scope.$parent.title = "Job By Designation, Job Profile | Aileensoul";    
    $scope.jobByDesc = {};
    $scope.jobs = {};
    var isProcessing = false;
    function jobDesignation(pagenum = "") {
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "job_live/jobs_by_designations_ajax?page=" + pagenum).then(function (success) {
            data = success.data;
            if(data.job_desc.length > 0)
            {                    
                if(pagenum > 1)
                {
                    for (var i in data.job_desc) {                            
                        $scope.jobByDesc.push(data.job_desc[i]);
                    }
                }
                else
                {
                    $scope.jobByDesc = data.job_desc;
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

            $('#main_loader').hide();
            $('#main_page_load').show();   
        }, function (error) {});
    }
    jobDesignation(1);  
    
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
                    jobDesignation(pagenum);
                }
            }
        }
    });
    
});

app.controller('jobsByCompanyController', function ($scope, $http, $location, $window) {
    $scope.$parent.title = "Search Full Time Jobs by Companies | Top Companies Hiring at Aileensoul";
    $scope.$parent.metadesc = "Explore numerous Jobs by company on Aileensoul. Choose your preferable company and find the latest jobs openings. Join Aileensoul and Get your dream job now!"; 
    $scope.jobByCompany = {};
    $scope.jobs = {};
    var isProcessing = false;
    function jobCompany(pagenum = "") {
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "job_live/jobs_by_companies_ajax?page=" + pagenum).then(function (success) {
            data = success.data;
            if(data.job_company.length > 0)
            {                    
                if(pagenum > 1)
                {
                    for (var i in data.job_company) {                            
                        $scope.jobByComp.push(data.job_company[i]);
                    }
                }
                else
                {
                    $scope.jobByComp = data.job_company;
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

            $('#main_loader').hide();
            $('#main_page_load').show();
        }, function (error) {});
    }
    jobCompany(1);  
    
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
                    jobCompany(pagenum);
                }
            }
        }
    });
    
});

app.controller('jobsBycategoryController', function ($scope, $http, $location, $window) {
    $scope.$parent.title = "Search Full Time Jobs by Categories - Browse HR, IT, Banking, Marketing Jobs";
    $scope.$parent.metadesc = "Explore numerous Jobs by categories like HR, Digital Marketing, Web Designing, Graphic Designing, Banking, and many more on Aileensoul. Join Aileensoul and Grab the opportunity now!"; 
    $scope.jobByCategory = {};
    $scope.jobs = {};
    var isProcessing = false;
    function jobCategory(pagenum = "") {
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "job_live/jobs_by_categories_ajax?page=" + pagenum).then(function (success) {
            data = success.data;
            if(data.job_cat.length > 0)
            {                    
                if(pagenum > 1)
                {
                    for (var i in data.job_cat) {                            
                        $scope.jobByCat.push(data.job_cat[i]);
                    }
                }
                else
                {
                    $scope.jobByCat = data.job_cat;
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

            $('#main_loader').hide();
            $('#main_page_load').show();
        }, function (error) {});
    }
    jobCategory(1);  
    
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
                    jobCategory(pagenum);
                }
            }
        }
    });
    
});

app.controller('jobsByjobsController', function ($scope, $http, $location, $window) {
    $scope.$parent.title = "Jobs, Job Profile | Aileensoul";    
    $scope.jobByJobs = {};
    $scope.jobs = {};
    var isProcessing = false;
    function jobJobs(pagenum = "") {
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "job_live/jobs_by_jobs_ajax?page=" + pagenum).then(function (success) {
            $scope.jobByJobs = data = success.data;
            $('#main_loader').hide();
            $('#main_page_load').show();
        }, function (error) {});
    }
    jobJobs(1);  
    
    
    
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