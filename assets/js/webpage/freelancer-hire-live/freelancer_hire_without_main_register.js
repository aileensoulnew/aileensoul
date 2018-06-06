app.controller('recruiterController', function ($scope, $http) {
    $scope.title = title;   
    $scope.relatedBlog = {};
    // GET RELATED BLOG LIST FOR INDEX PAGE 
    function getRelatedBlogList(){
        $http.post(base_url + "freelancer_hire_live/get_free_hire_related_blog_list").then(function (success) {
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