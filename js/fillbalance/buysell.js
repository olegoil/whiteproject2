$(function() {

    setTimeout(function() {
        App.getEtherBalance();
        App.getBalance();
    }, 2000);

    jQuery.ajax({
        dataType: 'json',
        type: 'get',
        url: 'https://api.coinmarketcap.com/v2/ticker/?limit=10',
        data: 1,
        success: function(res) {
        $.each(res.data, function(index, val) {
            if(val.name == 'Bitcoin') {
            bitcoincost = val.quotes.USD.price;
            // $('.bitcoin').html(val.quotes.USD.price);
            exchangebtc = exchangebtc/bitcoincost;
            $('#moneysellBTC').val(exchangebtc);
            }
            else if (val.name == 'Ethereum') {
            ethercost = val.quotes.USD.price;
            // $('.ether').html(val.quotes.USD.price);
            exchangeeth = exchangeeth/ethercost;
            }
            // console.log(val);
        });
        },
        error: function(err) {
        console.log('ERR '+JSON.stringify(err))
        }
    });

    $('#moneysell').keyup(function() {
        var recalcres = ($('#moneysell').val() / exchangeusd).toFixed(8);
        $('#wcbuy').val(recalcres);
        $('#commissionsP').html(($('#moneysell').val()/100*percentage).toFixed(2));
    });

    $('#wcbuy').keyup(function() {
        var recalcres = ($('#wcbuy').val() * exchangeusd).toFixed(8);
        $('#moneysell').val(recalcres);
        $('#commissionsP').html((recalcres/100*percentage).toFixed(2));
    });

    $('#moneyrec').keyup(function() {
        var recalcres = ($('#moneyrec').val() / exchangeusd).toFixed(8);
        $('#wcsell').val(recalcres);
        $('#commissionsR').html(($('#moneyrec').val()/100*percentage).toFixed(2));
    });

    $('#wcsell').keyup(function() {
        var recalcres = ($('#wcsell').val() * exchangeusd).toFixed(8);
        $('#moneyrec').val(recalcres);
        $('#commissionsR').html((recalcres/100*percentage).toFixed(2));
    });

    $('#moneysellEth').keyup(function() {
        var recalcres = ($('#moneysellEth').val() / exchangeeth).toFixed(8);
        $('#wcbuyEth').val(recalcres);
        $('#commissionsR').html(($('#moneysellEth').val()/100*percentage).toFixed(2));
    });

    $('#wcbuyEth').keyup(function() {
        var recalcres = ($('#wcbuyEth').val() * exchangeeth).toFixed(18);
        $('#moneysellEth').val(recalcres);
        $('#commissionsR').html((recalcres/100*percentage).toFixed(18));
    });

    $('#moneyrecEth').keyup(function() {
        var recalcres = ($('#moneyrecEth').val() / exchangeeth).toFixed(8);
        $('#wcsellEth').val(recalcres);
        $('#commissionsER').html(($('#moneyrecEth').val()/100*percentage).toFixed(18));
    });

    $('#wcsellEth').keyup(function() {
        var recalcres = ($('#wcsellEth').val() * exchangeeth).toFixed(8);
        $('#moneyrecEth').val(recalcres);
        $('#commissionsER').html((recalcres/100*percentage).toFixed(18));
    });

    $('#moneysellBTC').keyup(function() {
        var recalcres = ($('#moneysellBTC').val() / exchangebtc).toFixed(8);
        $('#wcbuyBTC').val(recalcres);
        $('#commissionsB').html(($('#moneysellBTC').val()/100*percentage).toFixed(18));
    });

    $('#wcbuyBTC').keyup(function() {
        var recalcres = ($('#wcbuyBTC').val() * exchangebtc).toFixed(8);
        $('#moneysellBTC').val(recalcres);
        $('#commissionsB').html((recalcres/100*percentage).toFixed(18));
    });

    $('#moneysellWCR').keyup(function() {
        $('#wcbuyWCUR').val($('#moneysellWCR').val());
    });

    $('#wcbuyWCUR').keyup(function() {
        $('#moneysellWCR').val($('#wcbuyWCUR').val());
    });

    var cnt = 10; //$("#custom_notifications ul.notifications li").length + 1;
    TabbedNotification = function(options) {
    var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
        "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";

    if (document.getElementById('custom_notifications') == null) {
        alert('doesnt exists');
    } else {
        $('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt + "' class='alert-" + options.type + "' href='#ntf" + cnt + "'><i class='fa fa-bell animated shake'></i></a></li>");
        $('#custom_notifications #notif-group').append(message);
        cnt++;
        CustomTabs(options);
    }
    }

    CustomTabs = function(options) {
    $('.tabbed_notifications > div').hide();
    $('.tabbed_notifications > div:first-of-type').show();
    $('#custom_notifications').removeClass('dsp_none');
    $('.notifications a').click(function(e) {
        e.preventDefault();
        var $this = $(this),
        tabbed_notifications = '#' + $this.parents('.notifications').data('tabbed_notifications'),
        others = $this.closest('li').siblings().children('a'),
        target = $this.attr('href');
        others.removeClass('active');
        $this.addClass('active');
        $(tabbed_notifications).children('div').hide();
        $(target).show();
    });
    }

    CustomTabs();

    var tabid = idname = '';
    $(document).on('click', '.notification_close', function(e) {
    idname = $(this).parent().parent().attr("id");
    tabid = idname.substr(-2);
    $('#ntf' + tabid).remove();
    $('#ntlink' + tabid).parent().remove();
    $('.notifications a').first().addClass('active');
    $('#notif-group div').first().css('display', 'block');
    });

    var permanotice, tooltip, _alert;
    $(function() {

    setTimeout(function() {
        if(contractAddress != '0' && contractAddress != '') {
        jQuery('#qrcodewc').html('').qrcode("ethereum:"+contractAddress);
        // jQuery('#qrcodebc').qrcode("this plugin is great for BTC");
        jQuery('#qrcodeet').html('').qrcode("ethereum:"+contractAddress);
        }
        else {

        new PNotify({
            title: "White Standard + Metamask",
            type: "error",
            text: "Please login into your Metamask and refresh this page.",
            nonblock: {
            nonblock: true
            },
            before_close: function(PNotify) {
            // You can access the notice's options with this. It is read only.
            //PNotify.options.text;

            // You can change the notice's options after the timer like this:
            PNotify.update({
                title: PNotify.options.title + " - Enjoy your Stay",
                before_close: null
            });
            PNotify.queueRemove();
            return false;
            }
        });

        }
    }, 5000);

    });

});