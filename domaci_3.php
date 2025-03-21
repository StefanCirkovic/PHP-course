<?php

    $headline = "Postani Programer";

    $navigation = ["Glavna", "O nama", "Kontakt"];

    $trenutna_godina = date("Y");

?>

<!DOCTYPE html>
<html lang="en">
<head>
   
    <title> <?= $headline ?></title>
</head>
<body>
    <h1> <?=  $headline ?> </h1>
    <nav> 
        <a href="https://www.php.net/"> <?= $navigation[0] ?></a>
        <a href="https://www.php.net/my.php"> <?= $navigation[1] ?></a>
        <a href="https://www.php.net/contact.php"> <?= $navigation[2] ?></a>
    </nav>

    <footer>
    <p>Copyright &copy; mojsajt <?= $trenutna_godina ?>  </p>

    </footer>
    
</body>
</html>