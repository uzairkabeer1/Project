<?php
session_start();
require_once "../common_functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'addFavorite') {
    $quote = $_POST['quote'];
    $author = $_POST['author'];

    addFavorite($quote, $author);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'removeFavorite') {
    $quoteId = $_POST['quoteId'];
    removeFavorite($quoteId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'editFavorite') {
    
    $quoteId = $_POST['quoteId'];
    $quote = $_POST['quote'];

    
    editFavorite($quoteId, $quote);
}

function addFavorite($quote, $author)
{
    
    global $conn;

    
    $quote = sanitizeInput($quote);
    $author = sanitizeInput($author);
    $userId = getUserId();

    
    $sql = "INSERT INTO favorite_quotes (quote, author, user_id) VALUES (?, ?, ?)";

    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $quote, $author, $userId);

    try {
        
        if (mysqli_stmt_execute($stmt)) {
            
            header("Location: favourites_page.php");
        } else {
            
            $_SESSION['error'] = "Something went wrong";
            header("Location: ../index.php");
        }
    } catch (Exception $e) {
        $_SESSION['error'] =  $e->getMessage();
    }
}

function removeFavorite($quoteId)
{
    
    global $conn;

    
    $sql = "DELETE FROM favorite_quotes WHERE id = $quoteId";
    echo $sql;

    try {
        
        if (mysqli_query($conn, $sql)) {
            
            header("Location: favourites_page.php");
            exit();
        } else {
            
            $_SESSION['error'] = "Something went wrong";
            header("Location: favourites_page.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: favourites_page.php");
        exit();
    }
}

function editFavorite($quoteId, $quote)
{
    
    global $conn;

    
    $quote = sanitizeInput($quote);

    
    $author = getUser(getUserId())['name'];
    $sql = "UPDATE favorite_quotes SET quote = '$quote', author = '$author' WHERE id = $quoteId";

    try {
        
        if ($conn->query($sql) === TRUE) {
            
            header("Location: favourites_page.php");
            exit();
        } else {
            
            $_SESSION['error'] = "Something went wrong";
            header("Location: favourites_page.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: favourites_page.php");
        exit();
    }
}
