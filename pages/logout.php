<?php
session_start();

unset($_SESSION["kaeru"]);
session_destroy();

header("Location: ../index.php");
exit;
?>