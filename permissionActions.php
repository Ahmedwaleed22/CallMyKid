<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "permissionActions.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$permission_id = filter_var($_GET['permission_id'], FILTER_SANITIZE_STRING);

$permissionInstance = new Permissions($_SESSION['email']);
$permission = $permissionInstance->getSinglePermission($permission_id);
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
  <div class="subject_container">
    <span>Subject:</span>
    <h3 class="message_type"><?php echo $permission['subject'] ?></h3>
  </div>
  <div class="text_area_container">
    <textarea name="message" id="message" cols="30" rows="10" placeholder="Text Writing..."></textarea>
    <div class="formActions">
      <div onclick="setStatus(<?php echo $permission['permission_id'] ?>, 'accepted')"><img src="<?php echo $svg ?>approveSign.svg" alt="Approve Sign"></div>
      <div onclick="setStatus(<?php echo $permission['permission_id'] ?>, 'refused')"><img src="<?php echo $svg ?>rejectSign.svg" alt="Reject Sign"></div>
    </div>
  </div>
</div>
<div class="actions">
  <a href="permissions.php">Back</a>
</div>

<?php
require $inc . "footer.inc.php";
?>