<?php

//Пробуем создать директории 
if (!mkdir('fileTransferred', 0777, true) && !is_dir('fileTransferred')){
	echo '"fileTransferred" not created' . PHP_EOL;
}
if (!mkdir('result', 0777, true) && !is_dir('fileTransferred')){
	echo '"result" not created' . PHP_EOL;
}

// Для создания уникального имени файла 
	$time = time();
	$timef = $time + 2;

 $text = $_POST['text'];
 $textFile = $_FILES['docs'];

// создаём переданный файл в директории "fileTransferred" 
if (!empty($_FILES['docs']['name'])){
	$docs = $_FILES['docs'];
	foreach ($docs['tmp_name'] as $index => $tmpPath){
		if (!array_key_exists($index, $docs['name'])){
			continue;
		}
		move_uploaded_file($tmpPath, __DIR__ . DIRECTORY_SEPARATOR . 'fileTransferred' . DIRECTORY_SEPARATOR . $docs['name'][$index]);
	}
}

// Функция,которая принимает текст и возвращает массив(ключ=>слово, значение=>количество вхождений + всего слов) 
function analysis($randText){
$textLover = mb_strtolower($randText);
$finishedText = str_replace(['!', '?', ':', ',', '.'], "", $textLover);	
$arrayFT = explode(' ', $finishedText);
global $count; 
$count = count($arrayFT);
$array0 = [];
foreach ($arrayFT as $word){
	if (isset($array0[$word])){
		$array0[$word]++;
	} else {
		$array0[$word] = 1;
	}
}
return $array0;
}

// Путь по которому будет создан обработанный файл 
$dir = __DIR__ . DIRECTORY_SEPARATOR .'result' . DIRECTORY_SEPARATOR . $time . '.csv';
$dirf = __DIR__ . DIRECTORY_SEPARATOR .'result' . DIRECTORY_SEPARATOR . $timef . '.csv';

// Проверка на наличии текста из формы и запись результата в отдельный файл
if (!($text == "")){
	touch("{$time}.csv");
	$file = fopen("{$time}.csv", "w");
	foreach (analysis($text) as $a => $b){
	fwrite($file, "{$a}: {$b}" . PHP_EOL);
	}
	fwrite($file, "Всего слов: " . $count);

	fclose($file);
	copy("{$time}.csv", $dir);
	unlink("{$time}.csv");

}
// Преобразование по формату utf-8
$file_dir = __DIR__ . DIRECTORY_SEPARATOR . 'fileTransferred' . DIRECTORY_SEPARATOR . $docs['name']['0'];
$t = file_get_contents($file_dir);
$get  = mb_detect_encoding($t, array('utf-8', 'cp1251'));

// Проверка на наличии текста из переданного файла и запись результата в отдельный файл
if (isset($textFile)){
	touch("{$timef}.csv");
	$file = fopen("{$timef}.csv", "w");
	foreach (analysis(iconv($get,'UTF-8',$t)) as $a => $b){
	fwrite($file, "{$a}: {$b}" . PHP_EOL);
	}
	fwrite($file, "Всего слов: " . $count);
	fclose($file);
	copy("{$timef}.csv", $dirf);
	unlink("{$timef}.csv");
}

// Удаляем переданный файл. Если удаление не требуется => удалить следующую строчку
 unlink(__DIR__ . DIRECTORY_SEPARATOR . 'fileTransferred' . DIRECTORY_SEPARATOR . $docs['name']['0']);

 // Переходим на страницу index.php
 header('Location: index.php');