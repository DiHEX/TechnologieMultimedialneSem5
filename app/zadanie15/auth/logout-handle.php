<?php
session_start();
unset($_SESSION["crm-logged-in"]);
session_destroy();

header("Location: /zadanie15");