app.controller('searchJobController', function ($scope, $window) {
    $scope.keyword = q;
    $scope.city = l;
    $scope.fulltime = w.split('+')[0];
    $scope.parttime = w.split('+')[1];
    $scope.internship = w.split('+')[2];
    
    $scope.searchSubmit = function () {

        var keyword = $scope.keyword.toLowerCase().split(' ').join('+');
        var city = $scope.city.toLowerCase().split(' ').join('+');
        var fulltime = $scope.fulltime;
        var parttime = $scope.parttime;
        var internship = $scope.internship;

        var work_type = '';
        fulltime1 = '';
        if (fulltime == '1') {
            var fulltime1 = 'fulltime+';
        }
        parttime1 = '';
        if (parttime == '1') {
            var parttime1 = 'parttime+';
        }
        internship1 = '';
        if (internship == '1') {
            var internship1 = 'internship+';
        }
        var work_type = work_type.concat(fulltime1, parttime1, internship1);
        var n = work_type.lastIndexOf("+");
        var work_type = work_type.substring(0, n);
        
        if (keyword == '' && city == '' && work_type == '') {
            return false;
        } else if (keyword != '' && city == '' && work_type == '') {
            $window.location.href = base_url + 'job/search?q=' + keyword;
        } else if (keyword == '' && city != '' && work_type == '') {
            $window.location.href = base_url + 'job/search?l=' + city;
        } else if (keyword == '' && city == '' && work_type != '') {
            $window.location.href = base_url + 'job/search?w=' + work_type;
        } else {
            $window.location.href = base_url + 'job/search?q=' + keyword + '&l=' + city + '&w=' + work_type;
        }
    }
    
});
$(function() {
    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) { 
        return split( term ).pop();
    }
    $( "#job_keyword" ).focusout(function() {
        if($( "#job_keyword" ).val() != "")
        {
            var ser_val = $( "#job_keyword" ).val();            
            ser_val_ = ser_val.substring(0, ser_val.length-1);            
            $( "#job_keyword" ).val(ser_val_)
        }
    });
    $( "#job_keyword" ).focusin(function() {
        if($( "#job_keyword" ).val() != "")
        {
            var ser_val = $( "#job_keyword" ).val();            
            ser_val_ = ser_val+",";
            $( "#job_keyword" ).val(ser_val_)
        }
    });
    $( "#job_keyword" ).bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    })
    .autocomplete({
        minLength: 2,
        source: function( request, response ) { 
            // delegate back to autocomplete, but extract the last term
            terms = extractLast( request.term );                
            if(terms != "")
            {                    
                $.getJSON(base_url + "job_live/job_search_keyword", { term : terms},response);
            }
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {

            var terms = split( this.value.toLowerCase() );
            // remove the current input
            terms.pop();
            // add the selected item

            var uniqueNames = [];
            $.each(terms, function(i, el){
                if($.inArray(el.toLowerCase(), uniqueNames) === -1) uniqueNames.push(el);
            });

            uniqueNames.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            uniqueNames.push( "" );
            this.value = uniqueNames.join( "," );
            return false;                
        }
    });

    $( "#job_location" ).focusout(function() {
        if($( "#job_location" ).val() != "")
        {
            var ser_val = $( "#job_location" ).val();            
            ser_val_ = ser_val.substring(0, ser_val.length-1);            
            $( "#job_location" ).val(ser_val_)
        }
    });
    $( "#job_location" ).focusin(function() {
        if($( "#job_location" ).val() != "")
        {
            var ser_val = $( "#job_location" ).val();            
            ser_val_ = ser_val+",";
            $( "#job_location" ).val(ser_val_)
        }
    });
    $( "#job_location" ).bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    })
    .autocomplete({
        minLength: 2,
        source: function( request, response ) { 
            // delegate back to autocomplete, but extract the last term
            terms = extractLast( request.term );                
            if(terms != "")
            {                    
                $.getJSON(base_url + "job_live/job_search_city", { term : terms},response);
            }
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {

            var terms = split( this.value.toLowerCase() );
            // remove the current input
            terms.pop();
            // add the selected item

            var uniqueNames = [];
            $.each(terms, function(i, el){
                if($.inArray(el.toLowerCase(), uniqueNames) === -1) uniqueNames.push(el);
            });

            uniqueNames.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            uniqueNames.push( "" );
            this.value = uniqueNames.join( "," ).toLowerCase();
            return false;                
        }
    });
});