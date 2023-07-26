<?php
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

function sanitizeInput($input)
{
    $sanitized = trim($input);
    $sanitized = stripslashes($sanitized);
    $sanitized = htmlspecialchars($sanitized);
    return $sanitized;
}

function getBaseUrl()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);
    $parentUrl = rtrim(dirname($protocol . "://" . $host . $path), '/');
    return $parentUrl;
}


function redirectTo($page)
{
    header("Location: $page");
    exit();
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function getUserId()
{
    return $_SESSION['user_id'];
}

function formatDate($date)
{
    return date('F j, Y', strtotime($date));
}

function getUser($id)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user;
}

function getQuote($id){
    global $conn;
    $sql = "SELECT * FROM favorite_quotes WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $quote = mysqli_fetch_assoc($result);
    return $quote;
}

function updateUser($id, $name, $email, $password)
{
    global $conn;
    $name = sanitizeInput($name);
    $email = sanitizeInput($email);
    $password = sanitizeInput($password);
    
    $existingUser = getUserByEmailOrUsername($email, $name);
    if ($existingUser && $existingUser['id'] != $id) {
        return false;
    }
    
    $stmt = mysqli_prepare($conn, "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $password, $id);

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}
function getUserByEmailOrUsername($email, $name)
{
    global $conn;
    $email = mysqli_real_escape_string($conn, $email);
    $name = mysqli_real_escape_string($conn, $name);
    $sql = "SELECT * FROM users WHERE email = '$email' OR name = '$name'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user;
}
?>
