<?php
session_start();

if (!isset($_SESSION['email'])) {
  echo json_encode([
    "Error" => "You are not allowed to access this part"
  ]);

  exit;
}

require_once "init.php";

$student_id = filter_var($_GET['student_id'], FILTER_SANITIZE_NUMBER_INT);

$studentsInstance = new Students($_SESSION['email']);

echo json_encode($studentsInstance->searchStudentsLog($student_id));
