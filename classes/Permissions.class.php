<?php

class Permissions extends Dbh
{
  public function __construct($email)
  {
    $this->getAdminSchoolID($email);
  }

  private function getAdminSchoolID($email)
  {
    $sql = "SELECT * FROM admins WHERE email_address = ? LIMIT 1";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();

    $this->admin_school_id = $row['school_id'];
    $this->admin_id = $row['ID'];
  }

  public function getPermissionsRequests($keyword, $date)
  {
    $sql = "SELECT permissions.*, students.*, permissions.ID as permission_id FROM `permissions` INNER JOIN students ON permissions.student_id = students.ID WHERE students.school_id = ? AND DATE(permissions.permission_ask_date) = ? AND students.first_name LIKE '%" . $keyword . "%'";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_school_id, $date]);

    while ($rows = $stmt->fetchAll()) {
      return $rows;
    }
  }

  public function setPermissionRequest($status, $message, $permission_id)
  {
    $sql = "UPDATE permissions SET `status` = ?, `message` = ?, admin_id = ? WHERE ID = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$status, $message, $this->admin_id, $permission_id]);

    return $stmt->rowCount() ? true : false;
  }

  public function getSinglePermission($permission_id)
  {
    $sql = "SELECT permissions.*, students.*, permissions.ID as permission_id FROM permissions INNER JOIN students ON permissions.student_id = students.ID WHERE permissions.ID = ? AND students.school_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$permission_id, $this->admin_school_id]);
    $row = $stmt->fetch();

    return $row;
  }
}
