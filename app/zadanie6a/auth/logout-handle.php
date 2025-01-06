<?php
session_start();
unset($_SESSION["zadanie6a-logged-in"]);
session_destroy();

header("Location: /zadanie6a");