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

  <title>Purchase | White Standard</title>

  <?php
    include '../incs/cssload.php';
  ?>
  <script src="../js/jquery.min.js"></script>
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
              <h3>Purchase White Standard</h3>
            </div>

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search"></div>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-bars"></i> Choose your wallet</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"> <i class="fa fa-krw"></i> WCR</a>
                      </li>
                      <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"> <i class="fa fa-krw"></i> WCUR</a>
                      </li>
                      <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><i class="fa fa-bar-chart"></i> Fees</a>
                      </li>
                      <!-- <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><i class="fa fa-ethereum"></i> Ethereum</a>
                      </li> -->
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                        <h3>Account: <span class="wcrestricted2"><?php echo $sql->getBalance(0)['recid']; ?></span></h3>
                        <h3>Balance: <span class="wcrestricted"><?php echo $sql->getBalance(0)['amount']; ?></span> <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#redeemModal" onclick="chngState('USD', '<?php echo $sql->getFee('WCR', 'USD')['fee']; ?>', 'redeemModal')">Redeem</button></h3>
                        <div class="row">
                          <div class="col-md-10 col-sm-10 col-xs-12">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Order options</h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th></th>
                                      <th>From</th>
                                      <th>Comissions %</th>
                                      <!-- <th>Comissions</th> -->
                                      <th>Enrollment time</th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <th scope="row"><i class="fa fa-bank"></i></th>
                                      <td>BANK WIRE</td>
                                      <td><?php echo $sql->getFee('BA', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal" onclick="chngState(\'BA\', \''.$sql->getFee('BA', 'WCR')['fee'].'\', \'tokenModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th scope="row"><i class="fa fa-bank"></i></th>
                                      <td>ACH</td>
                                      <td><?php echo $sql->getFee('CA', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal" onclick="chngState(\'CA\', \''.$sql->getFee('CA', 'WCR')['fee'].'\', \'tokenModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th scope="row"><i class="fa fa-cc-visa"></i></th>
                                      <td>VISA</td>
                                      <td><?php echo $sql->getFee('CC', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal" onclick="chngState(\'CC\', \''.$sql->getFee('CC', 'WCR')['fee'].'\', \'tokenModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th scope="row"><i class="fa fa-cc-mastercard"></i></th>
                                      <td>Mastercard</td>
                                      <td><?php echo $sql->getFee('CC', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal" onclick="chngState(\'CC\', \''.$sql->getFee('CC', 'WCR')['fee'].'\', \'tokenModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th scope="row"><i class="fa fa-cc-amex"></i></th>
                                      <td>American Express</td>
                                      <td><?php echo $sql->getFee('CC', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal" onclick="chngState(\'CC\', \''.$sql->getFee('CC', 'WCR')['fee'].'\', \'tokenModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th scope="row"><i class="fa fa-bitcoin"></i></th>
                                      <td>Bitcoin</td>
                                      <td><?php echo $sql->getFee('BTC', 'WCR')['fee']; ?>%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            if($sql->getUser()['user_name'] != '' && $sql->getUser()['user_lastname'] != '' && $sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                              echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenBTCModal" onclick="chngState(\'BTC\', \''.$sql->getFee('BTC', 'WCR')['fee'].'\', \'tokenBTCModal\')">Purchase White Standard</button>';
                                            }
                                            else {
                                              echo '<a href="/profile/" class="btn btn-success btn-xs">Verification</a><br/><b class="text-danger">Upload all required documents and also enter your name and lastname.</b>';
                                            }
                                        ?>
                                      </td>
                                    </tr>
                                    <!-- <tr>
                                      <th scope="row"><i class="fa fa-cc-paypal"></i></th>
                                      <td>PayPal</td>
                                      <td>2,95%</td>
                                      <td>3-5 Days</td>
                                      <td>
                                        <?php 
                                            // if($sql->getUser()['user_confirm'] == '1' && $sql->getUser()['user_mobile_confirm'] == '1' && $sql->getUser()['user_adress_confirm'] == '1') {
                                            //   echo '<button class="btn btn-success" data-toggle="modal" data-target="#tokenModal">Purchase White Standard</button>';
                                            // }
                                            // else {
                                            //   echo '<a href="/profile/" class="btn btn-success">Verification</a>';
                                            // }
                                        ?>
                                      </td>
                                    </tr> -->
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        <h3>Account: <span class="wcunrestricted2">loading..</span></h3>
                        <h3>Balance: <span class="wcunrestricted"><?php echo $sql->getBalance(1)['amount']; ?></span> <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#redeemEthModal" onclick="chngState('ETH', '<?php echo $sql->getFee('ETH', 'WCUR')['fee']; ?>', 'redeemEthModal')">Redeem</button></h3>
                          <table class="table">
                            <thead>
                              <tr>
                                <th></th>
                                <th>From</th>
                                <th>Comissions %</th>
                                <!-- <th>Comissions</th> -->
                                <th>Enrollment time</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row"><i class="fa fa-bank"></i></th>
                                <td>Ether</td>
                                <td><?php echo $sql->getFee('ETH', 'WCUR')['fee']; ?>%</td>
                                <td>3-5 Days</td>
                                <td>
                                  <button class="btn btn-success" data-toggle="modal" data-target="#tokenEthModal">Purchase White Standard</button>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row"><i class="fa fa-bank"></i></th>
                                <td>Wite Standart Restricted</td>
                                <td><?php echo $sql->getFee('WCR', 'WCUR')['fee']; ?>%</td>
                                <td>3-5 Days</td>
                                <td>
                                  <button class="btn btn-success" data-toggle="modal" data-target="#tokenChngModal">Transfer balance from Restricted to Unrestricted</button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        <p>Use your balance number or scan the qrcode below to fill wallet.</p>
                        <div id="qrcodewc"><i class="fa fa-spin fa-spinner" style="font-size:46px;"></i></div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>From</th>
                              <th>To</th>
                              <th>Comissions %</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php echo $sql->listFee(); ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                        <h3>Account: <span class="ethereum2">loading..</span></h3>
                        <h3>Balance: <span class="ethereum"><?php echo $sql->getBalance(3)['amount']; ?></span></h3>
                        <p>Use your balance number or scan the qrcode below to fill wallet.</p>
                        <div id="qrcodeet"><i class="fa fa-spin fa-spinner" style="font-size:46px;"></i></div>
                      </div> -->
                    </div>
                  </div>

                </div>
              </div>
            </div>

        </div>
        <div class="clearfix"></div>

        <?php include '../incs/footer.php'; ?>

      </div>
      <!-- /page content -->
    </div>

  </div>

  <!-- Modal USD Purchase -->
  <div class="modal fade" id="tokenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentrequest">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="moneysell">Spend USD</label>
          <div class="input-group">
            <input type="text" id="moneysell" name="moneysell" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">USD</button>
            </span>
          </div>
          <label for="wcbuy">Buy WCR</label>
          <div class="input-group">
            <input type="text" id="wcbuy" name="wcbuy" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('USD', 'WCR')['amount2']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCR</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsP">Commission
              <span id="commissionsP">0</span> USD
            </label>
          </div>
          <div class="checkbox">
            <label>
              <input id="conditionsbuy" name="conditionsbuy" type="checkbox" class="flat"> I'm not a citizen of NY, nor Washington state.
              <input id="state" name="state" type="hidden" value="BA">
            </label>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendreq" onclick="sendreq(); return false;">Send request</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal USD Redeem -->
  <div class="modal fade" id="redeemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentredeem">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel2">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="wcsell">Sell WCR</label>
          <div class="input-group">
            <input type="text" id="wcsell" name="wcsell" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('USD', 'WCR')['amount2']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCR</button>
            </span>
          </div>
          <label for="moneyrec">Receive USD</label>
          <div class="input-group">
            <input type="text" id="moneyrec" name="moneyrec" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">USD</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsR">Commission
              <span id="commissionsR">0</span> USD
            </label>
          </div>
          <div class="checkbox">
            <label>
              <input id="conditionssell" name="conditionssell" type="checkbox" class="flat"> I'm not a citizen of NY, nor Washington state.
            </label>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendredeem" onclick="sendredeem(); return false;">Send request</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal ETH Purchase -->
  <div class="modal fade" id="tokenEthModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentrequestEth">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label>Send Ether to get White Standard to the address below</label>
          <div class="input-group">
            <input type="text" class="form-control col-md-7 col-xs-12" value="0x838C133dA3C493D728d49FA94f4f9B1930651e2a" disabled>
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">Contract</button>
            </span>
          </div>
          <!-- <div class="input-group">
            <input type="text" id="moneysellEth" name="moneysellEth" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount1']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">ETH</button>
            </span>
          </div>
          <label for="wcbuyEth">Buy WCUR</label>
          <div class="input-group">
            <input type="text" id="wcbuyEth" name="wcbuyEth" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount2']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCUR</button>
            </span>
          </div> -->
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary sendreqEth" onclick="sendreqEth(); return false;">Send request</button> -->
        </div>
      </div>
    </div>
  </div>

  <!-- Modal ETH Redeem -->
  <div class="modal fade" id="redeemEthModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentredeemEth">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel2">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="wcsellEth">Sell WCUR</label>
          <div class="input-group">
            <input type="text" id="wcsellEth" name="wcsellEth" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount2']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCUR</button>
            </span>
          </div>
          <label for="moneyrecEth">Receive Ether</label>
          <div class="input-group">
            <input type="text" id="moneyrecEth" name="moneyrecEth" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount1']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">ETH</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsER">Commission
              <span id="commissionsER">0</span> WC
            </label>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendredeemEth" onclick="sendredeemEth(); return false;">Send request</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal BTC Purchase -->
  <div class="modal fade" id="tokenBTCModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentrequestBTC">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="moneysellBTC">Sell BTC</label>
          <div class="input-group">
            <input type="text" id="moneysellBTC" name="moneysellBTC" class="form-control col-md-7 col-xs-12" value="0">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">BTC</button>
            </span>
          </div>
          <label for="wcbuyBTC">Buy WCR</label>
          <div class="input-group">
            <input type="text" id="wcbuyBTC" name="wcbuyBTC" class="form-control col-md-7 col-xs-12" value="1">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCR</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsB">Commission
              <span id="commissionsB">0</span> BTC
            </label>
          </div>
          <label for="myBTC">My Bitcoin wallet (for comparison)</label>
          <div class="form-group">
            <input type="text" id="myBTC" name="myBTC" class="form-control col-md-7 col-xs-12" value="">
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendreqBTC" onclick="sendreqBTC(); return false;">Send request</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal BTC Redeem -->
  <div class="modal fade" id="redeemBTCModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentredeemBTC">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel2">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="wcsellBTC">Sell WCUR</label>
          <div class="input-group">
            <input type="text" id="wcsellBTC" name="wcsellBTC" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount2']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCUR</button>
            </span>
          </div>
          <label for="moneyrecBTC">Receive BTC</label>
          <div class="input-group">
            <input type="text" id="moneyrecBTC" name="moneyrecBTC" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount1']; ?>">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">ETH</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsBR">Commission
              <span id="commissionsBR">0</span> WC
            </label>
          </div>
          <label for="myBTCrec">My Bitcoin wallet (for comparison)</label>
          <div class="form-group">
            <input type="text" id="myBTCrec" name="myBTCrec" class="form-control col-md-7 col-xs-12" value="">
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendredeemBTC" onclick="sendredeemBTC(); return false;">Send request</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Restricted to Unrestricted -->
  <div class="modal fade" id="tokenChngModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content sentrequestChng">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Get token</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <label for="moneysellWCR">Spend WCR</label>
          <div class="input-group">
            <input type="text" id="moneysellWCR" name="moneysellWCR" class="form-control col-md-7 col-xs-12" value="1">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCR</button>
            </span>
          </div>
          <label for="wcbuyWCUR">Buy WCUR</label>
          <div class="input-group">
            <input type="text" id="wcbuyWCUR" name="wcbuyWCUR" class="form-control col-md-7 col-xs-12" value="1">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">WCUR</button>
            </span>
          </div>
          <div class="form-group">
            <label for="commissionsUR">Commission
              <span id="commissionsUR">0</span> WC
            </label>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary sendreqWCUR" onclick="sendreqWCUR(); return false;">Send request</button>
        </div>
      </div>
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
  <!-- pace -->
  <script src="../js/pace/pace.min.js"></script>
  <!-- PNotify -->
  <script type="text/javascript" src="../js/notify/pnotify.core.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.buttons.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.nonblock.js"></script>

  <script type="text/javascript" src="../js/app.js"></script>
  
  <script>
    $(function() {
      
    })
  </script>

  <script>

    var percentage = 0;
    var bitcoincost = 0;
    var ethercost = 0;

    var exchangeusd = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>;
    var exchangewcr = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount2']; ?>;
    var exchangeeth = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>;
    var exchangewcur = <?php echo $sql->getExchangeRate('ETH', 'WCUR')['amount2']; ?>;
    var exchangebtc = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>;

    var getbalamnt = "<?php echo $sql->getBalance(0)['amount']; ?>";

  </script>
  <script type="text/javascript" src="../js/fillbalance/reqredeem.js"></script>
  <script type="text/javascript" src="../js/fillbalance/buysell.js"></script>

</body>

</html>
