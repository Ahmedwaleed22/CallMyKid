<?php
session_start();

if (!isset($_SESSION['email'])) {
  echo json_encode([
    "Error" => "You are not allowed to access this part"
  ]);

  exit;
}

require_once "init.php";

$data = json_decode(file_get_contents('php://input'), true);

$studentID = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

$studentsInstance = new Students($_SESSION['email']);

echo $studentsInstance->deleteStudent($studentID);
