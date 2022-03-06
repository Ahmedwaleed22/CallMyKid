<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "studentsLogInfo.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$student_id = filter_var($_GET['student_id'], FILTER_SANITIZE_NUMBER_INT);

$studentsInstance = new Students($_SESSION['email']);
$studentLogs = $studentsInstance->studentCheckInOut($student_id);
$studentInfo = $studentsInstance->fetch($student_id);
?>

<div class="pageContainer">
  <div class="upperPage">
    <div class="studentInfo">
      <img src="static/svg/studentAvatar.svg" alt="Student Avatar" />
      <div class="text">
        <h3 class="studentID">ID NO <?php echo $student_id ?></h3>
        <h3 class="studentName"><?php echo $studentInfo['first_name'] . ' ' . $studentInfo['last_name'] ?></h3>
      </div>
    </div>
    <div class="searchAndDate">
      <!-- <input type="text" placeholder="Search" class="searchBar" /> -->
      <div class="dateController">
        <script>
          const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
          const date = new Date();
          let month = months[date.getMonth()];
          let year = date.getFullYear();

          const refresh_data = async () => {
            const tableBody = document.getElementById('tableBody');
            let matchingData = '';

            const {
              data
            } = await axios.get(`api/searchStudentLog.php?student_id=<?php echo $student_id ?>&month=${month}&year=${year}`) ?? [];

            if (data) {
              data.forEach((log) => {
                const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                const daysDate = new Date(log.date);
                let day = days[daysDate.getDay()];

                matchingData =
                  matchingData +
                  `
                    <tr>
                      <td>${day}</td>
                      <td>${log.date}</td>
                      <td>${log.place_name}</td>
                      <td>${log.check_in_time}</td>
                      <td>${log.check_out_time}</td>
                    </tr>
                  `;

                tableBody.innerHTML = matchingData;
              })
            } else {
              tableBody.innerHTML = '';
            }
          }

          const increaseDate = () => {
            const current_date = document.getElementById("current_date");

            switch (month) {
              case "January":
                month = "February";
                break;
              case "February":
                month = "March";
                break;
              case "March":
                month = "April";
                break;
              case "April":
                month = "May";
                break;
              case "May":
                month = "June";
                break;
              case "June":
                month = "July";
                break;
              case "July":
                month = "August";
                break;
              case "August":
                month = "September";
                break;
              case "September":
                month = "October";
                break;
              case "October":
                month = "November"
                break;
              case "November":
                month = "December";
                break;
              case "December":
                year = +year + 1;
                month = "January";
                break;
              default:
                year = +year + 1;
                month = "January";
                break;
            }

            current_date.textContent = `${month} ${year}`;
            refresh_data();
          }

          const decreaseDate = () => {
            const current_date = document.getElementById("current_date");

            switch (month) {
              case "December":
                month = "November";
                break;
              case "November":
                month = "October";
                break;
              case "October":
                month = "September";
                break;
              case "September":
                month = "August";
                break;
              case "August":
                month = "July";
                break;
              case "July":
                month = "June";
                break;
              case "June":
                month = "May";
                break;
              case "May":
                month = "April"
                break;
              case "April":
                month = "March";
                break;
              case "March":
                month = "February";
                break;
              case "February":
                month = "January"
                break;
              case "January":
                year = +year - 1;
                month = "December"
                break;
              default:
                year = +year - 1;
                month = "December"
                break;
            }

            current_date.textContent = `${month} ${year}`;
            refresh_data();
          }

          window.addEventListener('load', () => {
            current_date.textContent = `${month} ${year}`;

            refresh_data();
          })
        </script>
        <span class="past" onclick="decreaseDate()"><img src="<?php echo $svg ?>pastArrow.svg" alt="past arrow" /></span>
        <span class="current_date" id="current_date"></span>
        <span class="future" onclick="increaseDate()"><img src="<?php echo $svg ?>futureArrow.svg" alt="future arrow" /></span>
      </div>
    </div>
  </div>
  <div class="middlePage">
    <div class="table-container">
      <table>
        <thead>
          <th>Day</th>
          <th>Date</th>
          <th>Place Name</th>
          <th>Check in time</th>
          <th>check out time</th>
        </thead>
        <tbody id="tableBody">
          <!-- <?php
                foreach ($studentLogs as $log) {
                ?>
            <tr>
              <td><?php echo date("D", strtotime($log['date'])) ?></td>
              <td><?php echo $log['date'] ?></td>
              <td><?php echo $log['place_name'] ?></td>
              <td><?php echo $log['check_in_time'] ?></td>
              <td><?php echo date("g:i a", strtotime($log['check_out_time'])) ?></td>
            </tr>
          <?php
                }
          ?> -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
require $inc . "footer.inc.php";
?>