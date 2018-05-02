
$(function () {
        // alert('hi');
        $("#searchplace").autocomplete({
            source: function (request, response) {
                var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                response($.grep(data1, function (item) {
                    return matcher.test(item.label);
                }));
            },
            minLength: 1,
            select: function (event, ui) {
                event.preventDefault();
                $("#searchplace").val(ui.item.label);
                $("#selected-tag").val(ui.item.label);
                // window.location.href = ui.item.value;
            }
            ,
            focus: function (event, ui) {
                event.preventDefault();
                $("#searchplace").val(ui.item.label);
            }
        });
    });

$(function () {
                // alert('hi');
                $("#tags").autocomplete({
                    source: function (request, response) {
                        var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                        response($.grep(data, function (item) {
                            return matcher.test(item.label);
                        }));
                    },
                    minLength: 1,
                    select: function (event, ui) {
                        event.preventDefault();
                        $("#tags").val(ui.item.label);
                        $("#selected-tag").val(ui.item.label);
                        // window.location.href = ui.item.value;
                    }
                    ,
                    focus: function (event, ui) {
                        event.preventDefault();
                        $("#tags").val(ui.item.label);
                    }
                });
            });

$(function () {
                        // alert('hi');
                        $("#searchplace1").autocomplete({
                            source: function (request, response) {
                                var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                                response($.grep(data1, function (item) {
                                    return matcher.test(item.label);
                                }));
                            },
                            minLength: 1,
                            select: function (event, ui) {
                                event.preventDefault();
                                $("#searchplace1").val(ui.item.label);
                                $("#selected-tag").val(ui.item.label);
                                // window.location.href = ui.item.value;
                            }
                            ,
                            focus: function (event, ui) {
                                event.preventDefault();
                                $("#searchplace1").val(ui.item.label);
                            }
                        });
                    });

$(function () {
                                // alert('hi');
                                $("#tags1").autocomplete({
                                    source: function (request, response) {
                                        var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                                        response($.grep(data, function (item) {
                                            return matcher.test(item.label);
                                        }));
                                    },
                                    minLength: 1,
                                    select: function (event, ui) {
                                        event.preventDefault();
                                        $("#tags1").val(ui.item.label);
                                        $("#selected-tag").val(ui.item.label);
                                        // window.location.href = ui.item.value;
                                    }
                                    ,
                                    focus: function (event, ui) {
                                        event.preventDefault();
                                        $("#tags1").val(ui.item.label);
                                    }
                                });
                            });


function check() {
    var keyword = $.trim(document.getElementById('tags1').value);
    var place = $.trim(document.getElementById('searchplace1').value);
    if (keyword == "" && place == "") {
        return false;
    }
}

function checkvalue(){ 
                                        //alert("hi");
                                        var searchkeyword = $.trim(document.getElementById('tags').value);
                                        var searchplace = $.trim(document.getElementById('searchplace').value);
                                        // alert(searchkeyword);
                                        // alert(searchplace);
                                        if (searchkeyword == "" && searchplace == ""){
                                //alert('Please enter Keyword');
                                return false;
                            }
                        }

// recruiter search header 2  start
// recruiter search header 2 location start

$(function () { 
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }

    $(".rec_search_loc").bind("keydown", function (event) { 
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
    }
})
    .autocomplete({
        minLength: 2,
        source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "recruiter/get_location", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var text = this.value;
                    var terms = split(this.value);

                    text = text == null || text == undefined ? "" : text;
                    var checked = (text.indexOf(ui.item.value + ', ') > -1 ? 'checked' : '');
                    if (checked == 'checked') {

                        terms.push(ui.item.value);
                        this.value = terms.split("");
                    }//if end

                    else {
                        if (terms.length <= 1) {
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push(ui.item.value);
                            // add placeholder to get the comma-and-space at the end
                            terms.push("");
                            this.value = terms.join("");
                            return false;
                        } else {
                            var last = terms.pop();
                            $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                            $(this).effect("highlight", {}, 1000);
                            $(this).attr("style", "border: solid 1px red;");
                            return false;
                        }
                    }
                }//end else
            });
});

// recruiter searc location end
// recruiter searc title start
$(function () { 
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }

    $(".rec_search_title").bind("keydown", function (event) { 
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
    }
})
    .autocomplete({
        minLength: 2,
        source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    $.getJSON(base_url + "recruiter/get_job_tile", {term: extractLast(request.term)}, response);
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {

                    var text = this.value;
                    var terms = split(this.value);

                    text = text == null || text == undefined ? "" : text;
                    var checked = (text.indexOf(ui.item.value + ', ') > -1 ? 'checked' : '');
                    if (checked == 'checked') {

                        terms.push(ui.item.value);
                        this.value = terms.split("");
                    }//if end

                    else {
                        if (terms.length <= 1) {
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push(ui.item.value);
                            // add placeholder to get the comma-and-space at the end
                            terms.push("");
                            this.value = terms.join("");
                            return false;
                        } else {
                            var last = terms.pop();
                            $(this).val(this.value.substr(0, this.value.length - last.length - 2)); // removes text from input
                            $(this).effect("highlight", {}, 1000);
                            $(this).attr("style", "border: solid 1px red;");
                            return false;
                        }
                    }
                }//end else
            });
});

// recruiter searc title end
// recruiter search end

//AJAX DATA LOAD BY LAZZY LOADER START
$(document).ready(function () {
    recommen_candidate_post();
    
    $(window).scroll(function () {
        
      if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.7){
            var page = $(".page_number:last").val();
            var total_record = $(".total_record").val();
            var perpage_record = $(".perpage_record").val();
            if (parseInt(perpage_record) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                //if ($(".page_number:last").val() <= $(".total_record").val()) {
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt($(".page_number:last").val()) + 1;
                    recommen_candidate_post(pagenum);
                }
            }
        }
    });
});
var isProcessing = false;
function recommen_candidate_post(pagenum) {
    if (isProcessing) {
        /*
         *This won't go past this condition while
         *isProcessing is true.
         *You could even display a message.
         **/
        return;
    }
    isProcessing = true;
    $.ajax({
        type: 'POST',
        url: base_url + "recruiter/recommen_candidate_post?page=" + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "html",
        beforeSend: function () {
            if (pagenum == 'undefined') {
                 $(".job-contact-frnd").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            } else {
                $('#loader').show();
           }
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) {
            $('.loader').remove();
            $('.job-contact-frnd').append(data);

            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            isProcessing = false;
        }
    });
}


function savepopup(abc)
{

    var saveid = document.getElementById("hideenuser" + abc);

    $.ajax({
        type: 'POST',
        url: base_url +'recruiter/save_search_user',
        data: 'user_id=' + abc + '&save_id=' + saveid.value,
        success: function (data) {
            $('.' + 'saveduser' + abc).html(data).addClass('saved');
            $('.biderror .mes').html("<div class='pop_content'>Candidate successfully saved.");
            $('#bidmodal').modal('show');
        }
    });
}
