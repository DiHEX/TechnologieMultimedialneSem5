<?php
session_start();
unset($_SESSION["zadanie9-logged-in"]);
session_destroy();

header("Location: /zadanie9");