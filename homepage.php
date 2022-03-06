<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "homepage.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";
?>

<div class="pageContainer">
  <img src="static/svg/buslogo.svg" alt="buslogo">
  <p>Organizing safe departure in schools and using the latest technologies and employing them for a safe, smooth and easier exit</p>
</div>

<?php
require $inc . 'footer.inc.php';
?>