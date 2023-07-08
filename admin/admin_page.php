<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
    echo ("<script>alert('You are not an admin and cannot access this page.')</script>");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Hi admin</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'admin.php';
                $users = getUsers();
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td>" . $user['name'] . "</td>";
                    echo "<td>" . $user['email'] . "</td>";
                    echo "<td><a href='#' class='btn btn-primary'>Edit</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
      <form action="../logout.php" method="POST">
        <button type="submit" name="logout" class="btn btn-primary float-end">Logout</button>
      </form>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>