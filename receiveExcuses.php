<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "receiveExcuses.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$excusesInstance = new Excuses($_SESSION['email']);
$excuses = $excusesInstance->searchExcuses('', Date("Y-m-d")) ?? [];
?>
<script>
  const updateData = async (keyword, date) => {
    const excusesContainer = document.getElementById("excusesContainer");
    let matchingData = ``;

    const {
      data
    } = await axios.get(`api/searchExcuses.php?keyword=${keyword}&date=${date}`);

    if (data) {
      data.forEach((excuse) => {
        const date = new Date(excuse.excuse_date);
        const daysjs = dayjs(date);

        matchingData += `
          <a class="excuseCardLink" href="studentExcuse.php?excuse_id=${excuse.excuse_id}">
            <div class="excuseCard">
              <div class="avatar">
                <img src="<?php echo $svg ?>studentAvatar.svg" alt="Student Avatar">
                <h3 class="studentFirstName">${excuse.first_name}</h3>
              </div>
              <h2 class="studentName">${excuse.last_name}</h2>
              <div class="excuseInfo">
                <span class="date">${daysjs.format("DD/MM/YYYY")}</span>
                <span class="time">${daysjs.format("hh:mm a")}</span>
                <span class="moreIcon">></span>
              </div>
            </div>
          </a>
        `;

        excusesContainer.innerHTML = matchingData;
      });
    } else {
      excusesContainer.innerHTML = "";
    }
  }

  window.addEventListener('load', () => {
    const searchBar = document.getElementById('searchBar');
    const searchDate = document.getElementById('searchDate');

    searchBar.addEventListener('keyup', () => {
      updateData(searchBar.value, searchDate.value);
    });

    searchDate.addEventListener('change', () => {
      updateData(searchBar.value, searchDate.value);
    });
  });
</script>
<div class="pageContainer">
  <div class="upperPage">
    <input id="searchBar" type="text" placeholder="Search" class="searchBar">
    <div class="dateController">
      <span>date:</span>
      <div class="dateCard">
        <input id="searchDate" type="date" value="<?php echo date("Y-m-d") ?>">
      </div>
    </div>
  </div>
  <div class="excusesContainer" id="excusesContainer">
    <?php
    foreach ($excuses as $excuse) {
    ?>
      <a class="excuseCardLink" href="studentExcuse.php?excuse_id=<?php echo $excuse['excuse_id'] ?>">
        <div class="excuseCard">
          <div class="avatar">
            <img src="<?php echo $svg ?>studentAvatar.svg" alt="Student Avatar">
            <h3 class="studentFirstName"><?php echo $excuse['first_name'] ?></h3>
          </div>
          <h2 class="studentName"><?php echo $excuse['last_name'] ?></h2>
          <div class="excuseInfo">
            <span class="date"><?php echo date("d/m/Y", strtotime($excuse['excuse_date'])) ?></span>
            <span class="time"><?php echo date("H:i a", strtotime($excuse['excuse_date'])) ?></span>
            <span class="moreIcon">></span>
          </div>
        </div>
      </a>
    <?php
    }
    ?>
  </div>
  <div class="actions">
    <a href="absenceNotices.php">Back</a>
  </div>
</div>

<?php
require $inc . 'footer.inc.php';
?>