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

$firstName = filter_var($data['first_name'], FILTER_SANITIZE_STRING);
$lastName = filter_var($data['last_name'], FILTER_SANITIZE_STRING);
$mobileNumber = filter_var($data['mobile_number'], FILTER_SANITIZE_STRING);
$emailAddress = filter_var($data['email_address'], FILTER_SANITIZE_EMAIL);
$age = filter_var($data['age'], FILTER_SANITIZE_NUMBER_INT);

$studentsInstance = new Students($_SESSION['email']);

echo $studentsInstance->addStudent($firstName, $lastName, $mobileNumber, $emailAddress, $age);
