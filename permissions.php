<?php
session_start();

if (!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit;
}

$custom_styles = "permissions.css";

require "init.php";
require $inc . "header.inc.php";
require $inc . "navbar.inc.php";

$permissionsInstance = new Permissions($_SESSION['email']);
$permissions = $permissionsInstance->getPermissionsRequests('', Date("Y-m-d")) ?? [];
?>

<script>
  const updateData = async (keyword, date) => {
    const excusesContainer = document.getElementById("excusesContainer");
    let matchingData = ``;

    const {
      data
    } = await axios.get(`api/searchPermissions.php?keyword=${keyword}&date=${date}`);

    if (data) {
      data.forEach((permission) => {
        const date = new Date(permission.permission_ask_date);
        const daysjs = dayjs(date);

        matchingData += `
          <div class="excuseCard">
            <div class="avatar">
              <img src="<?php echo $svg ?>studentAvatar.svg" alt="Student Avatar">
              <h3 class="studentFirstName">${permission.first_name}</h3>
            </div>
            <div class="middleContainer">
              <h2 class="studentName">${permission.last_name}</h2>
              <div class="permissionActions">
                <a href="api/setPermission.php?permission_id=${permission.permission_id}&status=accepted"><img src="<?php echo $svg ?>approveSign.svg" alt="Approve Sign"></a>
                <a href="api/setPermission.php?permission_id=${permission.permission_id}&status=refused"><img src="<?php echo $svg ?>rejectSign.svg" alt="Reject Sign"></a>
              </div>
            </div>
            <div class="excuseInfo">
              <span class="date">${daysjs.format("DD/MM/YYYY")}</span>
              <span class="time">${daysjs.format("hh:mm a")}</span>
              <a href="permissionActions.php?permission_id=${permission.permission_id}"><span class="moreIcon">></span></a>
            </div>
          </div>
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
    foreach ($permissions as $permission) {
    ?>
      <div class="excuseCard">
        <div class="avatar">
          <img src="<?php echo $svg ?>studentAvatar.svg" alt="Student Avatar">
          <h3 class="studentFirstName"><?php echo $permission['first_name'] ?></h3>
        </div>
        <div class="middleContainer">
          <h2 class="studentName"><?php echo $permission['last_name'] ?></h2>
          <div class="permissionActions">
            <a href="api/setPermission.php?permission_id=<?php echo $permission['permission_id'] ?>&status=accepted"><img src="<?php echo $svg ?>approveSign.svg" alt="Approve Sign"></a>
            <a href="refusePermission.php?permission_id=<?php echo $permission['permission_id'] ?>"><img src="<?php echo $svg ?>rejectSign.svg" alt="Reject Sign"></a>
          </div>
        </div>
        <div class="excuseInfo">
          <span class="date"><?php echo date("d/m/Y", strtotime($permission['permission_ask_date'])) ?></span>
          <span class="time"><?php echo date("H:i a", strtotime($permission['permission_ask_date'])) ?></span>
          <a href="permissionActions.php?permission_id=<?php echo $permission['permission_id'] ?>"><span class="moreIcon">></span></a>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
  <div class="actions">
    <a href="messages.php">Back</a>
  </div>
</div>

<?php
require $inc . "footer.inc.php";
?>