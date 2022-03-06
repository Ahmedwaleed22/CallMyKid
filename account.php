<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "account.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$admin = new Admin($_SESSION['email']);
$adminData = $admin->getAdminData();
?>

<div class="pageContainer">
  <h1 class="pageTitle">My Account</h1>
  <div class="accountCard">
    <img src="static/svg/studentAvatar.svg" alt="student avatar">
    <div class="cardText">
      <h3><?php echo $adminData['ID'] ?></h3>
      <h3><?php echo $adminData['first_name'] . " " . $adminData['last_name'] ?></h3>
      <h3><?php echo $adminData['email_address'] ?></h3>
    </div>
  </div>
  <div class="actions">
    <a href="editAccount.php">Edit</a>
    <a href="homepage.php">Back</a>
  </div>
</div>

<?php
require $inc . 'footer.inc.php';
?>