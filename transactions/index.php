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
                    Transactions
                    <small>
                        A list of made transactions
                    </small>
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>


          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">

                <div class="x_content">

                  <table id="transTable" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%"></table>

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

  <script src="../js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="../js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="../js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="../js/icheck/icheck.min.js"></script>

  <script src="../js/custom.js"></script>

  <!-- pace -->
  <script src="../js/pace/pace.min.js"></script>

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
    var uid = '<?php echo $sql->getUser()['user_id'] ?>';
    var bankId = <?php echo '"'.$sql->adminGetBank()['recid'].'"'; ?>;
    var utype = <?php echo '"'.$sql->checkLevel().'"'; ?>;
  </script>
  <script type="text/javascript" src="../js/etherbalance.js"></script>
  <script type="text/javascript" src="../js/transactions/transtbls.js"></script>
  <script type="text/javascript" src="../js/transactions/transopts.js"></script>

</body>

</html>