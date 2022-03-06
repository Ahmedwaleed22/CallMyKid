<?php

class Classes extends Dbh
{
  public function __construct($email)
  {
    $this->admin_email = $email;
    $this->admin_school_id = $this->getAdminSchoolID();
  }

  private function getAdminSchoolID()
  {
    $sql = "SELECT school_id FROM admins WHERE email_address = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_email]);
    $row = $stmt->fetch();

    return $row['school_id'];
  }

  public function fetchAll()
  {
    $sql = "SELECT * FROM classes WHERE school_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_school_id]);

    while ($rows = $stmt->fetchAll()) {
      return $rows;
    }
  }
}
