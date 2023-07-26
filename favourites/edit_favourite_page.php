<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login/login.html");
    exit();
}

require_once "../common_functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favourites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />

</head>

<body>
    <?php require_once "../layout/navbar.php" ?>
    <?php
    if (isset($_SESSION['error'])) {
        echo ("
      <div class='alert alert-warning' role='alert'>
      Something went wrong
</div>
      ");
        unset($_SESSION['error']);
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 py-5">
                <h1>Edit Quote</h1>
                <div class="col-12 py-3">
                    <form action="favourites.php" method="post">
                        <input type="hidden" name="action" value="editFavorite">
                        <input type="hidden" name="quoteId" value="<?php echo $_GET['id'] ?>">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Quote</label>
                            <textarea class="form-control" placeholder="quote" id="floatingTextarea" name="quote" style="height: 100px"><?php echo getQuote($_GET['id'])['quote']; ?></textarea>
                            <div id="emailHelp" class="form-text">Upon update, this quote will be associated with you (you will be its author).</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https:
</body>

</html>