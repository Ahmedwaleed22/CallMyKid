<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "editaccount.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $admin = new Admin($_SESSION['email']);

  $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
  $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
  $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
  $new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING);
  $password_confirmation = filter_var($_POST['password_confirmation'], FILTER_SANITIZE_STRING);

  $admin_data = json_decode($admin->editAdminData($username, $first_name, $last_name, $email, $new_password, $password_confirmation));

  if ($admin_data->success) {
    session_regenerate_id();
    $_SESSION['email'] = $admin_data->email;
    header('Location: account.php');
    exit;
  } else {
    $error = $admin_data->message;
  }
}
?>

<div class="pageContainer">
  <div class="side">
    <h1 class="pageTitle">My Account</h1>
    <img class="studentAvatar" src="static/svg/studentAvatar.svg" alt="student avatar" />
  </div>
  <div class="side">
    <h2 class="side-title">Account Information</h2>
    <?php
    if (isset($error)) {
    ?>
      <div class="error"><?php echo $error ?></div>
    <?php
    }
    ?>
    <form id="editAdminForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="form-group required">
        <label for="username">Username</label>
        <input name="username" id="username" type="text" />
      </div>
      <div class="form-group required">
        <label for="firstname">First Name</label>
        <input name="first_name" id="firstname" type="text" />
      </div>
      <div class="form-group required">
        <label for="lastname">Last Name</label>
        <input name="last_name" id="lastname" type="text" />
      </div>
      <div class="form-group required">
        <label for="email">Email</label>
        <input name="email" id="email" type="email" />
      </div>
      <div class="form-group required">
        <label for="newpassword">New Password</label>
        <input name="new_password" id="newpassword" type="password" />
      </div>
      <div class="form-group required">
        <label for="passwordconfirmation">Password Confirmation</label>
        <input name="password_confirmation" id="passwordconfirmation" type="password" />
      </div>
    </form>
  </div>
</div>
<div class="actions">
  <button type="submit" form="editAdminForm">Save</button>
</div>

<?php
require $inc . 'footer.inc.php';
?>