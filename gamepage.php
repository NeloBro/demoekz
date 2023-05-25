<?php
session_start();
require_once("conn.php");

$id = $_GET['id'];

$sql = "SELECT * FROM `games` WHERE `id`=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
} else {
    echo "0 results";
}


$sqlrand = "SELECT * FROM `games`";
$resultrand = $conn->query($sqlrand);

$countsql = "SELECT count(*) FROM `games`";
$raw = $conn->query($countsql);
$res = $raw->fetch_row();
$count = $res[0];

$max = rand(1,$count);

$cc = 1;
$idrand;

foreach ($resultrand as $key){
    if ($cc == $max) {
        $idrand = $key['id'];
    }
    $cc++;
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Freed</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500&family=Roboto&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="container">
            <div class="header">
                <div><a href="index.php"><img src="logo.svg"></a></div>
                <div><a href="gamepage.php?id=<?php echo $idrand; ?>">Случайная игра</a></div>
                <div class="poisk">
                    <form action="index.php" method="post">
                        <input name="search">
                        <input type="submit" style="background-image: url(lupa.svg); background-repeat: no-repeat; background-color: #E21347;" value="">
                    </form>
                </div>
                <div><?php
                if (!$_SESSION['user']){
                    echo '<a href="login.php">Войти</a>';
                } elseif ($_SESSION['user']) {
                    echo '<a href="exit.php">Выйти</a>';
                }
                ?></div>
            </div>
            <div class="mainpage">
            	<div class="cover">
            		<div>
            			<img src="games/<?php echo $row['gameCover']; ?>">
            		</div>
            		<div style="justify-self: start;">
            			<h1><?php echo $row['gameName']; ?></h1>
            			<p>Дата выхода: <?php echo $row["date"]; ?></p>
						<p>Жанр: <?php echo $row['genre']; ?></p>
						<p>Разработчик: <?php echo $row['developer']; ?></p>
						<p>Издательство: <?php echo $row['publisher']; ?></p>
						<p>Язык интерфейса: <?php echo $row['interfaceLang']; ?><p>
						<p>Язык озвучки: <?php echo $row['voiceLang']; ?></p>
            		</div>
            	</div>
            	<div style="font-family: 'Roboto', sans-serif;">
            		<?php echo $row['description']; ?>
            	</div>
            	<div style="justify-self:center"><h2>Скриншоты</h2></div>
            	<div class="scrin">
            		<input type="checkbox" id="scrin1">
            		<label for="scrin1"><img src="games/<?php echo $row['scrin1']; ?>"></label>
            		<input type="checkbox" id="scrin2">
            		<label for="scrin2"><img src="games/<?php echo $row['scrin2']; ?>"></label>
            		<input type="checkbox" id="scrin3">
            		<label for="scrin3"><img src="games/<?php echo $row['scrin3']; ?>"></label>
            		<input type="checkbox" id="scrin4">
            		<label for="scrin4"><img src="games/<?php echo $row['scrin4']; ?>"></label>
            		<input type="checkbox" id="scrin5">
            		<label for="scrin5"><img src="games/<?php echo $row['scrin5']; ?>"></label>
            		<input type="checkbox" id="scrin6">
            		<label for="scrin6"><img src="games/<?php echo $row['scrin6']; ?>"></label>
            	</div>
            	<div style="justify-self:center; margin-top:20px;">
            		<?php echo $row['video']; ?>
            	</div>
            	<div class="download">
            		<a href="torrents/<?php echo $row['torrent']; ?>" download class="knopka">
            			<img src="download.svg">
            			<div>Скачать</div>
            		</a>
            	</div>
            	<div style="justify-self:center"><h2>Комментарии</h2></div>
            	<div class="cominput">
            		<form action="comm.php" method="post">
            			<input type="text" name="comment">
            			<input type="submit" style="background-color: #E21347; color: white; margin-left: 5px;">
            			<input type="hidden" name="gameName" value="<?php echo $row['gameName'];?>">
            			<input type="hidden" name="gameId" value="<?php echo $row['id'];?>">
            		</form>
            	</div>
            	<?php

            	$commGameName = $row['gameName'];

            	$sqlcomm = "SELECT * FROM `comments` WHERE `gameName`='$commGameName'";
				$resultcomm = $conn->query($sqlcomm);

				foreach ($resultcomm as $key) {
					echo '
            		<div class="comment">
            		<h2>'.$key["login"].'</h2>
            		<p>'.$key["comment"].'</p>
            		</div> 
            		';
				}

            	?>
            </div>
            <div class="footer">
                <div>
                    <p style="color: #B4B4B4;"><i>Контактная информация:</i></p>
                    <p>nelobro6@gmail.com</p>
                    <p>8-950-23-71-833</p>
                </div>
                <div>
                    <a href="index.php">Главная</a> <br><br>
                    <a href="gamepage.php?id=<?php echo $idrand; ?>">Случайная игра</a>
                </div>
            </div>
        </div>
</body>
</html>
<?php
$conn->close();
?>