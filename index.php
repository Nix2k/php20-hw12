<?php
	function clearInput($input) {
		return htmlspecialchars(strip_tags($input));
	}

	require_once './db-config.php';
	
	try {
    	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
	} catch (PDOException $e) {
    	echo 'Подключение не удалось: ' . $e->getMessage();
	}

	$sql = "SELECT * FROM books";

	if (isset($_GET['search'])) {
		foreach ($_GET as $key => $value) {
			$_GET[$key] = clearInput($value);
		}
		if (isset($_GET['name'])) {
			$sql = $sql . 'WHERE name=' . $_GET['name'];
		}
	}

	
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

<form action="index.php" method="GET">
	Название: <input type="text" name="name"><br>
	Автор: <input type="text" name="author"><br>
	ISBN: <input type="text" name="isbn"><br>
	<input type="submit" name="search" value="Поиск"><br>
</form>

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
	if ($data) {
		foreach ($data as $row) {
			echo "<tr><td>".$row['id']."</td><td>".$row['name']."</td><td>".$row['author']."</td><td>".$row['year']."</td><td>".$row['isbn']."</td><td>".$row['genre']."</td></tr>";
		}
	}
	else {
		echo "Нет результатов";
	}
?>
</table>

</body>
</html>