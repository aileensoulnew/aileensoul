app.controller('businessListController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessCategory = {};
    $scope.businessLocation = {};
    function businessCategory(){
        $http.get(base_url + "business_live/businessCategory?limit=5").then(function (success) {
            $scope.businessCategory = success.data;
        }, function (error) {});
    }
    businessCategory();
    function otherCategoryCount(){
        $http.get(base_url + "business_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();

    // Top 5 Location for filter
    function businessLocation(){
        $http.get(base_url + "business_live/businessLocation?limit=5").then(function (success) {
            $scope.businessLocation = success.data;
        }, function (error) {});
    }
    businessLocation();

    // get list of company based on category or locations
    function categoryBusinessList(){
        $http.get(base_url + "business_live/businessListByCategory/" + category_id).then(function (success) {
            $scope.businessList = success.data;
        }, function (error) {});
    }
    function locationBusinessList(){
        $http.get(base_url + "business_live/businessListByLocation/" + location_id).then(function (success) {
            $scope.businessList = success.data;
        }, function (error) {});
    }
    if(location_id == '' || !location_id){
        categoryBusinessList();
    }else{
        locationBusinessList();
    }
    
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});

