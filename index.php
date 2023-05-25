<?php
session_start();

require_once("conn.php");

if ($_POST['search']) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM `games` WHERE `gameName` LIKE '%$search%'";
}else{

    $sql = "SELECT * FROM `games`";
}

$result = $conn->query($sql);


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

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Freed</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500&family=Roboto&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Roboto&display=swap" rel="stylesheet">
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
            <div class="list">
                <?php 

                foreach($result as $row){
                    echo '
                        <div class="game">
                            <a href="gamepage.php?id='.$row["id"].'" class="gamea">
                                <p class="scrinsmotr">Скриншоты</p>
                                <img class="img-1" src="games/'.$row["gameCover"].'">
                                <div class="container_slider_css">
                                    <img class="photo_slider_css" src="games/'.$row["scrin1"].'" alt="">
                                    <img class="photo_slider_css" src="games/'.$row["scrin2"].'" alt="">
                                    <img class="photo_slider_css" src="games/'.$row["scrin3"].'" alt="">
                                    <img class="photo_slider_css" src="games/'.$row["scrin4"].'" alt="">
                                    <img class="photo_slider_css" src="games/'.$row["scrin5"].'" alt="">
                                    <img class="photo_slider_css" src="games/'.$row["scrin6"].'" alt="">
                                </div>
                                <p>'.$row["gameName"].'</p>
                            </a>
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