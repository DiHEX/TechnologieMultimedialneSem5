<?php
session_start();
unset($_SESSION["zadanie6b-logged-in"]);
session_destroy();

header("Location: /zadanie6b");