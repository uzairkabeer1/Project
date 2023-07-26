<?php
function getUsers() {

    try {
        $conn = mysqli_connect("localhost", "root", "", "api_crud_db");

        $sql = "SELECT * FROM users";
        $users = mysqli_query($conn, $sql);

        return $users;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>