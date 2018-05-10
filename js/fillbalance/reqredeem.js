  function chngState(state, percent, modal) {
    $('input#state').val(state);
    percentage = percent.replace(',', '.');
    if(modal) {
      $('#'+modal+' .modal-dialog .modal-content .modal-body .input-group input').keyup();
    }
  }

  function sendreq() {
    if(document.getElementsByName('conditionsbuy')[0].checked) {
      if($('#moneysell').val() > 0) {
        $('.sendreq').hide();
        $.ajax({
          type: 'post',
          data: 'amnt='+$('#moneysell').val()+'&state='+$('#state').val()+'&act=reqwc',
          url: '/coms/mktransaction.php',
          success: function(suc) {
            var succ = JSON.parse(suc);
            // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
            if(succ.success == 1) {
              $('.sentrequest').html('<h2 style="padding:6px 12px;">Request for White Standard sent!</h2>');
            }
            else {
              $('.sentrequest').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
            }
          },
          error: function(err) {
            alert('An unknown error occurred!')
            console.log(JSON.stringify(err));
            $('.sendreq').show();
          }
        });
      }
    }
    else {
      new PNotify({
        title: "Accept conditions",
        type: "error",
        text: "Please accept the conditions by checking the checkbox.",
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

  function sendredeem() {
    if(document.getElementsByName('conditionssell')[0].checked) {
      if($('#wcsell').val() > 0) {
        $('.sendredeem').hide();
        $.ajax({
          type: 'post',
          data: 'amnt='+$('#wcsell').val()+'&act=sellwc',
          url: '/coms/mktransaction.php',
          success: function(suc) {
            var succ = JSON.parse(suc);
            // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
            if(succ.success == 1) {
              $('.sentredeem').html('<h2 style="padding:6px 12px;">Request for USD sent!</h2>');
            }
            else {
              $('.sentredeem').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
            }
          },
          error: function(err) {
            alert('An unknown error occurred!')
            console.log(JSON.stringify(err));
            $('.sendredeem').show();
          }
        });
      }
    }
    else {
      new PNotify({
        title: "Accept conditions",
        type: "error",
        text: "Please accept the conditions by checking the checkbox.",
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

  function sendreqEth() {
    if($('#moneysellEth').val() > 0) {
      if(contractAddress != '0' && contractAddress != '') {
        if(parseFloat(document.getElementsByClassName('ethereum')[0].innerHTML) > parseFloat($('#moneysellEth').val())) {
          App.transferReqWCUR(contractAddress, parseFloat($('#moneysellEth').val()));
        }
        else {
          new PNotify({
            title: "Not enought money",
            type: "error",
            text: "There is not enought money on your account.",
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
    }
  }

  function sendredeemEth() {
    if($('#wcsellEth').val() > 0) {
      if(contractAddress != '0' && contractAddress != '') {
        if(parseFloat(document.getElementsByClassName('wcunrestricted')[0].innerHTML) > parseFloat($('#wcsellEth').val())) {
          App.transferRedeemWCUR(contractAddress, parseFloat($('#wcsellEth').val()));
        }
        else {
          new PNotify({
            title: "Not enought money",
            type: "error",
            text: "There is not enought money on your account.",
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
    }
  }

  function sendreqWCUR() {
    if($('#moneysellWCR').val() > 0) {
      if(contractAddress != '0' && contractAddress != '') {
        if(parseFloat($('#moneysellWCR').val()) <= parseFloat(getbalamnt)) {
          $('.sendreqWCUR').hide();
          $.ajax({
            type: 'post',
            data: 'amnt='+$('#moneysellWCR').val()+'&act=wcrtowcur',
            url: '/coms/mktransaction.php',
            success: function(suc) {
              // console.log(JSON.stringify(suc));
              var succ = JSON.parse(suc);
              // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
              if(succ.success == 1) {
                $('.sentrequestChng').html('<h2 style="padding:6px 12px;">Request for WCUR sent!</h2>');
              }
              else {
                $('.sentrequestChng').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
              }
            },
            error: function(err) {
              alert('An unknown error occurred!')
              console.log(JSON.stringify(err));
              $('.sendreqWCUR').show();
            }
          });
        }
        else {
          new PNotify({
            title: "Not enought money",
            type: "error",
            text: "There is not enought money on your account.",
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
    }
  }

  function sendreqBTC() {
    if($('#myBTC').val() != '' && $('#myBTC').val() != '0') {
      if($('#moneysellBTC').val() > 0) {
        $('.sendreqBTC').hide();
        $.ajax({
          type: 'post',
          data: 'amnt='+$('#moneysellBTC').val()+'&state='+$('#state').val()+'&fromadr='+$('#myBTC').val()+'&act=btcreqwc',
          url: '/coms/mktransaction.php',
          success: function(suc) {
            var succ = JSON.parse(suc);
            // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
            if(succ.success == 1) {
              $('.sentrequestBTC').html('<h2 style="padding:6px 12px;">Request for White Standard sent!</h2>');
            }
            else {
              $('.sentrequestBTC').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
            }
          },
          error: function(err) {
            alert('An unknown error occurred!')
            console.log(JSON.stringify(err));
            $('.sendreqBTC').show();
          }
        });
      }
    }
    else {
      new PNotify({
        title: "Valid Bitcoin wallet",
        type: "error",
        text: "Please specify a valid bitcoin wallet from that you'll buy White Standard. This is just for comparison reasons.",
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

  function sendredeemBTC() {
    if($('#myBTCrec').val() != '' && $('#myBTCrec').val() != '0') {
      if($('#wcsellBTC').val() > 0) {
        $('.sendredeemBTC').hide();
        $.ajax({
          type: 'post',
          data: 'amnt='+$('#wcsellBTC').val()+'&act=btcsellwc',
          url: '/coms/mktransaction.php',
          success: function(suc) {
            var succ = JSON.parse(suc);
            // console.log(JSON.stringify(suc)+' | '+suc.success+' | '+suc[0].success+' | '+succ.success);
            if(succ.success == 1) {
              $('.sentredeem').html('<h2 style="padding:6px 12px;">Request for USD sent!</h2>');
            }
            else {
              $('.sentredeem').html('<h2 style="padding:6px 12px;color:#f00;">An error occured!</h2>');
            }
          },
          error: function(err) {
            alert('An unknown error occurred!')
            console.log(JSON.stringify(err));
            $('.sendredeemBTC').show();
          }
        });
      }
    }
    else {
      new PNotify({
        title: "Valid Bitcoin wallet",
        type: "error",
        text: "Please specify a valid bitcoin wallet from that you'll buy White Standard. This is just for comparison reasons.",
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