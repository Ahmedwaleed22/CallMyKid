<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "studentsLog.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$studentsInstance = new Students($_SESSION['email']);
$students = $studentsInstance->studentsLog() ?? [];
?>

<div class="pageContainer">
  <h1 class="pageTitle">Student Log</h1>
  <div class="searchBarContainer">
    <input onkeyup="searchStudentsLogs(event)" type="text" placeholder="Search" class="searchBar">
  </div>
  <div class="container">
    <img class="studentsLogIcon" src="static/img/studentsLogIcon.png" alt="Students Log Icon">
    <div class="table-container">
      <table>
        <thead>
          <th>ID NO</th>
          <th>Full Name</th>
        </thead>
        <tbody id="studentsLogTableBody">
          <?php
          foreach ($students as $student) {
          ?>
            <tr>
              <td><?php echo $student['ID_number'] ?></td>
              <td><a href="studentLogInfo.php?student_id=<?php echo $student['ID_number'] ?>"><?php echo $student['first_name'] . " " . $student['last_name'] ?> ></a></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="actions">
    <a href="services.php">Back</a>
  </div>
</div>

<?php
require $inc . "footer.inc.php";
?>