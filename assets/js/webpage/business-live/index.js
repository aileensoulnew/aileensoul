app.controller('businessController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessCategory = {};
    $scope.locationCategory = {};
    $scope.relatedBlog = {};
    
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

    // GET RELATED BLOG LIST FOR INDEX PAGE 
    function getRelatedBlogList(){
        $http.post(base_url + "business_live/get_business_related_blog_list").then(function (success) {
            $scope.relatedBlog = success.data;
        }, function (error) {});
    }
    getRelatedBlogList();

});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});
