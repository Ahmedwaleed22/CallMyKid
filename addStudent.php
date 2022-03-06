<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "addstudent.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";
?>

<div class="pageContainer">
  <div class="side">
    <h1 class="pageTitle">My Account</h1>
    <img class="studentAvatar" src="static/svg/studentAvatar.svg" alt="student avatar" />
    <img class="studentAvatar" src="static/svg/studentQrCode.svg" alt="student qr code" />
  </div>
  <div class="side">
    <h2 class="side-title">Student Info</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <div class="form-group">
        <label for="username">ID NO</label>
        <input name="username" id="username" type="text" />
      </div>
      <div class="form-group">
        <label for="firstname">First Name</label>
        <input name="first_name" id="firstname" type="text" />
      </div>
      <div class="form-group">
        <label for="lastname">Father Name</label>
        <input name="last_name" id="lastname" type="text" />
      </div>
      <div class="form-group">
        <label for="date_of_birth">Date of birth</label>
        <input id="date_of_birth" type="date">
      </div>
      <div class="form-group">
        <label for="newpassword">Address</label>
        <input name="new_password" id="newpassword" type="text" />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input name="email" id="email" type="email" />
      </div>
      <div class="form-group">
        <label for="mobile">Mobile</label>
        <input name="mobile_number" id="mobile" type="text" />
      </div>
    </form>
  </div>
</div>
<div class="actions">
  <a href="homepage.php">Save</a>
</div>

<?php
require $inc . "footer.inc.php";
?>