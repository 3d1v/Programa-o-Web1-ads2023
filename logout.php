<?php
if(!isset($_SESSION)){
    session_start();
}

$_SESSION['user'] = $sysuser;

header("Location: index.php");
?>