function saveQuote() {
    var jsonstr = {
        amnt: $('#wcrquote').val(),
        act: 'quoteset'
    };

    jQuery.ajax({
        dataType: 'json',
        type: 'post',
        url: '/coms/mktransaction.php',
        data: jsonstr,
        success: function(res) {
            if(res.success == '1') {
                new PNotify({
                    title: "Success",
                    type: "success",
                    text: "Quote saved!",
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
            else {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "An unknown error occured!",
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
        },
        error: function(err) {
            console.log('ERR '+JSON.stringify(err))
        }
    });
}

function sendAjax(i) {
    var elements = document.forms["exchng"].getElementsByTagName("input");
    var element = elements[i];
    var ell = elements.length;
    console.log(element);
    if(element && i < ell) {
        if(element.id) {
            var from = '';
            var to = '';
            var amount = element.value;
            
            switch(element.id) {
                case 'usdwcr': 
                    from = 'USD';
                    to = 'WCR';
                    break;
                case 'wcrusd':
                    from = 'WCR';
                    to = 'USD';
                    break;
                case 'wcrwcur':
                    from = 'WCR';
                    to = 'WCUR';
                    break;
                case 'ethwcur':
                    from = 'ETH';
                    to = 'WCUR';
                    break;
                case 'bawcr':
                    from = 'BA';
                    to = 'WCR';
                    break;
                case 'cawcr':
                    from = 'CA';
                    to = 'WCR';
                    break;
                case 'ccwcr':
                    from = 'CC';
                    to = 'WCR';
                    break;
                case 'btcwcr':
                    from = 'BTC';
                    to = 'WCR';
                    break;
                default:
                    from = '';
                    to = '';
                    break;
            }

            var jsonstr = {
                fromadr: from,
                adr: to,
                amnt: amount,
                act: 'feeset'
            };

            jQuery.ajax({
                dataType: 'json',
                type: 'post',
                url: '/coms/mktransaction.php',
                data: jsonstr,
                success: function(res) {
                    console.log(JSON.stringify(res))
                    if(res.success == '1') {
                        new PNotify({
                            title: "Success",
                            type: "success",
                            text: "Fees saved!",
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
                    else {
                        new PNotify({
                            title: "Error",
                            type: "error",
                            text: "An unknown error occured!",
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
                    var j = i+1;
                    sendAjax(j);
                },
                error: function(err) {
                    console.log('ERR '+JSON.stringify(err))
                }
            });
        }
    }
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

$(function() {
    $('.feesave').on('click', function() {
        if($('#usdwcr').val() != '' && $('#wcrusd').val() != '' && $('#wcrwcur').val() != '' && $('#ethwcur').val() != '' && $('#bawcr').val() != '' && $('#cawcr').val() != '' && $('#ccwcr').val() != '') {

            if(isNumber($('#usdwcr').val()) && isNumber($('#wcrusd').val()) && isNumber($('#wcrwcur').val()) && isNumber($('#ethwcur').val()) && isNumber($('#bawcr').val()) && isNumber($('#cawcr').val()) && isNumber($('#ccwcr').val())) {
                sendAjax(0);
            }
            else {
                new PNotify({
                    title: "Wrong format!",
                    type: "error",
                    text: "There must only be Numbers!",
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

        }
        else {
            new PNotify({
                title: "Empty field!",
                type: "error",
                text: "There mustn't be any empty field!",
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
    });
});