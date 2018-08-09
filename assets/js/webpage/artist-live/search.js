app.controller('artistSearchListController', function ($scope, $http) {
    $scope.title = title;
    $scope.artistCategory = {};
    $scope.artistLocation = {};
    $scope.searchtitle = '';
    $scope.categorysearch = '';
    $scope.locationsearch = '';
    // $scope.artistList = {};
    searchArtist();
    function artistCategory() {
        $http.get(base_url + "artist_live/artistCategory?limit=5").then(function (success) {
            $scope.artistCategory = success.data;
            $($scope.artistCategory).each(function(i,d){
                d.isselected = false;
            });
        }, function (error) {});
    }
    artistCategory();
    function otherCategoryCount() {
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
    function searchArtist() {
        var search_data_url = '';
        if (q != '' && l == '') {
            search_data_url = base_url + 'artist_live/searchArtistData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'artist_live/searchArtistData?l=' + l;
        } else {
            search_data_url = base_url + 'artist_live/searchArtistData?q=' + q + '&l=' + l;
        }
        getsearchresultlist(search_data_url,'pageload');
    }
    

    // Search result text
    function searchResultText(){
        $scope.categorysearch = q.replace(/,/gi,' , ');
        $scope.locationsearch = l.replace(/,/gi,' , ');
        $scope.searchtitle = ($scope.categorysearch && $scope.locationsearch) ? (' for ' + $scope.categorysearch + ' in ' + $scope.locationsearch) : (($scope.categorysearch) ? $scope.categorysearch : $scope.locationsearch); 
    }
    searchResultText();

    $scope.getfilterartistdata = function(){
        var location = "";
        // Get Checked Location of filter and make data value for ajax call
        $('.locationcheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                var urllocation_id = l.split(",");
                if (urllocation_id.indexOf(currentid) === -1) {
                    location += (location == "") ? currentid : "," + currentid;
                }
            }
        });

        // Get Checked Category of filter and make data value for ajax call
        var category = "";
        $('.categorycheckbox').each(function(){
            if(this.checked){
                var currentid = $(this).val();
                var urlcategory_id = q.split(",");
                if (urlcategory_id.indexOf(currentid) === -1) {
                    category += (category == "") ? currentid : "," + currentid;
                }
            }
        });

        var search_data_url = '';
        if (q != '' && l == '') {
            search_data_url = base_url + 'artist_live/searchArtistData?q=' + q;
        } else if (q == '' && l != '') {
            search_data_url = base_url + 'artist_live/searchArtistData?l=' + l;
        } else {
            search_data_url = base_url + 'artist_live/searchArtistData?q=' + q + '&l=' + l;
        }

        // if filter apply append id of category and location
        if(location != ""){
            search_data_url += "&location_id=" + location;
        }
        if(category != ""){
            search_data_url += "&category_id=" + category;
        }
        getsearchresultlist(search_data_url,'filter');        
    }

    function getsearchresultlist(search_url, from){
        $("#loader").removeClass("hidden");
        $('#main_loader').show();
        $http.get(search_url).then(function (success) {
            $("#loader").addClass("hidden");
            $('#main_loader').hide();
            // $('#main_page_load').show();
            $('body').removeClass("body-loader");
            if (from == 'filter') {
                $scope.artistList = {};    
            }
            $scope.artistList = success.data;
        }, function (error) {});
    }

});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
    $('#q').val(q);
    $('#l').val(l);
});

// change location
$(document).on('change','.locationcheckbox,.categorycheckbox',function(){
    var self = this;
    // self.setAttribute('checked',(this.checked));
    angular.element(self).scope().getfilterartistdata();
});
