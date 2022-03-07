<?php 
include_once 'setting.php';
$CONNECT = mysqli_connect(HOST, USER, PASS, DB); 
mysqli_query($CONNECT, "SET lc_time_names = 'ru_RU'");
mysqli_set_charset($CONNECT, "utf8");

function FormChars ($p1) {
return nl2br(htmlspecialchars(trim($p1), ENT_QUOTES), false);
}

?>
<!DOCTYPE html><html><head><meta charset="utf-8" />
<meta name="robots" content="all"/>
</head>
<body>

<?php
if ($_POST['enter']) {
$post = file_get_contents('https://jsonplaceholder.typicode.com/posts');
$posts=json_decode($post, true);

foreach($posts as $row_post => $field_post){
mysqli_query($CONNECT, "INSERT INTO `posts` VALUES ('".implode("','", $field_post)."')");
}

$comm = file_get_contents('https://jsonplaceholder.typicode.com/comments');
$comments=json_decode($comm, true);

foreach($comments as $row => $field){
mysqli_query($CONNECT, "INSERT INTO `comments` VALUES ('".implode("','", $field)."')");
}

$res_post = mysqli_query($CONNECT, "SELECT COUNT(*) FROM `posts`") or die("Ошибка запроса: ".mysqli_error());
$row_post = mysqli_fetch_row($res_post);
$posts = $row_post[0];

$res_comm = mysqli_query($CONNECT, "SELECT COUNT(*) FROM `comments`") or die("Ошибка запроса: ".mysqli_error());
$row_comm = mysqli_fetch_row($res_comm);
$comments = $row_comm[0];

echo 'Загружено '.$posts.' записей и '.$comments.' комментариев ';
}
echo '	<form method="POST" action="/download.php">
<p><input type="text" name="search" value="" required minlength="3"></p>
       <p><input type="submit" name="enter1" value="Найти"></p>
    </form>';


if ($_POST['enter1']) {
	$_POST['search'] = FormChars($_POST['search']);
	
$search = $_POST['search'];

$query = "SELECT `body`, `postId` FROM `comments` WHERE `body` LIKE '%".$search."%'";
$result= mysqli_query($CONNECT, $query)or die(mysqli_error());   
while($comments = mysqli_fetch_assoc($result)){  

$post = "SELECT `title`, `id` FROM `posts` WHERE `id` = $comments[postId]";
$res_post= mysqli_query($CONNECT, $post)or die(mysqli_error());   
while($posts = mysqli_fetch_assoc($res_post)){  



echo '<p>postId: '.$posts['id'].', Заголовок: '.$posts['title'].'</p>  <p>Комментарий: '.$comments['body'].'</p><hr></hr>';
}
}
}




?>
