    function sendAjax(jsonstr) {
        jQuery.ajax({
            dataType: 'json',
            type: 'post',
            url: '/coms/mktransaction.php',
            data: jsonstr,
            success: function(res) {
                if(res.success == 'no money') {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "Not enough money!",
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
                else if(res.success == 'no wallet') {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "No such wallet!",
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
                else if(res.success >= '0') {
                    document.getElementById('bankbalance').innerHTML = 'Sum: '+res.success;
                    new PNotify({
                        title: "Success!",
                        type: "success",
                        text: "New balance: "+res.success,
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
                $('form#tknform')[0].reset();
            },
            error: function(err) {
                console.log('ERR '+JSON.stringify(err))
            }
        });
    }

    function sendAjax2(jsonstr) {
        jQuery.ajax({
            dataType: 'json',
            type: 'post',
            url: '/coms/mktransaction.php',
            data: jsonstr,
            success: function(res) {
                if(res.success == 'no money') {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "Not enough money!",
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
                else if(res.success == 'no wallet') {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "No such wallet!",
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
                else if(res.success >= '0') {
                    
                    document.getElementById('bankbalance').innerHTML = 'Sum: '+res.success;
                    new PNotify({
                        title: "Success!",
                        type: "success",
                        text: "New balance: "+res.success,
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
                $('form#tknform2')[0].reset();
            },
            error: function(err) {
                console.log('ERR '+JSON.stringify(err))
            }
        });
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    $(function() {
        $('.tknsend').on('click', function() {
            if($('#sndtokenadr').val() != '' && $('#sndnotes').val() != '' && $('#sndtokenamount').val() != '' && isNumber($('#sndtokenamount').val())) {
                var jsonstr = {
                    adr: $('#sndtokenadr').val(),
                    notes: $('#sndnotes').val(),
                    amnt: $('#sndtokenamount').val(),
                    act: 'send'
                };
                sendAjax(jsonstr);
            }
            else {
                new PNotify({
                    title: "All fields must be filled!",
                    type: "error",
                    text: "Check all fields and be sure number is filled in amount!",
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
        $('.tkncreate').on('click', function() {
            if(isNumber($('#crtoken').val())) {
                var jsonstr = {
                    amnt: $('#crtoken').val(),
                    act: 'create'
                };
                sendAjax(jsonstr);
            }
            else {
                new PNotify({
                    title: "Amount of new tokens!",
                    type: "error",
                    text: "Be sure number is filled in amount!",
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
        $('.tkndestroy').on('click', function() {
            if(isNumber($('#crtoken').val())) {
                var jsonstr = {
                    amnt: $('#dstoken').val(),
                    act: 'destroy'
                };
                sendAjax(jsonstr);
            }
            else {
                new PNotify({
                    title: "Amount of tokens!",
                    type: "error",
                    text: "Be sure number is filled in amount!",
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
        $('.tknsend2').on('click', function() {
            if($('#sndtokenadr2').val() != '' && $('#sndnotes2').val() != '' && $('#sndtokenamount2').val() != '' && isNumber($('#sndtokenamount2').val())) {
                var jsonstr = {
                    adr: $('#sndtokenadr2').val(),
                    notes: $('#sndnotes2').val(),
                    amnt: $('#sndtokenamount2').val(),
                    act: 'send2'
                };
                sendAjax2(jsonstr);
            }
            else {
                new PNotify({
                    title: "All fields must be filled!",
                    type: "error",
                    text: "Check all fields and be sure number is filled in amount!",
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
        $('.tkncreate2').on('click', function() {
            if(isNumber($('#crtoken2').val())) {
                var jsonstr = {
                    amnt: $('#crtoken2').val(),
                    act: 'create2'
                };
                sendAjax2(jsonstr);
            }
            else {
                new PNotify({
                    title: "Amount of new tokens!",
                    type: "error",
                    text: "Be sure number is filled in amount!",
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