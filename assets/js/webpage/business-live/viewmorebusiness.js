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
                controller: 'businessCategoryController'
            })        
    $locationProvider.html5Mode(true);
});


app.controller('businessCategoryController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessAllCategory = {};
    $scope.businessAllLocation = {};
    function businessAllCategory(){
        $http.get(base_url + "business_live/businessAllCategory").then(function (success) {
            $scope.businessAllCategory = success.data;
        }, function (error) {});
    }
    businessAllCategory();
    function otherCategoryCount(){
        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();
    function businessAllLocation(){
        $http.get(base_url + "business_live/businessLocation").then(function (success) {
            $scope.businessAllLocation = success.data;
        }, function (error) {});
    }
    businessAllLocation();
});


/*app.controller('businessLocationController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessAllCategory = {};
    $scope.businessAllLocation = {};
    function businessAllCategory(){
        $http.get(base_url + "business_live/businessAllCategory").then(function (success) {
            $scope.businessAllCategory = success.data;
        }, function (error) {});
    }
    businessAllCategory();
    function otherCategoryCount(){
        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();
    function businessAllLocation(){
        $http.get(base_url + "business_live/businessLocation").then(function (success) {
            $scope.businessAllLocation = success.data;
        }, function (error) {});
    }
    businessAllLocation();
});*/