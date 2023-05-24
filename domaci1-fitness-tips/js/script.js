// U ovom JavaScript fajlu se koristi AJAX

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

// AJAX POST zahtev na klik dugmeta za brisanje korisnika
$(document).ready(function () {
  $(".delete").click(function () {
    var el = this;
    var deleteid = $(this).data("id");

    // AJAX POST zahtev
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

// GET zahtev za treninge koji se nalaze na index.php
function getWorkouts() {
  $.ajax({
    url: "./handlers/workout_handlers/get_workouts.php?getAll",
    type: "GET",
    success: function (response) {
      try {
        console.log(response);
        if (response != null) {
          response = JSON.parse(response); // moramo da parsiramo povratnu vrednost jer predstavlja JSON fajl
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

// funkcija koja sortira treninge u zavisnosti od izbora (postoje 3 izbora: exercise_time, difficulty_level i name)
function sortWorkouts() {
  const sortingParam = sortSelect.value;
  const sortOrder = document.querySelector(
    'input[name="sortOrderRadio"]:checked'
  ).value;

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
  showWorkouts();
}

// funkcija za prolaz kroz sve treninge
function showWorkouts() {
  workoutsContainerElement.innerHTML = ""; // prazan String koji cemo napuniti HTML kodom
  if (workouts != null)
    workouts.forEach((workout) => createWorkoutElement(workout)); 
}

// funkcija koja dodaje HTML kod za svaki trening koji smo izvukli iz baze podataka kroz workout_handlers/get_workouts.php
function createWorkoutElement(workout) {
  const elementTemplate = `<a href="single_workout.php?workout_id=${workout.id}" class="workout">
    <img src="./assets/workouts/${workout.image}" class="img workout-img" alt="" />
    <h5>${workout.name}</h5>
    <p>Time: ${workout.exercise_time} min | Difficulty: ${workout.difficulty_level}/10</p>
    </a>`;

    workoutsContainerElement.insertAdjacentHTML("beforeend", elementTemplate); //dodajemo ovaj element na kraj
}

// AJAX zahtev za dodavanje novog treninga kako ne bismo osvezili ekran
$(document).ready(function (e) {
  $("#add_workout").on("submit", function (e) {
    e.preventDefault(); // radimo prevenciju kako ne bi doslo do osvezivanja ekrana

    $.ajax({
      url: "./handlers/workout_handlers/add_workout.php",
      type: "POST",
      data: new FormData(this),
      processData: false,
      contentType: false,
      cache: false,   // ovo ce zabraniti kesiranje datog elementa u browseru
      success: function (response) {
        console.log(response);
        if (response == "Success") {
          alert("Workout has been added successfully!");
          getWorkouts();    // pokrecemo getWorkouts() funkciju kako bismo dodali trening koji je unet na glavnu stranicu
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

// AJAX zahtev za filterovanje treninga na glavnoj strani
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
          response = JSON.parse(response); // kao odgovor dobijamo JSON fajl koji treba deserijalizovati
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
