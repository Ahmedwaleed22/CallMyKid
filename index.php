<?php
session_start();

if (isset($_SESSION['email'])) {
  header('Location: homepage.php');
  exit;
}

$custom_styles = "prelogin.css";

require "init.php";
require $inc . "header.inc.php";

?>
<div class="preLoginPageContainer">
  <img src="static/img/logo.png" alt="logo" />
  <a href="login.php" class="sign-in-button">Sign In</a>
</div>