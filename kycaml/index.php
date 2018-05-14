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

  <title>KYC/AML | White Standard</title>

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
                    KYC/AML's
                    <small>
                        
                    </small>
					<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#minterModal">Create KYC/AML</button>
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>


          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">

                <div class="x_content">

                    <table id="usersTable" class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" cellspacing="0" width="100%"></table>

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

	<!-- Modal create Minter -->
	<div class="modal fade" id="minterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content sentrequest">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Create new KYC/AML</h4>
					<div class="clearfix"></div>
				</div>
				<div class="modal-body">

					<div class="alert alert-success" style="display:none;" id="signUpSuccess">Registration was successfull!</div>
					<div class="alert alert-danger" style="display:none;" id="unknownError">An unknown Error occured.</div>

					<form id="signUpForm" onsubmit="submForm(); return false;" novalidate>
						<div class="form-group">
							<label for="firstname">Firstname</label>
							<input type="text" id="firstname" name="firstname" class="form-control col-md-7 col-xs-12" value="">
						</div>
						<div class="form-group">
							<label for="lastname">Lastname</label>
							<input type="text" id="lastname" name="lastname" class="form-control col-md-7 col-xs-12" value="">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12" value="">
						</div>

						<div class="alert alert-danger" style="display:none;" id="invalidEmail">Please fill a valid Email.</div>
						<div class="alert alert-danger" style="display:none;" id="takenEmail">Email already taken.</div>

						<div class="form-group">
							<label for="pwd">Password</label>
							<input type="password" id="pwd" name="pwd" class="form-control col-md-7 col-xs-12" value="" required pattern="[^ @]*@[^ @]*">
						</div>
						<div class="form-group">
							<label for="pwd2">Password confirmation</label>
							<input type="password" id="pwd2" name="pwd2" class="form-control col-md-7 col-xs-12" value="" required pattern="[^ @]*@[^ @]*">
						</div>

						<div class="alert alert-danger" style="display:none;" id="signUpPassErr">Passwords do not match.</div>
						<div class="alert alert-danger" style="display:none;" id="pwdStrength">Password must be at least 8 characters in length and contain letters, numbers and special characters.</div>
						<div class="alert alert-info" style="display:none;" id="checking">Checking.. Please keep waiting.</div>

						<div class="clearfix"></div>

						<br/>

						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" id="sbmtbtn" class="btn btn-success submit" onclick="submForm(); return false;">Create</button>

					</form>
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
	<script type="text/javascript" src="../js/kycaml/doctbls.js"></script>

</body>

</html>
