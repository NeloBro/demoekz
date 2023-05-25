<?php
session_start();
require_once("conn.php");

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
            <?php
            if (!$_SESSION['user']) {
                echo '<div class="loginlabel"><h3>Только авторизованные пользователи могут оставлять комментарии</h3></div>';
            } else {
                $login = $_SESSION['user']['login'];
                $gameName = $_POST['gameName'];
                $comment = $_POST['comment'];
                $id = $_POST['gameId'];

                mysqli_query($conn, "INSERT INTO `comments` (`gameName`, `login`, `comment`) VALUES ('$gameName', '$login', '$comment')");

                header("Location: gamepage.php?id=$id");
            }
            ?>
            <div class="footer" style="bottom: 0; position: absolute;">
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