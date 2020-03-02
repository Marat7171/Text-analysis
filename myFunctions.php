<?php

// Преобразование по формату utf-8
function formatConversion($file_dir) {
	$t = file_get_contents($file_dir);
	$get  = mb_detect_encoding($t, array('utf-8', 'cp1251'));
	$textf = iconv($get,'UTF-8',$t);
	return $textf;
}

// Функция,которая принимает текст и возвращает массив(ключ=>слово, значение=>количество вхождений + всего слов) 
function analysis($randText) {
	$textLover = mb_strtolower($randText);
	$finishedText = str_replace(['!', '?', ':', ',', '.'], "", $textLover);	
	$arrayFT = explode(' ', $finishedText);
	$count = count($arrayFT);
	$array0 = [];
	foreach ($arrayFT as $word) {
		if (isset($array0[$word])) {
			$array0[$word]++;
		} else {
			$array0[$word] = 1;
		}
	}
	$array0['Всего слов'] = $count;
	return $array0;
}

// запись обработанного файла
function fileRecord($time0, $text0) {
	$file = fopen("result/{$time0}.csv", "w");
	foreach (analysis($text0) as $a => $b) {
		fwrite($file, "{$a}: {$b}" . PHP_EOL);
	}
	fclose($file);
}