<?php
require_once 'myFunctions.php';
// Для создания уникального имени файла 
$time = time();
$timef = $time + 2;

$text = $_POST['text'];
$textFile = $_FILES['docs'];

if (!($text == "")) {
	fileRecord($time, $text);
}

if (!($textFile['name']['0'] == "")) {
	fileRecord($timef, formatConversion($textFile['tmp_name']['0']));
}

 // Переходим на страницу index.php
header('Location: index.php');