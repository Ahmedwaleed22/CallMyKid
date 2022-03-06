<?php

class Messages extends Dbh
{
  public function __construct($email)
  {
    $userSQL = "SELECT * FROM admins WHERE email_address = ?";
    $userStmt = $this->connect()->prepare($userSQL);
    $userStmt->execute([$email]);
    $userRow = $userStmt->fetch();

    $this->email = $email;
    $this->admin_id = $userRow['ID'];
  }

  public function sendEmergencyMessage($message_subject, $message_to, $message)
  {
    $sql = "INSERT INTO emergency_messages (message_subject, message_to, message, admin_id) VALUES (?, ?, ?, ?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$message_subject, $message_to, $message, $this->admin_id]);

    return $stmt->rowCount() ? true : false;
  }
}
