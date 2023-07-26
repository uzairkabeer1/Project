<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login/login.php");
    exit();
}

require_once "../common_functions.php";


// Get the filter and sort values from the URL parameters
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'user'; // Set the default filter to show user's quotes only
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'quote';

// Define the filter condition for the SQL query
$filterCondition = '';
$userId = $_SESSION["user_id"]; // Assuming the user ID is stored in the session variable
$userName = getUserNameById($userId); 

if ($filter === 'user') {
    $filterCondition = "WHERE user_id = '$userId' AND author = (SELECT author FROM favorite_quotes WHERE user_id = '$userId' LIMIT 1)";
} elseif ($filter === 'api') {
    $filterCondition = "WHERE user_id = '$userId' AND author <> '$userName' AND author NOT IN (SELECT DISTINCT author FROM favorite_quotes WHERE user_id = '$userId')";
} elseif ($filter === 'all') {
    $filterCondition = "WHERE user_id = '$userId'";
}

// Define the sort column for the SQL query
$sortColumn = ($sort === 'author') ? 'author' : 'quote';

// Build the SQL query with the filter and sort conditions
$sql = "SELECT * FROM favorite_quotes $filterCondition ORDER BY $sortColumn";

// Execute the SQL query and fetch the results
$result = mysqli_query($conn, $sql);
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
                <form action="favourites_page.php" method="get" class="mb-3">
                    <label for="filter">Filter by:</label>
                    <select name="filter" id="filter">
                        <option value="user" <?php if ($filter === 'user') echo 'selected'; ?>>User Quotes</option>
                        <option value="other" <?php if ($filter === 'other') echo 'selected'; ?>>API Quotes</option>
                        <option value="all" <?php if ($filter === 'all') echo 'selected'; ?>>All Quotes</option>
                    </select>

                    <label for="sort">Sort by:</label>
                    <select name="sort" id="sort">
                        <option value="quote" <?php if ($sort === 'quote') echo 'selected'; ?>>Quote</option>
                        <option value="author" <?php if ($sort === 'author') echo 'selected'; ?>>Author</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </form>
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
                            while ($row = mysqli_fetch_assoc($result)) {
                                $quoteId = $row['id'];
                                $sql = "SELECT * FROM favorite_quotes WHERE id = '$quoteId'";
                                $quoteResult = mysqli_query($conn, $sql);
                                $quote = mysqli_fetch_assoc($quoteResult);
                            ?>
                                <tr>
                                    <td><?php echo $quote['quote'] ?></td>
                                    <td><?php echo $quote['author'] ?></td>
                                    <td class="">
                                        <form action="favourites.php" method="post">
                                            <input type="hidden" name="action" value="removeFavorite">
                                            <input type="hidden" name="quoteId" value="<?php echo $quote['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                        <a href="edit_favourite_page.php?id=<?php echo $quote['id'] ?>" class="btn btn-sm btn-warning mt-2">Edit</a>
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