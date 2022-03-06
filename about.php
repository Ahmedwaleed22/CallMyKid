<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "about.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";
?>
<div class="aboutLogo">
  <img src="static/svg/about.svg" alt="About">
</div>
<?php
require $inc . "footer.inc.php";
?>