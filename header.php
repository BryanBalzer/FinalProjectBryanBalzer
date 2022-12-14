<!DOCTYPE html>
<html lang="en">

<head>
  <title>Movie Rate</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Movie Rate</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php if (isset($_SESSION['admin'])) : ?>
            <li class="nav-item">
              <a class="nav-link" href="admin.php">Admin</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="movie.php">Movies</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="genre.php">Genres</a>
            </li>
          <?php endif ?>
          <?php if (!isset($_SESSION['loggedin'])) : ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="create.php">Create Review</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          <?php endif ?>  

        </ul>
        <form action="search.php" method="GET" class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" name='search' aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>