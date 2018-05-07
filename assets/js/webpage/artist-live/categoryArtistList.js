app.controller('artistListController', function ($scope, $http) {
    $scope.title = title;
    $scope.artistCategory = {};
    $scope.artistLocation = {};
    function artistCategory(){
        $http.get(base_url + "artist_live/artistCategory?limit=5").then(function (success) {
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

    // ARTIST CITY FILTER
    function artistLocation(){
        $http.get(base_url + "artist_live/artistAllLocation?limit=5").then(function (success) {
            $scope.artistLocation = success.data;
        }, function (error) {});
    }
    artistLocation();
    // Category wise artist list
    function categoryArtistList(){
        $http.get(base_url + "artist_live/artistListByCategory/" + category_id).then(function (success) {
            $scope.ArtistList = success.data;
        }, function (error) {});
    }

    // Location  artist list
    function locationwiseArtistList(){
        $http.get(base_url + "artist_live/artistListByLocation/" + location_id).then(function (success) {
            $scope.ArtistList = success.data;
        }, function (error) {});
    }

    if(location_id == "" || !location_id){
        categoryArtistList();
    }else{
        locationwiseArtistList();
    }
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});