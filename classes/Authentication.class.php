<?php

class Authentication extends Dbh
{
  public function login($email, $password)
  {
    $sql = "SELECT email_address, password FROM admins WHERE email_address = ? LIMIT 1";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(array($email));
    $row = $stmt->fetch();

    if ($stmt->rowCount() > 0) {
      if (password_verify($password, $row['password'])) {
        return json_encode([
          'auth' => true,
          'email' => $row['email_address']
        ]);
      }
    }

    return json_encode([
      'auth' => false
    ]);
  }
}
