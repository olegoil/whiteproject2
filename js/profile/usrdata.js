    $(function() {
        setTimeout(function() {
            App.getEtherBalance();
            App.getBalance();
        }, 2000);
    })

    var strongRegex = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})');

    function cil(val) {
      return document.getElementById(val).length;
    }

    function chngPwd() {
      jQuery('div#matchPassErr').hide();
      jQuery('div#pwdStrength').hide();
      jQuery('div#oldPassErr').hide();
      jQuery('div#unknownError').hide();
      jQuery('div#pwdSuccess').hide();
      jQuery('div#checkingpwd').show();
      jQuery('button.pwdchangebtn').hide();
      if(jQuery('input#oldpwd').val() != '') {
        if (strongRegex.test(jQuery('input#newpwd').val())) {
          if(jQuery('input#newpwd').val() == jQuery('input#newpwdrep').val()) {
            var jsonstr = {
              pwdold: jQuery('input#oldpwd').val(),
              pwdnew: jQuery('input#newpwd').val(),
              act: 'chngpwd'
            };
            // console.log(JSON.stringify(jsonstr));
            jQuery.ajax({
              dataType: 'json',
              type: 'post',
              url: '/coms/usrdata.php',
              data: jsonstr,
              success: function(ress) {
                // console.log(JSON.stringify(ress));
                if (ress.success === 1) {
                  jQuery('#pwdform')[0].reset();
                  jQuery('div#matchPassErr').hide();
                  jQuery('div#pwdStrength').hide();
                  jQuery('div#oldPassErr').hide();
                  // jQuery('div#takenEmail').hide();
                  jQuery('div#checkingpwd').hide();
                  jQuery('button.pwdchangebtn').show();
                  jQuery('div#pwdSuccess').show();
                }
                else if (ress.success === 2) {
                  jQuery('div#matchPassErr').hide();
                  jQuery('div#pwdStrength').hide();
                  jQuery('div#oldPassErr').show();
                  // jQuery('div#takenEmail').hide();
                  jQuery('div#checkingpwd').hide();
                  jQuery('button.pwdchangebtn').show();
                  jQuery('div#pwdSuccess').hide();
                }
                else {
                  jQuery('div#matchPassErr').hide();
                  jQuery('div#pwdStrength').hide();
                  jQuery('div#oldPassErr').hide();
                  // jQuery('div#takenEmail').hide();
                  jQuery('div#checkingpwd').hide();
                  jQuery('button.pwdchangebtn').show();
                  jQuery('div#pwdSuccess').hide();
                  jQuery('div#unknownError').show();
                }
              },
              error: function(err) {
                jQuery('div#matchPassErr').hide();
                jQuery('div#pwdStrength').hide();
                jQuery('div#oldPassErr').hide();
                // jQuery('div#takenEmail').hide();
                jQuery('div#checkingpwd').hide();
                jQuery('button.pwdchangebtn').show();
                jQuery('div#pwdSuccess').hide();
                jQuery('div#unknownError').show();
                // console.log('ERR ' + JSON.stringify(err));
              }
            });
          }
          else {
            jQuery('div#checkingpwd').hide();
            jQuery('button.pwdchangebtn').show();
            jQuery('div#matchPassErr').show();
          }
        }
        else {
          jQuery('div#checkingpwd').hide();
          jQuery('button.pwdchangebtn').show();
          jQuery('div#pwdStrength').show();
        }
      }
      else {
        jQuery('div#checkingpwd').hide();
        jQuery('button.pwdchangebtn').show();
        jQuery('div#pwdStrength').show();
      }
    }

    function saveUsr() {
      jQuery('div#checkingpwd').show();
      jQuery('button.saveusr').hide();
      jQuery('div#saveSuccess').hide();
      jQuery('div#saveUnknownError').hide();
      var jsonstr = $('form#userform').serialize()+'&act=updusr';
      // console.log(JSON.stringify(jsonstr));
      jQuery.ajax({
        dataType: 'json',
        type: 'post',
        url: '/coms/usrdata.php',
        data: jsonstr,
        success: function(res) {
          // console.log(JSON.stringify(res))
          if (res.success === 1) {
            jQuery('div#checkingpwd').hide();
            jQuery('button.saveusr').show();
            jQuery('div#saveSuccess').show();
            jQuery('div#saveUnknownError').hide();
            if(cil('name') > 0 && cil('lastname') > 0 && cil('mobile') > 0 && cil('country') > 0 && cil('city') > 0 && cil('plz') > 0 && cil('address') > 0) {
                $('.docupl').show();
                $('.docwarn').hide();
              }
          }
          else {
            jQuery('div#checkingpwd').hide();
            jQuery('button.saveusr').show();
            jQuery('div#saveSuccess').hide();
            jQuery('div#saveUnknownError').show();
          }
        },
        error: function(err) {
          jQuery('div#checkingpwd').hide();
          jQuery('button.saveusr').show();
          jQuery('div#saveSuccess').hide();
          jQuery('div#saveUnknownError').show();
          // console.log('ERR '+JSON.stringify(err))
        }
      });
    }