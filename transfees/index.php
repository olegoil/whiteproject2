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

  <title>Transactions | White Standard</title>

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
        <div class="">

          <div class="page-title">
            <div class="title_left">
                <h3>
                    Transaction fees
                    <small>
                        A list of transaction fees
                    </small>
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>


          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">

                <div class="x_content">

                    <!-- start accordion -->
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <a class="panel-heading" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                <h4 class="panel-title">Transaction Fee</h4>
                            </a>
                            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">

                                    <form id="exchng" name="exchng">
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="usdwcr">USD to WCR
                                            <div class="input-group col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="usdwcr" name="usdwcr" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getFee('USD', 'WCR')['fee']; ?>" >
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary">%</button>
                                                </span>
                                            </div>
                                        </label>
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="wcrusd">WCR to USD
                                            <div class="input-group col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="wcrusd" name="wcrusd" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getFee('WCR', 'USD')['fee']; ?>" >
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary">%</button>
                                                </span>
                                            </div>
                                        </label>
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="wcrwcur">WCR to WCUR
                                            <div class="input-group col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="wcrwcur" name="wcrwcur" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getFee('WCR', 'WCUR')['fee']; ?>" >
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary">%</button>
                                                </span>
                                            </div>
                                        </label>
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="ethwcur">ETH to WCUR
                                            <div class="input-group col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="ethwcur" name="ethwcur" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getFee('ETH', 'WCUR')['fee']; ?>" >
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary">%</button>
                                                </span>
                                            </div>
                                        </label>
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="bawcr">Bank Account to WCR
                                            <div class="input-group col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="bawcr" name="bawcr" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getFee('BA', 'WCR')['fee']; ?>" >
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary">%</button>
                                                </span>
                                            </div>
                                        </label>
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="cawcr">ACH transfer to WCR
                                            <div class="input-group col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="cawcr" name="cawcr" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getFee('CA', 'WCR')['fee']; ?>" >
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary">%</button>
                                                </span>
                                            </div>
                                        </label>
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="ccwcr">Credit Card to WCR
                                            <div class="input-group col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="ccwcr" name="ccwcr" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getFee('CC', 'WCR')['fee']; ?>" >
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary">%</button>
                                                </span>
                                            </div>
                                        </label>
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="btcwcr">BTC to WCR
                                            <div class="input-group col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="btcwcr" name="btcwcr" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getFee('BTC', 'WCR')['fee']; ?>" >
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary">%</button>
                                                </span>
                                            </div>
                                        </label>
                                        <div class="input-group col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label col-md-6 col-sm-6 col-xs-12"> &nbsp;
                                                <button type="button" class="form-control col-md-7 col-xs-12 btn btn-success feesave">Save</button>
                                            </label>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h4 class="panel-title">White Standard Quote</h4>
                            </a>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                <form id="whitequote" name="whitequote">
                                    <div class="form-group">
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="wcrquote">USD
                                            <input type="text" id="wcrquote" name="wcrquote" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>" >
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-6 col-sm-6 col-xs-12"> &nbsp;
                                            <button type="button" class="form-control col-md-7 col-xs-12 btn btn-success" onclick="saveQuote()">Save</button>
                                        </label>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of accordion -->

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

  <script>
    
  <script src="../js/transfees/saveget.js"></script>

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

</body>

</html>
