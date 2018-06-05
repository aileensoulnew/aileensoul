app.controller('viewBusinessController', function ($scope, $http) {    
});


app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/business-by-categories", {
                templateUrl: base_url + "business_live/category",
                controller: 'businessCategoryController'
            })
            .when("/business-by-location", {
                templateUrl: base_url + "business_live/location",
                controller: 'businessLocationController'
            })        
            .when("/business", {
                templateUrl: base_url + "business_live/business_by_business",
                controller: 'businessBybusinessController'
            });   
    $locationProvider.html5Mode(true);
});


app.controller('businessCategoryController', function ($scope, $window, $http) {
    $scope.$parent.title = title;
    $scope.businessAllCategory = {};
    $scope.business = {};
    var isProcessing = false;
    function businessAllCategory(pagenum){
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "business_live/businessAllCategory?page=" + pagenum).then(function (success) {
            // $scope.businessAllCategory = success.data;
            data = success.data;
            if(data.bus_cat.length > 0)
            {                    
                if(pagenum > 1)
                {
                    for (var i in data.bus_cat) { 
                        $scope.businessAllCategory.push(data.bus_cat[i]);
                    }
                }
                else
                {
                    $scope.businessAllCategory = data.bus_cat;
                }
                $scope.business.page_number = pagenum;
                $scope.business.total_record = data.total_record;
                $scope.business.perpage_record = 5;            
                isProcessing = false;
            }
            else
            {
                $scope.showLoadmore = false;                
            }

        }, function (error) {});
    }
    businessAllCategory(1);
    function otherCategoryCount(){
        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();

    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {            
            isLoadingData = true;
            var page = $scope.business.page_number;
            var total_record = $scope.business.total_record;
            var perpage_record = $scope.business.perpage_record;            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.business.page_number + 1;
                    businessAllCategory(pagenum);
                }
            }
        }
    });
});


app.controller('businessLocationController', function ($scope, $window, $http) {
    $scope.$parent.title = title;
    $scope.businessAllLocation = {};
    $scope.business = {};
    var isProcessing = false;
    function businessAllLocation(pagenum = ""){
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "business_live/businessAllLocation?page=" + pagenum).then(function (success) {
            data = success.data;
            if(data.bus_loc.length > 0)
            {                    
                if(pagenum > 1)
                {
                    for (var i in data.bus_loc) {                            
                        $scope.businessAllLocation.push(data.bus_loc[i]);
                    }
                }
                else
                {
                    $scope.businessAllLocation = data.bus_loc;
                }
                $scope.business.page_number = pagenum;
                $scope.business.total_record = data.total_record;
                $scope.business.perpage_record = 5;            
                isProcessing = false;
            }
            else
            {
                $scope.showLoadmore = false;                
            }
        }, function (error) {});
    }
    businessAllLocation(1);

    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {            
            isLoadingData = true;
            var page = $scope.business.page_number;
            var total_record = $scope.business.total_record;
            var perpage_record = $scope.business.perpage_record;            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.business.page_number + 1;
                    businessAllLocation(pagenum);
                }
            }
        }
    });
});

app.controller('businessBybusinessController', function ($scope, $http) {
    $scope.$parent.title = title;
    $scope.businessByBusiness = {};
    var isProcessing = false;
    function jobJobs(pagenum = "") {
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "business_live/business_by_category_location_ajax?page=" + pagenum).then(function (success) {
            $scope.businessByBusiness = data = success.data;
        }, function (error) {});
    }
    jobJobs(1);  
});