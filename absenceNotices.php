<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "absencenotices.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

?>

<div class="pageContainer">
  <h1 class="pageTitle">Absence notices</h1>
  <div class="dateController">
    <span>date:</span>
    <div class="dateCard"><?php echo date('D d/m/Y') ?></div>
  </div>
  <div class="buttonsContainer">
    <a href="addAbsenceNotices.php" class="button">add student</a>
    <a href="receiveExcuses.php" class="button">receiving excuses</a>
  </div>
</div>
<div class="actions">
  <a href="messages.php">Back</a>
</div>

<?php

require $inc . "footer.inc.php";
