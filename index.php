<?php
// Check if user is logged in, otherwise redirect to login page
session_start();
if (!isset($_SESSION["user_id"])) {
  $_SESSION["error"] = "Please Login First";
  header("Location: login/login_page.php");
  exit();
}

require_once "common_functions.php";
?>

<!DOCTYPE html>
<html>

<head>
  <title>Quotes By Martin Svoboda API Integration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>
  <?php require_once "layout/navbar.php" ?>
  <?php
  if (isset($_SESSION['error'])) {
    echo ("
      <div class='alert alert-warning' role='alert'>
Something went wrong. Please try again.
</div>
      ");
  }
  unset($_SESSION['error']);
  
  ?>
  <div class="container">
    <div class="greetings">
      <h1>
        Hi, <?php echo getUser(getUserId())['name'] ?>! 👋
      </h1>
      <p>
        Find your favorite quote!
      </p>
    </div>
    <button id="getQuoteBtn" class="btn btn-sm btn-primary">Get Quote</button>
    <div id="quoteContainer">
      <div id="favIcon" style="display: none">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="addIcon" class="bi bi-heart-fill" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
        </svg>
      </div>
      <div id="quoteText"></div>
      <div id="quoteAuthor"></div>
    </div>
    <form action="favourites/favourites.php" method="post">
      <input type="hidden" name="action" value="addFavorite">
      <input type="hidden" name="quote" value="" id="quoteInput">
      <input type="hidden" name="author" value="" id="authorInput">
      <input type="submit" style="visibility:hidden" id="favBtn">
    </form>

  </div>

  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>