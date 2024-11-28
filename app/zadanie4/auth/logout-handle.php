<?php
session_start();
unset($_SESSION["zscan-logged-in"]);
session_destroy();

header("Location: /zadanie4");