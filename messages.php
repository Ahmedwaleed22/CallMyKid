<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "messages.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";
?>

<div class="pageContainer">
  <h1 class="pageTitle">messages</h1>
  <div class="messageTypesContainer">
    <!-- Start Message Button -->
    <a href="absenceNotices.php">
      <div class="messageButton">
        <img src="<?php echo $svg ?>absenceNoticesButtonIcon.svg" alt="Icon" />
        <span>Absence notices</span>
      </div>
    </a>
    <!-- End Message Button -->

    <!-- Start Message Button -->
    <a href="permissions.php">
      <div class="messageButton">
        <img src="<?php echo $svg ?>permissionsButtonIcon.svg" alt="Icon" />
        <span>Permission and early exit</span>
      </div>
    </a>
    <!-- End Message Button -->

    <!-- Start Message Button -->
    <a href="emergencyMessages.php">
      <div class="messageButton">
        <img src="<?php echo $svg ?>emergencyButtonIcon.svg" alt="Icon" />
        <span>emergency messages</span>
      </div>
    </a>
    <!-- End Message Button -->
  </div>
</div>
<div class="actions">
  <a href="services.php">back</a>
</div>

<?php
require $inc . "footer.inc.php";
?>