<?php

require 'models/Workout.php';
require 'db_connection.php';

session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}

if (!isset($_GET['workout_id'])) {
  header('Location: index.php');
  exit();
}

$workout = Workout::getById($conn, $_GET['workout_id']);

if (!$workout) {
  header('Location: index.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Single workout</title>
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

        <div class="nav-link logout-link">
          <a href="logout.php" class="btn">Log out</a>
        </div>
      </div>
    </div>
  </nav>
  <!-- end of nav-->

  <!-- main -->
  <main class="page">
    <section class="workout-hero">
      <img src="./assets/workouts/<?php echo $workout->imageName ?>" class="img workout-hero-img" alt="" />
      <article>
        <h2><?php echo $workout->name ?></h2>
        <p>
          <?php echo $workout->description ?>
        </p>
        <!-- workout icons -->
        <div class="workout-icons">
          <!-- single workout icon -->
          <article>
            <i class="fas fa-clock"></i>
            <h5>exercise time</h5>
            <p><?php echo $workout->exerciseTime ?> min</p>
          </article>
          <!-- single workout icon -->
          <article>
            <i class="fas fa-layer-group"></i>
            <h5>difficulty level</h5>
            <p><?php echo $workout->difficultyLevel ?>/10</p>
          </article>
        </div>
      </article>
    </section>
    <!-- workout content-->
    <section class="workout-content">
      <article>
        <h4>instructions</h4>
        <!-- single instruction -->
        <div class="single-instruction">
          <header>
            <p>Exercise 1</p>
            <div></div>
          </header>
          <p>
            <?php echo $workout->firstExercise ?>
          </p>
          <!-- single instruction -->
          <div class="single-instruction">
            <header>
              <p>Exercise 2</p>
              <div></div>
            </header>
            <p>
              <?php echo $workout->secondExercise ?>
            </p>
            <!-- single instruction -->
            <div class="single-instruction">
              <header>
                <p>Exercise 3</p>
                <div></div>
              </header>
              <p>
                <?php echo $workout->thirdExercise ?>
              </p>
            </div>
      </article>
      <article class="second-column"></article>
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

  <script src="./js/app.js"></script>
</body>

</html>