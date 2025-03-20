
<?php

    $headline = "Postani Programer";

    $navigation = ["Glavna", "O nama", "Kontakt"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
   
    <title> <?= $headline    ?></title>
</head>
<body>
    <h1> <?=  $headline ?> </h1>
    <nav> 
        <a> <?= $navigation[0] ?></a>
        <a> <?= $navigation[1] ?></a>
        <a> <?= $navigation[2] ?></a>
    </nav>
    
</body>
</html>