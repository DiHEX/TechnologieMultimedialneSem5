<?php
session_start();
unset($_SESSION["zadanie5-logged-in"]);
session_destroy();

header("Location: /zadanie5");
?>