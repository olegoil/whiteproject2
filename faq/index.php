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

  <title>FAQ | <?php echo COIN_NAME; ?></title>

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
              <h3>FAQ</h3>
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-align-left"></i> Questions and Answers</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <!-- start accordion -->
                  <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">

                    <?php if($sql->checkLevel() == '1') { ?>
                      <!-- <div class="panel">
                        <a class="panel-heading" role="tab" id="headingBtns" data-toggle="collapse" data-parent="#accordion" href="#collapseBtns" aria-expanded="true" aria-controls="collapseBtns">
                          <h4 class="panel-title">Manager actions</h4>
                        </a>
                        <div id="collapseBtns" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingBtns">
                          <div class="panel-body">
                              <button class="btn btn-default" onclick=""></button>
                          </div>
                        </div>
                      </div> -->
                    <?php } ?>

                    <div class="panel">
                      <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h4 class="panel-title">How to get WC?</h4>
                      </a>
                      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <p><strong>Give us Ether</strong></p>
                          Ipsum lorem ...
                        </div>
                      </div>
                    </div>
                    <div class="panel">
                      <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h4 class="panel-title">How to send WC?</h4>
                      </a>
                      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                          <p><strong>Simple send</strong>
                          </p>
                          Lorem ipsum..
                        </div>
                      </div>
                    </div>
                    <div class="panel">
                      <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h4 class="panel-title">Money not received?</h4>
                      </a>
                      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                          <p><strong>Why I don't received money yet?</strong>
                          </p>
                          Lorem Ipsum..
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
  <script type="text/javascript" src="../js/faq/tabs.js"></script>

</body>

</html>
