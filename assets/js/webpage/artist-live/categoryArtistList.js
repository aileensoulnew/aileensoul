app.controller('artistListController', function ($scope, $http) {
    $scope.title = title;
    $scope.artistCategory = {};
    $scope.artistLocation = {};
    $scope.urlcategory_id = category_id;
    $scope.urllocation_id = location_id;
    var filterajax = false;
    function artistCategory(){
        $http.get(base_url + "artist_live/artistCategory?q=" + q + "&limit=5").then(function (success) {
            $scope.artistCategory = success.data;
            $($scope.artistCategory).each(function(i,d){
                d.isselected = false;
            });
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
            $(success.data).each(function(i,d){
                d.isselected = false;
            });
            $scope.artistLocation = success.data;
        }, function (error) {});
    }
    artistLocation();
    // Category wise artist list
    function categoryArtistList(){
        $http.get(base_url + "artist_live/artistListByCategory/" + category_id).then(function (success) {
            $scope.ArtistList = success.data;
            $("#loader").addClass("hidden");
        }, function (error) {});
    }

    // Location  artist list
    function locationwiseArtistList(){
        $http.get(base_url + "artist_live/artistListByLocation/" + location_id).then(function (success) {
            $scope.ArtistList = success.data;
            $("#loader").addClass("hidden");
        }, function (error) {});
    }

    if(location_id == "" || !location_id){
        $("#loader").removeClass("hidden");
        categoryArtistList();
    }else{
        $("#loader").removeClass("hidden");
        locationwiseArtistList();
    }
    $scope.getfilterartistdata = function(){
        var location = location_id;
        // Get Checked Location of filter and make data value for ajax call
        $('.locationcheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                var urllocation_id = location_id.split(",");
                if (urllocation_id.indexOf(currentid) === -1) {
                    location += (location == "") ? currentid : "," + currentid;
                }
            }
        });

        // Get Checked Category of filter and make data value for ajax call
        var category = category_id;
        $('.categorycheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                var urlcategory_id = category_id.split(",");
                if (urlcategory_id.indexOf(currentid) === -1) {
                    category += (category == "") ? currentid : "," + currentid;
                }
            }
        });

        var datavalue = new FormData();
        datavalue.append('category_id', category);
        datavalue.append('location_id', location);
        $("#loader").removeClass("hidden");
        filterajax = $http.post(base_url + "artist_live/artistListByFilter/", datavalue,
            {
                            transformRequest: angular.identity,

                            headers: {'Content-Type': undefined, 'Process-Data': false}
            }).then(function (success) {
            $("#loader").addClass("hidden");
            $scope.ArtistList = success.data;
        }, function (error) {}
        , function (complete) { filterajax = false; });
    }
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});

// change location
$(document).on('change','.locationcheckbox,.categorycheckbox',function(){
    var self = this;
    // self.setAttribute('checked',(this.checked));
    angular.element(self).scope().getfilterartistdata();
});
