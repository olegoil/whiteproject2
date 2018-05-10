function saveNotes() {
    jQuery('div#savingnotes').show();
    jQuery('button.saveusr').hide();
    jQuery('div#saveSuccessNote').hide();
    jQuery('div#saveUnknownErrorNote').hide();
    var jsonstr = $('form#notesform').serialize()+'&act=usrnotes&usr='+getusr;
    // console.log(JSON.stringify(jsonstr));
    jQuery.ajax({
      dataType: 'json',
      type: 'post',
      url: '/coms/usrdata.php',
      data: jsonstr,
      success: function(res) {
        // console.log(JSON.stringify(res))
        if (res.success === 1) {
          jQuery('div#savingnotes').hide();
          jQuery('button.saveusr').show();
          jQuery('div#saveSuccessNote').show();
          jQuery('div#saveUnknownErrorNote').hide();
        }
        else {
          jQuery('div#savingnotes').hide();
          jQuery('button.saveusr').show();
          jQuery('div#saveSuccessNote').hide();
          jQuery('div#saveUnknownErrorNote').show();
        }
      },
      error: function(err) {
        jQuery('div#savingnotes').hide();
        jQuery('button.saveusr').show();
        jQuery('div#saveSuccessNote').hide();
        jQuery('div#saveUnknownErrorNote').show();
        // console.log('ERR '+JSON.stringify(err))
      }
    });
  }