app.controller('recruiterController', function ($scope, $http) {
    $scope.title = title;    

    // GET RELATED BLOG LIST FOR INDEX PAGE 
    function getRelatedBlogList(){
        $http.post(base_url + "recruiter_live/get_recruiter_related_blog_list").then(function (success) {
            $scope.relatedBlog = success.data;
        }, function (error) {});
    }
    getRelatedBlogList();

});
AOS.init({
    easing: 'ease-in-out-sine'
});
$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});