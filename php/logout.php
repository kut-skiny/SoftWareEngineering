<?php
session_start();

if (isset($_SESSION["id"])) {
    $errorMessage = "ログアウトしました。";
} else {
    $errorMessage = "セッションがタイムアウトしました。";
}
$_SESSION = array();

@session_destroy();

header('Location: ./login.php');

?>
