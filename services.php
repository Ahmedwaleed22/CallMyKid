<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "services.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";
?>
<div class="pageContainer">
  <div class="cards">
    <a class="cardLink" href="studentsInfo.php">
      <div class="card">
        <img src="static/svg/studentInfo.svg" alt="studentInfo" />
        <h2>Student information and guardian</h2>
      </div>
    </a>
    <a class="cardLink" href="studentsLog.php">
      <div class="card">
        <img src="static/svg/studentLog.svg" alt="studentInfo" />
        <h2>Student log</h2>
      </div>
    </a>
    <a class="cardLink" href="messages.php">
      <div class="card">
        <img src="static/svg/messages.svg" alt="studentInfo" />
        <h2>messages</h2>
      </div>
    </a>
  </div>
  <a href="homepage.php" class="back-home-button">Back Home</a>
</div>

<?php
require $inc . 'footer.inc.php';
?>