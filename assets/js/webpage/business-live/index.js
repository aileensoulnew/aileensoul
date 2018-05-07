app.controller('businessController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessCategory = {};
    $scope.locationCategory = {};
    
    function businessCategory(){
        $http.get(base_url + "business_live/businessCategory?limit=8").then(function (success) {
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
   
    //  GET ALL LOCATION OF BUSINESS
    function businessLocation(){
        $http.get(base_url + "business_live/businessLocation?limit=8").then(function (success) {
            $scope.businessLocation = success.data;
        }, function (error) {});
    }
    businessLocation();
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});
