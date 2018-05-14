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

  <title>Main | <?php echo COIN_NAME; ?></title>

  <?php
    include '../incs/cssload.php';
  ?>
  <script src="../js/jquery.min.js"></script>
</head>

<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <?php include '../incs/navigation.php'; ?>

      <!-- page content -->
      <div class="right_col" role="main">

        <br />
        <div class="">

          <div class="val top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-krw"></i>
                </div>
                <div class="count wcrestricted"><?php echo round($sql->getExchangeRate('USD', 'WCR')['amount1'], 3); ?></div>

                <h3><?php echo COIN_NAME; ?></h3>
                <p>Exchange rate.</p>
              </div>
            </div>
            <!-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-krw"></i>
                </div>
                <div class="count wcunrestricted"><?php echo round($sql->getBalance(1)['amount'], 8); ?></div>

                <h3>WC Unrestricted</h3>
                <p>External wallet.</p>
              </div>
            </div> -->
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-bitcoin"></i>
                </div>
                <div class="count bitcoin"></div>

                <h3>Bitcoin</h3>
                <p>Exchange rate.</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-inr"></i>
                </div>
                <div class="count ether"></div>

                <h3>Ethereum</h3>
                <p>Exchange rate.</p>
              </div>
            </div>
          </div>

          <div class="val">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Transaction Summary <small>Monthly progress</small></h2>
                  <!-- <div class="filter">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>January 30, <?php echo date('Y'); ?> - Juni 28, <?php echo date('Y'); ?></span> <b class="caret"></b>
                    </div>
                  </div> -->
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="demo-container" style="height:280px">
                      <div id="placeholder33x" class="demo-placeholder"></div>
                    </div>
                    <div class="tiles">
                      <div class="col-md-4 tile">
                        <span>Incoming Us. Dollar Transactions</span>
                        <h2>$<?php echo $sql->getIncomeTransactions() * $sql->getExchangeRate('USD', 'WCR')['amount1']; ?></h2>
                        <span class="sparkline11 graph" style="height: 160px;">
                          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                        </span>
                      </div>
                      <div class="col-md-4 tile">
                        <span>Total Balance in USD Value</span>
                        <h2>$<?php echo $sql->getBalance(0)['amount'] * $sql->getExchangeRate('USD', 'WCR')['amount1']; ?></h2>
                        <span class="sparkline22 graph" style="height: 160px;">
                          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                        </span>
                      </div>
                      <div class="col-md-4 tile">
                        <span>Outgoing Transactions</span>
                        <h2>$<?php echo $sql->getOutTransactions() * $sql->getExchangeRate('USD', 'WCR')['amount1']; ?></h2>
                        <span class="sparkline11 graph" style="height: 160px;">
                          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                        </span>
                      </div>
                    </div>

                  </div>

                  <div class="col-md-3 col-sm-12 col-xs-12">
                    <div>
                      <div class="x_title">
                        <h2>Transactions</h2>
                        <div class="clearfix"></div>
                      </div>
                      <ul class="list-unstyled top_profiles scroll-view">
                        <?php
                          $tg = json_decode($sql->getTransactionsGraph(), true);
                          foreach($tg as $val) {
                            // COIN BUY
                            if($val['wallet_from'] == $sql->getBank()['recid'] && $val['wallet_to'] == $sql->getUser()['user_id'] && $val['userid'] == $sql->getUser()['user_id']) {
                              $handleBtn = 'Pending';
                              $backcolor = 'aero';
                              if($val['acception'] == 0) {
                                  $handleBtn = 'Pending';
                                  $backcolor = 'aero';
                              }
                              else if($val['acception'] == 1) {
                                  $handleBtn = 'Aprofed';
                                  $backcolor = 'green';
                              }
                              else if($val['acception'] == 2) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 3) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 4) {
                                  $handleBtn = 'Pending';
                                  $backcolor = 'blue';
                              }
                              else if($val['acception'] == 6) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 7) {
                                  $handleBtn = 'Aprofed';
                                  $backcolor = 'green';
                              }
                              echo '<li class="media event">
                                <a class="pull-left border-'.$backcolor.' profile_thumb">
                                  <i class="fa fa-user '.$backcolor.'"></i>
                                </a>
                                <div class="media-body">
                                  <a class="title" href="#">'.COIN_NAME.' Purchase</a>
                                  <p><strong>$'.$val['amount_from'].'. </strong>'.$handleBtn.'</p>
                                  <p><small>'.date('m/d/Y h:i A', $val['datetime']).'</small></p>
                                </div>
                              </li>';
                            }
                            // COIN SELL
                            else if($val['wallet_from'] == $sql->getUser()['user_id'] && $val['wallet_to'] == $sql->getBank()['recid'] && $val['userid'] == $sql->getUser()['user_id']) {
                              $handleBtn = 'Pending';
                              $backcolor = 'aero';
                              if($val['acception'] == 0) {
                                  $handleBtn = 'Pending';
                                  $backcolor = 'aero';
                              }
                              else if($val['acception'] == 1) {
                                  $handleBtn = 'Aprofed';
                                  $backcolor = 'green';
                              }
                              else if($val['acception'] == 2) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 3) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 4) {
                                  $handleBtn = 'Pending';
                                  $backcolor = 'blue';
                              }
                              else if($val['acception'] == 6) {
                                  $handleBtn = 'Declined';
                                  $backcolor = 'red';
                              }
                              else if($val['acception'] == 7) {
                                  $handleBtn = 'Aprofed';
                                  $backcolor = 'green';
                              }
                              echo '<li class="media event">
                                <a class="pull-left border-'.$backcolor.' profile_thumb">
                                  <i class="fa fa-user '.$backcolor.'"></i>
                                </a>
                                <div class="media-body">
                                  <a class="title" href="#">'.COIN_NAME.' Sale</a>
                                  <p><strong>₩'.$val['amount_from'].'. </strong>'.$handleBtn.'</p>
                                  <p><small>'.date('m/d/Y h:i A', $val['datetime']).'</small></p>
                                </div>
                              </li>';
                            }
                            // COIN SEND
                            else if(($val['wallet_from'] == $sql->getBalance(0)['recid'] && $val['wallet_to'] != $sql->getBalance(0)['recid']) || ($val['wallet_from'] == $sql->getBalance(1)['recid'] && $val['wallet_to'] != $sql->getBalance(1)['recid']) || ($val['wallet_from'] == $sql->getBalance(2)['recid'] && $val['wallet_to'] != $sql->getBalance(2)['recid']) || ($val['wallet_from'] == $sql->getBalance(3)['recid'] && $val['wallet_to'] != $sql->getBalance(3)['recid']) && $val['userid'] == $sql->getUser()['user_id']) {
                              echo '<li class="media event">
                                <a class="pull-left border-green profile_thumb">
                                  <i class="fa fa-user green"></i>
                                </a>
                                <div class="media-body">
                                  <a class="title" href="#">'.COIN_NAME.' Send</a>
                                  <p><strong>₩'.$val['amount_from'].'. </strong>Sent to other user</p>
                                  <p><small>'.date('m/d/Y h:i A', $val['datetime']).'</small></p>
                                </div>
                              </li>';
                            }
                            // COIN RECEIVE
                            else if(($val['wallet_from'] != $sql->getBalance(0)['recid'] && $val['wallet_to'] == $sql->getBalance(0)['recid']) || ($val['wallet_from'] != $sql->getBalance(1)['recid'] && $val['wallet_to'] == $sql->getBalance(1)['recid']) || ($val['wallet_from'] != $sql->getBalance(2)['recid'] && $val['wallet_to'] == $sql->getBalance(2)['recid']) || ($val['wallet_from'] != $sql->getBalance(3)['recid'] && $val['wallet_to'] == $sql->getBalance(3)['recid']) && $val['userid'] != $sql->getUser()['user_id']) {
                              echo '<li class="media event">
                                <a class="pull-left border-green profile_thumb">
                                  <i class="fa fa-user green"></i>
                                </a>
                                <div class="media-body">
                                  <a class="title" href="#">'.COIN_NAME.' Receive</a>
                                  <p><strong>₩'.$val['amount_from'].'. </strong>Received from other user</p>
                                  <p><small>'.date('m/d/Y h:i A', $val['datetime']).'</small></p>
                                </div>
                              </li>';
                            }
                            // BANK WIRE
                            // else if($val['wallet_from'] == $sql->getUser()['user_id'] && $val['wallet_to'] == $sql->getBank()['recid'] && $val['userid'] == $sql->getUser()['user_id']) {
                              
                            // }
                          }
                        ?>
                        <!-- <li class="media event">
                          <a class="pull-left border-green profile_thumb">
                            <i class="fa fa-user green"></i>
                          </a>
                          <div class="media-body">
                            <a class="title" href="#">Restricted Wallet Credit</a>
                            <p><strong>₩ 19,600.00 </strong>Clearing Pending</p>
                            <p> <small>03/25/2018</small>
                            </p>
                          </div>
                        </li>
                        <li class="media event">
                          <a class="pull-left border-blue profile_thumb">
                            <i class="fa fa-user blue"></i>
                          </a>
                          <div class="media-body">
                            <a class="title" href="#"><?php echo COIN_NAME; ?> Sale</a>
                            <p><strong>₩ 40,000.00 </strong>Smart Contract Sent </p>
                            <p> <small>03/21/2018</small>
                            </p>
                          </div>
                        </li>
                        <li class="media event">
                          <a class="pull-left border-aero profile_thumb">
                            <i class="fa fa-user aero"></i>
                          </a>
                          <div class="media-body">
                            <a class="title" href="#">Bank Wire #2667899178991</a>
                            <p><strong>$39,200.00 </strong> Agent Avarage Sales </p>
                            <p> <small>03/21/2018</small>
                            </p>
                          </div>
                        </li>
                        <li class="media event">
                          <a class="pull-left border-green profile_thumb">
                            <i class="fa fa-user green"></i>
                          </a>
                          <div class="media-body">
                            <a class="title" href="#">Restricted to Unrestricted Wallet transfer</a>
                            <p><strong>₩ 12,375.00. </strong> Agent Avarage Sales </p>
                            <p> <small>03/21/2018</small>
                            </p>
                          </div>
                        </li> -->
                      </ul>
                    </div>
                  </div>

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
  <script src="../js/nicescroll/jquery.nicescroll.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="../js/progressbar/bootstrap-progressbar.min.js"></script>
  <!-- icheck -->
  <script src="../js/icheck/icheck.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="../js/moment/moment.min.js"></script>
  <script type="text/javascript" src="../js/datepicker/daterangepicker.js"></script>
  <!-- chart js -->
  <script src="../js/chartjs/chart.min.js"></script>
  <!-- sparkline -->
  <script src="../js/sparkline/jquery.sparkline.min.js"></script>

  <script src="../js/custom.js"></script>

  <!-- flot js -->
  <!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
  <script type="text/javascript" src="../js/flot/jquery.flot.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.pie.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.orderBars.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.time.min.js"></script>
  <script type="text/javascript" src="../js/flot/date.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.spline.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.stack.js"></script>
  <script type="text/javascript" src="../js/flot/curvedLines.js"></script>
  <script type="text/javascript" src="../js/flot/jquery.flot.resize.js"></script>
  <!-- pace -->
  <script src="../js/pace/pace.min.js"></script>
  <!-- PNotify -->
  <script type="text/javascript" src="../js/notify/pnotify.core.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.buttons.js"></script>
  <script type="text/javascript" src="../js/notify/pnotify.nonblock.js"></script>
  <!-- flot -->
  <script type="text/javascript" src="../js/app.js"></script>

  <script>
  
    //define chart clolors ( you maybe add more colors if you want or flot will add it automatic )
    var chartColours = ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];

    //generate random number for charts
    randNum = function() {
      return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
    }

    var transarr = <?php echo $sql->getTransactionsGraph(); ?>;
    var today = new Date();
        today = (today.getTime() / 1000).toFixed(0);
        today = parseInt(today)+86400;
    var firstday = parseInt(today) - (30*24*60*60);

    var uid = '<?php echo $_COOKIE['u']; ?>';
    
  </script>

  <script type="text/javascript" src="../js/main/charts.js"></script>
</body>

</html>
