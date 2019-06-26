//AJAX DATA LOAD BY LAZZY LOADER START
var isProcessing = false;
var main_page_number = "";
var main_total_record = "";
var main_perpage_record = "";
$(document).ready(function () {
    notificatin_ajax_data();
    
    $(window).scroll(function () {        
        if (($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.7)) {

            var page = main_page_number;//$(".page_number:last").val();
            var total_record = main_total_record;//$(".total_record").val();
            var perpage_record = main_perpage_record;//$(".perpage_record").val();
            if (parseInt(perpage_record) <= parseInt(total_record)) {
                var available_page = total_record / perpage_record;
                available_page = parseInt(available_page, 10);
                var mod_page = total_record % perpage_record;
                if (mod_page > 0) {
                    available_page = available_page + 1;
                }
                //if ($(".page_number:last").val() <= $(".total_record").val()) {
                if (parseInt(page) <= parseInt(available_page)) {
                    var pagenum = parseInt(main_page_number) + 1;
                    notificatin_ajax_data(pagenum);
                }
            }
        }
    });
});
    function notificatin_ajax_data(pagenum) {
    if (isProcessing) {
        return;
    }
    isProcessing = true;
    $.ajax({
        type: 'POST',
        url: base_url + "notification/ajax_notification_data?page=" + pagenum,
        data: {total_record: $("#total_record").val()},
        dataType: "json",
        beforeSend: function () {
            if (pagenum == 'undefined') {
                 $(".notification_data").prepend('<p style="text-align:center;"><img class="loader" src="' + base_url + 'images/loading.gif"/></p>');
            } else {
                $('#loader').show();
           }
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function (data) {
            $('.loader').remove();
            $('.notification_data').append(data.notification);
            /*if(pagenum == undefined || pagenum == 'undefined')
            {                
                main_page_number = data.page;
            }
            else
            {
            }*/
            main_page_number = data.page;
            main_total_record = data.total_record;
            main_perpage_record = data.perpage;

            // second header class add for scroll
            var nb = $('.post-design-box').length;
            if (nb == 0) {
                $("#dropdownclass").addClass("no-post-h2");
            } else {
                $("#dropdownclass").removeClass("no-post-h2");
            }
            isProcessing = false;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            setTimeout(function(){
                isProcessing = false;
                notificatin_ajax_data(pagenum);
            },500);
        }
    });
}
//AJAX DATA LOAD BY LAZZY LOADER END

