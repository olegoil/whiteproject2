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

  <title>Transactions | <?php echo COIN_NAME; ?></title>

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
                    Transactions
                    <small>
                        A list of transactions
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
                            <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title">Bank transactions</h4>
                            </a>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <!-- <p><strong>Bank transactions</strong></p>
                                    <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings">
                                            <th>
                                                <input type="checkbox" id="check-all" class="flat">
                                            </th>
                                            <th class="column-title">RecId </th>
                                            <th class="column-title">UserId </th>
                                            <th class="column-title">Sent </th>
                                            <th class="column-title">Received </th>
                                            <th class="column-title">Commissions </th>
                                            <th class="column-title">Notes </th>
                                            <th class="column-title">Wallet from </th>
                                            <th class="column-title">Wallet to </th>
                                            <th class="column-title">Date </th>
                                            <th class="bulk-actions" colspan="10">
                                            <a class="antoo" style="color:#fff; font-weight:500;">Selected records ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                            </th>
                                            </tr>
                                        </thead>

                                        <?php
                                            // echo $sql->adminGetBankTransactions($sql->adminGetBank()['recid']);
                                        ?>
                                    </table> -->
                                    <table id="transTable" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%"></table>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h4 class="panel-title">User wallets</h4>
                            </a>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <!-- <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings">
                                                <th>
                                                    <input type="checkbox" id="check-all" class="flat">
                                                </th>
                                                <th class="column-title">RecId </th>
                                                <th class="column-title">UserId </th>
                                                <th class="column-title">Type </th>
                                                <th class="column-title">Amount </th>
                                                <th class="column-title">Date </th>
                                                <th class="bulk-actions" colspan="7">
                                                <a class="antoo" style="color:#fff; font-weight:500;">Selected records ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                                </th>
                                            </tr>
                                        </thead>

                                        <?php
                                            // echo $sql->adminGetWallets();
                                        ?>
                                    </table> -->
                                    <table id="walletTable" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%"></table>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <a class="panel-heading" role="tab" id="headingZero" data-toggle="collapse" data-parent="#accordion" href="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                                <h4 class="panel-title">Restricted Bank account</h4>
                            </a>
                            <div id="collapseZero" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingZero">
                                <div class="panel-body">
                                    <!-- <p><strong>Bank transactions</strong></p> -->

                                    <h3>Restricted balance: <?php echo $sql->adminGetBank()['recid']; ?></h3>
                                    <h3 id="bankbalance">Sum: <?php echo $sql->adminGetBank()['amount']; ?></h3>

                                    <form id="tknform" name="tknform">
                                        <div class="input-group">
                                            <input id="crtoken" name="crtoken" type="text" class="form-control" placeholder="Amount of Token to create">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-success tkncreate">Create</button>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <input id="dstoken" name="dstoken" type="text" class="form-control" placeholder="Amount of Token to destroy">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-danger tkndestroy">Destroy</button>
                                            </span>
                                        </div>
                                        <h3>Send restricted tokens to wallet</h3>
                                        <div class="form-group">
                                            <input id="sndtokenadr" name="sndtokenadr" type="text" class="form-control" placeholder="Wallet address">
                                        </div>
                                        <div class="form-group">
                                            <input id="sndnotes" name="sndnotes" type="text" class="form-control" placeholder="Notes">
                                        </div>
                                        <div class="input-group">
                                            <input id="sndtokenamount" name="sndtokenamount" type="text" class="form-control" placeholder="Amount">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary tknsend">Send</button>
                                            </span>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- <div class="panel">
                            <a class="panel-heading" role="tab" id="headingZero" data-toggle="collapse" data-parent="#accordion" href="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                                <h4 class="panel-title">Unrestricted Bank account</h4>
                            </a>
                            <div id="collapseZero" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingZero">
                                <div class="panel-body">

                                    <h3>Unrestricted balance: <span class="unrestrictedwallet">0</span></h3>
                                    <h3>Sum: <span class="wcunrestricted2">0</span></h3>

                                    <form id="tknform2" name="tknform2">
                                        <div class="input-group">
                                            <input id="crtoken2" name="crtoken2" type="text" class="form-control" placeholder="Amount of Token to create">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-success tkncreate2">Create</button>
                                            </span>
                                        </div>
                                        <h3>Send unrestricted tokens to wallet</h3>
                                        <div class="form-group">
                                            <input id="sndtokenadr2" name="sndtokenadr2" type="text" class="form-control" placeholder="Wallet address">
                                        </div>
                                        <div class="form-group">
                                            <input id="sndnotes2" name="sndnotes2" type="text" class="form-control" placeholder="Notes">
                                        </div>
                                        <div class="input-group">
                                            <input id="sndtokenamount2" name="sndtokenamount2" type="text" class="form-control" placeholder="Amount">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary tknsend2">Send</button>
                                            </span>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div> -->
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

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="display:none;">
        Launch modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <p id="detailsbody"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

  <script src="../js/wallets/tokenhandler.js"></script>

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

    <!-- Datatables-->
    <script src="../js/datatables/jquery.dataTables.min.js"></script>
    <script src="../js/datatables/dataTables.bootstrap.js"></script>
    <script src="../js/datatables/dataTables.buttons.min.js"></script>
    <script src="../js/datatables/buttons.bootstrap.min.js"></script>
    <script src="../js/datatables/jszip.min.js"></script>
    <script src="../js/datatables/pdfmake.min.js"></script>
    <script src="../js/datatables/vfs_fonts.js"></script>
    <script src="../js/datatables/buttons.html5.min.js"></script>
    <script src="../js/datatables/buttons.print.min.js"></script>
    <script src="../js/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="../js/datatables/dataTables.keyTable.min.js"></script>
    <script src="../js/datatables/dataTables.responsive.min.js"></script>
    <script src="../js/datatables/responsive.bootstrap.min.js"></script>
    <script src="../js/datatables/dataTables.scroller.min.js"></script>
    <script src="../js/datatables/dataTables.select.min.js"></script>
    <script src="../js/datatables/buttons.colVis.min.js"></script>

    <script type="text/javascript" src="../js/app.js"></script>

  <script>

  var exchangeeth = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>;
  var exchangebtc = <?php echo $sql->getExchangeRate('USD', 'WCR')['amount1']; ?>;
  var ethercost = 1;
  var bitcoincost = 1;
  var recid = <?php echo '"'.$sql->adminGetBank()['recid'].'"'; ?>;

  </script>

    <script type="text/javascript" src="../js/wallets/wallettbls.js"></script>
    <script type="text/javascript" src="../js/wallets/tblhandler.js"></script>

</body>

</html>
