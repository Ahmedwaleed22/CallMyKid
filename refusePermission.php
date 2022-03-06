<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "refusePermission.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$permission_id = filter_var($_GET['permission_id'], FILTER_SANITIZE_STRING);

$permissionInstance = new Permissions($_SESSION['email']);
$permission = $permissionInstance->getSinglePermission($permission_id);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

  header("Location: api/setPermission.php?permission_id=" . $permission_id . "&status=refused&message=" . $message);
  exit;
}
?>

<script>
  const setStatus = (permission_id, status) => {
    const message = document.getElementById('message').value;
    window.open(`api/setPermission.php?permission_id=${permission_id}&status=${status}&message=${message}`, '_self');
  }
</script>
<div class="pageContainer">
  <div class="to_container">
    <span>TO</span>
    <h3><?php echo $permission['first_name'] . ' ' . $permission['last_name'] ?></h3>
  </div>
  <div class="logoContainer">
    <img class="refusingLogo" src="<?php echo $svg ?>rejectSign.svg" alt="Reject Sign">
  </div>
  <div class="text_area_container">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>?permission_id=<?php echo $permission_id ?>" method="POST">
      <textarea name="message" cols="30" rows="10" placeholder="Text Writing..."></textarea>
      <button type="submit">Send</button>
    </form>
  </div>
</div>
<div class="actions">
  <a href="permissions.php">Back</a>
</div>

<?php
require $inc . "footer.inc.php";
?>