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

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});