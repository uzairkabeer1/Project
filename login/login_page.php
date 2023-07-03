<?php
session_start();
if (isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}
if(isset($_SESSION["error"])) {
echo ("
<div class='alert alert-success' role='alert'>
You are not logged in. Please login first.
</div>
");
unset($_SESSION['error']);
session_destroy();
}
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$isFromRegisterPage = strpos($referrer, 'register_page.php') !== false;

if ($isFromRegisterPage) {
    echo "<script>alert('Congratulations! You have registered.');</script>";
}
if (isset($_SESSION['logout_success'])) {
  echo ("
    <div class='alert alert-success' role='alert'>
      You have successfully logged out.
    </div>
  ");
  unset($_SESSION['logout_success']);
  session_destroy();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>User Login</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8 col-lg-6 m-auto py-5">
          <h2>Login</h2>
          <form action="login.php" method="POST" id="loginForm">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label"
                >Email address</label
              >
              <input
                type="email"
                name="email"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
              />
              <div id="emailHelp" class="form-text">
                We'll never share your email with anyone else.
              </div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label"
                >Password</label
              >
              <input
                type="password"
                name="password"
                class="form-control"
                id="exampleInputPassword1"
              />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          <span id="loginError" class="text-sm text-danger"></span>
          <br>
          <a href="../register/register_page.php" class="btn btn-primary mt-3">Register</a>
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
    <script>
 document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault(); 

            var form = this;
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            window.location.href = response.redirect;
                        } else {
                            document.getElementById('loginError').textContent = response.message;
                        }
                    } else {
                        console.log('Request failed. Status:', xhr.status);
                    }
                }
            };

            xhr.open(form.method, form.action, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send(formData);
        });
</script>
  </body>
</html>