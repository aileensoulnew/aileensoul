var conn_new = new Strophe.Connection('http://127.0.0.1:7070/http-bind/');
// var conn_new = new Strophe.Connection('https://52.43.64.56:7443/http-bind/');
//var conn_new = new Strophe.Connection('http://52.43.64.56:7070/http-bind/');
var to_main_jid = '';
var to_dhash_jid = '';
var login_jid = '';
var Gab = {
    connection: null,

    jid_to_id: function (jid) {
        return Strophe.getBareJidFromJid(jid)
            .replace(/@/g, "-")
            .replace(/\./g, "-");
    },

    on_roster: function (iq) {
        $(iq).find('item').each(function () {
            var jid = $(this).attr('jid');
            var name = $(this).attr('name') || jid;

            // transform jid into an id
            var jid_id = Gab.jid_to_id(jid);

            var contact = $("<li id='" + jid_id + "'>" +
                            "<div class='roster-contact offline'>" +
                            "<div class='roster-name'>" +
                            name +
                            "</div><div class='roster-jid'>" +
                            jid +
                            "</div></div></li>");

            Gab.insert_contact(contact);
        });

        // set up presence handler and send initial presence
        Gab.connection.addHandler(Gab.on_presence, null, "presence");
        Gab.connection.send($pres());
    },

    pending_subscriber: null,

    on_presence: function (presence) {
        var ptype = $(presence).attr('type');
        var from = $(presence).attr('from');
        var jid_id = Gab.jid_to_id(from);

        if (ptype === 'subscribe') {
            // populate pending_subscriber, the approve-jid span, and
            // open the dialog
            Gab.pending_subscriber = from;
            $('#approve-jid').text(Strophe.getBareJidFromJid(from));
            $('#approve_dialog').dialog('open');
        } else if (ptype !== 'error') {
            var contact = $('#roster-area li#' + jid_id + ' .roster-contact')
                .removeClass("online")
                .removeClass("away")
                .removeClass("offline");
            if (ptype === 'unavailable') {
                contact.addClass("offline");
            } else {
                var show = $(presence).find("show").text();
                if (show === "" || show === "chat") {
                    contact.addClass("online");
                } else {
                    contact.addClass("away");
                }
            }

            var li = contact.parent();
            li.remove();
            Gab.insert_contact(li);
        }

        // reset addressing for user since their presence changed
        var jid_id = Gab.jid_to_id(from);
        $('#chat-' + jid_id).data('jid', Strophe.getBareJidFromJid(from));

        return true;
    },

    on_roster_changed: function (iq) {
        $(iq).find('item').each(function () {
            var sub = $(this).attr('subscription');
            var jid = $(this).attr('jid');
            var name = $(this).attr('name') || jid;
            var jid_id = Gab.jid_to_id(jid);

            if (sub === 'remove') {
                // contact is being removed
                $('#' + jid_id).remove();
            } else {
                // contact is being added or modified
                var contact_html = "<li id='" + jid_id + "'>" +
                    "<div class='" + 
                    ($('#' + jid_id).attr('class') || "roster-contact offline") +
                    "'>" +
                    "<div class='roster-name'>" +
                    name +
                    "</div><div class='roster-jid'>" +
                    jid +
                    "</div></div></li>";

                if ($('#' + jid_id).length > 0) {
                    $('#' + jid_id).replaceWith(contact_html);
                } else {
                    Gab.insert_contact($(contact_html));
                }
            }
        });

        return true;
    },

    on_message: function (message) {
        
        var full_jid = $(message).attr('from');
        var jid = Strophe.getBareJidFromJid(full_jid);
        var jid_id = Gab.jid_to_id(jid);

        /*if ($('#chat-' + jid_id).length === 0) {
            // $('#chat-area').tabs('add', '#chat-' + jid_id, jid);
            // $('#chat-' + jid_id).append(
            //     "<div class='chat-messages'></div>" +
            //     "<input type='text' class='chat-input'>");

            var tabs = $( "#chat-area" ).tabs();
            var ul = tabs.find( "ul" );
            $( "<li><a href='#chat-"+jid_id+"'>"+jid.split('@')[0]+"</a></li>" ).appendTo( ul );

            $('#chat-area').append("<div id='chat-" + jid_id+"' data='" + jid_id+"'><div class='chat-messages'></div><input type='text' class='chat-input'></div>");

            tabs.tabs( "refresh" );
        }*/
        
        $('#chat-' + jid_id).data('jid', full_jid);

        // $('#chat-area').tabs('select', '#chat-' + jid_id);
        $('#chat-' + jid_id + ' input').focus();

        var composing = $(message).find('composing');
        if (composing.length > 0) {
            $('.chat-event').html(Strophe.getNodeFromJid(jid)+" is typing...");
            // Gab.scroll_chat(jid_id);
        }

        var paused = $(message).find('paused');
        if (paused.length > 0) {
            $('.chat-event').html("");
            // Gab.scroll_chat(jid_id);
        }

        var body = $(message).find("html > body");

        if (body.length === 0) {
            body = $(message).find('body');
            if (body.length > 0) {
                body = body.text()
            } else {
                body = null;
            }
        } else {
            body = body.contents();

            var span = $("<span></span>");
            body.each(function () {
                if (document.importNode) {
                    $(document.importNode(this, true)).appendTo(span);
                } else {
                    // IE workaround
                    span.append(this.xml);
                }
            });

            body = span;
        }

        if (body) {
            // remove notifications since user is now active
            // $('#chat-' + jid_id + ' .chat-event').remove();
            $('.chat-event').html("");

            // add the new message
            $('#chat-' + jid_id + ' .chat-messages').append(
                "<div class='chat-message'>" +
                "&lt;<span class='chat-name'>" +
                Strophe.getNodeFromJid(jid) +
                "</span>&gt;<span class='chat-text'>" +
                "</span></div>");

            $('#chat-' + jid_id + ' .chat-message:last .chat-text')
                .append(decodeURIComponent(body));

            Gab.scroll_chat(jid_id);
        }

        return true;
    },

    scroll_chat: function (jid_id) {
        // var div = $('#chat-' + jid_id + ' .chat-messages').get(0);
        // div.scrollTop = div.scrollHeight;
        $('#chat-' + jid_id + ' .chat-messages')[0].scrollTop = $('#chat-' + jid_id + ' .chat-messages')[0].scrollHeight
    },


    presence_value: function (elem) {
        if (elem.hasClass('online')) {
            return 2;
        } else if (elem.hasClass('away')) {
            return 1;
        }

        return 0;
    },

    insert_contact: function (elem) {
        var jid = elem.find('.roster-jid').text();
        var pres = Gab.presence_value(elem.find('.roster-contact'));
        
        var contacts = $('#roster-area li');

        if (contacts.length > 0) {
            var inserted = false;
            contacts.each(function () {
                var cmp_pres = Gab.presence_value(
                    $(this).find('.roster-contact'));
                var cmp_jid = $(this).find('.roster-jid').text();

                if (pres > cmp_pres) {
                    $(this).before(elem);
                    inserted = true;
                    return false;
                } else if (pres === cmp_pres) {
                    if (jid < cmp_jid) {
                        $(this).before(elem);
                        inserted = true;
                        return false;
                    }
                }
            });

            if (!inserted) {
                $('#roster-area ul').append(elem);
            }
        } else {
            $('#roster-area ul').append(elem);
        }
    }
};

$(document).ready(function () {
    $(document).trigger('connect', {
        jid: username+'@127.0.0.1',
        password: username
    });
    /*$('#login_dialog').dialog({
        autoOpen: true,
        draggable: false,
        modal: true,
        closeOnEscape: false,
        open: function(event, ui) {
            $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
        },
        title: 'Connect to XMPP',
        buttons: {
            "Connect": function () {
                $(document).trigger('connect', {
                    jid: $('#jid').val().toLowerCase(),
                    password: $('#password').val()
                });
                
                $('#password').val('');
                $(this).dialog('close');
            },            
        }
    });*/

    $('#contact_dialog').dialog({
        autoOpen: false,
        draggable: false,
        modal: true,
        title: 'Add a Contact',
        buttons: {
            "Add": function () {
                $(document).trigger('contact_added', {
                    jid: $('#contact-jid').val().toLowerCase(),
                    name: $('#contact-name').val()
                });

                $('#contact-jid').val('');
                $('#contact-name').val('');
                
                $(this).dialog('close');
            }
        }
    });

    $('#new-contact').click(function (ev) {
        $('#contact_dialog').dialog('open');
    });

    $('#approve_dialog').dialog({
        autoOpen: false,
        draggable: false,
        modal: true,
        title: 'Subscription Request',
        buttons: {
            "Deny": function () {
                Gab.connection.send($pres({
                    to: Gab.pending_subscriber,
                    "type": "unsubscribed"}));
                Gab.pending_subscriber = null;

                $(this).dialog('close');
            },

            "Approve": function () {
                Gab.connection.send($pres({
                    to: Gab.pending_subscriber,
                    "type": "subscribed"}));

                Gab.connection.send($pres({
                    to: Gab.pending_subscriber,
                    "type": "subscribe"}));
                
                Gab.pending_subscriber = null;

                $(this).dialog('close');
            }
        }
    });

    $('#chat-area').tabs().find('.ui-tabs-nav').sortable({axis: 'x'});

    $(document).on('click','.roster-contact',function () {
        var jid = $(this).find(".roster-jid").text();
        var name = $(this).find(".roster-name").text();
        var jid_id = Gab.jid_to_id(jid);
        to_main_jid = jid;
        to_dhash_jid = jid_id;
            // if ($('#chat-' + jid_id).length === 0) {            
            // $('#chat-area').tabs('add', '#chat-' + jid_id, name);            
            // $('#chat-' + jid_id).data('jid', jid);

            var tabs = $( "#chat-area" ).tabs();
            var ul = tabs.find( "ul" );
            // $( "<li><a href='#chat-"+jid_id+"'>"+name+"</a></li>" ).appendTo( ul );
            $( ul ).html( "<li><a href='#chat-"+jid_id+"'>"+name+"</a></li>" );

            $('#chat-messages').html("<div id='chat-" + jid_id+"' data='" + jid_id+"'><div class='chat-messages'></div><input type='text' class='chat-input'></div>");

            get_messages(jid)
            tabs.tabs( "refresh" );
            $('#chat-area').tabs({ active: 0 });

            $('.chat-input').keyup( function (ev) {
                var jid = $(this).parent().data('jid');
                if (ev.which === 13) {                    
                    ev.preventDefault();

                    var body = $(this).val();
                    if(body == "" || body == undefined)
                    {
                        return false;
                    }

                    var message = $msg({to: to_main_jid,"type": "chat"})
                        .c('body').t(encodeURIComponent(body)).up()
                        .c('active', {xmlns: "http://jabber.org/protocol/chatstates"});
                    Gab.connection.send(message);                    

                    $(this).parent().find('.chat-messages').append(
                        "<div class='chat-message'>&lt;" +
                        "<span class='chat-name me'>" + 
                        Strophe.getNodeFromJid(Gab.connection.jid) +
                        "</span>&gt;<span class='chat-text'>" +
                        decodeURIComponent(body) +
                        "</span></div>");                    
                    Gab.scroll_chat(to_dhash_jid);

                    $(this).val('');
                    $(this).parent().data('composing', false);
                } else {
                    if($(this).val() != "")
                    {                        
                        var composing = $(this).parent().data('composing');
                        if (!composing && $('.chat-event').html() == '') {
                            /*var notify = $msg({to: to_main_jid, "type": "chat"})
                                .c('composing', {xmlns: "http://jabber.org/protocol/chatstates"});*/
                            // Gab.connection.send(notify);
                            // $(this).parent().data('composing', true);
                            Gab.connection.chatstates.sendComposing(to_main_jid,'chat');
                        }
                    }
                    else
                    {
                        Gab.connection.chatstates.sendPaused(to_main_jid,'chat');
                    }
                }
            });
        //}
        // $('#chat-area').tabs('select', '#chat-' + jid_id);

        // $('#chat-' + jid_id + ' input').focus();
    });

    

    $('#disconnect').click(function () {
        Gab.connection.disconnect();
        Gab.connection = null;
    });

    $('#chat_dialog').dialog({
        autoOpen: false,
        draggable: false,
        modal: true,
        title: 'Start a Chat',
        buttons: {
            "Start": function () {
                var jid = $('#chat-jid').val().toLowerCase();
                var jid_id = Gab.jid_to_id(jid);

                $('#chat-area').tabs('add', '#chat-' + jid_id, jid);
                $('#chat-' + jid_id).append(
                    "<div class='chat-messages'></div>" +
                    "<input type='text' class='chat-input'>");
            
                $('#chat-' + jid_id).data('jid', jid);
            
                $('#chat-area').tabs('select', '#chat-' + jid_id);
                $('#chat-' + jid_id + ' input').focus();
            
            
                $('#chat-jid').val('');
                
                $(this).dialog('close');
            }
        }
    });

    $('#new-chat').click(function () {
        $('#chat_dialog').dialog('open');
    });
});

$(document).bind('connect', function (ev, data) {
    //var conn = new Strophe.Connection('http://bosh.metajack.im:5280/xmpp-httpbind');
    // var conn = new Strophe.Connection('https://52.43.64.56:7443/http-bind/');
    // var conn = new Strophe.Connection('http://52.43.64.56:7070/http-bind/');
    var conn = new Strophe.Connection('http://127.0.0.1:7070/http-bind/');

    conn.connect(data.jid, data.password, function (status) {
        if (status === Strophe.Status.CONNECTED) {
            login_jid = data.jid;
            $(document).trigger('connected');
        } else if (status === Strophe.Status.DISCONNECTED) {
            $(document).trigger('disconnected');
        }
    });

    Gab.connection = conn;
});

$(document).bind('connected', function () {
    $("#login_user").text("Welcome "+login_jid);
    var iq = $iq({type: 'get'}).c('query', {xmlns: 'jabber:iq:roster'});
    Gab.connection.sendIQ(iq, Gab.on_roster);

    Gab.connection.addHandler(Gab.on_roster_changed,"jabber:iq:roster", "iq", "set");

    Gab.connection.addHandler(Gab.on_message,null, "message", "chat");
});

$(document).bind('disconnected', function () {
    Gab.connection = null;
    Gab.pending_subscriber = null;

    $('#roster-area ul').empty();
    $('#chat-area ul').empty();
    $('#chat-area div').remove();

    $('#login_dialog').dialog('open');
});

$(document).bind('contact_added', function (ev, data) {
    var iq = $iq({type: "set"}).c("query", {xmlns: "jabber:iq:roster"})
        .c("item", data);
    Gab.connection.sendIQ(iq);
    
    var subscribe = $pres({to: data.jid, "type": "subscribe"});
    Gab.connection.send(subscribe);
});
function get_messages(to_jid)
{    
    $.ajax({
        url: base_url+"message/get_messages_from_jid",        
        type: "POST",
        data: {"login_jid":login_jid,"to_jid": to_jid},
        success: function (data) {
            // console.log(data);            
            setTimeout(function(){
                $('.chat-messages').html(data);
                $('.chat-messages')[0].scrollTop = $('.chat-messages')[0].scrollHeight;
            },100);
        }
    });
}