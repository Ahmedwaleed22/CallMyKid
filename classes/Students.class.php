<?php

class Students extends Dbh
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

  public function fetch($student_id)
  {
    $sql = "SELECT * FROM students WHERE ID_number = ? AND school_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$student_id, $this->admin_school_id]);
    $row = $stmt->fetch();

    return $row;
  }

  public function fetchAll()
  {
    $sql = "SELECT * FROM students WHERE school_id = ? ORDER BY ID DESC";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_school_id]);

    while ($rows = $stmt->fetchAll()) {
      return $rows;
    }
  }

  public function addStudent($firstName, $lastName, $mobileNumber, $emailAddress, $age)
  {
    $sql = "INSERT INTO students (first_name, last_name, mobile_number, email_address, age, school_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$firstName, $lastName, $mobileNumber, $emailAddress, $age, $this->admin_school_id]);

    if ($stmt->rowCount()) {
      return json_encode([
        "success" => true
      ]);
    }

    return json_encode([
      "success" => false
    ]);
  }

  public function searchStudents($keyword)
  {
    $sql = "SELECT * FROM students WHERE first_name LIKE '%" . $keyword . "%' AND school_id = ? ORDER BY ID DESC";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_school_id]);

    while ($rows = $stmt->fetchAll()) {
      return $rows;
    }
  }

  public function deleteStudent($id)
  {
    $sql = "DELETE FROM students WHERE ID = ? AND school_id = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$id, $this->admin_school_id]);

    if ($stmt->rowCount()) {
      return json_encode([
        "success" => true
      ]);
    }

    return json_encode([
      "success" => false
    ]);
  }

  public function studentsLog()
  {
    $sql = "SELECT DISTINCT students_logs.student_id, students.* FROM students_logs INNER JOIN students ON students_logs.student_id = students.ID WHERE students.school_id = ? ORDER BY Date DESC";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_school_id]);

    while ($rows = $stmt->fetchAll()) {
      return $rows;
    }
  }

  public function searchStudentsLog($student_id)
  {
    $sql = "SELECT DISTINCT students_logs.student_id, students.* FROM students_logs INNER JOIN students ON students_logs.student_id = students.ID WHERE students.school_id = ? AND ID_number LIKE '%" . $student_id . "%' ORDER BY Date DESC";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_school_id]);

    while ($rows = $stmt->fetchAll()) {
      return $rows;
    }
  }

  public function studentCheckInOut($student_id)
  {
    $sql = "SELECT students_logs.*, students.* FROM students_logs INNER JOIN students ON students_logs.student_id = students.ID WHERE students.school_id = ? AND students.ID_number = ? ORDER BY Date DESC";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_school_id, $student_id]);

    while ($rows = $stmt->fetchAll()) {
      return $rows;
    }
  }

  public function searchStudentLog($month, $year, $student_id, $absence)
  {
    $month_number = date("m", strtotime($month));

    if ($absence == 'false') {
      $sql = "SELECT students_logs.*, students.* FROM students_logs INNER JOIN students ON students_logs.student_id = students.ID WHERE students.school_id = ? AND students.ID_number = ? AND (MONTH(students_logs.date) = ?) AND (YEAR(students_logs.date) = ?) AND students_logs.check_in_time IS NOT NULL AND students_logs.check_out_time IS NOT NULL ORDER BY Date DESC";
    } else {
      $sql = "SELECT students_logs.*, students.* FROM students_logs INNER JOIN students ON students_logs.student_id = students.ID WHERE students.school_id = ? AND students.ID_number = ? AND (MONTH(students_logs.date) = ?) AND (YEAR(students_logs.date) = ?) AND students_logs.check_in_time IS NULL AND students_logs.check_out_time IS NULL ORDER BY Date DESC";
    }
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->admin_school_id, $student_id, $month_number, $year]);

    while ($rows = $stmt->fetchAll()) {
      return $rows;
    }
  }
}
