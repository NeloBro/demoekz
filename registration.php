<?php
session_start();
require_once("conn.php");
if ($_SESSION['user']){
    header("Location: /");
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
            <div class="loginlabel"><h1>Регистрация</h1></div>
            <form class="inputs" action="signup.php" method="post">
            	<div>Логин&nbsp;<input type="text" style="width:570px" name="login"></div>
            	<div>Пароль&nbsp;<input type="text" style="width:550px" name="password"></div>
                <div>Подтвердите пароль&nbsp;<input type="text" name="password2"></div>
            	<input type="submit" style="background-color: #E21347; font-size: 25px; width: 250px; justify-self: center; color: white;" value="Зарегистрироватся">
            </form>
            <a href="login.php" class="ssilka">Войти</a>
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