<?php
session_start();
unset($_SESSION["todo-logged-in"]);
session_destroy();

header("Location: /zadanie13");