<?php
session_start();
unset($_SESSION["userLogin"]);
unset($_SESSION["adminLogin"]);
header('Location: login.php');
exit;
?>