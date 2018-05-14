jQuery(document).ready(function() {
      
    // if ( jQuery.browser.msie ) {
    //   if(jQuery.browser.version > 9) {
    //       jQuery('.modal').removeClass('fade');
    //   }
    // }

    jQuery('#forgotPwd').on('hidden.bs.modal', function () {
        jQuery('#forgotEmailForm').show();
        jQuery('#proofEmailSbmt').show();
        jQuery('#proofEmailGroup').show();
        jQuery('#proofEmailTxt').hide();
    });

  });

  function validateEmail(email) {
    var valmail = 0;
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        valmail = 1;
    }
    return valmail;
  }

  function forgotEmailSubmit() {
    jQuery('#waitForForgot').show();
    jQuery('#invalidEmail').hide();
    jQuery('#proofEmailSbmt').hide();
    jQuery('#forgotEmailErr').hide();
    jQuery('#forgotEmailNoSuchErr').hide();
    jQuery('#checking2').show();
    if (jQuery('#forgotEmail').val() != '') {
      if(validateEmail(jQuery('#forgotEmail').val()) == 1) {
        var jsonstr = {
          forgotEmail: jQuery('#forgotEmail').val(),
          resetPwd: 1
        };
        jQuery.ajax({
          dataType: 'json',
          type: 'post',
          url: 'coms/forgotpwd.php',
          data: jsonstr,
          success: function(ress) {
            if (ress[0].emailReset === 1) {
              jQuery('#waitForForgot').hide();
              jQuery('#proofEmailTxt').show();
              jQuery('#forgotEmailErr').hide();
              jQuery('#forgotEmailNoSuchErr').hide();
              jQuery('#proofEmailSbmt').hide();
              jQuery('#proofEmailGroup').hide();
              jQuery('#forgotEmailForm')[0].reset();
              jQuery('#forgotEmailForm').hide();
                    jQuery('#invalidEmail').hide();
              jQuery('#checking2').hide();
            }
            else {
              jQuery('#proofEmailSbmt').show();
              jQuery('#checking2').hide();
              jQuery('#waitForForgot').hide();
              jQuery('#forgotEmailNoSuchErr').show();
            }
          },
          error: function(err) {
            jQuery('#checking2').hide();
            jQuery('#waitForForgot').hide();
            console.log('ERR ' + JSON.stringify(err));
          }
        });
      }
      else {
        jQuery('#proofEmailSbmt').show();
        jQuery('#checking2').hide();
        jQuery('#waitForForgot').hide();
        jQuery('#invalidEmail').show();
      }
    } else {
      jQuery('#waitForForgot').hide();
      jQuery('#forgotEmailErr').show();
      jQuery('#proofEmailSbmt').show();
      jQuery('#checking2').hide();
      jQuery('#forgotEmailNoSuchErr').hide();
      jQuery('#invalidEmail').hide();
    }
  }

  var strongRegex = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})');

  function submForm() {
    jQuery('div#signUpPassErr').hide();
    jQuery('div#pwdStrength').hide();
    jQuery('div#invalidEmail').hide();
    jQuery('div#checking').show();
    jQuery('input#sbmtbtn').hide();
    if(jQuery('input#email').val() != '') {
      if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(jQuery('input#email').val())) {
        if(jQuery('input#password1').val() != '') {
          if (strongRegex.test(jQuery('input#password1').val())) {
            if(jQuery('input#password1').val() == jQuery('input#password2').val()) {
              var jsonstr = {
                email: jQuery('input#email').val(),
                password: jQuery('input#password1').val()
              };
              jQuery.ajax({
                dataType: 'json',
                type: 'post',
                url: 'coms/regin.php',
                data: jsonstr,
                success: function(ress) {
                  if (ress[0].success === 1) {
                    jQuery('#signUpForm')[0].reset();
                    jQuery('div#signUpPassErr').hide();
                    jQuery('div#pwdStrength').hide();
                    jQuery('div#invalidEmail').hide();
                    jQuery('div#takenEmail').hide();
                    jQuery('div#signUpSuccess').show();
                    jQuery('input#email').hide();
                    jQuery('input#password1').hide();
                    jQuery('input#password2').hide();
                    jQuery('div#checking').hide();
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
                  console.log('ERR ' + JSON.stringify(err));
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