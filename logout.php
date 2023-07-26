<?php
session_start();
session_destroy();
session_start();
$_SESSION['logout_success'] = "HI";
header("Location: /login/login_page.php");
exit();