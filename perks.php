<?php

	/*ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);*/
	
	include "config.php";
	
	$query = "SELECT name FROM `name_perks`";
		
	$result = mysqli_query($link, $query);
	$perk = [];
	while ($row = mysqli_fetch_assoc($result)) {		
		$perk[] = $row["name"];
	}
	
	
	$query = "SELECT * FROM `serv18_perks`";
	$result = mysqli_query($link, $query);
	
	$stat = [];
	$sum = 0;
	while ($row = mysqli_fetch_assoc($result)) {
		$res = str_split($row["pidlist"]);
		foreach($res as $i => $e) {
			if($e > 0) {
				if(!array_key_exists($i,$stat))
					$stat[$i] = 1;
				else
					$stat[$i]++;
			}
		}		
		$sum++;
	}
	
	$content = '<tr><td class="th" colspan="2"></a><div class="title">Трейты</div></td></tr>';
	$content .= '<tbody>';
	$class = 'trait';
	foreach($perk as $i => $e) {
		if(array_key_exists($i,$stat))
			$pr = round($stat[$i] / $sum * 100, 2);
		else
			$pr = 0;
		$content .= "<tr class='$class'><td class='td'>$e</td><td class='td'>$pr %</td></tr>";
		if($i == 15) {
			$content .= '</tbody><tr><td class="th" colspan="2"></a><div class="title">Перки</div></td></tr><tbody>';
			$class = 'perk';
		}
	}
	$content .= '</tbody>';
	
	$content .= "<tr><td class='td'>Всего данных</td><td class='td'>$sum</td></tr>";
?>
	<!DOCTYPE html>
	<html>
		<head>
			<link href="https://fonts.googleapis.com/css?family=Orbitron:500" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
			<title>Статистика взятия перков</title>
			<link rel='stylesheet' href='style.css'>
		</head>
		<body>
			<div = class="container">
				<div class="block1">
					<table align='center' id='table' class='table'>
						<?=$content?>
					</table>
				</div>
			</div>
			<script>
			function sortGrid(cls) {
				// Составить массив из TR
				var rowsArray = document.querySelectorAll("." + cls);
				var tbody = rowsArray[0].parentNode;
				rowsArray = Array.from(rowsArray);
				// сортировать
				rowsArray.sort(function(a,b) {			
					var compA = a.cells[1].innerText.slice(0,-2);
					var compB = b.cells[1].innerText.slice(0,-2);
					return compB - compA;
				});
				// добавить результат в нужном порядке в TBODY
				// они автоматически будут убраны со старых мест и вставлены в правильном порядке
				for (var i = 0; i < rowsArray.length; i++)
					tbody.appendChild(rowsArray[i]);
			}
			sortGrid("trait");
			sortGrid("perk");
			</script>
		</body>
	</html>
<?
	mysqli_close($link);
	exit;
/*------------------------------------------------------------------*/
/*	ini_set('error_reporting', E_ALL); 
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1);
	
	include "config.php";
	
	$query = "SELECT id FROM `serv18_chars`";
	$result = mysqli_query($link, $query);
	$inputquery = "INSERT INTO `serv18_perks` (`id`, `pidlist`) VALUES \n";
	while ($row = mysqli_fetch_assoc($result)) {
		$listperk = '';
		for($n = 0; $n < 140; $n++) {
			$r = rand(0,3);
			$listperk .= $r;
		}
		$inputquery .= "(" . $row["id"] . ", '" . $listperk . "'),\n";
	}
	$inputquery = substr($inputquery, 0, -2);
	$inputquery .= ";\n";
	
	$result = mysqli_query($link, $inputquery);
	
	$errors = mysqli_error_list ($link);
	if(!count($errors)) {
		echo "Запрос выполнен без ошибок";
	} else {
		echo "<pre>";
		print_r($errors);
		echo $inputquery;
		echo "</pre>";	
	}
	mysqli_close($link);*/
	