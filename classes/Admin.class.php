<?php

class Admin extends Dbh
{
  public function __construct($email)
  {
    $this->current_email = $email;
  }

  public function getAdminData()
  {
    $sql = "SELECT * FROM admins WHERE email_address = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->current_email]);
    $row = $stmt->fetch();

    return $row;
  }

  public function editAdminData($username, $first_name, $last_name, $email, $new_password, $confirm_password)
  {
    if ($username == "" || $first_name == "" || $last_name == "" || $email == "" || $new_password == "" || $confirm_password == "") {
      return json_encode([
        "success" => false,
        "message" => "All fields are required."
      ]);
    }

    if ($new_password == $confirm_password) {
      $password = password_hash($new_password, PASSWORD_DEFAULT);
    } else {
      return json_encode([
        "success" => false,
        "message" => "Both passwords not matching."
      ]);
    }

    $sql = "UPDATE admins SET username = ?, first_name = ?, last_name = ?, email_address = ?, password = ? WHERE email_address = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$username, $first_name, $last_name, $email, $password, $this->current_email]);

    if ($stmt->rowCount()) {
      return json_encode([
        "success" => true,
        "email" => $email,
      ]);
    }

    return json_encode([
      "success" => false,
      "message" => "Couldn't Update Account Information."
    ]);
  }
}
