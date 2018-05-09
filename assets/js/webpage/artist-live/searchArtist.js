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


//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD START
$(function() {
    var tempcategory = [];  
    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) { 
        return split( term ).pop();
    }
    $( ".artist_search_category" ).bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    })
    .autocomplete({
       
        minLength: 2,
        source: function( request, response ) { 
            // delegate back to autocomplete, but extract the last term
            $.getJSON(base_url + "artist/artistic_search_keyword", { term : extractLast( (request.term).trim() )},response);
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
           
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
});

//SCRIPT FOR AUTOFILL OF SEARCH KEYWORD END


//SCRIPT FOR CITY AUTOFILL OF SEARCH START

$(function() {
    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) { 
        return split( term ).pop();
    }
    $( ".artist_search_location" ).bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    })
    .autocomplete({
        minLength: 2,
        source: function( request, response ) { 
            // delegate back to autocomplete, but extract the last term
            $.getJSON(base_url + "artist/artistic_search_city", { term : extractLast( request.term )},response);
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
           
            var terms = split( this.value );
            if(terms.length <= 1) {
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push( ui.item.value );
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( "" );
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