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
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($password)) {
        $response = array('success' => false, 'message' => 'Please fill out all fields');
        echo json_encode($response);
        exit();
    }

    $checkEmailSql = "SELECT id FROM users WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailSql);
    if (mysqli_num_rows($checkEmailResult) > 0) {
        $response = array('success' => false, 'message' => 'Email already taken');
        echo json_encode($response);
        exit();
    }

    $checkUsernameSql = "SELECT id FROM users WHERE name = '$name'";
    $checkUsernameResult = mysqli_query($conn, $checkUsernameSql);
    if (mysqli_num_rows($checkUsernameResult) > 0) {
        $response = array('success' => false, 'message' => 'Username already exists');
        echo json_encode($response);
        exit();
    }

    // Password validation
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $response = array(
            'success' => false,
            'message' => 'Password should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character'
        );
        echo json_encode($response);
        exit();
    }

 
    $insertSql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if (mysqli_query($conn, $insertSql)) {
        $response = array('success' => true);
        echo json_encode($response);
        exit();
    } else {
        $response = array('success' => false, 'message' => 'Registration failed');
        echo json_encode($response);
        exit();
    }
}

mysqli_close($conn);