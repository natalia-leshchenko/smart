<?php
include_once 'setting.php';
$CONNECT = mysqli_connect(HOST, USER, PASS, DB); 
$CONNECT->set_charset('utf8');
?>

<!DOCTYPE html><html><head><meta charset="utf-8" />
<meta name="robots" content="all"/>
</head>
<body>
<?php
if($CONNECT === false){
    die("ERROR: Ошибка подключения. " . mysqli_connect_error());
}

$sql_posts = "CREATE TABLE posts(
    userId INT NOT NULL,
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title TEXT NOT NULL,
    body TEXT NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

$sql_comments = "CREATE TABLE comments(
    postId INT NOT NULL,
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name TEXT NOT NULL,
	email VARCHAR(70) NOT NULL UNIQUE,
    body TEXT NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

if(mysqli_query($CONNECT, $sql_posts) and mysqli_query($CONNECT, $sql_comments)){
    echo 'Таблицы posts и comments успешно созданы.
	
	<form method="POST" action="/download.php">
       <p><input type="submit" name="enter" value="Скачать список постов и комментариев"></p>
    </form>
	';
} else{
    echo "ERROR: Не удалось выполнить $sql. " . mysqli_error($CONNECT);
}
?>

</body>
</html>
