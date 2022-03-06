<?php
session_start();

if (!isset($_SESSION['email'])) {
  echo json_encode([
    "Error" => "You are not allowed to access this part"
  ]);

  exit;
}

require_once "init.php";

$keyword = filter_var($_GET['keyword'], FILTER_SANITIZE_STRING);

$studentsInstance = new Students($_SESSION['email']);

echo json_encode($studentsInstance->searchStudents($keyword));
