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

	$sql = "SELECT * FROM `books`";

	if (isset($_GET['search'])) {
		foreach ($_GET as $key => $value) {
			$_GET[$key] = clearInput($value);
		}
		$sql = $sql . ' WHERE 1=1';
		if ((isset($_GET['isbn']))&&($_GET['isbn']!='')) {
			$sql = $sql . " AND `isbn` like '%". $_GET['isbn']."%'";
		}
		if ((isset($_GET['name']))&&($_GET['name']!='')) {
			$sql = $sql . " AND `name` like '%". $_GET['name']."%'";
		}
		if ((isset($_GET['author']))&&($_GET['author']!='')) {
			$sql = $sql . " AND `author` like '%". $_GET['author']."%'";
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
	Название: <input type="text" name="name" <?php if (isset($_GET['name'])) echo ' value="'.$_GET['name'].'"';?> ><br>
	Автор: <input type="text" name="author" <?php if (isset($_GET['author'])) echo ' value="'.$_GET['author'].'"';?> ><br>
	ISBN: <input type="text" name="isbn" <?php if (isset($_GET['isbn'])) echo ' value="'.$_GET['isbn'].'"';?> ><br>
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