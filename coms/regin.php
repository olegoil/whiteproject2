<?php

if(isset($_POST['email']) && isset($_POST['password'])) {

  include '../conns/config.php';
  include '../conns/whiteauth.php';

  $email = "-1";
  if (isset($_POST['email'])) {
    $email = $sql->protect($_POST['email']);
  }

  $pwd = "-1";
  if (isset($_POST['password'])) {
    $pwd = $sql->protect($_POST['password']);
  }

  echo json_encode($sql->registerUser($email, $pwd));

}
else {
  echo 5;
}

?>
