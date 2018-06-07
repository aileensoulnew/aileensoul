app.controller('artistController', function ($scope, $http) {
    $scope.title = title;
    $scope.artistCategory = {};
    $scope.relatedBlog = {};
    
    function artistCategory(){
        $http.get(base_url + "artist_live/artistCategory?limit=8").then(function (success) {
            $scope.artistCategory = success.data;
        }, function (error) {});
    }
    artistCategory();
    function otherCategoryCount(){
        $http.get(base_url + "artist_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();

    function getArtistLocation(){
        var form_data = new FormData();
        form_data.append('limitstart', 0);
        form_data.append('limit', 8);
        $http.post(base_url + "artist_live/gettoploactionofartist").then(function (success) {
            $scope.topLocationData = success.data;
        }, function (error) {});
    }
    getArtistLocation();
    
    // GET RELATED BLOG LIST FOR INDEX PAGE 
    function getRelatedBlogList(){
        $http.post(base_url + "artist_live/get_art_related_blog_list").then(function (success) {
            $scope.relatedBlog = success.data;
            $('#main_loader').hide();
            $('#main_page_load').show();
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