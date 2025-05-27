<?php
session_start();
unset($_SESSION["zadanie14-logged-in"]);
session_destroy();

header("Location: /zadanie14");