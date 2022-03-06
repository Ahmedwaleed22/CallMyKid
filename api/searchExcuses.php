<?php
session_start();

if (!isset($_SESSION['email'])) {
  echo json_encode([
    "Error" => "You are not allowed to access this part"
  ]);

  exit;
}

require_once "init.php";

$search_keyword = filter_var($_GET['keyword'], FILTER_SANITIZE_STRING);
$search_date = filter_var($_GET['date'], FILTER_SANITIZE_STRING);

$excusesInstance = new Excuses($_SESSION['email']);

echo json_encode($excusesInstance->searchExcuses($search_keyword, $search_date));
