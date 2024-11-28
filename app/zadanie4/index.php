<?php declare(strict_types=1);  /* Ta linia musi być pierwsza */ 
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
{
	header('Location: ./zadanie.php');
	exit();
}
else{
	header('Location: ./bootstrap/mainPage.php');	
}
?>