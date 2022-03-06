<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "studentExcuse.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$excuse_id = filter_var($_GET['excuse_id'], FILTER_SANITIZE_NUMBER_INT);

$excusesInstance = new Excuses($_SESSION['email']);
$excuse = $excusesInstance->getSingleExcuse($excuse_id);
?>

<div class="pageContainer">
  <img src="<?php echo $excuse['excuse_image'] ?>" alt="">
</div>
<div class="actions">
  <a href="receiveExcuses.php">Back</a>
</div>

<?php
require $inc . 'footer.inc.php';
?>