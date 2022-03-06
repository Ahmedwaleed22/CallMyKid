<?php

class Excuses extends Dbh
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

  public function searchExcuses($keyword, $date)
  {
    $sql = "SELECT excuses.*, students.*, excuses.ID as excuse_id FROM excuses INNER JOIN students ON excuses.student_id = students.ID WHERE students.school_id = ? AND students.first_name LIKE '%" . $keyword . "%' AND DATE(excuses.excuse_date) = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_school_id, $date]);

    while ($rows = $stmt->fetchAll()) {
      return $rows;
    }
  }

  public function getSingleExcuse($excuse_id)
  {
    $sql = "SELECT excuses.*, students.school_id as school_id, students.ID as student_table_id FROM excuses INNER JOIN students ON excuses.student_id = students.ID WHERE school_id = ? AND excuses.ID = ? LIMIT 1";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_school_id, $excuse_id]);

    return $stmt->fetch();
  }

  public function sendAbsenceNotice($message_subject, $message_receivers, $message)
  {
    $sql = "INSERT INTO absence_notice_messages (message_subject, message_receivers, message, admin_id) VALUES (?, ?, ?, ?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$message_subject, $message_receivers, $message, $this->admin_id]);

    return $stmt->rowCount() ? true : false;
  }
}
