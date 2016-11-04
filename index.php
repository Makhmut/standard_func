<!DOCTYPE html>
<html>
<head>
	<title>Домашнее задание на Стандартные функции</title>
	<style>
		code {
			background-color: #f2f2f2;
			padding: 3px 6px;
			border-radius: 3px;
		}
		table {
			margin: 0 auto;
		}
		table td {
			vertical-align: top;
		}
		p.anons_title {
			margin-left: 10px;
			margin-top: 12px;
		}
		p.anons_text {
			color: gray;
			font-size: 14px;
			margin-top: 5px;
			margin-bottom: -4px;
			margin-left: 10px;
		}
	</style>
</head>
<body>

<?php 

// Количество картинок в папке 'img'
$dir = opendir('img');
$count = 0;
while($file = readdir($dir)){
    if($file == is_dir('img' . $file)){
        continue;
    }
    $count++;
}

echo "<div style='width: 250px; margin: 0 auto;'>";

echo "<h3>Картинки в папке <code>/img/</code></h3>";

// Проверка существования картинок в папке 'img' и создания миниатюры для них
for($i = 1; $i < $count; $i++) {
	$image = 'img/'.$i.'.jpg';
	if(file_exists($image)) {
		echo "<p style='margin: 5px 0 0 35px'>".substr($image,4)." существует!<br /></p>";
		
		// создания миниатюры для них
		$pathToSave = "img/small/"; /*Папка для сохранения миниатюры */
		$thumbnail_width = 130;
		$thumbnail_height = 150;
		
		$what = getimagesize($image);
		$original_width = $what[0];
		$original_height = $what[1];
		
		if ($original_width > $original_height) {
			$new_width = $thumbnail_width;
			$new_height = intval($original_height * $new_width / $original_width);
		} else {
			$new_height = $thumbnail_height;
			$new_width = intval($original_width * $new_height / $original_height);
		}
		$dest_x = intval(($thumbnail_width - $new_width) / 2);
		$dest_y = intval(($thumbnail_height - $new_height) / 2);
		
		$file_name = basename($image);/* Имя картинки*/
		$ext   = pathinfo($file_name, PATHINFO_EXTENSION);

		/* Добавить слова _small для миниатюры */
		$file_name = basename($file_name, ".$ext") . '_small.' . $ext;

		switch(strtolower($what['mime']))
		{
			case 'image/png':
				$img = imagecreatefrompng($image);
				$new = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
				imagecopyresized($new, $img, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);        
			break;
			case 'image/jpeg':
				$img = imagecreatefromjpeg($image);
				$new = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
				imagecopyresized($new, $img, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
			break;
			case 'image/gif':
				$img = imagecreatefromgif($image);
				$new = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
				imagecopyresized($new, $img, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
			break;
			default: die();
		}

			imagejpeg($new,$pathToSave.$file_name);
			imagedestroy($new);
		}
	else echo substr($image,4)." не существует!";
}

echo "</div>";
echo "<br />";
	
?>

<table border='1' cellpadding='5' cellspacing='5'>
	<tr><th colspan=4>Информация о существующих файлах</th></tr>
	<tr>
		<td><b>Имя файла</b></td>
		<td><b>Размер файла</b></td>
		<td><b>Время последнего изменения</b></td>
		<td><b>Последнее обращения к файлу</b></td>
	</tr>

<?php

// Создаем массив с информации о файлах
$data = array();

// Информация о файла
for($i = 1; $i < $count; $i++) {
	$img_src = 'img/'.$i.'.jpg';
	$image = substr($img_src, 4);
	if(file_exists($img_src)) {
		echo "<tr>";
			echo "<td>".$image."</td>";
			echo "<td>".filesize($img_src)." bytes</td>";
			echo "<td>".( date( "d M Y H:i", filemtime( $img_src ) ) )."</td>";
			echo "<td>".( date( "d M Y H:i", fileatime( $img_src ) ) )."</td>";
		echo "</tr>";
		// записываем каждый элемент в конец массива
		array_push($data, array($image, filesize($img_src), ( date( "d M Y H:i", filemtime( $img_src ) ) ), ( date( "d M Y H:i", fileatime( $img_src ) ) )));
	}
	else echo $image." не существует!";
}

// И записываем массив в .csv файл
$f = fopen('file.csv','w');
foreach($data as $item) {
	fputcsv($f, $item);
}

fclose($f);

?>	

</table>

<?php

echo "<h3 align='center'>Превьюшки и ссылки на полный просмотр</h3>";

echo "<table width=800 border=0 cellpadding=0 cellspacing=0>";

for($i = 1; $i < $count; $i++) {
	$img_src = 'img/small/'.$i.'_small.jpg';
	$image = (substr($img_src, 10));
	if(file_exists($img_src)) {
		echo "<tr>";
			echo "<td align='center'><p><a href='single.php?name=$i.jpg'><img src=".$img_src."></a></p></td>";
			echo "<td><p class='anons_title'><a href='single.php?name=$i.jpg'>Просмотреть $i-ую картинку</a></p>";
			echo "<p class='anons_text'>Имя файла: $image</p>";
			echo "<p class='anons_text'>Размер файла: ".filesize($img_src)." байт</p>";
			echo "</td>";
		echo "</tr>";
	}
}

echo "</table>";


?>

</body>
</html>
