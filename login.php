<?php
session_start();
session_regenerate_id();

if (isset($_SESSION['email'])) {
  header('Location: homepage.php');
  exit;
}

$custom_styles = "login.css";

require "init.php";
require $inc . "header.inc.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

  $authentication = new Authentication();
  $login = json_decode($authentication->login($email, $password));

  if ($login->auth) {
    $_SESSION['email'] = $login->email;

    header('Location: homepage.php');
    exit;
  } else {
    $error = 'Email Address Or Password Is Wrong!';
  }
}

?>
<div class="loginPageContainer">
  <div class="side">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <input name="email" type="text" placeholder="Email" id="email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input name="password" type="password" placeholder="Password" id="password">
      </div>
      <button class="sign-in-button">Sign In</button>
    </form>
  </div>
  <div class="side">
    <img src="static/img/logo.png" alt="logo">
  </div>
</div>