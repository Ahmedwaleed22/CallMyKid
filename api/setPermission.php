<?php
session_start();

if (!isset($_SESSION['email'])) {
  echo json_encode([
    "Error" => "You are not allowed to access this part"
  ]);

  exit;
}

require_once "init.php";

if (isset($_GET['message'])) {
  $message = filter_var($_GET['message'], FILTER_SANITIZE_STRING);
} else {
  $message = "";
}

$status = filter_var($_GET['status'], FILTER_SANITIZE_STRING);
$permission_id = filter_var($_GET['permission_id'], FILTER_SANITIZE_STRING);

$permissionInstance = new Permissions($_SESSION['email']);
$setPermission = $permissionInstance->setPermissionRequest($status, $message, $permission_id);

if ($setPermission && $status == "accepted") {
  header('Location: ../successPage.php?message=Acceptable');
  exit;
} else {
  header('Location: ../failPage.php');
  exit;
}
