app.controller('businessController', function ($scope, $http) {
    $scope.title = title;
    $scope.businessCategory = {};
    
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
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});

// NEW HTML SCRIPTS
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
  container.appendChild(item);
  itemsCounter++;
}