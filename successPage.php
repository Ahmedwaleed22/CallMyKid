<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "successFailPage.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$message = isset($_GET['message']) ? filter_var($_GET['message'], FILTER_SANITIZE_STRING) : "Done";
?>

<div class="pageContainer">
  <img src="<?php echo $svg ?>successLogo.svg" alt="Success Logo">
  <h2><?php echo $message ?></h2>
  <a class="backButton" href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "homepage.php" ?>">Back</a>
</div>

<?php
require $inc . "footer.inc.php";
?>