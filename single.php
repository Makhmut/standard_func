<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Подробности</title>
		<style>
			table {
				margin: 0 auto;
			}
		</style>
    </head>
    <body>
<?php
	$type = isset($_GET['name']) ? $_GET['name'] : '';
	$path = dirname(__FILE__);
	$fh = fopen($path . DIRECTORY_SEPARATOR . 'file.csv', 'r');
	
	$data = array();
	
	while($row = fgetcsv($fh, 1000, ',')) {
		if($row[0] === $type)
			$data = $row;
	}
	if(count($data) > 0) {
	?>
		<table border="1">
			<tr>
				<th colspan="2">Подробная информация из .csv файла</th>
			</tr>
			<tr>
				<th colspan="2"><img width='600' height='400' src="<?php echo 'img/'.($data[0]); ?>" /></th>
			</tr>
			<tr>
				<td>Имя файла</td>
				<td><?php echo($data[0]); ?></td>
			</tr>
			<tr>
				<td>Размер в байтах</td>
				<td><?php echo($data[1]); ?></td>
			</tr>
			<tr>
				<td>Время последнего изменения</td>
				<td><?php echo($data[2]); ?></td>
			</tr>
			<tr>
				<td>Последнее обращения к файлу</td>
				<td><?php echo($data[3]); ?></td>
			</tr>
		</table>
		<br />
		<a href='index.php' style='display: block;text-align: center;'>Назад на главную</a>
	<?php
	} else {
	?>
			По данному запросу ничего не найдено<br />
			<br />
			<a href='index.php' style='display: block;text-align: center;'>Назад на главную</a>
	<?php
	}
	?>
</body>
</html>