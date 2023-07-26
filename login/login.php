<?php
session_start();
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["email"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $response = array(
            "success" => false,
            "message" => "Please fill out all fields"
        );
        echo json_encode($response);
        exit();
    }

    $sql = "SELECT id, email, is_admin FROM users WHERE email = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        if($row["is_admin"] == 0){
            $_SESSION["user_id"] = $row["id"];
            $response = array(
                "success" => true,
                "redirect" => "../index.php"
            );
        }
        else if($row["is_admin"] == 1){
            $response = array(
                "success" => true,
                "redirect" => "../admin/admin_page.php"
            );
            $_SESSION['admin_logged']=true;
        }
       
        echo json_encode($response);
        exit();
    } else {
        $response = array(
            "success" => false,
            "message" => "Invalid username or password"
        );
        echo json_encode($response);
        exit();
    }
}
mysqli_close($conn);
