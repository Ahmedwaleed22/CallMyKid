const addStudentForm = document.getElementById("addStudentForm");

const getFieldValue = (field_name) =>
  document.getElementById(`${field_name}_field`).value;

if (addStudentForm) {
  addStudentForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    const data = {
      first_name: getFieldValue("first_name"),
      last_name: getFieldValue("last_name"),
      mobile_number: getFieldValue("mobile_number"),
      email_address: getFieldValue("email_address"),
      age: getFieldValue("age"),
    };

    const addStudentRequest = await axios.post("api/addStudent.php", data);

    if (addStudentRequest.data.success) {
      document.getElementById("addStudentErrorMessage").style.display = "none";
      document.getElementById("addStudentSuccessMessage").style.display =
        "block";
      updateStudentsTableData();
    } else {
      document.getElementById("addStudentSuccessMessage").style.display =
        "none";
      document.getElementById("addStudentErrorMessage").style.display = "block";
    }
  });
}

const toggleAddStudentFormVisibillity = () => {
  const addStudentFormContainer = document.getElementById(
    "addStudentFormContainer"
  );

  if (addStudentFormContainer.style.display == "block") {
    addStudentFormContainer.style.display = "none";
  } else {
    addStudentFormContainer.style.display = "block";
  }
};

const hideAddStudentForm = () =>
  (document.getElementById("addStudentFormContainer").style.display = "none");

const updateStudentsTableData = async () => {
  const StudentsTableNewData = await axios.get(
    `api/searchStudents.php?keyword=`
  );
  const tableBody = document.getElementById("studentsTableBody");
  let matchingData = ``;

  StudentsTableNewData.data.forEach((student) => {
    matchingData =
      matchingData +
      `
      <tr>
        <td>${student.first_name}</td>
        <td>${student.last_name}</td>
        <td>${student.mobile_number}</td>
        <td>${student.email_address}</td>
        <td>${student.age}</td>
        <td><button onclick="deleteStudent(${student.ID})" class="deleteButton">إلغاء</button></td>
      </tr>
    `;

    tableBody.innerHTML = matchingData;
  });
};

const searchStudents = async (searchKeyword) => {
  const tableBody = document.getElementById("studentsTableBody");
  let matchingData = ``;

  const search = await axios.get(
    `api/searchStudents.php?keyword=${searchKeyword}`
  );

  if (search.data) {
    search.data.forEach((student) => {
      matchingData =
        matchingData +
        `
        <tr>
          <td><input type="checkbox" id="${student.ID_number}" class="deletedItems" data-id="${student.ID}" /></td>
          <td>${student.ID_number}</td>
          <td>${student.first_name}</td>
          <td>${student.last_name}</td>
          <td>${student.date_of_birth}</td>
          <td>${student.address}</td>
          <td>${student.email_address}</td>
          <td>${student.mobile_number}</td>
        </tr>
      `;

      tableBody.innerHTML = matchingData;
    });
  }
};

const deleteStudent = async (id) => {
  const data = {
    id: id,
  };

  const deleteStudentRequest = await axios.post("api/deleteStudent.php", data);

  if (deleteStudentRequest.data.success) {
    updateStudentsTableData();
  } else {
    alert("Error Occured While Deleting Student");
  }
};

const searchStudentsLogs = async (event) => {
  const student_id = event.target.value;
  const tableBody = document.getElementById("studentsLogTableBody");
  let matchingData = ``;

  const { data } = await axios.get(
    `api/searchStudentsLogs.php?student_id=${student_id}`
  );

  if (data) {
    data.forEach((student) => {
      matchingData =
        matchingData +
        `
        <tr>
          <td>${student.ID_number}</td>
          <td>${student.first_name} ${student.last_name}</td>
        </tr>
      `;

      tableBody.innerHTML = matchingData;
    });
  }
};
