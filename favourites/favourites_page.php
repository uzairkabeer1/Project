<?php
session_start();
// Check if user is logged in, otherwise redirect to login page
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
                <h1>Favourite Quotes</h1>
                <div class="table-responsive">
                    <table class="table table-hover py-3">
                        <thead>
                            <tr>
                                <th>Quote</th>
                                <th>Author</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $userId = getUserId();
                            $sql = "SELECT * FROM favorite_quotes WHERE user_id = '$userId'";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $quoteId = $row['id'];
                                $sql = "SELECT * FROM favorite_quotes WHERE id = '$quoteId'";
                                $quoteResult = mysqli_query($conn, $sql);
                                $quote = mysqli_fetch_assoc($quoteResult);
                            ?>
                                <tr>
                                    <td><?php echo $quote['quote'] ?></td>
                                    <td><?php echo $quote['author'] ?></td>
                                    <td class="" >
                                        <form action="favourites.php" method="post">
                                            <input type="hidden" name="action" value="removeFavorite">
                                            <input type="hidden" name="quoteId" value="<?php echo $quote['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                        <a href="edit_favourite_page.php?id=<?php echo $quote['id'] ?>" class="btn btn-sm btn-warning mt-2" >Edit</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>