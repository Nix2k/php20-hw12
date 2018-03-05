<?php
	require_once './db-config.php';

	
	try {
    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
	} catch (PDOException $e) {
    	echo 'Подключение не удалось: ' . $e->getMessage();
	}

	$sql = "SELECT * FROM books";
	$data = $pdo->query($sql);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Книги</title>
</head>
<body>
<h1>Перечень книг</h1>

<table>
	<tr>
		<th>id</th>
		<th>Название</th>
		<th>Автор</th>
		<th>Год</th>
		<th>ISBN</th>
		<th>Жанр</th>
	</tr>
<?php
	foreach ($data as $row) {
		echo "<tr><td>".$row['id']."</td><td>".$row['name']."</td><td>".$row['author']."</td><td>".$row['year']."</td><td>".$row['isbn']."</td><td>".$row['genre']."</td></tr>";
	}
?>
</table>

</body>
</html>