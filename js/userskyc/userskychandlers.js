var strongRegex = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})');

function validateEmail(email) {
    var valmail = 0;
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        valmail = 1;
    }
    return valmail;
}

function chngState(state) {
    $('input#state').val(state);
}

function submForm() {
    if(jQuery('input#firstname').val() != '' && jQuery('input#lastname').val() != '') {
        jQuery('div#signUpPassErr').hide();
        jQuery('div#pwdStrength').hide();
        jQuery('div#invalidEmail').hide();
        jQuery('div#checking').show();
        jQuery('input#sbmtbtn').hide();
        if(jQuery('input#email').val() != '') {
            if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(jQuery('input#email').val())) {
                if(jQuery('input#pwd').val() != '') {
                    if (strongRegex.test(jQuery('input#pwd').val())) {
                        if(jQuery('input#pwd').val() == jQuery('input#pwd2').val()) {
                            var jsonstr = {
                                email: jQuery('input#email').val(),
                                password: jQuery('input#pwd').val(),
                                firstname: jQuery('input#firstname').val(),
                                lastname: jQuery('input#lastname').val()
                            };
                            jQuery.ajax({
                                dataType: 'json',
                                type: 'post',
                                url: '/coms/regin_kycaml.php',
                                data: jsonstr,
                                success: function(ress) {
                                    console.log(JSON.stringify(ress))
                                    // var ress = JSON.parse(ress);
                                    if (ress[0].success === 1) {
                                        $('#usersTable').DataTable().ajax.reload();
                                        jQuery('#signUpForm')[0].reset();
                                        jQuery('div#signUpPassErr').hide();
                                        jQuery('div#pwdStrength').hide();
                                        jQuery('div#invalidEmail').hide();
                                        jQuery('div#takenEmail').hide();
                                        jQuery('div#signUpSuccess').show();
                                        jQuery('button.close').click();
                                        // jQuery('input#email').hide();
                                        // jQuery('input#pwd').hide();
                                        // jQuery('input#pwd2').hide();
                                        // jQuery('div#checking').hide();
                                        new PNotify({
                                            title: "KYC/AML created!",
                                            type: "success",
                                            text: "New KYC/AML was created!",
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
                                    else if(ress[0].success === 0) {
                                        jQuery('div#signUpPassErr').hide();
                                        jQuery('div#pwdStrength').hide();
                                        jQuery('div#invalidEmail').hide();
                                        jQuery('div#takenEmail').show();
                                        jQuery('div#checking').hide();
                                        jQuery('input#sbmtbtn').show();
                                    }
                                    else {
                                        jQuery('div#signUpPassErr').hide();
                                        jQuery('div#pwdStrength').hide();
                                        jQuery('div#invalidEmail').hide();
                                        jQuery('div#unknownError').show();
                                        jQuery('div#checking').hide();
                                        jQuery('input#sbmtbtn').show();
                                    }
                                },
                                error: function(err) {
                                    jQuery('#waitForForgot').hide();
                                    jQuery('div#checking').hide();
                                    jQuery('input#sbmtbtn').show();
                                    // console.log('ERR ' + JSON.stringify(err));
                                }
                            });
                        }
                        else {
                            jQuery('div#checking').hide();
                            jQuery('input#sbmtbtn').show();
                            jQuery('div#signUpPassErr').show();
                        }
                    }
                    else {
                        jQuery('div#checking').hide();
                        jQuery('input#sbmtbtn').show();
                        jQuery('div#pwdStrength').show();
                    }
                }
                else {
                    jQuery('div#checking').hide();
                    jQuery('input#sbmtbtn').show();
                    jQuery('div#pwdStrength').show();
                }
            }
            else {
                jQuery('div#checking').hide();
                jQuery('input#sbmtbtn').show();
                jQuery('#invalidEmail').show();
            }
        }
        else {
            jQuery('div#checking').hide();
            jQuery('input#sbmtbtn').show();
            jQuery('#invalidEmail').show();
        }
    }
    else {
        new PNotify({
            title: "Fill all fields",
            type: "error",
            text: "Need to fill Firstname and Lastname!",
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

function remminter(val1, val2) {
    if(confirm("Delete this KYC/AML "+val1)) {
        if(val2 != '0' && val2 != '') {
            var datastr = 'act=mintdel&adr='+val1+'&amnt='+val2;
            $.ajax({
              type: 'post',
              url: '/coms/mktransaction.php',
              data: datastr,
              success: function(suc) {
                  console.log(JSON.stringify(suc));
                  var suc = JSON.parse(suc);
                  if(suc.success == 0) {
                    new PNotify({
                        title: "Error!",
                        type: "error",
                        text: "No such KYC/AML.",
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
                  else if(suc.success == 1) {
                    $('#usersTable').DataTable().ajax.reload();
                  }
              },
              error: function(err) {
                alert('Some error occured!')
              }
            })
        }
    }
}