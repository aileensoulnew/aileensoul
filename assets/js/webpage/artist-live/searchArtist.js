app.controller('searchArtistController', function ($scope, $window) {
    $scope.keyword = q;
    $scope.city = l;
    $scope.searchSubmit = function () {
        
        var keyword = $scope.keyword.toLowerCase().split(' ').join('+');
        var city = $scope.city.toLowerCase().split(' ').join('+');

        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            $window.location.href = base_url + 'artist/search?q=' + keyword;
        } else if (keyword == '' && city != '') {
            $window.location.href = base_url + 'artist/search?l=' + city;
        } else {
            $window.location.href = base_url + 'artist/search/' + keyword + '-in-' + city;
        }
    }
});
    
    // New design script

    $('#content').on( 'change keyup keydown paste cut', 'textarea', function (){
        $(this).height(0).height(this.scrollHeight);
    }).find( 'textarea' ).change();

    AOS.init({
        easing: 'ease-in-out-sine'
    });

    setInterval(addItem, 100);

    var itemsCounter = 1;
    var container = document.getElementById('aos-demo');

    function addItem () {
        if (itemsCounter > 42) return;
        var item = document.createElement('div');
        item.classList.add('aos-item');
        item.setAttribute('data-aos', 'fade-up');
        item.innerHTML = '<div class="aos-item__inner"><h3>' + itemsCounter + '</h3></div>';
        // container.appendChild(item);
        itemsCounter++;
  }