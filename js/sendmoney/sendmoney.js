$(document).ready(function() {

    var fromWallet = $('select#walletSend').val();
    var toWallet = $('input#walletRec').val();
    var sendAmount = $('input#sendAmount').val();
    var sendNotes = $('textarea#sendNotes').val();

    $('select#walletSend').change(function() {
      if($('select#walletSend option:selected').text() == 'WCUR' || $('select#walletSend option:selected').text() == 'Ethereum') {
        if(contractAddress) {
          $('p#fromWalletConf').html(contractAddress);
        }
        else {
          new PNotify({
            title: "WhiteCoin + Metamask",
            type: "error",
            text: "Please log in to Metamask extension!",
            nonblock: {
              nonblock: true
            },
            before_close: function(PNotify) {
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
        $('p#fromWalletConf').html($('select#walletSend').val());
      }
    });

    $('input#sendAmount').keyup(function() {
      $('p#sendSumConf').html($('input#sendAmount').val());
      $('input#recAmount').val($('input#sendAmount').val()*0.95);
      $('p#commsConf').html($('input#sendAmount').val()*0.05);
      $('p#amountRecConf').html($('input#sendAmount').val()*0.95);
    });

    $('input#walletRec').keyup(function() {
      $('p#toWalletConf').html($('input#walletRec').val());
    });

    $('input#recAmount').keyup(function() {
      $('p#commsConf').html($('input#sendAmount').val()*0.05);
      $('p#amountRecConf').html($('input#sendAmount').val()*0.95);
      $('p#sendSumConf').html($('input#sendAmount').val());
      $('input#recAmount').val($('input#sendAmount').val()*0.95);
    });

    $('textarea#sendNotes').keyup(function() {
      $('p#notesConf').html($('textarea#sendNotes').val());
    });

    $('p#fromWalletConf').html($('select#walletSend').val());

    $('#smartwizard').smartWizard({
      selected: 0,  // Initial selected step, 0 = first step 
      keyNavigation:true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
      autoAdjustHeight:true, // Automatically adjust content height
      cycleSteps: false, // Allows to cycle the navigation of steps
      backButtonSupport: true, // Enable the back button support
      useURLhash: false, // Enable selection of the step based on url hash
      lang: {  // Language variables
          next: 'Next', 
          previous: 'Previous'
      },
      toolbarSettings: {
          toolbarPosition: 'bottom', // none, top, bottom, both
          toolbarButtonPosition: 'right', // left, right
          showNextButton: true, // show/hide a Next button
          showPreviousButton: true // show/hide a Previous button
          // toolbarExtraButtons: [btnFinish, btnCancel]
      }, 
      anchorSettings: {
          anchorClickable: true, // Enable/Disable anchor navigation
          enableAllAnchors: false, // Activates all anchors clickable all times
          markDoneStep: true, // add done css
          enableAnchorOnDoneStep: true, // Enable/Disable the done steps navigation
          markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
          removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
      },            
      contentURL: null, // content url, Enables Ajax content loading. can set as data data-content-url on anchor
      disabledSteps: [],    // Array Steps disabled
      errorSteps: [],    // Highlight step with errors
      theme: 'arrows',
      transitionEffect: 'fade', // Effect on navigation, none/slide/fade
      transitionSpeed: '400'
    });

    $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
      var elmForm = $("#form-step-" + stepNumber);
      // stepDirection === 'forward' :- this condition allows to do the form validation
      // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
      if(stepDirection === 'forward' && elmForm) {
        elmForm.validator('validate');
        var elmErr = elmForm.children('.has-error');
        if(elmErr && elmErr.length > 0){
            // Form validation failed
            return false;
        }
      }
      return true;
    });

    $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
        // Enable finish button only on last step
        if(stepNumber == 3) {

          if($('select#walletSend option:selected').text() == "WCR") {
            var notesenc = encodeURIComponent($('textarea#sendNotes').val());
            var sendstr = 'amnt='+$('input#sendAmount').val()+'&adr='+$('input#walletRec').val()+'&notes='+notesenc+'&fromadr='+$('select#walletSend').val()+'&act=sendwc';
            $.ajax({
              type: 'post',
              data: sendstr,
              url: '/coms/mktransaction.php',
              success: function(suc) {
                var succ = JSON.parse(suc);
                // console.log(JSON.stringify(suc));
                if(succ.success == 1) {
                  $('#finalShotTitle').html('Congratulations!');
                  $('#finalShotText').html('Your payment gone!');
                  new PNotify({
                    title: "Success!",
                    type: "success",
                    text: "Transaction gone.",
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
                  $('button.sw-btn-next').hide();
                  $('button.sw-btn-prev').hide();
                  setTimeout(function() {
                    $('#smartwizard').smartWizard("reset");
                    $('#myForm').find("input, textarea").val("");
                    $('#myForm').find("select").val("WCR");
                    $('#fromWalletConf').html("");
                    $('#toWalletConf').html("");
                    $('#sendSumConf').html("");
                    $('#commsConf').html("");
                    $('#amountRecConf').html("");
                    $('#notesConf').html("");
                  }, 2000);
                }
                else if(succ.success == 0) {
                  $('#finalShotTitle').html('Error!');
                  $('#finalShotText').html('Not enough money in your wallet.');
                  new PNotify({
                    title: "Not enough money!",
                    type: "error",
                    text: "Not enough money in your wallet.",
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
                else if(succ.success == 2) {
                  $('#finalShotTitle').html('Error!');
                  $('#finalShotText').html('No receiver!');
                  new PNotify({
                    title: "No receiver!",
                    type: "error",
                    text: "There is no receiver with this wallet.",
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
                $('#finalShotTitle').html('Error!');
                $('#finalShotText').html('An unknown error occurred!');
                new PNotify({
                  title: "Error!",
                  type: "error",
                  text: "An unknown error occurred!",
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
                console.log(JSON.stringify(err));
                $('.sendredeem').show();
              }
            });
          }
          else if($('select#walletSend option:selected').text() == 'WCUR' || $('select#walletSend option:selected').text() == 'Ethereum') {
            if(parseInt($('input#sendAmount').val()) > 0) {
              if(contractAddress != '0' && contractAddress != '') {
                if(parseFloat(wcursum) >= parseFloat($('input#sendAmount').val())) {
                  App.transferPrivate($('input#walletRec').val(), $('input#sendAmount').val());
                }
                else {
                  $('#finalShotTitle').html('Error!');
                  $('#finalShotText').html('Not enough money in your wallet.');
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
                $('#finalShotTitle').html('Error!');
                $('#finalShotText').html('Please login into your Metamask and refresh this page.');
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
            else {
              $('#finalShotTitle').html('Error!');
              $('#finalShotText').html('There is no sum defined to send!');
              new PNotify({
                title: "No sum!",
                type: "error",
                text: "There is no sum defined to send!",
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
        else if(stepNumber == 2) {
          $('button.sw-btn-next').text('Send').removeClass('btn-secondary').addClass('btn-success');
        }
        else {
          $('button.sw-btn-next').text('Next').show().removeClass('btn-success').addClass('btn-secondary');
        }
    });

    // $('#qrcode').qrcode("this plugin is great");

});