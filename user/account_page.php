<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  $_SESSION["error"] = "Please Login First";
  header("Location: ../login/login_page.php");
  exit();
}

require_once "../common_functions.php";
$user = getUser(getUserId());
?>

<!DOCTYPE html>
<html>

<head>
  <title>Authentication</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="../styles.css" />
</head>

<body>
<?php require_once "../layout/navbar.php" ?>   
  <?php
  if (isset($_SESSION['error'])) {
    echo ("
      <div class='alert alert-warning' role='alert'>
       Username or Email Already Exist
      </div>
    ");
  }
  unset($_SESSION['error']);
  ?>
  <div class="container">
    <div class="greetings">
      <h1>
        Hi, <?php echo $user['name'] ?>! 👋
      </h1>
      <h2>Email Address: <?php echo $user['email'] ?></h2>
      <h2>Password: ********** <button id="editButton" class="btn btn-primary">Edit</button></h2>
      <div id="editForm" style="display: none;">
      <div class="container">
  <div class="row">
    <div class="col-12 col-md-8 col-lg-6 m-auto py-5">
      <h2>Edit User</h2>
      <form action="update_user.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo getUserId(); ?>">

        <div class="mb-3">
          <label for="name" class="form-label">Name:</label>
          <input type="text" name="name" value="<?php echo $user['name']; ?>" class="form-control">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address:</label>
          <input type="email" name="email" value="<?php echo $user['email']; ?>" class="form-control">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password" name="password" value="<?php echo $user['password']; ?>" class="form-control">
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
  </div>

  <script>
   
    document.getElementById("editButton").addEventListener("click", function() {
      document.getElementById("editForm").style.display = "block";
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>