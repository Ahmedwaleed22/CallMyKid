<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "addAbsenceNotices.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$studentsInstance = new Students($_SESSION['email']);
$students = $studentsInstance->fetchAll() ?? [];

$classesInstance = new Classes($_SESSION['email']);
$classes = $classesInstance->fetchAll() ?? [];
?>

<div class="pageContainer">
  <div class="searchBarContainer">
    <input id="searchBar" type="text" placeholder="Search" class="searchBar">
  </div>
  <div class="selectAllContainer">
    <script>
      const receiversName = [];

      Array.prototype.remove = function(from, to) {
        var rest = this.slice((to || from) + 1 || this.length);
        this.length = from < 0 ? this.length + from : from;
        return this.push.apply(this, rest);
      };

      const compose = () => {
        window.open(`sendEmergencyMessages.php?receivers=${receiversName.join("|")}`, '_self');
      }

      window.addEventListener('load', () => {
        const selectAllButton = document.getElementById('selectAllButton');
        const allCheckBoxes = document.querySelectorAll('input[type=checkbox]');

        selectAllButton.addEventListener('click', () => {
          allCheckBoxes.forEach(checkbox => {
            checkbox.checked = !checkbox.checked;
            if (checkbox.checked) {
              receiversName.push(checkbox.getAttribute('data-receivername'));
            } else {
              receiversName.remove(receiversName.indexOf(checkbox.getAttribute('data-receivername')));
            }
          });
        });

        allCheckBoxes.forEach((checkbox) => {
          checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
              receiversName.push(checkbox.getAttribute('data-receivername'));
            } else {
              receiversName.remove(receiversName.indexOf(checkbox.getAttribute('data-receivername')));
            }
          })
        });
      });
    </script>
    <button id="selectAllButton" type="button">Select All</button>
  </div>
  <div class="pageTables">
    <div class="table-container">
      <table>
        <thead>
          <th>ID NO</th>
          <th>Full Name</th>
        </thead>
        <tbody>
          <?php
          foreach ($students as $row) {
          ?>
            <tr>
              <td>
                <span><?php echo $row['ID_number'] ?></span>
                <input type="checkbox" data-receivername="<?php echo $row['first_name'] . " " . $row['last_name'] ?>">
              </td>
              <td><?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <div class="table-container">
      <table>
        <thead>
          <th>ID NO</th>
          <th>Class Name</th>
        </thead>
        <tbody>
          <?php
          foreach ($classes as $class) {
          ?>
            <tr>
              <td>
                <span><?php echo $class['ID'] ?></span>
                <input type="checkbox" data-receivername="<?php echo $class['class_name'] ?>">
              </td>
              <td><?php echo $class['class_name'] ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="actions">
  <a href="absenceNotices.php">back</a>
  <button onclick="compose()" type="button">Compose</button>
</div>

<?php
require $inc . "footer.inc.php";
?>