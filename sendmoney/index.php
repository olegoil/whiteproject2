<?php
  include '../conns/whiteauth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Send money | White Standard</title>

  <?php
    include '../incs/cssload.php';
  ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="../js/jquery.qrcode.min.js"></script>
</head>

<body class="nav-md">

  <div class="container body">

    <div class="main_container">

      <?php include '../incs/navigation.php'; ?>

      <!-- page content -->
      <div class="right_col" role="main">

        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Send Money</h3>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Send Money <small>from my wallet</small></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                <?php if($sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') { ?>
                  <div class="container">
                <form action="/coms/sendmoney.php" id="myForm" name="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

                  <!-- Smart Wizard -->
                  <p>Select the wallet you want to send from and point the wallet you want to send money to.</p>
                  <div id="smartwizard">
                    <ul>
                      <li>
                        <a href="#step-1">
                            <span>1</span>
                            <span>
                                Select Wallet<br />
                                <small>Select your wallet</small>
                            </span>
                        </a>
                      </li>
                      <li>
                        <a href="#step-2">
                            <span>2</span>
                            <span>
                              Payment confirmation<br/>
                              <small>Please check payment data</small>
                            </span>
                        </a>
                      </li>
                      <li>
                        <a href="#step-3">
                            <span>3</span>
                            <span>
                              Conditions<br/>
                              <small>Accept our conditions</small>
                            </span>
                        </a>
                      </li>
                      <li>
                        <a href="#step-4">
                          <span>4</span>
                          <span>
                              Payment Sent!<br />
                              <small>Your payment is awaiting confirmation!</small>
                          </span>
                        </a>
                      </li>
                    </ul>
                    <div>
                    <div id="step-1">
                      <!-- <h2>Select Wallet</h2> -->
                      <div id="form-step-0" role="form" data-toggle="validator">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label" for="walletSend">Wallet sender<span class="required">*</span>
                            </label>
                            <select id="walletSend" name="walletSend" required="required" class="form-control col-md-7 col-xs-12">
                              <?php
                                echo '<option value="'.$sql->getBalance(0)['recid'].'">WCR</option>';
                                // echo '<option value="'.$sql->getBalance(1)['recid'].'">WCUR</option>';
                                // echo '<option value="'.$sql->getBalance(2)['recid'].'">Bitcoin</option>';
                                // echo '<option value="'.$sql->getBalance(3)['recid'].'">Ethereum</option>';
                              ?>
                            </select>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label" for="sendAmount">Sending amount<span class="required">*</span>
                            </label>
                            <input type="text" id="sendAmount" name="sendAmount" required="required" class="form-control col-md-7 col-xs-12">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label" for="walletRec">Wallet receiver <span class="required">*</span>
                            </label>
                            <input type="text" id="walletRec" name="walletRec" required="required" class="form-control col-md-7 col-xs-12">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="recAmount" class="control-label">Receiving amount</label>
                            <input id="recAmount" class="form-control col-md-7 col-xs-12" type="text" name="recAmount">
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="sendNotes" class="control-label col-md-3 col-sm-3 col-xs-12">Notes</label>
                            <textarea id="sendNotes" class="form-control col-md-7 col-xs-12" name="sendNotes"></textarea>
                            <div class="help-block with-errors"></div>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                    <div id="step-2">
                      <!-- <h2>Check data</h2> -->
                      <div id="form-step-1" role="form" data-toggle="validator">
                        <h2>From wallet</h2>
                        <p id="fromWalletConf"></p>
                        <h2>To wallet</h2>
                        <p id="toWalletConf"></p>
                        <h2>Sending sum</h2>
                        <p id="sendSumConf"></p>
                        <h2>Commissions</h2>
                        <p id="commsConf"></p>
                        <h2>Receiving sum</h2>
                        <p id="amountRecConf"></p>
                        <h2>Notes</h2>
                        <p id="notesConf"></p>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div id="step-3">
                      <!-- <h2>Accept conditions</h2> -->
                      <div id="form-step-2" role="form" data-toggle="validator">
                        <h2 class="StepTitle">Transfer conditions</h2>
                        <p>
                          By proceeding the transfer you accept the following conditions:
                          <br/>
                          Lorem Ipsum ...
                        </p>
                        <!-- <div id="qrcode"></div> -->
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div id="step-4" class="">
                      <h2 id="finalShotTitle" class="StepTitle">Congratulations!</h2>
                      <p id="finalShotText">Your payment gone!</p>
                      <div class="clearfix"></div>
                    </div>
                    </div>
                  </div>
                  <!-- End SmartWizard Content -->

                </form>
                </div>
                <?php } else { ?>
                    <h2>Not verified user. Just verfificated user are able to send money. <a href="/profile/">Go to verification.</a></h2>
                <?php } ?>

                </div>
              </div>
            </div>

          </div>
        </div>

        <?php include '../incs/footer.php'; ?>

      </div>
      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <script src="../js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="../js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="../js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="../js/icheck/icheck.min.js"></script>

  <script src="../js/custom.js"></script>
  <!-- Include jQuery Validator plugin -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
  <!-- form wizard -->
  <script type="text/javascript" src="../js/wizard/jquery.smartWizard.min.js"></script>
  <!-- pace -->
  <script src="../js/pace/pace.min.js"></script>
  <!-- PNotify -->
  <script type="text/javascript" src="../js/notify/pnotify.core.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.buttons.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.nonblock.js"></script>

  <script type="text/javascript" src="../js/app.js"></script>
  
  <script type="text/javascript" src="../js/etherbalance.js"></script>

  <?php if($sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') { ?>
  
    <script type="text/javascript" src="../js/sendmoney/sendmoney.js"></script>

  <?php } ?>

</body>

</html>
