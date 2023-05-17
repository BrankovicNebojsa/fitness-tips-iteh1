// This JS file is primarily for AJAX

let workouts = [];
const workoutsContainerElement = document.querySelector(".workouts-list");
const sortSelect = document.querySelector("#sort-select");
const filters = {
  name: document.querySelector("#filter-name"),
  exerciseTimeFrom: document.querySelector("#filter-exerciseTimeFrom"),
  exerciseTimeTo: document.querySelector("#filter-exerciseTimeTo"),
  difficultyLevelFrom: document.querySelector("#filter-difficultyLevelFrom"),
  difficultyLevelTo: document.querySelector("#filter-difficultyLevelTo"),
};

getWorkouts();

// Because my button is not part of any form, I am making AJAX POST request when button is clicked
$(document).ready(function () {
  $(".delete").click(function () {
    var el = this;

    var deleteid = $(this).data("id");

    // AJAX Request
    $.ajax({
      url: "./handlers/user_handlers/delete_user.php",
      type: "POST",
      data: { id: deleteid },
      success: function (response) {
        if (response == "Success") {
          alert("Profile has been deleted successfully!");
          location.href = "./login.php";
        } else {
          alert(response);
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert("Status: " + textStatus);
        alert("Error: " + errorThrown);
      },
    });
  });
});

// GET Request for Workouts for main page
function getWorkouts() {
  $.ajax({
    url: "./handlers/workout_handlers/get_workouts.php?getAll",
    type: "GET",
    success: function (response) {
      try {
        console.log(response);
        if (response != null) {
          response = JSON.parse(response); // because we are getting workouts in JSON file
          workouts = response;
        } else {
          workouts = [];
        }
        sortWorkouts();
      } catch (error) {
        console.log(`Error parsing response from server: ${error}`);
        return;
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      alert("Status: " + textStatus);
      alert("Error: " + errorThrown);
    },
  });
}

// function to show (render workout)
function renderWorkouts() {
  workoutsContainerElement.innerHTML = ""; // this will make my div empty
  if (workouts != null)
    workouts.forEach((workout) => createNewWorkoutElement(workout)); // for each workout it adds content in html
}

// function to add div element in workout-list for every workout
function createNewWorkoutElement(workout) {
  const elementTemplate = `<a href="single_workout.php?workout_id=${workout.id}" class="workout">
    <img src="./assets/workouts/${workout.image}" class="img workout-img" alt="" />
    <h5>${workout.name}</h5>
    <p>Time: ${workout.exercise_time} min | Difficulty: ${workout.difficulty_level}/10</p>
    </a>`;

    workoutsContainerElement.insertAdjacentHTML("beforeend", elementTemplate);
}

// AJAX call to add workout, in order not to refresh the whole page

$(document).ready(function (e) {
  $("#add_workout").on("submit", function (e) {
    e.preventDefault(); // prevent page from reload

    $.ajax({
      url: "./handlers/workout_handlers/add_workout.php",
      type: "POST",
      data: new FormData(this),
      processData: false,
      contentType: false,
      cache: false,
      success: function (response) {
        console.log(response);
        if (response == "Success") {
          alert("Workout has been added successfully!");
          getWorkouts();
        } else {
          alert("Problem adding workout, try again!");
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        alert("Status: " + textStatus);
        alert("Error: " + errorThrown);
      },
    });
  });
});

// functio to sort Workout based on choice

function sortWorkouts() {
  const sortingParam = sortSelect.value;
  const sortOrder = document.querySelector(
    'input[name="sortOrderRadio"]:checked'
  ).value;

  if (sortingParam == "exercise_time" || sortingParam == "difficulty_level") {
    workouts.sort((a, b) => {
      aValue = parseInt(a[sortingParam]);
      bValue = parseInt(b[sortingParam]);
      if (sortOrder == "asc") {
        return aValue < bValue ? -1 : 1;
      } else if (sortOrder == "desc") {
        return aValue > bValue ? -1 : 1;
      } else {
        return 0;
      }
    });
  } else {
    workouts.sort((a, b) => {
      aValue = a[sortingParam];
      bValue = b[sortingParam];
      if (sortOrder == "asc") {
        return aValue < bValue ? -1 : 1;
      } else if (sortOrder == "desc") {
        return aValue > bValue ? -1 : 1;
      } else {
        return 0;
      }
    });
  }
  renderWorkouts();
}

// AJAX for filtering workouts

function filterWorkouts() {
  var formData = new FormData();
  formData.append("name", filters.name.value);
  formData.append("exerciseTimeFrom", filters.exerciseTimeFrom.value);
  formData.append("exerciseTimeTo", filters.exerciseTimeTo.value);
  formData.append("difficultyLevelFrom", filters.difficultyLevelFrom.value);
  formData.append("difficultyLevelTo", filters.difficultyLevelTo.value);

  $.ajax({
    url: "./handlers/workout_handlers/get_workouts.php?filter",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      try {
        console.log(response);
        if (response != null) {
          response = JSON.parse(response); // because we are getting workouts in JSON file
          workouts = response;
        } else {
          workouts = [];
        }
        sortWorkouts();
      } catch (error) {
        console.log(`Error parsing response from server: ${error}`);
        return;
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      alert("Status: " + textStatus);
      alert("Error: " + errorThrown);
    },
  });
}
