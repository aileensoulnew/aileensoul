app.controller('searchBusinessController', function ($scope, $window) {
    $scope.keyword = q;
    $scope.city = l;
    $scope.searchSubmit = function () {
        var keyword = $scope.keyword.toLowerCase().split(' ').join('+');
        var city = $scope.city.toLowerCase().split(' ').join('+');
        if (keyword == '' && city == '') {
            return false;
        } else if (keyword != '' && city == '') {
            $window.location.href = base_url + 'business/search/' + keyword;
        } else if (keyword == '' && city != '') {
            $window.location.href = base_url + 'business/search/' + city;
        } else {
            $window.location.href = base_url + 'business/search/' + keyword + '-in-' + city;
        }
    }
});

// SEARCH BANNER SUGGESTIONS
$(function () {
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    /* first box */
    $(".business_category").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
    .autocomplete({
        minLength: 1,
        source: function (request, response) {
            // delegate back to autocomplete, but extract the last term
            var searchTerm = (request.term).toLowerCase();
            $.getJSON(base_url + "business_profile/ajax_business_skill", {term: extractLast(searchTerm)}, response);
        },
        focus: function () {
            // prevent value inserted on focus
            return false;
        },
        select: function (event, ui) {
            var terms = split( this.value );
            var termslength = terms.length; 
            if(terms.length <= 4) {
                // remove the current input
                terms.pop();
                // terms.push("");
                // add the selected item
                terms.push((ui.item.value).trim());
                if(termslength <= 1){
                    this.value = terms.join("");
                }else{
                    this.value = terms.join(",");
                }
                return false;
            }else{
                var last = terms.pop();
                $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                $(this).effect("highlight", {}, 1000);
                $(this).attr("style","border: solid 1px red;");
                return false;
            }
        }
    });
    /* first box*/
    /* location box*/
    $(".business_location").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    })
    .autocomplete({
        minLength: 1,
        source: function (request, response) {
            // delegate back to autocomplete, but extract the last term
            $.getJSON(base_url + "business_profile/ajax_location_data", {term: extractLast(request.term)}, response);
        },
        focus: function () {
            // prevent value inserted on focus
            return false;
        },
        select: function (event, ui) {
            var terms = split( this.value );
            var termslength = terms.length; 
            if(terms.length <= 4) {
                // remove the current input
                terms.pop();
                // terms.push("");
                // add the selected item
                terms.push((ui.item.value).trim());
                if(termslength <= 1){
                    this.value = terms.join("");
                }else{
                    this.value = terms.join(",");
                }
                return false;
            }else{
                var last = terms.pop();
                $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                $(this).effect("highlight", {}, 1000);
                $(this).attr("style","border: solid 1px red;");
                return false;
            }
        }
    });
    /* location box*/
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
  // container.appendChild(item);
  itemsCounter++;
}