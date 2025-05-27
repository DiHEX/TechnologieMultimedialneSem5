<?php

session_start();
unset($_SESSION['is-admin']);
session_destroy();
header("Location: /zadanie16/index.php");
