<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "emergencymessages.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $message_subject = "Emergency Messages";
  $message_to = "All Students";
  $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

  $messageInstance = new Messages($_SESSION['email']);
  $sendEmergencyMessage = $messageInstance->sendEmergencyMessage($message_subject, $message_to, $message);

  if ($sendEmergencyMessage) {
    header("Location: successPage.php");
    exit;
  } else {
    header("Location: failPage.php");
    exit;
  }
}
?>

<div class="pageContainer">
  <div class="to_container">
    <span>TO</span>
    <h3>All the students</h3>
  </div>
  <div class="subject_container">
    <span>Subject:</span>
    <h3 class="message_type">emergency messages</h3>
  </div>
  <div class="text_area_container">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <textarea name="message" id="" cols="30" rows="10" placeholder="Text Writing..."></textarea>
      <button type="submit">Send</button>
    </form>
  </div>
</div>
<div class="actions">
  <a href="messages.php">Back</a>
</div>

<?php
require $inc . "footer.inc.php";
?>