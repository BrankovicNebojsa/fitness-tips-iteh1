<?php

require 'models/User.php';
require 'db_connection.php';

session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}

if (isset($_GET['message'])) {
  $message = $_GET['message'];
  echo "<script>alert($message)</script>";
}

$user = unserialize($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FitnessTips</title>
  <!-- favicon -->
  <link rel="shortcut icon" href="./assets/favicon.jpg" type="image/x-icon" />
  <!-- normalize -->
  <link rel="stylesheet" href="./css/normalize.css" />
  <!-- font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
  <!-- index css -->
  <link rel="stylesheet" href="./css/index.css" />
</head>

<body>
  <!-- nav-->
  <nav class="navbar">
    <div class="nav-center">
      <!-- header -->
      <div class="nav-header">
        <a href="index.php" class="nav-logo">
          <img src="./assets/logo.png" alt="simply workouts" />
        </a>
        <button type="button" class="btn nav-btn">
          <i class="fas fa-align-justify"></i>
        </button>
      </div>
      <!-- links -->
      <div class="nav-links">
        <a href="index.php" class="nav-link">Home</a>
        <a href="#" class="nav-link" onclick="popAddNewWorkoutModal(true)">Add workout</a>
        <a href="#" class="nav-link" onclick="popEditProfileDataModal(true)">Edit profile</a>
        <a href="#" class="nav-link" onclick="popDeleteProfileModal(true)">Delete profile</a>

        <div class="nav-link logout-link">
          <a href="logout.php" class="btn">Log out</a>
        </div>
      </div>
    </div>
  </nav>
  <!-- end of nav-->

  <!-- main -->
  <main class="page">
    <!-- header -->
    <header class="hero">
      <div class="hero-container">
        <div class="hero-text">
          <h1>Fitness Tips</h1>
          <h4>Hard work beats talent when talent fails to work hard.</h4>
        </div>
      </div>
    </header>
    <!-- end of header -->
    <section class="workouts-container">
      <!-- tag container -->
      <div class="search-sort-container">
        <h4>Workouts</h4>
        <div class="search-sort-list">
          <!-- sorting part -->
          <label for="">Sort by:</label>
          <select id="sort-select" class="form-select form-select-sm" aria-label=".form-select-sm example" onchange="sortWorkouts()">
            <option value="name" selected>Name</option>
            <option value="exercise_time">Exercise time</option>
            <option value="difficulty_level">Difficulty level</option>
          </select>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="sortOrderRadio" id="sortOrderRadio1" value="asc" checked onchange="sortWorkouts()" />
            <label class="form-check-label" for="sortOrderRadio1">
              Ascending
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="sortOrderRadio" id="sortOrderRadio2" value="desc" onchange="sortWorkouts()" />
            <label class="form-check-label" for="sortOrderRadio2">
              Descending
            </label>
          </div>
          <br /><br />
          <!-- searching part-->
          <div class="first-row">
            <div>
              <label for="">Name:</label>
              <input id="filter-name" type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search" />
            </div>
            <div class="exerciseTime-div">
              <div>
                <label for="">Exercise time from: </label>
                <input id="filter-exerciseTimeFrom" type="number" min=0 class="form-control form-control-dark" placeholder="Search..." aria-label="Search" />
              </div>
              <div>
                <label for="">Exercise time to:</label>
                <input id="filter-exerciseTimeTo" type="number" min=0 class="form-control form-control-dark" placeholder="Search..." aria-label="Search" />
              </div>
            </div>
            <div class="year-div">
              <div>
                <label for="">Difficulty level from (1-10):</label>
                <input id="filter-difficultyLevelFrom" type="number" min=0 class="form-control form-control-dark" placeholder="Search..." aria-label="Search" />
              </div>
              <div>
                <label for="">Difficulty level to (1-10):</label>
                <input id="filter-difficultyLevelTo" type="number" min=0 class="form-control form-control-dark" placeholder="Search..." aria-label="Search" />
              </div>
            </div>
            <hr />
            <button type="button" class="search-icon btn btn-success" onclick="filterWorkouts()">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
      <!-- end of tag container -->

      <!-- workouts list -->
      <div class="workouts-list">
        <!-- single workout -->

        <!-- end of single workout -->
      </div>
      <!-- end of workouts list -->
    </section>
  </main>
  <!-- end of main -->

  <!-- footer -->
  <footer class="page-footer">
    <p>
      &copy; <span id="date"></span>
      <span class="footer-logo">FitnessTips</span>
      built by
      <a href="https://github.com/BrankovicNebojsa">Nebojsa Brankovic</a>
    </p>
  </footer>

  <!-- modal for creating workout -->
  <div id="addNewWorkoutModal">
    <div class="addNewWorkoutTitle">Describe your workout:</div>
    <form id="add_workout" method="POST" action="" enctype="multipart/form-data">
      <!-- multipart/form-data is needed when we use type="file"-->

      <input type="name" name="name" id="name" placeholder="Workout name" required />
      <input type="number" min=1 name="exercise_time" id="exercise_time" placeholder="Exercise time in minutes" required />
      <input type="number" min=1 name="difficulty_level" id="difficulty_level" placeholder="Difficulty level out of 10" required />
      <input type="text" name="exercise_1" id="exercise_1" placeholder="Exercise 1" required />
      <input type="text" name="exercise_2" id="exercise_2" placeholder="Exercise 2" required />
      <input type="text" name="exercise_3" id="exercise_3" placeholder="Exercise 3" required />
      <textarea name="description" id="description" cols="30" rows="10" placeholder="Description"></textarea>
      <div class="files-div">
        <label for="files" class="btn">Insert image</label>
        <input type="file" id="files" name="image" accept=".img, .jpeg, .jpg, .png, .jfif" value="Insert image" required style="visibility: hidden" />
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <button type="button" class="btn btn-danger close-modal-btn" onclick="closeModals()">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
        <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"></path>
      </svg>
    </button>
  </div>
  <!-- modal for creating workout -->

  <!-- modal for deleting account -->
  <div id="deleteProfileModal">
    <div class="question">
      Are you sure you want to delete your profile?
      <br />
      All of your workouts will be deleted!
    </div>
    <div class="buttons">
      <button type="button" class="btn btn-danger delete" data-id="<?php echo $user->getId(); ?>" onclick="popDeleteProfileModal(false)">
        Delete
      </button>
      <button type="button" class="btn btn-dark" onclick="popDeleteProfileModal(false)">
        Cancel
      </button>
    </div>
  </div>
  <!-- end of modal for deleting account -->

  <!-- edit profile data modal -->
  <div id="editProfileDataModal">
    <div class="editProfileDataModal">
      <strong>Change your profile data:</strong>
    </div>
    <form method="POST" action="handlers/user_handlers/edit_user.php">
      <label for="username">Username: </label>
      <input type="text" name="username" id="username" value="<?php echo $user->getUsername(); ?>" />

      <label for="email">Email: </label>
      <input type="email" name="email" id="email" value="<?php echo $user->getEmail() ?>" />
      <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <hr />
    <div class="editProfileDataModal"><strong>Change password: </strong></div>
    <form method="POST" action="handlers/user_handlers/edit_user.php">
      <label for="old-password">Old password: </label>
      <input type="password" name="old-password" id="old-password" />

      <label for="new-password">New password: </label>
      <input type="password" name="new-password" id="new-password" />
      <button type="submit" class="btn btn-primary">Change password</button>
    </form>
    <button type="button" class="btn btn-danger close-modal-btn" onclick="popEditProfileDataModal(false)">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
        <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"></path>
      </svg>
    </button>
  </div>
  <!-- end of edit profile data modal -->

  <div id="background-overlay" onclick="closeModals()"></div>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script src="./js/app.js"></script>
  <script src="./js/script.js"></script>
</body>

</html>