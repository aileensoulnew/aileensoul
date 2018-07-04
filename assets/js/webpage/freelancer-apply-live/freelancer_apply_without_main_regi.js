app.controller('freelancerApplyController', function ($scope, $http) {
    $scope.title = title;
    $scope.relatedBlog = {};

    function FAFields(limit = 0) {
        $http.get(base_url + "freelancer_apply_live/freelancerFields?limit="+limit).then(function (success) {
            $scope.FAFields = success.data;
        }, function (error) {});
    }
    FAFields(8);

    function FASkills(limit = 0) {
        $http.get(base_url + "freelancer_apply_live/freelancerSkills?limit="+limit).then(function (success) {
            $scope.FASkills = success.data.fa_category;
        }, function (error) {});
    }
    FASkills(8);

    // GET RELATED BLOG LIST FOR INDEX PAGE 
    function getRelatedBlogList(){
        $http.post(base_url + "freelancer_apply_live/get_free_job_related_blog_list").then(function (success) {
            $scope.relatedBlog = success.data;
        }, function (error) {});
    }
    getRelatedBlogList();
});
/*AOS.init({
    easing: 'ease-in-out-sine'
});*/
$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});