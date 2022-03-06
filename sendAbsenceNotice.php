<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "sendAbsenceNotice.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$receivers = explode("|", filter_var($_GET['receivers'], FILTER_SANITIZE_STRING));

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
  $excuseInstance = new Excuses($_SESSION['email']);
  $excuseInsert = $excuseInstance->sendAbsenceNotice('Absence notice', filter_var($_GET['receivers'], FILTER_SANITIZE_STRING), $message);

  if ($excuseInsert) {
    header('Location: successPage.php');
    exit;
  } else {
    header('Location: failPage.php');
    exit;
  }
}
?>

<div class="pageContainer">
  <div class="to_container">
    <span>TO</span>
    <ul>
      <?php
      foreach ($receivers as $receiver) {
      ?>
        <li><?php echo $receiver ?></li>
      <?php
      }
      ?>
    </ul>
  </div>
  <div class="subject_container">
    <span>Subject:</span>
    <h3 class="message_type">Absence notice</h3>
  </div>
  <div class="text_area_container">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>?receivers=<?php echo filter_var($_GET['receivers'], FILTER_SANITIZE_STRING) ?>" method="POST">
      <textarea name="message" cols="30" rows="10" placeholder="Text Writing..."></textarea>
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