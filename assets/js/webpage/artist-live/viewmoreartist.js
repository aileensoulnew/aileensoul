app.controller('viewArtistController', function ($scope, $http) {   
});

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when("/artist/category", {
            templateUrl: category_url,
            controller: 'artistCategoryController'
        })
        .when("/artist/location", {
            templateUrl: base_url + "artist_live/location",
            controller: 'artistLocationController'
        })        
        .when("/artist", {
            templateUrl: base_url + "artist_live/artist_by_artist",
            controller: 'artistByArtistController'
        });   
    $locationProvider.html5Mode(true);
});

app.controller('artistCategoryController', function ($scope, $http) {
    $scope.$parent.title = 'Artist Category | Aileensoul';
    $scope.artistAllCategory = {};
    function artistAllCategory(){
        $http.get(base_url + "artist_live/artistAllCategory").then(function (success) {
            $scope.artistAllCategory = success.data;
            $('#main_loader').hide();
            $('#main_page_load').show();
        }, function (error) {});
    }
    artistAllCategory();
    function otherCategoryCount(){
        $http.get(base_url + "artist_live/otherCategoryCount").then(function (success) {
            $scope.otherCategoryCount = success.data;
        }, function (error) {});
    }
    otherCategoryCount();
});


app.controller('artistLocationController', function ($scope, $window, $http) {
    $scope.$parent.title = 'Artist Location | Aileensoul';
    $scope.artistAllLocation = {};
    $scope.artist = {};
    var isProcessing = false;
    // GET ALL LOCATION LIST FOR ARTIST
    function artistAllLocation(pagenum){
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "artist_live/artistAllLocationList?page="+pagenum).then(function (success) {
            data = success.data;
            if(data.art_loc.length > 0)
            {                    
                if(pagenum > 1)
                {
                    for (var i in data.art_loc) {                            
                        $scope.artistAllLocation.push(data.art_loc[i]);
                    }
                }
                else
                {
                    $scope.artistAllLocation = data.art_loc;
                }
                $scope.artist.page_number = pagenum;
                $scope.artist.total_record = data.total_record;
                $scope.artist.perpage_record = 5;            
                isProcessing = false;
            }
            else
            {
                $scope.showLoadmore = false;                
            }
            $('#main_loader').hide();
            $('#main_page_load').show();
            // $scope.artistAllLocation = success.data;
        }, function (error) {});
    }
    artistAllLocation(1);

    angular.element($window).bind("scroll", function (e) {        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7) {            
            isLoadingData = true;
            var page = $scope.artist.page_number;
            var total_record = $scope.artist.total_record;
            var perpage_record = $scope.artist.perpage_record;            
            if (parseInt(perpage_record * page) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum =  $scope.artist.page_number + 1;
                    artistAllLocation(pagenum);
                }
            }
        }
    });

});

app.controller('artistByArtistController', function ($scope, $http) {
    $scope.$parent.title = 'Artist | Aileensoul';
    $scope.artistByArtist = {};
    var isProcessing = false;
    function artistWithLocation(pagenum = "") {
        if (isProcessing) {            
            return;
        }
        $('#loader').show();
        isProcessing = true;
        $http.get(base_url + "artist_live/artist_by_category_location_ajax?page=" + pagenum).then(function (success) {
            $scope.artistByArtist = data = success.data;
            $('#main_loader').hide();
            $('#main_page_load').show();
        }, function (error) {});
    }
    artistWithLocation(1);  
});



$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});