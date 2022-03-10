<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "studentsinfo.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$studentsInstance = new Students($_SESSION['email']);
$students = $studentsInstance->fetchAll() ?? [];
?>

<script>
  window.addEventListener('load', async () => {
    document.getElementById('deleteButton').addEventListener('click', () => {
      const deletedItems = document.querySelectorAll(".deletedItems");

      deletedItems.forEach(async (item) => {
        if (item.checked) {
          let student_id = item.getAttribute('data-id');

          const {
            data
          } = await axios.post('api/deleteStudent.php', {
            id: student_id
          });

          if (data.success) {
            searchStudents('');
          }
        }
      })
    });
  })
</script>
<div class="pageContainer">
  <input type="text" placeholder="Search" class="searchBar" onkeyup="searchStudents(this.value)">
  <div class="table-container">
    <table>
      <thead>
        <th>#</th>
        <th>ID NO</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Date Of Birth</th>
        <th>Address</th>
        <th>Email</th>
        <th>Mobile</th>
      </thead>
      <tbody id="studentsTableBody">
        <?php
        foreach ($students as $student) {
        ?>
          <tr>
            <td><input type="checkbox" id="<?php echo $student['ID_number'] ?>" class="deletedItems" data-id="<?php echo $student['ID'] ?>" /></td>
            <td><?php echo $student['ID_number'] ?></td>
            <td><?php echo $student['first_name'] ?></td>
            <td><?php echo $student['last_name'] ?></td>
            <td><?php echo $student['date_of_birth'] ?></td>
            <td><?php echo $student['address'] ?></td>
            <td><?php echo $student['email_address'] ?></td>
            <td><?php echo $student['mobile_number'] ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="actions">
    <a href="services.php">Back</a>
    <a href="addStudent.php">Add new</a>
    <a id="deleteButton">Delete</a>
  </div>
</div>

<?php
require $inc . 'footer.inc.php';
?>